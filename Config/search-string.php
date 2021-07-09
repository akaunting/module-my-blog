<?php

return [

    'Modules\MyBlog\Models\Post' => [
        'columns' => [
            'id',
            'name' => ['searchable' => true],
            'description' => ['searchable' => true],
            'category_id' => [
                'route' => ['categories.index', 'search=type:post'],
            ],
            'enabled' => ['boolean' => true],
        ],
    ],

    'Modules\MyBlog\Models\Comment' => [
        'columns' => [
            'id',
            'description' => ['searchable' => true],
            'post_id' => [
                'route' => 'my-blog.posts.index',
            ],
        ],
    ],

];
