<?php

use Illuminate\Support\Facades\Route;

/**
 * 'admin' middleware and 'my-blog' prefix applied to all routes (including names)
 *
 * @see \App\Providers\Route::register
 */

Route::admin('my-blog', function () {
    Route::get('posts/{post}/duplicate', 'Posts@duplicate')->name('posts.duplicate');
    Route::get('posts/{post}/enable', 'Posts@enable')->name('posts.enable');
    Route::get('posts/{post}/disable', 'Posts@disable')->name('posts.disable');
    Route::post('posts/import', 'Posts@import')->name('posts.import');
    Route::get('posts/export', 'Posts@export')->name('posts.export');
    Route::resource('posts', 'Posts');
    Route::get('comments/export', 'Comments@export')->name('comments.export');
    Route::resource('comments', 'Comments');
});
