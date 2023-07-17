<template>
  <b-row>
    <b-col cols="12">
      <PartyGroupMasterList />
    </b-col>
  </b-row>
</template>

<script>
import { BRow, BCol } from 'bootstrap-vue'
import PartyGroupMasterList from './PartyGroupMasterList.vue'

export default {
  components: {
    BRow,
    BCol,
    PartyGroupMasterList,
  },
}
</script>

<style lang="scss" >
@import '~@core/scss/vue/libs/vue-good-table.scss';
</style>
