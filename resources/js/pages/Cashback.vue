<template>
    <div class="OrdersHistoryPage_page">
        <div class="detailsHdrBody OrdersHistoryPage_divBody">
            <div class="input-group OrdersHistoryPage_divOrder">
                <div class="AddressPage_inputTitle" style="margin-top:-5px; margin-bottom: -5px;">Periode&nbsp;<span class="AddressPage_req">*</span></div>
            </div>
            <div class="input-group OrdersHistoryPage_divOrder">
                <select class="form-control" style="padding-top: 0px; padding-bottom: 0px; margin-right: 15px" v-model="year" @change="fetchCashback()">
                    <option v-for="year in years" :key="year" v-bind:value="year" v-text="year" v-bind:selected="year == year"></option>
                </select>
                <select class="form-control" style="padding-top: 0px; padding-bottom: 0px;" v-model="toggled" @change="toggleItem()">
                    <option value="cashback">Cashback</option>
                    <option value="paid">Paid</option>
                </select>
            </div>
            <div class="input-group OrdersHistoryPage_divOrder">
                <div class="input-group-append">
                    <button type="button" class="products_search-box products_search-btn btn btn-primary">
                        <i class="products_search-icon"></i>
                    </button>
                </div>
                <input placeholder="Cari bulan ?" class="products_search-box products_search-input md-12 form-control" v-model="search" @input="clear = $event.target.value ? true : false">
                <div class="input-group-append">
                    <button class="products_search-box products_clear-btn btn btn-primary" @click="clear = !clear, search = ''">
                        <i class="products_clear-icon" v-show="clear"></i>
                    </button>
                </div>
            </div>
            <!-- paid -->
            <div class="Card_card OrdersHistoryPage_divOrder collapse-card_collapseCard" v-show="showPaid" v-for="(item, index) in filtered" :key="'paid-' + index">
                <div class="Card_cardBody clickable" v-b-toggle="'paid-' + index" @click="toggleItemPaid(index)">
                    <div class="OrdersHistoryPage_divOrderStatus OrdersHistoryPage_statusNotConfirmed">
                        <span class="OrdersHistoryPage_divOrderTitleContent">{{ item.label }}</span>
                        <i class="material-icons md-dark">{{ isCollapsePaid(index) ? 'expand_more' : 'expand_less' }}</i>
                    </div>
                </div>
                <b-collapse class="Card_cardBody" v-bind:id="'paid-' + index" visible>
                    <div class="undefined OrdersHistoryPage_divOrderDetails">
                        <div>
                            <div class="DetailsTable_detBodyRow">
                                <div class="DetailsTable_cartLabel">Cashback</div>
                                <div class="DetailsTable_cartInput">{{ formatCurrency(item.cashback) }}</div>
                            </div>
                            <div class="DetailsTable_detBodyRow">
                                <div class="DetailsTable_cartLabel">Other</div>
                                <div class="DetailsTable_cartInput">{{ formatCurrency(item.other) }}</div>
                            </div>
                            <div class="DetailsTable_detBodyRow">
                                <div class="DetailsTable_cartLabel">Subtotal</div>
                                <div class="DetailsTable_cartInput">{{ formatCurrency(item.subtotal) }}</div>
                            </div>
                        </div>
                    </div>
                    <a target="_blank" class="btn btn-secondary OrdersHistoryPage_orderDetailBtn" @click="downloadPdf(item.periode)">Unduh PDF</a>
                </b-collapse>
            </div>
            <!-- cashback -->
            <div class="Card_card OrdersHistoryPage_divOrder collapse-card_collapseCard" v-show="showCashback" v-for="(item, index) in filtered" :key="'cashback-' + index">
                <div class="Card_cardBody clickable" v-b-toggle="'cashback-' + index" @click="toggleItemCashback(index)">
                    <div class="OrdersHistoryPage_divOrderStatus OrdersHistoryPage_statusNotConfirmed">
                        <span class="OrdersHistoryPage_divOrderTitleContent">{{ item.label }}</span>
                        <i class="material-icons md-dark">{{ isCollapseCashback(index) ? 'expand_more' : 'expand_less' }}</i>
                    </div>
                </div>
                <b-collapse class="Card_cardBody" v-bind:id="'cashback-' + index" visible>
                    <div class="undefined OrdersHistoryPage_divOrderDetails">
                        <div v-for="item in cashback[item.periode]" :key="item.order_kp">
                            <div class="OrdersHistoryPage_divOrderTitle undefined">
                                <div class="OrdersHistoryPage_divOrderTitleCol">
                                    <span class="OrdersHistoryPage_divOrderTitleLabel">{{ item.order_date }}</span>
                                    <span class="OrdersHistoryPage_divOrderTitleContent">No. KP : {{ item.order_kp }}</span>
                                    <span class="OrdersHistoryPage_divOrderTitleContent">No. MP : {{ item.order_mp }}</span>
                                    <span class="OrdersHistoryPage_divOrderTitleLabel">Marketplace : {{ item.marketplace }}</span>
                                </div>
                                <div class="OrdersHistoryPage_divOrderTitleCol OrdersHistoryPage_algRight">
                                    <span class="OrdersHistoryPage_divOrderTitleLabel">Cashback</span>
                                    <span class="OrdersHistoryPage_divOrderTitleContent">{{ formatCurrency(item.cashback) }}</span>
                                </div>
                            </div>
                            <hr class="Card_cardLine undefined">
                        </div>
                        <div class="OrdersHistoryPage_divOrderTitle undefined">
                            <div class="OrdersHistoryPage_divOrderTitleCol">
                            </div>
                            <div class="OrdersHistoryPage_divOrderTitleCol OrdersHistoryPage_algRight">
                                <span class="OrdersHistoryPage_divOrderTitleLabel">Subtotal</span>
                                <span class="OrdersHistoryPage_divOrderTitleContent">{{ formatCurrency(item.subtotalCashback) }}</span>
                            </div>
                        </div>
                    </div>
                    <a class="btn btn-secondary OrdersHistoryPage_orderDetailBtn" @click="downloadExcel(item.periode)">Unduh XLS</a>
                </b-collapse>
            </div>
            <div class="OrdersHistoryPage_emptyOrderMessage" v-if="paid.length == 0">
                <div class="OrdersHistoryPage_sadFace">☹</div>
                Maaf, data Anda belum tersedia. Coba nanti lagi ya.
            </div>
        </div>
    </div>
</template>

<script>
import api from '../api.js'
export default {
    name: 'Cashback',
    data() {
        return {
            clear: false,
            search: '',
            cashback: [],
            paid: [],
            showCashback: true,
            showPaid: false,
            years: [],
            year: new Date().getFullYear(),
            toggledCashback: [],
            toggledPaid: [],
            toggled: 'cashback',
        }
    },
    created() {
        this.fetchCashback()
    },
    computed: {
        filtered() {
            return Object.values(this.paid).filter(p => {
                return p.label.toLowerCase().includes(this.search);
            });
        }
    },
    methods: {
        downloadExcel(periode) {
            api.post('/api/cashback/excel', { periode: periode }).then(res => {
                window.open(res.data)
            }).catch(err => {
                console.log(err);
            });
        },
        downloadPdf(periode) {
            api.post('/api/cashback/pdf', { periode: periode }).then(res => {
                window.open(res.data)
            }).catch(err => {
                console.log(err);
            });
        },
        fetchCashback() {
            api.post('/api/cashback', { year: this.year }).then(res => {
                this.cashback = res.data.cashback;
                this.paid = res.data.paid;
                this.years = res.data.years;
            }).catch(err => {
                console.log(err);
            });
        },
        isCollapseCashback(item) {
            return this.toggledCashback.indexOf(item) >= 0;
        },
        toggleItemCashback(item) {
            const index = this.toggledCashback.indexOf(item);

            if (index >= 0) {
                this.toggledCashback.splice(index, 1);
                return;
            }

            this.toggledCashback.push(item);
        },
        isCollapsePaid(item) {
            return this.toggledPaid.indexOf(item) >= 0;
        },
        toggleItemPaid(item) {
            const index = this.toggledPaid.indexOf(item);

            if (index >= 0) {
                this.toggledPaid.splice(index, 1);
                return;
            }

            this.toggledPaid.push(item);
        },
        toggleItem() {
            if (this.toggled == 'cashback') {
                this.showCashback = true;
                this.showPaid = false;
            } else {
                this.showCashback = false;
                this.showPaid = true;
            }
        }
    }
}
</script>
