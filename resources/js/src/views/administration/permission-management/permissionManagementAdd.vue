<template>
    <b-sidebar
        id="add-new-permission-management-sidebar"
        :visible="isAddPermissionManagementSidebarActive"
        bg-variant="white"
        sidebar-class="sidebar-lg"
        shadow
        backdrop
        no-header
        right
        @change="(val) => $emit('update:isAddPermissionManagementSidebarActive', val)"
    >
        <template #default="{ hide }">
            <div class="d-flex justify-content-between align-items-center content-sidebar-header px-2 py-1">
                <h5 class="mb-0">
                    Add/Edit Permission
                </h5>

                <feather-icon
                    class="ml-1 cursor-pointer"
                    icon="XIcon"
                    size="16"
                    @click="hide"
                />

            </div>
            <!--Body-->
            <validation-observer
                #default="{ handleSubmit }"
                ref="refFormObserver"
            >
                <!-- Form -->
                <b-form
                    class="p-2"
                    @submit.prevent="handleSubmit(onSubmit)"
                    @reset.prevent="resetForm"
                >
                    <!-- Group Name -->
                    <validation-provider
                        #default="validationContext"
                        name="Permission Name"
                        rules="required"
                    >
                        <b-form-group>
                            <label for="permission_name">Permission Name <span class="text-danger erp_required_star"
                            >*</span></label>
                            <b-form-input
                                id="permission_name"
                                v-model="formData.name"
                                placeholder="Permission Name"
                                autofocus
                                v-uppercaseInput
                                :state="getValidationState(validationContext)"
                                trim
                            />

                            <b-form-invalid-feedback>
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </validation-provider>

                    <!-- Form Actions -->
                    <div class="d-flex mt-2">
                        <b-button
                            v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                            variant="primary"
                            class="mr-2"
                            type="submit"
                        >
                            Add
                        </b-button>
                        <b-button
                            v-ripple.400="'rgba(186, 191, 199, 0.15)'"
                            type="button"
                            variant="outline-secondary"
                            @click="hide"
                        >
                            Cancel
                        </b-button>
                    </div>
                </b-form>
            </validation-observer>
        </template>
    </b-sidebar>
</template>
<script>
import { BSidebar, BForm, BFormGroup, BFormInput, BFormInvalidFeedback, BButton } from 'bootstrap-vue'
import { ValidationProvider, ValidationObserver } from 'vee-validate'
import { computed, ref } from '@vue/composition-api'
import { required } from '@validations'
import formValidation from '@core/comp-functions/forms/form-validation'
import Ripple from 'vue-ripple-directive'
import { uppercaseInput } from '@core/utils/utils'
import axios from '@axios'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
import { useToast } from 'vue-toastification/composition'

export default {
    components: {
        BSidebar,
        BForm,
        BFormGroup,
        BFormInput,
        BFormInvalidFeedback,
        BButton,

        // Form Validation
        ValidationProvider,
        ValidationObserver,
    },
    directives: {
        Ripple,
        uppercaseInput,
    },
    model: {
        props: 'isAddPermissionManagementSidebarActive',
    },
    props: {
        isAddPermissionManagementSidebarActive: {
            type: Boolean,
            required: true,
        },
        permissionFormData: {
            type: Object,
            required: true
        }
    },
    setup(props, {emit}) {


        const toast = useToast()

        const formData = computed(() => props.permissionFormData)

        const resetFormData = () => {
            formData.value._id = formData.value._id = null
            formData.value.name = formData.value.name = null
        }

        const onSubmit = async () => {
            if (formData.value._id === null) {
                await axios.post('/api/permission-management', formData.value)
                    .then((res) => {
                        if (res.status === 200) {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Permission Added',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: 'You have successfully Added Permission.',
                                },
                            })
                        } else {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Warning',
                                    icon: 'CheckSquareIcon',
                                    variant: 'warning',
                                    text: 'Something Went Wrong.',
                                },
                            })
                        }
                        emit('update:isAddPermissionManagementSidebarActive', false)
                        emit('refetch-data')
                    })
                    .catch((error) => {
                        if (error.response) {
                            let response = error.response
                            if (response.status === 400) {
                                toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: 'Warning',
                                        icon: 'AlertCircleIcon',
                                        variant: 'warning',
                                        text: `A ${formData.value.name} name already exists.`,
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
                                        text: 'Internal Server Error.',
                                    },
                                })
                            }
                        }
                    })
            } else {
                await axios.put(`/api/permission-management/${formData.value._id}`, formData.value)
                    .then((res) => {
                        if (res.status === 200) {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Permission Updated',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: 'You have successfully Updated Permission.',
                                },
                            })
                        } else {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Warning',
                                    icon: 'CheckSquareIcon',
                                    variant: 'warning',
                                    text: 'Something Went Wrong.',
                                },
                            })
                        }
                        emit('update:isAddPermissionManagementSidebarActive', false)
                        emit('refetch-data')
                    })
                    .catch((error) => {
                        if (error.response) {
                            let response = error.response
                            if (response.status === 400) {
                                toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: 'Warning',
                                        icon: 'AlertCircleIcon',
                                        variant: 'warning',
                                        text: `A ${formData.value.name} name already exists.`,
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
                                        text: 'Internal Server Error.',
                                    },
                                })
                            }
                        }
                    })
            }
        }

        const {
            refFormObserver,
            getValidationState,
            resetForm
        } = formValidation(resetFormData)

        return {
            formData,
            onSubmit,
            resetFormData,

            refFormObserver,
            getValidationState,
            resetForm,
            required,
        }
    }
}
</script>
