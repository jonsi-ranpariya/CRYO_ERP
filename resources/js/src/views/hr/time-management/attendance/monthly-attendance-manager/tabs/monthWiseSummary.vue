<template>
    <div>
        <b-card-actions
            title="Manager summary"
            action-collapse
        >

            <b-row>
                <b-col md="5">
                    <b-form-group
                        label="For The Period"
                        label-for="for_the_period"
                    >
                        <b-row>
                            <b-col md="6">
                                <v-select
                                    v-model="formData.month"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="monthOptions"
                                    :clearable="false"
                                    :reduce="val => val.value"
                                    placeholder="Month"
                                    input-id="for_the_period"
                                />
                            </b-col>
                            <b-col md="4">
                                <v-select
                                    v-model="formData.yearPresent"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="yearPresentOptions"
                                    :clearable="false"
                                    :reduce="val => val.value"
                                    placeholder="Year"
                                    input-id="YearPresent"
                                />
                            </b-col>
                            <b-col md="2"></b-col>
                        </b-row>
                    </b-form-group>
                </b-col>
                <b-col md="5">
                    <b-form-group
                        label="To Period"
                        label-for="to_the_period"
                    >
                        <b-row>
                            <b-col md="6">
                                <v-select
                                    v-model="formData.to_month"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="toMonthOptions"
                                    :clearable="false"
                                    :reduce="val => val.value"
                                    placeholder="Month"
                                    input-id="to_month"
                                />
                            </b-col>
                            <b-col md="4">
                                <v-select
                                    v-model="formData.toYearPresent"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="toYearOptions"
                                    :clearable="false"
                                    :reduce="val => val.value"
                                    placeholder="Year"
                                    input-id="toYearPresent"
                                />
                            </b-col>
                            <b-col md="2"></b-col>
                        </b-row>
                    </b-form-group>
                </b-col>
            </b-row>
        </b-card-actions>

        <!--------------- Table ---------------------->
        <hr>
        <b-card-code>
            <b-row>
            <b-col md="4">
                <v-select
                    v-model="formData.export"
                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                    :options="exportOptions"
                    :clearable="false"
                    :reduce="val => val.value"
                    placeholder="Export"
                    input-id="export"
                    class="float-end mb-2"
                />
            </b-col>
            </b-row>
                <b-table-simple
                    hover
                    caption-top
                    responsive
                    class="rounded-bottom mb-0"
                >
                    <b-thead head-variant="light">
                        <b-tr>
                            <th>Period</th>
                            <th>Total Days</th>
                            <th>Day Present</th>
                            <th>Absent</th>
                            <th>LWP</th>
                            <th>Total Leaves</th>
                            <th>Paid Holidays</th>
                            <th>Weekly Off</th>
                        </b-tr>
                    </b-thead>
                    <b-tbody>
                        <b-tr>
                            <td>FEB 2023</td>
                            <td>28</td>
                            <td>9.00</td>
                            <td>3.50</td>
                            <td>0.00</td>
                            <td>0.00</td>
                            <td>0.00</td>
                            <td>1.50</td>
                        </b-tr>
                    </b-tbody>
                </b-table-simple>
            <template #code>
                {{ codeSimple }}
            </template>
        </b-card-code>
    </div>
</template>
<script>
    import {
        BRow,
        BCol,
        BFormGroup,
        BFormCheckbox,
        BCard, BCardBody, BMedia, BMediaAside, BAvatar, BMediaBody, BCardText,
        BForm,
        BTableSimple,
        BThead,
        BTr,
        BTh,
        BTd,
        BTbody,
        BButton,
        BFormInput,
        BLink,
        BTable
    } from 'bootstrap-vue'
    import {codeSimple} from "../../../../../table/bs-table/code";
    import BCardActions from "@core/components/b-card-actions/BCardActions";
    import BCardCode from "@core/components/b-card-code/BCardCode";
    import vSelect from 'vue-select'
    import moment from "moment";
    import {ref} from "@vue/composition-api";

    export default {
        components: {
            BCardActions,
            BRow,
            BCol,
            vSelect,
            BFormGroup,
            BFormCheckbox,
            BCard,
            BCardBody,
            BMedia,
            BMediaAside,
            BAvatar,
            BMediaBody,
            BCardText,
            BCardCode,
            BForm,
            BTableSimple,
            BThead,
            BTr,
            BTh,
            BTd,
            BTbody,
            BButton,
            BFormInput,
            BLink,
            BTable
        },
        setup(attendanceModal) {
            attendanceModal = ref()

            const typeOptions = ref([
                {label: 'CO', value: 1},
                {label: 'CL', value: 2}
            ])

            const typeAltOptions = ref([
                {label: 'ABS', value: 1},
                {label: 'CL', value: 2}
            ])

            const exportOptions = ref([
                {label:'Excel', value:1},
                {label:'PDF', value:2},
            ])

            /*Get all Month*/
            let allMonth = [];
            let months = moment.months();
            for (let i = 0; i < months.length; i++) {
                allMonth.push({
                    label: months[i],
                    value: months[i],
                })
            }
            const monthOptions = ref([])
            monthOptions.value = allMonth

            const yearPresentOptions = ref([
                {
                    label: new Date().getFullYear() - 1,
                    value: new Date().getFullYear() - 1
                },
                {
                    label: new Date().getFullYear(),
                    value: new Date().getFullYear()
                },
            ])

            const toYearOptions = ref([
                {
                    label: new Date().getFullYear() - 1,
                    value: new Date().getFullYear() - 1
                },
                {
                    label: new Date().getFullYear(),
                    value: new Date().getFullYear()
                },
            ])
            const toMonthOptions = ref([])
            toMonthOptions.value = allMonth


            const formData = ref({
                month: null,
                yearPresent: null,
                to_month:null,
                toYearPresent:null,
            })

            return {
                monthOptions,
                yearPresentOptions,
                formData,
                typeAltOptions,
                typeOptions,
                codeSimple,
                toMonthOptions,
                toYearOptions,
                exportOptions
            }
        },
    }
</script>
