<template>
    <div class="products-page">
        <div class="header">
            <div class="title-n-search">
                <div class="top-header">
                    <img class="products_logo" src="/media/image/logo.png" alt="Tiramart">
                </div>
            </div>
        </div>
        <div class="products_search-outer" style="border-bottom-left-radius: 0px; border-bottom-right-radius: 0px;">
            <div class="products_search">
                <div class="input-group">
                    <img class="products_logo" src="media/image/logo.png" alt="Tiramart" style="margin-top: 5px; margin-right: 10px" v-show="stickyLogo">
                    <div class="input-group-append">
                        <button class="products_search-box products_search-btn btn btn-primary">
                            <i class="products_search-icon"></i>
                        </button>
                    </div>
                    <input class="products_search-box products_search-input md-12 form-control" aria-describedby="basic-addon1" placeholder="Mau beli apa hari ini?" v-model="search" @input="clear = $event.target.value ? true : false">
                    <div class="input-group-append">
                        <button class="products_search-box products_clear-btn btn btn-primary" @click="clear = !clear, search = null">
                            <i class="products_clear-icon" v-show="clear"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <slick class="header-ext" ref="slick" :options="slickOptions" v-if="banners.length > 0">
            <div class="slick-slide" v-for="banner in banners" :key="banner.id">
                <div class="products_banner-slide">
                    <img class="d-block w-100" v-bind:src="'media/image/' + banner.image">
                </div>
            </div>
        </slick>
        <div class="flex-container products_body products_categoryBar scrolling-wrapper">
            <div role="group" class="products_cat-btn-group btn-group btn-group-sm">
                <button class="products_cat-btn btn active btn-light">
                    <img class="products_cat-btn-icon" src="media/image/semua-product.png" alt="Semua Produk">
                    <div class="products_cat-btn-label">Semua Produk</div>
                </button>
                <button class="products_cat-btn btn btn-light">
                    <img class="products_cat-btn-icon" src="media/image/buah.png" alt="Buah">
                    <div class="products_cat-btn-label">Buah</div>
                </button>
                <button class="products_cat-btn btn btn-light">
                    <img class="products_cat-btn-icon" src="media/image/sayuran.png" alt="Sayuran">
                    <div class="products_cat-btn-label">Sayuran</div>
                </button>
                <button class="products_cat-btn btn btn-light">
                    <img class="products_cat-btn-icon" src="media/image/daging.png" alt="Daging">
                    <div class="products_cat-btn-label">Daging</div>
                </button>
                <button class="products_cat-btn btn btn-light">
                    <img class="products_cat-btn-icon" src="media/image/makanan-siap-saji.png" alt="Makanan Siap Saji">
                    <div class="products_cat-btn-label">Makanan Siap Saji</div>
                </button>
                <button class="products_cat-btn btn btn-light">
                    <img class="products_cat-btn-icon" src="media/image/bahan-pokok.png" alt="Bahan Pokok">
                    <div class="products_cat-btn-label">Bahan Pokok</div>
                </button>
                <button class="products_cat-btn btn btn-light">
                    <img class="products_cat-btn-icon" src="media/image/semua-product.png" alt="Bahan Pokok">
                    <div class="products_cat-btn-label">Test</div>
                </button>
            </div>
        </div>
        <div class="body">
            <div class="productCards" >
                <div class="productCard" data-toggle="modal" data-target="#product-modal" v-for="product in products" :key="product.id" @click="modal(product)">
                    <div class="productImageDiv clickable">
                        <div class="productImageWrapper">
                            <img class="productImage" v-bind:src="'media/image/' + product.image">
                        </div>
                        <div v-bind:class="'productLabel ' + product.label "></div>
                    </div>
                    <div class="productBody clickable">
                        <div class="productName">{{ product.title }}</div>
                        <div class="productDescription"></div>
                        <div class="productRating">
                            <div class="rating">
                                <span class="reviewStars">
                                    <span class="ratingIcon iconStarChecked"></span>
                                    <span class="ratingIcon iconStarChecked"></span>
                                    <span class="ratingIcon iconStarChecked"></span>
                                    <span class="ratingIcon iconStarChecked"></span>
                                    <span class="ratingIcon iconStarChecked"></span>
                                </span>
                                <span class="reviewCount">(5)</span>
                            </div>
                        </div>
                        <div class="productSellingUnit">{{ formatWeight(product.weight) }}</div>
                        <div class="productPrice">
                            <span class="productPriceNow">{{ formatCurrency(product.price) }}</span>
                            <span class="productPriceBefore">{{ formatCurrency(product.priceBefore) }}</span>
                        </div>
                    </div>
                    <div class="productAction" @click.stop>
                        <div class="spinnerControl qtyButton" v-show="productCart(product.id)">
                            <i class="spinnerControlIcon buttonMinus clickable" @click="updateCart(product, '-')"></i>
                            <span>{{ quantityCart(product.id) }}</span>
                            <i class="spinnerControlIcon buttonPlus clickable" @click="updateCart(product, '+')"></i>
                        </div>
                        <div v-show="!productCart(product.id)" @click="updateCart(product, '+')">
                            <button class="btn btn-primary d-block w-100 buyButton">BELI</button>
                        </div>
                    </div>
                </div>
            </div>
            <infinite @distance="1" @infinite="infinite" spinner="waveDots"/>
        <modal/>
        </div>
    </div>
</template>

<script>
import Infinite from 'vue-infinite-loading'
import Slick from 'vue-slick'
import { mapGetters } from 'vuex'
export default {
    name: 'Products',
    components: {
        Infinite,
        Slick,
        Modal: () => import( /* webpackChunkName: "modal" */ '../components/products/Modal.vue')
    },
    data() {
        return {
            clear: false,
            search: null,
            searchOuter: null,
            stickyLogo: false,
            slickOptions: {
                arrows: false,
                autoplay: true,
                autoplaySpeed: 2000,
                centerMode: true,
                centerPadding: '10px',
                infinite: true
            }
        }
    },
    computed: {
        ...mapGetters([
            'banners',
            'products'
        ])
    },
    methods: {
        infinite(state) {
            setTimeout(() => {
                this.$store.dispatch('fetchProducts').then(() => {
                    state.loaded();
                });
            }, 500);
        },
        modal(product) {
            this.$store.state.product = product;
        },
        onScroll() {
            this.searchOuter = document.querySelector('.products_search-outer');

            if (window.scrollY >= this.searchOuter.offsetTop) this.stickyLogo = true;
            else this.stickyLogo = false;
        }
    },
    created() {
        if (this.banners.length == 0)
            this.$store.dispatch('fetchBanners');
    },
    mounted() {
        window.addEventListener('scroll', this.onScroll);

        const slider = document.querySelector('.scrolling-wrapper');
        let isDown = false;
        let startX;
        let scrollLeft;

        slider.addEventListener('wheel', (e) => {
            e.preventDefault();
            slider.scrollLeft += e.deltaY;
        });

        slider.addEventListener('mousedown', e => {
            isDown = true;
            slider.classList.add('active');
            startX = e.pageX - slider.offsetLeft;
            scrollLeft = slider.scrollLeft;
        });

        slider.addEventListener('mouseleave', () => {
            isDown = false;
            slider.classList.remove('active');
        });

        slider.addEventListener('mouseup', () => {
            isDown = false;
        });

        slider.addEventListener('mousemove', e => {
            if (!isDown) return;
            e.preventDefault();
            const x = e.pageX - slider.offsetLeft;
            const walk = (x - startX) * 1;
            slider.scrollLeft = scrollLeft - walk;
        });
    },
    beforeDestroy() {
        window.removeEventListener('scroll', this.onScroll);
        // this.$store.state.banners = [];
        // this.$store.state.products = [];
        // this.$store.state.page = 1;
    }
}
</script>
