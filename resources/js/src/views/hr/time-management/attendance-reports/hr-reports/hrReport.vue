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
                                <b-col md="6">
                                    <b-form-group
                                        label="Order By"
                                        label-for="order_by"
                                    >
                                        <v-select
                                            v-model="formData.orderBy"
                                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                            :options="orderByOptions"
                                            :clearable="false"
                                            :reduce="val => val.value"
                                            input-id="orderBy"
                                            placeholder="Select Order By"
                                        />
                                    </b-form-group>
                                </b-col>
                            </b-row>
                        </b-col>
                        <b-col md="6">
                            <b-row>
                                <b-col md="6">
                                    <b-form-group
                                        label="IP Address"
                                        label-for="ip_address"
                                    >
                                        <b-form-input
                                            id="ip_address"
                                            v-model="formData.ip_address"
                                        />
                                    </b-form-group>
                                </b-col>
                                <b-col md="6">
                                    <b-form-group
                                        label="Machine Name"
                                        label-for="machine_name"
                                    >
                                        <b-form-input
                                            id="machine_name"
                                            v-model="formData.machine_name"
                                        />
                                    </b-form-group>
                                </b-col>
                            </b-row>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col md="5">
                            <b-row>
                                <b-col md="7">
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
                                <b-col md="5">
                                    <b-form-group
                                        label="Marked Type As"
                                        label-for="marke_type_as"
                                    >
                                        <v-select
                                            v-model="formData.marke_type_as"
                                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                            :options="markTypeOptions"
                                            :clearable="false"
                                            :reduce="val => val.value"
                                            input-id="marke_type_as"
                                        />
                                    </b-form-group>
                                </b-col>
                            </b-row>
                        </b-col>
                        <b-col md="7">
                            <b-row>
                                <b-col md="3">
                                    <b-form-group
                                        label="In / Out"
                                        label-for="in_out"
                                    >
                                        <v-select
                                            v-model="formData.in_out"
                                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                            :options="inOutOptions"
                                            :clearable="false"
                                            :reduce="val => val.value"
                                            input-id="in_out"
                                        />
                                    </b-form-group>
                                </b-col>
                                <b-col md="3">
                                    <b-form-group
                                        label="Fance"
                                        label-for="fance"
                                    >
                                        <v-select
                                            v-model="formData.fance"
                                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                            :options="fanceOptions"
                                            :clearable="false"
                                            :reduce="val => val.value"
                                            placeholder="Select fance"
                                            input-id="fance"
                                        />
                                    </b-form-group>
                                </b-col>
                                <b-col md="6" class="mt-2">
                                    <b-form-checkbox
                                        v-model="formData.show_employee"
                                        name="show_employee"
                                    >
                                        Show Employee wise List
                                    </b-form-checkbox>
                                </b-col>
                            </b-row>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col md="7">
                            <b-form-group
                                label="User Day Types"
                                label-for="user_day_types"
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
                        <b-col md="5">
                            <div class="demo-inline-spacing">
                                <b-form-checkbox
                                    v-model="formData.show_record_swipe_date"
                                    name="show_record_swipe_date"
                                >
                                    Show record(s) for which Swipe date is not updated
                                </b-form-checkbox>
                                <b-form-checkbox
                                    v-model="formData.calculate_lost_hours"
                                    name="calculate_lost_hours"
                                >
                                    Calculate Lost Hours
                                </b-form-checkbox>
                                <b-form-checkbox
                                    v-model="formData.calculate_effective_hours"
                                    name="calculate_effective_hours"
                                >
                                    Calculate Effective Hours
                                </b-form-checkbox>
                            </div>
                        </b-col>
                    </b-row>
                    <hr>
                    <b-row>
                        <b-col md="6">
                            <b-row>
                                <b-col md="6">
                                    <b-form-group
                                        label="From In Time"
                                        label-for="from_in_time"
                                    >
                                        <b-form-input
                                            id="from_in_time"
                                            v-model="formData.from_in_time"
                                        />
                                    </b-form-group>
                                </b-col>
                                <b-col md="6">
                                    <b-form-group
                                        label="To In Time"
                                        label-for="to_in_time"
                                    >
                                        <b-form-input
                                            id="to_in_time"
                                            v-model="formData.to_in_time"
                                        />
                                    </b-form-group>
                                </b-col>
                            </b-row>
                        </b-col>
                        <b-col md="6">
                            <b-row>
                                <b-col md="6">
                                    <b-form-group
                                        label="From Out Time"
                                        label-for="from_out_time"
                                    >
                                        <b-form-input
                                            id="from_out_time"
                                            v-model="formData.from_out_time"
                                        />
                                    </b-form-group>
                                </b-col>
                                <b-col md="6">
                                    <b-form-group
                                        label="To Out Time"
                                        label-for="to_out_time"
                                    >
                                        <b-form-input
                                            id="to_out_time"
                                            v-model="formData.to_out_time"
                                        />
                                    </b-form-group>
                                </b-col>
                            </b-row>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col md="6">
                            <b-row>
                                <b-col md="6">
                                    <b-form-group
                                        label="From Total Hrs."
                                        label-for="from_total_hrs"
                                    >
                                        <b-form-input
                                            id="from_total_hrs"
                                            v-model="formData.from_total_hrs"
                                        />
                                    </b-form-group>
                                </b-col>
                                <b-col md="6">
                                    <b-form-group
                                        label="To Total Hrs."
                                        label-for="to_total_hrs"
                                    >
                                        <b-form-input
                                            id="to_total_hrs"
                                            v-model="formData.to_total_hrs"
                                        />
                                    </b-form-group>
                                </b-col>
                            </b-row>
                        </b-col>
                        <b-col md="6">
                            <b-row>
                                <b-col md="4">
                                    <b-form-group
                                        label="Day Marked As"
                                        label-for="day_marked"
                                    >
                                        <v-select
                                            v-model="formData.day_marked"
                                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                            :options="dayMarkedOptions"
                                            :clearable="false"
                                            :reduce="val => val.value"
                                            placeholder="Select"
                                            input-id="day_marked"
                                        />
                                    </b-form-group>
                                </b-col>
                                <b-col md="8" class="mt-2">
                                    <b-form-checkbox
                                        v-model="formData.show_only_latemark_empolyee"
                                        name="calculate_lost_hours"
                                    >
                                        Show only latemarked employees
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
                            :to="{name:'view-hr-reports'}"
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
        BFormRadioGroup,
        BInputGroupPrepend
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
            BInputGroupPrepend,
            BButton
        },
        setup() {
            const markTypeOptions = ref([
                {label:'AWS', value: 1},
                {label: 'CL', value: 2},
            ])

            const shiftOptions = ref([
                {label:'9:00AM ~ 6:00PM', value: 1},
                {label: '2:00PM ~ 10:30PM', value: 2},
            ])

            const orderByOptions = ref([
                {label: 'Employee Name', value: 1},
                {label: 'Employee Code', value: 2},
            ])

            const genderOptions = ref([
                {label: 'All', value: 1},
                {label: 'Male', value: 2},
                {label: 'Female', value: 3},
                {label: 'Other', value: 4},
            ])

            const attendanceGroupOptions = ref([
                {label: 'Spine Type', value: 1},
                {label: 'User Defined Type', value: 2},
            ])

            const inOutOptions = ref([
                {label: 'In', value: 1},
                {label: 'Out', value: 2},
                {label: 'X', value: 3},
                {label: 'Z', value: 4},
            ])

            const fanceOptions = ref([
                {label: 'All', value: 1},
                {label: 'Within Range', value: 2},
                {label: 'Outside Range', value: 3},
            ])

            const dayMarkedOptions = ref([
                {label: 'ABS', value: 1},
                {label: 'CL', value: 2},
                {label: 'OD', value: 3}
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

            const reportTypeOptions = ref([
                {label: 'Daily InOut Daily Report', value: 1},
                {label: 'Daily InOur Summary Report', value: 2},
                {label: 'Monthly Attendance Report', value: 3},
                {label: 'Daily Attendance Report', value: 4},
                {label: 'Day Wise Unswiped Report', value: 5},
                {label: 'Presenntee Employee count Report', value: 6},
            ])

            const blankFormData = {
                report_type:null,
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
                gender:null,
                orderBy:null,
                ip_address:null,
                machine_name:null,
                shift:null,
                marke_type_as:null,
                in_out:null,
                fance:null,
                show_employee:null,
                dayTypeAbs:null,
                dayTypeCl:null,
                dayTypeCoMinus:null,
                dayTypeCoPlus:null,
                dayTypeDp:null,
                dayTypeEo:null,
                dayTypeLone:null,
                dayTypeLtwo:null,
                dayTypeTypeLthree:null,
                dayTypeLfour:null,
                dayTypeLfive:null,
                dayTypeLwp:null,
                dayTypeOd:null,
                dayTypeOl:null,
                dayTypePh:null,
                dayTypePhp:null,
                dayTypePl:null,
                dayTypeSl:null,
                dayTypeSv:null,
                dayTypeWo:null,
                dayTypeWop:null,
                show_record_swipe_date:null,
                calculate_lost_hours:null,
                calculate_effective_hours:null,
                from_in_time:null,
                to_in_time:null,
                from_out_time:null,
                to_out_time:null,
                from_total_hrs:null,
                to_total_hrs:null,
                day_marked:null,
                show_only_latemark_empolyee:null,
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
                reportTypeOptions,
                inOutOptions,
                fanceOptions,
                genderOptions,
                orderByOptions,
                shiftOptions,
                markTypeOptions,
                dayMarkedOptions
            }
        }
    }
</script>
