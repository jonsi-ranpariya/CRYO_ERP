<template>
    <div>
        <b-card-code>
            <b-form>
                <b-row>
                    <b-col md="5">
                        <b-form-group
                            label="Shift Transfer Type"
                            label-for="shift_transfer_type"
                        >
                            <v-select
                                v-model="formData.shift_transfer_type"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="shiftTypeOptions"
                                :clearable="false"
                                :reduce="val => val.value"
                                placeholder="Select Type"
                                id="shift_transfer_type"
                            />
                        </b-form-group>
                    </b-col>
                </b-row>
                <b-row>
                    <b-col md="4">
                        <b-form-group>
                            <label for="transfer_date">Transfer Date <span
                                class="text-danger erp_required_star"
                            >*</span></label>

                            <b-input-group>
                                <cleave
                                    id="transfer_date"
                                    v-model="formData.transfer_date"
                                    class="form-control"
                                    :raw="false"
                                    :options="dateFormat"
                                    placeholder="DD/MM/YYYY"
                                    show-decade-nav
                                    @input="getFormDate($event)"
                                />
                                <b-input-group-append>
                                    <b-form-datepicker
                                        v-model="formatDates.transfer_date"
                                        button-only
                                        @input="getTransferFormatDate($event)"
                                        show-decade-nav
                                        size="sm"
                                        nav-button-variant="primary"
                                        type="date"
                                    />
                                </b-input-group-append>
                            </b-input-group>
                        </b-form-group>
                    </b-col>
                    <b-col md="4">
                        <b-form-group>
                            <label for="existing_shift">Existing Shift <span
                                class="text-danger erp_required_star"
                            >*</span></label>

                            <v-select
                                v-model="formData.existing_shift"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="existingShiftOptions"
                                :clearable="false"
                                :reduce="val => val.value"
                                placeholder="Select Shift"
                                id="existing_shift"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="4">
                        <b-form-group>
                            <label for="new_shift">New Shift <span
                                class="text-danger erp_required_star"
                            >*</span></label>

                            <v-select
                                v-model="formData.existing_shift"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="newShiftOptions"
                                :clearable="false"
                                :reduce="val => val.value"
                                placeholder="Select Shift"
                                id="new_shift"
                            />
                        </b-form-group>
                    </b-col>
                </b-row>
                <b-row>
                    <b-col md="4">
                        <b-form-group>
                            <label for="existing_sat_shift">Existing Sat. Shift <span
                                class="text-danger erp_required_star"
                            >*</span></label>

                            <v-select
                                v-model="formData.existing_sat_shift"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="existingSatShiftOptions"
                                :clearable="false"
                                :reduce="val => val.value"
                                placeholder="Select Shift"
                                id="existing_sat_shift"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="4">
                        <b-form-group>
                            <label for="new_sat_shift">New Sat. Shift <span
                                class="text-danger erp_required_star"
                            >*</span></label>

                            <v-select
                                v-model="formData.new_sat_shift"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="newSatShiftOptions"
                                :clearable="false"
                                :reduce="val => val.value"
                                placeholder="Select Shift"
                                id="new_sat_shift"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="4">
                        <b-form-group
                            label="Transfer Type"
                            label-for="transfer_type"
                        >
                            <v-select
                                v-model="formData.transfer_type"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="transferTypeOptions"
                                :clearable="false"
                                :reduce="val => val.value"
                                placeholder="Select Type"
                                id="transfer_type"
                            />
                        </b-form-group>
                    </b-col>
                </b-row>
                <hr>
                <b-row>
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
                                input-id="department"
                                placeholder="Select Department"
                            />
                        </b-form-group>
                    </b-col>
                </b-row>
                <b-row>
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
                </b-row>
                <b-row>
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
                        :to="{name: 'add-multiple-shift-transfer-by-hr'}"
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
                transfer_date: null,
            })

            const getTransferFormatDate = (date) => {
                formData.value.transfer_date = forMatIndianDate(date)
            }

            const existingShiftOptions = ref([
                {label: '6:00AM ~   12:00PM-13', value: 1},
                {label: '1:00PM ~   6:00PM-13', value: 2},
            ])

            const newShiftOptions = ref([
                {label: '6:00AM ~   12:00PM-13', value: 1},
                {label: '1:00PM ~   6:00PM-13', value: 2},
            ])
            const existingSatShiftOptions = ref([
                {label: '6:00AM ~   12:00PM-13', value: 1},
                {label: '1:00PM ~   6:00PM-13', value: 2},
            ])
            const newSatShiftOptions = ref([
                {label: '6:00AM ~   12:00PM-13', value: 1},
                {label: '1:00PM ~   6:00PM-13', value: 2},
            ])
            const transferTypeOptions = ref([
                {label: '6:00AM ~   12:00PM-13', value: 1},
                {label: '1:00PM ~   6:00PM-13', value: 2},
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

            const shiftTypeOptions = ref([
                {label: 'Shift Transfer Using Existing Shift', value: 1},
                {label: 'Shift Transfer as Per Date', value: 1},
                {label: 'Shift Allocation For New Employee', value: 1},
            ])

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
                employeeOptions,
                departmentOptions,
                divisionOptions,
                branchOptions,
                statusOptions,
                dateFormat,
                formatDates,
                getTransferFormatDate,
                shiftTypeOptions,
                existingShiftOptions,
                newShiftOptions,
                existingSatShiftOptions,
                newSatShiftOptions,
                transferTypeOptions
            }
        }
    }
</script>
