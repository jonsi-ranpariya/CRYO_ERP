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
                                            name="Job Work Return No"
                                            rules="required"
                                        >
                                            <b-form-group
                                                label="Job Work Return No"
                                                label-for="jobWorkReturnNo"
                                            >
                                                <b-form-input
                                                    id="jobWorkReturnNo"
                                                    :state="getValidationState(validationContext)"
                                                    v-model="formData.jobWorkReturnNo"
                                                    readonly
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
                                            name="Job Work Return Date"
                                            rules="required"
                                        >
                                            <b-form-group
                                                label="Job Work Return Date"
                                                label-for="jobWorkReturnDate"
                                                :state="getValidationState(validationContext)"
                                            >
                                                <b-input-group>
                                                    <cleave
                                                        id="jobWorkReturnDate"
                                                        v-model="formData.jobWorkReturnDate"
                                                        class="form-control"
                                                        :raw="false"
                                                        :options="dateFormat"
                                                        placeholder="DD/MM/YYYY"
                                                        show-decade-nav
                                                    />
                                                    <b-input-group-append>
                                                        <b-form-datepicker
                                                            v-model="formatDates.jobWorkReturnDate"
                                                            button-only
                                                            @input="getJobWorkRejectionMemoFormateDate($event)"
                                                            show-decade-nav
                                                            size="sm"
                                                            nav-button-variant="primary"
                                                        />
                                                    </b-input-group-append>
                                                </b-input-group>
                                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                                    {{ validationContext.errors[0] }}
                                                </b-form-invalid-feedback>
                                            </b-form-group>
                                        </validation-provider>
                                    </b-col>
                                </b-row>
                                <validation-provider
                                    #default="validationContext"
                                    name="Sub-Contractor Code"
                                    rules="required"
                                >
                                    <b-form-group
                                        label="Sub-Contractor Code"
                                        label-for="subContractorCode"
                                    >
                                        <v-select
                                            placeholder="Select No"
                                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                            :options="subContractorOption"
                                            :reduce="val => val.value"
                                            :clearable="false"
                                            input-id="subContractorCode"
                                            v-model="formData.subContractorId"
                                            :state="getValidationState(validationContext)"
                                            disabled
                                        />
                                        <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                            {{validationContext.errors[0]}}
                                        </b-form-invalid-feedback>
                                    </b-form-group>
                                </validation-provider>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Kind Attn."
                                    label-for="kindAttn"
                                >
                                    <v-select
                                        placeholder="Select KindAttn"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :reduce="val => val.value"
                                        :options="kindAttnOption"
                                        :clearable="false"
                                        input-id="kindAttn"
                                        v-model="formData.kindAttn"
                                    />
                                </b-form-group>
                                <b-form-group
                                    label="Sub-Contractor Name"
                                    label-for="subContractorName"
                                >
                                    <b-form-input
                                        id="subContractorName"
                                        v-model="formData.subContractorName"
                                    />
                                </b-form-group>
                            </b-col>
                            <!--Button-->
                            <b-col md="12">
                                <hr>
                                <b-button
                                    variant="primary"
                                    type="submit"
                                    class="float-right"
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
                                icon="UserIcon"
                                size="16"
                                class="mr-0 mr-sm-50"
                            />
                            <span class="d-none d-sm-inline">Sub-Contractor</span>
                        </template>
                        <hr>
                        <sub-contractor-tab
                            :subContractorDetails="formData.subContractorDetails"
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
                        <item-details-tab
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
                        />
                    </b-tab>
                    <b-tab>
                        <template #title>
                            <feather-icon
                                icon="ServerIcon"
                                size="16"
                                class="mr-0 mr-sm-50"
                            />
                            <span class="d-none d-sm-inline">Header/Footer</span>
                        </template>
                        <hr>
                        <header-footer-report-tab
                            :headerFooterDetails="formData.headerFooterDetails"
                        />
                    </b-tab>
                    <b-tab>
                        <template #title>
                            <feather-icon
                                icon="LogInIcon"
                                size="16"
                                class="mr-0 mr-sm-50"
                            />
                            <span class="d-none d-sm-inline">Login Details</span>
                        </template>
                        <hr>
                        <login-details-tab
                            :loginData.sync="formData.loginDetails"
                        />
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
                        <reports-tab
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
    BFormInvalidFeedback,
    BButton,
    BFormDatepicker,
    BTabs,
    BTab,
    BOverlay,
    BInputGroup,
    BInputGroupAppend,
} from 'bootstrap-vue'
import BCardCode from '../../../@core/components/b-card-code/BCardCode'
import { ValidationObserver, ValidationProvider } from 'vee-validate'
import { required } from '@validations'
import { onUnmounted, ref } from '@vue/composition-api'
import formValidation from '../../../@core/comp-functions/forms/form-validation'
import vSelect from 'vue-select'
import axios from '@axios'
import { forMatIndianDate, forMatIndianDateAndTime, getTcTodayDate } from '@core/utils/utils'
import subContractorTab from './tabs/subContractorTab'
import itemDetailsTab from './tabs/itemDetailsTab'
import billingTermsTab from './tabs/billingTermsTab'
import headerFooterReportTab from './tabs/headerFooterReportTab'
import reportsTab from './tabs/reportsTab'
import loginDetailsTab from './tabs/loginDetailsTab'
import router from '@/router'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
import Ripple from 'vue-ripple-directive'
import store from '@/store'
import { useToast } from 'vue-toastification/composition'
import jobWorkStoreModule from '../jobWorkStoreModule'
import Cleave from 'vue-cleave-component'
import { getUserData } from '../../../auth/utils'

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
        BButton,
        BFormDatepicker,
        vSelect,
        BTabs,
        BTab,
        BOverlay,
        Cleave,
        subContractorTab,
        itemDetailsTab,
        billingTermsTab,
        headerFooterReportTab,
        reportsTab,
        loginDetailsTab,
        BInputGroup,
        BInputGroupAppend
    },
    directives: {
        Ripple,
    },
    setup() {
        const toast = useToast()
        const ITEMADDON_APP_STORE_MODULE_NAME = 'return-memo-store-module'
        if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, jobWorkStoreModule)
        onUnmounted(() => {
            if (store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.unregisterModule(ITEMADDON_APP_STORE_MODULE_NAME)
        })
        const showOverlayLoading = ref(false)
        const CurrentUserData = ref(getUserData())

        const subContractorOption = ref([])
        axios.get('/api/party/get-master-options')
            .then(res => {
                subContractorOption.value = res.data.data
            })
        const kindAttnOption = ref([])

        const dateFormat = ref({
            date: true,
            delimiter: '/',
            datePattern: ['d', 'm', 'Y'],
        })

        const formatDates = ref({
            jobWorkReturnDate: null,
        })

        const getJobWorkRejectionMemoFormateDate = (date) => {
            formData.value.jobWorkReturnDate = forMatIndianDate(date)
        }

        const formData = ref({
            jobWorkReturnNo: null,
            jobWorkReturnDate: getTcTodayDate(),
            subContractorId: null,
            subContractorCode: null,
            subContractorName: null,
            kindAttn: null,
            subContractorDetails: {
                subContractorCode: null,
                subContractorName: null,
                contractorAddress: null,
                contractorCountry: null,
                contractorState: null,
                contractorCity: null,
                contractorFaxNo: null,
                ContractorEmailId: null,
                contractorWebsite: null,
                contractorPinCode: null,
                contraPhoneCountry: '+91',
                contraPhoneNo: null,
            },
            headerFooterDetails: {
                header: null,
                headerDescription: null,
                footer: null,
                footerDescription: null,
                remark: null,
            },
            loginDetails: {
                createdBy: null,
                dateTime: null,
                lastModifiedBy: null,
                modifiedDateTime: null,
            },
        })

        const refetchData = async () => {
            showOverlayLoading.value = true
            await axios.get(`/api/new/return-rejection-memo/${router.currentRoute.params.id}`)
                .then(res => {
                    formData.value = res.data.data
                })
            showOverlayLoading.value = false
        }
        refetchData()

        setTimeout(async () => {
            await axios.get(`/api/party/get-party-contacts-options/${formData.value.subContractorId}`)
                .then(res => {
                    kindAttnOption.value = res.data.data
                })
        }, 1000)

        const resetFormData = () => {
            formData.value = JSON.parse(JSON.stringify(formData.value))
        }

        const saveFormData = async () => {
            formData.value.loginDetails.lastModifiedBy = CurrentUserData.value.first_name + ' ' + CurrentUserData.value.last_name
            formData.value.loginDetails.modifiedDateTime = forMatIndianDateAndTime(new Date())
            await store.dispatch('return-memo-store-module/updateReturnRejectionMemo', formData.value)
                .then(res => {
                    if (res.status === 200) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Return Rejection Memo Updated',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: `You have successfully Updated Return Rejection Memo.`,
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
                    router.push({ name: 'return-rejection-memo' })
                })
        }

        const {
            refFormObserver,
            getValidationState,
            resetForm
        } = formValidation(resetFormData)

        return {
            refFormObserver,
            getValidationState,
            resetForm,
            resetFormData,
            formData,
            required,
            subContractorOption,
            kindAttnOption,
            saveFormData,
            refetchData,
            showOverlayLoading,
            dateFormat,
            formatDates,
            getJobWorkRejectionMemoFormateDate,
        }
    }
}
</script>
