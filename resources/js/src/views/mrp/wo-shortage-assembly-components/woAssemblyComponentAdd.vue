<template>
    <div>
        <b-card-code>
            <validation-observer #default="{ handleSubmit }">
                <b-form @submit.prevent="handleSubmit(saveFormData)">
                    <b-row>
                        <b-col md="12">
                            <h5>Indent Details</h5>
                            <hr>
                        </b-col>
                        <b-col md="5">
                            <validation-provider
                                #default="validationContext"
                                name="Item Code"
                                rules="required"
                            >
                                <b-form-group
                                    :state="getValidationState(validationContext)"
                                >
                                    <label for="itemCode"> Item Code <span
                                        class="text-danger erp_required_star">*</span></label>

                                    <v-select
                                        v-model="formData.itemId"
                                        placeholder="Select itemCode"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="itemCodeOption"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        input-id="itemCode"
                                        @input="getItemDetails($event)"
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
                                        v-model="formData.itemDescription"
                                        id="itemDescription"
                                        readonly
                                        :state="getValidationState(validationContext)"
                                    />

                                    <b-form-invalid-feedback>
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                            <b-form-group
                                label="Item Make"
                                label-for="itemMake"
                            >
                                <v-select
                                    v-model="formData.itemMake"
                                    placeholder="Select itemMake"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="itemOption"
                                    :reduce="val => val.value"
                                    :clearable="false"
                                    input-id="itemMake"
                                    taggable
                                    push-tags
                                />
                            </b-form-group>
                            <b-form-group
                                label="Add Description"
                                label-for="addDescription"
                            >
                                <b-form-input
                                    v-model="formData.addDescription"
                                    id="addDescription"
                                />
                            </b-form-group>
                            <b-form-group
                                label="Detail Description"
                                label-for="detailDescription"
                            >
                                <b-form-textarea
                                    v-model="formData.detailDescription"
                                    id="detailDescription"
                                    rows="2"
                                />
                            </b-form-group>
                            <b-row>
                                <b-col md="6">
                                    <b-form-group
                                        label="Drawing Number"
                                        label-for="drawingNumber"
                                    >
                                        <b-form-input
                                            id="drawingNumber"
                                            v-model="formData.drawingNumber"
                                            readonly
                                        />
                                    </b-form-group>
                                </b-col>
                                <b-col md="6">
                                    <b-form-group
                                        label="Rev"
                                        label-for="rev"
                                    >
                                        <b-form-input
                                            id="rev"
                                            v-model="formData.rev"
                                            type="number"
                                            readonly
                                        />
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <validation-provider
                                #default="validationContext"
                                name="Planning Type"
                                rules="required"
                            >
                                <b-form-group
                                    :state="getValidationState(validationContext)"
                                >
                                    <label for="planning Type"> Planning Type <span
                                        class="text-danger erp_required_star">*</span></label>

                                    <v-select
                                        v-model="formData.planningType"
                                        placeholder="Select Planning Type"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="planningOption"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        input-id="planningType"
                                    />
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                            <b-form-group
                                label="Store"
                                label-for="store"
                            >
                                <v-select
                                    v-model="formData.store"
                                    placeholder="Select store"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="storeOption"
                                    :reduce="val => val.value"
                                    :clearable="false"
                                    input-id="store"
                                    multiple
                                    taggable
                                    push-tags
                                />
                            </b-form-group>
                            <br>
                            <b-form-checkbox
                                id="conversion"
                                class="custom-control-primary float-right"
                                v-model="formData.mrpConversion"
                            >
                                Conversion..?
                            </b-form-checkbox>
                            <br>
                        </b-col>
                        <b-col md="7">
                            <b-row>
                                <b-col md="4">
                                    <validation-provider
                                        #default="validationContext"
                                        name="Delivery Date"
                                        rules="required"
                                    >
                                        <b-form-group
                                            :state="getValidationState(validationContext)"
                                        >
                                            <label for="deliveryDate"> Delivery Date <span
                                                class="text-danger erp_required_star">*</span></label>

                                            <b-input-group>
                                                <cleave
                                                    id="deliveryDate"
                                                    v-model="formData.deliveryDate"
                                                    class="form-control"
                                                    :raw="false"
                                                    :options="dateFormat"
                                                    placeholder="DD/MM/YYYY"
                                                    show-decade-nav
                                                />
                                                <b-input-group-append>
                                                    <b-form-datepicker
                                                        v-model="formatDates.deliveryDate"
                                                        button-only
                                                        @input="getWoDeliveryFormateDate($event)"
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
                                <b-col md="4">
                                    <b-form-group
                                        label="Indent Date"
                                        label-for="indentDate"
                                    >
                                        <b-input-group>
                                            <b-input-group-prepend>
                                                <b-form-datepicker
                                                    v-model="formatDates.indentDate"
                                                    button-only
                                                    @input="getPurchaseIndentFormateDate($event)"
                                                    show-decade-nav
                                                    size="sm"
                                                    nav-button-variant="primary"
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
                                            />
                                        </b-input-group>
                                    </b-form-group>
                                </b-col>
                                <b-col md="4">
                                    <b-form-group
                                        label="Indent No."
                                        label-for="indentNo"
                                    >
                                        <b-form-input
                                            v-model="formData.indentNo"
                                            id="indentNo"
                                            readonly
                                        />
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col md="4">
                                    <b-form-group
                                        label="Req. Qty UM"
                                        label-for="reqQtyUm"
                                    >
                                        <b-form-input
                                            v-model="formData.reqQtyUm"
                                            id="reqQtyUm"
                                            @keyup="calculateAmount"
                                            type="number"
                                        />
                                    </b-form-group>
                                </b-col>
                                <b-col md="4">
                                    <b-form-group
                                        label="Req. Qty UP"
                                        label-for="reqQtyUp"
                                    >
                                        <b-form-input
                                            v-model="formData.reqQtyUp"
                                            id="reqQtyUp"
                                            type="number"
                                        />
                                    </b-form-group>
                                </b-col>
                                <b-col md="4">
                                    <b-form-group
                                        label="Lead Time"
                                        label-for="leadTime"
                                    >
                                        <b-form-input
                                            v-model="formData.leadTime"
                                            id="leadTime"
                                            type="number"
                                        />
                                    </b-form-group>
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
                                            :state="getValidationState(validationContext)"
                                        >
                                            <label for="uom"> UOM <span
                                                class="text-danger erp_required_star">*</span></label>

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
                                    <b-form-group
                                        label="UP"
                                        label-for="up"
                                    >
                                        <v-select
                                            v-model="formData.up"
                                            placeholder="Select UP"
                                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                            :options="UPOption"
                                            :reduce="val => val.value"
                                            :clearable="false"
                                            input-id="up"
                                        />
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col md="6">
                                    <b-form-group
                                        label="C-Factor"
                                        label-for="cFactor"
                                    >
                                        <b-form-input
                                            v-model="formData.cFactor"
                                            id="cFactor"
                                            @keyup="calculateAmount"
                                        />
                                    </b-form-group>
                                </b-col>
                                <b-col md="6">
                                    <b-form-group
                                        label="Conv. Qty"
                                        label-for="conveQty"
                                    >
                                        <b-form-input
                                            v-model="formData.conveQty"
                                            id="conveQty"
                                            @keyup="calculateAmount"
                                        />
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col md="6">
                                    <b-form-group
                                        label="Min Order Qty"
                                        label-for="minOrderQty"
                                    >
                                        <b-form-input
                                            v-model="formData.minOrderQty"
                                            id="minOrderQty"
                                            type="number"
                                        />
                                    </b-form-group>
                                </b-col>
                                <b-col md="6">
                                    <b-form-group
                                        label="Max Order Qty"
                                        label-for="maxOrderQty"
                                    >
                                        <b-form-input
                                            v-model="formData.maxOrderQty"
                                            id="maxOrderQty"
                                            type="number"
                                        />
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col md="6">
                                    <b-form-group
                                        label="Size(l*b)"
                                        label-for="size"
                                    >
                                        <b-form-input
                                            v-model="formData.size"
                                            id="size"
                                        />
                                    </b-form-group>
                                </b-col>
                                <b-col md="6">
                                    <b-form-group
                                        label="Qty (Nos.)"
                                        label-for="qtyNos"
                                    >
                                        <b-form-input
                                            v-model="formData.qtyNos"
                                            id="qtyNos"
                                        />
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col md="6">
                                    <b-form-group
                                        label="SO No."
                                        label-for="soNo"
                                    >
                                        <v-select
                                            v-model="formData.soId"
                                            placeholder="Select soNo"
                                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                            :options="soNoOption"
                                            :reduce="val => val.value"
                                            :clearable="false"
                                            input-id="soNo"
                                        />
                                    </b-form-group>
                                </b-col>
                                <b-col md="6">
                                    <b-form-group
                                        label="WO No."
                                        label-for="woNo"
                                    >
                                        <v-select
                                            v-model="formData.woId"
                                            placeholder="Select woNo"
                                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                            :options="woNoOption"
                                            :reduce="val => val.value"
                                            :clearable="false"
                                            input-id="woNo"
                                        />
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-form-group
                                label="Forecast No."
                                label-for="forecastNo"
                            >
                                <b-form-input
                                    id="forecastNo"
                                    v-model="formData.forecastNo"
                                />
                            </b-form-group>
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
                                        rows="3"
                                        :state="getValidationState(validationContext)"
                                    />
                                </b-form-group>
                            </validation-provider>
                        </b-col>
                        <!-- button select-->
                        <b-col md="2">
                            <b-form-group
                                label="Current Stock"
                                label-for="currentStock"
                            >
                                <b-input-group class="d-flex">
                                    <b-form-input
                                        id="currentStock"
                                        v-model="formData.currentStock"
                                    />
                                    <b-input-group-append>
                                        <b-button variant="primary" @click="">...</b-button>
                                    </b-input-group-append>
                                </b-input-group>
                            </b-form-group>
                        </b-col>
                        <b-col md="2">
                            <b-form-group
                                label="Pending Indent"
                                label-for="pendingIndent"
                            >
                                <b-input-group class="d-flex">
                                    <b-form-input
                                        id="pendingIndent"
                                        v-model="formData.pendingIndent"
                                    />
                                    <b-input-group-append>
                                        <b-button variant="primary" @click="">...</b-button>
                                    </b-input-group-append>
                                </b-input-group>
                            </b-form-group>
                        </b-col>
                        <b-col md="2">
                            <b-form-group
                                label="Pending PO"
                                label-for="pendingPurchaseOrder"
                            >
                                <b-input-group class="d-flex">
                                    <b-form-input
                                        id="pendingPurchaseOrder"
                                        v-model="formData.pendingPurchaseOrder"
                                    />
                                    <b-input-group-append>
                                        <b-button variant="primary" @click="">...</b-button>
                                    </b-input-group-append>
                                </b-input-group>
                            </b-form-group>
                        </b-col>
                        <b-col md="3">
                            <b-form-group
                                label="Pending For Inspection"
                                label-for="pendingForInspection"
                            >
                                <b-input-group class="d-flex">
                                    <b-form-input
                                        id="pendingForInspection"
                                        v-model="formData.pendingForInspection"
                                    />
                                    <b-input-group-append>
                                        <b-button variant="primary" @click="">...</b-button>
                                    </b-input-group-append>
                                </b-input-group>
                            </b-form-group>
                        </b-col>
                        <b-col md="3">
                            <b-form-group
                                label="Req Qty(Against W.O.)"
                                label-for="reqQtyAgainstWo"
                            >
                                <b-input-group class="d-flex">
                                    <b-form-input
                                        id="reqQtyAgainstWo"
                                        v-model="formData.reqQtyAgainstWo"
                                    />
                                    <b-input-group-append>
                                        <b-button variant="primary" @click="">...</b-button>
                                    </b-input-group-append>
                                </b-input-group>
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
                            <b-button
                                class="float-right mr-1"
                                variant="primary"
                            >
                                WO Allocation
                            </b-button>
                            <b-button
                                class="float-right mr-1"
                                variant="primary"
                            >
                                Stock Status
                            </b-button>
                            <b-button
                                class="float-right mr-1"
                                variant="primary"
                                @click="openDeliverySheduleModal"
                            >
                                Delivery Schedule
                            </b-button>
                        </b-col>
                    </b-row>
                </b-form>
            </validation-observer>
        </b-card-code>
<!-- Delivery Shedule Modal-->
        <b-modal
            cancel-variant="danger"
            id="deliverySheduleModal"
            no-close-on-backdrop
            ok-title="Save"
            ref="deliverySheduleModal"
            scrollable
            size="lg"
            title="Delivery Shedule"
        >
            <!-- Table -->
            <b-row>
                <b-col md="12">
                    <b-table
                        responsive
                        :fields="modalTables.deliverySheduleFields"
                        :items="modalTables.deliverySheduleData"
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
                                <b-dropdown-item @click="editDeliveryData(data.item)"
                                >
                                    <feather-icon
                                        class="mr-50"
                                        icon="Edit2Icon"
                                    />
                                    <span>Edit</span>
                                </b-dropdown-item>
                                <b-dropdown-item @click="deleteDeliveryData(data.item._id)"
                                >
                                    <feather-icon
                                        class="mr-50"
                                        icon="TrashIcon"
                                    />
                                    <span>Delete</span>
                                </b-dropdown-item>
                            </b-dropdown>
                        </template>
                    </b-table>
                    <hr/>
                </b-col>
            </b-row>
            <!--add Description-->
            <b-row>
                <b-col md="6">
                    <b-form-group
                        label="Delivery Date"
                        label-for="deliverySheduleDate"
                    >
                        <b-input-group>
                            <b-input-group-prepend>
                                <b-form-datepicker
                                    v-model="formatDates.deliverySheduleDate"
                                    button-only
                                    @input="getDeliveryFormateDate($event)"
                                    show-decade-nav
                                    size="sm"
                                    nav-button-variant="primary"
                                />
                            </b-input-group-prepend>
                            <cleave
                                id="indentDate"
                                v-model="formDataShedule.deliverySheduleDate"
                                class="form-control"
                                :raw="false"
                                :options="dateFormat"
                                placeholder="DD/MM/YYYY"
                                show-decade-nav
                            />
                        </b-input-group>
                    </b-form-group>
                    <b-form-group
                        label="Expected Arrival Date"
                        label-for="expectedArrivalDate"
                    >
                        <b-input-group>
                            <b-input-group-prepend>
                                <b-form-datepicker
                                    v-model="formatDates.expectedArrivalDate"
                                    button-only
                                    @input="getArrivalFormateDate($event)"
                                    show-decade-nav
                                    size="sm"
                                    nav-button-variant="primary"
                                />
                            </b-input-group-prepend>
                            <cleave
                                id="indentDate"
                                v-model="formDataShedule.expectedArrivalDate"
                                class="form-control"
                                :raw="false"
                                :options="dateFormat"
                                placeholder="DD/MM/YYYY"
                                show-decade-nav
                            />
                        </b-input-group>
                    </b-form-group>
                </b-col>
                <b-col md="6">
                    <b-row>
                        <b-col md="6">
                            <b-form-group
                                label="Quantity"
                                label-for="quantity"
                            >
                                <b-form-input
                                    v-model="formDataShedule.quantity"
                                    id="quantity"
                                />
                            </b-form-group>
                        </b-col>
                        <b-col md="6">
                            <b-form-group
                                label="Total Qty"
                                label-for="totalQuantity"
                            >
                                <b-form-input
                                    v-model="formDataShedule.totalQuantity"
                                    id="totalQuantity"
                                    readonly
                                />
                            </b-form-group>
                        </b-col>
                    </b-row>
                    <b-form-group
                        label="Sales Order Qty"
                        label-for="salesOrderQty"
                    >
                        <b-form-input
                            v-model="formDataShedule.salesOrderQty"
                            id="totalQuantity"
                        />
                    </b-form-group>
                </b-col>
            </b-row>
        </b-modal>
    </div>
</template>
<script>
import BCardCode from "../../../@core/components/b-card-code/BCardCode";
import Ripple from 'vue-ripple-directive'
import {onUnmounted, ref} from '@vue/composition-api'
import VSelect from 'vue-select'
import axios from '@axios'
import {forMatIndianDate, getTcTodayDate} from "../../../@core/utils/utils";
import {ValidationProvider, ValidationObserver} from 'vee-validate'
import formValidation from '@core/comp-functions/forms/form-validation'
import {required} from '@validations'
import router from '@/router'
import moment from 'moment'
import Cleave from 'vue-cleave-component'
import {
    BForm,
    BRow,
    BCol,
    BFormGroup,
    BFormInput,
    BFormTextarea,
    BFormDatepicker,
    BButton,
    BFormInvalidFeedback,
    BInputGroup,
    BInputGroupAppend,
    BInputGroupPrepend,
    BTable,
    BDropdownItem,
    BDropdown,
    BSpinner,
    BFormCheckbox
} from 'bootstrap-vue'
import {getUserData} from "../../../auth/utils";
import {useToast} from "vue-toastification/composition";
import mrpStoreModule from "../mrpStoreModule";
import store from '@/store'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'

export default {
    components: {
        BCardCode,
        VSelect,
        BForm,
        BRow,
        BCol,
        BFormGroup,
        BFormInput,
        BFormTextarea,
        BFormDatepicker,
        BButton,
        BFormInvalidFeedback,
        ValidationProvider,
        ValidationObserver,
        Cleave,
        BInputGroup,
        BInputGroupAppend,
        BInputGroupPrepend,
        BTable,
        BDropdownItem,
        BDropdown,
        BSpinner,
        BFormCheckbox
    },
    directives: {
        Ripple,
    },
    setup({deliverySheduleModal}) {
        deliverySheduleModal = ref()
        const isBusy = ref(false)
        //toast alert
        const toast = useToast()

        //Store Module
        const ITEMADDON_APP_STORE_MODULE_NAME = 'mrp-store-module'

        if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, mrpStoreModule)
        onUnmounted(() => {
            if (store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.unregisterModule(ITEMADDON_APP_STORE_MODULE_NAME)
        })

        const itemCodeOption = ref([])
        axios.get('/api/new/get-Work-Order-assembly-item-options').then(res => {
            itemCodeOption.value = res.data.data
        })

        const modalTables = ref({
            deliverySheduleFields: [
                {
                    key: 'index',
                    label: 'No'
                },
                {
                    key: 'deliveryDate',
                    label: 'Delivery Date',
                },
                {
                    key: 'quantity',
                    label: 'Quantity',
                },
                {
                    key: 'expectedArrivalDate',
                    label: 'Arrival Date',
                },
                {
                    key: 'pendingQty',
                    label: 'Pending Qty',
                },
                {
                    key: 'action',
                    label: 'Action',
                },
            ],
            deliverySheduleData: [],
        })

        const dateFormat = ref({
            date: true,
            delimiter: '/',
            datePattern: ['d', 'm', 'Y'],
        })

        const formatDates = ref({
            deliveryDate: null,
            indentDate: null,
            deliverySheduleDate: null,
            expectedArrivalDate: null,
        })

        const getWoDeliveryFormateDate = (date) => {
            formData.value.deliveryDate = forMatIndianDate(date)
        }
        const getWoIndentFormateDate = (date) => {
            formData.value.indentDate = forMatIndianDate(date)
        }
        const getDeliveryFormateDate = (date) => {
            formDataShedule.value.deliverySheduleDate = forMatIndianDate(date)
        }
        const getArrivalFormateDate = (date) => {
            formDataShedule.value.expectedArrivalDate = forMatIndianDate(date)
        }

        const uomOption = ref([])
        const UPOption = ref([])

        axios.get('/api/get-uom-master-options').then(res => {
            uomOption.value = res.data.data
            UPOption.value = res.data.data
        })

        const planningOption = ref([
            {label: 'Planned against Work Order Shortage', value: 1},
            {label: 'Planned against minimum Stock Level', value: 2},
            {label: 'Planned against Sales & Work Oreder', value: 3},
            {label: 'Planned against Sales Forecast', value: 4},
            {label: 'Planned against Market fluctuaction of raw matirial prices', value: 5},
            {label: 'Planned against shop rejection', value: 6},
            {label: 'Planned against sales order', value: 7},
            {label: 'Manual Planning', value: 8},
            {label: 'Manual', value: 9},
        ])

        const itemOption = ref([])
        axios.get('/api/get-item-make-master-options').then(res => {
            itemOption.value = res.data.data
        })

        const storeOption = ref([])
        axios.get('api/get-store-master-options').then(res => {
            storeOption.value = res.data.data
        })

        const soNoOption = ref([])
        axios.get('/api/get-sales-order-options').then(res => {
            soNoOption.value = res.data.data
        })

        const woNoOption = ref([])
        axios.get('/api/get-work-order-option').then(res => {
            woNoOption.value = res.data.data
        })

        const CurrentUserData = ref(getUserData())

        const blankFormData = {
            woItemId: null,
            itemId: null,
            itemCode: null,
            itemDescription: null,
            addDescription: null,
            detailDescription: null,
            drawingNumber: null,
            rev: null,
            uom: null,
            up: null,
            cFactor: null,
            reqQtyUm: 0,
            reqQtyUp: 0,
            conveQty: 0,
            size: null,
            qtyNos: null,
            planningType: null,
            itemMake: null,
            store: null,
            leadTime: null,
            deliveryDate: forMatIndianDate(),
            indentDate: forMatIndianDate(getTcTodayDate()),
            indentNo: null,
            minOrderQty: 0,
            maxOrderQty: 0,
            soId: null,
            soNumber:null,
            woId: null,
            woNumber:null,
            forecastNo: null,
            remark: null,
            currentStock:null,
            pendingIndent:null,
            pendingPurchaseOrder:null,
            pendingForInspection:null,
            reqQtyAgainstWo:null,
            mrpConversion: true,
            loginDetails: {
                createdBy: CurrentUserData.value.first_name + ' ' + CurrentUserData.value.last_name,
                dateTime: moment(new Date()).format('DD/MM/YYYY HH:mm'),
                lastModifiedBy: null,
                modifiedDateTime: null,
                approvedBy: null,
                approveDate: null,
                stage: 1,
            },
            indentCreatedFrom: 'assemblyComponent',
            indentCreatedMenuId: 2,
        }

        const formDataShedule = ref({
            deliverySheduleDate:forMatIndianDate(getTcTodayDate()),
            expectedArrivalDate:forMatIndianDate(getTcTodayDate()),
            quantity:0,
            totalQuantity:0,
            salesOrderQty:0,
        })

        const formData = ref(JSON.parse(JSON.stringify(blankFormData)))

        const resetFormData = () => {
            formData.value = JSON.parse(JSON.stringify(blankFormData))
        }
        const getItemDetails = async (id) => {
            await axios.get(`/api/work-order-item/${id}`).then(res => {
                formData.value.itemId = res.data.data._id ?? null
                formData.value.itemCode = res.data.data.itemCode ?? null
                formData.value.itemDescription = res.data.data.itemDescription ?? null
                formData.value.addDescription = res.data.data?.itemAddDescription ?? null
                formData.value.detailDescription = res.data.data?.itemDetailDescription ?? null
                formData.value.drawingNumber = res.data.data?.itemDrawingNumber ?? null
                formData.value.rev = res.data.data?.itemRevision ?? null
                formData.value.uom = res.data.data?.itemUom ?? null
                formData.value.cFactor = res.data.data?.itemConvFactor ?? null
                formData.value.conveQty = res.data.data?.itemConvQty ?? null
                formData.value.up = res.data.data?.itemConvUom ?? null
                formData.value.qtyNos = res.data.data?.itemMaterialQty ?? null
                formData.value.itemMake = res.data.data?.itemMake ?? null
                formData.value.leadTime = res.data.data?.item_name?.purchaseData?.leadTime ?? null
                formData.value.minOrderQty = res.data.data?.item_name?.purchaseData?.minimumOrderQuantity ?? null
                formData.value.maxOrderQty = res.data.data?.item_name?.purchaseData?.maximumOrderQuantity ?? null
                formData.value.remark = res.data.data?.itemNote ?? null
                formData.value.store = res.data.data?.itemStore ?? null
                formData.value.soId = res.data.data?.wo_details?.soId ?? null
                formData.value.soNumber = res.data.data?.wo_details?.soNumber ?? null
                formData.value.woId = res.data.data?.wo_details?._id ?? null
                formData.value.woNumber = res.data.data?.wo_details?.woNumber ?? null
                formData.value.deliveryDate = res.data.data?.wo_details?.woDeliveryDate ?? null
            })
        }

        const calculateAmount = () => {
            if (formData.value.mrpConversion === true) {
                formData.value.reqQtyUp = formData.value.reqQtyUm * formData.value.conveQty * formData.value.cFactor;
            }
        }
        const openDeliverySheduleModal = async () => {
            deliverySheduleModal.value.show();
        }
        const editDeliveryData = (data) => {}
        const deleteDeliveryData = async (id) => {}

        const saveFormData = async () => {
            await store.dispatch('mrp-store-module/addWoAssemblyComponent', formData.value).then(res => {
                if (res.status === 200) {
                    toast({
                        component: ToastificationContent,
                        position: 'top-right',
                        props: {
                            title: 'WO Assembly Component Added',
                            icon: 'CheckSquareIcon',
                            variant: 'success',
                            text: `You have successfully Added WO Assembly Component.`,
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
                // console.log(res.data)
                router.push({name: 'edit-wo-assembly-components', params: {id: res.data.data._id}})
            })
        }

        const {refFormObserver, getValidationState, resetForm} = formValidation(resetFormData)

        return {
            formData,
            itemCodeOption,
            getItemDetails,
            uomOption,
            UPOption,
            planningOption,
            itemOption,
            storeOption,
            soNoOption,
            woNoOption,
            refFormObserver,
            getValidationState,
            resetForm,
            saveFormData,
            required,
            dateFormat,
            formatDates,
            getWoIndentFormateDate,
            getWoDeliveryFormateDate,
            calculateAmount,
            deliverySheduleModal,
            openDeliverySheduleModal,
            modalTables,
            isBusy,
            formDataShedule,
            editDeliveryData,
            deleteDeliveryData,
            getDeliveryFormateDate,
            getArrivalFormateDate
        }
    }
}
</script>
