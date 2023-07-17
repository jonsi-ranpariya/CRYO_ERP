<template>
    <div>
        <b-row>
            <b-col md="12">
                <hr>
                <h4>Purchase Details</h4>
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
                    <b-col md="6">
                        <b-form-group
                            label="Minumum Stock Quantity"
                            label-for="minimumStockQuantity"
                        >
                            <validation-provider
                                #default="validationContext"
                                name="Minumum Stock Quantity"
                                rules=""
                            >
                                <b-form-input
                                    id="minimumStockQuantity"
                                    type="number"
                                    v-model="formData.minimumStockQuantity"
                                    :state="getValidationState(validationContext)"
                                />
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </validation-provider>
                        </b-form-group>
                        <b-form-group
                            label="Minumum Order Quantity"
                            label-for="minimumOrderQuantity"
                        >
                            <validation-provider
                                #default="validationContext"
                                name="Minumum Order Quantity"
                                rules=""
                            >
                                <b-form-input
                                    id="minimumOrderQuantity"
                                    type="number"
                                    v-model="formData.minimumOrderQuantity"
                                    :state="getValidationState(validationContext)"
                                />
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </validation-provider>
                        </b-form-group>
                        <b-form-group
                            label="Lead Time"
                            label-for="leadTime"
                        >
                            <validation-provider
                                #default="validationContext"
                                name="Lead Time"
                                rules=""
                            >
                                <b-input-group append="days">
                                    <b-form-input
                                        id="leadTime"
                                        type="number"
                                        v-model="formData.leadTime"
                                        :state="getValidationState(validationContext)"
                                    />
                                </b-input-group>
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </validation-provider>
                        </b-form-group>
                        <b-form-group
                            label="Class"
                            label-for="class"
                        >
                            <validation-provider
                                #default="validationContext"
                                name="Class"
                                rules=""
                            >
                                <v-select
                                    id="class"
                                    v-model="formData.class"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="classOptions"
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
                            label="Material Provided By"
                            label-for="materialProvidedBy"
                        >
                            <validation-provider
                                #default="validationContext"
                                name="Material Provided By"
                                rules=""
                            >
                                <v-select
                                    id="materialProvidedBy"
                                    v-model="formData.materialProvidedBy"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="materialProvidedOptions"
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
                            label="Purchase Officer"
                            label-for="purchaseOfficer"
                        >
                            <validation-provider
                                #default="validationContext"
                                name="Purchase Officer"
                                rules=""
                            >
                                <v-select
                                    id="purchaseOfficer"
                                    v-model="formData.purchaseOfficer"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="purchaseOfficerOptions"
                                    :clearable="false"
                                    :reduce="val => val.value"
                                    :state="getValidationState(validationContext)"
                                />
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </validation-provider>
                        </b-form-group>
                    </b-col>
                    <b-col md="6">
                        <b-form-group
                            label="Maximum Stock Quantity"
                            label-for="maximumStockQuantity"
                        >
                            <validation-provider
                                #default="validationContext"
                                name="Maximum Stock Quantity"
                                rules=""
                            >
                                <b-form-input
                                    id="maximumStockQuantity"
                                    type="number"
                                    v-model="formData.maximumStockQuantity"
                                    :state="getValidationState(validationContext)"
                                />
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </validation-provider>
                        </b-form-group>
                        <b-form-group
                            label="Maximum Order Quantity"
                            label-for="maximumOrderQuantity"
                        >
                            <validation-provider
                                #default="validationContext"
                                name="Maximum Order Quantity"
                                rules=""
                            >
                                <b-form-input
                                    id="maximumOrderQuantity"
                                    type="number"
                                    v-model="formData.maximumOrderQuantity"
                                    :state="getValidationState(validationContext)"
                                />
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </validation-provider>
                        </b-form-group>
                        <b-form-group
                            label="ReOrder Quantity"
                            label-for="reorderQuality"
                        >
                            <validation-provider
                                #default="validationContext"
                                name="ReOrder Quantity"
                                rules=""
                            >
                                <b-form-input
                                    id="reorderQuality"
                                    type="number"
                                    v-model="formData.reorderQuality"
                                    :state="getValidationState(validationContext)"
                                />
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </validation-provider>
                        </b-form-group>
                        <b-form-group
                            label="GRN Required...?"
                            label-for="grnRequied"
                        >
                            <validation-provider
                                #default="validationContext"
                                name="GRN Required...?"
                                rules=""
                            >
                                <v-select
                                    id="grnRequired"
                                    v-model="formData.grnRequired"
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
                            label="Allow Manual Transaction...?"
                            label-for="allowManualTransaction"
                        >
                            <validation-provider
                                #default="validationContext"
                                name="Allow Manual Transaction...?"
                                rules=""
                            >
                                <v-select
                                    id="allowManualTransaction"
                                    v-model="formData.allowManualTransaction"
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
                    </b-col>
                    <b-col md="12">
                        <hr>
                        <h4>Tolerance</h4>
                        <hr>
                    </b-col>
                    <b-col md="6">
                        <b-form-group
                            label="Tolerance(-)"
                            label-for="toleranceMinus"
                        >
                            <validation-provider
                                #default="validationContext"
                                name="Tolerance(-)"
                                rules=""
                            >
                                <b-input-group append="%">
                                    <b-form-input
                                        id="toleranceMinus"
                                        type="number"
                                        v-model="formData.toleranceMinus"
                                        :state="getValidationState(validationContext)"
                                    />
                                </b-input-group>
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </validation-provider>
                        </b-form-group>
                        <b-form-group
                            label="Tolerance(+)"
                            label-for="tolerancePlus"
                        >
                            <validation-provider
                                #default="validationContext"
                                name="Tolerance(+)"
                                rules=""
                            >
                                <b-input-group append="%">
                                    <b-form-input
                                        id="tolerancePlus"
                                        type="number"
                                        v-model="formData.tolerancePlus"
                                        :state="getValidationState(validationContext)"
                                    />
                                </b-input-group>
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </validation-provider>
                        </b-form-group>
                    </b-col>
                    <b-col md="6">
                        <b-form-group
                            label="Value"
                            label-for="toleranceMinusValue"
                        >
                            <validation-provider
                                #default="validationContext"
                                name="Value"
                                rules=""
                            >
                                <b-form-input
                                    id="toleranceMinusValue"
                                    type="number"
                                    v-model="formData.toleranceMinusValue"
                                    :state="getValidationState(validationContext)"
                                />
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </validation-provider>
                        </b-form-group>
                        <b-form-group
                            label="Value"
                            label-for="tolerancePlusValue"
                        >
                            <validation-provider
                                #default="validationContext"
                                name="Value"
                                rules=""
                            >
                                <b-form-input
                                    id="tolerancePlusValue"
                                    type="number"
                                    v-model="formData.tolerancePlusValue"
                                    :state="getValidationState(validationContext)"
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
                classOptions : [
                    {label: 'A', value: 1},
                    {label: 'B', value: 2},
                    {label: 'C', value: 3},
                    {label: 'D', value: 4},
                    {label: 'E', value: 5},
                    {label: 'F', value: 6},
                ],
                materialProvidedOptions: [
                    {label: 'Vendor', value: 1},
                    {label: 'Customer', value: 2}
                ],
                purchaseOfficerOptions: [],
            }
        },
        beforeCreate() {
            this.$http.get('/api/get-users-options').then(res => {
                this.purchaseOfficerOptions = res.data.data
            })

            this.$http.get(`/api/item-master/${router.currentRoute.params.id}`).then(res => {
                if (typeof (res.data.data.purchaseData) === "object") {
                    this.formData = res.data.data.purchaseData
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
                minimumStockQuantity: 0,
                maximumStockQuantity: 0,
                minimumOrderQuantity: 0,
                maximumOrderQuantity: 0,
                leadTime: null,
                reorderQuality: null,
                class: 1,
                grnRequired: 1,
                materialProvidedBy: null,
                allowManualTransaction: 1,
                purchaseOfficer: null,
                toleranceMinus: 0,
                toleranceMinusValue: 0,
                tolerancePlus: 0,
                tolerancePlusValue: 0,
                isPurchaseData: true
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
                            title: 'Purchase Updated',
                            icon: 'CheckSquareIcon',
                            variant: 'success',
                            text: 'You have successfully Updated Purchase',
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
