export default [
    {
        title: 'Inventory',
        icon: 'DatabaseIcon',
        children: [
            {
                title: 'GRN (Goods Receipt Note)',
                toolTipText: 'GRN (Goods Receipt Note)',
                route: 'goods-receipt-note',
                resource: 'GRN (GOODS RECEIPT NOTE)',
                action: 'manage'
            },
            {
                title: 'Material Issue',
                route: 'material-issue',
                resource: 'MATERIAL ISSUE',
                action: 'manage'
            },
            {
                title: 'GIR (Gate Inward Receipt)',
                toolTipText: 'GIR (Gate Inward Receipt)',
                route: 'gate-inward-receipt',
                resource: 'GIR (GATE INWARD RECEIPT)',
                action: 'manage'
            },
            {
                title: 'Opening Stock',
                route: null,
            },
            {
                title: 'Transaction',
                route: 'transaction-inventory',
                resource: 'TRANSACTION',
                action: 'manage'
            },
            {
                title: 'Stock Transfer Item To Item',
                toolTipText: 'Stock Transfer Item To Item',
                route: 'stock-transfer-item-to-item',
                resource: 'STOCK TRANSFER ITEM TO ITEM',
                action: 'manage'
            },
            {
                title: 'Stock Transfer Between Stores',
                toolTipText: 'Stock Transfer Between Stores',
                route: null,
            },
            {
                title: 'Stock Transfer Between Godowns',
                toolTipText: 'Stock Transfer Between Godowns',
                route: null,
            },
            {
                title: 'Item Stock Status',
                route: null,
            },
            {
                title: 'Finish Item Stock Status',
                toolTipText: 'Finish Item Stock Status',
                route: null,
            },
            {
                title: 'Material Issue Against Project',
                toolTipText: 'Material Issue Against Project',
                route: null,
            },
            {
                title: 'Returnable/Non-Returnable Challan',
                toolTipText: 'Returnable/Non-Returnable Challan',
                route: null,
            },
            {
                title: 'Returnable Receipt',
                route: null,
            },
            {
                title: 'GRN Modifications',
                route: null,
            },
            {
                title: 'GRN Item Serial No.',
                route: null,
            },
            {
                title: 'GRN View',
                route: null,
            },
            {
                title: 'Material Issue Multi Level',
                toolTipText: 'Material Issue Multi Level',
                route: null,
            },
            {
                title: 'Issue Material Against SO',
                toolTipText: 'Issue Material Against SO',
                route: null,
            },
            {
                title: 'Batch/Heat No. Tracking',
                toolTipText: 'Batch/Heat No. Tracking',
                route: null,
            },
            {
                title: 'Serial No. Tracking',
                route: null,
            },
            {
                title: 'Gate Outward Note',
                route: null,
            },
            {
                title: 'Inventory Reports',
                icon: 'ListIcon',
                children: [
                    {
                        title: 'Stock Ledger',
                        route: 'stock-ledger',
                        resource: 'INVENOTY REPORTS',
                        action: 'manage'
                    },
                    {
                        title: 'Stock Ledger Without Rate',
                        toolTipText: 'Stock Ledger Without Rate',
                        route: null,
                    },
                    {
                        title: 'Stock Ledger Item Serial No. Wise',
                        toolTipText: 'Stock Ledger Item Serial No. Wise',
                        route: null,
                    },
                    {
                        title: 'Stock Summary Group Wise',
                        toolTipText: 'Stock Summary Group Wise',
                        route: null,
                    },
                    {
                        title: 'Stock Summary (Make Wise)',
                        toolTipText: 'Stock Summary (Make Wise)',
                        route: null,
                    },
                    {
                        title: 'Stock Summary (Store Wise)',
                        toolTipText: 'Stock Summary (Store Wise)',
                        route: null,
                    },
                    {
                        title: 'Stock Summary Allocated',
                        toolTipText: 'Stock Summary Allocated',
                        route: null,
                    },
                    {
                        title: 'Godown Transfer Summary',
                        toolTipText: 'Godown Transfer Summary',
                        route: null,
                    },
                    {
                        title: 'Pending Inward Material Summary',
                        toolTipText: 'Pending Inward Material Summary',
                        route: null,
                    },
                    {
                        title: 'Daily Stock Summary',
                        toolTipText: 'Daily Stock Summary',
                        route: null,
                    },
                    {
                        title: 'Daily Stock Summary Without Rate',
                        toolTipText: 'Daily Stock Summary Without Rate',
                        route: null,
                    },
                    {
                        title: 'Dead Stock Summary',
                        toolTipText: 'Dead Stock Summary',
                        route: null,
                    },
                    {
                        title: 'Stock Analysis',
                        toolTipText: 'Stock Analysis',
                        route: null,
                    },
                    {
                        title: 'WIP (Work In Progress)',
                        toolTipText: 'WIP (Work In Progress)',
                        route: null,
                    },
                    {
                        title: 'WIP (Work In Progress) Date Wise',
                        toolTipText: 'WIP (Work In Progress) Date Wise',
                        route: null,
                    },
                    {
                        title: 'Opening Stock Statement',
                        toolTipText: 'Opening Stock Statement',
                        route: null,
                    },
                    {
                        title: 'Monthly Consumption',
                        toolTipText: 'Monthly Consumption',
                        route: null,
                    },
                    {
                        title: 'Item Consumption',
                        toolTipText: 'Item Consumption',
                        route: null,
                    },
                    {
                        title: 'GRN Report',
                        toolTipText: 'GRN Report',
                        route: null,
                    },
                    {
                        title: 'GRN Summary Group Wise',
                        toolTipText: 'GRN Summary Group Wise',
                        route: null,
                    },
                    {
                        title: 'Issue Slips',
                        toolTipText: 'Issue Slips',
                        route: null,
                    },
                    {
                        title: 'Sales Order Wise Mat. Issue',
                        toolTipText: 'Sales Order Wise Mat. Issue',
                        route: null,
                    },
                    {
                        title: 'Returnable Challan Receipt',
                        toolTipText: 'Returnable Challan Receipt',
                        route: null,
                    },
                    {
                        title: 'Returnable Challan Summary',
                        toolTipText: 'Returnable Challan Summary',
                        route: null,
                    },
                    {
                        title: 'GRN Summary Outside (Job Work)',
                        toolTipText: 'GRN Summary Outside (Job Work)',
                        route: null,
                    },
                    {
                        title: 'Gate Outword Summary',
                        toolTipText: 'Gate Outword Summary',
                        route: null,
                    }

                ],
            }
        ]
    },
]
