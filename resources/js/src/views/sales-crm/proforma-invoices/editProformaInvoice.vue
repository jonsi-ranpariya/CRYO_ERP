<template>
    <b-overlay
        :show="showOverlayLoading"
        rounded="sm"
    >
        <div>
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
                                        v-model="InvoiceFormData.pInvoiceNo"
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
                                    Save Invoice Data
                                </b-button>

                            </b-col>
                        </b-row>
                    </b-form>
                </validation-observer>

                <b-row>
                    <b-col md="12">
                        <hr>
                    </b-col>
                    <b-col md="12">
                        <b-tabs
                            pills
                            lazy
                        >

                            <b-tab active>
                                <template #title>
                                    <feather-icon
                                        icon="UserIcon"
                                        size="16"
                                        class="mr-0 mr-sm-50"
                                    />
                                    <span class="d-none d-sm-inline">Customer Detail</span>
                                </template>
                                <party-details
                                    :pi-party-tab-data.sync="InvoiceFormData.partyDetail"
                                />
                            </b-tab>

                            <b-tab>
                                <template #title>
                                    <feather-icon
                                        icon="PackageIcon"
                                        size="16"
                                        class="mr-0 mr-sm-50"
                                    />
                                    <span class="d-none d-sm-inline">Item Details</span>
                                </template>
                                <item-details
                                    :p-invoice-no.sync="InvoiceFormData.pInvoiceNo"
                                    :pInvoiceCustomerID.sync="InvoiceFormData.pInvoiceCustomerID"
                                    @updateBillingTerms="updateBillingTerms($event)"
                                />
                            </b-tab>

                            <b-tab>
                                <template #title>
                                    <feather-icon
                                        icon="FileTextIcon"
                                        size="16"
                                        class="mr-0 mr-sm-50"
                                    />
                                    <span class="d-none d-sm-inline">Billing Terms</span>
                                </template>
                                <billing-terms-details
                                    :pInvoiceNo.sync="InvoiceFormData.pInvoiceNo"
                                    :pInvoiceCustomerID.sync="InvoiceFormData.pInvoiceCustomerID"
                                />
                            </b-tab>

                            <b-tab>
                                <template #title>
                                    <feather-icon
                                        icon="ClipboardIcon"
                                        size="16"
                                        class="mr-0 mr-sm-50"
                                    />
                                    <span class="d-none d-sm-inline">Term & Conditions</span>
                                </template>
                                <term-condition-details/>
                            </b-tab>

                            <b-tab>
                                <template #title>
                                    <feather-icon
                                        icon="ShoppingCartIcon"
                                        size="16"
                                        class="mr-0 mr-sm-50"
                                    />
                                    <span class="d-none d-sm-inline">Buyer</span>
                                </template>
                                <buyer-tab-details
                                    :pi-buyer-tab-data.sync="InvoiceFormData.buyerDetail"
                                    :pi-party-list="PartyListOption"
                                />
                            </b-tab>

                            <b-tab>
                                <template #title>
                                    <feather-icon
                                        icon="TruckIcon"
                                        size="16"
                                        class="mr-0 mr-sm-50"
                                    />
                                    <span class="d-none d-sm-inline">Consignee</span>
                                </template>
                                <consignee-tab-details
                                    :pi-consignee-tab-data.sync="InvoiceFormData.consigneeDetail"
                                    :pi-party-list="PartyListOption"
                                />
                            </b-tab>
                            <b-tab>
                                <template #title>
                                    <feather-icon
                                        icon="FileIcon"
                                        size="16"
                                        class="mr-0 mr-sm-50"
                                    />
                                    <span class="d-none d-sm-inline">Other Details</span>
                                </template>
                                <other-details
                                    :other-tab-data.sync="InvoiceFormData.otherDetail"
                                />
                            </b-tab>
                            <b-tab>
                                <template #title>
                                    <feather-icon
                                        icon="LogInIcon"
                                        size="16"
                                        class="mr-0 mr-sm-50"
                                    />
                                    <span class="d-none d-sm-inline">Login</span>
                                </template>
                                <login-tab-details
                                    :pi-login-details.sync="InvoiceFormData.loginDetail"
                                />
                            </b-tab>

                        </b-tabs>
                    </b-col>
                </b-row>

            </b-card-code>
        </div>
    </b-overlay>
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
        BOverlay,
        BTab,
        BTabs,
        BInputGroupAppend,
        BInputGroup
    } from 'bootstrap-vue'
    import {required} from '@validations'
    import Ripple from 'vue-ripple-directive'
    import vSelect from 'vue-select'
    import router from '@/router'
    import store from '@/store'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import {ref, watch, watchEffect, onUnmounted} from '@vue/composition-api'
    import salesStoreModule from '../salesStoreModule'
    import axios from '@axios'
    import {getUserData} from "../../../auth/utils";
    import moment from 'moment'
    import PartyDetails from "./tabs/PartyDetails"
    import ItemDetails from "./tabs/itemDetails"
    import BillingTermsDetails from "./tabs/BillingTermsDetails"
    import TermConditionDetails from "./tabs/TermConditionDetails"
    import buyerTabDetails from "./tabs/buyerTabDetails"
    import consigneeTabDetails from "./tabs/consigneeTabDetails"
    import otherDetails from "./tabs/otherDetails"
    import loginTabDetails from "./tabs/loginTabDetails"
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
            BFormTextarea,
            BFormCheckbox,
            BForm,
            BButton,
            BFormDatepicker,
            vSelect,
            BOverlay,
            BTab,
            BTabs,
            PartyDetails,
            ItemDetails,
            BillingTermsDetails,
            TermConditionDetails,
            buyerTabDetails,
            consigneeTabDetails,
            otherDetails,
            loginTabDetails,
            BInputGroupAppend,
            BInputGroup,
            Cleave
        },
        directives: {
            Ripple,
        },
        methods: {
            validationForm() {
                this.$refs.simpleRules.validate().then(success => {
                    if (success) {

                        //console.log(this.InvoiceFormData)

                        this.InvoiceFormData.loginDetail.lastModifiedBy = this.CurrentUserData.first_name + ' ' + this.CurrentUserData.last_name
                        this.InvoiceFormData.loginDetail.modifiedDateTime = moment(new Date()).format('DD/MM/YYYY HH:mm')

                        store.dispatch('proforma-invoices-module/updateProformaInvoice', this.InvoiceFormData).then(response => {

                            //console.log(response);

                            if (response.status === 200) {

                                this.$router.push({name: 'proforma-invoices'})

                                this.$toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: 'PI Edited',
                                        icon: 'CheckSquareIcon',
                                        variant: 'success',
                                        text: `You have successfully Edited Proforma Invoice ${this.InvoiceFormData.pInvoiceNo}.`,
                                    },
                                })
                            }

                        })


                    }
                })
            },

        },
        setup() {

            const PI_APP_STORE_MODULE_NAME = 'proforma-invoices-module'
            // Register module
            if (!store.hasModule(PI_APP_STORE_MODULE_NAME)) store.registerModule(PI_APP_STORE_MODULE_NAME, salesStoreModule)
            // UnRegister on leave
            onUnmounted(() => {
                if (store.hasModule(PI_APP_STORE_MODULE_NAME)) store.unregisterModule(PI_APP_STORE_MODULE_NAME)
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
            const showOverlayLoading = ref(false)

            const CurrentPartyDetailData = ref([])

            const CurrentUserData = ref(getUserData())

            const PartyListOption = ref([])

            const BranchOptions = ref([])

            const currencyOptions = ref([])

            const KindAttnOptions = ref([])

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
                partyDetailStdCode:null,
                partyDetailPhoneNo: null,

            })

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
                pInvoiceDate: null,
                pInvoiceCurrency: null,
                pInvoiceConvRate: null,
                kindAttnId: null,
                kindAttnName: null,
                kindAttnMobile: null,
                kindAttnEmail: null,
                pInvoiceSalesType: null,
                pInvoiceStatus: null,
                pInvoiceBranch: null,
                pInvoiceSupplyType: null,
                pInvoiceGstType: null,
                pInvoiceReviewDate: null,
                pIRounding: 1,
                pInvoiceCustomerID: null,
                pInvoiceCustomerCode: null,
                pInvoiceCustomerName: null,
                partyDetail: PartyDetailTabData.value,
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
                    lastModifiedBy: CurrentUserData.value.first_name + ' ' + CurrentUserData.value.last_name,
                    modifiedDateTime: moment(new Date()).format('DD/MM/YYYY HH:mm'),
                    approvedBy: null,
                    approveDateTime: null,
                    stage: 'Prepared',
                }),
                pINetAmount: 0.00,
                pIGrossAmount: 0.00,
            })

            showOverlayLoading.value = true


            store.dispatch('proforma-invoices-module/fetchProformaInvoiceDetail', {id: router.currentRoute.params.id})
                .then(response => {
                    //console.log(response.data)

                    InvoiceFormData.value = response.data.data
                    InvoiceFormData.value.id = response.data.data._id
                    delete InvoiceFormData.value._id

                    if (response.data.data.partyDetail) {

                        PartyDetailTabData.value = response.data.data.partyDetail

                    }

                    axios.get(`/api/party/get-party-contacts-options/${response.data.data.pInvoiceCustomerID}`).then(res => {
                        KindAttnOptions.value = res.data.data
                    })

                    showOverlayLoading.value = false

                })
                .catch(error => {
                    if (error.response.status === 404) {
                        InvoiceFormData.value = undefined
                        showOverlayLoading.value = false
                    }
                })


            const getPartyCode = async (val) => {

                await axios.get(`/api/party/edit/${val}`).then(res => {

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

            }

            const getContactDetail = async (val) => {

                await axios.get(`/api/party/contact-person/${val}`).then(res => {

                    //console.log(res.data.data)

                    InvoiceFormData.value.kindAttnName = res.data.data.personName
                    InvoiceFormData.value.kindAttnMobile = res.data.data.mobileNo
                    InvoiceFormData.value.kindAttnEmail = res.data.data.email
                })

            }

            const updateBillingTerms = (e) => {
                console.log(e)
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
                showOverlayLoading,
                PartyDetailTabData,
                CurrentUserData,
                required,
                updateBillingTerms,
                dateFormat,
                formatDates,
                getInvoiceFormateDate,
                getReviewFormateDate
            }
        },

    }
</script>
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
