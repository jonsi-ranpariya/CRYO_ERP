<template>
    <div>
        <b-card-code>
            <b-row>
                <b-col md="12">
                    <b-button
                        variant="primary"
                        type="button"
                        class="float-right"
                        @click="approveIndent"
                    >
                        Approve Indent
                    </b-button>
                </b-col>
                <b-col md="12">
                    <hr>
                </b-col>
                <b-col md="5">
                    <b-form-group
                        label="Item Code"
                        label-for="itemCode"
                    >
                        <v-select
                            v-model="formData.itemCode"
                            placeholder="Select itemCode"
                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                            :options="itemCodeOption"
                            :reduce="val => val.value"
                            :clearable="false"
                            input-id="itemCode"
                            disabled
                        />
                    </b-form-group>
                    <b-form-group
                        label="Item Description"
                        label-for="itemDescription"
                    >
                        <b-form-input
                            v-model="formData.itemDescription"
                            id="itemDescription"
                            disabled
                        />
                    </b-form-group>
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
                            disabled
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
                            disabled
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
                                    type="number"
                                    disabled
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
                                    disabled
                                />
                            </b-form-group>
                        </b-col>
                    </b-row>
                    <b-form-group
                        label="Planning Type"
                        label-for="planningType"
                    >
                        <v-select
                            v-model="formData.planningType"
                            placeholder="Select Planning Type"
                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                            :options="planningOption"
                            :reduce="val => val.value"
                            :clearable="false"
                            input-id="planningType"
                            disabled
                        />
                    </b-form-group>
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
                            <b-form-group
                                label="Delivery Date"
                                label-for="deliveryDate"
                            >
                                <b-input-group>
                                    <cleave
                                        id="deliveryDate"
                                        v-model="formData.deliveryDate"
                                        class="form-control"
                                        :raw="false"
                                        :options="dateFormat"
                                        placeholder="DD/MM/YYYY"
                                        show-decade-nav
                                        disabled
                                    />
                                    <b-input-group-append>
                                        <b-form-datepicker
                                            v-model="formatDates.deliveryDate"
                                            button-only
                                            @input="getWoDeliveryFormateDate($event)"
                                            show-decade-nav
                                            size="sm"
                                            nav-button-variant="primary"
                                            disabled
                                        />
                                    </b-input-group-append>
                                </b-input-group>
                            </b-form-group>
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
                                            @input="getWoIndentFormateDate($event)"
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
                                    disabled
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
                                    disabled
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
                                    disabled
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
                                    disabled
                                />
                            </b-form-group>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col md="6">
                            <b-form-group
                                label="UOM"
                                label-for="uom"
                            >
                                <v-select
                                    v-model="formData.uom"
                                    placeholder="Select uom"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="uomOption"
                                    :reduce="val => val.value"
                                    :clearable="false"
                                    input-id="uom"
                                    disabled
                                />
                            </b-form-group>
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
                                    disabled
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
                                    disabled
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
                                    disabled
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
                                    disabled
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
                                    disabled
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
                                    disabled
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
                                    disabled
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
                                    disabled
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
                                    disabled
                                />
                            </b-form-group>
                        </b-col>
                    </b-row>
                    <b-form-group
                        label="Forecast No."
                        label-for="forecastNo"
                    >
                        <v-select
                            v-model="formData.forecastNo"
                            placeholder="Select forecastNo"
                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                            :options="forecastNoOption"
                            :reduce="val => val.value"
                            :clearable="false"
                            input-id="forecastNo"
                            disabled
                        />
                    </b-form-group>
                    <b-form-group
                        label="Remark"
                        label-for="remark"
                    >
                        <b-form-textarea
                            v-model="formData.remark"
                            id="remark"
                            rows="3"
                            disabled
                        />
                    </b-form-group>
                </b-col>
                <b-col md="2">
                    <b-form-group
                        label="Current Stock"
                        label-for="currentStock"
                    >
                        <b-form-input
                            id="currentStock"
                            v-model="formData.currentStock"
                            readonly
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
                            v-model="formData.pendingIndent"
                            readonly
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
                            v-model="formData.pendingPurchaseOrder"
                            readonly
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
                            v-model="formData.pendingForInspection"
                            readonly
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
                            v-model="formData.reqQtyAgainstWo"
                            readonly
                        />
                    </b-form-group>
                </b-col>
            </b-row>
        </b-card-code>
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
                        :loginData="formData.loginDetails"
                    />
                </b-tab>
            </b-tabs>
        </b-card-code>
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
    BTabs,
    BTab,
    BInputGroupAppend,
    BInputGroup,
    BInputGroupPrepend,
    BFormCheckbox
} from 'bootstrap-vue'
import BCardCode from "../../../@core/components/b-card-code/BCardCode";
import Ripple from 'vue-ripple-directive'
import {onUnmounted, ref} from '@vue/composition-api'
import VSelect from 'vue-select'
import axios from '@axios'
import {forMatIndianDate, getTcTodayDate} from "../../../@core/utils/utils";
import {ValidationProvider, ValidationObserver} from 'vee-validate'
import formValidation from '@core/comp-functions/forms/form-validation'
import {required} from '@validations'
import {getUserData} from "../../../auth/utils";
import loginTabDetails from "./tabs/loginTabDetails"
import {useToast} from "vue-toastification/composition";
import mrpStoreModule from "../mrpStoreModule";
import moment from "moment";
import store from '@/store'
import Toastification from '@core/components/toastification/ToastificationContent.vue'
import router from '@/router'
import Swal from 'sweetalert2'
import Cleave from 'vue-cleave-component'

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
        loginTabDetails,
        BTabs,
        BTab,
        Cleave,
        BInputGroupAppend,
        BInputGroup,
        BInputGroupPrepend,
        BFormCheckbox
    },
    directives: {
        Ripple,
    },
    setup() {
        //toast alert
        const toast = useToast()

        //store module
        const ITEMADDON_APP_STORE_MODULE_NAME = 'mrp-store-module'
        if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, mrpStoreModule)
        onUnmounted(() => {
            if (store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.unregisterModule(ITEMADDON_APP_STORE_MODULE_NAME)
        })
        const showOverlayLoading = ref(false)
        //new/get-work-order-item-option
        const itemCodeOption = ref([])
        axios.get('/api/get-item-master-options').then(res => {
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

        const getWoDeliveryFormateDate = (date) => {
            formData.value.deliveryDate = forMatIndianDate(date)
        }
        const getWoIndentFormateDate = (date) => {
            formData.value.indentDate = forMatIndianDate(date)
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

        const forecastNoOption = ref([])

        const CurrentUserData = ref(getUserData())

        const blankFormData = {
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
            soNumber:null,
            woId: null,
            woNumber:null,
            forecastNo: null,
            remark: null,
            currentStock: null,
            pendingIndent: null,
            pendingPurchaseOrder: null,
            pendingForInspection: null,
            reqQtyAgainstWo: null,
            mrpConversion:null,
            loginDetails: {
                createdBy: CurrentUserData.value.first_name + ' ' + CurrentUserData.value.last_name,
                dateTime: moment(new Date()).format('DD/MM/YYYY HH:mm'),
                lastModifiedBy: null,
                modifiedDateTime: null,
                approvedBy: null,
                approveDate: null,
                stage: 1,
            }
        }


        const formData = ref(JSON.parse(JSON.stringify(blankFormData)))

        const resetFormData = () => {
            formData.value = JSON.parse(JSON.stringify(blankFormData))
        }

        const refetchData = async (id) => {
            showOverlayLoading.value = true
            await axios.get(`/api/mrp/pending-indent/${id}`).then(res => {
                formData.value = res.data.data
            })
            showOverlayLoading.value = false
        }
        refetchData(router.currentRoute.params.id)

        const approveIndent = async () => {
            await Swal.fire({
                title: 'Are you sure?',
                text: "Name is already exist",
                icon: 'warning',
                showCancelButton: true,
                showDenyButton: true,
                confirmButtonText: 'Yes, Approve!',
                denyButtonText: 'No, Decline!',
                cancelButtonText: 'Cancel',
                customClass: {
                    confirmButton: 'btn btn-outline-success',
                    cancelButton: 'btn btn-outline-danger ml-1',
                    denyButton: 'btn btn-outline-warning ml-1',
                },
                buttonsStyling: false,
            }).then(result => {
                if (result.isConfirmed) {
                    acceptDeclineEvent(2)
                }
                if (result.isDenied) {
                    acceptDeclineEvent(3)
                }
                if (result.isDismissed) {
                    toast({
                        component: Toastification,
                        position: 'top-right',
                        props: {
                            title: 'Cancel',
                            icon: 'AlertCircleIcon',
                            variant: 'danger',
                            text: 'You have abort the task!',
                        },
                    })
                }
            })
        }

        const acceptDeclineEvent = async (status) => {
            /* status: 1 = Prepared, status: 2 = Approved, status: 3 = Regret */
            if (status === 3) {
                formData.value.loginDetails.approveDate = null
                formData.value.loginDetails.approvedBy = null
                formData.value.loginDetails.stage = status
            } else {
                formData.value.loginDetails.approveDate = moment(new Date()).format('DD/MM/YYYY HH:mm')
                formData.value.loginDetails.approvedBy = getUserData().first_name + ' ' + getUserData().last_name
                formData.value.loginDetails.stage = status
            }

            await axios.put(`/api/mrp/pending-indent/${router.currentRoute.params.id}`, formData.value).then(res => {
                if (res.status === 200) {
                    toast({
                        component: Toastification,
                        position: 'top-right',
                        props: {
                            title: 'Status Changed',
                            icon: 'ThumbsUpIcon',
                            variant: 'success',
                            text: 'Indent Status Change Successfully!',
                        },
                    })
                } else {
                    toast({
                        component: Toastification,
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

        const {refFormObserver, getValidationState, resetForm} = formValidation(resetFormData)

        return {
            formData,
            itemCodeOption,
            uomOption,
            UPOption,
            planningOption,
            forecastNoOption,
            itemOption,
            storeOption,
            soNoOption,
            woNoOption,
            refFormObserver,
            getValidationState,
            resetForm,
            refetchData,
            approveIndent,
            acceptDeclineEvent,
            required,
            dateFormat,
            formatDates,
            getWoDeliveryFormateDate,
            getWoIndentFormateDate
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
