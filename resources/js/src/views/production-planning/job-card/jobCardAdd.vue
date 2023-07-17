<template>
    <div>
        <b-card-code>
            <validation-observer #default="{ handleSubmit }">
                <b-form @submit.prevent="handleSubmit(saveFormData)">
                    <b-row>
                        <b-col md="12">
                            <h5>Job Card Details</h5>
                            <hr>
                        </b-col>
                        <b-col md="6">
                            <b-row>
                                <b-col md="6">
                                    <validation-provider
                                        #default="validationContext"
                                        name="Job Card No."
                                        rules=""
                                    >
                                        <b-form-group
                                            label="Job Card No."
                                            label-for="jobCardNumber"
                                        >
                                            <b-form-input
                                                v-model="formData.jobCardNumber"
                                                id="jobCardNumber"
                                                type="number"
                                                readonly
                                                :state="getValidationState(validationContext)"
                                            />
                                        </b-form-group>
                                    </validation-provider>
                                </b-col>
                                <b-col md="6">
                                    <validation-provider
                                        #default="validationContext"
                                        name="Job Card Date"
                                        rules=""
                                    >
                                        <b-form-group
                                            label="Date"
                                            label-for="jobCardDate"
                                        >
                                            <b-input-group>
                                                <cleave
                                                    id="jobCardDate"
                                                    v-model="formData.jobCardDate"
                                                    class="form-control"
                                                    :raw="false"
                                                    :options="dateFormat"
                                                    placeholder="DD/MM/YYYY"
                                                    show-decade-nav
                                                />
                                                <b-input-group-append>
                                                    <b-form-datepicker
                                                        v-model="formatDates.jobCardDate"
                                                        button-only
                                                        @input="getJobCardFormateDate($event)"
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
                                        name="W.O.No."
                                        rules=""
                                    >
                                        <b-form-group
                                            label="W.O.No."
                                            label-for="woNumber"
                                        >
                                            <b-form-input
                                                v-model="formData.woNumber"
                                                id="woNumber"
                                                :state="getValidationState(validationContext)"
                                            />
                                        </b-form-group>
                                    </validation-provider>
                                </b-col>
                                <b-col md="6">
                                    <validation-provider
                                        #default="validationContext"
                                        name="Complete Date"
                                        rules=""
                                    >
                                        <b-form-group
                                            label="Complete Date"
                                            label-for="completeDate"
                                        >
                                            <b-input-group>
                                                <cleave
                                                    id="completeDate"
                                                    v-model="formData.completeDate"
                                                    class="form-control"
                                                    :raw="false"
                                                    :options="dateFormat"
                                                    placeholder="DD/MM/YYYY"
                                                    show-decade-nav
                                                />
                                                <b-input-group-append>
                                                    <b-form-datepicker
                                                        v-model="formatDates.completeDate" button-only
                                                        @input="getJobCardCompleteDate($event)"
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
                                            readonly
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
                                rules=""
                            >
                                <b-form-group
                                    label="Item Description"
                                    label-for="itemDescription"
                                >
                                    <b-form-input
                                        id="itemDescription"
                                        v-model="formData.itemDescription"
                                        readonly
                                        :state="getValidationState(validationContext)"
                                    />
                                </b-form-group>
                            </validation-provider>
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
                                        v-model="formData.addDescription"
                                        :state="getValidationState(validationContext)"
                                    />
                                </b-form-group>
                            </validation-provider>
                            <b-form-group
                                label="MSN No."
                                label-for="msnNo"
                            >
                                <b-form-input
                                    v-model="formData.msnNo"
                                    id="msnNo"
                                />
                            </b-form-group>
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
                                        v-model="formData.detailDescription"
                                        id="detailDescription"
                                        rows="2"
                                        :state="getValidationState(validationContext)"
                                    />
                                </b-form-group>
                            </validation-provider>
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
                                                v-model="formData.drawingNumber"
                                                :state="getValidationState(validationContext)"
                                            />
                                        </b-form-group>
                                    </validation-provider>
                                </b-col>
                                <b-col md="6">
                                    <validation-provider
                                        #default="validationContext"
                                        name="Rev"
                                        rules=""
                                    >
                                        <b-form-group
                                            label="Drawing Revesion"
                                            label-for="drawingRevesion"
                                        >
                                            <b-form-input
                                                id="drawingRevesion"
                                                v-model="formData.drawingRevesion"
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
                                        name="Conv. UOM"
                                        rules="required"
                                    >
                                        <b-form-group
                                            label="UOM"
                                            label-for="uom"
                                            :state="getValidationState(validationContext)"
                                        >
                                            <v-select
                                                v-model="formData.uom"
                                                placeholder="Select uom"
                                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                                :options="uomOption"
                                                :reduce="val => val.value"
                                                :clearable="false"
                                                input-id="uom"
                                                disabled
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
                                        name="Conv. UOM"
                                        rules="required"
                                    >
                                        <b-form-group
                                            label="Conv. UOM"
                                            label-for="convUom"
                                            :state="getValidationState(validationContext)"
                                        >
                                            <v-select
                                                id="convUom"
                                                v-model="formData.convUom"
                                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                                :options="uomOptions"
                                                :clearable="false"
                                                :reduce="val => val.value"
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
                                    <validation-provider
                                        #default="validationContext"
                                        name="Conv Qty"
                                        rules="numeric|required"
                                    >
                                        <b-form-group
                                            label="Conv Qty"
                                            label-for="convQty"
                                        >
                                            <b-form-input
                                                id="convQty"
                                                v-model="formData.convQty"
                                                :state="getValidationState(validationContext)"
                                                @keyup="calculateAmount"
                                            />
                                            <b-form-invalid-feedback>
                                                {{ validationContext.errors[0] }}
                                            </b-form-invalid-feedback>
                                        </b-form-group>
                                    </validation-provider>
                                </b-col>
                                <b-col md="6">
                                    <validation-provider
                                        #default="validationContext"
                                        name="CFactor"
                                        rules="required"
                                    >
                                        <b-form-group
                                            label="CFactor"
                                            label-for="cFactor"
                                        >
                                            <b-form-input
                                                id="cFactor"
                                                v-model="formData.cFactor"
                                                :state="getValidationState(validationContext)"
                                                @keyup="calculateAmount"
                                            />
                                            <b-form-invalid-feedback>
                                                {{ validationContext.errors[0] }}
                                            </b-form-invalid-feedback>
                                        </b-form-group>
                                    </validation-provider>
                                </b-col>
                            </b-row>
                            <validation-provider
                                #default="validationContext"
                                name="Bom Number"
                                rules="required"
                            >
                                <b-form-group
                                    label="BOM No."
                                    label-for="bomNumber"
                                    :state="getValidationState(validationContext)"
                                >
                                    <v-select
                                        v-model="formData.bomNumber"
                                        placeholder="Select BOM"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="bomNumberOPtion"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        input-id="bomNumber"
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
                                        label="Forecast No."
                                        label-for="foreCastNo"
                                    >
                                        <b-form-input
                                            id="foreCastNo"
                                            v-model="formData.foreCastNo"
                                        />
                                    </b-form-group>
                                </b-col>
                                <b-col md="6">
                                    <b-form-group
                                        label="Ref. No."
                                        label-for="refNo"
                                    >
                                        <b-form-input
                                            v-model="formData.refNo"
                                            id="refNo"
                                        />
                                    </b-form-group>
                                </b-col>
                            </b-row>
                        </b-col>
                        <!--row division -->
                        <b-col md="6">
                            <b-row>
                                <b-col md="6">
                                    <validation-provider
                                        #default="validationContext"
                                        name="Job Card Type"
                                        rules=""
                                    >
                                        <b-form-group
                                            label="Job Card"
                                            label-for="jobCard"
                                        >
                                            <v-select
                                                v-model="formData.jobCard"
                                                placeholder="Select Job Card"
                                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                                :options="jobCardType"
                                                :reduce="val => val.value"
                                                :clearable="false"
                                                input-id="jobCard"
                                                @input="clearFormData"
                                                :state="getValidationState(validationContext)"
                                            />
                                        </b-form-group>
                                    </validation-provider>
                                </b-col>
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
                            </b-row>
                            <b-row>
                                <b-col md="6">
                                    <validation-provider
                                        #default="validationContext"
                                        name="Priority"
                                        rules=""
                                    >
                                        <b-form-group
                                            label="Priority"
                                            label-for="priority"
                                        >
                                            <v-select
                                                v-model="formData.priority"
                                                placeholder="Select priority"
                                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                                :options="priorityOptions"
                                                :reduce="val => val.value"
                                                :clearable="false"
                                                input-id="priority"
                                                :state="getValidationState(validationContext)"
                                            />
                                        </b-form-group>
                                    </validation-provider>
                                </b-col>
                                <b-col md="6">
                                    <b-form-group
                                        label="Is Excisable"
                                        label-for="isExcisable"
                                    >
                                        <v-select
                                            v-model="formData.isExcisable"
                                            placeholder="Select Excisable"
                                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                            :options="excisableOptions"
                                            :reduce="val => val.value"
                                            :clearable="false"
                                            input-id="isExcisable"
                                        />
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col md="6">
                                    <validation-provider
                                        #default="validationContext"
                                        name="Job Card Qty. UM"
                                        rules="required"
                                    >
                                        <b-form-group
                                            label="Job Card Qty. UM"
                                            label-for="quantityUm"
                                        >
                                            <b-form-input
                                                id="quantityUm"
                                                v-model="formData.quantityUm"
                                                @keyup="calculateAmount"
                                                :state="getValidationState(validationContext)"
                                            />
                                            <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                                {{ validationContext.errors[0] }}
                                            </b-form-invalid-feedback>
                                        </b-form-group>
                                    </validation-provider>
                                </b-col>
                                <b-col md="6">
                                    <b-form-group
                                        label="Job Card Qty. UP"
                                        label-for="quantityUp"
                                    >
                                        <b-form-input
                                            id="quantityUp"
                                            v-model="formData.quantityUp"
                                        />
                                    </b-form-group>
                                </b-col>
                            </b-row>
<!--                            <validation-provider
                                #default="validationContext"
                                name="Job Card Quantity"
                                rules="required"
                            >
                                <b-form-group
                                    label="Job Card Qty"
                                    label-for="jobQty"
                                >
                                    <b-form-input
                                        v-model="formData.jobQty"
                                        id="jobQty"
                                        :state="getValidationState(validationContext)"
                                        @keyup="calculateTimeAmount"
                                    />
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>-->
                            <validation-provider
                                #default="validationContext"
                                name="Pending Job Quantity"
                                rules="required"
                            >
                                <b-form-group
                                    label="Pending Job Qty"
                                    label-for="pendingJobQty"
                                >
                                    <b-form-input
                                        v-model="formData.pendingJobQty"
                                        id="pendingJobQty"
                                        :state="getValidationState(validationContext)"
                                    />
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                            <validation-provider
                                #default="validationContext"
                                name="Accepted Job Quantity"
                                rules=""
                            >
                                <b-form-group
                                    label="Accepted Qty"
                                    label-for="acceptedQty"
                                >
                                    <b-form-input
                                        v-model="formData.acceptedQty"
                                        id="acceptedQty"
                                        :state="getValidationState(validationContext)"
                                        readonly
                                    />
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                            <validation-provider
                                #default="validationContext"
                                name="R/W Quantity"
                                rules=""
                            >
                                <b-form-group
                                    label="R/W Qty"
                                    label-for="rwQty"
                                >
                                    <b-form-input
                                        v-model="formData.rwQty"
                                        id="rwQty"
                                        :state="getValidationState(validationContext)"
                                        readonly
                                    />
                                </b-form-group>
                            </validation-provider>
                            <validation-provider
                                #default="validationContext"
                                name="Rejected Quantity"
                                rules=""
                            >
                                <b-form-group
                                    label="Rejected Qty"
                                    label-for="rejectedQty"
                                >
                                    <b-form-input
                                        v-model="formData.rejectedQty"
                                        id="rejectedQty"
                                        :state="getValidationState(validationContext)"
                                        readonly
                                    />
                                </b-form-group>
                            </validation-provider>
                            <validation-provider
                                #default="validationContext"
                                name="SC Quantity"
                                rules=""
                            >
                                <b-form-group
                                    label="SC Qty"
                                    label-for="scQty"
                                >
                                    <b-form-input
                                        v-model="formData.scQty"
                                        id="scQty"
                                        :state="getValidationState(validationContext)"
                                        readonly
                                    />
                                </b-form-group>
                            </validation-provider>
                            <validation-provider
                                #default="validationContext"
                                name="Heat/Batch No"
                                rules=""
                            >
                                <b-form-group
                                    label="Heat/Batch No."
                                    label-for="heatBatchNo"
                                >
                                    <b-input-group class="d-flex">
                                        <b-form-input
                                            v-model="formData.heatBatchNo"
                                            id="heatBatchNo"
                                            :state="getValidationState(validationContext)"
                                        />
                                        <b-input-group-append>
                                            <b-button variant="primary">...</b-button>
                                        </b-input-group-append>
                                    </b-input-group>
                                    <b-form-invalid-feedback>
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                            <validation-provider
                                #default="validationContext"
                                name="Process Sheet No."
                                rules="required"
                            >
                                <b-form-group
                                    label="Process Sheet No."
                                    label-for="processSheetNo"
                                    :state="getValidationState(validationContext)"
                                >
                                    <b-form-input
                                        v-model="formData.processSheetNo"
                                        id="processSheetNo"
                                        :state="getValidationState(validationContext)"
                                        readonly
                                    />
                                    <b-form-invalid-feedback>
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
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
                                        v-model="formData.remark"
                                        id="remark"
                                        rows="2"
                                        :state="getValidationState(validationContext)"
                                    />
                                </b-form-group>
                            </validation-provider>
                            <!--  radio Buttons-->
                            <b-form-group
                                label="Select Batch"
                                label-for="selectBatch"
                            >
                                <div class="demo-inline-spacing">
                                    <b-form-radio
                                        name="selectBatch"
                                        type="radio"
                                        value="1"
                                        v-model="formData.selectBatch"
                                        checked
                                    >
                                        Form Stock
                                    </b-form-radio>
                                    <b-form-radio
                                        name="selectBatch"
                                        type="radio"
                                        value="2"
                                        v-model="formData.selectBatch"
                                    >
                                        Form JW Chn
                                    </b-form-radio>
                                </div>
                            </b-form-group>
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
        </b-card-code>
        <!--modal Work Order-->
        <b-modal
            id="workOrderItemModal"
            title="Work Order Item"
            size="xl"
            no-close-on-backdrop
            ref="workOrderItemModal"
            scrollable
            ok-only
            ok-variant="danger"
            ok-title="Cancel"
            @ok="resetWorkModalData"
            @cancel="resetWorkModalData"
        >

            <b-row>
                <b-col md="3">
                    <b-form-group label="WO Number" label-for="itemSoNumber">
                        <b-form-input
                            id="itemWoNumber"
                            v-model.trim="searchData.workDataSearch.woNumber"
                            @keyup="getWorkOrderItemData"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="3">
                    <b-form-group label="Item Code" label-for="itemCode">
                        <b-form-input
                            id="itemCodes"
                            v-model.trim="searchData.workDataSearch.assemblyCode"
                            @keyup="getWorkOrderItemData"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="3">
                    <b-form-group label="Description" label-for="itemDescription">
                        <b-form-input
                            id="itemDescriptions"
                            v-model.trim="searchData.workDataSearch.assembly"
                            @keyup="getWorkOrderItemData"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="3">
                    <b-form-group label="Drawing Number" label-for="itemDrawingNumber">
                        <b-form-input
                            id="itemDrawingNumber"
                            v-model.trim="searchData.workDataSearch.drawingNo"
                            @keyup="getWorkOrderItemData"
                        />
                    </b-form-group>
                </b-col>
            </b-row>
            <b-table
                responsive
                :fields="modalTableData.workOrderItemFields"
                :items="modalTableData.workOrderItemData"
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
                        @click="selectWorkOrderItem(data.item)"
                    >
                        Select
                    </b-button>
                </template>
            </b-table>
        </b-modal>

        <!--All Item Modal-->
        <b-modal
            id="itemMasterModal"
            title="Select Item"
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
            </b-table>
        </b-modal>
<!-- Sales Order -->
        <b-modal
            id="salesOrderItemModal"
            title="Select Item"
            size="xl"
            no-close-on-backdrop
            ref="salesOrderItemModal"
            scrollable
            ok-only
            ok-variant="danger"
            ok-title="Cancel"
            @ok="resetSoModalData"
            @cancel="resetSoModalData"
        >
            <b-row>
                <b-col md="3">
                    <b-form-group label="sales Order No" label-for="salesOrderNo">
                        <b-form-input
                            id="salesOrderNo"
                            v-model.trim="searchData.itemSoSearch.salesOrderNo"
                            @keyup="getSalesOrderFilter"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="3">
                    <b-form-group label="Item Code" label-for="itemMasterCode">
                        <b-form-input
                            id="itemMasterCode"
                            v-model.trim="searchData.itemSoSearch.itemCode"
                            @keyup="getSalesOrderFilter"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="3">
                    <b-form-group label="Item Description" label-for="masterDescription">
                        <b-form-input
                            id="masterDescription"
                            v-model.trim="searchData.itemSoSearch.itemName"
                            @keyup="getSalesOrderFilter"
                        />

                    </b-form-group>
                </b-col>
                <b-col md="3">
                    <b-form-group label="Drawing Number" label-for="masterDrawingNumber">
                        <b-form-input
                            id="masterDrawingNumber"
                            v-model.trim="searchData.itemSoSearch.itemDrawingNo"
                            @keyup="getSalesOrderFilter"
                        />
                    </b-form-group>
                </b-col>
            </b-row>
            <b-table
                responsive
                :fields="modalTableData.itemSoFields"
                :items="modalTableData.itemSoData"
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
                        @click="selectSoItem(data.item)"
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
    BCol,
    BRow,
    BFormGroup,
    BFormInput,
    BFormDatepicker,
    BFormTextarea,
    BButton,
    BFormValidFeedback,
    BInputGroupAppend,
    BInputGroup,
    BFormInvalidFeedback,
    BFormRadio,
    BTable,
    BFormCheckbox,
    BCard,
} from 'bootstrap-vue'
import BCardCode from '../../../@core/components/b-card-code/BCardCode'
import { getTcTodayDate, forMatIndianDate } from '../../../@core/utils/utils'
import vSelect from 'vue-select'
import Ripple from 'vue-ripple-directive'
import { onUnmounted, ref } from '@vue/composition-api'
import store from '@/store'
import jobCardStoreModule from '../jobCardStoreModule'
import { required } from '@validations'
import { useToast } from 'vue-toastification/composition'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
import router from '@/router'
import axios from '@axios'
import moment from 'moment'
import { getUserData } from '../../../auth/utils'
import { ValidationProvider, ValidationObserver } from 'vee-validate'
import formValidation from '@core/comp-functions/forms/form-validation'
import Cleave from 'vue-cleave-component'

export default {
    components: {
        BCardCode,
        BFormValidFeedback,
        BInputGroupAppend,
        BInputGroup,
        BFormInvalidFeedback,
        BFormRadio,
        BForm,
        BCol,
        BRow,
        BFormGroup,
        BFormInput,
        BFormTextarea,
        BFormDatepicker,
        BButton,
        BTable,
        BFormCheckbox,
        BCard,
        vSelect,
        ValidationObserver,
        ValidationProvider,
        Cleave
    },
    directives: {
        Ripple,
    },

    setup({itemMasterModal, workOrderItemModal,salesOrderItemModal}) {
        const SE_APP_STORE_MODULE_NAME = 'job-card'

        if (!store.hasModule(SE_APP_STORE_MODULE_NAME)) store.registerModule(SE_APP_STORE_MODULE_NAME, jobCardStoreModule)
        onUnmounted(() => {
            if (store.hasModule(SE_APP_STORE_MODULE_NAME)) store.unregisterModule(SE_APP_STORE_MODULE_NAME)
        })

        const toast = useToast()
        // const selectBatch = ref('formStock')
        const calculateTimeAmount = () => {
            formData.value.pendingJobQty = formData.value.jobQty
        }

        const calculateAmount = () => {
            formData.value.quantityUp = formData.value.convQty * formData.value.cFactor * formData.value.quantityUm ?? 0
            formData.value.pendingJobQty = formData.value.quantityUm
        }

        const makeOption = ref([]);
        axios.get('/api/get-item-make-master-options').then(res => {
            makeOption.value = res.data.data
        });

        itemMasterModal = ref()
        workOrderItemModal = ref()
        salesOrderItemModal = ref()

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
        ])

        const excisableOptions = ref([
            {
                label: 'Yes',
                value: 1
            },
            {
                label: 'No',
                value: 2
            },
        ])

        const jobCardType = ref([
            {
                label: 'Against Work Order',
                value: 1
            },
            {
                label: 'For Stock',
                value: 2
            },
            {
                label: 'For Process Purchase',
                value: 3
            },
            {
                label: 'Against Work Order Sub Assembly',
                value: 4
            },
            {
                label: 'Against Customer Work',
                value: 5
            },
            {
                label: 'Against Customer Work Option 2',
                value: 6
            },
            {
                label: 'Against Forecast',
                value: 7
            },
            {
                label: 'Against Sales Order',
                value: 8
            },
        ])

        const priorityOptions = ref([
            {
                label: 'Low',
                value: 1
            },
            {
                label: 'Medium',
                value: 2
            },
            {
                label: 'High',
                value: 3
            },
        ])

        const uomOption = ref([])
        axios.get('/api/get-uom-master-options')
            .then(res => {
                uomOption.value = res.data.data
            })

        const bomNumberOPtion = ref([])
        axios.get('/api/get-bom-versions-options')
            .then(res => {
                bomNumberOPtion.value = res.data.data
            })
        const uomOptions = ref([])
        axios.get('/api/get-uom-master-options')
            .then(res => {
                uomOptions.value = res.data.data
            })

        const dateFormat = ref({
            date: true,
            delimiter: '/',
            datePattern: ['d', 'm', 'Y'],
        })

        const formatDates = ref({
            jobCardDate: null,
            completeDate: null,
        })

        const getJobCardFormateDate = (date) => {
            formData.value.jobCardDate = forMatIndianDate(date)
        }

        const getJobCardCompleteDate = (date) => {
            formData.value.completeDate = forMatIndianDate(date)
        }

        const CurrentUserData = ref(getUserData())

        const blankFormData = {
            jobCardDate: forMatIndianDate(getTcTodayDate()),
            woNumber: null,
            itemCode: null,
            itemDescription: null,
            jobCardNumber: null,
            status: 1,
            completeDate: forMatIndianDate(getTcTodayDate()),
            itemMake:null,
            addDescription: null,
            detailDescription: null,
            drawingNumber: null,
            drawingRevesion: null,
            uom: null,
            convUom: null,
            convQty: null,
            cFactor: null,
            bomNumber: null,
            foreCastNo: null,
            priority: 3,
            quantityUm: 0,
            quantityUp: 0,
            refNo: null,
            msnNo:null,
            jobCard: 2,
            jobQty: 0,
            pendingJobQty: 0,
            acceptedQty: 0,
            rwQty: 0,
            rejectedQty: 0,
            scQty: 0,
            heatBatchNo: null,
            processSheetNo: null,
            remark: null,
            selectBatch: 1,
            itemId: null,
            scrapDetails: {
                scrapItemId: null,
                scrapCode: null,
                scrapDesc: null,
                matIssueWt: null,
                scrapQty: null,
            },
            loginDetails: {
                createdBy: CurrentUserData.value.first_name + ' ' + CurrentUserData.value.last_name,
                dateTime: moment(new Date())
                    .format('DD/MM/YYYY HH:mm'),
                lastModifiedBy: null,
                modifiedDateTime: null,
            },
        }

        const formData = ref(JSON.parse(JSON.stringify(blankFormData)))

        const resetFormData = () => {
            formData.value = JSON.parse(JSON.stringify(blankFormData))
        }

        const clearFormData = () => {
            formData.value.woNumber = null
            formData.value.itemCode = null
            formData.value.itemDescription = null
            formData.value.woNumber = null
            formData.value.detailDescription = null
            formData.value.drawingNumber = null
            formData.value.drawingRevesion = null
            formData.value.uom = null
            formData.value.convUom = null
            formData.value.convQty = null
            formData.value.cFactor = null
            formData.value.itemId = null
            resetItemMasterModalData()
        }

        const modalTableData = ref({
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
            workOrderItemFields: [
                {
                    key: 'selectItem',
                    label: ''
                },
                {
                    key: 'woNumber',
                    label: 'WO No.  '
                },
                {
                    key: 'assemblyCode',
                    label: 'Item Code'
                },
                {
                    key: 'assembly',
                    label: 'Description'
                },
                {
                    key: 'uom_details.uom',
                    label: 'UOM'
                },
                {
                    key: 'drawingNo',
                    label: 'Drg No'
                },
            ],
            workOrderItemData: [],
            itemSoFields :[
                {
                    key: 'selectItem',
                    label: ''
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
            ],
            itemSoData: [],
        })

        const searchData = ref({
            itemMasterSearch: {
                itemCode: null,
                itemDescription: null,
                detailsDescription: null,
                drawingNumber: null,
                forJobCard: true
            },
            workDataSearch: {
                woNumber: null,
                assemblyCode: null,
                assembly: null,
                drawingNo: null,
            },
            itemSoSearch:{
                salesOrderNo: null,
                itemCode: null,
                itemName: null,
                itemDrawingNo: null,
            }
        })
        const getWorkOrderItemData = async () => {
            await axios.post('/api/new/get-work-order-item-filter', searchData.value.workDataSearch)
                .then(res => {
                    modalTableData.value.workOrderItemData = res.data.data
                })
        }

        const geItemMasterData = async () => {
            await axios.post('/api/get-item-master-with-filter', searchData.value.itemMasterSearch)
                .then(res => {
                    modalTableData.value.itemMasterData = res.data.data
                })
        }

        const getSalesOrderFilter = async () => {
            await axios.post('/api/get-sales-order-items-details-filter', searchData.value.itemSoSearch).then((res) => {
                modalTableData.value.itemSoData = res.data.data
            })
        }

        const openModal = async () => {
            switch (formData.value.jobCard) {
                case 2:
                    return itemMasterModal.value.show()
                case 8:
                    return salesOrderItemModal.value.show()
                default :
                    return workOrderItemModal.value.show()
            }
        }

        const resetItemMasterModalData = () => {
            searchData.value.itemMasterSearch.itemCode = null
            searchData.value.itemMasterSearch.drawingNumber = null
            searchData.value.itemMasterSearch.itemDescription = null
            searchData.value.itemMasterSearch.detailsDescription = null
            modalTableData.value.itemMasterData = []
        }
        const resetWorkModalData = () => {
            searchData.value.workDataSearch.woNumber = null
            searchData.value.workDataSearch.assemblyCode = null
            searchData.value.workDataSearch.assembly = null
            searchData.value.workDataSearch.drawingNo = null
            modalTableData.value.workOrderItemData = []
        }
        const resetSoModalData = () => {
            searchData.value.itemSoSearch.salesOrderNo = null
            searchData.value.itemSoSearch.itemCode = null
            searchData.value.itemSoSearch.itemName = null
            searchData.value.itemSoSearch.itemDrawingNo = null
            modalTableData.value.itemSoData = []
        }

        const selectItemMasterItem = async (data) => {
            formData.value.uom = data.uom ?? null
            formData.value.itemMake = data.make ?? null
            formData.value.itemCode = data.itemCode ?? null
            formData.value.itemDescription = data.itemDescription ?? null
            formData.value.itemId = data._id ?? null
            formData.value.drawingNumber = data.itemDetails?.drawingNumber ?? null
            formData.value.drawingRevesion = data.itemDetails?.revision ?? null
            formData.value.detailDescription = data.itemDetails?.detailDescription ?? null
            formData.value.addDescription = data.itemDetails?.description ?? null
            formData.value.convUom = data.convUom ?? null
            formData.value.convQty = data.convQty ?? null
            formData.value.cFactor = data.cFactor ?? null
            formData.value.quantityUp = 0
            await axios.get(`/api/get-bom-versions-item-wise-options/${formData.value.itemId}`).then((res) => {
                bomNumberOPtion.value = res.data.data
            });
            await axios.get(`/api/get-process-sheet-number-by-item/${formData.value.itemId}`).then((res) => {
                formData.value.processSheetNo = res.data.data
            });
            itemMasterModal.value.hide()
            resetItemMasterModalData()
        }

        const selectWorkOrderItem = async (data) => {
            formData.value.uom = data.uom
            formData.value.itemCode = data.assemblyCode ?? null
            formData.value.itemDescription = data.assembly ?? null
            formData.value.itemId = data.itemId ?? null
            formData.value.drawingNumber = data.drawingNo ?? null
            formData.value.drawingRevesion = data.drawingRev ?? null
            formData.value.detailDescription = data.detailDescription ?? null
            formData.value.addDescription = data.addDescription ?? null
            formData.value.woNumber = data.woNumber ?? null
            formData.value.jobQty = data.woQty ?? null
            workOrderItemModal.value.hide()
            resetWorkModalData()
        }
        const selectSoItem = async(data) => {
            formData.value.itemId = data?.itemId
            formData.value.itemCode = data?.itemCode
            formData.value.itemDescription = data?.itemName
            formData.value.itemMake = data?.itemMake
            formData.value.addDescription = data?.itemAddonDescription
            formData.value.detailDescription = data?.itemDetailDescription
            formData.value.drawingNumber = data?.itemDrawingRev
            formData.value.drawingRevesion = data?.itemDrawingRev
            formData.value.uom = data?.itemUom
            formData.value.convUom = data?.itemConvUom
            formData.value.convQty = data?.itemConvQty
            formData.value.cFactor = data?.itemConvQty
            formData.value.jobQty = data?.itemQuantity
            salesOrderItemModal.value.hide()
            resetSoModalData()
        }
        const saveFormData = async () => {
            await store.dispatch('job-card/AddJobCard', formData.value)
                .then(res => {
                    if (res.status === 200) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Job Card Added',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: `You have successfully Added Job Card.`,
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
                    router.push({
                        name: 'edit-job-card',
                        params: { id: res.data.data._id }
                    })
                })
        }

        const {
            refFormObserver,
            getValidationState,
            resetForm
        } = formValidation(resetFormData)

        return {
            formData,
            resetFormData,
            refFormObserver,
            getValidationState,
            resetForm,
            statusOptions,
            excisableOptions,
            jobCardType,
            priorityOptions,
            uomOption,
            bomNumberOPtion,
            searchData,
            modalTableData,
            itemMasterModal,
            geItemMasterData,
            openModal,
            resetItemMasterModalData,
            selectItemMasterItem,
            saveFormData,
            required,
            uomOptions,
            calculateTimeAmount,
            getJobCardFormateDate,
            dateFormat,
            formatDates,
            getJobCardCompleteDate,
            getWorkOrderItemData,
            workOrderItemModal,
            selectWorkOrderItem,
            resetWorkModalData,
            clearFormData,
            calculateAmount,
            makeOption,
            getSalesOrderFilter,
            salesOrderItemModal,
            selectSoItem,
            resetSoModalData
        }
    },
}
</script>
