@php
    $isLoggedIn = Auth::check();
@endphp

<style>
    /* Navbar Styles */
    .navbar {
        border-bottom: 1px solid rgba(242, 72, 34, 0.2);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }
    
    .navbar-brand {
        color: #F24822 !important;
        font-weight: 700;
        font-size: 1.5rem !important;
    }
    
    .nav-link {
        font-size: 1.1rem !important;
        color: #1A364C !important;
        padding: 0.5rem 1rem !important;
    }
    
    .nav-link:hover {
        color: #F24822 !important;
    }
    
    .dropdown-menu {
        border-radius: 10px;
        border: 1px solid rgba(242, 72, 34, 0.2);
    }
    
    .dropdown-item {
        padding: 0.5rem 1rem;
    }
    
    .dropdown-item:hover {
        background-color: rgba(242, 72, 34, 0.1);
        color: #F24822 !important;
    }
    
    .divider-line {
        height: 30px;
        width: 2px;
        background-color: #F24822;
        margin: 0 0.5rem;
    }
    
    /* Auth Button Styles */
    .btn-signin {
        font-size: 1.1rem;
        background-color: #1A364C;
        color: #F24822;
        border: none;
        transition: all 0.3s ease;
        border-radius: 15px;
        padding: 0.5rem 1.25rem;
        white-space: nowrap;
    }
    
    .btn-signin:hover {
        background-color: #1A364C;
        color: #ffffff;
    }
    
    .user-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
    }
    
    /* Mobile Menu Styles */
    @media (max-width: 991.98px) {
        .navbar-collapse {
            background-color: white;
            padding: 1rem;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            margin-top: 1rem;
        }
        
        .navbar-nav {
            align-items: flex-start !important;
            gap: 0.5rem !important;
        }
        
        .divider-line {
            display: none;
        }
        
        .dropdown-menu {
            border: none;
            box-shadow: none;
            padding-left: 1rem;
        }
    }
</style>

<nav class="navbar navbar-expand-lg navbar-light bg-white py-2 py-lg-3">
    <div class="container">
        <!-- Brand/Logo -->
        <a class="navbar-brand fw-bold" href="/">ThreatPeek</a>
        
        <!-- Mobile Toggle -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <!-- Navbar Content -->
        <div class="collapse navbar-collapse" id="navbarContent">
            <!-- Center-aligned Navigation Items -->
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0 align-items-center">
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/') }}">Home</a>
                </li>
                
                <div class="divider-line d-none d-lg-block"></div>
                
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="scannerDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Scanner
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="scannerDropdown">
                        <li><a class="dropdown-item" href="{{ route('scanner.url') }}">URL Scanner</a></li>
                        <li><a class="dropdown-item" href="{{ route('scanner.file') }}">File Scanner</a></li>
                        <li><a class="dropdown-item" href="{{ route('scanner.email') }}">Email Scanner</a></li>
                    </ul>
                </li>
                
                <div class="divider-line d-none d-lg-block"></div>
                
                <li class="nav-item">
                    <a class="nav-link" href="{{ $isLoggedIn ? url('/history') : url('/login') }}">History</a>
                </li>
            </ul>
            
            <!-- Right-aligned Auth Section -->
            <div class="d-flex align-items-center">
                @if ($isLoggedIn)
                    <div class="nav-item dropdown">
                        <a class="nav-link d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ asset('images/User-Icon.svg') }}" alt="Profile" class="user-avatar me-2">
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li>
                                <a class="dropdown-item text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <div class="nav-item dropdown">
                        <a class="btn btn-signin" href="#" id="authDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Sign In
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="authDropdown">
                            <li><a class="dropdown-item" href="{{ url('/register') }}">Register</a></li>
                            <li><a class="dropdown-item" href="{{ url('/login') }}">Login</a></li>
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>
</nav>