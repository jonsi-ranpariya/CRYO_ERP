import axios from '@axios'

export default {
    namespaced: true,
    state: {
        showOverlayLoading: false,
        isAddNewUserSidebarActive: false,
        gradeMasterList: [],
        branchMasterList: [],
        departmentMasterList: [],
        divisionMasterList: [],
        unitMasterList: [],
        categoryMasterList: [],
        groupMasterList: [],
        designationMasterList: [],
    },
    getters: {
        getGradeMasterList: state => {
            return state.gradeMasterList;
        },
        getBranchMasterList: state => {
            return state.branchMasterList;
        },
        getDepartmentMasterList: state => {
            return state.departmentMasterList;
        },
        getDivisionMasterList: state => {
            return state.divisionMasterList;
        },
        getUnitMasterList: state => {
            return state.unitMasterList;
        },
        getCategoryMasterList: state => {
            return state.categoryMasterList;
        },
        getDesignationMasterList: state => {
            return state.designationMasterList;
        },
        getGroupMasterList: state => {
            return state.groupMasterList;
        }
    },
    mutations: {
        gradeMasterList(state, data) {
            state.gradeMasterList = data;
        },
        branchMasterList(state, data) {
            state.branchMasterList = data;
        },
        departmentMasterList(state, data) {
            state.departmentMasterList = data;
        },
        divisionMasterList(state, data) {
            state.divisionMasterList = data;
        },
        unitMasterList(state, data) {
            state.unitMasterList = data;
        },
        categoryMasterList(state, data) {
            state.categoryMasterList = data;
        },
        groupMasterList(state, data) {
            state.groupMasterList = data;
        },
        designationMasterList(state, data) {
            state.designationMasterList = data;
        },
        sideBarShowHide(state, val) {
            state.isAddNewUserSidebarActive = val
        }
    },
    actions: {
        async listGradeMaster(ctx, payload) {
            ctx.state.showOverlayLoading = true
            return await new Promise((resolve, reject) => {
                axios
                    .get(`/api/new/grade-master`)
                    .then(response => {
                        resolve(response)
                        ctx.commit('gradeMasterList', response.data)
                        ctx.state.showOverlayLoading = false
                    })
                    .catch(error => {
                        reject(error)
                        ctx.state.showOverlayLoading = false
                    });
            });
        },
        async insertGradeMaster(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .post(`/api/new/grade-master`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            });
        },
        async updateGradeMaster(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/new/grade-master/${payload._id}`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            });
        },
        async deleteGradeMaster(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/new/grade-master/${payload.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            });
        },
        /* Branch Master*/
        async listBranchMaster(ctx, payload) {
            ctx.state.showOverlayLoading = true
            return await new Promise((resolve, reject) => {
                axios
                    .get(`/api/new/hr-branch-master`)
                    .then(response => {
                        resolve(response)
                        ctx.commit('branchMasterList', response.data)
                        ctx.state.showOverlayLoading = false
                    })
                    .catch(error => {
                        reject(error)
                        ctx.state.showOverlayLoading = false
                    });
            });
        },
        async insertBranchMaster(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .post(`/api/new/hr-branch-master`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            });
        },
        async updateBranchMaster(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/new/hr-branch-master/${payload._id}`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            });
        },
        async deleteBranchMaster(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/new/hr-branch-master/${payload.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            });
        },
        /* Department Master*/
        async listDepartmentMaster(ctx, payload) {
            ctx.state.showOverlayLoading = true
            return await new Promise((resolve, reject) => {
                axios
                    .get(`/api/new/hr-department-master`)
                    .then(response => {
                        resolve(response)
                        ctx.commit('departmentMasterList', response.data)
                        ctx.state.showOverlayLoading = false
                    })
                    .catch(error => {
                        reject(error)
                        ctx.state.showOverlayLoading = false
                    });
            });
        },
        async insertDepartmentMaster(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .post(`/api/new/hr-department-master`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            });
        },
        async updateDepartmentMaster(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/new/hr-department-master/${payload._id}`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            });
        },
        async deleteDepartmentMaster(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/new/hr-department-master/${payload.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            });
        },
        /* Department Master*/
        async listDivisionMaster(ctx, payload) {
            ctx.state.showOverlayLoading = true
            return await new Promise((resolve, reject) => {
                axios
                    .get(`/api/new/division-master`)
                    .then(response => {
                        resolve(response)
                        ctx.commit('divisionMasterList', response.data)
                        ctx.state.showOverlayLoading = false
                    })
                    .catch(error => {
                        reject(error)
                        ctx.state.showOverlayLoading = false
                    });
            });
        },
        async insertDivisionMaster(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .post(`/api/new/division-master`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            });
        },
        async updateDivisionMaster(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/new/division-master/${payload._id}`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            });
        },
        async deleteDivisionMaster(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/new/division-master/${payload.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            });
        },
        /* Unit Master */
        async listUnitMaster(ctx, payload) {
            ctx.state.showOverlayLoading = true
            return await new Promise((resolve, reject) => {
                axios
                    .get(`/api/new/unit-master`)
                    .then(response => {
                        resolve(response)
                        ctx.commit('unitMasterList', response.data)
                        ctx.state.showOverlayLoading = false
                    })
                    .catch(error => {
                        reject(error)
                        ctx.state.showOverlayLoading = false
                    });
            });
        },
        async insertUnitMaster(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .post(`/api/new/unit-master`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            });
        },
        async updateUnitMaster(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/new/unit-master/${payload._id}`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            });
        },
        async deleteUnitMaster(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/new/unit-master/${payload.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            });
        },
        /* Category Master */
        async listCategoryMaster(ctx, payload) {
            ctx.state.showOverlayLoading = true
            return await new Promise((resolve, reject) => {
                axios
                    .get(`/api/new/category-master`)
                    .then(response => {
                        resolve(response)
                        ctx.commit('categoryMasterList', response.data)
                        ctx.state.showOverlayLoading = false
                    })
                    .catch(error => {
                        reject(error)
                        ctx.state.showOverlayLoading = false
                    });
            });
        },
        async insertCategoryMaster(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .post(`/api/new/category-master`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            });
        },
        async updateCategoryMaster(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/new/category-master/${payload._id}`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            });
        },
        async deleteCategoryMaster(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/new/category-master/${payload.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            });
        },
        /* Group Master */
        async listGroupMaster(ctx, payload) {
            ctx.state.showOverlayLoading = true
            return await new Promise((resolve, reject) => {
                axios
                    .get(`/api/new/group-master`)
                    .then(response => {
                        resolve(response)
                        ctx.commit('groupMasterList', response.data)
                        ctx.state.showOverlayLoading = false
                    })
                    .catch(error => {
                        reject(error)
                        ctx.state.showOverlayLoading = false
                    });
            });
        },
        async insertGroupMaster(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .post(`/api/new/group-master`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            });
        },
        async updateGroupMaster(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/new/group-master/${payload._id}`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            });
        },
        async deleteGroupMaster(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/new/group-master/${payload.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            });
        },
        /* Designation Master */
        async listDesignationMaster(ctx, payload) {
            ctx.state.showOverlayLoading = true
            return await new Promise((resolve, reject) => {
                axios
                    .get(`/api/new/hr-designation-master`)
                    .then(response => {
                        resolve(response)
                        ctx.commit('designationMasterList', response.data)
                        ctx.state.showOverlayLoading = false
                    })
                    .catch(error => {
                        reject(error)
                        ctx.state.showOverlayLoading = false
                    });
            });
        },
        async insertDesignationMaster(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .post(`/api/new/hr-designation-master`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            });
        },
        async updateDesignationMaster(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`/api/new/hr-designation-master/${payload._id}`, payload)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            });
        },
        async deleteDesignationMaster(ctx, payload) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`/api/new/hr-designation-master/${payload.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            });
        },
    },
}
