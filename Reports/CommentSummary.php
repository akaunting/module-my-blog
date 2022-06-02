<?php

namespace Modules\MyBlog\Reports;

use App\Abstracts\Report;
use Modules\MyBlog\Models\Comment;

class CommentSummary extends Report
{
    public $default_name = 'my-blog::reports.comment_name';

    public $category = 'my-blog::general.name';

    public $type = 'summary';

    public $icon = 'chat';

    public $has_money = false;

    public function setData()
    {
        $query = Comment::with('post', 'owner');

        $comments = $this->applyFilters($query, ['date_field' => 'created_at'])->get();

        $this->setArithmeticTotals($comments, 'created_at');
    }

    public function getFields()
    {
        return [
            $this->getGroupField(),
            $this->getPeriodField(),
        ];
    }
}
