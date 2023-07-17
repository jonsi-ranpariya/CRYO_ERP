<template>
    <div>
        <b-card-code>
            <validation-observer #default="{handleSubmit}">
                <b-form @submit.prevent="handleSubmit(saveFormData)">
                    <b-row>
                        <b-col md="12">
                            <b-alert
                                variant="danger"
                                show
                            >
                                <h4 class="alert-heading">
                                    Note:
                                </h4>
                                <div class="alert-body">
                                    <span>Color tagging also helps for unique identification at calendar and on dashboard.</span><br>
                                </div>
                            </b-alert>
                            <hr>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col md="4">
                            <validation-provider
                                #default="validationContext"
                                name="Attendance Group"
                                rules="required"
                            >
                                <b-form-group
                                    :state="getValidationState(validationContext)"
                                >
                                    <label for="attendance_group">Attendance Group <span
                                        class="text-danger erp_required_star"
                                    >*</span></label>

                                    <b-form-input
                                        id="attendance_group"
                                        v-model="formData.attendance_group"
                                        :state="getValidationState(validationContext)"
                                    />
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                        </b-col>
                        <b-col md="4">
                            <validation-provider
                                #default="validationContext"
                                name="Full Day Hours"
                                rules="required"
                            >
                                <b-form-group
                                    :state="getValidationState(validationContext)"
                                >
                                    <label for="full_day_hours">Full Day Hours <span
                                        class="text-danger erp_required_star"
                                    >*</span></label>

                                    <b-form-input
                                        id="full_day_hours"
                                        v-model="formData.full_day_hours"
                                        :state="getValidationState(validationContext)"
                                        type="number"
                                        step="0.01"
                                    />
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                        </b-col>
                        <b-col md="4">
                            <validation-provider
                                #default="validationContext"
                                name="Half Day Hours"
                                rules="required"
                            >
                                <b-form-group
                                    :state="getValidationState(validationContext)"
                                >
                                    <label for="half_day_hours">Half Day Hours <span
                                        class="text-danger erp_required_star"
                                    >*</span></label>

                                    <b-form-input
                                        id="half_day_hours"
                                        v-model="formData.half_day_hours"
                                        :state="getValidationState(validationContext)"
                                        type="number"
                                        step="0.01"
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
    </div>
</template>
<script>
    import {
        BRow,
        BCol,
        BAlert,
        BFormGroup,
        BFormInput,
        BForm,
        BFormInvalidFeedback,
        BButton
    } from 'bootstrap-vue'
    import BCardCode from "@core/components/b-card-code/BCardCode";
    import {ValidationProvider, ValidationObserver} from 'vee-validate'
    import {ref} from "@vue/composition-api";
    import formValidation from "@core/comp-functions/forms/form-validation";
    import router from '@/router'
    import {required} from '@validations'
    import {useToast} from "vue-toastification/composition";
    import store from '@/store'
    import hrmsStoreModule from "../../hrmsStoreModule";
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'

    export default {
        components: {
            BCardCode,
            ValidationProvider,
            ValidationObserver,
            BRow,
            BCol,
            BAlert,
            BFormGroup,
            BFormInput,
            BForm,
            BFormInvalidFeedback,
            BButton
        },
        setup() {
            /*  const toast = useToast()
               //using store module
               const SE_APP_STORE_MODULE_NAME = 'hr-store-module'
               if (!store.hasModule(SE_APP_STORE_MODULE_NAME)) store.registerModule(SE_APP_STORE_MODULE_NAME, hrmsStoreModule)
               onUnmounted(() => {
                   if (store.hasModule(SE_APP_STORE_MODULE_NAME)) store.unregisterModule(SE_APP_STORE_MODULE_NAME)
           })*/
            const blankFormData = {
                attendance_group: null,
                full_day_hours: null,
                half_day_hours: null,
            }
            const formData = ref(JSON.parse(JSON.stringify(blankFormData)))

            const resetFormData = () => {
                formData.value = JSON.parse(JSON.stringify(blankFormData))
            }

            const saveFormData = async () => {
                console.log(formData.value)
                router.push({name: 'edit-attendance-group'})
                /*
                await store.dispatch('hr-store-module/addAttendanceGroup', formData.value)
                    .then(res => {
                        if (res.status === 200) {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Attendance Group Added',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: `You have successfully Added Attendance Group.`,
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
                            name: 'edit-attendance-group',
                            params: {
                                id: res.data.data._id
                            }
                        })
                    })
                */
            }

            const {
                refFormObserver,
                getValidationState,
                resetForm
            } = formValidation(resetFormData)

            return {
                refFormObserver,
                getValidationState,
                resetForm,
                resetFormData,
                formData,
                saveFormData,
                required
            }
        }
    }
</script>
