<template>
    <div>
        <b-card-code>
            <validation-observer #default="{ handleSubmit }">
                <b-form @submit.prevent="handleSubmit(saveFormData)">
                    <b-row>
                        <b-col md="6">
                            <validation-provider
                                #default="validationContext"
                                name="W.O.No"
                          s      rules="required"
                            >
                                <b-form-group
                                    label="W.O.No"
                                    label-for="woNumber"
                                    :state="getValidationState(validationContext)"
                                >
                                    <b-input-group>
                                        <b-form-input
                                            readonly
                                            v-model="formData.woNumber"
                                            :state="getValidationState(validationContext)"
                                        />
                                        <b-input-group-append>
                                            <b-button variant="primary" @click="openModal">...</b-button>
                                        </b-input-group-append>
                                    </b-input-group>
                                    <b-form-invalid-feedback>
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                        </b-col>
                        <b-col md="12">
                            <hr>
                            <b-table
                                responsive
                                :fields="table.fields"
                                :items="table.data"
                                :bordered="true"
                                :hover="true"
                                show-empty
                                :busy="isTableBusy"
                                class="table_scroll"
                            >
                                <!-- Loader -->
                                <template #table-busy>
                                    <div class="text-center my-2">
                                        <b-spinner class="align-middle"></b-spinner>
                                        <strong>Loading...</strong>
                                    </div>
                                </template>

                                <!-- Selection Checkbox -->
                                <template #cell(selectBox)="data">
                                    <b-form-checkbox
                                        @input="checkItem($event, data.item._id)"
                                    />
                                </template>
                            </b-table>
                        </b-col>
                        <b-col md="12">
                            <hr>
                            <b-button
                                variant="primary"
                                type="submit"
                            >
                                Save
                            </b-button>
                        </b-col>
                    </b-row>
                </b-form>
            </validation-observer>
        </b-card-code>

        <!--Wo Modal-->
        <b-modal
            id="workOrderModal"
            ref="workOrderModal"
            no-close-on-backdrop
            ok-only
            ok-title="Cancel"
            ok-variant="danger"
            scrollable
            size="xl"
            title="Work Order Item Find"
            @ok="resetSearchModalData"
        >
            <!-- Search Area -->
            <b-row>
                <b-col md="2">
                    <b-form-group
                        label="Wo No"
                        label-for="modalWoNumber"
                    >
                        <b-form-input
                            id="modalWoNumber"
                            v-model="searchData.woNumber"
                            @keyup="getWoDataSearchWise"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="2">
                    <b-form-group
                        label="Item Desc"
                        label-for="modalItemDescription"
                    >
                        <b-form-input
                            id="modalItemDescription"
                            v-model="searchData.itemDescription"
                            @keyup="getWoDataSearchWise"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="2">
                    <b-form-group
                        label="Item Code"
                        label-for="modalItemCode"
                    >
                        <b-form-input
                            id="modalItemCode"
                            v-model="searchData.itemCode"
                            @keyup="getWoDataSearchWise"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="2">
                    <b-form-group
                        label="Drawing No"
                        label-for="modalDrawingNumber"
                    >
                        <b-form-input
                            id="modalDrawingNumber"
                            v-model="searchData.drawingNumber"
                            @keyup="getWoDataSearchWise"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="2">
                    <b-form-group
                        label="PartyName"
                        label-for="modalPartyName"
                    >
                        <b-form-input
                            id="modalPartyName"
                            v-model="searchData.partyName"
                            @keyup="getWoDataSearchWise"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="2">
                    <b-form-group
                        label="So No"
                        label-for="modalSoNumber"
                    >
                        <b-form-input
                            id="modalSoNumber"
                            v-model="searchData.soNo"
                            @keyup="getWoDataSearchWise"
                        />
                    </b-form-group>
                </b-col>
            </b-row>

            <!-- Table Area -->
            <b-row>
                <b-col md="12">
                    <hr>
                    <b-table
                        responsive
                        :fields="modalTable.fields"
                        :items="modalTable.data"
                        :bordered="true"
                        :hover="true"
                        show-empty
                        :busy="modalTableIsBusy"
                    >
                        <!-- Loader -->
                        <template #table-busy>
                            <div class="text-center my-2">
                                <b-spinner class="align-middle"></b-spinner>
                                <strong>Loading...</strong>
                            </div>
                        </template>

                        <!--Select Button-->
                        <template #cell(selectButton)="data">
                            <b-button
                                variant="primary"
                                size="sm"
                                type="button"
                                @click="selectModalWorkOrder(data.item)"
                            >
                                Select
                            </b-button>
                        </template>
                    </b-table>
                </b-col>
            </b-row>
        </b-modal>
    </div>
</template>
<script>
    import BCardCode from "../../../@core/components/b-card-code/BCardCode";
    import {
        BForm,
        BRow,
        BCol,
        BFormGroup,
        BFormInput,
        BFormTextarea,
        BFormDatepicker,
        BButton,
        BFormInvalidFeedback,
        BInputGroup,
        BInputGroupAppend,
        BTable,
        BSpinner,
        BFormCheckbox
    } from 'bootstrap-vue'
    import Ripple from 'vue-ripple-directive'
    import {ref, onUnmounted} from '@vue/composition-api'
    import VSelect from 'vue-select'
    import axios from '@axios'
    import {ValidationProvider, ValidationObserver} from 'vee-validate'
    import formValidation from '@core/comp-functions/forms/form-validation'
    import {required} from '@validations'
    import router from '@/router'
    import mrpStoreModule from "../mrpStoreModule";
    import store from '@/store'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import {useToast} from 'vue-toastification/composition'

    export default {
        components: {
            BCardCode,
            VSelect,
            BForm,
            BRow,
            BCol,
            BFormGroup,
            BFormInput,
            BFormTextarea,
            BFormDatepicker,
            BButton,
            BFormInvalidFeedback,
            BInputGroup,
            BInputGroupAppend,
            BTable,
            BSpinner,
            BFormCheckbox,
            ValidationProvider,
            ValidationObserver,
        },
        directives: {
            Ripple,
        },
        setup({workOrderModal}) {
            const ITEMADDON_APP_STORE_MODULE_NAME = 'mrp-store-module'
            if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, mrpStoreModule)
            onUnmounted(() => {
                if (store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.unregisterModule(ITEMADDON_APP_STORE_MODULE_NAME)
            })

            const toast = useToast()

            const modalTableIsBusy = ref(false)
            const isTableBusy = ref(false)

            workOrderModal = ref()

            const blankFormData = {
                woNumber: null,
                woIds: [],
                indentCreatedFrom: 'woWisePurchaseItems',
                indentCreatedMenuId: 5,
            }

            const formData = ref(JSON.parse(JSON.stringify(blankFormData)))

            const resetFormData = () => {
                formData.value = JSON.parse(JSON.stringify(blankFormData))
            }

            const table = ref({
                fields: [
                    {
                        key: 'selectBox',
                        label: ''
                    },
                    {
                        key: 'item_name.itemCode',
                        label: 'Item Code'
                    },
                    {
                        key: 'itemDescription',
                        label: 'Item Description'
                    },
                    {
                        key: 'uom_detail.uom',
                        label: 'UOM'
                    },
                    {
                        key: 'itemDrawingNumber',
                        label: 'Drawing No'
                    },
                    {
                        key: 'itemDetailDescription',
                        label: 'Detail Description'
                    },
                    {
                        key: 'partNo',
                        label: 'Part No.'
                    }
                ],
                data: [],
            })

            const modalTable = ref({
                fields: [
                    {
                        key: 'selectButton',
                        label: ''
                    },
                    {
                        key: 'woNumber',
                        label: 'WO No'
                    },
                    {
                        key: 'assembly',
                        label: 'Item Desc'
                    },
                    {
                        key: 'assemblyCode',
                        label: 'Item Code'
                    },
                    {
                        key: 'drawingNo',
                        label: 'Drawing No'
                    },
                    {
                        key: 'party_details.partyName',
                        label: 'Party Name'
                    },
                    {
                        key: 'soNumber',
                        label: 'SO No'
                    }
                ],
                data: []
            })

            const searchData = ref({
                woNumber: null,
                itemDescription: null,
                itemCode: null,
                drawingNumber: null,
                partyName: null,
                soNo: null,
            })

            const openModal = async () => {
                workOrderModal.value.show();
                modalTableIsBusy.value = true
                await axios.post('/api/get-work-order-list-with-party').then(res => {
                    modalTable.value.data = res.data.data
                })
                modalTableIsBusy.value = false
            }

            const getWoDataSearchWise = async () => {
                modalTableIsBusy.value = true
                await axios.post('/api/get-work-order-list-with-party', searchData.value).then(res => {
                    modalTable.value.data = res.data.data
                })
                modalTableIsBusy.value = false
            }

            const resetSearchModalData = () => {
                searchData.value.woNumber = null
                searchData.value.itemDescription = null
                searchData.value.itemCode = null
                searchData.value.drawingNumber = null
                searchData.value.partyName = null
                searchData.value.soNo = null
            }

            const selectModalWorkOrder = async (data) => {
                isTableBusy.value = true
                formData.value.woNumber = data.woNumber
                await axios.get(`/api/get-all-work-order-assembly-items/${data._id}`).then(res => {
                    console.log(res.data.data)
                    table.value.data = res.data.data
                })
                isTableBusy.value = false
                workOrderModal.value.hide();
                resetSearchModalData()
            }

            const checkItem = (e, id) => {
                if (e === false) {
                    formData.value.woIds = formData.value.woIds.filter(function (e) {
                        return e !== id
                    })
                } else {
                    formData.value.woIds.push(id)
                }
            }

            const saveFormData = async () => {
                if (formData.value.woIds.length === 0) {
                    toast({
                        component: ToastificationContent,
                        position: 'top-right',
                        props: {
                            title: 'Error',
                            icon: 'AlertCircleIcon',
                            variant: 'danger',
                            text: 'Please select minimum one item',
                        },
                    })
                } else {
                    await store.dispatch('mrp-store-module/addWoWisePurchaseItem', formData.value).then(res => {
                        if (res.status === 200) {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'WO Shortage Purchase Item (Wo Wise) Added',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: `You have successfully Added WO Shortage Purchase Item (Wo Wise).`,
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

                        router.push({name: 'wo-shortage-purchase-items-wo-wise'})
                    })
                }
            }

            const {refFormObserver, getValidationState, resetForm} = formValidation(resetFormData)

            return {
                modalTableIsBusy,
                isTableBusy,
                formData,
                workOrderModal,
                table,
                modalTable,
                searchData,
                openModal,
                getWoDataSearchWise,
                resetSearchModalData,
                selectModalWorkOrder,
                checkItem,
                saveFormData,
                required,

                refFormObserver,
                getValidationState,
                resetForm
            }
        }
    }
</script>
