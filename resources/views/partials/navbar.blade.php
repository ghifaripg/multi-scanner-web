@php
    $isLoggedIn = Auth::check();
@endphp

<style>
    .btn-signin {
        font-size: 23px;
        background-color: #1A364C;
        color: #F24822;
        border: none;
        transition: 0.3s ease;
        border-radius: 15px;
    }

    .btn-signin:hover {
        background-color: #1A364C;
        color: #ffffff;
    }
</style>

<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm py-2">
    <div class="container">
        <div class="d-flex w-100 align-items-center justify-content-between">

            {{-- Kiri: Logo --}}
            <a class="navbar-brand fw-bold" style="color: #F24822; font-size: 23px;" href="/">ThreatPeek</a>

            {{-- Toggler --}}
            <button class="navbar-toggler ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            {{-- Tengah: Menu --}}
            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                <ul class="navbar-nav gap-3 align-items-center">
                    <li class="nav-item">
                        <a class="nav-link text-center" href="{{ url('/') }}" style="font-size: 23px;">Home</a>
                    </li>


                    {{-- Garis vertikal pembatas --}}
                    <div style="height: 30px; width: 2px; background-color: #F24822;"></div>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-center" href="#" data-bs-toggle="dropdown"
                            style="font-size: 23px;">Scanner</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('scanner.url') }}">URL Scanner</a></li>
                            <li><a class="dropdown-item" href="{{ route('scanner.file') }}">File Scanner</a></li>
                            <li><a class="dropdown-item" href="{{ route('scanner.email') }}">Email Scanner</a></li>
                        </ul>
                    </li>

                    <div style="height: 30px; width: 2px; background-color: #F24822;"></div>

                    @if ($isLoggedIn)
                        <li class="nav-item">
                            <a class="nav-link text-center" href="{{ url('/history') }}"
                                style="font-size: 23px;">History</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link text-center" href="{{ url('/login') }}"
                                style="font-size: 23px;">History</a>
                        </li>
                    @endif
                </ul>
            </div>

            {{-- Kanan: Auth --}}
            <div class="d-flex align-items-center">
                @if ($isLoggedIn)
                    <div class="nav-item dropdown">
                        <a class="nav-link d-flex align-items-center" href="#" data-bs-toggle="dropdown" style="font-size: 23px;">
                            <img src="{{ asset('images/User-Icon.svg') }}" alt="Profile" width="36" height="36" class="rounded-circle me-2">
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item text-danger" href="#"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Logout
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <div class="nav-item dropdown">
                        <a class="btn btn-signin" href="#" data-bs-toggle="dropdown">
                            Sign In
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ url('/register') }}">Register</a></li>
                            <li><a class="dropdown-item" href="{{ url('/login') }}">Login</a></li>
                        </ul>
                    </div>
                @endif
            </div>

        </div>
    </div>
</nav>
