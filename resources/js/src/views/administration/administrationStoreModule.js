import axios from '@axios'

export default {
    namespaced: true,
    state: {},
    getters: {},
    mutations: {},
    actions: {
        addCompanyDetails(ctx, payload) {
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/administration/company', payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        updateCompanyDetails(ctx, payload) {
            return new Promise((resolve, reject) => {
                axios
                    .put(`/api/administration/company/${payload._id}`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        deleteCompanyDetails(ctx, payload) {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api/administration/company/${payload.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
    }
}
