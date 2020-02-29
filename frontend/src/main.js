import Vue from 'vue'
import Vuex from 'vuex'
import App from './App.vue'
import router from './router'
import store from './store'
import axios from 'axios';
import 'bootstrap';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap-vue/dist/bootstrap-vue.css'
import {
    BootstrapVue,
    IconsPlugin
} from 'bootstrap-vue'
import {
    ValidationProvider,
    extend
} from 'vee-validate';
import {
    required
} from 'vee-validate/dist/rules';
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

router.beforeEach((to, from, next) => {
    let isLogin = localStorage.getItem('isLogin');
    let token = localStorage.getItem('token');
    if (to.meta.requiresAuth) { // 判斷是否有許可權
        if (!store.state.isLogin && !isLogin && to.path !== '/login') { // store和sessionStorage中登入狀態都為false並且跳轉到 不是登入的頁面時 都強行跳轉到登入頁面
            next({
                path: '/login',
            });
        } else if (!isLogin && to.path !== '/login') { // 已經在登入頁面進入首頁的時候
            //將local狀態改變
            localStorage.setItem('isLogin', store.state.isLogin);
            console.log(123);
            //使用local的token給vuex取得該使用者資訊
            store.commit('getUserInfo', token);
            next();
        } else if (isLogin && to.path !== '/login') { // 登入進入後重新整理頁面時
            //使用local的token給vuex取得該使用者資訊
            console.log(456);
            console.log(token);
            store.commit('getUserInfo', token);
            //使用local的isLogin給vuex重新設置isLogin
            next();
        } else {
            next();
        }
    } else {
        next();
    }
});

new Vue({
    router,
    store,
    render: h => h(App)
}).$mount('#app')
