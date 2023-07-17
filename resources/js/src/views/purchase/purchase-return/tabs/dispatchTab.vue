<template>
    <div>
        <validation-observer #default="{ handleSubmit }">
            <b-form @submit.prevent="handleSubmit(saveFormData)">
                <b-row>
                    <b-col md="6">
                        <validation-provider
                            #default="validationContext"
                            name="Party Code"
                            rules=""
                        >
                            <b-form-group
                                label="Party Code"
                                label-for="buyerCode"
                            >
                                <v-select
                                    placeholder="Select Code"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="partyCodeOptions"
                                    :reduce="val => val.value"
                                    :clearable="false"
                                    input-id="buyerCode"
                                    v-model="formData.dispatchCode"
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
                                label-for="buyerName"
                            >
                                <b-form-input
                                    id="buyerName"
                                    :state="getValidationState(validationContext)"
                                    v-model="formData.dispatchName"
                                />
                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                        <b-form-group
                            label="Address"
                            label-for="buyerAddress"
                        >
                            <b-form-textarea
                                id="buyerAddress"
                                v-model="formData.dispatchAddress"
                                rows="2"
                            />
                        </b-form-group>
                        <b-row>
                            <b-col md="6">
                                <b-form-group
                                    label="District"
                                    label-for="buyerDistrict"
                                >
                                    <v-select
                                        placeholder="Select District"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="cityOptions"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        input-id="buyerDistrict"
                                        v-model="formData.dispatchCity"
                                        @input="getCityDetails($event)"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="State"
                                    label-for="buyerState"
                                >
                                    <v-select
                                        placeholder="Select State"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="stateOptions"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        input-id="buyerState"
                                        v-model="formData.dispatchState"
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="6">
                                <b-form-group
                                    label="Country"
                                    label-for="buyerCountry"
                                >
                                    <v-select
                                        placeholder="Select Country"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="countryOptions"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        v-model="formData.dispatchCountry"
                                        input-id="buyerCountry"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Fax No."
                                    label-for="buyerFaxNo"
                                >
                                    <b-form-input
                                        id="buyerFaxNo"
                                        v-model="formData.dispatchFaxNo"
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
                                    label-for="buyerEmailId"
                                >
                                    <b-form-input
                                        id="buyerEmailId"
                                        v-model="formData.dispatchEmailId"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Web Site"
                                    label-for="buyerWebSite"
                                >
                                    <b-form-input
                                        id="buyerWebSite"
                                        v-model="formData.dispatchWebSite"
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="6">
                                <b-form-group
                                    label="TIN VAT No."
                                    label-for="buyerTinVatNo"
                                >
                                    <b-form-input
                                        id="buyerTinVatNo"
                                        v-model="formData.dispatchTinVatNo"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="TIN CST No."
                                    label-for="buyerTinCstNo"
                                >
                                    <b-form-input
                                        id="buyerTinCstNo"
                                        v-model="formData.dispatchTinCstNo"
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="6">
                                <b-form-group
                                    label="Pan No."
                                    label-for="buyerPanNo"
                                >
                                    <b-form-input
                                        id="buyerPanNo"
                                        v-model="formData.dispatchPanNo"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="GSTIN"
                                    label-for="buyerGstinNo"
                                >
                                    <b-form-input
                                        id="buyerGstinNo"
                                        v-model="formData.dispatchGstinNo"
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-form-group
                            label="Pin-Code"
                            label-for="buyerPinCode"
                        >
                            <b-form-input
                                id="buyerPinCode"
                                v-model="formData.dispatchPinCode"
                            />
                        </b-form-group>
                        <b-form-group
                            label="Phone No."
                            label-for="work-phone"
                        >
                            <b-input-group>
                                <b-input-group-prepend>
                                    <b-form-input
                                        v-model="formData.dispatchPhoneCountry"
                                    />
                                </b-input-group-prepend>
                                <b-form-input
                                    id="buyer-work-phone"
                                    placeholder="Party Phone"
                                    v-model="formData.dispatchPhoneNo"
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
                                v-model="formData.dispatchKindAttnId"
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
                                v-model="formData.dispatchKindAttnName"
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
                                v-model="formData.dispatchKindAttnMobile"
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
                                v-model="formData.dispatchKindAttnEmail"
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
import {ValidationObserver,ValidationProvider} from 'vee-validate'
import formValidation from '@core/comp-functions/forms/form-validation'
import ToastificationContent from "../../../../@core/components/toastification/ToastificationContent";
import router from '@/router'
import store from '@/store'
import purchaseStoreModule from "../../purchaseStoreModule";
import {useToast} from "vue-toastification/composition";

export default {
    components:{
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
        BFormInvalidFeedback,
    },
    computed: {
        countryCode: () => countryCode
    },
    props:{
        dispatchDetails:{
            required: true,
        }
    },
    setup(props){
        const ITEMADDON_APP_STORE_MODULE_NAME = 'purchase-store-module'
        if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, purchaseStoreModule)

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
                formData.value.dispatchState = res.data.data.state
                formData.value.dispatchCountry = res.data.data.country
            });
        }

        const KindAttnOptions = ref([])

        const formData = computed(() => props.dispatchDetails)

        const resetFormData = () => {
            formData.value = JSON.parse(JSON.stringify(blankFormData))
        }

        const getPartyDetails =  async (id) => {
            await axios.get(`/api/party/edit/${id}`).then(res => {
                formData.value.dispatchName = res.data.data.partyName
                formData.value.dispatchAddress = res.data.data?.partyDetails?.partyAddress ?? null
                formData.value.dispatchCountry = res.data.data?.partyDetails?.partyCountry.value  ?? null
                formData.value.dispatchCountryName = res.data.data?.partyDetails?.partyCountry.label  ?? null
                formData.value.dispatchState = res.data.data?.partyDetails?.partyState.value  ?? null
                formData.value.dispatchStateName = res.data.data?.partyDetails?.partyState.label  ?? null
                formData.value.dispatchCity = res.data.data?.partyDetails?.partyCity.value  ?? null
                formData.value.dispatchCityName = res.data.data?.partyDetails?.partyCity.label  ?? null
                formData.value.dispatchFaxNo = res.data.data?.partyAddress?.partyFaxNo  ?? null
                formData.value.dispatchEmailId = res.data.data?.partyDetails?.partyEmilId  ?? null
                formData.value.dispatchWebSite = res.data.data?.partyDetails?.partyWebsite  ?? null
                formData.value.dispatchPinCode = res.data.data?.partyDetails?.partyPinCode  ?? null
                formData.value.dispatchPhoneCountry = res.data.data?.partyDetails?.partyCountryCode  ?? '+91'
                formData.value.dispatchPhoneNo = res.data.data?.partyDetails?.partyPhoneNo  ?? null
                formData.value.dispatchTinVatNo = res.data.data?.taxDetails?.tinVatNo  ?? null
                formData.value.dispatchTinCstNo = res.data.data?.taxDetails?.tinCstNo  ?? null
                formData.value.dispatchEccNo = res.data.data?.taxDetails?.eccNo  ?? null
                formData.value.dispatchGstinNo = res.data.data?.taxDetails?.gstin  ?? null
                formData.value.dispatchPanNo = res.data.data?.taxDetails?.panNo  ?? null

                axios.get(`/api/state-master/${formData.value.dispatchState}`).then((stateRes) => {
                    formData.value.dispatchStateCode = stateRes.data.data.stateCode
                });
            });
            await getKindAttnOptions(id)
        }

        const getKindAttnOptions = async (id) => {
            await axios.get('/api/party/get-party-contacts-options/'+id).then((res) => {
                KindAttnOptions.value = res.data.data
            });
        }
        setTimeout(() => {
            getKindAttnOptions(formData.value.dispatchCode)
        }, 2000)

        const getContactDetail = async (id) => {
            if (id) {
                await axios.get(`/api/party/contact-person/${id}`).then(res => {
                    formData.value.dispatchKindAttnId = res.data.data._id
                    formData.value.dispatchKindAttnName = res.data.data.personName
                    formData.value.dispatchKindAttnMobile = res.data.data.mobileNo
                    formData.value.dispatchKindAttnEmail = res.data.data.email
                });
            } else {
                formData.value.dispatchKindAttnId = null
                formData.value.dispatchKindAttnName = null
                formData.value.dispatchKindAttnMobile = null
                formData.value.dispatchKindAttnEmail = null
            }
        }

        const saveFormData = async () => {
            let submitData = {
                _id: router.currentRoute.params.id,
                dispatchDetails: formData.value
            }
            await store.dispatch('purchase-store-module/updatePurchaseReturn', submitData).then((res) => {
                if (res.status === 200) {
                    toast({
                        component: ToastificationContent,
                        position: 'top-right',
                        props: {
                            title: 'Purchase Return Dispatch Updated',
                            icon: 'CheckSquareIcon',
                            variant: 'success',
                            text: 'You have successfully Updated Purchase Return Dispatch',
                        },
                    });
                } else {
                    toast({
                        component: ToastificationContent,
                        position: 'top-right',
                        props: {
                            title: 'Error',
                            icon: 'AlertCircleIcon',
                            variant: 'danger',
                            text: 'Something went wrong',
                        },
                    });
                }
            }).catch(() => {
                toast({
                    component: ToastificationContent,
                    position: 'top-right',
                    props: {
                        title: 'Error',
                        icon: 'AlertCircleIcon',
                        variant: 'danger',
                        text: 'Internal server error',
                    },
                });
            });
        }

        const {refFormObserver, getValidationState, resetForm} = formValidation(resetFormData)

        return{
            formData,
            saveFormData,
            partyCodeOptions,
            countryOptions,
            stateOptions,
            cityOptions,
            refFormObserver,
            resetForm,
            resetFormData,
            getValidationState,
            getPartyDetails,
            KindAttnOptions,
            getKindAttnOptions,
            getContactDetail,
            getCityDetails
        }
    }
}
</script>
