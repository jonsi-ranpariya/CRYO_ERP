export default [
    {
        title: 'Administration & Setup',
        icon: 'ToolIcon',
        children: [
            {
                title: 'Company',
                route: 'company-details',
                resource: 'COMPANY',
                action: 'manage',
            },
            {
                title: 'User Management',
                route: 'user-management',
                resource: 'USER MANAGEMENT',
                action: 'manage',
            },
            {
                title: 'Permission Management',
                route: 'permission-management',
                resource: 'PERMISSION MANAGEMENT',
                action: 'manage',
            },
            {
                title: 'Role Management',
                route: 'role-management',
                resource: 'ROLE MANAGEMENT',
                action: 'manage',
            },
            {
                title: 'User Reference',
                route: 'apps-users-list',
            },
            {
                title: 'Report Parameters',
                route: null,
            },
            {
                title: 'Report Designing',
                route: null,
            },
            {
                title: 'Backup',
                route: null,
            },
            {
                title: 'Sales Purchase File For Accounting',
                toolTipText: 'Sales Purchase File For Accounting',
                route: null,
            },
            {
                title: 'Auto Mail Parameters',
                toolTipText: 'Auto Mail Parameters',
                route: null,
            },
            {
                title: 'View Login Users',
                route: null,
            },
        ]

    },
]
