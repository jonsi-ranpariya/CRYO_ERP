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
                        <h5 class="text-center text-uppercase">No Sales Order Checklist Available</h5>
                    </template>
                    <!-- Serial Number -->
                    <template #cell(index)="data">
                        {{ data.index + 1 }}
                    </template>
                    <template #cell(checkedFor)="data">
                        <span v-for="checked in checkedForOptions">
                            <span v-if="data.item.checkedFor === checked.value">{{ checked.label }}</span>
                        </span>
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
                      <b-dropdown-item @click="deleteChecklist(data.item._id)">
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
                    <b-form-group
                        label="Detail Description"
                        label-for="detailDescription"
                    >
                        <b-form-textarea
                            id="detailDescription"
                            v-model="formData.detailDescription"
                            rows="3"
                        />
                    </b-form-group>
                    <b-form-group
                        label="Remark"
                        label-for="remark"
                    >
                        <b-form-textarea
                            id="remark"
                            rows="3"
                            v-model="formData.remark"
                        />
                    </b-form-group>
                    <b-form-group
                        label="Checked For"
                        label-for="checkedFor"
                    >
                        <v-select
                            placeholder="Select ..."
                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                            :options="checkedForOptions"
                            :reduce="val => val.value"
                            :clearable="false"
                            input-id="checkedFor"
                            v-model="formData.checkedFor"
                        />
                    </b-form-group>
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
            BDropdownItem
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

            const checkedForOptions = [
                {
                    label: 'Production',
                    value: 1
                },
                {
                    label: 'Despatch',
                    value: 2
                },
            ]

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
                        key: 'detailDescription',
                        label: 'Description'
                    },
                    {
                        key: 'checkedFor',
                        label: 'Checked For'
                    },
                    {
                        key: 'action',
                        label: 'Action'
                    }
                ],
                rows: []
            })

            const fetchData = async () => {
                axios.get(`/api/get-sales-order-checklist/${router.currentRoute.params.id}`).then(res => {
                    tableData.value.rows = res.data.data
                })
            }
            fetchData()

            const formData = ref({
                id: null,
                salesOrderId: router.currentRoute.params.id,
                detailDescription: null,
                remark: null,
                checkedFor: null,
            })

            const buttonText = ref('Save')

            const onRowSelected = (items) => {
                if (items.length > 0) {
                    buttonText.value = 'Update'
                    formData.value.id = items[0]._id
                    formData.value.salesOrderId = items[0].salesOrderId
                    formData.value.detailDescription = items[0].detailDescription ?? null
                    formData.value.remark = items[0].remark ?? null
                    formData.value.checkedFor = items[0].checkedFor ?? null
                    buttonText.value = 'Update'
                } else {
                    formData.value.detailDescription = null
                    formData.value.remark = null
                    formData.value.checkedFor = null
                }
            }

            const submitForm = async () => {
                if (formData.value.id === null){
                    await store.dispatch('sales-order-module/addSalesOrderChecklist', formData.value).then(res=> {
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
                    await store.dispatch('sales-order-module/updateSalesOrderChecklist', formData.value).then(res=> {
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
                    })
                }
                buttonText.value = 'Save'
                formData.value.id = null
                formData.value.detailDescription = null
                formData.value.remark = null
                formData.value.checkedFor = null
                await fetchData()
            }

            const deleteChecklist = (id) => {
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
                        store.dispatch('sales-order-module/deleteSalesOrderChecklist', {id: id}).then(res => {
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

            return {
                tableData,
                checkedForOptions,
                formData,
                buttonText,
                fetchData,
                submitForm,
                deleteChecklist,
                onRowSelected
            }
        }
    }
</script>
