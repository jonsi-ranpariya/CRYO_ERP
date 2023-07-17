<template>
    <b-card-code>
        <validation-observer
            ref="validateRules"
            #default="{ handleSubmit }"
        >
            <b-form
                @submit.prevent="handleSubmit(submitFormData)"
                @reset.prevent="resetForm"
            >
                <b-row>
                    <b-col md="6">
                        <b-form-group
                            label="Account No."
                            label-for="accountNo"
                        >
                            <b-form-input
                                id="accountNo"
                                v-model="formData.accountNo"
                                readonly
                            />
                        </b-form-group>
                        <b-form-group
                            label="Account Name"
                            label-for="accountName"
                        >
                            <validation-provider
                                #default="validationContext"
                                name="Account Name"
                                rules="required"
                            >
                                <b-form-input
                                    id="accountName"
                                    v-model="formData.accountName"
                                    :state="getValidationState(validationContext)"
                                />
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </validation-provider>
                        </b-form-group>
                    </b-col>
                    <b-col md="4">
                        <b-form-group
                            label="Op. Bal. Book"
                            label-for="opBalBook"
                        >
                            <validation-provider
                                #default="validationContext"
                                name="Op. Bal. Book"
                                rules="required"
                            >
                                <b-form-input
                                    id="opBalBook"
                                    v-model="formData.opBalBook"
                                    :state="getValidationState(validationContext)"
                                />
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </validation-provider>
                        </b-form-group>
                        <div v-if="secondOpBalBookOption">
                            <b-form-group
                                label="Op. Bal. Book"
                                label-for="opBalBook1"
                            >
                                <validation-provider
                                    #default="validationContext"
                                    name="Op. Bal. Book"
                                    rules="required"
                                >
                                    <b-form-input
                                        id="opBalBook1"
                                        v-model="formData.opBalBook1"
                                        :state="getValidationState(validationContext)"
                                    />
                                    <b-form-invalid-feedback>
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </validation-provider>
                            </b-form-group>
                        </div>
                    </b-col>
                    <b-col md="2">
                        <b-form-group
                            label="Type"
                            label-for="opBalBookOption"
                        >
                            <validation-provider
                                #default="validationContext"
                                name=""
                                rules="required"
                            >
                                <v-select
                                    id="opBalBookOption"
                                    v-model="formData.opBalBookOption"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="options"
                                    label="title"
                                    value="value"
                                    :clearable="false"
                                    :reduce="val => val.value"
                                    :state="getValidationState(validationContext)"
                                />
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </validation-provider>
                        </b-form-group>
                        <div v-if="secondOpBalBookOption">
                            <b-form-group
                                label="Type"
                                label-for="opBalBookOption1"
                            >
                                <validation-provider
                                    #default="validationContext"
                                    name=""
                                    rules="required"
                                >
                                    <v-select
                                        id="opBalBookOption1"
                                        v-model="formData.opBalBookOption1"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="options"
                                        label="title"
                                        value="value"
                                        :clearable="false"
                                        :reduce="val => val.value"
                                        :state="getValidationState(validationContext)"
                                    />
                                    <b-form-invalid-feedback>
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </validation-provider>
                            </b-form-group>
                        </div>
                    </b-col>
                </b-row>
                <hr>
                <h4>Account Details</h4>
                <hr>
                <b-row>
                    <b-col md="6">
                        <b-form-group
                            label="Account Group"
                            label-for="accountGroup"
                        >
                            <validation-provider
                                #default="validationContext"
                                name="Account Group"
                                rules="required"
                            >
                                <v-select
                                    id="accountGroup"
                                    v-model="formData.accountGroup"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="accountGroupOptions"
                                    label="label"
                                    value="value"
                                    :clearable="false"
                                    :reduce="val => val.value"
                                    :state="getValidationState(validationContext)"
                                />
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </validation-provider>
                        </b-form-group>
                        <b-form-group
                            label="Remarks"
                            label-for="remarks"
                        >
                            <validation-provider
                                #default="validationContext"
                                name="Remarks"
                                rules="min:5"
                            >
                                <b-form-textarea
                                    id="remarks"
                                    v-model="formData.remarks"
                                    :state="getValidationState(validationContext)"
                                    placeholder=""
                                    rows="3"
                                />
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </validation-provider>
                        </b-form-group>
                        <b-form-checkbox-group
                            :options="[{name: 'Is TDS A/c...?', item: 1}]"
                            value-field="item"
                            text-field="name"
                            disabled-field="notEnabled"
                            v-model="formData.isTdsAcc"
                            @change="showTds($event)"
                        />
                        <div id="tdsSection" v-if="tdsAccOptions">
                            <b-form-group
                                class="mt-1"
                                label="TDS Payment Type"
                                label-for="tdsPaymentType"
                            >
                                <validation-provider
                                    #default="validationContext"
                                    name="TDS Payment Type"
                                >
                                    <v-select
                                        id="tdsPaymentType"
                                        v-model="formData.tdsPaymentType"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="tdsOptions"
                                        label="label"
                                        value="value"
                                        :clearable="false"
                                        :reduce="val => val.value"
                                        :state="getValidationState(validationContext)"
                                    />
                                    <b-form-invalid-feedback>
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </validation-provider>
                            </b-form-group>
                        </div>
                        <b-form-checkbox-group
                            :options="[{name: 'Is Bank or Cash Book...?', item: 1}]"
                            value-field="item"
                            text-field="name"
                            disabled-field="notEnabled"
                            @change="showBankOrCashOptions($event)"
                            class="mt-1"
                            v-model="formData.isBankOrCash"
                        />
                        <div id="chequePrintOptionSection" v-if="chequePrintOption">
                            <b-form-group
                                class="mt-1"
                                label="Cheque Printing Format"
                                label-for="chequePrintFormat"
                            >
                                <validation-provider
                                    #default="validationContext"
                                    name="Cheque Printing Format"
                                >
                                    <v-select
                                        id="chequePrintFormat"
                                        v-model="formData.chequePrintingFormat"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="chequePrintFormatOption"
                                        label="label"
                                        value="value"
                                        :clearable="false"
                                        :reduce="val => val.value"
                                        :state="getValidationState(validationContext)"
                                    />
                                    <b-form-invalid-feedback>
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </validation-provider>
                            </b-form-group>
                        </div>
                    </b-col>
                    <b-col md="6">
                        <b-row>
                            <b-col md="6">
                                <b-form-checkbox-group
                                    :options="[{name: 'Is Fixed Assets...?', item: 1}]"
                                    value-field="item"
                                    text-field="name"
                                    disabled-field="notEnabled"
                                    class="mt-2"
                                    @change="showDepreciationDetails($event)"
                                    v-model="formData.isFixedAssets"
                                />
                            </b-col>
                            <b-col md="6">
                                <b-form-checkbox-group
                                    :options="[{name: 'Enable Cost Center', item: 1}]"
                                    value-field="item"
                                    text-field="name"
                                    disabled-field="notEnabled"
                                    class="mt-2"
                                    @change=""
                                    v-model="formData.isEnableCostCenter"
                                />
                            </b-col>
                        </b-row>
                        <div v-if="isFixedAssets">
                            <hr>
                            <h4>Depreciation Details</h4>
                            <hr>
                            <h4>Income Tax Act.</h4>
                            <hr>
                            <b-form-group
                                label="Rate Of Depreciation Annual"
                                label-for="rateOfDepreciationAnual"
                            >
                                <validation-provider
                                    #default="validationContext"
                                    name="Rate Of Depreciation Annual"
                                    rules=""
                                >
                                    <b-input-group
                                        append="%"
                                        class="input-group-merge"
                                    >
                                        <b-form-input
                                            id="rateOfDepreciationAnual"
                                            v-model="formData.rateOfDepreciationAnual"
                                            :state="getValidationState(validationContext)"
                                        />

                                    </b-input-group>
                                    <b-form-invalid-feedback>
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </validation-provider>
                            </b-form-group>
                            <b-form-group
                                label="Rate Of Depreciation Half Year"
                                label-for="rateOfDepreciationHalfYear"
                            >
                                <validation-provider
                                    #default="validationContext"
                                    name="Rate Of Depreciation Half Year"
                                    rules=""
                                >
                                    <b-input-group
                                        append="%"
                                        class="input-group-merge"
                                    >
                                        <b-form-input
                                            id="rateOfDepreciationHalfYear"
                                            v-model="formData.rateOfDepreciationHalfYear"
                                            :state="getValidationState(validationContext)"
                                        />
                                    </b-input-group>
                                    <b-form-invalid-feedback>
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </validation-provider>
                            </b-form-group>
                            <b-form-group
                                label="Op. Bal."
                                label-for="opBal"
                            >
                                <validation-provider
                                    #default="validationContext"
                                    name="Op. Bal."
                                    rules=""
                                >
                                    <b-form-input
                                        id="opBal"
                                        v-model="formData.opBal"
                                        :state="getValidationState(validationContext)"
                                    />
                                    <b-form-invalid-feedback>
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </validation-provider>
                            </b-form-group>
                            <hr>
                            <h4>Companies Act.</h4>
                            <hr>
                            <b-form-group
                                label="Rate Of Depreciation"
                                label-for="rateOfDepreciation"
                            >
                                <validation-provider
                                    #default="validationContext"
                                    name="Rate Of Depreciation"
                                    rules=""
                                >
                                    <b-input-group
                                        append="%"
                                        class="input-group-merge"
                                    >
                                        <b-form-input
                                            id="rateOfDepreciation"
                                            v-model="formData.rateOfDepreciation"
                                            :state="getValidationState(validationContext)"
                                        />
                                    </b-input-group>
                                    <b-form-invalid-feedback>
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </validation-provider>
                            </b-form-group>
                        </div>
                    </b-col>
                </b-row>
                <hr>
                <h4>Other Details</h4>
                <hr>
                <b-row>
                    <b-col md="6">
                        <validation-provider
                            #default="validationContext"
                            name="District"
                            rules=""
                        >
                            <b-form-group
                                label="District"
                                label-for="city"
                                :state="getValidationState(validationContext)"
                            >
                                <v-select
                                    v-model="formData.city"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="cityChangeOptions"
                                    :reduce="val => val.value"
                                    :clearable="false"
                                    input-id="city"
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
                            rules=""
                        >
                            <b-form-group
                                label="State"
                                label-for="state"
                                :state="getValidationState(validationContext)"
                            >
                                <v-select
                                    v-model="formData.state"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="stateChangeOptions"
                                    :reduce="val => val.value"
                                    :clearable="false"
                                    input-id="state"
                                />
                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                        <validation-provider
                            #default="validationContext"
                            name="Country"
                            rules=""
                        >
                            <b-form-group
                                label="Country"
                                label-for="country"
                                :state="getValidationState(validationContext)"
                            >
                                <v-select
                                    v-model="formData.country"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="countryOption"
                                    :reduce="val => val.value"
                                    :clearable="false"
                                    input-id="country"
                                />
                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                        <b-form-group
                            label="Address"
                            label-for="address"
                        >
                            <validation-provider
                                #default="validationContext"
                                name="Address"
                                rules=""
                            >
                                <b-form-textarea
                                    id="address"
                                    v-model="formData.address"
                                    :state="getValidationState(validationContext)"
                                    placeholder=""
                                    rows="3"
                                />
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </validation-provider>
                        </b-form-group>
                        <b-form-group
                            label="Phone No."
                            label-for="phoneNo"
                        >
                            <validation-provider
                                #default="validationContext"
                                name="Phone No."
                                rules=""
                            >
                                <b-input-group>
                                    <b-input-group-prepend>
                                        <b-form-input
                                            id="stdCode"
                                            placeholder="STD code"
                                            type="number"
                                            v-model="formData.PhoneCountry"
                                        />
                                    </b-input-group-prepend>
                                    <b-form-input
                                        id="party-phone"
                                        placeholder="Party Phone"
                                        v-model="formData.phoneNo"
                                    />
                                </b-input-group>
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </validation-provider>
                        </b-form-group>
                        <b-form-group
                            label="Email ID"
                            label-for="email"
                        >
                            <validation-provider
                                #default="validationContext"
                                name="Email ID"
                                rules=""
                            >
                                <b-form-input
                                    id="email"
                                    v-model="formData.email"
                                    :state="getValidationState(validationContext)"
                                />
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </validation-provider>
                        </b-form-group>
                        <b-form-group
                            label="Web Site"
                            label-for="webSite"
                        >
                            <validation-provider
                                #default="validationContext"
                                name="Web Site"
                                rules=""
                            >
                                <b-form-input
                                    id="webSite"
                                    v-model="formData.webSite"
                                    :state="getValidationState(validationContext)"
                                />
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </validation-provider>
                        </b-form-group>
                        <b-form-group
                            label="GSTIN"
                            label-for="gstin"
                        >
                            <validation-provider
                                #default="validationContext"
                                name="GSTIN"
                                rules=""
                            >
                                <b-form-input
                                    id="gstin"
                                    v-model="formData.gstin"
                                    :state="getValidationState(validationContext)"
                                />
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </validation-provider>
                        </b-form-group>
                        <validation-provider
                            #default="validationContext"
                            name="HSA/SAC"
                            rules=""
                        >
                            <b-form-group
                                label="HSA/SAC"
                                label-for="hsaSac"
                                :state="getValidationState(validationContext)"
                            >
                                <v-select
                                    v-model="formData.hsaSac"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="hsaSacOption"
                                    :reduce="val => val.value"
                                    :clearable="false"
                                    input-id="hsaSac"
                                />
                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                        <b-form-group
                            label="HSN/SAC No."
                            label-for="hsnSacNo"
                        >
                            <validation-provider
                                #default="validationContext"
                                name="HSN/SAC No."
                                rules=""
                            >
                                <b-form-input
                                    id="hsnSacNo"
                                    v-model="formData.hsaSacNo"
                                    :state="getValidationState(validationContext)"
                                />
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </validation-provider>
                        </b-form-group>
                        <validation-provider
                            #default="validationContext"
                            name="GST Cal Code"
                            rules=""
                        >
                            <b-form-group
                                label="GST Cal Code"
                                label-for="gstCalCode"
                                :state="getValidationState(validationContext)"
                            >
                                <v-select
                                    v-model="formData.gstCalCode"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="gstCalCodeOption"
                                    :reduce="val => val.value"
                                    :clearable="false"
                                    input-id="gstCalCode"
                                />
                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                    </b-col>
                </b-row>
                <!-- Form Actions -->
                <hr>
                <div class="float-right">
                    <b-button
                        v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                        variant="primary"
                        class="mr-1"
                        type="submit"
                    >
                        Save
                    </b-button>
                    <b-button
                        v-ripple.400="'rgba(186, 191, 199, 0.15)'"
                        type="button"
                        variant="outline-secondary"
                    >
                        Cancel
                    </b-button>
                </div>
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
        BFormInvalidFeedback,
        BFormCheckboxGroup,
        BInputGroup,
        BInputGroupPrepend
    } from 'bootstrap-vue'
    import {required} from '@validations'
    import formValidation from '@core/comp-functions/forms/form-validation'
    import Ripple from 'vue-ripple-directive'
    import vSelect from 'vue-select'
    import store from '@/store'
    import Toastification from '@core/components/toastification/ToastificationContent.vue'
    import {ref, onUnmounted} from '@vue/composition-api'
    import financeMasterStoreModule from "../financeMasterStoreModule"
    import router from '@/router'

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
            BFormInvalidFeedback,
            BFormCheckboxGroup,
            BInputGroup,
            vSelect,
            BInputGroupPrepend
        },
        directives: {
            Ripple,
        },
        data(){
            return {
                options: [
                    {title: 'cr', value: 0},
                    {title: 'dr', value: 1}
                ],
                accountGroupOptions : [],
                tdsOptions : [],
                chequePrintFormatOption : [],
                countryOption : [],
                stateChangeOptions : [],
                cityChangeOptions : [],
                hsaSacOption : [],
                gstCalCodeOption : [
                    {label : 'test', value: '01'}
                ],
                tdsAccOptions: false,
                chequePrintOption: false,
                secondOpBalBookOption: false,
                isFixedAssets: false,
            }
        },
        setup() {
            const COACC_APP_STORE_MODULE_NAME = 'master-add'
            // Register module
            if (!store.hasModule(COACC_APP_STORE_MODULE_NAME)) store.registerModule(COACC_APP_STORE_MODULE_NAME, financeMasterStoreModule)
            // UnRegister on leave
            onUnmounted(() => {
                if (store.hasModule(COACC_APP_STORE_MODULE_NAME)) store.unregisterModule(COACC_APP_STORE_MODULE_NAME)
            })

            const blankFormData = {
                id: '',
                accountNo: '',
                accountName: '',
                opBalBook: '',
                opBalBook1: '',
                opBalBookOption: 'cr',
                opBalBookOption1: 'cr',
                accountGroup: '',
                remarks: '',
                isTdsAcc: [],
                tdsPaymentType: '',
                isBankOrCash: [],
                chequePrintingFormat: '',
                rateOfDepreciationAnual: '',
                rateOfDepreciationHalfYear: '',
                rateOfDepreciation: '',
                opBal: '',
                country: '',
                state: '',
                city: '',
                address: '',
                PhoneCountry:'',
                phoneNo: '',
                email: '',
                webSite: '',
                gstin: '',
                hsaSac: '',
                hsaSacNo: '',
                gstCalCode: '',
                isFixedAssets: [],
                isEnableCostCenter: [],
            }

            const formData = ref(JSON.parse(JSON.stringify(blankFormData)))

            const resetGroupData = () => {
                formData.value = JSON.parse(JSON.stringify(blankFormData))
            }

            store.dispatch('master-add/fetchGeneralLedgerMaster', {id: router.currentRoute.params.id})
                .then(response => {
                    formData.value = response.data.data
                    formData.value.id = response.data.data._id
                    delete formData.value._id
                })

            const { refFormObserver, getValidationState, resetForm } = formValidation(resetGroupData)

            return {
                formData,

                refFormObserver,
                getValidationState,
                resetForm,
                resetGroupData,
            }
        },
        created() {
            this.$http.get('/api/get-accounts-options').then(res => {
                this.accountGroupOptions = res.data.data
            })
            this.$http.get('/api/get-tds-options').then(res => {
                this.tdsOptions = res.data.data
            })
            this.$http.get('/api/cheque-printing-format-lists').then(res => {
                this.chequePrintFormatOption = res.data.data
            })
            this.$http.get('/api/get-country-options').then(res => {
                this.countryOption = res.data.data
            })
            this.$http.get('/api/get-state-options').then(res => {
                this.stateChangeOptions = res.data.data
            })
            this.$http.get('/api/get-city-options').then(res => {
                this.cityChangeOptions = res.data.data
            })
            this.$http.get('/api/get-item-hsn-sac-code-options').then(res => {
                this.hsaSacOption = res.data.data
            })
            this.$store.dispatch('master-add/fetchGeneralLedgerMaster', {id: router.currentRoute.params.id})
                .then(response => {
                    if (response.data.data.isBankOrCash[0] == 1){
                        this.chequePrintOption = true
                        this.secondOpBalBookOption = true
                    }
                    if (response.data.data.isFixedAssets[0] === 1){
                        this.isFixedAssets = true
                    }
                    if (response.data.data.isTdsAcc[0] === 1){
                        this.tdsAccOptions = true
                    }
                })
        },
        methods: {
            showTds(){
                this.tdsAccOptions = !this.tdsAccOptions
            },
            showBankOrCashOptions(){
                this.chequePrintOption = !this.chequePrintOption
                this.secondOpBalBookOption = !this.secondOpBalBookOption
            },
            showDepreciationDetails(){
                this.isFixedAssets = !this.isFixedAssets
            },

            async getCityDetails(id) {
                await this.$http.get(`/api/city-master/${id}`).then((res) => {
                    this.formData.state = res.data.data.state
                    this.formData.country = res.data.data.country
                });
            },

            submitFormData() {
                this.$store.dispatch('master-add/updateGeneralLedgerMaster',this.formData).then(response => {
                    this.$toast({
                        component: Toastification,
                        position: 'top-right',
                        props: {
                            title: 'General Ledger Updated',
                            icon: 'CheckSquareIcon',
                            variant: 'success',
                            text: `You have successfully Updated General Ledger : ${this.formData.accountName}.`,
                        },
                    })
                    this.$router.push('/finance/finance-master/general-ledger-accounts')
                })
            }
        }
    }
</script>
