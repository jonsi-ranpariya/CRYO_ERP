import axios from '@axios'

export default {
    namespaced: true,
    state: {
        showOverlayLoading: false,
        isAddNewUserSidebarActive: false,
        serialMasterList: []
    },
    getters: {
        getSerialMasterList: state => {
            return state.serialMasterList;
        },
    },
    mutations: {
        serialMasterList(state, data) {
            state.serialMasterList = data;
        },
        sideBarShowHide(state, val){
            state.isAddNewUserSidebarActive = val
        }
    },
    actions: {
        async listSerialMaster(ctx, payload) {
            ctx.state.showOverlayLoading = true
            return await new Promise((resolve, reject) => {
                axios
                    .get(`/api/serial-master`)
                    .then(response => {
                        resolve(response)
                        ctx.commit('serialMasterList', response.data.data)
                        ctx.state.showOverlayLoading = false
                    })
                    .catch(error => {
                        reject(error)
                        ctx.state.showOverlayLoading = false
                    });
            });
        },
        async insertSerialMaster(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .post(`/api/serial-master`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            });
        },
        async updateSerialMaster(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/serial-master/${payload._id}`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            });
        },
        async deleteSerialMaster(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/serial-master/${payload.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            });
        },
    }
}
