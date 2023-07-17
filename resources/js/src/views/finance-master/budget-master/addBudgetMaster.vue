<template>
    <b-card-code>
        <validation-observer
            ref="validateRules"
            #default="{ handleSubmit }"
        >
            <b-form
                @submit.prevent="handleSubmit(submitFormData)"
                @reset.prevent="resetForm"
            >
                <b-row>
                    <b-col md="6">
                        <validation-provider
                            #default="validationContext"
                            name="Group Type"
                            rules="required"
                        >
                            <b-form-group
                                label="Select Group Type"
                                label-for="groupType"
                                :state="getValidationState(validationContext)"
                            >
                                <b-form-radio-group
                                    id="groupType"
                                    v-model="formData.groupType"
                                    :options="options"
                                    value-field="item"
                                    text-field="name"
                                    disabled-field="notEnabled"
                                    class="demo-inline-spacing"
                                    @change="changeAccountGroupOption($event)"
                                />
                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                    </b-col>
                    <b-col md="6">
                        <b-form-group
                            label="Account Group"
                            label-for="accountGroup"
                        >
                            <validation-provider
                                #default="validationContext"
                                name="Account Group"
                                rules="required"
                            >
                                <v-select
                                    id="accountGroup"
                                    v-model="formData.accountGroup"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="accountGroupOptions"
                                    label="label"
                                    value="value"
                                    :clearable="false"
                                    :state="getValidationState(validationContext)"
                                    v-on:input="showBudgetDetails($event)"
                                />
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </validation-provider>
                        </b-form-group>
                    </b-col>
                </b-row>
                <div v-if="isGroupSelected">
                    <hr>
                    <h4>Monthly Budget</h4>
                    <hr>
                    <b-row>
                        <hr>
                        <b-col md="4">
                            <b-form-group
                                label="January"
                                label-for="january"
                            >
                                <validation-provider
                                    #default="validationContext"
                                    name="January"
                                    rules=""
                                >
                                    <b-form-input
                                        type="number"
                                        id="january"
                                        v-model="formData.january"
                                        :state="getValidationState(validationContext)"
                                    />
                                    <b-form-invalid-feedback>
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </validation-provider>
                            </b-form-group>
                            <b-form-group
                                label="April"
                                label-for="april"
                            >
                                <validation-provider
                                    #default="validationContext"
                                    name="April"
                                    rules=""
                                >
                                    <b-form-input
                                        type="number"
                                        id="april"
                                        v-model="formData.april"
                                        :state="getValidationState(validationContext)"
                                    />
                                    <b-form-invalid-feedback>
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </validation-provider>
                            </b-form-group>
                            <b-form-group
                                label="July"
                                label-for="july"
                            >
                                <validation-provider
                                    #default="validationContext"
                                    name="July"
                                    rules=""
                                >
                                    <b-form-input
                                        type="number"
                                        id="july"
                                        v-model="formData.july"
                                        :state="getValidationState(validationContext)"
                                    />
                                    <b-form-invalid-feedback>
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </validation-provider>
                            </b-form-group>
                            <b-form-group
                                label="October"
                                label-for="october"
                            >
                                <validation-provider
                                    #default="validationContext"
                                    name="October"
                                    rules=""
                                >
                                    <b-form-input
                                        type="number"
                                        id="october"
                                        v-model="formData.october"
                                        :state="getValidationState(validationContext)"
                                    />
                                    <b-form-invalid-feedback>
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </validation-provider>
                            </b-form-group>


                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                label="February"
                                label-for="february"
                            >
                                <validation-provider
                                    #default="validationContext"
                                    name="February"
                                    rules=""
                                >
                                    <b-form-input
                                        type="number"
                                        id="february"
                                        v-model="formData.february"
                                        :state="getValidationState(validationContext)"
                                    />
                                    <b-form-invalid-feedback>
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </validation-provider>
                            </b-form-group>
                            <b-form-group
                                label="May"
                                label-for="may"
                            >
                                <validation-provider
                                    #default="validationContext"
                                    name="May"
                                    rules=""
                                >
                                    <b-form-input
                                        type="number"
                                        id="may"
                                        v-model="formData.may"
                                        :state="getValidationState(validationContext)"
                                    />
                                    <b-form-invalid-feedback>
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </validation-provider>
                            </b-form-group>
                            <b-form-group
                                label="August"
                                label-for="august"
                            >
                                <validation-provider
                                    #default="validationContext"
                                    name="August"
                                    rules=""
                                >
                                    <b-form-input
                                        type="number"
                                        id="august"
                                        v-model="formData.august"
                                        :state="getValidationState(validationContext)"
                                    />
                                    <b-form-invalid-feedback>
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </validation-provider>
                            </b-form-group>
                            <b-form-group
                                label="November"
                                label-for="november"
                            >
                                <validation-provider
                                    #default="validationContext"
                                    name="November"
                                    rules=""
                                >
                                    <b-form-input
                                        type="number"
                                        id="november"
                                        v-model="formData.november"
                                        :state="getValidationState(validationContext)"
                                    />
                                    <b-form-invalid-feedback>
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </validation-provider>
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                label="March"
                                label-for="march"
                            >
                                <validation-provider
                                    #default="validationContext"
                                    name="March"
                                    rules=""
                                >
                                    <b-form-input
                                        type="number"
                                        id="march"
                                        v-model="formData.march"
                                        :state="getValidationState(validationContext)"
                                    />
                                    <b-form-invalid-feedback>
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </validation-provider>
                            </b-form-group>
                            <b-form-group
                                label="June"
                                label-for="june"
                            >
                                <validation-provider
                                    #default="validationContext"
                                    name="June"
                                    rules=""
                                >
                                    <b-form-input
                                        type="number"
                                        id="june"
                                        v-model="formData.june"
                                        :state="getValidationState(validationContext)"
                                    />
                                    <b-form-invalid-feedback>
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </validation-provider>
                            </b-form-group>
                            <b-form-group
                                label="September"
                                label-for="september"
                            >
                                <validation-provider
                                    #default="validationContext"
                                    name="September"
                                    rules=""
                                >
                                    <b-form-input
                                        type="number"
                                        id="september"
                                        v-model="formData.september"
                                        :state="getValidationState(validationContext)"
                                    />
                                    <b-form-invalid-feedback>
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </validation-provider>
                            </b-form-group>
                            <b-form-group
                                label="December"
                                label-for="december"
                            >
                                <validation-provider
                                    #default="validationContext"
                                    name="December"
                                    rules=""
                                >
                                    <b-form-input
                                        type="number"
                                        id="december"
                                        v-model="formData.december"
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
                                label="Monthly Budget"
                                label-for="monthlyBudget"
                            >
                                <validation-provider
                                    #default="validationContext"
                                    name="Monthly Budget"
                                    rules=""
                                >
                                    <b-form-input
                                        type="number"
                                        id="monthlyBudget"
                                        v-model="formData.monthlyBudget"
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
                                label="Yearly Budget"
                                label-for="yearlyBudget"
                            >
                                <validation-provider
                                    #default="validationContext"
                                    name="Yearly Budget"
                                    rules=""
                                >
                                    <b-form-input
                                        type="number"
                                        id="yearlyBudget"
                                        v-model="formData.yearlyBudget"
                                        :state="getValidationState(validationContext)"
                                    />
                                    <b-form-invalid-feedback>
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </validation-provider>
                            </b-form-group>
                        </b-col>
                    </b-row>
                    <!-- Form Actions -->
                    <hr>
                    <div class="float-right">
                        <b-button
                            v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                            variant="primary"
                            class="mr-1"
                            type="submit"
                        >
                            Save
                        </b-button>
                        <b-button
                            v-ripple.400="'rgba(186, 191, 199, 0.15)'"
                            type="button"
                            variant="outline-secondary"
                        >
                            Cancel
                        </b-button>
                    </div>
                </div>
            </b-form>
        </validation-observer>
    </b-card-code>
</template>
<script>
    import BCardCode from '@core/components/b-card-code'
    import {ValidationProvider, ValidationObserver} from 'vee-validate'
    import {
        BRow, BCol, BFormGroup, BFormInput, BFormTextarea, BForm, BButton,BFormInvalidFeedback, BFormCheckboxGroup, BInputGroup,BFormRadioGroup
    } from 'bootstrap-vue'
    import {required} from '@validations'
    import formValidation from '@core/comp-functions/forms/form-validation'
    import Ripple from 'vue-ripple-directive'
    import vSelect from 'vue-select'
    import store from '@/store'
    import router from "@/router";
    import Toastification from '@core/components/toastification/ToastificationContent.vue'
    import {ref, onUnmounted} from '@vue/composition-api'
    import financeMasterStoreModule from "../financeMasterStoreModule"
    import { useToast } from 'vue-toastification/composition'

    export default {
        components: {
            BCardCode,
            ValidationProvider,
            ValidationObserver,
            BRow,
            BCol,
            BFormGroup,
            BFormInput,
            BFormTextarea,
            BForm,
            BButton,
            BFormInvalidFeedback,
            BFormCheckboxGroup,
            BInputGroup,
            BFormRadioGroup,
            vSelect
        },
        directives: {
            Ripple,
        },
        data(){
            return {
                options: [
                    { item: 0, name: 'Account Group' },
                    { item: 1, name: 'Account Master' },
                ],
                accountGroupOptions: [],
                isGroupSelected: false,
            }
        },
        setup() {
            const toast = useToast()

            const COACC_APP_STORE_MODULE_NAME = 'budget-master'
            if (!store.hasModule(COACC_APP_STORE_MODULE_NAME)) store.registerModule(COACC_APP_STORE_MODULE_NAME, financeMasterStoreModule)
            onUnmounted(() => {
                if (store.hasModule(COACC_APP_STORE_MODULE_NAME)) store.unregisterModule(COACC_APP_STORE_MODULE_NAME)
            })

            const blankFormData = {
                groupType : null,
                accountGroup : null,
                january : '',
                february : '',
                march : '',
                april : '',
                may : '',
                june : '',
                july : '',
                august : '',
                september : '',
                october : '',
                november : '',
                december : '',
                monthlyBudget : '',
                yearlyBudget : '',
            }

            const formData = ref(JSON.parse(JSON.stringify(blankFormData)))

            const resetGroupData = () => {
                formData.value = JSON.parse(JSON.stringify(blankFormData))
            }

            const submitFormData = () => {
                store.dispatch('budget-master/addBudgetMaster',formData.value).then(response => {
                    if (response.data.status === 200){
                        toast({
                            component: Toastification,
                            position: 'top-right',
                            props: {
                                title: 'Budget Master created',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: 'You have successfully Created Budget Master',
                            },
                        })
                    }

                    if (response.data.status === 400){
                        toast({
                            component: Toastification,
                            position: 'top-right',
                            props: {
                                title: 'Budget Master Already Exist',
                                icon: 'AlertCircleIcon',
                                variant: 'danger',
                                text: 'You have Already Created Budget Master',
                            },
                        })
                    }

                    router.push('/finance/finance-master/budget-master')
                })
            }

            const { refFormObserver, getValidationState, resetForm } = formValidation(resetGroupData)

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
            changeAccountGroupOption(type){
                this.formData.accountGroup = null
                this.accountGroupOptions = []
                this.isGroupSelected = false
                if (type === 0){
                    this.$http.get('/api/get-accounts-options').then(res => {
                        this.accountGroupOptions = res.data.data
                    })
                } else {
                    this.$http.get('/api/get-account-ledger-options').then(res => {
                        this.accountGroupOptions = res.data.data
                    })
                }
            },
            showBudgetDetails(){
                this.isGroupSelected = true
            },
        }
    }
</script>
