<?php

namespace Modules\MyBlog\Exports;

use App\Abstracts\Export;
use Modules\MyBlog\Models\Comment as Model;

class Comments extends Export
{
    public function collection()
    {
        return Model::with('post', 'owner')->collectForExport($this->ids);
    }

    public function map($model): array
    {
        $model->author_name = $model->owner->name;
        $model->post_name = $model->post->name;

        return parent::map($model);
    }

    public function fields(): array
    {
        return [
            'post_name',
            'description',
            'author_name',
        ];
    }
}
