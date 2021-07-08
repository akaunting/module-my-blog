<?php

namespace Modules\MyBlog\Http\Controllers\Api;

use App\Abstracts\Http\ApiController;
use Modules\MyBlog\Http\Requests\Post as Request;
use Modules\MyBlog\Jobs\CreatePost;
use Modules\MyBlog\Jobs\DeletePost;
use Modules\MyBlog\Jobs\UpdatePost;
use Modules\MyBlog\Models\Post;
use Modules\MyBlog\Transformers\Post as Transformer;

class Posts extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Dingo\Api\Http\Response
     */
    public function index()
    {
        $posts = Post::with('category', 'comments')->collect();

        return $this->response->paginator($posts, new Transformer());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Dingo\Api\Http\Response
     */
    public function show($id)
    {
        $post = Post::with('category', 'comments')->find($id);

        return $this->item($post, new Transformer());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request
     * @return \Dingo\Api\Http\Response
     */
    public function store(Request $request)
    {
        $post = $this->dispatch(new CreatePost($request));

        return $this->response->created(route('api.my-blog.posts.show', $post->id), $this->item($post, new Transformer()));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  $post
     * @param  $request
     * @return \Dingo\Api\Http\Response
     */
    public function update(Post $post, Request $request)
    {
        $post = $this->dispatch(new UpdatePost($post, $request));

        return $this->item($post->fresh(), new Transformer());
    }

    /**
     * Enable the specified resource in storage.
     *
     * @param  Post  $post
     * @return \Dingo\Api\Http\Response
     */
    public function enable(Post $post)
    {
        $post = $this->dispatch(new UpdatePost($post, request()->merge(['enabled' => 1])));

        return $this->item($post->fresh(), new Transformer());
    }

    /**
     * Disable the specified resource in storage.
     *
     * @param  Post  $post
     * @return \Dingo\Api\Http\Response
     */
    public function disable(Post $post)
    {
        $post = $this->dispatch(new UpdatePost($post, request()->merge(['enabled' => 0])));

        return $this->item($post->fresh(), new Transformer());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Dingo\Api\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::with('comments')->find($id);

        try {
            $this->dispatch(new DeletePost($post));

            return $this->response->noContent();
        } catch(\Exception $e) {
            $this->response->errorUnauthorized($e->getMessage());
        }
    }
}
