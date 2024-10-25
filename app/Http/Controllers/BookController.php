<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use function PHPUnit\TestFixture\func;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $category_id = $request->input('category');
        $code = $request->input('code');

        $books = Book::when($category_id, function ($query, $category_id) {
            return $query->where('category_id', $category_id);
        })->when($code, function ($query, $code) {
            return $query->where('code', 'like', "%{$code}%");
        })->orderBy('created_at', 'DESC')->paginate(10);

        return view('books.index', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::orderBy('name', 'ASC')->get();

        return view('books.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => ['required', 'string', 'unique:books,code'],
            'title' => ['required', 'string'],
            'entry_date' => ['required', 'date']
        ]);

        $book = Book::create($request->all());

        return redirect()->route('books')->with('success', 'Data buku berhasil ditambahkan');
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
        $book = Book::findOrFail($id);

        return view('books.edit', compact('book'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'code' => ['required', 'string'],
            'title' => ['required', 'string'],
            'entry_date' => ['required', 'date']
        ]);

        $book = Book::findOrFail($id);

        $book->update($request->all());

        return redirect()->route('books')->with('success', 'Data buku berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $book = Book::findOrFail($id);

        $book->delete();

        return redirect()->route('books')->with('success', 'Data buku berhasil dihapus');
    }
}
