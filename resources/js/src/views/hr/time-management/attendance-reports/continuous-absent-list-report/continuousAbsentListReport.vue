<template>
    <div>
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
                                    <span>Save attendance muster properly before generating result here.</span><br><br>
                                    <span>Report will be generated based on type selected and employee with any type remain jointly for X number of days or greater will shown here.
                                          Please select WO and PH incase you want to count those days as absent.</span><br><br>
                                </div>
                            </b-alert>
                            <hr>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col md="6">
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
                                                    @input="calculateDays"
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
                                                <cleave
                                                    id="to_date"
                                                    v-model="formData.to_date"
                                                    class="form-control"
                                                    :raw="false"
                                                    :options="dateFormat"
                                                    placeholder="DD/MM/YYYY"
                                                    show-decade-nav
                                                    :state="getValidationState(validationContext)"
                                                    @input="calculateDays($event)"
                                                />
                                                <b-input-group-append>
                                                    <b-form-datepicker
                                                        v-model="formatDates.to_date"
                                                        button-only
                                                        @input="getToFormatDate($event)"
                                                        show-decade-nav
                                                        size="sm"
                                                        nav-button-variant="primary"
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
                            </b-row>
                        </b-col>
                        <b-col md="6">
                            <validation-provider
                                #default="validationContext"
                                name="Atten Type Group"
                                rules=""
                            >
                                <b-form-group
                                    label="Atten Type Group"
                                    label-for="attendance_type_group"
                                    :state="getValidationState(validationContext)"
                                >
                                    <v-select
                                        v-model="formData.attendance_type_group"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="attendanceGroupOptions"
                                        :clearable="false"
                                        :reduce="val => val.value"
                                        input-id="attendance_type_group"
                                        placeholder="Select Type"
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
                        <b-col md="3">
                            <validation-provider
                                #default="validationContext"
                                name="Total Days"
                                rules=""
                            >
                                <b-form-group
                                    label="Total Days"
                                    label-for="total_days"
                                    :state="getValidationState(validationContext)"
                                >
                                    <b-form-input
                                        id="total_days"
                                        placeholder="Total Days"
                                        v-model="formData.total_days"
                                        :state="getValidationState(validationContext)"
                                    />
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                        </b-col>
                        <b-col md="9">
                            <b-row>
                                <b-col md="12">
                                    <b-form-group
                                        label="Atten Types"
                                        label-for="attendance_type"
                                    >
                                        <div class="demo-inline-spacing">
                                            <b-form-checkbox
                                                v-model="formData.dayTypeAbs"
                                                name="dayTypeAbs"
                                            >
                                                ABS
                                            </b-form-checkbox>
                                            <b-form-checkbox
                                                v-model="formData.dayTypeCl"
                                                name="dayTypeCl"
                                            >
                                                CL
                                            </b-form-checkbox>
                                            <b-form-checkbox
                                                v-model="formData.dayTypeCoMinus"
                                                name="dayTypeCoMinus"
                                            >
                                                CO-
                                            </b-form-checkbox>
                                            <b-form-checkbox
                                                v-model="formData.dayTypeCoPlus"
                                                name="dayTypeCoPlus"
                                            >
                                                CO+
                                            </b-form-checkbox>
                                            <b-form-checkbox
                                                v-model="formData.dayTypeDp"
                                                name="dayTypeDp"
                                            >
                                                DP
                                            </b-form-checkbox>
                                            <b-form-checkbox
                                                v-model="formData.dayTypeEo"
                                                name="dayTypeEo"
                                            >
                                                EO
                                            </b-form-checkbox>
                                            <b-form-checkbox
                                                v-model="formData.dayTypeLone"
                                                name="dayTypeLone"
                                            >
                                                L1
                                            </b-form-checkbox>
                                            <b-form-checkbox
                                                v-model="formData.dayTypeLtwo"
                                                name="dayTypeLtwo"
                                            >
                                                L2
                                            </b-form-checkbox>
                                            <b-form-checkbox
                                                v-model="formData.dayTypeTypeLthree"
                                                name="dayTypeTypeLthree"
                                            >
                                                L3
                                            </b-form-checkbox>
                                            <b-form-checkbox
                                                v-model="formData.dayTypeLfour"
                                                name="dayTypeLfour"
                                            >
                                                L4
                                            </b-form-checkbox>
                                            <b-form-checkbox
                                                v-model="formData.dayTypeLfive"
                                                name="dayTypeLfive"
                                            >
                                                L5
                                            </b-form-checkbox>
                                            <b-form-checkbox
                                                v-model="formData.dayTypeLwp"
                                                name="dayTypeLwp"
                                            >
                                                LWP
                                            </b-form-checkbox>
                                            <b-form-checkbox
                                                v-model="formData.dayTypeOd"
                                                name="dayTypeOd"
                                            >
                                                OD
                                            </b-form-checkbox>
                                            <b-form-checkbox
                                                v-model="formData.dayTypeOl"
                                                name="dayTypeOl"
                                            >
                                                OL
                                            </b-form-checkbox>
                                            <b-form-checkbox
                                                v-model="formData.dayTypePh"
                                                name="dayTypePh"
                                            >
                                                PH
                                            </b-form-checkbox>
                                            <b-form-checkbox
                                                v-model="formData.dayTypePhp"
                                                name="dayTypePhp"
                                            >
                                                PHP
                                            </b-form-checkbox>
                                            <b-form-checkbox
                                                v-model="formData.dayTypePl"
                                                name="dayTypePl"
                                            >
                                                PL
                                            </b-form-checkbox>
                                            <b-form-checkbox
                                                v-model="formData.dayTypeSl"
                                                name="dayTypeSl"
                                            >
                                                SL
                                            </b-form-checkbox>
                                            <b-form-checkbox
                                                v-model="formData.dayTypeSv"
                                                name="dayTypeSv"
                                            >
                                                SV
                                            </b-form-checkbox>
                                            <b-form-checkbox
                                                v-model="formData.dayTypeWo"
                                                name="dayTypeWo"
                                            >
                                                WO
                                            </b-form-checkbox>
                                            <b-form-checkbox
                                                v-model="formData.dayTypeWop"
                                                name="dayTypeWop"
                                            >
                                                WOP
                                            </b-form-checkbox>
                                        </div>
                                    </b-form-group>
                                </b-col>
                            </b-row>
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
                            class="float-right"
                        >
                            View
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
        BAlert,
        BFormGroup,
        BFormDatepicker,
        BInputGroup,
        BFormInput,
        BInputGroupAppend,
        BFormInvalidFeedback,
        BFormCheckbox,
        BButton,
        BFormRadioGroup
    } from 'bootstrap-vue'
    import BCardCode from "@core/components/b-card-code/BCardCode";
    import {ValidationObserver, ValidationProvider} from 'vee-validate'
    import formValidation from "@core/comp-functions/forms/form-validation";
    import {ref} from "@vue/composition-api";
    import moment from "moment";
    import {forMatIndianDate} from "@core/utils/utils";
    import vSelect from 'vue-select'
    import Cleave from 'vue-cleave-component'
    import {required} from '@validations'
    import axios from '@axios'

    export default {
        components: {
            BCardCode,
            ValidationObserver,
            ValidationProvider,
            BForm,
            BRow,
            BCol,
            BAlert,
            BFormGroup,
            BFormInput,
            BFormDatepicker,
            vSelect,
            BInputGroup,
            BInputGroupAppend,
            BFormInvalidFeedback,
            Cleave,
            BFormCheckbox,
            BFormRadioGroup,
            BButton
        },
        setup() {
            const attendanceGroupOptions = ref([
                {label: 'Spine Type', value: 1},
                {label: 'User Defined Type', value: 2},
            ])
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
            const calculateDays = () => {
                let startDate = moment(formData.value.from_date, "DD/MM/YYYY");
                let endDate = moment(formData.value.to_date, "DD/MM/YYYY");

                formData.value.total_days = endDate.diff(startDate, 'days') + 1;
            }

            const saveFormData = async () => {
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
                dateFormat,
                formatDates,
                getToFormatDate,
                getFromFormatDate,
                saveFormData,
                attendanceGroupOptions,
                calculateDays,
                required,
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
            }
        }
    }
</script>
