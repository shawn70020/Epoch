import api from '../api/index';
export default {
    state: {
        cart: []
    },
    actions: {
        getUser({
            commit
        }) {
            api.getUserCart().then(function (res) {
                commit('SETUSER', res.data);
            });
        }
    },
    mutations: {
        SETUSER(state, lists) {
            state.user = lists;
        }
    },
}
