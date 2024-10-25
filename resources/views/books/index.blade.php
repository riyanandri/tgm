@extends('layouts.template')

@section('content')
    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
            });
        </script>
    @endif
    <!-- Book List Section -->
    <section class="book-list-section">
        <div class="container mt-5">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3>Buku</h3>
                <div class="align-items-end">
                    <a href="{{ route('categories') }}" class="ms-2">
                        <button class="btn btn-icon btn-secondary">
                            <i class="bi bi-folder"></i> Kategori Buku
                        </button>
                    </a>
                    <a href="{{ route('book.add') }}">
                        <button class="btn btn-icon btn-primary">
                            <i class="bi bi-folder-plus"></i> Tambah Buku
                        </button>
                    </a>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Filter</span>
                    <button class="btn btn-sm btn-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCardExample" aria-expanded="false" aria-controls="collapseCardExample" id="toggleButton">
                        <i class="bi bi-plus-lg" id="toggleIcon"></i>
                    </button>
                </div>
                <div class="collapse" id="collapseCardExample">
                    <div class="card-body">
                        <form action="{{ route('books') }}" method="GET">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="category" class="form-label">Kategori</label>
                                    <select class="form-control select2" id="category" name="category">
                                        <option value=""></option>
                                        @foreach(\App\Models\Category::orderBy('name', 'ASC')->get() as $category)
                                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="code" class="form-label">Kode Buku</label>
                                    <input type="text" class="form-control" id="code" name="code" value="{{ request('code') }}">
                                </div>
                            </div>
                            @include('components.button-filter')
                        </form>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered text-center">
                    <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Kode Buku</th>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th width="20%">Tanggal Masuk</th>
                        <th width="15%">Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php
                        use Carbon\Carbon;
                    @endphp
                    @forelse($books as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->code }}</td>
                            <td>{{ $item->title }}</td>
                            <td>{{ $item->category->name }}</td>
                            <td>{{ Carbon::parse($item->entry_date)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('book.edit', $item->id) }}">
                                        <button class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil-fill"></i> Ubah
                                        </button>
                                    </a>
                                    <form id="delete-form-{{ $item->id }}" action="{{ route('book.destroy', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $item->id }})">
                                            <i class="bi bi-trash-fill"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">Data Buku Tidak Ditemukan!</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                {{ $books->links('components.pagination') }}
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "data yang telah dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>
@endpush