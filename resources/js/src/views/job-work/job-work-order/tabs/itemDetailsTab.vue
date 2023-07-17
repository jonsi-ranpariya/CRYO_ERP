<template>
    <div>
        <!--table -->
        <b-row>
            <b-col md="12">
                <b-table
                    :fields="table.fields"
                    :items="table.data"
                    responsive
                    class="mb-0 table_scroll"
                    bordered
                    hover
                    show-empty
                    :busy="isBusy"
                    selectable
                    select-mode="single"
                    @row-selected="onRowSelected"
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
                            variant="link"
                            toggle-class="text-decoration-none"
                            no-caret
                        >
                            <template v-slot:button-content>
                                <feather-icon
                                    icon="MoreVerticalIcon"
                                    size="16"
                                    class="text-body align-middle mr-25"
                                />
                            </template>
                            <b-dropdown-item @click="deleteItemDetails(data.item._id)">
                                <feather-icon
                                    icon="TrashIcon"
                                    class="mr-50"
                                />
                                <span>Delete</span>
                            </b-dropdown-item>
                        </b-dropdown>
                    </template>

                    <!--  select row  -->
                    <template #cell(rowSelected)="{ rowSelected }">
                        <template v-if="rowSelected">
                            <span aria-hidden="true">&check;</span>
                            <span class="sr-only">Selected</span>
                        </template>
                        <template v-else>
                            <span aria-hidden="true">&nbsp;</span>
                            <span class="sr-only">Not selected</span>
                        </template>
                    </template>

                </b-table>
                <hr>
            </b-col>
        </b-row>
        <!--table Close-->
        <validation-observer #default="{ handleSubmit }">
            <b-form @submit.prevent="handleSubmit(saveFormData)">
                <b-row>
                    <b-col md="6">
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
                                    readonly
                                />
                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                        <b-form-group
                            label="Alice"
                            label-for="itemAlice"
                        >
                            <b-form-input
                                id="itemAlice"
                                v-model="formData.itemAlice"
                            />
                        </b-form-group>
                        <b-form-group
                            label="Add. Description"
                            label-for="addDescription"
                        >
                            <b-form-input
                                id="addDescription"
                                v-model="formData.itemAddDescription"
                            />
                        </b-form-group>
                        <b-form-group
                            label="Detail Description"
                            label-for="detailDescription"
                        >
                            <b-form-textarea
                                v-model="formData.itemDetailDescription"
                                id="detailDescription"
                                rows="2"
                            />
                        </b-form-group>
                        <b-row>
                            <b-col md="6">
                                <b-form-group
                                    label="Drawing Number"
                                    label-for="itemDrawingNumber"
                                >
                                    <b-form-input
                                        v-model="formData.itemDrawingNumber"
                                        id="itemDrawingNumber"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Drawing Revision"
                                    label-for="itemDrawingRevision"
                                >
                                    <b-form-input
                                        v-model="formData.itemDrawingRevision"
                                        id="itemDrawingRevision"
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>

                        <b-row>
                            <b-col md="6">
                                <b-form-group
                                    label="UOM"
                                    label-for="uom"
                                >
                                    <v-select
                                        v-model="formData.itemUom"
                                        placeholder="Select Uom"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="uomOption"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        input-id="uom"
                                        disabled
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Conv. UOM"
                                    label-for="convUom"
                                >
                                    <v-select
                                        id="convUom"
                                        v-model="formData.itemConvUom"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="uomOptions"
                                        :clearable="false"
                                        :reduce="val => val.value"
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="6">
                                <b-form-group
                                    label="Conv Qty"
                                    label-for="convQty"
                                >
                                    <b-form-input
                                        id="convQty"
                                        v-model="formData.itemConvQty"
                                        type="number"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <validation-provider
                                    #default="validationContext"
                                    name="CFactor"
                                    rules="regex:^\d+\.?\d*$"
                                >
                                    <b-form-group
                                        label="CFactor"
                                        label-for="cFactor"
                                    >
                                        <b-form-input
                                            id="cFactor"
                                            v-model="formData.itemcFactor"
                                            :state="getValidationState(validationContext)"
                                        />
                                        <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                            {{ validationContext.errors[0] }}
                                        </b-form-invalid-feedback>
                                    </b-form-group>
                                </validation-provider>
                            </b-col>
                        </b-row>
                    </b-col>
                    <b-col md="6">
                        <b-form-group
                            label="Process"
                            label-for="itemProcess"
                        >
                            <v-select
                                placeholder="Select Process"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="processOption"
                                :reduce="val => val.value"
                                :clearable="false"
                                input-id="itemProcess"
                                v-model="formData.itemProcess"
                            />
                        </b-form-group>
                        <b-row>
                            <b-col md="6">
                                <b-form-group
                                    label="Process Rate"
                                    label-for="itemProcessRate"
                                >
                                    <b-form-input
                                        id="itemProcessRate"
                                        v-model="formData.itemProcessRate"
                                        @keyup="calculateJobRate"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Process Amt"
                                    label-for="itemProcessAmt"
                                >
                                    <b-form-input
                                        id="itemProcessAmt"
                                        v-model="formData.itemProcessAmt"
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-form-group
                            label="Process Note"
                            label-for="itemProcessNote"
                        >
                            <b-form-input
                                id="itemProcessNote"
                                v-model="formData.itemProcessNote"
                            />
                        </b-form-group>
                        <b-row>
                            <b-col md="6">
                                <b-form-group
                                    label="Job Card No"
                                    label-for="jobCardNumber"
                                >
                                    <b-form-input
                                        v-model="formData.itemJobCardNumber"
                                        id="jobCardNumber"
                                        type="number"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="W.O.No."
                                    label-for="woNumber"
                                >
                                    <b-form-input
                                        v-model="formData.itemWoNumber"
                                        id="woNumber"
                                        type="number"
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="6">
                                <b-form-group
                                    label="Delivery Date"
                                    label-for="delDate"
                                >
                                    <b-input-group>
                                        <cleave
                                            id="jobCardDate"
                                            v-model="formData.delDate"
                                            class="form-control"
                                            :raw="false"
                                            :options="dateFormat"
                                            placeholder="DD/MM/YYYY"
                                            show-decade-nav
                                        />
                                        <b-input-group-append>
                                            <b-form-datepicker
                                                v-model="formatDates.delDate"
                                                button-only
                                                @input="getJobWorkItemFormateDate($event)"
                                                show-decade-nav
                                                size="sm"
                                                nav-button-variant="primary"
                                            />
                                        </b-input-group-append>
                                    </b-input-group>
                                    <!--                                    <b-form-datepicker-->
                                    <!--                                        id="delDate"-->
                                    <!--                                        v-model="formData.itemDelDate"-->
                                    <!--                                        :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }"-->
                                    <!--                                        locale="in"-->
                                    <!--                                        class="mb-1"-->
                                    <!--                                    />-->
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Note"
                                    label-for="itemNote"
                                >
                                    <b-form-input
                                        v-model="formData.itemNote"
                                        id="itemNote"
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="6">
                                <b-form-group
                                    label="Job Work Qty"
                                    label-for="jobWorkQty"
                                >
                                    <b-form-input
                                        id="jobWorkQty"
                                        v-model="formData.itemJobWorkQty"
                                        @keyup="calculateJobRate"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Acct Qty"
                                    label-for="acctQty"
                                >
                                    <b-form-input
                                        id="acctQty"
                                        v-model="formData.itemAcctQty"
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="6">
                                <b-form-group
                                    label="Pending Qty"
                                    label-for="pendingQty"
                                >
                                    <b-form-input
                                        id="pendingQty"
                                        v-model="formData.itemPendingQty"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Rejected Qty"
                                    label-for="rejectedQty"
                                >
                                    <b-form-input
                                        id="rejectedQty"
                                        v-model="formData.itemRejectedQty"
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="6">
                                <b-form-group
                                    label="Basic Value"
                                    label-for="estValue"
                                >
                                    <b-form-input
                                        id="estValue"
                                        v-model="formData.itemEstValue"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="R/W Qty"
                                    label-for="rwQty"
                                >
                                    <b-form-input
                                        id="rwQty"
                                        v-model="formData.itemRwQty"
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-form-group
                            label="Internal Note"
                            label-for="internalNote"
                        >
                            <b-form-input
                                id="internalNote"
                                v-model="formData.itemInternalNote"
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

        <!--All Item Modal-->
        <b-modal
            id="itemMasterModal"
            title="Select Item Detail"
            ref="itemMasterModal"
            ok-title="submit"
            cancel-variant="danger"
            size="xl"
            no-close-on-backdrop
            @ok="saveItemMasterDetail"
            @cancel="resetModalData"
            @close="resetModalData"
        >
            <b-row>
                <b-col md="3">
                    <b-form-group
                        label="Item Code"
                        label-for="itemMasterCode"
                    >
                        <b-form-input
                            id="itemMasterCode"
                            v-model="searchData.itemCode"
                            @keyup="getItemMasterFilter"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="3">
                    <b-form-group
                        label="Item Description"
                        label-for="masterDescription"
                    >
                        <b-form-input
                            id="masterDescription"
                            v-model="searchData.itemDescription"
                            @keyup="getItemMasterFilter"
                        />

                    </b-form-group>
                </b-col>
                <b-col md="3">
                    <b-form-group
                        label="Detail Description"
                        label-for="masterDetailDescription"
                    >
                        <b-form-input
                            id="masterDetailDescription"
                            v-model="searchData.detailDescription"
                            @keyup="getItemMasterFilter"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="3">
                    <b-form-group
                        label="Drawing Number"
                        label-for="masterDrawingNumber"
                    >
                        <b-form-input
                            id="masterDrawingNumber"
                            v-model="searchData.drawingNumber"
                            @keyup="getItemMasterFilter"
                        />
                    </b-form-group>
                </b-col>
            </b-row>

            <b-table
                :fields="modalTableData.itemMasterFields"
                :items="modalTableData.itemMasterData"
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
                <!-- Checkbox -->
                <template #cell(selectCheckBox)="data">
                    <b-form-checkbox
                        :value="`${data.item._id}`"
                        class="custom-control-primary"
                        @change="selectedItemIds($event, data.item._id)"
                    />
                </template>
            </b-table>
        </b-modal>
    </div>
</template>
<script>
import {
    BForm,
    BRow,
    BCol,
    BFormGroup,
    BFormInvalidFeedback,
    BFormInput,
    BFormTextarea,
    BFormDatepicker,
    BButton,
    BTable,
    BDropdown,
    BDropdownItem,
    BSpinner,
    BInputGroup,
    BFormCheckbox,
    BInputGroupAppend,
} from 'bootstrap-vue'
import {ValidationObserver, ValidationProvider} from 'vee-validate'
import vSelect from 'vue-select'
import {onUnmounted, ref} from '@vue/composition-api'
import formValidation from "@core/comp-functions/forms/form-validation";
import {required, regex} from '@validations'
import axios from '@axios'
import router from '@/router'
import {useToast} from "vue-toastification/composition";
import jobWorkStoreModule from "../../jobWorkStoreModule";
import ToastificationContent from "@core/components/toastification/ToastificationContent";
import store from '@/store'
import Swal from "sweetalert2";
import Cleave from 'vue-cleave-component'
import {forMatIndianDate} from "@core/utils/utils";

export default {
    components: {
        ValidationObserver,
        ValidationProvider,
        vSelect,
        BForm,
        BRow,
        BCol,
        BFormGroup,
        BFormInvalidFeedback,
        BFormInput,
        BFormTextarea,
        BFormDatepicker,
        BButton,
        BTable,
        BSpinner,
        BDropdown,
        BDropdownItem,
        BInputGroup,
        BInputGroupAppend,
        BFormCheckbox,
        Cleave
    },
    setup({itemMasterModal}) {
        const toast = useToast()

        const ITEMADDON_APP_STORE_MODULE_NAME = 'job-work-item-store-module'
        if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, jobWorkStoreModule)
        onUnmounted(() => {
            if (store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.unregisterModule(ITEMADDON_APP_STORE_MODULE_NAME)
        })

        itemMasterModal = ref()
        const isModalTableBusy = ref(false)

        const itemCodeOPtion = ref([])
        axios.get('/api/get-item-master-options').then(res => {
            itemCodeOPtion.value = res.data.data
        })
        const uomOption = ref([])
        axios.get('/api/get-uom-master-options').then(res => {
            uomOption.value = res.data.data
        })
        const processOption = ref([])
        axios.get('/api/get-process-master-option').then(res => {
            processOption.value = res.data.data
        })
        const uomOptions = ref([])
        axios.get('/api/get-uom-master-options').then(res => {
            uomOptions.value = res.data.data
        })
        const calculateJobRate = () => {
            formData.value.itemProcessAmt = formData.value.itemProcessRate * formData.value.itemJobWorkQty
            formData.value.itemEstValue = parseFloat(formData.value.itemProcessRate) + parseFloat(formData.value.itemJobWorkQty)
        }
        const dateFormat = ref({
            date: true,
            delimiter: '/',
            datePattern: ['d', 'm', 'Y'],
        })

        const formatDates = ref({
            delDate: null,
        })

        const getJobWorkItemFormateDate = (date) => {
            formData.value.delDate = forMatIndianDate(date)
        }

        const isBusy = ref(false)
        const modalTableData = ref({
            itemMasterFields: [
                {
                    key: 'rowSelected',
                    label: ''
                },
                {
                    key: 'selectCheckBox',
                    label: ''
                },
                {
                    key: 'itemCode',
                    label: 'Item Code'
                },
                {
                    key: 'itemDescription',
                    label: 'Description'
                },
                {
                    key: 'uom_details.uom',
                    label: 'UOM'
                },
                {
                    key: 'drawingNumber',
                    label: 'Drawing No'
                },
                {
                    key: 'drawingRevesion',
                    label: 'Revision'
                },
                {
                    key: 'jobQty',
                    label: 'Quantity'
                },

            ],
            itemMasterData: [],
        })

        const table = ref({
            fields: [
                {
                    key: 'rowSelected',
                    label: ''
                },
                {
                    key: 'index',
                    label: 'No',
                },
                {
                    key: 'itemCode',
                    label: 'Item Code',
                },
                {
                    key: 'itemDescription',
                    label: 'Description',
                },
                {
                    key: 'itemDetailDescription',
                    label: 'Description',
                },
                {
                    key: 'uom_details.uom',
                    label: 'UOM',
                },
                {
                    key: 'itemJobWorkQty',
                    label: 'Quantity',
                },
                {
                    key: 'itemProcessRate',
                    label: 'Rate',
                },
                {
                    key: 'itemProcessAmt',
                    label: 'Amount',
                },
                {
                    key: 'itemPendingQty',
                    label: 'Pending Qty',
                },
                {
                    key: 'status',
                    label: 'Status',
                },
                {
                    key: 'action',
                    label: 'Action',
                }
            ],
            data: [],
        })

        const itemDeatils = async (id) => {
            await axios.get(`/api/item-master/${id}`).then(res => {
                formData.value.itemDescription = res.data.data?.itemDescription ?? null
                formData.value.itemAddDescription = res.data.data?.itemDetails?.description ?? null
                formData.value.itemDetailDescription = res.data.data?.itemDetails?.detailDescription ?? null
                formData.value.itemDrawingNumber = res.data.data?.itemDetails?.drawingNumber ?? null
                formData.value.itemDrawingRevision = res.data.data?.itemDetails?.revision ?? null
                formData.value.itemUom = res.data.data?.convUom ?? null
                formData.value.itemJobWorkQty = res.data.data?.itemDetails?.jobQty ?? null
            })
        }

        const blankFormData = {
            _id: null,
            jobWorkId: router.currentRoute.params.id,
            itemId:null,
            itemCode: null,
            itemDescription: null,
            itemAlice: null,
            itemAddDescription: null,
            itemDetailDescription: null,
            itemDrawingNumber: null,
            itemDrawingRevision: null,
            itemUom: null,
            itemConvUom: null,
            itemConvQty: null,
            itemcFactor: null,
            itemProcess: null,
            itemProcessRate: null,
            itemProcessAmt: null,
            itemProcessNote: null,
            itemJobCardNumber: null,
            itemWoNumber: null,
            itemDelDate: forMatIndianDate(),
            itemNote: null,
            itemJobWorkQty: null,
            itemAcctQty: null,
            itemPendingQty: null,
            itemRejectedQty: null,
            itemEstValue: null,
            itemRwQty: null,
            itemInternalNote: null,
        }

        const onRowSelected = (items) => {
            if (items.length > 0) {
                formData.value._id = items[0]._id
                formData.value.jobWorkId = items[0].jobWorkId
                formData.value.itemId = items[0].itemId
                formData.value.itemCode = items[0].itemCode ?? null
                formData.value.itemDescription = items[0].itemDescription ?? null
                formData.value.itemAlice = items[0].itemAlice ?? null
                formData.value.itemAddDescription = items[0].itemAddDescription ?? null
                formData.value.itemDetailDescription = items[0].itemDetailDescription ?? null
                formData.value.itemDrawingNumber = items[0].itemDrawingNumber ?? null
                formData.value.itemDrawingRevision = items[0].itemDrawingRevision ?? null
                formData.value.itemUom = items[0].itemUom ?? null
                formData.value.itemConvUom = items[0].itemConvUom ?? null
                formData.value.itemConvQty = items[0].itemConvQty ?? null
                formData.value.itemcFactor = items[0].itemcFactor ?? null
                formData.value.itemProcess = items[0].itemProcess ?? null
                formData.value.itemProcessRate = items[0].itemProcessRate ?? null
                formData.value.itemProcessAmt = items[0].itemProcessAmt ?? null
                formData.value.itemProcessNote = items[0].itemProcessNote ?? null
                formData.value.itemJobCardNumber = items[0].itemJobCardNumber ?? null
                formData.value.itemWoNumber = items[0].itemWoNumber ?? null
                formData.value.itemDelDate = items[0].itemDelDate ?? null
                formData.value.itemNote = items[0].itemNote ?? null
                formData.value.itemJobWorkQty = items[0].itemJobWorkQty ?? null
                formData.value.itemAcctQty = items[0].itemAcctQty ?? null
                formData.value.itemPendingQty = items[0].itemPendingQty ?? null
                formData.value.itemRejectedQty = items[0].itemRejectedQty ?? null
                formData.value.itemEstValue = items[0].itemEstValue ?? null
                formData.value.itemRwQty = items[0].itemRwQty ?? null
                formData.value.itemInternalNote = items[0].itemInternalNote ?? null
            } else {
                resetFormData()
            }
        }

        const searchData = ref({
            itemCode: null,
            itemDescription: null,
            detailDescription: null,
            drawingNumber: null,
        })
        const getItemMasterFilter = async () => {
            isModalTableBusy.value = true
            await axios.post('/api/new/get-job-card-item-filter', searchData.value).then((res) => {
                // console.log(res.data.data)
                modalTableData.value.itemMasterData = res.data.data
            })
            isModalTableBusy.value = false
        }
        const ItemMasterList = ref([])
        const selectedItemIds = (e, id) => {
            if (e === false) {
                ItemMasterList.value = ItemMasterList.value.filter(function (e) {
                    return e !== id;
                });
            } else {
                ItemMasterList.value.push(id)
            }
        }
        const resetModalData = () => {
            searchData.value.itemCode = null
            searchData.value.itemDescription = null
            searchData.value.detailDescription = null
            searchData.value.drawingNumber = null
            ItemMasterList.value = []
            modalTableData.value.data = []
        }
        const openModal = () => {
            itemMasterModal.value.show();
        }

        const formData = ref(JSON.parse(JSON.stringify(blankFormData)))

        const resetFormData = () => {
            formData.value = JSON.parse(JSON.stringify(blankFormData))
        }

        const saveItemMasterDetail = async () => {
            await axios.post('/api/add-job-work-order-item', {
                ids: ItemMasterList.value,
                jobWorkId: router.currentRoute.params.id
            })
            resetModalData()
            await refetchData()
        }

        const refetchData = async () => {
            isBusy.value = true
            await axios.get(`/api/get-job-work-order-item/${router.currentRoute.params.id}`).then(res => {
                // console.log(res.data.data)
                table.value.data = res.data.data
            })
            isBusy.value = false
        }
        refetchData()

        const deleteItemDetails = async (id) => {
            await Swal.fire({
                title: 'Are you sure?',
                text: "Delete this item",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, do it!',
                cancelButtonText: 'No, keep it!',
                customClass: {
                    confirmButton: 'btn btn-primary',
                    cancelButton: 'btn btn-outline-danger ml-1',
                },
                buttonsStyling: false,
            }).then(result => {
                if (result.value) {
                    store.dispatch('job-work-item-store-module/deleteJobWorkItemDetail', {id: id}).then((res) => {
                        if (res.status === 200) {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Job Work Item Deleted',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: 'You have successfully Deleted Job Work Item  ',
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
                    refetchData()
                }
            })
        }

        const saveFormData = async () => {
            if (formData.value._id === null) {
                store.dispatch('job-work-item-store-module/addJobWorkItemDetail', formData.value).then((res) => {
                    if (res.status === 200) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Job Work Item Added',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: 'You have successfully Added Job Work Item',
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
                store.dispatch('job-work-item-store-module/updateJobWorkItemDetail', formData.value).then((res) => {
                    if (res.status === 200) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Job Work Item Updated',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: 'You have successfully Updated Job Work Item',
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
            }
            resetFormData();
            await refetchData()
        }


        const {refFormObserver, getValidationState, resetForm} = formValidation(resetFormData)
        return {
            formData,
            itemCodeOPtion,
            refFormObserver,
            getValidationState,
            resetForm,
            resetFormData,
            required,
            regex,
            uomOption,
            processOption,
            saveFormData,
            isBusy,
            table,
            itemDeatils,
            openModal,
            modalTableData,
            itemMasterModal,
            isModalTableBusy,
            searchData,
            getItemMasterFilter,
            ItemMasterList,
            selectedItemIds,
            saveItemMasterDetail,
            refetchData,
            resetModalData,
            deleteItemDetails,
            calculateJobRate,
            uomOptions,
            getJobWorkItemFormateDate,
            formatDates,
            dateFormat,
            onRowSelected
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

