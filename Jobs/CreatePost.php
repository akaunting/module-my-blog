<?php

namespace Modules\MyBlog\Jobs;

use App\Abstracts\Job;
use Modules\MyBlog\Models\Post;

class CreatePost extends Job
{
    protected $post;

    protected $request;

    /**
     * Create a new job instance.
     *
     * @param  $request
     */
    public function __construct($request)
    {
        $this->request = $this->getRequestInstance($request);
        $this->request->merge(['created_by' => user_id()]);
    }

    /**
     * Execute the job.
     *
     * @return Post
     */
    public function handle()
    {
        \DB::transaction(function () {
            $this->post = Post::create($this->request->all());
        });

        return $this->post;
    }
}
