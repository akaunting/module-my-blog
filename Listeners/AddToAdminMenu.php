<?php

namespace Modules\MyBlog\Listeners;

use App\Events\Menu\AdminCreated;
use App\Traits\Permissions;

class AddToAdminMenu
{
    use Permissions;

    /**
     * Handle the event.
     *
     * @param AdminCreated $event
     * @return void
     */
    public function handle(AdminCreated $event)
    {
        $menu = $event->menu;

        $attr = ['icon' => ''];

        $title = trim(trans('my-blog::general.name'));
        if ($this->canAccessMenuItem($title, ['read-my-blog-posts', 'read-my-blog-comments'])) {
            $menu->dropdown($title, function ($sub) use ($attr) {
                $title = trim(trans_choice('my-blog::general.posts', 2));
                if ($this->canAccessMenuItem($title, 'read-my-blog-posts')) {
                    $sub->route('my-blog.posts.index', $title, [], 10, $attr);
                }

                $title = trim(trans_choice('my-blog::general.comments', 2));
                if ($this->canAccessMenuItem($title, 'read-my-blog-comments')) {
                    $sub->route('my-blog.comments.index', $title, [], 20, $attr);
                }
            }, 15, [
                'title' => $title,
                'icon' => 'fa fa-pen',
            ]);
        }
    }
}
