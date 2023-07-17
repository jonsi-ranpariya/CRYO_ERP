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
                                    <span>In normal/alternate shift list only those shift will display which is mapped with attendance group or with employee</span>
                                    <span>If Setup "Consider attendance group shift mapped with employee while shift selection" at (Path : Time > Configuration > Attendance Settings > Other setting) Is Opted.</span>
                                    <span>Path : Time > Define > Attendance Group > Assign Shift To Attendance Group.</span>
                                    <span>Path : Time > Define > Attendance Group > Assign Shift To Employee.</span>
                                </div>
                            </b-alert>
                            <hr>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col md="4">
                            <validation-provider
                                #default="validationContext"
                                name="Employee"
                                rules="required"
                            >
                                <b-form-group
                                    :state="getValidationState(validationContext)"
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
                                </b-form-group>
                            </validation-provider>

                        </b-col>
                        <b-col md="4">
                            <validation-provider
                                #default="validationContext"
                                name="Normal Shift"
                                rules="required"
                            >
                                <b-form-group
                                    :state="getValidationState(validationContext)"
                                >
                                    <label for="normal_shift">Normal Shift <span
                                        class="text-danger erp_required_star"
                                    >*</span></label>

                                    <v-select
                                        v-model="formData.normal_shift"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="shiftTypeOptions"
                                        :clearable="false"
                                        :reduce="val => val.value"
                                        placeholder="Select Shift"
                                        id="normal_shift"
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
                                name="Alt. Shift"
                                rules="required"
                            >
                                <b-form-group
                                    :state="getValidationState(validationContext)"
                                >
                                    <label for="alt_shift">Alt. Shift <span
                                        class="text-danger erp_required_star"
                                    >*</span></label>

                                    <v-select
                                        v-model="formData.alt_shift"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="shiftTypeOptions"
                                        :clearable="false"
                                        :reduce="val => val.value"
                                        placeholder="Select Shift"
                                        id="alt_shift"
                                        :state="getValidationState(validationContext)"
                                    />
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col md="4">
                            <validation-provider
                                #default="validationContext"
                                name="Shift Starting Date"
                                rules="required"
                            >
                                <b-form-group
                                    :state="getValidationState(validationContext)"
                                >
                                    <label for="shift_starting_date">Shift Starting Date <span
                                        class="text-danger erp_required_star"
                                    >*</span></label>

                                    <b-input-group>
                                        <cleave
                                            id="shift_starting_date"
                                            v-model="formData.shift_starting_date"
                                            class="form-control"
                                            :raw="false"
                                            :options="dateFormat"
                                            placeholder="DD/MM/YYYY"
                                            show-decade-nav
                                            :state="getValidationState(validationContext)"
                                        />
                                        <b-input-group-append>
                                            <b-form-datepicker
                                                v-model="formatDates.shift_starting_date"
                                                button-only
                                                @input="getShiftFormatDate($event)"
                                                show-decade-nav
                                                size="sm"
                                                nav-button-variant="primary"
                                                type="date"
                                                :state="getValidationState(validationContext)"
                                            />
                                        </b-input-group-append>
                                    </b-input-group>
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                        </b-col>
                        <b-col md="8">
                            <b-form-group
                                label="Alt. Shift Days"
                                label-for="alt_shift_days"
                            >
                                <div class="demo-inline-spacing">
                                    <b-form-checkbox
                                        class="custom-control-primary mt-1 d-flex"
                                        v-model="formData.alt_shift_days_sun"
                                    >
                                        Sun
                                    </b-form-checkbox>
                                    <b-form-checkbox
                                        class="custom-control-primary mt-1 d-flex"
                                        v-model="formData.alt_shift_days_mon"
                                    >
                                        Mon
                                    </b-form-checkbox>
                                    <b-form-checkbox
                                        class="custom-control-primary mt-1"
                                        v-model="formData.alt_shift_days_tue"
                                    >
                                        Tue
                                    </b-form-checkbox>
                                    <b-form-checkbox
                                        class="custom-control-primary mt-1"
                                        v-model="formData.alt_shift_days_wed"
                                    >
                                        Wed
                                    </b-form-checkbox>
                                    <b-form-checkbox
                                        class="custom-control-primary mt-1"
                                        v-model="formData.alt_shift_days_thu"
                                    >
                                        Thu
                                    </b-form-checkbox>
                                    <b-form-checkbox
                                        class="custom-control-primary mt-1"
                                        v-model="formData.alt_shift_days_fri"
                                    >
                                        Fri
                                    </b-form-checkbox>
                                    <b-form-checkbox
                                        class="custom-control-primary mt-1"
                                        v-model="formData.alt_shift_days_sat"
                                    >
                                        Sat
                                    </b-form-checkbox>
                                </div>
                            </b-form-group>
                        </b-col>
                    </b-row>
                    <br>
                    <hr>
                    <b-row>
                        <b-col md="12">
                            <b-button
                                variant="primary"
                                class="float-right mt-2 ml-1"
                                type="sumbit"
                            >
                                Save
                            </b-button>
                        </b-col>
                    </b-row>
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
        BForm,
        BFormGroup,
        BTableSimple,
        BThead,
        BTbody,
        BTr,
        BTh,
        BButton,
        BFormCheckbox,
        BInputGroup,
        BInputGroupAppend,
        BFormInvalidFeedback,
        BFormDatepicker
    } from 'bootstrap-vue'
    import BCardCode from "@core/components/b-card-code/BCardCode";
    import {ref, onUnmounted} from "@vue/composition-api";
    import vSelect from 'vue-select'
    import {ValidationObserver, ValidationProvider} from 'vee-validate'
    import {required} from '@validations'
    import axios from '@axios'
    import formValidation from "@core/comp-functions/forms/form-validation";
    import Cleave from 'vue-cleave-component'
    import router from '@/router'
    import store from '@/store'
    import hrmsStoreModule from "../../../../hrmsStoreModule";
    import {useToast} from "vue-toastification/composition";
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import {forMatIndianDate} from "../../../../../../@core/utils/utils";


    export default {
        components: {
            BCardCode,
            BFormDatepicker,
            BRow,
            BCol,
            BAlert,
            BForm,
            vSelect,
            BFormGroup,
            BTableSimple,
            BThead,
            BTbody,
            BTr,
            BTh,
            BButton,
            BFormCheckbox,
            ValidationObserver,
            ValidationProvider,
            BInputGroup,
            BInputGroupAppend,
            BFormInvalidFeedback,
            Cleave
        },
        setup() {
            // const toast = useToast()
            // //using store module
            // const SE_APP_STORE_MODULE_NAME = 'hr-store-module'
            // if (!store.hasModule(SE_APP_STORE_MODULE_NAME)) store.registerModule(SE_APP_STORE_MODULE_NAME, hrmsStoreModule)
            // onUnmounted(() => {
            //     if (store.hasModule(SE_APP_STORE_MODULE_NAME)) store.unregisterModule(SE_APP_STORE_MODULE_NAME)
            // })

            const dateFormat = ref({
                date: true,
                delimiter: '/',
                datePattern: ['d', 'm', 'Y'],
            })

            const formatDates = ref({
                shift_starting_date: null,
            })

            const getShiftFormatDate = (date) => {
                formData.value.shift_starting_date = forMatIndianDate(date)
            }

            const shiftTypeOptions = ref([
                {
                    label: 'V1',
                    value: 1
                },
                {
                    label: 'L1',
                    value: 2
                },
            ])
            const employeeOptions = ref([])
            axios.get('/api/get-users-name-options')
                .then(res => {
                    employeeOptions.value = res.data.data
                })


            const blankFormData = {
                employee_name: null,
                normal_shift: null,
                alt_shift: null,
                alt_shift_days_sun: null,
                alt_shift_days_mon: null,
                alt_shift_days_tue: null,
                alt_shift_days_wed: null,
                alt_shift_days_thu: null,
                alt_shift_days_fri: null,
                alt_shift_days_sat: null,
                shift_starting_date: forMatIndianDate()
            }
            const formData = ref(JSON.parse(JSON.stringify(blankFormData)))

            const resetFormData = () => {
                formData.value = JSON.parse(JSON.stringify(blankFormData))
            }
            const saveFormData = async () => {
                console.log(formData.value)
                router.push({
                    name: 'edit-multiple-shift-transfer'
                })
                /*    await store.dispatch('hr-store-module/addMultipleShiftTransferHr', formData.value)
                       .then(res => {
                           if (res.status === 200) {
                               toast({
                                   component: ToastificationContent,
                                   position: 'top-right',
                                   props: {
                                       title: 'Multiple Shift Transfer By HR Added',
                                       icon: 'CheckSquareIcon',
                                       variant: 'success',
                                       text: `You have successfully Added Multiple Shift Transfer By HR.`,
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
                               name: 'edit-multiple-shift-transfer',
                               params: {
                                   id: res.data.data._id
                               }
                           })
                       })*/
            }

            const {
                refFormObserver,
                getValidationState,
                resetForm
            } = formValidation(resetFormData)

            return {
                shiftTypeOptions,
                formData,
                employeeOptions,
                getShiftFormatDate,
                dateFormat,
                formatDates,
                refFormObserver,
                getValidationState,
                resetForm,
                resetFormData,
                saveFormData,
                required,

            }

        }
    }
</script>
