<template>
    <!-- modal -->
    <b-modal
        :id="'edit-modal' + itemId"
        title="Edit"
        ok-title="submit"
        cancel-variant="danger"
        size="lg"
        no-close-on-backdrop
        @ok="handelOk"
    >
        <validation-observer ref="refFormObserver" #default="{ handleSubmit }">
            <b-form>
                <b-form-group
                    label="Code"
                    label-for="code"
                >
                    <b-form-input
                        id="code"
                        placeholder="Code"
                        v-model="formData.groupCode"
                        readonly
                    />
                </b-form-group>
                <b-form-group
                    label="Group Name"
                    label-for="groupName"
                >
                    <validation-provider
                        #default="validationContext"
                        name="Group Name"
                        rules="required"
                    >
                        <b-form-input
                            id="groupName"
                            placeholder="Group Name"
                            v-model="formData.groupName"
                            :state="getValidationState(validationContext)"
                        />
                        <b-form-invalid-feedback>
                            {{ validationContext.errors[0] }}
                        </b-form-invalid-feedback>
                    </validation-provider>
                </b-form-group>
                <b-form-group
                    label="Is Last Level"
                    label-for="lastLevel"
                >
                    <validation-provider
                        #default="validationContext"
                        name="vue-select"
                        rules="required"
                    >
                        <v-select
                            id="vue-select"
                            v-model="formData.isLastLevel"
                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                            :options="options"
                            :clearable="false"
                            disabled
                            :state="getValidationState(validationContext)"
                        />
                        <b-form-invalid-feedback>
                            {{ validationContext.errors[0] }}
                        </b-form-invalid-feedback>
                    </validation-provider>
                </b-form-group>
            </b-form>
        </validation-observer>
    </b-modal>
</template>
<script>
    import {
        BFormGroup, BForm, BButton, BModal, VBModal, BCardText, BCardBody, BFormInput, BFormInvalidFeedback
    } from 'bootstrap-vue'
    import {required} from '@validations'
    import formValidation from '@core/comp-functions/forms/form-validation'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import {ValidationProvider, ValidationObserver, validate} from 'vee-validate'
    import Ripple from 'vue-ripple-directive'
    import financeMasterStoreModule from '../financeMasterStoreModule'
    import {ref, onUnmounted} from '@vue/composition-api'
    import vSelect from 'vue-select'
    import store from '@/store'

    export default {
        components: {
            BFormGroup,
            BForm,
            BButton,
            vSelect,
            BModal,
            BCardText,
            BCardBody,
            BFormInput,
            BFormInvalidFeedback,

            ValidationProvider,
            ValidationObserver,
        },
        directives: {
            'b-modal': VBModal,
            Ripple,
        },
        props: {
            itemId : String,
            itemData: Object
        },
        data() {
            return {
                required,
                options: ['Yes', 'No'],
            }
        },
        computed: {},
        setup(props) {
            const COACC_APP_STORE_MODULE_NAME = 'master-add'
            if (!store.hasModule(COACC_APP_STORE_MODULE_NAME)) store.registerModule(COACC_APP_STORE_MODULE_NAME, financeMasterStoreModule)
            onUnmounted(() => {
                if (store.hasModule(COACC_APP_STORE_MODULE_NAME)) store.unregisterModule(COACC_APP_STORE_MODULE_NAME)
            })

            const blankFormData = props.itemData

            const formData = ref(JSON.parse(JSON.stringify(blankFormData)))

            const resetGroupData = () => {
                formData.value = JSON.parse(JSON.stringify(blankFormData))
            }

            const { refFormObserver, getValidationState, resetForm } = formValidation(resetGroupData)

            return {
                formData,

                refFormObserver,
                getValidationState,
                resetForm,
                resetGroupData,
            }
        },
        methods: {
            handelOk(eve){
                eve.preventDefault()
                this.$refs.refFormObserver.validate().then(valid => {
                    if (valid){
                        this.submitFormData()
                    }
                })
            },
            submitFormData() {
                let payload = {
                    groupName: this.formData.groupName,
                    groupCode: this.formData.groupCode,
                    isLastLevel: this.formData.isLastLevel,
                    d_id: this.formData.d_id
                }

                store.dispatch('master-add/updateCostCenterMaster', payload).then(response => {
                    if (response.status == 200) {
                        store.dispatch(`master-add/fetchCostCenterList`)
                        this.$bvModal.hide('edit-modal'+ this.formData.d_id)
                        this.$toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Cost Center Master Updated',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: `You have successfully Update Cost Center Master : ${this.formData.groupName}.`,
                            },
                        })
                    }
                })
            },
        },
    }
</script>
