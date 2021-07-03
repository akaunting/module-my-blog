<?php

namespace Modules\MyBlog\Http\Controllers;

use App\Abstracts\Http\Controller;
use App\Http\Requests\Common\Import as ImportRequest;
use Illuminate\Http\Response;
use Modules\MyBlog\Exports\Posts as Export;
use Modules\MyBlog\Http\Requests\Post as Request;
use Modules\MyBlog\Imports\Posts as Import;
use Modules\MyBlog\Jobs\CreatePost;
use Modules\MyBlog\Jobs\DeletePost;
use Modules\MyBlog\Jobs\UpdatePost;
use Modules\MyBlog\Models\Post;
use App\Models\Setting\Category;

class Posts extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $posts = Post::with('category', 'owner')->collect();

        return $this->response('my-blog::posts.index', compact('posts'));
    }

    /**
     * Show the form for viewing the specified resource.
     *
     * @return Response
     */
    public function show(Post $post)
    {
        $post->load('category', 'comments');

        $limit = (int) request('limit', setting('default.list_limit', '25'));
        $comments = $this->paginate($post->comments->sortByDesc('created_at'), $limit);

        return view('my-blog::posts.show', compact('post', 'comments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $categories = Category::type('post')->enabled()->orderBy('name')->take(setting('default.select_limit'))->pluck('name', 'id');

        return view('my-blog::posts.create', compact('categories'));
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
        $response = $this->ajaxDispatch(new CreatePost($request));

        if ($response['success']) {
            $response['redirect'] = route('my-blog.posts.index');

            $message = trans('messages.success.added', ['type' => trans_choice('my-blog::general.posts', 1)]);

            flash($message)->success();
        } else {
            $response['redirect'] = route('my-blog.posts.create');

            $message = $response['message'];

            flash($message)->error()->important();
        }

        return response()->json($response);
    }

    /**
     * Duplicate the specified resource.
     *
     * @param  Post  $post
     *
     * @return Response
     */
    public function duplicate(Post $post)
    {
        $clone = $post->duplicate();

        $message = trans('messages.success.duplicated', ['type' => trans_choice('my-blog::general.posts', 1)]);

        flash($message)->success();

        return redirect()->route('my-blog.posts.edit', $clone->id);
    }

    /**
     * Import the specified resource.
     *
     * @param  ImportRequest  $request
     *
     * @return Response
     */
    public function import(ImportRequest $request)
    {
        $response = $this->importExcel(new Import, $request, trans_choice('my-blog::general.posts', 2));

        if ($response['success']) {
            $response['redirect'] = route('my-blog.posts.index');

            flash($response['message'])->success();
        } else {
            $response['redirect'] = route('import.create', ['my-blog', 'posts']);

            flash($response['message'])->error()->important();
        }

        return response()->json($response);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Post $post
     *
     * @return Response
     */
    public function edit(Post $post)
    {
        $categories = Category::type('post')->enabled()->orderBy('name')->take(setting('default.select_limit'))->pluck('name', 'id');

        return view('my-blog::posts.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Post $post
     * @param  Request $request
     *
     * @return Response
     */
    public function update(Post $post, Request $request)
    {
        $response = $this->ajaxDispatch(new UpdatePost($post, $request));

        if ($response['success']) {
            $response['redirect'] = route('my-blog.posts.index');

            $message = trans('messages.success.updated', ['type' => $post->name]);

            flash($message)->success();
        } else {
            $response['redirect'] = route('my-blog.posts.edit', $post->id);

            $message = $response['message'];

            flash($message)->error()->important();
        }

        return response()->json($response);
    }

    /**
     * Enable the specified resource.
     *
     * @param  Post $post
     *
     * @return Response
     */
    public function enable(Post $post)
    {
        $response = $this->ajaxDispatch(new UpdatePost($post, request()->merge(['enabled' => 1])));

        if ($response['success']) {
            $response['message'] = trans('messages.success.enabled', ['type' => $post->name]);
        }

        return response()->json($response);
    }

    /**
     * Disable the specified resource.
     *
     * @param  Post $post
     *
     * @return Response
     */
    public function disable(Post $post)
    {
        $response = $this->ajaxDispatch(new UpdatePost($post, request()->merge(['enabled' => 0])));

        if ($response['success']) {
            $response['message'] = trans('messages.success.disabled', ['type' => $post->name]);
        }

        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Post $post
     *
     * @return Response
     */
    public function destroy(Post $post)
    {
        $response = $this->ajaxDispatch(new DeletePost($post));

        $response['redirect'] = route('my-blog.posts.index');

        if ($response['success']) {
            $message = trans('messages.success.deleted', ['type' => $post->name]);

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
        return $this->exportExcel(new Export, trans_choice('my-blog::general.posts', 2));
    }
}
