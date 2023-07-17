import axios from '@axios'

export default {
    namespaced: true,
    state: {},
    getters: {},
    mutations: {},
    actions: {
        async addDrawingMaster(ctx, referenceData) {
            return await new Promise((resolve, reject) => {
                axios
                    .post('/api/drawing-master', referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async updateDrawingMaster(ctx, referenceData) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/drawing-master/${referenceData.id}`, referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async deleteDrawingMaster(ctx, queryParams) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/drawing-master/${queryParams.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async fetchDrawingMasterDetail(ctx, {id}) {
            return await new Promise((resolve, reject) => {
                axios
                    .get(`/api/drawing-master/${id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async addBillOfMaterial(ctx, referenceData) {
            return await new Promise((resolve, reject) => {
                axios
                    .post('/api/bill-of-material', referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async fetchBillOfMaterial(ctx, queryParams) {
            return await new Promise((resolve, reject) => {
                axios
                    .get(`/api/bill-of-material/${queryParams.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async updateBillOfMaterial(ctx, referenceData) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/bill-of-material/${referenceData.id}`, referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async deleteBillOfMaterial(ctx, queryParams) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/bill-of-material/${queryParams.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async updateBillOfMaterialVersion(ctx, referenceData) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/bill-of-material-version/${referenceData.id}`, referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async deleteBillOfMaterialVersion(ctx, referenceData) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/bill-of-material-version/${referenceData.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async addBillOfMaterialVersion(ctx, referenceData) {
            return await new Promise((resolve, reject) => {
                axios
                    .post(`/api/bill-of-material-version`, referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async addBomVersionItem(ctx, referenceData) {
            return await new Promise((resolve, reject) => {
                axios
                    .post(`/api/bom-version-items`, referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async updateBomVersionItem(ctx, referenceData) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/bom-version-items/${referenceData._id}`, referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async deleteBomVersionItem(ctx, referenceData) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/bom-version-items/${referenceData.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async addBomVersionProcess(ctx, referenceData) {
            return await new Promise((resolve, reject) => {
                axios
                    .post(`/api/bom-version-process`, referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async updateBomVersionProcess(ctx, referenceData) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/bom-version-process/${referenceData.id}`, referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async deleteBomVersionProcess(ctx, referenceData) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/bom-version-process/${referenceData.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async addDrawingRevision(ctx, referenceData) {
            return await new Promise((resolve, reject) => {
                axios
                    .post('/api/drawing-master-revision', referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async updateDrawingRevision(ctx, referenceData) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/drawing-master-revision/${referenceData.id}`, referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async deleteDrawingRevision(ctx, queryParams) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/drawing-master-revision/${queryParams.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async fetchDrawingRevisionDetail(ctx, {id}) {
            return await new Promise((resolve, reject) => {
                axios
                    .get(`/api/drawing-master-revision/${id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async adddrawingDocuments(ctx, referenceData) {
            return await new Promise((resolve, reject) => {
                axios
                    .post(`/api/drawing-master-document`, referenceData, {
                        headers: {
                            'content-type': 'multipart/form-data'
                        }
                    })
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async deletedrawingDocuments(ctx, referenceData) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/drawing-master-document/${referenceData.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
    },
}
