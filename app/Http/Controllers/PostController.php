<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class PostController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $posts = DB::table('posts') 
        //             -> select('id','title', 'content', 'created_at')
        //             -> get();
                    
        $posts = Post::get();
        // dd($posts);
        $view_data = [
            'posts' => $posts
        ];

        return view('posts.index', $view_data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $title = $request -> input('title');
        $content = $request -> input('content');

        Post::insert(
            [
                'title' => $title,
                'content' => $content,
                'created_at' => date('Y-M-d H:i:s'),
                'updated_at' => date('Y-M-d H:i:s'),
            ]
        );

        return redirect('posts');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $selected_post = Post::where('id',$id) -> first();

        // dd($selected_post);

        $view_data = [
            'post' => $selected_post
        ];

        return view('posts.show', $view_data);



    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $selected_post = Post::where('id', $id)-> first();

        // dd($selected_post);

        $view_data = [
            'post' => $selected_post
        ];

        return view('posts.edit', $view_data);
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
        $title = $request -> input('title');
        $content = $request -> input('content');

        Post::where('id', $id)
        -> update(
            [
                'title' => $title,
                'content' => $content,
                'updated_at' => date('Y-M-d H:i:s'),
            ]
        );

        return redirect("posts/{$id}");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Post::where('id', $id)
        -> delete();

        return redirect("posts");
    }
}
