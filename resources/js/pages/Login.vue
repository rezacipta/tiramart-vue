<template>
    <div class="LoginPage_page height-control overflow-hidden">
        <div class="animated LoginPage_formBody" v-if="formPhone">
            <div class="detailsHdrBody LoginPage_detailsBody">
                <img src="media/image/login-page.png" width="200" style="padding: 10px">
                <div class="LoginPage_text LoginPage_formTitle">Masukkan nomor WhatsApp Anda</div>
                <div class="LoginPage_form">
                    <b-form @submit.stop.prevent="submitPhone">
                        <b-form-input class="LoginForm_phone" name="phone" type="number" placeholder="08xxx" @keypress="numberOnly" v-model="form.phone" v-validate="{ required: true, min:10, max:13, regex:/(08)[0-9]{8}/ }" :state="validateState('phone')" data-vv-as="Whatsapp"/>
                        <b-form-invalid-feedback>{{ veeErrors.first('phone') }}</b-form-invalid-feedback>
                        <b-overlay :show="busy" opacity="0.7" spinner-small spinner-variant="success" class="LoginForm_submitBtn">
                            <b-button :disabled="busy" class="btn btn-primary" block variant="primary" type="submit">Lanjut</b-button>
                        </b-overlay>
                    </b-form>
                </div>
            </div>
        </div>
        <div class="LoginPage_formBody" v-if="formPassword">
            <div class="animated detailsHdrBody LoginPage_detailsBody">
                <div class="LoginPage_text LoginPage_formTitle">Masukkan kata sandi</div>
                <div class="LoginPage_formInfo">Kata sandi dibutuhkan untuk keamanan akun Anda</div>
                <div class="LoginPage_form">
                    <b-form @submit.stop.prevent="submitPassword">
                        <b-form-input class="LoginForm_phone" name="password" type="password" v-model="form.password" v-validate="{ required: true, min:6 }" :state="validateState('password')" data-vv-as="Password"/>
                        <b-form-invalid-feedback>{{ veeErrors.first('password') }}</b-form-invalid-feedback>
                        <b-overlay :show="busyResend" opacity="0.7" spinner-small spinner-variant="success">
                        <div class="PinForm_forgotPin">Lupa kata sandi Anda? <a href="#" :disabled="busyResend" @click="forgot()">Klik disini</a> untuk verifikasi ulang</div>
                        </b-overlay>
                        <b-overlay :show="busy" opacity="0.7" spinner-small spinner-variant="success" class="LoginForm_submitBtn">
                            <b-button :disabled="busy" class="btn btn-primary" block variant="primary" type="submit">Konfirmasi</b-button>
                        </b-overlay>
                    </b-form>
                </div>
            </div>
        </div>
        <div class="animated LoginPage_formBody" v-if="formOtp">
            <div class="detailsHdrBody OtpPage_detailsBody">
                <div class="OtpPage_formTitle">Masukkan kode OTP</div>
                <div class="OtpPage_formInfo">Untuk memastikan ini Anda, ayo masukkan kode verifikasi yang telah kami kirim ke <span class="OtpPage_boldText" v-text="form.phone"></span>&nbsp;via <span class="OtpPage_boldText">WhatsApp</span></div>
                <div class="OtpPage_formInput">
                    <b-form @submit.stop.prevent="submitOtp">
                        <div class="OtpForm_otpInputAndResendDiv">
                            <div class="OtpForm_otpInputDi">
                                <div class="OtpForm_otpContainer" style="display: flex;">
                                    <div style="display: flex; align-items: center;">
                                        <v-otp-input ref="otpInput" input-classes="OtpForm_otpInput" separator="" :num-inputs="4" :should-auto-focus="true" :is-input-num="true" @on-complete="completeOtp"/>
                                    </div>
                                </div>
                            </div>
                            <div class="OtpForm_resendOtp">Tidak menerima kode verifikasi?</div>
                            <div class="OtpForm_resendOtp" v-if="timerEnabled">Mohon tunggu <span class="OtpForm_countdown">{{ timerCount }}</span>&nbsp;detik untuk kirim ulang</div>
                            <b-overlay :show="busyResend" opacity="0.7" spinner-small spinner-variant="success">
                                <div :disabled="busyResend" class="OtpForm_resendOtp OtpForm_resendOtpBtn OtpForm_whatsappResend" v-if="!timerEnabled" @click="resend()">KIRIM ULANG VIA WHATSAPP</div>
                            </b-overlay>
                        </div>
                        <b-overlay :show="busy" opacity="0.7" spinner-small spinner-variant="success" class="LoginForm_submitBtn">
                            <b-button :disabled="busy" class="btn btn-primary" block variant="primary" type="submit">Konfirmasi</b-button>
                        </b-overlay>
                    </b-form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Login',
    props: {
        otp: {
            type: Number,
            default: 4
        },
        timer: {
            type: Number,
            default: 60
        }
    },
    data() {
        return {
            busy: false,
            busyResend: false,
            timerCount: this.timer,
            timerEnabled: false,
            formPhone: true,
            formPassword: false,
            formOtp: false,
            form: {
                phone: null,
                password: null,
                otp: null,
                state: null,
            }
        }
    },
    watch: {
        timerEnabled(value) {
            if (value) {
                setTimeout(() => {
                    this.timerCount--;
                }, 1000);
            }
        },
        timerCount: {
            handler(value) {
                if (value > 0 && this.timerEnabled) {
                    setTimeout(() => {
                        this.timerCount--;
                    }, 1000);
                } else {
                    this.timerEnabled = false;
                    this.timerCount = this.timer;
                }
            },
            immediate: true
        }
    },
    methods: {
        completeOtp(value) {
            this.form.otp = value;
            console.log(this.form.otp);
        },
        forgot() {
            this.busyResend = true
            setTimeout(() => {
                this.$store.dispatch('sendOtp', this.form).then(res => {
                    this.pushToast('success', res.data.message);
                }).catch(err => {
                    this.pushToast('danger', err.data.error || err.data.errors.otp[0] || err.data.message);
                }).finally(res => {
                    this.formPassword = false;
                    this.formOtp = true;
                    this.busyResend = false;
                    this.form.state = 'forgot-password';
                    setTimeout(() => {
                        this.timerEnabled = true
                    }, 200)
                });
            }, 500)
        },
        resend() {
            this.busyResend = true
            setTimeout(() => {
                this.$store.dispatch('sendOtp', this.form).then(res => {
                    this.pushToast('success', res.data.message);
                    setTimeout(() => {
                        this.timerEnabled = true
                    }, 200)
                }).catch(err => {
                    this.pushToast('danger', err.data.error || err.data.errors.otp[0] || err.data.message);
                }).finally(res => {
                    this.busyResend = false;
                });
            }, 500)
        },
        submitOtp() {
            this.$validator.validateAll().then(result => {
                if (!result) return;
                this.busy = true;
                setTimeout(() => {
                    this.$store.dispatch('checkOtp', this.form).then(res => {
                        this.formOtp = false;
                        this.formPassword = true;
                    }).catch(err => {
                        this.pushToast('danger', err.data.error || err.data.errors.otp[0] || err.data.message);
                    }).finally(res => {
                        this.busy = false;
                    });
                }, 500)
            })
        },
        submitPassword() {
             this.$validator.validateAll().then(result => {
                if (!result) return;
                this.busy = true
                setTimeout(() => {
                    this.$store.dispatch('login', this.form).then(res => {
                        this.$router.push(this.$route.query.redirect || { name: 'account' })
                    }).catch(err => {
                        this.pushToast('danger', err.data.error || err.data.errors.password[0] || err.data.message);
                    }).finally(res => {
                        this.busy = false;
                    });
                }, 500)
            })
        },
        submitPhone() {
            this.$validator.validateAll().then(result => {
                if (!result) return;
                this.busy = true;
                setTimeout(() => {
                    this.$store.dispatch('checkLogin', this.form).then(res => {
                        this.formPhone = false;
                        if (res.data.otp) {
                            this.formOtp = true;
                            this.timerEnabled = true;
                            this.form.state = 'register';
                            this.pushToast('success', res.data.message);
                        } else {
                            this.formPassword = true;
                        }
                    }).catch(err => {
                        this.pushToast('danger', err.data.error || err.data.errors.phone[0] || err.data.message);
                    }).finally(res => {
                        this.busy = false;
                    });
                }, 500)
            })
        }
    }
}
</script>
