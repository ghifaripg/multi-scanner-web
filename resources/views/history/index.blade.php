@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <h2 class="fw-bold text-danger mb-4" style="color: #F24822 !important;">Your scans</h2>

        <!-- Scrollable Scan History -->
        <div class="scrollable-container">
            <div class="d-flex flex-column gap-3">
                @forelse ($scans as $scan_id)
                    <div class="p-3 rounded-4 border d-flex justify-content-between align-items-center shadow-sm">
                        <div>
                            <div class="fw-semibold">{{ $scan_id->scan_title }}</div>
                            <small class="text-muted">{{ $scan_id->scan_type }}</small><br>
                            <span class="text-muted">{{ $scan_id->scan_result }}</span>
                        </div>
                        <div class="d-flex flex-column align-items-end gap-2">
                            <small class="text-muted">
                                <i class="bi bi-clock"></i> {{ $scan_id->created_at->format('Y-m-d') }}
                            </small>
                            <div class="d-flex gap-2">
                                <a href="{{ route('report.full', ['scan_id' => $scan_id]) }}" class="btn btn-outline-secondary btn-sm rounded-5 px-3"
                                    style="color: #F24822">Full Report</a>
                                <button class="btn btn-outline-secondary btn-sm rounded-5 px-3 comment-btn"  data-scan-id="{{ $scan_id->scan_id }}">Comment</button>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-muted">No scan history found.</p>
                @endforelse
            </div>
        </div>

        <a href="/" class="btn-back btn-rounded">
            <img src="{{ asset('images/arrow-left.svg') }}" alt="Back" class="icon-left">
            Back
        </a>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle comment button clicks
    document.querySelectorAll('.comment-btn').forEach(button => {
        button.addEventListener('click', async function() {
            const scanId = this.getAttribute('data-scan-id');
            
            // First try to fetch existing comment
            try {
                const fetchResponse = await fetch(`/comments/check?scan_id=${scanId}`, {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });
                
                const existingComment = await fetchResponse.json();
                
                // Show the SweetAlert with existing comment if available
                const { value: commentText } = await Swal.fire({
                    title: existingComment ? 'Edit Your Comment' : 'Add Comment',
                    input: 'textarea',
                    inputLabel: 'Your Comment',
                    inputPlaceholder: 'Type your comment here...',
                    inputValue: existingComment?.comment || '', // Pre-fill if exists
                    inputAttributes: {
                        'aria-label': 'Type your comment here'
                    },
                    showCancelButton: true,
                    confirmButtonText: existingComment ? 'Update' : 'Submit',
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
                            Swal.fire('Success!', existingComment ? 'Comment updated' : 'Comment added successfully', 'success');
                        } else {
                            Swal.fire('Error!', result.message || 'Failed to save comment', 'error');
                        }
                    } catch (error) {
                        Swal.fire('Error!', 'Something went wrong', 'error');
                    }
                }
                
            } catch (error) {
                console.error('Error fetching existing comment:', error);
                // Fallback to regular comment flow if fetch fails
                // ... (use your original comment submission code)
            }
        });
    });
});
</script>

    </div>
@endsection

{{-- JavaScript File Reference --}}
@section('scripts')
    <script src="{{ asset('js/custom.js') }}"></script>
@endsection
