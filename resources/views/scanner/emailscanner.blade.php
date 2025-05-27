@extends('layouts.app')
@include('partials.loading-overlay')

@section('content')
    <div class="d-flex flex-column justify-content-center align-items-center position-relative"
        style="min-height: 680px; max-width: 1440px; margin: 0 auto;">

        {{-- Title --}}
        <h2 class="text-center fw-bold mb-5" style="color: #F24822; font-size: 44px;">
            Open an Email file for Threat Check
        </h2>

        {{-- Form Upload Email --}}
        <form method="POST" enctype="multipart/form-data" action="{{ route('scanner.email.submit') }}"
            class="emlForm d-flex flex-column align-items-center" onsubmit="showLoadingOverlay()">
            @csrf

            {{-- Upload Box --}}
            <div class="uploadBox upload-box">

                {{-- Hidden file input --}}
                <input type="file" name="email" class="fileInput d-none" accept=".eml">

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
        <a href="{{ url()->previous() }}" class="btn-back position-absolute btn-rounded d-flex align-items-center"
            style="bottom: 0; left: 0; margin: 24px;">
            <img src="{{ asset('images/arrow-left.svg') }}" alt="Back" class="icon-left me-2">
            Back
        </a>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // DOM Elements
            const fileInput = document.querySelector('.fileInput');
            const uploadBox = document.querySelector('.uploadBox');
            const uploadText = document.querySelector('.uploadText');
            const fileSelected = document.querySelector('.fileSelected');
            const fileName = document.querySelector('.fileName');
            const removeFileBtn = document.querySelector('.removeFileBtn');
            const scanBtn = document.getElementById('scanBtn');
            const form = document.querySelector('form');

            // 1. Trigger file input when clicking the upload box
            uploadBox.addEventListener('click', function (e) {
                // Don't trigger if clicking on remove button
                if (!e.target.classList.contains('btn-remove')) {
                    fileInput.click();
                }
            });

            // 2. Handle file selection
            fileInput.addEventListener('change', function (e) {
                if (e.target.files.length > 0) {
                    const file = e.target.files[0];
                    if (validateFile(file)) {
                        updateFileDisplay(file.name);
                    }
                }
            });

            // 3. Handle drag and drop
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                uploadBox.addEventListener(eventName, preventDefaults, false);
            });

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            ['dragenter', 'dragover'].forEach(eventName => {
                uploadBox.addEventListener(eventName, highlight, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                uploadBox.addEventListener(eventName, unhighlight, false);
            });

            function highlight() {
                uploadBox.classList.add('dragover');
            }

            function unhighlight() {
                uploadBox.classList.remove('dragover');
            }

            uploadBox.addEventListener('drop', function (e) {
                const dt = e.dataTransfer;
                const file = dt.files[0];

                if (file && validateFile(file)) {
                    fileInput.files = dt.files;
                    updateFileDisplay(file.name);
                }
            });

            // 4. Remove file
            removeFileBtn.addEventListener('click', function (e) {
                e.stopPropagation();
                resetFileDisplay();
            });

            // 5. Form submission handling
            form.addEventListener('submit', function (e) {
                if (!fileInput.files.length) {
                    e.preventDefault();
                    alert('Please select an .eml file first');
                }
            });

            // Helper functions
            function validateFile(file) {
                // Check file type
                if (!file.name.endsWith('.eml')) {
                    alert('Only .eml files are allowed');
                    return false;
                }

                // Check file size (10MB max)
                if (file.size > 1024 * 1024 * 10) {
                    alert('File size must be less than 10MB');
                    return false;
                }

                return true;
            }

            function updateFileDisplay(name) {
                uploadText.classList.add('d-none');
                fileSelected.classList.remove('d-none');
                fileName.textContent = name;
                scanBtn.disabled = false;
                scanBtn.classList.remove('btn-disabled');
            }

            function resetFileDisplay() {
                fileInput.value = '';
                uploadText.classList.remove('d-none');
                fileSelected.classList.add('d-none');
                fileName.textContent = '';
                scanBtn.disabled = true;
                scanBtn.classList.add('btn-disabled');
            }
        });
    </script>

@endsection