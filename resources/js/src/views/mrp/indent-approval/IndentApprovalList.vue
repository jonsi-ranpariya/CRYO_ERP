<template>
    <b-overlay
        :show="showOverlayLoading"
        rounded="sm"
    >
        <div>
            <b-card-code>
                <b-row class="mb-1">
                    <b-col cols="12" md="12">
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
                        <!-- -------Column: Action --------------->
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
                          <b-dropdown-item @click="approveIndent(props.row)">
                            <feather-icon
                                icon="CheckSquareIcon"
                                class="mr-50"
                            />
                            <span>Approve</span>
                          </b-dropdown-item>
                          <b-dropdown-item
                              :to="{ name: 'view-indent-approval', params: { id: props.row._id} }">
                            <feather-icon
                                icon="EyeIcon"
                                class="mr-50"
                            />
                            <span>View</span>
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
                                    :options="['5','10','20','50','100']"
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
    import {
        BRow,
        BCol,
        BButton,
        BFormGroup,
        BFormInput,
        BPagination,
        BFormSelect,
        BDropdown,
        BDropdownItem,
        BOverlay
    } from 'bootstrap-vue'
    import BCardCode from "../../../@core/components/b-card-code/BCardCode";
    import {VueGoodTable} from 'vue-good-table'
    import {ref, onUnmounted} from '@vue/composition-api'
    import store from '@/store'
    import router from '@/router'
    import axios from '@axios'
    import mrpStoreModule from "../mrpStoreModule";
    import {forMatIndianDate, getTcTodayDate, forMatIndianDateAndTime} from '@core/utils/utils'
    import Toastification from '@core/components/toastification/ToastificationContent.vue'
    import {useToast} from 'vue-toastification/composition'
    import Swal from 'sweetalert2'
    import {getUserData} from "../../../auth/utils";
    import moment from 'moment'

    export default {
        components: {
            VueGoodTable,
            BCardCode,
            BRow,
            BCol,
            BButton,
            BFormGroup,
            BFormInput,
            BPagination,
            BFormSelect,
            BDropdown,
            BDropdownItem,
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
            const ITEMADDON_APP_STORE_MODULE_NAME = 'mrp-store-module'
            if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, mrpStoreModule)
            onUnmounted(() => {
                if (store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.unregisterModule(ITEMADDON_APP_STORE_MODULE_NAME)
            })

            const toast = useToast()

            const showOverlayLoading = ref(false)
            const searchTerm = ref('')
            const pageLength = ref(5)
            const dir = ref(false)
            const rows = ref([])
            const columns = ref([
                {
                    label: 'Indent No.',
                    field: 'indentNo',
                },
                {
                    label: 'Date',
                    field: 'indentDate',
                },
                {
                    label: 'QtyUM',
                    field: 'reqQtyUm',
                },
                {
                    label: 'QtyUP',
                    field: 'reqQtyUp',
                },
                {
                    label: 'DeliveryDate',
                    field: 'deliveryDate',
                },
                {
                    label: 'SONo',
                    field: 'so_name.salesOrderNo',
                },
                {
                    label: 'WONo',
                    field: 'wo_name.woNumber',
                },
                {
                    label: 'Approved',
                    field: 'loginDetails.approvedBy',
                },
                {
                    label: 'Approved Date',
                    field: 'loginDetails.approveDate'
                },
                {
                    label: 'Item Description',
                    field: 'itemDescription',
                },
                {
                    label: 'Action',
                    field: 'action',
                },
            ])

            const refetchData = async () => {
                showOverlayLoading.value = true
                await axios.get('/api/mrp/indent-approval').then(res => {
                    rows.value = res.data.data
                })
                showOverlayLoading.value = false
            }
            refetchData()

            const approveIndent = async (data) => {
                await Swal.fire({
                    title: 'Are you sure?',
                    text: "Name is already exist",
                    icon: 'warning',
                    showCancelButton: true,
                    showDenyButton: true,
                    confirmButtonText: 'Yes, Approve!',
                    denyButtonText: 'No, Decline!',
                    cancelButtonText: 'Cancel',
                    customClass: {
                        confirmButton: 'btn btn-outline-success',
                        cancelButton: 'btn btn-outline-danger ml-1',
                        denyButton: 'btn btn-outline-warning ml-1',
                    },
                    buttonsStyling: false,
                }).then(result => {
                    if (result.isConfirmed) {
                        acceptDeclineEvent(data, 2)
                    }
                    if (result.isDenied) {
                        acceptDeclineEvent(data, 3)
                    }
                    if (result.isDismissed) {
                        toast({
                            component: Toastification,
                            position: 'top-right',
                            props: {
                                title: 'Cancel',
                                icon: 'AlertCircleIcon',
                                variant: 'danger',
                                text: 'You have abort the task!',
                            },
                        })
                    }
                })
            }

            const formData = ref({
                loginDetails: {
                    createdBy: null,
                    dateTime: null,
                    lastModifiedBy: null,
                    modifiedDateTime: null,
                    approveDate: getTcTodayDate(),
                    approvedBy: getUserData().first_name + ' ' + getUserData().last_name,
                    stage: 1,
                },
            })

            const acceptDeclineEvent = async (data, status) => {
                /* status: 1 = Prepared, status: 2 = Approved, status: 3 = Regret */
                if (status === 3) {
                    formData.value.loginDetails.stage = status
                    formData.value.loginDetails.createdBy = data.loginDetails.createdBy
                    formData.value.loginDetails.dateTime = data.loginDetails.dateTime
                    formData.value.loginDetails.lastModifiedBy = data.loginDetails.lastModifiedBy
                    formData.value.loginDetails.modifiedDateTime = data.loginDetails.modifiedDateTime
                    formData.value.loginDetails.approveDate = null
                    formData.value.loginDetails.approvedBy = null
                } else {
                    formData.value.loginDetails.stage = status
                    formData.value.loginDetails.createdBy = data.loginDetails.createdBy
                    formData.value.loginDetails.dateTime = data.loginDetails.dateTime
                    formData.value.loginDetails.lastModifiedBy = data.loginDetails.lastModifiedBy
                    formData.value.loginDetails.modifiedDateTime = data.loginDetails.modifiedDateTime
                    formData.value.loginDetails.approveDate = moment(new Date()).format('DD/MM/YYYY HH:mm')
                    formData.value.loginDetails.approvedBy = getUserData().first_name + ' ' + getUserData().last_name
                }

                await axios.put(`/api/mrp/pending-indent/${data._id}`, formData.value).then(res => {
                    if (res.status === 200) {
                        toast({
                            component: Toastification,
                            position: 'top-right',
                            props: {
                                title: 'Status Changed',
                                icon: 'ThumbsUpIcon',
                                variant: 'success',
                                text: 'Indent Status Change Successfully!',
                            },
                        })
                    } else {
                        toast({
                            component: Toastification,
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
                await refetchData()
            }

            return {
                showOverlayLoading,
                searchTerm,
                pageLength,
                dir,
                columns,
                rows,
                refetchData,
                approveIndent,
                formData,
                acceptDeclineEvent
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
