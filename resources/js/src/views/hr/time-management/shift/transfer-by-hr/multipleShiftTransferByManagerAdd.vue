<template>
    <div>
        <b-card-code>
            <b-form>
                <b-row>
                    <b-col md="2">
                        <b-form-group>
                            <label for="normal_shift">Normal Shift <span
                                class="text-danger erp_required_star"
                            >*</span></label>

                            <v-select
                                v-model="formData.normal_shift"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="shiftTypeOptions"
                                :clearable="false"
                                :reduce="val => val.value"
                                placeholder="Select Shift"
                                id="normal_shift"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="2">
                        <b-form-group>
                            <label for="alt_shift">Alt. Shift <span
                                class="text-danger erp_required_star"
                            >*</span></label>

                            <v-select
                                v-model="formData.alt_shift"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="shiftTypeOptions"
                                :clearable="false"
                                :reduce="val => val.value"
                                placeholder="Select Shift"
                                id="alt_shift"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="8">
                        <b-form-group
                            label="Alt. Shift Days"
                            label-for="alt_shift_days"
                        >
                            <div class="demo-inline-spacing">
                                <b-form-checkbox
                                    class="custom-control-primary mt-1 d-flex"
                                    v-model="formData.alt_shift_days_sun"
                                >
                                    Sun
                                </b-form-checkbox>
                                <b-form-checkbox
                                    class="custom-control-primary mt-1 d-flex"
                                    v-model="formData.alt_shift_days_mon"
                                >
                                    Mon
                                </b-form-checkbox>
                                <b-form-checkbox
                                    class="custom-control-primary mt-1"
                                    v-model="formData.alt_shift_days_tue"
                                >
                                    Tue
                                </b-form-checkbox>
                                <b-form-checkbox
                                    class="custom-control-primary mt-1"
                                    v-model="formData.alt_shift_days_wed"
                                >
                                    Wed
                                </b-form-checkbox>
                                <b-form-checkbox
                                    class="custom-control-primary mt-1"
                                    v-model="formData.alt_shift_days_thu"
                                >
                                    Thu
                                </b-form-checkbox>
                                <b-form-checkbox
                                    class="custom-control-primary mt-1"
                                    v-model="formData.alt_shift_days_fri"
                                >
                                    Fri
                                </b-form-checkbox>
                                <b-form-checkbox
                                    class="custom-control-primary mt-1"
                                    v-model="formData.alt_shift_days_sat"
                                >
                                    Sat
                                </b-form-checkbox>
                            </div>
                        </b-form-group>
                    </b-col>
                </b-row>
                <br>
                <b-table-simple
                    hover
                    responsive
                    class="rounded-bottom mb-0 table table-bordered"
                >
                    <b-thead head-variant="light">
                        <b-tr>
                            <th><b-form-checkbox class="custom-control-primary"></b-form-checkbox></th>
                            <th>Employee Name</th>
                            <th>Employee Code</th>
                            <th>Normal Shift</th>
                            <th>Alt. Shift</th>
                            <th>Alt. Shift Days</th>
                        </b-tr>
                    </b-thead>
                    <b-tbody>
                        <b-tr>
                            <th><b-form-checkbox class="custom-control-primary"></b-form-checkbox></th>
                            <td>RAKESH S PATEL</td>
                            <td>C008111</td>
                            <td>
                                <v-select
                                    v-model="formData.normal_shift"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="shiftTypeOptions"
                                    :clearable="false"
                                    :reduce="val => val.value"
                                    id="normalShift"
                                />
                            </td>
                            <td>
                                <v-select
                                    v-model="formData.alt_shift"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="shiftTypeOptions"
                                    :clearable="false"
                                    :reduce="val => val.value"
                                    id="altShift"
                                />
                            </td>
                            <td>
                                <div class="demo-inline-spacing">
                                    <b-form-checkbox
                                        class="custom-control-primary mt-1 d-flex"
                                        v-model="formData.alt_shift_days_sun"
                                    >
                                        Sun
                                    </b-form-checkbox>
                                    <b-form-checkbox
                                        class="custom-control-primary mt-1 d-flex"
                                        v-model="formData.alt_shift_days_mon"
                                    >
                                        Mon
                                    </b-form-checkbox>
                                    <b-form-checkbox
                                        class="custom-control-primary mt-1"
                                        v-model="formData.alt_shift_days_tue"
                                    >
                                        Tue
                                    </b-form-checkbox>
                                    <b-form-checkbox
                                        class="custom-control-primary mt-1"
                                        v-model="formData.alt_shift_days_wed"
                                    >
                                        Wed
                                    </b-form-checkbox>
                                    <b-form-checkbox
                                        class="custom-control-primary mt-1"
                                        v-model="formData.alt_shift_days_thu"
                                    >
                                        Thu
                                    </b-form-checkbox>
                                    <b-form-checkbox
                                        class="custom-control-primary mt-1"
                                        v-model="formData.alt_shift_days_fri"
                                    >
                                        Fri
                                    </b-form-checkbox>
                                    <b-form-checkbox
                                        class="custom-control-primary mt-1"
                                        v-model="formData.alt_shift_days_sat"
                                    >
                                        Sat
                                    </b-form-checkbox>
                                </div>
                            </td>
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
                            class="float-right mt-2 ml-1"
                            type="sumbit"
                        >
                            Save
                        </b-button>
                        <b-button
                            variant="primary"
                            class="float-right mt-2 ml-1"
                        >
                            Apply
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
        setup() {
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
            const formData = ref({
                normal_shift: null,
                alt_shift: null,
                alt_shift_days_sun: null,
                alt_shift_days_mon: null,
                alt_shift_days_tue: null,
                alt_shift_days_wed: null,
                alt_shift_days_thu: null,
                alt_shift_days_fri: null,
                alt_shift_days_sat: null,
            })

            return {
                shiftTypeOptions,
                formData,
                codeSimple,
            }

        }
    }
</script>
