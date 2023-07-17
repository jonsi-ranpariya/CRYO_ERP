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
                            responsive="sm"
                            :fields="bomItemRows"
                            :items="bomItemData"
                            :bordered="true"
                            :hover="true"
                            show-empty
                            class="table_scroll"
                            :busy="isBusy"
                            selectable
                            select-mode="single"
                            @row-selected="onRowSelected"
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

                            <!--Action-->
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
                                    <div v-if="data.item.itemType === 'A'">
                                        <b-dropdown-item @click="openBomVersionItem(data.item)">
                                            <feather-icon
                                                icon="CheckSquareIcon"
                                                class="mr-50"
                                            />
                                            <span>Open</span>
                                        </b-dropdown-item>
                                    </div>
                                    <b-dropdown-item @click="editBomVersionItem(data.item)">
                                        <feather-icon
                                            icon="Edit2Icon"
                                            class="mr-50"
                                        />
                                        <span>Edit</span>
                                    </b-dropdown-item>
                                    <b-dropdown-item @click="deleteBomVersionItem(data.item)">
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
                    <span class="d-none d-sm-inline">BOM</span>
                </template>
                <bom-assembly-item
                    :bom-form-data.sync="formData"
                    @refetchData="refetchData($event.versionItemId)"
                    @resetFormData="resetFormData"
                />
            </b-tab>
            <b-tab>
                <template #title>
                    <feather-icon
                        icon="ActivityIcon"
                        size="16"
                        class="mr-0 mr-sm-50"
                    />
                    <span class="d-none d-sm-inline">Process Details</span>
                </template>
                <process-details-tab/>
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
import BomTab from './tabs/bomTab'
import ProcessDetailsTab from './tabs/processDetailsTab'
import BomAssemblyItem from './tabs/bomAssemblyItem.vue'
import { ref } from '@vue/composition-api'
import axios from '@axios'
import router from '@/router'
import store from '@/store'
import Swal from 'sweetalert2'
import Toastification from '@core/components/toastification/ToastificationContent.vue'
import { useToast } from 'vue-toastification/composition'

export default {
    components: {
        BomAssemblyItem,
        ProcessDetailsTab,
        BomTab,
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

        const currentBomId = router.currentRoute.params.id
        const currentVersionId = router.currentRoute.params.versionId
        const currentVersionItemId = router.currentRoute.params.versionItemId

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
                key: 'item_details.itemCode',
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

        const refetchData = async (id) => {
            isBusy.value = true
            if (id) {
                await axios.get(`/api/get-bom-version-assembly-items-data/${currentBomId}/${currentVersionId}/${id}`)
                    .then(res => {
                        bomItemData.value = res.data.data
                    })
            } else {
                await axios.get(`/api/get-bom-version-items-data/${currentBomId}/${currentVersionId}`)
                    .then(res => {
                        bomItemData.value = res.data.data
                    })
            }
            showOverlayLoading.value = false
            isBusy.value = false
        }
        refetchData(currentVersionItemId)

        const blankFormData = {
            id: null,
            bomId: currentBomId,
            versionId: currentVersionId,
            versionItemId: null,
            level: 1,
            itemType: null,
            itemCode: null,
            itemDescription: null,
            itemAddDescription: null,
            itemDrawingNumber: null,
            itemMaterialSpecification: null,
            itemBomQty: null,
            itemBomQtyConv: null,
            itemConvFactor: null,
            itemUom: null,
            itemConvUom: null,
            itemConvQty: null,
            itemMaterialProcessType: null,
            itemAssemblyBomNumber: null,
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
            itemRateFrom: null,
            assemblyCopy: 0,
            assemblyFromVersionId: null
        }

        const formData = ref(JSON.parse(JSON.stringify(blankFormData)))

        const resetFormData = async () => {
            formData.value = JSON.parse(JSON.stringify(blankFormData))
        }

        const onRowSelected = (items) => {
            if (items.length > 0) {
                formData.value._id = items[0]._id
                formData.value.bomId = items[0].bomId
                formData.value.versionId = items[0].versionId
                formData.value.versionItemId = items[0].versionItemId
                formData.value.level = items[0].level ?? null
                formData.value.itemType = items[0].itemType ?? null
                formData.value.itemCode = items[0].itemCode ?? null
                formData.value.itemDescription = items[0].itemDescription ?? null
                formData.value.itemAddDescription = items[0].itemAddDescription ?? null
                formData.value.itemDrawingNumber = items[0].itemDrawingNumber ?? null
                formData.value.itemMaterialSpecification = items[0].itemMaterialSpecification ?? null
                formData.value.itemBomQty = items[0].itemBomQty ?? null
                formData.value.itemBomQtyConv = items[0].itemBomQtyConv ?? null
                formData.value.itemConvFactor = items[0].itemConvFactor ?? null
                formData.value.itemUom = items[0].itemUom ?? null
                formData.value.itemConvUom = items[0].itemConvUom ?? null
                formData.value.itemConvQty = items[0].itemConvQty ?? null
                formData.value.itemMaterialProcessType = items[0].itemMaterialProcessType ?? null
                formData.value.itemAssemblyBomNumber = items[0].itemAssemblyBomNumber ?? null
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
                formData.value.itemRateFrom = items[0].itemRateFrom ?? null
                formData.value.assemblyCopy = items[0].assemblyCopy ?? null
                formData.value.assemblyFromVersionId = items[0].assemblyFromVersionId ?? null
            } else {
                resetFormData()
            }
        }

        const breadCumItems = ref([])

        axios.get(`/api/bill-of-material-version/${currentVersionId}`)
            .then((res) => {
                breadCumItems.value.push({
                    text: res.data.data.bomNumber,
                })
            })

        const openBomVersionItem = async (data) => {
            breadCumItems.value.push({
                text: data.item_details.itemCode,
                itemCode: data._id
            })
            await router.push({
                name: 'edit-bill-of-material-version',
                params: {
                    id: currentBomId,
                    versionId: currentVersionId,
                    versionItemId: data._id
                }
            })
            await refetchData(data._id)
                .then(() => resetFormData())
        }

        const getPreviousItems = async (item) => {
            if (item.itemCode) {
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
            } else {
                await axios.get(`/api/bill-of-material-version/${currentVersionId}`)
                    .then((res) => {
                        breadCumItems.value = [{
                            text: res.data.data.bomNumber,
                        }]
                    })
                if (currentVersionItemId) {
                    await router.push({
                        name: 'edit-bill-of-material-version',
                        params: {
                            id: currentBomId,
                            versionId: currentVersionId
                        }
                    })
                }
            }
            await refetchData(item.itemCode)
                .then(() => resetFormData())
        }

        const editBomVersionItem = (data) => {
            formData.value = data
        }

        const deleteBomVersionItem = async (data) => {
            await Swal.fire({
                title: 'Are you sure?',
                text: 'Delete Bill Of Material Version Item',
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
                        store.dispatch('bom-module/deleteBomVersionItem', { id: data._id })
                            .then(res => {
                                if (res.data.status === 200) {
                                    toast({
                                        component: Toastification,
                                        position: 'top-right',
                                        props: {
                                            title: 'BOM Version Item Deleted',
                                            icon: 'CheckSquareIcon',
                                            variant: 'success',
                                            text: 'You have successfully Deleted Bill Of Master Version Item',
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
                        resetFormData()
                    }
                })
        }

        return {
            showOverlayLoading,
            isBusy,
            currentBomId,
            currentVersionId,
            currentVersionItemId,
            bomItemRows,
            bomItemData,
            refetchData,
            openBomVersionItem,
            getPreviousItems,
            formData,
            resetFormData,
            editBomVersionItem,
            deleteBomVersionItem,
            breadCumItems,
            onRowSelected
        }
    }
}
</script>
