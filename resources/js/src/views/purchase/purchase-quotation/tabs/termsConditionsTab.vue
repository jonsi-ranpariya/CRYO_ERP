<template>
    <div>
        <!-- Table -->
        <b-row>
            <b-col md="12">
                <b-table
                    :fields="tableFields"
                    :items="tableData"
                    responsive
                    class="mb-0 table_scroll"
                    bordered
                    hover
                    show-empty
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

                    <!-- Action -->
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
                            <b-dropdown-item @click="deleteTermCondition(data.item._id)">
                                <feather-icon
                                    icon="TrashIcon"
                                    class="mr-50"
                                />
                                <span>Delete</span>
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
            </b-col>
        </b-row>

        <!--Button group-->
        <b-row>
            <b-col md="12">
                <hr>
                <b-button
                    type="button"
                    variant="primary"
                    @click="copyFromPartyMaster"
                    :disabled="copyButton.isDisabled"
                >
                    {{ copyButton.text }}
                </b-button>
                <b-button
                    type="button"
                    variant="primary"
                    @click="defaultTemplate"
                >
                    From Default T & C
                </b-button>
                <b-button
                    type="button"
                    variant="primary"
                    @click="openTCTemplateModal"
                >
                    Form Template
                </b-button>
                <hr>
            </b-col>
        </b-row>

        <!--Form Detail-->
        <validation-observer #default="{ handleSubmit }">
            <b-form @submit.prevent="handleSubmit(saveFormData)">
                <b-row>
                    <b-col md="6">
                        <validation-provider
                            #default="validationContext"
                            name="Group"
                            rules=""
                        >
                            <b-form-group
                                label="Group"
                                label-for="group"
                                :state="getValidationState(validationContext)"
                            >
                                <v-select
                                    v-model="formData.groupId"
                                    placeholder="Select group"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="groupOption"
                                    :reduce="val => val.value"
                                    :clearable="false"
                                    input-id="group"
                                    @input="getGroupData($event)"
                                    :state="getValidationState(validationContext)"
                                />
                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                        <validation-provider
                            #default="validationContext"
                            name="Group Name"
                            rules="required"
                        >
                            <b-form-group
                                label="Group Name"
                                label-for="groupDescription"
                            >
                                <b-form-input
                                    id="groupDescription"
                                    v-model="formData.groupDescription"
                                    rows="1"
                                    :state="getValidationState(validationContext)"
                                />
                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                    </b-col>
                    <b-col md="6">
                        <b-form-group
                            label="Terms & Condition"
                            label-for="termsCondition"
                        >
                            <b-form-textarea
                                id="termsCondition"
                                rows="2"
                                v-model="formData.termsCondition"
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
        </validation-observer>
        <!--Modal Template Master-->
        <b-modal
            id="termConditionModal"
            title="Select Term & Condition Template"
            ok-title="submit"
            cancel-variant="danger"
            size="xl"
            no-close-on-backdrop
            scrollable
            ref="termConditionModal"
            @ok="fromTemplateHandelOk"
            @close="clearModalData"
            @cancel="clearModalData"
        >
            <b-table
                :fields="modalTableFields.templateField"
                :items="modalTableFields.templateItems"
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
                <template #cell(action)="data">
                    <b-button
                        variant="flat-primary"
                        size="sm"
                        :id="`b_${data.item._id}`"
                        @click="getTemplate(data.item._id)"
                    >
                        Select
                    </b-button>
                </template>
            </b-table>
            <hr>
            <h5>Template Details</h5>
            <hr>
            <b-table
                :fields="modalTableFields.templateDataFields"
                :items="modalTableFields.templateDataItems"
                :no-border-collapse="false"
                responsive
                bordered
                hover
                show-empty
                class="table_scroll"
                :busy="modalTableIsBusy"
            >
                <!--Loader-->
                <template #table-busy>
                    <div class="text-center my-2">
                        <b-spinner class="align-middle"></b-spinner>
                        <strong>Loading...</strong>
                    </div>
                </template>

                <template #cell(index)="data">
                    {{ data.index + 1 }}
                </template>
            </b-table>
        </b-modal>

    </div>
</template>
<script>
import {
    BForm,
    BRow,
    BCol,
    BFormGroup,
    BFormInput,
    BInputGroup,
    BInputGroupAppend,
    BFormInvalidFeedback,
    BButton,
    BFormTextarea,
    BTable,
    BDropdown,
    BDropdownItem,
    BSpinner,
} from 'bootstrap-vue'
import { ValidationObserver, ValidationProvider } from 'vee-validate'
import formValidation from '@core/comp-functions/forms/form-validation'
import { required } from '@validations'
import { onUnmounted, ref, } from '@vue/composition-api'
import vSelect from 'vue-select'
import axios from '@axios'
import store from '@/store'
import purchaseStoreModule from '../../purchaseStoreModule'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
import { useToast } from 'vue-toastification/composition'
import Swal from 'sweetalert2'
import router from '@/router'
import { forMatIndianDateAndTime } from '@core/utils/utils'
import { computed } from '@vue/composition-api/dist/vue-composition-api'

export default {
    components: {
        ValidationObserver,
        ValidationProvider,
        BForm,
        BRow,
        BCol,
        BFormGroup,
        BFormInput,
        BInputGroup,
        BInputGroupAppend,
        BFormInvalidFeedback,
        BButton,
        BFormTextarea,
        vSelect,
        BTable,
        BDropdown,
        BDropdownItem,
        BSpinner,
    },
    props: {
        vendorPartyId: {
            required: true,
        }
    },
    setup(props, { termConditionModal }) {
        termConditionModal = ref()
        const ITEM_ADDON_APP_STORE_MODULE_NAME = 'purchase-store-module'
        if (!store.hasModule(ITEM_ADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEM_ADDON_APP_STORE_MODULE_NAME, purchaseStoreModule)
        onUnmounted(() => {
            if (store.hasModule(ITEM_ADDON_APP_STORE_MODULE_NAME)) store.unregisterModule(ITEM_ADDON_APP_STORE_MODULE_NAME)
        })

        const currentPartyId = computed(() => props.vendorPartyId)

        const modalTableIsBusy = ref(false)
        const selectedTemplate = ref(null)
        const toast = useToast()
        const isBusy = ref(false)
        const tableFields = ref([
            {
                key: 'rowSelected',
                label: ''
            },
            {
                key: 'index',
                label: 'No'
            },
            {
                key: 'groupDescription',
                label: 'Group Description'
            },
            {
                key: 'termsCondition',
                label: 'Term & Condition Description'
            },
            {
                key: 'action',
                label: 'Actions'
            }
        ])
        const tableData = ref([])

        const modalTableFields = ref({
            templateField: [
                {
                    key: 'action',
                    label: ''
                },
                {
                    key: 'templateName',
                    label: 'Template Name'
                },
                {
                    key: 'created_at',
                    label: 'Created Date',
                    formatter: val => forMatIndianDateAndTime(val)
                }
            ],
            templateItems: [],
            templateDataFields: [
                {
                    key: 'index',
                    label: 'No.'
                },
                {
                    key: 'groupName',
                    label: 'Group Name'
                },
                {
                    key: 'tcDescription',
                    label: 'Description'
                },
            ],
            templateDataItems: [],
        })

        const refetchData = async () => {
            isBusy.value = true
            await axios.get(`/api/get-purchase-quotation-term-condition/${router.currentRoute.params.id}`)
                .then(res => {
                    tableData.value = res.data.data
                })
            isBusy.value = false
        }
        refetchData()

        //terms and condition
        const groupOption = ref([])
        axios.get('/api/get-term-condition-detail-with-group-options')
            .then(res => {
                groupOption.value = res.data.data
            })

        const getGroupData = async (id) => {
            await axios.get(`/api/get-term-condition-detail-with-group-details/${id}`)
                .then(res => {
                    formData.value.termsCondition = res.data.data.tcGroupDescription
                    formData.value.groupDescription = res.data.data?.tc_group_details?.groupDescription ?? null
                })
        }

        const blankFormData = {
            _id: null,
            purchaseQuotationId: router.currentRoute.params.id,
            groupId: null,
            groupDescription: null,
            termsCondition: null,
        }

        const formData = ref(JSON.parse(JSON.stringify(blankFormData)))

        const resetFormData = () => {
            formData.value = JSON.parse(JSON.stringify(blankFormData))
        }

        const onRowSelected = (items) => {
            if (items.length > 0) {
                formData.value._id = items[0]._id
                formData.value.purchaseOrderId = items[0].purchaseOrderId ?? null
                formData.value.groupId = items[0].groupId ?? null
                formData.value.poHistory = items[0].poHistory ?? null
                formData.value.groupDescription = items[0].groupDescription ?? null
                formData.value.termsCondition = items[0].termsCondition ?? null
            } else {
                resetFormData()
            }
        }

        const openTCTemplateModal = async () => {
            selectedTemplate.value = null
            await axios.get('/api/term-condition-template-master')
                .then((res) => {
                    modalTableFields.value.templateItems = res.data.data
                })
            termConditionModal.value.show()
        }

        const clearModalData = async () => {
            modalTableFields.value.templateDataItems = []
            modalTableFields.value.templateItems = []
            selectedTemplate.value = null
        }

        const getTemplate = async (id) => {
            selectedTemplate.value = id
            modalTableIsBusy.value = true
            await axios.get(`/api/new/term-condition-template-wise/${id}`)
                .then((res) => {
                    modalTableFields.value.templateDataItems = res.data.data
                })
            modalTableIsBusy.value = false
        }

        const fromTemplateHandelOk = async () => {
            if (selectedTemplate.value === null) {
                toast({
                    component: ToastificationContent,
                    position: 'top-right',
                    props: {
                        title: `Error`,
                        icon: 'AlertCircleIcon',
                        variant: 'danger',
                        text: 'Please select any template.',
                    },
                })
                await openTCTemplateModal()
            } else {
                await axios.post('/api/new/add-purchase-quotation-term-condition-from-template', {
                    purchaseQuotationId: router.currentRoute.params.id,
                    templateId: selectedTemplate.value
                })
                    .then((res) => {
                        if (res.status === 200) {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Added',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: 'You have successfully added Term & Condition from Template',
                                },
                            })
                        }
                    })
                    .catch(() => {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: `Error`,
                                icon: 'AlertCircleIcon',
                                variant: 'danger',
                                text: 'Internal server error.',
                            },
                        })
                    })
                await clearModalData()
                await refetchData()
            }
        }

        const defaultTemplate = async () => {
            await Swal.fire({
                title: 'Are you sure?',
                text: 'You want to copy Default term and condition!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, copy it!',
                customClass: {
                    confirmButton: 'btn btn-primary',
                    cancelButton: 'btn btn-outline-danger ml-1',
                },
                buttonsStyling: false,
            })
                .then(result => {
                    if (result.value) {
                        axios.post(`/api/new/copy-term-condition-default-template-purchase-quotation`, {
                            purchaseQuotationId: router.currentRoute.params.id
                        })
                            .then((res) => {
                                if (res.status === 200) {
                                    toast({
                                        component: ToastificationContent,
                                        position: 'top-right',
                                        props: {
                                            title: 'Added',
                                            icon: 'CheckSquareIcon',
                                            variant: 'success',
                                            text: 'You have successfully added Term & Condition from Default Template',
                                        },
                                    })
                                }
                            })
                            .catch(() => {
                                toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: `Error`,
                                        icon: 'AlertCircleIcon',
                                        variant: 'danger',
                                        text: 'Internal server error.',
                                    },
                                })
                            })
                    }
                })
            await refetchData()
        }
        const copyButton = ref({
            text: 'Copy From Party Master',
            isDisabled: false
        })

        const copyFromPartyMaster = async () => {
            await Swal.fire({
                title: 'Are you sure?',
                text: 'You want to copy master term and condition!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, copy it!',
                customClass: {
                    confirmButton: 'btn btn-primary',
                    cancelButton: 'btn btn-outline-danger ml-1',
                },
                buttonsStyling: false,
            })
                .then(result => {
                    if (result.value) {
                        copyButton.value.isDisabled = true
                        copyButton.value.text = 'Please wait...'
                        console.log(currentPartyId.value)
                        axios.post(`/api/new/copy-term-condition-party-master-purchase-quotation`, {
                            partyId: currentPartyId.value,
                            purchaseQuotationId: router.currentRoute.params.id
                        })
                            .then((res) => {
                                toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: res.data.shortMessage,
                                        icon: res.data.icon,
                                        variant: res.data.variant,
                                        text: res.data.message,
                                    },
                                })
                            })
                        copyButton.value.isDisabled = false
                        copyButton.value.text = 'Copy From Party Master'
                    }
                })
            await refetchData()
        }

        const deleteTermCondition = async (id) => {
            await Swal.fire({
                title: 'Are you sure?',
                text: 'Delete Purchase Order Term And Condition',
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
                        store.dispatch('purchase-store-module/deletePurchaseQuotationTermCondition', { id: id })
                            .then(res => {
                                if (res.status === 200) {
                                    toast({
                                        component: ToastificationContent,
                                        position: 'top-right',
                                        props: {
                                            title: 'Term And Condition Deleted',
                                            icon: 'CheckSquareIcon',
                                            variant: 'success',
                                            text: `You have successfully Deleted Term And Condition.`,
                                        },
                                    })
                                } else {
                                    toast({
                                        component: ToastificationContent,
                                        position: 'top-right',
                                        props: {
                                            title: 'Error',
                                            icon: 'AlertCircleIcon',
                                            variant: 'danger',
                                            text: 'Something went wrong!',
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
                await store.dispatch('purchase-store-module/addPurchaseQuotationTermCondition', formData.value)
                    .then(res => {
                        if (res.status === 200) {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Purchase Enquiry Term And Condition Added',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: `You have successfully Added Purchase Enquiry Term And Condition.`,
                                },
                            })
                        } else {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Error',
                                    icon: 'AlertCircleIcon',
                                    variant: 'danger',
                                    text: 'Something went wrong!',
                                },
                            })
                        }
                    })
            } else {
                await store.dispatch('purchase-store-module/updatePurchaseQuotationTermCondition', formData.value)
                    .then(res => {
                        if (res.status === 200) {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Purchase Enquiry Term And Condition Added',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: `You have successfully Added Purchase Order Term And Condition.`,
                                },
                            })
                        } else {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Error',
                                    icon: 'AlertCircleIcon',
                                    variant: 'danger',
                                    text: 'Something went wrong!',
                                },
                            })
                        }
                    })
            }
            resetFormData()
            await refetchData()
        }

        const {
            refFormObserver,
            getValidationState,
            resetForm
        } = formValidation(resetFormData)

        return {
            formData,
            refFormObserver,
            getValidationState,
            resetForm,
            resetFormData,

            required,
            saveFormData,
            groupOption,
            getGroupData,
            tableFields,
            tableData,
            refetchData,
            isBusy,
            deleteTermCondition,
            modalTableFields,
            fromTemplateHandelOk,
            getTemplate,
            clearModalData,
            modalTableIsBusy,
            openTCTemplateModal,
            selectedTemplate,
            termConditionModal,
            defaultTemplate,
            copyFromPartyMaster,
            copyButton,
            onRowSelected
        }
    },
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
