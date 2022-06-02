<?php

namespace Modules\MyBlog\Widgets;

use App\Abstracts\Widget;
use Modules\MyBlog\Models\Comment;

class LatestComments extends Widget
{
    public $default_name = 'my-blog::widgets.latest_comments';

    public $default_settings = [
        'width' => 'w-full lg:w-1/3 px-6',
    ];

    public $description = 'my-blog::widgets.description.latest_comments';

    public $report_class = 'Modules\MyBlog\Reports\CommentSummary';

    public function show()
    {
        $query = Comment::with('owner')->orderBy('created_at', 'desc')->take(5);

        $comments = $this->applyFilters($query, ['date_field' => 'created_at'])->get();

        return $this->view('my-blog::widgets.latest_comments', [
            'comments' => $comments,
        ]);
    }
}
