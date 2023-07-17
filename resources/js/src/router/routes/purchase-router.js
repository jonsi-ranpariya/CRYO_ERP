export default [
    {
        path: '/purchase-enquiry',
        name: 'purchase-enquiry',
        component: () => import('@/views/purchase/purchase-enquiry/purchaseEnquiryList.vue'),
        meta: {
            pageTitle: 'Purchase Enquiry List',
            breadcrumb: [
                {
                    text: 'Purchase Enquiry List',
                    active: true,
                },
            ],
            resource: 'PURCHASE ENQUIRY',
            action: 'manage'
        },
    },
    {
        path: '/add-purchase-enquiry',
        name: 'add-purchase-enquiry',
        component: () => import('@/views/purchase/purchase-enquiry/purchaseEnquiryAdd.vue'),
        meta: {
            pageTitle: 'Purchase Enquiry List',
            breadcrumb: [
                {
                    text: 'Purchase Enquiry List',
                    to: {name: 'purchase-enquiry'},
                },
                {
                    text: 'Add',
                    active: true,
                },
            ],
            resource: 'PURCHASE ENQUIRY',
            action: 'manage'
        },
    },
    {
        path: '/edit-purchase-enquiry/:id',
        name: 'edit-purchase-enquiry',
        component: () => import('@/views/purchase/purchase-enquiry/purchaseEnquiryEdit.vue'),
        meta: {
            pageTitle: 'Purchase Enquiry List',
            breadcrumb: [
                {
                    text: 'Purchase Enquiry List',
                    to: {name: 'purchase-enquiry'},
                },
                {
                    text: 'Edit',
                    active: true,
                },
            ],
            resource: 'PURCHASE ENQUIRY',
            action: 'manage'
        },
    },
    {
        path: '/purchase-quotation',
        name: 'purchase-quotation',
        component: () => import('@/views/purchase/purchase-quotation/purchaseQuotationList.vue'),
        meta: {
            pageTitle: 'Purchase Quotation',
            breadcrumb: [
                {
                    text: 'Purchase Quotation',
                    active: true,
                },
            ],
            resource: 'PURCHASE QUOTATION',
            action: 'manage'
        },
    },
    {
        path: '/add-purchase-quotation',
        name: 'add-purchase-quotation',
        component: () => import('@/views/purchase/purchase-quotation/purchaseQuotationAdd.vue'),
        meta: {
            pageTitle: 'Purchase Quotation',
            breadcrumb: [
                {
                    text: 'Purchase Quotation',
                    to: {name: 'purchase-quotation'},
                },
                {
                    text: 'Add',
                    active: true,
                },
            ],
            resource: 'PURCHASE QUOTATION',
            action: 'manage'
        },
    },
    {
        path: '/edit-purchase-quotation/:id',
        name: 'edit-purchase-quotation',
        component: () => import('@/views/purchase/purchase-quotation/purchaseQuotationEdit.vue'),
        meta: {
            pageTitle: 'Purchase Quotation',
            breadcrumb: [
                {
                    text: 'Purchase Quotation',
                    to: {name: 'purchase-quotation'},
                },
                {
                    text: 'Edit',
                    active: true,
                },
            ],
            resource: 'PURCHASE QUOTATION',
            action: 'manage'
        },
    },
    {
        path: '/purchase-order',
        name: 'purchase-order',
        component: () => import('@/views/purchase/purchase-order/purchaseOrderList.vue'),
        meta: {
            pageTitle: 'Purchase Order',
            breadcrumb: [
                {
                    text: 'Purchase Order',
                    active: true,
                },
            ],
            resource: 'PURCHASE ORDER',
            action: 'manage'
        },
    },
    {
        path: '/add-purchase-order',
        name: 'add-purchase-order',
        component: () => import('@/views/purchase/purchase-order/purchaseOrderAdd.vue'),
        meta: {
            pageTitle: 'Purchase order',
            breadcrumb: [
                {
                    text: 'Purchase order',
                    to: {name: 'purchase-order'},
                },
                {
                    text: 'Add',
                    active: true,
                },
            ],
            resource: 'PURCHASE ORDER',
            action: 'manage'
        },
    },
    {
        path: '/edit-purchase-order/:id',
        name: 'edit-purchase-order',
        component: () => import('@/views/purchase/purchase-order/purchaseOrderEdit.vue'),
        meta: {
            pageTitle: 'Purchase Order',
            breadcrumb: [
                {
                    text: 'Purchase Order',
                    to: {name: 'purchase-order'},
                },
                {
                    text: 'Edit',
                    active: true,
                },
            ],
            resource: 'PURCHASE ORDER',
            action: 'manage'
        },
    },
    {
        path: '/purchase-costing',
        name: 'purchase-costing',
        component: () => import('@/views/purchase/purchase-costing/purchaseCostingList.vue'),
        meta: {
            pageTitle: 'Purchase Costing',
            breadcrumb: [
                {
                    text: 'Purchase Costing',
                    active: true,
                },
            ],
            resource: 'PURCHASE COSTING',
            action: 'manage'
        },
    },
    {
        path: '/add-purchase-costing',
        name: 'add-purchase-costing',
        component: () => import('@/views/purchase/purchase-costing/purchaseCostingAdd.vue'),
        meta: {
            pageTitle: 'Purchase costing',
            breadcrumb: [
                {
                    text: 'Purchase costing',
                    to: {name: 'purchase-costing'},
                },
                {
                    text: 'Add',
                    active: true,
                },
            ],
            resource: 'PURCHASE COSTING',
            action: 'manage'
        },
    },
    {
        path: '/edit-purchase-costing/:id',
        name: 'edit-purchase-costing',
        component: () => import('@/views/purchase/purchase-costing/purchaseCostingEdit.vue'),
        meta: {
            pageTitle: 'Purchase Costing',
            breadcrumb: [
                {
                    text: 'Purchase Costing',
                    to: {name: 'purchase-costing'},
                },
                {
                    text: 'Edit',
                    active: true,
                },
            ],
            resource: 'PURCHASE COSTING',
            action: 'manage'
        },
    },
    {
        path: '/purchase-return',
        name: 'purchase-return',
        component: () => import('@/views/purchase/purchase-return/purchaseReturnList.vue'),
        meta: {
            pageTitle: 'Purchase Return',
            breadcrumb: [
                {
                    text: 'Purchase Return',
                    active: true,
                },
            ],
            resource: 'PURCHASE RETURN - DEBIT NOTE',
            action: 'manage'
        },
    },
    {
        path: '/add-purchase-return',
        name: 'add-purchase-return',
        component: () => import('@/views/purchase/purchase-return/purchaseReturnAdd.vue'),
        meta: {
            pageTitle: 'Purchase Return',
            breadcrumb: [
                {
                    text: 'Purchase Return',
                    to: {name: 'purchase-return'},
                },
                {
                    text: 'Add',
                    active: true,
                },
            ],
            resource: 'PURCHASE RETURN - DEBIT NOTE',
            action: 'manage'
        },
    },
    {
        path: '/edit-purchase-return/:id',
        name: 'edit-purchase-return',
        component: () => import('@/views/purchase/purchase-return/purchaseReturnEdit.vue'),
        meta: {
            pageTitle: 'Purchase Return',
            breadcrumb: [
                {
                    text: 'Purchase Return',
                    to: {name: 'purchase-return'},
                },
                {
                    text: 'Edit',
                    active: true,
                },
            ],
            resource: 'PURCHASE RETURN - DEBIT NOTE',
            action: 'manage'
        },
    },
    {
        path: '/item-rate-master',
        name: 'item-rate-master',
        component: () => import('@/views/purchase/item-rate-master/itemRateMasterList.vue'),
        meta: {
            pageTitle: 'Item Rate Master',
            breadcrumb: [
                {
                    text: 'Item Rate Master',
                    active: true,
                },
            ],
            resource: 'ITEM RATE MASTER (PURCHASE)',
            action: 'manage'
        },
    },
    {
        path: '/add-item-rate-master',
        name: 'add-item-rate-master',
        component: () => import('@/views/purchase/item-rate-master/itemRateMasterAdd.vue'),
        meta: {
            pageTitle: 'Item Rate Master',
            breadcrumb: [
                {
                    text: 'Item Rate Master',
                    to: {name: 'item-rate-master'},
                },
                {
                    text: 'Add',
                    active: true,
                },
            ],
            resource: 'ITEM RATE MASTER (PURCHASE)',
            action: 'manage'
        },
    },
    {
        path: '/edit-item-rate-master',
        name: 'edit-item-rate-master',
        component: () => import('@/views/purchase/item-rate-master/itemRateMasterEdit.vue'),
        meta: {
            pageTitle: 'Item Rate Master',
            breadcrumb: [
                {
                    text: 'Item Rate Master',
                    to: {name: 'item-rate-master'},
                },
                {
                    text: 'Edit',
                    active: true,
                },
            ],
            resource: 'ITEM RATE MASTER (PURCHASE)',
            action: 'manage'
        },
    },
]
