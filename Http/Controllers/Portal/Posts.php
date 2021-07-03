<?php

namespace Modules\MyBlog\Http\Controllers\Portal;

use App\Abstracts\Http\Controller;
use Illuminate\Http\Response;
use Modules\MyBlog\Models\Post;

class Posts extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $posts = Post::with('category')->enabled()->collect();

        return $this->response('my-blog::portal.posts.index', compact('posts'));
    }

    /**
     * Show the form for viewing the specified resource.
     *
     * @return Response
     */
    public function show(Post $post)
    {
        $post->load('comments');

        return view('my-blog::portal.posts.show', compact('post'));
    }
}
