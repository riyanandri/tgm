@extends('layouts.template')

@section('content')
<!-- <section class=" -->
<section class="intro">
            <img src="https://i.pinimg.com/564x/1c/e0/17/1ce01738ab0f190ee3932297b017353c.jpg" alt="intro">
            <p>Merangsang kepekaan hati dan pikiran dengan membaca serta saling bertukar gagasan dengan sesama</p>
        </section>
        <section class="options">
        <a href="{{ route('buku.index') }}" class="option">Data Buku</a>
        <a href="{{ route('pembaca.index') }}" class="option">Data Pembaca</a>
        <a href="{{ route('membaca.index') }}" class="option">TGM</a>
        </section>
@endsection