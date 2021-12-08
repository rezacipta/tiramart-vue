<template>
    <b-form @submit.stop.prevent="submitCart">
        <div class="shopping-cart-page">
            <div class="cart-body details-body">
                <div class="Card_card cart-card">
                    <div class="cardHeader">
                        <h1 class="cardTitle">Produk</h1>
                    </div>
                    <div class="cardBody">
                        <div class="flex-ctr-row">
                            <label class="checkbox_checkbox cart-checkbox">
                                <input type="checkbox" class="checkbox_nativeCheckbox" v-model="checkAll">
                                <span class="checkbox_styledCheckbox"></span>
                            </label>
                            <span><b>Pilih Semua Produk</b></span>
                        </div>
                        <div>
                            <div class="flex-start-row cart-prd-row cart-product" v-for="product in $store.state.cart.products" :key="product.id">
                                <label class="checkbox_checkbox cart-checkbox">
                                    <input type="checkbox" name="product[]" class="checkbox_nativeCheckbox checkbox-product" v-model="product.checked" @click="updateCart(product, 'check')">
                                    <span class="checkbox_styledCheckbox"></span>
                                </label>
                                <div class="d-flex flex-column align-items-stretch justify-content-between flex-grow-1">
                                    <div class="cart-prd-div">
                                        <div class="flex-grow-1 cart-prd-info clickable">
                                            <div class="cart-prd-name">{{ product.title }}</div>
                                            <div class="cart-prd-unit">{{ formatWeight(product.weight) }}</div>
                                            <div class="cart-prd-price">
                                                <div>
                                                    <div>
                                                        <span>{{ formatCurrency(product.price) }}</span>
                                                        <img src="media/image/promo-label-yellow.png" alt="promo" class="cart-promoLabel" style="padding-left: 8px;">
                                                    </div>
                                                    <span class="cart-productPriceBefore">{{ formatCurrency(product.priceBefore) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="shopping_cart_prd-qty">
                                            <div class="spinnerControl qtyButton">
                                                <i class="spinnerControlIcon buttonMinus clickable" @click="updateCart(product, '-')"></i>
                                                <span>{{ quantityCart(product.id) }}</span>
                                                <i class="spinnerControlIcon buttonPlus clickable" @click="updateCart(product, '+')"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="cardLine undefined">
                        <div class="cart-product-total-price">
                            <span>Total Belanja</span>
                            <span>
                                <span class="cart-product-total-price-before" v-if="cart.totalPriceBefore > 0">{{ formatCurrency(cart.totalPriceBefore) }}</span>
                                <span id="total">{{ formatCurrency(cart.totalPrice) }}</span>
                            </span>
                        </div>
                        <div class="cart-savingNotif" v-if="cart.totalPriceBefore > 0">Wah, Anda berhasil hemat <span> {{ formatCurrency(cart.totalPriceBefore - cart.totalPrice) }} </span> di pesanan ini!</div>
                    </div>
                </div>
                <div class="Card_card cart-card">
                    <div class="cardHeader">
                        <h1 class="cardTitle">Informasi Pembeli</h1>
                    </div>
                    <div class="cardBody">
                        <div class="cart-buyer-input">
                            <label class="cart-label" for="form-name">Nama Lengkap</label>
                            <b-form-input name="name" class="form-control" v-model="buyer.name" v-validate="{ required: true }" :state="validateState('name')" data-vv-as="Nama"/>
                            <b-form-invalid-feedback>{{ veeErrors.first('name') }}</b-form-invalid-feedback>
                        </div>
                        <div class="cart-buyer-input">
                            <label class="cart-label" for="form-phoneNumber">Nomor HP (WhatsApp)</label>
                            <b-form-input name="phone" type="number" @keypress="numberOnly" v-model="buyer.phone" v-validate="{ required: true, min:10, max:13, regex:/(08)[0-9]{8}/ }" :state="validateState('phone')" data-vv-as="Nomor HP (Whatsapp)"/>
                            <b-form-invalid-feedback>{{ veeErrors.first('phone') }}</b-form-invalid-feedback>
                        </div>
                    </div>
                </div>
                <div class="Card_card cart-card">
                    <div class="cardBody">
                        <div class="send-as-a-gift">
                            <div class="image-wrapper">
                                <div class="giftIcon"></div>
                            </div>
                            <div class="mx-1">
                                <div class="giftLabel">Kirimkan sebagai hadiah?</div>
                                <div class="giftInfo">Informasi harga tidak akan muncul pada <i>invoice</i> yang didapat oleh penerima.</div>
                            </div>
                            <div class="ml-1">
                                <label class="checkbox_checkbox giftCheckbox">
                                    <input type="checkbox" class="checkbox_nativeCheckbox" name="gift" @click="gift = !gift">
                                    <span class="checkbox_styledCheckbox"></span>
                                </label>
                            </div>
                        </div>
                        <div class="cart-buyer-input" v-show="gift">
                            <label class="cart-label" for="form-name">Pesan Khusus</label>
                            <textarea class="cart-input form-control" style="resize: none;" maxlength="150" name="note"></textarea>
                            <div class="giftNotes" id="gift-note-char">0/150</div>
                            <div class="invalid-feedback">Pesan harus diisi</div>
                        </div>
                    </div>
                </div>
                <div class="Card_card cart-card">
                    <div class="cardHeader">
                        <h1 class="cardTitle">Detail Pengiriman</h1>
                    </div>
                    <div class="cardBody">
                        <section class="deliveryInfoSection">
                            <div class="cart-title-section">
                                <span class="cart-label-section" for="form-fullAddress">Alamat Pengiriman</span>
                                <div class="editAddressBtn clickable" role="button" v-if="address.length">Pilih Alamat Lain</div>
                            </div>
                            <div class="addressCard" v-if="address.length">
                                <div class="nameData">{{ address.name }}</div>
                                <div class="recipientData">{{ address.recipient_name }} · {{ address.phone }}</div>
                                <div class="cart-buyer-input">
                                    <div class="d-flex flex-column">
                                        <div class="shopping_cart_fullAddressField">{{ address.address }}</div>
                                        <div class="shopping_cart_districtRegencyField">{{ address.subdistrict.name }}, {{ address.city.name }}, {{ address.province.name }}</div>
                                        <div class="shopping_cart_detailAddress">{{ address.detail }}</div>
                                    </div>
                                    <input type="radio" name="address" class="nativeRadioButton" value="$address->id" required checked>
                                    <div class="invalid-feedback">Alamat Pengiriman harus diisi</div>
                                </div>
                            </div>
                            <div class="cart-buyer-input" v-if="!address.length" @click="$router.push({ name: 'address' })">
                                <div class="addressBtn clickable no-address">
                                    <div class="addressBtnText">Tetapkan Alamat Pengiriman</div>
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" class="shopping_cart_addressArrow">
                                        <path d="M1.875 10H18.75" stroke="#2A960C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path d="M7.5 3.125L1.25 10L7.5 16.875" stroke="#2A960C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                </div>
                                <b-form-input name="address" style="display: none" v-model="address.address" v-validate="{ required: true }" :state="validateState('address')" data-vv-as="Alamat pengiriman"/>
                                <b-form-invalid-feedback>{{ veeErrors.first('address') }}</b-form-invalid-feedback>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
        <div class="FooterButtons_two-btn-footer-row width-control">
            <button type="button" class="btn btn-light FooterButtons_back-btn-footer FooterButtons_two-btn-footer" @click="$router.go(-1)">Kembali</button>
            <b-overlay :show="busy" opacity="0.7" spinner-small spinner-variant="success" class="FooterButtons_two-btn-footer">
                <b-button :disabled="busy" class="btn btn-primary" block variant="primary" type="submit">Selanjutnya</b-button>
            </b-overlay>
        </div>
    </b-form>
</template>

<script>
import {mapGetters} from 'vuex'
export default {
    name: 'Cart',
    data() {
        return {
            busy: false,
            gift: false,
        }
    },
    mounted() {
        window.scrollTo(0, 0)
    },
    computed: {
        ...mapGetters([
            'address',
            'buyer',
            'cart'
        ]),
        checkAll: {
            set(checked) {
                this.$store.state.cart.products.forEach(function (product) {
                    product.checked = checked;
                });
                this.$store.state.cartMethod = 'checkAll';
                this.$store.commit('UPDATE_CART');
            },
            get() {
                return this.cart.products.every(function (product) {
                    return product.checked ;
                });
            }
        }
    },
    methods: {
        submitCart() {
            this.$validator.validateAll().then(result => {
                if (!result) return;
                this.busy = true;
                setTimeout(() => {
                    this.$store.commit('FETCH_BUYER', this.buyer);
                    this.busy = false;
                }, 500)
            })
        }
    }
}
</script>
