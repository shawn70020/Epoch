import api from '../api/index';
export default {
    state: {
        user: []
    },
    mutations: {
        SETUSER(state, lists) {
            state.user = lists;
        }
    },
    actions: {
        getUser({
            commit
        }) {
            api.getUser().then(function (res) {
                console.log(res);
                commit('SETUSER', res.data.data);
            });
        }
    },

}
