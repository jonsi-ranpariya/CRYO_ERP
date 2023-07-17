<template>
    <div>
        <!--Assembly Details-->
        <b-overlay
            :show="showOverlayLoading"
            rounded="sm"
        >
            <b-card-code>
                <b-row>
                    <b-col md="12">
                        <h5>Assembly Details</h5>
                        <hr>
                    </b-col>
                </b-row>
                <b-row>
                    <b-col md="6">
                        <validation-provider
                            #default="{ errors }"
                            name="Item code"
                            rules="required"
                        >
                            <b-form-group
                                label="Item code"
                                label-for="itemCode"
                                :state="errors.length > 0 ? false:null"
                            >

                                <v-select
                                    placeholder="Select Item"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="itemListOptions"
                                    :reduce="val => val.value"
                                    :clearable="false"
                                    input-id="itemCode"
                                    @input="getItemDetails($event)"
                                    v-model="formData.itemCode"
                                    disabled
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
                                :state="getValidationState(validationContext)"
                            >
                                <b-form-input
                                    id="itemDescription"
                                    v-model="formData.itemDescription"
                                    :state="getValidationState(validationContext)"
                                    disabled
                                />
                                <b-form-invalid-feedback>
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
                                label="Add. Description"
                                label-for="addDescription"
                                :state="getValidationState(validationContext)"
                            >
                                <b-form-input
                                    id="addDescription"
                                    v-model="formData.addDescription"
                                    :state="getValidationState(validationContext)"
                                    disabled
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
                                label-for="drawingNumber"
                                :state="getValidationState(validationContext)"
                            >
                                <b-form-input
                                    id="drawingNumber"
                                    v-model="formData.drawingNumber"
                                    :state="getValidationState(validationContext)"
                                    disabled
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
                            name="Drawing Revision"
                            rules=""
                        >
                            <b-form-group
                                label="Drawing Revision"
                                label-for="drawingRevision"
                                :state="getValidationState(validationContext)"
                            >
                                <b-form-input
                                    id="drawingRevision"
                                    v-model="formData.drawingRevision"
                                    type="number"
                                    :state="getValidationState(validationContext)"
                                    disabled
                                />
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>

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
                                    placeholder="Select UOM"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="uomListOptions"
                                    :reduce="val => val.value"
                                    :clearable="false"
                                    input-id="uom"
                                    v-model="formData.uom"
                                    disabled
                                />
                                <small class="text-danger">{{ errors[0] }}</small>
                            </b-form-group>
                        </validation-provider>
                        <validation-provider
                            #default="validationContext"
                            name="Detail Description"
                            rules=""
                        >
                            <b-form-group
                                label="Detail Description"
                                label-for="detailDescription"
                                :state="getValidationState(validationContext)"
                            >
                                <b-form-textarea
                                    id="detailDescription"
                                    rows="3"
                                    v-model="formData.detailDescription"
                                    :state="getValidationState(validationContext)"
                                    disabled
                                />
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                    </b-col>
                </b-row>
            </b-card-code>
        </b-overlay>
        <!--BOM Version-->
        <b-overlay
            :show="showOverlayLoading"
            rounded="sm"
        >
            <b-card-code>
                <!-- Button Area-->
                <b-row>
                    <b-col md="9"></b-col>
                    <b-col md="3">
                        <b-button
                            variant="primary"
                            class="float-right"
                            @click="openModalBom"
                        >
                            Copy BOM
                        </b-button>
                    </b-col>
                    <!--                    <b-col md="3">
                                            <b-button
                                                class="float-right"
                                                variant="primary"
                                                @click="openModalBomFromWo"
                                            >
                                                Copy BOM From WO
                                            </b-button>
                                        </b-col>-->
                </b-row>
                <!-- Table Area-->
                <b-row>
                    <b-col md="12">
                        <h5>BOM Version</h5>
                        <hr>
                        <b-table
                            :fields="bomVersionRows"
                            :items="bomVersionData"
                            :bordered="true"
                            :hover="true"
                            show-empty
                            class="table_scroll"
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

                            <!-- Index No -->
                            <template #cell(index)="data">
                                {{ data.index + 1 }}
                            </template>

                            <!-- Options Area -->
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
                                    <b-dropdown-item @click="openBomVersion(data.item._id)">
                                        <feather-icon
                                            icon="CheckSquareIcon"
                                            class="mr-50"
                                        />
                                        <span>Open</span>
                                    </b-dropdown-item>
                                    <!-- <b-dropdown-item @click="editBomVersionForm(data.item)">
                                            <feather-icon
                                                icon="Edit2Icon"
                                                class="mr-50"
                                            />
                                            <span>Edit</span>
                                        </b-dropdown-item>-->
                                    <b-dropdown-item @click="deleteBomVersion(data.item._id)">
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
                <!-- Form Area-->
                <validation-observer #default="{ handleSubmit }">
                    <b-form @submit.prevent="handleSubmit(versionFormSubmit)">
                        <b-row>
                            <b-col md="6">
                                <validation-provider
                                    #default="validationContext"
                                    name="BOM No."
                                    rules=""
                                >
                                    <b-form-group
                                        label="BOM No."
                                        label-for="bomNumber"
                                        :state="getValidationState(validationContext)"
                                    >
                                        <b-form-input
                                            id="bomNumber"
                                            v-model="bomVersionFormData.bomNumber"
                                            :state="getValidationState(validationContext)"
                                            disabled
                                        />
                                        <b-form-invalid-feedback>
                                            {{ validationContext.errors[0] }}
                                        </b-form-invalid-feedback>
                                    </b-form-group>
                                </validation-provider>
                                <validation-provider
                                    #default="validationContext"
                                    name="Description"
                                    rules=""
                                >
                                    <b-form-group
                                        label="Description"
                                        label-for="description"
                                        :state="getValidationState(validationContext)"
                                    >
                                        <b-form-input
                                            id="description"
                                            v-model="bomVersionFormData.bomDescription"
                                            :state="getValidationState(validationContext)"
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
                                        label-for="bomDrawingNumber"
                                        :state="getValidationState(validationContext)"
                                    >
                                        <b-form-input
                                            id="bomDrawingNumber"
                                            v-model="bomVersionFormData.bomDrawingNumber"
                                            :state="getValidationState(validationContext)"
                                        />
                                        <b-form-invalid-feedback>
                                            {{ validationContext.errors[0] }}
                                        </b-form-invalid-feedback>
                                    </b-form-group>
                                </validation-provider>
                                <validation-provider
                                    #default="validationContext"
                                    name="Drawing Revision"
                                    rules=""
                                >
                                    <b-form-group
                                        label="Drawing Revision"
                                        label-for="bomDrawingRevision"
                                        :state="getValidationState(validationContext)"
                                    >
                                        <b-form-input
                                            id="bomDrawingRevision"
                                            v-model="bomVersionFormData.bomDrawingRevision"
                                            :state="getValidationState(validationContext)"
                                        />
                                        <b-form-invalid-feedback>
                                            {{ validationContext.errors[0] }}
                                        </b-form-invalid-feedback>
                                    </b-form-group>
                                </validation-provider>
                                <validation-provider
                                    #default="validationContext"
                                    name="Valid From"
                                    rules=""
                                >
                                    <b-form-group
                                        label="Valid From"
                                        label-for="validFrom"
                                        :state="getValidationState(validationContext)"
                                    >
                                        <b-input-group>
                                            <cleave
                                                id="jobCardDate"
                                                v-model="bomVersionFormData.bomValidFrom"
                                                class="form-control"
                                                :raw="false"
                                                :options="dateFormat"
                                                placeholder="DD/MM/YYYY"
                                                show-decade-nav
                                                :state="getValidationState(validationContext)"
                                            />
                                            <b-input-group-append>
                                                <b-form-datepicker
                                                    v-model="formatDates.bomValidFrom"
                                                    button-only
                                                    @input="getBomFormateDate($event)"
                                                    show-decade-nav
                                                    size="sm"
                                                    nav-button-variant="primary"
                                                    :state="getValidationState(validationContext)"
                                                />
                                            </b-input-group-append>
                                        </b-input-group>
                                        <b-form-invalid-feedback>
                                            {{ validationContext.errors[0] }}
                                        </b-form-invalid-feedback>
                                    </b-form-group>
                                </validation-provider>
                            </b-col>
                            <b-col md="6">
                                <validation-provider
                                    #default="validationContext"
                                    name="Bom Unit Qty"
                                    rules=""
                                >
                                    <b-form-group
                                        label="Bom Unit Qty"
                                        label-for="bomUnit"
                                        :state="getValidationState(validationContext)"
                                    >
                                        <b-form-input
                                            id="bomUnit"
                                            :state="getValidationState(validationContext)"
                                            type="number"
                                            v-model="bomVersionFormData.bomUnit"
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
                                        label-for="note"
                                        :state="getValidationState(validationContext)"
                                    >
                                        <b-form-textarea
                                            id="note"
                                            :state="getValidationState(validationContext)"
                                            rows="5"
                                            v-model="bomVersionFormData.bomNote"
                                        />
                                        <b-form-invalid-feedback>
                                            {{ validationContext.errors[0] }}
                                        </b-form-invalid-feedback>
                                    </b-form-group>
                                </validation-provider>
                                <b-row>
                                    <b-col md="6">
                                        <b-form-checkbox
                                            value="1"
                                            class="custom-control-primary mt-1"
                                            v-model="bomVersionFormData.bomActive"
                                        >
                                            Active BOM
                                        </b-form-checkbox>
                                    </b-col>
                                    <b-col md="6">
                                        <b-form-checkbox
                                            value="1"
                                            class="custom-control-primary mt-1"
                                            v-model="bomVersionFormData.bomDefault"
                                        >
                                            Default BOM
                                        </b-form-checkbox>
                                    </b-col>
                                </b-row>
                            </b-col>
                            <b-col md="12">
                                <hr>
                                <b-button
                                    type="submit"
                                    variant="primary"
                                    class="float-right"
                                >
                                    Save
                                </b-button>
                            </b-col>
                        </b-row>
                    </b-form>
                </validation-observer>
            </b-card-code>
        </b-overlay>
        <!--Login Details-->
        <b-overlay
            :show="showOverlayLoading"
            rounded="sm"
        >
            <b-card-code>
                <b-row>
                    <b-col md="6">
                        <hr>
                        <h5 class="text-center">Login Details</h5>
                        <hr>
                        <b-form-group
                            label="Created By"
                            label-for="createdBy"
                        >
                            <b-form-input
                                id="createdBy"
                                v-model="loginDetails.createdBy"
                                disabled
                            />
                        </b-form-group>
                        <b-form-group
                            label="Date & Time"
                            label-for="dateTimeCreatedBy"
                        >
                            <b-form-input
                                id="dateTimeCreatedBy"
                                v-model="loginDetails.createdDateAndTime"
                                disabled
                            />
                        </b-form-group>
                        <b-form-group
                            label="Updated By"
                            label-for="updatedBy"
                        >
                            <b-form-input
                                id="updatedBy"
                                v-model="loginDetails.updatedBy"
                                disabled
                            />
                        </b-form-group>
                        <b-form-group
                            label="Date & Time"
                            label-for="dateTimeUpdateBy"
                        >
                            <b-form-input
                                id="dateTimeUpdateBy"
                                v-model="loginDetails.updatedDateAndTime"
                                disabled
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="6">
                        <hr>
                        <h5 class="text-center">Approval Status</h5>
                        <hr>
                        <b-form-group
                            label="Approved By"
                            label-for="approvedBy"
                        >
                            <b-form-input
                                id="approvedBy"
                                disabled
                            />
                        </b-form-group>
                        <b-form-group
                            label="Date & Time"
                            label-for="dateTimeApprovedBy"
                        >
                            <b-form-input
                                id="dateTimeApprovedBy"
                                disabled
                            />
                        </b-form-group>
                        <b-form-group
                            label="Stage"
                            label-for="stage"
                        >
                            <b-form-input
                                id="stage"
                                disabled
                            />
                        </b-form-group>
                    </b-col>
                </b-row>

            </b-card-code>
        </b-overlay>

        <!--Modal-->
        <b-modal
            id="bomItemMasterModal"
            ref="bomItemMasterModal"
            title="Select Item"
            ok-title="Copy"
            cancel-variant="danger"
            size="xl"
            no-close-on-backdrop
            @ok="saveItemMasterDetail"
        >
            <b-row>
                <b-col md="4">
                    <b-form-group
                        label="Item Code"
                        label-for="itemCode"
                    >
                        <b-form-input
                            id="itemCode"
                            v-model="searchData.itemCode"
                            @keyup="getBomDetailFilter"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="4">
                    <b-form-group
                        label="Item Description"
                        label-for="itemDescription"
                    >
                        <b-form-input
                            id="itemDescriptions"
                            v-model="searchData.itemDescription"
                            @keyup="getBomDetailFilter"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="4">
                    <b-form-group
                        label="Drawing Number"
                        label-for="drawingNumber"
                    >
                        <b-form-input
                            id="drawingNumbers"
                            v-model="searchData.drawingNumber"
                            @keyup="getBomDetailFilter"
                        />
                    </b-form-group>
                </b-col>
            </b-row>
            <!--table-->
            <b-table
                :fields="modalData.fields"
                :items="modalData.data"
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
                <!-- Checkbox -->
                <template #cell(selectCheckBox)="data">
                    <b-form-checkbox
                        :value="`${data.item._id}`"
                        class="custom-control-primary"
                        @change="selectedBomItemIds($event, data.item._id)"
                    />
                </template>
            </b-table>
        </b-modal>
        <!--copy bom from wo -->
        <b-modal
            id="woItemMasterModal"
            ref="woItemMasterModal"
            title="Select Item"
            ok-title="Copy"
            cancel-variant="danger"
            size="xl"
            no-close-on-backdrop
            @ok="saveWoItemMasterDetail"
        >
            <b-row>
                <b-col md="4">
                    <b-form-group
                        label="Item Code"
                        label-for="itemCode"
                    >
                        <b-form-input
                            id="itemCodes"
                            v-model="searchDatas.assemblyCode"
                            @keyup="getWoDetailFilter"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="4">
                    <b-form-group
                        label="Item Description"
                        label-for="itemDescription"
                    >
                        <b-form-input
                            id="itemsDescription"
                            v-model="searchDatas.assembly"
                            @keyup="getWoDetailFilter"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="4">
                    <b-form-group
                        label="Drawing Number"
                        label-for="drawingNumber"
                    >
                        <b-form-input
                            id="drawingsNumbers"
                            v-model="searchDatas.drawingNo"
                            @keyup="getWoDetailFilter"
                        />
                    </b-form-group>
                </b-col>
            </b-row>
            <!--table-->
            <b-table
                :fields="modalData.woFields"
                :items="modalData.woData"
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
                <!-- Checkbox -->
                <template #cell(selectCheckBox)="data">
                    <b-form-checkbox
                        :value="`${data.item._id}`"
                        class="custom-control-primary"
                        @change="selectedWoItemIds($event, data.item._id)"
                    />
                </template>
            </b-table>
        </b-modal>
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
    BInputGroup,
    BInputGroupAppend,
} from 'bootstrap-vue'
import { required } from '@validations'
import formValidation from '@core/comp-functions/forms/form-validation'
import Ripple from 'vue-ripple-directive'
import vSelect from 'vue-select'
import store from '@/store'
import router from '@/router'
import Toastification from '@core/components/toastification/ToastificationContent.vue'
import { useToast } from 'vue-toastification/composition'
import { ref, onUnmounted } from '@vue/composition-api'
import axios from '@axios'
import { forMatIndianDateAndTime, forMatIndianDate } from '@core/utils/utils'
import bomStoreModule from '../bomStoreModule'
import Cleave from 'vue-cleave-component'
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
        vSelect,
        Cleave,
        BInputGroup,
        BInputGroupAppend
    },
    directives: {
        Ripple,
    },
    setup({
        bomItemMasterModal,
        woItemMasterModal
    }) {
        bomItemMasterModal = ref()
        woItemMasterModal = ref()
        const isModalTableBusy = ref(false)

        const DM_APP_STORE_MODULE_NAME = 'bom-module'
        // Register module
        if (!store.hasModule(DM_APP_STORE_MODULE_NAME)) store.registerModule(DM_APP_STORE_MODULE_NAME, bomStoreModule)
        // UnRegister on leave
        onUnmounted(() => {
            if (store.hasModule(DM_APP_STORE_MODULE_NAME)) store.unregisterModule(DM_APP_STORE_MODULE_NAME)
        })

        const toast = useToast()

        const dateFormat = ref({
            date: true,
            delimiter: '/',
            datePattern: ['d', 'm', 'Y'],
        })

        const formatDates = ref({
            bomValidFrom: null,
        })

        const getBomFormateDate = (date) => {
            bomVersionFormData.value.bomValidFrom = forMatIndianDate(date)
        }

        const blankFormData = {
            id: null,
            itemCode: null,
            itemDescription: null,
            addDescription: null,
            drawingNumber: null,
            drawingRevision: null,
            uom: null,
            detailDescription: null,
        }

        const formData = ref(JSON.parse(JSON.stringify(blankFormData)))

        const resetFormData = () => {
            formData.value = JSON.parse(JSON.stringify(blankFormData))
        }

        const showOverlayLoading = ref(true)
        const isBusy = ref(true)

        const getBillOFMaterial = async () => {
            showOverlayLoading.value = true
            isBusy.value = false
            await store.dispatch('bom-module/fetchBillOfMaterial', { id: router.currentRoute.params.id })
                .then(res => {
                    formData.value.id = res.data.data._id
                    formData.value.itemCode = res.data.data.itemCode
                    formData.value.itemDescription = res.data.data.itemDescription
                    formData.value.addDescription = res.data.data.addDescription
                    formData.value.drawingNumber = res.data.data.drawingNumber
                    formData.value.drawingRevision = res.data.data.drawingRevision
                    formData.value.uom = res.data.data.uom
                    formData.value.detailDescription = res.data.data.detailDescription
                    bomVersionData.value = res.data.data.bom_version
                    loginDetails.value.createdBy = res.data.data.created_detail.first_name + ' ' + res.data.data.created_detail.last_name
                    loginDetails.value.createdDateAndTime = forMatIndianDateAndTime(res.data.data.created_at)
                    /*loginDetails.value.updatedBy = res.data.data.updated_detail ? res.data.data.updated_detail.first_name + ' ' + res.data.data.updated_detail.last_name : null
                    loginDetails.value.updatedDateAndTime = forMatIndianDateAndTime(res.data.data.updated_at)*/
                })
            showOverlayLoading.value = false
            isBusy.value = false
        }
        getBillOFMaterial()

        const itemListOptions = ref([])
        axios.get('/api/get-item-master-options')
            .then(res => {
                itemListOptions.value = res.data.data
                showOverlayLoading.value = false
            })

        const uomListOptions = ref([])
        showOverlayLoading.value = true
        axios.get('/api/get-uom-master-options')
            .then(res => {
                uomListOptions.value = res.data.data
                showOverlayLoading.value = false
            })

        const getItemDetails = async (id) => {
            await axios.get(`/api/item-master/${id}`)
                .then(res => {
                    formData.value.itemCode = res.data.data._id
                    formData.value.itemDescription = res.data.data.itemDescription
                    formData.value.detailDescription = res.data.data.itemDetails?.detailDescription ?? null
                    formData.value.drawingNumber = res.data.data.itemDetails?.drawingNumber ?? null
                    formData.value.drawingRevision = res.data.data.itemDetails?.revision ?? null
                    formData.value.uom = res.data.data.uom
                })
        }

        const modalData = ref({
            fields: [
                {
                    key: 'selectCheckBox',
                    label: ''
                },
                {
                    key: 'bom_detail.item_details.itemCode',
                    label: 'Item Code'
                },
                {
                    key: 'bom_detail.itemDescription',
                    label: 'Item Description'
                },
                {
                    key: 'bomDrawingNumber',
                    label: 'Drawing Number'
                },
                {
                    key: 'bomDrawingRevision',
                    label: 'Revision'
                },
                {
                    key: 'bomNumber',
                    label: 'Bom Number'
                },
                {
                    key: 'bomDescription',
                    label: 'Bom Description'
                }
            ],
            data: [],
            woFields: [
                {
                    key: 'selectCheckBox',
                    label: ''
                },
                {
                    key: 'woNumber',
                    label: 'Wo Number'
                },
                {
                    key: 'assemblyCode',
                    label: 'Item Code'
                },
                {
                    key: 'assembly',
                    label: 'Item Description'
                },
                {
                    key: 'drawingNo',
                    label: 'Drawing Number'
                },
                {
                    key: 'drawingRev',
                    label: 'Revision'
                },
                {
                    key: 'bomNo',
                    label: 'Bom Number'
                },
            ],
            woData: [],
        })

        const bomVersionRows = ref([
            {
                key: 'rowSelected',
                label: ''
            },
            {
                key: 'index',
                label: 'Sr No',
            },
            {
                key: 'bomNumber',
                label: 'Bom No.',
                sortable: true
            },
            {
                key: 'bomDescription',
                label: 'Bom Description'
            },
            {
                key: 'bomDrawingRevision',
                label: 'Drg. Revision'
            },
            {
                key: 'bomUnit',
                label: 'BOM Unit'
            },
            {
                key: 'action',
                label: 'action'
            }
        ])
        const bomVersionData = ref([])

        const saveWoItemMasterDetail = async () => {
        }

        const blankBomVersionFormData = {
            id: null,
            bomId: router.currentRoute.params.id,
            bomNumber: null,
            bomDescription: null,
            bomDrawingNumber: null,
            bomDrawingRevision: null,
            bomValidFrom: forMatIndianDate(),
            bomUnit: null,
            bomNote: null,
            bomActive: null,
            bomDefault: null,
        }

        const bomVersionFormData = ref(JSON.parse(JSON.stringify(blankBomVersionFormData)))

        const resetBomVersionFormData = () => {
            bomVersionFormData.value = JSON.parse(JSON.stringify(blankBomVersionFormData))
        }

        const searchData = ref({
            itemCode: null,
            itemDescription: null,
            drawingNumber: null,
        })

        const resetSearchData = () => {
            searchData.value.itemCode = null
            searchData.value.itemDescription = null
            searchData.value.drawingNumber = null
        }

        const ItemMasterList = ref([])
        const selectedBomItemIds = (e, id) => {
            if (e === false) {
                ItemMasterList.value = ItemMasterList.value.filter(function (e) {
                    return e !== id
                })
            } else {
                ItemMasterList.value.push(id)
            }
        }

        const WoItemList = ref([])
        const selectedWoItemIds = (e, id) => {
            if (e === false) {
                WoItemList.value = WoItemList.value.filter(function (e) {
                    return e !== id
                })
            } else {
                WoItemList.value.push(id)
            }
        }

        const searchDatas = ref({
            assemblyCode: null,
            assembly: null,
            drawingNo: null,
        })

        const getBomDetailFilter = async () => {
            isModalTableBusy.value = true
            await axios.post('/api/new/get-bom-item-filter', searchData.value)
                .then(res => {
                    modalData.value.data = res.data.data
                })
            isModalTableBusy.value = false
        }

        const getWoDetailFilter = async () => {
            isModalTableBusy.value = true
            await axios.post('/api/new/get-work-order-item-filter', searchDatas.value)
                .then(res => {
                    modalData.value.woData = res.data.data
                })
            isModalTableBusy.value = false
        }

        const openModalBom = async () => {
            bomItemMasterModal.value.show()
        }

        const openModalBomFromWo = () => {
            woItemMasterModal.value.show()
        }

        const saveItemMasterDetail = async () => {
            resetSearchData()
            if (bomVersionFormData.value.bomDescription === null) {
                toast({
                    component: Toastification,
                    position: 'top-right',
                    props: {
                        title: 'Warning',
                        icon: 'AlertCircleIcon',
                        variant: 'warning',
                        text: 'Please select any BOM Version for copy items.',
                    },
                })
                ItemMasterList.value = []
            } else if (ItemMasterList.value.length === 0) {
                toast({
                    component: Toastification,
                    position: 'top-right',
                    props: {
                        title: 'Warning',
                        icon: 'AlertCircleIcon',
                        variant: 'warning',
                        text: 'Please select BOM Version which one copy.',
                    },
                })
            } else {
                await axios.post('/api/new/add-copy-bom-item', {
                    ids: ItemMasterList.value,
                    bomVersionId: bomVersionFormData.value.id
                })
                    .then((res) => {
                        toast({
                            component: Toastification,
                            position: 'top-right',
                            props: {
                                title: 'BOM Version Items Copied',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: 'You have successfully Copy Bill Of Master Version Items',
                            },
                        })
                    })
            }
        }

        const editBomVersionForm = (data) => {
            bomVersionFormData.value.id = data._id
            bomVersionFormData.value.bomNumber = data.bomNumber
            bomVersionFormData.value.bomDescription = data.bomDescription
            bomVersionFormData.value.bomDrawingNumber = data.bomDrawingNumber ?? null
            bomVersionFormData.value.bomDrawingRevision = data.bomDrawingRevision ?? null
            bomVersionFormData.value.bomValidFrom = data.bomValidFrom ?? null
            bomVersionFormData.value.bomUnit = data.bomUnit ?? null
            bomVersionFormData.value.bomNote = data.bomNote ?? null
            bomVersionFormData.value.bomActive = data.bomActive ?? null
            bomVersionFormData.value.bomDefault = data.bomDefault ?? null
        }

        const versionFormSubmit = async () => {
            if (bomVersionFormData.value.id !== null) {
                await store.dispatch('bom-module/updateBillOfMaterialVersion', bomVersionFormData.value)
                    .then(res => {
                        if (res.data.status === 200) {
                            toast({
                                component: Toastification,
                                position: 'top-right',
                                props: {
                                    title: 'BOM Version Updated',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: 'You have successfully Updated Bill Of Master Version',
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
                await store.dispatch('bom-module/addBillOfMaterialVersion', bomVersionFormData.value)
                    .then(res => {
                        if (res.data.status === 200) {
                            toast({
                                component: Toastification,
                                position: 'top-right',
                                props: {
                                    title: 'BOM Version Added',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: 'You have successfully Added Bill Of Master Version',
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
            resetBomVersionFormData()
            await getBillOFMaterial()
        }

        const deleteBomVersion = async (id) => {
            await Swal.fire({
                title: 'Are you sure?',
                text: 'Delete BOM Version? It won\'t be revert.',
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
                        store.dispatch('bom-module/deleteBillOfMaterialVersion', { id: id })
                            .then(res => {
                                if (res.data.status === 200) {
                                    toast({
                                        component: Toastification,
                                        position: 'top-right',
                                        props: {
                                            title: 'BOM Version Deleted',
                                            icon: 'CheckSquareIcon',
                                            variant: 'success',
                                            text: 'You have successfully Deleted Bill Of Master Version',
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
                                resetBomVersionFormData()
                                getBillOFMaterial()
                            })
                    }
                })
        }

        const openBomVersion = (id) => {
            router.push({
                name: 'edit-bill-of-material-version',
                params: {
                    versionId: id
                }
            })
        }

        const loginDetails = ref({
            createdBy: null,
            updatedBy: null,
            createdDateAndTime: null,
            updatedDateAndTime: null
        })

        const onRowSelected = (items) => {
            if (items.length > 0) {
                bomVersionFormData.value.id = items[0]._id
                bomVersionFormData.value.bomNumber = items[0].bomNumber
                bomVersionFormData.value.bomDescription = items[0].bomDescription
                bomVersionFormData.value.bomDrawingNumber = items[0].bomDrawingNumber ?? null
                bomVersionFormData.value.bomDrawingRevision = items[0].bomDrawingRevision ?? null
                bomVersionFormData.value.bomValidFrom = items[0].bomValidFrom ?? null
                bomVersionFormData.value.bomUnit = items[0].bomUnit ?? null
                bomVersionFormData.value.bomNote = items[0].bomNote ?? null
                bomVersionFormData.value.bomActive = items[0].bomActive ?? null
                bomVersionFormData.value.bomDefault = items[0].bomDefault ?? null
            } else {
                resetBomVersionFormData()
            }
        }

        const {
            refFormObserver,
            getValidationState,
            resetForm
        } = formValidation(resetBomVersionFormData)

        return {
            showOverlayLoading,
            itemListOptions,
            uomListOptions,
            getItemDetails,
            formData,
            resetFormData,
            isBusy,
            bomVersionRows,
            bomVersionData,
            bomVersionFormData,
            editBomVersionForm,
            versionFormSubmit,
            deleteBomVersion,
            resetBomVersionFormData,
            openBomVersion,
            loginDetails,

            /*Form Observer and validator*/
            refFormObserver,
            getValidationState,
            resetForm,
            dateFormat,
            formatDates,
            getBomFormateDate,
            openModalBom,
            openModalBomFromWo,
            searchData,
            getBomDetailFilter,
            modalData,
            isModalTableBusy,
            bomItemMasterModal,
            ItemMasterList,
            selectedBomItemIds,
            saveItemMasterDetail,
            woItemMasterModal,
            getWoDetailFilter,
            searchDatas,
            saveWoItemMasterDetail,
            WoItemList,
            selectedWoItemIds,
            onRowSelected,
            required
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
