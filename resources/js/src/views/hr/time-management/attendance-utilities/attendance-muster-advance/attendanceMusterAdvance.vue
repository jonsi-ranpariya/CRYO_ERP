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
                                    <b>Attendance Muster Advance :</b>
                                    <span>While opening the muster plus, system will neither recalculate nor update WO/PH automatically and also attendance rules will be not applicable.</span><br><br>
                                    <span>User will require to update the details manually as desire. After saving the details selected row will be locked.</span><br><br>
                                    <span>For best performance use appropriate filters to view muster details.</span><br><br>
                                    <span>Show Lock Records filter is not applicable for View (button).</span><br><br>
                                    <b>Edit with Recalculation :</b>
                                    <span>Edit with Recalculation will perform recalculation as per provided Shift, In Time and Out Time.</span><br><br>
                                    <span>For best performance use appropriate filters to view muster details.</span><br><br>
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
                    <b-row>
                        <b-col md="6">
                            <b-form-checkbox
                                v-model="formData.show_total_row_column"
                                name="show_total_row_column"
                            >
                                Show Total Row/Column
                            </b-form-checkbox>
                        </b-col>
                    </b-row>
                    <hr>
                    <b-col md="12">
                        <b-button
                            variant="primary"
                            class="float-right ml-1"
                            @click="openImportModal"
                        >
                            Import for Edit With Recalculation
                        </b-button>
                        <b-button
                            variant="primary"
                            class="float-right"
                            :to="{}"
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
        <b-modal
            cancel-variant="danger"
            id="importModal"
            no-close-on-backdrop
            ref="importModal"
            scrollable
            :ok-disabled="true"
            size="lg"
            title="Import With Recalculation"
        >
            <br>
            <b-row>
                <b-col md="12">
                    <b-form-group
                        label=""
                        label-for="importExcel"
                    >
                        <b-form-file
                            placeholder="Choose a file here..."
                            no-drop
                            accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                            id="importExcel"
                            v-model="importFormData.importFile"
                            @change="getItemData($event)"
                        />
                    </b-form-group>
                </b-col>
            </b-row>
            <b-row>
                <b-col md="6">
                    <b-button
                        variant="primary"
                        type="button"
                        @click="downloadSampleFile"
                    >
                        Download Sample File
                    </b-button>
                </b-col>
                <b-col md="6">
                    <b-button
                        variant="primary"
                        type="submit"
                        class="float-right"
                        :disabled="uploadButton.isDisabled"
                    >
                        {{ uploadButton.text }}
                    </b-button>
                </b-col>
            </b-row>
            <br>
        </b-modal>

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
    import generalFilterTab from "./tabs/generalFilterTab"
    import filterConditionTab from "./tabs/filterConditionTab"
    export default {
        components: {
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
            generalFilterTab,
            filterConditionTab
        },
        setup({importModal}) {
            importModal = ref()

            const uploadButton = ref({
                text: 'Upload File',
                isDisabled: false
            })

            const sortByOptions = ref([
                {label: 'Employee Name', value: 1},
                {label: 'Employeen Code', value: 2},
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
            const importFormData = ref({
                importFile:null,
            })

            const getItemData = (e) => {
                e.preventDefault()
                importFormData.value.importFile = e.target.files[0]
            }

            const downloadSampleFile = async () => {
                /* await axios.get('/import/').then((res) => {
                       let link = document.createElement('a');
                       document.body.appendChild(link);
                       link.href = res.data.path;
                       link.click();
                   });*/
            }


            const openImportModal = () => {
                importModal.value.show();
            }


            const blankFormData = {
                from_date: forMatIndianDate(),
                to_date: forMatIndianDate(),
                gender:null,
                shift_code:null,
                attendance_type_group:null,
                sort_by:null,
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
                show_total_row_column:null,
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
                sortByOptions,
                importModal,
                openImportModal,
                downloadSampleFile,
                getItemData,
                importFormData,
                uploadButton
            }
        }
    }
</script>
