<template>
    <div>
        <b-overlay
            :show="showOverlayLoading"
            rounded="sm"
        >
            <b-card-code>
                <validation-observer #default="{handleSubmit}">
                    <b-form @submit.prevent="handleSubmit(saveFormData)">
                        <b-row>
                            <b-col md="6">
                                <b-row>
                                    <b-col md="6">
                                        <validation-provider
                                            #default="validationContext"
                                            name="Work Order No"
                                            rules="required"
                                        >
                                            <b-form-group
                                                label="Work Order No."
                                                label-for="workOrderNo"
                                            >
                                                <b-form-input
                                                    v-model="formData.workOrderNo"
                                                    :state="getValidationState(validationContext)"
                                                    id="poNo"
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
                                            name="Work Order Date"
                                            rules="required"
                                        >
                                            <b-form-group
                                                label="Work Order Date"
                                                label-for="woDate"
                                                :state="getValidationState(validationContext)"
                                            >
                                                <b-input-group>
                                                    <cleave
                                                        id="poDate"
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
                                                            @input="getWoFormatDate($event)"
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
                                </b-row>
                                <b-row>
                                    <b-col md="7">
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
                                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                                    {{ validationContext.errors[0] }}
                                                </b-form-invalid-feedback>
                                            </b-form-group>
                                        </validation-provider>
                                    </b-col>
                                    <b-col md="5">
                                        <validation-provider
                                            #default="validationContext"
                                            name="Party Code"
                                            rules=""
                                        >
                                            <b-form-group
                                                label="Party Code"
                                                label-for="partyCode"
                                            >
                                                <b-form-input
                                                    id="partyCode"
                                                    v-model="formData.partyCode"
                                                    :state="getValidationState(validationContext)"
                                                />
                                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                                    {{ validationContext.errors[0] }}
                                                </b-form-invalid-feedback>

                                            </b-form-group>
                                        </validation-provider>
                                    </b-col>
                                </b-row>
                                <hr>
                                <validation-provider
                                    #default="validationContext"
                                    name="Item Code"
                                    rules="required"
                                >
                                    <b-form-group
                                        label="Item Code"
                                        label-for="itemCode"
                                    >
                                        <b-form-input
                                            v-model="formData.itemCode"
                                            :state="getValidationState(validationContext)"
                                            id="itemCode"
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
                                            id="itemDescription"
                                            v-model="formData.itemDescription"
                                            :state="getValidationState(validationContext)"
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
                                            name="Add Description"
                                            rules=""
                                        >
                                            <b-form-group
                                                label="Add Description"
                                                label-for="addDescription"
                                            >
                                                <b-form-input
                                                    id="addDescription"
                                                    v-model="formData.itemAddDescription"
                                                    :state="getValidationState(validationContext)"
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
                                            name="Item Make"
                                            rules=""
                                        >
                                            <b-form-group
                                                label="Item Make"
                                                label-for="itemMake"
                                                :state="getValidationState(validationContext)"
                                            >
                                                <v-select
                                                    :clearable="false"
                                                    :dir=" $store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                                    :options="makeOption"
                                                    :reduce="(val) => val.value"
                                                    input-id="itemMake"
                                                    placeholder="Select Make"
                                                    push-tags
                                                    taggable
                                                    v-model="formData.itemMake"
                                                    :state="getValidationState(validationContext)"
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
                                        label-for="detailDescription"
                                    >
                                        <b-form-textarea
                                            id="detailDescription"
                                            rows="2"
                                            v-model="formData.itemDetailDescription"
                                            :state="getValidationState(validationContext)"
                                        />
                                        <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                            {{ validationContext.errors[0] }}
                                        </b-form-invalid-feedback>
                                    </b-form-group>
                                </validation-provider>
                            </b-col>
                            <b-col md="6">
                                <b-row>
                                    <b-col md="6">
                                        <validation-provider
                                            #default="validationContext"
                                            name="Drawing No"
                                            rules=""
                                        >
                                            <b-form-group
                                                label="Drawing No."
                                                label-for="itemDrawingNo"
                                            >
                                                <b-form-input
                                                    id="itemDrawingNo"
                                                    v-model="formData.itemDrawingNo"
                                                    :state="getValidationState(validationContext)"
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
                                            name="Revision"
                                            rules=""
                                        >
                                            <b-form-group
                                                label="Rev"
                                                label-for="itemRev"
                                            >
                                                <b-form-input
                                                    id="itemRev"
                                                    v-model="formData.itemRev"
                                                    :state="getValidationState(validationContext)"
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
                                    name="UOM"
                                    rules=""
                                >
                                    <b-form-group
                                        label="UOM"
                                        label-for="itemUom"
                                    >
                                        <v-select
                                            :clearable="false"
                                            :dir="$store.state.appConfig.isRTL? 'rtl': 'ltr'"
                                            :options="uomOption"
                                            :reduce="(val) => val.value"
                                            input-id="itemUom"
                                            placeholder="Select uom"
                                            v-model="formData.itemUom"
                                            :state="getValidationState(validationContext)"
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
                                            name="Required Qty"
                                            rules=""
                                        >
                                            <b-form-group
                                                label="Required Qty"
                                                label-for="requiredQty"
                                            >
                                                <b-form-input
                                                    id="requiredQty"
                                                    v-model="formData.requiredQty"
                                                    :state="getValidationState(validationContext)"
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
                                            name="Rate"
                                            rules=""
                                        >
                                            <b-form-group
                                                label="Rate"
                                                label-for="rate"
                                            >
                                                <b-form-input
                                                    id="rate"
                                                    v-model="formData.rate"
                                                    :state="getValidationState(validationContext)"
                                                />
                                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                                    {{ validationContext.errors[0] }}
                                                </b-form-invalid-feedback>
                                            </b-form-group>
                                        </validation-provider>
                                    </b-col>
                                </b-row>
                                <b-row>
                                    <b-col md="6">
                                        <validation-provider
                                            #default="validationContext"
                                            name="Pending Qty"
                                            rules=""
                                        >
                                            <b-form-group
                                                label="Pending Qty"
                                                label-for="pendingQty"
                                            >
                                                <b-form-input
                                                    id="pendingQty"
                                                    v-model="formData.pendingQty"
                                                    :state="getValidationState(validationContext)"
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
                                            name="Completed Qty"
                                            rules=""
                                        >
                                            <b-form-group
                                                label="Completed Qty"
                                                label-for="completedQty"
                                            >
                                                <b-form-input
                                                    id="completedQty"
                                                    v-model="formData.completedQty"
                                                    :state="getValidationState(validationContext)"
                                                />
                                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                                    {{ validationContext.errors[0] }}
                                                </b-form-invalid-feedback>
                                            </b-form-group>
                                        </validation-provider>
                                    </b-col>
                                </b-row>
                                <hr>
                                <b-row>
                                    <b-col md="6">
                                        <validation-provider
                                            #default="validationContext"
                                            name="Inspection Date"
                                            rules=""
                                        >
                                            <b-form-group
                                                label="Inspection Date"
                                                label-for="inspectionDate"
                                                :state="getValidationState(validationContext)"
                                            >
                                                <b-input-group>
                                                    <b-input-group-prepend>
                                                        <b-form-datepicker
                                                            v-model="formatDates.inspectionDate"
                                                            button-only
                                                            @input="getInspectionFormatDate($event)"
                                                            show-decade-nav
                                                            size="sm"
                                                            nav-button-variant="primary"
                                                        />
                                                    </b-input-group-prepend>
                                                    <cleave
                                                        id="inspectionDate"
                                                        v-model="formData.inspectionDate"
                                                        class="form-control"
                                                        :raw="false"
                                                        :options="dateFormat"
                                                        placeholder="DD/MM/YYYY"
                                                        show-decade-nav
                                                    />
                                                </b-input-group>
                                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                                    {{ validationContext.errors[0] }}
                                                </b-form-invalid-feedback>
                                            </b-form-group>
                                        </validation-provider>
                                    </b-col>
                                    <b-col md="6">
                                        <validation-provider
                                            #default="validationContext"
                                            name="Job Card No"
                                            rules=""
                                        >
                                            <b-form-group
                                                label="Job Card No."
                                                label-for="jobCardNo"
                                            >
                                                <b-form-input
                                                    v-model="formData.jobCardNo"
                                                    :state="getValidationState(validationContext)"
                                                    id="jobCardNo"
                                                />
                                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                                    {{ validationContext.errors[0] }}
                                                </b-form-invalid-feedback>
                                            </b-form-group>
                                        </validation-provider>
                                    </b-col>
                                </b-row>
                                <b-row>
                                    <b-col md="6">
                                        <validation-provider
                                            #default="validationContext"
                                            name="Accepted Qty"
                                            rules=""
                                        >
                                            <b-form-group
                                                label="Accepted Qty"
                                                label-for="acceptedQty"
                                            >
                                                <b-form-input
                                                    id="acceptedQty"
                                                    v-model="formData.acceptedQty"
                                                    :state="getValidationState(validationContext)"
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
                                            name="Rejected Qty"
                                            rules=""
                                        >
                                            <b-form-group
                                                label="Rejected Qty"
                                                label-for="rejectedQty"
                                            >
                                                <b-form-input
                                                    id="rejectedQty"
                                                    v-model="formData.rejectedQty"
                                                    :state="getValidationState(validationContext)"
                                                />
                                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                                    {{ validationContext.errors[0] }}
                                                </b-form-invalid-feedback>
                                            </b-form-group>
                                        </validation-provider>
                                    </b-col>
                                </b-row>
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
                            icon="EditIcon"
                            size="16"
                            class="mr-0 mr-sm-50"
                        />
                        <span class="d-none d-sm-inline">Inspection Remark</span>
                    </template>
                    <hr>
                    <inspection-remark-tab
                        :remarkDetails="formData.remarkDetails"
                    />
                </b-tab>
                <b-tab>
                    <template #title>
                        <feather-icon
                            icon="LogInIcon"
                            size="16"
                            class="mr-0 mr-sm-50"
                        />
                        <span class="d-none d-sm-inline">Login</span>
                    </template>
                    <hr>
                    <login-details-tab
                        :loginData="formData.loginDetails"
                    />
                </b-tab>
            </b-tabs>
        </b-card-code>
        </b-overlay>
    </div>
</template>
<script>
    import BCardCode from "../../../@core/components/b-card-code/BCardCode";
    import {ValidationObserver, ValidationProvider} from 'vee-validate'
    import formValidation from "@core/comp-functions/forms/form-validation";
    import {onUnmounted, ref} from '@vue/composition-api'
    import Cleave from 'vue-cleave-component'
    import vSelect from 'vue-select'
    import axios from '@axios'
    import {required} from '@validations'
    import {forMatIndianDate, getTcTodayDate} from "@core/utils/utils";
    import router from '@/router'
    import inspectionRemarkTab from "./tabs/inspectionRemarkTab";
    import loginDetailsTab from './tabs/loginDetailsTab'
    import store from '@/store'
    import {getTcTodayDateTime} from "@core/utils/utils";

    import {
        BForm,
        BRow,
        BCol,
        BFormGroup,
        BFormInput,
        BInputGroup,
        BInputGroupAppend,
        BFormInvalidFeedback,
        BButton,
        BFormDatepicker,
        BFormTextarea,
        BTabs,
        BTab,
        BOverlay,
        BInputGroupPrepend
    } from 'bootstrap-vue'
    import {getUserData} from "../../../auth/utils";
    import moment from "moment";
    import {useToast} from "vue-toastification/composition";
    import qualityControlStoreModule from "../qualityControlStoreModule";
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'

    export default {
        components: {
            BCardCode,
            ValidationObserver,
            ValidationProvider,
            BForm,
            BRow,
            BCol,
            BFormGroup,
            BFormInput,
            BInputGroup,
            BInputGroupAppend,
            BFormInvalidFeedback,
            BButton,
            BFormDatepicker,
            Cleave,
            vSelect,
            BFormTextarea,
            inspectionRemarkTab,
            loginDetailsTab,
            BTabs,
            BTab,
            BOverlay,
            BInputGroupPrepend
        },
        setup(){
            const toast = useToast()

            const ITEMADDON_APP_STORE_MODULE_NAME = 'quality-control-store-module'
            if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, qualityControlStoreModule)
            onUnmounted(() => {
                if (store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.unregisterModule(ITEMADDON_APP_STORE_MODULE_NAME)
            })

            const showOverlayLoading = ref(false)
            const uomOption = ref([])
            axios.get("/api/get-uom-master-options").then((res) => {
                uomOption.value = res.data.data;
            });

            const workOrderType = ref([
                {label: 'Against Sales Order', value: 1},
                {label: 'Stock Order', value: 2},
                {label: 'Against Work Order', value: 3},
                {label: 'Against Replacement', value: 4},
                {label: 'Against Sample Trial', value: 5},
                {label: 'Against Shop Rejection', value: 6},
            ])
            const makeOption = ref([]);
            axios.get('/api/get-item-make-master-options').then(res => {
                makeOption.value = res.data.data
            });
            const dateFormat = ref({
                date: true,
                delimiter: '/',
                datePattern: ['d', 'm', 'Y'],
            })
            const formatDates = ref({
                woDate: null,
                inspectionDate: null,
            })
            const getWoFormatDate = (date) => {
                formData.value.woDate = forMatIndianDate(date)
            }
            const getInspectionFormatDate = (date) => {
                formData.value.inspectionDate = forMatIndianDate(date)
            }

            const currentUserData = ref(getUserData())

            const blankFormData = {
                workOrderNo: null,
                woDate: forMatIndianDate(getTcTodayDate()),
                woType: null,
                partyCode: null,
                itemCode: null,
                itemDescription: null,
                itemAddDescription: null,
                itemMake:null,
                itemDetailDescription: null,
                itemDrawingNo: null,
                itemRev: null,
                itemUom: null,
                requiredQty: null,
                rate: null,
                pendingQty: null,
                completedQty: null,
                jobCardNo: null,
                inspectionDate: forMatIndianDate(getTcTodayDate()),
                acceptedQty: null,
                rejectedQty: null,
                batchNo: null,
                remarkDetails: {
                    remark: null,
                },
                loginDetails: {
                    createdBy: getUserData().first_name + ' ' + getUserData().last_name,
                    dateTime: moment(new Date()).format('DD/MM/YYYY HH:mm'),
                    lastModifiedBy: null,
                    modifiedDateTime: null,
                }
            }
            const formData = ref(JSON.parse(JSON.stringify(blankFormData)))

            const resetFormData = () => {
                formData.value = JSON.parse(JSON.stringify(blankFormData))
            }
            const refetchData = async () => {
                showOverlayLoading.value = true
                await axios.get(`/api/new/work-order-sub-assembly-qc/${router.currentRoute.params.id}`).then((res) => {
                    formData.value = res.data.data
                })
                showOverlayLoading.value = false
            }
            refetchData()
            const saveFormData = async () => {
                formData.value.loginDetails.lastModifiedBy = currentUserData.value.first_name + ' ' + currentUserData.value.last_name
                formData.value.loginDetails.modifiedDateTime = getTcTodayDateTime()
                await store.dispatch('quality-control-store-module/updateWorkOrderSubAssemblyQc', formData.value).then(res => {
                    if (res.status === 200) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Work Order Sub-Assembly Quality Control Updated',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: 'You have successfully Updated Work Order Sub-Assembly quality Control',
                            },
                        })
                    } else {
                        toast({
                            component: ToastificationContent,
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
            const {refFormObserver, getValidationState, resetForm} = formValidation(resetFormData)
            return {
                formData,
                saveFormData,
                refFormObserver,
                getValidationState,
                resetForm,
                resetFormData,
                getWoFormatDate,
                formatDates,
                dateFormat,
                workOrderType,
                uomOption,
                getInspectionFormatDate,
                required,
                showOverlayLoading,
                refetchData,
                makeOption,
                currentUserData
            }
        }
    }
</script>
