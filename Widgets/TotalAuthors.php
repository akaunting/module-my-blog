<?php

namespace Modules\MyBlog\Widgets;

use App\Abstracts\Widget;
use App\Models\Auth\User;

class TotalAuthors extends Widget
{
    public $default_name = 'my-blog::widgets.total_authors';

    public $views = [
        'header' => 'partials.widgets.stats_header',
    ];

    public function show()
    {
        $query = User::query();

        $total_authors = $query->whereHas('my_blog_posts', function ($query) {
            $this->applyFilters($query, ['date_field' => 'created_at']);
        })->count();

        return $this->view('my-blog::widgets.total_authors', [
            'total_authors' => $total_authors,
        ]);
    }
}
