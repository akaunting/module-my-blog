<?php

namespace Modules\MyBlog\Exports;

use App\Abstracts\Export;
use Modules\MyBlog\Models\Post as Model;

class Posts extends Export
{
    public function collection()
    {
        return Model::with('category', 'owner')->collectForExport($this->ids);
    }

    public function map($model): array
    {
        $model->author_name = $model->owner->name;
        $model->category_name = $model->category->name;

        return parent::map($model);
    }

    public function fields(): array
    {
        return [
            'name',
            'description',
            'author_name',
            'category_name',
            'enabled',
        ];
    }
}
