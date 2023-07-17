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
                                label="Vendor Code"
                                label-for="vendorCode"
                            >
                                <v-select
                                    placeholder="Select Vendor"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="vendorOptions"
                                    :reduce="val => val.value"
                                    :clearable="false"
                                    input-id="vendorCode"
                                    :state="getValidationState(validationContext)"
                                    @input="getVendorDetails($event)"
                                    v-model="formData.vendorCode"
                                />
                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                        <validation-provider
                            #default="validationContext"
                            name="Vendor Code"
                            rules="required"
                        >
                            <b-form-group
                                label="Vendor Name"
                                label-for="vendorName"
                            >
                                <b-form-input
                                    id="vendorName"
                                    :state="getValidationState(validationContext)"
                                    v-model="formData.vendorName"
                                />
                            </b-form-group>
                            <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </validation-provider>
                        <b-form-group
                            label="Address"
                            label-for="address"
                        >
                            <b-form-textarea
                                id="address"
                                v-model="formData.vendorAddress"
                                rows="2"
                            />
                        </b-form-group>
                        <b-form-group
                            label="District"
                            label-for="district"
                        >
                            <v-select
                                placeholder="Select District"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="cityOptions"
                                :reduce="val => val.value"
                                :clearable="false"
                                input-id="district"
                                v-model="formData.vendorCity"
                                @input="getCityDetails($event)"
                            />
                        </b-form-group>
                        <b-form-group
                            label="State"
                            label-for="state"
                        >
                            <v-select
                                placeholder="Select State"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="stateOptions"
                                :reduce="val => val.value"
                                :clearable="false"
                                input-id="state"
                                v-model="formData.vendorState"
                            />
                        </b-form-group>
                        <b-form-group
                            label="Country"
                            label-for="country"
                        >
                            <v-select
                                placeholder="Select Country"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="countryOptions"
                                :reduce="val => val.value"
                                :clearable="false"
                                input-id="country"
                                v-model="formData.vendorCountry"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="6">

                        <b-form-group
                            label="Fax No."
                            label-for="faxNo"
                        >
                            <b-form-input
                                id="faxNo"
                                v-model="formData.vendorFaxNo"
                            />
                        </b-form-group>
                        <b-form-group
                            label="E-mail ID"
                            label-for="emailId"
                        >
                            <b-form-input
                                id="emailId"
                                v-model="formData.vendorEmailId"
                            />
                        </b-form-group>
                        <b-form-group
                            label="Website"
                            label-for="website"
                        >
                            <b-form-input
                                id="website"
                                v-model="formData.vendorWebSite"
                            />
                        </b-form-group>
                        <b-form-group
                            label="Kind Attn."
                            label-for="kindAttn"
                        >
                            <v-select
                                placeholder="Select KindAttn"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="kindAttnOption"
                                :reduce="val => val.value"
                                :clearable="false"
                                input-id="kindAttn"
                                v-model="formData.vendorKindAttn"
                            />
                        </b-form-group>
                        <b-form-group
                            label="Pin-Code"
                            label-for="pinCode"
                        >
                            <b-form-input
                                id="pinCode"
                                v-model="formData.vendorPinCode"
                            />
                        </b-form-group>
                        <b-form-group
                            label="Phone No."
                            label-for="work-phone"
                        >
                            <b-input-group>
                                <b-input-group-prepend>
                                   <b-form-input
                                        v-model="formData.vendorPhoneCountry"
                                    />
                                </b-input-group-prepend>
                                <b-form-input
                                    id="work-phone"
                                    placeholder="Party Phone"
                                    v-model="formData.vendorPhoneNo"
                                />
                            </b-input-group>
                        </b-form-group>
                    </b-col>
                    <!-- Button-->
                    <b-col md="12">
                        <hr>
                        <b-button
                            class="float-right"
                            variant="primary"
                            type="submit"
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
        BInputGroupPrepend,
        BFormInput,
        BFormTextarea,
        BButton,
        BFormValidFeedback,
        BInputGroupAppend,
        BInputGroup,
        BFormInvalidFeedback
    } from 'bootstrap-vue'
    import BCardCode from "../../../../@core/components/b-card-code/BCardCode";
    import {ValidationObserver, ValidationProvider} from 'vee-validate'
    import formValidation from '@core/comp-functions/forms/form-validation'
    import {required} from '@validations'
    import vSelect from 'vue-select'
    import axios from '@axios'
    import {ref, computed} from "@vue/composition-api";
    import countryCode from '@/@fake-db/data/other/country-code'
    import store from '@/store'
    import purchaseStoreModule from "../../purchaseStoreModule";
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import {useToast} from 'vue-toastification/composition'
    import router from '@/router'

    export default {
        components: {
            ValidationObserver,
            ValidationProvider,
            BCardCode,
            BForm,
            BRow,
            BCol,
            BFormGroup,
            BFormInput,
            BFormTextarea,
            BButton,
            BFormValidFeedback,
            BInputGroupAppend,
            BInputGroup,
            BFormInvalidFeedback,
            vSelect,
            BInputGroupPrepend,
        },
        props: {
            vendorDetails: {
                type: Object,
                required: true,
            }
        },
        computed: {
            countryCode: () => countryCode
        },
        setup(props) {
            const ITEMADDON_APP_STORE_MODULE_NAME = 'purchase-store-module'
            if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, purchaseStoreModule)

            const toast = useToast()

            const cityOptions = ref([])
            axios.get('/api/get-city-options').then(res => {
                cityOptions.value = res.data.data
            })

            const stateOptions = ref([])
            axios.get('/api/get-state-options').then(res => {
                stateOptions.value = res.data.data
            })

            const countryOptions = ref([])
            axios.get('/api/get-country-options').then(res => {
                countryOptions.value = res.data.data
            })

            const vendorOptions = ref([])
            axios.get('/api/party/get-master-options').then(res => {
                vendorOptions.value = res.data.data
            })
            const getCityDetails = async (id) => {
                await axios.get(`/api/city-master/${id}`).then(res => {
                    formData.value.vendorState = res.data.data.state
                    formData.value.vendorCountry = res.data.data.country
                });
            }
            const formData = computed(() => props.vendorDetails)

            const resetFormData = () => {
                formData.value = JSON.parse(JSON.stringify(formData.value))
            }

            const kindAttnOption = ref([])

            const getVendorDetails = async (id) => {
                await axios.get(`/api/party/edit/${id}`).then(res => {
                    formData.value.vendorName = res.data.data.partyName
                    formData.value.vendorAddress = res.data.data?.partyDetails?.partyAddress ?? null
                    formData.value.vendorCountry = res.data.data?.partyDetails?.partyCountry?.value ?? null
                    formData.value.vendorState = res.data.data?.partyDetails?.partyState?.value ?? null
                    formData.value.vendorCity = res.data.data?.partyDetails?.partyCity?.value ?? null
                    formData.value.vendorFaxNo = res.data.data?.partyDetails?.partyFaxNo ?? null
                    formData.value.vendorEmailId = res.data.data?.partyDetails?.partyEmilId ?? null
                    formData.value.vendorWebSite = res.data.data?.partyDetails?.partyWebsite ?? null
                    formData.value.vendorPinCode = res.data.data?.partyDetails?.partyPinCode ?? null
                    formData.value.vendorPhoneCountry = res.data.data?.partyDetails?.partyCountryCode ?? null
                    formData.value.vendorPhoneNo = res.data.data?.partyDetails?.partyPhoneNo ?? null
                })
                formData.value.kindAttnId = null
                await axios.get(`/api/party/get-party-contacts-options/${id}`).then(res => {
                    kindAttnOption.value = res.data.data
                })
            }

            const saveFormData = async () => {
                let sendFormData = {
                    _id: router.currentRoute.params.id,
                    vendorDetails: formData.value
                }
                await store.dispatch('purchase-store-module/updatePurchaseQuotation', sendFormData).then(res => {
                    if (res.status === 200) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Purchase Quotation Vendor Details Updated',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: 'You have successfully Updated Purchase Quotation Vendor Details.',
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
                })
            }

            const {refFormObserver, getValidationState, resetForm} = formValidation(resetFormData)
            return {
                formData,
                refFormObserver,
                getValidationState,
                resetForm,
                resetFormData,
                required,
                saveFormData,
                vendorOptions,
                cityOptions,
                stateOptions,
                countryOptions,
                getVendorDetails,
                getCityDetails,
                kindAttnOption
            }
        },
    }
</script>
