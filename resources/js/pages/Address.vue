<template>
    <b-form @submit.stop.prevent="submitAddress">
        <div class="detailsHdrBody AddressPage_body">
            <div class="Card_card AddressPage_cardGap AddressPage_outerDiv">
                <div class="cardBody">
                    <div class="AddressPage_inputDiv" style="margin-top: 20px;">
                        <div class="AddressPage_titleCard">Informasi Penerima</div>
                        <div class="AddressPage_inputTitle">Nama Penerima&nbsp;<span class="AddressPage_req">*</span></div>
                        <b-form-input name="recipientName" class="form-control" v-model="recipientName" v-validate="{ required: true }" :state="validateState('recipientName')" data-vv-as="Nama penerima"/>
                        <b-form-invalid-feedback>{{ veeErrors.first('recipientName') }}</b-form-invalid-feedback>
                    </div>
                    <div class="AddressPage_inputDiv" style="margin-top: 20px;">
                        <div class="AddressPage_inputTitle">Nomor HP (WhatsApp)&nbsp;<span class="AddressPage_req">*</span></div>
                        <b-form-input name="recipientPhone" class="form-control" @keypress="numberOnly" v-model="recipientPhone" v-validate="{ required: true, min:10, max:13, regex:/(08)[0-9]{8}/ }" :state="validateState('recipientPhone')" data-vv-as="Nomor penerima"/>
                        <b-form-invalid-feedback>{{ veeErrors.first('recipientPhone') }}</b-form-invalid-feedback>
                    </div>
                </div>
            </div>
            <div class="Card_card AddressPage_outerDiv">
                <div class="cardBody">
                    <div class="AddressPage_inputDiv">
                        <div class="AddressPage_inputTitle">Provinsi&nbsp;<span class="AddressPage_req">*</span></div>
                        <select2 name="province" :options="optionsProvince" v-model="province" v-validate="{ required: true }">
                            <option value="" selected disabled>Pilih Provinsi</option>
                        </select2>
                    </div>
                    <div class="AddressPage_inputDiv">
                        <div class="AddressPage_inputTitle">Kota / Kabupaten&nbsp;<span class="AddressPage_req">*</span></div>
                        <select2 name="city" :options="optionsCity" v-model="city" :disabled="!province" v-validate="{ required: true }">
                            <option value="" selected disabled>Pilih Kota</option>
                        </select2>
                    </div>
                    <div class="AddressPage_inputDiv">
                        <div class="AddressPage_inputTitle">Kecamatan&nbsp;<span class="AddressPage_req">*</span></div>
                        <select2 name="city" :options="optionsSubdistrict" v-model="subdistrict" :disabled="!city" v-validate="{ required: true }">
                            <option value="" selected disabled>Pilih Kecamatan</option>
                        </select2>
                    </div>
                    <div class="AddressPage_inputDiv">
                        <div class="AddressPage_inputTitle">Kode Pos&nbsp;<span class="AddressPage_req">*</span></div>
                        <b-form-input name="postalcode" class="form-control" type="number" @keypress="numberOnly" v-model="postalcode" v-validate="{ required: true, min:5  }" :state="validateState('postalcode')" data-vv-as="Kode pos"/>
                        <b-form-invalid-feedback>{{ veeErrors.first('postalcode') }}</b-form-invalid-feedback>
                    </div>
                    <div class="AddressPage_inputDiv" style="margin-top: 20px;">
                        <div class="AddressPage_inputTitle">Nama Jalan, Gedung, No. Rumah&nbsp;<span class="AddressPage_req">*</span></div>
                        <b-form-textarea name="fullAddress" class="AddressPage_inputBox form-control" placeholder="Contoh: Jl.Raya Bogor No.1" rows="3" v-model="fullAddress" v-validate="{ required: true }" :state="validateState('fullAddress')" data-vv-as="Alamat lengkap"></b-form-textarea>
                        <b-form-invalid-feedback>{{ veeErrors.first('fullAddress') }}</b-form-invalid-feedback>
                    </div>
                    <div class="AddressPage_inputDiv" style="margin-top: 20px;">
                        <div class="AddressPage_inputTitle">Detail (Patokan/Blok/Unit no.)&nbsp;</div>
                        <b-form-input name="detail" class="form-control" v-model="detail"/>
                    </div>
                    <div class="AddressPage_inputDiv" style="margin-top: 20px;">
                        <div class="AddressPage_inputTitle">Simpan Sebagai Alamat (<i>Mis: Rumah, Kantor</i>)&nbsp;<span class="AddressPage_req">*</span></div>
                        <b-form-input name="name" class="form-control" v-model="name" v-validate="{ required: true }" :state="validateState('name')" data-vv-as="Nama alamat"/>
                        <b-form-invalid-feedback>{{ veeErrors.first('name') }}</b-form-invalid-feedback>
                    </div>
                    <div class="AddressPage_inputDiv" style="margin-top: 20px;">
                        <div class="AddressPage_mainAddressContainer">
                            <label class="checkbox_checkbox clickable">
                                <input name="is_main" type="checkbox" class="checkbox_nativeCheckbox" v-model="isMain"><span class="checkbox_styledCheckbox"></span>
                            </label>
                            <div class="AddressPage_isMainTitle">Jadikan alamat ini alamat utama</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="FooterButtons_two-btn-footer-row width-control">
            <b-overlay :show="busy" opacity="0.7" spinner-small spinner-variant="success" class="FooterButtons_two-btn-footer">
                <b-button :disabled="busy" class="btn btn-primary" block variant="primary" type="submit">Simpan Alamat Pengiriman</b-button>
            </b-overlay>
        </div>
    </b-form>
</template>

<script>
import api from '../api.js'
import Select2 from '../components/Select2.vue'
export default {
    name: 'Address',
    components: {
        Select2
    },
    data() {
        return {
            busy: false,
            id: null,
            recipientName: null,
            recipientPhone: null,
            province: null,
            city: null,
            subdistrict: null,
            postalcode: null,
            fullAddress: null,
            detail: null,
            name: null,
            isMain: false,
            optionsProvince: [],
            optionsCity: [],
            optionsSubdistrict: [],
            editAddress: this.$store.state.address.listAddress[this.$store.state.address.indexSelected]
        }
    },
    created() {
        this.fetchProvince();
    },
    mounted() {
        window.scrollTo(0, 0);

        if (this.$store.state.editAddress) {
            setTimeout(() => {
                this.id = this.editAddress.id;
                this.recipientName = this.editAddress.recipientName;
                this.recipientPhone = this.editAddress.recipientPhone;
                this.fullAddress = this.editAddress.fullAddress;
                this.detail = this.editAddress.detail;
                this.name = this.editAddress.name;
                this.isMain = this.editAddress.isMain;
            }, 500)
        }
    },
    watch: {
        province: function(id) {
            this.city = null;
            this.postalcode = null;
            this.fetchCity(id);
        },
        city: function(id) {
            this.postalcode = null;
            this.fetchSubdistrict(id);
        },
        subdistrict: function(id) {
            this.optionsSubdistrict.postalcode.find(item => {
                if (item.id == id)
                    this.postalcode = item.postal_code;
            })
        }
    },
    methods: {
        fetchProvince() {
            api.get('/api/province').then(res => {
                this.optionsProvince = res.data;

                if (this.$store.state.editAddress) {
                    setTimeout(() => {
                        this.province = this.editAddress.provinceId
                    }, 100)
                }
            }).catch(err => {
                console.log(err);
            });
        },
        fetchCity(id) {
            api.get('/api/city/' + id).then(res => {
                this.optionsCity = res.data;

                if (this.$store.state.editAddress) {
                    setTimeout(() => {
                        this.city = this.editAddress.cityId
                    }, 100)
                }
            }).catch(err => {
                console.log(err);
            });
        },
        fetchSubdistrict(id) {
            api.get('/api/subdistrict/' + id).then(res => {
                this.optionsSubdistrict = res.data;

                if (this.$store.state.editAddress) {
                    setTimeout(() => {
                        this.subdistrict = this.editAddress.subdistrictId
                        this.postalcode = this.editAddress.postalcode
                    }, 100)
                }
            }).catch(err => {
                console.log(err);
            });
        },
        submitAddress() {
            this.$validator.validateAll().then(result => {
                if (!result) return;
                this.busy = true;
                setTimeout(() => {
                    this.$store.dispatch('saveAddress', {
                        id: this.id,
                        recipientName: this.recipientName,
                        recipientPhone: this.recipientPhone,
                        province: this.province,
                        city: this.city,
                        subdistrict: this.subdistrict,
                        postalcode: this.postalcode,
                        fullAddress: this.fullAddress,
                        detail: this.detail,
                        name: this.name,
                        isMain: this.isMain,
                    }).then(res => {
                        console.log(res);
                        this.pushToast('success', 'Alamat berhasil disimpan.');
                        this.$router.push({ name: 'address.list' })
                    }).catch(err => {
                        console.log(err);
                        this.pushToast('danger', err.data.error || 'Alamat gagal disimpan.');
                    }).finally(res => {
                        this.busy = false;
                    });
                }, 500)
            })
        }
    }
}
</script>
