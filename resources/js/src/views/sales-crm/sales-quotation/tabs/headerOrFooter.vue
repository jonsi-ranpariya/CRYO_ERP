<template>
    <div>
        <b-row>
            <b-col md="12">
                <hr>
                <h4>Header/Footer</h4>
                <b-form-group
                    label="Subject"
                    label-for="subject"
                >
                    <b-form-input
                        id="subject"
                        v-model="headerFooterData.subject"
                    />
                </b-form-group>
                <b-form-group
                    label="Header Option"
                    label-for="headerOption"
                >
                    <v-select
                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                        :options="headerOptions"
                        :clearable="false"
                        input-id="headerOption"
                        :reduce="val => val.value"
                        v-model="headerFooterData.headerType"
                        v-on:input="getHeaderData(headerFooterData.headerType)"
                    />
                </b-form-group>
                <b-form-group
                    label="Header"
                    label-for="header"
                >
                    <b-form-textarea
                        id="header"
                        rows="3"
                        v-model="headerFooterData.header"
                    />
                </b-form-group>
                <b-form-group
                    label="Footer Option"
                    label-for="footer"
                >
                    <v-select
                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                        :options="footerOptions"
                        :clearable="false"
                        input-id="footer"
                        :reduce="val => val.value"
                        v-model="headerFooterData.footerType"
                        v-on:input="getFooterData(headerFooterData.footerType)"
                    />
                </b-form-group>
                <b-form-group
                    label="Footer"
                    label-for="footer"
                >
                    <b-form-textarea
                        id="footer"
                        rows="3"
                        v-model="headerFooterData.footer"
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
            headerOptions: {
                type: Array
            },
            footerOptions: {
                type: Array
            },
            headerFooterData: {
                type: Object
            }
        },
        methods: {
            getHeaderData(id){
                this.$http.get(`/api/document-header/${id}`).then(res => {
                    this.headerFooterData.header = res.data.data.header
                    this.headerFooterData.headerType = id
                })
            },
            getFooterData(id){
                this.$http.get(`/api/document-footer/${id}`).then(res => {
                    this.headerFooterData.footer = res.data.data.footer
                    this.headerFooterData.footerType = id
                })
            }
        }
    }
</script>
