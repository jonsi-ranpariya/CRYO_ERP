export default [
    {
        title: 'Master',
        icon: 'SettingsIcon',
        toolTipText: '',
        children: [
            {
                title: 'General Master',
                children: [
                    {
                        title: 'UOM Master',
                        route: 'uom-list',
                        resource: 'UOM MASTER',
                        action: 'manage'
                    },
                    {
                        title: 'Item Make Master',
                        route: 'item-make-list',
                        resource: 'ITEM MAKE MASTER',
                        action: 'manage'
                    },
                    {
                        title: 'Store Master',
                        route: 'store-master',
                        resource: 'STORE MASTER',
                        action: 'manage',
                    },
                    {
                        title: 'Test Certificate Type',
                        toolTipText: 'Manage Test Certificate Type',
                        route: 'test-certificate-types-list',
                        resource: 'TEST CERTIFICATE TYPE',
                        action: 'manage'
                    },
                    {
                        title: 'Party Type',
                        route: 'party-type-list',
                        resource: 'PARTY TYPE',
                        action: 'manage'
                    },
                    {
                        title: 'Business Type Master',
                        toolTipText: 'Business Type Master',
                        route: 'business-type-list',
                        resource: 'BUSINESS TYPE MASTER',
                        action: 'manage'
                    },
                    {
                        title: 'Country Master',
                        route: 'country-list',
                        resource: 'COUNTRY MASTER',
                        action: 'manage'
                    },
                    {
                        title: 'State Master',
                        route: 'state-list',
                        resource: 'STATE MASTER',
                        action: 'manage'
                    },
                    {
                        title: 'District Master',
                        route: 'city-list',
                        resource: 'CITY MASTER',
                        action: 'manage'
                    },
                    {
                        title: 'Currency Master',
                        route: 'currency-list',
                        resource: 'CURRENCY MASTER',
                        action: 'manage'
                    },
                    {
                        title: 'Department',
                        route: 'department-list',
                        resource: 'DEPARTMENT',
                        action: 'manage'
                    },
                    {
                        title: 'Designation',
                        route: 'designation-list',
                        resource: 'DESIGNATION',
                        action: 'manage'
                    },
                    {
                        title: 'Enquiry Reference Master',
                        toolTipText: 'Enquiry Reference Master',
                        route: 'enquiry-reference-master',
                        resource: 'ENQUIRY REFERENCE MASTER',
                        action: 'manage'
                    },
                    {
                        title: 'Quotation Type',
                        route: 'quotation-type',
                        resource: 'QUOTATION TYPE',
                        action: 'manage'
                    },
                    {
                        title: 'Sales Lead Stage Master',
                        toolTipText: 'Sales Lead Stage Master',
                        route: 'sales-lead-stage-master',
                        resource: 'SALES LEAD STAGE MASTER',
                        action: 'manage',
                    },
                    {
                        title: 'Sales Lead Title Master',
                        toolTipText: 'Sales Lead Title Master',
                        route: 'sales-lead-title-master',
                        resource: 'SALES LEAD TITLE MASTER',
                        action: 'manage'
                    },
                    {
                        title: 'Industries Type Master',
                        toolTipText: 'Industries Type Master',
                        route: 'industries-type-master',
                        resource: 'INDUSTRIES TYPE MASTER',
                        action: 'manage',
                    },
                    {
                        title: 'Reason Master',
                        route: 'reason-master',
                        resource: 'REASON MASTER',
                        action: 'manage',
                    },
                    {
                        title: 'Purchase Type',
                        route: 'purchase-type',
                        resource: 'PURCHASE TYPE',
                        action: 'manage'
                    },
                    {
                        title: 'Document Header',
                        route: 'document-header',
                        resource: 'DOCUMENT HEADER',
                        action: 'manage'
                    },
                    {
                        title: 'Document Footer',
                        route: 'document-footer',
                        resource: 'DOCUMENT FOOTER',
                        action: 'manage'
                    },
                    {
                        title: 'Note Master',
                        route: 'note-master',
                        resource: 'NOTE MASTER',
                        action: 'manage'
                    },
                    {
                        title: 'Machine Master',
                        route: 'machine-master',
                        resource: 'MACHINE MASTER',
                        action: 'manage'
                    },
                    {
                        title: 'Process Master',
                        route: 'process-master',
                        resource: 'PROCESS MASTER',
                        action: 'manage'
                    },
                    {
                        title: 'Operator Master',
                        route: 'operator-master',
                        resource: 'OPERATOR MASTER',
                        action: 'manage'
                    },
                    {
                        title: 'Bank Master',
                        route: 'bank-master',
                        resource: 'BANK MASTER',
                        action: 'manage'
                    },
                    {
                        title: 'Packing Master',
                        route: 'packing-master',
                        resource: 'PACKING MASTER',
                        action: 'manage'
                    },
                    {
                        title: 'Payment Deduction Master',
                        toolTipText: 'Payment Deduction Master',
                        route: 'payment-deduction-master',
                        resource: 'PAYMENT DEDUCTION MASTER',
                        action: 'manage'
                    },
                    {
                        title: 'Expense Master',
                        route: 'expense-master',
                        resource: 'EXPENSE MASTER',
                        action: 'manage'
                    },
                    {
                        title: 'Document Type Master',
                        toolTipText: 'Document Type Master',
                        route: 'document-type-master',
                        resource: 'DOCUMENT TYPE MASTER',
                        action: 'manage'
                    },
                    {
                        title: 'Branch Master',
                        route: 'branch-master',
                        resource: 'BRANCH MASTER',
                        action: 'manage'
                    }
                ],
            },
            {
                title: 'Party Master',
                route: 'party-master-list',
                resource: 'PARTY MASTER',
                action: 'manage',
            },
            {
                title: 'Party Group Master',
                route: 'party-group-master-list',
                resource: 'PARTY GROUP MASTER',
                action: 'manage',
            },
            {
                title: 'Invoice Type Master',
                route: 'invoice-type-master',
                resource: 'INVOICE TYPE MASTER',
                action: 'manage'
            },
            {
                title: 'Sales Order Type Master',
                toolTipText: 'Sales Order Type Master',
                route: 'sales-order-type-master',
                resource: 'SALES ORDER TYPE MASTER',
                action: 'manage'
            },
            {
                title: 'Item Master',
                route: 'item-master-list',
                resource: 'ITEM MASTER',
                action: 'manage',
            },
            {
                title: 'Item Category',
                route: 'item-category',
                resource: 'ITEM CATEGORY',
                action: 'manage',
            },
            {
                title: 'Item Group',
                route: 'item-group-master',
                resource: 'ITEM GROUP',
                action: 'manage',
            },
            {
                title: 'Main Group/Sub Group',
                toolTipText: 'Main Group/Sub Group',
                route: 'item-main-sub-group',
                resource: 'MAIN GROUP/SUB GROUP',
                action: 'manage',
            },
            {
                title: 'HSN/SAC Master',
                route: 'item-hsn-sac-code',
                resource: 'HSN/SAC MASTER',
                action: 'manage',
            },
            {
                title: 'Material Specification',
                toolTipText: 'Material Specification',
                route: null,
                resource: 'MATERIAL SPECIFICATION',
                action: 'manage',
            },
            {
                title: 'Billing Description Master',
                toolTipText: 'Billing Description Master',
                route: 'billing-description-master',
                resource: 'BILLING DESCRIPTION MASTER',
                action: 'manage'
            },
            {
                title: 'Billing Template Master',
                toolTipText: 'Billing Template Master',
                route: 'billing-template-master',
                resource: 'BILLING TEMPLATE MASTER',
                action: 'manage'
            },
            {
                title: 'AddOn Type',
                route: 'item-addon-type',
            },
            {
                title: 'AddOn Detail',
                route: 'item-addon-detail',
            },
            {
                title: 'Item Serial No Generation Parameters',
                toolTipText: 'Item Serial No Generation Parameters',
                route: null,
            },
            {
                title: 'Sales Target Item Group',
                toolTipText: 'Sales Target Item Group',
                route: 'item-sales-target-group',
                resource: 'SALES TARGET ITEM GROUP',
                action: 'manage'
            },
            {
                title: 'Term & Condition Group',
                toolTipText: 'Term & Condition Group',
                route: 'term-condition-group-master',
                resource: 'TERM & CONDITION GROUP',
                action: 'manage'
            },
            {

                title: 'Term & Condition Details',
                toolTipText: 'Term & Condition Details',
                route: 'term-condition-detail-master',
                resource: 'TERM & CONDITION DETAILS',
                action: 'manage'
            },
            {
                title: 'Default Term & Condition',
                toolTipText: 'Default Term & Condition',
                route: 'default-term-condition-master',
                resource: 'DEFAULT TERM & CONDITION',
                action: 'manage'
            },
            {
                title: 'Term & Condition Template',
                toolTipText: 'Term & Condition Template',
                route: 'term-condition-template-master',
            },
            {
                title: 'Tax Master',
                route: 'tax-master',
                resource: 'TAX MASTER',
                action: 'manage'
            },
            {
                title: 'Tax Forms',
                route: 'tax-forms-master',
                resource: 'TAX FORMS',
                action: 'manage'
            },
            {
                title: 'ISO/API Document Master',
                toolTipText: 'ISO/API Document Master',
                route: 'ios-api-doc-master',
                resource: 'ISO/API DOCUMENT',
                action: 'manage'
            },
            {
                title: 'Duty Drawback Tariff Master',
                toolTipText: 'Duty Drawback Tariff Master',
                route: 'duty-drawback-master',
                resource: 'DUTY DRAWBACK TARIFF MASTER',
                action: 'manage'
            },
            {
                title: 'Import Item Master From Excel',
                toolTipText: 'Import Item Master From Excel',
                route: 'item-master-import',
            },
            {
                title: 'Import Party Master From Excel',
                toolTipText: 'Import Party Master From Excel',
                route: 'party-master-import',
            },
            {
                title: 'Task Manager',
                route: 'task-master',
                resource: 'TASK MANAGER',
                action: 'manage'
            },
            {
                title: 'Progress Stage Master',
                toolTipText: 'Progress Stage Master',
                route: 'progress-stage-master',
                resource: 'PROGRESS STAGE MASTER',
                action: 'manage'
            },
            {
                title: 'Serial Master',
                route: 'serial-master',
                resource: 'SERIAL MASTER',
                action: 'manage'
            },
            {
                title: 'Master Reports',
                children: [
                    {
                        title: 'List Of Party',
                        route: null,
                        resource: 'MASTER REPORTS',
                        action: 'manage'
                    },
                    {
                        title: 'List Of Item',
                        route: null,
                        resource: 'MASTER REPORTS',
                        action: 'manage'
                    }
                ]
            }
        ],
    },
]
