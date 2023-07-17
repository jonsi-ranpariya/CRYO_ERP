import { ref, watch, computed } from '@vue/composition-api'
import store from '@/store'
import { title } from '@core/utils/filter'

// Notification
import { useToast } from 'vue-toastification/composition'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'

export default function useUsersList() {
    // Use toast
    const toast = useToast()

    const refUserListTable = ref(null)

    // Table Handlers
    const tableColumns = [
        { key: 'user', sortable: true },
        { key: 'email', sortable: true },
        { key: 'role', sortable: true },
        {
            key: 'currentDepartment',
            label: 'Department',
            formatter: title,
            sortable: true,
        },
        { key: 'status', sortable: true },
        { key: 'actions' },
    ]
    const perPage = ref(10)
    const totalUsers = ref(0)
    const currentPage = ref(1)
    const perPageOptions = [10, 25, 50, 100]
    const searchQuery = ref('')
    const sortBy = ref('id')
    const isSortDirDesc = ref(true)
    const roleFilter = ref(null)
    const departmentFilter = ref(null)
    const statusFilter = ref(null)

    const dataMeta = computed(() => {
        const localItemsCount = refUserListTable.value ? refUserListTable.value.localItems.length : 0
        return {
            from: perPage.value * (currentPage.value - 1) + (localItemsCount ? 1 : 0),
            to: perPage.value * (currentPage.value - 1) + localItemsCount,
            of: totalUsers.value,
        }
    })

    const refetchData = () => {
        refUserListTable.value.refresh()
    }

    watch([currentPage, perPage, searchQuery, roleFilter, departmentFilter, statusFilter], () => {
        refetchData()
    })

    const fetchUsers = (ctx, callback) => {
        store
            .dispatch('app-user/fetchUsers', {
                q: searchQuery.value,
                perPage: perPage.value,
                page: currentPage.value,
                sortBy: sortBy.value,
                sortDesc: isSortDirDesc.value,
                role: roleFilter.value,
                plan: departmentFilter.value,
                status: statusFilter.value,
            })
            .then(response => {
                const { data, total } = response.data.data
                callback(data)
                totalUsers.value = total
            })
            .catch(() => {
                toast({
                    component: ToastificationContent,
                    props: {
                        title: 'Error fetching users list',
                        icon: 'AlertTriangleIcon',
                        variant: 'danger',
                    },
                })
            })
    }

    // *===============================================---*
    // *--------- UI ---------------------------------------*
    // *===============================================---*

    const resolveUserRoleVariant = role => {
        if (role === 'SUPER-ADMIN') return 'warning'
        if (role === 'ADMIN') return 'danger'
        if (role === 'HOD-ADMIN') return 'info'
        if (role === 'USER') return 'primary'
        if (role === 'EMPLOYEE') return 'success'
        return 'primary'
    }

    const resolveUserRoleIcon = role => {
        if (role === 'SUPER-ADMIN') return 'DatabaseIcon'
        if (role === 'ADMIN') return 'SettingsIcon'
        if (role === 'HOD-ADMIN') return 'ServerIcon'
        if (role === 'USER') return 'UserIcon'
        if (role === 'EMPLOYEE') return 'Edit2Icon'
        return 'UserIcon'
    }

    const resolveUserStatusVariant = status => {
        if (status === 'Pending') return 'warning'
        if (status === 'Active') return 'success'
        if (status === 'Inactive') return 'secondary'
        return 'primary'
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

        resolveUserRoleVariant,
        resolveUserRoleIcon,
        resolveUserStatusVariant,
        refetchData,

        // Extra Filters
        roleFilter,
        departmentFilter,
        statusFilter,
    }
}
