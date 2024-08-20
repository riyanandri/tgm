@extends('layouts.template')

@section('content')
<div class="container">
    <div class="mb-3">
        <h2 class="text-center">Tambah Data Buku</h2>
    </div>
    <div class="row">
        <form action="">
                <div class="form-floating mb-3">
                    <label for="floatingInput">Kode Buku</label>
                    <input type="text" class="form-control" id="floatingInput" placeholder="Masukan Kode Buku">
                </div>    
                <div class="form-floating mb-3">
                        <label for="floatingInput">Judul Buku</label>
                        <input type="text" class="form-control" id="floatingInput" placeholder="Masukan Judul Buku">
                    </div>
                <div class="form-floating mb-3">
                    <label for="floatingSelect">Kategori Buku</label>
                    <select class="form-control" id="floatingSelect" aria-label="Pilih Kategori buku">
                        <option selected>Pilih Kategori Buku</option>
                        <option value="1">Sastra</option>
                        <option value="2">Novel</option>
                        <option value="3">Umum</option>
                    </select>
                </div>
                <div class="form-floating mb-3">
                    <label for="floatingInput">Keterangan</label>
                    <input type="text" class="form-control" id="floatingInput" placeholder="Keterangan Buku">
                </div>
                <button class="btn btn-primary mb-3">Simpan</button>
        </form>
    </div>
</div>
@endsection
