<template>
    <div>
        <b-row>
            <b-col md="6">
                <hr>
                <h4>Quotation Note</h4>
                <hr>
                <b-form-group
                    label="Note"
                    label-for="quotationNote"
                >
                    <b-form-textarea
                        rows="4"
                        id="quotationNote"
                        v-model="noteData.quotationNote"
                        disabled
                    />
                </b-form-group>
                <b-form-group
                    label="Authorised By"
                    label-for="authorisedBy"
                >
                    <v-select
                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                        :clearable="false"
                        :options="authorisedByOptions"
                        input-id="authorisedBy"
                        :reduce="val => val.value"
                        v-model="noteData.authorisedBy"
                        disabled
                    />
                </b-form-group>
            </b-col>
            <b-col md="6">
                <hr>
                <h4>Reference Note</h4>
                <hr>
                <b-form-group
                    label="Note"
                    label-for="referenceNote"
                >
                    <b-form-textarea
                        rows="4"
                        id="referenceNote"
                        v-model="noteData.referenceNote"
                        disabled
                    />
                </b-form-group>
                <b-form-group
                    label="Item Desc Title"
                    label-for="itemDescTitle"
                >
                    <b-form-textarea
                        rows="3"
                        id="itemDescTitle"
                        v-model="noteData.itemDescTitle"
                        disabled
                    />
                </b-form-group>
                <b-form-group
                    label="AddOn Title"
                    label-for="addonTitle"
                >
                    <b-form-textarea
                        rows="3"
                        id="addonTitle"
                        v-model="noteData.addonTitle"
                        disabled
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
            authorisedByOptions: {
                type: Array
            },
            noteData: {
                type: Object
            }
        }
    }
</script>
