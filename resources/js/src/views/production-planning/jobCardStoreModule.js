import axios from '@axios'

export default {
    namespaced: true,
    state: {},
    getters: {},
    mutations: {},
    actions: {
        async getJobCard(ctx, referenceData) {
            return await new Promise((resolve, reject) => {
                axios
                    .get('/api/job-cards')
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async AddJobCard(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .post('/api/job-cards', payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async updateJobCard(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/job-cards/${payload._id}`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async deleteJobCard(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/job-cards/${payload.id}`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async addJobCardProcessDetails(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .post('/api/job-cards-process-details', payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async updateProcessDetails(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/job-cards-process-details/${payload._id}`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async deleteProcessDetails(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/job-cards-process-details/${payload.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        //show Issue Item
        async addShowIssueItems(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .post('/api/new/show-issue-items-process', payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async updateShowIssueItems(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/new/show-issue-items-process/${payload._id}`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async deleteShowIssueItems(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/new/show-issue-items-process/${payload.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
    //  job card process inside
        async addJobCardProcessInSide(ctx, payload){
            return await new Promise((resolve, reject) => {
                axios
                    .post(`/api/new/job-card-process-inside`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async updateJobCardProcessInSide(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/new/job-card-process-inside/${payload._id}`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async deleteJobCardProcessInSide(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/new/job-card-process-inside/${payload.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        //job card process outside
        async addJobCardProcessOutSide(ctx, payload){
            return await new Promise((resolve, reject) => {
                axios
                    .post(`/api/new/job-card-process-outside`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async updateJobCardProcessOutSide(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/new/job-card-process-outside/${payload._id}`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async deleteJobCardProcessOutSide(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/new/job-card-process-outside/${payload.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
    }
}
