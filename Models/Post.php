<?php

namespace Modules\MyBlog\Models;

use App\Abstracts\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $table = 'my_blog_posts';

    protected $fillable = ['company_id', 'name', 'description', 'category_id', 'enabled', 'created_from', 'created_by'];

    /**
     * Sortable columns.
     *
     * @var array
     */
    public $sortable = ['name', 'category.name', 'description', 'enabled'];

    public function category()
    {
        return $this->belongsTo('App\Models\Setting\Category')->withDefault(['name' => trans('general.na')]);
    }

    public function comments()
    {
        return $this->hasMany('Modules\MyBlog\Models\Comment');
    }

    /**
     * Get the line actions.
     *
     * @return array
     */
    public function getLineActionsAttribute()
    {
        $actions = [];

        $actions[] = [
            'title' => trans('general.edit'),
            'icon' => 'edit',
            'url' => route('my-blog.posts.edit', $this->id),
            'permission' => 'update-my-blog-posts',
        ];

        $actions[] = [
            'title' => trans('general.duplicate'),
            'icon' => 'file_copy',
            'url' => route('my-blog.posts.duplicate', $this->id),
            'permission' => 'create-my-blog-posts',
        ];

        $actions[] = [
            'type' => 'delete',
            'title' => trans_choice('my-blog::general.posts', 1),
            'icon' => 'delete',
            'route' => 'my-blog.posts.destroy',
            'permission' => 'delete-my-blog-posts',
            'model' => $this,
        ];

        return $actions;
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return \Modules\MyBlog\Database\Factories\Post::new();
    }
}
