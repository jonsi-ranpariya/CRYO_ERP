<template>
    <div>
        <b-overlay
            :show="showOverlayLoading"
            rounded="sm"
        >
            <b-card-code>
                <validation-observer #default="{ handleSubmit }" ref="refFormObserver">
                    <b-form @submit.prevent="handleSubmit(saveFormData)" @reset.prevent="resetForm">
                        <b-row>
                            <b-col md="8">
                                <validation-provider
                                    #default="validationContext"
                                    name="Term And Condition For"
                                    rules="required"
                                >
                                    <b-form-group
                                        :state="getValidationState(validationContext)"
                                    >
                                        <label for="tcFor">Term And Condition For <span
                                            class="text-danger erp_required_star">*</span></label>

                                        <v-select
                                            v-model="formData.tcFor"
                                            placeholder="Select For"
                                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                            :options="termConditionForOptions"
                                            :reduce="val => val.value"
                                            :clearable="false"
                                            id="tcFor"
                                        />
                                        <b-form-invalid-feedback :state="getValidationState(validationContext)">
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
                                            placeholder="select Status"
                                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                            :options="statusOption"
                                            :clearable="false"
                                            input-id="active"
                                            :reduce="val => val.value"
                                            v-model="formData.status"
                                        />
                                        <b-form-invalid-feedback>
                                            {{ validationContext.errors[0] }}
                                        </b-form-invalid-feedback>
                                    </b-form-group>
                                </validation-provider>
                            </b-col>
                        </b-row>
                        <b-col md="12">
                            <hr>
                            <b-button
                                type="submit"
                                variant="primary"
                                class="float-right"
                            >
                                Save
                            </b-button>
                        </b-col>
                    </b-form>
                </validation-observer>
            </b-card-code>
        </b-overlay>
        <!--table-->
        <b-overlay
            :show="showOverlayLoading"
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
                      <b-dropdown-item @click="editTermsConditionItem(data.item)">
                        <feather-icon
                            icon="Edit2Icon"
                            class="mr-50"
                        />
                        <span>Edit</span>
                      </b-dropdown-item>
                      <b-dropdown-item @click="deleteTermsConditionItem(data.item._id)">
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
        <!--input fileld-->
        <b-overlay
            :show="showOverlayLoading"
            rounded="sm"
        >
            <b-card-code>
                <validation-observer #default="{ handleSubmit }" ref="refFormObserver">
                    <!-- Form -->
                    <b-form @submit.prevent="handleSubmit(saveTermsItems)"
                            @reset.prevent="resetFormData">
                        <b-row>
                            <b-col md="6">
                                <b-form-group
                                    label="Group"
                                    label-for="tcGroup"
                                >
                                    <v-select
                                        v-model="userformData.tcGroup"
                                        placeholder="Select Group"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="termConditionGroupOptions"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        id="tcGroup"
                                        @input="getTcGroupDetail($event)"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <validation-provider
                                    #default="validationContext"
                                    name="Group Name"
                                    rules="required"
                                >
                                    <b-form-group
                                        :state="getValidationState(validationContext)"
                                    >
                                        <label for="tcFor">Group Name<span
                                            class="text-danger erp_required_star">*</span></label>
                                        <b-form-input
                                            id="groupName"
                                            v-model="userformData.tcGroupName"
                                            :state="getValidationState(validationContext)"
                                        />
                                        <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                            {{ validationContext.errors[0] }}
                                        </b-form-invalid-feedback>
                                    </b-form-group>
                                </validation-provider>
                            </b-col>
                        </b-row>
                        <b-form-group
                            label="Description"
                            label-for="tcDescription"
                        >
                            <b-form-textarea
                                id="tcDescription"
                                v-model="userformData.tcDescription"
                                rows="2"
                            />
                        </b-form-group>
                        <b-col md="12">
                            <hr>
                            <b-button
                                class="float-right"
                                type="submit"
                                variant="primary"
                            >
                                Save
                            </b-button>
                        </b-col>
                    </b-form>
                </validation-observer>
            </b-card-code>
        </b-overlay>
    </div>
</template>
<script>
import {
    BForm,
    BRow,
    BCol,
    BFormGroup,
    BFormInvalidFeedback,
    BButton,
    BOverlay,
    BFormInput,
    BFormTextarea,
    BTable,
    BDropdown,
    BDropdownItem
} from 'bootstrap-vue'
import BCardCode from "../../../@core/components/b-card-code/BCardCode";
import {ValidationObserver, ValidationProvider} from 'vee-validate'
import {ref, onUnmounted} from '@vue/composition-api'
import axios from '@axios'
import vSelect from 'vue-select'
import {required} from '@validations'
import formValidation from '@core/comp-functions/forms/form-validation'
import {useToast} from "vue-toastification/composition";
import store from '@/store'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
import masterStoreModule from '../masterStoreModule'
import router from '@/router'
import Swal from "sweetalert2";
import Toastification from "@core/components/toastification/ToastificationContent.vue";


export default {
    components: {
        BCardCode,
        ValidationObserver,
        ValidationProvider,
        BForm,
        BRow,
        BCol,
        BFormGroup,
        BFormInvalidFeedback,
        vSelect,
        BButton,
        BOverlay,
        BFormInput,
        BFormTextarea,
        BTable,
        BDropdown,
        BDropdownItem
    },
    setup() {
        const showOverlayLoading = ref(false)

        const toast = useToast()
        const ITEMADDON_APP_STORE_MODULE_NAME = 'default-terms-condition-master'
        if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, masterStoreModule)
        onUnmounted(() => {
            if (store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.unregisterModule(ITEMADDON_APP_STORE_MODULE_NAME)
        })

        const termConditionForOptions = ref([
            {label: 'Quotation', value: 1},
            {label: 'Sales Order', value: 2},
            {label: 'Purchase Order', value: 3},
            {label: 'Purchase Card', value: 4},
            {label: 'Invoice', value: 5},
        ])
        const statusOption = ref([
            {label: 'Yes', value: 1},
            {label: 'No', value: 2},
        ])

        const tableData = ref({
            fields: [
                {
                    key: 'tc_details.tcGroupCode',
                    label: 'Group'
                },
                {
                    key: 'tcGroupName',
                    label: 'Group Name'
                },
                {
                    key: 'tcDescription',
                    label: 'Group Description'
                },
                {
                    key: 'action',
                    label: 'Action'
                }
            ],
            rows: []
        })

        const editTermsConditionItem = (data) => {
            userformData.value = data
        }
        const termConditionGroupOptions = ref([])
        axios.get('/api/get-term-condition-detail-with-group-options').then(res => {
            termConditionGroupOptions.value = res.data.data
        })

        const getTcGroupDetail = async (id) => {
            await axios.get(`/api/term-condition-detail-master/${id}`).then(res => {
                userformData.value.tcDescription = res.data.data.tcGroupDescription
                userformData.value.tcGroupName = res.data.data.tc_group_details.groupDescription
            })
        }
        const blankData = {
            _id: null,
            defaultId: router.currentRoute.params.id,
            tcGroup: null,
            tcGroupName: null,
            tcDescription: null,
        }
        const formData = ref({
            _id: null,
            tcFor: null,
            status: null,
        })
        const userformData = ref(JSON.parse(JSON.stringify(blankData)))

        const resetFormData = () => {
            formData.value = JSON.parse(JSON.stringify(formData.value))
            userformData.value = JSON.parse(JSON.stringify(blankData))
        }
        const refetchData = async () => {
            showOverlayLoading.value = true
            await axios.get(`/api/default-term-condition-master/${router.currentRoute.params.id}`).then(res => {
                formData.value._id = res.data.data._id
                formData.value.tcFor = res.data.data.tcFor
                formData.value.status = res.data.data.status
                tableData.value.rows = res.data.data.billing_items
            })
            showOverlayLoading.value = false
        }
        refetchData()

        const deleteTermsConditionItem = async (id) => {
            await Swal.fire({
                title: 'Are you sure?',
                text: "Delete Terms Condition Template",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, do it!',
                cancelButtonText: 'No, keep it!',
                customClass: {
                    confirmButton: 'btn btn-primary',
                    cancelButton: 'btn btn-outline-danger ml-1',
                },
                buttonsStyling: false,
            }).then(result => {
                if (result.value) {
                    store.dispatch('default-terms-condition-master/deleteDefaultTermsConditionItem', {id: id}).then(res => {
                        if (res.status === 200) {
                            toast({
                                component: Toastification,
                                position: 'top-right',
                                props: {
                                    title: ' Default Terms Condition Deleted',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: 'You have successfully Deleted Default Terms Condition',
                                },
                            })
                        } else {
                            toast({
                                component: Toastification,
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

        const saveTermsItems = async () => {
            if (userformData.value._id === null) {
                await store.dispatch('default-terms-condition-master/addDefaultTermsConditionItem', userformData.value).then((res) => {
                    if (res.data.status === 200) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Default Terms & Condition Item Created',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: `You have successfully Created Default Terms & Condition Item`,
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
                await store.dispatch('default-terms-condition-master/updateDefaultTermsConditionItem', userformData.value).then((res) => {
                    if (res.data.status === 200) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Default Terms & Condition Item Updated',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: `You have successfully Updated Default Terms & Condition Item`,
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
            await refetchData()
        }

        const saveFormData = async () => {
            await axios.post('/api/new/default-terms-condition-master-exist',
                {
                    id: formData.value._id,
                    tcFor: formData.value.tcFor
                }
            ).then(res => {
                if (res.data.data === true) {

                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Tems and Condition For Already Exist!',
                    })

                } else {
                    store.dispatch('default-terms-condition-master/updateDefaultTermsCondition', formData.value).then((res) => {
                        if (res.status === 200) {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Default Terms & Condition Update',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: `You have successfully Update Terms & Condition Default.`,
                                },
                            })
                        }
                    })
                }
            })
        }

        const {refFormObserver, getValidationState, resetForm} = formValidation(resetFormData)
        return {
            termConditionForOptions,
            formData,
            refFormObserver,
            getValidationState,
            resetForm,
            resetFormData,
            required,
            saveFormData,
            refetchData,
            showOverlayLoading,
            saveTermsItems,
            termConditionGroupOptions,
            userformData,
            tableData,
            editTermsConditionItem,
            deleteTermsConditionItem,
            getTcGroupDetail,
            statusOption
        }
    }
}
</script>
