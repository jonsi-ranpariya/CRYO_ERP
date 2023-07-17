<template>
    <div>
        <b-overlay
            :show="showOverlayLoading"
            rounded="sm"
        >
            <b-card
                no-body
                class="card-statistics"
            >
                <b-card-body class="statistics-body">
                    <b-row>
                        <b-col
                            v-for="item in statisticsItems"
                            :key="item.title"
                            md="2"
                            sm="12"
                            class="mb-2 mb-md-0"
                            :class="item.customClass"
                        >
                            <b-media no-body>
                                <b-media-aside

                                    class="mr-2"
                                >
                                    <b-avatar
                                        size="45"
                                        :variant="item.color"
                                    >
                                        {{ item.title }}
                                    </b-avatar>
                                </b-media-aside>
                                <b-media-body class="my-auto">
                                    <b-card-text class="font-small-3 mb-0">
                                        {{ item.subtitle }}
                                    </b-card-text>
                                </b-media-body>
                            </b-media>
                        </b-col>
                    </b-row>
                </b-card-body>
            </b-card>

            <b-card-code>
                <b-row>
                    <b-col md="4">
                        <b-form-group>
                            <label for="employee">Employee <span
                                class="text-danger erp_required_star"
                            >*</span></label>

                            <v-select
                                v-model="formData.employee_name"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="employeeOptions"
                                :clearable="false"
                                :reduce="val => val.value"
                                placeholder="Select Employee"
                                id="employee"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="2">
                        <b-form-group
                            label="Employee Code"
                            label-for="employee_code"
                        >
                            <b-form-input
                                v-model="formData.employee_code"
                                placeholder="Code"
                                input-id="employee_code"
                            />
                        </b-form-group>
                    </b-col>
                </b-row>
                <b-row class="mb-1">
                    <b-col md="7">
                        <b-form-group
                            label="For The Period"
                            label-for="for_the_period"
                        >
                            <b-row>
                                <b-col md="4">
                                    <v-select
                                        v-model="formData.month"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="monthOptions"
                                        :clearable="false"
                                        :reduce="val => val.value"
                                        placeholder="Month"
                                        input-id="for_the_period"
                                    />
                                </b-col>
                                <b-col md="3">
                                    <v-select
                                        v-model="formData.YearPresent"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="yearPresentOptions"
                                        :clearable="false"
                                        :reduce="val => val.value"
                                        placeholder="Year"
                                        input-id="YearPresent"
                                    />
                                </b-col>
                                <b-col md="5">
                                    <b-button
                                        variant="primary"
                                        class="mb-2"
                                    > Export PDF
                                    </b-button>
                                </b-col>
                            </b-row>
                        </b-form-group>
                    </b-col>

                    <!----------------- search ---------------->
                    <b-col cols="12" md="5">
                        <div class="custom-search d-flex justify-content-end">
                            <b-form-group>
                                <div class="d-flex align-items-center">
                                    <label class="mr-1 mt-2">Search</label>
                                    <b-form-input
                                        v-model="searchTerm"
                                        placeholder="Search"
                                        type="text"
                                        class=" mt-2 d-inline-block"
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
                        <span v-if="props.column.field === 'selectDate'">
                               <b-link
                                   @click="openModal(props.row._id)"
                                   class="font-weight-bold d-block text-nowrap"
                               >
                              {{ props.row.date }}
                            </b-link>
                        </span>

                        <!-- Column: Action -->
                        <span v-if="props.column.field === 'action'">
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

        <b-modal
            id="viewAttendanceHrModal"
            ref="viewAttendanceHrModal"
            title="Shift [OS] Time: 01-Mar-23 08:11 AM - 02-Mar-23 08:10 AM [As per CutOff Time]"
            ok-title="Yes"
            cancel-title="No"
            cancel-variant="danger"
            no-close-on-backdrop
            scrollable
            centered
            hide-footer
            size="xl"
        >
            <b-row>
                <b-col md="12">
                    <h5>Daily In Out Punch</h5>
                </b-col>
            </b-row>
            <b-table
                :fields="modalTable.columns"
                :items="modalTable.rows"
                :bordered="true"
                :hover="true"
                show-empty
                responsive
                class="table_scroll"
            >
            </b-table>
        </b-modal>
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
        BCard,
        BCardBody,
        BMedia,
        BMediaAside,
        BAvatar,
        BMediaBody,
        BCardText,
        BLink,
        BTable
    } from 'bootstrap-vue'
    import BCardCode from '@core/components/b-card-code/BCardCode'
    import {VueGoodTable} from 'vue-good-table'
    import {ref} from '@vue/composition-api'
    import store from '@/store/index'
    import vSelect from 'vue-select'
    import moment from "moment";
    import axios from '@axios'

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
            BCard,
            BCardBody,
            BMedia,
            BMediaAside,
            BAvatar,
            BMediaBody,
            BCardText,
            BLink,
            BTable
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
        setup({viewAttendanceHrModal}) {
            viewAttendanceHrModal = ref()

            const openModal = () => {
                viewAttendanceHrModal.value.show();
            }

            const employeeOptions = ref([])
            axios.get('/api/get-users-name-options')
                .then(res => {
                    employeeOptions.value = res.data.data
                })

            const modalTable = ref({
                columns: [
                    {
                        key: 'date',
                        label: 'Date'
                    },
                    {
                        key: 'entry_time',
                        label: 'Entry Time'
                    },
                    {
                        key: 'in_out_time',
                        label: 'In/Out Time'
                    },
                    {
                        key: 'ip_address',
                        label: 'IP Address'
                    },
                    {
                        key: 'machine_name',
                        label: 'Machine Name'
                    },
                    {
                        key: 'swipe_date',
                        label: 'Swipe Date'
                    },
                    {
                        key: 'entry_date_time',
                        label: 'Entry Date Time'
                    },
                    {
                        key: 'approver_remark',
                        label: 'Approver Remark'
                    }
                ],
                rows: [
                    {
                        date: '22/02/2022', entry_time: '2:00', in_out_time: '6:00', ip_address: '127.0.0.1.23',
                        machine_name: 'a1', swipe_date: '12/03/2022', entry_date_time: '3:00', approver_remark: 'work'
                    }
                ]
            })

            const statisticsItems = [
                {
                    color: 'light-danger',
                    title: '10.5',
                    subtitle: 'DP',
                    customClass: 'mb-2 mb-sm-0',
                },
                {
                    color: 'light-warning',
                    title: '4',
                    subtitle: 'WO',
                    customClass: '',
                }
            ]


            /*Get all Month*/
            let allMonth = [];
            let months = moment.months();
            for (let i = 0; i < months.length; i++) {
                allMonth.push({
                    label: months[i],
                    value: months[i],
                })
            }
            const monthOptions = ref([])
            monthOptions.value = allMonth

            const yearPresentOptions = ref([
                {
                    label: new Date().getFullYear() - 1,
                    value: new Date().getFullYear() - 1
                },
                {
                    label: new Date().getFullYear(),
                    value: new Date().getFullYear()
                },
            ])

            const showOverlayLoading = ref(false)

            //search
            const searchTerm = ref('')
            //pagination
            const pageLength = ref(5)
            const dir = ref(false)
            const rows = ref([])
            const columns = ref([
                {
                    label: 'Date',
                    field: 'selectDate'
                },
                {
                    label: 'Day',
                    field: 'day'
                },
                {
                    label: 'Shift Code',
                    field: 'shift_code'
                },
                {
                    label: 'Shift InTime',
                    field: 'shift_in_time'
                },
                {
                    label: 'Shift OutTime',
                    field: 'shift_out_time'
                },
                {
                    label: 'InTime',
                    field: 'in_time'
                },
                {
                    label: 'OutTime',
                    field: 'out_time'
                },
                {
                    label: '1st Half',
                    field: 'first_half'
                },
                {
                    label: '2nd Half',
                    field: 'second_half'
                },
                {
                    label: 'Day Present',
                    field: 'day_present'
                },
                {
                    label: 'Total Hrs.',
                    field: 'total_hrs'
                },
                {
                    label: 'OT Hrs.',
                    field: 'ot_hrs',
                },
                {
                    label: 'Late Mark',
                    field: 'late_mark'
                },
                {
                    label: 'In Late Mark',
                    field: 'in_late_mark'
                }
            ])

            const formData = ref({
                employee_name: null,
                employee_code: null,
                YearPresent: null,
                month: null
            })


            const refetchData = async () => {
                showOverlayLoading.value = true
                rows.value = [
                    {
                        date: '23/03/2023',
                        day: 'monday', shift_code: 'A1', shift_in_time: '2:00',
                        shift_out_time: '6:00', in_time: '9:00', out_time: '6:30', first_half: 'first',
                        second_half: 'second', day_present: '1.0', total_hrs: '13.11', ot_hrs: '0.00',
                        late_mark: '0.00', in_late_mark: '0.00'
                    },
                    {
                        date: '28/03/2023',
                        day: 'wednesday', shift_code: 'A2', shift_in_time: '5:00',
                        shift_out_time: '6:00', in_time: '9:00', out_time: '6:30', first_half: 'first',
                        second_half: 'second', day_present: '1.0', total_hrs: '13.11', ot_hrs: '0.00',
                        late_mark: '0.00', in_late_mark: '0.00'
                    },
                ]
                showOverlayLoading.value = false
            }
            refetchData()

            return {
                formData,
                showOverlayLoading,
                searchTerm,
                pageLength,
                dir,
                columns,
                rows,
                yearPresentOptions,
                monthOptions,
                statisticsItems,
                viewAttendanceHrModal,
                openModal,
                modalTable,
                employeeOptions
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
