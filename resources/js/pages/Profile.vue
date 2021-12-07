<template>
    <b-form @submit.stop.prevent="submitData">
        <div class="detailsHdrBody AddressPage_body">
            <div class="Card_card AddressPage_cardGap AddressPage_outerDiv">
                <div class="cardBody">
                    <div class="AddressPage_inputDiv">
                        <div class="AddressPage_inputTitle">Nama</div>
                        <b-form-input name="name" class="form-control" v-model="user.name" v-validate="{ required: true }" :state="validateState('name')" data-vv-as="Nama"/>
                        <b-form-invalid-feedback>{{ veeErrors.first('name') }}</b-form-invalid-feedback>
                    </div>
                    <div class="AddressPage_inputDiv">
                        <div class="AddressPage_inputTitle">Nomor HP (WhatsApp)</div>
                        <b-form-input disabled name="phone" type="number" @keypress="numberOnly" v-model="user.phone" v-validate="{ required: true, min:10, max:13, regex:/(08)[0-9]{8}/ }" :state="validateState('phone')" data-vv-as="Nomor Whatsapp"/>
                        <b-form-invalid-feedback>{{ veeErrors.first('phone') }}</b-form-invalid-feedback>
                    </div>
                    <div class="AddressPage_inputDiv">
                        <div class="AddressPage_inputTitle">Surel (Email)</div>
                        <b-form-input name="email" type="email" v-model="user.email" v-validate="{ required: true, regex:/[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$/ }" :state="validateState('email')" data-vv-as="Surel (Email)"/>
                        <b-form-invalid-feedback>{{ veeErrors.first('email') }}</b-form-invalid-feedback>
                    </div>
                </div>
            </div>
        </div>
        <div class="FooterButtons_two-btn-footer-row width-control">
            <b-overlay :show="busy" opacity="0.7" spinner-small spinner-variant="success" class="FooterButtons_two-btn-footer">
                <b-button :disabled="busy" class="btn btn-primary" block variant="primary" type="submit">Simpan Data Diri</b-button>
            </b-overlay>
        </div>
    </b-form>
</template>

<script>
import api from '../api.js'
import {mapGetters} from 'vuex'
export default {
    name: 'Profile',
    data() {
        return {
            busy: false,
        }
    },
    created() {
        this.$store.dispatch('auth');
    },
    computed: {
        ...mapGetters([
            'user'
        ])
    },
    methods: {
        submitData() {
            this.$validator.validateAll().then(result => {
                if (!result) return;
                this.busy = true;
                setTimeout(() => {
                    api.post('/api/profile', this.user).then(res => {
                        this.pushToast('success', 'Data diri berhasil disimpan.');
                    }).catch(err => {
                        this.pushToast('danger', err.data.error || err.data.errors.otp[0] || err.data.message);
                        console.log(err);
                    }).finally(res => {
                        this.busy = false;
                    });
                }, 500)
            })
        }
    }
}
</script>
