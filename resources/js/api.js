import axios from 'axios'
import store from './store'

export const api = axios.create();

api.interceptors.request.use(
    function(config) {
        const token = window.localStorage.getItem('token');
        if (token != null) {
            config.headers.Authorization = `Bearer ${token}`;
        }
        return config;
    },
    function(error) {
        return Promise.reject(error.response);
    }
);

api.interceptors.response.use(
    res => {
        return res;
    },
    function(err) {
        if (err.response.status === 401) {
            store.commit('DELETE_USER');
        }
        return Promise.reject(err.response);
    }
);

export default api