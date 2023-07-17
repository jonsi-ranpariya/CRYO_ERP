<template>
<!--    no-body-->
    <b-card-code
        title="Weekly Off - Employee Information"
    >
        <b-form @submit.prevent="saveFormData">

        <b-table-simple
            hover
            caption-top
            responsive
            class="rounded-bottom mb-0 w100"
        >
            <b-thead head-variant="light">
                <b-tr>
                    <b-th colspan="3" style="width:20px">
                        Employee Information
                    </b-th>
                    <b-th colspan="8" style="width:20px">
                        Sunday
                    </b-th>
                    <b-th colspan="8" style="width:10px">
                        Monday
                    </b-th>
                    <b-th colspan="8" style="width:10px">
                        Tuesday
                    </b-th>
                    <b-th colspan="8" style="width:10px">
                        Wednesday
                    </b-th>
                    <b-th colspan="8" style="width:10px">
                        Thursday
                    </b-th>
                    <b-th colspan="8" style="width:10px">
                        Friday
                    </b-th>
                    <b-th colspan="8" style="width:10px">
                        Saturday
                    </b-th>
                </b-tr>
                <b-tr>
                    <b-th>
                        <b-form-checkbox></b-form-checkbox>
                    </b-th>
                    <b-th>Employee Code</b-th>
                    <b-th>Employee Name</b-th>
                    <b-th>1</b-th>
                    <b-th>2</b-th>
                    <b-th>3</b-th>
                    <b-th>4</b-th>
                    <b-th>5</b-th>
                    <b-th>All</b-th>
                    <b-th>Alt Odd</b-th>
                    <b-th>Alt Even</b-th>
                    <b-th>1</b-th>
                    <b-th>2</b-th>
                    <b-th>3</b-th>
                    <b-th>4</b-th>
                    <b-th>5</b-th>
                    <b-th>All</b-th>
                    <b-th>Alt Odd</b-th>
                    <b-th>Alt Even</b-th>
                    <b-th>1</b-th>
                    <b-th>2</b-th>
                    <b-th>3</b-th>
                    <b-th>4</b-th>
                    <b-th>5</b-th>
                    <b-th>All</b-th>
                    <b-th>Alt Odd</b-th>
                    <b-th>Alt Even</b-th>
                    <b-th>1</b-th>
                    <b-th>2</b-th>
                    <b-th>3</b-th>
                    <b-th>4</b-th>
                    <b-th>5</b-th>
                    <b-th>All</b-th>
                    <b-th>Alt Odd</b-th>
                    <b-th>Alt Even</b-th>
                    <b-th>1</b-th>
                    <b-th>2</b-th>
                    <b-th>3</b-th>
                    <b-th>4</b-th>
                    <b-th>5</b-th>
                    <b-th>All</b-th>
                    <b-th>Alt Odd</b-th>
                    <b-th>Alt Even</b-th>
                    <b-th>1</b-th>
                    <b-th>2</b-th>
                    <b-th>3</b-th>
                    <b-th>4</b-th>
                    <b-th>5</b-th>
                    <b-th>All</b-th>
                    <b-th>Alt Odd</b-th>
                    <b-th>Alt Even</b-th>
                    <b-th>1</b-th>
                    <b-th>2</b-th>
                    <b-th>3</b-th>
                    <b-th>4</b-th>
                    <b-th>5</b-th>
                    <b-th>All</b-th>
                    <b-th>Alt Odd</b-th>
                    <b-th>Alt Even</b-th>
                </b-tr>
            </b-thead>
            <b-tbody>
                <b-tr class="w-100">
                    <b-td>
                        <b-form-checkbox></b-form-checkbox>
                    </b-td>
                    <b-td>C001064</b-td>
                    <b-td>HIMMATSINH PARMAR</b-td>
                    <b-td >
                        <b-form-group>
                            <b-form-checkbox v-model="formData.sunday_one"></b-form-checkbox>
                        </b-form-group>
                    </b-td>
                    <b-td >
                        <b-form-group>
                            <b-form-checkbox v-model="formData.sunday_two"></b-form-checkbox>
                        </b-form-group>
                    </b-td>
                    <b-td >
                        <b-form-group>
                            <b-form-checkbox v-model="formData.sunday_three"></b-form-checkbox>
                        </b-form-group>
                    </b-td>
                    <b-td >
                        <b-form-group>
                            <b-form-checkbox v-model="formData.sunday_four"></b-form-checkbox>
                        </b-form-group>
                    </b-td>
                    <b-td >
                        <b-form-group>
                            <b-form-checkbox v-model="formData.sunday_five"></b-form-checkbox>
                        </b-form-group>
                    </b-td>
                    <b-td>
                        <b-form-group>
                            <b-form-checkbox v-model="formData.sunday_all"></b-form-checkbox>
                        </b-form-group>
                    </b-td>
                    <td >
                        <b-form-group>
                            <b-form-checkbox v-model="formData.sunday_alt_odd"></b-form-checkbox>
                        </b-form-group>
                    </td>
                    <td >
                        <b-form-group>
                            <b-form-checkbox v-model="formData.sunday_alt_even"></b-form-checkbox>
                        </b-form-group>
                    </td>
                    <b-td>
                        <b-form-group>
                            <b-form-checkbox v-model="formData.monday_one"></b-form-checkbox>
                        </b-form-group>
                    </b-td>
                    <b-td>
                        <b-form-group>
                            <b-form-checkbox v-model="formData.monday_two"></b-form-checkbox>
                        </b-form-group>
                    </b-td>
                    <b-td>
                        <b-form-group>
                            <b-form-checkbox v-model="formData.monday_three"></b-form-checkbox>
                        </b-form-group>
                    </b-td>
                    <b-td>
                        <b-form-group>
                            <b-form-checkbox v-model="formData.monday_four"></b-form-checkbox>
                        </b-form-group>
                    </b-td>
                    <b-td>
                        <b-form-group>
                            <b-form-checkbox v-model="formData.monday_five"></b-form-checkbox>
                        </b-form-group>
                    </b-td>
                    <b-td>
                        <b-form-group>
                            <b-form-checkbox v-model="formData.monday_all"></b-form-checkbox>
                        </b-form-group>
                    </b-td>
                    <td>
                        <b-form-group>
                            <b-form-checkbox v-model="formData.monday_alt_odd"></b-form-checkbox>
                        </b-form-group>
                    </td>
                    <td>
                        <b-form-group>
                            <b-form-checkbox v-model="formData.monday_alt_even"></b-form-checkbox>
                        </b-form-group>
                    </td>

                    <b-td>
                        <b-form-group>
                            <b-form-checkbox v-model="formData.tuesday_one"></b-form-checkbox>
                        </b-form-group>
                    </b-td>
                    <b-td>
                        <b-form-group>
                            <b-form-checkbox v-model="formData.tuesday_two"></b-form-checkbox>
                        </b-form-group>
                    </b-td>
                    <b-td>
                        <b-form-group>
                            <b-form-checkbox v-model="formData.tuesday_three"></b-form-checkbox>
                        </b-form-group>
                    </b-td>
                    <b-td>
                        <b-form-group>
                            <b-form-checkbox v-model="formData.tuesday_four"></b-form-checkbox>
                        </b-form-group>
                    </b-td>
                    <b-td>
                        <b-form-group>
                            <b-form-checkbox v-model="formData.tuesday_five"></b-form-checkbox>
                        </b-form-group>
                    </b-td>
                    <b-td>
                        <b-form-group>
                            <b-form-checkbox v-model="formData.tuesday_all"></b-form-checkbox>
                        </b-form-group>
                    </b-td>
                    <td>
                        <b-form-group>
                            <b-form-checkbox v-model="formData.tuesday_alt_odd"></b-form-checkbox>
                        </b-form-group>
                    </td>
                    <td>
                        <b-form-group>
                            <b-form-checkbox v-model="formData.tuesday_alt_even"></b-form-checkbox>
                        </b-form-group>
                    </td>
                    <b-td>
                        <b-form-group>
                            <b-form-checkbox v-model="formData.wednesday_one"></b-form-checkbox>
                        </b-form-group>
                    </b-td>
                    <b-td>
                        <b-form-group>
                            <b-form-checkbox v-model="formData.wednesday_two"></b-form-checkbox>
                        </b-form-group>
                    </b-td>
                    <b-td>
                        <b-form-group>
                            <b-form-checkbox v-model="formData.wednesday_three"></b-form-checkbox>
                        </b-form-group>
                    </b-td>
                    <b-td>
                        <b-form-group>
                            <b-form-checkbox v-model="formData.wednesday_four"></b-form-checkbox>
                        </b-form-group>
                    </b-td>
                    <b-td>
                        <b-form-group>
                            <b-form-checkbox v-model="formData.wednesday_five"></b-form-checkbox>
                        </b-form-group>
                    </b-td>
                    <b-td>
                        <b-form-group>
                            <b-form-checkbox v-model="formData.wednesday_all"></b-form-checkbox>
                        </b-form-group>
                    </b-td>
                    <td>
                        <b-form-group>
                            <b-form-checkbox v-model="formData.wednesday_alt_odd"></b-form-checkbox>
                        </b-form-group>
                    </td>
                    <td>
                        <b-form-group>
                            <b-form-checkbox v-model="formData.wednesday_alt_even"></b-form-checkbox>
                        </b-form-group>
                    </td>
                    <b-td>
                        <b-form-group>
                            <b-form-checkbox v-model="formData.thursday_one"></b-form-checkbox>
                        </b-form-group>
                    </b-td>
                    <b-td>
                        <b-form-group>
                            <b-form-checkbox v-model="formData.thursday_two"></b-form-checkbox>
                        </b-form-group>
                    </b-td>
                    <b-td>
                        <b-form-group>
                            <b-form-checkbox v-model="formData.thursday_three"></b-form-checkbox>
                        </b-form-group>
                    </b-td>
                    <b-td>
                        <b-form-group>
                            <b-form-checkbox v-model="formData.thursday_four"></b-form-checkbox>
                        </b-form-group>
                    </b-td>
                    <b-td>
                        <b-form-group>
                            <b-form-checkbox v-model="formData.thursday_five"></b-form-checkbox>
                        </b-form-group>
                    </b-td>
                    <b-td>
                        <b-form-group>
                            <b-form-checkbox v-model="formData.thursday_all"></b-form-checkbox>
                        </b-form-group>
                    </b-td>
                    <td>
                        <b-form-group>
                            <b-form-checkbox v-model="formData.thursday_alt_odd"></b-form-checkbox>
                        </b-form-group>
                    </td>
                    <td>
                        <b-form-group>
                            <b-form-checkbox v-model="formData.thursday_alt_even"></b-form-checkbox>
                        </b-form-group>
                    </td>
                    <b-td>
                        <b-form-group>
                            <b-form-checkbox v-model="formData.friday_one"></b-form-checkbox>
                        </b-form-group>
                    </b-td>
                    <b-td>
                        <b-form-group>
                            <b-form-checkbox v-model="formData.friday_two"></b-form-checkbox>
                        </b-form-group>
                    </b-td>
                    <b-td>
                        <b-form-group>
                            <b-form-checkbox v-model="formData.friday_three"></b-form-checkbox>
                        </b-form-group>
                    </b-td>
                    <b-td>
                        <b-form-group>
                            <b-form-checkbox v-model="formData.friday_four"></b-form-checkbox>
                        </b-form-group>
                    </b-td>
                    <b-td>
                        <b-form-group>
                            <b-form-checkbox v-model="formData.friday_five"></b-form-checkbox>
                        </b-form-group>
                    </b-td>
                    <b-td>
                        <b-form-group>
                            <b-form-checkbox v-model="formData.friday_all"></b-form-checkbox>
                        </b-form-group>
                    </b-td>
                    <td>
                        <b-form-group>
                            <b-form-checkbox v-model="formData.friday_alt_odd"></b-form-checkbox>
                        </b-form-group>
                    </td>
                    <td>
                        <b-form-group>
                            <b-form-checkbox v-model="formData.friday_alt_even"></b-form-checkbox>
                        </b-form-group>
                    </td>
                    <b-td>
                        <b-form-group>
                            <b-form-checkbox v-model="formData.saturday_one"></b-form-checkbox>
                        </b-form-group>
                    </b-td>
                    <b-td>
                        <b-form-group>
                            <b-form-checkbox v-model="formData.saturday_two"></b-form-checkbox>
                        </b-form-group>
                    </b-td>
                    <b-td>
                        <b-form-group>
                            <b-form-checkbox v-model="formData.saturday_three"></b-form-checkbox>
                        </b-form-group>
                    </b-td>
                    <b-td>
                        <b-form-group>
                            <b-form-checkbox v-model="formData.saturday_four"></b-form-checkbox>
                        </b-form-group>
                    </b-td>
                    <b-td>
                        <b-form-group>
                            <b-form-checkbox v-model="formData.saturday_five"></b-form-checkbox>
                        </b-form-group>
                    </b-td>
                    <b-td>
                        <b-form-group>
                            <b-form-checkbox v-model="formData.saturday_all"></b-form-checkbox>
                        </b-form-group>
                    </b-td>
                    <td>
                        <b-form-group>
                            <b-form-checkbox v-model="formData.saturday_alt_odd"></b-form-checkbox>
                        </b-form-group>
                    </td>
                    <td>
                        <b-form-group>
                            <b-form-checkbox v-model="formData.saturday_alt_even"></b-form-checkbox>
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
    } from 'bootstrap-vue'
    import {codeSimple} from "../../../table/bs-table/code";
    import {ref} from '@vue/composition-api'

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
        },
        setup() {
            const formData = ref({
                sunday_one: null,
                sunday_two: null,
                sunday_three: null,
                sunday_four: null,
                sunday_five: null,
                sunday_all: null,
                sunday_alt_odd: null,
                sunday_alt_even: null,
                monday_one: null,
                monday_two: null,
                monday_three: null,
                monday_four: null,
                monday_five: null,
                monday_all: null,
                monday_alt_odd: null,
                monday_alt_even: null,
                tuesday_one: null,
                tuesday_two: null,
                tuesday_three: null,
                tuesday_four: null,
                tuesday_five: null,
                tuesday_all: null,
                tuesday_alt_odd: null,
                tuesday_alt_even: null,
                wednesday_one: null,
                wednesday_two: null,
                wednesday_three: null,
                wednesday_four:null,
                wednesday_five:null,
                wednesday_all:null,
                wednesday_alt_odd:null,
                wednesday_alt_even:null,
                thursday_one:null,
                thursday_two:null,
                thursday_three:null,
                thursday_four:null,
                thursday_five:null,
                thursday_all:null,
                thursday_alt_odd:null,
                thursday_alt_even:null,
                friday_one:null,
                friday_two:null,
                friday_three:null,
                friday_four:null,
                friday_five:null,
                friday_all:null,
                friday_alt_odd:null,
                friday_alt_even:null,
                saturday_one:null,
                saturday_two:null,
                saturday_three:null,
                saturday_four:null,
                saturday_five:null,
                saturday_all:null,
                saturday_alt_odd:null,
                saturday_alt_even:null
            })
            const saveFormData = async () => {}
            return {
                codeSimple,
                formData,
                saveFormData
            }
        },
    }
</script>


