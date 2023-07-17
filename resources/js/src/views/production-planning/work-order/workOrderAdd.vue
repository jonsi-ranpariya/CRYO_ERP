<template>
    <div>
        <b-card-code>
            <validation-observer #default="{ handleSubmit }">
                <b-form @submit.prevent="handleSubmit(saveFormData)">
                    <b-row>
                        <b-col md="12">
                            <h5>Work Order Details</h5>
                            <hr>
                        </b-col>
                        <b-col md="6">
                            <b-row>
                                <b-col md="6">
                                    <validation-provider
                                        #default="validationContext"
                                        name="W.O.No."
                                        rules=""
                                    >
                                        <b-form-group
                                            label="W.O.No."
                                            label-for="woNumber"
                                        >
                                            <b-form-input
                                                id="woNumber"
                                                v-model="formData.woNumber"
                                                readonly
                                                :state="getValidationState(validationContext)"
                                            />
                                        </b-form-group>
                                    </validation-provider>
                                </b-col>
                                <b-col md="6">
                                    <validation-provider
                                        #default="validationContext"
                                        name="W.O. Date"
                                        rules=""
                                    >
                                        <b-form-group
                                            label="W.O. Date"
                                            label-for="woDate"
                                            :state="getValidationState(validationContext)"
                                        >
                                            <b-input-group>
                                                <cleave
                                                    id="woDate"
                                                    v-model="formData.woDate"
                                                    class="form-control"
                                                    :raw="false"
                                                    :options="dateFormat"
                                                    placeholder="DD/MM/YYYY"
                                                    show-decade-nav
                                                />
                                                <b-input-group-append>
                                                    <b-form-datepicker
                                                        v-model="formatDates.woDate"
                                                        button-only
                                                        @input="getWoFormateDate($event)"
                                                        show-decade-nav
                                                        size="sm"
                                                        nav-button-variant="primary"
                                                    />
                                                </b-input-group-append>
                                            </b-input-group>
                                        </b-form-group>
                                    </validation-provider>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col md="6">
                                    <validation-provider
                                        #default="validationContext"
                                        name="S.O. No."
                                        rules=""
                                    >
                                        <b-form-group
                                            label="S.O.No."
                                            label-for="soNumber"
                                        >
                                            <b-form-input
                                                id="soNumber"
                                                readonly
                                                v-model="formData.soNumber"
                                                :state="getValidationState(validationContext)"
                                            />
                                        </b-form-group>
                                    </validation-provider>
                                </b-col>
                                <b-col md="6">
                                    <validation-provider
                                        #default="validationContext"
                                        name="S.O. Date"
                                        rules=""
                                    >
                                        <b-form-group
                                            label="S.O. Date"
                                            label-for="soDate"
                                        >
                                            <b-input-group>
                                                <cleave
                                                    id="soDate"
                                                    v-model="formData.soDate"
                                                    class="form-control"
                                                    :raw="false"
                                                    :options="dateFormat"
                                                    placeholder="DD/MM/YYYY"
                                                    show-decade-nav
                                                    :state="getValidationState(validationContext)"
                                                />
                                                <b-input-group-append>
                                                    <b-form-datepicker
                                                        v-model="formatDates.soDate"
                                                        button-only
                                                        @input="getWoSoFormateDate($event)"
                                                        show-decade-nav
                                                        size="sm"
                                                        nav-button-variant="primary"
                                                    />
                                                </b-input-group-append>
                                            </b-input-group>
                                        </b-form-group>
                                    </validation-provider>
                                </b-col>
                            </b-row>
                            <validation-provider
                                #default="validationContext"
                                name="Party"
                                rules=""
                            >
                                <b-form-group
                                    label="Party"
                                    label-for="partyCode"
                                >
                                    <b-form-input
                                        id="partyCode"
                                        readonly
                                        v-model="formData.partyCode"
                                        :state="getValidationState(validationContext)"
                                    />
                                </b-form-group>
                            </validation-provider>
                            <validation-provider
                                #default="validationContext"
                                name="Cust P.O.No."
                                rules=""
                            >
                                <b-form-group
                                    label="Cust P.O.No."
                                    label-for="custPoNumber"
                                >
                                    <b-form-input
                                        id="custPoNumber"
                                        v-model="formData.custPoNo"
                                        :state="getValidationState(validationContext)"
                                    />
                                </b-form-group>
                            </validation-provider>
                            <validation-provider
                                #default="validationContext"
                                name="Assembly Code"
                                rules="required"
                            >
                                <b-form-group
                                    label="Assembly Code"
                                    label-for="assemblyCode"
                                    :state="getValidationState(validationContext)"
                                >
                                    <b-input-group>
                                        <b-form-input
                                            readonly
                                            v-model="formData.assemblyCode"
                                            :state="getValidationState(validationContext)"
                                        />
                                        <b-input-group-append>
                                            <b-button variant="primary" @click="openModal">...</b-button>
                                        </b-input-group-append>
                                    </b-input-group>
                                    <b-form-invalid-feedback>
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                            <validation-provider
                                #default="validationContext"
                                name="Assembly"
                                rules="required"
                            >
                                <b-form-group
                                    label="Assembly"
                                    label-for="assembly"
                                    :state="getValidationState(validationContext)"
                                >
                                    <b-form-input
                                        id="assembly"
                                        readonly
                                        v-model="formData.assembly"
                                        :state="getValidationState(validationContext)"
                                    />
                                    <b-form-invalid-feedback>
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                            <validation-provider
                                #default="validationContext"
                                name="Add. Description"
                                rules=""
                            >
                                <b-form-group
                                    label="Add. Description"
                                    label-for="addDescription"
                                >
                                    <b-form-input
                                        id="addDescription"
                                        v-model="formData.addDescription"
                                        :state="getValidationState(validationContext)"
                                    />
                                </b-form-group>
                            </validation-provider>
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
                                        v-model="formData.detailDescription"
                                        :state="getValidationState(validationContext)"
                                    />
                                </b-form-group>
                            </validation-provider>
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
                                        v-model="formData.drawingNo"
                                        :state="getValidationState(validationContext)"
                                    />
                                </b-form-group>
                            </validation-provider>
                            <validation-provider
                                #default="validationContext"
                                name="Rev"
                                rules=""
                            >
                                <b-form-group
                                    label="Rev"
                                    label-for="drawingRev"
                                >
                                    <b-form-input
                                        id="drawingRev"
                                        v-model="formData.drawingRev"
                                        :state="getValidationState(validationContext)"
                                    />
                                </b-form-group>
                            </validation-provider>
                            <validation-provider
                                #default="validationContext"
                                name="W.O. Quantity"
                                rules=""
                            >
                                <b-form-group
                                    label="W.O. Quantity"
                                    label-for="woQty"
                                >
                                    <b-form-input
                                        id="woQty"
                                        v-model="formData.woQty"
                                        :state="getValidationState(validationContext)"
                                    />
                                </b-form-group>
                            </validation-provider>
                        </b-col>
                        <b-col md="6">
                            <b-row>
                                <b-col md="6">
                                    <validation-provider
                                        #default="validationContext"
                                        name="W.O. Type"
                                        rules=""
                                    >
                                        <b-form-group
                                            label="W.O. Type"
                                            label-for="woType"
                                        >
                                            <v-select
                                                placeholder="Select Type"
                                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                                :options="workOrderType"
                                                :reduce="val => val.value"
                                                :clearable="false"
                                                input-id="woType"
                                                v-model="formData.woType"
                                                @input="clearFormData"
                                                :state="getValidationState(validationContext)"
                                            />
                                        </b-form-group>
                                    </validation-provider>
                                </b-col>
                                <b-col md="6">
                                    <validation-provider
                                        #default="validationContext"
                                        name="Sales Type"
                                        rules=""
                                    >
                                        <b-form-group
                                            label="Sales Type"
                                            label-for="salesType"
                                        >
                                            <v-select
                                                placeholder="Select Type"
                                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                                :options="salesTypeOptions"
                                                :reduce="val => val.value"
                                                :clearable="false"
                                                input-id="salesType"
                                                v-model="formData.salesType"
                                                :state="getValidationState(validationContext)"
                                            />
                                        </b-form-group>
                                    </validation-provider>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col md="6">
                                    <validation-provider
                                        #default="validationContext"
                                        name="Status"
                                        rules=""
                                    >
                                        <b-form-group
                                            label="Status"
                                            label-for="status"
                                        >
                                            <v-select
                                                placeholder="Select Status"
                                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                                :options="statusOptions"
                                                :reduce="val => val.value"
                                                :clearable="false"
                                                input-id="status"
                                                v-model="formData.status"
                                                disabled
                                                :state="getValidationState(validationContext)"
                                            />
                                        </b-form-group>
                                    </validation-provider>
                                </b-col>
                                <b-col md="6">
                                    <validation-provider
                                        #default="validationContext"
                                        name="WO Status"
                                        rules=""
                                    >
                                        <b-form-group
                                            label="WO Status"
                                            label-for="woStatus"
                                        >
                                            <v-select
                                                placeholder="Select Status"
                                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                                :options="woStatusOptions"
                                                :reduce="val => val.value"
                                                :clearable="false"
                                                input-id="woStatus"
                                                v-model="formData.woStatus"
                                                disabled
                                                :state="getValidationState(validationContext)"
                                            />
                                        </b-form-group>
                                    </validation-provider>
                                </b-col>
                            </b-row>
                            <validation-provider
                                #default="validationContext"
                                name="UOM"
                                rules=""
                            >
                                <b-form-group
                                    label="UOM"
                                    label-for="uom"
                                >
                                    <v-select
                                        placeholder="Select UOM"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="uomOptions"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        input-id="uom"
                                        v-model="formData.uom"
                                        :state="getValidationState(validationContext)"
                                    />
                                </b-form-group>
                            </validation-provider>
                            <validation-provider
                                #default="validationContext"
                                name="BOM No."
                                rules="required"
                            >
                                <b-form-group
                                    label="BOM No."
                                    label-for="bomNumber"
                                    :state="getValidationState(validationContext)"
                                >
                                    <v-select
                                        placeholder="Select BOM"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="bomOptions"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        input-id="bomNumber"
                                        v-model="formData.bomNo"
                                        :state="getValidationState(validationContext)"
                                        type=number
                                        :disabled="formData.reGenerateWoItem"
                                    />
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                            <validation-provider
                                #default="validationContext"
                                name="Prod. Engineer"
                                rules=""
                            >
                                <b-form-group
                                    label="Prod. Engineer"
                                    label-for="prodEngineer"
                                >
                                    <v-select
                                        placeholder="Select Engineer"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="userOptions"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        input-id="prodEngineer"
                                        v-model="formData.prodEngineer"
                                        :state="getValidationState(validationContext)"
                                    />
                                </b-form-group>
                            </validation-provider>
                            <validation-provider
                                #default="validationContext"
                                name="P.O. Date"
                                rules=""
                            >
                                <b-form-group
                                    label="P.O. Date"
                                    label-for="poDate"
                                >
                                    <b-input-group>
                                        <b-input-group-prepend>
                                            <b-form-datepicker
                                                v-model="formatDates.poDate"
                                                button-only
                                                @input="getWoPoFormateDate($event)"
                                                show-decade-nav
                                                size="sm"
                                                nav-button-variant="primary"
                                            />
                                        </b-input-group-prepend>
                                        <cleave
                                            id="poDate"
                                            v-model="formData.poDate"
                                            class="form-control"
                                            :raw="false"
                                            :options="dateFormat"
                                            placeholder="DD/MM/YYYY"
                                            show-decade-nav
                                            :state="getValidationState(validationContext)"
                                        />
                                    </b-input-group>
                                </b-form-group>
                            </validation-provider>
                            <validation-provider
                                #default="validationContext"
                                name="WO Start Date"
                                rules=""
                            >
                                <b-form-group
                                    label="WO Start Date"
                                    label-for="woStartDate"
                                >
                                    <b-input-group>
                                        <b-input-group-prepend>
                                            <b-form-datepicker
                                                v-model="formatDates.woStartDate"
                                                button-only
                                                @input="getWoStartFormateDate($event)"
                                                show-decade-nav
                                                size="sm"
                                                nav-button-variant="primary"
                                            />
                                        </b-input-group-prepend>
                                        <cleave
                                            id="woStartDate"
                                            v-model="formData.woStartDate"
                                            class="form-control"
                                            :raw="false"
                                            :options="dateFormat"
                                            placeholder="DD/MM/YYYY"
                                            show-decade-nav
                                            :state="getValidationState(validationContext)"
                                        />
                                    </b-input-group>
                                </b-form-group>
                            </validation-provider>
                            <validation-provider
                                #default="validationContext"
                                name="Delivery Date"
                                rules=""
                            >
                                <b-form-group
                                    label="Delivery Date"
                                    label-for="deliveryDate"
                                >
                                    <b-input-group>
                                        <b-input-group-prepend>
                                            <b-form-datepicker
                                                v-model="formatDates.woDeliveryDate"
                                                button-only
                                                @input="getWoDeliveryFormateDate($event)"
                                                show-decade-nav
                                                size="sm"
                                                nav-button-variant="primary"
                                            />
                                        </b-input-group-prepend>
                                        <cleave
                                            id="woDeliveryDate"
                                            v-model="formData.woDeliveryDate"
                                            class="form-control"
                                            :raw="false"
                                            :options="dateFormat"
                                            placeholder="DD/MM/YYYY"
                                            show-decade-nav
                                            :state="getValidationState(validationContext)"
                                        />
                                    </b-input-group>
                                </b-form-group>
                            </validation-provider>
                            <validation-provider
                                #default="validationContext"
                                name="D.S.No."
                                rules=""
                            >
                                <b-form-group
                                    label="D.S.No."
                                    label-for="dsNumber"
                                >
                                    <b-form-input
                                        id="dsNumber"
                                        v-model="formData.dsNo"
                                        :state="getValidationState(validationContext)"
                                    />
                                </b-form-group>
                            </validation-provider>
                            <validation-provider
                                #default="validationContext"
                                name="Remark"
                                rules=""
                            >
                                <b-form-group
                                    label="Remark"
                                    label-for="remark"
                                >
                                    <b-form-textarea
                                        id="remark"
                                        rows="2"
                                        v-model="formData.remark"
                                        :state="getValidationState(validationContext)"
                                    />
                                </b-form-group>
                            </validation-provider><br>
                            <b-form-checkbox
                                id="conversion"
                                class="custom-control-primary"
                                v-model="formData.reGenerateWoItem"
                                :disabled="!formData.assemblyCode"
                            >
                                Re-Generate WO Items When Edit WO
                            </b-form-checkbox>
                        </b-col>
                        <b-col md="12">
                            <hr>
                            <b-button
                                variant="primary"
                                type="submit"
                            >
                                Save
                            </b-button>
                        </b-col>
                    </b-row>
                </b-form>
            </validation-observer>
        </b-card-code>

        <!-- Sales Work Order Modal -->
        <b-modal
            id="salesWorkOrderItemModal"
            title="Sales Work Order Item"
            size="xl"
            no-close-on-backdrop
            ref="salesWorkOrderItemModal"
            scrollable
            ok-only
            ok-variant="danger"
            ok-title="Cancel"
            @ok="resetSalesModalData"
            @cancel="resetSalesModalData"
        >
            <b-row>
                <b-col md="3">
                    <b-form-group label="SO Number" label-for="itemSoNumber">
                        <b-form-input
                            id="itemSoNumber"
                            v-model.trim="searchData.salesDataSearch.salesOrderNo"
                            @keyup="getSalesOrderItemData"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="3">
                    <b-form-group label="Item Code" label-for="itemCode">
                        <b-form-input
                            id="itemCode"
                            v-model.trim="searchData.salesDataSearch.itemCode"
                            @keyup="getSalesOrderItemData"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="3">
                    <b-form-group label="Description" label-for="itemDescription">
                        <b-form-input
                            id="itemDescription"
                            v-model.trim="searchData.salesDataSearch.itemName"
                            @keyup="getSalesOrderItemData"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="3">
                    <b-form-group label="Drawing Number" label-for="itemDrawingNumber">
                        <b-form-input
                            id="itemDrawingNumber"
                            v-model.trim="searchData.salesDataSearch.itemDrawingNo"
                            @keyup="getSalesOrderItemData"
                        />
                    </b-form-group>
                </b-col>
            </b-row>
            <b-table
                responsive
                :fields="modalTableData.salesOrderItemFields"
                :items="modalTableData.salesOrderItemData"
                ref="table"
                show-empty
                bordered
                hover
            >

                <!--Select Item-->
                <template #cell(selectItem)="data">
                    <b-button
                        variant="primary"
                        type="button"
                        size="sm"
                        @click="selectSalesOrderItem(data.item)"
                    >
                        Select
                    </b-button>
                </template>

                <!--Show Item Details-->
                <template #cell(itemDetails)="data">
                    <b-form-checkbox
                        v-model="data.detailsShowing"
                        class="vs-checkbox-con"
                        @change="data.toggleDetails"
                    >
                        <span class="vs-label">{{ data.detailsShowing ? 'Hide' : 'Show' }}</span>
                    </b-form-checkbox>
                </template>

                <template #row-details="row">
                    <b-card>
                        <b-row>
                            <b-col md="4" class="mb-1">
                                <strong>Party Code: </strong>
                                <span v-if="row.item.po_number">{{ row.item.po_number.sellToPartyCustomerCode }}</span>
                                <span v-else>{{ null }}</span>
                            </b-col>
                            <b-col md="4" class="mb-1">
                                <strong>Item Code: </strong>{{ row.item.itemCode }}
                            </b-col>
                            <b-col md="4" class="mb-1">
                                <strong>item Description: </strong>{{ row.item.itemName }}
                            </b-col>
                            <b-col md="4" class="mb-1">
                                <strong>Add. Description: </strong>{{ row.item.itemAddonDescription }}
                            </b-col>
                            <b-col md="4" class="mb-1">
                                <strong>Drawing Number: </strong>{{ row.item.itemDrawingNo }}
                            </b-col>
                            <b-col md="4" class="mb-1">
                                <strong>Drawing Version: </strong>{{ row.item.itemDrawingRev }}
                            </b-col>
                            <b-col md="4" class="mb-1">
                                <strong>S.O. Qty: </strong>{{ row.item.itemQuantity }}
                            </b-col>
                            <b-col md="4" class="mb-1">
                                <strong>Customer P.O. No: </strong>
                                <span v-if="row.item.po_number">{{ row.item.po_number.customerPoNo }}</span>
                                <span v-else>{{ null }}</span>
                            </b-col>
                            <b-col md="4" class="mb-1">
                                <strong>Detail Desc: </strong>{{ row.item.itemDetailDescription }}
                            </b-col>
                        </b-row>

                        <b-button
                            size="sm"
                            variant="outline-success"
                            @click="selectSalesOrderItem(row.item)"
                        >
                            Select Item
                        </b-button>
                        <b-button
                            size="sm"
                            variant="outline-secondary"
                            @click="row.toggleDetails"
                        >
                            Hide Details
                        </b-button>
                    </b-card>
                </template>
            </b-table>
        </b-modal>

        <!--All Item Modal-->
        <b-modal
            id="itemMasterModal"
            title="Sales Work Order Item"
            size="xl"
            no-close-on-backdrop
            ref="itemMasterModal"
            scrollable
            ok-only
            ok-variant="danger"
            ok-title="Cancel"
            @ok="resetItemMasterModalData"
            @cancel="resetItemMasterModalData"
        >
            <b-row>
                <b-col md="3">
                    <b-form-group label="Item Code" label-for="itemMasterCode">
                        <b-form-input
                            id="itemMasterCode"
                            v-model.trim="searchData.itemMasterSearch.itemCode"
                            @keyup="geItemMasterData"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="3">
                    <b-form-group label="Item Description" label-for="masterDescription">
                        <b-form-input
                            id="masterDescription"
                            v-model.trim="searchData.itemMasterSearch.itemDescription"
                            @keyup="geItemMasterData"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="3">
                    <b-form-group label="Detail Description" label-for="masterDetailDescription">
                        <b-form-input
                            id="masterDetailDescription"
                            v-model.trim="searchData.itemMasterSearch.detailDescription"
                            @keyup="geItemMasterData"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="3">
                    <b-form-group label="Drawing Number" label-for="masterDrawingNumber">
                        <b-form-input
                            id="masterDrawingNumber"
                            v-model.trim="searchData.itemMasterSearch.drawingNumber"
                            @keyup="geItemMasterData"
                        />
                    </b-form-group>
                </b-col>
            </b-row>
            <b-table
                responsive
                :fields="modalTableData.itemMasterFields"
                :items="modalTableData.itemMasterData"
                bordered
                hover
                ref="table"
                show-empty
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

                <!--Show Item Details-->
                <template #cell(itemDetails)="data">
                    <b-form-checkbox
                        v-model="data.detailsShowing"
                        class="vs-checkbox-con"
                        @change="data.toggleDetails"
                    >
                        <span class="vs-label">{{ data.detailsShowing ? 'Hide' : 'Show' }}</span>
                    </b-form-checkbox>
                </template>

                <template #row-details="row">
                    <b-card>
                        <b-row>
                            <b-col md="4" class="mb-1">
                                <strong>Add Description: </strong>
                                {{ row.item.po_number.sellToPartyCustomerCode }}
                            </b-col>
                            <b-col md="4" class="mb-1">
                                <strong>Detail Description: </strong>
                            </b-col>
                            <b-col md="4" class="mb-1">
                                <strong>Drawing Revision: </strong>
                            </b-col>
                        </b-row>
                        <div class="mt-1">
                            <b-button
                                size="sm"
                                variant="outline-success"
                                @click="selectItemMasterItem(row.item)"
                            >
                                Select Item
                            </b-button>
                            <b-button
                                size="sm"
                                variant="outline-secondary"
                                @click="row.toggleDetails"
                            >
                                Hide Details
                            </b-button>
                        </div>
                    </b-card>
                </template>
            </b-table>
        </b-modal>
    </div>
</template>
<script>
import BCardCode from '@core/components/b-card-code'
import {
    BRow,
    BCol,
    BFormGroup,
    BFormInput,
    BFormTextarea,
    BFormCheckbox,
    BForm,
    BButton,
    BFormDatepicker,
    BInputGroup,
    BInputGroupAppend,
    BTable,
    BFormInvalidFeedback,
    BCard,
    BSpinner,
    BInputGroupPrepend
} from 'bootstrap-vue'
import Ripple from 'vue-ripple-directive'
import vSelect from 'vue-select'
import store from '@/store'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
import {ValidationProvider, ValidationObserver} from 'vee-validate'
import formValidation from '@core/comp-functions/forms/form-validation'
import {ref, onUnmounted, onMounted} from '@vue/composition-api'
import axios from '@axios'
import {getUserData} from "../../../auth/utils";
import moment from 'moment'
import {getTcTodayDate, getSalesTypeListOption} from '@core/utils/utils'
import productionPlanningStoreModule from '../productionPlanningStoreModule'
import {useToast} from 'vue-toastification/composition'
import router from '@/router'
import {forMatIndianDate} from "@core/utils/utils";
import Cleave from 'vue-cleave-component'
import {required} from '@validations'

export default {
    components: {
        BCardCode,
        ValidationProvider,
        ValidationObserver,
        BRow,
        BCol,
        BFormGroup,
        BFormInput,
        BFormCheckbox,
        BFormTextarea,
        BForm,
        BButton,
        BFormDatepicker,
        BInputGroup,
        BInputGroupAppend,
        BTable,
        BFormInvalidFeedback,
        BCard,
        BSpinner,
        vSelect,
        Cleave,
        BInputGroupPrepend
    },
    directives: {
        Ripple,
    },
    setup({salesWorkOrderItemModal, itemMasterModal}) {
        const ITEMADDON_APP_STORE_MODULE_NAME = 'production-planning'
        onMounted(() => {
            if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, productionPlanningStoreModule)
        });
        onUnmounted(() => {
            if (store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.unregisterModule(ITEMADDON_APP_STORE_MODULE_NAME)
        })

        const toast = useToast()

        salesWorkOrderItemModal = ref()

        itemMasterModal = ref()

        const CurrentUserData = ref(getUserData())

        const uomOptions = ref([])
        axios.get('/api/get-uom-master-options').then(res => {
            uomOptions.value = res.data.data
        })

        const bomOptions = ref([])
        /*axios.get('/api/get-bom-versions-options').then(res => {
            bomOptions.value = res.data.data
        })*/

        const userOptions = ref([])
        axios.get('/api/get-users-options').then(res => {
            userOptions.value = res.data.data
        })
        const dateFormat = ref({
            date: true,
            delimiter: '/',
            datePattern: ['d', 'm', 'Y'],
        })

        const formatDates = ref({
            woDate: null,
            soDate: null,
            poDate: null,
            woStartDate: null,
            woDeliveryDate: null,
        })

        const getWoFormateDate = (date) => {
            formData.value.woDate = forMatIndianDate(date)
        }

        const getWoSoFormateDate = (date) => {
            formData.value.soDate = forMatIndianDate(date)
        }
        const getWoPoFormateDate = (date) => {
            formData.value.poDate = forMatIndianDate(date)
        }
        const getWoStartFormateDate = (date) => {
            formData.value.woStartDate = forMatIndianDate(date)
        }
        const getWoDeliveryFormateDate = (date) => {
            formData.value.woDeliveryDate = forMatIndianDate(date)
        }
        const workOrderType = ref([
            {label: 'Against Sales Order', value: 1},
            {label: 'Stock Order', value: 2},
            {label: 'Against Work Order', value: 3},
            {label: 'Against Replacement', value: 4},
            {label: 'Against Sample Trial', value: 5},
            {label: 'Against Shop Rejection', value: 6},
        ])

        const salesTypeOptions = getSalesTypeListOption()

        const statusOptions = ref([
            {label: 'Pending', value: 1},
            {label: 'Canceled', value: 2},
            {label: 'Completed', value: 3},
        ])

        const woStatusOptions = ref([
            {label: 'Prepared', value: 1},
        ])

        const blankFormData = {
            woNumber: null,
            woDate: forMatIndianDate(getTcTodayDate()),
            soId: null,
            soNumber: null,
            soDate: forMatIndianDate(),
            partyCode: null,
            custPoNo: null,
            itemId: null,
            assemblyCode: null,
            assembly: null,
            addDescription: null,
            detailDescription: null,
            drawingNo: null,
            drawingRev: null,
            woQty: null,
            woType: 1,
            salesType: null,
            status: 1,
            woStatus: 1,
            uom: null,
            bomNo: null,
            prodEngineer: null,
            poDate: forMatIndianDate(),
            woStartDate: forMatIndianDate(getTcTodayDate()),
            woDeliveryDate: forMatIndianDate(),
            dsNo: null,
            remark: null,
            reGenerateWoItem:false,
            LoginData: {
                createdBy: CurrentUserData.value.first_name + ' ' + CurrentUserData.value.last_name,
                createdDate: moment(new Date()).format('DD/MM/YYYY HH:mm'),
                lastModifyBy: null,
                lastModifyDate: null,
                approveBy: null,
                approveDate: null,
            }
        }

        const formData = ref(JSON.parse(JSON.stringify(blankFormData)))

        const resetFormData = () => {
            formData.value = JSON.parse(JSON.stringify(blankFormData))
        }

        const clearFormData = () => {
            formData.value.soNumber = null
            formData.value.soDate = null
            formData.value.partyCode = null
            formData.value.custPoNo = null
            formData.value.itemId = null
            formData.value.assemblyCode = null
            formData.value.assembly = null
            formData.value.addDescription = null
            formData.value.detailDescription = null
            formData.value.drawingNo = null
            formData.value.drawingRev = null
            formData.value.woQty = null
            formData.value.salesType = null
            formData.value.uom = null
            formData.value.bomNo = null
            formData.value.prodEngineer = null
            formData.value.poDate = null
            formData.value.remark = null
            resetSalesModalData()
        }

        const modalTableData = ref({
            salesOrderItemFields: [
                {
                    key: 'selectItem',
                    label: ''
                },
                {
                    key: 'itemDetails',
                    label: 'Details'
                },
                {
                    key: 'bomNumber',
                    label: 'BOM No.'
                },
                {
                    key: 'salesOrderNo',
                    label: 'SONo'
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
                    key: 'itemDrawingNo',
                    label: 'Drg No'
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
                    key: 'itemAmount',
                    label: 'Amount'
                },
                {
                    key: 'itemStatus',
                    label: 'status'
                },
            ],
            salesOrderItemData: [],
            itemMasterFields: [
                {
                    key: 'selectItem',
                    label: ''
                },
                {
                    key: 'itemCode',
                    label: 'itemCode'
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
                    label: 'drawing number'
                },
                {
                    key: 'itemDetails.revision',
                    label: 'Rev'
                },
                {
                    key: 'userDefination',
                    label: 'User Defination'
                },
                {
                    key: 'uom_item.uom',
                    label: 'uom'
                },
            ],
            itemMasterData: [],
        })

        const searchData = ref({
            salesDataSearch: {
                salesOrderNo: null,
                itemCode: null,
                itemName: null,
                itemDrawingNo: null
            },
            itemMasterSearch: {
                itemCode: null,
                itemDescription: null,
                detailsDescription: null,
                drawingNumber: null
            }
        })
        //new/get-sales-orders-item-filters
        const getSalesOrderItemData = async () => {
            await axios.post('/api/get-sales-order-items-details-filter', searchData.value.salesDataSearch).then(res => {
                modalTableData.value.salesOrderItemData = res.data.data
            })
        }

        const geItemMasterData = async () => {
            await axios.post('/api/get-item-master-with-filter', searchData.value.itemMasterSearch).then(res => {
                modalTableData.value.itemMasterData = res.data.data
            })
        }

        const resetSalesModalData = () => {
            searchData.value.salesDataSearch.salesOrderNo = null
            searchData.value.salesDataSearch.itemCode = null
            searchData.value.salesDataSearch.itemName = null
            searchData.value.salesDataSearch.itemDrawingNo = null
            modalTableData.value.salesOrderItemData = []
        }

        const resetItemMasterModalData = () => {
            searchData.value.itemMasterSearch.itemCode = null
            searchData.value.itemMasterSearch.drawingNumber = null
            searchData.value.itemMasterSearch.itemDescription = null
            searchData.value.itemMasterSearch.detailsDescription = null
            modalTableData.value.itemMasterData = []
        }

        const openModal = async () => {
            switch (formData.value.woType) {
                case 1:
                    return salesWorkOrderItemModal.value.show();

                default:
                    return itemMasterModal.value.show();
            }
        }

        const selectSalesOrderItem = async (data) => {
            bomOptions.value = []
            formData.value.soId = data?.salesOrderId ?? null
            formData.value.soNumber = data?.salesOrderNo ?? null
            formData.value.drawingNo = data?.itemDrawingNo ?? null
            formData.value.drawingRev = data?.itemDrawingRev ?? null
            formData.value.addDescription = data?.itemAddonDescription ?? null
            formData.value.detailDescription = data?.itemDetailDescription ?? null
            formData.value.assemblyCode = data?.itemCode ?? null
            formData.value.assembly = data?.itemName ?? null
            formData.value.uom = data?.itemUom ?? null
            formData.value.soDate = data?.created_at ?? null
            formData.value.remark = data?.itemNote ?? null
            formData.value.woQty = data?.itemQuantity ?? null
            formData.value.itemId = data.itemId ?? null
            formData.value.salesType = data?.po_number?.salesOrderSalesType ?? null
            formData.value.partyCode = data?.po_number?.sellToPartyCustomerCode ?? null
            formData.value.custPoNo = data?.po_number?.customerPoNo ?? null
            formData.value.poDate = data?.po_number?.salesOrderPoDate ?? null
            formData.value.woDeliveryDate = data?.po_number?.salesOrderCommittedDate ?? null
            salesWorkOrderItemModal.value.hide();
            resetSalesModalData();
            await axios.post('/api/get-bom-versions-item-wise-options', {
                itemCode: data.itemId ?? null
            }).then((res) => {
                bomOptions.value = res.data.data;
            });
        }

        const selectItemMasterItem = (data) => {
            formData.value.uom = data.uom
            formData.value.assemblyCode = data.itemCode
            formData.value.assembly = data.itemDescription
            formData.value.itemId = data._id
            formData.value.drawingNo = data?.itemDetails?.drawingNumber ?? null
            formData.value.drawingRev = data?.itemDetails?.revision ?? null
            formData.value.detailDescription = data?.itemDetails?.detailDescription ?? null
            formData.value.addDescription = data?.itemDetails?.description ?? null
            itemMasterModal.value.hide()
            resetItemMasterModalData()
        }

        const saveFormData = async () => {
            await store.dispatch('production-planning/addWorkOrder', formData.value).then(res => {
                if (res.status === 200) {
                    toast({
                        component: ToastificationContent,
                        position: 'top-right',
                        props: {
                            title: 'Work Order Added',
                            icon: 'CheckSquareIcon',
                            variant: 'success',
                            text: `You have successfully Added Work Order.`,
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
                router.push({name: 'edit-work-order', params: {id: res.data.data._id}})
            })
        }

        const {
            refFormObserver,
            getValidationState,
            resetForm
        } = formValidation(resetFormData)

        return {
            uomOptions,
            bomOptions,
            userOptions,
            workOrderType,
            salesTypeOptions,
            statusOptions,
            woStatusOptions,
            formData,
            modalTableData,
            searchData,
            getSalesOrderItemData,
            geItemMasterData,
            openModal,
            salesWorkOrderItemModal,
            itemMasterModal,
            selectSalesOrderItem,
            selectItemMasterItem,
            saveFormData,
            resetSalesModalData,
            resetItemMasterModalData,

            clearFormData,
            resetFormData,
            refFormObserver,
            getValidationState,
            resetForm,
            dateFormat,
            formatDates,
            required,
            getWoDeliveryFormateDate,
            getWoFormateDate,
            getWoSoFormateDate,
            getWoStartFormateDate,
            getWoPoFormateDate
        }
    }
}
</script>
