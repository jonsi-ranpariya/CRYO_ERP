export default [
    {
        title: 'Bill Booking',
        icon: 'ClipboardIcon',
        children: [
            {
                title: 'Purchase Bill',
                toolTipText: 'Purchase Bill',
                route: 'purchase-bill',
            },
            {
                title: 'Purchase Bill Rate History',
                toolTipText: 'Purchase Bill Rate History',
                route: 'purchase-bill-rate-history',
            },
            {
                title: 'Payment',
                toolTipText: 'Payment',
                route: 'payment',
            },
            {
                title: 'Bill Booking Report',
                children: [
                    {
                        title: 'Purchase Bill Summary',
                        toolTipText: 'Purchase Bill Summary',
                        route: 'purchase-bill-summary',
                    },
                    {
                        title: 'Purchase Bill Analysis',
                        toolTipText: 'Purchase Bill Analysis',
                        route: 'purchase-bill-analysis',
                    },
                    {
                        title: 'Purchase Bill Other Expense',
                        toolTipText: 'Purchase Bill Other Expense',
                        route: 'purchase-bill-other-expense',
                    },
                    {
                        title: 'Purchase Bill Summary Group Wise',
                        toolTipText: 'Purchase Bill Summary Group Wise',
                        route: 'purchase-bill-summary-group-wise',
                    },
                    {
                        title: 'Purchase Bill Payment Summary',
                        toolTipText: 'Purchase Bill Payment Summary',
                        route: 'purchase-bill-payment-summary',
                    },
                    {
                        title: 'GRN Summary',
                        toolTipText: 'GRN Summary',
                        route: 'grn-summary',
                    },
                    {
                        title: 'TAX FORM Summary',
                        toolTipText: 'TAX FORM Summary',
                        route: 'tax-form-summary',
                    },
                    {
                        title: 'Purchase Return Summary',
                        toolTipText: 'Purchase Return Summary',
                        route: 'purchase-return-summary',
                    }
                ]
            }
        ]
    }
]
