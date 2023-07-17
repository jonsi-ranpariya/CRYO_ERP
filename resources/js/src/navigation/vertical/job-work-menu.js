export default [
    {
        title:'Job Work',
        icon:'BriefcaseIcon',
        children:[
            {
                title:'Job Work Order',
                route:'job-work-order',
                resource: 'JOB WORK ORDER',
                action: 'manage'
            },
            {
                title:'Issue (Job Work Challan)',
                toolTipText:'Issue (Job Work Challan)',
                route:'issue-job-work-challan',
                resource: 'ISSUE (JOB WORK CHALLAN)',
                action: 'manage'
            },
            {
                title:'Receipt(Job Work Challan)',
                toolTipText:'Receipt(Job Work Challan)',
                route:'receipt-job-work-challan',
                resource: 'RECEIPT (JOB WORK CHALLAN)',
                action: 'manage'
            },
            {
                title: 'Return(Rejection Memo)',
                toolTipText: 'Return(Rejection Memo)',
                route: 'return-rejection-memo',
            },
            {
                title: 'Raw Material Return From Sub-Contractor',
                toolTipText: 'Raw Material Return From Sub-Contractor',
                route: 'raw-material-return-sub-contractor',
                resource: 'RAW MATERIAL RETURN FROM SUB - CONTRACTOR',
                action: 'manage'
            },
            {
                title: 'Scrap Receipt Entry',
                route: 'scrap-receipt-entry',
                resource: 'SCRAP RECEIPT ENTRY',
                action: 'manage'
            },
            {
                title: 'Job Work ReWork Challan',
                toolTipText: 'Job Work ReWork Challan',
                route: 'job-work-rework-challan',
                resource: 'JOB WORK REWORK CHALLAN',
                action: 'manage'
            },
            {
                title: 'Job Work ReWork Receipt',
                toolTipText: 'Job Work ReWork Receipt',
                route: 'job-work-rework-receipt',
                resource: 'JOB WORK REWORK RECEIPT',
                action: 'manage'
            },
            {
                title: 'Job Work Rate Master',
                toolTipText: 'Job Work Rate Master',
                route: 'job-work-rate-master',
                resource: 'JOB WORK RATE MASTER',
                action: 'manage'
            },
            {
                title: 'Sub-Contractor Rating Parameters',
                toolTipText: 'Sub-Contractor Rating Parameters',
                route: 'sub-contractor-rating-parameters',
                resource: 'SUB-CONTRACTOR RATING PARAMETERS',
                action: 'manage'
            }
        ]
    },
]
