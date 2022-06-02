<?php

namespace Modules\MyBlog\Widgets;

use App\Abstracts\Widget;
use Modules\MyBlog\Models\Post;

class LatestPosts extends Widget
{
    public $default_name = 'my-blog::widgets.latest_posts';

    public $default_settings = [
        'width' => 'w-full lg:w-1/3 px-6',
    ];

    public $description = 'my-blog::widgets.description.latest_posts';

    public $report_class = 'Modules\MyBlog\Reports\PostSummary';

    public function show()
    {
        $query = Post::with('category')->enabled()->orderBy('created_at', 'desc')->take(5);

        $posts = $this->applyFilters($query, ['date_field' => 'created_at'])->get();

        return $this->view('my-blog::widgets.latest_posts', [
            'posts' => $posts,
        ]);
    }
}
