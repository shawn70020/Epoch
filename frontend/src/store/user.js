import api from '../api/index';
export default {
    state: {
        user: []
    },
    actions: {
        getUser({commit}) {
            api.getUser().then(function (res) {
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
