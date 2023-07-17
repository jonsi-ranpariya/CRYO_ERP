import axios from '@axios'

export default {
    namespaced: true,
    state: {},
    getters: {},
    mutations: {},
    actions: {
        addItemCategory(ctx, referenceData) {
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/item-category', referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        updateItemCategory(ctx, referenceData) {
            return new Promise((resolve, reject) => {
                axios
                    .put(`/api/item-category/${referenceData.id}`, referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        deleteItemCategory(ctx, queryParams) {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api/item-category/${queryParams.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        addItemMainSubGroup(ctx, referenceData) {
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/item-main-sub-group', referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        updateItemMainSubGroup(ctx, referenceData) {
            return new Promise((resolve, reject) => {
                axios
                    .put(`/api/item-main-sub-group/${referenceData.id}`, referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        deleteItemMainSubGroup(ctx, queryParams) {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api/item-main-sub-group/${queryParams.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        addHsnSacMaster(ctx, userData) {
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/item-hsn-sac-code', userData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        fetchHsnSacMasterDetail(ctx, {id}) {
            return new Promise((resolve, reject) => {
                axios
                    .get(`/api/item-hsn-sac-code/${id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        UpdateHsnSacMaster(ctx, referenceData) {
            return new Promise((resolve, reject) => {
                axios
                    .put(`/api/item-hsn-sac-code/${referenceData.id}`, referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        deleteIHsnSacMaster(ctx, queryParams) {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api/item-hsn-sac-code/${queryParams.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        addItemGroupMaster(ctx, userData) {
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/item-group-master', userData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        fetchItemGroupDetail(ctx, {id}) {
            return new Promise((resolve, reject) => {
                axios
                    .get(`/api/item-group-master/${id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        UpdateItemGroupMaster(ctx, referenceData) {
            return new Promise((resolve, reject) => {
                axios
                    .put(`/api/item-group-master/${referenceData.id}`, referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        deleteItemGroupMaster(ctx, queryParams) {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api/item-group-master/${queryParams.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        addItemAddonType(ctx, referenceData) {
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/item-addon-type', referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        updateItemAddonType(ctx, referenceData) {
            return new Promise((resolve, reject) => {
                axios
                    .put(`/api/item-addon-type/${referenceData.id}`, referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        deleteItemAddonType(ctx, queryParams) {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api/item-addon-type/${queryParams.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        addItemAddonDetail(ctx, referenceData) {
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/item-addon-detail', referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        updateItemAddonDetail(ctx, referenceData) {
            return new Promise((resolve, reject) => {
                axios
                    .put(`/api/item-addon-detail/${referenceData.id}`, referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        deleteItemAddonDetail(ctx, queryParams) {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api/item-addon-detail/${queryParams.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        addItemSaleTargetGroup(ctx, referenceData) {
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/item-sales-target-group', referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        updateItemSaleTargetGroup(ctx, referenceData) {
            return new Promise((resolve, reject) => {
                axios
                    .put(`/api/item-sales-target-group/${referenceData.id}`, referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        deleteItemSaleTargetGroup(ctx, queryParams) {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api/item-sales-target-group/${queryParams.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
    },
}
