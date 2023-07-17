<template>
    <div>
        <b-card-code>
            <validation-observer #default="{ handleSubmit }">
                <b-form @submit.prevent="handleSubmit(saveFormData)">
                    <b-row>
                        <b-col md="12">
                            <h4>Financial Year</h4>
                            <hr>
                        </b-col>
                        <b-col md="12">
                            <b-row>
                                <b-col md="6">
                                    <validation-provider
                                        #default="validationContext"
                                        name="From"
                                        rules=""
                                    >
                                        <b-form-group
                                            label="From"
                                            label-for="from"
                                        >
                                            <b-input-group>
                                                <cleave
                                                    id="jobCardDate"
                                                    v-model="formData.financialYearFrom"
                                                    class="form-control"
                                                    :raw="false"
                                                    :options="dateFormat"
                                                    placeholder="DD/MM/YYYY"
                                                    show-decade-nav
                                                    :state="getValidationState(validationContext)"
                                                />
                                                <b-input-group-append>
                                                    <b-form-datepicker
                                                        v-model="formatDates.financialYearFrom"
                                                        button-only
                                                        @input="getFinacialFormateDate($event)"
                                                        show-decade-nav
                                                        size="sm"
                                                        nav-button-variant="primary"
                                                        :state="getValidationState(validationContext)"
                                                    />
                                                </b-input-group-append>
                                            </b-input-group>
                                        </b-form-group>
                                    </validation-provider>
                                </b-col>
                                <b-col md="6">
                                    <validation-provider
                                        #default="validationContext"
                                        name="To"
                                        rules=""
                                    >
                                        <b-form-group
                                            label="To"
                                            label-for="to"
                                        >
                                            <b-input-group>
                                                <b-input-group-prepend>
                                                    <b-form-datepicker
                                                        v-model="formatDates.financialYearTo"
                                                        button-only
                                                        @input="getFinalToFormatDate($event)"
                                                        show-decade-nav
                                                        size="sm"
                                                        nav-button-variant="primary"
                                                        :state="getValidationState(validationContext)"
                                                    />
                                                </b-input-group-prepend>
                                                <cleave
                                                    id="prPurchaseDate"
                                                    v-model="formData.financialYearTo"
                                                    class="form-control"
                                                    :raw="false"
                                                    :options="dateFormat"
                                                    placeholder="DD/MM/YYYY"
                                                    show-decade-nav
                                                    :state="getValidationState(validationContext)"
                                                />
                                            </b-input-group>
                                        </b-form-group>
                                    </validation-provider>
                                </b-col>
                            </b-row>
                        </b-col>
                        <b-col md="12">
                            <hr>
                            <h4>Company Details</h4>
                            <hr>
                        </b-col>
                        <b-col md="6">
                            <validation-provider
                                #default="validationContext"
                                name="Company Code"
                                rules="required"
                            >
                                <b-form-group
                                    label="Company Code"
                                    label-for="companyCode"
                                >
                                    <b-form-input
                                        id="companyCode"
                                        :state="getValidationState(validationContext)"
                                        v-model="formData.companyCode"
                                    />
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                            <validation-provider
                                #default="validationContext"
                                name="Company Name"
                                rules="required"
                            >
                                <b-form-group
                                    label="Company Name"
                                    label-for="companyName"
                                >
                                    <b-form-input
                                        id="companyName"
                                        :state="getValidationState(validationContext)"
                                        v-model="formData.companyName"
                                        v-uppercase
                                    />
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                            <validation-provider
                                #default="validationContext"
                                name="Company Type"
                                rules="required"
                            >
                                <b-form-group
                                    label="Company Type"
                                    label-for="companyType"
                                    :state="getValidationState(validationContext)"
                                >
                                    <v-select
                                        placeholder="Select company type"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="companyTypeOption"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        input-id="companyType"
                                        v-model="formData.companyType"
                                    />
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                            <validation-provider
                                #default="validationContext"
                                name="Email"
                                rules="required"
                            >
                                <b-form-group
                                    label="Email"
                                    label-for="email"
                                >
                                    <b-form-input
                                        id="email"
                                        :state="getValidationState(validationContext)"
                                        v-model="formData.emailId"
                                    />
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                            <validation-provider
                                #default="validationContext"
                                name="Website"
                                rules=""
                            >
                                <b-form-group
                                    label="Website"
                                    label-for="website"
                                >
                                    <b-form-input
                                        id="website"
                                        :state="getValidationState(validationContext)"
                                        v-model="formData.website"
                                    />
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                            <validation-provider
                                #default="validationContext"
                                name="Currency"
                            >
                                <b-form-group
                                    label="Currency"
                                    label-for="currency"
                                    :state="getValidationState(validationContext)"
                                >
                                    <v-select
                                        placeholder="Select currency"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="currencyOptions"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        input-id="currency"
                                        v-model="formData.currency"
                                    />
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                            <validation-provider
                                #default="validationContext"
                                name="GSTIN"
                                rules="required"
                            >
                                <b-form-group
                                    label="GSTIN"
                                    label-for="gstNumber"
                                >
                                    <b-form-input
                                        id="gstNumber"
                                        :state="getValidationState(validationContext)"
                                        v-model="formData.gstNumber"
                                    />
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                            <validation-provider
                                #default="validationContext"
                                name="Pan No."
                                rules="required"
                            >
                                <b-form-group
                                    label="Pan No."
                                    label-for="panNumber"
                                >
                                    <b-form-input
                                        id="panNumber"
                                        :state="getValidationState(validationContext)"
                                        v-model="formData.panNumber"
                                    />
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                        </b-col>

                        <b-col md="6">
                            <validation-provider
                                #default="validationContext"
                                name="Address"
                                rules=""
                            >
                                <b-form-group
                                    label="Address"
                                    label-for="address"
                                >
                                    <b-form-textarea
                                        id="address"
                                        rows="2"
                                        :state="getValidationState(validationContext)"
                                        v-model="formData.address"
                                    />
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                            <validation-provider
                                #default="validationContext"
                                name="District"
                            >
                                <b-form-group
                                    label="District"
                                    label-for="city"
                                    :state="getValidationState(validationContext)"
                                >
                                    <v-select
                                        placeholder="Select city"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="cityOptions"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        input-id="city"
                                        v-model="formData.city"
                                        @input="getCityDetails($event)"
                                    />
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                            <validation-provider
                                #default="validationContext"
                                name="State"
                            >
                                <b-form-group
                                    label="State"
                                    label-for="state"
                                    :state="getValidationState(validationContext)"
                                >
                                    <v-select
                                        placeholder="Select state"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="stateOptions"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        input-id="state"
                                        v-model="formData.state"
                                    />
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                            <validation-provider
                                #default="validationContext"
                                name="Country"
                            >
                                <b-form-group
                                    label="Country"
                                    label-for="currency"
                                    :state="getValidationState(validationContext)"
                                >
                                    <v-select
                                        placeholder="Select country"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="countryOptions"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        input-id="country"
                                        v-model="formData.country"
                                    />
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                            <validation-provider
                                #default="validationContext"
                                name="Pin-Code"
                                rules=""
                            >
                                <b-form-group
                                    label="Pin-Code"
                                    label-for="pinCode"
                                >
                                    <b-form-input
                                        id="pinCode"
                                        :state="getValidationState(validationContext)"
                                        v-model="formData.pinCode"
                                        type="number"
                                    />
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                            <validation-provider
                                #default="validationContext"
                                name="Phone No."
                            >
                                <b-form-group
                                    label="Phone No."
                                    label-for="work-phone"
                                >
                                    <b-input-group>
                                        <b-input-group-prepend>
                                            <b-form-input
                                                id="stdCode"
                                                placeholder="STD code"
                                                type="number"
                                                v-model="formData.phoneNumberCode"
                                            />
                                        </b-input-group-prepend>
                                        <b-form-input
                                            id="party-phone"
                                            placeholder="Party Phone"
                                            v-model="formData.phoneNumber"
                                        />
                                    </b-input-group>
                                </b-form-group>
                            </validation-provider>
                            <validation-provider
                                #default="validationContext"
                                name="Fax No."
                                rules=""
                            >
                                <b-form-group
                                    label="Fax No."
                                    label-for="faxNumber"
                                >
                                    <b-form-input
                                        id="faxNumber"
                                        :state="getValidationState(validationContext)"
                                        v-model="formData.faxNumber"
                                    />
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                        </b-col>
                        <b-col md="12">
                            <hr>
                            <h4>Bank Details</h4>
                            <hr>
                            <b-row>
                                <b-col md="6">
                                    <validation-provider
                                        #default="validationContext"
                                        name="Name of Beneficiary"
                                        rules=""
                                    >
                                        <b-form-group
                                            label="Name of Beneficiary"
                                            label-for="nameOfBaneficiary"
                                        >
                                            <b-form-input
                                                id="nameOfBaneficiary"
                                                :state="getValidationState(validationContext)"
                                                v-model="formData.nameOfBeneficiary"
                                            />
                                            <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                                {{ validationContext.errors[0] }}
                                            </b-form-invalid-feedback>
                                        </b-form-group>
                                    </validation-provider>
                                    <validation-provider
                                        #default="validationContext"
                                        name="Bank Name"
                                        rules=""
                                    >
                                        <b-form-group
                                            label="Bank Name"
                                            label-for="bankName"
                                        >
                                            <b-form-input
                                                id="bankName"
                                                :state="getValidationState(validationContext)"
                                                v-model="formData.bankName"
                                            />
                                            <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                                {{ validationContext.errors[0] }}
                                            </b-form-invalid-feedback>
                                        </b-form-group>
                                    </validation-provider>
                                    <validation-provider
                                        #default="validationContext"
                                        name="Branch Name"
                                        rules=""
                                    >
                                        <b-form-group
                                            label="Branch Name"
                                            label-for="branchName"
                                        >
                                            <b-form-input
                                                id="branchName"
                                                :state="getValidationState(validationContext)"
                                                v-model="formData.branchName"
                                            />
                                            <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                                {{ validationContext.errors[0] }}
                                            </b-form-invalid-feedback>
                                        </b-form-group>
                                    </validation-provider>
                                </b-col>
                                <b-col md="6">
                                    <validation-provider
                                        #default="validationContext"
                                        name="Account Number"
                                        rules=""
                                    >
                                        <b-form-group
                                            label="Account Number"
                                            label-for="accountNumber"
                                        >
                                            <b-form-input
                                                id="accountNumber"
                                                :state="getValidationState(validationContext)"
                                                v-model="formData.accountNumber"
                                            />
                                            <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                                {{ validationContext.errors[0] }}
                                            </b-form-invalid-feedback>
                                        </b-form-group>
                                    </validation-provider>
                                    <validation-provider
                                        #default="validationContext"
                                        name="IFS Code"
                                        rules=""
                                    >
                                        <b-form-group
                                            label="IFS Code"
                                            label-for="ifsCode"
                                        >
                                            <b-form-input
                                                id="ifsCode"
                                                :state="getValidationState(validationContext)"
                                                v-model="formData.ifsCode"
                                            />
                                            <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                                {{ validationContext.errors[0] }}
                                            </b-form-invalid-feedback>
                                        </b-form-group>
                                    </validation-provider>
                                    <validation-provider
                                        #default="validationContext"
                                        name="MICR Code"
                                        rules=""
                                    >
                                        <b-form-group
                                            label="MICR Code"
                                            label-for="micrCode"
                                        >
                                            <b-form-input
                                                id="micrCode"
                                                :state="getValidationState(validationContext)"
                                                v-model="formData.micrCode"
                                            />
                                            <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                                {{ validationContext.errors[0] }}
                                            </b-form-invalid-feedback>
                                        </b-form-group>
                                    </validation-provider>
                                </b-col>
                            </b-row>
                        </b-col>
                        <b-col md="12">
                            <hr>
                            <h4>E-Invoice & E-Bill Credentials</h4>
                            <hr>
                            <b-row>
                                <b-col md="6">
                                    <validation-provider
                                        #default="validationContext"
                                        name="Email"
                                        rules=""
                                    >
                                        <b-form-group
                                            label="Email"
                                            label-for="ewayEmail"
                                        >
                                            <b-form-input
                                                id="ewayEmail"
                                                :state="getValidationState(validationContext)"
                                                v-model="formData.ewayEmail"
                                            />
                                            <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                                {{ validationContext.errors[0] }}
                                            </b-form-invalid-feedback>
                                        </b-form-group>
                                    </validation-provider>
                                    <validation-provider
                                        #default="validationContext"
                                        name="Username"
                                        rules=""
                                    >
                                        <b-form-group
                                            label="Username"
                                            label-for="ewayUsername"
                                        >
                                            <b-form-input
                                                id="ewayUsername"
                                                :state="getValidationState(validationContext)"
                                                v-model="formData.ewayUsername"
                                            />
                                            <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                                {{ validationContext.errors[0] }}
                                            </b-form-invalid-feedback>
                                        </b-form-group>
                                    </validation-provider>
                                    <validation-provider
                                        #default="validationContext"
                                        name="Password"
                                        rules=""
                                    >
                                        <b-form-group
                                            label="Password"
                                            label-for="ewayPassword"
                                        >
                                            <b-form-input
                                                id="ewayPassword"
                                                :state="getValidationState(validationContext)"
                                                v-model="formData.ewayPassword"
                                            />
                                            <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                                {{ validationContext.errors[0] }}
                                            </b-form-invalid-feedback>
                                        </b-form-group>
                                    </validation-provider>
                                </b-col>
                                <b-col md="6">
                                    <validation-provider
                                        #default="validationContext"
                                        name="Client ID"
                                        rules=""
                                    >
                                        <b-form-group
                                            label="Client ID"
                                            label-for="ewayClientId"
                                        >
                                            <b-form-input
                                                id="ewayClientId"
                                                :state="getValidationState(validationContext)"
                                                v-model="formData.ewayClientId"
                                            />
                                            <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                                {{ validationContext.errors[0] }}
                                            </b-form-invalid-feedback>
                                        </b-form-group>
                                    </validation-provider>
                                    <validation-provider
                                        #default="validationContext"
                                        name="Client Secret"
                                        rules=""
                                    >
                                        <b-form-group
                                            label="Client Secret"
                                            label-for="ewayClientSecret"
                                        >
                                            <b-form-input
                                                id="ewayClientSecret"
                                                :state="getValidationState(validationContext)"
                                                v-model="formData.ewayClientSecret"
                                            />
                                            <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                                {{ validationContext.errors[0] }}
                                            </b-form-invalid-feedback>
                                        </b-form-group>
                                    </validation-provider>
                                    <validation-provider
                                        #default="validationContext"
                                        name="GSTIN"
                                        rules=""
                                    >
                                        <b-form-group
                                            label="GSTIN"
                                            label-for="ewayGstin"
                                        >
                                            <b-form-input
                                                id="ewayGstin"
                                                :state="getValidationState(validationContext)"
                                                v-model="formData.ewayGstin"
                                            />
                                            <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                                {{ validationContext.errors[0] }}
                                            </b-form-invalid-feedback>
                                        </b-form-group>
                                    </validation-provider>
                                </b-col>
                            </b-row>
                        </b-col>
                        <!--Button-->
                        <b-col md="12">
                            <hr>
                            <b-button
                                type="submit"
                                class="float-right"
                                variant="primary"
                            >
                                Save
                            </b-button>
                        </b-col>
                    </b-row>
                </b-form>
            </validation-observer>
        </b-card-code>
    </div>
</template>
<script>
    import BCardCode from "@core/components/b-card-code/BCardCode";
    import formValidation from "@core/comp-functions/forms/form-validation";
    import {
        BButton,
        BCol,
        BForm,
        BFormCheckbox,
        BFormDatepicker,
        BFormGroup,
        BFormInput,
        BFormInvalidFeedback,
        BFormRadio,
        BFormTextarea,
        BInputGroup,
        BInputGroupPrepend,
        BInputGroupAppend,
        BRow
    } from 'bootstrap-vue'
    import {ValidationObserver, ValidationProvider} from 'vee-validate'
    import vSelect from 'vue-select'
    import {onUnmounted, ref} from "@vue/composition-api";
    import store from '@/store'
    import {required} from '@validations'
    import {useToast} from 'vue-toastification/composition'
    import administrationStoreModule from "../administrationStoreModule";
    import countryCode from '@/@fake-db/data/other/country-code'
    import axios from '@axios'
    import Ripple from "vue-ripple-directive";
    import router from '@/router'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import {forMatIndianDate} from "../../../@core/utils/utils";
    import Cleave from 'vue-cleave-component'

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
            ValidationObserver,
            ValidationProvider,
            vSelect,
            BForm,
            BRow,
            BCol,
            BFormGroup,
            BFormInput,
            BFormInvalidFeedback,
            BFormDatepicker,
            BFormCheckbox,
            BButton,
            BFormRadio,
            BFormTextarea,
            BInputGroup,
            BInputGroupPrepend,
            BInputGroupAppend,
            Cleave
        },
        computed: {
            countryCode: () => countryCode
        },
        directives: {
            Ripple,
            uppercase,
        },
        setup() {
            const ITEMADDON_APP_STORE_MODULE_NAME = 'administration-store-module'
            if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, administrationStoreModule)
            onUnmounted(() => {
                if (store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.unregisterModule(ITEMADDON_APP_STORE_MODULE_NAME)
            })

            const toast = useToast()

            const dateFormat = ref({
                date: true,
                delimiter: '/',
                datePattern: ['d', 'm', 'Y'],
            })

            const formatDates = ref({
                financialYearFrom: null,
                financialYearTo: null,
            })

            const getFinacialFormateDate = (date) => {
                formData.value.financialYearFrom = forMatIndianDate(date)
            }

            const getFinalToFormatDate = (date) => {
                formData.value.financialYearTo = forMatIndianDate(date)
            }

            const companyTypeOption = ref([
                {label: 'Private Limited', value: 1},
                {label: 'Public Limited', value: 2},
                {label: 'Partnerships Company', value: 3},
                {label: 'Limited Liability Partnership', value: 4},
                {label: 'One Person Company', value: 5},
                {label: 'Sole Proprietorship', value: 6},
                {label: 'Section 8 Company', value: 7},
            ])

            const countryOptions = ref([])
            axios.get('/api/get-country-options').then(res => {
                countryOptions.value = res.data.data
            })
            const stateOptions = ref([])
            axios.get('/api/get-state-options').then(res => {
                stateOptions.value = res.data.data
            })

            const cityOptions = ref([])
            axios.get('/api/get-city-options').then(res => {
                cityOptions.value = res.data.data
            })

            const getCityDetails = async (id) => {
            await axios.get(`/api/city-master/${id}`) .then(res => {
                formData.value.state = res.data.data.state
                formData.value.country = res.data.data.country
            })
            }

            const currencyOptions = ref([])
            axios.get('/api/get-currency-options').then(res => {
                currencyOptions.value = res.data.data
            })

            const blankFormData = {
                _id: null,
                companyCode: null,
                companyName: null,
                companyType: null,
                address: null,
                city: null,
                state: null,
                country: null,
                pinCode: null,
                currency: null,
                phoneNumber: null,
                phoneNumberCode: '',
                faxNumber: null,
                emailId: null,
                website: null,
                financialYearFrom: forMatIndianDate(),
                financialYearTo: forMatIndianDate(),
                gstNumber: null,
                panNumber: null,
                nameOfBeneficiary: null,
                bankName: null,
                branchName: null,
                accountNumber: null,
                ifsCode: null,
                micrCode: null,
                ewayEmail: null,
                ewayUsername: null,
                ewayPassword: null,
                ewayClientId: null,
                ewayClientSecret: null,
                ewayGstin: null,
            }

            const formData = ref(JSON.parse(JSON.stringify(blankFormData)))

            const resetFormData = () => {
                formData.value = JSON.parse(JSON.stringify(blankFormData))
            }

            const saveFormData = async () => {
                console.log(formData.value)
                await store.dispatch('administration-store-module/addCompanyDetails', formData.value).then(res => {
                    if (res.status === 200) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Company Added',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: `You have successfully Added Company.`,
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
                    router.push({
                        name: 'edit-company-details',
                        params: {
                            id: res.data.data._id
                        }
                    })
                })
            }

            const {refFormObserver, getValidationState, resetForm} = formValidation(resetFormData)

            return {
                companyTypeOption,
                countryOptions,
                stateOptions,
                cityOptions,
                currencyOptions,
                formData,
                resetFormData,
                saveFormData,

                //validation
                refFormObserver,
                required,
                getValidationState,
                resetForm,
                getFinacialFormateDate,
                getFinalToFormatDate,
                formatDates,
                dateFormat,
                getCityDetails
            }
        }
    }
</script>
