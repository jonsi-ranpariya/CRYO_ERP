<template>
  <b-row>
    <b-col cols="12">
      <PartyMasterList />
    </b-col>
  </b-row>
</template>

<script>
import { BRow, BCol } from 'bootstrap-vue'
import PartyMasterList from './PartyMasterList.vue'

export default {
  components: {
    BRow,
    BCol,
    PartyMasterList,
  },
}
</script>

<style lang="scss" >
@import '~@core/scss/vue/libs/vue-good-table.scss';
</style>
