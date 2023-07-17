<template>
    <!--    no-body-->
    <b-card-code>
        <b-form @submit.prevent="saveFormData">
            <b-row>
                <b-col md="3">
                    <b-form-group
                        label="Attendance Group"
                        label-for="attendance_group"
                    >
                        <v-select
                            v-model="formData.attendance_type"
                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                            :options="attendanceTypeOption"
                            :clearable="false"
                            :reduce="val => val.value"
                            placeholder="Select Group"
                            id="attendance_type"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="2">
                    <b-button
                        variant="primary"
                        class="mt-2"
                    >
                        Apply
                    </b-button>
                </b-col>
            </b-row>

            <b-table-simple
                hover
                caption-top
                responsive
                class="rounded-bottom mb-0 w100"
            >
                <b-thead head-variant="light">
                    <b-tr>
                        <b-th colspan="4">
                        </b-th>
                        <b-th colspan="4">
                            OT

                        </b-th>
                        <b-th colspan="4">
                            CO+
                        </b-th>
                    </b-tr>
                    <b-tr>
                        <b-th>
                            <b-form-checkbox></b-form-checkbox>
                        </b-th>
                        <b-th>Employee Code</b-th>
                        <b-th>Employee Name</b-th>
                        <b-th>Attendance Group</b-th>
                        <b-th>
                            <b-form-group>
                                <b-form-checkbox>All</b-form-checkbox>
                            </b-form-group>
                        </b-th>
                        <b-th>
                            <b-form-group>
                                <b-form-checkbox>Working</b-form-checkbox>
                            </b-form-group>
                        </b-th>
                        <b-th>
                            <b-form-group>
                                <b-form-checkbox>Weekly Off</b-form-checkbox>
                            </b-form-group>
                        </b-th>
                        <b-th>
                            <b-form-group>
                                <b-form-checkbox>Paid Holiday</b-form-checkbox>
                            </b-form-group>
                        </b-th>
                        <b-th>
                            <b-form-group>
                                <b-form-checkbox>All</b-form-checkbox>
                            </b-form-group>
                        </b-th>
                        <b-th>
                            <b-form-group>
                                <b-form-checkbox>Working</b-form-checkbox>
                            </b-form-group>
                        </b-th>
                        <b-th>
                            <b-form-group>
                                <b-form-checkbox>Weekly Off</b-form-checkbox>
                            </b-form-group>
                        </b-th>
                        <b-th>
                            <b-form-group>
                                <b-form-checkbox>Paid Holiday</b-form-checkbox>
                            </b-form-group>
                        </b-th>
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
                        <b-td>
                            <b-form-group>
                                <b-form-checkbox v-model="formData.ot_All"></b-form-checkbox>
                            </b-form-group>
                        </b-td>
                        <b-td>
                            <b-form-group>
                                <b-form-checkbox v-model="formData.ot_working"></b-form-checkbox>
                            </b-form-group>
                        </b-td>
                        <b-td>
                            <b-form-group>
                                <b-form-checkbox v-model="formData.ot_weekly_off"></b-form-checkbox>
                            </b-form-group>
                        </b-td>
                        <b-td>
                            <b-form-group>
                                <b-form-checkbox v-model="formData.ot_paid_holiday"></b-form-checkbox>
                            </b-form-group>
                        </b-td>
                        <b-td>
                            <b-form-group>
                                <b-form-checkbox v-model="formData.co_all"></b-form-checkbox>
                            </b-form-group>
                        </b-td>
                        <b-td>
                            <b-form-group>
                                <b-form-checkbox v-model="formData.co_working"></b-form-checkbox>
                            </b-form-group>
                        </b-td>
                        <td>
                            <b-form-group>
                                <b-form-checkbox v-model="formData.co_weekly_off"></b-form-checkbox>
                            </b-form-group>
                        </td>
                        <td>
                            <b-form-group>
                                <b-form-checkbox v-model="formData.co_paid_holiday"></b-form-checkbox>
                            </b-form-group>
                        </td>
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
            const attendanceTypeOption = ref([
                {label:'All' , value:1},
            ])


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
                attendanceTypeOption
            }
        },
    }
</script>


