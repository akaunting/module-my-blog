<?php

namespace Modules\MyBlog\Widgets;

use App\Abstracts\Widget;
use App\Models\Setting\Category;

class PostsByCategory extends Widget
{
    public $default_name = 'my-blog::widgets.posts_by_category';

    public $description = 'my-blog::widgets.description.posts_by_category';

    public $report_class = 'Modules\MyBlog\Reports\PostSummary';

    public function show()
    {
        $query = Category::withCount('my_blog_posts')->type('post')->orderBy('my_blog_posts_count', 'desc');

        $query->whereHas('my_blog_posts', function ($query) {
            $this->applyFilters($query, ['date_field' => 'created_at']);
        })->each(function ($category) {
            $this->addToDonut($category->color, $category->name, $category->my_blog_posts_count);
        });

        $chart = $this->getDonutChart(trans('my-blog::widgets.posts_by_category'), 0, 160, 6);

        return $this->view('widgets.donut_chart', [
            'chart' => $chart,
        ]);
    }
}
