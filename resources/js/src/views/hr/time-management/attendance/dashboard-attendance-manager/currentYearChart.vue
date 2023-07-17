<template>
    <b-card>
        <b-card-title class="mb-1">
            <h5>Total Working Hrs Vs. OT</h5>
        </b-card-title>
        <b-card-sub-title class="mb-2">
            (Current Month)
        </b-card-sub-title>

        <vue-apex-charts
            class="mt-3"
            type="donut"
            height="350"
            :options="chartData.donutChart.chartOptions"
            :series="chartData.donutChart.series"
        />
        <br><br>
    </b-card>
</template>

<script>
    import {
        BCard, BCardTitle, BCardSubTitle,
    } from 'bootstrap-vue'
    import VueApexCharts from 'vue-apexcharts'
    import chartData from "./chartData";
    export default {
        components: {
            VueApexCharts,
            BCard,
            BCardTitle,
            BCardSubTitle,
        },
        data() {
            return {
                chartData,
            }
        },
    }
</script>
