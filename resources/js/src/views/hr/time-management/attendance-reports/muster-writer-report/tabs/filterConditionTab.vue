<template>
    <div>
        <b-card-code>
            <b-form>
                <b-row>
                    <b-col md="6">
                        <b-form-group
                        >
                            <b-form-textarea
                                v-model="formData.blank_text"
                                input-id="blank_text"
                                rows="3"
                            />
                        </b-form-group>
                        <b-button
                            variant="primary"
                            class="mr-1 float-right"
                            type="submit"
                        >
                            Add
                        </b-button>
                        <b-button
                            variant="primary"
                            class="mr-1 float-right"
                        >
                            Clear
                        </b-button>
                    </b-col>
                    <b-col md="6">
                        <b-row>
                            <b-col md="6">
                                <b-form-group
                                    label="Join"
                                    label-for="join"
                                >
                                    <v-select
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :clearable="false"
                                        :reduce="val => val.value"
                                        placeholder="Select Join"
                                        id="join"
                                        v-model="formData.join"
                                        :options="joinOptions"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Field Name"
                                    label-for="field_name"
                                >
                                    <v-select
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :clearable="false"
                                        :reduce="val => val.value"
                                        placeholder="Select Name"
                                        id="field_name"
                                        v-model="formData.field_name"
                                        :options="fieldOptions"
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="6">
                                <b-form-group
                                    label="Operator"
                                    label-for="operator"
                                >
                                    <v-select
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :clearable="false"
                                        :reduce="val => val.value"
                                        placeholder="Select Operator"
                                        id="operator"
                                        v-model="formData.operator"
                                        :options="operatorOptions"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Value"
                                    label-for="value"
                                >
                                    <b-form-input
                                        id="value"
                                        v-model="formData.value"
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>
                    </b-col>
                </b-row>
                <b-col md="12">

                </b-col>
            </b-form>
        </b-card-code>
    </div>
</template>
<script>
    import {
        BForm,
        BRow,
        BCol,
        BFormGroup,
        BFormTextarea,
        BButton,
        BFormInput
    } from 'bootstrap-vue'
    import BCardCode from "@core/components/b-card-code/BCardCode";
    import {ref} from '@vue/composition-api'
    import vSelect from 'vue-select'

    export default {
        components: {
            BCardCode,
            BForm,
            BRow,
            BCol,
            BFormGroup,
            BFormTextarea,
            vSelect,
            BButton,
            BFormInput
        },
        setup() {
            const joinOptions = ref([
                {label:'AND', value:1},
                {label:'OR', value:2},
            ])
            const operatorOptions = ref([
                {label:'SPET', value:1},
                {label:'PRST', value:2},
                {label:'SHFT', value:3},
                {label:'SHFT', value:3},
            ])
            const fieldOptions = ref([
                {label:'>=', value:1},
                {label:'=', value:2},
                {label:'<=', value:3},
            ])
            const formData = ref({
                join:null,
                field_name:null,
                operator:null,
                value:null
            })
            return {
                formData,
                joinOptions,
                operatorOptions,
                fieldOptions
            }
        }
    }
</script>
