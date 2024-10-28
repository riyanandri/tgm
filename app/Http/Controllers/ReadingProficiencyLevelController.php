<?php

namespace App\Http\Controllers;

use App\Exports\ReadingStatisticExport;
use App\Http\Controllers\Controller;
use App\Models\Reader;
use App\Models\ReadingActivity;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Maatwebsite\Excel\Facades\Excel;

class ReadingProficiencyLevelController extends Controller
{
    public function readingStatistics(Request $request)
    {
        $reader = $request->input('reader_name');
        if ($request->has('date_range')) {
            $dates = explode(' - ', $request->input('date_range'));
            $startDate = Carbon::parse($dates[0])->startOfDay();
            $endDate = Carbon::parse($dates[1])->endOfDay();
        } else {
            $startDate = Carbon::now()->subMonths(3)->startOfDay();
            $endDate = Carbon::now()->endOfDay();
        }

        // Preload readers and activities within date range
        $data = Reader::with(['activity' => function ($query) use ($startDate, $endDate) {
            $query->whereBetween('reading_date', [$startDate, $endDate])
                  ->select('book_id', 'reading_date', 'reading_duration', 'reader_id')
                  ->with('book');
        }])->when($reader, function ($query, $reader) {
            $query->where('id', $reader);
        })->get();

        $activities = $data->map(function ($reader) use ($startDate, $endDate) {
            $groupedByDate = $reader->activity->groupBy(function ($activity) {
                return Carbon::parse($activity->reading_date)->format('Y-m-d');
            });

            $groupedByWeek = $reader->activity->groupBy(function ($activity) {
                return Carbon::parse($activity->reading_date)->format('o-W');
            });

            $groupedByQuarter = $reader->activity->groupBy(function ($activity) {
                $date = Carbon::parse($activity->reading_date);
                return $date->format('Y') . '-' . ceil($date->month / 3);
            });

            // Cache each reader's statistics to avoid recalculating every time
            $averageTDM = Cache::remember("tdm_{$reader->id}_{$startDate}_{$endDate}", 60, function () use ($groupedByDate, $startDate, $endDate) {
                return number_format($this->calculateAverageTDM($groupedByDate, $startDate, $endDate), 2);
            });

            $averageTFM = Cache::remember("tfm_{$reader->id}_{$startDate}_{$endDate}", 60, function () use ($groupedByWeek, $startDate, $endDate) {
                return number_format($this->calculateAverageTFM($groupedByWeek, $startDate, $endDate), 2);
            });

            $averageTJB = Cache::remember("tjb_{$reader->id}_{$startDate}_{$endDate}", 60, function () use ($groupedByQuarter, $startDate, $endDate) {
                return number_format($this->calculateAverageTJB($groupedByQuarter, $startDate, $endDate), 2);
            });

            $totalDurationInSeconds = $reader->activity->sum(function ($activity) {
                return $this->convertToSeconds($activity->reading_duration);
            });

            $totalDurationInHours = number_format($totalDurationInSeconds / 3600, 2);

            $books = $reader->activity->map(function ($activity) {
                return [
                    'title' => $activity->book->title,
                    'duration' => number_format($this->convertToSeconds($activity->reading_duration) / 3600, 2),
                    'date' => $activity->reading_date
                ];
            });

            $totalBooksRead = $reader->activity->pluck('book_id')->unique()->count();

            $tgm = number_format(($averageTDM + $averageTFM + $averageTJB) / 3, 2);

            return [
                'reader_name' => $reader->name,
                'total_books_read' => $totalBooksRead,
                'books' => $books,
                'total_reading_duration' => $totalDurationInHours,
                'tdm' => $averageTDM,
                'tfm' => $averageTFM,
                'tjb' => $averageTJB,
                'tgm' => $tgm
            ];
        });

        $averageTGM = $activities->avg('tgm');

        $activities = $activities->sortByDesc('tgm');

        if ($request->has('export') && $request->input('export') === 'excel') {
            return Excel::download(new ReadingStatisticExport($activities, $averageTGM), 'Data Tingkat Kegemaran Membaca Periode ' . $startDate . ' - ' . $endDate . '.xls');
        }

        return view('proficiency_level.statistic', [
            'activities' => $activities,
            'averageTGM' => $averageTGM,
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => $endDate->format('Y-m-d')
        ]);
    }

    private function convertToSeconds($time)
    {
        sscanf($time, "%d:%d:%d", $hours, $minutes, $seconds);
        return isset($seconds)
            ? $hours * 3600 + $minutes * 60 + $seconds
            : $hours * 3600 + $minutes * 60;
    }

    private function calculateAverageTDM($groupedByDate, $startDate, $endDate)
    {
        // Preload all activities for the given date range and group by date
        $allActivitiesByDate = ReadingActivity::whereBetween('reading_date', [$startDate, $endDate])
            ->select(['reading_date', 'reading_duration'])
            ->get()
            ->groupBy(function ($activity) {
                return Carbon::parse($activity->reading_date)->format('Y-m-d');
            });

        $dailyTDM = $groupedByDate->map(function ($activitiesOnDate, $date) use ($allActivitiesByDate) {
            $totalDurationForReaderInSeconds = $activitiesOnDate->sum(function ($activity) {
                return $this->convertToSeconds($activity->reading_duration);
            });

            $maxDurationForAllReadersInSeconds = $allActivitiesByDate[$date]->sum(function ($activity) {
                return $this->convertToSeconds($activity->reading_duration);
            });

            return $maxDurationForAllReadersInSeconds > 0
                ? ($totalDurationForReaderInSeconds / $maxDurationForAllReadersInSeconds) * 100
                : 0;
        });

        return $dailyTDM->avg();
    }

    private function calculateAverageTFM($groupedByWeek, $startDate, $endDate)
    {
        $weeklyTFM = $groupedByWeek->map(function ($activitiesOnWeek, $week) use ($startDate, $endDate) {
            $totalBooksForReader = $activitiesOnWeek->pluck('book_id')->unique()->count();

            [$year, $weekNumber] = explode('-', $week);

            $startOfWeek = Carbon::now()->setISODate($year, $weekNumber)->startOfWeek();
            $endOfWeek = Carbon::now()->setISODate($year, $weekNumber)->endOfWeek();

            $maxBooksForAllReaders = ReadingActivity::whereBetween('reading_date', [$startOfWeek, $endOfWeek])
                ->whereBetween('reading_date', [$startDate, $endDate])
                ->pluck('book_id')->unique()->count();

            return $maxBooksForAllReaders > 0
                ? ($totalBooksForReader / $maxBooksForAllReaders) * 100
                : 0;
        });

        return $weeklyTFM->avg();
    }

    private function calculateAverageTJB($groupedByQuarter, $startDate, $endDate)
    {
        // Preload all activities for the given date range
        $allActivities = ReadingActivity::whereBetween('reading_date', [$startDate, $endDate])
            ->select('book_id', 'reading_date')
            ->get()
            ->groupBy(function ($activity) {
                $date = Carbon::parse($activity->reading_date);
                return $date->format('Y') . '-' . ceil($date->month / 3);
            });

        $quarterlyTJB = collect($groupedByQuarter)->map(function ($activitiesOnQuarter, $quarter) use ($allActivities) {
            $totalBooksForReader = $activitiesOnQuarter->pluck('book_id')->unique()->count();

            $maxBooksForAllReaders = $allActivities[$quarter]->pluck('book_id')->unique()->count();

            return $maxBooksForAllReaders > 0
                ? ($totalBooksForReader / $maxBooksForAllReaders) * 100
                : 0;
        });

        return $quarterlyTJB->avg();
    }
}
