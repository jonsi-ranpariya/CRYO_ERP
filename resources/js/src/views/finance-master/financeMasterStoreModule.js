import axios from '@axios'

export default {
    namespaced: true,
    state: {
        costCenterList: [],
        chartAccountList: [],
        modalData : []
    },
    getters: {
        getChartAccountList: state => {
            return state.chartAccountList
        },
        getCostCenterList: state =>{
            return state.costCenterList
        }
    },
    mutations: {
        accountList(state, data){
            return state.chartAccountList = data
        },
        setModalData(state, data){
            return state.modalData = data
        },
        centerList(state, data){
            return state.costCenterList = data
        }
    },
    actions: {
        addTdsMaster(ctx, referenceData) {
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/tds-master', referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        updateTdsMaster(ctx, referenceData) {
            return new Promise((resolve, reject) => {
                axios
                    .put(`/api/tds-master/${referenceData.id}`, referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        deleteTdsMaster(ctx, queryParams) {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api/tds-master/${queryParams.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        addPaymentModeMaster(ctx, referenceData) {
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/payment-mode-master', referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        updatePaymentModeMaster(ctx, referenceData) {
            return new Promise((resolve, reject) => {
                axios
                    .put(`/api/payment-mode-master/${referenceData.id}`, referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        deletePaymentModeMaster(ctx, queryParams) {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api/payment-mode-master/${queryParams.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        addNarrationMaster(ctx, referenceData) {
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/narration-master', referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        updateNarrationMaster(ctx, referenceData) {
            return new Promise((resolve, reject) => {
                axios
                    .put(`/api/narration-master/${referenceData.id}`, referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        deleteNarrationModeMaster(ctx, queryParams) {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api/narration-master/${queryParams.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        addChequePrintingFormatMaster(ctx, referenceData) {
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/cheque-printing-master', referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        updateChequePrintingFormatMaster(ctx, referenceData) {
            return new Promise((resolve, reject) => {
                axios
                    .put(`/api/cheque-printing-master/${referenceData.id}`, referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        deleteChequePrintingFormatMaster(ctx, queryParams) {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api/cheque-printing-master/${queryParams.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        AddUpdateAccountParamMaster(ctx, referenceData) {
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/save-common-settings', referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        fetchChartOfAccounts(ctx){
            axios
                .get('/api/get-chart-of-accounts-options')
                .then((response) => {
                    ctx.commit("accountList",response.data.data)
                })
        },
        openModal(ctx, setModalData){
            ctx.commit("setModalData", setModalData.data)
            return new Promise((resolve, reject) => {
                axios
                    .get(`/api/chart-of-accounts-master/` + setModalData.data.d_id)
            })
        },
        addChartOfAccounts(ctx, referenceData){
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/chart-of-accounts-master', referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        updateChartOfAccounts(ctx, referenceData){
            return new Promise((resolve, reject) => {
                axios
                    .put('/api/chart-of-accounts-master/'+referenceData.d_id, referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        addGeneralLedgerMaster(ctx, payload){
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/general-ledger-accounts',payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        fetchGeneralLedgerMaster(ctx, {id}){
            return new Promise((resolve, reject) => {
                axios
                    .get(`/api/general-ledger-accounts/${id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        updateGeneralLedgerMaster(ctx, payload){
            return new Promise((resolve, reject) => {
                axios
                    .put(`/api/general-ledger-accounts/${payload.id}`,payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        deleteGeneralLedgerMaster(ctx, {id}){
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api/general-ledger-accounts/${id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        addBudgetMaster(ctx, payload){
            return new Promise((resolve, reject) => {
                axios
                    .post(`/api/budget-master/`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        fetchBudgetMaster(ctx, {id}){
            return new Promise((resolve, reject) => {
                axios
                    .get(`/api/budget-master/${id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        updateBudgetMaster(ctx, payload){
            return new Promise((resolve, reject) => {
                axios
                    .put(`/api/budget-master/${payload.id}`,payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        deleteBudgetMaster(ctx, {id}){
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api/budget-master/${id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        addCostCenterMaster(ctx, referenceData){
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/cost-center-master', referenceData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        fetchCostCenterList(ctx){
            axios
                .get('/api/cost-center-list-tree')
                .then((response) => {
                    ctx.commit("centerList",response.data.data)
                })
        },
        updateCostCenterMaster(ctx, payload){
            return new Promise((resolve, reject) => {
                axios
                    .put(`/api/cost-center-master/${payload.d_id}`,payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        }
    }
}
