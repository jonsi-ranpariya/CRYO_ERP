<template>
    <div>
        <b-card-code>
            <b-form>
                <b-row>
                    <b-col md="3">
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
                    <b-col md="3">
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
                    <b-col md="3">
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
                    <b-col md="3">
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
                    <b-col md="3">
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
                    <b-col md="3">
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
                    <b-col md="3">
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
                <b-row>
                    <b-col md="3">
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
                    <b-col md="4">
                        <b-form-checkbox
                            class="custom-control-primary mt-2"
                            v-model="formData.weekly_off_not_assign"
                        >
                            Show Weekly Off Not Assigned.
                        </b-form-checkbox>
                    </b-col>
                </b-row>
                <hr>
                <b-col md="12">
                    <b-button
                        variant="primary"
                        class="float-right ml-1"
                        @click="openImportWeeklyOffModal"
                    >
                        Import Weekly Off
                    </b-button>
                    <b-button
                        variant="primary"
                        class="float-right ml-1"
                        :to="{ name:'' }"
                    >
                        View
                    </b-button>
                    <b-button
                        variant="primary"
                        class="ml-1 float-right"
                        :to="{name: 'weekly-off-employee-information'}"
                    >
                        OK
                    </b-button>
                </b-col>
            </b-form>
        </b-card-code>
        <!-- Import Modal -->
        <b-modal
            cancel-variant="danger"
            id="importWeeklyOffModal"
            no-close-on-backdrop
            ref="importWeeklyOffModal"
            scrollable
            :ok-disabled="true"
            size="lg"
            title="Import Weekly Off"
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
                            <span>Columns sequence in the file has to be same as mentioned in File Format Structure.</span>
                            <span>Do not include header in file.</span>
                            <span>File formats allowed: csv.</span>
                            <span>Day Must Be One Of : Sunday, Monday, Tuesday, Wednesday, Thusday, Friday, Saturday.</span>
                            <span>If 'All' column value is Yes then it will insert Yes for all 1st, 2nd, 3rd, 4th and 5th week columns.</span>
                            <span>Alternate Odd Or Even Days can not be selected with other weeks..</span>
                        </div>
                    </b-alert>
<!--                    <hr>-->
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
                        Download File
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
        BFormRadioGroup,
        BFormGroup,
        BButton,
        BFormCheckbox,
        BAlert
    } from 'bootstrap-vue'
    import BCardCode from "@core/components/b-card-code/BCardCode";
    import vSelect from 'vue-select'
    import {ref} from "@vue/composition-api";
    import axios from '@axios'
    import moment from 'moment';

    export default {
        components: {
            BCardCode,
            BForm,
            BRow,
            BCol,
            vSelect,
            BFormRadioGroup,
            BFormGroup,
            BButton,
            BFormCheckbox,
            BAlert
        },
        setup({importWeeklyOffModal}) {
            importWeeklyOffModal = ref()

            const uploadButton = ref({
                text: 'Upload File',
                isDisabled: false
            })

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

            const downloadSampleFile = async () => {
                /* await axios.get('/import/').then((res) => {
                       let link = document.createElement('a');
                       document.body.appendChild(link);
                       link.href = res.data.path;
                       link.click();
                   });*/
            }
            const getItemData = (e) => {
                e.preventDefault()
                shiftFormData.value.importFile = e.target.files[0]
            }

            const openImportWeeklyOffModal = () => {
                importWeeklyOffModal.value.show();
            }

            const importFormData = ref({
                importFile:null
            })

            const formData = ref({
                grade:null,
                branch:null,
                department:null,
                division:null,
                unit:null,
                category:null,
                group:null,
                employee_name:null,
                status:'Current',
                weekly_off_not_assign:null
            })

            return {
                formData,
                gradeOptions,
                branchOptions,
                departmentOptions,
                divisionOptions,
                employeeOptions,
                groupOptions,
                categoryOptions,
                unitOptions,
                statusOptions,
                openImportWeeklyOffModal,
                importWeeklyOffModal,
                importFormData,
                getItemData,
                downloadSampleFile,
                uploadButton
            }
        }
    }

</script>
