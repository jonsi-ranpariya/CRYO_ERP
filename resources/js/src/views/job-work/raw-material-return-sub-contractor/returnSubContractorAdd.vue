<template>
    <div>
        <b-card-code>
            <validation-observer #default="{handleSubmit}">
                <b-form @submit.prevent="handleSubmit(saveFormData)">
                    <b-row>
                        <b-col md="6">
                            <b-row>
                                <b-col md="6">
                                    <validation-provider
                                        #default="validationContext"
                                        name="Return No."
                                        rules=""
                                    >
                                        <b-form-group
                                            label="Return No."
                                            label-for="returnNo"
                                        >
                                            <b-form-input
                                                id="returnNo"
                                                v-model="formData.returnNo"
                                                :state="getValidationState(validationContext)"
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
                                        name="Return Date"
                                        rules="required"
                                    >
                                        <b-form-group
                                            label="Return Date"
                                            label-for="returnDate"
                                        >
                                            <b-input-group>
                                                <cleave
                                                    id="returnDate"
                                                    v-model="formData.returnDate"
                                                    class="form-control"
                                                    :raw="false"
                                                    :options="dateFormat"
                                                    placeholder="DD/MM/YYYY"
                                                    show-decade-nav
                                                />
                                                <b-input-group-append>
                                                    <b-form-datepicker
                                                        v-model="formatDates.returnDate"
                                                        button-only
                                                        @input="getJobWorkRawMaterialFormateDate($event)"
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
                                        name="Job Work No"
                                        rules="required"
                                    >
                                        <b-form-group
                                            label="Job Work No"
                                            label-for="jobWorkNo"
                                        >
                                            <b-input-group>
                                                <b-form-input
                                                    id="jobWorkNo"
                                                    :state="getValidationState(validationContext)"
                                                    v-model="formData.jobWorkNo"

                                                />
                                                <b-input-group-append>
                                                    <!--                                                    @click="openModal"-->
                                                    <b-button variant="primary" @click="openModal">...</b-button>
                                                </b-input-group-append>
                                            </b-input-group>
                                            <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                                {{ validationContext.errors[0] }}
                                            </b-form-invalid-feedback>
                                        </b-form-group>
                                    </validation-provider>
                                </b-col>
                                <b-col md="6">
                                    <b-form-group
                                        label="JW Challan No."
                                        label-for="jwChallanNo"
                                    >
                                        <b-form-input
                                            id="jwChallanNo"
                                            v-model="formData.jwChallanNo"
                                        />
                                    </b-form-group>
                                </b-col>
                            </b-row>
                        </b-col>
                        <b-col md="6">
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
                                                v-model="formData.subContractorCode"
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
                                        label="Sub Contractor Name"
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
                        </b-col>   <!--Button-->
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
                        :subContractorDetail="formData.subContractorDetail"
                    />
                </b-tab>
            </b-tabs>
        </b-card-code>
        <!--All Raw Material Modal-->
        <b-modal
            id="rawMaterialModal"
            title="Select Item Detail"
            ref="rawMaterialModal"
            ok-title="submit"
            cancel-variant="danger"
            size="xl"
            no-close-on-backdrop
        >
            <b-table
                :fields="modalTableData.rawMaterialFields"
                :items="modalTableData.rawMaterialData"
                :no-border-collapse="false"
                responsive
                bordered
                hover
                ok-title="submit"
                cancel-variant="danger"
                size="lg"
                no-close-on-backdrop
                show-empty
                :busy="isModalTableBusy"
            >
                <!-- Loader -->
                <template #table-busy>
                    <div class="text-center my-2">
                        <b-spinner class="align-middle"></b-spinner>
                        <strong>Loading...</strong>
                    </div>
                </template>
                <!-- Index -->
                <template #cell(srNo)="data">
                    {{ data.index + 1 }}
                </template>
                <!-- Empty Text -->
                <template #empty="scope">
                    <h5 class="text-center text-uppercase">No Items Available</h5>
                </template>
                <template #cell(selectButton)="data">
                    <b-button
                        type="button"
                        size="sm"
                        variant="primary"
                        @click="getRawMaterialDetails(data.item)"
                    >
                        Select

                    </b-button>
                </template>

            </b-table>
        </b-modal>
    </div>
</template>
<script>
import BCardCode from '../../../@core/components/b-card-code/BCardCode'
import { ValidationObserver, ValidationProvider } from 'vee-validate'
import { required } from '@validations'
import {
    BForm,
    BRow,
    BCol,
    BFormGroup,
    BFormInput,
    BFormInvalidFeedback,
    BFormDatepicker,
    BFormTimepicker,
    BButton,
    BInputGroup,
    BInputGroupAppend,
    BTab,
    BTabs,
    BTable
} from 'bootstrap-vue'
import { onUnmounted, ref } from '@vue/composition-api'
import formValidation from '@core/comp-functions/forms/form-validation'
import axios from '@axios'
import vSelect from 'vue-select'
import router from '@/router'
import store from '@/store'
import { useToast } from 'vue-toastification/composition'
import jobWorkStoreModule from '../jobWorkStoreModule'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
import subContractorTab from './tabs/subContractorTab'
import { getUserData } from '../../../auth/utils'
import moment from 'moment'
import { forMatIndianDate } from '@core/utils/utils'
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
        BFormDatepicker,
        BFormTimepicker,
        BButton,
        BInputGroup,
        BInputGroupAppend,
        vSelect,
        BTab,
        BTabs,
        BTable,
        subContractorTab,
        Cleave
    },
    setup({ rawMaterialModal }) {
        rawMaterialModal = ref()

        const toast = useToast()
        const ITEMADDON_APP_STORE_MODULE_NAME = 'raw-material-store-module'
        if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, jobWorkStoreModule)
        onUnmounted(() => {
            if (store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.unregisterModule(ITEMADDON_APP_STORE_MODULE_NAME)
        })
        const subContractorOptions = ref([])
        axios.get('/api/party/get-master-options')
            .then(res => {
                subContractorOptions.value = res.data.data
            })
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
        const isModalTableBusy = ref(false)

        const dateFormat = ref({
            date: true,
            delimiter: '/',
            datePattern: ['d', 'm', 'Y'],
        })

        const formatDates = ref({
            returnDate: null,
        })

        const getJobWorkRawMaterialFormateDate = (date) => {
            formData.value.returnDate = forMatIndianDate(date)
        }
        const modalTableData = ref({
            rawMaterialFields: [
                {
                    key: 'selectButton',
                    label: ''
                },
                {
                    key: 'jobWorkNo',
                    label: 'Job Work No'
                },
                {
                    key: 'subContractorCode',
                    label: 'Party Code'
                },
                {
                    key: 'subContractorName',
                    label: 'Party Name'
                },
                {
                    key: 'jobWorkDate',
                    label: 'Job Date'
                },
                {
                    key: 'status',
                    label: 'Satatus'
                },
                {
                    key: 'created_by',
                    label: 'Created By'
                },
            ],
            rawMaterialData: [],
        })

        const openModal = () => {
            axios.get('/api/job-work-order')
                .then(res => {
                    modalTableData.value.rawMaterialData = res.data.data
                })
            rawMaterialModal.value.show()
        }

        const getRawMaterialDetails = async (data) => {
            formData.value.jobWorkId = data?._id ?? null
            formData.value.jobWorkNo = data.jobWorkNo
            formData.value.subContractorCode = data.subContractorCode
            formData.value.subContractorName = data.subContractorName
            formData.value.jwType = data.jwType
            formData.value.subContractorId = data?.subContractorId ?? null
            formData.value.subContractorDetail.subContractorCode = data.subContractorDetails.subContractorCode
            formData.value.subContractorDetail.subContractorName = data.subContractorDetails.subContractorName
            formData.value.subContractorDetail.contractorAddress = data.subContractorDetails.contractorAddress
            formData.value.subContractorDetail.contractorCountry = data.subContractorDetails.contractorCountry
            formData.value.subContractorDetail.contractorState = data.subContractorDetails.contractorState
            formData.value.subContractorDetail.contractorCity = data.subContractorDetails.contractorCity
            formData.value.subContractorDetail.contractorFaxNo = data.subContractorDetails.contractorFaxNo
            formData.value.subContractorDetail.ContractorEmailId = data.subContractorDetails.ContractorEmailId
            formData.value.subContractorDetail.contractorWebsite = data.subContractorDetails.contractorWebsite
            formData.value.subContractorDetail.contractorPinCode = data.subContractorDetails.contractorPinCode
            formData.value.subContractorDetail.contraPhoneCountry = data.subContractorDetails.contraPhoneCountry
            formData.value.subContractorDetail.contraPhoneNo = data.subContractorDetails.contraPhoneNo
            rawMaterialModal.value.hide()
        }

        const getSubContrctorDetails = async (id) => {
            await axios.get(`/api/party/edit/${id}`)
                .then(res => {
                    // formData.value.subContractorName = res.data.data?.partyName ?? null
                    formData.value.subContractorDetails.subContractorCode = res.data.data?.partyCode ?? null
                })
        }

        const CurrentUserData = ref(getUserData())

        const blankFormData = {
            returnNo: null,
            returnDate: null,
            jobWorkId:null,
            subContractorId:null,
            jobWorkNo: null,
            jwChallanNo: null,
            subContractorCode: null,
            subContractorName: null,
            jwType: null,
            subContractorDetail: {
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
            remarkDetails: {
                remark: null,
            },
            loginDetails: {
                createdBy: CurrentUserData.value.first_name + ' ' + CurrentUserData.value.last_name,
                dateTime: moment(new Date()).format('DD/MM/YYYY HH:mm'),
                lastModifiedBy: null,
                modifiedDateTime: null,
                approvedBy: null,
                approveDate: null,
            },
        }

        const formData = ref(JSON.parse(JSON.stringify(blankFormData)))

        const resetFormData = () => {
            formData.value = JSON.parse(JSON.stringify(blankFormData))
        }

        const saveFormData = async () => {
            await store.dispatch('raw-material-store-module/addRawMaterial', formData.value)
                .then(res => {
                    if (res.status === 200) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Issue Job Work Challan Added',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: `You have successfully Added Issue Job Challan.`,
                            },
                        })
                        router.push({
                            name: 'edit-return-sub-contractor',
                            params: {
                                id: res.data.data._id
                            }
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
            refFormObserver,
            getValidationState,
            resetForm,
            jwTypeOptions,
            subContractorOptions,
            required,
            saveFormData,
            openModal,
            isModalTableBusy,
            modalTableData,
            getRawMaterialDetails,
            rawMaterialModal,
            getSubContrctorDetails,
            dateFormat,
            formatDates,
            getJobWorkRawMaterialFormateDate

        }
    }

}
</script>
