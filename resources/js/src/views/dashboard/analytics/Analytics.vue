<template>
    <section id="dashboard-analytics">

        <!-- Stats Card Vertical -->
        <div v-if="$can('manage', 'all')">
            <calendar
            />
            <!--            <b-row class="match-height">-->
            <!--                <b-col-->
            <!--                    xl="2"-->
            <!--                    md="4"-->
            <!--                    sm="6"-->
            <!--                >-->
            <!--                    <statistic-card-vertical-->
            <!--                        icon="FileMinusIcon"-->
            <!--                        statistic="0"-->
            <!--                        statistic-title="Pending Activities"-->
            <!--                        color="primary"-->
            <!--                    />-->
            <!--                </b-col>-->
            <!--                <b-col-->
            <!--                    xl="2"-->
            <!--                    md="4"-->
            <!--                    sm="6"-->
            <!--                >-->
            <!--                    <statistic-card-vertical-->
            <!--                        icon="CheckCircleIcon"-->
            <!--                        statistic="0"-->
            <!--                        statistic-title="Enquiry Approval"-->
            <!--                        color="primary"-->
            <!--                    />-->
            <!--                </b-col>-->
            <!--                <b-col-->
            <!--                    xl="2"-->
            <!--                    md="4"-->
            <!--                    sm="6"-->
            <!--                >-->
            <!--                    <statistic-card-vertical-->
            <!--                        icon="DollarSignIcon"-->
            <!--                        statistic="0"-->
            <!--                        statistic-title="Quotes Approval"-->
            <!--                        color="primary"-->
            <!--                    />-->
            <!--                </b-col>-->
            <!--                <b-col-->
            <!--                    xl="2"-->
            <!--                    md="4"-->
            <!--                    sm="6"-->
            <!--                >-->
            <!--                    <statistic-card-vertical-->
            <!--                        icon="FileTextIcon"-->
            <!--                        statistic="0"-->
            <!--                        statistic-title="PI Approval"-->
            <!--                        color="primary"-->
            <!--                    />-->
            <!--                </b-col>-->
            <!--                <b-col-->
            <!--                    xl="2"-->
            <!--                    md="4"-->
            <!--                    sm="6"-->
            <!--                >-->
            <!--                    <statistic-card-vertical-->
            <!--                        icon="ShoppingBagIcon"-->
            <!--                        statistic="0"-->
            <!--                        statistic-title="Order Approval"-->
            <!--                        color="primary"-->
            <!--                    />-->
            <!--                </b-col>-->
            <!--                <b-col-->
            <!--                    xl="2"-->
            <!--                    md="4"-->
            <!--                    sm="6"-->
            <!--                >-->
            <!--                    <statistic-card-vertical-->
            <!--                        icon="BookOpenIcon"-->
            <!--                        statistic="0"-->
            <!--                        statistic-title="Open Orders"-->
            <!--                        color="primary"-->
            <!--                    />-->
            <!--                </b-col>-->

            <!--                <b-col-->
            <!--                    xl="2"-->
            <!--                    md="4"-->
            <!--                    sm="6"-->
            <!--                >-->
            <!--                    <statistic-card-vertical-->
            <!--                        icon="TruckIcon"-->
            <!--                        statistic="0"-->
            <!--                        statistic-title="Dispatch Today"-->
            <!--                        color="primary"-->
            <!--                    />-->
            <!--                </b-col>-->

            <!--                <b-col-->
            <!--                    xl="2"-->
            <!--                    md="4"-->
            <!--                    sm="6"-->
            <!--                >-->
            <!--                    <statistic-card-vertical-->
            <!--                        icon="ShoppingCartIcon"-->
            <!--                        statistic="0"-->
            <!--                        statistic-title="Total Orders"-->
            <!--                        color="primary"-->
            <!--                    />-->
            <!--                </b-col>-->

            <!--                <b-col-->
            <!--                    xl="2"-->
            <!--                    md="4"-->
            <!--                    sm="6"-->
            <!--                >-->
            <!--                    <statistic-card-vertical-->
            <!--                        icon="AlertTriangleIcon"-->
            <!--                        statistic="0"-->
            <!--                        statistic-title="Work Order Shortage"-->
            <!--                        color="primary"-->
            <!--                    />-->
            <!--                </b-col>-->

            <!--                <b-col-->
            <!--                    xl="2"-->
            <!--                    md="4"-->
            <!--                    sm="6"-->
            <!--                >-->
            <!--                    <statistic-card-vertical-->
            <!--                        icon="BatteryIcon"-->
            <!--                        statistic="0"-->
            <!--                        statistic-title="VieMin Level Shortage"-->
            <!--                        color="primary"-->
            <!--                    />-->
            <!--                </b-col>-->

            <!--                <b-col-->
            <!--                    xl="2"-->
            <!--                    md="4"-->
            <!--                    sm="6"-->
            <!--                >-->
            <!--                    <statistic-card-vertical-->
            <!--                        icon="BookOpenIcon"-->
            <!--                        statistic="0"-->
            <!--                        statistic-title="Open Indent"-->
            <!--                        color="primary"-->
            <!--                    />-->
            <!--                </b-col>-->

            <!--                <b-col-->
            <!--                    xl="2"-->
            <!--                    md="4"-->
            <!--                    sm="6"-->
            <!--                >-->
            <!--                    <statistic-card-vertical-->
            <!--                        icon="CheckIcon"-->
            <!--                        statistic="0"-->
            <!--                        statistic-title="Indent Approval"-->
            <!--                        color="primary"-->
            <!--                    />-->
            <!--                </b-col>-->

            <!--                <b-col-->
            <!--                    xl="2"-->
            <!--                    md="4"-->
            <!--                    sm="6"-->
            <!--                >-->
            <!--                    <statistic-card-vertical-->
            <!--                        icon="ClipboardIcon"-->
            <!--                        statistic="0"-->
            <!--                        statistic-title="Purchase Order Approval"-->
            <!--                        color="primary"-->
            <!--                    />-->
            <!--                </b-col>-->

            <!--                <b-col-->
            <!--                    xl="2"-->
            <!--                    md="4"-->
            <!--                    sm="6"-->
            <!--                >-->
            <!--                    <statistic-card-vertical-->
            <!--                        icon="CornerUpLeftIcon"-->
            <!--                        statistic="0"-->
            <!--                        statistic-title="Inward Material Today"-->
            <!--                        color="primary"-->
            <!--                    />-->
            <!--                </b-col>-->

            <!--                <b-col-->
            <!--                    xl="2"-->
            <!--                    md="4"-->
            <!--                    sm="6"-->
            <!--                >-->
            <!--                    <statistic-card-vertical-->
            <!--                        icon="FileMinusIcon"-->
            <!--                        statistic="0"-->
            <!--                        statistic-title="Open Work Orders"-->
            <!--                        color="primary"-->
            <!--                    />-->
            <!--                </b-col>-->

            <!--                <b-col-->
            <!--                    xl="2"-->
            <!--                    md="4"-->
            <!--                    sm="6"-->
            <!--                >-->
            <!--                    <statistic-card-vertical-->
            <!--                        icon="PlayIcon"-->
            <!--                        statistic="0"-->
            <!--                        statistic-title="Open Job Cards"-->
            <!--                        color="primary"-->
            <!--                    />-->
            <!--                </b-col>-->

            <!--                <b-col-->
            <!--                    xl="2"-->
            <!--                    md="4"-->
            <!--                    sm="6"-->
            <!--                >-->
            <!--                    <statistic-card-vertical-->
            <!--                        icon="PlayCircleIcon"-->
            <!--                        statistic="0"-->
            <!--                        statistic-title="Open Job Work Orders"-->
            <!--                        color="primary"-->
            <!--                    />-->
            <!--                </b-col>-->

            <!--                <b-col-->
            <!--                    xl="2"-->
            <!--                    md="4"-->
            <!--                    sm="6"-->
            <!--                >-->
            <!--                    <statistic-card-vertical-->
            <!--                        icon="FileMinusIcon"-->
            <!--                        statistic="0"-->
            <!--                        statistic-title="Pend WO Requisition"-->
            <!--                        color="primary"-->
            <!--                    />-->
            <!--                </b-col>-->

            <!--                <b-col-->
            <!--                    xl="2"-->
            <!--                    md="4"-->
            <!--                    sm="6"-->
            <!--                >-->
            <!--                    <statistic-card-vertical-->
            <!--                        icon="ArrowDownCircleIcon"-->
            <!--                        statistic="0"-->
            <!--                        statistic-title="Inward QC"-->
            <!--                        color="primary"-->
            <!--                    />-->
            <!--                </b-col>-->

            <!--                <b-col-->
            <!--                    xl="2"-->
            <!--                    md="4"-->
            <!--                    sm="6"-->
            <!--                >-->
            <!--                    <statistic-card-vertical-->
            <!--                        icon="ArrowDownIcon"-->
            <!--                        statistic="0"-->
            <!--                        statistic-title="Job Card Inside QC"-->
            <!--                        color="primary"-->
            <!--                    />-->
            <!--                </b-col>-->

            <!--                <b-col-->
            <!--                    xl="2"-->
            <!--                    md="4"-->
            <!--                    sm="6"-->
            <!--                >-->
            <!--                    <statistic-card-vertical-->
            <!--                        icon="UploadIcon"-->
            <!--                        statistic="0"-->
            <!--                        statistic-title="Job Card Outside QC"-->
            <!--                        color="primary"-->
            <!--                    />-->
            <!--                </b-col>-->

            <!--                <b-col-->
            <!--                    xl="2"-->
            <!--                    md="4"-->
            <!--                    sm="6"-->
            <!--                >-->
            <!--                    <statistic-card-vertical-->
            <!--                        icon="FilePlusIcon"-->
            <!--                        statistic="0"-->
            <!--                        statistic-title="Item Master Approval"-->
            <!--                        color="primary"-->
            <!--                    />-->
            <!--                </b-col>-->

            <!--                <b-col-->
            <!--                    xl="2"-->
            <!--                    md="4"-->
            <!--                    sm="6"-->
            <!--                >-->
            <!--                    <statistic-card-vertical-->
            <!--                        icon="UserCheckIcon"-->
            <!--                        statistic="0"-->
            <!--                        statistic-title="Party Master Approval"-->
            <!--                        color="primary"-->
            <!--                    />-->
            <!--                </b-col>-->

            <!--            </b-row>-->
        </div>

        <div v-else-if="$can('read', 'ACL')">
            <b-row class="match-height">
                <b-col
                    md="3"
                >
                    <statistic-card-vertical
                        icon="FileMinusIcon"
                        statistic="0"
                        statistic-title="Pending Activities"
                        color="primary"
                    />
                </b-col>
                <b-col
                    md="3"
                >
                    <statistic-card-vertical
                        icon="CheckCircleIcon"
                        statistic="0"
                        statistic-title="Enquiry Approval"
                        color="danger"
                    />
                </b-col>
                <b-col
                    md="3"
                >
                    <statistic-card-vertical
                        icon="DollarSignIcon"
                        statistic="0"
                        statistic-title="Quotes Approval"
                        color="warning"
                    />
                </b-col>
                <b-col
                    md="3"
                >
                    <statistic-card-vertical
                        icon="FileTextIcon"
                        statistic="0"
                        statistic-title="PI Approval"
                        color="success"
                    />
                </b-col>
            </b-row>
        </div>

        <!--        <b-row class="match-height">
                <b-col
                    lg="6"
                    md="12"
                >
                    <analytics-congratulation :data="data.congratulations"/>
                </b-col>
                <b-col
                    lg="3"
                    sm="6"
                >
                    <statistic-card-with-area-chart
                        v-if="data.subscribersGained"
                        icon="UsersIcon"
                        :statistic="kFormatter(data.subscribersGained.analyticsData.subscribers)"
                        statistic-title="Subscribers Gained"
                        :chart-data="data.subscribersGained.series"
                    />
                </b-col>
                <b-col
                    lg="3"
                    sm="6"
                >
                    <statistic-card-with-area-chart
                        v-if="data.ordersRecevied"
                        icon="PackageIcon"
                        color="warning"
                        :statistic="kFormatter(data.ordersRecevied.analyticsData.orders)"
                        statistic-title="Orders Received"
                        :chart-data="data.ordersRecevied.series"
                    />
                </b-col>
            </b-row>

            <b-row class="match-height">
                <b-col lg="6">
                    <analytics-avg-sessions :data="data.avgSessions"/>
                </b-col>
                <b-col lg="6">
                    <analytics-support-tracker :data="data.supportTracker"/>
                </b-col>
            </b-row>

            <b-row class="match-height">
                <b-col lg="4">
                    <analytics-timeline :data="data.timeline"/>
                </b-col>
                <b-col lg="4">
                    <analytics-sales-radar-chart :data="data.salesChart"/>
                </b-col>
                <b-col lg="4">
                    <analytics-app-design :data="data.appDesign"/>
                </b-col>
            </b-row>-->
    </section>
</template>

<script>
    import {BRow, BCol} from 'bootstrap-vue'
    import StatisticCardVertical from '@core/components/statistics-cards/StatisticCardVertical.vue'
    import StatisticCardWithAreaChart from '@core/components/statistics-cards/StatisticCardWithAreaChart.vue'
    import {kFormatter} from '@core/utils/filter'
    import InvoiceList from '@/views/apps/invoice/invoice-list/InvoiceList.vue'
    import AnalyticsCongratulation from './AnalyticsCongratulation.vue'
    import AnalyticsAvgSessions from './AnalyticsAvgSessions.vue'
    import AnalyticsSupportTracker from './AnalyticsSupportTracker.vue'
    import AnalyticsTimeline from './AnalyticsTimeline.vue'
    import AnalyticsSalesRadarChart from './AnalyticsSalesRadarChart.vue'
    import AnalyticsAppDesign from './AnalyticsAppDesign.vue'
    // import hrDashboard from './hrDashboard'
    import Calendar from "./Calender";

    export default {
        components: {
            BRow,
            BCol,
            StatisticCardVertical,
            AnalyticsCongratulation,
            AnalyticsAvgSessions,
            StatisticCardWithAreaChart,
            AnalyticsSupportTracker,
            AnalyticsTimeline,
            AnalyticsSalesRadarChart,
            AnalyticsAppDesign,
            InvoiceList,
            Calendar
            // hrDashboard
        },
        data() {
            return {
                data: {},
            }
        },
        created() {
            // data
            this.$http.get('/analytics/data')
                .then(response => {
                    this.data = response.data
                })
        },
        methods: {
            kFormatter,
        },
    }
</script>
