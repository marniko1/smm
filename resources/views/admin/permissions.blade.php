@extends('layouts.app')

@section('title', 'Permissions')

@section('content')

    @if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
    @endif

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">

                    <div class="card-header"><h3><i class="fas fa-user-lock"></i> {{ __('Permissions Administration') }}</h3></div>
                    
                    <div class="card-body">
                        
                        <button type="button" class="btn btn-primary mt-5" data-toggle="modal" data-target="#addPermissionModal">
                            Add new permission
                        </button>

                        <div class="table-wrapper col-12 mt-5">
                            <table id="permissions-table" class="table table-sm p-0 table-hover font-s display nowrap table-bordered" width="100%">
                                <caption>List of permissions</caption>
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Name</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('admin.modals.permissions.create')
    @include('admin.modals.permissions.edit')
    @include('admin.modals.permissions.delete')

@stop

@push('scripts')

    <script type="text/javascript" src="{{ URL::to('js/modals-functionalities/permissions/permissions.js') }}"></script>

@endpush