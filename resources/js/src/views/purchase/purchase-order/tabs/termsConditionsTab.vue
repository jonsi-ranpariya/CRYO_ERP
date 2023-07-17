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
                            <b-dropdown-item @click="deletePurchaseReturnTerm(data.item._id)">
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
                <hr>
            </b-col>
        </b-row>
        <!-- Modal Buttons -->
        <b-row>
            <b-col md="12">
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

        <validation-observer #default="{ handleSubmit }">
            <b-form @submit.prevent="handleSubmit(saveFormData)">
                <b-row>
                    <b-col md="12">
                        <b-form-group
                            label="Group Options"
                            label-for="groupOptions"
                        >
                            <v-select
                                v-model="formData.groupId"
                                placeholder="Select group"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="groupOption"
                                :reduce="val => val.value"
                                :clearable="false"
                                input-id="groupOptions"
                                @input="getGroupData($event)"
                            />
                        </b-form-group>
                        <validation-provider
                            #default="validationContext"
                            name="Group Name"
                            rules="required"
                        >
                            <b-form-group
                                label="Group Name"
                                label-for="groupName"
                            >
                                <b-form-input
                                    id="groupName"
                                    v-model="formData.groupName"
                                    :state="getValidationState(validationContext)"
                                />
                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
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
                </b-row>
                <b-row>
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
    BFormRadio,
    BTable,
    BTab,
    BSpinner,
    BDropdown,
    BDropdownItem,
    BInputGroup,
    BInputGroupAppend,
    BFormInvalidFeedback,
    BButton,
    BFormTextarea
} from 'bootstrap-vue'
import { ValidationObserver, ValidationProvider } from 'vee-validate'
import formValidation from '@core/comp-functions/forms/form-validation'
import { required } from '@validations'
import { computed, onUnmounted, ref } from '@vue/composition-api'
import vSelect from 'vue-select'
import axios from '@axios'
import Ripple from 'vue-ripple-directive'
import purchaseStoreModule from '../../purchaseStoreModule'
import { useToast } from 'vue-toastification/composition'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
import store from '@/store'
import router from '@/router'
import Swal from 'sweetalert2'
import { forMatIndianDateAndTime } from '@core/utils/utils'

export default {
    components: {
        ValidationObserver,
        ValidationProvider,
        BForm,
        BRow,
        BCol,
        BFormGroup,
        BFormInput,
        BFormRadio,
        BInputGroup,
        BInputGroupAppend,
        BFormInvalidFeedback,
        BButton,
        BFormTextarea,
        vSelect,
        BTable,
        BTab,
        BSpinner,
        BDropdown,
        BDropdownItem,
    },
    directives: {
        Ripple,
    },
    props: {
        vendorPartyId: {
            required: true,
        }
    },
    setup(props, { termConditionModal }) {
        termConditionModal = ref()
        const modalTableIsBusy = ref(false)
        const selectedTemplate = ref(null)
        const CurrentPurchaseOrderId = ref(router.currentRoute.params.id)
        const currentPartyId = computed(() => props.vendorPartyId)

        const ITEMADDON_APP_STORE_MODULE_NAME = 'purchase-store-module'
        if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, purchaseStoreModule)
        onUnmounted(() => {
            if (store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.unregisterModule(ITEMADDON_APP_STORE_MODULE_NAME)
        })

        const toast = useToast()
        const isBusy = ref(false)
        const copyButton = ref({
            text: 'Copy From Party Master',
            isDisabled: false
        })

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
                    key: 'groupName',
                    label: 'Group Name'
                },
                {
                    key: 'termsCondition',
                    label: 'Terms & Condition'
                },
                {
                    key: 'action',
                    label: 'Action'
                },
            ],
            data: [],
        })
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
                })
        }

        const blankFormData = {
            _id: null,
            purchaseOrderId: CurrentPurchaseOrderId.value,
            groupId: null,
            groupName: null,
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
                formData.value.groupName = items[0].groupName ?? null
                formData.value.termsCondition = items[0].termsCondition ?? null
            } else {
                resetFormData()
            }
        }

        const refetchData = async () => {
            isBusy.value = true
            await axios.get(`/api/get-purchase-order-term-conditions/${router.currentRoute.params.id}`)
                .then(res => {
                    table.value.data = res.data.data
                })
            isBusy.value = false
        }
        refetchData()

        const deletePurchaseReturnTerm = async (id) => {
            await Swal.fire({
                title: 'Are you sure?',
                text: 'Delete this item',
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
                        store.dispatch('purchase-store-module/deletePurchaseOrderTermsCondition', { id: id })
                            .then((res) => {
                                if (res.status === 200) {
                                    toast({
                                        component: ToastificationContent,
                                        position: 'top-right',
                                        props: {
                                            title: 'Purchase Order Terms & Condition Deleted',
                                            icon: 'CheckSquareIcon',
                                            variant: 'success',
                                            text: 'You have successfully Deleted Purchase Order Terms & Condition',
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
                        refetchData()
                    }
                })
        }

        const clearModalData = async () => {
            modalTableFields.value.templateDataItems = []
            modalTableFields.value.templateItems = []
            selectedTemplate.value = null
        }

        const openTCTemplateModal = async () => {
            selectedTemplate.value = null
            await axios.get('/api/term-condition-template-master')
                .then((res) => {
                    modalTableFields.value.templateItems = res.data.data
                })
            termConditionModal.value.show()

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
                await axios.post('/api/new/add-purchase-order-term-condition-from-template', {
                    purchaseOrderId: CurrentPurchaseOrderId.value,
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
                        axios.post(`/api/new/copy-term-condition-default-template-purchase-order`, {
                            purchaseOrderId: router.currentRoute.params.id
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
                        axios.post(`/api/new/copy-term-condition-party-master-purchase-order`, {
                            partyId: currentPartyId.value,
                            purchaseOrderId: CurrentPurchaseOrderId.value
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

        const saveFormData = async () => {
            if (formData.value._id === null) {
                await store.dispatch('purchase-store-module/addPurchaseOrderTermsCondition', formData.value)
                    .then(res => {
                        if (res.status === 200) {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Purchase Order Term And Condition Added',
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
            } else {
                await store.dispatch('purchase-store-module/updatePurchaseOrderTermsCondition', formData.value)
                    .then((res) => {
                        if (res.status === 200) {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Purchase Order Term & Condition Updated',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: 'You have successfully Updated Purchase Order Term & Condition',
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
            refetchData,
            isBusy,
            table,
            refFormObserver,
            getValidationState,
            resetForm,
            resetFormData,
            required,
            saveFormData,
            groupOption,
            getGroupData,
            openTCTemplateModal,
            deletePurchaseReturnTerm,
            termConditionModal,
            modalTableIsBusy,
            selectedTemplate,
            modalTableFields,
            getTemplate,
            fromTemplateHandelOk,
            clearModalData,
            defaultTemplate,
            copyFromPartyMaster,
            copyButton,
            onRowSelected
        }
    },

}
</script>
