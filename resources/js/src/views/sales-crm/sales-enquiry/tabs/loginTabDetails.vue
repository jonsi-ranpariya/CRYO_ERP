<template>
    <div>
        <b-row>
            <b-col md="6">
                <hr>
                <h4>Login Details</h4>
                <hr>
                <b-form-group
                    label="Created By"
                    label-for="createdBy"
                >
                    <b-form-input
                        id="createdBy"
                        :value="loginData.createdBy"
                        readonly
                    />
                </b-form-group>
                <b-form-group
                    label="Date & Time"
                    label-for="createdDateAndTime"
                >
                    <b-form-input
                        id="dateAndTime"
                        :value="loginData.createdDateTime"
                        readonly
                    />
                </b-form-group>
                <b-form-group
                    label="Last Modified By"
                    label-for="lastModifiedBy"
                >
                    <b-form-input
                        id="lastModifiedBy"
                        :value="loginData.lastModifiedBy"
                        readonly
                    />
                </b-form-group>
                <b-form-group
                    label="Date & Time"
                    label-for="updateDateAndTime"
                >
                    <b-form-input
                        id="updateDateAndTime"
                        :value="loginData.modifiedDateTime"
                        readonly
                    />
                </b-form-group>
            </b-col>
            <b-col md="6">
                <hr>
                <h4>Enquiry Stage</h4>
                <hr>
                <b-form-group
                    label="Approved By"
                    label-for="approvedBy"
                >
                    <b-form-input
                        id="approvedBy"
                        v-model="loginData.approvedBy"
                        readonly
                    />
                </b-form-group>
                <b-form-group
                    label="Date & Time"
                    label-for="approvedDateAndTime"
                >
                    <b-form-input
                        id="approvedDateAndTime"
                        v-model="loginData.approvedDateTime"
                        readonly
                    />
                </b-form-group>
                <b-form-group
                    label="Stage"
                    label-for="stage"
                >
                    <b-form-input
                        id="stage"
                        v-model="loginData.stage"
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
    import Ripple from 'vue-ripple-directive'
    import vSelect from 'vue-select'
    import {onUnmounted} from '@vue/composition-api'
    import router from '@/router'
    import moment from 'moment'
    import BCardCode from "../../../../@core/components/b-card-code/BCardCode";
    import salesStoreModule from "../../salesStoreModule";
    import store from '@/store'


    export default {
        components: {
            BCardCode,
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
        props:{
            loginData: {
                type: Object
            },
        },
        data() {
            return {
                dateTime: moment(new Date()).format('DD-MM-YYYY HH:MM'),
            }
        },
        setup(){
            const SO_APP_STORE_MODULE_NAME = 'sales-enquiry-module'
            // Register module
            if (!store.hasModule(SO_APP_STORE_MODULE_NAME)) store.registerModule(SO_APP_STORE_MODULE_NAME, salesStoreModule)
            // UnRegister on leave
            onUnmounted(() => {
                if (store.hasModule(SO_APP_STORE_MODULE_NAME)) store.unregisterModule(SO_APP_STORE_MODULE_NAME)
            })
        }
    }
</script>
