<?php

use Illuminate\Support\Facades\Route;

/**
 * 'portal' middleware and 'portal/my-blog' prefix applied to all routes (including names)
 *
 * @see \App\Providers\Route::register
 */

Route::portal('my-blog', function () {
    Route::resource('posts', 'Portal\Posts');
});
