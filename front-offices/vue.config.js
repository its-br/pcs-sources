process.env.VUE_APP_VERSION = require('./package.json').version;

module.exports = {
  transpileDependencies: [
    'vuetify'
  ],
  devServer: {
    proxy: 'https://pcs-api-stage.its.org.br/api',
  },
  build:{
    productionSourceMap: false
  },
  publicPath: "/app/"
}
