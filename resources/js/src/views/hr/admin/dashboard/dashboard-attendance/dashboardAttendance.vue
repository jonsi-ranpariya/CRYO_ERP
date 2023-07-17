<template>
    <div>
        <b-row>
            <b-col
                lg="4"
                sm="6"
            >
                <statistic-card-horizontal
                    icon="CpuIcon"
                    statistic="61"
                    statistic-title="Overall Pending (Swipe / Regularization) Requests"
                />
            </b-col>
            <b-col
                lg="4"
                sm="6"
            >
                <statistic-card-horizontal
                    icon="ServerIcon"
                    color="success"
                    statistic="61"
                    statistic-title="Current Month Pending (Swipe / Regularization) Requests"
                />
            </b-col>
            <b-col
                lg="4"
                sm="6"
            >
                <statistic-card-horizontal
                    icon="ActivityIcon"
                    color="danger"
                    statistic="0"
                    statistic-title="Past Month Pending (Swipe / Regularization) Requests"
                />
            </b-col>
        </b-row>
        <b-row>
            <b-col md="5">
                <current-year-chart
                />
            </b-col>
            <b-col md="7">
                <b-card-code>
                    <b-row>
                        <b-col md="9" class="justify-content-start">
                            <b-row>
                                <b-col md="12" class="mb-2">
                                    <h5>Total No. of Employee(s)</h5>
                                </b-col>
                            </b-row>
                        </b-col>
                        <!-- ---------------search ---------------->
                        <b-col md="3">
                            <div class="custom-search d-flex justify-content-end">
                                <b-form-group>
                                    <b-form-input
                                        v-model="searchTerm"
                                        placeholder="Filter"
                                        type="text"
                                        id="filter"
                                    />
                                </b-form-group>
                            </div>
                        </b-col>
                    </b-row>
                    <b-row class="match-height">
                        <b-col
                            md="6"
                        >
                            <statistic-card-vertical
                                icon="UserCheckIcon"
                                statistic="36.9k"
                                statistic-title="IN (Punch IN for Today)"
                                color="info"
                            />
                        </b-col>
                        <b-col
                            md="6"
                        >
                            <statistic-card-vertical
                                color="danger"
                                icon="LogInIcon"
                                statistic="12k"
                                statistic-title="Out (Punch Out for Today)"
                            />
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col md="3"></b-col>
                        <b-col
                            md="6"
                        >
                            <statistic-card-vertical
                                color="success"
                                icon="UsersIcon"
                                statistic="16"
                                statistic-title="Available(Punch Out not done)"
                            />
                        </b-col>
                        <b-col md="3"></b-col>
                    </b-row>
                </b-card-code>
            </b-col>
        </b-row>
        <b-row>
            <b-col md="6">
                <shift-wise-employee-count
                />
            </b-col>
            <b-col md="6">
                <employee-having-late-marks
                />
            </b-col>
        </b-row>
        <b-row>
            <b-col md="6">
                <list-employee-with-late-mark
                />
            </b-col>
            <b-col md="6">
                <list-employee-early-going
                />
            </b-col>
        </b-row>
        <b-row>
            <b-col md="6">
                <list-employee-on-leave-lwp
                />
            </b-col>
            <b-col md="6">
                <list-employee-on-leave-lwp-next-day
                />
            </b-col>
        </b-row>
        <b-row>
            <b-col md="12">
                <employee-count-analysis
                />
            </b-col>
        </b-row>
    </div>
</template>
<script>
    import {
        BRow,
        BCol,
        BFormSelect,
        BPagination,
        BFormGroup,
        BFormInput
    } from 'bootstrap-vue'
    import StatisticCardVertical from "../../../../../@core/components/statistics-cards/StatisticCardVertical";
    import StatisticCardHorizontal from "../../../../../@core/components/statistics-cards/StatisticCardHorizontal";
    import currentYearChart from './currentYearChart'
    import BCardCode from "../../../../../@core/components/b-card-code/BCardCode";
    import {ref} from "@vue/composition-api";
    import shiftWiseEmployeeCount from './table/shiftWiseEmployeeCount'
    import employeeHavingLateMarks from "./table/employeeHavingLateMarks";
    import listEmployeeWithLateMark from "./table/listEmployeeWithLateMark";
    import listEmployeeEarlyGoing from "./table/listEmployeeEarlyGoing";
    import listEmployeeOnLeaveLwp from './table/listEmployeeOnLeaveLwp';
    import listEmployeeOnLeaveLwpNextDay from './table/listEmployeeOnLeaveLwpNextDay'
    import employeeCountAnalysis from './table/employeeCountAnalysis'

    export default {
        components: {
            shiftWiseEmployeeCount,
            employeeHavingLateMarks,
            listEmployeeWithLateMark,
            listEmployeeEarlyGoing,
            employeeCountAnalysis,
            listEmployeeOnLeaveLwp,
            listEmployeeOnLeaveLwpNextDay,
            BRow,
            BCol,
            StatisticCardVertical,
            StatisticCardHorizontal,
            currentYearChart,
            BCardCode,
            BFormSelect,
            BPagination,
            BFormGroup,
            BFormInput
        },
        setup() {

            const searchTerm = ref('')

            return {
                searchTerm,
            }
        }
    }
</script>

<style lang="scss">
    @import '~@core/scss/vue/libs/vue-flatpicker.scss';
    @import '~@core/scss/vue/libs/chart-apex.scss';
</style>


