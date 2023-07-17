<template>
    <!-- modal -->
    <b-modal
        :id="'modal-primary' + itemId"
        title="Add"
        ok-title="submit"
        cancel-variant="danger"
        size="lg"
        no-close-on-backdrop
        @ok="handelOk"
        @cancel="resetFormData"
        @close="resetFormData"
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
            itemId : String
        },
        data() {
            return {
                required,
                options: ['Yes', 'No'],
            }
        },
        setup(props) {
            const COACC_APP_STORE_MODULE_NAME = 'master-add'
            if (!store.hasModule(COACC_APP_STORE_MODULE_NAME)) store.registerModule(COACC_APP_STORE_MODULE_NAME, financeMasterStoreModule)
            onUnmounted(() => {
                if (store.hasModule(COACC_APP_STORE_MODULE_NAME)) store.unregisterModule(COACC_APP_STORE_MODULE_NAME)
            })

            const blankFormData = {
                groupCode: '',
                groupName: '',
                isLastLevel: 'No',
                parentGroupId: props.itemId,
            }

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
                store.dispatch('master-add/addCostCenterMaster', this.formData)
                    .then(response => {
                        if (response.status == 200) {
                            store.dispatch(`master-add/fetchCostCenterList`)
                            this.$bvModal.hide('modal-primary' + this.formData.parentGroupId)
                            this.$toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Cost Center Master Created',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: `You have successfully Created New Cost Center Master : ${this.formData.groupName}.`,
                                },
                            })
                            this.$forceUpdate()
                            this.resetFormData()
                        }
                    })
                    .catch(error => {
                        console.log(error)
                    })
            },
            resetFormData() {
                this.formData.groupCode = ''
                this.formData.groupName = ''
            },
        },
    }
</script>
