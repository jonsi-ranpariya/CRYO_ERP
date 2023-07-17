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
                                            name="Return No."
                                            rules="required"
                                        >
                                            <b-form-group
                                                label="Return No."
                                                label-for="returnNo"
                                            >
                                                <b-form-input
                                                    id="returnNo"
                                                    v-model="formData.returnNo"
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
                                                        <b-button variant="primary">...</b-button>
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
                        <item-details-tab
                        />
                    </b-tab>
                    <b-tab>
                        <template #title>
                            <feather-icon
                                icon="FileIcon"
                                size="16"
                                class="mr-0 mr-sm-50"
                            />
                            <span class="d-none d-sm-inline">Remark</span>
                        </template>
                        <remark-tab
                            :remarkDetails="formData.remarkDetails"
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
    import BCardCode from "../../../@core/components/b-card-code/BCardCode";
    import {ValidationObserver, ValidationProvider} from 'vee-validate'
    import {required} from '@validations'
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
        BOverlay,
        BTabs,
        BTab
    } from 'bootstrap-vue'
    import {onUnmounted, ref} from "@vue/composition-api";
    import formValidation from "../../../@core/comp-functions/forms/form-validation";
    import axios from '@axios'
    import vSelect from 'vue-select'
    import router from '@/router'
    import subContractorTab from "./tabs/subContractorTab"
    import itemDetailsTab from "./tabs/itemDetailsTab"
    import remarkTab from "./tabs/remarkTab"
    import reportTab from "./tabs/reportTab"
    import loginDetailsTab from "./tabs/loginDetailsTab"
    import {useToast} from "vue-toastification/composition";
    import jobWorkStoreModule from "../jobWorkStoreModule";
    import store from '@/store'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import Cleave from 'vue-cleave-component'
    import {forMatIndianDate} from "../../../@core/utils/utils";
    import {getUserData} from "../../../auth/utils";
    import moment from "moment";

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
            BOverlay,
            BTabs,
            BTab,
            subContractorTab,
            itemDetailsTab,
            remarkTab,
            reportTab,
            loginDetailsTab,
            Cleave
        },
        setup() {
            const toast = useToast()

            const ITEMADDON_APP_STORE_MODULE_NAME = 'raw-material-store-module'
            if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, jobWorkStoreModule)
            onUnmounted(() => {
                if (store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.unregisterModule(ITEMADDON_APP_STORE_MODULE_NAME)
            })

            const showOverlayLoading = ref(false)
            const subContractorOptions = ref([])
            axios.get('/api/party/get-master-options').then(res => {
                subContractorOptions.value = res.data.data
            })
            const jwTypeOptions = ref([
                {label: 'Job Work Order', value: 1},
                {label: 'Only Material Issue', value: 2},
                {label: 'Job Work Order 2', value: 3},
            ])

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
            const CurrentUserData = ref(getUserData())

            const formData = ref({
                id:null,
                returnNo: null,
                returnDate: null,
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
            })

            axios.get(`/api/new/raw-material/${router.currentRoute.params.id}`).then(res => {
                formData.value = res.data.data
                formData.value.id = res.data.data._id
                formData.value.loginDetails.lastModifiedBy = CurrentUserData.value.first_name + ' ' + CurrentUserData.value.last_name
                formData.value.loginDetails.modifiedDateTime = moment(new Date()).format('DD/MM/YYYY HH:mm')
                delete res.data.data._id
                showOverlayLoading.value = false
            })


            const resetFormData = () => {
                formData.value = JSON.parse(JSON.stringify(formData.value))
            }
            const saveFormData = async () => {
                await store.dispatch('raw-material-store-module/updateRawMaterial', formData.value).then(res => {
                    if (res.status === 200) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Raw Material Updated',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: `You have successfully Updated Raw Material.`,
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
                    router.push({name: 'raw-material-return-sub-contractor'})
                })
            }
            const {refFormObserver, getValidationState, resetForm} = formValidation(resetFormData)
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
                // refetchData,
                showOverlayLoading,
                dateFormat,
                formatDates,
                getJobWorkRawMaterialFormateDate
            }
        }

    }
</script>
