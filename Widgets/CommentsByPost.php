<?php

namespace Modules\MyBlog\Widgets;

use App\Abstracts\Widget;
use Modules\MyBlog\Models\Post;

class CommentsByPost extends Widget
{
    public $default_name = 'my-blog::widgets.comments_by_post';

    public $default_settings = [
        'width' => 'col-md-6',
    ];

    public function show()
    {
        $query = Post::withCount('comments')->enabled()->orderBy('comments_count', 'desc');

        $this->applyFilters($query, ['date_field' => 'created_at'])->each(function ($post) {
            $random_color = '#' . dechex(rand(0x000000, 0xFFFFFF));

            $this->addToDonut($random_color, $post->name, $post->comments_count);
        });

        $chart = $this->getDonutChart(trans('my-blog::widgets.comments_by_post'), 0, 160, 6);

        return $this->view('widgets.donut_chart', [
            'chart' => $chart,
        ]);
    }
}
