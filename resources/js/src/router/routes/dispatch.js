export default [
    {
        path: '/dispatch/challan-invoices',
        name: 'challan-invoices-list',
        component: () => import('@/views/dispatch/challan-invoices/ChallanInvoices.vue'),
        meta: {
            pageTitle: 'Invoice List',
            breadcrumb: [
                {
                    text: 'Invoices',
                    active: true,
                },

            ],
        },
    },
    {
        path: '/dispatch/add-challan-invoice',
        name: 'add-challan-invoice',
        component: () => import('@/views/dispatch/challan-invoices/AddChallanInvoices.vue'),
        meta: {
            pageTitle: 'Add New Invoice',
            breadcrumb: [
                {
                    text: 'Invoice List',
                    to: {name: 'challan-invoices-list'},
                },
                {
                    text: 'Add New Invoice',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/dispatch/edit-challan-invoices/:id',
        name: 'edit-challan-invoices',
        component: () => import('@/views/dispatch/challan-invoices/EditChallanInvoices.vue'),
        meta: {
            pageTitle: 'Edit Invoice Detail',
            breadcrumb: [
                {
                    text: 'Invoice List',
                    to: { name: 'challan-invoices-list' },
                },
                {
                    text: 'Edit Invoice Detail',
                    active: true,
                },
            ],
        },
    },

    {
        path: '/new-challan-invoices',
        name: 'new-challan-invoices',
        component: () => import('@/views/dispatch/new-challan-invoices/newChallanInvoiceList.vue'),
        meta: {
            pageTitle: 'New Challan Invoices',
            breadcrumb: [
                {
                    text: 'New Invoices',
                    active: true,
                },
            ],
            resource: 'GENERATE INVOICE',
            action: 'manage'
        },
    },
    {
        path: '/add-new-challan-invoice',
        name: 'add-new-challan-invoice',
        component: () => import('@/views/dispatch/new-challan-invoices/newChallanInvoiceAdd.vue'),
        meta: {
            pageTitle: 'New Challan Invoices',
            breadcrumb: [
                {
                    text: 'New Challan Invoices',
                    to: {name: 'new-challan-invoices'},
                },
                {
                    text: 'Add',
                    active: true,
                },
            ],
            resource: 'GENERATE INVOICE',
            action: 'manage'
        },
    },
    {
        path: '/edit-new-challan-invoice/:id',
        name: 'edit-new-challan-invoice',
        component: () => import('@/views/dispatch/new-challan-invoices/newChallanInvoiceEdit.vue'),
        meta: {
            pageTitle: 'New Challan Invoices',
            breadcrumb: [
                {
                    text: 'New Challan Invoices',
                    to: { name: 'new-challan-invoices' },
                },
                {
                    text: 'Edit',
                    active: true,
                },
            ],
            resource: 'GENERATE INVOICE',
            action: 'manage'
        },
    },
]
