@extends('layouts.auth')

@section('content')
<div class="auth-container register-page">
    <a href="/" class="btn-back">
        <img src="{{ asset('images/arrow-left.svg') }}" alt="Back">
    </a>
    <div class="auth-form register-form">
        <h1 class="auth-title">Register</h1>
        <p class="auth-subtitle">Create an account to start scanning threats</p>

        <form action="{{ route('register') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" placeholder="Enter your full name" required>
            </div>
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="form-group">
                <label for="password">New Password</label>
                <input type="password" id="password" name="password" placeholder="Create a strong password" required>
            </div>
            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Re-enter your password" required>
                <small class="auth-hint">Make sure your passwords match.</small>
            </div>
            <button type="submit" class="btn-rounded register-btn">Register</button>
        </form>
        
        <p class="auth-footer">Already have an account? <a href="{{ route('login') }}" class="auth-link">Sign in here</a></p>
    </div>
</div>
@endsection
