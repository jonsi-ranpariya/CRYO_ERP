<template>
    <div>
        <b-row>
            <b-col md="12">
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
                        <h5 class="text-center text-uppercase">No Sales Order History Available</h5>
                    </template>
                    <!-- Serial Number -->
                    <template #cell(index)="data">
                        {{ data.index + 1 }}
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
                          <b-dropdown-item @click="deleteHistory(data.item._id)">
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
                <b-form @submit.prevent="saveFormData">
                    <b-form-group
                        label="Date"
                        label-for="date"
                    >
                        <!--<b-form-datepicker
                            id="date"
                            :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }"
                            locale="in"
                            class="mb-1"
                            v-model="formData.date"
                        />-->
                        <b-input-group>
                            <b-input-group-prepend>
                                <b-form-datepicker
                                    v-model="formatDates.date"
                                    button-only
                                    @input="getFormatDate($event)"
                                    show-decade-nav
                                    size="sm"
                                    nav-button-variant="primary"
                                    disabled
                                />
                            </b-input-group-prepend>
                            <cleave
                                id="invoiceDate"
                                v-model="formData.date"
                                class="form-control"
                                :raw="false"
                                :options="dateFormat"
                                placeholder="DD/MM/YYYY"
                                show-decade-nav
                                disabled
                            />
                        </b-input-group>
                    </b-form-group>
                    <b-form-group
                        label="History"
                        label-for="history"
                    >
                        <b-form-textarea
                            id="history"
                            rows="3"
                            v-model="formData.history"
                        />
                    </b-form-group>
                    <b-form-group
                        label="Created By"
                        label-for="createdBy"
                    >
                        <v-select
                            placeholder="Select Status"
                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                            :options="usersOptions"
                            :reduce="val => val.value"
                            :clearable="false"
                            input-id="status"
                            v-model="formData.createdUser"
                        />
                    </b-form-group>
                    <hr>
                    <b-button
                        variant="primary"
                        type="submit"
                        class="float-right"
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
    import Ripple from 'vue-ripple-directive'
    import vSelect from 'vue-select'
    import router from '@/router'
    import store from '@/store'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import {ref} from '@vue/composition-api'
    import axios from '@axios'
    import Swal from 'sweetalert2'
    import {useToast} from 'vue-toastification/composition'
    import salesStoreModule from "../../salesStoreModule";
    import Cleave from 'vue-cleave-component';
    import {forMatIndianDate} from "@core/utils/utils";
    import { getUserData } from '../../../../auth/utils'

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
            Cleave,
            BInputGroup,
            BInputGroupAppend,
            BInputGroupPrepend
        },
        directives: {
            Ripple,
        },
        setup(){
            const SO_APP_STORE_MODULE_NAME = 'sales-order-module'
            // Register module
            if (!store.hasModule(SO_APP_STORE_MODULE_NAME)) store.registerModule(SO_APP_STORE_MODULE_NAME, salesStoreModule)
            // UnRegister on leave

            const toast = useToast()

            const usersOptions = ref([])

            axios.get('/api/get-users-options').then(res => {
                usersOptions.value = res.data.data
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
                        key: 'date',
                        label: 'Date'
                    },
                    {
                        key: 'history',
                        label: 'History'
                    },
                    {
                        key: 'user_details',
                        label: 'Created By',
                        formatter: val => val !== null ? val.first_name + ' ' + val.last_name : null
                    },
                    {
                        key: 'action',
                        label: 'Action'
                    },
                ],
                rows: []
            })

            const currentUser = getUserData()

            const fetchData = async () => {
                await axios.get(`/api/get-sales-order-history/${router.currentRoute.params.id}`).then(res => {
                    tableData.value.rows = res.data.data
                })
            }
            fetchData()

            const buttonText = ref('Save')

            const formData = ref({
                id:null,
                salesOrderId: router.currentRoute.params.id,
                date: forMatIndianDate(new Date()),
                history: null,
                createdUser: currentUser._id,
            })

            const onRowSelected = (items) => {
                if (items.length > 0) {
                    buttonText.value = 'Update'
                    formData.value.id = items[0]._id
                    formData.value.salesOrderId = items[0].salesOrderId
                    formData.value.date = items[0].date ?? null
                    formData.value.history = items[0].history ?? null
                    formData.value.createdUser = items[0].createdUser ?? null
                } else {
                    formData.value.history = null
                }
            }

            const saveFormData = async () => {
                if (formData.value.id === null){
                    await store.dispatch('sales-order-module/addSalesOrderHistory', formData.value).then(res => {
                        if (res.data.status === 200) {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Sales Order Stage Saved',
                                    icon: 'ThumbsUpIcon',
                                    variant: 'success',
                                    text: 'Sales Order Stage Saved Successfully!',
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
                }else{
                    await store.dispatch('sales-order-module/updateSalesOrderHistory', formData.value).then(res => {
                        if (res.data.status === 200) {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Sales Order Stage Updated',
                                    icon: 'ThumbsUpIcon',
                                    variant: 'success',
                                    text: 'Sales Order Stage Updated Successfully!',
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
                        buttonText.value = 'Save'
                    })
                }
                formData.value.id = null
                formData.value.date = forMatIndianDate(new Date())
                formData.value.history = null
                formData.value.createdUser = currentUser._id
                await fetchData()
            }


            const deleteHistory = async (id) => {
                await Swal.fire({
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
                        store.dispatch('sales-order-module/deleteSalesOrderHistory', {id: id}).then(res => {
                            if (res.data.status === 200) {
                                toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: 'Sales Order Stage Deleted',
                                        icon: 'ThumbsUpIcon',
                                        variant: 'success',
                                        text: 'Sales Order Stage Deleted Successfully!',
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

            const dateFormat = ref({
                date: true,
                delimiter: '/',
                datePattern: ['d', 'm', 'Y'],
            })

            const formatDates = ref({
                date: null,
            })

            const getFormatDate = (date) => {
                formData.value.date = forMatIndianDate(date)
            }

            return {
                tableData,
                usersOptions,
                buttonText,
                formData,
                saveFormData,
                fetchData,
                deleteHistory,
                dateFormat,
                formatDates,
                getFormatDate,
                onRowSelected
            }
        }
    }
</script>
