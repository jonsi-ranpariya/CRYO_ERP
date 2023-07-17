export default [
    {
        path: '/finance/finance-master/chart-of-accounts',
        name: 'chart-of-accounts',
        component: () => import('@/views/finance-master/chart-of-accounts/chartOfAccountsMaster'),
        meta: {
            pageTitle: 'Chart Of Accounts',
            breadcrumb: [
                {
                    text: 'Chart Of Accounts',
                    active: true,
                },
            ],
            resource: 'CHART OF ACCOUNT (GROUPS)',
            action: 'manage'
        },
    },
    {
        path: '/finance/finance-master/tds-master',
        name: 'tds-master',
        component: () => import('@/views/finance-master/tds-master/tdsMasterList'),
        meta: {
            pageTitle: 'TDS Master',
            breadcrumb: [
                {
                    text: 'TDS Master',
                    active: true,
                },
            ],
            resource: 'GENERAL LEDGER ACCOUNTS',
            action: 'manage'
        },
    },
    {
        path: '/finance/finance-master/payment-mode-master',
        name: 'payment-mode-master',
        component: () => import('@/views/finance-master/payment-mode-master/paymentModeMasterList'),
        meta: {
            pageTitle: 'Payment Mode Master',
            breadcrumb: [
                {
                    text: 'Payment Mode Master',
                    active: true,
                },
            ],
            resource: 'PAYMENT MODE MASTER',
            action: 'manage'
        },
    },
    {
        path: '/finance/finance-master/narration-master',
        name: 'narration-master',
        component: () => import('@/views/finance-master/narration-master/narrationMasterList'),
        meta: {
            pageTitle: 'Narration Master',
            breadcrumb: [
                {
                    text: 'Narration Master',
                    active: true,
                },
            ],
            resource: 'NARRATION MASTER',
            action: 'manage'
        },
    },
    {
        path: '/finance/finance-master/cheque-printing-master',
        name: 'cheque-printing-master',
        component: () => import('@/views/finance-master/cheque-printing-master/chequePrintingMasterList'),
        meta: {
            pageTitle: 'Cheque Printing Format Master',
            breadcrumb: [
                {
                    text: 'Cheque Printing Format Master',
                    active: true,
                },
            ],
            resource: 'CHEQUE PRINTING REPORT PARAMETER',
            action: 'manage'
        },
    },
    {
        path: '/finance/finance-master/account-parameters',
        name: 'account-parameters',
        component: () => import('@/views/finance-master/account-parameters/accountParametersMaster'),
        meta: {
            pageTitle: 'Account Parameters',
            breadcrumb: [
                {
                    text: 'Account Parameters',
                    active: true,
                },
            ],
            resource: 'ACCOUNT PARAMETERS',
            action: 'manage'
        },
    },
    {
        path: '/finance/finance-master/general-ledger-accounts',
        name: 'general-ledger-accounts',
        component: () => import('@/views/finance-master/general-ledger-accounts/generalLedgerAccountsMaster'),
        meta: {
            pageTitle: 'General Ledger Accounts',
            breadcrumb: [
                {
                    text: 'General Ledger Accounts',
                    active: true,
                },
            ],
            resource: 'GENERAL LEDGER ACCOUNTS',
            action: 'manage'
        },
    },
    {
        path: '/finance/finance-master/add-general-ledger-accounts',
        name: 'add-general-ledger-accounts',
        component: () => import('@/views/finance-master/general-ledger-accounts/addGeneralLedgerAccountsMaster'),
        meta: {
            pageTitle: 'Add General Ledger',
            breadcrumb: [
                {
                    text: 'General Ledger Accounts',
                    to: { name : 'general-ledger-accounts' },
                },
                {
                    text: 'Add General Ledger Account',
                    active: true,
                }
            ],
            resource: 'GENERAL LEDGER ACCOUNTS',
            action: 'manage'
        },
    },
    {
        path: '/finance/finance-master/edit-general-ledger-accounts/:id',
        name: 'edit-general-ledger-accounts',
        component: () => import('@/views/finance-master/general-ledger-accounts/editGeneralLedgerAccountsMaster'),
        meta: {
            pageTitle: 'Edit General Ledger',
            breadcrumb: [
                {
                    text: 'General Ledger Accounts',
                    to: { name : 'general-ledger-accounts' },
                },
                {
                    text: 'Edit General Ledger Account',
                    active: true,
                }
            ],
            resource: 'GENERAL LEDGER ACCOUNTS',
            action: 'manage'
        },
    },
    {
        path: '/finance/finance-master/budget-master',
        name: 'budget-master',
        component: () => import('@/views/finance-master/budget-master/budgetMaster'),
        meta: {
            pageTitle: 'Budget Master',
            breadcrumb: [
                {
                    text: 'Budget Master',
                    active: true,
                },
            ],
            resource: 'BUDGET MASTER',
            action: 'manage'
        },
    },
    {
        path: '/finance/finance-master/add-budget-master',
        name: 'add-budget-master',
        component: () => import('@/views/finance-master/budget-master/addBudgetMaster'),
        meta: {
            pageTitle: 'Add Budget Master',
            breadcrumb: [
                {
                    text: 'Budget Master',
                    to: { name : 'budget-master' },
                },
                {
                    text: 'Add Budget Master',
                    active: true,
                },
            ],
            resource: 'BUDGET MASTER',
            action: 'manage'
        },
    },
    {
        path: '/finance/finance-master/edit-budget-master/:id',
        name: 'edit-budget-master',
        component: () => import('@/views/finance-master/budget-master/editBudgetMaster'),
        meta: {
            pageTitle: 'Edit Budget Master',
            breadcrumb: [
                {
                    text: 'Budget Master',
                    to: { name : 'budget-master' },
                },
                {
                    text: 'Edit Budget Master',
                    active: true,
                },
            ],
            resource: 'BUDGET MASTER',
            action: 'manage'
        },
    },
    {
        path: '/finance/finance-master/cost-center-group',
        name: 'cost-center-group',
        component: () => import('@/views/finance-master/cost-center-group/costCenterGroupMaster'),
        meta: {
            pageTitle: 'Cost Center Master',
            breadcrumb: [
                {
                    text: 'Cost Center Master',
                    active: true,
                },
            ],
            resource: 'COST CENTER GROUP MASTER',
            action: 'manage'
        },
    },
]
