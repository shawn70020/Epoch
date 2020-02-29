import Vue from 'vue'
import VueRouter from 'vue-router'
import Index from '../views/Index.vue'
import Login from '../views/Login.vue'
import Register from '../views/Register.vue'
import Admin from '../views/Admin.vue'
import Dashboard from "../components/Dashboard"
import Products from "../views/Products"
import Man from "../views/Man"
import Item from "../views/Item"

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
        path: '/man',
        name: 'Man',
        component: Man,
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
        ],
    },
]

const router = new VueRouter({
    mode: 'history',
    base: process.env.BASE_URL,
    routes
})

export default router
