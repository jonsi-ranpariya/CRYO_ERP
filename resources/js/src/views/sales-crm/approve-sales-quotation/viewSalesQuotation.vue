<template>
    <div>
        <b-card-code>
            <b-overlay
                :show="showOverLay"
                rounded="sm"
            >
                <b-row>
                    <b-col md="12">
                        <b-button
                            variant="outline-primary"
                            type="button"
                            :to="{ name: 'edit-sales-quotation', id: currentId }"
                            class="float-right ml-1"
                        >
                            Edit Quotation
                        </b-button>
                        <b-button
                            variant="outline-success"
                            type="button"
                            class="float-right"
                            @click="approveQuotation"
                        >
                            Approve/Decline Quotation
                        </b-button>
                    </b-col>
                </b-row>
            </b-overlay>
        </b-card-code>
        <b-card-code>
            <b-overlay
                :show="showOverLay"
                rounded="sm"
            >
                <b-row>
                    <b-col md="6">
                        <b-row>
                            <b-col md="6">
                                <b-form-group
                                    label="Quotation No."
                                    label-for="quotationNo"
                                >
                                    <b-form-input
                                        id="quotationNo"
                                        v-model="partyFormData.quotationNo"
                                        readonly
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Enquiry No."
                                    label-for="enquiryNo"
                                >
                                    <b-form-input
                                        id="enquiryNo"
                                        v-model="partyFormData.enquiryNo"
                                        readonly
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="6">
                                <b-form-group
                                    label="Enquiry Date"
                                    label-for="enquiryDate"
                                >
                                    <b-input-group>
                                        <cleave
                                            id="enquiryDate"
                                            v-model="partyFormData.enquiryDate"
                                            class="form-control"
                                            :raw="false"
                                            :options="dateFormat"
                                            placeholder="DD/MM/YYYY"
                                            show-decade-nav
                                            disabled
                                        />
                                        <b-input-group-append>
                                            <b-form-datepicker
                                                v-model="formatDates.enquiryDate"
                                                button-only
                                                @input="getEnquiryFormateDate($event)"
                                                show-decade-nav
                                                size="sm"
                                                nav-button-variant="primary"
                                                disabled
                                            />
                                        </b-input-group-append>
                                    </b-input-group>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Quotation Date"
                                    label-for="quotationDate"
                                >
                                    <b-input-group>
                                        <cleave
                                            id="quotationDate"
                                            v-model="partyFormData.quotationDate"
                                            class="form-control"
                                            :raw="false"
                                            :options="dateFormat"
                                            placeholder="DD/MM/YYYY"
                                            show-decade-nav
                                            disabled
                                        />
                                        <b-input-group-append>
                                            <b-form-datepicker
                                                v-model="formatDates.quotationDate"
                                                button-only
                                                @input="getQuotationFormateDate($event)"
                                                show-decade-nav
                                                size="sm"
                                                nav-button-variant="primary"
                                                disabled
                                            />
                                        </b-input-group-append>
                                    </b-input-group>
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="6">
                                <b-form-group
                                    label="Customer Code"
                                    label-for="customerCode"
                                >
                                    <b-form-input
                                        id="customerCode"
                                        v-model="partyFormData.customerCode"
                                        readonly
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Customer Name"
                                    label-for="customerName"
                                >
                                    <b-form-input
                                        id="customerName"
                                        v-model="partyFormData.customerName"
                                        readonly
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="6">
                                <b-form-group
                                    label="Currency"
                                    label-for="currency"
                                >
                                    <v-select
                                        placeholder="Select Currency"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="currencyOptions"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        input-id="currency"
                                        v-model="partyFormData.currency"
                                        disabled
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Conv. Rate"
                                    label-for="convRate"
                                >
                                    <b-form-input
                                        id="convRate"
                                        type="number"
                                        v-model="partyFormData.convRate"
                                        readonly
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="6">
                                <b-form-group
                                    label="Sales"
                                    label-for="sales"
                                >
                                    <v-select
                                        placeholder="Select Sales"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="SalesOptions"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        input-id="sales"
                                        v-model="partyFormData.sales"
                                        disabled
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Status"
                                    label-for="status"
                                >
                                    <v-select
                                        placeholder="Select Status"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="statusOptions"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        input-id="status"
                                        v-model="partyFormData.status"
                                        disabled
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="6">
                                <b-form-group
                                    label="Branch"
                                    label-for="branch"
                                >
                                    <v-select
                                        placeholder="Select Branch"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="branchOptions"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        input-id="branch"
                                        v-model="partyFormData.branch"
                                        disabled
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Branch Qtn No."
                                    label-for="branchQtnNo"
                                >
                                    <b-form-input
                                        id="branchQtnNo"
                                        type="number"
                                        v-model="partyFormData.branchQtyNo"
                                        readonly
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="6">
                                <b-form-group
                                    label="rev"
                                    label-for="rev"
                                >
                                    <b-form-input
                                        id="rev"
                                        readonly
                                        type="number"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Rev Date"
                                    label-for="revDate"
                                >
                                    <b-input-group>
                                        <b-input-group-prepend>
                                            <b-form-datepicker
                                                v-model="formatDates.revDate"
                                                button-only
                                                @input="getRevFormateDate($event)"
                                                show-decade-nav
                                                size="sm"
                                                nav-button-variant="primary"
                                                disabled
                                            />
                                        </b-input-group-prepend>
                                        <cleave
                                            id="revDate"
                                            v-model="partyFormData.revDate"
                                            class="form-control"
                                            :raw="false"
                                            :options="dateFormat"
                                            placeholder="DD/MM/YYYY"
                                            show-decade-nav
                                            disabled
                                        />
                                    </b-input-group>
                                </b-form-group>
                            </b-col>
                        </b-row>
                    </b-col>
                    <b-col md="6">
                        <b-row>
                            <b-col md="6">
                                <b-form-group
                                    label="Date"
                                    label-for="date"
                                >
                                    <b-input-group>
                                        <cleave
                                            id="date"
                                            v-model="partyFormData.date"
                                            class="form-control"
                                            :raw="false"
                                            :options="dateFormat"
                                            placeholder="DD/MM/YYYY"
                                            show-decade-nav
                                            disabled
                                        />
                                        <b-input-group-append>
                                            <b-form-datepicker
                                                v-model="formatDates.date"
                                                button-only
                                                @input="getFormateDate($event)"
                                                show-decade-nav
                                                size="sm"
                                                nav-button-variant="primary"
                                                disabled
                                            />
                                        </b-input-group-append>
                                    </b-input-group>
                                </b-form-group>
                                <b-form-group
                                    label="Qtn Type"
                                    label-for="qtnType"
                                >
                                    <v-select
                                        placeholder="Select Qtn Type"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="qtnOptions"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        input-id="qtnType"
                                        v-model="partyFormData.qtnType"
                                        disabled
                                    />
                                </b-form-group>
                                <b-form-group
                                    label="Sales Type"
                                    label-for="salesType"
                                >
                                    <v-select
                                        placeholder="Select Sales Type"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="SalesTypeOptions"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        input-id="salesType"
                                        v-model="partyFormData.salesType"
                                        disabled
                                    />
                                </b-form-group>
                                <b-form-group
                                    label="Reason"
                                    label-for="reason"
                                >
                                    <v-select
                                        placeholder="Select Reason Type"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="reasonOptions"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        input-id="reason"
                                        v-model="partyFormData.reason"
                                        disabled
                                    />
                                </b-form-group>
                                <b-form-group
                                    label="Reason Remark"
                                    label-for="reasonRemark"
                                >
                                    <b-form-textarea
                                        rows="2"
                                        id="reasonRemark"
                                        v-model="partyFormData.reasonRemark"
                                        readonly
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Review Date"
                                    label-for="reviewDate"
                                >
                                    <b-input-group>
                                        <b-input-group-prepend>
                                            <b-form-datepicker
                                                v-model="formatDates.reviewDate"
                                                button-only
                                                @input="getReviewFormateDate($event)"
                                                show-decade-nav
                                                size="sm"
                                                nav-button-variant="primary"
                                                disabled
                                            />
                                        </b-input-group-prepend>
                                        <cleave
                                            id="reviewDate"
                                            v-model="partyFormData.reviewDate"
                                            class="form-control"
                                            :raw="false"
                                            :options="dateFormat"
                                            placeholder="DD/MM/YYYY"
                                            show-decade-nav
                                            disabled
                                        />
                                    </b-input-group>
                                </b-form-group>
                                <b-form-group
                                    label="Due Date"
                                    label-for="dueDate"
                                >
                                    <b-input-group>
                                        <b-input-group-prepend>
                                            <b-form-datepicker
                                                v-model="formatDates.dueDate"
                                                button-only
                                                @input="getDueFormateDate($event)"
                                                show-decade-nav
                                                size="sm"
                                                nav-button-variant="primary"
                                                disabled
                                            />
                                        </b-input-group-prepend>
                                        <cleave
                                            id="dueDate"
                                            v-model="partyFormData.dueDate"
                                            class="form-control"
                                            :raw="false"
                                            :options="dateFormat"
                                            placeholder="DD/MM/YYYY"
                                            show-decade-nav
                                            disabled
                                        />
                                    </b-input-group>
                                </b-form-group>
                                <b-form-group
                                    label="Exp Closure Date"
                                    label-for="expClosureDate"
                                >
                                    <b-input-group>
                                        <b-input-group-prepend>
                                            <b-form-datepicker
                                                v-model="formatDates.expClosureDate"
                                                button-only
                                                @input="getExpFormateDate($event)"
                                                show-decade-nav
                                                size="sm"
                                                nav-button-variant="primary"
                                                disabled
                                            />
                                        </b-input-group-prepend>
                                        <cleave
                                            id="expClosureDate"
                                            v-model="partyFormData.expClosureDate"
                                            class="form-control"
                                            :raw="false"
                                            :options="dateFormat"
                                            placeholder="DD/MM/YYYY"
                                            show-decade-nav
                                            disabled
                                        />
                                    </b-input-group>
                                </b-form-group>
                                <b-form-group
                                    label="Action"
                                    label-for="action"
                                >
                                    <v-select
                                        placeholder="Select Action"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="actionOptions"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        input-id="action"
                                        v-model="partyFormData.action"
                                        disabled
                                    />
                                </b-form-group>
                                <b-form-group
                                    label="Qtn Stage"
                                    label-for="qtnStage"
                                >
                                    <v-select
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="qtnStageOptions"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        input-id="qtnStage"
                                        v-model="partyFormData.qtnStage"
                                        disabled
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-form-group
                            label="Rounding Type"
                            label-for="selectRound"
                            class="mt-2"
                        >
                            <div class="demo-inline-spacing" style="margin-top: -10px;">
                                <b-form-radio
                                    name="selectRound"
                                    v-model="partyFormData.roundingType"
                                    value="0"
                                >
                                    None
                                </b-form-radio>
                                <b-form-radio
                                    name="selectRound"
                                    v-model="partyFormData.roundingType"
                                    value="1"
                                >
                                    Rounding
                                </b-form-radio>
                                <b-form-radio
                                    name="selectRound"
                                    v-model="partyFormData.roundingType"
                                    value="2"
                                >
                                    Rounding All
                                </b-form-radio>
                            </div>
                        </b-form-group>

                    </b-col>
                </b-row>
                <b-row>
                    <b-col md="12">
                        <hr>
                        <b-tabs pills>
                            <b-tab active>
                                <template #title>
                                    <feather-icon
                                        icon="UserIcon"
                                        size="16"
                                        class="mr-0 mr-sm-50"
                                    />
                                    <span class="d-none d-sm-inline">Customer Details</span>
                                </template>
                                <customer-details-tab
                                    :customerData.sync="partyFormData.customerDetailsData"
                                />
                            </b-tab>
                            <b-tab>
                                <template #title>
                                    <feather-icon
                                        icon="LayersIcon"
                                        size="16"
                                        class="mr-0 mr-sm-50"
                                    />
                                    <span class="d-none d-sm-inline">Item Details</span>
                                </template>
                                <item-details-tab
                                    :tableData.sync="tableData.itemDetailsFields"
                                    :itemData.sync="partyFormData.item_details"
                                    :uomOptions="uomOptions"
                                    :itemOptions="itemOptions"
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
                                <billing-term-tab
                                    :tableData="tableData.billingTermFields"
                                    :billingData.sync="partyFormData.billingTermsData"
                                    :billingOptions="billingOptions"
                                />
                            </b-tab>
                            <b-tab>
                                <template #title>
                                    <feather-icon
                                        icon="PaperclipIcon"
                                        size="16"
                                        class="mr-0 mr-sm-50"
                                    />
                                    <span class="d-none d-sm-inline">Term & Condition</span>
                                </template>
                                <term-and-condition-tab
                                    :tableData="tableData.termAndConditionFields"
                                    :termData.sync="partyFormData.termAndConditionData"
                                />
                            </b-tab>
                            <!--                              :termAndConditionOptions="termAndConditionOptions"-->
                            <b-tab>
                                <template #title>
                                    <feather-icon
                                        icon="ServerIcon"
                                        size="16"
                                        class="mr-0 mr-sm-50"
                                    />
                                    <span class="d-none d-sm-inline">Header/Footer</span>
                                </template>
                                <header-or-footer-tab
                                    :headerFooterData.sync="partyFormData.headerOrFooterData"
                                    :headerOptions="headerOptions"
                                    :footerOptions="footerOptions"
                                />
                            </b-tab>
                            <b-tab>
                                <template #title>
                                    <feather-icon
                                        icon="BookIcon"
                                        size="16"
                                        class="mr-0 mr-sm-50"
                                    />
                                    <span class="d-none d-sm-inline">Note</span>
                                </template>
                                <note-tab
                                    :authorisedByOptions="authorisedByOptions"
                                    :noteData.sync="partyFormData.noteData"
                                />
                            </b-tab>
                            <b-tab>
                                <template #title>
                                    <feather-icon
                                        icon="FileIcon"
                                        size="16"
                                        class="mr-0 mr-sm-50"
                                    />
                                    <span class="d-none d-sm-inline">Qtn Spec</span>
                                </template>
                                <qtn-spec-tab
                                    :qtnSpecData.sync="partyFormData.qtnSpecData"
                                />
                            </b-tab>
                            <b-tab>
                                <template #title>
                                    <feather-icon
                                        icon="UsersIcon"
                                        size="16"
                                        class="mr-0 mr-sm-50"
                                    />
                                    <span class="d-none d-sm-inline">Sales Person</span>
                                </template>
                                <sales-agent-tab
                                    :tableData="tableData.salesPersonFields"
                                    :salesAgentData.sync="this.partyFormData.salesPersonData"
                                    :userList="authorisedByOptions"
                                />
                            </b-tab>
                            <b-tab>
                                <template #title>
                                    <feather-icon
                                        icon="TrelloIcon"
                                        size="16"
                                        class="mr-0 mr-sm-50"
                                    />
                                    <span class="d-none d-sm-inline">Follow Up History</span>
                                </template>
                                <follow-up-history-tab
                                    :tableData="tableData.followUpFields"
                                    :usersList="authorisedByOptions"
                                    :followUpData.sync="partyFormData.followUpHistoryData"
                                />
                            </b-tab>
                            <b-tab>
                                <template #title>
                                    <feather-icon
                                        icon="FileIcon"
                                        size="16"
                                        class="mr-0 mr-sm-50"
                                    />
                                    <span class="d-none d-sm-inline">Login</span>
                                </template>
                                <login-tab
                                    :loginData.sync="partyFormData.loginData"
                                    :loginDetails="loginDetails"
                                    :usersList="authorisedByOptions"
                                />
                            </b-tab>
                        </b-tabs>
                    </b-col>
                </b-row>
            </b-overlay>
        </b-card-code>
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
        VBModal,
        BFormTextarea,
        BForm,
        BButton,
        BFormDatepicker,
        BTab,
        BTabs,
        BOverlay,
        BFormCheckbox,
        BInputGroup,
        BInputGroupPrepend,
        BInputGroupAppend,
        BFormRadio
    } from 'bootstrap-vue'
    import {required} from '@validations'
    import Ripple from 'vue-ripple-directive'
    import vSelect from 'vue-select'
    import store from '@/store'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import {ref, onUnmounted} from '@vue/composition-api'
    import salesStoreModule from '../salesStoreModule'
    import router from '@/router'
    import axios from '@axios'
    import moment from 'moment'
    import CustomerDetailsTab from "./tabs/customerDetailsTab";
    import ItemDetailsTab from "./tabs/itemDetailsTab";
    import BillingTermTab from "./tabs/billingTermsTab";
    import TermAndConditionTab from "./tabs/termAndConditionTab";
    import HeaderOrFooterTab from "./tabs/headerOrFooterTab";
    import NoteTab from "./tabs/noteTab";
    import QtnSpecTab from "./tabs/qtnSpecTab";
    import SalesAgentTab from "./tabs/salesAgentTab";
    import FollowUpHistoryTab from "./tabs/followUpHistoryTab";
    import LoginTab from "./tabs/loginTab";
    import Swal from 'sweetalert2'
    import { useToast } from 'vue-toastification/composition'
    import { forMatIndianDate, forMatIndianDateAndTime } from '@core/utils/utils'
    import Cleave from 'vue-cleave-component'
    import { getUserData } from '../../../auth/utils'

    export default {
        components: {
            LoginTab,
            FollowUpHistoryTab,
            SalesAgentTab,
            QtnSpecTab,
            NoteTab,
            HeaderOrFooterTab,
            TermAndConditionTab,
            BillingTermTab,
            ItemDetailsTab,
            CustomerDetailsTab,
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
            BFormCheckbox,
            BTab,
            BTabs,
            BOverlay,
            vSelect,
            Cleave,
            BInputGroup,
            BInputGroupPrepend,
            BInputGroupAppend,
            BFormRadio
        },
        directives: {
            'b-model': VBModal,
            Ripple,
        },
        setup() {
            const SE_APP_STORE_MODULE_NAME = 'sales-enquiry-module'
            if (!store.hasModule(SE_APP_STORE_MODULE_NAME)) store.registerModule(SE_APP_STORE_MODULE_NAME, salesStoreModule)
            onUnmounted(() => {
                if (store.hasModule(SE_APP_STORE_MODULE_NAME)) store.unregisterModule(SE_APP_STORE_MODULE_NAME)
            })
            const currentUser = getUserData()
            const toast = useToast()
            const dateFormat = ref({
                date: true,
                delimiter: '/',
                datePattern: ['d', 'm', 'Y'],
            })

            const formatDates = ref({
                enquiryDate: null,
                quotationDate: null,
                date: null,
                reviewDate: null,
                dueDate: null,
                expClosureDate: null,
                revDate: null,
            })

            const getEnquiryFormateDate = (date) => {
                partyFormData.value.enquiryDate = forMatIndianDate(date)
            }
            const getQuotationFormateDate = (date) => {
                partyFormData.value.quotationDate = forMatIndianDate(date)
            }
            const getFormateDate = (date) => {
                partyFormData.value.date = forMatIndianDate(date)
            }
            const getReviewFormateDate = (date) => {
                partyFormData.value.reviewDate = forMatIndianDate(date)
            }
            const getDueFormateDate = (date) => {
                partyFormData.value.dueDate = forMatIndianDate(date)
            }
            const getExpFormateDate = (date) => {
                partyFormData.value.expClosureDate = forMatIndianDate(date)
            }
            const getRevFormateDate = (date) => {
                partyFormData.value.revDate = forMatIndianDate(date)
            }
            const showOverLay = ref(true)
            const currentId = router.currentRoute.params.id
            const partyFormData = ref({
                id: null,
                quotationNo: null,
                enquiryNo: null,
                enquiryDate: forMatIndianDate(),
                quotationDate: forMatIndianDate(),
                customerCode: null,
                customerName: null,
                currency: null,
                convRate: null,
                sales: null,
                status: null,
                branch: null,
                branchQtyNo: null,
                date: forMatIndianDate(),
                qtnType: null,
                salesType: null,
                reason: null,
                reasonRemark: null,
                reviewDate: forMatIndianDate(),
                dueDate: forMatIndianDate(),
                expClosureDate: forMatIndianDate(),
                action: null,
                qtnStage: null,
                roundingType: null,
                revDate:forMatIndianDate(),
                customerDetailsData: {
                    customerCode: null,
                    customerName: null,
                    reference: null,
                    address: null,
                    city: null,
                    state: null,
                    country: null,
                    faxNo: null,
                    email: null,
                    project: null,
                    referenceDate: null,
                    ourReference: null,
                    pincode: null,
                    phoneNo: null,
                    personName: null,
                    mobileNo: null,
                    emailId: null,
                },
                billingTermsData: [],
                termAndConditionData: [],
                headerOrFooterData: {
                    headerType: null,
                    header: null,
                    footerType: null,
                    footer: null,
                    subject: null,
                },
                noteData: {
                    quotationNote: null,
                    authorisedBy: null,
                    referenceNote: null,
                    itemDescTitle: null,
                    addonTitle: null,
                },
                qtnSpecData: {
                    specificationOne: null,
                    specificationTwo: null,
                    specificationThree: null,
                },
                loginData: {
                    createdBy: null,
                    createdDateTime: null,
                    lastModifiedBy: null,
                    modifiedDateTime: null,
                    prepareBy: null,
                    prepareDateTime: null,
                    stage: 1,
                    instructedBy: null,
                    instructedByName: null,
                    followUpBy: null,
                    followUpByName: null,
                    approvedBy: null,
                    approvedDateTime: null,
                },
                salesPersonData: [],
                followUpHistoryData: [],
            })
            const loginDetails = ref({
                createdBy: null,
                createdDateTime: null,
                lastModifiedBy: null,
                modifiedDateTime: null,
                prepareBy: null,
                prepareDateTime: null,
                stage: 1,
                instructedBy: null,
                instructedByName: null,
                followUpBy: null,
                followUpByName: null,
                approvedBy: null,
                approvedDateTime: null,
            })
            const refetchItemData = async () => {
                axios.get(`/api/sales-quotation/${router.currentRoute.params.id}`).then(res => {
                    showOverLay.value = true
                    partyFormData.value = res.data?.data
                    partyFormData.value.id = res.data.data?._id
                    partyFormData.value.billingTermsData = res.data.data?.billing_terms
                    partyFormData.value.termAndConditionData = res.data.data?.termAndConditionData
                    partyFormData.value.salesPersonData = res.data.data?.salesPersonData
                    partyFormData.value.headerOrFooterData = res.data.data?.headerOrFooterData
                    partyFormData.value.noteData = res.data.data?.noteData
                    partyFormData.value.qtnSpecData = res.data.data?.qtnSpecData
                    loginDetails.value = res.data.data.loginData
                    delete partyFormData.value._id
                    showOverLay.value = false
                })
            }
            refetchItemData()
            const enquiryOptions = ref([])
            axios.get('/api/sales-enquiry-options').then(res => {
                enquiryOptions.value = res.data?.data
            })

            const currencyOptions = ref([])
            axios.get('/api/get-currency-options').then(res => {
                currencyOptions.value = res.data?.data
            })

            const branchOptions = ref([])
            axios.get('/api/get-branch-master-options').then(res => {
                branchOptions.value = res.data?.data
            })

            const reasonOptions = ref([])
            axios.get('/api/get-quotation-reason-master-options').then(res => {
                reasonOptions.value = res.data?.data
            })

            const uomOptions = ref([])
            axios.get('/api/get-uom-master-options').then(res => {
                uomOptions.value = res.data?.data
            })

            const itemOptions = ref([])
            axios.get('/api/get-item-master-options').then(res => {
                itemOptions.value = res.data?.data
            })

            const billingOptions = ref([])
            axios.get('/api/get-billing-master-options').then(res => {
                billingOptions.value = res.data?.data
            })

            const SalesOptions = ref([
                {label: 'Domestic', value: 1},
                {label: 'Export', value: 2},
            ])
            const SalesTypeOptions = ref([
                {label: 'Product Order', value: 1},
                {label: 'Machine Order', value: 2},
                {label: 'Spare Order', value: 3},
                {label: 'Repairing & Service', value: 4},
            ])
            const qtnOptions = ref([
                {label: 'Product Quotation', value: 1},
                {label: 'Spares Quotation', value: 2},
                {label: 'Service Quotation', value: 3},
                {label: 'Budgetory Quotation', value: 4},
            ])
            const statusOptions = ref([
                {label: 'Hot', value: 1},
                {label: 'Cold', value: 2},
                {label: 'Received', value: 3},
                {label: 'Regret', value: 4},
                {label: 'Lost', value: 5},
            ])
            const actionOptions = ref([
                {label: 'No Action', value: 1},
                {label: 'Sent', value: 2},
                {label: 'Mailed', value: 3},
            ])
            const qtnStageOptions = ref([
                {label: 'Active', value: 1},
                {label: 'Achieved', value: 2},
                {label: 'Regret', value: 3},
                {label: 'Closed', value: 4},
                {label: 'Followup', value: 5},
            ])

            // const termAndConditionOptions = ref([])
            // axios.post('/api/get-term-condition-by-type', {type: 1}).then(res => {
            //     termAndConditionOptions.value = res.data?.data
            // })

            const headerOptions = ref([])
            axios.get('/api/new/document-sales-enquiry-header-options').then(res => {
                headerOptions.value = res.data?.data
            })

            const footerOptions = ref([])
            axios.get('/api/new/document-sales-enquiry-footer-options').then(res => {
                footerOptions.value = res.data?.data
            })

            const authorisedByOptions = ref([])
            axios.get('/api/get-users-options').then(res => {
                authorisedByOptions.value = res.data?.data
            })

            const tableData = ref({
                itemDetailsFields: [
                    {
                        key: 'srNo',
                        label: 'Sr No'
                    },
                    {
                        key: 'itemCode',
                        label: 'Item Code'
                    },
                    {
                        key: 'itemDescription',
                        label: 'Description'
                    },
                    {
                        key: 'uom_details.uom',
                        label: 'uom'
                    },
                    {
                        key: 'requireQty',
                        label: 'Quantity'
                    },
                    {
                        key: 'rate',
                        label: 'Rate'
                    },
                    {
                        key: 'amount',
                        label: 'Amount'
                    },
                    {
                        key: 'status',
                        label: 'Status'
                    },
                    {
                        key: 'action',
                        label: 'action'
                    },
                ],
                billingTermFields: [
                    {
                        key: 'index',
                        label: 'No'
                    },
                    {
                        key: 'calCodeLabel',
                        label: 'code',
                    },
                    {
                        key: 'description',
                        label: 'Name',
                    },
                    {
                        key: 'calDefination',
                        label: 'Defination'
                    },
                    {
                        key: 'percentage',
                        label: 'Percent (%)'
                    },
                    {
                        key: 'byValue',
                        label: 'Value'
                    },
                    {
                        key: 'calculateAmount',
                        label: 'Amount'
                    },
                    {
                        key: 'action',
                        label: 'Action'
                    }
                ],
                termAndConditionFields: [
                    {
                        key: 'no',
                        label: 'No',
                    },
                    {
                        key: 'groupName',
                        label: 'Group',
                    },
                    {
                        key: 'termAndCondition',
                        label: 'Term & Condition'
                    },
                    {
                        key: 'action',
                        label: 'Action'
                    }
                ],
                salesPersonFields: [
                    {
                        key: 'no',
                        label: 'No'
                    },
                    {
                        key: 'salesAgent',
                        label: 'Sales Agent'
                    },
                    {
                        key: 'salesOffice',
                        label: 'Sales Office'
                    },
                    {
                        key: 'comm',
                        label: 'Comm'
                    },
                    {
                        key: 'action',
                        label: 'Action'
                    }
                ],
                followUpFields: [
                    {
                        key: 'no',
                        label: 'No',
                    },
                    {
                        key: 'date',
                        label: 'Date',
                        formatter: value => moment(value).format('DD/MM/YYYY'),
                    },
                    {
                        key: 'history',
                        label: 'History'
                    },
                    {
                        key: 'followUpBy.label',
                        label: 'Followup By'
                    },
                    {
                        key: 'action',
                        label: 'Action'
                    }
                ]
            })

            const approveQuotation = () => {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Name is already exist",
                    icon: 'warning',
                    showCancelButton: true,
                    showDenyButton: true,
                    confirmButtonText: 'Yes, Approve!',
                    denyButtonText: 'No, Decline!',
                    cancelButtonText: 'Cancel',
                    customClass: {
                        confirmButton: 'btn btn-outline-success',
                        cancelButton: 'btn btn-outline-danger ml-1',
                        denyButton: 'btn btn-outline-warning ml-1',
                    },
                    buttonsStyling: false,
                }).then(result => {
                    if (result.isConfirmed){
                        acceptDeclineEvent(1)
                    }
                    if (result.isDenied){
                        acceptDeclineEvent(2)
                    }
                    if (result.isDismissed){
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
                let formData
                if (status === 2) {
                    formData = {
                        id: currentId,
                        quotationStatus: status,
                        loginData: {
                            createdBy: loginDetails.value.createdBy ?? null,
                            createdDateTime: loginDetails.value.createdDateTime ?? null,
                            lastModifiedBy: loginDetails.value.lastModifiedBy ?? null,
                            modifiedDateTime: loginDetails.value.modifiedDateTime ?? null,
                            prepareBy: loginDetails.value.prepareBy ?? null,
                            prepareDateTime: loginDetails.value.prepareDateTime ?? null,
                            stage: 3,
                            instructedBy: loginDetails.value.instructedBy ?? null,
                            instructedByName: loginDetails.value.instructedByName ?? null,
                            followUpBy: loginDetails.value.followUpBy ?? null,
                            followUpByName: loginDetails.value.followUpByName ?? null,
                            approvedBy: null,
                            approvedDateTime: null,
                        }
                    }
                } else {
                    formData = {
                        id: currentId,
                        quotationStatus: status,
                        loginData: {
                            createdBy: loginDetails.value.createdBy ?? null,
                            createdDateTime: loginDetails.value.createdDateTime ?? null,
                            lastModifiedBy: loginDetails.value.lastModifiedBy ?? null,
                            modifiedDateTime: loginDetails.value.modifiedDateTime ?? null,
                            prepareBy: loginDetails.value.prepareBy ?? null,
                            prepareDateTime: loginDetails.value.prepareDateTime ?? null,
                            stage: 2,
                            instructedBy: loginDetails.value.instructedBy ?? null,
                            instructedByName: loginDetails.value.instructedByName ?? null,
                            followUpBy: loginDetails.value.followUpBy ?? null,
                            followUpByName: loginDetails.value.followUpByName ?? null,
                            approvedBy: currentUser.first_name + ' ' + currentUser.last_name,
                            approvedDateTime: forMatIndianDateAndTime(new Date()),
                        }
                    }
                }
                await store.dispatch('sales-enquiry-module/updateSalesQuotation', formData).then(res => {
                    if (res.data.status === 200){
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Status Changed',
                                icon: 'ThumbsUpIcon',
                                variant: 'success',
                                text: 'Quotation Status Change Successfully!',
                            },
                        })
                    }else{
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

            return {
                showOverLay,
                currentId,
                enquiryOptions,
                currencyOptions,
                branchOptions,
                reasonOptions,
                SalesOptions,
                SalesTypeOptions,
                qtnOptions,
                statusOptions,
                actionOptions,
                qtnStageOptions,
                uomOptions,
                itemOptions,
                tableData,
                billingOptions,
                // termAndConditionOptions,
                headerOptions,
                footerOptions,
                authorisedByOptions,
                loginDetails,
                partyFormData,
                approveQuotation,
                acceptDeclineEvent,
                dateFormat,
                formatDates,
                getDueFormateDate,
                getReviewFormateDate,
                getEnquiryFormateDate,
                getExpFormateDate,
                getFormateDate,
                getQuotationFormateDate,
                getRevFormateDate,
                refetchItemData
            }
        }
    }
</script>
<style lang="scss">
    @import '~@core/scss/vue/libs/vue-sweetalert.scss';
</style>
