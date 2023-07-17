<template>
    <div>
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

        <!-- Form -->
        <validation-observer #default="{ handleSubmit }">
            <b-form @submit.prevent="handleSubmit(saveFormData)">
                <b-row>
                    <b-col md="6">
                        <validation-provider
                            #default="validationContext"
                            name="Item Code"
                            rules=""
                        >
                            <b-form-group
                                label="Item Code"
                                label-for="itemCode"
                                :state="getValidationState(validationContext)"
                            >
                                <v-select
                                    v-model="formData.itemCode"
                                    placeholder="Select itemCode"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="itemCodeOPtion"
                                    :reduce="val => val.value"
                                    :clearable="false"
                                    input-id="itemCode"
                                    @input="changeItemDescription($event)"
                                    :state="getValidationState(validationContext)"
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
                                    readonly
                                />
                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                        <b-row>
                            <b-col md="6">
                                <b-form-group label="Item Make" label-for="itemMake">
                                    <v-select
                                        :clearable="false"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="makeOption"
                                        :reduce="(val) => val.value"
                                        input-id="itemMake"
                                        placeholder="Select Make"
                                        v-model="formData.itemMake"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="HSN Number"
                                    label-for="itemHsnNumber"
                                >
                                    <b-form-input
                                        id="itemHsnNumber"
                                        v-model="formData.itemHsnNumber"
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="6">
                                <b-form-group
                                    label="MSN Number"
                                    label-for="itemMsnNumber"
                                >
                                    <b-form-input
                                        id="itemMsnNumber"
                                        v-model="formData.itemMsnNumber"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Add. Description"
                                    label-for="addDescription"
                                >
                                    <b-form-input
                                        id="addDescription"
                                        v-model="formData.itemAddDescription"
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>
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
                                <validation-provider
                                    #default="validationContext"
                                    name="Drawing Number"
                                    rules=""
                                >
                                    <b-form-group
                                        label="Drawing Number"
                                        label-for="drawingNumber"
                                    >
                                        <b-form-input
                                            id="drawingNumber"
                                            v-model="formData.itemDrawingNumber"
                                            :state="getValidationState(validationContext)"
                                        />
                                    </b-form-group>
                                </validation-provider>
                            </b-col>
                            <b-col md="6">
                                <validation-provider
                                    #default="validationContext"
                                    name="Drawing Revision"
                                    rules=""
                                >
                                    <b-form-group
                                        label="Drawing Rev"
                                        label-for="drawingRev"
                                    >
                                        <b-form-input
                                            id="drawingRev"
                                            v-model="formData.itemDrawingRevision"
                                            :state="getValidationState(validationContext)"
                                        />
                                    </b-form-group>
                                </validation-provider>
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
                                        placeholder="Select uom"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="uomOption"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        input-id="uom"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group label="Conv. UOM" label-for="itemConvUom">
                                    <v-select
                                        :clearable="false"
                                        :dir="
                                            $store.state.appConfig.isRTL
                                                ? 'rtl'
                                                : 'ltr'
                                        "
                                        :options="uomOption"
                                        :reduce="(val) => val.value"
                                        input-id="itemConvUom"
                                        placeholder="Select UOM"
                                        v-model="formData.itemConvUom"
                                    />
                                </b-form-group>

                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="6">
                                <b-form-group
                                    label="C-Factor"
                                    label-for="itemFactor"
                                >
                                    <b-form-input
                                        id="itemFactor"
                                        v-model="formData.itemFactor"
                                        @keyup="calculateAmount"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Conv Qty"
                                    label-for="itemConvQty"
                                >
                                    <b-form-input
                                        id="itemConvQty"
                                        v-model="formData.itemConvQty"
                                        @keyup="calculateAmount"
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>
                    </b-col>

                    <b-col md="6">
                        <b-form-group
                            label="Item Note"
                            label-for="itemNote"
                        >
                            <b-form-textarea
                                id="itemNote"
                                rows="2"
                                v-model="formData.itemNote"
                            />
                        </b-form-group>
                        <b-row>
                            <b-col md="6">
                                <b-form-group
                                    label="Quantity"
                                    label-for="quantity"
                                >
                                    <b-form-input
                                        id="quantity"
                                        v-model="formData.itemQuantity"
                                        @keyup="calculateAmount"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Quantity UP"
                                    label-for="itemQuantityUp"
                                >
                                    <b-form-input
                                        v-model="formData.itemQuantityUp"
                                        id="itemQuantityUp"
                                    />
                                </b-form-group>

                            </b-col>
                        </b-row>
                        <validation-provider
                            #default="validationContext"
                            name="Rate"
                            rules="required"
                        >
                            <b-form-group
                                label="Rate"
                                label-for="rate"
                            >
                                <b-form-input
                                    id="rate"
                                    v-model="formData.itemRate"
                                    @keyup="calculateAmount"
                                    step="0.01"
                                    min="0.00"
                                    type="number"
                                />
                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                        <b-row>
                            <b-col md="6">
                                <b-form-group
                                    label="Disc(%)"
                                    label-for="discount"
                                >
                                    <b-form-input
                                        id="discount"
                                        v-model="formData.itemDiscPercent"
                                        @keyup="calculateAmount"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Disc(value)"
                                    label-for="discountValue"
                                >
                                    <b-form-input
                                        id="discountValue"
                                        v-model="formData.itemDiscValue"
                                        @keyup="getItemDiscountCalculation"
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="6">
                                <b-form-group
                                    label="Amount"
                                    label-for="amount"
                                >
                                    <b-form-input
                                        id="amount"
                                        v-model="formData.itemAmount"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label=" Net Amount"
                                    label-for="netAmount"
                                >
                                    <b-form-input
                                        id="netAmount"
                                        v-model="formData.itemNetAmount"
                                        readonly
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-form-group
                            label="Total Amount"
                            label-for="totalAmount"
                        >
                            <b-form-input
                                id="totalAmount"
                                v-model="formData.totalAmount"
                                readonly
                            />
                        </b-form-group>
                        <b-row>
                            <b-col md="6">
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
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Status"
                                    label-for="status"
                                >
                                    <v-select
                                        v-model="formData.itemStatus"
                                        placeholder="Select Status"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="statusOptions"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        input-id="status"
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="4">
                                <b-form-group
                                    label="CGST(%)"
                                    label-for="itemCgstPercent"
                                >
                                    <b-form-input
                                        id="itemCgstPercent"
                                        v-model="formData.itemCgstPercent"
                                        @keyup="gstCalculation"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group
                                    label="SGST(%)"
                                    label-for="itemSgstPercent"
                                >
                                    <b-form-input
                                        id="itemSgstPercent"
                                        v-model="formData.itemSgstPercent"
                                        @keyup="gstCalculation"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group
                                    label="IGST/UGST(%)"
                                    label-for="itemIgstPercent"
                                >
                                    <b-form-input
                                        id="itemIgstPercent"
                                        v-model="formData.itemIgstUgstPercent"
                                        @keyup="gstCalculation"
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>
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
    BTable,
    BDropdown,
    BDropdownItem,
    BSpinner
} from 'bootstrap-vue'
import {ValidationObserver, ValidationProvider} from 'vee-validate'
import formValidation from '@core/comp-functions/forms/form-validation'
import {required} from '@validations'
import {ref, onUnmounted} from '@vue/composition-api'
import VSelect from 'vue-select'
import axios from '@axios'
import router from '@/router'
import Swal from 'sweetalert2'
import purchaseStoreModule from '../../purchaseStoreModule'
import Toastification from '@core/components/toastification/ToastificationContent.vue'
import {useToast} from 'vue-toastification/composition'
import store from '@/store'
import {generatePurchaseBillingTerm} from '../purchaseQuotationHelper'
import {computed} from '@vue/composition-api/dist/vue-composition-api'
import {changeAmountDecimalPoint, changeToRound} from '@core/utils/utils'

export default {
    components: {
        BForm,
        BRow,
        BCol,
        BFormGroup,
        BFormInput,
        BInputGroup,
        BInputGroupAppend,
        BFormInvalidFeedback,
        ValidationObserver,
        ValidationProvider,
        BButton,
        BFormTextarea,
        VSelect,
        BTable,
        BDropdown,
        BDropdownItem,
        BSpinner,
    },
    props: {
        poRoundingType: {
            required: true,
        }
    },
    setup(props) {
        const ITEMADDON_APP_STORE_MODULE_NAME = 'purchase-store-module'
        if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, purchaseStoreModule)

        const toast = useToast()

        const isBusy = ref(false)

        const roundingType = computed(() => props.poRoundingType)

        const storeOption = ref([]);
        axios.get("/api/get-store-master-options").then((res) => {
            storeOption.value = res.data.data;
        });

        const table = ref({
            fields: [
                {
                    key: 'rowSelected',
                    label: ''
                },
                {
                    key: 'index',
                    label: 'No'
                },
                {
                    key: 'item_details.itemCode',
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
                    key: 'itemQuantity',
                    label: 'Quantity'
                },
                {
                    key: 'itemRate',
                    label: 'rate'
                },
                {
                    key: 'itemNetAmount',
                    label: 'Net Amount'
                },
                {
                    key: 'itemStatus',
                    label: 'Status',
                    formatter: val => getStatus(val)
                },
                {
                    key: 'action',
                    label: 'Actions'
                }
            ],
            data: [],
        })

        const makeOption = ref([])
        axios.get('/api/get-item-make-master-options')
            .then(res => {
                makeOption.value = res.data.data
            })

        const uomOption = ref([])
        axios.get('/api/get-uom-master-options')
            .then(res => {
                uomOption.value = res.data.data
            })

        const statusOptions = ref([
            {
                label: 'Pending',
                value: 1
            },
            {
                label: 'Canceled',
                value: 2
            },
            {
                label: 'Completed',
                value: 3
            },
            {
                label: 'Regret',
                value: 4
            }
        ])

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

        const itemCodeOPtion = ref([])
        axios.get('/api/get-item-master-options')
            .then(res => {
                itemCodeOPtion.value = res.data.data
            })

        const changeItemDescription = async (id) => {
            await axios.get(`/api/item-master/${id}`)
                .then(res => {
                    formData.value.itemDescription = res.data.data?.itemDescription ?? null
                    formData.value.itemDetailDescription = res.data.data?.itemDetails?.detailDescription ?? null
                    formData.value.itemAddDescription = res.data.data?.itemDetails?.description ?? null
                    formData.value.itemDrawingNumber = res.data.data?.itemDetails?.drawingNumber ?? null
                    formData.value.itemDrawingRevision = res.data.data?.itemDetails?.revision ?? null
                    formData.value.itemUom = res.data.data?.uom ?? null
                    formData.value.itemMake = res.data.data?.make ?? null
                    formData.value.itemHsnNumber = res.data.data?.hsnSacDetails?.hsnSacNo ?? null
                    formData.value.itemConvUom = res.data.data?.convUom ?? null
                    formData.value.itemFactor = res.data.data?.cFactor ?? null
                    formData.value.itemConvQty = res.data.data?.convQty ?? null
                    formData.value.itemNote = res.data.data?.itemDetails?.remarkNote ?? null
                    formData.value.itemStatus = res.data.data.status
                })
        }

        const blankFormData = {
            _id: null,
            purchaseQuotationId: router.currentRoute.params.id,
            itemCode: null,
            itemDescription: null,
            itemMake: null,
            itemHsnNumber: 0,
            itemMsnNumber: 0,
            itemAddDescription: null,
            itemDetailDescription: null,
            itemDrawingNumber: null,
            itemDrawingRevision: null,
            itemUom: null,
            itemConvUom: null,
            itemFactor: null,
            itemConvQty: null,
            totalAmount: 0,
            itemNote: null,
            itemQuantityUp: 0,
            itemQuantity: 0,
            itemDiscPercent: 0,
            itemDiscValue: 0,
            itemAmount: 0,
            itemNetAmount: 0,
            itemRate: null,
            itemStore: null,
            itemStatus: 1,
            itemCgstPercent: 0,
            itemSgstPercent: 0,
            itemIgstUgstPercent: 0,
            itemCgstAmount: 0,
            itemSgstAmount: 0,
            itemIgstUgstAmount: 0,
        }

        const formData = ref(JSON.parse(JSON.stringify(blankFormData)))

        const resetFormData = () => {
            formData.value = JSON.parse(JSON.stringify(blankFormData))
        }

        const onRowSelected = (items) => {
            if (items.length > 0) {
                formData.value._id = items[0]._id
                formData.value.purchaseOrderId = items[0].purchaseOrderId ?? null
                formData.value.itemCode = items[0].itemCode ?? null
                formData.value.itemDescription = items[0].itemDescription ?? null
                formData.value.itemMake = items[0].itemMake ?? null
                formData.value.itemHsnNumber = items[0].itemHsnNumber ?? null
                formData.value.itemMsnNumber = items[0].itemMsnNumber ?? null
                formData.value.itemAddDescription = items[0].itemAddDescription ?? null
                formData.value.itemDetailDescription = items[0].itemDetailDescription ?? null
                formData.value.itemDrawingNumber = items[0].itemDrawingNumber ?? null
                formData.value.itemDrawingRevision = items[0].itemDrawingRevision ?? null
                formData.value.itemUom = items[0].itemUom ?? null
                formData.value.itemConvUom = items[0].itemConvUom ?? null
                formData.value.itemFactor = items[0].itemFactor ?? null
                formData.value.itemConvQty = items[0].itemConvQty ?? null
                formData.value.totalAmount = items[0].totalAmount ?? null
                formData.value.itemNote = items[0].itemNote ?? null
                formData.value.itemQuantityUp = items[0].itemQuantityUp ?? null
                formData.value.itemQuantity = items[0].itemQuantity ?? null
                formData.value.itemDiscPercent = items[0].itemDiscPercent ?? null
                formData.value.itemDiscValue = items[0].itemDiscValue ?? null
                formData.value.itemAmount = items[0].itemAmount ?? null
                formData.value.itemNetAmount = items[0].itemNetAmount ?? null
                formData.value.itemRate = items[0].itemRate ?? null
                formData.value.itemStore = items[0].itemStore ?? null
                formData.value.itemStatus = items[0].itemStatus ?? null
                formData.value.itemCgstPercent = items[0].itemCgstPercent ?? null
                formData.value.itemSgstPercent = items[0].itemSgstPercent ?? null
                formData.value.itemIgstUgstPercent = items[0].itemIgstUgstPercent ?? null
                formData.value.itemCgstAmount = items[0].itemCgstAmount ?? null
                formData.value.itemSgstAmount = items[0].itemSgstAmount ?? null
                formData.value.itemIgstUgstAmount = items[0].itemIgstUgstAmount ?? null
            } else {
                resetFormData()
            }
        }

        const calculateAmount = () => {
            formData.value.itemQuantityUp = formData.value.itemQuantity

            formData.value.reqQtyConv = formData.value.itemQuantity * formData.value.itemFactor * formData.value.itemConvQty;

            if (roundingType.value === '2') {
                formData.value.itemAmount = changeAmountDecimalPoint(changeToRound(formData.value.itemQuantity * formData.value.itemRate), 2)
                formData.value.itemDiscValue = changeAmountDecimalPoint(changeToRound((formData.value.itemAmount * formData.value.itemDiscPercent) / 100), 2)
                formData.value.itemNetAmount = changeAmountDecimalPoint(changeToRound(formData.value.itemAmount - formData.value.itemDiscValue))
            } else {
                formData.value.itemAmount = formData.value.itemQuantity * formData.value.itemRate
                formData.value.itemDiscValue = (formData.value.itemAmount * formData.value.itemDiscPercent) / 100
                formData.value.itemNetAmount = formData.value.itemAmount - formData.value.itemDiscValue
            }
        }
        const getItemDiscountCalculation = () => {
            let itemAmount = parseFloat(formData.value.itemQuantity * formData.value.itemRate)
            let discountValue = parseFloat(formData.value.itemDiscValue)
            let isRound = parseInt(roundingType.value)

            if (isRound === 2) {
                formData.value.itemNetAmount = changeAmountDecimalPoint(changeToRound(itemAmount - discountValue), 2)
                formData.value.itemDiscPercent = parseFloat((discountValue / itemAmount) * 100)
                    .toFixed(2)
            } else {
                formData.value.itemNetAmount = parseFloat(itemAmount - discountValue)
                    .toFixed(2)
                formData.value.itemDiscPercent = parseFloat((discountValue / itemAmount) * 100)
                    .toFixed(2)
            }
        }
        const gstCalculation = () => {
            if (roundingType.value === '2') {
                formData.value.itemCgstAmount = changeAmountDecimalPoint(changeToRound(formData.value.itemNetAmount * formData.value.itemCgstPercent / 100), 2)
                formData.value.itemSgstAmount = changeAmountDecimalPoint(changeToRound(formData.value.itemNetAmount * formData.value.itemSgstPercent / 100), 2)
                formData.value.itemIgstUgstAmount = changeAmountDecimalPoint(changeToRound(formData.value.itemNetAmount * formData.value.itemIgstUgstPercent / 100), 2)
            } else {
                formData.value.itemCgstAmount = formData.value.itemNetAmount * formData.value.itemCgstPercent / 100
                formData.value.itemSgstAmount = formData.value.itemNetAmount * formData.value.itemSgstPercent / 100
                formData.value.itemIgstUgstAmount = formData.value.itemNetAmount * formData.value.itemIgstUgstPercent / 100
            }
        }

        const refetchData = async () => {
            isBusy.value = true
            await axios.get(`/api/get-purchase-quotation-item/${router.currentRoute.params.id}`)
                .then(res => {
                    table.value.data = res.data.data
                })
            isBusy.value = false
        }
        refetchData()

        const deleteItemDetails = async (id) => {
            await Swal.fire({
                title: 'Are you sure?',
                text: 'Delete Purchase Quotation',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, do it!',
                cancelButtonText: 'No, keep it!',
                customClass: {
                    confirmButton: 'btn btn-primary',
                    cancelButton: 'btn btn-outline-danger ml-1',
                },
                buttonsStyling: false,
            })
                .then(result => {
                    if (result.value) {
                        store.dispatch('purchase-store-module/deletePurchaseQuotationItem', {id: id})
                            .then(res => {
                                if (res.status === 200) {
                                    toast({
                                        component: Toastification,
                                        position: 'top-right',
                                        props: {
                                            title: 'Purchase Quotation Item Deleted',
                                            icon: 'CheckSquareIcon',
                                            variant: 'success',
                                            text: 'You have successfully Deleted Purchase Quotation Item.',
                                        },
                                    })
                                } else {
                                    toast({
                                        component: Toastification,
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
                        resetFormData()
                        refetchData()
                    }
                })
        }

        const saveFormData = async () => {
            if (formData.value._id === null) {
                await store.dispatch('purchase-store-module/addPurchaseQuotationItem', formData.value)
                    .then(res => {
                        if (res.status === 200) {
                            toast({
                                component: Toastification,
                                position: 'top-right',
                                props: {
                                    title: 'Purchase Quotation Item Added',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: 'You have successfully Added Purchase Quotation Item.',
                                },
                            })
                        } else {
                            toast({
                                component: Toastification,
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
                await store.dispatch('purchase-store-module/updatePurchaseQuotationItem', formData.value)
                    .then(res => {
                        if (res.status === 200) {
                            toast({
                                component: Toastification,
                                position: 'top-right',
                                props: {
                                    title: 'Purchase Quotation Item Updated',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: 'You have successfully Updated Purchase Quotation Item.',
                                },
                            })
                        } else {
                            toast({
                                component: Toastification,
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
            resetFormData()
            await refetchData()
            let billingTerm = []
            await axios.get(`/api/get-purchase-quotation-billing-terms/${router.currentRoute.params.id}`)
                .then(res => {
                    billingTerm = res.data.data
                })
            await generatePurchaseBillingTerm(router.currentRoute.params.id,
                billingTerm,
                table.value.data,
                `/api/delete-purchase-quotation-billing-terms/${router.currentRoute.params.id}`,
                '/api/bulk-add-purchase-quotation-billing-terms',
                parseInt(roundingType.value)
            )
        }

        const {
            refFormObserver,
            getValidationState,
            resetForm
        } = formValidation(resetFormData)

        return {
            isBusy,
            table,
            refetchData,
            uomOption,
            formData,
            refFormObserver,
            getValidationState,
            resetForm,
            resetFormData,
            required,
            deleteItemDetails,
            saveFormData,
            statusOptions,
            getStatus,
            itemCodeOPtion,
            calculateAmount,
            changeItemDescription,
            makeOption,
            gstCalculation,
            roundingType,
            getItemDiscountCalculation,
            storeOption,
            onRowSelected
        }
    },
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
