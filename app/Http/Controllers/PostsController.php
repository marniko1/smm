<?php

namespace App\Http\Controllers;

use App\Author;
use App\Category;
use App\Domain;
use App\Gender;
use App\Post;
use App\Project;
use App\Sentiment;
use App\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        

         /*----------  Checks if request is AJAX  ----------*/
        

        if (request()->ajax()) {

            $posts = Post::select('posts.*')->with('tags:tags.id,category_id,name', 'tags.category:id,name', 'domain:id,name', 'type:id,name', 'author:id,name,author_id', 'sentiment:id,icon', 'project:id,name', 'gender:id,icon');

            if ($tags = request()->get('tags')) {
                //dd($tags);
                // flatten tags array
                $tags_flat = array();
                array_walk_recursive($tags, function($v) use(&$tags_flat){
                    $tags_flat[] = $v;
                });

                if(in_array("OR",$tags_flat)){   // check if OR is submitted anywhere
                    $or_in_post = 1;
                    $tags_flat = array_diff($tags_flat,array("OR"));
                }

                $posts_ids =  DB::table('post_tag')
                            ->whereIn('tag_id', $tags_flat)
                            ->groupBy('post_id');

                if (!empty($tags_flat)) {
                    
                    //there is OR in submitted data so cretae AND OR query
                    if(@$or_in_post==1){

                        foreach($tags as $tag){

                            //there is OR in tags subarray
                            if(in_array("OR",$tag) && count($tag)>1 ){

                                $orarr = array();
                                foreach(array_diff($tag,array("OR")) as $v){
                                    $orarr[] = " FIND_IN_SET( ? ,GROUP_CONCAT(tag_id)) ";
                                }
                                $posts_ids->havingRaw(' ( '.implode(" OR ",$orarr).' ) ', array_diff($tag,array("OR"))  );

                            } else if(!in_array("OR",$tag) && count($tag)>0) {

                                //there is no OR in tags subarray
                                $orarr = array();
                                foreach($tag as $v){
                                    $orarr[] = " FIND_IN_SET( ? ,GROUP_CONCAT(tag_id)) ";
                                }
                                $posts_ids->havingRaw('  '.implode(" AND ",$orarr).'  ', array($tag) );
                            }
                        }

                    } else {

                        //there is no OR in submitted data so do AND search
                        $posts_ids->havingRaw('COUNT(tag_id) = ?', array( count($tags_flat) ) );
                    }

                    $posts_ids = $posts_ids->pluck('post_id');
                    $posts_ids = $posts_ids->toArray();
                    $posts->whereIn('posts.id', $posts_ids);
                }

            }


            if ($domains = request()->get('domains')) {

                $posts->whereIn('domain_id', $domains);
            }

            if ($types = request()->get('types')) {

                $posts->whereIn('type_id', $types);
            }

            if ($authors = request()->get('authors')) {

                $posts->whereIn('author_id', $authors);
            }

            if ($sentiments = request()->get('sentiments')) {

                $posts->whereIn('sentiment_id', $sentiments);
            }

            if ($projects = request()->get('projects')) {

                $posts->whereIn('project_id', $projects);
            }

            if ($genders = request()->get('genders')) {

                $posts->whereIn('gender_id', $genders);
            }



            /*----------  Make DataTable  ----------*/
            
            return DataTables::of($posts)
            ->addColumn('link', function ($post){
                return "<a class='nav-link' href='$post->link' target='_blank'>Link</a>";
            })
            ->addColumn('tags', function ($post) {

                $post_tags = '';

                foreach ($post->tags as $key => $tag) {
                    $post_tags .= $tag->name . ', ';
                }

                $post_tags = rtrim($post_tags, ', ');

                return $post_tags;
            })
            // ->filterColumn('tags.name', function($query, $keyword) {

            //         var_dump($query->bindings);
            //         $sql = "CONCAT(users.first_name,'-',users.last_name)  like ?";
            //         // $query->whereRaw($sql, ["%{$keyword}%"]);
            //     })
        //     ->filter(function ($query) use ($posts) {

        //         // $query = $posts;

        //         if (request()->get('cats')) {

        //             $query->whereIn('posts.id', [46,47,48,49,50,51,52,53,54,55,56]);

        //         //     $cats = request()->get('cats');

        //         //     $custom_filter = false;

        //         //     $sql = "SELECT p.* FROM posts as p INNER JOIN post_tag as pt ON  p.id = pt.post_id INNER JOIN tags as t ON pt.tag_id = t.id GROUP BY p.id HAVING";

        //         //     foreach ($cats as $key => $cat) {
                        

        //         //             if ($custom_filter) {
        //         //                $sql .= " AND";
        //         //             }
        //         //             $sql .= " SUM(t.name = '$cat')";
        //         //             $custom_filter = true;

        //         //     }
                    
        //         //    return $posts->raw($sql);
        //         // }

        //         // $columns = request()->all()['columns'];

        //         // $custom_filter = false;

        //         // $sql = "";

        //         // foreach ($columns as $key => $column) {
        //         //     if ($column['search']['value'] && $column['name'] == 'tags.name') {

        //         //         $value = $column['search']['value'];

        //         //         if ($custom_filter) {
        //         //            $sql .= " AND";
        //         //         }
        //         //         $sql .= " SUM(LOWER(t.name) = '$value')";
        //         //         $custom_filter = true;

        //         //     }
        //         // }

        //         // if ($custom_filter) {

        //         //     // var_dump($query->getQuery()->bindings);
                    
        //         //     $query->havingRaw($sql);
        //         // }
        //         // var_dump(request()->all());
        //     // if (request()->has('content')) {
        //     //     var_dump('taj je');
        //         // $query->whereHas('signs', function($q) use($sign){
        //         //     $q->where('sign', $sign);
        //         // });
        //     }
        // }, true)
            // ->setTotalRecords(Post::count())
            // ->setFilteredRecords(100)
            ->rawColumns(['link', 'gender.icon', 'sentiment.icon'])
            ->make();
        }

        // $filters = array();

        $all_categories = Category::with('tags')->get();


        // $filters[] = Domain::all();
        // $filters[] = Type::all();
        // $filters[] = Author::all();
        // $filters[] = Sentiment::all();
        // $filters[] = Project::all();
        // $filters[] = Gender::all();


        $all_domains = Domain::all();
        $all_types = Type::all();
        $all_authors = Author::all();
        $all_sentiments = Sentiment::all();
        $all_projects = Project::all();
        $all_genders = Gender::all();



        // return view('posts')->with(['all_categories' => $all_categories, 'filters' => $filters]);
        return view('posts')->with(['all_categories' => $all_categories, 'all_domains' => $all_domains, 'all_types' => $all_types, 'all_authors' => $all_authors, 'all_sentiments' => $all_sentiments, 'all_projects' => $all_projects, 'all_genders' => $all_genders]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
