<?php

namespace Modules\MyBlog\Jobs;

use App\Abstracts\Job;
use App\Interfaces\Job\ShouldDelete;

class DeletePost extends Job implements ShouldDelete
{
    public function handle(): bool
    {
        \DB::transaction(function () {
            $this->deleteRelationships($this->model, ['comments']);

            $this->model->delete();
        });

        return true;
    }
}
