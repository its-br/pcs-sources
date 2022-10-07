import 'es6-promise/auto'
import Vue from 'vue'
import Vuex from 'vuex'
import App from './App.vue'
import router from './router'
import vuetify from './plugins/vuetify'
import i18n from './plugins/i18n'
import Vuelidate from "vuelidate";


Vue.use(Vuex);
Vue.config.productionTip = false

import store from "./store";

Vue.use(Vuelidate);
 
new Vue({
  router,
  vuetify,
  store,
  i18n,
  render: h => h(App)
}).$mount('#app')
