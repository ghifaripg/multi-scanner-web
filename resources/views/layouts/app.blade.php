<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>ThreatPeek</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link rel="icon" type="image/svg" href="{{ asset('images/Logo.svg') }}">
    <style>
        body {
            background-color: #ffffff;
            margin: 0;
            padding: 0;
        }
    </style>
</head>

<body>

    @include('partials.navbar')

    <div class="container mt-2">
        @yield('content')
    </div>

    @include('partials.footer')

    <!-- Bootstrap Script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JavaScript -->
    <script src="{{ asset('js/custom.js') }}"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('scan_error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Access Denied',
                text: '{{ session('scan_error') }}',
                confirmButtonText: 'OK'
            });
        </script>
    @endif

</body>

</html>
