@extends('layouts.app')

@section('title', 'Roles')

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

                    <div class="card-header"><h3><i class="fas fa-user-tag"></i> {{ __('Roles Administration') }}</h3></div>
                    
                    <div class="card-body">
                        
                        <button type="button" class="btn btn-primary mt-5" data-toggle="modal" data-target="#addRoleModal">
                            Add new role
                        </button>

                        <div class="table-wrapper col-12 mt-5">
                            <table id="roles-table" class="table table-sm p-0 table-hover font-s display nowrap table-bordered" width="100%">
                                <caption>List of roles</caption>
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Permissions</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('admin.modals.roles.create')
    @include('admin.modals.roles.edit')
    @include('admin.modals.roles.delete')

@stop

@push('scripts')

    <script type="text/javascript" src="{{ URL::to('js/modals-functionalities/roles/roles.js') }}"></script>

@endpush