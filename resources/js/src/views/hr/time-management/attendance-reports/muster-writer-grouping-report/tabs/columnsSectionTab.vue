<template>
    <div>
        <b-card-code>
            <b-table-simple
                hover
                responsive
                class="rounded-bottom mb-0 table table-bordered"
            >
                <b-thead head-variant="light">
                    <b-tr>
                        <th><b-form-checkbox class="custom-control-primary"></b-form-checkbox></th>
                        <th>Column Name</th>
                        <th>Description</th>
                    </b-tr>
                </b-thead>
                <b-tbody>
                    <b-tr>
                        <th><b-form-checkbox class="custom-control-primary"></b-form-checkbox></th>
                        <td>SPST</td>
                        <td>Spine Daytype</td>
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
    import BCardCode from "@core/components/b-card-code/BCardCode";
    import {codeSimple} from "../../../../../table/bs-table/code";
    import {
        BTableSimple,
        BFormCheckbox,
        BThead,
        BTbody,
        BTr,
        BTh,
        BTd
    } from 'bootstrap-vue'
    export default {
        components: {
            BCardCode,
            BTableSimple,
            BFormCheckbox,
            BThead,
            BTbody,
            BTr,
            BTh,
            BTd
        },
        setup() {

            return{
                codeSimple,

            }
        }
    }
</script>
