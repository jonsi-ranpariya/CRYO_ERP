export default [
    {
        title: 'Engineering & BOM',
        icon: 'ClipboardIcon',
        children: [
            {
                title: 'Bill Of Material',
                route: 'bill-of-material',
                resource: 'BILL OF MATERIAL',
                action: 'manage'
            },
            {
                title: 'Replace Item In BOM',
                toolTipText: 'Replace Item In BOM',
                route: 'replace-item',
                resource: 'REPLACE ITEM IN BOM',
                action: 'manage'
            },
            {
                title: 'Replace Sales Order Items',
                toolTipText: 'Replace Sales Order Items',
                route: 'replace-sales-order',
                resource: 'REPLACE SALES ORDER ITEMS',
                action: 'manage'
            },
            {
                title: 'Drawing Master',
                route: 'drawing-master',
                resource: 'DRAWING MASTER',
                action: 'manage'
            },
            {
                title: 'BOM Reports',
                children: [
                    {
                        title: 'Where Used (Material)',
                        toolTipText:'Where Used (Material)',
                        route:'where-used-material',
                    },
                    {
                        title: 'BOM Status',
                        toolTipText: 'BOM Status',
                        route: 'bom-status',
                    },
                    {
                        title: 'List of BOM',
                        toolTipText: 'List of BOM',
                        route: 'list-of-bom',
                    },
                    {
                        title: 'BOM Summary With Rate',
                        toolTipText: 'BOM Summary With Rate',
                        route: 'bom-summary-with-rate',
                    },
                    {
                        title: 'List of Drawing Master',
                        toolTipText: 'List of Drawing Master',
                        route: 'list-of-drawing-master',
                    },
                    {
                        title: 'ECN Summary',
                        toolTipText: 'ECN Summary',
                        route: 'ecn-summary',
                    },
                    {
                        title: 'BOM Common Uncommon Items',
                        toolTipText: 'BOM Common Uncommon Items',
                        route: 'bom-common-uncommon-items',
                    }
                ]
            }
        ],

    },
]
