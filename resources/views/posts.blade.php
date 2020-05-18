@extends('layouts.app')

@section('title', 'Posts')

@section('content')

{{-- get MODEL name by table name --}}
{{-- {{ dd(Str::studly(Str::singular($all_domains[0]->getTable()))) }} --}}

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">

                    <div class="card-header"><h3><i class="fab fa-facebook"></i><i class="fab fa-twitter" style="vertical-align: super; margin-left: -5px;"></i><i class="fab fa-instagram" style="vertical-align: sub; margin-left: -20px;"></i> {{ __('Posts') }}</h3></div>
                    
                    <div class="card-body">

                        <div class="row">
                            
                            @foreach ($all_categories as $key => $category)
                                <div class="col-md-4">
                                    <select class="js-example-basic-multiple col-12" name="tags[]" multiple="multiple" data-placeholder="{{ $category->name }}" data-col="{{ 11 + $key }}">
                                        @foreach ($category->tags as $tag)
                                            <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endforeach

                        </div>

                        <hr>

                        <div class="row">

                            <div class="col-md-4">
                                <select class="js-example-basic-multiple col-12" name="domains[]" multiple="multiple" data-placeholder="Domain">
                                    @foreach ($all_domains as $domain)
                                        <option value="{{ $domain->id }}">{{ $domain->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <select class="js-example-basic-multiple col-12" name="types[]" multiple="multiple" data-placeholder="Type">
                                    @foreach ($all_types as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <select class="js-example-basic-multiple col-12" name="authors[]" multiple="multiple" data-placeholder="Author">
                                    @foreach ($all_authors as $author)
                                        <option value="{{ $author->id }}">{{ $author->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <select class="js-example-basic-multiple col-12" name="sentiments[]" multiple="multiple" data-placeholder="Sentiments">
                                    @foreach ($all_sentiments as $sentiment)
                                        <option value="{{ $sentiment->id }}">{{ $sentiment->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <select class="js-example-basic-multiple col-12" name="projects[]" multiple="multiple" data-placeholder="Project">
                                    @foreach ($all_projects as $project)
                                        <option value="{{ $project->id }}">{{ $project->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <select class="js-example-basic-multiple col-12" name="genders[]" multiple="multiple" data-placeholder="Gender">
                                    @foreach ($all_genders as $gender)
                                        <option value="{{ $gender->id }}">{{ $gender->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                        </div>

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


    <script>
        jQuery(document).ready(function(){

            $('.js-example-basic-multiple').select2({
                allowClear: true
            }).on('select2:unselecting', function() {
                $(this).data('unselecting', true);
            }).on('select2:opening', function(e) {
                if ($(this).data('unselecting')) {
                    $(this).removeData('unselecting');
                    e.preventDefault();
                }
            });

            let table = $('#posts-table').DataTable({
                dom: '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>',
                // dom: 'Bft',
                processing: true,
                serverSide: true,
                responsive: true,
                search: {regex: true},
                pagingType: "full_numbers",
                ajax: { 
                    url: URL + '/posts',
                        data: function (d) {

                            let tags = [];

                            $.each($('select[name="tags[]"]'), function (key,value){
                                // tags.push($(value).val());
                                tags = tags.concat($(value).val());
                            })

                            d.tags = tags;

                            d.domains = $('select[name="domains[]"]').val();
                            d.types = $('select[name="types[]"]').val();
                            d.authors = $('select[name="authors[]"]').val();
                            d.sentiments = $('select[name="sentiments[]"]').val();
                            d.projects = $('select[name="projects[]"]').val();
                            d.genders = $('select[name="genders[]"]').val();
                        }
                    },
                columns: [
                    { data: 'id', name: 'posts.id' },
                    { data: 'so_id', name: 'posts.so_id' },
                    { data: 'domain.name', name: 'domain.name' },
                    { data: 'type.name', name: 'type.name' },
                    { data: 'author.name', name: 'author.name' },
                    { data: 'author.author_id', name: 'author.author_id' },
                    { data: 'content', name: 'posts.content', orderable: false, searchable: false },
                    { data: 'sentiment.icon', name: 'sentiment.icon' },
                    { data: 'project.name', name: 'project.name' },
                    { data: 'gender.icon', name: 'gender.icon' },
                    { data: 'link', name: 'posts.link', orderable: false, searchable: false },
                    @foreach ($all_categories as $category)
                        {
                            data: 'tags',
                            name: 'tags.id',
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
                            orderable: true,
                            searchable: true
                        },
                    @endforeach
                ],
                // "columnDefs": [
                    // { width: 200, "targets": [ 6 ] },
                    //{ className: "permissions", "targets": [ 1 ] }
                // ]
            });



            // $.fn.dataTableExt.afnFiltering.push(
            //     function(oSettings, aData, iDataIndex) {
            //         var keywords = $(".dataTables_filter input").val().split(' ');  
            //         var matches = 0;
            //         for (var k=0; k<keywords.length; k++) {
            //             var keyword = keywords[k];
            //             for (var col=0; col<aData.length; col++) {
            //                 if (aData[col].indexOf(keyword)>-1) {
            //                     matches++;
            //                     break;
            //                 }
            //             }
            //         }
            //         return matches == keywords.length;
            //    }
            // );





            $('.js-example-basic-multiple').change(function () {

                table.draw();

                // console.log($(this).data('col'));
                // console.log($(this).val());
                // var search = $(this).val();

                // $.each(search, function(key, value){
                //     search[key] = value.replace(/[^\w^\s^\d]/g, "\\$&");
                // });

                // //search = search.join('|'); // OR
                // search = search.join('&'); // AND

               
                // // $.each(search, function(key, value){

                //     table.columns($(this).data('col')).search(search, true, false, true).draw(); // search(input, regex -> Treat as a regular expression (true) or not (default, false)., smart, caseInsen)
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
        //                 $('#dt-filters-wrapper')
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