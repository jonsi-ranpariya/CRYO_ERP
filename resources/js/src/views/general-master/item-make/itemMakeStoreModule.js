import axios from '@axios'

export default {
    namespaced: true,
    state: {
        itemMakeList: []
    },
    getters: {
        getItemMakeList(state) {
            return state.itemMakeList
        }
    },
    mutations: {
        itemList(state, data){
            return state.itemMakeList = data
        }
    },
    actions: {
        fetchItemMakeMasterList(ctx){
            axios
                .get('/api/item-make-master')
                .then((response) => {
                    ctx.commit("itemList",response.data.data)
                })
        },
        getItemMakeMaster(ctx,queryParams){
            return new Promise((resolve, reject) => {
                axios
                    .get(`/api/item-make-master/${queryParams.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        addItemMakeMaster(ctx, data){
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/item-make-master', data)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        updateItemMakeMaster(ctx,data){
            return new Promise((resolve,reject) => {
                axios
                    .put(`/api/item-make-master/${data.id}`,data)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        deleteItemMakeMaster(ctx, queryParams){
            return new Promise((resolve,reject) => {
                axios
                    .delete(`/api/item-make-master/${queryParams.id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        }
    },
}
