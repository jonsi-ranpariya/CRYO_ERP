<template>
    <div>
        <b-card-code>
            <validation-observer #default="{ handleSubmit }">
                <b-form @submit.prevent="handleSubmit(saveFormData)">
                    <b-row>
                        <b-col md="12">
                            <h5>Vendor Details</h5>
                            <hr>
                        </b-col>
                        <b-col md="6">
                            <validation-provider
                                #default="validationContext"
                                name="Vendor"
                                rules="required"
                            >
                                <b-form-group
                                    label="Vendor"
                                    label-for="poVendorCode"
                                    :state="getValidationState(validationContext)"
                                >
                                    <v-select
                                        placeholder="Select Vendor"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="vendorOptions"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        input-id="poVendorCode"
                                        v-model="formData.poVendorCode"
                                        :state="getValidationState(validationContext)"
                                        @input="getQuotationVendorDetails($event)"
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
                                name="Vendor Name"
                                rules="required"
                            >
                                <b-form-group
                                    label="Vendor Name"
                                    label-for="poVendorName"
                                >
                                    <b-form-input
                                        id="poVendorName"
                                        v-model="formData.poVendorName"
                                        :state="getValidationState(validationContext)"
                                        readonly
                                    />
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col md="3">
                            <validation-provider
                                #default="validationContext"
                                name="P.O.No."
                                rules=""
                            >
                                <b-form-group
                                    label="P.O.No."
                                    label-for="poNumber"
                                >
                                    <b-form-input
                                        id="poNumber"
                                        v-model="formData.poNumber"
                                        :state="getValidationState(validationContext)"
                                        readonly
                                    />
                                </b-form-group>
                            </validation-provider>
                        </b-col>
                        <b-col md="3">
                            <validation-provider
                                #default="validationContext"
                                name="P.O. Date"
                                rules=""
                            >
                                <b-form-group
                                    label="P.O. Date"
                                    label-for="poDate"
                                    :state="getValidationState(validationContext)"
                                >
                                    <b-input-group>
                                        <cleave
                                            id="poDate"
                                            v-model="formData.poDate"
                                            class="form-control"
                                            :raw="false"
                                            :options="dateFormat"
                                            placeholder="DD/MM/YYYY"
                                            show-decade-nav
                                        />
                                        <b-input-group-append>
                                            <b-form-datepicker
                                                v-model="formatDates.poDate"
                                                button-only
                                                @input="getPoFormateDate($event)"
                                                show-decade-nav
                                                size="sm"
                                                nav-button-variant="primary"
                                                disabled
                                            />
                                        </b-input-group-append>
                                    </b-input-group>
                                </b-form-group>
                            </validation-provider>
                        </b-col>
                        <b-col md="3">
                            <validation-provider
                                #default="validationContext"
                                name="Reference No"
                                rules=""
                            >
                                <b-form-group
                                    label="Ref."
                                    label-for="poRefId"
                                    :state="getValidationState(validationContext)"
                                >
                                    <v-select
                                        v-model="formData.poRefId"
                                        placeholder="Select No"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="ReferenceNoOptions"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        input-id="poRefId"
                                        @input="getPqReferenceNo($event)"
                                        :state="getValidationState(validationContext)"
                                    />
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                        </b-col>
                        <b-col md="3">
                            <b-form-group
                                label="Quotation No."
                                label-for="poQtnNo"
                            >
                                <v-select
                                    v-model="formData.poQtnNo"
                                    placeholder="Select No"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="quotationNoOptions"
                                    :reduce="val => val.value"
                                    :clearable="false"
                                    input-id="poQtnNo"
                                />
                            </b-form-group>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col md="3">
                            <b-form-group
                                label="Amd. No."
                                label-for="poAmdNo"
                            >
                                <b-form-input
                                    id="poAmdNo"
                                    v-model="formData.poAmdNo"
                                />
                            </b-form-group>
                        </b-col>
                        <b-col md="3">
                            <b-form-group
                                label="Amd. Date"
                                label-for="poAmdDate"
                            >
                                <b-input-group>
                                    <cleave
                                        id="poAmdDate"
                                        v-model="formData.poAmdDate"
                                        class="form-control"
                                        :raw="false"
                                        :options="dateFormat"
                                        placeholder="DD/MM/YYYY"
                                        show-decade-nav
                                    />
                                    <b-input-group-append>
                                        <b-form-datepicker
                                            v-model="formatDates.poAmdDate"
                                            button-only
                                            @input="getPoAmdChallanFormateDate($event)"
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
                                label="Reference No"
                                label-for="refNo"
                            >
                                <b-form-input
                                    id="refNo"
                                    v-model="formData.refNo"
                                />
                            </b-form-group>
                        </b-col>
                        <b-col md="3">
                            <b-form-group
                                label="Quotation No"
                                label-for="QuotationNo"
                            >
                                <b-form-input
                                    id="QuotationNo"
                                    v-model="formData.QuotationNo"
                                />
                            </b-form-group>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col md="3">
                            <b-form-group
                                label="Status"
                                label-for="poStatus"
                            >
                                <v-select
                                    v-model="formData.poStatus"
                                    placeholder="Select Status"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="statusOptions"
                                    :reduce="val => val.value"
                                    :clearable="false"
                                    input-id="poStatus"
                                    disabled
                                />
                            </b-form-group>
                        </b-col>
                        <b-col md="3">
                            <b-form-group
                                label="Currency"
                                label-for="poCurrency"
                            >
                                <v-select
                                    v-model="formData.poCurrency"
                                    placeholder="Select Currency"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="currencyOptions"
                                    :reduce="val => val.value"
                                    :clearable="false"
                                    input-id="poCurrency"
                                    @input="getCurrency($event)"
                                />
                            </b-form-group>
                        </b-col>
                        <b-col md="3">
                            <b-form-group
                                label="Quotation Date"
                                label-for="poQtnDate"
                            >
                                <b-input-group>
                                    <b-input-group-prepend>
                                        <b-form-datepicker
                                            v-model="formatDates.poQtnDate"
                                            button-only
                                            @input="getPoQtnFormateDate($event)"
                                            show-decade-nav
                                            size="sm"
                                            nav-button-variant="primary"
                                        />
                                    </b-input-group-prepend>
                                    <cleave
                                        id="poQtnDate"
                                        v-model="formData.poQtnDate"
                                        class="form-control"
                                        :raw="false"
                                        :options="dateFormat"
                                        placeholder="DD/MM/YYYY"
                                        show-decade-nav
                                    />
                                </b-input-group>
                            </b-form-group>
                        </b-col>
                        <b-col md="3">
                            <b-form-group
                                label="Conversion Rate"
                                label-for="poConversionRate"
                            >
                                <b-form-input
                                    id="poConversionRate"
                                    v-model="formData.poConversionRate"
                                />
                            </b-form-group>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col md="6">
                            <b-form-group
                                label="Purchase Type"
                                label-for="purchaseType"
                            >
                                <v-select
                                    v-model="formData.purchaseType"
                                    placeholder="Select Type"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="purchaseTypeOptions"
                                    :reduce="val => val.value"
                                    :clearable="false"
                                    input-id="poCurrency"
                                />
                            </b-form-group>
                            <b-form-group
                                label="Kind Attn."
                                label-for="poKindAttn"
                            >
                                <v-select
                                    placeholder="Select KindAttn"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :reduce="val => val.value"
                                    :options="kindOption"
                                    :clearable="false"
                                    input-id="poKindAttn"
                                    v-model="formData.poKindAttn"
                                />
                            </b-form-group>
                            <b-form-group
                                label="Mobile No."
                                label-for="poPhoneCountry"
                            >
                                <b-input-group>
                                    <b-form-input
                                        id="party-work-phone"
                                        v-model="formData.poMobileNo"
                                    />
                                </b-input-group>
                            </b-form-group>
                            <b-form-group
                                label="E-mail ID"
                                label-for="poMobileNo"
                            >
                                <b-form-input
                                    v-model="formData.poEmailId"
                                    id="purchaseOrderEmailId"
                                />
                            </b-form-group>
                        </b-col>
                        <b-col md="6">
                            <b-form-group
                                label="Status"
                                label-for="poStage"
                            >
                                <v-select
                                    placeholder="Select Stage"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :reduce="val => val.value"
                                    :options="stageOption"
                                    :clearable="false"
                                    input-id="poStage"
                                    v-model="formData.poStage"
                                />
                            </b-form-group>
                            <b-form-group
                                label="Review Date"
                                label-for="poReviewDate"
                            >
                                <b-input-group>
                                    <b-input-group-prepend is-text>
                                        <b-form-checkbox
                                            plain
                                            name="checkbox-input"
                                            type="checkbox"
                                            v-model="formData.Selected"

                                        />
                                    </b-input-group-prepend>
                                    <b-input-group-prepend>
                                        <b-form-datepicker
                                            v-model="formatDates.poReviewDate"
                                            button-only
                                            @input="getPoReviewFormateDate($event)"
                                            show-decade-nav
                                            size="sm"
                                            nav-button-variant="primary"
                                            v-bind:disabled="!formData.Selected"
                                        />
                                    </b-input-group-prepend>
                                    <cleave
                                        id="poReviewDate"
                                        v-model="formData.poReviewDate"
                                        class="form-control"
                                        :raw="false"
                                        :options="dateFormat"
                                        placeholder="DD/MM/YYYY"
                                        show-decade-nav
                                        v-bind:disabled="!formData.Selected"
                                    />
                                </b-input-group>
                            </b-form-group>
                            <b-form-group
                                label="Supply Type"
                                label-for="poSupplyType"
                            >
                                <v-select
                                    placeholder="Select Supply"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :reduce="val => val.value"
                                    :options="supplyOption"
                                    :clearable="false"
                                    input-id="poSupplyType"
                                    v-model="formData.poSupplyType"
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
                                        v-model="formData.poRound"
                                        value="0"
                                    >
                                        None
                                    </b-form-radio>
                                    <b-form-radio
                                        name="selectRound"
                                        v-model="formData.poRound"
                                        value="1"
                                    >
                                        Rounding
                                    </b-form-radio>
                                    <b-form-radio
                                        name="selectRound"
                                        v-model="formData.poRound"
                                        value="2"
                                    >
                                        Rounding All
                                    </b-form-radio>
                                </div>
                            </b-form-group>
                        </b-col>
                        <!-- Button-->
                        <b-col md="12">
                            <hr>
                            <b-button
                                class="float-right"
                                variant="primary"
                                type="submit"
                            >
                                Save
                            </b-button>
                        </b-col>
                    </b-row>
                </b-form>
            </validation-observer>
        </b-card-code>

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
    BFormCheckbox,
    BInputGroupPrepend,
    BInputGroup,
    BButton,
    BInputGroupAppend,
    BFormRadio
} from 'bootstrap-vue'
import BCardCode from "@core/components/b-card-code/BCardCode";
import {ValidationObserver, ValidationProvider} from 'vee-validate'
import {ref, onUnmounted} from "@vue/composition-api";
import formValidation from '@core/comp-functions/forms/form-validation'
import {required} from '@validations'
import axios from '@axios'
import vSelect from 'vue-select'
import countryCode from '@/@fake-db/data/other/country-code'
import router from "@/router";
import {getTcTodayDate} from "@core/utils/utils";
import store from '@/store'
import purchaseStoreModule from "../purchaseStoreModule";
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
import {useToast} from 'vue-toastification/composition'
import {forMatIndianDate} from "../../../@core/utils/utils";
import Cleave from 'vue-cleave-component'
import {getUserData} from "../../../auth/utils";
import moment from "moment/moment";
import {getTcTodayDateTime} from "@core/utils/utils";

export default {
    components: {
        BCardCode,
        ValidationObserver,
        ValidationProvider,
        BForm,
        BRow,
        BCol,
        BFormGroup,
        BFormInput,
        BFormInvalidFeedback,
        vSelect,
        BFormDatepicker,
        BFormCheckbox,
        BInputGroupPrepend,
        BInputGroup,
        BButton,
        Cleave,
        BInputGroupAppend,
        BFormRadio
    },
    computed: {
        countryCode: () => countryCode
    },
    setup() {
        const ITEMADDON_APP_STORE_MODULE_NAME = 'purchase-store-module'
        if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, purchaseStoreModule)
        onUnmounted(() => {
            if (store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.unregisterModule(ITEMADDON_APP_STORE_MODULE_NAME)
        })

        const toast = useToast()

        const vendorOptions = ref([])
        //get-purchase-quotation-vendor-options
        //get-purchase-quotation-vendor-options
        axios.get('/api/party/get-master-without-customer-options').then(res => {
            vendorOptions.value = res.data.data
        })

        const quotationNoOptions = ref([])
        axios.get('/api/new/get-purchase-quotation-number').then(res => {
            quotationNoOptions.value = res.data.data
        })

        const ReferenceNoOptions = ref([])
        axios.get('/api/new/get-purchase-quotation-reference-number').then(res => {
            ReferenceNoOptions.value = res.data.data
        })

        const getPqReferenceNo = async (id) => {
            await axios.get(`/api/purchase-quotation/${id}`).then(res => {
                formData.value.refNo = res.data.data?.referenceNumber ?? null
                formData.value.poQtnNo = res.data.data?.vendorQtnNo ?? null
                formData.value.poQtnDate = res.data.data?.vendorQtnDate ?? null
                formData.value.QuotationNo = res.data.data?.vendorQtnNo ?? null
            })
        }

        const kindOption = ref([])

        const dateFormat = ref({
            date: true,
            delimiter: '/',
            datePattern: ['d', 'm', 'Y'],
        })

        const formatDates = ref({
            poDate: null,
            poAmdDate: null,
            poQtnDate: null,
            poReviewDate: null,
        })

        const getPoFormateDate = (date) => {
            formData.value.poDate = forMatIndianDate(date)
        }
        const getPoAmdChallanFormateDate = (date) => {
            formData.value.poAmdDate = forMatIndianDate(date)
        }
        const getPoQtnFormateDate = (date) => {
            formData.value.poQtnDate = forMatIndianDate(date)
        }
        const getPoReviewFormateDate = (date) => {
            formData.value.poReviewDate = forMatIndianDate(date)
        }
        const purchaseTypeOptions = ref([
            {label: 'General', value: 1},
            {label: 'Purchase Order', value: 2},
            {label: 'Import', value: 3},
            {label: 'Labour Service', value: 4},
            {label: 'Service Order', value: 5},
        ])
        const statusOptions = ref([
            {label: 'Pending', value: 1},
            {label: 'Canceled', value: 2},
            {label: 'Completed', value: 3},
        ])

        const stageOption = ref([
            {label: 'Prepared', value: 'Prepared'},
            {label: 'Approved', value: 'Approved'},
            {label: 'Redo', value: 'Redo'},
            {label: 'Hold', value: 'Hold'}
        ])

        const supplyOption = ref([
            {label: 'Intrastate', value: 1},
            {label: 'Interstate', value: 2},
            {label: 'Export', value: 3},
        ])


        const currencyOptions = ref([])
        axios.get('/api/get-currency-options').then(res => {
            currencyOptions.value = res.data.data
        })

        const getCurrency = async (id) => {
            await axios.get(`/api/currency-master/${id}`).then(res => {
                formData.value.poConversionRate = res.data.data.currencyRate
            })
        }
        const currentUserData = ref(getUserData())

        const blankFormData = {
            poVendorId: null,
            poVendorCode: null,
            poVendorName: null,
            poStatus: 1,
            poCurrency: null,
            poNumber: null,
            poDate: forMatIndianDate(getTcTodayDate()),
            poConversionRate: null,
            poAmdNo: 0,
            poAmdDate: forMatIndianDate(getTcTodayDate()),
            poQtnNo: null,
            poQtnDate: forMatIndianDate(),
            purchaseType: 1,
            poKindAttn: null,
            poPhoneCountry: null,
            poMobileNo: null,
            poEmailId: null,
            Selected: null,
            poRefId: null,
            refNo:null,
            QuotationNo:null,
            poStage: 'Prepared',
            poReviewDate: forMatIndianDate(),
            poSupplyType: 1,
            poRound:0,
            itemIds: [],
            vendorDetails: {
                vendorCode: null,
                vendorName: null,
                vendorAddress: null,
                vendorArea:null,
                vendorCountry: null,
                vendorState: null,
                vendorCity: null,
                vendorFaxNo: null,
                vendorEmailId: null,
                vendorGstin: null,
                vendorWebSite: null,
                vendorPinCode: null,
                vendorPhoneCountry: null,
                vendorPhoneNo: null,
            },
            headerFooterDetails: {
                header: null,
                headerDescription: null,
                footer: null,
                footerDescription: null,
            },
            noteDetails: {
                orderNote: null,
            },
            workAddressDetails:{
                partyAddress: null,
                partyArea: null,
                partyCity: null,
                partyState: null,
                partyCountry: null,
                partyPinCode:null,
                partyPhoneNoCode:null,
                partyPhoneNo:null,
                partyFaxNo:null,
                partyEmilId:null,
                partyWebsite:null,
            },
            loginDetails: {
                createdBy: currentUserData.value.first_name + ' ' + currentUserData.value.last_name,
                createdDateTime: getTcTodayDateTime(),
                modifiedBy: null,
                modifiedDateTime: null,
                approvedBy: null,
                approvedDateTime: null,
                stage: 'Prepared',
            }
        }

        const formData = ref(JSON.parse(JSON.stringify(blankFormData)))

        const resetFormData = () => {
            formData.value = JSON.parse(JSON.stringify(blankFormData))
        }

        const CurrentPartyDetailData = ref([])

        const getQuotationVendorDetails = async (id) => {
            await axios.get(`/api/party/edit/${id}`).then(res => {
                CurrentPartyDetailData.value = res.data.data
                formData.value.poVendorId = CurrentPartyDetailData.value._id
                formData.value.poVendorName = CurrentPartyDetailData.value.partyName
                // formData.value.poStatus = CurrentPartyDetailData.value.partyTypeStatus
                formData.value.poCurrency = CurrentPartyDetailData.value.partyCurrencyType
                formData.value.poPhoneCountry = CurrentPartyDetailData.value.partyDetails.partyCountryCode
                formData.value.poMobileNo = CurrentPartyDetailData.value.partyDetails.partyPhoneNo
                formData.value.poEmailId = CurrentPartyDetailData.value.partyDetails?.partyEmilId
                formData.value.poSupplyType = CurrentPartyDetailData.value.partySupplyType
                formData.value.vendorDetails.vendorCode = CurrentPartyDetailData.value._id
                formData.value.vendorDetails.vendorName = CurrentPartyDetailData.value.partyName
                formData.value.vendorDetails.vendorAddress = CurrentPartyDetailData.value.partyDetails.partyAddress
                formData.value.vendorDetails.vendorArea = CurrentPartyDetailData.value.partyDetails.partyArea
                formData.value.vendorDetails.vendorCountry = CurrentPartyDetailData.value.partyDetails.partyCountry
                formData.value.vendorDetails.vendorState = CurrentPartyDetailData.value.partyDetails.partyState
                formData.value.vendorDetails.vendorCity = CurrentPartyDetailData.value.partyDetails.partyCity
                formData.value.vendorDetails.vendorFaxNo = CurrentPartyDetailData.value.partyDetails.partyFaxNo
                formData.value.vendorDetails.vendorEmailId = CurrentPartyDetailData.value.partyDetails.partyEmilId
                formData.value.vendorDetails.vendorGstin = CurrentPartyDetailData.value.taxDetails.gstin
                formData.value.vendorDetails.vendorWebSite = CurrentPartyDetailData.value.partyDetails.partyWebsite
                formData.value.vendorDetails.vendorPinCode = CurrentPartyDetailData.value.partyDetails.partyPinCode
                formData.value.vendorDetails.vendorPhoneCountry = CurrentPartyDetailData.value.partyDetails.partyCountryCode
                formData.value.vendorDetails.vendorPhoneNo = CurrentPartyDetailData.value.partyDetails.partyPhoneNo
                formData.value.workAddressDetails.partyAddress = CurrentPartyDetailData.value?.partyAddress?.partyAddress ?? null
                formData.value.workAddressDetails.partyArea = CurrentPartyDetailData.value?.partyAddress?.partyArea ?? null
                formData.value.workAddressDetails.partyCity = CurrentPartyDetailData.value?.partyAddress?.partyCity ?? null
                formData.value.workAddressDetails.partyState = CurrentPartyDetailData.value?.partyAddress?.partyState ?? null
                formData.value.workAddressDetails.partyCountry = CurrentPartyDetailData.value?.partyAddress?.partyCountry ?? null
                formData.value.workAddressDetails.partyPinCode = CurrentPartyDetailData.value?.partyAddress?.partyPinCode ?? null
                formData.value.workAddressDetails.partyPhoneNoCode = CurrentPartyDetailData.value?.partyAddress?.partyPhoneNoCode ?? null
                formData.value.workAddressDetails.partyPhoneNo = CurrentPartyDetailData.value?.partyAddress?.partyPhoneNo ?? null
                formData.value.workAddressDetails.partyFaxNo = CurrentPartyDetailData.value?.partyAddress?.partyFaxNo ?? null
                formData.value.workAddressDetails.partyEmilId = CurrentPartyDetailData.value?.partyAddress?.partyEmilId ?? null
                formData.value.workAddressDetails.partyWebsite = CurrentPartyDetailData.value?.partyAddress?.partyWebsite ?? null
            })
            await axios.get(`/api/new/get-reference-number-by-party/${formData.value.poVendorId}`).then(res => {
                ReferenceNoOptions.value = res.data.data
            })

            formData.value.kindAttnId = null

            await axios.get(`/api/party/get-party-contacts-options/${id}`).then(res => {
                kindOption.value = res.data.data
            })

            if (CurrentPartyDetailData.value.partyCurrencyType) {

                formData.value.poCurrency = CurrentPartyDetailData.value.partyCurrencyType

                axios.get(`/api/currency-master/${CurrentPartyDetailData.value.partyCurrencyType}`).then(Curres => {

                    if (Curres.data.data) {

                        formData.value.poConversionRate = Curres.data.data.currencyRate
                    }
                })
            }
        }

        const saveFormData = async () => {
            await store.dispatch('purchase-store-module/addPurchaseOrder', formData.value).then(res => {
                if (res.status === 200) {
                    toast({
                        component: ToastificationContent,
                        position: 'top-right',
                        props: {
                            title: 'Purchase Order Added',
                            icon: 'CheckSquareIcon',
                            variant: 'success',
                            text: `You have successfully Added Purchase Order.`,
                        },
                    })
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
                    })
                }
                router.push({
                    name: 'edit-purchase-order',
                    params: {
                        id: res.data.data._id
                    }
                })
            })
        }

        const {refFormObserver, getValidationState, resetForm} = formValidation(resetFormData)
        return {
            getQuotationVendorDetails,
            formData,
            saveFormData,
            refFormObserver,
            getValidationState,
            resetForm,
            resetFormData,
            required,
            kindOption,
            vendorOptions,
            statusOptions,
            currencyOptions,
            getCurrency,
            stageOption,
            supplyOption,
            dateFormat,
            formatDates,
            getPoFormateDate,
            getPoAmdChallanFormateDate,
            getPoQtnFormateDate,
            getPoReviewFormateDate,
            purchaseTypeOptions,
            quotationNoOptions,
            getPqReferenceNo,
            CurrentPartyDetailData,
            ReferenceNoOptions
        }
    }
}
</script>
