<template>
    <div>
        <!-- Top Area -->
        <!--<b-row>
            <b-col md="3">
                <b-form-group
                    label="Box Description"
                    label-for="boxDescription"
                >
                    <b-form-input
                        id="boxDescription"
                        readonly
                    />
                </b-form-group>
            </b-col>
            <b-col md="3">
                <b-form-group
                    label="Wt Description"
                    label-for="wtDescription"
                >
                    <b-form-input
                        id="wtDescription"
                        readonly
                    />
                </b-form-group>
            </b-col>
            <b-col md="3">
                <b-form-group
                    label="Dim Of Box.?"
                    label-for="dimOfBox"
                >
                    <b-form-input
                        id="dimOfBox"
                        readonly
                    />
                </b-form-group>
            </b-col>
            <b-col md="3">
                <b-form-group
                    label="Total Case"
                    label-for="totalCase"
                >
                    <b-form-input
                        id="totalCase"
                        readonly
                    />
                </b-form-group>
            </b-col>
        </b-row>-->
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
                            <b-dropdown-item @click="editPackingItemdetails(data.item)">
                                <feather-icon
                                    icon="Edit2Icon"
                                    class="mr-50"
                                />
                                <span>Edit</span>
                            </b-dropdown-item>
                            <b-dropdown-item @click="deletePackingItemdetails(data.item._id)">
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
        </b-row>
        <!-- Form Area -->
        <validation-observer #default="{ handleSubmit }">
            <b-form @submit.prevent="handleSubmit(saveFormData)">
                <b-row>
                    <b-col md="7">
                        <validation-provider
                            #default="validationContext"
                            name="Item Code"
                            rules="required"
                        >
                            <b-form-group
                                label="Item Code"
                                label-for="itemCode"
                                :state="getValidationState(validationContext)"
                            >
                                <v-select
                                    placeholder="Select Item"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="itemOptions"
                                    :clearable="false"
                                    input-id="itemCode"
                                    :reduce="val => val.value"
                                    @input="getItemDetails($event)"
                                    v-model="formData.itemCode"
                                />
                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                        <b-form-group
                            label="Item Description"
                            label-for="itemDescription"
                        >
                            <b-form-input
                                id="itemDescription"
                                v-model="formData.itemDescription"
                            />
                        </b-form-group>
                        <b-form-group
                            label="Add. Description"
                            label-for="itemAddDescription"
                        >
                            <b-form-input
                                id="itemAddDescription"
                                v-model="formData.itemAddDescription"
                            />
                        </b-form-group>
                        <b-form-group
                            label="Detail Description"
                            label-for="itemDetailDescription"
                        >
                            <b-form-input
                                id="itemDetailDescription"
                                v-model="formData.itemDetailDescription"
                            />
                        </b-form-group>
                        <b-form-group
                            label="Drawing Number"
                            label-for="itemDrawingNumber"
                        >
                            <b-form-input
                                id="itemDrawingNumber"
                                v-model="formData.itemDrawingNumber"
                            />
                        </b-form-group>
                        <b-form-group
                            label="Drawing Revision"
                            label-for="itemDrawingRevision"
                        >
                            <b-form-input
                                id="itemDrawingRevision"
                                v-model="formData.itemDrawingRevision"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="5">
                        <b-form-group
                            label="Case No."
                            label-for="caseNo"
                        >
                            <b-form-input
                                id="caseNo"
                                v-model="formData.caseNo"
                            />
                        </b-form-group>
                        <b-form-group
                            label="Marks & Nos"
                            label-for="markAndNos"
                        >
                            <b-form-input
                                id="markAndNos"
                                v-model="formData.markAndNos"
                            />
                        </b-form-group>
                        <b-form-group
                            label="Total Qty"
                            label-for="totalQuantity"
                        >
                            <b-form-input
                                id="totalQuantity"
                                v-model="formData.totalQuantity"
                            />
                        </b-form-group>
                        <b-form-group
                            label="Total Net Wt."
                            label-for="totalNetWeight"
                        >
                            <b-form-input
                                id="totalNetWeight"
                                v-model="formData.totalNetWeight"
                            />
                        </b-form-group>
                        <b-form-group
                            label="Total Gs Wt."
                            label-for="totalGsWeight"
                        >
                            <b-form-input
                                id="totalGsWeight"
                                v-model="formData.totalGsWeight"
                            />
                        </b-form-group>
                        <b-form-group
                            label="Dim. Of Box"
                            label-for="dimOfBox"
                        >
                            <b-form-input
                                id="dimOfBox"
                                v-model="formData.dimOfBox"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="12">
                        <hr>
                        <b-button
                            type="submit"
                            variant="primary"
                            class="float-right"
                        >
                            Save
                        </b-button>
                        <!--<b-button
                            type="button"
                            variant="primary"
                            class="float-right mr-1"
                            @click="generatePdf"
                            :disabled="packingButton.isDisable"
                        >
                            <feather-icon
                                icon="FileIcon"
                                size="16"
                                class="text-body align-middle mr-25"
                            />
                            {{ packingButton.isText }}
                        </b-button>-->
                    </b-col>
                </b-row>
            </b-form>
        </validation-observer>
    </div>
</template>
<script>
    import BCardCode from "@core/components/b-card-code/BCardCode";
    import formValidation from "@core/comp-functions/forms/form-validation";
    import {
        BButton,
        BCol,
        BForm,
        BFormCheckbox,
        BFormDatepicker,
        BFormGroup,
        BFormInput,
        BFormInvalidFeedback,
        BFormRadio,
        BOverlay,
        BRow,
        BTab,
        BTabs,
        BFormTextarea,
        BInputGroup,
        BInputGroupAppend,
        BTable,
        BDropdown,
        BDropdownItem,
        BSpinner
    } from 'bootstrap-vue'
    import {ValidationObserver, ValidationProvider} from 'vee-validate'
    import vSelect from 'vue-select'
    import {onUnmounted, ref} from "@vue/composition-api";
    import router from "@/router";
    import store from '@/store'
    import {required} from '@validations'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import {useToast} from 'vue-toastification/composition'
    import dispatchStoreModule from "../../dispatchStoreModule";
    import axios from '@axios'
    import {getTcTodayDate, forMatIndianDate} from "@core/utils/utils";
    import Cleave from 'vue-cleave-component'
    import Swal from 'sweetalert2'

    export default {
        components: {
            BCardCode,
            ValidationObserver,
            ValidationProvider,
            vSelect,
            BForm,
            BRow,
            BCol,
            BFormGroup,
            BFormInput,
            BFormInvalidFeedback,
            BFormTextarea,
            BFormDatepicker,
            BFormCheckbox,
            BButton,
            BOverlay,
            BTabs,
            BTab,
            BFormRadio,
            BInputGroup,
            BInputGroupAppend,
            Cleave,
            BTable,
            BDropdown,
            BDropdownItem,
            BSpinner,
        },
        setup() {
            const ITEMADDON_APP_STORE_MODULE_NAME = 'dispatch-store-module'
            if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, dispatchStoreModule)

            const toast = useToast()
            const isBusy = ref(false)

            const tableFields = ref([
                {
                    key: 'index',
                    label: 'Sr No',
                },
                {
                    key: 'item_details.itemCode',
                    label: 'Item Code'
                },
                {
                    key: 'caseNo',
                    label: 'Case No'
                },
                {
                    key: 'totalBox',
                    label: 'Tot Box',
                },
                {
                    key: 'markAndNos',
                    label: 'Mark & Nos',
                },
                {
                    key: 'totalQuantity',
                    label: 'Tot Qty',
                },
                {
                    key: 'totalNetWeight',
                    label: 'TotNetWt',
                },
                {
                    key: 'totalGstWeight',
                    label: 'TotGstWt',
                },
                {
                    key: 'totalGsWeight',
                    label: 'TotGsWt',
                },
                {
                    key: 'totalGsWeight',
                    label: 'TotGsWt',
                },
                {
                    key: 'action',
                    label: 'Actions',
                },
            ])
            const tableData = ref([])

            const refetchData = async () => {
                isBusy.value = true
                await axios.get(`/api/get-new-challan-shipping-list/${router.currentRoute.params.id}`).then((res) => {
                    tableData.value = res.data.data
                });
                isBusy.value = false
            }
            refetchData()

            const itemOptions = ref([])
            axios.get(`/api/get-challan-and-invoice-item-options/${router.currentRoute.params.id}`).then(res => {
                itemOptions.value = res.data.data
            });

            const blankFormData = {
                challanInvoiceId: router.currentRoute.params.id,
                _id: null,
                itemCode: null,
                itemDescription: null,
                itemAddDescription: null,
                itemDetailDescription: null,
                itemDrawingNumber: null,
                itemDrawingRevision: null,
                caseNo: null,
                markAndNos: null,
                totalQuantity: null,
                totalNetWeight: null,
                totalGsWeight: null,
                dimOfBox: null,
            }

            const formData = ref(JSON.parse(JSON.stringify(blankFormData)))

            const resetFormData = () => {
                formData.value = JSON.parse(JSON.stringify(blankFormData))
            }

            const getItemDetails = async (id) => {
                await axios.get(`/api/new-challan-and-invoice-item/${id}`).then((res) => {
                    formData.value.itemDescription = res.data.data.itemDescription
                    formData.value.itemAddDescription = res.data.data.itemAddDescription
                    formData.value.itemDetailDescription = res.data.data.itemDetailDescription
                    formData.value.itemDrawingNumber = res.data.data.itemDrawingNo
                    formData.value.itemDrawingRevision = res.data.data.itemRevision
                    formData.value.totalQuantity = res.data.data.itemQuantity
                });
            }

            const editPackingItemdetails = (data) => {
                formData.value = data
            }

            const deletePackingItemdetails = async (id) => {
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
                        store.dispatch('dispatch-store-module/deleteNewInvoiceChallanShipping', {id: id}).then((res) => {
                            if (res.status === 200) {
                                toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: 'Challan & Invoice Shipping Item Deleted',
                                        icon: 'CheckSquareIcon',
                                        variant: 'success',
                                        text: 'You have successfully Deleted Challan & Invoice Shipping Item',
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
                        resetFormData()
                        refetchData()
                    }
                });
            }

            const saveFormData = async () => {
                if (formData.value._id === null){
                    await store.dispatch('dispatch-store-module/addNewInvoiceChallanShipping', formData.value).then((res) => {
                        if (res.status === 200) {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Challan & Invoice Shipping Item Added',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: 'You have successfully Added Shipping Item',
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
                }else{
                    await store.dispatch('dispatch-store-module/updateNewInvoiceChallanShipping', formData.value).then((res) => {
                        if (res.status === 200) {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Challan & Invoice Shipping Item Updated',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: 'You have successfully Updated Shipping Item',
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
                }

                resetFormData();
                await refetchData();
            }

            const packingButton = ref({
                isDisable: false,
                isText: 'Package List'
            });

            const generatePdf = async () => {
                packingButton.value.isDisable = true;
                packingButton.value.isText = 'Please Wait...';
                await axios.post('/pdf/generate-challan-package-list-invoice', {
                    challanInvoiceId: router.currentRoute.params.id
                }).then((res) => {
                    if (res.data.path){
                        window.open(res.data.path, '_blank')
                    }
                }).catch((error) => {
                    toast({
                        component: ToastificationContent,
                        position: 'top-right',
                        props: {
                            title: 'Error: ',
                            icon: 'AlertCircleIcon',
                            variant: 'danger',
                            text: `${error?.response?.data?.message ?? 'Internal server error'}`,
                        },
                    });
                });
                packingButton.value.isDisable = false;
                packingButton.value.isText = 'Package List';
            }

            const {refFormObserver, getValidationState, resetForm} = formValidation(resetFormData)

            return {
                isBusy,
                tableFields,
                tableData,
                refetchData,
                itemOptions,
                formData,
                resetFormData,
                getItemDetails,
                editPackingItemdetails,
                deletePackingItemdetails,
                saveFormData,
                packingButton,
                generatePdf,

                //validation
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
