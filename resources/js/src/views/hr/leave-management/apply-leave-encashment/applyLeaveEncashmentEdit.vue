<template>
    <div>
        <b-card-code>
            <b-table
                :fields="itemsField"
                :items="itemsData"
                :bordered="true"
                :hover="true"
                class="mb-0 table_scroll"
                :busy="isBusy"
                show-empty
                responsive
            >
                <!-- Loader -->
                <template #table-busy>
                    <div class="text-center my-2">
                        <b-spinner class="align-middle"></b-spinner>
                        <strong>Loading...</strong>
                    </div>
                </template>
            </b-table>
        </b-card-code>
        <!-- Form Data -->
        <b-overlay
            :show="showOverlayLoading"
            rounded="sm"
        >
        <b-card-code>
            <validation-observer #default="{handleSubmit}">
                <b-form @submit.prevent="handleSubmit(saveFormData)">
                    <b-row>
                        <b-col md="12">
                            <b-alert
                                v-height-fade.appear
                                variant="danger"
                                :show="show"
                                class="mb-0"
                            >
                                <div class="alert-body">
                                    <feather-icon
                                        icon="InfoIcon"
                                        class="mr-50"
                                    />
                                    Minimum Balance to be maintained for PL leaves is 12. Available Balance: 58.5                                </div>
                            </b-alert>
                            <hr>
                        </b-col>
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
                                        @keyup="validateInput"
                                    />
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </validation-provider>
                            </b-form-group>
                        </b-col>
                        <b-col md="5">
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
                        <b-col md="12">
                            <hr>
                            <b-button
                                type="submit"
                                variant="primary"
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
    </div>
</template>
<script>
    import {
        BTable,
        BForm,
        BRow,
        BCol,
        BFormGroup,
        BFormInvalidFeedback,
        BFormTextarea,
        BButton,
        BFormInput,
        BOverlay,
        BAlert
    } from 'bootstrap-vue'
    import BCardCode from "@core/components/b-card-code/BCardCode";
    import {ref} from "@vue/composition-api";
    import {ValidationObserver, ValidationProvider} from 'vee-validate'
    import vSelect from 'vue-select'
    import formValidation from '@core/comp-functions/forms/form-validation'
    import {required} from '@validations'
    import {useToast} from "vue-toastification/composition";
    import hrmsStoreModule from "../../hrmsStoreModule";
    import router from '@/router'
    import store from '@/store'
    import Toastification from '@core/components/toastification/ToastificationContent.vue'
    import axios from '@axios'
    import { heightFade } from '@core/directives/animations'

    export default {
        components: {
            BCardCode,
            BTable,
            BForm,
            BRow,
            BCol,
            ValidationObserver,
            ValidationProvider,
            vSelect,
            BFormGroup,
            BFormInvalidFeedback,
            BFormTextarea,
            BButton,
            BFormInput,
            BOverlay,
            BAlert
        },
        directives: {
            'height-fade': heightFade,
        },
        setup(){
            // const toast = useToast()
            // //using store module
            // const SE_APP_STORE_MODULE_NAME = 'hr-store-module'
            // if (!store.hasModule(SE_APP_STORE_MODULE_NAME)) store.registerModule(SE_APP_STORE_MODULE_NAME, hrmsStoreModule)
            // onUnmounted(() => {
            //     if (store.hasModule(SE_APP_STORE_MODULE_NAME)) store.unregisterModule(SE_APP_STORE_MODULE_NAME)
            // })
            const show = ref(true)

            const showOverlayLoading = ref(false)

            const isBusy = ref(false)
            const leaveTypeOptions = ref([
                {
                    label: 'Privilege Leave (PL)',
                    value: 1
                },
            ])

            const itemsField = ref([
                {
                    key: 'balance_leave',
                    label: 'Balance Leave',
                },
                {
                    key: 'requested_encashment_leave',
                    label: 'Requested Encashment Leaves',
                },
                {
                    key: 'available_leave',
                    label: 'Available Leaves',
                },
                {
                    key: 'minimum_balance_maintained',
                    label: 'Minimum Balance Maintained',
                },
            ])
            const itemsData = ref([])

            const refetchTableData = async () => {
                isBusy.value = true
                itemsData.value = [
                    {
                        balance_leave: '58.5',
                        requested_encashment_leave: '0',
                        available_leave: '58.5',
                        minimum_balance_maintained: '12',
                    }
                ]
                isBusy.value = false
            }
            refetchTableData()

            const validateInput = () => {
                console.log(formData.value.encashment_days)
                // if (formData.value.encashment_days <= subtotal) {
                //     show.value = false
                // } else {
                //     show.value = true
                // }
            }

            const blankFormData = {
                leave_type: 1,
                encashment_days:null,
                remarks:null,
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
                /*    await store.dispatch('hr-store-module/addLeaveEncashment', formData.value)
                       .then(res => {
                           if (res.status === 200) {
                               toast({
                                   component: ToastificationContent,
                                   position: 'top-right',
                                   props: {
                                       title: Leave Encashment Added',
                                       icon: 'CheckSquareIcon',
                                       variant: 'success',
                                       text: `You have successfully Added Leave Encashment.`,
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

            const {
                refFormObserver,
                getValidationState,
                resetForm
            } = formValidation(resetFormData)

            return{
                itemsField,
                itemsData,
                refetchTableData,
                isBusy,
                formData,
                resetFormData,
                refFormObserver,
                getValidationState,
                resetForm,
                required,
                saveFormData,
                leaveTypeOptions,
                showOverlayLoading,
                refetchData,
                show,
                validateInput
            }
        }
    }
</script>
