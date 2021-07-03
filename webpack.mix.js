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

mix.js('Resources/assets/js/my-blog.js', 'Resources/assets/js/my-blog.min.js')
    .sass('./../../resources/assets/sass/argon.scss', './../../public/css');
