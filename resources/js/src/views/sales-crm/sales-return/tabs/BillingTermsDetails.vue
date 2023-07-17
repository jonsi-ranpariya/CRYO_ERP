<template>
    <div>
        <b-row>
            <b-col md="12">
                <hr>
                <h6>Change Billing Term</h6>
                <hr>
            </b-col>
            <b-col md="12">

                <b-form-group
                    label="Billing Term"
                    label-for="billing-term"
                >
                    <v-select
                        placeholder="Select Billing Term To Change"
                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                        :options="billingOptions"
                        :clearable="false"
                        input-id="billing-term"
                        :reduce="val => val.value"
                        v-on:input="getBillingTermFromTemplateDetail($event)"
                    />

                </b-form-group>
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
            class="table_scroll"
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
            <template #cell(srNo)="data">
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
                                v-model="srBillingTermData.calCodeLabel"
                                disabled
                            />
                        </b-form-group>
                        <b-form-group
                            label="Description"
                            label-for="description"
                        >
                            <b-form-input
                                id="description"
                                v-model="srBillingTermData.description"
                            />
                        </b-form-group>
                        <b-form-group
                            label="Narration"
                            label-for="narration"
                        >
                            <b-form-input
                                id="narration"
                                v-model="srBillingTermData.narration"
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
                                v-model="srBillingTermData.calDefination"
                            />
                        </b-form-group>
                        <div v-if="isBillingPercentShow">
                            <b-form-group
                                label="Percentage(%)"
                                label-for="billingPercentage"
                            >
                                <b-form-input
                                    id="billingPercentage"
                                    v-model="srBillingTermData.percentage"
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
                                    v-model="srBillingTermData.byValue"
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
                            Save
                        </b-button>
                    </b-col>
                </b-row>
            </b-form>
        </validation-observer>

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
    BSpinner
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
import {changeAmountDecimalPoint, changeToRound} from "@core/utils/utils";

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
        BSpinner
    },
    directives: {
        Ripple,
    },
    methods: {
        validationForm() {
            this.$refs.simpleRules.validate().then(success => {
                if (success) {
                    const hasIdExist = this.containsKey(this.srBillingTermData, '_id')
                    if (hasIdExist) {
                        this.srBillingTermData.id = this.srBillingTermData._id
                        delete this.srBillingTermData._id
                        store.dispatch('sr-billing-module/updateSrBillingTerms', this.srBillingTermData).then(response => {
                            if (response.status === 200) {
                                this.resetBillingFormData()
                                this.refetchBillingTermData()
                                this.$toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: 'Term Edited',
                                        icon: 'CheckSquareIcon',
                                        variant: 'success',
                                        text: `You have successfully Edited Term : ${this.srBillingTermData.billingName}.`,
                                    },
                                })
                            }
                        })
                    } else {
                        store.dispatch('sr-billing-module/addSrBillingTerms', this.srBillingTermData).then(response => {
                            if (response.status === 200) {
                                this.resetBillingFormData()
                                this.refetchBillingTermData()
                                this.$toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: 'Term Created',
                                        icon: 'CheckSquareIcon',
                                        variant: 'success',
                                        text: `You have successfully Created New Term : ${this.srBillingTermData.billingName}.`,
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
                    store.dispatch(`sr-billing-module/deleteSrBillingTerms`, {id}).then(response => {
                        if (response.data.status === 200) {
                            this.refetchBillingTermData()
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
    props: ['salesReturnCustomerID', 'salesReturnRoundingType'],
    setup(props) {
        const SRB_APP_STORE_MODULE_NAME = 'sr-billing-module'
        // Register module
        if (!store.hasModule(SRB_APP_STORE_MODULE_NAME)) store.registerModule(SRB_APP_STORE_MODULE_NAME, salesStoreModule)
        // UnRegister on leave
        onUnmounted(() => {
            if (store.hasModule(SRB_APP_STORE_MODULE_NAME)) store.unregisterModule(SRB_APP_STORE_MODULE_NAME)
        })

        const totalAmount = ref(0.00)
        const currentPartyId = computed(() => props.salesReturnCustomerID)
        const roundingType = computed(() => props.salesReturnRoundingType)

        const CurrentSrId = ref(router.currentRoute.params.id)
        const isBillingValueShow = ref(false)
        const isBillingPercentShow = ref(false)
        const BillingTermOptions = ref([])
        const billingOptions = ref([])
        const isBusy = ref(true)
        const BillingTermFields = ref([
            {
                key: 'rowSelected',
                label: ''
            },
            {
                key: 'srNo',
                label: 'No',
            },
            {
                key: 'calCodeLabel',
                label: 'Code',
            },
            {
                key: 'description',
                label: 'Name',
            },
            {
                key: 'calDefination',
                label: 'Defination',
            },
            {
                key: 'percentage',
                label: 'Percent (%)',
            },
            {
                key: 'byValue',
                label: 'Value',
            },
            {
                key: 'total_amount',
                label: 'Amount',
            },
            {
                key: 'action',
                label: 'action',
            },
        ])

        axios.get('/api/get-billing-template-master-options').then(res => {
            billingOptions.value = res.data.data
        })

        const listOfBillingTerm = ref([])

        const refetchBillingTermData = async () => {
            isBusy.value = true
            await axios.get(`/api/get-sr-billing-terms/${CurrentSrId.value}`).then(res => {
                listOfBillingTerm.value = res.data.data
            })
            isBusy.value = false
        }

        axios.get('/api/get-billing-master-options').then(res => {
            BillingTermOptions.value = res.data.data
        })

        const srBillingTermData = ref({
            id: null,
            salesReturnId: CurrentSrId.value,
            calCode: null,
            calCodeLabel: null,
            calDefination: null,
            percentage: null,
            byValue: null,
            operation: null,
            narration: null,
            type: null,
            total_amount: null,
        })

        const onRowSelected = (items) => {
            if (items.length > 0) {
                srBillingTermData.value._id = items[0]._id
                srBillingTermData.value.salesOrderId = items[0].salesOrderId
                srBillingTermData.value.calCode = items[0].calCode ?? null
                srBillingTermData.value.calCodeLabel = items[0].calCodeLabel ?? null
                srBillingTermData.value.calDefination = items[0].calDefination ?? null
                srBillingTermData.value.percentage = items[0].percentage ?? null
                srBillingTermData.value.byValue = items[0].byValue ?? null
                srBillingTermData.value.operation = items[0].operation ?? null
                srBillingTermData.value.narration = items[0].narration ?? null
                srBillingTermData.value.type = items[0].type ?? null
                srBillingTermData.value.total_amount = items[0].total_amount ?? null
                isBillingPercentShow.value = srBillingTermData.value.type === 0;
                isBillingValueShow.value = srBillingTermData.value.type === 1;
            } else {
                resetBillingFormData()
            }
        }

        const resetBillingFormData = () => {
            srBillingTermData.value = {
                id: null,
                salesReturnId: CurrentSrId.value,
                calCode: null,
                calCodeLabel: null,
                calDefination: null,
                percentage: null,
                byValue: null,
                operation: null,
                narration: null,
                type: null,
                total_amount: null,
            }
            isBillingPercentShow.value = false
            isBillingValueShow.value = false
        }

        const getBillingTermDetails = async (val) => {
            await axios.get(`/api/billing-master/${val}`).then(res => {
                srBillingTermData.value.billingName = res.data.data.name
                if (res.data.data.valueType) {
                    srBillingTermData.value.billingType = res.data.data.valueType.value
                    if (res.data.data.valueType.value === 0) {
                        isBillingPercentShow.value = true
                        srBillingTermData.value.billingPercentage = res.data.data.defaultValue
                    } else {
                        isBillingPercentShow.value = false
                        srBillingTermData.value.billingPercentage = ref(0.00)
                    }
                    if (res.data.data.valueType.value === 1) {
                        isBillingValueShow.value = true
                        srBillingTermData.value.billingValue = res.data.data.defaultValue
                    } else {
                        isBillingValueShow.value = false
                        srBillingTermData.value.billingValue = ref(0.00)
                    }
                }
            })
        }

        const getBillingTermFromTemplateDetail = async (val) => {
            await axios.delete(`/api/delete-current-billing-term/${CurrentSrId.value}`)

            await axios.get(`/api/billing-template-master/${val}`).then(res => {
                if (res.data.data.billing_items) {
                    const calculationCodes = []
                    res.data.data.billing_items.forEach((billingData, key) => {
                        const myBillingFormData = {
                            id: null,
                            salesReturnId: CurrentSrId.value,
                            calCode: null,
                            calCodeLabel: null,
                            calDefination: null,
                            percentage: null,
                            byValue: null,
                            operation: null,
                            narration: null,
                            type: null,
                            total_amount: null,
                            srNo: key + 1,
                        }

                        if (roundingType.value === '0') {
                            if (billingData.calCodeLabel === 'BAS') {
                                calculationCodes[billingData.calCodeLabel] = totalAmount.value
                                myBillingFormData.calCode = billingData.calCode
                                myBillingFormData.calCodeLabel = billingData.calCodeLabel
                                myBillingFormData.description = billingData.description
                                myBillingFormData.calDefination = billingData.calDefination
                                myBillingFormData.percentage = billingData.percentage
                                myBillingFormData.byValue = billingData.byValue
                                myBillingFormData.operation = billingData.operation
                                myBillingFormData.narration = billingData.narration
                                myBillingFormData.type = billingData.type
                                myBillingFormData.total_amount = parseFloat(totalAmount.value).toFixed(2)
                            } else {
                                let dispayTotal = 0.00
                                calculationCodes[billingData.calCodeLabel] = dispayTotal
                                const AllcodeData = billingData.calDefination.split('+')
                                const billingDefLength = AllcodeData.length;

                                if (billingDefLength > 1) {
                                    let CalTotal = 0
                                    for (let i = 0; i < AllcodeData.length; i++) {
                                        CalTotal += parseFloat(calculationCodes[AllcodeData[i]])
                                    }
                                    calculationCodes[billingData.calCodeLabel] = CalTotal
                                    dispayTotal = CalTotal
                                } else {
                                    if (billingData.type === 0) {
                                        //By Percentage
                                        let calculatedPercentage = 0
                                        calculatedPercentage = ((parseFloat(billingData.percentage) / 100) * parseFloat(calculationCodes[AllcodeData[0]]))
                                        calculationCodes[billingData.calCodeLabel] = parseFloat(calculatedPercentage)
                                        dispayTotal = calculatedPercentage
                                    } else if (billingData.type === 1) {
                                        //By Value
                                        calculationCodes[billingData.calCodeLabel] = parseFloat(billingData.byValue)
                                        dispayTotal = parseFloat(billingData.byValue)
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
                                myBillingFormData.total_amount = parseFloat(dispayTotal).toFixed(2)
                            }
                        }

                        if (roundingType.value === '1') {
                            if (billingData.calCodeLabel === 'BAS') {
                                calculationCodes[billingData.calCodeLabel] = totalAmount.value
                                myBillingFormData.calCode = billingData.calCode
                                myBillingFormData.calCodeLabel = billingData.calCodeLabel
                                myBillingFormData.description = billingData.description
                                myBillingFormData.calDefination = billingData.calDefination
                                myBillingFormData.percentage = billingData.percentage
                                myBillingFormData.byValue = billingData.byValue
                                myBillingFormData.operation = billingData.operation
                                myBillingFormData.narration = billingData.narration
                                myBillingFormData.type = billingData.type
                                myBillingFormData.total_amount = parseFloat(totalAmount.value).toFixed(2)
                            } else {
                                let dispayTotal = 0.00
                                calculationCodes[billingData.calCodeLabel] = dispayTotal
                                const AllcodeData = billingData.calDefination.split('+')
                                const billingDefLength = AllcodeData.length;

                                if (billingDefLength > 1) {
                                    let CalTotal = 0
                                    for (let i = 0; i < AllcodeData.length; i++) {
                                        CalTotal += parseFloat(calculationCodes[AllcodeData[i]])
                                    }
                                    calculationCodes[billingData.calCodeLabel] = CalTotal
                                    dispayTotal = CalTotal
                                } else {
                                    if (billingData.type === 0) {
                                        //By Percentage
                                        let calculatedPercentage = 0
                                        calculatedPercentage = ((parseFloat(billingData.percentage) / 100) * parseFloat(calculationCodes[AllcodeData[0]]))
                                        calculationCodes[billingData.calCodeLabel] = parseFloat(calculatedPercentage)
                                        dispayTotal = calculatedPercentage
                                    } else if (billingData.type === 1) {
                                        //By Value
                                        calculationCodes[billingData.calCodeLabel] = parseFloat(billingData.byValue)
                                        dispayTotal = parseFloat(billingData.byValue)
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
                                    myBillingFormData.total_amount = changeAmountDecimalPoint(changeToRound(parseFloat(dispayTotal).toFixed(2)),2)
                                } else {
                                    myBillingFormData.total_amount = parseFloat(dispayTotal).toFixed(2)
                                }
                            }
                        }

                        if (roundingType.value === '2') {
                            if (billingData.calCodeLabel === 'BAS') {
                                calculationCodes[billingData.calCodeLabel] = changeToRound(totalAmount.value)
                                myBillingFormData.calCode = billingData.calCode
                                myBillingFormData.calCodeLabel = billingData.calCodeLabel
                                myBillingFormData.description = billingData.description
                                myBillingFormData.calDefination = billingData.calDefination
                                myBillingFormData.percentage = billingData.percentage
                                myBillingFormData.byValue = billingData.byValue
                                myBillingFormData.operation = billingData.operation
                                myBillingFormData.narration = billingData.narration
                                myBillingFormData.type = billingData.type
                                myBillingFormData.total_amount = changeToRound(parseFloat(totalAmount.value).toFixed(2))
                            } else {
                                let dispayTotal = 0.00
                                calculationCodes[billingData.calCodeLabel] = dispayTotal
                                const AllcodeData = billingData.calDefination.split('+')
                                const billingDefLength = AllcodeData.length;

                                if (billingDefLength > 1) {
                                    let CalTotal = 0
                                    for (let i = 0; i < AllcodeData.length; i++) {
                                        CalTotal += changeAmountDecimalPoint(changeToRound(parseFloat(calculationCodes[AllcodeData[i]])),2)
                                    }
                                    calculationCodes[billingData.calCodeLabel] = CalTotal
                                    dispayTotal = CalTotal
                                } else {
                                    if (billingData.type === 0) {
                                        //By Percentage
                                        let calculatedPercentage = 0
                                        calculatedPercentage = changeAmountDecimalPoint(changeToRound((parseFloat(billingData.percentage) / 100) * parseFloat(calculationCodes[AllcodeData[0]])),2)
                                        calculationCodes[billingData.calCodeLabel] = parseFloat(calculatedPercentage)
                                        dispayTotal = calculatedPercentage
                                    } else if (billingData.type === 1) {
                                        //By Value
                                        calculationCodes[billingData.calCodeLabel] = parseFloat(billingData.byValue)
                                        dispayTotal = parseFloat(billingData.byValue)
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
                                myBillingFormData.total_amount = changeAmountDecimalPoint(changeToRound(parseFloat(dispayTotal).toFixed(2)),2)
                            }
                        }

                        store.dispatch('sr-billing-module/addSrBillingTerms', myBillingFormData)
                    });
                }
            });

            await refetchBillingTermData();
        }

        const itemDetails = ref([])
        const refetchTermData = async (currentId) => {
            await axios.get(`/api/get-sales-return-items/${currentId}`).then(res => {
                itemDetails.value = res.data.data
            });

            await itemDetails.value.forEach((item) => {
                totalAmount.value += item.itemAmount
            });

            let billingTermData = []
            await axios.get(`/api/get-sr-billing-terms/${currentId}`).then(res => {
                billingTermData = res.data.data
            });

            await axios.delete(`/api/delete-current-billing-term/${currentId}`);
            const calculationCodes = []

            if (billingTermData.length > 0) {
                await billingTermData.forEach((billingData, key) => {
                    const myBillingFormData = {
                        id: null,
                        salesReturnId: currentId,
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

                    if (roundingType.value === '0') {
                        if (billingData.calCodeLabel === 'BAS') {
                            calculationCodes[billingData.calCodeLabel] = totalAmount.value
                            myBillingFormData.calCode = billingData.calCode
                            myBillingFormData.calCodeLabel = billingData.calCodeLabel
                            myBillingFormData.description = billingData.description
                            myBillingFormData.calDefination = billingData.calDefination
                            myBillingFormData.percentage = billingData.percentage
                            myBillingFormData.byValue = billingData.byValue
                            myBillingFormData.operation = billingData.operation
                            myBillingFormData.narration = billingData.narration
                            myBillingFormData.type = billingData.type
                            myBillingFormData.total_amount = parseFloat(totalAmount.value).toFixed(2)
                        } else {
                            let dispayTotal = 0.00
                            calculationCodes[billingData.calCodeLabel] = dispayTotal
                            const AllcodeData = billingData.calDefination.split('+')
                            const billingDefLength = AllcodeData.length;

                            if (billingDefLength > 1) {
                                let CalTotal = 0
                                for (let i = 0; i < AllcodeData.length; i++) {
                                    CalTotal += parseFloat(calculationCodes[AllcodeData[i]])
                                }
                                calculationCodes[billingData.calCodeLabel] = CalTotal
                                dispayTotal = CalTotal
                            } else {
                                if (billingData.type === 0) {
                                    //By Percentage
                                    let calculatedPercentage = 0
                                    calculatedPercentage = ((parseFloat(billingData.percentage) / 100) * parseFloat(calculationCodes[AllcodeData[0]]))
                                    calculationCodes[billingData.calCodeLabel] = parseFloat(calculatedPercentage)
                                    dispayTotal = calculatedPercentage
                                } else if (billingData.type === 1) {
                                    //By Value
                                    calculationCodes[billingData.calCodeLabel] = parseFloat(billingData.byValue)
                                    dispayTotal = parseFloat(billingData.byValue)
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
                            myBillingFormData.total_amount = parseFloat(dispayTotal).toFixed(2)
                        }
                    }

                    if (roundingType.value === '1') {
                        if (billingData.calCodeLabel === 'BAS') {
                            calculationCodes[billingData.calCodeLabel] = totalAmount.value
                            myBillingFormData.calCode = billingData.calCode
                            myBillingFormData.calCodeLabel = billingData.calCodeLabel
                            myBillingFormData.description = billingData.description
                            myBillingFormData.calDefination = billingData.calDefination
                            myBillingFormData.percentage = billingData.percentage
                            myBillingFormData.byValue = billingData.byValue
                            myBillingFormData.operation = billingData.operation
                            myBillingFormData.narration = billingData.narration
                            myBillingFormData.type = billingData.type
                            myBillingFormData.total_amount = parseFloat(totalAmount.value).toFixed(2)
                        } else {
                            let dispayTotal = 0.00
                            calculationCodes[billingData.calCodeLabel] = dispayTotal
                            const AllcodeData = billingData.calDefination.split('+')
                            const billingDefLength = AllcodeData.length;

                            if (billingDefLength > 1) {
                                let CalTotal = 0
                                for (let i = 0; i < AllcodeData.length; i++) {
                                    CalTotal += parseFloat(calculationCodes[AllcodeData[i]])
                                }
                                calculationCodes[billingData.calCodeLabel] = CalTotal
                                dispayTotal = CalTotal
                            } else {
                                if (billingData.type === 0) {
                                    //By Percentage
                                    let calculatedPercentage = 0
                                    calculatedPercentage = ((parseFloat(billingData.percentage) / 100) * parseFloat(calculationCodes[AllcodeData[0]]))
                                    calculationCodes[billingData.calCodeLabel] = parseFloat(calculatedPercentage)
                                    dispayTotal = calculatedPercentage
                                } else if (billingData.type === 1) {
                                    //By Value
                                    calculationCodes[billingData.calCodeLabel] = parseFloat(billingData.byValue)
                                    dispayTotal = parseFloat(billingData.byValue)
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
                                myBillingFormData.total_amount = changeAmountDecimalPoint(changeToRound(parseFloat(dispayTotal).toFixed(2)),2)
                            } else {
                                myBillingFormData.total_amount = parseFloat(dispayTotal).toFixed(2)
                            }
                        }
                    }

                    if (roundingType.value === '2') {
                        if (billingData.calCodeLabel === 'BAS') {
                            calculationCodes[billingData.calCodeLabel] = changeToRound(totalAmount.value)
                            myBillingFormData.calCode = billingData.calCode
                            myBillingFormData.calCodeLabel = billingData.calCodeLabel
                            myBillingFormData.description = billingData.description
                            myBillingFormData.calDefination = billingData.calDefination
                            myBillingFormData.percentage = billingData.percentage
                            myBillingFormData.byValue = billingData.byValue
                            myBillingFormData.operation = billingData.operation
                            myBillingFormData.narration = billingData.narration
                            myBillingFormData.type = billingData.type
                            myBillingFormData.total_amount = changeToRound(parseFloat(totalAmount.value).toFixed(2))
                        } else {
                            let dispayTotal = 0.00
                            calculationCodes[billingData.calCodeLabel] = dispayTotal
                            const AllcodeData = billingData.calDefination.split('+')
                            const billingDefLength = AllcodeData.length;

                            if (billingDefLength > 1) {
                                let CalTotal = 0
                                for (let i = 0; i < AllcodeData.length; i++) {
                                    CalTotal += changeAmountDecimalPoint(changeToRound(parseFloat(calculationCodes[AllcodeData[i]])),2)
                                }
                                calculationCodes[billingData.calCodeLabel] = CalTotal
                                dispayTotal = CalTotal
                            } else {
                                if (billingData.type === 0) {
                                    //By Percentage
                                    let calculatedPercentage = 0
                                    calculatedPercentage = changeAmountDecimalPoint(changeToRound((parseFloat(billingData.percentage) / 100) * parseFloat(calculationCodes[AllcodeData[0]])),2)
                                    calculationCodes[billingData.calCodeLabel] = parseFloat(calculatedPercentage)
                                    dispayTotal = calculatedPercentage
                                } else if (billingData.type === 1) {
                                    //By Value
                                    calculationCodes[billingData.calCodeLabel] = parseFloat(billingData.byValue)
                                    dispayTotal = parseFloat(billingData.byValue)
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
                            myBillingFormData.total_amount = changeAmountDecimalPoint(changeToRound(parseFloat(dispayTotal).toFixed(2)),2)
                        }
                    }
                    axios.post('/api/sr-billing-terms', myBillingFormData)
                });
            }

            await refetchBillingTermData();
        }
        refetchTermData(CurrentSrId.value)

        return {
            CurrentSrId,
            billingOptions,
            BillingTermFields,
            listOfBillingTerm,
            srBillingTermData,
            refetchBillingTermData,
            resetBillingFormData,
            getBillingTermDetails,
            BillingTermOptions,
            isBillingValueShow,
            isBillingPercentShow,
            getBillingTermFromTemplateDetail,
            required,
            isBusy,
            roundingType,
            itemDetails,
            refetchTermData,
            currentPartyId,
            onRowSelected
        }
    },
}
</script>

<style lang="scss">
@import '~@core/scss/vue/libs/vue-select.scss';
</style>
