<template>
    <div>
        <b-overlay
            :show="showOverlayLoading"
            rounded="sm"
        >
            <div>
                <b-card-code v-if="CurrentUserData.role === 'admin'">
                    <b-row>
                        <b-col md="12">
                            <b-button
                                variant="outline-success"
                                type="button"
                                class="float-right"
                                @click="approveOrder"
                            >
                                Approve/Redo Order
                            </b-button>
                        </b-col>
                    </b-row>
                </b-card-code>
                <b-card-code>
                    <validation-observer ref="simpleRules">
                        <b-form>
                            <b-row>
                                <b-col md="12">
                                    <b-form-group
                                        label="Company"
                                        label-for="company"
                                    >
                                        <v-select
                                            placeholder="Select company"
                                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                            :options="companyOptions"
                                            :reduce="val => val.value"
                                            :clearable="false"
                                            input-id="company"
                                            v-model="salesOrderFormData.company"
                                        />
                                    </b-form-group>
                                </b-col>
                                <b-col md="6">
                                    <b-form-group
                                        label="Quotation Reference"
                                        label-for="itemQtnRefNo"
                                    >
                                        <b-form-input
                                            v-model="salesOrderFormData.qtnRefNo"
                                            readonly
                                        />
                                    </b-form-group>
                                </b-col>
                                <b-col md="6">
                                    <b-form-group
                                        label="Quotation SrNo."
                                        label-for="itemQtnSrNo"
                                    >
                                        <b-form-input
                                            id="itemQtnSrNo"
                                            v-model="salesOrderFormData.qtnSrNo"
                                            disabled
                                        />
                                    </b-form-group>
                                </b-col>
                                <b-col md="2">
                                    <b-form-group
                                        label="Sales Order No"
                                        label-for="salesOrderNo"
                                    >
                                        <b-form-input
                                            id="salesOrderNo"
                                            v-model="salesOrderFormData.salesOrderNo"
                                        />
                                    </b-form-group>
                                </b-col>
                                <b-col md="4">
                                    <b-form-group
                                        label="Sell To Party"
                                        label-for="customerId"
                                    >
                                        <validation-provider
                                            #default="{ errors }"
                                            name="Sell To Party"
                                            rules="required"
                                        >
                                            <v-select
                                                v-model="salesOrderFormData.sellToPartyCustomerID"
                                                taggable
                                                push-tags
                                                placeholder="Select Party"
                                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                                :options="PartyListOption"
                                                :reduce="val => val.value"
                                                :clearable="false"
                                                v-on:input="getPartyCode(salesOrderFormData.sellToPartyCustomerID)"
                                                input-id="sellToPartyCustomerID"
                                                :state="errors.length > 0 ? false:null"
                                            />
                                            <small class="text-danger">{{ errors[0] }}</small>
                                        </validation-provider>
                                    </b-form-group>
                                </b-col>
                                <b-col md="2">
                                    <b-form-group
                                        label="Customer Code"
                                        label-for="sellToPartyCustomerCode"
                                    >
                                        <b-form-input
                                            id="sellToPartyCustomerCode"
                                            v-model="salesOrderFormData.sellToPartyCustomerCode"
                                            readonly
                                        />
                                    </b-form-group>
                                </b-col>
                                <b-col md="4">
                                    <b-form-group
                                        label="Customer Name"
                                        label-for="sellToPartyCustomerName"
                                    >
                                        <b-form-input
                                            id="sellToPartyCustomerName"
                                            v-model="salesOrderFormData.sellToPartyCustomerName"
                                            readonly
                                        />
                                    </b-form-group>
                                </b-col>
                                <b-col md="3">
                                    <b-form-group
                                        label="S.O Date"
                                        label-for="salesOrderDate"
                                    >
                                        <b-input-group>
                                            <cleave
                                                id="salesOrderDate"
                                                v-model="salesOrderFormData.salesOrderDate"
                                                class="form-control"
                                                :raw="false"
                                                :options="dateFormat"
                                                placeholder="DD/MM/YYYY"
                                                show-decade-nav
                                            />
                                            <b-input-group-append>
                                                <b-form-datepicker
                                                    v-model="formatDates.soDate"
                                                    button-only
                                                    @input="getSoFormatDate($event)"
                                                    show-decade-nav
                                                    size="sm"
                                                    nav-button-variant="primary"
                                                />
                                            </b-input-group-append>
                                        </b-input-group>
                                    </b-form-group>
                                </b-col>
                                <b-col md="3">
                                    <b-form-group
                                        label="Committed Date"
                                        label-for="salesOrderCommittedDate"
                                    >
                                        <b-input-group>
                                            <cleave
                                                id="salesOrderCommittedDate"
                                                v-model="salesOrderFormData.salesOrderCommittedDate"
                                                class="form-control"
                                                :raw="false"
                                                :options="dateFormat"
                                                placeholder="DD/MM/YYYY"
                                                show-decade-nav
                                            />
                                            <b-input-group-append>
                                                <b-form-datepicker
                                                    v-model="formatDates.soCommittedDate"
                                                    button-only
                                                    @input="getSoCommittedDate($event)"
                                                    show-decade-nav
                                                    size="sm"
                                                    nav-button-variant="primary"
                                                />
                                            </b-input-group-append>
                                        </b-input-group>
                                    </b-form-group>
                                </b-col>
                                <b-col md="3">
                                    <b-form-group
                                        label="Review Date"
                                        label-for="salesOrderReviewDate"
                                    >
                                        <b-input-group>
                                            <cleave
                                                id="salesOrderReviewDate"
                                                v-model="salesOrderFormData.salesOrderReviewDate"
                                                class="form-control"
                                                :raw="false"
                                                :options="dateFormat"
                                                placeholder="DD/MM/YYYY"
                                                show-decade-nav
                                            />
                                            <b-input-group-append>
                                                <b-form-datepicker
                                                    v-model="formatDates.soReviewDate"
                                                    button-only
                                                    @input="getSoReviewDate($event)"
                                                    show-decade-nav
                                                    size="sm"
                                                    nav-button-variant="primary"
                                                />
                                            </b-input-group-append>
                                        </b-input-group>
                                    </b-form-group>
                                </b-col>

                                <b-col md="3">
                                    <b-form-group
                                        label="Branch"
                                        label-for="salesOrderBranch"
                                    >
                                        <v-select
                                            v-model="salesOrderFormData.salesOrderBranch"
                                            placeholder="Select Branch"
                                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                            :options="BranchOptions"
                                            :reduce="val => val.value"
                                            :clearable="false"
                                            input-id="salesOrderBranch"
                                        />
                                    </b-form-group>
                                </b-col>
                                <b-col md="3">
                                    <b-form-group
                                        label="Customer P.O NO."
                                        label-for="customerPoNo"
                                    >
                                        <b-form-input
                                            id="customerPoNo"
                                            v-model="salesOrderFormData.customerPoNo"
                                            placeholder="Customer P.O NO"
                                        />
                                    </b-form-group>
                                </b-col>
                                <b-col md="3">
                                    <b-form-group
                                        label="P.O Date"
                                        label-for="salesOrderPoDate"
                                    >
                                        <b-input-group>
                                            <cleave
                                                id="salesOrderPoDate"
                                                v-model="salesOrderFormData.salesOrderPoDate"
                                                class="form-control"
                                                :raw="false"
                                                :options="dateFormat"
                                                placeholder="DD/MM/YYYY"
                                                show-decade-nav
                                            />
                                            <b-input-group-append>
                                                <b-form-datepicker
                                                    v-model="formatDates.soPoDate"
                                                    button-only
                                                    @input="getSoPoDate($event)"
                                                    show-decade-nav
                                                    size="sm"
                                                    left
                                                    nav-button-variant="primary"
                                                />
                                            </b-input-group-append>
                                        </b-input-group>
                                    </b-form-group>
                                </b-col>

                                <b-col md="3">
                                    <b-form-group
                                        label="Supply Type"
                                        label-for="salesOrderSupplyType"
                                    >
                                        <v-select
                                            v-model="salesOrderFormData.salesOrderSupplyType"
                                            placeholder="Select Supply Type"
                                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                            :options="SupplyTypeOption"
                                            :reduce="val => val.value"
                                            :clearable="false"
                                            input-id="salesOrderSupplyType"
                                        />
                                    </b-form-group>
                                </b-col>
                                <b-col md="4">
                                    <b-form-group
                                        label="Currency"
                                        label-for="salesOrderCurrency"
                                    >
                                        <v-select
                                            placeholder="Select Currency"
                                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                            :options="currencyOptions"
                                            :reduce="val => val.value"
                                            :clearable="false"
                                            input-id="salesOrderCurrency"
                                            v-model="salesOrderFormData.salesOrderCurrency"
                                        />
                                    </b-form-group>
                                </b-col>
                                <b-col md="4">
                                    <b-form-group
                                        label="Conversion Rate"
                                        label-for="salesOrderConvRate"
                                    >
                                        <b-form-input
                                            id="salesOrderConvRate"
                                            v-model="salesOrderFormData.salesOrderConvRate"
                                        />
                                    </b-form-group>
                                </b-col>
                                <b-col md="4">
                                    <b-form-group
                                        label="Sales"
                                        label-for="salesOrderSalesType"
                                    >
                                        <v-select
                                            placeholder="Select Sales"
                                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                            :options="SalesTypeOptions"
                                            :reduce="val => val.value"
                                            :clearable="false"
                                            input-id="salesOrderSalesType"
                                            v-model="salesOrderFormData.salesOrderSalesType"
                                        />
                                    </b-form-group>
                                </b-col>
                                <b-col md="4">
                                    <b-form-group
                                        label="Status"
                                        label-for="salesOrderStatus"
                                    >
                                        <v-select
                                            placeholder="Select Status"
                                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                            :options="StatusOptions"
                                            :reduce="val => val.value"
                                            :clearable="false"
                                            input-id="salesOrderStatus"
                                            v-model="salesOrderFormData.salesOrderStatus"
                                        />
                                    </b-form-group>
                                </b-col>
                                <b-col md="4">
                                    <b-form-group
                                        label="Order Type"
                                        label-for="salesOrderType"
                                    >
                                        <v-select
                                            placeholder="Select Order Type"
                                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                            :options="OrderTypeOptions"
                                            :reduce="val => val.value"
                                            :clearable="false"
                                            input-id="salesOrderType"
                                            v-model="salesOrderFormData.salesOrderType"
                                        />
                                    </b-form-group>
                                </b-col>
                                <b-col md="4">
                                    <b-form-group
                                        label="Project"
                                        label-for="salesOrderProject"
                                    >
                                        <b-form-input
                                            id="salesOrderProject"
                                            v-model="salesOrderFormData.salesOrderProject"
                                        />
                                    </b-form-group>
                                </b-col>
                                <b-col md="3">
                                    <b-form-group
                                        label="Select Kind Attn"
                                        label-for="kindAttnId"
                                    >
                                        <v-select
                                            v-model="salesOrderFormData.kindAttnId"
                                            placeholder="Select Kind Attn"
                                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                            :options="KindAttnOptions"
                                            :reduce="val => val.value"
                                            :clearable="false"
                                            @input="getContactDetail(salesOrderFormData.kindAttnId)"
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
                                            v-model="salesOrderFormData.kindAttnName"
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
                                            v-model="salesOrderFormData.kindAttnMobile"
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
                                            v-model="salesOrderFormData.kindAttnEmail"
                                        />
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-col md="12">
                                <b-form-group
                                    label=""
                                    label-for="selectRound"
                                >
                                    <div class="demo-inline-spacing">
                                        <b-form-radio
                                            name="selectRound"
                                            value="0"
                                            v-model="salesOrderFormData.roundingType"
                                        >
                                            None
                                        </b-form-radio>
                                        <b-form-radio
                                            name="selectRound"
                                            value="1"
                                            v-model="salesOrderFormData.roundingType"
                                        >
                                            Rounding
                                        </b-form-radio>
                                        <b-form-radio
                                            name="selectRound"
                                            value="2"
                                            v-model="salesOrderFormData.roundingType"
                                        >
                                            Rounding All
                                        </b-form-radio>
                                    </div>
                                </b-form-group>
                            </b-col>
                            <b-row>
                                <!-- submit and reset -->
                                <b-col md="12">
                                    <hr>
                                    <b-button
                                        v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                                        type="submit"
                                        variant="primary"
                                        class="mr-1 float-right"
                                        @click.prevent="validationForm"
                                    >
                                        Submit
                                    </b-button>
                                </b-col>
                            </b-row>
                        </b-form>
                    </validation-observer>
                    <b-row>
                        <b-col md="12">
                            <hr>
                        </b-col>
                        <b-col md="12">
                            <b-tabs
                                pills
                                lazy
                            >
                                <b-tab active>
                                    <template #title>
                                        <feather-icon
                                            icon="PackageIcon"
                                            size="16"
                                            class="mr-0 mr-sm-50"
                                        />
                                        <span class="d-none d-sm-inline">Item Details</span>
                                    </template>
                                    <item-details
                                        :salesOrderNo="salesOrderFormData.salesOrderNo"
                                        :roundingType="salesOrderFormData.roundingType"
                                        :supplyType="salesOrderFormData.salesOrderSupplyType"
                                    />
                                </b-tab>
                                <b-tab>
                                    <template #title>
                                        <feather-icon
                                            icon="FileTextIcon"
                                            size="16"
                                            class="mr-0 mr-sm-50"
                                        />
                                        <span class="d-none d-sm-inline">Billing Terms</span>
                                    </template>
                                    <billing-terms-details
                                        :partyDetails="PartyDetailTabData"
                                        :roundingType="salesOrderFormData.roundingType"
                                    />
                                </b-tab>
                                <b-tab>
                                    <template #title>
                                        <feather-icon
                                            icon="ClipboardIcon"
                                            size="16"
                                            class="mr-0 mr-sm-50"
                                        />
                                        <span class="d-none d-sm-inline">Term & Conditions</span>
                                    </template>
                                    <term-condition-details
                                        :shellToPartyId="salesOrderFormData.sellToPartyCustomerID"
                                    />
                                </b-tab>
                                <b-tab>
                                    <template #title>
                                        <feather-icon
                                            icon="FileIcon"
                                            size="16"
                                            class="mr-0 mr-sm-50"
                                        />
                                        <span class="d-none d-sm-inline">Note</span>
                                    </template>
                                    <note-details
                                        :note-tab-data.sync="salesOrderFormData.noteDetails"
                                    />
                                </b-tab>
                                <b-tab>
                                    <template #title>
                                        <feather-icon
                                            icon="UserIcon"
                                            size="16"
                                            class="mr-0 mr-sm-50"
                                        />
                                        <span class="d-none d-sm-inline">Party</span>
                                    </template>
                                    <party-details
                                        :so-party-tab-data.sync="salesOrderFormData.partyDetail"
                                    />
                                </b-tab>
                                <b-tab>
                                    <template #title>
                                        <feather-icon
                                            icon="ShoppingCartIcon"
                                            size="16"
                                            class="mr-0 mr-sm-50"
                                        />
                                        <span class="d-none d-sm-inline">Buyer</span>
                                    </template>
                                    <buyer-tab-details
                                        :so-buyer-tab-data.sync="salesOrderFormData.buyerDetail"
                                        :so-party-list="PartyListOption"
                                    />
                                </b-tab>
                                <b-tab>
                                    <template #title>
                                        <feather-icon
                                            icon="TruckIcon"
                                            size="16"
                                            class="mr-0 mr-sm-50"
                                        />
                                        <span class="d-none d-sm-inline">Consignee</span>
                                    </template>
                                    <consignee-tab-details
                                        :so-consignee-tab-data.sync="salesOrderFormData.consigneeDetail"
                                        :so-party-list="PartyListOption"
                                    />
                                </b-tab>
                                <b-tab>
                                    <template #title>
                                        <feather-icon
                                            icon="TruckIcon"
                                            size="16"
                                            class="mr-0 mr-sm-50"
                                        />
                                        <span class="d-none d-sm-inline">Dispatch</span>
                                    </template>
                                    <dispatch-tab-details
                                        :soDispatchTabData.sync="salesOrderFormData.dispatchDetail"
                                        :so-party-list="PartyListOption"
                                    />
                                </b-tab>
                                <b-tab>
                                    <template #title>
                                        <feather-icon
                                            icon="UsersIcon"
                                            size="16"
                                            class="mr-0 mr-sm-50"
                                        />
                                        <span class="d-none d-sm-inline">Sales Agent</span>
                                    </template>
                                    <sales-agent-tab/>
                                </b-tab>
                                <b-tab>
                                    <template #title>
                                        <feather-icon
                                            icon="UsersIcon"
                                            size="16"
                                            class="mr-0 mr-sm-50"
                                        />
                                        <span class="d-none d-sm-inline">SO Stages</span>
                                    </template>
                                    <so-stages-tab
                                        :soStageData.sync="salesOrderFormData.soStageDetails"
                                    />
                                </b-tab>
                                <b-tab>
                                    <template #title>
                                        <feather-icon
                                            icon="UsersIcon"
                                            size="16"
                                            class="mr-0 mr-sm-50"
                                        />
                                        <span class="d-none d-sm-inline">SO History</span>
                                    </template>
                                    <so-history-tab/>
                                </b-tab>
                                <b-tab>
                                    <template #title>
                                        <feather-icon
                                            icon="UsersIcon"
                                            size="16"
                                            class="mr-0 mr-sm-50"
                                        />
                                        <span class="d-none d-sm-inline">Checklist</span>
                                    </template>
                                    <check-list-tab/>
                                </b-tab>
                                <b-tab>
                                    <template #title>
                                        <feather-icon
                                            icon="UsersIcon"
                                            size="16"
                                            class="mr-0 mr-sm-50"
                                        />
                                        <span class="d-none d-sm-inline">Payment Schedule</span>
                                    </template>
                                    <payment-schedule-tab/>
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
                                    <login-tab-details
                                        :so-login-details.sync="salesOrderFormData.loginDetail"
                                        :so-stage-details.sync="salesOrderFormData.SalesOrderStageDetail"
                                    />
                                </b-tab>
                                <b-tab>
                                    <template #title>
                                        <feather-icon
                                            icon="FileIcon"
                                            size="16"
                                            class="mr-0 mr-sm-50"
                                        />
                                        <span class="d-none d-sm-inline">Reports</span>
                                    </template>
                                    <hr>
                                    <report-detail-tab/>
                                </b-tab>
                            </b-tabs>
                        </b-col>
                    </b-row>
                </b-card-code>
            </div>
        </b-overlay>
    </div>
</template>

<script>
import BCardCode from '@core/components/b-card-code'
import { ValidationProvider, ValidationObserver } from 'vee-validate'
import {
    BRow,
    BCol,
    BFormGroup,
    BFormInput,
    BFormTextarea,
    BForm,
    BButton,
    BFormDatepicker,
    BOverlay,
    BTab,
    BTabs,
    BTable,
    BSpinner,
    BInputGroup,
    BInputGroupAppend,
    BInputGroupPrepend,
    BFormRadio
} from 'bootstrap-vue'
import { required } from '@validations'
import Ripple from 'vue-ripple-directive'
import vSelect from 'vue-select'
import router from '@/router'
import store from '@/store'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
import { ref, onUnmounted } from '@vue/composition-api'
import salesStoreModule from '../salesStoreModule'
import axios from '@axios'
import { getUserData } from '../../../auth/utils'
import moment from 'moment'
import ItemDetails from './tabs/itemDetails'
import BillingTermsDetails from './tabs/BillingTermsDetails'
import TermConditionDetails from './tabs/TermConditionDetails'
import NoteDetails from './tabs/NoteDetails'
import PartyDetails from './tabs/PartyDetails'
import buyerTabDetails from './tabs/buyerTabDetails'
import consigneeTabDetails from './tabs/consigneeTabDetails'
import loginTabDetails from './tabs/loginTabDetails'
import Swal from 'sweetalert2'
import { useToast } from 'vue-toastification/composition'
import SalesAgentTab from './tabs/SalesAgentTab'
import SoStagesTab from './tabs/SoStagesTab'
import SoHistoryTab from './tabs/SoHistoryTab'
import CheckListTab from './tabs/checkListTab'
import PaymentScheduleTab from './tabs/paymentScheduleTab'
import Cleave from 'vue-cleave-component'
import { forMatIndianDate } from '@core/utils/utils'
import DispatchTabDetails from './tabs/dispatchTabDetails'
import reportDetailTab from './tabs/reportDetailTab'

export default {
    components: {
        DispatchTabDetails,
        PaymentScheduleTab,
        CheckListTab,
        SoHistoryTab,
        SoStagesTab,
        SalesAgentTab,
        BCardCode,
        ValidationProvider,
        ValidationObserver,
        BRow,
        BCol,
        BFormGroup,
        BFormInput,
        BFormTextarea,
        BForm,
        BButton,
        BFormDatepicker,
        vSelect,
        BOverlay,
        BTab,
        BTabs,
        ItemDetails,
        BillingTermsDetails,
        TermConditionDetails,
        NoteDetails,
        PartyDetails,
        buyerTabDetails,
        consigneeTabDetails,
        loginTabDetails,
        reportDetailTab,
        BTable,
        BSpinner,
        BInputGroup,
        BInputGroupAppend,
        BInputGroupPrepend,
        Cleave,
        BFormRadio
    },
    directives: {
        Ripple,
    },
    methods: {
        validationForm() {
            this.$refs.simpleRules.validate()
                .then(success => {
                    if (success) {
                        this.salesOrderFormData.loginDetail.lastModifiedBy = this.CurrentUserData.first_name + ' ' + this.CurrentUserData.last_name
                        this.salesOrderFormData.loginDetail.modifiedDateTime = moment(new Date())
                            .format('DD/MM/YYYY HH:mm')
                        store.dispatch('sales-order-module/updateSalesOrder', this.salesOrderFormData)
                            .then(response => {
                                if (response.status === 200) {
                                    this.$toast({
                                        component: ToastificationContent,
                                        position: 'top-right',
                                        props: {
                                            title: 'Sales Order Updated',
                                            icon: 'CheckSquareIcon',
                                            variant: 'success',
                                            text: `You have successfully Edited Sales Order ${this.salesOrderFormData.salesOrderNo}.`,
                                        },
                                    })
                                }
                            })
                    }
                })
        },
    },
    setup() {
        const SO_APP_STORE_MODULE_NAME = 'sales-order-module'
        // Register module
        if (!store.hasModule(SO_APP_STORE_MODULE_NAME)) store.registerModule(SO_APP_STORE_MODULE_NAME, salesStoreModule)
        // UnRegister on leave
        onUnmounted(() => {
            if (store.hasModule(SO_APP_STORE_MODULE_NAME)) store.unregisterModule(SO_APP_STORE_MODULE_NAME)
        })
        const toast = useToast()

        const showOverlayLoading = ref(false)

        const CurrentPartyDetailData = ref([])

        const CurrentUserData = ref(getUserData())

        const PartyListOption = ref([])

        const BranchOptions = ref([])

        const currencyOptions = ref([])

        const KindAttnOptions = ref([])

        const PartyDetailTabData = ref({
            partyDetailId: null,
            partyDetailCode: null,
            partyDetailName: null,
            partyDetailAddress: null,
            partyDetailCityId: null,
            partyDetailCity: null,
            partyDetailStateId: null,
            partyDetailState: null,
            partyDetailCountryID: null,
            partyDetailCountry: null,
            partyDetailFaxNo: null,
            partyDetailEmailId: null,
            partyDetailWebsite: null,
            partyDetailTinVatNO: null,
            partyDetailTinCstNO: null,
            partyDetailTinEccNO: null,
            partyDetailGstNo: null,
            partyDetailPinCode: null,
            partyDetailPhoneNo: null,
            partyDetailPanNo: null,
        })

        const StatusOptions = ref([
            {
                label: 'Pending',
                value: 'Pending'
            },
            {
                label: 'Completed',
                value: 'Completed'
            },
            {
                label: 'Regret',
                value: 'Regret'
            },
            {
                label: 'Cancelled',
                value: 'Cancelled'
            },
        ])

        const SalesTypeOptions = ref([
            {
                label: 'Domestic',
                value: 1
            },
            {
                label: 'Export',
                value: 2
            },
        ])

        const OrderTypeOptions = ref([])

        axios.get('/api/get-sales-order-type-options')
            .then(res => {
                OrderTypeOptions.value = res.data.data
            })

        const SupplyTypeOption = ref([
            {
                label: 'Intrastate',
                value: 1
            },
            {
                label: 'Interstate',
                value: 2
            },
            {
                label: 'Export',
                value: 3
            },
        ])

        const GstPercentageOption = ref([
            {
                label: 'SO Wise',
                value: 1
            },
            {
                label: 'Invoice Wise',
                value: 2
            },
            {
                label: 'Item Wise',
                value: 3
            }
        ])

        axios.get('/api/party/get-master-customer-options')
            .then(res => {
                PartyListOption.value = res.data.data
            })

        axios.get('/api/get-branch-master-options')
            .then(res => {
                BranchOptions.value = res.data.data
            })

        axios.get('/api/get-currency-options')
            .then(res => {
                currencyOptions.value = res.data.data
            })

        const companyOptions = ref([])
        axios.get('/api/administration/get-company-options')
            .then(res => {
                companyOptions.value = res.data.data
            })

        const salesOrderFormData = ref({
            id: null,
            company: null,
            salesOrderNo: null,
            customerPoNo: null,
            salesOrderPoDate: null,
            salesOrderDate: null,
            salesOrderCommittedDate: null,
            salesOrderCurrency: null,
            salesOrderConvRate: null,
            salesOrderProject: null,
            kindAttnId: null,
            kindAttnName: null,
            kindAttnMobile: null,
            kindAttnEmail: null,
            salesOrderSalesType: null,
            salesOrderStatus: null,
            salesOrderType: null,
            salesOrderBranch: null,
            salesOrderSupplyType: null,
            salesOrderGstType: null,
            salesOrderReviewDate: null,
            sellToPartyCustomerID: null,
            sellToPartyCustomerCode: null,
            sellToPartyCustomerName: null,
            shipToPartyCustomerID: null,
            shipToPartyCustomerCode: null,
            shipToPartyCustomerName: null,
            itemDetails: null,
            termConditionDetails: null,
            roundingType: '0',
            qtnRefNo: null,
            qtnSrNo: null,
            noteDetails: ref({
                headerId: null,
                noteHeader: null,
                footerId: null,
                noteFooter: null,
                noteNote: null,
                noteNote2: null,
                noteInternalNote: null,
                noteItemDescTitle: null,
            }),
            partyDetail: PartyDetailTabData.value,
            buyerDetail: ref({
                buyerDetailId: null,
                buyerDetailCode: null,
                buyerDetailName: null,
                buyerDetailAddress: null,
                buyerDetailCityId: null,
                buyerDetailCity: null,
                buyerDetailStateId: null,
                buyerDetailState: null,
                buyerDetailCountryID: null,
                buyerDetailCountry: null,
                buyerDetailFaxNo: null,
                buyerDetailEmailId: null,
                buyerDetailWebsite: null,
                buyerDetailTinVatNO: null,
                buyerDetailTinCstNO: null,
                buyerDetailTinEccNO: null,
                buyerDetailGstNo: null,
                buyerDetailPinCode: null,
                buyerDetailPhoneNo: null,
                buyerDetailPanNo: null,
                buyerDetailPhoneStdCode: null,
            }),
            consigneeDetail: ref({
                consigneeDetailId: null,
                consigneeDetailCode: null,
                consigneeDetailName: null,
                consigneeDetailAddress: null,
                consigneeDetailCityId: null,
                consigneeDetailCity: null,
                consigneeDetailStateId: null,
                consigneeDetailState: null,
                consigneeDetailCountryID: null,
                consigneeDetailCountry: null,
                consigneeDetailFaxNo: null,
                consigneeDetailEmailId: null,
                consigneeDetailWebsite: null,
                consigneeDetailTinVatNO: null,
                consigneeDetailTinCstNO: null,
                consigneeDetailTinEccNO: null,
                consigneeDetailGstNo: null,
                consigneeDetailPinCode: null,
                consigneeDetailPhoneNo: null,
                consigneeDetailPanNo: null,
                consigneeDetailPhoneStdCode: null,
            }),
            dispatchDetail: ref({
                dispatchDetailId: null,
                dispatchDetailCode: null,
                dispatchDetailName: null,
                dispatchDetailAddress: null,
                dispatchDetailCityId: null,
                dispatchDetailCity: null,
                dispatchDetailStateId: null,
                dispatchDetailState: null,
                dispatchDetailCountryID: null,
                dispatchDetailCountry: null,
                dispatchDetailFaxNo: null,
                dispatchDetailEmailId: null,
                dispatchDetailWebsite: null,
                dispatchDetailTinVatNO: null,
                dispatchDetailTinCstNO: null,
                dispatchDetailTinEccNO: null,
                dispatchDetailGstNo: null,
                dispatchDetailPinCode: null,
                dispatchDetailPhoneNo: null,
                dispatchDetailPanNo: null,
                dispatchDetailPhoneStdCode: null,
            }),
            loginDetail: ref({
                createdBy: CurrentUserData.value.first_name + ' ' + CurrentUserData.value.last_name,
                createdDateTime: moment(new Date())
                    .format('DD/MM/YYYY HH:mm'),
                lastModifiedBy: CurrentUserData.value.first_name + ' ' + CurrentUserData.value.last_name,
                modifiedDateTime: moment(new Date())
                    .format('DD/MM/YYYY HH:mm'),
            }),
            SalesOrderStageDetail: ref({
                preparedBy: CurrentUserData.value.first_name + ' ' + CurrentUserData.value.last_name,
                preparedDateTime: moment(new Date())
                    .format('DD/MM/YYYY HH:mm'),
                approvedBy: null,
                approveDateTime: null,
                orderStatus: null,
                approveUser: null,
                stage: 'Prepared',
            }),
        })
        showOverlayLoading.value = true

        store.dispatch('sales-order-module/fetchSalesOrderDetail', { id: router.currentRoute.params.id })
            .then(response => {
                salesOrderFormData.value = response.data.data
                salesOrderFormData.value.id = response.data.data._id
                delete salesOrderFormData.value._id
                if (!response.data.data.noteDetails) {
                    salesOrderFormData.value.noteDetails = {
                        headerId: null,
                        footerId: null,
                        noteHeader: null,
                        noteFooter: null,
                        noteNote: null,
                        noteNote2: null,
                        noteInternalNote: null,
                        noteItemDescTitle: null,
                    }
                } else {
                    salesOrderFormData.value.noteDetails = {
                        headerId: response.data.data.noteDetails.headerId ?? null,
                        footerId: response.data.data.noteDetails.footerId ?? null,
                        noteHeader: response.data.data.noteDetails.noteHeader ?? null,
                        noteFooter: response.data.data.noteDetails.noteFooter ?? null,
                        noteNote: response.data.data.noteDetails.noteNote ?? null,
                        noteNote2: response.data.data.noteDetails.noteNote2 ?? null,
                        noteInternalNote: response.data.data.noteDetails.noteInternalNote ?? null,
                        noteItemDescTitle: response.data.data.noteDetails.noteItemDescTitle ?? null,
                    }
                }
                if (!response.data.data.buyerDetail) {
                    salesOrderFormData.value.buyerDetail = {
                        buyerDetailId: null,
                        buyerDetailCode: null,
                        buyerDetailName: null,
                        buyerDetailAddress: null,
                        buyerDetailCityId: null,
                        buyerDetailCity: null,
                        buyerDetailStateId: null,
                        buyerDetailState: null,
                        buyerDetailCountryID: null,
                        buyerDetailCountry: null,
                        buyerDetailFaxNo: null,
                        buyerDetailEmailId: null,
                        buyerDetailWebsite: null,
                        buyerDetailTinVatNO: null,
                        buyerDetailTinCstNO: null,
                        buyerDetailTinEccNO: null,
                        buyerDetailGstNo: null,
                        buyerDetailPinCode: null,
                        buyerDetailPhoneNo: null,
                    }
                }
                if (!response.data.data.consigneeDetail) {
                    salesOrderFormData.value.consigneeDetail = {
                        consigneeDetailId: null,
                        consigneeDetailCode: null,
                        consigneeDetailName: null,
                        consigneeDetailAddress: null,
                        consigneeDetailCityId: null,
                        consigneeDetailCity: null,
                        consigneeDetailStateId: null,
                        consigneeDetailState: null,
                        consigneeDetailCountryID: null,
                        consigneeDetailCountry: null,
                        consigneeDetailFaxNo: null,
                        consigneeDetailEmailId: null,
                        consigneeDetailWebsite: null,
                        consigneeDetailTinVatNO: null,
                        consigneeDetailTinCstNO: null,
                        consigneeDetailTinEccNO: null,
                        consigneeDetailGstNo: null,
                        consigneeDetailPinCode: null,
                        consigneeDetailPhoneNo: null,
                    }
                }
                if (!response.data.data.dispatchDetail) {
                    salesOrderFormData.value.dispatchDetail = {
                        dispatchDetailId: null,
                        dispatchDetailCode: null,
                        dispatchDetailName: null,
                        dispatchDetailAddress: null,
                        dispatchDetailCityId: null,
                        dispatchDetailCity: null,
                        dispatchDetailStateId: null,
                        dispatchDetailState: null,
                        dispatchDetailCountryID: null,
                        dispatchDetailCountry: null,
                        dispatchDetailFaxNo: null,
                        dispatchDetailEmailId: null,
                        dispatchDetailWebsite: null,
                        dispatchDetailTinVatNO: null,
                        dispatchDetailTinCstNO: null,
                        dispatchDetailTinEccNO: null,
                        dispatchDetailGstNo: null,
                        dispatchDetailPinCode: null,
                        dispatchDetailPhoneNo: null,
                    }
                }
                if (response.data.data.partyDetail) {
                    PartyDetailTabData.value = response.data.data.partyDetail
                }
                axios.get(`/api/party/get-party-contacts-options/${response.data.data.sellToPartyCustomerID}`)
                    .then(res => {
                        KindAttnOptions.value = res.data.data
                    })
                showOverlayLoading.value = false
            })
            .catch(error => {
                if (error.response.status === 404) {
                    salesOrderFormData.value = undefined
                    showOverlayLoading.value = false
                }
            })

        const getPartyCode = async (val) => {
            await axios.get(`/api/party/edit/${val}`)
                .then(res => {
                    CurrentPartyDetailData.value = res.data.data
                    salesOrderFormData.value.sellToPartyCustomerCode = CurrentPartyDetailData.value.partyCode
                    salesOrderFormData.value.sellToPartyCustomerName = CurrentPartyDetailData.value.partyName
                    salesOrderFormData.value.shipToPartyCustomerID = val
                    salesOrderFormData.value.shipToPartyCustomerCode = CurrentPartyDetailData.value.partyCode
                    salesOrderFormData.value.shipToPartyCustomerName = CurrentPartyDetailData.value.partyName
                    PartyDetailTabData.value.partyDetailId = val
                    PartyDetailTabData.value.partyDetailCode = CurrentPartyDetailData.value.partyCode
                    PartyDetailTabData.value.partyDetailName = CurrentPartyDetailData.value.partyName
                    if (CurrentPartyDetailData.value.partyDetails) {
                        PartyDetailTabData.value.partyDetailAddress = CurrentPartyDetailData.value.partyDetails.partyAddress
                        if (CurrentPartyDetailData.value.partyDetails.partyCity) {
                            PartyDetailTabData.value.partyDetailCityId = CurrentPartyDetailData.value.partyDetails.partyCity.value
                            PartyDetailTabData.value.partyDetailCity = CurrentPartyDetailData.value.partyDetails.partyCity.label
                        }
                        if (CurrentPartyDetailData.value.partyDetails.partyState) {
                            PartyDetailTabData.value.partyDetailStateId = CurrentPartyDetailData.value.partyDetails.partyState.value
                            PartyDetailTabData.value.partyDetailState = CurrentPartyDetailData.value.partyDetails.partyState.label
                        }
                        if (CurrentPartyDetailData.value.partyDetails.partyCountry) {
                            PartyDetailTabData.value.partyDetailCountryID = CurrentPartyDetailData.value.partyDetails.partyCountry.value
                            PartyDetailTabData.value.partyDetailCountry = CurrentPartyDetailData.value.partyDetails.partyCountry.label
                        }
                        PartyDetailTabData.value.partyDetailFaxNo = CurrentPartyDetailData.value.partyDetails.partyFaxNo
                        PartyDetailTabData.value.partyDetailEmailId = CurrentPartyDetailData.value.partyDetails.partyEmilId
                        PartyDetailTabData.value.partyDetailWebsite = CurrentPartyDetailData.value.partyDetails.partyWebsite
                        PartyDetailTabData.value.partyDetailPinCode = CurrentPartyDetailData.value.partyDetails.partyPinCode
                        PartyDetailTabData.value.partyDetailStdCode = CurrentPartyDetailData.value.partyDetails.partyCountryCode
                        PartyDetailTabData.value.partyDetailPhoneNo = CurrentPartyDetailData.value.partyDetails.partyPhoneNo
                    }
                    if (CurrentPartyDetailData.value.taxDetails) {
                        PartyDetailTabData.value.partyDetailGstNo = CurrentPartyDetailData?.value.taxDetails.gstin
                        PartyDetailTabData.value.partyDetailTinVatNO = CurrentPartyDetailData?.value.taxDetails.tinVatNo
                        PartyDetailTabData.value.partyDetailTinCstNO = CurrentPartyDetailData?.value.taxDetails.tinCstNo
                        PartyDetailTabData.value.partyDetailTinEccNO = CurrentPartyDetailData?.value.taxDetails.eccNo
                    }

                    if (CurrentPartyDetailData.value.partyCurrencyType) {

                        salesOrderFormData.value.salesOrderCurrency = CurrentPartyDetailData.value.partyCurrencyType

                        axios.get(`/api/currency-master/${CurrentPartyDetailData.value.partyCurrencyType}`)
                            .then(Curres => {

                                if (Curres.data.data) {

                                    salesOrderFormData.value.salesOrderConvRate = Curres.data.data.currencyRate
                                }
                            })

                    }

                    if (CurrentPartyDetailData.value.partySupplyType) {

                        salesOrderFormData.value.salesOrderSupplyType = CurrentPartyDetailData.value.partySupplyType
                    }

                    if (CurrentPartyDetailData.value.partyBranch) {

                        salesOrderFormData.value.salesOrderBranch = CurrentPartyDetailData.value.partyBranch.value
                    }

                })
            salesOrderFormData.value.kindAttnId = null
            await axios.get(`/api/party/get-party-contacts-options/${val}`)
                .then(res => {
                    KindAttnOptions.value = res.data.data
                })
        }

        const getContactDetail = async (val) => {
            await axios.get(`/api/party/contact-person/${val}`)
                .then(res => {
                    salesOrderFormData.value.kindAttnName = res.data.data.personName
                    salesOrderFormData.value.kindAttnMobile = res.data.data.mobileNo
                    salesOrderFormData.value.kindAttnEmail = res.data.data.email
                })
        }

        const refetchItemData = async () => {
            await axios.get(`/api/get-sales-order-items/${router.currentRoute.params.id}`)
        }

        const approveOrder = async () => {
            await Swal.fire({
                title: 'Are you sure?',
                text: 'Name is already exist',
                icon: 'warning',
                showCancelButton: true,
                showDenyButton: true,
                confirmButtonText: 'Yes, Approve!',
                denyButtonText: 'No, Redo!',
                cancelButtonText: 'Cancel',
                customClass: {
                    confirmButton: 'btn btn-outline-success',
                    cancelButton: 'btn btn-outline-danger ml-1',
                    denyButton: 'btn btn-outline-warning ml-1',
                },
                buttonsStyling: false,
            })
                .then(result => {
                    if (result.isConfirmed) {
                        acceptDeclineEvent(1)
                    }
                    if (result.isDenied) {
                        acceptDeclineEvent(2)
                    }
                    if (result.isDismissed) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Cancel',
                                icon: 'AlertCircleIcon',
                                variant: 'danger',
                                text: 'You have abort the task!',
                            },
                        })
                    }
                })
        }

        const acceptDeclineEvent = async (status) => {
            salesOrderFormData.value.id = router.currentRoute.params.id
            salesOrderFormData.value.SalesOrderStageDetail.approvedBy = getUserData()._id
            salesOrderFormData.value.SalesOrderStageDetail.approveDateTime = moment()
                .format('DD/MM/YYYY HH:MM')
            salesOrderFormData.value.SalesOrderStageDetail.stage = status === 1 ? 'Approved' : 'Decline'
            salesOrderFormData.value.SalesOrderStageDetail.approveUser = getUserData().first_name + ' ' + getUserData().last_name

            await store.dispatch('sales-order-module/updateSalesOrder', salesOrderFormData.value)
                .then(res => {
                    if (res.data.status === 200) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Status Changed',
                                icon: 'ThumbsUpIcon',
                                variant: 'success',
                                text: 'Order Status Change Successfully!',
                            },
                        })
                    } else {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Error',
                                icon: 'AlertCircleIcon',
                                variant: 'danger',
                                text: 'Something went wrong!',
                            },
                        })
                    }
                })
            await refetchItemData()
        }

        const dateFormat = ref({
            date: true,
            delimiter: '/',
            datePattern: ['d', 'm', 'Y'],
        })

        const formatDates = ref({
            soDate: null,
            soCommittedDate: null,
            soPoDate: null,
            soReviewDate: null,
        })

        const getSoFormatDate = (date) => {
            salesOrderFormData.value.salesOrderDate = forMatIndianDate(date)
        }
        const getSoCommittedDate = (date) => {
            salesOrderFormData.value.salesOrderCommittedDate = forMatIndianDate(date)
        }
        const getSoPoDate = (date) => {
            salesOrderFormData.value.salesOrderPoDate = forMatIndianDate(date)
        }
        const getSoReviewDate = (date) => {
            salesOrderFormData.value.salesOrderReviewDate = forMatIndianDate(date)
        }

        return {
            dateFormat,
            formatDates,
            getSoFormatDate,
            getSoCommittedDate,
            getSoPoDate,
            getSoReviewDate,
            PartyListOption,
            BranchOptions,
            currencyOptions,
            KindAttnOptions,
            CurrentPartyDetailData,
            StatusOptions,
            SalesTypeOptions,
            OrderTypeOptions,
            SupplyTypeOption,
            GstPercentageOption,
            salesOrderFormData,
            getPartyCode,
            getContactDetail,
            showOverlayLoading,
            PartyDetailTabData,
            CurrentUserData,
            approveOrder,
            acceptDeclineEvent,
            refetchItemData,
            companyOptions,
            required,
        }
    },
}
</script>
<style lang="scss">
@import '~@core/scss/vue/libs/vue-sweetalert.scss';
</style>
<style lang="scss" scoped>
@import '~@core/scss/base/bootstrap-extended/include';
@import '~@core/scss/base/components/variables-dark';

.dark-layout {
    div ::v-deep .card .card-body {
        .b-overlay {
            .bg-light {
                background-color: $theme-dark-body-bg !important;
            }
        }
    }
}
</style>
