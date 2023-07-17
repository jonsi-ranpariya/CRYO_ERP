    /*

Array of object

Top level object can be:
1. Header
2. Group (Group can have navItems as children)
3. navItem

* Supported Options

/--- Header ---/

header

/--- nav Grp ---/

title
icon (if it's on top level)
tag
tagVariant
children

/--- nav Item ---/

icon (if it's on top level)
title
route: [route_obj/route_name] (I have to resolve name somehow from the route obj)
tag
tagVariant

*/

import dashboard from './dashboard'
import UserMenu from './users-menu'
import MasterMenu from './master-menu'
import SalescrmMenu from './sales-and-crm-menu'
import ProductionPlaningMenu from './production-and-planing-menu'
import EnggAndBomMenu from './Engineering-and-bom-menu'
import MrpMenu from './mrp-menu'
import PurchaseMenu from './purchase-menu'
import billBookingMenu from './bill-booking-menu'
import jonWorkMenu from './job-work-menu'
import InventoryMenu from './inventory-menu'
import QualityControlMenu from './quality-control-menu'
import DispatchMenu from './dispatch-menu'
import ServiceMenu from './service-menu'
import FixAssetsMenu from './fixedassets-menu'
import FinanceMenu from './finance-menu'
import MiscReportsMenu from './misc-reports-menu'
import GraphicalReportMenu from './graphical-report-menu'
import StatutoryReportMenu from './statutory-reports-menu'
import UtilityMenu from './utility-menu'
import AdministrationMenu from './administration-menu'
import ExciseMenu from './excise-menu'
import hrMenu from './hr-menu'
import hrMasterMenu from './hr-master-menu'

// import appsAndPages from './apps-and-pages'
// import others from './others'
// import chartsAndMaps from './charts-and-maps'
// import uiElements from './ui-elements'
// import formAndTable from './forms-and-table'

//...appsAndPages, ...uiElements, ...formAndTable, ...chartsAndMaps, ...others

// Array of sections

export default [
    ...dashboard,
    // ...UserMenu,
    ...MasterMenu,
    ...hrMasterMenu,
    ...SalescrmMenu,
    ...ProductionPlaningMenu,
    ...EnggAndBomMenu,
    ...MrpMenu,
    ...PurchaseMenu,
    ...billBookingMenu,
    ...jonWorkMenu,
    ...InventoryMenu,
    ...QualityControlMenu,
    ...DispatchMenu,
    ...ServiceMenu,
    ...FixAssetsMenu,
    ...FinanceMenu,
    ...MiscReportsMenu,
    ...GraphicalReportMenu,
    ...StatutoryReportMenu,
    ...UtilityMenu,
    ...hrMenu,
    ...AdministrationMenu,
    ...ExciseMenu,
    // ...appsAndPages,
    // ...uiElements,
    // ...formAndTable,
    // ...chartsAndMaps,
    // ...others
]
