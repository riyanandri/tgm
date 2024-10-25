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
                <h2>Data Membaca</h2>
                <div class="search-bar">
                    <label for="search">Search: </label>
                    <input type="text" id="search" class="form-control d-inline-block" style="width: 200px;">
                </div>
            </div>

            <div class="d-flex mb-3">
                <a href="{{ route('read.activity.add') }}">
                    <button class="btn btn-primary">Tambah Data Membaca</button>
                </a>
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
                                @if ($item->reading_duration === '00:00:00')
                                    <button id="start-stop-btn-{{ $item->id }}" class="btn btn-primary btn-sm" onclick="startStopTimer({{ $item->id }})">
                                        <i class="bi bi-play-fill"></i> Mulai
                                    </button>
                                @else
                                    <button id="start-stop-btn-{{ $item->id }}" class="btn btn-warning btn-sm" onclick="resetTimer({{ $item->id }})">
                                        <i class="bi bi-arrow-repeat"></i> Ulangi
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">Data Membaca Tidak Ditemukan!</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
<script>
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
</script>
@endpush
