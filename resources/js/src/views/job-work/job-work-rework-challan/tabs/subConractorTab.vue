<template>
    <div>
        <validation-observer #default="{ handleSubmit }">
            <b-form @submit.prevent="handleSubmit(saveFormData)">
                <b-row>
                    <b-col md="6">
                        <validation-provider
                            #default="validationContext"
                            name="Sub-Contractor Code"
                            rules="required"
                        >
                            <b-form-group
                                label="Sub-Contractor Code"
                                label-for="subContractorCode"
                            >
                                <v-select
                                    placeholder="Select Code"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="subContractorOptions"
                                    :reduce="val => val.value"
                                    :clearable="false"
                                    input-id="subContractorCode"
                                    v-model="formData.subContractorCode"
                                    @input="getSubContrctorDetail($event)"
                                    :state="getValidationState(validationContext)"
                                />
                            </b-form-group>
                            <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                {{validationContext.errors [0]}}
                            </b-form-invalid-feedback>
                        </validation-provider>
                        <validation-provider
                            #default="validationContext"
                            name="Sub-Contractor Name"
                            rules="required"
                        >
                            <b-form-group
                                label="Sub-Contractor Name"
                                label-for="subContractorName"
                            >
                                <b-form-input
                                    id="subContractorName"
                                    :state="getValidationState(validationContext)"
                                    v-model="formData.subContractorName"
                                />
                            </b-form-group>
                            <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </validation-provider>
                        <b-form-group
                            label="Address"
                            label-for="contractorAddress"
                        >
                            <b-form-textarea
                                id="address"
                                v-model="formData.contractorAddress"
                                rows="2"
                            />
                        </b-form-group>
                        <b-form-group
                            label="District"
                            label-for="contractorCity"
                        >
                            <v-select
                                placeholder="Select District"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="cityOptions"
                                :reduce="val => val.value"
                                :clearable="false"
                                input-id="city"
                                v-model="formData.contractorCity"
                                @input="getCityDetails($event)"
                            />
                        </b-form-group>
                        <b-form-group
                            label="State"
                            label-for="contractorState"
                        >
                            <v-select
                                placeholder="Select State"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="stateOptions"
                                :reduce="val => val.value"
                                :clearable="false"
                                input-id="state"
                                v-model="formData.contractorState"
                            />
                        </b-form-group>
                        <b-form-group
                            label="Country"
                            label-for="contractorCountry"
                        >
                            <v-select
                                placeholder="Select Country"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="countryOptions"
                                :reduce="val => val.value"
                                :clearable="false"
                                input-id="country"
                                v-model="formData.contractorCountry"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="6">
                        <b-form-group
                            label="Fax No."
                            label-for="contractorFaxNo"
                        >
                            <b-form-input
                                id="faxNo"
                                v-model="formData.contractorFaxNo"
                            />
                        </b-form-group>
                        <b-form-group
                            label="E-mail ID"
                            label-for="ContractorEmailId"
                        >
                            <b-form-input
                                id="emailId"
                                v-model="formData.ContractorEmailId"
                            />
                        </b-form-group>
                        <b-form-group
                            label="Website"
                            label-for="contractorWebsite"
                        >
                            <b-form-input
                                id="website"
                                v-model="formData.contractorWebsite"
                            />
                        </b-form-group>

                        <b-form-group
                            label="Pin-Code"
                            label-for="contractorPinCode"
                        >
                            <b-form-input
                                id="pinCode"
                                v-model="formData.contractorPinCode"
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
                                        v-model="formData.contraPhoneCountry"
                                    />
                                </b-input-group-prepend>
                                <b-form-input
                                    id="party-phone"
                                    placeholder="Party Phone"
                                    v-model="formData.contraPhoneNo"
                                />
                            </b-input-group>
                        </b-form-group>
                    </b-col>
                    <!--Button-->
                    <b-col md="12">
                        <hr>
                        <b-button
                            variant="primary"
                            type="submit"
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
        BFormInvalidFeedback,
        BFormTextarea,
        BInputGroupPrepend,
        BInputGroup,
        BButton
    } from 'bootstrap-vue'
    import {ValidationObserver, ValidationProvider} from 'vee-validate'
    import {ref, computed} from '@vue/composition-api'
    import vSelect from 'vue-select'
    import {required} from '@validations'
    import formValidation from "../../../../@core/comp-functions/forms/form-validation";
    import axios from '@axios'
    import countryCode from '@/@fake-db/data/other/country-code'
    import {useToast} from "vue-toastification/composition";
    import jobWorkStoreModule from "../../jobWorkStoreModule";
    import store from '@/store'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import router from '@/router'

    export default {
        components: {
            ValidationObserver,
            ValidationProvider,
            vSelect,
            BForm,
            BRow,
            BCol,
            BFormGroup,
            BFormInput,
            BFormInvalidFeedback,
            BFormTextarea,
            BInputGroupPrepend,
            BInputGroup,
            BButton
        },
        props: {
            subContractorDetail: {
                type: Object,
                required: true,
            }
        },
        computed: {
            countryCode: () => countryCode
        },
        setup(props) {
            const toast = useToast()

            const ITEMADDON_APP_STORE_MODULE_NAME = 'raw-material-store-module'
            if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, jobWorkStoreModule)

            const subContractorOptions = ref([])
            axios.get('/api/party/get-master-options').then(res => {
                subContractorOptions.value = res.data.data
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
                    formData.value.contractorState = res.data.data.state
                    formData.value.contractorCountry = res.data.data.country
                });
            }
            const getSubContrctorDetail = async (id) => {
                await axios.get(`/api/party/edit/${id}`).then(res => {
                    formData.value.subContractorName = res.data.data.partyName ?? null
                    formData.value.contractorAddress = res.data.data?.partyDetails?.partyAddress ?? null
                    formData.value.contractorCountry = res.data.data?.partyDetails?.partyCountry?.value ?? null
                    formData.value.contractorState = res.data.data?.partyDetails?.partyState?.value ?? null
                    formData.value.contractorCity = res.data.data?.partyDetails?.partyCity?.value ?? null
                    formData.value.contractorFaxNo = res.data.data?.partyDetails?.partyFaxNo ?? null
                    formData.value.ContractorEmailId = res.data.data?.partyDetails?.partyEmilId ?? null
                    formData.value.contractorWebsite = res.data.data?.partyDetails?.partyWebsite ?? null
                    formData.value.contractorPinCode = res.data.data?.partyDetails?.partyPinCode ?? null
                    formData.value.contraPhoneCountry = res.data.data?.partyDetails?.partyCountryCode ?? null
                    formData.value.contraPhoneNo = res.data.data?.partyDetails?.partyPhoneNo ?? null
                })
            }

            const formData = computed(() => props.subContractorDetail)

            const resetFormData = () => {
                formData.value = JSON.parse(JSON.stringify(formData.value))
            }
            const saveFormData = async () => {
                let sendData = {
                    _id: router.currentRoute.params.id,
                    subContractorDetails: formData.value
                }
                await store.dispatch('raw-material-store-module/updateRawMaterial', sendData).then(res =>{
                    if (res.status === 200) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Raw Material Sub-Contractor Details Updated',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: 'You have successfully Updated Raw Material Sub-Contractor Details.',
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
                    router.push({name: 'raw-material-return-sub-contractor'})
                })
            }
            const {refFormObserver, getValidationState, resetForm} = formValidation(resetFormData)
            return {
                formData,
                resetFormData,
                resetForm,
                getValidationState,
                refFormObserver,
                subContractorOptions,
                saveFormData,
                required,
                countryOptions,
                stateOptions,
                cityOptions,
                getSubContrctorDetail,
                getCityDetails
            }
        }

    }
</script>
