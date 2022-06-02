<?php

namespace Modules\MyBlog\Http\Controllers\Api;

use App\Abstracts\Http\ApiController;
use Modules\MyBlog\Http\Requests\Comment as Request;
use Modules\MyBlog\Http\Resources\Comment as Resource;
use Modules\MyBlog\Jobs\CreateComment;
use Modules\MyBlog\Jobs\DeleteComment;
use Modules\MyBlog\Jobs\UpdateComment;
use Modules\MyBlog\Models\Comment;

class Comments extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $comments = Comment::collect();

        return Resource::collection($comments);
    }

    /**
     * Display the specified resource.
     *
     * @param  int|string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Comment $comment)
    {
        return new Resource($comment);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $comment = $this->dispatch(new CreateComment($request));

        return $this->created(route('api.my-blog.comments.show', $comment->id), new Resource($comment));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  $comment
     * @param  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Comment $comment, Request $request)
    {
        $comment = $this->dispatch(new UpdateComment($comment, $request));

        return new Resource($comment->fresh());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        try {
            $this->dispatch(new DeleteComment($comment));

            return $this->noContent();
        } catch(\Exception $e) {
            $this->errorUnauthorized($e->getMessage());
        }
    }
}
