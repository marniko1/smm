@extends('layouts.app')

@section('title', 'Posts')

@section('content')

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">

                    <div class="card-header"><h3><i class="fab fa-facebook"></i><i class="fab fa-twitter" style="vertical-align: super; margin-left: -5px;"></i><i class="fab fa-instagram" style="vertical-align: sub; margin-left: -20px;"></i> {{ __('Posts') }}</h3></div>
                    
                    <div class="card-body">

                        <button id="btn" class="btn">SEARCH</button>

                        <select class="js-example-basic-multiple" name="states[]" multiple="multiple">
                            <option value="SDP Srbije (@sdpsrbije)">SDP Srbije (@sdpsrbije)</option>
    ...
                            <option value="Naprednjaci">Naprednjaci</option>
                        </select>

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

            $('.js-example-basic-multiple').select2();

            let table = $('#posts-table').DataTable({
                // dom: 'Bft',
                processing: true,
                serverSide: true,
                responsive: true,
                search: {regex: true},
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


            $('#btn').click(function () {
                var search = "SDP Srbije (@sdpsrbije)";
                table.columns(4).search(search).draw();
            });

            $('.js-example-basic-multiple').change(function () {
                // console.log($(this).val());
                var search = $(this).val();

                $.each(search, function(key, value){
                    search[key] = value.replace(/[^\w^\s^\d]/g, "\\$&");
                });

                search = search.join('|');

               // search = search.replace(/[^\w^\s^\d]/g, "\\$&")
                // $.each(search, function(key, value){

                    table.columns(4).search(search, true, false, true).draw(); // search(input, regex -> Treat as a regular expression (true) or not (default, false)., smart, caseInsen)
                // })
            });

            // var qualSearch = [];
            // for (var i = 0; i < quals.length; i++)
            // {
            //     qualSearch.push("\\b" + parseInt(quals[i]) + "\\b");
            // }
             
            // var search = qualSearch.join("|");
            // _DTOWLInfoGrid.columns(7).search(qualSearch.join("|"), true, false, true);
             
            // _DTOWLInfoGrid.draw();


        //     DropDowns.donetyping( function () {
        //     var val = $(this).val();
        //     if($.isArray(val)){val=val.join('$$');}
        //     table.column($(this).parents("td").index("td")).search( val ? ''+val+'' : '', false, false ).draw();
        // } , 1200);


        // $('#example').DataTable({"iDisplayLength": 100, "search": {regex: true}}).column(1).search("backlog|Stretch|Solid|NIR", true, false ).draw(); 

        //     table.columns().every( function () {
        //     // table.columns( '.select-filter' ).every( function () {
        //         var that = this;
             
        //         // Create the select list and search operation
        //         var select = $('<select />')
        //             .appendTo(
        //                 this.header()
        //             )
        //             .on( 'change', function () {
        //                 that
        //                     .search( $(this).val() )
        //                     .draw();
        //             } );
             
        //         // Get the search data for the first column and add to the select list
        //         this
        //             .cache( 'search' )
        //             .sort()
        //             .unique()
        //             .each( function ( d ) {
        //                 select.append( $('<option value="'+d+'">'+d+'</option>') );
        //             } );
        //     } );
        });
    </script>

@endpush