const mix = require('laravel-mix')

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

mix.js('resources/js/app.js', 'public/js').
  sass('resources/sass/app.scss', 'public/css').
  styles([
    'resources/vendor/argon/css/argon.min.css',
  ], 'public/css/vendor.min.css').
  scripts([
    'resources/vendor/js-cookie/js.cookie.js',
    'resources/vendor/scrollbar/jquery.scrollbar.min.js',
    'resources/vendor/scrollbar/jquery-scrollLock.min.js',
    'resources/vendor/argon/js/argon.min.js',
  ], 'public/js/vendor.min.js')
