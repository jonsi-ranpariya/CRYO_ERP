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
                            <b-col md="6">
                                <b-row>
                                    <b-col md="6">
                                        <validation-provider
                                            #default="validationContext"
                                            name="Ref No."
                                            rules="required"
                                        >
                                            <b-form-group
                                                label="Ref No."
                                                label-for="refNo"
                                            >
                                                <b-form-input
                                                    id="refNo"
                                                    :state="getValidationState(validationContext)"
                                                    v-model="formData.referenceNumber"
                                                    readonly
                                                />
                                            </b-form-group>
                                            <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                                {{ validationContext.errors[0] }}
                                            </b-form-invalid-feedback>
                                        </validation-provider>
                                    </b-col>
                                    <b-col md="6">
                                        <validation-provider
                                            #default="validationContext"
                                            name="Ref.Date"
                                            rules="required"
                                        >
                                            <b-form-group
                                                label="Ref. Date"
                                                label-for="refDate"
                                            >
                                                <b-input-group>
                                                    <cleave
                                                        id="referenceDate"
                                                        v-model="formData.referenceDate"
                                                        class="form-control"
                                                        :raw="false"
                                                        :options="dateFormat"
                                                        placeholder="DD/MM/YYYY"
                                                        show-decade-nav
                                                    />
                                                    <b-input-group-append>
                                                        <b-form-datepicker
                                                            v-model="formatDates.referenceDate"
                                                            button-only
                                                            @input="getRferenceFormateDate($event)"
                                                            show-decade-nav
                                                            size="sm"
                                                            nav-button-variant="primary"
                                                        />
                                                    </b-input-group-append>
                                                </b-input-group>
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
                                            label="Vendor Qtn No."
                                            label-for="vendorQtnNo"
                                        >
                                            <b-form-input
                                                id="vendorQtnNo"
                                                v-model="formData.vendorQtnNo"
                                            />
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="6">
                                        <b-form-group
                                            label="Vendor Qtn Date"
                                            label-for="vendorQtnDate"
                                        >
                                            <b-input-group>
                                                <cleave
                                                    id="vendorQtnDate"
                                                    v-model="formData.vendorQtnDate"
                                                    class="form-control"
                                                    :raw="false"
                                                    :options="dateFormat"
                                                    placeholder="DD/MM/YYYY"
                                                    show-decade-nav
                                                />
                                                <b-input-group-append>
                                                    <b-form-datepicker
                                                        v-model="formatDates.vendorQtnDate"
                                                        button-only
                                                        @input="getVendoerFormateDate($event)"
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
                                            label="Purchase Qtn No."
                                            label-for="purchseQtnNo"
                                        >
                                            <b-form-input
                                                v-model="formData.purchaseQtnNo"
                                                id="purchseQtnNo"
                                                readonly
                                            />
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="6">
                                        <b-form-group
                                            label="Purchase Qtn Date"
                                            label-for="purchasetnDate"
                                        >
                                            <b-input-group>
                                                <cleave
                                                    id="purchaseQtnDate"
                                                    v-model="formData.purchaseQtnDate"
                                                    class="form-control"
                                                    :raw="false"
                                                    :options="dateFormat"
                                                    placeholder="DD/MM/YYYY"
                                                    show-decade-nav
                                                />
                                                <b-input-group-append>
                                                    <b-form-datepicker
                                                        v-model="formatDates.purchaseQtnDate"
                                                        button-only
                                                        @input="getPurchaseQtnFormateDate($event)"
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
                            <!--row division -->
                            <b-col md="6">
                                <b-row>
                                    <b-col md="6">
                                        <validation-provider
                                            #default="validationContext"
                                            name="Due Date"
                                            rules=""
                                        >
                                            <b-form-group
                                                label="Due Date"
                                                label-for="dueDate"
                                            >
                                                <b-input-group>
                                                    <b-input-group-prepend>
                                                        <b-form-datepicker
                                                            v-model="formatDates.dueDate"
                                                            button-only
                                                            @input="getDueFormateDate($event)"
                                                            show-decade-nav
                                                            size="sm"
                                                            nav-button-variant="primary"
                                                            disabled
                                                        />
                                                    </b-input-group-prepend>
                                                    <cleave
                                                        id="dueDate"
                                                        v-model="formData.dueDate"
                                                        class="form-control"
                                                        :raw="false"
                                                        :options="dateFormat"
                                                        placeholder="DD/MM/YYYY"
                                                        show-decade-nav
                                                        disabled
                                                        :state="getValidationState(validationContext)"
                                                    />
                                                </b-input-group>
                                            </b-form-group>
                                            <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                                {{ validationContext.errors[0] }}
                                            </b-form-invalid-feedback>
                                        </validation-provider>
                                    </b-col>
                                    <b-col md="6">
                                        <b-form-group
                                            label="Currency"
                                            label-for="currency"
                                        >
                                            <v-select
                                                placeholder="Select Currency"
                                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                                :options="currencyOptions"
                                                :reduce="val => val.value"
                                                :clearable="false"
                                                input-id="currency"
                                                v-model="formData.currencyId"
                                                @input="getCurrencyDetail($event)"
                                            />
                                        </b-form-group>
                                    </b-col>
                                </b-row>
                                <b-row>
                                    <b-col md="6">
                                        <b-form-group
                                            label="Conversion Rate"
                                            label-for="conversionRate"
                                        >
                                            <b-form-input
                                                id="conversionRate"
                                                v-model="formData.conversationRate"
                                            />
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="6">
                                        <b-form-group
                                            label="Status"
                                            label-for="status"
                                        >
                                            <v-select
                                                placeholder="Select Status"
                                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                                :options="statusOptions"
                                                :reduce="val => val.value"
                                                :clearable="false"
                                                input-id="status"
                                                v-model="formData.status"
                                            />
                                        </b-form-group>
                                    </b-col>
                                </b-row>
                                <b-row>
                                    <b-col md="6">
                                        <b-form-group
                                            label="Quotation Type"
                                            label-for="quotationType"
                                        >
                                            <v-select
                                                placeholder="Select Quotation Type"
                                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                                :options="quotationOptions"
                                                :reduce="val => val.value"
                                                :clearable="false"
                                                input-id="quotationType"
                                                v-model="formData.qtnType"
                                            />
                                        </b-form-group>
                                    </b-col>
                                </b-row>
                            </b-col>

                            <!--Rounding Button-->
                            <b-col md="12">
                                <div class="demo-inline-spacing mb-2">
                                    <b-form-radio
                                        v-model="formData.purchaseQuotationRounding"
                                        name="salesReturnRoundingAll"
                                        value="0"
                                    >
                                        None
                                    </b-form-radio>
                                    <b-form-radio
                                        v-model="formData.purchaseQuotationRounding"
                                        name="salesReturnRoundingAll"
                                        value="1"
                                    >
                                        Rounding
                                    </b-form-radio>
                                    <b-form-radio
                                        v-model="formData.purchaseQuotationRounding"
                                        name="salesReturnRoundingAll"
                                        value="2"
                                    >
                                        Rounding All
                                    </b-form-radio>
                                </div>
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
        </b-overlay>
        <b-overlay
            :show="showOverlayLoading"
            rounded="sm"
        >
            <b-card-code>
                <b-tabs pills lazy>
                    <b-tab active>
                        <template #title>
                            <feather-icon
                                icon="UsersIcon"
                                size="16"
                                class="mr-0 mr-sm-50"
                            />
                            <span class="d-none d-sm-inline">Vendor Details</span>
                        </template>
                        <hr>
                        <vendor-tab-details
                            :vendorDetails.sync="formData.vendorDetails"
                        />
                    </b-tab>
                    <b-tab>
                        <template #title>
                            <feather-icon
                                icon="FileIcon"
                                size="16"
                                class="mr-0 mr-sm-50"
                            />
                            <span class="d-none d-sm-inline">Item Details</span>
                        </template>
                        <hr>
                        <item-tab-details
                            :poRoundingType="formData.purchaseQuotationRounding"
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
                            :itemDetails.sync="itemDetails"
                            :roundingType.sync="formData.purchaseQuotationRounding"
                        />
                    </b-tab>
                    <b-tab>
                        <template #title>
                            <feather-icon
                                icon="TypeIcon"
                                size="16"
                                class="mr-0 mr-sm-50"
                            />
                            <span class="d-none d-sm-inline">Terms & Conditions</span>
                        </template>
                        <hr>
                        <terms-condition-tab
                            :vendorPartyId="formData.vendorDetails.vendorCode"
                        />
                    </b-tab>
                    <b-tab>
                        <template #title>
                            <feather-icon
                                icon="EditIcon"
                                size="16"
                                class="mr-0 mr-sm-50"
                            />
                            <span class="d-none d-sm-inline">Note</span>
                        </template>
                        <hr>
                        <quotation-note-tab
                            :noteDetails.sync="formData.noteDetails"
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
                        <hr>
                        <login-tab
                            :loginData.sync="formData.loginDetails"
                        />
                    </b-tab>
                </b-tabs>
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
        BFormDatepicker,
        BFormTextarea,
        BButton,
        BFormValidFeedback,
        BInputGroupAppend,
        BInputGroup,
        BFormInvalidFeedback,
        BTabs,
        BTab,
        BTable,
        BOverlay,
        BInputGroupPrepend,
        BFormRadio
    } from 'bootstrap-vue'
    import BCardCode from "../../../@core/components/b-card-code/BCardCode";
    import {ValidationObserver, ValidationProvider} from 'vee-validate'
    import vSelect from 'vue-select'
    import {ref, onUnmounted} from "@vue/composition-api";
    import {forMatIndianDate, getTcTodayDate} from "../../../@core/utils/utils";
    import Ripple from "vue-ripple-directive";
    import itemTabDetails from "./tabs/itemTabDetails"
    import billingTermsTab from "./tabs/billingTermsTab"
    import termsConditionTab from "./tabs/termsConditionsTab"
    import quotationNoteTab from "./tabs/quotationNoteTab"
    import loginTab from "./tabs/loginTab"
    import vendorTabDetails from "./tabs/vendorTabDetails";
    import axios from '@axios'
    import formValidation from '@core/comp-functions/forms/form-validation'
    import {required} from '@validations'
    import store from '@/store'
    import purchaseStoreModule from "../purchaseStoreModule";
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import {useToast} from 'vue-toastification/composition'
    import router from '@/router'
    import Cleave from 'vue-cleave-component'
    import {getUserData} from "../../../auth/utils";
    import moment from "moment";
    import {getTcTodayDateTime} from "@core/utils/utils";

    export default {
        components: {
            BCardCode,
            ValidationObserver,
            ValidationProvider,
            BRow,
            BCol,
            BForm,
            BFormGroup,
            vSelect,
            BTabs,
            BTab,
            BFormInput,
            BFormDatepicker,
            BFormTextarea,
            BButton,
            BFormValidFeedback,
            BInputGroupAppend,
            BInputGroup,
            BFormInvalidFeedback,
            itemTabDetails,
            billingTermsTab,
            termsConditionTab,
            quotationNoteTab,
            loginTab,
            vendorTabDetails,
            BTable,
            BOverlay,
            Cleave,
            BInputGroupPrepend,
            BFormRadio
        },
        directives: {
            Ripple,
        },
        setup() {
            const ITEMADDON_APP_STORE_MODULE_NAME = 'purchase-store-module'
            if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, purchaseStoreModule)
            onUnmounted(() => {
                if (store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.unregisterModule(ITEMADDON_APP_STORE_MODULE_NAME)
            })

            const toast = useToast()

            const showOverlayLoading = ref(false)

            const statusOptions = ref([
                {label: 'Pending', value: 1},
                {label: 'Canceled', value: 2},
                {label: 'Completed', value: 3},
                {label: 'Regret', value: 4},
            ])
            const quotationOptions = ref([
                {label: 'Product Quotation', value: 1},
                {label: 'Spares Quotation', value: 2},
                {label: 'Service Quotation', value: 3},
                {label: 'Budgetory Quotation', value: 4},
            ])

            const currencyOptions = ref([])
            axios.get('/api/get-currency-options').then(res => {
                currencyOptions.value = res.data.data
            })

            const getCurrencyDetail = async (id) => {
                await axios.get(`/api/currency-master/${id}`).then(res => {
                    formData.value.conversationRate = res.data.data.currencyRate
                })
            }
            const dateFormat = ref({
                date: true,
                delimiter: '/',
                datePattern: ['d', 'm', 'Y'],
            })

            const formatDates = ref({
                referenceDate: null,
                vendorQtnDate: null,
                purchaseQtnDate: null,
                dueDate: null,
            })

            const getRferenceFormateDate = (date) => {
                formData.value.referenceDate = forMatIndianDate(date)
            }
            const getVendoerFormateDate = (date) => {
                formData.value.vendorQtnDate = forMatIndianDate(date)
            }
            const getPurchaseQtnFormateDate = (date) => {
                formData.value.purchaseQtnDate = forMatIndianDate(date)
            }
            const getDueFormateDate = (date) => {
                formData.value.dueDate = forMatIndianDate(date)
            }
            const CurrentUserData = ref(getUserData())

            const formData = ref({
                id:null,
                referenceId: null,
                referenceNumber: null,
                referenceDate: forMatIndianDate(),
                currencyId: null,
                dueDate: forMatIndianDate(getTcTodayDate()),
                vendorQtnNo: null,
                vendorQtnDate: forMatIndianDate(getTcTodayDate()),
                conversationRate: null,
                status: null,
                purchaseQtnNo: null,
                purchaseQtnDate: forMatIndianDate(getTcTodayDate()),
                qtnType: 1,
                purchaseQuotationRounding: null,
                itemIds: [],
                vendorDetails: {
                    vendorCode: null,
                    vendorName: null,
                    vendorKindAttn: null,
                    vendorAddress: null,
                    vendorCity: null,
                    vendorState: null,
                    vendorCountry: null,
                    vendorFaxNo: null,
                    vendorEmailId: null,
                    vendorPinCode: null,
                    vendorPhoneCountry: '+91',
                    vendorPhoneNo: null,
                    vendorWebSite: null,
                },
                noteDetails: {
                    quotationNote: null,
                },
                loginDetails: {
                    createdBy: CurrentUserData.value.first_name + ' ' + CurrentUserData.value.last_name,
                    dateTime: moment(new Date()).format('DD/MM/YYYY HH:mm'),
                    lastModifiedBy: null,
                    modifiedDateTime: null,
                },
            })

            const itemDetails = ref([])
            axios.get('/api/get-purchase-quotation-item/'.concat(router.currentRoute.params.id)).then(res => {
                itemDetails.value = res.data.data
            })

            const resetFormData = () => {
                formData.value = JSON.parse(JSON.stringify(formData.value))
            }

            axios.get(`/api/purchase-quotation/${router.currentRoute.params.id}`).then(res => {
                formData.value = res.data.data
                formData.value.id = res.data.data._id
                delete res.data.data._id
                showOverlayLoading.value = false
            })

            const saveFormData = async () => {
                formData.value.loginDetails.lastModifiedBy = CurrentUserData.value.first_name + ' ' + CurrentUserData.value.last_name
                formData.value.loginDetails.modifiedDateTime = getTcTodayDateTime()
                await store.dispatch('purchase-store-module/updatePurchaseQuotation', formData.value).then(res => {
                    if (res.status === 200) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Purchase Quotation Updated',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: 'You have successfully Updated Purchase Quotation.',
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

            const {refFormObserver, getValidationState, resetForm} = formValidation(resetFormData)

            return {
                showOverlayLoading,
                itemDetails,
                formData,
                statusOptions,
                quotationOptions,
                currencyOptions,
                getCurrencyDetail,
                resetFormData,
                saveFormData,
                refFormObserver,
                getValidationState,
                resetForm,
                getDueFormateDate,
                getPurchaseQtnFormateDate,
                getVendoerFormateDate,
                getRferenceFormateDate,
                dateFormat,
                formatDates
            }
        },
    }
</script>
