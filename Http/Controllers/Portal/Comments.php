<?php

namespace Modules\MyBlog\Http\Controllers\Portal;

use App\Abstracts\Http\Controller;
use Illuminate\Http\Response;
use Modules\MyBlog\Http\Requests\Comment as Request;
use Modules\MyBlog\Jobs\CreateComment;

class Comments extends Controller
{
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

        $response['redirect'] = route('portal.my-blog.posts.show', $request->get('post_id'));

        if ($response['success']) {
            $message = trans('messages.success.added', ['type' => trans_choice('my-blog::general.comments', 1)]);

            flash($message)->success();
        } else {
            $message = $response['message'];

            flash($message)->error()->important();
        }

        return response()->json($response);
    }
}
