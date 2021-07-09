<?php

namespace Modules\MyBlog\Widgets;

use App\Abstracts\Widget;
use Modules\MyBlog\Models\Comment;

class LatestComments extends Widget
{
    public $default_name = 'my-blog::widgets.latest_comments';

    public function show()
    {
        $query = Comment::with('owner')->orderBy('created_at', 'desc')->take(5);

        $comments = $this->applyFilters($query, ['date_field' => 'created_at'])->get();

        return $this->view('my-blog::widgets.latest_comments', [
            'comments' => $comments,
        ]);
    }
}
