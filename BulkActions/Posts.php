<?php

namespace Modules\MyBlog\BulkActions;

use App\Abstracts\BulkAction;
use Modules\MyBlog\Exports\Posts as Export;
use Modules\MyBlog\Jobs\DeletePost;
use Modules\MyBlog\Models\Post;

class Posts extends BulkAction
{
    public $model = Post::class;

    public $actions = [
        'enable' => [
            'name' => 'general.enable',
            'message' => 'bulk_actions.message.enable',
            'permission' => 'update-my-blog-posts',
        ],
        'disable' => [
            'name' => 'general.disable',
            'message' => 'bulk_actions.message.disable',
            'permission' => 'update-my-blog-posts',
        ],
        'delete' => [
            'name' => 'general.delete',
            'message' => 'bulk_actions.message.delete',
            'permission' => 'delete-my-blog-posts',
        ],
        'export' => [
            'name' => 'general.export',
            'message' => 'bulk_actions.message.export',
            'type' => 'download',
        ],
    ];

    public function destroy($request)
    {
        $posts = $this->getSelectedRecords($request, 'comments');

        foreach ($posts as $post) {
            try {
                $this->dispatch(new DeletePost($post));
            } catch (\Exception $e) {
                flash($e->getMessage())->error()->important();
            }
        }
    }

    public function export($request)
    {
        $selected = $this->getSelectedInput($request);

        return $this->exportExcel(new Export($selected), trans_choice('my-blog::general.posts', 2));
    }
}
