<template>
    <div>
        <b-overlay
            :show="showOverlayLoading"
            rounded="sm"
        >
            <b-card-code>
                <b-row class="mb-1">
                    <b-col cols="12" md="6" class="d-flex justify-content-start align-items-center">
                        <b-button
                            variant="primary"
                            :to="{ name: 'add-new-challan-invoice'}"
                        > Add New Challan Invoice
                        </b-button>
                    </b-col>

                    <!--                    :to="{ name: 'add-job-card'}"-->
                    <!-- ---------------search ---------------->
                    <b-col cols="12" md="6">
                        <div class="custom-search d-flex justify-content-end">
                            <b-form-group>
                                <div class="d-flex align-items-center">
                                    <label class="mr-1 mt-1">Search</label>
                                    <b-form-input
                                        v-model="searchTerm"
                                        placeholder="Search"
                                        type="text"
                                        class=" mt-1 d-inline-block"
                                    />
                                </div>
                            </b-form-group>
                        </div>
                    </b-col>
                </b-row>
                <!-- ---------------- table --------------------------------->
                <vue-good-table
                    :columns="columns"
                    :rows="rows"
                    :rtl="direction"
                    :search-options="{
                enabled: true,
                externalQuery: searchTerm }"
                    :select-options="{
                enabled: false,
                        selectOnCheckboxOnly: true, // only select when checkbox is clicked instead of the row
                        selectionInfoClass: 'custom-class',
                        selectionText: 'rows selected',
                        clearSelectionText: 'clear',
                        disableSelectInfo: true, // disable the select info panel on top
                        selectAllByGroup: true,
      }"
                    :pagination-options="{
                enabled: true,
                perPage:pageLength
            }"
                >
                    <template
                        slot="table-row"
                        slot-scope="props"
                    >

                        <!-- Column: Action -->
                        <span v-if="props.column.field === 'action'">
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
                            <b-dropdown-item
                                :disabled="openPdfButton.disabled"
                                @click="openPdf(props.row._id)"
                            >
                            <feather-icon
                                icon="FileTextIcon"
                                class="mr-50"
                            />
                            <span>{{ openPdfButton.text }}</span>
                          </b-dropdown-item>
                          <b-dropdown-item :to="{name: 'edit-new-challan-invoice', params:{id: props.row._id}}">
                            <feather-icon
                                icon="Edit2Icon"
                                class="mr-50"
                            />
                            <span>Edit</span>
                          </b-dropdown-item>
                          <b-dropdown-item @click="deleteChallanInvoiceData(props.row._id)">
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

                    <!-- pagination -->
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
                                    v-model="pageLength"
                                    :options="['3','5','10']"
                                    class="mx-1"
                                    @input="(value)=>props.perPageChanged({currentPerPage:value})"
                                />
                                <span class="text-nowrap"> of {{ props.total }} entries </span>
                            </div>
                            <div>
                                <b-pagination
                                    :value="1"
                                    :total-rows="props.total"
                                    :per-page="pageLength"
                                    first-number
                                    last-number
                                    align="right"
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
        </b-overlay>
    </div>
</template>
<script>
    import BCardCode from '@core/components/b-card-code/BCardCode'
    import {
        BButton,
        BCol,
        BDropdown,
        BDropdownItem,
        BFormGroup,
        BFormInput,
        BFormSelect,
        BOverlay,
        BPagination,
        BRow
    } from 'bootstrap-vue'
    import {VueGoodTable} from 'vue-good-table'
    import {ref} from '@vue/composition-api'
    import store from '@/store/index'
    import axios from '@axios'
    import {forMatIndianDate} from "@core/utils/utils";
    import Swal from "sweetalert2";
    import ToastificationContent from "../../../@core/components/toastification/ToastificationContent";
    import {useToast} from "vue-toastification/composition";

    export default {
        components: {
            VueGoodTable,
            BRow,
            BCol,
            BButton,
            BFormGroup,
            BFormInput,
            BPagination,
            BFormSelect,
            BDropdown,
            BDropdownItem,
            BCardCode,
            BOverlay,
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
        setup() {
            const showOverlayLoading = ref(false)
            const toast = useToast();

            //search
            const searchTerm = ref('')
            //pagination
            const pageLength = ref(5)
            const dir = ref(false)
            const rows = ref([])
            const columns = ref([
                {
                    label: 'Party Code',
                    field: 'sell_to_party_details.partyCode',
                },
                {
                    label: 'Party',
                    field: 'sell_to_party_details.partyName',
                },
                {
                    label: 'Invoice No',
                    field: 'invoiceNo',
                },
                {
                    label: 'Invoice',
                    field: 'invoice',
                    formatFn: val => getInvoice(val)
                },
                {
                    label: 'Invoice Date',
                    field: 'invoiceDate',
                },
                {
                    label: 'Cust PO No.',
                    field: 'orderNo',
                },
                {
                    label: 'Action',
                    field: 'action',
                },
            ])

            const InvoiceOptions = ref([
                {label: 'General', value: 1},
                {label: 'Export Invoice', value: 2},
                {label: 'Trading Invoice', value: 3},
                {label: 'Purchase Return', value: 4},
                {label: 'Labour Invoice', value: 5},
                {label: 'Service Invoice', value: 6},
                {label: 'NON TAXABLE', value: 7},
            ])
            const InvoiceTypeOptions = ref([
                {label: 'Tax Invoice', value: 1},
                {label: 'Retail Invoice', value: 2},
                {label: 'Bill Of Supply', value: 3},
                {label: 'Other', value: 4},
            ])

            const getInvoice = (id) => {
                let invoiceLabel
                InvoiceOptions.value.filter(invoice => {
                    if (invoice.value === id) {
                        invoiceLabel = invoice.label
                    } else {
                        return null
                    }
                })
                return invoiceLabel
            }

            const refetchData = async () => {
                showOverlayLoading.value = true
                await axios.get('/api/new-challan-and-invoice-list').then((res) => {
                    rows.value = res.data.data
                })
                showOverlayLoading.value = false
            }
            refetchData()

            const deleteChallanInvoiceData = async (id) => {
                await Swal.fire({
                    title: 'Are you sure?',
                    text: "Delete Challan Invoice",
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
                        axios.delete(`/api/new-challan-and-invoice/${id}`).then(res => {
                            if (res.status === 200) {
                                toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: 'Challan Invoice Deleted',
                                        icon: 'CheckSquareIcon',
                                        variant: 'success',
                                        text: `You have successfully Deleted Challan Invoice.`,
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
                        refetchData()
                    }
                })
            }

            const openPdfButton = ref({
                text: 'Report',
                disabled: false,
            })

            const openPdf = async (id) => {
                openPdfButton.value.text = 'Please wait...';
                openPdfButton.value.disabled = true;
                await axios.post('/pdf/generate-pdf', {
                    type: 'challanInvoiceReport',
                    newChallanInvoiceId: id,
                }).then(res => {
                    if (res.status === 200) {
                        let path = res.data.path
                        window.open(path, '_blank');
                    }
                }).catch((error) => {
                    toast({
                        component: ToastificationContent,
                        position: 'top-right',
                        props: {
                            title: `Error`,
                            icon: 'AlertCircleIcon',
                            variant: 'danger',
                            text: error.response.data.msg,
                        },
                    })
                })
                openPdfButton.value.text = 'Report';
                openPdfButton.value.disabled = false;
            }

            return {
                showOverlayLoading,
                InvoiceOptions,
                InvoiceTypeOptions,
                searchTerm,
                pageLength,
                dir,
                columns,
                rows,
                deleteChallanInvoiceData,
                openPdfButton,
                openPdf
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
