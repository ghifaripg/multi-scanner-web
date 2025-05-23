@extends('layouts.auth')

@section('content')
<div class="auth-container login-page">
    <a href="/" class="btn-back"> <!-- Update route ke dashboard -->
        <img src="{{ asset('images/arrow-left.svg') }}" alt="Back">
    </a>
    <div class="auth-form">
        <h1 class="auth-title">Login</h1>
        <p class="auth-subtitle">Sign in to continue protecting your data</p>

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
                <a href="{{ route('password.request') }}" class="forgot-password">Forgot password?</a>
            </div>
            <button type="submit" class="btn-rounded login-btn">Login</button>
        </form>
        
        <p class="auth-footer">New here? <a href="{{ route('register') }}" class="auth-link">Create an account</a></p>
    </div>
</div>
@endsection
