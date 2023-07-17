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
                                v-model="soBuyerTabData.buyerDetailId"
                                taggable
                                push-tags
                                placeholder="Select Party"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="soPartyList"
                                :reduce="val => val.value"
                                :clearable="true"
                                @input="getPartyCodeBuyer(soBuyerTabData.buyerDetailId)"
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
                                v-model="soBuyerTabData.buyerDetailName"
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
                                v-model="soBuyerTabData.buyerDetailAddress"
                                rows="1"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="6">
                        <b-form-group
                            label="Phone No"
                            label-for="buyerDetailPhoneNo"
                        >
                            <b-input-group>
                                <b-input-group-prepend>
                                    <b-form-input
                                        v-model="soBuyerTabData.buyerDetailPhoneStdCode"
                                    />
                                </b-input-group-prepend>
                                <b-form-input
                                    id="buyerDetailPhoneNo"
                                    v-model="soBuyerTabData.buyerDetailPhoneNo"
                                />
                            </b-input-group>
                        </b-form-group>
                    </b-col>
                    <b-col md="3">
                        <b-form-group
                            label="District"
                            label-for="buyerDetailCity"
                        >
                            <v-select
                                v-model="soBuyerTabData.buyerDetailCityId"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="cityOptions"
                                :reduce="val => val.value"
                                :clearable="false"
                                input-id="buyerDetailCity"
                                placeholder="Select District"
                                no-data-text
                                @input="getBuyerStateCountry($event)"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="3">
                        <b-form-group
                            label="State"
                            label-for="buyerDetailState"
                        >
                            <v-select
                                v-model="soBuyerTabData.buyerDetailStateId"
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
                                v-model="soBuyerTabData.buyerDetailCountryID"
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
                                v-model="soBuyerTabData.buyerDetailPinCode"
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
                                v-model="soBuyerTabData.buyerDetailFaxNo"
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
                                v-model="soBuyerTabData.buyerDetailEmailId"
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
                                v-model="soBuyerTabData.buyerDetailWebsite"
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
                                v-model="soBuyerTabData.buyerDetailGstNo"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="3">
                        <b-form-group
                            label="Pan No"
                            label-for="buyerDetailPanNo"
                        >
                            <b-form-input
                                id="buyerDetailPanNo"
                                v-model="soBuyerTabData.buyerDetailPanNo"
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
                                v-model="soBuyerTabData.buyerDetailTinVatNO"
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
                                v-model="soBuyerTabData.buyerDetailTinCstNO"
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
        BInputGroup,
        BInputGroupPrepend,
        BFormCheckbox,
        BFormTextarea,
        BForm,
        BDropdown,
        BDropdownItem,
        BButton,
        BFormDatepicker,
        BOverlay,
        BTable
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
            BInputGroupPrepend,
        },
        directives: {
            Ripple,
        },
        methods: {
            validationForm() {
                this.$refs.simpleRules.validate().then(success => {
                    if (success) {
                        const SubmitFormData = {
                            id: this.CurrentSalesOrderId,
                            buyerDetail: this.soBuyerTabData,
                        }
                        store.dispatch('sales-order-module/updateSalesOrder', SubmitFormData).then(response => {
                            if (response.status === 200) {
                                this.$toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: 'Buyer Edited',
                                        icon: 'CheckSquareIcon',
                                        variant: 'success',
                                        text: `You have successfully Edited Sales Order Buyer Detail`,
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
            soBuyerTabData: {
                type: Object,
                required: true,
            },
            soPartyList: {
                type: Array,
                required: true,
            },
        },
        setup(props) {

            const SO_APP_STORE_MODULE_NAME = 'sales-order-module'
            // Register module
            if (!store.hasModule(SO_APP_STORE_MODULE_NAME)) store.registerModule(SO_APP_STORE_MODULE_NAME, salesStoreModule)
            const CurrentSalesOrderId = ref(router.currentRoute.params.id)
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

            const getBuyerStateCountry = async (cityId) => {
                await axios.get(`/api/city-master/${cityId}`).then((res) => {
                    props.soBuyerTabData.buyerDetailState = res.data.data.state
                    props.soBuyerTabData.buyerDetailStateId = res.data.data?.state_detail?.label ?? null
                    props.soBuyerTabData.buyerDetailCountry = res.data.data.country
                    props.soBuyerTabData.buyerDetailCountryID = res.data.data?.country_detail?.label ?? null
                });
            }

            const getPartyCodeBuyer = async (val) => {
                if (val) {
                    await axios.get(`/api/party/edit/${val}`).then(res => {
                        props.soBuyerTabData.buyerDetailCode = res.data.data.partyCode
                        props.soBuyerTabData.buyerDetailName = res.data.data.partyName
                        if (res.data.data.partyDetails) {
                            props.soBuyerTabData.buyerDetailAddress = res.data.data.partyDetails.partyAddress
                            if (res.data.data.partyDetails.partyCity) {
                                props.soBuyerTabData.buyerDetailCityId = res.data.data.partyDetails.partyCity.value
                                props.soBuyerTabData.buyerDetailCity = res.data.data.partyDetails.partyCity.label
                            }
                            if (res.data.data.partyDetails.partyState) {
                                props.soBuyerTabData.buyerDetailStateId = res.data.data.partyDetails.partyState.value
                                props.soBuyerTabData.buyerDetailState = res.data.data.partyDetails.partyState.label
                            }
                            if (res.data.data.partyDetails.partyCountry) {
                                props.soBuyerTabData.buyerDetailCountryID = res.data.data.partyDetails.partyCountry.value
                                props.soBuyerTabData.buyerDetailCountry = res.data.data.partyDetails.partyCountry.label
                            }
                            props.soBuyerTabData.buyerDetailFaxNo = res.data.data.partyDetails.partyFaxNo
                            props.soBuyerTabData.buyerDetailEmailId = res.data.data.partyDetails.partyEmilId
                            props.soBuyerTabData.buyerDetailWebsite = res.data.data.partyDetails.partyWebsite
                            props.soBuyerTabData.buyerDetailPinCode = res.data.data.partyDetails.partyPinCode
                            props.soBuyerTabData.buyerDetailPhoneStdCode = res.data.data.partyDetails.partyCountryCode
                            props.soBuyerTabData.buyerDetailPhoneNo = res.data.data.partyDetails.partyPhoneNo
                        }
                        if (res.data.data.taxDetails) {
                            props.soBuyerTabData.buyerDetailGstNo = res.data.data.taxDetails.gstin
                            props.soBuyerTabData.buyerDetailTinVatNO = res.data.data.taxDetails.tinVatNo
                            props.soBuyerTabData.buyerDetailTinCstNO = res.data.data.taxDetails.tinCstNo
                            props.soBuyerTabData.buyerDetailTinEccNO = res.data.data.taxDetails.eccNo
                            props.soBuyerTabData.buyerDetailPanNo = res.data.data.taxDetails.panNo
                        }
                    })
                }
            }

            return {
                CurrentSalesOrderId,
                countryOptions,
                stateOptions,
                cityOptions,
                getPartyCodeBuyer,
                // getStatesData,
                // getCityData,
                getBuyerStateCountry,
                required,
            }
        },
    }
</script>

<style lang="scss">
    @import '~@core/scss/vue/libs/vue-select.scss';
</style>
