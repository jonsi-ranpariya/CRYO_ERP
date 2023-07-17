<template>
    <b-row>
        <b-col cols="12">
            <ItemMasterList />
        </b-col>
    </b-row>
</template>

<script>
    import { BRow, BCol } from 'bootstrap-vue'
    import ItemMasterList from './ItemMasterList'

    export default {
        components: {
            BRow,
            BCol,
            ItemMasterList,
        },
    }
</script>

<style lang="scss" >
    @import '~@core/scss/vue/libs/vue-good-table.scss';
</style>
