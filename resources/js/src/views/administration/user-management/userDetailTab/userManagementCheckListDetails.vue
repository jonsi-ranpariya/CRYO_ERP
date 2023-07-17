<template>
    <div>
        <validation-observer #default="{handleSubmit}">
            <b-form @submit.prevent="handleSubmit(saveFormData)" class="mb-2">
                <div class="d-flex">
                    <feather-icon
                        icon="FileIcon"
                        size="19"
                    />
                    <h4 class="mb-0 ml-50">
                        Document Detail
                    </h4>
                </div>
                <br>
                <b-row>
                    <b-col md="6">
                        <validation-provider
                            #default="validationContext"
                            name="Document Name"
                            rules="required"
                        >
                            <b-form-group
                                label="Document Name"
                                label-for="document_name"
                                :state="getValidationState(validationContext)"
                            >
                                <b-form-input
                                    type="text"
                                    id="document_name"
                                    v-model="userFormData.document_name"
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
                            name="Document Item"
                            rules="required"
                        >
                            <b-form-group
                                label="Select Document"
                                label-for="documentItem"
                                :state="getValidationState(validationContext)"
                            >
                                <b-form-file
                                    id="documentItem"
                                    v-model="userFormData.documentItem"
                                    @change="changeImage($event)"
                                    :state="getValidationState(validationContext)"
                                />
                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                    </b-col>
                </b-row><hr>
                <b-col md="12">
                    <b-button
                        type="submit"
                        variant="primary"
                        class="float-right"
                    >
                        Save
                    </b-button>
                </b-col>
            </b-form>
        </validation-observer>
    </div>
</template>
<script>
    import {
        BForm,
        BRow,
        BCol,
        BFormInput,
        BFormGroup,
        BFormInvalidFeedback,
        BButton
    } from 'bootstrap-vue'
    import {ValidationObserver, ValidationProvider} from 'vee-validate'
    import {computed, ref, onUnmounted} from "@vue/composition-api";
    import {required} from '@validations'
    import formValidation from '@core/comp-functions/forms/form-validation'
    import userStoreModule from "../userStoreModule";
    import {useToast} from "vue-toastification/composition";
    import store from '@/store'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import router from '@/router'

    export default {
        components: {
            ValidationObserver,
            ValidationProvider,
            BForm,
            BRow,
            BCol,
            BFormInput,
            BFormGroup,
            BFormInvalidFeedback,
            BButton
        },
        props:{
            userCheckListDetails:{
                type: Object,
                required: true,
            }
        },
        setup(props) {
            /*
            const toast = useToast()

            const ITEMADDON_APP_STORE_MODULE_NAME = 'users-store-module'
            if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, userStoreModule)
            onUnmounted(() => {
                if (store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.unregisterModule(ITEMADDON_APP_STORE_MODULE_NAME)
            })
            */

            const changeImage = (e) => {
                e.preventDefault()
                userFormData.value.documentItem = e.target.files[0]
            }

            const userFormData = computed(() => props.userCheckListDetails)

            const resetFormData = () => {
                userFormData.value = JSON.parse(JSON.stringify(userFormData.value))
            }

            const saveFormData = async () => {
                console.log(userFormData.value)
                /* let submitData = {
                    _id: router.currentRoute.params.id,
                    userCheckListDetails: userFormData.value
                }*/
                /*     await store.dispatch('users-store-module/updateUserManagementDetail', submitData).then((res) => {
                         if (res.status === 200) {
                             toast({
                                 component: ToastificationContent,
                                 position: 'top-right',
                                 props: {
                                     title: 'user Check List Detail updated',
                                     icon: 'CheckSquareIcon',
                                     variant: 'success',
                                     text: `You have successfully Updated User Check List Detail.`,
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

                     })
                 */
            }

            const {refFormObserver, getValidationState, resetForm} = formValidation(resetFormData)
            return {
                /*Form Data*/
                userFormData,
                saveFormData,

                /* Validations */
                refFormObserver,
                getValidationState,
                resetForm,
                resetFormData,
                required,

                /* upload file */
                changeImage
            }
        }
    }

</script>
