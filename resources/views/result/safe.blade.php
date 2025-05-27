@extends('layouts.app')

@section('content')
    <div class="d-flex flex-column justify-content-center align-items-center position-relative"
        style="min-height: 680px; max-width: 1440px; margin: 0 auto; padding: 32px;">

        {{-- Icon dan Judul --}}
        <div class="text-center mb-4 mt-4">
            <img src="{{ asset('images/SafeIcon.png') }}" alt="Safe Icon" style="width: 100px; height: 100px;" class="mb-3">
            <h1 class="fw-bold text-success" style="font-size: 3rem;">Safe!</h1>
            <p class="text-dark" style="max-width: 700px; font-size: 1.25rem;">
                No threats or suspicious activities were detected. The scanned input appears to be safe and does not show
                any signs of harmful content. See how to prevent <a href="{{ route('prevent.index') }}" target="_blank"
                    class="text-decoration-underline text-warning">here</a>.
            </p>
        </div>

         {{-- Glimpse Before Scan --}}
        <section id="glimpse" class="scroll-target">
            {{-- Carousel --}}
            <div id="glimpseCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @for ($i = 0; $i < 3; $i++)
                        <div class="carousel-item {{ $i == 0 ? 'active' : '' }}">
                            <div class="row g-4">
                                @for ($j = 1; $j <= 6; $j++)
                                    <div class="col-md-4">
                                        <div class="card shadow-sm p-3">
                                            <div class="card-body">
                                                <p class="card-text">I love how fast and simple it is. Just dropped a URL
                                                    and it gave me a clear risk
                                                    summary in seconds. Must-have for remote teams.</p>
                                            </div>
                                            <div class="card-footer d-flex align-items-center">
                                                <img src="{{ asset('images/User-Icon.svg') }}" class="rounded-circle me-2"
                                                    alt="User Icon" width="40">
                                                <div>
                                                    <p class="fw-bold mb-1">John Doe</p>
                                                    <p class="text-muted mb-0">Scan Name • URL Scan</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endfor
                            </div>
                        </div>
                    @endfor
                </div>

                {{-- Carousel Controls --}}
                <button class="carousel-control-prev" type="button" data-bs-target="#glimpseCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#glimpseCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
            </div>
        </section>

        {{-- Tombol --}}
        <a href="/" class="btn-back position-absolute btn-rounded" style="bottom: 0; left: 0; margin: 24px;">
            <img src="{{ asset('images/arrow-left.svg') }}" alt="Back" class="icon-left">
            Back
        </a>

        {{-- Container untuk Comment dan Full Report --}}
        <div class="d-flex gap-3 position-absolute" style="bottom: 0; right: 0; margin: 24px;">

            <button class="btn-orange btn-rounded comment-btn"
                data-scan-id="{{ $scan_id }}"
                style="font-size: 20px; padding: 12px 28px;">
                Comment
            </button>

            <a href="{{ route('result.full', ['scan_id' => $scan_id]) }}" class="btn-orange btn-rounded"
                style="font-size: 20px; padding: 12px 28px;">
                Full Report
            </a>
        </div>


    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle comment button clicks
    document.querySelectorAll('.comment-btn').forEach(button => {
        button.addEventListener('click', async function() {
            const scanId = this.getAttribute('data-scan-id');

            const { value: commentText } = await Swal.fire({
                title: 'Add Comment',
                input: 'textarea',
                inputLabel: 'Your Comment',
                inputPlaceholder: 'Type your comment here...',
                inputAttributes: {
                    'aria-label': 'Type your comment here'
                },
                showCancelButton: true,
                confirmButtonText: 'Submit',
                cancelButtonText: 'Cancel',
                inputValidator: (value) => {
                    if (!value) {
                        return 'You need to write something!';
                    }
                }
            });

            if (commentText) {
                // Send the comment to your backend
                try {
                    const response = await fetch('/comments', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            scan_id: scanId,
                            comment: commentText
                        })
                    });

                    const result = await response.json();

                    if (response.ok) {
                        Swal.fire('Success!', 'Comment added successfully', 'success');
                    } else {
                        Swal.fire('Error!', result.message || 'Failed to add comment', 'error');
                    }
                } catch (error) {
                    Swal.fire('Error!', 'Something went wrong', 'error');
                }
            }
        });
    });
});
</script>
@endsection
