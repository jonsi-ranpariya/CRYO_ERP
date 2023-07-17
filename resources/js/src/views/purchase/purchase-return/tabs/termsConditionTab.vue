<template>
    <div>
        <!--  table -->
        <b-row>
            <b-col md="12">
                <b-table
                    :fields="tableFields"
                    :items="tableData"
                    responsive
                    class="mb-0"
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
                            <b-dropdown-item @click="deletePurchaseReturnTerm(data.item._id)">
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
                <hr>
            </b-col>
        </b-row>
        <!--  FormData  -->
        <validation-observer #default="{handleSubmit}">
            <b-form @submit.prevent="handleSubmit(saveFormData)">
                <b-row>
                    <b-col md="12">
                        <validation-provider
                            #default="validationContext"
                            name="Group"
                            rules=""
                        >
                            <b-form-group
                                label="Group"
                                label-for="groupId"
                            >
                                <v-select
                                    v-model="formData.groupId"
                                    placeholder="Select group"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="groupOption"
                                    :reduce="val => val.value"
                                    :clearable="false"
                                    input-id="groupId"
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
                                label-for="groupName"
                            >
                                <b-form-input
                                    id="groupName"
                                    :state="getValidationState(validationContext)"
                                    v-model="formData.groupName"
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
                                rows="3"
                                v-model="formData.termAndCondition"
                            />
                        </b-form-group>
                    </b-col>
                    <!--                    <b-col md="6">
                                            <b-form-group
                                                label="Percentage"
                                                label-for="percentage"
                                            >
                                                <b-form-input
                                                    v-model="formData.byPercentage"
                                                    id="percentage"
                                                    :disabled="formData.byValue > 0"
                                                />
                                            </b-form-group>
                                            <b-form-group
                                                label="Value"
                                                label-for="value"
                                            >
                                                <b-form-input
                                                    v-model="formData.byValue"
                                                    id="value"
                                                    :disabled="formData.byPercentage > 0"
                                                />
                                            </b-form-group>
                                        </b-col>-->
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
    </div>
</template>
<script>
import {
    BTable,
    BRow,
    BCol,
    BSpinner,
    BDropdown,
    BDropdownItem,
    BFormGroup,
    BForm,
    BButton,
    BFormInput,
    BFormInvalidFeedback,
    BFormTextarea,
} from 'bootstrap-vue';
import vSelect from 'vue-select';
import {ValidationObserver, ValidationProvider} from 'vee-validate';
import {required} from '@validations';
import {onMounted, onUnmounted, ref} from '@vue/composition-api';
import formValidation from '@core/comp-functions/forms/form-validation';
import axios from '@axios';
import {useToast} from "vue-toastification/composition";
import purchaseStoreModule from "../../purchaseStoreModule";
import router from '@/router';
import store from '@/store';
import ToastificationContent from "@core/components/toastification/ToastificationContent";
import Swal from "sweetalert2";

export default {
    components: {
        ValidationObserver,
        ValidationProvider,
        BTable,
        BRow,
        BCol,
        BSpinner,
        BDropdown,
        BDropdownItem,
        BForm,
        vSelect,
        BButton,
        BFormGroup,
        BFormInput,
        BFormInvalidFeedback,
        BFormTextarea,
    },
    setup() {
        const toast = useToast()
        const ITEMADDON_APP_STORE_MODULE_NAME = 'purchase-store-module'
        onMounted(() => {
            if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, purchaseStoreModule)
        });
        onUnmounted(() => {
            if (store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.unregisterModule(ITEMADDON_APP_STORE_MODULE_NAME)
        });

        const groupOption = ref([]);
        axios.get('/api/get-term-condition-detail-with-group-options').then((res) => {
            groupOption.value = res.data.data
        });

        const isBusy = ref(false);
        const tableFields = ref([
            {
                key: 'rowSelected',
                label: ''
            },
            {
                key: 'index',
                label: 'No',
            },
            {
                key: 'groupName',
                label: 'Group'
            },
            {
                key: 'termAndCondition',
                label: 'Term & Condition'
            },
            {
                key: 'action',
                label: 'Actions'
            }
        ]);
        const tableData = ref([]);

        const refetchData = async () => {
            isBusy.value = true
            await axios.get(`/api/new/purchase-return-term-condition/${router.currentRoute.params.id}`).then((res) => {
                tableData.value = res.data.data
            });
            isBusy.value = false
        }
        refetchData();

        const blankFormData = {
            _id: null,
            purchaseReturnId: router.currentRoute.params.id,
            groupId: null,
            groupName: null,
            termAndCondition: null,
        }

        const formData = ref(JSON.parse(JSON.stringify(blankFormData)));

        const resetFormData = () => {
            formData.value = JSON.parse(JSON.stringify(blankFormData));
        }

        const onRowSelected = (items) => {
            if (items.length > 0) {
                formData.value._id = items[0]._id
                formData.value.purchaseOrderId = items[0].purchaseOrderId ?? null
                formData.value.groupId = items[0].groupId ?? null
                formData.value.groupName = items[0].groupName ?? null
                formData.value.termAndCondition = items[0].termAndCondition  ?? null
            } else {
                resetFormData()
            }
        }

        const getGroupData = async (id) => {
            await axios.get(`/api/get-term-condition-detail-with-group-details/${id}`).then((res) => {
                formData.value.groupName = res.data.data?.tc_group_details?.groupDescription ?? null
                formData.value.termAndCondition = res.data.data.tcGroupDescription
            });
        }

        const saveFormData = async () => {
            if (formData.value._id === null) {
                await store.dispatch('purchase-store-module/addPurchaseReturnTermCondition', formData.value).then((res) => {
                    if (res.status === 200) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Purchase Return Term & Condition Added',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: 'You have successfully Added Purchase Return Term & Condition',
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
                            text: 'Internal server error',
                        },
                    });
                });
            } else {
                await store.dispatch('purchase-store-module/updatePurchaseReturnTermCondition', formData.value).then((res) => {
                    if (res.status === 200) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Purchase Return Term & Condition Updated',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: 'You have successfully Updated Purchase Return Term & Condition',
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
                            text: 'Internal server error',
                        },
                    });
                });
            }
            resetFormData();
            await refetchData();
        }

        const deletePurchaseReturnTerm = async (id) => {
            await Swal.fire({
                title: 'Are you sure?',
                text: "Delete this item",
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
                    store.dispatch('purchase-store-module/deletePurchaseReturnTermCondition', {id: id}).then((res) => {
                        if (res.status === 200) {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Purchase Return Term & Condition Deleted',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: 'You have successfully Deleted Purchase Return Term & Condition',
                                },
                            });
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
                            });
                        }
                    });
                    resetFormData();
                    refetchData();
                }
            });
        }

        const {refFormObserver, getValidationState, resetForm} = formValidation(resetFormData);

        return {
            isBusy,
            formData,
            required,
            refetchData,
            tableFields,
            tableData,
            groupOption,
            refFormObserver,
            getValidationState,
            resetForm,
            resetFormData,
            saveFormData,
            getGroupData,
            deletePurchaseReturnTerm,
            onRowSelected

        }
    }
}
</script>
