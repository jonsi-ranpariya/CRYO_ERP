<template>
    <div>
        <b-card-code>
            <validation-observer ref="simpleRules">
                <b-form>
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
                                        <b-input-group>
                                            <b-form-input
                                                v-model="partyFormData.enquiryNo"
                                                readonly
                                            />
                                            <b-input-group-append>
                                                <b-button variant="primary" v-b-modal.inquiryList>...</b-button>
                                            </b-input-group-append>
                                        </b-input-group>
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
                                            />
                                            <b-input-group-append>
                                                <b-form-datepicker
                                                    v-model="formatDates.enquiryDate"
                                                    button-only
                                                    @input="getEnquiryFormateDate($event)"
                                                    show-decade-nav
                                                    size="sm"
                                                    nav-button-variant="primary"
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
                                            />
                                            <b-input-group-append>
                                                <b-form-datepicker
                                                    v-model="formatDates.quotationDate"
                                                    button-only
                                                    @input="getQuotationFormateDate($event)"
                                                    show-decade-nav
                                                    size="sm"
                                                    nav-button-variant="primary"
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
                                            @input="getConversionRate($event)"
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
                                            v-model="partyFormData.branchQtyNo"
                                        />
                                    </b-form-group>
                                </b-col>
                            </b-row>
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
                                            />
                                            <b-input-group-append>
                                                <b-form-datepicker
                                                    v-model="formatDates.date"
                                                    button-only
                                                    @input="getFormateDate($event)"
                                                    show-decade-nav
                                                    size="sm"
                                                    nav-button-variant="primary"
                                                />
                                            </b-input-group-append>
                                        </b-input-group>
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
                                            />
                                        </b-input-group>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-form-group
                                label="Due Date"
                                label-for="dueDate"
                            >
                                <b-input-group>
                                    <cleave
                                        id="dueDate"
                                        v-model="partyFormData.dueDate"
                                        class="form-control"
                                        :raw="false"
                                        :options="dateFormat"
                                        placeholder="DD/MM/YYYY"
                                        show-decade-nav
                                    />
                                    <b-input-group-append>
                                        <b-form-datepicker
                                            v-model="formatDates.dueDate"
                                            button-only
                                            @input="getDueFormateDate($event)"
                                            show-decade-nav
                                            size="sm"
                                            nav-button-variant="primary"
                                        />
                                    </b-input-group-append>
                                </b-input-group>
                            </b-form-group>
                        </b-col>
                        <b-col md="6">
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
                                            />
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
                                />
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
                                />
                            </b-form-group>
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
                                    <customer-details
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
                                    <item-details
                                        :tableData.sync="tableData"
                                        :itemData.sync="partyFormData.itemDetailsData"
                                        :uomOptions="uomOptions"
                                        :itemOptions="itemOptions"
                                        :rounding-type="partyFormData.roundingType"
                                        @updateBillingTermData="updateBillingTerm($event)"
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
                                    <billing-term
                                        :tableData.sync="tableData"
                                        :billingData.sync="partyFormData.billingTermsData"
                                        :billingOptions.sync="billingOptions"
                                        :billingTermCalculateData="billingTermCalculateData"
                                        @updateBillingTermData="updateBillingTerm($event)"
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
                                    <term-and-condition
                                        :tableData="tableData"
                                        :termData.sync="partyFormData.termAndConditionData"
                                        :termAndConditionOptions="termAndConditionOptions"
                                        :party-id="partyFormData.partyId"
                                    />
                                </b-tab>
                                <b-tab>
                                    <template #title>
                                        <feather-icon
                                            icon="ServerIcon"
                                            size="16"
                                            class="mr-0 mr-sm-50"
                                        />
                                        <span class="d-none d-sm-inline">Header/Footer</span>
                                    </template>
                                    <header-or-footer
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
                                    <note
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
                                    <qtn-spec
                                        :qtnSpecData.sync="partyFormData.qtnSpecData"
                                        :usersList="authorisedByOptions"
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
                                    <sales-agent
                                        :tableData="tableData.salesPersonFields"
                                        :salesAgentData.sync="partyFormData.salesPersonData"
                                        :userList="authorisedByOptions"
                                    />
                                </b-tab>
                            </b-tabs>
                        </b-col>
                    </b-row>
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
        </b-card-code>
        <b-modal
            id="inquiryList"
            title="Select Sales Inquiry"
            ok-title="submit"
            cancel-variant="danger"
            size="xl"
            no-close-on-backdrop
            @cancel="resetModalData"
            @close="resetModalData"
            @ok="getItemDetails"
            scrollable
        >
            <hr>
            <h5>Inquiry List</h5>
            <hr>
            <b-table
                :fields="modalTableFields.enquiryFields"
                :items="modalTableData.enquiryData"
                :no-border-collapse="false"
                responsive="sm"
                bordered
                hover
                show-empty
                class="table_scroll"
            >
                <template #empty="scope">
                    <h5 class="text-center text-uppercase">No Inquiry List Available</h5>
                </template>
                <template #cell(action)="data">
                    <b-button
                        variant="flat-primary"
                        size="sm"
                        :id="`b_${data.item._id}`"
                        @click="getEnquiryItems(data.item)"
                    >
                        Select
                    </b-button>
                </template>
            </b-table>
            <hr>
            <h4>Item List</h4>
            <hr>
            <b-table
                :fields="modalTableFields.itemListFields"
                :items="modalTableData.itemListData"
                :no-border-collapse="false"
                responsive
                bordered
                hover
                show-empty
                class="table_scroll"
            >
                <template #empty="scope">
                    <h5 class="text-center text-uppercase">No Items Available</h5>
                </template>
                <template #cell(yesNo)="data">
                    <b-form-checkbox-group>
                        <b-form-checkbox
                            :value="`${data.item._id}`"
                            class="custom-control-primary"
                            @change="selectedItemData.push(`${data.item._id}`)"
                        />
                    </b-form-checkbox-group>
                </template>
                <template #cell(srNo)="data">
                    {{ data.index + 1 }}
                </template>
            </b-table>
        </b-modal>
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
        BFormTextarea,
        BForm,
        BButton,
        BFormDatepicker,
        BTab,
        BTabs,
        BInputGroup,
        BTable,
        BInputGroupAppend,
        BFormCheckbox,
        BFormCheckboxGroup,
        BInputGroupPrepend,
        BFormRadio
    } from 'bootstrap-vue'
    import {required} from '@validations'
    import Ripple from 'vue-ripple-directive'
    import vSelect from 'vue-select'
    import store from '@/store'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import {ref, onUnmounted} from '@vue/composition-api'
    import salesStoreModule from '../salesStoreModule'
    import itemDetails from './tabs/itemDetails'
    import customerDetails from './tabs/customerDetails'
    import BillingTerm from "./tabs/billingTerm";
    import TermAndCondition from "./tabs/termAndCondition";
    import HeaderOrFooter from "./tabs/headerOrFooter";
    import Note from "./tabs/note";
    import QtnSpec from "./tabs/qtnSpec";
    import SalesAgent from "./tabs/salesAgent";
    import axios from '@axios'
    import moment from 'moment'
    import { changeToRound, getTcTodayDate } from '@core/utils/utils'
    import {getUserData} from "../../../auth/utils";
    import Cleave from 'vue-cleave-component'
    import {forMatIndianDate} from "@core/utils/utils";

    export default {
        components: {
            SalesAgent,
            QtnSpec,
            Note,
            HeaderOrFooter,
            TermAndCondition,
            BillingTerm,
            itemDetails,
            customerDetails,
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
            BTab,
            BTabs,
            BInputGroup,
            BInputGroupAppend,
            BTable,
            BFormCheckbox,
            BFormCheckboxGroup,
            vSelect,
            Cleave,
            BInputGroupPrepend,
            BFormRadio
        },
        directives: {
            Ripple,
        },
        setup() {
            const SE_APP_STORE_MODULE_NAME = 'sales-enquiry-module'
            if (!store.hasModule(SE_APP_STORE_MODULE_NAME)) store.registerModule(SE_APP_STORE_MODULE_NAME, salesStoreModule)
            onUnmounted(() => {
                if (store.hasModule(SE_APP_STORE_MODULE_NAME)) store.unregisterModule(SE_APP_STORE_MODULE_NAME)
            })

            const getConversionRate = async (id) => {
                await axios.get(`/api/currency-master/${id}`).then(res => {
                    partyFormData.value.convRate = res.data.data.currencyRate
                })
            }

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

            const SalesOptions = ref([
                {label: 'Domestic', value: 1},
                {label: 'Export', value: 2},
            ])
            const statusAllOptions = ref([
                {label: 'Pending', value: 1},
                {label: 'Completed', value: 2},
                {label: 'Regret', value: 3},
                {label: 'Cancelled', value: 4},
            ])

            const SalesTypeOptions = ref([])
            axios.get('/api/get-sales-order-type-options')
                .then(res => {
                    SalesTypeOptions.value = res.data.data
                })

            const CurrentUserData = ref(getUserData())

            const tableData = ref({
                fields: [
                    {
                        key: 'srNo',
                        label: 'Sr No'
                    },
                    {
                        key: 'itemCode.label',
                        label: 'Item Code'
                    },
                    {
                        key: 'itemDescription',
                        label: 'Description'
                    },
                    {
                        key: 'uom',
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
                        key: 'status.label',
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
                        key: 'group',
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
                    },
                    {
                        key: 'history',
                        label: 'History'
                    },
                    {
                        key: 'followUpBy',
                        label: 'Followup By'
                    },
                    {
                        key: 'action',
                        label: 'Action'
                    }
                ]
            })

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
                {label: 'Active/Closed', value: 1},
                {label: 'Achieved', value: 2},
                {label: 'Regret', value: 3},
                {label: 'Followup', value: 4},
                // {label: 'Closed', value: 5},
            ])

            const currencyOptions = ref([])

            axios.get('/api/get-currency-options').then(res => {
                currencyOptions.value = res.data.data
            })

            const branchOptions = ref([])

            axios.get('/api/get-branch-master-options').then(res => {
                branchOptions.value = res.data.data
            })

            const uomOptions = ref([])

            axios.get('/api/get-uom-master-options').then(res => {
                uomOptions.value = res.data.data
            })

            const reasonOptions = ref([])

            axios.get('/api/get-quotation-reason-master-options').then(res => {
                reasonOptions.value = res.data.data
            })

            const billingOptions = ref([])

            axios.get('/api/get-billing-template-master-options').then(res => {
                billingOptions.value = res.data.data
            })

            const termAndConditionOptions = ref([])

            axios.get('/api/get-term-condition-detail-with-group-options').then(res => {
                termAndConditionOptions.value = res.data.data
            })

            const headerOptions = ref([])

            axios.post('/api/document-sales-header-options', {type: 2}).then(res => {
                headerOptions.value = res.data.data
            })

            const footerOptions = ref([])

            axios.post('/api/document-sales-footer-options', {type: 2}).then(res => {
                footerOptions.value = res.data.data
            })

            const authorisedByOptions = ref([])

            axios.get('/api/get-users-options').then(res => {
                authorisedByOptions.value = res.data.data
            })

            const itemOptions = ref([])

            axios.get('/api/get-item-master-options').then(res => {
                itemOptions.value = res.data.data
            })

            const modalTableFields = ref({
                enquiryFields: [
                    {
                        key: 'action',
                        label: ''
                    },
                    {
                        key: 'enquiryNo',
                        label: 'Enquiry No'
                    },
                    {
                        key: 'created_at',
                        label: 'date',
                        formatter: value => moment(value).format('DD-MM-YYYY'),
                    },
                    {
                        key: 'customerName',
                        label: 'Customer Name'
                    },
                    {
                        key: 'enquiryStatus',
                        label: 'Status',
                        formatter: val => getStatus(val)
                    }
                ],
                itemListFields: [
                    {
                        key: 'yesNo',
                        label: 'Yes/No'
                    },
                    {
                        key: 'srNo',
                        label: 'Sr No'
                    },
                    {
                        key: 'itemCode.label',
                        label: 'Item Code'
                    },
                    {
                        key: 'itemDescription',
                        label: 'Description'
                    },
                    {
                        key: 'uom_details.uom',
                        label: 'UOM'
                    },
                    {
                        key: 'requireQty',
                        label: 'Quantity'
                    },
                    {
                        key: 'drawingNumber',
                        label: 'Drawing No'
                    }
                ]
            })

            const modalTableData = ref({
                enquiryData: [],
                itemListData: []
            })

            const getStatus = (id) => {
                let valObj = statusAllOptions.value.filter(function (elem) {
                    if (elem.value === id) {
                        return elem.label
                    }
                })
                if (valObj.length > 0) {
                    return valObj[0].label
                } else {
                    return ''
                }
            }

            axios.get('/api/new/get-approved-sales-enquiry-item-list').then(res => {
                modalTableData.value.enquiryData = res.data.data
            })

            const partyFormData = ref({
                id: null,
                quotationNo: null,
                enquiryNo: null,
                enquiryDate: forMatIndianDate(),
                quotationDate: forMatIndianDate(getTcTodayDate()),
                partyId: null,
                customerCode: null,
                customerName: null,
                currency: null,
                convRate: null,
                sales: null,
                status: 1,
                branch: null,
                branchQtyNo: null,
                date: forMatIndianDate(getTcTodayDate()),
                qtnType: null,
                salesType: null,
                reason: null,
                reasonRemark: null,
                reviewDate: forMatIndianDate(),
                dueDate: forMatIndianDate(),
                expClosureDate: forMatIndianDate(),
                action: null,
                qtnStage: 1,
                roundingType:'0',
                customerDetailsData: {
                    customerCode: null,
                    customerName: null,
                    reference: null,
                    address: null,
                    city: null,
                    cityId: null,
                    state: null,
                    stateId: null,
                    country: null,
                    countryId: null,
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
                itemDetailsData: [],
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
                    createdBy: CurrentUserData.value.first_name + ' ' + CurrentUserData.value.last_name,
                    createdDateTime: moment(new Date()).format('DD/MM/YYYY HH:mm'),
                    lastModifiedBy: null,
                    modifiedDateTime: null,
                    prepareBy: CurrentUserData.value.first_name + ' ' + CurrentUserData.value.last_name,
                    prepareDateTime: moment(new Date()).format('DD/MM/YYYY HH:mm'),
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

            const billingTermCalculateData = ref({
                netAmount: 0,
            })

            return {
                statusAllOptions,
                getStatus,
                required,
                CurrentUserData,
                SalesOptions,
                SalesTypeOptions,
                tableData,
                qtnOptions,
                statusOptions,
                actionOptions,
                qtnStageOptions,
                currencyOptions,
                branchOptions,
                uomOptions,
                reasonOptions,
                billingOptions,
                termAndConditionOptions,
                headerOptions,
                footerOptions,
                authorisedByOptions,
                itemOptions,
                modalTableFields,
                modalTableData,
                partyFormData,
                selectedItemData: [],
                billingTermCalculateData,
                dateFormat,
                formatDates,
                getDueFormateDate,
                getReviewFormateDate,
                getEnquiryFormateDate,
                getExpFormateDate,
                getFormateDate,
                getQuotationFormateDate,
                getConversionRate
            }
        },
        methods: {
            validationForm() {
                this.$swal({
                    title: 'Are you sure?',
                    text: "Save Entire Sales Quotation",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, do it!',
                    cancelButtonText: 'No, keep it!',
                    customClass: {
                        confirmButton: 'btn btn-primary',
                        cancelButton: 'btn btn-outline-danger ml-1',
                    },
                    buttonsStyling: false,
                }).then(result => {
                    if (result.value) {
                        this.$refs.simpleRules.validate().then(success => {
                            if (success) {
                                store.dispatch('sales-enquiry-module/addSalesQuotation', this.partyFormData).then(response => {
                                    if (response.data?.status === 200) {
                                        this.$router.push({name: 'edit-sales-quotation', params: {id: response.data.data._id}})
                                        this.$toast({
                                            component: ToastificationContent,
                                            position: 'top-right',
                                            props: {
                                                title: 'Sales Quotation Created',
                                                icon: 'CheckSquareIcon',
                                                variant: 'success',
                                                text: `You have successfully Created New Sales Quotation.`,
                                            },
                                        })
                                    }
                                })
                            }
                        })
                    }
                })

            },
            async getPartyWithItemDetails(id) {
                await this.$http.get(`/api/sales-enquiry-with-item-details/${id}`).then(res => {
                    this.partyFormData.customerDetailsData.customerCode = res.data.data.customerCode ?? null
                    this.partyFormData.customerDetailsData.customerName = res.data.data.customerName ?? null
                    this.partyFormData.customerDetailsData.project = res.data.data.customerProject ?? null
                    this.partyFormData.customerDetailsData.address = res.data.data.customerAddress ?? null
                    this.partyFormData.customerDetailsData.city = res.data.data.city.city ?? null
                    this.partyFormData.customerDetailsData.cityId = res.data.data.city._id ?? null
                    this.partyFormData.customerDetailsData.state = res.data.data.state.state ?? null
                    this.partyFormData.customerDetailsData.stateId = res.data.data.state._id ?? null
                    this.partyFormData.customerDetailsData.country = res.data.data.country.country ?? null
                    this.partyFormData.customerDetailsData.countryId = res.data.data.country._id ?? null
                    this.partyFormData.customerDetailsData.reference = res.data.data.reference ?? null
                    this.partyFormData.customerDetailsData.ourReference = res.data.data.ourReference ?? null
                    this.partyFormData.customerDetailsData.referenceDate = res.data.data.referenceDate ?? null
                    this.partyFormData.customerDetailsData.phoneNo = res.data.data.customerMobileNo ?? null
                    this.partyFormData.customerDetailsData.faxNo = res.data.data.customerFaxNo ?? null
                    this.partyFormData.customerDetailsData.email = res.data.data.customerEmailId ?? null
                    this.partyFormData.customerDetailsData.personName = res.data.data?.contactPersonName ?? null
                    this.partyFormData.customerDetailsData.mobileNo = res.data.data?.contactPersonMobileNo ?? null
                    this.partyFormData.customerDetailsData.emailId = res.data.data?.contactPersonEmailId ?? null
                    this.partyFormData.customerDetailsData.pincode = res.data.data.customerPinCode ?? null
                    this.partyFormData.customerCode = res.data.data.customerCode ?? null
                    this.partyFormData.customerName = res.data.data.customerName ?? null
                    this.partyFormData.branch = res.data.data.branch ?? null
                    this.partyFormData.reviewDate = res.data.data.reviewDate ?? null
                    this.partyFormData.dueDate = res.data.data.dueDate ?? null
                    this.partyFormData.sales = res.data.data.salesFrom ?? null
                    this.partyFormData.salesType = res.data.data.salesType ?? null
                    this.partyFormData.enquiryNo = res.data.data.enquiryNo ?? null
                    this.partyFormData.partyId = res.data.data.partyId ?? null
                    this.partyFormData.enquiryDate = res.data.data.enquiryDate ?? null
                    this.partyFormData.expClosureDate = res.data.data.dueDate ?? null
                    this.partyFormData.currency = res.data.data?.party_details?.partyCurrencyType ?? null
                    this.partyFormData.convRate = res.data.data?.party_details?.curreny_details?.currencyRate ?? null
                    this.partyFormData.loginData.followUpBy = res.data.data?.enquiryFollowUpBy ?? null
                    this.partyFormData.loginData.instructedBy = res.data.data?.enquiryAssignTo ?? null
                    this.partyFormData.loginData.followUpByName = res.data.data?.followByName ?? null
                    this.partyFormData.loginData.instructedByName = res.data.data?.enquiryAssignName ?? null
                    this.$http.get(`/api/party/get-party-billing-term/${res.data.data.partyId}`).then(response => {
                        this.partyFormData.billingTermsData = response.data.data
                    })
                })
            },
            async getEnquiryItems(data) {
                await this.getPartyWithItemDetails(data._id)
                await this.$http.get(`/api/get-sales-item-details/${data._id}`).then(res => {
                    this.modalTableData.itemListData = res.data?.data
                })
            },
            async getItemDetails() {
                let itemsIds = this.selectedItemData
                await this.$http.post('/api/get-sales-item-list', {ids: itemsIds}).then(res => {
                    this.partyFormData.itemDetailsData = res.data?.data ?? []
                })
                this.resetModalData()
            },
            resetModalData() {
                this.modalTableData.itemListData = null
                this.selectedItemData = []
            },
            updateBillingTerm(e) {
                let data = this.partyFormData.itemDetailsData
                let netAmount = 0.00
                let roundingType = parseInt(this.partyFormData.roundingType)
                data.forEach((item) => {
                    netAmount += item.netAmount
                })
                let dynamicCalculation = [], newAmount = 0.00
                if (this.partyFormData.billingTermsData.length > 0) {
                    this.partyFormData.billingTermsData.forEach((item) => {
                        let myBillingTerm = {
                            calCode: null,
                            calDefination: null,
                            type: null,
                            byValue: 0,
                            percentage: 0,
                            total_amount: 0,
                        }

                        if (roundingType === 0){
                            if (item.calCodeLabel === "BAS") {
                                dynamicCalculation[item.calCodeLabel] = netAmount
                                myBillingTerm.calCode = item.calCodeLabel
                                myBillingTerm.calDefination = item.calDefination
                                myBillingTerm.type = item.type
                                myBillingTerm.byValue = item.byValue
                                myBillingTerm.percentage = item.percentage
                                myBillingTerm.total_amount = netAmount
                                item.calculateAmount = parseFloat(netAmount).toFixed(2)
                            } else {
                                dynamicCalculation[item.calCodeLabel] = newAmount
                                myBillingTerm.calCode = item.calCodeLabel
                                myBillingTerm.calDefination = item.calDefination
                                myBillingTerm.type = item.type
                                myBillingTerm.byValue = item.byValue
                                myBillingTerm.percentage = item.percentage
                                myBillingTerm.total_amount = netAmount

                                let allCodeData = item.calDefination.split('+'), dispayTotal = 0.00
                                if (allCodeData.length > 1) {
                                    let calTotal = 0.00
                                    for (let i = 0; i < allCodeData.length; i++) {
                                        calTotal += parseFloat(dynamicCalculation[allCodeData[i]])
                                    }
                                    dynamicCalculation[item.calCodeLabel] = calTotal
                                    dispayTotal = parseFloat(calTotal).toFixed(2)
                                    item.calculateAmount = parseFloat(dispayTotal).toFixed(2)
                                } else {
                                    if (parseFloat(item.percentage) > 0) {
                                        //By Percentage
                                        let calculatedPercentage = 0
                                        calculatedPercentage = (parseFloat(item.percentage / 100) * parseFloat(dynamicCalculation[allCodeData[0]]))
                                        dynamicCalculation[item.calCodeLabel] = calculatedPercentage
                                        dispayTotal = parseFloat(calculatedPercentage).toFixed(2)
                                    }

                                    if (parseFloat(item.byValue) > 0) {
                                        //By Value
                                        dynamicCalculation[item.calCodeLabel] = parseFloat(item.byValue)
                                        dispayTotal = parseFloat(item.byValue).toFixed(2)
                                    }
                                    item.calculateAmount = dispayTotal
                                }
                            }
                        }

                        if (roundingType === 1){
                            if (item.calCodeLabel === "BAS") {
                                dynamicCalculation[item.calCodeLabel] = netAmount
                                myBillingTerm.calCode = item.calCodeLabel
                                myBillingTerm.calDefination = item.calDefination
                                myBillingTerm.type = item.type
                                myBillingTerm.byValue = item.byValue
                                myBillingTerm.percentage = item.percentage
                                myBillingTerm.total_amount = netAmount
                                item.calculateAmount = parseFloat(netAmount).toFixed(2)
                            } else {
                                dynamicCalculation[item.calCodeLabel] = newAmount
                                myBillingTerm.calCode = item.calCodeLabel
                                myBillingTerm.calDefination = item.calDefination
                                myBillingTerm.type = item.type
                                myBillingTerm.byValue = item.byValue
                                myBillingTerm.percentage = item.percentage
                                myBillingTerm.total_amount = netAmount

                                let allCodeData = item.calDefination.split('+'), dispayTotal = 0.00
                                if (allCodeData.length > 1) {
                                    let calTotal = 0.00
                                    for (let i = 0; i < allCodeData.length; i++) {
                                        calTotal += parseFloat(dynamicCalculation[allCodeData[i]])
                                    }
                                    if (item.calCodeLabel === 'GRD') {
                                        dynamicCalculation[item.calCodeLabel] = changeToRound(calTotal)
                                        dispayTotal = parseFloat(changeToRound(calTotal))
                                            .toFixed(2)
                                        item.calculateAmount = parseFloat(changeToRound(dispayTotal))
                                            .toFixed(2)
                                    } else {
                                        dynamicCalculation[item.calCodeLabel] = calTotal
                                        dispayTotal = parseFloat(calTotal)
                                            .toFixed(2)
                                        item.calculateAmount = parseFloat(dispayTotal)
                                            .toFixed(2)
                                    }

                                } else {
                                    if (parseFloat(item.percentage) > 0) {
                                        //By Percentage
                                        let calculatedPercentage = 0
                                        calculatedPercentage = (parseFloat(item.percentage / 100) * parseFloat(dynamicCalculation[allCodeData[0]]))
                                        dynamicCalculation[item.calCodeLabel] = calculatedPercentage
                                        dispayTotal = parseFloat(calculatedPercentage).toFixed(2)
                                    }

                                    if (parseFloat(item.byValue) > 0) {
                                        //By Value
                                        dynamicCalculation[item.calCodeLabel] = parseFloat(item.byValue)
                                        dispayTotal = parseFloat(item.byValue).toFixed(2)
                                    }
                                    item.calculateAmount = dispayTotal
                                }
                            }
                        }

                        if (roundingType === 2){
                            if (item.calCodeLabel === "BAS") {
                                dynamicCalculation[item.calCodeLabel] = changeToRound(netAmount)
                                myBillingTerm.calCode = item.calCodeLabel
                                myBillingTerm.calDefination = item.calDefination
                                myBillingTerm.type = item.type
                                myBillingTerm.byValue = item.byValue
                                myBillingTerm.percentage = item.percentage
                                myBillingTerm.total_amount = changeToRound(netAmount)
                                item.calculateAmount = parseFloat(changeToRound(netAmount)).toFixed(2)
                            } else {
                                dynamicCalculation[item.calCodeLabel] = changeToRound(newAmount)
                                myBillingTerm.calCode = item.calCodeLabel
                                myBillingTerm.calDefination = item.calDefination
                                myBillingTerm.type = item.type
                                myBillingTerm.byValue = item.byValue
                                myBillingTerm.percentage = item.percentage
                                myBillingTerm.total_amount = changeToRound(newAmount)

                                let allCodeData = item.calDefination.split('+'), dispayTotal = 0.00
                                if (allCodeData.length > 1) {
                                    let calTotal = 0.00
                                    for (let i = 0; i < allCodeData.length; i++) {
                                        calTotal += parseFloat(dynamicCalculation[allCodeData[i]])
                                    }
                                    dynamicCalculation[item.calCodeLabel] = changeToRound(calTotal)
                                    dispayTotal = parseFloat(changeToRound(calTotal)).toFixed(2)
                                    item.calculateAmount = parseFloat(dispayTotal).toFixed(2)
                                } else {
                                    if (parseFloat(item.percentage) > 0) {
                                        //By Percentage
                                        let calculatedPercentage = 0
                                        calculatedPercentage = (parseFloat(item.percentage / 100) * parseFloat(dynamicCalculation[allCodeData[0]]))
                                        dynamicCalculation[item.calCodeLabel] = changeToRound(calculatedPercentage)
                                        dispayTotal = parseFloat(changeToRound(calculatedPercentage)).toFixed(2)
                                    }

                                    if (parseFloat(item.byValue) > 0) {
                                        //By Value
                                        dynamicCalculation[item.calCodeLabel] = parseFloat(changeToRound(item.byValue))
                                        dispayTotal = parseFloat(changeToRound(item.byValue)).toFixed(2)
                                    }
                                    item.calculateAmount = dispayTotal
                                }
                            }
                        }
                    })
                }
            },
        },
    }
</script>
<style lang="scss">
    @import '~@core/scss/vue/libs/vue-sweetalert.scss';
</style>
