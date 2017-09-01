var path = require('path'); 
var debug = process.env.NODE_ENV !== "production";
var webpack = require('webpack');


module.exports = {
    devtool: debug ? "inline-sourcemap" : false,
    entry: './src/index.js',
    module: {
        loaders: [
            {
                test: /\.jsx?$/,
                include: path.join(__dirname,'src'),
                loaders: 'babel-loader',
                query: {
                    presets: ['react', 'es2015', 'stage-0'],
                    plugins: ['react-html-attrs', 'transform-decorators-legacy', 'transform-class-properties'],
                }
            }
        ]
    },
    output: {
        filename: '../script/bundle.js'
    },
    plugins: debug ? [] : [
        new webpack.optimize.DedupePlugin(),
        new webpack.optimize.OccurrenceOrderPlugin(),
        new webpack.optimize.UglifyJsPlugin({ mangle: false, sourcemap: false }),
    ],
};