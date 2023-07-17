<template>
    <b-overlay
        :show="showOverlayLoading"
        rounded="sm"
    >
        <div>
            <item-addon-detail-add-new
                :is-add-new-user-sidebar-active.sync="isAddNewUserSidebarActive"
                :userform-data="userFormData"
                :addon-type-options="addonTypeOptions"
                :is-print-options="isPrintOptions"
                @refetch-data="refetchData"
            />

            <b-card-code>

                <b-row class="mb-2">
                    <b-col
                        cols="12"
                        md="6"
                        class="d-flex align-items-center justify-content-start"
                    >
                        <b-button
                            variant="primary"
                            @click="AddNewDatTosidebar()"
                        >
                            Add New Item Addon Detail
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
                    :line-numbers="true"
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
                            v-if="props.column.field === 'addonDetailTitle'"
                            class="text-nowrap"
                        >

          <span class="text-nowrap">{{ props.row.addonDetailTitle }}</span>

        </span>

                        <span
                            v-else-if="props.column.field === 'addonDetailType'"
                            class="text-nowrap"
                        >

          <span class="text-nowrap">{{ getAddonTypeName(props.row.addonDetailType) }}</span>
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
    import itemStoreModule from '../itemStoreModule'
    import itemAddonDetailAddNew from './itemAddonDetailAddNew.vue'

    export default {
        components: {
            itemAddonDetailAddNew,
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

                this.$http.get('/api/item-addon-detail').then(res => {

                    this.rows = res.data.data

                    this.showOverlayLoading = false

                })

            }

            const isAddNewUserSidebarActive = false

            const userFormData = {
                id: null,
                addonDetailTitle: '',
                addonDetailType: '',
                addonDetailDescription: '',
                addonDetailIsPrint: '',
            }

            const addonTypeOptions = []
            const isPrintOptions = [{label: 'Yes', value: 1},{label: 'No', value: 2}]

            return {
                isAddNewUserSidebarActive,
                userFormData,
                addonTypeOptions,
                isPrintOptions,
                pageLength: 5,
                dir: false,
                columns: [
                    {
                        label: 'Title',
                        field: 'addonDetailTitle',
                    },
                    {
                        label: 'Addon Type',
                        field: 'addonDetailType',
                    },
                    {
                        label: 'Detail Description',
                        field: 'addonDetailDescription',
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

            const ITEMADDONDETAIL_APP_STORE_MODULE_NAME = 'item-addon-detail-module'

            // Register module
            if (!store.hasModule(ITEMADDONDETAIL_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDONDETAIL_APP_STORE_MODULE_NAME, itemStoreModule)

            // UnRegister on leave
            onUnmounted(() => {
                if (store.hasModule(ITEMADDONDETAIL_APP_STORE_MODULE_NAME)) store.unregisterModule(ITEMADDONDETAIL_APP_STORE_MODULE_NAME)
            })
        },
        computed: {
            direction() {
                if (store.state.appConfig.isRTL) {
                    // eslint-disable-next-line vue/no-side-effects-in-computed-properties
                    this.dir = true
                    return this.dir
                }
                // eslint-disable-next-line vue/no-side-effects-in-computed-properties
                this.dir = false
                return this.dir
            },
        },
        created() {

            this.showOverlayLoading = true

            this.$http.get('/api/item-addon-detail').then(res => {

                this.rows = res.data.data

                this.showOverlayLoading = false

            })

            this.$http.get('/api/get-item-addon-type-options').then(res => {

                this.addonTypeOptions = res.data.data

            })


        },
        methods: {

            getAddonTypeName(cat) {

                var valObj = this.addonTypeOptions.filter(function (elem) {
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

            EditMySidebar(user) {
                this.isAddNewUserSidebarActive = true
                this.userFormData = user
                //console.log(user)
            },

            AddNewDatTosidebar() {

                this.isAddNewUserSidebarActive = true

                this.userFormData = {
                    id: null,
                    addonDetailTitle: '',
                    addonDetailType: '',
                    addonDetailDescription: '',
                    addonDetailIsPrint: '',
                }

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

                        store.dispatch(`item-addon-detail-module/deleteItemAddonDetail`, {id}).then(response => {

                            if (response.data.status == '200') {

                                this.refetchData()

                                this.$toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: `Deleted`,
                                        icon: 'CheckSquareIcon',
                                        variant: 'success',
                                        text: `Item Addon Detail Delete Successfully`,
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
