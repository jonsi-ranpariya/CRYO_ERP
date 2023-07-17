<template>
    <div>
        <!-- Table -->
        <b-card-code>
            <b-overlay
                :show="showOverlayLoading"
                rounded="sm"
            >
                <b-row>
                    <b-col md="12">
                        <b-table
                            responsive="sm"
                            :fields="bomItemRows"
                            :items="bomItemData"
                            :bordered="true"
                            :hover="true"
                            show-empty
                            class="table_scroll"
                            :busy="isBusy"
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

                            <!--Action-->
                            <template
                                #cell(action)="data"
                            >
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
                                    <div v-if="data.item.itemType === 'A'">
                                        <b-dropdown-item @click="openBomVersionItem(data.item)">
                                            <feather-icon
                                                icon="CheckSquareIcon"
                                                class="mr-50"
                                            />
                                            <span>Open</span>
                                        </b-dropdown-item>
                                    </div>
                                    <b-dropdown-item @click="editBomVersionItem(data.item)">
                                        <feather-icon
                                            icon="Edit2Icon"
                                            class="mr-50"
                                        />
                                        <span>Edit</span>
                                    </b-dropdown-item>
                                    <b-dropdown-item @click="deleteBomVersionItem(data.item._id)">
                                        <feather-icon
                                            icon="TrashIcon"
                                            class="mr-50"
                                        />
                                        <span>Delete</span>
                                    </b-dropdown-item>
                                </b-dropdown>
                            </template>
                        </b-table>
                    </b-col>
                </b-row>
            </b-overlay>
        </b-card-code>
        <!-- Form -->
        <b-card-code>
            <b-overlay
                :show="showOverlayLoading"
                rounded="sm"
            >
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
                                            :disabled="isItemTypeDisable"
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
                                            :clearable="true"
                                            :reduce="val => val.value"
                                            :state="errors.length > 0 ? false : null"
                                            placeholder="select Make"
                                        />
                                        <small class="text-danger">{{ errors[0] }}</small>
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
                                    name="Material Specification"
                                    rules=""
                                >
                                    <b-form-group
                                        label="Material Specification"
                                        label-for="itemMaterialSpecification"
                                        :state="getValidationState(validationContext)"
                                    >
                                        <b-form-input
                                            id="itemMaterialSpecification"
                                            :state="getValidationState(validationContext)"
                                            v-model="formData.itemMaterialSpecification"
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
                                            @keyup="getBomQtyData($event)"
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
                                            placeholder="Select Item"
                                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                            :options="uomOptions"
                                            :reduce="val => val.value"
                                            :clearable="false"
                                            input-id="convUom"
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
                                    name="Drg. Rev"
                                    rules=""
                                >
                                    <b-form-group
                                        label="Drg. Rev"
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
                                <hr>
                                <h5>Rate And Total</h5>
                                <hr>
                                <b-form-group
                                    label="Rate From..."
                                    label-for="rateFrom"
                                >
                                    <b-form-radio-group
                                        id="rateFrom"
                                        :options="rateFromOptions"
                                        class="demo-inline-spacing mb-1"
                                        value-field="value"
                                        text-field="text"
                                        disabled-field="disabled"
                                        v-model="formData.itemRateFrom"
                                    />
                                </b-form-group>
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
            </b-overlay>
        </b-card-code>
    </div>
</template>
<script>
import BCardCode from '@core/components/b-card-code'
import { ValidationProvider, ValidationObserver } from 'vee-validate'
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
    BOverlay,
    BFormInvalidFeedback,
    BTable,
    BDropdown,
    BDropdownItem,
    BSpinner,
    BTabs,
    BTab,
    BFormRadioGroup
} from 'bootstrap-vue'
import { required } from '@validations'
import formValidation from '@core/comp-functions/forms/form-validation'
import Ripple from 'vue-ripple-directive'
import vSelect from 'vue-select'
import store from '@/store'
import router from '@/router'
import Toastification from '@core/components/toastification/ToastificationContent.vue'
import { useToast } from 'vue-toastification/composition'
import { ref, computed, onUnmounted } from '@vue/composition-api'
import axios from '@axios'
import bomStoreModule from '../../bomStoreModule'
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
        BOverlay,
        BFormInvalidFeedback,
        BTable,
        BDropdown,
        BDropdownItem,
        BSpinner,
        BTabs,
        BTab,
        BFormRadioGroup,
        vSelect
    },
    setup() {
        const DM_APP_STORE_MODULE_NAME = 'bom-module'
        if (!store.hasModule(DM_APP_STORE_MODULE_NAME)) store.registerModule(DM_APP_STORE_MODULE_NAME, bomStoreModule)
        const toast = useToast()

        const currentBomId = router.currentRoute.params.id
        const currentVersionId = router.currentRoute.params.versionId

        const isItemTypeDisable = ref(false)

        const showOverlayLoading = ref(true)
        const isBusy = ref(true)

        const bomItemRows = ref([
            {
                key: 'index',
                label: 'No'
            },
            {
                key: 'itemType',
                label: 'Type'
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
                key: 'uom_detail.uom',
                label: 'UOM'
            },
            {
                key: 'itemBomQty',
                label: 'Qty'
            },
            {
                key: 'itemDrawingNumber',
                label: 'Drawing Number'
            },
            {
                key: 'itemBomQtyConv',
                label: 'BOM Qty'
            },
            {
                key: 'itemCurrentStock',
                label: 'Curr Stock'
            },
            {
                key: 'itemAssemblyBomNumber',
                label: 'Assb. BomNo'
            },
            {
                key: 'action',
                label: 'Action'
            },
        ])

        const bomItemData = ref([])

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
                showOverlayLoading.value = false
            })

        const uomOptions = ref([])
        axios.get('/api/get-uom-master-options')
            .then(res => {
                uomOptions.value = res.data.data
                showOverlayLoading.value = false
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

        const rateFromOptions = ref([
            {
                text: 'Punch Card',
                value: 1,
                disabled: false
            },
            {
                text: 'Item Master',
                value: 2,
                disabled: false
            },
        ])

        const processOptions = ref([])
        axios.get('/api/get-process-master-option')
            .then(res => {
                processOptions.value = res.data.data
            })

        const refetchData = async () => {
            isBusy.value = true
            await axios.get(`/api/get-bom-version-items-data/${currentBomId}/${currentVersionId}`)
                .then(res => {
                    bomItemData.value = res.data.data
                })
            showOverlayLoading.value = false
            isBusy.value = false
        }
        refetchData()

        const blankFormData = {
            id: null,
            bomId: currentBomId,
            versionId: currentVersionId,
            itemType: null,
            itemCode: null,
            itemDescription: null,
            itemAddDescription: null,
            itemDrawingNumber: null,
            itemMaterialSpecification: null,
            itemBomQty: null,
            itemBomQtyConv: null,
            itemConvFactor: null,
            itemUom: null,
            itemConvUom: null,
            itemConvQty: null,
            itemMaterialProcessType: null,
            itemAssemblyBomNumber: null,
            itemNote: null,
            itemDetailDescription: null,
            itemCurrentStock: null,
            itemPositionNumber: null,
            itemDrawingRevision: null,
            itemIssueAtProcess: null,
            itemMake: null,
            itemStore: null,
            itemMaterialInput1: null,
            itemMaterialInput2: null,
            itemMaterialLenght: null,
            itemMaterialQty: null,
            itemMaterialWeight: null,
            itemRateFrom: null,
        }

        const formData = ref(JSON.parse(JSON.stringify(blankFormData)))

        const resetFormData = () => {
            formData.value = JSON.parse(JSON.stringify(blankFormData))
        }

        const editBomVersionItem = (data) => {
            formData.value = data
        }

        const deleteBomVersionItem = async (id) => {
            await Swal.fire({
                title: 'Are you sure?',
                text: 'Delete Bill Of Material Version Item',
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
                        store.dispatch('bom-module/deleteBomVersionItem', { id: id })
                            .then(res => {
                                if (res.data.status === 200) {
                                    toast({
                                        component: Toastification,
                                        position: 'top-right',
                                        props: {
                                            title: 'BOM Version Item Deleted',
                                            icon: 'CheckSquareIcon',
                                            variant: 'success',
                                            text: 'You have successfully Deleted Bill Of Master Version Item',
                                        },
                                    })
                                } else {
                                    toast({
                                        component: Toastification,
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
                        resetFormData()
                        refetchData()
                    }
                })
        }

        const getItemDetails = async (id) => {
            await axios.get(`/api/item-master/${id}`)
                .then(res => {
                    isItemTypeDisable.value = true
                    if (res.data.data.materialProcessType === 2) {
                        formData.value.itemType = 'I'
                    } else {
                        formData.value.itemType = 'A'
                    }
                    formData.value.itemDescription = res.data.data.itemDescription
                    formData.value.itemDrawingNumber = res.data.data?.itemDetails?.drawingNumber ?? null
                    formData.value.itemDrawingRevision = res.data.data?.itemDetails?.revision ?? null
                    formData.value.itemMaterialSpecification = res.data.data?.itemDetails?.materialSpecification ?? null
                    formData.value.itemNote = res.data.data?.itemDetails?.remarkNote ?? null
                    formData.value.itemConvFactor = res.data.data.cFactor
                    formData.value.itemUom = res.data.data.uom ?? null
                    formData.value.itemConvUom = res.data.data.convUom
                    formData.value.itemConvQty = res.data.data.convQty
                    formData.value.itemDetailDescription = res.data.data?.itemDetails?.detailDescription ?? null
                    formData.value.itemMaterialProcessType = res.data.data.materialProcessType
                    formData.value.itemMake = res.data.data.make
                    formData.value.itemAddDescription = res.data.data?.itemDetails?.description ?? null
                })
            await axios.get(`/api/bill-of-material-version/${currentVersionId}`)
                .then((res) => {
                    formData.value.itemAssemblyBomNumber = res.data.data.bomNumber
                })
        }

        const submitFormData = async () => {
            if (formData.value.id === null) {
                await store.dispatch('bom-module/addBomVersionItem', formData.value)
                    .then(res => {
                        if (res.data.status === 200) {
                            toast({
                                component: Toastification,
                                position: 'top-right',
                                props: {
                                    title: 'BOM Version Item Added',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: 'You have successfully Added Bill Of Master Version Item',
                                },
                            })
                        } else {
                            toast({
                                component: Toastification,
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
            } else {
                await store.dispatch('bom-module/updateBomVersionItem', formData.value)
                    .then(res => {
                        if (res.data.status === 200) {
                            toast({
                                component: Toastification,
                                position: 'top-right',
                                props: {
                                    title: 'BOM Version Item Updated',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: 'You have successfully Updated Bill Of Master Version Item',
                                },
                            })
                        } else {
                            toast({
                                component: Toastification,
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
            resetFormData()
            await refetchData()
        }

        const getBomQtyData = () => {
            formData.value.itemBomQtyConv = formData.value.itemBomQty * formData.value.itemConvFactor * formData.value.itemConvQty
        }

        const openBomVersionItem = async (data) => {
            await router.push({
                name: 'edit-bill-of-material-version-assembly',
                params: {
                    id: data.bomId,
                    versionId: data.versionId,
                    versionItemId: data._id
                },
            })
        }

        const {
            refFormObserver,
            getValidationState,
            resetForm
        } = formValidation(resetFormData)

        return {
            currentBomId,
            currentVersionId,
            showOverlayLoading,
            isBusy,
            isItemTypeDisable,
            bomItemRows,
            bomItemData,
            itemTypeOptions,
            itemListOptions,
            uomOptions,
            materialProcessOptions,
            makeOptions,
            storeOptions,
            rateFromOptions,
            processOptions,
            formData,
            getItemDetails,
            resetFormData,
            submitFormData,
            refetchData,
            editBomVersionItem,
            deleteBomVersionItem,
            openBomVersionItem,

            refFormObserver,
            getValidationState,
            resetForm,
            getBomQtyData
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
