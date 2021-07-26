const StyleLintPlugin = require('stylelint-webpack-plugin')
const path = require('path')

module.exports = {
  css: {
    sourceMap: process.env.NODE_ENV !== 'production',
    extract: process.env.NODE_ENV === 'production'
  },
  devServer: {
    historyApiFallback: true
  },
  lintOnSave: process.env.NODE_ENV === 'production' ? 'error' : 'warning',
  configureWebpack: {
    devtool: 'source-map',
    plugins: [
      new StyleLintPlugin({
        files: 'src/**/*.{vue,scss}'
      })
    ],
    resolve: {
      alias: {
        '@': path.join(__dirname, '/src')
      }
    }
  },
  pluginOptions: {
    lintStyleOnBuild: true
  }
}
