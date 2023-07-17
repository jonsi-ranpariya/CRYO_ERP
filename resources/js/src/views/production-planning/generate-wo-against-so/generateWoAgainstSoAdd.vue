<template>
    <div>
        <b-card-code>
            <b-button
                variant="primary"
                type="button"
                @click="openModal"
            >
                Generate
            </b-button>
        </b-card-code>
        <!-- Generate Work Order Modal -->

        <b-modal
            id="generateWorkOrderModal"
            title="Generate WO"
            size="lg"
            no-close-on-backdrop
            ref="generateWorkOrderModal"
            scrollable
            cancel-variant="danger"
            ok-title="Generate"
            @cancel="clearAllModalData"
            @close="clearAllModalData"
            @ok="generateWo"
        >
            <b-row>
                <b-col md="6">
                    <b-form-group
                        label="SO No."
                        label-for="soNumber"
                    >
                        <b-input-group class="d-flex">
                            <b-form-input
                                id="soNumber"
                                v-model="formData.soNumber"
                            />
                            <b-input-group-append>
                                <b-button variant="primary" @click="openSalesOrderModal">...</b-button>
                            </b-input-group-append>
                        </b-input-group>
                    </b-form-group>
                    <b-form-group
                        label="SO Date"
                        label-for="soDate"
                    >
                        <b-form-input
                            id="soDate"
                            v-model="formData.soDate"
                            disabled
                        />
                    </b-form-group>
                </b-col>
                <b-col md="6">
                    <b-form-group
                        label="Party Code"
                        label-for="partyCode"
                    >
                        <b-form-input
                            id="partyCode"
                            v-model="formData.partyCode"
                            disabled
                        />
                    </b-form-group>
                    <b-form-group
                        label="Party Name"
                        label-for="partyName"
                    >
                        <b-form-input
                            id="partyName"
                            v-model="formData.partyName"
                            disabled
                        />
                    </b-form-group>
                </b-col>
                <b-col md="12" v-if="showTable">
                    <hr>
                    <b-table
                        :fields="tableModal.woTableField"
                        :items="tableModal.woTableData"
                        :bordered="true"
                        :hover="true"
                        show-empty
                        class="table_scroll"
                        responsive
                    >
                        <template #cell(index)="data">
                            {{ data.index + 1 }}
                        </template>

                        <template #cell(checkItem)="data">
                            <b-form-checkbox
                                @input="checkItem($event, data.item._id)"
                             />
                        </template>
                    </b-table>
                </b-col>
            </b-row>
        </b-modal>

        <!-- Sales Order Modal -->
        <b-modal
            id="salesOrderModal"
            title="Sales Order List"
            size="lg"
            no-close-on-backdrop
            ref="salesOrderModal"
            scrollable
            ok-only
            ok-title="Cancel"
            ok-variant="danger"
        >
            <b-table
                :fields="tableModal.salesOrderField"
                :items="tableModal.salesOrderData"
                :bordered="true"
                :hover="true"
                show-empty
            >
                <template #cell(selectButton)="data">
                    <b-button
                        variant="primary"
                        size="sm"
                        type="button"
                        @click="selectSalesOrder(data.item)"
                    >
                        Select
                    </b-button>
                </template>
            </b-table>
        </b-modal>
    </div>
</template>
<script>
    import {
        BForm,
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
        BTable,
        BFormCheckbox,
        BCard,
    } from 'bootstrap-vue'
    import BCardCode from "../../../@core/components/b-card-code/BCardCode";
    import {getTcTodayDate} from "../../../@core/utils/utils";
    import vSelect from 'vue-select'
    import Ripple from 'vue-ripple-directive'
    import {onUnmounted, ref} from "@vue/composition-api";
    import store from '@/store'
    import productionPlanning from "../productionPlanningStoreModule";
    import {required} from '@validations'
    import {useToast} from 'vue-toastification/composition'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import router from '@/router'
    import axios from '@axios'
    import moment from 'moment'
    import {getUserData} from "../../../auth/utils";
    import {forMatIndianDate} from '@core/utils/utils'

    export default {
        components: {
            BCardCode,
            BFormValidFeedback,
            BInputGroupAppend,
            BInputGroup,
            BFormInvalidFeedback,
            BFormRadio,
            BForm,
            BCol,
            BRow,
            BFormGroup,
            BFormInput,
            BFormTextarea,
            BFormDatepicker,
            BButton,
            BTable,
            BFormCheckbox,
            BCard,
            vSelect,
        },
        directives: {
            Ripple,
        },
        mounted() {
            this.openModal()
        },
        setup({generateWorkOrderModal, salesOrderModal}) {
            const SE_APP_STORE_MODULE_NAME = 'production-planning'

            if (!store.hasModule(SE_APP_STORE_MODULE_NAME)) store.registerModule(SE_APP_STORE_MODULE_NAME, productionPlanning)

            onUnmounted(() => {
                if (store.hasModule(SE_APP_STORE_MODULE_NAME)) store.unregisterModule(SE_APP_STORE_MODULE_NAME)
            })

            const toast = useToast()

            generateWorkOrderModal = ref()

            salesOrderModal = ref()

            const showTable = ref(false)

            const blankFormData = {
                soId: null,
                soNumber: null,
                soDate: null,
                partyCode: null,
                partyName: null,
                itemIds: []
            }

            const formData = ref(JSON.parse(JSON.stringify(blankFormData)))

            const resetFormData = () => {
                formData.value = JSON.parse(JSON.stringify(blankFormData))
            }

            const openModal = () => {
                generateWorkOrderModal.value.show();
            }

            const tableModal = ref({
                salesOrderField: [
                    {
                        key: 'selectButton',
                        label: ''
                    },
                    {
                        key: 'salesOrderNo',
                        label: 'SO No.'
                    },
                    {
                        key: 'partyDetail.partyDetailName',
                        label: 'Party Name'
                    },
                    {
                        key: 'salesOrderDate',
                        label: 'SO Date',
                        formatter: val => forMatIndianDate(val)
                    },
                    {
                        key: 'customerPoNo',
                        label: 'Cust PO No.'
                    },
                    {
                        key: 'salesOrderStatus',
                        label: 'Status'
                    },
                    {
                        key: 'partyDetail.partyDetailCode',
                        label: 'Party Code'
                    },
                ],
                salesOrderData: [],
                woTableField: [
                    {
                        key: 'checkItem',
                        label: ''
                    },
                    {
                        key: 'index',
                        label: 'No'
                    },
                    {
                        key: 'itemCode',
                        label: 'Item Code'
                    },
                    {
                        key: 'itemName',
                        label: 'Description'
                    },
                    {
                        key: 'uom_details.uom',
                        label: 'UOM'
                    },
                    {
                        key: 'itemQuantity',
                        label: 'Quantity'
                    },
                    {
                        key: 'pendQty',
                        label: 'Pend. Qty.'
                    },
                    {
                        key: 'itemStatus',
                        label: 'Status'
                    }
                ],
                woTableData: [],
            })


            const openSalesOrderModal = async () => {
                await axios.get('/api/sales-order').then(res => {
                    tableModal.value.salesOrderData = res.data.data
                })
                salesOrderModal.value.show();
            }

            const selectSalesOrder = async (data) => {
                formData.value.soId = data._id ?? null
                formData.value.soNumber = data.salesOrderNo ?? null
                formData.value.soDate = data.salesOrderDate ?? null
                formData.value.partyName = data?.partyDetail?.partyDetailName ?? null
                formData.value.partyCode = data?.partyDetail?.partyDetailCode ?? null
                showTable.value = true
                await axios.get(`/api/get-sales-order-items/${data._id}`).then(res => {
                    tableModal.value.woTableData = res.data.data
                })
                salesOrderModal.value.hide();
            }

            const clearAllModalData = () => {
                formData.value.soId = null
                formData.value.soNumber = null
                formData.value.soDate = null
                formData.value.partyName = null
                formData.value.partyCode = null
                formData.value.itemIds = []
                tableModal.value.woTableData = []
                showTable.value = false
            }

            const checkItem = (e, id) => {
                if (e === false) {
                    formData.value.itemIds = formData.value.itemIds.filter(function (e) {
                        return e !== id
                    })
                } else {
                    formData.value.itemIds.push(id)
                }
            }

            const generateWo = async () => {
                await axios.post('/api/generate-wo-from-so', formData.value).then(res => {
                    if (res.status === 200) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Work Order Generate',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: `You have successfully Generate Work Order.`,
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

            return {
                formData,
                resetFormData,
                generateWorkOrderModal,
                salesOrderModal,
                showTable,
                openModal,
                openSalesOrderModal,
                tableModal,
                selectSalesOrder,
                clearAllModalData,
                checkItem,
                generateWo,
            }
        }
    }
</script>
