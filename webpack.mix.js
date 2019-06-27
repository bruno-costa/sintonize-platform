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

mix.setResourceRoot('../').
  js('resources/js/app.js', 'public/js').
  sass('resources/sass/app.scss', 'public/css').
  styles([
    'resources/plugins/argon/css/argon.css',
  ], 'public/css/plugins.main.min.css').
  scripts([
    'resources/plugins/js-cookie/js.cookie.js',
    'resources/plugins/scrollbar/jquery.scrollbar.js',
    'resources/plugins/scrollbar/jquery-scrollLock.js',
    'resources/plugins/argon/js/argon.js',
  ], 'public/js/plugins.main.min.js').
  scripts([
    'resources/plugins/chart/Chart.js',
    'resources/plugins/chart/Chart.extension.js',
  ], 'public/js/plugins.chart.min.js').
  scripts([
    'resources/plugins/dropzone/dropzone.js',
  ], 'public/js/plugins.dropzone.min.js').
  styles([
    'resources/plugins/select2/css/select2.css',
  ], 'public/css/plugins.select2.min.css').
  scripts([
    'resources/plugins/select2/js/select2.js',
  ], 'public/js/plugins.select2.min.js')
