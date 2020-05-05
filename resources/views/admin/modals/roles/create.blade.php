
<!-- Modal -->
<div class="modal fade" id="addRoleModal" tabindex="-1" role="dialog" aria-labelledby="addRoleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.roles.store') }}">
                <div class="modal-header">
                    <h5 class="modal-title" id="addRoleModalLongTitle">{{ __('Add new role') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    
                    @csrf

                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row p-1 border m-1 rounded">
                        @foreach ($all_permissions as $permission)
                            <div class="custom-control  custom-switch col-4">
                                <input class="custom-control-input permissions" name="pemissions[]" type="checkbox" id="permission-{{$permission->id}}" value="{{$permission->name}}">
                                <label class="custom-control-label" for="permission-{{$permission->id}}">
                                    {{ $permission->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                    <button type="submit" class="btn btn-primary" id="ajaxSubmit">{{ __('Add Role') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>