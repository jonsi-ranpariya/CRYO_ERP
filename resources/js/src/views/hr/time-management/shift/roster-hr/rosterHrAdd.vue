<template>
    <div>
        <b-card-code>
            <b-form>
                <b-row>
                    <b-col md="12">
                        <b-alert
                            variant="danger"
                            show
                        >
                            <h4 class="alert-heading">
                                Note:
                            </h4>
                            <div class="alert-body">
                                <span>In shift list only those shift will display which is mapped with attendance group or with employee.</span><br><br>
                                <span>If Setup "Consider attendance group shift mapped with employee while shift selection" at (Path : Time > Configuration > Attendance Settings > Other setting) Is Opted.</span><br><br>
                                <span>Path : Time > Define > Attendance Group > Assign Shift To Attendance Group.</span><br><br>
                                <span>Path : Time > Define > Attendance Group > Assign Shift To Employee.</span><br><br>
                            </div>
                        </b-alert>
                        <hr>
                    </b-col>
                </b-row>
                <b-row>
                    <b-col md="5" class="d-flex">
                        <p><b>From date</b> : 21-Mar-23</p>
                        <p class="ml-2"><b>To date </b> : 25-Apr-23</p>
                    </b-col>
                    <b-col md="3">
                        <b-form-group>
                            <label for="shift">Shift <span
                                class="text-danger erp_required_star"
                            >*</span></label>

                            <v-select
                                v-model="formData.shift"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="shiftTypeOptions"
                                :clearable="false"
                                :reduce="val => val.value"
                                placeholder="Select Shift"
                                id="shift"
                            />
                        </b-form-group>
                    </b-col>
                </b-row>
                <b-table-simple
                    hover
                    responsive
                    class="rounded-bottom mb-0 table table-bordered"
                >
                    <b-thead head-variant="light">
                        <b-tr>
                            <th>Employee Name</th>
                            <th>Employee Code</th>
                            <th v-for="day in no_of_days.getDate()">{{day}}&nbsp;&nbsp;{{`${days[new Date(year, month + 1, day).getDay()]}`}}</th>
                        </b-tr>
                    </b-thead>
                    <b-tbody>
                        <b-tr>
                            <td>RAKESH S PATEL</td>
                            <td>C008111</td>
                            <td v-for="(day, key) in no_of_days.getDate()">
                                <v-select
                                    v-model="formData.shift"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="shiftTypeOptions"
                                    :clearable="false"
                                    :reduce="val => val.value"
                                    placeholder="Select Shift"
                                    id="shift_one"
                                />
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

            </b-form>
        </b-card-code>
    </div>
</template>
<script>
    import {
        BRow,
        BCol,
        BAlert,
        BForm,
        BFormGroup,
        BTableSimple,
        BThead,
        BTbody,
        BTr,
        BTh,
        BButton,
        BFormCheckbox
    } from 'bootstrap-vue'
    import BCardCode from "@core/components/b-card-code/BCardCode";
    import {ref} from "@vue/composition-api";
    import vSelect from 'vue-select'
    import {codeSimple} from "../../../../table/bs-table/code";

    export default {
        components: {
            BCardCode,
            BRow,
            BCol,
            BAlert,
            BForm,
            vSelect,
            BFormGroup,
            BTableSimple,
            BThead,
            BTbody,
            BTr,
            BTh,
            BButton,
            BFormCheckbox
        },
        data() {
            let d = new Date(),
                month = d.getMonth(),
                year = d.getYear();

            return {
                month: month,
                year: year,
                no_of_days: new Date(year, month + 1, 0),
                days: [ "Sat", "Sun","Mon", "Tue", "Wed", "Thu", "Fri",],

            }
        },
        setup() {
            const formData = ref({
                shift: null,
            })
            const shiftTypeOptions = ref([
                {
                    label: 'V1',
                    value: 1
                },
                {
                    label: 'L1',
                    value: 2
                },
            ])

            return {
                shiftTypeOptions,
                formData,
                codeSimple,
            }

        }
    }
</script>
