<template>
    <div class="footer width-control">
        <div class="cartChkBar md-14" v-if="$store.state.cart.totalQuantity > 0" v-show="$route.name == 'products'">
            <div class="chkTxt">
                <router-link class="position-relative clickable" :to="{name: 'cart'}">
                    <span class="material-icons smallIcon">shopping_basket</span>
                    <div class="quantityLabel">
                        <div v-text="$store.state.cart.totalQuantity"></div>
                    </div>
                </router-link>
                <div class="ml-2 mr-2">
                    <div class="container-fluid">
                        <div class="p-0 contentCenter checkout-bar_price row row-cols-auto">
                            <div v-text="formatCurrency($store.state.cart.totalPrice)"></div>
                        </div>
                        <div class="p-0 contentCenter checkout-bar_priceBefore row row-cols-auto">
                            <div v-text="formatCurrency($store.state.cart.totalPriceBefore)"></div>
                        </div>
                    </div>
                </div>
            </div>
            <router-link class="flex-ctr-row cartBtnRow" :to="{name: 'cart'}"><input class="cartBtn btn btn-primary md-14" type="submit" value="Lanjut"></router-link>
        </div>
        <div class="footer_nav nav">
            <div class="footer_menuBtnDiv">
                <div class="footer_menuNavItem nav-item">
                    <router-link class="footer_menuNavLink nav-link" :to="{name: 'products'}">
                        <div class="footer_footerNavBtn footer_flexCol">
                            <span class="material-icons footer_icon">category</span>
                            <span>Produk</span>
                        </div>
                    </router-link>
                </div>
            </div>
            <div class="footer_menuBtnDiv">
                <div class="footer_menuNavItem nav-item">
                    <router-link class="footer_menuNavLink nav-link" :to="{name: 'cart'}">
                        <div class="footer_footerNavBtn footer_flexCol">
                            <span class="material-icons footer_icon">shopping_basket</span>
                            <span>Keranjang</span>
                        </div>
                    </router-link>
                </div>
            </div>
            <div class="footer_menuBtnDiv">
                <div class="footer_menuNavItem nav-item">
                    <a class="footer_menuNavLink nav-link">
                        <div class="footer_footerNavBtn footer_flexCol">
                            <span class="material-icons footer_icon">menu_book</span>
                            <span>Pesanan</span>
                        </div>
                    </a>
                </div>
            </div>
            <div class="footer_menuBtnDiv">
                <div class="footer_menuNavItem nav-item">
                    <router-link class="footer_menuNavLink nav-link" :to="{name: 'help'}">
                        <div class="footer_footerNavBtn footer_flexCol">
                            <span class="material-icons footer_icon">contact_support</span>
                            <span>Bantuan</span>
                        </div>
                    </router-link>
                </div>
            </div>
            <div class="footer_menuBtnDiv">
                <div class="footer_menuNavItem nav-item">
                    <router-link class="footer_menuNavLink nav-link" :to="{name: 'account'}" v-bind:class="$route.meta.group == 'account' ? 'active' : ''">
                        <div class="footer_footerNavBtn footer_flexCol">
                            <span class="material-icons footer_icon">account_circle</span>
                            <span>Akun</span>
                        </div>
                    </router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Footer'
}
</script>
