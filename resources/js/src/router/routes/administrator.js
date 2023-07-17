export default [
    {
        path: '/company-details',
        name: 'company-details',
        component: () => import('@/views/administration/company/companyDetailsList.vue'),
        meta: {
            pageTitle: 'Company',
            breadcrumb: [
                {
                    text: 'Company',
                    active: true,
                },
            ],
            resource: 'COMPANY',
            action: 'manage',
        },
    },
    {
        path: '/add-company-details',
        name: 'add-company-details',
        component: () => import('@/views/administration/company/companyDetailsAdd.vue'),
        meta: {
            pageTitle: 'Company',
            breadcrumb: [
                {
                    text: 'Company',
                    to: {name: 'company-details'},
                },
                {
                    text: 'Add Company',
                    active: true,
                },
            ],
            resource: 'COMPANY',
            action: 'manage',
        },
    },
    {
        path: '/edit-company-details/:id',
        name: 'edit-company-details',
        component: () => import('@/views/administration/company/companyDetailsEdit.vue'),
        meta: {
            pageTitle: 'Company',
            breadcrumb: [
                {
                    text: 'Company',
                    to: {name: 'company-details'},
                },
                {
                    text: 'Edit Company',
                    active: true,
                },
            ],
            resource: 'COMPANY',
            action: 'manage',
        },
    },
    {
        path: '/administration/users',
        name: 'user-management',
        component: () => import('@/views/administration/user-management/userManagementList.vue'),
        meta: {
            pageTitle: 'User Detail',
            breadcrumb: [
                {
                    text: 'User Detail',
                    active: true,
                },

            ],
            resource: 'USER MANAGEMENT',
            action: 'manage',
        },
    },
    {
        path: '/administration/user-add',
        name: 'add-user-details',
        component: () => import('@/views/administration/user-management/userManagementDataAdd.vue'),
        meta: {
            pageTitle: 'Users Details',
            breadcrumb: [
                {
                    text: 'Users Details',
                    to: {name: 'user-management'},
                },
                {
                    text: 'Add',
                    active: true,
                },
            ],
            resource: 'USER MANAGEMENT',
            action: 'manage',
        },
    },
    {
        path: '/administration/user-edit/:id',
        name: 'edit-user-details',
        component: () => import('@/views/administration/user-management/userManagementDataEdit.vue'),
        meta: {
            pageTitle: 'Users Details',
            breadcrumb: [
                {
                    text: 'Users Details',
                    to: {name: 'user-management'},
                },
                {
                    text: 'Edit',
                    active: true,
                },
            ],
            resource: 'USER MANAGEMENT',
            action: 'manage',
        },
    },
    {
        path: '/permission-management',
        name: 'permission-management',
        component: () => import('@/views/administration/permission-management/permissionManagementList.vue'),
        meta: {
            pageTitle: 'Permission Management',
            breadcrumb: [
                {
                    text: 'Permission Management',
                    active: true,
                },
            ],
            resource: 'PERMISSION MANAGEMENT',
            action: 'manage',
        },
    },
    {
        path: '/role-management',
        name: 'role-management',
        component: () => import('@/views/administration/role-management/roleManagementList.vue'),
        meta: {
            pageTitle: 'Role Management',
            breadcrumb: [
                {
                    text: 'Role Management',
                    active: true,
                },
            ],
            resource: 'ROLE MANAGEMENT',
            action: 'manage',
        },
    },
    {
        path: '/add-role-management',
        name: 'add-role-management',
        component: () => import('@/views/administration/role-management/roleManagementAdd.vue'),
        meta: {
            pageTitle: 'Role Management',
            breadcrumb: [
                {
                    text: 'Role Management',
                    to: {name: 'role-management'},
                },
                {
                    text: 'Add',
                    active: true,
                },
            ],
            resource: 'ROLE MANAGEMENT',
            action: 'manage',
        },
    },
    {
        path: '/edit-role-management/:id',
        name: 'edit-role-management',
        component: () => import('@/views/administration/role-management/roleManagementEdit.vue'),
        meta: {
            pageTitle: 'Role Management',
            breadcrumb: [
                {
                    text: 'Role Management',
                    to: {name: 'role-management'},
                },
                {
                    text: 'Edit',
                    active: true,
                },
            ],
            resource: 'ROLE MANAGEMENT',
            action: 'manage',
        },
    },

]
