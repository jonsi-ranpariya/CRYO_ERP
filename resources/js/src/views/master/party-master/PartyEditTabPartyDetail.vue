<template>
    <div>
        <hr>
        <validation-observer
            ref="validateRules"
            #default="{ handleSubmit }"
        >
            <!-- User Info: Input Fields -->
            <b-form @submit.prevent="handleSubmit(submitFormData)">
            <b-row>
                <b-col cols="6" class="party_detail_div">
                    <h6>Party Details</h6>
                    <b-form-group
                        label="Party Address"
                        label-for="party-address"
                    >
                        <validation-provider
                            #default="validationContext"
                            name="Party Address"
                            rules=""
                        >
                            <b-form-textarea
                                id="party-address"
                                placeholder="Party Address"
                                rows="2"
                                v-model="formData.partyAddress"
                                :state="getValidationState(validationContext)"
                            />
                            <b-form-invalid-feedback>
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </validation-provider>
                    </b-form-group>
                    <b-form-group
                        label="Area"
                        label-for="party-area"
                    >
                        <validation-provider
                            #default="validationContext"
                            name="Are"
                            rules=""
                        >
                            <b-form-input
                                id="party-are"
                                placeholder="Party Area"
                                v-model="formData.partyArea"
                                :state="getValidationState(validationContext)"
                            />
                            <b-form-invalid-feedback>
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </validation-provider>
                    </b-form-group>
                    <b-form-group
                        label="District‌"
                        label-for="party-city"
                    >
                        <validation-provider
                            #default="validationContext"
                            name="District‌"
                            rules=""
                        >
                            <v-select
                                placeholder="Select District‌"
                                v-model="formData.partyCity"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="cityOptions"
                                :clearable="false"
                                input-id="party-city"
                                :state="getValidationState(validationContext)"
                                @input="getCityDetails($event)"
                            />
                            <b-form-invalid-feedback>
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </validation-provider>
                    </b-form-group>
                    <validation-provider
                        #default="validationContext"
                        name="State"
                        rules=""
                    >
                        <b-form-group
                            label="State"
                            label-for="party-state"
                            :state="getValidationState(validationContext)"
                        >
                            <v-select
                                placeholder="Select State"
                                v-model="formData.partyState"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="stateOptions"
                                :clearable="false"
                                input-id="party-state"
                            />
                            <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </validation-provider>
                    <validation-provider
                        #default="validationContext"
                        name="Country"
                        rules=""
                    >
                        <b-form-group
                            label="Country"
                            label-for="party-country"
                            :state="getValidationState(validationContext)"
                        >
                            <v-select
                                placeholder="Select Country"
                                v-model="formData.partyCountry"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="countryOptions"
                                :clearable="false"
                                input-id="party-country"
                            />
                            <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </validation-provider>

                    <b-form-group
                        label="Pin-Code"
                        label-for="party-pincode"
                    >
                        <validation-provider
                            #default="validationContext"
                            name="Pin-Code"
                            rules="numeric"
                        >
                            <b-form-input
                                id="party-pincode"
                                placeholder="Party Pin Code"
                                type="number"
                                v-model="formData.partyPinCode"
                                :state="getValidationState(validationContext)"
                            />
                            <b-form-invalid-feedback>
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </validation-provider>
                    </b-form-group>
                    <b-form-group
                        label="Phone No."
                        label-for="party-phone"
                    >
                        <validation-provider
                            #default="validationContext"
                            name="Phone No."
                            rules=""
                        >
                            <b-input-group>
                                <b-input-group-prepend>
                                    <b-form-input
                                        id="stdCode"
                                        placeholder="STD code"
                                        type="number"
                                        v-model="formData.partyCountryCode"
                                        :state="getValidationState(validationContext)"
                                    />
                                </b-input-group-prepend>
                                <b-form-input
                                    id="party-phone"
                                    placeholder="Party Phone"
                                    v-model="formData.partyPhoneNo"
                                    :state="getValidationState(validationContext)"
                                />
                            </b-input-group>
                            <b-form-invalid-feedback>
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </validation-provider>
                    </b-form-group>
                    <b-form-group
                        label="Fax No."
                        label-for="party-fax"
                    >
                        <validation-provider
                            #default="validationContext"
                            name="Fax No."
                            rules="numeric"
                        >
                            <b-form-input
                                id="party-fax"
                                placeholder="Party Fax"
                                type="number"
                                v-model="formData.partyFaxNo"
                                :state="getValidationState(validationContext)"
                            />
                            <b-form-invalid-feedback>
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </validation-provider>
                    </b-form-group>
                    <b-form-group
                        label="Email ID"
                        label-for="party-email"
                    >
                        <validation-provider
                            #default="validationContext"
                            name="Email ID"
                            rules="email"
                        >
                            <b-form-input
                                id="party-email"
                                placeholder="Party Email"
                                type="email"
                                v-model="formData.partyEmilId"
                                :state="getValidationState(validationContext)"
                            />
                            <b-form-invalid-feedback>
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </validation-provider>
                    </b-form-group>
                    <b-form-group
                        label="Website"
                        label-for="party-website"
                    >
                        <validation-provider
                            #default="validationContext"
                            name="Website"
                            rules=""
                        >
                            <b-form-input
                                id="party-website"
                                placeholder="Party Website"
                                v-model="formData.partyWebsite"
                                :state="getValidationState(validationContext)"
                            />
                            <b-form-invalid-feedback>
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </validation-provider>
                    </b-form-group>
                </b-col>
                <b-col cols="6" class="party_detail_div">
                    <h6>GetParty Details</h6>
                    <b-row>
                        <b-col md="6">
                            <b-row>
                                <b-col cols="12">
                                    <b-form-group>
                                        <b-form-checkbox
                                            id="from-quotation"
                                            v-model="formData.fromQuotation"
                                            value="1"
                                        >
                                            From Sales Quotation
                                        </b-form-checkbox>
                                    </b-form-group>
                                </b-col>
                                <b-col cols="12">
                                    <b-form-group>
                                        <b-form-checkbox
                                            id="from-sales-support"
                                            v-model="formData.fromSalesSupport"
                                            value="2"
                                        >
                                            From Purchase Quotation
                                        </b-form-checkbox>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                        </b-col>

                        <b-col md="6">
                            <b-button
                                v-ripple.400="'rgba(113, 102, 240, 0.15)'"
                                variant="outline-primary"
                            >
                                Get Party Detail
                            </b-button>
                        </b-col>
                    </b-row>
                    <hr>
                    <h6>Account Details</h6>
                    <b-form-group
                        label="Group Code"
                        label-for="party-group-code"
                    >
                        <validation-provider
                            #default="validationContext"
                            name="Group Code"
                            rules=""
                        >
                            <v-select
                                v-model="formData.partyGroupCode"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="groupCodeOption"
                                label="code"
                                :clearable="false"
                                :state="getValidationState(validationContext)"
                                v-on:input="getPartyGroupName(formData.partyGroupCode)"
                                input-id="party-group-code"
                            />
                            <b-form-invalid-feedback>
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </validation-provider>
                    </b-form-group>
                    <b-form-group
                        label="Group Name"
                        label-for="party-group-name"
                    >
                        <validation-provider
                            #default="validationContext"
                            name="Group Name"
                            rules=""
                        >
                            <b-form-input
                                id="party-group-name"
                                placeholder="Group Name"
                                v-model="formData.partyGroupName"
                                :state="getValidationState(validationContext)"
                            />
                            <b-form-invalid-feedback>
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </validation-provider>
                    </b-form-group>
                    <b-form-group
                        label="Is TDS Applicable"
                        label-for="is-tds-applicable"
                    >
                        <validation-provider
                            #default="validationContext"
                            name="Is TDS Applicable"
                            rules=""
                        >
                            <v-select
                                v-model="formData.partyTdsApplicable"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="TdsOption"
                                :reduce="val => val.value"
                                :clearable="false"
                                v-on:input="isShowTDSFields(formData.partyTdsApplicable)"
                                :state="getValidationState(validationContext)"
                                input-id="is-tds-applicable"
                            />
                            <b-form-invalid-feedback>
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </validation-provider>
                    </b-form-group>
                    <div v-if="isTDSFields">
                        <b-form-group
                            label="GL TDS A/c"
                            label-for="party-gl-tds-acc"
                        >
                            <validation-provider
                                #default="validationContext"
                                name="GL TDS A/c"
                                rules=""
                            >
                                <v-select
                                    v-model="formData.partyGlTdsAC"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="glOptions"
                                    :clearable="false"
                                    v-on:input="getGlName(formData.partyGlTdsAC)"
                                    :state="getValidationState(validationContext)"
                                    input-id="party-gl-tds-acc"
                                />
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </validation-provider>
                        </b-form-group>
                        <b-form-group
                            label="GL TDS A/c Name"
                            label-for="party-gl-tds-acc-name"
                        >
                            <validation-provider
                                #default="validationContext"
                                name="GL TDS A/c Name"
                                rules=""
                            >
                                <b-form-input
                                    id="party-gl-tds-acc-name"
                                    placeholder="GL TDS A/c Name"
                                    v-model="formData.partyGlTdsACName"
                                    :state="getValidationState(validationContext)"
                                />
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </validation-provider>
                        </b-form-group>
                        <validation-provider
                            #default="validationContext"
                            name="TDS Payment Type"
                            rules=""
                        >
                            <b-form-group
                                label="TDS Payment Type"
                                label-for="party-tds-payment-type"
                                :state="getValidationState(validationContext)"
                            >
                                <v-select
                                    v-model="formData.partyTdsPaymentType"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="groupCodeOption"
                                    :clearable="false"
                                    v-on:input="getPaymentPercent(formData.partyTdsPaymentType)"
                                    input-id="party-tds-payment-type"
                                />
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                        <b-form-group
                            label="TDS %"
                            label-for="party-tds-percentage"
                        >
                            <validation-provider
                                #default="validationContext"
                                name="TDS"
                                rules="numeric"
                            >
                                <b-input-group append="%">
                                    <b-form-input
                                        id="party-tds-percentage"
                                        placeholder="TDS"
                                        type="number"
                                        v-model="formData.partyTdsPercentage"
                                        :state="getValidationState(validationContext)"
                                    />
                                </b-input-group>
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </validation-provider>
                        </b-form-group>
                    </div>
                </b-col>
            </b-row>
                <!-- Action Buttons -->
                <hr>
                <b-button
                    variant="primary"
                    class="mb-1 mb-sm-0 mr-0 mr-sm-1 float-right"
                    :block="$store.getters['app/currentBreakPoint'] === 'xs'"
                    type="submit"
                >
                    Save
                </b-button>
            </b-form>
        </validation-observer>
    </div>
</template>

<script>
    import {
        BButton,
        BRow,
        BCol,
        BFormGroup,
        BFormInput,
        BForm,
        BTable,
        BCard,
        BCardHeader,
        BCardTitle,
        BFormCheckbox,
        BFormTextarea,
        BFormInvalidFeedback,
        BInputGroup,
        BInputGroupPrepend
    } from 'bootstrap-vue'
    import Ripple from 'vue-ripple-directive'
    import vSelect from 'vue-select'
    import router from '@/router'
    import store from '@/store'
    import { useToast } from 'vue-toastification/composition'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import formValidation from '@core/comp-functions/forms/form-validation'
    import {required, numeric, email} from '@validations'
    import {ref, onUnmounted} from '@vue/composition-api'
    import {ValidationProvider, ValidationObserver, validate} from 'vee-validate'
    import partyStoreModule from '../partyStoreModule'
    import countryCode from '@/@fake-db/data/other/country-code'

    export default {
        components: {
            BButton,
            BRow,
            BCol,
            BFormGroup,
            BFormInput,
            BForm,
            BTable,
            BCard,
            BCardHeader,
            BCardTitle,
            BFormCheckbox,
            BFormTextarea,
            BFormInvalidFeedback,
            BInputGroup,
            BInputGroupPrepend,
            vSelect,
            ValidationProvider,
            ValidationObserver,
        },
        directives: {
            Ripple,
        },
        props: {
            partyData: {
                type: Object,
                required: true,
            },
        },
        computed: {
            countryCode: () => countryCode
        },
        data(){
            return {
                countryOptions: [],
                stateOptions: [],
                cityOptions: [],
                groupCodeOption: [],
                glOptions: [],

                TdsOption : [
                    {label: 'Yes', value: 1},
                    {label: 'No', value: 0}
                ],
                AccountGroupList: [
                    {label: 'Yes', value: 1},
                    {label: 'No', value: 0}
                ],
                isTDSFields : false,
            }
        },
        setup() {
            const toast = useToast()

            const APP_STORE_MODULE_NAME = 'master-add'
            if (!store.hasModule(APP_STORE_MODULE_NAME)) store.registerModule(APP_STORE_MODULE_NAME, partyStoreModule)
            onUnmounted(() => {
                if (store.hasModule(APP_STORE_MODULE_NAME)) store.unregisterModule(APP_STORE_MODULE_NAME)
            })

            const partyDetailFormData = {
                id: router.currentRoute.params.id,
                nsicNo: null,
                lwfNo: null,
                partyAddress: null,
                partyCity: null,
                partyArea: null,
                partyPinCode: null,
                partyState: null,
                partyCountry: null,
                partyCountryCode: '+91',
                partyPhoneNo: null,
                partyFaxNo: null,
                partyEmilId: null,
                partyWebsite: null,
                partyGroupName: null,
                partyTdsApplicable: null,
                partyGlTdsAC: [],
                partyTdsPaymentType: [],
                partyTdsPercentage: null,
                fromQuotation: 0,
                fromSalesSupport: 0,
                partyGroupCode: null,
                partyGlTdsACName: null,
                isPartyDetails: true
            }

            const formData = ref(JSON.parse(JSON.stringify(partyDetailFormData)))

            const resetGroupData = () => {
                formData.value = JSON.parse(JSON.stringify(partyDetailFormData))
            }

            const submitFormData = async () => {
                await store.dispatch('master-add/editPartyMaster',formData.value).then(res => {
                    toast({
                        component: ToastificationContent,
                        position: 'top-right',
                        props: {
                            title: 'General Updated',
                            icon: 'CheckSquareIcon',
                            variant: 'success',
                            text: 'You have successfully Updated General',
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
        created() {
            this.$http.get('/api/get-country-options').then(res => {
                this.countryOptions = res.data.data
            })

            this.$http.get('/api/get-state-options').then(res => {
                this.stateOptions = res.data.data
            })

            this.$http.get('/api/get-city-options').then(res => {
                this.cityOptions = res.data.data
            })

            this.$http.get('/api/get-tds-options').then(res => {
                this.groupCodeOption = res.data.data
            })

            this.$http.get('/api/get-account-ledger-options').then(res => {
                this.glOptions = res.data.data
            })

            this.$http.get(`/api/party/edit/${router.currentRoute.params.id}`).then(res => {
                if (typeof (res.data.data.partyDetails) === "object") {
                    this.formData = res.data.data.partyDetails
                    this.isTDSFields = res.data.data.partyDetails.partyTdsApplicable === 1
                }
            })
        },
        methods: {
            isShowTDSFields(val){
                if (val === 1){
                    this.isTDSFields = true
                }else{
                    this.isTDSFields = false
                    this.formData.partyGlTdsAC = null
                    this.formData.partyGlTdsACName = null
                    this.formData.partyTdsPaymentType = null
                    this.formData.partyTdsPercentage = null
                }
            },
            getPartyGroupName(val){
                this.formData.partyGroupName = val.label
            },
            getGlName(val){
                this.formData.partyGlTdsACName = val.label
            },
            getPaymentPercent(val){
                this.formData.partyTdsPercentage = val.percentage
            },

            getCityDetails(city){
                this.$http.get(`/api/city-master/${city.value}`).then((res) => {
                    this.formData.partyState = res.data.data.state_detail
                    this.formData.partyCountry = res.data.data.country_detail
                });
            }
        },
    }
</script>

<style lang="scss">
    @import '~@core/scss/vue/libs/vue-select.scss';
</style>
