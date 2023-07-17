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
                                <h5>Indent Details</h5>
                                <hr>
                            </b-col>
                            <b-col md="5">
                                <validation-provider
                                    #default="validationContext"
                                    name="Item Code"
                                    rules=""
                                >
                                    <b-form-group
                                        :state="getValidationState(validationContext)"
                                    >
                                        <label for="itemCode"> Item Code <span
                                            class="text-danger erp_required_star">*</span></label>

                                        <v-select
                                            v-model="mrpData.itemId"
                                            placeholder="Select itemCode"
                                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                            :options="itemCodeOption"
                                            :reduce="val => val.value"
                                            :clearable="false"
                                            input-id="itemCode"
                                            disabled
                                        />
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
                                            v-model="mrpData.itemDescription"
                                            id="itemDescription"
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
                                        v-model="mrpData.itemMake"
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
                                        v-model="mrpData.addDescription"
                                        id="addDescription"
                                    />
                                </b-form-group>
                                <b-form-group
                                    label="Detail Description"
                                    label-for="detailDescription"
                                >
                                    <b-form-textarea
                                        v-model="mrpData.detailDescription"
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
                                                v-model="mrpData.drawingNumber"
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
                                                v-model="mrpData.rev"
                                                type="number"
                                            />
                                        </b-form-group>
                                    </b-col>
                                </b-row>
                                <validation-provider
                                    #default="validationContext"
                                    name="Planning Type"
                                    rules=""
                                >
                                    <b-form-group
                                        :state="getValidationState(validationContext)"
                                    >
                                        <label for="planning Type"> Planning Type <span
                                            class="text-danger erp_required_star">*</span></label>

                                        <v-select
                                            v-model="mrpData.planningType"
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
                                        v-model="mrpData.store"
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
                                    v-model="mrpData.mrpConversion"
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
                                            rules=""
                                        >
                                            <b-form-group
                                                :state="getValidationState(validationContext)"
                                            >
                                                <label for="deliveryDate"> Delivery Date <span
                                                    class="text-danger erp_required_star">*</span></label>

                                                <b-input-group>
                                                    <cleave
                                                        id="deliveryDate"
                                                        v-model="mrpData.deliveryDate"
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
                                                            @input="getPurchaseItemFormateDate($event)"
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
                                                    v-model="mrpData.indentDate"
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
                                                v-model="mrpData.indentNo"
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
                                                v-model="mrpData.reqQtyUm"
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
                                                v-model="mrpData.reqQtyUp"
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
                                                v-model="mrpData.leadTime"
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
                                            rules=""
                                        >
                                            <b-form-group
                                                :state="getValidationState(validationContext)"
                                            >
                                                <label for="uom"> UOM <span
                                                    class="text-danger erp_required_star">*</span></label>

                                                <v-select
                                                    v-model="mrpData.uom"
                                                    placeholder="Select uom"
                                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                                    :options="uomOption"
                                                    :reduce="val => val.value"
                                                    :clearable="false"
                                                    input-id="uom"
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
                                                v-model="mrpData.up"
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
                                                v-model="mrpData.cFactor"
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
                                                v-model="mrpData.conveQty"
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
                                                v-model="mrpData.minOrderQty"
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
                                                v-model="mrpData.maxOrderQty"
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
                                                v-model="mrpData.size"
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
                                                v-model="mrpData.qtyNos"
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
                                                v-model="mrpData.soId"
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
                                                v-model="mrpData.woId"
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
                                        v-model="mrpData.forecastNo"
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
                                            v-model="mrpData.remark"
                                            id="remark"
                                            rows="3"
                                            :state="getValidationState(validationContext)"
                                        />
                                    </b-form-group>
                                </validation-provider>
                            </b-col>

                            <b-col md="2">
                                <b-form-group
                                    label="Current Stock"
                                    label-for="currentStock"
                                >
                                        <b-form-input
                                            id="currentStock"
                                            v-model="mrpData.currentStock"
                                        />
                                </b-form-group>
                            </b-col>
                            <b-col md="2">
                                <b-form-group
                                    label="Pending Indent"
                                    label-for="pendingIndent"
                                >
                                        <b-form-input
                                            id="pendingIndent"
                                            v-model="mrpData.pendingIndent"
                                        />
                                </b-form-group>
                            </b-col>
                            <b-col md="2">
                                <b-form-group
                                    label="Pending PO"
                                    label-for="pendingPurchaseOrder"
                                >
                                        <b-form-input
                                            id="pendingPurchaseOrder"
                                            v-model="mrpData.pendingPurchaseOrder"
                                        />
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group
                                    label="Pending For Inspection"
                                    label-for="pendingForInspection"
                                >
                                        <b-form-input
                                            id="pendingForInspection"
                                            v-model="mrpData.pendingForInspection"
                                        />
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group
                                    label="Req Qty(Against W.O.)"
                                    label-for="reqQtyAgainstWo"
                                >
                                        <b-form-input
                                            id="reqQtyAgainstWo"
                                            v-model="mrpData.reqQtyAgainstWo"
                                        />
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
                            </b-col>
                        </b-row>
                    </b-form>
                </validation-observer>
            </b-card-code>
        </b-overlay>
        <b-overlay
            :show="showOverlayLoading"
            rounded="sm"
        >
            <b-card-code>
                <b-tabs pills>
                    <b-tab active>
                        <template #title>
                            <feather-icon
                                icon="LogInIcon"
                                size="16"
                                class="mr-0 mr-sm-50"
                            />
                            <span class="d-none d-sm-inline">Login Details</span>
                        </template>
                        <hr>
                        <login-tab-details
                            :loginData="mrpData.loginDetails"
                        />
                    </b-tab>
                </b-tabs>
            </b-card-code>
        </b-overlay>
    </div>
</template>
<script>
    import BCardCode from "../../../@core/components/b-card-code/BCardCode";
    import Ripple from 'vue-ripple-directive'
    import {ref, onUnmounted} from '@vue/composition-api'
    import VSelect from 'vue-select'
    import axios from '@axios'
    import {forMatIndianDate, getTcTodayDate} from "../../../@core/utils/utils";
    import {ValidationProvider, ValidationObserver} from 'vee-validate'
    import formValidation from '@core/comp-functions/forms/form-validation'
    import {required} from '@validations'
    import router from '@/router'
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
        BTabs,
        BTab,
        BOverlay,
        BInputGroup,
        BInputGroupAppend,
        BInputGroupPrepend,
        BFormCheckbox
    } from 'bootstrap-vue'
    import {getUserData} from "../../../auth/utils";
    import moment from 'moment'
    import mrpStoreModule from "../mrpStoreModule";
    import store from '@/store'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import {useToast} from 'vue-toastification/composition'
    import loginTabDetails from "./tabs/loginTabDetails"
    import Swal from "sweetalert2";

    export default {
        components: {
            loginTabDetails,
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
            BTabs,
            BTab,
            BOverlay,
            Cleave,
            BInputGroup,
            BInputGroupAppend,
            BInputGroupPrepend,
            BFormCheckbox
        },
        directives: {
            Ripple,
        },
        setup() {
            const ITEMADDON_APP_STORE_MODULE_NAME = 'mrp-store-module'
            if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, mrpStoreModule)
            onUnmounted(() => {
                if (store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.unregisterModule(ITEMADDON_APP_STORE_MODULE_NAME)
            })

            const toast = useToast()

            const showOverlayLoading = ref(false)

            const itemCodeOption = ref([])
            axios.get('/api/new/get-Work-Order-item-options').then(res => {
                itemCodeOption.value = res.data.data
            })
            const dateFormat = ref({
                date: true,
                delimiter: '/',
                datePattern: ['d', 'm', 'Y'],
            })

            const formatDates = ref({
                deliveryDate: null,
                indentDate: null,
            })

            const getPurchaseItemFormateDate = (date) => {
                mrpData.value.deliveryDate = forMatIndianDate(date)
            }
            const getPurchaseIndentFormateDate = (date) => {
                mrpData.value.indentDate = forMatIndianDate(date)
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
            axios.get('/api/get-store-master-options').then(res => {
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
                id:null,
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
                reqQtyUm: null,
                reqQtyUp: null,
                conveQty: null,
                size: null,
                qtyNos: null,
                planningType: null,
                itemMake: null,
                store: null,
                leadTime: null,
                deliveryDate: forMatIndianDate(getTcTodayDate()),
                indentDate: forMatIndianDate(getTcTodayDate()),
                indentNo: null,
                minOrderQty: null,
                maxOrderQty: null,
                soId: null,
                woId: null,
                forecastNo: null,
                remark: null,
                currentStock:null,
                pendingIndent:null,
                pendingPurchaseOrder:null,
                pendingForInspection:null,
                reqQtyAgainstWo:null,
                mrpConversion: null,
                loginDetails: {
                    createdBy: CurrentUserData.value.first_name + ' ' + CurrentUserData.value.last_name,
                    dateTime: moment(new Date()).format('DD/MM/YYYY HH:mm'),
                    lastModifiedBy: null,
                    modifiedDateTime: null,
                    approvedBy: null,
                    approveDate: null,
                    stage: 1,
                },
                indentCreatedFrom: 'purchaseItems',
                indentCreatedMenuId: 1,
            }

            const mrpData = ref(JSON.parse(JSON.stringify(blankFormData)))

            const resetFormData = () => {
                mrpData.value = JSON.parse(JSON.stringify(blankFormData))
            }
            const calculateAmount = () => {
                if (mrpData.value.mrpConversion === true) {
                    mrpData.value.reqQtyUp = mrpData.value.reqQtyUm * mrpData.value.conveQty * mrpData.value.cFactor
                }
            }

            axios.get(`/api/mrp/wo-purchase-items/${router.currentRoute.params.id}`).then(res => {
                mrpData.value = res.data.data
                mrpData.value.id = res.data.data._id
                delete res.data.data._id
                showOverlayLoading.value = false
            })

            const saveFormData = async () => {
                mrpData.value.loginDetails.lastModifiedBy = CurrentUserData.value.first_name + ' ' + CurrentUserData.value.last_name
                mrpData.value.loginDetails.modifiedDateTime = moment(new Date()).format('DD/MM/YYYY HH:mm')
                if (mrpData.value.loginDetails.stage === 2) {
                  await Swal.fire({
                        icon: 'warning',
                        title: 'Warning',
                        text: 'This Item is Already Approved, Please Redo to Edit',
                    })
                } else {
                    await store.dispatch('mrp-store-module/updateWoPurchaseItem', mrpData.value).then(res => {
                        if (res.status === 200) {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'WO Purchase Item Updated',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: `You have successfully Updated WO Purchase Item.`,
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
            }

            const {refFormObserver, getValidationState, resetForm} = formValidation(resetFormData)

            return {
                showOverlayLoading,
                mrpData,
                itemCodeOption,
                uomOption,
                UPOption,
                planningOption,
                itemOption,
                storeOption,
                soNoOption,
                woNoOption,
                saveFormData,
                required,
                refFormObserver,
                getValidationState,
                resetForm,
                dateFormat,
                formatDates,
                getPurchaseIndentFormateDate,
                getPurchaseItemFormateDate,
                calculateAmount
            }
        }
    }
</script>
