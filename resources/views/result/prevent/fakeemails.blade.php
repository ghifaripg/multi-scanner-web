@extends('layouts.app')

@section('content')
    <div class="d-flex flex-column justify-content-center align-items-center position-relative"
        style="min-height: 680px; max-width: 1440px; margin: 0 auto;">
        <div class="container mt-5 mb-5">
            <h1 class="fw-bold mb-4" style="font-size: 2.5rem; color:#F24822; font-family: 'Manrope', sans-serif;">
                How to Recognize Phishing Emails
            </h1>

            <!-- Video Container -->
            <div class="d-flex justify-content-center mb-5">
                <div class="ratio ratio-16x9" style="max-width: 800px; width: 100%;" id="videoContainer">
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/7hwGbhD5O4Q?si=a76BbpjiwQ8auWtr"
                        title="YouTube video player" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                </div>
            </div>

            <!-- Tips Section -->
            <div class="row g-4">
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm p-3">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Signs of Phishing Emails</h5>
                            <ul class="list-unstyled small text-muted">
                                <li class="mb-2">Urgent language like “Your account will be locked!”</li>
                                <li class="mb-2">Spelling or grammar mistakes.</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm p-3">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Attachments and Links</h5>
                            <ul class="list-unstyled small text-muted">
                                <li class="mb-2">Don’t open unexpected attachments or click links.</li>
                                <li class="mb-2">Be wary of emails requesting personal info.</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm p-3">
                        <div class="card-body">
                            <h5 class="card-title mb-3">What to Do</h5>
                            <ul class="list-unstyled small text-muted">
                                <li class="mb-2">Don’t reply. Mark it as phishing.</li>
                                <li class="mb-2">Block the sender and notify security team.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Explore More Tips Section -->
            <div class="text-center mb-5 mt-5">
                <h5 class="fw-bold mb-3" style="color: #1a364c; font-family: 'Manrope', sans-serif;">Want More Safety Tips?
                </h5>
                <div class="d-flex flex-wrap justify-content-center gap-2">
                    <a href="{{ route('prevent.phishing') }}" class="btn btn-outline-secondary rounded-pill px-4 py-2"
                        onclick="switchVideo('prevent')">Prevent
                        Phishing</a>
                    <a href="{{ route('prevent.clicked') }}"
                        class="btn btn-outline-secondary rounded-pill px-4 py-2">Already Clicked</a>
                    <a href="{{ route('prevent.cyberhygiene') }}"
                        class="btn btn-outline-secondary rounded-pill px-4 py-2">Cyber Hygiene</a>
                    <a href="{{ route('prevent.exerisks') }}"
                        class="btn btn-outline-secondary rounded-pill px-4 py-2">Executable File Risks</a>
                    <a href="{{ route('prevent.urlattacks') }}" class="btn btn-outline-secondary rounded-pill px-4 py-2">URL
                        Attack Patterns</a>
                    <a href="{{ route('prevent.generaltips') }}"
                        class="btn btn-outline-secondary rounded-pill px-4 py-2">General Online Safety</a>
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
