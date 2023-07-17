export default [
    {
        title: 'Production Planning',
        icon: 'PackageIcon',
        toolTipText: 'Production Planning',
        children: [
            {
                title: 'Work Order',
                route: 'work-order',
                resource: 'WORK ORDER',
                action: 'manage'
            },
            {
                title: 'Job Card',
                route: 'Job-card',
                resource: 'JOB CARD',
                action: 'manage'
            },
            {
                title: 'Process Sheet',
                route: 'process-sheet-master',
                resource: 'PROCESS SHEET',
                action: 'manage'
            },
            {
                title: 'Assembly Card',
                route: null,
                resource: 'ASSEMBLY CARD',
                action: 'manage'
            },
            {
                title: 'Item Requisition',
                route: 'work-order-item-requisition',
                resource: 'ITEM REQUISITION',
                action: 'manage'
            },
            {
                title: 'Advance Planning',
                route: null,
                resource: 'ADVANCE PLANNING',
                action: 'manage'
            },
            {
                title: 'Production Forecasting',
                toolTipText: 'Production Forecasting',
                route: null,
                resource: 'PRODUCTION FORECASTING',
                action: 'manage'
            },
            {
                title: 'Approve Work Order For Production',
                toolTipText: 'Approve Work Order For Production',
                route: null,
                resource: 'APPROVE WORK ORDER FOR PRODUCTION',
                action: 'manage'
            },
            {
                title: 'Job Card Material Return From Shop',
                toolTipText: 'Job Card Material Return From Shop',
                route: 'job-card-material-return',
                resource: 'JOB CARD MATERIAL RETURN FROM SHOP',
                action: 'manage'
            },
            {
                title: 'Job Card Process Summary',
                toolTipText: 'Job Card Process Summary',
                route: null,
                resource: 'JOB CARD PROCESS SUMMARY',
                action: 'manage'
            },
            {
                title: 'Work Order Process Summary',
                toolTipText: 'Work Order Process Summary',
                route: null,
                resource: 'WORK ORDER PROCESS SUMMARY',
                action: 'manage'
            },
            {
                title: 'Work Order Item Serial Nos.',
                toolTipText: 'Work Order Item Serial Nos.',
                route: null,
                resource: 'WORK ORDER ITEM SERIAL NOS.',
                action: 'manage'
            },
            {
                title: 'Generate WO Against SO',
                toolTipText: 'Generate WO Against SO',
                route: 'generate-wo-against-so',
                resource: 'GENERATE WO AGAINST SO',
                action: 'manage'
            },
            {
                title: 'Cancel/Short Close Work Order Against SO',
                toolTipText: 'Cancel/Short Close Work Order Against SO',
                route: null,
                resource: 'CANCEL/SHORT CLOSE WORK ORDER AGAINST SO',
                action: 'manage'
            },
            {
                title: 'Production Planning Reports',
                children: [
                    {
                        title: 'Work Order Printing',
                        toolTipText:'Work Order Printing',
                        route: 'work-order-printing',
                    },
                    {
                        title: 'Work Order List',
                        toolTipText:'Work Order List',
                        route: 'work-order-list',
                    },
                    {
                        title: 'Work Order List With Rate',
                        toolTipText:'Work Order List With Rate',
                        route: 'work-order-list-with-rate',
                    },
                    {
                        title: 'Work Order Shortage Report',
                        toolTipText:'Work Order Shortage Report',
                        route: 'work-order-shortage-report',
                    },
                    {
                        title: 'Work Order Progress',
                        toolTipText:'Work Order Progress',
                        route: 'work-order-progress',
                    },
                    {
                        title: 'Pending Issue Item of Work Order',
                        toolTipText:'Pending Issue Item of Work Order',
                        route: 'pending-issue-item-of-work-order',
                    },
                    {
                        title: 'Daily Production Summary',
                        toolTipText:'Daily Production Summary',
                        route: 'daily-production-summary',
                    },
                    {
                        title: 'Production Schedule Report',
                        toolTipText:'Production Schedule Report',
                        route: 'production-schedule-report',
                    },
                    {
                        title: 'Finish Goods Stock Status',
                        toolTipText:'Finish Goods Stock Status',
                        route: 'finish-goods-stock-status',
                    },
                    {
                        title: 'Work Order List SO Wise',
                        toolTipText:'Work Order List SO Wise',
                        route: 'work-order-list-so-wise',
                    },
                    {
                        title: 'Work Order Item Requistion Summary',
                        toolTipText:'Work Order Item Requistion Summary',
                        route: 'work-order-item-requistion-summary',
                    },
                    {
                        title: 'Process Sheet Status',
                        toolTipText:'Process Sheet Status',
                        route: 'process-sheet-status',
                    },
                    {
                        title: 'Job Card Summary',
                        toolTipText:'Job Card Summary',
                        route: 'job-card-summary',
                    },
                    {
                        title: 'Job Card Summary With Cost',
                        toolTipText:'Job Card Summary With Cost',
                        route: 'job-card-summary-with-cost',
                    },
                    {
                        title: 'Job Card Summary Operator Wise',
                        toolTipText:'Job Card Summary Operator Wise',
                        route: 'job-card-summary-operator-wise',
                    },
                    {
                        title: 'Job Card Rejection Analysis',
                        toolTipText:'Job Card Rejection Analysis',
                        route: 'job-card-rejection-analysis',
                    },
                    {
                        title: 'Pending Issue Items of Job Card',
                        toolTipText:'Pending Issue Items of Job Card',
                        route: 'pending-issue-items-of-job-card',
                    },
                    {
                        title: 'Pending Issue Items of Job Card Requistion',
                        toolTipText:'Pending Issue Items of Job Card Requistion',
                        route: 'pending-issue-items-of-job-card-requistion',
                    },
                    {
                        title: 'Item Process Rate Summary',
                        toolTipText:'Item Process Rate Summary',
                        route: 'item-process-rate-summary',
                    },
                    {
                        title: 'WCN Summary',
                        toolTipText:'WCN Summary',
                        route: 'wcn-summary',
                    }
                ]
            }
        ],
    },
]
