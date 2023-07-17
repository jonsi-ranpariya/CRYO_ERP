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
                            <th>AF1</th>
                            <th>AF2</th>
                            <th>AF3</th>
                            <th>AF4</th>
                            <th>AF5</th>
                            <th>AF6</th>
                            <th>AF7</th>
                            <th>AF8</th>
                            <th>AF9</th>
                            <th>AF10</th>
                            <th>In Latemark</th>
                            <th>Out Latemark</th>
                        </b-tr>
                    </b-thead>
                    <b-tbody>
                        <b-tr>
                            <td>RAKESH S PATEL</td>
                            <td>C008111</td>
                            <td>0.00</td>
                            <td>0.00</td>
                            <td>0.00</td>
                            <td>0.00</td>
                            <td>0.00</td>
                            <td>0.00</td>
                            <td>0.00</td>
                            <td>0.00</td>
                            <td>0.00</td>
                            <td>0.00</td>
                            <td>0.00</td>
                            <td>0.00</td>
                        </b-tr>
                    </b-tbody>
                </b-table-simple>
                <template #code>
                    {{ codeSimple }}
                </template>
                <hr>
                <b-row>
                    <b-col md="12">
                        <b-button
                            variant="primary"
                            class="float-right mt-2"
                        >
                            Export
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
