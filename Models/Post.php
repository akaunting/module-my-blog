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
    public $sortable = ['name', 'category', 'description', 'enabled'];

    public function category()
    {
        return $this->belongsTo('App\Models\Setting\Category')->withDefault(['name' => trans('general.na')]);
    }

    public function comments()
    {
        return $this->hasMany('Modules\MyBlog\Models\Comment');
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
