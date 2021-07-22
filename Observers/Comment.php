<?php

namespace Modules\MyBlog\Observers;

use App\Abstracts\Observer;
use Modules\MyBlog\Notifications\Comment as Notification;
use Modules\MyBlog\Models\Comment as Model;

class Comment extends Observer
{
    /**
     * Listen to the created event.
     *
     * @param  Model $comment
     *
     * @return void
     */
    public function created(Model $comment)
    {
        $user = $comment->post->owner;

        $user->notify(new Notification($comment, 'comment_new_author'));
    }

    /**
     * Listen to the deleted event.
     *
     * @param  Model $comment
     *
     * @return void
     */
    public function deleted(Model $comment)
    {
        $user = $comment->post->owner;

        $user->notify(new Notification($comment, 'comment_delete_author'));
    }
}
