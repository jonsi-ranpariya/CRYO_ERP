<template>
    <div>
        <b-card-code>
            <validation-observer ref="simpleRules">
                <b-form>
                    <b-row>
                        <b-col md="12">
                            <b-form-group
                                label="Company"
                                label-for="company"
                            >
                                <v-select
                                    placeholder="Select company"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="companyOptions"
                                    :reduce="val => val.value"
                                    :clearable="false"
                                    input-id="company"
                                    v-model="salesOrderFormData.company"
                                />
                            </b-form-group>
                        </b-col>
                        <b-col md="6">
                            <b-form-group
                                label="Quotation Reference"
                                label-for="itemQtnRefNo"
                            >
                                <b-input-group>
                                    <b-form-input
                                        v-model="salesOrderFormData.qtnRefNo"
                                        readonly
                                    />
                                    <b-input-group-append>
                                        <b-button
                                            variant="primary"
                                            type="button"
                                            @click="openQuotationModal"
                                        >
                                            ...
                                        </b-button>
                                    </b-input-group-append>
                                </b-input-group>
                            </b-form-group>
                        </b-col>
                        <b-col md="6">
                            <b-form-group
                                label="Quotation SrNo."
                                label-for="itemQtnSrNo"
                            >
                                <b-form-input
                                    id="itemQtnSrNo"
                                    v-model="salesOrderFormData.qtnSrNo"
                                    disabled
                                />
                            </b-form-group>
                        </b-col>
                        <b-col md="2">
                            <validation-provider
                                #default="{ errors }"
                                name="Sales Order No"
                                rules="required"
                            >
                                <b-form-group
                                    label="Sales Order No"
                                    label-for="salesOrderNo"
                                >
                                    <b-form-input
                                        id="salesOrderNo"
                                        v-model="salesOrderFormData.salesOrderNo"
                                        :state="errors.length > 0 ? false:null"
                                    />
                                    <small class="text-danger">{{ errors[0] }}</small>
                                </b-form-group>
                            </validation-provider>
                        </b-col>
                        <b-col md="4">
                            <validation-provider
                                #default="{ errors }"
                                name="Sell To Party"
                                rules="required"
                            >
                                <b-form-group
                                    label="Sell To Party"
                                    label-for="customerId"
                                    :state="errors.length > 0 ? false:null"
                                >
                                    <v-select
                                        v-model="salesOrderFormData.sellToPartyCustomerID"
                                        taggable
                                        push-tags
                                        placeholder="Select Party"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="PartyListOption"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        v-on:input="getPartyCode(salesOrderFormData.sellToPartyCustomerID)"
                                        input-id="sellToPartyCustomerID"
                                        :state="errors.length > 0 ? false:null"
                                    />
                                    <small class="text-danger">{{ errors[0] }}</small>
                                </b-form-group>
                            </validation-provider>
                        </b-col>
                        <b-col md="2">
                            <b-form-group
                                label="Customer Code"
                                label-for="sellToPartyCustomerCode"
                            >
                                <b-form-input
                                    id="sellToPartyCustomerCode"
                                    v-model="salesOrderFormData.sellToPartyCustomerCode"
                                    readonly
                                />

                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                label="Customer Name"
                                label-for="sellToPartyCustomerName"
                            >
                                <b-form-input
                                    id="sellToPartyCustomerName"
                                    v-model="salesOrderFormData.sellToPartyCustomerName"
                                    readonly
                                />
                            </b-form-group>
                        </b-col>
                        <b-col md="3">
                            <b-form-group
                                label="S.O Date"
                                label-for="salesOrderDate"
                            >
                                <b-input-group>
                                    <cleave
                                        id="salesOrderDate"
                                        v-model="salesOrderFormData.salesOrderDate"
                                        class="form-control"
                                        :raw="false"
                                        :options="dateFormat"
                                        placeholder="DD/MM/YYYY"
                                        show-decade-nav
                                    />
                                    <b-input-group-append>
                                        <b-form-datepicker
                                            v-model="formatDates.soDate"
                                            button-only
                                            @input="getSoFormatDate($event)"
                                            show-decade-nav
                                            size="sm"
                                            nav-button-variant="primary"
                                        />
                                    </b-input-group-append>
                                </b-input-group>
                            </b-form-group>
                        </b-col>
                        <b-col md="3">
                            <b-form-group
                                label="Committed Date"
                                label-for="salesOrderCommittedDate"
                            >
                                <b-input-group>
                                    <cleave
                                        id="salesOrderCommittedDate"
                                        v-model="salesOrderFormData.salesOrderCommittedDate"
                                        class="form-control"
                                        :raw="false"
                                        :options="dateFormat"
                                        placeholder="DD/MM/YYYY"
                                        show-decade-nav
                                    />
                                    <b-input-group-append>
                                        <b-form-datepicker
                                            v-model="formatDates.soCommittedDate"
                                            button-only
                                            @input="getSoCommittedDate($event)"
                                            show-decade-nav
                                            size="sm"
                                            nav-button-variant="primary"
                                        />
                                    </b-input-group-append>
                                </b-input-group>
                            </b-form-group>
                        </b-col>
                        <b-col md="3">
                            <b-form-group
                                label="Review Date"
                                label-for="salesOrderReviewDate"
                            >
                                <b-input-group>
                                    <cleave
                                        id="salesOrderReviewDate"
                                        v-model="salesOrderFormData.salesOrderReviewDate"
                                        class="form-control"
                                        :raw="false"
                                        :options="dateFormat"
                                        placeholder="DD/MM/YYYY"
                                        show-decade-nav
                                    />
                                    <b-input-group-append>
                                        <b-form-datepicker
                                            v-model="formatDates.soReviewDate"
                                            button-only
                                            @input="getSoReviewDate($event)"
                                            show-decade-nav
                                            size="sm"
                                            nav-button-variant="primary"
                                        />
                                    </b-input-group-append>
                                </b-input-group>
                            </b-form-group>
                        </b-col>
                        <b-col md="3">
                            <b-form-group
                                label="Branch"
                                label-for="salesOrderBranch"
                            >
                                <v-select
                                    v-model="salesOrderFormData.salesOrderBranch"
                                    taggable
                                    push-tags
                                    placeholder="Select Branch"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="BranchOptions"
                                    :reduce="val => val.value"
                                    :clearable="false"
                                    input-id="salesOrderBranch"
                                />
                            </b-form-group>
                        </b-col>
                        <b-col md="3">
                            <validation-provider
                                #default="{ errors }"
                                name="Customer P.O NO."
                                rules="required"
                            >
                                <b-form-group
                                    label="Customer P.O NO."
                                    label-for="customerPoNo"
                                >
                                    <b-form-input
                                        id="customerPoNo"
                                        v-model="salesOrderFormData.customerPoNo"
                                        placeholder="Customer P.O NO"
                                        :state="errors.length > 0 ? false:null"
                                    />
                                    <small class="text-danger">{{ errors[0] }}</small>
                                </b-form-group>
                            </validation-provider>
                        </b-col>
                        <b-col md="3">
                            <b-form-group
                                label="P.O Date"
                                label-for="salesOrderPoDate"
                            >
                                <!--<b-form-datepicker
                                    id="salesOrderPoDate"
                                    :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }"
                                    v-model="salesOrderFormData.salesOrderPoDate"
                                    class="mb-1"
                                />-->
                                <b-input-group>
                                    <cleave
                                        id="salesOrderPoDate"
                                        v-model="salesOrderFormData.salesOrderPoDate"
                                        class="form-control"
                                        :raw="false"
                                        :options="dateFormat"
                                        placeholder="DD/MM/YYYY"
                                        show-decade-nav
                                    />
                                    <b-input-group-append>
                                        <b-form-datepicker
                                            v-model="formatDates.soPoDate"
                                            button-only
                                            @input="getSoPoDate($event)"
                                            show-decade-nav
                                            size="sm"
                                            nav-button-variant="primary"
                                        />
                                    </b-input-group-append>
                                </b-input-group>
                            </b-form-group>
                        </b-col>
                        <b-col md="3">
                            <b-form-group
                                label="Supply Type"
                                label-for="salesOrderSupplyType"
                            >
                                <v-select
                                    v-model="salesOrderFormData.salesOrderSupplyType"
                                    taggable
                                    push-tags
                                    placeholder="Select Supply Type"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="SupplyTypeOption"
                                    :reduce="val => val.value"
                                    :clearable="false"
                                    input-id="salesOrderSupplyType"
                                />
                            </b-form-group>
                        </b-col>
                        <b-col md="3">
                            <b-form-group
                                label="Branch Qtn No."
                                label-for="branchQtnNo"
                            >
                                <b-form-input
                                    type="text"
                                    v-model="salesOrderFormData.branchQtnNo"
                                />
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                label="Currency"
                                label-for="salesOrderCurrency"
                            >
                                <v-select
                                    placeholder="Select Currency"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="currencyOptions"
                                    :reduce="val => val.value"
                                    :clearable="false"
                                    input-id="salesOrderCurrency"
                                    v-model="salesOrderFormData.salesOrderCurrency"
                                />
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                label="Conversion Rate"
                                label-for="salesOrderConvRate"
                            >
                                <b-form-input
                                    id="salesOrderConvRate"
                                    v-model="salesOrderFormData.salesOrderConvRate"
                                />
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                label="Sales"
                                label-for="salesOrderSalesType"
                            >
                                <v-select
                                    placeholder="Select Sales"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="SalesTypeOptions"
                                    :reduce="val => val.value"
                                    :clearable="false"
                                    input-id="salesOrderSalesType"
                                    v-model="salesOrderFormData.salesOrderSalesType"
                                />
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                label="Status"
                                label-for="salesOrderStatus"
                            >
                                <v-select
                                    placeholder="Select Status"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="StatusOptions"
                                    :reduce="val => val.value"
                                    :clearable="false"
                                    input-id="salesOrderStatus"
                                    v-model="salesOrderFormData.salesOrderStatus"
                                />
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                label="Order Type"
                                label-for="salesOrderType"
                            >
                                <v-select
                                    placeholder="Select Order Type"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="OrderTypeOptions"
                                    :reduce="val => val.value"
                                    :clearable="false"
                                    input-id="salesOrderType"
                                    v-model="salesOrderFormData.salesOrderType"
                                />
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                label="Project"
                                label-for="salesOrderProject"
                            >
                                <b-form-input
                                    id="salesOrderProject"
                                    v-model="salesOrderFormData.salesOrderProject"
                                />
                            </b-form-group>
                        </b-col>
                        <b-col md="3">
                            <b-form-group
                                label="Select Kind Attn"
                                label-for="kindAttnId"
                            >
                                <v-select
                                    v-model="salesOrderFormData.kindAttnId"
                                    placeholder="Select Kind Attn"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="KindAttnOptions"
                                    :reduce="val => val.value"
                                    :clearable="false"
                                    v-on:input="getContactDetail(salesOrderFormData.kindAttnId)"
                                    input-id="kindAttnId"
                                />
                            </b-form-group>
                        </b-col>
                        <b-col md="3">
                            <b-form-group
                                label="Kind Attn Name"
                                label-for="kindAttnName"
                            >
                                <b-form-input
                                    id="kindAttnName"
                                    v-model="salesOrderFormData.kindAttnName"
                                />
                            </b-form-group>
                        </b-col>
                        <b-col md="3">
                            <b-form-group
                                label="Mobile NO"
                                label-for="kindAttnMobile"
                            >
                                <b-form-input
                                    id="kindAttnMobile"
                                    v-model="salesOrderFormData.kindAttnMobile"
                                />
                            </b-form-group>
                        </b-col>
                        <b-col md="3">
                            <b-form-group
                                label="Email Id"
                                label-for="kindAttnEmail"
                            >
                                <b-form-input
                                    id="kindAttnEmail"
                                    v-model="salesOrderFormData.kindAttnEmail"
                                />
                            </b-form-group>
                        </b-col>
                        <b-col md="12">
                            <b-form-group
                                label=" "
                                label-for="selectRound"
                            >
                                <div class="demo-inline-spacing">
                                    <b-form-radio
                                        name="selectRound"
                                        value="0"
                                        v-model="salesOrderFormData.roundingType"
                                    >
                                        None
                                    </b-form-radio>
                                    <b-form-radio
                                        name="selectRound"
                                        value="1"
                                        v-model="salesOrderFormData.roundingType"
                                    >
                                        Rounding
                                    </b-form-radio>
                                    <b-form-radio
                                        name="selectRound"
                                        value="2"
                                        v-model="salesOrderFormData.roundingType"
                                    >
                                        Rounding All
                                    </b-form-radio>
                                </div>
                            </b-form-group>
                        </b-col>
                    </b-row>
                    <b-row>
                        <!-- submit and reset -->
                        <b-col md="12">
                            <hr>
                            <b-button
                                v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                                type="submit"
                                variant="primary"
                                class="mr-1 float-right"
                                @click.prevent="validationForm"
                            >
                                Submit
                            </b-button>

                        </b-col>
                    </b-row>
                </b-form>
            </validation-observer>
        </b-card-code>

        <!--Sales Quotation Modal-->
        <b-modal
            id="quotationList"
            ref="salesQuotationModal"
            title="Select Sales Quotation"
            ok-title="submit"
            cancel-variant="danger"
            size="xl"
            no-close-on-backdrop
            scrollable
            @cancel="resetModalData"
            @close="resetModalData"
            @ok="resetModalData"
        >
            <b-table
                :fields="modalTableFields.quotationFields"
                :items="modalTableData.quotationData"
                :no-border-collapse="false"
                responsive
                bordered
                hover
                show-empty
                :busy="modalTableBusy.quotationListIsBusy"
                class="table_scroll"
            >
                <!-- Loader -->
                <template #table-busy>
                    <div class="text-center my-2">
                        <b-spinner class="align-middle"></b-spinner>
                        <strong>Loading...</strong>
                    </div>
                </template>

                <!-- Action -->
                <template #cell(action)="data">
                    <b-button
                        variant="flat-primary"
                        size="sm"
                        @click="getQuotationItems(data.item)"
                    >
                        Select
                    </b-button>
                </template>

                <!-- Sales Filter -->
                <template #cell(sales)="data">
                    <span v-for="sales in salesOptions">
                        <span v-if="sales.value === data.item.sales">{{ sales.label }}</span>
                    </span>
                </template>
            </b-table>
            <hr>
            <h4>Item Details</h4>
            <hr>
            <b-table
                :fields="modalTableFields.itemsFields"
                :items="modalTableData.itemListData"
                :no-border-collapse="false"
                responsive
                bordered
                hover
                show-empty
                :busy="modalTableBusy.itemIsBusy"
                class="table_scroll"
            >
                <!-- Loader -->
                <template #table-busy>
                    <div class="text-center my-2">
                        <b-spinner class="align-middle"></b-spinner>
                        <strong>Loading...</strong>
                    </div>
                </template>

                <!-- Index -->
                <template #cell(srNo)="data">
                    {{ data.index + 1 }}
                </template>

                <!-- Action -->
                <template #cell(action)="data">
                    <b-form-checkbox
                        class="custom-control-primary"
                        @change="selectedQuotationItemIds($event, data.item._id)"
                    />
                </template>
            </b-table>
        </b-modal>
    </div>
</template>

<script>
import BCardCode from '@core/components/b-card-code'
import { ValidationObserver, ValidationProvider } from 'vee-validate'
import {
    BButton,
    BCol,
    BForm,
    BFormDatepicker,
    BFormGroup,
    BFormInput,
    BFormTextarea,
    BRow,
    BInputGroup,
    BInputGroupAppend,
    BFormRadio,
    BTable,
    BFormCheckbox,
    BSpinner
} from 'bootstrap-vue'
import { required } from '@validations'
import Ripple from 'vue-ripple-directive'
import vSelect from 'vue-select'
import store from '@/store'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
import { onUnmounted, ref } from '@vue/composition-api'
import salesStoreModule from '../salesStoreModule'
import axios from '@axios'
import { getUserData } from '../../../auth/utils'
import moment from 'moment'
import { getTcTodayDate, forMatIndianDate } from '@core/utils/utils'
import Cleave from 'vue-cleave-component'

export default {
    components: {
        BCardCode,
        ValidationProvider,
        ValidationObserver,
        BRow,
        BCol,
        BFormGroup,
        BFormInput,
        BFormTextarea,
        BForm,
        BButton,
        BFormDatepicker,
        vSelect,
        Cleave,
        BInputGroup,
        BInputGroupAppend,
        BFormRadio,
        BTable,
        BFormCheckbox,
        BSpinner
    },
    directives: {
        Ripple,
    },
    setup({ salesQuotationModal }) {
        const SO_APP_STORE_MODULE_NAME = 'sales-order-module'
        // Register module
        if (!store.hasModule(SO_APP_STORE_MODULE_NAME)) store.registerModule(SO_APP_STORE_MODULE_NAME, salesStoreModule)
        // UnRegister on leave
        onUnmounted(() => {
            if (store.hasModule(SO_APP_STORE_MODULE_NAME)) store.unregisterModule(SO_APP_STORE_MODULE_NAME)
        })

        const CurrentPartyDetailData = ref([])
        const CurrentUserData = ref(getUserData())

        salesQuotationModal = ref()

        const statusAllOptions = ref([
            {label: 'Hot', value: 0},
            {label: 'Cold', value: 1},
            {label: 'Received', value: 2},
            {label: 'Regret', value: 3},
            {label: 'Lost', value: 4},
        ])

        const modalTableFields = ref({
            quotationFields: [
                {
                    key: 'action',
                    label: ''
                },
                {
                    key: 'quotationNo',
                    label: 'Quotation No'
                },
                {
                    key: 'created_at',
                    label: 'Date',
                    formatter: value => moment(value)
                        .format('DD/MM/YYYY')
                },
                {
                    key: 'rev',
                    label: 'Revision'
                },
                {
                    key: 'revDate',
                    label: 'Rev Date'
                },
                {
                    key: 'enquiryNo',
                    label: 'EnquiryNo'
                },
                {
                    key: 'sales',
                    label: 'sales'
                }
            ],
            itemsFields: [
                {
                    key: 'action',
                    label: ''
                },
                {
                    key: 'srNo',
                    label: 'Sr No'
                },
                {
                    key: 'itemCode.label',
                    label: 'Item Code'
                },
                {
                    key: 'itemDescription',
                    label: 'description'
                },
                {
                    key: 'uom_details.uom',
                    label: 'uom'
                },
                {
                    key: 'requireQty',
                    label: 'Quantity'
                },
                {
                    key: 'rate',
                    label: 'rate'
                },
                {
                    key: 'amount',
                    label: 'amount'
                },
                {
                    key: 'drawingNumber',
                    label: 'Drawing No'
                },
                {
                    key: 'rev',
                    label: 'Revision'
                },
                {
                    key: 'status',
                    label: 'status',
                    formatter: val => getStatus(val)
                }
            ]
        })

        const getStatus = (id) => {
            let valObj = statusAllOptions.value.filter(function (elem) {
                if (elem.value === id) {
                    return elem.label
                }
            })
            if (valObj.length > 0) {
                return valObj[0].label
            } else {
                return ''
            }
        }

        const modalTableData = ref({
            quotationData: [],
            itemListData: []
        })

        const modalTableBusy = ref({
            quotationListIsBusy: false,
            itemIsBusy: false
        })

        const salesOptions = ref([
            {
                label: 'Domestic',
                value: 1
            },
            {
                label: 'Export',
                value: 2
            },
        ])

        const PartyDetailTabData = ref({
            partyDetailId: null,
            partyDetailCode: null,
            partyDetailName: null,
            partyDetailAddress: null,
            partyDetailCityId: null,
            partyDetailCity: null,
            partyDetailStateId: null,
            partyDetailState: null,
            partyDetailCountryID: null,
            partyDetailCountry: null,
            partyDetailFaxNo: null,
            partyDetailEmailId: null,
            partyDetailWebsite: null,
            partyDetailTinVatNO: null,
            partyDetailTinCstNO: null,
            partyDetailTinEccNO: null,
            partyDetailGstNo: null,
            partyDetailPinCode: null,
            partyDetailStdCode: null,
            partyDetailPhoneNo: null,
            partyDetailPanNo: null,

        })

        const PartyListOption = ref([])

        const BranchOptions = ref([])

        const currencyOptions = ref([])

        const KindAttnOptions = ref([])

        const dateFormat = ref({
            date: true,
            delimiter: '/',
            datePattern: ['d', 'm', 'Y'],
        })

        const StatusOptions = ref([
            {
                label: 'Pending',
                value: 'Pending'
            },
            {
                label: 'Completed',
                value: 'Completed'
            },
            {
                label: 'Regret',
                value: 'Regret'
            },
            {
                label: 'Cancelled',
                value: 'Cancelled'
            },
        ])

        const SalesTypeOptions = ref([
            {
                label: 'Domestic',
                value: 1
            },
            {
                label: 'Export',
                value: 2
            },
        ])

        const OrderTypeOptions = ref([])

        axios.get('/api/get-sales-order-type-options')
            .then(res => {
                OrderTypeOptions.value = res.data.data
            })

        const SupplyTypeOption = ref([
            {
                label: 'Intrastate',
                value: 1
            },
            {
                label: 'Interstate',
                value: 2
            },
            {
                label: 'Export',
                value: 3
            },
        ])

        const GstPercentageOption = ref([
            {
                label: 'SO Wise',
                value: 1
            },
            {
                label: 'Invoice Wise',
                value: 2
            },
            {
                label: 'Item Wise',
                value: 3
            }
        ])

        axios.get('/api/party/get-master-customer-options')
            .then(res => {
                PartyListOption.value = res.data.data
            })

        axios.get('/api/get-branch-master-options')
            .then(res => {
                BranchOptions.value = res.data.data
            })

        axios.get('/api/get-currency-options')
            .then(res => {
                currencyOptions.value = res.data.data
            })

        const companyOptions = ref([])
        axios.get('/api/administration/get-company-options')
            .then(res => {
                companyOptions.value = res.data.data
            })

        const salesOrderFormData = ref({
            id: null,
            company: null,
            salesOrderNo: null,
            customerPoNo: null,
            salesOrderPoDate: forMatIndianDate(new Date()),
            salesOrderDate: forMatIndianDate(new Date()),
            salesOrderCommittedDate: forMatIndianDate(new Date()),
            salesOrderCurrency: null,
            salesOrderConvRate: null,
            salesOrderProject: null,
            kindAttnId: null,
            kindAttnName: null,
            kindAttnMobile: null,
            kindAttnEmail: null,
            salesOrderSalesType: null,
            salesOrderStatus: 'Pending',
            salesOrderType: null,
            salesOrderBranch: null,
            salesOrderSupplyType: null,
            salesOrderGstType: null,
            salesOrderReviewDate: forMatIndianDate(new Date()),
            sellToPartyCustomerID: null,
            sellToPartyCustomerCode: null,
            sellToPartyCustomerName: null,
            shipToPartyCustomerID: null,
            shipToPartyCustomerCode: null,
            shipToPartyCustomerName: null,
            itemDetails: null,
            termConditionDetails: null,
            qtnRefNo: null,
            qtnSrNo: null,
            qtnItemIds: [],
            branchQtnNo: null,
            roundingType: '1',
            noteDetails: ref({
                noteHeader: null,
                noteFooter: null,
                noteNote: null,
                noteNote2: null,
                noteInternalNote: null,
                noteItemDescTitle: null,
            }),
            partyDetail: PartyDetailTabData.value,
            buyerDetail: ref({
                buyerDetailId: null,
                buyerDetailCode: null,
                buyerDetailName: null,
                buyerDetailAddress: null,
                buyerDetailCityId: null,
                buyerDetailCity: null,
                buyerDetailStateId: null,
                buyerDetailState: null,
                buyerDetailCountryID: null,
                buyerDetailCountry: null,
                buyerDetailFaxNo: null,
                buyerDetailEmailId: null,
                buyerDetailWebsite: null,
                buyerDetailTinVatNO: null,
                buyerDetailTinCstNO: null,
                buyerDetailTinEccNO: null,
                buyerDetailGstNo: null,
                buyerDetailPinCode: null,
                buyerDetailPhoneNo: null,
                buyerDetailPhoneStdCode: null,
                buyerDetailPanNo: null,
            }),
            consigneeDetail: ref({
                consigneeDetailId: null,
                consigneeDetailCode: null,
                consigneeDetailName: null,
                consigneeDetailAddress: null,
                consigneeDetailCityId: null,
                consigneeDetailCity: null,
                consigneeDetailStateId: null,
                consigneeDetailState: null,
                consigneeDetailCountryID: null,
                consigneeDetailCountry: null,
                consigneeDetailFaxNo: null,
                consigneeDetailEmailId: null,
                consigneeDetailWebsite: null,
                consigneeDetailTinVatNO: null,
                consigneeDetailTinCstNO: null,
                consigneeDetailTinEccNO: null,
                consigneeDetailGstNo: null,
                consigneeDetailPinCode: null,
                consigneeDetailPhoneNo: null,
                consigneeDetailPhoneStdCode: null,
                consigneeDetailPanNo: null,
            }),
            dispatchDetail: ref({
                dispatchDetailId: null,
                dispatchDetailCode: null,
                dispatchDetailName: null,
                dispatchDetailAddress: null,
                dispatchDetailCityId: null,
                dispatchDetailCity: null,
                dispatchDetailStateId: null,
                dispatchDetailState: null,
                dispatchDetailCountryID: null,
                dispatchDetailCountry: null,
                dispatchDetailFaxNo: null,
                dispatchDetailEmailId: null,
                dispatchDetailWebsite: null,
                dispatchDetailTinVatNO: null,
                dispatchDetailTinCstNO: null,
                dispatchDetailTinEccNO: null,
                dispatchDetailGstNo: null,
                dispatchDetailPinCode: null,
                dispatchDetailPhoneNo: null,
                dispatchDetailPhoneStdCode: null,
                dispatchDetailPanNo: null,
            }),
            loginDetail: ref({
                createdBy: CurrentUserData.value.first_name + ' ' + CurrentUserData.value.last_name,
                createdDateTime: moment(new Date())
                    .format('DD/MM/YYYY HH:mm'),
                lastModifiedBy: null,
                modifiedDateTime: null,
            }),
            SalesOrderStageDetail: ref({
                preparedBy: CurrentUserData.value.first_name + ' ' + CurrentUserData.value.last_name,
                preparedDateTime: moment(new Date())
                    .format('DD/MM/YYYY HH:mm'),
                approvedBy: null,
                approveDateTime: null,
                stage: 'Prepared',
            }),
        })

        const getPartyCode = async (val) => {

            await axios.get(`/api/party/edit/${val}`)
                .then(res => {
                    CurrentPartyDetailData.value = res.data.data

                    salesOrderFormData.value.sellToPartyCustomerCode = CurrentPartyDetailData.value?.partyCode ?? null
                    salesOrderFormData.value.sellToPartyCustomerName = CurrentPartyDetailData.value?.partyName ?? null
                    salesOrderFormData.value.shipToPartyCustomerID = val
                    salesOrderFormData.value.shipToPartyCustomerCode = CurrentPartyDetailData.value?.partyCode ?? null
                    salesOrderFormData.value.shipToPartyCustomerName = CurrentPartyDetailData.value?.partyName ?? null

                    PartyDetailTabData.value.partyDetailId = val
                    PartyDetailTabData.value.partyDetailCode = CurrentPartyDetailData.value?.partyCode ?? null
                    PartyDetailTabData.value.partyDetailName = CurrentPartyDetailData.value?.partyName ?? null

                    salesOrderFormData.value.buyerDetail.buyerDetailId = val
                    salesOrderFormData.value.buyerDetail.buyerDetailCode = CurrentPartyDetailData.value?.partyCode ?? null
                    salesOrderFormData.value.buyerDetail.buyerDetailName = CurrentPartyDetailData.value?.partyName ?? null

                    salesOrderFormData.value.consigneeDetail.consigneeDetailId = val
                    salesOrderFormData.value.consigneeDetail.consigneeDetailCode = CurrentPartyDetailData.value?.partyCode ?? null
                    salesOrderFormData.value.consigneeDetail.consigneeDetailName = CurrentPartyDetailData.value?.partyName ?? null

                    salesOrderFormData.value.dispatchDetail.dispatchDetailId = val
                    salesOrderFormData.value.dispatchDetail.dispatchDetailCode = CurrentPartyDetailData.value?.partyCode ?? null
                    salesOrderFormData.value.dispatchDetail.dispatchDetailName = CurrentPartyDetailData.value?.partyName ?? null

                    if (CurrentPartyDetailData.value.partyDetails) {

                        PartyDetailTabData.value.partyDetailAddress = CurrentPartyDetailData.value?.partyDetails?.partyAddress ?? null
                        salesOrderFormData.value.buyerDetail.buyerDetailAddress = CurrentPartyDetailData.value?.partyDetails?.partyAddress ?? null
                        salesOrderFormData.value.consigneeDetail.consigneeDetailAddress = CurrentPartyDetailData.value?.partyDetails?.partyAddress ?? null
                        salesOrderFormData.value.dispatchDetail.dispatchDetailAddress = CurrentPartyDetailData.value?.partyDetails?.partyAddress ?? null

                        if (CurrentPartyDetailData.value.partyDetails.partyCity) {
                            PartyDetailTabData.value.partyDetailCityId = CurrentPartyDetailData.value?.partyDetails?.partyCity?.value ?? null
                            PartyDetailTabData.value.partyDetailCity = CurrentPartyDetailData.value?.partyDetails?.partyCity?.label ?? null

                            salesOrderFormData.value.buyerDetail.buyerDetailCityId = CurrentPartyDetailData.value?.partyDetails.partyCity?.value ?? null
                            salesOrderFormData.value.buyerDetail.buyerDetailCity = CurrentPartyDetailData.value?.partyDetails.partyCity?.label ?? null

                            salesOrderFormData.value.consigneeDetail.consigneeDetailCityId = CurrentPartyDetailData.value.partyDetails.partyCity.value
                            salesOrderFormData.value.consigneeDetail.consigneeDetailCity = CurrentPartyDetailData.value.partyDetails.partyCity.label

                            salesOrderFormData.value.dispatchDetail.dispatchDetailCityId = CurrentPartyDetailData.value.partyDetails.partyCity.value
                            salesOrderFormData.value.dispatchDetail.dispatchDetailCity = CurrentPartyDetailData.value.partyDetails.partyCity.label
                        }

                        if (CurrentPartyDetailData.value.partyDetails.partyState) {
                            PartyDetailTabData.value.partyDetailStateId = CurrentPartyDetailData.value.partyDetails.partyState.value
                            PartyDetailTabData.value.partyDetailState = CurrentPartyDetailData.value.partyDetails.partyState.label

                            salesOrderFormData.value.buyerDetail.buyerDetailStateId = CurrentPartyDetailData.value.partyDetails.partyState.value
                            salesOrderFormData.value.buyerDetail.buyerDetailState = CurrentPartyDetailData.value.partyDetails.partyState.label

                            salesOrderFormData.value.consigneeDetail.consigneeDetailStateId = CurrentPartyDetailData.value.partyDetails.partyState.value
                            salesOrderFormData.value.consigneeDetail.consigneeDetailState = CurrentPartyDetailData.value.partyDetails.partyState.label

                            salesOrderFormData.value.dispatchDetail.dispatchDetailStateId = CurrentPartyDetailData.value.partyDetails.partyState.value
                            salesOrderFormData.value.dispatchDetail.dispatchDetailState = CurrentPartyDetailData.value.partyDetails.partyState.label
                        }

                        if (CurrentPartyDetailData.value.partyDetails.partyCountry) {
                            PartyDetailTabData.value.partyDetailCountryID = CurrentPartyDetailData.value.partyDetails.partyCountry.value
                            PartyDetailTabData.value.partyDetailCountry = CurrentPartyDetailData.value.partyDetails.partyCountry.label

                            salesOrderFormData.value.buyerDetail.buyerDetailCountryID = CurrentPartyDetailData.value.partyDetails.partyCountry.value
                            salesOrderFormData.value.buyerDetail.buyerDetailCountry = CurrentPartyDetailData.value.partyDetails.partyCountry.label

                            salesOrderFormData.value.consigneeDetail.consigneeDetailCountryID = CurrentPartyDetailData.value.partyDetails.partyCountry.value
                            salesOrderFormData.value.consigneeDetail.consigneeDetailCountry = CurrentPartyDetailData.value.partyDetails.partyCountry.label

                            salesOrderFormData.value.dispatchDetail.dispatchDetailCountryID = CurrentPartyDetailData.value.partyDetails.partyCountry.value
                            salesOrderFormData.value.dispatchDetail.dispatchDetailCountry = CurrentPartyDetailData.value.partyDetails.partyCountry.label
                        }

                        PartyDetailTabData.value.partyDetailFaxNo = CurrentPartyDetailData.value.partyDetails.partyFaxNo
                        salesOrderFormData.value.buyerDetail.buyerDetailFaxNo = CurrentPartyDetailData.value.partyDetails.partyFaxNo
                        salesOrderFormData.value.consigneeDetail.consigneeDetailFaxNo = CurrentPartyDetailData.value.partyDetails.partyFaxNo
                        salesOrderFormData.value.dispatchDetail.dispatchDetailFaxNo = CurrentPartyDetailData.value.partyDetails.partyFaxNo

                        PartyDetailTabData.value.partyDetailEmailId = CurrentPartyDetailData.value.partyDetails.partyEmilId
                        salesOrderFormData.value.buyerDetail.buyerDetailEmailId = CurrentPartyDetailData.value.partyDetails.partyEmilId
                        salesOrderFormData.value.consigneeDetail.consigneeDetailEmailId = CurrentPartyDetailData.value.partyDetails.partyEmilId
                        salesOrderFormData.value.dispatchDetail.dispatchDetailEmailId = CurrentPartyDetailData.value.partyDetails.partyEmilId

                        PartyDetailTabData.value.partyDetailWebsite = CurrentPartyDetailData.value.partyDetails.partyWebsite
                        salesOrderFormData.value.buyerDetail.buyerDetailWebsite = CurrentPartyDetailData.value.partyDetails.partyWebsite
                        salesOrderFormData.value.consigneeDetail.consigneeDetailWebsite = CurrentPartyDetailData.value.partyDetails.partyWebsite
                        salesOrderFormData.value.dispatchDetail.dispatchDetailWebsite = CurrentPartyDetailData.value.partyDetails.partyWebsite

                        PartyDetailTabData.value.partyDetailPinCode = CurrentPartyDetailData.value.partyDetails.partyPinCode
                        salesOrderFormData.value.buyerDetail.buyerDetailPinCode = CurrentPartyDetailData.value.partyDetails.partyPinCode
                        salesOrderFormData.value.consigneeDetail.consigneeDetailPinCode = CurrentPartyDetailData.value.partyDetails.partyPinCode
                        salesOrderFormData.value.dispatchDetail.dispatchDetailPinCode = CurrentPartyDetailData.value.partyDetails.partyPinCode

                        PartyDetailTabData.value.partyDetailStdCode = CurrentPartyDetailData.value.partyDetails.partyCountryCode
                        salesOrderFormData.value.buyerDetail.buyerDetailPhoneStdCode = CurrentPartyDetailData.value.partyDetails.partyCountryCode
                        salesOrderFormData.value.consigneeDetail.consigneeDetailPhoneStdCode = CurrentPartyDetailData.value.partyDetails.partyCountryCode
                        salesOrderFormData.value.dispatchDetail.dispatchDetailPhoneStdCode = CurrentPartyDetailData.value.partyDetails.partyCountryCode

                        PartyDetailTabData.value.partyDetailPhoneNo = CurrentPartyDetailData.value.partyDetails.partyPhoneNo
                        salesOrderFormData.value.buyerDetail.buyerDetailPhoneNo = CurrentPartyDetailData.value.partyDetails.partyPhoneNo
                        salesOrderFormData.value.consigneeDetail.consigneeDetailPhoneNo = CurrentPartyDetailData.value.partyDetails.partyPhoneNo
                        salesOrderFormData.value.dispatchDetail.dispatchDetailPhoneNo = CurrentPartyDetailData.value.partyDetails.partyPhoneNo
                    }

                    if (CurrentPartyDetailData.value.taxDetails) {

                        PartyDetailTabData.value.partyDetailGstNo = CurrentPartyDetailData?.value.taxDetails.gstin
                        salesOrderFormData.value.buyerDetail.buyerDetailGstNo = CurrentPartyDetailData?.value.taxDetails.gstin
                        salesOrderFormData.value.consigneeDetail.consigneeDetailGstNo = CurrentPartyDetailData?.value.taxDetails.gstin
                        salesOrderFormData.value.dispatchDetail.dispatchDetailGstNo = CurrentPartyDetailData?.value.taxDetails.gstin

                        PartyDetailTabData.value.partyDetailTinVatNO = CurrentPartyDetailData?.value.taxDetails.tinVatNo
                        salesOrderFormData.value.buyerDetail.buyerDetailTinVatNO = CurrentPartyDetailData?.value.taxDetails.tinVatNo
                        salesOrderFormData.value.consigneeDetail.consigneeDetailTinVatNO = CurrentPartyDetailData?.value.taxDetails.tinVatNo
                        salesOrderFormData.value.dispatchDetail.dispatchDetailTinVatNO = CurrentPartyDetailData?.value.taxDetails.tinVatNo

                        PartyDetailTabData.value.partyDetailTinCstNO = CurrentPartyDetailData?.value.taxDetails.tinCstNo
                        salesOrderFormData.value.buyerDetail.buyerDetailTinCstNO = CurrentPartyDetailData?.value.taxDetails.tinCstNo
                        salesOrderFormData.value.consigneeDetail.consigneeDetailTinCstNO = CurrentPartyDetailData?.value.taxDetails.tinCstNo
                        salesOrderFormData.value.dispatchDetail.dispatchDetailTinCstNO = CurrentPartyDetailData?.value.taxDetails.tinCstNo

                        PartyDetailTabData.value.partyDetailTinEccNO = CurrentPartyDetailData?.value.taxDetails.eccNo
                        salesOrderFormData.value.buyerDetail.buyerDetailEccNO = CurrentPartyDetailData?.value.taxDetails.eccNo
                        salesOrderFormData.value.consigneeDetail.consigneeDetailEccNO = CurrentPartyDetailData?.value.taxDetails.eccNo
                        salesOrderFormData.value.dispatchDetail.dispatchDetailEccNO = CurrentPartyDetailData?.value.taxDetails.eccNo

                        PartyDetailTabData.value.partyDetailPanNo = CurrentPartyDetailData?.value.taxDetails.panNo
                        salesOrderFormData.value.buyerDetail.buyerDetailPanNo = CurrentPartyDetailData?.value.taxDetails.panNo
                        salesOrderFormData.value.consigneeDetail.consigneeDetailPanNo = CurrentPartyDetailData?.value.taxDetails.panNo
                        salesOrderFormData.value.dispatchDetail.dispatchDetailPanNo = CurrentPartyDetailData?.value.taxDetails.panNo
                    }

                    if (CurrentPartyDetailData.value.partyCurrencyType) {

                        salesOrderFormData.value.salesOrderCurrency = CurrentPartyDetailData.value.partyCurrencyType

                        axios.get(`/api/currency-master/${CurrentPartyDetailData.value.partyCurrencyType}`)
                            .then(Curres => {

                                if (Curres.data.data) {

                                    salesOrderFormData.value.salesOrderConvRate = Curres.data.data.currencyRate
                                }
                            })

                    }

                    if (CurrentPartyDetailData.value.partySupplyType) {

                        salesOrderFormData.value.salesOrderSupplyType = CurrentPartyDetailData.value.partySupplyType
                    }

                    if (CurrentPartyDetailData.value.partyBranch) {

                        salesOrderFormData.value.salesOrderBranch = CurrentPartyDetailData.value.partyBranch.value
                    }

                })

            salesOrderFormData.value.kindAttnId = null

            await axios.get(`/api/party/get-party-contacts-options/${val}`)
                .then(res => {
                    KindAttnOptions.value = res.data.data
                })

            //console.log(salesOrderFormData.value)

        }

        const getContactDetail = async (val) => {

            await axios.get(`/api/party/contact-person/${val}`)
                .then(res => {

                    //console.log(res.data.data)

                    salesOrderFormData.value.kindAttnName = res.data.data.personName
                    salesOrderFormData.value.kindAttnMobile = res.data.data.mobileNo
                    salesOrderFormData.value.kindAttnEmail = res.data.data.email
                })

        }

        const formatDates = ref({
            soDate: null,
            soCommittedDate: null,
            soPoDate: null,
            soReviewDate: null,
        })

        const getSoFormatDate = (date) => {
            salesOrderFormData.value.salesOrderDate = forMatIndianDate(date)
        }
        const getSoCommittedDate = (date) => {
            salesOrderFormData.value.salesOrderCommittedDate = forMatIndianDate(date)
        }
        const getSoPoDate = (date) => {
            salesOrderFormData.value.salesOrderPoDate = forMatIndianDate(date)
        }
        const getSoReviewDate = (date) => {
            salesOrderFormData.value.salesOrderReviewDate = forMatIndianDate(date)
        }

        const openQuotationModal = async () => {
            modalTableBusy.value.quotationListIsBusy = true
            salesOrderFormData.value.qtnItemIds = []
            salesQuotationModal.value.show()
            await axios.get('/api/get-approve-sales-quotation-list')
                .then(res => {
                    modalTableData.value.quotationData = res.data.data
                })
            modalTableBusy.value.quotationListIsBusy = false
        }

        const getQuotationItems = async (data) => {
            modalTableBusy.value.itemIsBusy = true
            salesOrderFormData.value.sellToPartyCustomerID = data.partyId
            salesOrderFormData.value.salesOrderSalesType = data.qtnType
            salesOrderFormData.value.salesOrderType = data.salesType
            await getPartyCode(data.partyId)
            salesOrderFormData.value.salesOrderCurrency = data.currency
            salesOrderFormData.value.salesOrderConvRate = data.convRate
            salesOrderFormData.value.salesOrderBranch = data.branch
            salesOrderFormData.value.branchQtnNo = data.branchQtyNo
            //salesOrderFormData.value.qtnSrNo = data?.customerDetailsData?.reference ?? null
            salesOrderFormData.value.qtnRefNo = data.quotationNo
            if (data.item_details) {
                modalTableData.value.itemListData = data.item_details
            } else {
                modalTableData.value.itemListData = []
            }
            modalTableBusy.value.itemIsBusy = false
        }

        const resetModalData = () => {
            modalTableData.value.quotationData = []
            modalTableData.value.itemListData = []
        }

        const selectedQuotationItemIds = (e, id) => {
            if (e === false) {
                salesOrderFormData.value.qtnItemIds = salesOrderFormData.value.qtnItemIds.filter(function (e) {
                    return e !== id;
                });
            } else {
                salesOrderFormData.value.qtnItemIds.push(id);
            }
        }

        return {
            salesQuotationModal,
            modalTableFields,
            modalTableData,
            salesOptions,
            getSoFormatDate,
            getSoCommittedDate,
            getSoPoDate,
            getSoReviewDate,
            formatDates,
            PartyListOption,
            dateFormat,
            BranchOptions,
            currencyOptions,
            KindAttnOptions,
            CurrentPartyDetailData,
            StatusOptions,
            SalesTypeOptions,
            OrderTypeOptions,
            SupplyTypeOption,
            GstPercentageOption,
            salesOrderFormData,
            getPartyCode,
            getContactDetail,
            PartyDetailTabData,
            companyOptions,
            required,

            openQuotationModal,
            modalTableBusy,
            getQuotationItems,
            resetModalData,
            selectedQuotationItemIds
        }
    },
    methods: {
        validationForm() {
            this.$refs.simpleRules.validate()
                .then(success => {
                    if (success) {

                        console.log(this.salesOrderFormData)

                        store.dispatch('sales-order-module/addSalesOrder', this.salesOrderFormData)
                            .then(response => {
                                if (response.status === 200) {
                                    this.$router.push({
                                        name: 'edit-sales-order',
                                        params: { id: response.data.data._id }
                                    })
                                    this.$toast({
                                        component: ToastificationContent,
                                        position: 'top-right',
                                        props: {
                                            title: 'Order Created',
                                            icon: 'CheckSquareIcon',
                                            variant: 'success',
                                            text: `You have successfully Created New Sales Order.`,
                                        },
                                    })
                                }
                            })
                    }
                })
        },
    }
}
</script>
