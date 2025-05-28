@extends('layouts.app')

@section('content')
    <div class="d-flex flex-column justify-content-center align-items-center position-relative"
        style="min-height: 680px; max-width: 1440px; margin: 0 auto;">
        <div class="container mt-5 mb-5">
            <h1 class="fw-bold mb-4" style="font-size: 2.5rem; color:#F24822; font-family: 'Manrope', sans-serif;">
                Best Practices for Online Security
            </h1>

            <!-- Video Container -->
            <div class="d-flex justify-content-center mb-5">
                <div class="ratio ratio-16x9" style="max-width: 800px; width: 100%;" id="videoContainer">
                    <iframe width="560" height="315"
                        src="https://www.dvidshub.net/video/embed/825765" title="Best Practices for Online Security"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                </div>
            </div>

            <!-- Tips Section -->
            <div class="row g-4">
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm p-3">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Update Regularly</h5>
                            <ul class="list-unstyled small text-muted">
                                <li class="mb-2">Keep your operating system and apps updated.</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm p-3">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Strong Password Habits</h5>
                            <ul class="list-unstyled small text-muted">
                                <li class="mb-2">Use strong and unique passwords.</li>
                                <li class="mb-2">Don’t reuse the same password across accounts.</li>
                                <li class="mb-2">Turn on two-factor authentication (2FA).</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm p-3">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Protect Your Data</h5>
                            <ul class="list-unstyled small text-muted">
                                <li class="mb-2">Regularly back up files to the cloud or external drive.</li>
                                <li class="mb-2">Use a password manager for convenience and safety.</li>
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
                    <a href="{{ route('prevent.phishing') }}"
                        class="btn btn-outline-secondary rounded-pill px-4 py-2">Prevent Phishing Attacks</a>
                    <a href="{{ route('prevent.clicked') }}"
                        class="btn btn-outline-secondary rounded-pill px-4 py-2">Already Clicked</a>
                    <a href="{{ route('prevent.fakeemails') }}"
                        class="btn btn-outline-secondary rounded-pill px-4 py-2">Recognize Fake Emails</a>
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
@endsection
