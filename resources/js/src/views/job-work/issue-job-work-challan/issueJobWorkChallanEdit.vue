<template>
    <div>
        <b-overlay
            :show="showOverlayLoading"
            rounded="sm"
        >
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
                                                <v-select
                                                    placeholder="Select No"
                                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                                    :options="jobNoOptions"
                                                    :reduce="val => val.value"
                                                    :clearable="false"
                                                    input-id="jobWorkNo"
                                                    v-model="formData.jobWorkNo"
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
                                        <validation-provider
                                            #default="validationContext"
                                            name="Job Work Date"
                                            rules=""
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
                                            rules=""
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
                                            <b-input-group>
                                                <cleave
                                                    v-model="formData.timeOfIssue"
                                                    class="form-control"
                                                    :raw="false"
                                                    :options="timeFormate"
                                                    placeholder="HH:mm:ss"
                                                    show-decade-nav
                                                />
                                                <b-input-group-append>
                                                    <b-form-timepicker
                                                        v-model="formData.timeOfIssue"
                                                        type="time"
                                                        button-only
                                                        right
                                                        show-seconds
                                                        locale="en"
                                                        aria-controls="timeOfIssue"
                                                    ></b-form-timepicker>
                                                </b-input-group-append>
                                            </b-input-group>
<!--                                            <b-form-timepicker-->
<!--                                                v-model="formData.timeOfIssue"-->
<!--                                                id="timeOfIssue"-->
<!--                                                show-seconds-->
<!--                                                locale="en"-->
<!--                                            />-->
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
                                icon="EditIcon"
                                size="16"
                                class="mr-0 mr-sm-50"
                            />
                            <span class="d-none d-sm-inline">Note</span>
                        </template>
                        <hr>
                        <note-details-tab
                            :noteDetails="formData.noteDetails"
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
                        <report-tab
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
        BFormDatepicker,
        BFormTimepicker,
        BButton,
        BTabs,
        BTab,
        BOverlay,
        BInputGroup,
        BInputGroupAppend
    } from 'bootstrap-vue'
    import BCardCode from "../../../@core/components/b-card-code/BCardCode";
    import {ValidationObserver, ValidationProvider} from 'vee-validate'
    import formValidation from "../../../@core/comp-functions/forms/form-validation";
    import {onUnmounted, ref} from "@vue/composition-api";
    import {required} from '@validations'
    import vSelect from 'vue-select'
    import subContractorTab from "./tabs/subContractorTab";
    import itemDetailsTab from "./tabs/itemDetailsTab";
    import noteDetailsTab from "./tabs/noteDetailsTab";
    import reportTab from "./tabs/reportTab";
    import Ripple from "vue-ripple-directive";
    import axios from "@axios"
    import router from '@/router'
    import {useToast} from "vue-toastification/composition";
    import jobWorkStoreModule from "../jobWorkStoreModule";
    import store from '@/store'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import Cleave from 'vue-cleave-component'
    import {forMatIndianDate} from "../../../@core/utils/utils";

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
            BOverlay,
            subContractorTab,
            itemDetailsTab,
            noteDetailsTab,
            reportTab,
            Cleave,
            BInputGroup,
            BInputGroupAppend
        },
        directives: {
            Ripple,
        },
        setup() {
            const toast = useToast()

            const ITEMADDON_APP_STORE_MODULE_NAME = 'issue-job-work-challan-store-module'
            if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, jobWorkStoreModule)
            onUnmounted(() => {
                if (store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.unregisterModule(ITEMADDON_APP_STORE_MODULE_NAME)
            })

            const showOverlayLoading = ref(false)
            const jobNoOptions = ref([])
            axios.get('/api/get-job-work-order-option').then(res => {
                jobNoOptions.value = res.data.data
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
            const timeFormate = ref({
                time: true,
                delimiter: ':',
                datePattern: ['hh', 'mm', 'ss'],
            })

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
            const formData = ref({
                jobWorkNo: null,
                jobWorkDate: null,
                challanNo: null,
                challanDate: null,
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
            })
            const refetchData = async () => {
                showOverlayLoading.value = true
                await axios.get(`/api/issue-job-work-challan/${router.currentRoute.params.id}`).then(res => {
                    formData.value = res.data.data
                })
                showOverlayLoading.value = false
            }
            refetchData()
            const resetFormData = () => {
                formData.value = JSON.parse(JSON.stringify(formData.value))
            }
            const saveFormData = async () => {
                await store.dispatch('issue-job-work-challan-store-module/updateIssueJobWorkOrderChallan', formData.value).then(res => {
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
                    router.push({name: 'issue-job-work-challan'})
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
                jobNoOptions,
                jwTypeOptions,
                required,
                showOverlayLoading,
                refetchData,
                subContractorOptions,
                dateFormat,
                formatDates,
                getJobWorkChallanFormateDate,
                getJobWorkFormateDate,
                timeFormate
            }
        }
    }
</script>
