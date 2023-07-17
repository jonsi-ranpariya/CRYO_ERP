<template>
    <b-overlay
        :show="showOverLoading"
        rounded="sm"
    >
        <div>
            <b-card-code>
                <vue-good-table
                    :columns="columns"
                    :rows="rows"
                    :rtl="direction"
                    :search-options="{
                        enabled: true,
                        externalQuery: searchTerm
                    }"
                    :select-options="{
                        enabled: false,
                        selectOnCheckboxOnly: true, // only select when checkbox is clicked instead of the row
                        selectionInfoClass: 'custom-class',
                        selectionText: 'rows selected',
                        clearSelectionText: 'clear',
                        disableSelectInfo: true, // disable the select info panel on top
                        selectAllByGroup: true, // when used in combination with a grouped table, add a checkbox in the header row to check/uncheck the entire group
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
                        <span
                            v-if="props.column.field === 'status'"
                            class="text-nowrap"
                        >
                            <span v-for="status in statusOptions">
                                <span class="text-nowrap" v-if="props.row.status === status.value">{{ status.label }}</span>
                            </span>
                        </span>

                        <!-- Column: Action -->
                        <span v-else-if="props.column.field === 'action'">
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
                              <b-dropdown-item :to="{ name: 'view-sales-quotation', params: { id: props.row._id} }">
                                <feather-icon
                                    icon="CheckSquareIcon"
                                    class="mr-50"
                                />
                                <span>View</span>
                              </b-dropdown-item>
                            </b-dropdown>
                          </span>
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
        </div>
    </b-overlay>
</template>
<script>
    import BCardCode from '@core/components/b-card-code/BCardCode.vue'
    import {
        BPagination, BFormGroup, BFormInput, BFormSelect, BDropdown, BDropdownItem, BButton, BRow,
        BCol, BOverlay
    } from 'bootstrap-vue'
    import {ref, onUnmounted} from '@vue/composition-api'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import {VueGoodTable} from 'vue-good-table'
    import store from '@/store'
    import salesStoreModule from '../salesStoreModule'
    import axios from '@axios'
    import { forMatIndianDate } from '@core/utils/utils'

    export default {
        components: {
            BCardCode,
            BOverlay,
            VueGoodTable,
            BButton,
            BRow,
            BCol,
            BPagination,
            BFormGroup,
            BFormInput,
            BFormSelect,
            BDropdown,
            BDropdownItem,
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
            const SE_APP_STORE_MODULE_NAME = 'sales-enquiry-module'

            if (!store.hasModule(SE_APP_STORE_MODULE_NAME)) store.registerModule(SE_APP_STORE_MODULE_NAME, salesStoreModule)

            onUnmounted(() => {
                if (store.hasModule(SE_APP_STORE_MODULE_NAME)) store.unregisterModule(SE_APP_STORE_MODULE_NAME)
            })

            const showOverLoading = ref(true)
            const searchTerm = ref('')
            const pageLength = ref(5)
            const dir = ref(false)
            const columns = ref([
                {
                    label: 'Quotation No.',
                    field: 'quotationNo',
                },
                {
                    label: 'Enq. No.',
                    field: 'enquiryNo',
                },
                {
                    label: 'Rev Date',
                    field: 'reviewDate',
                    // formatFn: val => forMatIndianDate(val),
                },
                {
                    label: 'Party Code',
                    field: 'customerCode',
                },
                {
                    label: 'Party Name',
                    field: 'customerName',
                },
                {
                    label: 'Quotation Amount',
                    field: 'quotation_total_amount',
                },
                {
                    label: 'Status',
                    field: 'status',
                },
                {
                    label: 'Created By',
                    field: 'created_by.first_name',
                },
                {
                    label: 'Action',
                    field: 'action',
                },
            ])

            const statusOptions = ref([
                {
                    label: 'Hot',
                    value: 1
                },
                {
                    label: 'Cold',
                    value: 2
                },
                {
                    label: 'Received',
                    value: 3
                },
                {
                    label: 'Regret',
                    value: 4
                },
                {
                    label: 'Lost',
                    value: 5
                },
            ])

            const rows = ref([])
            //get-pending-sales-quotations
            axios.get('/api/sales-quotation')
                .then(res => {
                    rows.value = res.data.data
                    showOverLoading.value = false
                })

            return {
                showOverLoading,
                searchTerm,
                pageLength,
                dir,
                columns,
                rows,
                statusOptions
            }
        },
    }
</script>
<style lang="scss">
    @import '~@core/scss/vue/libs/vue-good-table.scss';
</style>
<style lang="scss">
    @import '~@core/scss/vue/libs/vue-sweetalert.scss';
</style>
<style lang="scss" scoped>
    @import '~@core/scss/base/bootstrap-extended/include';
    @import '~@core/scss/base/components/variables-dark';

    .dark-layout {
        div ::v-deep .card .card-body {
            .b-overlay {
                .bg-light {
                    background-color: $theme-dark-body-bg !important;
                }
            }
        }
    }
</style>
