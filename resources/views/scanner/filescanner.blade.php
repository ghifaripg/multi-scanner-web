@extends('layouts.app')

@section('content')
  <div class="d-flex flex-column justify-content-center align-items-center position-relative"
    style="min-height: 680px; max-width: 1440px; margin: 0 auto;">

    <h2 class="text-center fw-bold mb-5" style="color: #F24822; font-size: 44px;">Upload a File for Basic Threat Check</h2>

    {{-- Form Upload Email --}}
    <form method="POST" {{--action="{{ route('scanner.file.submit') }}"--}} enctype="multipart/form-data"
      class="d-flex flex-column align-items-center">
      @csrf
      <label class="file-input">
        Drop your file here or <span style="color: #F24822; font-weight: bold;">Choose File</span>
        <input type="file" name="file" class="form-control d-none" accept=".eml">
      </label>
      <p class="file-helper"></p>
      <button type="submit" class="btn btn-scan">Scan</button>
    </form>

    {{-- Tombol Back --}}
    <a href="/" class="btn-back position-absolute btn-rounded" style="bottom: 0; left: 0; margin: 24px;">
      <img src="{{ asset('images/arrow-left.svg') }}" alt="Back" class="icon-left">
      Back
    </a>
  </div>
@endsection
