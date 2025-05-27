@extends('layouts.app')

@section('content')
    <div class="d-flex flex-column justify-content-center align-items-center position-relative"
         style="min-height: 680px; max-width: 1440px; margin: 0 auto;">
        <div class="container mt-5 mb-5">
            <h1 class="fw-bold mb-4" style="font-size: 2.5rem; color:#F24822; font-family: 'Manrope', sans-serif;">
                Prevent Phishing Attacks
            </h1>

            <!-- Video Switcher -->
            <div class="mb-4 d-flex gap-3">
                <button class="btn btn-outline px-3 py-2" style="font-size: 0.9rem;" onclick="switchVideo('clicked')">
                    🚨 Already Clicked?
                </button>
            </div>

            <!-- Video Container -->
            <div class="d-flex justify-content-center mb-5">
                <div class="ratio ratio-16x9" style="max-width: 800px; width: 100%;" id="videoContainer">
                    <iframe width="560" height="315"
                        src="https://www.youtube.com/embed/XsOWczwRVuc?si=zUVADJZGHUONnWRA"
                        title="Prevent Phishing"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                </div>
            </div>

            <!-- Tips Section -->
            <div class="row g-4 mb-5">
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm border-0 rounded-4 p-3">
                        <div class="card-body">
                            <h5 class="fw-bold mb-3" style="color: #1a364c;">How Phishing Works</h5>
                            <ul class="list-unstyled small text-muted" style="font-family: 'Manrope', sans-serif;">
                                <li class="mb-2">• Hackers try to trick you into clicking fake links.</li>
                                <li class="mb-2">• They may steal your passwords or sensitive info.</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm border-0 rounded-4 p-3">
                        <div class="card-body">
                            <h5 class="fw-bold mb-3" style="color: #1a364c;">How to Avoid It</h5>
                            <ul class="list-unstyled small text-muted" style="font-family: 'Manrope', sans-serif;">
                                <li class="mb-2">• Don’t click links from unknown emails.</li>
                                <li class="mb-2">• Check for strange addresses or typos.</li>
                                <li class="mb-2">• Don’t trust “verify account” or “reset password” emails.</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm border-0 rounded-4 p-3">
                        <div class="card-body">
                            <h5 class="fw-bold mb-3" style="color: #1a364c;">Extra Protection Tips</h5>
                            <ul class="list-unstyled small text-muted" style="font-family: 'Manrope', sans-serif;">
                                <li class="mb-2">• Use spam filters and security tools.</li>
                                <li class="mb-2">• Type URLs manually instead of clicking links.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Back Button -->
            <div class="mt-4">
                <a href="/" class="btn-back btn-rounded d-inline-flex align-items-center px-4 py-2">
                    <img src="{{ asset('images/arrow-left.svg') }}" alt="Back" class="me-2" style="height: 16px;">
                    Back
                </a>
            </div>
        </div>
    </div>

    <script>
        function switchVideo(type) {
            const container = document.getElementById('videoContainer');
            const videos = {
                prevent: `
                    <iframe width="560" height="315"
                        src="https://www.youtube.com/embed/XsOWczwRVuc?si=zUVADJZGHUONnWRA"
                        title="Prevent Phishing"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        referrerpolicy="strict-origin-when-cross-origin"
                        allowfullscreen></iframe>
                `,
                clicked: `
                    <iframe width="560" height="315"
                        src="https://www.youtube.com/embed/B06nvFCyBFs?si=sMr9OI10UOoxbTrO"
                        title="Already Clicked Phishing Link"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        referrerpolicy="strict-origin-when-cross-origin"
                        allowfullscreen></iframe>
                `
            };

            container.innerHTML = videos[type];
        }
    </script>
@endsection
