import axios from '@axios'

export default {
    namespaced: true,
    state: {},
    getters: {},
    mutations: {},
    actions: {
        async addInwardQualityControl(ctx, referenceData) {
            return await new Promise((resolve, reject) => {
                axios
                    .post('/api/new/inward-quality-control', referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async updateInwardQualityControl(ctx, referenceData) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/new/inward-quality-control/${referenceData._id}`, referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async deleteInwardQualityControl(ctx, queryParams) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/new/inward-quality-control/${queryParams.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async addInwardQualityControlItem(ctx, referenceData) {
            return await new Promise((resolve, reject) => {
                axios
                    .post('/api/new/inward-quality-control-item', referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async updateInwardQualityControlItem(ctx, referenceData) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/new/inward-quality-control-item/${referenceData._id}`, referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async deleteInwardQualityControlItem(ctx, queryParams) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/new/inward-quality-control-item/${queryParams.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async addFinishedGoodQualityControl(ctx, referenceData) {
            return await new Promise((resolve, reject) => {
                axios
                    .post('/api/new/finished-good-quality-control', referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async updateFinishedGoodQualityControl(ctx, referenceData) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/new/finished-good-quality-control/${referenceData._id}`, referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async deleteFinishedGoodQualityControl(ctx, queryParams) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/new/finished-good-quality-control/${queryParams.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async addWorkOrderSubAssemblyQc(ctx, referenceData) {
            return await new Promise((resolve, reject) => {
                axios
                    .post('/api/new/work-order-sub-assembly-qc', referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async updateWorkOrderSubAssemblyQc(ctx, referenceData) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/new/work-order-sub-assembly-qc/${referenceData._id}`, referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async deleteWorkOrderSubAssemblyQc(ctx, queryParams) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/new/work-order-sub-assembly-qc/${queryParams.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async addJobCardProcessInsideQc(ctx, referenceData) {
            return await new Promise((resolve, reject) => {
                axios
                    .post('/api/new/job-card-process-inside-qc', referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async updateJobCardProcessInsideQc(ctx, referenceData) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/new/job-card-process-inside-qc/${referenceData._id}`, referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async deleteJobCardProcessInsideQc(ctx, queryParams) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/new/job-card-process-inside-qc/${queryParams.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async addJobWorkOutsideQc(ctx, referenceData) {
            return await new Promise((resolve, reject) => {
                axios
                    .post('/api/new/job-work-outside-qc', referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async updateJobWorkOutsideQc(ctx, referenceData) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/new/job-work-outside-qc/${referenceData._id}`, referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async deleteJobWorkOutsideQc(ctx, queryParams) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/new/job-work-outside-qc/${queryParams.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },

    },
}
