<?php

namespace Modules\MyBlog\BulkActions;

use App\Abstracts\BulkAction;
use Modules\MyBlog\Exports\Comments as Export;
use Modules\MyBlog\Jobs\DeleteComment;
use Modules\MyBlog\Models\Comment;

class Comments extends BulkAction
{
    public $model = Comment::class;

    public $text = 'my-blog::general.comments';

    public $path = [
        'group' => 'my-blog',
        'type' => 'comments',
    ];

    public $actions = [
        'delete' => [
            'name' => 'general.delete',
            'message' => 'bulk_actions.message.delete',
            'permission' => 'delete-my-blog-comments',
        ],
        'export' => [
            'name' => 'general.export',
            'message' => 'bulk_actions.message.export',
            'type' => 'download',
        ],
    ];

    public function destroy($request)
    {
        $comments = $this->getSelectedRecords($request);

        foreach ($comments as $comment) {
            try {
                $this->dispatch(new DeleteComment($comment));
            } catch (\Exception $e) {
                flash($e->getMessage())->error()->important();
            }
        }
    }

    public function export($request)
    {
        $selected = $this->getSelectedInput($request);

        return $this->exportExcel(new Export($selected), trans_choice('my-blog::general.comments', 2));
    }
}
