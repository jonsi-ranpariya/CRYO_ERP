<template>
    <div>
        <b-row>

            <b-col md="12">
                <hr>
                <h6>Party Work Address Details</h6>

                <hr>
            </b-col>

        </b-row>
        <!-- User Info: Input Fields -->
        <b-form @submit.prevent="submitFormData">
            <b-row>
                <b-col md="12">
                    <b-button
                        variant="primary"
                        class="mb-1 mb-sm-0 mr-0 mr-sm-1 float-right"
                        :block="$store.getters['app/currentBreakPoint'] === 'xs'"
                        @click="sameAsPartyData"
                    >
                        Same As Party Details
                    </b-button>
                </b-col>
                <b-col md="12">
                    <b-form-group
                        label="Party Address"
                        label-for="party-work-address"
                    >
                        <b-form-textarea
                            id="party-work-address"
                            placeholder="Party Address"
                            rows="2"
                            v-model="formData.partyAddress"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="6">
                    <b-form-group
                        label="Area"
                        label-for="party-work-area"
                    >
                        <b-form-input
                            id="party-work-area"
                            placeholder="Party Area"
                            v-model="formData.partyArea"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="6">
                    <b-form-group
                        label="District‌"
                        label-for="party-work-city"
                    >
                        <v-select
                            placeholder="Select District‌"
                            v-model="formData.partyCity"
                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                            :options="cityOptions"
                            :reduce="val => val.value"
                            :clearable="false"
                            input-id="party-city"
                            @input="getCityDetails($event)"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="4">
                    <b-form-group
                        label="State"
                        label-for="party-work-state"
                    >
                        <v-select
                            placeholder="Select State"
                            v-model="formData.partyState"
                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                            :options="stateOptions"
                            :reduce="val => val.value"
                            :clearable="false"
                            input-id="party-state"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="4">
                    <b-form-group
                        label="Country"
                        label-for="party-work-country"
                    >
                        <v-select
                            placeholder="Select Country"
                            v-model="formData.partyCountry"
                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                            :options="countryOptions"
                            :reduce="val => val.value"
                            :clearable="false"
                            input-id="party-country"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="4">
                    <b-form-group
                        label="Pin-Code"
                        label-for="party-work-pincode"
                    >
                        <b-form-input
                            id="party-work-pincode"
                            placeholder="Party Pin Code"
                            v-model="formData.partyPinCode"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="12">
                    <b-form-group
                        label="Phone No."
                        label-for="party-work-phone"
                    >
                        <b-input-group>
                            <b-input-group-prepend>
                                <!--<v-select
                                    placeholder="Select Country"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="countryCode"
                                    :get-option-label="option => `${option.name} (${option.dial_code}) `"
                                    :clearable="false"
                                    :reduce="val => val.dial_code"
                                    v-model="formData.partyPhoneNoCode"
                                    input-id="customerCountryCode"
                                />-->
                                <b-form-input
                                    id="stdCode"
                                    placeholder="STD code"
                                    type="number"
                                    v-model="formData.partyPhoneNoCode"
                                />
                            </b-input-group-prepend>
                            <b-form-input
                                id="party-work-phone"
                                placeholder="Party Phone"
                                v-model="formData.partyPhoneNo"
                            />
                        </b-input-group>
                    </b-form-group>
                </b-col>
                <b-col md="4">
                    <b-form-group
                        label="Fax No."
                        label-for="party-work-fax"
                    >
                        <b-form-input
                            id="party-work-fax"
                            placeholder="Party Fax"
                            v-model="formData.partyFaxNo"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="4">
                    <b-form-group
                        label="Email ID"
                        label-for="party-work-email"
                    >
                        <b-form-input
                            id="party-work-email"
                            placeholder="Party Email"
                            v-model="formData.partyEmilId"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="4">
                    <b-form-group
                        label="Website"
                        label-for="party-work-website"
                    >
                        <b-form-input
                            id="party-work-website"
                            placeholder="Party Website"
                            v-model="formData.partyWebsite"
                        />
                    </b-form-group>
                </b-col>
            </b-row>
            <hr>
            <!-- Action Buttons -->
            <b-button
                variant="primary"
                class="mb-1 mb-sm-0 mr-0 mr-sm-1 float-right"
                :block="$store.getters['app/currentBreakPoint'] === 'xs'"
                type="submit"
            >
                Save Changes
            </b-button>

        </b-form>
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
        BInputGroup,
        BInputGroupPrepend
    } from 'bootstrap-vue'
    import Ripple from 'vue-ripple-directive'
    import vSelect from 'vue-select'
    import router from '@/router'
    import store from '@/store'
    import {ref, onUnmounted} from '@vue/composition-api'
    import {useToast} from 'vue-toastification/composition'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import formValidation from '@core/comp-functions/forms/form-validation'
    import {required, numeric, email} from '@validations'
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
        data() {
            return {
                partyDetails: {},
                countryOptions: [],
                stateOptions: [],
                cityOptions: [],
            }
        },
        created() {
            this.$http.get(`/api/party/edit/${router.currentRoute.params.id}`).then(res => {
                if (typeof (res.data.data.partyDetails) === "object") {
                    this.partyDetails = res.data.data.partyDetails
                }
                if (typeof (res.data.data.partyAddress) === "object") {
                    this.formData = res.data.data.partyAddress
                }
            })

            this.$http.get('/api/get-country-options').then(res => {
                this.countryOptions = res.data.data
            })

            this.$http.get('/api/get-state-options').then(res => {
                this.stateOptions = res.data.data
            })

            this.$http.get('/api/get-city-options').then(res => {
                this.cityOptions = res.data.data
            })
        },
        setup() {
            const APP_STORE_MODULE_NAME = 'master-add'
            if (!store.hasModule(APP_STORE_MODULE_NAME)) store.registerModule(APP_STORE_MODULE_NAME, partyStoreModule)
            onUnmounted(() => {
                if (store.hasModule(APP_STORE_MODULE_NAME)) store.unregisterModule(APP_STORE_MODULE_NAME)
            })

            const partyFormData = {
                id: router.currentRoute.params.id,
                isPartyAddress: true,
                partyAddress: null,
                partyCountry: null,
                partyState: null,
                partyCity: null,
                partyArea: null,
                partyPinCode: null,
                partyPhoneNoCode: '+91',
                partyPhoneNo: null,
                partyFaxNo: null,
                partyEmilId: null,
                partyWebsite: null,
            }

            const formData = ref(JSON.parse(JSON.stringify(partyFormData)))

            const resetGroupData = () => {
                formData.value = JSON.parse(JSON.stringify(partyFormData))
            }

            const {refFormObserver, getValidationState, resetForm} = formValidation(resetGroupData)

            return {
                formData,

                refFormObserver,
                getValidationState,
                resetForm,
                resetGroupData,
            }
        },
        methods: {
            async getCityDetails(id) {
                await this.$http.get(`/api/city-master/${id}`).then((res) => {
                    this.formData.partyState = res.data.data.state
                    this.formData.partyCountry = res.data.data.country
                });
            },

            async sameAsPartyData() {
                await this.$http.get(`/api/party/edit/${router.currentRoute.params.id}`).then(res => {
                    if (typeof (res.data.data.partyDetails) === "object") {
                        this.partyDetails = res.data.data.partyDetails
                    }
                    if (typeof (res.data.data.partyAddress) === "object") {
                        this.formData = res.data.data.partyAddress
                    }
                });
                if (Object.keys(this.partyDetails).length > 0) {
                    this.formData.partyAddress = this.partyDetails.partyAddress
                    this.formData.partyCountry = this.partyDetails.partyCountry
                    this.formData.partyState = this.partyDetails.partyState
                    this.formData.partyCity = this.partyDetails.partyCity
                    this.formData.partyArea = this.partyDetails.partyArea
                    this.formData.partyPinCode = this.partyDetails.partyPinCode
                    this.formData.partyPhoneNo = this.partyDetails.partyPhoneNo
                    this.formData.partyFaxNo = this.partyDetails.partyFaxNo
                    this.formData.partyEmilId = this.partyDetails.partyEmilId
                    this.formData.partyWebsite = this.partyDetails.partyWebsite
                    this.formData.partyPhoneNoCode = this.partyDetails.partyCountryCode
                } else {
                    this.$toast({
                        component: ToastificationContent,
                        position: 'top-right',
                        props: {
                            title: 'Please Fill Party Details',
                            icon: 'AlertCircleIcon',
                            variant: 'warning',
                            text: `No data available please fill party details`,
                        },
                    })
                }
            },
            submitFormData() {
                this.$store.dispatch('master-add/editPartyMaster', this.formData).then(res => {
                    this.$toast({
                        component: ToastificationContent,
                        position: 'top-right',
                        props: {
                            title: 'Party Address Updated',
                            icon: 'CheckSquareIcon',
                            variant: 'success',
                            text: 'You have successfully Updated Party Address',
                        },
                    })
                })
            }
        }
    }
</script>

<style lang="scss">
    @import '~@core/scss/vue/libs/vue-select.scss';
</style>
