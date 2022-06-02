<?php

namespace Modules\MyBlog\Http\Resources;

use App\Http\Resources\Setting\Category;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\MyBlog\Http\Resources\Comment;

class Post extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'company_id' => $this->company_id,
            'name' => $this->name,
            'description' => $this->description,
            'category_id' => $this->category_id,
            'enabled' => $this->enabled,
            'created_by' => $this->created_by,
            'created_from' => $this->created_from,
            'created_at' => $this->created_at ? $this->created_at->toIso8601String() : '',
            'updated_at' => $this->updated_at ? $this->updated_at->toIso8601String() : '',
            'category' => new Category($this->category),
            'comments' => [static::$wrap => Comment::collection($this->comments)],
        ];
    }
}
