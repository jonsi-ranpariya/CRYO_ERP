<template>
    <div>
        <validation-observer #default="{ handleSubmit }">
            <b-form @submit.prevent="handleSubmit(saveFormData)">
                <b-row>
                    <b-col md="6">
                        <validation-provider
                            #default="validationContext"
                            name="Vendor Code"
                            rules="required"
                        >
                            <b-form-group
                                label="Party Code"
                                label-for="partyCode"
                            >
                                <v-select
                                    placeholder="Select Code"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="partyCodeOption"
                                    :reduce="val => val.value"
                                    :clearable="false"
                                    input-id="partyCode"
                                    @input="getPartyDetails($event)"
                                    v-model="formData.partyCode"
                                    :state="getValidationState(validationContext)"
                                />
                            </b-form-group>
                            <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </validation-provider>
                        <validation-provider
                            #default="validationContext"
                            name="Vendor Code"
                            rules="required"
                        >
                            <b-form-group
                                label="Party Name"
                                label-for="partyName"
                            >
                                <b-form-input
                                    id="partyName"
                                    v-model="formData.partyName"
                                    :state="getValidationState(validationContext)"
                                />
                            </b-form-group>
                            <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </validation-provider>
                        <b-form-group
                            label="Address"
                            label-for="partyAddress"
                        >
                            <b-form-textarea
                                id="partyAddress"
                                rows="3"
                                v-model="formData.partyAddress"
                            />
                        </b-form-group>
                        <b-form-group
                            label="District"
                            label-for="partyDistrict"
                        >
                            <v-select
                                placeholder="Select District"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="cityOptions"
                                :reduce="val => val.value"
                                :clearable="false"
                                input-id="partyDistrict"
                                v-model="formData.partyCity"
                                @input="getCityDetails($event)"
                            />
                        </b-form-group>
                        <b-form-group
                            label="State"
                            label-for="partyState"
                        >
                            <v-select
                                placeholder="Select State"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="stateOptions"
                                :reduce="val => val.value"
                                :clearable="false"
                                input-id="partyState"
                                v-model="formData.partyState"
                            />
                        </b-form-group>
                        <b-form-group
                            label="Country"
                            label-for="partyCountry"
                        >
                            <v-select
                                placeholder="Select Country"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="countryOptions"
                                :reduce="val => val.value"
                                :clearable="false"
                                input-id="partyCountry"
                                v-model="formData.partyCountry"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="6">
                        <b-form-group
                            label="Fax No."
                            label-for="partyFaxNo"
                        >
                            <b-form-input
                                id="partyFaxNo"
                                v-model="formData.partyFaxNo"
                            />
                        </b-form-group>
                        <b-form-group
                            label="Email ID"
                            label-for="partyEmailId"
                        >
                            <b-form-input
                                id="partyEmailId"
                                v-model="formData.partyEmailId"
                            />
                        </b-form-group>
                        <b-form-group
                            label="Web Site"
                            label-for="partyWebSite"
                        >
                            <b-form-input
                                id="partyWebSite"
                                v-model="formData.partyWebSite"
                            />
                        </b-form-group>
                        <b-form-group
                            label="Pin-Code"
                            label-for="partyPinCode"
                        >
                            <b-form-input
                                id="partyPinCode"
                                v-model="formData.partyPinCode"
                            />
                        </b-form-group>
                        <b-form-group
                            label="Phone No."
                            label-for="work-phone"
                        >
                            <b-input-group>
                                <b-input-group-prepend>
                                    <b-form-input
                                        id="stdCode"
                                        placeholder="STD code"
                                        type="number"
                                        v-model="formData.partyPhoneCountry"
                                    />
                                </b-input-group-prepend>
                                <b-form-input
                                    id="party-phone"
                                    placeholder="Party Phone"
                                    v-model="formData.partyPhoneNo"
                                />
                            </b-input-group>
                        </b-form-group>
                    </b-col>
                    <!--Button-->
                    <b-col md="12">
                        <hr>
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
    import {
        BForm,
        BRow,
        BCol,
        BFormGroup,
        BFormInput,
        BFormTextarea,
        BInputGroupPrepend,
        BInputGroup,
        BButton,
        BFormInvalidFeedback,
    } from 'bootstrap-vue'
    import VSelect from 'vue-select'
    import {computed, ref} from "@vue/composition-api";
    import axios from '@axios'
    import countryCode from '@/@fake-db/data/other/country-code'
    import {ValidationObserver, ValidationProvider} from 'vee-validate'
    import {required} from '@validations'
    import formValidation from '@core/comp-functions/forms/form-validation'
    import purchaseStoreModule from "../../purchaseStoreModule";
    import {useToast} from "vue-toastification/composition";
    import store from '@/store'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import router from '@/router'

    export default {
        components: {
            ValidationProvider,
            ValidationObserver,
            BForm,
            BRow,
            BCol,
            VSelect,
            BFormGroup,
            BFormInput,
            BFormTextarea,
            BInputGroupPrepend,
            BInputGroup,
            BButton,
            BFormInvalidFeedback,
        },
        computed: {
            countryCode: () => countryCode
        },
        props: {
            partyDetails: {
                type: Object,
                required: true,
            }
        },
        setup(props) {
            const toast = useToast()

            const ITEMADDON_APP_STORE_MODULE_NAME = 'purchase-store-module'
            if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, purchaseStoreModule)


            const partyCodeOption = ref([])
            axios.get('/api/party/get-master-options').then(res => {
                partyCodeOption.value = res.data.data
            })

            const getCityDetails = async (id) => {
                await axios.get(`/api/city-master/${id}`).then(res => {
                    formData.value.partyState = res.data.data.state
                    formData.value.partyCountry = res.data.data.country
                });
            }

            const countryOptions = ref([])
            axios.get('/api/get-country-options').then(res => {
                countryOptions.value = res.data.data
            })
            const stateOptions = ref([])
            axios.get('/api/get-state-options').then(res => {
                stateOptions.value = res.data.data
            })

            const cityOptions = ref([])
            axios.get('/api/get-city-options').then(res => {
                cityOptions.value = res.data.data
            })

            const formData = computed(() => props.partyDetails)

            const resetFormData = () => {
                formData.value = JSON.parse(JSON.stringify(formData.value))
            }

            const getPartyDetails = async (id) => {
                await axios.get(`/api/party/edit/${id}`).then(res => {
                    formData.value.pcPartyName = res.data.data?.partyName ?? null
                    formData.value.pcCity = res.data.data?.partyDetails?.partyCity ?? null
                    formData.value.partyCode = res.data.data?.partyCode ?? null
                    formData.value.partyName = res.data.data?.partyName ?? null
                    formData.value.partyAddress = res.data.data?.partyDetails?.partyAddress ?? null
                    formData.value.partyCountry = res.data.data?.partyDetails?.partyCountry ?? null
                    formData.value.partyState = res.data.data?.partyDetails?.partyState ?? null
                    formData.value.partyCity = res.data.data?.partyDetails?.partyCity ?? null
                    formData.value.partyFaxNo = res.data.data?.partyDetails?.partyFaxNo ?? null
                    formData.value.partyEmailId = res.data.data?.partyDetails?.partyEmilId ?? null
                    formData.value.partyWebSite = res.data.data?.partyDetails?.partyWebsite ?? null
                    formData.value.partyPinCode = res.data.data?.partyDetails?.partyPinCode ?? null
                    formData.value.partyPhoneCountry = res.data.data?.partyDetails?.partyCountryCode ?? null
                    formData.value.partyPhoneNo = res.data.data?.partyDetails?.partyPhoneNo ?? null
                })
            }

            const saveFormData = async () => {
                let sendData = {
                    _id: router.currentRoute.params.id,
                    partyDetails: formData.value
                }
                await store.dispatch('purchase-store-module/updatePurchaseCosting', sendData).then(res =>{
                    if (res.status === 200) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Purchase Costing Party Details Updated',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: 'You have successfully Updated Purchase Costing Party Details.',
                            },
                        })
                    } else {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Something went wrong',
                                icon: 'AlertCircleIcon',
                                variant: 'danger',
                                text: 'Something went wrong',
                            },
                        })
                    }
                    router.push({name: 'purchase-costing'})
                })
            }
            const {refFormObserver, getValidationState, resetForm} = formValidation(resetFormData)
            return {
                formData,
                partyCodeOption,
                countryOptions,
                stateOptions,
                cityOptions,
                saveFormData,
                getPartyDetails,
                //validation
                refFormObserver,
                getValidationState,
                resetForm,
                resetFormData,
                required,
                getCityDetails
            }
        }
    }
</script>
