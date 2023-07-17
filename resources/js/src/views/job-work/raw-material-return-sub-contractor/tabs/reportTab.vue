<template>
    <div>
        <b-row>
            <b-col md="2"><b>Report Details</b></b-col>
        </b-row>
        <hr>
        <b-row>
            <b-col md="6">
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
            <b-col md="6"></b-col>
            <b-col>
                <hr>
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
    BFormCheckbox,
    BButton
} from 'bootstrap-vue'
import vSelect from 'vue-select'
import {ref} from "@vue/composition-api";
export default {
    components:{
        BRow,
        BCol,
        BFormGroup,
        BFormCheckbox,
        vSelect,
        BButton
    },
    setup(){
        const pageOption = ref([
            {label: 'Blank Page', value: 1},
            {label: 'Latter Pad', value: 2}
        ])
        const selected = ref([])
        return{
            selected,
            pageOption
        }
    }
}
</script>
