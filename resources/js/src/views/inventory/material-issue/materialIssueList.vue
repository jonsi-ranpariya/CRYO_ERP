<template>
    <div>
        <b-card-code>
            <validation-observer>
                <b-form>
                    <!-- Radio Button Area -->
                    <b-row>
                        <b-col md="3">
                            <div class="demo-inline-spacing">
                                <b-form-radio
                                    name="selectBatch"
                                    type="radio"
                                    value="1"
                                    v-model="formData.selectBatch"
                                >
                                    Against Work Order
                                </b-form-radio>
                            </div>
                        </b-col>
                        <b-col md="3">
                            <div class="demo-inline-spacing">
                                <b-form-radio
                                    name="selectBatch"
                                    type="radio"
                                    value="2"
                                    v-model="formData.selectBatch"
                                >
                                    Against Job Card
                                </b-form-radio>
                            </div>
                        </b-col>
                        <b-col md="3">
                            <div class="demo-inline-spacing">
                                <b-form-radio
                                    name="selectBatch"
                                    type="radio"
                                    value="3"
                                    v-model="formData.selectBatch"
                                >
                                    Against Item Requisition
                                </b-form-radio>
                            </div>
                        </b-col>
                        <b-col md="3">
                            <div class="demo-inline-spacing">
                                <b-form-radio
                                    name="selectBatch"
                                    type="radio"
                                    value="4"
                                    v-model="formData.selectBatch"
                                >
                                    Manual Material Issue
                                </b-form-radio>
                            </div>
                        </b-col>
                        <b-col md="12">
                            <b-button variant="primary" class="float-right" @click="openModal">...</b-button>
                        </b-col>
                    </b-row>
                    <hr>
                    <b-row>
                        <!-- Inputs Area -->
                        <b-col md="3">
                            <validation-provider
                                #default="validationContext"
                                name="Issue Slip No."
                                rules=""
                            >
                                <b-form-group
                                    label="Issue Slip No."
                                    label-for="issueSlipNo"
                                >
                                    <b-form-input
                                        v-model="formData.issueSlipNo"
                                        id="issueSlipNo"
                                        :state="getValidationState(validationContext)"
                                    />
                                </b-form-group>
                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </validation-provider>
                        </b-col>
                        <b-col md="3">
                            <validation-provider
                                #default="validationContext"
                                name="Issue Date"
                                rules=""
                            >
                                <b-form-group
                                    label="Issue Date"
                                    label-for="issueDate"
                                >
                                    <b-input-group>
                                        <cleave
                                            id="issueDate"
                                            v-model="formData.issueDate"
                                            class="form-control"
                                            :raw="false"
                                            :options="dateFormat"
                                            placeholder="DD/MM/YYYY"
                                            show-decade-nav
                                        />
                                        <b-input-group-append>
                                            <b-form-datepicker
                                                v-model="formatDates.issueDate"
                                                button-only
                                                @input="getMaterialIssueFormatDate($event)"
                                                show-decade-nav
                                                size="sm"
                                                nav-button-variant="primary"
                                            />
                                        </b-input-group-append>
                                    </b-input-group>
                                </b-form-group>
                            </validation-provider>
                        </b-col>
                        <b-col md="3">
                            <validation-provider
                                #default="validationContext"
                                name="Isssue Person By"
                                rules=""
                            >
                                <b-form-group
                                    label="Issue Person By"
                                    label-for="issuePersonBy"
                                >
                                    <b-form-input
                                        id="issuePersonBy"
                                        v-model="formData.issuePersonBy"
                                        :state="getValidationState(validationContext)"
                                    />
                                </b-form-group>
                            </validation-provider>
                        </b-col>
                        <b-col md="3">
                            <validation-provider
                                #default="validationContext"
                                name="Received Person By"
                                rules=""
                            >
                                <b-form-group
                                    label="Received Person By"
                                    label-for="receivedPersonBy"
                                >
                                    <b-form-input
                                        id="receivedPersonBy"
                                        v-model="formData.receivedPersonBy"
                                        :state="getValidationState(validationContext)"
                                    />
                                </b-form-group>
                            </validation-provider>
                        </b-col>
                        <b-col md="3">
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
                        <b-col md="3">
                            <b-form-group
                                label="Store"
                                label-for="itemStore"
                            >
                                <v-select
                                    :clearable="false"
                                    :dir=" $store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="storeOption"
                                    :reduce="(val) => val.value"
                                    input-id="itemStore"
                                    placeholder="Select Store"
                                    v-model="formData.itemStore"
                                />
                            </b-form-group>
                        </b-col>
                        <b-col md="3">
                            <validation-provider
                                #default="validationContext"
                                name="Issue Stock"
                                rules=""
                            >
                                <b-form-group
                                    label="Issue Stock"
                                    label-for="issueStock"
                                >
                                    <v-select
                                        placeholder="Select Issue Stock"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="issueStockOptions"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        input-id="issueStock"
                                        v-model="formData.issueStock"
                                        :state="getValidationState(validationContext)"
                                    />
                                </b-form-group>
                            </validation-provider>
                        </b-col>
                        <b-col md="3">
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
                                        v-model="formData.remark"
                                        id="remark"
                                        rows="2"
                                        :state="getValidationState(validationContext)"
                                    />
                                </b-form-group>
                            </validation-provider>
                        </b-col>

                        <!-- Buttons -->
                        <b-col md="12">
                            <hr>
                            <b-button
                                class="float-right"
                                variant="primary"
                                type="button"
                            >
                                Save
                            </b-button>
                            <b-button
                                class="float-right mr-1"
                                variant="primary"
                                type="button"
                            >
                                Preview Issue Slip
                            </b-button>
                        </b-col>
                    </b-row>
                </b-form>
            </validation-observer>
        </b-card-code>

        <!-- Models -->

        <!-- Start Job Card Models -->
        <b-modal
            id="againstJobCard"
            ref="againstJobCard"
            cancel-title="Cancel"
            cancel-variant="danger"
            hide-footer
            no-close-on-backdrop
            no-close-on-esc
            ok-title="Submit"
            scrollable
            size="xl"
            title="Against Job Card"
            @close="modalResetTableData"
        >
            <!-- Selection Area -->
            <b-row>
                <b-col md="3">
                    <b-form-group
                        label="Job Card"
                        label-for="jobCardId"
                    >
                        <v-select
                            :clearable="false"
                            :dir=" $store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                            :options="jobCardOptions"
                            :reduce="(val) => val.value"
                            input-id="jobCardId"
                            placeholder="Select Job Card"
                            @input="getJobCardItems($event)"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="3">
                    <b-form-group
                        label="Job Card Date"
                        label-for="jobCardDate"
                    >
                        <b-form-input
                            id="jobCardDate"
                            readonly
                            v-model="modalFormData.jobCardFormData.jobCardDate"
                            placeholder="DD/MM/YYYY"
                        />
                    </b-form-group>
                </b-col>
            </b-row>

            <!-- Table Area -->
            <b-row>
                <b-col md="12">
                    <b-table
                        :busy="modalTableIsBusy.jobCardIsBusy"
                        :fields="modalTables.jobCardItemFields"
                        :items="modalTables.jobCardItemData"
                        bordered
                        class="table_scroll"
                        hover
                        select-mode="single"
                        selectable
                        show-empty
                        @row-selected="onJobCardRowSelected"
                    >
                        <!-- Loader -->
                        <template #table-busy>
                            <div class="text-center my-2">
                                <b-spinner class="align-middle"></b-spinner>
                                <strong>Loading...</strong>
                            </div>
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

                        <!-- Index No -->
                        <template #cell(index)="data">
                            {{ data.index + 1 }}
                        </template>
                    </b-table>
                </b-col>
            </b-row>

            <!-- Form Area -->
            <b-row v-if="modalTables.jobCardItemData.length > 0">
                <b-col md="12">
                    <hr>
                    <b-row>
                        <b-col md="4">
                            <b-form-group
                                label="Item Description"
                                label-for="itemDescription"
                            >
                                <b-form-textarea
                                    row="1"
                                    readonly
                                    v-model="modalFormData.jobCardFormData.itemDescription"
                                />
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                label="Detail Description"
                                label-for="detailDescription"
                            >
                                <b-form-textarea
                                    row="1"
                                    readonly
                                    v-model="modalFormData.jobCardFormData.detailDescription"
                                />
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                label="Add Description"
                                label-for="addDescription"
                            >
                                <b-form-textarea
                                    row="1"
                                    readonly
                                    v-model="modalFormData.jobCardFormData.addDescription"
                                />
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                label="Drawing Number"
                                label-for="drawingNumber"
                            >
                                <b-form-input
                                    readonly
                                    v-model="modalFormData.jobCardFormData.drawingNumber"
                                />
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                label="Drawing Revision"
                                label-for="drawingRevision"
                            >
                                <b-form-input
                                    readonly
                                    v-model="modalFormData.jobCardFormData.drawingRevision"
                                />
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                label="Store"
                                label-for="store"
                            >
                                <b-form-input
                                    readonly
                                    v-model="modalFormData.jobCardFormData.store"
                                />
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                label="UOM"
                                label-for="uom"
                            >
                                <b-form-input
                                    readonly
                                    v-model="modalFormData.jobCardFormData.uom"
                                />
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                label="CFactor"
                                label-for="cFactor"
                            >
                                <b-form-input
                                    readonly
                                    v-model="modalFormData.jobCardFormData.cFactor"
                                />
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                label="Current Stock"
                                label-for="currentStock"
                            >
                                <b-form-input
                                    readonly
                                    v-model="modalFormData.jobCardFormData.currentStock"
                                />
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                label="Conv. UOM"
                                label-for="convUom"
                            >
                                <b-form-input
                                    readonly
                                    v-model="modalFormData.jobCardFormData.convUom"
                                />
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                label="Conv. Qty"
                                label-for="convQty"
                            >
                                <b-form-input
                                    readonly
                                    v-model="modalFormData.jobCardFormData.convQty"
                                />
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                label="Can Issue (Qty)"
                                label-for="canIssueQty"
                            >
                                <b-form-input
                                    type="number"
                                    v-model="modalFormData.jobCardFormData.canIssueQty"
                                />
                            </b-form-group>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col md="12">
                            <hr>
                            <b-button
                                variant="primary"
                                class="float-right"
                                type="button"
                                @click="submitJobCardIssueItem"
                            >
                                Save
                            </b-button>
                        </b-col>
                    </b-row>
                </b-col>
            </b-row>
        </b-modal>
        <!-- End Job Card Models -->

        <!-- Start Work Order Models -->
        <b-modal
            id="againstWorkOrder"
            ref="againstWorkOrder"
            hide-footer
            no-close-on-backdrop
            no-close-on-esc
            scrollable
            size="xl"
            title="Against Work Order"
            @close="modalResetTableData"
        >
            <!-- Selection Area -->
            <b-row>
                <b-col md="3">
                    <b-form-group
                        label="W.O.No"
                        label-for="woNumber"
                    >
                        <v-select
                            :clearable="false"
                            :dir=" $store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                            :options="workOrderOptions"
                            :reduce="(val) => val.value"
                            input-id="woNumber"
                            placeholder="Select Work Order"
                            @input="getWorkOrderItems($event)"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="3">
                    <b-form-group
                        label="W.O. Date"
                        label-for="woDate"
                    >
                        <b-form-input
                            placeholder="DD/MM/YYYY"
                            readonly
                            id="woDate"
                            v-model="workOrderModalForm.woDate"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="3">
                    <b-form-group
                        label="W.O. Quantity"
                        label-for="woQuantity"
                    >
                        <b-form-input
                            readonly
                            id="woQuantity"
                            v-model="workOrderModalForm.woQuantity"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="3">
                    <b-form-group
                        label="Quantity To Be Issue"
                        label-for="quantityToBeIssue"
                    >
                        <b-form-input
                            readonly
                            id="quantityToBeIssue"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="3">
                    <b-form-group
                        label="S.O. No."
                        label-for="soNumber"
                    >
                        <b-form-input
                            readonly
                            id="soNumber"
                            v-model="workOrderModalForm.soNumber"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="3">
                    <b-form-group
                        label="S.O. Date"
                        label-for="soDate"
                    >
                        <b-form-input
                            readonly
                            id="soDate"
                            v-model="workOrderModalForm.soDate"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="3">
                    <b-form-group
                        label="S.O. Quantity"
                        label-for="soQuantity"
                    >
                        <b-form-input
                            readonly
                            id="soQuantity"
                            v-model="workOrderModalForm.soQuantity"
                        />
                    </b-form-group>
                </b-col>
            </b-row>

            <!-- BreadCrumb/Table Area -->
            <b-row>
                <b-col md="12">
                    <!-- BreadCrumb Area -->
                    <hr>
                    <b-breadcrumb class="breadcrumb-chevron mb-0">
                        <b-breadcrumb-item
                            v-for="(item, key) in breadCumItems"
                            :key="key"
                            :active="item.active"
                            @click="getPreviousItems(item)"
                        >
                            <span v-if="item.assemblyCode">
                                {{ item.assemblyCode }}
                            </span>
                            <span v-else>
                                {{ item.itemCode }}
                            </span>
                        </b-breadcrumb-item>
                    </b-breadcrumb>
                    <hr>

                    <!-- Table Area -->
                    <b-table
                        :busy="modalTableIsBusy.workOrderIsBusy"
                        :fields="modalTables.workOrderItemFields"
                        :items="modalTables.workOrderItemData"
                        bordered
                        class="table_scroll"
                        hover
                        select-mode="single"
                        selectable
                        show-empty
                        @row-selected="onWorkOrderRowSelected"
                        responsive
                        ref="workOrderModalTable"
                    >
                        <!-- Loader -->
                        <template #table-busy>
                            <div class="text-center my-2">
                                <b-spinner class="align-middle"></b-spinner>
                                <strong>Loading...</strong>
                            </div>
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

                        <!-- Assembly Items Button -->
                        <template #cell(showChildItems)="data">
                            <b-button
                                v-if="data.item.itemType === 'A'"
                                variant="primary"
                                size="sm"
                                class="custom-control-primary"
                                @click="selectWoChildItems(data.item)"
                            >
                                Show
                            </b-button>
                        </template>
                    </b-table>
                </b-col>
            </b-row>

            <!-- Form Area -->
            <div v-if="modalTables.workOrderItemData.length > 0">
                <b-row>
                    <b-col md="12">
                        <hr>
                    </b-col>
                    <b-col md="4">
                        <b-form-group
                            label="Item Description"
                            label-for="woItemDescription"
                        >
                            <b-form-textarea
                                id="woItemDescription"
                                readonly
                                v-model="modalFormData.workOrderFormData.itemDescription"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="4">
                        <b-form-group
                            label="Detail Description"
                            label-for="woDetailDescription"
                        >
                            <b-form-textarea
                                id="woDetailDescription"
                                readonly
                                v-model="modalFormData.workOrderFormData.detailDescription"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="4">
                        <b-form-group
                            label="Add Description"
                            label-for="woAddDescription"
                        >
                            <b-form-textarea
                                id="woAddDescription"
                                readonly
                                v-model="modalFormData.workOrderFormData.addDescription"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="3">
                        <b-form-group
                            label="Drawing Number"
                            label-for="woDrawingNumber"
                        >
                            <b-form-input
                                id="woDrawingNumber"
                                readonly
                                v-model="modalFormData.workOrderFormData.drawingNumber"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="3">
                        <b-form-group
                            label="Drawing Revision"
                            label-for="woDrawingRevision"
                        >
                            <b-form-input
                                id="woDrawingRevision"
                                readonly
                                v-model="modalFormData.workOrderFormData.drawingRevision"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="3">
                        <b-form-group
                            label="Store"
                            label-for="woStore"
                        >
                            <b-form-input
                                id="woStore"
                                readonly
                                v-model="modalFormData.workOrderFormData.store"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="3">
                        <b-form-group
                            label="Current Stock"
                            label-for="woCurrentStock"
                        >
                            <b-form-input
                                id="woCurrentStock"
                                readonly
                                v-model="modalFormData.workOrderFormData.currentStock"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="3">
                        <b-form-group
                            label="UOM"
                            label-for="woUom"
                        >
                            <b-form-input
                                id="woUom"
                                readonly
                                v-model="modalFormData.workOrderFormData.uom"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="3">
                        <b-form-group
                            label="C-Factor"
                            label-for="woCFactor"
                        >
                            <b-form-input
                                id="woCFactor"
                                readonly
                                v-model="modalFormData.workOrderFormData.cFactor"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="3">
                        <b-form-group
                            label="Conv. UOM"
                            label-for="woConvUom"
                        >
                            <b-form-input
                                id="woConvUom"
                                readonly
                                v-model="modalFormData.workOrderFormData.convUom"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="3">
                        <b-form-group
                            label="Conv. Qty"
                            label-for="woConvQty"
                        >
                            <b-form-input
                                id="woConvQty"
                                readonly
                                v-model="modalFormData.workOrderFormData.convQty"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="3">
                        <b-form-group
                            label="Allocated Qty (Ind/PO)"
                            label-for="woAllocatedQty"
                        >
                            <b-form-input
                                id="woAllocatedQty"
                                v-model="modalFormData.workOrderFormData.allocatedQty"
                                readonly
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="3">
                        <b-form-group
                            label="Wo Allocate Qty"
                            label-for="woAllocateQty"
                        >
                            <b-form-input
                                id="woAllocateQty"
                                v-model="modalFormData.workOrderFormData.woAllocateQty"
                                readonly
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="3">
                        <b-form-group
                            label="Total Allocate Qty"
                            label-for="woTotalAllocateQty"
                        >
                            <b-form-input
                                id="woTotalAllocateQty"
                                v-model="modalFormData.workOrderFormData.totalAllocateQty"
                                readonly
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="3">
                        <b-form-group
                            label="Available Stock"
                            label-for="woAvailableStock"
                        >
                            <b-form-input
                                id="woAvailableStock"
                                v-model="modalFormData.workOrderFormData.availableStock"
                                readonly
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="3">
                        <b-form-group
                            label="Can Issue Qty"
                            label-for="woCanIssueQty"
                        >
                            <b-form-input
                                id="woCanIssueQty"
                                v-model="modalFormData.workOrderFormData.canIssueQty"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="12">
                        <hr>
                        <b-row>
                            <b-col md="12">
                                <b-button
                                    variant="primary"
                                    type="button"
                                    class="float-right"
                                    @click="submitWorkOrderIssueItem"
                                >
                                    Save
                                </b-button>
                            </b-col>
                        </b-row>
                    </b-col>
                </b-row>
            </div>

        </b-modal>
        <!-- End Work Order Models -->

        <!-- Start Item Requisition Models -->
        <b-modal
            id="againstItemRequisition"
            ref="againstItemRequisition"
            hide-footer
            no-close-on-backdrop
            no-close-on-esc
            scrollable
            size="xl"
            title="Item Requisition"
            @close="modalResetTableData"
        >
            <!-- Selection Area -->
            <b-row>
                <b-col md="3">
                    <b-form-group
                        label="Req. No."
                        label-for="modalReqNo"
                    >
                        <v-select
                            :clearable="false"
                            :dir=" $store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                            :options="itemRequisitionOptions"
                            :reduce="(val) => val.value"
                            input-id="modalReqNo"
                            placeholder="Select Item Requisition"
                            @input="getItemRequisitionItems($event)"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="3">
                    <b-form-group
                        label="Date"
                        label-for="modalDate"
                    >
                        <b-form-input
                            id="modalDate"
                            readonly
                            placeholder="DD/MM/YYYY"
                            v-model="modalItemRequisitionFormData.date"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="3">
                    <b-form-group
                        label="W.O. Quantity"
                        label-for="woQuantity"
                    >
                        <b-form-input
                            id="woQuantity"
                            v-model="modalItemRequisitionFormData.woQuantity"
                            readonly
                        />
                    </b-form-group>
                </b-col>
                <b-col md="3">
                    <b-form-group
                        label="S.O. Quantity"
                        label-for="soQuantity"
                    >
                        <b-form-input
                            id="soQuantity"
                            v-model="modalItemRequisitionFormData.soQuantity"
                            readonly
                        />
                    </b-form-group>
                </b-col>
                <b-col md="3">
                    <b-form-group
                        label="W.O. No."
                        label-for="woNumber"
                    >
                        <b-form-input
                            id="woNumber"
                            v-model="modalItemRequisitionFormData.woNumber"
                            readonly
                        />
                    </b-form-group>
                </b-col>
                <b-col md="3">
                    <b-form-group
                        label="W.O. Date"
                        label-for="woDate"
                    >
                        <b-form-input
                            id="woDate"
                            v-model="modalItemRequisitionFormData.woDate"
                            readonly
                        />
                    </b-form-group>
                </b-col>
                <b-col md="3">
                    <b-form-group
                        label="S.O. No."
                        label-for="soNumber"
                    >
                        <b-form-input
                            id="soNumber"
                            v-model="modalItemRequisitionFormData.soNumber"
                            readonly
                        />
                    </b-form-group>
                </b-col>
                <b-col md="3">
                    <b-form-group
                        label="S.O. Date"
                        label-for="soDate"
                    >
                        <b-form-input
                            id="soDate"
                            v-model="modalItemRequisitionFormData.soDate"
                            readonly
                        />
                    </b-form-group>
                </b-col>
            </b-row>

            <!-- Table Area -->
            <b-row>
                <b-col md="12">
                    <b-table
                        :busy="modalTableIsBusy.itemRequisitionIsBusy"
                        :fields="modalTables.itemRequisitionItemFields"
                        :items="modalTables.itemRequisitionItemData"
                        bordered
                        class="table_scroll"
                        hover
                        select-mode="single"
                        selectable
                        show-empty
                        @row-selected="onRequisitionRowSelected"
                        responsive
                    >
                        <!-- Loader -->
                        <template #table-busy>
                            <div class="text-center my-2">
                                <b-spinner class="align-middle"></b-spinner>
                                <strong>Loading...</strong>
                            </div>
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
                </b-col>
            </b-row>

            <!-- Form Area -->
            <b-row v-if="modalTables.itemRequisitionItemData.length > 0">
                <b-col md="12">
                    <hr>
                </b-col>
                <b-col md="4">
                    <b-form-group
                        label="Item Description"
                        label-for="requisitionItemDescription"
                    >
                        <b-form-textarea
                            id="requisitionItemDescription"
                            rows="1"
                            v-model="modalFormData.requisitionFormData.itemDescription"
                            readonly
                        />
                    </b-form-group>
                </b-col>
                <b-col md="4">
                    <b-form-group
                        label="Detail Description"
                        label-for="requisitionDetailDescription"
                    >
                        <b-form-textarea
                            id="requisitionDetailDescription"
                            v-model="modalFormData.requisitionFormData.detailDescription"
                            rows="1"
                            readonly
                        />
                    </b-form-group>
                </b-col>
                <b-col md="4">
                    <b-form-group
                        label="Add. Description"
                        label-for="requisitionAddDescription"
                    >
                        <b-form-textarea
                            id="requisitionAddDescription"
                            rows="1"
                            v-model="modalFormData.requisitionFormData.addDescription"
                            readonly
                        />
                    </b-form-group>
                </b-col>
                <b-col md="3">
                    <b-form-group
                        label="Drawing Number"
                        label-for="requisitionDrawingNumber"
                    >
                        <b-form-input
                            id="requisitionDrawingNumber"
                            readonly
                            v-model="modalFormData.requisitionFormData.drawingNumber"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="3">
                    <b-form-group
                        label="Drawing Revision"
                        label-for="requisitionDrawingRevision"
                    >
                        <b-form-input
                            id="requisitionDrawingRevision"
                            readonly
                            v-model="modalFormData.requisitionFormData.drawingRevision"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="3">
                    <b-form-group
                        label="Current Stock"
                        label-for="requisitionCurrentStock"
                    >
                        <b-form-input
                            id="requisitionCurrentStock"
                            v-model="modalFormData.requisitionFormData.currentStock"
                            readonly
                        />
                    </b-form-group>
                </b-col>
                <b-col md="3">
                    <b-form-group
                        label="Store"
                        label-for="requisitionStore"
                    >
                        <b-form-input
                            id="requisitionStore"
                            v-model="modalFormData.requisitionFormData.store"
                            readonly
                        />
                    </b-form-group>
                </b-col>
                <b-col md="3">
                    <b-form-group
                        label="UOM"
                        label-for="requisitionUom"
                    >
                        <b-form-input
                            id="requisitionUom"
                            v-model="modalFormData.requisitionFormData.uom"
                            readonly
                        />
                    </b-form-group>
                </b-col>
                <b-col md="3">
                    <b-form-group
                        label="C-Factor"
                        label-for="requisitionCFactor"
                    >
                        <b-form-input
                            id="requisitionCFactor"
                            v-model="modalFormData.requisitionFormData.cFactor"
                            readonly
                        />
                    </b-form-group>
                </b-col>
                <b-col md="3">
                    <b-form-group
                        label="Conv. UOM"
                        label-for="requisitionConvUom"
                    >
                        <b-form-input
                            id="requisitionConvUom"
                            v-model="modalFormData.requisitionFormData.convUom"
                            readonly
                        />
                    </b-form-group>
                </b-col>
                <b-col md="3">
                    <b-form-group
                        label="Conv. Qty"
                        label-for="requisitionConvQty"
                    >
                        <b-form-input
                            id="requisitionConvQty"
                            v-model="modalFormData.requisitionFormData.convQty"
                            readonly
                        />
                    </b-form-group>
                </b-col>
                <b-col md="3">
                    <b-form-group
                        label="Can Issue (Qty)"
                        label-for="requisitionCanIssueQty"
                    >
                        <b-form-input
                            id="requisitionCanIssueQty"
                            v-model="modalFormData.requisitionFormData.canIssueQty"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="12">
                    <hr>
                    <b-button
                        variant="primary"
                        type="button"
                        class="float-right"
                        @click.prevent="submitRequisitionForm"
                    >
                        Save
                    </b-button>
                </b-col>
            </b-row>
        </b-modal>
        <!-- End Item Requisition Models -->

        <!-- Start Manual Material Issue Model-->
        <b-modal
            id="manualMaterialIssue"
            ref="manualMaterialIssue"
            hide-footer
            no-close-on-backdrop
            no-close-on-esc
            scrollable
            size="xl"
            title="Manual Material Issue"
            @close="modalResetTableData"
        >
            <!-- Table Area -->
            <b-row>
                <b-col md="12">
                    <b-table
                        :busy="modalTableIsBusy.manualIssueIsBusy"
                        :fields="modalTables.manualMaterialIssueFields"
                        :items="modalTables.manualMaterialIssueData"
                        bordered
                        class="table_scroll"
                        hover
                        select-mode="single"
                        selectable
                        show-empty
                        @row-selected="onManualIssueSelected"
                        responsive
                        ref="manualMaterialIssueTable"
                    >
                        <!-- Loader -->
                        <template #table-busy>
                            <div class="text-center my-2">
                                <b-spinner class="align-middle"></b-spinner>
                                <strong>Loading...</strong>
                            </div>
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
                    <hr>
                </b-col>
            </b-row>

            <!-- Form Area -->
            <b-row>
                <b-col md="4">
                    <b-form-group
                        label="Item Code"
                        label-for="manualItemCode"
                    >
                        <v-select
                            placeholder="Select Item"
                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                            :options="itemMasterOptions"
                            :clearable="false"
                            input-id="itemCode"
                            :reduce="val => val.value"
                            @input="getItemMasterDetails($event)"
                            v-model="manualMaterialFormData.itemId"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="4">
                    <b-form-group
                        label="Item Description"
                        label-for="manualItemDescription"
                    >
                        <b-form-textarea
                            id="manualItemDescription"
                            rows="1"
                            v-model="manualMaterialFormData.itemDescription"
                            readonly
                        />
                    </b-form-group>
                </b-col>
                <b-col md="4">
                    <b-form-group
                        label="Detail Description"
                        label-for="manualDetailDescription"
                    >
                        <b-form-textarea
                            id="manualDetailDescription"
                            rows="1"
                            v-model="manualMaterialFormData.detailDescription"
                            readonly
                        />
                    </b-form-group>
                </b-col>
                <b-col md="4">
                    <b-form-group
                        label="Add. Description"
                        label-for="manualAddDescription"
                    >
                        <b-form-input
                            id="manualAddDescription"
                            v-model="manualMaterialFormData.addDescription"
                            readonly
                        />
                    </b-form-group>
                </b-col>
                <b-col md="4">
                    <b-form-group
                        label="Drawing Number"
                        label-for="manualDrawingNumber"
                    >
                        <b-form-input
                            id="manualDrawingNumber"
                            v-model="manualMaterialFormData.drawingNumber"
                            readonly
                        />
                    </b-form-group>
                </b-col>
                <b-col md="4">
                    <b-form-group
                        label="Drawing Rev"
                        label-for="manualDrawingRev"
                    >
                        <b-form-input
                            id="manualDrawingRev"
                            v-model="manualMaterialFormData.drawingRev"
                            readonly
                        />
                    </b-form-group>
                </b-col>
                <b-col md="4">
                    <b-form-group
                        label="UOM"
                        label-for="manualUom"
                    >
                        <b-form-input
                            id="manualUom"
                            v-model="manualMaterialFormData.uom"
                            readonly
                        />
                    </b-form-group>
                </b-col>
                <b-col md="4">
                    <b-form-group
                        label="Current Stock"
                        label-for="manualCurrentStock"
                    >
                        <b-form-input
                            id="manualCurrentStock"
                            v-model="manualMaterialFormData.currentStock"
                            readonly
                        />
                    </b-form-group>
                </b-col>
                <b-col md="4">
                    <b-form-group
                        label="Allocated Qty"
                        label-for="manualAllocatedQty"
                    >
                        <b-form-input
                            id="manualAllocatedQty"
                            v-model="manualMaterialFormData.allocatedQty"
                            readonly
                        />
                    </b-form-group>
                </b-col>
                <b-col md="4">
                    <b-form-group
                        label="Item Make"
                        label-for="manualItemMake"
                    >
                        <b-form-input
                            id="manualItemMake"
                            v-model="manualMaterialFormData.make"
                            readonly
                        />
                    </b-form-group>
                </b-col>
                <b-col md="4">
                    <b-form-group
                        label="Store"
                        label-for="manualStore"
                    >
                        <b-form-input
                            id="manualStore"
                            v-model="manualMaterialFormData.store"
                            readonly
                        />
                    </b-form-group>
                </b-col>
                <b-col md="4">
                    <b-form-group
                        label="Department"
                        label-for="manualDepartment"
                    >
                        <b-form-input
                            id="manualDepartment"
                            v-model="manualMaterialFormData.department"
                            readonly
                        />
                    </b-form-group>
                </b-col>
                <b-col md="4">
                    <b-form-group
                        label="Can Issue Qty"
                        label-for="manualCanIssueQty"
                    >
                        <b-form-input
                            id="manualCanIssueQty"
                            v-model="manualMaterialFormData.canIssueQty"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="4">
                    <b-form-group
                        label="W.O.No."
                        label-for="manualWorkOrder"
                    >
                        <v-select
                            placeholder="Select Work Order"
                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                            :options="manualWorkOrderOptions"
                            :clearable="true"
                            input-id="manualWorkOrder"
                            :reduce="val => val.value"
                            v-model="manualMaterialFormData.woNumber"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="12">
                    <hr>
                    <b-button
                        variant="primary"
                        type="button"
                        class="float-right"
                        @click="submitManualForm"
                    >
                        Save
                    </b-button>
                    <b-button
                        variant="danger"
                        type="button"
                        class="float-right mr-1"
                        @click="deleteMaterialIssueSubmit"
                    >
                        Delete Item
                    </b-button>
                    <b-button
                        variant="success"
                        type="button"
                        class="float-right mr-1"
                        @click="manualMaterialIssueSubmit"
                    >
                        Material Issue
                    </b-button>
                </b-col>
            </b-row>
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
    BFormRadio,
    BButton,
    BFormInvalidFeedback,
    BInputGroup,
    BInputGroupAppend,
    BFormDatepicker,
    BFormTextarea,
    BTable,
    BSpinner,
    BBreadcrumb,
    BBreadcrumbItem
} from 'bootstrap-vue'
import BCardCode from '@core/components/b-card-code/BCardCode'
import { ValidationObserver, ValidationProvider } from 'vee-validate'
import { ref } from '@vue/composition-api'
import formValidation from '@core/comp-functions/forms/form-validation'
import { forMatIndianDate, getTcTodayDate } from '@core/utils/utils'
import Cleave from 'vue-cleave-component'
import vSelect from 'vue-select'
import axios from '@axios'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
import { useToast } from 'vue-toastification/composition'

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
        BFormRadio,
        BButton,
        BFormInvalidFeedback,
        BInputGroup,
        Cleave,
        BInputGroupAppend,
        BFormDatepicker,
        vSelect,
        BFormTextarea,
        BTable,
        BSpinner,
        BBreadcrumb,
        BBreadcrumbItem
    },
    setup({
        againstJobCard,
        againstWorkOrder,
        workOrderModalTable,
        againstItemRequisition,
        manualMaterialIssue,
        manualMaterialIssueTable
    }) {
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

        const issueStockOptions = ref([
            {
                label: 'General',
                value: 1
            }
        ])

        const dateFormat = ref({
            date: true,
            delimiter: '/',
            datePattern: ['d', 'm', 'Y'],
        })

        const toast = useToast()

        // Modals
        againstJobCard = ref()
        againstWorkOrder = ref()
        workOrderModalTable = ref()
        againstItemRequisition = ref()
        manualMaterialIssue = ref()
        manualMaterialIssueTable = ref()

        const formatDates = ref({
            issueDate: null,
        })

        const getMaterialIssueFormatDate = (date) => {
            formData.value.issueDate = forMatIndianDate(date)
        }

        const blankFormData = {
            selectBatch: null,
            issueSlipNo: null,
            issueDate: forMatIndianDate(),
            issuePersonBy: null,
            receivedPersonBy: null,
            issueStock: null,
        }

        const formData = ref(JSON.parse(JSON.stringify(blankFormData)))

        const resetFormData = () => {
            formData.value = JSON.parse(JSON.stringify(blankFormData))
        }

        const modalTables = ref({
            jobCardItemFields: [
                {
                    key: 'rowSelected',
                    label: ''
                },
                {
                    key: 'index',
                    label: 'SR No.'
                },
                {
                    key: 'item_name.itemCode',
                    label: 'Item Code'
                },
                {
                    key: 'issueItemDescription',
                    label: 'Item Description'
                },
                {
                    key: 'issueItemDrawingNo',
                    label: 'Drawing No.'
                },
                {
                    key: 'issueItemPendingQty',
                    label: 'Pending Qty'
                },
                {
                    key: 'issueCurrentStock',
                    label: 'Current Stock'
                },
                {
                    key: 'issueRequiredQty',
                    label: 'Required Qty'
                },
            ],
            jobCardItemData: [],
            workOrderItemFields: [
                {
                    key: 'showChildItems',
                    label: ''
                },
                {
                    key: 'rowSelected',
                    label: ''
                },
                {
                    key: 'wo_details.assemblyCode',
                    label: 'Assembly'
                },
                {
                    key: 'item_name.itemCode',
                    label: 'BOMItem'
                },
                {
                    key: 'itemType',
                    label: 'type'
                },
                {
                    key: 'itemDescription',
                    label: 'Description'
                },
                {
                    key: 'itemDrawingNumber',
                    label: 'Drg No.'
                },
                {
                    key: 'itemBomQty',
                    label: 'BOM Qty.'
                },
                {
                    key: 'itemReqQty',
                    label: 'Req Qty.'
                },
                {
                    key: 'itemIssueQty',
                    label: 'Issue Qty.'
                },
                {
                    key: 'itemPendingQty',
                    label: 'Pending Qty.'
                },
                {
                    key: 'itemCurrentStock',
                    label: 'Current Stock'
                },
                {
                    key: 'iQty',
                    label: 'I Qty.'
                }
            ],
            workOrderItemData: [],
            itemRequisitionItemFields: [
                {
                    label: '',
                    key: 'rowSelected'
                },
                {
                    label: 'Assembly',
                    key: 'item_name.itemCode'
                },
                {
                    label: 'Description',
                    key: 'itemDescription'
                },
                {
                    label: 'Drg No.',
                    key: 'itemDrawingNumber'
                },
                {
                    label: 'Pending Qty.',
                    key: 'itemPendingQty'
                },
                {
                    label: 'Current Stock',
                    key: 'itemCurrentStock'
                },
                {
                    label: 'IQty',
                    key: 'issueQty'
                }
            ],
            itemRequisitionItemData: [],
            manualMaterialIssueFields: [
                {
                    label: '',
                    key: 'rowSelected'
                },
                {
                    label: 'Item Code',
                    key: 'itemCode'
                },
                {
                    label: 'Item Description',
                    key: 'itemDescription'
                },
                {
                    label: 'UOM',
                    key: 'uom'
                },
                {
                    label: 'Quantity',
                    key: 'itemQty'
                },
                {
                    label: 'Drg No.',
                    key: 'drawingNumber'
                },
                {
                    label: 'Rev.',
                    key: 'drawingRev'
                },
                {
                    label: 'Current Stock',
                    key: 'currentStock'
                },
                {
                    label: 'Make',
                    key: 'make'
                },
                {
                    label: 'Store',
                    key: 'store'
                },
            ],
            manualMaterialIssueData: []
        })

        const modalResetTableData = () => {
            modalTables.value.jobCardItemData = []
            modalTables.value.workOrderItemData = []
            modalTables.value.itemRequisitionItemData = []
            modalTables.value.manualMaterialIssueData = []
        }

        const modalTableIsBusy = ref({
            jobCardIsBusy: false,
            workOrderIsBusy: false,
            itemRequisitionIsBusy: false,
            manualIssueIsBusy: false
        })

        const openModal = async () => {
            switch (formData.value.selectBatch) {
                case '1':
                    return await againstWorkOrderModal()
                case '2':
                    return await againstJobCardModal()
                case '3':
                    return await againstItemRequisitionModal()
                case '4':
                    return await manualMaterialIssueModal()
                default:
                    return null
            }
        }

        const jobCardOptions = ref([])

        const workOrderOptions = ref([])

        const breadCumItems = ref([])

        const itemRequisitionOptions = ref([])

        const blankModalFormData = {
            jobCardFormData: {
                jobCardDate: null,
                showIssueItemId: null,
                jobId: null,
                itemId: null,
                itemDescription: null,
                detailDescription: null,
                addDescription: null,
                drawingNumber: null,
                drawingRevision: null,
                store: null,
                uom: null,
                cFactor: null,
                currentStock: null,
                convUom: null,
                convQty: null,
                canIssueQty: null,
            },
            workOrderFormData: {
                workOrderId: null,
                workOrderItemId: null,
                itemDescription: null,
                detailDescription: null,
                addDescription: null,
                drawingNumber: null,
                drawingRevision: null,
                store: null,
                currentStock: null,
                uom: null,
                cFactor: null,
                convUom: null,
                convQty: null,
                allocatedQty: null,
                woAllocateQty: null,
                totalAllocateQty: null,
                availableStock: null,
                canIssueQty: null,
            },
            requisitionFormData: {
                requisitionItemId: null,
                itemDescription: null,
                detailDescription: null,
                addDescription: null,
                drawingNumber: null,
                drawingRevision: null,
                currentStock: null,
                store: null,
                uom: null,
                cFactor: null,
                convUom: null,
                convQty: null,
                canIssueQty: null
            }
        }

        const modalFormData = ref(JSON.parse(JSON.stringify(blankModalFormData)))

        const resetModalFormData = () => {
            workOrderModalTable.value.clearSelected()
            modalFormData.value = JSON.parse(JSON.stringify(blankModalFormData))
        }

        const againstJobCardModal = async () => {
            await axios.get('/api/get-job-card-options')
                .then((res) => {
                    jobCardOptions.value = res.data
                })
            await againstJobCard.value.show()
        }

        const getJobCardItems = async (id) => {
            modalTableIsBusy.value.jobCardIsBusy = true
            await axios.get(`/api/job-cards/${id}`)
                .then((res) => {
                    modalFormData.value.jobCardFormData.jobCardDate = res.data.data.jobCardDate
                })
            await axios.get(`/api/new/get-show-issue-item/${id}`)
                .then((res) => {
                    modalTables.value.jobCardItemData = res.data.data
                })
            modalTableIsBusy.value.jobCardIsBusy = false
        }

        const onJobCardRowSelected = (items) => {
            if (items.length > 0) {
                modalFormData.value.jobCardFormData.showIssueItemId = items[0]._id
                modalFormData.value.jobCardFormData.jobId = items[0].jobId
                modalFormData.value.jobCardFormData.itemId = items[0].itemId
                modalFormData.value.jobCardFormData.itemDescription = items[0].issueItemDescription
                modalFormData.value.jobCardFormData.addDescription = items[0].issueItemAddDescription
                modalFormData.value.jobCardFormData.detailDescription = items[0].issueItemDetailDescription
                modalFormData.value.jobCardFormData.drawingNumber = items[0].issueItemDrawingNo
                modalFormData.value.jobCardFormData.drawingRevision = items[0].issueItemRevision
                modalFormData.value.jobCardFormData.uom = items[0]?.uom_detail?.uom
                modalFormData.value.jobCardFormData.cFactor = items[0].issueItemConvFactor
                modalFormData.value.jobCardFormData.convUom = items[0]?.conv_uom_detail?.uom
                modalFormData.value.jobCardFormData.convQty = items[0].issueItemConvQty
                modalFormData.value.jobCardFormData.currentStock = items[0].issueCurrentStock
                modalFormData.value.jobCardFormData.canIssueQty = 0
            } else {
                resetModalFormData()
            }
        }

        const submitJobCardIssueItem = async () => {
            let formData = {
                showIssueItemId: modalFormData.value.jobCardFormData.showIssueItemId,
                canIssueQty: parseFloat(modalFormData.value.jobCardFormData.canIssueQty),
                jobCardId: modalFormData.value.jobCardFormData.jobId,
                itemMasterId: modalFormData.value.jobCardFormData.itemId
            }
            if (formData.showIssueItemId) {
                await axios.post('/api/new/issue-quantity-for-job-card', formData)
                    .then(() => {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Material Issued.',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: `You have successfully Issued the material.`,
                            },
                        })
                        modalResetTableData()
                        resetModalFormData()
                        againstJobCard.value.hide()
                    })
                    .catch((error) => {
                        let response = error.response
                        if (response.data && response.status === 422) {
                            let data = response.data
                            if (data) {
                                toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: data.message,
                                        icon: 'AlertCircleIcon',
                                        variant: 'danger',
                                        text: data.errors.canIssueQty[0]
                                    },
                                })
                            }
                        } else {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Error',
                                    icon: 'AlertCircleIcon',
                                    variant: 'danger',
                                    text: 'Internal server error.'
                                },
                            })
                        }
                    })
            } else {
                toast({
                    component: ToastificationContent,
                    position: 'top-right',
                    props: {
                        title: 'Warning',
                        icon: 'AlertCircleIcon',
                        variant: 'warning',
                        text: 'Please select any item'
                    },
                })
            }
        }

        const blankWorkOrderModalForm = {
            woDate: null,
            soNumber: null,
            soDate: null,
            woQuantity: null,
            soQuantity: null,
        }

        const workOrderModalForm = ref(JSON.parse(JSON.stringify(blankWorkOrderModalForm)))

        const resetWorkOrderModalForm = () => {
            workOrderModalForm.value = JSON.parse(JSON.stringify(blankWorkOrderModalForm))
        }

        const againstWorkOrderModal = async () => {
            await axios.get('/api/get-work-order-option')
                .then((res) => {
                    workOrderOptions.value = res.data.data
                })
            await againstWorkOrder.value.show()
        }

        const getWorkOrderItems = async (id) => {
            modalTableIsBusy.value.workOrderIsBusy = true
            breadCumItems.value = []
            await axios.get(`/api/get-pending-work-order-assembly-items/${id}`)
                .then((res) => {
                    modalTables.value.workOrderItemData = res.data.data
                })
            await axios.get(`/api/work-orders/${id}`)
                .then((res) => {
                    workOrderModalForm.value.woDate = res.data.data.woDate
                    workOrderModalForm.value.soDate = res.data.data.soDate
                    workOrderModalForm.value.soNumber = res.data.data.soNumber
                    workOrderModalForm.value.woQuantity = res.data.data.woQty
                    workOrderModalForm.value.soQuantity = res.data.data.woQty
                    breadCumItems.value.push({
                        id: id,
                        assemblyCode: res.data.data.assemblyCode
                    })
                })
            modalTableIsBusy.value.workOrderIsBusy = false
        }

        const onWorkOrderRowSelected = (items) => {
            if (items.length > 0) {
                modalFormData.value.workOrderFormData.workOrderId = items[0].woId
                modalFormData.value.workOrderFormData.workOrderItemId = items[0]._id
                modalFormData.value.workOrderFormData.itemDescription = items[0].itemDescription
                modalFormData.value.workOrderFormData.detailDescription = items[0].itemDetailDescription
                modalFormData.value.workOrderFormData.addDescription = items[0].itemAddDescription
                modalFormData.value.workOrderFormData.drawingNumber = items[0].itemDrawingNumber
                modalFormData.value.workOrderFormData.drawingRevision = items[0].itemRevision
                modalFormData.value.workOrderFormData.store = items[0].itemStore
                modalFormData.value.workOrderFormData.uom = items[0]?.uom_detail?.uom ?? items[0].itemUom
                modalFormData.value.workOrderFormData.cFactor = items[0].itemConvFactor
                modalFormData.value.workOrderFormData.convUom = items[0]?.conv_uom_detail?.uom ?? null
                modalFormData.value.workOrderFormData.convQty = items[0].itemConvQty
            } else {
                resetModalFormData()
            }
        }

        const getPreviousItems = async (item) => {
            modalTableIsBusy.value.workOrderIsBusy = true
            let items = breadCumItems.value
            if (item.assemblyCode) {
                breadCumItems.value = []
                breadCumItems.value.push({
                    id: item.id,
                    assemblyCode: item.assemblyCode
                })
                await axios.get(`/api/get-pending-work-order-assembly-items/${item.id}`)
                    .then(res => {
                        modalTables.value.workOrderItemData = res.data.data
                    })
            } else {
                let newItemList = []
                items.every(value => {
                    if (value.itemCode !== item.itemCode) {
                        newItemList.push(value)
                        return true
                    } else {
                        newItemList.push(value)
                        return false
                    }
                })
                breadCumItems.value = newItemList
                await axios.get(`/api/get-pending-work-order-assembly-items-child/${item.id}`)
                    .then((res) => {
                        modalTables.value.workOrderItemData = res.data.data
                    })
            }
            modalTableIsBusy.value.workOrderIsBusy = false
        }

        const selectWoChildItems = async (data) => {
            breadCumItems.value.push({
                id: data._id,
                itemCode: data.item_name.itemCode
            })
            await axios.get(`/api/get-pending-work-order-assembly-items-child/${data._id}`)
                .then((res) => {
                    modalTables.value.workOrderItemData = res.data.data
                })
        }

        const submitWorkOrderIssueItem = async () => {
            let formData = {
                workOrderId: modalFormData.value.workOrderFormData.workOrderId,
                workOrderItemId: modalFormData.value.workOrderFormData.workOrderItemId,
                canIssueQty: parseFloat(modalFormData.value.workOrderFormData.canIssueQty)
            }

            await axios.post('/api/material-issue-work-order-item', formData)
                .then(() => {
                    toast({
                        component: ToastificationContent,
                        position: 'top-right',
                        props: {
                            title: 'Material Issued.',
                            icon: 'CheckSquareIcon',
                            variant: 'success',
                            text: `You have successfully Issued the material.`,
                        },
                    })
                    getWorkOrderItems(formData.workOrderId)
                    resetModalFormData()
                })
                .catch((error) => {
                    let response = error.response
                    if (response.data && response.status === 422) {
                        let data = response.data
                        if (data) {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: data.message,
                                    icon: 'AlertCircleIcon',
                                    variant: 'danger',
                                    text: data.errors.canIssueQty[0]
                                },
                            })
                        }
                    } else if (response.status === 400) {
                        let data = response.data
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: data.message,
                                icon: 'AlertCircleIcon',
                                variant: 'warning'
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
                                text: 'Internal server error.'
                            },
                        })
                    }
                })
        }

        const blankModalItemRequisitionFormData = {
            date: getTcTodayDate(),
            woQuantity: null,
            soQuantity: null,
            woNumber: null,
            woDate: null,
            soNumber: null,
            soDate: null
        }

        const modalItemRequisitionFormData = ref(JSON.parse(JSON.stringify(blankModalItemRequisitionFormData)))

        const resetModalItemRequisitionFormData = () => {
            modalItemRequisitionFormData.value = JSON.parse(JSON.stringify(blankModalItemRequisitionFormData))
        }

        const againstItemRequisitionModal = async () => {
            await axios.get('/api/get-item-requisition-options')
                .then((res) => {
                    itemRequisitionOptions.value = res.data
                })
            await againstItemRequisition.value.show()
        }

        const getItemRequisitionItems = async (id) => {
            modalTableIsBusy.value.itemRequisitionIsBusy = true
            await axios.get(`/api/get-wo-requisition-items/${id}`)
                .then((res) => {
                    modalTables.value.itemRequisitionItemData = res.data.data
                })
            await axios.get(`/api/get-item-requisition-details/${id}`)
                .then((res) => {
                    modalItemRequisitionFormData.value.woQuantity = res.data.data?.work_order_details?.woQty
                })
            modalTableIsBusy.value.itemRequisitionIsBusy = false
        }

        const onRequisitionRowSelected = (items) => {
            if (items.length > 0) {
                modalFormData.value.requisitionFormData.requisitionItemId = items[0]._id
                modalFormData.value.requisitionFormData.itemDescription = items[0].itemDescription
                modalFormData.value.requisitionFormData.detailDescription = items[0].itemDetailDescription
                modalFormData.value.requisitionFormData.addDescription = items[0].itemAddDescription
                modalFormData.value.requisitionFormData.drawingNumber = items[0].itemDrawingNumber
                modalFormData.value.requisitionFormData.drawingRevision = items[0].itemDrawingRevision
                modalFormData.value.requisitionFormData.currentStock = items[0].itemCurrentStock
                modalFormData.value.requisitionFormData.store = null
                modalFormData.value.requisitionFormData.uom = items[0].itemUom
                modalFormData.value.requisitionFormData.cFactor = items[0].itemCfactor
                modalFormData.value.requisitionFormData.convUom = items[0]?.conv_uom_details?.uom ?? null
                modalFormData.value.requisitionFormData.convQty = items[0].itemConvQty
            } else {
                resetModalFormData()
            }
        }

        const submitRequisitionForm = async () => {
            let formData = {
                requisitionItemId: modalFormData.value.requisitionFormData.requisitionItemId,
                canIssueQty: modalFormData.value.requisitionFormData.canIssueQty
            }
            if (formData.requisitionItemId) {
                await axios.post('/api/material-issue-on-requisition-item', formData)
                    .then((res) => {
                        console.log(res.data)
                    })
                    .catch((error) => {
                        let response = error.response
                        if (response.data && response.status === 422) {
                            let data = response.data
                            if (data) {
                                toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: data.message,
                                        icon: 'AlertCircleIcon',
                                        variant: 'warning',
                                        text: data.errors.canIssueQty[0]
                                    },
                                })
                            }
                        } else {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Error',
                                    icon: 'AlertCircleIcon',
                                    variant: 'danger',
                                    text: 'Internal server error.'
                                },
                            })
                        }
                    })
            } else {
                toast({
                    component: ToastificationContent,
                    position: 'top-right',
                    props: {
                        title: 'The given data was invalid.',
                        icon: 'AlertCircleIcon',
                        variant: 'warning',
                        text: 'Please select any item first.'
                    },
                })
            }
        }

        // Manual Material Issue
        const itemMasterOptions = ref([])
        axios.get('/api/get-item-master-options')
            .then(res => {
                itemMasterOptions.value = res.data.data
            })

        const manualWorkOrderOptions = ref([])
        axios.get('/api/get-work-order-option')
            .then(res => {
                manualWorkOrderOptions.value = res.data.data
            })

        const manualMaterialIssueModal = async () => {
            modalTableIsBusy.value.manualIssueIsBusy = true
            await manualMaterialIssue.value.show()
            modalTableIsBusy.value.manualIssueIsBusy = false
        }

        const blankManualMaterialIssueForm = {
            itemId: null,
            itemCode: null,
            itemDescription: null,
            detailDescription: null,
            addDescription: null,
            drawingNumber: null,
            drawingRev: null,
            uomId: null,
            uom: null,
            currentStock: null,
            allocatedQty: null,
            make: null,
            store: null,
            department: null,
            canIssueQty: null,
            woNumber: null,
        }

        const manualMaterialFormData = ref(JSON.parse(JSON.stringify(blankManualMaterialIssueForm)))

        const resetManualMaterialFormData = () => {
            manualMaterialFormData.value = JSON.parse(JSON.stringify(blankManualMaterialIssueForm))
            manualMaterialIssueTable.value.clearSelected()
        }

        const getItemMasterDetails = async (id) => {
            await axios.get(`/api/item-master/${id}`)
                .then(res => {
                    manualMaterialFormData.value.itemCode = res.data.data.itemCode
                    manualMaterialFormData.value.itemDescription = res.data.data.itemDescription
                    manualMaterialFormData.value.detailDescription = res.data.data?.itemDetails?.detailDescription ?? null
                    manualMaterialFormData.value.addDescription = res.data.data?.itemDetails?.description ?? null
                    manualMaterialFormData.value.drawingNumber = res.data.data?.itemDetails?.drawingNumber ?? null
                    manualMaterialFormData.value.drawingRev = res.data.data?.itemDetails?.revision ?? null
                    manualMaterialFormData.value.uomId = res.data.data.uom ?? null
                    manualMaterialFormData.value.uom = res.data.data?.uom_details?.uom ?? null
                    manualMaterialFormData.value.currentStock = null
                    manualMaterialFormData.value.allocatedQty = null
                    manualMaterialFormData.value.make = res.data.data.make
                    manualMaterialFormData.value.store = null
                    manualMaterialFormData.value.department = null
                })
            await axios.get(`/api/new/check-stock-transaction-details/${id}`)
                .then((res) => {
                    console.log(res.data)
                })
                .then((error) => {
                    console.log(error.response)
                })
        }

        const submitManualForm = async () => {
            let found = modalTables.value.manualMaterialIssueData.filter((item) => item.itemId === manualMaterialFormData.value.itemId)
            if (found.length === 0 && manualMaterialFormData.value.itemId) {
                modalTables.value.manualMaterialIssueData.push(manualMaterialFormData.value)
            }
            resetManualMaterialFormData()
        }

        const onManualIssueSelected = (items) => {
            if (items.length > 0) {
                manualMaterialFormData.value = items[0]
            } else {
                resetManualMaterialFormData()
            }
        }

        const manualMaterialIssueSubmit = async () => {
            await axios.post('/api/manual-material-issue', {
                materialIssueList: modalTables.value.manualMaterialIssueData
            })
                .then((res) => {
                    console.log(res.data)
                })
                .catch((error) => {
                    let response = error.response
                    if (response.data && response.status === 422) {
                        let data = response.data
                        if (data) {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: data.message,
                                    icon: 'AlertCircleIcon',
                                    variant: 'warning',
                                    text: data.errors.materialIssueList[0]
                                },
                            })
                        }
                    } else {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Error',
                                icon: 'AlertCircleIcon',
                                variant: 'danger',
                                text: 'Internal server error.'
                            },
                        })
                    }
                })
        }

        const deleteMaterialIssueSubmit = async () => {
            let itemList = modalTables.value.manualMaterialIssueData
            let newItemList = []
            await itemList.forEach((item) => {
                if (item.itemId === manualMaterialFormData.value.itemId) {

                } else {
                    newItemList.push(item)
                }
            })
            modalTables.value.manualMaterialIssueData = newItemList
            resetManualMaterialFormData()
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
            resetFormData,

            dateFormat,
            formatDates,
            getMaterialIssueFormatDate,
            makeOption,
            storeOption,
            issueStockOptions,
            openModal,

            //options
            jobCardOptions,
            workOrderOptions,
            breadCumItems,
            itemRequisitionOptions,
            itemMasterOptions,
            manualWorkOrderOptions,

            //get items
            getJobCardItems,
            getWorkOrderItems,
            getPreviousItems,
            getItemRequisitionItems,

            //modals
            modalTables,
            modalFormData,
            modalTableIsBusy,
            modalResetTableData,

            // Job Card
            againstJobCard,
            onJobCardRowSelected,
            submitJobCardIssueItem,

            // Work Order
            againstWorkOrder,
            workOrderModalTable,
            onWorkOrderRowSelected,
            workOrderModalForm,
            resetWorkOrderModalForm,
            selectWoChildItems,
            submitWorkOrderIssueItem,

            // Item Requisition
            againstItemRequisition,
            modalItemRequisitionFormData,
            resetModalItemRequisitionFormData,
            onRequisitionRowSelected,
            submitRequisitionForm,

            // Manual Material Issue
            manualMaterialIssue,
            manualMaterialIssueTable,
            getItemMasterDetails,
            manualMaterialFormData,
            resetManualMaterialFormData,
            submitManualForm,
            onManualIssueSelected,
            manualMaterialIssueSubmit,
            deleteMaterialIssueSubmit
        }
    }
}
</script>
