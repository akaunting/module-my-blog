<?php

namespace Modules\MyBlog\Jobs;

use App\Abstracts\Job;
use Modules\MyBlog\Models\Comment;

class UpdateComment extends Job
{
    protected $comment;

    protected $request;

    /**
     * Create a new job instance.
     *
     * @param  $post
     * @param  $comment
     * @param  $request
     */
    public function __construct($comment, $request)
    {
        $this->comment = $comment;
        $this->request = $this->getRequestInstance($request);
        $this->request->merge(['created_by' => user_id()]);
    }

    /**
     * Execute the job.
     *
     * @return Comment
     */
    public function handle()
    {
        \DB::transaction(function () {
            $this->comment->update($this->request->all());
        });

        return $this->comment;
    }
}
