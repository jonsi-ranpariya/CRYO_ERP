<template>
    <div>
        <hr>
        <!--table -->
        <b-row>
            <b-col md="12">
                <b-table
                    :fields="itemFields"
                    :items="listOfItems"
                    responsive
                    class="mb-0 table_scroll"
                    bordered
                    hover
                    show-empty
                    :busy="isBusy"
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
                            <b-dropdown-item @click="editItemDetails(data.item)">
                                <feather-icon
                                    icon="Edit2Icon"
                                    class="mr-50"
                                />
                                <span>Edit</span>
                            </b-dropdown-item>
                            <b-dropdown-item @click="deleteItemDetails(data.item._id)">
                                <feather-icon
                                    icon="TrashIcon"
                                    class="mr-50"
                                />
                                <span>Delete</span>
                            </b-dropdown-item>
                        </b-dropdown>
                    </template>
                </b-table>
                <hr>
            </b-col>
        </b-row>
        <!--table Close-->
        <validation-observer #default="{ handleSubmit }">
            <b-form @submit.prevent="handleSubmit(saveFormData)">
                <b-row>
                    <b-col md="7">
                        <b-row>
                            <b-col md="12">
                                <validation-provider
                                    #default="validationContext"
                                    name="Item Code"
                                    rules="required"
                                >
                                    <b-form-group
                                        label="Item Code"
                                        label-for="itemCode"
                                        :state="getValidationState(validationContext)"
                                    >
                                        <b-input-group>
                                            <b-form-input
                                                :state="getValidationState(validationContext)"
                                                id="itemCode"
                                                placeholder="Select Item"
                                                readonly
                                                v-model="formData.itemCode"
                                            />
                                            <b-input-group-append>
                                                <b-button
                                                    @click="openModal"
                                                    type="button"
                                                    variant="primary"
                                                >
                                                    ...
                                                </b-button>
                                            </b-input-group-append>
                                        </b-input-group>
                                        <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                            {{ validationContext.errors[0] }}
                                        </b-form-invalid-feedback>
                                    </b-form-group>
                                </validation-provider>
                            </b-col>
                            <b-col md="12">
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
                                            id="itemDescription"
                                            :state="getValidationState(validationContext)"
                                            readonly
                                            v-model="formData.itemDescription"
                                        />
                                        <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                            {{ validationContext.errors[0] }}
                                        </b-form-invalid-feedback>
                                    </b-form-group>
                                </validation-provider>
                            </b-col>
                            <b-col md="12">
                                <b-form-group
                                    label="Make"
                                    label-for="make"
                                >
                                    <vue-autosuggest
                                        v-model="formData.itemMake"
                                        :suggestions="makeFilteredOptions"
                                        :limit="10"
                                        :input-props="{id:'make',class:'form-control', placeholder:'Select Make'}"
                                        @input="onMakeInputChange($event)"
                                        @selected="onSelectedMake($event)"
                                    >
                                        <template slot-scope="{suggestion}">
                                            <span class="my-suggestion-item">{{ suggestion.item.label }}</span>
                                        </template>
                                    </vue-autosuggest>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Item Desc (Cust)"
                                    label-for="itemCustomDescription"
                                >
                                    <b-form-textarea
                                        id="itemCustomDescription"
                                        v-model="formData.itemCustomDescription"
                                        rows="2"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Add. Description"
                                    label-for="itemAddonDescription"
                                >
                                    <b-form-textarea
                                        id="itemAddonDescription"
                                        v-model="formData.itemAddDescription"
                                        rows="2"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="12">
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
                            <b-col md="12">
                                <b-form-group
                                    label="Detail Description"
                                    label-for="itemDetailDescription"
                                >
                                    <b-form-textarea
                                        id="itemDetailDescription"
                                        v-model="formData.itemDetailDescription"
                                        rows="2"
                                    />
                                </b-form-group>
                            </b-col>

                            <b-col md="8">
                                <b-form-group
                                    label="Drawing Number"
                                    label-for="itemDrawingNo"
                                >
                                    <b-form-input
                                        id="itemDrawingNo"
                                        v-model="formData.itemDrawingNo"
                                    />

                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group
                                    label="Drawing Revision"
                                    label-for="itemDrawingRev"
                                >
                                    <b-form-input
                                        id="itemDrawingRev"
                                        v-model="formData.itemRevision"
                                    />

                                </b-form-group>
                            </b-col>
                            <b-col md="12">
                                <b-form-group
                                    label="UOM"
                                    label-for="itemUom"
                                >
                                    <v-select
                                        :clearable="false"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="UomListOption"
                                        :reduce="val => val.value"
                                        input-id="itemUom"
                                        placeholder="Select UOM"
                                        v-model="formData.itemUom"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Cust Part No"
                                    label-for="custPartNo"
                                >
                                    <b-form-input
                                        id="custPartNo"
                                        v-model="formData.itemCustPartNo"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Store"
                                    label-for="store"
                                >
                                    <v-select
                                        :clearable="false"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="storeOption"
                                        :reduce="val => val.value"
                                        input-id="store"
                                        placeholder="Select store"
                                        v-model="formData.itemStore"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Er & Comm Required..?"
                                    label-for="erCommRequired"
                                >
                                    <v-select
                                        :clearable="false"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="ErCommRequiredOption"
                                        :reduce="val => val.value"
                                        input-id="erCommRequired"
                                        placeholder="Select ER"
                                        v-model="formData.itemErAndComm"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Partial Despatch..?"
                                    label-for="partialDispatch"
                                >
                                    <v-select
                                        :clearable="false"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="partialDispatchOption"
                                        :reduce="val => val.value"
                                        input-id="partialDispatch"
                                        placeholder="Select Dispatch"
                                        v-model="formData.itemPartialDespatch"
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>
                    </b-col>
                    <b-col md="5">
                        <b-row>
                            <b-col md="6">
                                <b-form-group
                                    label="Quantity"
                                    label-for="itemQuantity"
                                >
                                    <b-form-input
                                        id="itemQuantity"
                                        v-model="formData.itemQuantity"
                                        @keyup="calculateAmount"
                                    />

                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Rate"
                                    label-for="itemRate"
                                >
                                    <b-form-input
                                        id="itemRate"
                                        v-model="formData.itemRate"
                                        @keyup="calculateAmount"
                                    />

                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Discount(%)"
                                    label-for="itemDiscount"
                                >
                                    <b-form-input
                                        id="itemDiscount"
                                        v-model="formData.itemDiscount"
                                        @keyup="calculateAmount"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Disc(val)"
                                    label-for="itemDiscountValue"
                                >
                                    <b-form-input
                                        id="itemDiscountValue"
                                        v-model="formData.itemDiscountValue"
                                        @keyup="getItemDiscountCalculation"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Amount"
                                    label-for="itemAmount"
                                >
                                    <b-form-input
                                        id="itemAmount"
                                        readonly
                                        v-model="formData.itemAmount"
                                    />

                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="NetAmount"
                                    label-for="itemNetAmount"
                                >
                                    <b-form-input
                                        id="itemNetAmount"
                                        readonly
                                        v-model="formData.itemNetAmount"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="12">
                                <b-form-group
                                    label="WT in Kg."
                                    label-for="wtInKg"
                                >
                                    <b-form-input
                                        id="itemWtInKg"
                                        v-model="formData.itemWtInKg"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="12">
                                <b-form-group
                                    label="Remark"
                                    label-for="remark"
                                >
                                    <b-form-textarea
                                        id="itemRemark"
                                        rows="2"
                                        v-model="formData.itemRemark"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="12">
                                <b-form-group
                                    label="Warranty Required..?"
                                    label-for="warrantyRequired"
                                >
                                    <v-select
                                        placeholder="Select Dispatch"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="warrantyOption"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        input-id="warrantyRequired"
                                        v-model="formData.warrantyRequired"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group
                                    label="CGST(%)"
                                    label-for="cgstPercentage"
                                >
                                    <b-form-input
                                        id="cgstPercentage"
                                        v-model="formData.cgstPercentage"
                                        @keyup="calculateGstAmount"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group
                                    label="SGST(%)"
                                    label-for="sgstPercentage"
                                >
                                    <b-form-input
                                        id="sgstPercentage"
                                        v-model="formData.sgstPercentage"
                                        @keyup="calculateGstAmount"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group
                                    label="IGST(%)"
                                    label-for="igstPercentage"
                                >
                                    <b-form-input
                                        id="igstPercentage"
                                        v-model="formData.igstPercentage"
                                        @keyup="calculateGstAmount"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="12">
                                <b-form-group
                                    label="HSN/SAC No."
                                    label-for="itemHsnSanNumber"
                                >
                                    <b-form-input
                                        id="itemHsnSanNumber"
                                        v-model="formData.itemHsnSacNo"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="12">
                                <b-form-group
                                    label="Is Service?"
                                    label-for="isService"
                                >
                                    <v-select
                                        :options="isServiceOptions"
                                        placeholder="Select Service Type"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        input-id="isService"
                                        v-model="formData.isService"
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

        <!--Sales Order Modal-->
        <b-modal
            id="salesOrderModal"
            ref="salesOrderModal"
            title="Select Sales Order"
            ok-title="submit"
            cancel-variant="danger"
            size="xl"
            no-close-on-backdrop
            @ok="saveSalesOrderItemForInvoice"
            @cancel="resetModalData"
            @close="resetModalData"
        >
            <b-row>
                <b-col md="3">
                    <b-form-group
                        label="S.O. No"
                        label-for="modalSoNumber"
                    >
                        <b-form-input
                            id="modalSoNumber"
                            v-model="searchData.soNumber"
                            @keyup="getSalesOrderItemFilter"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="3">
                    <b-form-group
                        label="Item Code"
                        label-for="modalItemCode"
                    >
                        <b-form-input
                            id="modalItemCode"
                            v-model="searchData.itemCode"
                            @keyup="getSalesOrderItemFilter"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="3">
                    <b-form-group
                        label="Description"
                        label-for="modalItemDescription"
                    >
                        <b-form-input
                            id="modalItemDescription"
                            v-model="searchData.description"
                            @keyup="getSalesOrderItemFilter"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="3">
                    <b-form-group
                        label="DrawingNo"
                        label-for="modalItemDrawingNo"
                    >
                        <b-form-input
                            id="modalItemDrawingNo"
                            v-model="searchData.drawingNumber"
                            @keyup="getSalesOrderItemFilter"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="12">
                    <hr>
                </b-col>
            </b-row>

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
import {VueAutosuggest} from 'vue-autosuggest'
import {
    BButton,
    BCol,
    BDropdown,
    BDropdownItem,
    BForm,
    BFormCheckbox,
    BFormGroup,
    BFormInput,
    BFormInvalidFeedback,
    BFormTextarea,
    BInputGroup,
    BInputGroupAppend,
    BRow,
    BSpinner,
    BTable,
} from 'bootstrap-vue'
import {ref, computed} from "@vue/composition-api";
import {ValidationObserver, ValidationProvider} from 'vee-validate'
import vSelect from 'vue-select'
import formValidation from "@core/comp-functions/forms/form-validation";
import axios from '@axios'
import router from '@/router'
import Swal from "sweetalert2";
import {useToast} from "vue-toastification/composition";
import ToastificationContent from "@core/components/toastification/ToastificationContent";
import dispatchStoreModule from "../../dispatchStoreModule";
import store from '@/store'
import {generateBillingTerm} from "../newChallanAndInvoiceBillingTerm";
import {changeAmountDecimalPoint, changeToRound} from "@core/utils/utils";

export default {
    components: {
        BForm,
        BRow,
        BCol,
        BFormGroup,
        BFormInput,
        BTable,
        BSpinner,
        BDropdown,
        BDropdownItem,
        ValidationObserver,
        ValidationProvider,
        vSelect,
        BFormInvalidFeedback,
        BFormTextarea,
        BInputGroupAppend,
        BButton,
        BInputGroup,
        BFormCheckbox,
        VueAutosuggest,
    },
    props: {
        roundingType: {
            type: String
        },
        gstCalculationType: {
            required: true
        }
    },
    setup(props, {salesOrderModal}) {
        const ITEMADDON_APP_STORE_MODULE_NAME = 'dispatch-store-module'
        if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, dispatchStoreModule)

        const toast = useToast()
        const isBusy = ref(false)
        const isRounding = computed(() => props.roundingType)
        const calculationType = computed(() => props.gstCalculationType)
        salesOrderModal = ref()

        const UomListOption = ref([])
        axios.get('/api/get-uom-master-options').then((res) => {
            UomListOption.value = res.data.data
        })
        const storeOption = ref([])
        axios.get('/api/get-store-master-options').then(res => {
            storeOption.value = res.data.data
        })
        const StatusListOption = ref([
            {label: 'Pending', value: 'Pending'},
            {label: 'Completed', value: 'Completed'},
        ])
        const ItemTypeListOption = ref([
            {label: 'Manufacturing', value: 'Manufacturing'},
            {label: 'Trading', value: 'Trading'},
            {label: 'Job Work', value: 'Job Work'},
        ])
        const ErCommRequiredOption = ref([
            {label: 'Yes', value: 'Yes'},
            {label: 'No', value: 'No'},
        ])
        const partialDispatchOption = ref([
            {label: 'Yes', value: 'Yes'},
            {label: 'No', value: 'No'},
        ])
        const warrantyOption = ref([
            {label: 'Yes', value: 'Yes'},
            {label: 'No', value: 'No'},
        ])
        const isServiceOptions = ref([
            {label: 'Yes', value: 'Y'},
            {label: 'No', value: 'N'},
        ])
        const itemFields = ref([
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
                key: 'uom_details.uom',
                label: 'UOM',
            },
            {
                key: 'itemQuantity',
                label: 'Quantity',
            },
            {
                key: 'itemRate',
                label: 'Rate',
            },
            {
                key: 'itemNetAmount',
                label: 'Amount',
            },
            {
                key: 'soNumber',
                label: 'SO No',
            },
            {
                key: 'action',
                label: 'Action',
            },
        ])
        const listOfItems = ref([])
        const makeFilteredOptions = ref([])
        const makeDataSuggest = ref([])
        axios.get('/api/get-item-make-master-options').then(res => {
            makeDataSuggest.value = res.data.data
        })

        const refetchData = async () => {
            isBusy.value = true
            await axios.get(`/api/get-challan-and-invoice-item/${router.currentRoute.params.id}`).then((res) => {
                listOfItems.value = res.data.data
            })
            isBusy.value = false
        }
        refetchData()

        const blankFormData = {
            _id: null,
            challanInvoiceId: router.currentRoute.params.id,
            itemCode: null,
            itemDescription: null,
            itemCustomDescription: null,
            itemAddDescription: null,
            itemDetailDescription: null,
            itemMsnNumber: null,
            itemDrawingNo: null,
            itemRevision: null,
            itemUom: null,
            itemCustPartNo: null,
            itemStore: null,
            itemErAndComm: 'No',
            itemPartialDespatch: 'No',
            itemNoPackage: null,
            itemMarkAndNos: null,
            itemPackageDescription: null,
            itemAvgPkg: null,
            itemQuantity: 0,
            itemRate: 0,
            itemDiscount: 0,
            itemDiscountValue: 0,
            itemAmount: 0,
            itemNetAmount: 0,
            itemWtInKg: null,
            itemRemark: null,
            warrantyRequired: 'No',
            cgstPercentage: 0,
            cgstAmount: 0,
            sgstPercentage: 0,
            sgstAmount: 0,
            igstPercentage: 0,
            igstAmount: 0,
            itemHsnSacNo: null,
            itemMake: null,
            isService: null,
        }

        const formData = ref(JSON.parse(JSON.stringify(blankFormData)))

        const resetFormData = () => {
            formData.value = JSON.parse(JSON.stringify(blankFormData))
        }

        const calculateAmount = async () => {
            let isRound = parseInt(isRounding.value)
            if (isRound === 2) {
                formData.value.itemAmount = changeToRound((formData.value.itemQuantity * formData.value.itemRate))
                formData.value.itemDiscountValue = changeToRound(((formData.value.itemAmount * formData.value.itemDiscount) / 100))
                formData.value.itemNetAmount = changeToRound((formData.value.itemAmount - formData.value.itemDiscountValue))
            } else {
                formData.value.itemAmount = parseFloat(formData.value.itemQuantity * formData.value.itemRate).toFixed(2) ?? 0
                formData.value.itemDiscountValue = parseFloat((formData.value.itemAmount * formData.value.itemDiscount) / 100).toFixed(2) ?? 0
                formData.value.itemNetAmount = parseFloat(formData.value.itemAmount - formData.value.itemDiscountValue).toFixed(2) ?? 0
            }
        }

        const getItemDiscountCalculation = () => {
            let itemAmount = parseFloat(formData.value.itemQuantity * formData.value.itemRate);
            let discountValue = parseFloat(formData.value.itemDiscountValue);
            formData.value.itemNetAmount = parseFloat(itemAmount - discountValue).toFixed(2);
            formData.value.itemDiscount = parseFloat((discountValue / itemAmount) * 100).toFixed(2);
        }

        const calculateGstAmount = () => {
            formData.value.cgstAmount = changeAmountDecimalPoint(changeToRound((parseFloat(formData.value.itemNetAmount) * parseFloat(formData.value.cgstPercentage) / 100)), 2);
            formData.value.sgstAmount = changeAmountDecimalPoint(changeToRound((parseFloat(formData.value.itemNetAmount) * parseFloat(formData.value.sgstPercentage) / 100)), 2);
            formData.value.igstAmount = changeAmountDecimalPoint(changeToRound((parseFloat(formData.value.itemNetAmount) * parseFloat(formData.value.igstPercentage) / 100)), 2);
        }

        const isModalTableBusy = ref(false)

        const modalData = ref({
            fields: [
                {
                    key: 'selectCheckBox',
                    label: ''
                },
                {
                    key: 'salesOrderNo',
                    label: 'S.O.No.'
                },
                {
                    key: 'itemCode',
                    label: 'Item Code'
                },
                {
                    key: 'itemName',
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
                    key: 'itemPendingQuantity',
                    label: 'Pend Qty'
                },
                {
                    key: 'itemRate',
                    label: 'Rate'
                },
                {
                    key: 'itemStatus',
                    label: 'Status'
                },
                {
                    key: 'itemCustomPartNo',
                    label: 'Cust. Part No'
                },
                {
                    key: 'itemCustomDescription',
                    label: 'Cust Desc.'
                },
            ],
            data: []
        })

        const openModal = () => {
            salesOrderModal.value.show();
        }

        const searchData = ref({
            soNumber: null,
            itemCode: null,
            description: null,
            drawingNumber: null,
            challanInvoiceId: router.currentRoute.params.id
        })

        const getSalesOrderItemFilter = async () => {
            isModalTableBusy.value = true
            await axios.post('/api/get-sales-order-items-details-filter', searchData.value).then((res) => {
                modalData.value.data = res.data.data
            })
            isModalTableBusy.value = false
        }

        const salesOrderItemList = ref([])

        const selectedItemIds = (e, id) => {
            if (e === false) {
                salesOrderItemList.value = salesOrderItemList.value.filter(function (e) {
                    return e !== id;
                });
            } else {
                salesOrderItemList.value.push(id)
            }
        }

        const resetModalData = () => {
            searchData.value.soNumber = null
            searchData.value.description = null
            searchData.value.drawingNumber = null
            searchData.value.itemCode = null
            salesOrderItemList.value = []
            modalData.value.data = []
        }

        const saveSalesOrderItemForInvoice = async () => {
            await axios.post('/api/add-multiple-new-challan-invoice-items', {
                ids: salesOrderItemList.value,
                challanInvoiceId: router.currentRoute.params.id
            });
            resetModalData()
            await refetchData()
        }

        const editItemDetails = async (data) => {
            formData.value = data
        }

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
                    store.dispatch('dispatch-store-module/deleteNewInvoiceChallanItem', {id: id}).then((res) => {
                        if (res.status === 200) {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Challan & Invoice Item Deleted',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: 'You have successfully Deleted Challan & Invoice Item',
                                },
                            });
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
                            });
                        }
                    });
                    resetFormData();
                    refetchData();
                }
            });
        }

        const billingTerm = ref([])

        const saveFormData = async () => {
            if (formData.value._id === null) {
                await store.dispatch('dispatch-store-module/addNewInvoiceChallanItem', formData.value).then((res) => {
                    if (res.status === 200) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Challan & Invoice Item Added',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: 'You have successfully Added Challan & Invoice Item',
                            },
                        });
                        axios.get(`/api/get-challan-billing-term/${router.currentRoute.params.id}`).then(res => {
                            billingTerm.value = res.data.data
                        })

                        if (billingTerm.value.length > 0) {
                            generateBillingTerm(router.currentRoute.params.id, billingTerm.value, listOfItems.value,
                                `/api/delete-challan-billing-term/${router.currentRoute.params.id}`,
                                '/api/new-challan-billing-term',
                                parseInt(isRounding.value),
                                parseInt(calculationType.value),
                            );
                        }
                        resetFormData();
                        refetchData();
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
                await store.dispatch('dispatch-store-module/updateNewInvoiceChallanItem', formData.value).then((res) => {
                    if (res.status === 200) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Challan & Invoice Item Updated',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: 'You have successfully Updated Challan & Invoice Item',
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
                    axios.get(`/api/get-challan-billing-term/${router.currentRoute.params.id}`).then(res => {
                        billingTerm.value = res.data.data
                    })

                    if (billingTerm.value.length > 0) {
                        generateBillingTerm(router.currentRoute.params.id, billingTerm.value, listOfItems.value,
                            `/api/delete-challan-billing-term/${router.currentRoute.params.id}`,
                            '/api/new-challan-billing-term',
                            parseInt(isRounding.value),
                            parseInt(calculationType.value),
                        );
                    }
                    resetFormData();
                    refetchData();
                }).catch((error) => {
                    if (error.response.status === 422) {
                        let response = error.response.data
                        if (response.errors) {
                            let errors = response.errors
                            if (errors.itemQuantity) {
                                toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: 'Wrong Data',
                                        icon: 'AlertCircleIcon',
                                        variant: 'warning',
                                        text: errors.itemQuantity[0],
                                    },
                                });
                            }
                        }
                    } else {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Error',
                                icon: 'AlertCircleIcon',
                                variant: 'danger',
                                text: 'Internal server error',
                            },
                        });
                    }
                });
            }
        }

        const onMakeInputChange = (text) => {
            if (text === '' || text === undefined) {
                return
            }
            const filteredData = makeDataSuggest.value.filter(item => item.label.toLowerCase().indexOf(text.toLowerCase()) > -1).slice(0, 10)
            makeFilteredOptions.value = [{
                data: filteredData,
            }]
        }

        const onSelectedMake = (item) => {
            formData.value.itemMake = item.item.label;
        }

        const {refFormObserver, getValidationState, resetForm} = formValidation(resetFormData)

        return {
            isRounding,
            listOfItems,
            itemFields,
            isBusy,
            refetchData,
            formData,
            refFormObserver,
            getValidationState,
            resetForm,
            resetFormData,
            UomListOption,
            storeOption,
            StatusListOption,
            ItemTypeListOption,
            ErCommRequiredOption,
            partialDispatchOption,
            warrantyOption,
            makeFilteredOptions,
            makeDataSuggest,
            calculateAmount,
            getItemDiscountCalculation,
            isModalTableBusy,
            salesOrderModal,
            modalData,
            openModal,
            searchData,
            salesOrderItemList,
            selectedItemIds,
            getSalesOrderItemFilter,
            resetModalData,
            saveSalesOrderItemForInvoice,
            editItemDetails,
            deleteItemDetails,
            saveFormData,
            billingTerm,
            calculateGstAmount,
            onMakeInputChange,
            onSelectedMake,
            isServiceOptions
        }
    }
}
</script>
<style lang="scss" scoped>
@import '~@core/scss/vue/libs/vue-sweetalert.scss';
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
<style lang="scss">
@import '~@core/scss/vue/libs/vue-select.scss';
</style>
<style lang="scss">
@import '~@core/scss/vue/libs/vue-autosuggest.scss';
</style>
