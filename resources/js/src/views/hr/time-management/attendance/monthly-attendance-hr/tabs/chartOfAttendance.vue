<template>
    <div>
        <b-card-actions
            title="Manager Chart Of Attendance"
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
                <b-col md="7">
                    <b-row>
                        <b-col md="12">
                            <h5>User Day Type</h5>
                        </b-col>
                        <b-col md="12">
                            <div class="demo-inline-spacing">
                                <b-form-checkbox
                                    v-model="formData.dayTypeAbs"
                                    name="dayTypeAbs"
                                >
                                    ABS
                                </b-form-checkbox>
                                <b-form-checkbox
                                    v-model="formData.dayTypeCl"
                                    name="dayTypeCl"
                                >
                                    CL
                                </b-form-checkbox>
                                <b-form-checkbox
                                    v-model="formData.dayTypeCoMinus"
                                    name="dayTypeCoMinus"
                                >
                                    CO-
                                </b-form-checkbox>
                                <b-form-checkbox
                                    v-model="formData.dayTypeCoPlus"
                                    name="dayTypeCoPlus"
                                >
                                    CO+
                                </b-form-checkbox>
                                <b-form-checkbox
                                    v-model="formData.dayTypeDp"
                                    name="dayTypeDp"
                                >
                                    DP
                                </b-form-checkbox>
                                <b-form-checkbox
                                    v-model="formData.dayTypeEo"
                                    name="dayTypeEo"
                                >
                                    EO
                                </b-form-checkbox>
                                <b-form-checkbox
                                    v-model="formData.dayTypeLone"
                                    name="dayTypeLone"
                                >
                                    L1
                                </b-form-checkbox>
                                <b-form-checkbox
                                    v-model="formData.dayTypeLtwo"
                                    name="dayTypeLtwo"
                                >
                                    L2
                                </b-form-checkbox>
                                <b-form-checkbox
                                    v-model="formData.dayTypeTypeLthree"
                                    name="dayTypeTypeLthree"
                                >
                                    L3
                                </b-form-checkbox>
                                <b-form-checkbox
                                    v-model="formData.dayTypeLfour"
                                    name="dayTypeLfour"
                                >
                                    L4
                                </b-form-checkbox>
                                <b-form-checkbox
                                    v-model="formData.dayTypeLfive"
                                    name="dayTypeLfive"
                                >
                                    L5
                                </b-form-checkbox>
                                <b-form-checkbox
                                    v-model="formData.dayTypeLwp"
                                    name="dayTypeLwp"
                                >
                                    LWP
                                </b-form-checkbox>
                                <b-form-checkbox
                                    v-model="formData.dayTypeOd"
                                    name="dayTypeOd"
                                >
                                    OD
                                </b-form-checkbox>
                                <b-form-checkbox
                                    v-model="formData.dayTypeOl"
                                    name="dayTypeOl"
                                >
                                    OL
                                </b-form-checkbox>
                                <b-form-checkbox
                                    v-model="formData.dayTypePh"
                                    name="dayTypePh"
                                >
                                    PH
                                </b-form-checkbox>
                                <b-form-checkbox
                                    v-model="formData.dayTypePhp"
                                    name="dayTypePhp"
                                >
                                    PHP
                                </b-form-checkbox>
                                <b-form-checkbox
                                    v-model="formData.dayTypePl"
                                    name="dayTypePl"
                                >
                                    PL
                                </b-form-checkbox>
                                <b-form-checkbox
                                    v-model="formData.dayTypeSl"
                                    name="dayTypeSl"
                                >
                                    SL
                                </b-form-checkbox>
                                <b-form-checkbox
                                    v-model="formData.dayTypeSv"
                                    name="dayTypeSv"
                                >
                                    SV
                                </b-form-checkbox>
                                <b-form-checkbox
                                    v-model="formData.dayTypeWo"
                                    name="dayTypeWo"
                                >
                                    WO
                                </b-form-checkbox>
                                <b-form-checkbox
                                    v-model="formData.dayTypeWop"
                                    name="dayTypeWop"
                                >
                                    WOP
                                </b-form-checkbox>
                            </div>
                        </b-col>
                    </b-row>
                </b-col>
            </b-row>
        </b-card-actions>

        <!--------------- Table ---------------------->
        <hr>
        <b-card-code>
            <b-row>
                <b-col
                    v-for="item in statisticsItems"
                    :key="item.title"
                    md="2"
                    sm="12"
                    class="mb-2 mb-md-0"
                    :class="item.customClass"
                >
                    <b-media no-body>
                        <b-media-aside

                            class="mr-2"
                        >
                            <b-avatar
                                size="45"
                                :variant="item.color"
                            >
                                {{ item.title }}
                            </b-avatar>
                        </b-media-aside>
                        <b-media-body class="my-auto">
                            <b-card-text class="font-small-3 mb-0">
                                {{ item.subtitle }}
                            </b-card-text>
                        </b-media-body>
                    </b-media>
                </b-col>
            </b-row>
        </b-card-code>
        <b-card-code>
            <b-table-simple
                hover
                caption-top
                responsive
                class="rounded-bottom mb-0"
            >
                <b-thead head-variant="light">
                    <b-tr>
                        <th>Month Year</th>
                        <th v-for="day in no_of_days.getDate()">{{day}}</th>
                    </b-tr>
                </b-thead>
                <b-tbody>
                    <b-tr>
                            <td>Jan 2022</td>
                        <td v-for="(day, key) in no_of_days.getDate()">
                            <b-form-checkbox
                                value="1"
                                class="custom-control-primary mt-1"
                            ></b-form-checkbox>
                        </td>
                    </b-tr>
                </b-tbody>
            </b-table-simple>
            <template #code>
                {{ codeSimple }}
            </template>
            <b-row>
                <b-col md="12">
                    <b-button
                        variant="primary"
                        class="float-right mt-2"
                    >
                        Export PDF
                    </b-button>
                </b-col>
            </b-row>
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
        data() {
            let d = new Date(),
                month = d.getMonth(),
                year = d.getYear();

            return {
                month: month,
                year: year,
                no_of_days: new Date(year, month + 1, 0)
            }
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

            const statisticsItems = [
                {
                    color: 'light-info',
                    title: '4.5',
                    subtitle: 'CL',
                    customClass: 'mb-2 mb-xl-0',
                },
                {
                    color: 'light-danger',
                    title: '328',
                    subtitle: 'DP',
                    customClass: 'mb-2 mb-sm-0',
                },
                {
                    color: 'light-secondary',
                    title: '17',
                    subtitle: 'PH',
                    customClass: 'mb-2 mb-xl-0',
                },
                {
                    color: 'light-primary',
                    title: '60',
                    subtitle: 'WO',
                    customClass: 'mb-2 mb-xl-0',
                },
                {
                    color: 'light-success',
                    title: '7.5',
                    subtitle: 'SL',
                    customClass: 'mb-2 mb-xl-0',
                },
                {
                    color: 'light-secondary',
                    title: '6.5',
                    subtitle: 'CL',
                    customClass: 'mb-2 mb-xl-0',
                },
                {
                    color: 'light-warning',
                    title: '21.5',
                    subtitle: 'PL',
                    customClass: 'mt-2 mb-xl-0',
                }

            ]

            const formData = ref({
                month: null,
                yearPresent: null,
                to_month: null,
                toYearPresent: null,
                dayTypeAbs: null,
                dayTypeCl: null,
                dayTypeCoMinus: null,
                dayTypeCoPlus: null,
                dayTypeDp: null,
                dayTypeEo: null,
                dayTypeLone: null,
                dayTypeLtwo: null,
                dayTypeTypeLthree: null,
                dayTypeLfour: null,
                dayTypeLfive: null,
                dayTypeLwp: null,
                dayTypeOd: null,
                dayTypeOl: null,
                dayTypePh: null,
                dayTypePhp: null,
                dayTypePl: null,
                dayTypeSl: null,
                dayTypeSv: null,
                dayTypeWo: null,
                dayTypeWop: null,
            })

            return {
                monthOptions,
                yearPresentOptions,
                formData,
                statisticsItems,
                typeAltOptions,
                typeOptions,
                codeSimple,
                toMonthOptions,
                toYearOptions
            }
        },
    }
</script>
