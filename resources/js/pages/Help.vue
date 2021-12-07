<template>
    <div class="HelpPage_page">
        <div class="HelpSection_helpBody details-body">
            <div class="Card_card HelpSection_helpCard HelpSection_helpCustomerService">
                <div class="Card_cardBody">
                    <h2 class="HelpSection_helpCustomerServiceTitle">WhatsApp Customer Service</h2>
                    <div><a class="HelpSection_helpCustomerServiceNumber" target="_blank" rel="noopener noreferrer" href="https://wa.me/+6281281773557?text=Halo%20Tiramart!%20Saya%20ingin%20belanja,%20gimana%20caranya?">0812-8177-3557</a></div>
                </div>
            </div>
            <div class="collapse-card_collapseCard HelpSection_helpCard">
                <div class="collapse-card_collapseCardHeader" v-b-toggle="'help1'" @click="toggleItem(1)">
                    <h1>Kenapa saya tidak bisa membuka menu tertentu?</h1>
                    <i v-bind:class="isCollapse(1) ? 'collapse-card_icon collapse-card_iconCollapse' : 'collapse-card_icon collapse-card_iconExpand'"></i>
                </div>
                <b-collapse class="collapse-card_collapseCardBody" v-bind:id="'help1'">
                    <div>Website Tiramart masih dalam tahap pengembangan, tunggu update selanjutnya.</div>
                </b-collapse>
            </div>
            <div class="collapse-card_collapseCard HelpSection_helpCard">
                <div class="collapse-card_collapseCardHeader" v-b-toggle="'help2'" @click="toggleItem(2)">
                    <h1>Bagaimana cara menyampaikan saran atau keluhan yang saya miliki?</h1>
                    <i v-bind:class="isCollapse(2) ? 'collapse-card_icon collapse-card_iconCollapse' : 'collapse-card_icon collapse-card_iconExpand'"></i>
                </div>
                <b-collapse class="collapse-card_collapseCardBody" v-bind:id="'help2'">
                    <div>Anda bisa mengubungi nomor customer service kami di 0812-8177-3557. Kami akan melayani Anda secepatnya di jam operasional kami.</div>
                </b-collapse>
            </div>
            <div class="collapse-card_collapseCard HelpSection_helpCard">
                <div class="collapse-card_collapseCardHeader" v-b-toggle="'help3'" @click="toggleItem(3)">
                    <h1>Apakah Tiramart sudah berbadan hukum?</h1>
                    <i v-bind:class="isCollapse(3) ? 'collapse-card_icon collapse-card_iconCollapse' : 'collapse-card_icon collapse-card_iconExpand'"></i>
                </div>
                <b-collapse class="collapse-card_collapseCardBody" v-bind:id="'help3'">
                    <div>Ya. Bisnis kami berbadan hukum Perseroan Terbatas (PT) dengan nama PT Tira Satria Niaga, Tbk.</div>
                </b-collapse>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Help',
    data() {
        return {
            toggled: []
        }
    },
    methods: {
        isCollapse(item) {
            return this.toggled.indexOf(item) >= 0;
        },
        toggleItem(item) {
            const index = this.toggled.indexOf(item);

            if (index >= 0) {
                this.toggled.splice(index, 1);
                return;
            }

            this.toggled.push(item);
        },
    }
}
</script>
