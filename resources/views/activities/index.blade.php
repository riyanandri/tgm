@extends('layouts.template')

@push('styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endpush

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
                <h3>Data Membaca</h3>
                <div class="align-items-end">
                    <a href="#" class="text-decoration-none">
                        <button class="btn btn-icon btn-success">
                            <i class="bi bi-file-earmark-spreadsheet"></i> Impor Data Membaca
                        </button>
                    </a>
                    <a href="{{ route('read.activity.add') }}" class="text-decoration-none">
                        <button class="btn btn-icon btn-primary">
                            <i class="bi bi-folder"></i> Tambah Data Membaca
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
                        <form action="{{ route('read.activity') }}" method="GET">
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
                                    <label for="book" class="form-label">Judul Buku</label>
                                    <select class="form-control select2" id="book" name="book">
                                        <option value=""></option>
                                        @foreach(\App\Models\Book::orderBy('title', 'ASC')->get() as $book)
                                            <option value="{{ $book->id }}" {{ request('book') == $book->id ? 'selected' : '' }}>{{ $book->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="date_range" class="form-label">Tanggal Membaca</label>
                                    <input type="text" id="date_range" name="date_range" class="form-control" value="{{ old('date_range', $date_range) }}">
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
                        <th>Nama Pembaca</th>
                        <th>Buku Bacaan</th>
                        <th>Tgl Membaca</th>
                        <th>Durasi</th>
                        <th width="15%">Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php
                        use Carbon\Carbon;
                    @endphp

                    @forelse($activities as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->reader->name }}</td>
                            <td>{{ $item->book->title }}</td>
                            <td>{{ Carbon::parse($item->reading_date)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</td>
                            <td id="duration-{{ $item->id }}">{{ $item->reading_duration }}</td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    @if ($item->reading_duration === '00:00:00')
                                        <button id="start-stop-btn-{{ $item->id }}" class="btn btn-primary btn-sm" onclick="startStopTimer({{ $item->id }})">
                                            <i class="bi bi-play-fill"></i> Mulai
                                        </button>
                                    @else
                                        <button id="start-stop-btn-{{ $item->id }}" class="btn btn-warning btn-sm" onclick="resetTimer({{ $item->id }})">
                                            <i class="bi bi-arrow-repeat"></i> Ulangi
                                        </button>
                                    @endif
                                        <form id="delete-form-{{ $item->id }}" action="{{ route('read.activity.destroy', $item->id) }}" method="POST">
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
                            <td colspan="6">Data Membaca Tidak Ditemukan!</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                {{ $activities->links('components.pagination') }}
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/moment@2.29.1/min/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script type="text/javascript">
    let timers = {};  // To store timers for each activity

    function startStopTimer(activityId) {
        const button = document.getElementById(`start-stop-btn-${activityId}`);
        const durationElement = document.getElementById(`duration-${activityId}`);

        // If the timer is running
        if (timers[activityId]) {
            // Stop the timer and get the recorded time
            clearInterval(timers[activityId].intervalId);

            const totalTime = timers[activityId].totalTime;  // Get the stored total time in seconds

            // Send the totalTime to the server and update the database
            updateReadingDuration(activityId, totalTime);

            // Change the button to "Ulangi" and set the button class to btn-warning
            button.textContent = 'Ulangi';
            button.classList.remove('btn-danger');
            button.classList.add('btn-warning');
            button.innerHTML = '<i class="bi bi-arrow-repeat"></i> Ulangi';

            // Update the button click event to reset the timer
            button.onclick = function() {
                resetTimer(activityId);
            };

            delete timers[activityId];  // Remove the timer from the list
        }
        // If the timer is not running, start it
        else {
            const startTime = Date.now();  // Get the current timestamp

            timers[activityId] = { intervalId: null, totalTime: 0 };  // Initialize the timer object

            // Start an interval that will update every second
            timers[activityId].intervalId = setInterval(() => {
                const currentTime = Date.now();  // Get current timestamp
                timers[activityId].totalTime = Math.floor((currentTime - startTime) / 1000);  // Total time in seconds

                // Convert totalTime (seconds) into hours, minutes, and seconds
                const hours = Math.floor(timers[activityId].totalTime / 3600);
                const minutes = Math.floor((timers[activityId].totalTime % 3600) / 60);
                const seconds = timers[activityId].totalTime % 60;

                // Update the visible duration element
                durationElement.textContent = `${padZero(hours)}:${padZero(minutes)}:${padZero(seconds)}`;
            }, 1000);

            // Change the button text to "Berhenti" and set the button class to btn-danger
            button.textContent = 'Berhenti';
            button.classList.remove('btn-primary');
            button.classList.add('btn-danger');
            button.innerHTML = '<i class="bi bi-stop-fill"></i> Berhenti';
        }
    }

    // Helper function to reset the timer
    function resetTimer(activityId) {
        const button = document.getElementById(`start-stop-btn-${activityId}`);
        const durationElement = document.getElementById(`duration-${activityId}`);

        // Reset the timer to 00:00:00
        durationElement.textContent = '00:00:00';

        // Change the button back to "Mulai" and set the button class to btn-primary
        button.textContent = 'Mulai';
        button.classList.remove('btn-warning');
        button.classList.add('btn-primary');
        button.innerHTML = '<i class="bi bi-play-fill"></i> Mulai';

        // Reset the button click event to start the timer again
        button.onclick = function() {
            startStopTimer(activityId);
        };
    }

    function padZero(num) {
        return num < 10 ? '0' + num : num;
    }

    function updateReadingDuration(activityId, totalTime) {
        const hours = Math.floor(totalTime / 3600);
        const minutes = Math.floor((totalTime % 3600) / 60);
        const seconds = totalTime % 60;

        // Ensure the time is always in the correct format HH:MM:SS
        const readingDuration = `${padZero(hours)}:${padZero(minutes)}:${padZero(seconds)}`;

        // Send the reading duration via AJAX to the backend
        fetch(`/read-activity/${activityId}/update-duration`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ reading_duration: readingDuration })  // Send the formatted time
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Durasi membaca berhasil diperbarui!');
            } else {
                alert('Terjadi kesalahan saat memperbarui durasi membaca.');
            }
        })
        .catch((error) => {
            console.error('Error:', error);
        });
    }

    $(document).ready(function() {
        $('#date_range').daterangepicker({
            locale: {
                format: 'YYYY-MM-DD'
            },
            startDate: "{{ explode(' - ', request('date_range', $date_range))[0] }}",
            endDate: "{{ explode(' - ', request('date_range', $date_range))[1] }}"
        });
    });


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
