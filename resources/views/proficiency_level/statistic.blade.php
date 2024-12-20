@extends('layouts.template')

@push('styles')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endpush

@section('content')
<section class="reader-list-section">
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>Tingkat Kegemaran Membaca</h3>
            <div class="align-items-end">
                <a href="{{ route('reading.statistic', array_merge(request()->all(), ['export' => 'excel'])) }}" class="text-decoration-none">
                    <button class="btn btn-icon btn-success">
                        <i class="bi bi-filetype-xls"></i> Ekspor Data TGM
                    </button>
                </a>
                <a href="#" data-bs-toggle="modal" data-bs-target="#tgmModal" class="text-decoration-none">
                    <button type="button" class="btn btn-icon btn-primary">
                        <i class="bi bi-file-earmark-bar-graph"></i> TGM Keseluruhan
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
                    <form action="{{ route('reading.statistic') }}" method="GET">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="reader_name" class="form-label">Nama Pembaca</label>
                                <select class="form-control select2" id="reader_name" name="reader_name">
                                    <option value=""></option>
                                    @foreach(\App\Models\Reader::orderBy('name', 'ASC')->get() as $reader)
                                        <option value="{{ $reader->id }}" {{ request('reader_name') == $reader->id ? 'selected' : '' }}>{{ $reader->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="date_range" class="form-label">Tanggal Membaca</label>
                                <input type="text" id="date_range" name="date_range" class="form-control" value="{{ isset($start_date) && isset($end_date) ? $start_date . ' - ' . $end_date : '' }}">
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
                    <th rowspan="2">No</th>
                    <th rowspan="2">Pembaca</th>
                    {{-- <th rowspan="2">Total Buku</th>
                    <th colspan="2">Buku Bacaan</th>
                    <th rowspan="2">Total Durasi</th> --}}
                    <th colspan="3">Perhitungan TGM</th>
                    <th rowspan="2">Nilai TGM</th>
                    {{-- <th rowspan="2">Aksi</th> --}}
                </tr>
                <tr>
                    {{-- <th>Judul</th>
                    <th>Durasi</th> --}}
                    <th>TDM</th>
                    <th>TFM</th>
                    <th>TJB</th>
                </tr>
                </thead>
                <tbody>
                    @forelse($activities as $index => $reader)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $reader['reader_name'] }}</td>
                            <td>{{ $reader['tdm'] }}%</td>
                            <td>{{ $reader['tfm'] }}%</td>
                            <td>{{ $reader['tjb'] }}%</td>
                            <td>{{ $reader['tgm'] }}%</td>
                            {{-- <td rowspan="{{ count($reader['books']) }}">{{ $reader['total_books'] }}</td> --}}

                            {{-- @if(count($reader['books']) > 0)
                                <td>{{ $reader['books'][0]['book_title'] }}</td>
                                <td>{{ number_format($reader['books'][0]['total_duration'], 2) }} jam</td>
                            @endif --}}

                            {{-- <td rowspan="{{ count($reader['books']) }}">{{ number_format($reader['total_duration_in_hours'], 2) }} jam</td>
                            <td rowspan="{{ count($reader['books']) }}" width="10%">

                            </td>
                        </tr>
                        @for($i = 1; $i < count($reader['books']); $i++)
                            <tr>
                                <td>{{ $reader['books'][$i]['book_title'] }}</td>
                                <td>{{ number_format($reader['books'][$i]['total_duration'], 2) }} jam</td>
                            </tr>
                        @endfor --}}
                    @empty
                        <tr>
                            <td colspan="7">Data Statistik Pembaca Tidak Ditemukan!</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $activities->appends(request()->query())->links('components.pagination') }}
        </div>
    </div>
</section>

<!-- Modal Structure -->
<div class="modal fade" id="tgmModal" tabindex="-1" aria-labelledby="tgmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tgmModalLabel">Ranking TGM Keseluruhan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered text-center">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Pembaca</th>
                            <th>Nilai TGM</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($activities as $index => $reader)
                            <tr>
                                <td>{{ ($activities->currentPage() - 1) * $activities->perPage() + $index + 1 }}</td>
                                <td>{{ $reader['reader_name'] }}</td>
                                <td>{{ $reader['tgm'] }}%</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">Tidak ada data pembaca!</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2" class="text-start"><strong>Nilai TGM Keseluruhan</strong></td>
                            <td><strong>{{ $averageTGM }}%</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/moment@2.29.1/min/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#date_range').daterangepicker({
            locale: {
                format: 'YYYY-MM-DD'
            },
            startDate: "{{ isset($start_date) ? $start_date : now()->subMonths(3)->format('Y-m-d') }}",
            endDate: "{{ isset($end_date) ? $end_date : now()->format('Y-m-d') }}"
        });
    });
</script>
@endpush
