import axios from '@axios'

export default {
    namespaced: true,
    state: {},
    getters: {},
    mutations: {},
    actions: {
        addLeave(ctx, payload) {
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/', payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        updateLeave(ctx, payload) {
            return new Promise((resolve, reject) => {
                axios
                    .put(`/api//${payload._id}`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        deleteLeave(ctx, payload) {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api//${payload.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        addApplyLeaveByManager(ctx, payload) {
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/', payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        updateApplyLeaveByManager(ctx, payload) {
            return new Promise((resolve, reject) => {
                axios
                    .put(`/api//${payload._id}`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        deleteApplyLeaveByManager(ctx, payload) {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api//${payload.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        /*outdoor Duty*/
        addOutdoorDuty(ctx, payload) {
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/', payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        updateOutdoorDuty(ctx, payload) {
            return new Promise((resolve, reject) => {
                axios
                    .put(`/api//${payload._id}`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        deleteOutdoorDuty(ctx, payload) {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api//${payload.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        addOutdoorDutyByManager(ctx, payload) {
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/', payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        updateOutdoorDutyByManager(ctx, payload) {
            return new Promise((resolve, reject) => {
                axios
                    .put(`/api//${payload._id}`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        deleteOutdoorDutyByManager(ctx, payload) {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api//${payload.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        /* Leave Encashment */
        addLeaveEncashment(ctx, payload) {
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/', payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        updateLeaveEncashment(ctx, payload) {
            return new Promise((resolve, reject) => {
                axios
                    .put(`/api//${payload._id}`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        deleteLeaveEncashment(ctx, payload) {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api//${payload.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        updateApproveLeaveEncashment(ctx, payload) {
            return new Promise((resolve, reject) => {
                axios
                    .put(`/api//${payload._id}`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        /* Leave Adjustment*/
        addLeaveAdjustment(ctx, payload) {
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/', payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        updateLeaveAdjustment(ctx, payload) {
            return new Promise((resolve, reject) => {
                axios
                    .put(`/api//${payload._id}`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        deleteLeaveAdjustment(ctx, payload) {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api//${payload.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        /*Leave Notes*/
        addLeaveNotes(ctx, payload) {
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/new/leave-notes', payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        addLeaveEncashmentRules(ctx, payload) {
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/', payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        updateLeaveEncashmentRules(ctx, payload) {
            return new Promise((resolve, reject) => {
                axios
                    .put(`/api//${payload._id}`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        deleteLeaveEnacashmentRules(ctx, payload) {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api//${payload.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        addLeaveCategoryMaster(ctx, payload) {
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/', payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        updateLeaveCategoryMaster(ctx, payload) {
            return new Promise((resolve, reject) => {
                axios
                    .put(`/api//${payload._id}`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        deleteLeaveCategoryMaster(ctx, payload) {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api//${payload.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },

        /*Time MAnagement*/
        addShiftDefinition(ctx, payload) {
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/', payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        updateShiftDefinition(ctx, payload) {
            return new Promise((resolve, reject) => {
                axios
                    .put(`/api//${payload._id}`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        deleteShiftDefinition(ctx, payload) {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api//${payload.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        addSlabShiftDefinition(ctx, payload) {
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/', payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        updateSlabShiftDefinition(ctx, payload) {
            return new Promise((resolve, reject) => {
                axios
                    .put(`/api//${payload._id}`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        deleteSlabShiftDefinition(ctx, payload) {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api//${payload.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        addAdditionalShiftRule(ctx, payload) {
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/', payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        updateAdditionalShiftRule(ctx, payload) {
            return new Promise((resolve, reject) => {
                axios
                    .put(`/api//${payload._id}`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        deleteAdditionalShiftRule(ctx, payload) {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api//${payload.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        addHolidayMaster(ctx, payload) {
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/', payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        updateHolidayMaster(ctx, payload) {
            return new Promise((resolve, reject) => {
                axios
                    .put(`/api//${payload._id}`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        deleteHolidayMaster(ctx, payload) {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api//${payload.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        addAttendanceType(ctx, payload) {
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/', payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        updateAttendanceType(ctx, payload) {
            return new Promise((resolve, reject) => {
                axios
                    .put(`/api//${payload._id}`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        deleteAttendanceType(ctx, payload) {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api//${payload.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        addAttendanceGroup(ctx, payload) {
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/', payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        updateAttendanceGroup(ctx, payload) {
            return new Promise((resolve, reject) => {
                axios
                    .put(`/api//${payload._id}`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        deleteAttendanceGroup(ctx, payload) {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api//${payload.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },

        /*Shift (Multiple Shift Transfer By HR )*/
        addMultipleShiftTransferHr(ctx, payload) {
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/', payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        updateMultipleShiftTransferHr(ctx, payload) {
            return new Promise((resolve, reject) => {
                axios
                    .put(`/api//${payload._id}`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        deleteMultipleShiftTransferHr(ctx, payload) {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api//${payload.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        /* Shift Change(Request) */
        addShiftChangeRequest(ctx, payload) {
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/', payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        updateShiftChangeRequest(ctx, payload) {
            return new Promise((resolve, reject) => {
                axios
                    .put(`/api//${payload._id}`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        deleteShiftChangeRequest(ctx, payload) {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api//${payload.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },

    }
}
