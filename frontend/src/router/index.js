import Vue from 'vue'
import VueRouter from 'vue-router'
import Index from '../views/Index.vue'
import Login from '../views/Login.vue'
import Register from '../views/Register.vue'
import Admin from '../views/Admin.vue'
import Dashboard from "../components/Dashboard"
import Products from "../views/Products"
import Men from "../views/Men"
import Women from "../views/Women"
import Item from "../views/Item"
import Saved from "../views/Saved"
import Bag from "../views/Bag"
import Checkout from "../views/Checkout"
import Account from "../views/Account"
import Details from "../components/Details"
import Password from "../components/Password"
import Myorder from "../components/Myorder"
import Myorderdetail from "../components/Myorderdetail"
import Coupon from "../components/Coupon"
import Orders from "../components/Orders"
import Orderdetails from "../views/Orderdetails"
import Member from "../views/Member"
import Memberdetails from "../views/Memberdetails"

import store from '../store'
import axios from "axios";
Vue.use(VueRouter)

const routes = [{
        path: '*',
        redirect: '/login',
    },
    {
        path: '/',
        name: 'Index',
        component: Index,
    },
    {
        path: '/login',
        name: 'Login',
        component: Login,
        meta: {
            requiresAuth: true
        },
    },
    {
        path: '/register',
        name: 'Register',
        component: Register
    },
    {
        path: '/men',
        name: 'Men',
        component: Men,
        beforeEnter: (to, from, next) => {
            let token = localStorage.getItem('token');
            let isLogin = localStorage.getItem('isLogin');
            if (store.state.isLogin && !isLogin) {
                //將local狀態改變
                localStorage.setItem('isLogin', store.state.isLogin);
                //使用local的token給vuex取得該使用者資訊
                store.commit('getUserInfo', token);
                next();
            } else if (isLogin) {
                store.state.isLogin = true;
                store.commit('getUserInfo', token);
                next();
            } else {
                next();
            }
        },
    },
    {
        path: '/women',
        name: 'Women',
        component: Women,
        beforeEnter: (to, from, next) => {
            let token = localStorage.getItem('token');
            let isLogin = localStorage.getItem('isLogin');
            if (store.state.isLogin && !isLogin) {
                //將local狀態改變
                localStorage.setItem('isLogin', store.state.isLogin);
                //使用local的token給vuex取得該使用者資訊
                store.commit('getUserInfo', token);
                next();
            } else if (isLogin) {
                store.state.isLogin = true;
                store.commit('getUserInfo', token);
                next();
            } else {
                next();
            }
        },
    },
    {
        path: '/item/:pid',
        name: 'Item',
        component: Item,
        beforeEnter: (to, from, next) => {
            let pid = to.params.pid;
            let token = localStorage.getItem('token');
            let isLogin = localStorage.getItem('isLogin');
            axios
                .get(`/api/products/${pid}`)
                .then(res => {
                    if (res.data.result === false) {
                        next({
                            path: '/login',
                        });
                    }
                })

            if (store.state.isLogin && !isLogin) {
                //將local狀態改變
                localStorage.setItem('isLogin', store.state.isLogin);
                //使用local的token給vuex取得該使用者資訊
                store.commit('getUserInfo', token);
                next();
            } else if (isLogin) {
                store.state.isLogin = true;
                store.commit('getUserInfo', token);
                next();
            } else {
                next();
            }

        },
    },
    {
        path: '/user/bag',
        name: 'Bag',
        component: Bag,
        meta: {
            requiresAuth: true
        },
    },
    {
        path: '/user/checkout',
        name: 'Checkout',
        component: Checkout,
        meta: {
            requiresAuth: true
        },
    },
    {
        path: '/user/saved',
        name: 'Saved',
        component: Saved,
        meta: {
            requiresAuth: true
        },
    },
    {
        path: '/account',
        name: 'Account',
        component: Account,
        meta: {
            requiresAuth: true
        },
    },
    {
        path: '/mydetails',
        name: 'Details',
        component: Details,
        meta: {
            requiresAuth: true
        },
    },
    {
        path: '/mypassword',
        name: 'Password',
        component: Password,
        meta: {
            requiresAuth: true
        },
    },
    {
        path: '/myorder',
        name: 'Myorder',
        component: Myorder,
        meta: {
            requiresAuth: true
        },
    },
    {
        path: '/myorderdetail/:oid',
        name: 'Myorderdetail',
        component: Myorderdetail,
        beforeEnter: (to, from, next) => {
            let login;
            let oid = to.params.oid;
            let token = localStorage.getItem('token');
            let isLogin = localStorage.getItem('isLogin');

            if (store.state.isLogin && !isLogin) {
                //將local狀態改變
                localStorage.setItem('isLogin', store.state.isLogin);
                //使用local的token給vuex取得該使用者資訊
                store.commit('getUserInfo', token);
                login = true;
            } else if (isLogin) {
                store.state.isLogin = true;
                store.commit('getUserInfo', token);
                login = true;
            } else {
                next({
                    path: '/login',
                });
            }
            setTimeout(() => {
                if (login === true) {
                    let uid = store.state.info.id
                    axios
                        .get(`/api/orders/${oid}/${uid}`)
                        .then(res => {
                            if (res.data.result === false) {
                                next({
                                    path: '/myorder',
                                });
                            } else {
                                next();
                            }
                        })
                }
            }, 100);

        },
    },
    {
        path: '/admin',
        name: 'Admin',
        component: Admin,
        children: [{
                path: 'dashboard',
                name: 'dashboard',
                component: Dashboard,
                beforeEnter: (to, from, next) => {
                    let login;
                    let token = localStorage.getItem('token');
                    let isLogin = localStorage.getItem('isLogin');
                    if (store.state.isLogin && !isLogin) {
                        //將local狀態改變
                        localStorage.setItem('isLogin', store.state.isLogin);
                        //使用local的token給vuex取得該使用者資訊
                        store.commit('getUserInfo', token);
                        login = true;
                    } else if (isLogin) {
                        store.state.isLogin = true;
                        store.commit('getUserInfo', token);
                        login = true;
                    } else {
                        next({
                            path: '/login',
                        });
                    }
                    if (login === true) {
                        axios.get(`/api/user/status/${token}`).then(res => {
                            if (res.data.result === false) {
                                next({
                                    path: '/login',
                                });
                            } else {
                                next();
                            }
                        })
                    }
                },
            },
            {
                path: 'products',
                name: 'Products',
                component: Products,
                beforeEnter: (to, from, next) => {
                    let login;
                    let token = localStorage.getItem('token');
                    let isLogin = localStorage.getItem('isLogin');
                    if (store.state.isLogin && !isLogin) {
                        //將local狀態改變
                        localStorage.setItem('isLogin', store.state.isLogin);
                        //使用local的token給vuex取得該使用者資訊
                        store.commit('getUserInfo', token);
                        login = true;
                    } else if (isLogin) {
                        store.state.isLogin = true;
                        store.commit('getUserInfo', token);
                        login = true;
                    } else {
                        next({
                            path: '/login',
                        });
                    }
                    if (login === true) {
                        axios.get(`/api/user/status/${token}`).then(res => {
                            if (res.data.result === false) {
                                next({
                                    path: '/login',
                                });
                            } else {
                                next();
                            }
                        })
                    }
                },
            },
            {
                path: 'orders',
                name: 'Orders',
                component: Orders,
                beforeEnter: (to, from, next) => {
                    let login;
                    let token = localStorage.getItem('token');
                    let isLogin = localStorage.getItem('isLogin');
                    if (store.state.isLogin && !isLogin) {
                        //將local狀態改變
                        localStorage.setItem('isLogin', store.state.isLogin);
                        //使用local的token給vuex取得該使用者資訊
                        store.commit('getUserInfo', token);
                        login = true;
                    } else if (isLogin) {
                        store.state.isLogin = true;
                        store.commit('getUserInfo', token);
                        login = true;
                    } else {
                        next({
                            path: '/login',
                        });
                    }
                    if (login === true) {
                        axios.get(`/api/user/status/${token}`).then(res => {
                            if (res.data.result === false) {
                                next({
                                    path: '/login',
                                });
                            } else {
                                next();
                            }
                        })
                    }
                },
            },
            {
                path: 'orderdetails/:oid',
                name: 'Orderdetails',
                component: Orderdetails,
                beforeEnter: (to, from, next) => {
                    let login;
                    let oid = to.params.oid;
                    let token = localStorage.getItem('token');
                    let isLogin = localStorage.getItem('isLogin');
                    if (store.state.isLogin && !isLogin) {
                        //將local狀態改變
                        localStorage.setItem('isLogin', store.state.isLogin);
                        //使用local的token給vuex取得該使用者資訊
                        store.commit('getUserInfo', token);
                        login = true;
                    } else if (isLogin) {
                        store.state.isLogin = true;
                        store.commit('getUserInfo', token);
                        login = true;
                    } else {
                        next({
                            path: '/login',
                        });
                    }
                    if (login === true) {
                        axios.get(`/api/user/status/${token}`).then(res => {
                            if (res.data.result === false) {
                                next({
                                    path: '/login',
                                });
                            }
                            axios.get(`/api/admin/order/${oid}`).then(res => {
                                if (res.data.result === false) {
                                    next({
                                        path: '/login',
                                    });
                                } else {
                                    next();
                                }
                            })
                        })
                    }
                },
            },
            {
                path: 'coupon',
                name: 'Coupon',
                component: Coupon,
                beforeEnter: (to, from, next) => {
                    let login;
                    let token = localStorage.getItem('token');
                    let isLogin = localStorage.getItem('isLogin');
                    if (store.state.isLogin && !isLogin) {
                        //將local狀態改變
                        localStorage.setItem('isLogin', store.state.isLogin);
                        //使用local的token給vuex取得該使用者資訊
                        store.commit('getUserInfo', token);
                        login = true;
                    } else if (isLogin) {
                        store.state.isLogin = true;
                        store.commit('getUserInfo', token);
                        login = true;
                    } else {
                        next({
                            path: '/login',
                        });
                    }
                    if (login === true) {
                        axios.get(`/api/user/status/${token}`).then(res => {
                            if (res.data.result === false) {
                                next({
                                    path: '/login',
                                });
                            } else {
                                next();
                            }
                        })
                    }
                },
            },
            {
                path: 'member',
                name: 'Member',
                component: Member,
                beforeEnter: (to, from, next) => {
                    let login;
                    let token = localStorage.getItem('token');
                    let isLogin = localStorage.getItem('isLogin');
                    if (store.state.isLogin && !isLogin) {
                        //將local狀態改變
                        localStorage.setItem('isLogin', store.state.isLogin);
                        //使用local的token給vuex取得該使用者資訊
                        store.commit('getUserInfo', token);
                        login = true;
                    } else if (isLogin) {
                        store.state.isLogin = true;
                        store.commit('getUserInfo', token);
                        login = true;
                    } else {
                        next({
                            path: '/login',
                        });
                    }
                    if (login === true) {
                        axios.get(`/api/user/status/${token}`).then(res => {
                            if (res.data.result === false) {
                                next({
                                    path: '/login',
                                });
                            } else {
                                next();
                            }
                        })
                    }
                },
            },
            {
                path: 'memberdetails/:uid',
                name: 'Memberdetails',
                component: Memberdetails,
                beforeEnter: (to, from, next) => {
                    let login;
                    let uid = to.params.uid;
                    let token = localStorage.getItem('token');
                    let isLogin = localStorage.getItem('isLogin');
                    if (store.state.isLogin && !isLogin) {
                        //將local狀態改變
                        localStorage.setItem('isLogin', store.state.isLogin);
                        //使用local的token給vuex取得該使用者資訊
                        store.commit('getUserInfo', token);
                        login = true;
                    } else if (isLogin) {
                        store.state.isLogin = true;
                        store.commit('getUserInfo', token);
                        login = true;
                    } else {
                        next({
                            path: '/login',
                        });
                    }
                    if (login === true) {
                        axios.get(`/api/user/status/${token}`).then(res => {
                            if (res.data.result === false) {
                                next({
                                    path: '/login',
                                });
                            }
                            axios.get(`/api/admin/member/${uid}`).then(res => {
                                if (res.data.result === false) {
                                    next({
                                        path: '/login',
                                    });
                                } else {
                                    next();
                                }
                            })
                        })
                    }
                },
            },
        ],
    }
]

const router = new VueRouter({
    mode: 'history',
    base: process.env.BASE_URL,
    routes
})

export default router