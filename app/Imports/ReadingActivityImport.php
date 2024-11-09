<?php

namespace App\Imports;

use App\Models\Book;
use App\Models\Reader;
use App\Models\ReadingActivity;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ReadingActivityImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $reader = Reader::firstOrCreate(['name' => $row['reader_name']]);
        $book = Book::firstOrCreate(['title' => $row['book_title']]);

        if (is_numeric($row['reading_date'])) {
            $readingDate = Carbon::createFromDate(1900, 1, 1)->addDays($row['reading_date'] - 2)->format('Y-m-d');
        } else {
            $readingDate = Carbon::parse($row['reading_date'])->format('Y-m-d');
        }

        $readingTimeDecimal = $row['reading_duration'];
        $totalSeconds = $readingTimeDecimal * 24 * 60 * 60;

        $hours = floor($totalSeconds / 3600);
        $minutes = floor(($totalSeconds % 3600) / 60);
        $seconds = floor($totalSeconds % 60);

        $readingTime = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);

        if (empty($row['reader_name']) || empty($row['book_title']) || empty($row['reading_date']) || empty($row['reading_duration'])) {
            return null;
        }

        return new ReadingActivity([
            'reader_id' => $reader->id,
            'book_id' => $book->id,
            'reading_date' => $readingDate,
            'reading_duration' => $readingTime,
        ]);
    }
}
