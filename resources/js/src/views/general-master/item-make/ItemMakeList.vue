<template>
    <b-card-code>
        <b-row class="mb-2">
            <b-col
                cols="12"
                md="6"
                class="d-flex align-items-center justify-content-start"
            >
                <item-make-add
                    :is-add-new-item-make-master-sidebar-active.sync="isAddNewItemMakeMasterSidebarActive"
                />

                <item-make-edit
                    :is-edit-new-item-make-master-sidebar-active.sync="isEditNewItemMakeMasterSidebarActive"
                    :item-make-master-data="itemMakeMasterData"
                />
                <b-button
                    variant="primary"
                    @click="isAddNewItemMakeMasterSidebarActive = true"
                >
                    Add Item Make
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
            :line-numbers="true"
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
                <!--<span
                    v-if="props.column.field === 'srNo'"
                    class="text-nowrap"
                >

                 &lt;!&ndash;<span class="text-nowrap">{{ props.row._id }}</span>&ndash;&gt;
               </span>-->

                <!-- Column: Name -->
                <span
                    v-if="props.column.field === 'Make'"
                    class="text-nowrap"
                >

                  <span class="text-nowrap">{{ props.row.make }}</span>
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
                      <b-dropdown-item @click="getItemMakeMasterData(props.row._id)">
                        <feather-icon
                            icon="Edit2Icon"
                            class="mr-50"
                        />
                        <span>Edit</span>
                      </b-dropdown-item>
                      <b-dropdown-item @click="deleteItemMakeMasterData(props.row._id)">
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
</template>
<script>
    import BCardCode from '@core/components/b-card-code/BCardCode.vue'
    import {
        BAvatar, BBadge, BPagination, BFormGroup, BFormInput, BFormSelect, BDropdown, BDropdownItem, BButton, BRow,
        BCol,
    } from 'bootstrap-vue'
    import  {VueGoodTable} from 'vue-good-table'
    import store from '@/store'
    import {onUnmounted, ref} from "@vue/composition-api";
    import itemMakeStore from "./itemMakeStoreModule";
    import ItemMakeAdd from "./ItemMakeAdd";
    import ItemMakeEdit from "./ItemMakeEdit";
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'

    export default {
        components:{
            ItemMakeEdit,
            ItemMakeAdd,
            BCardCode,
            BAvatar,
            BBadge,
            BPagination,
            BFormGroup,
            BFormInput,
            BFormSelect,
            BDropdown,
            BDropdownItem,
            BButton,
            BRow,
            BCol,
            VueGoodTable,
        },
        data() {
            return {
                pageLength: 10,
                dir: false,
                columns: [
                    {
                        label: 'Make',
                        field: 'makeName',
                    },
                    {
                        label: 'Action',
                        field: 'action',
                    },
                ],
                searchTerm: '',
            }
        },
        mounted() {
            function getItemMakeMasterList() {
                store.dispatch(`item-make-master/fetchItemMakeMasterList`)
            }

            getItemMakeMasterList()
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
            rows() {
                return this.$store.getters["itemMakeStoreModule/getItemMakeList"]
            }
        },
        setup() {
            const isAddNewItemMakeMasterSidebarActive = ref(false)
            const isEditNewItemMakeMasterSidebarActive = ref(false)
            const itemMakeData = {
                id : '',
                makeName: '',
            }

            const itemMakeMasterData = ref(JSON.parse(JSON.stringify(itemMakeData)))

            const resetgroupData = () => {
                itemMakeMasterData.value = JSON.parse(JSON.stringify(itemMakeData))
            }

            const ITEM_MAKE_STORE_MODULE_NAME = 'item-make-master'

            // Register module
            if (!store.hasModule(ITEM_MAKE_STORE_MODULE_NAME)) store.registerModule(ITEM_MAKE_STORE_MODULE_NAME, itemMakeStore)

            // UnRegister on leave
            onUnmounted(() => {
                if (store.hasModule(ITEM_MAKE_STORE_MODULE_NAME)) store.unregisterModule(ITEM_MAKE_STORE_MODULE_NAME)
            })

            return {
                isAddNewItemMakeMasterSidebarActive,
                isEditNewItemMakeMasterSidebarActive,
                itemMakeMasterData
            }
        },
        methods:{
            getItemMakeMasterData(id){
                store.dispatch(`item-make-master/getItemMakeMaster`,{
                    id
                }).then((response) => {
                    this.itemMakeMasterData.makeName = response.data.data.makeName
                    this.itemMakeMasterData.id = response.data.data._id
                    this.isEditNewItemMakeMasterSidebarActive = true
                })
            },
            async deleteItemMakeMasterData(id){
                await this.$swal({
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
                        store.dispatch(`item-make-master/deleteItemMakeMaster`, {
                            id
                        }).then(response => {
                            if (response.status === 200) {
                                store.dispatch('item-make-master/fetchItemMakeMasterList')
                                this.$toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: `Deleted`,
                                        icon: 'CheckSquareIcon',
                                        variant: 'success',
                                        text: `Make Delete Successfully`,
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
<style lang="scss" >
    @import '~@core/scss/vue/libs/vue-good-table.scss';
</style>
<style lang="scss">
@import '~@core/scss/vue/libs/vue-sweetalert.scss';
</style>
