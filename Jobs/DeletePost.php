<?php

namespace Modules\MyBlog\Jobs;

use App\Abstracts\Job;

class DeletePost extends Job
{
    protected $post;

    /**
     * Create a new job instance.
     *
     * @param  $post
     */
    public function __construct($post)
    {
        $this->post = $post;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        \DB::transaction(function () {
            $this->deleteRelationships($this->post, ['comments']);

            $this->post->delete();
        });

        return true;
    }
}
