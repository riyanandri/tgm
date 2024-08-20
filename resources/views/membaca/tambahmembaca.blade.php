@extends('layouts.template')

@section('content')
<div class="container">
    <div class="mb-3">
        <h2 class="text-center">Tambah Data Membaca</h2>
    </div>
    @dd($membaca)
    <div class="row">
        <form action="">
                    <div class="form-floating mb-3">
                        <label for="floatingInput">Nama Pembaca</label>
                        <input type="text" class="form-control" id="floatingInput" placeholder="Masukan Nama">
                    </div>
                <div class="form-floating mb-3">
                    <label for="floatingInput">Judul Buku</label>
                    <input type="text" class="form-control" id="floatingInput" placeholder="Masukan Alamat">
                </div>
                <div class="form-floating mb-3">
                    <label for="floatingInput">Tanggal Membaca</label>
                    <input type="text" class="form-control" id="floatingInput" placeholder="Masukan Tanggal Lahir">
                </div>
                <div class="form-floating mb-3">
                    <label for="floatingInput">Durasi</label>
                    <input type="text" class="form-control" id="floatingInput" placeholder="Masukan Instansi">
                </div>
                <button class="btn btn-primary mb-3">Simpan</button>
        </form>
    </div>
</div>
@endsection
