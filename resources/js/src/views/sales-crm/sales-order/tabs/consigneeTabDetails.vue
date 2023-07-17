<template>
    <div>
        <b-row>
            <b-col md="12">
                <hr>
                <h4>Consignee Details</h4>
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
                                v-model="soConsigneeTabData.consigneeDetailId"
                                taggable
                                push-tags
                                placeholder="Select Party"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="soPartyList"
                                :reduce="val => val.value"
                                :clearable="true"
                                @input="getPartyCodeConsignee(soConsigneeTabData.consigneeDetailId)"
                                input-id="consigneeDetailId"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="6">
                        <b-form-group
                            label="consignee Name"
                            label-for="consigneeDetailName"
                        >
                            <b-form-input
                                id="consigneeDetailName"
                                v-model="soConsigneeTabData.consigneeDetailName"
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
                                v-model="soConsigneeTabData.consigneeDetailAddress"
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
                                        v-model="soConsigneeTabData.consigneeDetailPhoneStdCode"
                                    />
                                </b-input-group-prepend>
                                <b-form-input
                                    id="consigneeDetailPhoneNo"
                                    v-model="soConsigneeTabData.consigneeDetailPhoneNo"
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
                                v-model="soConsigneeTabData.consigneeDetailCityId"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="cityOptions"
                                :reduce="val => val.value"
                                :clearable="false"
                                input-id="buyerDetailCity"
                                placeholder="Select District"
                                no-data-text
                                @input="getConsigneeCityState($event)"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="3">
                        <b-form-group
                            label="State"
                            label-for="consigneeDetailState"
                        >
                            <v-select
                                v-model="soConsigneeTabData.consigneeDetailStateId"
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
                                v-model="soConsigneeTabData.consigneeDetailCountryID"
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
                                v-model="soConsigneeTabData.consigneeDetailPinCode"
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
                                v-model="soConsigneeTabData.consigneeDetailFaxNo"
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
                                v-model="soConsigneeTabData.consigneeDetailEmailId"
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
                                v-model="soConsigneeTabData.consigneeDetailWebsite"
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
                                v-model="soConsigneeTabData.consigneeDetailGstNo"
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
                                v-model="soConsigneeTabData.consigneeDetailPanNo"
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
                                v-model="soConsigneeTabData.consigneeDetailTinVatNO"
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
                                v-model="soConsigneeTabData.consigneeDetailTinCstNO"
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
                                v-model="soConsigneeTabData.consigneeDetailTinEccNO"
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
                            consigneeDetail: this.soConsigneeTabData,
                        }
                        console.log(SubmitFormData)
                        store.dispatch('sales-order-module/updateSalesOrder', SubmitFormData).then(response => {
                            if (response.status === 200) {
                                this.$toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: 'consignee Edited',
                                        icon: 'CheckSquareIcon',
                                        variant: 'success',
                                        text: `You have successfully Edited Sales Order consignee Detail`,
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
            soConsigneeTabData: {
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
            const getPartyCodeConsignee = async (val) => {
                if (val) {
                    await axios.get(`/api/party/edit/${val}`).then(res => {
                        props.soConsigneeTabData.consigneeDetailCode = res.data.data.partyCode
                        props.soConsigneeTabData.consigneeDetailName = res.data.data.partyName
                        if (res.data.data.partyDetails) {
                            props.soConsigneeTabData.consigneeDetailAddress = res.data.data.partyDetails.partyAddress
                            if (res.data.data.partyDetails.partyCity) {
                                props.soConsigneeTabData.consigneeDetailCityId = res.data.data.partyDetails.partyCity.value
                                props.soConsigneeTabData.consigneeDetailCity = res.data.data.partyDetails.partyCity.label
                            }
                            if (res.data.data.partyDetails.partyState) {
                                props.soConsigneeTabData.consigneeDetailStateId = res.data.data.partyDetails.partyState.value
                                props.soConsigneeTabData.consigneeDetailState = res.data.data.partyDetails.partyState.label
                            }
                            if (res.data.data.partyDetails.partyCountry) {
                                props.soConsigneeTabData.consigneeDetailCountryID = res.data.data.partyDetails.partyCountry.value
                                props.soConsigneeTabData.consigneeDetailCountry = res.data.data.partyDetails.partyCountry.label
                            }
                            props.soConsigneeTabData.consigneeDetailFaxNo = res.data.data.partyDetails.partyFaxNo
                            props.soConsigneeTabData.consigneeDetailEmailId = res.data.data.partyDetails.partyEmilId
                            props.soConsigneeTabData.consigneeDetailWebsite = res.data.data.partyDetails.partyWebsite
                            props.soConsigneeTabData.consigneeDetailPinCode = res.data.data.partyDetails.partyPinCode
                            props.soConsigneeTabData.consigneeDetailPhoneStdCode = res.data.data.partyDetails.partyCountryCode
                            props.soConsigneeTabData.consigneeDetailPhoneNo = res.data.data.partyDetails.partyPhoneNo
                        }
                        if (res.data.data.taxDetails) {
                            props.soConsigneeTabData.consigneeDetailGstNo = res.data.data.taxDetails.gstin
                            props.soConsigneeTabData.consigneeDetailTinVatNO = res.data.data.taxDetails.tinVatNo
                            props.soConsigneeTabData.consigneeDetailTinCstNO = res.data.data.taxDetails.tinCstNo
                            props.soConsigneeTabData.consigneeDetailTinEccNO = res.data.data.taxDetails.eccNo
                            props.soConsigneeTabData.consigneeDetailPanNo = res.data.data.taxDetails.panNo
                        }
                    })
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


            const getConsigneeCityState = async (cityId) => {
                await axios.get(`/api/city-master/${cityId}`).then((res) => {
                    props.soConsigneeTabData.consigneeDetailStateId = res.data.data.state
                    props.soConsigneeTabData.consigneeDetailCountryID = res.data.data.country
                    props.soConsigneeTabData.consigneeDetailCountry = res.data.data?.country_detail?.label ?? null
                    props.soConsigneeTabData.consigneeDetailState = res.data.data?.state_detail?.label ?? null
                });
            }

            return {
                CurrentSalesOrderId,
                getPartyCodeConsignee,
                countryOptions,
                stateOptions,
                cityOptions,
                getConsigneeCityState,
                required,
            }
        },
    }
</script>

<style lang="scss">
    @import '~@core/scss/vue/libs/vue-select.scss';
</style>
