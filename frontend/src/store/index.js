import Vue from 'vue'
import Vuex from 'vuex'
import user from './user'
import axios from 'axios';

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        isLogin: false,
        info: {},
        cart: {}
    },
    mutations: {
      getUserInfo(state, token) {
            return axios.get(`/api/getuserinfo/${token}`)
                .then(res => {
                    state.info = res.data.info;
                    state.cart = res.data.cart;
                    console.log(344)
                }).catch(err => {
                    console.log(err);
                })
        }
    },
    modules: {
        user
    }
})
