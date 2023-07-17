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
                            <b-dropdown-item @click="editWoDeliverySchedule(data.item)">
                                <feather-icon
                                    icon="Edit2Icon"
                                    class="mr-50"
                                />
                                <span>Edit</span>
                            </b-dropdown-item>
                            <b-dropdown-item @click="deleteWoDeliverySchedule(data.item._id)">
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
                <validation-observer #default="{ handleSubmit }">
                    <b-form @submit.prevent="handleSubmit(saveFormData)">
                        <b-row>
                            <b-col md="6">
                                <validation-provider
                                    #default="{ errors }"
                                    name="Delivery Date"
                                    rules="required"
                                >
                                    <b-form-group
                                        label="Delivery Date"
                                        label-for="deliveryDate"
                                        :state="errors.length > 0 ? false:null"
                                    >
                                        <b-input-group
                                            :state="errors.length > 0 ? false:null"
                                        >
                                            <cleave
                                                id="deliveryDate"
                                                v-model="formData.deliveryDate"
                                                class="form-control"
                                                :raw="false"
                                                :options="dateFormat"
                                                placeholder="DD/MM/YYYY"
                                                show-decade-nav
                                                :state="errors.length > 0 ? false:null"
                                            />
                                            <b-input-group-append>
                                                <b-form-datepicker
                                                    v-model="formatDates.deliveryDate"
                                                    button-only
                                                    @input="getDeliveryFormatDate($event)"
                                                    show-decade-nav
                                                    size="sm"
                                                    nav-button-variant="primary"
                                                />
                                            </b-input-group-append>
                                        </b-input-group>
                                        <small class="text-danger">{{ errors[0] }}</small>
                                    </b-form-group>
                                </validation-provider>
                                <b-form-group
                                    label="Quantity"
                                    label-for="quantity"
                                >
                                    <b-form-input
                                        id="quantity"
                                        v-model="formData.quantity"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Total Qty"
                                    label-for="totalQty"
                                >
                                    <b-form-input
                                        id="totalQty"
                                        v-model="formData.totalQty"
                                        readonly
                                    />
                                </b-form-group>
                                <b-form-group
                                    label="PO Qty"
                                    label-for="poQty"
                                >
                                    <b-form-input
                                        id="poQty"
                                        v-model="formData.poQty"
                                        readonly
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="12">
                                <hr>
                                <b-button
                                    variant="primary"
                                    type="submit"
                                    class="float-right"
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
    BTable,
    BRow,
    BCol,
    BFormGroup,
    BFormInput,
    BDropdown,
    BDropdownItem,
    BInputGroup,
    BInputGroupAppend,
    BButton,
    BFormDatepicker,
    BForm,
    BSpinner
} from "bootstrap-vue";
import {onMounted, onUnmounted, ref} from '@vue/composition-api';
import router from '@/router';
import {forMatIndianDate} from "@core/utils/utils";
import Cleave from 'vue-cleave-component'
import axios from '@axios';
import mrpStoreModule from "../../mrpStoreModule";
import {useToast} from "vue-toastification/composition";
import {ValidationProvider, ValidationObserver} from 'vee-validate';
import {required} from '@validations';
import formValidation from "@core/comp-functions/forms/form-validation";
import store from '@/store';
import ToastificationContent from "@core/components/toastification/ToastificationContent";
import Swal from "sweetalert2";

export default {
    components: {
        BTable,
        BRow,
        BCol,
        BFormGroup,
        BFormInput,
        BDropdown,
        BDropdownItem,
        BInputGroup,
        BInputGroupAppend,
        BButton,
        BFormDatepicker,
        Cleave,
        BForm,
        BSpinner,

        //validation
        ValidationProvider,
        ValidationObserver,
    },
    setup() {
        const APP_STORE_MODULE_NAME = 'mrp-store-module'
        if (!store.hasModule(APP_STORE_MODULE_NAME)) store.registerModule(APP_STORE_MODULE_NAME, mrpStoreModule);
        const toast = useToast();

        const tableData = ref({
            columns: [
                {
                    label: 'SR No.',
                    key: 'index'
                },
                {
                    label: 'Date',
                    key: 'deliveryDate'
                },
                {
                    label: 'Quantity',
                    key: 'quantity'
                },
                {
                    label: 'Pend Qty',
                    key: 'pendingQty'
                },
                {
                    label: 'Action',
                    key: 'action'
                }
            ],
            rows: [],
            isBusy: false
        });

        const refetchData = async () => {
            tableData.value.isBusy = true;
            await axios.get(`/api/mrp/manual-planning-delivery-list/${router.currentRoute.params.id}`).then((res) => {
                tableData.value.rows = res.data.data;
            });
            tableData.value.isBusy = false;
        }
        refetchData()

        const blankFormData = {
            _id: null,
            manualPlanningId: router.currentRoute.params.id,
            deliveryDate: null,
            quantity: 0,
            totalQty: 0,
            poQty: 0
        }

        const formData = ref(JSON.parse(JSON.stringify(blankFormData)));

        const resetFormData = () => {
            formData.value = JSON.parse(JSON.stringify(blankFormData));
        }

        const dateFormat = ref({
            date: true,
            delimiter: '/',
            datePattern: ['d', 'm', 'Y'],
        });

        const formatDates = ref({
            deliveryDate: null,
        });

        const getDeliveryFormatDate = (date) => {
            formData.value.deliveryDate = forMatIndianDate(date);
        }

        const saveFormData = async () => {
            if (formData.value._id === null) {
                await store.dispatch('mrp-store-module/addWoDeliverySchedule', formData.value).then((res) => {
                    if (res.status === 200) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Wo Delivery Schedule Created',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: `You have successfully created Wo Delivery Schedule.`,
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
                await store.dispatch('mrp-store-module/updateWoDeliverySchedule', formData.value).then((res) => {
                    if (res.status === 200) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Wo Delivery Schedule Updated',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: `You have successfully Updated Wo Delivery Schedule.`,
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

        const editWoDeliverySchedule = (data) => {
            formData.value = data;
        }

        const deleteWoDeliverySchedule = async (id) => {
            await Swal.fire({
                title: 'Are you sure?',
                text: "Delete Wo Delivery Schedule.",
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
                    store.dispatch('mrp-store-module/deleteWoDeliverySchedule', {id: id}).then(res => {
                        if (res.status === 200) {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Wo Delivery Schedule Deleted',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: `You have successfully Deleted Wo Delivery Schedule.`,
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

        const {refFormObserver, getValidationState, resetForm} = formValidation(resetFormData);

        return {
            tableData,
            refetchData,
            formData,
            resetFormData,
            dateFormat,
            formatDates,
            getDeliveryFormatDate,
            saveFormData,
            editWoDeliverySchedule,
            deleteWoDeliverySchedule,

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
