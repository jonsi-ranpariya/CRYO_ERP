<template>
    <div>
        <b-row>
            <b-col md="2"><b>Challan</b></b-col>
        </b-row>
        <hr>
        <b-row>
            <b-col md="12">
                <template>
                    <div class="demo-inline-spacing">
                        <b-form-checkbox
                            v-model="selected"
                            value="A"
                        >
                            Buyers Copy Checked
                        </b-form-checkbox>
                        <b-form-checkbox
                            v-model="selected"
                            value="B"
                        >
                            Suppliers Copy
                        </b-form-checkbox>
                        <b-form-checkbox
                            v-model="selected"
                            value="C"
                        >
                            Office Copy
                        </b-form-checkbox>
                        <!--<b-form-checkbox
                            v-model="selected"
                            value="D"
                        >
                            All
                        </b-form-checkbox>-->
                        <b-form-checkbox
                            v-model="selected"
                            value="E"
                        >
                            GST Challan
                        </b-form-checkbox>
                        <!--<b-form-checkbox
                            v-model="selected"
                            value="F"
                        >
                            Paking List Formate 2
                        </b-form-checkbox>-->
                    </div>
                </template>
            </b-col>
        </b-row>
        <!--<br>
        <b-row>
            <b-col md="4">
                <b-form-group
                    label="Page"
                    label-for="page"
                >
                    <v-select
                        placeholder="Select Page"
                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                        :reduce="val => val.value"
                        :options="pageOption"
                        :clearable="false"
                        input-id="page"
                    />
                </b-form-group>
            </b-col>
            <b-col md="8">
                <template>
                    <div class="demo-inline-spacing">
                        <b-form-checkbox
                            v-model="selected"
                            value="A"
                        >
                            With Item Image
                        </b-form-checkbox>
                        <b-form-checkbox
                            v-model="selected"
                            value="B"
                        >
                            Item Wise PONo
                        </b-form-checkbox>
                    </div>
                </template>
            </b-col>
        </b-row>
        <hr>
        -->
        <b-row>
            <b-col md="12">
                <hr>
                <b>Invoice</b>
            </b-col>
        </b-row>
        <hr>
        <b-row>
            <!--<b-col md="8">
                <template>
                    <div class="demo-inline-spacing">
                        <b-form-checkbox
                            v-model="selected"
                            value="A"
                        >
                            GST Invoice
                        </b-form-checkbox>
                        <b-form-checkbox
                            v-model="selected"
                            value="B"
                        >
                            Commercial Invoice
                        </b-form-checkbox>
                        <b-form-checkbox
                            v-model="selected"
                            value="B"
                        >
                            Excisable Invoice
                        </b-form-checkbox>
                        <b-form-checkbox
                            v-model="selected"
                            value="B"
                        >
                            Multi Page
                        </b-form-checkbox>
                    </div>
                </template>
                <br>
                <b-row>
                    <b-col md="5">
                        <v-select
                            placeholder="Select Page"
                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                            :reduce="val => val.value"
                            :options="formatOption"
                            :clearable="false"
                            input-id="page"
                        />
                    </b-col>
                    <b-col md="5">
                        <v-select
                            placeholder="Select Page"
                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                            :reduce="val => val.value"
                            :options="blankPageOption"
                            :clearable="false"
                            input-id="Blank page"
                        />
                    </b-col>
                </b-row>
                <b-row>
                    <b-col md="5"></b-col>
                    <b-col md="7">
                        <b-form-checkbox
                            class="mt-1"
                            v-for="option in options7"
                            :key="option.value"
                            v-model="selected"
                            :value="option.value"
                            name="report7"
                        >
                            {{option.text}}
                        </b-form-checkbox>
                    </b-col>
                </b-row>
            </b-col>-->
            <b-col md="4">
                <!--<b-form-group
                    label="Title For Blank Page Report"
                    label-for="blankReport"
                >
                    <b-form-input
                        id="blankReport"
                    />
                </b-form-group>
                <br>-->
                <b-form-checkbox
                    v-for="option in options8"
                    :key="option.value"
                    v-model="invoiceSelectionMode"
                    :value="option.value"
                    name="report8"
                    class="m-1"
                >
                    {{ option.text }}
                </b-form-checkbox>
                <!--<br>
                <v-select
                    placeholder="Select Page"
                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                    :reduce="val => val.value"
                    :options="formatOption3"
                    :clearable="false"
                    input-id="page"
                />
                <br>
                <b-form-checkbox
                    v-for="option in options11"
                    :key="option.value"
                    v-model="selected"
                    :value="option.value"
                    name="report9"
                >
                    {{option.text}}
                </b-form-checkbox>-->
            </b-col>
        </b-row>
        <hr>
        <b-row>
            <b-col md="2"><b>Copy Selection</b></b-col>
        </b-row>
        <hr>
        <b-row>
            <b-col>
                <template>
                    <div class="demo-inline-spacing">
                        <b-form-checkbox
                            v-model="copySelection"
                            value="Original for Recipient"
                        >
                            Original for Buyer
                        </b-form-checkbox>
                        <b-form-checkbox
                            v-model="copySelection"
                            value="Duplicate for Transporter"
                        >
                            Duplicate for Transporter
                        </b-form-checkbox>
                        <b-form-checkbox
                            v-model="copySelection"
                            value="Triplicate for Assesses"
                        >
                            Triplicate for Assesses
                        </b-form-checkbox>
                        <b-form-checkbox
                            v-model="copySelection"
                            value="Extra Copy"
                        >
                            Extra Copy
                        </b-form-checkbox>
                        <!--<b-form-checkbox
                            v-model="copySelection"
                            value="All"
                        >
                            All
                        </b-form-checkbox>-->
                    </div>
                </template>
            </b-col>
        </b-row>
        <hr>
        <!--<br>
        <b-row>
            <b-col md="3">
                <b-form-group
                    label="Page"
                    label-for="page"
                >
                    <v-select
                        placeholder="Select Page"
                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                        :reduce="val => val.value"
                        :options="pageOption"
                        :clearable="false"
                        input-id="page"
                    />
                </b-form-group>
                <b-form-checkbox
                    v-for="option in options0"
                    :key="option.value"
                    v-model="selected"
                    :value="option.value"
                    name="report"
                >
                    {{ option.text }}
                </b-form-checkbox>
            </b-col>
            <b-col md="4">
                <b-form-group
                    label="Export Invoice Formate"
                    label-for="page"
                >
                    <v-select
                        placeholder="Select Page"
                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                        :reduce="val => val.value"
                        :options="exportInvoiceOption"
                        :clearable="false"
                        input-id="page"
                    />
                </b-form-group>
                <br>
                <b-form-checkbox
                    v-for="option in options12"
                    :key="option.value"
                    v-model="selected"
                    :value="option.value"
                    name="report"
                >
                    {{ option.text }}
                </b-form-checkbox>
            </b-col>
            <b-col md="5">
                <hr>
                <b>Export Packing List</b>
                <hr>
                <b-row>
                    <b-col md="12" class="d-flex ">
                        <b-form-radio
                            name="some-radios"
                            value="1"
                        >
                            Item Wise
                        </b-form-radio>
                        &nbsp; &nbsp;
                        <b-form-radio
                            name="some-radios"
                            value="2"
                        >
                            Box Wise
                        </b-form-radio>
                    </b-col>
                    <b-row class="ml-1">
                        <template>
                            <div class="demo-inline-spacing">
                                <b-form-checkbox
                                    v-model="selected"
                                    value="A"
                                >
                                    With Notify Party
                                </b-form-checkbox>
                            </div>
                        </template>
                    </b-row>
                </b-row>
            </b-col>
        </b-row>
        <hr>-->
        <b-row>
            <b-col md="12">
                <b-row>
                    <b-col md="3">
                        <b-button
                            type="button"
                            class="ml-1"
                            variant="primary"
                            @click="openPdf"
                            :disabled="openPdfButton.disabled"
                        >
                            {{ openPdfButton.text }}
                        </b-button>
                    </b-col>
                    <b-col md="3">
                        <b-button
                            type="button"
                            class="ml-1"
                            variant="primary"
                            @click="generateIrn"
                        >
                            Generate E-INVOICE
                        </b-button>
                    </b-col>
                    <b-col md="3">
                        <div
                            v-if="currentPurchaseReturnData.master_gst && Object.keys(currentPurchaseReturnData.master_gst).length !== 0"
                        >
                            <b-button
                                type="button"
                                class="ml-1"
                                variant="primary"
                                @click="cancelIrn"
                                v-if="currentPurchaseReturnData.master_gst.Irn"
                            >
                                Cancel E-INVOICE
                            </b-button>
                        </div>
                    </b-col>
                </b-row>
                <b-row>
                    <b-col md="3">
                        <b-button
                            variant="primary"
                            type="button"
                            class="ml-1 mt-1"
                            @click="ewayBillSiteRedirect"
                        >
                            Eway Bill Login
                        </b-button>

                    </b-col>
                    <b-col md="3">
                        <b-button
                            type="button"
                            class="ml-1 mt-1"
                            variant="primary"
                            @click="generateEWayBill"
                        >
                            Generate E-Way Bill
                        </b-button>
                    </b-col>
                </b-row>
            </b-col>
        </b-row>
        <!-- Cancel IRN Modal -->
        <b-modal
            id="cancelIrnModal"
            no-close-on-backdrop
            ref="cancelIrnModal"
            size="lg"
            title="Cancel IRN"
            hide-footer
        >
            <validation-observer #default="{ handleSubmit }">
                <b-form @submit.prevent="handleSubmit(cancelIrnFormSubmit)">
                    <b-row>
                        <b-col md="12">
                            <validation-provider
                                #default="validationContext"
                                name="IRN Number"
                                rules="required"
                            >
                                <b-form-group
                                    label="IRN Number"
                                    label-for="irnNumber"
                                >
                                    <b-form-input
                                        id="irnNumber"
                                        :state="getValidationState(validationContext)"
                                        v-model="cancelFormData.irnNumber"
                                        readonly
                                    />
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                            <validation-provider
                                #default="validationContext"
                                name="Cancel Reason"
                                rules="required"
                            >
                                <b-form-group
                                    label="Cancel Reason"
                                    label-for="cancelReason"
                                    :state="getValidationState(validationContext)"
                                >
                                    <v-select
                                        placeholder="Select Reason"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :reduce="val => val.value"
                                        :options="cancelReasonOptions"
                                        :clearable="false"
                                        input-id="cancelReason"
                                        v-model="cancelFormData.cancelReason"
                                    />
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                            <validation-provider
                                #default="validationContext"
                                name="Cancel Remark"
                                rules=""
                            >
                                <b-form-group
                                    label="Cancel Remark"
                                    label-for="cancelRemark"
                                >
                                    <b-form-textarea
                                        id="cancelRemark"
                                        v-model="cancelFormData.cancelRemark"
                                        rows="3"
                                        :state="getValidationState(validationContext)"
                                    />
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                            <hr>
                            <b-button
                                class="float-right"
                                type="submit"
                                variant="primary"
                            >
                                Submit
                            </b-button>
                        </b-col>
                    </b-row>
                </b-form>
            </validation-observer>
        </b-modal>
    </div>
</template>
<script>
import {
    BButton,
    BCol,
    BFormCheckbox,
    BFormGroup,
    BFormInput,
    BFormRadio,
    BRow,
    BFormTextarea,
    BForm,
    BFormInvalidFeedback,
    BTable,
    BDropdown,
    BDropdownItem,
} from 'bootstrap-vue'
import vSelect from 'vue-select'
import {ref} from "@vue/composition-api"
import axios from '@axios'
import router from '@/router'
import {useToast} from "vue-toastification/composition";
import ToastificationContent from "@core/components/toastification/ToastificationContent";
import Swal from "sweetalert2";
import {ValidationObserver, ValidationProvider} from 'vee-validate'
import {required} from '@validations'
import formValidation from "@core/comp-functions/forms/form-validation";

export default {
    components: {
        BRow,
        BCol,
        BFormGroup,
        BFormCheckbox,
        vSelect,
        BFormInput,
        BButton,
        BFormRadio,
        BFormTextarea,
        BForm,
        BFormInvalidFeedback,
        BTable,
        BDropdown,
        BDropdownItem,

        ValidationObserver,
        ValidationProvider,
    },
    setup({cancelIrnModal}) {
        const currentPurchaseReturnData = ref({})

        const file_get_content = async (url, callback) => {
            let res = await fetch(url),
                ret = await res.text();

            return callback ? callback(ret) : ret;
        }

        cancelIrnModal = ref();

        const MASTER_API_BASE_URL = 'https://api.mastergst.com';
        const MASTER_GST_IP_ADDRESS = file_get_content('https://api.ipify.org');

        axios.get(`/api/new/purchase-return/${router.currentRoute.params.id}`).then(res => {
            currentPurchaseReturnData.value = res.data.data
        });

        const toast = useToast();
        const formatOption = ref([
            {label: 'A4 Format1', value: 1},
            {label: 'A4 Format2', value: 2},
            {label: 'A4 Format3Box', value: 3},
            {label: 'A4 Format4MRP', value: 4},
            {label: 'A4 Format5', value: 5},
            {label: 'A4 Format6', value: 6},
        ]);
        const blankPageOption = ref([
            {label: 'BlankA4 Format2', value: 1},
            {label: 'BlankDotMatrix358x12Formate1WithBoxDetails', value: 2},
            {label: 'BlankDotMatrix358x12Formate2', value: 3},
            {label: 'BlankDotMatrix358x12Formate3', value: 4},
            {label: 'BlankDotMatrix358x12Formate2NoneExcise', value: 5},
            {label: 'BlankA4Format3WithBoxDetails', value: 6},
            {label: 'BlankA4Format3', value: 7},
            {label: 'BlankA4Format4', value: 8},
        ]);
        const pageOption = ref([
            {label: 'Blank Page', value: 1},
            {label: 'Letter Pad', value: 2}
        ]);
        const formatOption2 = ref([
            {label: 'TAX INVOICE', value: 1}
        ]);
        const formatOption3 = ref([
            {label: 'Blank Page', value: 1},
            {label: 'Latter Pad', value: 2}
        ]);
        const exportInvoiceOption = ref([
            {label: 'Format 1', value: 1},
            {label: 'Format 2', value: 2},
            {label: 'Format 3', value: 3},
            {label: 'Format 4', value: 4},
            {label: 'Format 5', value: 5},
            {label: 'Format 6', value: 6}
        ]);
        const cancelReasonOptions = ref([
            {label: 'Duplicate', value: '1'},
            {label: 'Data entry mistake', value: '2'},
            {label: 'Order Cancelled', value: '3'},
            {label: 'Others', value: '4'},
        ]);

        const openPdfButton = ref({
            text: 'Preview E-INVOICE',
            disabled: false
        });

        const selected = ref([]);

        const copySelection = ref('');

        const invoiceSelectionMode = ref(0);

        const openPdf = async () => {
            openPdfButton.value.text = 'Please wait...';
            openPdfButton.value.disabled = true;
            await axios.post('/pdf/purchase-return-invoice-preview', {
                purchaseReturnId: router.currentRoute.params.id,
                copySelection: copySelection.value,
                invoiceSelectionMode: invoiceSelectionMode.value
            }).then((res) => {
                if (res.data.path) {
                    let path = res.data.path
                    window.open(path, '_blank');
                }
            }).catch((error) => {
                toast({
                    component: ToastificationContent,
                    position: 'top-right',
                    props: {
                        title: `Error`,
                        icon: 'AlertCircleIcon',
                        variant: 'danger',
                        text: error.response.data.msg,
                    },
                });
            });
            openPdfButton.value.text = 'Preview E-INVOICE';
            openPdfButton.value.disabled = false;
        }

        const generateIrn = async () => {
            await Swal.fire({
                title: 'Are you sure?',
                text: "Generate E-Invoice!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
                customClass: {
                    confirmButton: 'btn btn-primary',
                    cancelButton: 'btn btn-outline-danger ml-1',
                },
                buttonsStyling: false,
            }).then(result => {
                if (result.value) {
                    axios.get('/api/master-gst/get-purchase-return-items-and-final-amounts/' + router.currentRoute.params.id).then((res) => {
                        generateEInvoiceDetails(res.data)
                    });
                }
            });
        }

        const generateEInvoiceDetails = async (itemData) => {
            let authToken;

            let data = {
                "Version": "1.1",
                "TranDtls": {
                    "TaxSch": "GST",
                    "SupTyp": currentPurchaseReturnData.value.prReportSupplyType,
                    "RegRev": "N",
                    "EcmGstin": null,
                    "IgstOnIntra": "N"
                },
                "DocDtls": {
                    "Typ": "DBN",
                    "No": currentPurchaseReturnData.value.prInvoiceNo,
                    "Dt": currentPurchaseReturnData.value.prInvoiceDate
                },
                "SellerDtls": {
                    "Gstin": currentPurchaseReturnData.value.company_detail.ewayGstin,
                    "LglNm": currentPurchaseReturnData.value.company_detail.companyName,
                    "TrdNm": currentPurchaseReturnData.value.company_detail.companyName,
                    "Addr1": currentPurchaseReturnData.value.company_detail.address.substring(0, 100),
                    "Loc": currentPurchaseReturnData.value.company_detail.city_data.city.toUpperCase(),
                    "Pin": parseInt(currentPurchaseReturnData.value.company_detail.pinCode),
                    "Stcd": currentPurchaseReturnData.value.company_detail.state_data.stateCode,
                },
                /*"SellerDtls": {
                    "Gstin": "29AABCT1332L000",
                    "LglNm": "ABC company pvt ltd",
                    "TrdNm": "NIC Industries",
                    "Addr1": "5th block, kuvempu layout",
                    "Addr2": "kuvempu layout",
                    "Loc": "GANDHINAGAR",
                    "Pin": 560001,
                    "Stcd": "29",
                },*/
                "BuyerDtls": {
                    "Gstin": currentPurchaseReturnData.value.buyerDetails.buyerGstinNo,
                    "LglNm": currentPurchaseReturnData.value.buyerDetails.buyerName,
                    "TrdNm": currentPurchaseReturnData.value.buyerDetails.buyerName,
                    "Pos": currentPurchaseReturnData.value.buyerDetails.buyerStateCode,
                    "Addr1": currentPurchaseReturnData.value.buyerDetails.buyerAddress.substring(0, 100),
                    "Loc": currentPurchaseReturnData.value.buyerDetails.buyerCityName.toUpperCase(),
                    "Pin": parseInt(currentPurchaseReturnData.value.buyerDetails.buyerPinCode),
                    "Stcd": currentPurchaseReturnData.value.buyerDetails.buyerStateCode,
                },
                "DispDtls": {
                    "Nm": currentPurchaseReturnData.value.company_detail.companyName,
                    "Addr1": currentPurchaseReturnData.value.company_detail.address.substring(0, 100),
                    "Loc": currentPurchaseReturnData.value.company_detail.city_data.city.toUpperCase(),
                    "Pin": parseInt(currentPurchaseReturnData.value.company_detail.pinCode),
                    "Stcd": currentPurchaseReturnData.value.company_detail.state_data.stateCode
                },
                "ShipDtls": {
                    "LglNm": currentPurchaseReturnData.value.buyerDetails.buyerName,
                    "Addr1": currentPurchaseReturnData.value.buyerDetails.buyerAddress.substring(0, 100),
                    "Loc": currentPurchaseReturnData.value.buyerDetails.buyerCityName.toUpperCase(),
                    "Pin": parseInt(currentPurchaseReturnData.value.buyerDetails.buyerPinCode),
                    "Stcd": currentPurchaseReturnData.value.buyerDetails.buyerStateCode,
                },
                "ItemList": itemData.itemList,
                "ValDtls": itemData.itemValueDetail,
            }

            /*await axios.get(MASTER_API_BASE_URL + '/einvoice/authenticate?email=' + currentPurchaseReturnData.value.company_detail.ewayEmail, {
                headers: {
                    username: currentPurchaseReturnData.value.company_detail.ewayUsername,
                    password: currentPurchaseReturnData.value.company_detail.ewayPassword,
                    ip_address: MASTER_GST_IP_ADDRESS,
                    client_id: currentPurchaseReturnData.value.company_detail.ewayClientId,
                    client_secret: currentPurchaseReturnData.value.company_detail.ewayClientSecret,
                    gstin: currentPurchaseReturnData.value.company_detail.ewayGstin
                }
            }).then(res => {
                authToken = res.data.data.AuthToken
            });

            await axios.post(MASTER_API_BASE_URL + '/einvoice/type/GENERATE/version/V1_03?email=' + currentPurchaseReturnData.value.company_detail.ewayEmail, data, {
                headers: {
                    ip_address: MASTER_GST_IP_ADDRESS,
                    client_id: currentPurchaseReturnData.value.company_detail.ewayClientId,
                    client_secret: currentPurchaseReturnData.value.company_detail.ewayClientSecret,
                    username: currentPurchaseReturnData.value.company_detail.ewayUsername,
                    'auth-token': authToken,
                    gstin: currentPurchaseReturnData.value.company_detail.ewayGstin,
                }
            }).then((res) => {
                let response = res.data
                if (response.status_cd == 0) {
                    let jsonDecode = JSON.parse(response.status_desc)
                    jsonDecode.forEach((item) => {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: `Error Code: ${item.ErrorCode}`,
                                icon: 'AlertCircleIcon',
                                variant: 'danger',
                                text: item.ErrorMessage,
                            },
                        });
                    });
                } else {
                    axios.post('/api/master-gst/generated-irn-save', {
                        purchaseReturnId: router.currentRoute.params.id,
                        ...response.data
                    }).then(() => {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'IRN Generated',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: 'You have successfully Generate IRN'
                            }
                        });
                    });
                }
            }).catch(() => {
                toast({
                    component: ToastificationContent,
                    position: 'top-right',
                    props: {
                        title: 'Error',
                        icon: 'AlertCircleIcon',
                        variant: 'danger',
                        text: 'Master GST Server Issues.'
                    }
                });
            });*/
        }

        const cancelBlankFormData = {
            irnNumber: null,
            cancelReason: null,
            cancelRemark: null
        }

        const cancelFormData = ref(JSON.parse(JSON.stringify(cancelBlankFormData)));

        const resetCancelFormData = () => {
            cancelFormData.value = JSON.parse(JSON.stringify(cancelBlankFormData));
        }

        const cancelIrn = async () => {
            await axios.get(`/api/new/purchase-return/${router.currentRoute.params.id}`).then(res => {
                cancelFormData.value.irnNumber = res.data.data.master_gst.Irn ?? null
            });

            cancelIrnModal.value.show();
        }

        const cancelIrnFormSubmit = async () => {
            await Swal.fire({
                title: 'Are you sure?',
                text: "Cancel E-Way Bill!",
                icon: 'error',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
                customClass: {
                    confirmButton: 'btn btn-primary',
                    cancelButton: 'btn btn-outline-danger ml-1',
                },
                buttonsStyling: false,
            }).then(result => {
                if (result.value) {
                    generateCancelIrnRequest();
                } else {
                    resetCancelFormData();
                }
                cancelIrnModal.value.hide();
            });
        }

        const generateCancelIrnRequest = async () => {
            let authToken, data = {
                Irn: cancelFormData.value.irnNumber,
                CnlRsn: cancelFormData.value.cancelReason,
                CnlRem: cancelFormData.value.cancelRemark,
            };
            await axios.get(MASTER_API_BASE_URL + '/einvoice/authenticate?email=' + currentPurchaseReturnData.value.company_detail.ewayEmail, {
                headers: {
                    username: currentPurchaseReturnData.value.company_detail.ewayUsername,
                    password: currentPurchaseReturnData.value.company_detail.ewayPassword,
                    ip_address: MASTER_GST_IP_ADDRESS,
                    client_id: currentPurchaseReturnData.value.company_detail.ewayClientId,
                    client_secret: currentPurchaseReturnData.value.company_detail.ewayClientSecret,
                    gstin: currentPurchaseReturnData.value.company_detail.ewayGstin
                }
            }).then(res => {
                authToken = res.data.data.AuthToken
            });

            await axios.post(MASTER_API_BASE_URL + '​/einvoice/type/CANCEL/version/V1_03/?email=' + currentPurchaseReturnData.value.company_detail.ewayEmail, data, {
                headers: {
                    ip_address: MASTER_GST_IP_ADDRESS,
                    client_id: currentPurchaseReturnData.value.company_detail.ewayClientId,
                    client_secret: currentPurchaseReturnData.value.company_detail.ewayClientSecret,
                    username: currentPurchaseReturnData.value.company_detail.ewayUsername,
                    'auth-token': authToken,
                    gstin: currentPurchaseReturnData.value.company_detail.ewayGstin
                }
            }).then(res => {
                let response = res.data
                if (response.status_cd == 0) {
                    let jsonDecode = JSON.parse(response.status_desc)
                    jsonDecode.forEach((item) => {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: `Error Code: ${item.ErrorCode}`,
                                icon: 'AlertCircleIcon',
                                variant: 'danger',
                                text: item.ErrorMessage,
                            },
                        });
                    });
                } else {
                    axios.post('/api/master-gst/cancel-irn-ebill-details', {
                        purchaseReturnId: router.currentRoute.params.id,
                        ...response.data
                    }).then(() => {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'EInvoice Canceled',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: 'You have successfully Cancel EInvoice'
                            }
                        });
                    });
                }
            });
            resetCancelFormData();
        }

        const {refFormObserver, getValidationState, resetForm} = formValidation(resetCancelFormData);

        const ewayBillSiteRedirect = async () => {
            window.open('https://einvoice1.gst.gov.in/', '_blank');
        }

        const generateEWayBill = async () => {
            await Swal.fire({
                title: 'Are you sure?',
                text: "Generate E-Way Bill!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
                customClass: {
                    confirmButton: 'btn btn-primary',
                    cancelButton: 'btn btn-outline-danger ml-1',
                },
                buttonsStyling: false,
            }).then(result => {
                if (result.value) {
                    generateEwayBillDetails()
                }
            })
        }

        const generateEwayBillDetails = async () => {
            let authToken, data = {
                "Irn": currentPurchaseReturnData.value.master_gst.Irn,
                "Distance": parseInt(currentPurchaseReturnData.value.transportExportData.distance),
                "TransMode": currentPurchaseReturnData.value.transportExportData.transportMode ?? '1',
                "TransId": currentPurchaseReturnData.value.transportExportData.transporterId ?? null,
                "TransName": currentPurchaseReturnData.value.transportExportData.transporter ?? null,
                "TransDocNo": currentPurchaseReturnData.value.transportExportData.lrNumber,
                "TransDocDt": currentPurchaseReturnData.value.transportExportData.lrDate,
                "VehNo": currentPurchaseReturnData.value.transportExportData.vehicalNo ?? null,
                "VehType": currentPurchaseReturnData.value.transportExportData.vehicleType ?? "R"
            };

            await axios.get(MASTER_API_BASE_URL + '/einvoice/authenticate?email=' + currentPurchaseReturnData.value.company_detail.ewayEmail, {
                headers: {
                    username: currentPurchaseReturnData.value.company_detail.ewayUsername,
                    password: currentPurchaseReturnData.value.company_detail.ewayPassword,
                    ip_address: MASTER_GST_IP_ADDRESS,
                    client_id: currentPurchaseReturnData.value.company_detail.ewayClientId,
                    client_secret: currentPurchaseReturnData.value.company_detail.ewayClientSecret,
                    gstin: currentPurchaseReturnData.value.company_detail.ewayGstin
                }
            }).then(res => {
                authToken = res.data.data.AuthToken
            });

            await axios.post(MASTER_API_BASE_URL + '​/einvoice/type/GENERATE_EWAYBILL/version/V1_03?email=' + currentPurchaseReturnData.value.company_detail.ewayEmail,
                data, {
                    headers: {
                        ip_address: MASTER_GST_IP_ADDRESS,
                        client_id: currentPurchaseReturnData.value.company_detail.ewayClientId,
                        client_secret: currentPurchaseReturnData.value.company_detail.ewayClientSecret,
                        username: currentPurchaseReturnData.value.company_detail.ewayUsername,
                        'auth-token': authToken,
                        gstin: currentPurchaseReturnData.value.company_detail.ewayGstin
                    }
                }).then(res => {
                let response = res.data
                if (response.status_cd == 0) {
                    let jsonDecode = JSON.parse(response.status_desc)
                    jsonDecode.forEach((item) => {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: `Error Code: ${item.ErrorCode}`,
                                icon: 'AlertCircleIcon',
                                variant: 'danger',
                                text: item.ErrorMessage,
                            },
                        })
                    });
                } else {
                    axios.post('/api/master-gst/update-irn-ebill-details', {
                        challanInvoiceId: router.currentRoute.params.id,
                        ...response.data
                    }).then(() => {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'EWay Bill Generated',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: 'You have successfully Generate EWay Bill'
                            }
                        })
                    });
                }
            }).catch(() => {
                toast({
                    component: ToastificationContent,
                    position: 'top-right',
                    props: {
                        title: 'Error',
                        icon: 'AlertCircleIcon',
                        variant: 'danger',
                        text: 'Master GST Server Issues.'
                    }
                })
            });
        }

        return {
            selected,
            options7: [
                {text: 'Print Invoice With Challan No.', value: 'Print Excisable Invoice With Challan No.'},
                {text: 'Report With Item Detail Description', value: 'Report With Item Detail Description'},
                {text: 'Report With Item Description Only', value: 'Report With Item Description Only'},
            ],
            options8: [
                {text: 'Report With Discount', value: 1},
                /*{text: 'Report With Item Serial No.', value: 2},*/
            ],
            options11: [
                {text: 'Envelope #10', value: 'Envelope'},
                {text: 'Form 402', value: 'Form 402'},
            ],
            options12: [
                {text: 'Export Invoice Without Sign', value: 'Export Invoice Without Sign'},
            ],
            options0: [
                {text: 'Header Image', value: 'Header Image'},
                {text: 'Footer Image', value: 'Footer Image'},
            ],
            options13: [
                {text: 'With Notify Party', value: 'With Notify Party'},
            ],

            cancelIrnModal,
            copySelection,
            invoiceSelectionMode,
            currentPurchaseReturnData,
            formatOption,
            blankPageOption,
            pageOption,
            formatOption2,
            formatOption3,
            exportInvoiceOption,
            cancelReasonOptions,
            openPdfButton,
            openPdf,
            generateIrn,
            cancelBlankFormData,
            cancelFormData,
            resetCancelFormData,
            cancelIrn,
            cancelIrnFormSubmit,
            generateCancelIrnRequest,
            refFormObserver,
            getValidationState,
            resetForm,
            required,
            ewayBillSiteRedirect,
            generateEWayBill,
            generateEwayBillDetails
        }
    }
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
