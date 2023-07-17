<template>
    <div>
        <b-row>
            <b-col md="12">
                <hr>
                <h4>Dispatch Details</h4>
                <hr>
            </b-col>
        </b-row>
        <validation-observer ref="simpleRules">
            <b-form>
                <b-row>
                    <b-col md="6">
                        <b-form-group
                            label="Select Party"
                            label-for="consigneeDetailId"
                        >
                            <v-select
                                v-model="soDispatchTabData.dispatchDetailId"
                                taggable
                                push-tags
                                placeholder="Select Party"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="soPartyList"
                                :reduce="val => val.value"
                                :clearable="true"
                                @input="getPartyCodeDispatch(soDispatchTabData.dispatchDetailId)"
                                input-id="consigneeDetailId"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="6">
                        <b-form-group
                            label="Dispatch Name"
                            label-for="dispatchDetailName"
                        >
                            <b-form-input
                                id="dispatchDetailName"
                                v-model="soDispatchTabData.dispatchDetailName"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="6">
                        <b-form-group
                            label="Address"
                            label-for="consigneeDetailAddress"
                        >
                            <b-form-textarea
                                id="consigneeDetailAddress"
                                v-model="soDispatchTabData.dispatchDetailAddress"
                                rows="1"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="6">
                        <b-form-group
                            label="Phone No"
                            label-for="consigneeDetailPhoneNo"
                        >
                            <b-input-group>
                                <b-input-group-prepend>
                                    <b-form-input
                                        v-model="soDispatchTabData.dispatchDetailPhoneStdCode"
                                    />
                                </b-input-group-prepend>
                                <b-form-input
                                    id="consigneeDetailPhoneNo"
                                    v-model="soDispatchTabData.dispatchDetailPhoneNo"
                                />
                            </b-input-group>
                        </b-form-group>
                    </b-col>
                    <b-col md="3">
                        <b-form-group
                            label="District"
                            label-for="consigneeDetailCity"
                        >
                            <v-select
                                v-model="soDispatchTabData.dispatchDetailCityId"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="cityOptions"
                                :reduce="val => val.value"
                                :clearable="false"
                                input-id="buyerDetailCity"
                                placeholder="Select District"
                                no-data-text
                                @input="getDispatchCityState($event)"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="3">
                        <b-form-group
                            label="State"
                            label-for="consigneeDetailState"
                        >
                            <v-select
                                v-model="soDispatchTabData.dispatchDetailStateId"
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
                            label-for="consigneeDetailCountry"
                        >
                            <v-select
                                v-model="soDispatchTabData.dispatchDetailCountryID"
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
                            label-for="consigneeDetailPinCode"
                        >
                            <b-form-input
                                id="consigneeDetailPinCode"
                                v-model="soDispatchTabData.dispatchDetailPinCode"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="4">
                        <b-form-group
                            label="Fax No"
                            label-for="consigneeDetailFaxNo"
                        >
                            <b-form-input
                                id="consigneeDetailFaxNo"
                                v-model="soDispatchTabData.dispatchDetailFaxNo"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="4">
                        <b-form-group
                            label="Email ID"
                            label-for="consigneeDetailEmailId"
                        >
                            <b-form-input
                                id="consigneeDetailEmailId"
                                v-model="soDispatchTabData.dispatchDetailEmailId"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="4">
                        <b-form-group
                            label="Website"
                            label-for="consigneeDetailWebsite"
                        >
                            <b-form-input
                                id="consigneeDetailWebsite"
                                v-model="soDispatchTabData.dispatchDetailWebsite"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="3">
                        <b-form-group
                            label="GST No"
                            label-for="consigneeDetailGstNo"
                        >
                            <b-form-input
                                id="consigneeDetailGstNo"
                                v-model="soDispatchTabData.dispatchDetailGstNo"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="3">
                        <b-form-group
                            label="Pan No"
                            label-for="consigneeDetailPanNo"
                        >
                            <b-form-input
                                id="consigneeDetailPanNo"
                                v-model="soDispatchTabData.dispatchDetailPanNo"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="3">
                        <b-form-group
                            label="Tin Vat No"
                            label-for="consigneeDetailTinVatNO"
                        >
                            <b-form-input
                                id="consigneeDetailTinVatNO"
                                v-model="soDispatchTabData.dispatchDetailTinVatNO"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="3">
                        <b-form-group
                            label="Tin CST No"
                            label-for="consigneeDetailTinCstNO"
                        >
                            <b-form-input
                                id="consigneeDetailTinCstNO"
                                v-model="soDispatchTabData.dispatchDetailTinCstNO"
                            />
                        </b-form-group>
                    </b-col>
                    <!--<b-col md="3">
                        <b-form-group
                            label="ECC No"
                            label-for="consigneeDetailTinEccNO"
                        >
                            <b-form-input
                                id="consigneeDetailTinEccNO"
                                v-model="soDispatchTabData.dispatchDetailTinEccNO"
                            />
                        </b-form-group>
                    </b-col>-->
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
                            Add / Save consignee Detail
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
                            id: this.CurrentSalesOrderId,
                            dispatchDetail: this.soDispatchTabData,
                        }
                        console.log(SubmitFormData)
                        store.dispatch('sales-order-module/updateSalesOrder', SubmitFormData).then(response => {
                            if (response.status === 200) {
                                this.$toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: 'Dispatch Edited',
                                        icon: 'CheckSquareIcon',
                                        variant: 'success',
                                        text: `You have successfully Edited Sales Order Dispatch Detail`,
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
            soDispatchTabData: {
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
            // UnRegister on leave
            /*onUnmounted(() => {
                if (store.hasModule(SO_APP_STORE_MODULE_NAME)) store.unregisterModule(SO_APP_STORE_MODULE_NAME)
            })*/

            const CurrentSalesOrderId = ref(router.currentRoute.params.id)
            const getPartyCodeDispatch = async (val) => {
                if (val) {
                    await axios.get(`/api/party/edit/${val}`).then(res => {
                        props.soDispatchTabData.dispatchDetailCode = res.data.data.partyCode
                        props.soDispatchTabData.dispatchDetailName = res.data.data.partyName
                        if (res.data.data.partyDetails) {
                            props.soDispatchTabData.dispatchDetailAddress = res.data.data.partyDetails.partyAddress
                            if (res.data.data.partyDetails.partyCity) {
                                props.soDispatchTabData.dispatchDetailCityId = res.data.data.partyDetails.partyCity.value
                                props.soDispatchTabData.dispatchDetailCity = res.data.data.partyDetails.partyCity.label
                            }
                            if (res.data.data.partyDetails.partyState) {
                                props.soDispatchTabData.dispatchDetailStateId = res.data.data.partyDetails.partyState.value
                                props.soDispatchTabData.dispatchDetailState = res.data.data.partyDetails.partyState.label
                            }
                            if (res.data.data.partyDetails.partyCountry) {
                                props.soDispatchTabData.dispatchDetailCountryID = res.data.data.partyDetails.partyCountry.value
                                props.soDispatchTabData.dispatchDetailCountry = res.data.data.partyDetails.partyCountry.label
                            }
                            props.soDispatchTabData.dispatchDetailFaxNo = res.data.data.partyDetails.partyFaxNo
                            props.soDispatchTabData.dispatchDetailEmailId = res.data.data.partyDetails.partyEmilId
                            props.soDispatchTabData.dispatchDetailWebsite = res.data.data.partyDetails.partyWebsite
                            props.soDispatchTabData.dispatchDetailPinCode = res.data.data.partyDetails.partyPinCode
                            props.soDispatchTabData.dispatchDetailPhoneStdCode = res.data.data.partyDetails.partyCountryCode
                            props.soDispatchTabData.dispatchDetailPhoneNo = res.data.data.partyDetails.partyPhoneNo
                        }
                        if (res.data.data.taxDetails) {
                            props.soDispatchTabData.dispatchDetailGstNo = res.data.data.taxDetails.gstin
                            props.soDispatchTabData.dispatchDetailTinVatNO = res.data.data.taxDetails.tinVatNo
                            props.soDispatchTabData.dispatchDetailTinCstNO = res.data.data.taxDetails.tinCstNo
                            props.soDispatchTabData.dispatchDetailTinEccNO = res.data.data.taxDetails.eccNo
                            props.soDispatchTabData.dispatchDetailPanNo = res.data.data.taxDetails.panNo
                        }
                    });
                }
            }

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

            const getDispatchCityState = async (cityId) => {
                await axios.get(`/api/city-master/${cityId}`).then((res) => {
                    props.soDispatchTabData.dispatchDetailStateId = res.data.data.state
                    props.soDispatchTabData.dispatchDetailCountryID = res.data.data.country
                    props.soDispatchTabData.dispatchDetailCountry = res.data.data?.country_detail?.label ?? null
                    props.soDispatchTabData.dispatchDetailState = res.data.data?.state_detail?.label ?? null
                });
            }

            return {
                CurrentSalesOrderId,
                getPartyCodeDispatch,
                countryOptions,
                stateOptions,
                cityOptions,
                getDispatchCityState,
                required,
            }
        },
    }
</script>

<style lang="scss">
    @import '~@core/scss/vue/libs/vue-select.scss';
</style>
