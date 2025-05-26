<div id="commentModal" class="modal">
    <div class="modal-header">
        <h3 class="modal-title">Leave a Comment</h3>
        <span class="close" onclick="closeCommentModal()">&times;</span>
    </div>
    <div class="modal-body">
        <textarea id="commentText" placeholder="Type here" rows="5"></textarea>
    </div>
    <div class="modal-footer">
        <button class="btn-cancel" onclick="closeCommentModal()">Cancel</button>
        <button class="btn-save" onclick="saveComment()">Save</button>
    </div>
</div>
