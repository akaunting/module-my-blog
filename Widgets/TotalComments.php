<?php

namespace Modules\MyBlog\Widgets;

use App\Abstracts\Widget;
use Modules\MyBlog\Models\Comment;

class TotalComments extends Widget
{
    public $default_name = 'my-blog::widgets.total_comments';

    public $views = [
        'header' => 'partials.widgets.stats_header',
    ];

    public function show()
    {
        $query = Comment::query();

        $total_comments = $this->applyFilters($query, ['date_field' => 'created_at'])->count();

        return $this->view('my-blog::widgets.total_comments', [
            'total_comments' => $total_comments,
        ]);
    }
}
