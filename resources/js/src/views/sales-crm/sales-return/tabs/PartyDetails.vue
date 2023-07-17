<template>
    <div>
        <b-row>
            <b-col md="12">
                <hr>
                <h4>Customer Details</h4>
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
                                v-model="srPartyTabData.partyDetailCode"
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
                                v-model="srPartyTabData.partyDetailName"
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
                                v-model="srPartyTabData.partyDetailAddress"
                                rows="1"
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
                                        v-model="srPartyTabData.partyDetailStdCode"
                                        readonly
                                    />
                                </b-input-group-prepend>
                                <b-form-input
                                    id="party-phone"
                                    placeholder="Party Phone"
                                    v-model="srPartyTabData.partyDetailPhoneNo"
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
                                v-model="srPartyTabData.partyDetailCity"
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
                                v-model="srPartyTabData.partyDetailState"
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
                                v-model="srPartyTabData.partyDetailCountry"
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
                                v-model="srPartyTabData.partyDetailPinCode"
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
                                v-model="srPartyTabData.partyDetailFaxNo"
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
                                v-model="srPartyTabData.partyDetailEmailId"
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
                                v-model="srPartyTabData.partyDetailWebsite"
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
                                v-model="srPartyTabData.partyDetailGstNo"
                                readonly
                            />

                        </b-form-group>
                    </b-col>
                    <b-col md="3">
                        <b-form-group
                            label="PAN No"
                            label-for="partyDetailTinPanNO"
                        >
                            <b-form-input
                                id="partyDetailTinPanNO"
                                v-model="srPartyTabData.partyDetailTinPanNO"
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
                                v-model="srPartyTabData.partyDetailTinVatNO"
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
                                v-model="srPartyTabData.partyDetailTinCstNO"
                                readonly
                            />

                        </b-form-group>
                    </b-col>
                    <b-col md="12">
                        <b-form-group
                            label="Narration"
                            label-for="partyDetailNarration"
                        >
                            <b-form-textarea
                                id="partyDetailNarration"
                                v-model="srPartyTabData.partyDetailNarration"
                                rows="1"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="3">
                        <b-form-group
                            label="Select Kind Attn"
                            label-for="kindAttnId"
                        >
                            <v-select
                                v-model="srPartyTabData.partyKindAttnId"
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
                                v-model="srPartyTabData.partyKindAttnName"
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
                                v-model="srPartyTabData.partyKindAttnMobile"
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
                                v-model="srPartyTabData.partyKindAttnEmail"
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
                            Save Customer Detail
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
        BInputGroupPrepend,
        BInputGroup
    } from 'bootstrap-vue'
    import {required} from '@validations'
    import Ripple from 'vue-ripple-directive'
    import vSelect from 'vue-select'
    import router from '@/router'
    import store from '@/store'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import {ref, computed, onMounted, onUnmounted} from '@vue/composition-api'
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
        methods: {
            async validationForm() {
                await this.$refs.simpleRules.validate().then(success => {
                    if (success) {
                        const SubmitFormData = {
                            id: this.CurrentSrId,
                            customerDetail: this.srPartyTabData,
                        }
                        console.log(SubmitFormData)
                        store.dispatch('srp-module/updateSalesReturn', SubmitFormData).then(response => {
                            if (response.status === 200) {
                                this.$toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: 'Customer Edited',
                                        icon: 'CheckSquareIcon',
                                        variant: 'success',
                                        text: `You have successfully Edited Customer Detail`,
                                    },
                                });
                            }
                        });
                    }
                });
            },
            containsKey(obj, key) {
                return Object.keys(obj).includes(key)
            },
        },
        props: {
            srPartyTabData: {
                type: Object,
            },
        },
        setup(props) {

            const SRP_APP_STORE_MODULE_NAME = 'srp-module'
            // Register module
            onMounted(() => {
                if (!store.hasModule(SRP_APP_STORE_MODULE_NAME)) store.registerModule(SRP_APP_STORE_MODULE_NAME, salesStoreModule)
            });
            // UnRegister on leave
            onUnmounted(() => {
                if (store.hasModule(SRP_APP_STORE_MODULE_NAME)) store.unregisterModule(SRP_APP_STORE_MODULE_NAME)
            });

            const CurrentSrId = ref(router.currentRoute.params.id)

            const srPartyData = computed(() => props.srPartyTabData)

            const KindAttnOptions = ref([])

            const getKindAttnOptions = async (id) => {
                await axios.get('/api/party/get-party-contacts-options/'+id).then((res) => {
                    KindAttnOptions.value = res.data.data
                });
            }
            setTimeout(() => {
                getKindAttnOptions(srPartyData.value.partyDetailId)
            }, 2000);

            const getContactDetail = async (id) => {
                if (id) {
                    await axios.get('/api/party/contact-person/' + id).then((res) => {
                        srPartyData.value.partyKindAttnId = res.data.data._id
                        srPartyData.value.partyKindAttnName = res.data.data.personName
                        srPartyData.value.partyKindAttnMobile = res.data.data.mobileNo
                        srPartyData.value.partyKindAttnEmail = res.data.data.email
                    });
                } else {
                    srPartyData.value.partyKindAttnId = null
                    srPartyData.value.partyKindAttnName = null
                    srPartyData.value.partyKindAttnMobile = null
                    srPartyData.value.partyKindAttnEmail = null
                }
            }

            return {
                CurrentSrId,
                srPartyData,
                KindAttnOptions,
                required,
                getContactDetail,
            }
        },

    }
</script>

<style lang="scss">
    @import '~@core/scss/vue/libs/vue-select.scss';
</style>
