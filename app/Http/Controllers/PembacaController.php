<?php

namespace App\Http\Controllers;

use App\Models\Pembaca;
use Illuminate\Http\Request;

class PembacaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pembaca.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pembaca.tambahpembaca');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Pembaca $pembaca)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pembaca $pembaca)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pembaca $pembaca)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pembaca $pembaca)
    {
        //
    }
}
