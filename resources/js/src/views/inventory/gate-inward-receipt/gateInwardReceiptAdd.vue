<template>
    <div>
        <b-card-code>
            <validation-observer #default="{handleSubmit}">
                <b-form @submit.prevent="handleSubmit(saveFormData)">
                    <b-row>
                        <b-col md="6">
                            <b-row>
                                <b-col md="6">
                                    <validation-provider
                                        #default="validationContext"
                                        name="GIR No"
                                        rules=""
                                    >
                                        <b-form-group
                                            label="GIR No"
                                            label-for="girNo"
                                        >
                                            <b-form-input
                                                v-model="formData.girNo"
                                                id="girNo"
                                                :state="getValidationState(validationContext)"
                                                readonly
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
                                        name="GIR No"
                                        rules="required"
                                    >
                                        <b-form-group
                                            label="GIR Date"
                                            label-for="girDate"
                                        >
                                            <b-input-group>
                                                <cleave
                                                    id="girDate"
                                                    v-model="formData.girDate"
                                                    class="form-control"
                                                    :raw="false"
                                                    :options="dateFormat"
                                                    placeholder="DD/MM/YYYY"
                                                    show-decade-nav
                                                />
                                                <b-input-group-append>
                                                    <b-form-datepicker
                                                        v-model="formatDates.girDate"
                                                        button-only
                                                        @input="getGirFormateDate($event)"
                                                        show-decade-nav
                                                        size="sm"
                                                        nav-button-variant="primary"
                                                    />
                                                </b-input-group-append>
                                            </b-input-group>
                                            <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                                {{ validationContext.errors[0] }}
                                            </b-form-invalid-feedback>
                                        </b-form-group>
                                    </validation-provider>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col md="6">
                                    <validation-provider
                                        #default="validationContext"
                                        name="Party Code"
                                        rules=""
                                    >
                                        <b-form-group
                                            label="Party Code"
                                            label-for="partyCode"
                                        >
                                            <v-select
                                                placeholder="Select Code"
                                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                                :options="partyCodeOptions"
                                                :reduce="val => val.value"
                                                :clearable="false"
                                                input-id="partyCode"
                                                @input="getPartyDetail($event)"
                                                v-model="formData.purchaseOrderId"
                                                :state="getValidationState(validationContext)"
                                            />
                                        </b-form-group>
                                        <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                            {{validationContext.errors [0]}}
                                        </b-form-invalid-feedback>
                                    </validation-provider>
                                </b-col>
                                <b-col md="6">
                                    <validation-provider
                                        #default="validationContext"
                                        name="Party Name"
                                        rules=""
                                    >
                                        <b-form-group
                                            label="Party Name"
                                            label-for="partyName"
                                        >
                                            <b-form-input
                                                id="partyName"
                                                :state="getValidationState(validationContext)"
                                                v-model="formData.partyName"
                                            />
                                        </b-form-group>
                                        <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                            {{ validationContext.errors[0] }}
                                        </b-form-invalid-feedback>
                                    </validation-provider>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col md="6">
                                    <validation-provider
                                        #default="validationContext"
                                        name="Type"
                                        rules="required"
                                    >
                                        <b-form-group
                                            label="Type"
                                            label-for="type"
                                        >
                                            <v-select
                                                v-model="formData.poJobtype"
                                                placeholder="Select Type"
                                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                                :options="typeOPtion"
                                                :reduce="val => val.value"
                                                :clearable="false"
                                                input-id="type"
                                                @input="clearFormData"
                                                :state="getValidationState(validationContext)"
                                            />
                                            <b-form-invalid-feedback>
                                                {{ validationContext.errors[0] }}
                                            </b-form-invalid-feedback>
                                        </b-form-group>
                                    </validation-provider>
                                </b-col>
                                <b-col md="6">
                                    <div v-if="formData.poJobtype === 1">
                                        <validation-provider
                                            #default="validationContext"
                                            name="Purchase Order No."
                                            rules=""
                                        >
                                            <b-form-group
                                                label="Purchase Order No."
                                                label-for="poNo"
                                            >
                                                <b-input-group class="d-flex">
                                                    <b-form-input
                                                        v-model="formData.poNo"
                                                        :state="getValidationState(validationContext)"
                                                        id="poNo"
                                                    />
                                                    <b-input-group-append>
                                                        <b-button variant="primary" @click="openModal">...</b-button>
                                                    </b-input-group-append>
                                                </b-input-group>
                                                <b-form-invalid-feedback>
                                                    {{ validationContext.errors[0] }}
                                                </b-form-invalid-feedback>
                                            </b-form-group>
                                        </validation-provider>
                                    </div>
                                    <div v-if="formData.poJobtype === 2">
                                        <validation-provider
                                            #default="validationContext"
                                            name="Job Work No."
                                            rules=""
                                        >
                                            <b-form-group
                                                label="Job Work No."
                                                label-for="jwNo"
                                            >
                                                <b-input-group class="d-flex">
                                                    <b-form-input
                                                        v-model="formData.jwNo"
                                                        :state="getValidationState(validationContext)"
                                                        id="jwNo"
                                                    />
                                                    <b-input-group-append>
                                                        <b-button variant="primary" @click="openModal">...</b-button>
                                                    </b-input-group-append>
                                                </b-input-group>
                                                <b-form-invalid-feedback>
                                                    {{ validationContext.errors[0] }}
                                                </b-form-invalid-feedback>
                                            </b-form-group>
                                        </validation-provider>
                                    </div>
                                    <div v-if="formData.poJobtype === 3">
                                        <validation-provider
                                            #default="validationContext"
                                            name="Purchase Order No."
                                            rules=""
                                        >
                                            <b-form-group
                                                label="Purchase Order No."
                                                label-for="poNo"
                                            >
                                                <b-input-group class="d-flex">
                                                    <b-form-input
                                                        v-model="formData.manualPoNo"
                                                        :state="getValidationState(validationContext)"
                                                        id="manualPoNo"
                                                    />
                                                </b-input-group>
                                                <b-form-invalid-feedback>
                                                    {{ validationContext.errors[0] }}
                                                </b-form-invalid-feedback>
                                            </b-form-group>
                                        </validation-provider>
                                    </div>
                                </b-col>
                            </b-row>
                            <b-form-group
                                label="Date"
                                label-for="poJobDate"
                            >
                                <b-input-group>
                                    <cleave
                                        id="poJobDate"
                                        v-model="formData.poJobDate"
                                        class="form-control"
                                        :raw="false"
                                        :options="dateFormat"
                                        placeholder="DD/MM/YYYY"
                                        show-decade-nav
                                    />
                                    <b-input-group-append>
                                        <b-form-datepicker
                                            v-model="formatDates.poJobDate"
                                            button-only
                                            @input="getPoJobFormateDate($event)"
                                            show-decade-nav
                                            size="sm"
                                            nav-button-variant="primary"
                                        />
                                    </b-input-group-append>
                                </b-input-group>
                            </b-form-group>
                            <b-row>
                                <b-col md="6">
                                    <validation-provider
                                        #default="validationContext"
                                        name="Invoice No."
                                        rules="required"
                                    >
                                        <b-form-group
                                            label="Invoice No."
                                            label-for="invoiceNo"
                                        >
                                            <b-form-input
                                                v-model="formData.invoiceNo"
                                                id="invoiceNo"
                                                :state="getValidationState(validationContext)"
                                            />
                                            <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                                {{ validationContext.errors[0] }}
                                            </b-form-invalid-feedback>
                                        </b-form-group>
                                    </validation-provider>
                                </b-col>
                                <b-col md="6">
                                    <b-form-group
                                        label="Invoice Date"
                                        label-for="invoiceDate"
                                    >
                                        <b-input-group>
                                            <cleave
                                                id="invoiceDate"
                                                v-model="formData.invoiceDate"
                                                class="form-control"
                                                :raw="false"
                                                :options="dateFormat"
                                                placeholder="DD/MM/YYYY"
                                                show-decade-nav
                                            />
                                            <b-input-group-append>
                                                <b-form-datepicker
                                                    v-model="formatDates.invoiceDate"
                                                    button-only
                                                    @input="getInvoiceFormateDate($event)"
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
                                    <validation-provider
                                        #default="validationContext"
                                        name="Challan No."
                                        rules="required"
                                    >
                                    <b-form-group
                                        label="Challan No."
                                        label-for="challanNo"
                                        :state="getValidationState(validationContext)"
                                    >
                                        <b-form-input
                                            v-model="formData.challanNo"
                                            id="challanNo"
                                            :state="getValidationState(validationContext)"
                                        />
                                        <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                            {{ validationContext.errors[0] }}
                                        </b-form-invalid-feedback>
                                    </b-form-group>
                                    </validation-provider>
                                </b-col>
                                <b-col md="6">
                                    <b-form-group
                                        label="Challan Date"
                                        label-for="challanDate"
                                    >
                                        <b-input-group>
                                            <cleave
                                                id="challanDate"
                                                v-model="formData.challanDate"
                                                class="form-control"
                                                :raw="false"
                                                :options="dateFormat"
                                                placeholder="DD/MM/YYYY"
                                                show-decade-nav
                                            />
                                            <b-input-group-append>
                                                <b-form-datepicker
                                                    v-model="formatDates.challanDate"
                                                    button-only
                                                    @input="getChallanFormateDate($event)"
                                                    show-decade-nav
                                                    size="sm"
                                                    nav-button-variant="primary"
                                                />
                                            </b-input-group-append>
                                        </b-input-group>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-form-group
                                label="Remark"
                                label-for="remark"
                            >
                                <b-form-textarea
                                    v-model="formData.remark"
                                    id="remark"
                                    rows="2"
                                />
                            </b-form-group>
                        </b-col>
                        <b-col md="6">
                            <b-form-group
                                label="Address"
                                label-for="contractorAddress"
                            >
                                <b-form-textarea
                                    id="address"
                                    v-model="formData.partyAddress"
                                    rows="2"
                                />
                            </b-form-group>
                            <b-form-group
                                label="City"
                                label-for="partyCity"
                            >
                                <v-select
                                    placeholder="Select City"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="cityOptions"
                                    :reduce="val => val.value"
                                    :clearable="false"
                                    input-id="partyCity"
                                    v-model="formData.partyCity"
                                    @input="getCityDetails($event)"
                                />
                            </b-form-group>
                            <b-form-group
                                label="State"
                                label-for="partyState"
                            >
                                <v-select
                                    placeholder="Select State"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="stateOptions"
                                    :reduce="val => val.value"
                                    :clearable="false"
                                    input-id="partyState"
                                    v-model="formData.partyState"
                                />
                            </b-form-group>
                            <b-form-group
                                label="Country"
                                label-for="partyCountry"
                            >
                                <v-select
                                    placeholder="Select Country"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="countryOptions"
                                    :reduce="val => val.value"
                                    :clearable="false"
                                    input-id="partyCountry"
                                    v-model="formData.partyCountry"
                                />
                            </b-form-group>
                            <b-form-group
                                label="Phone No."
                                label-for="work-phone"
                            >
                                <b-input-group>
                                    <b-input-group-prepend>
                                        <b-form-input
                                            v-model="formData.partyPhoneCountry"
                                        />
                                    </b-input-group-prepend>
                                    <b-form-input
                                        id="work-phone"
                                        placeholder="Party Phone"
                                        v-model="formData.partyPhoneNo"
                                    />
                                </b-input-group>
                            </b-form-group>
                            <b-row>
                                <b-col md="6">
                                    <b-form-group
                                        label="Pin-Code"
                                        label-for="partyPinCode"
                                    >
                                        <b-form-input
                                            id="partyPinCode"
                                            v-model="formData.partyPinCode"
                                        />
                                    </b-form-group>
                                </b-col>
                                <b-col md="6">
                                    <b-form-group
                                        label="Fax No."
                                        label-for="partyFaxNo"
                                    >
                                        <b-form-input
                                            id="faxNo"
                                            v-model="formData.partyFaxNo"
                                        />
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-form-group
                                label="E-mail ID"
                                label-for="partyEmailId"
                            >
                                <b-form-input
                                    id="emailId"
                                    v-model="formData.partyEmailId"
                                />
                            </b-form-group>
                            <b-form-group
                                label="Website"
                                label-for="partyWebsite"
                            >
                                <b-form-input
                                    id="website"
                                    v-model="formData.partyWebsite"
                                />
                            </b-form-group>
                        </b-col>
                        <!--Button-->
                        <b-col md="12">
                            <hr>
                            <b-button
                                variant="primary"
                                type="submit"
                                class="float-right"
                            >
                                Save
                            </b-button>
                        </b-col>
                    </b-row>
                </b-form>
            </validation-observer>
        </b-card-code>
        <!--modal-->
        <b-modal
            id="purchaseOrderModal"
            title="Select PO Detail"
            ref="purchaseOrderModal"
            ok-title="submit"
            cancel-variant="danger"
            size="lg"
            no-close-on-backdrop
        >
            <b-table
                :fields="modalTableData.purchaseOrderFields"
                :items="modalTableData.purchaseOrderData"
                :no-border-collapse="false"
                responsive
                bordered
                hover
                ok-title="submit"
                cancel-variant="danger"
                size="lg"
                no-close-on-backdrop
                show-empty
                :busy="isModalTableBusy"
            >
                <!-- Loader -->
                <template #table-busy>
                    <div class="text-center my-2">
                        <b-spinner class="align-middle"></b-spinner>
                        <strong>Loading...</strong>
                    </div>
                </template>
                <!-- Index -->
                <template #cell(srNo)="data">
                    {{ data.index + 1 }}
                </template>
                <!-- Empty Text -->
                <template #empty="scope">
                    <h5 class="text-center text-uppercase">No Items Available</h5>
                </template>
                <template #cell(selectButton)="data">
                    <b-button
                        type="button"
                        size="sm"
                        variant="primary"
                        @click="getPurchaseOrderDetails(data.item)"
                    >
                        Select

                    </b-button>
                </template>
            </b-table>
        </b-modal>
        <!--        2 modal-->
        <!--modal-->
        <b-modal
            id="jobWorkModal"
            title="Select Job Work Detail"
            ref="jobWorkModal"
            ok-title="submit"
            cancel-variant="danger"
            size="lg"
            no-close-on-backdrop
        >
            <b-table
                :fields="modalTablesData.jobWorkFields"
                :items="modalTablesData.jobWorkData"
                :no-border-collapse="false"
                responsive
                bordered
                hover
                ok-title="submit"
                cancel-variant="danger"
                size="lg"
                no-close-on-backdrop
                show-empty
                :busy="isModalTableBusy"
            >
                <!-- Loader -->
                <template #table-busy>
                    <div class="text-center my-2">
                        <b-spinner class="align-middle"></b-spinner>
                        <strong>Loading...</strong>
                    </div>
                </template>
                <!-- Index -->
                <template #cell(srNo)="data">
                    {{ data.index + 1 }}
                </template>
                <!-- Empty Text -->
                <template #empty="scope">
                    <h5 class="text-center text-uppercase">No Items Available</h5>
                </template>
                <template #cell(selectButton)="data">
                    <b-button
                        type="button"
                        size="sm"
                        variant="primary"
                        @click="getJobWorkDetails(data.item)"
                    >
                        Select

                    </b-button>
                </template>

            </b-table>
        </b-modal>
    </div>
</template>
<script>
    import {
        BFormGroup,
        BRow,
        BCol,
        BFormInput,
        BForm,
        BFormInvalidFeedback,
        BInputGroup,
        BInputGroupAppend,
        BFormDatepicker,
        BButton,
        BFormTextarea,
        BInputGroupPrepend,
        BTable
    } from 'bootstrap-vue'
    import {ValidationObserver, ValidationProvider} from 'vee-validate'
    import BCardCode from '../../../@core/components/b-card-code/BCardCode'
    import {required} from '@validations'
    import {computed, onUnmounted, ref} from '@vue/composition-api'
    import formValidation from "@core/comp-functions/forms/form-validation";
    import {forMatIndianDate, getTcTodayDate} from "../../../@core/utils/utils";
    import Cleave from 'vue-cleave-component'
    import vSelect from 'vue-select'
    import axios from '@axios'
    import countryCode from '@/@fake-db/data/other/country-code'
    import router from '@/router'
    import {getUserData} from "../../../auth/utils";
    import moment from "moment";
    import inventoryStoreModule from "../inventoryStoreModule";
    import {useToast} from "vue-toastification/composition";
    import store from '@/store'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'


    export default {
        components: {
            BCardCode,
            BFormGroup,
            BRow,
            BCol,
            BFormInput,
            BForm,
            ValidationProvider,
            ValidationObserver,
            BFormInvalidFeedback,
            Cleave,
            BInputGroup,
            BInputGroupAppend,
            BFormDatepicker,
            BButton,
            vSelect,
            BFormTextarea,
            BInputGroupPrepend,
            BTable
        },
        computed: {
            countryCode: () => countryCode
        },
        setup({purchaseOrderModal}, {jobWorkModal}) {
            purchaseOrderModal = ref()
            jobWorkModal = ref()
            const isModalTableBusy = ref(false)
            const toast = useToast()

            const ITEMADDON_APP_STORE_MODULE_NAME = 'inventory-store-module'
            if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, inventoryStoreModule)
            onUnmounted(() => {
                if (store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.unregisterModule(ITEMADDON_APP_STORE_MODULE_NAME)
            })

            const getCityDetails = async (id) => {
                await axios.get(`/api/city-master/${id}`).then(res => {
                    formData.value.partyState = res.data.data.state
                    formData.value.partyCountry = res.data.data.country
                });
            }

            const modalTableData = ref({
                purchaseOrderFields: [
                    {
                        key: 'selectButton',
                        label: ''
                    },
                    {
                        key: 'poNumber',
                        label: 'PO No'
                    },
                    {
                        key: 'poDate',
                        label: 'PO Date'
                    },
                ],
                purchaseOrderData: [],
            })
            const modalTablesData = ref({
                jobWorkFields: [
                    {
                        key: 'selectButton',
                        label: ''
                    },
                    {
                        key: 'jobWorkNo',
                        label: 'Job Work No'
                    },
                    {
                        key: 'jobWorkDate',
                        label: 'Job Work Date'
                    },
                ],
                jobWorkData: [],
            })

            const partyCodeOptions = ref([])
            axios.get('/api/new/get-purchase-order-vendor-options').then(res => {
                partyCodeOptions.value = res.data.data
            })


            const typeOPtion = ref([
                {label: 'Purchase Order', value: 1},
                {label: 'Job Work Order', value: 2},
                {label: 'Manual', value: 3},
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

            const dateFormat = ref({
                date: true,
                delimiter: '/',
                datePattern: ['d', 'm', 'Y'],
            })

            const formatDates = ref({
                girDate: null,
                poJobDate: null,
                invoiceDate: null,
                challanDate: null,
            })

            const getGirFormateDate = (date) => {
                formData.value.girDate = forMatIndianDate(date)
            }
            const getPoJobFormateDate = (date) => {
                formData.value.poJobDate = forMatIndianDate(date)
            }
            const getInvoiceFormateDate = (date) => {
                formData.value.invoiceDate = forMatIndianDate(date)
            }
            const getChallanFormateDate = (date) => {
                formData.value.challanDate = forMatIndianDate(date)
            }

            const getPurchaseOrderItem = async () => {
                await axios.get(`/api/get-purchase-order-by-party/${formData.value.partyId}`).then((res) => {
                    modalTableData.value.purchaseOrderData = res.data.data
                });
            };

            const getJobWorkItem = async () => {
                await axios.get(`/api/get-job-work-no-by-party/${formData.value.partyId}`).then((res) => {
                    modalTablesData.value.jobWorkData = res.data.data
                });
            };
            const openModal = async () => {
                switch (formData.value.poJobtype) {
                    case 2:
                        await getJobWorkItem();
                        return jobWorkModal.value.show();
                    default:
                        await getPurchaseOrderItem();
                        return purchaseOrderModal.value.show();
                }
            }

            const getPurchaseOrderDetails = async (data) => {
                formData.value.purchaseOrderId = data.poVendorId
                formData.value.poNo = data.poNumber
                formData.value.poJobDate = data.poDate
                purchaseOrderModal.value.hide();
            }
            const getJobWorkDetails = async (data) => {
                formData.value.partyId = data.subContractorId
                formData.value.jwNo = data.jobWorkNo
                formData.value.poJobDate = data.jobWorkDate
                jobWorkModal.value.hide();
            }

            const CurrentUserData = ref(getUserData())

            const blankFormData = {
                purchaseOrderId:null,
                partyId:null,
                girNo: null,
                girDate: forMatIndianDate(getTcTodayDate()),
                partyCode: null,
                partyName: null,
                poNo: null,
                jwNo: null,
                manualPoNo:null,
                poJobtype: 1,
                poJobDate: forMatIndianDate(getTcTodayDate()),
                invoiceNo: null,
                invoiceDate: forMatIndianDate(getTcTodayDate()),
                challanNo: null,
                challanDate: forMatIndianDate(getTcTodayDate()),
                remark: null,
                partyAddress: null,
                partyCountry: null,
                partyState: null,
                partyCity: null,
                partyFaxNo: null,
                partyEmailId: null,
                partyPinCode: null,
                partyPhoneCountry: '+91',
                partyPhoneNo: null,
                partyWebsite: null,
                loginDetails: {
                    createdBy: CurrentUserData.value.first_name + ' ' + CurrentUserData.value.last_name,
                    dateTime: moment(new Date()).format('DD/MM/YYYY HH:mm'),
                    lastModifiedBy: CurrentUserData.value.first_name + ' ' + CurrentUserData.value.last_name,
                    modifiedDateTime: moment(new Date()).format('DD/MM/YYYY HH:mm'),
                    approvedBy: null,
                    approveDate: null,
                },
            }
            const formData = ref(JSON.parse(JSON.stringify(blankFormData)))
            const resetFormData = () => {
                formData.value = JSON.parse(JSON.stringify(blankFormData))
            }
            const clearFormData = () => {
                formData.value.poNo = null
                formData.value.jwNo = null
            }
            const partyId = ref(null)

            const getPartyDetail = async (id) => {
                partyId.value = null
                await axios.get(`/api/purchase-order/${id}`).then(res => {
                    formData.value.poJobDate = res.data.data?.poDate
                    formData.value.partyName = res.data.data?.vendorDetails?.vendorName
                    formData.value.partyAddress = res.data.data?.vendorDetails?.vendorAddress
                    formData.value.partyCountry = res.data.data?.vendorDetails?.vendorCountry
                    formData.value.partyState = res.data.data?.vendorDetails?.vendorState
                    formData.value.partyCity = res.data.data?.vendorDetails?.vendorCity
                    formData.value.partyFaxNo = res.data.data?.vendorDetails?.vendorFaxNo
                    formData.value.partyEmailId = res.data.data?.vendorDetails?.vendorEmailId
                    formData.value.partyPhoneCountry = res.data.data?.vendorDetails?.vendorPhoneCountry
                    formData.value.partyPinCode = res.data.data?.vendorDetails?.vendorPinCode
                    formData.value.partyPhoneNo = res.data.data?.vendorDetails?.vendorPhoneNo
                    formData.value.partyWebsite = res.data.data?.vendorDetails?.vendorWebSite
                    formData.value.purchaseOrderId = res.data.data?._id
                    // formData.value.partyId = res.data.data?.
                    formData.value.partyId = res.data.data?.party_details?._id ?? null
                    formData.value.partyCode = res.data.data?.party_details?.partyCode ?? null

                })
                partyId.value = id

            }

            const saveFormData = async () => {
                await store.dispatch('inventory-store-module/addGateInwardReceipt', formData.value).then(res => {
                    if (res.status === 200) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Gate Inward Receipt Added',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: `You have successfully Added Gate Inward Receipt.`,
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
                        name: 'edit-gate-inward-receipt',
                        params: {
                            id: res.data.data._id
                        }
                    })
                })
            }
            const {refFormObserver, resetForm, getValidationState} = formValidation(resetFormData)
            return {
                refFormObserver,
                getValidationState,
                resetForm,
                resetFormData,
                formData,
                required,
                dateFormat,
                formatDates,
                getGirFormateDate,
                openModal,
                typeOPtion,
                getPoJobFormateDate,
                partyCodeOptions,
                getPartyDetail,
                getInvoiceFormateDate,
                getChallanFormateDate,
                countryOptions,
                stateOptions,
                cityOptions,
                saveFormData,
                purchaseOrderModal,
                isModalTableBusy,
                modalTableData,
                getPurchaseOrderDetails,
                jobWorkModal,
                getJobWorkDetails,
                modalTablesData,
                getPurchaseOrderItem,
                getJobWorkItem,
                getCityDetails,
                clearFormData
            }
        }
    }

</script>
