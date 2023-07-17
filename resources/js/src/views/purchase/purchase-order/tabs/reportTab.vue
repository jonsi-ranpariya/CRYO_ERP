<template>
    <div>
        <b-row>
            <b-col md="2"><b>Report Details</b></b-col>
        </b-row>
        <hr>
        <br>
        <b-row>
            <b-col md="6">
                <b-form-radio
                    name="puchase-radio"
                    value="1"
                    class="custom-control-primary mb-2"
                >
                    Purchase Order
                </b-form-radio>
                <br>
                <b-form-checkbox
                    v-model="selected"
                    value="A"
                    class="mb-1"
                >
                    Report With Conv Qty.
                </b-form-checkbox>
                <b-form-checkbox
                    v-model="selected"
                    value="B"
                    class="mb-1"
                >
                    Report With Discount
                </b-form-checkbox>
                <b-form-checkbox
                    v-model="selected"
                    value="C"
                    class="mb-1"
                >
                    Report With Discounted Rate
                </b-form-checkbox>
                <b-form-checkbox
                    v-model="selected"
                    value="D"
                    class="mb-1"
                >
                    Report WithOut Rate
                </b-form-checkbox>
<!--                <b-form-checkbox
                    v-model="selected"
                    value="E"
                    class="mb-1"
                >
                    Report With Item Wise Grouping
                </b-form-checkbox>-->

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
                        input-id="page"
                    />
                </b-form-group>
            </b-col>
            <b-col md="6">
                <b-form-checkbox
                    v-model="selected"
                    value="F"
                    class="mb-1"
                >
                    Common Delivery Date for All Items
                </b-form-checkbox>
                <b-form-checkbox
                    v-model="selected"
                    value="G"
                    class="mb-1"
                >
                    Without Delivery Date
                </b-form-checkbox>
                <b-form-checkbox
                    v-model="selected"
                    value="H"
                    class="mb-1"
                >
                    With Delivery Schedule Rate
                </b-form-checkbox>
                <b-form-checkbox
                    v-model="selected"
                    value="I"
                    class="mb-1"
                >
                    Rate With 4 Decimal Points
                </b-form-checkbox>
                <b-row>
                    <b-col md="6"></b-col>
                    <b-col md="6">
                        <b-form-checkbox
                            v-model="selected"
                            value="J"
                            class="mb-1"
                        >
                            With GST %
                        </b-form-checkbox>
                    </b-col>
                </b-row>
                <b-row>
                    <b-col md="6">
                        <b-form-checkbox
                            v-model="selected"
                            value="K"
                            class="mb-1"
                        >
                            FORM 403
                        </b-form-checkbox>
                        <b-form-checkbox
                            v-model="selected"
                            value="L"
                            class="mb-1"
                        >
                            Vendor Challan
                        </b-form-checkbox>
                    </b-col>
                    <b-col md="6"></b-col>
                </b-row>
                <br>
                <b-row>
                    <b-col md="6">
                        <b-form-checkbox
                            v-model="selected"
                            value="M"
                            class="mb-1"
                        >
                            Envelop # 10
                        </b-form-checkbox>
                    </b-col>
                    <b-col md="6">
<!--                        <b-form-checkbox
                            v-model="selected"
                            value="N"
                            class="mb-1"
                        >
                            Header Image
                        </b-form-checkbox>
                        <b-form-checkbox
                            v-model="selected"
                            value="O"
                            class="mb-1"
                        >
                            Footer Image
                        </b-form-checkbox>-->
                        <b-form-checkbox
                            v-model="selected"
                            value="P"
                            class="mb-1"
                        >
                            User Sign
                        </b-form-checkbox>
                    </b-col>
                </b-row>
            </b-col>
            <!-- Button-->
            <b-col md="12">
                <hr>
                <b-button
                    class="float-right"
                    variant="primary"
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
    BFormRadio,
    BFormGroup,
    BFormCheckbox,
    BButton
} from 'bootstrap-vue'
import vSelect from 'vue-select'
import {ref} from '@vue/composition-api'

export default {
    components: {
        BRow,
        BCol,
        BFormRadio,
        BFormGroup,
        BFormCheckbox,
        vSelect,
        BButton,
    },
    setup() {
        const selected = ref([])
        const pageOption = ref([
            {label: 'Blank Page', value: 1},
            {label: 'Letter Pad', value: 2}
        ])

        return {
            selected,
            pageOption,
        }
    }
}
</script>
