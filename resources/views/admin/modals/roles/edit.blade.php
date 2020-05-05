<!-- Modal -->
<div class="modal fade" id="editRoleModal" tabindex="-1" role="dialog" aria-labelledby="editRoleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form method="POST" action="">
                <div class="modal-header">
                    <h5 class="modal-title" id="editRoleModalLongTitle">{{ __('Edit role') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @method('PATCH')
                    @csrf

                    <div class="form-group row">
                        <label for="edit-name" class="col-md-4 col-form-label text-md-right">{{ __('Role') }}</label>

                        <div class="col-md-6">
                            <input id="edit-name" type="text" class="form-control @error('edit_name') is-invalid @enderror" name="edit_name" value="{{ old('edit_name') }}" required autocomplete="edit_name" autofocus>
                        </div>
                    </div>
                    <div class="form-group row p-1 border m-1 rounded">
                        @foreach ($all_permissions as $permission)
                            <div class="custom-control  custom-switch col-4">
                                <input class="custom-control-input edit-permissions" name="pemissions[]" type="checkbox" id="{{$permission->name}}" value="{{$permission->id}}">
                                <label class="custom-control-label" for="{{$permission->name}}">
                                    {{ $permission->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                    <button type="submit" class="btn btn-primary" id="ajaxEditSubmit">{{ __('Update') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>