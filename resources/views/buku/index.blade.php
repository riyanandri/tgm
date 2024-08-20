@extends('layouts.template')

@section('content')


<div class="container">
<div class="mb-3">
        <h2 class="text-center">Data Buku</h2>
    </div>
<a href="{{route('buku.create')}}" class="btn btn-primary mb-3">Tambah Buku</a>
<table class="table">
  <thead>
    <tr>
      <th scope="col">No</th>
      <th scope="col">Kode</th>
      <th scope="col">Judul</th>
      <th scope="col">Kategori</th>
      <th scope="col">Keterangan</th>
    </tr>
  </thead>
</table>
</div>
@endsection