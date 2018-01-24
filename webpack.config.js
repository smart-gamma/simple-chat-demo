var Encore = require("@symfony/webpack-encore");

Encore
    .setOutputPath("web/build/")
    .setPublicPath("/build")
    .addLoader({
        test: /\.hbs$/,
        loader: "handlebars-loader",
    })
    .addEntry("ws-chat", "./app/frontend/js/ws.chat.js")
    .addEntry("http-chat", "./app/frontend/js/http.chat.js")
    .enableSassLoader()
    .autoProvidejQuery()
    .enableSourceMaps(!Encore.isProduction())
    .cleanupOutputBeforeBuild()
    .enableVersioning()
    .createSharedEntry("vendor", [
        "jquery",
        "bootstrap-sass",
        "bootstrap-sass/assets/stylesheets/_bootstrap.scss"
    ])
;

module.exports = Encore.getWebpackConfig();
