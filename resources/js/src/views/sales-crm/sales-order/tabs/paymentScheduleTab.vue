<template>
    <div>
        <b-row>
            <b-col md="12">
                <hr>
                <b-button
                    type="button"
                    variant="outline-primary"
                    @click="getTotalAmount"
                >
                    Refresh Amount
                </b-button>
                <hr>
                <b-row>
                    <b-col md="4">
                        <b-form-group
                            label="So. Amount"
                            label-for="soAmount"
                        >
                            <b-form-input
                                id="soAmount"
                                disabled
                                v-model="displayData.soAmount"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="4">
                        <b-form-group
                            label="Total Amt."
                            label-for="totalAmount"
                        >
                            <b-form-input
                                id="totalAmount"
                                disabled
                                v-model="displayData.totalAmount"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="4">
                        <b-form-group
                            label="Total Pend. Amt."
                            label-for="totalPendingAmount"
                        >
                            <b-form-input
                                id="totalPendingAmount"
                                disabled
                                v-model="displayData.totalPendingAmount"
                            />
                        </b-form-group>
                    </b-col>
                </b-row>
                <hr>
                <b-table
                    :fields="tableData.fields"
                    :items="tableData.rows"
                    :bordered="true"
                    :hover="true"
                    show-empty
                    responsive
                    class="mb-0 table_scroll"
                    selectable
                    select-mode="single"
                    @row-selected="onRowSelected"
                >
                    <!-- Empty Fields -->
                    <template #empty="scope">
                        <h5 class="text-center text-uppercase">No Sales Order Payment Schedule Available</h5>
                    </template>
                    <!-- Serial Number -->
                    <template #cell(index)="data">
                        {{ data.index + 1 }}
                    </template>
                    <template #cell(status)="data">
                        <span v-if="data.item.status === 1">Pending</span>
                        <span v-else-if="data.item.status === 2">Complete</span>
                        <span v-else></span>
                    </template>
                    <template #cell(action)="data">
                <span>
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
                      <b-dropdown-item @click="deletePaymentSchedule(data.item._id)">
                        <feather-icon
                            icon="TrashIcon"
                            class="mr-50"
                        />
                        <span>Delete</span>
                      </b-dropdown-item>
                    </b-dropdown>
                </span>
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
            <b-col md="12">
                <hr>
                <b-form @submit.prevent="submitForm">
                    <b-row>
                        <b-col md="6">
                            <b-form-group
                                label="Payment (%)"
                                label-for="payment"
                            >
                                <b-form-input
                                    id="payment"
                                    type="number"
                                    v-model="formData.payment"
                                    @keyup="calculateAmount"
                                />
                            </b-form-group>
                            <b-form-group
                                label="Due Date"
                                label-for="dueDate"
                            >
                                <!--<b-form-datepicker
                                    id="dueDate"
                                    :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }"
                                    locale="in"
                                    class="mb-1"
                                    v-model="formData.dueDate"
                                />-->
                                <b-input-group>
                                    <b-input-group-prepend>
                                        <b-form-datepicker
                                            v-model="formatDates.dueDate"
                                            button-only
                                            @input="getDueFormatDate($event)"
                                            show-decade-nav
                                            size="sm"
                                            nav-button-variant="primary"
                                        />
                                    </b-input-group-prepend>
                                    <cleave
                                        id="invoiceDate"
                                        v-model="formData.dueDate"
                                        class="form-control"
                                        :raw="false"
                                        :options="dateFormat"
                                        placeholder="DD/MM/YYYY"
                                        show-decade-nav
                                    />
                                </b-input-group>
                            </b-form-group>
                            <b-form-group
                                label="Days"
                                label-for="days"
                            >
                                <b-form-input
                                    id="days"
                                    type="number"
                                    v-model="formData.days"
                                />
                            </b-form-group>
                            <b-form-group
                                label="Exp. Date"
                                label-for="expDate"
                            >
                                <!--<b-form-datepicker
                                    id="expDate"
                                    :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }"
                                    locale="in"
                                    class="mb-1"
                                    v-model="formData.expDate"
                                />-->
                                <b-input-group>
                                    <b-input-group-prepend>
                                        <b-form-datepicker
                                            v-model="formatDates.expDate"
                                            button-only
                                            @input="getExpFormatDate($event)"
                                            show-decade-nav
                                            size="sm"
                                            nav-button-variant="primary"
                                        />
                                    </b-input-group-prepend>
                                    <cleave
                                        id="expDate"
                                        v-model="formData.expDate"
                                        class="form-control"
                                        :raw="false"
                                        :options="dateFormat"
                                        placeholder="DD/MM/YYYY"
                                        show-decade-nav
                                    />
                                </b-input-group>
                            </b-form-group>
                        </b-col>
                        <b-col md="6">
                            <b-form-group
                                label="Amt."
                                label-for="amount"
                            >
                                <b-form-input
                                    id="amount"
                                    type="number"
                                    v-model="formData.amount"
                                    readonly
                                />
                            </b-form-group>
                            <b-form-group
                                label="Pend. Amt."
                                label-for="pendingAmount"
                            >
                                <b-form-input
                                    id="pendingAmount"
                                    type="number"
                                    v-model="formData.pendingAmount"
                                    readonly
                                />
                            </b-form-group>
                            <b-form-group
                                label="Status"
                                label-for="status"
                            >
                                <v-select
                                    placeholder="Select Status"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="statusOptions"
                                    :reduce="val => val.value"
                                    :clearable="false"
                                    input-id="status"
                                    v-model="formData.status"
                                />
                            </b-form-group>
                        </b-col>
                    </b-row>
                    <hr>
                    <b-button
                        variant="primary"
                        type="submit"
                    >
                        {{ buttonText }}
                    </b-button>
                </b-form>
            </b-col>
        </b-row>
    </div>
</template>
<script>
    import BCardCode from '@core/components/b-card-code'
    import {ValidationProvider, ValidationObserver} from 'vee-validate'
    import {
        BRow,
        BCol,
        BFormGroup,
        BFormInput,
        BFormTextarea,
        BForm,
        BButton,
        BFormDatepicker,
        BOverlay,
        BTab,
        BTabs,
        BTable,
        BSpinner,
        BFormInvalidFeedback,
        BDropdown,
        BDropdownItem,
        BInputGroup,
        BInputGroupAppend,
        BInputGroupPrepend
    } from 'bootstrap-vue'
    import {required, numeric} from '@validations'
    import Ripple from 'vue-ripple-directive'
    import vSelect from 'vue-select'
    import router from '@/router'
    import store from '@/store'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import {ref, watch, watchEffect, onUnmounted, computed} from '@vue/composition-api'
    import axios from '@axios'
    import Swal from 'sweetalert2'
    import {useToast} from 'vue-toastification/composition'
    import formValidation from '@core/comp-functions/forms/form-validation'
    import salesStoreModule from "../../salesStoreModule";
    import moment from 'moment'
    import Cleave from 'vue-cleave-component';
    import {forMatIndianDate} from "../../../../@core/utils/utils";

    export default {
        components: {
            BCardCode,
            BRow,
            BCol,
            BFormGroup,
            BFormInput,
            BFormTextarea,
            BForm,
            BButton,
            BFormDatepicker,
            BOverlay,
            BTab,
            BTabs,
            BTable,
            BSpinner,
            vSelect,
            ValidationProvider,
            ValidationObserver,
            BFormInvalidFeedback,
            BDropdown,
            BDropdownItem,
            BInputGroup,
            BInputGroupAppend,
            BInputGroupPrepend,
            Cleave,
        },
        directives: {
            Ripple,
        },
        setup() {
            const SO_APP_STORE_MODULE_NAME = 'sales-order-module'
            // Register module
            if (!store.hasModule(SO_APP_STORE_MODULE_NAME)) store.registerModule(SO_APP_STORE_MODULE_NAME, salesStoreModule)
            // UnRegister on leave
            /*onUnmounted(() => {
                if (store.hasModule(SO_APP_STORE_MODULE_NAME)) store.unregisterModule(SO_APP_STORE_MODULE_NAME)
            })*/

            const toast = useToast()

            const tableData = ref({
                fields: [
                    {
                        key: 'rowSelected',
                        label: ''
                    },
                    {
                        key: 'index',
                        label: 'Sr.'
                    },
                    {
                        key: 'payment',
                        label: 'Pay %'
                    },
                    {
                        key: 'amount',
                        label: 'Payment Amount'
                    },
                    {
                        key: 'dueDate',
                        label: 'Due Date',
                        formatter: val => val !== null ? moment(val).format('DD/MM/YYYY') : null
                    },
                    {
                        key: 'days',
                        label: 'Days'
                    },
                    {
                        key: 'expDate',
                        label: 'Exp. Dt.',
                        formatter: val => val !== null ? moment(val).format('DD/MM/YYYY') : null
                    },
                    {
                        key: 'pendingAmount',
                        label: 'Pend. Amt',
                    },
                    {
                        key: 'status',
                        label: 'Status'
                    },
                    {
                        key: 'action',
                        label: 'Action'
                    }
                ],
                rows: []
            })

            const statusOptions = ref([
                {
                    label: 'Pending',
                    value: 1,
                },
                {
                    label: 'Complete',
                    value: 2,
                },
            ])

            const buttonText = ref('Save')

            const formData = ref({
                id: null,
                salesOrderId: router.currentRoute.params.id,
                payment: 0,
                dueDate: null,
                days: null,
                expDate: null,
                amount: null,
                pendingAmount: null,
                status: null,
            })

            const onRowSelected = (items) => {
                if (items.length > 0) {
                    formData.value.id = items[0]._id
                    formData.value.salesOrderId = items[0].salesOrderId
                    formData.value.dueDate = items[0].dueDate ?? null
                    formData.value.days = items[0].days ?? null
                    formData.value.expDate = items[0].expDate ?? null
                    formData.value.amount = items[0].amount ?? null
                    formData.value.pendingAmount = items[0].pendingAmount ?? null
                    formData.value.status = items[0].status ?? null
                    buttonText.value = 'Update'
                } else {
                    formData.value.id = null
                    formData.value.payment = null
                    formData.value.amount = null
                    formData.value.dueDate = null
                    formData.value.days = null
                    formData.value.expDate = null
                    formData.value.amount = null
                    formData.value.pendingAmount = null
                    formData.value.status = null
                }
            }

            const displayData = ref({
                soAmount: null,
                totalAmount: null,
                totalPendingAmount: null,
            })

            const getTotalAmount = async () => {
                await axios.get(`/api/get-sales-order-items-total-amount/${router.currentRoute.params.id}`).then(res => {
                    displayData.value.soAmount = res.data.data.itemNetAmount
                    displayData.value.totalAmount = res.data.data.itemNetAmount
                    displayData.value.totalPendingAmount = res.data.data.totalPendingAmount
                })
            }
            getTotalAmount()

            const fetchData = async () => {
                await axios.get(`/api/get-sales-order-payment-schedule/${router.currentRoute.params.id}`).then(res => {
                    tableData.value.rows = res.data.data
                })
            }
            fetchData()

            const submitForm = async () => {
                if (formData.value.id === null) {
                    await store.dispatch('sales-order-module/addSalesOrderSchedulePayment', formData.value).then(res => {
                        if (res.data.status === 200) {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Sales Order Payment Schedule Saved',
                                    icon: 'ThumbsUpIcon',
                                    variant: 'success',
                                    text: 'Sales Order Payment Schedule Saved Successfully!',
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
                    await store.dispatch('sales-order-module/updateSalesOrderSchedulePayment', formData.value).then(res => {
                        if (res.data.status === 200) {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Sales Order Payment Schedule Updated',
                                    icon: 'ThumbsUpIcon',
                                    variant: 'success',
                                    text: 'Sales Order Payment Schedule Updated Successfully!',
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
                buttonText.value = 'Save'
                formData.value.id = null
                formData.value.payment = null
                formData.value.amount = null
                formData.value.dueDate = null
                formData.value.days = null
                formData.value.expDate = null
                formData.value.amount = null
                formData.value.pendingAmount = null
                formData.value.status = null
                await fetchData()
                await getTotalAmount()
            }

            const deletePaymentSchedule = async (id) => {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Name is already exist",
                    icon: 'warning',
                    showCancelButton: true,
                    showDenyButton: false,
                    confirmButtonText: 'Yes, delete It!',
                    denyButtonText: 'No, Decline!',
                    cancelButtonText: 'Cancel',
                    customClass: {
                        confirmButton: 'btn btn-outline-success',
                        cancelButton: 'btn btn-outline-danger ml-1',
                        denyButton: 'btn btn-outline-warning ml-1',
                    },
                    buttonsStyling: false,
                }).then(result => {
                    if (result.isConfirmed) {
                        store.dispatch('sales-order-module/deleteSalesOrderSchedulePayment', {id: id}).then(res => {
                            if (res.data.status === 200) {
                                toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: 'Sales Order Payment Schedule Deleted',
                                        icon: 'ThumbsUpIcon',
                                        variant: 'success',
                                        text: 'Sales Order Payment Schedule Deleted Successfully!',
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
                        fetchData()
                        getTotalAmount()
                    }
                    if (result.isDismissed) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Cancel',
                                icon: 'AlertCircleIcon',
                                variant: 'danger',
                                text: 'You have abort the task!',
                            },
                        })
                    }
                })
            }

            const calculateAmount = () => {
                formData.value.amount = ((displayData.value.soAmount / 100) * formData.value.payment)
                formData.value.pendingAmount = (displayData.value.soAmount - formData.value.amount)
            }

            const dateFormat = ref({
                date: true,
                delimiter: '/',
                datePattern: ['d', 'm', 'Y'],
            })

            const formatDates = ref({
                dueDate: null,
                expDate: null,
            })

            const getDueFormatDate = (date) => {
                formData.value.dueDate = forMatIndianDate(date)
            }

            const getExpFormatDate = (date) => {
                formData.value.expDate = forMatIndianDate(date)
            }

            return {
                tableData,
                statusOptions,
                buttonText,
                formData,
                displayData,
                fetchData,
                submitForm,
                calculateAmount,
                getTotalAmount,
                deletePaymentSchedule,
                dateFormat,
                formatDates,
                getDueFormatDate,
                getExpFormatDate,
                onRowSelected
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
