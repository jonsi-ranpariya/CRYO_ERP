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
                                    <span>Find the description for the abbreviation used below.</span><br>
                                    <span>SPST=Spine-Daytype; PRST=User-daytype; SHFT=shift-code; SHIFT IN=shift-intime; SHIFT OUT=shift-outtime;</span><br>
                                    <span>COFF=CutoffTime; F-DAY=shift-hr-fullday; H-DAY=shift-hr-fullday; ARRV=intime; DEPT=outtime; WORK=tot hr worked;</span><br>
                                    <span>LATE=late in; EARL=early going by; EXTR=extra our;OT=over time; LT=lost time; E-HRS=Effective Hrs; LateMark=latemark;</span><br>
                                </div>
                            </b-alert>
                            <hr>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col md="12">
                            <b-row>
                                <b-col md="3">
                                    <b-form-group
                                        label="Select Grouping"
                                        label-for="select_grouping"
                                    >
                                        <v-select
                                            v-model="formData.select_grouping"
                                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                            :options="groupingOptions"
                                            :clearable="false"
                                            :reduce="val => val.value"
                                            placeholder="Select Grouping"
                                            input-id="select_grouping"
                                        />
                                    </b-form-group>
                                </b-col>
                                <b-col md="9">
                                    <b-form-group
                                        label="Selection for Row"
                                        label-for="selection_for_row"
                                    >
                                        <div class="demo-inline-spacing">
                                            <b-form-checkbox
                                                v-model="formData.genderCheck"
                                                name="gender"
                                            >
                                                Gender
                                            </b-form-checkbox>
                                            <b-form-checkbox
                                                v-model="formData.gradeCheck"
                                                name="grade"
                                            >
                                                Grade
                                            </b-form-checkbox>
                                            <b-form-checkbox
                                                v-model="formData.branchCheck"
                                                name="branch"
                                            >
                                                Branch
                                            </b-form-checkbox>
                                            <b-form-checkbox
                                                v-model="formData.departmentCheck"
                                                name="department"
                                            >
                                                Department
                                            </b-form-checkbox>
                                            <b-form-checkbox
                                                v-model="formData.designationCheck"
                                                name="designation"
                                            >
                                                Designation
                                            </b-form-checkbox>
                                            <b-form-checkbox
                                                v-model="formData.divisionCheck"
                                                name="division"
                                            >
                                                Division
                                            </b-form-checkbox>
                                            <b-form-checkbox
                                                v-model="formData.unitCheck"
                                                name="unit"
                                            >
                                                Unit
                                            </b-form-checkbox>
                                            <b-form-checkbox
                                                v-model="formData.categoryCheck"
                                                name="category"
                                            >
                                                Category
                                            </b-form-checkbox>
                                            <b-form-checkbox
                                                v-model="formData.groupCheck"
                                                name="group"
                                            >
                                                Group
                                            </b-form-checkbox>
                                        </div>
                                    </b-form-group>
                                </b-col>
                            </b-row>
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
                                            placeholder="Select Gender"
                                            input-id="gender"
                                        />
                                    </b-form-group>
                                </b-col>
                                <b-col md="6">
                                    <b-form-group
                                        label="Shift Code"
                                        label-for="shift_code"
                                    >
                                        <v-select
                                            v-model="formData.shift_code"
                                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                            :options="shiftCodeOptions"
                                            :clearable="false"
                                            :reduce="val => val.value"
                                            placeholder="Select Code"
                                            input-id="shift_code"
                                        />
                                    </b-form-group>
                                </b-col>
                            </b-row>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col md="3">
                            <b-form-group
                                label="Atten Type Group"
                                label-for="attendance_type_group"
                            >
                                <v-select
                                    v-model="formData.attendance_type_group"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="attendanceGroupOptions"
                                    :clearable="false"
                                    :reduce="val => val.value"
                                    placeholder="Select Group"
                                    input-id="attendance_type_group"
                                />
                            </b-form-group>
                            <b-form-group
                                label="Show Lock Records"
                                label-for="show_lock_records"
                            >
                                <v-select
                                    v-model="formData.show_lock_records"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="showLockRecordOptions"
                                    :clearable="false"
                                    :reduce="val => val.value"
                                    placeholder="Select records"
                                    input-id="show_lock_records"
                                />
                            </b-form-group>
                        </b-col>
                        <b-col md="9">
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
                    <hr>
                    <b-row>
                        <b-col md="4">
                            <b-form-group
                                label="Title 1"
                                label-for="title_one"
                            >
                                <b-form-textarea
                                    v-model="formData.title_one"
                                    input-id="title_one"
                                    rows="2"
                                />
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                label="Title 2"
                                label-for="title_two"
                            >
                                <b-form-textarea
                                    v-model="formData.title_two"
                                    input-id="title_two"
                                    rows="2"
                                />
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                label="Title 3"
                                label-for="title_three"
                            >
                                <b-form-textarea
                                    v-model="formData.title_three"
                                    input-id="title_three"
                                    rows="2"
                                />
                            </b-form-group>
                        </b-col>
                    </b-row>
                    <hr>
                    <b-row>
                        <b-col md="5">
                            <b-form-group
                                label="Orientation"
                                label-for="orientation"
                                label-class="mb-1"
                            >
                                <b-form-radio-group
                                    id="orientation"
                                    v-model="formData.orientation"
                                    :options="orientationOptions"
                                />
                            </b-form-group>
                            <b-row>
                                <b-col md="6">
                                    <b-form-group
                                        label="Date Display Format"
                                        label-for="date_display_format"
                                    >
                                        <v-select
                                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                            :clearable="false"
                                            :reduce="val => val.value"
                                            placeholder="Select Date Formate"
                                            id="date_display_format"
                                            v-model="formData.date_display_format"
                                            :options="dateFormateOptions"
                                        />
                                    </b-form-group>

                                </b-col>
                                <b-col md="6">
                                    <b-form-group
                                        label="Sort by"
                                        label-for="sort_by"
                                    >
                                        <v-select
                                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                            :clearable="false"
                                            :reduce="val => val.value"
                                            placeholder="Sort By"
                                            id="sort_by"
                                            v-model="formData.sort_by"
                                            :options="sortByOptions"
                                        />
                                    </b-form-group>

                                </b-col>
                            </b-row>
                        </b-col>
                        <b-col md="7">
                            <b-row>
                                <b-col>
                                    <div class="demo-inline-spacing">
                                        <b-form-checkbox
                                            v-model="formData.show_manager"
                                            name="show_manager"
                                        >
                                            Show Manager records only
                                        </b-form-checkbox>
                                        <b-form-checkbox
                                            v-model="formData.repeat_employee_code"
                                            name="repeat_employee_code"
                                        >
                                            Repeat Employee code, employee name and available masters
                                        </b-form-checkbox>
                                        <b-form-checkbox
                                            v-model="formData.show_total"
                                            name="show_total"
                                        >
                                            Show Total Row/Column
                                        </b-form-checkbox>
                                    </div>
                                </b-col>
                            </b-row>
                        </b-col>
                    </b-row>
                    <hr>
                    <b-col md="12">
                        <b-button
                            variant="primary"
                            class="mr-1 float-right"
                            :to="{name:'add-muster-writer-grouping-report'}"
                        >
                            View
                        </b-button>
                    </b-col>
                </b-form>
            </validation-observer>
        </b-card-code>
        <b-card-code>
            <b-tabs pills>
                <b-tab active>
                    <template #title>
                        <span class="d-none d-sm-inline">Columans Section</span>
                    </template>
                    <hr>
                    <columns-section-tab
                    />
                </b-tab>
                <b-tab active>
                    <template #title>
                        <span class="d-none d-sm-inline">General Filter</span>
                    </template>
                    <hr>
                    <general-filter-tab
                    />
                </b-tab>
                <b-tab active>
                    <template #title>
                        <span class="d-none d-sm-inline">Filter Condition</span>
                    </template>
                    <hr>
                    <filter-condition-tab
                    />
                </b-tab>
            </b-tabs>
        </b-card-code>
    </div>
</template>
<script>
    import {
        BForm,
        BRow,
        BCol,
        BFormGroup,
        BAlert,
        BFormCheckbox,
        BInputGroup,
        BInputGroupAppend,
        BFormDatepicker,
        BFormInvalidFeedback,
        BFormTextarea,
        BButton,
        BFormRadioGroup,
        BTabs,
        BTab
    } from 'bootstrap-vue'
    import BCardCode from "@core/components/b-card-code/BCardCode";
    import {ValidationObserver, ValidationProvider} from 'vee-validate'
    import {ref} from "@vue/composition-api";
    import formValidation from "@core/comp-functions/forms/form-validation";
    import {forMatIndianDate} from "@core/utils/utils";
    import Cleave from 'vue-cleave-component'
    import {required} from '@validations'
    import vSelect from 'vue-select'
    import columansSectionTab from "./tabs/columnsSectionTab";
    import filterConditionTab from "./tabs/filterConditionTab";
    import generalFilterTab from "./tabs/generalFilterTab";
    import ColumnsSectionTab from "./tabs/columnsSectionTab";

    export default {
        components: {
            ColumnsSectionTab,
            BForm,
            BRow,
            BCol,
            BFormGroup,
            BAlert,
            BCardCode,
            ValidationObserver,
            ValidationProvider,
            BFormCheckbox,
            BInputGroup,
            BInputGroupAppend,
            Cleave,
            BFormDatepicker,
            BFormInvalidFeedback,
            vSelect,
            BFormTextarea,
            BFormRadioGroup,
            BButton,
            BTabs,
            BTab,
            columansSectionTab,
            filterConditionTab,
            generalFilterTab
        },
        setup() {
            const orientationOptions = ref([
                {text: 'Vertical', value: 1},
                {text: 'Horizontal', value: 2},
            ])

            const sortByOptions = ref([
                {label: 'Employee Name', value: 1},
                {label: 'Employeen Code', value: 2},
            ])

            const dateFormateOptions = ref([
                {label: 'dd', value: 1},
                {label: 'dd-MMM', value: 2},
                {label: 'dd-MMM-yy', value: 3},
            ])

            const genderOptions = ref([
                {label: 'Male', value: 1},
                {label: 'Female', value: 2},
                {label: 'Other', value: 3},
            ])

            const shiftCodeOptions = ref([
                {label: 'L1', value: 1},
                {label: 'V1', value: 2},
                {label: 'G1', value: 3},
            ])

            const attendanceGroupOptions = ref([
                {label: 'Spine Type', value: 1},
                {label: 'User Define Type', value: 2},
            ])

            const showLockRecordOptions = ref([
                {label: 'NO', value: 1},
                {label: 'YES', value: 2},
                {label: 'ALL', value: 3},
            ])

            const groupingOptions = ref([
                {label: 'Grade', value: 1},
                {label: 'Branch', value: 2},
                {label: 'Department', value: 3},
                {label: 'Division', value: 4},
                {label: 'Unit', value: 5},
                {label: 'Category', value: 6},
                {label: 'Group', value: 7},
                {label: 'Designation', value: 8},
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

            const blankFormData = {
                from_date: forMatIndianDate(),
                to_date: forMatIndianDate(),
            }

            const formData = ref(JSON.parse(JSON.stringify(blankFormData)))

            const resetFormData = () => {
                formData.value = JSON.parse(JSON.stringify(blankFormData))
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
                getFromFormatDate,
                getToFormatDate,
                required,
                genderOptions,
                shiftCodeOptions,
                attendanceGroupOptions,
                showLockRecordOptions,
                orientationOptions,
                sortByOptions,
                dateFormateOptions,
                groupingOptions,
            }
        }
    }
</script>
