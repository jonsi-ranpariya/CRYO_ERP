<template>
    <div>
        <b-overlay
            :show="showOverlayLoading"
            rounded="sm"
        >
            <b-card-code>
                <validation-observer #default="{ handleSubmit }">
                    <b-form @submit.prevent="handleSubmit(saveFormData)">
                        <b-row cols="12">
                            <b-col md="12">
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
                                            v-model="formData.prCompanyId"
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
                                        label-for="prSellToParty"
                                        :state="getValidationState(validationContext)"
                                    >
                                        <v-select
                                            placeholder="Select Sell Party"
                                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                            :options="SellPartyOptions"
                                            :reduce="val => val.value"
                                            :clearable="false"
                                            input-id="prSellToParty"
                                            v-model="formData.prSellToParty"
                                            :state="getValidationState(validationContext)"
                                            @input="getPartyDetails($event)"
                                        />
                                        <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                            {{ validationContext.errors[0] }}
                                        </b-form-invalid-feedback>
                                    </b-form-group>
                                </validation-provider>
                                <validation-provider
                                    #default="validationContext"
                                    name="Sell-to Description"
                                    rules="required"
                                >
                                    <b-form-group
                                        label="Sell-To Description"
                                        label-for="prSellToDescription"
                                    >
                                        <b-form-input
                                            id="prSellToDescription"
                                            v-model="formData.prSellToDescription"
                                            :state="getValidationState(validationContext)"
                                        />
                                        <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                            {{ validationContext.errors[0] }}
                                        </b-form-invalid-feedback>
                                    </b-form-group>
                                </validation-provider>
                                <validation-provider
                                    #default="validationContext"
                                    name="Ship to Party"
                                    rules="required"
                                >
                                    <b-form-group
                                        label="Ship-To Party"
                                        label-for="prShipToParty"
                                        :state="getValidationState(validationContext)"
                                    >
                                        <v-select
                                            placeholder="Select Ship Party"
                                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                            :options="SellPartyOptions"
                                            :reduce="val => val.value"
                                            :clearable="false"
                                            input-id="prShipToParty"
                                            v-model="formData.prShipToParty"
                                            @input="getShipPartyDetails($event)"
                                        />
                                        <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                            {{ validationContext.errors[0] }}
                                        </b-form-invalid-feedback>
                                    </b-form-group>
                                </validation-provider>
                                <validation-provider
                                    #default="validationContext"
                                    name="Ship to Description"
                                    rules="required"
                                >
                                    <b-form-group
                                        label="Ship To Description"
                                        label-for="prShipToDescription"
                                    >
                                        <b-form-input
                                            id="prShipToDescription"
                                            v-model="formData.prShipToDescription"
                                            :state="getValidationState(validationContext)"
                                        />
                                        <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                            {{ validationContext.errors[0] }}
                                        </b-form-invalid-feedback>
                                    </b-form-group>
                                </validation-provider>
                                <b-row>
                                    <b-col md="6">
                                        <b-form-group
                                            label="Invoice No."
                                            label-for="prInvoiceNo"
                                        >
                                            <b-form-input
                                                id="prInvoiceNo"
                                                v-model="formData.prInvoiceNo"
                                            />
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="6">
                                        <b-form-group
                                            label="Invoice Date"
                                            label-for="prInvoiceDate"
                                        >
                                            <b-input-group>
                                                <cleave
                                                    id="prInvoiceDate"
                                                    v-model="formData.prInvoiceDate"
                                                    class="form-control"
                                                    :raw="false"
                                                    :options="dateFormat"
                                                    placeholder="DD/MM/YYYY"
                                                    show-decade-nav
                                                />
                                                <b-input-group-append>
                                                    <b-form-datepicker
                                                        v-model="formatDates.prInvoiceDate"
                                                        button-only
                                                        @input="getPoInvoiceFormatDate($event)"
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
                                            label="Invoice"
                                            label-for="prInvoice"
                                        >
                                            <v-select
                                                placeholder="Select Invoice"
                                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                                :options="InvoiceOptions"
                                                :reduce="val => val.value"
                                                :clearable="false"
                                                input-id="prInvoice"
                                                v-model="formData.prInvoice"
                                            />
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="6">
                                        <b-form-group
                                            label="Invoice Type"
                                            label-for="prInvoiceType"
                                        >
                                            <v-select
                                                placeholder="Select Type"
                                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                                :options="InvoiceTypeOptions"
                                                :reduce="val => val.value"
                                                :clearable="false"
                                                input-id="prInvoiceType"
                                                v-model="formData.prInvoiceType"
                                            />
                                        </b-form-group>
                                    </b-col>
                                </b-row>
                                <b-row>
                                    <b-col md="6">
                                        <b-form-group
                                            label="Tax Type"
                                            label-for="prTaxType"
                                        >
                                            <v-select
                                                placeholder="Select Type"
                                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                                :options="TextTypeOptions"
                                                :reduce="val => val.value"
                                                :clearable="false"
                                                input-id="prTaxType"
                                                v-model="formData.prTaxType"
                                            />
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="6">
                                        <b-form-group
                                            label="GST Invoice Type"
                                            label-for="prGstInvoiceType"
                                        >
                                            <v-select
                                                placeholder="Select Invoice"
                                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                                :options="GstInvoiceTypeOptions"
                                                :reduce="val => val.value"
                                                :clearable="false"
                                                input-id="prGstInvoiceType"
                                                v-model="formData.prGstInvoiceType"
                                            />
                                        </b-form-group>
                                    </b-col>
                                </b-row>
                            </b-col>
                            <b-col md="6">
                                <b-row>
                                    <b-col md="6">
                                        <b-form-group
                                            label="Sales"
                                            label-for="prSales"
                                        >
                                            <v-select
                                                placeholder="Select Sales"
                                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                                :options="SalesOptions"
                                                :reduce="val => val.value"
                                                :clearable="false"
                                                input-id="prSales"
                                                v-model="formData.prSales"
                                            />
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="6">
                                        <b-form-group
                                            label="Supply Type"
                                            label-for="prSupplyType"
                                        >
                                            <v-select
                                                placeholder="Select Type"
                                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                                :options="SupplyTypeOption"
                                                :reduce="val => val.value"
                                                :clearable="false"
                                                input-id="prSupplyType"
                                                v-model="formData.prSupplyType"
                                            />
                                        </b-form-group>
                                    </b-col>
                                </b-row>
                                <b-form-group
                                    label="Reverse Charge"
                                    label-for="prReverseCharge"
                                >
                                    <v-select
                                        placeholder="Select Sales"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="ReverseChargeOption"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        input-id="prReverseCharge"
                                        v-model="formData.prReverseCharge"
                                    />
                                </b-form-group>
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
                                        v-model="formData.prReportSupplyType"
                                    />
                                </b-form-group>
                                <b-form-group
                                    label="Purchase Bill No."
                                    label-for="prPurchaseBillNo"
                                >
                                    <b-form-input
                                        id="prPurchaseBillNo"
                                        v-model="formData.prPurchaseBillNo"
                                    />
                                </b-form-group>
                                <b-form-group
                                    label="Purchase Bill Date"
                                    label-for="prPurchaseDate"
                                >
                                    <b-input-group>
                                        <b-input-group-prepend>
                                            <b-form-datepicker
                                                v-model="formatDates.prPurchaseDate"
                                                button-only
                                                @input="getPurchasePrFormatDate($event)"
                                                show-decade-nav
                                                size="sm"
                                                nav-button-variant="primary"
                                            />
                                        </b-input-group-prepend>
                                        <cleave
                                            id="prPurchaseDate"
                                            v-model="formData.prPurchaseDate"
                                            class="form-control"
                                            :raw="false"
                                            :options="dateFormat"
                                            placeholder="DD/MM/YYYY"
                                            show-decade-nav
                                        />
                                    </b-input-group>
                                </b-form-group>
                                <b-form-group
                                    label="Reason"
                                    label-for="prReason"
                                >
                                    <b-form-input
                                        id="prReason"
                                        v-model="formData.prReason"
                                    />
                                </b-form-group>
                                <b-form-group
                                    label="Rounding Type"
                                    label-for="selectRound"
                                    class="mt-2"
                                >
                                    <div class="demo-inline-spacing" style="margin-top: -10px;">
                                        <b-form-radio
                                            name="selectRound"
                                            v-model="formData.prRound"
                                            value="0"
                                        >
                                            None
                                        </b-form-radio>
                                        <b-form-radio
                                            name="selectRound"
                                            v-model="formData.prRound"
                                            value="1"
                                        >
                                            Rounding
                                        </b-form-radio>
                                        <b-form-radio
                                            name="selectRound"
                                            v-model="formData.prRound"
                                            value="2"
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
    </div>
</template>
<script>
import {
    BForm,
    BRow,
    BCol,
    BFormGroup,
    BFormInput,
    BFormInvalidFeedback,
    BFormDatepicker,
    BButton,
    BFormCheckbox,
    BInputGroupAppend,
    BInputGroupPrepend,
    BInputGroup,
    BFormRadio,
    BOverlay
} from 'bootstrap-vue'
import {ValidationObserver, ValidationProvider} from 'vee-validate'
import BCardCode from "@core/components/b-card-code/BCardCode";
import VSelect from 'vue-select'
import Cleave from 'vue-cleave-component'
import formValidation from '@core/comp-functions/forms/form-validation'
import {required} from '@validations'
import {onUnmounted, onMounted, ref} from "@vue/composition-api";
import router from "@/router";
import {forMatIndianDate} from "@core/utils/utils";
import purchaseStoreModule from "../purchaseStoreModule";
import {useToast} from "vue-toastification/composition";
import store from '@/store'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
import axios from "@axios";

export default {
    components: {
        ValidationObserver,
        ValidationProvider,
        BFormInvalidFeedback,
        BFormDatepicker,
        BCardCode,
        BForm,
        BRow,
        BCol,
        BFormGroup,
        BFormInput,
        VSelect,
        BButton,
        BFormCheckbox,
        Cleave,
        BInputGroupAppend,
        BInputGroupPrepend,
        BInputGroup,
        BFormRadio,
        BOverlay
    },
    setup() {
        const ITEMADDON_APP_STORE_MODULE_NAME = 'purchase-store-module'
        onMounted(() => {
            if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, purchaseStoreModule)
        });
        onUnmounted(() => {
            if (store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.unregisterModule(ITEMADDON_APP_STORE_MODULE_NAME)
        });
        const showOverlayLoading = ref(false)
        const toast = useToast()

        const SellPartyOptions = ref([])
        axios.get('/api/party/get-master-options').then((res) => {
            SellPartyOptions.value = res.data.data
        });

        const InvoiceOptions = ref([
            {label: 'General', value: 1},
            {label: 'Export Invoice', value: 2},
            {label: 'Trading Invoice', value: 3},
            {label: 'Purchase Return', value: 4},
            {label: 'Labour Invoice', value: 5},
            {label: 'Service Invoice', value: 6},
            {label: 'NON TAXABLE', value: 7},
        ]);

        const InvoiceTypeOptions = ref([]);
        axios.get('/api/get-invoice-type-options').then((res) => {
            InvoiceTypeOptions.value = res.data.data
        });

        const TextTypeOptions = ref([
            {label: 'Old', value: 1},
            {label: 'GST', value: 2},
        ]);

        const GstInvoiceTypeOptions = ref([
            {label: 'Tax Invoice', value: 1},
            {label: 'Retail Invoice', value: 2},
            {label: 'Bill Of Supply', value: 3},
            {label: 'Other', value: 4},
        ]);

        const SalesOptions = ref([
            {label: 'Domestic', value: 1},
            {label: 'Export', value: 2},
        ]);

        const SupplyTypeOption = ref([
            {label: 'Goods', value: 1},
            {label: 'Services', value: 2},
        ]);

        const ReverseChargeOption = ref([
            {label: 'Yes', value: 1},
            {label: 'No', value: 2},
        ]);

        const PurchaseBillNoOption = ref([]);

        const companyOptions = ref([])
        axios.get('/api/administration/get-company-options').then((res) => {
            companyOptions.value = res.data.data
        });

        const reportSupplyType = ref([
            {label: 'B2B', value: 'B2B'},
            {label: 'SEZWP', value: 'SEZWP'},
            {label: 'SEZWOP', value: 'SEZWOP'},
            {label: 'EXPWP', value: 'EXPWP'},
            {label: 'EXPWOP', value: 'EXPWOP'},
            {label: 'DEXP', value: 'DEXP'},
        ]);

        const dateFormat = ref({
            date: true,
            delimiter: '/',
            datePattern: ['d', 'm', 'Y'],
        });

        const formatDates = ref({
            prInvoiceDate: null,
            prPurchaseDate: null,
        });

        const getPoInvoiceFormatDate = (date) => {
            formData.value.prInvoiceDate = forMatIndianDate(date);
        }

        const getPurchasePrFormatDate = (date) => {
            formData.value.prPurchaseDate = forMatIndianDate(date);
        }

        const blankFormData = {
            prSellToParty: null,
            prSellToDescription: null,
            prShipToParty: null,
            prShipToDescription: null,
            prInvoiceNo: null,
            prInvoiceDate: forMatIndianDate(new Date()),
            prInvoice: 1,
            prInvoiceType: null,
            prTaxType: 2,
            prGstInvoiceType: 1,
            prSales: 1,
            prSupplyType: 1,
            prReverseCharge: 2,
            prReportSupplyType: 'B2B',
            prPurchaseBillNo: null,
            prPurchaseDate: forMatIndianDate(new Date()),
            prReason: null,
            prRound: 0,
            prCompanyId: null,
            partyDetails: {
                PartyCode: null,
                PartyName: null,
                partyAddress: null,
                partyCountry: null,
                partyCountryName: null,
                partyState: null,
                partyStateName: null,
                partyStateCode: null,
                partyCity: null,
                partyCityName: null,
                partyFaxNo: null,
                partyEmailId: null,
                partyWebSite: null,
                partyPinCode: null,
                partyPhoneCountry: '+91',
                partyPhoneNo: null,
                partyTinVatNo: null,
                partyTinCstNo: null,
                partyEccNo: null,
                partyPanNo: null,
                partyGstinNo: null,
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
                buyerCountryName: null,
                buyerState: null,
                buyerStateName: null,
                buyerStateCode: null,
                buyerCity: null,
                buyerCityName: null,
                buyerFaxNo: null,
                buyerEmailId: null,
                buyerWebSite: null,
                buyerPinCode: null,
                buyerPhoneCountry: '+91',
                buyerPhoneNo: null,
                buyerTinVatNo: null,
                buyerTinCstNo: null,
                buyerEccNo: null,
                buyerPanNo: null,
                buyerGstinNo: null,
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
                consigneeCountryName: null,
                consigneeState: null,
                consigneeStateName: null,
                consigneeStateCode: null,
                consigneeCity: null,
                consigneeCityName: null,
                consigneeFaxNo: null,
                consigneeEmailId: null,
                consigneeWebSite: null,
                consigneePinCode: null,
                consigneePhoneCountry: '+91',
                consigneePhoneNo: null,
                consigneeTinVatNo: null,
                consigneeTinCstNo: null,
                consigneeEccNo: null,
                consigneePanNo: null,
                consigneeGstinNo: null,
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
                transporter: null,
                vehicalNo: null,
                lrNumber: null,
                lrDate: null,
                dateIssueInvoice: null,
                timeIssueInvoice: null,
                dateRemovalGood: null,
                timeRemovalGood: null,
                narration: null,
                note: null,
                exportReference: null,
                otherReference: null,
                preCarriageBy: null,
                vessel: null,
                portOfDischarge: null,
                placeOfReceipt: null,
                placeOfLoading: null,
                finalDestination: null,
            }
        }

        const formData = ref(JSON.parse(JSON.stringify(blankFormData)));

        const resetFormData = () => {
            formData.value = JSON.parse(JSON.stringify(blankFormData));
        }

        const getPartyDetails = async (id) => {
            showOverlayLoading.value = true
            await axios.get(`/api/party/edit/${id}`).then((res) => {
                formData.value.prSellToDescription = res.data.data.partyName
                formData.value.partyDetails.PartyCode = res.data.data._id
                formData.value.partyDetails.PartyName = res.data.data.partyName
                formData.value.partyDetails.partyAddress = res.data.data?.partyDetails?.partyAddress ?? null
                formData.value.partyDetails.partyCountry = res.data.data?.partyDetails?.partyCountry?.value ?? null
                formData.value.partyDetails.partyCountryName = res.data.data?.partyDetails?.partyCountry?.label ?? null
                formData.value.partyDetails.partyState = res.data.data?.partyDetails?.partyState?.value ?? null
                formData.value.partyDetails.partyStateName = res.data.data?.partyDetails?.partyState?.label ?? null
                formData.value.partyDetails.partyCity = res.data.data?.partyDetails?.partyCity?.value ?? null
                formData.value.partyDetails.partyCityName = res.data.data?.partyDetails?.partyCity?.label ?? null
                formData.value.partyDetails.partyFaxNo = res.data.data?.partyDetails?.partyFaxNo ?? null
                formData.value.partyDetails.partyEmailId = res.data.data?.partyDetails?.partyEmilId ?? null
                formData.value.partyDetails.partyWebSite = res.data.data?.partyDetails?.partyWebSite ?? null
                formData.value.partyDetails.partyPinCode = res.data.data?.partyAddress?.partyPinCode ?? null
                formData.value.partyDetails.partyPhoneCountry = res.data.data?.partyDetails?.partyCountryCode ?? null
                formData.value.partyDetails.partyPhoneNo = res.data.data?.partyDetails?.partyPhoneNo ?? null
                formData.value.partyDetails.partyTinVatNo = res.data.data?.taxDetails?.tinVatNo ?? null
                formData.value.partyDetails.partyTinCstNo = res.data.data?.taxDetails?.tinCstNo ?? null
                formData.value.partyDetails.partyEccNo = res.data.data?.taxDetails?.eccNo ?? null
                formData.value.partyDetails.partyPanNo = res.data.data?.taxDetails?.panNo ?? null
                formData.value.partyDetails.partyGstinNo = res.data.data?.taxDetails?.gstin ?? null
            });
            await axios.get(`/api/state-master/${formData.value.partyDetails.partyState}`).then((stateRes) => {
                formData.value.partyDetails.partyStateCode = stateRes.data.data.stateCode
            });
            showOverlayLoading.value = false
        }

        const getShipPartyDetails = async (id) => {
            showOverlayLoading.value = true
            await axios.get(`/api/party/edit/${id}`).then((res) => {
                formData.value.prShipToDescription = res.data.data.partyName
                formData.value.buyerDetails.buyerCode = res.data.data._id
                formData.value.buyerDetails.buyerName = res.data.data.partyName
                formData.value.buyerDetails.buyerAddress = res.data.data?.partyDetails?.partyAddress ?? null
                formData.value.buyerDetails.buyerCountry = res.data.data?.partyDetails?.partyCountry?.value ?? null
                formData.value.buyerDetails.buyerCountryName = res.data.data?.partyDetails?.partyCountry?.label ?? null
                formData.value.buyerDetails.buyerState = res.data.data?.partyDetails?.partyState?.value ?? null
                formData.value.buyerDetails.buyerStateName = res.data.data?.partyDetails?.partyState?.label ?? null
                formData.value.buyerDetails.buyerCity = res.data.data?.partyDetails?.partyCity?.value ?? null
                formData.value.buyerDetails.buyerCityName = res.data.data?.partyDetails?.partyCity?.label ?? null
                formData.value.buyerDetails.buyerFaxNo = res.data.data?.partyDetails?.partyFaxNo ?? null
                formData.value.buyerDetails.buyerEmailId = res.data.data?.partyDetails?.partyEmilId ?? null
                formData.value.buyerDetails.buyerWebSite = res.data.data?.partyDetails?.partyWebSite ?? null
                formData.value.buyerDetails.buyerPinCode = res.data.data?.partyAddress?.partyPinCode ?? null
                formData.value.buyerDetails.buyerPhoneCountry = res.data.data?.partyDetails?.partyCountryCode ?? null
                formData.value.buyerDetails.buyerPhoneNo = res.data.data?.partyDetails?.partyPhoneNo ?? null
                formData.value.buyerDetails.buyerTinVatNo = res.data.data?.taxDetails?.tinVatNo ?? null
                formData.value.buyerDetails.buyerTinCstNo = res.data.data?.taxDetails?.tinCstNo ?? null
                formData.value.buyerDetails.buyerEccNo = res.data.data?.taxDetails?.eccNo ?? null
                formData.value.buyerDetails.buyerPanNo = res.data.data?.taxDetails?.panNo ?? null
                formData.value.buyerDetails.buyerGstinNo = res.data.data?.taxDetails?.gstin ?? null
            });
            await axios.get(`/api/state-master/${formData.value.buyerDetails.buyerState}`).then((stateRes) => {
                formData.value.buyerDetails.buyerStateCode = stateRes.data.data.stateCode
            });
            showOverlayLoading.value = false
        }

        const saveFormData = async () => {
            await store.dispatch('purchase-store-module/addPurchaseReturn', formData.value).then((res) => {
                if (res.status === 200) {
                    toast({
                        component: ToastificationContent,
                        position: 'top-right',
                        props: {
                            title: 'Purchase Return Added',
                            icon: 'CheckSquareIcon',
                            variant: 'success',
                            text: `You have successfully Added Purchase Return.`,
                        },
                    });
                    router.push({
                        name: 'edit-purchase-return',
                        params: {
                            id: res.data.data._id
                        }
                    });
                } else {
                    toast({
                        component: ToastificationContent,
                        position: 'top-right',
                        props: {
                            title: 'Error',
                            icon: 'AlertCircleIcon',
                            variant: 'danger',
                            text: 'Something went wrong!',
                        },
                    });
                }
            }).catch(() => {
                toast({
                    component: ToastificationContent,
                    position: 'top-right',
                    props: {
                        title: 'Error',
                        icon: 'AlertCircleIcon',
                        variant: 'danger',
                        text: 'Internal server error.',
                    },
                });
            });
        }

        const {refFormObserver, getValidationState, resetForm} = formValidation(resetFormData);

        return {
            showOverlayLoading,
            //DropDown
            SellPartyOptions,
            InvoiceOptions,
            InvoiceTypeOptions,
            TextTypeOptions,
            GstInvoiceTypeOptions,
            SalesOptions,
            SupplyTypeOption,
            ReverseChargeOption,
            PurchaseBillNoOption,
            companyOptions,
            reportSupplyType,

            formData,
            saveFormData,
            getValidationState,
            resetForm,
            refFormObserver,
            resetFormData,
            required,

            getPartyDetails,
            getShipPartyDetails,
            getPurchasePrFormatDate,
            getPoInvoiceFormatDate,
            dateFormat,
            formatDates
        }
    }
}
</script>
