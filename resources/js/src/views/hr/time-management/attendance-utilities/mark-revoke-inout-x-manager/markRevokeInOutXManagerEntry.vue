<template>
    <div>
        <b-overlay
            :show="showOverlayLoading"
            rounded="sm"
        >
            <b-card-code>
                <b-row>
                    <!-- danger -->
                    <b-col md="12">
                        <b-alert
                            variant="danger"
                            show
                        >
                            <h4 class="alert-heading">
                                Note:
                            </h4>
                            <div class="alert-body">
                                <span>The Punch Data which is technically needed to be ignored which calculating day records can be tagged as “X” with this utility.</span><br><br>
                                <span>This can be used for some incident eg. Employee attending office on LEAVE day for small unit of minutes for some urgent requirement etc.</span>
                                <span>[ if this is required on all such event this can be also configured from shift rules.]</span><br><br>
                            </div>
                        </b-alert>
                        <hr>
                    </b-col>
                </b-row>
                <b-row class="mb-1">
                    <b-col cols="12">
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
<!--                        <b-dropdown-->
                          <!--                            variant="link"-->
                          <!--                            toggle-class="text-decoration-none"-->
                          <!--                            no-caret-->
                          <!--                        >-->
                          <!--                          <template v-slot:button-content>-->
                          <!--                            <feather-icon-->
                          <!--                                icon="MoreVerticalIcon"-->
                          <!--                                size="16"-->
                          <!--                                class="text-body align-middle mr-25"-->
                          <!--                            />-->
                          <!--                          </template>-->
                          <!--                        </b-dropdown>-->
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
                <b-col md="12" class="mt-2">
                    <b-button
                        variant="primary"
                        class="float-right ml-1"
                    >
                        Reset to Original
                    </b-button>
                    <b-button
                        variant="primary"
                        class="float-right"
                    >
                        Mark as X
                    </b-button>
                </b-col>
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
        BOverlay,
        BAlert
    } from 'bootstrap-vue'
    import BCardCode from "../../../../../@core/components/b-card-code/BCardCode";
    import {ref} from '@vue/composition-api'
    import {VueGoodTable} from 'vue-good-table'
    import store from '@/store/index'

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
            BOverlay,
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
            const searchTerm = ref('')
            const pageLength = ref(5)
            const dir = ref(false)
            const rows = ref([])
            const columns = ref([
                {
                    label: 'Employee Code',
                    field: 'employee_Code',
                },
                {
                    label: 'Employee Name',
                    field: 'employee_name',
                },
                {
                    label: 'Date',
                    field: 'date',
                },
                {
                    label: 'Entry_Time',
                    field: 'entry_time',
                },
                {
                    label: 'Flag',
                    field: 'flag',
                },
            ])

            const refetchData = async () => {
                showOverlayLoading.value = true
                /*      await axios.get('/api/').then(res => {
                        rows.value = res.data.data
                    })
                 */
                rows.value = [
                    {
                        employee_Code:'C000996',
                        employee_name:'NAYAN PANDYA',
                        date:'25-Mar-2023',
                        entry_time:'0:12',
                        flag:'Z',
                    }
                ]
                showOverlayLoading.value = false
            }
            refetchData()

            return {
                searchTerm,
                pageLength,
                dir,
                rows,
                columns,
                refetchData,
                showOverlayLoading,
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
