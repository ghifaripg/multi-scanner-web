@extends('layouts.app')

@section('content')
    <div class="d-flex flex-column justify-content-center align-items-center position-relative"
        style="min-height: 680px; max-width: 1440px; margin: 0 auto; padding: 32px;">

        {{-- Icon dan Judul --}}
        <div class="text-center mb-4" style="margin-top: -40px;">
            <img src="{{ asset('images/NotSafeIcon.png') }}" alt="Not Safe Icon" style="width: 100px; height: 100px;"
                class="mb-3">
            <h1 class="fw-bold text-danger" style="font-size: 3rem;">Not Safe!</h1>
            <p class="text-dark" style="max-width: 700px; font-size: 1.25rem;">
                Threats or malicious activity were detected in the scanned input. It is strongly advised not to proceed or
                open the file. See how to prevent
                <a href="{{ route('prevent.index') }}" class="text-decoration-underline text-warning" onclick="event.preventDefault(); window.location.href='{{ route('prevent.index') }}';">
                    here
                </a>.
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

            <a href="{{ route('result.full', ['scan_id' => $scan_id]) }}" class="btn-orange btn-rounded"
                style="font-size: 20px; padding: 12px 28px;">
                Full Report
            </a>
        </div>

    </div>

    @include('partials.comment-modal')
@endsection
