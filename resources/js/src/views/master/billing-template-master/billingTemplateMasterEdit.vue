<template>
    <div>
        <b-overlay
            :show="showLoading"
            rounded="sm"
        >
            <b-card-code>
                <validation-observer
                    #default="{ handleSubmit }"
                    ref="refFormObserver"
                >
                    <!-- Form -->
                    <b-form
                        @submit.prevent="handleSubmit(saveTemplateData)"
                        @reset.prevent="resetForm"
                    >
                        <b-row>
                            <b-col md="8">
                                <validation-provider
                                    #default="validationContext"
                                    name="Template"
                                    rules="required"
                                >
                                    <b-form-group>

                                        <label for="template">Template <span
                                            class="text-danger erp_required_star"
                                        >*</span></label>

                                        <b-form-input
                                            id="template"
                                            v-model="templateData.templateName"
                                            :state="getValidationState(validationContext)"
                                        />
                                        <b-form-invalid-feedback>
                                            {{ validationContext.errors[0] }}
                                        </b-form-invalid-feedback>
                                    </b-form-group>
                                </validation-provider>
                            </b-col>
                            <b-col md="4">
                                <validation-provider
                                    #default="validationContext"
                                    name="Active"
                                    rules="required"
                                >
                                    <b-form-group
                                        label="Active"
                                        label-for="active"
                                        :state="getValidationState(validationContext)"
                                    >
                                        <v-select
                                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                            :options="statusOption"
                                            :clearable="false"
                                            input-id="active"
                                            :reduce="val => val.value"
                                            v-model="templateData.status"
                                        />
                                        <b-form-invalid-feedback>
                                            {{ validationContext.errors[0] }}
                                        </b-form-invalid-feedback>
                                    </b-form-group>
                                </validation-provider>
                            </b-col>
                            <b-col md="12">
                                <hr>
                                <b-button
                                    type="submit"
                                    variant="primary"
                                >
                                    Save Template
                                </b-button>
                            </b-col>
                        </b-row>
                    </b-form>
                </validation-observer>
            </b-card-code>
        </b-overlay>
        <b-overlay
            :show="showLoading"
            rounded="sm"
        >
            <b-card-code>
                <b-table
                    :fields="tableData.fields"
                    :items="tableData.rows"
                    :bordered="true"
                    :hover="true"
                    show-empty
                    responsive
                    class="mb-0 table_scroll"
                >
                    <!-- A custom formatted column -->
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
              <b-dropdown-item @click="editBillingItem(data.item)">
                <feather-icon
                    icon="Edit2Icon"
                    class="mr-50"
                />
                <span>Edit</span>
              </b-dropdown-item>
              <b-dropdown-item @click="deleteBillingItem(data.item._id)">
                <feather-icon
                    icon="TrashIcon"
                    class="mr-50"
                />
                <span>Delete</span>
              </b-dropdown-item>
            </b-dropdown>
                </span>
                    </template>
                </b-table>
            </b-card-code>
        </b-overlay>
        <b-overlay
            :show="showLoading"
            rounded="sm"
        >
            <b-card-code>
                <validation-observer
                    #default="{ handleSubmit }"
                    ref="refFormObserver"
                >
                    <!-- Form -->
                    <b-form
                        @submit.prevent="handleSubmit(submitFormData)"
                        @reset.prevent="resetForm"
                    >
                        <b-row>
                            <b-col md="6">
                                <validation-provider
                                    #default="validationContext"
                                    name="Serial No."
                                    rules="required"
                                >
                                    <b-form-group
                                        :state="getValidationState(validationContext)"
                                    >
                                        <label for="serialNo">Serial No. <span
                                            class="text-danger erp_required_star"
                                        >*</span></label>
                                        <b-form-input
                                            id="serialNo"
                                            v-model="formData.serialNo"
                                            type="number"
                                            :state="getValidationState(validationContext)"
                                        />
                                        <b-form-invalid-feedback>
                                            {{ validationContext.errors[0] }}
                                        </b-form-invalid-feedback>
                                    </b-form-group>
                                </validation-provider>
                                <validation-provider
                                    #default="validationContext"
                                    name="Cal Code"
                                    rules="required"
                                >
                                    <b-form-group
                                        :state="getValidationState(validationContext)"
                                    >
                                        <label for="calCode">Cal Code <span
                                            class="text-danger erp_required_star"
                                        >*</span></label>

                                        <v-select
                                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                            :options="billingDescriptionOption"
                                            :clearable="false"
                                            input-id="calCode"
                                            :reduce="val => val.value"
                                            v-model="formData.calCode"
                                            @input="getBillingItemDetails($event)"
                                        />
                                        <b-form-invalid-feedback>
                                            {{ validationContext.errors[0] }}
                                        </b-form-invalid-feedback>
                                    </b-form-group>
                                </validation-provider>
                                <validation-provider
                                    #default="validationContext"
                                    name="Description"
                                    rules="required"
                                >
                                    <b-form-group
                                        :state="getValidationState(validationContext)"
                                    >
                                        <label for="description">Description <span
                                            class="text-danger erp_required_star"
                                        >*</span></label>

                                        <b-form-input
                                            id="description"
                                            v-model="formData.description"
                                            :state="getValidationState(validationContext)"
                                        />
                                        <b-form-invalid-feedback>
                                            {{ validationContext.errors[0] }}
                                        </b-form-invalid-feedback>
                                    </b-form-group>
                                </validation-provider>
                                <validation-provider
                                    #default="validationContext"
                                    name="Cal Defination"
                                    rules="required"
                                >
                                    <b-form-group>
                                        <label for="calDefination">Cal Definition <span
                                            class="text-danger erp_required_star"
                                        >*</span></label>

                                        <b-form-textarea
                                            id="calDefination"
                                            rows="3"
                                            v-model="formData.calDefination"
                                            :state="getValidationState(validationContext)"
                                            class="text-uppercase"
                                        />
                                        <b-form-invalid-feedback>
                                            {{ validationContext.errors[0] }}
                                        </b-form-invalid-feedback>
                                    </b-form-group>
                                </validation-provider>
                            </b-col>
                            <b-col md="6">
                                <validation-provider
                                    #default="validationContext"
                                    name="Percent (%)"
                                    :rules="{
                                        numeric: true,
                                        min:0,
                                        max:100
                                    }"
                                >
                                    <b-form-group
                                        label="Percent (%)"
                                        label-for="percentage"
                                    >
                                        <b-form-input
                                            id="percentage"
                                            v-model="formData.percentage"
                                            :disabled="formData.byValue > 0"
                                            :state="getValidationState(validationContext)"
                                            max="100"
                                            min="0"
                                            type="number"
                                        />
                                        <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                            {{ validationContext.errors[0] }}
                                        </b-form-invalid-feedback>
                                    </b-form-group>
                                </validation-provider>
                                <validation-provider
                                    #default="validationContext"
                                    name="Value"
                                    rules=""
                                >
                                    <b-form-group
                                        label="Value"
                                        label-for="value"
                                    >
                                        <b-form-input
                                            id="value"
                                            type="number"
                                            :disabled="formData.percentage > 0"
                                            v-model="formData.byValue"
                                            :state="getValidationState(validationContext)"
                                        />
                                        <b-form-invalid-feedback>
                                            {{ validationContext.errors[0] }}
                                        </b-form-invalid-feedback>
                                    </b-form-group>
                                </validation-provider>
                                <validation-provider
                                    #default="validationContext"
                                    name="Operation"
                                    rules="required"
                                >
                                    <b-form-group
                                        label="Operation"
                                        label-for="operation"
                                        :state="getValidationState(validationContext)"
                                    >
                                        <v-select
                                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                            :options="operationOption"
                                            :clearable="false"
                                            input-id="operation"
                                            :reduce="val => val.value"
                                            v-model="formData.operation"
                                        />
                                        <b-form-invalid-feedback>
                                            {{ validationContext.errors[0] }}
                                        </b-form-invalid-feedback>
                                    </b-form-group>
                                </validation-provider>
                                <validation-provider
                                    #default="validationContext"
                                    name="Narration"
                                    rules=""
                                >
                                    <b-form-group
                                        label="Narration"
                                        label-for="narration"
                                    >
                                        <b-form-input
                                            id="narration"
                                            v-model="formData.narration"
                                            :state="getValidationState(validationContext)"
                                        />
                                        <b-form-invalid-feedback>
                                            {{ validationContext.errors[0] }}
                                        </b-form-invalid-feedback>
                                    </b-form-group>
                                </validation-provider>
                            </b-col>
                            <b-col md="12">
                                <hr>
                                <b-button
                                    type="submit"
                                    variant="primary"
                                >
                                    Save
                                </b-button>
                            </b-col>
                        </b-row>
                    </b-form>
                </validation-observer>
            </b-card-code>
        </b-overlay>
    </div>
</template>
<script>
import BCardCode from '@core/components/b-card-code/BCardCode.vue'
import {
    BPagination, BFormGroup, BFormInput, BFormSelect, BDropdown, BDropdownItem, BButton, BRow,
    BCol, BOverlay, BFormTextarea, BFormInvalidFeedback, BForm, BTable
} from 'bootstrap-vue'
import Ripple from 'vue-ripple-directive'
import vSelect from 'vue-select'
import { VueGoodTable } from 'vue-good-table'
import store from '@/store'
import router from '@/router'
import { ref, onUnmounted } from '@vue/composition-api'
import { useToast } from 'vue-toastification/composition'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
import { ValidationProvider, ValidationObserver } from 'vee-validate'
import formValidation from '@core/comp-functions/forms/form-validation'
import { required, min, max, numeric } from '@validations'
import axios from '@axios'
import masterStoreModule from '../masterStoreModule'
import moment from 'moment'
import swal from 'sweetalert2'

export default {
    components: {
        BForm,
        BCardCode,
        BOverlay,
        VueGoodTable,
        BButton,
        BRow,
        BCol,
        BPagination,
        BFormGroup,
        BFormInput,
        BFormSelect,
        BDropdown,
        BDropdownItem,
        BFormTextarea,
        BFormInvalidFeedback,
        BTable,
        ValidationProvider,
        ValidationObserver,
        vSelect
    },
    directives: {
        Ripple,
    },
    computed: {
        direction() {
            if (store.state.appConfig.isRTL) {
                this.dir = true
                return this.dir
            }
            this.dir = false
            return this.dir
        },
    },
    setup() {
        const ITEMADDON_APP_STORE_MODULE_NAME = 'billing-template-master'
        if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, masterStoreModule)
        onUnmounted(() => {
            if (store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.unregisterModule(ITEMADDON_APP_STORE_MODULE_NAME)
        })

        const toast = useToast()

        const showLoading = ref(true)

        const billingDescriptionOption = ref([])
        axios.get('/api/get-billing-details-master-options')
            .then(res => {
                billingDescriptionOption.value = res.data.data
            })

        const operationOption = ref([
            {
                label: '+',
                value: '+'
            },
            {
                label: '-',
                value: '-'
            },
            {
                label: '%',
                value: '%'
            }
        ])

        const statusOption = ref([
            {
                label: 'Yes',
                value: 1
            },
            {
                label: 'No',
                value: 0
            },
        ])

        const tableData = ref({
            fields: [
                {
                    key: 'calCodeLabel',
                    label: 'Code'
                },
                {
                    key: 'description',
                    label: 'Description'
                },
                {
                    key: 'calDefination',
                    label: 'Cal Defination'
                },
                {
                    key: 'percentage',
                    label: 'Percent (%)'
                },
                {
                    key: 'byValue',
                    label: 'value'
                },
                {
                    key: 'operation',
                    label: 'Operation'
                },
                {
                    key: 'narration',
                    label: 'Narration'
                },
                {
                    key: 'action',
                    label: 'Action'
                }
            ],
            rows: []
        })

        const blankData = {
            id: null,
            serialNo: 1,
            calCode: null,
            calCodeLabel: null,
            description: null,
            calDefination: null,
            operation: '+',
            percentage: 0,
            byValue: 0,
            type: null,
            narration: null,
            templateId: router.currentRoute.params.id
        }

        const templateData = ref({
            id: null,
            status: null,
            templateName: null,
            billingTerms: []
        })

        const formData = ref(JSON.parse(JSON.stringify(blankData)))

        const fetchData = async () => {
            showLoading.value = true
            await axios.get(`/api/billing-template-master/${router.currentRoute.params.id}`)
                .then((res) => {
                    templateData.value.id = res.data.data._id
                    templateData.value.status = res.data.data.status
                    templateData.value.templateName = res.data.data.templateName
                    tableData.value.rows = res.data.data.billing_items
                    showLoading.value = false
                })
        }
        fetchData()

        const resetFormData = () => {
            formData.value = JSON.parse(JSON.stringify(blankData))
        }

        const submitFormData = async () => {
            formData.value.templateId = router.currentRoute.params.id
            formData.value.calDefination = formData.value.calDefination.toUpperCase()
            if (formData.value.id === null) {
                await store.dispatch('billing-template-master/addBillingTemplateItemMaster', formData.value)
                    .then(res => {
                        if (res.data.status === 200) {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Billing Template Item Created',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: `You have successfully Created Billing Template Item`,
                                },
                            })
                        } else {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Abort',
                                    icon: 'AlertCircleIcon',
                                    variant: 'danger',
                                    text: `Something went wrong`,
                                },
                            })
                        }
                    })
            } else {
                await store.dispatch('billing-template-master/updateBillingTemplateItemMaster', formData.value)
                    .then(res => {
                        if (res.data.status === 200) {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Billing Template Item Updated',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: `You have successfully Updated Billing Template Item`,
                                },
                            })
                        } else {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Abort',
                                    icon: 'AlertCircleIcon',
                                    variant: 'danger',
                                    text: `Something went wrong`,
                                },
                            })
                        }
                    })
            }
            resetFormData()
            await fetchData()
        }

        const saveTemplateData = async () => {
            await store.dispatch('billing-template-master/updateBillingTemplateMaster', templateData.value)
                .then(res => {
                    if (res.data.status === 200) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Billing Template Created',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: `You have successfully Created Billing Template: ${templateData.value.templateName}`,
                            },
                        })
                    } else {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Abort',
                                icon: 'AlertCircleIcon',
                                variant: 'danger',
                                text: `Something went wrong`,
                            },
                        })
                    }
                })
            router.push({ name: 'billing-template-master' })
        }

        const getBillingItemDetails = (id) => {
            axios.get(`/api/billing-master/${id}`)
                .then(res => {
                    formData.value.description = res.data.data.name
                    formData.value.calCodeLabel = res.data.data.calCode
                    formData.value.type = res.data.data.valueType.value
                    if (res.data.data.valueType.value === 0) {
                        formData.value.percentage = res.data.data.defaultValue
                        formData.value.byValue = 0
                    }
                    if (res.data.data.valueType.value === 1) {
                        formData.value.byValue = res.data.data.defaultValue
                        formData.value.percentage = 0
                    }
                })
        }

        const editBillingItem = (data) => {
            formData.value.id = data._id
            formData.value.serialNo = data.serialNo ?? 0
            formData.value.calCode = data.calCode
            formData.value.calCodeLabel = data.calCodeLabel
            formData.value.description = data.description
            formData.value.calDefination = data.calDefination.toUpperCase()
            formData.value.operation = data.operation
            formData.value.percentage = data.percentage
            formData.value.byValue = data.byValue
            formData.value.narration = data.narration
        }

        const deleteBillingItem = async (id) => {
            swal.fire({
                title: 'Are you sure?',
                text: 'Name is already exist',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, do it!',
                cancelButtonText: 'No, cancel it!',
                customClass: {
                    confirmButton: 'btn btn-primary',
                    cancelButton: 'btn btn-outline-danger ml-1',
                },
                buttonsStyling: false,
            })
                .then(result => {
                    if (result.value) {
                        store.dispatch('billing-template-master/deleteBillingTemplateItemMaster', { id: id })
                            .then(res => {
                                if (res.data.status === 200) {
                                    toast({
                                        component: ToastificationContent,
                                        position: 'top-right',
                                        props: {
                                            title: 'Billing Template Item Deleted',
                                            icon: 'CheckSquareIcon',
                                            variant: 'success',
                                            text: `You have successfully Deleted Billing Template Item`,
                                        },
                                    })
                                } else {
                                    toast({
                                        component: ToastificationContent,
                                        position: 'top-right',
                                        props: {
                                            title: 'Abort',
                                            icon: 'AlertCircleIcon',
                                            variant: 'danger',
                                            text: `Something went wrong`,
                                        },
                                    })
                                }
                                fetchData()
                            })
                    } else {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Abort Task',
                                icon: 'AlertCircleIcon',
                                variant: 'danger',
                                text: `You had canceled This task`,
                            },
                        })
                    }
                })
        }

        const {
            refFormObserver,
            getValidationState,
            resetForm
        } = formValidation(resetFormData)

        return {
            billingDescriptionOption,
            operationOption,
            statusOption,
            tableData,
            formData,
            templateData,
            submitFormData,
            getBillingItemDetails,
            saveTemplateData,
            editBillingItem,
            deleteBillingItem,

            refFormObserver,
            getValidationState,
            resetForm,
            required,
            min,
            max,
            numeric,
            showLoading
        }
    }
}
</script>
<style lang="scss">
@import '~@core/scss/vue/libs/vue-sweetalert.scss';
</style>
<style lang="scss" scoped>
@import '~@core/scss/base/bootstrap-extended/include';
@import '~@core/scss/base/components/variables-dark';

.dark-layout {
    div ::v-deep .card .card-body {
        .b-overlay {
            .bg-light {
                background-color: $theme-dark-body-bg !important;
            }
        }
    }
}
</style>
