<?php

namespace Modules\MyBlog\Models;

use App\Abstracts\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;

    protected $table = 'my_blog_comments';

    protected $fillable = ['company_id', 'post_id', 'description', 'created_by'];

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
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return \Modules\MyBlog\Database\Factories\Comment::new();
    }
}
