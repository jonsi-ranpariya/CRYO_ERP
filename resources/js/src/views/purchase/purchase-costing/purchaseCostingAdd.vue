<template>
    <div>
        <b-card-code>
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
                                    label-for="pcPartyCode"
                                >
                                    <v-select
                                        placeholder="Select Code"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="partyCodeOptions"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        input-id="pcPartyCode"
                                        v-model="formData.pcPartyCode"
                                        @input="getPartyDetails($event)"
                                        :state="getValidationState(validationContext)"
                                    />
                                </b-form-group>
                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </validation-provider>
                            <validation-provider
                                #default="validationContext"
                                name="Party Name"
                                rules="required"
                            >
                                <b-form-group
                                    label="Party Name"
                                    label-for="pcPartyName"
                                >
                                    <b-form-input
                                        id="pcPartyName"
                                        v-model="formData.pcPartyName"
                                        :state="getValidationState(validationContext)"
                                    />
                                </b-form-group>
                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </validation-provider>
                            <b-form-group
                                label="Item Code"
                                label-for="pcItemCode"
                            >
                                <v-select
                                    v-model="formData.pcItemCode"
                                    placeholder="Select itemCode"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="itemCodeOption"
                                    :reduce="val => val.value"
                                    :clearable="false"
                                    input-id="pcItemCode"
                                    @input="changeItemDescription($event)"
                                />
                            </b-form-group>
                            <b-form-group
                                label="Item Description"
                                label-for="pcItemDescription"
                            >
                                <b-form-input
                                    v-model="formData.pcItemDescription"
                                    id="pcItemDescription"
                                    readonly
                                />
                            </b-form-group>
                        </b-col>
                        <b-col md="6">
                            <b-form-group
                                label="District"
                                label-for="pcDistrict"
                            >
                                <v-select
                                    placeholder="Select District"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="cityOptions"
                                    :reduce="val => val.value"
                                    :clearable="false"
                                    input-id="pcDistrict"
                                    v-model="formData.pcCity"
                                    disabled
                                />
                            </b-form-group>
                            <b-form-group
                                label="Drawing No."
                                label-for="pcDrawingNo"
                            >
                                <b-form-input
                                    v-model="formData.pcDrawingNo"
                                    id="pcDrawingNo"
                                    type="number"
                                    readonly
                                />
                            </b-form-group>
                            <b-form-group
                                label="Drawing Revision"
                                label-for="pcDrawingRev"
                            >
                                <b-form-input
                                    id="pcDrawingRev"
                                    v-model="formData.pcDrawingRev"
                                    type="number"
                                    readonly
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
        </b-card-code>
        <!-- Tabs -->
        <b-card-code>
            <b-tabs pills>
                <b-tab active>
                    <template #title>
                        <feather-icon
                            icon="UsersIcon"
                            size="16"
                            class="mr-0 mr-sm-50"
                        />
                        <span class="d-none d-sm-inline">Party Details</span>
                    </template>
                    <hr>
                    <party-details-tab
                        :partyDetails="formData.partyDetails"
                    />
                </b-tab>
            </b-tabs>
        </b-card-code>
    </div>
</template>
<script>
    import BCardCode from "../../../@core/components/b-card-code/BCardCode";
    import {
        BForm,
        BRow,
        BCol,
        BFormGroup,
        BFormInput,
        BFormInvalidFeedback,
        BTabs,
        BTab,
        BButton,
    } from 'bootstrap-vue'
    import {ValidationObserver, ValidationProvider} from 'vee-validate'
    //validation
    import formValidation from '@core/comp-functions/forms/form-validation'
    import {onUnmounted, ref} from "@vue/composition-api";
    import VSelect from 'vue-select'
    import partyDetailsTab from "./tabs/partyDetailsTab"
    import axios from '@axios'
    import router from '@/router'
    import Ripple from "vue-ripple-directive";
    import {required} from '@validations'
    import purchaseStoreModule from "../purchaseStoreModule";
    import {useToast} from "vue-toastification/composition";
    import store from '@/store'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'

    export default {
        components: {
            BCardCode,
            ValidationObserver,
            ValidationProvider,
            BForm,
            BRow,
            BCol,
            BFormGroup,
            BFormInput,
            BFormInvalidFeedback,
            VSelect,
            BTabs,
            BTab,
            BButton,
            partyDetailsTab,
        },
        directives: {
            Ripple,
        },
        setup() {
            const toast = useToast()

            const ITEMADDON_APP_STORE_MODULE_NAME = 'purchase-store-module'
            if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, purchaseStoreModule)
            onUnmounted(() => {
                if (store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.unregisterModule(ITEMADDON_APP_STORE_MODULE_NAME)
            })

            const partyCodeOptions = ref([])
            axios.get('/api/party/get-master-options').then(res => {
                partyCodeOptions.value = res.data.data
            })

            const itemCodeOption = ref([])
            axios.get('/api/get-item-master-options').then(res => {
                itemCodeOption.value = res.data.data
            })

            const cityOptions = ref([])
            axios.get('/api/get-city-options').then(res => {
                cityOptions.value = res.data.data
            })
            const changeItemDescription = async (id) => {
                await axios.get(`/api/item-master/${id}`).then(res => {
                    formData.value.pcItemDescription = res.data.data?.itemDescription ?? null
                    formData.value.pcDrawingNo = res.data.data?.itemDetails?.drawingNumber ?? null
                    formData.value.pcDrawingRev = res.data.data?.itemDetails?.revision ?? null
                })
            }

            const getPartyDetails = async (id) => {
                await axios.get(`/api/party/edit/${id}`).then(res => {
                    formData.value.pcPartyName = res.data.data?.partyName ?? null
                    formData.value.pcCity = res.data.data?.partyDetails?.partyCity?.value ?? null
                    formData.value.partyDetails.partyCode = res.data.data?.partyCode ?? null
                    formData.value.partyDetails.partyName = res.data.data?.partyName ?? null
                    formData.value.partyDetails.partyAddress = res.data.data?.partyDetails?.partyAddress ?? null
                    formData.value.partyDetails.partyCountry = res.data.data?.partyDetails?.partyCountry?.value ?? null
                    formData.value.partyDetails.partyState = res.data.data?.partyDetails?.partyState?.value ?? null
                    formData.value.partyDetails.partyCity = res.data.data?.partyDetails?.partyCity?.value ?? null
                    formData.value.partyDetails.partyFaxNo = res.data.data?.partyDetails?.partyFaxNo ?? null
                    formData.value.partyDetails.partyEmailId = res.data.data?.partyDetails?.partyEmilId ?? null
                    formData.value.partyDetails.partyWebSite = res.data.data?.partyDetails?.partyWebsite ?? null
                    formData.value.partyDetails.partyPinCode = res.data.data?.partyDetails?.partyPinCode ?? null
                    formData.value.partyDetails.partyPhoneCountry = res.data.data?.partyDetails?.partyCountryCode ?? null
                    formData.value.partyDetails.partyPhoneNo = res.data.data?.partyDetails?.partyPhoneNo ?? null
                })
            }

            const blankFormData = {
                pcPartyCode: null,
                pcPartyName: null,
                pcItemCode: null,
                pcItemDescription: null,
                pcCity: null,
                pcDrawingNo: null,
                pcDrawingRev: null,
                partyDetails: {
                    partyCode: null,
                    partyName: null,
                    partyAddress: null,
                    partyCountry: null,
                    partyState: null,
                    partyCity: null,
                    partyFaxNo: null,
                    partyEmailId: null,
                    partyWebSite: null,
                    partyPinCode: null,
                    partyPhoneCountry: '+91',
                    partyPhoneNo: null,
                },
            }

            const formData = ref(JSON.parse(JSON.stringify(blankFormData)))

            const resetFormData = () => {
                formData.value = JSON.parse(JSON.stringify(blankFormData))
            }

            const saveFormData = async () => {
                await store.dispatch('purchase-store-module/addPurchaseCosting', formData.value).then(res => {
                    if (res.status === 200) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Purchase Costing Added',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: `You have successfully Added Costing.`,
                            },
                        })
                    } else {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Error',
                                icon: 'AlertCircleIcon',
                                variant: 'danger',
                                text: 'Something went wrong!',
                            },
                        })
                    }
                    router.push({
                        name: 'edit-purchase-costing',
                        params: {
                            id: res.data.data._id
                        }
                    })
                })
            }
            const {refFormObserver, getValidationState, resetForm} = formValidation(resetFormData)
            return {
                //validation
                formData,
                required,
                getValidationState,
                resetForm,
                refFormObserver,
                resetFormData,
                saveFormData,
                //dropdown
                partyCodeOptions,
                itemCodeOption,
                cityOptions,
                getPartyDetails,
                changeItemDescription,
            }
        },
    }
</script>
