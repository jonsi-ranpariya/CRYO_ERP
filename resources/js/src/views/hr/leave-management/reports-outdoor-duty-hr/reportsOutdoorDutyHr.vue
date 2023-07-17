<template>
    <div>
        <b-card-code>
            <b-form>
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
                                placeholder="Select Type"
                                input-id="report_type"
                            />
                        </b-form-group>
                    </b-col>
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
                </b-row>
                <b-row>
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
                </b-row>
                <b-row>
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
                    <b-col md="3">
                        <div v-if="formData.report_type === 1">
                            <b-form-group
                                label="Manager Employee"
                                label-for="manager_employee"
                            >
                                <v-select
                                    v-model="formData.manager_employee"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="managerEmployeeOptions"
                                    :clearable="false"
                                    :reduce="val => val.value"
                                    placeholder="Select Employee"
                                    input-id="manager_employee"
                                />
                            </b-form-group>
                        </div>
                    </b-col>
                </b-row>
                <hr>
                <b-row>
                    <b-col md="6">
                        <div v-if="formData.report_type === 1">
                            <b-row>
                                <b-col md="6">
                                    <b-form-group
                                        label="Approve Form Date"
                                        label-for="approve_form_date"
                                    >
                                        <b-input-group>
                                            <cleave
                                                id="approve_form_date"
                                                v-model="formData.approve_form_date"
                                                class="form-control"
                                                :raw="false"
                                                :options="dateFormat"
                                                placeholder="DD/MM/YYYY"
                                                show-decade-nav
                                            />
                                            <b-input-group-append>
                                                <b-form-datepicker
                                                    v-model="formatDates.approve_form_date"
                                                    button-only
                                                    @input="getApproveFormDate($event)"
                                                    show-decade-nav
                                                    size="sm"
                                                    nav-button-variant="primary"
                                                />
                                            </b-input-group-append>
                                        </b-input-group>
                                    </b-form-group>
                                </b-col>
                                <b-col md="6">
                                    <b-form-group
                                        label="Approve To Date"
                                        label-for="approve_to_date"
                                    >
                                        <b-input-group>
                                            <cleave
                                                id="approve_to_date"
                                                v-model="formData.approve_to_date"
                                                class="form-control"
                                                :raw="false"
                                                :options="dateFormat"
                                                placeholder="DD/MM/YYYY"
                                                show-decade-nav
                                            />
                                            <b-input-group-append>
                                                <b-form-datepicker
                                                    v-model="formatDates.approve_to_date"
                                                    button-only
                                                    @input="getApproveToDate($event)"
                                                    show-decade-nav
                                                    size="sm"
                                                    nav-button-variant="primary"
                                                />
                                            </b-input-group-append>
                                        </b-input-group>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col md="6">
                                    <b-form-group
                                        label="Application Form Date"
                                        label-for="application_form_date"
                                    >
                                        <b-input-group>
                                            <cleave
                                                id="application_form_date"
                                                v-model="formData.application_form_date"
                                                class="form-control"
                                                :raw="false"
                                                :options="dateFormat"
                                                placeholder="DD/MM/YYYY"
                                                show-decade-nav
                                            />
                                            <b-input-group-append>
                                                <b-form-datepicker
                                                    v-model="formatDates.application_form_date"
                                                    button-only
                                                    @input="getApplicationFormDate($event)"
                                                    show-decade-nav
                                                    size="sm"
                                                    nav-button-variant="primary"
                                                />
                                            </b-input-group-append>
                                        </b-input-group>
                                    </b-form-group>
                                </b-col>
                                <b-col md="6">
                                    <b-form-group
                                        label="Application To Date"
                                        label-for="application_to_date"
                                    >
                                        <b-input-group>
                                            <cleave
                                                id="application_to_date"
                                                v-model="formData.application_to_date"
                                                class="form-control"
                                                :raw="false"
                                                :options="dateFormat"
                                                placeholder="DD/MM/YYYY"
                                                show-decade-nav
                                            />
                                            <b-input-group-append>
                                                <b-form-datepicker
                                                    v-model="formatDates.application_to_date"
                                                    button-only
                                                    @input="getApplicationToDate($event)"
                                                    show-decade-nav
                                                    size="sm"
                                                    nav-button-variant="primary"
                                                />
                                            </b-input-group-append>
                                        </b-input-group>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                        </div>
                        <b-row>
                            <b-col md="6">
                                <b-form-group
                                    label="OD Form Date"
                                    label-for="approve_form_date"
                                >
                                    <b-input-group>
                                        <cleave
                                            id="outdoor_duty_form_date"
                                            v-model="formData.outdoor_duty_form_date"
                                            class="form-control"
                                            :raw="false"
                                            :options="dateFormat"
                                            placeholder="DD/MM/YYYY"
                                            show-decade-nav
                                        />
                                        <b-input-group-append>
                                            <b-form-datepicker
                                                v-model="formatDates.outdoor_duty_form_date"
                                                button-only
                                                @input="getOutdoorDutyFormDate($event)"
                                                show-decade-nav
                                                size="sm"
                                                nav-button-variant="primary"
                                            />
                                        </b-input-group-append>
                                    </b-input-group>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="OD To Date"
                                    label-for="outdoor_duty_to_date"
                                >
                                    <b-input-group>
                                        <cleave
                                            id="outdoor_duty_to_date"
                                            v-model="formData.outdoor_duty_to_date"
                                            class="form-control"
                                            :raw="false"
                                            :options="dateFormat"
                                            placeholder="DD/MM/YYYY"
                                            show-decade-nav
                                        />
                                        <b-input-group-append>
                                            <b-form-datepicker
                                                v-model="formatDates.outdoor_duty_to_date"
                                                button-only
                                                @input="getOutdoorDutyToDate($event)"
                                                show-decade-nav
                                                size="sm"
                                                nav-button-variant="primary"
                                            />
                                        </b-input-group-append>
                                    </b-input-group>
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <div v-if="formData.report_type === 1">
                            <b-row>
                                <b-col md="6">
                                    <b-form-group
                                        label="OD Form Days"
                                        label-for="outdoor_duty_form_days"
                                    >
                                        <b-form-input
                                            id="outdoor_duty_form_days"
                                            placeholder="Form Days"
                                            v-model="formData.outdoor_duty_form_days"
                                        />
                                    </b-form-group>
                                </b-col>
                                <b-col md="6">
                                    <b-form-group
                                        label="OD To Days"
                                        label-for="outdoor_duty_to_days"
                                    >
                                        <b-form-input
                                            id="outdoor_duty_to_days"
                                            placeholder="Form Days"
                                            v-model="formData.outdoor_duty_to_days"
                                        />
                                    </b-form-group>

                                </b-col>
                            </b-row>
                        </div>
                    </b-col>
                    <b-col md="6">
                        <div v-if="formData.report_type === 1">
                            <b-row>
                                <b-col md="6">
                                    <b-form-group
                                        label="OD Instance Count From"
                                        label-for="od_instance_count_from"
                                    >
                                        <b-form-input
                                            id="od_instance_count_from"
                                            placeholder="Form Days"
                                            v-model="formData.od_instance_count_from"
                                        />
                                    </b-form-group>
                                </b-col>
                                <b-col md="6">
                                    <b-form-group
                                        label="OD Instance Count To"
                                        label-for="od_instance_count_to"
                                    >
                                        <b-form-input
                                            id="od_instance_count_to"
                                            placeholder="To Days"
                                            v-model="formData.od_instance_count_to"
                                        />
                                    </b-form-group>
                                </b-col>
                            </b-row>
                        </div>
                        <b-row>
                            <b-col md="6">
                                <b-form-group
                                    label="Leave Type"
                                    label-for="leave_type"
                                >
                                    <v-select
                                        v-model="formData.leave_type"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="leaveTypeOptions"
                                        :clearable="false"
                                        :reduce="val => val.value"
                                        placeholder="Leave Type"
                                        input-id="leave_type"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <div v-if="formData.report_type === 1">

                                    <b-form-group
                                        label="Application Satus"
                                        label-for="application_status"
                                    >
                                        <v-select
                                            v-model="formData.application_status"
                                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                            :options="applicationStatusOptions"
                                            :clearable="false"
                                            :reduce="val => val.value"
                                            placeholder="Leave Type"
                                            input-id="leave_type"
                                        />
                                    </b-form-group>
                                </div>
                            </b-col>
                        </b-row>
                        <div v-if="formData.report_type === 1">
                            <b-row>
                                <b-col md="6">
                                    <b-form-group
                                        label="Order By"
                                        label-for="order_by"
                                    >
                                        <v-select
                                            v-model="formData.order_by"
                                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                            :options="orderByOptions"
                                            :clearable="false"
                                            :reduce="val => val.value"
                                            placeholder="Order By"
                                            input-id="order_by"
                                        />
                                    </b-form-group>
                                </b-col>
                                <b-col md="6"></b-col>
                            </b-row>
                        </div>
                    </b-col>
                </b-row>
                <div v-if="formData.report_type === 1">
                    <hr>
                    <b-col md="12">
                        <h5>Print Master Details</h5>
                    </b-col>
                    <hr>
                    <b-row>
                        <b-col md="12">
                            <div class="demo-inline-spacing">
                                <b-form-checkbox
                                    v-model="formData.masterGrand"
                                    name="grand"
                                >
                                    Grand
                                </b-form-checkbox>
                                <b-form-checkbox
                                    v-model="formData.masterBranch"
                                    name="branch"
                                >
                                    Branch
                                </b-form-checkbox>
                                <b-form-checkbox
                                    v-model="formData.masterDepartment"
                                    name="department"
                                >
                                    Department
                                </b-form-checkbox>
                                <b-form-checkbox
                                    v-model="formData.masterDivision"
                                    name="division"
                                >
                                    Division
                                </b-form-checkbox>
                                <b-form-checkbox
                                    v-model="formData.masterUnit"
                                    name="unit"
                                >
                                    Unit
                                </b-form-checkbox>
                                <b-form-checkbox
                                    v-model="formData.masterCategory"
                                    name="category"
                                >
                                    Category
                                </b-form-checkbox>
                                <b-form-checkbox
                                    v-model="formData.masterGroup"
                                    name="group"
                                >
                                    Group
                                </b-form-checkbox>
                                <b-form-checkbox
                                    v-model="formData.masterDesignation"
                                    name="designation"
                                >
                                    Designation
                                </b-form-checkbox>
                            </div>
                        </b-col>
                    </b-row>
                </div>

                <div v-if="formData.report_type != 1">
                <b-col md="12">
                    <h5>Group By</h5>
                </b-col>
                    <hr>
                    <b-row>
                        <b-col md="4">
                            <b-form-group
                                label="Level 1"
                                label-for="level_1"
                            >
                                <v-select
                                    v-model="formData.level_1"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="levelOneOptions"
                                    :clearable="false"
                                    :reduce="val => val.value"
                                    placeholder="Select Level"
                                    input-id="level_1"
                                />
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                label="Level 2"
                                label-for="level_2"
                            >
                                <v-select
                                    v-model="formData.level_2"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="levelTwoOptions"
                                    :clearable="false"
                                    :reduce="val => val.value"
                                    placeholder="Select Level"
                                    input-id="level_2"
                                />
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                label="Level 3"
                                label-for="level_3"
                            >
                                <v-select
                                    v-model="formData.level_3"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="levelThreeOptions"
                                    :clearable="false"
                                    :reduce="val => val.value"
                                    placeholder="Select Level"
                                    input-id="level_3"
                                />
                            </b-form-group>
                        </b-col>
                    </b-row>
                </div>
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
        BInputGroup,
        BInputGroupAppend,
        BFormDatepicker,
        BFormCheckbox,
        BButton
    } from 'bootstrap-vue'
    import BCardCode from "@core/components/b-card-code/BCardCode";
    import vSelect from 'vue-select'
    import {ref} from '@vue/composition-api'
    import axios from '@axios'
    import Cleave from 'vue-cleave-component'
    import {forMatIndianDate} from "@core/utils/utils";

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
            BInputGroup,
            BInputGroupAppend,
            BFormDatepicker,
            Cleave,
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
                application_form_date: null,
                application_to_date: null,
                approve_form_date: null,
                approve_to_date: null,
                outdoor_duty_form_date: null,
                outdoor_duty_to_date: null,
            })

            const getApplicationFormDate = (date) => {
                formData.value.application_form_date = forMatIndianDate(date)
            }

            const getApplicationToDate = (date) => {
                formData.value.application_to_date = forMatIndianDate(date)
            }

            const getApproveFormDate = (date) => {
                formData.value.approve_form_date = forMatIndianDate(date)
            }

            const getApproveToDate = (date) => {
                formData.value.approve_to_date = forMatIndianDate(date)
            }

            const getOutdoorDutyFormDate = (date) => {
                formData.value.outdoor_duty_form_date = forMatIndianDate(date)
            }

            const getOutdoorDutyToDate = (date) => {
                formData.value.outdoor_duty_to_date = forMatIndianDate(date)
            }

            const reportTypeOptions = ref([
                {
                    label: 'OD List Report',
                    value: 1
                },
                {
                    label: 'Count Analysis Report',
                    value: 2
                },
                {
                    label: 'Day Wise Count Analysis',
                    value: 3
                }
                ,
                {
                    label: 'Month Wise Count Analysis Reports',
                    value: 4
                }
            ])

            const companyOptions = ref([])
            axios.get('/api/administration/get-company-options')
                .then(res => {
                    companyOptions.value = res.data.data
                })

            const gradeOptions = ref([])
            axios.get('/api/new/get-grade-master')
                .then(res => {
                    gradeOptions.value = res.data
                })


            const branchOptions = ref([
                {
                    label: 'Factory',
                    value: 1
                },
                {
                    label: 'Office',
                    value: 2
                },
                {
                    label: 'SITE',
                    value: 3
                },
            ])

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

            const managerEmployeeOptions = ref([])
            axios.get('/api/get-users-name-options')
                .then(res => {
                    managerEmployeeOptions.value = res.data.data
                })

            const statusOptions = ref([
                {
                    text: 'All',
                    value: 1
                },
                {
                    text: 'Current',
                    value: 2
                },
                {
                    text: 'Left',
                    value: 3
                },
                {
                    text: 'Web Active',
                    value: 4
                },
            ])

            const leaveTypeOptions = ref([
                {
                    label: 'Outdoor Duty',
                    value: 1
                }
            ])

            const applicationStatusOptions = ref([
                {
                    label: 'Approved',
                    value: 1
                },
                {
                    label: 'In Process',
                    value: 2
                },
                {
                    label: 'Rejected',
                    value: 3
                },
                {
                    label: 'Lapsed',
                    value: 4
                },
                {
                    label: 'Cancelled',
                    value: 5
                },
            ])

            const orderByOptions = ref([
                {
                    label: 'Employee Code',
                    value: 1
                },
                {
                    label: 'Employee Name',
                    value: 2
                },
                {
                    label: 'Approved Date',
                    value: 3
                },
            ])
            const levelOneOptions = ref([
                {label: 'Group', value: 1},
                {label: 'Grade', value: 2},
                {label: 'Branch', value: 3},
                {label: 'Department', value: 4},
                {label: 'Division', value: 5},
                {label: 'Unit', value: 6},
                {label: 'Category', value: 7},
            ])

            const levelTwoOptions = ref([
                {label: 'Group', value: 1},
                {label: 'Grade', value: 2},
                {label: 'Branch', value: 3},
                {label: 'Department', value: 4},
                {label: 'Division', value: 5},
                {label: 'Unit', value: 6},
                {label: 'Category', value: 7},
            ])

            const levelThreeOptions = ref([
                {label: 'Group', value: 1},
                {label: 'Grade', value: 2},
                {label: 'Branch', value: 3},
                {label: 'Department', value: 4},
                {label: 'Division', value: 5},
                {label: 'Unit', value: 6},
                {label: 'Category', value: 7},
            ])

            const formData = ref({
                report_type: 1,
                company_name: null,
                grade: null,
                branch: null,
                department: null,
                division: null,
                unit: null,
                category: null,
                group: null,
                employee_name: null,
                manager_employee: null,
                status: null,
                approve_form_date: forMatIndianDate(),
                approve_to_date: forMatIndianDate(),
                application_form_date: forMatIndianDate(),
                application_to_date: forMatIndianDate(),
                outdoor_duty_form_date: forMatIndianDate(),
                outdoor_duty_to_date: forMatIndianDate(),
                outdoor_duty_form_days: null,
                outdoor_duty_to_days: null,
                od_instance_count_from: null,
                od_instance_count_to: null,
                leave_type: null,
                application_status: null,
                order_by: null,
                masterGrand: null,
                masterBranch: null,
                masterDepartment: null,
                masterDivision: null,
                masterUnit: null,
                masterCategory: null,
                masterGroup: null,
                masterDesignation: null,
                level_1: 2,
                level_2: null,
                level_3: null,
            })

            return {
                formData,
                companyOptions,
                reportTypeOptions,
                gradeOptions,
                branchOptions,
                departmentOptions,
                divisionOptions,
                unitOptions,
                categoryOptions,
                groupOptions,
                employeeOptions,
                managerEmployeeOptions,
                statusOptions,
                dateFormat,
                formatDates,
                getApplicationFormDate,
                getApplicationToDate,
                getApproveFormDate,
                getApproveToDate,
                getOutdoorDutyFormDate,
                getOutdoorDutyToDate,
                leaveTypeOptions,
                applicationStatusOptions,
                orderByOptions,
                levelOneOptions,
                levelTwoOptions,
                levelThreeOptions
            }
        }
    }
</script>
