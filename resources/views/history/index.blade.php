@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <h2 class="fw-bold text-danger mb-4" style="color: #F24822 !important;">Your scans</h2>

        <!-- Scrollable Scan History -->
        <div class="scrollable-container">
            <div class="d-flex flex-column gap-3">
                @forelse ($scans as $scan_id)
                    <div class="p-3 rounded-4 border d-flex justify-content-between align-items-center shadow-sm">
                        <div>
                            <div class="fw-semibold">{{ $scan_id->scan_title }}</div>
                            <small class="text-muted">{{ $scan_id->scan_type }}</small><br>
                            <span class="text-muted">{{ $scan_id->scan_result }}</span>
                        </div>
                        <div class="d-flex flex-column align-items-end gap-2">
                            <small class="text-muted">
                                <i class="bi bi-clock"></i> {{ $scan_id->created_at->format('Y-m-d') }}
                            </small>
                            <div class="d-flex gap-2">
                                <a href="{{ route('result.full', ['scan_id' => $scan_id]) }}" class="btn btn-outline-secondary btn-sm rounded-5 px-3"
                                    style="color: #F24822">Full Report</a>
                                <button class="btn btn-outline-secondary btn-sm rounded-5 px-3 comment-btn">Comment</button>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-muted">No scan history found.</p>
                @endforelse
            </div>
        </div>

        <a href="/" class="btn-back btn-rounded">
            <img src="{{ asset('images/arrow-left.svg') }}" alt="Back" class="icon-left">
            Back
        </a>

        {{-- Include Comment Modal --}}
        @include('partials.comment-modal')

    </div>
@endsection

{{-- JavaScript File Reference --}}
@section('scripts')
    <script src="{{ asset('js/custom.js') }}"></script>
@endsection
