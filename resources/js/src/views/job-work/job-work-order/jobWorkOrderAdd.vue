<template>
    <div>
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
                                                @input="getSubContrctorDetails($event)"
                                                :state="getValidationState(validationContext)"
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
                                            readonly
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
                                Save
                            </b-button>
                        </b-col>
                    </b-row>
                </b-form>
            </validation-observer>
        </b-card-code>
        <b-card-code>
            <b-tabs pills>
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
            </b-tabs>
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
    BFormRadio,
    BButton,
    BTabs,
    BTab,
    BInputGroup,
    BInputGroupAppend,
} from 'bootstrap-vue'
import BCardCode from '../../../@core/components/b-card-code/BCardCode'
import { ValidationObserver, ValidationProvider } from 'vee-validate'
import { onUnmounted, ref } from '@vue/composition-api'
import formValidation from '../../../@core/comp-functions/forms/form-validation'
import { required } from '@validations'
import vSelect from 'vue-select'
import subContractorTab from './tabs/subContractorTab'
import router from '@/router'
import axios from '@axios'
import { forMatIndianDate, getTcTodayDate } from '@core/utils/utils'
import { useToast } from 'vue-toastification/composition'
import store from '@/store'
import jobWorkStoreModule from '../jobWorkStoreModule'
import Ripple from 'vue-ripple-directive'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
import { getUserData } from '../../../auth/utils'
import moment from 'moment'
import Cleave from 'vue-cleave-component'

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
        BFormRadio,
        BButton,
        BTabs,
        BTab,
        BInputGroup,
        BInputGroupAppend,
        subContractorTab,
        Cleave
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

        const subContractorOptions = ref([])
        axios.get('/api/party/get-master-options')
            .then(res => {
                subContractorOptions.value = res.data.data
            })
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
        const getSubContrctorDetails = async (id) => {
            await axios.get(`/api/party/edit/${id}`)
                .then(res => {
                    formData.value.subContractorName = res.data.data?.partyName ?? null
                    formData.value.subContractorCode = res.data.data?.partyCode ?? null
                    formData.value.subContractorDetails.subContractorCode = id ?? null
                    formData.value.subContractorDetails.subContractorName = res.data.data?.partyName ?? null
                    formData.value.subContractorDetails.contractorAddress = res.data.data?.partyDetails?.partyAddress ?? null
                    formData.value.subContractorDetails.contractorCountry = res.data.data?.partyDetails?.partyCountry?.value ?? null
                    formData.value.subContractorDetails.contractorState = res.data.data?.partyDetails?.partyState?.value ?? null
                    formData.value.subContractorDetails.contractorCity = res.data.data?.partyDetails?.partyCity?.value ?? null
                    formData.value.subContractorDetails.contractorFaxNo = res.data.data?.partyDetails?.partyFaxNo ?? null
                    formData.value.subContractorDetails.ContractorEmailId = res.data.data?.partyDetails?.partyEmilId ?? null
                    formData.value.subContractorDetails.contractorWebsite = res.data.data?.partyDetails?.partyWebsite ?? null
                    formData.value.subContractorDetails.ContractorGstin = res.data.data?.taxDetails?.gstin ?? null
                    formData.value.subContractorDetails.contractorPinCode = res.data.data?.partyDetails?.partyPinCode ?? null
                    formData.value.subContractorDetails.contraPhoneCountry = res.data.data?.partyDetails?.partyCountryCode ?? null
                    formData.value.subContractorDetails.contraPhoneNo = res.data.data?.partyDetails?.partyPhoneNo ?? null
                })
        }

        const CurrentUserData = ref(getUserData())

        const blankFormData = {
            jobWorkNo: null,
            jobWorkDate: forMatIndianDate(getTcTodayDate()),
            subContractorId: null,
            subContractorCode: null,
            subContractorName: null,
            status: null,
            isExcisable: null,
            jwType: null,
            rounding: 0,
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
                createdBy: CurrentUserData.value.first_name + ' ' + CurrentUserData.value.last_name,
                dateTime: moment(new Date())
                    .format('DD/MM/YYYY HH:mm'),
                lastModifiedBy: null,
                modifiedDateTime: null,
                approvedBy: null,
                approveDate: null,
                stage: 1,
            },
        }

        const formData = ref(JSON.parse(JSON.stringify(blankFormData)))

        const resetFormData = () => {
            formData.value = JSON.parse(JSON.stringify(blankFormData))
        }
        const saveFormData = async () => {
            await store.dispatch('job-work-order-store-module/addJobWorkOrder', formData.value)
                .then(res => {
                    if (res.status === 200) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Job Work Order Added',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: `You have successfully Added Job Order.`,
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
                        name: 'edit-job-work-order',
                        params: {
                            id: res.data.data._id
                        }
                    })
                })
        }

        const {
            refFormObserver,
            getValidationState,
            resetForm
        } = formValidation(resetFormData)
        return {
            formData,
            refFormObserver,
            getValidationState,
            resetForm,
            required,
            resetFormData,
            subContractorOptions,
            statusOptions,
            excisableOptions,
            jwTypeOptions,
            saveFormData,
            getSubContrctorDetails,
            dateFormat,
            formatDates,
            getJobWorkFormateDate

        }
    }
}
</script>
