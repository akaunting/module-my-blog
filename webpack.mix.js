const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('Resources/assets/js/posts.js', 'Resources/assets/js/posts.min.js')
    .js('Resources/assets/js/comments.js', 'Resources/assets/js/comments.min.js')
    .sass('./../../resources/assets/sass/argon.scss', './../../public/css');
