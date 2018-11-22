<div class="modal admin-modal" id="{{ $modalId }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Reject</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label>Reject reason</label>
                    <input type="text" class="form-control non-disabling" name="reject_reason">
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-danger">Reject</button>
                <a href="#" class="btn btn-default" data-dismiss="modal">Cancel</a>
            </div>
        </div>
    </div>
</div>