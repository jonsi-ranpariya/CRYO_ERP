<template>
    <div>
        <b-card-code>
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
                                    <b-input-group class="d-flex">
                                        <b-form-input
                                            v-model="formData.itemCode"
                                            :state="getValidationState(validationContext)"
                                            id="itemCode"
                                            readonly
                                        />
                                        <b-input-group-append>
                                            <b-button variant="primary" @click="openModalItem">...</b-button>
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
                                >
                                    <b-form-input
                                        :state="getValidationState(validationContext)"
                                        id="itemDescription"
                                        v-model="formData.itemDescription"
                                        readonly
                                    />
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                            <b-row>
                                <b-col md="6">
                                    <validation-provider
                                        #default="validationContext"
                                        name="Add Description"
                                        rules=""
                                    >
                                        <b-form-group
                                            label="Add Description"
                                            label-for="addDescription"
                                        >
                                            <b-form-input
                                                id="addDescription"
                                                v-model="formData.itemAddDescription"
                                                :state="getValidationState(validationContext)"
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
                                        name="Item Make"
                                        rules=""
                                    >
                                        <b-form-group
                                            label="Item Make"
                                            label-for="itemMake"
                                            :state="getValidationState(validationContext)"
                                        >
                                            <v-select
                                                :clearable="false"
                                                :dir=" $store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                                :options="makeOption"
                                                :reduce="(val) => val.value"
                                                input-id="itemMake"
                                                placeholder="Select Make"
                                                push-tags
                                                taggable
                                                v-model="formData.itemMake"
                                                :state="getValidationState(validationContext)"
                                            />
                                            <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                                {{ validationContext.errors[0] }}
                                            </b-form-invalid-feedback>
                                        </b-form-group>
                                    </validation-provider>
                                </b-col>
                            </b-row>
                            <validation-provider
                                #default="validationContext"
                                name="Detail Description"
                                rules=""
                            >
                                <b-form-group
                                    label="Detail Description"
                                    label-for="detailDescription"
                                >
                                    <b-form-textarea
                                        id="detailDescription"
                                        rows="2"
                                        v-model="formData.itemDetailDescription"
                                        :state="getValidationState(validationContext)"
                                    />
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                            <b-row>
                                <b-col>
                                    <validation-provider
                                        #default="validationContext"
                                        name="Drawing No"
                                        rules=""
                                    >
                                        <b-form-group
                                            label="Drawing No."
                                            label-for="itemDrawingNo"
                                        >
                                            <b-form-input
                                                id="itemDrawingNo"
                                                v-model="formData.itemDrawingNo"
                                                :state="getValidationState(validationContext)"
                                            />
                                            <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                                {{ validationContext.errors[0] }}
                                            </b-form-invalid-feedback>
                                        </b-form-group>
                                    </validation-provider>
                                </b-col>
                                <b-col>
                                    <validation-provider
                                        #default="validationContext"
                                        name="Revision"
                                        rules=""
                                    >
                                        <b-form-group
                                            label="Rev"
                                            label-for="itemRev"
                                        >
                                            <b-form-input
                                                id="itemRev"
                                                v-model="formData.itemRev"
                                                :state="getValidationState(validationContext)"
                                            />
                                            <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                                {{ validationContext.errors[0] }}
                                            </b-form-invalid-feedback>
                                        </b-form-group>
                                    </validation-provider>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col md="6">
                                    <b-form-group
                                        label="UOM"
                                        label-for="itemUom"
                                    >
                                        <v-select
                                            :clearable="false"
                                            :dir="$store.state.appConfig.isRTL? 'rtl': 'ltr'"
                                            :options="uomOption"
                                            :reduce="(val) => val.value"
                                            input-id="itemUom"
                                            placeholder="Select uom"
                                            v-model="formData.itemUom"
                                            disabled
                                        />
                                    </b-form-group>
                                </b-col>
                                <b-col md="6">
                                    <b-form-group
                                        label="Conversion UOM"
                                        label-for="conversionUom"
                                    >
                                        <v-select
                                            :clearable="false"
                                            :dir="$store.state.appConfig.isRTl? 'rtl': 'ltr'"
                                            :options="convUomOptions"
                                            :reduce="(val) => val.value"
                                            input-id="conversionUom"
                                            placeholder="Select uom"
                                            v-model="formData.conversionUom"
                                        />
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col md="6">
                                    <b-form-group
                                        label="C-Factor"
                                        label-for="cFactor"
                                    >
                                        <b-form-input
                                            id="cFactor"
                                            v-model="formData.cFactor"
                                        />
                                    </b-form-group>
                                </b-col>
                                <b-col md="6">
                                    <b-form-group
                                        label="Conversion Qty"
                                        label-for="conversionQty"
                                    >
                                        <b-form-input
                                            id="conversionQty"
                                            v-model="formData.conversionQty"
                                        />
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <validation-provider
                                #default="validationContext"
                                name="Transaction"
                                rules="required"
                            >
                                <b-form-group
                                    label="Transaction"
                                    label-for="transaction"
                                    :state="getValidationState(validationContext)"
                                >
                                    <v-select
                                        :clearable="false"
                                        :dir="$store.state.appConfig.isRTL? 'rtl': 'ltr'"
                                        :options="transactionOption"
                                        :reduce="(val) => val.value"
                                        input-id="transaction"
                                        placeholder="Select Transaction"
                                        v-model="formData.transaction"
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
                                        label="Document No"
                                        label-for="documentNo"
                                    >
                                        <b-form-input
                                            v-model="formData.documentNo"
                                            id="documentNo"
                                        />
                                    </b-form-group>
                                </b-col>
                                <b-col md="6">
                                    <b-form-group
                                        label="Document Date"
                                        label-for="documentDate"
                                    >
                                        <b-input-group>
                                            <Cleave
                                                id="documentDate"
                                                v-model="formData.documentDate"
                                                class="form-control"
                                                :raw="false"
                                                :options="dateFormat"
                                                placeholder="DD/MM/YYYY"
                                                show-decade-nav
                                            />
                                            <b-input-group-append>
                                                <b-form-datepicker
                                                    v-model="formatDates.documentDate"
                                                    button-only
                                                    show-decade-nav
                                                    size="sm"
                                                    @input="getDocumentFormatDate($event)"
                                                />
                                            </b-input-group-append>
                                        </b-input-group>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                        </b-col>
                        <b-col md="6">
                            <b-row>
                                <b-col md="6">
                                    <b-form-group
                                        label="Transaction Qty"
                                        label-for="transactionQty"
                                    >
                                        <b-form-input
                                            id="transactionQty"
                                            v-model="formData.transactionQty"
                                            @keyup="calculateAmount"
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
                                            v-model="formData.rejectedQty"
                                        />
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col md="6">
                                    <b-form-group
                                        label="Rate"
                                        label-for="rate"
                                    >
                                        <b-form-input
                                            id="rate"
                                            v-model="formData.rate"
                                            @keyup="calculateAmount"
                                        />
                                    </b-form-group>
                                </b-col>
                                <b-col md="6">
                                    <b-form-group
                                        label="Value"
                                        label-for="value"
                                    >
                                        <b-form-input
                                            id="value"
                                            v-model="formData.value"
                                            readonly
                                        />
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-form-group
                                label="W.O. No/P.O. No"
                                label-for="woPoNo"
                            >
                                <b-form-input
                                    id="woPoNo"
                                    v-model="formData.woPoNo"
                                />
                            </b-form-group>
                            <b-row>
                                <b-col md="6">
                                    <b-form-group
                                        label="Opening Stock"
                                        label-for="openingStock"
                                    >
                                        <b-form-input
                                            id="openingStock"
                                            v-model="formData.openingStock"
                                        />
                                    </b-form-group>
                                </b-col>
                                <b-col md="6">
                                    <b-form-group
                                        label="Current Stock"
                                        label-for="currentStock"
                                    >
                                        <b-form-input
                                            id="currentStock"
                                            v-model="formData.currentStock"
                                        />
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col md="6">
                                    <b-form-group
                                        label="Minimum Stock"
                                        label-for="minimumStock"
                                    >
                                        <b-form-input
                                            id="minimumStock"
                                            v-model="formData.minimumStock"
                                        />
                                    </b-form-group>
                                </b-col>
                                <b-col md="6">
                                    <b-form-group
                                        label="Lead Time"
                                        label-for="leadTime"
                                    >
                                        <b-form-input
                                            id="leadTime"
                                            v-model="formData.leadTime"
                                        />
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-form-group
                                label="Reference"
                                label-for="reference"
                            >
                                <b-form-input
                                    id="reference"
                                    v-model="formData.reference"
                                />
                            </b-form-group>
                            <b-row>
                                <b-col md="6">
                                    <b-form-group
                                        label="Party"
                                        label-for="party"
                                    >
                                        <b-form-input
                                            id="party"
                                            v-model="formData.party"
                                        />
                                    </b-form-group>
                                </b-col>
                                <b-col md="6">
                                    <b-form-group
                                        label="Transaction Type"
                                        label-for="transactionType"
                                    >
                                        <b-form-input
                                            id="transactionType"
                                            v-model="formData.transactionType"
                                        />
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col md="6">
                                    <b-form-group
                                        label="Issue By - Person"
                                        label-for="issueByPerson"
                                    >
                                        <b-form-input
                                            id="issueByPerson"
                                            v-model="formData.issueByPerson"
                                        />
                                    </b-form-group>
                                </b-col>
                                <b-col md="6">
                                    <b-form-group
                                        label="Received By - Person"
                                        label-for="receivedByPerson"
                                    >
                                        <b-form-input
                                            id="receivedByPerson"
                                            v-model="formData.receivedByPerson"
                                        />
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-form-group
                                label="Remark"
                                label-for="remark"
                            >
                                <b-form-input
                                    id="remark"
                                    v-model="formData.remark"
                                />
                            </b-form-group>
                        </b-col>
                        <b-col>
                            <hr>
                            <b-button
                                class="float-right"
                                type="submit"
                                variant="primary"
                            >
                                Save
                            </b-button>
                        </b-col>
                    </b-row>
                </b-form>
            </validation-observer>
        </b-card-code>
        <!--Modal -->
        <b-modal
            id="itemMasterModal"
            ref="itemMasterModal"
            title="Select Item"
            ok-title="submit"
            cancel-variant="danger"
            size="xl"
            no-close-on-backdrop
            @cancel="resetModalData"
            @close="resetModalData"
        >
            <b-row>
                <b-col md="3">
                    <b-form-group
                        label="Item Code"
                        label-for="itemCodes"
                    >
                        <b-form-input
                            id="itemCodes"
                            v-model="searchData.itemCode"
                            @keyup="getTransactionItemFilter"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="3">
                    <b-form-group
                        label="Item Description"
                        label-for="itemDescriptions"
                    >
                        <b-form-input
                            id="itemDescriptions"
                            v-model="searchData.itemDescription"
                            @keyup="getTransactionItemFilter"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="3">
                    <b-form-group
                        label="Detail Description"
                        label-for="detailDescriptions"
                    >
                        <b-form-input
                            id="detailDescriptions"
                            v-model="searchData.detailDescription"
                            @keyup="getTransactionItemFilter"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="3">
                    <b-form-group
                        label="Drawing Number"
                        label-for="drawingNumber"
                    >
                        <b-form-input
                            id="drawingNumber"
                            v-model="searchData.drawingNumber"
                            @keyup="getTransactionItemFilter"
                        />
                    </b-form-group>
                </b-col>
            </b-row>
            <!--table-->
            <b-table
                :fields="modalData.fields"
                :items="modalData.data"
                :no-border-collapse="false"
                responsive
                bordered
                hover
                show-empty
                :busy="isModalTableBusy"
                class="table_scroll"
            >
                <template #cell(selectItem)="data">
                    <b-button
                        variant="primary"
                        type="button"
                        size="sm"
                        @click="selectItemMasterItem(data.item)"
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
    BForm,
    BRow,
    BCol,
    BFormGroup,
    BFormInput,
    BInputGroup,
    BInputGroupAppend,
    BFormInvalidFeedback,
    BButton,
    BFormTextarea,
    BFormDatepicker,
    BTable,
    BSpinner,
    BFormCheckbox
} from 'bootstrap-vue'
import BCardCode from '../../../@core/components/b-card-code/BCardCode'
import { ValidationObserver, ValidationProvider } from 'vee-validate'
import { onUnmounted, ref } from '@vue/composition-api'
import formValidation from '@core/comp-functions/forms/form-validation'
import Cleave from 'vue-cleave-component'
import { forMatIndianDate, getTcTodayDate } from '@core/utils/utils'
import vSelect from 'vue-select'
import axios from '@axios'
import { required } from '@validations'
import inventoryStoreModule from '../inventoryStoreModule'
import { useToast } from 'vue-toastification/composition'
import store from '@/store'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
import router from '@/router'
import { getUserData } from '../../../auth/utils'

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
        BFormTextarea,
        Cleave,
        vSelect,
        BFormDatepicker,
        BTable,
        BSpinner,
        BFormCheckbox
    },
    setup({ itemMasterModal }) {
        const toast = useToast()
        const SE_APP_STORE_MODULE_NAME = 'inventory-store-module'
        if (!store.hasModule(SE_APP_STORE_MODULE_NAME)) store.registerModule(SE_APP_STORE_MODULE_NAME, inventoryStoreModule)
        onUnmounted(() => {
            if (store.hasModule(SE_APP_STORE_MODULE_NAME)) store.unregisterModule(SE_APP_STORE_MODULE_NAME)
        })

        itemMasterModal = ref()
        const isModalTableBusy = ref(false)

        const uomOption = ref([])
        axios.get('/api/get-uom-master-options')
            .then(res => {
                uomOption.value = res.data.data
            })

        const convUomOptions = ref([])
        axios.get('/api/get-uom-master-options')
            .then(res => {
                convUomOptions.value = res.data.data
            })

        const makeOption = ref([])
        axios.get('/api/get-item-make-master-options')
            .then(res => {
                makeOption.value = res.data.data
            })

        const transactionOption = ref([
            {
                label: 'Opening Stock',
                value: 1
            },
            {
                label: 'Receipt',
                value: 2
            },
            {
                label: 'Issue',
                value: 3
            },
            {
                label: 'Return',
                value: 4
            },
            {
                label: 'Rejection(Shop)',
                value: 5
            },
        ])

        const dateFormat = ref({
            date: true,
            delimiter: '/',
            datePattern: ['d', 'm', 'Y']
        })

        const formatDates = ref({
            documentDate: null,
        })

        const getDocumentFormatDate = (date) => {
            formData.value.documentDate = forMatIndianDate(date)
        }

        const modalData = ref({
            fields: [
                {
                    key: 'selectItem',
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
                    key: 'itemDetails.detailDescription',
                    label: 'Detail Description'
                },
                {
                    key: 'itemDetails.drawingNumber',
                    label: 'Drawing No'
                },
                {
                    key: 'itemDetails.revision',
                    label: 'Rev'
                },
                {
                    key: 'uom_item.uom',
                    label: 'UOM'
                },
            ],
            data: [],
        })

        const getTransactionItemFilter = async () => {
            isModalTableBusy.value = true
            await axios.post('/api/get-item-master-with-filter', searchData.value)
                .then(res => {
                    modalData.value.data = res.data.data
                })
            isModalTableBusy.value = false
        }

        const searchData = ref({
            itemCode: null,
            itemDescription: null,
            detailDescription: null,
            drawingNumber: null,
        })

        const openModalItem = async () => {
            itemMasterModal.value.show()
        }

        const resetModalData = () => {
            searchData.value.itemCode = null
            searchData.value.itemDescription = null
            searchData.value.itemDetailDescription = null
            searchData.value.itemDrawingNo = null
            modalData.value.data = []
        }
        const selectItemMasterItem = (data) => {
            formData.value.itemId = data._id
            formData.value.itemCode = data.itemCode ?? null
            formData.value.itemDescription = data.itemDescription ?? null
            formData.value.itemAddDescription = data.itemDetails?.description ?? null
            formData.value.itemDetailDescription = data.itemDetails?.detailDescription ?? null
            formData.value.itemDrawingNo = data.itemDetails?.drawingNumber ?? null
            formData.value.itemMake = data.make ?? null
            formData.value.itemRev = data.itemDetails?.revision ?? null
            formData.value.itemUom = data.uom_item?.uom ?? null
            formData.value.conversionUom = data.convUom ?? null
            formData.value.cFactor = data.cFactor ?? null
            formData.value.conversionQty = data.convQty ?? null
            formData.value.leadTime = data?.purchaseData?.leadTime ?? 0
            formData.value.minimumStock = data?.purchaseData?.minimumStockQuantity ?? 0
            itemMasterModal.value.hide()
            resetModalData()
        }

        const CurrentUserData = ref(getUserData())

        const blankFormData = {
            itemCode: null,
            itemDescription: null,
            itemAddDescription: null,
            itemDetailDescription: null,
            itemDrawingNo: null,
            itemRev: null,
            itemMake: null,
            transaction: null,
            documentNo: null,
            documentDate: forMatIndianDate(getTcTodayDate()),
            transactionQty: 0,
            rejectedQty: 0,
            rate: 0,
            value: 0,
            woPoNo: null,
            openingStock: null,
            currentStock: null,
            minimumStock: null,
            leadTime: null,
            reference: null,
            party: null,
            transactionType: null,
            itemUom: null,
            conversionUom: null,
            cFactor: null,
            conversionQty: null,
            issueByPerson: CurrentUserData.value.first_name + ' ' + CurrentUserData.value.last_name,
            receivedByPerson: null,
            remark: null,
        }

        const formData = ref(JSON.parse(JSON.stringify(blankFormData)))

        const resetFormData = () => {
            formData.value = JSON.parse(JSON.stringify(blankFormData))
        }

        const saveFormData = async () => {
            await store.dispatch('inventory-store-module/addTransaction', formData.value)
                .then(res => {
                    if (res.status === 200) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Transaction Added',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: `You have successfully Added Transaction.`,
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
                    if (res.data.data.transaction) {
                        router.push({
                            name: 'edit-transaction-inventory',
                            params: { id: res.data.data.transaction._id }
                        })
                    } else {
                        router.push({
                            name: 'edit-transaction-inventory',
                            params: { id: res.data.data._id }
                        })
                    }
                })
                .catch((error) => {
                    let response = error.response
                    if (response.status === 400) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Warning',
                                icon: 'AlertCircleIcon',
                                variant: 'warning',
                                text: response.data.message,
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
                                text: 'Internal Server Error',
                            },
                        })
                    }
                })
        }

        const calculateAmount = () => {
            formData.value.value = parseFloat(formData.value.transactionQty)  * parseFloat(formData.value.rate)
        }

        const {
            refFormObserver,
            resetForm,
            getValidationState
        } = formValidation(resetFormData)

        return {
            refFormObserver,
            resetForm,
            getValidationState,
            resetFormData,
            formData,
            dateFormat,
            formatDates,
            getDocumentFormatDate,
            transactionOption,
            uomOption,
            convUomOptions,
            openModalItem,
            saveFormData,
            itemMasterModal,
            getTransactionItemFilter,
            isModalTableBusy,
            searchData,
            modalData,
            selectItemMasterItem,
            resetModalData,
            required,
            makeOption,
            calculateAmount
        }
    }
}
</script>
