import axios from "@axios";

export default {
    namespaced: true,
    state: {},
    getters: {},
    mutations: {},
    actions: {
        async getWoPurchaseItem(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .get('/api/mrp/wo-purchase-items')
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async addWoPurchaseItem(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .post('/api/mrp/wo-purchase-items', payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async updateWoPurchaseItem(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/mrp/wo-purchase-items/${payload.id}`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async deleteWoPurchaseItem(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/mrp/wo-purchase-items/${payload.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async getWoAssemblyComponent(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .get('/api/mrp/wo-assembly-component')
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async addWoAssemblyComponent(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .post('/api/mrp/wo-assembly-component', payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async updateWoAssemblyComponent(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/mrp/wo-assembly-component/${payload.id}`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async deleteWoAssemblyComponent(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/mrp/wo-assembly-component/${payload.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async addWoWisePurchaseItem(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .post('/api/mrp/wo-wise-purchase-items', payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async updateWoWisePurchaseItem(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/mrp/wo-wise-purchase-items/${payload._id}`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async deleteWoWisePurchaseItem(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/mrp/wo-wise-purchase-items/${payload.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async getWoWiseAssemblyComponent(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .get('/api/mrp/wo-wise-assembly-component')
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async addWoWiseAssemblyComponent(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .post('/api/mrp/wo-wise-assembly-component', payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async updateWoWiseAssemblyComponent(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/mrp/wo-wise-assembly-component/${payload._id}`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async deleteWoWiseAssemblyComponent(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/mrp/wo-wise-assembly-component/${payload.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async getMinimumLevelShortage(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .get('/api/mrp/minimum-level-shortage')
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async addMinimumLevelShortage(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .post('/api/mrp/minimum-level-shortage', payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async updateMinimumLevelShortage(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/mrp/minimum-level-shortage/${payload._id}`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async deleteMinimumLevelShortage(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/mrp/minimum-level-shortage/${payload.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async getManualPlanning(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .get('/api/mrp/manual-planning')
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async addManualPlanning(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .post('/api/mrp/manual-planning', payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async updateManualPlanning(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/mrp/manual-planning/${payload._id}`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async deleteManualPlanning(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/mrp/manual-planning/${payload.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async addWoAllocation(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .post('/api/mrp/manual-planning-allocation', payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async updateWoAllocation(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/mrp/manual-planning-allocation/${payload._id}`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async deleteWoAllocation(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/mrp/manual-planning-allocation/${payload.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async addWoDeliverySchedule(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .post('/api/mrp/manual-planning-delivery', payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async updateWoDeliverySchedule(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/mrp/manual-planning-delivery/${payload._id}`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async deleteWoDeliverySchedule(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/mrp/manual-planning-delivery/${payload.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },

    },
}
