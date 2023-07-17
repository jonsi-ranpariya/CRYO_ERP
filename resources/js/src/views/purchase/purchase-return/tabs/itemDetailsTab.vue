<template>
    <div>
        <!-- table -->
        <b-row>
            <b-col md="12">
                <b-table
                    :fields="table.fields"
                    :items="table.data"
                    responsive
                    class="mb-0 table_scroll"
                    bordered
                    hover
                    show-empty
                    :busy="isBusy"
                    selectable
                    select-mode="single"
                    @row-selected="onRowSelect"
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
                            <b-dropdown-item @click="deletePurchaseReturnItem(data.item._id)">
                                <feather-icon
                                    icon="TrashIcon"
                                    class="mr-50"
                                />
                                <span>Delete</span>
                            </b-dropdown-item>
                        </b-dropdown>
                    </template>
                    <!-- Selected Row -->
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
        <!--        table close-->
        <validation-observer #default="{ handleSubmit }">
            <b-form @submit.prevent="handleSubmit(saveFormData)">
                <b-row>
                    <b-col md="7">
                        <b-form-group
                            label="Select Item"
                            label-for="selectItem"
                        >
                            <v-select
                                :clearable="false"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="itemCodeOption"
                                :reduce="(val) => val.value"
                                input-id="selectItem"
                                placeholder="Select itemCode"
                                @input="itemDetails($event)"
                                v-model="formData.itemCodeId"
                            />
                        </b-form-group>
                        <b-row>
                            <b-col md="4">
                                <b-form-group
                                    label="Item Code"
                                    label-for="itemCode"
                                >
                                    <b-form-input
                                        id="itemCode"
                                        v-model="formData.itemCode"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="8">
                                <validation-provider
                                    #default="validationContext"
                                    name="Item Description"
                                    rules="required"
                                >
                                    <b-form-group
                                        label="Item Description"
                                        label-for="itemDescription"
                                    >
                                        <b-form-input
                                            :state="getValidationState(validationContext)"
                                            id="itemDescription"
                                            v-model="formData.itemDescription"
                                        />
                                        <b-form-invalid-feedback>
                                            {{ validationContext.errors[0] }}
                                        </b-form-invalid-feedback>
                                    </b-form-group>
                                </validation-provider>
                            </b-col>
                        </b-row>
                        <b-form-group
                            label="MSN Number"
                            label-for="itemMsnNumber"
                        >
                            <b-form-input
                                id="itemMsnNumber"
                                v-model="formData.itemMsnNumber"
                            />
                        </b-form-group>
                        <b-form-group
                            label="Detail Description"
                            label-for="detailDescription"
                        >
                            <b-form-textarea
                                id="detailDescription"
                                rows="2"
                                v-model="formData.itemDetailDescription"
                            />
                        </b-form-group>
                        <b-row>
                            <b-col md="6">
                                <b-form-group
                                    label="Item Description (Cust)"
                                    label-for="itemCustDescription"
                                >
                                    <b-form-textarea
                                        id="itemCustDescription"
                                        rows="2"
                                        v-model="formData.itemCustDescription"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Add Description"
                                    label-for="addDescription"
                                >
                                    <b-form-textarea
                                        id="addDescription"
                                        rows="2"
                                        v-model="formData.itemAddDescription"
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="4">
                                <b-form-group
                                    label="Drawing No."
                                    label-for="itemDrawingNo"
                                >
                                    <b-form-input
                                        id="itemDrawingNo"
                                        v-model="formData.itemDrawingNo"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group
                                    label="Drawing Revision"
                                    label-for="itemRevision"
                                >
                                    <b-form-input
                                        id="itemRevision"
                                        v-model="formData.itemRevision"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group
                                    label="UOM"
                                    label-for="uom"
                                >
                                    <v-select
                                        v-model="formData.itemUom"
                                        placeholder="Select uom"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="uomOption"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        input-id="uom"
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-form-group
                            label="HSN Number"
                            label-for="itemHsnNumber"
                        >
                            <b-form-input
                                id="itemHsnNumber"
                                v-model="formData.itemHsnNumber"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="5">
                        <b-row>
                            <b-col md="6">
                                <b-form-group
                                    label="Quantity"
                                    label-for="itemQuantity"
                                >
                                    <b-form-input
                                        id="itemQuantity"
                                        v-model="formData.itemQuantity"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Rate"
                                    label-for="itemRate"
                                >
                                    <b-form-input
                                        id="itemRate"
                                        v-model="formData.itemRate"
                                        @keyup="calculateAmount"
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="6">
                                <b-form-group
                                    label="Disc(%)"
                                    label-for="itemDiscount"
                                >
                                    <b-form-input
                                        id="itemDiscount"
                                        v-model="formData.itemDiscount"
                                        @keyup="calculateAmount"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Disc(val)"
                                    label-for="itemDiscountValue"
                                >
                                    <b-form-input
                                        id="itemDiscountValue"
                                        v-model="formData.itemDiscountValue"
                                        @keyup="getItemDiscountCalculation"
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="6">
                                <b-form-group
                                    label="Amount"
                                    label-for="itemAmount"
                                >
                                    <b-form-input
                                        id="itemAmount"
                                        readonly
                                        v-model="formData.itemAmount"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="NetAmount"
                                    label-for="itemNetAmount"
                                >
                                    <b-form-input
                                        id="itemNetAmount"
                                        readonly
                                        v-model="formData.itemNetAmount"
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="4">
                                <b-form-group
                                    label="CGST(%)"
                                    label-for="itemCgstPercent"
                                >
                                    <b-form-input
                                        id="itemCgstPercent"
                                        v-model="formData.itemCgstPercent"
                                        @keyup="gstCalculation"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group
                                    label="SGST(%)"
                                    label-for="itemSgstPercent"
                                >
                                    <b-form-input
                                        id="itemSgstPercent"
                                        v-model="formData.itemSgstPercent"
                                        @keyup="gstCalculation"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group
                                    label="IGST(%)"
                                    label-for="itemIgstPercent"
                                >
                                    <b-form-input
                                        id="itemIgstPercent"
                                        v-model="formData.itemIgstPercent"
                                        @keyup="gstCalculation"
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-form-group
                            label="Remark"
                            label-for="itemRemark"
                        >
                            <b-form-textarea
                                v-model="formData.itemRemark"
                                id="itemRemark"
                            />
                        </b-form-group>
                    </b-col>
                    <!-- Button-->
                    <b-col md="12">
                        <hr/>
                        <b-button
                            class="float-right"
                            type="submit"
                            variant="primary"
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
    BForm,
    BRow,
    BCol,
    BFormGroup,
    BFormInvalidFeedback,
    BFormInput,
    BFormTextarea,
    BButton,
    BTable,
    BSpinner,
    BDropdown,
    BDropdownItem,
} from 'bootstrap-vue'
import {ValidationObserver, ValidationProvider} from 'vee-validate'
import formValidation from "@core/comp-functions/forms/form-validation";
import {computed, onMounted, onUnmounted, ref} from "@vue/composition-api";
import VSelect from "vue-select"
import axios from "@axios"
import router from '@/router'
import {useToast} from "vue-toastification/composition";
import purchaseStoreModule from "../../purchaseStoreModule";
import ToastificationContent from "@core/components/toastification/ToastificationContent";
import store from '@/store'
import Swal from "sweetalert2";
import {changeAmountDecimalPoint, changeToRound} from "@core/utils/utils";

export default {
    components: {
        ValidationObserver,
        ValidationProvider,
        BForm,
        BRow,
        BCol,
        VSelect,
        BFormGroup,
        BFormInvalidFeedback,
        BFormInput,
        BFormTextarea,
        BButton,
        BTable,
        BSpinner,
        BDropdown,
        BDropdownItem,
    },
    props: {
        prRoundingType: {
            required: true,
        }
    },
    setup(props) {
        const toast = useToast()
        const ITEMADDON_APP_STORE_MODULE_NAME = 'purchase-store-module'
        onMounted(() => {
            if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, purchaseStoreModule)
        });
        /*onUnmounted(() => {
            if (store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.unregisterModule(ITEMADDON_APP_STORE_MODULE_NAME)
        });*/

        const isBusy = ref(false)

        const roundingType = computed(() => props.prRoundingType)

        const itemCodeOption = ref([]);
        axios.get("/api/get-item-master-options").then((res) => {
            itemCodeOption.value = res.data.data;
        });

        const uomOption = ref([])
        axios.get('/api/get-uom-master-options').then(res => {
            uomOption.value = res.data.data
        });

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
                    key: 'itemCode',
                    label: 'Item Code'
                },
                {
                    key: 'itemDescription',
                    label: 'Description'
                },
                {
                    key: 'uom_detail.uom',
                    label: 'UOM'
                },
                {
                    key: 'itemQuantity',
                    label: 'Quantity'
                },
                {
                    key: 'itemRate',
                    label: 'Rate'
                },
                {
                    key: 'itemAmount',
                    label: 'Amount'
                },
                {
                    key: 'action',
                    label: 'Actions'
                }
            ],
            data: [],
        });

        const refetchData = async () => {
            isBusy.value = true
            await axios.get(`/api/new/get-purchase-return-items/${router.currentRoute.params.id}`).then((res) => {
                table.value.data = res.data.data
            });
            isBusy.value = false
        }
        refetchData();

        const blankFormData = {
            _id: null,
            purchaseReturnId: router.currentRoute.params.id,
            itemCodeId: null,
            itemCode: null,
            itemDescription: null,
            itemMsnNumber: null,
            itemDetailDescription: null,
            itemCustDescription: null,
            itemAddDescription: null,
            itemDrawingNo: null,
            itemRevision: null,
            itemUom: null,
            itemHsnNumber: null,
            itemQuantity: 0,
            itemRate: 0,
            itemDiscount: 0,
            itemDiscountValue: 0,
            itemAmount: 0,
            itemNetAmount: 0,
            itemCgstPercent: 0,
            itemSgstPercent: 0,
            itemIgstPercent: 0,
            itemCgstAmount: 0,
            itemSgstAmount: 0,
            itemIgstAmount: 0,
            itemRemark: null,
        }

        const formData = ref(JSON.parse(JSON.stringify(blankFormData)));

        const resetFormData = () => {
            formData.value = JSON.parse(JSON.stringify(blankFormData));
        };

        const onRowSelect = (items) => {
            if(items.length > 0){
                formData.value._id = items[0]._id
                formData.value.purchaseReturnId = items[0].purchaseReturnId
                formData.value.itemCodeId = items[0].itemCodeId
                formData.value.itemCode = items[0].itemCode ?? null
                formData.value.itemDescription = items[0].itemDescription ?? null
                formData.value.itemMsnNumber = items[0].itemMsnNumber ?? null
                formData.value.itemDetailDescription = items[0].itemDetailDescription ?? null
                formData.value.itemCustDescription = items[0].itemCustDescription ?? null
                formData.value.itemAddDescription = items[0].itemAddDescription ?? null
                formData.value.itemDrawingNo = items[0].itemDrawingNo ?? null
                formData.value.itemRevision = items[0].itemRevision ?? null
                formData.value.itemUom = items[0].itemUom ?? null
                formData.value.itemUom = itemHsnNumber[0].itemHsnNumber ?? null
                formData.value.itemQuantity = items[0].itemQuantity ?? null
                formData.value.itemRate = items[0].itemRate ?? null
                formData.value.itemDiscount = items[0].itemDiscount ?? null
                formData.value.itemDiscountValue = items[0].itemDiscountValue ?? null
                formData.value.itemAmount = items[0].itemAmount ?? null
                formData.value.itemNetAmount = items[0].itemNetAmount ?? null
                formData.value.itemCgstPercent = items[0].itemCgstPercent ?? null
                formData.value.itemSgstPercent = items[0].itemSgstPercent ?? null
                formData.value.itemIgstPercent = items[0].itemIgstPercent ?? null
                formData.value.itemCgstAmount = items[0].itemCgstAmount ?? null
                formData.value.itemSgstAmount = items[0].itemSgstAmount ?? null
                formData.value.itemIgstAmount = items[0].itemIgstAmount ?? null
                formData.value.itemRemark = items[0].itemRemark ?? null
            }else{
                resetFormData()
            }
        }

        const itemDetails = async (id) => {
            await axios.get(`/api/item-master/${id}`).then((res) => {
                formData.value.itemCode = res.data.data.itemCode
                formData.value.itemDescription = res.data.data.itemDescription
                formData.value.itemMsnNumber = null
                formData.value.itemDetailDescription = res.data.data?.itemDetails?.detailDescription ?? null
                formData.value.itemCustDescription = null
                formData.value.itemAddDescription = res.data.data?.itemDetails?.description ?? null
                formData.value.itemDrawingNo = res.data.data?.itemDetails?.drawingNumber ?? null
                formData.value.itemRevision = res.data.data?.itemDetails?.revision ?? null
                formData.value.itemUom = res.data.data.uom ?? null
                formData.value.itemHsnNumber = res.data.data?.hsnSacDetails?.hsnSacNo ?? null
                formData.value.itemRemark = res.data.data?.itemDetails?.remarkNote ?? null
            });
        }

        const calculateAmount = () => {
            if (roundingType.value === '2') {
                formData.value.itemAmount = changeAmountDecimalPoint(changeToRound(formData.value.itemQuantity * formData.value.itemRate), 2)
                formData.value.itemDiscountValue = changeAmountDecimalPoint(changeToRound((formData.value.itemAmount * formData.value.itemDiscount) / 100), 2)
                formData.value.itemNetAmount = changeAmountDecimalPoint(changeToRound(formData.value.itemAmount - formData.value.itemDiscountValue))
            } else {
                formData.value.itemAmount = formData.value.itemQuantity * formData.value.itemRate
                formData.value.itemDiscountValue = (formData.value.itemAmount * formData.value.itemDiscount) / 100
                formData.value.itemNetAmount = formData.value.itemAmount - formData.value.itemDiscountValue
            }
        }

        const getItemDiscountCalculation = () => {
            let itemAmount = parseFloat(formData.value.itemQuantity * formData.value.itemRate);
            let discountValue = parseFloat(formData.value.itemDiscountValue);
            let isRound = parseInt(roundingType.value)

            if (isRound === 2){
                formData.value.itemNetAmount = changeAmountDecimalPoint(changeToRound(itemAmount - discountValue),2)
                formData.value.itemDiscount = parseFloat((discountValue / itemAmount) * 100).toFixed(2)
            }else{
                formData.value.itemNetAmount = parseFloat(itemAmount - discountValue).toFixed(2);
                formData.value.itemDiscount = parseFloat((discountValue / itemAmount) * 100).toFixed(2);
            }
        }

        const gstCalculation = () => {
            if (roundingType.value === '2') {
                formData.value.itemCgstAmount = changeAmountDecimalPoint(changeToRound(formData.value.itemNetAmount * formData.value.itemCgstPercent / 100), 2)
                formData.value.itemSgstAmount = changeAmountDecimalPoint(changeToRound(formData.value.itemNetAmount * formData.value.itemSgstPercent / 100), 2)
                formData.value.itemIgstAmount = changeAmountDecimalPoint(changeToRound(formData.value.itemNetAmount * formData.value.itemIgstPercent / 100), 2)
            } else {
                formData.value.itemCgstAmount = formData.value.itemNetAmount * formData.value.itemCgstPercent / 100
                formData.value.itemSgstAmount = formData.value.itemNetAmount * formData.value.itemSgstPercent / 100
                formData.value.itemIgstAmount = formData.value.itemNetAmount * formData.value.itemIgstPercent / 100
            }
        }

        const saveFormData = async () => {
            if (formData.value._id === null) {
                await store.dispatch('purchase-store-module/addPurchaseReturnItem', formData.value).then((res) => {
                    if (res.status === 200) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Purchase Return Item Added',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: `You have successfully Added Purchase Return Item.`,
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
                await store.dispatch('purchase-store-module/updatePurchaseReturnItem', formData.value).then((res) => {
                    if (res.status === 200) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Purchase Return Item Updated',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: `You have successfully Updated Purchase Return Item.`,
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

        const deletePurchaseReturnItem = async (id) => {
            await Swal.fire({
                title: 'Are you sure?',
                text: "Delete Purchase Return Item",
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
                    store.dispatch('purchase-store-module/deletePurchaseReturnItem', {id: id}).then((res) => {
                        if (res.status === 200) {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Purchase Return Item Deleted',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: `You have successfully Deleted Purchase Return Item.`,
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
                    resetFormData();
                    refetchData();
                }
            });
        }

        const {refFormObserver, getValidationState, resetForm} = formValidation(resetFormData);

        return {
            isBusy,
            roundingType,
            itemCodeOption,
            uomOption,
            table,
            refetchData,

            itemDetails,
            formData,
            calculateAmount,
            getItemDiscountCalculation,
            gstCalculation,
            saveFormData,
            deletePurchaseReturnItem,

            //validations
            resetFormData,
            refFormObserver,
            resetForm,
            getValidationState,
            onRowSelect
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
