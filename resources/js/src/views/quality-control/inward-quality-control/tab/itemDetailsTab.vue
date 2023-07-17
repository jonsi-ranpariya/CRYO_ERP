<template>
    <div>
        <b-row>
            <b-col md="12">
                <b-table
                    :fields="table.fields"
                    :items="table.data"
                    responsive
                    class="mb-0"
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
        <validation-observer #default="{handleSubmit}">
            <b-form @submit.prevent="handleSubmit(saveFormData)">
                <b-row>
                    <b-col md="6">
                        <b-row>
                            <b-col md="6">
                                <validation-provider
                                    #default="validationContext"
                                    name="PO No"
                                    rules="required"
                                >
                                    <b-form-group
                                        label="PO No."
                                        label-for="poNo"
                                    >
                                        <b-input-group class="d-flex">
                                            <b-form-input
                                                v-model="formData.poNo"
                                                :state="getValidationState(validationContext)"
                                                id="poNo"
                                                readonly
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
                            </b-col>
                            <b-col md="6">
                                <validation-provider
                                    #default="validationContext"
                                    name="PO Date"
                                    rules="required"
                                >
                                    <b-form-group
                                        label="Date"
                                        label-for="poJobDate"
                                        :state="getValidationState(validationContext)"
                                    >
                                        <b-input-group>
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
                                            <b-input-group-append>
                                                <b-form-datepicker
                                                    v-model="formatDates.poDate"
                                                    button-only
                                                    @input="getPoFormatDate($event)"
                                                    show-decade-nav
                                                    size="sm"
                                                    nav-button-variant="primary"
                                                />
                                            </b-input-group-append>
                                        </b-input-group>
                                        <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                            {{ validationContext.errors[0] }}
                                        </b-form-invalid-feedback>
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
                                <b-form-input
                                    v-model="formData.itemCode"
                                    :state="getValidationState(validationContext)"
                                    id="itemCode"
                                    readonly
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
                            >
                                <b-form-input
                                    :state="getValidationState(validationContext)"
                                    id="itemDescription"
                                    v-model="formData.itemDescription"
                                    readonly
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
                                    name="Item Desc(vendor)"
                                    rules=""
                                >
                                    <b-form-group
                                        label="ItemDesc (vendor)"
                                        label-for="itemDescVendor"
                                    >
                                        <b-form-input
                                            id="itemDescVendor"
                                            v-model="formData.itemDescVendor"
                                            :state="getValidationState(validationContext)"
                                            disabled
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
                                            placeholder="Select Make"
                                            v-model="formData.itemMake"
                                            :state="getValidationState(validationContext)"
                                            disabled
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
                            name="Add Description"
                            rules="required"
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
                        <validation-provider
                            #default="validationContext"
                            name="Detail Description"
                            rules="required"
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
                                    rules="required"
                                >
                                    <b-form-group
                                        label="Drawing No."
                                        label-for="itemDrowingNo"
                                    >
                                        <b-form-input
                                            id="itemDrowingNo"
                                            v-model="formData.itemDrowingNo"
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
                                    rules="required"
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
                        <b-row>
                            <b-col md="6">
                                <validation-provider
                                    #default="validationContext"
                                    name="UOM"
                                    rules="required"
                                >
                                    <b-form-group
                                        label="UOM"
                                        label-for="itemUom"
                                    >
                                        <v-select
                                            :clearable="false"
                                            :dir="$store.state.appConfig.isRTL? 'rtl': 'ltr'"
                                            :options="uomOPtion"
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
                                <validation-provider
                                    #default="validationContext"
                                    name="Purchase UOM"
                                    rules="required"
                                >
                                    <b-form-group
                                        label="Purchase UOM"
                                        label-for="purchaseUom"
                                    >
                                        <v-select
                                            :clearable="false"
                                            :dir="$store.state.appConfig.isRTL? 'rtl': 'ltr'"
                                            :options="purchaseUomOPtion"
                                            :reduce="(val) => val.value"
                                            input-id="purchaseUom"
                                            placeholder="Select uom"
                                            v-model="formData.purchaseUom"
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
                            name="C-Factor"
                            rules="required"
                        >
                            <b-form-group
                                label="C-Factor"
                                label-for="itemFactor"
                            >
                                <b-form-input
                                    id="itemFactor"
                                    v-model="formData.itemFactor"
                                    readonly
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
                                    name="GRN No"
                                    rules="required"
                                >
                                    <b-form-group
                                        label="GRN No."
                                        label-for="grnNo"
                                    >
                                        <b-form-input
                                            v-model="formData.grnNo"
                                            id="grnNo"
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
                                    name="GRN No"
                                    rules="required"
                                >
                                    <b-form-group
                                        label="GRN Date"
                                        label-for="grnDate"
                                        :state="getValidationState(validationContext)"
                                    >
                                        <b-input-group>
                                            <cleave
                                                id=""
                                                v-model="formData.grnDate"
                                                class="form-control"
                                                :raw="false"
                                                :options="dateFormat"
                                                placeholder="DD/MM/YYYY"
                                                show-decade-nav
                                            />
                                            <b-input-group-append>
                                                <b-form-datepicker
                                                    v-model="formatDates.grnDate"
                                                    button-only
                                                    @input="getGrnFormatDate($event)"
                                                    show-decade-nav
                                                    size="sm"
                                                    nav-button-variant="primary"
                                                />
                                            </b-input-group-append>
                                        </b-input-group>
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
                                    name="Challan No"
                                    rules="required"
                                >
                                    <b-form-group
                                        label="Challan No."
                                        label-for="challanNo"
                                    >
                                        <b-form-input
                                            v-model="formData.challanNo"
                                            id="challanNo"
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
                                    name="Challan Date"
                                    rules="required"
                                >
                                    <b-form-group
                                        label="Challan Date"
                                        label-for="challanDate"
                                        :state="getValidationState(validationContext)"
                                    >
                                        <b-input-group>
                                            <cleave
                                                id="challanDate"
                                                v-model="formData.challanDate"
                                                class="form-control"
                                                :raw="false"
                                                :options="dateFormat"
                                                placeholder="DD/MM/YYYY"
                                                show-decade-nav
                                            />
                                            <b-input-group-append>
                                                <b-form-datepicker
                                                    v-model="formatDates.challanDate"
                                                    button-only
                                                    @input="getChallanFormatDate($event)"
                                                    show-decade-nav
                                                    size="sm"
                                                    nav-button-variant="primary"
                                                />
                                            </b-input-group-append>
                                        </b-input-group>
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
                                    name="GIR No"
                                    rules="required"
                                >
                                    <b-form-group
                                        label="GIR No"
                                        label-for="girNo"
                                    >
                                        <b-form-input
                                            v-model="formData.girNo"
                                            id="girNo"
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
                                    name="GIR Date"
                                    rules="required"
                                >
                                    <b-form-group
                                        label="GIR Date"
                                        label-for="girDate"
                                    >
                                        <b-input-group>
                                            <cleave
                                                id="girDate"
                                                v-model="formData.girDate"
                                                class="form-control"
                                                :raw="false"
                                                :options="dateFormat"
                                                placeholder="DD/MM/YYYY"
                                                show-decade-nav
                                            />
                                            <b-input-group-append>
                                                <b-form-datepicker
                                                    v-model="formatDates.girDate"
                                                    button-only
                                                    @input="getGirFormatDate($event)"
                                                    show-decade-nav
                                                    size="sm"
                                                    nav-button-variant="primary"
                                                />
                                            </b-input-group-append>
                                        </b-input-group>
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
                                <b-form-group
                                    label="L.R. No"
                                    label-for="lrNo"
                                >
                                    <b-form-input
                                        v-model="formData.lrNo"
                                        id="lrNo"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="L.R. Date"
                                    label-for="lrDate"
                                >
                                    <b-input-group>
                                        <cleave
                                            id="lrDate"
                                            v-model="formData.lrDate"
                                            class="form-control"
                                            :raw="false"
                                            :options="dateFormat"
                                            placeholder="DD/MM/YYYY"
                                            show-decade-nav
                                        />
                                        <b-input-group-append>
                                            <b-form-datepicker
                                                v-model="formatDates.lrDate"
                                                button-only
                                                @input="getLrFormatDate($event)"
                                                show-decade-nav
                                                size="sm"
                                                nav-button-variant="primary"
                                            />
                                        </b-input-group-append>
                                    </b-input-group>
                                </b-form-group>
                            </b-col>
                        </b-row>
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
                                                    v-model="formatDates.deliveryDate"
                                                    button-only
                                                    @input="getDeliveryFormatDate($event)"
                                                    show-decade-nav
                                                    size="sm"
                                                    nav-button-variant="primary"
                                                    :state="getValidationState(validationContext)"
                                                    disabled
                                                />
                                            </b-input-group-prepend>
                                            <cleave
                                                id="deliveryDate"
                                                v-model="formData.deliveryDate"
                                                class="form-control"
                                                :raw="false"
                                                :options="dateFormat"
                                                placeholder="DD/MM/YYYY"
                                                show-decade-nav
                                                :state="getValidationState(validationContext)"
                                                disabled
                                            />
                                        </b-input-group>
                                        <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                            {{ validationContext.errors[0] }}
                                        </b-form-invalid-feedback>
                                    </b-form-group>
                                </validation-provider>
                            </b-col>
                            <b-col md="6">
                                <validation-provider
                                    #default="validationContext"
                                    name="Location"
                                    rules="required"
                                >
                                    <b-form-group
                                        label="Location"
                                        label-for="location"
                                    >
                                        <b-form-input
                                            v-model="formData.location"
                                            id="location"
                                            :state="getValidationState(validationContext)"
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
                                    name="Indent Date"
                                    rules=""
                                >
                                    <b-form-group
                                        label="Indent Date"
                                        label-for="indentDate"
                                        :state="getValidationState(validationContext)"
                                    >
                                        <b-input-group>
                                            <b-input-group-prepend>
                                                <b-form-datepicker
                                                    v-model="formatDates.indentDate"
                                                    button-only
                                                    @input="getIndentFormatDate($event)"
                                                    show-decade-nav
                                                    size="sm"
                                                    nav-button-variant="primary"
                                                    disabled
                                                />
                                            </b-input-group-prepend>
                                            <cleave
                                                id="indentDate"
                                                v-model="formData.indentDate"
                                                class="form-control"
                                                :raw="false"
                                                :options="dateFormat"
                                                placeholder="DD/MM/YYYY"
                                                show-decade-nav
                                                disabled
                                            />
                                        </b-input-group>
                                        <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                            {{ validationContext.errors[0] }}
                                        </b-form-invalid-feedback>
                                    </b-form-group>
                                </validation-provider>
                            </b-col>
                            <b-col md="6">
                                <validation-provider
                                    #default="validationContext"
                                    name="Indent No"
                                    rules="required"
                                >
                                    <b-form-group
                                        label="Indent No."
                                        label-for="itemIndentNo"
                                    >
                                        <b-form-input
                                            id="itemIndentNo"
                                            v-model="formData.itemIndentNo"
                                            :state="getValidationState(validationContext)"
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
                                    name="P.O. Qty UM"
                                    rules="required"
                                >
                                    <b-form-group
                                        label="P.O. Qty UM"
                                        label-for="poQuantityUm"
                                    >
                                        <b-form-input
                                            id="poQuantityUm"
                                            v-model="formData.poQuantityUm"
                                            :state="getValidationState(validationContext)"
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
                                    name="Pending Qty UM"
                                    rules="required"
                                >
                                    <b-form-group
                                        label="Pending Qty UM"
                                        label-for="pendingQuantityUm"
                                    >
                                        <b-form-input
                                            id="pendingQuantityUm"
                                            v-model="formData.pendingQuantityUm"
                                            :state="getValidationState(validationContext)"
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
                                    name="P.O. Qty UP"
                                    rules="required"
                                >
                                    <b-form-group
                                        label="P.O. Qty UP"
                                        label-for="poQuantityUp"
                                    >
                                        <b-form-input
                                            id="poQuantityUp"
                                            v-model="formData.poQuantityUp"
                                            :state="getValidationState(validationContext)"
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
                                    name="Pending Qty UP"
                                    rules="required"
                                >
                                    <b-form-group
                                        label="Pending Qty UP"
                                        label-for="pendingQuantityUp"
                                    >
                                        <b-form-input
                                            id="pendingQuantityUp"
                                            v-model="formData.pendingQuantityUp"
                                            :state="getValidationState(validationContext)"
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
                                    name="Rate"
                                    rules="required"
                                >
                                    <b-form-group
                                        label="Rate"
                                        label-for="rate"
                                    >
                                        <b-form-input
                                            id="rate"
                                            v-model="formData.rate"
                                            :state="getValidationState(validationContext)"
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
                                    name="Insp. Qty"
                                    rules=""
                                >
                                    <b-form-group
                                        label="Insp. Qty"
                                        label-for="inspQuantity"
                                    >
                                        <b-form-input
                                            id="inspQuantity"
                                            v-model="formData.inspQuantity"
                                            :state="getValidationState(validationContext)"
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
                                    name="Challan Qty UP"
                                    rules="required"
                                >
                                    <b-form-group
                                        label="Challan Qty UP"
                                        label-for="challanQty"
                                    >
                                        <b-form-input
                                            id="challanQty"
                                            v-model="formData.challanQtyUp"
                                            :state="getValidationState(validationContext)"
                                            type="number"
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
                                    name="Challan Qty UM"
                                    rules="required"
                                >
                                    <b-form-group
                                        label="Challan Qty UM"
                                        label-for="actualQty"
                                    >
                                        <b-form-input
                                            id="actualQty"
                                            v-model="formData.challanQtyUm"
                                            :state="getValidationState(validationContext)"
                                            type="number"
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
                                    name="Actual Qty UP"
                                    rules="required"
                                >
                                    <b-form-group
                                        label="Actual Qty UP"
                                        label-for="acceptedQuantityUp"
                                    >
                                        <b-form-input
                                            id="acceptedQuantityUp"
                                            v-model="formData.acceptedQuantityUp"
                                            :state="getValidationState(validationContext)"
                                            type="number"
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
                                    name="Actual Qty UM"
                                    rules="required"
                                >
                                    <b-form-group
                                        label="Actual Qty UM"
                                        label-for="acceptedQuantityUm"
                                    >
                                        <b-form-input
                                            id="acceptedQuantityUm"
                                            v-model="formData.acceptedQuantityUm"
                                            :state="getValidationState(validationContext)"
                                            type="number"
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
                                    name="Rejected Qty UP"
                                    rules="required"
                                >
                                    <b-form-group
                                        label="Rejected Qty UP"
                                        label-for="rejectedQuantityUp"
                                    >
                                        <b-form-input
                                            id="rejectedQuantityUp"
                                            v-model="formData.rejectedQuantityUp"
                                            :state="getValidationState(validationContext)"
                                            type="number"
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
                                    name="Rejected Qty UM"
                                    rules="required"
                                >
                                    <b-form-group
                                        label="Rejected Qty UM"
                                        label-for="rejectedQuantityUm"
                                    >
                                        <b-form-input
                                            id="rejectedQuantityUm"
                                            v-model="formData.rejectedQuantityUm"
                                            :state="getValidationState(validationContext)"
                                            type="number"
                                        />
                                        <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                            {{ validationContext.errors[0] }}
                                        </b-form-invalid-feedback>
                                    </b-form-group>
                                </validation-provider>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="12">
                                <b-button
                                    class="float-right"
                                    variant="primary"
                                >
                                    Hold
                                </b-button>
                            </b-col>
                        </b-row>
                        <validation-provider
                            #default="validationContext"
                            name="Inspaction Date"
                            rules=""
                        >
                            <b-form-group
                                label="Inspaction Date"
                                label-for="inspactionDate"
                                :state="getValidationState(validationContext)"
                            >
                                <b-input-group>
                                    <b-input-group-prepend>
                                        <b-form-datepicker
                                            v-model="formatDates.inspactionDate"
                                            button-only
                                            @input="getInspactionFormatDate($event)"
                                            show-decade-nav
                                            size="sm"
                                            nav-button-variant="primary"
                                        />
                                    </b-input-group-prepend>
                                    <cleave
                                        id="inspactionDate"
                                        v-model="formData.inspactionDate"
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
                        <div class="demo-inline-spacing">
                            <b-form-checkbox
                                id="conversion"
                                class="custom-control-primary"
                                v-model="formData.grnConversion"
                            >
                                Conversion..?
                            </b-form-checkbox>
                        </div>
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
                    </b-col>
                    <b-col md="6">
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
                    <b-col md="12">
                        <b-form-group
                            label="Remark"
                            label-for="remark"
                        >
                            <b-form-textarea
                                id="remark"
                                rows="2"
                                v-model="formData.remark"
                            />
                        </b-form-group>
                    </b-col>
                    <!-- Button-->
                    <b-col md="12">
                        <hr>
                        <b-button
                            class="float-right mr-1"
                            variant="primary"
                            type="submit"
                        >
                            Save
                        </b-button>
                        <b-button
                            class="float-right mr-1"
                            variant="primary"
                        >
                            Inspaction Report
                        </b-button>
                        <div v-if="formData.poNo">
                            <b-button
                                class="float-right mr-1"
                                variant="primary"
                                @click="openTermsAndConditionModal"
                            >
                                For Terms & Condition
                            </b-button>
                        </div>
                    </b-col>
                </b-row>
            </b-form>
        </validation-observer>

        <!-- PO Terms & Condition Modal ------->
        <b-modal
            cancel-variant="danger"
            id="poTermsAndConditionModal"
            no-close-on-backdrop
            ok-title="Save"
            ref="poTermsAndConditionModal"
            scrollable
            size="xl"
            hide-footer
            title="Purchase Order Terms & Condition Details"
        >
            <!-- Table -->
            <b-row>
                <b-col md="12">
                    <b-table
                        responsive
                        :fields="modalTables.termsAndConditionFields"
                        :items="modalTables.termsAndConditionData"
                        :bordered="true"
                        :hover="true"
                        show-empty
                        class="table_scroll"
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
                    </b-table>
                    <hr/>
                </b-col>
            </b-row>
            <!--add Description-->
        </b-modal>

        <!--Modal grn item-->
        <b-modal
            id="purchaseItemModal"
            title="Select PO Item Detail"
            ref="purchaseItemModal"
            ok-title="submit"
            cancel-variant="danger"
            size="xl"
            no-close-on-backdrop
        >
            <b-table
                :fields="modalTableItemData.purchaseItemFields"
                :items="modalTableItemData.purchaseItemData"
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
                <template #cell(selectButton)="data">
                    <b-button
                        type="button"
                        size="sm"
                        variant="primary"
                        @click="getPurchaseItemDetails(data.item)"
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
    BFormGroup,
    BFormInput,
    BForm,
    BRow,
    BCol,
    BDropdown,
    BDropdownItem,
    BTable,
    BSpinner,
    BInputGroup,
    BInputGroupAppend,
    BButton,
    BFormInvalidFeedback,
    BFormDatepicker,
    BFormTextarea,
    BInputGroupPrepend,
    BFormCheckbox
} from 'bootstrap-vue'
import BCardCode from '../../../../@core/components/b-card-code/BCardCode'
import { ref, onUnmounted, onMounted, computed } from '@vue/composition-api'
import { ValidationProvider, ValidationObserver } from 'vee-validate'
import formValidation from '@core/comp-functions/forms/form-validation'
import Cleave from 'vue-cleave-component'
import axios from '@axios'
import vSelect from 'vue-select'
import { forMatIndianDate, getTcTodayDate } from '@core/utils/utils'
import { required } from '@validations'
import qualityControlStoreModule from '../../qualityControlStoreModule'
import { useToast } from 'vue-toastification/composition'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
import store from '@/store'
import router from '@/router'
import Swal from 'sweetalert2'

export default {
    components: {
        BForm,
        BCardCode,
        BRow,
        BCol,
        BDropdownItem,
        BDropdown,
        BTable,
        BSpinner,
        ValidationObserver,
        ValidationProvider,
        BFormGroup,
        BFormInput,
        BInputGroup,
        BInputGroupAppend,
        BButton,
        BFormInvalidFeedback,
        Cleave,
        BFormDatepicker,
        BFormTextarea,
        vSelect,
        BInputGroupPrepend,
        required,
        BFormCheckbox
    },
    props: {
        partyId: {
            required: true
        },
        goodNoteId: {
            required: true
        },
        purchaseOrderId: {
            required: true
        },
    },
    setup(props, {
        purchaseOrderModal,
        purchaseItemModal,
        poTermsAndConditionModal
    }) {

        const grnPartyId = computed(() => props.partyId)
        const currentGoodNoteId = computed(() => props.goodNoteId)
        const currentPurchaseOrderId = computed(() => props.purchaseOrderId)

        const toast = useToast()

        const ITEMADDON_APP_STORE_MODULE_NAME = 'quality-control-store-module'
        onMounted(() => {
            if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, qualityControlStoreModule)
        })
        onUnmounted(() => {
            if (store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.unregisterModule(ITEMADDON_APP_STORE_MODULE_NAME)
        })
        purchaseOrderModal = ref()
        purchaseItemModal = ref()
        poTermsAndConditionModal = ref()
        const isModalTableBusy = ref(false)

        const isBusy = ref(false)

        const uomOPtion = ref([])
        axios.get('/api/get-uom-master-options')
            .then((res) => {
                uomOPtion.value = res.data.data
            })

        const purchaseUomOPtion = ref([])
        axios.get('/api/get-uom-master-options')
            .then((res) => {
                purchaseUomOPtion.value = res.data.data
            })

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

        const table = ref({
            fields: [
                {
                    key: 'index',
                    label: 'No',
                },
                {
                    key: 'poNo',
                    label: 'PO No',
                },
                {
                    key: 'poDate',
                    label: 'PO Date',
                },
                {
                    key: 'itemCode',
                    label: 'Item Code',
                },
                {
                    key: 'itemDescription',
                    label: 'Item Description',
                },
                {
                    key: 'deliveryDate',
                    label: 'Delivery Date'
                },
                {
                    key: 'poQuantityUm',
                    label: 'PO Qty'
                },
                {
                    key: 'pendingQuantityUm',
                    label: 'Pending PO Qty'
                },
                {
                    key: 'action',
                    label: 'Action',
                }
            ],
            data: [],
        })
        const modalTableItemData = ref({
            purchaseItemFields: [
                {
                    key: 'selectButton',
                    label: ''
                },
                {
                    key: 'grnNo',
                    label: 'GRN No'
                },
                {
                    key: 'grnDate',
                    label: 'GRN Date'
                },
                {
                    key: 'challanNo',
                    label: 'Challan No'
                },
                {
                    key: 'challanDate',
                    label: 'Challan Date'
                },
                {
                    key: 'party_detail.partyName',
                    label: 'Vendor'
                },
                {
                    key: 'challanQuantityUm',
                    label: 'Challan Qty'
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
                    key: 'itemDescVendor',
                    label: 'Item Description(Vendor)'
                },
            ],
            purchaseItemData: [],
        })

        const modalTables = ref({
            termsAndConditionFields: [
                {
                    key: 'groupName',
                    label: 'Group Name'
                },
                {
                    key: 'termsCondition',
                    label: 'Terms & Condition'
                },
            ],
            termsAndConditionData: [],
        })

        const dateFormat = ref({
            date: true,
            delimiter: '/',
            datePattern: ['d', 'm', 'Y'],
        })

        const formatDates = ref({
            poDate: null,
            challanDate: null,
            girDate: null,
            lrDate: null,
            deliveryDate: null,
            indentDate: null,
            grnDate: null,
            inspactionDate: null,
            manufacturedDate: null,
            expiredDate: null,
        })
        const getPoFormatDate = (date) => {
            formData.value.poDate = forMatIndianDate(date)
        }

        const getChallanFormatDate = (date) => {
            formData.value.challanDate = forMatIndianDate(date)
        }

        const getGirFormatDate = (date) => {
            formData.value.girDate = forMatIndianDate(date)
        }

        const getLrFormatDate = (date) => {
            formData.value.lrDate = forMatIndianDate(date)
        }

        const getDeliveryFormatDate = (date) => {
            formData.value.deliveryDate = forMatIndianDate(date)
        }

        const getIndentFormatDate = (date) => {
            formData.value.indentDate = forMatIndianDate(date)
        }

        const getGrnFormatDate = (date) => {
            formData.value.grnDate = forMatIndianDate(date)
        }

        const getInspactionFormatDate = (date) => {
            formData.value.inspactionDate = forMatIndianDate(date)
        }

        const getMfgFormatDate = (date) => {
            formData.value.manufacturedDate = forMatIndianDate(date)
        }

        const getExpiredFormatDate = (date) => {
            formData.value.expiredDate = forMatIndianDate(date)
        }

        const getPurchaseItemDetails = async (data) => {
            formData.value.poNo = data?.poNo ?? null
            formData.value.poDate = data?.poDate ?? null
            formData.value.itemCode = data?.itemCode ?? null
            formData.value.itemDescription = data?.itemDescription ?? null
            formData.value.itemDescVendor = data?.itemDescVendor ?? null
            formData.value.itemAddDescription = data?.itemAddDescription ?? null
            formData.value.itemDetailDescription = data?.itemDetailDescription ?? null
            formData.value.itemDrowingNo = data?.itemDrowingNo ?? null
            formData.value.itemRev = data?.itemRev ?? null
            formData.value.itemUom = data?.itemUom ?? null
            formData.value.purchaseUom = data?.purchaseUom ?? null
            formData.value.itemFactor = data?.itemFactor ?? null
            formData.value.grnNo = data?.grnNo ?? null
            formData.value.grnDate = data?.grnDate ?? null
            formData.value.challanNo = data?.challanNo ?? null
            formData.value.challanDate = data?.challanDate ?? null
            formData.value.girNo = data?.girNo ?? null
            formData.value.girDate = data?.girDate ?? null
            formData.value.lrNo = data?.lrNo ?? null
            formData.value.lrDate = data?.lrDate ?? null
            formData.value.itemMake = data?.itemMake ?? null
            formData.value.itemStore = data?.itemStore ?? null
            formData.value.deliveryDate = data?.deliveryDate ?? null
            formData.value.location = data?.location ?? null
            formData.value.indentDate = data?.indentDate ?? null
            formData.value.itemIndentNo = data?.itemIndentNo ?? null
            formData.value.poQuantityUm = data?.poQuantityUm ?? null
            formData.value.pendingQuantityUm = data?.pendingQuantityUm ?? null
            formData.value.poQuantityUp = data?.poQuantityUp ?? null
            formData.value.pendingQuantityUp = data?.pendingQuantityUp ?? null
            formData.value.rate = data?.rate ?? null
            formData.value.inspQuantity = data?.inspQuantity ?? null
            formData.value.challanQtyUp = data?.challanQuantityUp ?? null
            formData.value.challanQtyUm = data?.challanQuantityUm ?? null
            formData.value.acceptedQuantityUm = data?.actualQuantityUm ?? null
            formData.value.acceptedQuantityUp = data?.actualQuantityUp ?? null
            formData.value.goodNoteId = data?.goodNoteId
            formData.value.grnItemId = data?._id
            formData.value.poItemId = data?.poItemId
            formData.value.purchaseOrderId = data?.purchaseOrderId
            formData.value.itemId = data?.itemId
            purchaseItemModal.value.hide()
        }

        const blankFormData = {
            _id: null,
            itemId: null,
            inwardQcId: router.currentRoute.params.id,
            goodNoteId: null,
            grnItemId: null,
            poItemId: null,
            purchaseOrderId: null,
            poNo: null,
            poDate: forMatIndianDate(),
            itemCode: null,
            itemDescription: null,
            itemDescVendor: null,
            itemAddDescription: null,
            itemDetailDescription: null,
            itemDrowingNo: null,
            itemRev: null,
            itemUom: null,
            purchaseUom: null,
            itemFactor: null,
            grnNo: null,
            grnDate: forMatIndianDate(),
            challanNo: null,
            challanDate: forMatIndianDate(),
            girNo: null,
            girDate: forMatIndianDate(),
            lrNo: null,
            lrDate: null,
            itemMake: null,
            itemStore: null,
            deliveryDate: null,
            location: null,
            indentDate: null,
            itemIndentNo: null,
            poQuantityUm: null,
            pendingQuantityUm: null,
            poQuantityUp: null,
            pendingQuantityUp: null,
            rate: null,
            inspQuantity: null,
            challanQtyUp: null,
            challanQtyUm: null,
            acceptedQuantityUp: null,
            acceptedQuantityUm: null,
            rejectedQuantityUp: 0,
            rejectedQuantityUm: 0,
            hold: null,
            inspactionDate: forMatIndianDate(getTcTodayDate()),
            grnConversion: true,
            heatNo: null,
            quantity: null,
            manufacturedDate: forMatIndianDate(getTcTodayDate()),
            expiredDate: forMatIndianDate(getTcTodayDate()),
            remark: null
        }

        const formData = ref(JSON.parse(JSON.stringify(blankFormData)))

        const resetFormData = () => {
            formData.value = JSON.parse(JSON.stringify(blankFormData))
        }

        const refetchData = async () => {
            isBusy.value = true
            await axios.get(`/api/new/inward-quality-control-items/${router.currentRoute.params.id}`)
                .then(res => {
                    table.value.data = res.data.data
                })
            isBusy.value = false
        }
        refetchData()

        const openModalItem = async () => {
            await axios.post('/api/new/get-grn-item-list', {
                partyId: grnPartyId.value,
                goodNoteId: currentGoodNoteId.value
            })
                .then((res) => {
                    modalTableItemData.value.purchaseItemData = res.data.data
                })
            purchaseItemModal.value.show()
        }

        const editItemDetails = (data) => {
            formData.value = data
        }

        const openTermsAndConditionModal = async () => {
            await axios.get('/api/new/get-po-terms-condition-list-qc/'.concat(formData.value.purchaseOrderId))
                .then((res) => {
                    modalTables.value.termsAndConditionData = res.data.data
                })
            poTermsAndConditionModal.value.show()
        }

        const deleteItemDetails = async (id) => {
            await Swal.fire({
                title: 'Are you sure?',
                text: 'Delete this item',
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
                        store.dispatch('quality-control-store-module/deleteInwardQualityControlItem', { id: id })
                            .then((res) => {
                                if (res.status === 200) {
                                    toast({
                                        component: ToastificationContent,
                                        position: 'top-right',
                                        props: {
                                            title: 'Inward Quality Control Item Deleted',
                                            icon: 'CheckSquareIcon',
                                            variant: 'success',
                                            text: 'You have successfully Deleted Inward Quality Control Item',
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
                            })
                        refetchData()
                    }
                })
        }

        const saveFormData = async () => {
            if (formData.value._id === null) {
                await store.dispatch('quality-control-store-module/addInwardQualityControlItem', formData.value)
                    .then(res => {
                        if (res.status === 200) {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Inward Quality Control Item Added',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: 'You have successfully Added Inward Quality Control Item',
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
                        resetFormData()
                        refetchData()
                    })
                    .catch((error) => {
                        let response = error.response
                        if (response) {
                            let data = response.data
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Warning',
                                    icon: 'AlertCircleIcon',
                                    variant: 'warning',
                                    text: data.message,
                                },
                            })
                        }
                        resetFormData()
                    })
            } else {
                await store.dispatch('quality-control-store-module/updateInwardQualityControlItem', formData.value)
                    .then(res => {
                        if (res.status === 200) {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Inward Quality Control Item Update',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: 'You have successfully Update Inward Quality Control Item',
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
                    })
                    .catch((error) => {
                        let response = error.response
                        if (response) {
                            let data = response.data
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Warning',
                                    icon: 'AlertCircleIcon',
                                    variant: 'warning',
                                    text: data.message,
                                },
                            })
                        }
                    })
                resetFormData()
                await refetchData()
            }
        }

        const {
            refFormObserver,
            getValidationState,
            resetForm
        } = formValidation(resetFormData)

        return {
            formData,
            saveFormData,
            refFormObserver,
            getValidationState,
            resetForm,
            resetFormData,
            isBusy,
            table,
            editItemDetails,
            deleteItemDetails,
            getPoFormatDate,
            dateFormat,
            formatDates,
            purchaseOrderModal,
            isModalTableBusy,
            openModalItem,
            purchaseItemModal,
            modalTableItemData,
            getPurchaseItemDetails,
            uomOPtion,
            purchaseUomOPtion,
            getChallanFormatDate,
            getGirFormatDate,
            getLrFormatDate,
            getIndentFormatDate,
            getDeliveryFormatDate,
            getGrnFormatDate,
            getInspactionFormatDate,
            makeOption,
            storeOption,
            refetchData,
            getMfgFormatDate,
            getExpiredFormatDate,
            poTermsAndConditionModal,
            modalTables,
            openTermsAndConditionModal
        }
    }
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
