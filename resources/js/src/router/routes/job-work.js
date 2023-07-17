export default [
    {
        path: '/job-work-order',
        name: 'job-work-order',
        component: () => import('@/views/job-work/job-work-order/jobWorkOrderList.vue'),
        meta: {
            pageTitle: 'Job Work Order',
            breadcrumb: [
                {
                    text: 'Job Work Order',
                    active: true,
                },
            ],
            resource: 'JOB WORK ORDER',
            action: 'manage'
        },
    },
    {
        path: '/add-job-work-order',
        name: 'add-job-work-order',
        component: () => import('@/views/job-work/job-work-order/jobWorkOrderAdd.vue'),
        meta: {
            pageTitle: 'Job Work Order',
            breadcrumb: [
                {
                    text: 'Job Work Order',
                    to: {name: 'job-work-order'},
                },
                {
                    text: 'Add',
                    active: true,
                },
            ],
            resource: 'JOB WORK ORDER',
            action: 'manage'
        },
    },
    {
        path: '/edit-job-work-order/:id',
        name: 'edit-job-work-order',
        component: () => import('@/views/job-work/job-work-order/jobWorkOrderEdit.vue'),
        meta: {
            pageTitle: 'Job Work Order',
            breadcrumb: [
                {
                    text: 'Job Work Order',
                    to: {name: 'job-work-order'},
                },
                {
                    text: 'Edit',
                    active: true,
                },
            ],
            resource: 'JOB WORK ORDER',
            action: 'manage'
        },
    },
    {
        path: '/issue-job-work-challan',
        name: 'issue-job-work-challan',
        component: () => import('@/views/job-work/issue-job-work-challan/issueJobWorkChallanList.vue'),
        meta: {
            pageTitle: 'Issue Job Work Challan',
            breadcrumb: [
                {
                    text: 'Issue Job Work Challan',
                    active: true,
                },
            ],
            resource: 'ISSUE (JOB WORK CHALLAN)',
            action: 'manage'
        },
    },
    {
        path:'/add-issue-job-work-challan',
        name: 'add-issue-job-work-challan',
        component: () => import('@/views/job-work/issue-job-work-challan/issueJobWorkChallanAdd.vue'),
        meta: {
            pageTitle: 'Issue Job Work Challan',
            breadcrumb: [
                {
                    text: 'Issue Job Work Challan',
                    to: {name :'issue-job-work-challan'},
                },
                {
                    text: 'Add',
                    active: true,
                },
            ],
            resource: 'ISSUE (JOB WORK CHALLAN)',
            action: 'manage'
        },
    },
    {
        path: '/edit-issue-job-work-challan/:id',
        name: 'edit-issue-job-work-challan',
        component: () => import('@/views/job-work/issue-job-work-challan/issueJobWorkChallanEdit.vue'),
        meta: {
            pageTitle: 'Issue Job Work Challan',
            breadcrumb: [
                {
                    text: 'Issue Job Work Challan',
                    to: {name: 'issue-job-work-challan'},
                },
                {
                    text: 'Edit',
                    active: true,
                },
            ],
            resource: 'ISSUE (JOB WORK CHALLAN)',
            action: 'manage'
        },
    },
    {
        path: '/receipt-job-work-challan',
        name: 'receipt-job-work-challan',
        component: () => import('@/views/job-work/receipt-job-work-challan/receiptJobWorkChallanList.vue'),
        meta: {
            pageTitle: 'Receipt Job Work Challan',
            breadcrumb: [
                {
                    text: 'Receipt Job Work Challan',
                    active: true,
                },
            ],
            resource: 'RECEIPT (JOB WORK CHALLAN)',
            action: 'manage'
        },
    },
    {
        path:'/add-receipt-job-work-challan',
        name: 'add-receipt-job-work-challan',
        component: () => import('@/views/job-work/receipt-job-work-challan/receiptJobWorkChallanAdd.vue'),
        meta: {
            pageTitle: 'Receipt Job Work Challan',
            breadcrumb: [
                {
                    text: 'Receipt Job Work Challan',
                    to: {name :'receipt-job-work-challan'},
                },
                {
                    text: 'Add',
                    active: true,
                },
            ],
            resource: 'RECEIPT (JOB WORK CHALLAN)',
            action: 'manage'
        },
    },
    {
        path: '/edit-receipt-job-work-challan/:id',
        name: 'edit-receipt-job-work-challan',
        component: () => import('@/views/job-work/receipt-job-work-challan/receiptJobWorkChallanEdit.vue'),
        meta: {
            pageTitle: 'Receipt Job Work Challan',
            breadcrumb: [
                {
                    text: 'Receipt Job Work Challan',
                    to: {name :'receipt-job-work-challan'},
                },
                {
                    text: 'Edit',
                    active: true,
                },
            ],
            resource: 'RECEIPT (JOB WORK CHALLAN)',
            action: 'manage'
        },
    },
    {
        path: '/return-rejection-memo',
        name: 'return-rejection-memo',
        component: () => import('@/views/job-work/return-rejection-memo/returnRejectionMemoList.vue'),
        meta: {
            pageTitle: 'Return Rejection Memo',
            breadcrumb: [
                {
                    text: 'Return Rejection Memo',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/add-return-rejection-memo',
        name: 'add-return-rejection-memo',
        component: () => import('@/views/job-work/return-rejection-memo/returnRejectionMemoAdd.vue'),
        meta: {
            pageTitle: 'Return Rejection Memo',
            breadcrumb: [
                {
                    text: 'Return Rejection Memo',
                    to: {name :'return-rejection-memo'},
                },
                {
                    text: 'Add',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/edit-return-rejection-memo/:id',
        name: 'edit-return-rejection-memo',
        component: () => import('@/views/job-work/return-rejection-memo/returnRejectionMemoEdit.vue'),
        meta: {
            pageTitle: 'Return Rejection Memo',
            breadcrumb: [
                {
                    text: 'Return Rejection Memo',
                    to: {name: 'return-rejection-memo'},
                },
                {
                    text: 'Edit',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/raw-material-return-sub-contractor',
        name: 'raw-material-return-sub-contractor',
        component: () => import('@/views/job-work/raw-material-return-sub-contractor/returnSubContractorList.vue'),
        meta: {
            pageTitle: 'Return Sub Contractor',
            breadcrumb: [
                {
                    text: 'Return Sub Contractor',
                    active: true,
                },
            ],
            resource: 'RAW MATERIAL RETURN FROM SUB - CONTRACTOR',
            action: 'manage'
        },
    },
    {
        path: '/add-return-sub-contractor',
        name: 'add-return-sub-contractor',
        component: () => import('@/views/job-work/raw-material-return-sub-contractor/returnSubContractorAdd.vue'),
        meta: {
            pageTitle: 'Return Sub Contractor',
            breadcrumb: [
                {
                    text: 'Return Sub Contractor',
                    to: {name :'raw-material-return-sub-contractor'},
                },
                {
                    text: 'Add',
                    active: true,
                },
            ],
            resource: 'RAW MATERIAL RETURN FROM SUB - CONTRACTOR',
            action: 'manage'
        },
    },
    {
        path: '/edit-return-sub-contractor/:id',
        name: 'edit-return-sub-contractor',
        component: () => import('@/views/job-work/raw-material-return-sub-contractor/returnSubContractorEdit.vue'),
        meta: {
            pageTitle: 'Return Sub Contractor',
            breadcrumb: [
                {
                    text: 'Return Sub Contractor',
                    to: {name: 'raw-material-return-sub-contractor'},
                },
                {
                    text: 'Edit',
                    active: true,
                },
            ],
            resource: 'RAW MATERIAL RETURN FROM SUB - CONTRACTOR',
            action: 'manage'
        },
    },
    {
        path: '/scrap-receipt-entry',
        name: 'scrap-receipt-entry',
        component: () => import('@/views/job-work/scrap-receipt-entry/scarpReceiptEntryList.vue'),
        meta: {
            pageTitle: 'Scrap Receipt Entry',
            breadcrumb: [
                {
                    text: 'Scrap Receipt Entry',
                    active: true,
                },
            ],
            resource: 'SCRAP RECEIPT ENTRY',
            action: 'manage'
        },
    },
    {
        path: '/add-scrap-receipt-entry',
        name: 'add-scrap-receipt-entry',
        component: () => import('@/views/job-work/scrap-receipt-entry/scarpReceiptEntryAdd.vue'),
        meta: {
            pageTitle: 'Scrap Receipt Entry',
            breadcrumb: [
                {
                    text: 'Scrap Receipt Entry',
                    to: {name :'scrap-receipt-entry'},
                },
                {
                    text: 'Add',
                    active: true,
                },
            ],
            resource: 'SCRAP RECEIPT ENTRY',
            action: 'manage'
        },
    },
    {
        path: '/edit-scrap-receipt-entry/:id',
        name: 'edit-scrap-receipt-entry',
        component: () => import('@/views/job-work/scrap-receipt-entry/scrapReceiptEntryEdit.vue'),
        meta: {
            pageTitle: 'Scrap Receipt Entry',
            breadcrumb: [
                {
                    text: 'Scrap Receipt Entry',
                    to: {name: 'scrap-receipt-entry'},
                },
                {
                    text: 'Edit',
                    active: true,
                },
            ],
            resource: 'SCRAP RECEIPT ENTRY',
            action: 'manage'
        },
    },
    {
        path: '/job-work-rework-challan',
        name: 'job-work-rework-challan',
        component: () => import('@/views/job-work/job-work-rework-challan/jobWorkReworkChallanList.vue'),
        meta: {
            pageTitle: 'Job Work ReWork Challan',
            breadcrumb: [
                {
                    text: 'Job Work ReWork Challan',
                    active: true,
                },
            ],
            resource: 'JOB WORK REWORK CHALLAN',
            action: 'manage'
        },
    },
    {
        path: '/add-job-work-rework-challan',
        name: 'add-job-work-rework-challan',
        component: () => import('@/views/job-work/job-work-rework-challan/jobWorkReworkChallanAdd.vue'),
        meta: {
            pageTitle: 'Job Work ReWork Challan',
            breadcrumb: [
                {
                    text: 'Job Work ReWork Challan',
                    to: {name :'job-work-rework-challan'},
                },
                {
                    text: 'Add',
                    active: true,
                },
            ],
            resource: 'JOB WORK REWORK CHALLAN',
            action: 'manage'
        },
    },
    {
        path: '/edit-job-work-rework-challan/:id',
        name: 'edit-job-work-rework-challan',
        component: () => import('@/views/job-work/job-work-rework-challan/jobWorkReworkChallanEdit.vue'),
        meta: {
            pageTitle: 'Job Work ReWork Challan',
            breadcrumb: [
                {
                    text: 'Job Work ReWork Challan',
                    to: {name: 'job-work-rework-challan'},
                },
                {
                    text: 'Edit',
                    active: true,
                },
            ],
            resource: 'JOB WORK REWORK CHALLAN',
            action: 'manage'
        },
    },
    {
        path: '/job-work-rework-receipt',
        name: 'job-work-rework-receipt',
       component: () => import('@/views/job-work/job-work-rework-receipt/jobWorkReworkReceiptList.vue'),
        meta: {
            pageTitle: 'Job Work ReWork Receipt',
            breadcrumb: [
                {
                    text: 'Job Work ReWork Receipt',
                    active: true,
                },
            ],
            resource: 'JOB WORK REWORK RECEIPT',
            action: 'manage'
        },
    },
    {
        path: '/add-job-work-rework-receipt',
        name: 'add-job-work-rework-receipt',
        component: () => import('@/views/job-work/job-work-rework-receipt/jobWorkReWorkReceiptAdd.vue'),
        meta: {
            pageTitle: 'Job Work ReWork Receipt',
            breadcrumb: [
                {
                    text: 'Job Work ReWork Receipt',
                    to: {name:'job-work-rework-receipt'},
                },
                {
                    text: 'Add',
                    active: true,
                },
            ],
            resource: 'JOB WORK REWORK RECEIPT',
            action: 'manage'
        },
    },
    {
        path: '/edit-job-work-rework-receipt/:id',
        name: 'edit-job-work-rework-receipt',
        component: () => import('@/views/job-work/job-work-rework-receipt/jobWorkReworkReceiptEdit.vue'),
        meta: {
            pageTitle: 'Job Work ReWork Receipt',
            breadcrumb: [
                {
                    text: 'Job Work ReWork Receipt',
                    to: {name: 'job-work-rework-receipt'},
                },
                {
                    text: 'Edit',
                    active: true,
                },
            ],
            resource: 'JOB WORK REWORK RECEIPT',
            action: 'manage'
        },
    },
    {
        path: '/job-work-rate-master',
        name: 'job-work-rate-master',
        component: () => import('@/views/job-work/job-work-rate-master/jobWorkRateMasterList.vue'),
        meta: {
            pageTitle: 'Job Work Rate Master',
            breadcrumb: [
                {
                    text: 'Job Work Rate Master',
                    active: true,
                },
            ],
            resource: 'JOB WORK RATE MASTER',
            action: 'manage'
        },
    },
    {
        path: '/add-job-work-rate-master',
        name: 'add-job-work-rate-master',
        component: () => import('@/views/job-work/job-work-rate-master/JobWorkRateMasterAdd.vue'),
        meta: {
            pageTitle: 'Job Work Rate Master',
            breadcrumb: [
                {
                    text: 'Job Work Rate Master',
                    to:  {name:'job-work-rate-master'},
                },
                {
                    text: 'Add',
                    active: true,
                },
            ],
            resource: 'JOB WORK RATE MASTER',
            action: 'manage'
        },
    },
    {
        path: '/edit-job-work-rate-master/:id',
        name: 'edit-job-work-rate-master',
       component: () => import('@/views/job-work/job-work-rate-master/jobWorkRateMasterEdit.vue'),
        meta: {
            pageTitle: 'Job Work Rate Master',
            breadcrumb: [
                {
                    text: 'Job Work Rate Master',
                    to:  {name:'job-work-rate-master'},
                },
                {
                    text: 'Edit',
                    active: true,
                },
            ],
            resource: 'JOB WORK RATE MASTER',
            action: 'manage'
        },
    },

    {
        path: '/sub-contractor-rating-parameters',
        name: 'sub-contractor-rating-parameters',
        component: () => import('@/views/job-work/sub-contractor-rating-parameters/subContractorRatingParameterList.vue'),
        meta: {
            pageTitle: 'Sub-Contractor Parameters',
            breadcrumb: [
                {
                    text: 'Sub-Contractor Parameters',
                    active: true,
                },
            ],
            resource: 'SUB-CONTRACTOR RATING PARAMETERS',
            action: 'manage'
        },
    },

]
