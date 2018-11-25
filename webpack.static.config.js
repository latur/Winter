const devMode = process.env.NODE_ENV !== 'production';

const path = require('path');
const webpack = require('webpack');

const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const CleanWebpackPlugin = require('clean-webpack-plugin');
const CopyWebpackPlugin = require('copy-webpack-plugin');
const autoprefixer = require('autoprefixer');
const CleanObsoleteChunks = require('webpack-clean-obsolete-chunks');
const WebpackAssetsManifest = require('webpack-assets-manifest');

module.exports = [
    {
        name: 'frontend',
        mode: devMode ? 'development' : 'production',
        entry: {
            main: [ path.resolve('static/js/main.js') ],
            root: [ path.resolve('static/js/root.js') ],
        },
        devtool: 'source-map',
        output: {
            path: path.join(__dirname, 'www/static'),
            filename: '[name]-[hash].js',
            publicPath: '/static/',
        },
        resolve: {
            alias: {
                jquery: 'jquery/src/jquery',
            },
        },
        module: {
            rules: [{
                test: /\.js$/,
                exclude: /node_modules/,
                use: [{
                    loader: 'babel-loader',
                    options: {
                            presets: ['babel-preset-env', 'stage-2']
                    },
                }],
            },
            {
                test: /\.(png|jpe?g|gif)$/,
                use: [{
                    loader: 'file-loader',
                    options: {
                        name: '[name]-[hash].[ext]',
                        outputPath: 'images-processed'
                    },
                }],
            },
            {
                test: /\.(otf|ttf|eot|woff|woff2)$/,
                use: [
                    {
                        loader: 'file-loader',
                        options: {
                            name: '[name]-[hash].[ext]',
                            outputPath: 'fonts'
                        },
                    },
                ],
            },
            {
                test: /\.css$/,
                use: [
                    {
                        loader: devMode ? 'style-loader' : MiniCssExtractPlugin.loader,
                    },
                    {
                        loader: 'css-loader',
                        options: {
                            sourceMap: true,
                        },
                    },
                    {
                        loader: 'postcss-loader',
                        options: {
                            plugins: [
                                autoprefixer(),
                            ],
                            sourceMap: true,
                        },
                    },
                ],
            },
            {
                test: /\.scss$/,
                use: [
                    {
                        loader: devMode ? 'style-loader' : MiniCssExtractPlugin.loader,
                    },
                    {
                        loader: 'css-loader',
                        options: {
                            sourceMap: true,
                        },
                    },
                    {
                        loader: 'postcss-loader',
                        options: {
                            plugins: [
                                autoprefixer(),
                            ],
                            sourceMap: true,
                        },
                    },
                    {
                        loader: 'sass-loader',
                        options: {
                            sourceMap: true,
                            includePaths: [path.resolve(__dirname, 'static/scss/_settings')],
                        },
                    },
                ],
            }],
        },
        plugins: [
            new CleanWebpackPlugin([path.resolve(__dirname, 'www/static')]),
            new CleanObsoleteChunks(),
            new CopyWebpackPlugin([
                {
                    from: path.resolve(__dirname, 'static/images'),
                    to: 'images',
                },
            ]),
            new MiniCssExtractPlugin({
                filename: '[name]-[hash].css',
                chunkFilename: '[id].css',
            }),
            new webpack.ProvidePlugin({
                $: 'jquery',
                jQuery: 'jquery',
                _: 'underscore',
                underscore: 'underscore',
            }),
            new WebpackAssetsManifest({
                writeToDisk: true,
                output: path.join(__dirname, 'www/static/manifest.json'),
            }),
            new webpack.NamedModulesPlugin()
        ],
        devServer: {
            host: '0.0.0.0',
            port: 9000,
            hot: true,
            inline: true,
            contentBase: './',
            proxy: {
                '*': {
                    target: 'http://0.0.0.0:8000/',
                    changeOrigin: true,
                },
            },
            headers: {
                'Access-Control-Allow-Origin': '*',
                'Access-Control-Allow-Credentials': 'true',
                'Access-Control-Allow-Headers': 'Content-Type, Authorization, x-id, Content-Length, X-Requested-With',
                'Access-Control-Allow-Methods': 'GET, POST, PUT, DELETE, OPTIONS',
            },
        },
    },
];
