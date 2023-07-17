<template>
    <div>
        <b-overlay
            :show="showOverlayLoading"
            rounded="sm"
        >
            <b-card-code>
                <validation-observer #default="{ handleSubmit }">
                    <b-form @submit.prevent="handleSubmit(saveFormData)">
                        <b-row>
                            <b-col md="12">
                                <h5>Work Order Details</h5>
                                <hr>
                            </b-col>
                            <b-col md="6">
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
                                                    id="woNumber"
                                                    v-model="formData.woNumber"
                                                    readonly
                                                    :state="getValidationState(validationContext)"
                                                />
                                            </b-form-group>
                                        </validation-provider>
                                    </b-col>
                                    <b-col md="6">
                                        <validation-provider
                                            #default="validationContext"
                                            name="W.O. Date"
                                            rules=""
                                        >
                                            <b-form-group
                                                label="W.O. Date"
                                                label-for="woDate"
                                            >
                                                <b-input-group>
                                                    <cleave
                                                        id="woDate"
                                                        v-model="formData.woDate"
                                                        class="form-control"
                                                        :raw="false"
                                                        :options="dateFormat"
                                                        placeholder="DD/MM/YYYY"
                                                        show-decade-nav
                                                    />
                                                    <b-input-group-append>
                                                        <b-form-datepicker
                                                            v-model="formatDates.woDate"
                                                            button-only
                                                            @input="getWoFormateDate($event)"
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
                                            name="S.O. No."
                                            rules=""
                                        >
                                            <b-form-group
                                                label="S.O.No."
                                                label-for="soNumber"
                                            >
                                                <b-form-input
                                                    id="soNumber"
                                                    readonly
                                                    v-model="formData.soNumber"
                                                    :state="getValidationState(validationContext)"
                                                />
                                            </b-form-group>
                                        </validation-provider>
                                    </b-col>
                                    <b-col md="6">
                                        <validation-provider
                                            #default="validationContext"
                                            name="S.O. Date"
                                            rules=""
                                        >
                                            <b-form-group
                                                label="S.O. Date"
                                                label-for="soDate"
                                            >
                                                <b-input-group>
                                                    <cleave
                                                        id="soDate"
                                                        v-model="formData.soDate"
                                                        class="form-control"
                                                        :raw="false"
                                                        :options="dateFormat"
                                                        placeholder="DD/MM/YYYY"
                                                        show-decade-nav
                                                        :state="getValidationState(validationContext)"
                                                    />
                                                    <b-input-group-append>
                                                        <b-form-datepicker
                                                            v-model="formatDates.soDate"
                                                            button-only
                                                            @input="getWoSoFormateDate($event)"
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
                                    name="Party"
                                    rules=""
                                >
                                    <b-form-group
                                        label="Party"
                                        label-for="partyCode"
                                    >
                                        <b-form-input
                                            id="partyCode"
                                            readonly
                                            v-model="formData.partyCode"
                                            :state="getValidationState(validationContext)"
                                        />
                                    </b-form-group>
                                </validation-provider>
                                <validation-provider
                                    #default="validationContext"
                                    name="Cust P.O.No."
                                    rules=""
                                >
                                    <b-form-group
                                        label="Cust P.O.No."
                                        label-for="custPoNumber"
                                    >
                                        <b-form-input
                                            id="custPoNumber"
                                            v-model="formData.custPoNo"
                                            :state="getValidationState(validationContext)"
                                        />
                                    </b-form-group>
                                </validation-provider>
                                <validation-provider
                                    #default="validationContext"
                                    name="Assembly Code"
                                    rules="required"
                                >
                                    <b-form-group
                                        label="Assembly Code"
                                        label-for="assemblyCode"
                                    >
                                        <b-form-input
                                            readonly
                                            v-model="formData.assemblyCode"
                                            :state="getValidationState(validationContext)"
                                        />
                                    </b-form-group>
                                    <b-form-invalid-feedback>
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </validation-provider>
                                <validation-provider
                                    #default="validationContext"
                                    name="Assembly"
                                    rules="required"
                                >
                                    <b-form-group
                                        label="Assembly"
                                        label-for="assembly"
                                    >
                                        <b-form-input
                                            id="assembly"
                                            readonly
                                            v-model="formData.assembly"
                                            :state="getValidationState(validationContext)"
                                        />
                                        <b-form-invalid-feedback>
                                            {{ validationContext.errors[0] }}
                                        </b-form-invalid-feedback>
                                    </b-form-group>
                                </validation-provider>
                                <validation-provider
                                    #default="validationContext"
                                    name="Make"
                                    rules=""
                                >
                                    <b-form-group
                                        label="Make"
                                        label-for="itemMake"
                                    >
                                        <vue-autosuggest
                                            v-model="formData.itemMake"
                                            :suggestions="makeFilteredOptions"
                                            :limit="10"
                                            :input-props="{id:'make',class:'form-control', placeholder:'Select Make'}"
                                            @input="onMakeInputChange($event)"
                                            @selected="onSelectedMake($event)"
                                        >
                                            <template slot-scope="{suggestion}">
                                                <span class="my-suggestion-item">{{ suggestion.item.label }}</span>
                                            </template>
                                        </vue-autosuggest>
                                    </b-form-group>
                                </validation-provider>
                                <b-row>
                                    <b-col md="6">
                                        <validation-provider
                                            #default="validationContext"
                                            name="Add. Description"
                                            rules=""
                                        >
                                            <b-form-group
                                                label="Add. Description"
                                                label-for="addDescription"
                                            >
                                                <b-form-input
                                                    id="addDescription"
                                                    v-model="formData.addDescription"
                                                    :state="getValidationState(validationContext)"
                                                />
                                            </b-form-group>
                                        </validation-provider>
                                    </b-col>
                                    <b-col md="6">
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
                                                    v-model="formData.detailDescription"
                                                    :state="getValidationState(validationContext)"
                                                />
                                            </b-form-group>
                                        </validation-provider>
                                    </b-col>
                                </b-row>
                                <validation-provider
                                    #default="validationContext"
                                    name="MSN No."
                                    rules=""
                                >
                                    <b-form-group
                                        label="MSN No."
                                        label-for="msnNumber"
                                    >
                                        <b-form-input
                                            id="msnNumber"
                                            v-model="formData.itemMsnNumber"
                                            :state="getValidationState(validationContext)"
                                        />
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
                                    >
                                        <b-form-input
                                            id="drawingNumber"
                                            v-model="formData.drawingNo"
                                            :state="getValidationState(validationContext)"
                                        />
                                    </b-form-group>
                                </validation-provider>
                                <validation-provider
                                    #default="validationContext"
                                    name="Rev"
                                    rules=""
                                >
                                    <b-form-group
                                        label="Rev"
                                        label-for="drawingRev"
                                    >
                                        <b-form-input
                                            id="drawingRev"
                                            v-model="formData.drawingRev"
                                            :state="getValidationState(validationContext)"
                                        />
                                    </b-form-group>
                                </validation-provider>
                                <validation-provider
                                    #default="validationContext"
                                    name="W.O. Quantity"
                                    rules=""
                                >
                                    <b-form-group
                                        label="W.O. Quantity"
                                        label-for="woQty"
                                    >
                                        <b-form-input
                                            id="woQty"
                                            v-model="formData.woQty"
                                            :state="getValidationState(validationContext)"
                                        />
                                    </b-form-group>
                                </validation-provider>
                            </b-col>
                            <b-col md="6">
                                <b-row>
                                    <b-col md="6">
                                        <validation-provider
                                            #default="validationContext"
                                            name="W.O. Type"
                                            rules=""
                                        >
                                            <b-form-group
                                                label="W.O. Type"
                                                label-for="woType"
                                            >
                                                <v-select
                                                    placeholder="Select Type"
                                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                                    :options="workOrderType"
                                                    :reduce="val => val.value"
                                                    :clearable="false"
                                                    input-id="woType"
                                                    v-model="formData.woType"
                                                    :state="getValidationState(validationContext)"
                                                />
                                            </b-form-group>
                                        </validation-provider>
                                    </b-col>
                                    <b-col md="6">
                                        <validation-provider
                                            #default="validationContext"
                                            name="Sales Type"
                                            rules=""
                                        >
                                            <b-form-group
                                                label="Sales Type"
                                                label-for="salesType"
                                            >
                                                <v-select
                                                    placeholder="Select Type"
                                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                                    :options="salesTypeOptions"
                                                    :reduce="val => val.value"
                                                    :clearable="false"
                                                    input-id="salesType"
                                                    v-model="formData.salesType"
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
                                    <b-col md="6">
                                        <validation-provider
                                            #default="validationContext"
                                            name="WO Status"
                                            rules=""
                                        >
                                            <b-form-group
                                                label="WO Status"
                                                label-for="woStatus"
                                            >
                                                <v-select
                                                    placeholder="Select Status"
                                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                                    :options="woStatusOptions"
                                                    :reduce="val => val.value"
                                                    :clearable="false"
                                                    input-id="woStatus"
                                                    v-model="formData.woStatus"
                                                    disabled
                                                    :state="getValidationState(validationContext)"
                                                />
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
                                        label-for="uom"
                                    >
                                        <v-select
                                            placeholder="Select UOM"
                                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                            :options="uomOptions"
                                            :reduce="val => val.value"
                                            :clearable="false"
                                            input-id="uom"
                                            v-model="formData.uom"
                                            :state="getValidationState(validationContext)"
                                        />
                                    </b-form-group>
                                </validation-provider>
                                <validation-provider
                                    #default="validationContext"
                                    name="BOM No."
                                    rules=""
                                >
                                    <b-form-group
                                        label="BOM No."
                                        label-for="bomNumber"
                                    >
                                        <v-select
                                            placeholder="Select BOM"
                                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                            :options="bomOptions"
                                            :reduce="val => val.value"
                                            :clearable="false"
                                            input-id="bomNumber"
                                            v-model="formData.bomNo"
                                            :state="getValidationState(validationContext)"
                                        />
                                    </b-form-group>
                                </validation-provider>
                                <validation-provider
                                    #default="validationContext"
                                    name="Prod. Engineer"
                                    rules=""
                                >
                                    <b-form-group
                                        label="Prod. Engineer"
                                        label-for="prodEngineer"
                                    >
                                        <v-select
                                            placeholder="Select Engineer"
                                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                            :options="userOptions"
                                            :reduce="val => val.value"
                                            :clearable="false"
                                            input-id="prodEngineer"
                                            v-model="formData.prodEngineer"
                                            :state="getValidationState(validationContext)"
                                        />
                                    </b-form-group>
                                </validation-provider>
                                <validation-provider
                                    #default="validationContext"
                                    name="P.O. Date"
                                    rules=""
                                >
                                    <b-form-group
                                        label="P.O. Date"
                                        label-for="poDate"
                                    >
                                        <b-input-group>
                                            <b-input-group-prepend>
                                                <b-form-datepicker
                                                    v-model="formatDates.poDate"
                                                    button-only
                                                    @input="getWoPoFormateDate($event)"
                                                    show-decade-nav
                                                    size="sm"
                                                    nav-button-variant="primary"
                                                />
                                            </b-input-group-prepend>
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
                                        </b-input-group>
                                    </b-form-group>
                                </validation-provider>
                                <validation-provider
                                    #default="validationContext"
                                    name="WO Start Date"
                                    rules=""
                                >
                                    <b-form-group
                                        label="WO Start Date"
                                        label-for="woStartDate"
                                    >
                                        <b-input-group>
                                            <b-input-group-prepend>
                                                <b-form-datepicker
                                                    v-model="formatDates.woStartDate"
                                                    button-only
                                                    @input="getWoStartFormateDate($event)"
                                                    show-decade-nav
                                                    size="sm"
                                                    nav-button-variant="primary"
                                                />
                                            </b-input-group-prepend>
                                            <cleave
                                                id="woStartDate"
                                                v-model="formData.woStartDate"
                                                class="form-control"
                                                :raw="false"
                                                :options="dateFormat"
                                                placeholder="DD/MM/YYYY"
                                                show-decade-nav
                                                :state="getValidationState(validationContext)"
                                            />
                                        </b-input-group>
                                    </b-form-group>
                                </validation-provider>
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
                                                    v-model="formatDates.woDeliveryDate"
                                                    button-only
                                                    @input="getWoDeliveryFormateDate($event)"
                                                    show-decade-nav
                                                    size="sm"
                                                    nav-button-variant="primary"
                                                />
                                            </b-input-group-prepend>
                                            <cleave
                                                id="woDeliveryDate"
                                                v-model="formData.woDeliveryDate"
                                                class="form-control"
                                                :raw="false"
                                                :options="dateFormat"
                                                placeholder="DD/MM/YYYY"
                                                show-decade-nav
                                                :state="getValidationState(validationContext)"
                                            />
                                        </b-input-group>
                                    </b-form-group>
                                </validation-provider>
                                <validation-provider
                                    #default="validationContext"
                                    name="D.S.No."
                                    rules=""
                                >
                                    <b-form-group
                                        label="D.S.No."
                                        label-for="dsNumber"
                                    >
                                        <b-form-input
                                            id="dsNumber"
                                            v-model="formData.dsNo"
                                            :state="getValidationState(validationContext)"
                                        />
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
                                            id="remark"
                                            rows="2"
                                            v-model="formData.remark"
                                            :state="getValidationState(validationContext)"
                                        />
                                    </b-form-group>
                                </validation-provider><br>
                                <b-form-checkbox
                                    id="conversion"
                                    class="custom-control-primary"
                                    v-model="formData.reGenerateWoItem"
                                >
                                    Re-Generate WO Items When Edit WO
                                </b-form-checkbox>
                            </b-col>
                            <b-col md="12">
                                <b-button
                                    class="mr-1"
                                    variant="primary"
                                >
                                    WO Shortage
                                </b-button>
                                <b-button
                                    class="mr-1"
                                    variant="primary"
                                >
                                    WO Details
                                </b-button>
                                <b-button
                                    class="mr-1"
                                    variant="primary"
                                >
                                    WO Label
                                </b-button>
                                <b-button
                                    class="mr-1"
                                    variant="primary"
                                >
                                    Stock Status
                                </b-button>
                                <b-button
                                    class="mr-1"
                                    variant="primary"
                                >
                                    Batch Details
                                </b-button>
                                <b-button
                                    class="mr-1"
                                    variant="primary"
                                >
                                    Material Availabel
                                </b-button>
                            </b-col><br><br><br>
                            <b-col md="12">
                                <b-button
                                    class="mr-1 mb-2"
                                    variant="primary"
                                >
                                    WO Shortage From BOM
                                </b-button>
                                <b-button
                                    class="mr-1 mb-2"
                                    variant="primary"
                                >
                                    Job Card Details
                                </b-button>
                                <b-button
                                    class="mr-1 mb-2"
                                    variant="primary"
                                >
                                    Work Order Issue Details
                                </b-button>
                                <b-button
                                    class="mr-1 mb-2"
                                    variant="primary"
                                >
                                    Convert to Stock Order
                                </b-button>
                            </b-col>
                            <b-col md="12">
                                <hr>
                                <b-button
                                    variant="primary"
                                    class="float-right"
                                    type="submit"
                                >
                                    Save
                                </b-button>
                                <b-button
                                    class="mr-1 float-right"
                                    variant="primary"
                                >
                                    SO Allocation
                                </b-button>
                                <b-button
                                    class="mr-1 float-right"
                                    variant="primary"
                                >
                                    Assign SO No.
                                </b-button>
                                <b-button
                                    class="mr-1 float-right"
                                    variant="primary"
                                >
                                    WO Progess
                                </b-button>
                                <b-button
                                    class="mr-1 float-right"
                                    variant="primary"
                                >
                                    WCN
                                </b-button>
                            </b-col>
                        </b-row>
                    </b-form>
                </validation-observer>
            </b-card-code>
            <b-card-code>
                <b-tabs
                    pills
                >
                    <b-tab active>
                        <template #title>
                            <feather-icon
                                icon="DatabaseIcon"
                                size="16"
                                class="mr-0 mr-sm-50"
                            />
                            <span class="d-none d-sm-inline">Items</span>
                        </template>
                        <items-tab />
                    </b-tab>
                    <b-tab>
                        <template #title>
                            <feather-icon
                                icon="ActivityIcon"
                                size="16"
                                class="mr-0 mr-sm-50"
                            />
                            <span class="d-none d-sm-inline">Routing</span>
                        </template>
                        <hr>
                        <routing-tab />
                    </b-tab>
                    <b-tab>
                        <template #title>
                            <feather-icon
                                icon="BookIcon"
                                size="16"
                                class="mr-0 mr-sm-50"
                            />
                            <span class="d-none d-sm-inline">Notes</span>
                        </template>
                        <note-details-tab />
                    </b-tab>
                    <b-tab >
                        <template #title>
                            <feather-icon
                                icon="LogInIcon"
                                size="16"
                                class="mr-0 mr-sm-50"
                            />
                            <span class="d-none d-sm-inline">Login</span>
                        </template>
                        <login-details-tab
                            :loginData.sync="formData.LoginData"
                        />
                    </b-tab>
                </b-tabs>
            </b-card-code>
        </b-overlay>
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
        BTabs,
        BTab,
        BInputGroupPrepend
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
    import {getUserData} from "../../../auth/utils";
    import moment from 'moment'
    import {getTcTodayDate, getSalesTypeListOption} from '@core/utils/utils'
    import productionPlanningStoreModule from '../productionPlanningStoreModule'
    import {useToast} from 'vue-toastification/composition'
    import router from '@/router'
    import NoteDetailsTab from "./tabs/noteDetailsTab";
    import LoginDetailsTab from "./tabs/loginDetailsTab";
    import ItemsTab from "./tabs/itemsTab";
    import RoutingTab from "./tabs/routingTab";
    import Cleave from 'vue-cleave-component'
    import {forMatIndianDate} from "../../../@core/utils/utils";
    import {VueAutosuggest} from 'vue-autosuggest'

    export default {
        components: {
            RoutingTab,
            ItemsTab,
            LoginDetailsTab,
            NoteDetailsTab,
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
            BTabs,
            BTab,
            vSelect,
            Cleave,
            BInputGroupPrepend,
            VueAutosuggest
        },
        directives: {
            Ripple,
        },
        setup() {

            const ITEMADDON_APP_STORE_MODULE_NAME = 'production-planning'
            if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, productionPlanningStoreModule)
            onUnmounted(() => {
                if (store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.unregisterModule(ITEMADDON_APP_STORE_MODULE_NAME)
            })

            const toast = useToast()

            const showOverlayLoading = ref(true)

            const CurrentUserData = ref(getUserData())

            const uomOptions = ref([])
            axios.get('/api/get-uom-master-options').then(res => {
                uomOptions.value = res.data.data
            })

            const bomOptions = ref([])
            axios.get('/api/get-bom-versions-options').then(res => {
                bomOptions.value = res.data.data
            })

            const userOptions = ref([])
            axios.get('/api/get-users-options').then(res => {
                userOptions.value = res.data.data
            })

            const makeFilteredOptions = ref([])

            const onMakeInputChange = (text) => {
                if (text === '' || text === undefined) {
                    return
                }
                const filteredData = makeDataSuggest.value.filter(item => item.label.toLowerCase().indexOf(text.toLowerCase()) > -1).slice(0, 10)
                makeFilteredOptions.value = [{
                    data: filteredData,
                }]
            }

            const onSelectedMake = (item) => {
                formData.value.itemMake = item.item.label;
            }

            const dateFormat = ref({
                date: true,
                delimiter: '/',
                datePattern: ['d', 'm', 'Y'],
            })

            const formatDates = ref({
                woDate: null,
                soDate: null,
                poDate: null,
                woStartDate: null,
                woDeliveryDate: null,
            })

            const getWoFormateDate = (date) => {
                formData.value.woDate = forMatIndianDate(date)
            }

            const getWoSoFormateDate = (date) => {
                formData.value.soDate = forMatIndianDate(date)
            }
            const getWoPoFormateDate = (date) => {
                formData.value.poDate = forMatIndianDate(date)
            }
            const getWoStartFormateDate = (date) => {
                formData.value.woStartDate = forMatIndianDate(date)
            }
            const getWoDeliveryFormateDate = (date) => {
                formData.value.woDeliveryDate = forMatIndianDate(date)
            }

            const workOrderType = ref([
                {label: 'Against Sales Order', value: 1},
                {label: 'Stock Order', value: 2},
                {label: 'Against Work Order', value: 3},
                {label: 'Against Replacement', value: 4},
                {label: 'Against Sample Trial', value: 5},
                {label: 'Against Shop Rejection', value: 6},
            ])

            const salesTypeOptions = getSalesTypeListOption()

            const statusOptions = ref([
                {label: 'Pending', value: 1},
            ])

            const woStatusOptions = ref([
                {label: 'Prepared', value: 1},
            ])

            const blankFormData = {
                id: null,
                woNumber: null,
                woDate: forMatIndianDate(getTcTodayDate()),
                soNumber: null,
                soDate: forMatIndianDate(),
                partyCode: null,
                custPoNo: null,
                itemId: null,
                assemblyCode: null,
                assembly: null,
                itemMake:null,
                addDescription: null,
                detailDescription: null,
                itemMsnNumber:null,
                drawingNo: null,
                drawingRev: null,
                woQty: null,
                woType: 1,
                salesType: null,
                status: 1,
                woStatus: 1,
                uom: null,
                bomNo: null,
                prodEngineer: null,
                poDate: forMatIndianDate(),
                woStartDate: forMatIndianDate(getTcTodayDate()),
                woDeliveryDate: forMatIndianDate(),
                dsNo: null,
                remark: null,
                reGenerateWoItem:null,
                LoginData: {
                    createdBy: null,
                    createdDate: null,
                    lastModifyBy: null,
                    lastModifyDate: null,
                    approveBy: null,
                    approveDate: null,
                }
            }

            const formData = ref(JSON.parse(JSON.stringify(blankFormData)))

            const resetFormData = () => {
                formData.value = JSON.parse(JSON.stringify(blankFormData))
            }

            axios.get(`/api/work-orders/${router.currentRoute.params.id}`).then(res => {
                formData.value = res.data.data
                formData.value.id = res.data.data._id
                delete res.data.data._id
                showOverlayLoading.value = false
            })

            const saveFormData = async () => {
                formData.value.LoginData.lastModifyBy = CurrentUserData.value.first_name + ' ' + CurrentUserData.value.last_name
                formData.value.LoginData.lastModifyDate = moment(new Date()).format('DD/MM/YYYY HH:mm')
                await store.dispatch('production-planning/updateWorkOrder', formData.value).then(res => {
                    if (res.status === 200) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Work Order Updated',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: `You have successfully Updated Work Order.`,
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
                    router.push({name: 'work-order'})
                })
            }

            const {refFormObserver, getValidationState, resetForm} = formValidation(resetFormData)

            return {
                showOverlayLoading,
                CurrentUserData,
                uomOptions,
                bomOptions,
                userOptions,
                workOrderType,
                salesTypeOptions,
                statusOptions,
                woStatusOptions,
                formData,
                saveFormData,

                resetFormData,
                refFormObserver,
                getValidationState,
                resetForm,
                dateFormat,
                formatDates,
                getWoDeliveryFormateDate,
                getWoFormateDate,
                getWoSoFormateDate,
                getWoStartFormateDate,
                getWoPoFormateDate,
                makeFilteredOptions,
                onSelectedMake,
                onMakeInputChange
            }
        }
    }
</script>

<style lang="scss">
    @import '~@core/scss/vue/libs/vue-select.scss';
</style>
<style lang="scss">
    @import '~@core/scss/vue/libs/vue-autosuggest.scss';
</style>
