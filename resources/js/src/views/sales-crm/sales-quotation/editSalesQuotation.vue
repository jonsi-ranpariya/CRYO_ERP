<template>
    <div>
        <b-overlay
            :show="showOverlayLoading"
            rounded="sm"
        >
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
                                                type="number"
                                                v-model="partyFormData.branchQtyNo"
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
                                                />
                                            </b-input-group>
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
                            </b-col>
                            <b-col md="6">
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
                            <b-col md="12">
                                <hr>
                                <b-button
                                    type="button"
                                    variant="primary"
                                    class="mr-1"
                                    @click="generateRev"
                                >
                                    Generate Rev
                                </b-button>
                                <b-button
                                    type="button"
                                    variant="primary"
                                    class="mr-1"
                                    v-b-modal.edit-details
                                >
                                    Edit Details
                                </b-button>
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
                                            :itemData.sync="partyFormData.item_details"
                                            :uomOptions="uomOptions"
                                            :itemOptions="itemOptions"
                                            @updateBillingTermData="updateBillingTerm($event)"
                                            :roundingType="partyFormData.roundingType"
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
                                            :tableData="tableData"
                                            :billingData.sync="partyFormData.billingTermsData"
                                            :billingOptions="billingOptions"
                                            :itemData.sync="partyFormData.item_details"
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
                                            :partyId="partyFormData.partyId"
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
                                        <follow-up-history
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
                                        <login
                                            :loginData.sync="partyFormData.loginData"
                                            :loginDetails="loginDetails"
                                            :usersList="authorisedByOptions"
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
        </b-overlay>
        <!--Start Edit Details Modal-->
        <b-modal
            id="edit-details"
            title="Quotation Other Details"
            ok-title="submit"
            cancel-variant="danger"
            size="lg"
            no-close-on-backdrop
            @ok="validationForm"
        >
            <b-row>
                <b-col md="12">
                    <b-row>
                        <b-col md="3">
                            <b-form-checkbox
                                id="review-date"
                                class="mt-1"
                                @change="updateModalReviewDate($event)"
                            >
                                Review Date
                            </b-form-checkbox>
                        </b-col>
                        <b-col md="9">
                            <b-form-group
                                label-for="modalReviewDate"
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
                                            :disabled="isModalReviewDate"
                                        />
                                    </b-input-group-prepend>
                                    <cleave
                                        id="reviewDateModal"
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
                        <b-col md="3">
                            <b-form-checkbox
                                id="due-date"
                                class="mt-1"
                                @change="updateModalDueDate($event)"
                            >
                                Due Date
                            </b-form-checkbox>
                        </b-col>
                        <b-col md="9">
                            <b-form-group
                                label-for="modalDueDate"
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
                                            :disabled="isModalDueDate"
                                        />
                                    </b-input-group-prepend>
                                    <cleave
                                        id="dueDateModal"
                                        v-model="partyFormData.dueDate"
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
                        label="Exp Closure Date"
                        label-for="modalExpClosureDate"
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
                                id="modalExpClosureDate"
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
                        label="Reason"
                        label-for="modalReason"
                    >
                        <v-select
                            placeholder="Select Reason Type"
                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                            :options="reasonOptions"
                            :reduce="val => val.value"
                            :clearable="false"
                            input-id="modalReason"
                            v-model="partyFormData.reason"
                        />
                    </b-form-group>
                    <b-form-group
                        label="Reason Remark"
                        label-for="modalReasonRemark"
                    >
                        <b-form-textarea
                            rows="2"
                            id="modalReasonRemark"
                            v-model="partyFormData.reasonRemark"
                        />
                    </b-form-group>
                </b-col>
            </b-row>
        </b-modal>
        <!--End Edit Details Modal-->
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
        BInputGroupPrepend,
        BInputGroupAppend,
        BInputGroup,
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
    import router from '@/router'
    import BillingTerm from "./tabs/billingTerm"
    import TermAndCondition from "./tabs/termAndCondition"
    import HeaderOrFooter from "./tabs/headerOrFooter"
    import Note from "./tabs/note"
    import QtnSpec from "./tabs/qtnSpec"
    import Login from "./tabs/login"
    import reportDetailTab from "./tabs/reportDetailTab"
    import moment from 'moment'
    import SalesAgent from "./tabs/salesAgent";
    import FollowUpHistory from "./tabs/followUpHistory";
    import axios from "@axios"
    import {getUserData} from "../../../auth/utils";
    import {forMatIndianDate} from "../../../@core/utils/utils";
    import Cleave from 'vue-cleave-component'
    import Swal from "sweetalert2";
    export default {
        components: {
            FollowUpHistory,
            SalesAgent,
            Login,
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
            BFormCheckbox,
            BTab,
            BTabs,
            BOverlay,
            vSelect,
            BInputGroupPrepend,
            BInputGroupAppend,
            BInputGroup,
            Cleave,
            BFormRadio,
            reportDetailTab
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
            const showOverlayLoading = ref(true)
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
                        key: 'netAmount',
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

            const CurrentUserData = ref(getUserData())

            const partyFormData = ref({
                id: null,
                quotationNo: null,
                enquiryNo: null,
                enquiryDate: forMatIndianDate(),
                quotationDate: forMatIndianDate(),
                partyId: null,
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
                roundingType: '0',
                revDate: forMatIndianDate(),
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
                    referenceDate: forMatIndianDate(),
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
                    createdBy: CurrentUserData.value.first_name + ' ' + CurrentUserData.value.last_name,
                    createdDateTime: moment(new Date()).format('DD/MM/YYYY HH:mm'),
                    lastModifiedBy: null,//CurrentUserData.value.first_name + ' ' + CurrentUserData.value.last_name
                    modifiedDateTime: null,//moment(new Date()).format('DD/MM/YYYY HH:mm')
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
                item_details: [],
            })

            const loginDetails = ref({})

            axios.get(`/api/sales-quotation/${router.currentRoute.params.id}`).then(res => {
                showOverlayLoading.value = true
                partyFormData.value = res.data?.data
                partyFormData.value.id = res.data.data?._id
                partyFormData.value.billingTermsData = res.data.data?.billing_terms ?? []
                partyFormData.value.termAndConditionData = res.data.data?.termAndConditionData
                partyFormData.value.salesPersonData = res.data.data?.salesPersonData
                partyFormData.value.headerOrFooterData = res.data.data?.headerOrFooterData
                partyFormData.value.noteData = res.data.data?.noteData
                partyFormData.value.qtnSpecData = res.data.data?.qtnSpecData
                partyFormData.value.loginData = res.data.data.loginData
                partyFormData.value.loginData.followUpByName = res.data.data?.loginData?.followUpByName ?? null
                partyFormData.value.loginData.instructedByName = res.data.data?.loginData?.instructedByName ?? null
                delete partyFormData.value._id
                showOverlayLoading.value = false
            })

            const SalesOptions = ref([
                {label: 'Domestic', value: 1},
                {label: 'Export', value: 2},
            ])
            const SalesTypeOptions = ref([])
            axios.get('/api/get-sales-order-type-options')
                .then(res => {
                    SalesTypeOptions.value = res.data.data
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
                {label: 'Active', value: 1},
                {label: 'Achieved', value: 2},
                {label: 'Regret', value: 3},
                {label: 'Closed', value: 4},
                {label: 'Followup', value: 5},
            ])

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

            const uomOptions = ref([])
            axios.get('/api/get-uom-master-options').then(res => {
                uomOptions.value = res.data?.data
            })

            const itemOptions = ref([])
            axios.get('/api/get-item-master-options').then(res => {
                itemOptions.value = res.data?.data
            })

            const reasonOptions = ref([])
            axios.get('/api/get-quotation-reason-master-options').then(res => {
                reasonOptions.value = res.data?.data
            })

            const billingOptions = ref([])
            axios.get('/api/get-billing-template-master-options').then(res => {
                billingOptions.value = res.data?.data
            })

            const termAndConditionOptions = ref([])

            axios.get('/api/get-term-condition-detail-with-group-options').then(res => {
                termAndConditionOptions.value = res.data.data
            })

            const headerOptions = ref([])
            axios.get('/api/new/document-sales-enquiry-header-options').then(res => {
                headerOptions.value = res.data?.data
            })

            const footerOptions = ref([])
            axios.get('/api/new/document-sales-enquiry-footer-options').then(res => {
                footerOptions.value = res.data.data
            })

            const authorisedByOptions = ref([])
            axios.get('/api/get-users-options').then(res => {
                authorisedByOptions.value = res.data.data
            })

            const isModalReviewDate = ref(true)
            const isModalDueDate = ref(true)

            const updateModalReviewDate = (e) => {
                isModalReviewDate.value = !e
            }

            const updateModalDueDate = (e) => {
                isModalDueDate.value = !e
            }

            const generateRev = () => {
                alert('here')
            }

            return {
                required,
                CurrentUserData,
                showOverlayLoading,
                tableData,
                SalesOptions,
                SalesTypeOptions,
                qtnOptions,
                statusOptions,
                actionOptions,
                qtnStageOptions,
                enquiryOptions,
                currencyOptions,
                branchOptions,
                uomOptions,
                itemOptions,
                reasonOptions,
                billingOptions,
                headerOptions,
                footerOptions,
                authorisedByOptions,
                isModalReviewDate,
                isModalDueDate,
                partyFormData,
                loginDetails,
                updateModalReviewDate,
                updateModalDueDate,
                generateRev,
                dateFormat,
                formatDates,
                getDueFormateDate,
                getReviewFormateDate,
                getEnquiryFormateDate,
                getExpFormateDate,
                getFormateDate,
                getQuotationFormateDate,
                getRevFormateDate,
                termAndConditionOptions
            }
        },
        methods: {
            async validationForm() {
                if (this.partyFormData.loginData.stage === 2) {
                    await Swal.fire({
                        icon: 'warning',
                        title: 'Warning',
                        text: 'This Quotation is Already Approved, Please Redo to Edit',
                    })
                } else {
                    await this.$refs.simpleRules.validate().then(success => {
                        if (success) {
                            this.partyFormData.loginData.lastModifiedBy = this.CurrentUserData.first_name + ' ' + this.CurrentUserData.last_name
                            this.partyFormData.loginData.modifiedDateTime = moment(new Date()).format('DD/MM/YYYY HH:mm')

                            store.dispatch('sales-enquiry-module/updateSalesQuotation', this.partyFormData).then(response => {
                                if (response.status === 200) {
                                    this.$toast({
                                        component: ToastificationContent,
                                        position: 'top-right',
                                        props: {
                                            title: 'Sales Quotation Updated',
                                            icon: 'CheckSquareIcon',
                                            variant: 'success',
                                            text: `You have successfully Updated New Sales Quotation.`,
                                        },
                                    })
                                }
                            })
                        }
                    })
                }
            },
            async updateBillingTerm(e) {
                let data = this.partyFormData.item_details
                let netAmount = 0.00;
                await data.forEach((item) => {
                    netAmount += parseFloat(item.netAmount)
                })

                let dynamicCalculation = [], newAmount = 0.00
                if (this.partyFormData.billingTermsData.length > 0) {
                    await this.partyFormData.billingTermsData.forEach((item, key) => {
                        let myBillingTerm = {
                            calCode: null,
                            calDefination: null,
                            type: null,
                            byValue: 0,
                            percentage: 0,
                            total_amount: 0,
                            srNo: null,
                        }

                        if (item.calCodeLabel === "BAS") {
                            dynamicCalculation[item.calCodeLabel] = netAmount
                            myBillingTerm.calCode = item.calCodeLabel
                            myBillingTerm.calDefination = item.calDefination
                            myBillingTerm.type = item.type
                            myBillingTerm.byValue = item.byValue
                            myBillingTerm.percentage = item.percentage
                            myBillingTerm.total_amount = netAmount
                            item.calculateAmount = parseFloat(netAmount).toFixed(2)
                            myBillingTerm.srNo = key
                        } else {
                            dynamicCalculation[item.calCodeLabel] = newAmount
                            myBillingTerm.calCode = item.calCodeLabel
                            myBillingTerm.calDefination = item.calDefination
                            myBillingTerm.type = item.type
                            myBillingTerm.byValue = item.byValue
                            myBillingTerm.percentage = item.percentage
                            myBillingTerm.total_amount = netAmount
                            myBillingTerm.srNo = key

                            let allCodeData = item.calDefination.split('+'), dispayTotal = 0.00
                            if (allCodeData.length > 1) {
                                let calTotal = 0.00
                                for (let i = 0; i < allCodeData.length; i++) {
                                    calTotal += dynamicCalculation[allCodeData[i]]
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

                                if (parseFloat(item.byValue) > 1) {
                                    //By Value
                                    dynamicCalculation[item.calCodeLabel] = parseFloat(item.byValue)
                                    dispayTotal = parseFloat(item.byValue).toFixed(2)
                                }
                                item.calculateAmount = dispayTotal
                            }
                        }
                    })
                }
            },
            async getStatesData(countryId) {
                this.partyFormData.customerState = null
                await this.$http.get('/api/get-state-by-country', {
                    params: {
                        country_id: countryId
                    }
                }).then(res => {
                    this.stateOptions = res.data.data
                })
            },
            async getCityData(stateId) {
                this.partyFormData.customerCity = null
                await this.$http.get('/api/get-city-by-state', {
                    params: {
                        state_id: stateId
                    }
                }).then(res => {
                    this.cityOptions = res.data.data
                })
            },
        },
    }
</script>
