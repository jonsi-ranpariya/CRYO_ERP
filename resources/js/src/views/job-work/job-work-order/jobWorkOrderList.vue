<template>
    <div>
        <b-overlay
            :show="showOverlayLoading"
            rounded="sm"
        >
        <b-card-code>
            <b-row class="mb-1">
                <b-col cols="12" md="6" class="justify-content-start d-flex align-items-center">
                    <b-button
                        variant="primary"
                        :to="{name :'add-job-work-order'}"
                    >
                        Add Job Work Order
                    </b-button>
                </b-col>
                <b-col cols="12" md="6">
                    <div class="custom-search d-flex justify-content-end">
                        <b-form-group>
                            <div class="d-flex align-items-center">
                                <label class="mr-1 mt-1">Search</label>
                                <b-form-input
                                    v-model="searchTerm"
                                    placeholder="Search"
                                    type="text"
                                    class="mt-1 d-inline-block"
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
                          <b-dropdown-item :to="{ name: 'edit-job-work-order', params: { id: props.row._id} }">
                            <feather-icon
                                icon="Edit2Icon"
                                class="mr-50"
                            />
                            <span>Edit</span>
                          </b-dropdown-item>
                          <b-dropdown-item @click="deleteJobWorkOrder(props.row._id)">
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
    import {
        BRow,
        BCol,
        BButton,
        BFormGroup,
        BFormInput,
        BFormSelect,
        BPagination,
        BDropdown,
        BDropdownItem,
        BOverlay
    } from 'bootstrap-vue'
    import BCardCode from "../../../@core/components/b-card-code/BCardCode";
    import {onUnmounted, ref} from '@vue/composition-api'
    import {VueGoodTable} from 'vue-good-table'
    import store from '@/store/index'
    import axios from '@axios'
    import Swal from "sweetalert2";
    import {useToast} from "vue-toastification/composition";
    import jobWorkStoreModule from "../jobWorkStoreModule";
    import Toastification from "@core/components/toastification/ToastificationContent.vue";

    export default {
        components: {
            VueGoodTable,
            BCardCode,
            BRow,
            BCol,
            BButton,
            BFormGroup,
            BFormInput,
            BFormSelect,
            BPagination,
            BDropdown,
            BDropdownItem,
            BOverlay
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
            const toast = useToast()

            const ITEMADDON_APP_STORE_MODULE_NAME = 'job-work-order-store-module'
            if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, jobWorkStoreModule)
            onUnmounted(() => {
                if (store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.unregisterModule(ITEMADDON_APP_STORE_MODULE_NAME)
            })
            const showOverlayLoading = ref(false)
            const searchTerm = ref('')
            const pageLength = ref(5)
            const dir = ref(false)
            const rows = ref([])
            const columns = ref([
                {
                    label: 'Job Work No',
                    field: 'jobWorkNo',
                },
                {
                    label: 'Job Work Date',
                    field: 'jobWorkDate',
                },
                {
                    label: 'Sub-Contractor Code',
                    field: 'subContractorCode',
                },
                {
                    label: 'Sub-Contractor Name',
                    field: 'subContractorName',
                },
                {
                    label: 'Status',
                    field: 'status',
                },
                {
                    label: 'Action',
                    field: 'action',
                },
            ])
            const refetchData = async () => {
                showOverlayLoading.value = true
                await axios.get('/api/job-work-order').then(res => {
                    rows.value = res.data.data
                })
                showOverlayLoading.value = false
            }
            refetchData()

            const deleteJobWorkOrder = async (id) => {
                await Swal.fire({
                    title: 'Are you sure?',
                    text: "Delete Job Work Order",
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
                        store.dispatch('job-work-order-store-module/deleteJobWorkOrder', {id: id}).then(res => {
                            if (res.status === 200) {
                                toast({
                                    component: Toastification,
                                    position: 'top-right',
                                    props: {
                                        title: 'Job Work Order Deleted',
                                        icon: 'CheckSquareIcon',
                                        variant: 'success',
                                        text: 'You have successfully Deleted Job Work Order',
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
                        refetchData()
                    }
                })
            }

            return {
                searchTerm,
                pageLength,
                dir,
                rows,
                columns,
                refetchData,
                showOverlayLoading,
                deleteJobWorkOrder
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
