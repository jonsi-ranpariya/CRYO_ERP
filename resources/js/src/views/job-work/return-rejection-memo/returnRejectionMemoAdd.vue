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
                                        name="Job Work Return No"
                                        rules=""
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
                                    readonly
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
                        :subContractorDetails.sync="formData.subContractorDetails"
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
    BButton,
    BFormDatepicker,
    BTabs,
    BTab,
    BInputGroup,
    BInputGroupAppend
} from 'bootstrap-vue'
import BCardCode from '../../../@core/components/b-card-code/BCardCode'
import { ValidationObserver, ValidationProvider } from 'vee-validate'
import { required } from '@validations'
import { onUnmounted, ref } from '@vue/composition-api'
import formValidation from '../../../@core/comp-functions/forms/form-validation'
import vSelect from 'vue-select'
import subContractorTab from './tabs/subContractorTab'
import router from '@/router'
import axios from '@axios'
import moment from 'moment'
import { getUserData } from '../../../auth/utils'
import store from '@/store'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
import { useToast } from 'vue-toastification/composition'
import jobWorkStoreModule from '../jobWorkStoreModule'
import { forMatIndianDate, forMatIndianDateAndTime } from '@core/utils/utils'
import Cleave from 'vue-cleave-component'

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
        subContractorTab,
        Cleave,
        BInputGroup,
        BInputGroupAppend
    },
    setup() {
        const toast = useToast()
        const ITEMADDON_APP_STORE_MODULE_NAME = 'return-memo-store-module'
        if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, jobWorkStoreModule)
        onUnmounted(() => {
            if (store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.unregisterModule(ITEMADDON_APP_STORE_MODULE_NAME)
        })

        const subContractorOption = ref([])
        axios.get('/api/party/get-master-options')
            .then(res => {
                subContractorOption.value = res.data.data
            })

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

        const CurrentUserData = ref(getUserData())
        const blankFormData = {
            jobWorkReturnNo: null,
            jobWorkReturnDate: forMatIndianDate(new Date()),
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
                createdBy: CurrentUserData.value.first_name + ' ' + CurrentUserData.value.last_name,
                dateTime: forMatIndianDateAndTime(new Date()),
                lastModifiedBy: null,
                modifiedDateTime: null,
            },
        }
        const kindAttnOption = ref([])

        const getSubContrctorDetails = async (id) => {
            await axios.get(`/api/party/edit/${id}`)
                .then(res => {
                    formData.value.subContractorName = res.data.data?.partyName ?? null
                    formData.value.subContractorCode = res.data.data?.partyCode ?? null
                    formData.value.subContractorDetails.subContractorCode = id
                    formData.value.subContractorDetails.subContractorName = res.data.data?.partyName ?? null
                    formData.value.subContractorDetails.contractorAddress = res.data.data?.partyDetails?.partyAddress ?? null
                    formData.value.subContractorDetails.contractorCountry = res.data.data?.partyDetails?.partyCountry?.value ?? null
                    formData.value.subContractorDetails.contractorState = res.data.data?.partyDetails?.partyState?.value ?? null
                    formData.value.subContractorDetails.contractorCity = res.data.data?.partyDetails?.partyCity?.value ?? null
                    formData.value.subContractorDetails.contractorFaxNo = res.data.data?.partyDetails?.partyFaxNo ?? null
                    formData.value.subContractorDetails.ContractorEmailId = res.data.data?.partyDetails?.partyEmilId ?? null
                    formData.value.subContractorDetails.contractorWebsite = res.data.data?.partyDetails?.partyWebsite ?? null
                    formData.value.subContractorDetails.contractorPinCode = res.data.data?.partyDetails?.partyPinCode ?? null
                    formData.value.subContractorDetails.contraPhoneCountry = res.data.data?.partyDetails?.partyCountryCode ?? null
                    formData.value.subContractorDetails.contraPhoneNo = res.data.data?.partyDetails?.partyPhoneNo ?? null
                })
            formData.value.kindAttnId = null

            await axios.get(`/api/party/get-party-contacts-options/${id}`)
                .then(res => {
                    kindAttnOption.value = res.data.data
                })
        }

        const formData = ref(JSON.parse(JSON.stringify(blankFormData)))
        const resetFormData = () => {
            formData.value = JSON.parse(JSON.stringify(blankFormData))
        }

        const saveFormData = async () => {
            await store.dispatch('return-memo-store-module/addRerunRejectionMemo', formData.value)
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
                        name: 'edit-return-rejection-memo',
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
            refFormObserver,
            getValidationState,
            resetForm,
            resetFormData,
            formData,
            required,
            subContractorOption,
            kindAttnOption,
            saveFormData,
            getSubContrctorDetails,
            dateFormat,
            formatDates,
            getJobWorkRejectionMemoFormateDate
        }
    }
}
</script>
