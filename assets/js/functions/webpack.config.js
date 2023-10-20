const path = require('path');
module.exports = {
    mode: 'development',
    entry: './ts-functions.js',
    output: {
        path: path.resolve(__dirname, 'dist'),
        filename: 'ts-functions-bundle.js',
    },
};
// TODO: Lazy Loading Javascript Snippets (Chunks)
// TODO: https://webpack.js.org/guides/lazy-loading/
// TODO: OnebyOneRequest Refactor (Promises)
// TODO: https://developer.mozilla.org/de/docs/Web/JavaScript/Reference/Global_Objects/Promise
