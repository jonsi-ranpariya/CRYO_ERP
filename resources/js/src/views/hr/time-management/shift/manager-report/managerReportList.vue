<template>
    <div>
        <b-card-code>
            <b-form>
                <b-row>
                    <b-col md="4">
                        <b-form-group>
                            <label for="report_type">Report Type <span
                                class="text-danger erp_required_star"
                            >*</span></label>

                            <v-select
                                v-model="formData.report_type"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="reportTypeOptions"
                                :clearable="false"
                                :reduce="val => val.value"
                                placeholder="Select Type"
                                id="report_type"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="4">
                        <b-form-group>
                            <label for="month">Month & Year <span
                                class="text-danger erp_required_star"
                            >*</span></label>

                            <b-row>
                                <b-col md="6">
                                    <v-select
                                        v-model="formData.month"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="monthOptions"
                                        :clearable="false"
                                        :reduce="val => val.value"
                                        placeholder="Month"
                                        id="month"
                                    />
                                </b-col>
                                <b-col md="6">
                                    <v-select
                                        v-model="formData.YearPresent"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="yearPresentOptions"
                                        :clearable="false"
                                        :reduce="val => val.value"
                                        placeholder="Year"
                                        id="YearPresent"
                                    />
                                </b-col>
                                <b-col md="1"></b-col>
                            </b-row>
                        </b-form-group>
                    </b-col>
                </b-row>
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
                        Clear Section
                    </b-button>
                    <b-button
                        variant="primary"
                        class="float-right mr-1"
                        :to="{name: 'add-manager-report'}"
                    >
                        OK
                    </b-button>
                </b-col>
            </b-form>
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
        BFormRadioGroup,
        BButton,
        BFormCheckbox,
        BInputGroup,
        BInputGroupAppend,
        BFormDatepicker
    } from 'bootstrap-vue'
    import BCardCode from "@core/components/b-card-code/BCardCode";
    import vSelect from 'vue-select'
    import {ref} from '@vue/composition-api'
    import axios from '@axios'
    import Cleave from 'vue-cleave-component'
    import {forMatIndianDate, getTcTodayDate} from "@core/utils/utils";
    import moment from 'moment'

    export default {
        components: {
            BCardCode,
            BForm,
            BRow,
            BCol,
            vSelect,
            BFormGroup,
            BFormInput,
            BFormRadioGroup,
            BButton,
            BFormCheckbox,
            BFormDatepicker,
            Cleave,
            BInputGroup,
            BInputGroupAppend
        },
        setup() {
            const reportTypeOptions = ref([
                {label: 'Shift Allocation Report', value: 1},
                {label: 'Shift Listing Report', value: 2},
                {label: 'Employeewise Shift Count Analysis Report', value: 3},
                {label: 'Shiftwise Count Analysis Report', value: 4},
                {label: 'Shift Not Assigned Report', value: 5},
            ])

            /*Get all Month*/
            let allMonth = [];
            let months = moment.months();
            for (let i=0; i < months.length; i++){
                allMonth.push({
                    label: months[i],
                    value: months[i],
                })
            }
            const monthOptions = ref([])
            monthOptions.value = allMonth

            const yearPresentOptions = ref([
                {
                    label: new Date().getFullYear()-1,
                    value: new Date().getFullYear()-1
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


            const formData = ref({
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
                from_date: forMatIndianDate(getTcTodayDate()),
                to_date: forMatIndianDate(),
                employee_with_all_shift_Assign: null,
            })

            return {
                formData,
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
                reportTypeOptions,
                monthOptions,
                yearPresentOptions
            }
        }
    }
</script>
