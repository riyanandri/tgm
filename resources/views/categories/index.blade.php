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
                <h3>Kategori Buku</h3>
                <a href="{{ route('category.add') }}" class="text-decoration-none">
                    <button class="btn btn-icon btn-primary">
                        <i class="bi bi-folder-plus"></i> Tambah Kategori
                    </button>
                </a>
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
                        <form action="{{ route('categories') }}" method="GET">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="category" class="form-label">Nama Kategori</label>
                                    <select class="form-control select2" id="category" name="category">
                                        <option value=""></option>
                                        @foreach(\App\Models\Category::orderBy('name', 'ASC')->get() as $category)
                                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
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
                        <th width="7%">No</th>
                        <th>Nama Kategori</th>
                        <th width="15%">Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($categories as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->name }}</td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('category.edit', $item->id) }}">
                                        <button class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil-fill"></i> Ubah
                                        </button>
                                    </a>
                                    <form id="delete-form-{{ $item->id }}" action="{{ route('category.destroy', $item->id) }}" method="POST">
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
                            <td colspan="3">Data Kategori Buku Tidak Ditemukan!</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                {{ $categories->links('components.pagination') }}
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
