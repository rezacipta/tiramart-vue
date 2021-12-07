<template>
    <div class="detailsHdr bottomBorderRadius width-control">
        <div class="hdrSide">
            <a class="headerBackBtn headerIcon headerIconLeft" @click="$router.go(-1)"></a>
        </div>
        <div class="detailsHdrTitle">
            <span class="detailsHdrTitleTxt" v-text="this.title"></span>
        </div>
        <div class="hdrSide rightDiv"></div>
    </div>
</template>

<script>
export default {
    name: 'Header',
    props: ['title']
}
</script>
