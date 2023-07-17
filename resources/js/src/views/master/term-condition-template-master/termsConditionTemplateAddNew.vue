<template>
<div>
    <b-card-code>
        <validation-observer
            #default="{ handleSubmit }"
            ref="refFormObserver"
        >
            <!-- Form -->
            <b-form
                @submit.prevent="handleSubmit(saveTemplateData)"
                @reset.prevent="resetForm"
            >
                <b-row>
                    <b-col md="8">
                        <validation-provider
                            #default="validationContext"
                            name="Template"
                            rules="required"
                        >
                            <b-form-group>

                                <label for="template">Template <span
                                    class="text-danger erp_required_star">*</span></label>

                                <b-form-input
                                    id="template"
                                    v-model="templateData.templateName"
                                    :state="getValidationState(validationContext)"
                                />
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                    </b-col>
                    <b-col md="4">
                        <validation-provider
                            #default="validationContext"
                            name="Active"
                            rules="required"
                        >
                            <b-form-group
                                label="Active"
                                label-for="active"
                                :state="getValidationState(validationContext)"
                            >
                                <v-select
                                    placeholder="select Status"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="statusOption"
                                    :clearable="false"
                                    input-id="active"
                                    :reduce="val => val.value"
                                    v-model="templateData.status"
                                />
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                    </b-col>
                    <b-col md="12">
                        <hr>
                        <b-button
                            type="submit"
                            variant="primary"
                        >
                            Save Template
                        </b-button>
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
        BFormInvalidFeedback,
        BButton
    } from 'bootstrap-vue'
    import BCardCode from '@core/components/b-card-code/BCardCode.vue'
    import {ValidationProvider, ValidationObserver} from 'vee-validate'
    import {onUnmounted, ref} from "@vue/composition-api";
    import {required} from '@validations'
    import vSelect from 'vue-select'
    import formValidation from '@core/comp-functions/forms/form-validation'
    import masterStoreModule from "../masterStoreModule";
    import store from '@/store'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import router from '@/router'
    import {useToast} from "vue-toastification/composition";
    export default {
        components:{
            BCardCode,
            BForm,
            BRow,
            BCol,
            BFormGroup,
            BFormInput,
            BFormInvalidFeedback,
            vSelect,
            ValidationObserver,
            ValidationProvider,
            BButton
        },
        setup(){
            const toast = useToast()
            const ITEMADDON_APP_STORE_MODULE_NAME = 'terms-condition-template-master'
            if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, masterStoreModule)
            onUnmounted(() => {
                if (store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.unregisterModule(ITEMADDON_APP_STORE_MODULE_NAME)
            })

            const statusOption = ref([
                {label: 'Yes', value: 1},
                {label: 'No', value: 2},
            ])

            const blankData = {
                templateName:null,
                status:1,
            }

            const templateData = ref(JSON.parse(JSON.stringify(blankData)))

            const resetFormData = () => {
                templateData.value = JSON.parse(JSON.stringify(blankData))
            }

            const saveTemplateData = async () => {
                await store.dispatch('terms-condition-template-master/addTermsConditionTemplateMaster', templateData.value).then(res => {
                    if (res.status === 200) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Terms & Condition Template Added',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: `You have successfully Added Terms & Condition Template.`,
                            },
                        })
                    } else {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Error',
                                icon: 'AlertCircleIcon',
                                variant: 'danger',
                                text: 'Something went wrong!',
                            },
                        })
                    }
                    router.push({
                        name: 'edit-term-condition-template-master',
                        params: {
                            id: res.data.data._id
                        }
                    })
                })

            }

            const {refFormObserver, getValidationState, resetForm} = formValidation(resetFormData)
            return{
                templateData,
                resetFormData,
                refFormObserver,
                getValidationState,
                resetForm,
                required,
                statusOption,
                saveTemplateData

            }
        }
    }
</script>

