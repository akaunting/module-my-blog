<?php

namespace Modules\MyBlog\Providers;

use Illuminate\Support\ServiceProvider as Provider;
use Modules\MyBlog\Models\Comment;

class Observer extends Provider
{
    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        Comment::observe('Modules\MyBlog\Observers\Comment');
    }
}
