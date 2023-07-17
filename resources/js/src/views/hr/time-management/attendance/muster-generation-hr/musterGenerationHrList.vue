<template>
    <div>
        <b-card-code>
            <b-form>
                <b-row>
                    <b-col md="12">
                        <b-alert
                            variant="danger"
                            show
                        >
                            <h4 class="alert-heading">
                                Note:
                            </h4>
                            <div class="alert-body">
                            <span>This module will open MUSTER in edit mode For best use either select small range of dates or small group /single employee ,
                                for which edit is required To view muster report go-through MUSTER –REPORT WRITER.</span><br><br>
                                <span>While opening Muster in edit mode it will recalculate data internally before display on screen.</span><br><br>
                            </div>
                        </b-alert>
                        <hr>
                    </b-col>
                </b-row>
                <b-row>
                    <b-col md="4">
                        <b-form-group>
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
                                />
                                <b-input-group-append>
                                    <b-form-datepicker
                                        v-model="formatDates.from_date"
                                        button-only
                                        @input="getFromFormatDate($event)"
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
                                />

                                <b-input-group-append>
                                    <b-form-datepicker
                                        v-model="formatDates.to_date"
                                        button-only
                                        @input="getToFormatDate($event)"
                                        show-decade-nav
                                        size="sm"
                                        nav-button-variant="primary"
                                    />
                                </b-input-group-append>
                            </b-input-group>
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
                    <b-col md="3">
                        <b-form-group
                            label="Order by	"
                            label-for="order_by"
                        >
                            <v-select
                                v-model="formData.order_by"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="orderByOptions"
                                :clearable="false"
                                :reduce="val => val.value"
                                placeholder="Select Order"
                                input-id="order_by"
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
                <br>
                <b-row>
                    <b-col md="12" class="d-flex">
                        <b-form-checkbox
                            v-model="formData.alternate_Attendance_type"
                            name="alternate_Attendance_type"
                        >
                            Display Alternate attendance type
                        </b-form-checkbox>
                        <b-form-checkbox
                            v-model="formData.over_time_detail"
                            name="over_time_detail"
                            class="ml-2"
                        >
                            Display Over time details
                        </b-form-checkbox>
                    </b-col>
                </b-row>
                <hr>
                <b-col md="12">
                    <h5>User Day Type</h5>
                </b-col>
                <hr>
                <b-row>
                    <b-col md="12">
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
                    </b-col>
                </b-row>
                <hr>
                <b-col md="12">
                    <b-button
                        variant="primary"
                        class="float-right ml-1"
                        @click="openMusterModal"
                    >
                        Import Muster Modal
                    </b-button>

                    <b-button
                        variant="primary"
                        class="float-right ml-1"
                    >
                        Clear Section
                    </b-button>
                    <b-button
                        variant="primary"
                        class="float-right"
                        :to="{name:'add-muster-generation-hr'}"
                    >
                        OK
                    </b-button>
                </b-col>
            </b-form>
        </b-card-code>

        <b-modal
            cancel-variant="danger"
            id="importMusterModal"
            no-close-on-backdrop
            ref="importMusterModal"
            scrollable
            :ok-disabled="true"
            size="lg"
            hide-footer
            title="Import Muster HR Modal"
        >
            <br>
            <b-row>
                <b-col md="12">
                    <b-alert
                        variant="danger"
                        show
                    >
                        <h4 class="alert-heading">
                            Note:
                        </h4>
                        <div class="alert-body">
                            <span>This Will Delete existing Muster Data and Import data as per given file,
                                only User Type,Portion,User Type2 and OT hours will be uploaded in muster for given
                                employee and for given date, Other fields will not reflect any data.</span><br><br>
                            <span>For uploading file use txt or csv format.File size should not be more than 2 MB</span><br><br>
                            <span>For Sample data <b-link> Click here</b-link></span><br><br>
                        </div>
                    </b-alert>
                    <hr>
                </b-col>
            </b-row>
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
                            v-model="musterFormData.importFile"
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
        BFormInput,
        BFormRadioGroup,
        BButton,
        BFormCheckbox,
        BInputGroup,
        BInputGroupAppend,
        BFormDatepicker,
        BAlert,
        BLink
    } from 'bootstrap-vue'
    import BCardCode from "@core/components/b-card-code/BCardCode";
    import vSelect from 'vue-select'
    import {ref} from '@vue/composition-api'
    import axios from '@axios'
    import Cleave from 'vue-cleave-component'
    import {forMatIndianDate, getTcTodayDate} from "@core/utils/utils";

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
            BInputGroupAppend,
            BAlert,
            BLink
        },
        setup({importMusterModal}) {
            importMusterModal = ref()

            const uploadButton = ref({
                text: 'Upload File',
                isDisabled: false
            })

            const dateFormat = ref({
                date: true,
                delimiter: '/',
                datePattern: ['d', 'm', 'Y'],
            })

            const formatDates = ref({
                from_date: null,
                to_date:null,
            })

            const getFromFormatDate = (date) => {
                formData.value.from_date = forMatIndianDate(date)
            }

            const getToFormatDate = (date) => {
                formData.value.to_date = forMatIndianDate(date)

            }
            const openMusterModal = () => {
                importMusterModal.value.show();
            }

            const orderByOptions = ref([
                {
                    label: 'Employee Code',
                    value: 1
                },
                {
                    label: 'Employee Name',
                    value: 2
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

            const musterFormData = ref({
                importFile:null,
            })
            const getItemData = (e) => {
                e.preventDefault()
                musterFormData.value.importFile = e.target.files[0]
            }

            const downloadSampleFile = async () => {
                /* await axios.get('/import/').then((res) => {
                       let link = document.createElement('a');
                       document.body.appendChild(link);
                       link.href = res.data.path;
                       link.click();
                   });*/
            }


            const formData = ref({
                from_date: forMatIndianDate(getTcTodayDate()),
                to_date: forMatIndianDate(getTcTodayDate()),
                grade: null,
                branch: null,
                department: null,
                division: null,
                unit: null,
                category: null,
                group: null,
                employee_name: null,
                order_by: null,
                status: 'Current',
                alternate_Attendance_type: true,
                over_time_detail: null,
                dayTypeAbs: null,
                dayTypeCl: null,
                dayTypeCoMinus: null,
                dayTypeCoPlus: null,
                dayTypeDp: null,
                dayTypeEo: null,
                dayTypeLone: null,
                dayTypeLtwo: null,
                dayTypeTypeLthree: null,
                dayTypeLfour: null,
                dayTypeLfive: null,
                dayTypeLwp: null,
                dayTypeOd: null,
                dayTypeOl: null,
                dayTypePh: null,
                dayTypePhp: null,
                dayTypePl: null,
                dayTypeSl: null,
                dayTypeSv: null,
                dayTypeWo: null,
                dayTypeWop: null,
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
                dateFormat,
                formatDates,
                getFromFormatDate,
                getToFormatDate,
                orderByOptions,
                importMusterModal,
                openMusterModal,
                musterFormData,
                getItemData,
                downloadSampleFile,
                uploadButton
            }
        }
    }

</script>
