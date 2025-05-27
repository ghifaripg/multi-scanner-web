@extends('layouts.app')
@include('partials.loading-overlay')

@section('content')
    <div class="d-flex flex-column justify-content-center align-items-center position-relative"
        style="min-height: 680px; max-width: 1440px; margin: 0 auto;">

        {{-- Title --}}
        <h2 class="text-center fw-bold mb-5" style="color: #F24822; font-size: 44px;">
            Upload a File for Basic Threat Check
        </h2>

        {{-- Form --}}
        <form method="POST" enctype="multipart/form-data" action="{{ route('scanner.file.submit') }}"
            class="exeForm d-flex flex-column align-items-center" onsubmit="showLoadingOverlay()">
            @csrf

            {{-- Upload Box --}}
            <div class="uploadBox upload-box">

                {{-- Hidden file input --}}
                <input type="file" name="file" class="fileInput d-none" accept=".exe,.pdf">

                {{-- Default text --}}
                <div class="uploadText">
                    Open your <span class="text-danger fw-bold">File Here</span>
                </div>

                {{-- File selected view --}}
                <div class="fileSelected d-none d-flex justify-content-between align-items-center mt-1">
                    <span class="fileName text-truncate" style="max-width: 220px;"></span>
                    <button type="button" class="removeFileBtn btn-remove">✕</button>
                </div>
            </div>

            {{-- Helper Text --}}
            <small class="text-muted mt-2">Only .exe & pdf files</small>

            {{-- Submit Button --}}
            <button type="submit" class="btn btn-scan btn-disabled mt-4" id="scanBtn" disabled>
                Scan
            </button>
        </form>

        {{-- Back Button --}}
        <a href="/" class="btn-back position-absolute btn-rounded" style="bottom: 0; left: 0; margin: 24px;">
            <img src="{{ asset('images/arrow-left.svg') }}" alt="Back" class="icon-left">
            Back
        </a>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fileForm = document.querySelector('form.exeForm');
        if (!fileForm) return;

        const fileInput = fileForm.querySelector('.fileInput');
        const uploadBox = fileForm.querySelector('.uploadBox');
        const uploadText = fileForm.querySelector('.uploadText');
        const fileSelected = fileForm.querySelector('.fileSelected');
        const fileName = fileForm.querySelector('.fileName');
        const removeFileBtn = fileForm.querySelector('.removeFileBtn');
        const scanBtn = fileForm.querySelector('#scanBtn');

        uploadBox.addEventListener('click', function(e) {
            if (!e.target.classList.contains('btn-remove')) {
                fileInput.click();
            }
        });

        fileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file && validateFile(file)) {
                updateFileDisplay(file.name);
            }
        });

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            uploadBox.addEventListener(eventName, preventDefaults, false);
        });

        ['dragenter', 'dragover'].forEach(eventName => {
            uploadBox.addEventListener(eventName, () => uploadBox.classList.add('dragover'), false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            uploadBox.addEventListener(eventName, () => uploadBox.classList.remove('dragover'), false);
        });

        uploadBox.addEventListener('drop', function(e) {
            const file = e.dataTransfer.files[0];
            if (file && validateFile(file)) {
                fileInput.files = e.dataTransfer.files;
                updateFileDisplay(file.name);
            }
        });

        removeFileBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            resetFileDisplay();
        });

        fileForm.addEventListener('submit', function(e) {
            if (!fileInput.files.length) {
                e.preventDefault();
                alert('Please select a .exe or .pdf file first');
            }
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        function validateFile(file) {
            const allowed = ['.exe', '.pdf'];
            const isValid = allowed.some(ext => file.name.endsWith(ext));
            if (!isValid) {
                alert('Only .exe and .pdf files are allowed');
                return false;
            }
            if (file.size > 10 * 1024 * 1024) {
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
