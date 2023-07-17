<template>
    <div>
        <b-row>
            <b-col md="12">
                <!-- Table Area -->
                <b-table
                    :fields="tableData.columns"
                    :items="tableData.rows"
                    responsive
                    class="mb-0 table_scroll"
                    bordered
                    hover
                    show-empty
                    :busy="tableData.isBusy"
                >
                    <!-- select-mode="single"
                         selectable
                         @row-selected="onRowSelected"
                     -->

                    <!-- Loader -->
                    <template #table-busy>
                        <div class="text-center my-2">
                            <b-spinner class="align-middle"></b-spinner>
                            <strong>Loading...</strong>
                        </div>
                    </template>

                    <!-- Index -->
                    <template #cell(index)="data">
                        {{ data.index + 1 }}
                    </template>

                    <!-- A custom selection column -->
                    <template #cell(selected)="{ rowSelected }">
                        <template v-if="rowSelected">
                            <feather-icon
                                icon="Edit3Icon"
                                size="16"
                                class="text-body align-middle mr-25"
                            />
                        </template>
                        <template v-else></template>
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
                            <b-dropdown-item @click="editWoAllocation(data.item)">
                                <feather-icon
                                    icon="Edit2Icon"
                                    class="mr-50"
                                />
                                <span>Edit</span>
                            </b-dropdown-item>
                            <b-dropdown-item @click="deleteWoAllocation(data.item._id)">
                                <feather-icon
                                    icon="TrashIcon"
                                    class="mr-50"
                                />
                                <span>Delete</span>
                            </b-dropdown-item>
                        </b-dropdown>
                    </template>
                </b-table>
                <hr>
            </b-col>
            <b-col md="12">
                <!-- Form Area -->
                <validation-observer #default="{ handleSubmit }">
                    <b-form @submit.prevent="handleSubmit(saveFormData)">
                        <b-row>
                            <b-col md="4">
                                <validation-provider
                                    #default="{ errors }"
                                    name="W.O. NO."
                                    rules="required"
                                >
                                    <b-form-group
                                        label="W.O. NO."
                                        label-for="woNumber"
                                        :state="errors.length > 0 ? false:null"
                                    >
                                        <v-select
                                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                            :options="woNumberOption"
                                            :reduce="val => val.value"
                                            input-id="woNumber"
                                            placeholder="select work order"
                                            @input="getWoDetails($event)"
                                            v-model="formData.woId"
                                            :state="errors.length > 0 ? false:null"
                                        />
                                        <small class="text-danger">{{ errors[0] }}</small>
                                    </b-form-group>
                                </validation-provider>
                            </b-col>
                            <b-col md="4">
                                <validation-provider
                                    #default="{ errors }"
                                    name="Item Name"
                                    rules="required"
                                >
                                    <b-form-group
                                        label="Item Name"
                                        label-for="itemName"
                                    >
                                        <b-form-input
                                            id="itemName"
                                            v-model="formData.itemName"
                                            :state="errors.length > 0 ? false:null"
                                        />
                                        <small class="text-danger">{{ errors[0] }}</small>
                                    </b-form-group>
                                </validation-provider>
                            </b-col>
                            <b-col md="4">
                                <b-form-group
                                    label="Req. Qty."
                                    label-for="reqQty"
                                >
                                    <b-form-input
                                        id="reqQty"
                                        v-model="formData.itemReqQty"
                                        type="number"
                                        min="0"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="12">
                                <hr>
                                <b-button
                                    variant="primary"
                                    class="float-right"
                                    type="submit"
                                >
                                    Save
                                </b-button>
                            </b-col>
                        </b-row>
                    </b-form>
                </validation-observer>
            </b-col>
        </b-row>
    </div>
</template>
<script>

import {
    BButton,
    BRow,
    BCol,
    BFormGroup,
    BFormInput,
    BForm,
    BTable,
    BSpinner,
    BDropdown,
    BDropdownItem
} from "bootstrap-vue";
import VSelect from 'vue-select';
import {ref, computed, onMounted, onUnmounted} from '@vue/composition-api';
import axios from '@axios';
import {ValidationProvider, ValidationObserver} from 'vee-validate';
import {required} from '@validations';
import formValidation from "@core/comp-functions/forms/form-validation";
import router from '@/router';
import store from '@/store';
import mrpStoreModule from "../../mrpStoreModule";
import {useToast} from "vue-toastification/composition";
import ToastificationContent from "@core/components/toastification/ToastificationContent";
import Swal from "sweetalert2";

export default {
    components: {
        BForm,
        BButton,
        BRow,
        BCol,
        BFormGroup,
        BFormInput,
        BTable,
        BSpinner,
        BDropdown,
        BDropdownItem,
        VSelect,

        //validation
        ValidationProvider,
        ValidationObserver,
    },
    props: {
        currentItemId: {
            required: true
        }
    },
    setup(props) {
        const APP_STORE_MODULE_NAME = 'mrp-store-module'
        if (!store.hasModule(APP_STORE_MODULE_NAME)) store.registerModule(APP_STORE_MODULE_NAME, mrpStoreModule);
        const toast = useToast();

        /*{label: '',key: 'selected'},*/
        const tableData = ref({
            columns: [
                {
                    label: 'No.',
                    key: 'index'
                },
                {
                    label: 'W.O.No.',
                    key: 'woNumber'
                },
                {
                    label: 'Req Qty',
                    key: 'itemReqQty'
                },
                {
                    label: 'Item Desc',
                    key: 'itemName'
                },
                {
                    label: 'Action',
                    key: 'action'
                }
            ],
            rows: [],
            isBusy: false
        });

        const currentItemId = computed(() => props.currentItemId);

        const woNumberOption = ref([]);
        setTimeout(() => {
            axios.get(`/api/get-work-order-item-list-with-id/${currentItemId.value}`).then((res) => {
                woNumberOption.value = res.data.data
            });
        }, 1000);

        const refetchData = async () => {
            tableData.value.isBusy = true;
            await axios.get(`/api/mrp/manual-planning-allocation-list/${router.currentRoute.params.id}`).then((res) => {
                tableData.value.rows = res.data.data;
            });
            tableData.value.isBusy = false;
        }
        refetchData();

        const blankFormData = {
            _id: null,
            manualPlanningId: router.currentRoute.params.id,
            woId: null,
            woNumber: null,
            itemName: null,
            itemReqQty: 0
        }

        const formData = ref(JSON.parse(JSON.stringify(blankFormData)));

        const resetFormData = () => {
            formData.value = JSON.parse(JSON.stringify(blankFormData));
        }

        const getWoDetails = async (id) => {
            if (id) {
                await axios.get(`/api/get-wo-item-detail-manual/${id}`).then((res) => {
                    formData.value.itemName = res.data.data.itemDescription;
                    formData.value.itemReqQty = res.data.data.itemReqQty ?? 0;
                    formData.value.woNumber = res.data.data?.work_order_detail?.woNumber ?? null;
                });
            } else {
                formData.value.itemName = null;
                formData.value.itemReqQty = 0;
                formData.value.woNumber = null;
            }
        }

        const saveFormData = async () => {
            if (formData.value._id === null) {
                await store.dispatch('mrp-store-module/addWoAllocation', formData.value).then((res) => {
                    if (res.status === 200) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Wo Allocation Added',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: `You have successfully Added Wo Allocation.`,
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
                                text: 'Something went wrong!',
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
                            text: 'Internal server error.',
                        },
                    });
                });
            } else {
                await store.dispatch('mrp-store-module/updateWoAllocation', formData.value).then((res) => {
                    if (res.status === 200) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Wo Allocation Updated',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: `You have successfully Updated Wo Allocation.`,
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
                                text: 'Something went wrong!',
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
                            text: 'Internal server error.',
                        },
                    });
                });
            }
            resetFormData();
            await refetchData();
        }

        const editWoAllocation = (data) => {
            formData.value = data;
        }

        const deleteWoAllocation = async (id) => {
            await Swal.fire({
                title: 'Are you sure?',
                text: "Delete Wo Allocation.",
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
                    store.dispatch('mrp-store-module/deleteWoAllocation', {id: id}).then(res => {
                        if (res.status === 200) {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Wo Allocation Deleted',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: `You have successfully Deleted Wo Allocation.`,
                                },
                            });
                        } else {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Error',
                                    icon: 'AlertCircleIcon',
                                    variant: 'error',
                                    text: 'Something went wrong!',
                                },
                            });
                        }
                    });
                    resetFormData();
                    refetchData();
                }
            });
        }

        const onRowSelected = (item) => {
            formData.value = item[0]
        }

        const {refFormObserver, getValidationState, resetForm} = formValidation(resetFormData);

        return {
            tableData,
            woNumberOption,
            getWoDetails,
            formData,
            resetFormData,
            refetchData,
            saveFormData,
            editWoAllocation,
            deleteWoAllocation,
            onRowSelected,

            //validation
            required,
            refFormObserver,
            getValidationState,
            resetForm,
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
