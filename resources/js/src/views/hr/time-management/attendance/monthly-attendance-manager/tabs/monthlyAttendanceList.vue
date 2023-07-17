<template>
    <div>
        <b-card-actions
            title="Manager List"
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

            <b-modal
                id="attendanceModal"
                ref="attendanceModal"
                title="Shift [OS] Time: 01-Mar-23 08:11 AM - 02-Mar-23 08:10 AM [As per CutOff Time]    "
                ok-title="Yes"
                cancel-title="No"
                cancel-variant="danger"
                no-close-on-backdrop
                scrollable
                centered
                hide-footer
                size="xl"
            >
                <b-row>
                    <b-col md="12">
                        <h5>Daily In Out Punch</h5>
                    </b-col>
                </b-row>
                <b-table
                    :fields="modalTable.columns"
                    :items="modalTable.rows"
                    :bordered="true"
                    :hover="true"
                    show-empty
                    responsive
                    class="table_scroll"
                >
                </b-table>
            </b-modal>

        </b-card-code>
        <b-card-code>
            <b-form @submit.prevent="saveFormData">
                <b-table-simple
                    hover
                    caption-top
                    responsive
                    class="rounded-bottom mb-0"
                >
                    <b-thead head-variant="light">
                        <b-tr>
                            <th></th>
                            <b-th>Date</b-th>
                            <b-th>Day</b-th>
                            <b-th>Type1</b-th>
                            <b-th>Part</b-th>
                            <b-th>Type2</b-th>
                            <b-th>O.T</b-th>
                            <b-th>L.T</b-th>
                            <b-th>Allow In</b-th>
                            <b-th>Out</b-th>
                            <b-th>In/Out Time</b-th>
                            <b-th>Shift In/Out Time</b-th>
                            <b-th>Total Hrs</b-th>
                            <b-th>
                                <b-form-checkbox>Day Lock</b-form-checkbox>
                            </b-th>
                        </b-tr>
                    </b-thead>
                    <b-tbody>
                        <b-tr>
                            <b-td>
                                <b-link
                                    @click="openModal"
                                >
                                    View
                                </b-link>
                            </b-td>
                            <b-td>01-Mar-23</b-td>
                            <b-td>Wed</b-td>
                            <b-td>
                                <v-select
                                    v-model="formData.type"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="typeOptions"
                                    :clearable="false"
                                    :reduce="val => val.value"
                                    placeholder="Select Type"
                                    input-id="type"
                                />
                            </b-td>
                            <b-td>1.00</b-td>
                            <b-td>
                                <v-select
                                    v-model="formData.type_alt"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="typeAltOptions"
                                    :clearable="false"
                                    :reduce="val => val.value"
                                    input-id="type_alt"
                                />
                            </b-td>
                            <b-td>0.00</b-td>
                            <b-td>0.00</b-td>
                            <b-td>
                                <b-form-group>
                                    <b-form-checkbox v-model="formData.day_lock"></b-form-checkbox>
                                </b-form-group>
                            </b-td>
                            <b-td>
                                <b-form-group>
                                    <b-form-checkbox v-model="formData.day_lock"></b-form-checkbox>
                                </b-form-group>
                            </b-td>
                            <b-td>I 9:05 AM O 1:02 PM</b-td>
                            <b-td>I 9:00 AM O 6:00 PM</b-td>
                            <b-td>0.00</b-td>
                            <b-td>
                                <b-form-group>
                                    <b-form-checkbox v-model="formData.day_lock"></b-form-checkbox>
                                </b-form-group>
                            </b-td>
                        </b-tr>
                    </b-tbody>
                </b-table-simple>
            </b-form>
            <template #code>
                {{ codeSimple }}
            </template>
            <hr>
            <b-col md="12">
                <b-button
                    variant="primary"
                    class="float-right mb-2 ml-2"
                >
                    Export PDF
                </b-button>
                <b-button
                    variant="primary"
                    class="float-right"
                    type="submit"
                >
                    Save
                </b-button>
            </b-col>
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
            const statisticsItems = [
                {
                    color: 'light-primary',
                    title: '0.5',
                    subtitle: 'ABS',
                    customClass: 'mb-2 mb-xl-0',
                },
                {
                    color: 'light-info',
                    title: '5',
                    subtitle: 'CL',
                    customClass: 'mb-2 mb-xl-0',
                },
                {
                    color: 'light-danger',
                    title: '10.5',
                    subtitle: 'DP',
                    customClass: 'mb-2 mb-sm-0',
                },
                {
                    color: 'light-success',
                    title: '2',
                    subtitle: 'OD',
                    customClass: 'mb-2 mb-sm-0',
                },
                {
                    color: 'light-secondary',
                    title: '1',
                    subtitle: 'PH',
                    customClass: 'mb-2 mb-sm-0',
                },
                {
                    color: 'light-warning',
                    title: '4',
                    subtitle: 'WO',
                    customClass: 'mb-2 mb-sm-0',
                }
            ]

            const modalTable = ref({
                columns: [
                    {
                        key: 'date',
                        label: 'Date'
                    },
                    {
                        key: 'entry_time',
                        label: 'Entry Time'
                    },
                    {
                        key: 'in_out_time',
                        label: 'In/Out Time'
                    },
                    {
                        key: 'ip_address',
                        label: 'IP Address'
                    },
                    {
                        key: 'machine_name',
                        label: 'Machine Name'
                    },
                    {
                        key: 'swipe_date',
                        label: 'Swipe Date'
                    },
                    {
                        key: 'entry_date_time',
                        label: 'Entry Date Time'
                    },
                    {
                        key: 'approver_remark',
                        label: 'Approver Remark'
                    }
                ],
                rows: [
                    {
                        date: '22/02/2022', entry_time: '2:00', in_out_time: '6:00', ip_address: '127.0.0.1.23',
                        machine_name: 'a1', swipe_date: '12/03/2022', entry_date_time: '3:00', approver_remark: 'work'
                    }
                ]
            })

            const openModal = () => {
                attendanceModal.value.show();

                // function getDaysInCurrentMonth() {
                //     const date = new Date();
                //
                //     return new Date(date.getFullYear(), date.getMonth() + 1, 0).getDate();
                // }
                //
                // const result = getDaysInCurrentMonth();
                // console.log(result); // 👉️ 31
            }

            const formData = ref({
                month: null,
                yearPresent: null,
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

            const saveFormData = async () => {
            }

            return {
                monthOptions,
                yearPresentOptions,
                formData,
                statisticsItems,
                typeAltOptions,
                typeOptions,
                codeSimple,
                saveFormData,
                attendanceModal,
                openModal,
                modalTable
            }
        },
    }
</script>
