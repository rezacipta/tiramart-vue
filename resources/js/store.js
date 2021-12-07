import Vue from 'vue'
import Vuex from 'vuex'
import api from './api.js'

let cart = localStorage.getItem('cart');
let token = localStorage.getItem('token');
let address = localStorage.getItem('address');

const csrf = () => {
    return api.get('/sanctum/csrf-cookie');
}

const cartDefault = () => {
    return {
        products: [],
        totalPrice: 0,
        totalPriceBefore: 0,
        totalQuantity: 0,
        totalWeight: 0,
    }
}

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        address: address ? JSON.parse(address) : [],
        cart: cart ? JSON.parse(cart) : cartDefault(),
        cartProducts: cart ? JSON.parse(cart).products : cartDefault().products,
        cartMethod: null,
        page: 1,
        banners: [],
        products: [],
        product: null,
        user: [],
        token: token ? token : null,
    },
    mutations: {
        FETCH_BANNERS(state, banners) {
            state.banners = banners;
        },
        FETCH_CART(state, cart) {
            state.cart = cart;
        },
        FETCH_PRODUCTS(state, produtcs) {
            $.each(produtcs, (key, value) => {
                state.products.push(value);
            });
        },
        FETCH_USER(state, data) {
            state.user = data.user;
            state.token = data.token;

            localStorage.setItem('token', state.token);
        },
        DELETE_FROM_CART(state, cart) {
            let index = state.cartProducts.findIndex(item => item.id === cart.id)
            state.cartProducts.splice(index, 1);
        },
        DELETE_USER(state) {
            state.user = null;
            state.token = null;

            localStorage.removeItem('token');
        },
        CALCULATE_CART(state) {
            Object.assign(state.cart, cartDefault());
            state.cart.products = state.cartProducts;
            for (let item of state.cart.products) {
                if (item.checked) {
                    state.cart.totalPrice += item.price * item.quantity;
                    state.cart.totalPriceBefore += item.priceBefore * item.quantity;
                    state.cart.totalQuantity += item.quantity;
                    state.cart.totalWeight += item.weight * item.quantity;
                }
            }

            localStorage.setItem('cart', JSON.stringify(state.cart));
        },
        UPDATE_CART(state, product) {
            if (state.cartMethod == null) return;
            let item = state.cartProducts.find(item => item.id == product.id);

            if (item) {
                if (state.cartMethod == '+') {
                    item.quantity++;
                    item.checked = true;
                } else if (state.cartMethod == '-') {
                    item.quantity--;
                    if (item.quantity == 0)
                        this.commit('DELETE_FROM_CART', product);
                } else if (state.cartMethod == 'check') {
                    item.checked = !item.checked;
                }
            } else {
                state.cartProducts.push(product);
                Vue.set(product, 'checked', true);
                Vue.set(product, 'quantity', 1);
            }

            state.cartMethod = null;
            this.commit('CALCULATE_CART');
        },
        NEXT_PAGE(state) {
            state.page = state.page + 1;
        },
        AUTH(state, data) {
            state.user = data;
        }
    },
    getters: {
        address: state => {
            return state.address;
        },
        banners: state => {
            return state.banners;
        },
        cart: state => {
            return state.cart;
        },
        product: state => {
            return state.product;
        },
        products: state => {
            return state.products;
        },
        user: state => {
            return state.user;
        }
    },
    actions: {
        async fetchBanners({ commit }) {
            return api.get('/api/banner').then(res => {
                commit('FETCH_BANNERS', res.data);
            }).catch(err => {
                console.log(err);
            });
        },
        async fetchProducts({ commit }) {
            return api.get('/api/product?page=' + this.state.page).then(res => {
                commit('FETCH_PRODUCTS', res.data);
                commit('NEXT_PAGE');
            }).catch(err => {
                console.log(err);
            });
        },
        async auth({ commit }) {
            return api.get('/api/user').then(res => {
                commit('AUTH', res.data);
            }).catch(err => {
                console.log(err);
            });
        },
        async logout({ commit }) {
            return new Promise((resolve, reject) => {
                api.get('/api/logout').then(res => {
                    commit('DELETE_USER', res.data);
                    resolve(res);
                }).catch(err => {
                    reject(err);
                    console.log(err);
                });
            });
        },
        async login({ commit }, payload) {
            await csrf();
            return new Promise((resolve, reject) => {
                api.post('/api/login', payload).then(res => {
                    commit('FETCH_USER', res.data);
                    resolve(res);
                }).catch(err => {
                    reject(err);
                    console.log(err);
                });
            });
        },
        async checkLogin({ commit }, payload) {
            await csrf();
            return new Promise((resolve, reject) => {
                api.post('/api/check/login', payload).then(res => {
                    resolve(res);
                }).catch(err => {
                    reject(err);
                    console.log(err);
                });
            });
        },
        async checkOtp({ commit }, payload) {
            await csrf();
            return new Promise((resolve, reject) => {
                api.post('/api/check/otp', payload).then(res => {
                    resolve(res);
                }).catch(err => {
                    reject(err);
                    console.log(err);
                });
            });
        },
        async sendOtp({ commit }, payload) {
            await csrf();
            return new Promise((resolve, reject) => {
                api.post('/api/send/otp', payload).then(res => {
                    resolve(res);
                }).catch(err => {
                    reject(err);
                    console.log(err);
                });
            });
        },
        async saveCart({ commit }, payload) {
            await csrf();
            return api.post('/api/cart', payload).then(res => {
                console.log(res);
            }).catch(err => {
                console.log(err);
            });
        }
    }
})