<template>
    <div>
        <!--<hr>
        <b-row>
            <b-col md="12">
                <div class="demo-inline-spacing text-center">
                    <b-form-radio
                        v-model="selectedRadio"
                        name="some-radios"
                        value="2"
                    >
                        From Direct
                    </b-form-radio>
                    <b-form-radio
                        v-model="selectedRadio"
                        name="some-radios"
                        value="1"
                    >
                        From Invoice
                    </b-form-radio>
                    <b-button
                        variant="primary"
                        type="button"
                        @click="getSelectItem"
                        :disabled="selectedRadio === '2'"
                        class="ml-1"
                    >
                        Select Item
                    </b-button>
                </div>
            </b-col>
        </b-row>-->
        <hr>
        <b-table
            :fields="itemFields"
            :items="listOfItems"
            responsive
            class="mb-0"
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

            <!-- A custom formatted column -->
            <template #cell(itemName)="data">
                <span class="text-nowrap">{{ data.value }}</span>
            </template>

            <!-- A custom formatted column -->
            <template #cell(itemUom)="data">
                <span class="text-nowrap">{{ getUomName(data.value) }}</span>
            </template>

            <template #cell(rejectedItemName)="data">
                <span class="text-nowrap">{{ data.value }}</span>
            </template>

            <!-- A custom formatted column -->
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
                    <b-dropdown-item @click="deleteSalesOrderItem(data.item._id)">
                        <feather-icon
                            icon="TrashIcon"
                            class="mr-50"
                        />
                        <span>Delete</span>
                    </b-dropdown-item>
                </b-dropdown>
            </template>

            <!-- Selection Area -->
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
        <b-row>
            <b-col md="12">
                <hr>
                <h4>Item Details</h4>
                <hr>
            </b-col>
        </b-row>
        <validation-observer ref="simpleRules">
            <b-form>
                <b-row>
                    <b-col md="7">
                        <b-row>
                            <b-col md="12">
                                <b-form-group
                                    label="Select Item"
                                    label-for="itemId"
                                >
                                    <v-select
                                        v-model="salesReturnItemData.itemId"
                                        placeholder="Select Item"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="ItemListOption"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        v-on:input="getItemDetails(salesReturnItemData.itemId)"
                                        input-id="itemId"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <validation-provider
                                    #default="{ errors }"
                                    name="Item Code"
                                    rules=""
                                >
                                    <b-form-group
                                        label="Item Code"
                                        label-for="itemCode"
                                    >
                                        <b-form-input
                                            id="itemCode"
                                            v-model="salesReturnItemData.itemCode"
                                            :state="errors.length > 0 ? false:null"
                                        />
                                        <small class="text-danger">{{ errors[0] }}</small>
                                    </b-form-group>
                                </validation-provider>
                            </b-col>
                            <b-col md="8">
                                <validation-provider
                                    #default="{ errors }"
                                    name="Item Description"
                                    rules="required"
                                >
                                    <b-form-group
                                        label="Item Description"
                                        label-for="itemName"
                                        :state="errors.length > 0 ? false:null"
                                    >
                                        <b-form-input
                                            id="itemName"
                                            v-model="salesReturnItemData.itemName"
                                            :state="errors.length > 0 ? false:null"
                                        />
                                        <small class="text-danger">{{ errors[0] }}</small>
                                    </b-form-group>
                                </validation-provider>
                            </b-col>
                            <b-col md="12">
                                <b-form-group
                                    label="MSN Number"
                                    label-for="itemMsnNumber"
                                >
                                    <b-form-input
                                        id="itemMsnNumber"
                                        v-model="salesReturnItemData.itemMsnNumber"
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
                                        v-model="salesReturnItemData.itemDetailDescription"
                                        rows="1"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Item Desc (Cust)"
                                    label-for="itemCustomDescription"
                                >
                                    <b-form-textarea
                                        id="itemCustomDescription"
                                        v-model="salesReturnItemData.itemCustomDescription"
                                        rows="1"
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
                                        v-model="salesReturnItemData.itemAddonDescription"
                                        rows="1"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group
                                    label="Drawing Number"
                                    label-for="itemDrawingNo"
                                >
                                    <b-form-input
                                        id="itemDrawingNo"
                                        v-model="salesReturnItemData.itemDrawingNo"
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
                                        v-model="salesReturnItemData.itemDrawingRev"
                                    />
                                </b-form-group>
                            </b-col>

                            <b-col md="4">
                                <b-form-group
                                    label="UOM"
                                    label-for="itemUom"
                                >
                                    <v-select
                                        v-model="salesReturnItemData.itemUom"
                                        placeholder="Select UOM"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="UomListOption"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        input-id="itemUom"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="12">
                                <b-form-group
                                    label="HSN No."
                                    label-for="itemHsnSacNo"
                                >
                                    <b-form-input
                                        id="itemHsnSacNo"
                                        v-model="salesReturnItemData.itemHsnSacNo"
                                    />
                                </b-form-group>
                            </b-col>

                            <b-col md="6">
                                <b-form-group
                                    label="Item Note"
                                    label-for="itemNote"
                                >
                                    <b-form-textarea
                                        id="itemNote"
                                        v-model="salesReturnItemData.itemNote"
                                        rows="1"
                                    />
                                </b-form-group>
                            </b-col>

                            <b-col md="6">
                                <b-form-group
                                    label="Reason"
                                    label-for="reason"
                                >
                                    <b-form-textarea
                                        id="reason"
                                        v-model="salesReturnItemData.reason"
                                        rows="1"
                                    />
                                </b-form-group>
                            </b-col>

                        </b-row>
                    </b-col>
                    <b-col md="5">
                        <b-row>
                            <b-col md="6">
                                <b-form-group
                                    label="Invoice Date"
                                    label-for="invoiceDate"
                                >
                                    <!--<b-form-datepicker
                                        id="invoiceDate"
                                        :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }"
                                        locale="in"
                                        v-model="salesReturnItemData.invoiceDate"
                                        class="mb-1"
                                    />-->
                                    <b-input-group>
                                        <b-input-group-prepend>
                                            <b-form-datepicker
                                                v-model="formatDates.salesReturnDate"
                                                button-only
                                                @input="getInvoiceFormatDate($event)"
                                                show-decade-nav
                                                size="sm"
                                                nav-button-variant="primary"
                                            />
                                        </b-input-group-prepend>
                                        <cleave
                                            id="invoiceDate"
                                            v-model="salesReturnItemData.invoiceDate"
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
                                    label="Invoice No"
                                    label-for="invoiceNo"
                                >
                                    <b-form-input
                                        id="invoiceNo"
                                        v-model="salesReturnItemData.invoiceNo"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Quantity"
                                    label-for="itemQuantity"
                                >
                                    <b-form-input
                                        id="itemQuantity"
                                        v-model="salesReturnItemData.itemQuantity"
                                        type="number"
                                        @keyup="getItemCalculation"
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
                                        v-model="salesReturnItemData.itemRate"
                                        type="number"
                                        @keyup="getItemCalculation"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="12">
                                <b-form-group
                                    label="Amount"
                                    label-for="itemAmount"
                                >
                                    <b-form-input
                                        id="itemAmount"
                                        v-model="salesReturnItemData.itemAmount"
                                        type="number"
                                        disabled
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
                                        v-model="salesReturnItemData.cgstPercentage"
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
                                        v-model="salesReturnItemData.sgstPercentage"
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
                                        v-model="salesReturnItemData.igstPercentage"
                                        @keyup="calculateGstAmount"
                                    />
                                </b-form-group>
                            </b-col>

                            <b-col md="12">
                                <hr>
                                <h5>Rejected Item Code For Stock Return Entry</h5>
                                <hr>
                            </b-col>

                            <b-col md="12">
                                <b-form-group
                                    label="Select Item"
                                    label-for="rejectedItemId"
                                >

                                    <v-select
                                        v-model="salesReturnItemData.rejectedItemId"
                                        placeholder="Select Item"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="ItemListOption"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        v-on:input="getItemRejectedDetails(salesReturnItemData.rejectedItemId)"
                                        input-id="rejectedItemId"
                                    />

                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group
                                    label="Item Code"
                                    label-for="rejectedItemCode"
                                >
                                    <b-form-input
                                        id="rejectedItemCode"
                                        v-model="salesReturnItemData.rejectedItemCode"
                                        readonly
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="8">
                                <b-form-group
                                    label="Item Description"
                                    label-for="rejectedItemName"
                                >
                                    <b-form-input
                                        id="rejectedItemName"
                                        v-model="salesReturnItemData.rejectedItemName"
                                        readonly
                                    />
                                </b-form-group>
                            </b-col>

                        </b-row>
                    </b-col>
                </b-row>
                <b-row>
                    <!-- submit and reset -->
                    <b-col md="12">
                        <hr>
                        <b-button
                            v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                            type="submit"
                            variant="primary"
                            class="mr-1 float-right"
                            @click.prevent="validationForm"
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
import BCardCode from '@core/components/b-card-code'
import {ValidationProvider, ValidationObserver} from 'vee-validate'
import {
    BRow,
    BCol,
    BFormGroup,
    BFormInput,
    BFormTextarea,
    BForm,
    BDropdown,
    BDropdownItem,
    BButton,
    BFormDatepicker,
    BOverlay,
    BTable,
    BFormRadio,
    BSpinner,
    BInputGroup,
    BInputGroupPrepend,
    BInputGroupAppend
} from 'bootstrap-vue'
import {required} from '@validations'
import Ripple from 'vue-ripple-directive'
import vSelect from 'vue-select'
import router from '@/router'
import store from '@/store'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
import {ref, computed, onMounted, onUnmounted} from '@vue/composition-api'
import salesStoreModule from '../../salesStoreModule'
import axios from '@axios'
import {billingTerm} from '../billingTermHelper.js'
import {changeAmountDecimalPoint, changeToRound} from "@core/utils/utils";
import Cleave from 'vue-cleave-component'
import {forMatIndianDate} from "@core/utils/utils";

export default {
    components: {
        BCardCode,
        ValidationProvider,
        ValidationObserver,
        BRow,
        BCol,
        BFormGroup,
        BFormInput,
        BFormTextarea,
        BForm,
        BButton,
        BDropdown,
        BDropdownItem,
        BFormDatepicker,
        vSelect,
        BOverlay,
        BTable,
        BFormRadio,
        BSpinner,
        BInputGroup,
        BInputGroupPrepend,
        BInputGroupAppend,
        Cleave
    },
    directives: {
        Ripple,
    },
    methods: {
        async validationForm() {
            await this.$refs.simpleRules.validate().then(success => {
                if (success) {
                    const hasIdExist = this.containsKey(this.salesReturnItemData, '_id')
                    if (hasIdExist) {
                        this.salesReturnItemData.id = this.salesReturnItemData._id
                        delete this.salesReturnItemData._id
                        store.dispatch('sr-items-module/updateSalesReturnItems', this.salesReturnItemData).then(response => {
                            if (response.status === 200) {
                                this.billingTermDetails.refetchTermData(router.currentRoute.params.id, this.salesReturnCustomerID);
                                this.resetItemFormData();
                                this.refetchItemData();
                                this.$toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: 'Item Updated',
                                        icon: 'CheckSquareIcon',
                                        variant: 'success',
                                        text: `You have successfully Updated Item.`,
                                    },
                                });
                            }
                        });
                    } else {
                        store.dispatch('sr-items-module/addSalesReturnItems', this.salesReturnItemData).then(response => {
                            if (response.status === 200) {
                                this.billingTermDetails.refetchTermData(router.currentRoute.params.id, this.salesReturnCustomerID)
                                this.resetItemFormData()
                                this.refetchItemData()
                                this.$toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: 'Item Added',
                                        icon: 'CheckSquareIcon',
                                        variant: 'success',
                                        text: `You have successfully Added New Item.`,
                                    },
                                });
                            }
                        });
                    }
                }
            });
        },
        containsKey(obj, key) {
            return Object.keys(obj).includes(key)
        },
        deleteSalesOrderItem(id) {
            this.$swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                customClass: {
                    confirmButton: 'btn btn-primary',
                    cancelButton: 'btn btn-outline-danger ml-1',
                },
                buttonsStyling: false,
            }).then(result => {
                if (result.value) {
                    store.dispatch(`sr-items-module/deleteSalesReturnItems`, {id}).then(response => {
                        if (response.data.status === 200) {
                            this.billingTermDetails.refetchTermData(router.currentRoute.params.id, this.salesReturnCustomerID)
                            this.refetchItemData()
                            this.$toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: `Deleted`,
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: `Department Deleted Successfully`,
                                },
                            });
                        } else {
                            this.$toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: `Error`,
                                    icon: 'AlertCircleIcon',
                                    variant: 'danger',
                                    text: `something went wrong`,
                                },
                            });
                        }
                    });
                }
            });
        }
    },
    props: ['salesReturnCustomerID', 'salesReturnRoundingType'],
    setup(props) {
        const SRI_APP_STORE_MODULE_NAME = 'sr-items-module';
        // Register module
        onMounted(() => {
            if (!store.hasModule(SRI_APP_STORE_MODULE_NAME)) store.registerModule(SRI_APP_STORE_MODULE_NAME, salesStoreModule)
        });
        // UnRegister on leave
        onUnmounted(() => {
            if (store.hasModule(SRI_APP_STORE_MODULE_NAME)) store.unregisterModule(SRI_APP_STORE_MODULE_NAME);
        });

        const CurrentSrId = ref(router.currentRoute.params.id);

        const roundingType = computed(() => props.salesReturnRoundingType)

        const ItemListOption = ref([]);

        const UomListOption = ref([]);

        const isBusy = ref(true);

        const itemFields = ref([
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
                key: 'itemName',
                label: 'Item Name',
            },
            {
                key: 'itemName',
                label: 'Description',
            },
            {
                key: 'itemUom',
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
                key: 'itemAmount',
                label: 'Amount',
            },
            {
                key: 'rejectedItemCode',
                label: 'SR Item code',
            },
            {
                key: 'rejectedItemName',
                label: 'SR Item Desc',
            },
            {
                key: 'action',
                label: 'Action',
            },
        ]);

        const listOfItems = ref([])

        axios.get('/api/get-uom-master-options').then(res => {
            UomListOption.value = res.data.data
        })

        const refetchItemData = async () => {
            isBusy.value = true;
            await axios.get(`/api/get-sales-return-items/${CurrentSrId.value}`).then(res => {
                listOfItems.value = res.data.data;
            });
            isBusy.value = false;
        }
        refetchItemData();

        const salesReturnItemData = ref({
            id: null,
            salesReturnId: CurrentSrId.value,
            invoiceNo: null,
            invoiceDate: null,
            itemId: null,
            itemCode: null,
            itemName: null,
            itemCustomDescription: null,
            itemAddonDescription: null,
            itemDetailDescription: null,
            itemDrawingNo: null,
            itemDrawingRev: null,
            itemProject: null,
            itemInternalNote: null,
            itemUom: null,
            itemCustPartNo: null,
            itemNote: null,
            itemQuantity: null,
            itemRate: null,
            itemDiscount: null,
            itemDiscountVal: 0,
            itemNetAmount: 0,
            itemAmount: 0,
            itemMsnNumber: null,
            itemHsnSacNo: null,
            rejectedItemId: null,
            rejectedItemCode: null,
            rejectedItemName: null,
            reason: null,
            cgstPercentage: 0,
            sgstPercentage: 0,
            igstPercentage: 0,
            cgstAmount: null,
            sgstAmount: null,
            igstAmount: null,
        });

        const onRowSelected = (items) => {
            if (items.length > 0) {
                salesReturnItemData.value._id = items[0]._id
                salesReturnItemData.value.salesReturnId = items[0].salesReturnId
                salesReturnItemData.value.invoiceNo = items[0].invoiceNo ?? null
                salesReturnItemData.value.invoiceDate = items[0].invoiceDate ?? null
                salesReturnItemData.value.itemId = items[0].itemId ?? null
                salesReturnItemData.value.itemCode = items[0].itemCode ?? null
                salesReturnItemData.value.itemName = items[0].itemName ?? null
                salesReturnItemData.value.itemCustomDescription = items[0].itemCustomDescription ?? null
                salesReturnItemData.value.itemAddonDescription = items[0].itemAddonDescription ?? null
                salesReturnItemData.value.itemDetailDescription = items[0].itemDetailDescription ?? null
                salesReturnItemData.value.itemDrawingNo = items[0].itemDrawingNo ?? null
                salesReturnItemData.value.itemDrawingNo = items[0].itemDrawingNo ?? null
                salesReturnItemData.value.itemDrawingRev = items[0].itemDrawingRev ?? null
                salesReturnItemData.value.itemProject = items[0].itemProject ?? null
                salesReturnItemData.value.itemInternalNote = items[0].itemInternalNote ?? null
                salesReturnItemData.value.itemUom = items[0].itemUom ?? null
                salesReturnItemData.value.itemCustPartNo = items[0].itemCustPartNo ?? null
                salesReturnItemData.value.itemNote = items[0].itemNote ?? null
                salesReturnItemData.value.itemQuantity = items[0].itemQuantity ?? null
                salesReturnItemData.value.itemRate = items[0].itemRate ?? null
                salesReturnItemData.value.itemDiscount = items[0].itemDiscount ?? null
                salesReturnItemData.value.itemDiscountVal = items[0].itemDiscountVal ?? null
                salesReturnItemData.value.itemNetAmount = items[0].itemNetAmount ?? null
                salesReturnItemData.value.itemAmount = items[0].itemAmount ?? null
                salesReturnItemData.value.itemMsnNumber = items[0].itemMsnNumber ?? null
                salesReturnItemData.value.itemHsnSacNo = items[0].itemHsnSacNo ?? null
                salesReturnItemData.value.rejectedItemId = items[0].rejectedItemId ?? null
                salesReturnItemData.value.rejectedItemCode = items[0].rejectedItemCode ?? null
                salesReturnItemData.value.rejectedItemName = items[0].rejectedItemName ?? null
                salesReturnItemData.value.reason = items[0].reason ?? null
                salesReturnItemData.value.cgstPercentage = items[0].cgstPercentage ?? null
                salesReturnItemData.value.sgstPercentage = items[0].sgstPercentage ?? null
                salesReturnItemData.value.igstPercentage = items[0].igstPercentage ?? null
                salesReturnItemData.value.cgstAmount = items[0].cgstAmount ?? null
                salesReturnItemData.value.sgstAmount = items[0].sgstAmount ?? null
                salesReturnItemData.value.igstAmount = items[0].igstAmount ?? null
            } else {
                resetItemFormData()
            }
        }

        axios.get('/api/get-item-master-options').then(res => {
            ItemListOption.value = res.data.data
        });

        const getItemDetails = async (val) => {
            await axios.get(`/api/item-master/${val}`).then((res) => {
                salesReturnItemData.value.itemCode = res.data.data.itemCode
                salesReturnItemData.value.itemName = res.data.data.itemDescription
                if (res.data.data.itemDetails) {
                    salesReturnItemData.value.itemDetailDescription = res.data.data.itemDetails.detailDescription
                    salesReturnItemData.value.itemAddonDescription = res.data.data.itemDetails.description
                    salesReturnItemData.value.itemDrawingNo = res.data.data.itemDetails.drawingNumber
                    salesReturnItemData.value.itemDrawingRev = res.data.data.itemDetails.revision
                }
                salesReturnItemData.value.itemUom = res.data.data.uom ?? null
                salesReturnItemData.value.itemHsnSacNo = res.data.data?.hsnSacDetails?.hsnSacNo ?? null
            });
        }

        const getItemRejectedDetails = async (val) => {
            await axios.get(`/api/item-master/${val}`).then(res => {
                salesReturnItemData.value.rejectedItemCode = res.data.data.itemCode
                salesReturnItemData.value.rejectedItemName = res.data.data.itemDescription
            });
        }

        const resetItemFormData = () => {
            salesReturnItemData.value = {
                id: null,
                salesReturnId: CurrentSrId.value,
                invoiceNo: null,
                invoiceDate: null,
                itemId: null,
                itemCode: null,
                itemName: null,
                itemCustomDescription: null,
                itemAddonDescription: null,
                itemDetailDescription: null,
                itemDrawingNo: null,
                itemDrawingRev: null,
                itemProject: null,
                itemInternalNote: null,
                itemUom: null,
                itemCustPartNo: null,
                itemNote: null,
                itemQuantity: null,
                itemRate: null,
                itemDiscount: null,
                itemDiscountVal: 0,
                itemNetAmount: 0,
                itemAmount: 0,
                rejectedItemId: null,
                rejectedItemCode: null,
                rejectedItemName: null,
                reason: null,
                cgstPercentage: 0,
                sgstPercentage: 0,
                igstPercentage: 0,
                cgstAmount: null,
                sgstAmount: null,
                igstAmount: null,
            }
        }

        const getUomName = (uom) => {
            let valObj = UomListOption.value.filter(function (elem) {
                if (elem.value === uom) {
                    return elem.label
                }
            });

            if (valObj.length > 0) {
                return valObj[0].label
            } else {
                return ''
            }
        }

        const getItemCalculation = () => {
            if (roundingType.value !== '0') {
                salesReturnItemData.value.itemAmount = changeAmountDecimalPoint(changeToRound(salesReturnItemData.value.itemQuantity * salesReturnItemData.value.itemRate));
                salesReturnItemData.value.itemDiscountVal = changeAmountDecimalPoint(changeToRound((salesReturnItemData.value.itemAmount * salesReturnItemData.value.itemDiscount) / 100));
                salesReturnItemData.value.itemNetAmount = changeAmountDecimalPoint(changeToRound(salesReturnItemData.value.itemAmount - salesReturnItemData.value.itemDiscountVal ?? 0), 2);
            } else {
                salesReturnItemData.value.itemAmount = salesReturnItemData.value.itemQuantity * salesReturnItemData.value.itemRate
                salesReturnItemData.value.itemDiscountVal = (salesReturnItemData.value.itemAmount * salesReturnItemData.value.itemDiscount) / 100
                salesReturnItemData.value.itemNetAmount = (salesReturnItemData.value.itemAmount - salesReturnItemData.value.itemDiscountVal ?? 0)
            }
        }

        const selectedRadio = ref('2')

        const getSelectItem = async () => {
            if (selectedRadio.value === '1') {
                /*await axios.get('/api/get-party-items-from-orders/'.concat(pCustomerID.value)).then(res => {
                    //modalTable.value.salesOrderData = res.data.data
                    console.log(res.data.data)
                })
                salesOrderModal.value.show()*/
                console.log(selectedRadio.value)
            }
        }

        const calculateGstAmount = () => {
            salesReturnItemData.value.cgstAmount = changeAmountDecimalPoint(changeToRound((parseFloat(salesReturnItemData.value.itemNetAmount) * parseFloat(salesReturnItemData.value.cgstPercentage) / 100)), 2);
            salesReturnItemData.value.sgstAmount = changeAmountDecimalPoint(changeToRound((parseFloat(salesReturnItemData.value.itemNetAmount) * parseFloat(salesReturnItemData.value.sgstPercentage) / 100)), 2);
            salesReturnItemData.value.igstAmount = changeAmountDecimalPoint(changeToRound((parseFloat(salesReturnItemData.value.itemNetAmount) * parseFloat(salesReturnItemData.value.igstPercentage) / 100)), 2);
        }

        const billingTermDetails = billingTerm

        const dateFormat = ref({
            date: true,
            delimiter: '/',
            datePattern: ['d', 'm', 'Y'],
        });

        const formatDates = ref({
            invoiceDate: null,
        });

        const getInvoiceFormatDate = (date) => {
            salesReturnItemData.value.invoiceDate = forMatIndianDate(date)
        }

        return {
            CurrentSrId,
            itemFields,
            listOfItems,
            salesReturnItemData,
            ItemListOption,
            getItemDetails,
            getItemRejectedDetails,
            refetchItemData,
            resetItemFormData,
            UomListOption,
            getUomName,
            getItemCalculation,
            required,
            selectedRadio,
            getSelectItem,
            billingTermDetails,
            calculateGstAmount,
            isBusy,
            roundingType,
            dateFormat,
            formatDates,
            getInvoiceFormatDate,
            onRowSelected
        }
    },
}
</script>
<style lang="scss">
@import '~@core/scss/vue/libs/vue-select.scss';
</style>
