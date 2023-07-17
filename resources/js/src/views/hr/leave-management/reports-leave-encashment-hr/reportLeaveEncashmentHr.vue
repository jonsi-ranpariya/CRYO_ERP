<template>
    <div>
        <b-card-code>
            <b-form>
                <b-row>
                    <b-col md="5">
                        <b-row>
                            <b-col md="6">
                                <b-form-group
                                    label="Request Date"
                                    label-for="request_from_date"
                                >
                                    <b-input-group>
                                        <cleave
                                            id="request_from_date"
                                            v-model="formData.request_from_date"
                                            class="form-control"
                                            :raw="false"
                                            :options="dateFormat"
                                            placeholder="DD/MM/YYYY"
                                            show-decade-nav
                                        />
                                        <b-input-group-append>
                                            <b-form-datepicker
                                                v-model="formatDates.request_from_date"
                                                button-only
                                                @input="getRequestFromDate($event)"
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
                                    label="To Date"
                                    label-for="request_to_date"
                                >
                                    <b-input-group>
                                        <cleave
                                            id="request_to_date"
                                            v-model="formData.request_to_date"
                                            class="form-control"
                                            :raw="false"
                                            :options="dateFormat"
                                            placeholder="DD/MM/YYYY"
                                            show-decade-nav
                                        />
                                        <b-input-group-append>
                                            <b-form-datepicker
                                                v-model="formatDates.request_to_date"
                                                button-only
                                                @input="getRequestToFormDate($event)"
                                                show-decade-nav
                                                size="sm"
                                                nav-button-variant="primary"
                                            />
                                        </b-input-group-append>
                                    </b-input-group>
                                </b-form-group>
                            </b-col>
                        </b-row>
                    </b-col>
                    <b-col md="7">
                        <b-form-group
                            label="Month Year"
                            label-for="request_to_date"
                        >
                            <b-row>
                                <b-col md="1">
                                    <b-form-checkbox
                                        v-model="formData.Selected"
                                        name="monthYearCheck"
                                        type="checkbox"
                                    >
                                    </b-form-checkbox>
                                </b-col>
                                <b-col md="5">
                                    <v-select
                                        v-model="formData.month"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="monthOptions"
                                        :clearable="false"
                                        :reduce="val => val.value"
                                        placeholder="Month"
                                        input-id="month"
                                        v-bind:disabled="!formData.Selected"
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
                                        input-id="YearPresent"
                                        v-bind:disabled="!formData.Selected"
                                    />
                                </b-col>
                                <b-col md="1"></b-col>
                            </b-row>
                        </b-form-group>
                    </b-col>
                </b-row>
                <b-row>
                    <b-col md="5">
                        <b-row>
                            <b-col md="6">
                                <b-form-group
                                    label="Approver Date"
                                    label-for="approver_from_date"
                                >
                                    <b-input-group>
                                        <cleave
                                            id="approver_from_date"
                                            v-model="formData.approver_from_date"
                                            class="form-control"
                                            :raw="false"
                                            :options="dateFormat"
                                            placeholder="DD/MM/YYYY"
                                            show-decade-nav
                                        />
                                        <b-input-group-append>
                                            <b-form-datepicker
                                                v-model="formatDates.approver_from_date"
                                                button-only
                                                @input="getApproverFromDate($event)"
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
                                    label="To Date"
                                    label-for="approver_to_date"
                                >
                                    <b-input-group>
                                        <cleave
                                            id="approver_to_date"
                                            v-model="formData.approver_to_date"
                                            class="form-control"
                                            :raw="false"
                                            :options="dateFormat"
                                            placeholder="DD/MM/YYYY"
                                            show-decade-nav
                                        />
                                        <b-input-group-append>
                                            <b-form-datepicker
                                                v-model="formatDates.approver_to_date"
                                                button-only
                                                @input="getApproverToFormDate($event)"
                                                show-decade-nav
                                                size="sm"
                                                nav-button-variant="primary"
                                            />
                                        </b-input-group-append>
                                    </b-input-group>
                                </b-form-group>
                            </b-col>
                        </b-row>
                    </b-col>
                    <b-col md="7">
                        <b-row>
                            <b-col>
                                <b-form-group
                                    label="Status"
                                    label-for="statusStage"
                                >
                                    <v-select
                                        v-model="formData.statusStage"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="statusStageOptions"
                                        :clearable="false"
                                        :reduce="val => val.value"
                                        placeholder="Select Status"
                                        input-id="statusStage"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col>
                                <b-form-group
                                    label="User Leave Type"
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
                                        disabled
                                    />
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
        BInputGroup,
        BInputGroupAppend,
        BFormDatepicker,
        BFormCheckbox,
        BFormRadioGroup,
        BButton
    } from 'bootstrap-vue'
    import BCardCode from "@core/components/b-card-code/BCardCode";
    import {ref} from "@vue/composition-api";
    import {forMatIndianDate} from "@core/utils/utils";
    import Cleave from 'vue-cleave-component'
    import vSelect from 'vue-select'
    import axios from '@axios'
    import moment from 'moment'

    export default {
        components: {
            BCardCode,
            BForm,
            BRow,
            BCol,
            BFormGroup,
            BInputGroup,
            BInputGroupAppend,
            BFormDatepicker,
            Cleave,
            vSelect,
            BFormCheckbox,
            BFormRadioGroup,
            BButton
        },
        setup() {
            const dateFormat = ref({
                date: true,
                delimiter: '/',
                datePattern: ['d', 'm', 'Y'],
            })

            const formatDates = ref({
                request_from_date: null,
                request_to_date: null,
                approver_from_date: null,
                approver_to_date: null,
            })

            const getRequestFromDate = (date) => {
                formData.value.request_from_date = forMatIndianDate(date)
            }
            const getRequestToFormDate = (date) => {
                formData.value.request_to_date = forMatIndianDate(date)
            }
            const getApproverFromDate = (date) => {
                formData.value.approver_from_date = forMatIndianDate(date)
            }
            const getApproverToDate = (date) => {
                formData.value.approver_to_date = forMatIndianDate(date)
            }

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
                    label: new Date().getFullYear() - 1,
                    value: new Date().getFullYear() - 1
                },
                {
                    label: new Date().getFullYear(),
                    value: new Date().getFullYear()
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
            const leaveTypeOptions = ref([
                {
                    label: 'Privilege Leave (PL)',
                    value: 1
                }
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
                request_from_date: forMatIndianDate(),
                request_to_date: forMatIndianDate(),
                Selected: null,
                month: null,
                YearPresent: null,
                approver_from_date: forMatIndianDate(),
                approver_to_date: forMatIndianDate(),
                statusStage: null,
                leave_type: 1,
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
            })

            return {
                formData,
                dateFormat,
                formatDates,
                getRequestFromDate,
                getRequestToFormDate,
                monthOptions,
                getApproverFromDate,
                getApproverToDate,
                statusStageOptions,
                statusOptions,
                leaveTypeOptions,
                employeeOptions,
                branchOptions,
                groupOptions,
                divisionOptions,
                departmentOptions,
                unitOptions,
                companyOptions,
                categoryOptions,
                gradeOptions,
                yearPresentOptions,
            }
        }
    }
</script>
