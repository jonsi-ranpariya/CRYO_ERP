import axios from '@axios'

export default {
    namespaced: true,
    state: {},
    getters: {},
    mutations: {},
    actions: {
        async addWorkOrder(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .post('/api/work-orders', payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async updateWorkOrder(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/work-orders/${payload.id}`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async deleteWorkOrder(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/work-orders/${payload.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async addWorkOrderNote(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .post('/api/work-order-note', payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async updateWorkOrderNote(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/work-order-note/${payload.id}`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async deleteWorkOrderNote(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/work-order-note/${payload.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async addProcessSheetMaster(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .post('/api/process-sheet-master', payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async updateProcessSheetMaster(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/process-sheet-master/${payload.id}`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async deleteProcessSheetMaster(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/process-sheet-master/${payload.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async fetchProcessSheetMasterDetail(ctx, {id}) {
            return await new Promise((resolve, reject) => {
                axios
                    .get(`/api/process-sheet-master/${id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async addProcessSheetList(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .post('/api/process-sheet-list', payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async updateProcessSheetList(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/process-sheet-list/${payload.id}`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async deleteProcessSheetList(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/process-sheet-list/${payload.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async fetchProcessSheetListDetail(ctx, {id}) {
            return await new Promise((resolve, reject) => {
                axios
                    .get(`/api/process-sheet-list/${id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async addWorkOrderItem(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .post('/api/work-order-item', payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async updateWorkOrderItem(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/work-order-item/${payload.id}`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async deleteWorkOrderItem(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/work-order-item/${payload.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async addWorkOrderAssemblyItem(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .post('/api/work-order-item-assembly', payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async updateWorkOrderAssemblyItem(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/work-order-item-assembly/${payload.id}`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async deleteWorkOrderAssemblyItem(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/work-order-item-assembly/${payload.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async addWorkOrderRouting(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .post('/api/work-order-routing', payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async updateWorkOrderRouting(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/work-order-routing/${payload.id}`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async deleteWorkOrderRouting(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/work-order-routing/${payload.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async addWorkOrderItemRouting(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .post('/api/work-order-item-routing', payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async updateWorkOrderItemRouting(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/work-order-item-routing/${payload.id}`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async deleteWorkOrderItemRouting(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/work-order-item-routing/${payload.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async addWorkOrderRequisition(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .post('/api/wo-requisition', payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async udpateWorkOrderRequisition(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/wo-requisition/${payload.id}`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async deleteWorkOrderRequisition(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/wo-requisition/${payload.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async addWorkOrderRequisitionItem(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .post(`/api/wo-requisition-items`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async updateWorkOrderRequisitionItem(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/wo-requisition-items/${payload.id}`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async deleteWorkOrderRequisitionItem(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/wo-requisition-items/${payload.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async addJobCardReturnShop(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .post(`/api/job-card-return-shop`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async updateJobCardReturnShop(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/job-card-return-shop/${payload.id}`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async deleteJobCardReturnShop(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/job-card-return-shop/${payload.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async addJobCardReturnShopItem(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .post(`/api/job-card-return-shop-item`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async updateJobCardReturnShopItem(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/job-card-return-shop-item/${payload.id}`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async deleteJobCardReturnShopItem(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/job-card-return-shop-item/${payload.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
    }
}
