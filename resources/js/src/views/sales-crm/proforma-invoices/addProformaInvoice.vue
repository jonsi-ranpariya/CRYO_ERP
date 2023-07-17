<template>
    <b-card-code>
        <validation-observer ref="simpleRules">
            <b-form>
                <b-row>
                    <b-col md="2">
                        <b-form-group
                            label="Invoice No"
                            label-for="pInvoiceNo"
                        >
                            <b-form-input
                                id="pInvoiceNo"
                                readonly
                            />

                        </b-form-group>
                    </b-col>

                    <b-col md="4">
                        <b-form-group
                            label="Customer"
                            label-for="pInvoiceCustomerID"
                        >
                            <validation-provider
                                #default="{ errors }"
                                name="Customer"
                                rules="required"
                            >
                                <v-select
                                    v-model="InvoiceFormData.pInvoiceCustomerID"
                                    taggable
                                    push-tags
                                    placeholder="Select Party"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="PartyListOption"
                                    :reduce="val => val.value"
                                    :clearable="false"
                                    v-on:input="getPartyCode(InvoiceFormData.pInvoiceCustomerID)"
                                    input-id="pInvoiceCustomerID"
                                    :state="errors.length > 0 ? false:null"
                                />
                                <small class="text-danger">{{ errors[0] }}</small>
                            </validation-provider>
                        </b-form-group>
                    </b-col>

                    <b-col md="2">
                        <b-form-group
                            label="Customer Code"
                            label-for="pInvoiceCustomerCode"
                        >
                            <b-form-input
                                id="pInvoiceCustomerCode"
                                v-model="InvoiceFormData.pInvoiceCustomerCode"
                                readonly
                            />

                        </b-form-group>
                    </b-col>

                    <b-col md="4">
                        <b-form-group
                            label="Customer Name"
                            label-for="pInvoiceCustomerName"
                        >
                            <b-form-input
                                id="pInvoiceCustomerName"
                                v-model="InvoiceFormData.pInvoiceCustomerName"
                                readonly
                            />
                        </b-form-group>
                    </b-col>

                    <b-col md="3">
                        <b-form-group
                            label="Invoice Date"
                            label-for="pInvoiceDate"
                        >
                            <b-input-group>
                                <cleave
                                    id="pInvoiceDate"
                                    v-model="InvoiceFormData.pInvoiceDate"
                                    class="form-control"
                                    :raw="false"
                                    :options="dateFormat"
                                    placeholder="DD/MM/YYYY"
                                    show-decade-nav
                                />
                                <b-input-group-append>
                                    <b-form-datepicker
                                        v-model="formatDates.pInvoiceDate"
                                        button-only
                                        @input="getInvoiceFormateDate($event)"
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
                            label="Currency"
                            label-for="pInvoiceCurrency"
                        >
                            <v-select
                                placeholder="Select Currency"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="currencyOptions"
                                :reduce="val => val.value"
                                :clearable="false"
                                input-id="pInvoiceCurrency"
                                v-model="InvoiceFormData.pInvoiceCurrency"
                            />
                        </b-form-group>
                    </b-col>

                    <b-col md="3">
                        <b-form-group
                            label="Conversion Rate"
                            label-for="pInvoiceConvRate"
                        >
                            <b-form-input
                                id="pInvoiceConvRate"
                                v-model="InvoiceFormData.pInvoiceConvRate"
                            />
                        </b-form-group>
                    </b-col>


                    <b-col md="3">
                        <b-form-group
                            label="Branch"
                            label-for="pInvoiceBranch"
                        >
                            <v-select
                                v-model="InvoiceFormData.pInvoiceBranch"
                                taggable
                                push-tags
                                placeholder="Select Branch"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="BranchOptions"
                                :reduce="val => val.value"
                                :clearable="false"
                                input-id="pInvoiceBranch"
                            />
                        </b-form-group>
                    </b-col>

                    <b-col md="3">
                        <b-form-group
                            label="Review Date"
                            label-for="pInvoiceReviewDate"
                        >
                            <b-input-group>
                                <cleave
                                    id="pInvoiceReviewDate"
                                    v-model="InvoiceFormData.pInvoiceReviewDate"
                                    class="form-control"
                                    :raw="false"
                                    :options="dateFormat"
                                    placeholder="DD/MM/YYYY"
                                    show-decade-nav
                                />
                                <b-input-group-append>
                                    <b-form-datepicker
                                        v-model="formatDates.pInvoiceReviewDate"
                                        button-only
                                        @input="getReviewFormateDate($event)"
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
                            label-for="pInvoiceSupplyType"
                        >
                            <v-select
                                v-model="InvoiceFormData.pInvoiceSupplyType"
                                taggable
                                push-tags
                                placeholder="Select Supply Type"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="SupplyTypeOption"
                                :reduce="val => val.value"
                                :clearable="false"
                                input-id="pInvoiceSupplyType"
                            />
                        </b-form-group>
                    </b-col>

                    <b-col md="3">
                        <b-form-group
                            label="Gst %"
                            label-for="pInvoiceGstType"
                        >
                            <v-select
                                v-model="InvoiceFormData.pInvoiceGstType"
                                taggable
                                push-tags
                                placeholder="Select GST %"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="GstPercentageOption"
                                :reduce="val => val.value"
                                :clearable="false"
                                input-id="pInvoiceGstType"
                            />
                        </b-form-group>
                    </b-col>

                    <b-col md="3">
                        <b-form-group
                            label="Sales"
                            label-for="pInvoiceSalesType"
                        >
                            <v-select
                                placeholder="Select Sales"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="SalesTypeOptions"
                                :reduce="val => val.value"
                                :clearable="false"
                                input-id="pInvoiceSalesType"
                                v-model="InvoiceFormData.pInvoiceSalesType"
                            />
                        </b-form-group>
                    </b-col>

                    <b-col md="3">
                        <b-form-group
                            label="Select Kind Attn"
                            label-for="kindAttnId"
                        >
                            <v-select
                                v-model="InvoiceFormData.kindAttnId"
                                placeholder="Select Kind Attn"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="KindAttnOptions"
                                :reduce="val => val.value"
                                :clearable="false"
                                v-on:input="getContactDetail(InvoiceFormData.kindAttnId)"
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
                                v-model="InvoiceFormData.kindAttnName"
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
                                v-model="InvoiceFormData.kindAttnMobile"
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
                                v-model="InvoiceFormData.kindAttnEmail"
                            />
                        </b-form-group>
                    </b-col>

                    <b-col md="6">
                        <b-form-group
                            label="Status"
                            label-for="pInvoiceStatus"
                        >
                            <v-select
                                placeholder="Select Status"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="StatusOptions"
                                :reduce="val => val.value"
                                :clearable="false"
                                input-id="pInvoiceStatus"
                                v-model="InvoiceFormData.pInvoiceStatus"
                            />
                        </b-form-group>
                    </b-col>

                    <b-col md="6">
                        <b-form-group class="mt-2">
                            <b-form-checkbox
                                id="isPrint"
                                v-model="InvoiceFormData.pIRounding"
                                name="isPrint"
                                value="1"
                            >
                                Rounding
                            </b-form-checkbox>
                        </b-form-group>
                    </b-col>

                </b-row>
                <b-row>
                    <!-- submit and reset -->
                    <b-col>
                        <b-button
                            v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                            type="submit"
                            variant="primary"
                            class="mr-1"
                            @click.prevent="validationForm"
                        >
                            Submit
                        </b-button>

                    </b-col>
                </b-row>
            </b-form>
        </validation-observer>
    </b-card-code>
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
        BForm,
        BButton,
        BFormDatepicker,
        BInputGroup,
        BInputGroupAppend
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
    import { getTcTodayDate } from '@core/utils/utils'
    import {forMatIndianDate} from "../../../@core/utils/utils";
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
            BFormTextarea,
            BForm,
            BButton,
            BFormDatepicker,
            vSelect,
            Cleave,
            BInputGroup,
            BInputGroupAppend
        },
        directives: {
            Ripple,
        },
        setup() {
            const SO_APP_STORE_MODULE_NAME = 'sales-order-module'
            // Register module
            if (!store.hasModule(SO_APP_STORE_MODULE_NAME)) store.registerModule(SO_APP_STORE_MODULE_NAME, salesStoreModule)
            // UnRegister on leave
            onUnmounted(() => {
                if (store.hasModule(SO_APP_STORE_MODULE_NAME)) store.unregisterModule(SO_APP_STORE_MODULE_NAME)
            })
            const dateFormat = ref({
                date: true,
                delimiter: '/',
                datePattern: ['d', 'm', 'Y'],
            })

            const formatDates = ref({
                pInvoiceDate: null,
                pInvoiceReviewDate: null,
            })

            const getInvoiceFormateDate = (date) => {
                InvoiceFormData.value.pInvoiceDate = forMatIndianDate(date)
            }
            const getReviewFormateDate = (date) => {
                InvoiceFormData.value.pInvoiceReviewDate = forMatIndianDate(date)
            }

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

            })

            const PartyListOption = ref([])

            const BranchOptions = ref([])

            const currencyOptions = ref([])

            const KindAttnOptions = ref([])

            const StatusOptions = ref([
                {label: 'Pending', value: 'Pending'},
                {label: 'Completed', value: 'Completed'},
                {label: 'Regret', value: 'Regret'},
                {label: 'Cancelled', value: 'Cancelled'},
            ])

            const SalesTypeOptions = ref([
                {label: 'Domestic', value: 1},
                {label: 'Export', value: 2},
            ])


            const SupplyTypeOption = ref([
                {label: 'Intrastate', value: 1},
                {label: 'Interstate', value: 2},
                {label: 'Export', value: 3},
            ])

            const GstPercentageOption = ref([
                {label: 'SO Wise', value: 1},
                {label: 'Invoice Wise', value: 2},
                {label: 'Item Wise', value: 3}
            ])

            axios.get('/api/party/get-master-options').then(res => {
                PartyListOption.value = res.data.data
            })

            axios.get('/api/get-branch-master-options').then(res => {
                BranchOptions.value = res.data.data
            })

            axios.get('/api/get-currency-options').then(res => {
                currencyOptions.value = res.data.data
            })

            const InvoiceFormData = ref({
                id: null,
                pInvoiceNo: null,
                pInvoiceDate: forMatIndianDate(getTcTodayDate()),
                pInvoiceCurrency: null,
                pInvoiceConvRate: null,
                kindAttnId: null,
                kindAttnName: null,
                kindAttnMobile: null,
                kindAttnEmail: null,
                pInvoiceSalesType: null,
                pInvoiceStatus: 'Pending',
                pInvoiceBranch: null,
                pInvoiceSupplyType: null,
                pInvoiceGstType: null,
                pInvoiceReviewDate: forMatIndianDate(),
                pIRounding: 1,
                pInvoiceCustomerID: null,
                pInvoiceCustomerCode: null,
                pInvoiceCustomerName: null,
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
                    buyerDetailPhoneStdCode: null,
                    buyerDetailPhoneNo: null,
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
                    consigneeDetailPhoneStdCode: null,
                    consigneeDetailPhoneNo: null,

                }),
                otherDetail: ref({
                    exportRef: null,
                    otherRef: null,
                    preCarriageBy: null,
                    vessel: null,
                    portOfDischarge: null,
                    note: null,
                    itemDescTitle: null,
                    placeOfReceipt: null,
                    portOfLoading: null,
                    finalDestination: null,
                }),
                loginDetail: ref({
                    createdBy: CurrentUserData.value.first_name + ' ' + CurrentUserData.value.last_name,
                    createdDateTime: moment(new Date()).format('DD/MM/YYYY HH:mm'),
                    lastModifiedBy: null,
                    modifiedDateTime: null,
                    approvedBy: null,
                    approveDateTime: null,
                    stage: 'Prepared',
                }),
                pINetAmount: 0.00,
                pIGrossAmount: 0.00,
            })


            const getPartyCode = async (val) => {

                await axios.get(`/api/party/edit/${val}`).then(res => {

                    //console.log(res.data.data)

                    CurrentPartyDetailData.value = res.data.data

                    InvoiceFormData.value.pInvoiceCustomerCode = CurrentPartyDetailData.value.partyCode
                    InvoiceFormData.value.pInvoiceCustomerName = CurrentPartyDetailData.value.partyName
                    InvoiceFormData.value.pInvoiceCustomerID = val

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
                    }

                    if (CurrentPartyDetailData.value.partyCurrencyType) {

                        InvoiceFormData.value.pInvoiceCurrency = CurrentPartyDetailData.value.partyCurrencyType
                    }

                    if (CurrentPartyDetailData.value.partyCurrencyType) {

                        InvoiceFormData.value.pInvoiceCurrency = CurrentPartyDetailData.value.partyCurrencyType

                        axios.get(`/api/currency-master/${CurrentPartyDetailData.value.partyCurrencyType}`).then(Curres => {

                            if (Curres.data.data) {

                                InvoiceFormData.value.pInvoiceConvRate = Curres.data.data.currencyRate
                            }
                        })

                    }

                    if (CurrentPartyDetailData.value.partySupplyType) {

                        InvoiceFormData.value.pInvoiceSupplyType = CurrentPartyDetailData.value.partySupplyType
                    }

                    if (CurrentPartyDetailData.value.partyBranch) {

                        InvoiceFormData.value.pInvoiceBranch = CurrentPartyDetailData.value.partyBranch.value
                    }

                })

                InvoiceFormData.value.kindAttnId = null

                await axios.get(`/api/party/get-party-contacts-options/${val}`).then(res => {
                    KindAttnOptions.value = res.data.data
                })

                //console.log(InvoiceFormData.value)

            }

            const getContactDetail = async (val) => {

                await axios.get(`/api/party/contact-person/${val}`).then(res => {

                    //console.log(res.data.data)

                    InvoiceFormData.value.kindAttnName = res.data.data.personName
                    InvoiceFormData.value.kindAttnMobile = res.data.data.mobileNo
                    InvoiceFormData.value.kindAttnEmail = res.data.data.email
                })

            }


            return {
                PartyListOption,
                BranchOptions,
                currencyOptions,
                KindAttnOptions,
                CurrentPartyDetailData,
                StatusOptions,
                SalesTypeOptions,
                SupplyTypeOption,
                GstPercentageOption,
                InvoiceFormData,
                getPartyCode,
                getContactDetail,
                PartyDetailTabData,
                required,
                dateFormat,
                formatDates,
                getReviewFormateDate,
                getInvoiceFormateDate
            }
        },
        methods: {
            validationForm() {
                this.$refs.simpleRules.validate().then(success => {
                    if (success) {

                        //console.log(this.InvoiceFormData)

                        store.dispatch('sales-order-module/addProformaInvoice', this.InvoiceFormData).then(response => {
                            if (response.status === 200) {
                                this.$router.push({
                                    name: 'edit-proforma-invoices',
                                    params: {id: response.data.data._id}
                                })
                                this.$toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: 'Invoice Created',
                                        icon: 'CheckSquareIcon',
                                        variant: 'success',
                                        text: `You have successfully Created New Invoice.`,
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
