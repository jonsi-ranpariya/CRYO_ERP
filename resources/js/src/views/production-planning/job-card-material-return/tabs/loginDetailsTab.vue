<template>
    <div>
        <b-row>
            <b-col md="6">
                <b-form-group
                    label="Created By"
                    label-for="createdBy"
                >
                    <b-form-input
                        v-model="loginDetails.createdBy"
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
                        v-model="loginDetails.dateTime"
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
                        v-model="loginDetails.lastModifiedBy"
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
                        v-model="loginDetails.modifiedDateTime"
                        disabled
                    />
                </b-form-group>
            </b-col>
            <b-col md="6">
                <b-form-group
                    label="Approved By"
                    label-for="approvedBy"
                >
                    <b-form-input
                        v-model="loginDetails.approvedBy"
                        id="approvedBy"
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
                        id="dateTime"
                        v-model="loginDetails.approveDateTime"
                        disabled
                    />
                </b-form-group>
            </b-col>
        </b-row>
    </div>
</template>
<script>
    import {BRow, BCol, BFormGroup, BFormInput} from 'bootstrap-vue'

    export default {
        components: {
            BRow,
            BCol,
            BFormGroup,
            BFormInput,
        },
        props: {
            loginDetails: {
                type: Object,
                required: true
            }
        }
    }
</script>
