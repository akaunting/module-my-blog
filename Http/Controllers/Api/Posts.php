<?php

namespace Modules\MyBlog\Http\Controllers\Api;

use App\Abstracts\Http\ApiController;
use Modules\MyBlog\Http\Requests\Post as Request;
use Modules\MyBlog\Http\Resources\Post as Resource;
use Modules\MyBlog\Jobs\CreatePost;
use Modules\MyBlog\Jobs\DeletePost;
use Modules\MyBlog\Jobs\UpdatePost;
use Modules\MyBlog\Models\Post;

class Posts extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $posts = Post::with('category', 'comments')->collect();

        return Resource::collection($posts);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $post = Post::with('category', 'comments')->find($id);

        return new Resource($post);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $post = $this->dispatch(new CreatePost($request));

        return $this->created(route('api.my-blog.posts.show', $post->id), new Resource($post));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  $post
     * @param  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Post $post, Request $request)
    {
        $post = $this->dispatch(new UpdatePost($post, $request));

        return new Resource($post->fresh());
    }

    /**
     * Enable the specified resource in storage.
     *
     * @param  Post  $post
     * @return \Illuminate\Http\JsonResponse
     */
    public function enable(Post $post)
    {
        $post = $this->dispatch(new UpdatePost($post, request()->merge(['enabled' => 1])));

        return new Resource($post->fresh());
    }

    /**
     * Disable the specified resource in storage.
     *
     * @param  Post  $post
     * @return \Illuminate\Http\JsonResponse
     */
    public function disable(Post $post)
    {
        $post = $this->dispatch(new UpdatePost($post, request()->merge(['enabled' => 0])));

        return new Resource($post->fresh());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::with('comments')->find($id);

        try {
            $this->dispatch(new DeletePost($post));

            return $this->noContent();
        } catch(\Exception $e) {
            $this->errorUnauthorized($e->getMessage());
        }
    }
}
