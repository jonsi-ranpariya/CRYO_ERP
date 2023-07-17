<template>
    <div>
        <b-row>
            <b-col md="12">
                <hr>
                <h4>Buyer Details</h4>
                <hr>
            </b-col>
        </b-row>
        <validation-observer ref="simpleRules">
            <b-form>
                <b-row>
                    <b-col md="6">
                        <b-form-group
                            label="Select Party"
                            label-for="buyerDetailId"
                        >
                            <v-select
                                v-model="piBuyerTabData.buyerDetailId"
                                placeholder="Select Party"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="piPartyList"
                                :reduce="val => val.value"
                                :clearable="true"
                                @input="getPartyCodeBuyer(piBuyerTabData.buyerDetailId)"
                                input-id="buyerDetailId"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="6">
                        <b-form-group
                            label="buyer Name"
                            label-for="buyerDetailName"
                        >
                            <b-form-input
                                id="buyerDetailName"
                                v-model="piBuyerTabData.buyerDetailName"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="6">
                        <b-form-group
                            label="Address"
                            label-for="buyerDetailAddress"
                        >
                            <b-form-textarea
                                id="buyerDetailAddress"
                                v-model="piBuyerTabData.buyerDetailAddress"
                                rows="1"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="6">
                        <b-form-group
                            label="Phone No"
                            label-for="consigneeDetailPhoneNo"
                        >  <b-input-group>
                            <b-input-group-prepend>
                                <b-form-input
                                    v-model="piBuyerTabData.buyerDetailPhoneStdCode"
                                />
                            </b-input-group-prepend>
                            <b-form-input
                                id="consigneeDetailPhoneNo"
                                v-model="piBuyerTabData.buyerDetailPhoneNo"
                            />
                        </b-input-group>
                        </b-form-group>
                    </b-col>
                    <b-col md="3">
                        <b-form-group
                            label="District"
                            label-for="buyerDetailDistrict"
                        >
                            <v-select
                                v-model="piBuyerTabData.buyerDetailCityId"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="cityOptions"
                                :reduce="val => val.value"
                                :clearable="false"
                                input-id="buyerDetailDistrict"
                                placeholder="Select District"
                                no-data-text
                                @input="getCityDetails($event)"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="3">
                        <b-form-group
                            label="State"
                            label-for="buyerDetailState"
                        >
                            <v-select
                                v-model="piBuyerTabData.buyerDetailStateId"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="stateOptions"
                                :reduce="val => val.value"
                                :clearable="false"
                                input-id="buyerDetailState"
                                placeholder="Select State"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="3">
                        <b-form-group
                            label="Country"
                            label-for="buyerDetailCountry"
                        >
                            <v-select
                                v-model="piBuyerTabData.buyerDetailCountryID"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="countryOptions"
                                :reduce="val => val.value"
                                :clearable="false"
                                input-id="buyerDetailCountry"
                                placeholder="Select Country"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="3">
                        <b-form-group
                            label="Pin Code"
                            label-for="buyerDetailPinCode"
                        >
                            <b-form-input
                                id="buyerDetailPinCode"
                                v-model="piBuyerTabData.buyerDetailPinCode"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="4">
                        <b-form-group
                            label="Fax No"
                            label-for="buyerDetailFaxNo"
                        >
                            <b-form-input
                                id="buyerDetailFaxNo"
                                v-model="piBuyerTabData.buyerDetailFaxNo"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="4">
                        <b-form-group
                            label="Email ID"
                            label-for="buyerDetailEmailId"
                        >
                            <b-form-input
                                id="buyerDetailEmailId"
                                v-model="piBuyerTabData.buyerDetailEmailId"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="4">
                        <b-form-group
                            label="Website"
                            label-for="buyerDetailWebsite"
                        >
                            <b-form-input
                                id="buyerDetailWebsite"
                                v-model="piBuyerTabData.buyerDetailWebsite"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="3">
                        <b-form-group
                            label="GST No"
                            label-for="buyerDetailGstNo"
                        >
                            <b-form-input
                                id="buyerDetailGstNo"
                                v-model="piBuyerTabData.buyerDetailGstNo"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="3">
                        <b-form-group
                            label="Tin Vat No"
                            label-for="buyerDetailTinVatNO"
                        >
                            <b-form-input
                                id="buyerDetailTinVatNO"
                                v-model="piBuyerTabData.buyerDetailTinVatNO"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="3">
                        <b-form-group
                            label="Tin CST No"
                            label-for="buyerDetailTinCstNO"
                        >
                            <b-form-input
                                id="buyerDetailTinCstNO"
                                v-model="piBuyerTabData.buyerDetailTinCstNO"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="3">
                        <b-form-group
                            label="ECC No"
                            label-for="buyerDetailTinEccNO"
                        >
                            <b-form-input
                                id="buyerDetailTinEccNO"
                                v-model="piBuyerTabData.buyerDetailTinEccNO"
                            />
                        </b-form-group>
                    </b-col>
                </b-row>
                <b-row>
                    <!-- submit and reset -->
                    <b-col>
                        <b-button
                            v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                            type="submit"
                            variant="primary"
                            class="mr-1"
                            @click.prevent="validationForm"
                        >
                            Add / Save Buyer Detail
                        </b-button>
                    </b-col>
                </b-row>
            </b-form>
        </validation-observer>

    </div>
</template>
<script>
    import BCardCode from '@core/components/b-card-code'
    import {ValidationProvider, ValidationObserver} from 'vee-validate'
    import {
        BRow,
        BCol,
        BFormGroup,
        BFormInput,
        BFormCheckbox,
        BFormTextarea,
        BForm,
        BDropdown,
        BDropdownItem,
        BButton,
        BFormDatepicker,
        BOverlay,
        BTable,
        BInputGroup,
        BInputGroupPrepend
    } from 'bootstrap-vue'
    import {required} from '@validations'
    import Ripple from 'vue-ripple-directive'
    import vSelect from 'vue-select'
    import router from '@/router'
    import store from '@/store'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import {ref, onUnmounted} from '@vue/composition-api'
    import salesStoreModule from '../../salesStoreModule'
    import axios from '@axios'

    export default {
        components: {
            BCardCode,
            ValidationProvider,
            ValidationObserver,
            BRow,
            BCol,
            BFormGroup,
            BFormCheckbox,
            BFormInput,
            BFormTextarea,
            BForm,
            BButton,
            BDropdown,
            BDropdownItem,
            BFormDatepicker,
            vSelect,
            BOverlay,
            BTable,
            BInputGroup,
            BInputGroupPrepend
        },
        directives: {
            Ripple,
        },
        methods: {
            validationForm() {
                this.$refs.simpleRules.validate().then(success => {
                    if (success) {
                        const SubmitFormData = {
                            id: this.CurrentPiId,
                            buyerDetail: this.piBuyerTabData,
                        }
                        store.dispatch('pi-buyer-module/updateProformaInvoice', SubmitFormData).then(response => {
                            if (response.status === 200) {
                                this.$toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: 'Buyer Edited',
                                        icon: 'CheckSquareIcon',
                                        variant: 'success',
                                        text: `You have successfully Edited Buyer Detail`,
                                    },
                                })
                            }
                        })
                    }
                })
            },
            containsKey(obj, key) {
                return Object.keys(obj).includes(key)
            },
        },
        props: {
            piBuyerTabData: {
                type: Object,
                required: true,
            },
            piPartyList: {
                type: Array,
                required: true,
            },
        },
        setup(props) {

            const PIBUYER_APP_STORE_MODULE_NAME = 'pi-buyer-module'
            // Register module
            if (!store.hasModule(PIBUYER_APP_STORE_MODULE_NAME)) store.registerModule(PIBUYER_APP_STORE_MODULE_NAME, salesStoreModule)
            // UnRegister on leave
            onUnmounted(() => {
                if (store.hasModule(PIBUYER_APP_STORE_MODULE_NAME)) store.unregisterModule(PIBUYER_APP_STORE_MODULE_NAME)
            })

            const getCityDetails = async (cityId) => {
                await axios.get(`/api/city-master/${cityId}`).then((res) => {
                    props.piBuyerTabData.buyerDetailState = res.data.data.state
                    props.piBuyerTabData.buyerDetailStateId = res.data.data?.state_detail?.label ?? null
                    props.piBuyerTabData.buyerDetailCountry = res.data.data.country
                    props.piBuyerTabData.buyerDetailCountryID = res.data.data?.country_detail?.label ?? null
                });
            }

            const CurrentPiId = ref(router.currentRoute.params.id)
            const countryOptions = ref([])
            const stateOptions = ref([])
            const cityOptions = ref([])

            axios.get('/api/get-country-options').then(res => {
                countryOptions.value = res.data.data
            })

            axios.get('/api/get-state-options').then(res => {
                stateOptions.value = res.data.data
            })

            axios.get('/api/get-city-options').then(res => {
                cityOptions.value = res.data.data
            })


            const getPartyCodeBuyer = async (val) => {
                if (val) {

                    await axios.get(`/api/party/edit/${val}`).then(res => {


                        props.piBuyerTabData.buyerDetailId = val
                        props.piBuyerTabData.buyerDetailCode = res.data.data.partyCode
                        props.piBuyerTabData.buyerDetailName = res.data.data.partyName
                        if (res.data.data.partyDetails) {
                            props.piBuyerTabData.buyerDetailAddress = res.data.data.partyDetails.partyAddress
                            if (res.data.data.partyDetails.partyCity) {
                                props.piBuyerTabData.buyerDetailCityId = res.data.data.partyDetails.partyCity.value
                                props.piBuyerTabData.buyerDetailCity = res.data.data.partyDetails.partyCity.label
                            }
                            if (res.data.data.partyDetails.partyState) {
                                props.piBuyerTabData.buyerDetailStateId = res.data.data.partyDetails.partyState.value
                                props.piBuyerTabData.buyerDetailState = res.data.data.partyDetails.partyState.label
                            }
                            if (res.data.data.partyDetails.partyCountry) {
                                props.piBuyerTabData.buyerDetailCountryID = res.data.data.partyDetails.partyCountry.value
                                props.piBuyerTabData.buyerDetailCountry = res.data.data.partyDetails.partyCountry.label
                            }
                            props.piBuyerTabData.buyerDetailFaxNo = res.data.data.partyDetails.partyFaxNo
                            props.piBuyerTabData.buyerDetailEmailId = res.data.data.partyDetails.partyEmilId
                            props.piBuyerTabData.buyerDetailWebsite = res.data.data.partyDetails.partyWebsite
                            props.piBuyerTabData.buyerDetailPinCode = res.data.data.partyDetails.partyPinCode
                            props.piBuyerTabData.buyerDetailPhoneStdCode = res.data.data.partyDetails.partyCountryCode
                            props.piBuyerTabData.buyerDetailPhoneNo = res.data.data.partyDetails.partyPhoneNo
                        }
                        if (res.data.data.taxDetails) {
                            props.piBuyerTabData.buyerDetailGstNo = res.data.data.taxDetails.gstin
                            props.piBuyerTabData.buyerDetailTinVatNO = res.data.data.taxDetails.tinVatNo
                            props.piBuyerTabData.buyerDetailTinCstNO = res.data.data.taxDetails.tinCstNo
                            props.piBuyerTabData.buyerDetailTinEccNO = res.data.data.taxDetails.eccNo
                        }

                    })
                }
            }

            return {
                CurrentPiId,
                countryOptions,
                stateOptions,
                cityOptions,
                getPartyCodeBuyer,
                required,
                getCityDetails
            }
        },
    }
</script>

<style lang="scss">
    @import '~@core/scss/vue/libs/vue-select.scss';
</style>
