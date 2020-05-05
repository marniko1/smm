<!-- Modal -->
<div class="modal fade" id="removeUserModal" tabindex="-1" role="dialog" aria-labelledby="removeUserModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            {{-- <div class="alert alert-danger" style="display:none"></div> --}}
            <form method="POST" action="">
                <div class="modal-header">
                    <h5 class="modal-title" id="removeUserModalLongTitle">{{ __('Remove user') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @method('DELETE')
                    @csrf

                    <h6>You are going to delete user! Click confirm button to continue.</h6>
                  
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                    <button type="submit" class="btn btn-primary" id="ajaxDeleteUserSubmit">{{ __('Confirm') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>