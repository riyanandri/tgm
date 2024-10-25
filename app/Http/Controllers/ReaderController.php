<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Reader;
use Illuminate\Http\Request;

class ReaderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $name = $request->input('name');
        $gender = $request->input('gender');
        $agency = $request->input('agency');

        $readers = Reader::when($name, function ($query, $name) {
            return $query->where('name', 'like', "%{$name}%");
        })->when($gender, function ($query, $gender) {
            return $query->where('gender', $gender);
        })->when($agency, function ($query, $agency) {
            return $query->where('agency', 'like', "%{$agency}%");
        })->orderBy('created_at', 'DESC')->paginate(10);

        return view('readers.index', compact('readers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $gender = Reader::genderOptions();

        return view('readers.create', compact('gender'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'gender' => ['required', 'in:Laki-laki,Perempuan'],
            'phone' => ['required', 'unique:readers,phone'],
            'date_of_birth' => ['required', 'date'],
            'agency' => ['required', 'string']
        ]);

        $reader = Reader::create($request->all());

        return redirect()->route('readers')->with('success', 'Data pembaca berhasil ditambahkan');
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
