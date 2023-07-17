import axios from "@axios";

export default {
    namespaced: true,
    state: {},
    getters: {},
    mutations: {},
    actions: {
        async addPurchaseEnquiry(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .post("/api/purchase-enquiry", payload)
                    .then((response) => resolve(response))
                    .catch((error) => reject(error));
            });
        },
        async updatePurchaseEnquiry(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/purchase-enquiry/${payload.id}`, payload)
                    .then((response) => resolve(response))
                    .catch((error) => reject(error));
            });
        },
        async deletePurchaseEnquiry(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/purchase-enquiry/${payload.id}`)
                    .then((response) => resolve(response))
                    .catch((error) => reject(error));
            });
        },
        async addPurchaseEnquiryVendorDetail(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .post("/api/purchase-enquiry-vendor-detail", payload)
                    .then((response) => resolve(response))
                    .catch((error) => reject(error));
            });
        },
        async updatePurchaseEnquiryVendorDetail(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(
                        `/api/purchase-enquiry-vendor-detail/${payload._id}`,
                        payload
                    )
                    .then((response) => resolve(response))
                    .catch((error) => reject(error));
            });
        },
        async deletePurchaseEnquiryVendorDetail(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/purchase-enquiry-vendor-detail/${payload.id}`)
                    .then((response) => resolve(response))
                    .catch((error) => reject(error));
            });
        },
        async addPurchaseEnquiryItemDetail(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .post("/api/purchase-enquiry-item-detail", payload)
                    .then((response) => resolve(response))
                    .catch((error) => reject(error));
            });
        },
        async updatePurchaseEnquiryItemDetail(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(
                        `/api/purchase-enquiry-item-detail/${payload._id}`,
                        payload
                    )
                    .then((response) => resolve(response))
                    .catch((error) => reject(error));
            });
        },
        async deletePurchaseEnquiryItemDetail(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/purchase-enquiry-item-detail/${payload.id}`)
                    .then((response) => resolve(response))
                    .catch((error) => reject(error));
            });
        },
      async addPurchaseQuotation(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .post("/api/purchase-quotation", payload)
                    .then((response) => resolve(response))
                    .catch((error) => reject(error));
            });
        },
        async updatePurchaseQuotation(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/purchase-quotation/${payload.id}`, payload)
                    .then((response) => resolve(response))
                    .catch((error) => reject(error));
            });
        },
        async deletePurchaseQuotation(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/purchase-quotation/${payload.id}`)
                    .then((response) => resolve(response))
                    .catch((error) => reject(error));
            });
        },
        async addPurchaseQuotationItem(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .post("/api/purchase-quotation-item", payload)
                    .then((response) => resolve(response))
                    .catch((error) => reject(error));
            });
        },
        async updatePurchaseQuotationItem(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/purchase-quotation-item/${payload._id}`, payload)
                    .then((response) => resolve(response))
                    .catch((error) => reject(error));
            });
        },
        async deletePurchaseQuotationItem(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/purchase-quotation-item/${payload.id}`)
                    .then((response) => resolve(response))
                    .catch((error) => reject(error));
            });
        },
        async addPurchaseQuotationTermCondition(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .post("/api/purchase-quot-term-condition", payload)
                    .then((response) => resolve(response))
                    .catch((error) => reject(error));
            });
        },
        async updatePurchaseQuotationTermCondition(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(
                        `/api/purchase-quot-term-condition/${payload._id}`,
                        payload
                    )
                    .then((response) => resolve(response))
                    .catch((error) => reject(error));
            });
        },
        async deletePurchaseQuotationTermCondition(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/purchase-quot-term-condition/${payload.id}`)
                    .then((response) => resolve(response))
                    .catch((error) => reject(error));
            });
        },
        async addPurchaseQuotationBillingTerm(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .post("/api/purchase-quotation-billing-term", payload)
                    .then((response) => resolve(response))
                    .catch((error) => reject(error));
            });
        },
        async editPurchaseQuotationBillingTerm(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(
                        `/api/purchase-quotation-billing-term/${payload._id}`,
                        payload
                    )
                    .then((response) => resolve(response))
                    .catch((error) => reject(error));
            });
        },
        async deletePurchaseQuotationBillingTerm(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(
                        `/api/purchase-quotation-billing-term/${payload.id}`
                    )
                    .then((response) => resolve(response))
                    .catch((error) => reject(error));
            });
        },
        async addPurchaseOrder(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .post("/api/purchase-order", payload)
                    .then((response) => resolve(response))
                    .catch((error) => reject(error));
            });
        },
        async updatePurchaseOrder(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/purchase-order/${payload.id}`, payload)
                    .then((response) => resolve(response))
                    .catch((error) => reject(error));
            });
        },
        async deletePurchaseOrder(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/purchase-order/${payload.id}`)
                    .then((response) => resolve(response))
                    .catch((error) => reject(error));
            });
        },
        async addPurchaseOrderItem(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .post("/api/purchase-order-item", payload)
                    .then((response) => resolve(response))
                    .catch((error) => reject(error));
            });
        },
        async updatePurchaseOrderItem(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/purchase-order-item/${payload._id}`, payload)
                    .then((response) => resolve(response))
                    .catch((error) => reject(error));
            });
        },
        async deletePurchaseOrderItem(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/purchase-order-item/${payload.id}`)
                    .then((response) => resolve(response))
                    .catch((error) => reject(error));
            });
        },
        /*Purchase Order Tems & Condition */
        async addPurchaseOrderTermsCondition(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .post("/api/purchase-order-term-condition", payload)
                    .then((response) => resolve(response))
                    .catch((error) => reject(error));
            });
        },
        async updatePurchaseOrderTermsCondition(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/purchase-order-term-condition/${payload._id}`, payload)
                    .then((response) => resolve(response))
                    .catch((error) => reject(error));
            });
        },
        async deletePurchaseOrderTermsCondition(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/purchase-order-term-condition/${payload.id}`)
                    .then((response) => resolve(response))
                    .catch((error) => reject(error));
            });
        },
        async addPurchaseOrderPoHistory(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .post("/api/new/purchase-order-po-history", payload)
                    .then((response) => resolve(response))
                    .catch((error) => reject(error));
            });
        },
        async updatePurchaseOrderPoHistory(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/new/purchase-order-po-history/${payload._id}`, payload)
                    .then((response) => resolve(response))
                    .catch((error) => reject(error));
            });
        },
        async deletePurchaseOrderPoHistory(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/new/purchase-order-po-history/${payload.id}`)
                    .then((response) => resolve(response))
                    .catch((error) => reject(error));
            });
        },
        //Purchase Costing
        async addPurchaseCosting(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .post('/api/purchase-costing', payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async updatePurchaseCosting(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/purchase-costing/${payload._id}`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async deletePurchaseCosting(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/purchase-costing/${payload.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async addPurchaseCostingItem(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .post('/api/purchase-costing-item', payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async updatePurchaseCostingItem(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/purchase-costing-item/${payload._id}`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async deletePurchaseCostingItem(ctx, payload) {
            return await new Promise((resolve, reject) =>{
                axios
                    .delete(`/api//${payload.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async addPurchaseReturn(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .post('/api/new/purchase-return', payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async updatePurchaseReturn(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/new/purchase-return/${payload._id}`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async deletePurchaseReturn(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/new/purchase-return/${payload.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async addPurchaseReturnItem(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .post('/api/new/purchase-return-item', payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async updatePurchaseReturnItem(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/new/purchase-return-item/${payload._id}`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async deletePurchaseReturnItem(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/new/purchase-return-item/${payload.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async addPurchaseReturnBillingTerm(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .post('/api/new/purchase-return-billing', payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async updatePurchaseReturnBillingTerm(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/new/purchase-return-billing/${payload._id}`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async deletePurchaseReturnBillingTerm(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/new/purchase-return-billing/${payload.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async addPurchaseReturnTermCondition(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .post('/api/new/purchase-return-terms', payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async updatePurchaseReturnTermCondition(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/new/purchase-return-terms/${payload._id}`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async deletePurchaseReturnTermCondition(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/new/purchase-return-terms/${payload.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async addPurchaseOrderShowAmdDetail(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .post('/api/new/purchase-order-show-amd-detail', payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async updatePurchaseOrderShowAmdDetail(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/new/purchase-order-show-amd-detail/${payload._id}`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async deletePurchaseOrderShowAmdDetail(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/new/purchase-order-show-amd-detail/${payload.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
    },
}
