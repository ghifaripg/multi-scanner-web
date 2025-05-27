<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Auth Page')</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('images/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon-16x16.png') }}">
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}">
</head>
<body class="auth-bg">
    @yield('content')

    {{-- script --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>
</html>
