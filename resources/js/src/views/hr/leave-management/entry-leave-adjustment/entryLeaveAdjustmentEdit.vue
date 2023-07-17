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
                            <!-- danger -->
                            <b-col md="12">
                                <b-alert
                                    variant="danger"
                                    show
                                >
                                    <h4 class="alert-heading">
                                        Note:
                                    </h4>
                                    <div class="alert-body">
                                    <span>This Application needs to be done incase some leave has been left out to taken into account of past or you want to adjust loss of pay due to
                                          latemark against any of your leave in which balance is available.</span><br><br>
                                        <span>Please Provide Proper Remark.</span><br><br>
                                        <span>HR/MANAGER can use this module to take / avail any of the leave type to employee for e.g. allotting additional leave for working extra hrs or
                                          to give additional credit of leave on completion of X year etc.</span><br><br>
                                        <span>User Leave type will be displayed for, default leave type.</span><br>
                                    </div>
                                </b-alert>
                                <hr>
                            </b-col>
                            <b-col md="4">
                                <b-form-group>
                                    <validation-provider
                                        #default="validationContext"
                                        name="Employee"
                                        rules="required"
                                    >
                                        <label for="employee_name">Employee <span
                                            class="text-danger erp_required_star"
                                        >*</span></label>

                                        <v-select
                                            v-model="formData.employee_name"
                                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                            :options="employeeOptions"
                                            :clearable="false"
                                            :reduce="val => val.value"
                                            placeholder="Select Employee"
                                            id="employee_name"
                                            :state="getValidationState(validationContext)"
                                        />
                                        <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                            {{ validationContext.errors[0] }}
                                        </b-form-invalid-feedback>
                                    </validation-provider>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group>
                                    <validation-provider
                                        #default="validationContext"
                                        name="Adjustment Days"
                                        rules="required"
                                    >
                                        <label for="adjustment_days">Adjustment Days <span
                                            class="text-danger erp_required_star"
                                        >*</span></label>

                                        <b-form-input
                                            id="adjustment_days"
                                            placeholder="Adjustment Days"
                                            v-model="formData.adjustment_days"
                                            :state="getValidationState(validationContext)"
                                            type="number"
                                        />
                                        <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                            {{ validationContext.errors[0] }}
                                        </b-form-invalid-feedback>
                                    </validation-provider>
                                </b-form-group>
                            </b-col>
                            <b-col md="5">
                                <h6><p class="text-danger">To reduce from balance input days in positive else input  in negative.</p></h6>
                            </b-col>
                            <b-col md="4">
                                <validation-provider
                                    #default="validationContext"
                                    name="Leave Type"
                                    rules=""
                                >
                                    <b-form-group
                                        label="Leave Type"
                                        label-for="leave_type"
                                        :state="getValidationState(validationContext)"
                                    >
                                        <v-select
                                            v-model="formData.leave_type"
                                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                            :options="leaveTypeOptions"
                                            :clearable="false"
                                            placeholder="Leave Type"
                                            :reduce="val => val.value"
                                            input-id="leave_type"
                                            :state="getValidationState(validationContext)"
                                        />
                                        <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                            {{ validationContext.errors[0] }}
                                        </b-form-invalid-feedback>
                                    </b-form-group>
                                </validation-provider>
                            </b-col>
                            <b-col md="8">
                                <validation-provider
                                    #default="validationContext"
                                    name="Remarks"
                                    rules=""
                                >
                                    <b-form-group
                                        label="Remarks"
                                        label-for="remarks"
                                        :state="getValidationState(validationContext)"
                                    >
                                        <b-form-textarea
                                            id="remarks"
                                            placeholder="Remarks"
                                            v-model="formData.remarks"
                                            rows="2"
                                            :state="getValidationState(validationContext)"
                                        />
                                        <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                            {{ validationContext.errors[0] }}
                                        </b-form-invalid-feedback>
                                    </b-form-group>
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
        BAlert,
        BCol,
        BFormGroup,
        BFormInput,
        BFormInvalidFeedback,
        BFormTextarea,
        BButton,
        BOverlay
    } from 'bootstrap-vue'
    import BCardCode from "@core/components/b-card-code/BCardCode";
    import {ValidationObserver, ValidationProvider} from 'vee-validate'
    import formValidation from "@core/comp-functions/forms/form-validation";
    import {ref, onUnmounted} from "@vue/composition-api";
    import axios from '@axios'
    import vSelect from 'vue-select'
    import {required} from '@validations'
    import {useToast} from "vue-toastification/composition";
    import hrmsStoreModule from "../../hrmsStoreModule";
    import router from '@/router'
    import store from '@/store'
    import Toastification from '@core/components/toastification/ToastificationContent.vue'

    export default {
        components: {
            BCardCode,
            ValidationObserver,
            ValidationProvider,
            BForm,
            BRow,
            BAlert,
            BCol,
            vSelect,
            BFormGroup,
            BFormInput,
            BFormInvalidFeedback,
            required,
            BFormTextarea,
            BButton,
            BOverlay
        },
        setup() {
            // const toast = useToast()
            // //using store module
            // const SE_APP_STORE_MODULE_NAME = 'hr-store-module'
            // if (!store.hasModule(SE_APP_STORE_MODULE_NAME)) store.registerModule(SE_APP_STORE_MODULE_NAME, hrmsStoreModule)
            // onUnmounted(() => {
            //     if (store.hasModule(SE_APP_STORE_MODULE_NAME)) store.unregisterModule(SE_APP_STORE_MODULE_NAME)
            // })

            const showOverlayLoading = ref(false)

            const employeeOptions = ref([])
            axios.get('/api/get-users-name-options').then(res => {
                employeeOptions.value = res.data.data
            })

            const leaveTypeOptions = ref([
                {
                    label: 'Casual Leave (CL)',
                    value: 1
                },
                {
                    label: 'Privilege Leave (PL)',
                    value: 2
                },
                {
                    label: 'Sick Leave (SL)',
                    value: 3
                },
                {
                    label: 'OL',
                    value: 4
                },
                {
                    label: 'CO+',
                    value: 5
                },
                {
                    label: 'CO-',
                    value: 6
                },
                {
                    label: 'L1',
                    value: 7
                },
                {
                    label: 'L2',
                    value: 8
                },
                {
                    label: 'L3',
                    value: 9
                },
                {
                    label: 'L4',
                    value: 10
                },
                {
                    label: 'L5',
                    value: 11
                },
            ])

            const blankFormData = {
                employee_name: null,
                adjustment_days: null,
                leave_type: null,
                remarks: null
            }

            const formData = ref(JSON.parse(JSON.stringify(blankFormData)))

            const resetFormData = () => {
                formData.value = JSON.parse(JSON.stringify(blankFormData))
            }

            const refetchData = async () => {
                showOverlayLoading.value = true
                /* await axios.get(`/api//${router.currentRoute.params.id}`).then(res => {
                     formData.value = res.data.data
                 })*/
                showOverlayLoading.value = false
            }
            refetchData()

            const saveFormData = async () => {
                console.log(formData.value)
                /*
                await store.dispatch('hr-store-module/updateLeaveAdjustment', formData.value)
                    .then(res => {
                        if (res.status === 200) {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Entry Leave Adjustment Added',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: `You have successfully Added Entry Leave Adjustment.`,
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
                getValidationState,
                resetForm
            } = formValidation(resetFormData)

            return {
                saveFormData,
                refFormObserver,
                getValidationState,
                resetForm,
                resetFormData,
                formData,
                employeeOptions,
                leaveTypeOptions,
                refetchData,
                showOverlayLoading
            }
        }
    }
</script>

