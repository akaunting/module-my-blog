<?php

namespace Modules\MyBlog\Reports;

use App\Abstracts\Report;
use Modules\MyBlog\Models\Post;

class PostSummary extends Report
{
    public $default_name = 'my-blog::reports.post_name';

    public $category = 'my-blog::general.name';

    public $type = 'summary';

    public $icon = 'edit';

    public $has_money = false;

    public function setData()
    {
        $query = Post::with('category', 'owner')->enabled();

        $posts = $this->applyFilters($query, ['date_field' => 'created_at'])->get();

        $this->setArithmeticTotals($posts, 'created_at');
    }

    public function getFields()
    {
        return [
            $this->getGroupField(),
            $this->getPeriodField(),
        ];
    }
}
