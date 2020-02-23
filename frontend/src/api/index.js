import axios from 'axios';
export default {
    getUser: function () {
        return axios.get('/test')
    },
    signin: function (user) {
        return axios.post('/signin', {
            email: user.email,
            password: user.password,
            name: user.name,
            date: user.time,
            sex: user.sex
        });
    }
}
