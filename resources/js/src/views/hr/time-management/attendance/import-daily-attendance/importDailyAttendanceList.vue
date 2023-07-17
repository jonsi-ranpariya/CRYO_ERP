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
                            <span>Following attendance formats are available <br>
                                    27, 33, 34, 35, 36, 37, 38, 39, 4.</span><br><br>
                                <span>Feature provided to upload the daily in /out swipes captured from attendance machine data.</span><br><br>
                                <span>This will not only upload the data, but also process the Muster Day of that data. ie. if In/Out punch data uploaded it will create day records as per the shift rules and save day type , late mark , OT etc accordingly.</span><br><br>
                                <span>System is also having provision of capturing data on scheduled basis through API. For details check module [API Configuration].</span><br><br>
                            </div>
                        </b-alert>
                        <hr>
                    </b-col>
                </b-row>
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
                                input-id="grade"
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
                </b-row>
                <b-row>
                    <b-col md="4">
                        <b-form-group>
                            <label for="importExcel">Select File <span
                                class="text-danger erp_required_star"
                            >*</span></label>

                            <b-form-file
                                placeholder="Choose a file here..."
                                no-drop
                                accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                                id="importExcel"
                                v-model="formData.importFile"
                                @change="getItemData($event)"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="3">
                        <b-button
                            variant="primary"
                            type="button"
                            class="mt-2"
                            @click="downloadSampleFile"
                        >
                            Download Sample File
                        </b-button>
                    </b-col>
                    <b-col md="5">
                        <b-row>
                            <b-col md="5">
                                <b-button
                                    variant="primary"
                                    type="submit"
                                    class="mt-2"
                                    :disabled="uploadButton.isDisabled"
                                >
                                    {{ uploadButton.text }}
                                </b-button>
                            </b-col>
                            <b-col md="7">
                                <b-form-group>
                                    <v-select
                                        v-model="formData.import_data"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="importFileOptions"
                                        :clearable="false"
                                        :reduce="val => val.value"
                                        input-id="import_file"
                                        class="mt-2"
                                    />
                                </b-form-group>
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
                        Start Process
                    </b-button>

                    <b-button
                        variant="primary"
                        class="float-right ml-1"
                    >
                        Reset
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
                to_date: null,
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

            const importFileOptions = ref([
                {label: 'Import File', value: 1},
                {label: 'Error Log', value: 2},
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

            const getItemData = (e) => {
                e.preventDefault()
                formData.value.importFile = e.target.files[0]
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
                grade: null,
                branch: null,
                department: null,
                division: null,
                unit: null,
                category: null,
                group: null,
                employee_name: null,
                importFile: null,
                import_data: 1,
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
                getItemData,
                downloadSampleFile,
                uploadButton,
                importFileOptions
            }
        }
    }

</script>
