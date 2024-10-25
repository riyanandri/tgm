@extends('layouts.template')

@section('content')
    <!-- Add Book Section -->
    <section class="add-book-section">
        <div class="container mt-5">
            <h2 class="text-center mb-4">Tambah Data Membaca</h2>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <form action="{{ route('read.activity.store') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="reader_id" class="form-label">Pembaca</label>
                                    <select class="form-select" id="reader_id" name="reader_id">
                                        <option selected disabled>Pilih pembaca</option>
                                        @foreach($readers as $r)
                                            <option value="{{ $r->id }}">{{ $r->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="book_id" class="form-label">Buku Bacaan</label>
                                    <select class="form-select" id="book_id" name="book_id">
                                        <option selected disabled>Pilih buku</option>
                                        @foreach($books as $b)
                                            <option value="{{ $b->id }}">{{ $b->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="reading_date" class="form-label">Tanggal Membaca</label>
                                    <input type="date" class="form-control" id="reading_date" name="reading_date">
                                </div>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
