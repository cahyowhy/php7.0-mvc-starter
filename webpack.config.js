var path = require('path');
var Webpack = require('webpack');
var LiveReload = require('webpack-livereload-plugin');
var ExtracTextPlugin = require('extract-text-webpack-plugin');

module.exports = {
    entry: {
        'app/main': './assets/js/main.js',
        'css/main': './assets/scss/main.scss'
    },
    output: {
        path: path.resolve(__dirname, './dist'),
        publicPath: '/dist/',
        filename: '[name].js'
    },
    module: {
        rules: [
            {
                test: /\.vue$/,
                loader: 'vue-loader',
                options: {
                    loaders: {}
                    // other vue-loader options go here
                }
            },
            {
                test: /\.js$/,
                loader: 'babel-loader',
                exclude: /node_modules/
            },

            // regular css files
            {
                test: /\.css$/,
                loader: ExtracTextPlugin.extract(['css-loader'])
            },
            // sass / scss loader for webpack
            {
                test: /\.(sass|scss)$/,
                loader: ExtracTextPlugin.extract(['css-loader', 'sass-loader'])
            },
            {
                test: /\.(png|jpg|gif|svg)$/,
                loader: 'file-loader',
                options: {
                    name: '[name].[ext]?[hash]'
                }
            }
        ]
    },
    plugins: [
        new ExtracTextPlugin({
            // define where to save the file
            filename: '[name].bundle.css',
            allChunks: true
        })
    ],
    resolve: {
        extensions: ['.js', '.vue', '.json'],
        alias: {
            'vue$': 'vue/dist/vue.esm.js'
        }
    },
    devServer: {
        historyApiFallback: true,
        noInfo: true,
        overlay: true
    },
    performance: {
        hints: false
    },
    devtool: '#eval-source-map'
};


if (process.env.NODE_ENV === 'devwatch') {

    // http://vue-loader.vuejs.org/en/workflow/production.html
    module.exports.plugins = (module.exports.plugins || []).concat([
        new Webpack.DefinePlugin({
            'process.env': {
                NODE_ENV: '"development"'
            }
        }),
        new LiveReload()
    ]);
    module.exports.watch = true
}

if (process.env.NODE_ENV === 'production') {
    module.exports.devtool = '#source-map';
    // http://vue-loader.vuejs.org/en/workflow/production.html
    // short-circuits all Vue.js warning code
    module.exports.plugins = (module.exports.plugins || []).concat([
        new Webpack.DefinePlugin({
            'process.env': {
                NODE_ENV: '"production"'
            }
        }),
        // minify with dead-code elimination
        new Webpack.optimize.UglifyJsPlugin({
            sourceMap: true,
            compress: {
                warnings: false
            }
        }),
        new Webpack.LoaderOptionsPlugin({
            minimize: true
        })
    ])
}