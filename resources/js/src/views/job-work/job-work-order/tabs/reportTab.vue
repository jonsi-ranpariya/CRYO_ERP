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
                        </b-form-radio><br>
                        <b-form-radio
                            name="selectRound"
                            value="2"
                            v-model="roundingType"
                        >
                            Job Work Order
                        </b-form-radio>
                        <b-form-radio
                            name="selectRound"
                            value="3"
                            v-model="roundingType"
                        >
                            Job Work Order Without Issue Items
                        </b-form-radio>
                        <b-form-radio
                            name="selectRound"
                            value="4"
                            v-model="roundingType"
                            class="mb-2"
                        >
                            GST Job Work Challan
                        </b-form-radio>
                    </div>
                </b-form-group>
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
            </b-col>
            <b-col md="7"><br>
                <b-form-checkbox
                    v-model="selected"
                    value="C"
                    class="mb-1"
                >
                    With Rate
                </b-form-checkbox>
                <b-form-checkbox
                    v-model="selected"
                    value="D"
                    class="mb-1"
                >
                    With Conversion
                </b-form-checkbox><br>
                <b-form-checkbox
                    v-model="selected"
                    value="E"
                    class="mb-1"
                >
                    Format2
                </b-form-checkbox>
                <b-form-checkbox
                    v-model="selected"
                    value="F"
                    class="mb-1"
                >
                    Report With Only Issue Items
                </b-form-checkbox>
                <b-form-checkbox
                    v-model="selected"
                    value="G"
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
    import vSelect from 'vue-select'
    import {ref} from "@vue/composition-api";

    export default {
        components: {
            BFormGroup,
            BFormRadio,
            BRow,
            BCol,
            BFormCheckbox,
            vSelect,
            BButton
        },
        setup() {
            const roundingType = ref([])
            const selected = ref([])
            const pageOption = ref([
                {label: 'Blank Page', value: 1},
                {label: 'Letter Pad', value: 2}
            ])
            return {
                options: [
                    {text: 'Job Work Challan Excisable(Annx II)', value: 'Job Work Challan Excisable'},
                    {text: 'Job Work Challan General', value: 'Job Work Challan General'},
                    {text: 'Job Work Order', value: 'Job Work Order'},
                    {text: 'Job Work Order Without Issue Items', value: 'ob Work Order Without Issue Items'},
                    {text: 'GST Job Work Challan', value: 'GST Job Work Challan'},
                ],
                roundingType,
                pageOption,
                selected,
            }
        }
    }
</script>
