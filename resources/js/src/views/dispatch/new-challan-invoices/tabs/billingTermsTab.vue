<template>
    <div>
        <!-- table-->
        <b-row>
            <b-col md="12">
                <b-form-group
                    label="Select Template"
                >
                    <v-select
                        :clearable="false"
                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                        :options="billingOptions"
                        :reduce="val => val.value"
                        @input="getBillingData($event)"
                        input-id="billing-term"
                        placeholder="Change Billing Template"
                    />
                </b-form-group>
            </b-col>
            <b-col md="12">
                <hr>
                <b-table
                    :bordered="true"
                    :busy="isBusy"
                    :fields="table.fields"
                    :hover="true"
                    :items="table.data"
                    class="table_scroll"
                    responsive="sm"
                    show-empty
                >
                    <!--Loader-->
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
                            <b-dropdown-item @click="editBillingTermItem(data.item)">
                                <feather-icon
                                    icon="Edit2Icon"
                                    class="mr-50"
                                />
                                <span>Edit</span>
                            </b-dropdown-item>
                            <b-dropdown-item @click="deleteBillingTermItem(data.item._id)">
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
        <!-- table Close-->
        <b-form @submit.prevent="saveFormData">
            <b-row>
                <b-col md="6">
                    <b-form-group
                        label="Cal Code"
                        label-for="calCode"
                    >
                        <b-form-input
                            id="calCode"
                            v-model="formData.calCode"
                            readonly
                        />
                    </b-form-group>
                    <b-form-group
                        label="Cal Description"
                        label-for="billCalDescription"
                    >
                        <b-form-input
                            id="billCalDescription"
                            v-model="formData.description"
                        />
                    </b-form-group>
                    <b-form-group
                        label="Defination"
                        label-for="defination"
                    >
                        <b-form-input
                            id="defination"
                            v-model="formData.calDefination"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="6">
                    <b-form-group
                        label="Narration"
                        label-for="narration"
                    >
                        <b-form-input
                            id="narration"
                            v-model="formData.narration"
                        />
                    </b-form-group>
                    <b-form-group
                        label="Percentage"
                        label-for="byPercent"
                    >
                        <b-form-input
                            id="byPercent"
                            v-model="formData.percentage"
                            :disabled="formData.byValue > 0"
                        />
                    </b-form-group>
                    <b-form-group
                        label="Value"
                        label-for="byValue"
                    >
                        <b-form-input
                            id="byValue"
                            v-model="formData.byValue"
                            :disabled="formData.percentage > 0"
                        />
                    </b-form-group>
                </b-col>
                <!-- Button -->
                <b-col md="12">
                    <hr>
                    <b-button
                        variant="primary"
                        type="button"
                        @click="getItemWiseCalculation"
                    >
                        Calculate Amount
                    </b-button>
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
    </div>
</template>
<script>
import {
    BButton,
    BCol,
    BDropdown,
    BDropdownItem,
    BForm,
    BFormGroup,
    BFormInput,
    BRow,
    BSpinner,
    BTable,
} from 'bootstrap-vue'
import { onUnmounted, ref, computed } from '@vue/composition-api'
import Ripple from 'vue-ripple-directive'
import axios from '@axios'
import router from '@/router'
import vSelect from 'vue-select'
import { generateBillingTerm } from '../newChallanAndInvoiceBillingTerm'
import store from '@/store'
import dispatchStoreModule from '../../dispatchStoreModule'
import ToastificationContent from '@core/components/toastification/ToastificationContent'
import { useToast } from 'vue-toastification/composition'
import Swal from 'sweetalert2'

export default {
    components: {
        BForm,
        BRow,
        BCol,
        BFormGroup,
        BFormInput,
        BButton,
        BTable,
        BSpinner,
        BDropdown,
        BDropdownItem,
        vSelect,
    },
    directives: {
        Ripple,
    },
    props: {
        roundingType: {
            type: String
        },
        gstCalculationType: {
            required: true
        }
    },
    setup(props) {
        const ITEMADDON_APP_STORE_MODULE_NAME = 'dispatch-store-module'
        if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, dispatchStoreModule)

        const toast = useToast()
        const isBusy = ref(false)
        const isRounding = computed(() => props.roundingType)
        const calculationType = computed(() => props.gstCalculationType)

        const billingOptions = ref([])
        axios.get('/api/get-billing-template-master-options')
            .then(res => {
                billingOptions.value = res.data?.data ?? []
            })

        const table = ref({
            fields: [
                {
                    key: 'index',
                    label: 'No'
                },
                {
                    key: 'calCode',
                    label: 'Cal Code'
                },
                {
                    key: 'description',
                    label: 'Description'
                },
                {
                    key: 'calDefination',
                    label: 'Definition'
                },
                {
                    key: 'percentage',
                    label: 'Percent (%)'
                },
                {
                    key: 'byValue',
                    label: 'Value'
                },
                {
                    key: 'calculateAmount',
                    label: 'Amount'
                },
                {
                    key: 'Action',
                    label: 'action'
                },
            ],
            data: [],
        })

        const itemDetails = ref([])
        const getItemDetails = async () => {
            await axios.get(`/api/get-challan-and-invoice-item/${router.currentRoute.params.id}`)
                .then((res) => {
                    itemDetails.value = res.data.data
                })
        }
        getItemDetails()
        const refetchData = async () => {
            isBusy.value = true
            await axios.get(`/api/get-challan-billing-term/${router.currentRoute.params.id}`)
                .then((res) => {
                    table.value.data = res.data.data
                })
            isBusy.value = false
        }
        refetchData()

        const blankFormData = {
            _id: null,
            challanInvoiceId: router.currentRoute.params.id,
            calCode: null,
            calDefination: null,
            description: null,
            type: null,
            byValue: 0,
            percentage: 0,
            total_amount: 0,
            narration: null,
            operation: null,
            calculateAmount: null,
            srNo: null,
        }

        const formData = ref(JSON.parse(JSON.stringify(blankFormData)))

        const resetFormData = () => {
            formData.value = JSON.parse(JSON.stringify(blankFormData))
        }

        const billingData = ref([])

        const getBillingData = async (id) => {
            billingData.value = []
            await axios.get(`/api/billing-template-master/${id}`)
                .then((res) => {
                    if (res.data.data.billing_items) {
                        for (let i = 0; i < res.data.data.billing_items.length; i++) {
                            billingData.value.push({ ...res.data.data.billing_items[i] })
                        }
                    }
                })

            await generateBillingTerm(router.currentRoute.params.id, billingData.value, itemDetails.value,
                `/api/delete-challan-billing-term/${router.currentRoute.params.id}`,
                '/api/new-challan-billing-term',
                parseInt(isRounding.value),
                parseInt(calculationType.value),
            )
            await refetchData()
        }

        const editBillingTermItem = (data) => {
            formData.value = data
        }

        const deleteBillingTermItem = async (id) => {
            await Swal.fire({
                title: 'Are you sure?',
                text: 'Delete Challan Invoice Billing Item',
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
                        store.dispatch('dispatch-store-module/deleteNewInvoiceChallanBillingItem', { id: id })
                            .then(res => {
                                if (res.status === 200) {
                                    toast({
                                        component: ToastificationContent,
                                        position: 'top-right',
                                        props: {
                                            title: 'Challan Invoice Billing Item Deleted',
                                            icon: 'CheckSquareIcon',
                                            variant: 'success',
                                            text: 'You have successfully Deleted Challan Invoice Billing Item.',
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
                        resetFormData()
                        refetchData()
                    }
                })
        }

        const saveFormData = async () => {
            if (formData.value._id === null) {
                await store.dispatch('dispatch-store-module/addNewInvoiceChallanBillingItem', formData.value)
                    .then((res) => {
                        if (res.status === 200) {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Challan & Invoice Billing Term Added',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: 'You have successfully Added Challan & Invoice Billing Term',
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
            } else {
                await store.dispatch('dispatch-store-module/updateNewInvoiceChallanBillingItem', formData.value)
                    .then((res) => {
                        if (res.status === 200) {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Challan & Invoice Billing Term Updated',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: 'You have successfully Updated Challan & Invoice Billing Term',
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
            await generateBillingTerm(router.currentRoute.params.id, table.value.data, itemDetails.value,
                `/api/delete-challan-billing-term/${router.currentRoute.params.id}`,
                '/api/new-challan-billing-term',
                parseInt(isRounding.value),
                parseInt(calculationType.value),
            )
            resetFormData()
            await refetchData()
        }

        const getItemWiseCalculation = async () => {
            await axios.get('/api/master-gst/get-items-and-final-amounts/'+router.currentRoute.params.id);
            await refetchData()
        }

        return {
            isBusy,
            isRounding,
            table,
            billingOptions,
            billingData,
            getBillingData,
            refetchData,
            formData,
            editBillingTermItem,
            deleteBillingTermItem,
            saveFormData,
            resetFormData,
            getItemWiseCalculation,
        }
    }
}
</script>
