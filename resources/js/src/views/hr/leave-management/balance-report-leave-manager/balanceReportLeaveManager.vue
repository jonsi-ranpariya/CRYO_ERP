<template>
    <div>

        <b-card-code>
            <b-form>
                <b-row>
                    <b-col md="4">
                        <b-form-group
                            label="For the Period"
                            label-for="for_the_period"
                        >
                            <v-select
                                v-model="formData.for_the_period"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="forPeriodOptions"
                                :clearable="false"
                                :reduce="val => val.value"
                                placeholder="Select"
                                input-id="for_the_period"
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
                </b-row>
                <hr>
                <b-col md="12">
                    <h5>Select User Leave Type</h5>
                </b-col>
                <hr>
                <b-row>
                    <b-col md="12">
                        <div class="demo-inline-spacing">
                            <b-form-checkbox
                                v-model="formData.privilege_leave"
                                name="grand"
                            >
                                PL
                            </b-form-checkbox>
                            <b-form-checkbox
                                v-model="formData.casual_leave"
                                name="branch"
                            >
                                CL
                            </b-form-checkbox>
                            <b-form-checkbox
                                v-model="formData.sick_leave"
                                name="department"
                            >
                                SL
                            </b-form-checkbox>
                            <b-form-checkbox
                                v-model="formData.ordinary_leave"
                                name="division"
                            >
                                OL
                            </b-form-checkbox>
                            <b-form-checkbox
                                v-model="formData.co_leave"
                                name="unit"
                            >
                                CO-/CO+
                            </b-form-checkbox>
                            <b-form-checkbox
                                v-model="formData.leave_l1"
                                name="category"
                            >
                                L1
                            </b-form-checkbox>
                            <b-form-checkbox
                                v-model="formData.leave_l2"
                                name="group"
                            >
                                L2
                            </b-form-checkbox>
                            <b-form-checkbox
                                v-model="formData.leave_l3"
                                name="group"
                            >
                                L3
                            </b-form-checkbox>
                            <b-form-checkbox
                                v-model="formData.leave_l4"
                                name="designation"
                            >
                                L4
                            </b-form-checkbox>
                            <b-form-checkbox
                                v-model="formData.leave_l5"
                                name="designation"
                            >
                                L5
                            </b-form-checkbox>
                        </div>
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
    import moment from "moment";

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
                for_the_period:null,
                company_name:null,
                grade:null,
                branch:null,
                department:null,
                division:null,
                unit:null,
                category:null,
                group:null,
                employee_name:null,
                status:'Current',
                privilege_leave: null,
                casual_leave: null,
                sick_leave: null,
                ordinary_leave: null,
                co_leave: null,
                leave_l1: null,
                leave_l2: null,
                leave_l3: null,
                leave_l4: null,
                leave_l5: null,
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
                forPeriodOptions
            }
        }
    }
</script>
