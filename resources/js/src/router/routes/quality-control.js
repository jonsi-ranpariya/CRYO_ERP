export default [
    {
        path: '/inward-quality-control',
        name: 'inward-quality-control',
        component: () => import('@/views/quality-control/inward-quality-control/inwardQualityControlList.vue'),
        meta: {
            pageTitle: 'Inward Quality Control',
            breadcrumb: [
                {
                    text: 'Inward Quality Control',
                    active: true,
                },
            ],
            resource: 'INWARD QC',
            action: 'manage'
        },
    },
    {
        path: '/add-inward-quality-control',
        name: 'add-inward-quality-control',
        component: () => import('@/views/quality-control/inward-quality-control/inwardQualityControlAdd.vue'),
        meta: {
            pageTitle: 'Inward Quality Control',
            breadcrumb: [
                {
                    text: 'Inward Quality Control',
                    to: {name: 'inward-quality-control'},
                },
                {
                    text: 'Add',
                    active: true,
                },
            ],
            resource: 'INWARD QC',
            action: 'manage'
        },
    },
    {
        path: '/edit-inward-quality-control/:id',
        name: 'edit-inward-quality-control',
        component: () => import('@/views/quality-control/inward-quality-control/inwardQualityControlEdit.vue'),
        meta: {
            pageTitle: 'Inward Quality Control',
            breadcrumb: [
                {
                    text: 'Inward Quality Control',
                    to: {name: 'inward-quality-control'},
                },
                {
                    text: 'Edit',
                    active: true,
                },
            ],
            resource: 'INWARD QC',
            action: 'manage'
        },
    },
    {
        path: '/finished-good-quality-control',
        name: 'finished-good-quality-control',
        component: () => import('@/views/quality-control/finished-good-quality-control/finishedGoodQualityControlList.vue'),
        meta: {
            pageTitle: 'Finished Good Quality Control',
            breadcrumb: [
                {
                    text: 'Finished Good Quality Control',
                    active: true
                },
            ],
            resource: 'FINISH GOOD QC',
            action: 'manage'
        },
    },
    {
        path: '/add-finished-good-quality-control',
        name: 'add-finished-good-quality-control',
        component: () => import('@/views/quality-control/finished-good-quality-control/finishedGoodQualityControlAdd.vue'),
        meta: {
            pageTitle: 'Finished Good Quality Control',
            breadcrumb: [
                {
                    text: 'Finished Good Quality Control',
                    to: {name: 'finished-good-quality-control'},
                },
                {
                    text: 'Add',
                    active: true,
                },
            ],
            resource: 'FINISH GOOD QC',
            action: 'manage'
        },
    },
    {
        path: '/edit-finished-good-quality-control/:id',
        name: 'edit-finished-good-quality-control',
        component: () => import('@/views/quality-control/finished-good-quality-control/finishedGoodQualityControlEdit.vue'),
        meta: {
            pageTitle: 'Finished Good Quality Control',
            breadcrumb: [
                {
                    text: 'Finished Good Quality Control',
                    to: {name: 'finished-good-quality-control'},
                },
                {
                    text: 'Edit',
                    active: true,
                },
            ],
            resource: 'FINISH GOOD QC',
            action: 'manage'
        },
    },
    {
        path: '/work-order-sub-assembly-qc',
        name: 'work-order-sub-assembly-qc',
        component: () => import('@/views/quality-control/work-order-sub-assembly-qc/workOrderSubAssemblyQcList.vue'),
        meta: {
            pageTitle: 'Work Order Sub-Assembly QC',
            breadcrumb: [
                {
                    text: 'Work Order Sub-Assembly QC',
                    active: true,
                },
            ],
            resource: 'WORK ORDER SUB-ASSEMBLY QC',
            action: 'manage'
        },
    },
    {
        path: '/add-work-order-sub-assembly-qc',
        name: 'add-work-order-sub-assembly-qc',
        component: () => import('@/views/quality-control/work-order-sub-assembly-qc/workOrderSubAssemblyQcAdd.vue'),
        meta: {
            pageTitle: 'Work Order Sub-Assembly QC',
            breadcrumb: [
                {
                    text: 'WO Sub-Assembly QC',
                    to: {name: 'work-order-sub-assembly-qc'},
                },
                {
                    text: 'ADD',
                    active: true,
                },
            ],
            resource: 'WORK ORDER SUB-ASSEMBLY QC',
            action: 'manage'
        },
    },
    {
        path: '/edit-work-order-sub-assembly-qc/:id',
        name: 'edit-work-order-sub-assembly-qc',
        component: () => import('@/views/quality-control/work-order-sub-assembly-qc/workOrderSubAssemblyQcEdit.vue'),
        meta: {
            pageTitle: 'Work Order Sub-Assembly QC',
            breadcrumb: [
                {
                    text: 'WO Sub-Assembly Qc',
                    to: {name: 'work-order-sub-assembly-qc'},
                },
                {
                    text: 'Edit',
                    active: true,
                },
            ],
            resource: 'WORK ORDER SUB-ASSEMBLY QC',
            action: 'manage'
        },
    },
    {
        path: '/job-card-process-inside-qc',
        name: 'job-card-process-inside-qc',
        component: () => import('@/views/quality-control/job-card-process-inside-qc/jobCardProcessInsideQcList.vue'),
        meta: {
            pageTitle: ' Job Card Process Inside QC',
            breadcrumb: [
                {
                    text: 'Job Card Process Inside QC',
                    active: true,
                },
            ],
            resource: 'JOB CARD PROCESS (IN SIDE) QC',
            action: 'manage'
        },
    },
    {
        path: '/add-job-card-process-inside-qc',
        name: 'add-job-card-process-inside-qc',
        component: () => import('@/views/quality-control/job-card-process-inside-qc/jobCardProcessInsideQcAdd.vue'),
        meta: {
            pageTitle: 'Job Card Process Inside QC',
            breadcrumb: [
                {
                    text: 'Job Card Process Inside QC',
                    to: {name: 'job-card-process-inside-qc'},
                },
                {
                    text: 'Add',
                    active: true,
                },
            ],
            resource: 'JOB CARD PROCESS (IN SIDE) QC',
            action: 'manage'
        },
    },
    {
        path: '/edit-job-card-process-inside-qc/:id',
        name: 'edit-job-card-process-inside-qc',
        component: () => import('@/views/quality-control/job-card-process-inside-qc/jobCardProcessInsideQcEdit.vue'),
        meta: {
            pageTitle: 'Job Card Process Inside QC',
            breadcrumb: [
                {
                    text: 'Job Card Process Inside QC',
                    to: {name: 'job-card-process-inside-qc'},
                },
                {
                    text: 'Edit',
                    active: true,
                },
            ],
            resource: 'JOB CARD PROCESS (IN SIDE) QC',
            action: 'manage'
        },
    },
    {
        path: '/job-work-process-outside-qc',
        name: 'job-work-process-outside-qc',
        component: () => import('@/views/quality-control/job-work-process-outside-qc/jobWorkProcessOutsideQcList.vue'),
        meta: {
            pageTitle: ' Job Work Process Outside QC',
            breadcrumb: [
                {
                    text: 'Job work Process Outside QC',
                    active: true,
                },
            ],
            resource: 'JOB WORK (OUT SIDE)',
            action: 'manage'
        },
    },
    {
        path: '/add-job-work-process-outside-qc',
        name: 'add-job-work-process-outside-qc',
        component: () => import('@/views/quality-control/job-work-process-outside-qc/jobWorkProcessOutsideQcAdd.vue'),
        meta: {
            pageTitle: 'Job Work Process OutSide QC',
            breadcrumb: [
                {
                    text: 'Job Work Process OutSide QC',
                    to: {name: 'job-work-process-outside-qc'},
                },
                {
                    text: 'Add',
                    active: true,
                },
            ],
            resource: 'JOB WORK (OUT SIDE)',
            action: 'manage'
        },
    },
    {
        path: '/edit-job-work-process-outside-qc/:id',
        name: 'edit-job-work-process-outside-qc',
        component: () => import('@/views/quality-control/job-work-process-outside-qc/jobWorkProcessOutsideQcEdit.vue'),
        meta: {
            pageTitle: 'Job Work Process OutSide QC',
            breadcrumb: [
                {
                    text: 'Job Work Process OutSide QC',
                    to: {name: 'job-work-process-outside-qc'},
                },
                {
                    text: 'Edit',
                    active: true,
                },
            ],
            resource: 'JOB WORK (OUT SIDE)',
            action: 'manage'
        },
    },
]
