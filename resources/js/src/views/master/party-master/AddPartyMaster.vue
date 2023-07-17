<template>
    <b-card-code>
        <validation-observer ref="simpleRules">
            <b-form>
                <b-row>
                    <b-col md="3">
                        <b-form-group
                            label="Party Code"
                            label-for="party-code"
                        >
                            <b-form-input
                                id="party-code"
                                placeholder="Party Code"
                                v-uppercase
                                v-model="partyFormData.partyCode"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="9">
                        <b-form-group
                            label="Party Name"
                            label-for="party-name"
                        >
                            <validation-provider
                                #default="{ errors }"
                                name="Party Name"
                                rules="required"
                            >
                                <b-form-input
                                    id="party-name"
                                    v-model="partyFormData.partyName"
                                    placeholder="Party Name"
                                    v-uppercase
                                    :state="errors.length > 0 ? false:null"
                                />
                                <small class="text-danger">{{ errors[0] }}</small>
                            </validation-provider>
                        </b-form-group>
                    </b-col>
                </b-row>
                <b-row>
                    <b-col md="3">
                        <b-form-group
                            label="Party Type"
                            label-for="party-type"
                        >
                            <v-select
                                v-model="partyFormData.partyType"
                                placeholder="Select Party Type"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="PartyTypeOption"
                                :reduce="val => val.value"
                                :clearable="false"
                                input-id="party-type"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="3">
                        <b-form-group
                            label="Party Deal In"
                            label-for="party-deal"
                        >
                            <v-select
                                v-model="partyFormData.PartyTypeDealIn"
                                placeholder="Select Party Deal Type"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="PartyDealOption"
                                :reduce="val => val.value"
                                :clearable="false"
                                input-id="party-deal"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="3">
                        <b-form-group
                            label="Party Status"
                            label-for="partyStatus"
                        >
                            <v-select
                                placeholder="Select Party Status"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="PartyStatusOption"
                                :reduce="val => val.value"
                                :clearable="false"
                                v-model="partyFormData.partyStatus"
                                input-id="partyStatus"
                                disabled
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="3">
                        <b-form-group
                            label="Party Business Type"
                            label-for="party-bussiness-type"
                        >
                            <v-select
                                placeholder="Select Party Business Type"
                                v-model="partyFormData.partyTypeBusinessType"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="PartyCompanyTypeOption"
                                :reduce="val => val.value"
                                :clearable="false"
                                input-id="party-business-type"
                            />
                        </b-form-group>
                    </b-col>

                    <b-col md="4">
                        <b-form-group
                            label="Industry Type"
                            label-for="industry-type"
                        >
                            <v-select
                                placeholder="Select Party Industry Type"
                                v-model="partyFormData.partyTypeIndustry"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="IndustryTypeOption"
                                :reduce="val => val.value"
                                :clearable="false"
                                input-id="industry-type"
                            />
                        </b-form-group>
                    </b-col>

                    <b-col md="4">
                        <b-form-group
                            label="Branch"
                            label-for="branch"
                        >
                            <v-select
                                placeholder="Select Party Branch"
                                v-model="partyFormData.partyBranch"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="branchOption"
                                :clearable="false"
                                input-id="branch"
                            />
                        </b-form-group>
                    </b-col>

                    <b-col md="4">
                        <b-form-group
                            label="Supply Type"
                            label-for="supply-type"
                        >
                            <v-select
                                placeholder="Select Party Supply Type"
                                v-model="partyFormData.partySupplyType"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="SupplyTypeOption"
                                :reduce="val => val.value"
                                :clearable="false"
                                input-id="supply-type"
                            />
                        </b-form-group>
                    </b-col>


                    <b-col md="2">
                        <b-form-group
                            label="Opening Balance"
                            label-for="opening-balance"
                        >
                            <b-form-input
                                id="opening-balance"
                                v-model="partyFormData.partyOpeningBalance"
                                placeholder="Opening Balance"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="2">
                        <b-form-group
                            label="Balance Type"
                            label-for="balance-type"
                        >
                            <v-select
                                placeholder="Select Party Balance Type"
                                v-model="partyFormData.partyBalanceType"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="BalanceTypeOption"
                                :reduce="val => val.value"
                                :clearable="false"
                                input-id="balance-type"
                            />
                        </b-form-group>
                    </b-col>

                    <b-col md="3">
                        <b-form-group
                            label="Credit Limit"
                            label-for="credit-limit"
                        >
                            <b-form-input
                                id="credit-limit"
                                v-model="partyFormData.partyCreditLimit"
                                placeholder="Credit Limit"
                            />
                        </b-form-group>
                    </b-col>

                    <b-col md="3">
                        <b-form-group
                            label="Party Group"
                            label-for="partyGroup"
                        >
                            <v-select
                                v-model="partyFormData.partyGroup"
                                taggable
                                push-tags
                                placeholder="Select Party Group"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="PartyGroupOption"
                                :reduce="val => val.value"
                                :clearable="false"
                                input-id="partyGroup"
                            />
                        </b-form-group>
                    </b-col>

                    <b-col md="2">
                        <b-form-group
                            label="Currency Type"
                            label-for="currency-type"
                        >
                            <v-select
                                v-model="partyFormData.partyCurrencyType"
                                placeholder="Select Party Currency"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="CurrencyTypeOption"
                                :reduce="val => val.value"
                                :clearable="false"
                                input-id="currency-type"
                            />
                        </b-form-group>
                    </b-col>

                </b-row>
                <b-row>
                    <b-col cols="12">
                        <b-form-group>
                            <b-form-checkbox
                                id="partyActive"
                                v-model="partyFormData.partyActive"
                                name="partyActive"
                                value="1"
                            >
                                Active
                            </b-form-checkbox>
                        </b-form-group>
                    </b-col>

                    <!-- submit and reset -->
                    <b-col>
                        <b-button
                            v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                            type="submit"
                            variant="primary"
                            class="mr-1"
                            @click.prevent="validationForm"
                        >
                            Submit
                        </b-button>

                    </b-col>
                </b-row>
            </b-form>
        </validation-observer>
    </b-card-code>
</template>

<script>
import BCardCode from '@core/components/b-card-code'
import {ValidationProvider, ValidationObserver} from 'vee-validate'
import {
    BRow, BCol, BFormGroup, BFormInput, BFormCheckbox, BForm, BButton,
} from 'bootstrap-vue'
import {required} from '@validations'
import Ripple from 'vue-ripple-directive'
import vSelect from 'vue-select'
import store from '@/store'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
import {ref, onUnmounted} from '@vue/composition-api'
import partyStoreModule from '../partyStoreModule'
import {getUserData} from "../../../auth/utils";
import {getTcTodayDateTime} from "@core/utils/utils";

const uppercase = {

    inserted: function (el, _, vnode) {
        el.addEventListener('input', async function (e) {
            e.target.value = e.target.value.toUpperCase()
            vnode.componentInstance.$emit('input', e.target.value.toUpperCase())
        })
    }

}

export default {
    components: {
        BCardCode,
        ValidationProvider,
        ValidationObserver,
        BRow,
        BCol,
        BFormGroup,
        BFormInput,
        BFormCheckbox,
        BForm,
        BButton,
        vSelect
    },
    directives: {
        Ripple,
        uppercase,
    },
    data() {
        return {
            PartyGroupOption: [],
            IndustryTypeOption: [],
            PartyTypeOption: [],
            PartyCompanyTypeOption: [],
            CurrencyTypeOption: [],
            branchOption: [],
        }
    },
    //
    methods: {
        validationForm: function () {
            this.$refs.simpleRules.validate().then(success => {
                if (success) {
                    this.$http.get(`/api/party/check-name/${this.partyFormData.partyName}`).then(res => {
                        if (res.data.data === false) {
                            this.saveData()
                        } else {
                            this.$swal({
                                title: 'Are you sure?',
                                text: "Name is already exist",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonText: 'Yes, do it!',
                                cancelButtonText: 'No, Change Name!',
                                customClass: {
                                    confirmButton: 'btn btn-primary',
                                    cancelButton: 'btn btn-outline-danger ml-1',
                                },
                                buttonsStyling: false,
                            }).then(result => {
                                if (result.value) {
                                    this.saveData()
                                } else {
                                    this.partyFormData.partyName = null
                                }
                            })
                        }
                    })
                }
            })
        },
        saveData() {
            store.dispatch('master-add/addPartyMaster', this.partyFormData).then(response => {
                if (response.status = 200) {
                    this.$router.push({
                        name: 'edit-party-master',
                        params: {id: response.data.data._id}
                    })
                    this.$toast({
                        component: ToastificationContent,
                        position: 'top-right',
                        props: {
                            title: 'Party Created',
                            icon: 'CheckSquareIcon',
                            variant: 'success',
                            text: `You have successfully Created New Party ${this.partyFormData.partyCode}.`,
                        },
                    })
                }
            })
        }
    },
    setup() {
        const PARTYMASTER_APP_STORE_MODULE_NAME = 'master-add'
        // Register module
        if (!store.hasModule(PARTYMASTER_APP_STORE_MODULE_NAME)) store.registerModule(PARTYMASTER_APP_STORE_MODULE_NAME, partyStoreModule)
        // UnRegister on leave
        onUnmounted(() => {
            if (store.hasModule(PARTYMASTER_APP_STORE_MODULE_NAME)) store.unregisterModule(PARTYMASTER_APP_STORE_MODULE_NAME)
        })

        const currentUserData = ref(getUserData())
        const partyFormData = ref({
            id: null,
            partyCode: null,
            partyName: null,
            partyType: null,
            PartyTypeDealIn: null,
            partyTypeStatus: null,
            partyTypeBusinessType: null,
            partyTypeIndustry: null,
            partyBranch: null,
            partySupplyType: null,
            partyOpeningBalance: null,
            partyBalanceType: null,
            partyCreditLimit: null,
            partyGroup: null,
            partyCurrencyType: null,
            partyStatus: 'Created',
            partyActive: null,
            loginDetails: {
                createdBy: currentUserData.value.first_name + ' ' + currentUserData.value.last_name,
                createdDateTime: getTcTodayDateTime(),
                modifiedBy: null,
                modifiedDateTime: null,
                approvedBy: null,
                approvedDateTime: null,
                stage: 'Created',
                stageReason: null
            }
        });

        return {
            partyFormData,
            PartyDealOption: [
                {label: 'Manufacturer', value: 1},
                {label: 'Dealer', value: 2},
                {label: 'Other', value: 3}
            ],
            PartyStatusOption: [
                {label: 'Created', value: 'Created'},
                {label: 'Trial', value: 'Trial'},
                {label: 'Approved', value: 'Approved'},
                {label: 'Rejected', value: 'Rejected'}
            ],
            SupplyTypeOption: [
                {label: 'Intrastate', value: 1},
                {label: 'Interstate', value: 2},
                {label: 'Export', value: 3}
            ],
            BalanceTypeOption: [{label: 'CR', value: 1}, {label: 'DR', value: 2}],
            required,
        }
    },
    beforeCreate() {
        //Get All Group
        this.$http.get('/api/get-party-group-options').then(res => {
            this.PartyGroupOption = res.data.data
        })

        this.$http.get('/api/get-industry-type-options').then(res => {
            this.IndustryTypeOption = res.data.data
        })

        this.$http.get('/api/get-party-type-options').then(res => {
            this.PartyTypeOption = res.data.data
        })

        this.$http.get('/api/get-party-business-type-options').then(res => {
            this.PartyCompanyTypeOption = res.data.data
        })

        this.$http.get('/api/get-currency-options').then(res => {
            this.CurrencyTypeOption = res.data.data
        })

        this.$http.get('/api/get-branch-master-options').then(res => {
            this.branchOption = res.data.data
        })
    },
}
</script>
<style lang="scss">
@import '~@core/scss/vue/libs/vue-sweetalert.scss';
</style>
