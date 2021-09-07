<?php

namespace Modules\MyBlog\Jobs;

use App\Abstracts\Job;
use App\Interfaces\Job\HasOwner;
use App\Interfaces\Job\HasSource;
use App\Interfaces\Job\ShouldCreate;
use Modules\MyBlog\Models\Post;

class CreatePost extends Job implements HasOwner, HasSource, ShouldCreate
{
    public function handle(): Post
    {
        \DB::transaction(function () {
            $this->model = Post::create($this->request->all());
        });

        return $this->model;
    }
}
