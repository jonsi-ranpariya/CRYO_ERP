<template>
    <!--loading overlay-->
    <b-overlay
        :show="showOverlayLoading"
        rounded="sm"
    >
        <b-card-code>
            <b-row class="mb-1">
                <b-col cols="12" md="6" class="d-flex justify-content-start align-items-center">
                    <b-button
                        variant="primary"
                        :to="{ name: 'add-job-card-material-return'}"
                    >
                        Add Job Card Material Return
                    </b-button>
                </b-col>
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

                    <!-- Column: Status -->
                    <span v-if="props.column.field === 'status'">
                        <b-badge :variant="statusVariant(props.row.status)">
                            {{ props.row.status }}
                        </b-badge>
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
                          <b-dropdown-item
                              :to="{ name: 'edit-job-card-material-return', params: { id: props.row._id} }">
                            <feather-icon
                                icon="Edit2Icon"
                                class="mr-50"
                            />
                            <span>Edit</span>
                          </b-dropdown-item>
                          <b-dropdown-item @click="deleteJobCardData(props.row._id)">
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
</template>

<script>
    import BCardCode from "../../../@core/components/b-card-code/BCardCode";
    import {
        BOverlay,
        BRow,
        BCol,
        BButton,
        BFormGroup,
        BFormInput,
        BAvatar,
        BBadge,
        BPagination,
        BFormSelect,
        BDropdown,
        BDropdownItem,
    } from 'bootstrap-vue'
    import {VueGoodTable} from 'vue-good-table'
    import store from '@/store/index'
    import {ref, onUnmounted} from '@vue/composition-api'
    import productionPlanningStoreModule from '../productionPlanningStoreModule'
    import Swal from "sweetalert2";
    import Toastification from '@core/components/toastification/ToastificationContent.vue'
    import {useToast} from "vue-toastification/composition";
    import {forMatIndianDate} from '@core/utils/utils'
    import axios from '@axios'


    export default {
        components: {
            BCardCode,
            BOverlay,
            VueGoodTable,
            BRow,
            BCol,
            BButton,
            BFormGroup,
            BFormInput,
            BAvatar,
            BBadge,
            BPagination,
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
            statusVariant() {
                const statusColor = {
                    Current: 'light-primary',
                    Professional: 'light-success',
                    Rejected: 'light-danger',
                    Resigned: 'light-warning',
                    Applied: 'light-info',
                }
                return status => statusColor[status]
            },
        },
        setup() {
            //using store module
            const SE_APP_STORE_MODULE_NAME = 'job-module'

            if (!store.hasModule(SE_APP_STORE_MODULE_NAME)) store.registerModule(SE_APP_STORE_MODULE_NAME, productionPlanningStoreModule)

            onUnmounted(() => {
                if (store.hasModule(SE_APP_STORE_MODULE_NAME)) store.unregisterModule(SE_APP_STORE_MODULE_NAME)
            })
            //toast notification
            const toast = useToast()
            const showOverlayLoading = ref(false)
            const searchTerm = ref('')
            const pageLength = ref(5)
            const dir = ref(false)
            const columns = ref([
                {
                    label: 'Return No',
                    field: 'returnNumber',
                },
                {
                    label: 'Return Date',
                    field: 'returnDate',
                },
                {
                    label: 'Job Card No.',
                    field: 'jobCardNumber',
                },
                {
                    label: 'Create Date',
                    field: 'created_at',
                    formatFn: val => forMatIndianDate(val)
                },
                {
                    label: 'Action',
                    field: 'action',
                },
            ])

            const rows = ref([])
            const refetchData = async () => {
                showOverlayLoading.value = true
                await axios.get('/api/job-card-return-shop').then(res => {
                    rows.value = res.data.data
                })
                showOverlayLoading.value = false
            }
            refetchData()

            const deleteJobCardData = async (id) => {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Delete Job Card",
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
                        store.dispatch('job-module/deleteJobCardReturnShop', {id: id}).then(res => {
                            if (res.status === 200) {
                                toast({
                                    component: Toastification,
                                    position: 'top-right',
                                    props: {
                                        title: 'Job Card Return Shop Deleted',
                                        icon: 'CheckSquareIcon',
                                        variant: 'success',
                                        text: 'You have successfully Deleted Job Card Return Shop',
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
                refetchData,
                dir,
                columns,
                rows,
                deleteJobCardData,
                showOverlayLoading,

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
