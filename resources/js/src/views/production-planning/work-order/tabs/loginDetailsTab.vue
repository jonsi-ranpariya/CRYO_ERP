<template>
    <div>
        <hr>
        <b-form-group
            label="createdBy"
            label-for="createdBy"
        >
            <b-form-input
                id="createdBy"
                v-model="loginData.createdBy"
                disabled
            />
        </b-form-group>
        <b-form-group
            label="Date & Time"
            label-for="createdDateTime"
        >
            <b-form-input
                id="createdDateTime"
                v-model="loginData.createdDate"
                disabled
            />
        </b-form-group>
        <b-form-group
            label="Last Modified By"
            label-for="lastModifiedBy"
        >
            <b-form-input
                id="lastModifiedBy"
                v-model="loginData.lastModifyBy"
                disabled
            />
        </b-form-group>
        <b-form-group
            label="Date & Time"
            label-for="lastModifiedDate"
        >
            <b-form-input
                id="lastModifiedDate"
                v-model="loginData.lastModifyDate"
                disabled
            />
        </b-form-group>
        <b-form-group
            label="Approved By"
            label-for="approvedBy"
        >
            <b-form-input
                id="approvedBy"
                v-model="loginData.approveBy"
                disabled
            />
        </b-form-group>
        <b-form-group
            label="Date & Time"
            label-for="approveDate"
        >
            <b-form-input
                id="approveDate"
                v-model="loginData.approveDate"
                disabled
            />
        </b-form-group>
    </div>
</template>
<script>
    import BCardCode from '@core/components/b-card-code'
    import {
        BRow,
        BCol,
        BFormGroup,
        BFormInput,
        BFormTextarea,
        BFormCheckbox,
        BForm,
        BButton,
        BFormDatepicker,
        BTable,
        BFormInvalidFeedback,
        BCard,
        BSpinner,
        BOverlay,
    } from 'bootstrap-vue'

    export default {
        components: {
            BCardCode,
            BRow,
            BCol,
            BFormGroup,
            BFormInput,
            BFormCheckbox,
            BFormTextarea,
            BForm,
            BButton,
            BFormDatepicker,
            BTable,
            BFormInvalidFeedback,
            BCard,
            BOverlay,
            BSpinner,
        },
        props: {
            loginData: {
                type: Object,
            }
        }
    }
</script>
