<template>
    <div>
        <b-overlay
            :show="showOverlayLoading"
            rounded="sm"
        >
            <b-card-code>
                <b-form @submit.prevent="saveFormData">
                    <b-row>
                        <b-col md="12">
                            <h5>Job Card Details</h5>
                            <hr>
                        </b-col>
                        <b-col md="6">
                            <b-row>
                                <b-col md="6">
                                    <b-form-group
                                        label="Job Card No."
                                        label-for="jobCardNumber"
                                    >
                                        <b-form-input
                                            v-model="formData.jobCardNumber"
                                            id="jobCardNumber"
                                            readonly
                                        />
                                    </b-form-group>
                                </b-col>
                                <b-col md="6">
                                    <b-form-group
                                        label="Date"
                                        label-for="jobCardDate"
                                    >
                                        <b-input-group>
                                            <cleave
                                                id="jobCardDate"
                                                v-model="formData.jobCardDate"
                                                class="form-control"
                                                :raw="false"
                                                :options="dateFormat"
                                                placeholder="DD/MM/YYYY"
                                                show-decade-nav
                                            />
                                            <b-input-group-append>
                                                <b-form-datepicker
                                                    v-model="formatDates.jobCardDate"
                                                    button-only
                                                    @input="getJobCardFormateDate($event)"
                                                    show-decade-nav
                                                    size="sm"
                                                    nav-button-variant="primary"
                                                />
                                            </b-input-group-append>
                                        </b-input-group>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col md="6">
                                    <b-form-group
                                        label="W.O.No."
                                        label-for="woNumber"
                                    >
                                        <b-form-input
                                            v-model="formData.woNumber"
                                            id="woNumber"
                                            readonly
                                        />
                                    </b-form-group>
                                </b-col>
                                <b-col md="6">
                                    <b-form-group
                                        label="Complete Date"
                                        label-for="completeDate"
                                    >
                                        <b-input-group>
                                            <cleave
                                                id="completeDate"
                                                v-model="formData.completeDate"
                                                class="form-control"
                                                :raw="false"
                                                :options="dateFormat"
                                                placeholder="DD/MM/YYYY"
                                                show-decade-nav
                                            />
                                            <b-input-group-append>
                                                <b-form-datepicker
                                                    v-model="formatDates.completeDate" button-only
                                                    @input="getJobCardCompleteDate($event)"
                                                    show-decade-nav
                                                    size="sm"
                                                    nav-button-variant="primary"
                                                />
                                            </b-input-group-append>
                                        </b-input-group>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-form-group
                                label="Item Code"
                                label-for="itemCode"
                            >
                                <b-form-input
                                    id="itemCode"
                                    v-model="formData.itemCode"
                                    readonly
                                />
                            </b-form-group>
                            <b-form-group
                                label="Item Description"
                                label-for="itemDescription"
                            >
                                <b-form-input
                                    id="itemDescription"
                                    v-model="formData.itemDescription"
                                    readonly
                                />
                            </b-form-group>
                            <b-form-group
                                label="Item Make"
                                label-for="itemMake"
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
                                />
                            </b-form-group>
                            <b-form-group
                                label="Add Description"
                                label-for="addDescription"
                            >
                                <b-form-input
                                    id="addDescription"
                                    v-model="formData.addDescription"
                                />
                            </b-form-group>
                            <b-form-group
                                label="MSN No."
                                label-for="msnNo"
                            >
                                <b-form-input
                                    v-model="formData.msnNo"
                                    id="msnNo"
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
                                        />
                                    </b-form-group>
                                </b-col>
                                <b-col md="6">
                                    <b-form-group
                                        label="Drawing Revesion"
                                        label-for="drawingRevesion"
                                    >
                                        <b-form-input
                                            id="drawingRevesion"
                                            v-model="formData.drawingRevesion"
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
                                        label="Conv. UOM"
                                        label-for="convUom"
                                    >
                                        <v-select
                                            id="convUom"
                                            v-model="formData.convUom"
                                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                            :options="uomOptions"
                                            :clearable="false"
                                            :reduce="val => val.value"
                                        />
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col md="6">
                                    <b-form-group
                                        label="Conv Qty"
                                        label-for="convQty"
                                    >
                                        <b-form-input
                                            id="convQty"
                                            v-model="formData.convQty"
                                            type="number"
                                        />
                                    </b-form-group>
                                </b-col>
                                <b-col md="6">
                                    <b-form-group
                                        label="CFactor"
                                        label-for="cFactor"
                                    >
                                        <b-form-input
                                            id="cFactor"
                                            v-model="formData.cFactor"
                                        />
                                    </b-form-group>
                                </b-col>
                            </b-row>

                            <b-form-group
                                label="BOM No."
                                label-for="bomNumber"
                            >
                                <v-select
                                    v-model="formData.bomNumber"
                                    placeholder="Select BOM"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="bomNumberOPtion"
                                    :reduce="val => val.value"
                                    :clearable="false"
                                    input-id="bomNumber"
                                    disabled="disabled"
                                />
                            </b-form-group>
                            <b-row>
                                <b-col md="6">
                                    <b-form-group
                                        label="Forecast No."
                                        label-for="foreCastNo"
                                    >
                                        <b-form-input
                                            id="foreCastNo"
                                            v-model="formData.foreCastNo"
                                        />
                                    </b-form-group>
                                </b-col>
                                <b-col md="6">
                                    <b-form-group
                                        label="Ref. No."
                                        label-for="refNo"
                                    >
                                        <b-form-input
                                            v-model="formData.refNo"
                                            id="refNo"
                                        />
                                    </b-form-group>
                                </b-col>
                            </b-row>
                        </b-col>
                        <!--row division -->
                        <b-col md="6">
                            <b-row>
                                <b-col md="6">
                                    <b-form-group
                                        label="Job Card"
                                        label-for="jobCard"
                                    >
                                        <v-select
                                            v-model="formData.jobCard"
                                            placeholder="Select Job Card"
                                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                            :options="jobCardType"
                                            :reduce="val => val.value"
                                            :clearable="false"
                                            input-id="jobCard"
                                        />
                                    </b-form-group>
                                </b-col>
                                <b-col md="6">
                                    <b-form-group
                                        label="Status"
                                        label-for="status"
                                    >
                                        <v-select
                                            v-model="formData.status"
                                            placeholder="Select Status"
                                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                            :options="statusOptions"
                                            :reduce="val => val.value"
                                            :clearable="false"
                                            input-id="status"
                                            disabled="disabled"
                                        />
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col md="6">
                                    <b-form-group
                                        label="Priority"
                                        label-for="priority"
                                    >
                                        <v-select
                                            v-model="formData.priority"
                                            placeholder="Select priority"
                                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                            :options="priorityOptions"
                                            :reduce="val => val.value"
                                            :clearable="false"
                                            input-id="priority"
                                        />
                                    </b-form-group>
                                </b-col>
                                <b-col md="6">
                                    <b-form-group
                                        label="Is Excisable"
                                        label-for="isExcisable"
                                    >
                                        <v-select
                                            v-model="formData.isExcisable"
                                            placeholder="Select Excisable"
                                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                            :options="excisableOptions"
                                            :reduce="val => val.value"
                                            :clearable="false"
                                            input-id="isExcisable"
                                        />
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col md="6">
                                    <b-form-group
                                        label="Job Card Qty. UM"
                                        label-for="quantityUm"
                                    >
                                        <b-form-input
                                            id="quantityUm"
                                            v-model="formData.quantityUm"
                                            @keyup="calculateAmount"
                                        />
                                    </b-form-group>
                                </b-col>
                                <b-col md="6">
                                    <b-form-group
                                        label="Job Card Qty. UP"
                                        label-for="quantityUp"
                                    >
                                        <b-form-input
                                            id="quantityUp"
                                            v-model="formData.quantityUp"
                                        />
                                    </b-form-group>
                                </b-col>
                            </b-row>
<!--                            <b-form-group
                                label="Job Qty"
                                label-for="jobQty"
                            >
                                <b-form-input
                                    v-model="formData.jobQty"
                                    id="jobQty"
                                />
                            </b-form-group>-->
                            <b-form-group
                                label="Pending Job Qty"
                                label-for="pendingJobQty"
                            >
                                <b-form-input
                                    v-model="formData.pendingJobQty"
                                    id="pendingJobQty"
                                />
                            </b-form-group>
                            <b-form-group
                                label="Accepted Qty"
                                label-for="acceptedQty"
                            >
                                <b-form-input
                                    v-model="formData.acceptedQty"
                                    id="acceptedQty"
                                    readonly
                                />
                            </b-form-group>
                            <b-form-group
                                label="R/W Qty"
                                label-for="rwQty"
                            >
                                <b-form-input
                                    v-model="formData.rwQty"
                                    id="rwQty"
                                    readonly
                                />
                            </b-form-group>
                            <b-form-group
                                label="Rejected Qty"
                                label-for="rejectedQty"
                            >
                                <b-form-input
                                    v-model="formData.rejectedQty"
                                    id="rejectedQty"
                                    readonly
                                />
                            </b-form-group>
                            <b-form-group
                                label="SC Qty"
                                label-for="scQty"
                            >
                                <b-form-input
                                    v-model="formData.scQty"
                                    id="scQty"
                                    readonly
                                />
                            </b-form-group>
                            <b-form-group
                                label="Heat/Batch No."
                                label-for="heatBatchNo"
                            >
                                <b-form-input
                                    v-model="formData.heatBatchNo"
                                    id="heatBatchNo"
                                />
                            </b-form-group>
                            <b-form-group
                                label="Process Sheet No."
                                label-for="processSheetNo"
                            >
                                <b-form-input
                                    v-model="formData.processSheetNo"
                                    id="processSheetNo"
                                    readonly
                                />
                            </b-form-group>
                            <b-form-group
                                label="Remark"
                                label-for="remark"
                            >
                                <b-form-textarea
                                    v-model="formData.remark"
                                    id="remark"
                                    rows="2"
                                />
                            </b-form-group>
                            <!--  radio Buttons-->
                            <b-form-group
                                label="Select Batch"
                                label-for="selectBatch"
                            >
                                <div class="demo-inline-spacing">
                                    <b-form-radio
                                        name="selectBatch"
                                        value="1"
                                        type="radio"
                                        v-model="formData.selectBatch"
                                    >
                                        Form Stock
                                    </b-form-radio>
                                    <b-form-radio
                                        name="selectBatch"
                                        value="2"
                                        type="radio"
                                        v-model="formData.selectBatch"
                                    >
                                        Form JW Chn
                                    </b-form-radio>
                                </div>
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
                                Update
                            </b-button>
                        </b-col>
                    </b-row>
                </b-form>
            </b-card-code>
        </b-overlay>
        <b-overlay
            :show="showOverlayLoading"
            rounded="sm"
        >
            <b-card-code>
                <b-tabs pills lazy>
                    <b-tab active>
                        <template #title>
                            <feather-icon
                                icon="FileTextIcon"
                                size="16"
                                class="mr-0 mr-sm-50"
                            />
                            <span class="d-none d-sm-inline">Process Details</span>
                        </template>
                        <hr>
                        <process-sheet-details
                            :processSheetItemId="formData"
                            :jobCardBomNumber="formData.bomNumber"
                        />
                    </b-tab>
                    <b-tab>
                        <template #title>
                            <feather-icon
                                icon="TrashIcon"
                                size="16"
                                class="mr-0 mr-sm-50"
                            />
                            <span class="d-none d-sm-inline">Scrap Details</span>
                        </template>
                        <hr>
                        <scrap-details
                            :scrap-details="formData.scrapDetails"
                            :ItemListOption="ItemListOption"
                        />
                    </b-tab>
                    <b-tab>
                        <template #title>
                            <feather-icon
                                icon="ChevronsUpIcon"
                                size="16"
                                class="mr-0 mr-sm-50"
                            />
                            <span class="d-none d-sm-inline">Show Issue Item</span>
                        </template>
                        <hr>
                        <show-issue-item
                        />
                    </b-tab>
                    <b-tab>
                        <template #title>
                        <feather-icon
                            icon="ChevronsDownIcon"
                            size="16"
                            class="mr-0 mr-sm-50"
                        />
                        <span class="d-none d-sm-inline">Process Inside</span>
                    </template>
                        <hr>
                        <process-inside
                            :jobQty.sync="formData.quantityUm"
                            :processNumber="formData.processSheetNo"
                        />
                    </b-tab>
                    <b-tab>
                        <template #title>
                            <feather-icon
                                icon="ChevronsRightIcon"
                                size="16"
                                class="mr-0 mr-sm-50"
                            />
                            <span class="d-none d-sm-inline">Process Outside</span>
                        </template>
                        <hr>
                        <process-outside
                            :itemCode="formData.itemCode"
                        />
                    </b-tab>
                    <b-tab>
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
        </b-overlay>
    </div>
</template>

<script>
    import BCardCode from "../../../@core/components/b-card-code/BCardCode";
    import {
        BForm, BTab, BTabs,
        BCol,
        BRow,
        BFormGroup,
        BFormInput,
        BFormDatepicker,
        BFormTextarea,
        BButton,
        BFormValidFeedback,
        BInputGroupAppend,
        BInputGroup,
        BFormInvalidFeedback,
        BFormRadio,
        BOverlay
    } from 'bootstrap-vue'
    import {ValidationProvider, ValidationObserver} from 'vee-validate'
    import { forMatIndianDate, forMatIndianDateAndTime, getTcTodayDate } from '@core/utils/utils'
    import vSelect from 'vue-select'
    import Ripple from 'vue-ripple-directive'
    import {onUnmounted, ref} from "@vue/composition-api";
    import store from '@/store'
    import jobCardStoreModule from "../jobCardStoreModule";
    import router from '@/router'
    import {useToast} from 'vue-toastification/composition'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import processSheetDetails from "./tabs/processSheetDetails";
    import scrapDetails from "./tabs/scrapDetails";
    import loginTabDetails from "./tabs/loginTabDetails"
    import axios from '@axios'
    import Cleave from 'vue-cleave-component'
    import processInside from "./tabs/processInside"
    import processOutside from "./tabs/processOutside"
    import showIssueItem from "./tabs/showIssueItem"
    import {getUserData} from '../../../auth/utils'

    export default {
        components: {
            BCardCode,
            ValidationObserver,
            ValidationProvider,
            BFormValidFeedback,
            BInputGroupAppend,
            BInputGroup,
            BFormInvalidFeedback,
            BFormRadio,
            BTab,
            BTabs,
            BForm,
            BCol,
            BRow,
            BFormGroup,
            BFormInput,
            BFormTextarea,
            BFormDatepicker,
            BButton,
            getTcTodayDate,
            vSelect,
            Cleave,
            processSheetDetails,
            loginTabDetails,
            scrapDetails,
            processInside,
            processOutside,
            showIssueItem,
            BOverlay
        },
        directives: {
            Ripple,
        },
        setup() {
            const showOverlayLoading = ref(false)
            //alert toast
            const toast = useToast()

            const SE_APP_STORE_MODULE_NAME = 'update-job-card'

            if (!store.hasModule(SE_APP_STORE_MODULE_NAME)) store.registerModule(SE_APP_STORE_MODULE_NAME, jobCardStoreModule)

            onUnmounted(() => {
                if (store.hasModule(SE_APP_STORE_MODULE_NAME)) store.unregisterModule(SE_APP_STORE_MODULE_NAME)
            })

            const currentUser = ref(getUserData())

            const uomOptions = ref([])
            axios.get('/api/get-uom-master-options').then(res => {
                uomOptions.value = res.data.data
            })
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
                jobCardDate: null,
                completeDate: null,
            })

            const getJobCardFormateDate = (date) => {
                formData.value.jobCardDate = forMatIndianDate(date)
            }

            const getJobCardCompleteDate = (date) => {
                formData.value.completeDate = forMatIndianDate(date)
            }

            const formData = ref({
                jobCardDate: getTcTodayDate(),
                woNumber: null,
                itemCode: null,
                itemDescription: null,
                jobCardNumber: null,
                status: null,
                completeDate: getTcTodayDate(),
                itemMake:null,
                addDescription: null,
                detailDescription: null,
                drawingNumber: null,
                drawingRevesion: null,
                uom: null,
                convUom: null,
                convQty: null,
                cFactor: null,
                bomNumber: null,
                foreCastNo: null,
                priority: null,
                refNo: null,
                isExcisable: null,
                // woStatus: 1,
                jobCard: null,
                jobQty: null,
                pendingJobQty: null,
                acceptedQty: null,
                rwQty: null,
                rejectedQty: null,
                scQty: null,
                heatBatchNo: null,
                processSheetNo: null,
                remark: null,
                selectBatch: null,
                scrapDetails: {
                    scrapItemId: null,
                    scrapCode: null,
                    scrapDesc: null,
                    matIssueWt: null,
                    scrapQty: null,
                },
                loginDetails: {
                    createdBy: null,
                    dateTime: null,
                    lastModifiedBy: null,
                    modifiedDateTime: null,
                },
            })

            const uomOption = ref([])
            axios.get('/api/get-uom-master-options').then(res => {
                uomOption.value = res.data.data
            })

            const bomNumberOPtion = ref([])
            axios.get('/api/get-bom-versions-options').then(res => {
                bomNumberOPtion.value = res.data.data
            })
            const refetchData = async () => {
                showOverlayLoading.value = true
                await axios.get(`/api/job-cards/${router.currentRoute.params.id}`).then(res => {
                    formData.value = res.data.data
                })
                showOverlayLoading.value = false
            }
            refetchData()


            const saveFormData = async () => {
                formData.value.loginDetails.lastModifiedBy = currentUser.value.first_name + ' ' + currentUser.value.last_name
                formData.value.loginDetails.modifiedDateTime = forMatIndianDateAndTime(new Date());
                await store.dispatch('update-job-card/updateJobCard', formData.value).then(res => {
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
                })

            }

            const calculateAmount = () => {
                formData.value.quantityUp = formData.value.convQty * formData.value.cFactor * formData.value.quantityUm ?? 0
                formData.value.pendingJobQty = formData.value.quantityUm
            }

            const statusOptions = ref([
                {label: 'Pending', value: 1},
                {label: 'Canceled', value: 2},
                {label: 'Completed', value: 3},
            ])

            const priorityOptions = ref([
                {label: 'Low', value: 1},
                {label: 'Medium', value: 2},
                {label: 'High', value: 3},
            ])

            const excisableOptions = ref([
                {label: 'Yes', value: 1},
                {label: 'No', value: 2},
            ])
            const jobCardType = ref([
                {label: 'Against Work Order', value: 1},
                {label: 'For Stock', value: 2},
                {label: 'For Process Purchase', value: 3},
                {label: 'Against Work Order Sub Assembly', value: 4},
                {label: 'Against Customer Work', value: 5},
                {label: 'Against Customer Work Option 2', value: 6},
                {label: 'Against Forecast', value: 7},
                {label: 'Against Sales Order', value: 8},
            ])

            const ItemListOption = ref([])

            axios.get('/api/get-item-master-options').then(res => {
                ItemListOption.value = res.data.data
            })

            return {
                formData,
                statusOptions,
                excisableOptions,
                jobCardType,
                uomOption,
                bomNumberOPtion,
                priorityOptions,
                calculateAmount,
                ItemListOption,
                saveFormData,
                uomOptions,
                getJobCardCompleteDate,
                getJobCardFormateDate,
                dateFormat,
                formatDates,
                showOverlayLoading,
                refetchData,
                makeOption
                //required,
            }
        },
    }
</script>
