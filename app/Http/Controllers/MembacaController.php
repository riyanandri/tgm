<?php

namespace App\Http\Controllers;

use App\Models\Membaca;
use App\Http\Requests\StoreMembacaRequest;

class MembacaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('membaca.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $membaca = Membaca::all();

        return view('membaca.tambahmembaca', compact('membaca'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMembacaRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Membaca $membaca)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Membaca $membaca)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMembacaRequest $request, Membaca $membaca)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Membaca $membaca)
    {
        //
    }
}
