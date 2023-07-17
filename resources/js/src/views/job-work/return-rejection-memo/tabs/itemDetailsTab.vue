<template>
    <div>
        <!--table -->
        <b-row>
            <b-col md="12">
                <b-table
                    :fields="itemsField"
                    :items="itemsData"
                    responsive
                    class="mb-0"
                    bordered
                    hover
                    show-empty
                    :busy="isBusy"
                >
                    <!-- Loader -->
                    <template #table-busy>
                        <div class="text-center my-2">
                            <b-spinner class="align-middle"></b-spinner>
                            <strong>Loading...</strong>
                        </div>
                    </template>

                    <!-- A virtual column -->
                    <template #cell(index)="data">
                        {{ data.index + 1 }}
                    </template>

                    <!-- Action -->
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
                            <b-dropdown-item @click="editItem(data.item)">
                                <feather-icon
                                    icon="Edit2Icon"
                                    class="mr-50"
                                />
                                <span>Edit</span>
                            </b-dropdown-item>
                            <b-dropdown-item @click="deleteItemDetails(data.item._id)">
                                <feather-icon
                                    icon="TrashIcon"
                                    class="mr-50"
                                />
                                <span>Delete</span>
                            </b-dropdown-item>
                        </b-dropdown>
                    </template>
                </b-table>
                <hr>
            </b-col>
        </b-row>
        <!--table Close-->
        <validation-observer #default="{ handleSubmit }">
            <b-form @submit.prevent="handleSubmit(saveFormData)">
                <b-row>
                    <b-col md="6">
                        <validation-provider
                            #default="validationContext"
                            name="Item Code"
                            rules="required"
                        >
                            <b-form-group
                                label="Item Code"
                                label-for="itemCode"
                                :state="getValidationState(validationContext)"
                            >
                                <v-select
                                    placeholder="Select Item"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="itemListOptions"
                                    :reduce="val => val.value"
                                    :clearable="false"
                                    input-id="itemList"
                                    v-model="formData.itemCode"
                                    @input="getItemDetails($event)"
                                    :state="getValidationState(validationContext)"
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
                                :state="getValidationState(validationContext)"
                            >
                                <b-form-input
                                    v-model="formData.itemDescription"
                                    id="itemDescription"
                                    :state="getValidationState(validationContext)"
                                    readonly
                                />
                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                        <b-form-group
                            label="Add. Description"
                            label-for="addDescription"
                        >
                            <b-form-input
                                id="addDescription"
                                v-model="formData.itemAddDescription"
                            />
                        </b-form-group>
                        <b-form-group
                            label="Detail Description"
                            label-for="detailDescription"
                        >
                            <b-form-textarea
                                v-model="formData.itemDetailDescription"
                                id="detailDescription"
                                rows="2"
                            />
                        </b-form-group>
                        <b-row>
                            <b-col md="6">
                                <b-form-group
                                    label="Drawing Number"
                                    label-for="itemDrawingNumber"
                                >
                                    <b-form-input
                                        v-model="formData.itemDrawingNumber"
                                        id="itemDrawingNumber"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Drawing Revision"
                                    label-for="itemDrawingRevision"
                                >
                                    <b-form-input
                                        v-model="formData.itemDrawingRevision"
                                        id="itemDrawingRevision"
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-form-group
                            label="UOM"
                            label-for="itemUom"
                        >
                            <v-select
                                placeholder="Select UOm"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="uomOptions"
                                :clearable="false"
                                input-id="salesFrom"
                                :reduce="val => val.value"
                                v-model="formData.itemUom"
                            />
                        </b-form-group>
                        <b-form-group
                            label="Process"
                            label-for="itemProcess"
                        >
                            <v-select
                                v-model="formData.itemProcess"
                                placeholder="Select Process"
                                :dir="$store.state.appConfig.isRTl ? 'rtl' : 'ltr'"
                                :options="processOption"
                                :reduce="val => val.value"
                                :clearable="false"
                                input-id="itemProcess"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="6">
                        <b-form-group
                            label="Item Note"
                            label-for="itemNote"
                        >
                            <b-form-input
                                id="itemNote"
                                v-model="formData.itemNote"
                            />
                        </b-form-group>
                        <b-row>
                            <b-col md="6">
                                <b-form-group
                                    label="GIR No"
                                    label-for="itemGirNo"
                                >
                                    <b-form-input
                                        id="itemGirNo"
                                        v-model="formData.itemGirNo"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="GIR Date"
                                    label-for="itemGirDate"
                                >
                                    <b-input-group>
                                        <b-input-group-prepend>
                                            <b-form-datepicker
                                                v-model="formatDates.itemGirDate"
                                                button-only
                                                @input="getRejectionMemoItemFormateDate($event)"
                                                show-decade-nav
                                                size="sm"
                                                nav-button-variant="primary"
                                            />
                                        </b-input-group-prepend>
                                        <cleave
                                            id="itemGirDate"
                                            v-model="formData.itemGirDate"
                                            class="form-control"
                                            :raw="false"
                                            :options="dateFormat"
                                            placeholder="DD/MM/YYYY"
                                            show-decade-nav
                                        />
                                    </b-input-group>
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="6">
                                <b-form-group
                                    label="Quantity"
                                    label-for="itemQuantity"
                                >
                                    <b-form-input
                                        id="itemQuantity"
                                        v-model="formData.itemQuantity"
                                        @keyup="itemCalculation"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Rate"
                                    label-for="itemRate"
                                >
                                    <b-form-input
                                        id="itemRate"
                                        v-model="formData.itemRate"
                                        @keyup="itemCalculation"
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="12">
                                <b-form-group
                                    label="Amount"
                                    label-for="itemAmount"
                                >
                                    <b-form-input
                                        id="itemAmount"
                                        v-model="formData.itemAmount"
                                        readonly
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="12">
                                <b-form-group
                                    label="Reasons"
                                    label-for="itemReasons"
                                >
                                    <b-form-textarea
                                        id="itemReasons"
                                        v-model="formData.itemReasons"
                                        rows="2"
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="12">
                                <hr>
                                <h5>Rejection Item</h5>
                                <hr>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="6">
                                <b-form-group
                                    label="Reject Item Code"
                                    label-for="rejectionItemCode"
                                >
                                    <v-select
                                        v-model="formData.rejectionItemCode"
                                        placeholder="Select Rject Code"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="rejectItemCodeOPtion"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        @input="rejectItemOption($event)"
                                        input-id="rejectionItemCode"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label=" Reject Item Description"
                                    label-for="rejectItemDescription"
                                >
                                    <b-form-input
                                        v-model="formData.rejectItemDescription"
                                        id="rejectItemDescription"
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-form-group
                            label=" Reject Item Rete"
                            label-for="rejectItemRate"
                        >
                            <b-form-input
                                v-model="formData.rejectItemRate"
                                id="rejectItemRate"
                            />
                        </b-form-group>
                    </b-col>
                    <!--Button-->
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

    </div>
</template>
<script>
import {
    BForm,
    BRow,
    BCol,
    BFormGroup,
    BFormInput,
    BFormInvalidFeedback,
    BTable,
    BSpinner,
    BDropdown,
    BDropdownItem,
    BFormTextarea,
    BFormDatepicker,
    BButton,
    BInputGroup,
    BInputGroupAppend,
    BInputGroupPrepend
} from 'bootstrap-vue'
import { ref } from '@vue/composition-api'
import { ValidationObserver, ValidationProvider } from 'vee-validate'
import { required } from '@validations'
import vSelect from 'vue-select'
import axios from '@axios'
import formValidation from '@core/comp-functions/forms/form-validation'
import { useToast } from 'vue-toastification/composition'
import jobWorkStoreModule from '../../jobWorkStoreModule'
import router from '@/router'
import store from '@/store'
import Toastification from '@core/components/toastification/ToastificationContent.vue'
import { forMatIndianDate, getTcTodayDate } from '@core/utils/utils'
import Swal from 'sweetalert2'
import Cleave from 'vue-cleave-component'

export default {
    components: {
        ValidationObserver,
        ValidationProvider,
        BForm,
        BRow,
        BCol,
        BFormGroup,
        BFormInput,
        BFormInvalidFeedback,
        BTable,
        BSpinner,
        BDropdown,
        BDropdownItem,
        vSelect,
        BFormTextarea,
        BFormDatepicker,
        BButton,
        BInputGroup,
        BInputGroupAppend,
        BInputGroupPrepend,
        Cleave
    },
    setup({ jobWorkProcessModal }) {
        jobWorkProcessModal = ref()
        const toast = useToast()

        const ITEMADDON_APP_STORE_MODULE_NAME = 'item-rejection-memo-store-module'

        if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, jobWorkStoreModule)

        const itemListOptions = ref([])
        axios.get('/api/new/get-jobWork-challan-item-options')
            .then(res => {
                itemListOptions.value = res.data.data
            })
        const uomOptions = ref([])
        axios.get('/api/get-uom-master-options')
            .then(res => {
                uomOptions.value = res.data?.data
            })
        const processOption = ref([])
        axios.get('/api/get-process-master-option')
            .then(res => {
                processOption.value = res.data.data
            })
        const rejectItemCodeOPtion = ref([])
        axios.get('/api/get-item-job-order-option')
            .then(res => {
                rejectItemCodeOPtion.value = res.data.data
            })

        const dateFormat = ref({
            date: true,
            delimiter: '/',
            datePattern: ['d', 'm', 'Y'],
        })

        const formatDates = ref({
            itemGirDate: null,
        })

        const getRejectionMemoItemFormateDate = (date) => {
            formData.value.itemGirDate = forMatIndianDate(date)
        }

        const isBusy = ref(false)
        const itemsField = ref([
            {
                key: 'index',
                label: 'No',
            },
            {
                key: 'issue_item.itemCode',
                label: 'Item Code',
            },
            {
                key: 'itemDescription',
                label: 'Description',
            },
            {
                key: 'itemDescription',
                label: 'Description',
            },
            {
                key: 'uom_details.uom',
                label: 'UOM',
            },
            {
                key: 'itemQuantity',
                label: 'Quantity',
            },
            {
                key: 'itemRate',
                label: 'Rate',
            },
            {
                key: 'itemAmount',
                label: 'Amount',
            },
            {
                key: 'action',
                label: 'Action',
            },
        ])
        const itemsData = ref([])

        const rejectItemOption = async (id) => {
            await axios.get(`/api/job-work-order-item/${id}`)
                .then(res => {
                    formData.value.rejectItemDescription = res.data.data?.itemDescription ?? null
                })
        }

        const getItemDetails = async (id) => {
            await axios.get(`/api/issue-job-work-challan-item/${id}`)
                .then(res => {
                    formData.value.issueJobWorkChallanId = res.data.data?._id ?? null
                    formData.value.itemId = res.data.data?.itemId ?? null
                    formData.value.showIssueItemId = res.data.data?.showIssueItemId ?? null
                    formData.value.jobCardId = res.data.data?.jobCardId ?? null
                    formData.value.itemDescription = res.data.data?.itemDescription ?? null
                    formData.value.itemAddDescription = res.data.data?.itemAddDescription ?? null
                    formData.value.itemDetailDescription = res.data.data?.itemDetailDescription ?? null
                    formData.value.itemDrawingNumber = res.data.data?.itemDrawingNumber ?? null
                    formData.value.itemDrawingRevision = res.data.data?.itemDrawingRevision ?? null
                    formData.value.itemUom = res.data.data?.itemUom ?? null
                    formData.value.itemQuantity = res.data.data?.itemQuntity ?? null
                })
        }

        const blankFormData = {
            _id: null,
            memoId: router.currentRoute.params.id,
            issueJobWorkChallanId:null,
            itemId:null,
            showIssueItemId:null,
            jobCardId:null,
            itemCode: null,
            itemDescription: null,
            itemAddDescription: null,
            itemDetailDescription: null,
            itemDrawingNumber: null,
            itemDrawingRevision: null,
            itemUom: null,
            itemProcess: null,
            itemNote: null,
            itemGirNo: null,
            itemGirDate: getTcTodayDate(),
            itemQuantity: 0,
            itemRate: 0,
            itemAmount: 0,
            itemReasons: null,
            rejectionItemCode: null,
            rejectItemDescription: null,
            rejectItemRate: null,
        }

        const refetchData = async () => {
            isBusy.value = true
            await axios.get(`/api/new/get-rejection-memo-item/${router.currentRoute.params.id}`)
                .then(res => {
                    itemsData.value = res.data.data
                })
            isBusy.value = false
        }
        refetchData()

        const editItem = (data) => {
            formData.value = data
        }

        const formData = ref(JSON.parse(JSON.stringify(blankFormData)))

        const resetFormData = () => {
            formData.value = JSON.parse(JSON.stringify(blankFormData))
        }

        const deleteItemDetails = async (id) => {
            await Swal.fire({
                title: 'Are you sure?',
                text: 'Delete Return Rejection Memo',
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
                        store.dispatch('item-rejection-memo-store-module/deleteRejectionMemoItemDetail', { id: id })
                            .then(res => {
                                if (res.status === 200) {
                                    toast({
                                        component: Toastification,
                                        position: 'top-right',
                                        props: {
                                            title: 'Return Rejection Memo Item Deleted',
                                            icon: 'CheckSquareIcon',
                                            variant: 'success',
                                            text: 'You have successfully Deleted Return Rejection Memo Item.',
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
            if (formData.value._id === null) {
                await store.dispatch('item-rejection-memo-store-module/addRejectionMemoItemDetail', formData.value)
                    .then(res => {
                        if (res.status === 200) {
                            toast({
                                component: Toastification,
                                position: 'top-right',
                                props: {
                                    title: 'Return Rejection Memo Item Added',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: 'You have successfully Added Return Rejection Memo Costing Item.',
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
            } else {
                await store.dispatch('item-rejection-memo-store-module/updateRejectionMemoItemDetail', formData.value)
                    .then(res => {
                        if (res.status === 200) {
                            toast({
                                component: Toastification,
                                position: 'top-right',
                                props: {
                                    title: 'Return Rejection Memo Item Update',
                                    icon: 'CheckSquareIcon',
                                    variant: 'Success',
                                    text: 'You Have successfully Updated Return Rejection Memo Item.',
                                },
                            })
                        } else {
                            toast({
                                component: Toastification,
                                position: 'top-right',
                                props: {
                                    title: 'Something Went Wrong',
                                    position: 'AlertCircleIcon',
                                    variant: 'Success',
                                    text: 'Something Want Wrong',
                                },
                            })
                        }
                    })
            }
            resetFormData()
            await refetchData()
        }

        const itemCalculation = () => {
            formData.value.itemAmount = parseFloat(formData.value.itemQuantity) * parseFloat(formData.value.itemRate)
        }

        const {
            refFormObserver,
            getValidationState,
            resetForm
        } = formValidation(resetFormData)

        return {
            itemsField,
            itemsData,
            isBusy,
            required,
            formData,
            resetFormData,
            resetForm,
            getValidationState,
            refFormObserver,
            saveFormData,
            processOption,
            rejectItemCodeOPtion,
            uomOptions,
            getItemDetails,
            rejectItemOption,
            refetchData,
            editItem,
            deleteItemDetails,
            dateFormat,
            formatDates,
            getRejectionMemoItemFormateDate,
            itemListOptions,
            itemCalculation
        }
    }
}
</script>
