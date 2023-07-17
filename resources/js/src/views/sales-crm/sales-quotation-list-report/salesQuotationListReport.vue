<template>
    <b-overlay
        :show="showOverlayLoading"
        rounded="sm"
    >
        <div>
            <b-card-code>

                <div class="custom-search">

                    <!-- advance search input -->
                    <b-row>
                        <b-col md="3">
                            <b-form-group
                                label="Party"
                                label-for="partyId"
                            >
                                <v-select
                                    v-model="serverParams.partyId"
                                    placeholder="Select Party"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="PartyListOption"
                                    :reduce="val => val.value"
                                    :clearable="true"
                                    input-id="partyId"
                                />

                            </b-form-group>
                        </b-col>
                        <b-col md="3">
                            <b-form-group
                                label="District"
                                label-for="customerDistrict"
                            >
                                <v-select
                                    v-model="serverParams.customerCity"
                                    placeholder="Select District"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="cityOptions"
                                    :reduce="val => val.value"
                                    :clearable="true"
                                    input-id="customerDistrict"
                                    @input="getCityDetails($event)"
                                />
                            </b-form-group>
                        </b-col>
                        <b-col md="3">
                            <b-form-group
                                label="State"
                                label-for="customerState"
                            >
                                <v-select
                                    v-model="serverParams.customerState"
                                    placeholder="Select State"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="stateOptions"
                                    :reduce="val => val.value"
                                    :clearable="true"
                                    input-id="customerState"
                                />
                            </b-form-group>
                        </b-col>
                        <b-col md="3">
                            <b-form-group
                                label="Country"
                                label-for="customerCountry"
                            >
                                <v-select
                                    v-model="serverParams.customerCountry"
                                    placeholder="Select Country"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="countryOptions"
                                    :reduce="val => val.value"
                                    :clearable="true"
                                    input-id="customerCountry"
                                />
                            </b-form-group>
                        </b-col>
                        <b-col md="3">
                            <b-form-group
                                label="Branch"
                                label-for="branch"
                            >
                                <v-select
                                    v-model="serverParams.branch"
                                    placeholder="Select Branch"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="BranchOptions"
                                    :reduce="val => val.value"
                                    :clearable="true"
                                    input-id="branch"
                                />
                            </b-form-group>
                        </b-col>

                        <b-col md="3">
                            <b-form-group
                                label="Stage"
                                label-for="stage"
                            >
                                <v-select
                                    placeholder="Select Stage"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="stageOptions"
                                    :clearable="true"
                                    input-id="stage"
                                    :reduce="val => val.value"
                                    v-model="serverParams.stage"
                                />
                            </b-form-group>
                        </b-col>
                        <b-col md="3">
                            <b-form-group
                                label="Sales"
                                label-for="sales"
                            >
                                <v-select
                                    v-model="serverParams.sales"
                                    placeholder="Select Sales From"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="salesOptions"
                                    :reduce="val => val.value"
                                    :clearable="true"
                                    input-id="sales"
                                />
                            </b-form-group>
                        </b-col>

                        <b-col md="3">
                            <b-form-group
                                label="Sales Type"
                                label-for="salesType"
                            >
                                <v-select
                                    v-model="serverParams.salesType"
                                    placeholder="Select Sales Type"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="salesTypeOptions"
                                    :reduce="val => val.value"
                                    :clearable="true"
                                    input-id="salesType"
                                />
                            </b-form-group>
                        </b-col>

                        <b-col md="3">
                            <b-form-group
                                label="Quotation Status"
                                label-for="status"
                            >
                                <v-select
                                    v-model="serverParams.status"
                                    placeholder="Select Quotation Status"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="quotationStatusOptions"
                                    :reduce="val => val.value"
                                    :clearable="true"
                                    input-id="status"
                                />
                            </b-form-group>
                        </b-col>

                        <b-col md="3">
                            <b-form-group
                                label="Users"
                                label-for="addedFrom"
                            >
                                <v-select
                                    v-model="serverParams.addedFrom"
                                    placeholder="Select Assign To"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="userOptions"
                                    :reduce="val => val.value"
                                    :clearable="true"
                                    input-id="addedFrom"
                                />
                            </b-form-group>
                        </b-col>
                        <b-col md="3">
                            <b-form-group
                                label="Qtn Type"
                                label-for="qtnType"
                            >
                                <v-select
                                    placeholder="Select Qtn Type"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="qtnOptions"
                                    :reduce="val => val.value"
                                    :clearable="true"
                                    input-id="qtnType"
                                    v-model="serverParams.qtnType"
                                />
                            </b-form-group>
                        </b-col>
                        <b-col md="3">
                            <b-form-group
                                label="Qtn Stage"
                                label-for="qtnStage"
                            >
                                <v-select
                                    placeholder="Select Qtn Stage"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="qtnStageOptions"
                                    :reduce="val => val.value"
                                    :clearable="true"
                                    input-id="qtnStage"
                                    v-model="serverParams.qtnStage"
                                />
                            </b-form-group>
                        </b-col>

                        <b-col md="12">
                            <b-button
                                type="button"
                                variant="primary"
                                @click="refetchData()"
                            >
                                <feather-icon icon="FilterIcon"/>
                                Apply Filter
                            </b-button>
                        </b-col>
                    </b-row>
                </div>

                <b-row>
                    <b-col cols="12">
                        <hr>
                    </b-col>
                </b-row>

                <b-row class="mb-2">
                    <b-col
                        cols="12"
                        md="12"
                        class="d-flex justify-content-end"
                    >

                        <div class="custom-search">
                            <b-form-group>
                                <div class="d-flex align-items-center">
                                    <label class="mr-1">Search</label>
                                    <b-form-input
                                        v-model="searchTerm"
                                        placeholder="Search"
                                        type="text"
                                        class="d-inline-block"
                                    />
                                </div>
                            </b-form-group>

                        </div>

                        <div class="ml-1">
                            <b-button-toolbar justify>
                                <b-button-group>
                                    <b-button
                                        v-ripple.400="'rgba(113, 102, 240, 0.15)'"
                                        variant="outline-primary"
                                        @click="exportDataToExcel(columns, rows, 'quotation_list.xlsx', 'enquiry_list')"
                                    >
                                        <feather-icon icon="FileTextIcon"/>
                                        Export To Excel
                                    </b-button>
                                    <b-button
                                        v-ripple.400="'rgba(113, 102, 240, 0.15)'"
                                        variant="outline-primary"
                                        @click="exportTableDataToPdf(columns, rows, 'quotation_list.pdf')"
                                    >
                                        <feather-icon icon="FileIcon"/>
                                        Export To PDF
                                    </b-button>
                                </b-button-group>
                            </b-button-toolbar>
                        </div>


                    </b-col>
                </b-row>

                <!-- table -->
                <vue-good-table
                    :columns="columns"
                    :rows="rows"
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
                        <!-- Column: Common -->
                        <span>
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
                                    :options="['10','20','30','50']"
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
        BPagination,
        BFormGroup,
        BFormInput,
        BFormSelect,
        BDropdown,
        BDropdownItem,
        BButtonToolbar,
        BButtonGroup,
        BButton,
        BRow,
        BCol,
        BOverlay
    } from 'bootstrap-vue'
    import Ripple from 'vue-ripple-directive'
    import vSelect from 'vue-select'
    import {ref, onUnmounted} from '@vue/composition-api'
    //import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import {VueGoodTable} from 'vue-good-table'
    import store from '@/store'
    import salesStoreModule from '../salesStoreModule'
    import axios from '@axios'
    import {forMatIndianDate, exportDataToExcel, exportTableDataToPdf} from '@core/utils/utils'

    export default {
        components: {
            BCardCode,
            BOverlay,
            VueGoodTable,
            BButtonToolbar,
            BButtonGroup,
            BButton,
            BRow,
            BCol,
            BPagination,
            BFormGroup,
            BFormInput,
            BFormSelect,
            BDropdown,
            BDropdownItem,
            vSelect,
        },
        directives: {
            Ripple,
        },
        setup() {

            const SE_APP_STORE_MODULE_NAME = 'sales-enquiry-module'

            // Register module
            if (!store.hasModule(SE_APP_STORE_MODULE_NAME)) store.registerModule(SE_APP_STORE_MODULE_NAME, salesStoreModule)

            // UnRegister on leave
            onUnmounted(() => {
                if (store.hasModule(SE_APP_STORE_MODULE_NAME)) store.unregisterModule(SE_APP_STORE_MODULE_NAME)
            })

            const printStatus = (statusValue) => {

                var valObj = quotationStatusOptions.value.filter(function (elem) {
                    if (elem.value === statusValue) {
                        return elem.label
                    }
                })

                if (valObj.length > 0) {

                    return valObj[0].label

                } else {

                    return ''
                }
            }

            const printCreatedBy = (addedFrom) => {

                var valObj = userOptions.value.filter(function (elem) {
                    if (elem.value === addedFrom) {
                        return elem.label
                    }
                })

                if (valObj.length > 0) {

                    return valObj[0].label

                } else {

                    return ''
                }
            }

            const PartyListOption = ref([])
            const BranchOptions = ref([])
            const userOptions = ref([])
            const countryOptions = ref([])
            const stateOptions = ref([])
            const cityOptions = ref([])

            const salesOptions = ref([
                {
                    label: 'Domestic',
                    value: 1,
                },
                {
                    label: 'Export',
                    value: 2,
                },
            ])
            const salesTypeOptions = ref([
                {
                    label: 'Product Order',
                    value: 1,
                },
                {
                    label: 'Machine Order',
                    value: 2,
                },
                {
                    label: 'Spare Order',
                    value: 3,
                },
                {
                    label: 'Repairing & Service',
                    value: 4,
                },
            ])

            const quotationStatusOptions = ref([
                {label: 'Hot', value: 1},
                {label: 'Cold', value: 2},
                {label: 'Received', value: 3},
                {label: 'Regret', value: 4},
                {label: 'Lost', value: 5},
            ])

            const qtnOptions = ref([
                {label: 'Product Quotation', value: 1},
                {label: 'Spares Quotation', value: 2},
                {label: 'Service Quotation', value: 3},
                {label: 'Budgetory Quotation', value: 4},
            ])

            const qtnStageOptions = ref([
                {label: 'Active', value: 1},
                {label: 'Achieved', value: 2},
                {label: 'Regret', value: 3},
                {label: 'Closed', value: 4},
                {label: 'Followup', value: 5},
            ])

            const stageOptions = ref([
                {label: 'Prepared', value: 1},
                {label: 'Approved', value: 2},
                {label: 'Regret', value: 3}
            ])

            const serverParams = ref({
                partyId: null,
                customerCountry: null,
                customerState: null,
                customerCity: null,
                branch: null,
                sales: null,
                salesType: null,
                status: null,
                addedFrom: null,
                qtnType: null,
                qtnStage: null,
                stage: null,
            })

            const showOverlayLoading = ref(false)
            const pageLength = ref(10)
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
                    label: 'Rev',
                    field: 'quotationRevNo',
                },
                {
                    label: 'Date',
                    field: 'quotationDate',
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
                    formatFn: val => Number.parseFloat(val).toFixed(2),
                },
                {
                    label: 'Status',
                    field: 'status',
                    formatFn: val => printStatus(val),
                },
                {
                    label: 'Created By',
                    field: 'addedFrom',
                    formatFn: val => printCreatedBy(val),
                },
            ])

            const rows = ref([])

            const searchTerm = ref('')

            axios.get('/api/party/get-master-options')
                .then(res => {
                    PartyListOption.value = res.data.data
                })

            axios.get('/api/get-branch-master-options')
                .then(res => {
                    BranchOptions.value = res.data.data
                })

            axios.get('/api/get-country-options')
                .then(res => {
                    countryOptions.value = res.data.data
                })

            axios.get('/api/get-state-options')
                .then(res => {
                    stateOptions.value = res.data.data
                })

            axios.get('/api/get-city-options')
                .then(res => {
                    cityOptions.value = res.data.data
                })
            const getCityDetails = async (id) => {
                await axios.get(`/api/city-master/${id}`).then((res) => {
                    serverParams.value.customerState = res.data.data?.state ?? null
                    serverParams.value.customerCountry = res.data.data?.country ?? null
                });
            }

            axios.get('/api/get-users-options')
                .then(res => {
                    userOptions.value = res.data.data
                })

            const refetchData = async () => {
                showOverlayLoading.value = true
                await axios.post('/api/get-sales-quotation-list-with-filter', {
                    ...serverParams.value,
                })
                    .then(res => {
                        rows.value = res.data.data
                        showOverlayLoading.value = false
                    })
            }

            refetchData()

            return {
                showOverlayLoading,
                pageLength,
                dir,
                refetchData,
                columns,
                rows,
                searchTerm,
                serverParams,
                PartyListOption,
                BranchOptions,
                salesOptions,
                salesTypeOptions,
                qtnOptions,
                quotationStatusOptions,
                qtnStageOptions,
                stageOptions,
                userOptions,
                countryOptions,
                stateOptions,
                cityOptions,
                exportDataToExcel,
                printStatus,
                exportTableDataToPdf,
                getCityDetails
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
