@extends('layouts.dashboard')

@section('title', 'Profile')

@section('content')


                <form method="POST" action="{{ url('/users', array('id' => Auth::user()->id )) }}">
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
	                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" value="{{ old('password', $user->password) }}">
	                        </div>
	                    </div>

	                    <div class="form-group row">
	                        <label for="password_confirmation" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

	                        <div class="col-md-6">
	                            <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" value="{{ old('password_confirmation', $user->password) }}">
	                        </div>
	                    </div>
	                </div>
	                <div class="modal-footer">
	                    <button type="submit" class="btn btn-primary" id="ajaxEditSubmit">{{ __('Update') }}</button>
	                </div>
	            </form>
                    

                </div>
            </div>


 


        </div>
    </div>
</div>
@stop