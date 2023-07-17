<template>
    <div>
        <!-- Table -->
        <b-row>
            <b-col md="12">
                <b-table
                    :fields="tableFields"
                    :items="tableData"
                    responsive
                    class="mb-0"
                    bordered
                    hover
                    show-empty
                    :busy="isBusy"
                    selectable
                    select-mode="single"
                    @row-selected="onRowSelected"
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
                            <b-dropdown-item @click="deletePurchaseOrderPoHistory(data.item._id)">
                                <feather-icon
                                    icon="TrashIcon"
                                    class="mr-50"
                                />
                                <span>Delete</span>
                            </b-dropdown-item>
                        </b-dropdown>
                    </template>

                    <!--  select row  -->
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
                    <b-col md="12">
                        <validation-provider
                            #default="validationContext"
                            name="PO Date"
                            rules=""
                        >
                            <b-form-group
                                label="PO. Date"
                                label-for="poDate"
                                :state="getValidationState(validationContext)"
                            >
                                <b-input-group>
                                    <b-input-group-prepend>
                                        <b-form-datepicker
                                            v-model="formatDates.poDate"
                                            button-only
                                            @input="getPoItemFormateDate($event)"
                                            show-decade-nav
                                            size="sm"
                                            nav-button-variant="primary"
                                            disabled
                                        />
                                    </b-input-group-prepend>
                                    <cleave
                                        id="itemDeliveryDate"
                                        v-model="formData.poDate"
                                        class="form-control"
                                        :raw="false"
                                        :options="dateFormat"
                                        placeholder="DD/MM/YYYY"
                                        show-decade-nav
                                        disabled
                                    />
                                </b-input-group>
                            </b-form-group>
                            <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </validation-provider>
                        <b-form-group
                            label="History"
                            label-for="poHistory"
                        >
                            <b-form-textarea
                                id="poHistory"
                                v-model="formData.poHistory"
                            />
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
    BFormDatepicker,
    BFormTextarea,
    BButton,
    BTable,
    BSpinner,
    BDropdown,
    BDropdownItem,
    BInputGroupAppend,
    BInputGroupPrepend,
    BInputGroup,
    BFormInvalidFeedback,
} from 'bootstrap-vue'
import { ref } from '@vue/composition-api'
import Cleave from 'vue-cleave-component'
import { forMatIndianDate } from '@core/utils/utils'
import purchaseStoreModule from '../../purchaseStoreModule'
import { onUnmounted } from '@vue/composition-api/dist/vue-composition-api'
import { useToast } from 'vue-toastification/composition'
import store from '@/store'
import ToastificationContent from '@core/components/toastification/ToastificationContent'
import axios from '@axios'
import router from '@/router'
import Swal from 'sweetalert2'
import formValidation from '@core/comp-functions/forms/form-validation'
import { ValidationObserver, ValidationProvider } from 'vee-validate'

export default {
    components: {
        BForm,
        BRow,
        BCol,
        BFormGroup,
        BFormDatepicker,
        BFormTextarea,
        BButton,
        BTable,
        BSpinner,
        BDropdown,
        BDropdownItem,
        Cleave,
        BInputGroupAppend,
        BInputGroupPrepend,
        BInputGroup,
        ValidationObserver,
        ValidationProvider,
        BFormInvalidFeedback,
    },
    setup() {
        const ITEMADDON_APP_STORE_MODULE_NAME = 'purchase-store-module'
        if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, purchaseStoreModule)
        onUnmounted(() => {
            if (store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.unregisterModule(ITEMADDON_APP_STORE_MODULE_NAME)
        })
        const toast = useToast()

        const dateFormat = ref({
            date: true,
            delimiter: '/',
            datePattern: ['d', 'm', 'Y'],
        })

        const formatDates = ref({
            poDate: null,
        })

        const getPoItemFormateDate = (date) => {
            formData.value.poDate = forMatIndianDate(date)
        }
        const isBusy = ref(false)

        const tableFields = ref([
            {
                key: 'rowSelected',
                label: ''
            },
            {
                key: 'index',
                label: 'No',
            },
            {
                key: 'poDate',
                label: 'Date'
            },
            {
                key: 'poHistory',
                label: 'History'
            },
            {
                key: 'action',
                label: 'Action'
            },
        ])

        const tableData = ref([])

        const blankFormData = {
            _id: null,
            purchaseOrderId: router.currentRoute.params.id,
            poDate: forMatIndianDate(new Date()),
            poHistory: null,
        }
        const formData = ref(JSON.parse(JSON.stringify(blankFormData)))

        const resetFormData = () => {
            formData.value = JSON.parse(JSON.stringify(blankFormData))
        }

        const onRowSelected = (items) => {
            if (items.length > 0) {
                formData.value._id = items[0]._id
                formData.value.purchaseOrderId = items[0].purchaseOrderId ?? null
                formData.value.poDate = items[0].poDate ?? null
                formData.value.poHistory = items[0].poHistory ?? null
            } else {
                resetFormData()
            }
        }

        const refetchData = async () => {
            isBusy.value = true
            await axios.get(`/api/new/get-po-history/${router.currentRoute.params.id}`)
                .then(res => {
                    tableData.value = res.data.data
                })
            isBusy.value = false
        }
        refetchData()

        const deletePurchaseOrderPoHistory = async (id) => {
            await Swal.fire({
                title: 'Are you sure?',
                text: 'Delete this item',
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
                        store.dispatch('purchase-store-module/deletePurchaseOrderPoHistory', { id: id })
                            .then((res) => {
                                if (res.status === 200) {
                                    toast({
                                        component: ToastificationContent,
                                        position: 'top-right',
                                        props: {
                                            title: 'Purchase Order PO History Deleted',
                                            icon: 'CheckSquareIcon',
                                            variant: 'success',
                                            text: 'You have successfully Deleted Purchase Order PO History',
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
                        refetchData()
                    }
                })
        }
        const saveFormData = async () => {
            if (formData.value._id === null) {
                await store.dispatch('purchase-store-module/addPurchaseOrderPoHistory', formData.value)
                    .then(res => {
                        if (res.status === 200) {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Purchase Order PO History Added',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: `You have successfully Added Purchase Order PO History.`,
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
                await store.dispatch('purchase-store-module/updatePurchaseOrderPoHistory', formData.value)
                    .then((res) => {
                        if (res.status === 200) {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Purchase Order PO History Updated',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: 'You have successfully Updated Purchase Order PO History',
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
            resetFormData()
            await refetchData()
        }
        const {
            refFormObserver,
            getValidationState,
            resetForm
        } = formValidation(resetFormData)

        return {
            resetFormData,
            refFormObserver,
            getValidationState,
            resetForm,
            formData,
            refetchData,
            isBusy,
            saveFormData,
            tableFields,
            tableData,
            getPoItemFormateDate,
            dateFormat,
            formatDates,
            deletePurchaseOrderPoHistory,
            onRowSelected
        }
    }
}
</script>

