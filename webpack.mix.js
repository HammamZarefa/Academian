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

mix.js('resources/js/app.js', 'public/js');

mix.sass('resources/sass/theme.scss', 'public/css/theme.min.css');
mix.sass('resources/sass/app.scss', 'public/css/app.min.css');
mix.sass('resources/sass/authentication.scss', 'public/css/authentication.css');

mix.js('resources/js/theme.min.js', 'public/js');

mix.sass('resources/sass/invoice.scss', 'public/css/invoice.css');

// mix.scripts([
// 	'resources/js/theme.js',
//     'resources/js/website/jquery.slicknav.min.js',
//     'resources/js/website/main.js'
// ], 'public/js/theme.min.js');