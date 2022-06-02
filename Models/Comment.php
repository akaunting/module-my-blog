<?php

namespace Modules\MyBlog\Models;

use App\Abstracts\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;

    protected $table = 'my_blog_comments';

    protected $fillable = ['company_id', 'post_id', 'description', 'created_from', 'created_by'];

    /**
     * Sortable columns.
     *
     * @var array
     */
    public $sortable = ['post', 'description'];

    public function post()
    {
        return $this->belongsTo('Modules\MyBlog\Models\Post')->withDefault(['name' => trans('general.na')]);
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
            'url' => route('my-blog.comments.edit', $this->id),
            'permission' => 'update-my-blog-comments',
        ];

        $actions[] = [
            'type' => 'delete',
            'title' => trans_choice('my-blog::general.comments', 1),
            'icon' => 'delete',
            'route' => 'my-blog.comments.destroy',
            'permission' => 'delete-my-blog-comments',
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
        return \Modules\MyBlog\Database\Factories\Comment::new();
    }
}
