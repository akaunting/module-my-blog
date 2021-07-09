<?php

namespace Modules\MyBlog\Widgets;

use App\Abstracts\Widget;
use Modules\MyBlog\Models\Post;

class TotalPosts extends Widget
{
    public $default_name = 'my-blog::widgets.total_posts';

    public $views = [
        'header' => 'partials.widgets.stats_header',
    ];

    public function show()
    {
        $query = Post::enabled();

        $total_posts = $this->applyFilters($query, ['date_field' => 'created_at'])->count();

        return $this->view('my-blog::widgets.total_posts', [
            'total_posts' => $total_posts,
        ]);
    }
}
