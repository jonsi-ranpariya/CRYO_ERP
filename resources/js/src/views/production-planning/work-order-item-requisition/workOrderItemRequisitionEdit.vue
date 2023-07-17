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
                                <validation-provider
                                    #default="validationContext"
                                    name="Req. No"
                                    rules=""
                                >
                                    <b-form-group
                                        label="Req. No"
                                        label-for="reqNumber"
                                    >
                                        <b-form-input
                                            id="reqNumber"
                                            readonly
                                            v-model="formData.reqNumber"
                                            :state="getValidationState(validationContext)"
                                        />
                                        <b-form-invalid-feedback>
                                            {{ validationContext.errors[0] }}
                                        </b-form-invalid-feedback>
                                    </b-form-group>
                                </validation-provider>
                                <div v-if="formData.reqType === 1">
                                    <validation-provider
                                        #default="validationContext"
                                        name="W.O.No"
                                        rules=""
                                    >
                                        <b-form-group
                                            label="W.O.No"
                                            label-for="woNumber"
                                            :state="getValidationState(validationContext)"
                                        >
                                            <b-form-input
                                                readonly
                                                v-model="formData.woNumber"
                                                :state="getValidationState(validationContext)"
                                            />
                                            <b-form-invalid-feedback>
                                                {{ validationContext.errors[0] }}
                                            </b-form-invalid-feedback>
                                        </b-form-group>
                                    </validation-provider>
                                </div>
                                <div v-if="formData.reqType === 3">
                                    <validation-provider
                                        #default="validationContext"
                                        name="Job Card No"
                                        rules=""
                                    >
                                        <b-form-group
                                            label="Job Card No."
                                            label-for="jobCardNumber"
                                            :state="getValidationState(validationContext)"
                                        >
                                            <b-form-input
                                                readonly
                                                v-model="formData.jobCardNumber"
                                                :state="getValidationState(validationContext)"
                                                id="jobCardNumber"
                                            />
                                            <b-form-invalid-feedback>
                                                {{ validationContext.errors[0] }}
                                            </b-form-invalid-feedback>
                                        </b-form-group>
                                    </validation-provider>
                                </div>
                            </b-col>
                            <b-col md="6">
                                <validation-provider
                                    #default="validationContext"
                                    name="Date"
                                    rules="required"
                                >
                                    <b-form-group
                                        label="Date"
                                        label-for="date"
                                    >
                                        <b-input-group>
                                            <b-input-group-prepend>
                                                <b-form-datepicker
                                                    v-model="formatDates.woDate"
                                                    button-only
                                                    @input="getWoFormateDate($event)"
                                                    show-decade-nav
                                                    size="sm"
                                                    nav-button-variant="primary"
                                                    disabled
                                                />
                                            </b-input-group-prepend>
                                            <cleave
                                                id="woDate"
                                                v-model="formData.woDate"
                                                class="form-control"
                                                :raw="false"
                                                :options="dateFormat"
                                                placeholder="DD/MM/YYYY"
                                                show-decade-nav
                                                disabled
                                            />
                                        </b-input-group>
                                        <b-form-invalid-feedback>
                                            {{ validationContext.errors[0] }}
                                        </b-form-invalid-feedback>
                                    </b-form-group>
                                </validation-provider>
                                <validation-provider
                                    #default="validationContext"
                                    name="Req. Type"
                                    rules="required"
                                >
                                    <b-form-group
                                        label="Req. Type"
                                        label-for="reqType"
                                        :state="getValidationState(validationContext)"
                                    >
                                        <v-select
                                            placeholder="Select Type"
                                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                            :options="workOrderType"
                                            :reduce="val => val.value"
                                            :clearable="false"
                                            id="reqType"
                                            v-model="formData.reqType"
                                            disabled
                                        />
                                        <b-form-invalid-feedback>
                                            {{ validationContext.errors[0] }}
                                        </b-form-invalid-feedback>
                                    </b-form-group>
                                </validation-provider>
                            </b-col>
                            <b-col md="12">
                                <hr>
                                <b-button
                                    variant="primary"
                                    type="submit"
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
                                icon="DatabaseIcon"
                                size="16"
                                class="mr-0 mr-sm-50"
                            />
                            <span class="d-none d-sm-inline">Item Detail</span>
                        </template>
                        <hr>
                        <item-details
                            :req-type="formData.reqType"
                        />
                    </b-tab>
                    <b-tab>
                        <template #title>
                            <feather-icon
                                icon="LogInIcon"
                                size="16"
                                class="mr-0 mr-sm-50"
                            />
                            <span class="d-none d-sm-inline">Login</span>
                        </template>
                        <hr>
                        <wo-login-tab
                            :login-data.sync="formData.LoginData"
                        />
                    </b-tab>
                </b-tabs>
            </b-card-code>
        </b-overlay>
    </div>
</template>
<script>
import BCardCode from '@core/components/b-card-code'
import {
    BRow,
    BCol,
    BFormGroup,
    BFormInput,
    BFormTextarea,
    BFormCheckbox,
    BForm,
    BButton,
    BFormDatepicker,
    BInputGroup,
    BInputGroupAppend,
    BTable,
    BFormInvalidFeedback,
    BCard,
    BSpinner,
    BTabs,
    BTab,
    BOverlay,
    BInputGroupPrepend
} from 'bootstrap-vue'
import { required } from '@validations'
import Ripple from 'vue-ripple-directive'
import vSelect from 'vue-select'
import store from '@/store'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
import { ValidationProvider, ValidationObserver } from 'vee-validate'
import formValidation from '@core/comp-functions/forms/form-validation'
import { ref, onUnmounted } from '@vue/composition-api'
import axios from '@axios'
import { getUserData } from '../../../auth/utils'
import moment from 'moment'
import { getTcTodayDate, getSalesTypeListOption } from '@core/utils/utils'
import productionPlanningStoreModule from '../productionPlanningStoreModule'
import { useToast } from 'vue-toastification/composition'
import router from '@/router'
import ItemDetails from '../work-order-item-requisition/tabs/itemDetails'
import WoLoginTab from './tabs/woLoginTab'
import Cleave from 'vue-cleave-component'
import { forMatIndianDate } from '@core/utils/utils'

export default {
    components: {
        WoLoginTab,
        ItemDetails,
        BCardCode,
        ValidationProvider,
        ValidationObserver,
        BRow,
        BCol,
        BFormGroup,
        BFormInput,
        BFormCheckbox,
        BFormTextarea,
        BForm,
        BButton,
        BFormDatepicker,
        BInputGroup,
        BInputGroupAppend,
        BTable,
        BFormInvalidFeedback,
        BCard,
        BSpinner,
        BTabs,
        BTab,
        BOverlay,
        vSelect,
        Cleave,
        BInputGroupPrepend
    },
    directives: {
        Ripple,
    },
    setup() {

        const ITEM_ADDON_APP_STORE_MODULE_NAME = 'production-planning'
        if (!store.hasModule(ITEM_ADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEM_ADDON_APP_STORE_MODULE_NAME, productionPlanningStoreModule)
        onUnmounted(() => {
            if (store.hasModule(ITEM_ADDON_APP_STORE_MODULE_NAME)) store.unregisterModule(ITEM_ADDON_APP_STORE_MODULE_NAME)
        })

        const toast = useToast()

        const showOverlayLoading = ref(false)

        const CurrentUserData = ref(getUserData())

        const workOrderType = ref([
            {
                label: 'Against Work Order',
                value: 1
            },
            {
                label: 'Manual',
                value: 2
            },
            {
                label: 'Against Job Order',
                value: 3
            },
        ])

        const dateFormat = ref({
            date: true,
            delimiter: '/',
            datePattern: ['d', 'm', 'Y'],
        })

        const formatDates = ref({
            woDate: null,
        })

        const getWoFormateDate = (date) => {
            formData.value.woDate = forMatIndianDate(date)
        }

        const salesTypeOptions = getSalesTypeListOption()

        const blankFormData = {
            id: null,
            reqNumber: null,
            woNumber: null,
            woDate: forMatIndianDate(getTcTodayDate()),
            jobCardId: null,
            jobCardNumber: null,
            reqType: 1,
            LoginData: {
                createdBy: null,
                createdDate: null,
                lastModifyBy: CurrentUserData.value.first_name + ' ' + CurrentUserData.value.last_name,
                lastModifyDate: moment(new Date())
                    .format('DD/MM/YYYY HH:mm'),
                approveBy: null,
                approveDate: null,
                stage: 1,
            }
        }

        const formData = ref(JSON.parse(JSON.stringify(blankFormData)))

        const resetFormData = () => {
            formData.value = JSON.parse(JSON.stringify(blankFormData))
        }

        const refetchData = async () => {
            showOverlayLoading.value = true
            await axios.get('/api/wo-requisition/'.concat(router.currentRoute.params.id))
                .then(res => {
                    formData.value.id = res.data.data._id
                    formData.value.reqNumber = res.data.data.reqNumber
                    formData.value.woNumber = res.data.data.woNumber
                    formData.value.woDate = res.data.data.woDate
                    formData.value.jobCardId = res.data.data.jobCardId
                    formData.value.jobCardNumber = res.data.data.jobCardNumber
                    formData.value.reqType = res.data.data.reqType
                    formData.value.LoginData.createdBy = res.data.data.LoginData.createdBy
                    formData.value.LoginData.createdDate = res.data.data.LoginData.createdDate
                })
            showOverlayLoading.value = false
        }
        refetchData()

        const saveFormData = async () => {
            await store.dispatch('production-planning/udpateWorkOrderRequisition', formData.value)
                .then(res => {
                    if (res.status === 200) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Work Order Item Requisition Updated',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: `You have successfully Updated Work Order Item Requisition.`,
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
                    router.push({ name: 'work-order-item-requisition' })
                })
        }

        const {
            refFormObserver,
            getValidationState,
            resetForm
        } = formValidation(resetFormData)

        return {
            showOverlayLoading,
            workOrderType,
            salesTypeOptions,
            formData,
            saveFormData,
            refetchData,

            resetFormData,
            refFormObserver,
            getValidationState,
            resetForm,
            getWoFormateDate,
            formatDates,
            dateFormat
        }
    }
}
</script>
