<template>
    <div>
        <b-card-code>
            <b-row>
                <b-col md="9" class="justify-content-start">
                    <b-row>
                        <b-col md="12" class="mb-1">
                            <h5>List of Employee(s) on Leave/LWP for Next X Days</h5>
                        </b-col>
                    </b-row>
                </b-col>
                <!-- ---------------search ---------------->
                <b-col md="3">
                    <div class="custom-search d-flex justify-content-end">
                        <b-form-group>
                            <b-form-input
                                v-model="searchTerm"
                                placeholder="Filter"
                                type="text"
                                id="filter"
                            />
                        </b-form-group>
                    </div>
                </b-col>
            </b-row>
            <!--  Table  -->
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
    </div>
</template>
<script>
    import {
        BRow,
        BCol,
        BFormSelect,
        BPagination,
        BFormGroup,
        BFormInput
    } from 'bootstrap-vue'
    import BCardCode from "../../../../../../@core/components/b-card-code/BCardCode";
    import {VueGoodTable} from 'vue-good-table'
    import {ref} from "@vue/composition-api";
    import store from '@/store/index'

    export default {
        components: {
            VueGoodTable,
            BRow,
            BCol,
            BCardCode,
            BFormSelect,
            BPagination,
            BFormGroup,
            BFormInput
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
            //search
            const searchTerm = ref('')
            //pagination
            const pageLength = ref(3)
            const dir = ref(false)
            const rows = ref([])
            const columns = ref([
                {
                    label: 'Employee Code',
                    field: 'employee_code',
                },
                {
                    label: 'Employee Name',
                    field: 'employee_name',
                },
                {
                    label: 'Department',
                    field: 'department',
                },
                {
                    label: 'Date',
                    field: 'date',
                },
                {
                    label: 'Leave Type',
                    field: 'leave_type',
                }
            ])

            const refetchDta = async () => {
                rows.value = [
                    {
                        employee_code: 'C002033',
                        employee_name: 'BIMAL BHATT',
                        department: 'IT',
                        date: '28-Mar-23',
                        leave_type: 'PL',
                    },
                    {
                        employee_code: 'C001250',
                        employee_name: 'CHAUHAN RAVIKUMAR NARPATSINH',
                        department: 'Production',
                        date: '28-Mar-23',
                        leave_type: 'SL',
                    },
                    {
                        employee_code: 'C007829',
                        employee_name: 'DHRUVIL V DESAI',
                        department: 'QC',
                        date: '28-Mar-23',
                        leave_type: 'SL',
                    }
                ]
            }
            refetchDta()

            return {
                searchTerm,
                pageLength,
                rows,
                columns,
                dir
            }
        }
    }
</script>
<style lang="scss">
    @import '~@core/scss/vue/libs/vue-good-table.scss';
</style>


