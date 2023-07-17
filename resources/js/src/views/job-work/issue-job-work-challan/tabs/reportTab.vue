<template>
    <div>
        <b-row>
            <b-col md="2"><b>Report Details</b></b-col>
        </b-row>
        <hr>
        <b-row>
            <b-col md="5">
                <b-form-group
                    label=""
                    label-for="selectRound"
                >
                    <div class="demo-inline-spacing">
                        <b-form-radio
                            name="selectRound"
                            value="0"
                            v-model="roundingType"
                        >
                            Job Work Challan Excisable(Annx II)
                        </b-form-radio>
                        <b-form-radio
                            name="selectRound"
                            value="1"
                            v-model="roundingType"
                        >
                            Job Work Challan General
                        </b-form-radio>
                    </div>
                </b-form-group><br>
                <b-form-radio
                    name="selectRound"
                    value="4"
                    v-model="roundingType"
                    class="mb-2"
                >
                    GST Job Work Challan
                </b-form-radio>
                <br>
                <b-form-group
                    label="Page"
                    label-for="page"
                >
                    <v-select
                        placeholder="Select Page"
                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                        :reduce="val => val.value"
                        :options="pageOption"
                        :clearable="false"
                        input-id="Blank page"
                    />
                </b-form-group>
                <b-form-checkbox
                    v-model="selected"
                    value="A"
                    class="mb-1"
                >
                    Header Image
                </b-form-checkbox>
                <b-form-checkbox
                    v-model="selected"
                    value="B"
                    class="mb-1"
                >
                    Footer Image
                </b-form-checkbox>
            </b-col>
            <b-col md="7"><br>
                <b-form-checkbox
                    v-model="selected"
                    value="B"
                    class="mb-1"
                >
                    With Rate
                </b-form-checkbox>
                <b-form-checkbox
                    v-model="selected"
                    value="B"
                    class="mb-1"
                >
                    With Conversion
                </b-form-checkbox>
                <br>
                <b-form-checkbox
                    v-model="selected"
                    value="B"
                    class="mb-1"
                >
                    Report With Only Issue Items
                </b-form-checkbox>
                <b-form-checkbox
                    v-model="selected"
                    value="B"
                    class="mb-1"
                >
                    Print First Process Issue Items
                </b-form-checkbox>
            </b-col>
        </b-row>
        <hr>
        <b-row>
            <b-col>
                <b-button
                    variant="primary"
                    class="float-right"
                    type="submit"
                >
                    Preview
                </b-button>
            </b-col>
        </b-row>
    </div>
</template>
<script>
    import {
        BRow,
        BCol,
        BFormGroup,
        BFormRadio,
        BFormCheckbox,
        BButton
    } from 'bootstrap-vue'
    import {ref} from "@vue/composition-api";
    import vSelect from 'vue-select'

    export default {
        components: {
            BRow,
            BCol,
            BFormGroup,
            BFormRadio,
            BFormCheckbox,
            vSelect,
            BButton
        },
        setup() {
            const pageOption = ref([
                {label: 'Blank Page', value: 1},
                {label: 'Letter Pad', value: 2}
            ])
            const roundingType = ref([])
            const selected = ref([])
            return {
                roundingType,
                pageOption,
                selected
            }
        }
    }
</script>
