<template>
  <b-row>
    <b-col cols="12">
      <ChallanInvoicesList />
    </b-col>
  </b-row>
</template>

<script>
import { BRow, BCol } from 'bootstrap-vue'
import ChallanInvoicesList from './ChallanInvoicesList.vue'

export default {
  components: {
    BRow,
    BCol,
    ChallanInvoicesList,
  },
}
</script>

<style lang="scss" >
@import '~@core/scss/vue/libs/vue-good-table.scss';
</style>
