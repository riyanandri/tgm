@extends('layouts.template')

@section('content')
    <!-- Add Book Section -->
    <section class="add-book-section">
        <div class="container mt-5">
            <h2 class="text-center mb-4">Edit Pembaca</h2>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <form action="{{ route('reader.update', $reader->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ $reader->name }}" placeholder="Masukkan nama pembaca">
                                </div>
                                <div class="mb-3">
                                    <label for="gender" class="form-label">Jenis Kelamin</label>
                                    <select class="form-select" id="gender" name="gender">
                                        <option value="{{ \App\Models\Reader::GENDER_MALE }}" {{ $reader->gender == \App\Models\Reader::GENDER_MALE ? 'selected' : '' }}>LAKI - LAKI</option>
                                        <option value="{{ \App\Models\Reader::GENDER_FEMALE }}" {{ $reader->gender == \App\Models\Reader::GENDER_FEMALE ? 'selected' : '' }}>PEREMPUAN</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="date_of_birth" class="form-label">Tanggal Lahir</label>
                                    <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="{{ $reader->date_of_birth }}">
                                </div>
                                <div class="mb-3">
                                    <label for="phone" class="form-label">No HP</label>
                                    <input type="text" class="form-control" id="phone" name="phone" value="{{ $reader->phone }}" placeholder="Masukkan no hp">
                                </div>
                                <div class="mb-3">
                                    <label for="address" class="form-label">Alamat</label>
                                    <textarea class="form-control" id="address" name="address" rows="3" placeholder="Masukkan alamat">{{ $reader->address }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="agency" class="form-label">Instansi</label>
                                    <input type="text" class="form-control" id="agency" name="agency" value="{{ $reader->agency }}" placeholder="Masukkan instansi">
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