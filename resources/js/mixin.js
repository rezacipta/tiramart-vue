import Vue from 'vue'

Vue.mixin({
    methods: {
        // cart helper
        productCart(id) {
            let index = this.$store.state.cart.products.findIndex(item => item.id == id);

            if (index != -1) return true;
            else return false;
        },
        quantityCart(id) {
            let item = this.$store.state.cart.products.find(item => item.id == id);

            if (item) return item.quantity;
        },
        updateCart(product, method) {
            this.$store.state.cartMethod = method;
            this.$store.commit('UPDATE_CART', product);
        },
        // common helper
        formatCurrency(price) {
            let format = new Intl.NumberFormat('en-ID', {
                style: 'currency',
                currency: 'IDR'
            }).format(price).replace(/[IDR]/gi, '').replace(/(\.+\d{2})/, '').trimLeft();

            return 'Rp ' + format;
        },
        formatWeight(weight) {
            let format = new Intl.NumberFormat('en-ID', {
                style: 'unit',
                unit: 'gram',
                unitDisplay: 'long'
            }).format(weight);

            return format;
        },
        numberOnly(e) {
            e = (e) ? e : window.event;
            var charCode = (e.which) ? e.which : e.keyCode;

            if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46)
                e.preventDefault();
            else return true;
        },
        pushToast(variant = null, message) {
            this.$bvToast.toast(message, {
                title: 'Notifikasi',
                toaster: 'b-toaster-top-center',
                variant: variant,
                solid: true
            })
        },
        validateState(ref) {
            if (this.veeFields[ref] && (this.veeFields[ref].dirty || this.veeFields[ref].validated))
                return !this.veeErrors.has(ref);

            return null;
        }
    }
});