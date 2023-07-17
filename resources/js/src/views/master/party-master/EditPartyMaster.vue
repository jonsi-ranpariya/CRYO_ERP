<template>
    <div>
        <!-- Approval Section-->
        <b-overlay
            :show="showOverlayLoading"
            rounded="sm"
            v-if="currentUserData.role === 'admin'"
        >
            <app-collapse accordion type="border" class="mb-1">
                <app-collapse-item title="Admin Area">
                    <b-row>
                        <b-col md="12">
                            <b-form-group
                                label="Status"
                                label-for="adminStatus"
                            >
                                <v-select
                                    placeholder="Select Party Status"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="PartyStatusOption"
                                    :reduce="val => val.value"
                                    :clearable="false"
                                    v-model="adminFormData.partyStatus"
                                    input-id="adminStatus"
                                />
                            </b-form-group>
                            <div v-if="adminFormData.partyStatus === 'Rejected'">
                                <b-form-group
                                    label="Reason"
                                    label-for="adminReason"
                                >
                                    <b-form-textarea
                                        id="adminReason"
                                        rows="3"
                                        v-model="adminFormData.rejectReason"
                                    />
                                </b-form-group>
                            </div>
                        </b-col>
                        <b-col md="12">
                            <hr>
                            <b-button
                                type="button"
                                variant="primary"
                                class="float-right"
                                @click="changePartyStatusStage"
                            >
                                Change Status
                            </b-button>
                        </b-col>
                    </b-row>
                </app-collapse-item>
            </app-collapse>
        </b-overlay>
        <!-- Regular Section-->
        <b-overlay
            :show="showOverlayLoading"
            rounded="sm"
        >
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
                                        v-model="partyFormData.partyTypeBusinessType"
                                        placeholder="Select Party Business Type"
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
                                        v-model="partyFormData.partyTypeIndustry"
                                        placeholder="Select Party Industry Type"
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
                                        v-model="partyFormData.partyBranch"
                                        placeholder="Select Party Branch"
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
                                        v-model="partyFormData.partySupplyType"
                                        placeholder="Select Party Supply Type"
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
                                        v-model="partyFormData.partyBalanceType"
                                        placeholder="Select Party Balance Type"
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
                <b-row>
                    <b-col cols="12">
                        <hr>
                    </b-col>
                </b-row>
                <b-row class="mt-25">
                    <b-col cols="12">
                        <b-tabs v-if="partyFormData" pills lazy>
                            <b-tab active>
                                <template #title>
                                    <feather-icon
                                        icon="FileTextIcon"
                                        size="16"
                                        class="mr-0 mr-sm-50"
                                    />
                                    <span class="d-none d-sm-inline">Party Detail</span>
                                </template>

                                <party-edit-tab-party-detail
                                    :party-data="partyFormData"
                                    class="mt-2 pt-75"
                                />
                            </b-tab>

                            <b-tab>
                                <template #title>
                                    <feather-icon
                                        icon="UsersIcon"
                                        size="16"
                                        class="mr-0 mr-sm-50"
                                    />
                                    <span class="d-none d-sm-inline">Contact Person</span>
                                </template>
                                <party-edit-tab-contact-person
                                    :party-data="partyFormData"
                                    class="mt-2 pt-75"
                                />
                            </b-tab>

                            <b-tab>
                                <template #title>
                                    <feather-icon
                                        icon="MapPinIcon"
                                        size="16"
                                        class="mr-0 mr-sm-50"
                                    />
                                    <span class="d-none d-sm-inline">Address Work</span>
                                </template>
                                <party-edit-tab-address-work
                                    :party-data="partyFormData"
                                    class="mt-2 pt-75"
                                />
                            </b-tab>

                            <b-tab>
                                <template #title>
                                    <feather-icon
                                        icon="CheckSquareIcon"
                                        size="16"
                                        class="mr-0 mr-sm-50"
                                    />
                                    <span class="d-none d-sm-inline">Term & Conds</span>
                                </template>
                                <party-edit-tab-term-condition
                                    :party-data="partyFormData"
                                    class="mt-2 pt-75"
                                />
                            </b-tab>

                            <b-tab>
                                <template #title>
                                    <feather-icon
                                        icon="FileTextIcon"
                                        size="16"
                                        class="mr-0 mr-sm-50"
                                    />
                                    <span class="d-none d-sm-inline">Tax Details</span>
                                </template>
                                <party-edit-tab-tax-detail
                                    :party-data="partyFormData"
                                    class="mt-2 pt-75"
                                />
                            </b-tab>

                            <b-tab>
                                <template #title>
                                    <feather-icon
                                        icon="HomeIcon"
                                        size="16"
                                        class="mr-0 mr-sm-50"
                                    />
                                    <span class="d-none d-sm-inline">Bank Details</span>
                                </template>
                                <party-edit-tab-bank-detail
                                    :party-data="partyFormData"
                                    class="mt-2 pt-75"
                                />
                            </b-tab>

                            <b-tab>
                                <template #title>
                                    <feather-icon
                                        icon="FileIcon"
                                        size="16"
                                        class="mr-0 mr-sm-50"
                                    />
                                    <span class="d-none d-sm-inline">General</span>
                                </template>
                                <party-edit-tab-general
                                    :party-data="partyFormData"
                                    class="mt-2 pt-75"
                                />
                            </b-tab>

                            <b-tab>
                                <template #title>
                                    <feather-icon
                                        icon="BriefcaseIcon"
                                        size="16"
                                        class="mr-0 mr-sm-50"
                                    />
                                    <span class="d-none d-sm-inline">Company Profile</span>
                                </template>
                                <party-edit-tab-company-profile
                                    :party-data="partyFormData"
                                    class="mt-2 pt-75"
                                />
                            </b-tab>

                            <b-tab>
                                <template #title>
                                    <feather-icon
                                        icon="BookOpenIcon"
                                        size="16"
                                        class="mr-0 mr-sm-50"
                                    />
                                    <span class="d-none d-sm-inline">Billing Terms</span>
                                </template>
                                <party-edit-tab-billing-term
                                    :party-data="partyFormData"
                                    class="mt-2 pt-75"
                                />
                            </b-tab>

                            <b-tab>
                                <template #title>
                                    <feather-icon
                                        icon="TruckIcon"
                                        size="16"
                                        class="mr-0 mr-sm-50"
                                    />
                                    <span class="d-none d-sm-inline">Delivery Address</span>
                                </template>
                                <party-edit-tab-delivery-address
                                    :party-data="partyFormData"
                                    class="mt-2 pt-75"
                                />
                            </b-tab>
                            <b-tab>
                                <template #title>
                                    <feather-icon
                                        icon="MailIcon"
                                        size="16"
                                        class="mr-0 mr-sm-50"
                                    />
                                    <span class="d-none d-sm-inline">Envelope</span>
                                </template>
                                <hr>
                                <party-edit-envelope-tab/>
                            </b-tab>
                            <b-tab>
                                <template #title>
                                    <feather-icon
                                        icon="LogInIcon"
                                        size="16"
                                        class="mr-0 mr-sm-50"
                                    />
                                    <span class="d-none d-sm-inline">Login</span>
                                </template>
                                <hr>
                                <party-edit-login-tab
                                    :login-data="partyFormData.loginDetails"
                                />
                            </b-tab>
                        </b-tabs>
                    </b-col>
                </b-row>
            </b-card-code>
        </b-overlay>
    </div>
</template>

<script>
import BCardCode from '@core/components/b-card-code'
import {ValidationProvider, ValidationObserver} from 'vee-validate'
import {
    BRow, BCol, BFormGroup, BFormInput, BFormCheckbox, BForm, BButton, BTab, BTabs, BFormTextarea, BOverlay
} from 'bootstrap-vue'
import {required} from '@validations'
import Ripple from 'vue-ripple-directive'
import vSelect from 'vue-select'
import {ref, onUnmounted, onMounted} from '@vue/composition-api'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
import router from '@/router'
import store from '@/store'
import partyStoreModule from '../partyStoreModule'
import PartyEditTabPartyDetail from './PartyEditTabPartyDetail.vue'
import PartyEditTabContactPerson from './PartyEditTabContactPerson'
import PartyEditTabAddressWork from './PartyEditTabAddressWork'
import PartyEditTabTermCondition from './PartyEditTabTermCondition'
import PartyEditTabTaxDetail from './PartyEditTabTaxDetail'
import PartyEditTabBankDetail from './PartyEditTabBankDetail'
import PartyEditTabGeneral from './PartyEditTabGeneral'
import PartyEditTabCompanyProfile from './PartyEditTabCompanyProfile'
import PartyEditTabBillingTerm from './PartyEditTabBillingTerm'
import PartyEditTabDeliveryAddress from './PartyEditTabDeliveryAddress'
import axios from '@axios';
import PartyEditLoginTab from "./partyEditLoginTab.vue";
import {getUserData} from "../../../auth/utils";
import {getTcTodayDateTime} from "@core/utils/utils";
import {useToast} from "vue-toastification/composition";
import PartyEditEnvelopeTab from "./partyEditEnvelopeTab.vue";
import AppCollapse from '@core/components/app-collapse/AppCollapse.vue'
import AppCollapseItem from '@core/components/app-collapse/AppCollapseItem.vue'

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
        PartyEditEnvelopeTab,
        PartyEditLoginTab,
        PartyEditTabPartyDetail,
        PartyEditTabContactPerson,
        PartyEditTabAddressWork,
        PartyEditTabTermCondition,
        PartyEditTabTaxDetail,
        PartyEditTabBankDetail,
        PartyEditTabGeneral,
        PartyEditTabCompanyProfile,
        PartyEditTabBillingTerm,
        PartyEditTabDeliveryAddress,
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
        BTab,
        BTabs,
        BFormTextarea,
        BOverlay,
        vSelect,
        AppCollapse,
        AppCollapseItem,
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
    methods: {
        validationForm() {
            this.$http.get(`/api/party/check-name-with-id/${this.partyFormData.id}/${this.partyFormData.partyName}`).then(res => {
                if (res.data.data === false) {
                    this.updateData()
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
                            this.updateData()
                        } else {
                            this.partyFormData.partyName = null
                        }
                    })
                }
            })
        },
        updateData() {
            this.$refs.simpleRules.validate().then(success => {
                if (success) {
                    this.partyFormData.loginDetails.modifiedBy = this.currentUserData.first_name + ' ' + this.currentUserData.last_name;
                    this.partyFormData.loginDetails.modifiedDateTime = getTcTodayDateTime();
                    store.dispatch('master-edit/editPartyMaster', this.partyFormData).then(response => {
                        if (response.status === 200) {
                            this.$toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Party Edited',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: `You have successfully Edited Party Detail ${this.partyFormData.partyCode}.`,
                                },
                            })
                        }
                    })
                }
            })
        }
    },
    setup() {
        const PARTY_MASTER_APP_STORE_MODULE_NAME = 'master-edit'
        // Register module
        onMounted(() => {
            if (!store.hasModule(PARTY_MASTER_APP_STORE_MODULE_NAME)) store.registerModule(PARTY_MASTER_APP_STORE_MODULE_NAME, partyStoreModule)
        })
        // UnRegister on leave
        onUnmounted(() => {
            if (store.hasModule(PARTY_MASTER_APP_STORE_MODULE_NAME)) store.unregisterModule(PARTY_MASTER_APP_STORE_MODULE_NAME)
        })

        const toast = useToast();
        const showOverlayLoading = ref(false)
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
            partyStatus: null,
            partyActive: null,
            loginDetails: {
                createdBy: null,
                createdDateTime: null,
                modifiedBy: null,
                modifiedDateTime: null,
                approvedBy: null,
                approvedDateTime: null,
                stage: 'Created',
                stageReason: null
            }
        })

        const adminFormData = ref({
            partyStatus: null,
            rejectReason: null
        });

        const fetchData = async () => {
            showOverlayLoading.value = true
            await axios.get(`/api/party/edit/${router.currentRoute.params.id}`).then((response) => {
                partyFormData.value = response.data.data
                partyFormData.value.id = response.data.data._id
                delete partyFormData.value._id
                if (!response.data.data.loginDetails) {
                    partyFormData.value.loginDetails = {
                        createdBy: null,
                        createdDateTime: null,
                        modifiedBy: null,
                        modifiedDateTime: null,
                        approvedBy: null,
                        approvedDateTime: null,
                        stage: 'Created',
                        stageReason: null
                    }
                    adminFormData.value.partyStatus = response.data.data.partyStatus
                } else {
                    adminFormData.value.partyStatus = response.data.data.loginDetails.stage ?? response.data.data.partyStatus;
                    adminFormData.value.rejectReason = response.data.data.loginDetails.stageReason ?? null;
                }
            }).catch(error => {
                if (error.response.status === 404) {
                    partyFormData.value = undefined
                }
            });
            showOverlayLoading.value = false
        }
        fetchData();

        const PartyDealOption = [
            {label: 'Manufacturer', value: 1},
            {label: 'Dealer', value: 2},
            {label: 'Other', value: 3}]

        const PartyStatusOption = [{label: 'Created', value: 'Created'}, {
            label: 'Trial',
            value: 'Trial'
        }, {label: 'Approved', value: 'Approved'}, {label: 'Rejected', value: 'Rejected'}]

        const SupplyTypeOption = [{label: 'Intrastate', value: 1}, {
            label: 'Interstate',
            value: 2
        }, {label: 'Export', value: 3}]

        const BalanceTypeOption = [{label: 'CR', value: 1}, {label: 'DR', value: 2}]

        const changePartyStatusStage = async () => {
            let approvedBy = null, approvedDateTime = null;
            if (adminFormData.value.partyStatus === 'Approved'){
                approvedBy = currentUserData.value.first_name + ' ' + currentUserData.value.last_name;
                approvedDateTime = getTcTodayDateTime();
            }
            let updatedData = {
                id: router.currentRoute.params.id,
                partyStatus: adminFormData.value.partyStatus,
                loginDetails: {
                    createdBy: partyFormData.value.loginDetails.createdBy,
                    createdDateTime: partyFormData.value.loginDetails.createdDateTime,
                    modifiedBy: currentUserData.value.first_name + ' ' + currentUserData.value.last_name,
                    modifiedDateTime: getTcTodayDateTime(),
                    approvedBy: approvedBy,
                    approvedDateTime: approvedDateTime,
                    stage: adminFormData.value.partyStatus,
                    stageReason: adminFormData.value.rejectReason
                }
            }
            await store.dispatch('master-edit/editPartyMaster', updatedData).then((response) => {
                if (response.status === 200) {
                    toast({
                        component: ToastificationContent,
                        position: 'top-right',
                        props: {
                            title: 'Party status changed',
                            icon: 'CheckSquareIcon',
                            variant: 'success',
                            text: `You have successfully Change Party Status: ${adminFormData.value.partyStatus}.`,
                        },
                    });
                }
            });
            adminFormData.value.rejectReason = null;
            await fetchData();
        }

        return {
            adminFormData,
            BalanceTypeOption,
            changePartyStatusStage,
            PartyDealOption,
            PartyStatusOption,
            SupplyTypeOption,
            currentUserData,
            partyFormData,
            required,
            showOverlayLoading,
        }
    },
    created() {
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
