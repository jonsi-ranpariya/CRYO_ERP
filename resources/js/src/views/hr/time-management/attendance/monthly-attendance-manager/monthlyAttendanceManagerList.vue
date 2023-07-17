<template>
    <div>
        <b-card-code>
            <b-row>
                <b-col md="5">
                    <b-form-group>
                        <label for="employee_name">Select Employee <span
                            class="text-danger erp_required_star"
                        >*</span></label>

                        <v-select
                            v-model="formData.employee_name"
                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                            :options="employeeOptions"
                            :clearable="false"
                            :reduce="val => val.value"
                            placeholder="Select Employee"
                            id="employee_name"
                        />
                    </b-form-group>
                </b-col>
            </b-row>
            <br>
            <b-tabs pills>
                <b-tab active>
                    <template #title>
                        <span class="d-none d-sm-inline">List</span>
                    </template>
                    <hr>
                    <monthly-attendance-list
                    />
                </b-tab>

                <b-tab>
                    <template #title>
                        <span class="d-none d-sm-inline">Chart Of Attendance</span>
                    </template>
                    <hr>
                    <chart-of-attendance
                    />
                </b-tab>

                <b-tab>
                    <template #title>
                        <span class="d-none d-sm-inline">Month Wise Summary</span>
                    </template>
                    <hr>
                    <month-wise-summary
                    />
                </b-tab>

            </b-tabs>
        </b-card-code>
    </div>
</template>
<script>
    import {
        BTabs,
        BTab,
        BBadge,
        BRow,
        BCol,
        BFormGroup
    } from 'bootstrap-vue'
    import BCardCode from "@core/components/b-card-code/BCardCode";
    import chartOfAttendance from './tabs/chartOfAttendance'
    import monthlyAttendanceList from './tabs/monthlyAttendanceList'
    import monthWiseSummary from './tabs/monthWiseSummary'
    import vSelect from 'vue-select'
    import axios from '@axios'
    import {ref} from '@vue/composition-api'
    export default {
        components: {
            BCardCode,
            BTab,
            BTabs,
            BBadge,
            chartOfAttendance,
            monthlyAttendanceList,
            monthWiseSummary,
            vSelect,
            BRow,
            BCol,
            BFormGroup
        },
        setup() {
          const employeeOptions = ref([])
            axios.get('/api/get-users-name-options')
                .then(res => {
                    employeeOptions.value = res.data.data
                })

            const formData = ref({
                employee_name:null,
            })

            return{
              employeeOptions,
                formData
            }
        }

    }
</script>

