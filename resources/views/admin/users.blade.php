@extends('layouts.app')

@section('title', 'Users')

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

                                    <div class="card-header"><h3><i class="fas fa-users"></i> {{ __('Users Administration') }}</h3></div>
                                    
                                    <div class="card-body">
                                        
                                        <button type="button" class="btn btn-primary mt-5" data-toggle="modal" data-target="#addUserModal">
                                            <i class="fas fa-user-plus"></i> Add new user
                                        </button>

                                        <div class="table-wrapper col-12 mt-5">
                                            <table id="users-table" class="table table-sm p-0 table-hover font-s display nowrap table-bordered" width="100%">
                                                <caption>List of users</caption>
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Username</th>
                                                        <th>Email</th>
                                                        <th>Roles</th>
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

				</div>
            </div>


            @include('admin.modals.users.create')
            @include('admin.modals.users.edit')
            @include('admin.modals.users.delete')


        </div>
    </div>
</div>
@stop

@push('scripts')

    <script type="text/javascript" src="{{ URL::to('js/modals-functionalities/users/users.js') }}"></script>

@endpush
