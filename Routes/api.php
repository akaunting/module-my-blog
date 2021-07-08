<?php

use Illuminate\Support\Facades\Route;

/**
 * 'api' middleware and 'api/my-blog' prefix applied to all routes (including names)
 *
 * @see \App\Providers\Route::register
 */

Route::api('my-blog', function ($api) {
    $api->get('posts/{post}/enable', 'Posts@enable')->name('.posts.enable');
    $api->get('posts/{post}/disable', 'Posts@disable')->name('.posts.disable');
    $api->resource('posts', 'Posts');
    $api->resource('comments', 'Comments');
});
