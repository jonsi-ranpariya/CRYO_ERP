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
                                   <span>All Leave masked in muster for the year selected will be considered as consumed, additional to this other Adjustment/Encashment/In Process (Non Approved Leave Applications) entries will also be considered as consumed,
                                         Any Leave entered in Adjustment/Increment Payroll process will be credited.</span><br>
                                </div>
                            </b-alert>
                            <hr>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col md="4">
                            <b-form-group
                                label="Report Type"
                                label-for="reportType"
                            >
                                <v-select
                                    v-model="formData.reportType"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="reportTypeOptions"
                                    :clearable="false"
                                    :reduce="val => val.value"
                                    placeholder="Select Status"
                                    input-id="reportType"
                                />
                            </b-form-group>
                        </b-col>
                        <b-col md="8">
                            <validation-provider
                                #default="validationContext"
                                name="Status"
                                rules="required"
                            >
                                <b-form-group
                                    label="Status"
                                    label-for="status"
                                    label-class="mb-1"
                                >
                                    <b-form-radio-group
                                        id="status"
                                        v-model="formData.status"
                                        :options="statusOptions"
                                    />
                                </b-form-group>
                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </validation-provider>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col md="4">
                            <validation-provider
                                #default="validationContext"
                                name="Employee"
                                rules=""
                            >
                                <b-form-group
                                    label="Employee"
                                    label-for="employee_name"
                                    :state="getValidationState(validationContext)"
                                >
                                    <v-select
                                        v-model="formData.employee_name"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="employeeOptions"
                                        :clearable="false"
                                        :reduce="val => val.value"
                                        placeholder="Select Employee"
                                        input-id="employee_name"
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
                                    name="For the Period"
                                    rules="required"
                                >
                                    <label for="for_the_period">For the Period <span
                                        class="text-danger erp_required_star"
                                    >*</span></label>

                                    <v-select
                                        v-model="formData.for_the_period"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="forPeriodOptions"
                                        :clearable="false"
                                        :reduce="val => val.value"
                                        placeholder="Select"
                                        id="for_the_period"
                                        :state="getValidationState(validationContext)"
                                    />
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </validation-provider>
                            </b-form-group>
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
                                        :reduce="val => val.value"
                                        placeholder="Leave Type"
                                        input-id="leave_type"
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
                            variant="primary"
                            class="float-right"
                        >
                            Reset
                        </b-button>
                        <b-button
                            variant="primary"
                            class="float-right mr-1"
                        >
                            View Report
                        </b-button>
                    </b-col>
                </b-form>
            </Validation-observer>
        </b-card-code>
    </div>
</template>
<script>
    import {
        BForm,
        BRow,
        BCol,
        BAlert,
        BFormGroup,
        BFormRadioGroup,
        BFormInvalidFeedback,
        BButton
    } from 'bootstrap-vue'
    import BCardCode from "@core/components/b-card-code/BCardCode";
    import {ValidationObserver, ValidationProvider} from 'vee-validate'
    import {ref} from "@vue/composition-api";
    import vSelect from 'vue-select'
    import axios from '@axios'
    import formValidation from "@core/comp-functions/forms/form-validation";
    import {required} from '@validations'
    import moment from "moment";

    export default {
        components: {
            BCardCode,
            ValidationObserver,
            ValidationProvider,
            BForm,
            BRow,
            BCol,
            BAlert,
            vSelect,
            BFormGroup,
            BFormRadioGroup,
            BFormInvalidFeedback,
            BButton
        },
        setup() {
            let monthYear = {
                april: moment().month(3).startOf("month").format('MMMM'),
                march: moment().month(2).startOf("month").format('MMMM'),
                currentYear: moment().year(),
                lastYear: moment().subtract(1, 'year').year(),
                secondLastYear: moment().subtract(2, 'year').year(),
                thirdLastYear: moment().subtract(3, 'year').year(),
            }
            const forPeriodOptions = ref([
                {
                    label: `${monthYear.april} , ${monthYear.lastYear} - ${monthYear.march} , ${monthYear.currentYear}`,
                    value: `${monthYear.april} , ${monthYear.lastYear} - ${monthYear.march} , ${monthYear.currentYear}`
                },
                {
                    label: `${monthYear.april} , ${monthYear.secondLastYear} - ${monthYear.march} , ${monthYear.lastYear}`,
                    value: `${monthYear.april} , ${monthYear.secondLastYear} - ${monthYear.march} , ${monthYear.lastYear}`
                },
                {
                    label: `${monthYear.april} , ${monthYear.thirdLastYear} - ${monthYear.march} , ${monthYear.secondLastYear}`,
                    value: `${monthYear.april} , ${monthYear.thirdLastYear} - ${monthYear.march} , ${monthYear.secondLastYear}`
                },
            ])

            const statusOptions = ref([
                {
                    text: 'All',
                    value: 'All'
                },
                {
                    text: 'Current',
                    value: 'Current'
                },
                {
                    text: 'Left',
                    value: 'Left'
                },
                {
                    text: 'Web Active',
                    value: 'Web Active'
                },
            ])

            const employeeOptions = ref([])
            axios.get('/api/get-users-name-options')
                .then(res => {
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
                    label: 'CO-',
                    value: 4
                },
                {
                    label: 'CO+',
                    value: 5
                },
            ])

            const reportTypeOptions = ref([
                {
                    label: 'Employee Wise Report',
                    value: 1
                },
                {
                    label: 'Summary Report',
                    value: 2
                },
            ])

            const blankFormData = {
                status: 'Current',
                for_the_period: null,
                employee_name: null,
                leave_type: null,
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
                saveFormData,
                statusOptions,
                forPeriodOptions,
                formData,
                employeeOptions,
                leaveTypeOptions,
                refFormObserver,
                getValidationState,
                resetForm,
                resetFormData,
                required,
                reportTypeOptions
            }
        }
    }
</script>
