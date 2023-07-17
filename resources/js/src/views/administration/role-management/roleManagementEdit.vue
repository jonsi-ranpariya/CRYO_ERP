<template>
    <div>
        <b-overlay
            :show="showOverlayLoading"
            rounded="sm"
        >
            <b-card-code>
                <validation-observer
                    #default="{ handleSubmit }"
                >
                    <!-- Form -->
                    <b-form
                        @submit.prevent="handleSubmit(saveFormData)"
                    >
                        <b-row>
                            <b-col md="4">
                                <!-- Group Name -->
                                <validation-provider
                                    #default="validationContext"
                                    name="Role Name"
                                    rules="required"
                                >
                                    <b-form-group>
                                        <label for="role_name">Role Name <span class="text-danger erp_required_star"
                                        >*</span></label>

                                        <b-form-input
                                            id="role_name"
                                            v-model="formData.name"
                                            placeholder="Role Name"
                                            autofocus
                                            v-uppercaseInput
                                            :state="getValidationState(validationContext)"
                                            trim
                                        />

                                        <b-form-invalid-feedback :state="getValidationState(validationContext)"
                                        >
                                            {{ validationContext.errors[0] }}
                                        </b-form-invalid-feedback>
                                    </b-form-group>
                                </validation-provider>
                            </b-col>
                        </b-row>
                        <hr>
                        <h3>Permissions</h3>
                        <hr>
                        <permission-tree-view
                            v-for="(child, key) in nodes"
                            :key="key"
                            :node="child"
                            :spacing="0"
                            :selectedParentValues.sync="formData.permissions"
                            @itemSelectedData="getSelectedItem($event)"
                        />
                        <hr>

                        <hr>
                        <!-- Save Button -->
                        <b-col md="12">
                            <b-button
                                v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                                variant="primary"
                                class="mr-2 float-right"
                                type="submit"
                            >
                                Save
                            </b-button>
                        </b-col>
                    </b-form>
                </validation-observer>
            </b-card-code>
        </b-overlay>
    </div>
</template>
<script>
import {
    BForm,
    BRow,
    BCol,
    BFormGroup,
    BButton,
    BFormInput,
    BCard,
    BFormInvalidFeedback,
    BTable,
    BCardHeader,
    BCardTitle,
    BFormCheckbox,
    BOverlay
} from 'bootstrap-vue'
import BCardCode from '@core/components/b-card-code/BCardCode'
import { ValidationObserver, ValidationProvider } from 'vee-validate'
import { ref } from '@vue/composition-api'
import formValidation from '../../../@core/comp-functions/forms/form-validation'
import { required } from '@validations'
import { uppercaseInput } from '@core/utils/utils'
import Ripple from 'vue-ripple-directive'
import PermissionTreeView from '@core/components/tree-view/PermissionTreeView.vue'
import axios from '@axios'
import router from '@/router'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
import { useToast } from 'vue-toastification/composition'
import {permissionList} from '@core/utils/permissions'

export default {
    components: {
        PermissionTreeView,
        BCardCode,
        BForm,
        BRow,
        BCol,
        ValidationProvider,
        ValidationObserver,
        BFormGroup,
        BButton,
        BFormInput,
        BFormInvalidFeedback,
        BTable,
        BCard,
        BCardHeader,
        BCardTitle,
        BFormCheckbox,
        BOverlay
    },
    directives: {
        Ripple,
        uppercaseInput,
    },
    setup() {
        const showOverlayLoading = ref(false)
        const toast = useToast()

        const blankFormData = {
            _id: null,
            name: null,
            permissions: []
        }

        const formData = ref(JSON.parse(JSON.stringify(blankFormData)))

        const resetFormData = () => {
            formData.value = JSON.parse(JSON.stringify(blankFormData))
        }

        const refetchData = async () => {
            showOverlayLoading.value = true
            await axios.get(`/api/role-management/${router.currentRoute.params.id}`)
                .then((res) => {
                    formData.value._id = res.data.data._id
                    formData.value.name = res.data.data.name
                    formData.value.permissions = res.data.data.permissions

                    let permissions = formData.value.permissions
                    if (permissions.length > 0) {
                        permissions.forEach((permission) => {
                            document.getElementById(permission.name).setAttribute('checked', 'checked')
                        })
                    }
                })
            showOverlayLoading.value = false
        }
        refetchData()

        const saveFormData = async () => {
            await axios.put(`/api/role-management/${router.currentRoute.params.id}`, formData.value)
                .then((res) => {
                    if (res.status === 200) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Role Details Updated',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: 'You have successfully Updated Role Details.',
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
                })
                .catch((error) => {
                    let response = error.response
                    if (response){
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Error',
                                icon: 'CheckSquareIcon',
                                variant: 'danger',
                                text: 'Internal server error',
                            },
                        })
                    }
                })
        }

        let tree = permissionList()

        const getSelectedItem = (event) => {
            let myPermissionArray = []
            let allSelectedCheckBox = document.querySelectorAll('input[type=checkbox]:checked')
            allSelectedCheckBox.forEach((item) => {
                myPermissionArray.push(item.dataset.value)
            })
            formData.value.permissions = myPermissionArray
        }

        const {
            refFormObserver,
            getValidationState,
            resetForm
        } = formValidation(resetFormData)

        return {
            refFormObserver,
            getValidationState,
            resetForm,
            resetFormData,
            formData,
            required,
            saveFormData,
            refetchData,
            showOverlayLoading,
            nodes: tree,
            getSelectedItem
        }

    }
}
</script>
