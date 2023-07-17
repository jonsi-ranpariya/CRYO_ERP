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
                                <span>In the setup if the NOT REQ option is selected, employee's in/out punch is not necessary to mark attendance.
                                      System will consider that employee as present [DP].
                                      If ONCE REQ selected, that employee's one punch in a day will qualify him as present [DP].
                                      For TWICE REQ, employee's both in and out punch is necessary to mark him as present [DP].
                                </span>
                            </div>
                        </b-alert>
                        <hr>
                    </b-col>
                </b-row>
                <b-row>
                    <b-col md="3">
                        <b-form-group
                            label="Assign Punch Require"
                            label-for="punch_required"
                        >
                            <v-select
                                v-model="formData.punch_required"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="punchRequiredOptions"
                                :clearable="false"
                                :reduce="val => val.value"
                                placeholder="Select Required"
                                id="punch_required"
                                class="mb-2"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="2" class="d-flex justify-content-start align-items-center">
                        <b-button
                            variant="primary"
                        >
                            Execute
                        </b-button>
                    </b-col>
                    <b-col md="1">
                        <b-button
                            variant="primary"
                            type="submit"
                            class="mt-2 float-right"
                        >
                            Save
                        </b-button>
                    </b-col>
                    <!-- ---------------search ---------------->
                    <b-col md="6">
                        <div class="custom-search d-flex justify-content-end">
                            <b-form-group>
                                <div class="d-flex align-items-center">
                                    <label class="mr-1 mt-2">Search</label>
                                    <b-form-input
                                        v-model="searchTerm"
                                        placeholder="Search"
                                        type="text"
                                        class=" mt-1 d-inline-block mt-2"
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

            const punchRequiredOptions = ref([
                {label: 'Once Required', value: 1},
                {label: 'Twice Required', value: 2},
                {label: 'Not Required', value: 3},
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
                    label: 'Punch Required',
                    field: 'punch_required',
                },
            ])

            const formData = ref({
                punch_required: 1,
            })

            const refetchData = async () => {
                showOverlayLoading.value = true
                rows.value = [
                    {
                        employee_name: 'NAYAN PANDYA',
                        employee_code: 'C000996',
                        punch_required: 'Not Required',
                    },
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
                punchRequiredOptions,
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
