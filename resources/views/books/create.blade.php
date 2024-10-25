@extends('layouts.template')

@section('content')
    <!-- Add Book Section -->
    <section class="add-book-section">
        <div class="container mt-5">
            <h2 class="text-center mb-4">Tambah Buku Baru</h2>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <form action="{{ route('book.store') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="category_id" class="form-label">Jenis Buku</label>
                                    <select class="form-select" id="category_id" name="category_id">
                                        <option selected disabled>Pilih jenis buku</option>
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="code" class="form-label">Kode Buku</label>
                                    <input type="text" class="form-control" id="code" name="code" placeholder="Masukkan kode buku">
                                </div>
                                <div class="mb-3">
                                    <label for="title" class="form-label">Nama Buku</label>
                                    <input type="text" class="form-control" id="title" name="title" placeholder="Masukkan nama buku">
                                </div>
                                <div class="mb-3">
                                    <label for="entry_date" class="form-label">Tanggal Masuk</label>
                                    <input type="date" class="form-control" id="entry_date" name="entry_date">
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Keterangan</label>
                                    <textarea class="form-control" id="description" name="description" rows="3" placeholder="Masukkan deskripsi buku"></textarea>
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