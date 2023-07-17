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
                                <span>This will add leave transaction of employee as approved leave and will have an impact on balance if leave balance calculation is not based on salary process data. User can import leave application data older than date 23-Oct-20.</span><br><br>
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
                                v-model="formData.importFile"
                                @change="getItemData($event)"
                            />
                        </b-form-group>
                    </b-col>
                </b-row>
                <b-row>
                    <b-col md="12">
                        <b-button
                            variant="primary"
                            type="submit"
                            class="float-right"
                            :disabled="uploadButton.isDisabled"
                        >
                            {{ uploadButton.text }}
                        </b-button>
                        <b-button
                            variant="primary"
                            type="button"
                            class="float-right mx-1"
                            @click="downloadSampleFile"
                        >
                            Download Sample File
                        </b-button>
                    </b-col>
                </b-row>
                <hr>
            </b-form>
        </b-card-code>
    </div>
</template>
<script>
    import {
        BForm,
        BRow,
        BCol,
        BAlert,
        BButton,
        BFormFile,
        BFormGroup
    } from 'bootstrap-vue'
    import BCardCode from "../../../../../@core/components/b-card-code/BCardCode";
    import {ref} from "@vue/composition-api";
    export default {
        components:{
            BCardCode,
            BForm,
            BRow,
            BCol,
            BAlert,
            BButton,
            BFormFile,
            BFormGroup
        },
        setup(){
            const uploadButton = ref({
                text: 'Upload File',
                isDisabled: false
            })

            const formData = ref({
                importFile:null,
            })

            const getItemData = (e) => {
                e.preventDefault()
                shiftFormData.value.importFile = e.target.files[0]
            }

            const downloadSampleFile = async () => {
                /* await axios.get('/import/').then((res) => {
                       let link = document.createElement('a');
                       document.body.appendChild(link);
                       link.href = res.data.path;
                       link.click();
                   });*/
            }

            const saveFormData = async () =>{}

            return{
                formData,
                downloadSampleFile,
                getItemData,
                uploadButton,
                saveFormData
            }
        }
    }
</script>

