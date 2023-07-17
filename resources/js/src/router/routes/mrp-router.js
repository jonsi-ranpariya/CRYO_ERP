export default [
    {
        path: '/add-wo-shortage-purchase-items',
        name: 'add-wo-shortage-purchase-items',
        component: () => import('@/views/mrp/wo-shortage-purchase-items/woPurchaseItemAdd.vue'),
        meta: {
            pageTitle: 'Wo Purchase Items',
            breadcrumb: [
                {
                    text: 'Wo Purchase Items',
                    to: {name: 'wo-shortage-purchase-items'},
                },
                {
                    text: 'Add',
                    active: true,
                },
            ],
            resource: 'WO SHORTAGE (PURCHASE ITEMS) - CUMULATIVE',
            action: 'manage'
        },
    },
    {
        path: '/edit-wo-shortage-purchase-items/:id',
        name: 'edit-wo-shortage-purchase-items',
        component: () => import('@/views/mrp/wo-shortage-purchase-items/woPurchaseItemEdit.vue'),
        meta: {
            pageTitle: 'Wo Purchase Items',
            breadcrumb: [
                {
                    text: 'Wo Purchase Items',
                    to: {name: 'wo-shortage-purchase-items'},
                },
                {
                    text: 'Edit',
                    active: true,
                },
            ],
            resource: 'WO SHORTAGE (PURCHASE ITEMS) - CUMULATIVE',
            action: 'manage'
        },
    },
    {
        path: '/wo-shortage-assembly-components',
        name: 'wo-shortage-assembly-components',
        component: () => import('@/views/mrp/wo-shortage-assembly-components/woAssemblyComponentList.vue'),
        meta: {
            pageTitle: 'Wo Assembly Component',
            breadcrumb: [
                {
                    text: 'Wo Assembly Component',
                    active: true,
                },
            ],
            resource: 'WO SHORTAGE (ASSEMBLY/COMPONENTS) - CUMULATIVE',
            action: 'manage'
        },
    },
    {
        path: '/add-wo-assembly-components',
        name: 'add-wo-assembly-components',
        component: () => import('@/views/mrp/wo-shortage-assembly-components/woAssemblyComponentAdd.vue'),
        meta: {
            pageTitle: 'Wo Assembly Component',
            breadcrumb: [
                {
                    text: 'Wo Assembly Component',
                    to: {name: 'wo-shortage-assembly-components'},
                },
                {
                    text: 'Add',
                    active: true,
                },
            ],
            resource: 'WO SHORTAGE (ASSEMBLY/COMPONENTS) - CUMULATIVE',
            action: 'manage'
        },
    },
    {
        path: '/edit-wo-assembly-components/:id',
        name: 'edit-wo-assembly-components',
        component: () => import('@/views/mrp/wo-shortage-assembly-components/woAssemblyComponentEdit.vue'),
        meta: {
            pageTitle: 'Wo Assembly Component',
            breadcrumb: [
                {
                    text: 'Wo Assembly Component',
                    to: {name: 'wo-shortage-assembly-components'},
                },
                {
                    text: 'Edit',
                    active: true,
                },
            ],
            resource: 'WO SHORTAGE (ASSEMBLY/COMPONENTS) - CUMULATIVE',
            action: 'manage'
        },
    },
    {
        path: '/minimum-level-shortage',
        name: 'minimum-level-shortage',
        component: () => import('@/views/mrp/minimum-level-shortage/minimumLevelShortageList.vue'),
        meta: {
            pageTitle: 'Minimum Level Shortage',
            breadcrumb: [
                {
                    text: 'Minimum Level Shortage',
                    active: true,
                },
            ],
            resource: 'MINIMUM LEVEL SHORTAGE',
            action: 'manage'
        },
    },
    {
        path: '/add-minimum-level-shortage',
        name: 'add-minimum-level-shortage',
        component: () => import('@/views/mrp/minimum-level-shortage/minimumLevelShortageAdd.vue'),
        meta: {
            pageTitle: 'Minimum Level Shortage',
            breadcrumb: [
                {
                    text: 'Minimum Level Shortage',
                    to: {name: 'minimum-level-shortage'},
                },
                {
                    text: 'Add',
                    active: true,
                },
            ],
            resource: 'MINIMUM LEVEL SHORTAGE',
            action: 'manage'
        },
    },
    {
        path: '/edit-minimum-level-shortage/:id',
        name: 'edit-minimum-level-shortage',
        component: () => import('@/views/mrp/minimum-level-shortage/minimumLevelShortageEdit.vue'),
        meta: {
            pageTitle: 'Minimum Level Shortage',
            breadcrumb: [
                {
                    text: 'Minimum Level Shortage',
                    to: {name: 'minimum-level-shortage'},
                },
                {
                    text: 'Edit',
                    active: true,
                },
            ],
            resource: 'MINIMUM LEVEL SHORTAGE',
            action: 'manage'
        },
    },
    {
        path: '/manual-planning',
        name: 'manual-planning',
        component: () => import('@/views/mrp/manual-planning/manualPlanningList.vue'),
        meta: {
            pageTitle: 'Manual Planning',
            breadcrumb: [
                {
                    text: 'Manual Planning',
                    active: true,
                },
            ],
            resource: 'MANUAL PLANNING',
            action: 'manage'
        },
    },
    {
        path: '/add-manual-planning',
        name: 'add-manual-planning',
        component: () => import('@/views/mrp/manual-planning/manualPlanningAdd.vue'),
        meta: {
            pageTitle: 'Manual Planning',
            breadcrumb: [
                {
                    text: 'Manual Planning',
                    to: {name: 'manual-planning'},
                },
                {
                    text: 'Add',
                    active: true,
                },
            ],
            resource: 'MANUAL PLANNING',
            action: 'manage'
        },
    },
    {
        path: '/edit-manual-planning/:id',
        name: 'edit-manual-planning',
        component: () => import('@/views/mrp/manual-planning/manualPlanningEdit.vue'),
        meta: {
            pageTitle: 'Manual Planning',
            breadcrumb: [
                {
                    text: 'Manual Planning',
                    to: {name: 'manual-planning'},
                },
                {
                    text: 'Edit',
                    active: true,
                },
            ],
            resource: 'MANUAL PLANNING',
            action: 'manage'
        },
    },
    {
        path: '/wo-shortage-purchase-items',
        name: 'wo-shortage-purchase-items',
        component: () => import('@/views/mrp/wo-shortage-purchase-items/woPurchaseItemList.vue'),
        meta: {
            pageTitle: 'Wo Purchase Items',
            breadcrumb: [
                {
                    text: 'Wo Purchase Items',
                    active: true,
                },
            ],
            resource: 'WO SHORTAGE (PURCHASE ITEMS) - WO WISE',
            action: 'manage'
        },
    },
    {
        path: '/wo-shortage-purchase-items-wo-wise',
        name: 'wo-shortage-purchase-items-wo-wise',
        component: () => import('@/views/mrp/wo-shortage-purchase-item-wo-wise/WoWisePurchaseItemList.vue'),
        meta: {
            pageTitle: 'Wo Purchase Items (Wo Wise)',
            breadcrumb: [
                {
                    text: 'Wo Purchase Items (Wo Wise)',
                    active: true,
                },
            ],
            resource: 'WO SHORTAGE (PURCHASE ITEMS) - WO WISE',
            action: 'manage'
        },
    },
    {
        path: '/add-wo-shortage-purchase-items-wo-wise',
        name: 'add-wo-shortage-purchase-items-wo-wise',
        component: () => import('@/views/mrp/wo-shortage-purchase-item-wo-wise/WoWisePurchaseItemAdd.vue'),
        meta: {
            pageTitle: 'Wo Wise Purchase Items',
            breadcrumb: [
                {
                    text: 'Wo Wise Purchase Items',
                    to: {name: 'wo-shortage-purchase-items-wo-wise'},
                },
                {
                    text: 'Add',
                    active: true,
                },
            ],
            resource: 'WO SHORTAGE (PURCHASE ITEMS) - WO WISE',
            action: 'manage'
        },
    },
    {
        path: '/edit-wo-shortage-purchase-items-wo-wise/:id',
        name: 'edit-wo-shortage-purchase-items-wo-wise',
        component: () => import('@/views/mrp/wo-shortage-purchase-item-wo-wise/WoWisePurchaseItemEdit.vue'),
        meta: {
            pageTitle: 'Wo Wise Purchase Items',
            breadcrumb: [
                {
                    text: 'Wo Wise Purchase Items',
                    to: {name: 'wo-shortage-purchase-items-wo-wise'},
                },
                {
                    text: 'Edit',
                    active: true,
                },
            ],
            resource: 'WO SHORTAGE (PURCHASE ITEMS) - WO WISE',
            action: 'manage'
        },
    },
    {
        path: '/wo-shortage-assembly-component-wo-wise',
        name: 'wo-shortage-assembly-component-wo-wise',
        component: () => import('@/views/mrp/wo-shortage-assembly-components-wo-wise/WoWiseAssemblyComponentList.vue'),
        meta: {
            pageTitle: 'Wo Wise Assembly Component',
            breadcrumb: [
                {
                    text: 'Wo Wise Assembly Component',
                    active: true,
                },
            ],
            resource: 'WO SHORTAGE (ASSEMBLY/COMPONENTS) - WO WISE',
            action: 'manage'
        },
    },
    {
        path: '/add-wo-shortage-assembly-component-wo-wise/:id',
        name: 'add-wo-shortage-assembly-component-wo-wise',
        component: () => import('@/views/mrp/wo-shortage-assembly-components-wo-wise/WoWiseAssemblyComponentAdd.vue'),
        meta: {
            pageTitle: 'Wo Wise Assembly Component',
            breadcrumb: [
                {
                    text: 'Wo Wise Assembly Component',
                    to: {name: 'wo-shortage-assembly-component-wo-wise'},
                },
                {
                    text: 'Add',
                    active: true,
                },
            ],
            resource: 'WO SHORTAGE (ASSEMBLY/COMPONENTS) - WO WISE',
            action: 'manage'
        },
    },
    {
        path: '/edit-wo-shortage-assembly-component-wo-wise/:id',
        name: 'edit-wo-shortage-assembly-component-wo-wise',
        component: () => import('@/views/mrp/wo-shortage-assembly-components-wo-wise/WoWiseAssemblyComponentEdit.vue'),
        meta: {
            pageTitle: 'Wo Wise Assembly Component',
            breadcrumb: [
                {
                    text: 'Wo Wise Assembly Component',
                    to: {name: 'wo-shortage-assembly-component-wo-wise'},
                },
                {
                    text: 'Edit',
                    active: true,
                },
            ],
            resource: 'WO SHORTAGE (ASSEMBLY/COMPONENTS) - WO WISE',
            action: 'manage'
        },
    },
    {
        path: '/pending-indent',
        name: 'pending-indent',
        component: () => import('@/views/mrp/pending-indent/PendingIndentList.vue'),
        meta: {
            pageTitle: 'Pending Indent',
            breadcrumb: [
                {
                    text: 'Pending Indent',
                    active: true,
                },
            ],
            resource: 'PENDING INDENT',
            action: 'manage'
        },
    },
    {
        path: '/view-pending-indent/:id',
        name: 'view-pending-indent',
        component: () => import('@/views/mrp/pending-indent/PendingIndentView.vue'),
        meta: {
            pageTitle: 'Pending Indent',
            breadcrumb: [
                {
                    text: 'Pending Indent',
                    to: {name: 'pending-indent'}
                },
                {
                    text: 'View',
                    active: true,
                },
            ],
            resource: 'PENDING INDENT',
            action: 'manage'
        },
    },
    {
        path: '/indent-approval',
        name: 'indent-approval',
        component: () => import('@/views/mrp/indent-approval/IndentApprovalList.vue'),
        meta: {
            pageTitle: 'Indent Approval',
            breadcrumb: [
                {
                    text: 'Indent Approval',
                    active: true,
                },
            ],
            resource: 'INDENT APPROVAL',
            action: 'manage'
        },
    },
    {
        path: '/view-indent-approval/:id',
        name: 'view-indent-approval',
        component: () => import('@/views/mrp/indent-approval/IndentApprovalView.vue'),
        meta: {
            pageTitle: 'Indent Approval',
            breadcrumb: [
                {
                    text: 'Indent Approval',
                    to: {name: 'indent-approval'}
                },
                {
                    text: 'View',
                    active: true,
                },
            ],
            resource: 'INDENT APPROVAL',
            action: 'manage'
        },
    },
]
