<?php

namespace Modules\MyBlog\Http\Controllers;

use App\Abstracts\Http\Controller;
use Illuminate\Http\Response;
use Modules\MyBlog\Exports\Comments as Export;
use Modules\MyBlog\Http\Requests\Comment as Request;
use Modules\MyBlog\Jobs\CreateComment;
use Modules\MyBlog\Jobs\DeleteComment;
use Modules\MyBlog\Jobs\UpdateComment;
use Modules\MyBlog\Models\Comment;
use Modules\MyBlog\Models\Post;

class Comments extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $comments = Comment::with('post')->collect(['created_at' => 'desc']);

        return $this->response('my-blog::comments.index', compact('comments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $posts = Post::orderBy('name')->take(setting('default.select_limit'))->pluck('name', 'id');

        return view('my-blog::comments.create', compact('posts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $response = $this->ajaxDispatch(new CreateComment($request));

        if ($response['success']) {
            $response['redirect'] = route('my-blog.comments.index');

            $message = trans('messages.success.added', ['type' => trans_choice('my-blog::general.comments', 1)]);

            flash($message)->success();
        } else {
            $response['redirect'] = route('my-blog.comments.create');

            $message = $response['message'];

            flash($message)->error()->important();
        }

        return response()->json($response);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Comment $comment
     *
     * @return Response
     */
    public function edit(Comment $comment)
    {
        $posts = Post::orderBy('name')->take(setting('default.select_limit'))->pluck('name', 'id');

        return view('my-blog::comments.edit', compact('comment', 'posts'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Comment $comment
     * @param  Request $request
     *
     * @return Response
     */
    public function update(Comment $comment, Request $request)
    {
        $response = $this->ajaxDispatch(new UpdateComment($comment, $request));

        if ($response['success']) {
            $response['redirect'] = route('my-blog.comments.index');

            $message = trans('messages.success.updated', ['type' => $comment->id]);

            flash($message)->success();
        } else {
            $response['redirect'] = route('my-blog.comments.edit', $comment->id);

            $message = $response['message'];

            flash($message)->error()->important();
        }

        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Comment $comment
     *
     * @return Response
     */
    public function destroy(Comment $comment)
    {
        $response = $this->ajaxDispatch(new DeleteComment($comment));

        $response['redirect'] = route('my-blog.comments.index');

        if ($response['success']) {
            $message = trans('messages.success.deleted', ['type' => $comment->id]);

            flash($message)->success();
        } else {
            $message = $response['message'];

            flash($message)->error()->important();
        }

        return response()->json($response);
    }

    /**
     * Export the specified resource.
     *
     * @return Response
     */
    public function export()
    {
        return $this->exportExcel(new Export, trans_choice('my-blog::general.comments', 2));
    }
}
