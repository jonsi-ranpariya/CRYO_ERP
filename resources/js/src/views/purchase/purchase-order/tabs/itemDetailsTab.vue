<template>
    <div>
        <!-- Table -->
        <b-row>
            <b-col md="12">
                <b-table
                    :busy="isBusy"
                    :fields="tableFields"
                    :items="tableData"
                    bordered
                    class="mb-0 table_scroll"
                    hover
                    responsive
                    show-empty
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
                            no-caret
                            toggle-class="text-decoration-none"
                            variant="link"
                        >
                            <template v-slot:button-content>
                                <feather-icon
                                    class="text-body align-middle mr-25"
                                    icon="MoreVerticalIcon"
                                    size="16"
                                />
                            </template>
                            <b-dropdown-item
                                @click="deleteItemDetail(data.item._id)"
                            >
                                <feather-icon
                                    class="mr-50"
                                    icon="TrashIcon"
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
                <hr/>
            </b-col>
        </b-row>

        <!-- Modal Buttons -->
        <b-row>
            <b-col md="12">
                <div class="demo-inline-spacing mb-2">
                    <b-form-radio
                        name="selectItemFromModal"
                        v-model="selectedRadio"
                        value="1"
                    >
                        Indent
                    </b-form-radio>
                    <b-form-radio
                        name="selectItemFromModal"
                        v-model="selectedRadio"
                        value="2"
                    >
                        Sales Order
                    </b-form-radio>
                    <b-form-radio
                        name="selectItemFromModal"
                        v-model="selectedRadio"
                        value="3"
                    >
                        Purchase Quotation
                    </b-form-radio>
                    <b-button
                        @click="openModal"
                        type="button"
                        variant="primary"
                    >
                        Select Item
                    </b-button>
                </div>
                <hr/>
            </b-col>
        </b-row>

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
                                    :clearable="false"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="itemCodeOption"
                                    :reduce="(val) => val.value"
                                    :state="getValidationState(validationContext)"
                                    @input="getItemDetails($event)"
                                    input-id="itemCode"
                                    placeholder="Select itemCode"
                                    v-model="formData.itemCode"
                                />
                                <b-form-invalid-feedback
                                    :state="getValidationState(validationContext)"
                                >
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
                                    :state="
                                        getValidationState(validationContext)
                                    "
                                    id="itemDescription"
                                    readonly
                                    v-model="formData.itemDescription"
                                />

                                <b-form-invalid-feedback>
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
                                        :reduce="val => val.value"
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
                            <b-col md="12">
                                <b-form-group
                                    label="ItemDesc (vendor)"
                                    label-for="itemDescVendor"
                                >
                                    <b-form-input
                                        id="itemDescVendor"
                                        v-model="formData.itemDescVendor"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="12">
                                <b-form-group
                                    label="Add Description"
                                    label-for="addDescription"
                                >
                                    <b-form-textarea
                                        id="addDescription"
                                        v-model="formData.itemAddDescription"
                                        rows="2"
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-form-group
                            label="Detail Description"
                            label-for="detailDescription"
                        >
                            <b-form-textarea
                                id="detailDescription"
                                rows="2"
                                v-model="formData.itemDetailDescription"
                            />
                        </b-form-group>
                        <b-row>
                            <b-col md="6">
                                <b-form-group
                                    label="Drawing No."
                                    label-for="itemDrowingNo"
                                >
                                    <b-form-input
                                        id="itemDrowingNo"
                                        v-model="formData.itemDrowingNo"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group label="Rev" label-for="itemRev">
                                    <b-form-input
                                        id="itemRev"
                                        v-model="formData.itemRev"
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="6">
                                <b-form-group label="UOM" label-for="itemUom">
                                    <v-select
                                        :clearable="false"
                                        :dir="
                                            $store.state.appConfig.isRTL
                                                ? 'rtl'
                                                : 'ltr'
                                        "
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
                                <b-form-group label="UP" label-for="itemup">
                                    <v-select
                                        :clearable="false"
                                        :dir="
                                            $store.state.appConfig.isRTL
                                                ? 'rtl'
                                                : 'ltr'
                                        "
                                        :options="uomOption"
                                        :reduce="(val) => val.value"
                                        input-id="itemup"
                                        placeholder="Select UP"
                                        v-model="formData.itemup"
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
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Conv-Qty"
                                    label-for="itemQty"
                                >
                                    <b-form-input
                                        @keyup="calculateAmount"
                                        id="cQty"
                                        v-model="formData.itemQty"
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="6">
                                <b-form-group
                                    label="Quantity UM"
                                    label-for="itemQuantityUm"
                                >
                                    <b-form-input
                                        id="quantityUm"
                                        v-model="formData.itemQuantityUm"
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
                                        id="quantityUp"
                                        v-model="formData.itemQuantityUp"
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="6">
                                <b-form-group
                                    label="Pending Qty UM"
                                    label-for="pendingQtyUm"
                                >
                                    <b-form-input
                                        id="pendingQtyUm"
                                        v-model="formData.pendingQtyUm"
                                        disabled
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Pending Qty Up"
                                    label-for="PendingQtyUp"
                                >
                                    <b-form-input
                                        id="pendingQtyUp"
                                        v-model="formData.pendingQtyUp"
                                        disabled
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>
                    </b-col>
                    <b-col md="6">
                        <b-row>
                            <b-col md="12">
                                <b-form-group label="Rate" label-for="itemRate">
                                    <b-form-input
                                        @keyup="calculateAmount"
                                        id="itemRate"
                                        v-model="formData.itemRate"
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="6">
                                <b-form-group
                                    label="Disc(%)"
                                    label-for="itemDiscount"
                                >
                                    <b-form-input
                                        @keyup="calculateAmount"
                                        id="itemDiscount"
                                        v-model="formData.itemDiscount"
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
                        </b-row>
                        <b-row>
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
                        </b-row>
                        <b-row>
                            <b-col md="6">
                                <b-form-group
                                    label="Indent No."
                                    label-for="itemIndentNo"
                                >
                                    <b-form-input
                                        id="itemIndentNo"
                                        v-model="formData.itemIndentNo"
                                        disabled
                                    />
                                </b-form-group>

                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Indent Date"
                                    label-for="indentDate"
                                >
                                    <b-input-group>
                                        <b-input-group-prepend>
                                            <b-form-datepicker
                                                v-model="formatDates.itemIndentDate"
                                                button-only
                                                @input="getIndentFormateDate($event)"
                                                show-decade-nav
                                                size="sm"
                                                nav-button-variant="primary"
                                            />
                                        </b-input-group-prepend>
                                        <cleave
                                            id="indentDate"
                                            v-model="formData.itemIndentDate"
                                            class="form-control"
                                            :raw="false"
                                            :options="dateFormat"
                                            placeholder="DD/MM/YYYY"
                                            show-decade-nav
                                        />
                                    </b-input-group>
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="6">
                                <b-form-group label="Indenter" label-for="itemIndenter">
                                    <b-form-input
                                        id="itemIndenter"
                                        readonly
                                        v-model="formData.itemIndenter"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group label="Job No." label-for="itemJobNumber">
                                    <b-form-input
                                        id="itemJobNumber"
                                        v-model="formData.itemJobNumber"
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="6">
                                <b-form-group label="Store" label-for="itemStore">
                                    <v-select
                                        :clearable="false"
                                        :dir="
                                    $store.state.appConfig.isRTL ? 'rtl' : 'ltr'
                                "
                                        :options="storeOption"
                                        :reduce="(val) => val.value"
                                        input-id="itemStore"
                                        placeholder="Select Store"
                                        v-model="formData.itemStore"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group label="Status" label-for="itemStatus">
                                    <v-select
                                        :clearable="false"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="statusOptions"
                                        :reduce="(val) => val.value"
                                        input-id="itemStatus"
                                        placeholder="Select Status"
                                        disabled="disabled"
                                        v-model="formData.itemStatus"
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-form-group
                            label="Delivery Date"
                            label-for="itemDeliveryDate"
                        >
                            <b-input-group>
                                <b-input-group-prepend>
                                    <b-form-datepicker
                                        v-model="formatDates.itemDeliveryDate"
                                        button-only
                                        @input="getPoItemFormateDate($event)"
                                        show-decade-nav
                                        size="sm"
                                        nav-button-variant="primary"
                                    />
                                </b-input-group-prepend>
                                <cleave
                                    id="itemDeliveryDate"
                                    v-model="formData.itemDeliveryDate"
                                    class="form-control"
                                    :raw="false"
                                    :options="dateFormat"
                                    placeholder="DD/MM/YYYY"
                                    show-decade-nav
                                />
                            </b-input-group>
                        </b-form-group>
                        <b-row>
                            <b-col md="6">
                                <b-form-group
                                    label="SO.No."
                                    label-for="itemSoNumber"
                                >
                                    <v-select
                                           :clearable="false"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="soOption"
                                        :reduce="(val) => val.value"
                                        input-id="itemSoNumber"
                                        placeholder="Select No"
                                        v-model="formData.itemSoNumber"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group label="WO.No." label-for="itemWoNumber">
                                    <v-select
                                        :clearable="false"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="woOption"
                                        :reduce="(val) => val.value"
                                        input-id="itemWoNumber"
                                        placeholder="Select No"
                                        v-model="formData.itemWoNumber"
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
                            <b-col md="12">
                                <b-form-group label="Remark" label-for="itemRemark">
                                    <b-form-textarea
                                        id="itemRemark"
                                        rows="2"
                                        v-model="formData.itemRemark"
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>
                    </b-col>
                    <!-- Button-->
                    <b-col md="12">
                        <hr/>
                        <b-button
                            class="float-right"
                            type="submit"
                            variant="primary"
                        >
                            Save
                        </b-button>
                        <div v-if="formData._id">
                            <b-button
                                type="button"
                                variant="primary"
                            >
                                Item Documents
                            </b-button>
                            <b-button
                                type="button"
                                variant="primary"
                            >
                                Delivery Schedule
                            </b-button>
                            <b-button
                                type="button"
                                variant="primary"
                            >
                                WO Allocation
                            </b-button>
                            <b-button
                                type="button"
                                variant="primary"
                            >
                                Stock Status
                            </b-button>
                            <b-button
                                type="button"
                                variant="primary"
                            >
                                GRN Details
                            </b-button>
                        </div>
                    </b-col>
                </b-row>
            </b-form>
        </validation-observer>

        <!-- Indent Item Modal -->
        <b-modal
            @cancel="resetIndentItemDetails"
            @ok="addIndentItemDetails"
            cancel-variant="danger"
            id="indentModal"
            no-close-on-backdrop
            ok-title="Save"
            ref="indentModal"
            scrollable
            size="xl"
            title="Find Indent For Purchase order"
        >
            <b-row>
                <b-col md="3">
                    <b-form-group
                        label="Indent No"
                        label-for="indent No"
                    >
                        <b-form-input
                            id="indentNo"
                            v-model="searchData.indentNo"
                            @keyup="getIndentFilter"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="3">
                    <b-form-group
                        label="Item Code"
                        label-for="itemMasterCode"
                    >
                        <b-form-input
                            id="itemMasterCode"
                            v-model="searchData.itemCode"
                            @keyup="getIndentFilter"
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
                            @keyup="getIndentFilter"
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
                            @keyup="getIndentFilter"
                        />
                    </b-form-group>
                </b-col>
            </b-row>

            <b-table
                :fields="modalTables.indentFields"
                :items="modalTables.indentData"
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
                        @input="checkIndentItem($event, data.item._id)"
                    />
                </template>
            </b-table>
        </b-modal>

        <!-- Sales Order Modal -->
        <b-modal
            @cancel="resetSalesOrderItemDetails"
            @ok="addSalesOrderItemDetails"
            cancel-variant="danger"
            id="salesOrderModal"
            no-close-on-backdrop
            ok-title="Save"
            ref="salesOrderModal"
            scrollable
            size="xl"
            title="Find So For Purchase order"
        >
            <b-row>
                <b-col md="3">
                    <b-form-group
                        label="sales Order No"
                        label-for="salesOrderNo"
                    >
                        <b-form-input
                            id="salesOrderNo"
                            v-model="searchSoData.salesOrderNo"
                            @keyup="getSalesOrderFilter"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="3">
                    <b-form-group
                        label="Item Code"
                        label-for="soItemCode"
                    >
                        <b-form-input
                            id="soItemCode"
                            v-model="searchSoData.itemCode"
                            @keyup="getSalesOrderFilter"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="3">
                    <b-form-group
                        label="Item Description"
                        label-for="soItemDescription"
                    >
                        <b-form-input
                            id="soItemDescription"
                            v-model="searchSoData.itemName"
                            @keyup="getSalesOrderFilter"
                        />

                    </b-form-group>
                </b-col>
                <b-col md="3">
                    <b-form-group
                        label="Drawing Number"
                        label-for="soDrawingNumber"
                    >
                        <b-form-input
                            id="soDrawingNumber"
                            v-model="searchSoData.itemDrawingNo"
                            @keyup="getSalesOrderFilter"
                        />
                    </b-form-group>
                </b-col>
            </b-row>

            <b-table
                :fields="modalTables.salesOrderFields"
                :items="modalTables.salesOrderData"
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
                        @input="checkItem($event, data.item._id)"
                    />
                </template>
            </b-table>
        </b-modal>

        <!-- Purchase Quotation Modal -->
        <b-modal
            @cancel="resetPurchaseQuotationItemDetails"
            @ok="addPurchaseQuotationItemDetails"
            cancel-variant="danger"
            id="purchaseQuotationModal"
            no-close-on-backdrop
            ok-title="Save"
            ref="purchaseQuotationModal"
            scrollable
            size="xl"
            title="Find So For Purchase Quotation"
        >
            <b-row>
                <b-col md="4">
                    <b-form-group
                        label="Item Code"
                        label-for="pqItemCode"
                    >
                        <b-form-input
                            id="pqItemCode"
                            v-model="searchPqData.itemCode"
                            @keyup="getPurchaseQuotationFilter"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="4">
                    <b-form-group
                        label="Item Description"
                        label-for="pqItemDescription"
                    >
                        <b-form-input
                            id="pqItemDescription"
                            v-model="searchPqData.itemDescription"
                            @keyup="getPurchaseQuotationFilter"
                        />

                    </b-form-group>
                </b-col>
                <b-col md="4">
                    <b-form-group
                        label="Drawing Number"
                        label-for="pqDrawingNumber"
                    >
                        <b-form-input
                            id="pqDrawingNumber"
                            v-model="searchPqData.itemDrawingNumber"
                            @keyup="getPurchaseQuotationFilter"
                        />
                    </b-form-group>
                </b-col>
            </b-row>

            <b-table
                :fields="modalTables.salesQuotationFields"
                :items="modalTables.salesQuotationData"
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
                        @input="checkQuotationItem($event, data.item._id)"
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
    BFormInput,
    BFormTextarea,
    BFormDatepicker,
    BButton,
    BTable,
    BSpinner,
    BDropdown,
    BDropdownItem,
    BFormInvalidFeedback,
    BFormRadio,
    BFormCheckbox,
    BInputGroup,
    BInputGroupAppend,
    BInputGroupPrepend
} from "bootstrap-vue";
import {ValidationObserver, ValidationProvider} from "vee-validate";
import {ref, onUnmounted,computed} from "@vue/composition-api";
import formValidation from "@core/comp-functions/forms/form-validation";
import {required} from "@validations";
import vSelect from "vue-select";
import axios from "@axios";
import router from "@/router";
import Ripple from "vue-ripple-directive";
import {useToast} from "vue-toastification/composition";
import ToastificationContent from "@core/components/toastification/ToastificationContent.vue";
import {forMatIndianDate, getTcTodayDate} from "@core/utils/utils";
import store from '@/store';
import purchaseStoreModule from "../../purchaseStoreModule";
import Swal from 'sweetalert2'
import Cleave from 'vue-cleave-component'
import {changeAmountDecimalPoint, changeToRound} from "@core/utils/utils";

export default {
    components: {
        ValidationProvider,
        ValidationObserver,
        BForm,
        BRow,
        BCol,
        BFormGroup,
        BFormInput,
        BFormTextarea,
        BFormDatepicker,
        BButton,
        BTable,
        BSpinner,
        BDropdown,
        BDropdownItem,
        BFormInvalidFeedback,
        vSelect,
        BFormRadio,
        BFormCheckbox,
        BInputGroup,
        BInputGroupAppend,
        BInputGroupPrepend,
        Cleave
    },
    directives: {
        Ripple,
    },
    props: {
        poRoundingType: {
            required: true,
        },
        poRefId: {
            required: true,
        }
    },
    setup(props,{indentModal, salesOrderModal, purchaseQuotationModal}) {
        const ITEMADDON_APP_STORE_MODULE_NAME = 'purchase-store-module'
        if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, purchaseStoreModule)
        onUnmounted(() => {
            if (store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.unregisterModule(ITEMADDON_APP_STORE_MODULE_NAME)
        })

        const roundingType = computed(() => props.poRoundingType)
        const refId = computed(() => props.poRefId)

        const isModalTableBusy = ref(false)

        const toast = useToast();
        const isBusy = ref(false);

        const dateFormat = ref({
            date: true,
            delimiter: '/',
            datePattern: ['d', 'm', 'Y'],
        })

        const formatDates = ref({
            itemDeliveryDate: null,
            itemIndentDate: null,
        })

        const getPoItemFormateDate = (date) => {
            formData.value.itemDeliveryDate = forMatIndianDate(date)
        }
        const getIndentFormateDate = (date) => {
            formData.value.itemIndentDate = forMatIndianDate(date)
        }

        salesOrderModal = ref();
        indentModal = ref();
        purchaseQuotationModal = ref();

        const tableFields = ref([
            {
                key: 'rowSelected',
                label: ''
            },
            {
                key: "index",
                label: "No",
            },
            {
                key: "item_name.itemCode",
                label: "Item Code",
            },
            {
                key: "itemDescription",
                label: "Item Description",
            },
            {
                key: "uom_details.uom",
                label: "UOM",
            },
            {
                key: "itemQuantityUm",
                label: "Quantity UM",
            },
            {
                key: "itemRate",
                label: "Rate",
            },
            {
                key: "itemNetAmount",
                label: "Amount",
            },
            {
                key: "itemStatus",
                label: "Status",
                formatter: (val) => getStatus(val),
            },
            {
                key: "pendingQtyUm",
                label: "Pending Qty UM",
            },
            {
                key: "pendingQtyUp",
                label: "Pending Qty UP",
            },
            {
                key: "action",
                label: "Action",
            },
        ]);

        const tableData = ref([]);


        const searchData = ref({
            indentNo: null,
            itemCode: null,
            itemDescription: null,
            drawingNumber: null,
        })
        const getIndentFilter = async () => {
            isModalTableBusy.value = true
            await axios.post('/api/new/get-Indent-Approval-item-filter', searchData.value).then((res) => {
                modalTables.value.indentData = res.data.data
            })
            isModalTableBusy.value = false
        }
        const searchSoData = ref({
            salesOrderNo: null,
            itemCode: null,
            itemName: null,
            itemDrawingNo: null,
        })

        const getSalesOrderFilter = async () => {
            isModalTableBusy.value = true
            //new/get-sales-orders-item-filters
            await axios.post('/api/get-sales-order-items-details-filter', searchSoData.value).then((res) => {
                modalTables.value.salesOrderData = res.data.data
            })
            isModalTableBusy.value = false
        }
        const searchPqData = ref({
            itemCode: null,
            itemDescription: null,
            itemDrawingNumber: null,
        })
        const getPurchaseQuotationFilter = async () => {
            isModalTableBusy.value = true
            await axios.post('/api/new/get-purchase-quotation-item-filters', searchPqData.value).then((res) => {
                modalTables.value.salesQuotationData = res.data.data
            })
            isModalTableBusy.value = false
        }
        const refetchData = async () => {
            isBusy.value = true;
            await axios.get(`/api/get-purchase-order-item/${router.currentRoute.params.id}`)
                .then((res) => {
                    tableData.value = res.data.data;
                });
            isBusy.value = false;
        };
        refetchData();

        const itemCodeOption = ref([]);
        axios.get("/api/get-item-master-options").then((res) => {
            itemCodeOption.value = res.data.data;
        });

        const uomOption = ref([]);
        axios.get("/api/get-uom-master-options").then((res) => {
            uomOption.value = res.data.data;
        });

        const itemOption = ref([]);
        axios.get("/api/get-item-master-options").then((res) => {
            itemOption.value = res.data.data;
        });

        const UPOption = ref([]);
        const woOption = ref([]);
        axios.get("/api/get-work-order-option").then((res) => {
            woOption.value = res.data.data;
        });

        const makeOption = ref([]);
        axios.get('/api/get-item-make-master-options').then(res => {
            makeOption.value = res.data.data
        })

        const soOption = ref([]);
        axios.get("/api/get-sales-order-options").then((res) => {
            soOption.value = res.data.data;
        });

        const storeOption = ref([]);
        axios.get("/api/get-store-master-options").then((res) => {
            storeOption.value = res.data.data;
        });

        const statusOptions = ref([
            {label: "Pending", value: 1},
            {label: "Canceled", value: 2},
            {label: "Completed", value: 3},
            {label: "Regret", value: 4},
        ]);

        const getStatus = (id) => {
            let statusLabel;
            statusOptions.value.filter((status) => {
                if (status.value !== id) {
                    return null;
                }
                statusLabel = status.label;
            });
            return statusLabel;
        };

        const modalTables = ref({
            indentFields: [
                {
                    key: "selectCheckBox",
                    label: "",
                },
                {
                    key: "indentNo",
                    label: "Indent No.",
                },
                {
                    key: "indentDate",
                    label: "Date",
                },
                {
                    key: "item_name.itemCode",
                    label: "Item Code",
                },
                {
                    key: "itemDescription",
                    label: "Description",
                },
                {
                    key: "uom_details.uom",
                    label: "uom",
                },
                {
                    key: "drawingNumber",
                    label: "Drg No",
                },
                {
                    key: "rev",
                    label: "Rev",
                },
                {
                    key: "reqQtyUm",
                    label: "Qty UM",
                },
                {
                    key: "qtyNos",
                    label: "Quantity",
                },
                {
                    key: "planAgaint",
                    label: "Plann Against",
                },
                {
                    key: "so_name.salesOrderNo",
                    label: "So No.",
                },
                {
                    key: "wo_name.woNumber",
                    label: "Wo No.",
                },
            ],
            indentData: [],
            salesOrderFields: [
                {
                    key: "selectCheckBox",
                    label: "",
                },
                {
                    key: "salesOrderNo",
                    label: "S.O.No",
                },
                {
                    key: 'po_number.customerPoNo',
                    label: 'Cust. P. O.',
                },
                {
                    key: "itemCode",
                    label: "Item Code",
                },
                {
                    key: "itemName",
                    label: "Description",
                },
                {
                    key: "uom_details.uom",
                    label: "uom",
                },
                {
                    key: "itemDrawingNo",
                    label: "Drawing No",
                },
                {
                    key: "itemDrawingRev",
                    label: "Rev",
                },
                {
                    key: "itemQuantity",
                    label: "Quantity",
                },
                {
                    key: "itemRate",
                    label: "Rate",
                },
                {
                    key: "pendingQty",
                    label: "Pending Qty",
                },
                {
                    key: "itemCustPartNo",
                    label: "Cust Part No",
                },
                {
                    key: "itemCustomDescription",
                    label: "SItemDescription",
                },
            ],
            salesOrderData: [],
            salesQuotationFields: [
                {
                    key: 'selectCheckBox',
                    label: ''
                },
                {
                    key: 'quotation_number.referenceNumber',
                    label: 'PQuotation Number'
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
                    key: 'itemDrawingNumber',
                    label: 'Drawing No.'
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
                    key: 'itemAmount',
                    label: 'Amount'
                }
            ],
            salesQuotationData: [],
        });

        const getSalesItemDetailWithFilter = async () => {
            await axios.post('/api/get-sales-order-items-details-filter').then((res) => {
                modalTables.value.salesOrderData = res.data.data;
            });
        };

        const getIndentItemDetailWithFilter = async () => {
            await axios.post("/api/mrp/get-indent-with-filter").then((res) => {
                modalTables.value.indentData = res.data.data;
            });
        };

        const getPurchaseQuotationItem = async () => {
            await axios.get(`/api/get-purchase-quotation-item-ref-wise/${refId.value}`).then((res) => {
                modalTables.value.salesQuotationData = res.data.data
            });

            /* await axios.get('/api/purchase-quotation-item').then((res) => {
                modalTables.value.salesQuotationData = res.data.data
            }); */
        };

        const openModal = async () => {
            switch (selectedRadio.value) {
                case "1":
                    await getIndentItemDetailWithFilter();
                    return indentModal.value.show();
                case "2":
                    await getSalesItemDetailWithFilter();
                    return salesOrderModal.value.show();
                case "3":
                    await getPurchaseQuotationItem()
                    return purchaseQuotationModal.value.show();
                default:
                    return toast({
                        component: ToastificationContent,
                        position: "top-right",
                        props: {
                            title: "Error",
                            icon: "AlertCircleIcon",
                            variant: "danger",
                            text: "Please Select Any Item.",
                        },
                    });
            }
        };

        const indentItemIds = ref([]);

        const addIndentItemDetails = async () => {
            await axios.post('/api/add-purchase-order-items', {
                type: selectedRadio.value,
                ids: indentItemIds.value,
                purchaseOrderId: router.currentRoute.params.id
            }).then(() => {
                toast({
                    component: ToastificationContent,
                    position: 'top-right',
                    props: {
                        title: 'Purchase Enquiry Item Added',
                        icon: 'CheckSquareIcon',
                        variant: 'success',
                        text: `You have successfully Added Purchase Enquiry Item.`,
                    },
                })
            }).catch(error => {
                toast({
                    component: ToastificationContent,
                    position: 'top-right',
                    props: {
                        title: `${error.response.statusText}`,
                        icon: 'AlertCircleIcon',
                        variant: 'danger',
                        text: `${error.response.data.message || 'Something went wrong'}`,
                    },
                })
            })
            resetIndentItemDetails();
            await refetchData();
        };

        const resetIndentItemDetails = () => {
            indentItemIds.value = [];
        };

        const checkIndentItem = (e, id) => {
            switch (e) {
                case false:
                    indentItemIds.value = indentItemIds.value.filter(function (e) {
                        return e !== id;
                    });
                    break;
                default:
                    indentItemIds.value.push(id);
                    break;
            }
        };

        const addSalesOrderItemDetails = async () => {
            await axios.post('/api/add-purchase-order-items', {
                type: selectedRadio.value,
                ids: salesOrderIds.value,
                purchaseOrderId: router.currentRoute.params.id
            }).then(() => {
                toast({
                    component: ToastificationContent,
                    position: 'top-right',
                    props: {
                        title: 'Purchase Enquiry Item Added',
                        icon: 'CheckSquareIcon',
                        variant: 'success',
                        text: `You have successfully Added Purchase Enquiry Item.`,
                    },
                })
            }).catch(error => {
                toast({
                    component: ToastificationContent,
                    position: 'top-right',
                    props: {
                        title: `${error.response.statusText}`,
                        icon: 'AlertCircleIcon',
                        variant: 'danger',
                        text: `${error.response.data.message || 'Something went wrong'}`,
                    },
                })
            })
            resetSalesOrderItemDetails();
            await refetchData();
        };

        const resetSalesOrderItemDetails = () => {
            salesOrderIds.value = [];
        };

        const salesOrderIds = ref([]);

        const checkItem = (e, id) => {
            if (e === false) {
                salesOrderIds.value = salesOrderIds.value.filter(function (e) {
                    return e !== id;
                });
            } else {
                salesOrderIds.value.push(id);
            }
        };

        const purchaseQuotationIds = ref([])

        const checkQuotationItem = (e, id) => {
            if (e === false) {
                purchaseQuotationIds.value = purchaseQuotationIds.value.filter(function (e) {
                    return e !== id;
                });
            } else {
                purchaseQuotationIds.value.push(id)
            }
        }

        const addPurchaseQuotationItemDetails = async () => {
            await axios.post('/api/add-purchase-order-items', {
                type: selectedRadio.value,
                ids: purchaseQuotationIds.value,
                purchaseOrderId: router.currentRoute.params.id
            }).then(() => {
                toast({
                    component: ToastificationContent,
                    position: 'top-right',
                    props: {
                        title: 'Purchase Quotation Item Added',
                        icon: 'CheckSquareIcon',
                        variant: 'success',
                        text: `You have successfully Added Purchase Quotation Item.`,
                    },
                })
            }).catch(error => {
                toast({
                    component: ToastificationContent,
                    position: 'top-right',
                    props: {
                        title: `${error.response.statusText}`,
                        icon: 'AlertCircleIcon',
                        variant: 'danger',
                        text: `${error.response.data.message || 'Something went wrong'}`,
                    },
                })
            })
            resetPurchaseQuotationItemDetails();
            await refetchData();
        };

        const resetPurchaseQuotationItemDetails = () => {
            purchaseQuotationIds.value = [];
        };

        const blankFormData = {
            _id: null,
            purchaseOrderId: router.currentRoute.params.id,
            itemId:null,
            itemCode: null,
            itemDescription: null,
            itemDescVendor: null,
            itemAddDescription: null,
            itemDetailDescription: null,
            itemUom: null,
            itemup: null,
            itemFactor: 0,
            itemQty: 0,
            itemQuantityUm: 0,
            itemQuantityUp: 0,
            pendingQtyUm: 0,
            pendingQtyUp: 0,
            itemRate: 0,
            itemDiscount: 0,
            itemDiscountValue: 0,
            itemAmount: 0,
            itemNetAmount: 0,
            itemSize: null,
            itemIndentNo: null,
            itemIndentDate: forMatIndianDate(),
            itemIndenter: null,
            itemRemark: null,
            itemJobNumber: null,
            itemMake: null,
            itemStore: null,
            itemDrowingNo: null,
            itemRev: null,
            itemStatus: 1,
            itemDeliveryDate: forMatIndianDate(getTcTodayDate()),
            itemSoNumber: null,
            itemWoNumber: null,
            itemHsnNumber:0,
            itemCgstPercent:0,
            itemSgstPercent:0,
            itemIgstUgstPercent:0,
            itemCgstAmount: 0,
            itemSgstAmount: 0,
            itemIgstUgstAmount: 0,
        };

        const selectedRadio = ref("");

        const formData = ref(JSON.parse(JSON.stringify(blankFormData)));

        const resetFormData = () => {
            formData.value = JSON.parse(JSON.stringify(blankFormData));
        };

        const onRowSelected = (items) => {
            if (items.length > 0) {
                formData.value._id = items[0]._id
                formData.value.purchaseOrderId = items[0].purchaseOrderId ?? null
                formData.value.itemId = items[0].itemId ?? null
                formData.value.itemCode = items[0].itemCode ?? null
                formData.value.itemDescription = items[0].itemDescription ?? null
                formData.value.itemDescVendor = items[0].itemDescVendor ?? null
                formData.value.itemAddDescription = items[0].itemAddDescription ?? null
                formData.value.itemDetailDescription = items[0].itemDetailDescription ?? null
                formData.value.itemUom = items[0].itemUom ?? null
                formData.value.itemup = items[0].itemup ?? null
                formData.value.itemFactor = items[0].itemFactor ?? null
                formData.value.itemQty = items[0].itemQty ?? null
                formData.value.itemQuantityUm = items[0].itemQuantityUm ?? null
                formData.value.itemQuantityUp = items[0].itemQuantityUp ?? null
                formData.value.pendingQtyUm = items[0].pendingQtyUm ?? null
                formData.value.pendingQtyUp = items[0].pendingQtyUp ?? null
                formData.value.itemRate = items[0].itemRate ?? null
                formData.value.itemDiscount = items[0].itemDiscount ?? null
                formData.value.itemDiscountValue = items[0].itemDiscountValue ?? null
                formData.value.itemAmount = items[0].itemAmount ?? null
                formData.value.itemNetAmount = items[0].itemNetAmount ?? null
                formData.value.itemSize = items[0].itemSize ?? null
                formData.value.itemIndentNo = items[0].itemIndentNo ?? null
                formData.value.itemIndentDate = items[0].itemIndentDate ?? null
                formData.value.itemIndenter = items[0].itemIndenter ?? null
                formData.value.itemRemark = items[0].itemRemark ?? null
                formData.value.itemJobNumber = items[0].itemJobNumber ?? null
                formData.value.itemMake = items[0].itemMake ?? null
                formData.value.itemStore = items[0].itemStore ?? null
                formData.value.itemDrowingNo = items[0].itemDrowingNo ?? null
                formData.value.itemRev = items[0].itemRev ?? null
                formData.value.itemStatus = items[0].itemStatus ?? null
                formData.value.itemDeliveryDate = items[0].itemDeliveryDate ?? null
                formData.value.itemSoNumber = items[0].itemSoNumber ?? null
                formData.value.itemWoNumber = items[0].itemWoNumber ?? null
                formData.value.itemHsnNumber = items[0].itemHsnNumber ?? null
                formData.value.itemCgstPercent = items[0].itemCgstPercent ?? null
                formData.value.itemSgstPercent = items[0].itemSgstPercent ?? null
                formData.value.itemIgstUgstPercent = items[0].itemIgstUgstPercent ?? null
                formData.value.itemCgstPercent = items[0].itemCgstPercent ?? null
                formData.value.itemSgstAmount = items[0].itemSgstAmount ?? null
                formData.value.itemIgstUgstAmount = items[0].itemIgstUgstAmount ?? null
            } else {
                resetFormData()
            }
        }

        const getItemDetails = async (id) => {
            await axios.get(`/api/item-master/${id}`).then((res) => {
                formData.value.itemDescription = res.data.data.itemDescription
                formData.value.itemAddDescription = res.data.data?.itemDetails?.description ?? null
                formData.value.itemDetailDescription = res.data.data?.itemDetails?.detailDescription ?? null
                formData.value.itemUom = res.data.data.uom
                formData.value.itemup = res.data.data.convUom
                formData.value.itemFactor = res.data.data.cFactor
                formData.value.itemQty = res.data.data.convQty
                formData.value.itemRemark = res.data.data?.itemDetails?.remarkNote ?? null
                formData.value.itemMake = res.data.data.make
                formData.value.itemDrowingNo = res.data.data?.itemDetails?.drawingNumber ?? null
                formData.value.itemRev = res.data.data?.itemDetails?.revision ?? null
                formData.value.itemStatus = res.data.data.status
                formData.value.itemHsnNumber = res.data.data?.hsnSacDetails?.hsnSacNo ?? null
                    formData.value.itemId = res.data.data?._id ?? null
            });
        };

        const deleteItemDetail = async (id) => {
            await Swal.fire({
                title: 'Are you sure?',
                text: "Delete Purchase Order Item",
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
                    store.dispatch('purchase-store-module/deletePurchaseOrderItem', {id: id}).then(res => {
                        if (res.status === 200) {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Purchase Order Item Deleted',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: `You have successfully Deleted Purchase Order Item.`,
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
                        resetFormData()
                        refetchData()
                    }).catch((error) => {
                        let response = error.response
                        if (response) {
                            let data = response.data
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Error',
                                    icon: 'AlertCircleIcon',
                                    variant: 'danger',
                                    text: data.message,
                                },
                            })
                        }
                    })
                }
            })
        };

        const saveFormData = async () => {
            if (formData.value._id === null) {
                await store.dispatch('purchase-store-module/addPurchaseOrderItem', formData.value).then(res => {
                    if (res.status === 200) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Purchase Order Item Added',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: `You have successfully Added Purchase Order Item.`,
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
                })
                resetFormData()
                await refetchData()
            } else {
                await store.dispatch('purchase-store-module/updatePurchaseOrderItem', formData.value).then(res => {
                    if (res.status === 200) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Purchase Order Item Update',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: `You have successfully Update Purchase Order Item.`,
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
                    resetFormData()
                    refetchData()
                }).catch((error) => {
                    let response = error.response
                    if (response) {
                        let data = response.data
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: data.message,
                                icon: 'AlertCircleIcon',
                                variant: 'danger',
                                text: data.errors.itemQuantityUm[0],
                            },
                        })
                    }
                })
            }
        };

        const calculateAmount = () => {
            formData.value.itemQuantityUp = formData.value.itemQuantityUm * formData.value.itemFactor * formData.value.itemQty
            formData.value.pendingQtyUm = formData.value.itemQuantityUm
            formData.value.pendingQtyUp = formData.value.itemQuantityUp

            if(roundingType.value === '2') {
                formData.value.itemAmount = changeAmountDecimalPoint(changeToRound(formData.value.itemQuantityUp * formData.value.itemRate), 2)
                formData.value.itemDiscountValue = changeAmountDecimalPoint(changeToRound((formData.value.itemAmount * formData.value.itemDiscount) / 100), 2)
                formData.value.itemNetAmount = changeAmountDecimalPoint(changeToRound(formData.value.itemAmount - formData.value.itemDiscountValue))
            }else{
                formData.value.itemAmount = formData.value.itemQuantityUp * formData.value.itemRate;
                formData.value.itemDiscountValue = (formData.value.itemAmount * formData.value.itemDiscount) / 100;
                formData.value.itemNetAmount = formData.value.itemAmount - formData.value.itemDiscountValue;
            }
        };

        const getItemDiscountCalculation = () => {
            let itemAmount = parseFloat(formData.value.itemQuantityUm * formData.value.itemRate);
            let discountValue = parseFloat(formData.value.itemDiscountValue);
            let isRound = parseInt(roundingType.value)

            if (isRound === 2){
                formData.value.itemNetAmount = changeAmountDecimalPoint(changeToRound(itemAmount - discountValue),2)
                formData.value.itemDiscount = parseFloat((discountValue / itemAmount) * 100).toFixed(2)
            }else{
                formData.value.itemNetAmount = parseFloat(itemAmount - discountValue).toFixed(2);
                formData.value.itemDiscount = parseFloat((discountValue / itemAmount) * 100).toFixed(2);
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

        const {refFormObserver, getValidationState, resetForm} = formValidation(resetFormData);

        return {
            isBusy,
            refetchData,
            formData,
            getValidationState,
            refFormObserver,
            resetForm,
            resetFormData,
            itemCodeOption,
            uomOption,
            UPOption,
            itemOption,
            makeOption,
            storeOption,
            statusOptions,
            getStatus,
            woOption,
            soOption,
            tableData,
            tableFields,
            getItemDetails,
            indentModal,
            selectedRadio,
            openModal,
            modalTables,
            salesOrderModal,
            addIndentItemDetails,
            indentItemIds,
            checkIndentItem,
            resetIndentItemDetails,
            addSalesOrderItemDetails,
            resetSalesOrderItemDetails,
            salesOrderIds,
            checkItem,
            getPurchaseQuotationItem,
            purchaseQuotationModal,
            purchaseQuotationIds,
            checkQuotationItem,
            addPurchaseQuotationItemDetails,
            resetPurchaseQuotationItemDetails,
            calculateAmount,
            deleteItemDetail,
            saveFormData,
            getPoItemFormateDate,
            dateFormat,
            formatDates,
            getIndentFormateDate,
            isModalTableBusy,
            searchData,
            getIndentFilter,
            getSalesOrderFilter,
            searchSoData,
            searchPqData,
            getPurchaseQuotationFilter,
            roundingType,
            getItemDiscountCalculation,
            gstCalculation,
            onRowSelected
        };
    },
};
</script>
<style lang="scss">
@import '~@core/scss/vue/libs/vue-sweetalert.scss';
</style>
