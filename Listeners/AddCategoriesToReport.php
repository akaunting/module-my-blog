<?php

namespace Modules\MyBlog\Listeners;

use App\Abstracts\Listeners\Report as Listener;
use App\Events\Report\FilterShowing;
use App\Events\Report\GroupShowing;
use App\Events\Report\RowsShowing;

class AddCategoriesToReport extends Listener
{
    protected $classes = [
        'Modules\MyBlog\Reports\PostSummary',
    ];

    /**
     * Handle filter showing event.
     *
     * @param  $event
     * @return void
     */
    public function handleFilterShowing(FilterShowing $event)
    {
        if ($this->skipThisClass($event)) {
            return;
        }

        $event->class->filters['categories'] = $this->getCategories('post', true);
        $event->class->filters['routes']['categories'] = ['categories.index', 'search=type:post'];
    }

    /**
     * Handle group showing event.
     *
     * @param  $event
     * @return void
     */
    public function handleGroupShowing(GroupShowing $event)
    {
        if ($this->skipThisClass($event)) {
            return;
        }

        $event->class->groups['category'] = trans_choice('general.categories', 1);
    }

    /**
     * Handle rows showing event.
     *
     * @param  $event
     * @return void
     */
    public function handleRowsShowing(RowsShowing $event)
    {
        if ($this->skipRowsShowing($event, 'category')) {
            return;
        }

        $all_categories = $this->getCategories('post');

        if ($category_ids = $this->getSearchStringValue('category_id')) {
            $categories = explode(',', $category_ids);

            $rows = collect($all_categories)->filter(function ($value, $key) use ($categories) {
                return in_array($key, $categories);
            });
        } else {
            $rows = $all_categories;
        }

        $this->setRowNamesAndValues($event, $rows);
    }
}
