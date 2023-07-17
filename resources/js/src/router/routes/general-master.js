export default [
    {
        path: '/general-master/uom-list',
        name: 'uom-list',
        component: () => import('@/views/general-master/uom/UomMasterList.vue'),
        meta: {
            pageTitle: 'UOM List',
            breadcrumb: [
                {
                    text: 'UOM Master',
                    active: true,
                },
            ],
            resource: 'UOM MASTER',
            action: 'manage'
        },
    },
    {
        path: '/general-master/test-certificate-types',
        name: 'test-certificate-types-list',
        component: () => import('@/views/general-master/test-certificate-types/testCertificateTypeMasterList.vue'),
        meta: {
            pageTitle: 'Test Certificate Types',
            breadcrumb: [
                {
                    text: 'Test Certificate Types',
                    active: true,
                },
            ],
            resource: 'TEST CERTIFICATE TYPE',
            action: 'manage'
        },
    },
    {
        path: '/general-master/party-type',
        name: 'party-type-list',
        component: () => import('@/views/general-master/party-type-master/partyTypeMasterList.vue'),
        meta: {
            pageTitle: 'Party Types',
            breadcrumb: [
                {
                    text: 'Party Types',
                    active: true,
                },
            ],
            resource: 'PARTY TYPE',
            action: 'manage'
        },
    },
    {
        path: '/general-master/business-type',
        name: 'business-type-list',
        component: () => import('@/views/general-master/business-type-master/businessTypeMasterList.vue'),
        meta: {
            pageTitle: 'Business Types',
            breadcrumb: [
                {
                    text: 'Business Types',
                    active: true,
                },
            ],
            resource: 'BUSINESS TYPE MASTER',
            action: 'manage'
        },
    },
    {
        path: '/general-master/currency-master',
        name: 'currency-list',
        component: () => import('@/views/general-master/currency-master/currencyMasterList.vue'),
        meta: {
            pageTitle: 'Currency',
            breadcrumb: [
                {
                    text: 'Currency',
                    active: true,
                },
            ],
            resource: 'CURRENCY MASTER',
            action: 'manage'
        },
    },
    {
        path: '/general-master/department-master',
        name: 'department-list',
        component: () => import('@/views/general-master/department-master/departmentMasterList.vue'),
        meta: {
            pageTitle: 'Department',
            breadcrumb: [
                {
                    text: 'Department',
                    active: true,
                },
            ],
            resource: 'DEPARTMENT',
            action: 'manage'
        },
    },
    {
        path: '/general-master/designation-master',
        name: 'designation-list',
        component: () => import('@/views/general-master/designation-master/designationMasterList.vue'),
        meta: {
            pageTitle: 'Designation',
            breadcrumb: [
                {
                    text: 'Designation',
                    active: true,
                },
            ],
            resource: 'DESIGNATION',
            action: 'manage'
        },
    },
    {
        path: '/general-master/country-master',
        name: 'country-list',
        component: () => import('@/views/general-master/country-master/countryMasterList.vue'),
        meta: {
            pageTitle: 'Country',
            breadcrumb: [
                {
                    text: 'Country',
                    active: true,
                },
            ],
            resource: 'COUNTRY MASTER',
            action: 'manage'
        },
    },
    {
        path: '/general-master/state-master',
        name: 'state-list',
        component: () => import('@/views/general-master/state-master/stateMasterList.vue'),
        meta: {
            pageTitle: 'State',
            breadcrumb: [
                {
                    text: 'State',
                    active: true,
                },
            ],
            resource: 'STATE MASTER',
            action: 'manage'
        },
    },
    {
        path: '/general-master/city-master',
        name: 'city-list',
        component: () => import('@/views/general-master/city-master/cityMasterList.vue'),
        meta: {
            pageTitle: 'District',
            breadcrumb: [
                {
                    text: 'District',
                    active: true,
                },
            ],
            resource: 'CITY MASTER',
            action: 'manage'
        },
    },
    {
        path: '/general-master/item-make-list',
        name: 'item-make-list',
        component: () => import('@/views/general-master/item-make/ItemMakeList'),
        meta: {
            pageTitle: 'Item Make List',
            breadcrumb: [
                {
                    text: 'Item Make Master',
                    active: true,
                },
            ],
            resource: 'ITEM MAKE MASTER',
            action: 'manage'
        },
    },
    {
        path: '/general-master/enquiry-reference-master',
        name: 'enquiry-reference-master',
        component: () => import('@/views/general-master/enquiry-reference-master/enquiryReferenceMasterList'),
        meta: {
            pageTitle: 'Enquiry Reference Master',
            breadcrumb: [
                {
                    text: 'Enquiry Reference Master',
                    active: true,
                },
            ],
            resource: 'ENQUIRY REFERENCE MASTER',
            action: 'manage'
        },
    },
    {
        path: '/general-master/quotation-type',
        name: 'quotation-type',
        component: () => import('@/views/general-master/quotation-type/quotationTypeList'),
        meta: {
            pageTitle: 'Quotation Type',
            breadcrumb: [
                {
                    text: 'Quotation Type',
                    active: true,
                },
            ],
            resource: 'QUOTATION TYPE',
            action: 'manage'
        },
    },
    {
        path: '/general-master/sales-lead-stage-master',
        name: 'sales-lead-stage-master',
        component: () => import('@/views/general-master/lead-stage-master/leadStageMasterList'),
        meta: {
            pageTitle: 'Sales Lead Stage Master',
            breadcrumb: [
                {
                    text: 'Sales Lead Stage Master',
                    active: true,
                },
            ],
            resource: 'SALES STAGE TITLE MASTER',
            action: 'manage'
        },
    },
    {
        path: '/general-master/sales-lead-title-master',
        name: 'sales-lead-title-master',
        component: () => import('@/views/general-master/lead-title-master/leadTitleMasterList'),
        meta: {
            pageTitle: 'Sales Lead Title Master',
            breadcrumb: [
                {
                    text: 'Sales Lead Title Master',
                    active: true,
                },
            ],
            resource: 'SALES LEAD TITLE MASTER',
            action: 'manage'
        },
    },
    {
        path: '/general-master/industries-type-master',
        name: 'industries-type-master',
        component: () => import('@/views/general-master/industries-type-master/industriesTypeMasterList'),
        meta: {
            pageTitle: 'Industries Type Master',
            breadcrumb: [
                {
                    text: 'Industries Type Master',
                    active: true,
                },
            ],
            resource: 'INDUSTRIES TYPE MASTER',
            action: 'manage'
        },
    },
    {
        path: '/general-master/reason-master',
        name: 'reason-master',
        component: () => import('@/views/general-master/reason-master/reasonMasterList'),
        meta: {
            pageTitle: 'Reason Master',
            breadcrumb: [
                {
                    text: 'Reason Master',
                    active: true,
                },
            ],
            resource: 'REASON MASTER',
            action: 'manage'
        },
    },
    {
        path: '/general-master/purchase-type',
        name: 'purchase-type',
        component: () => import('@/views/general-master/purchase-type/purchaseTypeList'),
        meta: {
            pageTitle: 'Purchase Type',
            breadcrumb: [
                {
                    text: 'Purchase Type',
                    active: true,
                },
            ],
            resource: 'PURCHASE TYPE',
            action: 'manage'
        },
    },
    {
        path: '/general-master/document-header',
        name: 'document-header',
        component: () => import('@/views/general-master/document-header/documentHeaderList'),
        meta: {
            pageTitle: 'Document Header',
            breadcrumb: [
                {
                    text: 'Document Header',
                    active: true,
                },
            ],
            resource: 'DOCUMENT HEADER',
            action: 'manage'
        },
    },
    {
        path: '/general-master/document-footer',
        name: 'document-footer',
        component: () => import('@/views/general-master/document-footer/documentFooterList'),
        meta: {
            pageTitle: 'Document Footer',
            breadcrumb: [
                {
                    text: 'Document Footer',
                    active: true,
                },
            ],
            resource: 'DOCUMENT FOOTER',
            action: 'manage'
        },
    },
    {
        path: '/general-master/store-master',
        name: 'store-master',
        component: () => import('@/views/general-master/store-master/storeMasterList'),
        meta: {
            pageTitle: 'Store Master',
            breadcrumb: [
                {
                    text: 'Store Master',
                    active: true,
                },
            ],
            resource: 'STORE MASTER',
            action: 'manage'
        },
    },
    {
        path: '/general-master/note-master',
        name: 'note-master',
        component: () => import('@/views/general-master/note-master/noteMasterList'),
        meta: {
            pageTitle: 'Note Master',
            breadcrumb: [
                {
                    text: 'Note Master',
                    active: true,
                },
            ],
            resource: 'NOTE MASTER',
            action: 'manage'
        },
    },
    {
        path: '/general-master/machine-master',
        name: 'machine-master',
        component: () => import('@/views/general-master/machine-master/machineMasterList'),
        meta: {
            pageTitle: 'Machine Master',
            breadcrumb: [
                {
                    text: 'Machine Master',
                    active: true,
                },
            ],
            resource: 'MACHINE MASTER',
            action: 'manage'
        },
    },
    {
        path: '/general-master/process-master',
        name: 'process-master',
        component: () => import('@/views/general-master/process-master/processMasterList'),
        meta: {
            pageTitle: 'Process Master',
            breadcrumb: [
                {
                    text: 'Process Master',
                    active: true,
                },
            ],
            resource: 'PROCESS MASTER',
            action: 'manage'
        },
    },
    {
        path: '/general-master/operator-master',
        name: 'operator-master',
        component: () => import('@/views/general-master/operator-master/operatorMasterList'),
        meta: {
            pageTitle: 'Operator Master',
            breadcrumb: [
                {
                    text: 'Operator Master',
                    active: true,
                },
            ],
            resource: 'OPERATOR MASTER',
            action: 'manage'
        },
    },
    {
        path: '/general-master/packing-master',
        name: 'packing-master',
        component: () => import('@/views/general-master/packing-master/packingMasterList'),
        meta: {
            pageTitle: 'Packing Master',
            breadcrumb: [
                {
                    text: 'Packing Master',
                    active: true,
                },
            ],
            resource: 'PACKING MASTER',
            action: 'manage'
        },
    },
    {
        path: '/general-master/payment-deduction-master',
        name: 'payment-deduction-master',
        component: () => import('@/views/general-master/payment-deduction-master/deductionMasterList'),
        meta: {
            pageTitle: 'Payment Deduction Master',
            breadcrumb: [
                {
                    text: 'Payment Deduction Master',
                    active: true,
                },
            ],
            resource: 'PAYMENT DEDUCTION MASTER',
            action: 'manage'
        },
    },
    {
        path: '/general-master/expense-master',
        name: 'expense-master',
        component: () => import('@/views/general-master/expense-master/expenseMasterList'),
        meta: {
            pageTitle: 'Expense Master',
            breadcrumb: [
                {
                    text: 'Expense Master',
                    active: true,
                },
            ],
            resource: 'EXPENSE MASTER',
            action: 'manage'
        },
    },
    {
        path: '/general-master/document-type-master',
        name: 'document-type-master',
        component: () => import('@/views/general-master/document-type-master/documentTypeMasterList'),
        meta: {
            pageTitle: 'Document Type Master',
            breadcrumb: [
                {
                    text: 'Document Type Master',
                    active: true,
                },
            ],
            resource: 'DOCUMENT TYPE MASTER',
            action: 'manage'
        },
    },
    {
        path: '/general-master/bank-master',
        name: 'bank-master',
        component: () => import('@/views/general-master/bank-master/bankMasterList'),
        meta: {
            pageTitle: 'Bank Master',
            breadcrumb: [
                {
                    text: 'Bank Master',
                    active: true,
                },
            ],
            resource: 'BANK MASTER',
            action: 'manage'
        },
    },
    {
        path: '/branch-master/branch-master',
        name: 'branch-master',
        component: () => import('@/views/general-master/branch-master/branchMasterList'),
        meta: {
            pageTitle: 'Branch Master',
            breadcrumb: [
                {
                    text: 'Branch Master',
                    active: true,
                },
            ],
            resource: 'BRANCH MASTER',
            action: 'manage'
        },
    },
]
