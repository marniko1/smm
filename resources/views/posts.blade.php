@extends('layouts.app')

@section('title', 'Posts')

@section('content')

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">

                    <div class="card-header"><h3><i class="fab fa-facebook"></i><i class="fab fa-twitter" style="vertical-align: super; margin-left: -5px;"></i><i class="fab fa-instagram" style="vertical-align: sub; margin-left: -20px;"></i> {{ __('Posts') }}</h3></div>
                    
                    <div class="card-body">

                        <div class="table-wrapper col-12 mt-5">
                            <table id="posts-table" class="table table-sm p-0 table-hover font-s display wrap table-bordered" width="100%">
                                <caption>List of posts</caption>
                                <thead class="text-nowrap">
                                    <tr>
                                        <th>ID</th>
                                        <th>SO ID</th>
                                        <th>Domain group</th>
                                        <th>Specific type</th>
                                        <th>Author</th>
                                        <th>Author ID</th>
                                        <th>Content &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</th>
                                        <th>Sentiment</th>
                                        <th>Project name</th>
                                        <th>Gender</th>
                                        <th>Link to post</th>
                                        @foreach ($all_categories as $category)
                                            <th>{{ $category->name }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

@push('scripts')

<script src="https://cdn.datatables.net/fixedcolumns/3.3.0/js/dataTables.fixedColumns.min.js"></script>


    <script>
        jQuery(document).ready(function(){

            let table = $('#posts-table').DataTable({
                // dom: 'Bft',
                processing: true,
                serverSide: true,
                responsive: true,
                pagingType: "full_numbers",
                ajax: URL + '/posts',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'so_id', name: 'so_id' },
                    { data: 'domain.name', name: 'domain.name' },
                    { data: 'type.name', name: 'type.name' },
                    { data: 'author.name', name: 'author.name' },
                    { data: 'author.author_id', name: 'author.author_id' },
                    { data: 'content', name: 'content', orderable: false, searchable: false },
                    { 
                        data: 'sentiment.icon',
                        name: 'sentiment.icon',
                        render: function(data) {
                            return $("<div/>").html(data).text();
                        }
                    },
                    { data: 'project.name', name: 'project.name' },
                    { 
                        data: 'gender.icon',
                        name: 'gender.icon',
                        render: function(data) {
                            return $("<div/>").html(data).text();
                        }
                    },
                    { data: 'link', name: 'link', orderable: false, searchable: false },
                    @foreach ($all_categories as $category)
                        {
                            data: 'tags',
                            name: 'category',
                            render: function(data) {

                                let cat_prefix = '{{ $category->prefix }}';

                                let tags_arr = data.split(', ');

                                let filtered_tags = '';

                                $.each(tags_arr, function(key, value){

                                    if ((value.split('_')[0] + '_') == cat_prefix) {
                                        filtered_tags += value + ', ';
                                    }

                                })

                                filtered_tags = filtered_tags.replace(/,\s*$/, "");

                                return filtered_tags;
                            },
                            orderable: false,
                            searchable: false
                        },
                    @endforeach
                ],
                // "columnDefs": [
                    // { width: 200, "targets": [ 6 ] },
                    //{ className: "permissions", "targets": [ 1 ] }
                // ]
            });
        });
    </script>

@endpush