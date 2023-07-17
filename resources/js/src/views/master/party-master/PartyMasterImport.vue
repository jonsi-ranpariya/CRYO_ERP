<template>
    <div>
        <b-card-code>
            <validation-observer
                ref="validateRules"
                #default="{ handleSubmit }"
            >
                <b-form
                    @submit.prevent="handleSubmit(submitFormData)"
                >
                    <validation-provider
                        #default="validationContext"
                        name="File"
                        rules="required"
                    >
                        <b-form-group
                            label=""
                            label-for="itemMasterExcel"
                            :state="getValidationState(validationContext)"
                        >
                            <b-form-file
                                placeholder="Choose a file here..."
                                no-drop
                                accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                                id="itemMasterExcel"
                                :state="getValidationState(validationContext)"
                                v-model="formData.importFile"
                                @change="getItemData($event)"
                            />
                            <b-form-invalid-feedback>
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </validation-provider>
                    <hr>
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

                </b-form>
            </validation-observer>
        </b-card-code>
    </div>
</template>
<script>
import BCardCode from "@core/components/b-card-code";
import {
    BButton,
    BForm,
    BFormGroup,
    BFormInput,
    BFormFile,
    BRow,
    BCol,
    BFormInvalidFeedback
} from "bootstrap-vue";
import {ValidationProvider, ValidationObserver} from 'vee-validate';
import formValidation from '@core/comp-functions/forms/form-validation';
import {ref, onUnmounted, onMounted} from '@vue/composition-api'
import {required} from '@validations';
import axios from '@axios';
import {useToast} from "vue-toastification/composition";
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue';

export default {
    components: {
        BCardCode,
        BButton,
        BForm,
        BFormGroup,
        BFormInput,
        BFormFile,
        BRow,
        BCol,
        BFormInvalidFeedback,

        //validations
        ValidationProvider,
        ValidationObserver
    },
    setup() {
        const toast = useToast();

        const uploadButton = ref({
            text: 'Upload File',
            isDisabled: false
        });

        const blankFormData = {
            importFile: null
        }

        const formData = ref(JSON.parse(JSON.stringify(blankFormData)));

        const resetFormData = () => {
            formData.value = JSON.parse(JSON.stringify(blankFormData));
        }

        const getItemData = (e) => {
            e.preventDefault()
            formData.value.importFile = e.target.files[0]
        }

        const downloadSampleFile = async () => {
            await axios.get('/import/party-master-sample-file-download').then((res) => {
                let link = document.createElement('a');
                document.body.appendChild(link);
                link.href = res.data.path;
                link.click();
            });
        }

        const submitFormData = async () => {
            uploadButton.value.text = 'Please wait...';
            uploadButton.value.isDisabled = true;
            const newFormData = new FormData()
            newFormData.append('importFile', formData.value.importFile)
            await axios.post('/import/party-master', newFormData).then((res) => {
                if (res.status === 200) {
                    toast({
                        component: ToastificationContent,
                        position: 'top-right',
                        props: {
                            title: 'File Uploaded',
                            icon: 'CheckSquareIcon',
                            variant: 'success',
                            text: `You have successfully Upload file ${res.data.data.name}.`,
                        },
                    });
                }
            }).catch(() => {
                toast({
                    component: ToastificationContent,
                    position: 'top-right',
                    props: {
                        title: `Error`,
                        icon: 'AlertCircleIcon',
                        variant: 'danger',
                        text: `Internal server error`,
                    },
                });
            });
            resetFormData();
            uploadButton.value.text = 'Upload File';
            uploadButton.value.isDisabled = false;
        }

        const {refFormObserver, getValidationState, resetForm} = formValidation(resetFormData);

        return {
            uploadButton,
            formData,
            resetFormData,
            getItemData,
            downloadSampleFile,
            submitFormData,

            //validations
            required,
            refFormObserver,
            getValidationState,
            resetForm,
        }
    }
}
</script>
