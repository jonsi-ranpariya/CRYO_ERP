<template>
    <div>
        <hr>
        <!-- Table Area -->
        <b-table
            :fields="itemFields"
            :items="listOfItems"
            :bordered="true"
            :hover="true"
            show-empty
            responsive
            class="mb-0 table_scroll"
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
            <!-- Empty -->
            <template #empty="scope">
                <h5 class="text-center text-uppercase">No Item Details Available</h5>
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

        <!-- Form Area -->
        <validation-observer ref="simpleRules">
            <b-form>
                <b-row>
                    <b-col md="7">
                        <b-row>
                            <b-col md="12">
                                <validation-provider
                                    #default="{ errors }"
                                    name="Item"
                                    rules="required"
                                >
                                    <b-form-group
                                        label="Select Item"
                                        label-for="itemId"
                                        :state="errors.length > 0 ? false:null"
                                    >
                                        <v-select
                                            v-model="salesOrderItemData.itemId"
                                            placeholder="Select Item"
                                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                            :options="ItemListOption"
                                            :reduce="val => val.value"
                                            :clearable="false"
                                            @input="getItemDetails(salesOrderItemData.itemId)"
                                            input-id="itemId"
                                            :state="errors.length > 0 ? false:null"
                                        />
                                        <small class="text-danger">{{ errors[0] }}</small>
                                    </b-form-group>
                                </validation-provider>
                            </b-col>

                            <b-col md="4">
                                <b-form-group
                                    label="Item Code"
                                    label-for="itemCode"
                                >
                                    <b-form-input
                                        id="itemCode"
                                        v-model="salesOrderItemData.itemCode"
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
                                        v-model="salesOrderItemData.itemName"
                                        readonly
                                    />

                                </b-form-group>
                            </b-col>
                            <b-col md="12">
                                <b-form-group
                                    label="Make"
                                    label-for="make"
                                >
                                    <vue-autosuggest
                                        v-model="salesOrderItemData.itemMake"
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
                                        v-model="salesOrderItemData.itemCustomDescription"
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
                                        v-model="salesOrderItemData.itemAddonDescription"
                                        rows="1"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="12">
                                <b-form-group
                                    label="MSN No."
                                    label-for="msnNumber"
                                >
                                    <b-form-input
                                        id="msnNumber"
                                        v-model="salesOrderItemData.itemMsnNumber"
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
                                        v-model="salesOrderItemData.itemDetailDescription"
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
                                        v-model="salesOrderItemData.itemDrawingNo"
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
                                        v-model="salesOrderItemData.itemDrawingRev"
                                    />

                                </b-form-group>
                            </b-col>

                            <b-col md="12">
                                <b-form-group
                                    label="Project"
                                    label-for="itemProject"
                                >
                                    <b-form-input
                                        id="itemProject"
                                        v-model="salesOrderItemData.itemProject"
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
                                        v-model="salesOrderItemData.itemCustPartNo"
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
                                        v-model="salesOrderItemData.itemInternalNote"
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
                                        v-model="salesOrderItemData.itemNote"
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
                                    label="UOM"
                                    label-for="itemUom"
                                >
                                    <v-select
                                        v-model="salesOrderItemData.itemUom"
                                        placeholder="Select UOM"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="UomListOption"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        input-id="itemUom"
                                        disabled="disabled"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Conv. UOM"
                                    label-for="itemConvUom"
                                >
                                    <v-select
                                        v-model="salesOrderItemData.itemConvUom"
                                        placeholder="Select Conv. UOM"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="UomListOption"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        input-id="itemConvUom"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="CFactor"
                                    label-for="CFactor"
                                >
                                    <b-form-input
                                        id="itemCFactor"
                                        v-model="salesOrderItemData.itemCFactor"
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
                                        v-model="salesOrderItemData.itemConvQty"
                                    />
                                </b-form-group>
                            </b-col>

                            <!--<b-col md="6">
                                <b-form-group
                                    label="Sales Item"
                                    label-for="itemSalesType"
                                >
                                    <v-select
                                        v-model="salesOrderItemData.itemSalesType"
                                        placeholder="Select Sales Item"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="SalesTypeListOption"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        input-id="itemSalesType"
                                    />
                                </b-form-group>
                            </b-col>-->

                            <b-col md="6">
                                <b-form-group
                                    label="Quantity"
                                    label-for="itemQuantity"
                                >
                                    <b-form-input
                                        id="itemQuantity"
                                        v-model="salesOrderItemData.itemQuantity"
                                        type="number"
                                        @keyup="getItemCalculation"
                                    />

                                </b-form-group>
                            </b-col>

                            <b-col md="6">
                                <b-form-group
                                    label="Qty Conv."
                                    label-for="itemQtyConv"
                                >
                                    <b-form-input
                                        id="itemQtyConv"
                                        v-model="salesOrderItemData.itemQtyConv"
                                        type="number"
                                        disabled
                                    />

                                </b-form-group>
                            </b-col>

                            <b-col md="12">
                                <b-form-group
                                    label="Rate"
                                    label-for="itemRate"
                                >
                                    <b-form-input
                                        id="itemRate"
                                        v-model="salesOrderItemData.itemRate"
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
                                        v-model="salesOrderItemData.itemAmount"
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
                                        v-model="salesOrderItemData.itemDiscount"
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
                                        v-model="salesOrderItemData.itemDiscountVal"
                                        type="number"
                                        @keyup="getItemDiscountCalculation"
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
                                        v-model="salesOrderItemData.itemNetAmount"
                                        type="number"
                                        disabled
                                    />

                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group
                                    label="CGST (%)"
                                    label-for="itemCgstPercentage"
                                >
                                    <b-form-input
                                        id="itemCgstPercentage"
                                        v-model="salesOrderItemData.itemCgstPercentage"
                                        @keyup="getPercentageValue"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group
                                    label="SGST (%)"
                                    label-for="itemSgstPercentage"
                                >
                                    <b-form-input
                                        id="itemSgstPercentage"
                                        v-model="salesOrderItemData.itemSgstPercentage"
                                        @keyup="getPercentageValue"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group
                                    label="IGST (%)"
                                    label-for="itemIgstPercentage"
                                >
                                    <b-form-input
                                        id="itemIgstPercentage"
                                        v-model="salesOrderItemData.itemIgstPercentage"
                                        @keyup="getPercentageValue"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="12">
                                <b-form-group
                                    label="HSN/SAC No."
                                    label-for="itemHsnSacNumber"
                                >
                                    <b-form-input
                                        id="itemHsnSacNumber"
                                        v-model="salesOrderItemData.itemHsnSacNumber"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Item Status"
                                    label-for="itemStatus"
                                >
                                    <v-select
                                        v-model="salesOrderItemData.itemStatus"
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
                                        v-model="salesOrderItemData.itemType"
                                        placeholder="Select Item Type"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="ItemTypeListOption"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        input-id="itemType"
                                    />
                                </b-form-group>
                            </b-col>

                            <b-col md="6">
                                <b-form-group
                                    label="Quotation Reference"
                                    label-for="itemQtnRefNo"
                                >
                                    <b-input-group>
                                        <b-form-input
                                            v-model="salesOrderItemData.itemQtnRefNo"
                                            readonly
                                        />
                                        <b-input-group-append>
                                            <b-button variant="primary" v-b-modal.quotationList>...</b-button>
                                        </b-input-group-append>
                                    </b-input-group>
                                </b-form-group>
                            </b-col>

                            <b-col md="6">
                                <b-form-group
                                    label="Quotation SrNo."
                                    label-for="itemQtnSrNo"
                                >
                                    <b-form-input
                                        id="itemQtnSrNo"
                                        v-model="salesOrderItemData.itemQtnSrNo"
                                        disabled
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
                            @click.prevent="validationForm"
                            class="float-right"
                        >
                            Save
                        </b-button>
                        <div v-if="salesOrderItemData._id">
                            <b-button
                                variant="primary"
                                type="button"
                            >
                                Hold/Unhold Item
                            </b-button>
                            <b-button
                                variant="primary"
                                type="button"
                            >
                                Work order Details
                            </b-button>
                            <b-button
                                variant="primary"
                                type="button"
                            >
                                Dispatch Details
                            </b-button>
                            <b-button
                                variant="primary"
                                type="button"
                            >
                                Rate
                            </b-button>
                            <b-button
                                variant="primary"
                                type="button"
                            >
                                Stock
                            </b-button>
                            <b-button
                                variant="primary"
                                type="button"
                            >
                                Item Image
                            </b-button>
                            <b-button
                                variant="primary"
                                type="button"
                                class="mt-1"
                                @click="openDeliveryScheduleModel"
                            >
                                Delivery Schedule
                            </b-button>
                        </div>
                    </b-col>
                </b-row>
            </b-form>
        </validation-observer>

        <!--Sales Quotation Modal-->
        <b-modal
            id="quotationList"
            title="Select Sales Quotation"
            ok-title="submit"
            cancel-variant="danger"
            size="xl"
            no-close-on-backdrop
            @ok="getSelectedItemDetails"
        >
            <b-table
                :fields="modalTableFields.quotationFields"
                :items="modalTableData.quotationData"
                :no-border-collapse="false"
                responsive
                bordered
                hover
                show-empty
            >
                <template #empty="scope">
                    <h5 class="text-center text-uppercase">No Quotation List Available</h5>
                </template>
                <template #cell(action)="data">
                    <b-button
                        variant="flat-primary"
                        size="sm"
                        :id="`b_${data.item._id}`"
                        @click="getQuotationItems(data.item)"
                    >
                        Select
                    </b-button>
                </template>
                <template #cell(status)="data">
                    <span v-for="status in statusOptions">
                        <span v-if="status.value === data.item.status">{{ status.label }}</span>
                    </span>
                </template>
                <template #cell(sales)="data">
                    <span v-for="sales in salesOptions">
                        <span v-if="sales.value === data.item.sales">{{ sales.label }}</span>
                    </span>
                </template>
            </b-table>
            <hr>
            <h4>Item Details</h4>
            <hr>
            <b-table
                :fields="modalTableFields.itemsFields"
                :items="modalTableData.itemListData"
                :no-border-collapse="false"
                responsive
                bordered
                hover
                show-empty
            >
                <template #cell(srNo)="data">
                    {{ data.index + 1 }}
                </template>
                <template #empty="scope">
                    <h5 class="text-center text-uppercase">No Items Available</h5>
                </template>
                <template #cell(action)="data">
                    <b-form-checkbox-group>
                        <b-form-checkbox
                            :value="`${data.item._id}`"
                            class="custom-control-primary"
                            @change="selectedItemIds($event, data.item._id)"
                        />
                    </b-form-checkbox-group>
                </template>
            </b-table>
        </b-modal>

        <!--Delivery Schedule Modal-->
        <b-modal
            id="deliveryScheduleModal"
            ref="deliveryScheduleModal"
            cancel-variant="danger"
            hide-footer
            no-close-on-backdrop
            no-close-on-esc
            ok-title="submit"
            size="xl"
            title="Delivery Schedule"
        >
            <h5 class="text-primary"> {{ salesOrderItemName }}</h5>
            <hr>
            <!-- Table Area -->
            <b-row>
                <b-col>
                    <b-table
                        :busy="deliveryIsBusy"
                        :fields="modalTableFields.deliveryFields"
                        :items="modalTableData.deliveryData"
                        :no-border-collapse="false"
                        bordered
                        class="table_scroll"
                        hover
                        responsive
                        show-empty
                    >
                        <!--Loader-->
                        <template #table-busy>
                            <div class="text-center my-2">
                                <b-spinner class="align-middle"></b-spinner>
                                <strong>Loading...</strong>
                            </div>
                        </template>

                        <!--Index-->
                        <template #cell(index)="data">
                            {{ data.index + 1 }}
                        </template>
                    </b-table>
                </b-col>
            </b-row>

            <!-- Form Area -->
            <b-row>
                <b-col md="12">
                    <hr>
                    <h5 class="text-primary">Details</h5>
                    <hr>
                </b-col>
                <b-col md="4">
                    <b-form-group
                        label="Delivery Date"
                        label-for="deliveryDate"
                    >
                        <b-form-input
                            id="deliveryDate"
                            v-model="deliveryScheduleFormData.deliveryDate"
                            type="date"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="4">
                    <b-form-group
                        label="Expected Arrival Date"
                        label-for="expectedArrivalDate"
                    >
                        <b-form-input
                            id="expectedArrivalDate"
                            v-model="deliveryScheduleFormData.expectedDate"
                            type="date"
                            :min="deliveryScheduleFormData.deliveryDate"
                            :state="deliveryScheduleFormData.expectedDate > deliveryScheduleFormData.deliveryDate"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="4">
                    <b-form-group
                        label="Quanitity"
                        label-for="quantity"
                    >
                        <b-form-input
                            id="quantity"
                            v-model="deliveryScheduleFormData.quantity"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="12">
                    <hr>
                </b-col>
                <b-col md="4">
                    <b-form-group
                        label="Total Quantity"
                        label-for="totalQuantity"
                    >
                        <b-form-input
                            id="totalQuantity"
                            v-model="deliveryScheduleFormData.totalQuantity"
                            readonly
                        />
                    </b-form-group>
                </b-col>
                <b-col md="4">
                    <b-form-group
                        label="Sales Order Qty"
                        label-for="salesOrderQty"
                    >
                        <b-form-input
                            id="salesOrderQty"
                            v-model="deliveryScheduleFormData.salesOrderQty"
                            readonly
                        />
                    </b-form-group>
                </b-col>
                <b-col md="12">
                    <hr>
                    <b-button
                        variant="primary"
                        type="button"
                        class="float-right"
                        @click="submitDeliveryScheduleForm"
                    >
                        Save
                    </b-button>
                </b-col>
            </b-row>
        </b-modal>
    </div>
</template>
<script>
import {VueAutosuggest} from 'vue-autosuggest'
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
    BInputGroup,
    BInputGroupAppend,
    BFormCheckboxGroup,
    BFormCheckbox,
    BSpinner
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
import moment from 'moment'
import { changeToRound, forMatIndianDate } from '@core/utils/utils'
import { useToast } from 'vue-toastification/composition'

export default {
    components: {
        VueAutosuggest,
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
        BInputGroup,
        BInputGroupAppend,
        BFormCheckboxGroup,
        BFormCheckbox,
        BSpinner
    },
    directives: {
        Ripple,
    },
    methods: {
        async validationForm() {
            await this.$refs.simpleRules.validate().then(success => {
                if (success) {
                    const hasIdExist = this.containsKey(this.salesOrderItemData, '_id')
                    if (this.salesOrderItemData._id) {
                        this.salesOrderItemData.id = this.salesOrderItemData._id
                        store.dispatch('sales-order-module/updateSalesOrderItems', this.salesOrderItemData).then(response => {
                            if (response.status === 200) {
                                this.resetItemFormData()
                                this.refetchItemData()
                                this.$toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: 'Sales Order Item Edited',
                                        icon: 'CheckSquareIcon',
                                        variant: 'success',
                                        text: `You have successfully Edited Sales Order Item : ${this.salesOrderItemData.itemCode}.`,
                                    },
                                })
                            }
                        }).catch((error) => {
                            if (error.response.status === 422) {
                                let response = error.response.data
                                if (response.errors) {
                                    let errors = response.errors
                                    if (errors.itemQuantity) {
                                        this.$toast({
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
                                this.$toast({
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
                    } else {
                        store.dispatch('sales-order-module/addSalesOrderItems', this.salesOrderItemData).then(response => {
                            if (response.status === 200) {
                                this.resetItemFormData()
                                this.refetchItemData()
                                this.$toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: 'Sales Order Item Created',
                                        icon: 'CheckSquareIcon',
                                        variant: 'success',
                                        text: `You have successfully Created Sales Order Item : ${this.salesOrderItemData.itemCode}.`,
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
        async deleteSalesOrderItem(id) {
            await this.$swal({
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
                    store.dispatch(`sales-order-module/deleteSalesOrderItems`, {id}).then(response => {
                        if (response.data.status === 200) {
                            this.refetchItemData()
                            this.resetItemFormData()
                            this.$toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: `Deleted`,
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: `Sales Order Item Deleted Successfully`,
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
                    }).catch((error) => {
                        if (error.response.status === 422) {
                            let errors = error.response.data
                            if (errors.message) {
                                this.$toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: 'Something went wrong',
                                        icon: 'AlertCircleIcon',
                                        variant: 'warning',
                                        text: errors.message,
                                    },
                                })
                            }
                        } else {
                            this.$toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Error',
                                    icon: 'AlertCircleIcon',
                                    variant: 'warning',
                                    text: 'Internal server error.',
                                },
                            })
                        }
                    })
                }
            })
        }
    },
    props: {
        salesOrderNo: String,
        roundingType: String,
        supplyType: String|Number,
    },
    setup(props, {deliveryScheduleModal}) {
        const SO_APP_STORE_MODULE_NAME = 'sales-order-module'
        // Register module
        if (!store.hasModule(SO_APP_STORE_MODULE_NAME)) store.registerModule(SO_APP_STORE_MODULE_NAME, salesStoreModule)

        const CurrentSalesOrderId = ref(router.currentRoute.params.id)

        const CurrentSalesOrderNo = computed(() => props.salesOrderNo)

        const CurrenRoundingType = computed(() => props.roundingType)
        const CurrenSupplyType = computed(() => props.supplyType)

        const toast = useToast()

        const isBusy = ref(true)
        deliveryScheduleModal = ref()

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
        const makeFilteredOptions = ref([])
        const makeDataSuggest = ref([])
        axios.get('/api/get-item-make-master-options').then(res => {
            makeDataSuggest.value = res.data.data
        })
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
                key: 'itemPendingQuantity',
                label: 'Pend Qty',
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
                key: 'itemStatus',
                label: 'Status',
            },
            {
                key: 'action',
                label: 'Action',
            },
        ])
        const listOfItems = ref([])
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

        const modalTableFields = ref({
            quotationFields: [
                {
                    key: 'action',
                    label: ''
                },
                {
                    key: 'quotationNo',
                    label: 'Quotation No'
                },
                {
                    key: 'created_at',
                    label: 'Date',
                    formatter: value => moment(value).format('DD/MM/YYYY')
                },
                {
                    key: 'rev',
                    label: 'Revision'
                },
                {
                    key: 'revDate',
                    label: 'Rev Date'
                },
                {
                    key: 'enquiryNo',
                    label: 'EnquiryNo'
                },
                {
                    key: 'status',
                    label: 'status'
                },
                {
                    key: 'sales',
                    label: 'sales'
                }
            ],
            itemsFields: [
                {
                    key: 'action',
                    label: ''
                },
                {
                    key: 'srNo',
                    label: 'Sr No'
                },
                {
                    key: 'itemCode.label',
                    label: 'Item Code'
                },
                {
                    key: 'itemDescription',
                    label: 'description'
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
                    label: 'rate'
                },
                {
                    key: 'amount',
                    label: 'amount'
                },
                {
                    key: 'drawingNo',
                    label: 'Drawing No'
                },
                {
                    key: 'version',
                    label: 'version'
                },
                {
                    key: 'status.label',
                    label: 'status'
                }
            ],
            deliveryFields: [
                {
                    key: 'index',
                    label: 'No.'
                },
                {
                    key: 'deliveryDate',
                    label: 'Date',
                    formatter: value => forMatIndianDate(value)
                },
                {
                    key: 'quantity',
                    label: 'Quantity'
                },
                {
                    key: 'pendingQty',
                    label: 'Pending Qty'
                },
                {
                    key: 'expectedDate',
                    label: 'Arrival Date',
                    formatter: value => forMatIndianDate(value)
                }
            ],
        })

        const modalTableData = ref({
            quotationData: [],
            itemListData: [],
            deliveryData: []
        })

        axios.get('/api/get-uom-master-options').then(res => {
            UomListOption.value = res.data.data
        })

        axios.get('/api/get-approve-quotation-list').then(res => {
            modalTableData.value.quotationData = res.data.data
        })

        const refetchItemData = async () => {
            isBusy.value = true
            await axios.get(`/api/get-sales-order-items/${CurrentSalesOrderId.value}`).then(res => {
                listOfItems.value = res.data.data
            })
            await axios.get(`/api/get-sales-order-items-total-amount/${CurrentSalesOrderId.value}`)
            isBusy.value = false
        }
        refetchItemData()

        const salesOrderItemData = ref({
            id: null,
            salesOrderId: CurrentSalesOrderId.value,
            salesOrderNo: CurrentSalesOrderNo,
            itemId: null,
            itemCode: null,
            itemName: null,
            itemCustomDescription: null,
            itemAddonDescription: null,
            itemDetailDescription: null,
            itemMake: null,
            itemDrawingNo: null,
            itemDrawingRev: null,
            itemProject: null,
            itemInternalNote: null,
            itemSalesType: 2,
            itemUom: null,
            itemConvUom: null,
            itemMsnNumber: null,
            itemCustPartNo: null,
            itemNote: null,
            itemQuantity: 0,
            itemPendingQuantity: 0,
            itemRate: 0,
            itemDiscount: 0,
            itemDiscountVal: 0,
            itemNetAmount: 0,
            itemAmount: 0,
            itemStatus: 'Pending',
            itemType: 'Manufacturing',
            itemQtnRefNo: null,
            itemQtnSrNo: null,
            itemDocuments: null,
            itemStockStatus: null,
            itemHolUnhold: null,
            itemImage: null,
            itemWorkOrderDetail: null,
            itemDispatchDetail: null,
            itemDeliverySchedule: null,
            itemHsnSacNumber: null,
            itemHsnSacId: null,
            itemCFactor: null,
            itemConvQty: null,
            itemCgstPercentage: 0,
            itemSgstPercentage: 0,
            itemIgstPercentage: 0,
            itemCgstAmount: 0,
            itemSgstAmount: 0,
            itemIgstAmount: 0,
            itemQtyConv: 0,
        });

        const onRowSelected = (items) => {
            if (items.length > 0) {
                salesOrderItemData.value._id = items[0]._id
                salesOrderItemData.value.itemId = items[0].itemId
                salesOrderItemData.value.itemCode = items[0].itemCode ?? null
                salesOrderItemData.value.itemName = items[0].itemName ?? null
                salesOrderItemData.value.itemCustomDescription = items[0].itemCustomDescription ?? null
                salesOrderItemData.value.itemAddonDescription = items[0].itemAddonDescription ?? null
                salesOrderItemData.value.itemDetailDescription = items[0].itemDetailDescription ?? null
                salesOrderItemData.value.itemMake = items[0].itemMake ?? null
                salesOrderItemData.value.itemDrawingNo = items[0].itemDrawingNo ?? null
                salesOrderItemData.value.itemDrawingRev = items[0].itemDrawingRev ?? null
                salesOrderItemData.value.itemProject = items[0].itemProject ?? null
                salesOrderItemData.value.itemInternalNote = items[0].itemInternalNote ?? null
                salesOrderItemData.value.itemUom = items[0].itemUom ?? null
                salesOrderItemData.value.itemConvUom = items[0].itemConvUom ?? null
                salesOrderItemData.value.itemMsnNumber = items[0].itemMsnNumber ?? null
                salesOrderItemData.value.itemCustPartNo = items[0].itemCustPartNo ?? null
                salesOrderItemData.value.itemNote = items[0].itemNote ?? null
                salesOrderItemData.value.itemQuantity = items[0].itemQuantity ?? null
                salesOrderItemData.value.itemRate = items[0].itemRate ?? null
                salesOrderItemData.value.itemDiscount = items[0].itemDiscount ?? null
                salesOrderItemData.value.itemDiscountVal = items[0].itemDiscountVal ?? null
                salesOrderItemData.value.itemNetAmount = items[0].itemNetAmount ?? null
                salesOrderItemData.value.itemHsnSacNumber = items[0].itemHsnSacNumber ?? null
                salesOrderItemData.value.itemCgstPercentage = items[0].itemCgstPercentage ?? null
                salesOrderItemData.value.itemSgstPercentage = items[0].itemSgstPercentage ?? null
                salesOrderItemData.value.itemIgstPercentage = items[0].itemIgstPercentage ?? null
                salesOrderItemData.value.itemAmount = items[0].itemAmount ?? null
                salesOrderItemData.value.itemStatus = items[0].itemStatus ?? null
                salesOrderItemData.value.itemType = items[0].itemType ?? null
                salesOrderItemData.value.itemQtnRefNo = items[0].itemQtnRefNo ?? null
                salesOrderItemData.value.itemQtnSrNo = items[0].itemQtnSrNo ?? null
                salesOrderItemData.value.itemCFactor = items[0].itemCFactor ?? null
                salesOrderItemData.value.itemConvQty = items[0].itemConvQty ?? null
                salesOrderItemData.value.itemQtyConv = items[0].itemQtyConv ?? null
            } else {
                resetItemFormData()
            }
        }

        axios.get('/api/get-item-master-options').then(res => {
            ItemListOption.value = res.data.data
        })

        const getItemDetails = async (val) => {
            resetItemFormData();
            await axios.get(`/api/item-master/${val}`).then(res => {
                salesOrderItemData.value.itemId = res.data.data?._id ?? null
                salesOrderItemData.value.itemCode = res.data.data?.itemCode ?? null
                salesOrderItemData.value.itemName = res.data.data?.itemDescription ?? null
                salesOrderItemData.value.itemUom = res.data.data.uom ?? null
                salesOrderItemData.value.itemMake = res.data.data.make ?? null
                salesOrderItemData.value.itemConvUom = res.data.data.convUom ?? null
                salesOrderItemData.value.itemCFactor = res.data.data.cFactor ?? null
                salesOrderItemData.value.itemConvQty = res.data.data.convQty ?? null
                if (res.data.data.itemDetails) {
                    salesOrderItemData.value.itemAddonDescription = res.data.data?.itemDetails.description ?? null
                    salesOrderItemData.value.itemDetailDescription = res.data.data?.itemDetails.detailDescription ?? null
                    salesOrderItemData.value.itemDrawingNo = res.data.data?.itemDetails.drawingNumber ?? null
                    salesOrderItemData.value.itemDrawingRev = res.data.data?.itemDetails.revision ?? null
                    salesOrderItemData.value.itemNote = res.data.data?.itemDetails.remarkNote ?? null
                }
                if (res.data.data.hsnSacDetails) {
                    salesOrderItemData.value.itemHsnSacNumber = res.data.data.hsnSacDetails.hsnSacDescription.codeNo ?? null
                    salesOrderItemData.value.itemHsnSacId = res.data.data.hsnSacDetails.hsnSacDescription.value ?? null
                }

                if (res.data.data.hsn_details) {
                    //salesOrderSupplyType => 1: intrastate, 2: interstate
                    if (CurrenSupplyType.value == 1) {
                        salesOrderItemData.value.itemCgstPercentage = parseInt(res.data.data?.hsn_details?.codeCGSTPercentage ?? 0)
                        salesOrderItemData.value.itemSgstPercentage = parseInt(res.data.data?.hsn_details?.codeSGSTPercentage ?? 0)
                        salesOrderItemData.value.itemIgstPercentage = 0
                    }
                    if (CurrenSupplyType.value == 2) {
                        salesOrderItemData.value.itemCgstPercentage = 0
                        salesOrderItemData.value.itemSgstPercentage = 0
                        salesOrderItemData.value.itemIgstPercentage = parseInt(res.data.data?.hsn_details?.codeIGSTPercentage ?? 0)
                    }
                }
            });
        }

        const resetItemFormData = () => {
            salesOrderItemData.value = {
                id: null,
                salesOrderId: CurrentSalesOrderId.value,
                salesOrderNo: CurrentSalesOrderNo.value,
                itemId: null,
                itemCode: null,
                itemName: null,
                itemCustomDescription: null,
                itemAddonDescription: null,
                itemDetailDescription: null,
                itemMake: null,
                itemDrawingNo: null,
                itemDrawingRev: null,
                itemProject: null,
                itemInternalNote: null,
                itemSalesType: 2,
                itemUom: null,
                itemMsnNumber: null,
                itemCustPartNo: null,
                itemNote: null,
                itemQuantity: 0,
                itemRate: 0,
                itemDiscount: 0,
                itemDiscountVal: 0,
                itemNetAmount: 0,
                itemAmount: 0,
                itemStatus: 'Pending',
                itemType: 'Trading',
                itemQtnRefNo: null,
                itemQtnSrNo: null,
                itemDocuments: null,
                itemStockStatus: null,
                itemHolUnhold: null,
                itemImage: null,
                itemWorkOrderDetail: null,
                itemDispatchDetail: null,
                itemDeliverySchedule: null,
                itemConvUom: null,
                itemCFactor: null,
                itemConvQty: null
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

        const getQuotationItems = (data) => {
            if (data.item_details) {
                modalTableData.value.itemListData = data.item_details
            }
        }

        const selectedItemData = ref([])

        const selectedItemIds = (e, id) => {
            if (e === false) {
                selectedItemData.value = selectedItemData.value.filter(function (e) {
                    return e !== id;
                });
            } else {
                selectedItemData.value.push(id);
            }
        }

        const getSelectedItemDetails = async () => {
            let itemsIds = selectedItemData.value
            await axios.post('/api/get-quotation-item-list', {ids: itemsIds}).then(res => {
                let itemList = res.data.data
                for (let i = 0; i < itemList.length; i++) {
                    itemList[i].itemId = itemList[i].itemCode.value
                    let itemCode = itemList[i].itemCode.label.split('-')
                    itemList[i].salesOrderId = CurrentSalesOrderId.value
                    itemList[i].itemCode = itemCode[0] ?? null
                    itemList[i].itemName = itemCode[1] ?? null
                    itemList[i].salesOrderNo = CurrentSalesOrderNo.value
                    itemList[i].itemCustomDescription = itemList[i].itemDescCust
                    itemList[i].itemAddonDescription = itemList[i].addDescription
                    itemList[i].itemDetailDescription = itemList[i].detailDescription
                    itemList[i].itemDrawingNo = itemList[i].drawingNumber
                    itemList[i].itemDrawingRev = itemList[i].rev
                    itemList[i].itemUom = itemList[i].uom
                    itemList[i].itemCustPartNo = itemList[i].custPartNo
                    itemList[i].itemQuantity = itemList[i].requireQty
                    itemList[i].itemRate = itemList[i].rate
                    itemList[i].itemDiscount = itemList[i].discPercent
                    itemList[i].itemDiscountVal = itemList[i].discValue
                    itemList[i].itemNetAmount = itemList[i].netAmount
                    itemList[i].itemAmount = itemList[i].amount
                    itemList[i].itemStatus = itemList[i].status.label
                }
                store.dispatch('sales-order-module/addSalesOrderItems', itemList)
            })
            resetModalData()
            await refetchItemData()
        }

        const resetModalData = () => {
            modalTableData.value.itemListData = null
            selectedItemData.value = []
        }

        const getItemCalculation = () => {
            salesOrderItemData.value.itemPendingQuantity = salesOrderItemData.value.itemQuantity;
            salesOrderItemData.value.itemQtyConv = salesOrderItemData.value.itemQuantity * salesOrderItemData.value.itemCFactor * salesOrderItemData.value.itemConvQty

            if (CurrenRoundingType.value === '0') {
                salesOrderItemData.value.itemAmount = parseFloat(salesOrderItemData.value.itemQuantity * salesOrderItemData.value.itemRate).toFixed(2)
                salesOrderItemData.value.itemDiscountVal = parseFloat((salesOrderItemData.value.itemAmount * salesOrderItemData.value.itemDiscount) / 100).toFixed(2)
                salesOrderItemData.value.itemNetAmount = parseFloat(salesOrderItemData.value.itemAmount - salesOrderItemData.value.itemDiscountVal).toFixed(2)
            }

            if (CurrenRoundingType.value === '1' || CurrenRoundingType.value === '2') {
                salesOrderItemData.value.itemAmount = changeToRound(parseFloat(salesOrderItemData.value.itemQuantity * salesOrderItemData.value.itemRate).toFixed(2))
                salesOrderItemData.value.itemDiscountVal = changeToRound(parseFloat((salesOrderItemData.value.itemAmount * salesOrderItemData.value.itemDiscount) / 100).toFixed(2))
                salesOrderItemData.value.itemNetAmount = changeToRound(parseFloat(salesOrderItemData.value.itemAmount - salesOrderItemData.value.itemDiscountVal).toFixed(2))
            }
        }

        const getItemDiscountCalculation = () => {
            let itemAmount = parseFloat(salesOrderItemData.value.itemQuantity * salesOrderItemData.value.itemRate);
            let discountValue = parseFloat(salesOrderItemData.value.itemDiscountVal);

            if (CurrenRoundingType.value === '0') {
                salesOrderItemData.value.itemNetAmount = parseFloat(itemAmount - discountValue).toFixed(2);
                salesOrderItemData.value.itemDiscount = parseFloat((discountValue / itemAmount) * 100).toFixed(2);
            }

            if (CurrenRoundingType.value === '1' || CurrenRoundingType.value === '2') {
                salesOrderItemData.value.itemNetAmount = changeToRound(parseFloat(itemAmount - discountValue).toFixed(2));
                salesOrderItemData.value.itemDiscount = changeToRound(parseFloat((discountValue / itemAmount) * 100).toFixed(2));
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
            salesOrderItemData.value.itemMake = item.item.label;
        }

        const getPercentageValue = () => {
            let roundingType = parseInt(CurrenRoundingType.value)
            if (roundingType === 2) {
                salesOrderItemData.value.itemCgstAmount = changeToRound(salesOrderItemData.value.itemNetAmount * salesOrderItemData.value.itemCgstPercentage / 100);
                salesOrderItemData.value.itemSgstAmount = changeToRound(salesOrderItemData.value.itemNetAmount * salesOrderItemData.value.itemSgstPercentage / 100)
                salesOrderItemData.value.itemIgstAmount = changeToRound(salesOrderItemData.value.itemNetAmount * salesOrderItemData.value.itemIgstPercentage / 100)
            } else {
                salesOrderItemData.value.itemCgstAmount = salesOrderItemData.value.itemNetAmount * salesOrderItemData.value.itemCgstPercentage / 100
                salesOrderItemData.value.itemSgstAmount = salesOrderItemData.value.itemNetAmount * salesOrderItemData.value.itemSgstPercentage / 100
                salesOrderItemData.value.itemIgstAmount = salesOrderItemData.value.itemNetAmount * salesOrderItemData.value.itemIgstPercentage / 100
            }
        }

        // Delivery Schedule
        const blankDeliveryScheduleFormData = {
            deliveryDate: null,
            expectedDate: null,
            quantity: null,
            totalQuantity: null,
            salesOrderQty: null
        }

        const deliveryScheduleFormData = ref(JSON.parse(JSON.stringify(blankDeliveryScheduleFormData)))

        const resetScheduleFormData = () => {
            deliveryScheduleFormData.value = JSON.parse(JSON.stringify(blankDeliveryScheduleFormData))
        }

        const salesOrderItemName = ref(null)

        const deliveryIsBusy = ref(false)

        const getDeliveryScheduleModalData = async () => {
            deliveryIsBusy.value = true
            await axios.get(`/api/get-sales-order-item-delivery/${salesOrderItemData.value._id}`).then((res) => {
                modalTableData.value.deliveryData = res.data
            })
            deliveryIsBusy.value = false
        }

        const openDeliveryScheduleModel = async () => {
            salesOrderItemName.value = salesOrderItemData.value.itemCode + ' - ' + salesOrderItemData.value.itemName
            deliveryScheduleFormData.value.totalQuantity = salesOrderItemData.value.itemQuantity
            deliveryScheduleFormData.value.salesOrderQty = salesOrderItemData.value.itemQuantity
            await getDeliveryScheduleModalData()
            await deliveryScheduleModal.value.show();
        }

        const submitDeliveryScheduleForm = async () => {
            let formData = {
                salesOrderItemId: salesOrderItemData.value._id,
                ...deliveryScheduleFormData.value
            }
            await axios.post('/api/sales-delivery-schedule', formData)
                .then(() => {
                    getDeliveryScheduleModalData()
                    toast({
                        component: ToastificationContent,
                        position: 'top-right',
                        props: {
                            title: 'Delivery Schedule Created',
                            icon: 'CheckSquareIcon',
                            variant: 'success',
                            text: `You have successfully Created Delivery Schedule.`,
                        },
                    })
                })
                .catch(() => {
                    toast({
                        component: ToastificationContent,
                        position: 'top-right',
                        props: {
                            title: 'Error',
                            icon: 'AlertCircleIcon',
                            variant: 'danger',
                            text: 'Internal Server Error.',
                        },
                    })
                })
        }

        return {
            CurrentSalesOrderId,
            itemFields,
            listOfItems,
            salesOrderItemData,
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
            modalTableFields,
            modalTableData,
            statusOptions,
            salesOptions,
            getQuotationItems,
            required,
            selectedItemData,
            getSelectedItemDetails,
            resetModalData,
            getItemCalculation,
            getItemDiscountCalculation,
            isBusy,
            selectedItemIds,
            CurrentSalesOrderNo,
            makeDataSuggest,
            makeFilteredOptions,
            onMakeInputChange,
            onSelectedMake,
            getPercentageValue,

            // Delivery Schedule
            salesOrderItemName,
            deliveryScheduleFormData,
            resetScheduleFormData,
            deliveryIsBusy,
            openDeliveryScheduleModel,
            deliveryScheduleModal,
            submitDeliveryScheduleForm,
            onRowSelected
        }
    },
}
</script>

<style lang="scss">
@import '~@core/scss/vue/libs/vue-select.scss';
</style>
<style lang="scss">
@import '~@core/scss/vue/libs/vue-autosuggest.scss';
</style>
