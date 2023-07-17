<template>
    <div>
        <!-- Table -->
        <b-card-code>
            <b-row>
                <b-col md="12">
                    <b-breadcrumb class="breadcrumb-chevron mb-0">
                        <b-breadcrumb-item
                            v-for="(item, key) in breadCumItems"
                            :key="key"
                            :active="item.active"
                            @click="getPreviousItems(item)"
                        >
                            {{ item.text }}
                        </b-breadcrumb-item>
                    </b-breadcrumb>
                </b-col>
            </b-row>
            <b-overlay
                :show="showOverlayLoading"
                rounded="sm"
            >
                <b-row>
                    <b-col md="12">
                        <hr>
                        <b-table
                            responsive
                            :fields="bomItemRows"
                            :items="bomItemData"
                            :bordered="true"
                            :hover="true"
                            show-empty
                            class="table_scroll"
                            :busy="isBusy"
                            selectable
                            select-mode="single"
                            @row-selected="onRowSelect"
                        >
                            <!--Loader-->
                            <template #table-busy>
                                <div class="text-center my-2">
                                    <b-spinner class="align-middle"></b-spinner>
                                    <strong>Loading...</strong>
                                </div>
                            </template>

                            <!--Index-->
                            <template #cell(index)="data">
                                {{ data.index + 1 }}
                            </template>

                            <!-- A custom formatted column -->
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
                                    <div v-if="data.item.itemType === 'A'">
                                        <b-dropdown-item @click="openBomVersionItem(data.item)">
                                            <feather-icon
                                                icon="CheckSquareIcon"
                                                class="mr-50"
                                            />
                                            <span>Open</span>
                                        </b-dropdown-item>
                                    </div>
                                    <b-dropdown-item @click="deleteItem(data.item._id)">
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
                    </b-col>
                </b-row>
            </b-overlay>
        </b-card-code>

        <!-- Tabs -->
        <b-tabs pills lazy>
            <b-tab active>
                <template #title>
                    <feather-icon
                        icon="DatabaseIcon"
                        size="16"
                        class="mr-0 mr-sm-50"
                    />
                    <span class="d-none d-sm-inline">Item Details</span>
                </template>
                <wo-item-details
                    :assembly-form-data.sync="formData"
                    :is-assembly-type-disabled="isTypeDisabled"
                    :is-assembly-item-code-disabled="isItemCodeDisabled"
                    @refetchAssemblyItems="refetchData($event.assemblyId)"
                    @resetAssemblyForm="resetFormData"
                    @disableAssemblyTypeItemCode="disableTypeAndItemCode($event)"
                />
            </b-tab>
        </b-tabs>
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
    BTabs,
    BTab,
    BBreadcrumb,
    BBreadcrumbItem
} from 'bootstrap-vue'
import vSelect from 'vue-select'
import { ref, computed } from '@vue/composition-api'
import axios from '@axios'
import router from '@/router'
import store from '@/store'
import Swal from 'sweetalert2'
import Toastification from '@core/components/toastification/ToastificationContent.vue'
import { useToast } from 'vue-toastification/composition'
import WoItemDetails from './tabs/woItemDetails.vue'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'

export default {
    components: {
        WoItemDetails,
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
        BTabs,
        BTab,
        BBreadcrumb,
        BBreadcrumbItem,
        vSelect
    },
    setup() {
        const showOverlayLoading = ref(false)
        const isBusy = ref(false)
        const toast = useToast()

        const isTypeDisabled = ref(false)
        const isItemCodeDisabled = ref(false)

        const currentWoId = router.currentRoute.params.id
        const currentAssemblyId = computed(() => router.currentRoute.params.assemblyId)
        const breadCumItems = ref([])

        const bomItemRows = ref([
            {
                key: 'rowSelected',
                label: ''
            },
            {
                key: 'index',
                label: 'No'
            },
            {
                key: 'itemType',
                label: 'Type'
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
                key: 'uom_detail.uom',
                label: 'UOM'
            },
            {
                key: 'itemBomQty',
                label: 'Qty'
            },
            {
                key: 'itemDrawingNumber',
                label: 'Drawing Number'
            },
            {
                key: 'itemBomQtyConv',
                label: 'BOM Qty'
            },
            {
                key: 'itemCurrentStock',
                label: 'Curr Stock'
            },
            {
                key: 'itemAssemblyBomNumber',
                label: 'Assb. BomNo'
            },
            {
                key: 'action',
                label: 'Action'
            },
        ])
        const bomItemData = ref([])

        const refetchData = async (assemblyId) => {
            isBusy.value = true
            await axios.get(`/api/work-order-assembly-item-list/${currentWoId}/${assemblyId}`)
                .then((res) => {
                    bomItemData.value = res.data.data
                })
            isBusy.value = false
        }
        refetchData(currentAssemblyId.value)

        axios.get(`/api/work-order-item/${currentAssemblyId.value}`)
            .then((res) => {
                breadCumItems.value.push({
                    text: res.data.data.item_name.itemCode,
                    itemCode: res.data.data._id
                })
            })

        const openBomVersionItem = async (data) => {
            if (data._id) {
                breadCumItems.value.push({
                    text: data.item_name.itemCode,
                    itemCode: data._id
                })
                await router.push({
                    name: 'work-order-item-details',
                    params: {
                        id: currentWoId,
                        assemblyId: data._id,
                    }
                })
                await refetchData(data._id)
                    .then(() => resetFormData())
            } else {
                breadCumItems.value.push({
                    text: data.item_name.itemCode,
                    itemCode: data.id
                })
                await router.push({
                    name: 'work-order-item-details',
                    params: {
                        id: currentWoId,
                        assemblyId: data.id,
                    }
                })
                await refetchData(data.id)
                    .then(() => resetFormData())
            }
        }

        const getPreviousItems = async (item) => {
            let items = breadCumItems.value
            let newItemList = []
            items.every(value => {
                if (value.itemCode !== item.itemCode) {
                    newItemList.push(value)
                    return true
                } else {
                    newItemList.push(value)
                    return false
                }
            })
            breadCumItems.value = newItemList
            await router.push({
                name: 'work-order-item-details',
                params: {
                    id: currentWoId,
                    assemblyId: item.itemCode
                }
            })
            await refetchData(item.itemCode)
                .then(() => resetFormData())
        }

        const blankFormData = {
            id: null,
            woId: currentWoId,
            versionItemId: null,
            itemType: null,
            itemCode: null,
            itemDescription: null,
            itemAddDescription: null,
            itemDrawingNumber: null,
            itemBomQty: null,
            itemBomQtyConv: null,
            itemConvFactor: null,
            itemUom: null,
            itemConvUom: null,
            itemConvQty: null,
            itemMaterialProcessType: null,
            itemNote: null,
            itemDetailDescription: null,
            itemCurrentStock: null,
            itemPositionNumber: null,
            itemDrawingRevision: null,
            itemIssueAtProcess: null,
            itemMake: null,
            itemStore: null,
            itemMaterialInput1: null,
            itemMaterialInput2: null,
            itemMaterialLenght: null,
            itemMaterialQty: null,
            itemMaterialWeight: null,
            itemReqQty: null,
            itemReqQtyConv: null,
            itemLocation: null,
            itemBinNumber: null,
            assemblyCopy: null,
            itemAssemblyBomNumber: null,
            itemStatus: 1,
        }

        const formData = ref(JSON.parse(JSON.stringify(blankFormData)))

        const resetFormData = () => {
            formData.value = JSON.parse(JSON.stringify(blankFormData))
            isTypeDisabled.value = false
            isItemCodeDisabled.value = false
        }

        const onRowSelect = (items) => {
            if (items.length > 0) {
                isTypeDisabled.value = true
                isItemCodeDisabled.value = true
                formData.value.id = items[0]._id
                formData.value.itemType = items[0].itemType ?? null
                formData.value.itemCode = items[0].itemCode ?? null
                formData.value.itemDescription = items[0].itemDescription ?? null
                formData.value.itemAddDescription = items[0].itemAddDescription ?? null
                formData.value.itemDrawingNumber = items[0].itemDrawingNumber ?? null
                formData.value.itemBomQty = items[0].itemBomQty ?? null
                formData.value.itemBomQtyConv = items[0].itemBomQtyConv ?? null
                formData.value.itemConvFactor = items[0].itemConvFactor ?? null
                formData.value.itemUom = items[0].itemUom ?? null
                formData.value.itemConvUom = items[0].itemConvUom ?? null
                formData.value.itemConvQty = items[0].itemConvQty ?? null
                formData.value.itemMaterialProcessType = items[0].itemMaterialProcessType ?? null
                formData.value.itemNote = items[0].itemNote ?? null
                formData.value.itemDetailDescription = items[0].itemDetailDescription ?? null
                formData.value.itemCurrentStock = items[0].itemCurrentStock ?? null
                formData.value.itemPositionNumber = items[0].itemPositionNumber ?? null
                formData.value.itemDrawingRevision = items[0].itemDrawingRevision ?? null
                formData.value.itemIssueAtProcess = items[0].itemIssueAtProcess ?? null
                formData.value.itemMake = items[0].itemMake ?? null
                formData.value.itemStore = items[0].itemStore ?? null
                formData.value.itemMaterialInput1 = items[0].itemMaterialInput1 ?? null
                formData.value.itemMaterialInput2 = items[0].itemMaterialInput2 ?? null
                formData.value.itemMaterialLenght = items[0].itemMaterialLenght ?? null
                formData.value.itemMaterialQty = items[0].itemMaterialQty ?? null
                formData.value.itemMaterialWeight = items[0].itemMaterialWeight ?? null
                formData.value.itemReqQty = items[0].itemReqQty ?? null
                formData.value.itemReqQtyConv = items[0].itemReqQtyConv ?? null
                formData.value.itemLocation = items[0].itemLocation ?? null
                formData.value.assemblyCopy = items[0].assemblyCopy ?? null
                formData.value.itemAssemblyBomNumber = items[0].itemAssemblyBomNumber ?? null
                formData.value.itemStatus = items[0].itemStatus ?? null
            } else {
                resetFormData()
                isTypeDisabled.value = false
                isItemCodeDisabled.value = false
            }
        }


        const deleteItem = async (id) => {
            await Swal.fire({
                title: 'Are you sure?',
                text: 'You won\'t be able to revert this!',
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
                        axios.delete(`/api/work-order-item/${id}`)
                            .then(res => {
                                resetFormData()
                                refetchData(currentAssemblyId.value)
                                if (res.status === 200) {
                                    toast({
                                        component: ToastificationContent,
                                        position: 'top-right',
                                        props: {
                                            title: 'Work Order Item Deleted',
                                            icon: 'CheckSquareIcon',
                                            variant: 'success',
                                            text: `You have successfully Deleted Work Order Item.`,
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
                })
        }

        const disableTypeAndItemCode = (e) => {
            isTypeDisabled.value = true
            isItemCodeDisabled.value = true
        }

        return {
            showOverlayLoading,
            isBusy,
            currentWoId,
            currentAssemblyId,
            isTypeDisabled,
            isItemCodeDisabled,

            breadCumItems,
            bomItemRows,
            bomItemData,
            formData,

            //methods
            refetchData,
            openBomVersionItem,
            getPreviousItems,
            resetFormData,
            deleteItem,
            disableTypeAndItemCode,
            onRowSelect
        }
    }
}
</script>
