@extends('layouts.template')

@section('content')
<div class="container">
<div class="mb-3">
        <h2 class="text-center">Data Pembaca</h2>
    </div>
<a href="{{route('pembaca.create')}}" class="btn btn-primary mb-3">Tambah Pembaca</a>
<table class="table">
  <thead>
    <tr>
      <th scope="col">No</th>
      <th scope="col">Nama</th>
      <th scope="col">Alamat</th>
      <th scope="col">Tanggal Lahir</th>
      <th scope="col">Instansi</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">1</th>
      <td>Mark</td>
      <td>Otto</td>
      <td>@mdo</td>
    </tr>
  </tbody>
</table>
</div>
@endsection