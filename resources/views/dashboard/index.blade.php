@extends('layouts.app')

@section('content')


    <div class="container py-5">

        {{-- Hero Section --}}
        <section class="pb-5">
            <div class="row align-items-center">
                <div class="col-md-6 text-start ps-md-5">
                    <h1 class="fw-bold mb-5" style="color: #F24822;">
                        Scan, Detect, Secure</span>
                    </h1>
                    <p class="text-muted fs-4">
                        A web-based cybersecurity platform that lets you scan URLs, files, and emails for potential threats.
                    </p>
                    <p class="text-muted fs-4 mb-5">
                        With just one click, identify hidden issues before they cause harm.
                    </p>
                    <div class="d-flex gap-3">
                        <a href="#scan-options" class="btn px-4 py-2 btn-rounded"
                            style="background-color: #FF6666; color: white;">Get
                            Started</a>
                        <a href="#glimpse" class="btn btn-outline" style="border-color: #FF6666; color: #FF6666;">Learn
                            More</a>
                    </div>
                </div>
                <div class="col-md-6 text-center">
                    <img src="{{ asset('images/HeroImage.png') }}" alt="Hero Image" class="img-fluid">
                </div>
            </div>
        </section>


        {{-- Glimpse Before Scan --}}
        <section id="glimpse" class="scroll-target">
            <div class="text-center mb-5">
                <h1 class="fw-bold" style="color: #F24822;">A Glimpse Before You Scan</h1>
                <p class="text-muted fs-4">
                    Before you dive in, take a look at some results from our users. See how quick and easy it is to
                    get insights on potential threats.
                </p>
            </div>

            {{-- Dynamic Grid of 6 Cards --}}
            <div class="row g-4 justify-content-center">
                @foreach ($glimpseResults as $scan)
                    <div class="col-md-4">
                        <div class="card shadow-sm p-3 glimpse-card h-100 d-flex flex-column justify-content-between">
                            <div class="card-body">
                                <p class="card-text mb-0">{{ $scan->comments->first()->comment ?? 'No comment provided.' }}</p>
                            </div>
                            <hr class="my-2" style="border-top: 1px solid #646464;">
                            <div class="card-footer d-flex align-items-center bg-white border-0 pt-0">
                                <img src="{{ asset('images/User-Icon.svg') }}" class="rounded-circle me-2"
                                    alt="User Icon" width="40">
                                <div>
                                    <p class="fw-bold mb-1">Anonymous</p>
                                    @if ($scan->scan_type === 'email' && !empty($scan->sender))
                                        <p class="text-muted mb-0">{{ $scan->sender }}</p>
                                    @endif
                                    <p class="text-muted mb-0">
                                        {{ $scan->scan_title }} • {{ ucfirst($scan->scan_result) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

            <style>
                .glimpse-card {
                    min-height: 200px;
                    max-height: 180px;
                    height: 180px;
                    display: flex;
                    flex-direction: column;
                    justify-content: space-between;
                }

                .glimpse-card .card-body {
                    flex: 1 1 auto;
                    overflow: hidden;
                }
            </style>



        {{-- Scan Lookup --}}
        <section id="scan-lookup">
            <h1 class="fw-bold text-center mb-5" style="color: #F24822;">Scan Lookup</h1>

            <!-- Search Form -->
            <form id="searchForm" class="d-flex justify-content-center mb-4" role="search">
                @csrf
                <input class="form-control me-2 rounded-pill" type="search" id="searchInput" name="search"
                    placeholder="Search email or URL scans..." aria-label="Search">
                <button class="btn rounded-pill px-4" type="submit"
                    style="background-color: #FF6666; color: white;">Search</button>
            </form>
            <small class="text-center d-block text-muted mb-3">Showing only Email and URL scan results</small>

            <!-- Results Container -->
            <div id="resultsContainer" class="result-container" style="display: none;">
                <div class="scrollable-list" id="resultsList">
                    <!-- Results will be inserted here by JavaScript -->
                </div>
            </div>
        </section>

        {{-- Scan Options --}}
        <section id="scan-options" class="scroll-target">
            <div class="text-center mb-5">
                <h1 class="fw-bold" style="color: #F24822;">Pick What You Want to Scan</h1>
            </div>

            <div class="row g-5">
                @php
                    $scanOptions = [
                        [
                            'title' => 'URL',
                            'desc' => 'Quickly scan any link for phishing, malware, or suspicious activity.',
                            'link' => '/url-scanner',
                            'icon' => 'URL-Vector.svg',
                        ],
                        [
                            'title' => 'File',
                            'desc' => 'Upload any file to scan for viruses, trojans, and hidden threats.',
                            'link' => '/file-scanner',
                            'icon' => 'File-Vector.svg',
                        ],
                        [
                            'title' => 'Email',
                            'desc' => 'Scan email headers and content to spot spoofing, spam or malicious attachments.',
                            'link' => '/email-scanner',
                            'icon' => 'Email-Vector.svg',
                        ],
                    ];
                @endphp

                @foreach ($scanOptions as $option)
                    <div class="col-md-4">
                        <div
                            class="card h-100 shadow-orange rounded-4 p-4 text-center d-flex flex-column align-items-center justify-content-between scan-card">
                            <div class="mb-3">
                                <img src="{{ asset('images/' . $option['icon']) }}" class="mb-2" width="60"
                                    alt="{{ $option['title'] }} icon">
                                <h5 class="fw-bold mb-1">{{ $option['title'] }}</h5>
                            </div>
                            <p class="text-muted fs-5">{{ $option['desc'] }}</p>
                            <a href="{{ $option['link'] }}" class="btn btn-scan-now">
                                Scan Now <img src="{{ asset('images/arrow-right.svg') }}" alt="arrow">
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    </div>
    </section>


    </div>
@endsection

<style>
    .result-container {
        max-height: 400px;
        overflow-y: auto;
    }

    .scrollable-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .result-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem;
        background-color: white;
        border-radius: 0.5rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {

        function escapeHTML(str) {
            return str.replace(/[&<>"']/g, function (match) {
                const escapeMap = {
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    '"': '&quot;',
                    "'": '&#39;'
                };
                return escapeMap[match];
            });
        }

        // Handle form submission
        $('#searchForm').on('submit', function(e) {
            e.preventDefault(); // Prevent default form submission
            performSearch();
        });

        function performSearch() {
            const searchTerm = $('#searchInput').val().trim();

            if (searchTerm.length === 0) {
                $('#resultsContainer').hide();
                return;
            }

            $.ajax({
                url: '{{ route('scan.ajaxSearch') }}',
                type: 'GET',
                data: {
                    search: searchTerm
                },
                success: function(response) {
                    const resultsList = $('#resultsList');
                    resultsList.empty(); // Clear previous results

                    if (response.scans.length > 0) {
                        response.scans.forEach(scan => {
                            resultsList.append(`
                            <div class="result-item">
                                <div class="d-flex align-items-center gap-3">
                                    <img src="{{ asset('images/User-Icon.svg') }}" class="rounded-circle" alt="User Icon" width="50">
                                    <div class="d-flex flex-column">
                                        <span class="fw-bold">${escapeHTML(scan.scan_title)}</span>
                                        <span class="text-muted">${scan.scan_result}</span>
                                        <span class="text-muted">${scan.scan_type}</span>
                                    </div>
                                </div>
                                <a href="/result/full-public/${scan.scan_id}" class="btn btn-link text-decoration-none">View</a>
                            </div>
                        `);
                        });
                        $('#resultsContainer').show();
                    } else {
                        resultsList.append(`
                        <div class="text-center text-muted py-3">
                            No scan results found for "${searchTerm}"
                        </div>
                    `);
                        $('#resultsContainer').show();
                    }
                },
                error: function(xhr) {
                    console.error('Search error:', xhr.responseText);
                }
            });
        }
    });
</script>
