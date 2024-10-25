@extends('layouts.template')

@section('content')
    <!-- Add Book Section -->
    <section class="add-book-section">
        <div class="container mt-5">
            <h2 class="text-center mb-4">Tambah Kategori Buku</h2>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <form action="{{ route('category.store') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="bookTitle" class="form-label">Nama Kategori Buku</label>
                                    <input type="text" name="name" class="form-control" id="name" placeholder="Masukkan nama kategori" required>
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