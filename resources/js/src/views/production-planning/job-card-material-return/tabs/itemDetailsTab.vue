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
                    @row-selected="onRowSelect"
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
                            <b-dropdown-item @click="deleteJobCardShopItem(data.item._id)">
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
        <!--<b-col md="12">
            <b-button
                type="button"
                variant="primary"
                @click="refetchData"
            >
                Select Item
            </b-button>
            <hr>
        </b-col>-->
        <validation-observer #default="{ handleSubmit }">
            <b-form @submit.prevent="handleSubmit(saveData)">
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
                                :state="getValidationState(validationContext)"
                            >
                                <v-select
                                    placeholder="Select item"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="itemOptions"
                                    :reduce="val => val.value"
                                    :clearable="false"
                                    input-id="itemCode"
                                    @input="getItemDetails($event)"
                                    v-model="formData.itemCode"
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
                                    id="itemDescription"
                                    v-model="formData.itemDescription"
                                    :state="getValidationState(validationContext)"
                                />

                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                        <b-form-group
                            label="Add Description"
                            label-for="addDescription"
                        >
                            <b-form-input
                                id="addDescription"
                                v-model="formData.addDescription"
                            />
                        </b-form-group>
                        <b-form-group
                            label="Detail Description"
                            label-for="detailsDescription"
                        >
                            <b-form-textarea
                                id="detailsDescription"
                                row="3"
                                v-model="formData.detailDescription"
                            />
                        </b-form-group>
                        <b-form-group
                            label="Drawing Number"
                            label-for="drawingNumber"
                        >
                            <b-form-input
                                id="drawingNumber"
                                v-model="formData.drawingNumber"
                            />
                        </b-form-group>
                        <b-form-group
                            label="Drawing Revision"
                            label-for="drawingRevision"
                        >
                            <b-form-input
                                id="drawingRevision"
                                v-model="formData.drawingRevision"
                            />
                        </b-form-group>
                        <b-form-group
                            label="Quantity"
                            label-for="quantity"
                        >
                            <b-form-input
                                id="quantity"
                                v-model="formData.quantity"
                            />
                        </b-form-group>
                        <b-form-group
                            label="Accept Quantity"
                            label-for="acceptQuantity"
                        >
                            <b-form-input
                                id="acceptQuantity"
                                v-model="formData.acceptQuantity"
                            />
                        </b-form-group>
                        <b-form-group
                            label="Reject Quantity"
                            label-for="rejectQuantity"
                        >
                            <b-form-input
                                id="rejectQuantity"
                                v-model="formData.rejectQuantity"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="6">
                        <b-form-group
                            label="Rate"
                            label-for="rate"
                        >
                            <b-form-input
                                id="rate"
                                v-model="formData.rate"
                            />
                        </b-form-group>
                        <b-form-group
                            label="UOM"
                            label-for="uom"
                        >
                            <v-select
                                placeholder="Select uom"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="uomOption"
                                :reduce="val => val.value"
                                :clearable="false"
                                input-id="uom"
                                v-model="formData.uom"
                            />
                        </b-form-group>
                        <b-form-group
                            label="Note"
                            label-for="note"
                        >
                            <b-form-textarea
                                id="note"
                                rows="3"
                                v-model="formData.note"
                            />
                        </b-form-group>
                        <hr>
                        <h5>Return Item Code For Stock Return Entry</h5>
                        <hr>
                        <b-form-group
                            label="Ret. Item Code"
                            label-for="returnItemCode"
                        >
                            <b-form-input
                                id="returnItemCode"
                                readonly
                                v-model="formData.returnItemCode"
                            />
                        </b-form-group>
                        <b-form-group
                            label="Ret. Item Description"
                            label-for="returnItemDescription"
                        >
                            <b-form-input
                                id="returnItemDescription"
                                readonly
                                v-model="formData.returnItemDescription"
                            />
                        </b-form-group>
                        <b-form-group
                            label="Ret. Item Rate"
                            label-for="returnItemRate"
                        >
                            <b-form-input
                                id="returnItemRate"
                                v-model="formData.returnItemRate"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="12">
                        <hr>
                        <b-button
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
        BCol,
        BRow,
        BFormGroup,
        BFormInput,
        BFormDatepicker,
        BFormTextarea,
        BButton,
        BFormValidFeedback,
        BInputGroupAppend,
        BInputGroup,
        BFormInvalidFeedback,
        BFormRadio,
        BTable,
        BFormCheckbox,
        BCard,
        BTabs,
        BTab,
        BSpinner,
        BDropdown,
        BDropdownItem,
    } from 'bootstrap-vue'
    import BCardCode from "@core/components/b-card-code/BCardCode";
    import {getTcTodayDate} from "@core/utils/utils";
    import vSelect from 'vue-select'
    import Ripple from 'vue-ripple-directive'
    import {onUnmounted, ref, computed} from "@vue/composition-api";
    import store from '@/store'
    import jobCardStoreModule from "../../jobCardStoreModule";
    import {required} from '@validations'
    import {useToast} from 'vue-toastification/composition'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import router from '@/router'
    import axios from '@axios'
    import moment from 'moment'
    import {getUserData} from "../../../../auth/utils";
    import {ValidationProvider, ValidationObserver} from 'vee-validate'
    import formValidation from '@core/comp-functions/forms/form-validation'
    import productionPlanningStoreModule from '../../productionPlanningStoreModule'
    import Swal from 'sweetalert2'

    export default {
        components: {
            BCardCode,
            BFormValidFeedback,
            BInputGroupAppend,
            BInputGroup,
            BFormInvalidFeedback,
            BFormRadio,
            BForm,
            BCol,
            BRow,
            BFormGroup,
            BFormInput,
            BFormTextarea,
            BFormDatepicker,
            BButton,
            BTable,
            BFormCheckbox,
            BCard,
            BSpinner,
            BDropdown,
            BDropdownItem,
            vSelect,
            ValidationProvider,
            ValidationObserver,
        },
        directives: {
            Ripple,
        },
        props: {
            jobCardNumber: {
                type: String
            }
        },
        setup(props) {
            const ITEMADDON_APP_STORE_MODULE_NAME = 'production-planning'
            if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, productionPlanningStoreModule)
            onUnmounted(() => {
                if (store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.unregisterModule(ITEMADDON_APP_STORE_MODULE_NAME)
            })

            const isBusy = ref(false)

            const toast = useToast()

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
                        key: 'item_name.itemCode',
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
                        key: 'quantity',
                        label: 'Quantity'
                    },
                    {
                        key: 'rate',
                        label: 'Rate'
                    },
                    {
                        key: 'action',
                        label: 'Action'
                    },
                ],
                data: [],
            })

            const blankFormData = {
                id: null,
                returnId: router.currentRoute.params.id,
                itemCode: null,
                itemDescription: null,
                addDescription: null,
                detailDescription: null,
                drawingNumber: null,
                drawingRevision: null,
                quantity: null,
                acceptQuantity: null,
                rejectQuantity: null,
                rate: null,
                uom: null,
                note: null,
                returnItemCode: null,
                returnItemDescription: null,
                returnItemRate: null,
            }

            const formData = ref(JSON.parse(JSON.stringify(blankFormData)))

            const resetFormData = () => {
                formData.value = JSON.parse(JSON.stringify(blankFormData))
            }

            const jobCardId = computed(() => props.jobCardNumber)

            const uomOption = ref([])
            axios.get('/api/get-uom-master-options').then(res => {
                uomOption.value = res.data.data
            })

            const itemOptions = ref([])
            axios.get('/api/get-item-master-options').then(res => {
                itemOptions.value = res.data.data
            })

            const refetchData = async () => {
                isBusy.value = true
                await axios.get('/api/get-job-card-return-shop-items/'.concat(router.currentRoute.params.id)).then(res => {
                    table.value.data = res.data.data
                })
                isBusy.value = false
            }
            refetchData()

            const getItemDetails = async (id) => {
                await axios.get('/api/item-master/'.concat(id)).then(res => {
                    formData.value.itemDescription = res.data.data.itemDescription
                    formData.value.addDescription = res.data.data?.itemDetails?.description ?? null
                    formData.value.detailDescription = res.data.data?.itemDetails?.detailDescription ?? null
                    formData.value.drawingNumber = res.data.data?.itemDetails?.drawingNumber ?? null
                    formData.value.drawingRevision = res.data.data?.itemDetails?.revision ?? null
                    formData.value.note = res.data.data?.itemDetails?.remarkNote ?? null
                    formData.value.uom = res.data.data.uom ?? null
                    formData.value.returnItemCode = res.data.data.itemCode ?? null
                })
            }

            const onRowSelect = (items) => {
                if (items.length > 0) {
                    formData.value.id = items[0]._id
                    formData.value.itemCode = items[0].itemCode ?? null
                    formData.value.itemDescription = items[0].itemDescription ?? null
                    formData.value.addDescription = items[0].addDescription ?? null
                    formData.value.detailDescription = items[0].detailDescription ?? null
                    formData.value.drawingNumber = items[0].drawingNumber ?? null
                    formData.value.drawingRevision = items[0].drawingRevision ?? null
                    formData.value.quantity = items[0].quantity ?? null
                    formData.value.acceptQuantity = items[0].acceptQuantity ?? null
                    formData.value.rejectQuantity = items[0].rejectQuantity ?? null
                    formData.value.rate = items[0].rate ?? null
                    formData.value.uom = items[0].uom ?? null
                    formData.value.note = items[0].note ?? null
                    formData.value.returnItemCode = items[0].returnItemCode ?? null
                    formData.value.returnItemDescription = items[0].returnItemDescription ?? null
                    formData.value.returnItemRate = items[0].returnItemRate ?? null
                } else {
                    resetFormData()
                }
            }


            const saveData = async () => {
                if (formData.value.id === null) {
                    await store.dispatch('production-planning/addJobCardReturnShopItem', formData.value).then(res => {
                        if (res.status === 200) {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Job Card Return Shop Item Added',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: `You have successfully Added Job Card Return Shop Item.`,
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
                    await store.dispatch('production-planning/updateJobCardReturnShopItem', formData.value).then(res => {
                        if (res.status === 200) {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Job Card Return Shop Item Updated',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: `You have successfully Update Job Card Return Shop Item.`,
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

            const deleteJobCardShopItem = async (id) => {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Delete Work Order Note",
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
                        store.dispatch('production-planning/deleteJobCardReturnShopItem', {id: id}).then(res => {
                            if (res.status === 200) {
                                toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: 'Job Card Shop Item Deleted',
                                        icon: 'CheckSquareIcon',
                                        variant: 'success',
                                        text: `You have successfully Deleted Job Card Shop Item.`,
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

            const {refFormObserver, getValidationState, resetForm} = formValidation(resetFormData)

            return {
                isBusy,
                table,
                formData,
                resetFormData,
                jobCardId,
                uomOption,
                itemOptions,
                refetchData,
                getItemDetails,
                saveData,
                deleteJobCardShopItem,

                refFormObserver,
                getValidationState,
                resetForm,
                onRowSelect
            }
        }
    }
</script>
<style lang="scss">
    @import '~@core/scss/vue/libs/vue-sweetalert.scss';
</style>

