<template>
    <div>
        <b-overlay
            :show="showOverlayLoading"
            rounded="sm"
        >
            <b-card-code>
                <b-row>
                    <b-col md="12">
                        <b-alert
                            variant="danger"
                            show
                        >
                            <h4 class="alert-heading">
                                Note:
                            </h4>
                            <div class="alert-body">
                                <span>Please Publish for the Selected Employees before you change Page.</span>
                            </div>
                        </b-alert>
                        <hr>
                    </b-col>
                </b-row>
                <b-row class="mb-1">
                    <b-col md="3">
                        <b-form-group
                            label="Calendar"
                            label-for="calendar"
                        >
                            <v-select
                                v-model="formData.calendar_name"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="calenderNameOptions"
                                :clearable="false"
                                :reduce="val => val.value"
                                placeholder="Select Name"
                                id="calendar"
                                class="mb-2"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="2">
                        <b-form-group
                            label="Year"
                            label-for="year"
                        >
                            <v-select
                                v-model="formData.year"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="yearOptions"
                                :clearable="false"
                                :reduce="val => val.value"
                                placeholder="Select Year"
                                id="year"
                                class="mb-2 ml-1"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col cols="12" md="2" class="d-flex justify-content-start align-items-center">
                        <b-button
                            variant="primary"
                        >
                            Publish
                        </b-button>
                    </b-col>
                    <b-col md="1"></b-col>
                    <!-- ---------------search ---------------->
                    <b-col cols="12" md="4">
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
                        enabled: true,
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
                    theme="my-theme"
                    @on-row-click=""
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
    import {VueGoodTable} from 'vue-good-table'
    import {ref} from '@vue/composition-api'
    import store from '@/store/index'
    import vSelect from 'vue-select'
    import BCardCode from '@core/components/b-card-code/BCardCode'
    import moment from "moment";


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

            const calenderNameOptions = ref([
                {label: 'Holiday_Factory', value: 1},
                {label: 'Holiday_Staff', value: 2},
            ])

            let year = {
                currentYear: moment().year(),
                lastYear: moment().subtract(1, 'year').year(),
                secondLastYear: moment().subtract(2, 'year').year(),
            }

            const yearOptions = ref([
                {
                    label: `${year.currentYear}`,
                    value: `${year.currentYear}`
                },
                {
                    label: `${year.lastYear}`,
                    value: `${year.lastYear}`
                },
                {
                    label: `${year.secondLastYear}`,
                    value: `${year.secondLastYear}`
                }
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
                    label: 'Employee Name',
                    field: 'employee_name',
                },
                {
                    label: 'Employee Code',
                    field: 'employee_code',
                },
                {
                    label: 'Grade',
                    field: 'grade',
                },
                {
                    label: 'Branch',
                    field: 'branch',
                },
                {
                    label: 'Department',
                    field: 'department',
                },
                {
                    label: 'Email',
                    field: 'email_id',
                },
                {
                    label: 'Is Calendar Created',
                    field: 'is_calendar_created',
                },
                {
                    label: 'Calendar',
                    field: 'calendar',
                }, {
                    label: 'Optional Calendar',
                    field: 'optional_calendar',
                },
            ])

            const formData = ref({
                calendar_name: 1,
                year: `${year.currentYear}`,
            })

            const refetchData = async () => {
                showOverlayLoading.value = true
                rows.value = [{
                    employee_name: 'AKSHAY PATANVADIA',
                    employee_code: 'C007879',
                    grade: 'Worker',
                    branch: 'Factory',
                    department: 'Production',
                    email_id: '',
                    is_calendar_created: 'No',
                    calendar: 'Holiday_Factory_2023',
                    optional_calendar: '',
                },
                    {
                        employee_name: 'AKSHAY PATANVADIA',
                        employee_code: 'C007879',
                        grade: 'Worker',
                        branch: 'Factory',
                        department: 'Production',
                        email_id: '',
                        is_calendar_created: 'No',
                        calendar: 'Holiday_Factory_2023',
                        optional_calendar: '',
                    }
                ]
                showOverlayLoading.value = false
            }
            refetchData()

            return {
                showOverlayLoading,
                searchTerm,
                pageLength,
                dir,
                columns,
                rows,
                formData,
                calenderNameOptions,
                yearOptions
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
