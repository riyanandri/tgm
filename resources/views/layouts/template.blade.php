<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Website</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #ffffff;
            padding: 20px 50px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .logo img {
            width: 50px;
        }

        nav ul {
            list-style: none;
            display: flex;
            gap: 20px;
            margin: 0;
            padding: 0;
        }

        nav a {
            text-decoration: none;
            color: black;
        }

        .intro {
            background-image: url(https://i.pinimg.com/originals/e9/ba/23/e9ba232b196c79fbba7cd1a4cb5d41bf.jpg);
            /* background-repeat: repeat; /* Atur pengulangan gambar (opsional) */
            /* background-size: cover; Atur ukuran gambar (opsional) */
            background-width: 20px;
            background-height: 80px;
            background-size:100px;
            padding: 20px 20px;
            text-align: center;
            font-size: 1.2em;
            color: white;
        }

        .options {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin: 80px 0;
        }

        .option {
            background-color: white;
            padding: 50px;
            border: 3px solid #ccc;
            border-radius: 5px;
            text-align: center;
            transition: transform 0.2s;
            text-decoration: none;
            color: black;
            font-size: 1em;
        }

        .option:hover {
            transform: scale(1.05);
        }

        .about {
            background-color: #e0e0e0;
            padding: 20px;
            text-align: center;
        }

        footer {
            text-align: center;
            padding: 10px;
            background-color: #ffffff;
            box-shadow: 0 -2px 4px rgba(0,0,0,0.1);
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
</head>
<body>
    @include('components.navbar')
    <main>
        @yield('content')
        @include('components.about')
    </main>
    @include('components.footer')

    <script src="{{ asset('js/jquery-3.2.1.slim.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
</body>
</html>
