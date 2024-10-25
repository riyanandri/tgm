<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Literasi Sosial</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Sweetalert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Custom CSS -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    @vite(['resources/js/app.js', 'resources/css/app.css'])
    @stack('styles')
</head>
<body>

@include('components.navbar')

@yield('content')

@include('components.about')

@include('components.footer')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap 5 JS and dependencies -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<!-- Sweetalert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    var collapseCard = document.getElementById('collapseCardExample');
    var toggleButton = document.getElementById('toggleButton');
    var toggleIcon = document.getElementById('toggleIcon');

    collapseCard.addEventListener('show.bs.collapse', function () {
        toggleIcon.classList.remove('bi-plus-lg');
        toggleIcon.classList.add('bi-dash-lg');
    });

    collapseCard.addEventListener('hide.bs.collapse', function () {
        toggleIcon.classList.remove('bi-dash-lg');
        toggleIcon.classList.add('bi-plus-lg');
    });
    $(document).ready(function() {
        $('.select2').select2({
            width: '100%'
        });
    });
</script>
@stack('scripts')
</body>
</html>
