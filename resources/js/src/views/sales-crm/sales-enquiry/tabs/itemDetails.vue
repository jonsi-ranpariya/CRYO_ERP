<template>
    <validation-observer ref="simpleRules" #default="{ handleSubmit }">
        <b-form @submit.prevent="handleSubmit(submitFormData)">
            <b-row>
                <b-col md="12">
                    <hr>
                </b-col>
                <b-col md="6">
                    <h4>Item Details</h4>
                </b-col>
                <b-col md="6">
                    <b-button
                        variant="primary"
                        type="button"
                        class="float-right"
                        @click="addNewItemDetails"
                    >
                        Add New Item
                    </b-button>
                </b-col>
                <!-- Start Table Section-->
                <b-col md="12">
                    <hr>
                    <b-table
                        responsive="sm"
                        :fields="fields"
                        :items="rows"
                        :bordered="true"
                        :hover="true"
                        show-empty
                        selectable
                        select-mode="single"
                        @row-selected="onRowSelected"
                    >
                        <template #empty="scope">
                            <h5 class="text-center text-uppercase">No Item Details Available</h5>
                        </template>
                        <template #cell(srNo)="data">
                            {{ data.index + 1 }}
                        </template>
                        <template
                            #cell(action)="data"
                        >
                    <span>
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
                        <b-dropdown-item @click="selectItemDetails(data.item)">
                          <feather-icon
                              icon="CheckSquareIcon"
                              class="mr-50"
                          />
                          <span>Select</span>
                        </b-dropdown-item>
                        <b-dropdown-item @click="deleteItemDetails(data.item._id)">
                          <feather-icon
                              icon="TrashIcon"
                              class="mr-50"
                          />
                          <span>Delete</span>
                        </b-dropdown-item>
                        </b-dropdown>
                        </span>
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
                </b-col>
                <!-- End Table Section-->
                <b-col md="12">
                    <hr>
                </b-col>
                <b-col md="6">
                    <b-form-group
                        label="Item Code"
                        label-for="itemCode"
                    >
                        <v-select
                            v-model="formData.itemCode"
                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                            :options="itemCodeOptions"
                            :clearable="false"
                            input-id="itemCode"
                            @input="getItemDetails($event)"
                        />
                    </b-form-group>

                    <validation-provider
                        #default="{ errors }"
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
                                :state="errors.length > 0 ? false : null"
                            />
                            <small class="text-danger">{{ errors[0] }}</small>
                        </b-form-group>
                    </validation-provider>

                    <b-form-group
                        label="Item Desc (Cust)"
                        label-for="itemDesCust"
                    >
                        <b-form-textarea
                            v-model="formData.itemDescCust"
                            rows="2"
                            id="itemDesCust"
                        />
                    </b-form-group>
                    <b-form-group
                        label="Add Description"
                        label-for="addDescription"
                    >
                        <b-form-input
                            v-model="formData.addDescription"
                            type="text"
                            id="addDescription"
                        />
                    </b-form-group>
                    <b-form-group
                        label="Detail Description"
                        label-for="detailDescription"
                    >
                        <b-form-textarea
                            id="detailDescription"
                            rows="3"
                            v-model="formData.detailDescription"
                        />
                    </b-form-group>
                    <b-row>
                        <b-col md="8">
                            <b-form-group
                                label="Drawing Number"
                                label-for="drawingNumber"
                            >
                                <b-form-input
                                    v-model="formData.drawingNumber"
                                    type="text"
                                    id="drawingNumber"
                                />
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                label="Rev"
                                label-for="rev"
                            >
                                <b-form-input
                                    v-model="formData.rev"
                                    type="text"
                                    id="rev"
                                />
                            </b-form-group>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col md="6">
                            <b-form-group
                                label="UOM"
                                label-for="uom"
                            >
                                <v-select
                                    v-model="formData.uom"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="uomOptions"
                                    :reduce="val => val.value"
                                    :clearable="false"
                                    input-id="uom"
                                />
                            </b-form-group>
                        </b-col>
                        <b-col md="6">
                            <b-form-group
                                label="Require Qty"
                                label-for="requireQty"
                            >
                                <b-form-input
                                    v-model="formData.requireQty"
                                    id="requireQty"
                                />
                            </b-form-group>
                        </b-col>
                    </b-row>
                </b-col>
                <b-col md="6">
                    <b-form-group
                        label="Cust Part No."
                        label-for="custPartNo"
                    >
                        <b-form-input
                            v-model="formData.custPartNo"
                            id="custPartNo"
                        />
                    </b-form-group>
                    <b-form-group
                        label="Item Note"
                        label-for="itemNote"
                    >
                        <b-form-textarea
                            v-model="formData.itemNote"
                            rows="2"
                            id="itemNote"
                        />
                    </b-form-group>
                    <b-form-group
                        label="Lead No."
                        label-for="leadNo"
                    >
                        <b-form-input
                            v-model="formData.leadNo"
                            type="number"
                            id="leadNo"
                        />
                    </b-form-group>
                    <b-form-group
                        label="Status"
                        label-for="status"
                    >
                        <v-select
                            v-model="formData.status"
                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                            :options="statusOptions"
                            :reduce="val => val.value"
                            :clearable="false"
                            input-id="status"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="12">
                    <hr>
                    <b-button
                        class="float-right"
                        variant="primary"
                        type="submit"
                        v-if="isButtonShow"
                    >
                        {{ itemButton }}
                    </b-button>
                </b-col>
            </b-row>
        </b-form>
    </validation-observer>
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
        BCard,
        BCardHeader,
        BCardTitle,
        BFormCheckbox,
        BFormTextarea,
        BFormInvalidFeedback,
        BDropdown,
        BDropdownItem,
    } from 'bootstrap-vue'
    import Ripple from 'vue-ripple-directive'
    import vSelect from 'vue-select'
    import router from '@/router'
    import store from '@/store'
    import {useToast} from 'vue-toastification/composition'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import formValidation from '@core/comp-functions/forms/form-validation'
    import {required, numeric, email} from '@validations'
    import {ref, onUnmounted} from '@vue/composition-api'
    import {ValidationProvider, ValidationObserver, validate} from 'vee-validate'
    import salesStoreModule from "../../salesStoreModule";

    export default {
        components: {
            BButton,
            BRow,
            BCol,
            BFormGroup,
            BFormInput,
            BForm,
            BTable,
            BCard,
            BCardHeader,
            BCardTitle,
            BFormCheckbox,
            BFormTextarea,
            BFormInvalidFeedback,
            BDropdown,
            BDropdownItem,
            vSelect,

            ValidationProvider,
            ValidationObserver
        },
        data() {
            const refetchData = () => {
                this.$store.dispatch('sales-module/getSalesItemDetails', {id: router.currentRoute.params.id}).then(res => {
                    this.rows = res.data.data
                })
            }

            return {
                statusOptions: [
                    {label: 'Pending', value: 1},
                    {label: 'Completed', value: 2},
                    {label: 'Regret', value: 3},
                    {label: 'Cancelled', value: 4},
                ],
                fields: [
                    {
                        key: 'rowSelected',
                        label: ''
                    },
                    {
                        key: 'srNo',
                        label: 'No'
                    },
                    {
                        key: 'itemCode.label',
                        label: 'Item Code'
                    },
                    {
                        key: 'itemDescription',
                        label: 'Item Description'
                    },
                    {
                        key: 'uom_details.uom',
                        label: 'UOM'
                    },
                    {
                        key: 'requireQty',
                        label: 'quantity'
                    },
                    {
                        key: 'action',
                        label: 'Actions'
                    },
                ],
                rows: [],
                itemCodeOptions: [],
                uomOptions: [],
                itemButton: "Save",
                isButtonShow: true,
                refetchData
            }
        },
        created() {
            this.refetchData()

            this.$http.get('/api/get-uom-master-options').then(res => {
                this.uomOptions = res.data.data
            })
            this.$http.get('/api/get-item-master-options').then(res => {
                this.itemCodeOptions = res.data.data
            })
        },
        props: {
            itemDetails: {
                type: Object
            }
        },
        setup() {
            const toast = useToast()
            const APP_STORE_MODULE_NAME = 'sales-module'
            if (!store.hasModule(APP_STORE_MODULE_NAME)) store.registerModule(APP_STORE_MODULE_NAME, salesStoreModule)
            onUnmounted(() => {
                if (store.hasModule(APP_STORE_MODULE_NAME)) store.unregisterModule(APP_STORE_MODULE_NAME)
            })
            const partyDetailFormData = {
                id: null,
                salesIqID: router.currentRoute.params.id,
                itemCode: null,
                itemDescription: null,
                itemDescCust: null,
                addDescription: null,
                detailDescription: null,
                drawingNumber: null,
                rev: null,
                uom: null,
                requireQty: null,
                custPartNo: null,
                itemNote: null,
                leadNo: null,
                status: 1,
            }
            const formData = ref(JSON.parse(JSON.stringify(partyDetailFormData)))
            const resetGroupData = () => {
                formData.value = JSON.parse(JSON.stringify(partyDetailFormData))
            }

            const onRowSelected = (items) => {
                if (items.length > 0) {
                    formData.value.id = items[0]._id
                    formData.value.itemCode = items[0].itemCode
                    formData.value.itemDescription = items[0].itemDescription ?? null
                    formData.value.itemDescCust = items[0].itemDescCust ?? null
                    formData.value.addDescription = items[0].addDescription ?? null
                    formData.value.detailDescription = items[0].detailDescription ?? null
                    formData.value.drawingNumber = items[0].drawingNumber ?? null
                    formData.value.rev = items[0].rev ?? null
                    formData.value.uom = items[0].uom ?? null
                    formData.value.requireQty = items[0].requireQty ?? null
                    formData.value.custPartNo = items[0].custPartNo ?? null
                    formData.value.itemNote = items[0].itemNote ?? null
                    formData.value.leadNo = items[0].leadNo ?? null
                    formData.value.status = items[0].status ?? null
                } else {
                    resetGroupData()
                }
            }

            const {refFormObserver, getValidationState, resetForm} = formValidation(resetGroupData)
            return {
                formData,
                refFormObserver,
                getValidationState,
                resetForm,
                resetGroupData,
                onRowSelected
            }
        },
        methods: {
            getItemDetails(e) {
                this.$http.get(`/api/item-master/${e.value}`).then(res => {
                    //this.formData.itemDescription = res.data.data?.itemDetails?.description
                    this.formData.itemDescription = res.data.data.itemDescription
                    this.formData.addDescription = res.data.data?.itemDetails?.description
                    this.formData.detailDescription = res.data.data?.itemDetails?.detailDescription
                    this.formData.drawingNumber = res.data.data?.itemDetails?.drawingNumber
                    this.formData.rev = res.data.data?.itemDetails?.revision
                    this.formData.itemNote = res.data.data?.itemDetails?.remarkNote
                    this.formData.uom = res.data.data.uom
                })
            },
            addNewItemDetails() {
                this.resetGroupData()
                this.isButtonShow = true
                this.itemButton = "Save"
            },
            selectItemDetails(data) {
                this.formData = data
                this.isButtonShow = false
            },
            submitFormData() {
                if (this.formData.id === null) {
                    store.dispatch('sales-module/addSalesItemDetails', this.formData).then(response => {
                        this.refetchData()
                        this.resetGroupData()
                        this.$toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Item Details Added',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: `You have successfully Added Item Details.`,
                            },
                        })
                    })
                } else {
                    store.dispatch('sales-module/updateSalesItemDetails', this.formData).then(response => {
                        this.refetchData()
                        this.resetGroupData()
                        this.itemButton = "Save"
                        this.$toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Item Details Updated',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: `You have successfully Updated Item Details.`,
                            },
                        })
                    })
                }
            },
            deleteItemDetails(id) {
                this.$swal({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    customClass: {
                        confirmButton: 'btn btn-primary',
                        cancelButton: 'btn btn-outline-danger ml-1',
                    },
                    buttonsStyling: false,
                }).then(result => {
                    if (result.value) {
                        store.dispatch(`sales-module/deleteSalesItemDetails`, {id}).then(response => {
                            if (response.data.status === 200) {
                                this.refetchData()
                                this.$toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: 'Deleted',
                                        icon: 'CheckSquareIcon',
                                        variant: 'success',
                                        text: 'Item Details Delete Successfully',
                                    },
                                })
                            } else {
                                this.$toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: `Error`,
                                        icon: 'AlertCircleIcon',
                                        variant: 'danger',
                                        text: `something went wrong`,
                                    },
                                })
                            }
                        })
                    }
                })
            }
        }
    }
</script>
<style lang="scss">
    @import '~@core/scss/vue/libs/vue-select.scss';
</style>
<style lang="scss">
    @import '~@core/scss/vue/libs/vue-sweetalert.scss';
</style>
