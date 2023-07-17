<template>
    <!--    no-body-->
    <b-card-code>
        <b-form @submit.prevent="saveFormData">

            <b-table-simple
                hover
                caption-top
                class="rounded-bottom mb-0"
            >
                <b-thead head-variant="light">
                    <b-tr>
                        <b-th colspan="2">
                        </b-th>
                        <b-th colspan="3">
                            Mon - 20-Mar-23
                        </b-th>
                    </b-tr>

                    <b-tr>
                        <b-th>Employee Code</b-th>
                        <b-th>Employee Name</b-th>
                        <b-th>
                            <b-form-group
                                label="Type 1"
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
                        <b-th>Part</b-th>
                        <b-th>
                            <b-form-group
                                label="Type 2"
                                label-for="type_two"
                            >
                                <v-select
                                    v-model="formData.type_two"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="typeAltOptions"
                                    :clearable="false"
                                    :reduce="val => val.value"
                                    input-id="type_alt"
                                />
                            </b-form-group>
                        </b-th>
                    </b-tr>
                </b-thead>
                <b-tbody>
                    <b-tr>
                        <b-td>RAKESH S PATEL</b-td>
                        <b-td>C008111</b-td>
                        <b-td>
                            <v-select
                                v-model="formData.type"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="typeOptions"
                                :clearable="false"
                                :reduce="val => val.value"
                                input-id="type"
                            />
                        </b-td>
                        <b-td>1.00</b-td>
                        <b-td>
                            <v-select
                                v-model="formData.type_two"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="typeAltOptions"
                                :clearable="false"
                                :reduce="val => val.value"
                                input-id="type_two"
                            />
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
                type_two:null,
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


