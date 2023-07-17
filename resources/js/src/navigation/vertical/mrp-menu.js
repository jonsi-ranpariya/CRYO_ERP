export default [
    {
        title: 'MRP',
        icon: 'DollarSignIcon',
        children: [
            {
                title: 'WO Shortage (Purchase Items) - Cumulative',
                toolTipText: 'WO Shortage (Purchase Items) - Cumulative',
                route: 'wo-shortage-purchase-items',
                resource: 'WO SHORTAGE (PURCHASE ITEMS) - CUMULATIVE',
                action: 'manage'
            },
            {
                title: 'WO Shortage (Assembly/Components) - Cumulative',
                toolTipText: 'WO Shortage (Assembly/Components) - Cumulative',
                route: 'wo-shortage-assembly-components',
                resource: 'WO SHORTAGE (ASSEMBLY/COMPONENTS) - CUMULATIVE',
                action: 'manage'
            },
            {
                title: 'Minimum Level Shortage',
                toolTipText: 'Minimum Level Shortage',
                route: 'minimum-level-shortage',
                resource: 'MINIMUM LEVEL SHORTAGE',
                action: 'manage'
            },
            {
                title: 'Manual Planning',
                route: 'manual-planning',
                resource: 'MANUAL PLANNING',
                action: 'manage'
            },
            {
                title: 'WO Shortage (Purchase Items) - WO Wise',
                toolTipText: 'WO Shortage (Purchase Items) - WO Wise',
                route: 'wo-shortage-purchase-items-wo-wise',
                resource: 'WO SHORTAGE (PURCHASE ITEMS) - WO WISE',
                action: 'manage'
            },
            {
                title: 'WO Shortage (Assembly/Components) - WO Wise',
                toolTipText: 'WO Shortage (Assembly/Components) - WO Wise',
                route: 'wo-shortage-assembly-component-wo-wise',
                resource: 'WO SHORTAGE (ASSEMBLY/COMPONENTS) - WO WISE',
                action: 'manage'
            },
            {
                title: 'Pending Indent',
                route: 'pending-indent',
                resource: 'PENDING INDENT',
                action: 'manage'
            },
            {
                title: 'Indent Approval',
                route: 'indent-approval',
                resource: 'INDENT APPROVAL',
                action: 'manage'
            },
            {
                title: 'Forecast Base Shortage',
                toolTipText: 'Forecast Base Shortage',
                route: null,
                resource: 'FORECAST BASE SHORTAGE',
                action: 'manage'
            },
            {
                title: 'MRP Report',
                route: null,
                resource: 'MRP REPORT',
                action: 'manage',
                children: [
                    {
                        title: 'Indent Summary',
                        route: 'indent-summary',
                    },
                    {
                        title: 'Indent Summary Group Wise',
                        toolTipText: 'Indent Summary Group Wise',
                        route: 'indent-summary-group-wise',
                    },
                    {
                        title: 'Work Order Material Availability',
                        toolTipText: 'Work Order Material Availability',
                        route: 'work-order-material-availability',
                    },
                ]
            }
        ],
    },
]
