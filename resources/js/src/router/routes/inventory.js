export default [
    {
        path:'/gate-inward-receipt',
        name:'gate-inward-receipt',
        component: () => import('@/views/inventory/gate-inward-receipt/gateInwardReceiptList.vue'),
        meta:{
            pageTitle:'Gate Inward Receipt',
            breadcrumb:[
                {
                    text:'Gate Inward Receipt',
                    active:true,
                },
            ],
            resource: 'GIR (GATE INWARD RECEIPT)',
            action: 'manage'
        },
    },
    {
        path: '/add-gate-inward-receipt',
        name: 'add-gate-inward-receipt',
        component: () => import('@/views/inventory/gate-inward-receipt/gateInwardReceiptAdd.vue'),
        meta: {
            pageTitle: 'Gate Inward Receipt',
            breadcrumb: [
                {
                    text: 'Gate Inward Receipt',
                    to: {name:'gate-inward-receipt'},
                },
                {
                    text: 'Add',
                    active: true,
                },
            ],
            resource: 'GIR (GATE INWARD RECEIPT)',
            action: 'manage'
        },
    },
    {
        path: '/edit-gate-inward-receipt/:id',
        name: 'edit-gate-inward-receipt',
        component: () => import('@/views/inventory/gate-inward-receipt/gateInwardReceiptEdit.vue'),
        meta: {
            pageTitle: 'Gate Inward Receipt',
            breadcrumb: [
                {
                    text: 'Gate Inward Receipt',
                    to: {name:'gate-inward-receipt'},
                },
                {
                    text: 'Edit',
                    active: true,
                },
            ],
            resource: 'GIR (GATE INWARD RECEIPT)',
            action: 'manage'
        },
    },
    {
        path:'/goods-receipt-note',
        name:'goods-receipt-note',
        component: () => import('@/views/inventory/goods-receipt-note/goodsReceiptNoteList.vue'),
        meta:{
            pageTitle:'Goods Receipt Note',
            breadcrumb:[
                {
                    text:'Goods Receipt Note',
                    active:true,
                },
            ],
            resource: 'GRN (GOODS RECEIPT NOTE)',
            action: 'manage'
        },
    },
    {
        path: '/add-goods-receipt-note',
        name: 'add-goods-receipt-note',
        component: () => import('@/views/inventory/goods-receipt-note/goodsReceiptNoteAdd.vue'),
        meta: {
            pageTitle: 'Goods Receipt Note',
            breadcrumb: [
                {
                    text: 'Goods Receipt Note',
                    to: {name:'goods-receipt-note'},
                },
                {
                    text: 'Add',
                    active: true,
                },
            ],
            resource: 'GRN (GOODS RECEIPT NOTE)',
            action: 'manage'
        },
    },
    {
        path: '/edit-goods-receipt-note/:id',
        name: 'edit-goods-receipt-note',
        component: () => import('@/views/inventory/goods-receipt-note/goodsReceiptNoteEdit.vue'),
        meta: {
            pageTitle: 'Goods Receipt Note',
            breadcrumb: [
                {
                    text: 'Goods Receipt Note',
                    to: {name:'goods-receipt-note'},
                },
                {
                    text: 'Edit',
                    active: true,
                },
            ],
            resource: 'GRN (GOODS RECEIPT NOTE)',
            action: 'manage'
        },
    },
    {
        path: '/add-transaction-inventory',
        name: 'add-transaction-inventory',
        component: () => import('@/views/inventory/transaction-inventory/transactionInventoryAdd.vue'),
        meta: {
            pageTitle: 'Transaction',
            breadcrumb: [
                {
                    text: 'Transaction',
                    to: {name:'transaction-inventory'},
                },
                {
                    text: 'Add',
                    active: true,
                },
            ],
            resource: 'TRANSACTION',
            action: 'manage'
        },
    },
    {
        path:'/transaction-inventory',
        name:'transaction-inventory',
        component: () => import('@/views/inventory/transaction-inventory/transactionInventoryList.vue'),
        meta:{
            pageTitle:'Transaction',
            breadcrumb:[
                {
                    text:'Transaction',
                    active:true,
                },
            ],
            resource: 'TRANSACTION',
            action: 'manage'
        },
    },
    {
        path:'/edit-transaction-inventory/:id',
        name:'edit-transaction-inventory',
        component: () => import('@/views/inventory/transaction-inventory/transactionInventoryEdit.vue'),
        meta:{
            pageTitle:'Transaction',
            breadcrumb:[
                {
                    text: 'Transaction',
                    to: {name:'transaction-inventory'},
                },
                {
                    text:'Edit',
                    active:true,
                },
            ],
            resource: 'TRANSACTION',
            action: 'manage'
        },
    },
    {
        path: '/stock-transfer-item-to-item',
        name: 'stock-transfer-item-to-item',
        component: () => import('@/views/inventory/stock-transfer-item-to-item/stockTransferItemToItemList.vue'),
        meta: {
            pageTitle: 'Stock Transfer Item To Item',
            breadcrumb: [
                {
                    text: 'Stock Transfer Item To Item',
                    active: true,
                },
            ],
            resource: 'STOCK TRANSFER ITEM TO ITEM',
            action: 'manage'
         },
    },
    {
        path: '/add-stock-transfer-item-to-item',
        name: 'add-stock-transfer-item-to-item',
        component: () => import('@/views/inventory/stock-transfer-item-to-item/stockTransferItemToItemAdd.vue'),
        meta: {
            pageTitle: 'Stock Transfer Item To Item',
            breadcrumb: [
                {
                    text: 'Stock Transfer Item To Item',
                    to: { name: 'stock-transfer-item-to-item'}
                },
                {
                    text: 'Add',
                    active: true,
                }
            ],
            resource: 'STOCK TRANSFER ITEM TO ITEM',
            action: 'manage'
        }
    },
    {
        path:'/material-issue',
        name:'material-issue',
        component: () => import('@/views/inventory/material-issue/materialIssueList.vue'),
        meta:{
            pageTitle:'Material Issue',
            breadcrumb:[
                {
                    text:'Material Issue',
                    active:true,
                },
            ],
            resource: 'MATERIAL ISSUE',
            action: 'manage'
        },
    },
    {
        path:'/stock-ledger',
        name:'stock-ledger',
        component: () => import('@/views/inventory/stock-ledger/stockLedger.vue'),
        meta:{
            pageTitle:'Stock Ledger',
            breadcrumb:[
                {
                    text:'Stock Ledger',
                    active:true,
                },
            ],
            resource: 'INVENOTY REPORTS',
            action: 'manage'
        },
    }
]
