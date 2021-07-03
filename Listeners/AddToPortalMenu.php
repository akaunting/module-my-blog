<?php
 namespace Modules\MyBlog\Listeners;

 use App\Events\Menu\PortalCreated;

 class AddToPortalMenu
 {
     /**
      * Handle the event.
      *
      * @param PortalCreated $event
      * @return void
      */
     public function handle(PortalCreated $event)
     {
        if (user()->cannot('read-my-blog-portal-posts')) {
            return;
        }

        $event->menu->add([
            'route' => ['portal.my-blog.posts.index', []],
            'title' => trans_choice('my-blog::general.posts', 2),
            'icon' => 'fas fa-pen',
            'order' => 40,
        ]);
     }
 }
