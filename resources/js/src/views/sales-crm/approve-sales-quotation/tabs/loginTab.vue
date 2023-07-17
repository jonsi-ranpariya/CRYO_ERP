<template>
    <div>
        <b-row>
            <b-col md="12">
                <hr>
                <h4>Login Details</h4>
                <hr>
            </b-col>
            <b-col md="3">
                <b-form-group
                    label="Created By"
                    label-for="createdBy"
                >
                    <b-form-input
                        id="createdBy"
                        :value="loginDetails.createdBy"
                        readonly
                    />
                </b-form-group>
            </b-col>
            <b-col md="3">
                <b-form-group
                    label="Date & Time"
                    label-for="createdDateAndTime"
                >
                    <b-form-input
                        id="dateAndTime"
                        :value="loginDetails.createdDateTime"
                        readonly
                    />
                </b-form-group>
            </b-col>
            <b-col md="3">
                <b-form-group
                    label="Last Modified By"
                    label-for="lastModifiedBy"
                >
                    <b-form-input
                        id="lastModifiedBy"
                        :value="loginDetails.lastModifiedBy"
                        readonly
                    />
                </b-form-group>
            </b-col>
            <b-col md="3">
                <b-form-group
                    label="Date & Time"
                    label-for="updateDateAndTime"
                >
                    <b-form-input
                        id="updateDateAndTime"
                        :value="loginDetails.modifiedDateTime"
                        readonly
                    />
                </b-form-group>
            </b-col>
            <b-col md="12">
                <hr>
                <h4>Quotation Stage</h4>
                <hr>
            </b-col>
            <b-col md="6">
                <b-form-group
                    label="Prepared By"
                    label-for="preparedBy"
                >
                    <b-form-input
                        id="preparedBy"
                        :value="loginDetails.prepareBy"
                        readonly
                    />
                </b-form-group>
                <b-form-group
                    label="Date & Time"
                    label-for="preparedDateAndTime"
                >
                    <b-form-input
                        id="preparedDateAndTime"
                        v-model="loginDetails.prepareDateTime"
                        readonly
                    />
                </b-form-group>
                <b-form-group
                    label="Approved By"
                    label-for="approvedBy"
                >
                    <b-form-input
                        id="approvedBy"
                        v-model="loginDetails.approvedBy"
                        readonly
                    />
                </b-form-group>
                <b-form-group
                    label="Date & Time"
                    label-for="approvedDateAndTime"
                >
                    <b-form-input
                        id="approvedDateAndTime"
                        v-model="loginDetails.approvedDateTime"
                        readonly
                    />
                </b-form-group>
            </b-col>
            <b-col md="6">
                <b-form-group
                    label="Stage"
                    label-for="stage"
                >
                    <v-select
                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                        :options="stageOptions"
                        :clearable="false"
                        input-id="stage"
                        :reduce="val => val.value"
                        v-model="loginDetails.stage"
                        disabled
                    />
                </b-form-group>
                <b-form-group
                    label="Instructed By"
                    label-for="instructedBy"
                >
                    <v-select
                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                        :options="usersList"
                        :clearable="false"
                        input-id="instructedBy"
                        :reduce="val => val.value"
                        v-model="loginDetails.instructedBy"
                        disabled
                    />
                </b-form-group>
                <b-form-group
                    label="Instructed By Name"
                    label-for="instructedByName"
                >
                    <b-form-input
                        type="text"
                        readonly
                        v-model="loginDetails.instuctedByName"
                    />
                </b-form-group>
                <b-form-group
                    label="Follow Up By"
                    label-for="followUpBy"
                >
                    <v-select
                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                        :options="usersList"
                        :clearable="false"
                        input-id="followUpBy"
                        :reduce="val => val.value"
                        v-model="loginDetails.followUpBy"
                        disabled
                    />
                </b-form-group>
                <b-form-group
                    label="Follow Up By Name"
                    label-for="followUpByName"
                >
                    <b-form-input
                        type="text"
                        readonly
                        v-model="loginDetails.followUpByName"
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
    import { getUserData } from "../../../../auth/utils";
    import moment from 'moment'

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
        props:{
            loginData: {
                type: Object
            },
            loginDetails: {
                type: Object
            },
            usersList: {
                type: Array
            }
        },
        mounted(){
            this.getUserData = getUserData
        },
        computed: {
            getUser(){
                return getUserData()
            }
        },
        setup() {
            const dateTime = moment(new Date()).format('DD-MM-YYYY HH:mm')
            const stageOptions = [
                {label: 'Prepared', value: 1},
                {label: 'Approved', value: 2},
                {label: 'Regret', value: 3}
            ]
            return {
                dateTime,
                stageOptions
            }
        }
    }
</script>
