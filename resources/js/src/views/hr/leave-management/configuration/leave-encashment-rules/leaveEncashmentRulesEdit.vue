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
                            <b-col md="2">
                                <validation-provider
                                    #default="validationContext"
                                    name="Leave Type"
                                    rules="required"
                                >
                                    <b-form-group
                                        :state="getValidationState(validationContext)"
                                    >
                                        <label for="leave_type">Leave Type <span
                                            class="text-danger erp_required_star"
                                        >*</span></label>

                                        <v-select
                                            placeholder="Select Type"
                                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                            :options="leaveTypeOptions"
                                            :reduce="val => val.value"
                                            :clearable="false"
                                            id="leave_type"
                                            v-model="formData.leave_type"
                                            :state="getValidationState(validationContext)"
                                        />
                                    </b-form-group>
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </validation-provider>
                            </b-col>
                            <b-col md="5">
                                <validation-provider
                                    #default="validationContext"
                                    name="Maximum Encashment Days (Per Instance)"
                                    rules="required"
                                >
                                    <b-form-group
                                        :state="getValidationState(validationContext)"
                                    >
                                        <label for="max_encashment_day_in_application">Maximum Encashment Days (Per
                                            Instance) <span
                                                class="text-danger erp_required_star"
                                            >*</span></label>

                                        <b-form-input
                                            v-model="formData.max_encashment_day_in_application"
                                            id="max_encashment_day_in_application"
                                            :state="getValidationState(validationContext)"
                                        />
                                    </b-form-group>
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </validation-provider>
                            </b-col>
                            <b-col md="5">
                                <validation-provider
                                    #default="validationContext"
                                    name="Minimum Encashment Days (Per Instance)"
                                    rules=""
                                >
                                    <b-form-group
                                        label="Minimum Encashment Days (Per Instance)"
                                        label-for="min_encashment_day_in_application"
                                    >
                                        <b-form-input
                                            v-model="formData.min_encashment_day_in_application"
                                            id="min_encashment_day_in_application"
                                            :state="getValidationState(validationContext)"
                                        />
                                    </b-form-group>
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </validation-provider>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="2">
                            </b-col>
                            <b-col md="5">
                                <validation-provider
                                    #default="validationContext"
                                    name="No. of Instance In Year"
                                    rules="required"
                                >
                                    <b-form-group
                                        :state="getValidationState(validationContext)"
                                    >
                                        <label for="no_of_instance_in_year">No. of Instance In Year <span
                                            class="text-danger erp_required_star"
                                        >*</span></label>

                                        <b-form-input
                                            v-model="formData.no_of_instance_in_year"
                                            id="no_of_instance_in_year"
                                            :state="getValidationState(validationContext)"
                                        />
                                    </b-form-group>
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </validation-provider>
                            </b-col>
                            <b-col md="5">
                                <validation-provider
                                    #default="validationContext"
                                    name="Minimum Balance To be Maintained (Per Year)"
                                    rules="required"
                                >
                                    <b-form-group
                                        :state="getValidationState(validationContext)"
                                    >
                                        <label for="min_balance_maintain">Minimum Balance To be Maintained (Per Year)
                                            <span
                                                class="text-danger erp_required_star"
                                            >*</span></label>

                                        <b-form-input
                                            v-model="formData.min_balance_maintain"
                                            id="min_balance_maintain"
                                            :state="getValidationState(validationContext)"
                                        />
                                    </b-form-group>
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </validation-provider>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="2"></b-col>
                            <b-col md="5">
                                <validation-provider
                                    #default="validationContext"
                                    name="Minimum Leave Used required in Current Year"
                                    rules=""
                                >
                                    <b-form-group
                                        label="Minimum Leave Used required in Current Year"
                                        label-for="min_leave_used_required_current_year"
                                    >
                                        <b-form-input
                                            v-model="formData.min_leave_used_required_current_year"
                                            id="min_leave_used_required_current_year"
                                            :state="getValidationState(validationContext)"
                                        />
                                    </b-form-group>
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </validation-provider>
                            </b-col>
                            <b-col md="5">
                                <validation-provider
                                    #default="validationContext"
                                    name="No. of Months Service Completed required"
                                    rules=""
                                >
                                    <b-form-group
                                        label="No. of Months Service Completed required"
                                        label-for="no_of_month_service_complete_required"
                                    >
                                        <b-form-input
                                            v-model="formData.no_of_month_service_complete_required"
                                            id="no_of_month_service_complete_required"
                                            :state="getValidationState(validationContext)"
                                        />
                                    </b-form-group>
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </validation-provider>
                            </b-col>
                        </b-row>
                        <hr>
                        <b-col md="12">
                            <b-button
                                type="submit"
                                variant="primary"
                                class="float-right"
                            >
                                Save
                            </b-button>
                        </b-col>
                    </b-form>
                </validation-observer>
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
        BButton,
        BFormInvalidFeedback
    } from 'bootstrap-vue'
    import BCardCode from "@core/components/b-card-code/BCardCode";
    import {ValidationObserver, ValidationProvider} from 'vee-validate'
    import vSelect from 'vue-select'
    import {onUnmounted, ref} from "@vue/composition-api";
    import formValidation from "../../../../../@core/comp-functions/forms/form-validation";
    import {required} from '@validations'
    import {useToast} from "vue-toastification/composition";
    import hrmsStoreModule from "../../../hrmsStoreModule";
    import store from '@/store/index'
    import axios from '@axios'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import Swal from "sweetalert2";
    import router from '@/router'

    export default {
        components: {
            BCardCode,
            ValidationProvider,
            ValidationObserver,
            vSelect,
            BForm,
            BRow,
            BButton,
            BCol,
            BFormGroup,
            BFormInput,
            BFormInvalidFeedback
        },
        setup() {
            const showOverlayLoading = ref(false)

            const toast = useToast()

            const ITEMADDON_APP_STORE_MODULE_NAME = 'hr-store-module'
            if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, hrmsStoreModule)
            onUnmounted(() => {
                if (store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.unregisterModule(ITEMADDON_APP_STORE_MODULE_NAME)
            })

            const leaveTypeOptions = ref([
                {label: 'CL', value: 1},
                {label: 'PL', value: 2},
                {label: 'OL', value: 3},
            ])
            const blankFormData = {
                leave_type: null,
                max_encashment_day_in_application:null,
                min_encashment_day_in_application:null,
                no_of_instance_in_year:null,
                min_balance_maintain:null,
                min_leave_used_required_current_year:null,
                no_of_month_service_complete_required:null

            }
            const formData = ref(JSON.parse(JSON.stringify(blankFormData)))
            const resetFormData = () => {
                formData.value = JSON.parse(JSON.stringify(blankFormData))
            }

            const refetchData = async () => {
                showOverlayLoading.value = true
                // await axios.get(`/api/new//${router.currentRoute.params.id}`).then((res) => {
                //     formData.value = res.data.data
                // })
                showOverlayLoading.value = false
            }
            refetchData()

            const saveFormData = async () => {
                console.log(formData.value)
            /*
                await store.dispatch('hr-store-module/addLeaveEncashmentRules', formData.value).then(res => {
                    if (res.status === 200) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Leave Encashment Rules Added',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: `You have successfully Added Leave Encashment Rules.`,
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
            */
            }

            const {
                refFormObserver,
                resetForm,
                getValidationState
            }
            = formValidation(resetFormData)

            return {
                saveFormData,
                formData,
                refFormObserver,
                resetForm,
                getValidationState,
                resetFormData,
                leaveTypeOptions,
                required,
                showOverlayLoading,
                refetchData
            }
        }
    }
</script>

