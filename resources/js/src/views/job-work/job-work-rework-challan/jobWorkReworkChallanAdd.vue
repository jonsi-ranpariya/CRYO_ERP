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
                                        name="ReWork Challan No"
                                        rules="required"
                                    >
                                        <b-form-group
                                            label="ReWork Challan No"
                                            label-for="reWorkChallanNo"
                                        >
                                            <b-input-group>
                                                <b-form-input
                                                    id="reWorkChallanNo"
                                                    :state="getValidationState(validationContext)"
                                                    v-model="formData.reWorkChallanNo"
                                                />
                                                <b-input-group-append>
                                                    <!--                                                @click="openModal"-->
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
                                    <validation-provider
                                        #default="validationContext"
                                        name="ReWork Challan Date"
                                        rules="required"
                                    >
                                        <b-form-group
                                            label="ReWork Challan Date"
                                            label-for="reWorkChallanDate"
                                        >
                                            <b-input-group>
                                                <cleave
                                                    id="reWorkChallanDate"
                                                    v-model="formData.reWorkChallanDate"
                                                    class="form-control"
                                                    :raw="false"
                                                    :options="dateFormat"
                                                    placeholder="DD/MM/YYYY"
                                                    show-decade-nav
                                                />
                                                <b-input-group-append>
                                                    <b-form-datepicker
                                                        v-model="formatDates.reWorkChallanDate"
                                                        button-only
                                                        @input="getJobReWorkChallanFormateDate($event)"
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
                                        label="Sub-Contractor Code"
                                        label-for="subContractor"
                                    >
                                        <v-select
                                            placeholder="Select Code"
                                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                            :options="subContractorOptions"
                                            :reduce="val => val.value"
                                            :clearable="false"
                                            input-id="subContractorCode"
                                            v-model="formData.subContractor"
                                            @input="getSubContrctorDetails($event)"
                                        />
                                    </b-form-group>
                                </b-col>
                                <b-col md="6">
                                    <b-form-group
                                        label="Sub-Contractor Name"
                                        label-for="subContractorName"
                                    >
                                        <b-form-input
                                            id="subContractorName"
                                            readonly
                                            v-model="formData.subContractorName"
                                        />
                                    </b-form-group>
                                </b-col>
                            </b-row>
                        </b-col>
                        <b-col md="6">
                            <b-form-group
                                label="Job Work No"
                                label-for="jobWorkNo"
                            >
                                <b-form-input
                                    id="jobWorkNo"
                                    v-model="formData.itemJobWorkNo"
                                />
                            </b-form-group>
                            <b-form-group
                                label="Remark"
                                label-for="remark"
                            >
                                <b-form-input
                                    id="remark"
                                    v-model="formData.remark"
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
                        :subContractorDetail="formData.subContractorDetail"
                    />
                </b-tab>
            </b-tabs>
        </b-card-code>

<!--        All Item Modal-->
        <b-modal
            id="jobReWorkChallanModal"
            title="Select Item Detail"
            ref="jobReWorkChallanModal"
            ok-title="submit"
            cancel-variant="danger"
            size="xl"
            no-close-on-backdrop
        >
            <b-table
                :fields="modalTableData.jobReWorkChallanFields"
                :items="modalTableData.jobReWorkChallanData"
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
                        @click="getJobReWorkChallanDetails(data.item)"
                    >
                        Select

                    </b-button>
                </template>

            </b-table>
        </b-modal>
    </div>
</template>
<script>
    import {
        BForm,
        BRow,
        BCol,
        BFormGroup,
        BFormInput,
        BInputGroup,
        BInputGroupAppend,
        BFormInvalidFeedback,
        BButton,
        BFormDatepicker,
        BTab,
        BTabs,
        BTable
    } from 'bootstrap-vue'
    import BCardCode from "../../../@core/components/b-card-code/BCardCode";
    import {ValidationObserver, ValidationProvider} from 'vee-validate'
    import {onUnmounted, ref} from "@vue/composition-api";
    import formValidation from "../../../@core/comp-functions/forms/form-validation";
    import axios from '@axios'
    import vSelect from 'vue-select'
    import subContractorTab from "./tabs/subConractorTab"
    import router from "@/router"
    import {useToast} from "vue-toastification/composition";
    import jobWorkStoreModule from "../jobWorkStoreModule";
    import store from '@/store'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import {required} from '@validations'
    import {forMatIndianDate} from "../../../@core/utils/utils";
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
            BInputGroup,
            BInputGroupAppend,
            BFormInvalidFeedback,
            BButton,
            BFormDatepicker,
            vSelect,
            BTab,
            BTabs,
            BTable,
            subContractorTab,
            Cleave
        },
        setup({jobReWorkChallanModal}) {

            jobReWorkChallanModal = ref()

            const toast = useToast()
            const ITEMADDON_APP_STORE_MODULE_NAME = 'job-rework-challan-store-module'
            if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, jobWorkStoreModule)
            onUnmounted(() => {
                if (store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.unregisterModule(ITEMADDON_APP_STORE_MODULE_NAME)
            })

            const isModalTableBusy = ref(false)

            const subContractorOptions = ref([])
            axios.get('/api/party/get-master-options').then(res => {
                subContractorOptions.value = res.data.data
            })

            const dateFormat = ref({
                date: true,
                delimiter: '/',
                datePattern: ['d', 'm', 'Y'],
            })

            const formatDates = ref({
                reWorkChallanDate: null,
            })

            const getJobReWorkChallanFormateDate = (date) => {
                formData.value.reWorkChallanDate = forMatIndianDate(date)
            }

            const modalTableData = ref({
                jobReWorkChallanFields: [
                    {
                        key: 'selectButton',
                        label: ''
                    },
                    {
                        key: 'jobWorkNo',
                        label: 'Job Work No'
                    },
                    {
                        key: 'subContractorName',
                        label: 'party Name'
                    },
                    {
                        key: 'subContractorName',
                        label: 'party Name'
                    },
                    {
                        key: 'city_details.city',
                        label: 'party City'
                    },
                    {
                        key: 'jobWorkDate',
                        label: 'Job Work Date'
                    },
                    {
                        key: 'netAmount',
                        label: 'JW Net Amount'
                    },
                    {
                        key: 'grossAmount',
                        label: 'JW Gross Amount'
                    },
                ],
                jobReWorkChallanData: [],
            })

            const openModal = () => {
                axios.get('/api/job-work-order').then(res => {
                    modalTableData.value.jobReWorkChallanData = res.data.data
                })
                jobReWorkChallanModal.value.show();
            }

            const getJobReWorkChallanDetails = async (data) => {
                formData.value.jobWorkId = data._id
                formData.value.reWorkChallanNo = data.jobWorkNo
                formData.value.reWorkChallanDate = data.jobWorkDate
                formData.value.subContractorId = data.subContractorId
                formData.value.subContractor = data.subContractorDetails.subContractorCode
                formData.value.subContractorName = data.subContractorDetails.subContractorName
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
                formData.value.subContractorCode = data._id
                jobReWorkChallanModal.value.hide()
            }
            const getSubContrctorDetails = async (id) => {
                await axios.get(`/api/party/edit/${id}`).then(res => {
                    formData.value.subContractorName = res.data.data?.partyName ?? null
                })
            }
            const blankFormData = {
                jobWorkId:null,
                reWorkChallanNo: null,
                reWorkChallanDate: forMatIndianDate(),
                subContractorId:null,
                subContractor: null,
                subContractorName: null,
                itemJobWorkNo: null,
                remark: null,
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
            }

            const formData = ref(JSON.parse(JSON.stringify(blankFormData)))

            const resetFormData = () => {
                formData.value = JSON.parse(JSON.stringify(blankFormData))
            }
            const saveFormData = async () => {
                await store.dispatch('job-rework-challan-store-module/addJobReWorkChallan', formData.value).then(res => {
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
                        name: 'edit-job-work-rework-challan',
                        params: {
                            id: res.data.data._id
                        }
                    })
                })
            }
            const {refFormObserver, getValidationState, resetForm} = formValidation(resetFormData)
            return {
                formData,
                resetFormData,
                refFormObserver,
                getValidationState,
                resetForm,
                subContractorOptions,
                getSubContrctorDetails,
                saveFormData,
                required,
                openModal,
                jobReWorkChallanModal,
                modalTableData,
                isModalTableBusy,
                getJobReWorkChallanDetails,
                dateFormat,
                formatDates,
                getJobReWorkChallanFormateDate
            }
        }
    }
</script>
