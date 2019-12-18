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
mix.webpackConfig({
    resolve: {
        alias: {
            "@": path.resolve(
                __dirname,
                "resources/assets/"
            )
        }
    },
    output: {
        publicPath: '/',
        chunkFilename: '[name].[chunkhash].js',
    },
});
mix.js('resources/assets/user/js/app.js', 'public/user-js');
mix.js('resources/assets/inspector/js/app.js', 'public/inspector-js');
mix.js('resources/assets/client/js/app.js', 'public/client-js');
mix.js('resources/assets/team/js/app.js', 'public/team-js');
