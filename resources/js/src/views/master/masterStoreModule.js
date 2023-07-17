import axios from '@axios'

export default {
    namespaced: true,
    state: {},
    getters: {},
    mutations: {},
    actions: {
        addTermsConditionGroup(ctx, referenceData) {
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/term-condition-group-master', referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        updateTermsConditionGroup(ctx, referenceData) {
            return new Promise((resolve, reject) => {
                axios
                    .put(`/api/term-condition-group-master/${referenceData.id}`, referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        deleteTermsConditionGroup(ctx, queryParams) {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api/term-condition-group-master/${queryParams.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        addTermsConditionDetails(ctx, referenceData) {
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/term-condition-detail-master', referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        updateTermsConditionDetail(ctx, referenceData) {
            return new Promise((resolve, reject) => {
                axios
                    .put(`/api/term-condition-detail-master/${referenceData.id}`, referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        deleteTermsConditionDetail(ctx, queryParams) {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api/term-condition-detail-master/${queryParams.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        addDefaultTermsCondition(ctx, referenceData) {
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/default-term-condition-master', referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        updateDefaultTermsCondition(ctx, referenceData) {
            return new Promise((resolve, reject) => {
                axios
                    .put(`/api/default-term-condition-master/${referenceData._id}`, referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        deleteDefaultTermsCondition(ctx, queryParams) {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api/default-term-condition-master/${queryParams.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        /* default-terms-condition */
        addDefaultTermsConditionItem(ctx, referenceData) {
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/new/default-term-condition-item', referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        updateDefaultTermsConditionItem(ctx, referenceData) {
            return new Promise((resolve, reject) => {
                axios
                    .put(`/api/new/default-term-condition-item/${referenceData._id}`, referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        deleteDefaultTermsConditionItem(ctx, queryParams) {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api/new/default-term-condition-item/${queryParams.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        //template terms condition master
        addTermsConditionTemplateMaster(ctx, referenceData) {
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/term-condition-template-master', referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        updateTermsConditionTemplateMaster(ctx, payload){
            return new Promise((resolve, reject) => {
                axios
                    .put(`/api/term-condition-template-master/${payload.id}`,payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        deleteTermsConditionTemplateMaster(ctx, queryParams) {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api/term-condition-template-master/${queryParams.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        addTaxMaster(ctx, referenceData) {
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/tax-master', referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        updateTaxMaster(ctx, referenceData) {
            return new Promise((resolve, reject) => {
                axios
                    .put(`/api/tax-master/${referenceData.id}`, referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        deleteTaxMaster(ctx, queryParams) {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api/tax-master/${queryParams.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        addTaxFormsMaster(ctx, referenceData) {
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/tax-forms-master', referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        updateTaxFormsMaster(ctx, referenceData) {
            return new Promise((resolve, reject) => {
                axios
                    .put(`/api/tax-forms-master/${referenceData.id}`, referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        deleteTaxFormsMaster(ctx, queryParams) {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api/tax-forms-master/${queryParams.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        addDutyDrawbackMaster(ctx, referenceData) {
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/duty-drawback-master', referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        updateDutyDrawbackMaster(ctx, referenceData) {
            return new Promise((resolve, reject) => {
                axios
                    .put(`/api/duty-drawback-master/${referenceData.id}`, referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        deleteDutyDrawbackMaster(ctx, queryParams) {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api/duty-drawback-master/${queryParams.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        addIsoApiDocMaster(ctx, referenceData) {
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/ios-api-doc-master', referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        updateIsoApiDocMaster(ctx, referenceData) {
            return new Promise((resolve, reject) => {
                axios
                    .put(`/api/ios-api-doc-master/${referenceData.id}`, referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        deleteIsoApiDocMaster(ctx, queryParams) {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api/ios-api-doc-master/${queryParams.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        addItemMaster(ctx, payload){
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/item-master',payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        fetchItemMaster(ctx, payload){
            return new Promise((resolve, reject) => {
                axios
                    .get(`/api/item-master/${payload.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        updateItemMaster(ctx, payload){
            return new Promise((resolve, reject) => {
                axios
                    .put(`/api/item-master/${payload.id}`,payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async deleteItemMaster(ctx, payload){
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/item-master/${payload.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async copyItemMaster(ctx, payload){
            return await new Promise((resolve, reject) => {
                axios
                    .post(`/api/copy-item-master-data`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            });
        },
        addTaskMaster(ctx, referenceData) {
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/task-master', referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        updateTaskMaster(ctx, referenceData) {
            return new Promise((resolve, reject) => {
                axios
                    .put(`/api/task-master/${referenceData.id}`, referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        deleteTaskMaster(ctx, queryParams) {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api/task-master/${queryParams.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        addProgressStageMaster(ctx, referenceData) {
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/progress-stage-master', referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        updateProgressStageMaster(ctx, referenceData) {
            return new Promise((resolve, reject) => {
                axios
                    .put(`/api/progress-stage-master/${referenceData.id}`, referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        deleteProgressStageMaster(ctx, queryParams) {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api/progress-stage-master/${queryParams.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        addBillingMaster(ctx, payload){
            return new Promise((resolve, reject) => {
                axios
                    .post(`/api/billing-master`,payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        updateBillingMaster(ctx, payload){
            return new Promise((resolve, reject) => {
                axios
                    .put(`/api/billing-master/${payload.id}`,payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        deleteBillingMaster(ctx, queryParams){
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api/billing-master/${queryParams.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async addBillingTemplateMaster(ctx, payload){
            return await new Promise((resolve, reject) => {
                axios
                    .post(`/api/billing-template-master`,payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async updateBillingTemplateMaster(ctx, payload){
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/billing-template-master/${payload.id}`,payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async deleteBillingTemplateMaster(ctx, payload){
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/billing-template-master/${payload.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async addBillingTemplateItemMaster(ctx, payload){
            return await new Promise((resolve, reject) => {
                axios
                    .post(`/api/billing-template-items-master`,payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async updateBillingTemplateItemMaster(ctx, payload){
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/billing-template-items-master/${payload.id}`,payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async deleteBillingTemplateItemMaster(ctx, payload){
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/billing-template-items-master/${payload.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        addInvoiceTypeMaster(ctx, userData) {
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/invoice-type-master', userData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        fetchInvoiceTypeDetail(ctx, {id}) {
            return new Promise((resolve, reject) => {
                axios
                    .get(`/api/invoice-type-master/${id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        UpdateInvoiceTypeMaster(ctx, referenceData) {
            return new Promise((resolve, reject) => {
                axios
                    .put(`/api/invoice-type-master/${referenceData.id}`, referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        deleteInvoiceTypeMaster(ctx, queryParams) {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api/invoice-type-master/${queryParams.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        addSalesOrderTypeMaster(ctx, userData) {
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/sales-order-type-master', userData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        fetchSalesOrderTypeDetail(ctx, {id}) {
            return new Promise((resolve, reject) => {
                axios
                    .get(`/api/sales-order-type-master/${id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        UpdateSalesOrderTypeMaster(ctx, referenceData) {
            return new Promise((resolve, reject) => {
                axios
                    .put(`/api/sales-order-type-master/${referenceData.id}`, referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        deleteSalesOrderTypeMaster(ctx, queryParams) {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api/sales-order-type-master/${queryParams.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async addDefaultBillingTemplateMaster(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .post('/api/default-billing-template-master', payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async updateDefaultBillingTemplateMaster(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/default-billing-template-master/${payload.id}`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        //terms & COndition template Item Master
        async addTermConditionTemplateItemMaster(ctx, payload){
            return await new Promise((resolve, reject) => {
                axios
                    .post(`/api/new/terms-condi-template-item-master`,payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async updateTermConditionTemplateItemMaster(ctx, payload){
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/new/terms-condi-template-item-master/${payload.id}`,payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async deleteTermConditionTemplateItemMaster(ctx, payload){
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/new/terms-condi-template-item-master/${payload.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
    },
}
