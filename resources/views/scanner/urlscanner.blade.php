@extends('layouts.app')

@section('content')
    <div class="d-flex flex-column justify-content-center align-items-center position-relative"
        style="min-height: 680px; max-width: 1440px; margin: 0 auto;">

        <h2 class="text-center fw-bold mb-5" style="color: #F24822; font-size: 44px;">Check a Link Before You Click</h2>

        {{-- Form Input URL --}}
        <form method="POST" action="{{ route('scanner.url.submit') }}" class="w-50 d-flex flex-column align-items-center">

            @csrf
            <input type="text" id="url" name="url" class="form-control url-input"
                placeholder="Enter a URL to scan">
            <p class="url-helper">Example: https://example.com</p>
            <button type="submit" class="btn btn-scan">Scan</button>
        </form>


        <a href="/" class="btn-back position-absolute btn-rounded" style="bottom: 0; left: 0; margin: 24px;">
            <img src="{{ asset('images/arrow-left.svg') }}" alt="Back" class="icon-left">
            Back
        </a>

    </div>
@endsection
