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
                                    placeholder="Select PO Status"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="stageOption"
                                    :reduce="val => val.value"
                                    :clearable="false"
                                    v-model="adminFormData.poStage"
                                    input-id="adminStatus"
                                />
                            </b-form-group>
                        </b-col>
                        <b-col md="12">
                            <hr>
                            <b-button
                                type="button"
                                variant="primary"
                                class="float-right"
                                @click="changePoStatusStage"
                            >
                                Change Stage
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
                <validation-observer #default="{ handleSubmit }">
                    <b-form @submit.prevent="handleSubmit(saveFormData)">
                        <b-row>
                            <b-col md="12">
                                <h5>Vendor Details</h5>
                                <hr>
                            </b-col>
                            <b-col md="6">
                                <validation-provider
                                    #default="validationContext"
                                    name="Vendor"
                                    rules="required"
                                >
                                    <b-form-group
                                        label="Vendor"
                                        label-for="poVendorCode"
                                    >
                                        <v-select
                                            placeholder="Select Vendor"
                                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                            :options="vendorOptions"
                                            :reduce="val => val.value"
                                            :clearable="false"
                                            input-id="poVendorCode"
                                            v-model="formData.poVendorCode"
                                            :state="getValidationState(validationContext)"
                                            @input="getQuotationVendorDetails($event)"
                                        />
                                    </b-form-group>
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </validation-provider>
                            </b-col>
                            <b-col md="6">
                                <validation-provider
                                    #default="validationContext"
                                    name="Vendor Name"
                                    rules="required"
                                >
                                    <b-form-group
                                        label="Vendor Name"
                                        label-for="poVendorName"
                                    >
                                        <b-form-input
                                            id="poVendorName"
                                            v-model="formData.poVendorName"
                                            :state="getValidationState(validationContext)"
                                        />
                                    </b-form-group>
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </validation-provider>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="3">
                                <validation-provider
                                    #default="validationContext"
                                    name="P.O.No."
                                    rules=""
                                >
                                    <b-form-group
                                        label="P.O.No."
                                        label-for="poNumber"
                                    >
                                        <b-form-input
                                            id="poNumber"
                                            v-model="formData.poNumber"
                                            :state="getValidationState(validationContext)"
                                            readonly
                                        />
                                    </b-form-group>
                                </validation-provider>
                            </b-col>
                            <b-col md="3">
                                <validation-provider
                                    #default="validationContext"
                                    name="P.O. Date"
                                    rules=""
                                >
                                    <b-form-group
                                        label="P.O. Date"
                                        label-for="poDate"
                                    >
                                        <b-input-group>
                                            <cleave
                                                id="poDate"
                                                v-model="formData.poDate"
                                                class="form-control"
                                                :raw="false"
                                                :options="dateFormat"
                                                placeholder="DD/MM/YYYY"
                                                show-decade-nav
                                            />
                                            <b-input-group-append>
                                                <b-form-datepicker
                                                    v-model="formatDates.poDate"
                                                    button-only
                                                    @input="getPoFormateDate($event)"
                                                    show-decade-nav
                                                    size="sm"
                                                    nav-button-variant="primary"
                                                />
                                            </b-input-group-append>
                                        </b-input-group>
                                    </b-form-group>
                                </validation-provider>
                            </b-col>
                            <b-col md="3">
                                <b-form-group
                                    label="Ref."
                                    label-for="poRefId"
                                >
                                    <v-select
                                        v-model="formData.poRefId"
                                        placeholder="Select No"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="ReferenceNoOptions"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        input-id="poRefId"
                                        @input="getPqReferenceNo($event)"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group
                                    label="Qtn. No."
                                    label-for="poQtnNo"
                                >
                                    <v-select
                                        v-model="formData.poQtnNo"
                                        placeholder="Select Currency"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="quotationNoOptions"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        input-id="poQtnNo"
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="3">
                                <b-form-group
                                    label="Amd. No."
                                    label-for="poAmdNo"
                                >
                                    <b-form-input
                                        id="poAmdNo"
                                        v-model="formData.poAmdNo"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group
                                    label="Amd. Date"
                                    label-for="poAmdDate"
                                >
                                    <b-input-group>
                                        <cleave
                                            id="poAmdDate"
                                            v-model="formData.poAmdDate"
                                            class="form-control"
                                            :raw="false"
                                            :options="dateFormat"
                                            placeholder="DD/MM/YYYY"
                                            show-decade-nav
                                        />
                                        <b-input-group-append>
                                            <b-form-datepicker
                                                v-model="formatDates.poAmdDate"
                                                button-only
                                                @input="getPoAmdChallanFormateDate($event)"
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
                                    label="Reference No"
                                    label-for="refNo"
                                >
                                    <b-form-input
                                        id="refNo"
                                        v-model="formData.refNo"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group
                                    label="Quotation No"
                                    label-for="QuotationNo"
                                >
                                    <b-form-input
                                        id="QuotationNo"
                                        v-model="formData.QuotationNo"
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="3">
                                <b-form-group
                                    label="Status"
                                    label-for="poStatus"
                                >
                                    <v-select
                                        v-model="formData.poStatus"
                                        placeholder="Select Status"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="statusOptions"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        input-id="poStatus"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group
                                    label="Currency"
                                    label-for="poCurrency"
                                >
                                    <v-select
                                        v-model="formData.poCurrency"
                                        placeholder="Select Currency"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="currencyOptions"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        input-id="poCurrency"
                                        @input="getCurrency($event)"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group
                                    label="Quotation Date"
                                    label-for="poQtnDate"
                                >
                                    <b-input-group>
                                        <b-input-group-prepend>
                                            <b-form-datepicker
                                                v-model="formatDates.poQtnDate"
                                                button-only
                                                @input="getPoQtnFormateDate($event)"
                                                show-decade-nav
                                                size="sm"
                                                nav-button-variant="primary"
                                            />
                                        </b-input-group-prepend>
                                        <cleave
                                            id="poQtnDate"
                                            v-model="formData.poQtnDate"
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
                                <b-form-group
                                    label="Conversion Rate"
                                    label-for="poConversionRate"
                                >
                                    <b-form-input
                                        id="poConversionRate"
                                        v-model="formData.poConversionRate"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="6"><br>
                                <b-row>
                                    <b-col md="7">
                                        <b-button
                                            variant="primary"
                                            @click="openAmdModal"
                                        >
                                            Show Amd Details
                                        </b-button>
                                    </b-col>
                                    <b-col md="5">

                                    </b-col>
                                </b-row>
                                <br>
                                <b-form-group
                                    label="Kind Attn."
                                    label-for="poKindAttn"
                                >
                                    <v-select
                                        placeholder="Select KindAttn"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :reduce="val => val.value"
                                        :options="kindOption"
                                        :clearable="false"
                                        input-id="poKindAttn"
                                        v-model="formData.poKindAttn"
                                    />
                                </b-form-group>
                                <b-form-group
                                    label="Mobile No."
                                    label-for="poPhoneCountry"
                                >
                                    <b-input-group>
                                        <b-form-input
                                            id="party-work-phone"
                                            v-model="formData.poMobileNo"
                                        />
                                    </b-input-group>
                                </b-form-group>
                                <b-form-group
                                    label="E-mail ID"
                                    label-for="poMobileNo"
                                >
                                    <b-form-input
                                        v-model="formData.poEmailId"
                                        id="purchaseOrderEmailId"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-row>
                                    <b-col md="6">
                                        <b-form-group
                                            label="Purchase Type"
                                            label-for="purchaseType"
                                        >
                                            <v-select
                                                v-model="formData.purchaseType"
                                                placeholder="Select Type"
                                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                                :options="purchaseTypeOptions"
                                                :reduce="val => val.value"
                                                :clearable="false"
                                                input-id="poCurrency"
                                            />
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="6">
                                        <b-form-group
                                            label="Status"
                                            label-for="poStage"
                                        >
                                            <v-select
                                                placeholder="Select Stage"
                                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                                :reduce="val => val.value"
                                                :options="stageOption"
                                                :clearable="false"
                                                input-id="poStage"
                                                v-model="formData.poStage"
                                            />
                                        </b-form-group>
                                    </b-col>
                                </b-row>
                                <b-form-group
                                    label="Review Date"
                                    label-for="poReviewDate"
                                >
                                    <b-input-group>
                                        <b-input-group-prepend is-text>
                                            <b-form-checkbox
                                                plain
                                                name="checkbox-input"
                                                type="checkbox"
                                                v-model="formData.Selected"
                                            />
                                        </b-input-group-prepend>
                                        <b-input-group-prepend>
                                            <b-form-datepicker
                                                v-model="formatDates.poReviewDate"
                                                button-only
                                                @input="getPoReviewFormateDate($event)"
                                                show-decade-nav
                                                size="sm"
                                                nav-button-variant="primary"
                                                v-bind:disabled="!formData.Selected"
                                            />
                                        </b-input-group-prepend>
                                        <cleave
                                            id="poReviewDate"
                                            v-model="formData.poReviewDate"
                                            class="form-control"
                                            :raw="false"
                                            :options="dateFormat"
                                            placeholder="DD/MM/YYYY"
                                            show-decade-nav
                                            v-bind:disabled="!formData.Selected"
                                        />
                                    </b-input-group>
                                </b-form-group>
                                <b-form-group
                                    label="Supply Type"
                                    label-for="poSupplyType"
                                >
                                    <v-select
                                        placeholder="Select Supply"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :reduce="val => val.value"
                                        :options="supplyOption"
                                        :clearable="false"
                                        input-id="poSupplyType"
                                        v-model="formData.poSupplyType"
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
                                            v-model="formData.poRound"
                                            value="0"
                                        >
                                            None
                                        </b-form-radio>
                                        <b-form-radio
                                            name="selectRound"
                                            v-model="formData.poRound"
                                            value="1"
                                        >
                                            Rounding
                                        </b-form-radio>
                                        <b-form-radio
                                            name="selectRound"
                                            v-model="formData.poRound"
                                            value="2"
                                        >
                                            Rounding All
                                        </b-form-radio>
                                    </div>
                                </b-form-group>
                            </b-col>
                            <!-- Button-->
                            <b-col md="12">
                                <hr>
                                <b-button
                                    class="float-right"
                                    variant="primary"
                                    type="submit"
                                >
                                    Save
                                </b-button>
                            </b-col>
                        </b-row>
                    </b-form>
                </validation-observer>
                <!-- Tabs -->
                <b-row>
                    <b-col cols="12">
                        <hr>
                    </b-col>
                </b-row>
                <b-tabs
                    pills
                    lazy
                >
                    <b-tab active>
                        <template #title>
                            <feather-icon
                                icon="FileIcon"
                                size="16"
                                class="mr-0 mr-sm-50"
                            />
                            <span class="d-none d-sm-inline">Item Details</span>
                        </template>
                        <hr>
                        <item-details-tab
                            :poRoundingType="formData.poRound"
                            :poRefId="formData.poRefId"
                        />
                    </b-tab>
                    <b-tab>
                        <template #title>
                            <feather-icon
                                icon="LayoutIcon"
                                size="16"
                                class="mr-0 mr-sm-50"
                            />
                            <span class="d-none d-sm-inline">Billing Terms</span>
                        </template>
                        <hr>
                        <billing-terms-tab
                            :po-rounding-type="formData.poRound"
                        />
                    </b-tab>
                    <b-tab>
                        <template #title>
                            <feather-icon
                                icon="TypeIcon"
                                size="16"
                                class="mr-0 mr-sm-50"
                            />
                            <span class="d-none d-sm-inline">Terms & Conditions</span>
                        </template>
                        <hr>
                        <terms-conditions-tab
                            :vendorPartyId="formData.poVendorId"
                        />
                    </b-tab>
                    <b-tab>
                        <template #title>
                            <feather-icon
                                icon="EditIcon"
                                size="16"
                                class="mr-0 mr-sm-50"
                            />
                            <span class="d-none d-sm-inline">Note</span>
                        </template>
                        <hr>
                        <order-note-tab
                            :noteDetails="formData.noteDetails"
                        />
                    </b-tab>
                    <b-tab>
                        <template #title>
                            <feather-icon
                                icon="FileTextIcon"
                                size="16"
                                class="mr-0 mr-sm-50"
                            />
                            <span class="d-none d-sm-inline">Header/Footer</span>
                        </template>
                        <hr>
                        <header-footer-tab
                            :headerFooterDetails="formData.headerFooterDetails"
                        />
                    </b-tab>
                    <b-tab>
                        <template #title>
                            <feather-icon
                                icon="UsersIcon"
                                size="16"
                                class="mr-0 mr-sm-50"
                            />
                            <span class="d-none d-sm-inline">Vendor Details</span>
                        </template>
                        <hr>
                        <vendor-details-tab
                            :vendorDetails="formData.vendorDetails"
                        />
                    </b-tab>
                    <b-tab>
                        <template #title>
                            <feather-icon
                                icon="MapPinIcon"
                                size="16"
                                class="mr-0 mr-sm-50"
                            />
                            <span class="d-none d-sm-inline">Work Address</span>
                        </template>
                        <hr>
                        <work-address-details
                            :workAddressDetails="formData.workAddressDetails"
                        />
                    </b-tab>
                    <b-tab>
                        <template #title>
                            <feather-icon
                                icon="UsersIcon"
                                size="16"
                                class="mr-0 mr-sm-50"
                            />
                            <span class="d-none d-sm-inline">PO History</span>
                        </template>
                        <hr>
                        <po-history/>
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
                        <login-detail-tab
                            :loginData="formData.loginDetails"
                        />
                    </b-tab>
                    <b-tab>
                        <template #title>
                            <feather-icon
                                icon="UsersIcon"
                                size="16"
                                class="mr-0 mr-sm-50"
                            />
                            <span class="d-none d-sm-inline">Report</span>
                        </template>
                        <hr>
                        <report-tab/>
                    </b-tab>
                </b-tabs>
            </b-card-code>
        </b-overlay>

        <!--Model-->
        <b-modal
            cancel-variant="danger"
            id="showAmdDetailsModal"
            no-close-on-backdrop
            ok-title="Save"
            ref="showAmdDetailsModal"
            scrollable
            size="lg"
            title="Show Amd Details"
            @ok="saveDataShowAmd"
        >
            <b-row>
                <b-col md="4">
                    <b-form-group
                        label="PO No."
                        label-for="poNumber"
                    >
                        <b-form-input
                            v-model="formData.poNumber"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="4">
                    <b-form-group
                        label="P.O. Date"
                        label-for="poDate"
                    >
                        <b-input-group>
                            <cleave
                                v-model="formData.poDate"
                                class="form-control"
                                :raw="false"
                                :options="dateFormat"
                                placeholder="DD/MM/YYYY"
                                show-decade-nav
                            />
                            <b-input-group-append>
                                <b-form-datepicker
                                    v-model="formatDates.poDate"
                                    button-only
                                    @input="getPoFormateDate($event)"
                                    show-decade-nav
                                    size="sm"
                                    nav-button-variant="primary"
                                />
                            </b-input-group-append>
                        </b-input-group>
                    </b-form-group>
                </b-col>
                <b-col md="4">
                    <b-form-group
                        label="Vendor Name"
                        label-for="poVendorName"
                    >
                        <b-form-input
                            v-model="formData.poVendorName"
                        />
                    </b-form-group>
                </b-col>
            </b-row>

            <!-- Table -->
            <b-row>
                <b-col md="12">
                    <b-table
                        responsive
                        :fields="modalTables.showAmdFields"
                        :items="modalTables.showAmdData"
                        :bordered="true"
                        :hover="true"
                        show-empty
                        class="table_scroll"
                        :busy="isBusy"
                    >
                        <!-- Loader -->
                        <template #table-busy>
                            <div class="text-center my-2">
                                <b-spinner class="align-middle"></b-spinner>
                                <strong>Loading...</strong>
                            </div>
                        </template>

                        <!-- A virtual column -->
                        <template #cell(index)="data">
                            {{ data.index + 1 }}
                        </template>

                        <!-- Action -->
                        <template #cell(action)="data">
                            <b-dropdown
                                no-caret
                                toggle-class="text-decoration-none"
                                variant="link"
                            >
                                <template v-slot:button-content>
                                    <feather-icon
                                        class="text-body align-middle mr-25"
                                        icon="MoreVerticalIcon"
                                        size="16"
                                    />
                                </template>
                                <b-dropdown-item @click="editShowAmdData(data.item)"
                                >
                                    <feather-icon
                                        class="mr-50"
                                        icon="Edit2Icon"
                                    />
                                    <span>Edit</span>
                                </b-dropdown-item>
                                <b-dropdown-item @click="deleteShowAmdData(data.item._id)"
                                >
                                    <feather-icon
                                        class="mr-50"
                                        icon="TrashIcon"
                                    />
                                    <span>Delete</span>
                                </b-dropdown-item>
                            </b-dropdown>
                        </template>
                    </b-table>
                    <hr/>
                </b-col>
            </b-row>
            <!--add Description-->
            <b-row>
                <b-col>
                    <hr>
                    Ammendment Details
                    <hr>
                </b-col>
            </b-row>
            <b-row>
                <b-col md="6">
                    <b-form-group
                        label="Ammendment"
                        label-for="ammendment"
                    >
                        <b-form-textarea
                            id="ammendment"
                            rows="2"
                            v-model="formDataAmd.ammendmentDescription"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="6">
                </b-col>
            </b-row>
        </b-modal>
    </div>
</template>
<script>
import {
    BForm,
    BRow,
    BCol,
    BFormGroup,
    BFormInput,
    BFormInvalidFeedback,
    BFormDatepicker,
    BFormCheckbox,
    BInputGroupPrepend,
    BInputGroup,
    BButton,
    BTabs,
    BTab,
    BOverlay,
    BInputGroupAppend,
    BTable,
    BFormTextarea,
    BDropdownItem,
    BDropdown,
    BSpinner,
    BFormRadio
} from 'bootstrap-vue'
import BCardCode from '@core/components/b-card-code/BCardCode'
import { ValidationObserver, ValidationProvider } from 'vee-validate'
import { ref } from '@vue/composition-api'
import formValidation from '@core/comp-functions/forms/form-validation'
import { required } from '@validations'
import axios from '@axios'
import vSelect from 'vue-select'
import countryCode from '@/@fake-db/data/other/country-code'
import router from '@/router'
import itemDetailsTab from './tabs/itemDetailsTab'
import billingTermsTab from './tabs/billingTermsTab'
import termsConditionsTab from './tabs/termsConditionsTab'
import orderNoteTab from './tabs/orderNoteTab'
import headerFooterTab from './tabs/headerFooterTab'
import vendorDetailsTab from './tabs/vendorDetailsTab'
import poHistory from './tabs/poHistoryTab'
import reportTab from './tabs/reportTab'
import { getTcTodayDate } from '@core/utils/utils'
import store from '@/store'
import purchaseStoreModule from '../purchaseStoreModule'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
import { useToast } from 'vue-toastification/composition'
import Cleave from 'vue-cleave-component'
import { forMatIndianDate } from '@core/utils/utils'
import Swal from 'sweetalert2'
import { getUserData } from '../../../auth/utils'
import loginDetailTab from './tabs/loginDetailTab'
import { getTcTodayDateTime } from '@core/utils/utils'
import AppCollapse from '@core/components/app-collapse/AppCollapse.vue'
import AppCollapseItem from '@core/components/app-collapse/AppCollapseItem.vue'
import workAddressDetails from './tabs/workAddressDetails'

export default {
    components: {
        loginDetailTab,
        BCardCode,
        ValidationObserver,
        ValidationProvider,
        BForm,
        BRow,
        BCol,
        BFormGroup,
        BFormInput,
        BFormInvalidFeedback,
        vSelect,
        BFormDatepicker,
        BFormCheckbox,
        BInputGroupPrepend,
        BInputGroup,
        BButton,
        BTabs,
        BTab,
        BOverlay,
        itemDetailsTab,
        billingTermsTab,
        termsConditionsTab,
        orderNoteTab,
        headerFooterTab,
        vendorDetailsTab,
        poHistory,
        reportTab,
        Cleave,
        BInputGroupAppend,
        BTable,
        BFormTextarea,
        BDropdownItem,
        BDropdown,
        BSpinner,
        BFormRadio,
        AppCollapse,
        AppCollapseItem,
        workAddressDetails
    },
    computed: {
        countryCode: () => countryCode
    },
    setup({ showAmdDetailsModal }) {
        showAmdDetailsModal = ref()
        const isBusy = ref(false)
        const ITEMADDON_APP_STORE_MODULE_NAME = 'purchase-store-module'
        if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, purchaseStoreModule)

        const modalTables = ref({
            showAmdFields: [
                {
                    key: 'index',
                    label: 'No'
                },
                {
                    key: 'ammendmentDescription',
                    label: 'Details',
                },
                {
                    key: 'createdBy',
                    label: 'Created By',
                },
                {
                    key: 'action',
                    label: 'Action',
                },
            ],
            showAmdData: [],
        })

        const openAmdModal = async () => {
            showAmdDetailsModal.value.show()
        }
        const incrementAmd = async () => {
            formData.value.poAmdNo = (parseInt(formData.value.poAmdNo) + 1)
        }
        const toast = useToast()

        const showOverlayLoading = ref(false)

        const kindOption = ref([])
        axios.get('/api/party/get-all-party-contacts-options')
            .then(res => {
                kindOption.value = res.data.data
            })

        const quotationNoOptions = ref([])
        axios.get('/api/new/get-purchase-quotation-number')
            .then(res => {
                quotationNoOptions.value = res.data.data
            })

        const ReferenceNoOptions = ref([])
        axios.get('/api/new/get-purchase-quotation-reference-number')
            .then(res => {
                ReferenceNoOptions.value = res.data.data
            })

        const getPqReferenceNo = async (id) => {
            await axios.get(`/api/purchase-quotation/${id}`)
                .then(res => {
                    formData.value.refNo = res.data.data?.referenceNumber ?? null
                    formData.value.poQtnNo = res.data.data?.vendorQtnNo ?? null
                    formData.value.poQtnDate = res.data.data?.vendorQtnDate ?? null
                    formData.value.QuotationNo = res.data.data?.vendorQtnNo ?? null
                })
        }

        const purchaseTypeOptions = ref([
            {
                label: 'General',
                value: 1
            },
            {
                label: 'Purchase Order',
                value: 2
            },
            {
                label: 'Import',
                value: 3
            },
            {
                label: 'Labour Service',
                value: 4
            },
            {
                label: 'Service Order',
                value: 5
            },
        ])

        const vendorOptions = ref([])
        axios.get('/api/party/get-master-options')
            .then(res => {
                vendorOptions.value = res.data.data
            })
        const dateFormat = ref({
            date: true,
            delimiter: '/',
            datePattern: ['d', 'm', 'Y'],
        })

        const formatDates = ref({
            poDate: null,
            poAmdDate: null,
            poQtnDate: null,
            poReviewDate: null,
        })

        const getPoFormateDate = (date) => {
            formData.value.poDate = forMatIndianDate(date)
        }
        const getPoAmdChallanFormateDate = (date) => {
            formData.value.poAmdDate = forMatIndianDate(date)
        }
        const getPoQtnFormateDate = (date) => {
            formData.value.poQtnDate = forMatIndianDate(date)
        }
        const getPoReviewFormateDate = (date) => {
            formData.value.poReviewDate = forMatIndianDate(date)
        }

        const statusOptions = ref([
            {
                label: 'Pending',
                value: 1
            },
            {
                label: 'Canceled',
                value: 2
            },
            {
                label: 'Completed',
                value: 3
            },
        ])

        const stageOption = ref([
            {
                label: 'Prepared',
                value: 'Prepared'
            },
            {
                label: 'Approved',
                value: 'Approved'
            },
            {
                label: 'Redo',
                value: 'Redo'
            },
            {
                label: 'Hold',
                value: 'Hold'
            }
        ])

        const supplyOption = ref([
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

        const currencyOptions = ref([])
        axios.get('/api/get-currency-options')
            .then(res => {
                currencyOptions.value = res.data.data
            })

        const getCurrency = async (id) => {
            await axios.get(`/api/currency-master/${id}`)
                .then(res => {
                    formData.value.poConversionRate = res.data.data.currencyRate
                })
        }
        const currentUserData = ref(getUserData())

        const formDataAmd = ref({
            _id: null,
            purchaseOrderId: router.currentRoute.params.id,
            ammendmentDescription: null,
            createdBy: currentUserData.value.first_name + ' ' + currentUserData.value.last_name,
        })

        const formData = ref({
            id: null,
            poVendorId: null,
            poVendorCode: null,
            poVendorName: null,
            poStatus: null,
            poCurrency: null,
            poNumber: null,
            poDate: forMatIndianDate(getTcTodayDate()),
            poConversionRate: null,
            poAmdNo: null,
            poAmdDate: forMatIndianDate(getTcTodayDate()),
            poQtnNo: null,
            poQtnDate: forMatIndianDate(),
            poKindAttn: null,
            poPhoneCountry: '+91',
            poMobileNo: null,
            poEmailId: null,
            Selected: null,
            poRefId: null,
            refNo: null,
            QuotationNo: null,
            poStage: null,
            poReviewDate: forMatIndianDate(),
            poSupplyType: null,
            poRound: 0,
            vendorDetails: {
                vendorCode: null,
                vendorName: null,
                vendorAddress: null,
                vendorArea: null,
                vendorCountry: null,
                vendorState: null,
                vendorCity: null,
                vendorFaxNo: null,
                vendorEmailId: null,
                vendorWebSite: null,
                vendorKindAttn: null,
                vendorStatus: null,
                vendorPinCode: null,
                vendorPhoneCountry: '+91',
                vendorPhoneNo: null,
            },
            headerFooterDetails: {
                header: null,
                headerDescription: null,
                footer: null,
                footerDescription: null,
            },
            noteDetails: {
                orderNote: null,
            },
            workAddressDetails: {
                partyAddress: null,
                partyArea: null,
                partyCity: null,
                partyState: null,
                partyCountry: null,
                partyPinCode: null,
                partyPhoneNoCode: null,
                partyPhoneNo: null,
                partyFaxNo: null,
                partyEmilId: null,
                partyWebsite: null,
            },
            loginDetails: {
                createdBy: null,
                createdDateTime: null,
                modifiedBy: null,
                modifiedDateTime: null,
                approvedBy: null,
                approvedDateTime: null,
                stage: 'Prepared',
            },
        })

        const adminFormData = ref({
            poStage: null,
        })

        const resetFormData = () => {
            formData.value = JSON.parse(JSON.stringify(formData.value))
            formDataAmd.value = JSON.parse(JSON.stringify(formDataAmd.value))
            adminFormData.value = JSON.parse(JSON.stringify(adminFormData.value))
        }

        const CurrentPartyDetailData = ref([])

        const editShowAmdData = (data) => {
            formDataAmd.value = data
        }
        const refetchDataShow = async () => {
            isBusy.value = true
            await axios.get(`/api/new/get-purchase-order-show-amd-list/${router.currentRoute.params.id}`)
                .then(res => {
                    modalTables.value.showAmdData = res.data.data
                })
            isBusy.value = false
        }
        refetchDataShow()

        const getQuotationVendorDetails = async (id) => {
            await axios.get(`/api/party/edit/${id}`)
                .then(res => {
                    CurrentPartyDetailData.value = res.data.data
                    formData.value.poVendorId = CurrentPartyDetailData.value._id
                    formData.value.poVendorName = CurrentPartyDetailData.value.partyName
                    formData.value.poCurrency = CurrentPartyDetailData.value.partyCurrencyType
                    formData.value.poPhoneCountry = CurrentPartyDetailData.value.partyDetails.partyCountryCode
                    formData.value.poMobileNo = CurrentPartyDetailData.value.partyDetails.partyPhoneNo
                    formData.value.poEmailId = CurrentPartyDetailData.value.partyDetails?.partyEmilId
                    formData.value.poSupplyType = CurrentPartyDetailData.value.partySupplyType
                    formData.value.vendorDetails.vendorCode = CurrentPartyDetailData.value._id
                    formData.value.vendorDetails.vendorName = CurrentPartyDetailData.value.partyName
                    formData.value.vendorDetails.vendorAddress = CurrentPartyDetailData.value.partyDetails.partyAddress
                    formData.value.vendorDetails.vendorArea = CurrentPartyDetailData.value.partyDetails.partyArea
                    formData.value.vendorDetails.vendorCountry = CurrentPartyDetailData.value.partyDetails.partyCountry
                    formData.value.vendorDetails.vendorState = CurrentPartyDetailData.value.partyDetails.partyState
                    formData.value.vendorDetails.vendorCity = CurrentPartyDetailData.value.partyDetails.partyCity
                    formData.value.vendorDetails.vendorFaxNo = CurrentPartyDetailData.value.partyDetails.partyFaxNo
                    formData.value.vendorDetails.vendorEmailId = CurrentPartyDetailData.value.partyDetails.partyEmilId
                    formData.value.vendorDetails.vendorGstin = CurrentPartyDetailData.value.taxDetails.gstin
                    formData.value.vendorDetails.vendorWebSite = CurrentPartyDetailData.value.partyDetails.partyWebsite
                    formData.value.vendorDetails.vendorPinCode = CurrentPartyDetailData.value.partyDetails.partyPinCode
                    formData.value.vendorDetails.vendorPhoneCountry = CurrentPartyDetailData.value.partyDetails.partyCountryCode
                    formData.value.vendorDetails.vendorPhoneNo = CurrentPartyDetailData.value.partyDetails.partyPhoneNo
                })

            await axios.get(`/api/new/get-reference-number-by-party/${formData.value.poVendorId}`)
                .then(res => {
                    ReferenceNoOptions.value = res.data.data
                })

            formData.value.kindAttnId = null

            await axios.get(`/api/party/get-party-contacts-options/${id}`)
                .then(res => {
                    kindOption.value = res.data.data
                })

            if (CurrentPartyDetailData.value.partyCurrencyType) {

                formData.value.poCurrency = CurrentPartyDetailData.value.partyCurrencyType

                axios.get(`/api/currency-master/${CurrentPartyDetailData.value.partyCurrencyType}`)
                    .then(Curres => {

                        if (Curres.data.data) {

                            formData.value.poConversionRate = Curres.data.data.currencyRate
                        }
                    })
            }
        }

        const refetchData = async () => {
            showOverlayLoading.value = true
            await axios.get(`/api/purchase-order/${router.currentRoute.params.id}`)
                .then((response) => {
                    formData.value = response.data.data
                    formData.value.id = response.data.data._id
                    delete response.data.data._id
                    if (!response.data.data.loginDetails) {
                        formData.value.loginDetails = {
                            createdBy: null,
                            createdDateTime: null,
                            modifiedBy: null,
                            modifiedDateTime: null,
                            approvedBy: null,
                            approvedDateTime: null,
                            stage: 'Prepared',
                        }
                        adminFormData.value.poStage = response.data.data.poStage
                    } else {
                        adminFormData.value.poStage = response.data.data.loginDetails.stage ?? response.data.data.poStage
                    }
                    if (!response.data.data.workAddressDetails) {
                        formData.value.workAddressDetails = {
                            partyAddress: null,
                            partyArea: null,
                            partyCity: null,
                            partyState: null,
                            partyCountry: null,
                            partyPinCode: null,
                            partyPhoneNoCode: null,
                            partyPhoneNo: null,
                            partyFaxNo: null,
                            partyEmilId: null,
                            partyWebsite: null
                        }
                    }
                })
                .catch(error => {
                    if (error.response.status === 404) {
                        formData.value = undefined
                    }
                })
            showOverlayLoading.value = false
        }
        refetchData()

        const changePoStatusStage = async () => {
            let approvedBy = null,
                approvedDateTime = null
            if (adminFormData.value.poStage === 'Approved') {
                approvedBy = currentUserData.value.first_name + ' ' + currentUserData.value.last_name
                approvedDateTime = getTcTodayDateTime()
            }
            let updatedData = {
                id: router.currentRoute.params.id,
                poStage: adminFormData.value.poStage,
                loginDetails: {
                    createdBy: formData.value.loginDetails.createdBy,
                    createdDateTime: formData.value.loginDetails.createdDateTime,
                    modifiedBy: currentUserData.value.first_name + ' ' + currentUserData.value.last_name,
                    modifiedDateTime: getTcTodayDateTime(),
                    approvedBy: approvedBy,
                    approvedDateTime: approvedDateTime,
                    stage: adminFormData.value.poStage,
                }
            }
            await store.dispatch('purchase-store-module/updatePurchaseOrder', updatedData)
                .then((response) => {
                    if (response.status === 200) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'PO Status changed',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: `You have successfully Change PO Status: ${adminFormData.value.poStage}.`,
                            },
                        })
                    }
                })
            await refetchData()
        }

        const deleteShowAmdData = async (id) => {
            Swal.fire({
                title: 'Are you sure?',
                text: 'Delete Show Amd Details',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, do it!',
                cancelButtonText: 'No, keep it!',
                customClass: {
                    confirmButton: 'btn btn-primary',
                    cancelButton: 'btn btn-outline-danger ml-1',
                },
                buttonsStyling: false,
            })
                .then(result => {
                    if (result.value) {
                        store.dispatch('purchase-store-module/deletePurchaseOrderShowAmdDetail', { id: id })
                            .then(res => {
                                if (res.status === 200) {
                                    toast({
                                        component: ToastificationContent,
                                        position: 'top-right',
                                        props: {
                                            title: 'Purchase Order Show Amd Detail Deleted',
                                            icon: 'CheckSquareIcon',
                                            variant: 'success',
                                            text: `You have successfully Deleted Purchase Order Show Amd.`,
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
                        resetFormData()
                        refetchDataShow()
                    }
                })
        }

        const saveDataShowAmd = async () => {
            if (formDataAmd.value._id === null) {
                await store.dispatch('purchase-store-module/addPurchaseOrderShowAmdDetail', formDataAmd.value)
                    .then(res => {
                        if (res.status === 200) {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Purchase Order Amd Details Added',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: 'You have successfully Added Purchase Order Amd Details',
                                },
                            })
                        } else {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Something went wrong',
                                    icon: 'AlertCircleIcon',
                                    variant: 'danger',
                                    text: 'Something went wrong',
                                },
                            })
                        }
                    })
            } else {
                await store.dispatch('purchase-store-module/updatePurchaseOrderShowAmdDetail', formDataAmd.value)
                    .then(res => {
                        if (res.status === 200) {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Purchase Order Amd Details Update',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: `You have successfully Update Purchase Order Amd Details.`,
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
            }
            resetFormData()
            await refetchDataShow()
        }

        const saveFormData = async () => {
            formData.value.loginDetails.modifiedBy = currentUserData.value.first_name + ' ' + currentUserData.value.last_name
            formData.value.loginDetails.modifiedDateTime = getTcTodayDateTime()

            await store.dispatch('purchase-store-module/updatePurchaseOrder', formData.value)
                .then(res => {
                    if (res.status === 200) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Purchase Order Updated',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: `You have successfully Updated Purchase Order.`,
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
        }

        const {
            refFormObserver,
            getValidationState,
            resetForm
        } = formValidation(resetFormData)

        return {
            formData,
            refetchData,
            showOverlayLoading,
            saveFormData,
            refFormObserver,
            getValidationState,
            resetForm,
            resetFormData,
            required,
            vendorOptions,
            statusOptions,
            currencyOptions,
            getCurrency,
            stageOption,
            supplyOption,
            getQuotationVendorDetails,
            kindOption,
            dateFormat,
            formatDates,
            getPoFormateDate,
            getPoAmdChallanFormateDate,
            getPoQtnFormateDate,
            getPoReviewFormateDate,
            purchaseTypeOptions,
            showAmdDetailsModal,
            openAmdModal,
            isBusy,
            incrementAmd,
            saveDataShowAmd,
            formDataAmd,
            editShowAmdData,
            refetchDataShow,
            modalTables,
            deleteShowAmdData,
            quotationNoOptions,
            ReferenceNoOptions,
            getPqReferenceNo,
            CurrentPartyDetailData,
            currentUserData,
            adminFormData,
            changePoStatusStage,
            // approveOrder,
            // acceptDeclineEvent
        }
    }
}
</script>
