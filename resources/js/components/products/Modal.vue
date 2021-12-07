<template>
    <div id="product-modal" role="dialog" class="fade ProductDetailsPopup_modal modal show" tabindex="-1" aria-hidden="true">
        <div role="document" class="modal-dialog">
            <div class="modal-content">
                <div class="ProductDetailsPopup_modalBody modal-body">
                    <div class="ProductDetailsPopup_modalBody modal-body">
                        <div class="ProductDetailsPopup_closeContainer">
                            <div class="ProductDetailsPopup_closeButton" data-dismiss="modal" aria-label="Close">
                                <div class="ProductDetailsPopup_closeIcon"></div>
                            </div>
                        </div>
                        <div class="ScrollableGradient_scrollWrapper">
                            <div class="ScrollableGradient_scrollGradient"></div>
                            <div class="ScrollableGradient_scrollContainer">
                                <div class="ProductDetailsPopup_productImageDiv">
                                    <div class="ProductDetailsPopup_productImageWrapper">
                                        <img class="ProductDetailsPopup_productImagePopup" v-if="product" v-bind:src="'media/image/' + (product ? product.image : '')">
                                    </div>
                                    <div v-bind:class="'productLabel ' + (product ? product.label : '')"></div>
                                </div>
                                <div class="ProductDetailsPopup_productBody">
                                    <div class="ProductDetailsPopup_productName">{{ product ? product.title : '' }}</div>
                                    <div class="ProductDetailsPopup_productSellingUnit">{{ formatWeight(product ? product.weight : 0) }}</div>
                                    <div class="ProductDetailsPopup_productRating">
                                        <div class="Rating_rating">
                                            <span class="Rating_reviewStars">
                                                <span class="Rating_icon Rating_iconStarChecked"></span>
                                                <span class="Rating_icon Rating_iconStarChecked"></span>
                                                <span class="Rating_icon Rating_iconStarChecked"></span>
                                                <span class="Rating_icon Rating_iconStarChecked"></span>
                                                <span class="Rating_icon Rating_iconStarChecked"></span>
                                            </span>
                                            <span class="Rating_reviewCount">(5)</span>
                                        </div>
                                    </div>
                                    <div class="ProductDetailsPopup_categoryWrapper">
                                        <span class="ProductDetailsPopup_categoryImage">
                                            <img src="media/image/bahan-pokok.png" alt="Bahan Pokok">
                                        </span>
                                        <span class="ProductDetailsPopup_categoryName">Bahan Pokok</span>
                                    </div>
                                    <div class="ProductDetailsPopup_productDescription">{{ product ? product.title : '' }}</div>
                                </div>
                            </div>
                            <div class="ScrollableGradient_scrollGradient" style="bottom: 0px; background: linear-gradient(rgba(0, 0, 0, 0) 0%, rgb(0, 0, 0) 100%); opacity: 0;"></div>
                        </div>
                        <div class="ProductDetailsPopup_productFooter mt-3">
                            <div class="ProductDetailsPopup_productPrice">
                                <span class="ProductDetailsPopup_productPriceNow">
                                    <span>{{ formatCurrency(product ? product.price : 0) }}</span>
                                    <img src="media/image/promo-label-yellow.png" alt="promo" class="ProductDetailsPopup_promoLabel" style="padding-left: 8px;">
                                </span>
                            </div>
                            <div>
                                <div class="spinner-control_spinnerControl ProductDetailsPopup_spinnerControl" v-show="product ? productCart(product.id) : false">
                                    <i class="spinner-control_icon spinner-control_buttonMinus buttonMinus clickable" @click="updateCart(product, '-')"></i>
                                    <span>{{ product ? quantityCart(product.id) : 0 }}</span>
                                    <i class="spinner-control_icon spinner-control_buttonPlus buttonPlus clickable" @click="updateCart(product, '+')"></i>
                                </div>
                                <div v-show="product ? !productCart(product.id) : false">
                                    <button class="btn btn-primary d-block w-100 ProductDetailsPopup_buyButton buttonBuy" @click="updateCart(product, '+')">BELI</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {mapGetters} from 'vuex'
export default {
    name: 'Modal',
    computed: {
        ...mapGetters([
            'product'
        ])
    }
}
</script>
