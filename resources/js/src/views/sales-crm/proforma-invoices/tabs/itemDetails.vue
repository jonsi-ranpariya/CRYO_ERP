<template>
    <div>
        <hr>
        <b-row>
            <b-col md="12">
                <div class="demo-inline-spacing text-center">
                    <b-form-radio
                        v-model="selectedRadio"
                        name="some-radios"
                        value="1"
                        selected
                    >
                        From Sales Order
                    </b-form-radio>
                    <b-form-radio
                        v-model="selectedRadio"
                        name="some-radios"
                        value="2"
                    >
                        From Quotation
                    </b-form-radio>
                    <b-button
                        variant="primary"
                        type="button"
                        @click="getSelectItem"
                        class="ml-1"
                    >
                        Select Item
                    </b-button>
                </div>
            </b-col>
        </b-row>
        <hr>
        <b-table
            :fields="itemFields"
            :items="listOfItems"
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

            <!-- A custom formatted column -->
            <template #cell(itemName)="data">
                <span class="text-nowrap">{{ data.value}}</span>
            </template>

            <!-- A custom formatted column -->
            <template #cell(itemUom)="data">
                <span class="text-nowrap">{{ getUomName(data.value)}}</span>
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
                                    <validation-provider
                                        #default="{ errors }"
                                        name="Item"
                                        rules="required"
                                    >
                                        <v-select
                                            v-model="proformaInvoiceItemData.itemId"
                                            placeholder="Select Item"
                                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                            :options="ItemListOption"
                                            :reduce="val => val.value"
                                            :clearable="false"
                                            v-on:input="getItemDetails(proformaInvoiceItemData.itemId)"
                                            input-id="itemId"
                                            :state="errors.length > 0 ? false:null"
                                        />
                                        <small class="text-danger">{{ errors[0] }}</small>
                                    </validation-provider>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group
                                    label="Item Code"
                                    label-for="itemCode"
                                >
                                    <b-form-input
                                        id="itemCode"
                                        v-model="proformaInvoiceItemData.itemCode"
                                        readonly
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="8">
                                <b-form-group
                                    label="Item Description"
                                    label-for="itemName"
                                >
                                    <b-form-input
                                        id="itemName"
                                        v-model="proformaInvoiceItemData.itemName"
                                        readonly
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group
                                    label="Item Desc (Cust)"
                                    label-for="itemCustomDescription"
                                >
                                    <b-form-textarea
                                        id="itemCustomDescription"
                                        v-model="proformaInvoiceItemData.itemCustomDescription"
                                        rows="1"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group
                                    label="Add. Description"
                                    label-for="itemAddonDescription"
                                >
                                    <b-form-textarea
                                        id="itemAddonDescription"
                                        v-model="proformaInvoiceItemData.itemAddonDescription"
                                        rows="1"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group
                                    label="Detail Description"
                                    label-for="itemDetailDescription"
                                >
                                    <b-form-textarea
                                        id="itemDetailDescription"
                                        v-model="proformaInvoiceItemData.itemDetailDescription"
                                        rows="1"
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
                                        v-model="proformaInvoiceItemData.itemDrawingNo"
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
                                        v-model="proformaInvoiceItemData.itemDrawingRev"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group
                                    label="Cust Part No."
                                    label-for="itemCustPartNo"
                                >
                                    <b-form-textarea
                                        id="itemCustPartNo"
                                        v-model="proformaInvoiceItemData.itemCustPartNo"
                                        rows="1"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group
                                    label="Internal Note"
                                    label-for="itemInternalNote"
                                >
                                    <b-form-textarea
                                        id="itemInternalNote"
                                        v-model="proformaInvoiceItemData.itemInternalNote"
                                        rows="1"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group
                                    label="Item Note"
                                    label-for="itemNote"
                                >
                                    <b-form-textarea
                                        id="itemNote"
                                        v-model="proformaInvoiceItemData.itemNote"
                                        rows="1"
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>
                    </b-col>
                    <b-col md="5">
                        <b-row>
                            <b-col md="12">
                                <b-form-group
                                    label="UOM"
                                    label-for="itemUom"
                                >
                                    <v-select
                                        v-model="proformaInvoiceItemData.itemUom"
                                        placeholder="Select UOM"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="UomListOption"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        input-id="itemUom"
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
                                        v-model="proformaInvoiceItemData.itemQuantity"
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
                                        v-model="proformaInvoiceItemData.itemRate"
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
                                        v-model="proformaInvoiceItemData.itemAmount"
                                        type="number"
                                        disabled
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
                                        v-model="proformaInvoiceItemData.itemDiscount"
                                        type="number"
                                        @keyup="getItemCalculation"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Discount Value"
                                    label-for="itemDiscountVal"
                                >
                                    <b-form-input
                                        id="itemDiscountVal"
                                        v-model="proformaInvoiceItemData.itemDiscountVal"
                                        type="number"
                                        disabled
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="12">
                                <b-form-group
                                    label="Net Amount"
                                    label-for="itemNetAmount"
                                >
                                    <b-form-input
                                        id="itemNetAmount"
                                        v-model="proformaInvoiceItemData.itemNetAmount"
                                        type="number"
                                        disabled
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Item Status"
                                    label-for="itemStatus"
                                >
                                    <v-select
                                        v-model="proformaInvoiceItemData.itemStatus"
                                        placeholder="Select Status"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="StatusListOption"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        input-id="itemStatus"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Item Type"
                                    label-for="itemType"
                                >
                                    <v-select
                                        v-model="proformaInvoiceItemData.itemType"
                                        placeholder="Select Item Type"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="ItemTypeListOption"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        input-id="itemType"
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>
                    </b-col>
                </b-row>
                <b-row>
                    <!-- submit and reset -->
                    <b-col>
                        <b-button
                            v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                            type="submit"
                            variant="primary"
                            class="mr-1"
                            @click.prevent="validationForm"
                        >
                            Add / Save Item
                        </b-button>
                    </b-col>
                </b-row>
            </b-form>
        </validation-observer>
        <!-- Sales Order Modal -->
        <b-modal
            id="salesOrderModal"
            title="Sales Order Item"
            ok-title="submit"
            cancel-variant="danger"
            size="lg"
            no-close-on-backdrop
            ref="salesOrderModal"
            @ok="getSalesOrderItems"
            @cancel="resetSalesOrderIds"
            @close="resetSalesOrderIds"
        >
            <b-table
                :fields="modalTable.salesOrderFields"
                :items="modalTable.salesOrderData"
                :no-border-collapse="false"
                responsive
                bordered
                hover
                show-empty
                class="table_scroll"
            >
                <template #empty="scope">
                    <h5 class="text-center text-uppercase">No Sales Order Items Available</h5>
                </template>

                <template #cell(action)="data">
                    <b-form-checkbox
                        :value="`${data.item._id}`"
                        class="custom-control-primary"
                        @change="selectedItemIds($event, data.item._id)"
                    />
                </template>
            </b-table>
        </b-modal>
        <!--Sales Quotation Modal-->
        <b-modal
            id="salesQuotationModal"
            title="Sales Quotation"
            ok-title="submit"
            cancel-variant="danger"
            size="lg"
            no-close-on-backdrop
            ref="salesQuotationModal"
            @ok="getSelectedQuotationItems"
            @cancel="resetQuotationItemsData"
            @close="resetQuotationItemsData"
            scrollable
        >
            <b-table
                :fields="modalTable.salesQuotationFields"
                :items="modalTable.salesQuotationData"
                :no-border-collapse="false"
                responsive
                bordered
                hover
                show-empty
                class="table_scroll"
            >
                <template #empty="scope">
                    <h5 class="text-center text-uppercase">No Sales Quotation Items Available</h5>
                </template>

                <template #cell(action)="data">
                    <b-button
                        variant="flat-primary"
                        type="button"
                        size="sm"
                        @click="getQuotationItemData(data.item)"
                    >
                        Select
                    </b-button>
                </template>
                <template #cell(status)="data">
                    <span v-for="status in statusOptions">
                        <span v-if="status.value === data.item.status">{{status.label}}</span>
                    </span>
                </template>
                <template #cell(sales)="data">
                    <span v-for="sales in salesOptions">
                        <span v-if="sales.value === data.item.sales">{{sales.label}}</span>
                    </span>
                </template>
            </b-table>
            <b-table
                :fields="modalTable.salesQuotationItemFields"
                :items="modalTable.salesQuotationItemData"
                :no-border-collapse="false"
                responsive
                bordered
                hover
                show-empty
            >
                <!--Empty Data-->
                <template #empty="scope">
                    <h5 class="text-center text-uppercase">No Sales Quotation Items Available</h5>
                </template>
                <!--Actions-->
                <template #cell(action)="data">
                    <b-form-checkbox
                        :value="`${data.item._id}`"
                        class="custom-control-primary"
                        @change="selectQuotationItem($event, data.item._id)"
                    />
                </template>
                <!--Index-->
                <template #cell(index)="data">
                    <span>{{ data.index + 1}}</span>
                </template>
                <!--Status-->
                <template #cell(status)="data">
                    <span v-for="status in statusOptions">
                        <span v-if="status.value === data.item.status">{{status.label}}</span>
                    </span>
                </template>
            </b-table>
        </b-modal>
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
        BFormCheckbox
    } from 'bootstrap-vue'
    import {required} from '@validations'
    import Ripple from 'vue-ripple-directive'
    import vSelect from 'vue-select'
    import router from '@/router'
    import store from '@/store'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import {ref, computed, onUnmounted} from '@vue/composition-api'
    import salesStoreModule from '../../salesStoreModule'
    import axios from '@axios'
    import {billingTerm} from '../billingTermHelper.js'

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
            BFormCheckbox
        },
        directives: {
            Ripple,
        },
        props: {
            pInvoiceNo: String,
            pInvoiceCustomerID: String
        },
        emits: ['updateBillingTerms'],
        methods: {
            validationForm() {
                this.$refs.simpleRules.validate().then(success => {
                    if (success) {
                        const hasIdExist = this.containsKey(this.proformaInvoiceItemData, '_id')
                        if (hasIdExist) {
                            this.proformaInvoiceItemData.id = this.proformaInvoiceItemData._id
                            delete this.proformaInvoiceItemData._id
                            store.dispatch('proforma-invoices-module/updateProformaInvoiceItems', this.proformaInvoiceItemData).then(response => {
                                if (response.status === 200) {
                                    this.resetItemFormData()
                                    this.refetchItemData()
                                    this.bilingTerm.refetchBillingTerm(this.pInvoiceCustomerID)
                                    this.$toast({
                                        component: ToastificationContent,
                                        position: 'top-right',
                                        props: {
                                            title: 'Item Edited',
                                            icon: 'CheckSquareIcon',
                                            variant: 'success',
                                            text: `You have successfully Edited Item : ${this.proformaInvoiceItemData.itemCode}.`,
                                        },
                                    })
                                }
                            })
                        } else {
                            store.dispatch('proforma-invoices-module/addProformaInvoiceItems', this.proformaInvoiceItemData).then(response => {
                                if (response.status === 200) {
                                    this.resetItemFormData()
                                    this.refetchItemData()
                                    this.bilingTerm.refetchBillingTerm(this.pInvoiceCustomerID)
                                    this.$toast({
                                        component: ToastificationContent,
                                        position: 'top-right',
                                        props: {
                                            title: 'Item Created',
                                            icon: 'CheckSquareIcon',
                                            variant: 'success',
                                            text: `You have successfully Created New Item : ${this.proformaInvoiceItemData.itemCode}.`,
                                        },
                                    })
                                }
                            })
                        }
                    }
                })
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
                        store.dispatch(`proforma-invoices-module/deleteProformaInvoiceItems`, {id}).then(response => {
                            if (response.data.status === 200) {
                                this.refetchItemData()
                                this.resetItemFormData()
                                this.bilingTerm.refetchBillingTerm(this.pInvoiceCustomerID)
                                this.$toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: `Deleted`,
                                        icon: 'CheckSquareIcon',
                                        variant: 'success',
                                        text: `Department Deleted Successfully`,
                                    },
                                })
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
                                })
                            }
                        })
                    }
                })
            }
        },
        setup(props, {emit, salesOrderModal, salesQuotationModal}) {
            const PI_APP_STORE_MODULE_NAME = 'proforma-invoices-module'
            // Register module
            if (!store.hasModule(PI_APP_STORE_MODULE_NAME)) store.registerModule(PI_APP_STORE_MODULE_NAME, salesStoreModule)
            // UnRegister on leave
            onUnmounted(() => {
                if (store.hasModule(PI_APP_STORE_MODULE_NAME)) store.unregisterModule(PI_APP_STORE_MODULE_NAME)
            })

            const CurrentPiId = ref(router.currentRoute.params.id)
            const isBusy = ref(true)
            const CurrentPinvoiceNo = computed(() => props.pInvoiceNo)
            const pCustomerID = computed(() => props.pInvoiceCustomerID)
            const ItemListOption = ref([])
            const UomListOption = ref([])
            const StatusListOption = ref([
                {label: 'Pending', value: 'Pending'},
                {label: 'Completed', value: 'Completed'},
            ])
            const ItemTypeListOption = ref([
                {label: 'Manufacturing', value: 'Manufacturing'},
                {label: 'Trading', value: 'Trading'},
                {label: 'Job Work', value: 'Job Work'},
            ])
            const QtyRefListOption = ref([])
            const SalesTypeListOption = ref([
                {label: 'Specific To Party', value: 1},
                {label: 'Standard', value: 2},
            ])
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
                    key: 'itemNetAmount',
                    label: 'Amount',
                },
                {
                    key: 'itemSoNo',
                    label: 'SoNo',
                },
                {
                    key: 'itemQRevNo',
                    label: 'QRevNo',
                },
                {
                    key: 'itemStatus',
                    label: 'Status',
                },
                {
                    key: 'action',
                    label: 'Action',
                },
            ])
            const statusOptions = ref([
                {label: 'Hot', value: 1},
                {label: 'Cold', value: 2},
                {label: 'Received', value: 3},
                {label: 'Regret', value: 4},
                {label: 'Lost', value: 5},
            ])
            const salesOptions = ref([
                {label: 'Domestic', value: 1},
                {label: 'Export', value: 2},
            ])

            const listOfItems = ref([])

            axios.get('/api/get-uom-master-options').then(res => {
                UomListOption.value = res.data.data
            })

            const refetchItemData = async () => {
                isBusy.value = true
                await axios.get(`/api/get-proforma-invoice-items/${CurrentPiId.value}`).then(res => {
                    listOfItems.value = res.data.data
                })
                isBusy.value = false
            }
            refetchItemData()

            const proformaInvoiceItemData = ref({
                id: null,
                pInvoiceId: CurrentPiId.value,
                pInvoiceNo: CurrentPinvoiceNo,
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
                itemSalesType: 2,
                itemUom: null,
                itemCustPartNo: null,
                itemNote: null,
                itemQuantity: null,
                itemRate: null,
                itemDiscount: null,
                itemDiscountVal: 0,
                itemNetAmount: 0,
                itemAmount: 0,
                itemStatus: 'Pending',
                itemType: 'Trading',
                itemSoNo: null,
                itemQtnSrNo: null,
                itemQRevNo: null,
                itemStockStatus: null,
                itemHolUnhold: null,
                itemImage: null,
                itemWorkOrderDetail: null,
                itemDispatchDetail: null,
                itemDeliverySchedule: null,
            })

            const onRowSelected = (items) => {
                if (items.length > 0) {
                    proformaInvoiceItemData.value._id = items[0]._id
                    proformaInvoiceItemData.value.pInvoiceId = items[0].pInvoiceId
                    proformaInvoiceItemData.value.itemId = items[0].itemId
                    proformaInvoiceItemData.value.itemCode = items[0].itemCode ?? null
                    proformaInvoiceItemData.value.itemName = items[0].itemName ?? null
                    proformaInvoiceItemData .value.itemCustomDescription = items[0].itemCustomDescription ?? null
                    proformaInvoiceItemData .value.itemCustomDescription = items[0].itemCustomDescription ?? null
                    proformaInvoiceItemData .value.itemAddonDescription = items[0].itemAddonDescription ?? null
                    proformaInvoiceItemData .value.itemDetailDescription = items[0].itemDetailDescription ?? null
                    proformaInvoiceItemData .value.itemAddonDescription = items[0].itemAddonDescription ?? null
                    proformaInvoiceItemData .value.itemDrawingNo = items[0].itemDrawingNo ?? null
                    proformaInvoiceItemData .value.itemDrawingRev = items[0].itemDrawingRev ?? null
                    proformaInvoiceItemData .value.itemProject = items[0].itemProject ?? null
                    proformaInvoiceItemData .value.itemInternalNote = items[0].itemInternalNote ?? null
                    proformaInvoiceItemData .value.itemSalesType = items[0].itemSalesType ?? null
                    proformaInvoiceItemData .value.itemUom = items[0].itemUom ?? null
                    proformaInvoiceItemData .value.itemCustPartNo = items[0].itemCustPartNo ?? null
                    proformaInvoiceItemData .value.itemNote = items[0].itemNote ?? null
                    proformaInvoiceItemData .value.itemQuantity = items[0].itemQuantity ?? null
                    proformaInvoiceItemData .value.itemRate = items[0].itemRate ?? null
                    proformaInvoiceItemData .value.itemDiscount = items[0].itemDiscount ?? null
                    proformaInvoiceItemData .value.itemDiscountVal = items[0].itemDiscountVal ?? null
                    proformaInvoiceItemData .value.itemNetAmount = items[0].itemNetAmount ?? null
                    proformaInvoiceItemData .value.itemStatus = items[0].itemStatus ?? null
                    proformaInvoiceItemData .value.itemType = items[0].itemType ?? null
                    proformaInvoiceItemData .value.itemSoNo = items[0].itemSoNo ?? null
                    proformaInvoiceItemData .value.itemQtnSrNo = items[0].itemQtnSrNo ?? null
                    proformaInvoiceItemData .value.itemQRevNo = items[0].itemQRevNo ?? null
                    proformaInvoiceItemData .value.itemStockStatus = items[0].itemStockStatus ?? null
                    proformaInvoiceItemData .value.itemHolUnhold = items[0].itemHolUnhold ?? null
                    proformaInvoiceItemData .value.itemImage = items[0].itemImage ?? null
                    proformaInvoiceItemData .value.itemWorkOrderDetail = items[0].itemWorkOrderDetail ?? null
                    proformaInvoiceItemData .value.itemDispatchDetail = items[0].itemDispatchDetail ?? null
                    proformaInvoiceItemData .value.itemDeliverySchedule = items[0].itemDeliverySchedule ?? null
                } else {
                    resetItemFormData()
                }
            }

            axios.get('/api/get-item-master-options').then(res => {
                ItemListOption.value = res.data.data
            })

            const getItemDetails = async (val) => {
                await axios.get(`/api/item-master/${val}`).then(res => {
                    proformaInvoiceItemData.value.itemCode = res.data.data.itemCode
                    proformaInvoiceItemData.value.itemName = res.data.data.itemDescription
                    if (res.data.data.itemDetails) {
                        proformaInvoiceItemData.value.itemDetailDescription = res.data.data.itemDetails.detailDescription
                        proformaInvoiceItemData.value.itemDrawingNo = res.data.data.itemDetails.drawingNumber
                        proformaInvoiceItemData.value.itemDrawingRev = res.data.data.itemDetails.revision
                    }
                })
            }

            const resetItemFormData = () => {
                proformaInvoiceItemData.value = {
                    id: null,
                    pInvoiceId: CurrentPiId.value,
                    pInvoiceNo: CurrentPinvoiceNo,
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
                    itemSalesType: 2,
                    itemUom: null,
                    itemCustPartNo: null,
                    itemNote: null,
                    itemQuantity: null,
                    itemRate: null,
                    itemDiscount: null,
                    itemDiscountVal: 0,
                    itemNetAmount: 0,
                    itemAmount: 0,
                    itemStatus: 'Pending',
                    itemType: 'Trading',
                    itemSoNo: null,
                    itemQRevNo: null,
                    itemDocuments: null,
                    itemStockStatus: null,
                    itemHolUnhold: null,
                    itemImage: null,
                    itemWorkOrderDetail: null,
                    itemDispatchDetail: null,
                    itemDeliverySchedule: null,
                }
            }

            const getUomName = (uom) => {
                let valObj = UomListOption.value.filter(function (elem) {
                    if (elem.value === uom) {
                        return elem.label
                    }
                })

                if (valObj.length > 0) {
                    return valObj[0].label
                } else {
                    return ''
                }
            }

            const getItemCalculation = () => {
                proformaInvoiceItemData.value.itemAmount = (proformaInvoiceItemData.value.itemQuantity * proformaInvoiceItemData.value.itemRate)
                proformaInvoiceItemData.value.itemDiscountVal = ((proformaInvoiceItemData.value.itemAmount * proformaInvoiceItemData.value.itemDiscount) / 100)
                proformaInvoiceItemData.value.itemNetAmount = (proformaInvoiceItemData.value.itemAmount - proformaInvoiceItemData.value.itemDiscountVal)
            }

            /*modalTable.salesOrderFields*/
            const modalTable = ref({
                salesOrderFields: [
                    {
                        key: 'action',
                        label: ''
                    },
                    {
                        key: 'salesOrderNo',
                        label: 'S.O.No'
                    },
                    {
                        key: 'custPo',
                        label: 'Cust P.O.'
                    },
                    {
                        key: 'itemCode',
                        label: 'Item Code'
                    },
                    {
                        key: 'itemDetailDescription',
                        label: 'Description'
                    },
                    {
                        key: 'uom_details.uom',
                        label: 'UOM'
                    },
                    {
                        key: 'itemDrawingNo',
                        label: 'Drawing No'
                    },
                    {
                        key: 'itemDrawingRev',
                        label: 'Rev'
                    },
                    {
                        key: 'itemQuantity',
                        label: 'Quantity'
                    },
                    {
                        key: 'itemRate',
                        label: 'Rate'
                    },
                    {
                        key: 'pendingQt',
                        label: 'Pending Qt'
                    },
                    {
                        key: 'status',
                        label: 'Status'
                    },
                    {
                        key: 'itemCustPartNo',
                        label: 'CustPartNo'
                    },
                    {
                        key: 'itemCustomDescription',
                        label: 'SItemDesc'
                    },
                ],
                salesOrderData: [],
                salesQuotationFields: [
                    {
                        key: 'action',
                        label: ''
                    },
                    {
                        key: 'quotationNo',
                        label: 'Quotation No'
                    },
                    {
                        key: 'rev',
                        label: 'Rev'
                    },
                    {
                        key: 'quotationDate',
                        label: 'Date',
                    },
                    {
                        key: 'enquiryNo',
                        label: 'Enquiry No'
                    },
                    {
                        key: 'status',
                        label: 'Status'
                    },
                    {
                        key: 'sales',
                        label: 'Sales'
                    },
                ],
                salesQuotationData: [],
                salesQuotationItemFields: [
                    {
                        key: 'action',
                        label: ''
                    },
                    {
                        key: 'index',
                        label: 'Sr No'
                    },
                    {
                        key: 'itemDescription',
                        label: 'Description'
                    },
                    {
                        key: 'uom_details.uom',
                        label: 'uom'
                    },
                    {
                        key: 'requireQty',
                        label: 'Quantity'
                    },
                    {
                        key: 'rate',
                        label: 'Rate'
                    },
                    {
                        key: 'amount',
                        label: 'Amount'
                    },
                    {
                        key: 'drawingNumber',
                        label: 'Drawing No'
                    },
                    {
                        key: 'version',
                        label: 'Version'
                    },
                    {
                        key: 'status',
                        label: 'status'
                    },
                ],
                salesQuotationItemData: []
            })

            const selectedRadio = ref('1')

            salesOrderModal = ref()
            salesQuotationModal = ref()

            const getSelectItem = async () => {
                if (selectedRadio.value === '1') {
                    await axios.get('/api/get-party-items-from-orders/'.concat(pCustomerID.value)).then(res => {
                        modalTable.value.salesOrderData = res.data.data
                    })
                    salesOrderModal.value.show()
                }
                if (selectedRadio.value === '2') {
                    await axios.get('/api/get-party-quotations/'.concat(pCustomerID.value)).then(res => {
                        modalTable.value.salesQuotationData = res.data.data
                    })
                    salesQuotationModal.value.show()
                }
            }

            const selectedSalesOrderItemIds = ref([])

            const selectedItemIds = (e, id) => {
                if (e === false) {
                    selectedSalesOrderItemIds.value.pop(id)
                } else {
                    selectedSalesOrderItemIds.value.push(id)
                }
            }

            const getSalesOrderItems = async () => {
                let ids = selectedSalesOrderItemIds.value
                if (ids.length > 0) {
                    await axios.post('/api/get-sales-order-items-details', {ids: ids}).then(res => {
                        let items = res.data.data
                        /*Spiliting Items From Array*/
                        if (items.length > 0) {
                            items.forEach((item) => {
                                proformaInvoiceItemData.value.itemAddonDescription = item.itemAddonDescription
                                proformaInvoiceItemData.value.itemAmount = item.itemAmount
                                proformaInvoiceItemData.value.itemCode = item.itemCode
                                proformaInvoiceItemData.value.itemCustPartNo = item.itemCustPartNo
                                proformaInvoiceItemData.value.itemCustomDescription = item.itemCustomDescription
                                proformaInvoiceItemData.value.itemDetailDescription = item.itemDetailDescription
                                proformaInvoiceItemData.value.itemDiscount = item.itemDiscount
                                proformaInvoiceItemData.value.itemDiscountVal = item.itemDiscountVal
                                proformaInvoiceItemData.value.itemDrawingNo = item.itemDrawingNo
                                proformaInvoiceItemData.value.itemDrawingRev = item.itemDrawingRev
                                proformaInvoiceItemData.value.itemId = item.itemId
                                proformaInvoiceItemData.value.itemName = item.itemName
                                proformaInvoiceItemData.value.itemNetAmount = item.itemNetAmount
                                proformaInvoiceItemData.value.itemNote = item.itemNote
                                proformaInvoiceItemData.value.itemQuantity = item.itemQuantity
                                proformaInvoiceItemData.value.itemRate = item.itemRate
                                proformaInvoiceItemData.value.itemUom = item.itemUom
                                proformaInvoiceItemData.value.itemSoNo = item.salesOrderNo
                                /*Storing Data*/
                                store.dispatch('proforma-invoices-module/addProformaInvoiceItems', proformaInvoiceItemData.value)
                            })
                            resetItemFormData()
                            refetchItemData()
                            bilingTerm.value.refetchBillingTerm(pCustomerID.value)
                        }
                    })
                }
                resetSalesOrderIds()
            }

            const resetSalesOrderIds = () => {
                selectedSalesOrderItemIds.value = []
            }

            const getQuotationItemData = (data) => {
                modalTable.value.salesQuotationItemData = data.item_details
            }

            const selectedQuotationItemIds = ref([])

            const selectQuotationItem = (e, id) => {
                if (e === false) {
                    selectedQuotationItemIds.value.pop(id)
                } else {
                    selectedQuotationItemIds.value.push(id)
                }
            }

            const getSelectedQuotationItems = async () => {
                let ids = selectedQuotationItemIds.value
                if (ids.length > 0) {
                    await axios.post('/api/get-quotation-item-list', {ids: ids}).then(res => {
                        let items = res.data.data
                        if (items.length > 0) {
                            items.forEach((item) => {
                                let itemId = item.itemCode.value
                                let codeName = item.itemCode.label.split('-')
                                proformaInvoiceItemData.value.itemAddonDescription = item.addDescription
                                proformaInvoiceItemData.value.itemAmount = item.amount
                                proformaInvoiceItemData.value.itemCode = codeName[0]
                                proformaInvoiceItemData.value.itemCustPartNo = item.custPartNo
                                proformaInvoiceItemData.value.itemCustomDescription = item.itemDescCust
                                proformaInvoiceItemData.value.itemDetailDescription = item.detailDescription
                                proformaInvoiceItemData.value.itemDiscount = item.discPercent
                                proformaInvoiceItemData.value.itemDiscountVal = item.discValue
                                proformaInvoiceItemData.value.itemDrawingNo = item.drawingNumber
                                proformaInvoiceItemData.value.itemId = itemId
                                proformaInvoiceItemData.value.itemName = codeName[1]
                                proformaInvoiceItemData.value.itemNetAmount = item.netAmount
                                proformaInvoiceItemData.value.itemNote = item.itemNote
                                proformaInvoiceItemData.value.itemQuantity = item.requireQty
                                proformaInvoiceItemData.value.itemRate = item.rate
                                proformaInvoiceItemData.value.itemUom = item.uom
                                /*Storing Data*/
                                store.dispatch('proforma-invoices-module/addProformaInvoiceItems', proformaInvoiceItemData.value)
                            })
                        }
                        bilingTerm.value.refetchBillingTerm(pCustomerID.value)
                        resetItemFormData()
                        refetchItemData()
                    })
                }
                resetQuotationItemsData()
            }

            const resetQuotationItemsData = () => {
                modalTable.value.salesQuotationItemData = []
                selectedQuotationItemIds.value = []
            }

            const bilingTerm = billingTerm

            return {
                CurrentPiId,
                pCustomerID,
                isBusy,
                itemFields,
                listOfItems,
                proformaInvoiceItemData,
                ItemListOption,
                getItemDetails,
                refetchItemData,
                resetItemFormData,
                UomListOption,
                StatusListOption,
                ItemTypeListOption,
                QtyRefListOption,
                SalesTypeListOption,
                getUomName,
                getItemCalculation,
                required,
                selectedRadio,
                getSelectItem,
                modalTable,
                salesOrderModal,
                salesQuotationModal,
                selectedItemIds,
                selectedSalesOrderItemIds,
                getSalesOrderItems,
                resetSalesOrderIds,
                statusOptions,
                salesOptions,
                getQuotationItemData,
                getSelectedQuotationItems,
                selectedQuotationItemIds,
                selectQuotationItem,
                resetQuotationItemsData,
                bilingTerm,
                onRowSelected
            }
        },
    }
</script>
<style lang="scss">
    @import '~@core/scss/vue/libs/vue-select.scss';
</style>
