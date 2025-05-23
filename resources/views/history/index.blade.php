@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <h2 class="fw-bold text-danger mb-4" style="color: #F24822 !important;">Your scans</h2>

        <!-- Scrollable Riwayat Scan -->
        <div class="scrollable-container">
            <div class="d-flex flex-column gap-3">
                @for ($i = 0; $i < 10; $i++) <!-- Tambah jumlah data untuk uji scroll -->
                    <div class="p-3 rounded-4 border d-flex justify-content-between align-items-center shadow-sm">
                        <div>
                            <div class="fw-semibold">Scan Name {{ $i+1 }}</div>
                            <small class="text-muted">Scan Type</small><br>
                            <span class="text-muted">Safe/Not Safe</span>
                        </div>
                        <div class="d-flex flex-column align-items-end gap-2">
                            <small class="text-muted">
                                <i class="bi bi-clock"></i> 19min ago
                            </small>
                            <div class="d-flex gap-2">
                                <a href="#" class="btn btn-outline-secondary btn-sm rounded-5 px-3" style="color: #F24822">Full Report</a>
                                <a href="#" class="btn btn-outline-secondary btn-sm rounded-5 px-3">Comment</a>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
        </div>

        <a href="/" class="btn-back btn-rounded">
            <img src="{{ asset('images/arrow-left.svg') }}" alt="Back" class="icon-left">
            Back
        </a>
    </div>
@endsection
