<template>
    <div>
        <b-row>
            <b-col md="12">
                <b-table
                    responsive
                    :fields="tableData.fields"
                    :items="tableData.data"
                    ref="table"
                    show-empty
                    bordered
                    hover
                    :busy="isBusy"
                    class="table_scroll"
                    selectable
                    select-mode="single"
                    @row-selected="onRowSelect"
                >
                    <!-- Loader -->
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
                    <template #cell(itemCurrentStock)="data">
                        <span v-if="data.item.itemCurrentStock">{{ data.item.itemCurrentStock }}</span>
                        <span v-else>0</span>
                    </template>

                    <!--Actions-->
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
                            <b-dropdown-item @click="deleteWoRequisitionItem(data.item)">
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
                <hr>
            </b-col>
        </b-row>
        <validation-observer #default="{ handleSubmit }">
            <b-form @submit.prevent="handleSubmit(saveFormData)">
                <b-row>
                    <b-col md="6">
                        <validation-provider
                            #default="validationContext"
                            name="Item Code"
                            rules=""
                        >
                            <b-form-group
                                label="Item Code"
                                label-for="itemCode"
                            >
                                <v-select
                                    placeholder="Select Type"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="itemOptionList"
                                    :reduce="val => val.value"
                                    :clearable="false"
                                    input-id="itemCode"
                                    v-model="formData.itemCode"
                                    :state="getValidationState(validationContext)"
                                    @input="getItemDetails($event)"
                                />
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
                                    id="itemDescription"
                                    v-model="formData.itemDescription"
                                    :state="getValidationState(validationContext)"
                                />
                            </b-form-group>
                        </validation-provider>
                        <validation-provider
                            #default="validationContext"
                            name="Add. Description"
                            rules=""
                        >
                            <b-form-group
                                label="Add. Description"
                                label-for="itemAddDescription"
                            >
                                <b-form-input
                                    id="itemAddDescription"
                                    v-model="formData.itemAddDescription"
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
                                label-for="itemDrawingNumber"
                            >
                                <b-form-input
                                    id="itemDrawingNumber"
                                    v-model="formData.itemDrawingNumber"
                                    :state="getValidationState(validationContext)"
                                />
                            </b-form-group>
                        </validation-provider>
                        <validation-provider
                            #default="validationContext"
                            name="Drawing Revision"
                            rules=""
                        >
                            <b-form-group
                                label="Drawing Revision"
                                label-for="itemDrawingRevision"
                            >
                                <b-form-input
                                    id="itemDrawingRevision"
                                    v-model="formData.itemDrawingRevision"
                                    :state="getValidationState(validationContext)"
                                />
                            </b-form-group>
                        </validation-provider>
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
                                    :reduce="val => val.label"
                                    :clearable="false"
                                    input-id="uom"
                                    v-model="formData.itemUom"
                                    :state="getValidationState(validationContext)"
                                />
                            </b-form-group>
                        </validation-provider>
                        <validation-provider
                            #default="validationContext"
                            name="Conv. UOM"
                            rules=""
                        >
                            <b-form-group
                                label="Conv. UOM"
                                label-for="convUom"
                            >
                                <v-select
                                    placeholder="Select UOM"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="uomOptions"
                                    :reduce="val => val.value"
                                    :clearable="false"
                                    input-id="convUom"
                                    v-model="formData.itemConvUom"
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
                                label-for="itemDetailDescription"
                            >
                                <b-form-textarea
                                    id="itemDetailDescription"
                                    v-model="formData.itemDetailDescription"
                                    rows="3"
                                    :state="getValidationState(validationContext)"
                                />
                            </b-form-group>
                        </validation-provider>
                        <validation-provider
                            #default="validationContext"
                            name="Req Qty"
                            rules=""
                        >
                            <b-form-group
                                label="Req Qty"
                                label-for="itemReqQty"
                            >
                                <b-form-input
                                    id="itemReqQty"
                                    v-model="formData.itemReqQty"
                                    :state="getValidationState(validationContext)"
                                />
                            </b-form-group>
                        </validation-provider>
                        <validation-provider
                            #default="validationContext"
                            name="Req Qty Conv."
                            rules=""
                        >
                            <b-form-group
                                label="Req Qty Conv."
                                label-for="itemReqQtyConv"
                            >
                                <b-form-input
                                    id="itemReqQtyConv"
                                    v-model="formData.itemReqQtyConv"
                                    :state="getValidationState(validationContext)"
                                />
                            </b-form-group>
                        </validation-provider>
                        <validation-provider
                            #default="validationContext"
                            name="Pend Qty"
                            rules=""
                        >
                            <b-form-group
                                label="Pend Qty"
                                label-for="itemPendingQty"
                            >
                                <b-form-input
                                    id="itemPendingQty"
                                    v-model="formData.itemPendingQty"
                                    :state="getValidationState(validationContext)"
                                />
                            </b-form-group>
                        </validation-provider>
                        <validation-provider
                            #default="validationContext"
                            name="Current Stock"
                            rules=""
                        >
                            <b-form-group
                                label="Current Stock"
                                label-for="itemCurrentStock"
                            >
                                <b-form-input
                                    id="itemCurrentStock"
                                    v-model="formData.itemCurrentStock"
                                    :state="getValidationState(validationContext)"
                                />
                            </b-form-group>
                        </validation-provider>
                        <validation-provider
                            #default="validationContext"
                            name="C Factor"
                            rules=""
                        >
                            <b-form-group
                                label="C Factor"
                                label-for="itemCfactor"
                            >
                                <b-form-input
                                    id="itemCfactor"
                                    v-model="formData.itemCfactor"
                                    :state="getValidationState(validationContext)"
                                />
                            </b-form-group>
                        </validation-provider>
                        <validation-provider
                            #default="validationContext"
                            name="Conv Qty"
                            rules=""
                        >
                            <b-form-group
                                label="Conv Qty"
                                label-for="itemConvQty"
                            >
                                <b-form-input
                                    id="itemConvQty"
                                    v-model="formData.itemConvQty"
                                    :state="getValidationState(validationContext)"
                                />
                            </b-form-group>
                        </validation-provider>
                        <div v-if="currentReqType === 2">
                            <b-form-group
                                label="Work Order"
                                label-for="workOrder"
                            >
                                <v-select
                                    id="workOrder"
                                    v-model="formData.itemWorkOrderId"
                                    placeholder="Select Work Order"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="workOrderOptions"
                                    :reduce="val => val.value"
                                    :clearable="true"
                                    input-id="workOrder"
                                />
                            </b-form-group>
                        </div>
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
    BDropdown,
    BDropdownItem,
} from 'bootstrap-vue'
import { required } from '@validations'
import Ripple from 'vue-ripple-directive'
import vSelect from 'vue-select'
import store from '@/store'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
import { ValidationProvider, ValidationObserver } from 'vee-validate'
import formValidation from '@core/comp-functions/forms/form-validation'
import { ref, computed } from '@vue/composition-api'
import axios from '@axios'
import { useToast } from 'vue-toastification/composition'
import router from '@/router'
import Toastification from '@core/components/toastification/ToastificationContent.vue'
import Swal from 'sweetalert2'

export default {
    components: {
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
        BDropdown,
        BDropdownItem,
        vSelect
    },
    directives: {
        Ripple,
    },
    props: {
        reqType: {
            required: true
        }
    },
    setup(props) {
        const isBusy = ref(false)

        const toast = useToast()

        const currentReqType = computed(() => props.reqType)

        const itemOptionList = ref([])
        axios.get('/api/get-item-master-options')
            .then(res => {
                itemOptionList.value = res.data.data
            })

        const uomOptions = ref([])
        axios.get('/api/get-uom-master-options')
            .then(res => {
                uomOptions.value = res.data.data
            })

        const workOrderOptions = ref([])
        axios.get('/api/get-work-order-option').then(res => {
            workOrderOptions.value = res.data.data
        })

        const tableData = ref({
            fields: [
                {
                    key: 'rowSelected',
                    label: ''
                },
                {
                    key: 'index',
                    label: 'No'
                },
                {
                    key: 'item_name.itemCode',
                    label: 'Item Code'
                },
                {
                    key: 'itemDescription',
                    label: 'Item Description'
                },
                {
                    key: 'itemDrawingNumber',
                    label: 'Drawing No'
                },
                {
                    key: 'itemDrawingRevision',
                    label: 'Rev'
                },
                {
                    key: 'itemUom',
                    label: 'uom'
                },
                {
                    key: 'itemReqQty',
                    label: 'Qty'
                },
                {
                    key: 'itemPendingQty',
                    label: 'Pend Qty'
                },
                {
                    key: 'itemCurrentStock',
                    label: 'Current Stock'
                },
                {
                    key: 'action',
                    label: 'Action'
                },
            ],
            data: [],
        })

        const blankFormData = {
            id: null,
            woRequitionId: router.currentRoute.params.id,
            itemCode: null,
            itemDescription: null,
            itemAddDescription: null,
            itemDrawingNumber: null,
            itemDrawingRevision: null,
            itemUom: null,
            itemConvUom: null,
            itemDetailDescription: null,
            itemReqQty: 0,
            itemReqQtyConv: 0,
            itemPendingQty: 0,
            itemCfactor: 0,
            itemCurrentStock: 0,
            itemConvQty: 0,
            itemWorkOrderId: null,
        }

        const formData = ref(JSON.parse(JSON.stringify(blankFormData)))

        const resetFormData = () => {
            formData.value = JSON.parse(JSON.stringify(blankFormData))
        }

        const onRowSelect = (items) => {
            if (items.length > 0) {
                formData.value.id = items[0]._id
                formData.value.itemCode = items[0].itemCode ?? null
                formData.value.itemDescription = items[0].itemDescription ?? null
                formData.value.itemAddDescription = items[0].itemAddDescription ?? null
                formData.value.itemDrawingNumber = items[0].itemDrawingNumber ?? null
                formData.value.itemDrawingRevision = items[0].itemDrawingRevision ?? null
                formData.value.itemUom = items[0].itemUom ?? null
                formData.value.itemConvUom = items[0].itemConvUom ?? null
                formData.value.itemDetailDescription = items[0].itemDetailDescription ?? null
                formData.value.itemReqQty = items[0].itemReqQty ?? null
                formData.value.itemReqQtyConv = items[0].itemReqQtyConv ?? null
                formData.value.itemPendingQty = items[0].itemPendingQty ?? null
                formData.value.itemCfactor = items[0].itemCfactor ?? null
                formData.value.itemCurrentStock = items[0].itemCurrentStock ?? null
                formData.value.itemConvQty = items[0].itemConvQty ?? null
                formData.value.itemWorkOrderId = items[0].itemWorkOrderId ?? null
            } else {
                resetFormData()
            }
        }

        const refetchData = async () => {
            isBusy.value = true
            await axios.get('/api/get-wo-requisition-items/'.concat(router.currentRoute.params.id))
                .then(res => {
                    tableData.value.data = res.data.data
                })
            isBusy.value = false
        }
        refetchData()

        const getItemDetails = async (id) => {
            await axios.get('/api/item-master/'.concat(id))
                .then(res => {
                    formData.value.itemDescription = res.data.data.itemDescription ?? null
                    formData.value.itemAddDescription = res.data.data.itemDetails.description ?? null
                    formData.value.itemDrawingNumber = res.data.data.itemDetails.drawingNumber ?? null
                    formData.value.itemDrawingRevision = res.data.data.itemDetails.revision ?? null
                    formData.value.itemUom = res.data.data.uom_details.uom ?? null
                    formData.value.itemConvUom = res.data.data.convUom ?? null
                    formData.value.itemDetailDescription = res.data.data.itemDetails.detailDescription ?? null
                    formData.value.itemCfactor = res.data.data.cFactor ?? null
                    formData.value.itemConvQty = res.data.data.convQty ?? null
                })
        }

        const deleteWoRequisitionItem = async (data) => {
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
                        store.dispatch('production-planning/deleteWorkOrderRequisitionItem', { id: data._id })
                            .then(res => {
                                if (res.status === 200) {
                                    toast({
                                        component: Toastification,
                                        position: 'top-right',
                                        props: {
                                            title: 'Work Order Requision Item Deleted',
                                            icon: 'CheckSquareIcon',
                                            variant: 'success',
                                            text: 'You have successfully Deleted Work Order Requision Item',
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
                        refetchData()
                    }
                })
        }

        const saveFormData = async () => {
            if (formData.value.id === null) {
                await store.dispatch('production-planning/addWorkOrderRequisitionItem', formData.value)
                    .then(res => {
                        if (res.status === 200) {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Work Order Requisition Item Added',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: `You have successfully Added Work Order Requisition Item.`,
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
            } else {
                await store.dispatch('production-planning/updateWorkOrderRequisitionItem', formData.value)
                    .then(res => {
                        if (res.status === 200) {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Work Order Requisition Item Updated',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: `You have successfully Updated Work Order Requisition Item.`,
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
            resetFormData()
            await refetchData()
        }

        const {
            refFormObserver,
            getValidationState,
            resetForm
        } = formValidation(resetFormData)

        return {
            isBusy,
            currentReqType,
            tableData,
            refetchData,
            formData,
            resetFormData,
            itemOptionList,
            uomOptions,
            workOrderOptions,
            getItemDetails,
            deleteWoRequisitionItem,
            saveFormData,

            refFormObserver,
            getValidationState,
            resetForm,
            onRowSelect
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
