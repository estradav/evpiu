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

mix.js('resources/dashboard/scripts/app.js', 'public/dashboard/scripts')
   .scripts([
        'node_modules/datatables.net/js/jquery.dataTables.min.js',
        'node_modules/datatables.net-bs4/js/dataTables.bootstrap4.min.js',
        'resources/dashboard/scripts/datatables.net.js'
   ], 'public/dashboard/scripts/main.js')
   .styles([
        'node_modules/datatables.net-bs4/css/dataTables.bootstrap4.css'
   ], 'public/dashboard/styles/main.css')
   .sass('resources/dashboard/styles/app.scss', 'public/dashboard/styles')
   .js('resources/clean-blog/scripts/app.js', 'public/clean-blog/scripts')
   .sass('resources/clean-blog/styles/app.scss', 'public/clean-blog/styles');
