@extends('layouts.app')

@section('content')
    <div class="d-flex flex-column justify-content-center align-items-center" style="min-height: calc(100vh - 180px);">
        <h2 class="text-center fw-bold mb-4 mb-md-5" style="color: #F24822; font-size: clamp(28px, 4vw, 44px);">Check a Link Before You Click</h2>

        {{-- Form Input URL --}}
        <form method="POST" action="{{ route('scanner.url.submit') }}" class="w-100 w-md-50 d-flex flex-column align-items-center" onsubmit="showLoadingOverlay()">
            @csrf
            <input type="text" id="url" name="url" class="form-control url-input mb-2" placeholder="Enter a URL to scan">
            <p class="url-helper text-center">Example: https://example.com</p>
            <button type="submit" class="btn btn-scan mt-3 mt-md-4" id="scanBtn">Scan</button>
        </form>

        <a href="/" class="btn-back btn-rounded mt-4 mt-md-5" style="margin-bottom: 24px;">
            <img src="{{ asset('images/arrow-left.svg') }}" alt="Back" class="icon-left">
            Back
        </a>
    </div>
@endsection