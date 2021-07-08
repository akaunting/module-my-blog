<?php

namespace Modules\MyBlog\Http\Controllers\Api;

use App\Abstracts\Http\ApiController;
use Modules\MyBlog\Http\Requests\Comment as Request;
use Modules\MyBlog\Jobs\CreateComment;
use Modules\MyBlog\Jobs\DeleteComment;
use Modules\MyBlog\Jobs\UpdateComment;
use Modules\MyBlog\Models\Comment;
use Modules\MyBlog\Transformers\Comment as Transformer;

class Comments extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Dingo\Api\Http\Response
     */
    public function index()
    {
        $comments = Comment::collect();

        return $this->response->paginator($comments, new Transformer());
    }

    /**
     * Display the specified resource.
     *
     * @param  int|string  $id
     * @return \Dingo\Api\Http\Response
     */
    public function show(Comment $comment)
    {
        return $this->item($comment, new Transformer());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request
     * @return \Dingo\Api\Http\Response
     */
    public function store(Request $request)
    {
        $comment = $this->dispatch(new CreateComment($request));

        return $this->response->created(route('api.my-blog.comments.show', $comment->id), $this->item($comment, new Transformer()));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  $comment
     * @param  $request
     * @return \Dingo\Api\Http\Response
     */
    public function update(Comment $comment, Request $request)
    {
        $comment = $this->dispatch(new UpdateComment($comment, $request));

        return $this->item($comment->fresh(), new Transformer());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Comment  $comment
     * @return \Dingo\Api\Http\Response
     */
    public function destroy(Comment $comment)
    {
        try {
            $this->dispatch(new DeleteComment($comment));

            return $this->response->noContent();
        } catch(\Exception $e) {
            $this->response->errorUnauthorized($e->getMessage());
        }
    }
}
