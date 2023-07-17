<template>
    <div>
        <b-row>
            <b-col md="12">
                <hr>
                <b-table
                    :fields="itemsField"
                    :items="itemsData"
                    :bordered="true"
                    :hover="true"
                    class="mb-0 table_scroll"
                    :busy="isBusy"
                    show-empty
                    responsive
                    selectable
                    select-mode="single"
                    @row-selected="onRowSelect"
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

                    <template #cell(itemStatus)="data">
                       <span v-for="status in statusOptions">
                           <span v-if="status.value === data.item.itemStatus">
                               {{ status.label }}
                           </span>
                       </span>
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
                            <b-dropdown-item v-if="data.item.itemType === 'A'" @click="openItem(data.item)">
                                <feather-icon
                                    icon="CheckSquareIcon"
                                    class="mr-50"
                                />
                                <span>View</span>
                            </b-dropdown-item>
                            <b-dropdown-item @click="deleteItem(data.item._id)">
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
                <hr>
            </b-col>
        </b-row>
        <validation-observer ref="simpleRules" #default="{ handleSubmit }">
            <b-form @submit.prevent="handleSubmit(checkBomExist)">
                <b-row>
                    <b-col md="4">
                        <validation-provider
                            #default="{ errors }"
                            name="Type"
                            rules="required"
                        >
                            <b-form-group
                                label="Type"
                                label-for="itemType"
                                :state="errors.length > 0 ? false : null"
                            >
                                <v-select
                                    placeholder="Select Item Type"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="itemTypeOptions"
                                    :reduce="val => val.value"
                                    :clearable="false"
                                    input-id="itemType"
                                    v-model="formData.itemType"
                                    :disabled="isTypeDisabled"
                                />
                                <small class="text-danger">{{ errors[0] }}</small>
                            </b-form-group>
                        </validation-provider>
                        <validation-provider
                            #default="{ errors }"
                            name="Item Code"
                            rules="required"
                        >
                            <b-form-group
                                label="Item Code"
                                label-for="itemList"
                                :state="errors.length > 0 ? false : null"
                            >
                                <v-select
                                    placeholder="Select Item"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="itemListOptions"
                                    :reduce="val => val.value"
                                    :clearable="false"
                                    input-id="itemList"
                                    v-model="formData.itemCode"
                                    :disabled="isItemCodeDisabled"
                                    @input="getItemDetails($event)"
                                />
                                <small class="text-danger">{{ errors[0] }}</small>
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
                                :state="getValidationState(validationContext)"
                            >
                                <b-form-input
                                    id="itemDescription"
                                    :state="getValidationState(validationContext)"
                                    v-model="formData.itemDescription"
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
                                label-for="itemAddDescription"
                                :state="getValidationState(validationContext)"
                            >
                                <b-form-input
                                    id="itemAddDescription"
                                    :state="getValidationState(validationContext)"
                                    v-model="formData.itemAddDescription"
                                />
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                        <validation-provider
                            #default="validationContext"
                            name="Drawing Number"
                            rules=""
                        >
                            <b-form-group
                                label="Drawing Number"
                                label-for="itemDrawingNumber"
                                :state="getValidationState(validationContext)"
                            >
                                <b-form-input
                                    id="itemDrawingNumber"
                                    :state="getValidationState(validationContext)"
                                    v-model="formData.itemDrawingNumber"
                                />
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>

                        <validation-provider
                            #default="validationContext"
                            name="BOM Qty"
                            rules=""
                        >
                            <b-form-group
                                label="BOM Qty"
                                label-for="itemBomQty"
                                :state="getValidationState(validationContext)"
                            >
                                <b-form-input
                                    id="itemBomQty"
                                    :state="getValidationState(validationContext)"
                                    v-model="formData.itemBomQty"
                                    @keyup="getBomQtyData"
                                />
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                        <validation-provider
                            #default="validationContext"
                            name="BOM Qty (Conv)"
                            rules=""
                        >
                            <b-form-group
                                label="BOM Qty (Conv)"
                                label-for="itemBomQtyConv"
                                :state="getValidationState(validationContext)"
                            >
                                <b-form-input
                                    id="itemBomQtyConv"
                                    :state="getValidationState(validationContext)"
                                    v-model="formData.itemBomQtyConv"
                                />
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                        <validation-provider
                            #default="validationContext"
                            name="Conv. Factor"
                            rules=""
                        >
                            <b-form-group
                                label="Conv. Factor"
                                label-for="itemConvFactor"
                                :state="getValidationState(validationContext)"
                            >
                                <b-form-input
                                    id="itemConvFactor"
                                    :state="getValidationState(validationContext)"
                                    v-model="formData.itemConvFactor"
                                />
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                        <validation-provider
                            #default="validationContext"
                            name="UOM"
                            rules=""
                        >
                            <b-form-group
                                label="UOM"
                                label-for="itemUom"
                                :state="getValidationState(validationContext)"
                            >
                                <v-select
                                    placeholder="Select UOM"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="uomOptions"
                                    :reduce="val => val.value"
                                    :clearable="false"
                                    input-id="uom"
                                    v-model="formData.itemUom"
                                    :state="getValidationState(validationContext)"
                                    disabled
                                />
                                <!--<b-form-input
                                    id="itemUom"
                                    :state="getValidationState(validationContext)"
                                    v-model="formData.itemUom"
                                    disabled
                                />-->
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                        <validation-provider
                            #default="{ errors }"
                            name="Conv. UOM"
                            rules="required"
                        >
                            <b-form-group
                                label="Conv. UOM"
                                label-for="convUom"
                                :state="errors.length > 0 ? false : null"
                            >
                                <v-select
                                    placeholder="Select Item"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="uomOptions"
                                    :reduce="val => val.value"
                                    :clearable="false"
                                    input-id="convUom"
                                    v-model="formData.itemConvUom"
                                />
                                <small class="text-danger">{{ errors[0] }}</small>
                            </b-form-group>
                        </validation-provider>
                        <validation-provider
                            #default="validationContext"
                            name="Conv. Qty"
                            rules=""
                        >
                            <b-form-group
                                label="Conv. Qty"
                                label-for="convUomQty"
                                :state="getValidationState(validationContext)"
                            >
                                <b-form-input
                                    id="convUomQty"
                                    :state="getValidationState(validationContext)"
                                    v-model="formData.itemConvQty"
                                />
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                        <validation-provider
                            #default="validationContext"
                            name="Req Qty"
                            rules=""
                        >
                            <b-form-group
                                label="Req Qty"
                                label-for="reqQty"
                                :state="getValidationState(validationContext)"
                            >
                                <b-form-input
                                    id="reqQty"
                                    :state="getValidationState(validationContext)"
                                    v-model="formData.itemReqQty"
                                />
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                        <validation-provider
                            #default="validationContext"
                            name="Req Qty (Conv)"
                            rules=""
                        >
                            <b-form-group
                                label="Req Qty (Conv)"
                                label-for="reqQtyConv"
                                :state="getValidationState(validationContext)"
                            >
                                <b-form-input
                                    id="reqQtyConv"
                                    :state="getValidationState(validationContext)"
                                    v-model="formData.itemReqQtyConv"
                                />
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                    </b-col>
                    <b-col md="4">
                        <validation-provider
                            #default="{ errors }"
                            name="Material Process Type"
                            rules=""
                        >
                            <b-form-group
                                label="Material Process Type"
                                label-for="materialProcessType"
                                :state="errors.length > 0 ? false : null"
                            >
                                <v-select
                                    placeholder="Select Item"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="materialProcessOptions"
                                    :reduce="val => val.value"
                                    :clearable="false"
                                    input-id="materialProcessType"
                                    v-model="formData.itemMaterialProcessType"
                                    disabled
                                />
                                <small class="text-danger">{{ errors[0] }}</small>
                            </b-form-group>
                        </validation-provider>
                        <validation-provider
                            #default="validationContext"
                            name="Assb. BOM No."
                            rules=""
                        >
                            <b-form-group
                                label="Assb. BOM No."
                                label-for="itemAssemblyBomNumber"
                                :state="getValidationState(validationContext)"
                            >
                                <b-form-input
                                    id="itemAssemblyBomNumber"
                                    :state="getValidationState(validationContext)"
                                    disabled
                                    v-model="formData.itemAssemblyBomNumber"
                                />
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                        <validation-provider
                            #default="validationContext"
                            name="Note"
                            rules=""
                        >
                            <b-form-group
                                label="Note"
                                label-for="itemNote"
                                :state="getValidationState(validationContext)"
                            >
                                <b-form-textarea
                                    id="itemNote"
                                    :state="getValidationState(validationContext)"
                                    v-model="formData.itemNote"
                                    rows="3"
                                />
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                        <validation-provider
                            #default="validationContext"
                            name="Detail Desc"
                            rules=""
                        >
                            <b-form-group
                                label="Detail Desc"
                                label-for="itemDetailDescription"
                                :state="getValidationState(validationContext)"
                            >
                                <b-form-textarea
                                    id="itemDetailDescription"
                                    :state="getValidationState(validationContext)"
                                    rows="3"
                                    v-model="formData.itemDetailDescription"
                                />
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                        <validation-provider
                            #default="validationContext"
                            name="Curr Stock"
                            rules=""
                        >
                            <b-form-group
                                label="Curr Stock"
                                label-for="itemCurrentStock"
                                :state="getValidationState(validationContext)"
                            >
                                <b-form-input
                                    id="itemCurrentStock"
                                    :state="getValidationState(validationContext)"
                                    v-model="formData.itemCurrentStock"
                                />
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                        <validation-provider
                            #default="validationContext"
                            name="Position No."
                            rules=""
                        >
                            <b-form-group
                                label="Position No."
                                label-for="itemPositionNumber"
                                :state="getValidationState(validationContext)"
                            >
                                <b-form-input
                                    id="itemPositionNumber"
                                    :state="getValidationState(validationContext)"
                                    v-model="formData.itemPositionNumber"
                                />
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                        <validation-provider
                            #default="validationContext"
                            name="Rev"
                            rules=""
                        >
                            <b-form-group
                                label="Rev"
                                label-for="itemDrawingRev"
                                :state="getValidationState(validationContext)"
                            >
                                <b-form-input
                                    id="itemDrawingRev"
                                    :state="getValidationState(validationContext)"
                                    v-model="formData.itemRevision"
                                />
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                        <validation-provider
                            #default="{ errors }"
                            name="Issue At Process"
                            rules=""
                        >
                            <b-form-group
                                label="Issue At Process"
                                label-for="itemIssueAtProcess"
                                :state="errors.length > 0 ? false : null"
                            >
                                <v-select
                                    id="itemIssueAtProcess"
                                    v-model="formData.itemIssueAtProcess"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="processOptions"
                                    :clearable="false"
                                    :reduce="val => val.value"
                                    :state="errors.length > 0 ? false : null"
                                    placeholder="select Issue"
                                />
                                <small class="text-danger">{{ errors[0] }}</small>
                            </b-form-group>
                        </validation-provider>
                        <validation-provider
                            #default="{ errors }"
                            name="Make"
                            rules=""
                        >
                            <b-form-group
                                label="Make"
                                label-for="itemMake"
                                :state="errors.length > 0 ? false : null"
                            >
                                <v-select
                                    id="itemMake"
                                    v-model="formData.itemMake"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="makeOptions"
                                    :clearable="false"
                                    :reduce="val => val.value"
                                    :state="errors.length > 0 ? false : null"
                                    placeholder="select Make"
                                />
                                <small class="text-danger">{{ errors[0] }}</small>
                            </b-form-group>
                        </validation-provider>
                        <validation-provider
                            #default="{ errors }"
                            name="Store"
                            rules=""
                        >
                            <b-form-group
                                label="Store"
                                label-for="itemStore"
                                :state="errors.length > 0 ? false : null"
                            >
                                <v-select
                                    id="itemStore"
                                    v-model="formData.itemStore"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="storeOptions"
                                    :clearable="false"
                                    multiple
                                    taggable
                                    push-tags
                                    :reduce="val => val.value"
                                    :state="errors.length > 0 ? false : null"
                                    placeholder="select Store"
                                />
                                <small class="text-danger">{{ errors[0] }}</small>
                            </b-form-group>
                        </validation-provider>
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
                                    :reduce="val => val.label"
                                    :clearable="false"
                                    input-id="status"
                                    v-model="formData.itemStatus"
                                    :state="getValidationState(validationContext)"
                                />
                            </b-form-group>
                        </validation-provider>
                    </b-col>
                    <b-col md="4">
                        <h5>Material Description</h5>
                        <hr>
                        <validation-provider
                            #default="validationContext"
                            name=""
                            rules=""
                        >
                            <b-form-group
                                label=""
                                label-for="itemMaterial1"
                                :state="getValidationState(validationContext)"
                            >
                                <b-form-input
                                    id="itemMaterial1"
                                    :state="getValidationState(validationContext)"
                                    v-model="formData.itemMaterialInput1"
                                />
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                        <validation-provider
                            #default="validationContext"
                            name=""
                            rules=""
                        >
                            <b-form-group
                                label=""
                                label-for="itemMaterial2"
                                :state="getValidationState(validationContext)"
                            >
                                <b-form-input
                                    id="itemMaterial2"
                                    :state="getValidationState(validationContext)"
                                    v-model="formData.itemMaterialInput2"
                                />
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                        <validation-provider
                            #default="validationContext"
                            name="Len(mm)"
                            rules=""
                        >
                            <b-form-group
                                label="Len(mm)"
                                label-for="itemMaterialLen"
                                :state="getValidationState(validationContext)"
                            >
                                <b-form-input
                                    id="itemMaterialLen"
                                    :state="getValidationState(validationContext)"
                                    v-model="formData.itemMaterialLenght"
                                />
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                        <validation-provider
                            #default="validationContext"
                            name="Qty(Nos.)"
                            rules=""
                        >
                            <b-form-group
                                label="Qty(Nos.)"
                                label-for="itemMaterialQty"
                                :state="getValidationState(validationContext)"
                            >
                                <b-form-input
                                    id="itemMaterialQty"
                                    :state="getValidationState(validationContext)"
                                    v-model="formData.itemMaterialQty"
                                />
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                        <validation-provider
                            #default="validationContext"
                            name="Weight(kg)"
                            rules=""
                        >
                            <b-form-group
                                label="Weight(kg)"
                                label-for="itemMaterialWeight"
                                :state="getValidationState(validationContext)"
                            >
                                <b-form-input
                                    id="itemMaterialWeight"
                                    :state="getValidationState(validationContext)"
                                    v-model="formData.itemMaterialWeight"
                                />
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                        <validation-provider
                            #default="validationContext"
                            name="Location"
                            rules=""
                        >
                            <b-form-group
                                label="Location"
                                label-for="itemLocation"
                                :state="getValidationState(validationContext)"
                            >
                                <b-form-input
                                    id="itemLocation"
                                    :state="getValidationState(validationContext)"
                                    v-model="formData.itemLocation"
                                />
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                        <validation-provider
                            #default="validationContext"
                            name="Bin No"
                            rules=""
                        >
                            <b-form-group
                                label="Bin No"
                                label-for="itemBinNumber"
                                :state="getValidationState(validationContext)"
                            >
                                <b-form-input
                                    id="itemBinNumber"
                                    :state="getValidationState(validationContext)"
                                    v-model="formData.itemBinNumber"
                                />
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                        <br>
                        <b-form-checkbox
                            id="onlyAlternateItem"
                            class="custom-control-primary"
                            v-model="formData.onlyAlternateItem"
                        >
                            Only Alternate Item
                        </b-form-checkbox>
                        <br>
                        <b-form-checkbox
                            id="onlyAlternateItemFromBom"
                            class="custom-control-primary"
                            v-model="formData.onlyAlternateItemFromBom"
                        >
                            Only Alternate Item From BOM
                        </b-form-checkbox>
                        <br>
                        <b-form-checkbox
                            id="isPrint"
                            class="custom-control-primary"
                            v-model="formData.isPrint"
                        >
                            Is Print..?
                        </b-form-checkbox>
                    </b-col>
                    <b-col md="12">
                        <b-button
                            class="float-left mr-1"
                            variant="primary"
                        >
                            Transaction History
                        </b-button>
                        <b-button
                            class="float-left mr-1"
                            variant="primary"
                        >
                            Stock Allocation
                        </b-button>
                        <b-button
                            class="float-left mr-1"
                            variant="primary"
                        >
                            Show Issue Item Details
                        </b-button>
                        <b-button
                            class="float-left    mr-1"
                            variant="primary"
                        >
                            Generate Stock Allocation
                        </b-button>
                    </b-col>
                    <b-col md="12">
                        <hr>
                        <b-button
                            variant="primary"
                            type="submit"
                            class="float-right mr-1"
                            :disabled="isButtonDisabled"
                        >
                            {{ buttonText }}
                        </b-button>
                        <b-button
                            class="float-right mr-1"
                            variant="primary"
                        >
                            Item Document
                        </b-button>
                    </b-col>
                </b-row>
            </b-form>
        </validation-observer>

        <!-- Confirmation Modal / confirmationModal-->

        <b-modal
            id="confirmationModal"
            size="lg"
            title="Select BOM Version"
            ref="confirmationModal"
            centered
            scrollable
            no-close-on-esc
            no-close-on-backdrop
            hide-footer
            hide-header-close
        >
            <b-table
                responsive="sm"
                :fields="modalField"
                :items="modalData"
                :bordered="true"
                :hover="true"
                show-empty
                class="table_scroll"
            >
                <!-- Index -->
                <template #cell(selectButton)="data">
                    <b-button
                        variant="primary"
                        size="sm"
                        type="button"
                        @click="selectBomVersion(data.item)"
                    >
                        SELECT
                    </b-button>
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
        BOverlay,
        BDropdown,
        BDropdownItem,
    } from 'bootstrap-vue'
    import {required} from '@validations'
    import Ripple from 'vue-ripple-directive'
    import vSelect from 'vue-select'
    import store from '@/store'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import {ValidationProvider, ValidationObserver} from 'vee-validate'
    import formValidation from '@core/comp-functions/forms/form-validation'
    import {ref, onUnmounted} from '@vue/composition-api'
    import axios from '@axios'
    import {getUserData} from '../../../../auth/utils'
    import moment from 'moment'
    import {getTcTodayDate, getSalesTypeListOption} from '@core/utils/utils'
    import productionPlanningStoreModule from '../../productionPlanningStoreModule'
    import {useToast} from 'vue-toastification/composition'
    import router from '@/router'
    import Swal from 'sweetalert2'

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
            BOverlay,
            BSpinner,
            BDropdown,
            BDropdownItem,
            vSelect
        },
        directives: {
            Ripple,
        },
        setup({confirmationModal}) {
            const ITEMADDON_APP_STORE_MODULE_NAME = 'production-planning'
            if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, productionPlanningStoreModule)
            onUnmounted(() => {
                if (store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.unregisterModule(ITEMADDON_APP_STORE_MODULE_NAME)
            })

            const toast = useToast()
            const isBusy = ref(true)
            const buttonText = ref('Save')
            const isButtonDisabled = ref(false)
            const isTypeDisabled = ref(false)
            const isItemCodeDisabled = ref(false)

            confirmationModal = ref()

            const itemsField = ref([
                {
                    key: 'rowSelected',
                    label: ''
                },
                {
                    key: 'index',
                    label: 'no'
                },
                {
                    key: 'item_name.itemCode',
                    label: 'Item Code'
                },
                {
                    key: 'itemDescription',
                    label: 'Description'
                },
                {
                    key: 'itemBomQty',
                    label: 'BOM Qty'
                },
                {
                    key: 'itemReqQty',
                    label: 'Req Qty'
                },
                {
                    key: 'itemIssueQty',
                    label: 'Issue Qty'
                },
                {
                    key: 'itemPendingQty',
                    label: 'Pend Qty'
                },
                {
                    key: 'itemStatus',
                    label: 'Status'
                },
                {
                    key: 'itemDrawingNumber',
                    label: 'DrawingNo'
                },
                {
                    key: 'scQty',
                    label: 'SC Qty'
                },
                {
                    key: 'action',
                    label: 'action'
                },
            ])
            const itemsData = ref([])

            const refetchData = async () => {
                isBusy.value = true
                await axios.get(`/api/work-order-item-list/${router.currentRoute.params.id}`)
                    .then(res => {
                        itemsData.value = res.data.data
                    })
                isBusy.value = false
            }
            refetchData()

            const itemTypeOptions = ref([
                {
                    label: 'A',
                    value: 'A'
                },
                {
                    label: 'I',
                    value: 'I'
                },
            ])

            const itemListOptions = ref([])
            axios.get('/api/get-item-master-options')
                .then(res => {
                    itemListOptions.value = res.data.data
                })

            const uomOptions = ref([])
            axios.get('/api/get-uom-master-options')
                .then(res => {
                    uomOptions.value = res.data.data
                })

            const materialProcessOptions = ref([
                {
                    label: 'Process-in-House',
                    value: 1
                },
                {
                    label: 'Procured',
                    value: 2
                },
                {
                    label: 'Sub-Contracting',
                    value: 3
                },
            ])

            const makeOptions = ref([])
            axios.get('/api/get-item-make-master-options')
                .then(res => {
                    makeOptions.value = res.data.data
                })

            const storeOptions = ref([])
            axios.get('/api/get-store-master-options')
                .then(res => {
                    storeOptions.value = res.data.data
                })

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

            const processOptions = ref([])
            axios.get('/api/get-process-master-option')
                .then(res => {
                    processOptions.value = res.data.data
                })

            const blankFormData = {
                id: null,
                woId: router.currentRoute.params.id,
                itemType: null,
                itemCode: null,
                itemDescription: null,
                itemAddDescription: null,
                itemDrawingNumber: null,
                itemBomQty: null,
                itemBomQtyConv: null,
                itemConvFactor: null,
                itemUom: null,
                itemConvUom: null,
                itemConvQty: null,
                itemMaterialProcessType: null,
                itemNote: null,
                itemDetailDescription: null,
                itemCurrentStock: null,
                itemPositionNumber: null,
                itemRevision: null,
                itemIssueAtProcess: null,
                itemMake: null,
                itemStore: null,
                itemMaterialInput1: null,
                itemMaterialInput2: null,
                itemMaterialLenght: null,
                itemMaterialQty: null,
                itemMaterialWeight: null,
                itemReqQty: null,
                itemReqQtyConv: null,
                itemPendingQty: null,
                itemPendingQtyConv: null,
                itemIssueQty: 0,
                itemIssueQtyConv: 0,
                itemLocation: null,
                itemBinNumber: null,
                assemblyCopy: null,
                itemAssemblyBomNumber: null,
                itemStatus: 1,
                onlyAlternateItem: true,
                onlyAlternateItemFromBom: null,
                isPrint: null
            }

            const formData = ref(JSON.parse(JSON.stringify(blankFormData)))

            const resetFormData = () => {
                formData.value = JSON.parse(JSON.stringify(blankFormData))
            }

            const getItemDetails = async (id) => {
                await axios.get(`/api/item-master/${id}`)
                    .then(res => {
                        isTypeDisabled.value = true
                        if (res.data.data.materialProcessType === 2) {
                            formData.value.itemType = 'I'
                        } else {
                            formData.value.itemType = 'A'
                        }
                        formData.value.itemUom = res.data.data.uom_details.uom ?? null
                        formData.value.itemDescription = res.data.data.itemDescription
                        formData.value.itemConvUom = res.data.data.convUom
                        formData.value.itemAddDescription = res.data.data?.itemDetails?.description ?? null
                        formData.value.itemDetailDescription = res.data.data?.itemDetails?.detailDescription ?? null
                        formData.value.itemDrawingNumber = res.data.data?.itemDetails?.drawingNumber ?? null
                        formData.value.itemRevision = res.data.data?.itemDetails?.revision ?? null
                        formData.value.itemMake = res.data.data.make ?? []
                        formData.value.itemConvQty = res.data.data.convQty
                        formData.value.itemMaterialProcessType = res.data.data.materialProcessType
                        formData.value.itemConvFactor = res.data.data.cFactor
                        formData.value.itemNote = res.data.data?.itemDetails?.remarkNote ?? null
                    })
            }

            const modalField = ref([
                {
                    label: '',
                    key: 'selectButton'
                },
                {
                    label: 'BOM No.',
                    key: 'bomNumber'
                },
                {
                    label: 'Version',
                    key: 'bomVersion'
                },
                {
                    label: 'BOM Description',
                    key: 'bomDescription'
                }
            ])
            const modalData = ref([])

            const checkBomExist = async () => {
                if (formData.value.id === null) {
                    formData.value.bomVersionIds = []
                    await axios.get(`/api/is-bom-exist/${formData.value.itemCode}`)
                        .then(res => {
                            if (res.data.data) {
                                modalData.value = res.data.item.bom_version
                                confirmationModal.value.show()
                            } else {
                                submitFormData()
                            }
                        })
                } else {
                    await submitFormData()
                }
            }

            const submitStatus = (status) => {
                formData.value.bomItemCopy = status
                submitFormData()
            }

            const openItem = async (data) => {
                if (data._id) {
                    await router.push({
                        name: 'work-order-item-details',
                        params: {
                            id: router.currentRoute.params.id,
                            assemblyId: data._id
                        }
                    })
                } else {
                    await router.push({
                        name: 'work-order-item-details',
                        params: {
                            id: router.currentRoute.params.id,
                            assemblyId: data.id
                        }
                    })
                }
            }

            const onRowSelect = (items) => {
                if (items.length > 0) {
                    isTypeDisabled.value = true
                    isItemCodeDisabled.value = true
                    formData.value.id = items[0]._id
                    formData.value.itemType = items[0].itemType ?? null
                    formData.value.itemCode = items[0].itemCode ?? null
                    formData.value.itemDescription = items[0].itemDescription ?? null
                    formData.value.itemAddDescription = items[0].itemAddDescription ?? null
                    formData.value.itemDrawingNumber = items[0].itemDrawingNumber ?? null
                    formData.value.itemBomQty = items[0].itemBomQty ?? null
                    formData.value.itemBomQtyConv = items[0].itemBomQtyConv ?? null
                    formData.value.itemConvFactor = items[0].itemConvFactor ?? null
                    formData.value.itemUom = items[0].itemUom ?? null
                    formData.value.itemConvUom = items[0].itemConvUom ?? null
                    formData.value.itemConvQty = items[0].itemConvQty ?? null
                    formData.value.itemMaterialProcessType = items[0].itemMaterialProcessType ?? null
                    formData.value.itemNote = items[0].itemNote ?? null
                    formData.value.itemDetailDescription = items[0].itemDetailDescription ?? null
                    formData.value.itemCurrentStock = items[0].itemCurrentStock ?? null
                    formData.value.itemPositionNumber = items[0].itemPositionNumber ?? null
                    formData.value.itemRevision = items[0].itemRevision ?? null
                    formData.value.itemIssueAtProcess = items[0].itemIssueAtProcess ?? null
                    formData.value.itemMake = items[0].itemMake ?? null
                    formData.value.itemStore = items[0].itemStore ?? null
                    formData.value.itemMaterialInput1 = items[0].itemMaterialInput1 ?? null
                    formData.value.itemMaterialInput2 = items[0].itemMaterialInput2 ?? null
                    formData.value.itemMaterialLenght = items[0].itemMaterialLenght ?? null
                    formData.value.itemMaterialQty = items[0].itemMaterialQty ?? null
                    formData.value.itemMaterialWeight = items[0].itemMaterialWeight ?? null
                    formData.value.itemReqQty = items[0].itemReqQty ?? null
                    formData.value.itemReqQtyConv = items[0].itemReqQtyConv ?? null
                    formData.value.itemPendingQty = items[0].itemPendingQty ?? null
                    formData.value.itemPendingQtyConv = items[0].itemPendingQtyConv ?? null
                    formData.value.itemIssueQty = items[0].itemIssueQty ?? null
                    formData.value.itemIssueQtyConv = items[0].itemIssueQtyConv ?? null
                    formData.value.itemLocation = items[0].itemLocation ?? null
                    formData.value.itemBinNumber = items[0].itemBinNumber ?? null
                    formData.value.assemblyCopy = items[0].assemblyCopy ?? null
                    formData.value.itemAssemblyBomNumber = items[0].itemAssemblyBomNumber ?? null
                    formData.value.itemStatus = items[0].itemStatus ?? null
                    formData.value.onlyAlternateItem = items[0].onlyAlternateItem ?? null
                    formData.value.onlyAlternateItemFromBom = items[0].onlyAlternateItemFromBom ?? null
                    formData.value.isPrint = items[0].isPrint ?? null
                } else {
                    resetFormData()
                    isTypeDisabled.value = false
                    isItemCodeDisabled.value = false
                }
            }

        const deleteItem = async (id) => {
            Swal.fire({
                title: 'Are you sure?',
                text: 'You won\'t be able to revert this!',
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
                        store.dispatch('production-planning/deleteWorkOrderItem', {id: id})
                            .then(res => {
                                if (res.status === 200) {
                                    toast({
                                        component: ToastificationContent,
                                        position: 'top-right',
                                        props: {
                                            title: 'Work Order Item Deleted',
                                            icon: 'CheckSquareIcon',
                                            variant: 'success',
                                            text: `You have successfully Deleted Work Order Item.`,
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
                        refetchData()
                    }
                })
        }

        const submitFormData = async (copyItem = 0) => {
            isButtonDisabled.value = true
            buttonText.value = 'Please wait...'
            formData.value.assemblyCopy = copyItem
            if (formData.value.id === null) {
                await store.dispatch('production-planning/addWorkOrderItem', formData.value)
                    .then(res => {
                        if (res.status === 200) {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Work Order Item Added',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: `You have successfully Added Work Order Item.`,
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
            } else {
                await store.dispatch('production-planning/updateWorkOrderItem', formData.value)
                    .then(res => {
                        if (res.status === 200) {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Work Order Item Updated',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: `You have successfully Updated Work Order Item.`,
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
            }
            resetFormData()
            await refetchData()
            isButtonDisabled.value = false
            isTypeDisabled.value = false
            isItemCodeDisabled.value = false
            buttonText.value = 'Save'
            modalData.value = []
        }

        const selectBomVersion = async (data) => {
            formData.value.itemAssemblyBomNumber = data.bomNumber
            formData.value.assemblyFromVersionId = data._id
            confirmationModal.value.hide()
            await Swal.fire({
                title: 'Copy BOM Assembly?',
                text: '',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
                customClass: {
                    confirmButton: 'btn btn-primary',
                    cancelButton: 'btn btn-outline-danger ml-1',
                },
                buttonsStyling: false,
            })
                .then(result => {
                    if (result.value) {
                        submitFormData(1)
                    } else {
                        submitFormData()
                    }
                })
        }

        const getBomQtyData = () => {
            formData.value.itemBomQtyConv = formData.value.itemBomQty * formData.value.itemConvFactor * formData.value.itemConvQty
            formData.value.itemReqQty = formData.value.itemBomQty
            formData.value.itemReqQtyConv = formData.value.itemBomQtyConv
            formData.value.itemPendingQty = formData.value.itemBomQty
            formData.value.itemPendingQtyConv = formData.value.itemBomQtyConv
        }


        const {
            refFormObserver,
            getValidationState,
            resetForm
        } = formValidation(resetFormData)

        return {
            isBusy,
            itemsField,
            isTypeDisabled,
            isItemCodeDisabled,
            buttonText,
            isButtonDisabled,
            itemsData,
            itemTypeOptions,
            itemListOptions,
            uomOptions,
            materialProcessOptions,
            makeOptions,
            storeOptions,
            statusOptions,
            processOptions,
            refetchData,
            formData,
            resetFormData,
            getItemDetails,
            modalField,
            modalData,
            confirmationModal,
            submitStatus,
            checkBomExist,
            openItem,
            deleteItem,
            submitFormData,
            selectBomVersion,
            getBomQtyData,

            refFormObserver,
            getValidationState,
            resetForm,
            onRowSelect
        }
    }
    }
</script>
<style lang="scss">
    @import '~@core/scss/vue/libs/vue-sweetalert.scss';
</style>
