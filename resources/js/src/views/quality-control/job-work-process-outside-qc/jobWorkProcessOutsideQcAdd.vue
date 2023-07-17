<template>
    <div>
        <b-card-code>
            <validation-observer #default="{handleSubmit}">
                <b-form @submit.prevent="handleSubmit(saveFormData)">
                    <b-row>
                        <b-col md="6">
                            <b-row>
                                <b-col md="6">
                                    <validation-provider
                                        #default="validationContext"
                                        name="Sub-Contractor Code"
                                        rules=""
                                    >
                                        <b-form-group
                                            label="Sub-Contractor Code"
                                            label-for="subContractorCode"
                                        >
                                            <v-select
                                                placeholder="Select Code"
                                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                                :options="subContractorCodeOptions"
                                                :reduce="val => val.value"
                                                :clearable="false"
                                                input-id="subContractorCode"
                                                @input="getSubContractorDetail($event)"
                                                v-model="formData.subContractorCode"
                                                :state="getValidationState(validationContext)"
                                            />
                                        </b-form-group>
                                        <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                            {{ validationContext.errors [0] }}
                                        </b-form-invalid-feedback>
                                    </validation-provider>
                                </b-col>
                                <b-col md="6">
                                    <validation-provider
                                        #default="validationContext"
                                        name="Sub-Contractor Name"
                                        rules="required"
                                    >
                                        <b-form-group
                                            label="Sub-Contractor Name"
                                            label-for="subContractorName"
                                        >
                                            <b-form-input
                                                id="subContractorName"
                                                :state="getValidationState(validationContext)"
                                                v-model="formData.subContractorName"
                                            />
                                        </b-form-group>
                                        <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                            {{ validationContext.errors[0] }}
                                        </b-form-invalid-feedback>
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
                                            id="itemCode"
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
                                rules=""
                            >
                                <b-form-group
                                    label="Item Description"
                                    label-for="itemDescription"
                                >
                                    <b-form-input
                                        :state="getValidationState(validationContext)"
                                        id="itemDescription"
                                        v-model="formData.itemDescription"
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
                                                multiple
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
                                <b-col md="6">
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
                                <b-col md="6">
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
                            <validation-provider
                                #default="validationContext"
                                name="UOM"
                                rules=""
                            >
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
                                        :state="getValidationState(validationContext)"
                                    />
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                        </b-col>
                        <b-col md="6">
                            <b-row>
                                <b-col md="6">
                                    <validation-provider
                                        #default="validationContext"
                                        name="Job Work No."
                                        rules=""
                                    >
                                        <b-form-group
                                            label="Job Work No."
                                            label-for="jobWorkNo"
                                        >
                                            <b-form-input
                                                id="jobWorkNo"
                                                v-model="formData.jobWorkNo"
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
                                        name="Job Card No."
                                        rules=""
                                    >
                                        <b-form-group
                                            label="Job Card No."
                                            label-for="jobCardNo"
                                        >
                                            <b-form-input
                                                id="jobCardNo"
                                                v-model="formData.jobCardNo"
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
                                        name="Work Order No."
                                        rules=""
                                    >
                                        <b-form-group
                                            label="Work Order No."
                                            label-for="workOrderNo"
                                        >
                                            <b-form-input
                                                id="workOrderNo"
                                                v-model="formData.workOrderNo"
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
                                        name="Challan No."
                                        rules=""
                                    >
                                        <b-form-group
                                            label="Challan No."
                                            label-for="challanNo"
                                        >
                                            <b-form-input
                                                id="challanNo"
                                                v-model="formData.challanNo"
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
                                name="Challan Date"
                                rules=""
                            >
                                <b-form-group
                                    label="Challan Date"
                                    label-for="challanDate"
                                    :state="getValidationState(validationContext)"
                                >
                                    <b-input-group>
                                        <b-input-group-prepend>
                                            <b-form-datepicker
                                                v-model="formatDates.challanDate"
                                                button-only
                                                @input="getchallanFormatDate($event)"
                                                show-decade-nav
                                                size="sm"
                                                nav-button-variant="primary"
                                            />
                                        </b-input-group-prepend>
                                        <cleave
                                            id="challanDate"
                                            v-model="formData.challanDate"
                                            class="form-control"
                                            :raw="false"
                                            :options="dateFormat"
                                            placeholder="DD/MM/YYYY"
                                            show-decade-nav
                                        />
                                    </b-input-group>
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                            <validation-provider
                                #default="validationContext"
                                name="Store"
                                rules=""
                            >
                                <b-form-group
                                    label="Store"
                                    label-for="itemStore"
                                    :state="getValidationState(validationContext)"
                                >
                                    <v-select
                                        :clearable="false"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="storeOption"
                                        :reduce="(val) => val.value"
                                        input-id="itemStore"
                                        placeholder="Select Store"
                                        v-model="formData.itemStore"
                                        :state="getValidationState(validationContext)"
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
                                        name="Challan Qty"
                                        rules=""
                                    >
                                        <b-form-group
                                            label="Challan Qty"
                                            label-for="challanQty"
                                        >
                                            <b-form-input
                                                id="challanQty"
                                                v-model="formData.challanQty"
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
                                        name="ReWork Qty"
                                        rules=""
                                    >
                                        <b-form-group
                                            label="ReWork Qty"
                                            label-for="reWorkQty"
                                        >
                                            <b-form-input
                                                id="reWorkQty"
                                                v-model="formData.reWorkQty"
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
                                        name="Accepted Qty"
                                        rules=""
                                    >
                                        <b-form-group
                                            label="Accepted Qty"
                                            label-for="acceptedQty"
                                        >
                                            <b-form-input
                                                id="acceptedQty"
                                                v-model="formData.acceptedQty"
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
                                        name="Rejected Qty"
                                        rules=""
                                    >
                                        <b-form-group
                                            label="Rejected Qty"
                                            label-for="rejectedQty"
                                        >
                                            <b-form-input
                                                id="rejectedQty"
                                                v-model="formData.rejectedQty"
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
                                name="Inspection Date"
                                rules=""
                            >
                                <b-form-group
                                    label="Inspection Date"
                                    label-for="inspectionDate"
                                    :state="getValidationState(validationContext)"
                                >
                                    <b-input-group>
                                        <b-input-group-prepend>
                                            <b-form-datepicker
                                                v-model="formatDates.inspectionDate"
                                                button-only
                                                @input="getInspectionFormatDate($event)"
                                                show-decade-nav
                                                size="sm"
                                                nav-button-variant="primary"
                                            />
                                        </b-input-group-prepend>
                                        <cleave
                                            id="inspectionDate"
                                            v-model="formData.inspectionDate"
                                            class="form-control"
                                            :raw="false"
                                            :options="dateFormat"
                                            placeholder="DD/MM/YYYY"
                                            show-decade-nav
                                        />
                                    </b-input-group>
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col md="12">
                            <hr>
                            <h5>Rejected Item</h5>
                            <hr>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col md="6">
                            <b-row>
                                <b-col md="6">
                                    <validation-provider
                                        #default="validationContext"
                                        name="Rejected Item"
                                        rules=""
                                    >
                                        <b-form-group
                                            label="Rejected Item"
                                            label-for="rejectItemCode"
                                        >
                                            <v-select
                                                placeholder="Select Item"
                                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                                :options="itemListOptions"
                                                :reduce="val => val.value"
                                                :clearable="false"
                                                input-id="rejectItemCode"
                                                v-model="formData.rejectItemCode"
                                                @input="getItemDetails($event)"
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
                                        name="Rejected Item Description"
                                        rules=""
                                    >
                                        <b-form-group
                                            label="Rejected Item Description"
                                            label-for="rejectItemDescription"
                                        >
                                            <b-form-input
                                                :state="getValidationState(validationContext)"
                                                id="rejectItemDescription"
                                                v-model="formData.rejectItemDescription"
                                                readonly
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
                                        name="Rejected Item Rate"
                                        rules=""
                                    >
                                        <b-form-group
                                            label="Rejected Item Rate"
                                            label-for="rejectItemRate"
                                        >
                                            <b-form-input
                                                :state="getValidationState(validationContext)"
                                                id="rejectItemRate"
                                                v-model="formData.rejectItemRate"
                                                readonly
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
                                        name="Rejected Cost"
                                        rules=""
                                    >
                                        <b-form-group
                                            label="Rejected Cost"
                                            label-for="rejectCost"
                                        >
                                            <b-form-input
                                                :state="getValidationState(validationContext)"
                                                id="rejectCost"
                                                v-model="formData.rejectCost"
                                                readonly
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
                                        name="Rejected Item Qty"
                                        rules=""
                                    >
                                        <b-form-group
                                            label="Rejected Item Qty"
                                            label-for="rejectItemQty"
                                        >
                                            <b-form-input
                                                :state="getValidationState(validationContext)"
                                                id="rejectItemQty"
                                                v-model="formData.rejectItemQty"
                                                readonly
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
                                        name="Rejection Type"
                                        rules=""
                                    >
                                        <b-form-group
                                            label="Rejection Type"
                                            label-for="rejectionType"
                                        >
                                            <v-select
                                                :clearable="false"
                                                :dir="$store.state.appConfig.isRTL? 'rtl': 'ltr'"
                                                :options="rejectionTypeOption"
                                                :reduce="(val) => val.value"
                                                input-id="rejectionType"
                                                placeholder="Select Type"
                                                v-model="formData.rejectionType"
                                                :state="getValidationState(validationContext)"
                                            />
                                            <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                                {{ validationContext.errors[0] }}
                                            </b-form-invalid-feedback>
                                        </b-form-group>
                                    </validation-provider>
                                </b-col>
                            </b-row>
                        </b-col>
                        <b-col md="6">
                            <b-row>
                                <b-col md="6">
                                    <validation-provider
                                        #default="validationContext"
                                        name="Batch No"
                                        rules=""
                                    >
                                        <b-form-group
                                            label="Batch No"
                                            label-for="batchNo"
                                        >
                                            <b-form-input
                                                :state="getValidationState(validationContext)"
                                                id="batchNo"
                                                v-model="formData.batchNo"
                                                readonly
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
                                        name="Operator Name"
                                        rules=""
                                    >
                                        <b-form-group
                                            label="Operator Name"
                                            label-for="operatorName"
                                        >
                                            <v-select
                                                :clearable="false"
                                                :dir="$store.state.appConfig.isRTL? 'rtl': 'ltr'"
                                                :options="operatorOption"
                                                :reduce="(val) => val.value"
                                                input-id="operatorName"
                                                placeholder="Select Type"
                                                v-model="formData.operatorName"
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
                                        name="Rejection Reason"
                                        rules=""
                                    >
                                        <b-form-group
                                            label="Rejection Reason"
                                            label-for="rejectionReason"
                                        >
                                            <b-form-input
                                                :state="getValidationState(validationContext)"
                                                id="rejectionReason"
                                                v-model="formData.rejectionReason"
                                                readonly
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
                                        name="Remark"
                                        rules=""
                                    >
                                        <b-form-group
                                            label="Remark"
                                            label-for="remark"
                                        >
                                            <b-form-input
                                                :state="getValidationState(validationContext)"
                                                id="remark"
                                                v-model="formData.remark"
                                                readonly
                                            />
                                            <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                                {{ validationContext.errors[0] }}
                                            </b-form-invalid-feedback>
                                        </b-form-group>
                                    </validation-provider>
                                </b-col>
                            </b-row>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col md="12">
                            <hr>
                            <h5>Batch/Heat Details</h5>
                            <hr>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col md="6">
                            <b-row>
                                <b-col md="6">
                                    <validation-provider
                                        #default="validationContext"
                                        name="Heat No."
                                        rules=""
                                    >
                                        <b-form-group
                                            label="Heat No."
                                            label-for="heatNo"
                                        >
                                            <b-form-input
                                                id="heatNo"
                                                v-model="formData.heatNo"
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
                                        name="Quantity"
                                        rules=""
                                    >
                                        <b-form-group
                                            label="Quantity"
                                            label-for="quantity"
                                        >
                                            <b-form-input
                                                id="quantity"
                                                v-model="formData.quantity"
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
                                        label="Manufactured Date"
                                        label-for="manufacturedDate"
                                    >
                                        <b-input-group>
                                            <cleave
                                                id="mfgDate"
                                                v-model="formData.manufacturedDate"
                                                class="form-control"
                                                :raw="false"
                                                :options="dateFormat"
                                                placeholder="DD/MM/YYYY"
                                                show-decade-nav
                                            />
                                            <b-input-group-append>
                                                <b-form-datepicker
                                                    v-model="formatDates.manufacturedDate"
                                                    button-only
                                                    @input="getMfgFormatDate($event)"
                                                    show-decade-nav
                                                    size="sm"
                                                    nav-button-variant="primary"
                                                />
                                            </b-input-group-append>
                                        </b-input-group>
                                    </b-form-group>
                                </b-col>
                                <b-col md="6">
                                    <b-form-group
                                        label="Expired Date"
                                        label-for="expiredDate"
                                    >
                                        <b-input-group>
                                            <cleave
                                                id="expiredDate"
                                                v-model="formData.expiredDate"
                                                class="form-control"
                                                :raw="false"
                                                :options="dateFormat"
                                                placeholder="DD/MM/YYYY"
                                                show-decade-nav
                                            />
                                            <b-input-group-append>
                                                <b-form-datepicker
                                                    v-model="formatDates.expiredDate"
                                                    button-only
                                                    @input="getExpiredFormatDate($event)"
                                                    show-decade-nav
                                                    size="sm"
                                                    nav-button-variant="primary"
                                                />
                                            </b-input-group-append>
                                        </b-input-group>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                        </b-col>
                        <b-col md="6">
                            <b-form-group
                                label="Remark"
                                label-for="remark"
                            >
                                <b-form-textarea
                                    id="batchRemark"
                                    rows="2"
                                    v-model="formData.batchRemark"
                                />
                            </b-form-group>
                        </b-col>
                        <b-col md="12">
                            <b-button
                                class="float-right"
                                variant="primary"
                            >
                                Inspaction Report
                            </b-button>
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
        <!--Receipt Item Detail -->
        <b-modal
            id="receiptJobWorkItemModal"
            title="Select Item Detail"
            ref="receiptJobWorkItemModal"
            ok-title="submit"
            cancel-variant="danger"
            size="xl"
            no-close-on-backdrop
        >
            <b-row>
                <b-col md="3">
                    <b-form-group
                        label="Item Code"
                        label-for="itemMasterCode"
                    >
                        <b-form-input
                            id="itemMasterCode"
                            v-model="searchData.itemCode"
                            @keyup="getReceiptJobWorkItemFilter"
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
                            @keyup="getReceiptJobWorkItemFilter"
                        />

                    </b-form-group>
                </b-col>
                <b-col md="3">
                    <b-form-group
                        label="Detail Description"
                        label-for="masterDetailDescription"
                    >
                        <b-form-input
                            id="masterDetailDescription"
                            v-model="searchData.itemDetailDescription"
                            @keyup="getReceiptJobWorkItemFilter"
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
                            v-model="searchData.itemDrawingNo"
                            @keyup="getReceiptJobWorkItemFilter"
                        />
                    </b-form-group>
                </b-col>
            </b-row>
            <b-table
                responsive
                :fields="modalTableData.receiptJobWorkItemFields"
                :items="modalTableData.receiptJobWorkItemData"
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
                        @click="selectJobWorkReceiptItemItem(data.item)"
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
        BInputGroupPrepend,
        BTable
    } from 'bootstrap-vue'
    import BCardCode from "../../../@core/components/b-card-code/BCardCode";
    import {ValidationObserver, ValidationProvider} from 'vee-validate'
    import formValidation from "@core/comp-functions/forms/form-validation";
    import {required} from '@validations'
    import {ref, onUnmounted} from '@vue/composition-api'
    import axios from '@axios'
    import vSelect from 'vue-select'
    import {forMatIndianDate,getTcTodayDate} from "@core/utils/utils";
    import Cleave from 'vue-cleave-component'
    import router from '@/router'
    import {getUserData} from "../../../auth/utils";
    import moment from "moment";
    import qualityControlStoreModule from "../qualityControlStoreModule";
    import store from '@/store'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import {useToast} from "vue-toastification/composition";

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
            vSelect,
            BFormDatepicker,
            Cleave,
            BInputGroupPrepend,
            BTable
        },
        setup({receiptJobWorkItemModal}) {
            receiptJobWorkItemModal = ref()
            const isModalTableBusy = ref(false)
            const toast = useToast()

            const ITEMADDON_APP_STORE_MODULE_NAME = 'quality-control-store-module'
            if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, qualityControlStoreModule)
            onUnmounted(() => {
                if (store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.unregisterModule(ITEMADDON_APP_STORE_MODULE_NAME)
            })

            const subContractorCodeOptions = ref([]);
            axios.get('/api/party/get-master-options').then(res => {
                subContractorCodeOptions.value = res.data.data
            });

            const makeOption = ref([]);
            axios.get('/api/get-item-make-master-options').then(res => {
                makeOption.value = res.data.data
            });
            const storeOption = ref([]);
            axios.get("/api/get-store-master-options").then((res) => {
                storeOption.value = res.data.data;
            });
            const rejectionTypeOption = ref([
                {label: 'Process Rejection', value: 1}
            ]);

            const operatorOption = ref([]);
            axios.get('/api/new/get-operator-master-option').then(res => {
                operatorOption.value = res.data.data
            })
            const itemListOptions = ref([])
            axios.get('/api/new/get-receipt-job-work-item-option').then(res => {
                itemListOptions.value = res.data.data
            })
            const modalTableData = ref({
                receiptJobWorkItemFields: [
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
                        label: 'Item Description'
                    },
                    {
                        key: 'jobQty',
                        label: 'Quantity'
                    },
                    {
                        key: 'uom_details.uom',
                        label: 'UOM'
                    },
                ],
                receiptJobWorkItemData:[],
            })
            const searchData = ref({
                itemCode:null,
                itemDescription:null,
                itemDetailDescription:null,
                itemDrawingNo:null,
            })

            const getReceiptJobWorkItemFilter = async () => {
                isModalTableBusy.value = true
                await axios.post('/api/new/get-receipt-job-work-item-filter', searchData.value).then(res => {
                    modalTableData.value.receiptJobWorkItemData = res.data.data
                })
                isModalTableBusy.value = false
            }

            const dateFormat = ref({
                date: true,
                delimiter: '/',
                datePattern: ['d', 'm', 'Y'],
            })
            const formatDates = ref({
                challanDate: null,
                inspectionDate: null,
                manufacturedDate: null,
                expiredDate: null,
            })
            const getchallanFormatDate = (date) => {
                formData.value.challanDate = forMatIndianDate(date)
            }
            const getInspectionFormatDate = (date) => {
                formData.value.inspectionDate = forMatIndianDate(date)
            }
            const getExpiredFormatDate = (date) => {
                formData.value.expiredDate = forMatIndianDate(date)
            }
            const getMfgFormatDate = (date) => {
                formData.value.manufacturedDate = forMatIndianDate(date)
            }

            const uomOption = ref([])
            axios.get("/api/get-uom-master-options").then((res) => {
                uomOption.value = res.data.data;
            });
            const blankFormData = {
                subContractorCode: null,
                subContractorName: null,
                itemCode: null,
                itemDescription: null,
                itemAddDescription: null,
                itemMake: null,
                itemDetailDescription: null,
                itemDrawingNo: null,
                itemRev: null,
                itemUom: null,
                jobWorkNo: null,
                jobCardNo: null,
                workOrderNo: null,
                challanNo: null,
                challanDate: forMatIndianDate(),
                itemStore: null,
                challanQty: null,
                acceptedQty: null,
                rejectedQty: null,
                reWorkQty: null,
                inspectionDate: forMatIndianDate(getTcTodayDate()),
                rejectItemCode: null,
                rejectItemDescription: null,
                rejectItemRate: null,
                rejectCost: null,
                rejectItemQty: null,
                rejectionType: null,
                batchNo: null,
                operatorName: null,
                rejectionReason: null,
                remark: null,
                heatNo:null,
                quantity:null,
                manufacturedDate:forMatIndianDate(getTcTodayDate()),
                expiredDate:forMatIndianDate(getTcTodayDate()),
                batchRemark:null,
                remarkDetails:{
                    inspectionRemark:null,
                },
                loginDetails:{
                    createdBy: getUserData().first_name + ' ' + getUserData().last_name,
                    dateTime: moment(new Date()).format('DD/MM/YYYY HH:mm'),
                    lastModifiedBy: null,
                    modifiedDateTime: null,
                }
            }
            const formData = ref(JSON.parse(JSON.stringify(blankFormData)))
            const resetFormData = () => {
                formData.value = JSON.parse(JSON.stringify(blankFormData))
            }
            const getItemDetails = async (id) => {
                await axios.get(`/api/new/receipt-job-work-challan/${id}`)
                    .then(res => {
                        formData.value.rejectItemDescription = res.data.data?.itemDescription ?? null
                    })
            }

            const getSubContractorDetail = async (id) => {
                await axios.get(`/api/party/edit/${id}`)
                    .then(res => {
                        formData.value.subContractorName = res.data.data?.partyName ?? null
                    })
            }
            const openModalItem = () => {
                receiptJobWorkItemModal.value.show();
            }
            const selectJobWorkReceiptItemItem = (data) => {
                formData.value.subContractorCode = data?.subContractor ?? null
                formData.value.subContractorName = data?.subContractorName ?? null
                formData.value.itemCode = data?.itemCode ?? null
                formData.value.itemDescription = data?.itemDescription ?? null
                formData.value.itemAddDescription = data?.itemAddDescription ?? null
                formData.value.itemMake = data?.itemMake ?? null
                formData.value.itemDetailDescription = data?.itemDetailDescription ?? null
                formData.value.itemDrawingNo = data?.itemDrawingNo ?? null
                formData.value.itemRev = data?.itemRevision ?? null
                formData.value.itemUom = data?.itemUom ?? null
                formData.value.jobWorkNo = data?.itemJobWorkNo ?? null
                formData.value.jobCardNo = data?.itemJobCardNo ?? null
                formData.value.workOrderNo = data?.itemWoNumber ?? null
                formData.value.challanNo = data?.challanNo ?? null
                formData.value.challanDate = data?.challanDate ?? null
                formData.value.itemStore = data?.itemStore ?? null
                formData.value.challanQty = data?.challanQty ?? null
                receiptJobWorkItemModal.value.hide();
            }
            const saveFormData = async () => {
                await store.dispatch('quality-control-store-module/addJobWorkOutsideQc', formData.value).then(res => {
                    if (res.status === 200) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Job Work OutSide QC Added',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: `You have successfully Added Job Work OutSide QC.`,
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
                        name: 'edit-job-work-process-outside-qc',
                        params: {
                            id: res.data.data._id
                        }
                    })
                })
            }
            const {refFormObserver, getValidationState, resetForm} = formValidation(resetFormData)
            return {
                formData,
                required,
                resetForm,
                refFormObserver,
                resetFormData,
                getValidationState,
                openModalItem,
                uomOption,
                dateFormat,
                formatDates,
                getchallanFormatDate,
                makeOption,
                storeOption,
                getInspectionFormatDate,
                rejectionTypeOption,
                operatorOption,
                saveFormData,
                getExpiredFormatDate,
                getMfgFormatDate,
                subContractorCodeOptions,
                getSubContractorDetail,
                modalTableData,
                searchData,
                getReceiptJobWorkItemFilter,
                isModalTableBusy,
                receiptJobWorkItemModal,
                selectJobWorkReceiptItemItem,
                itemListOptions,
                getItemDetails
            }
        }
    }
</script>
