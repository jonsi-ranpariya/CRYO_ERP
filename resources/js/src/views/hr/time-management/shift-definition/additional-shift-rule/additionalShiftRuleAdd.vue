<template>
    <div>
        <b-card-code>
            <validation-observer #default="{handleSubmit}">
                <b-form @submit.prevent="handleSubmit(saveFormData)">
                    <b-row>
                        <b-col md="3">
                            <validation-provider
                                #default="validationContext"
                                name="Shift Code"
                                rules="required"
                            >
                                <b-form-group
                                    :state="getValidationState(validationContext)"
                                >
                                    <label for="shift_code">Shift Code <span
                                        class="text-danger erp_required_star"
                                    >*</span></label>

                                    <v-select
                                        v-model="formData.shift_code"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="shiftCodeOptions"
                                        :clearable="false"
                                        :reduce="val => val.value"
                                        placeholder="Select Code"
                                        id="shift_code"
                                        :state="getValidationState(validationContext)"
                                    />
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                            <b-form-group>
                                <validation-provider
                                    #default="validationContext"
                                    name="Order No"
                                    rules="required"
                                >
                                    <label for="shift_code">Order No <span
                                        class="text-danger erp_required_star"
                                    >*</span></label>

                                    <b-form-input
                                        placeholder="Enter Number"
                                        v-model="formData.order_number"
                                        :state="getValidationState(validationContext)"
                                        id="order_number"
                                    />
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </validation-provider>
                            </b-form-group>
                            <b-form-group
                                label="Is Active"
                                label-for="is_active"
                            >
                                <v-select
                                    v-model="formData.is_active"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="isActiveOptions"
                                    :clearable="false"
                                    :reduce="val => val.value"
                                    placeholder="Select"
                                    id="is_active"
                                />
                            </b-form-group>
                            <b-form-group
                                label="Rule Remark"
                                label-for="remark"
                            >
                                <b-form-textarea
                                    v-model="formData.remark"
                                    id="remark"
                                    rows="2"
                                />
                            </b-form-group>
                        </b-col>
                        <b-col md="5">
                            <b-form-group>
                                <validation-provider
                                    #default="validationContext"
                                    name="Update Values"
                                    rules="required"
                                >
                                    <label for="update_values">Update Values <span
                                        class="text-danger erp_required_star"
                                    >*</span></label>

                                    <b-form-textarea
                                        v-model="formData.update_values"
                                        :state="getValidationState(validationContext)"
                                        id="update_values"
                                        rows="2"
                                    />
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </validation-provider>
                            </b-form-group>
                            <b-form-group>
                                <validation-provider
                                    #default="validationContext"
                                    name="Conditions"
                                    rules="required"
                                >
                                    <label for="condition">Condition <span
                                        class="text-danger erp_required_star"
                                    >*</span></label>

                                    <b-form-textarea
                                        v-model="formData.condition"
                                        :state="getValidationState(validationContext)"
                                        id="condition"
                                        rows="2"
                                    />
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </validation-provider>
                            </b-form-group>
                            <br>
                            <b-form-checkbox
                                class="custom-control-primary mt-4"
                                v-model="formData.execute_shift_rule_even_locked"
                            >
                                Execute this shift rule even day locked
                            </b-form-checkbox>
                        </b-col>
                        <b-col md="4">
                            <v-select
                                class="mt-2"
                                v-model="formData.in_time"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="inTimeOptions"
                                :clearable="false"
                                :reduce="val => val.value"
                                placeholder="InTime"
                                id="in_time"
                                @input="updatesValue"
                            />
                            <br>
                            <v-select
                                class="mt-4"
                                v-model="formData.in_time_condition"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="inTimeOptions"
                                :clearable="false"
                                :reduce="val => val.value"
                                placeholder="InTime"
                                id="in_time_condition"
                                @input="updatesValue"
                            />
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
        BForm,
        BRow,
        BCol,
        BFormGroup,
        BFormInput,
        BFormInvalidFeedback,
        BFormTextarea,
        BFormCheckbox,
        BButton
    } from 'bootstrap-vue'
    import BCardCode from "@core/components/b-card-code/BCardCode";
    import {ValidationObserver, ValidationProvider} from 'vee-validate'
    import vSelect from 'vue-select'
    import {ref, onUnmounted} from '@vue/composition-api'
    import formValidation from "@core/comp-functions/forms/form-validation";
    import {required} from '@validations'
    import axios from '@axios'
    import {useToast} from "vue-toastification/composition";
    import router from '@/router'
    import store from '@/store'
    import hrmsStoreModule from "../../../hrmsStoreModule";
    import Toastification from '@core/components/toastification/ToastificationContent.vue'

    export default {
        components: {
            BCardCode,
            ValidationObserver,
            ValidationProvider,
            BForm,
            BCol,
            BRow,
            vSelect,
            BFormGroup,
            BFormInput,
            BFormInvalidFeedback,
            BFormTextarea,
            BFormCheckbox,
            BButton
        },
        setup() {
       /*   const toast = useToast()
           //using store module
           const SE_APP_STORE_MODULE_NAME = 'hr-store-module'
           if (!store.hasModule(SE_APP_STORE_MODULE_NAME)) store.registerModule(SE_APP_STORE_MODULE_NAME, hrmsStoreModule)
           onUnmounted(() => {
               if (store.hasModule(SE_APP_STORE_MODULE_NAME)) store.unregisterModule(SE_APP_STORE_MODULE_NAME)
           })*/

            const isActiveOptions = ref([
                {label: 'Yes', value: 1},
                {label: 'No', value: 2},
            ])

            const shiftCodeOptions = ref([
                {label: 'A1', value: 1},
            ])
            /* axios.get('/api/new/')
                .then(res => {
                    shiftCodeOptions.value = res.data
                })
            */

            const inTimeOptions = ref([
                {label: 'inTime', value: 'inTime'},
                {label: 'outTime', value: 'outTime'},
            ])
            /*  axios.get('/api/new/get-operator-master-option')
                  .then(res => {
                      inTimeOptions.value = res.data.data
                  })*/
            const updatesValue = () => {
                formData.value.update_values = formData.value.in_time
                formData.value.condition = formData.value.in_time_condition

            }

            const blankFormData = {
                shift_code:null,
                order_number:null,
                is_active:null,
                remark:null,
                update_values:null,
                condition:null,
                execute_shift_rule_even_locked:null,
                in_time:null,
                in_time_condition:null,
            }
            const formData = ref(JSON.parse(JSON.stringify(blankFormData)))

            const resetFormData = () => {
                formData.value = JSON.parse(JSON.stringify(blankFormData))
            }
            const saveFormData = async () => {
                console.log(formData.value)
                router.push({name: 'edit-additional-shift-rule'})
                /*
                await store.dispatch('hr-store-module/addAdditionalShiftRule', formData.value)
                    .then(res => {
                        if (res.status === 200) {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Additional Shift Rule Added',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: `You have successfully Added Addditional Shift Rule.`,
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
                            name:'edit-additional-shift-rule',
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
                saveFormData,
                shiftCodeOptions,
                refFormObserver,
                getValidationState,
                resetForm,
                resetFormData,
                formData,
                inTimeOptions,
                updatesValue,
                required,
                isActiveOptions
            }
        }
    }
</script>
