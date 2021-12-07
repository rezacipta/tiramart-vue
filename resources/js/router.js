import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter);

export const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '*',
            redirect: '/products'
        },
        {
            path: '/',
            redirect: '/products'
        },
        {
            path: '/products',
            name: 'products',
            meta: {
                auth: false,
                header: false,
                footer: true,
                title: 'Produk',
            },
            component: () =>
                import ( /* webpackChunkName: "products" */ './pages/Products.vue')
        },
        {
            path: '/cart',
            name: 'cart',
            meta: {
                auth: false,
                header: true,
                footer: false,
                title: 'Keranjang',
            },
            component: () =>
                import ( /* webpackChunkName: "cart" */ './pages/Cart.vue')
        },
        {
            path: '/help',
            name: 'help',
            meta: {
                auth: false,
                header: true,
                footer: true,
                title: 'Bantuan',
            },
            component: () =>
                import ( /* webpackChunkName: "layout" */ './pages/Help.vue')
        },
        {
            path: '/login',
            name: 'login',
            meta: {
                auth: false,
                header: true,
                footer: true,
                title: 'Akun',
                group: 'account'
            },
            component: () =>
                import ( /* webpackChunkName: "login" */ './pages/Login.vue')
        },
        {
            path: '/account',
            name: 'account',
            meta: {
                auth: true,
                header: true,
                footer: true,
                title: 'Akun',
                group: 'account'
            },
            component: () =>
                import ( /* webpackChunkName: "account" */ './pages/Account.vue')
        },
        {
            path: '/profile',
            name: 'profile',
            meta: {
                auth: true,
                header: true,
                footer: false,
                title: 'Data Diri',
                group: 'account'
            },
            component: () =>
                import ( /* webpackChunkName: "account" */ './pages/Profile.vue')
        },
        {
            path: '/cashback',
            name: 'cashback',
            meta: {
                auth: true,
                header: true,
                footer: false,
                title: 'Cashback',
                group: 'account'
            },
            component: () =>
                import ( /* webpackChunkName: "account" */ './pages/Cashback.vue')
        },
    ],
    linkActiveClass: 'active'
})

router.beforeEach(async(to, from, next) => {
    const token = localStorage.getItem('token');

    if (to.matched.some(record => record.meta.auth) && !token) {
        next({
            path: "/login",
            query: { redirect: to.fullPath }
        });
    } else {
        next();
    }

    if (to.path == '/login' && token) {
        next({
            path: '/account',
            params: { nextUrl: to.fullPath }
        });
    } else {
        next();
    }
})

export default router