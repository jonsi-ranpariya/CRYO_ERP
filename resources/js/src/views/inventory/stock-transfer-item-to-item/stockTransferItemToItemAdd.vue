<template>
    <div>
        <b-card-code>
            <validation-observer #default="handleSubmit">
                <b-form @submit.prevent="handleSubmit(saveFormData)">
                    <b-row>
                        <b-col md="6">
                            <validation-provider
                                #default="validationContext"
                                name="Item Code"
                                rules="required"
                            >
                                <b-form-group
                                    label="Item Code"
                                    label-for="itemCode"
                                >
                                    <b-input-group class="d-flex">
                                        <b-form-input
                                            v-model="formData.itemCode"
                                            :state="getValidationState(validationContext)"
                                            id="itemCode"
                                            readonly
                                        />
                                        <b-input-group-append>
                                            <b-button variant="primary" @click="openModal">...</b-button>
                                        </b-input-group-append>
                                    </b-input-group>
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                            <validation-provider
                                #default="validationContext"
                                name="Item Description"
                                rules="required"
                            >
                                <b-form-group
                                    label="Item Description"
                                    label-for="itemDescription"
                                >
                                    <b-form-input
                                        :state="getValidationState(validationContext)"
                                        v-model="formData.itemCode"
                                        id="itemDescription"
                                        readonly
                                    />
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{validationContext.errors[0]}}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                            <b-row>
                                <b-col md="6">
                                    <validation-provider
                                        #default="validationContext"
                                        name="Add Description"
                                        rules="required"
                                    >
                                        <b-form-group
                                            label="Add Description"
                                            label-for="addDescription"
                                        >
                                            <b-form-input
                                                v-model="formData.addDescription"
                                                id="addDescription"
                                                :state="getValidationState(validationContext)"
                                            />
                                            <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                                {{validationContext.errors[0]}}
                                            </b-form-invalid-feedback>
                                        </b-form-group>
                                    </validation-provider>
                                </b-col>
                                <b-col md="6">
                                    <validation-provider
                                        #default="validationContext"
                                        name="Detail Description"
                                        rules="required"
                                    >
                                        <b-form-group
                                            label="Detail Description"
                                            label-for="detailDescription"
                                        >
                                            <b-form-textarea
                                                v-model="formData.detailDescription"
                                                id="detailDescription"
                                                :state="getValidationState(validationContext)"
                                                rows="2"
                                            />
                                            <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                                    {{validationContext.errors[0]}}
                                            </b-form-invalid-feedback>
                                        </b-form-group>
                                    </validation-provider>
                                </b-col>
                            </b-row>

                        </b-col>
                        <b-col md="6">

                        </b-col>
                    </b-row>
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
        BFormGroup,
        BFormInput,
        BInputGroup,
        BInputGroupAppend,
        BButton,
        BFormInvalidFeedback,
        BFormTextarea
    } from 'bootstrap-vue'
    import BCardCode from '../../../@core/components/b-card-code/BCardCode'
    import {ValidationObserver, ValidationProvider} from 'vee-validate'
    import formValidation from "@core/comp-functions/forms/form-validation";
    import {ref} from '@vue/composition-api'

    export default {
        components: {
            BCardCode,
            BForm,
            BRow,
            BCol,
            BFormGroup,
            BFormInput,
            ValidationProvider,
            ValidationObserver,
            BInputGroup,
            BInputGroupAppend,
            BFormInvalidFeedback,
            BButton,
            BFormTextarea
        },
        setup() {
            const blankFormData = {}
            const formData = ref(JSON.parse(JSON.stringify(blankFormData)))
            const resetFormData = () => {
                formData.value = JSON.parse(JSON.stringify(blankFormData))
            }
            const openModal = () => {

            }
            const {refFormObserver, getValidationState, resetForm} = formValidation(resetFormData)
            return {
                formData,
                resetFormData,
                resetForm,
                refFormObserver,
                getValidationState,
                openModal
            }
        }
    }
</script>
