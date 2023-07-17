<template>
    <!--    no-body-->
    <b-card-code
        title="Note : Row locked as salary for the month is processed."
    >
        <b-form @submit.prevent="saveFormData">

            <b-table-simple
                hover
                caption-top
                responsive
                class="rounded-bottom mb-0"
            >
                <b-thead head-variant="light">
                    <b-tr>
                        <b-th>Employee Code</b-th>
                        <b-th>Employee Name</b-th>
                        <b-th>
                            <b-form-group
                                label="Type"
                                label-for="type"
                            >
                                <v-select
                                    v-model="formData.type"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="typeOptions"
                                    :clearable="false"
                                    :reduce="val => val.value"
                                    input-id="type"
                                />
                            </b-form-group>
                        </b-th>
                        <b-th>Day Portion</b-th>
                        <b-th>
                            <b-form-group
                                label="Type(Alt)"
                                label-for="type_alt"
                            >
                                <v-select
                                    v-model="formData.type_alt"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="typeAltOptions"
                                    :clearable="false"
                                    :reduce="val => val.value"
                                    input-id="type_alt"
                                />
                            </b-form-group>
                        </b-th>
                        <b-th>
                            <b-form-checkbox>Allow In</b-form-checkbox>
                        </b-th>
                        <b-th>
                            <b-form-checkbox>Allow Out</b-form-checkbox>
                        </b-th>
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
                        <b-td>C008111</b-td>
                        <b-td>RAKESH S PATEL</b-td>
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
                        <b-td>
                            <b-form-group>
                                <b-form-checkbox v-model="formData.allow_in"></b-form-checkbox>
                            </b-form-group>
                        </b-td>
                        <b-td>
                            <b-form-group>
                                <b-form-checkbox v-model="formData.allow_out"></b-form-checkbox>
                            </b-form-group>
                        </b-td>
                        <b-td>I 9:05 AM O 1:02 PM</b-td>
                        <b-td>I 9:00 AM O 6:00 PM</b-td>
                        <b-td>3.57</b-td>
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
    } from 'bootstrap-vue'
    import {ref} from '@vue/composition-api'
    import {codeSimple} from "../../../../table/bs-table/code";
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
            vSelect
        },
        setup() {
            const typeOptions = ref([
                {label: 'CO', value: 1},
                {label: 'CL', value: 2}
            ])

            const typeAltOptions = ref([
                {label:'ABS', value: 1},
                {label:'CL', value: 2}
            ])

            const formData = ref({
                type:null,
                type_alt:null,
                allow_in:null,
                allow_out:null,
                day_lock:null,
            })
            const saveFormData = async () => {
            }
            return {
                codeSimple,
                formData,
                saveFormData,
                typeOptions,
                typeAltOptions
            }
        },
    }
</script>


