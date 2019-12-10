<!DOCTYPE html>
<html lang="es">
<head>
    <title>@yield('title')</title>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" type="image/png" href="{{ asset('/img/favicon_192x192.png') }}">
    <link rel="shortcut icon" sizes="192x192" href="{{ asset('/img/favicon_192x192.png') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/styles/app.css') }}">
    <style>
        html,
        body {
            height: 100%;
        }
        body {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center;
            padding-top: 40px;
            padding-bottom: 40px;
        }
    </style>
</head>
<body>
    <div class="splash-container">
        @yield('content')
    </div>
    <script src="{{ asset('dashboard/scripts/app.js') }}"></script>
</body>
</html>
