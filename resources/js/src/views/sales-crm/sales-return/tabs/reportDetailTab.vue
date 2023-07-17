<template>
    <div>
        <!--        <b-row>
                    <b-col md="12">
                        <h5>Copy Section</h5>
                        <hr>
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
                                &lt;!&ndash;<b-form-checkbox
                                    v-model="copySelection"
                                    value="All"
                                >
                                    All
                                </b-form-checkbox>&ndash;&gt;
                            </div>
                        </template>
                    </b-col>
                </b-row>
                <hr>-->
        <b-row>
            <b-col md="3">
                <b-button
                    variant="primary"
                    type="button"
                    @click="generatePdf"
                    :disabled="previewButton.buttonDisabled"
                >
                    {{ previewButton.buttonName }}
                </b-button>
            </b-col>
            <b-col md="3">
                <b-button
                    variant="primary"
                    type="button"
                    @click="generateEInvoice"
                >
                    Generate E-Invoice
                </b-button>
            </b-col>
            <b-col md="3">
                <div
                    v-if="currentSalesReturnData.master_gst && Object.keys(currentSalesReturnData.master_gst).length !== 0">
                    <b-button
                        variant="primary"
                        type="button"
                        v-if="currentSalesReturnData.master_gst.Irn"
                        @click="cancelIrn"
                    >
                        Cancel E-Invoice
                    </b-button>
                </div>
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
} from 'bootstrap-vue';
import vSelect from 'vue-select';
import {computed, ref} from "@vue/composition-api";
import axios from '@axios';
import router from '@/router';
import {useToast} from "vue-toastification/composition";
import Swal from "sweetalert2";
import {ValidationObserver, ValidationProvider} from "vee-validate";
import {MASTER_API_BASE_URL, MASTER_GST_EMAIL, MASTER_GST_IP_ADDRESS} from "@core/utils/masterGstHelper";
import ToastificationContent from "@core/components/toastification/ToastificationContent";
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
        ValidationProvider
    },
    props: {
        salesReturnData: {
            type: Object
        }
    },
    setup(props, {emit, cancelIrnModal}) {
        const toast = useToast();
        const copySelection = ref('');
        const currentSalesReturnData = computed(() => props.salesReturnData);
        const currentSalesReturnId = router.currentRoute.params.id;
        cancelIrnModal = ref()

        const generateEInvoice = async () => {
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
                    axios.get(`/api/get-sales-return-final-amount-items/${currentSalesReturnId}`).then((res) => {
                        generateMasterGstInvoice(res.data);
                    });
                } else {
                    toast({
                        component: ToastificationContent,
                        position: 'top-right',
                        props: {
                            title: 'Abort',
                            icon: 'AlertCircleIcon',
                            variant: 'warning',
                            text: 'The task is Abort.'
                        }
                    });
                }
            });
        }

        const generateMasterGstInvoice = async (itemData) => {
            let authToken, masterCompanyDetail = currentSalesReturnData.value.company_detail;

            await axios.get(`${MASTER_API_BASE_URL}/einvoice/authenticate?email=${masterCompanyDetail.ewayEmail}`, {
                headers: {
                    username: masterCompanyDetail.ewayUsername,
                    password: masterCompanyDetail.ewayPassword,
                    ip_address: MASTER_GST_IP_ADDRESS,
                    client_id: masterCompanyDetail.ewayClientId,
                    client_secret: masterCompanyDetail.ewayClientSecret,
                    gstin: masterCompanyDetail.ewayGstin
                }
            })
                .then((res) => {
                    authToken = res.data.data.AuthToken
                }).catch(() => {
                    toast({
                        component: ToastificationContent,
                        position: 'top-right',
                        props: {
                            title: 'MasterGST Server Issue',
                            icon: 'AlertCircleIcon',
                            variant: 'danger',
                            text: 'Master GST Authentication Failed.'
                        }
                    });
                });

            if (authToken) {
                let data = {
                    "Version": "1.1",
                    "TranDtls": {
                        "TaxSch": "GST",
                        "SupTyp": 'B2B',
                        "RegRev": "N",
                        "EcmGstin": null,
                        "IgstOnIntra": "N"
                    },
                    "DocDtls": {
                        "Typ": "CRN",
                        "No": currentSalesReturnData.value.salesReturnNo,
                        "Dt": currentSalesReturnData.value.salesReturnDate
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
                    "SellerDtls": {
                        "Gstin": masterCompanyDetail.ewayGstin,
                        "LglNm": masterCompanyDetail.companyName,
                        "TrdNm": masterCompanyDetail.companyName,
                        "Addr1": masterCompanyDetail.address.substring(0, 100),
                        "Loc": masterCompanyDetail.city_data.city.toUpperCase(),
                        "Pin": parseInt(masterCompanyDetail.pinCode),
                        "Stcd": masterCompanyDetail.state_data.stateCode,
                    },
                    "BuyerDtls": {
                        "Gstin": currentSalesReturnData.value.buyerDetails.buyerGstinNo,
                        "LglNm": currentSalesReturnData.value.buyerDetails.buyerName,
                        "TrdNm": currentSalesReturnData.value.buyerDetails.buyerName,
                        "Pos": currentSalesReturnData.value.buyerDetails.buyerStateCode,
                        "Addr1": currentSalesReturnData.value.buyerDetails.buyerAddress.substring(0, 100),
                        "Loc": currentSalesReturnData.value.buyerDetails.buyerCityName.toUpperCase(),
                        "Pin": parseInt(currentSalesReturnData.value.buyerDetails.buyerPinCode),
                        "Stcd": currentSalesReturnData.value.buyerDetails.buyerStateCode,
                    },
                    "DispDtls": {
                        "Nm": masterCompanyDetail.companyName,
                        "Addr1": masterCompanyDetail.address.substring(0, 100),
                        "Loc": masterCompanyDetail.city_data.city.toUpperCase(),
                        "Pin": parseInt(masterCompanyDetail.pinCode),
                        "Stcd": masterCompanyDetail.state_data.stateCode
                    },
                    "ShipDtls": {
                        "Gstin": currentSalesReturnData.value.buyerDetails.buyerGstinNo,
                        "LglNm": currentSalesReturnData.value.buyerDetails.buyerName,
                        "Addr1": currentSalesReturnData.value.buyerDetails.buyerAddress.substring(0, 100),
                        "Loc": currentSalesReturnData.value.buyerDetails.buyerCityName.toUpperCase(),
                        "Pin": parseInt(currentSalesReturnData.value.buyerDetails.buyerPinCode),
                        "Stcd": currentSalesReturnData.value.buyerDetails.buyerStateCode,
                    },
                    "ItemList": itemData.itemList,
                    "ValDtls": itemData.itemValueDetail,
                }

                await axios.post(`${MASTER_API_BASE_URL}/einvoice/type/GENERATE/version/V1_03?email=${masterCompanyDetail.ewayEmail}`, data, {
                    headers: {
                        client_id: masterCompanyDetail.ewayClientId,
                        client_secret: masterCompanyDetail.ewayClientSecret,
                        username: masterCompanyDetail.ewayUsername,
                        'auth-token': authToken,
                        ip_address: MASTER_GST_IP_ADDRESS,
                        gstin: masterCompanyDetail.ewayGstin
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
                            salesReturnId: router.currentRoute.params.id,
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
                            emit('refreshData', true);
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
                });
            }
        }

        const cancelReasonOptions = ref([
            {label: 'Duplicate', value: '1'},
            {label: 'Data entry mistake', value: '2'},
            {label: 'Order Cancelled', value: '3'},
            {label: 'Others', value: '4'},
        ])

        const cancelBlankFormData = {
            irnNumber: null,
            cancelReason: null,
            cancelRemark: null
        }

        const cancelFormData = ref(JSON.parse(JSON.stringify(cancelBlankFormData)))

        const resetCancelFormData = () => {
            cancelFormData.value = JSON.parse(JSON.stringify(cancelBlankFormData))
        }

        const cancelIrn = async () => {
            cancelFormData.value.irnNumber = currentSalesReturnData.value.master_gst.Irn ?? null
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
                    generateCancelIrnRequest()
                } else {
                    resetCancelFormData();
                }
                cancelIrnModal.value.hide();
            });
        }

        const generateCancelIrnRequest = async () => {
            let authToken, masterCompanyDetail = currentSalesReturnData.value.company_detail, data = {
                Irn: cancelFormData.value.irnNumber,
                CnlRsn: cancelFormData.value.cancelReason,
                CnlRem: cancelFormData.value.cancelRemark,
            };
            await axios.get(MASTER_API_BASE_URL + '/einvoice/authenticate?email=' + masterCompanyDetail.ewayEmail, {
                headers: {
                    username: masterCompanyDetail.ewayUsername,
                    password: masterCompanyDetail.ewayPassword,
                    ip_address: MASTER_GST_IP_ADDRESS,
                    client_id: masterCompanyDetail.ewayClientId,
                    client_secret: masterCompanyDetail.ewayClientSecret,
                    gstin: masterCompanyDetail.ewayGstin
                }
            }).then((res) => {
                authToken = res.data.data.AuthToken
            }).catch(() => {
                toast({
                    component: ToastificationContent,
                    position: 'top-right',
                    props: {
                        title: 'MasterGST Server Issue',
                        icon: 'AlertCircleIcon',
                        variant: 'danger',
                        text: 'Master GST Authentication Failed.'
                    }
                });
            });

            if (authToken) {
                await axios.post(`${MASTER_API_BASE_URL}​/einvoice/type/CANCEL/version/V1_03/?email=${MASTER_GST_EMAIL}`, data, {
                    headers: {
                        ip_address: MASTER_GST_IP_ADDRESS,
                        client_id: masterCompanyDetail.ewayClientId,
                        client_secret: masterCompanyDetail.ewayClientSecret,
                        username: masterCompanyDetail.ewayUsername,
                        'auth-token': authToken,
                        gstin: masterCompanyDetail.ewayGstin
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
                        axios.post('/api/master-gst/cancel-irn-ebill-details', {
                            salesReturnId: router.currentRoute.params.id,
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
                    resetCancelFormData();
                }).catch(() => {
                    toast({
                        component: ToastificationContent,
                        position: 'top-right',
                        props: {
                            title: 'Error',
                            icon: 'AlertCircleIcon',
                            variant: 'danger',
                            text: 'Master GST Server Issue Cancel EInvoice.',
                        },
                    });
                });
            }
        }

        const previewButton = ref({
            buttonName: 'Preview E-Invoice',
            buttonDisabled: false,
        });

        const generatePdf = async () => {
            previewButton.value.buttonName = 'Please wait...';
            previewButton.value.buttonDisabled = true;
            await axios.post('/pdf/generate-credit-note-invoice', {salesReturnId: currentSalesReturnId})
                .then((res) => {
                    if (res.data){
                        window.open(res.data.path,'_blank')
                    }
                });
            previewButton.value.buttonName = 'Preview E-Invoice';
            previewButton.value.buttonDisabled = false;
        }

        const {refFormObserver, getValidationState, resetForm} = formValidation(resetCancelFormData)

        return {
            copySelection,
            currentSalesReturnData,
            currentSalesReturnId,
            previewButton,
            cancelIrnModal,
            generateEInvoice,
            generateMasterGstInvoice,
            cancelReasonOptions,
            cancelBlankFormData,
            cancelFormData,
            resetCancelFormData,
            cancelIrn,
            cancelIrnFormSubmit,
            generatePdf,

            //Validation Area
            refFormObserver,
            getValidationState,
            resetForm,
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
