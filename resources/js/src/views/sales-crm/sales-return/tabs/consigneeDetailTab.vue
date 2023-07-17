<template>
    <div>
        <validation-observer #default="{ handleSubmit }">
            <b-form @submit.prevent="handleSubmit(saveFormData)">
                <b-row>
                    <b-col md="6">
                        <validation-provider
                            #default="validationContext"
                            name="Party Code"
                            rules="required"
                        >
                            <b-form-group
                                label="Party Code"
                                label-for="consigneeCode"
                            >
                                <v-select
                                    placeholder="Select Code"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="partyCodeOptions"
                                    :reduce="val => val.value"
                                    :clearable="false" validationContext
                                    input-id="consigneeCode"
                                    v-model="formData.consigneeCode"
                                    :state="getValidationState(validationContext)"
                                    @input="getPartyDetails($event)"
                                />
                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                        <validation-provider
                            #default="validationContext"
                            name="Party Name"
                            rules="required"
                        >
                            <b-form-group
                                label="Party Name"
                                label-for="consigneeName"
                            >
                                <b-form-input
                                    id="consigneeName"
                                    :state="getValidationState(validationContext)"
                                    v-model="formData.consigneeName"
                                />
                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                        <b-form-group
                            label="Address"
                            label-for="consigneeAddress"
                        >
                            <b-form-textarea
                                id="consigneeAddress"
                                v-model="formData.consigneeAddress"
                                rows="2"
                            />
                        </b-form-group>
                        <b-row>
                            <b-col md="6">
                                <b-form-group
                                    label="District"
                                    label-for="consigneeCity"
                                >
                                    <v-select
                                        placeholder="Select City"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="cityOptions"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        input-id="consigneeCity"
                                        v-model="formData.consigneeCity"
                                        @input="getCityStateCountry($event)"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="State"
                                    label-for="consigneeState"
                                >
                                    <v-select
                                        placeholder="Select State"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="stateOptions"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        input-id="consigneeState"
                                        v-model="formData.consigneeState"
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="6">
                                <b-form-group
                                    label="Country"
                                    label-for="consigneeCountry"
                                >
                                    <v-select
                                        placeholder="Select Country"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="countryOptions"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        input-id="consigneeCountry"
                                        v-model="formData.consigneeCountry"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Fax No."
                                    label-for="consigneeFaxNo"
                                >
                                    <b-form-input
                                        id="consigneeFaxNo"
                                        v-model="formData.consigneeFaxNo"
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>
                    </b-col>
                    <b-col md="6">
                        <b-row>
                            <b-col md="6">
                                <b-form-group
                                    label="Email ID"
                                    label-for="consigneeEmailId"
                                >
                                    <b-form-input
                                        id="consigneeEmailId"
                                        v-model="formData.consigneeEmailId"

                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Web Site"
                                    label-for="consigneeWebSite"
                                >
                                    <b-form-input
                                        id="consigneeWebSite"
                                        v-model="formData.consigneeWebSite"
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="6">
                                <b-form-group
                                    label="TIN VAT No."
                                    label-for="consigneeTinVatNo"
                                >
                                    <b-form-input
                                        id="consigneeTinVatNo"
                                        v-model="formData.consigneeTinVatNo"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="TIN CST No."
                                    label-for="consigneeTinCstNo"
                                >
                                    <b-form-input
                                        id="consigneeTinCstNo"
                                        v-model="formData.consigneeTinCstNo"
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="6">
                                <b-form-group
                                    label="Pan No."
                                    label-for="consigneePanNo"
                                >
                                    <b-form-input
                                        id="consigneeEccNo"
                                        v-model="formData.consigneePanNo"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="GSTIN"
                                    label-for="consigneeGstinNo"
                                >
                                    <b-form-input
                                        id="consigneeGstinNo"
                                        v-model="formData.consigneeGstinNo"
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-form-group
                            label="Pin-Code"
                            label-for="partyPinCode"
                        >
                            <b-form-input
                                id="partyPinCode"
                                v-model="formData.consigneePinCode"
                            />
                        </b-form-group>
                        <b-form-group
                            label="Phone No."
                            label-for="work-phone"
                        >
                            <b-input-group>
                                <b-input-group-prepend>
                                    <b-form-input
                                        v-model="formData.consigneePhoneCountry"
                                    />
                                </b-input-group-prepend>
                                <b-form-input
                                    id="party-work-phone"
                                    placeholder="Party Phone"
                                    v-model="formData.consigneePhoneNo"
                                />
                            </b-input-group>
                        </b-form-group>
                    </b-col>
                    <b-col md="3">
                        <b-form-group
                            label="Select Kind Attn"
                            label-for="kindAttnId"
                        >
                            <v-select
                                v-model="formData.consigneeKindAttnId"
                                placeholder="Select Kind Attn"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="KindAttnOptions"
                                :reduce="val => val.value"
                                :clearable="true"
                                @input="getContactDetail($event)"
                                input-id="kindAttnId"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="3">
                        <b-form-group
                            label="Kind Attn Name"
                            label-for="kindAttnName"
                        >
                            <b-form-input
                                id="kindAttnName"
                                v-model="formData.consigneeKindAttnName"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="3">
                        <b-form-group
                            label="Mobile NO"
                            label-for="kindAttnMobile"
                        >
                            <b-form-input
                                id="kindAttnMobile"
                                v-model="formData.consigneeKindAttnMobile"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="3">
                        <b-form-group
                            label="Email Id"
                            label-for="kindAttnEmail"
                        >
                            <b-form-input
                                id="kindAttnEmail"
                                v-model="formData.consigneeKindAttnEmail"
                            />
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
        BInputGroup,
        BInputGroupPrepend,
        BButton,
        BFormInvalidFeedback,
    } from 'bootstrap-vue'
    import VSelect from 'vue-select'
    import {ref,computed,onUnmounted} from "@vue/composition-api";
    import axios from '@axios'
    import countryCode from '@/@fake-db/data/other/country-code'
    import {ValidationObserver, ValidationProvider} from 'vee-validate'
    import formValidation from '@core/comp-functions/forms/form-validation'
    import ToastificationContent from "../../../../@core/components/toastification/ToastificationContent";
    import router from '@/router'
    import store from '@/store'
    import salesStoreModule from '../../salesStoreModule'
    import {useToast} from "vue-toastification/composition";

    export default {
        components: {
            ValidationProvider,
            ValidationObserver,
            BForm,
            BRow,
            BCol,
            BFormGroup,
            VSelect,
            BFormInput,
            BFormTextarea,
            BInputGroup,
            BInputGroupPrepend,
            BButton,
            BFormInvalidFeedback,
        },
        computed: {
            countryCode: () => countryCode
        },
        props:{
            consigneeDetails: {
                type: Object,
                required: true,
            }
        },
        setup(props) {
            const ITEMADDON_APP_STORE_MODULE_NAME = 'sales-return-module'
            if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, salesStoreModule)

            const toast = useToast()

            const partyCodeOptions = ref([])
            axios.get('/api/party/get-master-options').then(res => {
                partyCodeOptions.value = res.data.data
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

            const KindAttnOptions = ref([])

            const formData = computed(() => props.consigneeDetails)

            const resetFormData = () => {
                formData.value = JSON.parse(JSON.stringify(blankFormData))
            }

            const getPartyDetails =  async (id) => {
                await axios.get(`/api/party/edit/${id}`).then(res => {
                    formData.value.consigneeName = res.data.data.partyName
                    formData.value.consigneeAddress = res.data.data?.partyAddress?.partyAddress ?? null
                    formData.value.consigneeCountry = res.data.data?.partyAddress?.partyCountry  ?? null
                    formData.value.consigneeState = res.data.data?.partyAddress?.partyState  ?? null
                    formData.value.consigneeCity = res.data.data?.partyAddress?.partyCity  ?? null
                    formData.value.consigneeFaxNo = res.data.data?.partyAddress?.partyFaxNo  ?? null
                    formData.value.consigneeEmailId = res.data.data?.partyDetails?.partyEmilId  ?? null
                    formData.value.consigneeWebSite = res.data.data?.partyDetails?.partyWebsite  ?? null
                    formData.value.consigneePinCode = res.data.data?.partyDetails?.partyPinCode  ?? null
                    formData.value.consigneePhoneCountry = res.data.data?.partyDetails?.partyCountryCode  ?? null
                    formData.value.consigneePhoneNo = res.data.data?.partyDetails?.partyPhoneNo  ?? null
                    formData.value.consigneeTinVatNo = res.data.data?.taxDetails?.tinVatNo  ?? null
                    formData.value.consigneeTinCstNo = res.data.data?.taxDetails?.tinCstNo  ?? null
                    formData.value.consigneeEccNo = res.data.data?.taxDetails?.eccNo  ?? null
                    formData.value.consigneeGstinNo = res.data.data?.taxDetails?.gstin  ?? null
                    formData.value.consigneePanNo = res.data.data?.taxDetails?.panNo  ?? null
                    formData.value.consigneeCountryName = res.data.data?.partyAddress?.partyCountry.label  ?? null
                    formData.value.consigneeStateName = res.data.data?.partyAddress?.partyState.label  ?? null
                    formData.value.consigneeCityName = res.data.data?.partyAddress?.partyCity.label  ?? null

                    axios.get(`/api/state-master/${formData.value.consigneeState}`).then((stateRes) => {
                        formData.value.consigneeStateCode = stateRes.data.data.stateCode
                    });
                });
                await getKindAttnOptions(id)
            }

            const getKindAttnOptions = async (id) => {
                await axios.get(`/api/party/get-party-contacts-options/${id}`).then((res) => {
                    KindAttnOptions.value = res.data.data
                });
            }
            setTimeout(() => {
                getKindAttnOptions(formData.value.consigneeCode)
            }, 2000)

            const getContactDetail = async (id) => {
                if (id) {
                    await axios.get(`/api/party/contact-person/${id}`).then(res => {
                        formData.value.consigneeKindAttnId = res.data.data._id
                        formData.value.consigneeKindAttnName = res.data.data.personName
                        formData.value.consigneeKindAttnMobile = res.data.data.mobileNo
                        formData.value.consigneeKindAttnEmail = res.data.data.email
                    });
                } else {
                    formData.value.consigneeKindAttnId = null
                    formData.value.consigneeKindAttnName = null
                    formData.value.consigneeKindAttnMobile = null
                    formData.value.consigneeKindAttnEmail = null
                }
            }

            const getCityStateCountry = async (id) => {
                await axios.get(`/api/city-master/${id}`).then((res) => {
                    formData.value.consigneeCityName = res.data.data.city
                    formData.value.consigneeState = res.data.data.state
                    formData.value.consigneeStateName = res.data.data.state_detail.label
                    formData.value.consigneeStateCode = res.data.data.state_detail.code
                    formData.value.consigneeCountry = res.data.data.country
                    formData.value.consigneeCountryName = res.data.data.country_detail.label
                });
            }

            const saveFormData = async () => {
                let submitData = {
                    id: router.currentRoute.params.id,
                    consigneeDetails: formData.value
                }
                await store.dispatch('sales-return-module/updateSalesReturn', submitData).then((res) => {
                    if (res.status === 200) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Sales Return Consignee Updated',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: 'You have successfully Updated Sales Return Consignee',
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
                saveFormData,
                partyCodeOptions,
                countryOptions,
                stateOptions,
                cityOptions,
                resetFormData,
                refFormObserver,
                getValidationState,
                resetForm,
                getPartyDetails,
                getCityStateCountry,
                getKindAttnOptions,
                KindAttnOptions,
                getContactDetail,
            }
        }
    }
</script>
