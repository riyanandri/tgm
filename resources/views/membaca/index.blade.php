@extends('layouts.template')

@section('content')


<div class="container">
<div class="mb-3">
        <h2 class="text-center">Data TGM</h2>
    </div>
<a href="{{route('membaca.create')}}" class="btn btn-primary mb-3">Tambah Data Membaca</a>
<a href="{{route('membaca.create')}}" class="btn btn-primary mb-3">Tampilkan TGM</a>
<table class="table">
  <thead>
    <tr>
      <th scope="col">No</th>
      <th scope="col">Nama Pembaca</th>
      <th scope="col">TDM</th>
      <th scope="col">TFM</th>
      <th scope="col">TJB</th>
      <th scope="col">Tanggal</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">1</th>
      <td>Mark</td>
      <td>Otto</td>
      <td>@mdo</td>
      <td></td>
      <td></td>
      <td><button type="button" class="btn btn-primary">Stop</button></td>
      <td><button type="button" class="btn btn-primary">Edit</button></td>
    </tr>
  </tbody>
</table>
</div>
@endsection