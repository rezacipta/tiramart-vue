import Vue from 'vue'
import Vuex from 'vuex'
import api from './api.js'

let cart = localStorage.getItem('cart');
let token = localStorage.getItem('token');
let address = localStorage.getItem('address');
let buyer = localStorage.getItem('buyer');

const csrf = () => {
    return api.get('/sanctum/csrf-cookie');
}

const addressDefault = () => {
    return {
        indexSelected: 0,
        listAddress: [],
    }
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
        address: address ? JSON.parse(address) : addressDefault(),
        buyer: buyer ? JSON.parse(buyer) : [],
        cart: cart ? JSON.parse(cart) : cartDefault(),
        cartMethod: null,
        page: 1,
        banners: [],
        products: [],
        product: null,
        user: [],
        token: token ? token : null,
    },
    mutations: {
        FETCH_ADDRESS(state, address) {
            let listAddress = state.address.listAddress ? state.address.listAddress : [];
            let item = null;

            if (listAddress.length)
                item = listAddress.find(item => item.id == address.id);

            if (item) {
                item = address;
            } else {
                listAddress.push(address);
            }

            state.address = {
                indexSelected: listAddress.length - 1,
                listAddress: listAddress
            }

            localStorage.setItem('address', JSON.stringify(state.address));
        },
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
        FETCH_BUYER(state, data) {
            state.buyer = data;

            localStorage.setItem('buyer', JSON.stringify(state.buyer));
        },
        DELETE_FROM_CART(state, cart) {
            let index = state.cart.products.findIndex(item => item.id == cart.id)
            state.cart.products.splice(index, 1);
        },
        DELETE_USER(state) {
            state.user = null;
            state.token = null;

            localStorage.removeItem('token');
        },
        UPDATE_CART(state, product = null) {
            if (state.cartMethod == null) return;
            let products = state.cart.products ? state.cart.products : [];
            let item = null;

            if (products.length && product != null)
                item = products.find(item => item.id == product.id);

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
            } else if (product != null) {
                products.push(product);
                Vue.set(product, 'checked', true);
                Vue.set(product, 'quantity', 1);
            }

            Object.assign(state.cart, cartDefault());
            state.cartMethod = null;
            state.cart.products = products;
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
        buyer: state => {
            return state.buyer;
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
        async fetchAddress({ commit }) {
            return api.get('/api/address').then(res => {
                commit('FETCH_ADDRESS', res.data);
            }).catch(err => {
                console.log(err);
            });
        },
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
                    commit('FETCH_BUYER', res.data.user);
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
        async saveAddress({ commit }, payload) {
            await csrf();
            return new Promise((resolve, reject) => {
                api.post('/api/address', payload).then(res => {
                    commit('FETCH_ADDRESS', res.data);
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