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
                            <b-col md="3">
                                <validation-provider
                                    #default="validationContext"
                                    name="Leave Type"
                                    rules="required"
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
                                            :reduce="val => val.value"
                                            placeholder="Leave Type"
                                            input-id="leave_type"
                                            disabled
                                            :state="getValidationState(validationContext)"
                                        />
                                        <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                            {{ validationContext.errors[0] }}
                                        </b-form-invalid-feedback>
                                    </b-form-group>
                                </validation-provider>
                            </b-col>
                            <b-col md="4">
                                <b-form-group>
                                    <validation-provider
                                        #default="validationContext"
                                        name="Encashment Days"
                                        rules="required"
                                    >
                                        <label for="encashment_days">Encashment Days <span
                                            class="text-danger erp_required_star"
                                        >*</span></label>

                                        <b-form-input
                                            id="encashment_days"
                                            placeholder="Encashment Days"
                                            v-model="formData.encashment_days"
                                            :state="getValidationState(validationContext)"
                                            readonly
                                        />
                                        <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                            {{ validationContext.errors[0] }}
                                        </b-form-invalid-feedback>
                                    </validation-provider>
                                </b-form-group>
                            </b-col>
                            <b-col md="5">
                                <b-form-group>
                                    <validation-provider
                                        #default="validationContext"
                                        name="Status"
                                        rules="required"
                                    >
                                        <label for="status">Status <span
                                            class="text-danger erp_required_star"
                                        >*</span></label>

                                        <v-select
                                            v-model="formData.status"
                                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                            :options="statusOptions"
                                            :clearable="false"
                                            id="status"
                                            placeholder="Select Status"
                                            :reduce="val => val.value"
                                            :state="getValidationState(validationContext)"
                                        />
                                        <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                            {{ validationContext.errors[0] }}
                                        </b-form-invalid-feedback>
                                    </validation-provider>
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="7">
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
            <b-card-code>
                <b-table
                    responsive
                    striped hover outlined
                    :items="tableRows"
                    empty-text="No matching records found"
                >
                </b-table>
            </b-card-code>
        </b-overlay>
    </div>
</template>
<script>
    import {
        BOverlay,
        BForm,
        BRow,
        BCol,
        BFormGroup,
        BFormInput,
        BFormTextarea,
        BFormDatepicker,
        BInputGroup,
        BInputGroupAppend,
        BFormInvalidFeedback,
        BButton,
        BTable
    } from 'bootstrap-vue'
    import BCardCode from "@core/components/b-card-code/BCardCode";
    import formValidation from "@core/comp-functions/forms/form-validation";
    import {ValidationObserver, ValidationProvider} from 'vee-validate'
    import Cleave from 'vue-cleave-component'
    import {ref, onUnmounted} from "@vue/composition-api";
    import vSelect from 'vue-select'
    import {required} from "@validations";
    import {forMatIndianDate, getTcTodayDate} from "@core/utils/utils";
    import {useToast} from "vue-toastification/composition";
    import hrmsStoreModule from "../../hrmsStoreModule";
    import axios from '@axios'
    import Toastification from '@core/components/toastification/ToastificationContent.vue'
    import store from '@/store'

    export default {
        components: {
            BCardCode,
            BOverlay,
            BForm,
            BRow,
            BCol,
            BFormGroup,
            BFormInput,
            BFormTextarea,
            BFormDatepicker,
            ValidationObserver,
            ValidationProvider,
            Cleave,
            BInputGroup,
            BInputGroupAppend,
            BFormInvalidFeedback,
            vSelect,
            BButton,
            BTable
        },
        setup() {
            // const toast = useToast()
            // //using store module
            // const SE_APP_STORE_MODULE_NAME = 'hr-store-module'
            // if (!store.hasModule(SE_APP_STORE_MODULE_NAME)) store.registerModule(SE_APP_STORE_MODULE_NAME, hrmsStoreModule)
            // onUnmounted(() => {
            //     if (store.hasModule(SE_APP_STORE_MODULE_NAME)) store.unregisterModule(SE_APP_STORE_MODULE_NAME)
            // })

            const tableRows = [
                {key: 'Employee Name: ', value: 'RAKESH S PATEL'},
                {key: 'Grade:', value: 'Staff New'},
                {key: 'Branch: ', value: 'Office'},
                {key: 'Department: ', value: 'ADMIN'},
                {key: 'Designation: ', value: 'OFFICE ASSISTANT'},
                {key: 'Joining Date: ', value: '18-Apr-22'},
                {key: 'Employee Code: ', value: 'C008111'},
                {key: 'Group: ', value: 'Non Technical'},
                {key: 'Division: ', value: 'Vadodara'},
                {key: 'Category: ', value: 'CEPL'},
                {key: 'Unit Name: ', value: 'HEAD OFFICE'},
                {key: 'Confirmation Dt: ', value: '18-Apr-22'},
            ]
            const statusOptions = ref([
                {label: 'Approved', value: 1},
                {label: 'Decline', value: 2},
            ])

            const showOverlayLoading = ref(false)

            const leaveTypeOptions = ref([
                {
                    label: 'Privilege Leave (PL)',
                    value: 1
                },
            ])
            const blankFormData = {
                leave_type: 1,
                encashment_days: null,
                remarks: null,
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
                /* await store.dispatch('hr-store-module/updateApproveLeaveEncashment', formData.value)
                 .then(res => {
                     if (res.status === 200) {
                         toast({
                             component: ToastificationContent,
                             position: 'top-right',
                             props: {
                                 title: 'Approved Leave Encashment updated',
                                 icon: 'CheckSquareIcon',
                                 variant: 'success',
                                 text: `You have successfully update Approved Leave Encashment.`,
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

                 })*/
            }
            const {refFormObserver, getValidationState, resetForm} = formValidation(resetFormData)
            return {
                refFormObserver,
                getValidationState,
                resetForm,
                resetFormData,
                formData,
                showOverlayLoading,
                saveFormData,
                tableRows,
                refetchData,
                leaveTypeOptions,
                required,
                statusOptions
            }
        }
    }
</script>
