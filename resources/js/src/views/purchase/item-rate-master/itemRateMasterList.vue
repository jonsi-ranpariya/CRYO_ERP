<template>
    <b-card-code>
        <b-row class="mb-1">
            <b-col cols="12" md="6" class="d-flex justify-content-start align-items-center">
                <b-button
                    variant="primary"
                    :to="{ name: 'add-item-rate-master'}"
                > Add Item Rate Master
                </b-button>
            </b-col>

            <!--                    :to="{ name: 'add-job-card'}"-->
            <!-- ---------------search ---------------->
            <b-col cols="12" md="6">
                <div class="custom-search d-flex justify-content-end">
                    <b-form-group>
                        <div class="d-flex align-items-center">
                            <label class="mr-1 mt-1">Search</label>
                            <b-form-input
                                v-model="searchTerm"
                                placeholder="Search"
                                type="text"
                                class=" mt-1 d-inline-block"
                            />
                        </div>
                    </b-form-group>
                </div>
            </b-col>
        </b-row>
        <!-- ---------------- table --------------------------------->
        <vue-good-table
            :columns="columns"
            :rows="rows"
            :rtl="direction"
            :search-options="{
                enabled: true,
                externalQuery: searchTerm }"
            :select-options="{
                enabled: false,
                        selectOnCheckboxOnly: true, // only select when checkbox is clicked instead of the row
                        selectionInfoClass: 'custom-class',
                        selectionText: 'rows selected',
                        clearSelectionText: 'clear',
                        disableSelectInfo: true, // disable the select info panel on top
                        selectAllByGroup: true,
      }"
            :pagination-options="{
                enabled: true,
                perPage:pageLength
            }"
        >
            <template
                slot="table-row"
                slot-scope="props"
            >

                <!-- Column: Action -->
                <span v-if="props.column.field === 'action'">
                      <span>
                        <b-dropdown
                            variant="link"
                            toggle-class="text-decoration-none"
                            no-caret
                        >
                          <template v-slot:button-content>
                            <feather-icon
                                icon="MoreVerticalIcon"
                                size="16"
                                class="text-body align-middle mr-25"
                            />
                          </template>
                          <b-dropdown-item >
                            <feather-icon
                                icon="Edit2Icon"
                                class="mr-50"
                            />
                            <span>Edit</span>
                          </b-dropdown-item>
                          <b-dropdown-item>
                            <feather-icon
                                icon="TrashIcon"
                                class="mr-50"
                            />
                            <span>Delete</span>
                          </b-dropdown-item>
                        </b-dropdown>
                      </span>
                    </span>

                <!-- Column: Common -->
                <span v-else>
                  {{ props.formattedRow[props.column.field] }}
                </span>
            </template>

            <!-- pagination -->
            <template
                slot="pagination-bottom"
                slot-scope="props"
            >
                <div class="d-flex justify-content-between flex-wrap">
                    <div class="d-flex align-items-center mb-0 mt-1">
                 <span class="text-nowrap ">
                     Showing 1 to
                 </span>
                        <b-form-select
                            v-model="pageLength"
                            :options="['3','5','10']"
                            class="mx-1"
                            @input="(value)=>props.perPageChanged({currentPerPage:value})"
                        />
                        <span class="text-nowrap"> of {{ props.total }} entries </span>
                    </div>
                    <div>
                        <b-pagination
                            :value="1"
                            :total-rows="props.total"
                            :per-page="pageLength"
                            first-number
                            last-number
                            align="right"
                            prev-class="prev-item"
                            next-class="next-item"
                            class="mt-1 mb-0"
                            @input="(value)=>props.pageChanged({currentPage:value})"
                        >
                            <template #prev-text>
                                <feather-icon
                                    icon="ChevronLeftIcon"
                                    size="18"
                                />
                            </template>
                            <template #next-text>
                                <feather-icon
                                    icon="ChevronRightIcon"
                                    size="18"
                                />
                            </template>
                        </b-pagination>
                    </div>
                </div>
            </template>
        </vue-good-table>
    </b-card-code>
</template>
<script>
    import BCardCode from '../../../@core/components/b-card-code/BCardCode'
    import {  BRow,
        BCol,
        BButton,
        BFormGroup,
        BFormInput,
        BPagination,
        BFormSelect,
        BDropdown,
        BDropdownItem,} from 'bootstrap-vue'
    import  {VueGoodTable} from 'vue-good-table'
    import {ref} from '@vue/composition-api'
    import store from '@/store/index'

    export default {
        components:{
            VueGoodTable,
            BRow,
            BCol,
            BButton,
            BFormGroup,
            BFormInput,
            BPagination,
            BFormSelect,
            BDropdown,
            BDropdownItem,
            BCardCode,
        },
        computed: {
            direction() {
                if (store.state.appConfig.isRTL) {
                    this.dir = true
                    return this.dir
                }
                this.dir = false
                return this.dir
            },
        },
        setup() {
            //search
            const searchTerm = ref('')
            //pagination
            const pageLength = ref('')
            const dir = ref(false)
            const rows = ref([])
            const columns = ref([
                {
                    label: 'Item Code',
                    field: 'Itemcode',
                },
                {
                    label: 'Item Description',
                    field: 'itemDescription',
                },
                {
                    label: 'Item Cost',
                    field: 'itemCost',
                },
                {
                    label: 'Sales Rate',
                    field: 'itemSalesRate',
                },
                {
                    label: 'Purchase Rate',
                    field: 'itemPurchaseRate',
                },
                {
                    label: 'MRP',
                    field: 'itemMrp',
                },
                {
                    label: 'Action',
                    field: 'action',
                },
            ])
            return {
                searchTerm,
                pageLength,
                dir,
                columns,
                rows,
            }
        },
    }
</script>
<style lang="scss">
    @import '~@core/scss/vue/libs/vue-good-table.scss';
</style>
