var Encore = require('@symfony/webpack-encore');

// noinspection JSUnresolvedFunction

/**
 * The Encore helps generate the Webpack configuration.
 */
Encore
    /*
     * The project directory where compiled assets will be stored
     */
    .setOutputPath('public/build/')

    /*
     * The public path used by the web server to access the previous directory
     */
    .setPublicPath('/build')

    /*
     * Empty the outputPath dir before each build
     */
    .cleanupOutputBeforeBuild()

    /*
     * For production, enable source maps
     */
    .enableSourceMaps(!Encore.isProduction())

    // uncomment to create hashed filenames (e.g. app.abc123.css)
    // .enableVersioning(Encore.isProduction())

    // uncomment to define the assets of the project

    /*
     * app.js
     */
    .addEntry('js/app', './assets/js/app.js')

    // .addStyleEntry('css/app', './assets/css/app.scss')

    // uncomment if you use Sass/SCSS files
    // .enableSassLoader()

    // uncomment for legacy applications that require $/jQuery as a global variable
    // .autoProvidejQuery()
;

// noinspection JSUnresolvedFunction

module.exports = Encore.getWebpackConfig();
