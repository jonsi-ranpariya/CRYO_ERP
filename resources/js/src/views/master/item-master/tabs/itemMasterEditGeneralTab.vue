<template>
    <div>
        <b-row>
            <b-col md="12">
                <hr>
                <h4>Store Details</h4>
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
                            label="Location"
                            label-for="location"
                        >
                            <validation-provider
                                #default="validationContext"
                                name="Location"
                                rules=""
                            >
                                <b-form-input
                                    id="location"
                                    v-model="formData.location"
                                    :state="getValidationState(validationContext)"
                                />
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </validation-provider>
                        </b-form-group>
                        <b-form-group
                            label="Bin Number"
                            label-for="binNumber"
                        >
                            <validation-provider
                                #default="validationContext"
                                name="Bin Number"
                                rules=""
                            >
                                <b-form-input
                                    id="binNumber"
                                    v-model="formData.binNumber"
                                    :state="getValidationState(validationContext)"
                                />
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </validation-provider>
                        </b-form-group>
                        <b-form-group
                            label="Weight"
                            label-for="weight"
                        >
                            <validation-provider
                                #default="validationContext"
                                name="Weight"
                                rules=""
                            >
                                <b-input-group append="Kg.">
                                    <b-form-input
                                        id="weight"
                                        type="number"
                                        v-model="formData.weight"
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
                            label="Self Life Days"
                            label-for="selfLifeDays"
                        >
                            <validation-provider
                                #default="validationContext"
                                name="Self Life Days"
                                rules=""
                            >
                                <b-form-group append="(0=Unlimited)">
                                    <b-form-input
                                        id="selfLifeDays"
                                        type="number"
                                        v-model="formData.selfLifeDays"
                                        :state="getValidationState(validationContext)"
                                    />
                                </b-form-group>

                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </validation-provider>
                        </b-form-group>
                        <b-form-group
                            label="Warranty Period (0=No Warranty)"
                            label-for="warrantyPeriod"
                        >
                            <validation-provider
                                #default="validationContext"
                                name="Month"
                                rules=""
                            >
                                <b-form-group append="Months">
                                    <b-form-input
                                        id="warrantyPeriod"
                                        type="number"
                                        v-model="formData.warrantyPeriod"
                                        :state="getValidationState(validationContext)"
                                    />
                                </b-form-group>

                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </validation-provider>
                        </b-form-group>
                    </b-col>
                    <b-col md="12">
                        <hr>
                        <h4>Quality Details</h4>
                        <hr>
                    </b-col>
                    <b-col md="6">
                        <b-form-group
                            label="Test Report Require"
                            label-for="testReportRequire"
                        >
                            <validation-provider
                                #default="validationContext"
                                name="Test Report Require"
                                rules=""
                            >
                                <v-select
                                    id="testReportRequire"
                                    v-model="formData.testReportRequire"
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
                    <b-col md="6"></b-col>
                    <b-col md="6">
                        <b-form-group
                            label="Module Number"
                            label-for="moduleNumber"
                        >
                            <validation-provider
                                #default="validationContext"
                                name="Module Number"
                                rules=""
                            >
                                <b-form-input
                                    id="moduleNumber"
                                    v-model="formData.moduleNumber"
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
import {ref, onUnmounted, onMounted} from '@vue/composition-api'
import formValidation from '@core/comp-functions/forms/form-validation'
import {ValidationProvider, ValidationObserver} from 'vee-validate'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
import {useToast} from 'vue-toastification/composition'
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
        }
    },
    beforeCreate() {
        this.$http.get(`/api/item-master/${router.currentRoute.params.id}`).then(res => {
            if (typeof (res.data.data.generalData) === "object") {
                this.formData = res.data.data.generalData
                this.formData.id = res.data.data._id
                delete this.formData._id
            }
        })
    },
    setup() {
        const toast = useToast()

        const APP_STORE_MODULE_NAME = 'master-add'
        onMounted(() => {
            if (!store.hasModule(APP_STORE_MODULE_NAME)) store.registerModule(APP_STORE_MODULE_NAME, masterStoreModule)
        });
        onUnmounted(() => {
            if (store.hasModule(APP_STORE_MODULE_NAME)) store.unregisterModule(APP_STORE_MODULE_NAME)
        });

        const blankFormData = {
            id: router.currentRoute.params.id,
            isGeneralData: true,
            location: null,
            binNumber: null,
            weight: null,
            selfLifeDays: null,
            warrantyPeriod: null,
            testReportRequire: null,
            moduleNumber: null,
        }

        const formData = ref(JSON.parse(JSON.stringify(blankFormData)));

        const resetGroupData = () => {
            formData.value = JSON.parse(JSON.stringify(blankFormData));
        }

        const submitFormData = async () => {
            await store.dispatch('master-add/updateItemMaster', formData.value).then(() => {
                toast({
                    component: ToastificationContent,
                    position: 'top-right',
                    props: {
                        title: 'General Updated',
                        icon: 'CheckSquareIcon',
                        variant: 'success',
                        text: 'You have successfully Updated General',
                    },
                });
            });
        }

        const {refFormObserver, getValidationState, resetForm} = formValidation(resetGroupData)

        return {
            required,
            max,
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
