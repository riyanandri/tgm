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
                <h3>Pembaca</h3>
                <a href="{{ route('reader.add') }}">
                    <button class="btn btn-icon btn-primary">
                        <i class="bi bi-folder-plus"></i> Tambah Pembaca
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
                        <form action="{{ route('readers') }}" method="GET">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="name" class="form-label">Nama</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ request('name') }}">
                                </div>
                                <div class="col-md-3">
                                    <label for="gender" class="form-label">Jenis Kelamin</label>
                                    <select class="form-control select2" id="gender" name="gender">
                                        <option value=""></option>
                                        <option value="{{ \App\Models\Reader::GENDER_MALE }}" {{ request('gender') == \App\Models\Reader::GENDER_MALE ? 'selected' : '' }}>LAKI - LAKI</option>
                                        <option value="{{ \App\Models\Reader::GENDER_FEMALE }}" {{ request('gender') == \App\Models\Reader::GENDER_FEMALE ? 'selected' : '' }}>PEREMPUAN</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="agency" class="form-label">Instansi</label>
                                    <input type="text" class="form-control" id="agency" name="agency" value="{{ request('agency') }}">
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
                        <th>Nama</th>
                        <th>Jenis Kelamin</th>
                        <th>Tanggal Lahir</th>
                        <th>No HP</th>
                        <th>Instansi</th>
                        <th width="15%">Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php
                        use Carbon\Carbon;
                    @endphp
                    @forelse($readers as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->gender }}</td>
                            <td>{{ Carbon::parse($item->date_of_birth)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</td>
                            <td>{{ $item->phone }}</td>
                            <td>{{ $item->agency }}</td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('reader.edit', $item->id) }}">
                                        <button class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil-fill"></i> Ubah
                                        </button>
                                    </a>
                                    <form id="delete-form-{{ $item->id }}" action="{{ route('reader.destroy', $item->id) }}" method="POST">
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
                            <td colspan="7">Data Pembaca Tidak Ditemukan!</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                {{ $readers->links('components.pagination') }}
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