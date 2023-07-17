<template>
    <div>
        <!--table-->
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
                            <b-dropdown-item @click="editBillingItem(data.item)">
                                <feather-icon
                                    icon="Edit2Icon"
                                    class="mr-50"
                                />
                                <span>Edit</span>
                            </b-dropdown-item>
                        </b-dropdown>
                    </template>
                </b-table>
                <hr>
            </b-col>
        </b-row>

        <!--Change Template Area-->
        <b-row>
            <b-col md="8">
                <b-form-group
                    label="Choose Template"
                    label-for="billingTermTemplate"
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
                    variant="primary"
                    type="button"
                    class="mt-1"
                    @click="templateWiseBillingTerm"
                >
                    Change Template
                </b-button>
            </b-col>
        </b-row>

        <!--close table-->
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
    BTable,
    BSpinner,
    BDropdown,
    BDropdownItem,
    BFormGroup,
    BFormInput,
    BButton
} from 'bootstrap-vue'
import Ripple from 'vue-ripple-directive'
import { ref } from '@vue/composition-api'
import vSelect from 'vue-select'
import axios from '@axios'
import router from '@/router'
import {generateBillingTermFromTemplate, generateBillingTerm} from '../ReturnRejectionBillingTermHelper'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
import { useToast } from 'vue-toastification/composition'

export default {
    components: {
        BForm,
        BRow,
        BCol,
        BTable,
        BSpinner,
        BDropdown,
        BDropdownItem,
        BFormGroup,
        BFormInput,
        BButton,
        vSelect
    },
    directives: {
        Ripple,
    },
    setup() {
        const toast = useToast()
        const isBusy = ref(false)
        const table = ref({
            fields: [
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

        const billingTemplateId = ref(null)

        const billingTemplateOptions = ref([])
        axios.get('/api/get-billing-template-master-options')
            .then((res) => {
                billingTemplateOptions.value = res.data.data
            })

        const refetchData = async () => {
            isBusy.value = true
            await axios.get(`/api/new/get-return-rejection-billing-term/${router.currentRoute.params.id}`).then((res) => {
                table.value.data = res.data.data
            })
            isBusy.value = false
        }
        refetchData()

        const blankFormData = {
            _id: null,
            returnRejectMemoId: null,
            calCode: null,
            calCodeLabel: null,
            calDefination: null,
            description: null,
            percentage: null,
            byValue: null,
            operation: null,
            narration: null,
            type: null,
            total_amount: null,
            srNo: 1
        }

        const formData = ref(JSON.parse(JSON.stringify(blankFormData)))

        const resetFormData = async () => {
            formData.value = JSON.parse(JSON.stringify(blankFormData))
        }

        const isBillingPercentShow = ref(false)
        const isBillingValueShow = ref(false)

        const editBillingItem = (data) => {
            formData.value = data
            isBillingPercentShow.value = formData.value.type === 0
            isBillingValueShow.value = formData.value.type === 1
        }

        const saveFormData = async () => {
            if (formData.value._id !== null) {
                await axios.put(`/api/new/return-rejection-billing-term/${formData.value._id}`, formData.value).then((res) => {
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
                await generateBillingTerm(router.currentRoute.params.id)
                await resetFormData()
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
                await generateBillingTermFromTemplate(billingTemplateId.value, router.currentRoute.params.id)
                await refetchData()
                await resetFormData()
                billingTemplateId.value = null
            }
        }

        return {
            isBusy,
            table,
            billingTemplateId,
            billingTemplateOptions,
            refetchData,
            formData,
            resetFormData,
            isBillingPercentShow,
            isBillingValueShow,
            editBillingItem,
            saveFormData,
            templateWiseBillingTerm
        }
    }
}
</script>
