<template>
    <div>
        <b-card-code>
            <validation-observer #default="{handleSubmit}">
                <b-form @submit.prevent="handleSubmit(saveFormData)">
                    <b-row>
                        <b-col md="8">
                            <b-row>
                                <b-col md="6">
                                    <validation-provider
                                        #default="validationContext"
                                        name="From Date"
                                        rules="required"
                                    >
                                        <b-form-group
                                            :state="getValidationState(validationContext)"
                                        >
                                            <label for="from_date">From Date <span
                                                class="text-danger erp_required_star"
                                            >*</span></label>

                                            <b-input-group>
                                                <cleave
                                                    id="from_date"
                                                    v-model="formData.from_date"
                                                    class="form-control"
                                                    :raw="false"
                                                    :options="dateFormat"
                                                    placeholder="DD/MM/YYYY"
                                                    show-decade-nav
                                                    :state="getValidationState(validationContext)"
                                                />
                                                <b-input-group-append>
                                                    <b-form-datepicker
                                                        v-model="formatDates.from_date"
                                                        button-only
                                                        @input="getFromFormatDate($event)"
                                                        show-decade-nav
                                                        size="sm"
                                                        nav-button-variant="primary"
                                                        :state="getValidationState(validationContext)"
                                                        type="date"
                                                    />
                                                </b-input-group-append>
                                            </b-input-group>
                                            <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                                {{ validationContext.errors[0] }}
                                            </b-form-invalid-feedback>
                                        </b-form-group>
                                    </validation-provider>
                                </b-col>
                                <b-col md="6">
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
                            </b-row>
                        </b-col>
                        <b-col md="4">
                            <p><span>Employee Code :</span>C002092</p>
                            <p><span>Shift Code :</span>CG</p>
                            <p><span>Shift Timing :</span>9:00 AM To 5:30 PM</p>
                        </b-col>
                    </b-row>
                    <hr>
                    <b-col md="12">
                        <h5>Attendanc Detail</h5>
                    </b-col>
                    <hr>
                    <b-row>
                        <b-col md="6">
                            <b-row>
                                <b-col md="6">
                                    <b-form-group
                                        label="In Time"
                                        label-for="inTime"
                                    >
                                        <b-form-timepicker
                                            id="inTime"
                                            locale="en"
                                            v-model="formData.inTime"
                                        />
                                    </b-form-group>
                                </b-col>
                                <b-col md="6">
                                    <b-form-group
                                        label="Out Time"
                                        label-for="outTime"
                                    >
                                        <b-form-timepicker
                                            id="outTime"
                                            locale="en"
                                            v-model="formData.outTime"
                                        />
                                    </b-form-group>
                                </b-col>
                            </b-row>
                        </b-col>
                        <b-col md="6">
                            <b-row>
                                <b-col md="6">
                                    <b-form-group
                                        label="User Type 1"
                                        label-for="user_type_one"
                                    >
                                        <v-select
                                            v-model="formData.user_type_one"
                                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                            :options="userTypeOneOptions"
                                            :clearable="false"
                                            :reduce="val => val.value"
                                            placeholder="Select Type"
                                            input-id="user_type_one"
                                        />
                                    </b-form-group>
                                </b-col>
                                <b-col md="6">
                                    <b-form-group
                                        label="User Type 2"
                                        label-for="user_type_two"
                                    >
                                        <v-select
                                            v-model="formData.user_type_two"
                                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                            :options="userTypeTwoOptions"
                                            :clearable="false"
                                            :reduce="val => val.value"
                                            placeholder="Select Type"
                                            input-id="user_type_two"
                                        />
                                    </b-form-group>
                                </b-col>
                            </b-row>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col md="6">
                            <b-row>
                                <b-col md="3">
                                    <b-form-group
                                        label="Portion"
                                        label-for="portion"
                                    >
                                        <b-form-input
                                            id="portion"
                                            v-model="formData.portion"
                                        />
                                    </b-form-group>
                                </b-col>
                                <b-col md="3">
                                    <b-form-group
                                        label="Late Mark"
                                        label-for="late_mark"
                                    >
                                        <b-form-input
                                            id="late_mark"
                                            v-model="formData.late_mark"
                                        />
                                    </b-form-group>
                                </b-col>
                                <b-col md="3">
                                    <b-form-group
                                        label="OT"
                                        label-for="ot"
                                    >
                                        <b-form-input
                                            id="ot"
                                            v-model="formData.ot"
                                        />
                                    </b-form-group>
                                </b-col>
                                <b-col md="3">
                                    <b-form-group
                                        label="AF1"
                                        label-for="af1"
                                    >
                                        <b-form-input
                                            id="af1"
                                            v-model="formData.af1"
                                        />
                                    </b-form-group>
                                </b-col>
                            </b-row>
                        </b-col>
                        <b-col md="6">
                            <b-row>
                                <b-col md="3">
                                    <b-form-group
                                        label="AF4"
                                        label-for="af4"
                                    >
                                        <b-form-input
                                            id="af4"
                                            v-model="formData.af4"
                                        />
                                    </b-form-group>
                                </b-col>
                                <b-col md="3">
                                    <b-form-group
                                        label="AF1 Total"
                                        label-for="af1_total"
                                    >
                                        <b-form-input
                                            id="af1_total"
                                            v-model="formData.af1_total"
                                        />
                                    </b-form-group>
                                </b-col>
                                <b-col md="6" class="mt-2">
                                    <b-form-checkbox
                                        v-model="formData.dayLock"
                                        name="dayLock"
                                    >
                                        Day Lock
                                    </b-form-checkbox>
                                </b-col>
                            </b-row>
                        </b-col>
                    </b-row>
                    <hr>
                    <b-col md="12">
                        <b-button
                            variant="primary"
                            class="float-right"
                            type="submit"
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
        BFormDatepicker,
        BInputGroup,
        BInputGroupAppend,
        BFormGroup,
        BFormInvalidFeedback,
        BFormTimepicker,
        BFormInput,
        BButton,
        BFormCheckbox
    } from 'bootstrap-vue'
    import BCardCode from "@core/components/b-card-code/BCardCode";
    import {ref} from "@vue/composition-api";
    import {ValidationObserver, ValidationProvider} from 'vee-validate'
    import formValidation from "@core/comp-functions/forms/form-validation";
    import Cleave from 'vue-cleave-component'
    import {forMatIndianDate} from "@core/utils/utils";
    import {required} from '@validations'
    import axios from '@axios'
    import vSelect from 'vue-select'

    export default {
        components: {
            BCardCode,
            BForm,
            BRow,
            BCol,
            BFormDatepicker,
            BInputGroup,
            BInputGroupAppend,
            ValidationProvider,
            ValidationObserver,
            BFormGroup,
            BFormInvalidFeedback,
            Cleave,
            vSelect,
            BFormTimepicker,
            BFormInput,
            BFormCheckbox,
            BButton
        },
        setup() {
            const dateFormat = ref({
                date: true,
                delimiter: '/',
                datePattern: ['d', 'm', 'Y'],
            })

            const formatDates = ref({
                from_date: null,
            })

            const getFromFormatDate = (date) => {
                formData.value.from_date = forMatIndianDate(date)
            }
            const employeeOptions = ref([])
            axios.get('/api/get-users-name-options')
                .then(res => {
                    employeeOptions.value = res.data.data
                })

            const userTypeOneOptions = ref([
                {label: 'ABS', value: 1},
                {label: 'CL', value: 2}
            ])
            const userTypeTwoOptions = ref([
                {label: 'ABS', value: 1},
                {label: 'CL', value: 2}
            ])


            const blankFormData = {
                from_date: null,
                employee_name: null,
                inTime: null,
                outTime: null,
                user_type_one: null,
                user_type_two: null,
                portion: null,
                late_mark: null,
                ot: null,
                af1: null,
                af4: null,
                af1_total: null,
                dayLock: null,
            }
            const formData = ref(JSON.parse(JSON.stringify(blankFormData)))

            const resetFormData = () => {
                formData.value = JSON.parse(JSON.stringify(blankFormData))
            }
            const saveFormData = async () => {

            }

            const {
                refFormObserver,
                getValidationState,
                resetForm
            } = formValidation(resetFormData)

            return {
                dateFormat,
                formatDates,
                getFromFormatDate,
                resetFormData,
                refFormObserver,
                getValidationState,
                resetForm,
                formData,
                required,
                employeeOptions,
                userTypeOneOptions,
                userTypeTwoOptions,
                saveFormData
            }
        }
    }
</script>
