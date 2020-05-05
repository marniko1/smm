@extends('layouts.app')

@section('title', 'Profile')

@section('content')
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-12">

				<div class="card">
					
	                <form method="POST" action="{{ route('admin.users.update', array(Auth::user()->id) ) }}">
		                <div class="modal-header">
		                    <h5 class="modal-title">{{ __('Edit user') }}</h5>
		                </div>
		                <div class="modal-body">
		                    @method('PATCH')
		                    @csrf

		                    <div class="form-group row">
		                        <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

		                        <div class="col-md-6">
		                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $user->name) }}" required autocomplete="name" autofocus>
		                        </div>
		                    </div>


		                    <div class="form-group row">
		                        <label for="username" class="col-md-4 col-form-label text-md-right">{{ __('Username') }}</label>

		                        <div class="col-md-6">
		                            <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username', $user->username) }}" required autocomplete="username" autofocus>
		                        </div>
		                    </div>



		                    <div class="form-group row">
		                        <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

		                        <div class="col-md-6">
		                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $user->email) }}" required autocomplete="email">
		                        </div>
		                    </div>

		                    <div class="form-group row">
		                        <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

		                        <div class="col-md-6">
		                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password" value="">
		                        </div>
		                    </div>

		                    <div class="form-group row">
		                        <label for="password_confirmation" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

		                        <div class="col-md-6">
		                            <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" autocomplete="new-password" value="">
		                        </div>
		                    </div>

		                    @role('Administrator')
		                    <div class="form-group row p-1 border m-1 rounded">
		                        @foreach ($all_roles as $role)
		                            <div class="custom-control custom-checkbox col-4">
		                                <input class="custom-control-input roles" name="roles[]" type="checkbox" id="role-{{$role->id}}" value="{{$role->id}}" {{ $user->roles->contains($role->id) ? 'checked' : '' }}>

		                                <label class="custom-control-label" for="role-{{$role->id}}">
		                                    {{ $role->name }}
		                                </label>
		                            </div>
		                        @endforeach
		                    </div>
		                    @endrole

		                </div>
		                <div class="modal-footer">
		                    <button type="submit" class="btn btn-primary" id="ajaxEditSubmit">{{ __('Update') }}</button>
		                </div>
		            </form>
				</div>
				
			</div>
		</div>
	</div>

                    

 
@stop