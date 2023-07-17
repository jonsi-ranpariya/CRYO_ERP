<template>
    <div>
        <b-card-code>
            <validation-observer #default="{handleSubmit}">
                <b-form @submit.prevent="handleSubmit(saveFormData)">
                    <b-row>
                        <b-col md="4">
                            <b-form-group
                                label="Report Type"
                                label-for="report_type"
                            >
                                <v-select
                                    v-model="formData.report_type"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="reportTypeOptions"
                                    :clearable="false"
                                    :reduce="val => val.value"
                                    input-id="report_type"
                                    placeholder="Select Type"
                                />
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                label="Period"
                                label-for="period"
                            >
                                <v-select
                                    v-model="formData.YearPresent"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="yearPresentOptions"
                                    :clearable="false"
                                    :reduce="val => val.value"
                                    placeholder="Year"
                                    input-id="YearPresent"
                                />
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                label="Based on"
                                label-for="based_on"
                            >
                                <v-select
                                    v-model="formData.based_on"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="basedOnOptions"
                                    :clearable="false"
                                    :reduce="val => val.value"
                                    input-id="based_on"
                                />
                            </b-form-group>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col md="4">
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
                        <b-col md="4">
                            <validation-provider
                                #default="validationContext"
                                name="To Date"
                                rules="required"
                            >
                                <b-form-group
                                    :state="getValidationState(validationContext)"
                                >
                                    <label for="to_date">To Date <span
                                        class="text-danger erp_required_star"
                                    >*</span></label>

                                    <b-input-group>
                                        <b-input-group-prepend>
                                            <b-form-datepicker
                                                v-model="formatDates.to_date"
                                                button-only
                                                @input="getToFormatDate($event)"
                                                show-decade-nav
                                                size="sm"
                                                nav-button-variant="primary"
                                                :state="getValidationState(validationContext)"
                                            />
                                        </b-input-group-prepend>
                                        <cleave
                                            id="to_date"
                                            v-model="formData.to_date"
                                            class="form-control"
                                            :raw="false"
                                            :options="dateFormat"
                                            placeholder="DD/MM/YYYY"
                                            show-decade-nav
                                            :state="getValidationState(validationContext)"
                                        />
                                    </b-input-group>
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                        </b-col>
                        <b-col md="2">
                            <b-form-group
                                label="Shift"
                                label-for="shift"
                            >
                                <v-select
                                    v-model="formData.shift"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="shiftOptions"
                                    :clearable="false"
                                    :reduce="val => val.value"
                                    input-id="shift"
                                />
                            </b-form-group>
                        </b-col>
                        <b-col md="2">
                            <b-form-group
                                label="Gender"
                                label-for="gender"
                            >
                                <v-select
                                    v-model="formData.gender"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="genderOptions"
                                    :clearable="false"
                                    :reduce="val => val.value"
                                    input-id="gender"
                                    placeholder="Select Gender"
                                />
                            </b-form-group>
                        </b-col>
                    </b-row>
                    <hr>
                    <b-row>
                        <b-col md="4">
                            <b-form-group
                                label="Company Name"
                                label-for="company_name"
                            >
                                <v-select
                                    v-model="formData.company_name"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="companyOptions"
                                    :clearable="false"
                                    :reduce="val => val.value"
                                    placeholder="Select Company"
                                    input-id="company_name"
                                />
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                label="Grade"
                                label-for="grade"
                            >
                                <v-select
                                    v-model="formData.grade"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="gradeOptions"
                                    :clearable="false"
                                    input-id="grade"
                                    placeholder="Select Grade"
                                />
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                label="Branch"
                                label-for="branch"
                            >
                                <v-select
                                    v-model="formData.branch"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="branchOptions"
                                    :clearable="false"
                                    input-id="branch"
                                    placeholder="Select Branch"
                                />
                            </b-form-group>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col md="4">
                            <b-form-group
                                label="Department"
                                label-for="department"
                            >
                                <v-select
                                    v-model="formData.department"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="departmentOptions"
                                    :clearable="false"
                                    input-id="grade"
                                    placeholder="Select Department"
                                />
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                label="Division"
                                label-for="division"
                            >
                                <v-select
                                    v-model="formData.division"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="divisionOptions"
                                    :clearable="false"
                                    placeholder="Select Division"
                                    input-id="division"
                                />
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                label="Unit"
                                label-for="unit"
                            >
                                <v-select
                                    v-model="formData.unit"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="unitOptions"
                                    :clearable="false"
                                    input-id="unit"
                                    placeholder="Select Unit"
                                />
                            </b-form-group>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col md="4">
                            <b-form-group
                                label="Category"
                                label-for="category"
                            >
                                <v-select
                                    v-model="formData.category"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="categoryOptions"
                                    :clearable="false"
                                    placeholder="Select Category"
                                    input-id="category"
                                />
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                label="Group"
                                label-for="group"
                            >
                                <v-select
                                    v-model="formData.group"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="groupOptions"
                                    :clearable="false"
                                    placeholder="Select Group"
                                    input-id="group"
                                />
                            </b-form-group>
                        </b-col>
                    </b-row>
                    <hr>
                    <b-row>
                        <b-col md="4">
                            <b-form-group
                                label="Employee"
                                label-for="employee_name"
                            >
                                <v-select
                                    v-model="formData.employee_name"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="employeeOptions"
                                    :clearable="false"
                                    :reduce="val => val.value"
                                    placeholder="Select Employee"
                                    input-id="employee_name"
                                />
                            </b-form-group>
                        </b-col>
                        <b-col md="5">
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
                        </b-col>
                    </b-row>
                    <hr>
                    <b-col md="12">
                        <b-button
                            variant="primary"
                            class="float-right ml-1"
                        >
                            Reset
                        </b-button>
                        <b-button
                            variant="primary"
                            class="float-right"
                        >
                            Show
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
        BFormRadioGroup,
        BButton,
        BInputGroup,
        BInputGroupAppend,
        BInputGroupPrepend,
        BFormInvalidFeedback,
        BFormDatepicker
    } from 'bootstrap-vue'
    import BCardCode from "@core/components/b-card-code/BCardCode";
    import vSelect from 'vue-select'
    import {ValidationProvider,ValidationObserver} from 'vee-validate'
    import {ref} from "@vue/composition-api";
    import axios from '@axios'
    import {required} from '@validations'
    import formValidation from "@core/comp-functions/forms/form-validation";
    import {forMatIndianDate} from "@core/utils/utils";
    import Cleave from 'vue-cleave-component'

    export default {
        components:{
            BCardCode,
            vSelect,
            BForm,
            BRow,
            BCol,
            BFormGroup,
            ValidationObserver,
            ValidationProvider,
            BButton,
            BFormRadioGroup,
            BInputGroup,
            BInputGroupAppend,
            BInputGroupPrepend,
            BFormInvalidFeedback,
            BFormDatepicker,
            Cleave
        },setup(){
            const dateFormat = ref({
                date: true,
                delimiter: '/',
                datePattern: ['d', 'm', 'Y'],
            })

            const formatDates = ref({
                from_date: null,
                to_date: null,
            })

            const getFromFormatDate = (date) => {
                formData.value.from_date = forMatIndianDate(date)
            }

            const getToFormatDate = (date) => {
                formData.value.to_date = forMatIndianDate(date)
            }
            const genderOptions = ref([
                {label: 'All', value: 1},
                {label: 'Male', value: 2},
                {label: 'Female', value: 3},
                {label: 'Other', value: 4},
            ])

            const shiftOptions = ref([
                {label:'AWS', value: 1},
                {label: 'CL', value: 2},
            ])

            const reportTypeOptions = ref([
                {label: 'Man Day Analysis', value: 1},
                {label: 'Man Hours Analysis', value: 2},
                {label: 'Leave Retio Analysis', value: 3},
                {label: 'Employee Count Report', value: 4},
                {label: 'Day Wise Attendance Summary', value: 5},
                {label: 'CostCenter wise Manday/OT Reports', value: 6},
            ])
            const basedOnOptions = ref([
                {label: 'Grade', value: 1},
                {label: 'Department', value: 2},
                {label: 'Division', value: 3},
                {label: 'Branch', value: 4},
                {label: 'Group', value: 5},
                {label: 'Unit', value: 6},
                {label: 'Category', value: 7},
            ])
            const yearPresentOptions = ref([
                {
                    label: new Date().getFullYear() - 1,
                    value: new Date().getFullYear() - 1
                },
                {
                    label: new Date().getFullYear(),
                    value: new Date().getFullYear()
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

            const gradeOptions = ref([])
            axios.get('/api/new/get-grade-master')
                .then(res => {
                    gradeOptions.value = res.data
                })

            const branchOptions = ref([])
            axios.get('/api/new/get-hr-branch-master')
                .then(res => {
                    branchOptions.value = res.data
                })

            const departmentOptions = ref([])
            axios.get('/api/new/get-hr-department-master')
                .then(res => {
                    departmentOptions.value = res.data
                })

            const divisionOptions = ref([])
            axios.get('/api/new/get-division-master')
                .then(res => {
                    divisionOptions.value = res.data
                })

            const unitOptions = ref([])
            axios.get('/api/new/get-unit-master')
                .then(res => {
                    unitOptions.value = res.data
                })

            const categoryOptions = ref([])
            axios.get('/api/new/get-category-master')
                .then(res => {
                    categoryOptions.value = res.data
                })

            const groupOptions = ref([])
            axios.get('/api/new/get-group-master')
                .then(res => {
                    groupOptions.value = res.data
                })

            const employeeOptions = ref([])
            axios.get('/api/get-users-name-options')
                .then(res => {
                    employeeOptions.value = res.data.data
                })

            const companyOptions = ref([])
            axios.get('/api/administration/get-company-options')
                .then(res => {
                    companyOptions.value = res.data.data
                })

            const blankFormData = {
                report_type:null,
                YearPresent:null,
                based_on:null,
                from_date: forMatIndianDate(),
                to_date: forMatIndianDate(),
                company_name: null,
                grade: null,
                branch: null,
                department: null,
                division: null,
                unit: null,
                category: null,
                group: null,
                employee_name: null,
                status: 'Current',
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

            return{
                saveFormData,
                reportTypeOptions,
                yearPresentOptions,
                gradeOptions,
                groupOptions,
                unitOptions,
                categoryOptions,
                companyOptions,
                employeeOptions,
                departmentOptions,
                divisionOptions,
                branchOptions,
                statusOptions,
                basedOnOptions,
                formData,
                dateFormat,
                formatDates,
                getFromFormatDate,
                getToFormatDate,
                refFormObserver,
                getValidationState,
                resetForm,
                resetFormData,
                required,
                shiftOptions,
                genderOptions
            }
        }
    }
</script>
