<!-- Modal -->
<div class="modal fade" id="commentModal" tabindex="-1" aria-labelledby="commentModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content custom-modal-content">
      <div class="modal-header border-0">
        <h5 class="modal-title fw-bold text-primary" id="commentModalLabel">Leave a Comment</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body pt-0">
        <form>
          <div class="mb-3">
            <textarea class="form-control" id="comment-text" rows="5" placeholder="Type here"></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer p-0">
        <button type="button" class="btn w-50 cancel-btn rounded-0" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn w-50 save-btn rounded-0">Save</button>
      </div>
    </div>
  </div>
</div>

<!-- Custom CSS -->
<style>
  .custom-modal-content {
    border-radius: 12px;
    box-shadow: 0 8px 16px rgba(0,0,0,0.25);
    overflow: hidden;
  }

  .modal-title {
    font-size: 1.25rem;
    color: #003049; /* dark navy */
  }

  .form-control {
    resize: none;
    border: 1px solid #ccc;
    border-radius: 8px;
  }

  .modal-footer button {
    height: 45px;
    font-weight: bold;
  }

  .cancel-btn {
    background-color: #003049; /* navy blue */
    color: white;
  }

  .save-btn {
    background-color: #F24822; /* orange */
    color: white;
  }

  .cancel-btn:hover, .save-btn:hover {
    opacity: 0.9;
  }

  .btn-close {
    background: transparent;
  }
</style>