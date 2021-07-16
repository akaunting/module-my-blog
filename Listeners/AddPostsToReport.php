<?php

namespace Module\MyBlog\Listeners;

use App\Abstracts\Listeners\Report as Listener;
use App\Events\Report\FilterShowing;
use App\Events\Report\GroupShowing;
use App\Events\Report\RowsShowing;
use Modules\MyBlog\Models\Post;

class AddPostsToReport extends Listener
{
    protected $classes = [
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

        $event->class->filters['posts'] = $this->getPosts(true);
        $event->class->filters['routes']['posts'] = 'my-blog.posts.index';
        $event->class->filters['names']['posts'] = trans_choice('my-blog::general.posts', 1);
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

        $event->class->groups['post'] = trans_choice('my-blog::general.posts', 1);
    }

    /**
     * Handle rows showing event.
     *
     * @param  $event
     * @return void
     */
    public function handleRowsShowing(RowsShowing $event)
    {
        if ($this->skipRowsShowing($event, 'post')) {
            return;
        }

        $all_posts = $this->getPosts();

        if ($post_ids = $this->getSearchStringValue('post_id')) {
            $posts = explode(',', $post_ids);

            $rows = collect($all_posts)->filter(function ($value, $key) use ($posts) {
                return in_array($key, $posts);
            });
        } else {
            $rows = $all_posts;
        }

        $this->setRowNamesAndValues($event, $rows);
    }

    public function getPosts($limit = false)
    {
        $model = Post::whereHas('comments');

        if ($limit !== false) {
            $model->take(setting('default.select_limit'));
        }

        return $model->pluck('name', 'id')->toArray();
    }
}
