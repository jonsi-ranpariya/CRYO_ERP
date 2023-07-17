<template>
    <b-row>
        <b-col cols="12" class="mb-2">
            <h5>Login Details</h5>
        </b-col>
        <b-col md="6">
            <b-form-group
                label="Created By"
                label-for="createdBy"
            >
                <b-form-input
                    v-model="loginData.createdBy"
                    id="createdBy"
                    readonly
                />
            </b-form-group>
        </b-col>
        <b-col md="6">
            <b-form-group
                label="Date & Time"
                label-for="dateTime"
            >
                <b-form-input
                    v-model="loginData.dateTime"
                    disabled
                />
            </b-form-group>
        </b-col>
        <b-col md="6">
            <b-form-group
                label="Last Modified By"
                label-for="lastModifiedBy"
            >
                <b-form-input
                    v-model="loginData.lastModifiedBy"
                    id="lastModifiedBy"
                    readonly
                />
            </b-form-group>
        </b-col>
        <b-col md="6">
            <b-form-group
                label="Date & Time"
                label-for="modifiedDateTime"
            >
                <b-form-input
                    id="modifiedDateTime"
                    v-model="loginData.modifiedDateTime"
                    disabled
                />
            </b-form-group>
        </b-col>
    </b-row>
</template>

<script>
    import BCardCode from "../../../../@core/components/b-card-code/BCardCode";
    import {BForm, BRow, BCol, BFormGroup, BFormInput, BFormDatepicker, BButton} from 'bootstrap-vue'

    export default {
        components: {
            BCardCode,
            BForm,
            BRow,
            BCol,
            BFormGroup,
            BFormInput,
            BFormDatepicker,
            BButton,
        },
        props: {
            loginData: {
                type: Object
            }
        }
    }
</script>
