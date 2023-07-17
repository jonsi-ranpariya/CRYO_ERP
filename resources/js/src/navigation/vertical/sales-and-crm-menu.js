export default [
    {
        title: 'Sales & CRM',
        icon: 'BriefcaseIcon',
        children: [
            {
                title: 'Sales Support',
                route: null,
                resource: 'SALES SUPPORT',
                action: 'manage'
            },
            {
                title: 'Sales Opportunities/Leads',
                toolTipText: 'Sales Opportunities/Leads',
                route: null,
                resource: 'SALES OPPORTUNITIES/LEADS',
                action: 'manage'
            },
            {
                title: 'Sales Enquiry',
                route: 'sales-enquiry',
                resource: 'SALES ENQUIRY',
                action: 'manage'
            },
            {
                title: 'Sales Quotation',
                route: 'sales-quotation',
                resource: 'SALES QUOTATION',
                action: 'manage'
            },
            {
                title: 'Sales Quotation Approval',
                toolTipText: 'Sales Quotation Approval',
                route: 'approve-sales-quotation',
                resource: 'SALES QUOTATION APPROVAL',
                action: 'manage'
            },
            {
                title: 'Sales Order',
                route: 'sales-order',
                resource: 'SALES ORDER',
                action: 'manage'
            },
            {
                title: 'Proforma Invoice',
                route: 'proforma-invoices',
                resource: 'PROFORMA INVOICE',
                action: 'manage'
            },
            {
                title: 'Sales Return - Credit Note',
                toolTipText: 'Sales Return - Credit Note',
                route: 'sales-return',
                resource: 'SALES RETURN - CREDIT NOTE',
                action: 'manage'
            },
            {
                title: 'Sales Branches',
                route: null,
                resource: 'SALES BRANCHES',
                action: 'manage'
            },
            {
                title: 'Sales Offices',
                route: null,
                resource: 'SALES OFFICES',
                action: 'manage'
            },
            {
                title: 'Sales Costing Master',
                toolTipText: 'Sales Costing Master',
                route: null,
                resource: 'SALES COSTING MASTER',
                action: 'manage'
            },
            {
                title: 'Sales Costing Templates',
                toolTipText: 'Sales Costing Templates',
                route: null,
                resource: 'SALES COSTING TEMPLATES',
                action: 'manage'
            },
            {
                title: 'Sales Data History',
                route: null,
                resource: 'SALES DATA HISTORY',
                action: 'manage'
            },
            {
                title: 'Sales Target',
                route: null,
                resource: 'SALES TARGET',
                action: 'manage'
            },
            {
                title: 'Item Rate Master',
                route: null,
                resource: 'ITEM RATE MATER',
                action: 'manage'
            },
            {
                title: 'Price List (Party Type)',
                toolTipText: 'Price List (Party Type)',
                route: null,
                resource: 'PRICE LIST (PARTY TYPE)',
                action: 'manage'
            },
            {
                title: 'Price List (Party Type - Item Wise)',
                toolTipText: 'Price List (Party Type - Item Wise)',
                route: null,
                resource: 'PRICE LIST (PARTY TYPE - ITEM WISE)',
                action: 'manage'
            },
            {
                title: 'Price List Type Master',
                toolTipText: 'Price List Type Master',
                route: null,
                resource: 'PRICE LIST TYPE MASTER',
                action: 'manage'
            },
            {
                title: 'Price List Type Wise',
                route: null,
                resource: 'PRICE LIST TYPE WISE',
                action: 'manage'
            },
            {
                title: 'Payment Receipt',
                route: null,
                resource: 'PAYMENT RECEIPT',
                action: 'manage'
            },
            {
                title: 'Project Management',
                toolTipText: 'Project Management',
                route: null,
                resource: 'PROJECT MANAGEMENT',
                action: 'manage'
            },
            {
                title: 'Competitor Master',
                route: null,
                resource: 'COMPETITOR MASTER',
                action: 'manage'
            },
            {
                title: 'Sales Report',
                children: [
                    {
                        title: 'List of Enquiry',
                        route: 'sales-enquiry-list-report',
                        resource: 'SALES REPORTS',
                        action: 'manage'
                    },
                    {
                        title: 'List of Quotation',
                        route: 'sales-quotation-list-report',
                        resource: 'SALES REPORTS',
                        action: 'manage'
                    },
                    {
                        title: 'List of Sales Order',
                        route: 'sales-order-list-report',
                        resource: 'SALES REPORTS',
                        action: 'manage'
                    },
                    {
                        title: 'List Of sales Order without rate',
                        toolTipText: 'List Of sales Order without rate',
                        route: null,
                        resource: 'SALES REPORTS',
                        action: 'manage'
                    },
                    {
                        title: 'Sales order status',
                        route: null,
                        resource: 'SALES REPORTS',
                        action: 'manage'
                    },
                    {
                        title: 'Pending SO for WO',
                        route: null,
                        resource: 'SALES REPORTS',
                        action: 'manage'
                    },
                    {
                        title: 'Proforma Invoice Summary',
                        toolTipText: 'Proforma Invoice Summary',
                        route: 'proforma-invoice-summary-report',
                        resource: 'SALES REPORTS',
                        action: 'manage'
                    },
                    {
                        title: 'Sales Summary',
                        route: null,
                        resource: 'SALES REPORTS',
                        action: 'manage'
                    },
                    {
                        title: 'Sales Return Summary',
                        toolTipText: 'Sales Return Summary',
                        route: 'sales-return-summary-report',
                        resource: 'SALES REPORTS',
                        action: 'manage'
                    },
                ]
            }
        ]
    }

]
