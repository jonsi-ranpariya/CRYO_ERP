import axios from '@axios'

export default {
    namespaced: true,
    state: {},
    getters: {},
    mutations: {},
    actions: {
        fetchUsers(ctx, queryParams) {
            return new Promise((resolve, reject) => {
                axios
                    .get('/api/get-users-list', { params: queryParams })
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        fetchUser(ctx, { id }) {
            return new Promise((resolve, reject) => {
                axios
                    .get(`/apps/user/users/${id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        addUser(ctx, userData) {
            return new Promise((resolve, reject) => {
                axios
                    .post('/apps/user/users', { user: userData })
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },

        /*User Management Data Add,Edit,Delete*/
        async addUserManagementDetail(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .post("/api/users", payload)
                    .then((response) => resolve(response))
                    .catch((error) => reject(error));
            });
        },
        async updateUserManagementDetail(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/users/${payload._id}`, payload)
                    .then((response) => resolve(response))
                    .catch((error) => reject(error));
            });
        },
        async deleteUserManagementDetail(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api//${payload.id}`)
                    .then((response) => resolve(response))
                    .catch((error) => reject(error));
            });
        },
    },
}
