<template>
    <div>
        <b-overlay
            :show="showOverlayLoading"
            rounded="sm"
        >
            <b-card-code>
                <validation-observer ref="simpleRules">
                    <b-form>
                        <b-row>
                            <b-col md="12">
                                <validation-provider
                                    #default="{ errors }"
                                    name="Company"
                                    rules="required"
                                >
                                    <b-form-group
                                        label="Company"
                                        label-for="company"
                                        :state="errors.length > 0 ? false:null"
                                    >
                                        <v-select
                                            placeholder="Select company"
                                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                            :options="companyOptions"
                                            :reduce="val => val.value"
                                            :clearable="false"
                                            input-id="company"
                                            v-model="SalesReturnFormData.manualCompanyId"
                                        />
                                        <small class="text-danger">{{ errors[0] }}</small>
                                    </b-form-group>
                                </validation-provider>
                            </b-col>
                            <b-col md="2">
                                <validation-provider
                                    #default="{ errors }"
                                    name="Sales Return No"
                                    rules="required"
                                >
                                    <b-form-group
                                        label="Sales Return No"
                                        label-for="salesReturnNo"
                                    >
                                        <b-form-input
                                            id="salesReturnNo"
                                            v-model="SalesReturnFormData.salesReturnNo"
                                            :state="errors.length > 0 ? false:null"
                                        />
                                        <small class="text-danger">{{ errors[0] }}</small>
                                    </b-form-group>
                                </validation-provider>
                            </b-col>
                            <b-col md="4">
                                <validation-provider
                                    #default="{ errors }"
                                    name="Customer"
                                    rules="required"
                                >
                                    <b-form-group
                                        label="Customer"
                                        label-for="salesReturnCustomerID"
                                        :state="errors.length > 0 ? false:null"
                                    >
                                        <v-select
                                            v-model="SalesReturnFormData.salesReturnCustomerID"
                                            placeholder="Select Customer"
                                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                            :options="PartyListOption"
                                            :reduce="val => val.value"
                                            :clearable="false"
                                            @input="getPartyCode($event)"
                                            input-id="salesReturnCustomerID"
                                            :state="errors.length > 0 ? false:null"
                                        />
                                        <small class="text-danger">{{ errors[0] }}</small>
                                    </b-form-group>
                                </validation-provider>
                            </b-col>

                            <b-col md="2">
                                <b-form-group
                                    label="Customer Code"
                                    label-for="salesReturnCustomerCode"
                                >
                                    <b-form-input
                                        id="salesReturnCustomerCode"
                                        v-model="SalesReturnFormData.salesReturnCustomerCode"
                                        readonly
                                    />
                                </b-form-group>
                            </b-col>

                            <b-col md="4">
                                <b-form-group
                                    label="Customer Name"
                                    label-for="salesReturnCustomerName"
                                >
                                    <b-form-input
                                        id="salesReturnCustomerName"
                                        v-model="SalesReturnFormData.salesReturnCustomerName"
                                        readonly
                                    />
                                </b-form-group>
                            </b-col>

                            <b-col md="3">
                                <b-form-group
                                    label="Sales Return Date"
                                    label-for="salesReturnDate"
                                >
                                    <!--<b-form-datepicker
                                        id="salesReturnDate"
                                        :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }"
                                        locale="in"
                                        v-model="SalesReturnFormData.salesReturnDate"
                                        class="mb-1"
                                    />-->
                                    <b-input-group>
                                        <cleave
                                            id="salesReturnDate"
                                            v-model="SalesReturnFormData.salesReturnDate"
                                            class="form-control"
                                            :raw="false"
                                            :options="dateFormat"
                                            placeholder="DD/MM/YYYY"
                                            show-decade-nav
                                        />
                                        <b-input-group-append>
                                            <b-form-datepicker
                                                v-model="formatDates.salesReturnDate"
                                                button-only
                                                @input="getSalesReturnFormatDate($event)"
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
                                    label="Invoice No"
                                    label-for="salesReturnInvoiceId"
                                >
                                    <v-select
                                        v-model="SalesReturnFormData.salesReturnInvoiceId"
                                        placeholder="Select Invoice"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="InvoiceListOption"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        input-id="salesReturnInvoiceId"
                                        @input="getChallanInvoiceDetails($event)"
                                    />
                                </b-form-group>
                            </b-col>

                            <b-col md="3">
                                <b-form-group
                                    label="Invoice Date"
                                    label-for="salesReturnInvoiceDate"
                                >
                                    <!--<b-form-datepicker
                                        id="salesReturnInvoiceDate"
                                        :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }"
                                        locale="in"
                                        v-model="SalesReturnFormData.salesReturnInvoiceDate"
                                        class="mb-1"
                                    />-->

                                    <b-input-group>
                                        <cleave
                                            id="salesReturnInvoiceDate"
                                            v-model="SalesReturnFormData.salesReturnInvoiceDate"
                                            class="form-control"
                                            :raw="false"
                                            :options="dateFormat"
                                            placeholder="DD/MM/YYYY"
                                            show-decade-nav
                                        />
                                        <b-input-group-append>
                                            <b-form-datepicker
                                                v-model="formatDates.salesReturnInvoiceDate"
                                                button-only
                                                @input="getSalesReturnInvoiceFormatDate($event)"
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
                                    label="Manual Invoice No."
                                    label-for="manualInvoiceNumber"
                                >
                                    <b-form-input
                                        id="manualInvoiceNumber"
                                        v-model="SalesReturnFormData.manualInvoiceNumber"
                                    />
                                </b-form-group>
                            </b-col>

                            <b-col md="4">
                                <b-form-group
                                    label="SR Stage"
                                    label-for="salesReturnStage"
                                >
                                    <v-select
                                        v-model="SalesReturnFormData.salesReturnStage"
                                        placeholder="Select SR Stage"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="srStagesType"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        input-id="salesReturnStage"
                                    />
                                </b-form-group>
                            </b-col>

                            <b-col md="4">
                                <b-form-group
                                    label="Currency"
                                    label-for="salesReturnCurrency"
                                >
                                    <v-select
                                        placeholder="Select Currency"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="currencyOptions"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        input-id="salesReturnCurrency"
                                        v-model="SalesReturnFormData.salesReturnCurrency"
                                    />
                                </b-form-group>
                            </b-col>


                            <b-col md="4">
                                <b-form-group
                                    label="Conversion Rate"
                                    label-for="salesReturnConvRate"
                                >
                                    <b-form-input
                                        id="salesReturnConvRate"
                                        v-model="SalesReturnFormData.salesReturnConvRate"
                                    />
                                </b-form-group>
                            </b-col>

                            <b-col md="12">
                                <b-form-group
                                    label="Reason"
                                    label-for="salesReturnReason"
                                >
                                    <b-form-input
                                        id="salesReturnReason"
                                        v-model="SalesReturnFormData.salesReturnReason"
                                    />
                                </b-form-group>
                            </b-col>


                            <b-col md="12">

                                <div class="demo-inline-spacing mb-2">
                                    <b-form-radio
                                        v-model="SalesReturnFormData.salesReturnRounding"
                                        name="salesReturnRoundingAll"
                                        value="0"
                                    >
                                        None
                                    </b-form-radio>
                                    <b-form-radio
                                        v-model="SalesReturnFormData.salesReturnRounding"
                                        name="salesReturnRoundingAll"
                                        value="1"
                                    >
                                        Rounding
                                    </b-form-radio>
                                    <b-form-radio
                                        v-model="SalesReturnFormData.salesReturnRounding"
                                        name="salesReturnRoundingAll"
                                        value="2"
                                    >
                                        Rounding All
                                    </b-form-radio>
                                </div>

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
import BCardCode from '@core/components/b-card-code'
import {ValidationProvider, ValidationObserver} from 'vee-validate'
import {
    BRow,
    BCol,
    BFormGroup,
    BFormInput,
    BFormTextarea,
    BFormCheckbox,
    BFormRadio,
    BForm,
    BButton,
    BFormDatepicker,
    BInputGroup,
    BInputGroupPrepend,
    BInputGroupAppend,
    BOverlay
} from 'bootstrap-vue'
import {required} from '@validations'
import Ripple from 'vue-ripple-directive'
import vSelect from 'vue-select'
import store from '@/store'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
import {ref, onUnmounted} from '@vue/composition-api'
import salesStoreModule from '../salesStoreModule'
import axios from '@axios'
import {getUserData} from "../../../auth/utils";
import moment from 'moment'
import {forMatIndianDate} from "@core/utils/utils";
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
        BFormCheckbox,
        BFormRadio,
        BFormTextarea,
        BForm,
        BButton,
        BFormDatepicker,
        BInputGroup,
        BInputGroupPrepend,
        BInputGroupAppend,
        vSelect,
        BOverlay,
        Cleave
    },
    directives: {
        Ripple,
    },
    setup() {
        const SR_APP_STORE_MODULE_NAME = 'sales-return-module'
        // Register module
        if (!store.hasModule(SR_APP_STORE_MODULE_NAME)) store.registerModule(SR_APP_STORE_MODULE_NAME, salesStoreModule)
        // UnRegister on leave
        onUnmounted(() => {
            if (store.hasModule(SR_APP_STORE_MODULE_NAME)) store.unregisterModule(SR_APP_STORE_MODULE_NAME)
        })

        const todayDate = (new Date()).toISOString().split('T')[0]

        const showOverlayLoading = ref(false)

        const CurrentPartyDetailData = ref([])
        const CurrentUserData = ref(getUserData())

        const PartyDetailTabData = ref({
            partyDetailId: null,
            partyDetailCode: null,
            partyDetailName: null,
            partyDetailAddress: null,
            partyDetailCityId: null,
            partyDetailCity: null,
            partyDetailStateId: null,
            partyDetailState: null,
            partyDetailStateCode: null,
            partyDetailCountryID: null,
            partyDetailCountry: null,
            partyDetailFaxNo: null,
            partyDetailEmailId: null,
            partyDetailWebsite: null,
            partyDetailTinVatNO: null,
            partyDetailTinCstNO: null,
            partyDetailTinEccNO: null,
            partyDetailTinPanNO: null,
            partyDetailGstNo: null,
            partyDetailPinCode: null,
            partyDetailStdCode: null,
            partyDetailPhoneNo: null,
            partyDetailNarration: null,
            partyKindAttnId: null,
            partyKindAttnName: null,
            partyKindAttnEmail: null,
            partyKindAttnMobile: null,
        })

        const PartyListOption = ref([])

        const InvoiceListOption = ref([])

        const currencyOptions = ref([])

        const srStagesType = ref([
            {label: 'Prepared', value: 1},
            {label: 'Approved', value: 2}
        ]);

        axios.get('/api/party/get-master-options').then((res) => {
            PartyListOption.value = res.data.data
        });


        axios.get('/api/get-currency-options').then((res) => {
            currencyOptions.value = res.data.data
        });

        const companyOptions = ref([])
        axios.get('/api/administration/get-company-options').then(res => {
            companyOptions.value = res.data.data
        });

        const SalesReturnFormData = ref({
            id: null,
            salesReturnNo: null,
            salesReturnDate: forMatIndianDate(todayDate),
            salesReturnCurrency: null,
            salesReturnConvRate: null,
            salesReturnStage: 1,
            salesReturnRounding: '0',
            salesReturnRoundingAll: null,
            salesReturnCustomerID: null,
            salesReturnCustomerCode: null,
            salesReturnCustomerName: null,
            salesReturnInvoiceId: null,
            salesReturnInvoiceNo: null,
            salesReturnInvoiceDate: null,
            manualInvoiceNumber: null,
            salesReturnReason: null,
            manualCompanyId: null,
            customerDetail: PartyDetailTabData.value,
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
                consigneeCountryName: null,
                consigneeState: null,
                consigneeStateCode: null,
                consigneeStateName: null,
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
                dispatchCountryName: null,
                dispatchState: null,
                dispatchStateName: null,
                dispatchStateCode: null,
                dispatchCity: null,
                dispatchCityName: null,
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
            },
            loginDetail: ref({
                createdBy: CurrentUserData.value.first_name + ' ' + CurrentUserData.value.last_name,
                createdDateTime: moment(new Date()).format('DD/MM/YYYY HH:mm'),
                lastModifiedBy: null,
                modifiedDateTime: null,
                approvedBy: null,
                approveDateTime: null,
            }),
            salesReturnAmount: 0.00,
            salesReturnGrossAmount: 0.00,
        })


        const getPartyCode = async (val) => {
            showOverlayLoading.value = true;
            SalesReturnFormData.value.salesReturnInvoiceId = null
            SalesReturnFormData.value.salesReturnInvoiceNo = null
            SalesReturnFormData.value.salesReturnInvoiceDate = null
            await axios.get(`/api/party/edit/${val}`).then((res) => {
                CurrentPartyDetailData.value = res.data.data
                SalesReturnFormData.value.salesReturnCustomerCode = CurrentPartyDetailData.value.partyCode
                SalesReturnFormData.value.salesReturnCustomerName = CurrentPartyDetailData.value.partyName
                SalesReturnFormData.value.salesReturnCustomerID = val
                PartyDetailTabData.value.partyDetailId = val
                PartyDetailTabData.value.partyDetailCode = CurrentPartyDetailData.value.partyCode
                PartyDetailTabData.value.partyDetailName = CurrentPartyDetailData.value.partyName
                if (CurrentPartyDetailData.value.partyDetails) {
                    PartyDetailTabData.value.partyDetailAddress = CurrentPartyDetailData.value.partyDetails.partyAddress
                    if (CurrentPartyDetailData.value.partyDetails.partyCity) {
                        PartyDetailTabData.value.partyDetailCityId = CurrentPartyDetailData.value.partyDetails.partyCity.value
                        PartyDetailTabData.value.partyDetailCity = CurrentPartyDetailData.value.partyDetails.partyCity.label
                    }
                    if (CurrentPartyDetailData.value.partyDetails.partyState) {
                        PartyDetailTabData.value.partyDetailStateId = CurrentPartyDetailData.value.partyDetails.partyState.value
                        PartyDetailTabData.value.partyDetailState = CurrentPartyDetailData.value.partyDetails.partyState.label
                        axios.get(`/api/state-master/${CurrentPartyDetailData.value.partyDetails.partyState.value}`).then((stateResponse) => {
                            PartyDetailTabData.value.partyDetailStateCode = stateResponse.data.data.stateCode
                        });
                    }
                    if (CurrentPartyDetailData.value.partyDetails.partyCountry) {
                        PartyDetailTabData.value.partyDetailCountryID = CurrentPartyDetailData.value.partyDetails.partyCountry.value
                        PartyDetailTabData.value.partyDetailCountry = CurrentPartyDetailData.value.partyDetails.partyCountry.label
                    }
                    PartyDetailTabData.value.partyDetailFaxNo = CurrentPartyDetailData.value.partyDetails.partyFaxNo
                    PartyDetailTabData.value.partyDetailEmailId = CurrentPartyDetailData.value.partyDetails.partyEmilId
                    PartyDetailTabData.value.partyDetailWebsite = CurrentPartyDetailData.value.partyDetails.partyWebsite
                    PartyDetailTabData.value.partyDetailPinCode = CurrentPartyDetailData.value.partyDetails.partyPinCode
                    PartyDetailTabData.value.partyDetailStdCode = CurrentPartyDetailData.value.partyDetails.partyCountryCode
                    PartyDetailTabData.value.partyDetailPhoneNo = CurrentPartyDetailData.value.partyDetails.partyPhoneNo
                }

                if (CurrentPartyDetailData.value.taxDetails) {
                    PartyDetailTabData.value.partyDetailGstNo = CurrentPartyDetailData?.value.taxDetails.gstin
                    PartyDetailTabData.value.partyDetailTinVatNO = CurrentPartyDetailData?.value.taxDetails.tinVatNo
                    PartyDetailTabData.value.partyDetailTinCstNO = CurrentPartyDetailData?.value.taxDetails.tinCstNo
                    PartyDetailTabData.value.partyDetailTinEccNO = CurrentPartyDetailData?.value.taxDetails.eccNo
                    PartyDetailTabData.value.partyDetailTinPanNO = CurrentPartyDetailData?.value.taxDetails.panNo
                }

                if (CurrentPartyDetailData.value.partyCurrencyType) {
                    SalesReturnFormData.value.salesReturnCurrency = CurrentPartyDetailData.value.partyCurrencyType
                }

                if (CurrentPartyDetailData.value.partyCurrencyType) {
                    SalesReturnFormData.value.salesReturnCurrency = CurrentPartyDetailData.value.partyCurrencyType
                    axios.get(`/api/currency-master/${CurrentPartyDetailData.value.partyCurrencyType}`).then(Curres => {
                        if (Curres.data.data) {
                            SalesReturnFormData.value.salesReturnConvRate = Curres.data.data.currencyRate
                        }
                    })
                }
            });

            await axios.get(`/api/get-challan-invoice-from-party/${val}`).then((res) => {
                InvoiceListOption.value = res.data.data
            });

            showOverlayLoading.value = false;
        }

        const getChallanInvoiceDetails = async (id) => {
            showOverlayLoading.value = true;
            await axios.get(`/api/new-challan-and-invoice/${id}`).then((res) => {
                SalesReturnFormData.value.salesReturnInvoiceNo = res.data.data.invoiceNo
                SalesReturnFormData.value.salesReturnInvoiceDate = res.data.data.invoiceDate
            });
            showOverlayLoading.value = false;
        }

        const dateFormat = ref({
            date: true,
            delimiter: '/',
            datePattern: ['d', 'm', 'Y'],
        });

        const formatDates = ref({
            salesReturnDate: null,
            salesReturnInvoiceDate: null,
        })

        const getSalesReturnFormatDate = (date) => {
            SalesReturnFormData.value.salesReturnDate = forMatIndianDate(date)
        }

        const getSalesReturnInvoiceFormatDate = (date) => {
            SalesReturnFormData.value.salesReturnInvoiceDate = forMatIndianDate(date)
        }

        return {
            PartyListOption,
            currencyOptions,
            CurrentPartyDetailData,
            srStagesType,
            SalesReturnFormData,
            getPartyCode,
            getChallanInvoiceDetails,
            PartyDetailTabData,
            InvoiceListOption,
            companyOptions,
            dateFormat,
            formatDates,
            getSalesReturnFormatDate,
            getSalesReturnInvoiceFormatDate,
            required,
            showOverlayLoading,
        }
    },
    methods: {
        validationForm() {
            this.$refs.simpleRules.validate().then(success => {
                if (success) {

                    store.dispatch('sales-return-module/addSalesReturn', this.SalesReturnFormData).then(response => {
                        if (response.status === 200) {
                            this.$router.push({
                                name: 'edit-sales-return',
                                params: {id: response.data.data._id}
                            })
                            this.$toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Invoice Created',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: `You have successfully Created New Return.`,
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
