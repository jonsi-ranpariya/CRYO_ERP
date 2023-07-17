<template>
    <div>
        <hr>
        <b-table
            :fields="salesPersonTable.fields"
            :items="salesPersonTable.rows"
            :bordered="true"
            :hover="true"
            show-empty
            responsive
            class="mb-0 table_scroll"
            selectable
            select-mode="single"
            @row-selected="onRowSelected"
        >
            <template #empty="scope">
                <h5 class="text-center text-uppercase">No Sales Person Available</h5>
            </template>
            <!-- A virtual column -->
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
                      <b-dropdown-item @click="deleteSalesAgent(data.item._id)">
                        <feather-icon
                            icon="TrashIcon"
                            class="mr-50"
                        />
                        <span>Delete</span>
                      </b-dropdown-item>
                    </b-dropdown>
                </span>
            </template>

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
        <h5>Details</h5>
        <hr>
        <b-row>
            <b-col md="12">
                <validation-observer
                    ref="validateRules"
                    #default="{ handleSubmit }"
                >
                    <b-form
                        @submit.prevent="handleSubmit(saveSalesAgent)"
                    >
                        <b-form-group
                            label="Sales Agent"
                            label-for="salesAgent"
                        >
                            <validation-provider
                                #default="validationContext"
                                name="Sales Agent"
                                rules=""
                            >
                                <b-form-input
                                    type="text"
                                    id="salesAgent"
                                    v-model="formData.salesAgent"
                                    :state="getValidationState(validationContext)"
                                />
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </validation-provider>
                        </b-form-group>
                        <b-form-group
                            label="Sales Office"
                            label-for="salesOffice"
                        >
                            <validation-provider
                                #default="validationContext"
                                name="Sales Office"
                                rules=""
                            >
                                <b-form-input
                                    type="text"
                                    id="salesOffice"
                                    v-model="formData.salesOffice"
                                    :state="getValidationState(validationContext)"
                                />
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </validation-provider>
                        </b-form-group>
                        <b-form-group
                            label="Comm(%)"
                            label-for="commPercent"
                        >
                            <validation-provider
                                #default="validationContext"
                                name="Comm(%)"
                                rules=""
                            >
                                <b-form-input
                                    type="number"
                                    id="commPercent"
                                    v-model="formData.commPercentage"
                                    :disabled="formData.commValue > 0"
                                    :state="getValidationState(validationContext)"
                                />
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </validation-provider>
                        </b-form-group>
                        <b-form-group
                            label="Comm Value"
                            label-for="commValue"
                        >
                            <validation-provider
                                #default="validationContext"
                                name="Comm(%)"
                                rules=""
                            >
                                <b-form-input
                                    type="number"
                                    id="commValue"
                                    v-model="formData.commValue"
                                    :disabled="formData.commPercentage > 0"
                                    :state="getValidationState(validationContext)"
                                />
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </validation-provider>
                        </b-form-group>
                        <b-form-group
                            label="Remark"
                            label-for="remark"
                        >
                            <validation-provider
                                #default="validationContext"
                                name="Comm(%)"
                                rules=""
                            >
                                <b-form-textarea
                                    id="remark"
                                    rows="3"
                                    v-model="formData.remark"
                                    :state="getValidationState(validationContext)"
                                />
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </validation-provider>
                        </b-form-group>
                        <hr>
                        <b-button
                            type="submit"
                            variant="primary"
                        >
                            {{ buttonText }} Agent
                        </b-button>
                    </b-form>
                </validation-observer>
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
        BDropdownItem
    } from 'bootstrap-vue'
    import {required} from '@validations'
    import Ripple from 'vue-ripple-directive'
    import vSelect from 'vue-select'
    import router from '@/router'
    import store from '@/store'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import {ref, watch, watchEffect, onUnmounted} from '@vue/composition-api'
    import axios from '@axios'
    import Swal from 'sweetalert2'
    import {useToast} from 'vue-toastification/composition'
    import formValidation from '@core/comp-functions/forms/form-validation'
    import salesStoreModule from "../../salesStoreModule";

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

            const salesPersonTable = ref({
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
                        key: 'salesAgent',
                        label: 'Sales Agent'
                    },
                    {
                        key: 'salesOffice',
                        label: 'Sales Office'
                    },
                    {
                        key: 'commPercentage',
                        label: 'Comm(%)'
                    },
                    {
                        key: 'commValue',
                        label: 'Comm(Value)'
                    },
                    {
                        key: 'action',
                        label: 'Action'
                    },
                ],
                rows: []
            })

            const buttonText = ref('Save')

            const salesPerson = {
                id: null,
                salesOrderId: router.currentRoute.params.id,
                salesAgent: null,
                salesOffice: null,
                commPercentage: 0,
                commValue: 0,
                remark: null,
            }

            const formData = ref(JSON.parse(JSON.stringify(salesPerson)))

            const resetGroupData = () => {
                formData.value = JSON.parse(JSON.stringify(salesPerson))
            }

            const onRowSelected = (items) => {
                if (items.length > 0) {
                    formData.value.id = items[0]._id
                    formData.value.salesOrderId = items[0].salesOrderId
                    formData.value.salesAgent = items[0].salesAgent ?? null
                    formData.value.salesOffice = items[0].salesOffice ?? null
                    formData.value.commPercentage = items[0].commPercentage ?? null
                    formData.value.commValue = items[0].commValue ?? null
                    formData.value.remark = items[0].remark ?? null
                    buttonText.value = 'Update'
                } else {
                    resetGroupData()
                }
            }

            const fetchSalesAgents = async () => {
                await store.dispatch('sales-order-module/fetchSalesOrderAgents', {id: router.currentRoute.params.id}).then(res => {
                    salesPersonTable.value.rows = res.data.data
                })
            }

            fetchSalesAgents()

            const saveSalesAgent = async () => {
                if (formData.value.id === null){
                    await store.dispatch('sales-order-module/addSalesOrderAgent', formData.value).then(res => {
                        if (res.data.status === 200) {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Sales Agent Saved',
                                    icon: 'ThumbsUpIcon',
                                    variant: 'success',
                                    text: `Sales Agent: ${formData.value.salesAgent} Saved Successfully!`,
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
                    await store.dispatch('sales-order-module/updateSalesOrderAgent', formData.value).then(res => {
                        if (res.data.status === 200) {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Sales Agent Updated',
                                    icon: 'ThumbsUpIcon',
                                    variant: 'success',
                                    text: `Sales Agent: ${formData.value.salesAgent} Updated Successfully!`,
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
                await fetchSalesAgents()
                resetGroupData()
                buttonText.value = 'Save'
            }

            const deleteSalesAgent = async (id) => {
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
                        store.dispatch('sales-order-module/deleteSalesOrderAgent', id).then(res => {
                            if (res.data.status === 200) {
                                toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: 'Sales Agent Deleted',
                                        icon: 'ThumbsUpIcon',
                                        variant: 'success',
                                        text: `Sales Agent Deleted Successfully!`,
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
                        fetchSalesAgents()
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

            const {refFormObserver, getValidationState, resetForm} = formValidation(resetGroupData)

            return {
                saveSalesAgent,
                fetchSalesAgents,
                deleteSalesAgent,
                formData,
                salesPersonTable,
                buttonText,

                resetGroupData,
                refFormObserver,
                getValidationState,
                resetForm,
                onRowSelected

            }
        }
    }
</script>
