import axios from '@axios'

export default {
    namespaced: true,
    state: {},
    getters: {},
    mutations: {},
    actions: {
        fetchInvoiceDetail(ctx, {id}) {
            return new Promise((resolve, reject) => {
                axios
                    .get(`/api/invoice/edit/${id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        addInvoiceChallan(ctx, userData) {
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/invoice/store', userData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        editInvoiceChallan(ctx, userData) {
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/invoice/update', userData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        addNewInvoiceChallan(ctx, payload) {
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/new-challan-and-invoice', payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        updateNewInvoiceChallan(ctx, payload) {
            return new Promise((resolve, reject) => {
                axios
                    .put(`/api/new-challan-and-invoice/${payload._id}`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        deleteNewInvoiceChallan(ctx, payload) {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api/new-challan-and-invoice/${payload.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        addNewInvoiceChallanItem(ctx, payload) {
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/new-challan-and-invoice-item', payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        updateNewInvoiceChallanItem(ctx, payload) {
            return new Promise((resolve, reject) => {
                axios
                    .put(`/api/new-challan-and-invoice-item/${payload._id}`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        deleteNewInvoiceChallanItem(ctx, payload) {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api/new-challan-and-invoice-item/${payload.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        addNewInvoiceChallanBillingItem(ctx, payload) {
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/new-challan-billing-term', payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        updateNewInvoiceChallanBillingItem(ctx, payload) {
            return new Promise((resolve, reject) => {
                axios
                    .put(`/api/new-challan-billing-term/${payload._id}`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        deleteNewInvoiceChallanBillingItem(ctx, payload) {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api/new-challan-billing-term/${payload.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        addNewInvoiceChallanTermCondition(ctx, payload) {
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/new-challan-term-condition', payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        updateNewInvoiceChallanTermCondition(ctx, payload) {
            return new Promise((resolve, reject) => {
                axios
                    .put(`/api/new-challan-term-condition/${payload._id}`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        deleteNewInvoiceChallanTermCondition(ctx, payload) {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api/new-challan-term-condition/${payload.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async addNewInvoiceChallanPacking(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .post('/api/new-challan-invoice-packing', payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            });
        },
        async updateNewInvoiceChallanPacking(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/new-challan-invoice-packing/${payload._id}`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            });
        },
        async deleteNewInvoiceChallanPacking(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/new-challan-invoice-packing/${payload.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            });
        },
        async addNewInvoiceChallanShipping(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .post('/api/new-challan-invoice-shipping', payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            });
        },
        async updateNewInvoiceChallanShipping(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/new-challan-invoice-shipping/${payload._id}`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            });
        },
        async deleteNewInvoiceChallanShipping(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/new-challan-invoice-shipping/${payload.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            });
        },
    },
}
