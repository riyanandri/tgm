<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Reader;
use App\Models\ReadingActivity;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReadingActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $reader = $request->input('reader_name');
        $book = $request->input('book');

        if ($request->has('date_range')) {
            $dates = explode(' - ', $request->input('date_range'));
            $startDate = Carbon::parse($dates[0])->startOfDay();
            $endDate = Carbon::parse($dates[1])->endOfDay();
        } else {
            $startDate = Carbon::now()->subMonths(1)->startOfDay();
            $endDate = Carbon::now()->endOfDay();
        }

        $activities = ReadingActivity::when($request->input('reader_name'), function ($query, $reader) {
            return $query->where('reader_id', $reader);
        })->when($request->input('book'), function ($query, $book) {
            return $query->where('book_id', $book);
        })->whereBetween('reading_date', [$startDate, $endDate])->latest()->paginate(10);


        return view('activities.index', [
            'activities' => $activities,
            'date_range' => $startDate->format('Y-m-d') . ' - ' . $endDate->format('Y-m-d'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $readers = Reader::orderBy('name', 'ASC')->get();
        $books = Book::orderBy('title', 'ASC')->get();

        return view('activities.create', compact('readers', 'books'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'reader_id' => ['required'],
            'book_id' => ['required'],
            'reading_date' => ['required']
        ]);

        $activity = ReadingActivity::create($request->only('reader_id', 'book_id', 'reading_date'));

        return redirect()->route('read.activity')->with('success', 'Data membaca berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validation to ensure correct format
        $request->validate([
            'reading_duration' => ['required', 'regex:/^\d{2}:\d{2}:\d{2}$/'],
        ]);

        $activity = ReadingActivity::findOrFail($id);
        $activity->reading_duration = $request->reading_duration;

        if ($activity->save()) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'message' => 'Gagal memperbarui durasi membaca.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $activity = ReadingActivity::findOrFail($id);

        $activity->delete();

        return redirect()->route('read.activity')->with('success', 'Data membaca berhasil dihapus');
    }
}
