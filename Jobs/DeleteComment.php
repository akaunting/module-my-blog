<?php

namespace Modules\MyBlog\Jobs;

use App\Abstracts\Job;

class DeleteComment extends Job
{
    protected $comment;

    /**
     * Create a new job instance.
     *
     * @param  $comment
     */
    public function __construct($comment)
    {
        $this->comment = $comment;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        \DB::transaction(function () {
            $this->comment->delete();
        });

        return true;
    }
}
