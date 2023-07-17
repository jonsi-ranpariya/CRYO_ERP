<template>
    <b-overlay
        rounded="sm"
        :show="showOverlayLoading"
    >
        <div>
            <reason-master-add-edit
                :is-add-new-user-sidebar-active.sync="isAddNewUserSidebarActive"
                :userform-data="userFormData"
                @refetch-data="refetchData"
                :reason-type-option="reasonTypeOption"
            />

            <b-card-code>

                <b-row class="mb-2">
                    <b-col
                        cols="12"
                        md="6"
                        class="d-flex align-items-center justify-content-start"
                    >
                        <b-button
                            @click="AddNewDatTosidebar()"
                            variant="primary"
                        >
                            Add New Reason Type
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
                                        placeholder="Search"
                                        type="text"
                                        class="d-inline-block"
                                        v-model="searchTerm"
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
                    :line-numbers="true"
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

                        <!-- Column: Name -->
                        <span
                            v-if="props.column.field === 'reason'"
                            class="text-nowrap"
                        >
                            <span class="text-nowrap"></span>
                        </span>

                        <span
                            v-if="props.column.field === 'reasonType'"
                            class="text-nowrap"
                        >
                            <span class="text-nowrap">{{ getReasonTypeName(props.row.reasonType) }}</span>
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
                              <b-dropdown-item @click="EditMySidebar(props.row)">
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
            </b-card-code>
        </div>
    </b-overlay>
</template>

<script>
    import BCardCode from '@core/components/b-card-code/BCardCode.vue'
    import {
        BPagination, BFormGroup, BFormInput, BFormSelect, BDropdown, BDropdownItem, BButton, BRow,
        BCol, BOverlay,
    } from 'bootstrap-vue'
    import {ref, onUnmounted} from '@vue/composition-api'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import {VueGoodTable} from 'vue-good-table'
    import store from '@/store'
    import generalMasterStoreModule from "../generalMasterStoreModule";
    import ReasonMasterAddEdit from "./reasonMasterAddEdit";

    export default {
        components: {
            ReasonMasterAddEdit,
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
                this.$http.get('/api/reason-type').then(res => {
                    this.rows = res.data.data
                    this.showOverlayLoading = false
                })
            }

            const isAddNewUserSidebarActive = false

            const reasonTypeOption = [
                {label: 'Quotation', value: 1},
                {label: 'Despatch Delay', value: 2},
                {label: 'Rejection', value: 3},
                {label: 'Debit Note', value: 4},
                {label: 'Credit Note', value: 5},
                {label: 'Activity', value: 6},
                {label: 'WO Progress', value: 7},
                {label: 'General', value: 8},
            ]

            const userFormData = {
                id: null,
                reason: '',
                reasonType: '',
            }

            return {
                isAddNewUserSidebarActive,
                userFormData,
                reasonTypeOption,
                pageLength: 10,
                dir: false,
                columns: [
                    {
                        label: 'Reason',
                        field: 'reason',
                    },
                    {
                        label: 'Reason Type',
                        field: 'reasonType',
                    },
                    {
                        label: 'Action',
                        field: 'action',
                        sortable: false,
                    },
                ],
                rows: [],
                searchTerm: '',
                refetchData,
                showOverlayLoading: false,
            }
        },
        setup() {
            const COUNTRY_APP_STORE_MODULE_NAME = 'reason-type-module'
            if (!store.hasModule(COUNTRY_APP_STORE_MODULE_NAME)) store.registerModule(COUNTRY_APP_STORE_MODULE_NAME, generalMasterStoreModule)
            onUnmounted(() => {
                if (store.hasModule(COUNTRY_APP_STORE_MODULE_NAME)) store.unregisterModule(COUNTRY_APP_STORE_MODULE_NAME)
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
            this.$http.get('/api/reason-type').then(res => {
                this.rows = res.data.data
                this.showOverlayLoading = false
            })
            /*this.$http.get('/api/quotation-type-options').then(res => {
                this.reasonTypeOption = res.data.data
            })*/
        },
        methods: {
            getReasonTypeName(cat) {
                let valObj = this.reasonTypeOption.filter(function (elem) {
                    if (elem.value === cat) {
                        return elem.label
                    }
                })
                if (valObj.length > 0) {
                    return valObj[0].label
                } else {
                    return ''
                }
            },
            AddNewDatTosidebar(){
                this.isAddNewUserSidebarActive = true
                this.userFormData = {
                    id: null,
                    reason: '',
                    reasonType: ''
                }
            },
            EditMySidebar(user) {
                this.isAddNewUserSidebarActive = true
                this.userFormData = user
            },
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
                        store.dispatch(`reason-type-module/deleteReasonType`, {id}).then(response => {
                            if (response.data.status == '200') {
                                this.refetchData()
                                this.$toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: `Deleted`,
                                        icon: 'CheckSquareIcon',
                                        variant: 'success',
                                        text: `Reason Master Delete Successfully`,
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
