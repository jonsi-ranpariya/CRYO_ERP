export default [
    {
        path: '/grade-master',
        name: 'grade-master',
        component: () => import('@/views/hr-master/grade-master/gradeMasterList.vue'),
        meta: {
            pageTitle: 'Grade Master',
            breadcrumb: [
                {
                    text: 'List',
                    active: true,
                },
            ],
            resource: 'GRADE MASTER',
            action: 'manage',
        },
    },
    {
        path: '/branch-master',
        name: 'hr-branch-master',
        component: () => import('@/views/hr-master/branch-master/branchMasterList.vue'),
        meta: {
            pageTitle: 'Branch Master',
            breadcrumb: [
                {
                    text: 'List',
                    active: true,
                },
            ],
            resource: 'HR BRANCH MASTER',
            action: 'manage',
        },
    },
    {
        path: '/department-master',
        name: 'hr-department-master',
        component: () => import('@/views/hr-master/department-master/departmentMasterList.vue'),
        meta: {
            pageTitle: 'Department Master',
            breadcrumb: [
                {
                    text: 'List',
                    active: true,
                },
            ],
            resource: 'DEPARTMENT MASTER',
            action: 'manage',
        },
    },
    {
        path: '/division-master',
        name: 'division-master',
        component: () => import('@/views/hr-master/division-master/divisionMasterList.vue'),
        meta: {
            pageTitle: 'Division Master',
            breadcrumb: [
                {
                    text: 'List',
                    active: true,
                },
            ],
            resource: 'DIVISION MASTER',
            action: 'manage',
        },
    },
    {
        path: '/unit-master',
        name: 'unit-master',
        component: () => import('@/views/hr-master/unit-master/unitMasterList.vue'),
        meta: {
            pageTitle: 'Unit Master',
            breadcrumb: [
                {
                    text: 'Unit Master',
                    active: true,
                },
            ],
            resource: 'UNIT MASTER',
            action: 'manage',
        },
    },
    {
        path: '/category-master',
        name: 'category-master',
        component: () => import('@/views/hr-master/category-master/categoryMasterList.vue'),
        meta: {
            pageTitle: 'Category Master',
            breadcrumb: [
                {
                    text: 'Category Master',
                    active: true,
                },
            ],
            resource: 'CATEGORY MASTER',
            action: 'manage',
        },
    },
    {
        path: '/group-master',
        name: 'group-master',
        component: () => import('@/views/hr-master/group-master/groupMasterList.vue'),
        meta: {
            pageTitle: 'Group Master',
            breadcrumb: [
                {
                    text: 'Group Master',
                    active: true,
                },
            ],
            resource: 'GROUP MASTER',
            action: 'manage',
        },
    },
    {
        path: '/hr-designation-master',
        name: 'hr-designation-master',
        component: () => import('@/views/hr-master/designation-master/designationMasterList.vue'),
        meta: {
            pageTitle: 'Designation Master',
            breadcrumb: [
                {
                    text: 'Designation Master',
                    active: true,
                },
            ],
            resource: 'DESIGNATION MASTER',
            action: 'manage',
        },
    },
]


