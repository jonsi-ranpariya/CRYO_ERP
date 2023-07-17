export default [
    {
        path: '/master/party-master',
        name: 'party-master-list',
        component: () => import('@/views/master/party-master/PartyMaster.vue'),
        meta: {
            pageTitle: 'Party List',
            breadcrumb: [
                {
                    text: 'Party Master',
                    active: true,
                },
            ],
            resource: 'PARTY MASTER',
            action: 'manage',
        },
    },
    {
        path: '/master/add-party-master',
        name: 'add-party-master',
        component: () => import('@/views/master/party-master/AddPartyMaster.vue'),
        meta: {
            pageTitle: 'Add New Party',
            breadcrumb: [
                {
                    text: 'Party Master',
                    to: { name: 'party-master-list' },
                },
                {
                    text: 'Add New Party',
                    active: true,
                },
            ],
            resource: 'PARTY MASTER',
            action: 'manage',
        },
    },
    {
        path: '/master/edit-party-master/:id',
        name: 'edit-party-master',
        component: () => import('@/views/master/party-master/EditPartyMaster.vue'),
        meta: {
            pageTitle: 'Edit Party Detail',
            breadcrumb: [
                {
                    text: 'Party Master',
                    to: { name: 'party-master-list' },
                },
                {
                    text: 'Edit Party Detail',
                    active: true,
                },
            ],
            resource: 'PARTY MASTER',
            action: 'manage',
        },
    },
    {
        path: '/master/party-group-master',
        name: 'party-group-master-list',
        component: () => import('@/views/master/party-group-master/PartyGroupMaster.vue'),
        meta: {
            pageTitle: 'Party Group List',
            breadcrumb: [
                {
                    text: 'Party Group Master',
                    active: true,
                },
            ],
            resource: 'PARTY GROUP MASTER',
            action: 'manage',
        },
    },
    {
        path: '/master/item-master',
        name: 'item-master-list',
        component: () => import('@/views/master/item-master/ItemMaster'),
        meta: {
            pageTitle: 'Item Master List',
            breadcrumb: [
                {
                    text: 'Item Master',
                    active: true,
                },
            ],
            resource: 'ITEM MASTER',
            action: 'manage',
        },
    },
    {
        path: '/master/add-item-master',
        name: 'add-item-master',
        component: () => import('@/views/master/item-master/ItemMasterAdd'),
        meta: {
            pageTitle: 'Add Item Master',
            breadcrumb: [
                {
                    text: 'Item Master',
                    to: { name: 'item-master-list' }
                },
                {
                    text: 'Add Item Master',
                    active: true,
                }
            ],
            resource: 'ITEM MASTER',
            action: 'manage',
        },
    },
    {
        path: '/master/edit-item-master/:id',
        name: 'edit-item-master',
        component: () => import('@/views/master/item-master/ItemMasterEdit'),
        meta: {
            pageTitle: 'Edit Item Master',
            breadcrumb: [
                {
                    text: 'Item Master',
                    to: { name: 'item-master-list' }
                },
                {
                    text: 'Edit Item Master',
                    active: true,
                }
            ],
            resource: 'ITEM MASTER',
            action: 'manage',
        },
    },
    {
        path: '/master/item-category',
        name: 'item-category',
        component: () => import('@/views/master/item-category/itemCategoryList.vue'),
        meta: {
            pageTitle: 'Item Category',
            breadcrumb: [
                {
                    text: 'Item Category',
                    active: true,
                },
            ],
            resource: 'ITEM CATEGORY',
            action: 'manage',
        },
    },
    {
        path: '/master/item-main-sub-group',
        name: 'item-main-sub-group',
        component: () => import('@/views/master/item-main-sub-group/itemMainSubGroupList.vue'),
        meta: {
            pageTitle: 'Item Main/Sub Group',
            breadcrumb: [
                {
                    text: 'Item Main/Sub Group',
                    active: true,
                },
            ],
            resource: 'MAIN GROUP/SUB GROUP',
            action: 'manage',
        },
    },
    {
        path: '/master/item-hsn-sac-code',
        name: 'item-hsn-sac-code',
        component: () => import('@/views/master/item-hsn-sac-code/hsnSacMaster.vue'),
        meta: {
            pageTitle: 'HSN/SAC Master',
            breadcrumb: [
                {
                    text: 'HSN/SAC Master',
                    active: true,
                },
            ],
            resource: 'HSN/SAC MASTER',
            action: 'manage',
        },
    },
    {
        path: '/master/add-hsn-sac-code',
        name: 'add-hsn-sac-code',
        component: () => import('@/views/master/item-hsn-sac-code/AddHsnSacMaster.vue'),
        meta: {
            pageTitle: 'Create HSN/SAC Master',
            breadcrumb: [
                {
                    text: 'HSN/SAC Master',
                    to: { name: 'item-hsn-sac-code' },
                },
                {
                    text: 'Create HSN/SAC Master',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/master/edit-hsn-sac-code/:id',
        name: 'edit-hsn-sac-code',
        component: () => import('@/views/master/item-hsn-sac-code/EditHsnSacMaster.vue'),
        meta: {
            pageTitle: 'Edit HSN/SAC Master',
            breadcrumb: [
                {
                    text: 'HSN/SAC Master',
                    to: { name: 'item-hsn-sac-code' },
                },
                {
                    text: 'Edit HSN/SAC Master',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/master/item-group-master',
        name: 'item-group-master',
        component: () => import('@/views/master/item-group-master/itemGroupMaster.vue'),
        meta: {
            pageTitle: 'Item Group Master',
            breadcrumb: [
                {
                    text: 'Item Group Master',
                    active: true,
                },
            ],
            resource: 'ITEM GROUP',
            action: 'manage',
        },
    },
    {
        path: '/master/add-item-group-master',
        name: 'add-item-group-master',
        component: () => import('@/views/master/item-group-master/AddItemGroupMaster.vue'),
        meta: {
            pageTitle: 'Create Item Group',
            breadcrumb: [
                {
                    text: 'Item Group Master',
                    to: { name: 'item-group-master' },
                },
                {
                    text: 'Create Item Group',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/master/edit-item-group-master/:id',
        name: 'edit-item-group-master',
        component: () => import('@/views/master/item-group-master/EditItemGroupMaster.vue'),
        meta: {
            pageTitle: 'Edit Item Group Master',
            breadcrumb: [
                {
                    text: 'Item Group Master',
                    to: { name: 'item-group-master' },
                },
                {
                    text: 'Edit Item Group Master',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/master/item-addon-type',
        name: 'item-addon-type',
        component: () => import('@/views/master/item-addon-type/itemAddonTypeList.vue'),
        meta: {
            pageTitle: 'Item Addon Type',
            breadcrumb: [
                {
                    text: 'Item Addon Type',
                    active: true,
                },
            ],
            resource: 'ADDON TYPE',
            action: 'manage',
        },
    },
    {
        path: '/master/item-addon-detail',
        name: 'item-addon-detail',
        component: () => import('@/views/master/item-addon-detail/itemAddonDetailList.vue'),
        meta: {
            pageTitle: 'Item Addon Detail',
            breadcrumb: [
                {
                    text: 'Item Addon Detail',
                    active: true,
                },
            ],
            resource: 'ADDON DETAILS',
            action: 'manage',
        },
    },
    {
        path: '/master/item-sales-target-group',
        name: 'item-sales-target-group',
        component: () => import('@/views/master/item-sales-target-group/itemSaleTargetGroupList.vue'),
        meta: {
            pageTitle: 'Item Sales Target Group',
            breadcrumb: [
                {
                    text: 'Item Sales Target Group',
                    active: true,
                },
            ],
            resource: 'SALES TARGET ITEM GROUP',
            action: 'manage'
        },
    },
    {
        path: '/master/term-condition-group-master',
        name: 'term-condition-group-master',
        component: () => import('@/views/master/term-condition-group-master/TermsConditionGroupList.vue'),
        meta: {
            pageTitle: 'Terms Condition Group',
            breadcrumb: [
                {
                    text: 'Terms Condition Group',
                    active: true,
                },
            ],
            resource: 'TERM & CONDITION GROUP',
            action: 'manage'
        },
    },
    {
        path: '/master/term-condition-detail-master',
        name: 'term-condition-detail-master',
        component: () => import('@/views/master/term-condition-detail-master/termsConditionDetailsList.vue'),
        meta: {
            pageTitle: 'Terms Condition Detail',
            breadcrumb: [
                {
                    text: 'Terms Condition Detail',
                    active: true,
                },
            ],
            resource: 'TERM & CONDITION DETAILS',
            action: 'manage'
        },
    },
    {
        path: '/default-term-condition-master',
        name: 'default-term-condition-master',
        component: () => import('@/views/master/default-term-condition-master/defaultTermConditionList.vue'),
        meta: {
            pageTitle: 'Default Terms Condition',
            breadcrumb: [
                {
                    text: 'Default Terms Condition',
                    active: true,
                },
            ],
            resource: 'DEFAULT TERM & CONDITION',
            action: 'manage'
        },
    },
    {
        path: '/add-default-term-condition-master',
        name: 'add-default-term-condition-master',
        component: () => import('@/views/master/default-term-condition-master/defaultTermConditionAdd.vue'),
        meta: {
            pageTitle: 'Default Terms Condition',
            breadcrumb: [
                {
                    text: 'Default Terms Condition',
                    to: { name: 'default-term-condition-master' },
                },
                {
                    text: 'Add',
                    active: true,
                },
            ],
            resource: 'DEFAULT TERM & CONDITION',
            action: 'manage'
        },
    },
    {
        path: '/edit-default-term-condition-master/:id',
        name: 'edit-default-term-condition-master',
        component: () => import('@/views/master/default-term-condition-master/defaultTermConditionEdit.vue'),
        meta: {
            pageTitle: ' Default Terms Condition Master',
            breadcrumb: [
                {
                    text: 'Default Terms Condition Master',
                    to: { name: 'default-term-condition-master' }
                },
                {
                    text: 'Edit',
                    active: true,
                },
            ],
            resource: 'DEFAULT TERM & CONDITION',
            action: 'manage'
        },
    },
    {
        path: '/master/term-condition-template-master',
        name: 'term-condition-template-master',
        component: () => import('@/views/master/term-condition-template-master/termsConditionTemplateList.vue'),
        meta: {
            pageTitle: 'Terms Condition Template Master',
            breadcrumb: [
                {
                    text: 'Terms Condition Template',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/master/add-term-condition-template-master',
        name: 'add-term-condition-template-master',
        component: () => import('@/views/master/term-condition-template-master/termsConditionTemplateAddNew.vue'),
        meta: {
            pageTitle: 'Terms & Condition Template',
            breadcrumb: [
                {
                    text: 'Terms & Condition Template',
                    to: { name: 'term-condition-template-master' },
                },
                {
                    text: 'Add',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/master/edit-term-condition-template-master/:id',
        name: 'edit-term-condition-template-master',
        component: () => import('@/views/master/term-condition-template-master/termsConditionTemplateEdit.vue'),
        meta: {
            pageTitle: 'Terms & Condition Template',
            breadcrumb: [
                {
                    text: 'Terms & Condition Template',
                    to: { name: 'term-condition-template-master' },
                },
                {
                    text: 'Edit',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/master/tax-master',
        name: 'tax-master',
        component: () => import('@/views/master/tax-master/taxMasterList.vue'),
        meta: {
            pageTitle: 'Tax Master',
            breadcrumb: [
                {
                    text: 'Tax Master',
                    active: true,
                },
            ],
            resource: 'TAX MASTER',
            action: 'manage'
        },
    },
    {
        path: '/master/tax-forms-master',
        name: 'tax-forms-master',
        component: () => import('@/views/master/tax-forms-master/taxFormsMasterList.vue'),
        meta: {
            pageTitle: 'Tax Forms Master',
            breadcrumb: [
                {
                    text: 'Tax Forms Master',
                    active: true,
                },
            ],
            resource: 'TAX FORMS',
            action: 'manage'
        },
    },
    {
        path: '/master/duty-drawback-master',
        name: 'duty-drawback-master',
        component: () => import('@/views/master/duty-drawback-master/dutyDrawbackMasterList.vue'),
        meta: {
            pageTitle: 'Duty DrawBack Master',
            breadcrumb: [
                {
                    text: 'Duty DrawBack Master',
                    active: true,
                },
            ],
            resource: 'DUTY DRAWBACK TARIFF MASTER',
            action: 'manage'
        },
    },
    {
        path: '/master/ios-api-doc-master',
        name: 'ios-api-doc-master',
        component: () => import('@/views/master/ios-api-doc-master/isoApiDocMasterList.vue'),
        meta: {
            pageTitle: 'ISO/API Document Master',
            breadcrumb: [
                {
                    text: 'ISO/API Document Master',
                    active: true,
                },
            ],
            resource: 'ISO/API DOCUMENT',
            action: 'manage'
        },
    },
    {
        path: '/master/task-master',
        name: 'task-master',
        component: () => import('@/views/master/task-master/taskMasterList.vue'),
        meta: {
            pageTitle: 'Task Master',
            breadcrumb: [
                {
                    text: 'Task Master',
                    active: true,
                },
            ],
            resource: 'TASK MANAGER',
            action: 'manage'
        },
    },
    {
        path: '/master/progress-stage-master',
        name: 'progress-stage-master',
        component: () => import('@/views/master/progress-stage-master/progressStageMasterList.vue'),
        meta: {
            pageTitle: 'Progress Stage Master',
            breadcrumb: [
                {
                    text: 'Progress Stage Master',
                    active: true,
                },
            ],
            resource: 'PROGRESS STAGE MASTER',
            action: 'manage'
        },
    },
    {
        path: '/master/billing-description-master',
        name: 'billing-description-master',
        component: () => import('@/views/master/billing-master/billingMasterList.vue'),
        meta: {
            pageTitle: 'Billing Description Master',
            breadcrumb: [
                {
                    text: 'Billing Description Master',
                    active: true,
                },
            ],
            resource: 'BILLING DESCRIPTION MASTER',
            action: 'manage'
        },
    },
    {
        path: '/master/billing-template-master',
        name: 'billing-template-master',
        component: () => import('@/views/master/billing-template-master/billingTemplateMasterList.vue'),
        meta: {
            pageTitle: 'Billing Template Master',
            breadcrumb: [
                {
                    text: 'Billing Template Master',
                    active: true,
                },
            ],
            resource: 'BILLING TEMPLATE MASTER',
            action: 'manage'
        },
    },
    {
        path: '/master/add-billing-template-master',
        name: 'add-billing-template-master',
        component: () => import('@/views/master/billing-template-master/billingTemplateMasterAdd.vue'),
        meta: {
            pageTitle: 'Add Billing Template Master',
            breadcrumb: [
                {
                    text: 'Billing Template Master',
                    to: { name: 'billing-template-master' },
                },
                {
                    text: 'Add',
                    active: true,
                },
            ],
            resource: 'BILLING TEMPLATE MASTER',
            action: 'manage'
        },
    },
    {
        path: '/master/edit-billing-template-master/:id',
        name: 'edit-billing-template-master',
        component: () => import('@/views/master/billing-template-master/billingTemplateMasterEdit.vue'),
        meta: {
            pageTitle: 'Edit Billing Template Master',
            breadcrumb: [
                {
                    text: 'Billing Template Master',
                    to: { name: 'billing-template-master' },
                },
                {
                    text: 'Edit',
                    active: true,
                },
            ],
            resource: 'BILLING TEMPLATE MASTER',
            action: 'manage'
        },
    },
    {
        path: '/master/invoice-type-master',
        name: 'invoice-type-master',
        component: () => import('@/views/master/invoice-type-master/invoiceTypeMaster.vue'),
        meta: {
            pageTitle: 'Invoice Type Master',
            breadcrumb: [
                {
                    text: 'Invoice Type Master',
                    active: true,
                },
            ],
            resource: 'INVOICE TYPE MASTER',
            action: 'manage'
        },
    },
    {
        path: '/master/add-invoice-type-master',
        name: 'add-invoice-type-master',
        component: () => import('@/views/master/invoice-type-master/AddInvoiceTypeMaster.vue'),
        meta: {
            pageTitle: 'Create Invoice Type Master',
            breadcrumb: [
                {
                    text: 'Invoice Type Master',
                    to: { name: 'invoice-type-master' },
                },
                {
                    text: 'Add Invoice Type',
                    active: true,
                },
            ],
            resource: 'INVOICE TYPE MASTER',
            action: 'manage'
        },
    },
    {
        path: '/master/edit-invoice-type-master/:id',
        name: 'edit-invoice-type-master',
        component: () => import('@/views/master/invoice-type-master/EditInvoiceTypeMaster.vue'),
        meta: {
            pageTitle: 'Edit Invoice Type Master',
            breadcrumb: [
                {
                    text: 'Invoice Type Master',
                    to: { name: 'invoice-type-master' },
                },
                {
                    text: 'Edit Type',
                    active: true,
                },
            ],
            resource: 'INVOICE TYPE MASTER',
            action: 'manage'
        },
    },
    {
        path: '/master/sales-order-type-master',
        name: 'sales-order-type-master',
        component: () => import('@/views/master/sales-order-type-master/salesOrderTypeMaster.vue'),
        meta: {
            pageTitle: 'Sales Order Type Master',
            breadcrumb: [
                {
                    text: 'Sales Order Type Master',
                    active: true,
                },
            ],
            resource: 'SALES ORDER TYPE MASTER',
            action: 'manage'
        },
    },
    {
        path: '/master/add-sales-order-type-master',
        name: 'add-sales-order-type-master',
        component: () => import('@/views/master/sales-order-type-master/AddSalesOrderTypeMaster.vue'),
        meta: {
            pageTitle: 'Create Sales Order Type Master',
            breadcrumb: [
                {
                    text: 'Sales Order Type Master',
                    to: { name: 'sales-order-type-master' },
                },
                {
                    text: 'Add SO Type',
                    active: true,
                },
            ],
            resource: 'SALES ORDER TYPE MASTER',
            action: 'manage'
        },
    },
    {
        path: '/master/edit-sales-order-type-master/:id',
        name: 'edit-sales-order-type-master',
        component: () => import('@/views/master/sales-order-type-master/EditSalesOrderTypeMaster.vue'),
        meta: {
            pageTitle: 'Edit Sales Order Type Master',
            breadcrumb: [
                {
                    text: 'Sales Order Type Master',
                    to: { name: 'sales-order-type-master' },
                },
                {
                    text: 'Edit SO Type',
                    active: true,
                },
            ],
            resource: 'SALES ORDER TYPE MASTER',
            action: 'manage'
        },
    },
    {
        path: '/master/serial-master',
        name: 'serial-master',
        component: () => import('@/views/master/serial-master/serialMasterList.vue'),
        meta: {
            pageTitle: 'Serial Master',
            breadcrumb: [
                {
                    text: 'List',
                    active: true,
                },
            ],
            resource: 'SERIAL MASTER',
            action: 'manage'
        },
    },
    {
        path: '/master/party-master-import',
        name: 'party-master-import',
        component: () => import('@/views/master/party-master/PartyMasterImport.vue'),
        meta: {
            pageTitle: 'Party Master',
            breadcrumb: [
                {
                    text: 'Party Master Import',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/master/item-master-import',
        name: 'item-master-import',
        component: () => import('@/views/master/item-master/itemMasterImport'),
        meta: {
            pageTitle: 'Item Master',
            breadcrumb: [
                {
                    text: 'Item Master Import',
                    active: true,
                },
            ],
        },
    },
]
