<template>
    <div>
        <b-card-code>
            <b-form>
                <b-table-simple
                    hover
                    responsive
                    class="rounded-bottom mb-0 table table-bordered"
                >
                    <b-thead head-variant="light">
                        <b-tr>
                            <th>Employee Name</th>
                            <th>Employee Code</th>
                            <th>Date</th>
                            <th>Type1</th>
                            <th>Portion</th>
                            <th>Type2</th>
                            <th>Late Hrs</th>
                            <th>Ot Hrs</th>
                            <th>In Time</th>
                            <th>Out Time</th>
                            <th>Total Hrs</th>
                            <th>Shift In Time</th>
                            <th>Shift Out Time</th>
                            <th>Latemark</th>
                        </b-tr>
                    </b-thead>
                    <b-tbody>
                        <b-tr>
                            <td>RAKESH S PATEL</td>
                            <td>C008111</td>
                            <td>1-Jun-22</td>
                            <td>DP</td>
                            <td>1.00</td>
                            <td>CL</td>
                            <td>0.00</td>
                            <td>0.00</td>
                            <td>9:00 AM</td>
                            <td>6:00 PM</td>
                            <td>9.00</td>
                            <td>9:00 AM</td>
                            <td>6:00 PM</td>
                            <td>0.00</td>
                        </b-tr>
                    </b-tbody>
                </b-table-simple>
                <template #code>
                    {{ codeSimple }}
                </template>
            </b-form>
        </b-card-code>
    </div>
</template>
<script>
    import {
        BRow,
        BCol,
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
            return {
                codeSimple,
            }

        }
    }
</script>
