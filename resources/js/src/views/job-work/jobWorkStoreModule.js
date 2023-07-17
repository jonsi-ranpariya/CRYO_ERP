import axios from "@axios";

export default {
    namespaced: true,
    state: {},
    getters: {},
    mutations: {},
    actions: {
        async addJobWorkOrder(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .post("/api/job-work-order", payload)
                    .then((response) => resolve(response))
                    .catch((error) => reject(error));
            });
        },
        async updateJobWorkOrder(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/job-work-order/${payload._id}`, payload)
                    .then((response) => resolve(response))
                    .catch((error) => reject(error));
            });
        },
        async deleteJobWorkOrder(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/job-work-order/${payload.id}`)
                    .then((response) => resolve(response))
                    .catch((error) => reject(error));
            });
        },
        async addJobWorkItemDetail(ctx, payload) {
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/job-work-order-item', payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async updateJobWorkItemDetail(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/job-work-order-item/${payload._id}`, payload)
                    .then((response) => resolve(response))
                    .catch((error) => reject(error));
            });
        },
        async deleteJobWorkItemDetail(ctx, payload) {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api/job-work-order-item/${payload.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        addJobWorkOrderTermCondition(ctx, payload) {
            return new Promise((resolve, reject) => {
                axios
                    .post(`/api/job-order-term-condition`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        updateJobWorkOrderTermCondition(ctx, payload) {
            return new Promise((resolve, reject) => {
                axios
                    .put(`/api/job-order-term-condition/${payload._id}`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        deleteJobWorkOrderTermCondition(ctx, payload) {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api/job-order-term-condition/${payload.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async addIssueJobWorkOrderChallan(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .post("/api/issue-job-work-challan", payload)
                    .then((response) => resolve(response))
                    .catch((error) => reject(error));
            });
        },
        async updateIssueJobWorkOrderChallan(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/issue-job-work-challan/${payload._id}`, payload)
                    .then((response) => resolve(response))
                    .catch((error) => reject(error));
            });
        },
        async deleteIssueJobWorkOrderChallan(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/issue-job-work-challan/${payload.id}`)
                    .then((response) => resolve(response))
                    .catch((error) => reject(error));
            });
        },
        async addIssueJobOrderChallanItemDetail(ctx, payload) {
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/issue-job-work-challan-item', payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async updateIssueJobOrderChallanItemDetail(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/issue-job-work-challan-item/${payload._id}`, payload)
                    .then((response) => resolve(response))
                    .catch((error) => reject(error));
            });
        },
        async deleteIssueJobOrderChallanItemDetail(ctx, payload) {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api/issue-job-work-challan-item/${payload.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async addReceiptJobWorkChallan(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .post(`/api/new/receipt-job-work-challan`, payload)
                    .then((response) => resolve(response))
                    .catch((error) => reject(error));
            });
        },
        async updateReceiptJobWorkChallan(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/new/receipt-job-work-challan/${payload.id}`, payload)
                    .then((response) => resolve(response))
                    .catch((error) => reject(error));
            });
        },
        async deleteReceiptJobWorkChallan(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/new/receipt-job-work-challan/${payload.id}`)
                    .then((response) => resolve(response))
                    .catch((error) => reject(error));
            });
        },
        async addRerunRejectionMemo(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .post(`/api/new/return-rejection-memo`, payload)
                    .then((response) => resolve(response))
                    .catch((error) => reject(error));
            });
        },
        async updateReturnRejectionMemo(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/new/return-rejection-memo/${payload._id}`, payload)
                    .then((response) => resolve(response))
                    .catch((error) => reject(error));
            });
        },
        async deleteReturnRejectionMemo(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/new/return-rejection-memo/${payload.id}`)
                    .then((response) => resolve(response))
                    .catch((error) => reject(error));
            });
        },
        async addRejectionMemoItemDetail(ctx, payload) {
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/new/return-rejection-memo-item', payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async updateRejectionMemoItemDetail(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/new/return-rejection-memo-item/${payload._id}`, payload)
                    .then((response) => resolve(response))
                    .catch((error) => reject(error));
            });
        },
        async deleteRejectionMemoItemDetail(ctx, payload) {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api/new/return-rejection-memo-item/${payload.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async addRawMaterialSubContractor(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .post("/api/new/raw-material-sub-contractor", payload)
                    .then((response) => resolve(response))
                    .catch((error) => reject(error));
            });
        },
        async deleteRawMaterialSubContractor(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/new/raw-material-sub-contractor/${payload.id}`)
                    .then((response) => resolve(response))
                    .catch((error) => reject(error));
            });
        },
        async addRawMaterialItemDetail(ctx, payload) {
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/new/raw-material-sub-contractor-item', payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async updateRawMaterialItemDetail(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/new/raw-material-sub-contractor-item/${payload._id}`, payload)
                    .then((response) => resolve(response))
                    .catch((error) => reject(error));
            });
        },
        async deleteRawMaterialItemDetail(ctx, payload) {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api/new/raw-material-sub-contractor-item/${payload.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async addRawMaterial(ctx, payload) {
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/new/raw-material', payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async updateRawMaterial(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/new/raw-material/${payload.id}`, payload)
                    .then((response) => resolve(response))
                    .catch((error) => reject(error));
            });
        },
        async deleteRawMaterial(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/new/raw-material/${payload.id}`)
                    .then((response) => resolve(response))
                    .catch((error) => reject(error));
            });
        },
        async addScrapReceiptEntry(ctx, payload) {
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/new/scrap-receipt-entrys', payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async updateScrapReceiptEntry(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/new/scrap-receipt-entrys/${payload._id}`, payload)
                    .then((response) => resolve(response))
                    .catch((error) => reject(error));
            });
        },
        async deleteScrapReceiptEntry(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/new/scrap-receipt-entrys/${payload.id}`)
                    .then((response) => resolve(response))
                    .catch((error) => reject(error));
            });
        },
        async addJobReWorkChallan(ctx, payload) {
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/new/job-work-rework-challan', payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async updateJobReWorkChallan(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/new/job-work-rework-challan/${payload._id}`, payload)
                    .then((response) => resolve(response))
                    .catch((error) => reject(error));
            });
        },
        async deleteJobReWorkChallan(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/new/job-work-rework-challan/${payload.id}`)
                    .then((response) => resolve(response))
                    .catch((error) => reject(error));
            });
        },
        async addJobReWorkChallanItem(ctx, payload) {
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/new/job-work-rework-challan-item', payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async updateJobReWorkChallanItem(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/new/job-work-rework-challan-item/${payload._id}`, payload)
                    .then((response) => resolve(response))
                    .catch((error) => reject(error));
            });
        },
        async deleteJobReWorkChallanItem(ctx, payload) {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api/new/job-work-rework-challan-item/${payload.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async addJobReWorkReceipt(ctx, payload){
            return await new Promise((resolve, reject) => {
                axios
                    .post('/api/new/job-work-reawork-receipt', payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            });
        },
        async updateJobReWorkReceipt(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/new/job-work-reawork-receipt/${payload.id}`, payload)
                    .then((response) => resolve(response))
                    .catch((error) => reject(error));
            });
        },
        async deleteJobReWorkReceipt(ctx, payload) {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api/new/job-work-reawork-receipt/${payload.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async addJobWorkRateMaster(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .post("/api/new/job-work-rate-master", payload)
                    .then((response) => resolve(response))
                    .catch((error) => reject(error));
            });
        },
        async updateJobWorkRateMaster(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/new/job-work-rate-master/${payload._id}`, payload)
                    .then((response) => resolve(response))
                    .catch((error) => reject(error));
            });
        },
        async deleteJobWorkRateMaster(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/new/job-work-rate-master/${payload.id}`)
                    .then((response) => resolve(response))
                    .catch((error) => reject(error));
            });
        },
        async addJobWorkRateMasterProcess(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .post(`/api/new/job-work-rate-master-process`, payload)
                    .then((response) => resolve(response))
                    .catch((error) => reject(error));
            });
        },
        async updateJobWorkRateMasterProcess(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/new/job-work-rate-master-process/${payload._id}`, payload)
                    .then((response) => resolve(response))
                    .catch((error) => reject(error));
            });
        },
        async deleteJobWorkRateMasterProcess(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/new/job-work-rate-master-process/${payload.id}`)
                    .then((response) => resolve(response))
                    .catch((error) => reject(error));
            });
        },
        async addJobWorkRateMasterTerms(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .post("/api/new/job-work-rate-terms-condition", payload)
                    .then((response) => resolve(response))
                    .catch((error) => reject(error));
            });
        },
        async updateJobWorkRateMasterTerms(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/new/job-work-rate-terms-condition/${payload._id}`, payload)
                    .then((response) => resolve(response))
                    .catch((error) => reject(error));
            });
        },
        async deleteJobWorkRateMasterTerms(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/new/job-work-rate-terms-condition/${payload.id}`)
                    .then((response) => resolve(response))
                    .catch((error) => reject(error));
            });
        },
        async addSubContractorRateParameter(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .post(`/api/new/sub-contractor-rate-parameter`, payload)
                    .then((response) => resolve(response))
                    .catch((error) => reject(error));
            });
        },
        async updateDeliveryParameter(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/new/sub-contractor-rate-parameter/${payload._id}`, payload)
                    .then((response) => resolve(response))
                    .catch((error) => reject(error));
            });
        },
        async deleteDeliveryParameter(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/new/sub-contractor-rate-parameter/${payload.id}`)
                    .then((response) => resolve(response))
                    .catch((error) => reject(error));
            });
        },
        async addQcRateParameter(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .post(`/api/new/sub-contractor-rate-parameter`, payload)
                    .then((response) => resolve(response))
                    .catch((error) => reject(error));
            });
        },
        async updateQcRateParameter(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/new/sub-contractor-rate-parameter/${payload._id}`, payload)
                    .then((response) => resolve(response))
                    .catch((error) => reject(error));
            });
        },
        async deleteQcRateParameter(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/new/sub-contractor-rate-parameter/${payload.id}`)
                    .then((response) => resolve(response))
                    .catch((error) => reject(error));
            });
        },
    },
}
