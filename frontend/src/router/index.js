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
import Coupon from "../components/Coupon"
import Orders from "../components/Orders"
import Orderdetails from "../views/Orderdetails"
import Member from "../views/Member"
// import Memberdetails from "../views/Memberdetails"

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
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/women',
        name: 'Women',
        component: Women,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/item/:pid',
        name: 'Item',
        component: Item,
        meta: {
            requiresAuth: true
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
        path: '/admin',
        name: 'Admin',
        component: Admin,
        children: [{
                path: 'dashboard',
                name: 'dashboard',
                component: Dashboard,
                meta: {
                    requiresAuth: true
                },
            },
            {
                path: 'products',
                name: 'Products',
                component: Products,
                meta: {
                    requiresAuth: true
                },
            },
            {
                path: 'orders',
                name: 'Orders',
                component: Orders,
                meta: {
                    requiresAuth: true
                },
            },
            {
                path: 'orderdetails/:oid',
                name: 'Orderdetails',
                component: Orderdetails,
                meta: {
                    requiresAuth: true
                },
            },
            {
                path: 'coupon',
                name: 'Coupon',
                component: Coupon,
                meta: {
                    requiresAuth: true
                },
            },
            {
                path: 'member',
                name: 'Member',
                component: Member,
                meta: {
                    requiresAuth: true
                },
            },
            // {
            //     path: 'memberdetails/:uid',
            //     name: 'Memberdetails',
            //     component: Memberdetails,
            //     meta: {
            //         requiresAuth: true
            //     },
            // },
        ],
    }
]

const router = new VueRouter({
    mode: 'history',
    base: process.env.BASE_URL,
    routes
})

export default router
