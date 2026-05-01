<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @stack('styles')

    <style>
        body {
            margin: 0;
            background-color: #f5f7fa;
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: #0a2342; /* navy blue */
            padding-top: 20px;
            box-shadow: 2px 0 8px rgba(0,0,0,0.15);
        }

        .sidebar .nav-link {
            padding: 12px 18px;
            border-radius: 8px;
            margin-bottom: 8px;
            transition: 0.3s ease;
        }

        .sidebar .nav-link:hover {
            background-color: rgba(255,255,255,0.12);
        }

        .sidebar .nav-link.active {
            background-color: #1d4ed8;
            font-weight: bold;
        }

        .main-content {
            margin-left: 250px;
            padding: 30px;
            min-height: 100vh;
        }
    </style>
</head>
<body>
    @include('layouts.navigation')

    <main class="main-content">
        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>