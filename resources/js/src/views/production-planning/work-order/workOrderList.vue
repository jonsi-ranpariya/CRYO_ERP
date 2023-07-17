<template>
    <b-overlay
        :show="showOverlayLoading"
        rounded="sm"
    >
        <div>
            <b-card-code>
                <b-row class="mb-1">
                    <b-col
                        cols="12"
                        md="6"
                        class="d-flex align-items-center justify-content-start"
                    >
                        <!-- Add New Party Button -->
                        <b-button
                            variant="primary"
                            :to="{ name: 'add-work-order'}"
                        >
                            Add New Work Order
                        </b-button>
                    </b-col>
                    <b-col cols="12" md="6">
                        <!-- search input -->
                        <div class="custom-search d-flex justify-content-end">
                            <b-form-group>
                                <div class="d-flex align-items-center">
                                    <label class="mr-1" >Search</label>
                                    <b-form-input
                                        v-model="searchTerm"
                                        placeholder="Search"
                                        type="text"
                                        class="d-inline-block mt-2"
                                    />
                                </div>
                            </b-form-group>
                        </div>
                    </b-col>
                </b-row>

                <!-- table -->
                <vue-good-table
                    :columns="columns"
                    :rows="rows"
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
                        perPage:pageLength
                    }"
                >
                    <template
                        slot="table-row"
                        slot-scope="props"
                    >
                        <!-- Column: Name -->
                        <span
                            v-if="props.column.field === 'pInvoiceNo'"
                            class="text-nowrap"
                        >

                          <span class="text-nowrap">{{ props.row.pInvoiceNo }}</span>
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
                              <b-dropdown-item :to="{ name: 'edit-work-order', params: { id: props.row._id} }">
                                <feather-icon
                                    icon="Edit2Icon"
                                    class="mr-50"
                                />
                                <span>Edit</span>
                              </b-dropdown-item>
                              <b-dropdown-item @click="deleteWorkOrder(props.row._id)">
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
        </div>
    </b-overlay>
</template>
<script>
    import BCardCode from '@core/components/b-card-code/BCardCode.vue'
    import {
        BPagination, BFormGroup, BFormInput, BFormSelect, BDropdown, BDropdownItem, BButton, BRow,
        BCol, BOverlay
    } from 'bootstrap-vue'
    import {ref, onUnmounted} from '@vue/composition-api'
    import Toastification from '@core/components/toastification/ToastificationContent.vue'
    import {VueGoodTable} from 'vue-good-table'
    import store from '@/store'
    import moment from 'moment'
    import {forMatIndianDate} from '@core/utils/utils'
    import axios from '@axios'
    import Swal from  'sweetalert2'
    import productionPlanningStoreModule from '../productionPlanningStoreModule'
    import {useToast} from 'vue-toastification/composition'

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
            const ITEMADDON_APP_STORE_MODULE_NAME = 'production-planning'
            if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, productionPlanningStoreModule)
            onUnmounted(() => {
                if (store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.unregisterModule(ITEMADDON_APP_STORE_MODULE_NAME)
            })
            const showOverlayLoading = ref(false)
            const searchTerm = ref('')
            const columns = ref([
                {
                    label: 'WONo.',
                    field: 'woNumber',
                },
                {
                    label: 'Date',
                    field: 'woDate',
                },
                {
                    label: 'WO Qty',
                    field: 'woQty',
                },
                {
                    label: 'Pend Qty',
                    field: 'pendingQty',
                },
                {
                    label: 'Rej Qty',
                    field: 'rejectQty',
                },
                {
                    label: 'SC Qty',
                    field: 'scQty',
                },
                {
                    label: 'Status',
                    field: 'status',
                    formatFn: val => getStatus(val)
                },
                {
                    label: 'Del Date',
                    field: 'woDeliveryDate',
                    // formatFn: val => forMatIndianDate(val)
                },
                {
                    label: 'Action',
                    field: 'action',
                },
            ])
            const rows = ref([])
            const pageLength = ref(5)
            const toast = useToast()

            const reFetchData = async () => {
                showOverlayLoading.value = true
                await axios.get('/api/work-orders').then(res => {
                    rows.value = res.data.data
                })
                showOverlayLoading.value = false
            }
            reFetchData()

            const statusOptions = ref([
                {label: 'Pending', value: 1},
            ])

            const getStatus = (id) => {
                let statusLabel
                statusOptions.value.forEach(status => {
                    statusLabel = status.value === id ? status.label : null
                })
                return statusLabel
            }

            const deleteWorkOrder = async (id) => {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Delete Work Order",
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
                        store.dispatch('production-planning/deleteWorkOrder',{id: id}).then(res => {
                            if (res.status === 200) {
                                toast({
                                    component: Toastification,
                                    position: 'top-right',
                                    props: {
                                        title: 'Work Order Deleted',
                                        icon: 'CheckSquareIcon',
                                        variant: 'success',
                                        text: 'You have successfully Deleted Work Order',
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
                        reFetchData()
                    }
                })
            }

            return {
                showOverlayLoading,
                reFetchData,
                searchTerm,
                columns,
                rows,
                pageLength,
                getStatus,
                deleteWorkOrder,
            }
        }
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
