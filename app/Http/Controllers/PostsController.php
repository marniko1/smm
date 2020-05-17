<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
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
        

        // $posts = Post::select('*')
        // // ->where('firstname', 'like', "%$word%")
        // // ->orWhere('lastname', 'like', "%$word%")
        // ->with(['job' => function($query) {
        //                 $query->select('id', 'name');
        //         }])->get();

        // dd($posts);

         /*----------  Checks if request is AJAX  ----------*/
        

        if (request()->ajax()) {

            // $posts = Post::with('tags:category_id,name', 'tags.category:id,name')->select('posts.*')->chunk(100);
            // $posts = DB::table('posts')
            //         ->join('post_tag', 'posts.id', '=', 'post_tag.post_id')
            //         ->join('tags', 'tags.id', '=', 'post_tag.tag_id')
            //         ->join('categories', 'categories.id', '=', 'tags.category_id')
            //         ->join('domains', 'domains.id', '=', 'posts.domain_id')
            //         ->join('types', 'types.id', '=', 'posts.type_id')
            //         ->join('authors', 'authors.id', '=', 'posts.author_id')
            //         ->join('sentiments', 'sentiments.id', '=', 'posts.sentiment_id')
            //         ->join('projects', 'projects.id', '=', 'posts.project_id')
            //         ->join('genders', 'genders.id', '=', 'posts.gender_id')
            //         ->havingRaw('')
            //         ->select('posts.*', 'tags.name as tags', 'categories.name as category', 'domains.name as domain', 'types.name as type', 'authors.name as author', 'authors.id as authors_id', 'sentiments.icon as sentiment', 'projects.name as project', 'genders.icon as gender')
            //         // ->groupBy('posts.id')
            //         ->orderBy('posts.id');




                        // 'tags.category:id,name', 'domain:id,name', 'type:id,name', 'author:id,name,author_id', 'sentiment:id,icon', 'project:id,name', 'gender:id,icon');
            $posts = Post::select('posts.*')->with('tags:tags.id,category_id,name', 'tags.category:id,name', 'domain:id,name', 'type:id,name', 'author:id,name,author_id', 'sentiment:id,icon', 'project:id,name', 'gender:id,icon');

            if ($tags = request()->get('tags')) {


                //1 iz tabele post_tag nadjem sve post_id koji imaju svaki tag_id koji su dosli kroz request u array-u
                //2 onda modifikujem query sa whereIn pa array tih post_id

                $filtered_posts_ids = DB::table('post_tag')
                                        ->select('post_id')
                                        ->whereIn('tag_id', $tags)
                                        ->groupBy('post_id')
                                        ->havingRaw('COUNT(tag_id) = ?', [count($tags)])
                                        ->get()
                                        ->toArray();

                // var_dump($filtered_posts_ids);

                $posts_ids = array();

                foreach ($filtered_posts_ids as $key => $id) {
                    
                    array_push($posts_ids, $id->post_id);
                }

                $posts->whereIn('posts.id', $posts_ids);

                // foreach($selectedActivities as $activityId){
                //     $query->whereHas('activities', function($q) use ($activityId){
                //         $q->where('id', $activityId);
                //     });
                // }


                // $posts->having('count', '=', $tags);
                // $posts->having('count', $datatables->request->get('operator'), $post);

                // $count = count($tags);
                // $custom_filter = false;
                // $sql = '';
                // foreach ($tags as $key => $tag) {
                        

                //     if ($custom_filter) {
                //        $sql .= " AND";
                //     }
                //     $sql .= " SUM(tags.name = ?)";
                //     $custom_filter = true;

                // }
                // // $filtered_posts_ids = PostTag::with('post:id')->whereIn('posts.id', [''])
                // $posts->havingRaw($sql, [$tags]);

                 // $posts = Post::select('posts.*')->with('tags:tags.id,category_id,name', 'tags.category:id,name', 'domain:id,name', 'type:id,name', 'author:id,name,author_id', 'sentiment:id,icon', 'project:id,name', 'gender:id,icon')->havingRaw($sql, [$tags]);;
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
            ->setTotalRecords(Post::count())
            // ->setFilteredRecords(100)
            ->rawColumns(['link', 'gender.icon', 'sentiment.icon'])
            ->make();
        }

        $all_categories = Category::with('tags')->get();

        $categories_string = array();

        return view('posts')->with('all_categories', $all_categories);
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
