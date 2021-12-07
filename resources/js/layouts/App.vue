<template>
    <div>
        <vue-progress-bar/>
        <vue-loading :active="loading" class="page" loader="dots" color="#2A960C"/>
        <header-view v-show="header" :title="title"/>
        <router-view :key="$route.fullPath"></router-view>
        <footer-view v-show="footer"/>
    </div>
</template>

<script>
import VueLoading from 'vue-loading-overlay';
export default {
    name: 'App',
    components: {
        VueLoading,
        HeaderView: () => import( /* webpackChunkName: "layout", webpackPrefetch: true */ './Header.vue'),
        FooterView: () => import( /* webpackChunkName: "layout", webpackPrefetch: true */ './Footer.vue')
    },
    data() {
        return {
            loading: false,
            footer: true,
            header: true,
            title: ''
        }
    },
    watch: {
        $route(to, from) {
            this.$nextTick(this.loadingState);

            this.header = to.meta.header;
            this.footer = to.meta.footer;
            this.title = to.meta.title;

            document.title = 'Tiramart | ' + to.meta.title;
        }
    },
    methods: {
        loadingState() {
            this.loading = true;
            this.$Progress.start();
            setTimeout(() => {
                this.loading = false;
                this.$Progress.finish();
            }, 500);
        }
    }
}
</script>
