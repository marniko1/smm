@extends('layouts.app')

@section('title', 'Import')

@section('content')

{{-- {{ dd(session('failures')) }} --}}

	<div class="container">
	    <div class="card bg-light mt-3">
	        <div class="card-header">
	            Import SentiOne Excel to database
	        </div>

	        <div class="card-body">

	        	@if (session('status'))
			    <div class="alert alert-success" role="alert">
			        {{ session('status') }}
			    </div>
			    @endif

			    @if (session('failures'))
				   <div class="alert alert-danger" role="alert">
				      <strong>Errors:</strong>
				      
				      <ul>
			            @foreach (session('failures') as $error)
			                <li>{{ $error }}</li>
			            @endforeach
				      </ul>
				   </div>
				@endif

	            <form action="{{ route('admin.import') }}" method="POST" enctype="multipart/form-data">
	                @csrf
	                <input id="file" type="file" class="form-control @error('file') is-invalid @enderror" name="file" value="{{ old('file') }}" autocomplete="file" autofocus required>

                            @error('file')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
	                <br>
	                <button class="btn btn-success">Import Data</button>
	                {{-- <a class="btn btn-warning" href="{{ route('export') }}">Export User Data</a> --}}
	            </form>
	        </div>
	    </div>
	</div>					

@stop

@push('scripts')

    

@endpush