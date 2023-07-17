import Vue from 'vue'
import VueRouter from 'vue-router'

// Routes
import {canNavigate} from '@/libs/acl/routeProtection'
import {isUserLoggedIn, getUserData, getHomeRouteForLoggedInUser} from '@/auth/utils'
import apps from './routes/apps'
import dashboard from './routes/dashboard'
import uiElements from './routes/ui-elements/index'
import pages from './routes/pages'
import chartsMaps from './routes/charts-maps'
import formsTable from './routes/forms-tables'
import others from './routes/others'
import MasterRoute from './routes/master'
import GeneralMasterRoute from './routes/general-master'
import DispatchRoute from './routes/dispatch'
import Finance from './routes/finance'
import SalesAndCRM from './routes/sales-crm'
import EngBom from './routes/eng-bom'
import ProductionPlanning from './routes/production-planning'
import MrpRouter from './routes/mrp-router'
import PurchaseRouter from './routes/purchase-router'
import billBooking from './routes/bill-booking'
import jobWork from './routes/job-work'
import inventory from "./routes/inventory";
import QualityControl from "./routes/quality-control"
import administrator from "./routes/administrator";
import hr from './routes/hr';
import hrMaster from './routes/hr-master';

Vue.use(VueRouter)

const router = new VueRouter({
    //mode: 'history',
    base: process.env.BASE_URL,
    scrollBehavior() {
        return {x: 0, y: 0}
    },
    routes: [
        {path: '/', redirect: {name: 'dashboard-analytics'}},
        ...administrator,
        ...apps,
        ...dashboard,
        ...pages,
        ...chartsMaps,
        ...formsTable,
        ...uiElements,
        ...others,
        ...MasterRoute,
        ...GeneralMasterRoute,
        ...DispatchRoute,
        ...Finance,
        ...SalesAndCRM,
        ...EngBom,
        ...ProductionPlanning,
        ...PurchaseRouter,
        ...billBooking,
        ...MrpRouter,
        ...jobWork,
        ...inventory,
        ...QualityControl,
        ...hr,
        ...hrMaster,
        {
            path: '*',
            redirect: 'error-404',
        },
    ],
})

router.beforeEach((to, _, next) => {
    const isLoggedIn = isUserLoggedIn()

    if (!canNavigate(to)) {
        // Redirect to login if not logged in
        if (!isLoggedIn) return next({name: 'auth-login'})

        // If logged in => not authorized
        return next({name: 'misc-not-authorized'})
    }

    // Redirect if logged in
    if (to.meta.redirectIfLoggedIn && isLoggedIn) {
        const userData = getUserData()
        next(getHomeRouteForLoggedInUser(userData ? userData.role : null))
    }

    return next()
})

// ? For splash screen
// Remove afterEach hook if you are not using splash screen
router.afterEach(() => {
    // Remove initial loading
    const appLoading = document.getElementById('loading-bg')
    if (appLoading) {
        appLoading.style.display = 'none'
    }
})

export default router
