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
    'resources/plugins/argon/css/argon.min.css'
  ], 'public/css/plugins.main.min.css').
  scripts([
    'resources/plugins/js-cookie/js.cookie.js',
    'resources/plugins/scrollbar/jquery.scrollbar.min.js',
    'resources/plugins/scrollbar/jquery-scrollLock.min.js',
    'resources/plugins/argon/js/argon.js'
  ], 'public/js/plugins.main.min.js').
  scripts([
    'resources/plugins/chart/Chart.min.js',
    'resources/plugins/chart/Chart.extension.js'
  ], 'public/js/plugins.chart.min.js').
  scripts([
    'resources/plugins/dropzone/dropzone.min.js'
  ], 'public/js/plugins.dropzone.min.js')
