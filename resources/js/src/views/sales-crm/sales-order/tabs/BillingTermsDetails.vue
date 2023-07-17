<template>
    <div>
        <b-row>
            <b-col md="12">
                <hr>
                <div class="float-right">
                    <b-button
                        type="button"
                        variant="primary"
                        v-b-modal.billingTermModal
                    >
                        Change Template
                    </b-button>
                    <b-button
                        type="button"
                        variant="primary"
                        @click="getTemplateFromParty($event)"
                    >
                        From Party Master
                    </b-button>
                </div>
            </b-col>
        </b-row>
        <hr>
        <b-table
            :fields="BillingTermFields"
            :items="listOfBillingTerm"
            :bordered="true"
            :hover="true"
            show-empty
            responsive
            class="mb-0 table_scroll"
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
                    <b-dropdown-item @click="editSalesOrderItemBillingTerm(data.item)">
                        <feather-icon
                            icon="Edit2Icon"
                            class="mr-50"
                        />
                        <span>Edit</span>
                    </b-dropdown-item>
                    <b-dropdown-item @click="deleteSalesOrderBillingTerm(data.item._id)">
                        <feather-icon
                            icon="TrashIcon"
                            class="mr-50"
                        />
                        <span>Delete</span>
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

        <b-row>
            <b-col md="12">
                <hr>
                <h4>Billing Term Details</h4>
                <hr>
            </b-col>
        </b-row>

        <validation-observer ref="simpleRules">
            <b-form>
                <b-row>
                    <b-col md="6">
                        <b-form-group
                            label="Cal Code"
                            label-for="calCode"
                        >
                            <b-form-input
                                id="calCode"
                                v-model="salesOrderBillingTermData.calCodeLabel"
                                disabled
                            />
                        </b-form-group>
                        <b-form-group
                            label="Description"
                            label-for="description"
                        >
                            <b-form-input
                                id="description"
                                v-model="salesOrderBillingTermData.billingName"
                            />
                        </b-form-group>
                        <b-form-group
                            label="Narration"
                            label-for="narration"
                        >
                            <b-form-input
                                id="narration"
                                v-model="salesOrderBillingTermData.billingNarration"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="6">
                        <b-form-group
                            label="Defination"
                            label-for="defination"
                        >
                            <b-form-input
                                id="defination"
                                v-model="salesOrderBillingTermData.calDefination"
                            />
                        </b-form-group>
                        <b-form-group
                            label="Percentage(%)"
                            label-for="billingPercentage"
                        >
                            <b-form-input
                                id="billingPercentage"
                                v-model="salesOrderBillingTermData.billingPercentage"
                                :disabled="salesOrderBillingTermData.billingValue > 0"
                                type="number"
                            />
                        </b-form-group>
                        <b-form-group
                            label="Value"
                            label-for="billingValue"
                        >
                            <b-form-input
                                id="billingValue"
                                v-model="salesOrderBillingTermData.billingValue"
                                :disabled="salesOrderBillingTermData.billingPercentage > 0"
                                type="number"
                            />
                        </b-form-group>
                    </b-col>
                </b-row>
                <b-row>
                    <!-- submit and reset -->
                    <b-col md="12">
                        <b-button
                            v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                            type="submit"
                            variant="primary"
                            class="mr-1"
                            @click.prevent="validationForm"
                        >
                            Save
                        </b-button>
                    </b-col>
                </b-row>
            </b-form>
        </validation-observer>

        <!--Billing Modal-->
        <b-modal
            id="billingTermModal"
            title="Select Billing Template"
            ok-title="submit"
            cancel-variant="danger"
            size="lg"
            no-close-on-backdrop
            @ok="handelOk"
            @cancel="resetModalData"
            @close="resetModalData"
        >
            <b-table
                :fields="modalTableFields.billingFields"
                :items="modalTableFields.billingModalData"
                :no-border-collapse="false"
                responsive
                bordered
                hover
                show-empty
                class="table_scroll"
            >
                <template #empty="scope">
                    <h5 class="text-center text-uppercase">No Billing Template Available</h5>
                </template>
                <template #cell(index)="data">
                    {{ data.index + 1 }}
                </template>
                <template #cell(action)="data">
                    <b-button
                        variant="flat-primary"
                        size="sm"
                        :id="`b_${data.item._id}`"
                        @click="getTemplate(data.item)"
                    >
                        Select
                    </b-button>
                </template>
            </b-table>
            <hr>
            <h5>Template Details</h5>
            <hr>
            <b-table
                :fields="modalTableFields.templateFields"
                :items="modalTableFields.templateData"
                :no-border-collapse="false"
                responsive
                bordered
                hover
                show-empty
                class="table_scroll"
            >
                <template #cell(index)="data">
                    {{ data.index + 1 }}
                </template>
                <template #empty="scope">
                    <h5 class="text-center text-uppercase">No Template Details Available</h5>
                </template>
                <!--<template #cell(action)="data">
                    <b-form-checkbox-group>
                        <b-form-checkbox
                            :value="`${data.item._id}`"
                            class="custom-control-primary"
                        />
                        &lt;!&ndash;@change="selectedItemData.push(`${data.item._id}`)"&ndash;&gt;
                    </b-form-checkbox-group>
                </template>-->
            </b-table>
        </b-modal>

    </div>
</template>
<script>
import BCardCode from '@core/components/b-card-code'
import { ValidationProvider, ValidationObserver } from 'vee-validate'
import {
    BRow,
    BCol,
    BFormGroup,
    BFormInput,
    BFormTextarea,
    BForm,
    BDropdown,
    BDropdownItem,
    BButton,
    BFormDatepicker,
    BOverlay,
    BTable,
    BModal,
    BSpinner
} from 'bootstrap-vue'
import { required } from '@validations'
import Ripple from 'vue-ripple-directive'
import vSelect from 'vue-select'
import router from '@/router'
import store from '@/store'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
import { ref, computed, onUnmounted } from '@vue/composition-api'
import salesStoreModule from '../../salesStoreModule'
import axios from '@axios'
import { changeToRound } from '../../../../@core/utils/utils'

export default {
    components: {
        BCardCode,
        ValidationProvider,
        ValidationObserver,
        BRow,
        BCol,
        BFormGroup,
        BFormInput,
        BFormTextarea,
        BForm,
        BButton,
        BDropdown,
        BDropdownItem,
        BFormDatepicker,
        vSelect,
        BOverlay,
        BTable,
        BModal,
        BSpinner
    },
    directives: {
        Ripple,
    },
    props: ['partyDetails', 'roundingType'],
    methods: {
        validationForm() {
            this.$refs.simpleRules.validate()
                .then(success => {
                    if (success) {
                        const hasIdExist = this.containsKey(this.salesOrderBillingTermData, '_id')
                        if (hasIdExist) {
                            this.salesOrderBillingTermData.id = this.salesOrderBillingTermData._id
                            delete this.salesOrderBillingTermData._id
                            store.dispatch('sales-order-module/updateSalesOrderBillingTerms', this.salesOrderBillingTermData)
                                .then(response => {
                                    if (response.status === 200) {
                                        this.resetBillingFormData()
                                        this.refetchBillingTermData()
                                        this.refetchBillingTerm()
                                        this.$toast({
                                            component: ToastificationContent,
                                            position: 'top-right',
                                            props: {
                                                title: 'Billing Term Updated',
                                                icon: 'CheckSquareIcon',
                                                variant: 'success',
                                                text: `You have successfully Updated Billing Term.`,
                                            },
                                        })
                                    }
                                })
                        } else {
                            store.dispatch('sales-order-module/addSalesOrderBillingTerms', this.salesOrderBillingTermData)
                                .then(response => {
                                    if (response.status === 200) {
                                        this.resetBillingFormData()
                                        this.refetchBillingTermData()
                                        this.refetchBillingTerm()
                                        this.$toast({
                                            component: ToastificationContent,
                                            position: 'top-right',
                                            props: {
                                                title: 'Billing Term Created',
                                                icon: 'CheckSquareIcon',
                                                variant: 'success',
                                                text: `You have successfully Created New Billing Term : ${this.salesOrderBillingTermData.billingName}.`,
                                            },
                                        })
                                    }
                                })
                        }
                    }
                })
        },
        containsKey(obj, key) {
            return Object.keys(obj)
                .includes(key)
        },
        deleteSalesOrderBillingTerm(id) {
            this.$swal({
                title: 'Are you sure?',
                text: 'You won\'t be able to revert this!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                customClass: {
                    confirmButton: 'btn btn-primary',
                    cancelButton: 'btn btn-outline-danger ml-1',
                },
                buttonsStyling: false,
            })
                .then(result => {
                    if (result.value) {
                        store.dispatch(`sales-order-module/deleteSalesOrderBillingTerms`, { id })
                            .then(response => {
                                if (response.data.status === 200) {
                                    this.refetchBillingTermData()
                                    this.refetchBillingTerm()
                                    this.$toast({
                                        component: ToastificationContent,
                                        position: 'top-right',
                                        props: {
                                            title: `Deleted`,
                                            icon: 'CheckSquareIcon',
                                            variant: 'success',
                                            text: `Department Deleted Successfully`,
                                        },
                                    })
                                } else {
                                    this.$toast({
                                        component: ToastificationContent,
                                        position: 'top-right',
                                        props: {
                                            title: `Error`,
                                            icon: 'AlertCircleIcon',
                                            variant: 'danger',
                                            text: `something went wrong`,
                                        },
                                    })
                                }
                            })
                    }
                })
        }
    },
    setup(props) {
        const SO_APP_STORE_MODULE_NAME = 'sales-order-module'
        // Register module
        if (!store.hasModule(SO_APP_STORE_MODULE_NAME)) store.registerModule(SO_APP_STORE_MODULE_NAME, salesStoreModule)
        // UnRegister on leave
        /*onUnmounted(() => {
            if (store.hasModule(SO_APP_STORE_MODULE_NAME)) store.unregisterModule(SO_APP_STORE_MODULE_NAME)
        })*/

        const CurrentSalesOrderId = ref(router.currentRoute.params.id)
        const currentRoundingType = computed(() => props.roundingType)

        const isBillingValueShow = ref(false)
        const isBillingPercentShow = ref(false)
        const BillingTermOptions = ref([])
        const BillingTermFields = ref([
            {
                key: 'rowSelected',
                label: ''
            },
            {
                key: 'index',
                label: 'No',
            },
            {
                key: 'calCodeLabel',
                label: 'Code'
            },
            {
                key: 'billingName',
                label: 'Description',
            },
            {
                key: 'calDefination',
                label: 'Cal Defination',
            },
            {
                key: 'billingNarration',
                label: 'Narration',
            },
            {
                key: 'billingPercentage',
                label: 'Percentage (%)',
            },
            {
                key: 'billingValue',
                label: 'Value',
            },
            {
                key: 'calculatedAmount',
                label: 'Amount',
            },
            {
                key: 'action',
                label: 'Action',
            },
        ])
        const listOfBillingTerm = ref([])
        const isBusy = ref(false)

        const refetchBillingTermData = async () => {
            isBusy.value = true
            await axios.get(`/api/get-sales-order-billing-terms/${CurrentSalesOrderId.value}`)
                .then(res => {
                    listOfBillingTerm.value = res.data.data
                })
            isBusy.value = false
        }

        axios.get('/api/get-billing-template-master-options')
            .then(res => {
                BillingTermOptions.value = res.data.data
            })

        const salesOrderBillingTermData = ref({
            id: null,
            salesOrderId: CurrentSalesOrderId.value,
            billingId: null,
            billingName: null,
            billingType: null,
            billingPercentage: null,
            billingValue: null,
            billingNarration: null,
            calCode: null,
            calCodeLabel: null,
            calculatedAmount: null,
            srNo: null,
        })

        const onRowSelected = (items) => {
            if (items.length > 0) {
                salesOrderBillingTermData.value._id = items[0]._id
                salesOrderBillingTermData.value.billingId = items[0].billingId
                salesOrderBillingTermData.value.billingName = items[0].billingName ?? null
                salesOrderBillingTermData.value.billingType = items[0].billingType ?? null
                salesOrderBillingTermData.value.billingPercentage = items[0].billingPercentage ?? null
                salesOrderBillingTermData.value.billingValue = items[0].billingValue ?? null
                salesOrderBillingTermData.value.billingNarration = items[0].billingNarration ?? null
                salesOrderBillingTermData.value.calCode = items[0].calCode ?? null
                salesOrderBillingTermData.value.calCodeLabel = items[0].calCodeLabel ?? null
                salesOrderBillingTermData.value.calDefination = items[0].calDefination ?? null
                salesOrderBillingTermData.value.calculatedAmount = items[0].calculatedAmount ?? null
                salesOrderBillingTermData.value.srNo = items[0].srNo ?? null
                isBillingPercentShow.value = salesOrderBillingTermData.value.billingPercentage > 0
                isBillingValueShow.value = salesOrderBillingTermData.value.billingValue > 1
            } else {
                resetBillingFormData()
            }
        }


        const resetBillingFormData = () => {
            salesOrderBillingTermData.value = {
                id: null,
                salesOrderId: CurrentSalesOrderId.value,
                billingId: null,
                billingName: null,
                billingType: null,
                billingPercentage: null,
                billingValue: null,
                billingNarration: null,
                calCode: null,
                calCodeLabel: null,
                calDefination: null,
                calculatedAmount: null,
                srNo: null,
            }
            isBillingPercentShow.value = false
            isBillingValueShow.value = false
        }

        const itemDetails = ref([])

        const editSalesOrderItemBillingTerm = (BillingTermEditdata) => {
            salesOrderBillingTermData.value = BillingTermEditdata
            isBillingPercentShow.value = salesOrderBillingTermData.value.billingPercentage > 0
            isBillingValueShow.value = salesOrderBillingTermData.value.billingValue > 1
        }

        const modalTableFields = ref({
            billingFields: [
                {
                    key: 'action',
                    label: ''
                },
                {
                    key: 'index',
                    label: 'No'
                },
                {
                    key: 'templateName',
                    label: 'Template Name'
                },
            ],
            billingModalData: [],
            templateFields: [
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
                    label: 'Description'
                },
                {
                    key: 'percentage',
                    label: 'Percent'
                },
                {
                    key: 'byValue',
                    label: 'Value'
                },
                {
                    key: 'narration',
                    label: 'Narration'
                },
            ],
            templateData: []
        })

        axios.get('/api/billing-template-master')
            .then(res => {
                modalTableFields.value.billingModalData = res.data.data
            })

        const getTemplate = (data) => {
            modalTableFields.value.templateData = data.billing_items
        }

        const getTemplateFromParty = async (e) => {
            e.preventDefault()
            const newBillingTerm = ref([])
            await axios.get('/api/get-sales-order-items/'.concat(CurrentSalesOrderId.value))
                .then(res => {
                    itemDetails.value = res.data.data
                })
            let netAmount = 0.00
            await itemDetails.value.forEach((item) => {
                netAmount += parseFloat(item.itemNetAmount)
            })
            let dynamicCalculation = []
            await axios.delete('/api/delete-old-sales-order-billing-terms/'.concat(CurrentSalesOrderId.value))
            await axios.get('/api/party/get-party-billing-term/'.concat(props.partyDetails.partyDetailId))
                .then(res => {
                    if (res.data.data.length > 0) {
                        res.data.data.forEach((item, key) => {
                            let newAmount = 0.00
                            if (itemDetails.value.length > 0) {

                                if (currentRoundingType.value === '0') {
                                    if (item.calCodeLabel === 'BAS') {
                                        dynamicCalculation[item.calCodeLabel] = netAmount
                                        item.calculateAmount = parseFloat(netAmount)
                                            .toFixed(2)
                                        salesOrderBillingTermData.value.calCode = item.calCode
                                        salesOrderBillingTermData.value.calCodeLabel = item.calCodeLabel
                                        salesOrderBillingTermData.value.calDefination = item.calDefination
                                        salesOrderBillingTermData.value.billingName = item.description
                                        salesOrderBillingTermData.value.billingNarration = item.narration
                                        salesOrderBillingTermData.value.billingType = item.type
                                        salesOrderBillingTermData.value.billingPercentage = item.percentage
                                        salesOrderBillingTermData.value.billingValue = item.byValue
                                        salesOrderBillingTermData.value.calculatedAmount = parseFloat(netAmount)
                                            .toFixed(2)
                                        salesOrderBillingTermData.value.srNo = key
                                    } else {
                                        dynamicCalculation[item.calCodeLabel] = newAmount
                                        salesOrderBillingTermData.value.calCode = item.calCode
                                        salesOrderBillingTermData.value.calCodeLabel = item.calCodeLabel
                                        salesOrderBillingTermData.value.calDefination = item.calDefination
                                        salesOrderBillingTermData.value.billingName = item.description
                                        salesOrderBillingTermData.value.billingNarration = item.narration
                                        salesOrderBillingTermData.value.billingType = item.type
                                        salesOrderBillingTermData.value.billingPercentage = item.percentage
                                        salesOrderBillingTermData.value.billingValue = item.byValue
                                        salesOrderBillingTermData.value.calculatedAmount = parseFloat(netAmount)
                                            .toFixed(2)
                                        salesOrderBillingTermData.value.srNo = key

                                        let allCodeData = item.calDefination.split('+'),
                                            dispayTotal = 0.00
                                        if (allCodeData.length > 1) {
                                            let calTotal = 0.00
                                            for (let i = 0; i < allCodeData.length; i++) {
                                                calTotal += dynamicCalculation[allCodeData[i]]
                                            }
                                            dynamicCalculation[item.calCodeLabel] = calTotal
                                            dispayTotal = parseFloat(calTotal)
                                                .toFixed(2)
                                            salesOrderBillingTermData.value.calculatedAmount = parseFloat(dispayTotal)
                                                .toFixed(2)
                                        } else {
                                            if (parseFloat(item.percentage) > 0) {
                                                //By Percentage
                                                let calculatedPercentage = 0
                                                calculatedPercentage = (parseFloat(item.percentage / 100) * parseFloat(dynamicCalculation[allCodeData[0]]))
                                                dynamicCalculation[item.calCodeLabel] = calculatedPercentage
                                                dispayTotal = parseFloat(calculatedPercentage)
                                                    .toFixed(2)
                                            }

                                            if (parseFloat(item.byValue) > 0) {
                                                //By Value
                                                dynamicCalculation[item.calCodeLabel] = parseFloat(item.byValue)
                                                dispayTotal = parseFloat(item.byValue)
                                                    .toFixed(2)
                                            }
                                            salesOrderBillingTermData.value.calculatedAmount = dispayTotal
                                        }
                                    }
                                }

                                if (currentRoundingType.value === '1') {
                                    if (item.calCodeLabel === 'BAS') {
                                        dynamicCalculation[item.calCodeLabel] = netAmount
                                        item.calculateAmount = parseFloat(netAmount)
                                            .toFixed(2)
                                        salesOrderBillingTermData.value.calCode = item.calCode
                                        salesOrderBillingTermData.value.calCodeLabel = item.calCodeLabel
                                        salesOrderBillingTermData.value.calDefination = item.calDefination
                                        salesOrderBillingTermData.value.billingName = item.description
                                        salesOrderBillingTermData.value.billingNarration = item.narration
                                        salesOrderBillingTermData.value.billingType = item.type
                                        salesOrderBillingTermData.value.billingPercentage = item.percentage
                                        salesOrderBillingTermData.value.billingValue = item.byValue
                                        salesOrderBillingTermData.value.calculatedAmount = parseFloat(netAmount)
                                            .toFixed(2)
                                        salesOrderBillingTermData.value.srNo = key
                                    } else {
                                        dynamicCalculation[item.calCodeLabel] = newAmount
                                        salesOrderBillingTermData.value.calCode = item.calCode
                                        salesOrderBillingTermData.value.calCodeLabel = item.calCodeLabel
                                        salesOrderBillingTermData.value.calDefination = item.calDefination
                                        salesOrderBillingTermData.value.billingName = item.description
                                        salesOrderBillingTermData.value.billingNarration = item.narration
                                        salesOrderBillingTermData.value.billingType = item.type
                                        salesOrderBillingTermData.value.billingPercentage = item.percentage
                                        salesOrderBillingTermData.value.billingValue = item.byValue

                                        if (item.calCodeLabel === 'GRD') {
                                            salesOrderBillingTermData.value.calculatedAmount = parseFloat(changeToRound(netAmount))
                                                .toFixed(2)
                                        } else {
                                            salesOrderBillingTermData.value.calculatedAmount = parseFloat(netAmount)
                                                .toFixed(2)
                                        }

                                        salesOrderBillingTermData.value.srNo = key

                                        let allCodeData = item.calDefination.split('+'),
                                            dispayTotal = 0.00
                                        if (allCodeData.length > 1) {
                                            let calTotal = 0.00
                                            for (let i = 0; i < allCodeData.length; i++) {
                                                calTotal += dynamicCalculation[allCodeData[i]]
                                            }
                                            dynamicCalculation[item.calCodeLabel] = calTotal
                                            dispayTotal = parseFloat(calTotal)
                                                .toFixed(2)

                                            if (item.calCodeLabel === 'GRD') {
                                                salesOrderBillingTermData.value.calculatedAmount = parseFloat(changeToRound(dispayTotal))
                                                    .toFixed(2)
                                            } else {
                                                salesOrderBillingTermData.value.calculatedAmount = parseFloat(dispayTotal)
                                                    .toFixed(2)
                                            }
                                        } else {
                                            if (parseFloat(item.percentage) > 0) {
                                                //By Percentage
                                                let calculatedPercentage = 0
                                                calculatedPercentage = (parseFloat(item.percentage / 100) * parseFloat(dynamicCalculation[allCodeData[0]]))
                                                dynamicCalculation[item.calCodeLabel] = calculatedPercentage
                                                dispayTotal = parseFloat(calculatedPercentage)
                                                    .toFixed(2)
                                            }

                                            if (parseFloat(item.byValue) > 0) {
                                                //By Value
                                                dynamicCalculation[item.calCodeLabel] = parseFloat(item.byValue)
                                                dispayTotal = parseFloat(item.byValue)
                                                    .toFixed(2)
                                            }

                                            if (item.calCodeLabel === 'GRD') {
                                                salesOrderBillingTermData.value.calculatedAmount = parseFloat(changeToRound(dispayTotal))
                                                    .toFixed(2)
                                            } else {
                                                salesOrderBillingTermData.value.calculatedAmount = dispayTotal
                                            }
                                        }
                                    }
                                }

                                if (currentRoundingType.value === '2') {
                                    if (item.calCodeLabel === 'BAS') {
                                        dynamicCalculation[item.calCodeLabel] = netAmount
                                        item.calculateAmount = parseFloat(netAmount)
                                            .toFixed(2)
                                        salesOrderBillingTermData.value.calCode = item.calCode
                                        salesOrderBillingTermData.value.calCodeLabel = item.calCodeLabel
                                        salesOrderBillingTermData.value.calDefination = item.calDefination
                                        salesOrderBillingTermData.value.billingName = item.description
                                        salesOrderBillingTermData.value.billingNarration = item.narration
                                        salesOrderBillingTermData.value.billingType = item.type
                                        salesOrderBillingTermData.value.billingPercentage = item.percentage
                                        salesOrderBillingTermData.value.billingValue = item.byValue
                                        salesOrderBillingTermData.value.calculatedAmount = parseFloat(changeToRound(netAmount))
                                            .toFixed(2)
                                        salesOrderBillingTermData.value.srNo = key
                                    } else {
                                        dynamicCalculation[item.calCodeLabel] = newAmount
                                        salesOrderBillingTermData.value.calCode = item.calCode
                                        salesOrderBillingTermData.value.calCodeLabel = item.calCodeLabel
                                        salesOrderBillingTermData.value.calDefination = item.calDefination
                                        salesOrderBillingTermData.value.billingName = item.description
                                        salesOrderBillingTermData.value.billingNarration = item.narration
                                        salesOrderBillingTermData.value.billingType = item.type
                                        salesOrderBillingTermData.value.billingPercentage = item.percentage
                                        salesOrderBillingTermData.value.billingValue = item.byValue
                                        salesOrderBillingTermData.value.calculatedAmount = parseFloat(changeToRound(netAmount))
                                            .toFixed(2)
                                        salesOrderBillingTermData.value.srNo = key

                                        let allCodeData = item.calDefination.split('+'),
                                            dispayTotal = 0.00
                                        if (allCodeData.length > 1) {
                                            let calTotal = 0.00
                                            for (let i = 0; i < allCodeData.length; i++) {
                                                calTotal += dynamicCalculation[allCodeData[i]]
                                            }
                                            dynamicCalculation[item.calCodeLabel] = calTotal
                                            dispayTotal = parseFloat(calTotal)
                                                .toFixed(2)
                                            salesOrderBillingTermData.value.calculatedAmount = parseFloat(changeToRound(dispayTotal))
                                                .toFixed(2)
                                        } else {
                                            if (parseFloat(item.percentage) > 0) {
                                                //By Percentage
                                                let calculatedPercentage = 0
                                                calculatedPercentage = (parseFloat(item.percentage / 100) * parseFloat(dynamicCalculation[allCodeData[0]]))
                                                dynamicCalculation[item.calCodeLabel] = calculatedPercentage
                                                dispayTotal = parseFloat(calculatedPercentage)
                                                    .toFixed(2)
                                            }

                                            if (parseFloat(item.byValue) > 0) {
                                                //By Value
                                                dynamicCalculation[item.calCodeLabel] = parseFloat(item.byValue)
                                                dispayTotal = parseFloat(item.byValue)
                                                    .toFixed(2)
                                            }
                                            salesOrderBillingTermData.value.calculatedAmount = parseFloat(changeToRound(dispayTotal))
                                                .toFixed(2)
                                        }
                                    }
                                }

                            } else {
                                salesOrderBillingTermData.value.calCode = item.calCode
                                salesOrderBillingTermData.value.calCodeLabel = item.calCodeLabel
                                salesOrderBillingTermData.value.calDefination = item.calDefination
                                salesOrderBillingTermData.value.billingName = item.description
                                salesOrderBillingTermData.value.billingNarration = item.narration
                                salesOrderBillingTermData.value.billingType = item.type
                                salesOrderBillingTermData.value.billingPercentage = item.percentage
                                salesOrderBillingTermData.value.billingValue = item.byValue
                                salesOrderBillingTermData.value.calculatedAmount = parseFloat(newAmount)
                                    .toFixed(2)
                                salesOrderBillingTermData.value.srNo = key
                            }

                            newBillingTerm.value.push(salesOrderBillingTermData.value)
                            resetBillingFormData()
                            //store.dispatch('sales-order-module/addSalesOrderBillingTerms', salesOrderBillingTermData.value)
                        })
                    }
                })
            await axios.post('/api/sales-order-bulk-insert-billing-term', {
                billingTerm: newBillingTerm.value
            })
                .then(() => {
                    refetchBillingTermData()
                })
            //await refetchBillingTermData();
        }

        const handelOk = async () => {
            const newBillingTerm = ref([])

            await axios.get('/api/get-sales-order-items/'.concat(CurrentSalesOrderId.value))
                .then(res => {
                    itemDetails.value = res.data.data
                })
            let netAmount = 0.00
            await itemDetails.value.forEach((item) => {
                netAmount += parseFloat(item.itemNetAmount)
            })
            let dynamicCalculation = []
            await axios.delete('/api/delete-old-sales-order-billing-terms/'.concat(CurrentSalesOrderId.value))
            await modalTableFields.value.templateData.forEach((item, key) => {
                let newAmount = 0.00
                if (itemDetails.value.length > 0) {

                    if (currentRoundingType.value === '0') {
                        if (item.calCodeLabel === 'BAS') {
                            dynamicCalculation[item.calCodeLabel] = netAmount
                            item.calculateAmount = parseFloat(netAmount)
                                .toFixed(2)
                            salesOrderBillingTermData.value.calCode = item.calCode
                            salesOrderBillingTermData.value.calCodeLabel = item.calCodeLabel
                            salesOrderBillingTermData.value.calDefination = item.calDefination
                            salesOrderBillingTermData.value.billingName = item.description
                            salesOrderBillingTermData.value.billingNarration = item.narration
                            salesOrderBillingTermData.value.billingType = item.type
                            salesOrderBillingTermData.value.billingPercentage = item.percentage
                            salesOrderBillingTermData.value.billingValue = item.byValue
                            salesOrderBillingTermData.value.calculatedAmount = parseFloat(netAmount)
                                .toFixed(2)
                            salesOrderBillingTermData.value.srNo = key
                        } else {
                            dynamicCalculation[item.calCodeLabel] = newAmount
                            salesOrderBillingTermData.value.calCode = item.calCode
                            salesOrderBillingTermData.value.calCodeLabel = item.calCodeLabel
                            salesOrderBillingTermData.value.calDefination = item.calDefination
                            salesOrderBillingTermData.value.billingName = item.description
                            salesOrderBillingTermData.value.billingNarration = item.narration
                            salesOrderBillingTermData.value.billingType = item.type
                            salesOrderBillingTermData.value.billingPercentage = item.percentage
                            salesOrderBillingTermData.value.billingValue = item.byValue
                            salesOrderBillingTermData.value.calculatedAmount = parseFloat(netAmount)
                                .toFixed(2)
                            salesOrderBillingTermData.value.srNo = key

                            let allCodeData = item.calDefination.split('+'),
                                dispayTotal = 0.00
                            if (allCodeData.length > 1) {
                                let calTotal = 0.00
                                for (let i = 0; i < allCodeData.length; i++) {
                                    calTotal += dynamicCalculation[allCodeData[i]]
                                }
                                dynamicCalculation[item.calCodeLabel] = calTotal
                                dispayTotal = parseFloat(calTotal)
                                    .toFixed(2)
                                salesOrderBillingTermData.value.calculatedAmount = parseFloat(dispayTotal)
                                    .toFixed(2)
                            } else {
                                if (parseFloat(item.percentage) > 0) {
                                    //By Percentage
                                    let calculatedPercentage = 0
                                    calculatedPercentage = (parseFloat(item.percentage / 100) * parseFloat(dynamicCalculation[allCodeData[0]]))
                                    dynamicCalculation[item.calCodeLabel] = calculatedPercentage
                                    dispayTotal = parseFloat(calculatedPercentage)
                                        .toFixed(2)
                                }

                                if (parseFloat(item.byValue) > 0) {
                                    //By Value
                                    dynamicCalculation[item.calCodeLabel] = parseFloat(item.byValue)
                                    dispayTotal = parseFloat(item.byValue)
                                        .toFixed(2)
                                }
                                salesOrderBillingTermData.value.calculatedAmount = dispayTotal
                            }
                        }
                    }

                    if (currentRoundingType.value === '1') {
                        if (item.calCodeLabel === 'BAS') {
                            dynamicCalculation[item.calCodeLabel] = netAmount
                            item.calculateAmount = parseFloat(netAmount)
                                .toFixed(2)
                            salesOrderBillingTermData.value.calCode = item.calCode
                            salesOrderBillingTermData.value.calCodeLabel = item.calCodeLabel
                            salesOrderBillingTermData.value.calDefination = item.calDefination
                            salesOrderBillingTermData.value.billingName = item.description
                            salesOrderBillingTermData.value.billingNarration = item.narration
                            salesOrderBillingTermData.value.billingType = item.type
                            salesOrderBillingTermData.value.billingPercentage = item.percentage
                            salesOrderBillingTermData.value.billingValue = item.byValue
                            salesOrderBillingTermData.value.calculatedAmount = parseFloat(netAmount)
                                .toFixed(2)
                            salesOrderBillingTermData.value.srNo = key
                        } else {
                            dynamicCalculation[item.calCodeLabel] = newAmount
                            salesOrderBillingTermData.value.calCode = item.calCode
                            salesOrderBillingTermData.value.calCodeLabel = item.calCodeLabel
                            salesOrderBillingTermData.value.calDefination = item.calDefination
                            salesOrderBillingTermData.value.billingName = item.description
                            salesOrderBillingTermData.value.billingNarration = item.narration
                            salesOrderBillingTermData.value.billingType = item.type
                            salesOrderBillingTermData.value.billingPercentage = item.percentage
                            salesOrderBillingTermData.value.billingValue = item.byValue

                            if (item.calCodeLabel === 'GRD') {
                                salesOrderBillingTermData.value.calculatedAmount = parseFloat(changeToRound(netAmount))
                                    .toFixed(2)
                            } else {
                                salesOrderBillingTermData.value.calculatedAmount = parseFloat(netAmount)
                                    .toFixed(2)
                            }
                            salesOrderBillingTermData.value.srNo = key

                            let allCodeData = item.calDefination.split('+'),
                                dispayTotal = 0.00
                            if (allCodeData.length > 1) {
                                let calTotal = 0.00
                                for (let i = 0; i < allCodeData.length; i++) {
                                    calTotal += dynamicCalculation[allCodeData[i]]
                                }
                                dynamicCalculation[item.calCodeLabel] = calTotal
                                dispayTotal = parseFloat(calTotal)
                                    .toFixed(2)

                                if (item.calCodeLabel === 'GRD') {
                                    salesOrderBillingTermData.value.calculatedAmount = parseFloat(changeToRound(dispayTotal))
                                        .toFixed(2)
                                } else {
                                    salesOrderBillingTermData.value.calculatedAmount = parseFloat(dispayTotal)
                                        .toFixed(2)
                                }
                            } else {
                                if (parseFloat(item.percentage) > 0) {
                                    //By Percentage
                                    let calculatedPercentage = 0
                                    calculatedPercentage = (parseFloat(item.percentage / 100) * parseFloat(dynamicCalculation[allCodeData[0]]))
                                    dynamicCalculation[item.calCodeLabel] = calculatedPercentage
                                    dispayTotal = parseFloat(calculatedPercentage)
                                        .toFixed(2)
                                }

                                if (parseFloat(item.byValue) > 0) {
                                    //By Value
                                    dynamicCalculation[item.calCodeLabel] = parseFloat(item.byValue)
                                    dispayTotal = parseFloat(item.byValue)
                                        .toFixed(2)
                                }

                                if (item.calCodeLabel === 'GRD') {
                                    salesOrderBillingTermData.value.calculatedAmount = parseFloat(changeToRound(dispayTotal))
                                        .toFixed(2)
                                } else {
                                    salesOrderBillingTermData.value.calculatedAmount = dispayTotal
                                }
                            }
                        }
                    }

                    if (currentRoundingType.value === '2') {
                        if (item.calCodeLabel === 'BAS') {
                            dynamicCalculation[item.calCodeLabel] = netAmount
                            item.calculateAmount = parseFloat(netAmount)
                                .toFixed(2)
                            salesOrderBillingTermData.value.calCode = item.calCode
                            salesOrderBillingTermData.value.calCodeLabel = item.calCodeLabel
                            salesOrderBillingTermData.value.calDefination = item.calDefination
                            salesOrderBillingTermData.value.billingName = item.description
                            salesOrderBillingTermData.value.billingNarration = item.narration
                            salesOrderBillingTermData.value.billingType = item.type
                            salesOrderBillingTermData.value.billingPercentage = item.percentage
                            salesOrderBillingTermData.value.billingValue = item.byValue
                            salesOrderBillingTermData.value.calculatedAmount = parseFloat(netAmount)
                                .toFixed(2)
                            salesOrderBillingTermData.value.srNo = key
                        } else {
                            dynamicCalculation[item.calCodeLabel] = newAmount
                            salesOrderBillingTermData.value.calCode = item.calCode
                            salesOrderBillingTermData.value.calCodeLabel = item.calCodeLabel
                            salesOrderBillingTermData.value.calDefination = item.calDefination
                            salesOrderBillingTermData.value.billingName = item.description
                            salesOrderBillingTermData.value.billingNarration = item.narration
                            salesOrderBillingTermData.value.billingType = item.type
                            salesOrderBillingTermData.value.billingPercentage = item.percentage
                            salesOrderBillingTermData.value.billingValue = item.byValue
                            salesOrderBillingTermData.value.calculatedAmount = parseFloat(changeToRound(netAmount))
                                .toFixed(2)
                            salesOrderBillingTermData.value.srNo = key

                            let allCodeData = item.calDefination.split('+'),
                                dispayTotal = 0.00
                            if (allCodeData.length > 1) {
                                let calTotal = 0.00
                                for (let i = 0; i < allCodeData.length; i++) {
                                    calTotal += dynamicCalculation[allCodeData[i]]
                                }
                                dynamicCalculation[item.calCodeLabel] = calTotal
                                dispayTotal = parseFloat(calTotal)
                                    .toFixed(2)
                                salesOrderBillingTermData.value.calculatedAmount = parseFloat(changeToRound(dispayTotal))
                                    .toFixed(2)
                            } else {
                                if (parseFloat(item.percentage) > 0) {
                                    //By Percentage
                                    let calculatedPercentage = 0
                                    calculatedPercentage = (parseFloat(item.percentage / 100) * parseFloat(dynamicCalculation[allCodeData[0]]))
                                    dynamicCalculation[item.calCodeLabel] = calculatedPercentage
                                    dispayTotal = parseFloat(calculatedPercentage)
                                        .toFixed(2)
                                }

                                if (parseFloat(item.byValue) > 0) {
                                    //By Value
                                    dynamicCalculation[item.calCodeLabel] = parseFloat(item.byValue)
                                    dispayTotal = parseFloat(item.byValue)
                                        .toFixed(2)
                                }
                                salesOrderBillingTermData.value.calculatedAmount = parseFloat(changeToRound(dispayTotal))
                                    .toFixed(2)
                            }
                        }
                    }

                } else {
                    salesOrderBillingTermData.value.calCode = item.calCode
                    salesOrderBillingTermData.value.calCodeLabel = item.calCodeLabel
                    salesOrderBillingTermData.value.calDefination = item.calDefination
                    salesOrderBillingTermData.value.billingName = item.description
                    salesOrderBillingTermData.value.billingNarration = item.narration
                    salesOrderBillingTermData.value.billingType = item.type
                    salesOrderBillingTermData.value.billingPercentage = item.percentage
                    salesOrderBillingTermData.value.billingValue = item.byValue
                    salesOrderBillingTermData.value.calculatedAmount = parseFloat(newAmount)
                        .toFixed(2)
                    salesOrderBillingTermData.value.srNo = key
                }

                newBillingTerm.value.push(salesOrderBillingTermData.value)
                resetBillingFormData()
            })

            await axios.post('/api/sales-order-bulk-insert-billing-term', {
                billingTerm: newBillingTerm.value
            })
                .then(() => {
                    resetModalData()
                    refetchBillingTermData()
                })
        }

        const resetModalData = () => {
            modalTableFields.value.templateData = []
        }

        const refetchBillingTerm = async () => {
            const newBillingTerm = ref([])
            await axios.get('/api/get-sales-order-items/'.concat(CurrentSalesOrderId.value))
                .then(res => {
                    itemDetails.value = res.data.data
                })
            let netAmount = 0.00
            await itemDetails.value.forEach((item) => {
                netAmount += parseFloat(item.itemNetAmount)
            })
            let dynamicCalculation = []
            let billingTerms = []
            await axios.get('/api/get-sales-order-billing-terms/'.concat(CurrentSalesOrderId.value))
                .then(res => {
                    billingTerms = res.data.data
                })
            await axios.delete('/api/delete-old-sales-order-billing-terms/'.concat(CurrentSalesOrderId.value))
            if (billingTerms.length > 0) {
                await billingTerms.forEach((item, key) => {
                    let newAmount = 0.00

                    if (currentRoundingType.value === '0') {
                        if (item.calCodeLabel === 'BAS') {
                            dynamicCalculation[item.calCodeLabel] = netAmount
                            item.calculateAmount = parseFloat(netAmount)
                                .toFixed(2)
                            salesOrderBillingTermData.value.calCode = item.calCode
                            salesOrderBillingTermData.value.calCodeLabel = item.calCodeLabel
                            salesOrderBillingTermData.value.calDefination = item.calDefination
                            salesOrderBillingTermData.value.billingName = item.billingName
                            salesOrderBillingTermData.value.billingNarration = item.billingNarration
                            salesOrderBillingTermData.value.billingType = item.billingType
                            salesOrderBillingTermData.value.billingPercentage = item.billingPercentage
                            salesOrderBillingTermData.value.billingValue = item.billingValue
                            salesOrderBillingTermData.value.calculatedAmount = parseFloat(netAmount)
                                .toFixed(2)
                            salesOrderBillingTermData.value.srNo = key
                        } else {
                            dynamicCalculation[item.calCodeLabel] = newAmount
                            salesOrderBillingTermData.value.calCode = item.calCode
                            salesOrderBillingTermData.value.calCodeLabel = item.calCodeLabel
                            salesOrderBillingTermData.value.calDefination = item.calDefination
                            salesOrderBillingTermData.value.billingName = item.billingName
                            salesOrderBillingTermData.value.billingNarration = item.billingNarration
                            salesOrderBillingTermData.value.billingType = item.billingType
                            salesOrderBillingTermData.value.billingPercentage = item.billingPercentage
                            salesOrderBillingTermData.value.billingValue = item.billingValue
                            salesOrderBillingTermData.value.calculatedAmount = parseFloat(netAmount)
                                .toFixed(2)
                            salesOrderBillingTermData.value.srNo = key

                            let allCodeData = item.calDefination.split('+'),
                                dispayTotal = 0.00
                            if (allCodeData.length > 1) {
                                let calTotal = 0.00
                                for (let i = 0; i < allCodeData.length; i++) {
                                    calTotal += dynamicCalculation[allCodeData[i]]
                                }
                                dynamicCalculation[item.calCodeLabel] = calTotal
                                dispayTotal = parseFloat(calTotal)
                                    .toFixed(2)
                                salesOrderBillingTermData.value.calculatedAmount = parseFloat(dispayTotal)
                                    .toFixed(2)
                            } else {
                                if (parseFloat(item.billingPercentage) > 0) {
                                    //By Percentage
                                    let calculatedPercentage = 0
                                    calculatedPercentage = (parseFloat(item.billingPercentage / 100) * parseFloat(dynamicCalculation[allCodeData[0]]))
                                    dynamicCalculation[item.calCodeLabel] = calculatedPercentage
                                    dispayTotal = parseFloat(calculatedPercentage)
                                        .toFixed(2)
                                }

                                if (parseFloat(item.billingValue) > 0) {
                                    //By Value
                                    dynamicCalculation[item.calCodeLabel] = parseFloat(item.billingValue)
                                    dispayTotal = parseFloat(item.billingValue)
                                        .toFixed(2)
                                }
                                salesOrderBillingTermData.value.calculatedAmount = dispayTotal
                            }
                        }
                    }

                    if (currentRoundingType.value === '1') {
                        if (item.calCodeLabel === 'BAS') {
                            dynamicCalculation[item.calCodeLabel] = netAmount
                            item.calculateAmount = parseFloat(netAmount)
                                .toFixed(2)
                            salesOrderBillingTermData.value.calCode = item.calCode
                            salesOrderBillingTermData.value.calCodeLabel = item.calCodeLabel
                            salesOrderBillingTermData.value.calDefination = item.calDefination
                            salesOrderBillingTermData.value.billingName = item.billingName
                            salesOrderBillingTermData.value.billingNarration = item.billingNarration
                            salesOrderBillingTermData.value.billingType = item.billingType
                            salesOrderBillingTermData.value.billingPercentage = item.billingPercentage
                            salesOrderBillingTermData.value.billingValue = item.billingValue
                            salesOrderBillingTermData.value.calculatedAmount = parseFloat(netAmount)
                                .toFixed(2)
                            salesOrderBillingTermData.value.srNo = key
                        } else {
                            dynamicCalculation[item.calCodeLabel] = newAmount
                            salesOrderBillingTermData.value.calCode = item.calCode
                            salesOrderBillingTermData.value.calCodeLabel = item.calCodeLabel
                            salesOrderBillingTermData.value.calDefination = item.calDefination
                            salesOrderBillingTermData.value.billingName = item.billingName
                            salesOrderBillingTermData.value.billingNarration = item.billingNarration
                            salesOrderBillingTermData.value.billingType = item.billingType
                            salesOrderBillingTermData.value.billingPercentage = item.billingPercentage
                            salesOrderBillingTermData.value.billingValue = item.billingValue
                            if (item.calCodeLabel === 'GRD') {
                                salesOrderBillingTermData.value.calculatedAmount = changeToRound(parseFloat(parseFloat(netAmount)
                                    .toFixed(2)))
                            } else {
                                salesOrderBillingTermData.value.calculatedAmount = parseFloat(netAmount)
                                    .toFixed(2)
                            }

                            salesOrderBillingTermData.value.srNo = key

                            let allCodeData = item.calDefination.split('+'),
                                dispayTotal = 0.00
                            if (allCodeData.length > 1) {
                                let calTotal = 0.00
                                for (let i = 0; i < allCodeData.length; i++) {
                                    calTotal += dynamicCalculation[allCodeData[i]]
                                }
                                dynamicCalculation[item.calCodeLabel] = calTotal
                                dispayTotal = parseFloat(calTotal)
                                    .toFixed(2)

                                if (item.calCodeLabel === 'GRD') {
                                    salesOrderBillingTermData.value.calculatedAmount = parseFloat(changeToRound(dispayTotal))
                                        .toFixed(2)
                                } else {
                                    salesOrderBillingTermData.value.calculatedAmount = parseFloat(dispayTotal)
                                        .toFixed(2)
                                }
                            } else {
                                if (parseFloat(item.billingPercentage) > 0) {
                                    //By Percentage
                                    let calculatedPercentage = 0
                                    calculatedPercentage = (parseFloat(item.billingPercentage / 100) * parseFloat(dynamicCalculation[allCodeData[0]]))
                                    dynamicCalculation[item.calCodeLabel] = calculatedPercentage
                                    dispayTotal = parseFloat(calculatedPercentage)
                                        .toFixed(2)
                                }

                                if (parseFloat(item.billingValue) > 0) {
                                    //By Value
                                    dynamicCalculation[item.calCodeLabel] = parseFloat(item.billingValue)
                                    dispayTotal = parseFloat(item.billingValue)
                                        .toFixed(2)
                                }

                                if (item.calCodeLabel === 'GRD') {
                                    salesOrderBillingTermData.value.calculatedAmount = changeToRound(parseFloat(dispayTotal))
                                } else {
                                    salesOrderBillingTermData.value.calculatedAmount = dispayTotal
                                }
                            }
                        }
                    }

                    if (currentRoundingType.value === '2') {
                        if (item.calCodeLabel === 'BAS') {
                            dynamicCalculation[item.calCodeLabel] = netAmount
                            item.calculateAmount = parseFloat(netAmount)
                                .toFixed(2)
                            salesOrderBillingTermData.value.calCode = item.calCode
                            salesOrderBillingTermData.value.calCodeLabel = item.calCodeLabel
                            salesOrderBillingTermData.value.calDefination = item.calDefination
                            salesOrderBillingTermData.value.billingName = item.billingName
                            salesOrderBillingTermData.value.billingNarration = item.billingNarration
                            salesOrderBillingTermData.value.billingType = item.billingType
                            salesOrderBillingTermData.value.billingPercentage = item.billingPercentage
                            salesOrderBillingTermData.value.billingValue = item.billingValue
                            salesOrderBillingTermData.value.calculatedAmount = parseFloat(changeToRound(netAmount))
                                .toFixed(2)
                            salesOrderBillingTermData.value.srNo = key
                        } else {
                            dynamicCalculation[item.calCodeLabel] = newAmount
                            salesOrderBillingTermData.value.calCode = item.calCode
                            salesOrderBillingTermData.value.calCodeLabel = item.calCodeLabel
                            salesOrderBillingTermData.value.calDefination = item.calDefination
                            salesOrderBillingTermData.value.billingName = item.billingName
                            salesOrderBillingTermData.value.billingNarration = item.billingNarration
                            salesOrderBillingTermData.value.billingType = item.billingType
                            salesOrderBillingTermData.value.billingPercentage = item.billingPercentage
                            salesOrderBillingTermData.value.billingValue = item.billingValue
                            salesOrderBillingTermData.value.calculatedAmount = parseFloat(changeToRound(netAmount))
                                .toFixed(2)
                            salesOrderBillingTermData.value.srNo = key

                            let allCodeData = item.calDefination.split('+'),
                                dispayTotal = 0.00
                            if (allCodeData.length > 1) {
                                let calTotal = 0.00
                                for (let i = 0; i < allCodeData.length; i++) {
                                    calTotal += dynamicCalculation[allCodeData[i]]
                                }
                                dynamicCalculation[item.calCodeLabel] = calTotal
                                dispayTotal = parseFloat(calTotal)
                                    .toFixed(2)
                                salesOrderBillingTermData.value.calculatedAmount = parseFloat(changeToRound(dispayTotal))
                                    .toFixed(2)
                            } else {
                                if (parseFloat(item.billingPercentage) > 0) {
                                    //By Percentage
                                    let calculatedPercentage = 0
                                    calculatedPercentage = (parseFloat(item.billingPercentage / 100) * parseFloat(dynamicCalculation[allCodeData[0]]))
                                    dynamicCalculation[item.calCodeLabel] = calculatedPercentage
                                    dispayTotal = parseFloat(calculatedPercentage)
                                        .toFixed(2)
                                }

                                if (parseFloat(item.billingValue) > 0) {
                                    //By Value
                                    dynamicCalculation[item.calCodeLabel] = parseFloat(item.billingValue)
                                    dispayTotal = parseFloat(item.billingValue)
                                        .toFixed(2)
                                }
                                salesOrderBillingTermData.value.calculatedAmount = parseFloat(changeToRound(dispayTotal))
                                    .toFixed(2)
                            }
                        }
                    }

                    newBillingTerm.value.push(salesOrderBillingTermData.value)
                    resetBillingFormData()
                })
                await axios.post('/api/sales-order-bulk-insert-billing-term', {
                    billingTerm: newBillingTerm.value
                })
                    .then(() => {
                        refetchBillingTermData()
                    })
                    .catch(() => {
                        alert('INTERNAL SERVER ERROR')
                    })
            }
        }
        refetchBillingTerm()

        return {
            CurrentSalesOrderId,
            BillingTermFields,
            listOfBillingTerm,
            salesOrderBillingTermData,
            refetchBillingTermData,
            resetBillingFormData,
            editSalesOrderItemBillingTerm,
            BillingTermOptions,
            isBillingValueShow,
            isBillingPercentShow,
            required,
            modalTableFields,
            getTemplate,
            getTemplateFromParty,
            itemDetails,
            handelOk,
            resetModalData,
            isBusy,
            refetchBillingTerm,
            onRowSelected
        }
    },
}
</script>

<style lang="scss">
@import '~@core/scss/vue/libs/vue-select.scss';
</style>
