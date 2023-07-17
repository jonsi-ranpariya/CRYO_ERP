<template>
    <b-card-code>
        <validation-observer ref="simpleRules">
            <b-form>

                <b-row>

                    <b-col md="12">
                        <b-form-group
                            label="Budget Validation On"
                            label-for="budgetValidationOn"
                        >
                            <validation-provider
                                #default="{ errors }"
                                name="Budget Validation On"
                                rules="required"
                            >
                                <v-select
                                    v-model="accountParamData.budgetValidationOn"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="BudgetValidationOption"
                                    :reduce="val => val.value"
                                    :clearable="false"
                                    input-id="budgetValidationOn"
                                    :state="errors.length > 0 ? false:null"
                                />
                                <small class="text-danger">{{ errors[0] }}</small>
                            </validation-provider>
                        </b-form-group>
                    </b-col>
                    <b-col md="12">
                        <b-form-group
                            label="If Budget Exceeded"
                            label-for="ifBudgetExceeded"
                        >
                            <validation-provider
                                #default="{ errors }"
                                name="If Budget Exceeded"
                                rules="required"
                            >
                                <v-select
                                    v-model="accountParamData.ifBudgetExceeded"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="BudgetExceedOption"
                                    :reduce="val => val.value"
                                    :clearable="false"
                                    input-id="ifBudgetExceeded"
                                    :state="errors.length > 0 ? false:null"
                                />
                                <small class="text-danger">{{ errors[0] }}</small>
                            </validation-provider>
                        </b-form-group>
                    </b-col>
                    <b-col md="12">
                        <b-form-group
                            label="Auto generate Forex Gain Loss...?"
                            label-for="autoForex"
                        >
                            <validation-provider
                                #default="{ errors }"
                                name="Auto generate Forex Gain Loss"
                                rules="required"
                            >
                                <v-select
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="AutoForexOption"
                                    :reduce="val => val.value"
                                    :clearable="false"
                                    v-model="accountParamData.autoForex"
                                    input-id="autoForex"
                                    :state="errors.length > 0 ? false:null"
                                />
                                <small class="text-danger">{{ errors[0] }}</small>
                            </validation-provider>
                        </b-form-group>
                    </b-col>

                </b-row>
                <b-row>
                    <!-- submit and reset -->
                    <b-col>
                        <b-button
                            v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                            type="submit"
                            variant="primary"
                            class="mr-1"
                            @click.prevent="validationForm"
                        >
                            Save Changes
                        </b-button>

                    </b-col>
                </b-row>
            </b-form>
        </validation-observer>
    </b-card-code>
</template>

<script>
    import BCardCode from '@core/components/b-card-code'
    import {ValidationProvider, ValidationObserver} from 'vee-validate'
    import {
        BRow, BCol, BFormGroup, BForm, BButton,
    } from 'bootstrap-vue'
    import {required} from '@validations'
    import Ripple from 'vue-ripple-directive'
    import vSelect from 'vue-select'
    import store from '@/store'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import {ref, onUnmounted} from '@vue/composition-api'
    import financeMasterStoreModule from '../financeMasterStoreModule'

    export default {
        components: {
            BCardCode,
            ValidationProvider,
            ValidationObserver,
            BRow,
            BCol,
            BFormGroup,
            BForm,
            BButton,
            vSelect
        },
        directives: {
            Ripple,
        },
        data() {

            const accountParamData = {
                id: null,
                settingKey: 'account_parameters',
                budgetValidationOn: 1,
                ifBudgetExceeded: 1,
                autoForex: 1,
            }

            const refetchData = () => {
                this.$http.get('/api/get-settings-by-key', {
                    params: {
                        setting_key: 'account_parameters'
                    }
                }).then(res => {
                    if (res.data.data) {
                        this.accountParamData = res.data.data
                        this.accountParamData.id = this.accountParamData._id
                        delete this.accountParamData._id
                    } else {
                        this.accountParamData = {
                            id: null,
                            settingKey: 'account_parameters',
                            budgetValidationOn: 1,
                            ifBudgetExceeded: 1,
                            autoForex: 1,
                        }
                    }
                })
            }

            return {
                accountParamData,
                refetchData,
                BudgetValidationOption: [{label: 'Month', value: 1}, {label: 'Total', value: 2}],
                BudgetExceedOption: [{label: 'Block Transaction', value: 1}, {
                    label: 'Allow Transaction With Warning',
                    value: 2
                }, {label: 'Allow Transaction', value: 3}],
                AutoForexOption: [{label: 'Yes', value: 1}, {label: 'No', value: 2}],
                required,

            }
        },
        setup() {

            const ACCPARAM_APP_STORE_MODULE_NAME = 'master-add'

            // Register module
            if (!store.hasModule(ACCPARAM_APP_STORE_MODULE_NAME)) store.registerModule(ACCPARAM_APP_STORE_MODULE_NAME, financeMasterStoreModule)

            // UnRegister on leave
            onUnmounted(() => {
                if (store.hasModule(ACCPARAM_APP_STORE_MODULE_NAME)) store.unregisterModule(ACCPARAM_APP_STORE_MODULE_NAME)
            })
        },
        created() {
            this.refetchData()
        },
        methods: {
            validationForm() {
                this.$refs.simpleRules.validate().then(success => {
                    if (success) {
                        store.dispatch('master-add/AddUpdateAccountParamMaster', this.accountParamData).then(response => {
                            if (response.status === 200) {
                                this.refetchData()
                                this.$toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: 'Party Created',
                                        icon: 'CheckSquareIcon',
                                        variant: 'success',
                                        text: `You have successfully Save Parameters.`,
                                    },
                                })
                            }

                        })
                    }
                })
            },

        },
    }
</script>
