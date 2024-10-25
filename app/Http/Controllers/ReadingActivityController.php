<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Reader;
use App\Models\ReadingActivity;
use Illuminate\Http\Request;

class ReadingActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $activities = ReadingActivity::latest()->get();

        return view('activities.index', compact('activities'));
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
        //
    }
}
