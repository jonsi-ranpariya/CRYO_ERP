<template>
    <div>
        <!-- table-->
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
        <!--  table Close-->
        <b-form @submit.prevent="saveFormData">
            <b-row>
                <b-col md="12">
                    <b-form-group
                        label="Change Template"
                        label-for="changeTemplate"
                    >
                        <v-select
                            :clearable="false"
                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                            :options="billingTemplateOptions"
                            :reduce="(val) => val.value"
                            input-id="changeTemplate"
                            placeholder="Select Template"
                            @input="getBillingTemplate($event)"
                        />
                    </b-form-group>
                    <hr>
                </b-col>
                <b-col md="6">
                    <b-form-group
                        label="Cal Code"
                        label-for="calCode"
                    >
                        <v-select
                            :clearable="false"
                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                            :options="billingMasterOption"
                            :reduce="(val) => val.value"
                            input-id="calCode"
                            placeholder="Cal code"
                            disabled
                            v-model="formData.calCode"
                        />
                    </b-form-group>
                    <b-form-group
                        label="Cal Description"
                        label-for="billCalDescription"
                    >
                        <b-form-input
                            v-model="formData.calCodeLabel"
                            id="billCalDescription"
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
                        label="Cal Definition"
                        label-for="calDefinition"
                    >
                        <b-form-input
                            v-model="formData.calDefination"
                            id="calDefinition"
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
    BSpinner,
    BDropdown,
    BDropdownItem,
} from 'bootstrap-vue'
import {computed, onMounted, onUnmounted, ref} from '@vue/composition-api'
import Ripple from 'vue-ripple-directive'
import VSelect from "vue-select"
import axios from "@axios";
import router from '@/router'
import purchaseStoreModule from "../../purchaseStoreModule";
import store from '@/store'
import {useToast} from "vue-toastification/composition";
import {changeAmountDecimalPoint, changeToRound} from "@core/utils/utils";
import ToastificationContent from "@core/components/toastification/ToastificationContent";

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
        VSelect
    },
    directives: {
        Ripple,
    },
    props: {
        prRoundingType: {
            required: true
        }
    },
    setup(props) {
        const toast = useToast()
        const ITEMADDON_APP_STORE_MODULE_NAME = 'purchase-store-module'
        onMounted(() => {
            if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, purchaseStoreModule)
        });
        /*onUnmounted(() => {
            if (store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.unregisterModule(ITEMADDON_APP_STORE_MODULE_NAME)
        });*/

        const isBusy = ref(false)
        const roudingType = computed(() => props.prRoundingType);

        const billingMasterOption = ref([])
        axios.get('/api/get-billing-details-master-options').then((res) => {
            billingMasterOption.value = res.data.data
        });

        const billingTemplateOptions = ref([])
        axios.get('/api/get-billing-template-master-options').then((res) => {
            billingTemplateOptions.value = res.data.data
        });

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
                    label: 'Cal Definition'
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
                    key: 'total_amount',
                    label: 'Amount'
                },
                // {
                //     key: 'Action',
                //     label: 'action'
                // },
            ],
            data: [],
        });

        const refetchData = async () => {
            isBusy.value = true
            await axios.get(`/api/new/get-purchase-return-billing-term/${router.currentRoute.params.id}`).then((res) => {
                table.value.data = res.data.data
            });
            isBusy.value = false
        }

        const blankFormData = {
            _id: null,
            purchaseReturnId: router.currentRoute.params.id,
            calCode: null,
            calCodeLabel: null,
            calDefination: null,
            percentage: null,
            byValue: null,
            operation: null,
            narration: null,
            type: null,
            total_amount: null,
            srNo: null
        }

        const formData = ref(JSON.parse(JSON.stringify(blankFormData)));

        const resetFormData = () => {
            formData.value = JSON.parse(JSON.stringify(blankFormData));
        }

        const onRowSelected = (items) => {
            if (items.length > 0) {
                formData.value._id = items[0]._id
                formData.value.purchaseOrderId = items[0].purchaseOrderId ?? null
                formData.value.calCode = items[0].calCode ?? null
                formData.value.calCodeLabel = items[0].calCodeLabel ?? null
                formData.value.calDefination = items[0].calDefination ?? null
                formData.value.percentage = items[0].percentage ?? null
                formData.value.byValue = items[0].byValue ?? null
                formData.value.operation = items[0].operation ?? null
                formData.value.narration = items[0].narration ?? null
                formData.value.type = items[0].type ?? null
                formData.value.total_amount = items[0].total_amount ?? null
                formData.value.srNo = items[0].srNo ?? null
            } else {
                resetFormData()
            }
        }

        const saveFormData = async () => {
            if (formData.value._id === null) {
                await store.dispatch('purchase-store-module/addPurchaseReturnBillingTerm', formData.value).then((res) => {
                    if (res.status === 200) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Purchase Return Billing Term Added',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: 'You have successfully Added Purchase Return Billing Term.',
                            },
                        });
                    } else {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Error',
                                icon: 'AlertCircleIcon',
                                variant: 'danger',
                                text: 'Something went wrong',
                            },
                        });
                    }
                }).catch(() => {
                    toast({
                        component: ToastificationContent,
                        position: 'top-right',
                        props: {
                            title: 'Error',
                            icon: 'AlertCircleIcon',
                            variant: 'danger',
                            text: 'Internal server error.',
                        },
                    });
                });
            } else {
                await store.dispatch('purchase-store-module/updatePurchaseReturnBillingTerm', formData.value).then((res) => {
                    if (res.status === 200) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Purchase Return Billing Term Updated',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: 'You have successfully Updated Purchase Return Billing Term.',
                            },
                        });
                    } else {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Error',
                                icon: 'AlertCircleIcon',
                                variant: 'danger',
                                text: 'Something went wrong',
                            },
                        });
                    }
                }).catch(() => {
                    toast({
                        component: ToastificationContent,
                        position: 'top-right',
                        props: {
                            title: 'Error',
                            icon: 'AlertCircleIcon',
                            variant: 'danger',
                            text: 'Internal server error.',
                        },
                    });
                });
            }
            await generateBillingTerm();
        }

        const billingTemplate = ref([]);

        const getBillingTemplate = async (id) => {
            billingTemplate.value = []
            await axios.get(`/api/billing-template-master/${id}`).then((res) => {
                billingTemplate.value = res.data.data.billing_items
            });

            await generateBillingTerm(billingTemplate.value);
            await refetchData();
        }

        const generateBillingTerm = async (billingTerm = []) => {
            let itemTotalAmount = 0, roundingType = parseInt(roudingType.value), calculationCodes = [],
                itemDetails = [], billingTerms = billingTerm ?? [];
            if (billingTerm.length === 0) {
                await axios.get(`/api/new/get-purchase-return-billing-term/${router.currentRoute.params.id}`).then((res) => {
                    billingTerms = res.data.data
                });
            }

            await axios.get(`/api/new/get-purchase-return-items/${router.currentRoute.params.id}`).then((res) => {
                itemDetails = res.data.data
            });

            await itemDetails.forEach((item) => {
                itemTotalAmount += item.itemNetAmount;
            });

            if (billingTerms.length > 0) {
                await axios.delete(`/api/new/delete-purchase-return-billing-term/${router.currentRoute.params.id}`)
                await billingTerms.forEach((billingData, key) => {
                    const myBillingFormData = {
                        id: null,
                        purchaseReturnId: router.currentRoute.params.id,
                        calCode: null,
                        calCodeLabel: null,
                        calDefination: null,
                        percentage: null,
                        byValue: null,
                        operation: null,
                        narration: null,
                        type: null,
                        total_amount: null,
                        srNo: key + 1
                    }

                    if (roundingType === 0) {
                        if (billingData.calCodeLabel === 'BAS') {
                            calculationCodes[billingData.calCodeLabel] = itemTotalAmount
                            myBillingFormData.calCode = billingData.calCode
                            myBillingFormData.calCodeLabel = billingData.calCodeLabel
                            myBillingFormData.description = billingData.description
                            myBillingFormData.calDefination = billingData.calDefination
                            myBillingFormData.percentage = billingData.percentage
                            myBillingFormData.byValue = billingData.byValue
                            myBillingFormData.operation = billingData.operation
                            myBillingFormData.narration = billingData.narration
                            myBillingFormData.type = billingData.type
                            myBillingFormData.total_amount = parseFloat(itemTotalAmount).toFixed(2)
                        } else {
                            let displayTotal = 0.00
                            calculationCodes[billingData.calCodeLabel] = displayTotal
                            const allCodeData = billingData.calDefination.split('+')
                            const billingDefLength = allCodeData.length;

                            if (billingDefLength > 1) {
                                let CalTotal = 0
                                for (let i = 0; i < allCodeData.length; i++) {
                                    CalTotal += parseFloat(calculationCodes[allCodeData[i]])
                                }
                                calculationCodes[billingData.calCodeLabel] = CalTotal
                                displayTotal = CalTotal
                            } else {
                                if (billingData.percentage > 0) {
                                    //By Percentage
                                    let calculatedPercentage = 0
                                    calculatedPercentage = ((parseFloat(billingData.percentage) / 100) * parseFloat(calculationCodes[allCodeData[0]]))
                                    calculationCodes[billingData.calCodeLabel] = parseFloat(calculatedPercentage)
                                    displayTotal = calculatedPercentage
                                } else if (billingData.byValue > 0) {
                                    //By Value
                                    calculationCodes[billingData.calCodeLabel] = parseFloat(billingData.byValue)
                                    displayTotal = parseFloat(billingData.byValue)
                                }
                            }

                            myBillingFormData.calCode = billingData.calCode
                            myBillingFormData.calCodeLabel = billingData.calCodeLabel
                            myBillingFormData.description = billingData.description
                            myBillingFormData.calDefination = billingData.calDefination
                            myBillingFormData.percentage = billingData.percentage
                            myBillingFormData.byValue = billingData.byValue
                            myBillingFormData.operation = billingData.operation
                            myBillingFormData.narration = billingData.narration
                            myBillingFormData.type = billingData.type
                            myBillingFormData.total_amount = parseFloat(displayTotal).toFixed(2)
                        }
                    }

                    if (roundingType === 1) {
                        if (billingData.calCodeLabel === 'BAS') {
                            calculationCodes[billingData.calCodeLabel] = itemTotalAmount
                            myBillingFormData.calCode = billingData.calCode
                            myBillingFormData.calCodeLabel = billingData.calCodeLabel
                            myBillingFormData.description = billingData.description
                            myBillingFormData.calDefination = billingData.calDefination
                            myBillingFormData.percentage = billingData.percentage
                            myBillingFormData.byValue = billingData.byValue
                            myBillingFormData.operation = billingData.operation
                            myBillingFormData.narration = billingData.narration
                            myBillingFormData.type = billingData.type
                            myBillingFormData.total_amount = parseFloat(itemTotalAmount).toFixed(2)
                        } else {
                            let displayTotal = 0.00
                            calculationCodes[billingData.calCodeLabel] = displayTotal
                            const allCodeData = billingData.calDefination.split('+')
                            const billingDefLength = allCodeData.length;

                            if (billingDefLength > 1) {
                                let CalTotal = 0
                                for (let i = 0; i < allCodeData.length; i++) {
                                    CalTotal += parseFloat(calculationCodes[allCodeData[i]])
                                }
                                calculationCodes[billingData.calCodeLabel] = CalTotal
                                displayTotal = CalTotal
                            } else {
                                if (billingData.percentage > 0) {
                                    //By Percentage
                                    let calculatedPercentage = 0
                                    calculatedPercentage = ((parseFloat(billingData.percentage) / 100) * parseFloat(calculationCodes[allCodeData[0]]))
                                    calculationCodes[billingData.calCodeLabel] = parseFloat(calculatedPercentage)
                                    displayTotal = calculatedPercentage
                                } else if (billingData.byValue > 0) {
                                    //By Value
                                    calculationCodes[billingData.calCodeLabel] = parseFloat(billingData.byValue)
                                    displayTotal = parseFloat(billingData.byValue)
                                }
                            }

                            myBillingFormData.calCode = billingData.calCode
                            myBillingFormData.calCodeLabel = billingData.calCodeLabel
                            myBillingFormData.description = billingData.description
                            myBillingFormData.calDefination = billingData.calDefination
                            myBillingFormData.percentage = billingData.percentage
                            myBillingFormData.byValue = billingData.byValue
                            myBillingFormData.operation = billingData.operation
                            myBillingFormData.narration = billingData.narration
                            myBillingFormData.type = billingData.type
                            if (billingData.calCodeLabel === 'GRD') {
                                myBillingFormData.total_amount = changeAmountDecimalPoint(changeToRound(displayTotal), 2)
                            } else {
                                myBillingFormData.total_amount = parseFloat(displayTotal).toFixed(2)
                            }
                        }
                    }

                    if (roundingType === 2) {
                        if (billingData.calCodeLabel === 'BAS') {
                            calculationCodes[billingData.calCodeLabel] = changeAmountDecimalPoint(changeToRound(itemTotalAmount))
                            myBillingFormData.calCode = billingData.calCode
                            myBillingFormData.calCodeLabel = billingData.calCodeLabel
                            myBillingFormData.description = billingData.description
                            myBillingFormData.calDefination = billingData.calDefination
                            myBillingFormData.percentage = billingData.percentage
                            myBillingFormData.byValue = billingData.byValue
                            myBillingFormData.operation = billingData.operation
                            myBillingFormData.narration = billingData.narration
                            myBillingFormData.type = billingData.type
                            myBillingFormData.total_amount = changeAmountDecimalPoint(changeToRound(itemTotalAmount), 2)
                        } else {
                            let displayTotal = 0.00
                            calculationCodes[billingData.calCodeLabel] = displayTotal
                            const allCodeData = billingData.calDefination.split('+')
                            const billingDefLength = allCodeData.length;

                            if (billingDefLength > 1) {
                                let CalTotal = 0
                                for (let i = 0; i < allCodeData.length; i++) {
                                    CalTotal += changeAmountDecimalPoint(changeToRound(calculationCodes[allCodeData[i]]), 2)
                                }
                                calculationCodes[billingData.calCodeLabel] = CalTotal
                                displayTotal = CalTotal
                            } else {
                                if (billingData.percentage > 0) {
                                    //By Percentage
                                    let calculatedPercentage = 0
                                    calculatedPercentage = changeAmountDecimalPoint(changeToRound((parseFloat(billingData.percentage) / 100) * parseFloat(calculationCodes[allCodeData[0]])), 2)
                                    calculationCodes[billingData.calCodeLabel] = parseFloat(calculatedPercentage)
                                    displayTotal = calculatedPercentage
                                } else if (billingData.byValue > 0) {
                                    //By Value
                                    calculationCodes[billingData.calCodeLabel] = changeAmountDecimalPoint(changeToRound(parseFloat(billingData.byValue)), 2)
                                    displayTotal = changeAmountDecimalPoint(changeToRound(parseFloat(billingData.byValue)), 2)
                                }
                            }

                            myBillingFormData.calCode = billingData.calCode
                            myBillingFormData.calCodeLabel = billingData.calCodeLabel
                            myBillingFormData.description = billingData.description
                            myBillingFormData.calDefination = billingData.calDefination
                            myBillingFormData.percentage = billingData.percentage
                            myBillingFormData.byValue = billingData.byValue
                            myBillingFormData.operation = billingData.operation
                            myBillingFormData.narration = billingData.narration
                            myBillingFormData.type = billingData.type
                            myBillingFormData.total_amount = changeAmountDecimalPoint(changeToRound(displayTotal), 2)
                        }
                    }

                    axios.post('/api/new/purchase-return-billing', myBillingFormData)
                });
            }
            resetFormData();
            await refetchData();
        }
        generateBillingTerm([]);

        return {
            isBusy,
            roudingType,
            billingTemplateOptions,
            billingMasterOption,
            table,

            refetchData,
            formData,
            saveFormData,
            getBillingTemplate,
            generateBillingTerm,
            onRowSelected
        }
    }
}
</script>
