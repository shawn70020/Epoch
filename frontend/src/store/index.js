import Vue from 'vue'
import Vuex from 'vuex'
import user from './user'
import axios from 'axios';

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        isLogin: false,
        isEmpty: false,
        info: {},
        cart: {},
    },
    mutations: {
        async getUserInfo(state, token) {
            try {
                const res = await axios.get(`/api/getuserinfo/${token}`);
                state.info = res.data.info;
                state.cart = res.data.cart;
                console.log(state.cart.length);
                if (state.cart.length > 0) {
                    state.isEmpty = true;
                }
            } catch (err) {
                console.log(err);
            }
        },
        updateCart(state, updatePid) {
            let i;
            let repeat = false;
            for (i = 0; i < state.cart.length; i++) {
                if (state.cart[i].pid == updatePid) {
                    state.cart[i].num++
                    repeat = true;
                }
            }
            if (repeat == false) {
                state.cart.push({
                    num: 1,
                    pid: updatePid
                })
            }
            state.isEmpty = true;
        },
        deleteCart(state, deletePid) {
            let i;
            for (i = 0; i < state.cart.length; i++) {
                if (state.cart[i].pid == deletePid) {
                    state.cart.splice(i, 1);
                }
            }
            if (state.cart.length === 0) {
                state.isEmpty = false;
            }
        },
    },
    modules: {
        user
    }
})
