@extends('layouts.app')

@section('content')
    <div class="position-relative" style="min-height: 680px; max-width: 1440px; margin: 0 auto; padding: 40px 32px 120px;">

        {{-- Konten utama --}}
        <div class="text-start" style="max-width: 800px;">
            <h1 class="fw-bold mb-4" style="color: #F24822; font-size: 2.25rem;"> Scan Report:
                {{ $filename ?? 'Unknown File' }}
            </h1>
            @if (isset($reportLines))
                <div class="bg-light rounded p-4" style="font-family: monospace; white-space: pre-wrap;">
                    @foreach ($reportLines as $line)
                        {{ $line }}<br>
                    @endforeach
                </div>
            @else
                <p class="text-muted fs-5 mb-5">No report available.</p>
            @endif
        </div>

        {{-- Tombol Back dan Download sejajar dengan navbar & footer --}}
        <div class="d-flex align-items-center justify-content-between w-100 px-3"
            style="max-width: 1440px; position: absolute; bottom: 20px; left: 50%; transform: translateX(-50%);">

            {{-- Tombol Back - Sejajar dengan Logo ThreatPeek --}}
            <a href="{{ url()->previous() }}" class="btn-back btn-rounded d-flex align-items-center"
                style="position: absolute; bottom: 20px; left: 0; margin: 0 24px;">
                <img src="{{ asset('images/arrow-left.svg') }}" alt="Back" class="icon-left me-2">
                Back
            </a>

            {{-- Tombol Download - Sejajar dengan Sign In --}}
            <a href="#" class="btn-orange text-decoration-none"
                style="position: absolute; bottom: 20px; right: 0; margin: 0 24px;">
                Download Report
            </a>
        </div>

    @endsection
