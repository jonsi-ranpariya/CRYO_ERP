<template>
    <b-card-code>
        <validation-observer ref="simpleRules">
            <b-form>
                <b-row>
                    <b-col md="8">
                        <b-form-group
                            label="Description"
                            label-for="description"
                        >
                            <validation-provider
                                #default="{ errors }"
                                name="Description"
                                rules="required"
                            >
                                <b-form-input
                                    id="description"
                                    v-model="partyFormData.description"
                                    placeholder="Description"
                                    :state="errors.length > 0 ? false:null"
                                />
                                <small class="text-danger">{{ errors[0] }}</small>
                            </validation-provider>
                        </b-form-group>
                    </b-col>

                    <b-col md="4">
                        <b-form-group
                            label="Prefix"
                            label-for="prefix"
                        >
                            <validation-provider
                                #default="{ errors }"
                                name="Prefix"
                                rules="required"
                            >
                                <b-form-input
                                    id="prefix"
                                    v-model="partyFormData.prefix"
                                    placeholder="Prefix"
                                    :state="errors.length > 0 ? false:null"
                                    readonly
                                />
                                <small class="text-danger">{{ errors[0] }}</small>
                            </validation-provider>
                        </b-form-group>
                    </b-col>

                    <b-col md="4">
                        <b-form-group
                            label="Current No"
                            label-for="currentNo"
                        >
                            <validation-provider
                                #default="{ errors }"
                                name="Current No"
                                rules="required"
                            >
                                <b-form-input
                                    id="currentNo"
                                    v-model="partyFormData.currentNo"
                                    type="number"
                                    placeholder="Current No"
                                    @keyup="generateCode()"
                                    :state="errors.length > 0 ? false:null"
                                />
                                <small class="text-danger">{{ errors[0] }}</small>
                            </validation-provider>
                        </b-form-group>
                    </b-col>

                    <b-col md="4">
                        <b-form-group
                            label="Financial Year"
                            label-for="financialYearAs"
                        >
                            <validation-provider
                                #default="{ errors }"
                                name="Financial Year"
                                rules="required"
                            >
                                <v-select
                                    v-model="partyFormData.financialYearAs"
                                    placeholder="Select Financial Year"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="FinancialYears"
                                    :reduce="val => val.value"
                                    :clearable="false"
                                    input-id="financialYearAs"
                                    :state="errors.length > 0 ? false:null"
                                    disabled
                                />
                                <small class="text-danger">{{ errors[0] }}</small>
                            </validation-provider>
                        </b-form-group>
                    </b-col>

                    <b-col md="4">
                        <b-form-group
                            label="Separator"
                            label-for="separator"
                        >
                            <validation-provider
                                #default="{ errors }"
                                name="Separator"
                                rules="required"
                            >
                                <b-form-input
                                    id="separator"
                                    v-model="partyFormData.separator"
                                    placeholder="Separator"
                                    :state="errors.length > 0 ? false:null"
                                    readonly
                                />
                                <small class="text-danger">{{ errors[0] }}</small>
                            </validation-provider>
                        </b-form-group>
                    </b-col>

                    <b-col md="6">
                        <b-form-group
                            label="Sample No"
                            label-for="sampleNo"
                        >
                            <validation-provider
                                #default="{ errors }"
                                name="Sample NO"
                                rules="required"
                            >
                                <b-form-input
                                    id="sampleNo"
                                    v-model="partyFormData.sampleNo"
                                    placeholder="Separator"
                                    :state="errors.length > 0 ? false:null"
                                    readonly
                                />
                                <small class="text-danger">{{ errors[0] }}</small>
                            </validation-provider>
                        </b-form-group>
                    </b-col>

                    <b-col md="4">
                        <b-button
                            v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                            variant="primary"
                            class="mt-2"
                            @click="generateCode()"
                        >
                            <feather-icon
                                icon="CodesandboxIcon"
                                size="16"
                                class="mr-0"
                            />
                            Generate Sample Code
                        </b-button>
                    </b-col>

                </b-row>
                <b-row>
                    <!-- submit and reset -->
                    <b-col>
                        <b-button
                            v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                            type="submit"
                            variant="primary"
                            class="mr-1 float-right"
                            @click.prevent="validationForm"
                        >
                            Edit Invoice Type Master
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
        BRow, BCol, BFormGroup, BFormInput, BFormTextarea, BForm, BButton, BTab, BTabs,
    } from 'bootstrap-vue'
    import {required} from '@validations'
    import Ripple from 'vue-ripple-directive'
    import vSelect from 'vue-select'
    import {ref, onUnmounted} from '@vue/composition-api'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import router from '@/router'
    import store from '@/store'
    import masterStoreModule from '../masterStoreModule'

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
            BTab,
            BTabs,
            vSelect,
        },
        directives: {
            Ripple,
        },
        methods: {

            validationForm() {
                this.$refs.simpleRules.validate().then(success => {
                    if (success) {

                        store.dispatch('inv-type-module/UpdateInvoiceTypeMaster', this.partyFormData).then(response => {

                            //console.log(response);

                            if (response.status = 200) {

                                this.$router.push({name: 'invoice-type-master'})

                                this.$toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: 'Invoice Type Edited',
                                        icon: 'CheckSquareIcon',
                                        variant: 'success',
                                        text: `You have successfully Edited Type ${this.partyFormData.description}.`,
                                    },
                                })
                            }

                        })


                    }
                })
            },
        },
        setup() {

            const INTYPE_APP_STORE_MODULE_NAME = 'inv-type-module'

            // Register module
            if (!store.hasModule(INTYPE_APP_STORE_MODULE_NAME)) store.registerModule(INTYPE_APP_STORE_MODULE_NAME, masterStoreModule)

            // UnRegister on leave
            onUnmounted(() => {
                if (store.hasModule(INTYPE_APP_STORE_MODULE_NAME)) store.unregisterModule(INTYPE_APP_STORE_MODULE_NAME)
            })

            const FinancialYears = ref([
                {label: 'As a Prefix', value: 1},
                {label: 'As a Suffix', value: 2},
                {label: 'Note Applicable', value: 3},
            ])

            const partyFormData = ref({
                id: null,
                description: null,
                prefix: '',
                currentNo: '0001',
                financialYearAs: 2,
                separator: '/',
                sampleNo: null,
            })

            store.dispatch('inv-type-module/fetchInvoiceTypeDetail', {id: router.currentRoute.params.id})
                .then(response => {
                    //console.log(response.data)
                    partyFormData.value = response.data.data
                    partyFormData.value.id = response.data.data._id
                    delete partyFormData.value._id

                })
                .catch(error => {
                    if (error.response.status === 404) {
                        partyFormData.value = {
                            id: router.currentRoute.params.id,
                            description: null,
                            prefix: '',
                            currentNo: '0001',
                            financialYearAs: 2,
                            separator: '/',
                            sampleNo: null,
                        }
                    }
                })

            const generateCode = () => {

                let sampleNo = ''

                let currentFinancialYear = '22-23'

                if (partyFormData.value.financialYearAs == 1) {

                    sampleNo = partyFormData.value.prefix + partyFormData.value.separator + currentFinancialYear + partyFormData.value.separator + partyFormData.value.currentNo

                } else if (partyFormData.value.financialYearAs == 2) {

                    sampleNo = partyFormData.value.prefix + partyFormData.value.currentNo + partyFormData.value.separator + currentFinancialYear

                } else {

                    sampleNo = partyFormData.value.prefix + partyFormData.value.currentNo

                }

                partyFormData.value.sampleNo = sampleNo

                /*if (partyFormData.value.prefix && partyFormData.value.currentNo && partyFormData.value.financialYearAs && partyFormData.value.separator) {



                } else {

                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Please Enter Prefix And Current No and Financial Year And Separator To Generate Sample No',
                    })
                }*/

            }

            return {
                FinancialYears,
                partyFormData,
                generateCode,
                required,
            }
        },
    }
</script>
<style lang="scss">
    @import '~@core/scss/vue/libs/vue-sweetalert.scss';
</style>
