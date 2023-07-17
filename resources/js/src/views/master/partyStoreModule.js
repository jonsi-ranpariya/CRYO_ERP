import axios from '@axios'
export default {
    namespaced: true,
    state: {
        partyGroupMasterList: [],
        partyContactPersonList: [],
    },
    getters: {
        getPartyGroupMasterList(state){
            return state.partyGroupMasterList
        },
        getPartyContactPersonList(state){
            return state.partyContactPersonList
        }
    },
    mutations: {
        groupList(state, data){
            return state.partyGroupMasterList = data
        },
        contactPersonList(state, data){
            return state.partyContactPersonList = data
        }
    },
    actions: {
        fetchPartyDetail(ctx, {id}) {
            return new Promise((resolve, reject) => {
                axios
                    .get(`/api/party/edit/${id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async addPartyMaster(ctx, userData) {
            return await new Promise((resolve, reject) => {
                axios
                    .post('/api/party/store', userData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async editPartyMaster(ctx, userData) {
            return await new Promise((resolve, reject) => {
                axios
                    .post('/api/party/update', userData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        async deletePartyMaster(ctx, queryParams) {
            return await new Promise((resolve, reject) => {
                axios
                    .get(`/api/party/destroy/${queryParams.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        /* Party Group Master Store */
        fetchPartyGroupMasterList(ctx){
                axios
                    .get(`/api/party-group`)
                    .then((response) => {
                        ctx.commit('groupList',response.data.data)
                    })
        },
        getPartyGroupMaster(ctx, queryParams){
            return new Promise((resolve, reject) => {
                axios
                    .get(`/api/party-group/${queryParams.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        addPartyGroupMaster(ctx, partyData) {
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/party-group', partyData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        updatePartyGroupMaster(ctx,partyData){
          return new Promise((resolve,reject) => {
              axios
                  .put(`/api/party-group/${partyData.id}`,partyData)
                  .then(response => resolve(response))
                  .catch(error => reject(error))
          })
        },
        deletePartyGroupMaster(ctx, queryParams){
            return new Promise((resolve,reject) => {
                axios
                    .delete(`/api/party-group/${queryParams.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        fetchPartyContactPersonList(ctx,payload){
            return new Promise((resolve,reject) => {
                axios
                    .get(`/api/party/get-party-contacts/${payload.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        addContactPerson(ctx, payload){
            return new Promise((resolve,reject) => {
                axios
                    .post('/api/party/contact-person',payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        updateContactPerson(ctx, payload){
            return new Promise((resolve,reject) => {
                axios
                    .put(`/api/party/contact-person/${payload.id}`,payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        deletePartyContactPerson(ctx, queryParams){
            return new Promise((resolve,reject) => {
                axios
                    .delete(`/api/party/contact-person/${queryParams.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        fetchPartyTermDetails(ctx, payload){
            return new Promise((resolve,reject) => {
                axios
                    .get(`/api/party/get-party-term-condition/${payload.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        addPartyTermDetails(ctx, payload){
            return new Promise((resolve,reject) => {
                axios
                    .post('/api/party/term-condition',payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        updatePartyTermDetails(ctx, payload){
            return new Promise((resolve,reject) => {
                axios
                    .put(`/api/party/term-condition/${payload.id}`,payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        deletePartyTermDetails(ctx, queryParams){
            return new Promise((resolve,reject) => {
                axios
                    .delete(`/api/party/term-condition/${queryParams.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        fetchPartyBillingTerm(ctx, payload){
            return new Promise((resolve,reject) => {
                axios
                    .get(`/api/party/get-party-billing-term/${payload.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        addPartyBillingTerm(ctx, payload){
            return new Promise((resolve,reject) => {
                axios
                    .post('/api/party/billing-term',payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        updatePartyBillingTerm(ctx, payload){
            return new Promise((resolve,reject) => {
                axios
                    .put(`/api/party/billing-term/${payload.id}`,payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        deletePartyBillingTerm(ctx, queryParams){
            return new Promise((resolve,reject) => {
                axios
                    .delete(`/api/party/billing-term/${queryParams.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        fetchPartyDeliveryAddress(ctx, payload){
            return new Promise((resolve,reject) => {
                axios
                    .get(`/api/party/get-party-delivery-address/${payload.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        addDeliveryAddress(ctx, payload){
            return new Promise((resolve,reject) => {
                axios
                    .post('/api/party/delivery-address',payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        updateDeliveryAddress(ctx, payload){
            return new Promise((resolve,reject) => {
                axios
                    .put(`/api/party/delivery-address/${payload.id}`,payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        deleteDeliveryAddress(ctx, payload){
            return new Promise((resolve,reject) => {
                axios
                    .delete(`/api/party/delivery-address/${payload.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
    },
}
