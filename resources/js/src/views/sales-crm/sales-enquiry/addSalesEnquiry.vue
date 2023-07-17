<template>
    <b-card-code>
        <validation-observer ref="simpleRules">
            <b-form>
                <b-row>
                    <b-col md="7">
                        <b-row>
                            <b-col md="3">
                                <b-form-group
                                    label="Enquiry No"
                                    label-for="enquiryNo"
                                >
                                    <b-form-input
                                        id="enquiryNo"
                                        readonly
                                    />

                                </b-form-group>
                            </b-col>

                            <b-col md="3">
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
                                    label="Customer Code"
                                    label-for="customerId"
                                >
                                    <v-select
                                        v-model="partyFormData.customerId"
                                        placeholder="Select Customer"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="PartyListOption"
                                        :clearable="false"
                                        v-on:input="getPartyCode(partyFormData.customerId)"
                                        input-id="customerId"
                                    />
                                </b-form-group>
                            </b-col>

                            <b-col md="12">
                                <b-form-group
                                    label="Customer Name"
                                    label-for="customerName"
                                >
                                    <validation-provider
                                        #default="{ errors }"
                                        name="Customer Name"
                                        rules="required"
                                    >
                                        <b-form-input
                                            id="customerName"
                                            v-model="partyFormData.customerName"
                                            placeholder="Customer Name"
                                            :state="errors.length > 0 ? false:null"
                                        />
                                        <small class="text-danger">{{ errors[0] }}</small>
                                    </validation-provider>
                                </b-form-group>
                            </b-col>

                            <b-col md="12">
                                <b-form-group
                                    label="Address"
                                    label-for="customerAddress"
                                >
                                    <b-form-textarea
                                        id="customerAddress"
                                        placeholder="Address"
                                        rows="2"
                                        v-model="partyFormData.customerAddress"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="District"
                                    label-for="customerCity"
                                >
                                    <v-select
                                        v-model="partyFormData.customerCity"
                                        placeholder="Select District"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="cityOptions"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        input-id="customerCity"
                                        @input="getCityDetails($event)"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="State"
                                    label-for="customerState"
                                >
                                    <v-select
                                        v-model="partyFormData.customerState"
                                        placeholder="Select State"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="stateOptions"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        input-id="customerState"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Country"
                                    label-for="customerCountry"
                                >
                                    <v-select
                                        v-model="partyFormData.customerCountry"
                                        placeholder="Select Country"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="countryOptions"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        input-id="customerCountry"
                                    />
                                </b-form-group>
                            </b-col>

                            <b-col md="6">
                                <b-form-group
                                    label="Pin Code"
                                    label-for="customerPinCode"
                                >
                                    <b-form-input
                                        id="customerPinCode"
                                        v-model="partyFormData.customerPinCode"
                                        placeholder="Pin code"
                                    />

                                </b-form-group>
                            </b-col>

                            <b-col md="12">
                                <b-form-group
                                    label="Phone No"
                                    label-for="customerMobileNo"
                                >
                                    <b-input-group>
                                        <b-input-group-prepend>
                                            <b-form-input
                                                id="stdCode"
                                                placeholder="STD code"
                                                type="number"
                                                v-model="partyFormData.customercountryCode"
                                            />
                                        </b-input-group-prepend>
                                        <b-form-input
                                            id="party-phone"
                                            placeholder="Party Phone"
                                            v-model="partyFormData.customerMobileNo"
                                        />
                                    </b-input-group>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Email Id"
                                    label-for="customerEmailId"
                                >
                                    <b-form-input
                                        id="customerEmailId"
                                        v-model="partyFormData.customerEmailId"
                                        placeholder="Email Id"
                                    />

                                </b-form-group>
                            </b-col>

                            <b-col md="6">
                                <b-form-group
                                    label="Fax No"
                                    label-for="customerFaxNo"
                                >
                                    <b-form-input
                                        id="customerFaxNo"
                                        v-model="partyFormData.customerFaxNo"
                                        placeholder="Fax No"
                                    />

                                </b-form-group>
                            </b-col>

                            <b-col md="6">
                                <b-form-group
                                    label="Website"
                                    label-for="customerWebsite"
                                >
                                    <b-form-input
                                        id="customerWebsite"
                                        v-model="partyFormData.customerWebsite"
                                        placeholder="Website"
                                    />

                                </b-form-group>
                            </b-col>

                            <b-col md="6">
                                <b-form-group
                                    label="GST No."
                                    label-for="customerGstNo"
                                >
                                    <b-form-input
                                        id="customerGstNo"
                                        v-model="partyFormData.customerGstNo"
                                        placeholder="GST NO"
                                        maxlength="15"
                                        class="text-uppercase"
                                    />

                                </b-form-group>
                            </b-col>

                            <b-col md="6">
                                <b-form-group
                                    label="PAN No."
                                    label-for="customerPanNo"
                                >
                                    <b-form-input
                                        id="customerPanNo"
                                        v-model="partyFormData.customerPanNo"
                                        placeholder="Pan No."
                                        maxlength="10"
                                        class="text-uppercase"
                                    />

                                </b-form-group>
                            </b-col>

                            <b-col md="6">
                                <b-form-group
                                    label="Project"
                                    label-for="customerProject"
                                >
                                    <b-form-input
                                        id="customerProject"
                                        v-model="partyFormData.customerProject"
                                        placeholder="Project"
                                    />

                                </b-form-group>
                            </b-col>

                            <b-col md="12">
                                <b-form-group
                                    label="Kind Attn"
                                    label-for="kindAttn"
                                >
                                    <v-select
                                        v-model="partyFormData.kindAttn"
                                        placeholder="Select user"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="KindAttnOptions"
                                        :clearable="false"
                                        :reduce="val => val.value"
                                        v-on:input="getContactDetail(partyFormData.kindAttn)"
                                        input-id="kindAttn"
                                    />
                                </b-form-group>
                            </b-col>

                            <b-col md="12">
                                <b-form-group
                                    label="Contact Person Name"
                                    label-for="contactPersonName"
                                >
                                    <b-form-input
                                        id="contactPersonName"
                                        v-model="partyFormData.contactPersonName"
                                        placeholder="Contact Person Name"
                                    />

                                </b-form-group>
                            </b-col>
                            <b-col md="12">
                            <b-form-group
                                label="Mobile No"
                                label-for="contact-mobile"
                            >
                                <b-input-group>
                                    <b-input-group-prepend>
                                        <v-select
                                            placeholder="Select Country"
                                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                            :options="countryCode"
                                            :get-option-label="option => `${option.name} (${option.dial_code}) `"
                                            :clearable="false"
                                            :reduce="val => val.dial_code"
                                            v-model="partyFormData.personCountryCode"
                                            input-id="mobileNoCode"
                                        />
                                    </b-input-group-prepend>
                                    <b-form-input
                                        id="contact-mobile"
                                        placeholder="Mobile No"
                                        type="number"
                                        v-model="partyFormData.contactPersonMobileNo"
                                    />
                                </b-input-group>
                            </b-form-group>
                            </b-col>
                            <b-col md="12">
                                <b-form-group
                                    label="Contact Person Email"
                                    label-for="contactPersonEmailId"
                                >
                                    <b-form-input
                                        id="contactPersonEmailId"
                                        v-model="partyFormData.contactPersonEmailId"
                                        placeholder="Contact Person Email"
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>
                    </b-col>

                    <b-col md="5">
                        <b-row>

                            <b-col md="12">
                                <b-form-group
                                    label="Reference"
                                    label-for="reference"
                                >
                                    <b-form-textarea
                                        id="reference"
                                        placeholder="Reference"
                                        rows="2"
                                        v-model="partyFormData.reference"
                                    />
                                </b-form-group>
                            </b-col>

                            <b-col md="12">
                                <b-form-group
                                    label="Our Reference"
                                    label-for="ourReference"
                                >
                                    <b-form-textarea
                                        id="ourReference"
                                        placeholder="Our Reference"
                                        rows="2"
                                        v-model="partyFormData.ourReference"
                                    />
                                </b-form-group>
                            </b-col>


                            <b-col md="6">
                                <b-form-group
                                    label="Industry Type"
                                    label-for="industryType"
                                >
                                    <v-select
                                        v-model="partyFormData.industryType"
                                        placeholder="Select Industry Type"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="IndustryTypeOptions"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        input-id="industryType"
                                    />
                                </b-form-group>
                            </b-col>

                            <b-col md="6">
                                <b-form-group
                                    label="Enquiry Stage"
                                    label-for="enquiryStage"
                                >
                                    <v-select
                                        v-model="partyFormData.enquiryStage"
                                        placeholder="Select Enquiry Stage"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="EnquiryStageOptions"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        input-id="enquiryStage"
                                    />
                                </b-form-group>
                            </b-col>

                            <b-col md="12">
                                <b-form-group
                                    label="Enquiry Date"
                                    label-for="enquiryDate"
                                >
                                    <b-input-group>
                                        <b-input-group-prepend>
                                            <b-form-datepicker
                                                v-model="formatDates.enquiryDate"
                                                button-only
                                                @input="getEnquiryFormateDate($event)"
                                                show-decade-nav
                                                size="sm"
                                                nav-button-variant="primary"
                                            />
                                        </b-input-group-prepend>
                                        <cleave
                                            id="enquiryDate"
                                            v-model="partyFormData.enquiryDate"
                                            class="form-control"
                                            :raw="false"
                                            :options="dateFormat"
                                            placeholder="DD/MM/YYYY"
                                            show-decade-nav
                                        />
                                    </b-input-group>
                                </b-form-group>
                            </b-col>
                            <b-col md="12">
                                <b-form-group
                                    label="Reference Date"
                                    label-for="referenceDate"
                                >
                                    <b-input-group>
                                        <b-input-group-prepend>
                                            <b-form-datepicker
                                                v-model="formatDates.referenceDate"
                                                button-only
                                                @input="getReferenceFormateDate($event)"
                                                show-decade-nav
                                                size="sm"
                                                nav-button-variant="primary"
                                            />
                                        </b-input-group-prepend>
                                        <cleave
                                            id="referenceDate"
                                            v-model="partyFormData.referenceDate"
                                            class="form-control"
                                            :raw="false"
                                            :options="dateFormat"
                                            placeholder="DD/MM/YYYY"
                                            show-decade-nav
                                        />
                                    </b-input-group>
                                </b-form-group>
                            </b-col>

                            <b-col md="12">
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
                            </b-col>

                            <b-col md="12">
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

                            <b-col md="12">
                                <b-form-group
                                    label="Branch"
                                    label-for="branch"
                                >
                                    <v-select
                                        v-model="partyFormData.branch"
                                        placeholder="Select Branch"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="BranchOptions"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        input-id="branch"
                                    />
                                </b-form-group>
                            </b-col>

                            <b-col md="6">
                                <b-form-group
                                    label="Enquiry By"
                                    label-for="enquiryBy"
                                >
                                    <v-select
                                        v-model="partyFormData.enquiryBy"
                                        placeholder="Select Enq By"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="EnqByOptions"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        input-id="enquiryBy"
                                    />
                                </b-form-group>
                            </b-col>

                            <b-col md="6">
                                <b-form-group
                                    label="Enquiry Status"
                                    label-for="enquiryStatus"
                                >
                                    <v-select
                                        v-model="partyFormData.enquiryStatus"
                                        placeholder="Select Enq Status"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="EnqStatusOptions"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        input-id="enquiryStatus"
                                    />
                                </b-form-group>
                            </b-col>

                            <b-col md="12">
                                <b-form-group
                                    label="Assign To"
                                    label-for="enquiryAssignTo"
                                >
                                    <v-select
                                        v-model="partyFormData.enquiryAssignTo"
                                        placeholder="Select Assign To"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="userOptions"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        @input="getAssignData($event)"
                                        input-id="enquiryAssignTo"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="12">
                                <b-form-group
                                    label="Assign To"
                                    label-for="enquiryAssignName"
                                >
                                    <b-form-input
                                        id="enquiryAssignName"
                                        v-model="partyFormData.enquiryAssignName"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="12">
                                <b-form-group
                                    label="Followup By"
                                    label-for="enquiryFollowUpBy"
                                >
                                    <v-select
                                        v-model="partyFormData.enquiryFollowUpBy"
                                        placeholder="Select Followup By"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="userOptions"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        @input="getFllowedData($event)"
                                        input-id="enquiryFollowUpBy"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="12">
                                <b-form-group
                                    label="Followup By"
                                    label-for="followByName"
                                >
                                    <b-form-input
                                        id="followByName"
                                        v-model="partyFormData.followByName"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Sales"
                                    label-for="salesFrom"
                                >
                                    <v-select
                                        v-model="partyFormData.salesFrom"
                                        placeholder="Select Sales From"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="SalesFromOptions"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        input-id="salesFrom"
                                    />
                                </b-form-group>
                            </b-col>

                            <b-col md="6">
                                <b-form-group
                                    label="Sales Type"
                                    label-for="salesType"
                                >
                                    <v-select
                                        v-model="partyFormData.salesType"
                                        placeholder="Select Sales Type"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="SalesTypeOptions"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        input-id="salesType"
                                    />
                                </b-form-group>
                            </b-col>

                        </b-row>
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
    BRow,
    BCol,
    BFormGroup,
    BFormInput,
    BFormTextarea,
    BForm,
    BButton,
    BFormDatepicker,
    BInputGroup,
    BInputGroupPrepend,
    BInputGroupAppend
} from 'bootstrap-vue'
import {required} from '@validations'
import Ripple from 'vue-ripple-directive'
import vSelect from 'vue-select'
import store from '@/store'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
import {ref, onUnmounted, computed} from '@vue/composition-api'
import salesStoreModule from '../salesStoreModule'
import countryCode from '@/@fake-db/data/other/country-code'
import {getTcTodayDate} from '@core/utils/utils'
import Cleave from 'vue-cleave-component'
import {forMatIndianDate} from "../../../@core/utils/utils";
import moment from "moment";
import {getUserData} from "../../../auth/utils";
import axios from '@axios'

export default {
    components: {
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
        BInputGroup,
        BInputGroupPrepend,
        BInputGroupAppend,
        vSelect,
        Cleave
    },
    directives: {
        Ripple,
    },
    computed: {
        countryCode: () => countryCode
    },
    data() {
        return {
            EnquiryStageOptions: [
                {label: 'Active', value: 1},
                {label: 'Achieved', value: 2},
                {label: 'Regret', value: 3},
                {label: 'Closed', value: 4},
                {label: 'Follow Up', value: 5},
            ],
            EnqStatusOptions: [
                {label: 'Pending', value: 1},
                {label: 'Completed', value: 2},
                {label: 'Regret', value: 3},
                {label: 'Cancelled', value: 4},
            ],
            SalesFromOptions: [
                {label: 'Domestic', value: 1},
                {label: 'Export', value: 2},
            ],
            SalesTypeOptions: [],
            userOptions: [],
            KindAttnOptions: [],
            PartyListOption: [],
            countryOptions: [],
            stateOptions: [],
            cityOptions: [],
            IndustryTypeOptions: [],
            // EnquiryStageOptions: [],
            BranchOptions: [],
            EnqByOptions: [],
        }
    },
    setup() {
        const SE_APP_STORE_MODULE_NAME = 'sales-enquiry-module'
        // Register module
        if (!store.hasModule(SE_APP_STORE_MODULE_NAME)) store.registerModule(SE_APP_STORE_MODULE_NAME, salesStoreModule)
        // UnRegister on leave
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
            referenceDate: null,
            dueDate: null,
            reviewDate: null,
        })

        const getEnquiryFormateDate = (date) => {
            partyFormData.value.enquiryDate = forMatIndianDate(date)
        }
        const getReferenceFormateDate = (date) => {
            partyFormData.value.referenceDate = forMatIndianDate(date)
        }
        const getDueFormateDate = (date) => {
            partyFormData.value.dueDate = forMatIndianDate(date)
        }
        const getReviewFormateDate = (date) => {
            partyFormData.value.reviewDate = forMatIndianDate(date)
        }
        const CurrentUserData = ref(getUserData())

        const partyFormData = ref({
            id: null,
            partyId: null,
            customerId: null,
            customerCode: null,
            customerName: null,
            customerAddress: null,
            customerCity: null,
            customerState: null,
            customerCountry: null,
            customerPinCode: null,
            customerFaxNo: null,
            customercountryCode: null,
            customerMobileNo: null,
            customerEmailId: null,
            customerWebsite: null,
            customerProject: null,
            customerGstNo: null,
            customerPanNo: null,
            contactPersonName: null,
            // contactPersonMobileNo: null,
            contactPersonEmailId: null,
            kindAttn: null,
            personCountryCode:'+91',
            contactPersonMobileNo: null,
            emailId: null,
            reference: null,
            ourReference: null,
            industryType: null,
            enquiryStage: 1,
            enquiryDate: forMatIndianDate(getTcTodayDate()),
            referenceDate: forMatIndianDate(),
            isReviewDate: null,
            reviewDate: forMatIndianDate(),
            dueDate: forMatIndianDate(),
            branch: null,
            enquiryBy: null,
            enquiryStatus: 1,
            enquiryAssignTo: null,
            enquiryAssignName:null,
            enquiryFollowUpBy: null,
            followByName:null,
            salesFrom: null,
            salesType: null,
            itemDetails: null,
            confirmationDetails: null,
            historyDetails: null,
            letterDetails: null,
            loginData: {
                createdBy: CurrentUserData.value.first_name + ' ' + CurrentUserData.value.last_name,
                createdDateTime: moment(new Date()).format('DD/MM/YYYY HH:mm'),
                lastModifiedBy: null,
                modifiedDateTime: null,
                approvedBy: null,
                approvedDateTime: null,
                stage:null,
            },
        })
        return {
            partyFormData,
            required,
            dateFormat,
            formatDates,
            getEnquiryFormateDate,
            getReferenceFormateDate,
            getDueFormateDate,
            getReviewFormateDate
        }
    },
    created() {
        this.$http.get('/api/get-item-sales-target-group-options').then(res => {
            this.SalesTargetOption = res.data.data
        })
        this.$http.get('/api/get-account-ledger-options').then(res => {
            this.GlAccountOption = res.data.data
        })
        this.$http.get('/api/get-country-options').then(res => {
            this.countryOptions = res.data.data
        })
        this.$http.get('/api/get-state-options').then(res => {
            this.stateOptions = res.data.data
        })
        this.$http.get('/api/get-city-options').then(res => {
            this.cityOptions = res.data.data
        })
        this.$http.get('/api/get-industry-type-options').then(res => {
            this.IndustryTypeOptions = res.data.data
        })
        this.$http.get('/api/get-enquiry-ref-options').then(res => {
            this.EnqByOptions = res.data.data
        })

        this.$http.get('/api/get-branch-master-options').then(res => {
            this.BranchOptions = res.data.data
        })
        this.$http.get('/api/party/get-master-customer-options').then(res => {
            this.PartyListOption = res.data.data
        })
        this.$http.get('/api/get-users-options').then(res => {
            this.userOptions = res.data.data
        })
        this.$http.get('/api/get-sales-order-type-options')
            .then(res => {
                this.SalesTypeOptions = res.data.data
            })
        /* {label: 'Product Order', value: 1},
            {label: 'Machine Order', value: 2},
            {label: 'Spare Order', value: 3},
            {label: 'Repairing & Service', value: 4}, */
    },
    methods: {
        async getCityDetails(id) {
            await this.$http.get(`/api/city-master/${id}`).then((res) => {
                this.partyFormData.customerState = res.data.data.state
                this.partyFormData.customerCountry = res.data.data.country
            });
        },
        async getAssignData(id) {
            await this.$http.get(`/api/get-users-details/${id}`).then((res) => {
                this.partyFormData.enquiryAssignName = res.data.data.first_name + ' ' + res.data.data.last_name
        });
        },
        async getFllowedData(id) {
            await this.$http.get(`/api/get-users-details/${id}`).then((res) => {
                this.partyFormData.followByName = res.data.data.first_name + ' ' + res.data.data.last_name
            });
        },
        getPartyCode(val) {
            this.partyFormData.kindAttn = null
            this.partyFormData.contactPersonName = null
            this.partyFormData.contactPersonMobileNo = null
            this.partyFormData.contactPersonEmailId = null
            this.$http.get(`/api/party/get-party-contacts-options/${val.value}`).then(res => {
                this.KindAttnOptions = res.data.data
            })
            this.$http.get(`/api/party/edit/${val.value}`).then(res => {
                this.partyFormData.partyId = res.data?.data?._id
                this.partyFormData.customerCode = res.data.data.partyCode
                this.partyFormData.customerName = res.data.data.partyName
                this.partyFormData.customerAddress = res.data.data.partyDetails ? res.data.data.partyDetails.partyAddress : null
                this.partyFormData.customerCity = res.data.data.partyDetails ? res.data.data?.partyDetails?.partyCity?.value : null
                this.partyFormData.customerState = res.data.data.partyDetails ? res.data.data.partyDetails?.partyState?.value : null
                this.partyFormData.customerCountry = res.data.data.partyDetails ? res.data.data.partyDetails?.partyCountry?.value : null
                this.partyFormData.customerPinCode = res.data.data.partyDetails ? res.data.data.partyDetails.partyPinCode : null
                this.partyFormData.customerFaxNo = res.data.data.partyDetails ? res.data.data.partyDetails.partyFaxNo : null
                this.partyFormData.customerMobileNo = res.data.data.partyDetails ? res.data.data.partyDetails.partyPhoneNo : null
                this.partyFormData.customerEmailId = res.data.data.partyDetails ? res.data.data.partyDetails.partyEmilId : null
                this.partyFormData.customerWebsite = res.data.data.partyDetails ? res.data.data.partyDetails.partyWebsite : null
                this.partyFormData.customercountryCode = res.data.data.partyDetails ? res.data.data.partyDetails.partyCountryCode : null

                if (res.data.data.taxDetails) {

                    this.partyFormData.customerGstNo = res.data.data.taxDetails.gstin
                    this.partyFormData.customerPanNo = res.data.data.taxDetails.panNo

                }

                if (res.data.data.partyBranch) {

                    this.partyFormData.branch = res.data.data.partyBranch.value
                }

                if (res.data.data.partyTypeIndustry) {

                    this.partyFormData.industryType = res.data.data.partyTypeIndustry
                }
            })
        },
        getContactDetail(val) {

            this.$http.get(`/api/party/contact-person/${val}`).then(res => {

                this.partyFormData.contactPersonName = res.data.data.personName
                this.partyFormData.contactPersonMobileNo = res.data.data.mobileNo
                this.partyFormData.personCountryCode = res.data.data.mobileNoCode
                this.partyFormData.contactPersonEmailId = res.data.data.email
            })

        },

        validationForm() {
            this.$refs.simpleRules.validate().then(success => {
                if (success) {
                    store.dispatch('sales-enquiry-module/addSalesEnquiry', this.partyFormData).then(response => {
                        if (response.status === 200) {
                            this.$router.push({name: 'edit-sales-enquiry', params: {id: response.data.data._id}})
                            this.$toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Party Created',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: `You have successfully Created New Sales Enquiry`,
                                },
                            })
                        }
                    })
                }
            })
        },
    }
}
</script>
