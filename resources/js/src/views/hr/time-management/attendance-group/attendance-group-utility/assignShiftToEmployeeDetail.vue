<template>
    <!--    no-body-->
    <b-card-code>
        <b-form @submit.prevent="saveFormData">
            <b-table-simple
                hover
                caption-top
                responsive
                class="rounded-bottom mb-0 w100"
            >
                <b-thead head-variant="light">
                    <b-tr>
                        <b-th>
                            <b-form-checkbox></b-form-checkbox>
                        </b-th>
                        <b-th>Employee Code</b-th>
                        <b-th>Employee Name</b-th>
                        <b-th>Attendance Group</b-th>
                        <b-th>Attendance Group Shift</b-th>
                        <b-th>Shift</b-th>
                    </b-tr>
                </b-thead>
                <b-tbody>
                    <b-tr class="w-100">
                        <b-td>
                            <b-form-checkbox></b-form-checkbox>
                        </b-td>
                        <b-td>C001064</b-td>
                        <b-td>HIMMATSINH PARMAR</b-td>
                        <b-td>All</b-td>
                        <b-td></b-td>
                        <b-td class="d-flex">
                            <b-form-group class="d-flex">
                                <b-form-checkbox v-model="formData.a1">A1</b-form-checkbox>
                            </b-form-group>
                        </b-td>
                    </b-tr>
                </b-tbody>

            </b-table-simple>
        </b-form>
        <template #code>
            {{ codeSimple }}
        </template>
        <br>
        <hr>
        <b-row>
            <b-col md="12">
                <b-button
                    variant="primary"
                    class="mr-2 float-right"
                    type="submit"
                >
                    Save
                </b-button>
            </b-col>
        </b-row>
        <br>
    </b-card-code>
</template>

<script>
    import BCardCode from '@core/components/b-card-code/BCardCode.vue'
    import {
        BForm,
        BTableSimple,
        BThead,
        BTr,
        BTh,
        BTd,
        BTbody,
        BFormGroup,
        BFormCheckbox,
        BRow,
        BCol,
        BButton,
        BFormInput
    } from 'bootstrap-vue'
    import {codeSimple} from "../../../../table/bs-table/code";
    import {ref} from '@vue/composition-api'
    import vSelect from 'vue-select'
    export default {
        components: {
            BCardCode,
            BForm,
            BTableSimple,
            BThead,
            BTr,
            BTh,
            BTd,
            BTbody,
            BFormGroup,
            BFormCheckbox,
            BRow,
            BCol,
            BButton,
            BFormInput,
            vSelect
        },
        setup() {
            const formData = ref({
                ot_All: null,
                ot_working: null,
                ot_weekly_off: null,
                ot_paid_holiday: null,
                co_all: null,
                co_working: null,
                co_weekly_off: null,
                co_paid_holiday: null,
            })
            const saveFormData = async () => {
            }
            return {
                codeSimple,
                formData,
                saveFormData,
            }
        },
    }
</script>


