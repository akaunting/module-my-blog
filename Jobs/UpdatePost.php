<?php

namespace Modules\MyBlog\Jobs;

use App\Abstracts\Job;
use Modules\MyBlog\Models\Post;

class UpdatePost extends Job
{
    protected $post;

    protected $request;

    /**
     * Create a new job instance.
     *
     * @param  $post
     * @param  $request
     */
    public function __construct($post, $request)
    {
        $this->post = $post;
        $this->request = $this->getRequestInstance($request);
    }

    /**
     * Execute the job.
     *
     * @return Post
     */
    public function handle()
    {
        \DB::transaction(function () {
            $this->post->update($this->request->all());
        });

        return $this->post;
    }
}
