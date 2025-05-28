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
    document.querySelectorAll('.comment-btn').forEach(button => {
        button.addEventListener('click', async function() {
            const scanId = this.getAttribute('data-scan-id');
            
            try {
                // First check if comment exists
                const checkResponse = await fetch(`/comments/check?scan_id=${scanId}`, {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                });
                
                const existingComment = await checkResponse.json();
                
                // Show SweetAlert
                const { value: commentText } = await Swal.fire({
                    title: existingComment ? 'Edit Your Comment' : 'Add Comment',
                    input: 'textarea',
                    inputLabel: 'Your Comment',
                    inputPlaceholder: 'Type your comment here...',
                    inputValue: existingComment ? existingComment.comment : '',
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
                    let response;
                    let url;
                    let method;
                    
                    if (existingComment) {
                        // Update existing comment
                        url = `/comments/${existingComment.id}`;
                        method = 'PUT';
                    } else {
                        // Create new comment
                        url = '/comments';
                        method = 'POST';
                    }

                    response = await fetch(url, {
                        method: method,
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            scan_id: scanId,
                            comment: commentText
                        })
                    });

                    const result = await response.json();

                    if (response.ok) {
                        Swal.fire('Success!', result.message, 'success');
                    } else {
                        Swal.fire('Error!', result.message || 'Failed to save comment', 'error');
                    }
                }
            } catch (error) {
                console.error('Error:', error);
                Swal.fire('Error!', 'Something went wrong', 'error');
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
