<template>
    <b-overlay
        :show="showLoading"
        rounded="sm"
    >
        <div>
            <b-card-code>
                <b-row>
                    <b-col md="12">
                        <b-button
                            variant="primary"
                            type="button"
                            class="float-right"
                            v-b-modal.defaultTemplateModal
                        >
                            Choose Default Billing Template
                        </b-button>
                    </b-col>
                    <b-col md="12">
                        <hr>
                    </b-col>
                </b-row>
                <b-row class="mb-2">
                    <b-col
                        cols="12"
                        md="6"
                        class="d-flex align-items-center justify-content-start"
                    >
                        <b-button
                            variant="primary"
                            :to="{name: 'add-billing-template-master'}"
                        >
                            <!--@click="addNewDatToSidebar()"-->
                            Add New Billing Description
                        </b-button>
                    </b-col>
                    <b-col
                        cols="12"
                        md="6"
                    >
                        <!-- search input -->
                        <div class="custom-search d-flex justify-content-end">
                            <b-form-group>
                                <div class="d-flex align-items-center">
                                    <label class="mr-1">Search</label>
                                    <b-form-input
                                        v-model="searchTerm"
                                        placeholder="Search"
                                        type="text"
                                        class="d-inline-block"
                                    />
                                </div>
                            </b-form-group>
                        </div>
                    </b-col>
                </b-row>
                <!-- table -->
                <vue-good-table
                    :columns="tableData.fields"
                    :rows="tableData.rows"
                    :line-numbers="true"
                    :rtl="direction"
                    :search-options="{
                        enabled: true,
                        externalQuery: searchTerm
                    }"
                    :select-options="{
                        enabled: false,
                        selectOnCheckboxOnly: true, // only select when checkbox is clicked instead of the row
                        selectionInfoClass: 'custom-class',
                        selectionText: 'rows selected',
                        clearSelectionText: 'clear',
                        disableSelectInfo: true, // disable the select info panel on top
                        selectAllByGroup: true, // when used in combination with a grouped table, add a checkbox in the header row to check/uncheck the entire group
                    }"
                    :pagination-options="{
                        enabled: true,
                        perPage:tableData.perPage
                    }"
                >
                    <template
                        slot="table-row"
                        slot-scope="props"
                    >
                        <!-- Column: Name -->
                        <span
                            v-if="props.column.field === 'status'"
                            class="text-nowrap"
                        >
                          <span v-if="props.row.status === 1 ">
                              <b-badge variant="success">
                                  Active
                              </b-badge>
                          </span>
                          <span v-else-if="props.row.status === 0 ">
                              <b-badge variant="danger">
                                  Inactive
                              </b-badge>
                          </span>
                          <span v-else></span>
                        </span>
                        <!-- Column: Action -->
                        <span v-else-if="props.column.field === 'action'">
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
                              <b-dropdown-item :to="{
                                  name: 'edit-billing-template-master',
                                  params: {
                                      id: props.row._id
                                  }
                              }"
                              >
                                <feather-icon
                                    icon="Edit2Icon"
                                    class="mr-50"
                                />
                                <span>Edit</span>
                              </b-dropdown-item>
                              <b-dropdown-item @click="deleteBillingTemplate(props.row._id)">
                                <feather-icon
                                    icon="TrashIcon"
                                    class="mr-50"
                                />
                                <span>Delete</span>
                              </b-dropdown-item>
                            </b-dropdown>
                          </span>
                        </span>
                        <!-- Column: Common -->
                        <span v-else>
                          {{ props.formattedRow[props.column.field] }}
                        </span>
                    </template>
                    pagination
                    <template
                        slot="pagination-bottom"
                        slot-scope="props"
                    >
                        <div class="d-flex justify-content-between flex-wrap">
                            <div class="d-flex align-items-center mb-0 mt-1">
                                <span class="text-nowrap ">
                                  Showing 1 to
                                </span>
                                <b-form-select
                                    v-model="tableData.perPage"
                                    :options="['5','10','20','50']"
                                    class="mx-1"
                                    @input="(value)=>props.perPageChanged({currentPerPage:value})"
                                />
                                <span class="text-nowrap"> of {{ props.total }} entries </span>
                            </div>
                            <div>
                                <b-pagination
                                    :value="1"
                                    :total-rows="props.total"
                                    :per-page="tableData.perPage"
                                    first-number
                                    last-number
                                    prev-class="prev-item"
                                    next-class="next-item"
                                    class="mt-1 mb-0"
                                    @input="(value)=>props.pageChanged({currentPage:value})"
                                >
                                    <template #prev-text>
                                        <feather-icon
                                            icon="ChevronLeftIcon"
                                            size="18"
                                        />
                                    </template>
                                    <template #next-text>
                                        <feather-icon
                                            icon="ChevronRightIcon"
                                            size="18"
                                        />
                                    </template>
                                </b-pagination>
                            </div>
                        </div>
                    </template>
                </vue-good-table>
            </b-card-code>
        </div>
        <!--Modal-->
        <div>
            <b-modal
                id="defaultTemplateModal"
                title="Assign Default Billing Template"
                ok-title="submit"
                cancel-variant="danger"
                size="lg"
                no-close-on-backdrop
                centered
                @ok="handelOk"
            >
                <!--
                @cancel="resetFormData"
                @close="resetFormData"
                -->
                <b-form-group
                    label="Invoice"
                    label-for="invoice"
                >
                    <v-select
                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                        :options="templateOptions"
                        :clearable="false"
                        input-id="invoice"
                        :reduce="val => val.value"
                        placeholder="Choose Template"
                        v-model="modalFormData.invoice"
                    />
                </b-form-group>
                <b-form-group
                    label="Sales Order"
                    label-for="salesOrder"
                >
                    <v-select
                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                        :options="templateOptions"
                        :clearable="false"
                        input-id="salesOrder"
                        :reduce="val => val.value"
                        placeholder="Choose Template"
                        v-model="modalFormData.salesOrder"
                    />
                </b-form-group>
                <b-form-group
                    label="Purchase Order"
                    label-for="purchaseOrder"
                >
                    <v-select
                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                        :options="templateOptions"
                        :clearable="false"
                        input-id="purchaseOrder"
                        :reduce="val => val.value"
                        placeholder="Choose Template"
                        v-model="modalFormData.purchaseOrder"
                    />
                </b-form-group>
            </b-modal>
        </div>
    </b-overlay>
</template>
<script>
    import BCardCode from '@core/components/b-card-code/BCardCode.vue'
    import {
        BPagination, BFormGroup, BFormInput, BFormSelect, BDropdown, BDropdownItem, BButton, BRow,
        BCol, BOverlay,BModal,BBadge
    } from 'bootstrap-vue'
    import {ref, onUnmounted} from '@vue/composition-api'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import {VueGoodTable} from 'vue-good-table'
    import store from '@/store'
    import masterStoreModule from "../masterStoreModule";
    import router from '@/router'
    import {useToast} from 'vue-toastification/composition'
    import moment from 'moment'
    import swal from 'sweetalert2'
    import axios from '@axios'
    import Ripple from 'vue-ripple-directive'
    import vSelect from 'vue-select'

    export default {
        components: {
            BCardCode,
            BOverlay,
            VueGoodTable,
            BButton,
            BRow,
            BCol,
            BPagination,
            BFormGroup,
            BFormInput,
            BFormSelect,
            BDropdown,
            BDropdownItem,
            BModal,
            BBadge,
            vSelect
        },
        computed: {
            direction() {
                if (store.state.appConfig.isRTL) {
                    this.dir = true
                    return this.dir
                }
                this.dir = false
                return this.dir
            },
        },
        directives: {
            Ripple,
        },
        setup() {
            const ITEMADDON_APP_STORE_MODULE_NAME = 'billing-template-master'
            if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, masterStoreModule)
            onUnmounted(() => {
                if (store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.unregisterModule(ITEMADDON_APP_STORE_MODULE_NAME)
            })

            const toast = useToast()

            const tableData = ref({
                fields: [
                    {
                        label: 'Template Name',
                        field: 'templateName',
                    },
                    {
                        label: 'Status',
                        field: 'status',
                    },
                    {
                        label: 'Action',
                        field: 'action',
                        sortable: false,
                    },
                ],
                rows: [],
                perPage: 5,
            })
            const showLoading = ref(true)

            const searchTerm = ref('')
            const fetchData = () => {
                axios.get('/api/billing-template-master').then(res => {
                    tableData.value.rows = res.data.data
                    showLoading.value = false
                })
            }
            fetchData()

            const deleteBillingTemplate = async (id) => {
                swal.fire({
                    title: 'Are you sure?',
                    text: "Delete Billing Template",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, do it!',
                    cancelButtonText: 'No, cancel it!',
                    customClass: {
                        confirmButton: 'btn btn-primary',
                        cancelButton: 'btn btn-outline-danger ml-1',
                    },
                    buttonsStyling: false,
                }).then(result => {
                    if (result.value) {
                        store.dispatch('billing-template-master/deleteBillingTemplateMaster', {id: id}).then(res => {
                            if (res.data.status === 200){
                                toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: 'Billing Template Deleted',
                                        icon: 'CheckSquareIcon',
                                        variant: 'success',
                                        text: `You have successfully Deleted Billing Template`,
                                    },
                                })
                            }else{
                                toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: 'Abort',
                                        icon: 'AlertCircleIcon',
                                        variant: 'danger',
                                        text: `Something went wrong`,
                                    },
                                })
                            }
                            fetchData()
                        })
                    } else {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Abort Task',
                                icon: 'AlertCircleIcon',
                                variant: 'danger',
                                text: `You had canceled This task`,
                            },
                        })
                    }
                })
            }

            const templateOptions = ref([])
            axios.get('/api/get-billing-template-master-options').then(res => {
                templateOptions.value = res.data.data
            })

            const modalFormData = ref({
                id: null,
                invoice: null,
                salesOrder: null,
                purchaseOrder: null,
            })

            axios.get('/api/default-billing-template-master').then(res => {
                if(res.data.data !== null){
                    modalFormData.value.id = res.data.data._id
                    modalFormData.value.invoice = res.data.data.invoice
                    modalFormData.value.salesOrder = res.data.data.salesOrder
                    modalFormData.value.purchaseOrder = res.data.data.purchaseOrder
                }
            })

            const handelOk = async () => {
                if (modalFormData.value.id === null){
                    await store.dispatch('billing-template-master/addDefaultBillingTemplateMaster', modalFormData.value).then(res => {
                        if (res.data.status === 200){
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Default Billing Template Saved',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: `You have successfully Created Default Billing Template`,
                                },
                            })
                        }else{
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Abort',
                                    icon: 'AlertCircleIcon',
                                    variant: 'danger',
                                    text: `Something went wrong`,
                                },
                            })
                        }
                    })
                }else{
                    await store.dispatch('billing-template-master/updateDefaultBillingTemplateMaster', modalFormData.value).then(res => {
                        if (res.data.status === 200){
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Default Billing Template Updated',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: `You have successfully Updated Default Billing Template`,
                                },
                            })
                        }else{
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Abort',
                                    icon: 'AlertCircleIcon',
                                    variant: 'danger',
                                    text: `Something went wrong`,
                                },
                            })
                        }
                    })
                }
            }

            return {
                searchTerm,
                tableData,
                deleteBillingTemplate,
                showLoading,
                modalFormData,
                templateOptions,
                handelOk
            }
        },
    }
</script>
<style lang="scss">
    @import '~@core/scss/vue/libs/vue-good-table.scss';
</style>
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
