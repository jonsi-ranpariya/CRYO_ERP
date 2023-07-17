<template>
    <b-form>
        <b-row>
            <b-col md="4">
                <b-form-group
                    label="Page"
                    label-for="page"
                >
                    <v-select
                        v-model="formData.page"
                        placeholder="Select Page"
                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                        :options="pageOPtion"
                        :reduce="val => val.value"
                        :clearable="false"
                        input-id="page"
                    />
                </b-form-group>
            </b-col>
         </b-row>
            <b-row>
                <b-col class="d-flex mt-1">
                    <b-form-checkbox
                    >
                        Header Image
                    </b-form-checkbox>
                    <b-form-checkbox
                        class="ml-2"
                    >
                        Footer Image
                    </b-form-checkbox>
                </b-col>
            </b-row>
    </b-form>
</template>
<script>
    import {ref} from '@vue/composition-api'
    import {BForm,BRow,BCol,BFormGroup,BFormCheckbox} from 'bootstrap-vue'
    import vSelect from 'vue-select'
    export default {
        components:{
            BForm,BRow,BCol,BFormGroup,vSelect,BFormCheckbox
        },
        setup(){
            const pageOPtion =ref([
                {label:'blank Page', value:1}
            ])
            const formData = ref([

            ])
            return{
                formData,
                pageOPtion,
            }
        }
    }
</script>
