@extends('layouts.app')

@section('title', 'Posts')

@section('content')

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">

                    <div class="card-header">
                        <h3>
                            <i class="fab fa-facebook" style="color: #3b5998;"></i><i class="fab fa-twitter" style="vertical-align: super;margin-left: -5px;color: #55acee;"></i><i class="fab fa-instagram" style="vertical-align: sub;margin-left: -20px;color: #3f729b;"></i> {{ __('Posts') }}
                        </h3>
                    </div>
                    
                    <div class="card-body">

                        <div class="row">
                            
                            @foreach ($all_categories as $key => $category)
                                <div class="col-md-4 mb-3 tags">
                                    <select class="filters col-12" name="tags[]" multiple="multiple" data-placeholder="{{ $category->name }}">
                                        @foreach ($category->tags as $tag)
                                            <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                                        @endforeach
                                    </select>
                                    <input id="orAnd{{ $key }}" class="or-and-toggle" type="checkbox" data-toggle="toggle" data-style="position-absolute-left" data-on="OR" data-off="AND" data-onstyle="danger" data-width="67" data-height="39">
                                </div>
                            @endforeach

                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-4 row">
                                <label for="reportrange" class="col-3 col-form-label">Report date range</label>
                                <div class="col reportrange-input-wrapper">
                                    <div id="reportrange">
                                        <input class="reportrange form-control bg-white text-dark btn border" type="text" readonly>
                                        <i class="fas fa-caret-down" style="cursor: pointer;"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-8 row align-content-center">

                                <div class="col-md-2 h2 border rounded text-center filter-icons-wrapper">

                                    @foreach ($all_domains as $domain)
                                        <label class="mb-0 filter-icons-labels" for="{{ $domain->name }}-icon">{!! $domain->icon !!}</label>
                                        <input id="{{ $domain->name }}-icon" class="invisible position-absolute filter-icons" type="checkbox" name="domain[]" value="{{ $domain->id }}" checked>
                                    @endforeach

                                </div>

                                <div class="col-md-2 h2 border rounded text-center filter-icons-wrapper">

                                    @foreach ($all_sentiments as $sentiment)
                                        <label class="mb-0 filter-icons-labels btn" for="{{ $sentiment->name }}-icon">{!! $sentiment->icon !!}</label>
                                        <input id="{{ $sentiment->name }}-icon" class="invisible position-absolute filter-icons" type="checkbox" name="sentiments[]" value="{{ $sentiment->id }}" checked>
                                    @endforeach

                                </div>

                                <div class="col-md-2 h2 border rounded text-center filter-icons-wrapper">

                                    @foreach ($all_genders as $gender)
                                        <label class="mb-0 filter-icons-labels btn" for="{{ $gender->name }}-icon">{!! $gender->icon !!}</label>
                                        <input id="{{ $gender->name }}-icon" class="invisible position-absolute filter-icons" type="checkbox" name="genders[]" value="{{ $gender->id }}" checked>
                                    @endforeach

                                </div>

                                <div class="col-md-6 h2 text-center filter-btns-wrapper">

                                    @foreach ($all_types as $type)
                                        <label class="mb-0 filter-btns-labels btn border border-primary text-primary" for="{{ $type->name }}-btn">{{ $type->name }}</label>
                                        <input id="{{ $type->name }}-btn" class="invisible position-absolute filter-btns" type="checkbox" name="types[]" value="{{ $type->id }}" checked>
                                    @endforeach

                                </div>

                            </div>

                        </div>

                        <hr>

                        <div class="row">

                            <div class="col-md-4">
                                <select class="filters col-12" name="authors[]" multiple="multiple" data-placeholder="Author">
                                    @foreach ($all_authors as $author)
                                        <option value="{{ $author->id }}">{{ $author->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <select class="filters col-12" name="projects[]" multiple="multiple" data-placeholder="Project">
                                    @foreach ($all_projects as $project)
                                        <option value="{{ $project->id }}">{{ $project->name }}</option>
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
                                        <th>SO Date</th>
                                        @foreach ($all_categories as $category)
                                            <th>{{ $category->name }}</th>
                                        @endforeach
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
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

    <script>
        jQuery(document).ready(function(){

            /*===============================
            =            Select2            =
            ===============================*/
            
            
            $('.filters').select2({
                allowClear: true,
                // tags: true // allows to search by non existing tag
            }).on('select2:unselecting', function() {
                $(this).data('unselecting', true);
            }).on('select2:opening', function(e) {
                if ($(this).data('unselecting')) {
                    $(this).removeData('unselecting');
                    e.preventDefault();
                }
            });
            
            /*=====  End of Select2  ======*/

            /*=================================
            =            DataTable            =
            =================================*/
            
            
            let table = $('#posts-table').DataTable({
                dom: '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>',
                processing: true,
                serverSide: true,
                responsive: true,
                search: {regex: true},
                pagingType: "full_numbers",
                language: {
                    processing: '<i class="fas fa-circle-notch fa-spin fa-3x fa-fw text-primary"></i><span class="sr-only">Loading...</span>'
                },
                ajax: { 
                    url: URL + '/posts',
                        data: function (d) {

                            let tags = [];
                            $.each($('select[name="tags[]"]'), function (key,value){
                                let val = $(value).val();

                                if ($(this).parents('.tags').find('.or-and-toggle').is(':checked')) {
                                    val.push('OR');
                                }
                                tags.push(val);
                            })
                            d.tags = tags;

                            let domains = [0];
                            $.each($('input[name="domain[]"]:checked'), function (key,value){
                                domains.push($(value).val());
                            })
                            d.domains = domains;

                            let sentiments = [0];
                            $.each($('input[name="sentiments[]"]:checked'), function (key,value){
                                sentiments.push($(value).val());
                            })
                            d.sentiments = sentiments;

                            let genders = [0];
                            $.each($('input[name="genders[]"]:checked'), function (key,value){
                                genders.push($(value).val());
                            })
                            d.genders = genders;

                            let types = [0];
                            $.each($('input[name="types[]"]:checked'), function (key,value){
                                types.push($(value).val());
                            })
                            d.types = types;


                            d.authors = $('select[name="authors[]"]').val();
                            d.projects = $('select[name="projects[]"]').val();
                            d.range = $('#reportrange input').val();
                        }
                    },
                columns: [
                    { data: 'id', name: 'posts.id' },
                    { 
                        data: 'so_added_to_system',
                        name: 'posts.so_added_to_system',
                        render: function(data) {
                            let date = moment(data);
                            return date.format('DD.MM.YYYY. HH:mm');
                        }
                    },
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
                    { data: 'so_id', name: 'posts.so_id' },
                    { data: 'domain.name', name: 'domain.name' },
                    { data: 'type.name', name: 'type.name' },
                    { data: 'author.name', name: 'author.name' },
                    { data: 'author.author_id', name: 'author.author_id' },
                    { 
                        data: 'content',
                        name: 'posts.content',
                        render: function(data, type, row){
                            return data.substr( 0, 300 ) + '...';
                        },
                        orderable: false,
                        searchable: false 
                    },
                    { data: 'sentiment.icon', name: 'sentiment.icon' },
                    { data: 'project.name', name: 'project.name' },
                    { data: 'gender.icon', name: 'gender.icon' },
                    { data: 'link', name: 'posts.link', orderable: false, searchable: false },
                ],
            });
            
            /*=====  End of DataTable  ======*/


            /*=======================================
            =            Datepickerrange            =
            =======================================*/
            
            
            let start = moment("2020-02-21").startOf('day');
            let end = moment().startOf('23:59');

            function cb(start, end) {
                $('#reportrange input').val(start.format('DD.MM.YYYY. HH:mm') + ' - ' + end.format('DD.MM.YYYY. HH:mm'));
                table.draw();
            }

            $('#reportrange').daterangepicker({
                timePicker: true,
                timePicker24Hour: true,
                startDate: start,
                endDate: end,
                ranges: {
                   'Today': [moment().startOf('day'), moment()],
                   'Yesterday': [moment().subtract(1, 'days').startOf('day'), moment().subtract(1, 'days')],
                   'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                   'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                   'This Month': [moment().startOf('month'), moment().endOf('month')],
                   'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                locale: {
                  format: 'DD.MM.YYYY. HH:mm'
                }
            }, cb);

            cb(start, end);
            
            /*=====  End of Datepickerrange  ======*/
            

            // Filters events
            $('.filters, .or-and-toggle, .reportrange, .filter-icons, .filter-btns').change(function () {
                table.draw();
            });

            $('.filter-icons-labels, .filter-btns-labels').click(function (e) {
                $(this).toggleClass('opacity-5 grey-scale-100');
            });

            $('i.fa-caret-down').click(function(){
                $(this).parent().find('input').focus();
            })
        });
    </script>

@endpush