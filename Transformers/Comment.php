<?php

namespace Modules\MyBlog\Transformers;

use Modules\MyBlog\Models\Comment as Model;
use League\Fractal\TransformerAbstract;

class Comment extends TransformerAbstract
{
    /**
     * @var array
     */
    protected $defaultIncludes = [];

    /**
     * @param  Model $model
     * @return array
     */
    public function transform(Model $model)
    {
        return [
            'id' => $model->id,
            'company_id' => $model->company_id,
            'post_id' => $model->post_id,
            'description' => $model->description,
            'created_by' => $model->created_by,
            'created_at' => $model->created_at ? $model->created_at->toIso8601String() : '',
            'updated_at' => $model->updated_at ? $model->updated_at->toIso8601String() : '',
        ];
    }
}
