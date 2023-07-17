    <template>
    <b-overlay
        :show="showOverlayLoading"
        rounded="sm"
    >
        <div>
            <b-card-code>

                <b-row class="mb-2">
                    <b-col
                        cols="12"
                        md="6"
                        class="d-flex align-items-center justify-content-start"
                    >
                        <!-- Add New Party Button -->
                        <b-button
                            variant="primary"
                            :to="{ name: 'add-sales-enquiry'}"
                        >
                            Add New Sales Enquiry
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
<!--                        <span-->
<!--                            v-if="props.column.field === 'customerCityLabel'"-->
<!--                            class="text-nowrap"-->
<!--                        >-->
<!--                          <span class="text-nowrap" v-if="props.row.customerCity !== null">{{ props.row.customerCity.label }}</span>-->
<!--                          <span class="text-nowrap" v-else>N/A</span>-->
<!--                        </span>-->
                        <span
                            v-if="props.column.field === 'enquiryStatus'"
                            class="text-nowrap"
                        >
                          <span class="text-nowrap" v-if="props.row.enquiryStatus === 1">Pending</span>
                          <span class="text-nowrap" v-else-if="props.row.enquiryStatus === 2">Completed</span>
                          <span class="text-nowrap" v-else-if="props.row.enquiryStatus === 3">Regret</span>
                          <span class="text-nowrap" v-else-if="props.row.enquiryStatus === 4">Cancelled</span>
                          <span class="text-nowrap" v-else></span>
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
                              <b-dropdown-item :to="{ name: 'edit-sales-enquiry', params: { id: props.row._id} }">
                                <feather-icon
                                    icon="Edit2Icon"
                                    class="mr-50"
                                />
                                <span>Edit</span>
                              </b-dropdown-item>
                              <b-dropdown-item @click="deleteMyCurrentErpData(props.row._id)">
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
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import {VueGoodTable} from 'vue-good-table'
    import store from '@/store'
    import salesStoreModule from '../salesStoreModule'
    import moment from 'moment'
    import { forMatIndianDate } from '@core/utils/utils'

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
        data() {
            const refetchData = () => {
                this.showOverlayLoading = true
                this.$http.get('/api/sales-enquiry').then(res => {
                    this.rows = res.data.data
                    this.showOverlayLoading = false
                })
            }
            return {
                pageLength: 5,
                dir: false,
                // Party list table columns
                columns: [
                    {
                        label: 'Enq. No.',
                        field: 'enquiryNo',
                    },
                    {
                        label: 'Enquiry Date',
                        field: 'enquiryDate',
                    },
                    {
                        label: 'Reference',
                        field: 'reference',
                    },
                    {
                        label: 'Reference Date',
                        field: 'referenceDate',
                    },
                    {
                        label: 'Customer Name',
                        field: 'customerName',
                    },
                    {
                        label: 'District',
                        field: 'city_details.city',
                    },
                    {
                        label: 'Status',
                        field: 'enquiryStatus',
                    },
                    {
                        label: 'Action',
                        field: 'action',
                    },
                ],
                rows: [],
                searchTerm: '',
                refetchData,
                showOverlayLoading: false,
            }
        },
        setup() {

            const SE_APP_STORE_MODULE_NAME = 'sales-enquiry-module'

            // Register module
            if (!store.hasModule(SE_APP_STORE_MODULE_NAME)) store.registerModule(SE_APP_STORE_MODULE_NAME, salesStoreModule)

            // UnRegister on leave
            onUnmounted(() => {
                if (store.hasModule(SE_APP_STORE_MODULE_NAME)) store.unregisterModule(SE_APP_STORE_MODULE_NAME)
            })
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
        created() {

            this.showOverlayLoading = true

            this.$http.get('/api/sales-enquiry')
                .then(res => {
                    this.rows = res.data.data
                    this.showOverlayLoading = false
                })
        },
        methods: {

            deleteMyCurrentErpData(id) {

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

                        store.dispatch(`sales-enquiry-module/deleteSalesEnquiry`, {id}).then(response => {

                            if (response.data.status == '200') {

                                this.refetchData()

                                this.$toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: `Deleted`,
                                        icon: 'CheckSquareIcon',
                                        variant: 'success',
                                        text: `Sales Enquiry Delete Successfully`,
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
