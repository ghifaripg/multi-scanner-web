@extends('layouts.app')

@section('content')
<div class="d-flex flex-column justify-content-center align-items-center position-relative"
     style="min-height: 680px; max-width: 1440px; margin: 0 auto;">
    
    {{-- Title --}}
    <h2 class="text-center fw-bold mb-5" style="color: #F24822; font-size: 44px;">
        Open an Email file for Threat Check
    </h2>

    {{-- Form Upload Email --}}
    <form method="POST" enctype="multipart/form-data" action="{{ route('scanner.email.submit') }}"
          class="d-flex flex-column align-items-center">
        @csrf

        {{-- Upload Box --}}
        <div class="uploadBox upload-box">
            
            {{-- Hidden file input --}}
            <input type="file" name="file" class="fileInput d-none" accept=".eml">

            {{-- Default text --}}
            <div class="uploadText">
                Open your email <span class="text-danger fw-bold">File Here</span>
            </div>

            {{-- File selected view --}}
            <div class="fileSelected d-none d-flex justify-content-between align-items-center mt-1">
                <span class="fileName text-truncate" style="max-width: 220px;"></span>
                <button type="button" class="removeFileBtn btn-remove">✕</button>
            </div>
        </div>

        {{-- Helper Text --}}
        <small class="text-muted mt-2">Only .eml files</small>

        {{-- Submit Button --}}
        <button type="submit" class="btn btn-scan btn-disabled mt-4" id="scanBtn" disabled>Scan</button>
    </form>

    {{-- Back Button --}}
    <a href="{{ url()->previous() }}"
       class="btn-back position-absolute btn-rounded d-flex align-items-center"
       style="bottom: 0; left: 0; margin: 24px;">
        <img src="{{ asset('images/arrow-left.svg') }}" alt="Back" class="icon-left me-2">
        Back
    </a>
</div>
@endsection