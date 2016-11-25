const elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for your application as well as publishing vendor resources.
 |
 */

elixir((mix) => {
    mix.sass('app.scss');

    // mix scripts
    mix.scripts([
        '../../../node_modules/angular/angular.js',
        '../../../node_modules/angular-resource/angular-resource.js',
        '../../../node_modules/angularjs-scroll-glue/src/scrollglue.js',
        'app.js',
    ]);

    // version assets for cache busting
    mix.version([
        'css/app.css',
        'js/all.js',
    ]);
});
