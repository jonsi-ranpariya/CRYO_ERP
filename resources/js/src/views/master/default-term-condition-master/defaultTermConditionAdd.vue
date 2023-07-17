<template>
    <div>
        <b-card-code>
            <validation-observer #default="{ handleSubmit }">
                <b-form @submit.prevent="handleSubmit(saveFormData)">
                    <b-row>
                        <b-col md="8">
                            <validation-provider
                                #default="validationContext"
                                name="Term And Condition For"
                                rules="required"
                            >
                                <b-form-group
                                    :state="getValidationState(validationContext)"
                                >
                                    <label for="tcFor">Term And Condition For <span
                                        class="text-danger erp_required_star">*</span></label>

                                    <v-select
                                        v-model="formData.tcFor"
                                        placeholder="Select For"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="termConditionForOptions"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        id="tcFor"
                                    />
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
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
                                        v-model="formData.status"
                                    />
                                    <b-form-invalid-feedback>
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                        </b-col>
                    </b-row>
                    <b-col md="12">
                        <hr>
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
        </b-card-code>
    </div>
</template>
<script>
import {
    BForm,
    BRow,
    BCol,
    BFormGroup,
    BFormInvalidFeedback,
    BButton
} from 'bootstrap-vue'
import BCardCode from "../../../@core/components/b-card-code/BCardCode";
import {ValidationObserver, ValidationProvider} from 'vee-validate'
import {ref, onUnmounted} from '@vue/composition-api'
import axios from '@axios'
import vSelect from 'vue-select'
import {required} from '@validations'
import formValidation from '@core/comp-functions/forms/form-validation'
import {useToast} from "vue-toastification/composition";
import store from '@/store'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
import masterStoreModule from '../masterStoreModule'
import router from '@/router'
import Swal from "sweetalert2";
export default {
    components: {
        BCardCode,
        ValidationObserver,
        ValidationProvider,
        BForm,
        BRow,
        BCol,
        BFormGroup,
        BFormInvalidFeedback,
        vSelect,
        BButton
    },
    setup() {
        const toast = useToast()
        const ITEMADDON_APP_STORE_MODULE_NAME = 'default-terms-condition-master'
        if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, masterStoreModule)
        onUnmounted(() => {
            if (store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.unregisterModule(ITEMADDON_APP_STORE_MODULE_NAME)
        })

        const termConditionForOptions = ref([
            {label: 'Quotation', value: 1},
            {label: 'Sales Order', value: 2},
            {label: 'Purchase Order', value: 3},
            {label: 'Purchase Card', value: 4},
            {label: 'Invoice', value: 5},
        ])
        const statusOption = ref([
            {label: 'Yes', value: 1},
            {label: 'No', value: 2},
        ])

        const blankFormData = {
            id:null,
            tcFor: null,
            status: 1,
        }
        const formData = ref(JSON.parse(JSON.stringify(blankFormData)))

        const resetFormData = () => {
            formData.value = JSON.parse(JSON.stringify(blankFormData))
        }
        const saveFormData = async () => {
            await axios.post('/api/new/default-terms-condition-master-exist',
                    {
                        // id: formData.value._id,
                        tcFor: formData.value.tcFor
                    }
                ).then(res => {
                 if (res.data.data === true) {

                     Swal.fire({
                         icon: 'error',
                         title: 'Oops...',
                         text: 'Tems and Condition For Already Exist!',
                     })

                 } else {
                     store.dispatch('default-terms-condition-master/addDefaultTermsCondition', formData.value).then(res => {
                         if (res.status === 200) {
                             router.push({
                                 name: 'edit-default-term-condition-master',
                                 params: {
                                     id: res.data.data._id
                                 }
                             })
                             toast({
                                 component: ToastificationContent,
                                 position: 'top-right',
                                 props: {
                                     title: 'Default Terms & Condition Added',
                                     icon: 'CheckSquareIcon',
                                     variant: 'success',
                                     text: `You have successfully Added Default Terms & Condition.`,
                                 },
                             })
                         }
                     })
                 }
               })
            }

        const {refFormObserver, getValidationState, resetForm} = formValidation(resetFormData)
        return {
            termConditionForOptions,
            formData,
            refFormObserver,
            getValidationState,
            resetForm,
            resetFormData,
            required,
            saveFormData,
            statusOption
        }
    }
}
</script>
