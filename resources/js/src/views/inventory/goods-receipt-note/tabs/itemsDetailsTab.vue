<template>
    <div>
        <!--table -->
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
        <!--table Close-->
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
                                <b-input-group class="d-flex">
                                    <b-form-input
                                        v-model="formData.itemCode"
                                        :state="getValidationState(validationContext)"
                                        id="itemCode"
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
                            </b-col>
                        </b-row>
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
                                    @keyup="calculateTimeAmount"
                                    type="number"
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
                                        <b-input-group class="d-flex">
                                            <b-form-input
                                                v-model="formData.girNo"
                                                id="girNo"
                                                :state="getValidationState(validationContext)"
                                            />
                                            <b-input-group-append>
                                                <b-button variant="primary" @click="openGirModal">...</b-button>
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
                                    rules=""
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
                                    name="GRN Date"
                                    rules=""
                                >
                                    <b-form-group
                                        label="GRN Date"
                                        label-for="grnDate"
                                        :state="getValidationState(validationContext)"
                                    >
                                        <b-input-group>
                                            <b-input-group-prepend>
                                                <b-form-datepicker
                                                    v-model="formatDates.grnDate"
                                                    button-only
                                                    @input="getGrnFormatDate($event)"
                                                    show-decade-nav
                                                    size="sm"
                                                    nav-button-variant="primary"
                                                />
                                            </b-input-group-prepend>
                                            <cleave
                                                id="grnDate"
                                                v-model="formData.grnDate"
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
                            <b-col md="6">
                                <validation-provider
                                    #default="validationContext"
                                    name="GRN No"
                                    rules=""
                                >
                                    <b-form-group
                                        label="GRN No"
                                        label-for="grnNo"
                                    >
                                        <b-form-input
                                            v-model="formData.grnNo"
                                            id="grnNo"
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
                                        label-for="challanQuantityUp"
                                    >
                                        <b-form-input
                                            id="challanQuantityUp"
                                            v-model="formData.challanQuantityUp"
                                            :state="getValidationState(validationContext)"
                                            @keyup="calculateTimeAmount"
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
                                    name="Challan Qty UM"
                                    rules="required"
                                >
                                    <b-form-group
                                        label="Challan Qty UM"
                                        label-for="challanQuantityUm"
                                    >
                                        <b-form-input
                                            id="challanQuantityUm"
                                            v-model="formData.challanQuantityUm"
                                            @keyup="calculateTimeAmount"
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
                            <b-col md="6">
                                <validation-provider
                                    #default="validationContext"
                                    name="Actual Qty UP"
                                    rules="required"
                                >
                                    <b-form-group
                                        label="Actual Qty UP"
                                        label-for="actualQuantityUp"
                                    >
                                        <b-form-input
                                            id="actualQuantityUp"
                                            v-model="formData.actualQuantityUp"
                                            :state="getValidationState(validationContext)"
                                            @keyup="calculateTimeAmount"
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
                                    name="Actual Qty UM"
                                    rules="required"
                                >
                                    <b-form-group
                                        label="Actual Qty UM"
                                        label-for="actualQuantityUm"
                                    >
                                        <b-form-input
                                            id="actualQuantityUm"
                                            @keyup="calculateTimeAmount"
                                            v-model="formData.actualQuantityUm"
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

                        <div class="demo-inline-spacing">
                            <b-form-checkbox
                                id="conversion"
                                class="custom-control-primary"
                                v-model="formData.grnConversion"
                            >
                                Conversion..?
                            </b-form-checkbox>
                        </div>
                        <b-button
                            class="float-right"
                            variant="primary"
                        >
                            GRN Report
                        </b-button>
                    </b-col>
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
        <!--Modal-->
        <b-modal
            id="purchaseOrderModal"
            title="Select PO Detail"
            ref="purchaseOrderModal"
            ok-title="submit"
            cancel-variant="danger"
            size="lg"
            no-close-on-backdrop
        >
            <b-table
                :fields="modalTableData.purchaseOrderFields"
                :items="modalTableData.purchaseOrderData"
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
                        @click="getPurchaseOrderDetails(data.item)"
                    >
                        Select

                    </b-button>
                </template>
            </b-table>
        </b-modal>
        <!--Modal-->
        <b-modal
            id="gateInwardReceiptModal"
            title="Select Gate Inward Receipt Detail"
            ref="gateInwardReceiptModal"
            ok-title="submit"
            cancel-variant="danger"
            size="xl"
            no-close-on-backdrop
        >
            <b-table
                :fields="modalTablesData.girFields"
                :items="modalTablesData.girData"
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
                        @click="getGateInwardReceiptModalDetails(data.item)"
                    >
                        Select

                    </b-button>
                </template>
            </b-table>
        </b-modal>
        <!--        modal 3-->
        <!--All Item Modal-->
        <b-modal
            id="purchaseItemModal"
            title="Select Purchase Order Item Detail"
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
    BForm,
    BRow,
    BCol,
    BFormGroup,
    BFormInput,
    BTable,
    BSpinner,
    BDropdown,
    BDropdownItem,
    BInputGroup,
    BInputGroupAppend,
    BButton,
    BFormInvalidFeedback,
    BFormDatepicker,
    BFormTextarea,
    BFormCheckbox,
    BInputGroupPrepend
} from 'bootstrap-vue'
import {onMounted, onUnmounted, ref, computed} from "@vue/composition-api";
import {ValidationObserver, ValidationProvider} from 'vee-validate'
import formValidation from "@core/comp-functions/forms/form-validation";
import {forMatIndianDate, getTcTodayDate} from "@core/utils/utils";
import Cleave from 'vue-cleave-component'
import axios from '@axios'
import vSelect from 'vue-select'
import {useToast} from "vue-toastification/composition";
import inventoryStoreModule from "../../inventoryStoreModule";
import store from '@/store'
import {required} from '@validations'
import router from '@/router'
import ToastificationContent from "@core/components/toastification/ToastificationContent";
import Swal from "sweetalert2";

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
        BInputGroup,
        BInputGroupAppend,
        BButton,
        BFormInvalidFeedback,
        Cleave,
        BFormDatepicker,
        vSelect,
        BFormTextarea,
        BFormCheckbox,
        BInputGroupPrepend
    },
    props: {
        partyId: {
            required: true
        },
    },
    setup(props, {gateInwardReceiptModal, purchaseOrderModal, purchaseItemModal}) {
        const ITEMADDON_APP_STORE_MODULE_NAME = 'inventory-store-module'
        onMounted(() => {
            if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, inventoryStoreModule)
        });
        onUnmounted(() => {
            if (store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.unregisterModule(ITEMADDON_APP_STORE_MODULE_NAME)
        });

        const currentPartyId = computed(() => props.partyId)

        gateInwardReceiptModal = ref()
        purchaseOrderModal = ref()
        purchaseItemModal = ref()
        const toast = useToast()

        const isModalTableBusy = ref(false)

        const uomOPtion = ref([])
        axios.get("/api/get-uom-master-options").then((res) => {
            uomOPtion.value = res.data.data;
        });

        const purchaseUomOPtion = ref([])
        axios.get("/api/get-uom-master-options").then((res) => {
            purchaseUomOPtion.value = res.data.data;
        });

        const makeOption = ref([]);
        axios.get('/api/get-item-make-master-options').then(res => {
            makeOption.value = res.data.data
        });

        const storeOption = ref([]);
        axios.get("/api/get-store-master-options").then((res) => {
            storeOption.value = res.data.data;
        });

        const isBusy = ref(false)
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
                    key: 'item_name.itemCode',
                    label: 'Item Code'
                },
                {
                    key: 'itemDescription',
                    label: 'Item Description'
                },
                {
                    key: 'itemDeliveryDate',
                    label: 'Delivery Date'
                },
                {
                    key: 'itemQuantityUm',
                    label: 'PO Qty'
                },
                {
                    key: 'pendingQtyUm',
                    label: 'Prnding PO Qty'
                },
            ],
            purchaseItemData: [],
        })
        const modalTablesData = ref({
            girFields: [
                {
                    key: 'selectButton',
                    label: ''
                },
                {
                    key: 'girNo',
                    label: 'GIR No'
                },
                {
                    key: 'girDate',
                    label: 'GIR Date'
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
                    key: 'invoiceNo',
                    label: 'Invoice No'
                },
                {
                    key: 'invoiceDate',
                    label: 'Invoice Date'
                },
            ],
            girData: [],
        })
        const modalTableData = ref({
            purchaseOrderFields: [
                {
                    key: 'selectButton',
                    label: ''
                },
                {
                    key: 'poNumber',
                    label: 'PO No'
                },
                {
                    key: 'poDate',
                    label: 'PO Date'
                },
            ],
            purchaseOrderData: [],
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
        })

        const calculateTimeAmount = () => {
            if (formData.value.grnConversion === true) {
                formData.value.actualQuantityUp = formData.value.itemFactor * formData.value.challanQuantityUp
                formData.value.actualQuantityUm = formData.value.itemFactor * formData.value.challanQuantityUm
            }else {
              formData.value.actualQuantityUp = formData.value.challanQuantityUp
              formData.value.actualQuantityUm = formData.value.challanQuantityUm
            }
            formData.value.inspQuantity = formData.value.actualQuantityUp
        }

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

        const openGirModal = async () => {
            axios.get(`/api/new/get-gir-party-wise/${currentPartyId.value}`).then(res => {
                modalTablesData.value.girData = res.data.data
            })
            gateInwardReceiptModal.value.show();
        }
        const getGateInwardReceiptModalDetails = async (data) => {
            formData.value.challanNo = data.challanNo
            formData.value.challanDate = data.challanDate
            formData.value.girNo = data.girNo
            formData.value.girDate = data.girDate
            gateInwardReceiptModal.value.hide();
        }

        const openModalItem = async () => {
            await axios.get('/api/new/get-purchase-order-item-list/'.concat(formData.value.purchaseOrderId)).then((res) => {
                modalTableItemData.value.purchaseItemData = res.data.data
            });
            purchaseItemModal.value.show();
        }

        const getPurchaseItemDetails = async (data) => {

            formData.value.itemCode = data?.item_name?.itemCode ?? null
            formData.value.itemDescription = data.itemDescription
            formData.value.itemDescVendor = data.itemDescVendor
            formData.value.itemAddDescription = data.itemAddDescription
            formData.value.itemDetailDescription = data.itemDetailDescription
            formData.value.itemDrowingNo = data.itemDrowingNo
            formData.value.itemRev = data.itemRev
            formData.value.itemUom = data.itemUom
            formData.value.purchaseUom = data.itemUom
            formData.value.itemFactor = data.itemFactor
            formData.value.itemMake = data.itemMake
            formData.value.itemStore = data.itemStore
            formData.value.location = data?.item_name?.generalData?.location ?? null
            formData.value.deliveryDate = data.itemDeliveryDate
            formData.value.itemIndentNo = data.itemIndentNo
            formData.value.indentDate = data.itemIndentDate
            formData.value.poQuantityUm = data.itemQuantityUm
            formData.value.poQuantityUp = data.itemQuantityUp
            formData.value.pendingQuantityUm = data.pendingQtyUm
            formData.value.pendingQuantityUp = data.pendingQtyUp
            formData.value.challanQuantityUp = data.pendingQtyUp
            formData.value.challanQuantityUm = data.pendingQtyUm
            calculateTimeAmount()
            formData.value.rate = data.itemRate
            formData.value.poItemId = data._id
            formData.value.purchaseOrderId = data.purchaseOrderId
            formData.value.itemId = data.itemId
            purchaseItemModal.value.hide();
        }

        const openModal = async () => {
            axios.get(`/api/get-purchase-order-by-party/${currentPartyId.value}`).then((res) => {
                modalTableData.value.purchaseOrderData = res.data.data
            });
            purchaseOrderModal.value.show();
        }

        const getPurchaseOrderDetails = async (data) => {
            formData.value.purchaseOrderId = data._id
            formData.value.poNo = data.poNumber
            formData.value.poDate = data.poDate
            purchaseOrderModal.value.hide();
        }

        const blankFormData = {
            _id: null,
            itemId:null,
            goodNoteId: router.currentRoute.params.id,
            poItemId: null,
            purchaseOrderId: null,
            partyCode: null,
            partyName: null,
            poNo: null,
            poDate: forMatIndianDate(getTcTodayDate()),
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
            challanNo: null,
            challanDate: forMatIndianDate(getTcTodayDate()),
            girNo: null,
            girDate: forMatIndianDate(getTcTodayDate()),
            lrNo: null,
            lrDate: forMatIndianDate(),
            itemMake: null,
            itemStore: null,
            location: null,
            deliveryDate: forMatIndianDate(getTcTodayDate()),
            itemIndentNo: null,
            indentDate: forMatIndianDate(getTcTodayDate()),
            poQuantityUm: null,
            pendingQuantityUm: null,
            poQuantityUp: null,
            pendingQuantityUp: null,
            rate: null,
            inspQuantity: null,
            grnNo: null,
            grnDate: forMatIndianDate(getTcTodayDate()),
            challanQuantityUp: null,
            challanQuantityUm: null,
            actualQuantityUp: null,
            actualQuantityUm: null,
            grnConversion: true,
        }
        const formData = ref(JSON.parse(JSON.stringify(blankFormData)))

        const resetFormData = () => {
            formData.value = JSON.parse(JSON.stringify(blankFormData))
        }
        const refetchData = async () => {
            isBusy.value = true
            await axios.get(`/api/new/goods-receipt-note-items/${router.currentRoute.params.id}`).then(res => {
                table.value.data = res.data.data
            })
            isBusy.value = false
        }
        refetchData()
        const editItemDetails = (data) => {
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
                    store.dispatch('inventory-store-module/deleteGoodsReceiptNoteItem', {id: id}).then((res) => {
                        if (res.status === 200) {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Good Receipt Note Item Deleted',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: 'You have successfully Deleted Good Receipt Note Item',
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
                await store.dispatch('inventory-store-module/addGoodsReceiptNoteItem', formData.value).then((res) => {
                    if (res.status === 200) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Goods Receipt Note Item Added',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: 'You have successfully Added Goods Receipt Note Item',
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
                }).catch((error) => {
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
            } else {
                await store.dispatch('inventory-store-module/updateGoodsReceiptNoteItem', formData.value).then((res) => {
                    if (res.status === 200) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Goods Receipt Note Item Updated',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: 'You have successfully Updated Goods Receipt Note Item',
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
            }
            resetFormData();
            await refetchData()
        }

        const {
            refFormObserver,
            getValidationState,
            resetForm
        } = formValidation(resetFormData)

        return {
            isBusy,
            table,
            saveFormData,
            openModal,
            dateFormat,
            formatDates,
            formData,
            resetFormData,
            resetForm,
            refFormObserver,
            getValidationState,
            // itemCodeOption,
            uomOPtion,
            purchaseUomOPtion,
            openGirModal,
            getPoFormatDate,
            getGirFormatDate,
            getLrFormatDate,
            getChallanFormatDate,
            getDeliveryFormatDate,
            getIndentFormatDate,
            getGrnFormatDate,
            makeOption,
            storeOption,
            calculateTimeAmount,
            purchaseOrderModal,
            gateInwardReceiptModal,
            modalTablesData,
            modalTableData,
            getGateInwardReceiptModalDetails,
            getPurchaseOrderDetails,
            isModalTableBusy,
            openModalItem,
            purchaseItemModal,
            modalTableItemData,
            getPurchaseItemDetails,
            editItemDetails,
            deleteItemDetails,
            refetchData,
            required,
        }
    }
}
</script>
