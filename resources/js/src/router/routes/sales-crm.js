export default [
    {
        path: '/sales-crm/sales-enquiry/',
        name: 'sales-enquiry',
        component: () => import('@/views/sales-crm/sales-enquiry/salesEnquiryList.vue'),
        meta: {
            pageTitle: 'Sales Enquiry',
            breadcrumb: [
                {
                    text: 'Sales Enquiry',
                    active: true,
                },
            ],
            resource: 'SALES ENQUIRY',
            action: 'manage'
        },
    },
    {
        path: '/sales-crm/add-sales-enquiry',
        name: 'add-sales-enquiry',
        component: () => import('@/views/sales-crm/sales-enquiry/addSalesEnquiry.vue'),
        meta: {
            pageTitle: 'Add Sales Enquiry',
            breadcrumb: [
                {
                    text: 'Sales Enquiry',
                    to: { name: 'sales-enquiry' },
                },
                {
                    text: 'Add Sales Enquiry',
                    active: true,
                },
            ],
            resource: 'SALES ENQUIRY',
            action: 'manage'
        },
    },
    {
        path: '/sales-crm/edit-sales-enquiry/:id',
        name: 'edit-sales-enquiry',
        component: () => import('@/views/sales-crm/sales-enquiry/editSalesEnquiry.vue'),
        meta: {
            pageTitle: 'Edit Sales Enquiry',
            breadcrumb: [
                {
                    text: 'Sales Enquiry',
                    to: { name: 'sales-enquiry' },
                },
                {
                    text: 'Edit Sales Enquiry',
                    active: true,
                },
            ],
            resource: 'SALES ENQUIRY',
            action: 'manage'
        },
    },
    {
        path: '/sales-crm/sales-quotation/',
        name: 'sales-quotation',
        component: () => import('@/views/sales-crm/sales-quotation/salesQuotationList.vue'),
        meta: {
            pageTitle: 'Sales Quotation',
            breadcrumb: [
                {
                    text: 'Sales Quotation',
                    active: true,
                },
            ],
            resource: 'SALES QUOTATION',
            action: 'manage'
        },
    },
    {
        path: '/sales-crm/add-sales-quotation',
        name: 'add-sales-quotation',
        component: () => import('@/views/sales-crm/sales-quotation/addSalesQuotation.vue'),
        meta: {
            pageTitle: 'Add Sales Quotation',
            breadcrumb: [
                {
                    text: 'Sales Quotation',
                    to: { name: 'sales-quotation' },
                },
                {
                    text: 'Add Sales Quotation',
                    active: true,
                },
            ],
            resource: 'SALES QUOTATION',
            action: 'manage'
        },
    },
    {
        path: '/sales-crm/edit-sales-quotation/:id',
        name: 'edit-sales-quotation',
        component: () => import('@/views/sales-crm/sales-quotation/editSalesQuotation.vue'),
        meta: {
            pageTitle: 'Edit Sales Quotation',
            breadcrumb: [
                {
                    text: 'Sales Quotation',
                    to: { name: 'sales-quotation' },
                },
                {
                    text: 'Edit Sales Quotation',
                    active: true,
                },
            ],
            resource: 'SALES QUOTATION',
            action: 'manage'
        },
    },
    {
        path: '/sales-crm/approve-sales-quotation',
        name: 'approve-sales-quotation',
        component: () => import('@/views/sales-crm/approve-sales-quotation/listSalesQuotation.vue'),
        meta: {
            pageTitle: 'Sales Quotation List',
            breadcrumb: [
                {
                    text: 'Approve Sales Quotation',
                    to: { name: 'approve-sales-quotation' },
                },
            ],
            resource: 'SALES QUOTATION APPROVAL',
            action: 'manage'
        },
    },
    {
        path: '/sales-crm/approve-sales-quotation/:id',
        name: 'view-sales-quotation',
        component: () => import('@/views/sales-crm/approve-sales-quotation/viewSalesQuotation.vue'),
        meta: {
            pageTitle: 'Sales Quotation',
            breadcrumb: [
                {
                    text: 'Sales Quotation List',
                    to: { name: 'approve-sales-quotation' },
                },
                {
                    text: 'View Sales Quotation',
                    active: true,
                },
            ],
            resource: 'SALES QUOTATION APPROVAL',
            action: 'manage'
        },
    },
    {
        path: '/sales-crm/sales-order/',
        name: 'sales-order',
        component: () => import('@/views/sales-crm/sales-order/salesOrderList.vue'),
        meta: {
            pageTitle: 'Sales Order',
            breadcrumb: [
                {
                    text: 'Sales Order',
                    active: true,
                },
            ],
            resource: 'SALES ORDER',
            action: 'manage'
        },
    },
    {
        path: '/sales-crm/add-sales-order',
        name: 'add-sales-order',
        component: () => import('@/views/sales-crm/sales-order/addSalesOrder.vue'),
        meta: {
            pageTitle: 'Add Sales Order',
            breadcrumb: [
                {
                    text: 'Sales Order',
                    to: { name: 'sales-order' },
                },
                {
                    text: 'Add Sales Order',
                    active: true,
                },
            ],
            resource: 'SALES ORDER',
            action: 'manage'
        },
    },
    {
        path: '/sales-crm/edit-sales-order/:id',
        name: 'edit-sales-order',
        component: () => import('@/views/sales-crm/sales-order/editSalesOrder.vue'),
        meta: {
            pageTitle: 'Edit Sales Order',
            breadcrumb: [
                {
                    text: 'Sales Order',
                    to: { name: 'sales-order' },
                },
                {
                    text: 'Edit Sales Order',
                    active: true,
                },
            ],
            resource: 'SALES ORDER',
            action: 'manage'
        },
    },
    {
        path: '/sales-crm/proforma-invoices/',
        name: 'proforma-invoices',
        component: () => import('@/views/sales-crm/proforma-invoices/proformaInvoiceList.vue'),
        meta: {
            pageTitle: 'Proforma Invoice',
            breadcrumb: [
                {
                    text: 'Proforma Invoice',
                    active: true,
                },
            ],
            resource: 'PROFORMA INVOICE',
            action: 'manage'
        },
    },
    {
        path: '/sales-crm/add-proforma-invoices',
        name: 'add-proforma-invoices',
        component: () => import('@/views/sales-crm/proforma-invoices/addProformaInvoice.vue'),
        meta: {
            pageTitle: 'Add Proforma Invoice',
            breadcrumb: [
                {
                    text: 'Proforma Invoice',
                    to: { name: 'proforma-invoices' },
                },
                {
                    text: 'Add Proforma Invoice',
                    active: true,
                },
            ],
            resource: 'PROFORMA INVOICE',
            action: 'manage'
        },
    },
    {
        path: '/sales-crm/edit-proforma-invoices/:id',
        name: 'edit-proforma-invoices',
        component: () => import('@/views/sales-crm/proforma-invoices/editProformaInvoice.vue'),
        meta: {
            pageTitle: 'Edit Proforma Invoice',
            breadcrumb: [
                {
                    text: 'Proforma Invoice',
                    to: { name: 'proforma-invoices' },
                },
                {
                    text: 'Edit Proforma Invoice',
                    active: true,
                },
            ],
            resource: 'PROFORMA INVOICE',
            action: 'manage'
        },
    },
    {
        path: '/sales-crm/sales-return/',
        name: 'sales-return',
        component: () => import('@/views/sales-crm/sales-return/salesReturnList.vue'),
        meta: {
            pageTitle: 'Sales Return',
            breadcrumb: [
                {
                    text: 'Sales Return',
                    active: true,
                },
            ],
            resource: 'SALES RETURN - CREDIT NOTE',
            action: 'manage'
        },
    },
    {
        path: '/sales-crm/add-sales-return',
        name: 'add-sales-return',
        component: () => import('@/views/sales-crm/sales-return/addSalesReturn.vue'),
        meta: {
            pageTitle: 'Add Sales Return',
            breadcrumb: [
                {
                    text: 'Sales Return',
                    to: { name: 'sales-return' },
                },
                {
                    text: 'Add Sales Return',
                    active: true,
                },
            ],
            resource: 'SALES RETURN - CREDIT NOTE',
            action: 'manage'
        },
    },
    {
        path: '/sales-crm/edit-sales-return/:id',
        name: 'edit-sales-return',
        component: () => import('@/views/sales-crm/sales-return/editSalesReturn.vue'),
        meta: {
            pageTitle: 'Edit Sales Return',
            breadcrumb: [
                {
                    text: 'Sales Return',
                    to: { name: 'sales-return' },
                },
                {
                    text: 'Edit Sales Return',
                    active: true,
                },
            ],
            resource: 'SALES RETURN - CREDIT NOTE',
            action: 'manage'
        },
    },
    {
        path: '/sales-crm/sales-enquiry-list-report/',
        name: 'sales-enquiry-list-report',
        component: () => import('@/views/sales-crm/sales-enquiry-list-report/salesEnquiryListReport.vue'),
        meta: {
            pageTitle: 'List of Enquiry',
            breadcrumb: [
                {
                    text: 'List of Enquiry',
                    active: true,
                },
            ],
            resource: 'SALES REPORTS',
            action: 'manage'
        },
    },
    {
        path: '/sales-crm/sales-enquiry-filter-list/',
        name: 'sales-enquiry-filter-list',
        component: () => import('@/views/sales-crm/sales-enquiry-list-report/salesEnquiryFilters.vue'),
        meta: {
            pageTitle: 'List of Enquiry',
            breadcrumb: [
                {
                    text: 'List of Enquiry',
                    active: true,
                },
            ],
            resource: 'SALES REPORTS',
            action: 'manage'
        },
    },
    {
        path: '/sales-crm/sales-quotation-list-report/',
        name: 'sales-quotation-list-report',
        component: () => import('@/views/sales-crm/sales-quotation-list-report/salesQuotationListReport.vue'),
        meta: {
            pageTitle: 'List of Quotation',
            breadcrumb: [
                {
                    text: 'Sales Quotation List',
                    active: true,
                },
            ],
            resource: 'SALES REPORTS',
            action: 'manage'
        },
    },
    {
        path: '/sales-crm/sales-quotation-filter-list-report/',
        name: 'sales-quotation-filter-list-report',
        component: () => import('@/views/sales-crm/sales-quotation-list-report/salesQuotationFilters.vue'),
        meta: {
            pageTitle: 'List of Quotation',
            breadcrumb: [
                {
                    text: 'Sales Quotation List',
                    active: true,
                },
            ],
            resource: 'SALES REPORTS',
            action: 'manage'
        },
    },
    {
        path: '/sales-crm/sales-order-list-report/',
        name: 'sales-order-list-report',
        component: () => import('@/views/sales-crm/sales-order-list-report/salesOrderListReport.vue'),
        meta: {
            pageTitle: 'List of Sales Order',
            breadcrumb: [
                {
                    text: 'List of Sales Order',
                    active: true,
                },
            ],
            resource: 'SALES REPORTS',
            action: 'manage'
        },
    },
    {
        path: '/sales-crm/proforma-invoice-summary-report/',
        name: 'proforma-invoice-summary-report',
        component: () => import('@/views/sales-crm/proforma-invoice-summary-report/PiSummaryReport.vue'),
        meta: {
            pageTitle: 'Proforma invoice summary',
            breadcrumb: [
                {
                    text: 'Proforma invoice summary',
                    active: true,
                },
            ],
            resource: 'SALES REPORTS',
            action: 'manage'
        },
    },
    {
        path: '/sales-crm/sales-return-summary-report/',
        name: 'sales-return-summary-report',
        component: () => import('@/views/sales-crm/sales-return-summary-report/salesReturnSummaryReport.vue'),
        meta: {
            pageTitle: 'Sales return Summary',
            breadcrumb: [
                {
                    text: 'Sales return Summary',
                    active: true,
                },
            ],
            resource: 'SALES REPORTS',
            action: 'manage'
        },
    },
]
