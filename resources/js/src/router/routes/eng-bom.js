export default [
    {
        path: '/bom/bill-of-material',
        name: 'bill-of-material',
        component: () => import('@/views/bom/bill-of-material/billOfMaterialList.vue'),
        meta: {
            pageTitle: 'Bill Of Material',
            breadcrumb: [
                {
                    text: 'BOM',
                    active: true,
                },
            ],
            resource: 'BILL OF MATERIAL',
            action: 'manage'
        },
    },
    {
        path: '/bom/add-bill-of-material',
        name: 'add-bill-of-material',
        component: () => import('@/views/bom/bill-of-material/billOfMaterialAdd.vue'),
        meta: {
            pageTitle: 'Add BOM',
            breadcrumb: [
                {
                    text: 'BOM',
                    to: {name: 'bill-of-material'}
                },
                {
                    text: 'Add BOM',
                    active: true,
                },
            ],
            resource: 'BILL OF MATERIAL',
            action: 'manage'
        },
    },
    {
        path: '/bom/edit-bill-of-material/:id',
        name: 'edit-bill-of-material',
        component: () => import('@/views/bom/bill-of-material/billOfMaterialEdit.vue'),
        meta: {
            pageTitle: 'Edit BOM',
            breadcrumb: [
                {
                    text: 'BOM',
                    to: {name: 'bill-of-material'}
                },
                {
                    text: 'Edit BOM',
                    active: true,
                },
            ],
            resource: 'BILL OF MATERIAL',
            action: 'manage'
        },
    },
    {
        path: '/bom/bill-of-material/:id/:versionId/:versionItemId?',
        name: 'edit-bill-of-material-version',
        component: () => import('@/views/bom/bill-of-material/bomVersionAssemblyItems.vue'),
        meta: {
            pageTitle: 'Edit BOM Version',
            breadcrumb: [
                {
                    text: 'Bill Of Material',
                    to: {name: 'bill-of-material'}
                },
                {
                    text: 'Edit BOM',
                    to: {name: 'edit-bill-of-material'}
                },
                {
                    text: 'Edit BOM Version',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/bom/bill-of-material/:id/:versionId/:versionItemId',
        name: 'edit-bill-of-material-version-assembly',
        component: () => import('@/views/bom/bill-of-material/bomVersionAssemblyItems.vue'),
        meta: {
            pageTitle: 'Edit BOM Version',
            breadcrumb: [
                {
                    text: 'Edit BOM',
                    to: {name: 'edit-bill-of-material'}
                },
                {
                    text: 'Edit Bom Version',
                    to: {name: 'edit-bill-of-material-version'}
                },
                {
                    text: 'Edit BOM Assembly',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/bom/replace-item',
        name: 'replace-item',
        component: () => import('@/views/bom/replace-item/ReplaceItemList.vue'),
        meta: {
            pageTitle: 'Replace Item',
            breadcrumb: [
                {
                    text: 'Replace Item',
                    active: true,
                },
            ],
            resource: 'REPLACE ITEM IN BOM',
            action: 'manage'
        },
    },
    {
        path: '/bom/replace-sales-order',
        name: 'replace-sales-order',
        component: () => import('@/views/bom/replace-sales-order/ReplaceSalesOrderList.vue'),
        meta: {
            pageTitle: 'Replace Sales Order',
            breadcrumb: [
                {
                    text: 'Replace Sales Order',
                    active: true,
                },
            ],
            resource: 'REPLACE SALES ORDER ITEMS',
            action: 'manage'
        },
    },
    {
        path: '/bom/drawing-master',
        name: 'drawing-master',
        component: () => import('@/views/bom/drawing-master/DrawingMasterList.vue'),
        meta: {
            pageTitle: 'Drawing Master',
            breadcrumb: [
                {
                    text: 'Drawing Master',
                    active: true,
                },
            ],
            resource: 'DRAWING MASTER',
            action: 'manage'
        },
    },
    {
        path: '/bom/add-drawing-master',
        name: 'add-drawing-master',
        component: () => import('@/views/bom/drawing-master/addDrawingMaster.vue'),
        meta: {
            pageTitle: 'Add Drawing Master',
            breadcrumb: [
                {
                    text: 'Drawing Master',
                    to: {name: 'drawing-master'},
                },
                {
                    text: 'Add Drawing Master',
                    active: true,
                },
            ],
            resource: 'DRAWING MASTER',
            action: 'manage'
        },
    },
    {
        path: '/bom/edit-drawing-master/:id',
        name: 'edit-drawing-master',
        component: () => import('@/views/bom/drawing-master/editDrawingMaster.vue'),
        meta: {
            pageTitle: 'Edit Drawing Master',
            breadcrumb: [
                {
                    text: 'Drawing Master',
                    to: { name: 'drawing-master' },
                },
                {
                    text: 'Edit Drawing Master',
                    active: true,
                },
            ],
            resource: 'DRAWING MASTER',
            action: 'manage'
        },
    },
    {
        path: '/bom/bom-reports',
        name: 'bom-reports',
        component: () => import('@/views/bom/bom-reports/BomReportsList.vue'),
        meta: {
            pageTitle: 'BOM Reports',
            breadcrumb: [
                {
                    text: 'BOM Reports',
                    active: true,
                },
            ],
            resource: 'BOM REPORTS',
            action: 'manage'
        },
    },
]
