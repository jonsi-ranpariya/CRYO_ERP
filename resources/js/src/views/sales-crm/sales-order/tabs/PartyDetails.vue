<template>
    <div>
        <b-row>
            <b-col md="12">
                <hr>
                <h4>Party Details</h4>
                <hr>
            </b-col>
        </b-row>
        <validation-observer ref="simpleRules">
            <b-form>
                <b-row>
                    <b-col md="3">
                        <b-form-group
                            label="Party Code"
                            label-for="partyDetailCode"
                        >
                            <b-form-input
                                id="partyDetailCode"
                                v-model="soPartyTabData.partyDetailCode"
                                readonly
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="9">
                        <b-form-group
                            label="Party Name"
                            label-for="partyDetailName"
                        >
                            <b-form-input
                                id="partyDetailName"
                                v-model="soPartyTabData.partyDetailName"
                                readonly
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="6">
                        <b-form-group
                            label="Address"
                            label-for="partyDetailAddress"
                        >
                            <b-form-textarea
                                id="partyDetailAddress"
                                v-model="soPartyTabData.partyDetailAddress"
                                rows="1"
                                readonly
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="6">
                        <b-form-group
                            label="Phone No"
                            label-for="partyDetailPhoneNo"
                        >
                            <b-input-group>
                                <b-input-group-prepend>
                                    <b-form-input
                                        id="stdCode"
                                        placeholder="STD code"
                                        type="number"
                                        v-model="soPartyTabData.partyDetailStdCode"
                                        readonly
                                    />
                                </b-input-group-prepend>
                                <b-form-input
                                    id="party-phone"
                                    placeholder="Party Phone"
                                    v-model="soPartyTabData.partyDetailPhoneNo"
                                    readonly
                                />
                            </b-input-group>
                        </b-form-group>
                    </b-col>
                    <b-col md="3">
                        <b-form-group
                            label="District"
                            label-for="partyDetailCity"
                        >
                            <b-form-input
                                id="partyDetailCity"
                                v-model="soPartyTabData.partyDetailCity"
                                readonly
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="3">
                        <b-form-group
                            label="State"
                            label-for="partyDetailState"
                        >
                            <b-form-input
                                id="partyDetailState"
                                v-model="soPartyTabData.partyDetailState"
                                readonly
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="3">
                        <b-form-group
                            label="Country"
                            label-for="partyDetailCountry"
                        >
                            <b-form-input
                                id="partyDetailCountry"
                                v-model="soPartyTabData.partyDetailCountry"
                                readonly
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="3">
                        <b-form-group
                            label="Pin Code"
                            label-for="partyDetailPinCode"
                        >
                            <b-form-input
                                id="partyDetailPinCode"
                                v-model="soPartyTabData.partyDetailPinCode"
                                readonly
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="4">
                        <b-form-group
                            label="Fax No"
                            label-for="partyDetailFaxNo"
                        >
                            <b-form-input
                                id="partyDetailFaxNo"
                                v-model="soPartyTabData.partyDetailFaxNo"
                                readonly
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="4">
                        <b-form-group
                            label="Email ID"
                            label-for="partyDetailEmailId"
                        >
                            <b-form-input
                                id="partyDetailEmailId"
                                v-model="soPartyTabData.partyDetailEmailId"
                                readonly
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="4">
                        <b-form-group
                            label="Website"
                            label-for="partyDetailWebsite"
                        >
                            <b-form-input
                                id="partyDetailWebsite"
                                v-model="soPartyTabData.partyDetailWebsite"
                                readonly
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="3">
                        <b-form-group
                            label="GST No"
                            label-for="partyDetailGstNo"
                        >
                            <b-form-input
                                id="partyDetailGstNo"
                                v-model="soPartyTabData.partyDetailGstNo"
                                readonly
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="3">
                        <b-form-group
                            label="Pan No"
                            label-for="partyDetailPanNo"
                        >
                            <b-form-input
                                id="partyDetailPanNo"
                                v-model="soPartyTabData.partyDetailPanNo"
                                readonly
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="3">
                        <b-form-group
                            label="Tin Vat No"
                            label-for="partyDetailTinVatNO"
                        >
                            <b-form-input
                                id="partyDetailTinVatNO"
                                v-model="soPartyTabData.partyDetailTinVatNO"
                                readonly
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="3">
                        <b-form-group
                            label="Tin CST No"
                            label-for="partyDetailTinCstNO"
                        >
                            <b-form-input
                                id="partyDetailTinCstNO"
                                v-model="soPartyTabData.partyDetailTinCstNO"
                                readonly
                            />
                        </b-form-group>
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
        BInputGroupPrepend,
        BInputGroup
    } from 'bootstrap-vue'
    import {required} from '@validations'
    import Ripple from 'vue-ripple-directive'
    import vSelect from 'vue-select'
    import router from '@/router'
    import store from '@/store'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import {ref, onMounted, onUpdated, onBeforeMount, onBeforeUpdate, onActivated, onUnmounted} from '@vue/composition-api'
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
            BInputGroupPrepend,
            BInputGroup
        },
        directives: {
            Ripple,
        },
        props: {
                soPartyTabData: {
                type: Object,
            },
        },
        setup() {

            const SO_APP_STORE_MODULE_NAME = 'sales-order-module'
            // Register module
            if (!store.hasModule(SO_APP_STORE_MODULE_NAME)) store.registerModule(SO_APP_STORE_MODULE_NAME, salesStoreModule)
            // UnRegister on leave
            /*onUnmounted(() => {
                if (store.hasModule(SO_APP_STORE_MODULE_NAME)) store.unregisterModule(SO_APP_STORE_MODULE_NAME)
            })*/

            const CurrentSalesOrderId = ref(router.currentRoute.params.id)

            return {
                CurrentSalesOrderId,
                required,
            }
        },

    }
</script>

<style lang="scss">
    @import '~@core/scss/vue/libs/vue-select.scss';
</style>
