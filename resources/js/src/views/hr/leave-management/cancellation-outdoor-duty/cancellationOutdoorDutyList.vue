<template>
    <div>
        <b-overlay
            :show="showOverlayLoading"
            rounded="sm"
        >
            <b-card-code>
                <b-row class="mb-1">
                    <b-col md="12">
                        <b-alert
                            variant="danger"
                            show
                        >
                            <h4 class="alert-heading">
                                Note:
                            </h4>
                            <div class="alert-body">
                                <span>Following are the list of leaves Which are applied and already approved, Whitch can be request for cancellation.</span><br><br>
                            </div>
                        </b-alert>
                    </b-col>
                    <b-col md="12">
                        <b-alert
                            variant="danger"
                            show
                        >
                            <h4 class="alert-heading">
                                Please Note:
                            </h4>
                            <div class="alert-body">
                                <span>For Leave cancellation, Select the approved leaves from the list mention below.</span><br><br>
                                <span>It Will not display approved leaves older than 6 months (Comparison will be done from application From date).</span><br><br>
                            </div>
                        </b-alert>
                        <hr>
                    </b-col>
                    <b-col cols="5">
                        <b-form-group
                            label="Leave Cancellation"
                            label-for="leave_cancellation"
                        >
                            <v-select
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="leaveCancellationOptions"
                                :reduce="val => val.value"
                                :clearable="false"
                                placeholder="Select Leave"
                                input-id="leave_type"
                                @input="selectCancellationType($event)"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col cols="1"></b-col>
                    <!-----------------search ---------------->
                    <b-col cols="6">
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
                          <b-dropdown-item :to="{name: 'edit-cancellation-outdoor-duty', params:{id: props.row._id}}">
                            <feather-icon
                                icon="Edit2Icon"
                                class="mr-50"
                            />
                            <span>Edit</span>
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
        BRow,
        BAlert
    } from 'bootstrap-vue'
    import BCardCode from '@core/components/b-card-code/BCardCode'
    import {VueGoodTable} from 'vue-good-table'
    import {onUnmounted, ref} from '@vue/composition-api'
    import store from '@/store/index'

    import vSelect from 'vue-select'

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
            vSelect,
            BAlert
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

            const leaveCancellationOptions = ref([
                {
                    label: 'For Cancellation',
                    value: 1
                },
                {
                    label: 'Recent Application',
                    value: 2
                },
                {
                    label: 'Cancellation Approved Application',
                    value: 3
                },
                {
                    label: 'Rejected Applications',
                    value: 4
                },
                {
                    label: 'Lapsed Application',
                    value: 5
                },
            ])

            //search
            const searchTerm = ref('')
            //pagination
            const pageLength = ref(5)
            const dir = ref(false)
            const rows = ref([])
            const columns = ref([
                {
                    label: 'App. ID',
                    field: 'applicationId',
                },
                {
                    label: 'From Date',
                    field: 'from_date',
                },
                {
                    label: 'To Date',
                    field: 'to_date',
                },
                {
                    label: 'Apply Day',
                    field: 'total_days',
                },
                {
                    label: 'Remarks',
                    field: 'remarks',
                },
                {
                    label: 'Admin Feedback',
                    field: 'adminFeedback',
                },
                {
                    label: 'Status',
                    field: 'status',
                },
                {
                    label: 'Leave Type',
                    field: 'leave_type',
                },
                {
                    label: 'Action',
                    field: 'action',
                },
            ])

            const refetchData = async () => {
                showOverlayLoading.value = true
                rows.value = [
                    {
                        applicationId: '12234',
                        from_date: '23/03/2023',
                        to_date: '26/03/2023',
                        total_days: '4',
                        remarks: 'Leave Apply',
                        adminFeedback: 'Approved By HR',
                        status: 'In Process',
                        leave_type: 'Casual Leave (CL)'
                    }]
                showOverlayLoading.value = false
            }
            refetchData()

            const selectCancellationType = () => {}

            return {
                showOverlayLoading,
                searchTerm,
                pageLength,
                dir,
                columns,
                rows,
                leaveCancellationOptions,
                selectCancellationType
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

