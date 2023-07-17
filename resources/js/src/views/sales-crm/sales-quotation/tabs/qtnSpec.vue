<template>
    <div>
        <b-row>
            <b-col md="12">
                <hr>
                <h4>Quotation Specification</h4>
                <hr>
                <b-form-group
                    label="Specification 1"
                    label-for="specificationOne"
                >
                    <b-form-textarea
                        rows="4"
                        id="specificationOne"
                        v-model="qtnSpecData.specificationOne"
                    />
                </b-form-group>
                <b-form-group
                    label="Specification 2"
                    label-for="specificationTwo"
                >
                    <b-form-textarea
                        rows="3"
                        id="specificationTwo"
                        v-model="qtnSpecData.specificationTwo"
                    />
                </b-form-group>
                <b-form-group
                    label="Specification 3"
                    label-for="specificationThree"
                >
                    <b-form-textarea
                        rows="2"
                        id="specificationThree"
                        v-model="qtnSpecData.specificationThree"
                    />
                </b-form-group>
            </b-col>
        </b-row>
    </div>
</template>
<script>
    import {ValidationProvider, ValidationObserver} from 'vee-validate'
    import {
        BRow, BCol, BFormGroup, BFormInput, BFormTextarea, BForm, BButton, BFormDatepicker,BDropdown,BDropdownItem
    } from 'bootstrap-vue'
    import {required} from '@validations'
    import Ripple from 'vue-ripple-directive'
    import vSelect from 'vue-select'
    import {ref, onUnmounted} from '@vue/composition-api'
    import router from '@/router'

    export default {
        components: {
            ValidationProvider,
            ValidationObserver,
            BRow,
            BCol,
            BFormGroup,
            BFormInput,
            BFormTextarea,
            BForm,
            BButton,
            BDropdown,
            BDropdownItem,
            BFormDatepicker,
            vSelect
        },
        directives: {
            Ripple,
        },
        props: {
            qtnSpecData: {
                type: Object
            }
        }
    }
</script>
