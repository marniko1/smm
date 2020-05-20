@extends('layouts.app')

@section('title', 'Import')

@section('content')

{{-- {{ dd($errors) }} --}}

	@if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
    @endif

	<div class="container">
	    <div class="card bg-light mt-3">
	        <div class="card-header">
	            Laravel 5.7 Import Export Excel to database Example - ItSolutionStuff.com
	        </div>
	        <div class="card-body">
	            <form action="{{ route('admin.import') }}" method="POST" enctype="multipart/form-data">
	                @csrf
	                <input id="file" type="file" class="form-control @error('file') is-invalid @enderror" name="file" value="{{ old('file') }}" autocomplete="file" autofocus required>

                            @error('file')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
	                <br>
	                <button class="btn btn-success">Import User Data</button>
	                {{-- <a class="btn btn-warning" href="{{ route('export') }}">Export User Data</a> --}}
	            </form>
	        </div>
	    </div>
	</div>					

@stop

@push('scripts')

    

@endpush