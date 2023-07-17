<template>
    <div>
        <!-- Table -->
        <b-row>
            <b-col md="12">
                <b-table
                    :fields="tableFields"
                    :items="tableData"
                    responsive
                    class="mb-0"
                    bordered
                    hover
                    show-empty
                    :busy="isBusy"
                    selectable
                    select-mode="single"
                    @row-selected="onRowSelected"
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
                            <b-dropdown-item @click="deleteItemDetails(data.item._id)">
                                <feather-icon
                                    icon="TrashIcon"
                                    class="mr-50"
                                />
                                <span>Delete</span>
                            </b-dropdown-item>
                        </b-dropdown>
                    </template>

                    <!--  select row  -->
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

        <!-- Modal Buttons -->
        <b-row>
            <b-col md="12">
                <div class="demo-inline-spacing mb-2">
                    <b-form-radio
                        name="selectItemFromModal"
                        value="1"
                        v-model="selectedRadio"
                    >
                        From Sales Order
                    </b-form-radio>
                    <b-form-radio
                        name="selectItemFromModal"
                        value="2"
                        v-model="selectedRadio"
                    >
                        From Indent
                    </b-form-radio>
                    <b-button
                        type="button"
                        variant="primary"
                        @click="openModal"
                    >
                        Select Item
                    </b-button>
                </div>
                <hr>
            </b-col>
        </b-row>

        <!-- Item Form -->
        <validation-observer #default="{ handleSubmit }">
            <b-form @submit.prevent="handleSubmit(saveFormData)">
                <b-row>
                    <b-col md="6">
                        <validation-provider
                            #default="{ errors }"
                            name="Item Code"
                            rules=""
                        >
                            <b-form-group
                                label="Item Code"
                                label-for="itemCode"
                                :state="errors.length > 0 ? false:null"
                            >
                                <v-select
                                    placeholder="Select Item"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="itemsOptions"
                                    :reduce="val => val.value"
                                    :clearable="false"
                                    input-id="itemCode"
                                    :state="errors.length > 0 ? false:null"
                                    @input="getItemDetails($event)"
                                    v-model="formData.itemCode"
                                />
                                <small class="text-danger">{{ errors[0] }}</small>
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
                                    id="itemDescription"
                                    :state="getValidationState(validationContext)"
                                    v-model="formData.itemDescription"
                                />
                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                        <b-row>
                            <b-col md="6">
                                <b-form-group
                                    label="Item Make"
                                    label-for="itemMake"
                                >
                                    <v-select
                                        :clearable="false"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="makeOption"
                                        :reduce="(val) => val.value"
                                        input-id="itemMake"
                                        placeholder="Select Make"
                                        v-model="formData.itemMake"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="HSN Number"
                                    label-for="itemHsnNumber"
                                >
                                    <b-form-input
                                        id="itemHsnNumber"
                                        v-model="formData.itemHsnNumber"
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="6">
                                <b-form-group
                                    label="MSN Number"
                                    label-for="itemMsnNumber"
                                >
                                    <b-form-input
                                        id="itemMsnNumber"
                                        v-model="formData.itemMsnNumber"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <validation-provider
                                    #default="validationContext"
                                    name="Add. Description"
                                    rules=""
                                >
                                    <b-form-group
                                        label="Add. Description"
                                        label-for="itemAddDescription"
                                    >
                                        <b-form-input
                                            id="itemAddDescription"
                                            :state="getValidationState(validationContext)"
                                            v-model="formData.itemAddDescription"
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
                                label-for="itemDetailDescription"
                            >
                                <b-form-textarea
                                    id="itemDetailDescription"
                                    rows="3"
                                    :state="getValidationState(validationContext)"
                                    v-model="formData.itemDetailDescription"
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
                                    name="Drawing Number"
                                    rules=""
                                >
                                    <b-form-group
                                        label="Drawing Number"
                                        label-for="itemDrawingNumber"
                                    >
                                        <b-form-input
                                            id="itemDrawingNumber"
                                            :state="getValidationState(validationContext)"
                                            v-model="formData.itemDrawingNumber"
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
                                    name="Drawing Revision"
                                    rules=""
                                >
                                    <b-form-group
                                        label="Drawing Revision"
                                        label-for="itemDrawingRevision"
                                    >
                                        <b-form-input
                                            id="itemDrawingRevision"
                                            :state="getValidationState(validationContext)"
                                            v-model="formData.itemDrawingRevision"
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
                                    #default="{ errors }"
                                    name="UOM"
                                    rules=""
                                >
                                    <b-form-group
                                        label="UOM"
                                        label-for="uom"
                                        :state="errors.length > 0 ? false:null"
                                    >
                                        <v-select
                                            placeholder="Select Uom"
                                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                            :options="uomOptions"
                                            :reduce="val => val.value"
                                            :clearable="false"
                                            input-id="uom"
                                            :state="errors.length > 0 ? false:null"
                                            v-model="formData.itemUom"
                                        />
                                        <small class="text-danger">{{ errors[0] }}</small>
                                    </b-form-group>
                                </validation-provider>
                            </b-col>
                            <b-col md="6">
                                <b-form-group label="Conv. UOM" label-for="itemConvUom">
                                    <v-select
                                        :clearable="false"
                                        :dir="
                                            $store.state.appConfig.isRTL
                                                ? 'rtl'
                                                : 'ltr'
                                        "
                                        :options="uomOptions"
                                        :reduce="(val) => val.value"
                                        input-id="itemConvUom"
                                        placeholder="Select UOM"
                                        v-model="formData.itemConvUom"
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="6">
                                <b-form-group
                                    label="C-Factor"
                                    label-for="itemFactor"
                                >
                                    <b-form-input
                                        id="itemFactor"
                                        v-model="formData.itemFactor"
                                        @keyup="calculateAmount"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Conv Qty"
                                    label-for="itemConvQty"
                                >
                                    <b-form-input
                                        id="itemConvQty"
                                        v-model="formData.itemConvQty"
                                        @keyup="calculateAmount"
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="6">
                                <validation-provider
                                    #default="validationContext"
                                    name="Require Quantity"
                                    rules="required"
                                >
                                    <b-form-group
                                        label="Require Quantity"
                                        label-for="itemRequireQuantity"
                                        :state="getValidationState(validationContext)"
                                    >
                                        <b-form-input
                                            id="itemRequireQuantity"
                                            :state="getValidationState(validationContext)"
                                            v-model="formData.itemRequireQuantity"
                                            @keyup="calculateAmount"
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
                                    name="Quantity UP"
                                    rules="required"
                                >
                                    <b-form-group
                                        label="Quantity Conv"
                                        label-for="itemQuantityUp"
                                    >
                                        <b-form-input
                                            id="itemRequireQuantityConv"
                                            :state="getValidationState(validationContext)"
                                            v-model="formData.itemQuantityUp"
                                        />
                                        <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                            {{ validationContext.errors[0] }}
                                        </b-form-invalid-feedback>
                                    </b-form-group>
                                </validation-provider>
                            </b-col>
                        </b-row>
                        <b-form-group
                            label="Store"
                            label-for="itemStore"
                        >
                            <v-select
                                :clearable="false"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="storeOption"
                                :reduce="(val) => val.value"
                                input-id="itemStore"
                                placeholder="Select Store"
                                v-model="formData.itemStore"
                            />
                        </b-form-group>
                        <validation-provider
                            #default="validationContext"
                            name="SO No."
                            rules=""
                        >
                            <b-form-group
                                label="SO No."
                                label-for="itemSoNumber"
                            >
                                <b-form-input
                                    id="itemSoNumber"
                                    :state="getValidationState(validationContext)"
                                    v-model="formData.itemSoNumber"
                                />
                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                        <validation-provider
                            #default="validationContext"
                            name="Indent No."
                            rules=""
                        >
                            <b-form-group
                                label="Indent No."
                                label-for="itemIndentNumber"
                            >
                                <b-form-input
                                    id="itemIndentNumber"
                                    :state="getValidationState(validationContext)"
                                    v-model="formData.itemIndentNumber"
                                />
                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                        <validation-provider
                            #default="{ errors }"
                            name="Status"
                            rules=""
                        >
                            <b-form-group
                                label="Status"
                                label-for="vendorStatus"
                                :state="errors.length > 0 ? false:null"
                            >
                                <v-select
                                    placeholder="Select Status"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="statusOptions"
                                    :reduce="val => val.value"
                                    :clearable="false"
                                    input-id="vendorStatus"
                                    :state="errors.length > 0 ? false:null"
                                    v-model="formData.itemStatus"
                                />
                                <small class="text-danger">{{ errors[0] }}</small>
                            </b-form-group>
                        </validation-provider>
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

        <!-- Sales Order Modal -->
        <b-modal
            id="salesOrderModal"
            title="Find So For Purchase Enquiry"
            size="xl"
            no-close-on-backdrop
            ref="salesOrderModal"
            scrollable
            cancel-variant="danger"
            ok-title="Save"
            @ok="addSalesOrderItemDetails"
            @cancel="resetSalesOrderItemDetails"
        >
            <b-row>
                <b-col md="3">
                    <b-form-group
                        label="sales Order No"
                        label-for="salesOrderNo"
                    >
                        <b-form-input
                            id="salesOrderNo"
                            v-model="searchSoData.salesOrderNo"
                            @keyup="getSalesOrderFilter"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="3">
                    <b-form-group
                        label="Item Code"
                        label-for="soItemCode"
                    >
                        <b-form-input
                            id="soItemCode"
                            v-model="searchSoData.itemCode"
                            @keyup="getSalesOrderFilter"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="3">
                    <b-form-group
                        label="Item Description"
                        label-for="soItemDescription"
                    >
                        <b-form-input
                            id="soItemDescription"
                            v-model="searchSoData.itemDetailDescription"
                            @keyup="getSalesOrderFilter"
                        />

                    </b-form-group>
                </b-col>
                <b-col md="3">
                    <b-form-group
                        label="Drawing Number"
                        label-for="soDrawingNumber"
                    >
                        <b-form-input
                            id="soDrawingNumber"
                            v-model="searchSoData.itemDrawingNo"
                            @keyup="getSalesOrderFilter"
                        />
                    </b-form-group>
                </b-col>
            </b-row>

            <b-row>
                <b-col md="12">
                    <b-table
                        :fields="modalTables.salesOrderFields"
                        :items="modalTables.salesOrderData"
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
                        class="table_scroll"
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
                        <!-- Checkbox -->
                        <template #cell(selectCheckBox)="data">
                            <b-form-checkbox
                                :value="`${data.item._id}`"
                                class="custom-control-primary"
                                @input="checkItem($event, data.item._id)"
                            />
                        </template>
                    </b-table>
                    <hr>
                </b-col>
            </b-row>
        </b-modal>

        <!-- Indent Item Modal -->
        <b-modal
            id="indentModal"
            title="Find Indent For Purchase Enquiry"
            size="xl"
            no-close-on-backdrop
            ref="indentModal"
            scrollable
            cancel-variant="danger"
            ok-title="Save"
            @ok="addIndentItemDetails"
            @cancel="resetIndentItemDetails"
        >
            <b-row>
                <b-col md="3">
                    <b-form-group
                        label="Indent No"
                        label-for="indent No"
                    >
                        <b-form-input
                            id="indentNo"
                            v-model="searchData.indentNo"
                            @keyup="getIndentFilter"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="3">
                    <b-form-group
                        label="Item Code"
                        label-for="itemMasterCode"
                    >
                        <b-form-input
                            id="itemMasterCode"
                            v-model="searchData.itemCode"
                            @keyup="getIndentFilter"
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
                            @keyup="getIndentFilter"
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
                            v-model="searchData.drawingNumber"
                            @keyup="getIndentFilter"
                        />
                    </b-form-group>
                </b-col>
            </b-row>

            <b-table
                :fields="modalTables.indentFields"
                :items="modalTables.indentData"
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
                class="table_scroll"
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
                <!-- Checkbox -->
                <template #cell(selectCheckBox)="data">
                    <b-form-checkbox
                        :value="`${data.item._id}`"
                        class="custom-control-primary"
                        @input="checkIndentItem($event, data.item._id)"
                    />
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
        BFormTextarea,
        BFormDatepicker,
        BButton,
        BFormInvalidFeedback,
        BOverlay,
        BTable,
        BInputGroup,
        BInputGroupPrepend,
        BSpinner,
        BDropdown,
        BDropdownItem,
        BFormRadio,
        BFormCheckbox
    } from 'bootstrap-vue'
    import BCardCode from "@core/components/b-card-code/BCardCode";
    import Ripple from 'vue-ripple-directive'
    import {ref, onUnmounted} from '@vue/composition-api'
    import VSelect from 'vue-select'
    import axios from '@axios'
    import {getTcTodayDate, forMatIndianDate} from "@core/utils/utils";
    import {ValidationProvider, ValidationObserver} from 'vee-validate'
    import formValidation from '@core/comp-functions/forms/form-validation'
    import {required} from '@validations'
    import router from '@/router'
    import {getUserData} from "../../../../auth/utils";
    import moment from 'moment'
    import store from '@/store'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import {useToast} from 'vue-toastification/composition'
    import purchaseStoreModule from "../../purchaseStoreModule";
    import countryCode from '@/@fake-db/data/other/country-code'
    import Swal from 'sweetalert2'

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
            BTable,
            BOverlay,
            BInputGroup,
            BInputGroupPrepend,
            BSpinner,
            BDropdown,
            BDropdownItem,
            BFormRadio,
            BFormCheckbox,
            ValidationProvider,
            ValidationObserver,
        },
        directives: {
            Ripple,
        },
        setup({salesOrderModal, indentModal}) {

            const ITEMADDON_APP_STORE_MODULE_NAME = 'purchase-store-module'
            if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, purchaseStoreModule)
            onUnmounted(() => {
                if (store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.unregisterModule(ITEMADDON_APP_STORE_MODULE_NAME)
            })

            const toast = useToast()

            const isBusy = ref(false)
            const isModalTableBusy = ref(false)

            salesOrderModal = ref()

            indentModal = ref()

            const makeOption = ref([])
            axios.get('/api/get-item-make-master-options')
                .then(res => {
                    makeOption.value = res.data.data
                })

            const tableFields = ref([
                {
                    key: 'rowSelected',
                    label: ''
                },
                {
                    key: 'index',
                    label: 'No'
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
                    key: 'uom_detail.uom',
                    label: 'UOM'
                },
                {
                    key: 'itemRequireQuantity',
                    label: 'Quantity'
                },
                {
                    key: 'itemDrawingNumber',
                    label: 'Drawing No.'
                },
                {
                    key: 'itemDrawingRevision',
                    label: 'Revision'
                },
                {
                    key: 'itemStatus',
                    label: 'Status',
                    formatter: val => getStatusLabel(val)
                },
                {
                    key: 'action',
                    label: 'Actions'
                }
            ])

            const tableData = ref([])

            const refetchData = async () => {
                isBusy.value = true
                await axios.get(`/api/purchase-enquiry-item-details/${router.currentRoute.params.id}`).then(res => {
                    tableData.value = res.data.data
                })
                isBusy.value = false
            }
            refetchData()

            const itemsOptions = ref([])
            axios.get('/api/get-item-master-options').then(res => {
                itemsOptions.value = res.data.data
            })

            const uomOptions = ref([])
            axios.get('/api/get-uom-master-options').then(res => {
                uomOptions.value = res.data.data
            })

            const statusOptions = ref([
                {label: 'Pending', value: 1},
                {label: 'Canceled', value: 2},
                {label: 'Completed', value: 3},
            ])

            const storeOption = ref([]);
            axios.get("/api/get-store-master-options").then((res) => {
                storeOption.value = res.data.data;
            });

            const getStatusLabel = (id) => {
                let status = statusOptions.value.filter(status => status.value === id);
                return status[0].label ?? null;
            }

            const blankFormData = {
                _id: null,
                referenceId: router.currentRoute.params.id,
                itemId:null,
                itemCode: null,
                itemDescription: null,
                itemAddDescription: null,
                itemMake:null,
                itemHsnNumber:0,
                itemMsnNumber:0,
                itemDetailDescription: null,
                itemDrawingNumber: null,
                itemDrawingRevision: null,
                itemUom: null,
                itemConvUom:null,
                itemFactor:0,
                itemConvQty:0,
                itemRequireQuantity: null,
                itemQuantityUp: 0,
                itemStore:null,
                itemSoNumber: null,
                itemIndentNumber: null,
                itemStatus: 1,
            }

            const selectedRadio = ref('')

            const formData = ref(JSON.parse(JSON.stringify(blankFormData)))

            const resetFormData = () => {
                formData.value = JSON.parse(JSON.stringify(blankFormData))
            }

            const onRowSelected = (items) => {
                if(items.length > 0) {
                    formData.value._id = items[0]._id
                    formData.value.referenceId = items[0].referenceId
                    formData.value.itemId = items[0].itemId
                    formData.value.itemCode = items[0].itemCode ?? null
                    formData.value.itemDescription = items[0].itemDescription ?? null
                    formData.value.itemAddDescription = items[0].itemAddDescription ?? null
                    formData.value.itemMake = items[0].itemMake ?? null
                    formData.value.itemHsnNumber = items[0].itemHsnNumber ?? null
                    formData.value.itemMsnNumber = items[0].itemMsnNumber ?? null
                    formData.value.itemDetailDescription = items[0].itemDetailDescription ?? null
                    formData.value.itemDrawingNumber = items[0].itemDrawingNumber ?? null
                    formData.value.itemDrawingRevision = items[0].itemDrawingRevision ?? null
                    formData.value.itemUom = items[0].itemUom ?? null
                    formData.value.itemConvUom = items[0].itemConvUom ?? null
                    formData.value.itemFactor = items[0].itemFactor ?? null
                    formData.value.itemConvQty = items[0].itemConvQty ?? null
                    formData.value.itemRequireQuantity = items[0].itemRequireQuantity ?? null
                    formData.value.itemQuantityUp = items[0].itemQuantityUp ?? null
                    formData.value.itemStore = items[0].itemStore ?? null
                    formData.value.itemSoNumber = items[0].itemSoNumber ?? null
                    formData.value.itemIndentNumber = items[0].itemIndentNumber ?? null
                    formData.value.itemStatus = items[0].itemStatus ?? null
                }else{
                    resetFormData()
                }
            }

            const getItemDetails = async (id) => {
                await axios.get(`/api/item-master/${id}`).then(res => {
                    formData.value.itemDescription = res.data.data.itemDescription
                    formData.value.itemAddDescription = res.data.data?.itemDetails?.description ?? null
                    formData.value.itemMake = res.data.data?.make ?? null
                    formData.value.itemDetailDescription = res.data.data?.itemDetails?.detailDescription ?? null
                    formData.value.itemDrawingNumber = res.data.data?.itemDetails?.drawingNumber ?? null
                    formData.value.itemDrawingRevision = res.data.data?.itemDetails?.revision ?? null
                    formData.value.itemUom = res.data.data?.uom ?? null
                    formData.value.itemHsnNumber = res.data.data?.hsnSacDetails?.hsnSacNo ?? null
                    formData.value.itemConvUom = res.data.data?.convUom ?? null
                    formData.value.itemFactor = res.data.data?.cFactor ?? null
                    formData.value.itemConvQty = res.data.data?.convQty ?? null
                    formData.value.itemStatus = res.data.data?.status ?? null
                    formData.value.itemId = res.data.data?._id ?? null
                })
            }

            const modalTables = ref({
                salesOrderFields: [
                    {
                        key: 'selectCheckBox',
                        label: ''
                    },
                    {
                        key: 'salesOrderNo',
                        label: 'S.O.No',
                    },
                    {
                        key: 'po_number.customerPoNo',
                        label: 'Cust. P. O.',
                    },
                    {
                        key: 'itemCode',
                        label: 'Item Code',
                    },
                    {
                        key: 'itemName',
                        label: 'Description',
                    },
                    {
                        key: 'uom_details.uom',
                        label: 'uom',
                    },
                    {
                        key: 'itemDrawingNo',
                        label: 'Drawing No',
                    },
                    {
                        key: 'itemDrawingRev',
                        label: 'Rev',
                    },
                    {
                        key: 'itemQuantity',
                        label: 'Quantity',
                    },
                    {
                        key: 'itemRate',
                        label: 'Rate',
                    },
                    {
                        key: 'itemPendingQuantity',
                        label: 'Pending Qty',
                    },
                    {
                        key: 'itemCustPartNo',
                        label: 'Cust Part No',
                    },
                    {
                        key: 'itemCustomDescription',
                        label: 'SItemDescription',
                    },
                ],
                salesOrderData: [],
                indentFields: [
                    {
                        key: 'selectCheckBox',
                        label: ''
                    },
                    {
                        key: 'indentNo',
                        label: 'Indent No.'
                    },
                    {
                        key: 'indentDate',
                        label: 'Date',
                        // formatter: val => forMatIndianDate(val)
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
                        key: 'uom_details.uom',
                        label: 'uom'
                    },
                    {
                        key: 'drawingNumber',
                        label: 'Drg No'
                    },
                    {
                        key: 'rev',
                        label: 'Rev'
                    },
                    {
                        key: 'reqQtyUm',
                        label: 'Qty UM'
                    },
                    {
                        key: 'qtyNos',
                        label: 'Quantity'
                    },
                    {
                        key: 'planAgaint',
                        label: 'Plann Against'
                    },
                    {
                        key: 'soNumber',
                        label: 'So No.'
                    },
                    {
                        key: 'woNumber',
                        label: 'Wo No.'
                    },
                ],
                indentData: [],
            })
            const searchSoData = ref({
                salesOrderNo: null,
                itemCode: null,
                itemDetailDescription: null,
                itemDrawingNo: null,
            })

            const getSalesOrderFilter = async () => {
                isModalTableBusy.value = true
                await axios.post('/api/new/get-sales-orders-item-filters', searchSoData.value).then((res) => {
                    modalTables.value.salesOrderData = res.data.data
                })
                isModalTableBusy.value = false
            }
            const searchData = ref({
                indentNo: null,
                itemCode: null,
                itemDescription: null,
                drawingNumber: null,
            })
            const getIndentFilter = async () => {
                isModalTableBusy.value = true
                await axios.post('/api/new/get-Indent-Approval-item-filter', searchData.value).then((res) => {
                    modalTables.value.indentData = res.data.data
                })
                isModalTableBusy.value = false
            }


            const getSalesItemDetailWithFilter = async () => {
                await axios.post('/api/get-sales-order-items-details-filter').then(res => {
                    modalTables.value.salesOrderData = res.data.data
                })
            }

            const getIndentItemDetailWithFilter = async () => {
                await axios.post("/api/mrp/get-indent-with-filter").then((res) => {
                    console.log(res.data.data)
                    modalTables.value.indentData = res.data.data;
                });
            };

            const openModal = async () => {
                switch (selectedRadio.value) {
                    case '1':
                        await getSalesItemDetailWithFilter()
                        return salesOrderModal.value.show();

                    case '2':
                        await getIndentItemDetailWithFilter()
                        return indentModal.value.show();

                    default:
                        return toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Error',
                                icon: 'AlertCircleIcon',
                                variant: 'danger',
                                text: 'Please Select Any Item.',
                            },
                        })
                }
            }

            const salesOrderIds = ref([])

            const checkItem = (e, id) => {
                if (e === false) {
                    salesOrderIds.value = salesOrderIds.value.filter(function (e) {
                        return e !== id
                    })
                } else {
                    salesOrderIds.value.push(id)
                }
            }

            const indentItemIds = ref([])

            const checkIndentItem = (e, id) => {
                if (e === false) {
                    indentItemIds.value = indentItemIds.value.filter(function (e) {
                        return e !== id
                    })
                } else {
                    indentItemIds.value.push(id)
                }
            }

            const addSalesOrderItemDetails = async () => {
                await axios.post('/api/add-purchase-item-from-sales-order', {
                    type: selectedRadio.value,
                    ids: salesOrderIds.value,
                    referenceId: router.currentRoute.params.id
                }).then(res => {
                    if (res.status === 200) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Purchase Enquiry Item Added',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: `You have successfully Added Purchase Enquiry Item.`,
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
                resetSalesOrderItemDetails()
                await refetchData()
            }

            const resetSalesOrderItemDetails = () => {
                salesOrderIds.value = []
            }

            const addIndentItemDetails = async () => {
                await axios.post('/api/add-purchase-item-from-indent', {
                    type: selectedRadio.value,
                    ids: indentItemIds.value,
                    referenceId: router.currentRoute.params.id
                }).then(res => {
                    if (res.status === 200) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Purchase Enquiry Item Added',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: `You have successfully Added Purchase Enquiry Item.`,
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
                resetIndentItemDetails()
                await refetchData()
            }

            const resetIndentItemDetails = () => {
                indentItemIds.value = []
            }

            const saveFormData = async () => {
                if (formData.value._id === null) {
                    await store.dispatch('purchase-store-module/addPurchaseEnquiryItemDetail', formData.value).then(res => {
                        if (res.status === 200) {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Purchase Enquiry Item Added',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: `You have successfully Added Purchase Enquiry Item.`,
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
                    await store.dispatch('purchase-store-module/updatePurchaseEnquiryItemDetail', formData.value).then(res => {
                        if (res.status === 200) {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Purchase Enquiry Item Updated',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: `You have successfully Updated Purchase Enquiry Item.`,
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
            }

            const deleteItemDetails = async (id) => {
                await Swal.fire({
                    title: 'Are you sure?',
                    text: "Delete Purchase Enquiry Item",
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
                        store.dispatch('purchase-store-module/deletePurchaseEnquiryItemDetail', {id: id}).then(res => {
                            if (res.status === 200) {
                                toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: 'Item Details Deleted',
                                        icon: 'CheckSquareIcon',
                                        variant: 'success',
                                        text: `You have successfully Deleted Item Details.`,
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

            const calculateAmount = () => {
                formData.value.itemRequireQuantityConv = formData.value.itemRequireQuantity * formData.value.itemFactor * formData.value.itemConvQty
            }


            const {refFormObserver, getValidationState, resetForm} = formValidation(resetFormData)

            return {
                isBusy,
                salesOrderModal,
                indentModal,
                tableFields,
                tableData,
                refetchData,
                itemsOptions,
                uomOptions,
                statusOptions,
                selectedRadio,
                formData,
                resetFormData,
                getItemDetails,
                modalTables,
                getSalesItemDetailWithFilter,
                getIndentItemDetailWithFilter,
                openModal,
                salesOrderIds,
                checkItem,
                indentItemIds,
                checkIndentItem,
                addSalesOrderItemDetails,
                resetSalesOrderItemDetails,
                addIndentItemDetails,
                resetIndentItemDetails,
                saveFormData,
                deleteItemDetails,

                refFormObserver,
                getValidationState,
                resetForm,
                isModalTableBusy,
                searchSoData,
                getSalesOrderFilter,
                searchData,
                getIndentFilter,
                makeOption,
                storeOption,
                calculateAmount,
                onRowSelected
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
