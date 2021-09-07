<?php

namespace Modules\MyBlog\Jobs;

use App\Abstracts\Job;
use App\Interfaces\Job\HasOwner;
use App\Interfaces\Job\HasSource;
use App\Interfaces\Job\ShouldCreate;
use Modules\MyBlog\Models\Comment;

class CreateComment extends Job implements HasOwner, HasSource, ShouldCreate
{
    public function handle(): Comment
    {
        \DB::transaction(function () {
            $this->model = Comment::create($this->request->all());
        });

        return $this->model;
    }
}
