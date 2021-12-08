require('./bootstrap');

import Vue from 'vue'
import VueProgressBar from 'vue-progressbar'
import VeeValidate, { Validator } from 'vee-validate'
import VueLoading from 'vue-loading-overlay'
import BootstrapVue from 'bootstrap-vue'
import attributesEn from 'vee-validate/dist/locale/en'
import attributesId from 'vee-validate/dist/locale/id'
import otp from '@bachdgvn/vue-otp-input';
import router from './router'
import store from './store'
import './mixin'

Validator.localize('id', attributesId);

Vue.use(VeeValidate, {
    locale: 'id',
    inject: true,
    fieldsBagName: 'veeFields',
    errorBagName: 'veeErrors',
    dictionary: {
        translationsEn: { attributes: attributesEn },
        translationsId: { attributes: attributesId }
    }
});

Vue.use(VueProgressBar, {
    color: '#2A960C',
    failedColor: '#FD8D25',
    thickness: '3px',
    transition: {
        speed: '0.2s',
        opacity: '0.6s',
        termination: 300
    }
});

Vue.use(VueLoading);

Vue.use(BootstrapVue);

Vue.component('app', require('./layouts/App.vue').default);
// Vue.component('select2', require('./components/Select2.vue').default);
Vue.component('v-otp-input', otp);

const app = new Vue({
    el: '#app',
    router,
    store,
});