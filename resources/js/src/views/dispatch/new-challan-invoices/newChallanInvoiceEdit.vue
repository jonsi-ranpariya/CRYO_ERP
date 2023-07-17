<template>
    <div>
        <b-overlay
            :show="showOverlayLoading"
            rounded="sm"
        >
            <b-card-code>
                <validation-observer #default="{ handleSubmit }">
                    <b-form @submit.prevent="handleSubmit(saveFormData)">
                        <b-row>
                            <b-col md="12">
                                <b-form-group
                                    label="Sales Order"
                                    label-for="salesOrderNumber"
                                >
                                    <v-select
                                        :clearable="false"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="salesOrderOption"
                                        :reduce="val => val.value"
                                        @input="getSalesOrderDetail($event)"
                                        input-id="salesOrderNumber"
                                        multiple
                                        placeholder="Select Sales Order"
                                        taggable
                                        v-model="formData.salesOrderNumber"
                                    />
                                </b-form-group>
                                <validation-provider
                                    #default="validationContext"
                                    name="Company"
                                    rules="required"
                                >
                                    <b-form-group
                                        label="Company"
                                        label-for="company"
                                        :state="getValidationState(validationContext)"
                                    >
                                        <v-select
                                            placeholder="Select company"
                                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                            :options="companyOptions"
                                            :reduce="val => val.value"
                                            :clearable="false"
                                            input-id="company"
                                            v-model="formData.company"
                                        />
                                        <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                            {{ validationContext.errors[0] }}
                                        </b-form-invalid-feedback>
                                    </b-form-group>
                                </validation-provider>
                            </b-col>
                            <b-col md="6">
                                <validation-provider
                                    #default="validationContext"
                                    name="Sell Party"
                                    rules="required"
                                >
                                    <b-form-group
                                        label="Sell-To Party"
                                        label-for="SellToParty"
                                    >
                                        <v-select
                                            placeholder="Select Code"
                                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                            :options="partyCodeOptions"
                                            :reduce="val => val.value"
                                            :clearable="false"
                                            input-id="PartyCode"
                                            v-model="formData.SellToParty"
                                            :state="getValidationState(validationContext)"
                                        />
                                    </b-form-group>
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </validation-provider>
                                <validation-provider
                                    #default="validationContext"
                                    name="Sell-to Description"
                                    rules="required"
                                >
                                    <b-form-group
                                        label="Sell-To Description"
                                        label-for="sellToDescription"
                                        readonly
                                    >
                                        <b-form-input
                                            id="SellToDescription"
                                            :state="getValidationState(validationContext)"
                                            v-model="formData.sellToDescription"
                                        />
                                    </b-form-group>
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </validation-provider>
                                <validation-provider
                                    #default="validationContext"
                                    name="Ship-To Party"
                                    rules="required"
                                >
                                    <b-form-group
                                        label="Ship-To Party"
                                        label-for="ShipToParty"
                                        :state="getValidationState(validationContext)"
                                    >
                                        <v-select
                                            placeholder="Select Code"
                                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                            :options="partyCodeOptions"
                                            :reduce="val => val.value"
                                            :clearable="false"
                                            input-id="PartyCode"
                                            v-model="formData.ShipToParty"
                                            :state="getValidationState(validationContext)"
                                        />
                                    </b-form-group>
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </validation-provider>
                                <validation-provider
                                    #default="validationContext"
                                    name="Ship-to Description"
                                    rules="required"
                                >
                                    <b-form-group
                                        label="Ship-To Description"
                                        label-for="shipToDescription"
                                        readonly
                                    >
                                        <b-form-input
                                            id="shipToDescription"
                                            :state="getValidationState(validationContext)"
                                            v-model="formData.shipToDescription"
                                        />
                                    </b-form-group>
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </validation-provider>
                                <b-row>
                                    <b-col md="6">
                                        <b-form-group
                                            label="Invoice No."
                                            label-for="invoiceNo"
                                        >
                                            <b-form-input
                                                id="invoiceNo"
                                                v-model="formData.invoiceNo"
                                            />
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="6">
                                        <b-form-group
                                            label="Invoice Date"
                                            label-for="invoiceDate"
                                        >
                                            <b-input-group>
                                                <cleave
                                                    id="invoiceDate"
                                                    v-model="formData.invoiceDate"
                                                    class="form-control"
                                                    :raw="false"
                                                    :options="dateFormat"
                                                    placeholder="DD/MM/YYYY"
                                                    show-decade-nav
                                                />
                                                <b-input-group-append>
                                                    <b-form-datepicker
                                                        v-model="formatDates.invoiceDate"
                                                        button-only
                                                        @input="getInvoiceFormatDate($event)"
                                                        show-decade-nav
                                                        size="sm"
                                                        nav-button-variant="primary"
                                                    />
                                                </b-input-group-append>
                                            </b-input-group>
                                        </b-form-group>
                                    </b-col>
                                </b-row>
                                <b-row>
                                    <b-col md="6">
                                        <b-form-group
                                            label="Challan No."
                                            label-for="challanNo"
                                        >
                                            <b-form-input
                                                id="challanNo"
                                                v-model="formData.challanNo"
                                            />
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="6">
                                        <b-form-group
                                            label="Challan Date"
                                            label-for="challanDate"
                                        >
                                            <b-input-group>
                                                <cleave
                                                    id="challanDate"
                                                    v-model="formData.challanDate"
                                                    class="form-control"
                                                    :raw="false"
                                                    :options="dateFormat"
                                                    placeholder="DD/MM/YYYY"
                                                    show-decade-nav
                                                />
                                                <b-input-group-append>
                                                    <b-form-datepicker
                                                        v-model="formatDates.challanDate"
                                                        button-only
                                                        @input="getChallanFormatDate($event)"
                                                        show-decade-nav
                                                        size="sm"
                                                        nav-button-variant="primary"
                                                    />
                                                </b-input-group-append>
                                            </b-input-group>
                                        </b-form-group>
                                    </b-col>
                                </b-row>
                            </b-col>
                            <b-col md="6">
                                <b-row>
                                    <b-col md="6">
                                        <b-form-group
                                            label="Sales"
                                            label-for="sales"
                                        >
                                            <v-select
                                                placeholder="Select Sales"
                                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                                :options="SalesOptions"
                                                :reduce="val => val.value"
                                                :clearable="false"
                                                input-id="sales"
                                                v-model="formData.sales"
                                            />
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="6">
                                        <b-form-group
                                            label="Tax Type"
                                            label-for="taxType"
                                        >
                                            <v-select
                                                placeholder="Select Type"
                                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                                :options="TextTypeOptions"
                                                :reduce="val => val.value"
                                                :clearable="false"
                                                input-id="taxType"
                                                v-model="formData.taxType"
                                            />
                                        </b-form-group>
                                    </b-col>
                                </b-row>
                                <b-row>
                                    <b-col md="6">
                                        <b-form-group
                                            label="Supply Type"
                                            label-for="interstateType"
                                        >
                                            <v-select
                                                placeholder="Supply Type"
                                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                                :options="typeOption"
                                                :reduce="val => val.value"
                                                :clearable="false"
                                                id="interstateType"
                                                v-model="formData.interstateType"
                                            />
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="6">
                                        <validation-provider
                                            #default="validationContext"
                                            name="GST Type"
                                            rules="required"
                                        >
                                            <b-form-group
                                                label="GST Type"
                                                label-for="gstCalculationType"
                                                :state="getValidationState(validationContext)"
                                            >
                                                <v-select
                                                    placeholder="GST Type"
                                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                                    :options="gstCalculationTypeOptions"
                                                    :reduce="val => val.value"
                                                    :clearable="false"
                                                    id="gstCalculationType"
                                                    v-model="formData.gstCalculationType"
                                                    :state="getValidationState(validationContext)"
                                                />
                                            </b-form-group>
                                            <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                                {{ validationContext.errors[0] }}
                                            </b-form-invalid-feedback>
                                        </validation-provider>
                                    </b-col>
                                </b-row>
                                <b-row>
                                    <b-col md="6">
                                        <b-form-group
                                            label="Reverse Charge"
                                            label-for="reverseCharge"
                                        >
                                            <v-select
                                                placeholder="Select Charge"
                                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                                :options="ReverseChargeOption"
                                                :reduce="val => val.value"
                                                :clearable="false"
                                                input-id="reverseCharge"
                                                v-model="formData.reverseCharge"
                                            />
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="6">
                                        <b-form-group
                                            label="Report Supply Type"
                                            label-for="reportSupplyType"
                                        >
                                            <v-select
                                                placeholder="Select supply type"
                                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                                :options="reportSupplyType"
                                                :reduce="val => val.value"
                                                :clearable="false"
                                                input-id="reportSupplyType"
                                                v-model="formData.reportSupplyType"
                                            />
                                        </b-form-group>
                                    </b-col>
                                </b-row>
                                <b-row>
                                    <b-col md="6">
                                        <b-form-group
                                            label="Currency"
                                            label-for="currency"
                                        >
                                            <v-select
                                                placeholder="Select currency"
                                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                                :options="currencyOptions"
                                                :reduce="val => val.value"
                                                :clearable="false"
                                                input-id="currency"
                                                v-model="formData.currency"
                                                @input="getCurrencyDetails($event)"
                                            />
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="6">
                                        <b-form-group
                                            label="Conv. Rate"
                                            label-for="convRate"
                                        >
                                            <b-form-input
                                                id="convRate"
                                                v-model="formData.currencyRate"
                                            />
                                        </b-form-group>
                                    </b-col>
                                </b-row>
                                <b-row>
                                    <b-col md="6">
                                        <b-form-group
                                            label="Cust PO. No."
                                            label-for="orderNo"
                                        >
                                            <b-form-input
                                                id="orderNo"
                                                v-model="formData.orderNo"
                                            />
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="6">
                                        <b-form-group
                                            label="P.O Date"
                                            label-for="orderDate"
                                        >
                                            <!--<b-form-datepicker
                                                id="orderDate"
                                                :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }"
                                                v-model="formData.orderDate"
                                            />-->
                                            <b-input-group>
                                                <cleave
                                                    id="orderDate"
                                                    v-model="formData.orderDate"
                                                    class="form-control"
                                                    :raw="false"
                                                    :options="dateFormat"
                                                    placeholder="DD/MM/YYYY"
                                                    show-decade-nav
                                                />
                                                <b-input-group-append>
                                                    <b-form-datepicker
                                                        v-model="formatDates.orderDate"
                                                        button-only
                                                        @input="getOrderFormatDate($event)"
                                                        show-decade-nav
                                                        size="sm"
                                                        nav-button-variant="primary"
                                                    />
                                                </b-input-group-append>
                                            </b-input-group>
                                        </b-form-group>
                                    </b-col>
                                </b-row>
                                <b-row>
                                    <b-col md="6">
                                        <b-form-group
                                            label="Is Service?"
                                            label-for="invoice"
                                        >
                                            <v-select
                                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                                :options="InvoiceOptions"
                                                :reduce="val => val.value"
                                                :clearable="false"
                                                input-id="invoice"
                                                v-model="formData.invoice"
                                            />
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="6">
                                        <b-form-group
                                            label="Invoice Type"
                                            label-for="invoiceType"
                                        >
                                            <v-select
                                                placeholder="Select Type"
                                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                                :options="InvoiceTypeOptions"
                                                :reduce="val => val.label"
                                                :clearable="false"
                                                input-id="invoiceType"
                                                v-model="formData.invoiceType"
                                            />
                                        </b-form-group>
                                    </b-col>
                                </b-row>
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
                                            v-model="formData.roundingType"
                                        >
                                            None
                                        </b-form-radio>
                                        <b-form-radio
                                            name="selectRound"
                                            value="1"
                                            v-model="formData.roundingType"
                                        >
                                            Rounding
                                        </b-form-radio>
                                        <b-form-radio
                                            name="selectRound"
                                            value="2"
                                            v-model="formData.roundingType"
                                        >
                                            Rounding All
                                        </b-form-radio>
                                    </div>
                                </b-form-group>
                            </b-col>
                            <!--Button-->
                            <b-col md="12">
                                <hr>
                                <b-button
                                    type="submit"
                                    class="float-right"
                                    variant="primary"
                                >
                                    Save
                                </b-button>
                            </b-col>
                        </b-row>
                    </b-form>
                </validation-observer>
            </b-card-code>
        </b-overlay>
        <!--tabs-->
        <b-overlay
            :show="showOverlayLoading"
            rounded="sm"
        >
            <b-card-code>
                <b-tabs pills lazy>
                    <b-tab active>
                        <template #title>
                            <feather-icon
                                icon="FileIcon"
                                size="16"
                                class="mr-0 mr-sm-50"
                            />
                            <span class="d-none d-sm-inline">Item Details</span>
                        </template>
                        <item-details-tab
                            :roundingType="formData.roundingType"
                            :gstCalculationType="formData.gstCalculationType"
                        />
                    </b-tab>
                    <b-tab>
                        <template #title>
                            <feather-icon
                                icon="LayoutIcon"
                                size="16"
                                class="mr-0 mr-sm-50"
                            />
                            <span class="d-none d-sm-inline">Billing Terms</span>
                        </template>
                        <hr>
                        <billing-terms-tab
                            :roundingType="formData.roundingType"
                            :gstCalculationType="formData.gstCalculationType"
                        />
                    </b-tab>
                    <b-tab>
                        <template #title>
                            <feather-icon
                                icon="TypeIcon"
                                size="16"
                                class="mr-0 mr-sm-50"
                            />
                            <span class="d-none d-sm-inline">Terms & Condition</span>
                        </template>
                        <hr>
                        <terms-condition-tab
                        />
                    </b-tab>
                    <b-tab>
                        <template #title>
                            <feather-icon
                                icon="CodepenIcon"
                                size="16"
                                class="mr-0 mr-sm-50"
                            />
                            <span class="d-none d-sm-inline">Party</span>
                        </template>
                        <hr>
                        <party-details-tab
                            :partyDetails.sync="formData.partyDetails"
                        />
                    </b-tab>
                    <b-tab>
                        <template #title>
                            <feather-icon
                                icon="BoldIcon"
                                size="16"
                                class="mr-0 mr-sm-50"
                            />
                            <span class="d-none d-sm-inline">Buyer</span>
                        </template>
                        <hr>
                        <buyer-details-tab
                            :buyerDetails.sync="formData.buyerDetails"
                        />
                    </b-tab>
                    <b-tab>
                        <template #title>
                            <feather-icon
                                icon="BriefcaseIcon"
                                size="16"
                                class="mr-0 mr-sm-50"
                            />
                            <span class="d-none d-sm-inline">Consignee</span>
                        </template>
                        <hr>
                        <consignee-tab
                            :consigneeDetails.sync="formData.consigneeDetails"
                        />
                    </b-tab>
                    <b-tab>
                        <template #title>
                            <feather-icon
                                icon="TruckIcon"
                                size="16"
                                class="mr-0 mr-sm-50"
                            />
                            <span class="d-none d-sm-inline">Dispatch</span>
                        </template>
                        <hr>
                        <dispatch-tab
                            :dispatchDetails.sync="formData.dispatchDetails"
                        />
                    </b-tab>
                    <b-tab>
                        <template #title>
                            <feather-icon
                                icon="TruckIcon"
                                size="16"
                                class="mr-0 mr-sm-50"
                            />
                            <span class="d-none d-sm-inline">Transporter/Export</span>
                        </template>
                        <hr>
                        <transport-export-tab
                            :transportExportData.sync="formData.transportExportData"
                        />
                    </b-tab>
                    <b-tab>
                        <template #title>
                            <feather-icon
                                icon="PackageIcon"
                                size="16"
                                class="mr-0 mr-sm-50"
                            />
                            <span class="d-none d-sm-inline">Packing List</span>
                        </template>
                        <hr>
                        <packaging-list/>
                    </b-tab>
                    <b-tab>
                        <template #title>
                            <feather-icon
                                icon="ShoppingCartIcon"
                                size="16"
                                class="mr-0 mr-sm-50"
                            />
                            <span class="d-none d-sm-inline">Shipping Dimensions</span>
                        </template>
                        <hr>
                        <shipping-dimensions/>
                    </b-tab>
                    <b-tab>
                        <template #title>
                            <feather-icon
                                icon="FileIcon"
                                size="16"
                                class="mr-0 mr-sm-50"
                            />
                            <span class="d-none d-sm-inline">Reports</span>
                        </template>
                        <hr>
                        <report-tab/>
                    </b-tab>
                    <b-tab>
                        <template #title>
                            <feather-icon
                                icon="MailIcon"
                                size="16"
                                class="mr-0 mr-sm-50"
                            />
                            <span class="d-none d-sm-inline">Envelope</span>
                        </template>
                        <hr>
                        <envolope-tab/>
                    </b-tab>
                </b-tabs>
            </b-card-code>
        </b-overlay>
    </div>
</template>
<script>
import BCardCode from "../../../@core/components/b-card-code/BCardCode";
import formValidation from "../../../@core/comp-functions/forms/form-validation";
import {
    BButton,
    BCol,
    BForm,
    BFormCheckbox,
    BFormDatepicker,
    BFormGroup,
    BFormInput,
    BFormInvalidFeedback,
    BFormRadio,
    BOverlay,
    BRow,
    BTab,
    BTabs,
    BFormTextarea,
    BInputGroup,
    BInputGroupAppend
} from 'bootstrap-vue'
import {ValidationObserver, ValidationProvider} from 'vee-validate'
import vSelect from 'vue-select'
import {onUnmounted, ref} from "@vue/composition-api";
import itemDetailsTab from "./tabs/itemDetailsTab"
import billingTermsTab from "./tabs/billingTermsTab"
import termsConditionTab from "./tabs/termsConditionTab"
import partyDetailsTab from "./tabs/partyDetailsTab";
import buyerDetailsTab from "./tabs/buyerDetailsTab";
import consigneeTab from "./tabs/consigneeTab";
import transportExportTab from "./tabs/transportExportTab";
import reportTab from "./tabs/reportTab";
import dispatchTab from "./tabs/dispatchTab"
import router from "@/router";
import store from '@/store'
import {required} from '@validations'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
import {useToast} from 'vue-toastification/composition'
import dispatchStoreModule from "../dispatchStoreModule";
import axios from '@axios'
import {getTcTodayDate, forMatIndianDate} from "@core/utils/utils";
import Cleave from 'vue-cleave-component'
import PackagingList from "./tabs/packagingList";
import EnvolopeTab from "./tabs/envolopeTab";
import ShippingDimensions from "./tabs/shippingDimensions";

export default {
    components: {
        ShippingDimensions,
        EnvolopeTab,
        PackagingList,
        BCardCode,
        ValidationObserver,
        ValidationProvider,
        vSelect,
        BForm,
        BRow,
        BCol,
        BFormGroup,
        BFormInput,
        BFormInvalidFeedback,
        BFormTextarea,
        BFormDatepicker,
        BFormCheckbox,
        BButton,
        BOverlay,
        BTabs,
        BTab,
        BFormRadio,
        itemDetailsTab,
        billingTermsTab,
        termsConditionTab,
        partyDetailsTab,
        buyerDetailsTab,
        consigneeTab,
        transportExportTab,
        reportTab,
        dispatchTab,
        BInputGroup,
        BInputGroupAppend,
        Cleave,
    },
    setup() {
        const ITEMADDON_APP_STORE_MODULE_NAME = 'dispatch-store-module'
        if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, dispatchStoreModule)
        onUnmounted(() => {
            if (store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.unregisterModule(ITEMADDON_APP_STORE_MODULE_NAME)
        })

        const toast = useToast()

        const showOverlayLoading = ref(false)

        const InvoiceOptions = ref([
            {
                label: 'No',
                value: 1
            },
            {
                label: 'Yes',
                value: 6
            },
        ])
        const InvoiceTypeOptions = ref([])
        axios.get('/api/get-invoice-type-options').then(res => {
            InvoiceTypeOptions.value = res.data.data
        })

        const TextTypeOptions = ref([
            {label: 'Old', value: 1},
            {label: 'GST', value: 2},
        ])
        const GstInvoiceTypeOptions = ref([
            {label: 'Tax Invoice', value: 1},
            {label: 'Retail Invoice', value: 2},
            {label: 'Bill Of Supply', value: 3},
            {label: 'Other', value: 4},
        ])
        const SalesOptions = ref([
            {label: 'Domestic', value: 1},
            {label: 'Export', value: 2},
        ])
        const SupplyTypeOption = ref([
            {label: 'Goods', value: 1},
            {label: 'Services', value: 2},
        ])
        const reportSupplyType = ref([
            {label: 'B2B', value: 'B2B'},
            {label: 'SEZWP', value: 'SEZWP'},
            {label: 'SEZWOP', value: 'SEZWOP'},
            {label: 'EXPWP', value: 'EXPWP'},
            {label: 'EXPWOP', value: 'EXPWOP'},
            {label: 'DEXP', value: 'DEXP'},
        ])
        const ReverseChargeOption = ref([
            {label: 'Yes', value: 1},
            {label: 'No', value: 2},
        ])
        const gstOption = ref([
            {label: 'Invoice Wise', value: 1},
            {label: 'Item Wise', value: 2},
        ])
        const typeOption = ref([
            {label: 'Intrastate Sales-Taxable', value: 1},
            {label: 'Interstate Sales-Taxable', value: 2},
            {label: 'Interstate Sales-Nil Rated', value: 3},
            {label: 'Interstate Sales-Nil Exempted', value: 4},
            {label: 'Export-Exempted', value: 5},
            {label: 'Export-Nil Rated', value: 6},
            {label: 'SEZ-Exempted', value: 7},
            {label: 'SEZ-Nil Rated', value: 8},
            {label: 'Deemed Export - Exempted', value: 9},
            {label: 'Union Territory Sales-Taxable', value: 10},
            {label: 'Union Territory Sales-Nil', value: 11},
        ])
        const partyCodeOptions = ref([])
        axios.get('/api/party/get-master-customer-options').then(res => {
            partyCodeOptions.value = res.data.data
        })
        const companyOptions = ref([])
        axios.get('/api/administration/get-company-options').then(res => {
            companyOptions.value = res.data.data
        })

        const salesOrderOption = ref([])
        axios.get('/api/get-sales-order-options').then(res => {
            salesOrderOption.value = res.data.data
        })

        const KindAttnOptions = ref([])

        const currencyOptions = ref([])
        axios.get('/api/get-currency-options').then((res) => {
            currencyOptions.value = res.data.data
        });
        const gstCalculationTypeOptions = ref([
            {label: 'Item Wise', value: 1},
            {label: 'Non Taxable (OTH)', value: 2}
        ])

        const blankFormData = {
            company: null,
            SellToParty: null,
            sellToDescription: null,
            ShipToParty: null,
            shipToDescription: null,
            invoiceNo: null,
            invoiceDate: null,
            challanNo: null,
            challanDate: null,
            orderNo: null,
            orderDate: null,
            invoice: null,
            invoiceType: null,
            taxType: null,
            gstInvoiceType: null,
            salesOrderNumber: null,
            sales: null,
            supplyType: null,
            interstateType: null,
            gstCalculationType: null,
            reverseCharge: null,
            gstPercentage: null,
            roundingType: null,
            reportTermAndCondition: null,
            reportSupplyType: 'B2B',
            kindAttnId: null,
            kindAttnName: null,
            kindAttnMobile: null,
            kindAttnEmail: null,
            currency: null,
            currencyRate: null,
            partyDetails: {
                PartyCode: null,
                PartyName: null,
                partyAddress: null,
                partyCountry: null,
                partyState: null,
                partyCity: null,
                partyFaxNo: null,
                partyEmailId: null,
                partyWebSite: null,
                partyPinCode: null,
                partyPhoneCountry: '+91',
                partyPhoneNo: null,
                partyTinVatNo: null,
                partyTinCstNo: null,
                partyEccNo: null,
                partyGstinNo: null,
                partyPanNo: null,
                partyKindAttnId: null,
                partyKindAttnName: null,
                partyKindAttnMobile: null,
                partyKindAttnEmail: null,
            },
            buyerDetails: {
                buyerCode: null,
                buyerName: null,
                buyerAddress: null,
                buyerCountry: null,
                buyerState: null,
                buyerCity: null,
                buyerFaxNo: null,
                buyerEmailId: null,
                buyerWebSite: null,
                buyerPinCode: null,
                buyerPhoneCountry: '+91',
                buyerPhoneNo: null,
                buyerTinVatNo: null,
                buyerTinCstNo: null,
                buyerEccNo: null,
                buyerGstinNo: null,
                buyerPanNo: null,
                buyerKindAttnId: null,
                buyerKindAttnName: null,
                buyerKindAttnMobile: null,
                buyerKindAttnEmail: null,
            },
            consigneeDetails: {
                consigneeCode: null,
                consigneeName: null,
                consigneeAddress: null,
                consigneeCountry: null,
                consigneeState: null,
                consigneeCity: null,
                consigneeFaxNo: null,
                consigneeEmailId: null,
                consigneeWebSite: null,
                consigneePinCode: null,
                consigneePhoneCountry: '+91',
                consigneePhoneNo: null,
                consigneeTinVatNo: null,
                consigneeTinCstNo: null,
                consigneeEccNo: null,
                consigneeGstinNo: null,
                consigneePanNo: null,
                consigneeKindAttnId: null,
                consigneeKindAttnName: null,
                consigneeKindAttnMobile: null,
                consigneeKindAttnEmail: null,
            },
            dispatchDetails: {
                dispatchCode: null,
                dispatchName: null,
                dispatchAddress: null,
                dispatchCountry: null,
                dispatchState: null,
                dispatchCity: null,
                dispatchFaxNo: null,
                dispatchEmailId: null,
                dispatchWebSite: null,
                dispatchPinCode: null,
                dispatchPhoneCountry: '+91',
                dispatchPhoneNo: null,
                dispatchTinVatNo: null,
                dispatchTinCstNo: null,
                dispatchEccNo: null,
                dispatchGstinNo: null,
                dispatchPanNo: null,
                dispatchKindAttnId: null,
                dispatchKindAttnName: null,
                dispatchKindAttnMobile: null,
                dispatchKindAttnEmail: null,
            },
            transportExportData: {
                transporterPartyId: null,
                transporter: null,
                vehicalNo: null,
                distance: null,
                transporterId: null,
                transportMode: '1',
                vehicleType: 'R',
                lrNumber: null,
                lrDate: null,
                dateIssueInvoice: null,
                timeIssueInvoice: null,
                dateRemovalGood: null,
                timeRemovalGood: null,
                exportReference: null,
                otherReference: null,
                preCarriageBy: null,
                vessel: null,
                portOfDischarge: null,
                placeOfReceipt: null,
                placeOfLoading: null,
                finalDestination: null,
                exportCurrentDesc: null,
                exportTerms: null,
                markNoTitle: null,
                noPkgTitle: null,
                itemDescTitle: null,
                narration: null,
                note: null,
            }
        }

        const formData = ref(JSON.parse(JSON.stringify(blankFormData)))

        const resetFormData = () => {
            formData.value = JSON.parse(JSON.stringify(blankFormData))
        }

        const refetchData = async () => {
            showOverlayLoading.value = true
            await axios.get(`/api/new-challan-and-invoice/${router.currentRoute.params.id}`).then((res) => {
                formData.value = res.data.data
            })
            showOverlayLoading.value = false
        }
        refetchData()

        const getCurrencyDetails = async (id) => {
            await axios.get(`/api/currency-master/${id}`).then((res) => {
                formData.value.currencyRate = res.data.data.currencyRate
            });
        }

        const saveFormData = async () => {
            await store.dispatch('dispatch-store-module/updateNewInvoiceChallan', formData.value).then((res) => {
                if (res.status === 200) {
                    toast({
                        component: ToastificationContent,
                        position: 'top-right',
                        props: {
                            title: 'Challan & Invoice Updated',
                            icon: 'CheckSquareIcon',
                            variant: 'success',
                            text: 'You have successfully Updated Challan & Invoice',
                        },
                    })
                } else {
                    toast({
                        component: ToastificationContent,
                        position: 'top-right',
                        props: {
                            title: 'Something went wrong',
                            icon: 'AlertCircleIcon',
                            variant: 'danger',
                            text: 'Something went wrong',
                        },
                    })
                }
            })
        }

        const dateFormat = ref({
            date: true,
            delimiter: '/',
            datePattern: ['d', 'm', 'Y'],
        })

        const formatDates = ref({
            invoiceDate: null,
            challanDate: null,
            orderDate: null,
        })

        const getInvoiceFormatDate = (date) => {
            formData.value.invoiceDate = forMatIndianDate(date)
        }
        const getChallanFormatDate = (date) => {
            formData.value.challanDate = forMatIndianDate(date)
        }
        const getOrderFormatDate = (date) => {
            formData.value.orderDate = forMatIndianDate(date)
        }

        const getSalesOrderDetail = async (ids) => {
            let submitIds = ids.length > 0 ? ids : formData.value.salesOrderNumber ?? [];
            await axios.post('/api/get-sales-order-kind-attn', {ids: submitIds}).then(res => {
                KindAttnOptions.value = res.data.data
            });
        }
        setTimeout(() => {
            getSalesOrderDetail([])
        }, 1000)


        const getContactDetail = async (id) => {
            if (id) {
                await axios.get('/api/party/contact-person/' + id).then(res => {
                    formData.value.kindAttnId = res.data.data._id
                    formData.value.kindAttnName = res.data.data.personName
                    formData.value.kindAttnMobile = res.data.data.phoneNo
                    formData.value.kindAttnEmail = res.data.data.email
                });
            } else {
                formData.value.kindAttnId = null
                formData.value.kindAttnName = null
                formData.value.kindAttnMobile = null
                formData.value.kindAttnEmail = null
            }
        }

        const {refFormObserver, getValidationState, resetForm} = formValidation(resetFormData)

        return {
            dateFormat,
            formatDates,
            getInvoiceFormatDate,
            getChallanFormatDate,
            getOrderFormatDate,
            resetFormData,
            refFormObserver,
            getValidationState,
            resetForm,
            companyOptions,
            InvoiceTypeOptions,
            InvoiceOptions,
            TextTypeOptions,
            GstInvoiceTypeOptions,
            salesOrderOption,
            partyCodeOptions,
            SalesOptions,
            SupplyTypeOption,
            reportSupplyType,
            ReverseChargeOption,
            gstOption,
            KindAttnOptions,
            currencyOptions,
            getSalesOrderDetail,
            getContactDetail,
            saveFormData,
            getCurrencyDetails,
            formData,
            showOverlayLoading,
            refetchData,
            typeOption,
            required,

            gstCalculationTypeOptions
        }
    }
}
</script>
