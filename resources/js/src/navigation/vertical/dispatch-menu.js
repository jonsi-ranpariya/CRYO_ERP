export default [
    {
        title: 'Despatch',
        icon: 'TruckIcon',
        children: [
            /*{
                title: 'Challan & Invoices',
                route: 'challan-invoices-list',
            },*/
            {
                title: 'Generate Invoice',
                route: 'new-challan-invoices',
                resource: 'GENERATE INVOICE',
                action: 'manage'
            },
            {
                title: 'Transfer Challan & Invoice',
                toolTipText: 'Transfer Challan & Invoice',
                route: null,
                resource: 'TRANSFER CHALLAN & INVOICE',
                action: 'manage'
            },
            {
                title: 'Despatch Intimation',
                route: null,
                resource: 'DESPATCH INTIMATION',
                action: 'manage'
            },
            {
                title: 'TAX FORM Details',
                route: null,
                resource: 'TAX FORM DETAILS',
                action: 'manage'
            },
            {
                title: 'Despatch Follow Up',
                route: null,
                resource: 'DESPATCH FOLLOW UP',
                action: 'manage'
            },
            {
                title: 'Service Invoice',
                route: null,
                resource: 'SERVICE INVOICE',
                action: 'manage'
            },
            {
                title: 'Dealer Invoice',
                route: null,
                resource: 'DEALER INVOICE',
                action: 'manage'
            },
            {
                title: 'Supplementary Invoice',
                toolTipText: 'Supplementary Invoice',
                route: null,
                resource: 'SUPPLEMENTARY INVOICE',
                action: 'manage'
            },
            {
                title: 'Dealer Sales Entry',
                route: null,
                resource: 'DEALER SALES ENTRY',
                action: 'manage'
            },
            {
                title: 'Despatch Report',
                children: [
                    {
                        title: 'Despatch Summary',
                        route: null,
                    },
                    {
                        title: 'Daily Despatch Summary With Rate',
                        toolTipText: 'Daily Despatch Summary With Rate',
                        route: null,
                    },
                    {
                        title: 'Delivery Analysis',
                        route: null,
                    },
                    {
                        title: 'Despatch Details[E-Mail]',
                        toolTipText: 'Despatch Details[E-Mail]',
                        route: null,
                    },
                    {
                        title: 'TAX FORM Reminder Letter',
                        toolTipText: 'TAX FORM Reminder Letter',
                        route: null,
                    }
                ]
            }
        ]

    },
]
