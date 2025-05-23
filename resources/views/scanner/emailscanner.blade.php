@extends('layouts.app')

@section('content')
  <div class="page-email-bg d-flex flex-column justify-content-center align-items-center position-relative"
       style="min-height: 680px; max-width: 1440px; margin: 0 auto;">

    <h2 class="text-center fw-bold mb-5" style="color: #F24822; font-size: 44px;">
      Open an Email file for Threat Check
    </h2>

    {{-- Form Upload Email --}}
    <form method="POST" {{--action="{{ route('scanner.email.submit') }}"--}} enctype="multipart/form-data"
          class="d-flex flex-column align-items-center">
      @csrf
      <label class="file-input">
        Drop your file here or <span style="color: #F24822; font-weight: bold;">Choose File</span>
        <input type="file" name="file" class="form-control d-none" accept=".eml">
      </label>
      <p class="email-helper"></p>

      <button type="submit" class="btn btn-scan mt-4">
        Scan
      </button>
    </form>

    {{-- Tombol Back --}}
    <a href="{{ url()->previous() }}"
       class="btn-back position-absolute btn-rounded d-flex align-items-center"
       style="bottom: 0; left: 0; margin: 24px;">
      <img src="{{ asset('images/arrow-left.svg') }}" alt="Back" class="icon-left me-2">
      Back
    </a>

  </div>
@endsection
