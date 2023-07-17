<template>
    <div>
        <!-- Table -->
        <b-row>
            <b-col md="12">
                <b-table
                    :busy="isBusy"
                    :fields="tableFields"
                    :items="tableData"
                    bordered
                    class="mb-0 table_scroll"
                    hover
                    responsive
                    show-empty
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
                            no-caret
                            toggle-class="text-decoration-none"
                            variant="link"
                        >
                            <template v-slot:button-content>
                                <feather-icon
                                    class="text-body align-middle mr-25"
                                    icon="MoreVerticalIcon"
                                    size="16"
                                />
                            </template>
                            <b-dropdown-item
                                @click="editItemDetails(data.item)"
                            >
                                <feather-icon
                                    class="mr-50"
                                    icon="Edit2Icon"
                                />
                                <span>Edit</span>
                            </b-dropdown-item>
                            <b-dropdown-item
                                @click="deleteItemDetail(data.item._id)"
                            >
                                <feather-icon
                                    class="mr-50"
                                    icon="TrashIcon"
                                />
                                <span>Delete</span>
                            </b-dropdown-item>
                        </b-dropdown>
                    </template>
                </b-table>
                <hr/>
            </b-col>
        </b-row>
        <hr>
        <validation-observer #default="{handleSubmit}">
            <b-form @submit.prevent="handleSubmit(saveFormData)">
                <b-row>
                    <b-col md="6">
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
                                            v-model="formDataIssue.issueItemCode"
                                            placeholder="Select Status"
                                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                            :options="itemCodeOptions"
                                            :reduce="val => val.value"
                                            :clearable="false"
                                            input-id="itemCode"
                                            @input="getItemDetails($event)"
                                        />
                                        <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                            {{ validationContext.errors[0] }}
                                        </b-form-invalid-feedback>
                                    </b-form-group>
                                </validation-provider>
                            </b-col>
                            <b-col md="6">
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
                                            v-model="formDataIssue.issueItemDescription"
                                            id="itemDescription"
                                            :state="getValidationState(validationContext)"
                                        />
                                        <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                            {{ validationContext.errors[0] }}
                                        </b-form-invalid-feedback>
                                    </b-form-group>
                                </validation-provider>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="6">
                                <b-form-group
                                    label="Add Description"
                                    label-for="addDescription"
                                >
                                    <b-form-textarea
                                        id="addDescription"
                                        rows="2"
                                        v-model="formDataIssue.issueItemAddDescription"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Detail Description"
                                    label-for="detailDescription"
                                >
                                    <b-form-textarea
                                        id="detailDescription"
                                        readonly
                                        rows="2"
                                        v-model="formDataIssue.issueItemDetailDescription"
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="6">
                                <b-form-group
                                    label="Drawing No."
                                    label-for="itemDrawingNo"
                                >
                                    <b-form-input
                                        id="itemDrawingNo"
                                        readonly
                                        v-model="formDataIssue.issueItemDrawingNo"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Drawing Revision"
                                    label-for="itemRevision"
                                >
                                    <b-form-input
                                        id="itemRevision"
                                        readonly
                                        v-model="formDataIssue.issueItemRevision"
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="6">
                                <b-form-group
                                    label="Required Quantity"
                                    label-for="requiredQty"
                                >
                                    <b-form-input
                                        v-model="formDataIssue.issueRequiredQty"
                                        id="requiredQty"
                                        type="number"
                                        @keyup="calculateAmount"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Required Qty(Conv)"
                                    label-for="requiredQtyConv"
                                >
                                    <b-form-input
                                        v-model="formDataIssue.issueRequiredQtyConv"
                                        id="requiredQtyConv"
                                        type="number"
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>
                    </b-col>

                    <b-col md="6">
                        <b-form-group
                            label="Issue Qty"
                            label-for="issueQty"
                        >
                            <b-form-input
                                v-model="formDataIssue.issueItemQty"
                                id="issueQty"
                                type="number"
                            />
                        </b-form-group>
                        <b-row>
                            <b-col md="6">
                                <b-form-group
                                    label="UOM"
                                    label-for="uom"
                                >
                                    <v-select
                                        v-model="formDataIssue.issueItemUom"
                                        placeholder="Select uom"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="uomOption"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        input-id="uom"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Conv UOM"
                                    label-for="convUom"
                                >
                                    <v-select
                                        v-model="formDataIssue.issueItemConvUom"
                                        placeholder="Select uom"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="convUomOPtion"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        input-id="convUom"
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="6">
                                <b-form-group
                                    label="Conv.Factor"
                                    label-for="convFactor"
                                >
                                    <b-form-input
                                        v-model="formDataIssue.issueItemConvFactor"
                                        id="itemConvFactor"
                                        @keyup="calculateAmount"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Conv. Qty"
                                    label-for="convQty"
                                >
                                    <b-form-input
                                        v-model="formDataIssue.issueItemConvQty"
                                        id="itemConvQty"
                                        type="number"
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="6">
                                <b-form-group
                                    label="Current Stock"
                                    label-for="currentStock"
                                >
                                    <b-form-input
                                        v-model="formDataIssue.issueCurrentStock"
                                        id="currentStock"
                                        type="number"
                                        readonly
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Stock At Sub-Contractor"
                                    label-for="stockSunContractor"
                                >
                                    <b-form-input
                                        v-model="formDataIssue.issueStockSubContractor"
                                        id="stockSubContractor"
                                        type="number"
                                        readonly
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-form-group
                            label="Remark"
                            label-for="processRemark"
                        >
                            <b-form-textarea
                                v-model="formDataIssue.issueItemremark"
                                id="itemremark"
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
                    <hr>
                </b-row>
            </b-form>
        </validation-observer>
    </div>
</template>
<script>
    import {
        BCol,
        BRow,
        BForm,
        BFormGroup,
        BFormInput,
        BFormTextarea,
        BButton,
        BFormDatepicker,
        BTable,
        BSpinner,
        BDropdown,
        BDropdownItem,
        BFormInvalidFeedback,
        BFormRadio,
        BFormCheckbox,
        BInputGroup,
        BInputGroupAppend
    } from 'bootstrap-vue'
    import {ValidationProvider, ValidationObserver} from 'vee-validate'
    import {onUnmounted, ref} from "@vue/composition-api";
    import formValidation from '@core/comp-functions/forms/form-validation'
    import vSelect from 'vue-select'
    import axios from '@axios'
    import {useToast} from "vue-toastification/composition";
    import jobCardStoreModule from "../../jobCardStoreModule";
    import store from '@/store'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import router from '@/router'
    import Swal from "sweetalert2";
    export default {
        components: {
            ValidationObserver,
            ValidationProvider,
            BCol,
            BRow,
            BForm,
            BFormGroup,
            BFormInput,
            BFormTextarea,
            BButton,
            BFormDatepicker,
            BTable,
            BSpinner,
            BDropdown,
            BDropdownItem,
            BFormInvalidFeedback,
            BFormRadio,
            BFormCheckbox,
            BInputGroup,
            BInputGroupAppend,
            vSelect
        },
        setup() {
            const toast = useToast()
            const isBusy = ref(false)
            const SE_APP_STORE_MODULE_NAME = 'job-card-process-detail'
            if (!store.hasModule(SE_APP_STORE_MODULE_NAME)) store.registerModule(SE_APP_STORE_MODULE_NAME, jobCardStoreModule)
            onUnmounted(() => {
                if (store.hasModule(SE_APP_STORE_MODULE_NAME)) store.unregisterModule(SE_APP_STORE_MODULE_NAME)
            })
            const uomOption = ref([])
            axios.get('/api/get-uom-master-options').then(res => {
                uomOption.value = res.data.data
            })
            const convUomOPtion = ref([])
            axios.get('/api/get-uom-master-options').then(res => {
                convUomOPtion.value = res.data.data
            })
            const itemCodeOptions = ref([])
            axios.get('/api/get-item-master-options').then(res => {
                itemCodeOptions.value = res.data.data
            })

            const getItemDetails = async (id) => {
                await axios.get(`/api/item-master/${id}`).then(res => {
                    formDataIssue.value.itemId = res.data.data?._id ?? null
                    formDataIssue.value.issueItemUom = res.data.data?.uom_details?.uom ?? null
                    formDataIssue.value.issueItemDescription = res.data.data?.itemDescription ?? null
                    formDataIssue.value.issueItemConvUom = res.data.data?.convUom ?? null
                    formDataIssue.value.issueItemAddDescription = res.data.data?.itemDetails?.description ?? null
                    formDataIssue.value.issueItemDetailDescription = res.data.data?.itemDetails?.detailDescription ?? null
                    formDataIssue.value.issueItemDrawingNo = res.data.data?.itemDetails?.drawingNumber ?? null
                    formDataIssue.value.issueItemRevision = res.data.data?.itemDetails?.revision ?? null
                    formDataIssue.value.issueItemConvQty = res.data.data?.convQty ?? null
                    formDataIssue.value.issueItemConvFactor = res.data.data?.cFactor ?? null
                    formDataIssue.value.issueItemremark = res.data.data?.itemDetails?.remarkNote ?? null
                })
            }
            const calculateAmount = () => {
                formDataIssue.value.issueRequiredQtyConv = formDataIssue.value.issueRequiredQty * formDataIssue.value.issueItemConvFactor
                formDataIssue.value.issueItemQty = formDataIssue.value.issueRequiredQty
            }
            const tableFields = ref([
                    {
                        key: "index",
                        label: "No"
                    },
                    {
                        key: "item_name.itemCode",
                        label: "Item Code"
                    },
                    {
                        key: "issueItemDescription",
                        label: "Item Description"
                    },
                    {
                        key: "uom_detail.uom",
                        label: "UOM"
                    },
                    {
                        key: "issueRequiredQty",
                        label: 'Quntity'
                    },
                    {
                        key: "issueItemQty",
                        label: "Issue Qty"
                    },
                    {
                        key: "issueItemPendingQty",
                        label:"Pending Qty"
                    },
                    {
                        key: "action",
                        label: "Action"
                    },
            ])
            const tableData = ref([])
            const blankFormData = {
                _id: null,
                jobId: router.currentRoute.params.id,
                itemId:null,
                issueItemCode: null,
                issueItemDescription: null,
                issueItemAddDescription: null,
                issueItemDetailDescription: null,
                issueItemDrawingNo: null,
                issueItemRevision: null,
                issueRequiredQty: null,
                issueRequiredQtyConv: null,
                issueItemQty: null,
                issueItemUom: null,
                issueItemConvUom: null,
                issueItemConvFactor: null,
                issueItemConvQty: null,
                issueCurrentStock: null,
                issueStockSubContractor: null,
                issueItemremark: null,
            }

            const formDataIssue = ref(JSON.parse(JSON.stringify(blankFormData)))

            const resetFormData = () => {
                formDataIssue.value = JSON.parse(JSON.stringify(blankFormData))
            }
            const refetchData = async () => {
                isBusy.value = true;
                await axios.get(`/api/new/get-show-issue-item/${router.currentRoute.params.id}`)
                    .then((res) => {
                        tableData.value = res.data.data;
                    });
                isBusy.value = false;
            }
            refetchData();

            const editItemDetails = (data) => {
                formDataIssue.value = data
            }
            const deleteItemDetail = async (id) => {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Delete Job Card Process Issue Item",
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
                        store.dispatch('job-card-process-detail/deleteShowIssueItems', {id: id}).then(res => {
                            if (res.status === 200) {
                                toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: 'Job Card Process Issue Item Deleted',
                                        icon: 'CheckSquareIcon',
                                        variant: 'success',
                                        text: `You have successfully Deleted Job Card Process Issue Item.`,
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
                if(formDataIssue.value._id === null) {
                await store.dispatch('job-card-process-detail/addShowIssueItems', formDataIssue.value).then(res => {
                    if (res.status === 200) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Job Card Process Issue Item Added',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: 'You have successfully Added Job Card Process Issue Item',
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
                }else {
                    await store.dispatch('job-card-process-detail/updateShowIssueItems', formDataIssue.value).then(res => {
                        if (res.status === 200) {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Job Card Proces Issue Item Updated',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: `You have successfully Update Job Card Proces Issue Item.`,
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
            const {refFormObserver, getValidationState, resetForm} = formValidation(resetFormData)

            return {
                formDataIssue,
                resetFormData,
                refFormObserver,
                getValidationState,
                resetForm,
                saveFormData,
                editItemDetails,
                deleteItemDetail,
                tableFields,
                tableData,
                calculateAmount,
                uomOption,
                convUomOPtion,
                itemCodeOptions,
                getItemDetails,
                refetchData,
                isBusy
            }
        }
    }
</script>
