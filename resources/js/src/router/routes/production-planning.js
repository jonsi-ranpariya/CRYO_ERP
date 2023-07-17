export default [
    {
        path: '/work-order',
        name: 'work-order',
        component: () => import('@/views/production-planning/work-order/workOrderList.vue'),
        meta: {
            pageTitle: 'Work Order List',
            breadcrumb: [
                {
                    text: 'Work Order List',
                    active: true,
                },
            ],
            resource: 'WORK ORDER',
            action: 'manage'
        },
    },
    {
        path: '/add-work-order',
        name: 'add-work-order',
        component: () => import('@/views/production-planning/work-order/workOrderAdd.vue'),
        meta: {
            pageTitle: 'Work Order Add',
            breadcrumb: [
                {
                    text: 'Work Order List',
                    to: {name: 'work-order'},
                },
                {
                    text: 'Work Order Add',
                    active: true,
                },
            ],
            resource: 'WORK ORDER',
            action: 'manage'
        },
    },
    {
        path: '/edit-work-order/:id',
        name: 'edit-work-order',
        component: () => import('@/views/production-planning/work-order/workOrderEdit.vue'),
        meta: {
            pageTitle: 'Work Order Edit',
            breadcrumb: [
                {
                    text: 'Work Order List',
                    to: {name: 'work-order'},
                },
                {
                    text: 'Work Order Edit',
                    active: true,
                },
            ],
            resource: 'WORK ORDER',
            action: 'manage'
        },
    },
    {
        path: '/edit-work-order/:id/:assemblyId',
        name: 'work-order-item-details',
        component: () => import('@/views/production-planning/work-order/workOrderItemDetails.vue'),
        meta: {
            pageTitle: 'Work Order Details',
            breadcrumb: [
                {
                    text: 'WO List',
                    to: {name: 'work-order'},
                },
                {
                    text: 'WO Edit',
                    to: {name: 'edit-work-order'},
                },
                {
                    text: 'WO Details',
                    active: true
                },
            ],
            resource: 'WORK ORDER',
            action: 'manage'
        },
    },
    {
        path: '/process-sheet-master',
        name: 'process-sheet-master',
        component: () => import('@/views/production-planning/process-sheet-master/processSheetMasterList.vue'),
        meta: {
            pageTitle: 'Process Sheet',
            breadcrumb: [
                {
                    text: 'Process Sheet',
                    active: true,
                },
            ],
            resource: 'PROCESS SHEET',
            action: 'manage'
        },
    },
    {
        path: '/add-process-sheet-master',
        name: 'add-process-sheet-master',
        component: () => import('@/views/production-planning/process-sheet-master/processSheetMasterAdd.vue'),
        meta: {
            pageTitle: 'Add Process Sheet',
            breadcrumb: [
                {
                    text: 'Process Sheet List',
                    to: {name: 'process-sheet-master'},
                },
                {
                    text: 'Add Process Sheet',
                    active: true,
                },
            ],
            resource: 'PROCESS SHEET',
            action: 'manage'
        },
    },
    {
        path: '/edit-process-sheet-master/:id',
        name: 'edit-process-sheet-master',
        component: () => import('@/views/production-planning/process-sheet-master/processSheetMasterEdit.vue'),
        meta: {
            pageTitle: 'Edit Process Sheet',
            breadcrumb: [
                {
                    text: 'Process Sheet List',
                    to: {name: 'process-sheet-master'},
                },
                {
                    text: 'Edit Process Sheet',
                    active: true,
                },
            ],
            resource: 'PROCESS SHEET',
            action: 'manage'
        },
    },
    {
        path: '/Job-card',
        name: 'Job-card',
        component: () => import('@/views/production-planning/job-card/jobCardList.vue'),
        meta: {
            pageTitle: 'Job Card List',
            breadcrumb: [
                {
                    text: 'Job Card List',
                    active: true,
                },
            ],
            resource: 'JOB CARD',
            action: 'manage'
        },
    },
    {
        path: '/add-job-card',
        name: 'add-job-card',
        component: () => import('@/views/production-planning/job-card/jobCardAdd.vue'),
        meta: {
            pageTitle: 'Job Card Add',
            breadcrumb: [
                {
                    text: 'Job Card List',
                    to: {name: 'Job-card'},
                },
                {
                    text: 'Job Card Add',
                    active: true,
                },
            ],
            resource: 'JOB CARD',
            action: 'manage'
        },
    },
    {
        path: '/edit-job-card/:id',
        name: 'edit-job-card',
        component: () => import('@/views/production-planning/job-card/jobCardEdit.vue'),
        meta: {
            pageTitle: 'Edit Job Card',
            breadcrumb: [
                {
                    text: 'Job Card List',
                    to: {name: 'Job-card'},
                },
                {
                    text: 'Edit Job Card',
                    active: true,
                },
            ],
            resource: 'JOB CARD',
            action: 'manage'
        },
    },

    {
        path: '/work-order-item-requisition',
        name: 'work-order-item-requisition',
        component: () => import('@/views/production-planning/work-order-item-requisition/workOrderItemRequisitionList.vue'),
        meta: {
            pageTitle: 'Item Requisition',
            breadcrumb: [
                {
                    text: 'Item Requisition',
                    active: true
                },
            ],
            resource: 'ITEM REQUISITION',
            action: 'manage'
        },
    },
    {
        path: '/work-order-item-requisition/add',
        name: 'add-work-order-item-requisition',
        component: () => import('@/views/production-planning/work-order-item-requisition/workOrderItemRequisitionAdd.vue'),
        meta: {
            pageTitle: 'Add Item Requisition',
            breadcrumb: [
                {
                    text: 'Item Requisition',
                    to: {name: 'work-order-item-requisition'}
                },
                {
                    text: 'Add Item Requisition',
                    active: true
                },
            ],
            resource: 'ITEM REQUISITION',
            action: 'manage'
        },
    },
    {
        path: '/work-order-item-requisition/edit/:id',
        name: 'edit-work-order-item-requisition',
        component: () => import('@/views/production-planning/work-order-item-requisition/workOrderItemRequisitionEdit.vue'),
        meta: {
            pageTitle: 'Edit Item Requisition',
            breadcrumb: [
                {
                    text: 'Item Requisition',
                    to: {name: 'work-order-item-requisition'}
                },
                {
                    text: 'Edit Item Requisition',
                    active: true
                },
            ],
            resource: 'ITEM REQUISITION',
            action: 'manage'
        },
    },
    {
        path: '/job-card-material-return',
        name: 'job-card-material-return',
        component: () => import('@/views/production-planning/job-card-material-return/jobCardMaterialReturnList.vue'),
        meta: {
            pageTitle: 'Job Card Material Return',
            breadcrumb: [
                {
                    text: 'Job Card Material Return',
                    active: true
                },
            ],
            resource: 'JOB CARD MATERIAL RETURN FROM SHOP',
            action: 'manage'
        },
    },
    {
        path: '/job-card-material-return/add',
        name: 'add-job-card-material-return',
        component: () => import('@/views/production-planning/job-card-material-return/jobCardMaterialReturnAdd.vue'),
        meta: {
            pageTitle: 'Job Card Material Return',
            breadcrumb: [
                {
                    text: 'Job Card Material Return',
                    to: {name: 'job-card-material-return'}
                },
                {
                    text: 'Add Job Card Material Return',
                    active: true
                },
            ],
            resource: 'JOB CARD MATERIAL RETURN FROM SHOP',
            action: 'manage'
        },
    },
    {
        path: '/job-card-material-return/edit/:id',
        name: 'edit-job-card-material-return',
        component: () => import('@/views/production-planning/job-card-material-return/jobCardMaterialReturnEdit.vue'),
        meta: {
            pageTitle: 'Edit Job Card Material Return',
            breadcrumb: [
                {
                    text: 'Job Card Material Return',
                    to: {name: 'job-card-material-return'}
                },
                {
                    text: 'Edit Job Card Material Return',
                    active: true
                },
            ],
            resource: 'JOB CARD MATERIAL RETURN FROM SHOP',
            action: 'manage'
        },
    },
    {
        path: '/generate-wo-against-so',
        name: 'generate-wo-against-so',
        component: () => import('@/views/production-planning/generate-wo-against-so/generateWoAgainstSoAdd.vue'),
        meta: {
            pageTitle: 'Generate WO Against SO',
            breadcrumb: [
                {
                    text: 'Generate WO Against SO',
                    active: true
                },
            ],
            resource: 'GENERATE WO AGAINST SO',
            action: 'manage'
        },
    },
]
