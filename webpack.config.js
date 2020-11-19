const Encore = require('@symfony/webpack-encore');
const PurgeCssPlugin = require('purgecss-webpack-plugin');
const path = require('path');
const glob = require('glob-all');
const _ = require('lodash');


const isProduction = Encore.isProduction();

Encore
  .setOutputPath('public/media/shop/')
  .setPublicPath('/media/shop')
  .copyFiles({
    from: './assets/images',
  })
  .addEntry('shop-entry', './assets/shop/entry.js')
  .disableSingleRuntimeChunk()
  .cleanupOutputBeforeBuild()
  .enableSourceMaps(!isProduction)
  .enableVersioning(isProduction)
  .enableBuildNotifications(!isProduction)
  .enablePostCssLoader();


if (isProduction) {
  Encore.addPlugin(new PurgeCssPlugin({
    paths: glob.sync([
      path.join(__dirname, 'themes/**/views/**/*.html.twig'),
      path.join(__dirname, 'themes/**/assets/**/*.js'),

      path.join(__dirname, 'vendor/**/Resources/**/*.html.twig'),
      path.join(__dirname, 'templates/**/Resources/**/*.html.twig'),
    ]),
    extractors: [
      {
        extractor: class {
          static extract(content) {
            return content.match(/[A-z0-9-_:/]+/g) || [];
          }
        },
        extensions: [
          'twig',
          'js',
        ],
        whitelistPatterns: [
        ],
      },
    ],
  }));
}

const config = Encore.getWebpackConfig();
config.name = 'shop';
module.exports = config;
