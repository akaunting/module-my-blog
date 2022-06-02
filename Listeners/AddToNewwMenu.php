<?php
 namespace Modules\MyBlog\Listeners;

 use App\Events\Menu\NewwCreated;
 use App\Traits\Permissions;

 class AddToNewwMenu
 {
    use Permissions;

     /**
      * Handle the event.
      *
      * @param NewwCreated $event
      * @return void
      */
     public function handle(NewwCreated $event)
     {
        $menu = $event->menu;

        $title = trim(trans_choice('my-blog::general.posts', 1));
        if ($this->canAccessMenuItem($title, 'create-my-blog-posts')) {
            $menu->route('my-blog.posts.create', $title, [], 70, ['icon' => 'edit']);
        }

        $title = trim(trans_choice('my-blog::general.comments', 1));
        if ($this->canAccessMenuItem($title, 'create-my-blog-comments')) {
            $menu->route('my-blog.comments.create', $title, [], 71, ['icon' => 'chat']);
        }
     }
 }
