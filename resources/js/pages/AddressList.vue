<template>
<b-form @submit.prevent="submitAddress">
    <div class="AddressListPage_page">
        <div class="AddressListPage_accountBody AddressListPage_bodySelectMode">
            <div class="AddressListPage_titleBody" v-if="address.listAddress.length">Pilih Alamat</div>
            <div class="AddressListPage_containerAddresses">
                <div class="AddressListPage_addressItem clickable" v-for="(item, index) in address.listAddress" :key="item.id" @click="address.indexSelected = index" v-bind:class="address.indexSelected == index ? 'AddressListPage_selected' : 'AddressListPage_notSelected'">
                    <label class="radio-button_radioButtonTop clickable mr-3">
                        <input type="radio" name="selected" class="radio-button_nativeRadioButton" v-bind:value="index" v-model="address.indexSelected">
                        <span class="radio-button_styledRadioButton"></span>
                    </label>
                    <div class="d-flex flex-column flex-grow-1">
                        <div class="d-flex flex-row">
                            <div class="d-flex flex-column flex-grow-1">
                                <div class="nameData">{{ item.name }}</div>
                                <div class="recipientData">{{ item.recipientName }} · {{ item.recipientPhone }}</div>
                            </div>
                            <div class="AddressListPage_optionsInOrderStatus">
                                <b-dropdown size="sm" variant="white" right no-caret @click.stop>
                                    <template #button-content>
                                    <span class="editAddressBtn">ATUR</span>
                                    </template>
                                    <b-dropdown-item href="#" @click="editAddress(index)">Ubah Alamat</b-dropdown-item>
                                    <b-dropdown-item href="#" variant="danger" data-toggle="modal" data-target="#confirm-modal" @click="deleteAddress(item.id, item.name)">Hapus Alamat</b-dropdown-item>
                                </b-dropdown>
                                <!-- <div class="fade AddressListPage_optionsOverlay dropdown-menu">
                                    <div>Ubah Alamat</div>
                                    <div>Hapus Alamat</div>
                                </div> -->
                            </div>
                        </div>
                        <div>
                            <div class="AddressListPage_fullAddressData">{{ item.fullAddress }}</div>
                            <div class="AddressListPage_districtRegencyData">{{ item.subdistrict }}, {{ item.city }}, {{ item.province }}, {{ item.postalcode }}</div>
                            <div class="AddressListPage_detailAddress">{{ item.detail }}</div>
                            <div class="d-flex flex-row" v-if="item.isMain">
                                <div class="AddressListPage_mainAddressNote">ALAMAT UTAMA</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="AddressListPage_titleBody">Buat Alamat Baru</div>
            <a class="AddressListPage_greenBtn clickable" @click="$store.state.editAddress = false, $router.push({name:'address'})">
                <div class="AddressListPage_greenBtnText">Tambahkan Alamat Baru</div>
                <svg width="16" height="22" viewBox="0 0 16 22" fill="none" class="AddressListPage_icon">
                    <path d="M8 0.5C3.85953 0.5 0.5 3.52391 0.5 7.25C0.5 13.25 8 21.5 8 21.5C8 21.5 15.5 13.25 15.5 7.25C15.5 3.52391 12.1405 0.5 8 0.5ZM8 11C7.40666 11 6.82664 10.8241 6.33329 10.4944C5.83994 10.1648 5.45542 9.69623 5.22836 9.14805C5.0013 8.59987 4.94189 7.99667 5.05764 7.41473C5.1734 6.83279 5.45912 6.29824 5.87868 5.87868C6.29824 5.45912 6.83279 5.1734 7.41473 5.05764C7.99667 4.94189 8.59987 5.0013 9.14805 5.22836C9.69623 5.45542 10.1648 5.83994 10.4944 6.33329C10.8241 6.82664 11 7.40666 11 8C10.9991 8.79538 10.6828 9.55794 10.1204 10.1204C9.55794 10.6828 8.79538 10.9991 8 11Z" fill="#0C7800"></path>
                </svg>
            </a>
        </div>
        <div class="FooterButtons_two-btn-footer-row width-control">
            <button type="submit" class="btn btn-primary FooterButtons_two-btn-footer FooterButtons_primary-color">Pilih Alamat Pengiriman</button>
        </div>
    </div>
    <confirm-dialogue ref="confirmDialogue"></confirm-dialogue>
</b-form>
</template>

<script>
import api from '../api.js'
import {mapGetters} from 'vuex'
export default {
    name: 'AddressList',
    components: {
        ConfirmDialogue: () => import( /* webpackChunkName: "modal" */ '../components/ConfirmDialogue.vue'),
    },
    computed: {
        ...mapGetters([
            'address'
        ]),
    },
    methods: {
        async deleteAddress(id, name) {
            const confirm = await this.$refs.confirmDialogue.show({
                message: 'Hapus ' + name + ' dari daftar alamat ?'
            });
            if (confirm) {
                api.delete('/api/address/' + id).then(res => {
                    let index = this.address.listAddress.findIndex(item => item.id == id)
                    this.address.listAddress.splice(index, 1);
                    this.address.indexSelected = 0;
                    localStorage.setItem('address', JSON.stringify(this.address));
                    this.pushToast('success', 'Alamat berhasil dihapus.');
                }).catch(err => {
                    console.log(err);
                    this.pushToast('danger', err.data.error || 'Alamat gagal dihapus.');
                });
            }
        },
        editAddress(index) {
            this.$store.state.editAddress = true;
            this.$store.state.address.indexSelected = index;
            this.$router.push({ name: 'address' });
        },
        submitAddress() {
            localStorage.setItem('address', JSON.stringify(this.address));
            this.$router.push({ name:'cart' });
        }
    }
}
</script>
