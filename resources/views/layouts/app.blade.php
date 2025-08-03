<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ThreatPeek</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('images/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon-16x16.png') }}">
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}">
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            background-color: #ffffff;
        }
        
        #app {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        
        .content {
            flex: 1;
            padding-bottom: 60px; /* Space for footer */
        }
        
       .footer {
            border-top: 1px solid #e9ecef; /* Changed to light gray border */
            background-color: white;
            padding: 1.5rem 0;
            margin-top: auto; /* Pushes footer to bottom */
        }

        @media (max-width: 768px) {
            .footer {
                padding: 1rem 0;
                border-top: 1px solid #e9ecef; /* Consistent border on mobile */
            }
        }
    </style>
</head>

<body id="app">
    @include('partials.navbar')

    <main class="content">
        <div class="container mt-2">
            @yield('content')
        </div>
    </main>

    <footer class="footer">
        <div class="container text-start">
            <p class="mb-0 fs-5">
                <span style="color: #F24822;">&copy;</span> ThreatPeek
            </p>
        </div>
    </footer>

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