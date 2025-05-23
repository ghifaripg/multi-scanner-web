<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ThreatPeek</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #ffffff;
            margin: 0;
            padding: 0;
        }

        .page-wrapper {
            width: 100%;
            min-height: 1024px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .centered-container {
            width: 100%;
            max-width: 1440px;
            min-height: 1024px;
            margin: 0 auto;
            position: relative;
            padding: 2rem;
        }
    </style>
</head>
<body>

    @include('partials.navbar')

    <div class="page-wrapper">
        <div class="centered-container">
            @yield('content')
        </div>
    </div>

    @include('partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
