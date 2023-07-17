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
                                            name="Job Work No"
                                            rules="required"
                                        >
                                            <b-form-group
                                                label="Job Work No"
                                                label-for="jobWorkNo"
                                            >
                                                <b-form-input
                                                    v-model="formData.jobWorkNo"
                                                    id="jobWorkNo"
                                                    readonly
                                                    :state="getValidationState(validationContext)"
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
                                            name="Job Work No"
                                            rules="required"
                                        >
                                            <b-form-group
                                                label="Job Work Date"
                                                label-for="jobWorkDate"
                                            >
                                                <b-input-group>
                                                    <cleave
                                                        id="jobWorkDate"
                                                        v-model="formData.jobWorkDate"
                                                        class="form-control"
                                                        :raw="false"
                                                        :options="dateFormat"
                                                        placeholder="DD/MM/YYYY"
                                                        show-decade-nav
                                                    />
                                                    <b-input-group-append>
                                                        <b-form-datepicker
                                                            v-model="formatDates.jobWorkDate"
                                                            button-only
                                                            @input="getJobWorkFormateDate($event)"
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
                                <b-row>
                                    <b-col md="6">
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
                                                    placeholder="Select Code"
                                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                                    :options="subContractorOptions"
                                                    :reduce="val => val.value"
                                                    :clearable="false"
                                                    input-id="subContractorCode"
                                                    v-model="formData.subContractorId"
                                                    :state="getValidationState(validationContext)"
                                                    disabled
                                                />
                                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                                    {{ validationContext.errors[0] }}
                                                </b-form-invalid-feedback>
                                            </b-form-group>
                                        </validation-provider>
                                    </b-col>
                                    <b-col md="6">
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
                                </b-row>
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
                            <b-col md="6">
                                <b-form-group
                                    label="Is Excisable"
                                    label-for="isExcisable"
                                >
                                    <v-select
                                        v-model="formData.isExcisable"
                                        placeholder="Select Excisable"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="excisableOptions"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        input-id="isExcisable"
                                    />
                                </b-form-group>
                                <b-form-group
                                    label="JW Type"
                                    label-for="jwType"
                                >
                                    <v-select
                                        v-model="formData.jwType"
                                        placeholder="Select Type"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="jwTypeOptions"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        input-id="jwType"
                                    />
                                </b-form-group>
                                <b-form-group
                                    label=" "
                                    label-for="selectRound"
                                >
                                    <div class="demo-inline-spacing">
                                        <b-form-radio
                                            name="selectRound"
                                            value="0"
                                            v-model="formData.rounding"
                                        >
                                            None
                                        </b-form-radio>
                                        <b-form-radio
                                            name="selectRound"
                                            value="1"
                                            v-model="formData.rounding"
                                        >
                                            Rounding
                                        </b-form-radio>
                                        <b-form-radio
                                            name="selectRound"
                                            value="2"
                                            v-model="formData.rounding"
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
                                    variant="primary"
                                    type="submit"
                                    class="float-right"
                                >
                                    Update
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
                            :rounding="formData.rounding"
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
                        <job-note-tab
                            :noteDetail="formData.noteDetail"
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
                        <login-tab-details
                            :loginData="formData.loginDetails"
                        />
                    </b-tab>
                    <b-tab>
                        <template #title>
                            <feather-icon
                                icon="FileIcon"
                                size="16"
                                class="mr-0 mr-sm-50"
                            />
                            <span class="d-none d-sm-inline">Report</span>
                        </template>
                        <hr>
                        <report-tab/>
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
    BFormDatepicker,
    BFormCheckbox,
    BButton,
    BTabs,
    BTab,
    BOverlay,
    BInputGroup,
    BInputGroupAppend,
    BFormRadio
} from 'bootstrap-vue'
import BCardCode from '@core/components/b-card-code/BCardCode'
import { ValidationObserver, ValidationProvider } from 'vee-validate'
import { onUnmounted, ref } from '@vue/composition-api'
import formValidation from '@core/comp-functions/forms/form-validation'
import { required } from '@validations'
import vSelect from 'vue-select'
import subContractorTab from './tabs/subContractorTab'
import itemDetailsTab from './tabs/itemDetailsTab'
import billingTermsTab from './tabs/billingTermsTab'
import termsConditionTab from './tabs/termsConditionsTab'
import jobNoteTab from './tabs/jobNoteTab'
import Ripple from 'vue-ripple-directive'
import loginTabDetails from './tabs/loginTabDetails'
import reportTab from './tabs/reportTab'
import axios from '@axios'
import router from '@/router'
import jobWorkStoreModule from '../jobWorkStoreModule'
import store from '@/store'
import { useToast } from 'vue-toastification/composition'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
import Cleave from 'vue-cleave-component'
import { forMatIndianDate, forMatIndianDateAndTime } from '@core/utils/utils'
import { getUserData } from '../../../auth/utils'

export default {
    components: {
        BCardCode,
        ValidationProvider,
        ValidationObserver,
        BForm,
        BRow,
        BCol,
        BFormGroup,
        BFormInput,
        BFormInvalidFeedback,
        BFormDatepicker,
        vSelect,
        BFormCheckbox,
        BButton,
        BTabs,
        BTab,
        subContractorTab,
        itemDetailsTab,
        billingTermsTab,
        termsConditionTab,
        jobNoteTab,
        loginTabDetails,
        reportTab,
        BOverlay,
        Cleave,
        BInputGroup,
        BInputGroupAppend,
        BFormRadio
    },
    directives: {
        Ripple,
    },
    setup() {
        const toast = useToast()

        const ITEMADDON_APP_STORE_MODULE_NAME = 'job-work-order-store-module'
        if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, jobWorkStoreModule)
        onUnmounted(() => {
            if (store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.unregisterModule(ITEMADDON_APP_STORE_MODULE_NAME)
        })

        const showOverlayLoading = ref(false)

        const currentUser = ref(getUserData())

        const jobWorkNoOptions = ref([
            {
                label: '001',
                value: 1
            },
        ])
        const statusOptions = ref([
            {
                label: 'Pending',
                value: 'Pending'
            },
            {
                label: 'Canceled',
                value: 'Canceled'
            },
            {
                label: 'Completed',
                value: 'Completed'
            },
        ])
        const excisableOptions = ref([
            {
                label: 'Yes',
                value: 1
            },
            {
                label: 'No',
                value: 2
            },
        ])
        const jwTypeOptions = ref([
            {
                label: 'Job Work Order',
                value: 1
            },
            {
                label: 'Only Material Issue',
                value: 2
            },
            {
                label: 'Job Work Order 2',
                value: 3
            },
        ])
        const subContractorOptions = ref([])
        axios.get('/api/party/get-master-options')
            .then(res => {
                subContractorOptions.value = res.data.data
            })
        const dateFormat = ref({
            date: true,
            delimiter: '/',
            datePattern: ['d', 'm', 'Y'],
        })

        const formatDates = ref({
            jobWorkDate: null,
        })

        const getJobWorkFormateDate = (date) => {
            formData.value.jobWorkDate = forMatIndianDate(date)
        }

        const formData = ref({
            jobWorkNo: null,
            jobWorkDate: null,
            subContractorId: null,
            subContractorCode: null,
            subContractorName: null,
            status: null,
            isExcisable: null,
            jwType: null,
            rounding: null,
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
                ContractorGstin: null,
                contractorPinCode: null,
                contraPhoneCountry: '+91',
                contraPhoneNo: null,
            },
            noteDetail: {
                jobOrderNote: null,
            },
            loginDetails: {
                createdBy: null,
                dateTime: null,
                lastModifiedBy: null,
                modifiedDateTime: null,
                approvedBy: null,
                approveDate: null,
                stage: 1,
            },
        })
        const refetchData = async () => {
            showOverlayLoading.value = true
            await axios.get(`/api/job-work-order/${router.currentRoute.params.id}`)
                .then(res => {
                    formData.value = res.data.data
                })
            showOverlayLoading.value = false
        }
        refetchData()

        const resetFormData = () => {
            formData.value = JSON.parse(JSON.stringify(formData.value))
        }
        const saveFormData = async () => {
            formData.value.loginDetails.lastModifiedBy = currentUser.value.first_name +' '+ currentUser.value.last_name
            formData.value.loginDetails.modifiedDateTime = forMatIndianDateAndTime(new Date())
            await store.dispatch('job-work-order-store-module/updateJobWorkOrder', formData.value)
                .then(res => {
                    if (res.status === 200) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Job Work Order Updated',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: `You have successfully Updated Job Work Order.`,
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
                })

        }
        const {
            refFormObserver,
            getValidationState,
            resetForm
        } = formValidation(resetFormData)
        return {
            formData,
            resetFormData,
            resetForm,
            getValidationState,
            refFormObserver,
            required,
            showOverlayLoading,
            jobWorkNoOptions,
            statusOptions,
            excisableOptions,
            jwTypeOptions,
            saveFormData,
            refetchData,
            subContractorOptions,
            dateFormat,
            formatDates,
            getJobWorkFormateDate
        }
    }
}
</script>
