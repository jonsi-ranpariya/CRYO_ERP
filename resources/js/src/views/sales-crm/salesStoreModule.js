import axios from '@axios'

export default {
    namespaced: true,
    state: {},
    getters: {},
    mutations: {},
    actions: {
        async addSalesEnquiry(ctx, referenceData) {
            return await new Promise((resolve, reject) => {
                axios
                    .post('/api/sales-enquiry', referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async updateSalesEnquiry(ctx, referenceData) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/sales-enquiry/${referenceData.id}`, referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async deleteSalesEnquiry(ctx, queryParams) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/sales-enquiry/${queryParams.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async fetchSalesEnquiryDetail(ctx, {id}) {
            return await new Promise((resolve, reject) => {
                axios
                    .get(`/api/sales-enquiry/${id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async getSalesItemDetails(ctx, payload){
            return await new Promise((resolve, reject) => {
                axios
                    .get(`/api/get-sales-item-details/${payload.id}`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async addSalesItemDetails(ctx, payload){
            return await new Promise((resolve, reject) => {
                axios
                    .post('/api/sales-item-details', payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async updateSalesItemDetails(ctx, payload){
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/sales-item-details/${payload.id}`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async deleteSalesItemDetails(ctx, payload){
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/sales-item-details/${payload.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async saveConfirmation(ctx, payload){
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/sales-enquiry/${payload.id}`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async getHistory(ctx, payload){
            return await new Promise((resolve, reject) => {
                axios
                    .get(`/api/sales-history-iq-wise/${payload.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async addHistory(ctx, payload){
            return await new Promise((resolve, reject) => {
                axios
                    .post('/api/sales-history', payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async updateHistory(ctx, payload){
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/sales-history/${payload.id}`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async deleteHistory(ctx, payload){
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/sales-history/${payload.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async addSalesQuotation(ctx, referenceData) {
            return await new Promise((resolve, reject) => {
                axios
                    .post('/api/sales-quotation', referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async updateSalesQuotation(ctx, referenceData) {
            return await new Promise((resolve, reject) => {
                  axios
                    .put(`/api/sales-quotation/${referenceData.id}`, referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async deleteSalesQuotation(ctx, queryParams) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/sales-quotation/${queryParams.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async fetchSalesQuotationDetail(ctx, {id}) {
            return await new Promise((resolve, reject) => {
                axios
                    .get(`/api/sales-quotation/${id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
///sales Quotation Terms & Condition
        async addSalesQuotationTermCondition(ctx, referenceData) {
            return await new Promise((resolve, reject) => {
                axios
                    .post('/api/new/sales-quotation-term-condition', referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async updateSalesQuotationTermCondition(ctx, referenceData) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/new/sales-quotation-term-condition/${referenceData.id}`, referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async deleteSalesQuotationTermCondition(ctx, queryParams) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/new/sales-quotation-term-condition/${queryParams.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        /*Slaes Order*/
        async addSalesOrder(ctx, referenceData) {
            return await new Promise((resolve, reject) => {
                axios
                    .post('/api/sales-order', referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async updateSalesOrder(ctx, referenceData) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/sales-order/${referenceData.id}`, referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async deleteSalesOrder(ctx, queryParams) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/sales-order/${queryParams.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async fetchSalesOrderDetail(ctx, {id}) {
            return await new Promise((resolve, reject) => {
                axios
                    .get(`/api/sales-order/${id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async addSalesOrderItems(ctx, referenceData) {
            return await new Promise((resolve, reject) => {
                axios
                    .post('/api/sales-order-items', referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async updateSalesOrderItems(ctx, referenceData) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/sales-order-items/${referenceData.id}`, referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async deleteSalesOrderItems(ctx, queryParams) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/sales-order-items/${queryParams.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async fetchSalesOrderItemsDetail(ctx, {id}) {
            return await new Promise((resolve, reject) => {
                axios
                    .get(`/api/sales-order-items/${id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async addSalesOrderBillingTerms(ctx, referenceData) {
            return await new Promise((resolve, reject) => {
                axios
                    .post('/api/sales-order-billing-terms', referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async updateSalesOrderBillingTerms(ctx, referenceData) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/sales-order-billing-terms/${referenceData.id}`, referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async deleteSalesOrderBillingTerms(ctx, queryParams) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/sales-order-billing-terms/${queryParams.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async fetchSalesOrderBillingTermsDetail(ctx, {id}) {
            return await new Promise((resolve, reject) => {
                axios
                    .get(`/api/sales-order-billing-terms/${id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async addSalesOrderTermCondition(ctx, referenceData) {
            return await new Promise((resolve, reject) => {
                axios
                    .post('/api/sales-order-term-condition', referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async updateSalesOrderTermCondition(ctx, referenceData) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/sales-order-term-condition/${referenceData.id}`, referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async deleteSalesOrderTermCondition(ctx, queryParams) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/sales-order-term-condition/${queryParams.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async fetchSalesOrderTermCondition(ctx, {id}) {
            return await new Promise((resolve, reject) => {
                axios
                    .get(`/api/sales-order-term-condition/${id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async addProformaInvoice(ctx, referenceData) {
            return await new Promise((resolve, reject) => {
                axios
                    .post('/api/proforma-invoices', referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async updateProformaInvoice(ctx, referenceData) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/proforma-invoices/${referenceData.id}`, referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async deleteProformaInvoice(ctx, queryParams) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/proforma-invoices/${queryParams.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async fetchProformaInvoiceDetail(ctx, {id}) {
            return await new Promise((resolve, reject) => {
                axios
                    .get(`/api/proforma-invoices/${id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async addProformaInvoiceItems(ctx, referenceData) {
            return await new Promise((resolve, reject) => {
                axios
                    .post('/api/proforma-invoice-items', referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async updateProformaInvoiceItems(ctx, referenceData) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/proforma-invoice-items/${referenceData.id}`, referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async deleteProformaInvoiceItems(ctx, queryParams) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/proforma-invoice-items/${queryParams.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async fetchProformaInvoiceItemsDetail(ctx, {id}) {
            return await new Promise((resolve, reject) => {
                axios
                    .get(`/api/proforma-invoice-items/${id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async fetchSalesOrderAgents(ctx, referenceData) {
            return await new Promise((resolve, reject) => {
                axios
                    .get(`/api/get-sales-order-agents/${referenceData.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async addSalesOrderAgent(ctx, referenceData) {
            return await new Promise((resolve, reject) => {
                axios
                    .post('/api/sales-order-agents', referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async addPiBillingTerms(ctx, referenceData) {
            return await new Promise((resolve, reject) => {
                axios
                    .post('/api/pi-billing-terms', referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async updatePiBillingTerms(ctx, referenceData) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/pi-billing-terms/${referenceData.id}`, referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async deletePiBillingTerms(ctx, queryParams) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/pi-billing-terms/${queryParams.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async fetchPiBillingTermsDetail(ctx, {id}) {
            return await new Promise((resolve, reject) => {
                axios
                    .get(`/api/pi-billing-terms/${id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async addPiTermCondition(ctx, referenceData) {
            return await new Promise((resolve, reject) => {
                axios
                    .post('/api/pi-term-condition', referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async updatePiTermCondition(ctx, referenceData) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/pi-term-condition/${referenceData.id}`, referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async deletePiTermCondition(ctx, queryParams) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/pi-term-condition/${queryParams.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async fetchPiTermCondition(ctx, {id}) {
            return await new Promise((resolve, reject) => {
                axios
                    .get(`/api/pi-term-condition/${id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async updateSalesOrderAgent(ctx, referenceData) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/sales-order-agents/${referenceData.id}`, referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async deleteSalesOrderAgent(ctx, id) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/sales-order-agents/${id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async addSalesOrderStage(ctx, referenceData) {
            return await new Promise((resolve, reject) => {
                axios
                    .post('/api/sales-order-stage', referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async updateSalesOrderStage(ctx, referenceData) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/sales-order-stage/${referenceData.id}`, referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async deleteSalesOrderStage(ctx, referenceData) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/sales-order-stage/${referenceData.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async addSalesOrderHistory(ctx, referenceData) {
            return await new Promise((resolve, reject) => {
                axios
                    .post(`/api/sales-order-history/`, referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async updateSalesOrderHistory(ctx, referenceData) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/sales-order-history/${referenceData.id}`, referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async deleteSalesOrderHistory(ctx, referenceData) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/sales-order-history/${referenceData.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async addSalesOrderChecklist(ctx, referenceData) {
            return await new Promise((resolve, reject) => {
                axios
                    .post(`/api/sales-order-checklist/`, referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async updateSalesOrderChecklist(ctx, referenceData) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/sales-order-checklist/${referenceData.id}`, referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async deleteSalesOrderChecklist(ctx, referenceData) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/sales-order-checklist/${referenceData.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async addSalesOrderSchedulePayment(ctx, referenceData) {
            return await new Promise((resolve, reject) => {
                axios
                    .post(`/api/sales-order-payment-schedule/`, referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async updateSalesOrderSchedulePayment(ctx, referenceData) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/sales-order-payment-schedule/${referenceData.id}`, referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async deleteSalesOrderSchedulePayment(ctx, referenceData) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/sales-order-payment-schedule/${referenceData.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async addSalesReturn(ctx, referenceData) {
            return await new Promise((resolve, reject) => {
                axios
                    .post('/api/sales-return', referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async updateSalesReturn(ctx, referenceData) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/sales-return/${referenceData.id}`, referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async deleteSalesReturn(ctx, queryParams) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/sales-return/${queryParams.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async fetchSalesReturnDetail(ctx, {id}) {
            return await new Promise((resolve, reject) => {
                axios
                    .get(`/api/sales-return/${id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async addSalesReturnItems(ctx, referenceData) {
            return await new Promise((resolve, reject) => {
                axios
                    .post('/api/sales-return-items', referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async updateSalesReturnItems(ctx, referenceData) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/sales-return-items/${referenceData.id}`, referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async deleteSalesReturnItems(ctx, queryParams) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/sales-return-items/${queryParams.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async fetchSalesReturnItemsDetail(ctx, {id}) {
            return await new Promise((resolve, reject) => {
                axios
                    .get(`/api/sales-return-items/${id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async addSrBillingTerms(ctx, referenceData) {
            return await new Promise((resolve, reject) => {
                axios
                    .post('/api/sr-billing-terms', referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async updateSrBillingTerms(ctx, referenceData) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/sr-billing-terms/${referenceData.id}`, referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async deleteSrBillingTerms(ctx, queryParams) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/sr-billing-terms/${queryParams.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async fetchSrBillingTermsDetail(ctx, {id}) {
            return await new Promise((resolve, reject) => {
                axios
                    .get(`/api/sr-billing-terms/${id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
    },
}
