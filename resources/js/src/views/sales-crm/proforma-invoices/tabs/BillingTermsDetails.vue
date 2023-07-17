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
            <template #cell(itemName)="data">
                <span class="text-nowrap">{{ data.value}}</span>
            </template>

            <!-- A custom formatted column -->
            <template #cell(itemUom)="data">
                <span class="text-nowrap">{{ getUomName(data.value)}}</span>
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
                                v-model="piBillingTermData.calCodeLabel"
                                disabled
                            />
                        </b-form-group>
                        <b-form-group
                            label="Description"
                            label-for="description"
                        >
                            <b-form-input
                                id="description"
                                v-model="piBillingTermData.billingName"
                                disabled
                            />
                        </b-form-group>
                        <b-form-group
                            label="Narration"
                            label-for="narration"
                        >
                            <b-form-input
                                id="narration"
                                v-model="piBillingTermData.billingNarration"
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
                                v-model="piBillingTermData.calDefination"
                                disabled
                            />
                        </b-form-group>
                        <div v-if="isBillingPercentShow">
                            <b-form-group
                                label="Percentage(%)"
                                label-for="billingPercentage"
                            >
                                <b-form-input
                                    id="billingPercentage"
                                    v-model="piBillingTermData.billingPercentage"
                                    type="number"
                                />
                            </b-form-group>
                        </div>
                        <div v-if="isBillingValueShow">
                            <b-form-group
                                label="Value"
                                label-for="billingValue"
                            >
                                <b-form-input
                                    id="billingValue"
                                    v-model="piBillingTermData.billingValue"
                                    type="number"
                                />
                            </b-form-group>
                        </div>
                    </b-col>
                </b-row>
                <b-row>
                    <!-- submit and reset -->
                    <b-col>
                        <b-button
                            v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                            type="submit"
                            variant="primary"
                            class="mr-1"
                            @click.prevent="validationForm"
                        >
                            Add / Save Billing Term
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
            scrollable
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
                <<!--template #cell(action)="data">
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
    import {ValidationProvider, ValidationObserver} from 'vee-validate'
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
        BSpinner,
        BFormCheckbox
    } from 'bootstrap-vue'
    import {required} from '@validations'
    import Ripple from 'vue-ripple-directive'
    import vSelect from 'vue-select'
    import router from '@/router'
    import store from '@/store'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import {ref, computed, onUnmounted} from '@vue/composition-api'
    import salesStoreModule from '../../salesStoreModule'
    import axios from '@axios'

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
            BSpinner,
            BFormCheckbox
        },
        directives: {
            Ripple,
        },
        methods: {
            validationForm() {
                this.$refs.simpleRules.validate().then(success => {
                    if (success) {
                        const hasIdExist = this.containsKey(this.piBillingTermData, '_id')
                        if (hasIdExist) {
                            this.piBillingTermData.id = this.piBillingTermData._id
                            delete this.piBillingTermData._id
                            store.dispatch('pi-order-module/updatePiBillingTerms', this.piBillingTermData).then(response => {
                                if (response.status === 200) {
                                    this.resetBillingFormData()
                                    this.refetchBillingTerm()
                                    this.$toast({
                                        component: ToastificationContent,
                                        position: 'top-right',
                                        props: {
                                            title: 'Term Edited',
                                            icon: 'CheckSquareIcon',
                                            variant: 'success',
                                            text: `You have successfully Edited Term : ${this.piBillingTermData.billingName}.`,
                                        },
                                    })
                                }
                            })
                        } else {
                            store.dispatch('pi-order-module/addPiBillingTerms', this.piBillingTermData).then(response => {
                                if (response.status === 200) {
                                    this.resetBillingFormData()
                                    this.refetchBillingTerm()
                                    this.$toast({
                                        component: ToastificationContent,
                                        position: 'top-right',
                                        props: {
                                            title: 'Term Created',
                                            icon: 'CheckSquareIcon',
                                            variant: 'success',
                                            text: `You have successfully Created New Term : ${this.piBillingTermData.billingName}.`,
                                        },
                                    })
                                }
                            })
                        }
                    }
                })
            },
            containsKey(obj, key) {
                return Object.keys(obj).includes(key)
            },
            deleteSalesOrderBillingTerm(id) {
                this.$swal({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    customClass: {
                        confirmButton: 'btn btn-primary',
                        cancelButton: 'btn btn-outline-danger ml-1',
                    },
                    buttonsStyling: false,
                }).then(result => {
                    if (result.value) {
                        store.dispatch(`pi-order-module/deletePiBillingTerms`, {id}).then(response => {
                            if (response.data.status === 200) {
                                this.resetBillingFormData()
                                this.refetchBillingTerm()
                                this.$toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: `Deleted`,
                                        icon: 'CheckSquareIcon',
                                        variant: 'success',
                                        text: `Term Deleted Successfully`,
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
        props: {
            pInvoiceNo: String,
            pInvoiceCustomerID: String
        },
        setup(props) {
            const PIB_APP_STORE_MODULE_NAME = 'pi-order-module'
            // Register module
            if (!store.hasModule(PIB_APP_STORE_MODULE_NAME)) store.registerModule(PIB_APP_STORE_MODULE_NAME, salesStoreModule)
            // UnRegister on leave
            onUnmounted(() => {
                if (store.hasModule(PIB_APP_STORE_MODULE_NAME)) store.unregisterModule(PIB_APP_STORE_MODULE_NAME)
            })

            const CurrentPiId = ref(router.currentRoute.params.id)
            const CurrentPinvoiceNo = computed(() => props.pInvoiceNo)
            const pCustomerID = computed(() => props.pInvoiceCustomerID)
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
            const isBusy = ref(true)

            const listOfBillingTerm = ref([])

            const refetchBillingTermData = async () => {
                isBusy.value = true
                await axios.get(`/api/get-pi-billing-terms/${CurrentPiId.value}`).then(res => {
                    listOfBillingTerm.value = res.data.data
                })
                isBusy.value = false
            }

            axios.get('/api/get-billing-master-options').then(res => {
                BillingTermOptions.value = res.data.data
            })

            const piBillingTermData = ref({
                id: null,
                pInvoiceId: CurrentPiId.value,
                calCode: null,
                calCodeLabel: null,
                calDefination: null,
                billingId: null,
                billingName: null,
                billingType: null,
                billingPercentage: null,
                billingValue: null,
                billingNarration: null,
                calculatedAmount: null,
            })

            const onRowSelected = (items) => {
                if (items.length > 0) {
                    piBillingTermData.value._id = items[0]._id
                    piBillingTermData.value.pInvoiceId = items[0].pInvoiceId
                    piBillingTermData.value.calCodeLabel = items[0].calCodeLabel ?? null
                    piBillingTermData.value.calDefination = items[0].calDefination ?? null
                    piBillingTermData.value.billingId = items[0].billingId ?? null
                    piBillingTermData.value.billingName = items[0].billingName ?? null
                    piBillingTermData.value.billingType = items[0].billingType ?? null
                    piBillingTermData.value.billingPercentage = items[0].billingPercentage ?? null
                    piBillingTermData.value.billingValue = items[0].billingValue ?? null
                    piBillingTermData.value.billingPercentage = items[0].billingPercentage ?? null
                    piBillingTermData.value.billingNarration = items[0].billingNarration ?? null
                    piBillingTermData.value.calculatedAmount = items[0].calculatedAmount ?? null
                    isBillingPercentShow.value = piBillingTermData.value.billingType === 0;
                    isBillingValueShow.value = piBillingTermData.value.billingType === 1;
                } else {
                    resetBillingFormData()
                }
            }

            const resetBillingFormData = () => {
                piBillingTermData.value = {
                    id: null,
                    pInvoiceId: CurrentPiId.value,
                    calCode: null,
                    calCodeLabel: null,
                    calDefination: null,
                    billingId: null,
                    billingName: null,
                    billingType: null,
                    billingPercentage: null,
                    billingValue: null,
                    billingNarration: null,
                    calculatedAmount: null,
                }
                isBillingPercentShow.value = false
                isBillingValueShow.value = false
            }

            const itemDetails = ref([])

            const getTemplateFromParty = async (e) => {
                e.preventDefault()
                await axios.get('/api/get-proforma-invoice-items/'.concat(CurrentPiId.value)).then(res => {
                    itemDetails.value = res.data.data
                })
                let netAmount = 0.00
                itemDetails.value.forEach((item) => {
                    netAmount += parseFloat(item.itemNetAmount)
                })
                let dynamicCalculation = []
                await axios.delete('/api/delete-old-proforma-billing-terms/'.concat(CurrentPiId.value))
                await axios.get('/api/party/get-party-billing-term/'.concat(pCustomerID.value)).then(res => {
                    if (res.data.data.length > 0) {
                        res.data.data.forEach((item) => {
                            let newAmount = 0.00
                            if (itemDetails.value.length > 0) {
                                if (item.calCodeLabel === "BAS") {
                                    dynamicCalculation[item.calCodeLabel] = netAmount
                                    item.calculateAmount = parseFloat(netAmount).toFixed(2)
                                    piBillingTermData.value.calCode = item.calCode
                                    piBillingTermData.value.calCodeLabel = item.calCodeLabel
                                    piBillingTermData.value.calDefination = item.calDefination
                                    piBillingTermData.value.billingName = item.description
                                    piBillingTermData.value.billingNarration = item.narration
                                    piBillingTermData.value.billingType = item.type
                                    piBillingTermData.value.billingPercentage = item.percentage
                                    piBillingTermData.value.billingValue = item.byValue
                                    piBillingTermData.value.calculatedAmount = parseFloat(netAmount).toFixed(2)
                                } else {
                                    dynamicCalculation[item.calCodeLabel] = newAmount
                                    piBillingTermData.value.calCode = item.calCode
                                    piBillingTermData.value.calCodeLabel = item.calCodeLabel
                                    piBillingTermData.value.calDefination = item.calDefination
                                    piBillingTermData.value.billingName = item.description
                                    piBillingTermData.value.billingNarration = item.narration
                                    piBillingTermData.value.billingType = item.type
                                    piBillingTermData.value.billingPercentage = item.percentage
                                    piBillingTermData.value.billingValue = item.byValue
                                    piBillingTermData.value.calculatedAmount = parseFloat(netAmount).toFixed(2)

                                    let allCodeData = item.calDefination.split('+'), dispayTotal = 0.00
                                    if (allCodeData.length > 1) {
                                        let calTotal = 0.00
                                        for (let i = 0; i < allCodeData.length; i++) {
                                            calTotal += dynamicCalculation[allCodeData[i]]
                                        }
                                        dynamicCalculation[item.calCodeLabel] = calTotal
                                        dispayTotal = parseFloat(calTotal).toFixed(2)
                                        piBillingTermData.value.calculatedAmount = parseFloat(dispayTotal).toFixed(2)
                                    } else {
                                        if (item.type === 0) {
                                            //By Percentage
                                            let calculatedPercentage = 0
                                            calculatedPercentage = (parseFloat(item.percentage / 100) * parseFloat(dynamicCalculation[allCodeData[0]]))
                                            dynamicCalculation[item.calCodeLabel] = calculatedPercentage
                                            dispayTotal = parseFloat(calculatedPercentage).toFixed(2)
                                        }

                                        if (item.type === 1) {
                                            //By Value
                                            dynamicCalculation[item.calCodeLabel] = parseFloat(item.byValue)
                                            dispayTotal = parseFloat(item.byValue).toFixed(2)
                                        }
                                        piBillingTermData.value.calculatedAmount = dispayTotal
                                    }
                                }
                            } else {
                                piBillingTermData.value.calCode = item.calCode
                                piBillingTermData.value.calCodeLabel = item.calCodeLabel
                                piBillingTermData.value.calDefination = item.calDefination
                                piBillingTermData.value.billingName = item.description
                                piBillingTermData.value.billingNarration = item.narration
                                piBillingTermData.value.billingType = item.type
                                piBillingTermData.value.billingPercentage = item.percentage
                                piBillingTermData.value.billingValue = item.byValue
                                piBillingTermData.value.calculatedAmount = parseFloat(newAmount).toFixed(2)
                            }
                            store.dispatch('pi-order-module/addPiBillingTerms', piBillingTermData.value)
                        })
                    }
                })
                await refetchBillingTermData()
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
            axios.get('/api/billing-template-master').then(res => {
                modalTableFields.value.billingModalData = res.data.data
            })

            const getTemplate = (data) => {
                modalTableFields.value.templateData = data.billing_items
            }

            const handelOk = async () => {
                await axios.get('/api/get-proforma-invoice-items/'.concat(CurrentPiId.value)).then(res => {
                    itemDetails.value = res.data.data
                })
                let netAmount = 0.00
                itemDetails.value.forEach((item) => {
                    netAmount += parseFloat(item.itemNetAmount)
                })
                let dynamicCalculation = []
                await axios.delete('/api/delete-old-proforma-billing-terms/'.concat(CurrentPiId.value))
                modalTableFields.value.templateData.forEach((item) => {
                    let newAmount = 0.00
                    if (itemDetails.value.length > 0) {
                        if (item.calCodeLabel === "BAS") {
                            dynamicCalculation[item.calCodeLabel] = netAmount
                            item.calculateAmount = parseFloat(netAmount).toFixed(2)
                            piBillingTermData.value.calCode = item.calCode
                            piBillingTermData.value.calCodeLabel = item.calCodeLabel
                            piBillingTermData.value.calDefination = item.calDefination
                            piBillingTermData.value.billingName = item.description
                            piBillingTermData.value.billingNarration = item.narration
                            piBillingTermData.value.billingType = item.type
                            piBillingTermData.value.billingPercentage = item.percentage
                            piBillingTermData.value.billingValue = item.byValue
                            piBillingTermData.value.calculatedAmount = parseFloat(netAmount).toFixed(2)
                        } else {
                            dynamicCalculation[item.calCodeLabel] = newAmount
                            piBillingTermData.value.calCode = item.calCode
                            piBillingTermData.value.calCodeLabel = item.calCodeLabel
                            piBillingTermData.value.calDefination = item.calDefination
                            piBillingTermData.value.billingName = item.description
                            piBillingTermData.value.billingNarration = item.narration
                            piBillingTermData.value.billingType = item.type
                            piBillingTermData.value.billingPercentage = item.percentage
                            piBillingTermData.value.billingValue = item.byValue
                            piBillingTermData.value.calculatedAmount = parseFloat(netAmount).toFixed(2)

                            let allCodeData = item.calDefination.split('+'), dispayTotal = 0.00
                            if (allCodeData.length > 1) {
                                let calTotal = 0.00
                                for (let i = 0; i < allCodeData.length; i++) {
                                    calTotal += dynamicCalculation[allCodeData[i]]
                                }
                                dynamicCalculation[item.calCodeLabel] = calTotal
                                dispayTotal = parseFloat(calTotal).toFixed(2)
                                piBillingTermData.value.calculatedAmount = parseFloat(dispayTotal).toFixed(2)
                            } else {
                                if (item.type === 0) {
                                    //By Percentage
                                    let calculatedPercentage = 0
                                    calculatedPercentage = (parseFloat(item.percentage / 100) * parseFloat(dynamicCalculation[allCodeData[0]]))
                                    dynamicCalculation[item.calCodeLabel] = calculatedPercentage
                                    dispayTotal = parseFloat(calculatedPercentage).toFixed(2)
                                }

                                if (item.type === 1) {
                                    //By Value
                                    dynamicCalculation[item.calCodeLabel] = parseFloat(item.byValue)
                                    dispayTotal = parseFloat(item.byValue).toFixed(2)
                                }
                                piBillingTermData.value.calculatedAmount = dispayTotal
                            }
                        }
                    } else {
                        piBillingTermData.value.calCode = item.calCode
                        piBillingTermData.value.calCodeLabel = item.calCodeLabel
                        piBillingTermData.value.calDefination = item.calDefination
                        piBillingTermData.value.billingName = item.description
                        piBillingTermData.value.billingNarration = item.narration
                        piBillingTermData.value.billingType = item.type
                        piBillingTermData.value.billingPercentage = item.percentage
                        piBillingTermData.value.billingValue = item.byValue
                        piBillingTermData.value.calculatedAmount = parseFloat(newAmount).toFixed(2)
                    }
                    store.dispatch('pi-order-module/addPiBillingTerms', piBillingTermData.value)
                })

                await refetchBillingTermData()
                resetModalData()
            }

            const resetModalData = () => {
                modalTableFields.value.templateData = []
            }

            const refetchBillingTerm = async () => {
                await axios.get('/api/get-proforma-invoice-items/'.concat(CurrentPiId.value)).then(res => {
                    itemDetails.value = res.data.data
                })
                let netAmount = 0.00
                itemDetails.value.forEach((item) => {
                    netAmount += parseFloat(item.itemNetAmount)
                })
                let dynamicCalculation = []
                let billingTerms = []
                await axios.get('/api/get-pi-billing-terms/'.concat(CurrentPiId.value)).then(res => {
                    billingTerms = res.data.data
                })
                await axios.delete('/api/delete-old-proforma-billing-terms/'.concat(CurrentPiId.value))
                if (billingTerms.length > 0){
                    billingTerms.forEach((item) => {
                        let newAmount = 0.00
                        if (item.calCodeLabel === "BAS") {
                            dynamicCalculation[item.calCodeLabel] = netAmount
                            item.calculateAmount = parseFloat(netAmount).toFixed(2)
                            piBillingTermData.value.calCode = item.calCode
                            piBillingTermData.value.calCodeLabel = item.calCodeLabel
                            piBillingTermData.value.calDefination = item.calDefination
                            piBillingTermData.value.billingName = item.billingName
                            piBillingTermData.value.billingNarration = item.billingNarration
                            piBillingTermData.value.billingType = item.billingType
                            piBillingTermData.value.billingPercentage = item.billingPercentage
                            piBillingTermData.value.billingValue = item.billingValue
                            piBillingTermData.value.calculatedAmount = parseFloat(netAmount).toFixed(2)
                        } else {
                            dynamicCalculation[item.calCodeLabel] = newAmount
                            piBillingTermData.value.calCode = item.calCode
                            piBillingTermData.value.calCodeLabel = item.calCodeLabel
                            piBillingTermData.value.calDefination = item.calDefination
                            piBillingTermData.value.billingName = item.billingName
                            piBillingTermData.value.billingNarration = item.billingNarration
                            piBillingTermData.value.billingType = item.billingType
                            piBillingTermData.value.billingPercentage = item.billingPercentage
                            piBillingTermData.value.billingValue = item.billingValue
                            piBillingTermData.value.calculatedAmount = parseFloat(netAmount).toFixed(2)

                            let allCodeData = item.calDefination.split('+'), dispayTotal = 0.00
                            if (allCodeData.length > 1) {
                                let calTotal = 0.00
                                for (let i = 0; i < allCodeData.length; i++) {
                                    calTotal += dynamicCalculation[allCodeData[i]]
                                }
                                dynamicCalculation[item.calCodeLabel] = calTotal
                                dispayTotal = parseFloat(calTotal).toFixed(2)
                                piBillingTermData.value.calculatedAmount = parseFloat(dispayTotal).toFixed(2)
                            } else {
                                if (item.billingType === 0) {
                                    //By Percentage
                                    let calculatedPercentage = 0
                                    calculatedPercentage = (parseFloat(item.billingPercentage / 100) * parseFloat(dynamicCalculation[allCodeData[0]]))
                                    dynamicCalculation[item.calCodeLabel] = calculatedPercentage
                                    dispayTotal = parseFloat(calculatedPercentage).toFixed(2)
                                }

                                if (item.billingType === 1) {
                                    //By Value
                                    dynamicCalculation[item.calCodeLabel] = parseFloat(item.billingValue)
                                    dispayTotal = parseFloat(item.billingValue).toFixed(2)
                                }
                                piBillingTermData.value.calculatedAmount = dispayTotal
                            }
                        }
                        store.dispatch('pi-order-module/addPiBillingTerms', piBillingTermData.value)
                    })
                    resetBillingFormData()
                }
                await refetchBillingTermData()
            }
            refetchBillingTerm()

            return {
                CurrentPiId,
                CurrentPinvoiceNo,
                pCustomerID,
                BillingTermFields,
                listOfBillingTerm,
                piBillingTermData,
                refetchBillingTermData,
                resetBillingFormData,
                BillingTermOptions,
                isBillingValueShow,
                isBillingPercentShow,
                required,
                isBusy,
                itemDetails,
                getTemplateFromParty,
                modalTableFields,
                getTemplate,
                handelOk,
                resetModalData,
                refetchBillingTerm,
                onRowSelected
            }
        },
    }
</script>

<style lang="scss">
    @import '~@core/scss/vue/libs/vue-select.scss';
</style>
