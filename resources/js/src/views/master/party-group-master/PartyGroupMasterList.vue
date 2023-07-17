<template>
    <b-card-code>
        <b-row class="mb-2">
            <b-col
                cols="12"
                md="6"
                class="d-flex align-items-center justify-content-start"
            >
                <party-group-master-add
                    :is-add-new-party-group-master-sidebar-active.sync="isAddNewPartyGroupMasterSidebarActive"
                />
                <party-group-master-edit
                    :is-edit-new-party-group-master-sidebar-active.sync="isEditNewPartyGroupMasterSidebarActive"
                    :partyGroupData="partyGroupData"
                />
                <b-button
                    variant="primary"
                    @click="isAddNewPartyGroupMasterSidebarActive = true"
                >
                    Add New Party Group
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

                  <span class="text-nowrap">{{ props.row._id }}</span>
                </span>-->

                <!-- Column: Name -->
                <span
                    v-if="props.column.field === 'GroupName'"
                    class="text-nowrap"
                >

                  <span class="text-nowrap">{{ props.row.groupName }}</span>
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
                      <b-dropdown-item @click="getGroupMasterData(props.row._id)"> <!--getGroupMasterData(props.row._id)//:to="{ name: 'edit-party-master', params: { id: props.row._id} }"-->
                        <feather-icon
                            icon="Edit2Icon"
                            class="mr-50"
                        />
                        <span>Edit</span>
                      </b-dropdown-item>
                      <b-dropdown-item @click="deleteGroupMasterData(props.row._id)">
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
    import {VueGoodTable} from 'vue-good-table'
    import store from '@/store'
    import PartyGroupMasterAdd from "./PartyGroupMasterAdd";
    import {onUnmounted, ref} from "@vue/composition-api";
    import partyStoreModule from "../partyStoreModule";
    import PartyGroupMasterEdit from "./PartyGroupMasterEdit";
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'

    export default {
        components: {
            PartyGroupMasterEdit,
            PartyGroupMasterAdd,
            BCardCode,
            VueGoodTable,
            BAvatar,
            BBadge,
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
            return {
                pageLength: 10,
                dir: false,
                columns: [
                    /*{
                        label: 'Sr No',
                        field: '_id',
                    },*/
                    {
                        label: 'Group Name',
                        field: 'groupName',
                    },
                    {
                        label: 'Action',
                        field: 'action',
                    },
                ],
                //rows: [],
                searchTerm: '',
            }
        },
        mounted() {
            function getPartyGroupMasterList() {
                store.dispatch(`master-add/fetchPartyGroupMasterList`)
            }

            getPartyGroupMasterList()
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
                return this.$store.getters['partyStoreModule/getPartyGroupMasterList']
            },
        },
        setup() {
            const isAddNewPartyGroupMasterSidebarActive = ref(false)
            const isEditNewPartyGroupMasterSidebarActive = ref(false)
            const partyGroupData = {
                id : '',
                groupName: '',
            }

            const PARTY_MASTER_APP_STORE_MODULE_NAME = 'master-add'

            // Register module
            if (!store.hasModule(PARTY_MASTER_APP_STORE_MODULE_NAME)) store.registerModule(PARTY_MASTER_APP_STORE_MODULE_NAME, partyStoreModule)

            // UnRegister on leave
            onUnmounted(() => {
                if (store.hasModule(PARTY_MASTER_APP_STORE_MODULE_NAME)) store.unregisterModule(PARTY_MASTER_APP_STORE_MODULE_NAME)
            })

            return {
                isAddNewPartyGroupMasterSidebarActive,
                isEditNewPartyGroupMasterSidebarActive,
                partyGroupData
            }
        },
        methods: {
            getGroupMasterData(id) {
                store.dispatch(`master-add/getPartyGroupMaster`,{
                    id
                }).then((response) => {
                    this.partyGroupData.groupName = response.data.data.groupName
                    this.partyGroupData.id = response.data.data._id
                    this.isEditNewPartyGroupMasterSidebarActive = true
                })
            },
            async deleteGroupMasterData(id) {
                await store.dispatch(`master-add/deletePartyGroupMaster`, {
                    id
                }).then(response => {
                    if (response.data.status == '200') {
                        store.dispatch('master-add/fetchPartyGroupMasterList')
                        this.$toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: `Deleted`,
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: `Group Delete Successfully`,
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
        }
    }
</script>
