<template>
    <div>
        <!--table -->
        <b-row>
            <b-col md="12">
                <b-table
                    :fields="table.fields"
                    :items="table.data"
                    responsive
                    class="mb-0"
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
                </b-table>
                <hr>
            </b-col>
        </b-row>
        <!--table Close-->
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
                                <b-input-group>
                                    <b-form-input
                                        id="itemCode"
                                        :state="getValidationState(validationContext)"
                                        v-model="formData.itemCode"
                                    />
                                    <b-input-group-append>
                                        <b-button variant="primary" @click="openModal">...</b-button>
                                    </b-input-group-append>
                                </b-input-group>
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
                                :state="getValidationState(validationContext)"
                            >
                                <b-form-input
                                    v-model="formData.itemDescription"
                                    id="itemDescription"
                                    :state="getValidationState(validationContext)"
                                    readonly
                                />
                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                        <b-form-group
                            label="Add. Description"
                            label-for="addDescription"
                        >
                            <b-form-input
                                id="addDescription"
                                v-model="formData.itemAddDescription"
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
                        <b-row>
                            <b-col md="6">
                                <b-form-group
                                    label="Drawing Number"
                                    label-for="itemDrawingNumber"
                                >
                                    <b-form-input
                                        v-model="formData.itemDrawingNumber"
                                        id="itemDrawingNumber"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Drawing Revision"
                                    label-for="itemDrawingRevision"
                                >
                                    <b-form-input
                                        v-model="formData.itemDrawingRevision"
                                        id="itemDrawingRevision"
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-form-group
                            label="UOM"
                            label-for="uom"
                        >
                            <v-select
                                v-model="formData.itemUom"
                                placeholder="Select Uom"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="uomOption"
                                :reduce="val => val.value"
                                :clearable="false"
                                input-id="uom"
                            />
                        </b-form-group>
                        <b-form-group
                            label="Quntity"
                            label-for="itemQuntity"
                        >
                            <b-form-input
                                v-model="formData.itemQuntity"
                                id="itemQuntity"
                            />
                        </b-form-group>
                        <b-form-group
                            label="Pending Quntity"
                            label-for="pendingQuntity"
                        >
                            <b-form-input
                                v-model="formData.pendingQuntity"
                                id="pendingQuntity"
                            />
                        </b-form-group>
                    </b-col>
                    <!--Button-->
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
        <!--All Item Modal-->
        <b-modal
            id="itemMasterModal"
            title="Select Item Detail"
            ref="itemMasterModal"
            ok-title="submit"
            cancel-variant="danger"
            size="xl"
            no-close-on-backdrop
            @ok="saveItemJobWorkDetail"
            @cancel="resetModalData"
            @close="resetModalData"
        >
            <b-row>
                <b-col md="3">
                    <b-form-group
                        label="Item Code"
                        label-for="itemMasterCode"
                    >
                        <b-form-input
                            id="itemMasterCode"
                            v-model="searchData.itemCode"
                            @keyup="getItemMasterFilter"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="3">
                    <b-form-group
                        label="Item Description"
                        label-for="masterDescription"
                    >
                        <b-form-input
                            id="masterDescription"
                            v-model="searchData.itemDescription"
                            @keyup="getItemMasterFilter"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="3">
                    <b-form-group
                        label="Detail Description"
                        label-for="masterDetailDescription"
                    >
                        <b-form-input
                            id="masterDetailDescription"
                            v-model="searchData.itemDetailDescription"
                            @keyup="getItemMasterFilter"
                        />

                    </b-form-group>
                </b-col>
                <b-col md="3">
                    <b-form-group
                        label="Drawing Number"
                        label-for="masterDrawingNumber"
                    >
                        <b-form-input
                            id="masterDrawingNumber"
                            v-model="searchData.itemDrawingNumber"
                            @keyup="getItemMasterFilter"
                        />
                    </b-form-group>
                </b-col>
            </b-row>

            <b-table
                :fields="modalTableData.itemJobWorkFields"
                :items="modalTableData.itemJobWorkData"
                :no-border-collapse="false"
                responsive
                bordered
                hover
                ok-title="submit"
                cancel-variant="danger"
                size="lg"
                no-close-on-backdrop
                show-empty
                :busy="isModalTableBusy"
            >
                <!-- Loader -->
                <template #table-busy>
                    <div class="text-center my-2">
                        <b-spinner class="align-middle"></b-spinner>
                        <strong>Loading...</strong>
                    </div>
                </template>
                <!-- Index -->
                <template #cell(srNo)="data">
                    {{ data.index + 1 }}
                </template>
                <!-- Empty Text -->
                <template #empty="scope">
                    <h5 class="text-center text-uppercase">No Items Available</h5>
                </template>
                <!-- Checkbox -->
                <template #cell(selectCheckBox)="data">
                    <b-form-checkbox
                        :value="`${data.item._id}`"
                        class="custom-control-primary"
                        @change="selectedItemIds($event, data.item._id)"
                    />
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
        BTable,
        BSpinner,
        BDropdown,
        BDropdownItem,
        BFormInvalidFeedback,
        BFormTextarea,
        BButton,
        BInputGroup,
        BInputGroupAppend,
        BFormCheckbox,

    } from 'bootstrap-vue'
    import {onUnmounted, ref} from '@vue/composition-api'
    import {ValidationObserver, ValidationProvider} from 'vee-validate'
    import formValidation from "../../../../@core/comp-functions/forms/form-validation";
    import {required} from '@validations'
    import vSelect from 'vue-select'
    import axios from '@axios'
    import router from '@/router'
    import {useToast} from "vue-toastification/composition";
    import jobWorkStoreModule from "../../jobWorkStoreModule";
    import ToastificationContent from "@core/components/toastification/ToastificationContent";
    import store from '@/store'
    import Swal from "sweetalert2";

    export default {
        components: {
            BForm,
            BRow,
            BCol,
            BFormGroup,
            BFormInput,
            BTable,
            BSpinner,
            BDropdown,
            BDropdownItem,
            ValidationObserver,
            ValidationProvider,
            vSelect,
            BFormInvalidFeedback,
            BFormTextarea,
            BButton,
            BInputGroup,
            BInputGroupAppend,
            BFormCheckbox
        },
        setup({itemMasterModal}) {
            itemMasterModal = ref()
            const toast = useToast()

            const ITEMADDON_APP_STORE_MODULE_NAME = 'job-rework-item-store-module'
            if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, jobWorkStoreModule)
            onUnmounted(() => {
                if (store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.unregisterModule(ITEMADDON_APP_STORE_MODULE_NAME)
            })

            const isModalTableBusy = ref(false)

            const uomOption = ref([])
            axios.get('/api/get-uom-master-options').then(res => {
                uomOption.value = res.data.data
            })
            const isBusy = ref(false)

            const modalTableData = ref({
                itemJobWorkFields: [
                    {
                        key: 'selectCheckBox',
                        label: ''
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
                        key: 'uom_details.uom',
                        label: 'UOM'
                    },
                    {
                        key: 'itemJobWorkQty',
                        label: 'Quantity'
                    },
                    {
                        key: 'itemPendingQty',
                        label: 'Pending Qty'
                    },
                    {
                        key: 'itemDrawingNumber',
                        label: 'Drawing No'
                    },
                    {
                        key: 'itemDrawingRevision',
                        label: 'Revision'
                    },
                ],
                itemJobWorkData: [],
            })

            const table = ref({
                fields: [
                    {
                        key: 'index',
                        label: 'No',
                    },
                    {
                        key: 'itemCode',
                        label: 'Item Code',
                    },
                    {
                        key: 'itemDescription',
                        label: 'Description',
                    },
                    {
                        key: 'uom_details.uom',
                        label: 'UOM',
                    },
                    {
                        key: 'itemQuntity',
                        label: 'Quantity',
                    },
                    {
                        key: 'itemDrawingNumber',
                        label: 'Drawing No',
                    },
                    {
                        key: 'itemDrawingRevision',
                        label: 'Revision',
                    },
                    {
                        key: 'action',
                        label: 'Action',
                    }
                ],
                data: [],
            })

            const blankFormData = {
                _id: null,
                jobReWorkId: router.currentRoute.params.id,
                jobWorkId:null,
                jobWorkItemId:null,
                itemId:null,
                itemCode: null,
                itemDescription: null,
                itemAddDescription: null,
                itemDetailDescription: null,
                itemDrawingNumber: null,
                itemDrawingRevision: null,
                itemUom: null,
                itemQuntity: null,
            }
            const openModal = () => {
                itemMasterModal.value.show();
            }
            const searchData = ref({
                itemCode: null,
                itemDescription: null,
                itemDetailDescription: null,
                itemDrawingNumber: null,
            })
            const getItemMasterFilter = async () => {
                isModalTableBusy.value = true
                await axios.post('/api/new/get-job-work-item-with-filter', searchData.value).then((res) =>{
                    modalTableData.value.itemJobWorkData = res.data.data

                })
                isModalTableBusy.value = false
            }
            const ItemJobWorkList = ref([])
            const selectedItemIds = (e, id) => {
                if (e === false) {
                    ItemJobWorkList.value = ItemJobWorkList.value.filter(function (e) {
                        return e !== id;
                    });
                } else {
                    ItemJobWorkList.value.push(id)
                }
            }
            const resetModalData = () => {
                searchData.value.itemCode = null
                searchData.value.itemDescription = null
                searchData.value.itemDetailDescription = null
                searchData.value.draitemDrawingNumberwingNumber = null
                ItemJobWorkList.value = []
                modalTableData.value.data = []
            }
            const saveItemJobWorkDetail = async () => {
                await axios.post('/api/new/add-job-work-rework-challan-item', {
                    ids: ItemJobWorkList.value,
                    jobReWorkId: router.currentRoute.params.id
                })
                resetModalData()
                await refetchData()
            }

            const refetchData = async () => {
                isBusy.value = true
                await axios.get(`/api/new/get-job-work-rework-challan-item/${router.currentRoute.params.id}`).then(res => {
                    table.value.data = res.data.data
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
                        store.dispatch('job-rework-item-store-module/deleteJobReWorkChallanItem', {id: id}).then((res) => {
                            if (res.status === 200) {
                                toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: 'Job ReWork Item Deleted',
                                        icon: 'CheckSquareIcon',
                                        variant: 'success',
                                        text: 'You have successfully Deleted Job ReWork Item  ',
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
            const formData = ref(JSON.parse(JSON.stringify(blankFormData)))

            const resetFormData = () => {
                formData.value = JSON.parse(JSON.stringify(blankFormData))
            }

            const saveFormData = async () => {
                if (formData.value._id === null) {
                    store.dispatch('job-rework-item-store-module/addJobReWorkChallanItem', formData.value).then((res) => {
                        if (res.status === 200) {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Job ReWork Item Added',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: 'You have successfully Added Job ReWork Item',
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
                } else {
                    store.dispatch('job-rework-item-store-module/updateJobReWorkChallanItem', formData.value).then((res) => {
                        if (res.status === 200) {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Job ReWork Item Updated',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: 'You have successfully Updated Job ReWork Item',
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
                resetFormData();
                await refetchData()
            }
            const {refFormObserver, getValidationState, resetForm} = formValidation(resetFormData)
            return {
                isBusy,
                table,
                formData,
                resetForm,
                resetFormData,
                getValidationState,
                refFormObserver,
                saveFormData,
                required,
                uomOption,
                refetchData,
                modalTableData,
                openModal,
                itemMasterModal,
                isModalTableBusy,
                searchData,
                getItemMasterFilter,
                deleteItemDetails,
                ItemJobWorkList,
                selectedItemIds,
                saveItemJobWorkDetail,
                resetModalData,
                editItemDetails
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
