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
                                        name="Job Work Date"
                                        rules="required"
                                    >
                                        <b-form-group
                                            label="Job Work Date"
                                            label-for="jobWorkDate"
                                            :state="getValidationState(validationContext)"
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
                                        name="Challan No"
                                        rules=""
                                    >
                                        <b-form-group
                                            label="Challan No"
                                            label-for="challanNo"
                                        >
                                            <b-form-input
                                                v-model="formData.challanNo"
                                                id="challanNo"
                                                type="number"
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
                                        name="Challan Date"
                                        rules="required"
                                    >
                                        <b-form-group
                                            label="Challan Date"
                                            label-for="challanDate"
                                            :state="getValidationState(validationContext)"
                                        >
                                            <b-input-group>
                                                <cleave
                                                    id="challanDate"
                                                    v-model="formData.challanDate"
                                                    class="form-control"
                                                    :raw="false"
                                                    :options="dateFormat"
                                                    placeholder="DD/MM/YYYY"
                                                    show-decade-nav
                                                />
                                                <b-input-group-append>
                                                    <b-form-datepicker
                                                        v-model="formatDates.challanDate"
                                                        button-only
                                                        @input="getJobWorkChallanFormateDate($event)"
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
                                                v-model="formData.subContractorId"
                                                @input="getSubContrctorDetails($event)"
                                                :state="getValidationState(validationContext)"
                                            />
                                            <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                                {{validationContext.errors[0]}}
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
                            <b-row>
                                <b-col md="6">
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
                                </b-col>
                                <b-col md="6">
                                    <b-form-group
                                        label="Time Of Issue"
                                        label-for="timeOfIssue"
                                    >
                                        <b-form-timepicker
                                            id="timeIssueInvoice"
                                            locale="en"
                                            v-model="formData.timeOfIssue"
                                        />
                                   </b-form-group>
                                </b-col>
                            </b-row>
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

        <!--All Item Modal-->
        <b-modal
            id="itemMasterModal"
            title="Select Item Detail"
            ref="itemMasterModal"
            ok-title="submit"
            cancel-variant="danger"
            size="xl"
            no-close-on-backdrop
        >
            <b-table
                :fields="modalTableData.itemMasterFields"
                :items="modalTableData.itemMasterData"
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
                        @click="getJobOrderDetails(data.item)"
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
        BFormInvalidFeedback,
        BFormDatepicker,
        BFormTimepicker,
        BButton,
        BTabs,
        BTab,
        BInputGroup,
        BInputGroupAppend,
        BTable
    } from 'bootstrap-vue'
    import BCardCode from "../../../@core/components/b-card-code/BCardCode";
    import {ValidationObserver, ValidationProvider} from 'vee-validate'
    import formValidation from "../../../@core/comp-functions/forms/form-validation";
    import {onUnmounted, ref} from "@vue/composition-api";
    import {required} from '@validations'
    import vSelect from 'vue-select'
    import subContractorTab from "./tabs/subContractorTab";
    import router from '@/router'
    import axios from '@axios'
    import {forMatIndianDate, getTcTodayDate} from "../../../@core/utils/utils";
    import store from '@/store'
    import {useToast} from "vue-toastification/composition";
    import jobWorkStoreModule from "../jobWorkStoreModule";
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import Cleave from 'vue-cleave-component'
    import moment from "moment";
    import _ from "moment";

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
            vSelect,
            BFormTimepicker,
            BButton,
            BTabs,
            BTab,
            subContractorTab,
            BInputGroup,
            BInputGroupAppend,
            BTable,
            Cleave
        },
        setup({itemMasterModal}){
            itemMasterModal = ref()
            const isModalTableBusy = ref(false)
            const toast = useToast()
            const ITEMADDON_APP_STORE_MODULE_NAME = 'issue-job-work-challan-store-module'
            if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, jobWorkStoreModule)
            onUnmounted(() => {
                if (store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.unregisterModule(ITEMADDON_APP_STORE_MODULE_NAME)
            })

            setTimeout(() => {
                if (!formData.value.timeOfIssue) {
                    formData.value.timeOfIssue = _(new Date(), 'hh:mm:ss A').format('HH:mm:ss');
                }
            }, 1000);

            const dateFormat = ref({
                date: true,
                delimiter: '/',
                datePattern: ['d', 'm', 'Y'],
            })

            const formatDates = ref({
                jobWorkDate: null,
                challanDate: null,
            })

            const getJobWorkFormateDate = (date) => {
                formData.value.jobWorkDate = forMatIndianDate(date)
            }
            const getJobWorkChallanFormateDate = (date) => {
                formData.value.challanDate = forMatIndianDate(date)
            }

            const modalTableData = ref ({
                itemMasterFields:[
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
                        key: 'city_details.city',
                        label: 'party city'
                    },
                    {
                        key: 'jobWorkDate',
                        label: 'Job Work Date'
                    },
                    {
                        key: 'net_amount',
                        label: 'Job Work NetAmount'
                    },
                    {
                        key: 'gross_amount',
                        label: 'Job Work GrossAmount'
                    },

                ],
                itemMasterData: [],
            })

            const subContractorOptions = ref([])
            axios.get('/api/party/get-master-options').then(res => {
                subContractorOptions.value = res.data.data
            })
            const jwTypeOptions = ref([
                {label: 'Job Work Order', value: 1},
                {label: 'Only Material Issue', value: 2},
                {label: 'Job Work Order 2', value: 3},
            ])
            const openModal =  () =>{
                 axios.get('/api/job-work-order').then(res => {
                     modalTableData.value.itemMasterData = res.data.data
                })
                itemMasterModal.value.show();
            }
            const getJobOrderDetails = async (data) => {
                formData.value.jobWorkId = data._id
                formData.value.jobWorkNo = data.jobWorkNo
                formData.value.jobWorkDate = data.jobWorkDate
                formData.value.subContractorId = data.subContractorId
                formData.value.subContractorCode = data.subContractorCode
                formData.value.subContractorName = data.subContractorName
                formData.value.subContractorDetails.subContractorCode = data.subContractorDetails.subContractorCode
                formData.value.subContractorDetails.subContractorName = data.subContractorDetails.subContractorName
                formData.value.subContractorDetails.contractorAddress = data.subContractorDetails.contractorAddress
                formData.value.subContractorDetails.contractorCountry = data.subContractorDetails.contractorCountry
                formData.value.subContractorDetails.contractorState = data.subContractorDetails.contractorState
                formData.value.subContractorDetails.contractorCity = data.subContractorDetails.contractorCity
                formData.value.subContractorDetails.contractorFaxNo = data.subContractorDetails.contractorFaxNo
                formData.value.subContractorDetails.ContractorEmailId = data.subContractorDetails.ContractorEmailId
                formData.value.subContractorDetails.contractorWebsite = data.subContractorDetails.contractorWebsite
                formData.value.subContractorDetails.ContractorGstin = data.subContractorDetails.ContractorGstin
                formData.value.subContractorDetails.contractorPinCode = data.subContractorDetails.contractorPinCode
                formData.value.subContractorDetails.contraPhoneCountry = data.subContractorDetails.contraPhoneCountry
                formData.value.subContractorDetails.contraPhoneNo = data.subContractorDetails.contraPhoneNo
                itemMasterModal.value.hide()
            }
            const getSubContrctorDetails = async (id) => {
                await axios.get(`/api/party/edit/${id}`).then(res => {
                    // formData.value.subContractorName = res.data.data?.partyName ?? null
                    formData.value.subContractorDetails.subContractorCode = res.data.data?.partyCode ?? null
                })
            }

            const blankFormData = {
                jobWorkId:null,
                jobWorkNo: null,
                jobWorkDate:forMatIndianDate(getTcTodayDate()),
                challanNo: null,
                challanDate: forMatIndianDate(getTcTodayDate()),
                subContractorId: null,
                subContractorCode: null,
                subContractorName: null,
                jwType: null,
                timeOfIssue: null,
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
                noteDetails: {
                    jobChallanRemark: null,
                },
            }
            const formData = ref(JSON.parse(JSON.stringify(blankFormData)))

            const resetFormData = () => {
                formData.value = JSON.parse(JSON.stringify(blankFormData))
            }
            const saveFormData = async () => {
                await store.dispatch('issue-job-work-challan-store-module/addIssueJobWorkOrderChallan', formData.value).then(res => {
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
                        name: 'edit-issue-job-work-challan',
                        params: {
                            id: res.data.data._id
                        }
                    })
                })
            }
            const {refFormObserver, getValidationState, resetForm} = formValidation(resetFormData)
            return {
                formData,
                refFormObserver,
                getValidationState,
                resetForm,
                resetFormData,
                saveFormData,
                subContractorOptions,
                jwTypeOptions,
                required,
                getSubContrctorDetails,
                getJobOrderDetails,
                isModalTableBusy,
                modalTableData,
                openModal,
                itemMasterModal,
                dateFormat,
                formatDates,
                getJobWorkFormateDate,
                getJobWorkChallanFormateDate,
                // timeFormate
            }
        }
    }
</script>
