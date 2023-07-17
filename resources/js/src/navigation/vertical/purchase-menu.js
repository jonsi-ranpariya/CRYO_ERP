export default [
    {
        title: 'Purchase',
        icon: 'ShoppingCartIcon',
        children: [
            {
                title: 'Purchase Order Against Indent',
                toolTipText: 'Purchase Order Against Indent',
                route: null,
                resource: 'PURCHASE ORDER AGAINST INDENT',
                action: 'manage'
            },
            {
                title: 'Purchase Order',
                route: 'purchase-order',
                resource: 'PURCHASE ORDER',
                action: 'manage'
            },
            {
                title: 'Purchase Order Approval',
                toolTipText: 'Purchase Order Approval',
                route: null,
                resource: 'PURCHASE ORDER APPROVAL',
                action: 'manage'
            },
            {
                title: 'Purchase Costing',
                route: 'purchase-costing',
                resource: 'PURCHASE COSTING',
                action: 'manage'
            },
            {
                title: 'Purchase Return - Debit Note',
                toolTipText: 'Purchase Return - Debit Note',
                route: 'purchase-return',
                resource: 'PURCHASE RETURN - DEBIT NOTE',
                action: 'manage'
            },
            {
                title: 'Purchase Card (Item Wise)',
                toolTipText: 'Purchase Card (Item Wise)',
                route: null,
                resource: 'PURCHASE CARD (ITEM WISE)',
                action: 'manage'
            },
            {
                title: 'Purchase Card (Party Wise)',
                toolTipText: 'Purchase Card (Party Wise)',
                route: null,
                resource: 'PURCHASE CARD (PARTY WISE)',
                action: 'manage'
            },
            {
                title: 'Item Rate Master (Purchase)',
                toolTipText: 'Item Rate Master (Purchase)',
                route: 'item-rate-master',
                resource: 'ITEM RATE MASTER (PURCHASE)',
                action: 'manage'
            },
            {
                title: 'Vendor Rating Parameters',
                toolTipText: 'Vendor Rating Parameters',
                route: null,
                resource: 'VENDOR RATING PARAMETERS',
                action: 'manage'
            },
            {
                title: 'Purchase Enquiry',
                route: 'purchase-enquiry',
                resource: 'PURCHASE ENQUIRY',
                action: 'manage'
            },
            {
                title: 'Purchase Quotation',
                route: 'purchase-quotation',
                resource: 'PURCHASE QUOTATION',
                action: 'manage'
            },
            {
                title: 'Purchase Report',
                children: [
                    {
                        title: 'Pending Purchase Order',
                        toolTipText: 'Pending Purchase Order',
                        route: null,
                        resource: 'PURCHASE REPORT',
                        action: 'manage'
                    },
                    {
                        title: 'Pending Purchase Order Group Wise',
                        toolTipText: 'Pending Purchase Order Group Wise',
                        route: null,
                        resource: 'PURCHASE REPORT',
                        action: 'manage'
                    },
                    {
                        title: 'Purchase Order [Follow-up Latter]',
                        toolTipText: 'Purchase Order [Follow-up Latter]',
                        route: null,
                        resource: 'PURCHASE REPORT',
                        action: 'manage'
                    },
                    {
                        title: 'Purchase Order Summary',
                        toolTipText: 'Purchase Order Summary',
                        route: null,
                        resource: 'PURCHASE REPORT',
                        action: 'manage'
                    },
                    {
                        title: 'Purchase Order Summary Work Order Wise',
                        toolTipText: 'Purchase Order Summary Work Order Wise',
                        route: null,
                        resource: 'PURCHASE REPORT',
                        action: 'manage'
                    },
                    {
                        title: 'Purchase Order Summary Work Order Wise With Rate',
                        toolTipText: 'Purchase Order Summary Work Order Wise With Rate',
                        route: null,
                        resource: 'PURCHASE REPORT',
                        action: 'manage'
                    },
                    {
                        title: 'Purchase Order Status',
                        toolTipText: 'Purchase Order Status',
                        route: null,
                        resource: 'PURCHASE REPORT',
                        action: 'manage'
                    },
                    {
                        title: 'Price List (Purchase Items)',
                        toolTipText: 'Price List (Purchase Items)',
                        route: null,
                        resource: 'PURCHASE REPORT',
                        action: 'manage'
                    },
                    {
                        title: 'Purchase Quotation Summary',
                        toolTipText: 'Purchase Quotation Summary',
                        route: null,
                        resource: 'PURCHASE REPORT',
                        action: 'manage'
                    },
                    {
                        title: 'Vendor Analysis',
                        route: null,
                        resource: 'PURCHASE REPORT',
                        action: 'manage'
                    }
                ]
            }
        ]
    },
]
