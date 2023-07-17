<template>

    <div>

        <b-row>

            <b-col md="12">

                <hr></hr>

                <h4>Party Details</h4>

                <hr></hr>

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
                                v-model="piPartyTabData.partyDetailCode"
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
                                v-model="piPartyTabData.partyDetailName"
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
                                v-model="piPartyTabData.partyDetailAddress"
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
                                        v-model="piPartyTabData.partyDetailStdCode"
                                        readonly
                                    />
                                </b-input-group-prepend>
                                <b-form-input
                                    id="party-phone"
                                    placeholder="Party Phone"
                                    v-model="piPartyTabData.partyDetailPhoneNo"
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
                                v-model="piPartyTabData.partyDetailCity"
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
                                v-model="piPartyTabData.partyDetailState"
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
                                v-model="piPartyTabData.partyDetailCountry"
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
                                v-model="piPartyTabData.partyDetailPinCode"
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
                                v-model="piPartyTabData.partyDetailFaxNo"
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
                                v-model="piPartyTabData.partyDetailEmailId"
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
                                v-model="piPartyTabData.partyDetailWebsite"
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
                                v-model="piPartyTabData.partyDetailGstNo"
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
                                v-model="piPartyTabData.partyDetailTinVatNO"
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
                                v-model="piPartyTabData.partyDetailTinCstNO"
                                readonly
                            />

                        </b-form-group>
                    </b-col>

                    <b-col md="3">
                        <b-form-group
                            label="ECC No"
                            label-for="partyDetailTinEccNO"
                        >
                            <b-form-input
                                id="partyDetailTinEccNO"
                                v-model="piPartyTabData.partyDetailTinEccNO"
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
        BInputGroup,
        BInputGroupPrepend
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
            BInputGroup,
            BInputGroupPrepend
        },
        directives: {
            Ripple,
        },
        props: {
            piPartyTabData: {
                type: Object,
            },
        },
        setup() {

            const PI_APP_STORE_MODULE_NAME = 'pi-module'
            // Register module
            if (!store.hasModule(PI_APP_STORE_MODULE_NAME)) store.registerModule(PI_APP_STORE_MODULE_NAME, salesStoreModule)
            // UnRegister on leave
            onUnmounted(() => {
                if (store.hasModule(PI_APP_STORE_MODULE_NAME)) store.unregisterModule(PI_APP_STORE_MODULE_NAME)
            })

            const CurrentPiId = ref(router.currentRoute.params.id)

            return {
                CurrentPiId,
                required,
            }
        },

    }
</script>

<style lang="scss">
    @import '~@core/scss/vue/libs/vue-select.scss';
</style>
