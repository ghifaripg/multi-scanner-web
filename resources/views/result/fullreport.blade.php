@extends('layouts.app')

@section('content')
  <div class="position-relative" style="min-height: 680px; max-width: 1440px; margin: 0 auto; padding: 40px 32px 120px;">

    {{-- Konten utama --}}
    <div class="text-start" style="max-width: 800px;">
    <h1 class="fw-bold mb-4" style="color: #F24822; font-size: 2.25rem;">Title</h1>
    <p class="text-muted fs-5 mb-5" style="line-height: 1.8;">
      Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore
      magna aliqua.
      Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
      Lorem ipsum dolor sit amet, consectetur adipiscing elit...
    </p>
    </div>

{{-- Tombol Back dan Download sejajar dengan navbar & footer --}}
<div class="d-flex align-items-center justify-content-between w-100 px-3"
    style="max-width: 1440px; position: absolute; bottom: 20px; left: 50%; transform: translateX(-50%);">

    {{-- Tombol Back - Sejajar dengan Logo ThreatPeek --}}
    <a href="{{ url()->previous() }}" class="btn-back text-decoration-none d-flex align-items-center"
        style="position: absolute; left: 0;">
        <img src="{{ asset('images/arrow-left.svg') }}" alt="Back" class="icon-left">
        Back
    </a>

    {{-- Tombol Download - Sejajar dengan Sign In --}}
    <a href="#" class="btn-orange text-decoration-none"
        style="position: absolute; right: 0;">
        Download Report
    </a>
</div>

@endsection