<?php

use Illuminate\Support\Facades\Route;

/**
 * 'api' middleware and 'api/my-blog' prefix applied to all routes (including names)
 *
 * @see \App\Providers\Route::register
 */

Route::api('my-blog', function () {
    Route::get('posts/{post}/enable', 'Posts@enable')->name('posts.enable');
    Route::get('posts/{post}/disable', 'Posts@disable')->name('posts.disable');
    Route::apiResource('posts', 'Posts');
    Route::apiResource('comments', 'Comments');
});
