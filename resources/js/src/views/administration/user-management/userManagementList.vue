<template>
    <div>

        <!-- Filters -->
        <user-list-filters
            :role-filter.sync="roleFilter"
            :department-filter.sync="departmentFilter"
            :status-filter.sync="statusFilter"
            :role-options="roleOptions"
            :department-options="departmentOptions"
            :status-options="statusOptions"
        />

        <!-- Table Container Card -->
        <b-card
            no-body
            class="mb-0"
        >
            <div class="m-2">

                <!-- Table Top -->
                <b-row>

                    <!-- Per Page -->
                    <b-col
                        cols="12"
                        md="6"
                        class="d-flex align-items-center justify-content-start mb-1 mb-md-0"
                    >
                        <label>Show</label>
                        <v-select
                            v-model="perPage"
                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                            :options="perPageOptions"
                            :clearable="false"
                            class="per-page-selector d-inline-block mx-50"
                        />
                        <label>entries</label>
                    </b-col>

                    <!-- Search -->
                    <b-col
                        cols="12"
                        md="6"
                    >
                        <div class="d-flex align-items-center justify-content-end">
                            <b-form-input
                                v-model="searchQuery"
                                class="d-inline-block mr-1"
                                placeholder="Search..."
                            />
                            <b-button
                                variant="primary"
                                :to="{ name:'add-user-details'}"
                            >
                                <span class="text-nowrap">Add User</span>
                            </b-button>
                        </div>
                    </b-col>
                </b-row>

            </div>

            <b-table
                ref="refUserListTable"
                class="position-relative"
                :items="fetchUsers"
                responsive
                :fields="tableColumns"
                primary-key="id"
                :sort-by.sync="sortBy"
                show-empty
                empty-text="No matching records found"
                :sort-desc.sync="isSortDirDesc"
            >

                <!-- Column: User -->
                <template #cell(user)="data">
                    <b-media vertical-align="center">
                        <template #aside>
                            <b-avatar
                                size="32"
                                :src="data.item.avatar"
                                :text="avatarText(data.item.email)"
                                :variant="`light-${resolveUserRoleVariant(data.item.role)}`"
                            />
                            <!--  :to="{ name: 'apps-users-view', params: { id: data.item.id } }"-->
                        </template>
                        <b-link
                            :to="{ name: 'edit-user-details', params: { id: data.item._id } }"
                            class="font-weight-bold d-block text-nowrap"
                            v-if="data.item.role !== 'SUPER-ADMIN'"
                        >
                            <span v-if="data.item.name">
                                {{ data.item.name }}
                            </span>
                            <span v-else>
                                {{ data.item.first_name }} {{ data.item.last_name }}
                            </span>
                        </b-link>
                        <b-link
                            class="font-weight-bold d-block text-nowrap"
                            v-else
                        >
                            <span v-if="data.item.name">
                                {{ data.item.name }}
                            </span>
                            <span v-else>
                                {{ data.item.first_name }} {{ data.item.last_name }}
                            </span>
                        </b-link>

                        <small class="text-muted">@{{ data.item.username }}</small>
                    </b-media>
                </template>

                <!-- Column: Role -->
                <template #cell(role)="data">
                    <div class="text-nowrap">
                        <feather-icon
                            :icon="resolveUserRoleIcon(data.item.role)"
                            size="18"
                            class="mr-50"
                            :class="`text-${resolveUserRoleVariant(data.item.role)}`"
                        />
                        <span class="align-text-top text-capitalize">{{ data.item.role }}</span>
                    </div>
                </template>

                <!-- Column: Status -->
                <template #cell(status)="data">
                    <b-badge
                        pill
                        :variant="`light-${resolveUserStatusVariant(data.item.status)}`"
                        class="text-capitalize"
                    >
                        {{ data.item.status }}
                    </b-badge>
                </template>

                <!-- Column: Actions -->
                <template #cell(actions)="data">
                    <b-dropdown
                        variant="link"
                        no-caret
                        :right="$store.state.appConfig.isRTL"
                        v-if="data.item.role !== 'SUPER-ADMIN'"
                    >

                        <template #button-content>
                            <feather-icon
                                icon="MoreVerticalIcon"
                                size="16"
                                class="align-middle text-body"
                            />
                        </template>
                        <!-- <b-dropdown-item :to="{ name: 'apps-users-view', params: { id: data.item.id } }">
                           <feather-icon icon="FileTextIcon" />
                           <span class="align-middle ml-50">Details</span>
                         </b-dropdown-item>-->

                        <b-dropdown-item :to="{ name: 'edit-user-details', params: { id: data.item._id } }">
                            <feather-icon icon="EditIcon"/>
                            <span class="align-middle ml-50">Edit</span>
                        </b-dropdown-item>

                        <b-dropdown-item @click="deleteUser(data.item._id)">
                            <feather-icon icon="TrashIcon"/>
                            <span class="align-middle ml-50">Delete</span>
                        </b-dropdown-item>
                    </b-dropdown>
                </template>

            </b-table>
            <div class="mx-2 mb-2">
                <b-row>

                    <b-col
                        cols="12"
                        sm="6"
                        class="d-flex align-items-center justify-content-center justify-content-sm-start"
                    >
                        <span class="text-muted">Showing {{ dataMeta.from }} to {{ dataMeta.to }} of {{ dataMeta.of }} entries</span>
                    </b-col>
                    <!-- Pagination -->
                    <b-col
                        cols="12"
                        sm="6"
                        class="d-flex align-items-center justify-content-center justify-content-sm-end"
                    >

                        <b-pagination
                            v-model="currentPage"
                            :total-rows="totalUsers"
                            :per-page="perPage"
                            first-number
                            last-number
                            class="mb-0 mt-1 mt-sm-0"
                            prev-class="prev-item"
                            next-class="next-item"
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

                    </b-col>

                </b-row>
            </div>
        </b-card>
    </div>
</template>

<script>
import {
    BCard,
    BCardBody,
    BRow,
    BCol,
    BFormInput,
    BButton,
    BTable,
    BMedia,
    BAvatar,
    BLink,
    BBadge,
    BDropdown,
    BDropdownItem,
    BPagination,
} from 'bootstrap-vue'
import vSelect from 'vue-select'
import useUsersList from '../user-management/useUsersList'
// import useUsersList from "../../apps/user/users-list/useUsersList";
import { avatarText, title } from '@core/utils/filter'
import { ref, onUnmounted } from '@vue/composition-api'
import userStoreModule from '../user-management/userStoreModule'
import store from '@/store'
import BCardCode from '@core/components/b-card-code'
import userListFilters from './userListFilters'
import axios from '@axios'
import Swal from 'sweetalert2'
import Toastification from '@core/components/toastification/ToastificationContent.vue'
import { useToast } from 'vue-toastification/composition'

export default {
    components: {
        BRow,
        BCol,
        BCard,
        BCardBody,
        vSelect,
        BFormInput,
        BButton,
        BTable,
        BMedia,
        BAvatar,
        BLink,
        BBadge,
        BDropdown,
        BDropdownItem,
        BPagination,
        BCardCode,
        useUsersList,
        userListFilters
    },
    setup() {
        const USER_APP_STORE_MODULE_NAME = 'app-user'

        const toast = useToast()

        // Register module
        if (!store.hasModule(USER_APP_STORE_MODULE_NAME)) store.registerModule(USER_APP_STORE_MODULE_NAME, userStoreModule)

        // UnRegister on leave
        onUnmounted(() => {
            if (store.hasModule(USER_APP_STORE_MODULE_NAME)) store.unregisterModule(USER_APP_STORE_MODULE_NAME)
        })

        const roleOptions = ref([
            {
                label: 'Admin',
                value: 'admin'
            },
            {
                label: 'Author',
                value: 'author'
            },
            {
                label: 'Editor',
                value: 'editor'
            },
            {
                label: 'Maintainer',
                value: 'maintainer'
            },
            {
                label: 'Subscriber',
                value: 'subscriber'
            },
        ])

        const departmentOptions = ref([
            {
                label: 'Administration',
                value: 'administration'
            },
            {
                label: 'Sales',
                value: 'sales'
            },
            {
                label: 'Marketing',
                value: 'marketing'
            },
            {
                label: 'Account',
                value: 'account'
            },
        ])

        const statusOptions = ref([
            {
                label: 'Pending',
                value: 'pending'
            },
            {
                label: 'Active',
                value: 'active'
            },
            {
                label: 'Inactive',
                value: 'inactive'
            },
        ])

        const tableColumns = [
            {
                key: 'user',
                sortable: true
            },
            {
                key: 'email',
                sortable: true
            },
            {
                key: 'role',
                sortable: true
            },
            {
                key: 'status',
                sortable: true
            },
            { key: 'actions' },
        ]

        const {
            fetchUsers,
            //tableColumns,
            perPage,
            currentPage,
            totalUsers,
            dataMeta,
            perPageOptions,
            searchQuery,
            sortBy,
            isSortDirDesc,
            refUserListTable,
            refetchData,

            // UI
            resolveUserRoleVariant,
            resolveUserRoleIcon,
            resolveUserStatusVariant,

            // Extra Filters
            roleFilter,
            departmentFilter,
            statusFilter,
        } = useUsersList()

        const deleteUser = async (id) => {
            await Swal.fire({
                title: 'Are you sure?',
                text: 'Delete User! You won\'t be able to revert this!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, do it!',
                cancelButtonText: 'No, keep it!',
                customClass: {
                    confirmButton: 'btn btn-primary',
                    cancelButton: 'btn btn-outline-danger ml-1',
                },
                buttonsStyling: false,
            })
                .then(result => {
                    if (result.value) {
                        axios.delete(`/api/users/${id}`)
                            .then(res => {
                                if (res.status === 200) {
                                    toast({
                                        component: Toastification,
                                        position: 'top-right',
                                        props: {
                                            title: 'User Deleted',
                                            icon: 'CheckSquareIcon',
                                            variant: 'success',
                                            text: 'You have successfully Deleted User.',
                                        },
                                    })
                                    refetchData()
                                } else {
                                    toast({
                                        component: Toastification,
                                        position: 'top-right',
                                        props: {
                                            title: 'Warning',
                                            icon: 'AlertCircleIcon',
                                            variant: 'warning',
                                            text: 'Something went wrong',
                                        },
                                    })
                                }
                            })
                            .catch(error => {
                                let response = error.response
                                if (response) {
                                    toast({
                                        component: Toastification,
                                        position: 'top-right',
                                        props: {
                                            title: 'Error',
                                            icon: 'AlertCircleIcon',
                                            variant: 'danger',
                                            text: 'Internal server error',
                                        },
                                    })
                                }
                            })
                    }
                })
        }

        return {
            fetchUsers,
            tableColumns,
            perPage,
            currentPage,
            totalUsers,
            dataMeta,
            perPageOptions,
            searchQuery,
            sortBy,
            isSortDirDesc,
            refUserListTable,
            refetchData,
            deleteUser,

            // Filter
            avatarText,

            // UI
            resolveUserRoleVariant,
            resolveUserRoleIcon,
            resolveUserStatusVariant,

            // Extra Filters
            roleFilter,
            departmentFilter,
            statusFilter,

            roleOptions,
            departmentOptions,
            statusOptions
        }
    }
}
</script>

<style lang="scss">
@import '~@core/scss/vue/libs/vue-select.scss';
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
