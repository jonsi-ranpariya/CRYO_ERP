export default [
    {
        path: '/apply-leave',
        name: 'apply-leave',
        component: () => import('@/views/hr/leave-management/apply-leave/leaveList.vue'),
        meta: {
            pageTitle: 'Apply Leave',
            breadcrumb: [
                {
                    text: 'Apply Leave',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/add-leave',
        name: 'add-leave',
        component: () => import('@/views/hr/leave-management/apply-leave/leaveAdd.vue'),
        meta: {
            pageTitle: 'Leave',
            breadcrumb: [
                {
                    text: 'Leave',
                    to: {name: 'apply-leave'},
                },
                {
                    text: 'Add',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/edit-leave',
        name: 'edit-leave',
        component: () => import('@/views/hr/leave-management/apply-leave/leaveEdit.vue'),
        meta: {
            pageTitle: 'Leave',
            breadcrumb: [
                {
                    text: 'Leave',
                    to: {name: 'apply-leave'},
                },
                {
                    text: 'Edit',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/apply-leave-by-manager',
        name: 'apply-leave-by-manager',
        component: () => import('@/views/hr/leave-management/apply-leave-by-manager/applyLeaveByManagerList.vue'),
        meta: {
            pageTitle: 'Apply Leave By Manager',
            breadcrumb: [
                {
                    text: 'Apply Leave By Manager',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/add-leave-by-manager',
        name: 'add-leave-by-manager',
        component: () => import('@/views/hr/leave-management/apply-leave-by-manager/applyLeaveByManagerAdd.vue'),
        meta: {
            pageTitle: 'Leave By Manager',
            breadcrumb: [
                {
                    text: 'Leave By Manager',
                    to: {name: 'apply-leave-by-manager'},
                },
                {
                    text: 'Add',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/edit-leave-by-manager',
        name: 'edit-leave-by-manager',
        component: () => import('@/views/hr/leave-management/apply-leave-by-manager/applyLeaveByManagerEdit.vue'),
        meta: {
            pageTitle: 'Leave By Manager',
            breadcrumb: [
                {
                    text: 'Leave By Manager',
                    to: {name: 'apply-leave-by-manager'},
                },
                {
                    text: 'Edit',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/approve-leave',
        name: 'approve-leave',
        component: () => import('@/views/hr/leave-management/approve-leave/approveLeave.vue'),
        meta: {
            pageTitle: 'Approve Leave',
            breadcrumb: [
                {
                    text: 'Approve Leave',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/edit-approve-leave',
        name: 'edit-approve-leave',
        component: () => import('@/views/hr/leave-management/approve-leave/approvedLeaveEdit.vue'),
        meta: {
            pageTitle: 'Approve Leave',
            breadcrumb: [
                {
                    text: 'Approve Leave',
                    to: {name: 'approve-leave'},
                },
                {
                    text: 'Edit',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/cancellation-leave',
        name: 'cancellation-leave',
        component: () => import('@/views/hr/leave-management/cancellation-leave/cancellationLeaveList.vue'),
        meta: {
            pageTitle: 'Cancellation Leave',
            breadcrumb: [
                {
                    text: 'Cancellation Leave',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/edit-cancellation-leave',
        name: 'edit-cancellation-leave',
        component: () => import('@/views/hr/leave-management/cancellation-leave/cancellationLeaveEdit.vue'),
        meta: {
            pageTitle: 'Cancellation Leave',
            breadcrumb: [
                {
                    text: 'Cancellation Leave',
                    to: {name: 'cancellation-leave'},
                },
                {
                    text: 'Edit',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/cancellation-leave-hr',
        name: 'cancellation-leave-hr',
        component: () => import('@/views/hr/leave-management/cancellation-leave-hr/cancellationLeaveHrList.vue'),
        meta: {
            pageTitle: 'Cancellation Leave HR',
            breadcrumb: [
                {
                    text: 'Cancellation Leave HR',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/apply-outdoor-duty',
        name: 'apply-outdoor-duty',
        component: () => import('@/views/hr/leave-management/apply-outdoor-duty/applyOutdoorDutyList.vue'),
        meta: {
            pageTitle: 'Apply Outdoor Duty',
            breadcrumb: [
                {
                    text: 'Apply Outdoor Duty',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/add-outdoor-duty',
        name: 'add-outdoor-duty',
        component: () => import('@/views/hr/leave-management/apply-outdoor-duty/applyOutdoorDutyAdd.vue'),
        meta: {
            pageTitle: 'Apply Outdoor Duty',
            breadcrumb: [
                {
                    text: 'Apply Outdoor Duty',
                    to: {name: 'apply-outdoor-duty'},
                },
                {
                    text: 'Add',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/edit-outdoor-duty',
        name: 'edit-outdoor-duty',
        component: () => import('@/views/hr/leave-management/apply-outdoor-duty/applyOutdoorDutyEdit.vue'),
        meta: {
            pageTitle: 'Apply Outdoor Duty',
            breadcrumb: [
                {
                    text: 'Apply Outdoor Duty',
                    to: {name: 'apply-outdoor-duty'},
                },
                {
                    text: 'Edit',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/apply-outdoor-duty-by-manager',
        name: 'apply-outdoor-duty-by-manager',
        component: () => import('@/views/hr/leave-management/apply-outdoor-duty-by-manager/applyOutdoorDutyByManagerList.vue'),
        meta: {
            pageTitle: 'Apply Outdoor Duty By Manager',
            breadcrumb: [
                {
                    text: 'Outdoor Duty By Manager',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/add-outdoor-duty-by-manager',
        name: 'add-outdoor-duty-by-manager',
        component: () => import('@/views/hr/leave-management/apply-outdoor-duty-by-manager/applyOutdoorDutyByManagerAdd.vue'),
        meta: {
            pageTitle: 'Outdoor Duty By Manager',
            breadcrumb: [
                {
                    text: 'Outdoor Duty By Manager',
                    to: {name: 'apply-outdoor-duty-by-manager'},
                },
                {
                    text: 'Add',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/edit-outdoor-duty-by-manager',
        name: 'edit-outdoor-duty-by-manager',
        component: () => import('@/views/hr/leave-management/apply-outdoor-duty-by-manager/applyOutdoorDutyByManagerEdit.vue'),
        meta: {
            pageTitle: 'Outdoor Duty By Manager',
            breadcrumb: [
                {
                    text: 'Outdoor Duty By Manager',
                    to: {name: 'apply-outdoor-duty-by-manager'},
                },
                {
                    text: 'Edit',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/approve-outdoor-duty',
        name: 'approve-outdoor-duty',
        component: () => import('@/views/hr/leave-management/approve-outdoor-duty/approveOutdoorDuty.vue'),
        meta: {
            pageTitle: 'Approve Outdoor Duty',
            breadcrumb: [
                {
                    text: 'Approve Outdoor Duty',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/edit-approve-outdoor-duty',
        name: 'edit-approve-outdoor-duty',
        component: () => import('@/views/hr/leave-management/approve-outdoor-duty/approveOutdoorDutyEdit.vue'),
        meta: {
            pageTitle: 'Approve Outdoor Duty',
            breadcrumb: [
                {
                    text: 'Approve Outdoor Duty',
                    to: {name: 'approve-outdoor-duty'},
                },
                {
                    text: 'Edit',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/cancellation-outdoor-duty',
        name: 'cancellation-outdoor-duty',
        component: () => import('@/views/hr/leave-management/cancellation-outdoor-duty/cancellationOutdoorDutyList.vue'),
        meta: {
            pageTitle: 'Cancellation Outdoor Duty',
            breadcrumb: [
                {
                    text: 'Cancellation Outdoor Duty',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/edit-cancellation-outdoor-duty',
        name: 'edit-cancellation-outdoor-duty',
        component: () => import('@/views/hr/leave-management/cancellation-outdoor-duty/cancellationOutdoorDutyEdit.vue'),
        meta: {
            pageTitle: 'Cancellation Outdoor Duty',
            breadcrumb: [
                {
                    text: 'Cancellation Outdoor Duty',
                    to: {name: 'cancellation-outdoor-duty'},
                },
                {
                    text: 'Edit',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/outdoor-duty-report-manager',
        name: 'reports-outdoor-duty-manager',
        component: () => import('@/views/hr/leave-management/reports-outdoor-duty-manager/reportsOutdoorDutyManager.vue'),
        meta: {
            pageTitle: 'Outdoor Duty Report Manager',
            breadcrumb: [
                {
                    text: 'Outdoor Duty Report Manager',
                    active: true,
                },
            ],
        },
    },

    {
        path: '/outdoor-duty-report-hr',
        name: 'reports-outdoor-duty-hr',
        component: () => import('@/views/hr/leave-management/reports-outdoor-duty-hr/reportsOutdoorDutyHr.vue'),
        meta: {
            pageTitle: 'Outdoor Duty Report HR',
            breadcrumb: [
                {
                    text: 'Outdoor Duty Report HR',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/apply-leave-encashment',
        name: 'apply-leave-encashment',
        component: () => import('@/views/hr/leave-management/apply-leave-encashment/applyLeaveEnchashmentList.vue'),
        meta: {
            pageTitle: 'Apply Leave Encashment',
            breadcrumb: [
                {
                    text: 'Apply Leave Encashment',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/add-leave-encashment',
        name: 'add-leave-encashment',
        component: () => import('@/views/hr/leave-management/apply-leave-encashment/applyLeaveEnchashmentAdd.vue'),
        meta: {
            pageTitle: 'Apply Leave Encashment',
            breadcrumb: [
                {
                    text: 'Apply Leave Encashment',
                    to: {name: 'apply-leave-encashment'},
                },
                {
                    text: 'Add',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/edit-leave-encashment',
        name: 'edit-leave-encashment',
        component: () => import('@/views/hr/leave-management/apply-leave-encashment/applyLeaveEncashmentEdit.vue'),
        meta: {
            pageTitle: 'Apply Leave Encashment',
            breadcrumb: [
                {
                    text: 'Apply Leave Encashment',
                    to: {name: 'apply-leave-encashment'},
                },
                {
                    text: 'Edit',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/approve-leave-encashment',
        name: 'approve-leave-encashment',
        component: () => import('@/views/hr/leave-management/approve-leave-encashment/approveLeaveEncashment.vue'),
        meta: {
            pageTitle: 'Approve Leave Encashment',
            breadcrumb: [
                {
                    text: 'Approve Leave Encashment',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/edit-approve-leave-encashment',
        name: 'edit-approve-leave-encashment',
        component: () => import('@/views/hr/leave-management/approve-leave-encashment/approveLeaveEncashmentEdit.vue'),
        meta: {
            pageTitle: 'Approve Leave Encashment',
            breadcrumb: [
                {
                    text: 'Approve Leave Encashment',
                    to: {name: 'approve-leave-encashment'},
                },
                {
                    text: 'Edit',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/entry-leave-adjustment',
        name: 'entry-leave-adjustment',
        component: () => import('@/views/hr/leave-management/entry-leave-adjustment/entryLeaveAdjustmentList.vue'),
        meta: {
            pageTitle: 'Entry Leave Adjustment',
            breadcrumb: [
                {
                    text: 'Entry Leave Adjustment',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/add-entry-leave-adjustment',
        name: 'add-entry-leave-adjustment',
        component: () => import('@/views/hr/leave-management/entry-leave-adjustment/entryLeaveAdjustmentAdd.vue'),
        meta: {
            pageTitle: 'Entry Leave Adjustment',
            breadcrumb: [
                {
                    text: 'Entry Leave Adjustment',
                    to: {name: 'entry-leave-adjustment'}
                },
                {
                    text: 'Add',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/edit-entry-leave-adjustment',
        name: 'edit-entry-leave-adjustment',
        component: () => import('@/views/hr/leave-management/entry-leave-adjustment/entryLeaveAdjustmentEdit.vue'),
        meta: {
            pageTitle: 'Entry Leave Adjustment',
            breadcrumb: [
                {
                    text: 'Entry Leave Adjustment',
                    to: {name: 'entry-leave-adjustment'},
                },
                {
                    text: 'Edit',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/leave-encashment-report-manager',
        name: 'reports-leave-encashment-manager',
        component: () => import('@/views/hr/leave-management/reports-leave-encashment-manager/reportLeaveEncashmentManager.vue'),
        meta: {
            pageTitle: 'Leave Encashment Report Manager',
            breadcrumb: [
                {
                    text: 'Encashment-Manager',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/leave-encashment-report-hr',
        name: 'reports-leave-encashment-hr',
        component: () => import('@/views/hr/leave-management/reports-leave-encashment-hr/reportLeaveEncashmentHr.vue'),
        meta: {
            pageTitle: 'Leave Encashment Report HR',
            breadcrumb: [
                {
                    text: 'Encashment - HR',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/leave-manager-report',
        name: 'report-leave-manager',
        component: () => import('@/views/hr/leave-management/report-leave-manager/reportLeaveManager.vue'),
        meta: {
            pageTitle: 'Leave Manager Report',
            breadcrumb: [
                {
                    text: 'Leave Manager Report',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/leave-hr-report',
        name: 'report-leave-hr',
        component: () => import('@/views/hr/leave-management/report-leave-hr/reportLeavehr.vue'),
        meta: {
            pageTitle: 'Leave HR Report',
            breadcrumb: [
                {
                    text: 'Leave HR Report',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/balance-leave-report-manager',
        name: 'balance-report-leave-manager',
        component: () => import('@/views/hr/leave-management/balance-report-leave-manager/balanceReportLeaveManager.vue'),
        meta: {
            pageTitle: 'Balance Leave Report Manager',
            breadcrumb: [
                {
                    text: 'Balance Leave Report Manager',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/balance-leave-report-hr',
        name: 'balance-report-leave-hr',
        component: () => import('@/views/hr/leave-management/balance-report-leave-hr/balanceReportLeaveHr.vue'),
        meta: {
            pageTitle: 'Balance Leave Report HR',
            breadcrumb: [
                {
                    text: 'Balance Leave Report HR',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/leave-register-report-manager',
        name: 'leave-register-report-manager',
        component: () => import('@/views/hr/leave-management/leave-register-report-manager/leaveRegisterReportManager.vue'),
        meta: {
            pageTitle: 'Leave Register Report Manager',
            breadcrumb: [
                {
                    text: 'Leave Register Report Manager',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/leave-register-report-hr',
        name: 'leave-register-report-hr',
        component: () => import('@/views/hr/leave-management/leave-register-report-hr/leaveRegisterReportHr.vue'),
        meta: {
            pageTitle: 'Leave Register Report HR',
            breadcrumb: [
                {
                    text: 'Leave Register Report HR',
                    active: true,
                },
            ],
        },
    },

    /*Time Management*/
    {
        path: '/shift-definition',
        name: 'shift-definition',
        component: () => import('@/views/hr/time-management/shift-definition/shiftDefinationList'),
        meta: {
            pageTitle: 'Shift Definition',
            breadcrumb: [
                {
                    text: 'Shift Definition',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/add-shift-definition',
        name: 'add-shift-definition',
        component: () => import('@/views/hr/time-management/shift-definition/shiftDefinitionAdd.vue'),
        meta: {
            pageTitle: 'Shift Definition',
            breadcrumb: [
                {
                    text: 'Shift Definition',
                    to: {name: 'shift-definition'}
                },
                {
                    text: 'Add',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/edit-shift-definition',
        name: 'edit-shift-definition',
        component: () => import('@/views/hr/time-management/shift-definition/shiftDefinitionEdit.vue'),
        meta: {
            pageTitle: 'Shift Definition',
            breadcrumb: [
                {
                    text: 'Shift Definition',
                    to: {name: 'shift-definition'}
                },
                {
                    text: 'Edit',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/additional-shift-rule',
        name: 'additional-shift-rule',
        component: () => import('@/views/hr/time-management/shift-definition/additional-shift-rule/additionalShiftRuleList.vue'),
        meta: {
            pageTitle: 'Additional Shift Rule',
            breadcrumb: [
                {
                    text: 'Shift Definition',
                    to: {name: 'shift-definition'}
                },
                {
                    text: 'Additional Shift Rule',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/add-additional-shift-rule',
        name: 'add-additional-shift-rule',
        component: () => import('@/views/hr/time-management/shift-definition/additional-shift-rule/additionalShiftRuleAdd.vue'),
        meta: {
            pageTitle: 'Additional Shift Rule',
            breadcrumb: [
                {
                    text: 'Additional Shift Rule',
                    to: {name: 'additional-shift-rule'}
                },
                {
                    text: 'Add',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/edit-additional-shift-rule',
        name: 'edit-additional-shift-rule',
        component: () => import('@/views/hr/time-management/shift-definition/additional-shift-rule/additionalShiftRuleEdit.vue'),
        meta: {
            pageTitle: 'Additional Shift Rule',
            breadcrumb: [
                {
                    text: 'Additional Shift Rule',
                    to: {name: 'additional-shift-rule'}
                },
                {
                    text: 'Edit',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/holiday-master',
        name: 'holiday-master',
        component: () => import('@/views/hr/time-management/holiday-master/holidayMasterList.vue'),
        meta: {
            pageTitle: 'Holiday Master',
            breadcrumb: [
                {
                    text: 'Holiday Master',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/add-holiday-master',
        name: 'add-holiday-master',
        component: () => import('@/views/hr/time-management/holiday-master/holidayMasterAdd.vue'),
        meta: {
            pageTitle: 'Holiday Master',
            breadcrumb: [
                {
                    text: 'Holiday Master',
                    to: {name: 'holiday-master'}
                },
                {
                    text: 'Add',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/edit-holiday-master',
        name: 'edit-holiday-master',
        component: () => import('@/views/hr/time-management/holiday-master/holidayMasterEdit.vue'),
        meta: {
            pageTitle: 'Holiday Master',
            breadcrumb: [
                {
                    text: 'Holiday Master',
                    to: {name: 'holiday-master'}
                },
                {
                    text: 'Edit',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/attendance-type',
        name: 'attendance-type',
        component: () => import('@/views/hr/time-management/attendance-type/attendanceTypeList.vue'),
        meta: {
            pageTitle: 'Attendance Type',
            breadcrumb: [
                {
                    text: 'Attendance Type',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/add-attendance-type',
        name: 'add-attendance-type',
        component: () => import('@/views/hr/time-management/attendance-type/attendanceTypeAdd.vue'),
        meta: {
            pageTitle: 'Attendance Type',
            breadcrumb: [
                {
                    text: 'Attendance Type',
                    to: {name: 'attendance-type'}
                },
                {
                    text: 'Add',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/edit-attendance-type',
        name: 'edit-attendance-type',
        component: () => import('@/views/hr/time-management/attendance-type/attendanceTypeEdit.vue'),
        meta: {
            pageTitle: 'Attendance Type',
            breadcrumb: [
                {
                    text: 'Attendance Type',
                    to: {name: 'attendance-type'}
                },
                {
                    text: 'Edit',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/publish-holiday-calendar',
        name: 'publish-holiday-calendar',
        component: () => import('@/views/hr/time-management/publish-holiday-calendar/publishHolidayCalendarList.vue'),
        meta: {
            pageTitle: 'Public Holiday Calendar',
            breadcrumb: [
                {
                    text: 'Public Holiday Calendar',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/card-punch-setup',
        name: 'card-punch-setup',
        component: () => import('@/views/hr/time-management/card-punch-setup/cardPunchSetupList.vue'),
        meta: {
            pageTitle: 'Card Punch Setup',
            breadcrumb: [
                {
                    text: 'Card Punch Setup',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/publish-holiday-calendar/publish-calendar-for-employees',
        name: 'publish-calendar-for-employees',
        component: () => import('@/views/hr/time-management/publish-holiday-calendar/publishCalendarEmployeeList.vue'),
        meta: {
            pageTitle: 'Calendar Employees',
            breadcrumb: [
                {
                    text: 'Public Holiday Calendar',
                    to: {name: 'publish-holiday-calendar'}
                },
                {
                    text: 'Publish Calendar',
                    active: true
                },
            ],
        },
    },
    {
        path: '/card-punch-setup/card-punch-setup-required',
        name: 'card-punch-setup-required',
        component: () => import('@/views/hr/time-management/card-punch-setup/cardPunchSetupRequiredList.vue'),
        meta: {
            pageTitle: 'Punch Setup Required',
            breadcrumb: [
                {
                    text: 'Card Punch Setup',
                    to: {name: 'card-punch-setup'},
                },
                {
                    text: 'Punch Setup Required',
                    active: true
                },
            ],
        },
    },
    {
        path: '/weekly-off',
        name: 'weekly-off',
        component: () => import('@/views/hr/time-management/weekly-off/weeklyOffList.vue'),
        meta: {
            pageTitle: 'Weekly Off',
            breadcrumb: [
                {
                    text: 'Weekly Off',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/weekly-off/weekly-off-employee-information',
        name: 'weekly-off-employee-information',
        component: () => import('@/views/hr/time-management/weekly-off/weeklyOffEmployeeDetailList.vue'),
        meta: {
            pageTitle: 'Weekly Off Detail',
            breadcrumb: [
                {
                    text: 'Weekly Off',
                    to: { name: 'weekly-off'},
                },
                {
                    text: 'Weekly Off Detail',
                    active: true
                },
            ],
        },
    },
    {
        path: '/attendance-group',
        name: 'attendance-group',
        component: () => import('@/views/hr/time-management/attendance-group/AttendanceGroupList.vue'),
        meta: {
            pageTitle: 'Attendance Group',
            breadcrumb: [
                {
                    text: 'Attendance Group',
                    active: true
                },
            ],
        },
    },
    {
        path: '/add-attendance-group',
        name: 'add-attendance-group',
        component: () => import('@/views/hr/time-management/attendance-group/AttendanceGroupAdd.vue'),
        meta: {
            pageTitle: 'Attendance Group',
            breadcrumb: [
                {
                    text: 'Attendance Group',
                    to: {name: 'attendance-group'}
                },
                {
                    text: 'Add',
                    active: true
                },
            ],
        },
    },
    {
        path: '/edit-attendance-group',
        name: 'edit-attendance-group',
        component: () => import('@/views/hr/time-management/attendance-group/AttendanceGroupEdit.vue'),
        meta: {
            pageTitle: 'Attendance Group',
            breadcrumb: [
                {
                    text: 'Attendance Group',
                    to: {name: 'attendance-group'}
                },
                {
                    text: 'Edit',
                    active: true
                },
            ],
        },
    },
    {
        path: '/attendance-group/convert-ot-co-utility',
        name: 'convert-ot-co-utility',
        component: () => import('@/views/hr/time-management/attendance-group/attendance-group-utility/convertOtCoUtility.vue'),
        meta: {
            pageTitle: 'Convert OT To CO+',
            breadcrumb: [
                {
                    text:'Attendance Group',
                    to: {name: 'attendance-group'}
                },
                {
                    text: 'Convert OT TO CO+',
                    active: true
                },
            ],
        },
    },
    {
        path: '/attendance-group/assign-shift-to-attendance-group',
        name: 'assign-shift-to-attendance-group',
        component: () => import('@/views/hr/time-management/attendance-group/attendance-group-utility/assignShiftToAttendanceGroup.vue'),
        meta: {
            pageTitle: 'Assign Shift To Attendance',
            breadcrumb: [
                {
                    text:'Attendance Group',
                    to: {name: 'attendance-group'}
                },
                {
                    text: 'Shift To Attendance',
                    active: true
                },
            ],
        },
    },
    {
        path: '/attendance-group/assign-shift-to-employee',
        name: 'assign-shift-to-employee',
        component: () => import('@/views/hr/time-management/attendance-group/attendance-group-utility/assignShiftToEmployee.vue'),
        meta: {
            pageTitle: 'Assign Shift To Employee',
            breadcrumb: [
                {
                    text:'Attendance Group',
                    to: {name: 'attendance-group'}
                },
                {
                    text: 'Shift To Employee',
                    active: true
                },
            ],
        },
    },
    {
        path: '/assign-shift-to-employee/assign_shift_to_employee_view',
        name: 'assign_shift_to_employee_view',
        component: () => import('@/views/hr/time-management/attendance-group/attendance-group-utility/assignShiftToEmployeeDetail.vue'),
        meta: {
            pageTitle: 'Shift To Employee',
            breadcrumb: [
                {
                    text:'Assign Shift To Employee',
                    to: {name: 'assign-shift-to-employee'}
                },
                {
                    text: 'Add',
                    active: true
                },
            ],
        },
    },
    {
        path: '/attendance-group/assign-unassign-attendance-group',
        name: 'assign-unassign-attendance-group',
        component: () => import('@/views/hr/time-management/attendance-group/attendance-group-utility/assignUnassignAttendanceGroup.vue'),
        meta: {
            pageTitle: 'Assign/Unassign Attendance',
            breadcrumb: [
                {
                    text:'Attendance Group',
                    to: {name: 'attendance-group'}
                },
                {
                    text: 'Assign/Unassign',
                    active: true
                },
            ],
        },
    },
    {
        path: '/assign-unassign-attendance-group/assign-unassign-employee',
        name: 'assign-unassign-employee',
        component: () => import('@/views/hr/time-management/attendance-group/attendance-group-utility/assignUnassignEmployeeDetail.vue'),
        meta: {
            pageTitle: 'Assign / Unassign Employee',
            breadcrumb: [
                {
                    text:'Assign/Unassign Attendance',
                    to: {name: 'assign-unassign-attendance-group'}
                },
                {
                    text: 'Add',
                    active: true
                },
            ],
        },
    },
    {
        path: '/my-attendance',
        name: 'my-attendance',
        component: () => import('@/views/hr/time-management/attendance/my-attendance/myAttendanceList.vue'),
        meta: {
            pageTitle: 'My Attendance',
            breadcrumb: [
                {
                    text: 'My Attendance',
                    active: true
                },
            ],
        },
    },
    {
        path: '/view-attendance-manager',
        name: 'view-attendance-manager',
        component: () => import('@/views/hr/time-management/attendance/view-attendance-manager/viewAttendanceManagerList.vue'),
        meta: {
            pageTitle: 'view Attendance Manager',
            breadcrumb: [
                {
                    text: 'View Attendance Manager',
                    active: true
                },
            ],
        },
    },
    {
        path: '/view-attendance-hr',
        name: 'view-attendance-hr',
        component: () => import('@/views/hr/time-management/attendance/view-attendance-hr/viewAttendanceHrList.vue'),
        meta: {
            pageTitle: 'View Attendance HR',
            breadcrumb: [
                {
                    text: 'View Attendance Hr',
                    active: true
                },
            ],
        },
    },
    {
        path: '/daily-attendance-manager',
        name: 'daily-attendance-manager',
        component: () => import('@/views/hr/time-management/attendance/daily-attendance-manager/dailyAttendanceManager.vue'),
        meta: {
            pageTitle: 'Daily Attendance Manager',
            breadcrumb: [
                {
                    text: 'Daily Attendance Manager',
                    active: true
                },
            ],
        },
    },
    {
        path: '/add-daily-attendance-manager',
        name: 'add-daily-attendance-manager',
        component: () => import('@/views/hr/time-management/attendance/daily-attendance-manager/dailyAttendanceManagerAdd.vue'),
        meta: {
            pageTitle: 'Daily Attendance Manager',
            breadcrumb: [
                {
                    text: 'Daily Attendance Manager',
                    to: {name: 'daily-attendance-manager'}
                },
                {
                    text: 'Add',
                    active: true
                },
            ],
        },
    },
    {
        path: '/monthly-attendance-manager',
        name: 'monthly-attendance-manager',
        component: () => import('@/views/hr/time-management/attendance/monthly-attendance-manager/monthlyAttendanceManagerList.vue'),
        meta: {
            pageTitle: 'Monthly Attendance Manager',
            breadcrumb: [
                {
                    text: 'Monthly Attendance Manager',
                    active: true
                },
            ],
        },
    },
    {
        path: '/monthly-attendance-hr',
        name: 'monthly-attendance-hr',
        component: () => import('@/views/hr/time-management/attendance/monthly-attendance-hr/monthlyAttendanceHrList.vue'),
        meta: {
            pageTitle: 'Monthly Attendance HR',
            breadcrumb: [
                {
                    text: 'Monthly Attendance HR',
                    active: true
                },
            ],
        },
    },
    {
        path: '/muster-generation-manager',
        name: 'muster-generation-manager',
        component: () => import('@/views/hr/time-management/attendance/muster-generation-manager/musterGenerationManagerList.vue'),
        meta: {
            pageTitle: 'Muster Generation Manager',
            breadcrumb: [
                {
                    text: 'Muster Generation Manager',
                    active: true
                },
            ],
        },
    },
    {
        path: '/add-muster-generation-manager',
        name: 'add-muster-generation-manager',
        component: () => import('@/views/hr/time-management/attendance/muster-generation-manager/musterGenerationManagerAdd.vue'),
        meta: {
            pageTitle: 'Muster Generation Manager',
            breadcrumb: [
                {
                    text: 'Muster Generation Manager',
                    to: {name: 'muster-generation-manager'}
                },
                {
                    text: 'Add',
                    active: true
                },
            ],
        },
    },
    {
        path: '/muster-generation-hr',
        name: 'muster-generation-hr',
        component: () => import('@/views/hr/time-management/attendance/muster-generation-hr/musterGenerationHrList.vue'),
        meta: {
            pageTitle: 'Muster Generation HR',
            breadcrumb: [
                {
                    text: 'Muster Generation HR',
                    active: true
                },
            ],
        },
    },
    {
        path: '/add-muster-generation-hr',
        name: 'add-muster-generation-hr',
        component: () => import('@/views/hr/time-management/attendance/muster-generation-hr/musterGenerationHrAdd.vue'),
        meta: {
            pageTitle: 'Muster Generation HR',
            breadcrumb: [
                {
                    text: 'Muster Generation HR',
                    to: {name: 'muster-generation-hr'}
                },
                {
                    text: 'Add',
                    active: true
                },
            ],
        },
    },
    {
        path: '/import-daily-attendance',
        name: 'import-daily-attendance',
        component: () => import('@/views/hr/time-management/attendance/import-daily-attendance/importDailyAttendanceList.vue'),
        meta: {
            pageTitle: 'Import Daily Attendance',
            breadcrumb: [
                {
                    text: 'Import Daily Attendance',
                    active: true
                },
            ],
        },
    },
    {
        path: '/roster-manager',
        name: 'roster-manager',
        component: () => import('@/views/hr/time-management/shift/roster-manager/rosterManagerList.vue'),
        meta: {
            pageTitle: 'Roster Manager',
            breadcrumb: [
                {
                    text: 'Roster Manager',
                    active: true
                },
            ],
        },
    },
    {
        path: '/add-roster-manager',
        name: 'add-roster-manager',
        component: () => import('@/views/hr/time-management/shift/roster-manager/rosterManagerAdd.vue'),
        meta: {
            pageTitle: 'Roster Manager',
            breadcrumb: [
                {
                    text: 'Roster Manager',
                    to: {name: 'roster-manager'}
                },
                {
                    text: 'Add',
                    active: true
                },
            ],
        },
    },
    {
        path: '/roster-hr',
        name: 'roster-hr',
        component: () => import('@/views/hr/time-management/shift/roster-hr/rosterHrList.vue'),
        meta: {
            pageTitle: 'Roster HR',
            breadcrumb: [
                {
                    text: 'Roster HR',
                    active: true
                },
            ],
        },
    },
    {
        path: '/add-roster-hr',
        name: 'add-roster-hr',
        component: () => import('@/views/hr/time-management/shift/roster-hr/rosterHrAdd.vue'),
        meta: {
            pageTitle: 'Roster HR',
            breadcrumb: [
                {
                    text: 'Roster HR',
                    to: {name: 'roster-hr'}
                },
                {
                    text: 'Add',
                    active: true
                },
            ],
        },
    },
    {
        path: '/bulk-transfer-by-manager',
        name: 'bulk-transfer-by-manager',
        component: () => import('@/views/hr/time-management/shift/bulk-transfer-by-manager/bulkTransferByManagerList.vue'),
        meta: {
            pageTitle: 'Bulk Transfer By Manager',
            breadcrumb: [
                {
                    text: 'Bulk Transfer By Manager',
                    active: true
                },
            ],
        },
    },
    {
        path: '/add-bulk-transfer-by-manager',
        name: 'add-bulk-transfer-by-manager',
        component: () => import('@/views/hr/time-management/shift/bulk-transfer-by-manager/bulkTransferByManagerAdd.vue'),
        meta: {
            pageTitle: 'Bulk Transfer By Manager',
            breadcrumb: [
                {
                    text: 'Bulk Transfer By Manager',
                    to: {name: 'bulk-transfer-by-manager'}
                },
                {
                    text: 'Add',
                    active: true
                },
            ],
        },
    },
    {
        path: '/transfer-by-hr',
        name: 'transfer-by-hr',
        component: () => import('@/views/hr/time-management/shift/transfer-by-hr/transferByHr.vue'),
        meta: {
            pageTitle: 'Transfer By HR',
            breadcrumb: [
                {
                    text: 'Transfer By HR',
                    active: true
                },
            ],
        },
    },
    {
        path: '/multiple-shift-transfer-by-hr',
        name: 'multiple-shift-transfer-by-hr',
        component: () => import('@/views/hr/time-management/shift/transfer-by-hr/multipleShiftTransferByHrList.vue'),
        meta: {
            pageTitle: 'Shift Transfer By HR',
            breadcrumb: [
                {
                    text: 'Transfer By HR',
                    to: {name: 'transfer-by-hr'}
                },
                {
                    text: 'Shift Transfer By HR',
                    active: true
                },
            ],
        },
    },
    {
        path: '/add-multiple-shift-transfer-by-hr',
        name: 'add-multiple-shift-transfer-by-hr',
        component: () => import('@/views/hr/time-management/shift/transfer-by-hr/multipleShiftTransferByManagerAdd.vue'),
        meta: {
            pageTitle: 'Shift Transfer By HR',
            breadcrumb: [
                {
                    text: 'Shift Transfer By HR',
                    to: {name: 'multiple-shift-transfer-by-hr'}
                },
                {
                    text: 'Add',
                    active: true
                },
            ],
        },
    },
    {
        path: '/multiple-shift-transfer-List',
        name: 'multiple-shift-transfer-Hr-List',
        component: () => import('@/views/hr/time-management/shift/transfer-by-hr/multiple-shift-transfer/multipleShiftTransferList.vue'),
        meta: {
            pageTitle: 'Multiple Shift Transfer List',
            breadcrumb: [
                {
                    text: 'Transfer By HR',
                    to: {name: 'transfer-by-hr'}
                },
                {
                    text: 'List',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/add-multiple-shift-transfer',
        name: 'add-multiple-shift-transfer',
        component: () => import('@/views/hr/time-management/shift/transfer-by-hr/multiple-shift-transfer/multipleShiftTransferAdd.vue'),
        meta: {
            pageTitle: 'Multiple Shift Transfer',
            breadcrumb: [
                {
                    text: 'Multiple Shift Transfer',
                    to: {name: 'multiple-shift-transfer-Hr-List'},
                },
                {
                    text: 'Add',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/edit-multiple-shift-transfer',
        name: 'edit-multiple-shift-transfer',
        component: () => import('@/views/hr/time-management/shift/transfer-by-hr/multiple-shift-transfer/multipleShiftTransferEdit.vue'),
        meta: {
            pageTitle: 'Multiple Shift Transfer',
            breadcrumb: [
                {
                    text: 'Multiple Shift Transfer',
                    to: {name: 'multiple-shift-transfer-Hr-List'},
                },
                {
                    text: 'Edit',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/manager-report',
        name: 'manager-report',
        component: () => import('@/views/hr/time-management/shift/manager-report/managerReportList.vue'),
        meta: {
            pageTitle: 'Manager Report',
            breadcrumb: [
                {
                    text: 'Manager Report',
                    active: true
                },
            ],
        },
    },
    {
        path: '/add-manager-report',
        name: 'add-manager-report',
        component: () => import('@/views/hr/time-management/shift/manager-report/managerReportAdd.vue'),
        meta: {
            pageTitle: 'Manager - Report',
            breadcrumb: [
                {
                    text: 'Manager Report',
                    to: {name: 'manager-report'},
                },
                {
                    text: 'Add',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/hr-report',
        name: 'hr-report',
        component: () => import('@/views/hr/time-management/shift/hr-report/hrReportList.vue'),
        meta: {
            pageTitle: 'HR Report',
            breadcrumb: [
                {
                    text: 'HR Report',
                    active: true
                },
            ],
        },
    },
    {
        path: '/add-hr-report',
        name: 'add-hr-report',
        component: () => import('@/views/hr/time-management/shift/hr-report/hrReportAdd.vue'),
        meta: {
            pageTitle: 'HR - Report',
            breadcrumb: [
                {
                    text: 'HR Report',
                    to: {name: 'hr-report'},
                },
                {
                    text: 'Add',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/shift-change-request',
        name: 'shift-change-request',
        component: () => import('@/views/hr/time-management/shift-change/shift-change-request/shiftChangeRequestList.vue'),
        meta: {
            pageTitle: 'Shift Change Request',
            breadcrumb: [
                {
                    text: 'Shift Change Request',
                    active: true
                },
            ],
        },
    },
    {
        path: '/add-shift-change-request',
        name: 'add-shift-change-request',
        component: () => import('@/views/hr/time-management/shift-change/shift-change-request/shiftChangeRequestAdd.vue'),
        meta: {
            pageTitle: 'Shift Change Report',
            breadcrumb: [
                {
                    text: 'Shift Change Report',
                    to: {name: 'shift-change-request'},
                },
                {
                    text: 'Add',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/edit-shift-change-request',
        name: 'edit-shift-change-request',
        component: () => import('@/views/hr/time-management/shift-change/shift-change-request/shiftChangeRequestEdit.vue'),
        meta: {
            pageTitle: 'Shift Change Report',
            breadcrumb: [
                {
                    text: 'Shift Change Report',
                    to: {name: 'shift-change-request'},
                },
                {
                    text: 'Edit',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/shift-change-approve',
        name: 'shift-change-approve',
        component: () => import('@/views/hr/time-management/shift-change/shift-change-approve/shiftChangeApprove.vue'),
        meta: {
            pageTitle: 'Shift Change Approve',
            breadcrumb: [
                {
                    text: 'Shift Change Approve',
                    active: true
                },
            ],
        },
    },
    {
        path: '/edit-shift-change-approve',
        name: 'edit-shift-change-approve',
        component: () => import('@/views/hr/time-management/shift-change/shift-change-approve/shiftChangeApproveEdit.vue'),
        meta: {
            pageTitle: 'Shift Change Approve',
            breadcrumb: [
                {
                    text: 'Shift Change Approve',
                    to: {name: 'shift-change-approve'},
                },
                {
                    text: 'Edit',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/shift-change-manager-report',
        name: 'shift-change-manager-report',
        component: () => import('@/views/hr/time-management/shift-change/shift-change-manager-report/shiftChangeManageReport.vue'),
        meta: {
            pageTitle: 'Manager Report',
            breadcrumb: [
                {
                    text: 'Manager Report',
                    active: true
                },
            ],
        },
    },
    {
        path: '/shift-change-hr-report',
        name: 'shift-change-hr-report',
        component: () => import('@/views/hr/time-management/shift-change/shift-change-hr-report/shiftChangeHrReport.vue'),
        meta: {
            pageTitle: 'HR Report',
            breadcrumb: [
                {
                    text: 'HR Report',
                    active: true
                },
            ],
        },
    },
    {
        path: '/import-roster',
        name: 'import-roster',
        component: () => import('@/views/hr/time-management/shift-roster/import-roster/shiftRoster.vue'),
        meta: {
            pageTitle: 'Shift Roster',
            breadcrumb: [
                {
                    text: 'Shift Roster',
                    active: true
                },
            ],
        },
    },
    {
        path: '/import-roster-manager',
        name: 'import-roster-manager',
        component: () => import('@/views/hr/time-management/shift-roster/import-roster-manager/shiftRosterManager.vue'),
        meta: {
            pageTitle: 'Shift Roster Manager',
            breadcrumb: [
                {
                    text: 'Shift Roster Manager',
                    active: true
                },
            ],
        },
    },
    {
        path: '/continuous-absent-list-report',
        name: 'continuous-absent-list-report',
        component: () => import('@/views/hr/time-management/attendance-reports/continuous-absent-list-report/continuousAbsentListReport.vue'),
        meta: {
            pageTitle: 'Continuous Absent List Report',
            breadcrumb: [
                {
                    text: 'Continuous Absent List Report',
                    active: true
                },
            ],
        },
    },
    {
        path: '/muster-writer-report',
        name: 'muster-writer-report',
        component: () => import('@/views/hr/time-management/attendance-reports/muster-writer-report/musterWriterReport.vue'),
        meta: {
            pageTitle: 'Muster Writer Report',
            breadcrumb: [
                {
                    text: 'Muster Writer Report',
                    active: true
                },
            ],
        },
    },
    {
        path: '/add-muster-writer-report',
        name: 'add-muster-writer-report',
        component: () => import('@/views/hr/time-management/attendance-reports/muster-writer-report/musterWriterReportAdd.vue'),
        meta: {
            pageTitle: 'Muster Writer Report',
            breadcrumb: [
                {
                    text: 'Muster Writer Report',
                    to: {name: 'muster-writer-report'},
                },
                {
                    text: 'Add',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/muster-writer-grouping-report',
        name: 'muster-writer-grouping-report',
        component: () => import('@/views/hr/time-management/attendance-reports/muster-writer-grouping-report/musterWriterGroupingReport.vue'),
        meta: {
            pageTitle: 'Muster Writer Grouping Report',
            breadcrumb: [
                {
                    text: 'Muster Writer Grouping Report',
                    active: true
                },
            ],
        },
    },
    {
        path: '/add-muster-writer-grouping-report',
        name: 'add-muster-writer-grouping-report',
        component: () => import('@/views/hr/time-management/attendance-reports/muster-writer-grouping-report/musterWriterGroupingReportAdd.vue'),
        meta: {
            pageTitle: 'Muster Writer Grouping Report',
            breadcrumb: [
                {
                    text: 'Muster Writer Grouping Report',
                    to: {name: 'muster-writer-grouping-report'},
                },
                {
                    text: 'Add',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/attendance-summary-report',
        name: 'attendance-summary-report',
        component: () => import('@/views/hr/time-management/attendance-reports/attendance-summary-report/attendanceSummaryReport.vue'),
        meta: {
            pageTitle: 'Attendance Summary Report',
            breadcrumb: [
                {
                    text: 'Attendance Summary Report',
                    active: true
                },
            ],
        },
    },
    {
        path: '/attendance-summary-report',
        name: 'attendance-summary-report-export',
        component: () => import('@/views/hr/time-management/attendance-reports/attendance-summary-report/musterWriterGroupingReportExport.vue'),
        meta: {
            pageTitle: 'Attendance Summary Report',
            breadcrumb: [
                {
                    text: 'Attendance Summary Report',
                    to: {name: 'attendance-summary-report'},
                },
                {
                    text: 'Add',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/daywise-attendance-muster',
        name: 'daywise-attendance-muster',
        component: () => import('@/views/hr/time-management/attendance-reports/daywise-attendance-muster/daywiseAttendanceMuster.vue'),
        meta: {
            pageTitle: 'Day-Wise Attendance Muster',
            breadcrumb: [
                {
                    text: 'Day-Wise Attendance Muster',
                    active: true
                },
            ],
        },
    },
    {
        path: '/manger-reports',
        name: 'attendance-manger-reports',
        component: () => import('@/views/hr/time-management/attendance-reports/manger-reports/managerReport.vue'),
        meta: {
            pageTitle: 'Manager Report',
            breadcrumb: [
                {
                    text: 'Manager Report',
                    active: true
                },
            ],
        },
    },
    {
        path: '/view-manger-reports',
        name: 'view-manger-reports',
        component: () => import('@/views/hr/time-management/attendance-reports/manger-reports/viewManagerReport.vue'),
        meta: {
            pageTitle: 'Manager Report',
            breadcrumb: [
                {
                    text: 'Manager Report',
                    to: {name: 'attendance-manger-reports'},
                },
                {
                    text: 'Report',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/hr-reports',
        name: 'attendance-hr-reports',
        component: () => import('@/views/hr/time-management/attendance-reports/hr-reports/hrReport.vue'),
        meta: {
            pageTitle: 'HR Report',
            breadcrumb: [
                {
                    text: 'HR Report',
                    active: true
                },
            ],
        },
    },
    {
        path: '/view-hr-reports',
        name: 'view-hr-reports',
        component: () => import('@/views/hr/time-management/attendance-reports/hr-reports/viewHrReport.vue'),
        meta: {
            pageTitle: 'HR Report',
            breadcrumb: [
                {
                    text: 'HR Report',
                    to: {name: 'attendance-hr-reports'},
                },
                {
                    text: 'Report',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/analysis-reports',
        name: 'analysis-reports',
        component: () => import('@/views/hr/time-management/attendance-reports/analysis-reports/analysisReports.vue'),
        meta: {
            pageTitle: 'Analysis Report',
            breadcrumb: [
                {
                    text: 'Analysis Report',
                    active: true
                },
            ],
        },
    },
    {
        path: '/attendance-muster-advance',
        name: 'attendance-muster-advance',
        component: () => import('@/views/hr/time-management/attendance-utilities/attendance-muster-advance/attendanceMusterAdvance.vue'),
        meta: {
            pageTitle: 'Attendance Muster Advance',
            breadcrumb: [
                {
                    text: 'Attendance Master Advance',
                    active: true
                },
            ],
        },
    },
    {
        path: '/recalculation-muster',
        name: 'recalculation-muster',
        component: () => import('@/views/hr/time-management/attendance-utilities/recalculation-muster/recalculationMuster.vue'),
        meta: {
            pageTitle: 'Recalculation Muster',
            breadcrumb: [
                {
                    text: 'Recalculation Muster',
                    active: true
                },
            ],
        },
    },
    {
        path: '/muster-update-bulk',
        name: 'muster-update-bulk',
        component: () => import('@/views/hr/time-management/attendance-utilities/muster-update-bulk/musterUpdateBulk.vue'),
        meta: {
            pageTitle: 'Muster Update Bulk',
            breadcrumb: [
                {
                    text: 'Muster Update Bulk',
                    active: true
                },
            ],
        },
    },
    {
        path: '/monthly-summary-generation',
        name: 'monthly-summary-generation',
        component: () => import('@/views/hr/time-management/attendance-utilities/monthly-summary-generation/monthlySummarygeneration.vue'),
        meta: {
            pageTitle: 'Monthly Summary Report',
            breadcrumb: [
                {
                    text: 'Monthly Summary Report',
                    active: true
                },
            ],
        },
    },
    {
        path: '/monthly-summary-report',
        name: 'monthly-summary-report',
        component: () => import('@/views/hr/time-management/attendance-utilities/monthly-summary-report/monthlySummaryReport.vue'),
        meta: {
            pageTitle: 'Monthly Summary Report',
            breadcrumb: [
                {

                    text: 'Monthly Summary Report',
                    active: true
                },
            ],
        },
    },
    {
        path: '/data-deletion',
        name: 'data-deletion',
        component: () => import('@/views/hr/time-management/attendance-utilities/data-deletion/dataDeletion.vue'),
        meta: {
            pageTitle: 'Data Deletion',
            breadcrumb: [
                {

                    text: 'Data Deletion',
                    active: true
                },
            ],
        },
    },
    {
        path: '/lock-data-unlock-data',
        name: 'lock-data-unlock-data',
        component: () => import('@/views/hr/time-management/attendance-utilities/lock-data-unlock-data/lockDataUnlockData.vue'),
        meta: {
            pageTitle: 'Lock Data Unlock Data',
            breadcrumb: [
                {

                    text: 'Lock Data Unlock Data',
                    active: true
                },
            ],
        },
    },
    {
        path: '/mark-revoke-inout-x-hr',
        name: 'mark-revoke-inout-x-hr',
        component: () => import('@/views/hr/time-management/attendance-utilities/mark-revoke-inout-x-hr/markRevokeInOutXhr.vue'),
        meta: {
            pageTitle: 'Mark Revoke In Out X HR',
            breadcrumb: [
                {

                    text: 'Mark Revoke In Out X HR',
                    active: true
                },
            ],
        },
    },
    {
        path: '/mark-revoke-inout-x-hr-entry',
        name: 'mark-revoke-inout-x-hr-entry',
        component: () => import('@/views/hr/time-management/attendance-utilities/mark-revoke-inout-x-hr/markRevokeInOutXhrEntry.vue'),
        meta: {
            pageTitle: 'Mark Revoke In Out X HR',
            breadcrumb: [
                {
                    text: 'Mark Revoke In Out X HR',
                    to:{name:''},
                },
                {
                    text: 'View',
                    active: true
                },
            ],
        },
    },
    {
        path: '/mark-revoke-inout-x-manager',
        name: 'mark-revoke-inout-x-manager',
        component: () => import('@/views/hr/time-management/attendance-utilities/mark-revoke-inout-x-manager/markRevokeInOutXManager.vue'),
        meta: {
            pageTitle: 'Mark Revoke InOut X Manager',
            breadcrumb: [
                {
                    text: 'Mark Revoke InOut X Manager',
                    active: true
                },
            ],
        },
    },
    {
        path: '/mark-revoke-inout-x-manager-entry',
        name: 'mark-revoke-inout-x-manager-entry',
        component: () => import('@/views/hr/time-management/attendance-utilities/mark-revoke-inout-x-manager/markRevokeInOutXManagerEntry.vue'),
        meta: {
            pageTitle: 'Mark Revoke In Out X Manager',
            breadcrumb: [
                {
                    text: 'Mark Revoke In Out X Manager',
                    to:{name:'mark-revoke-inout-x-manager'},
                },
                {
                    text: 'View',
                    active: true
                },
            ],
        },
    },
    {
        path: '/reconciliation',
        name: 'reconciliation',
        component: () => import('@/views/hr/time-management/attendance-utilities/reconciliation/reconciliation.vue'),
        meta: {
            pageTitle: 'Reconciliation',
            breadcrumb: [
                {
                    text: 'Reconciliation',
                    active: true
                },
            ],
        },
    },
    {
        path: '/misc-utilities',
        name: 'misc-utilities',
        component: () => import('@/views/hr/time-management/attendance-utilities/misc-utilities/miscUtilities.vue'),
        meta: {
            pageTitle: 'MISC Utilities',
            breadcrumb: [
                {
                    text: 'MISC Utilities',
                    active: true
                },
            ],
        },
    },
    {
        path: '/dashboard-leave',
        name: 'dashboard-leave',
        component: () => import('@/views/hr/admin/dashboard/dashboard-leave/dashboardLeave.vue'),
        meta: {
            pageTitle: 'Dashboard Leave',
            breadcrumb: [
                {
                    text: 'Dashboard Leave',
                    active: true
                },
            ],
        },
    },
    {
        path: '/dashboard-attendance',
        name: 'dashboard-attendance',
        component: () => import('@/views/hr/admin/dashboard/dashboard-attendance/dashboardAttendance.vue'),
        meta: {
            pageTitle: 'Dashboard Attendance',
            breadcrumb: [
                {
                    text: 'Dashboard Attendance',
                    active: true
                },
            ],
        },
    },
    {
        path: '/dashboard-manager',
        name: 'dashboard-manager',
        component: () => import('@/views/hr/leave-management/dashboard-manager/dashboardManager.vue'),
        meta: {
            pageTitle: 'Dashboard Manager',
            breadcrumb: [
                {
                    text: 'Dashboard Manager',
                    active: true
                },
            ],
        },
    },
    {
        path: '/dashboard-attendance-manager',
        name: 'dashboard-attendance-manager',
        component: () => import('@/views/hr/time-management/attendance/dashboard-attendance-manager/dashboardAttendanceManager.vue'),
        meta: {
            pageTitle: 'Dashboard Manager',
            breadcrumb: [
                {
                    text: 'Dashboard Manager',
                    active: true
                },
            ],
        },
    },
    {
        path: '/leave-notes',
        name: 'leave-notes',
        component: () => import('@/views/hr/leave-management/configuration/leave-notes/leaveNotes.vue'),
        meta: {
            pageTitle: 'Leave Notes',
            breadcrumb: [
                {
                    text: 'Leave Notes',
                    active: true
                },
            ],
        },
    },
    {
        path: '/leave-encashment-rules',
        name: 'leave-encashment-rules',
        component: () => import('@/views/hr/leave-management/configuration/leave-encashment-rules/leaveEncashmentRulesList.vue'),
        meta: {
            pageTitle: 'Leave Encashment Rules',
            breadcrumb: [
                {
                    text: 'Leave Encashment Rules',
                    active: true
                },
            ],
        },
    },
    {
        path: '/add-leave-encashment-rules',
        name: 'add-leave-encashment-rules',
        component: () => import('@/views/hr/leave-management/configuration/leave-encashment-rules/leaveEncashmentRulesAdd.vue'),
        meta: {
            pageTitle: 'Leave Encashment Rules',
            breadcrumb: [
                {
                    text: 'Leave Encashment Rules',
                    to:{name:'leave-encashment-rules'},
                },
                {
                    text: 'Add',
                    active: true
                },
            ],
        },
    },
    {
        path: '/edit-leave-encashment-rules',
        name: 'edit-leave-encashment-rules',
        component: () => import('@/views/hr/leave-management/configuration/leave-encashment-rules/leaveEncashmentRulesEdit.vue'),
        meta: {
            pageTitle: 'Leave Encashment Rules',
            breadcrumb: [
                {
                    text: 'Leave Encashment Rules',
                    to:{name:'leave-encashment-rules'},
                },
                {
                    text: 'Edit',
                    active: true
                },
            ],
        },
    },
    {
        path: '/leave-category-master',
        name: 'leave-category-master',
        component: () => import('@/views/hr/leave-management/configuration/leave-category-master/leaveCategoryMasterList.vue'),
        meta: {
            pageTitle: 'Leave Category Master',
            breadcrumb: [
                {
                    text: 'Leave Category Master',
                    active: true
                },
            ],
        },
    },
    {
        path: '/add-leave-category-master',
        name: 'add-leave-category-master',
        component: () => import('@/views/hr/leave-management/configuration/leave-category-master/leaveCategoryMasterAdd.vue'),
        meta: {
            pageTitle: 'Leave Category Master',
            breadcrumb: [
                {
                    text: 'Leave Category Master',
                    to:{name:'leave-category-master'},
                },
                {
                    text: 'Add',
                    active: true
                },
            ],
        },
    },
    {
        path: '/edit-leave-category-master',
        name: 'edit-leave-category-master',
        component: () => import('@/views/hr/leave-management/configuration/leave-category-master/leaveCategoryMasterEdit.vue'),
        meta: {
            pageTitle: 'Leave Category Master',
            breadcrumb: [
                {
                    text: 'Leave Category Master',
                    to:{name:'leave-category-master'},
                },
                {
                    text: 'Edit',
                    active: true
                },
            ],
        },
    },
    {
        path: '/leave-application-import',
        name: 'leave-application-import',
        component: () => import('@/views/hr/leave-management/configuration/leave-application-import/leaveApplicationImport.vue'),
        meta: {
            pageTitle: 'Leave Application Import',
            breadcrumb: [
                {
                    text: 'Leave Application Import',
                    active: true
                },
            ],
        },
    }
]

