<?php

return [

    'name'              => 'Blog',
    'description'       => 'Example module with beyond CRUD functions',

    'posts'             => 'Post|Posts',
    'comments'          => 'Comment|Comments',
    'authors'           => 'Author|Authors',

    'demo' => [
        'categories' => [
            'php'       => 'PHP',
            'laravel'   => 'Laravel',
        ],
    ],

    'form_description' => [
        'post'          => 'Enter the post name, description and select the category.',
        'comment'       => 'Select the post and enter the comment in the description field.',
    ],

    'empty' => [
        'comments' => 'Write comments for posts.',
        'posts' => 'Write posts and publish them.',
    ],

];
