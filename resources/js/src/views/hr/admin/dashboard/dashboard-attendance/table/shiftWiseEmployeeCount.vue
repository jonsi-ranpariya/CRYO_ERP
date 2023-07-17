<template>
    <div>
        <b-card-code>
            <b-row>
                <b-col md="9" class="justify-content-start">
                    <b-row>
                        <b-col md="12" class="mb-1">
                            <h5>Shift Wise Employee Count (Today/Tomorrow)</h5>
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
            const pageLength = ref(5)
            const dir = ref(false)
            const rows = ref([])
            const columns = ref([
                {
                    label: 'Shift Code',
                    field: 'shift_code',
                },
                {
                    label: 'Today',
                    field: 'today',
                },
                {
                    label: 'Tomorrow',
                    field: 'tomorrow',
                },
            ])

            const refetchDta = async () => {
                rows.value = [
                    {
                        shift_code: 'A2 (3:00 PM - 11:00 PM)',
                        today: '1',
                        tomorrow: '1',
                    },
                    {
                        shift_code: 'M3 (11:00 PM - 7:30 AM)',
                        today: '1',
                        tomorrow: '1',
                    },
                    {
                        shift_code: 'CG (9:00 AM - 5:30 PM)',
                        today: '79',
                        tomorrow: '80',
                    },
                    {
                        shift_code: 'L2 (2:00 PM - 10:30 PM)',
                        today: '4',
                        tomorrow: '3',
                    },
                    {
                        shift_code: 'V1 (6:00 AM - 2:30 PM)',
                        today: '4',
                        tomorrow: '4',
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


