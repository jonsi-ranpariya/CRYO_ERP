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
                                    <span>This module is meant for updating information post recalculation of attendance data is done. Before running this process, running of recalculation of attendance data is mandatory to avoid duplication of process effect.
                                          (Recalculation of attendance data will remove the effective data generated from process done here.)</span><br><br>
                                    <span>Value to be updated should be entered in Hours. e.g. if 1 hr 30 min need to be updated then value entered should be 1.30.</span>
                                    <span>Day Lock entry will not be editable.</span><br><br>
                                    <span>Before running this utility, please run the recalculation of an attendance.</span><br><br>
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
                                name="Shift Code"
                                rules=""
                            >
                                <b-form-group
                                    label="Shift Code"
                                    label-for="shift_code"
                                    :state="getValidationState(validationContext)"
                                >
                                    <v-select
                                        v-model="formData.shift_code"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="shiftOptions"
                                        :clearable="false"
                                        :reduce="val => val.value"
                                        input-id="shift_code"
                                        placeholder="Select COde"
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
                        <b-col md="6">
                            <b-row>
                                <b-col md="6">
                                    <validation-provider
                                        #default="validationContext"
                                        name="Adjustment"
                                        rules=""
                                    >
                                        <b-form-group
                                            label="adjustment"
                                            label-for="adjustment"
                                            :state="getValidationState(validationContext)"
                                        >
                                            <v-select
                                                v-model="formData.adjustment"
                                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                                :options="adjustmentOptions"
                                                :clearable="false"
                                                :reduce="val => val.value"
                                                input-id="adjustment"
                                                :state="getValidationState(validationContext)"
                                            />
                                            <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                                {{ validationContext.errors[0] }}
                                            </b-form-invalid-feedback>
                                        </b-form-group>
                                    </validation-provider>
                                </b-col>
                                <b-col md="6" class="mt-2">
                                    <b-form-group>
                                        <v-select
                                            v-model="formData.operator"
                                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                            :options="operatorOptions"
                                            :clearable="false"
                                            :reduce="val => val.value"
                                            input-id="operator"
                                        />
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col md="6">
                                    <validation-provider
                                        #default="validationContext"
                                        name="TotHrs From"
                                        rules=""
                                    >
                                        <b-form-group
                                            label="total_hrs_from"
                                            label-for="total_hrs_from"
                                            :state="getValidationState(validationContext)"
                                        >
                                            <b-form-input
                                                id="total_hrs_from"
                                                v-model="formData.total_hrs_from"
                                                :state="getValidationState(validationContext)"
                                            />
                                            <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                                {{ validationContext.errors[0] }}
                                            </b-form-invalid-feedback>
                                        </b-form-group>
                                    </validation-provider>
                                </b-col>
                                <b-col md="6">
                                    <validation-provider
                                        #default="validationContext"
                                        name="TotHrs To"
                                        rules=""
                                    >
                                        <b-form-group
                                            label="total_hrs_to"
                                            label-for="total_hrs_to"
                                            :state="getValidationState(validationContext)"
                                        >
                                            <b-form-input
                                                id="total_hrs_to"
                                                v-model="formData.total_hrs_to"
                                                :state="getValidationState(validationContext)"
                                            />
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
                                    <validation-provider
                                        #default="validationContext"
                                        name="Value"
                                        rules=""
                                    >
                                        <b-form-group
                                            label="value"
                                            label-for="value"
                                            :state="getValidationState(validationContext)"
                                        >
                                            <b-form-input
                                                id="value"
                                                v-model="formData.value"
                                                :state="getValidationState(validationContext)"
                                            />
                                            <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                                {{ validationContext.errors[0] }}
                                            </b-form-invalid-feedback>
                                        </b-form-group>
                                    </validation-provider>
                                </b-col>
                                <b-col md="6" class="mt-2">
                                    <b-form-checkbox
                                        v-model="formData.addFormula"
                                        name="addFormula"
                                    >
                                        Add Formula
                                    </b-form-checkbox>
                                </b-col>
                            </b-row>
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
                            Update
                        </b-button>
                    </b-col>
                </b-form>
            </validation-observer>
        </b-card-code>
        <b-card-code>
            <b-tabs pills>
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
        BTabs,
        BTab
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
    import filterConditionTab from './tabs/filterConditionTab'
    import generalFilterTab from './tabs/generalFilterTab'

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
            BButton,
            BTabs,
            BTab,
            filterConditionTab,
            generalFilterTab
        },
        setup() {
            const attendanceGroupOptions = ref([
                {label: 'Spine Type', value: 1},
                {label: 'User Defined Type', value: 2},
            ])
            const adjustmentOptions = ref([
                {label: 'Total Working Hours', value: 1},
                {label: 'Late Hours', value: 2},
                {label: 'Early Hours', value: 3},
                {label: 'Extra Working Hours', value: 4},
                {label: 'OT Working Hours', value: 5},
                {label: 'Portion', value: 6},
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

            const operatorOptions = ref([
                {label: '=', value: 1},
                {label: '+', value: 2},
                {label: '-', value: 3},
            ])
            const shiftOptions = ref([
                {label: 'L1', value: 1},
                {label: 'V1', value: 2},
                {label: 'G1', value: 3},
            ])

            const blankFormData = {
                from_date: forMatIndianDate(),
                to_date: forMatIndianDate(),
                shift_code:null,
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
                adjustment:null,
                operator:null,
                total_hrs_from:null,
                total_hrs_to:null,
                value:null,
                addFormula:null,
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
                required,
                shiftOptions,
                adjustmentOptions,
                operatorOptions
            }
        }
    }
</script>
