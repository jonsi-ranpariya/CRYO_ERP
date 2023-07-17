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
                                    name="GRN No"
                                    rules="required"
                                >
                                    <b-form-group
                                        label="GRN No"
                                        label-for="grnNo"
                                    >
                                        <b-input-group>
                                            <b-form-input
                                                id="grnNo"
                                                :state="getValidationState(validationContext)"
                                                v-model="formData.grnNo"
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
                                    name="GRN Date"
                                    rules="required"
                                >
                                <b-form-group
                                    label="GRN Date"
                                    label-for="grnDate"
                                >
                                    <b-input-group>
                                        <cleave
                                            id="grnDate"
                                            v-model="formData.grnDate"
                                            class="form-control"
                                            :raw="false"
                                            :options="dateFormat"
                                            placeholder="DD/MM/YYYY"
                                            show-decade-nav
                                        />
                                        <b-input-group-append>
                                            <b-form-datepicker
                                                v-model="formatDates.grnDate"
                                                button-only
                                                @input="getJobWorkScrapFormateDate($event)"
                                                show-decade-nav
                                                size="sm"
                                                nav-button-variant="primary"
                                            />
                                        </b-input-group-append>
                                    </b-input-group>
                                </b-form-group>
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </validation-provider>
                            </b-col>
                        </b-row>
                        <validation-provider
                            #default="validationContext"
                            name="Item Code"
                            rules="required"
                        >
                            <b-form-group
                                label="Item Code"
                                label-for="itemCode"
                            >
                                    <b-form-input
                                        id="itemCode"
                                        :state="getValidationState(validationContext)"
                                        v-model="formData.itemCode"
                                    />
                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                        <validation-provider
                            #default="validationContext"
                            name="Item Description"
                            rules="required"
                        >
                            <b-form-group
                                label="Item Description"
                                label-for="itemDescription"
                                :state="getValidationState(validationContext)"
                            >
                                <b-form-input
                                    v-model="formData.itemDescription"
                                    id="itemDescription"
                                    :state="getValidationState(validationContext)"
                                />
                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                        <b-row>
                            <b-col md="6">
                                <b-form-group
                                    label="Add Description"
                                    label-for="addDescription"
                                >
                                    <b-form-textarea
                                        id="addDescription"
                                        rows="2"
                                        v-model="formData.itemAddDescription"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Detail Description"
                                    label-for="detailDescription"
                                >
                                    <b-form-textarea
                                        id="detailDescription"
                                        readonly
                                        rows="2"
                                        v-model="formData.itemDetailDescription"
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="6">
                                <b-form-group
                                    label="Drawing No."
                                    label-for="itemDrawingNo"
                                >
                                    <b-form-input
                                        id="itemDrawingNo"
                                        readonly
                                        v-model="formData.itemDrawingNo"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Drawing Revision"
                                    label-for="itemRevision"
                                >
                                    <b-form-input
                                        id="itemRevision"
                                        readonly
                                        v-model="formData.itemRevision"
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-form-group
                            label="UOM"
                            label-for="uom"
                        >
                            <v-select
                                v-model="formData.itemUom"
                                placeholder="Select uom"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="uomOption"
                                :reduce="val => val.value"
                                :clearable="false"
                                input-id="uom"
                            />
                        </b-form-group>
                        <b-row>
                            <b-col md="6">
                                <b-form-group
                                    label="Sub-Contractor Code"
                                    label-for="subContractor"
                                >
                                    <v-select
                                        placeholder="Select Code"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="subContractorOptions"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        input-id="subContractorCode"
                                        v-model="formData.subContractor"
                                        @input="getSubContrctorDetails($event)"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Sub-Contractor Name"
                                    label-for="subContractorName"
                                >
                                    <b-form-input
                                        id="subContractorName"
                                        readonly
                                        v-model="formData.subContractorName"
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>
                    </b-col>
                    <b-col md="6">
                        <b-form-group
                            label="Job Work No"
                            label-for="jobWorkNo"
                        >
                            <b-form-input
                                id="jobWorkNo"
                                v-model="formData.itemJobWorkNo"
                            />
                        </b-form-group>
                        <b-row>
                            <b-col md="6">
                                <b-form-group
                                    label="Challan Date"
                                    label-for="challanDate"
                                >
                                    <b-input-group>
                                        <b-input-group-prepend>
                                            <b-form-datepicker
                                                v-model="formatDates.challanDate"
                                                button-only
                                                @input="getJobWorkChallanFormateDate($event)"
                                                show-decade-nav
                                                size="sm"
                                                nav-button-variant="primary"
                                            />
                                        </b-input-group-prepend>
                                        <cleave
                                            id="challanDate"
                                            v-model="formData.challanDate"
                                            class="form-control"
                                            :raw="false"
                                            :options="dateFormat"
                                            placeholder="DD/MM/YYYY"
                                            show-decade-nav
                                        />
                                    </b-input-group>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Challan No"
                                    label-for="challanNo"
                                >
                                    <b-form-input
                                        id="challanNo"
                                        v-model="formData.challanNo"
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-form-group
                            label="Challan Qty"
                            label-for="challanQty"
                        >
                            <b-form-input
                                id="challanQty"
                                v-model="formData.challanQty"
                            />
                        </b-form-group>
                        <b-row>
                            <b-col md="12">
                                <hr>
                                <h5>Scrap Details</h5>
                                <hr>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="4">
                                <b-form-group
                                    label="Expected Scrap"
                                    label-for="expectedScrap"
                                >
                                    <b-form-input
                                        id="expectedScrap"
                                        v-model="formData.expectedScrap"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group
                                    label="Scrap Received"
                                    label-for="scrapReceived"
                                >
                                    <b-form-input
                                        id="scrapReceived"
                                        v-model="formData.scrapReceived"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group
                                    label="Rate"
                                    label-for="rate"
                                >
                                    <b-form-input
                                        id="rate"
                                        v-model="formData.rate"
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="8">
                                <b-form-group
                                    label="Scrap Code"
                                    label-for="scrapCode"
                                >
                                    <v-select
                                        placeholder="Select Code"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="scrapCodeOption"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        input-id="scrapCode"
                                        @input="getScrapDetails($event)"
                                        v-model="formData.scrapCode"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group
                                    label="Scrap Name"
                                    label-for="scrapName"
                                >
                                    <b-form-input
                                        id="scrapName"
                                        readonly
                                        v-model="formData.scrapName"
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>
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

    <!--Wo Modal-->
    <b-modal
        id="scrapreceiptModal"
        title="Select Item"
        size="xl"
        no-close-on-backdrop
        ref="scrapreceiptModal"
        scrollable
        cancel-variant="danger"
    >
        <b-row>
            <b-col md="12">
                <hr>
                <b-table
                    responsive
                    :fields="modalTable.scrapFields"
                    :items="modalTable.scrapData"
                    :bordered="true"
                    :hover="true"
                    show-empty
                    class="table_scroll"
                >
                    <!-- Loader -->
                    <template #table-busy>
                        <div class="text-center my-2">
                            <b-spinner class="align-middle"></b-spinner>
                            <strong>Loading...</strong>
                        </div>
                    </template>
                    <!--button-->
                    <template #cell(selectButton)="data">
                        <b-button
                            type="button"
                            size="sm"
                            variant="primary"
                            @click="getScrapEntryDetails(data.item)"
                        >
                            Select

                        </b-button>
                    </template>
                </b-table>
            </b-col>
        </b-row>
    </b-modal>
</div>
</template>
<script>
    import BCardCode from "../../../@core/components/b-card-code/BCardCode";
    import {
        BForm,
        BRow,
        BCol,
        BFormGroup,
        BFormInput,
        BInputGroup,
        BInputGroupAppend,
        BFormInvalidFeedback,
        BButton,
        BFormDatepicker,
        BFormTextarea,
        BInputGroupPrepend,
        BTable
    } from 'bootstrap-vue'
    import {ValidationObserver,ValidationProvider} from 'vee-validate'
    import formValidation from "../../../@core/comp-functions/forms/form-validation";
    import {onUnmounted, ref} from "@vue/composition-api";
    import {required} from "@validations"
    import axios from '@axios'
    import vSelect from 'vue-select'
    import router from '@/router'
    import {useToast} from "vue-toastification/composition";
    import jobWorkStoreModule from "../jobWorkStoreModule";
    import store from '@/store'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import {forMatIndianDate} from "../../../@core/utils/utils";
    import Cleave from 'vue-cleave-component'
    export default {
        components: {
            BCardCode,
            ValidationObserver,
            ValidationProvider,
            BForm,
            BRow,
            BCol,
            BFormGroup,
            BFormInput,
            BInputGroup,
            BInputGroupAppend,
            BFormInvalidFeedback,
            BButton,
            BFormDatepicker,
            BFormTextarea,
            vSelect,
            BTable,
            Cleave,
            BInputGroupPrepend
        },
        setup({scrapreceiptModal}){
            scrapreceiptModal =ref()

            const toast = useToast()
            const ITEMADDON_APP_STORE_MODULE_NAME = 'scrap-entry-store-module'
            if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, jobWorkStoreModule)
            onUnmounted(() => {
                if (store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.unregisterModule(ITEMADDON_APP_STORE_MODULE_NAME)
            })

            const dateFormat = ref({
                date: true,
                delimiter: '/',
                datePattern: ['d', 'm', 'Y'],
            })

            const formatDates = ref({
                grnDate: null,
                challanDate: null,
            })

            const getJobWorkScrapFormateDate = (date) => {
                formData.value.grnDate = forMatIndianDate(date)
            }
            const getJobWorkChallanFormateDate = (date) => {
                formData.value.challanDate = forMatIndianDate(date)
            }


            const uomOption = ref([])
            axios.get('/api/get-uom-master-options').then(res => {
                uomOption.value = res.data.data
            })
            const subContractorOptions = ref([])
            axios.get('/api/party/get-master-options').then(res => {
                subContractorOptions.value = res.data.data
            })
            const getSubContrctorDetails = async (id) => {
                await axios.get(`/api/party/edit/${id}`).then(res => {
                    formData.value.subContractorName = res.data.data?.partyName ?? null
                })
            }
            const scrapCodeOption = ref([])
            axios.get('/api/get-item-master-options').then(res => {
                scrapCodeOption.value = res.data.data
            })

            const getScrapDetails = async (id) => {
                await axios.get(`/api/item-master/${id}`).then(res => {
                    formData.value.scrapName = res.data.data?.itemDescription ?? null

                })
            }
            const modalTable = ref({
                scrapFields: [
                    {
                        key: 'selectButton',
                        label: ''
                    },
                    {
                        key: 'grnNo',
                        label: 'GRN No'
                    },
                    {
                        key: 'partyName',
                        label: 'Party Name'
                    },
                    {
                        key: 'itemCode',
                        label: 'Item Code'
                    },
                    {
                        key: 'itemDescription',
                        label: 'Item Description'
                    },
                    {
                        key: 'challanQty',
                        label: 'Challan Qty'
                    },
                    {
                        key: 'gsrNo',
                        label: 'GSR No'
                    },

                ],
                scrapData: [],
            })
            const openModal = async () => {
                axios.get('/api/new/receipt-job-work-challan').then(res => {
                    modalTable.value.scrapData = res.data.data
                })
                scrapreceiptModal.value.show();
            }
            const getScrapEntryDetails = async (data) => {
                formData.value.itemId = data.itemId
                formData.value.grnNo = data.grnNo
                formData.value.grnDate = data.grnDate
                formData.value.itemCode = data.itemCode
                formData.value.itemDescription = data.itemDescription
                formData.value.itemAddDescription = data.itemAddDescription
                formData.value.itemDetailDescription = data.itemDetailDescription
                formData.value.itemDrawingNo = data.itemDrawingNo
                formData.value.itemRevision = data.itemRevision
                formData.value.itemUom = data.itemUom
                formData.value.itemUom = data.itemUom
                formData.value.subContractorId = data.subContractorId
                formData.value.subContractor = data.subContractor
                formData.value.subContractorName = data.subContractorName
                formData.value.itemJobWorkNo = data.itemJobWorkNo
                formData.value.challanNo = data.challanNo
                formData.value.challanDate = data.challanDate
                formData.value.challanQty = data.challanQty
                scrapreceiptModal.value.hide()
            }
            const blankFormData = {
                grnNo:null,
                grnDate:forMatIndianDate(),
                itemId:null,
                itemCode:null,
                itemDescription:null,
                itemAddDescription:null,
                itemDetailDescription:null,
                itemDrawingNo:null,
                itemRevision:null,
                itemUom:null,
                subContractorId:null,
                subContractor:null,
                subContractorName:null,
                itemJobWorkNo:null,
                challanNo:null,
                challanDate:forMatIndianDate(),
                challanQty:null,
                expectedScrap:null,
                scrapReceived:null,
                rate:null,
                scrapCode:null,
                scrapName:null,
            }
            const formData = ref(JSON.parse(JSON.stringify(blankFormData)))

            const resetFormData = () => {
                formData.value = JSON.parse(JSON.stringify(blankFormData))
            }
            const saveFormData = async () => {
                await store.dispatch('scrap-entry-store-module/addScrapReceiptEntry', formData.value).then(res => {
                    if (res.status === 200) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Scarp Receipt Entry Added',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: `You have successfully Added Scrap Entry.`,
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
                        name: 'edit-scrap-receipt-entry',  params: {
                            id: res.data.data._id
                        }
                    })
                })
            }
            const {refFormObserver, getValidationState, resetForm} = formValidation(resetFormData)
            return{
                formData,
                refFormObserver,
                getValidationState,
                resetForm,
                resetFormData,
                required,
                uomOption,
                subContractorOptions,
                scrapCodeOption,
                getScrapDetails,
                getSubContrctorDetails,
                modalTable,
                openModal,
                scrapreceiptModal,
                getScrapEntryDetails,
                saveFormData,
                dateFormat,
                formatDates,
                getJobWorkScrapFormateDate,
                getJobWorkChallanFormateDate
            }
        }
    }
</script>

