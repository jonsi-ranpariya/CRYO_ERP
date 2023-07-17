<template>
    <div>
        <b-row>
            <b-col md="12">
                <b-table
                    responsive="sm"
                    :fields="table.fields"
                    :items="table.data"
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

                    <!-- A virtual column -->
                    <template #cell(index)="data">
                        {{ data.index + 1 }}
                    </template>

                    <!-- A custom formatted column -->
                    <template #cell(action)="data">
<!--                        <b-dropdown-->
<!--                            variant="link"-->
<!--                            toggle-class="text-decoration-none"-->
<!--                            no-caret-->
<!--                        >-->
<!--                            <template v-slot:button-content>-->
<!--                                <feather-icon-->
<!--                                    icon="MoreVerticalIcon"-->
<!--                                    size="16"-->
<!--                                    class="text-body align-middle mr-25"-->
<!--                                />-->
<!--                            </template>-->
<!--                            &lt;!&ndash;<b-dropdown-item @click="deleteBillingTerm(data.item._id)">-->
<!--                                <feather-icon-->
<!--                                    icon="TrashIcon"-->
<!--                                    class="mr-50"-->
<!--                                />-->
<!--                                <span>Delete</span>-->
<!--                            </b-dropdown-item>&ndash;&gt;-->
<!--                        </b-dropdown>-->
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
        <!-- table Close -->
        <b-row>
            <!-- Billing Template Dropdown -->
            <b-col md="12">
                <h5>Change Billing Template</h5>
                <hr>
            </b-col>
            <b-col md="6">
                <b-form-group
                    label="Select Template"
                    label-for="billing-term"
                >
                    <v-select
                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                        :options="billingOptions"
                        :clearable="false"
                        input-id="billing-term"
                        :reduce="val => val.value"
                        @input="getBillingData($event)"
                    />
                </b-form-group>
            </b-col>
            <b-col md="6">
                <!--Change Template Button-->
                <b-button
                    type="button"
                    size="md"
                    variant="primary"
                    @click="updateBillingTerm"
                    class="mt-2"
                >
                    Update Billing Template
                </b-button>
            </b-col>
        </b-row>
        <b-form @submit.prevent="submitFormData">
            <b-row>
                <b-col md="12">
                    <hr>
                </b-col>
                <b-col md="6">
                    <b-form-group
                        label="Cal Code"
                        label-for="calCode"
                    >
                        <b-form-input
                            readonly
                            id="calCode"
                            v-model="formData.calCode"
                        />
                    </b-form-group>
                    <b-form-group
                        label="Description"
                        label-for="description"
                    >
                        <b-form-input
                            readonly
                            id="description"
                            v-model="formData.description"
                        />
                    </b-form-group>
                    <b-form-group
                        label="Narration"
                        label-for="narration"
                    >
                        <b-form-input
                            id="narration"
                            v-model="formData.narration"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="6">
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
    </div>
</template>
<script>
    import {
        BForm,
        BRow,
        BCol,
        BFormGroup,
        BFormInput,
        BButton,
        BTable,
        BTab,
        BSpinner,
        BDropdown,
        BDropdownItem,
    } from 'bootstrap-vue'
    import {ref, computed} from "@vue/composition-api";
    import vSelect from 'vue-select'
    import Ripple from "vue-ripple-directive";
    import axios from '@axios'
    import router from '@/router'
    import store from '@/store'
    import purchaseStoreModule from "../../purchaseStoreModule";
    import {useToast} from 'vue-toastification/composition'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import Swal from 'sweetalert2'
    import {generatePurchaseBillingTerm} from "../purchaseQuotationHelper";

    export default {
        components: {
            BForm,
            BRow,
            BFormGroup,
            BCol,
            BFormInput,
            BButton,
            BTable,
            BTab,
            BSpinner,
            BDropdown,
            BDropdownItem,

            vSelect,
        },
        directives: {
            Ripple,
        },
        props: {
            itemDetails: {
                type: Array
            },
            roundingType: {
                required: true
            }
        },
        setup(props) {
            const SE_APP_STORE_MODULE_NAME = 'purchase-store-module'
            if (!store.hasModule(SE_APP_STORE_MODULE_NAME)) store.registerModule(SE_APP_STORE_MODULE_NAME, purchaseStoreModule)

            const toast = useToast()

            const isBusy = ref(false)

            const table = ref({
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
                        key: 'calCode',
                        label: 'code'
                    },
                    {
                        key: 'description',
                        label: 'description'
                    },
                    {
                        key: 'calDefination',
                        label: 'calDescription'
                    },
                    {
                        key: 'percentage',
                        label: 'percentage'
                    },
                    {
                        key: 'byValue',
                        label: 'value'
                    },
                    {
                        key: 'calculateAmount',
                        label: 'Amount'
                    },
                    // {
                    //     key: 'Action',
                    //     label: 'action'
                    // },
                ],
                data: [],
            })

            const itemDetail = computed(() => props.itemDetails)
            const currentRounding = computed(() => props.roundingType)

            const formData = ref({
                _id: null,
                purchaseQuotationId: router.currentRoute.params.id,
                calCode: null,
                description: null,
                narration: null,
                percentage: null,
                byValue: null,
            })

            const onRowSelected = (items) => {
                if (items.length > 0) {
                    formData.value._id = items[0]._id
                    formData.value.purchaseOrderId = items[0].purchaseOrderId ?? null
                    formData.value.calCode = items[0].calCode ?? null
                    formData.value.description = items[0].description ?? null
                    formData.value.narration = items[0].narration ?? null
                    formData.value.percentage = items[0].percentage ?? null
                    formData.value.byValue = items[0].byValue ?? null
                } else {
                    resetFormData()
                }
            }

            const resetFormData = () => {
                formData.value._id = null
                formData.value.calCode = null
                formData.value.description = null
                formData.value.narration = null
                formData.value.percentage = null
                formData.value.byValue = null
            }

            const billingOptions = ref([])
            axios.get('/api/get-billing-template-master-options').then(res => {
                billingOptions.value = res.data?.data
            })

            const refetchData = async () => {
                isBusy.value = true
                await axios.get(`/api/get-purchase-quotation-billing-terms/${router.currentRoute.params.id}`).then(res => {
                    table.value.data = res.data.data
                })
                isBusy.value = false
            }
            refetchData()

            const billingData = ref([])

            const getBillingData = async (id) => {
                billingData.value = []
                await axios.get(`/api/billing-template-master/${id}`).then(res => {
                    if (res.data.data.billing_items) {
                        for (let i = 0; i < res.data.data.billing_items.length; i++) {
                            billingData.value.push({...res.data.data.billing_items[i]})
                        }
                    }
                })
            }

            const updateBillingTerm = async () => {
                if (billingData.value.length > 0) {
                    await generatePurchaseBillingTerm(router.currentRoute.params.id,
                        billingData.value,
                        itemDetail.value,
                        `/api/delete-purchase-quotation-billing-terms/${router.currentRoute.params.id}`,
                        '/api/bulk-add-purchase-quotation-billing-terms',
                        parseInt(currentRounding.value)
                    );
                    await refetchData()
                } else {
                    toast({
                        component: ToastificationContent,
                        position: 'top-right',
                        props: {
                            title: 'Something went wrong',
                            icon: 'AlertCircleIcon',
                            variant: 'danger',
                            text: 'Please select billing template.',
                        },
                    })
                }
            }

            const deleteBillingTerm = async (id) => {
                console.log(id)
            }

            const submitFormData = async () => {
                if (formData.value._id === null) {
                    toast({
                        component: ToastificationContent,
                        position: 'top-right',
                        props: {
                            title: 'Something went wrong',
                            icon: 'AlertCircleIcon',
                            variant: 'danger',
                            text: 'Please select any billing term item.',
                        },
                    })
                } else {
                    await store.dispatch('purchase-store-module/editPurchaseQuotationBillingTerm', formData.value).then(res => {
                        if (res.status === 200) {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Purchase Quotation Billing Term Updated',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: 'You have successfully Updated Purchase Quotation Billing Term.',
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
                    await refetchData()
                    await generatePurchaseBillingTerm(router.currentRoute.params.id,
                        table.value.data,
                        itemDetail.value,
                        `/api/delete-purchase-quotation-billing-terms/${router.currentRoute.params.id}`,
                        '/api/bulk-add-purchase-quotation-billing-terms',
                        parseInt(currentRounding.value)
                    );
                    await refetchData()
                }
            }

            return {
                isBusy,
                formData,
                itemDetail,
                table,
                billingOptions,
                refetchData,
                billingData,
                getBillingData,
                updateBillingTerm,
                deleteBillingTerm,
                submitFormData,
                onRowSelected
            }
        }
    }
</script>
