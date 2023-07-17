import axios from '@axios'

export default {
    namespaced: true,
    state: {},
    getters: {},
    mutations: {},
    actions: {
        fetchUomDetail(ctx, {id}) {
            return new Promise((resolve, reject) => {
                axios
                    .get(`/api/invoice/edit/${id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        addUomData(ctx, userData) {
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/uom-master', userData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        editUomData(ctx, partyData) {
            return new Promise((resolve, reject) => {
                axios
                    .put(`/api/uom-master/${partyData.id}`, partyData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        deleteUomMaster(ctx, queryParams) {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api/uom-master/${queryParams.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        addItemMakeData(ctx, userData) {
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/item-make-master', userData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        editItemMakeData(ctx, partyData) {
            return new Promise((resolve, reject) => {
                axios
                    .put(`/api/item-make-master/${partyData.id}`, partyData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        deleteItemMakeMaster(ctx, queryParams) {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api/item-make-master/${queryParams.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        addTestCertificateData(ctx, userData) {
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/certificate-type-master', userData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        editTestCertificateData(ctx, partyData) {
            return new Promise((resolve, reject) => {
                axios
                    .put(`/api/certificate-type-master/${partyData.id}`, partyData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        deleteTestCertificateMaster(ctx, queryParams) {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api/certificate-type-master/${queryParams.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        addPartyTypeData(ctx, userData) {
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/party-type-master', userData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        editPartyTypeData(ctx, partyData) {
            return new Promise((resolve, reject) => {
                axios
                    .put(`/api/party-type-master/${partyData.id}`, partyData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        deletePartyTypeMaster(ctx, queryParams) {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api/party-type-master/${queryParams.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        addBusinessTypeData(ctx, userData) {
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/business-type-master', userData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        editBusinessTypeData(ctx, partyData) {
            return new Promise((resolve, reject) => {
                axios
                    .put(`/api/business-type-master/${partyData.id}`, partyData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        deleteBusinessTypeMaster(ctx, queryParams) {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api/business-type-master/${queryParams.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        addCurrencyData(ctx, userData) {
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/currency-master', userData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        editCurrencyData(ctx, partyData) {
            return new Promise((resolve, reject) => {
                axios
                    .put(`/api/currency-master/${partyData.id}`, partyData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        deleteCurrencyMaster(ctx, queryParams) {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api/currency-master/${queryParams.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        addDepartmentData(ctx, userData) {
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/department-master', userData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        editDepartmentData(ctx, partyData) {
            return new Promise((resolve, reject) => {
                axios
                    .put(`/api/department-master/${partyData.id}`, partyData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        deleteDepartmentMaster(ctx, queryParams) {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api/department-master/${queryParams.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        addDesignationData(ctx, userData) {
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/designation-master', userData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        editDesignationData(ctx, partyData) {
            return new Promise((resolve, reject) => {
                axios
                    .put(`/api/designation-master/${partyData.id}`, partyData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        deleteDesignationMaster(ctx, queryParams) {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api/designation-master/${queryParams.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        addCountryMasterData(ctx, userData) {
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/country-master', userData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        editCountryMasterData(ctx, partyData) {
            return new Promise((resolve, reject) => {
                axios
                    .put(`/api/country-master/${partyData.id}`, partyData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        deleteCountryMaster(ctx, queryParams) {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api/country-master/${queryParams.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        addStateMasterData(ctx, userData) {
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/state-master', userData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        editStateMasterData(ctx, partyData) {
            return new Promise((resolve, reject) => {
                axios
                    .put(`/api/state-master/${partyData.id}`, partyData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        deleteStateMaster(ctx, queryParams) {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api/state-master/${queryParams.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        addCityMasterData(ctx, userData) {
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/city-master', userData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        editCityMasterData(ctx, partyData) {
            return new Promise((resolve, reject) => {
                axios
                    .put(`/api/city-master/${partyData.id}`, partyData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        deleteCityMaster(ctx, queryParams) {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api/city-master/${queryParams.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        addEnquiryReference(ctx, referenceData) {
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/enquiry-reference', referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        updateEnquiryReference(ctx, referenceData) {
            return new Promise((resolve, reject) => {
                axios
                    .put(`/api/enquiry-reference/${referenceData.id}`, referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        deleteEnquiryReference(ctx, queryParams) {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api/enquiry-reference/${queryParams.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        addQuotationType(ctx, referenceData) {
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/quotation-type', referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        updateQuotationType(ctx, referenceData) {
            return new Promise((resolve, reject) => {
                axios
                    .put(`/api/quotation-type/${referenceData.id}`, referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        deleteQuotationType(ctx, queryParams) {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api/quotation-type/${queryParams.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        addLeadTitleMaster(ctx, referenceData) {
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/lead-title-master', referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        updateLeadTitleMaster(ctx, referenceData) {
            return new Promise((resolve, reject) => {
                axios
                    .put(`/api/lead-title-master/${referenceData.id}`, referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        deleteLeadTitleMaster(ctx, queryParams) {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api/lead-title-master/${queryParams.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        addLeadStageMaster(ctx, referenceData) {
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/lead-stage-master', referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        updateLeadStageMaster(ctx, referenceData) {
            return new Promise((resolve, reject) => {
                axios
                    .put(`/api/lead-stage-master/${referenceData.id}`, referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        deleteLeadStageMaster(ctx, queryParams) {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api/lead-stage-master/${queryParams.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        addIndustriesTypeMaster(ctx, referenceData) {
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/industries-type-master', referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        updateIndustriesTypeMaster(ctx, referenceData) {
            return new Promise((resolve, reject) => {
                axios
                    .put(`/api/industries-type-master/${referenceData.id}`, referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        deleteIndustriesTypeMaster(ctx, queryParams) {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api/industries-type-master/${queryParams.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        addPurchaseType(ctx, referenceData) {
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/purchase-type', referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        updatePurchaseType(ctx, referenceData) {
            return new Promise((resolve, reject) => {
                axios
                    .put(`/api/purchase-type/${referenceData.id}`, referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        deletePurchaseType(ctx, queryParams) {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api/purchase-type/${queryParams.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        addReasonType(ctx, referenceData) {
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/reason-type', referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        updateReasonType(ctx, referenceData) {
            return new Promise((resolve, reject) => {
                axios
                    .put(`/api/reason-type/${referenceData.id}`, referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        deleteReasonType(ctx, queryParams) {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api/reason-type/${queryParams.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        addDocumentHeader(ctx, referenceData) {
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/document-header', referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        updateDocumentHeader(ctx, referenceData) {
            return new Promise((resolve, reject) => {
                axios
                    .put(`/api/document-header/${referenceData.id}`, referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        deleteDocumentHeader(ctx, queryParams) {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api/document-header/${queryParams.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        addDocumentFooter(ctx, referenceData) {
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/document-footer', referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        updateDocumentFooter(ctx, referenceData) {
            return new Promise((resolve, reject) => {
                axios
                    .put(`/api/document-footer/${referenceData.id}`, referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        deleteDocumentFooter(ctx, queryParams) {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api/document-footer/${queryParams.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        addNoteMaster(ctx, referenceData) {
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/note-master', referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        updateNoteMaster(ctx, referenceData) {
            return new Promise((resolve, reject) => {
                axios
                    .put(`/api/note-master/${referenceData.id}`, referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        deleteNoteMaster(ctx, queryParams) {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api/note-master/${queryParams.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        addMachineMaster(ctx, referenceData) {
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/machine-master', referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        updateMachineMaster(ctx, referenceData) {
            return new Promise((resolve, reject) => {
                axios
                    .put(`/api/machine-master/${referenceData.id}`, referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        deleteMachineMaster(ctx, queryParams) {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api/machine-master/${queryParams.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        addProcessMaster(ctx, referenceData) {
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/process-master', referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        updateProcessMaster(ctx, referenceData) {
            return new Promise((resolve, reject) => {
                axios
                    .put(`/api/process-master/${referenceData.id}`, referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        deleteProcessMaster(ctx, queryParams) {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api/process-master/${queryParams.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        addOperatorMaster(ctx, referenceData) {
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/operator-master', referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        updateOperatorMaster(ctx, referenceData) {
            return new Promise((resolve, reject) => {
                axios
                    .put(`/api/operator-master/${referenceData.id}`, referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        deleteOperatorMaster(ctx, queryParams) {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api/operator-master/${queryParams.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        addPackingMaster(ctx, referenceData) {
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/packing-master', referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        updatePackingMaster(ctx, referenceData) {
            return new Promise((resolve, reject) => {
                axios
                    .put(`/api/packing-master/${referenceData.id}`, referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        deletePackingMaster(ctx, queryParams) {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api/packing-master/${queryParams.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        addDeductionMaster(ctx, referenceData) {
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/payment-deduction-master', referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        updateDeductionMaster(ctx, referenceData) {
            return new Promise((resolve, reject) => {
                axios
                    .put(`/api/payment-deduction-master/${referenceData.id}`, referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        deleteDeductionMaster(ctx, queryParams) {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api/payment-deduction-master/${queryParams.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        addExpenseMaster(ctx, referenceData) {
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/expense-master', referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        updateExpenseMaster(ctx, referenceData) {
            return new Promise((resolve, reject) => {
                axios
                    .put(`/api/expense-master/${referenceData.id}`, referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        deleteExpenseMaster(ctx, queryParams) {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api/expense-master/${queryParams.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        addDocumentTypeMaster(ctx, referenceData) {
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/document-type-master', referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        updateDocumentTypeMaster(ctx, referenceData) {
            return new Promise((resolve, reject) => {
                axios
                    .put(`/api/document-type-master/${referenceData.id}`, referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        deleteDocumentTypeMaster(ctx, queryParams) {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api/document-type-master/${queryParams.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        addBankMaster(ctx, referenceData) {
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/bank-master', referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        updateBankMaster(ctx, referenceData) {
            return new Promise((resolve, reject) => {
                axios
                    .put(`/api/bank-master/${referenceData.id}`, referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        deleteBankMaster(ctx, queryParams) {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api/bank-master/${queryParams.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        addStoreMaster(ctx, referenceData) {
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/store-master', referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        updateStoreMaster(ctx, referenceData) {
            return new Promise((resolve, reject) => {
                axios
                    .put(`/api/store-master/${referenceData.id}`, referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        deleteStoreMaster(ctx, queryParams) {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api/store-master/${queryParams.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        addBranchMaster(ctx, referenceData) {
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/branch-master', referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        updateBranchMaster(ctx, referenceData) {
            return new Promise((resolve, reject) => {
                axios
                    .put(`/api/branch-master/${referenceData.id}`, referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        deleteBranchMaster(ctx, queryParams) {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api/branch-master/${queryParams.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
    },
}
