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
                                label="Sales"
                                label-for="salesFrom"
                            >
                                <v-select
                                    v-model="serverParams.salesFrom"
                                    placeholder="Select Sales From"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="SalesFromOptions"
                                    :reduce="val => val.value"
                                    :clearable="true"
                                    input-id="salesFrom"
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
                                    :options="SalesTypeOptions"
                                    :reduce="val => val.value"
                                    :clearable="true"
                                    input-id="salesType"
                                />
                            </b-form-group>
                        </b-col>

                        <b-col md="3">
                            <b-form-group
                                label="Enquiry Status"
                                label-for="enquiryStatus"
                            >
                                <v-select
                                    v-model="serverParams.enquiryStatus"
                                    placeholder="Select Enq Status"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="EnqStatusOptions"
                                    :clearable="true"
                                    input-id="enquiryStatus"
                                />
                            </b-form-group>
                        </b-col>

                        <b-col md="3">
                            <b-form-group
                                label="Enquiry By"
                                label-for="enquiryBy"
                            >
                                <v-select
                                    v-model="serverParams.enquiryBy"
                                    placeholder="Select Enq By"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="EnqByOptions"
                                    :reduce="val => val.value"
                                    :clearable="true"
                                    input-id="enquiryBy"
                                />
                            </b-form-group>
                        </b-col>

                        <b-col md="3">
                            <b-form-group
                                label="Users"
                                label-for="enquiryAssignTo"
                            >
                                <v-select
                                    v-model="serverParams.enquiryAssignTo"
                                    placeholder="Select Assign To"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="userOptions"
                                    :reduce="val => val.value"
                                    :clearable="true"
                                    input-id="enquiryAssignTo"
                                />
                            </b-form-group>
                        </b-col>

                        <b-col md="3">
                            <b-form-group
                                label="Industry Type"
                                label-for="industryType"
                            >
                                <v-select
                                    v-model="serverParams.industryType"
                                    placeholder="Select Industry Type"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="IndustryTypeOptions"
                                    :reduce="val => val.value"
                                    :clearable="true"
                                    input-id="industryType"
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
                                        @click="exportDataToExcel(columns, rows, 'enquiry_list.xlsx', 'enquiry_list')"
                                    >
                                        <feather-icon icon="FileTextIcon"/>
                                        Export To Excel
                                    </b-button>
                                    <b-button
                                        v-ripple.400="'rgba(113, 102, 240, 0.15)'"
                                        variant="outline-primary"
                                        @click="exportTableDataToPdf(columns, rows, 'enquiry_list.pdf')"
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
                        <span
                            v-if="props.column.field === 'customerCityLabel'"
                            class="text-nowrap"
                        >
                          <span class="text-nowrap" v-if="props.row.customerCity !== null">{{ props.row.customerCity.label }}</span>
                          <span class="text-nowrap" v-else>N/A</span>
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

            const printEnquiryStatus = (value) => {

                if (value) {
                    return value.label
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
            const IndustryTypeOptions = ref([])
            const EnqByOptions = ref([])

            const SalesFromOptions = ref([
                {
                    label: 'Domestic',
                    value: 1,
                },
                {
                    label: 'Export',
                    value: 2,
                },
            ])
            const SalesTypeOptions = ref([
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

            const EnqStatusOptions = ref([
                {
                    label: 'Pending',
                    value: 1,
                },
                {
                    label: 'Completed',
                    value: 2,
                },
                {
                    label: 'Regret',
                    value: 3,
                },
                {
                    label: 'Cancelled',
                    value: 4,
                },
            ])

            const serverParams = ref({
                partyId: null,
                customerCountry: null,
                customerState: null,
                customerCity: null,
                branch: null,
                salesFrom: null,
                salesType: null,
                enquiryStatus: null,
                enquiryBy: null,
                enquiryAssignTo: null,
                industryType: null,
            })

            const showOverlayLoading = ref(false)
            const pageLength = ref(10)
            const dir = ref(false)

            const columns = ref([
                {
                    label: 'Enq. No.',
                    field: 'enquiryNo',
                },
                {
                    label: 'Enquiry Date',
                    field: 'enquiryDate',
                    formatFn: val => forMatIndianDate(val),
                },
                {
                    label: 'Reference',
                    field: 'reference',
                },
                {
                    label: 'Reference Date',
                    field: 'referenceDate',
                    formatFn: val => forMatIndianDate(val),
                },
                {
                    label: 'Customer Name',
                    field: 'customerName',
                },
                {
                    label: 'District',
                    field: 'city_details.city',
                },
                {
                    label: 'Status',
                    field: 'enquiryStatus',
                    formatFn: val => printEnquiryStatus(val),
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

            axios.get('/api/get-industry-type-options')
                .then(res => {
                    IndustryTypeOptions.value = res.data.data
                })

            axios.get('/api/get-enquiry-ref-options')
                .then(res => {
                    EnqByOptions.value = res.data.data
                })

            axios.get('/api/get-users-options')
                .then(res => {
                    userOptions.value = res.data.data
                })

            const refetchData = async () => {
                showOverlayLoading.value = true
                await axios.post('/api/get-sales-enquiry-list-with-filter', {
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
                SalesFromOptions,
                SalesTypeOptions,
                EnqStatusOptions,
                userOptions,
                countryOptions,
                stateOptions,
                cityOptions,
                IndustryTypeOptions,
                EnqByOptions,
                getCityDetails,
                exportDataToExcel,
                printEnquiryStatus,
                exportTableDataToPdf,
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
