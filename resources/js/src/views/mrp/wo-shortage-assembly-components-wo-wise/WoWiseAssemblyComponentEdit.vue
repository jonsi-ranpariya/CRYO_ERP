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
                            <b-col md="6">
                                <validation-provider
                                    #default="{ errors }"
                                    name="Item Code"
                                    rules="required"
                                >
                                    <b-form-group
                                        label="Item Code"
                                        label-for="itemCode"
                                        :state="errors.length > 0 ? false:null"
                                    >
                                        <v-select
                                            v-model="mrpData.itemCode"
                                            placeholder="Select itemCode"
                                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                            :options="itemCodeOption"
                                            :reduce="val => val.value"
                                            :clearable="false"
                                            input-id="itemCode"
                                            @input="getItemDetails($event)"
                                            :state="errors.length > 0 ? false:null"
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
                                    >
                                        <b-form-input
                                            v-model="mrpData.itemDescription"
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
                                    label="Add Description"
                                    label-for="addDescription"
                                >
                                    <b-form-input
                                        v-model="mrpData.addDescription"
                                        id="addDescription"
                                        readonly
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
                                        readonly
                                    />
                                </b-form-group>
                                <b-form-group
                                    label="Drawing Number"
                                    label-for="drawingNumber"
                                >
                                    <b-form-input
                                        id="drawingNumber"
                                        v-model="mrpData.drawingNumber"
                                        type="number"
                                        readonly
                                    />
                                </b-form-group>
                                <b-form-group
                                    label="Rev"
                                    label-for="rev"
                                >
                                    <b-form-input
                                        id="rev"
                                        v-model="mrpData.rev"
                                        type="number"
                                        readonly
                                    />
                                </b-form-group>
                                <b-row>
                                    <b-col md="6">
                                        <b-form-group
                                            label="UOM"
                                            label-for="uom"
                                        >
                                            <v-select
                                                v-model="mrpData.uom"
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
                                                readonly
                                            />
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="6">
                                        <b-form-group
                                            label="Req. Qty UM"
                                            label-for="reqQtyUm"
                                        >
                                            <b-form-input
                                                v-model="mrpData.reqQtyUm"
                                                id="reqQtyUm"
                                            />
                                        </b-form-group>
                                    </b-col>
                                </b-row>
                                <b-row>
                                    <b-col md="6">
                                        <b-form-group
                                            label="Req. Qty UP"
                                            label-for="reqQtyUp"
                                        >
                                            <b-form-input
                                                v-model="mrpData.reqQtyUp"
                                                id="reqQtyUp"
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
                                                readonly
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
                                <b-form-group
                                    label="Planning Type"
                                    label-for="planningType"
                                >
                                    <v-select
                                        v-model="mrpData.planningType"
                                        placeholder="Select Planning Type"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="planningOption"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        input-id="planningType"
                                    />
                                </b-form-group>
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
                                        multiple
                                        taggable
                                        push-tags
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
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
                                <b-form-group
                                    label="Lead Time"
                                    label-for="leadTime"
                                >
                                    <b-form-input
                                        v-model="mrpData.leadTime"
                                        id="leadTime"
                                        type="number"
                                        readonly
                                    />
                                </b-form-group>
                                <b-form-group
                                    label="Delivery Date"
                                    label-for="deliveryDate"
                                >
                                    <b-input-group>
                                        <b-input-group-prepend>
                                            <b-form-datepicker
                                                v-model="formatDates.deliveryDate"
                                                button-only
                                                @input="getWoDeliveryFormateDate($event)"
                                                show-decade-nav
                                                size="sm"
                                                nav-button-variant="primary"
                                            />
                                        </b-input-group-prepend>
                                        <cleave
                                            id="deliveryDate"
                                            v-model="mrpData.deliveryDate"
                                            class="form-control"
                                            :raw="false"
                                            :options="dateFormat"
                                            placeholder="DD/MM/YYYY"
                                            show-decade-nav
                                        />
                                    </b-input-group>
                                </b-form-group>
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
                                            v-model="mrpData.indentDate"
                                            class="form-control"
                                            :raw="false"
                                            :options="dateFormat"
                                            placeholder="DD/MM/YYYY"
                                            show-decade-nav
                                            disabled
                                        />
                                    </b-input-group>
                                </b-form-group>
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
                                <b-form-group
                                    label="Min Order Qty"
                                    label-for="minOrderQty"
                                >
                                    <b-form-input
                                        v-model="mrpData.minOrderQty"
                                        id="minOrderQty"
                                    />
                                </b-form-group>
                                <b-form-group
                                    label="Max Order Qty"
                                    label-for="maxOrderQty"
                                >
                                    <b-form-input
                                        v-model="mrpData.maxOrderQty"
                                        id="maxOrderQty"
                                    />
                                </b-form-group>
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
                                <b-form-group
                                    label="Forecast No."
                                    label-for="forecastNo"
                                >
                                    <v-select
                                        v-model="mrpData.forecastNo"
                                        placeholder="Select forecastNo"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="forecastNoOption"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        input-id="forecastNo"
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
        BInputGroupPrepend
    } from 'bootstrap-vue'
    import {getUserData} from "../../../auth/utils";
    import moment from 'moment'
    import mrpStoreModule from "../mrpStoreModule";
    import store from '@/store'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import {useToast} from 'vue-toastification/composition'
    import loginTabDetails from "./tabs/loginTabDetails"

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
            BInputGroupPrepend
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
                mrpData.value.deliveryDate = forMatIndianDate(date)
            }
            const getWoIndentFormateDate = (date) => {
                mrpData.value.indentDate = forMatIndianDate(date)
            }

            const getItemDetails = async (id) => {
                await axios.get(`/api/item-master/${id}`).then(res => {
                    mrpData.value.itemId = res.data.data._id
                    mrpData.value.itemDescription = res.data.data.itemDescription
                    mrpData.value.addDescription = res.data.data?.itemDetails?.description ?? null
                    mrpData.value.detailDescription = res.data.data?.itemDetails?.detailDescription ?? null
                    mrpData.value.drawingNumber = res.data.data?.itemDetails?.drawingNumber ?? null
                    mrpData.value.rev = res.data.data?.itemDetails?.revision ?? null
                    mrpData.value.uom = res.data.data.uom
                    mrpData.value.cFactor = res.data.data.cFactor
                    mrpData.value.conveQty = res.data.data.convQty
                    mrpData.value.planningType = res.data.data.planning
                    mrpData.value.itemMake = res.data.data.make
                    mrpData.value.leadTime = res.data.data?.purchaseData?.leadTime ?? null
                    mrpData.value.minOrderQty = res.data.data?.purchaseData?.minimumOrderQuantity ?? null
                    mrpData.value.maxOrderQty = res.data.data?.purchaseData?.maximumOrderQuantity ?? null
                    mrpData.value.remark = res.data.data?.itemDetails?.remarkNote ?? null
                })
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
                woId: null,
                forecastNo: null,
                remark: null,
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

            const saveFormData = async () => {
                mrpData.value.loginDetails.lastModifiedBy = CurrentUserData.value.first_name + ' ' + CurrentUserData.value.last_name
                mrpData.value.loginDetails.modifiedDateTime = moment(new Date()).format('DD/MM/YYYY HH:mm')
                await store.dispatch('mrp-store-module/updateWoWiseAssemblyComponent', mrpData.value).then(res => {
                    if (res.status === 200) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'WO Shortage Assembly Component (Wo Wise) Updated',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: `You have successfully Updated WO Shortage Assembly Component (Wo Wise).`,
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
                    router.push({name: 'wo-shortage-assembly-component-wo-wise'})
                })
            }

            const refetchData = async (id) => {
                showOverlayLoading.value = true
                await axios.get(`/api/mrp/wo-purchase-items/${id}`).then(res => {
                    mrpData.value = res.data.data
                })
                showOverlayLoading.value = false
            }
            refetchData(router.currentRoute.params.id)

            const {refFormObserver, getValidationState, resetForm} = formValidation(resetFormData)

            return {
                showOverlayLoading,
                mrpData,
                itemCodeOption,
                getItemDetails,
                uomOption,
                UPOption,
                planningOption,
                forecastNoOption,
                itemOption,
                storeOption,
                soNoOption,
                woNoOption,
                saveFormData,
                refetchData,
                required,
                refFormObserver,
                getValidationState,
                resetForm,
                formatDates,
                dateFormat,
                getWoDeliveryFormateDate,
                getWoIndentFormateDate
            }
        }
    }
</script>
