<template>
    <div>
        <b-card-code>
            <validation-observer #default="{ handleSubmit }">
                <b-form @submit.prevent="handleSubmit(saveFormData)">
                    <b-row>
                        <b-col md="6">
                            <validation-provider
                                #default="validationContext"
                                name="Req. No"
                                rules=""
                            >
                                <b-form-group
                                    label="Req. No"
                                    label-for="reqNumber"
                                >
                                    <b-form-input
                                        id="reqNumber"
                                        readonly
                                        v-model="formData.reqNumber"
                                        :state="getValidationState(validationContext)"
                                    />
                                    <b-form-invalid-feedback>
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                            <div v-if="formData.reqType === 1">
                                <validation-provider
                                    #default="validationContext"
                                    name="W.O.No"
                                    rules=""
                                >
                                    <b-form-group
                                        label="W.O.No"
                                        label-for="woNumber"
                                        :state="getValidationState(validationContext)"
                                    >
                                        <b-input-group>
                                            <b-form-input
                                                readonly
                                                v-model="formData.woNumber"
                                                :state="getValidationState(validationContext)"
                                            />
                                            <b-input-group-append>
                                                <b-button variant="primary" @click="openModal">...</b-button>
                                            </b-input-group-append>
                                        </b-input-group>
                                        <b-form-invalid-feedback>
                                            {{ validationContext.errors[0] }}
                                        </b-form-invalid-feedback>
                                    </b-form-group>
                                </validation-provider>
                            </div>
                            <div v-if="formData.reqType === 3">
                                <validation-provider
                                    #default="validationContext"
                                    name="Job Card No"
                                    rules=""
                                >
                                    <b-form-group
                                        label="Job Card No."
                                        label-for="jobCardNumber"
                                        :state="getValidationState(validationContext)"
                                    >
                                        <b-input-group>
                                            <b-form-input
                                                readonly
                                                v-model="formData.jobCardNumber"
                                                :state="getValidationState(validationContext)"
                                                id="jobCardNumber"
                                            />
                                            <b-input-group-append>
                                                <b-button variant="primary" @click="openJobCardModal">...</b-button>
                                            </b-input-group-append>
                                        </b-input-group>
                                        <b-form-invalid-feedback>
                                            {{ validationContext.errors[0] }}
                                        </b-form-invalid-feedback>
                                    </b-form-group>
                                </validation-provider>
                            </div>
                        </b-col>
                        <b-col md="6">
                            <validation-provider
                                #default="validationContext"
                                name="Date"
                                rules=""
                            >
                                <b-form-group
                                    label="Date"
                                    label-for="date"
                                >
                                    <b-input-group>
                                        <b-input-group-prepend>
                                            <b-form-datepicker
                                                v-model="formatDates.woDate"
                                                button-only
                                                @input="getWoFormateDate($event)"
                                                show-decade-nav
                                                size="sm"
                                                nav-button-variant="primary"
                                            />
                                        </b-input-group-prepend>
                                        <cleave
                                            id="woDate"
                                            v-model="formData.woDate"
                                            class="form-control"
                                            :raw="false"
                                            :options="dateFormat"
                                            placeholder="DD/MM/YYYY"
                                            show-decade-nav
                                        />
                                    </b-input-group>
                                    <b-form-invalid-feedback>
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                            <validation-provider
                                #default="validationContext"
                                name="Req. Type"
                                rules="required"
                            >
                                <b-form-group
                                    label="Req. Type"
                                    label-for="reqType"
                                    :state="getValidationState(validationContext)"
                                >
                                    <v-select
                                        placeholder="Select Type"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="workOrderType"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        id="reqType"
                                        v-model="formData.reqType"
                                    />
                                    <b-form-invalid-feedback>
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                        </b-col>
                        <b-col md="12">
                            <hr>
                            <b-button
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
        <!-- Wo Modal -->
        <b-modal
            id="woModal"
            title="Work Order List"
            size="xl"
            no-close-on-backdrop
            ref="woModal"
            scrollable
            ok-variant="primary"
            cancel-variant="danger"
            ok-title="Save"
            cancel-title="Cancel"
            @close="resetSalesModalData"
            @cancel="resetSalesModalData"
        >
            <b-row>
                <b-col md="4">
                    <b-form-group
                        label="W.O. No."
                        label-for="modalWoNumber"
                    >
                        <b-input-group>
                            <b-form-input
                                readonly
                                id="modalWoNumber"
                                v-model="modalWONumber"
                            />
                            <b-input-group-append>
                                <b-button variant="primary" @click="openWoModal">...</b-button>
                            </b-input-group-append>
                        </b-input-group>
                    </b-form-group>
                </b-col>
                <!-- Breadcrumb Area-->
                <b-col md="12">
                    <hr>
                    <b-breadcrumb class="breadcrumb-chevron mb-0 mt-1">
                        <b-breadcrumb-item
                            v-for="(item, key) in woBreadCumItems"
                            :key="key"
                            :active="item.active"
                            @click="getPreviousItems(item)"
                        >
                            <span v-if="item.assemblyCode">
                                {{ item.assemblyCode }}
                            </span>
                            <span v-else>
                                {{ item.itemCode }}
                            </span>
                        </b-breadcrumb-item>
                    </b-breadcrumb>
                    <hr>
                </b-col>
            </b-row>
            <b-table
                responsive
                :fields="modalTableData.salesOrderItemFields"
                :items="modalTableData.salesOrderItemData"
                ref="table"
                show-empty
                bordered
                hover
                :busy="woModalIsBusy"
            >
                <!--Loader-->
                <template #table-busy>
                    <div class="text-center my-2">
                        <b-spinner class="align-middle"></b-spinner>
                        <strong>Loading...</strong>
                    </div>
                </template>

                <!--Select Item-->
                <template #cell(checkItems)="data">
                    <b-form-checkbox
                        :value="`${data.item._id}`"
                        class="custom-control-primary"
                        @change="selectWoItem($event,`${data.item._id}`)"
                    />
                </template>

                <!-- Assembly Items Button -->
                <template #cell(showChildItems)="data">
                    <b-button
                        v-if="data.item.itemType === 'A'"
                        variant="primary"
                        size="sm"
                        class="custom-control-primary"
                        @click="selectWoChildItems(data.item)"
                    >
                        Show
                    </b-button>
                </template>
            </b-table>
        </b-modal>

        <!--WO Item Modal-->
        <b-modal
            id="woModalItem"
            title="Work Order Item List"
            size="xl"
            no-close-on-backdrop
            ref="woModalItem"
            scrollable
            ok-only
            ok-variant="danger"
            ok-title="Cancel"
            @cancel="resetSalesModalData"
        >
            <b-table
                responsive
                :fields="modalTableData.workOrderListField"
                :items="modalTableData.workOrderListData"
                ref="table"
                show-empty
                bordered
                hover
            >
                <template #cell(selectButton)="data">
                    <b-button
                        variant="primary"
                        size="sm"
                        type="button"
                        @click="selectWo(data.item)"
                    >
                        Select
                    </b-button>
                </template>
            </b-table>
        </b-modal>

        <!--Job Item Modal-->
        <b-modal
            id="jobModalItem"
            title="Job Card List"
            size="xl"
            no-close-on-backdrop
            ref="jobModalItem"
            scrollable
            ok-variant="primary"
            cancel-variant="danger"
            @close="resetJobCardModalData"
            @cancel="resetJobCardModalData"
        >
            <b-table
                responsive
                :fields="modalTableData.jobCardListField"
                :items="modalTableData.jobCardListData"
                show-empty
                bordered
                hover
                class="table_scroll"
            >
                <template #cell(selectButton)="data">
                    <b-button
                        variant="primary"
                        size="sm"
                        type="button"
                        @click="selectJobCard(data.item)"
                    >
                        Select
                    </b-button>
                </template>
            </b-table>

            <b-row>
                <b-col md="12">
                    <hr>
                    <h5>Job Card Items</h5>
                    <hr>
                    <b-table
                        responsive
                        :fields="modalTableData.jobCardItemListField"
                        :items="modalTableData.jobCardItemListData"
                        show-empty
                        bordered
                        hover
                        class="table_scroll"
                        :busy="jobCardItemTableBusy"
                    >
                        <!-- Loader -->
                        <template #table-busy>
                            <div class="text-center my-2">
                                <b-spinner class="align-middle"></b-spinner>
                                <strong>Loading...</strong>
                            </div>
                        </template>

                        <template #cell(selectCheckBox)="data">
                            <b-form-checkbox
                                @input="checkJobCardItem($event, data.item._id)"
                            />
                        </template>
                    </b-table>
                </b-col>
            </b-row>
        </b-modal>
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
    BTabs,
    BTab,
    BInputGroupPrepend,
    BBreadcrumb,
    BBreadcrumbItem,
} from 'bootstrap-vue'
import { required } from '@validations'
import Ripple from 'vue-ripple-directive'
import vSelect from 'vue-select'
import store from '@/store'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
import { ValidationProvider, ValidationObserver } from 'vee-validate'
import formValidation from '@core/comp-functions/forms/form-validation'
import { ref, onUnmounted } from '@vue/composition-api'
import axios from '@axios'
import { getUserData } from '../../../auth/utils'
import moment from 'moment'
import { getTcTodayDate, getSalesTypeListOption } from '@core/utils/utils'
import productionPlanningStoreModule from '../productionPlanningStoreModule'
import { useToast } from 'vue-toastification/composition'
import router from '@/router'
import ItemDetails from '../work-order-item-requisition/tabs/itemDetails'
import WoLoginTab from './tabs/woLoginTab'
import { forMatIndianDate } from '@core/utils/utils'
import Cleave from 'vue-cleave-component'

export default {
    components: {
        WoLoginTab,
        ItemDetails,
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
        BSpinner,
        BTabs,
        BTab,
        vSelect,
        Cleave,
        BInputGroupPrepend,
        BBreadcrumb,
        BBreadcrumbItem
    },
    directives: {
        Ripple,
    },
    setup({
        woModal,
        woModalItem,
        jobModalItem
    }) {

        const ITEMADDON_APP_STORE_MODULE_NAME = 'production-planning'
        if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, productionPlanningStoreModule)
        onUnmounted(() => {
            if (store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.unregisterModule(ITEMADDON_APP_STORE_MODULE_NAME)
        })

        const toast = useToast()

        woModal = ref()

        woModalItem = ref()
        jobModalItem = ref()
        const woModalIsBusy = ref(false)

        const CurrentUserData = ref(getUserData())

        const workOrderType = ref([
            {
                label: 'Against Work Order',
                value: 1
            },
            {
                label: 'Manual',
                value: 2
            },
            {
                label: 'Against Job Order',
                value: 3
            },
        ])

        const dateFormat = ref({
            date: true,
            delimiter: '/',
            datePattern: ['d', 'm', 'Y'],
        })

        const formatDates = ref({
            woDate: null,
        })

        const jobCardItemTableBusy = ref(false)

        const getWoFormateDate = (date) => {
            formData.value.woDate = forMatIndianDate(date)
        }

        const salesTypeOptions = getSalesTypeListOption()

        const blankFormData = {
            reqNumber: null,
            woNumber: null,
            jobCardId: null,
            jobCardNumber: null,
            jobCardItemIds: [],
            woDate: forMatIndianDate(getTcTodayDate()),
            reqType: 1,
            LoginData: {
                createdBy: CurrentUserData.value.first_name + ' ' + CurrentUserData.value.last_name,
                createdDate: moment(new Date())
                    .format('DD/MM/YYYY HH:mm'),
                lastModifyBy: null,
                lastModifyDate: null,
                approveBy: null,
                approveDate: null,
                stage: 1,
            },
            itemList: []
        }

        const formData = ref(JSON.parse(JSON.stringify(blankFormData)))

        const resetFormData = () => {
            formData.value = JSON.parse(JSON.stringify(blankFormData))
        }

        const modalTableData = ref({
            salesOrderItemFields: [
                {
                    key: 'checkItems',
                    label: ''
                },
                {
                    key: 'showChildItems',
                    label: ''
                },
                {
                    key: 'item_name.itemCode',
                    label: 'Assembly'
                },
                {
                    key: 'itemType',
                    label: 'Type'
                },
                {
                    key: 'itemDescription',
                    label: 'Item Description'
                },
                {
                    key: 'itemDrawingNumber',
                    label: 'Drg No.'
                },
                {
                    key: 'itemBomQty',
                    label: 'Bom Qty'
                },
                {
                    key: 'itemReqQty',
                    label: 'Req Qty'
                },
                {
                    key: 'itemIssueQty',
                    label: 'Issue Qty'
                },
                {
                    key: 'itemPendingQty',
                    label: 'Pending Qty'
                },
                {
                    key: 'itemCurrentStock',
                    label: 'Current Stock'
                },
                {
                    key: 'itemQty',
                    label: 'IQty'
                },
            ],
            salesOrderItemData: [],
            workOrderListField: [
                {
                    key: 'selectButton',
                    label: ''
                },
                {
                    key: 'woNumber',
                    label: 'W.O. No.'
                },
                {
                    key: 'assemblyCode',
                    label: 'Item Code'
                },
                {
                    key: 'assembly',
                    label: 'Item Desc.'
                },
                {
                    key: 'drawingNo',
                    label: 'Drawing Number'
                },
                {
                    key: 'soNumber',
                    label: 'S.O. No'
                },
                {
                    key: 'woQty',
                    label: 'W.O. Qty'
                },
                {
                    key: 'pendingQty',
                    label: 'Pend Qty'
                },
                {
                    key: 'status',
                    label: 'Status'
                },
                {
                    key: 'dsNo',
                    label: 'DS No.'
                },
                {
                    key: 'bomNumber.bomNumber',
                    label: 'BOM No'
                },
            ],
            workOrderListData: [],
            jobCardListField: [
                {
                    key: 'selectButton',
                    label: ''
                },
                {
                    key: 'jobCardNumber',
                    label: 'Job Card No.'
                },
                {
                    key: 'itemCode',
                    label: 'Item Code'
                },
                {
                    key: 'itemDescription',
                    label: 'Item Description'
                },
                {
                    key: 'status',
                    label: 'Status',
                    formatter: val => getStatus(val)
                },
            ],
            jobCardListData: [],
            jobCardItemListField: [
                {
                    key: 'selectCheckBox',
                    label: ''
                },
                {
                    key: 'item_name.itemCode',
                    label: 'Item Code'
                },
                {
                    key: 'issueItemDescription',
                    label: 'Item Description'
                },
                {
                    key: 'uom_detail.uom',
                    label: 'UOM'
                },
                {
                    key: 'issueRequiredQty',
                    label: 'Quntity'
                },
                {
                    key: 'issueItemQty',
                    label: 'Issue Qty'
                },
                {
                    key: 'issueItemPendingQty',
                    label: 'Pending Qty'
                },
            ],
            jobCardItemListData: [],
        })

        let selectedWo = null

        const resetSalesModalData = () => {

        }

        const modalWONumber = ref('')

        const openModal = async () => {
            modalTableData.value.salesOrderItemData = []
            formData.value.itemList = []
            woBreadCumItems.value = []
            modalWONumber.value = null
            if (formData.value.reqType === 1) {
                return woModal.value.show()
            }
        }

        const openWoModal = async () => {
            await axios.get('/api/get-pending-work-orders')
                .then(res => {
                    modalTableData.value.workOrderListData = res.data.data
                })
            woModalItem.value.show()
        }

        const woBreadCumItems = ref([])

        const selectWo = async (data) => {
            woModalIsBusy.value = true
            woBreadCumItems.value.push({
                id: data._id,
                assemblyCode: data.assemblyCode
            })
            await axios.get(`/api/get-pending-work-order-assembly-items/${data._id}`)
                .then(res => {
                    modalTableData.value.salesOrderItemData = res.data.data
                })
            modalWONumber.value = data.woNumber
            formData.value.woNumber = data.woNumber
            woModalItem.value.hide()
            woModalIsBusy.value = false
        }

        const selectWoChildItems = async (data) => {
            woModalIsBusy.value = true
            woBreadCumItems.value.push({
                id: data._id,
                itemCode: data.item_name.itemCode
            })
            await axios.get(`/api/get-pending-work-order-assembly-items-child/${data._id}`)
                .then((res) => {
                    modalTableData.value.salesOrderItemData = res.data.data
                })
            woModalIsBusy.value = false
        }

        const getPreviousItems = async (item) => {
            woModalIsBusy.value = true
            let items = woBreadCumItems.value
            if (item.assemblyCode){
                woBreadCumItems.value = [];
                woBreadCumItems.value.push({
                    id: item.id,
                    assemblyCode: item.assemblyCode
                })
                await axios.get(`/api/get-pending-work-order-assembly-items/${item.id}`)
                    .then(res => {
                        modalTableData.value.salesOrderItemData = res.data.data
                    })
            } else {
                let newItemList = [];
                items.every(value => {
                    if (value.itemCode !== item.itemCode) {
                        newItemList.push(value)
                        return true
                    } else {
                        newItemList.push(value)
                        return false
                    }
                })
                woBreadCumItems.value = newItemList
                await axios.get(`/api/get-pending-work-order-assembly-items-child/${item.id}`)
                    .then((res) => {
                        modalTableData.value.salesOrderItemData = res.data.data
                    })
            }
            woModalIsBusy.value = false
        }

        const selectWoItem = (e, id) => {
            if (e === false) {
                formData.value.itemList = formData.value.itemList.filter(function (e) {
                    return e !== id
                })
            } else {
                formData.value.itemList.push(id)
            }
        }

        const getSelectedItemData = async () => {
            woModal.value.hide()
            await axios.post('/api/workorder/get-assembly-items', { ids: formData.value.itemList })
                .then(res => {
                    formData.value.itemList = res.data.data
                })
        }

        const statusList = ref([
            {
                label: 'Pending',
                value: 1
            },
            {
                label: 'Canceled',
                value: 2
            },
            {
                label: 'Completed',
                value: 3
            },
        ])

        const getStatus = (id) => {
            let valObj = statusList.value.filter(function (elem) {
                if (elem.value === id) {
                    return elem.label
                }
            })
            if (valObj.length > 0) {
                return valObj[0].label
            } else {
                return ''
            }
        }

        const openJobCardModal = async () => {
            formData.value.jobCardItemIds = []
            await axios.get('/api/job-cards')
                .then((res) => {
                    modalTableData.value.jobCardListData = res.data.data
                })
            await jobModalItem.value.show()
        }

        const selectJobCard = async (data) => {
            formData.value.jobCardNumber = data.jobCardNumber
            formData.value.jobCardId = data._id
            jobCardItemTableBusy.value = true
            await axios.get(`/api/new/get-show-issue-item/${data._id}`)
                .then((res) => {
                    modalTableData.value.jobCardItemListData = res.data.data
                })
            jobCardItemTableBusy.value = false
        }

        const resetJobCardModalData = () => {
            modalTableData.value.jobCardItemListData = []
            modalTableData.value.jobCardListData = []
        }

        const checkJobCardItem = (e, id) => {
            if (e === false) {
                formData.value.jobCardItemIds = formData.value.itemIds.filter(function (item) {
                    return item !== id
                })
            } else {
                formData.value.jobCardItemIds.push(id)
            }
        }

        const saveFormData = async () => {
            await store.dispatch('production-planning/addWorkOrderRequisition', formData.value)
                .then(res => {
                    if (res.status === 200) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Work Order Item Requisition Added',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: `You have successfully Added Work Order Item Requisition.`,
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
                    router.push({
                        name: 'edit-work-order-item-requisition',
                        params: { id: res.data.data._id }
                    })
                })
        }

        const {
            refFormObserver,
            getValidationState,
            resetForm
        } = formValidation(resetFormData)

        return {
            workOrderType,
            salesTypeOptions,
            formData,
            modalTableData,
            openModal,
            openWoModal,
            jobCardItemTableBusy,
            selectWo,
            woModal,
            woModalItem,
            jobModalItem,
            openJobCardModal,
            selectJobCard,
            checkJobCardItem,
            saveFormData,
            resetSalesModalData,
            modalWONumber,
            selectWoItem,
            getSelectedItemData,
            resetJobCardModalData,
            selectWoChildItems,
            woModalIsBusy,
            woBreadCumItems,
            getPreviousItems,

            resetFormData,
            refFormObserver,
            getValidationState,
            resetForm,
            getWoFormateDate,
            dateFormat,
            formatDates
        }
    }
}
</script>
