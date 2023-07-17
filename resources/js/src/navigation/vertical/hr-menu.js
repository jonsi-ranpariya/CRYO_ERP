export default [
    {
        title: 'HR',
        icon: 'UserIcon',
        children: [
            {
                title: 'Admin',
                children: [
                    {
                        title: 'Dashboard - Leave',
                        route: 'dashboard-leave',
                    },
                    {
                        title: 'Dashboard - Attendance',
                        toolTipText: 'Dashboard - Attendance',
                        route: 'dashboard-attendance',
                    }
                ]
            },
            {
                title: 'Leave Management',
                children: [
                    {
                        header: 'Leave',
                    },
                    {
                        title: 'Apply Leave',
                        route: 'apply-leave',
                    },
                    {
                        title: 'Apply Leave By Manager',
                        toolTipText: 'Apply Leave By Manager',
                        route: 'apply-leave-by-manager',
                    },
                    {
                        title: 'Approve Leave',
                        route: 'approve-leave',
                    },
                    {
                        title: 'Cancellation Leave',
                        route: 'cancellation-leave',
                    },
                    {
                        title: 'Cancellation Leave – HR',
                        toolTipText: 'Cancellation Leave – HR',
                        route: 'cancellation-leave-hr',
                    },
                    {
                        title: 'Dashboard - Manager',
                        toolTipText: 'Dashboard - Manager',
                        route: 'dashboard-manager'
                    },
                    {
                        header: 'Outdoor Duty',
                    },
                    {
                        title: 'Apply Outdoor Duty',
                        toolTipText: 'Apply Outdoor Duty',
                        route: 'apply-outdoor-duty',
                    },
                    {
                        title: 'Apply Outdoor Duty By Manager',
                        toolTipText: 'Apply Outdoor Duty By Manager',
                        route: 'apply-outdoor-duty-by-manager',
                    },
                    {
                        title: 'Approve Outdoor Duty',
                        toolTipText: 'Approve Outdoor Duty',
                        route: 'approve-outdoor-duty',
                    },
                    {
                        title: 'Cancellation Outdoor Duty',
                        toolTipText: 'Cancellation Outdoor Duty',
                        route: 'cancellation-outdoor-duty',
                    },
                    {
                        title: 'Outdoor Duty Report - Manager',
                        toolTipText: 'Outdoor Duty Reports - Manager',
                        route: 'reports-outdoor-duty-manager',
                    },
                    {
                        title: 'Outdoor Duty Report - HR',
                        toolTipText: 'Reports Outdoor Duty - HR',
                        route: 'reports-outdoor-duty-hr',
                    },
                    {
                        header: 'Leave Encashment',
                    },
                    {
                        title: 'Apply Leave Encashment',
                        toolTipText: 'Apply Leave Encashment',
                        route: 'apply-leave-encashment',
                    },
                    {
                        title: 'Approve Leave Encashment',
                        toolTipText: 'Approve Leave Encashment',
                        route: 'approve-leave-encashment',
                    },
                    {
                        title: 'Leave Encashment Report - Manager',
                        toolTipText: 'Leave Encashment Report - Manager',
                        route: 'reports-leave-encashment-manager',
                    },
                    {
                        title: 'Leave Encashment Report - HR',
                        toolTipText: 'Leave Encashment Report - HR',
                        route: 'reports-leave-encashment-hr',
                    },
                    // {
                    //     header: 'Leave Adjustment',
                    // },
                    // {
                    //     title: 'Add/Entry Leave Adjustment',
                    //     toolTipText: 'Add/Entry Leave Adjustment',
                    //     route: 'entry-leave-adjustment',
                    // },
                    // {
                    //     title: 'Request Leave Adjustment',
                    //     toolTipText: 'Request Leave Adjustment',
                    //     route: null,
                    // },
                    // {
                    //     title: 'Request Leave Adjustment By Manager',
                    //     toolTipText: 'Request Leave Adjustment By Manager',
                    //     route: null,
                    // },
                    // {
                    //     title: 'Approve Leave Adjustment',
                    //     toolTipText: 'Approve Leave Adjustment',
                    //     route: null,
                    // },
                    // {
                    //     title: 'Leave Adjustment Report',
                    //     toolTipText: 'Leave Adjustment Report',
                    //     route: null,
                    // },
                    {
                        header: 'Configuration',
                    },
                    {
                        title: 'Leave Notes',
                        toolTipText: 'Leave Notes',
                        route: 'leave-notes',
                    },
                    {
                        title: 'Leave Encashment Rules',
                        toolTipText: 'Leave Encashment Rules',
                        route: 'leave-encashment-rules',
                    },
                    {
                        title: 'Leave Category Master',
                        toolTipText: 'Leave Category Master',
                        route: 'leave-category-master',
                    },
                    {
                        title: 'Leave Application Import',
                        toolTipText: 'Leave Application Import',
                        route: 'leave-application-import',
                    }
                ],
            },
            {
                title: 'Leave Reports',
                children: [
                    {
                        title: 'Leave - Manager Report',
                        toolTipText: 'Leave - Manager Report',
                        route: 'report-leave-manager',
                    },
                    {
                        title: 'Leave Report - HR',
                        route: 'report-leave-hr',
                    },
                    {
                        title: 'Balance Leave Report - Manager',
                        toolTipText: 'Balance Leave Report - Manager',
                        route: 'balance-report-leave-manager',
                    },
                    {
                        title: 'Balance Leave Report - HR',
                        toolTipText: 'Balance Leave Report - HR',
                        route: 'balance-report-leave-hr',
                    },
                    {
                        title: 'Leave Register Report – Manager',
                        toolTipText: 'Leave Register Report – Manager',
                        route: 'leave-register-report-manager',
                    },
                    {
                        title: 'Leave Register Report – HR',
                        toolTipText: 'Leave Register Report – HR',
                        route: 'leave-register-report-hr',
                    },
                ],
            },
            {
                header: 'Time Management',
            },
            {
                title: 'Define',
                children: [
                    {
                        title: 'Shift Definition',
                        route: 'shift-definition',
                    },
                    {
                        title: 'Holiday Master',
                        route: 'holiday-master',
                    },
                    {
                        title: 'Attendance Type',
                        toolTipText: 'Attendance Type',
                        route: 'attendance-type',
                    },
                    {
                        title: 'Publish Holiday Calendar',
                        toolTipText: 'Publish Holiday Calendar',
                        route: 'publish-holiday-calendar',
                    },
                    {
                        title: 'Card Punch Setup',
                        toolTipText: 'Card Punch Setup',
                        route: 'card-punch-setup',
                    },
                    {
                        title: 'Weekly Off',
                        route: 'weekly-off',
                    },
                    /*{
                        title: 'Swipe Request Category',
                        toolTipText: 'Swipe Request Category',
                        route: null,
                    },*/
                    {
                        title: 'Attendance Group',
                        toolTipText: 'Attendance Group',
                        route: 'attendance-group',
                    },
                ],
            },
            {
                title: 'Attendance',
                children: [
                    {
                        title: 'My Attendance',
                        route: 'my-attendance',
                    },
                    {
                        title: 'View Attendance - Manager',
                        toolTipText: 'View Attendance - Manager',
                        route: 'view-attendance-manager',
                    },
                    {
                        title: 'View Attendance - HR',
                        toolTipText: 'View Attendance - HR',
                        route: 'view-attendance-hr',
                    },
                    {
                        title: 'Dashboard - Manager',
                        toolTipText: 'Dashboard - Manager',
                        route: 'dashboard-attendance-manager',
                    },
                    {
                        title: 'Daily Attendance - Manager',
                        toolTipText: 'Daily Attendance - Manager',
                        route: 'daily-attendance-manager',
                    },
                    {
                        title: 'Monthly Attendance - Manager',
                        toolTipText: 'Monthly Attendance - Manager',
                        route: 'monthly-attendance-manager',
                    },
                    {
                        title: 'Monthly Attendance - HR',
                        toolTipText: 'Monthly Attendance - HR',
                        route: 'monthly-attendance-hr',
                    },
                    {
                        title: 'Muster Generation - Manager',
                        toolTipText: 'Muster Generation - Manager',
                        route: 'muster-generation-manager',
                    },
                    {
                        title: 'Muster Generation - HR',
                        toolTipText: 'Muster Generation - HR',
                        route: 'muster-generation-hr',
                    },
                    {
                        title: 'Import Daily Attendance',
                        toolTipText: 'Import Daily Attendance',
                        route: 'import-daily-attendance',
                    },
                ]
            },
            {
                title: 'Shift',
                children: [
                    {
                        title: 'Roster - Manager',
                        toolTipText: 'Roster - Manage',
                        route: 'roster-manager',
                    },
                    {
                        title: 'Roster - HR',
                        route: 'roster-hr',
                    },
                    {
                        title: 'Bulk Transfer By Manager',
                        toolTipText: 'Bulk Transfer By Manager',
                        route: 'bulk-transfer-by-manager',
                    },
                    {
                        title: 'Transfer By HR',
                        route: 'transfer-by-hr',
                    },
                    {
                        title: 'Report - Manager',
                        toolTipText: 'Report - Manager',
                        route: 'manager-report',
                    },
                    {
                        title: 'Report - HR',
                        route: 'hr-report',
                    }
                ]
            },
            {
                title: 'Shift Change',
                children: [
                    {
                        title: 'Request',
                        route: 'shift-change-request',
                    },
                    {
                        title: 'Approve',
                        route: 'shift-change-approve',
                    },
                    {
                        title: 'Reports - Manager',
                        toolTipText: 'Reports - Manager',
                        route: 'shift-change-manager-report',
                    },
                    {
                        title: 'Reports - HR',
                        route: 'shift-change-hr-report',
                    }
                ]
            },
            {
                title: 'Shift Roster',
                children: [
                    {
                        title: 'Import Roster',
                        route: 'import-roster',
                    },
                    {
                        title: 'Import Roster - Manager',
                        toolTipText: 'Import Roster - Manager',
                        route: 'import-roster-manager',
                    }

                ]
            },
            {
                title: 'Attendance Reports',
                children: [
                    {
                        title: 'Continuous Absent List Report',
                        toolTipText: 'Continuous Absent List Report',
                        route: 'continuous-absent-list-report',
                    },
                    {
                        title: 'Muster Report Writer',
                        toolTipText: 'Muster Report Writer',
                        route: 'muster-writer-report',
                    },
                    {
                        title: 'Muster Report Writer Grouping',
                        toolTipText: 'Continuous Absent List Report',
                        route: 'muster-writer-grouping-report',
                    },
                    {
                        title: 'Attendance Summary Report',
                        toolTipText: 'Attendance Summary Report',
                        route: 'attendance-summary-report',
                    },
                    {
                        title: 'Daywise Attendance Muster',
                        toolTipText: 'Continuous Absent List Report',
                        route: 'daywise-attendance-muster',
                    },
                    {
                        title: 'Reports - Manager',
                        route: 'attendance-manger-reports',
                    },
                    {
                        title: 'Reports - HR',
                        route: 'attendance-hr-reports',
                    },
                    {
                        title: 'Analysis Reports',
                        route: 'analysis-reports',
                    }
                ]
            },
            {
                title: 'Attendance Utilities',
                children: [
                    {
                        title: 'Attendance Muster Advance',
                        toolTipText: 'Attendance Muster Advance',
                        route: 'attendance-muster-advance',
                    },
                    {
                        title: 'Recalculation Muster',
                        toolTipText: 'Recalculation Muster',
                        route: 'recalculation-muster',
                    },
                    {
                        title: 'Muster Update - Bulk',
                        toolTipText: 'Muster Update Bulk',
                        route: 'muster-update-bulk',
                    },
                    {
                        title: 'Monthly Summary Generation',
                        toolTipText: 'Monthly Summary Generation',
                        route: 'monthly-summary-generation',
                    },
                    {
                        title: 'Monthly Summary Report',
                        toolTipText: 'Monthly Summary Report',
                        route: 'monthly-summary-report',
                    },
                    {
                        title: 'Data Deletion',
                        route: 'data-deletion',
                    },
                    {
                        title: 'Lock Data - Unlock Data',
                        toolTipText: 'Lock Data - Unlock Data',
                        route: 'lock-data-unlock-data',
                    },
                    {
                        title: 'Mark - Revoke InOut as X - HR',
                        toolTipText: 'Mark - Revoke InOut as X - HR',
                        route: 'mark-revoke-inout-x-hr',
                    },
                    {
                        title: 'Mark - Revoke InOut as X - Manager Reconciliation',
                        toolTipText: 'Mark - Revoke InOut as X - Manager Reconciliation',
                        route: 'mark-revoke-inout-x-manager',
                    },
                    {
                        title: 'Reconciliation',
                        route: 'reconciliation',
                    },
                    // {
                    //     title: 'Assign Swipe Date - HR',
                    //     toolTipText: 'Assign Swipe Date - HR',
                    //     route: 'assign-swipe-date-hr',
                    // },
                    // {
                    //     title: 'Assign Swipe Date - Manager',
                    //     toolTipText: 'Assign Swipe Date - Manager',
                    //     route: 'assign-swipe-date-manager',
                    // },
                    {
                        title: 'MISC Utilities',
                        route: 'misc-utilities',
                    },
                ]
            },


        ],
    },

]
