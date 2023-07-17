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
                                v-model="piConsigneeTabData.consigneeDetailId"
                                taggable
                                push-tags
                                placeholder="Select Party"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="piPartyList"
                                :reduce="val => val.value"
                                :clearable="true"
                                @input="getPartyCodeConsignee(piConsigneeTabData.consigneeDetailId)"
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
                                v-model="piConsigneeTabData.consigneeDetailName"
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
                                v-model="piConsigneeTabData.consigneeDetailAddress"
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
                                    v-model="piConsigneeTabData.consigneeDetailPhoneStdCode"
                                />
                            </b-input-group-prepend>
                            <b-form-input
                                id="consigneeDetailPhoneNo"
                                v-model="piConsigneeTabData.consigneeDetailPhoneNo"
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
                                v-model="piConsigneeTabData.consigneeDetailCityId"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="cityOptions"
                                :reduce="val => val.value"
                                :clearable="false"
                                input-id="buyerDetailCity"
                                placeholder="Select District"
                                no-data-text
                                @input="getCityDetails($event)"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="3">
                        <b-form-group
                            label="State"
                            label-for="consigneeDetailState"
                        >
                            <v-select
                                v-model="piConsigneeTabData.consigneeDetailStateId"
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
                                v-model="piConsigneeTabData.consigneeDetailCountryID"
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
                                v-model="piConsigneeTabData.consigneeDetailPinCode"
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
                                v-model="piConsigneeTabData.consigneeDetailFaxNo"
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
                                v-model="piConsigneeTabData.consigneeDetailEmailId"
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
                                v-model="piConsigneeTabData.consigneeDetailWebsite"
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
                                v-model="piConsigneeTabData.consigneeDetailGstNo"
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
                                v-model="piConsigneeTabData.consigneeDetailTinVatNO"
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
                                v-model="piConsigneeTabData.consigneeDetailTinCstNO"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="3">
                        <b-form-group
                            label="ECC No"
                            label-for="consigneeDetailTinEccNO"
                        >
                            <b-form-input
                                id="consigneeDetailTinEccNO"
                                v-model="piConsigneeTabData.consigneeDetailTinEccNO"
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
                            id: this.CurrentPiId,
                            consigneeDetail: this.piConsigneeTabData,
                        }
                        console.log(SubmitFormData)
                        store.dispatch('pi-consi-module/updateProformaInvoice', SubmitFormData).then(response => {
                            if (response.status === 200) {
                                this.$toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: 'consignee Edited',
                                        icon: 'CheckSquareIcon',
                                        variant: 'success',
                                        text: `You have successfully Edited PI consignee Detail`,
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
            piConsigneeTabData: {
                type: Object,
                required: true,
            },
            piPartyList: {
                type: Array,
                required: true,
            },
        },
        setup(props) {
            const PIC_APP_STORE_MODULE_NAME = 'pi-consi-module'
            // Register module
            if (!store.hasModule(PIC_APP_STORE_MODULE_NAME)) store.registerModule(PIC_APP_STORE_MODULE_NAME, salesStoreModule)
            // UnRegister on leave
            onUnmounted(() => {
                if (store.hasModule(PIC_APP_STORE_MODULE_NAME)) store.unregisterModule(PIC_APP_STORE_MODULE_NAME)
            })

            const CurrentPiId = ref(router.currentRoute.params.id)
            const getPartyCodeConsignee = async (val) => {
                if (val) {
                    await axios.get(`/api/party/edit/${val}`).then(res => {
                        props.piConsigneeTabData.consigneeDetailCode = res.data.data.partyCode
                        props.piConsigneeTabData.consigneeDetailName = res.data.data.partyName
                        if (res.data.data.partyDetails) {
                            props.piConsigneeTabData.consigneeDetailAddress = res.data.data.partyDetails.partyAddress
                            if (res.data.data.partyDetails.partyCity) {
                                props.piConsigneeTabData.consigneeDetailCityId = res.data.data.partyDetails.partyCity.value
                                props.piConsigneeTabData.consigneeDetailCity = res.data.data.partyDetails.partyCity.label
                            }
                            if (res.data.data.partyDetails.partyState) {
                                props.piConsigneeTabData.consigneeDetailStateId = res.data.data.partyDetails.partyState.value
                                props.piConsigneeTabData.consigneeDetailState = res.data.data.partyDetails.partyState.label
                            }
                            if (res.data.data.partyDetails.partyCountry) {
                                props.piConsigneeTabData.consigneeDetailCountryID = res.data.data.partyDetails.partyCountry.value
                                props.piConsigneeTabData.consigneeDetailCountry = res.data.data.partyDetails.partyCountry.label
                            }
                            props.piConsigneeTabData.consigneeDetailFaxNo = res.data.data.partyDetails.partyFaxNo
                            props.piConsigneeTabData.consigneeDetailEmailId = res.data.data.partyDetails.partyEmilId
                            props.piConsigneeTabData.consigneeDetailWebsite = res.data.data.partyDetails.partyWebsite
                            props.piConsigneeTabData.consigneeDetailPinCode = res.data.data.partyDetails.partyPinCode
                            props.piConsigneeTabData.consigneeDetailPhoneStdCode = res.data.data.partyDetails.partyCountryCode
                            props.piConsigneeTabData.consigneeDetailPhoneNo = res.data.data.partyDetails.partyPhoneNo
                        }
                        if (res.data.data.taxDetails) {
                            props.piConsigneeTabData.consigneeDetailGstNo = res.data.data.taxDetails.gstin
                            props.piConsigneeTabData.consigneeDetailTinVatNO = res.data.data.taxDetails.tinVatNo
                            props.piConsigneeTabData.consigneeDetailTinCstNO = res.data.data.taxDetails.tinCstNo
                            props.piConsigneeTabData.consigneeDetailTinEccNO = res.data.data.taxDetails.eccNo
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

            const getCityDetails = async (cityId) => {
                await axios.get(`/api/city-master/${cityId}`).then((res) => {
                    props.piConsigneeTabData.consigneeDetailStateId = res.data.data.state
                    props.piConsigneeTabData.consigneeDetailCountryID = res.data.data.country
                    props.piConsigneeTabData.consigneeDetailCountry = res.data.data?.country_detail?.label ?? null
                    props.piConsigneeTabData.consigneeDetailState = res.data.data?.state_detail?.label ?? null
                });
            }
            return {
                CurrentPiId,
                getPartyCodeConsignee,
                countryOptions,
                stateOptions,
                cityOptions,
                required,
                getCityDetails
            }
        },
    }
</script>

<style lang="scss">
    @import '~@core/scss/vue/libs/vue-select.scss';
</style>
