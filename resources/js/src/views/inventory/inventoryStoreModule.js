import axios from '@axios'

export default {
    namespaced: true,
    state: {},
    getters: {},
    mutations: {},
    actions: {
        async addGateInwardReceipt(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .post('/api/new/gate-inward-receipt', payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async updateGateInwardReceipt(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/new/gate-inward-receipt/${payload._id}`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async deleteGateInwardReceipt(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/new/gate-inward-receipt/${payload.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async addGoodsReceiptNote(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .post('/api/new/goods-receipt-note', payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async updateGoodsReceiptNote(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/new/goods-receipt-note/${payload._id}`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async deleteGoodsReceiptNote(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/new/goods-receipt-note/${payload.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async addGoodsReceiptNoteItem(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .post('/api/new/goods-receipt-note-item', payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async updateGoodsReceiptNoteItem(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/new/goods-receipt-note-item/${payload._id}`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async deleteGoodsReceiptNoteItem(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/new/goods-receipt-note-item/${payload.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async addTransaction(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .post('/api/new/transaction-inventory', payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async updateTransaction(ctx, payload){
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/new/transaction-inventory/${payload._id}`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async deleteTransaction(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/new/transaction-inventory/${payload.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },

    }
}
