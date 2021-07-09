<?php

namespace Modules\MyBlog\Widgets;

use App\Abstracts\Widget;
use App\Models\Auth\User;

class TopAuthors extends Widget
{
    public $default_name = 'my-blog::widgets.top_authors';

    public function show()
    {
        $query = User::withCount('my_blog_posts')->orderBy('my_blog_posts_count', 'desc');

        $authors = $query->whereHas('my_blog_posts', function ($query) {
            $this->applyFilters($query, ['date_field' => 'created_at']);
        })->get();

        return $this->view('my-blog::widgets.top_authors', [
            'authors' => $authors,
        ]);
    }
}
