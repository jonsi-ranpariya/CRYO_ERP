<template>
    <div>
        <b-overlay
            :show="showOverlayLoading"
            rounded="sm"
        >
            <b-card-code>
                <div>
                    <!-- <b-row>
                        <b-col md="12">
                            <b-table
                                :fields="itemsField"
                                :items="itemsData"
                                :bordered="true"
                                :hover="true"
                                class="mb-0 table_scroll"
                                :busy="isBusy"
                                show-empty
                                responsive
                            >
                                &lt;!&ndash; Loader &ndash;&gt;
                                <template #table-busy>
                                    <div class="text-center my-2">
                                        <b-spinner class="align-middle"></b-spinner>
                                        <strong>Loading...</strong>
                                    </div>
                                </template>

                                &lt;!&ndash; A virtual column &ndash;&gt;
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


                            </b-table>
                            <hr>
                        </b-col>
                    </b-row>-->
                    <validation-observer ref="simpleRules" #default="{ handleSubmit }">
                        <b-form @submit.prevent="handleSubmit(submitFormData)">
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
                                            <b-form-input
                                                id="itemUom"
                                                :state="getValidationState(validationContext)"
                                                v-model="formData.itemUom"
                                                disabled
                                            />
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
                                                v-model="formData.itemDrawingRevision"
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
                                                multiple
                                                taggable
                                                push-tags
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
                                                :reduce="val => val.value"
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

                                </b-col>
                                <b-col md="12">
                                    <hr>
                                    <b-button
                                        variant="primary"
                                        type="submit"
                                        :disabled="isButtonDisabled"
                                    >
                                        {{ buttonText }}
                                    </b-button>
                                </b-col>
                            </b-row>
                        </b-form>
                    </validation-observer>
                </div>
            </b-card-code>
        </b-overlay>
        <!-- Modal Area -->
        <b-modal
            id="confirmModal"
            size="lg"
            title="Select BOM Version"
            ref="confirmModal"
            centered
            scrollable
            no-close-on-esc
            no-close-on-backdrop
            hide-footer
            hide-header-close
        >
            <b-table
                responsive="sm"
                :fields="bomVersion.fields"
                :items="bomVersion.data"
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
import { required } from '@validations'
import Ripple from 'vue-ripple-directive'
import vSelect from 'vue-select'
import store from '@/store'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
import { ValidationProvider, ValidationObserver } from 'vee-validate'
import formValidation from '@core/comp-functions/forms/form-validation'
import { ref, onUnmounted, computed } from '@vue/composition-api'
import axios from '@axios'
import moment from 'moment'
import { getTcTodayDate, getSalesTypeListOption } from '@core/utils/utils'
import productionPlanningStoreModule from '../../productionPlanningStoreModule'
import { useToast } from 'vue-toastification/composition'
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
    props: {
        assemblyFormData: {
            required: true
        },
        isAssemblyTypeDisabled: {
            required: true
        },
        isAssemblyItemCodeDisabled: {
            required: true
        }
    },
    setup(props, { emit, confirmModal }) {
        const ITEMADDON_APP_STORE_MODULE_NAME = 'production-planning'
        if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, productionPlanningStoreModule)
        onUnmounted(() => {
            if (store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.unregisterModule(ITEMADDON_APP_STORE_MODULE_NAME)
        })

        const toast = useToast()
        confirmModal = ref()

        const showOverlayLoading = ref(false)
        const isBusy = ref(false)
        const isTypeDisabled = computed(() => props.isAssemblyTypeDisabled)
        const isItemCodeDisabled = computed(() => props.isAssemblyItemCodeDisabled)
        const buttonText = ref('Save')
        const isButtonDisabled = ref(false)

        const itemsField = ref([
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
                key: 'pendingQty',
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

        const refetchData = async () => {
            isBusy.value = true
            /* await axios.get(`/api/get-work-order-item-assembly-list/${orderId}/${itemId}`).then(res => {
                itemsData.value = res.data.data
            }) */
            isBusy.value = false
        }
        refetchData()

        const formData = computed(() => props.assemblyFormData)

        const resetFormData = () => {
            //formData.value = JSON.parse(JSON.stringify(blankFormData))
        }

        const getItemDetails = async (id) => {
            await axios.get(`/api/item-master/${id}`)
                .then(res => {
                    emit('disableTypeAndItemCode', true)
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

        const submitFormData = async () => {
            buttonText.value = 'Please wait...'
            formData.value.versionItemId = router.currentRoute.params.assemblyId
            if (formData.value.id === null) {
                console.log(formData.value)
                await axios.get(`/api/is-bom-exist/${formData.value.itemCode}`)
                    .then((res) => {
                        if (res.data.data === false) {
                            if (formData.value.itemType === 'A') {
                                Swal.fire({
                                    title: 'Are you sure?',
                                    text: 'Save Blank Assembly?',
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
                                            saveFormData()
                                        } else {
                                            emit('resetFormData', true)
                                        }
                                    })
                            } else {
                                saveFormData()
                            }
                        } else {
                            bomVersion.value.data = res.data.item.bom_version
                            confirmModal.value.show()
                        }
                    })

            } else {
                await axios.put(`/api/work-order-item/${formData.value.id}`, formData.value)
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
                await emit('resetAssemblyForm', true)
                await emit('refetchAssemblyItems', { assemblyId: router.currentRoute.params.assemblyId })
            }
            buttonText.value = 'Save'
        }

        const bomVersion = ref({
            fields: [
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
            ],
            data: []
        })

        const saveFormData = async (copyItem = 0) => {
            formData.value.assemblyCopy = copyItem
            await axios.post('/api/work-order-item', formData.value)
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
            await emit('resetAssemblyForm', true)
            await emit('refetchAssemblyItems', { assemblyId: router.currentRoute.params.assemblyId })
        }

        const selectBomVersion = async (data) => {
            formData.value.itemAssemblyBomNumber = data.bomNumber
            formData.value.assemblyFromVersionId = data._id
            confirmModal.value.hide()
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
                        saveFormData(1)
                    } else {
                        saveFormData()
                    }
                })
        }

        const {
            refFormObserver,
            getValidationState,
            resetForm
        } = formValidation(resetFormData)

        return {
            showOverlayLoading,
            isBusy,
            isTypeDisabled,
            isItemCodeDisabled,
            buttonText,
            confirmModal,
            isButtonDisabled,
            itemTypeOptions,
            itemListOptions,
            uomOptions,
            materialProcessOptions,
            makeOptions,
            storeOptions,
            statusOptions,
            processOptions,
            itemsField,
            itemsData,
            refetchData,
            formData,
            resetFormData,
            getItemDetails,
            submitFormData,
            bomVersion,
            selectBomVersion,

            refFormObserver,
            getValidationState,
            resetForm,
        }
    }
}
</script>
<style lang="scss">
@import '~@core/scss/vue/libs/vue-sweetalert.scss';
</style>
