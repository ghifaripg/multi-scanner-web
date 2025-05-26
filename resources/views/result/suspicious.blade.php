@extends('layouts.app')

@section('content')
    <div class="d-flex flex-column justify-content-center align-items-center position-relative"
        style="min-height: 680px; max-width: 1440px; margin: 0 auto; padding: 32px;">

        {{-- Icon dan Judul --}}
        <div class="text-center mb-4" style="margin-top: -40px;">
            <img src="{{ asset('images/SuspiciousIcon.png') }}" alt="Suspicious Icon" style="width: 100px; height: 100px;" class="mb-3">
            <h1 class="fw-bold text-warning" style="font-size: 3rem;">Suspicious</h1>
            <p class="text-dark" style="max-width: 700px; font-size: 1.25rem;">
                The input contains elements that may be potentially harmful. Caution is advised and further review is recommended.
            </p>
        </div>

        {{-- Tombol --}}
        <a href="/" class="btn-back position-absolute btn-rounded" style="bottom: 0; left: 0; margin: 24px;">
            <img src="{{ asset('images/arrow-left.svg') }}" alt="Back" class="icon-left">
            Back
        </a>
        
        <div class="d-flex gap-3 position-absolute" style="bottom: 0; right: 0; margin: 24px;">
            <button onclick="openCommentModal()" class="btn-orange btn-rounded"
                style="font-size: 20px; padding: 12px 28px;">
                Comment
            </button>

            <a href="{{ route('result.full') }}" class="btn-orange btn-rounded"
                style="font-size: 20px; padding: 12px 28px;">
                Full Report
            </a>
        </div>

    </div>

    @include('partials.comment-modal')
@endsection
