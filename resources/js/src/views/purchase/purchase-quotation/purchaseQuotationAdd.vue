<template>
    <div>
        <b-card-code>
            <validation-observer #default="{ handleSubmit }">
                <b-form @submit.prevent="handleSubmit(saveFormData)">
                    <b-row>
                        <b-col md="6">
                            <b-row>
                                <b-col md="6">
                                    <validation-provider
                                        #default="validationContext"
                                        name="Ref No."
                                        rules="required"
                                    >
                                        <b-form-group
                                            label="Ref No."
                                            label-for="refNo"
                                        >
                                            <b-input-group>
                                                <b-form-input
                                                    id="refNo"
                                                    :state="getValidationState(validationContext)"
                                                    v-model="formData.referenceNumber"
                                                />
                                                <b-input-group-append>
                                                    <b-button variant="primary" @click="openModal">...</b-button>
                                                </b-input-group-append>
                                            </b-input-group>
                                            <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                                {{ validationContext.errors[0] }}
                                            </b-form-invalid-feedback>
                                        </b-form-group>
                                    </validation-provider>
                                </b-col>
                                <b-col md="6">
                                    <validation-provider
                                        #default="validationContext"
                                        name="Ref.Date"
                                        rules="required"
                                    >
                                        <b-form-group
                                            label="Ref. Date"
                                            label-for="refDate"
                                            :state="getValidationState(validationContext)"
                                        >
                                            <b-input-group>
                                                <cleave
                                                    id="referenceDate"
                                                    v-model="formData.referenceDate"
                                                    class="form-control"
                                                    :raw="false"
                                                    :options="dateFormat"
                                                    placeholder="DD/MM/YYYY"
                                                    show-decade-nav
                                                />
                                                <b-input-group-append>
                                                    <b-form-datepicker
                                                        v-model="formatDates.referenceDate"
                                                        button-only
                                                        @input="getRferenceFormateDate($event)"
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
                                        name="Ref.Date"
                                        rules="required"
                                    >
                                        <b-form-group
                                            label="Vendor Qtn No."
                                            label-for="vendorQtnNo"
                                            :state="getValidationState(validationContext)"
                                        >
                                            <b-form-input
                                                id="vendorQtnNo"
                                                v-model="formData.vendorQtnNo"
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
                                        label="Vendor Qtn Date"
                                        label-for="vendorQtnDate"
                                    >
                                        <b-input-group>
                                            <cleave
                                                id="vendorQtnDate"
                                                v-model="formData.vendorQtnDate"
                                                class="form-control"
                                                :raw="false"
                                                :options="dateFormat"
                                                placeholder="DD/MM/YYYY"
                                                show-decade-nav
                                            />
                                            <b-input-group-append>
                                                <b-form-datepicker
                                                    v-model="formatDates.vendorQtnDate"
                                                    button-only
                                                    @input="getVendoerFormateDate($event)"
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
                                        label="Purchase Qtn No."
                                        label-for="purchseQtnNo"
                                    >
                                        <b-form-input
                                            v-model="formData.purchaseQtnNo"
                                            id="purchseQtnNo"
                                            readonly
                                        />
                                    </b-form-group>
                                </b-col>
                                <b-col md="6">
                                    <b-form-group
                                        label="Purchase Qtn Date"
                                        label-for="purchasetnDate"
                                    >
                                        <b-input-group>
                                            <cleave
                                                id="purchaseQtnDate"
                                                v-model="formData.purchaseQtnDate"
                                                class="form-control"
                                                :raw="false"
                                                :options="dateFormat"
                                                placeholder="DD/MM/YYYY"
                                                show-decade-nav
                                            />
                                            <b-input-group-append>
                                                <b-form-datepicker
                                                    v-model="formatDates.purchaseQtnDate"
                                                    button-only
                                                    @input="getPurchaseQtnFormateDate($event)"
                                                    show-decade-nav
                                                    size="sm"
                                                    nav-button-variant="primary"
                                                />
                                            </b-input-group-append>
                                        </b-input-group>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                        </b-col>
                        <!--row division -->
                        <b-col md="6">
                            <b-row>
                                <b-col md="6">
                                    <validation-provider
                                        #default="validationContext"
                                        name="Due Date"
                                        rules=""
                                    >
                                        <b-form-group
                                            label="Due Date"
                                            label-for="dueDate"
                                            :state="getValidationState(validationContext)"
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
                                                    v-model="formData.dueDate"
                                                    class="form-control"
                                                    :raw="false"
                                                    :options="dateFormat"
                                                    placeholder="DD/MM/YYYY"
                                                    show-decade-nav
                                                />
                                            </b-input-group>
                                        </b-form-group>
                                        <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                            {{ validationContext.errors[0] }}
                                        </b-form-invalid-feedback>
                                    </validation-provider>
                                </b-col>
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
                                            v-model="formData.currencyId"
                                            @input="getCurrencyDetail($event)"
                                        />
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col md="6">
                                    <b-form-group
                                        label="Conversion Rate"
                                        label-for="conversionRate"
                                    >
                                        <b-form-input
                                            id="conversionRate"
                                            v-model="formData.conversationRate"
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
                                            v-model="formData.status"
                                        />
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col md="6">
                                    <b-form-group
                                        label="Quotation Type"
                                        label-for="quotationType"
                                    >
                                        <v-select
                                            placeholder="Select Quotation Type"
                                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                            :options="quotationOptions"
                                            :reduce="val => val.value"
                                            :clearable="false"
                                            input-id="quotationType"
                                            v-model="formData.qtnType"
                                        />
                                    </b-form-group>
                                </b-col>
                            </b-row>
                        </b-col>
                        <!--Rounding Button-->
                        <b-col md="12">
                            <div class="demo-inline-spacing mb-2">
                                <b-form-radio
                                    v-model="formData.purchaseQuotationRounding"
                                    name="salesReturnRoundingAll"
                                    value="0"
                                >
                                    None
                                </b-form-radio>
                                <b-form-radio
                                    v-model="formData.purchaseQuotationRounding"
                                    name="salesReturnRoundingAll"
                                    value="1"
                                >
                                    Rounding
                                </b-form-radio>
                                <b-form-radio
                                    v-model="formData.purchaseQuotationRounding"
                                    name="salesReturnRoundingAll"
                                    value="2"
                                >
                                    Rounding All
                                </b-form-radio>
                            </div>
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
        </b-card-code>
        <b-card-code>
            <b-tabs pills>
                <b-tab active>
                    <template #title>
                        <feather-icon
                            icon="UsersIcon"
                            size="16"
                            class="mr-0 mr-sm-50"
                        />
                        <span class="d-none d-sm-inline">Vendor Details</span>
                    </template>
                    <hr>
                    <vendor-tab-details
                        :vendorDetails="formData.vendorDetails"
                    />
                </b-tab>
            </b-tabs>
        </b-card-code>

        <!--Wo Modal-->
        <b-modal
            id="purchaseEnquiryModal"
            title="Select Purchase Enquiry"
            size="xl"
            no-close-on-backdrop
            ref="purchaseEnquiryModal"
            scrollable
            cancel-variant="danger"
            @ok="handelOk"
            @cancel="resetModalData"
        >
            <b-row>
                <b-col md="12">
                    <hr>
                    <b-table
                        responsive
                        :fields="modalTable.enquiryFields"
                        :items="modalTable.enquiryData"
                        :bordered="true"
                        :hover="true"
                        show-empty
                        class="table_scroll"
                    >
                        <!-- :busy="modalTableIsBusy" -->
                        <!-- Loader -->
                        <template #table-busy>
                            <div class="text-center my-2">
                                <b-spinner class="align-middle"></b-spinner>
                                <strong>Loading...</strong>
                            </div>
                        </template>

                        <template #cell(selectButton)="data">
                            <b-button
                                type="button"
                                size="sm"
                                variant="primary"
                                @click="getEnquiryItems(data.item.referenceId, data.item._id)"
                            >
                                Select
                            </b-button>
                        </template>
                    </b-table>
                </b-col>
                <b-col md="12">
                    <hr>
                    <b-table
                        responsive
                        :fields="modalTable.enquireItemFields"
                        :items="modalTable.enquireItemData"
                        :bordered="true"
                        :hover="true"
                        show-empty
                        class="table_scroll"
                        :busy="isItemTableBusy"
                    >
                        <!-- Index -->
                        <template #cell(index)="data">
                            {{ data.index + 1 }}
                        </template>

                        <!-- Select Multiple Items Checkbox -->
                        <template #cell(selectCheckBox)="data">
                            <b-form-checkbox
                                @input="checkItem($event, data.item._id)"
                            />
                        </template>
                    </b-table>
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
    BFormDatepicker,
    BFormTextarea,
    BButton,
    BFormValidFeedback,
    BInputGroupAppend,
    BInputGroup,
    BFormInvalidFeedback,
    BTabs,
    BTab,
    BSpinner,
    BTable,
    BFormCheckbox,
    BInputGroupPrepend,
    BFormRadio
} from 'bootstrap-vue'
import BCardCode from "@core/components/b-card-code/BCardCode";
import {ValidationObserver, ValidationProvider} from 'vee-validate'
import vSelect from 'vue-select'
import {ref, onUnmounted} from "@vue/composition-api";
import router from '@/router'
import {getTcTodayDate, forMatIndianDate} from "@core/utils/utils";
import vendorTabDetails from "./tabs/vendorTabDetails";
import formValidation from '@core/comp-functions/forms/form-validation'
import {required} from '@validations'
import moment from "moment";
import {getUserData} from "../../../auth/utils";
import axios from '@axios'
import store from '@/store'
import purchaseStoreModule from "../purchaseStoreModule";
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
import {useToast} from 'vue-toastification/composition'
import Cleave from 'vue-cleave-component'

export default {
    components: {
        BCardCode,
        ValidationObserver,
        ValidationProvider,
        BRow,
        BCol,
        BForm,
        BFormGroup,
        vSelect,
        BFormInput,
        BFormDatepicker,
        BFormTextarea,
        BButton,
        BFormValidFeedback,
        BInputGroupAppend,
        BInputGroup,
        BFormInvalidFeedback,
        vendorTabDetails,
        BTabs,
        BTab,
        BSpinner,
        BTable,
        BFormCheckbox,
        BFormRadio,
        Cleave,
        BInputGroupPrepend
    },
    setup({purchaseEnquiryModal}) {
        const ITEMADDON_APP_STORE_MODULE_NAME = 'purchase-store-module'
        if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, purchaseStoreModule)
        onUnmounted(() => {
            if (store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.unregisterModule(ITEMADDON_APP_STORE_MODULE_NAME)
        })

        const toast = useToast()

        const statusOptions = ref([
            {label: 'Pending', value: 1},
            {label: 'Canceled', value: 2},
            {label: 'Completed', value: 3},
            {label: 'Regret', value: 4},
        ])

        const quotationOptions = ref([
            {label: 'Product Quotation', value: 1},
            {label: 'Spares Quotation', value: 2},
            {label: 'Service Quotation', value: 3},
            {label: 'Budgetory Quotation', value: 4},
        ])

        const currencyOptions = ref([])
        axios.get('/api/get-currency-options').then(res => {
            currencyOptions.value = res.data.data
        })

        const getCurrencyDetail = async (id) => {
            await axios.get(`/api/currency-master/${id}`).then(res => {
                formData.value.conversationRate = res.data.data.currencyRate
            })
        }
        const dateFormat = ref({
            date: true,
            delimiter: '/',
            datePattern: ['d', 'm', 'Y'],
        })

        const formatDates = ref({
            referenceDate: null,
            vendorQtnDate: null,
            purchaseQtnDate: null,
            dueDate: null,
        })

        const getRferenceFormateDate = (date) => {
            formData.value.referenceDate = forMatIndianDate(date)
        }
        const getVendoerFormateDate = (date) => {
            formData.value.vendorQtnDate = forMatIndianDate(date)
        }
        const getPurchaseQtnFormateDate = (date) => {
            formData.value.purchaseQtnDate = forMatIndianDate(date)
        }
        const getDueFormateDate = (date) => {
            formData.value.dueDate = forMatIndianDate(date)
        }

        const CurrentUserData = ref(getUserData())

        purchaseEnquiryModal = ref()

        const isItemTableBusy = ref(false)

        const modalTable = ref({
            enquiryFields: [
                {
                    key: 'selectButton',
                    label: ''
                },
                {
                    key: 'enquiry_details.referenceNumber',
                    label: 'Enquiry No.'
                },
                {
                    key: 'enquiry_details.referenceDate',
                    label: 'Date',
                    // formatter: val => forMatIndianDate(val)
                },
                {
                    key: 'party_code.partyName',
                    label: 'Customer Name'
                },
                {
                    key: 'city_name.city',
                    label: 'City'
                },
                {
                    key: 'vendorStatus',
                    label: 'Status',
                    formatter: val => getStatus(val)
                }
            ],
            enquiryData: [],
            enquireItemFields: [
                {
                    key: 'selectCheckBox',
                    label: 'Yes/No'
                },
                {
                    key: 'index',
                    label: 'Sr No'
                },
                {
                    key: 'item_name.itemCode',
                    label: 'Item Code'
                },
                {
                    key: 'itemDescription',
                    label: 'Description'
                },
                {
                    key: 'uom_detail.uom',
                    label: 'uom'
                },
                {
                    key: 'itemRequireQuantity',
                    label: 'Quantity'
                },
                {
                    key: 'itemDrawingNumber',
                    label: 'Drawing No'
                }
            ],
            enquireItemData: [],
        })

        const blankFormData = {
            referenceId: null,
            referenceNumber: null,
            referenceDate: forMatIndianDate(),
            currencyId: null,
            dueDate: forMatIndianDate(getTcTodayDate()),
            vendorQtnNo: null,
            vendorQtnDate: forMatIndianDate(getTcTodayDate()),
            conversationRate: null,
            status: null,
            purchaseQtnNo: null,
            purchaseQtnDate: forMatIndianDate(getTcTodayDate()),
            qtnType: 1,
            purchaseQuotationRounding: 0,
            itemIds: [],
            vendorDetails: {
                vendorCode: null,
                vendorName: null,
                vendorKindAttn: null,
                vendorAddress: null,
                vendorCity: null,
                vendorState: null,
                vendorCountry: null,
                vendorFaxNo: null,
                vendorEmailId: null,
                vendorPinCode: null,
                vendorPhoneCountry: '+91',
                vendorPhoneNo: null,
                vendorWebSite: null,
            },
            noteDetails: {
                quotationNote: null,
            },
            loginDetails: {
                createdBy: CurrentUserData.value.first_name + ' ' + CurrentUserData.value.last_name,
                dateTime: moment(new Date()).format('DD/MM/YYYY HH:mm'),
                lastModifiedBy: null,
                modifiedDateTime: null,
            },
        }

        const formData = ref(JSON.parse(JSON.stringify(blankFormData)))

        const resetFormData = () => {
            formData.value = JSON.parse(JSON.stringify(blankFormData))
        }

        const openModal = async () => {
            formData.value.itemIds = []
            await axios.get('/api/purchase-enquiry-vendor-detail').then(res => {
                modalTable.value.enquiryData = res.data.data
            })
            purchaseEnquiryModal.value.show();
        }

        const getStatus = (id) => {
            let valObj = statusOptions.value.filter(function (elem) {
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

        const getEnquiryItems = async (id, vendorId) => {
            isItemTableBusy.value = true
            await axios.get(`/api/purchase-enquiry-vendor-detail/${vendorId}`).then(res => {
                formData.value.referenceId = res.data.data.referenceId
                formData.value.referenceNumber = res.data.data?.enquiry_details?.referenceNumber ?? null
                formData.value.referenceDate = res.data.data?.enquiry_details?.referenceDate ?? null
                formData.value.vendorDetails.vendorCode = res.data.data.vendorCode
                formData.value.vendorDetails.vendorName = res.data.data?.party_code?.partyName ?? null
                formData.value.vendorDetails.vendorKindAttn = res.data.data?.kind_attn_name?.personName ?? null
                formData.value.vendorDetails.vendorAddress = res.data.data.vendorAddress
                formData.value.vendorDetails.vendorCity = res.data.data.vendorCity
                formData.value.vendorDetails.vendorState = res.data.data.vendorState
                formData.value.vendorDetails.vendorCountry = res.data.data.vendorCountry
                formData.value.vendorDetails.vendorFaxNo = res.data.data.vendorFaxNo
                formData.value.vendorDetails.vendorEmailId = res.data.data.vendorEmailId
                formData.value.vendorDetails.vendorPinCode = res.data.data.vendorPinCode
                formData.value.vendorDetails.vendorPhoneCountry = res.data.data.vendorPhoneCountry
                formData.value.vendorDetails.vendorPhoneNo = res.data.data.vendorPhoneNo
                formData.value.vendorDetails.vendorWebSite = res.data.data.vendorWebSite
                formData.value.status = res.data.data.vendorStatus

                //Currency Details
                formData.value.currencyId = res.data.data?.party_master_details?.curreny_details?._id ?? null
                formData.value.conversationRate = res.data.data?.party_master_details?.curreny_details?.currencyRate ?? null
            })

            await axios.get(`/api/purchase-enquiry-item-details/${id}`).then(res => {
                modalTable.value.enquireItemData = res.data.data
            })
            isItemTableBusy.value = false
        }

        const checkItem = (e, id) => {
            if (e === false) {
                formData.value.itemIds = formData.value.itemIds.filter(function (e) {
                    return e !== id
                })
            } else {
                formData.value.itemIds.push(id)
            }
        }

        const handelOk = async () => {
            resetModalData()
        }

        const resetModalData = () => {
            modalTable.value.enquireItemData = []
        }

        const saveFormData = async () => {
            await store.dispatch('purchase-store-module/addPurchaseQuotation', formData.value).then(res => {
                if (res.status === 200) {
                    toast({
                        component: ToastificationContent,
                        position: 'top-right',
                        props: {
                            title: 'Purchase Quotation Added',
                            icon: 'CheckSquareIcon',
                            variant: 'success',
                            text: `You have successfully Added Purchase Quotation.`,
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
                    name: 'edit-purchase-quotation',
                    params: {
                        id: res.data.data._id
                    }
                })
            })
        }

        const {refFormObserver, getValidationState, resetForm} = formValidation(resetFormData)

        return {
            formData,
            statusOptions,
            quotationOptions,
            currencyOptions,
            getCurrencyDetail,
            saveFormData,
            purchaseEnquiryModal,
            isItemTableBusy,
            refFormObserver,
            getValidationState,
            resetForm,
            resetFormData,
            modalTable,
            openModal,
            getStatus,
            getEnquiryItems,
            checkItem,
            handelOk,
            resetModalData,
            required,
            getDueFormateDate,
            getPurchaseQtnFormateDate,
            getVendoerFormateDate,
            getRferenceFormateDate,
            dateFormat,
            formatDates
        }
    },
}
</script>
