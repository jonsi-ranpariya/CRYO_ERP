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
                                            name="ReWork Challan No"
                                            rules="required"
                                        >
                                            <b-form-group
                                                label="ReWork Challan No"
                                                label-for="reWorkChallanNo"
                                            >
                                                <b-form-input
                                                    id="reWorkChallanNo"
                                                    :state="getValidationState(validationContext)"
                                                    v-model="formData.reWorkChallanNo"
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
                                            name="ReWork Challan Date"
                                            rules="required"
                                        >
                                            <b-form-group
                                                label="ReWork Challan Date"
                                                label-for="reWorkChallanDate"
                                            >
                                                <b-input-group>
                                                    <cleave
                                                        id="grnDate"
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
                                                disabled
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
                                        readonly
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
                            :subContractorDetail="formData.subContractorDetail"
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
                        <item-detail-tab
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
        BInputGroup,
        BInputGroupAppend,
        BFormInvalidFeedback,
        BButton,
        BFormDatepicker,
        BTab,
        BTabs,
        BOverlay
    } from 'bootstrap-vue'
    import BCardCode from "../../../@core/components/b-card-code/BCardCode";
    import {ValidationObserver, ValidationProvider} from 'vee-validate'
    import {onUnmounted, ref} from "@vue/composition-api";
    import formValidation from "../../../@core/comp-functions/forms/form-validation";
    import axios from '@axios'
    import vSelect from 'vue-select'
    import subContractorTab from "./tabs/subConractorTab"
    import Ripple from "vue-ripple-directive";
    import {useToast} from "vue-toastification/composition";
    import itemDetailTab from "./tabs/itemDetailTab";
    import jobWorkStoreModule from "../jobWorkStoreModule";
    import store from '@/store'
    import router from '@/router'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import reportTab from "./tabs/reportTab";
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
            subContractorTab,
            itemDetailTab,
            reportTab,
            BOverlay,
            Cleave
        },
        directives: {
            Ripple,
        },
        setup() {
            const toast = useToast()

            const ITEMADDON_APP_STORE_MODULE_NAME = 'job-rework-challan-store-module'
            if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, jobWorkStoreModule)
            onUnmounted(() => {
                if (store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.unregisterModule(ITEMADDON_APP_STORE_MODULE_NAME)
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

            const showOverlayLoading = ref(false)

            const subContractorOptions = ref([])
            axios.get('/api/party/get-master-options').then(res => {
                subContractorOptions.value = res.data.data
            })
            const formData = ref({
                reWorkChallanNo: null,
                reWorkChallanDate: null,
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
            })

            const resetFormData = () => {
                formData.value = JSON.parse(JSON.stringify(formData.value))
            }

            const refetchData = async () => {
                showOverlayLoading.value = true
                await axios.get(`/api/new/job-work-rework-challan/${router.currentRoute.params.id}`).then(res => {
                    formData.value = res.data.data
                })
                showOverlayLoading.value = false
            }
            refetchData()

            const saveFormData = async () => {
                await store.dispatch('job-rework-challan-store-module/updateJobReWorkChallan', formData.value).then(res => {
                    if (res.status === 200) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Job ReWork Challan Material Updated',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: `You have successfully Updated Job ReWork Challan.`,
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
                    router.push({name: 'job-work-rework-challan'})
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
                showOverlayLoading,
                refetchData,
                saveFormData,
                dateFormat,
                formatDates,
                getJobReWorkChallanFormateDate
            }
        }
    }
</script>
