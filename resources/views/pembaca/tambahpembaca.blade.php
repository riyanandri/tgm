@extends('layouts.template')

@section('content')
<div class="container">
    <div class="mb-3">
        <h2 class="text-center">Tambah Data Pembaca</h2>
    </div>
    <div class="row">
        <form action="{{ route('pembaca.create') }}" method="POST" enctype="multipart/form-data">
                    <div class="form-floating mb-3">
                        <label for="floatingInput">Nama</label>
                        <input type="text" class="form-control" id="floatingInput" placeholder="Masukan Nama">
                    </div>
                <div class="form-floating mb-3">
                    <label for="floatingInput">Alamat</label>
                    <input type="text" class="form-control" id="floatingInput" placeholder="Masukan Alamat">
                </div>
                <div class="form-floating mb-3">
                    <label for="floatingInput">Tanggal Lahir</label>
                    <input type="text" class="form-control" id="floatingInput" placeholder="Masukan Tanggal Lahir">
                </div>
                <div class="form-floating mb-3">
                    <label for="floatingInput">Instansi</label>
                    <input type="text" class="form-control" id="floatingInput" placeholder="Masukan Instansi">
                </div>
                <div class="form-floating mb-3">
                    <label for="floatingInput">NO HP</label>
                    <input type="numeric" class="form-control" id="floatingInput" placeholder="Masukan No HP">
                </div>
                <button class="btn btn-primary mb-3" type='submit'>Simpan</button>
        </form>
    </div>
</div>
@endsection
