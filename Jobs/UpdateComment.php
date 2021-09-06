<?php

namespace Modules\MyBlog\Jobs;

use App\Abstracts\Job;
use App\Interfaces\Job\ShouldUpdate;
use Modules\MyBlog\Models\Comment;

class UpdateComment extends Job implements ShouldUpdate
{
    public function handle(): Comment
    {
        \DB::transaction(function () {
            $this->model->update($this->request->all());
        });

        return $this->model;
    }
}
