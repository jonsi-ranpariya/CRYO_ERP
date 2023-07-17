<template>
    <validation-observer
        ref="validateRules"
        #default="{ handleSubmit }"
    >
        <b-form
            @submit.prevent="handleSubmit(submitFormData)"
        >
            <b-row>
                <b-col md="6">
                    <hr>
                        <h4>Item Details</h4>
                    <hr>
                    <b-form-group
                        label="Add Description"
                        label-for="description"
                    >
                        <validation-provider
                            #default="validationContext"
                            name="Add Description"
                            rules=""
                        >
                            <b-form-input
                                id="description"
                                v-model="formData.description"
                                :state="getValidationState(validationContext)"
                            />
                            <b-form-invalid-feedback>
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </validation-provider>
                    </b-form-group>
                    <b-form-group
                        label="Detail Description"
                        label-for="detailDescription"
                    >
                        <validation-provider
                            #default="validationContext"
                            name="Detail Description"
                            rules=""
                        >
                            <b-form-textarea
                                id="detailDescription"
                                v-model="formData.detailDescription"
                                rows="2"
                                :state="getValidationState(validationContext)"
                            />
                            <b-form-invalid-feedback>
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </validation-provider>
                    </b-form-group>
                    <b-form-group
                        label="Drawing Number"
                        label-for="drawingNumber"
                    >
                        <validation-provider
                            #default="validationContext"
                            name="Drawing Number"
                            rules=""
                        >
                            <b-form-input
                                id="drawingNumber"
                                v-model="formData.drawingNumber"
                                :state="getValidationState(validationContext)"
                            />
                            <b-form-invalid-feedback>
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </validation-provider>
                    </b-form-group>
                    <b-form-group
                        label="Revision"
                        label-for="revision"
                    >
                        <validation-provider
                            #default="validationContext"
                            name="Revision"
                            rules=""
                        >
                            <b-form-input
                                id="revision"
                                type="number"
                                v-model="formData.revision"
                                :state="getValidationState(validationContext)"
                            />
                            <b-form-invalid-feedback>
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </validation-provider>
                    </b-form-group>
                    <b-form-group
                        label="Material Specification"
                        label-for="materialSpecification"
                    >
                        <validation-provider
                            #default="validationContext"
                            name="Material Specification"
                            rules=""
                        >
                            <b-form-input
                                id="materialSpecification"
                                v-model="formData.materialSpecification"
                                :state="getValidationState(validationContext)"
                            />
                            <b-form-invalid-feedback>
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </validation-provider>
                    </b-form-group>
                    <b-form-group
                        label="Remark / Note"
                        label-for="remarkNote"
                    >
                        <validation-provider
                            #default="validationContext"
                            name="Remark / Note"
                            rules=""
                        >
                            <b-form-textarea
                                id="remarkNote"
                                v-model="formData.remarkNote"
                                rows="2"
                                :state="getValidationState(validationContext)"
                            />
                            <b-form-invalid-feedback>
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </validation-provider>
                    </b-form-group>
                </b-col>
                <b-col md="6">
                    <hr>
                    <h4>Item Groups</h4>
                    <hr>
                    <b-form-group
                        label="Main Group"
                        label-for="mainGroup"
                    >
                        <validation-provider
                            #default="validationContext"
                            name="Main Group"
                            rules=""
                        >
                            <v-select
                                id="mainGroup"
                                v-model="formData.mainGroup"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="groupOptions"
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
                        label="Sub Group"
                        label-for="subGroup"
                    >
                        <validation-provider
                            #default="validationContext"
                            name="Sub Group"
                            rules=""
                        >
                            <v-select
                                id="subGroup"
                                v-model="formData.subGroup"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="groupOptions"
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
                        label="Serial No Code"
                        label-for="serialNoCode"
                    >
                        <validation-provider
                            #default="validationContext"
                            name="Serial No Code"
                            rules=""
                        >
                            <b-form-input
                                id="serialNoCode"
                                type="number"
                                v-model="formData.serialNoCode"
                                :state="getValidationState(validationContext)"
                            />
                            <b-form-invalid-feedback>
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </validation-provider>
                    </b-form-group>
                </b-col>
                <b-col md="12">
                    <hr>
                    <b-button
                        variant="primary"
                        type="submit"
                        class="float-right"
                    >
                        Save
                    </b-button>
                </b-col>
            </b-row>
        </b-form>
    </validation-observer>
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
                groupOptions: [],
            }
        },
        created() {
            this.$http.get('/api/get-item-main-sub-group-options').then(res => {
                this.groupOptions = res.data.data
            });
            this.$http.get(`/api/item-master/${router.currentRoute.params.id}`).then(res => {
                if (typeof (res.data.data.itemDetails) === "object"){
                    this.formData = res.data.data.itemDetails
                    this.formData.id = res.data.data._id
                    this.formData.isItemDetailsData = true
                    delete this.formData._id
                }
            });
        },
        emits: ['refetchData'],
        setup(props, { emit }) {
            const toast = useToast()

            const APP_STORE_MODULE_NAME = 'master-add'
            if (!store.hasModule(APP_STORE_MODULE_NAME)) store.registerModule(APP_STORE_MODULE_NAME, masterStoreModule)
            onUnmounted(() => {
                if (store.hasModule(APP_STORE_MODULE_NAME)) store.unregisterModule(APP_STORE_MODULE_NAME)
            })

            const blankFormData = {
                id: router.currentRoute.params.id,
                description : '',
                detailDescription : '',
                drawingNumber : '',
                revision : '',
                materialSpecification : '',
                remarkNote : '',
                mainGroup : [],
                subGroup : [],
                serialNoCode : '',
                isItemDetailsData: true
            }

            const formData = ref(JSON.parse(JSON.stringify(blankFormData)))

            const resetGroupData = () => {
                formData.value = JSON.parse(JSON.stringify(blankFormData))
            }

            const submitFormData = async () => {
                await store.dispatch('master-add/updateItemMaster',formData.value).then(res => {
                    emit('refetchData', true)
                    toast({
                        component: ToastificationContent,
                        position: 'top-right',
                        props: {
                            title: 'Item Details Updated',
                            icon: 'CheckSquareIcon',
                            variant: 'success',
                            text: 'You have successfully Updated Item Details',
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
    }
</script>
