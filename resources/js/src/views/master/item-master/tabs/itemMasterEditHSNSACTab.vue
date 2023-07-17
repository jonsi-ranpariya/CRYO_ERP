<template>
    <div>
        <b-row>
            <b-col md="12">
                <hr>
                <h4>HSN/SAC Details</h4>
                <hr>
            </b-col>
        </b-row>
        <validation-observer
            ref="validateRules"
            #default="{ handleSubmit }"
        >
            <b-form
                @submit.prevent="handleSubmit(submitFormData)"
            >
                <b-row>
                    <b-col md="12">
                        <b-form-group
                            label="HSN/SAC"
                            label-for="hsnSac"
                        >
                            <validation-provider
                                #default="validationContext"
                                name="HSN/SAC"
                                rules=""
                            >
                                <v-select
                                    id="hsnSac"
                                    v-model="formData.hsnSac"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="options"
                                    :clearable="false"
                                    :reduce="val => val.value"
                                    :state="getValidationState(validationContext)"
                                />
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </validation-provider>
                        </b-form-group>
                        <b-form-group
                            label="HSN/SAC Description"
                            label-for="hsnSacDescription"
                        >
                            <validation-provider
                                #default="validationContext"
                                name="HSN/SAC Description"
                                rules=""
                            >
                                <v-select
                                    id="hsnSacDescription"
                                    v-model="formData.hsnSacDescription"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="hsnSacDescriptionOptions"
                                    :clearable="false"
                                    :state="getValidationState(validationContext)"
                                    v-on:input="getHsnCode($event)"
                                />
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </validation-provider>
                        </b-form-group>
                        <b-form-group
                            label="HSN/SAC No."
                            label-for="hsnSacNo"
                        >
                            <validation-provider
                                #default="validationContext"
                                name="HSN/SAC No."
                                rules=""
                            >
                                <b-form-input
                                    id="hsnSacNo"
                                    v-model="formData.hsnSacNo"
                                    :state="getValidationState(validationContext)"
                                    readonly
                                />
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </validation-provider>
                        </b-form-group>
                    </b-col>
                    <b-col md="12">
                        <b-button
                            type="submit"
                            variant="primary"
                            class="float-right"
                        >
                            Save
                        </b-button>
                    </b-col>
                </b-row>
            </b-form>
        </validation-observer>
    </div>
</template>
<script>
    import BCardCode from '@core/components/b-card-code'
    import flatPickr from 'vue-flatpickr-component'
    import {
        BRow,
        BCol,
        BFormGroup,
        BFormInput,
        BFormCheckbox,
        BForm,
        BButton,
        BTab,
        BTabs,
        BFormTextarea,
        BFormInvalidFeedback,
        BInputGroup
    } from 'bootstrap-vue'
    import {required, max} from '@validations'
    import Ripple from 'vue-ripple-directive'
    import vSelect from 'vue-select'
    import {ref, onUnmounted} from '@vue/composition-api'
    import formValidation from '@core/comp-functions/forms/form-validation'
    import {ValidationProvider, ValidationObserver, validate} from 'vee-validate'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import { useToast } from 'vue-toastification/composition'
    import router from '@/router'
    import store from '@/store'
    import masterStoreModule from "../../masterStoreModule";

    export default {
        components: {
            BCardCode,
            ValidationProvider,
            ValidationObserver,
            BRow,
            BCol,
            BFormGroup,
            BFormInput,
            BFormCheckbox,
            BForm,
            BButton,
            BTab,
            BTabs,
            BFormTextarea,
            BFormInvalidFeedback,
            BInputGroup,
            vSelect,
            flatPickr,
        },
        directives: {
            Ripple,
        },
        data() {
            return {
                options: [
                    {label: 'No', value: 0},
                    {label: 'Yes', value: 1},
                ],
                hsnSacDescriptionOptions: [],
            }
        },
        beforeCreate() {
            this.$http.get('/api/get-item-hsn-sac-code-options').then(res => {
                this.hsnSacDescriptionOptions = res.data.data
            })
            this.$http.get(`/api/item-master/${router.currentRoute.params.id}`).then(res => {
                if (typeof (res.data.data.hsnSacDetails) === "object") {
                    this.formData = res.data.data.hsnSacDetails
                    this.formData.id = res.data.data._id
                    delete this.formData._id
                }
            })
        },
        setup() {
            const toast = useToast()

            const APP_STORE_MODULE_NAME = 'master-add'
            if (!store.hasModule(APP_STORE_MODULE_NAME)) store.registerModule(APP_STORE_MODULE_NAME, masterStoreModule)
            onUnmounted(() => {
                if (store.hasModule(APP_STORE_MODULE_NAME)) store.unregisterModule(APP_STORE_MODULE_NAME)
            })

            const blankFormData = {
                id: router.currentRoute.params.id,
                ishsnSacDetails: true,
                hsnSac: 1,
                hsnSacDescription: [],
                hsnSacNo: null,
            }

            const formData = ref(JSON.parse(JSON.stringify(blankFormData)))

            const resetGroupData = () => {
                formData.value = JSON.parse(JSON.stringify(blankFormData))
            }

            const submitFormData = () => {
                store.dispatch('master-add/updateItemMaster',formData.value).then(res => {
                    toast({
                        component: ToastificationContent,
                        position: 'top-right',
                        props: {
                            title: 'HSN/SAC Updated',
                            icon: 'CheckSquareIcon',
                            variant: 'success',
                            text: 'You have successfully Updated HSN/SAC',
                        },
                    })
                })
            }

            const {refFormObserver, getValidationState, resetForm} = formValidation(resetGroupData)

            return {
                formData,
                submitFormData,

                refFormObserver,
                getValidationState,
                resetForm,
                resetGroupData,
            }
        },
        methods: {
            getHsnCode() {
                this.formData.hsnSacNo = this.formData.hsnSacDescription.codeNo
            }
        }
    }
</script>
