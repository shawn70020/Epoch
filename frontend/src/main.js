import Vue from 'vue'
import Vuex from 'vuex'
import App from './App.vue'
import router from './router'
import store from './store'
import axios from 'axios';
import 'bootstrap';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap-vue/dist/bootstrap-vue.css'
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import { ValidationProvider, extend } from 'vee-validate';
import { required } from 'vee-validate/dist/rules';
import VueCookie from 'vue-cookie';
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
import Element from 'element-ui';
import './plugins/element.js'

extend('required', {
  ...required,
  message: 'This field is required'
});

Vue.component('ValidationProvider', ValidationProvider);
Vue.use(Vuex);
Vue.use(VueCookie);
Vue.use(Element);
Vue.use(BootstrapVue);
Vue.use(IconsPlugin);
Vue.component('Loading', Loading)
Vue.prototype.$http = axios;
Vue.config.productionTip = false


new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app')
