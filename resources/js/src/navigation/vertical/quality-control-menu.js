export default [
    {
        title: 'Quality Control',
        icon: 'CheckSquareIcon',
        children: [
            {
                title: 'Inward QC',
                route: 'inward-quality-control',
                resource: 'INWARD QC',
                action: 'manage'
            },
            {
                title: 'Finished Goods QC',
                route: 'finished-good-quality-control',
                resource: 'FINISH GOOD QC',
                action: 'manage'
            },
            {
                title: 'Work Order Sub-Assembly QC',
                toolTipText: 'Work Order Sub-Assembly QC',
                route: 'work-order-sub-assembly-qc',
                resource: 'WORK ORDER SUB-ASSEMBLY QC',
                action: 'manage'
            },
            {
                title: 'Assembly Card QC',
                route: null,
                resource: 'ASSEMBLY CARD QC',
                action: 'manage'
            },
            {
                title: 'Job Card Process (In Side) QC',
                toolTipText: 'Job Card Process (In Side) QC',
                route: 'job-card-process-inside-qc',
                resource: 'JOB CARD PROCESS (IN SIDE) QC',
                action: 'manage'
            },
            {
                title: 'Job Work (Out Side) QC',
                route: 'job-work-process-outside-qc',
                resource: 'JOB WORK (OUT SIDE)',
                action: 'manage'
            },
            {
                title: 'Mat Return From Job Card QC',
                toolTipText: 'Material Return From Job Card QC',
                route: null,
                resource: 'MATERIAL RETURN FROM JOB CARD QC',
                action: 'manage'
            },
            {
                title: 'Mat Return From Sub-Contractor QC',
                toolTipText: 'Material Return From Sub-Contractor QC',
                route: null,
                resource: 'MATERIAL RETURN FROM SUB-CONTRACTOR QC',
                action: 'manage'
            },
            {
                title: 'Inward QC Modification',
                toolTipText: 'Inward QC Modification',
                route: null,
                resource: 'INWARD QC MODIFICATION',
                action: 'manage'
            },
            {
                title: 'Finish Goods QC Modification',
                toolTipText: 'Finish Goods QC Modification',
                route: null,
                resource: 'FINISH GOODS QC MODIFICATION',
                action: 'manage'
            },
            {
                title: 'Job Work (Out Side) QC Modification',
                toolTipText: 'Job Work (Out Side) QC Modification',
                route: null,
                resource: 'JOB WORK (OUT SIDE) QC MODIFICATION',
                action: 'manage'
            },
            {
                title: 'Finished Goods QC Against SO',
                toolTipText: 'Finished Goods QC Against SO',
                route: null,
                resource: 'FINISH GOODS QC AGAINST SO',
                action: 'manage'
            },
            {
                title: 'Instrument Category',
                route: null,
                resource: 'INSTRUMENT CATEGORY',
                action: 'manage'
            },
            {
                title: 'Instrument Master',
                route: null,
                resource: 'INSTRUMENT MASTER',
                action: 'manage'
            },
            {
                title: 'Issue Instruments',
                route: null,
                resource: 'ISSUE INSTRUMENTS',
                action: 'manage'
            },
            {
                title: 'Jigs & Fixtures Category',
                toolTipText: 'Jigs & Fixtures Category',
                route: null,
                resource: 'JIGS & FIXTURES CATEGORY',
                action: 'manage'
            },
            {
                title: 'Jigs & Fixtures Master',
                toolTipText: 'Jigs & Fixtures Master',
                route: null,
                resource: 'JIGS & FIXTURES MASTER',
                action: 'manage'
            },
            {
                title: 'Raw Material TC',
                route: null,
                resource: 'RAW MATERIAL TC',
                action: 'manage'
            },
            {
                title: 'Job Card Inside TC',
                route: null,
                resource: 'JOB CARD INSIDE TC',
                action: 'manage'
            },
            {
                title: 'Job Card OutSide TC',
                route: null,
                resource: 'JOB CARD OUTSIDE TC',
                action: 'manage'
            },
            {
                title: 'Work Order Rejected Items',
                toolTipText: 'Work Order Rejected Items',
                route: null,
                resource: 'WORK ORDER REJECTED ITEMS',
                action: 'manage'
            },
            {
                title: 'Routine Test',
                route: null,
                resource: 'ROUTINE TEST',
                action: 'manage'
            },
            {
                title: 'Traction Machine Test',
                toolTipText: 'Traction Machine Test',
                route: null,
                resource: 'TRANSACTION MACHINE TEST',
                action: 'manage'
            },
            {
                title: 'Job Card Multiple Rejection Reason',
                toolTipText: 'Job Card Multiple Rejection Reason',
                route: null,
            },
            {
                title: 'QC Reports',
                children: [
                    {
                        title: 'Inward QC Reports',
                        route: null,
                        resource: 'QC REPORTS',
                        action: 'manage'
                    },
                    {
                        title: 'Inward QC Summary',
                        route: null,
                        resource: 'QC REPORTS',
                        action: 'manage'
                    },
                    {
                        title: 'Finished Goods QC Summary',
                        toolTipText: 'Finished Goods QC Summary',
                        route: null,
                        resource: 'QC REPORTS',
                        action: 'manage'
                    },
                    {
                        title: 'List Of Instruments',
                        route: null,
                        resource: 'QC REPORTS',
                        action: 'manage'
                    },
                    {
                        title: 'List Of Jigs & Fixtures',
                        toolTipText: 'List Of Jigs & Fixtures',
                        route: null,
                        resource: 'QC REPORTS',
                        action: 'manage'
                    },
                    {
                        title: 'Pending Inward For QC',
                        toolTipText: 'Pending Inward For QC',
                        route: null,
                        resource: 'QC REPORTS',
                        action: 'manage'
                    },
                    {
                        title: 'Pending For QC (Job Card Inside)',
                        toolTipText: 'Pending For QC (Job Card Inside)',
                        route: null,
                        resource: 'QC REPORTS',
                        action: 'manage'
                    },
                    {
                        title: 'QC Summary (Job Card In Side)',
                        toolTipText: 'QC Summary (Job Card In Side)',
                        route: null,
                        resource: 'QC REPORTS',
                        action: 'manage'
                    },
                    {
                        title: 'QC Summary (Job Card Out Side)',
                        toolTipText: 'QC Summary (Job Card Out Side)',
                        route: null,
                        resource: 'QC REPORTS',
                        action: 'manage'
                    }
                ]
            }
        ]
    },
]
