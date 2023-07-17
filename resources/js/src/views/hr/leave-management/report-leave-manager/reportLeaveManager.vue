<template>
    <div>
        <b-card-code>
            <b-form>
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
                    <b-col md="3">
                        <v-select
                            v-model="formData.report_Detail"
                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                            :options="reportDetailOptions"
                            :clearable="false"
                            :reduce="val => val.value"
                            placeholder="Select Status"
                            input-id="report_Detail"
                            class="mt-2"
                        />
                    </b-col>
                    <b-col md="5">
                        <div v-if="formData.reportType === 1">
                            <b-form-radio-group
                                id="selected"
                                class="d-flex mt-2"
                                v-model="formData.selected"
                                :options="leaveTypeOptions"
                            />
                        </div>
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
                <b-row>
                    <b-col md="6">
                        <b-row>
                            <b-col md="6">
                                <b-form-group
                                    label="Leave Form Date"
                                    label-for="leave_form_date"
                                >
                                    <b-input-group>
                                        <cleave
                                            id="leave_form_date"
                                            v-model="formData.leave_form_date"
                                            class="form-control"
                                            :raw="false"
                                            :options="dateFormat"
                                            placeholder="DD/MM/YYYY"
                                            show-decade-nav
                                        />
                                        <b-input-group-append>
                                            <b-form-datepicker
                                                v-model="formatDates.leave_form_date"
                                                button-only
                                                @input="getLeaveFormDate($event)"
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
                                    label="Leave To Date"
                                    label-for="leave_to_date"
                                >
                                    <b-input-group>
                                        <cleave
                                            id="leave_to_date"
                                            v-model="formData.leave_to_date"
                                            class="form-control"
                                            :raw="false"
                                            :options="dateFormat"
                                            placeholder="DD/MM/YYYY"
                                            show-decade-nav
                                        />
                                        <b-input-group-append>
                                            <b-form-datepicker
                                                v-model="formatDates.leave_to_date"
                                                button-only
                                                @input="getLeaveToDate($event)"
                                                show-decade-nav
                                                size="sm"
                                                nav-button-variant="primary"
                                            />
                                        </b-input-group-append>
                                    </b-input-group>
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <div v-if="formData.reportType === 1">
                            <b-row>
                                <b-col md="6">
                                    <b-form-group
                                        label="Leave Form Days"
                                        label-for="leave_form_days"
                                    >
                                        <b-form-input
                                            id="leave_form_days"
                                            placeholder="Form Days"
                                            v-model="formData.leave_form_days"
                                        />
                                    </b-form-group>
                                </b-col>
                                <b-col md="6">
                                    <b-form-group
                                        label="Leave To Days"
                                        label-for="leave_to_days"
                                    >
                                        <b-form-input
                                            id="leave_to_days"
                                            placeholder="To Days"
                                            v-model="formData.leave_to_days"
                                        />
                                    </b-form-group>
                                </b-col>
                            </b-row>
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
                    </b-col>
                    <b-col md="6">
                        <div v-if="formData.reportType === 1">
                            <b-row>
                                <b-col md="6">
                                    <b-form-group
                                        label="Leave Instance Count From"
                                        label-for="leave_instance_count_from"
                                    >
                                        <b-form-input
                                            id="leave_instance_count_from"
                                            placeholder="Form Days"
                                            v-model="formData.leave_instance_count_from"
                                        />
                                    </b-form-group>
                                </b-col>
                                <b-col md="6">
                                    <b-form-group
                                        label="Leave Instance Count To"
                                        label-for="leave_instance_count_to"
                                    >
                                        <b-form-input
                                            id="leave_instance_count_to"
                                            placeholder="To Days"
                                            v-model="formData.leave_instance_count_to"
                                        />
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col md="6">
                                    <b-form-group
                                        label="Leave Type"
                                        label-for="leave_type"
                                    >
                                        <v-select
                                            v-model="formData.leave_type"
                                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                            :options="leaveTypesOptions"
                                            :clearable="false"
                                            :reduce="val => val.value"
                                            placeholder="Leave Type"
                                            input-id="leave_type"
                                        />
                                    </b-form-group>
                                </b-col>
                                <b-col md="6">
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
                                            placeholder="Select Status"
                                            input-id="application_status"
                                        />
                                    </b-form-group>
                                </b-col>
                            </b-row>
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
                <br>
                <b-row>
                    <div v-if="formData.report_Detail === 2 || formData.reportType === 1">
                        <b-col md="12">
                            <b-form-checkbox
                                v-model="formData.leave_application_pasy_day"
                                name="grand"
                                class="mb-1"
                            >
                                Show leave application for past days only ( leave request date is lesser than
                                application date )
                            </b-form-checkbox>
                        </b-col>
                    </div>
                </b-row>
                <div v-if="formData.reportType === 1 && formData.report_Detail === 1">
                    <b-row>
                        <b-col md="12">
                            <b-form-checkbox
                                v-model="formData.feedback_All_manager"
                                name="grand"
                                class="mb-1"
                            >
                                Show feedback of all Managers
                            </b-form-checkbox>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col md="12">
                            <b-form-checkbox
                                v-model="formData.continuous_leave"
                                name="grand"
                                class="mb-1"
                            >
                                Continuous Leave (To Date of one application and From Date of another application is
                                continuous)
                            </b-form-checkbox>
                        </b-col>
                    </b-row>
                </div>
                <div v-if="formData.reportType === 1">
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
            BButton,
            BFormCheckbox,
            BFormDatepicker,
            Cleave,
            BInputGroup,
            BInputGroupAppend
        },
        setup() {
            const dateFormat = ref({
                date: true,
                delimiter: '/',
                datePattern: ['d', 'm', 'Y'],
            })

            const formatDates = ref({
                approve_form_date: null,
                approve_to_date: null,
                application_form_date: null,
                application_to_date: null,
                leave_form_date: null,
                leave_to_date: null,
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

            const getLeaveFormDate = (date) => {
                formData.value.leave_form_date = forMatIndianDate(date)
            }

            const getLeaveToDate = (date) => {
                formData.value.leave_to_date = forMatIndianDate(date)
            }
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

            const reportTypeOptions = ref([
                {
                    label: 'Leave List Report',
                    value: 1
                },
                {
                    label: 'Leave Approved List Report',
                    value: 2
                },
            ])
            const leaveTypesOptions = ref([
                {
                    label: 'Leave Without pay',
                    value: 1
                },
                {
                    label: 'Casual Leave',
                    value: 2
                },
                {
                    label: 'Sick Leave',
                    value: 3
                },
                {
                    label: 'Privilege Leave',
                    value: 4
                },
                {
                    label: 'CO-',
                    value: 5
                }
            ])

            const leaveTypeOptions = ref([
                {
                    text: 'Leave Application',
                    value: 'Leave Application'
                },
                {
                    text: 'Leave Cancellation',
                    value: 'Leave Cancellation'
                }
            ])

            const reportDetailOptions = ref([
                {
                    label: 'Detail Report',
                    value: 1
                },
                {
                    label: 'Summary Report',
                    value: 2
                },
            ])

            const statusStageOptions = ref([
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
                reportType: 1,
                selected: 'Leave Application',
                report_Detail: 1,
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
                approve_form_date: null,
                approve_to_date: null,
                application_form_date: null,
                application_to_date: null,
                leave_form_date: null,
                leave_to_date: null,
                leave_form_days: null,
                leave_to_days: null,
                leave_instance_count_from: null,
                leave_instance_count_to: null,
                leave_type: null,
                application_status: null,
                order_by: null,
                leave_application_pasy_day: null,
                feedback_All_manager: null,
                continuous_leave: null,
                masterGrand: null,
                masterBranch: null,
                masterDepartment: null,
                masterDivision: null,
                masterUnit: null,
                masterCategory: null,
                masterGroup: null,
                masterDesignation: null,
            })

            return {
                reportTypeOptions,
                formData,
                leaveTypeOptions,
                reportDetailOptions,
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
                dateFormat,
                formatDates,
                getApplicationFormDate,
                getApplicationToDate,
                getApproveFormDate,
                getApproveToDate,
                getLeaveFormDate,
                getLeaveToDate,
                applicationStatusOptions,
                orderByOptions,
                leaveTypesOptions
            }
        }
    }
</script>
