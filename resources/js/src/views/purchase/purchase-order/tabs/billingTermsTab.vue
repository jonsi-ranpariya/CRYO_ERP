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
                            <b-dropdown-item
                                @click="editBillingData(data.item)"
                            >
                                <feather-icon
                                    icon="Edit2Icon"
                                    class="mr-50"
                                />
                                <span>Edit</span>
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
        <b-row>
            <b-col md="6">
                <b-form-group
                    label="Select Template"
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
            <b-col md="12">
                <hr>
            </b-col>
        </b-row>
        <!--    table Close-->
        <b-form @submit.prevent="saveFormData">
            <b-row>
                <b-col md="6">
                    <b-form-group
                        label="Cal Code"
                        label-for="billingCalCOde"
                    >
                        <b-form-input
                            v-model="formData.calCodeLabel"
                            id="billingCalCOde"
                            readonly
                        />
                    </b-form-group>
                    <b-form-group
                        label="Cal Description"
                        label-for="billCalDescription"
                    >
                        <b-form-input
                            v-model="formData.description"
                            id="billCalDescription"
                        />
                    </b-form-group>
                    <b-form-group
                        label="Narration"
                        label-for="billNarration"
                    >
                        <b-form-input
                            v-model="formData.narration"
                            id="billNarration"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="6">
                    <b-form-group
                        label="Percentage"
                        label-for="billPercentage"
                    >
                        <b-form-input
                            v-model="formData.percentage"
                            id="billPercentage"
                            type="number"
                            :disabled="formData.byValue > 0"
                        />
                    </b-form-group>
                    <b-form-group
                        label="Value"
                        label-for="billValue"
                    >
                        <b-form-input
                            v-model="formData.byValue"
                            id="billValue"
                            type="number"
                            :disabled="formData.percentage > 0"
                        />
                    </b-form-group>
                    <b-form-group
                        label="GL A/C"
                        label-for="billGlAc"
                    >
                        <b-form-input
                            id="billGlAc"
                            type="number"
                            readonly
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
    import Ripple from "vue-ripple-directive";
    import vSelect from 'vue-select';
    import axios from '@axios';
    import router from '@/router';
    import store from '@/store';
    import purchaseStoreModule from "../../purchaseStoreModule";
    import {useToast} from 'vue-toastification/composition';
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue';
    import {generatePurchaseBillingTerm} from "../PurchaseOrderBillingTermHelper";

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
            poRoundingType: {
                required: true
            }
        },
        setup(props) {
            const ITEMADDON_APP_STORE_MODULE_NAME = 'purchase-store-module'
            if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, purchaseStoreModule)

            const isBusy = ref(false)
            const toast = useToast()
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
                        key: 'calCodeLabel',
                        label: 'Cal Code'
                    },
                    {
                        key: 'description',
                        label: 'Cal Description'
                    },
                    {
                        key: 'calDefination',
                        label: 'Cal Defination'
                    },
                    {
                        key: 'percentage',
                        label: 'Percentage'
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
            const roundingType = computed(() => props.poRoundingType)

            const billingOptions = ref([])
            axios.get('/api/get-billing-template-master-options').then(res => {
                billingOptions.value = res.data?.data
            })

            const billingData = ref([])

            const getBillingData = async (id) => {
                billingData.value = []
                await axios.get(`/api/billing-template-master/${id}`).then(res => {
                    billingData.value = res.data.data.billing_items
                })
            }

            const itemDetail = ref([])
            axios.get(`/api/get-purchase-order-item/${router.currentRoute.params.id}`)
                .then((res) => {
                    itemDetail.value = res.data.data;
                });

            const updateBillingTerm = async () => {
                if (billingData.value.length > 0) {
                    await generatePurchaseBillingTerm(router.currentRoute.params.id,
                        billingData.value,
                        itemDetail.value,
                        `/api/delete-purchase-order-billing-terms/${router.currentRoute.params.id}`,
                        '/api/add-bulk-purchase-order-billing-terms',
                        parseInt(roundingType.value)
                    );
                    await refetchData(false)
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

            const refetchData = async (regenerate = true) => {
                isBusy.value = true
                const billingTerm = ref([])
                await axios.get(`/api/get-purchase-order-billing-terms/${router.currentRoute.params.id}`).then((res) => {
                    table.value.data = res.data.data
                    billingTerm.value = res.data.data
                })
                if (regenerate === true){
                    await generatePurchaseBillingTerm(router.currentRoute.params.id,
                        billingTerm.value,
                        itemDetail.value,
                        `/api/delete-purchase-order-billing-terms/${router.currentRoute.params.id}`,
                        '/api/add-bulk-purchase-order-billing-terms',
                        parseInt(roundingType.value)
                    );
                    await axios.get(`/api/get-purchase-order-billing-terms/${router.currentRoute.params.id}`).then((res) => {
                        table.value.data = res.data.data
                    })
                }
                isBusy.value = false
            }
            refetchData()

            const blankFormData = {
                _id: null,
                purchaseOrderId: router.currentRoute.params.id,
                calCode: null,
                calCodeLabel: null,
                calDefination: null,
                calculateAmount: null,
                description: null,
                narration: null,
                percentage: null,
            }

            const formData = ref(JSON.parse(JSON.stringify(blankFormData)))

            const resetFormData = () => {
                formData.value = JSON.parse(JSON.stringify(blankFormData))
            }

            const onRowSelected = (items) => {
                if (items.length > 0) {
                    formData.value._id = items[0]._id
                    formData.value.purchaseOrderId = items[0].purchaseOrderId
                    formData.value.calCode = items[0].calCode ?? null
                    formData.value.calCodeLabel = items[0].calCodeLabel ?? null
                    formData.value.calDefination = items[0].calDefination ?? null
                    formData.value.calculateAmount = items[0].calculateAmount ?? null
                    formData.value.description = items[0].description ?? null
                    formData.value.narration = items[0].narration ?? null
                    formData.value.percentage = items[0].percentage ?? null
                } else {
                    resetFormData()
                }
            }

            const editBillingData = (data) => {
                formData.value = data
            }

            const saveFormData = async () => {
                await axios.put(`/api/purchase-order-billing-term/${formData.value._id}`, formData.value).then((res) => {
                    if (res.status === 200) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Purchase Order Billing Term Updated',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: 'You have successfully Updated Purchase Order Billing Term',
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
                }).catch(() => {
                    toast({
                        component: ToastificationContent,
                        position: 'top-right',
                        props: {
                            title: 'Error',
                            icon: 'AlertCircleIcon',
                            variant: 'danger',
                            text: 'Internal Server Error',
                        },
                    })
                })
                resetFormData()
                await refetchData()
            }

            return {
                formData,
                billingOptions,
                billingData,
                getBillingData,
                itemDetail,
                updateBillingTerm,
                refetchData,
                editBillingData,
                isBusy,
                table,
                roundingType,
                saveFormData,
                onRowSelected
            }
        }
    }
</script>

