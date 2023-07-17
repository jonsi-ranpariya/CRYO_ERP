<template>
    <div>
        <!--table Area-->
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
                            <b-dropdown-item @click="editBillingData(data.item)">
                                <feather-icon
                                    icon="Edit2Icon"
                                    class="mr-50"
                                />
                                <span>Edit</span>
                            </b-dropdown-item>
                        </b-dropdown>
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
        <!--close table-->
        <!--Template Area-->
        <b-row>
            <b-col md="8">
                <b-form-group
                    label="Choose Billing Template"
                    label-for="billingTemplate"
                >
                    <v-select
                        id="billingTemplate"
                        v-model="billingTemplateId"
                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                        :options="billingTemplateOptions"
                        :clearable="false"
                        :reduce="val => val.value"
                        placeholder="Choose Template.."
                    />
                </b-form-group>
            </b-col>
            <b-col md="4">
                <b-button
                    type="button"
                    variant="primary"
                    class="mt-1"
                    @click="templateWiseBillingTerm"
                >
                    Update Term
                </b-button>
            </b-col>
        </b-row>
        <!--Form Area-->
        <b-form @submit.prevent="saveFormData">
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
                            v-model="formData.calCodeLabel"
                        />
                    </b-form-group>
                    <b-form-group
                        label="Description"
                        label-for="description"
                    >
                        <b-form-input
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
                        label="Defination"
                        label-for="calDefination"
                    >
                        <b-form-input
                            id="calDefination"
                            v-model="formData.calDefination"
                        />
                    </b-form-group>
                    <div v-if="isBillingPercentShow">
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
                    </div>
                    <div v-if="isBillingValueShow">
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
                    </div>
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
    BTable,
    BDropdown,
    BDropdownItem,
    BSpinner,
    BButton,
} from 'bootstrap-vue'
import { ref, computed } from '@vue/composition-api'
import Ripple from 'vue-ripple-directive'
import vSelect from 'vue-select'
import axios from '@axios'
import router from '@/router'
import { generateBillingTermFromTemplate, generateBillingTerm } from '../JobWorkOrderBillingTermHelper'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
import { useToast } from 'vue-toastification/composition'

export default {
    components: {
        BForm,
        BRow,
        BCol,
        BTable,
        BDropdown,
        BDropdownItem,
        BSpinner,
        BFormGroup,
        BFormInput,
        BButton,
        vSelect
    },
    directives: {
        Ripple,
    },
    props: {
        rounding: {
            required: true
        }
    },
    setup(props) {
        const toast = useToast()
        const isBusy = ref(false)

        const billingTemplateId = ref(null)

        const billingTemplateOptions = ref([])
        axios.get('/api/get-billing-template-master-options')
            .then((res) => {
                billingTemplateOptions.value = res.data.data
            })

        const roundingType = computed(() => props.rounding)

        const table = ref({
            fields: [
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
                    label: 'Per(%)',
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
                    label: 'Action',
                }
            ],
            data: [],
        })

        const blankFormData = {
            _id: null,
            jobWorkOrderId: router.currentRoute.params.id,
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

        const formData = ref(JSON.parse(JSON.stringify(blankFormData)))

        const resetFormData = async () => {
            formData.value = JSON.parse(JSON.stringify(blankFormData))
        }

        const onRowSelected = (items) => {
            if (items.length > 0) {
                formData.value._id = items[0]._id
                formData.value.jobWorkOrderId = items[0].jobWorkOrderId ?? null
                formData.value.calCode = items[0].calCode ?? null
                formData.value.calCodeLabel = items[0].calCodeLabel ?? null
                formData.value.calDefination = items[0].calDefination ?? null
                formData.value.percentage = items[0].percentage ?? null
                formData.value.byValue = items[0].byValue ?? null
                formData.value.narration = items[0].narration ?? null
                formData.value.type = items[0].type ?? null
                formData.value.total_amount = items[0].total_amount ?? null
            } else {
                resetFormData()
            }
        }

        const refetchData = async () => {
            isBusy.value = true
            await axios.get(`/api/get-job-work-order-billing-term/${router.currentRoute.params.id}`)
                .then((res) => {
                    table.value.data = res.data
                })
            isBusy.value = false
        }
        refetchData()

        const saveFormData = async () => {
            if (formData.value._id) {
                await axios.put(`/api/job-order-billing-term/${formData.value._id}`, formData.value)
                    .then((res) => {
                        if (res.status === 200) {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Billing Term Updated',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: `You have successfully Update Billing Term.`,
                                },
                            })
                        }
                    })
                isBillingPercentShow.value = false
                isBillingValueShow.value = false
                await resetFormData()
                await generateBillingTerm(router.currentRoute.params.id, parseInt(roundingType.value))
                await refetchData()
            }
        }

        const templateWiseBillingTerm = async () => {
            if (billingTemplateId.value === null) {
                toast({
                    component: ToastificationContent,
                    position: 'top-right',
                    props: {
                        title: 'Error',
                        icon: 'AlertCircleIcon',
                        variant: 'warning',
                        text: 'Please select Billing Template.',
                    },
                })
            } else {
                await generateBillingTermFromTemplate(billingTemplateId.value
                    , router.currentRoute.params.id
                    , parseInt(roundingType.value)
                )
                await refetchData()
                await resetFormData()
                billingTemplateId.value = null
            }
        }

        const isBillingPercentShow = ref(false)
        const isBillingValueShow = ref(false)

        const editBillingData = (data) => {
            formData.value = data
            isBillingPercentShow.value = formData.value.type === 0
            isBillingValueShow.value = formData.value.type === 1
        }

        return {
            isBusy,
            billingTemplateId,
            billingTemplateOptions,
            table,
            formData,
            resetFormData,
            refetchData,
            saveFormData,
            templateWiseBillingTerm,
            isBillingPercentShow,
            isBillingValueShow,
            editBillingData,
            onRowSelected
        }
    }
}
</script>
