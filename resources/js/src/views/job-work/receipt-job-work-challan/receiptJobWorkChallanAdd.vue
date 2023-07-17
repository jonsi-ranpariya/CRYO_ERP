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
                                        name="Party Code"
                                        rules="required"
                                    >
                                        <b-form-group
                                            label="Party Code"
                                            label-for="pcPartyCode"
                                        >
                                            <v-select
                                                placeholder="Select Code"
                                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                                :options="partyCodeOPtion"
                                                :reduce="val => val.value"
                                                :clearable="false"
                                                input-id="pcPartyCode"
                                                v-model="formData.partyCode"
                                                @input="getPartyDetails($event)"
                                                :state="getValidationState(validationContext)"
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
                                        name="Party Name"
                                        rules="required"
                                    >
                                        <b-form-group
                                            label="Party Name"
                                            label-for="partyName"
                                        >
                                            <b-form-input
                                                id="partyName"
                                                v-model="formData.partyName"
                                                :state="getValidationState(validationContext)"
                                            />
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
                                    <b-input-group>
                                        <b-form-input
                                            id="itemCode"
                                            :state="getValidationState(validationContext)"
                                            v-model="formData.itemCode"
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
                            <b-row>
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
                                </b-col>
                                <b-col md="6">
                                    <b-form-group
                                        label="Job Card No"
                                        label-for="jobCardNo"
                                    >
                                        <b-form-input
                                            id="jobCardNo"
                                            v-model="formData.itemJobCardNo"
                                        />
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-form-group
                                label="WO.No."
                                label-for="itemWoNumber"
                            >
                                <b-form-input
                                    id="itemWoNumber"
                                    v-model="formData.itemWoNumber"
                                />
                            </b-form-group>
                            <b-row>
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
                                                    @input="getJobChallanFormateDate($event)"
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
                                        label="GIR No"
                                        label-for="girNo"
                                    >
                                        <b-form-input
                                            id="girNo"
                                            v-model="formData.girNo"
                                        />
                                    </b-form-group>
                                </b-col>
                                <b-col md="6">
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
                                                    @input="getJobGirFormateDate($event)"
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
                        <b-col md="6">
                            <b-form-group
                                label="Item Make"
                                label-for="itemMake"
                            >
                                <v-select
                                    :clearable="false"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="makeOption"
                                    :reduce="(val) => val.value"
                                    input-id="itemMake"
                                    multiple
                                    placeholder="Select Make"
                                    push-tags
                                    taggable
                                    v-model="formData.itemMake"
                                />
                            </b-form-group>
                            <b-form-group
                                label="Store"
                                label-for="itemStore"
                            >
                                <v-select
                                    :clearable="false"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="storeOption"
                                    :reduce="(val) => val.value"
                                    input-id="itemStore"
                                    placeholder="Select Store"
                                    v-model="formData.itemStore"
                                />
                            </b-form-group>
                            <b-form-group
                                label="Receipt Note"
                                label-for="receiptNote"
                            >
                                <b-form-input
                                    id="receiptNote"
                                    v-model="formData.receiptNote"
                                />
                            </b-form-group>
                            <b-row>
                                <b-col md="6">
                                    <b-form-group
                                        label="Job Qty"
                                        label-for="jobQty"
                                    >
                                        <b-form-input
                                            v-model="formData.jobQty"
                                            id="jobQty"
                                        />
                                    </b-form-group>
                                </b-col>
                                <b-col md="6">
                                    <b-form-group
                                        label="Pending Job Qty"
                                        label-for="pendingJobQty"
                                    >
                                        <b-form-input
                                            v-model="formData.pendingJobQty"
                                            id="pendingJobQty"
                                        />
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-form-group
                                label="Challan Qty"
                                label-for="challanQty"
                            >
                                <b-form-input
                                    v-model="formData.challanQty"
                                    id="challanQty"
                                />
                            </b-form-group>
                            <b-row>
                                <b-col md="6">
                                    <b-form-group
                                        label="GRN Date"
                                        label-for="grnDate"
                                    >
                                        <b-input-group>
                                            <b-input-group-prepend>
                                                <b-form-datepicker
                                                    v-model="formatDates.grnDate"
                                                    button-only
                                                    @input="getJobGrnFormateDate($event)"
                                                    show-decade-nav
                                                    size="sm"
                                                    nav-button-variant="primary"
                                                />
                                            </b-input-group-prepend>
                                            <cleave
                                                id="grnDate"
                                                v-model="formData.grnDate"
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
                                        label="GRN No"
                                        label-for="grnNo"
                                    >
                                        <b-form-input
                                            id="grnNo"
                                            v-model="formData.grnNo"
                                        />
                                    </b-form-group>
                                </b-col>
                            </b-row>
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
                                <b-col md="6">
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
                                <b-col md="6">
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
            id="jobWorkProcessModal"
            title="Select Item"
            size="xl"
            no-close-on-backdrop
            ref="jobWorkProcessModal"
            scrollable
            cancel-variant="danger"
        >
            <b-row>
                <b-col md="12">
                    <hr>
                    <b-table
                        responsive
                        :fields="modalTable.jobWorkFields"
                        :items="modalTable.jobWorkData"
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
                                @click="getJobWorkDetails(data.item._id)"
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
import  BCardCode from '@core/components/b-card-code/BCardCode'
import { ValidationObserver, ValidationProvider } from 'vee-validate'
import vSelect from 'vue-select'
import axios from '@axios'
import { required } from '@validations'
import Cleave from 'vue-cleave-component'
import {
    BForm,
    BRow,
    BCol,
    BFormGroup,
    BFormInput,
    BFormInvalidFeedback,
    BFormTextarea,
    BFormDatepicker,
    BButton,
    BInputGroupAppend,
    BInputGroup,
    BTable,
    BInputGroupPrepend
} from 'bootstrap-vue'
import { onUnmounted, ref } from '@vue/composition-api'
import formValidation from '@core/comp-functions/forms/form-validation'
import router from '@/router'
import { getUserData } from '../../../auth/utils'
import moment from 'moment'
import { useToast } from 'vue-toastification/composition'
import jobWorkStoreModule from '../jobWorkStoreModule'
import store from '@/store'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
import { forMatIndianDate, getTcTodayDate } from '@core/utils/utils'

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
        vSelect,
        BFormInvalidFeedback,
        BFormTextarea,
        BFormDatepicker,
        BButton,
        BInputGroupAppend,
        BInputGroup,
        BTable,
        Cleave,
        BInputGroupPrepend
    },
    setup({ jobWorkProcessModal }) {
        const toast = useToast()
        const ITEMADDON_APP_STORE_MODULE_NAME = 'receipt-job-challan-store-module'
        if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, jobWorkStoreModule)
        onUnmounted(() => {
            if (store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.unregisterModule(ITEMADDON_APP_STORE_MODULE_NAME)
        })

        jobWorkProcessModal = ref()

        const partyCodeOPtion = ref([])
        axios.get('/api/party/get-master-options')
            .then(res => {
                partyCodeOPtion.value = res.data.data
            })

        const scrapCodeOption = ref([])
        axios.get('/api/get-item-job-order-option')
            .then(res => {
                scrapCodeOption.value = res.data.data
            })

        const subContractorOptions = ref([])
        axios.get('/api/party/get-master-options')
            .then(res => {
                subContractorOptions.value = res.data.data
            })

        const uomOption = ref([])
        axios.get('/api/get-uom-master-options')
            .then(res => {
                uomOption.value = res.data.data
            })
        const makeOption = ref([])
        axios.get('/api/get-item-make-master-options')
            .then(res => {
                makeOption.value = res.data.data
            })
        const storeOption = ref([])
        axios.get('/api/get-store-master-options')
            .then((res) => {
                storeOption.value = res.data.data
            })

        const dateFormat = ref({
            date: true,
            delimiter: '/',
            datePattern: ['d', 'm', 'Y'],
        })

        const formatDates = ref({
            challanDate: null,
            girDate: null,
            grnDate: null,
        })

        const getJobChallanFormateDate = (date) => {
            formData.value.challanDate = forMatIndianDate(date)
        }

        const getJobGirFormateDate = (date) => {
            formData.value.girDate = forMatIndianDate(date)
        }
        const getJobGrnFormateDate = (date) => {
            formData.value.grnDate = forMatIndianDate(date)
        }
        const CurrentUserData = ref(getUserData())

        const blankFormData = {
            partyCode: null,
            partyName: null,
            subContractorId:null,
            itemId:null,
            itemCode: null,
            itemDescription: null,
            itemAddDescription: null,
            itemDetailDescription: null,
            itemDrawingNo: null,
            itemRevision: null,
            itemUom: null,
            subContractor: null,
            subContractorName: null,
            itemJobWorkNo: null,
            itemJobCardNo: null,
            itemWoNumber: null,
            challanNo: null,
            challanDate: forMatIndianDate(getTcTodayDate()),
            girNo: null,
            girDate: forMatIndianDate(getTcTodayDate()),
            itemMake: null,
            itemStore: null,
            receiptNote: null,
            jobQty: null,
            pendingJobQty: null,
            challanQty: null,
            grnNo: null,
            grnDate: forMatIndianDate(getTcTodayDate()),
            expectedScrap: null,
            scrapReceived: null,
            scrapCode: null,
            scrapName: null,
            rate: null,
            loginDetails: {
                createdBy: CurrentUserData.value.first_name + ' ' + CurrentUserData.value.last_name,
                dateTime: moment(new Date()).format('DD/MM/YYYY HH:mm'),
                lastModifiedBy: null,
                modifiedDateTime: null,
            },
        }

        const modalTable = ref({
            jobWorkFields: [
                {
                    key: 'selectButton',
                    label: ''
                },
                {
                    key: 'job_work_details.subContractorCode',
                    label: 'Party Code'
                },
                {
                    key: 'job_work_details.subContractorName',
                    label: 'Party Name'
                },
                {
                    key: 'job_work_details.jobWorkNo',
                    label: 'Job Work No'
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
                    key: 'itemPendingQty',
                    label: 'Pending Qty'
                },
                {
                    key: 'itemJobWorkQty',
                    label: 'Job Qty'
                },
                {
                    key: 'process_details.processName',
                    label: 'Process'
                },
                {
                    key: 'itemJobCardNumber',
                    label: 'Job Card No'
                },
                {
                    key: 'itemDrawingNumber',
                    label: 'Drawing No'
                },

            ],
            jobWorkData: [],
        })

        const getScrapDetails = async (id) => {
            await axios.get(`/api/job-work-order-item/${id}`)
                .then(res => {
                    formData.value.scrapName = res.data.data?.itemDescription ?? null

                })
        }
        const getPartyDetails = async (id) => {
            await axios.get(`/api/party/edit/${id}`)
                .then(res => {
                    formData.value.partyName = res.data.data?.partyName ?? null
                })
        }

        const getSubContrctorDetails = async (id) => {
            await axios.get(`/api/party/edit/${id}`)
                .then(res => {
                    formData.value.subContractorName = res.data.data?.partyName ?? null
                })
        }

        const openModal = async () => {
            await axios.get('/api/job-work-order-item')
                .then(res => {
                    modalTable.value.jobWorkData = res.data.data
                })
            jobWorkProcessModal.value.show()
        }

        const getJobWorkDetails = async (id) => {
            await axios.get(`/api/job-work-order-item/${id}`).then((res) => {
                formData.value.itemId = res.data.data.itemId
                formData.value.itemCode = res.data.data.itemCode
                formData.value.itemDescription = res.data.data.itemDescription
                formData.value.itemAddDescription = res.data.data.itemAddDescription
                formData.value.itemDetailDescription = res.data.data.itemDetailDescription
                formData.value.itemDrawingNo = res.data.data.itemDrawingNumber
                formData.value.itemRevision = res.data.data.itemDrawingRevision
                formData.value.itemUom = res.data.data.uom_details.uom
                formData.value.itemJobCardNo = res.data.data.itemJobCardNumber
                formData.value.itemWoNumber = res.data.data.itemWoNumber
                formData.value.jobQty = res.data.data.itemJobWorkQty
                formData.value.pendingJobQty = res.data.data.itemPendingQty
                formData.value.subContractorId = res.data.data?.job_work_details?.subContractorId ?? null
                formData.value.subContractor = res.data.data?.job_work_details?.subContractorId ?? null
                formData.value.subContractorName = res.data.data?.job_work_details?.subContractorName ?? null
                formData.value.itemJobWorkNo = res.data.data?.job_work_details?.jobWorkNo ?? null
            })
            jobWorkProcessModal.value.hide()
        }

        const formData = ref(JSON.parse(JSON.stringify(blankFormData)))

        const resetFormData = () => {
            formData.value = JSON.parse(JSON.stringify(blankFormData))
        }

        const saveFormData = async () => {
            await store.dispatch('receipt-job-challan-store-module/addReceiptJobWorkChallan', formData.value)
                .then(res => {
                    if (res.status === 200) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Receipt Job Work Challan Added',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: `You have successfully Added Receipt Job Work Challan.`,
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
                        name: 'edit-receipt-job-work-challan',
                        params: {
                            id: res.data.data._id
                        }
                    })
                })
        }

        const {
            refFormObserver,
            getValidationState,
            resetForm
        } = formValidation(resetFormData)

        return {
            formData,
            refFormObserver,
            getValidationState,
            resetForm,
            saveFormData,
            resetFormData,
            uomOption,
            makeOption,
            storeOption,
            required,
            openModal,
            modalTable,
            jobWorkProcessModal,
            partyCodeOPtion,
            getPartyDetails,
            getJobWorkDetails,
            getSubContrctorDetails,
            subContractorOptions,
            scrapCodeOption,
            getScrapDetails,
            dateFormat,
            formatDates,
            getJobChallanFormateDate,
            getJobGirFormateDate,
            getJobGrnFormateDate
        }
    }
}
</script>
