<template>
    <div>
        <b-card-code>
            <b-form @submit.prevent="saveFormData">
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
                                <span>For uploading file use txt or csv format.</span><br><br>
                                <span>For Sample data <b-link>Click here</b-link></span><br><br>
                                <span>CL and SL will be lapse at the end of Financial Year. You can't adjust or encash SL or CL in ant case.</span><br><br>
                                <span>All Leave application must be approved by approving authority, without approval, leave will be treated as an absent.</span><br>
                            </div>
                        </b-alert>
                        <hr>
                    </b-col>
                </b-row>
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
                                v-model="formData.importFile"
                                @change="getItemData($event)"
                            />
                        </b-form-group>
                    </b-col>
                </b-row>
                <b-row>
                    <b-col md="12" class="d-flex">
                        <b-button
                            variant="primary"
                            type="button"
                            @click="downloadSampleFile"
                        >
                            Download Sample File
                        </b-button>
                        <b-button
                            variant="primary"
                            type="submit"
                            class="float-left ml-1"
                            :disabled="uploadButton.isDisabled"
                        >
                            {{ uploadButton.text }}
                        </b-button>
                        <b-form-checkbox
                            class="custom-control-primary ml-1 mt-1"
                            v-model="formData.override_file"
                        >
                            Override file if already exist
                        </b-form-checkbox>
                    </b-col>
                </b-row>
                <br>
                <p class="align-items-center"><b>OR</b></p>
                <b-row>
                    <b-col md="6">
                        <b-form-group
                            label="Select Existing File"
                            label-for="select_existing_file"
                        >
                            <v-select
                                v-model="formData.select_existing_file"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="existingFileSelectOptions"
                                :clearable="false"
                                :reduce="val => val.value"
                                placeholder="Select Shift"
                                id="select_existing_file"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="6">
                        <b-form-checkbox
                            class="custom-control-primary ml-1 mt-1"
                            v-model="formData.update_exiting_record"
                        >
                            Update Existing Record
                        </b-form-checkbox>
                        <b-form-checkbox
                            class="custom-control-primary ml-1 mt-1"
                            v-model="formData.recalculation_attendance"
                        >
                            Recalculate Attendance while importing Data
                        </b-form-checkbox>
                    </b-col>
                </b-row>
                <hr>
                <b-col md="12">
                    <b-button
                        variant="primary"
                        class="ml-1 float-right"
                    >
                        Reset
                    </b-button>
                    <b-button
                        variant="primary"
                        type="button"
                        class="ml-1 float-right"
                    >
                        Start Import Process
                    </b-button>
                </b-col>
            </b-form>
        </b-card-code>
    </div>
</template>
<script>
    import {
        BRow,
        BCol,
        BFormGroup,
        BFormInput,
        BForm,
        BButton,
        BFormFile,
        BFormCheckbox,
        BLink,
        BAlert
    } from 'bootstrap-vue'
    import BCardCode from "@core/components/b-card-code/BCardCode";
    import {ref} from "@vue/composition-api";
    import vSelect from 'vue-select'

    export default {
        components: {
            BCardCode,
            BRow,
            BCol,
            BFormGroup,
            BFormInput,
            BForm,
            BButton,
            BFormFile,
            vSelect,
            BFormCheckbox,
            BLink,
            BAlert
        },
        setup() {
            const existingFileSelectOptions = ref([])

            const uploadButton = ref({
                text: 'Upload File',
                isDisabled: false
            })

            const formData = ref({
                importFile: null,
                select_existing_file:null,
                update_exiting_record:null,
                recalculation_attendance:true
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

            const saveFormData = async () => {
            }

            return {
                saveFormData,
                formData,
                uploadButton,
                getItemData,
                downloadSampleFile,
                existingFileSelectOptions
            }
        }
    }
</script>
