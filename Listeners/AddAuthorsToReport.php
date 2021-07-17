<?php

namespace Modules\MyBlog\Listeners;

use App\Abstracts\Listeners\Report as Listener;
use App\Events\Report\FilterApplying;
use App\Events\Report\FilterShowing;
use App\Events\Report\GroupApplying;
use App\Events\Report\GroupShowing;
use App\Events\Report\RowsShowing;
use App\Models\Auth\User;

class AddAuthorsToReport extends Listener
{
    protected $classes = [
        'Modules\MyBlog\Reports\PostSummary',
        'Modules\MyBlog\Reports\CommentSummary',
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

        $event->class->filters['authors'] = $this->getAuthors($event, true);
        $event->class->filters['routes']['authors'] = 'users.index';
        $event->class->filters['names']['authors'] = trans_choice('my-blog::general.authors', 1);
    }

    /**
     * Handle filter applying event.
     *
     * @param  $event
     * @return void
     */
    public function handleFilterApplying(FilterApplying $event)
    {
        if ($this->skipThisClass($event)) {
            return;
        }

        $author_id = $this->getSearchStringValue('author_id');

        if (empty($author_id)) {
            return;
        }

        $event->model->where('created_by', $author_id);
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

        $event->class->groups['author'] = trans_choice('my-blog::general.authors', 1);
    }

    /**
     * Handle group applying event.
     *
     * @param  $event
     * @return void
     */
    public function handleGroupApplying(GroupApplying $event)
    {
        if ($this->skipThisClass($event)) {
            return;
        }

        $event->model->author_id = $event->model->created_by;
    }

    /**
     * Handle rows showing event.
     *
     * @param  $event
     * @return void
     */
    public function handleRowsShowing(RowsShowing $event)
    {
        if ($this->skipRowsShowing($event, 'author')) {
            return;
        }

        $all_authors = $this->getAuthors($event);

        if ($author_ids = $this->getSearchStringValue('author_id')) {
            $authors = explode(',', $author_ids);

            $rows = collect($all_authors)->filter(function ($value, $key) use ($authors) {
                return in_array($key, $authors);
            });
        } else {
            $rows = $all_authors;
        }

        $this->setRowNamesAndValues($event, $rows);
    }

    public function getAuthors($event, $limit = false)
    {
        $relation_name = (class_basename($event->class) == 'PostSummary') ? 'my_blog_posts' : 'my_blog_comments';

        $model = User::whereHas($relation_name);

        if ($limit !== false) {
            $model->take(setting('default.select_limit'));
        }

        return $model->pluck('name', 'id')->toArray();
    }
}
