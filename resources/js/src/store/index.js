import Vue from 'vue'
import Vuex from 'vuex'

// Modules
import ecommerceStoreModule from '@/views/apps/e-commerce/eCommerceStoreModule'
import app from './app'
import appConfig from './app-config'
import verticalMenu from './vertical-menu'
import partyStoreModule from "../views/master/partyStoreModule";
import itemMakeStoreModule from "../views/general-master/item-make/itemMakeStoreModule";
import financeMasterStoreModule from "../views/finance-master/financeMasterStoreModule";
import serialMasterStore from "../views/master/serial-master/store/serialMasterStore";
import hrMasterStoreModule from "../views/hr-master/hrMasterStoreModule";


Vue.use(Vuex)

export default new Vuex.Store({
    modules: {
        app,
        appConfig,
        verticalMenu,
        partyStoreModule,
        itemMakeStoreModule,
        financeMasterStoreModule,
        serialMasterStore,
        hrMasterStoreModule,
        'app-ecommerce': ecommerceStoreModule,
    },
    strict: process.env.DEV,
})
