<?php

namespace Modules\MyBlog\Transformers;

use Modules\MyBlog\Models\Post as Model;
use App\Transformers\Setting\Category;
use League\Fractal\TransformerAbstract;

class Post extends TransformerAbstract
{
    /**
     * @var array
     */
    protected $defaultIncludes = ['category', 'comments'];

    /**
     * @param  Model $model
     * @return array
     */
    public function transform(Model $model)
    {
        return [
            'id' => $model->id,
            'company_id' => $model->company_id,
            'name' => $model->name,
            'description' => $model->description,
            'category_id' => $model->category_id,
            'enabled' => $model->enabled,
            'created_by' => $model->created_by,
            'created_at' => $model->created_at ? $model->created_at->toIso8601String() : '',
            'updated_at' => $model->updated_at ? $model->updated_at->toIso8601String() : '',
        ];
    }

    /**
     * @param  Model $model
     * @return mixed
     */
    public function includeCategory(Model $model)
    {
        if (!$model->category) {
            return $this->null();
        }

        return $this->item($model->category, new Category());
    }

    /**
     * @param  Model $model
     * @return mixed
     */
    public function includeComments(Model $model)
    {
        if (!$model->comments) {
            return $this->null();
        }

        return $this->collection($model->comments, new Comment());
    }
}
