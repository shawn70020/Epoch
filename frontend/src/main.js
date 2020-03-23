//基本配置
import Vue from 'vue'
import Vuex from 'vuex'
import App from './App.vue'
import router from './router'
import store from './store'
import axios from 'axios';

// bootstrap 導入
import 'bootstrap';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap-vue/dist/bootstrap-vue.css'
import {
    BootstrapVue,
    IconsPlugin
} from 'bootstrap-vue'

// loading樣式
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';

// Element ui 導入
import Element from 'element-ui';
import './plugins/element.js';

// 貨幣千分位
import currencyFilter from './filters/currency';

// 日期處理
import moment from "moment";
Vue.prototype.$moment = moment;

// 圖表
import ECharts from 'vue-echarts'
import 'echarts/lib/chart/line'
import 'echarts/lib/chart/bar'
import 'echarts/lib/chart/pie'
import 'echarts/lib/component/tooltip'
import 'echarts/lib/component/polar'
import 'echarts/lib/component/legend'
import 'echarts/lib/component/title.js'
import {
    ValidationProvider,
    ValidationObserver,
    extend
} from 'vee-validate';
import {
    required,email
} from 'vee-validate/dist/rules';
extend('required', {
    ...required,
    message: 'is required'
});
extend('email', {
    ...email,
    message: 'is not right'
});

Vue.component('ValidationObserver', ValidationObserver);
Vue.component('ValidationProvider', ValidationProvider);
// 欄位檢驗
import Vuelidate from 'vuelidate'
Vue.use(Vuelidate);

Vue.component('chart', ECharts)
Vue.use(Vuex);
Vue.use(Element);
Vue.use(BootstrapVue);
Vue.use(IconsPlugin);
Vue.filter('currency', currencyFilter);
Vue.component('Loading', Loading)
Vue.prototype.$http = axios;
Vue.config.productionTip = false

// 基本路由判斷
router.beforeEach((to, from, next) => {
    let isLogin = localStorage.getItem('isLogin');
    let token = localStorage.getItem('token');
    if (to.meta.requiresAuth) { // 判斷是否有許可權
        if (!store.state.isLogin && !isLogin && to.path !== '/login') { // store和localStorage中登入狀態都為false並且跳轉到 不是登入的頁面時 都強行跳轉到登入頁面
            next({
                path: '/login',
            });
        } else if (!isLogin && to.path !== '/login') {
            //將local狀態改變
            localStorage.setItem('isLogin', store.state.isLogin);
            //使用local的token給vuex取得該使用者資訊
            store.commit('getUserInfo', token);
            next();
        } else if (isLogin && to.path !== '/login') {
            //使用local的token給vuex取得該使用者資訊
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

// 頁面掛載在App.vue頁面
new Vue({
    router,
    store,
    render: h => h(App)
}).$mount('#app')
