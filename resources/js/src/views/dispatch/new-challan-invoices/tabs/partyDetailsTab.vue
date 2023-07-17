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
                                label-for="PartyCode"
                            >
                                <v-select
                                    placeholder="Select Code"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="partyCodeOptions"
                                    :reduce="val => val.value"
                                    :clearable="false"
                                    input-id="PartyCode"
                                    v-model="formData.PartyCode"
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
                                label-for="PartyName"
                            >
                                <b-form-input
                                    id="PartyName"
                                    :state="getValidationState(validationContext)"
                                    v-model="formData.PartyName"
                                     readonly
                                />
                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                        <b-form-group
                            label="Address"
                            label-for="partyAddress"
                        >
                            <b-form-textarea
                                id="partyAddress"
                                rows="2"
                                v-model="formData.partyAddress"
                            />
                        </b-form-group>
                        <b-row>
                            <b-col md="6">
                                <b-form-group
                                    label="District"
                                    label-for="partyCity"
                                >
                                    <v-select
                                        placeholder="Select District"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="cityOptions"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        input-id="partyCity"
                                        v-model="formData.partyCity"
                                        @input="getCityDetails($event)"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
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
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="6">
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
                            </b-col>
                        </b-row>
                    </b-col>
                    <b-col md="6">
                        <b-row>
                            <b-col md="6">
                                <b-form-group
                                    label="Email ID"
                                    label-for="partyEmailId"
                                >
                                    <b-form-input
                                        id="partyEmailId"
                                        v-model="formData.partyEmailId"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Web Site"
                                    label-for="partyWebSite"
                                >
                                    <b-form-input
                                        id="partyWebSite"
                                        v-model="formData.partyWebSite"
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="6">
                                <b-form-group
                                    label="TIN VAT No."
                                    label-for="partyTinVatNo"
                                >
                                    <b-form-input
                                        id="partyTinVatNo"
                                        v-model="formData.partyTinVatNo"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="TIN CST No."
                                    label-for="partyTinCstNo"
                                >
                                    <b-form-input
                                        id="partyTinCstNo"
                                        v-model="formData.partyTinCstNo"
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="6">
                                <b-form-group
                                    label="Pan No."
                                    label-for="partyEccNo"
                                >
                                    <b-form-input
                                        id="partyEccNo"
                                        v-model="formData.partyPanNo"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="GSTIN"
                                    label-for="partyGstinNo"
                                >
                                    <b-form-input
                                        id="partyGstinNo"
                                        v-model="formData.partyGstinNo"
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
                                        v-model="formData.partyPhoneCountry"
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
                    <b-col md="3">
                        <b-form-group
                            label="Select Kind Attn"
                            label-for="kindAttnId"
                        >
                            <v-select
                                v-model="formData.partyKindAttnId"
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
                                v-model="formData.partyKindAttnName"
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
                                v-model="formData.partyKindAttnMobile"
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
                                v-model="formData.partyKindAttnEmail"
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
    import {ref, computed, onUnmounted} from "@vue/composition-api";
    import axios from '@axios'
    import countryCode from '@/@fake-db/data/other/country-code'
    import {ValidationObserver, ValidationProvider} from 'vee-validate'
    import formValidation from '@core/comp-functions/forms/form-validation'
    import {useToast} from "vue-toastification/composition";
    import dispatchStoreModule from "../../dispatchStoreModule";
    import store from '@/store'
    import ToastificationContent from "@core/components/toastification/ToastificationContent";
    import router from '@/router'

    export default {
        components: {
            ValidationObserver,
            ValidationProvider,
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
            BFormInvalidFeedback
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
            const ITEMADDON_APP_STORE_MODULE_NAME = 'dispatch-store-module'
            if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, dispatchStoreModule)

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
            const getCityDetails = async (id) => {
                await axios.get(`/api/city-master/${id}`).then(res => {
                    console.log(res.data.data)
                    formData.value.partyState = res.data.data.state
                    formData.value.partyCountry = res.data.data.country
                });
            }

            const KindAttnOptions = ref([])

            const formData = computed(() => props.partyDetails)

            const getPartyDetails =  async (id) => {
                await axios.get(`/api/party/edit/${id}`).then(res => {
                    formData.value.PartyName = res.data.data.partyName
                    formData.value.partyAddress = res.data.data?.partyAddress?.partyAddress ?? null
                    formData.value.partyCountry = res.data.data?.partyAddress?.partyCountry.value  ?? null
                    formData.value.partyState = res.data.data?.partyAddress?.partyState.value  ?? null
                    formData.value.partyCity = res.data.data?.partyAddress?.partyCity.value  ?? null
                    formData.value.partyFaxNo = res.data.data?.partyAddress?.partyFaxNo  ?? null
                    formData.value.partyEmailId = res.data.data?.partyDetails?.partyEmilId  ?? null
                    formData.value.partyWebSite = res.data.data?.partyDetails?.partyWebsite  ?? null
                    formData.value.partyPinCode = res.data.data?.partyDetails?.partyPinCode  ?? null
                    formData.value.partyPhoneCountry = res.data.data?.partyDetails?.partyCountryCode  ?? null
                    formData.value.partyPhoneNo = res.data.data?.partyDetails?.partyPhoneNo  ?? null
                    formData.value.partyTinVatNo = res.data.data?.taxDetails?.tinVatNo  ?? null
                    formData.value.partyTinCstNo = res.data.data?.taxDetails?.tinCstNo  ?? null
                    formData.value.partyEccNo = res.data.data?.taxDetails?.eccNo  ?? null
                    formData.value.partyGstinNo = res.data.data?.taxDetails?.gstin  ?? null
                    formData.value.partyPanNo = res.data.data?.taxDetails?.panNo  ?? null
                });
                await getKindAttnOptions(id);
                formData.value.partyKindAttnId = null
                formData.value.partyKindAttnName = null
                formData.value.partyKindAttnMobile = null
                formData.value.partyKindAttnEmail = null
            }

            const getKindAttnOptions = async (id) => {
                await axios.get('/api/party/get-party-contacts-options/'+id).then((res) => {
                    KindAttnOptions.value = res.data.data
                })
            }
            setTimeout(() => {
                getKindAttnOptions(formData.value.PartyCode)
            }, 2000)

            const getContactDetail = async (id) => {
                if (id) {
                    await axios.get('/api/party/contact-person/' + id).then(res => {
                        formData.value.partyKindAttnId = res.data.data._id
                        formData.value.partyKindAttnName = res.data.data.personName
                        formData.value.partyKindAttnMobile = res.data.data.mobileNo
                        formData.value.partyKindAttnEmail = res.data.data.email
                    });
                } else {
                    formData.value.partyKindAttnId = null
                    formData.value.partyKindAttnName = null
                    formData.value.partyKindAttnMobile = null
                    formData.value.partyKindAttnEmail = null
                }
            }

            const resetFormData = () => {
                formData.value = JSON.parse(JSON.stringify(blankFormData))
            }

            const saveFormData = async () => {
                let subtmiData = {
                    _id: router.currentRoute.params.id,
                    partyDetails: formData.value
                }
                await store.dispatch('dispatch-store-module/updateNewInvoiceChallan', subtmiData).then((res) => {
                    if (res.status === 200) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Challan & Invoice Party Updated',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: 'You have successfully Updated Challan & Invoice Party',
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
                KindAttnOptions,
                stateOptions,
                cityOptions,
                getValidationState,
                refFormObserver,
                resetForm,
                resetFormData,
                getPartyDetails,
                getContactDetail,
                getCityDetails
            }
        }
    }
</script>
