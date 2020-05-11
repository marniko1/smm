<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
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
        
        // $posts = Post::with('tags', 'tags.category', 'domain', 'type', 'author', 'sentiment', 'project', 'gender')->get();

         /*----------  Checks if request is AJAX  ----------*/
        

        if (request()->ajax()) {

            /*----------  Make DataTable  ----------*/
            
            // return DataTables::of($posts)
            // ->addColumn('link', function ($post){
            //     return "<a class='nav-link' href='$post->link' target='_blank'>Link</a>";
            // })
            // ->addColumn('tags', function ($post) {
            //     $post_tags = '';

            //     foreach ($post->tags as $key => $tag) {
            //         $post_tags .= $tag->name . ', ';
            //     }

            //     $post_tags = rtrim($post_tags, ', ');

            //     return $post_tags;
            // })
            // ->addColumn('categories', function ($post) {
            //     $categories = '';

            //     foreach ($post->tags as $key => $tag) {
            //         $categories .= $tag->category->name . ', ';
            //     }

            //     $categories = rtrim($categories, ', ');

            //     return $categories;
            // })
            // ->rawColumns(['link'])
            // ->make();
        }   

        return view('posts');
        // return view('posts')->with('all_categories', $all_categories);
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
