<template>
    <div>
        <!-- Table -->
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
                            <b-dropdown-item @click="editItemDetails(data.item)">
                                <feather-icon
                                    icon="Edit2Icon"
                                    class="mr-50"
                                />
                                <span>Edit</span>
                            </b-dropdown-item>
                            <b-dropdown-item @click="deleteItemDetails(data.item._id)">
                                <feather-icon
                                    icon="TrashIcon"
                                    class="mr-50"
                                />
                                <span>Delete</span>
                            </b-dropdown-item>
                        </b-dropdown>
                    </template>
                    <!-- Select Row -->
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

        <!--        Form-->
        <validation-observer #default="{ handleSubmit }">
            <b-form @submit.prevent="handleSubmit(saveFormData)">
                <b-row>
                    <b-col md="6">
                        <validation-provider
                            #default="validationContext"
                            name="Item Code"
                            rules="required"
                        >
                            <b-form-group
                                label="Item Code"
                                label-for="itemCode"
                            >
                                <v-select
                                    v-model="formData.itemCode"
                                    placeholder="Select itemCode"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="itemCodeOption"
                                    :reduce="val => val.value"
                                    :clearable="false"
                                    input-id="itemCode"
                                    @input="getItemDetails($event)"
                                    :state="getValidationState(validationContext)"
                                />
                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
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
                                    v-model="formData.itemDescription"
                                    id="itemDescription"
                                    :state="getValidationState(validationContext)"
                                    readonly
                                />

                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                        <b-form-group
                            label="Add Description"
                            label-for="addDescription"
                        >
                            <b-form-input
                                v-model="formData.itemAddDescription"
                                id="addDescription"
                            />
                        </b-form-group>
                        <b-form-group
                            label="Detail Description"
                            label-for="detailDescription"
                        >
                            <b-form-textarea
                                v-model="formData.itemDetailDescription"
                                id="detailDescription"
                                rows="2"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="6">
                        <b-form-group
                            label="Drawing No."
                            label-for="itemDrawingNo"
                        >
                            <b-form-input
                                v-model="formData.itemDrawingNo"
                                id="itemDrawingNo"
                                type="number"
                            />
                        </b-form-group>
                        <b-form-group
                            label="Drawing Revision"
                            label-for="itemRevision"
                        >
                            <b-form-input
                                id="itemRevision"
                                v-model="formData.itemRevision"
                                type="number"
                            />
                        </b-form-group>
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
                        <b-form-group
                            label="Rate"
                            label-for="itemRate"
                        >
                            <b-form-input
                                v-model="formData.itemRate"
                                id="itemRate"
                            />
                        </b-form-group>
                    </b-col>
                    <!--Button-->
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
                </b-row>
            </b-form>
        </validation-observer>
    </div>
</template>
<script>
    import {
        BTable,
        BForm,
        BRow,
        BCol,
        BSpinner,
        BDropdown,
        BDropdownItem,
        BFormInvalidFeedback,
        BFormGroup,
        BFormInput,
        BFormTextarea,
        BButton,
    } from 'bootstrap-vue'
    import {ref} from "@vue/composition-api";
    import {ValidationObserver, ValidationProvider} from 'vee-validate'
    import vSelect from 'vue-select'
    import formValidation from '@core/comp-functions/forms/form-validation'
    import axios from '@axios'
    import {required} from '@validations'
    import {useToast} from "vue-toastification/composition";
    import purchaseStoreModule from "../../purchaseStoreModule";
    import store from '@/store'
    import Toastification from '@core/components/toastification/ToastificationContent.vue'
    import router from '@/router'
    import Swal from 'sweetalert2'

    export default {
        components: {
            BTable,
            BForm,
            BRow,
            BCol,
            BSpinner,
            BDropdown,
            BDropdownItem,
            ValidationObserver,
            ValidationProvider,
            BFormGroup,
            vSelect,
            BFormInvalidFeedback,
            BFormInput,
            BFormTextarea,
            BButton,
        },
        setup() {
            const toast = useToast()

            const ITEMADDON_APP_STORE_MODULE_NAME = 'purchase-store-module'

            if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, purchaseStoreModule)

            const isBusy = ref(false)

            const itemCodeOption = ref([])
            axios.get('/api/get-item-master-options').then(res => {
                itemCodeOption.value = res.data.data
            })
            const uomOption = ref([])
            axios.get('/api/get-uom-master-options').then(res => {
                uomOption.value = res.data.data
            })

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
                    key: 'item_details.itemCode',
                    label: 'Item Code',
                },
                {
                    key: 'itemDescription',
                    label: 'Description'
                },
                {
                    key: 'uom_details.uom',
                    label: 'UOM'
                },
                {
                    key: 'itemDrawingNo',
                    label: 'Drowing No'
                },
                {
                    key: 'itemRevision',
                    label: 'Revision'
                }, {
                    key: 'itemRate',
                    label: 'Rate'
                },
                {
                    key: 'action',
                    label: 'Action'
                },
            ])

            const tableData = ref([])


            const blankFormData = {
                _id: null,
                purchaseCostingId: router.currentRoute.params.id,
                itemCode: null,
                itemDescription: null,
                itemAddDescription: null,
                itemDetailDescription: null,
                itemDrawingNo: null,
                itemRevision: null,
                itemUom: null,
                itemRate: null,
            }

            const getItemDetails = async (id) => {
                await axios.get(`/api/item-master/${id}`).then(res => {
                    formData.value.itemDescription = res.data.data?.itemDescription ?? null
                    formData.value.itemAddDescription = res.data.data?.itemDetails?.drawingNumber ?? null
                    formData.value.itemDetailDescription = res.data.data?.itemDetails?.detailDescription ?? null
                    formData.value.itemDrawingNo = res.data.data?.itemDetails?.drawingNumber ?? null
                    formData.value.itemRevision = res.data.data?.itemDetails?.revision ?? null
                    formData.value.itemUom = res.data.data?.convUom ?? null
                })
            }

            const formData = ref(JSON.parse(JSON.stringify(blankFormData)))

            const resetFormData = () => {
                formData.value = JSON.parse(JSON.stringify(blankFormData))
            }

            const onRowSelected = (items) => {
                if (items.length > 0) {
                    formData.value._id = items[0]._id
                    formData.value.purchaseOrderId = items[0].purchaseOrderId ?? null
                    formData.value.itemCode = items[0].itemCode ?? null
                    formData.value.itemDescription = items[0].itemDescription ?? null
                    formData.value.itemAddDescription = items[0].itemAddDescription ?? null
                    formData.value.itemDetailDescription = items[0].itemDetailDescription ?? null
                    formData.value.itemDrawingNo = items[0].itemDrawingNo ?? null
                    formData.value.itemRevision = items[0].itemRevision ?? null
                    formData.value.itemUom = items[0].itemUom ?? null
                    formData.value.itemRate = items[0].itemRate ?? null
                } else {
                    resetFormData()
                }
            }

            const refetchData = async () => {
                isBusy.value = true
                await axios.get(`/api/get-purchase-costing-item/${router.currentRoute.params.id}`).then(res => {
                    tableData.value = res.data.data
                })
                isBusy.value = false
            }
            refetchData()

            const editItemDetails = (data) => {
                formData.value = data
            }

            const deleteItemDetails = async (id) => {
                await Swal.fire({
                    title: 'Are you sure?',
                    text: "Delete Purchase Costing",
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
                        store.dispatch('purchase-store-module/deletePurchaseCostingItem', {id: id}).then(res => {
                            if (res.status === 200) {
                                toast({
                                    component: Toastification,
                                    position: 'top-right',
                                    props: {
                                        title: 'Purchase Costing Item Deleted',
                                        icon: 'CheckSquareIcon',
                                        variant: 'success',
                                        text: 'You have successfully Deleted Purchase Costing Item.',
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
                        resetFormData()
                        refetchData()
                    }
                })
            }

            const saveFormData = async () => {
                if (formData.value._id === null) {
                    await store.dispatch('purchase-store-module/addPurchaseCostingItem', formData.value).then(res => {
                        if (res.status === 200) {
                            toast({
                                component: Toastification,
                                position: 'top-right',
                                props: {
                                    title: 'Purchase Costing Item Added',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: 'You have successfully Added Purchase Costing Item.',
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
                } else {
                    await store.dispatch('purchase-store-module/updatePurchaseCostingItem', formData.value).then(res => {
                        if (res.status === 200) {
                            toast({
                                component: Toastification,
                                position: 'top-right',
                                props: {
                                    title: 'Purchase Costing Item Update',
                                    icon: 'CheckSquareIcon',
                                    variant: 'Success',
                                    text: 'You Have successfully Updated Purchase Costing Item.',
                                },
                            })
                        } else {
                            toast({
                                component: Toastification,
                                position: 'top-right',
                                props: {
                                    title: 'Something Went Wrong',
                                    position: 'AlertCircleIcon',
                                    variant: 'Success',
                                    text: 'Something Want Wrong',
                                },
                            })
                        }
                        // console.log(res.data.data)
                    })
                }
                await refetchData()
                resetFormData()
            }


            const {refFormObserver, getValidationState, resetForm} = formValidation(resetFormData)
            return {
                formData,
                isBusy,
                required,
                saveFormData,
                refetchData,
                tableFields,
                tableData,
                itemCodeOption,
                getItemDetails,
                //validation
                refFormObserver,
                resetForm,
                getValidationState,
                resetFormData,
                //dropdown
                uomOption,
                //edit
                editItemDetails,
                deleteItemDetails,
                onRowSelected

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

