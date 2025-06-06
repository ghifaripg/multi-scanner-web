@extends('layouts.app')

@section('content')
    <div class="d-flex flex-column justify-content-center align-items-center position-relative"
        style="min-height: 680px; max-width: 1440px; margin: 0 auto; padding: 32px;">

        {{-- Icon dan Judul --}}
        <div class="text-center mb-4 mt-4">
            <img src="{{ asset('images/NotSafeIcon.png') }}" alt="Not Safe Icon" style="width: 100px; height: 100px;"
                class="mb-3">
            <h1 class="fw-bold text-danger" style="font-size: 3rem;">Not Safe!</h1>
            <p class="text-dark" style="max-width: 700px; font-size: 1.25rem;">
                Threats or malicious activity were detected in the scanned input. It is strongly advised not to proceed or
                open the file. See how to prevent
                <a href="{{ route('prevent.phishing') }}" class="text-decoration-underline text-warning" onclick="event.preventDefault()'">
                    here
                </a>.
            </p>
        </div>

<section id="glimpse" class="scroll-target">
            {{-- Carousel --}}
            <div id="glimpseCarousel" class="carousel slide" data-bs-ride="carousel">
                {{-- Show indicators only if more than 6 comments --}}
                @if($relatedComments->count() > 6)
                    <div class="carousel-indicators">
                        @for ($i = 0; $i < ceil($relatedComments->count() / 6); $i++)
                            <button type="button" data-bs-target="#glimpseCarousel"
                                    data-bs-slide-to="{{ $i }}"
                                    class="{{ $i === 0 ? 'active' : '' }}"
                                    aria-label="Slide {{ $i + 1 }}"></button>
                        @endfor
                    </div>
                @endif

                <div class="carousel-inner">
                    @php
                        $chunks = $relatedComments->chunk(6);
                    @endphp

                    @foreach ($chunks as $index => $chunk)
                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                            <div class="row g-4">
                                {{-- Real Comments --}}
                                @foreach ($chunk as $comment)
                                    <div class="col-md-4">
                                        <div class="card shadow-sm p-3 h-100">
                                            <div class="card-body">
                                                <p class="card-text">{{ $comment->comment }}</p>
                                            </div>
                                            <div class="card-footer d-flex align-items-center">
                                                <img src="{{ asset('images/User-Icon.svg') }}" class="rounded-circle me-2" alt="User Icon" width="40">
                                                <div>
                                                    <p class="fw-bold mb-1">{{ $comment->user->name ?? 'Anonymous' }}</p>
                                                    <p class="text-muted mb-0">{{ $comment->scan->scan_title ?? 'Untitled' }} • {{ ucfirst($comment->scan->scan_result ?? '-') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                {{-- Placeholder Cards (hidden but space-reserving) --}}
                                @for ($i = $chunk->count(); $i < 6; $i++)
                                    <div class="col-md-4">
                                        <div class="card shadow-sm p-3 invisible h-100">
                                            <div class="card-body">
                                                <p class="card-text">Placeholder text</p>
                                            </div>
                                            <div class="card-footer d-flex align-items-center">
                                                <img src="{{ asset('images/User-Icon.svg') }}" class="rounded-circle me-2" alt="User Icon" width="40">
                                                <div>
                                                    <p class="fw-bold mb-1">Placeholder</p>
                                                    <p class="text-muted mb-0">Placeholder • Placeholder</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endfor
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Only show controls if more than 6 comments --}}
                @if($relatedComments->count() > 6)
                    <button class="carousel-control-prev" type="button" data-bs-target="#glimpseCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#glimpseCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                @endif
            </div>
        </section>


        {{-- Tombol --}}
        <a href="/" class="btn-back position-absolute btn-rounded" style="bottom: 0; left: 0; margin: 24px;">
            <img src="{{ asset('images/arrow-left.svg') }}" alt="Back" class="icon-left">
            Back
        </a>

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

