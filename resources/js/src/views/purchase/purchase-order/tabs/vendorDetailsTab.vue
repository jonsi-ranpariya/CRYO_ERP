<template>
    <div>
        <!-- Vendor Form -->
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
                                    v-model="formData.vendorCode"
                                    @input="getVendorDetails($event)"
                                />
                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                        <validation-provider
                            #default="validationContext"
                            name="Vendor Name"
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
                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                        <b-form-group
                            label="Address"
                            label-for="vendorAddress"
                        >
                            <b-form-textarea
                                id="vendorAddress"
                                rows="3"
                                v-model="formData.vendorAddress"
                            />
                        </b-form-group>
                        <b-form-group
                            label="Area"
                            label-for="party-area"
                        >
                            <validation-provider
                                #default="validationContext"
                                name="Area"
                                rules=""
                            >
                                <b-form-input
                                    id="party-area"
                                    placeholder="Party Area"
                                    v-model="formData.vendorArea"
                                    :state="getValidationState(validationContext)"
                                />
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </validation-provider>
                        </b-form-group>
                        <b-form-group
                            label="District"
                            label-for="vendorDistrict"
                        >
                            <v-select
                                placeholder="Select District"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="cityOptions"
                                :reduce="val => val.value"
                                :clearable="false"
                                input-id="vendorDistrict"
                                v-model="formData.vendorCity"
                                @input="getCountryDetails($event)"
                            />
                        </b-form-group>
                        <b-form-group
                            label="State"
                            label-for="vendorState"
                        >
                            <v-select
                                placeholder="Select State"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="stateOptions"
                                :reduce="val => val.value"
                                :clearable="false"
                                input-id="vendorState"
                                v-model="formData.vendorState"
                            />
                        </b-form-group>
                        <b-form-group
                            label="Country"
                            label-for="vendorCountry"
                        >
                            <v-select
                                placeholder="Select Country"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="countryOptions"
                                :reduce="val => val.value"
                                :clearable="false"
                                input-id="vendorCountry"
                                v-model="formData.vendorCountry"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="6">
                        <b-form-group
                            label="Fax No."
                            label-for="vendorFaxNo"
                        >
                            <b-form-input
                                id="vendorFaxNo"
                                v-model="formData.vendorFaxNo"
                            />
                        </b-form-group>
                        <b-form-group
                            label="Email"
                            label-for="vendorEmailId"
                        >
                            <b-form-input
                                id="vendorEmailId"
                                v-model="formData.vendorEmailId"
                            />
                        </b-form-group>
                        <b-form-group
                            label="GSTIN"
                            label-for="vendorGstin"
                        >
                            <b-form-input
                                id="vendorGstin"
                                v-model="formData.vendorGstin"
                            />
                        </b-form-group>
                        <b-form-group
                            label="Web Site"
                            label-for="vendorWebSite"
                        >
                            <b-form-input
                                id="WebSite"
                                v-model="formData.vendorWebSite"
                            />
                        </b-form-group>
                        <b-form-group
                            label="Pin-Code"
                            label-for="vendorPinCode"
                        >
                            <b-form-input
                                id="vendorPinCode"
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
                                        id="stdCode"
                                        placeholder="STD code"
                                        type="number"
                                        v-model="formData.vendorPhoneCountry"
                                    />
                                </b-input-group-prepend>
                                <b-form-input
                                    id="party-phone"
                                    placeholder="Party Phone"
                                    v-model="formData.vendorPhoneNo"
                                />
                            </b-input-group>
                        </b-form-group>
                        <b-form-group>
                            <b-form-checkbox
                                id="report-status"
                                name="report-status"
                                value="1"
                            >
                                Active
                            </b-form-checkbox>
                        </b-form-group>
                    </b-col>
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
        BFormDatepicker,
        BButton,
        BFormInvalidFeedback,
        BOverlay,
        BTable,
        BInputGroup,
        BInputGroupPrepend,
        BSpinner,
        BDropdown,
        BDropdownItem,
        BFormCheckbox
    } from 'bootstrap-vue'
    import BCardCode from "@core/components/b-card-code/BCardCode";
    import {ref, computed} from '@vue/composition-api'
    import VSelect from 'vue-select'
    import axios from '@axios'
    import {ValidationProvider, ValidationObserver} from 'vee-validate'
    import formValidation from '@core/comp-functions/forms/form-validation'
    import {required} from '@validations'
    import router from '@/router'
    import countryCode from '@/@fake-db/data/other/country-code'
    import purchaseStoreModule from "../../purchaseStoreModule";
    import {useToast} from "vue-toastification/composition";
    import store from '@/store'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'

    export default {
        components: {
            BCardCode,
            VSelect,
            BForm,
            BRow,
            BCol,
            BFormGroup,
            BFormInput,
            BFormTextarea,
            BFormDatepicker,
            BButton,
            BFormInvalidFeedback,
            BTable,
            BOverlay,
            BInputGroup,
            BInputGroupPrepend,
            BSpinner,
            BDropdown,
            BDropdownItem,
            BFormCheckbox,
            ValidationProvider,
            ValidationObserver,
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

            const vendorOptions = ref([])
            axios.get('/api/party/get-master-options').then(res => {
                vendorOptions.value = res.data.data
            })

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
            const getCountryDetails = async (id) => {
                await axios.get(`/api/city-master/${id}`).then(res => {
                    formData.value.vendorState = res.data.data.state
                    formData.value.vendorCountry = res.data.data.country
                });
            }

            const formData = computed(() => props.vendorDetails)

            const blankFormData = {}
            const resetFormData = () => {
                formData.value = JSON.parse(JSON.stringify(blankFormData))
            }

            const getVendorDetails = async (id) => {
                await axios.get(`/api/party/edit/${id}`).then(res => {
                    formData.value.vendorName = res.data.data.partyName
                    formData.value.vendorAddress = res.data.data?.partyDetails?.partyAddress ?? null
                    formData.value.vendorArea = res.data.data?.partyDetails?.partyArea ?? null
                    formData.value.vendorCountry = res.data.data?.partyDetails?.partyCountry?? null
                    formData.value.vendorState = res.data.data?.partyDetails?.partyState ?? null
                    formData.value.vendorCity = res.data.data?.partyDetails?.partyCity ?? null
                    formData.value.vendorFaxNo = res.data.data?.partyDetails?.partyFaxNo ?? null
                    formData.value.vendorEmailId = res.data.data?.partyDetails?.partyEmilId ?? null
                    formData.value.vendorWebSite = res.data.data?.partyDetails?.partyWebsite ?? null
                    formData.value.vendorGstin = res.data.data?.taxDetails?.gstin ?? null
                    formData.value.vendorPinCode = res.data.data?.partyDetails?.partyPinCode ?? null
                    formData.value.vendorPhoneCountry = res.data.data?.partyDetails?.partyCountryCode ?? null
                    formData.value.vendorPhoneNo = res.data.data?.partyDetails?.partyPhoneNo ?? null
                })
            }

            const saveFormData = async () => {
                let sendFormData = {
                    id: router.currentRoute.params.id,
                    vendorDetails: formData.value
                }
                await store.dispatch('purchase-store-module/updatePurchaseOrder', sendFormData).then(res => {
                    if (res.status === 200) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Purchase Order Vendor Details Updated',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: 'You have successfully Updated Purchase Order Vendor Details.',
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
                vendorOptions,
                countryOptions,
                stateOptions,
                cityOptions,
                formData,
                resetFormData,
                getVendorDetails,
                saveFormData,
                required,
                refFormObserver,
                getValidationState,
                resetForm,
                getCountryDetails
            }
        }
    }
</script>


