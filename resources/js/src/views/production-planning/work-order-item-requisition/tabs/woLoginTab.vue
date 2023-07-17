<template>
    <div>
        <b-form-group
            label="Created By"
            label-for="createdBy"
        >
            <b-form-input
                id="createdBy"
                readonly
                v-model="loginData.createdBy"
            />
        </b-form-group>
        <b-form-group
            label="Date & Time"
            label-for="createdByDateTime"
        >
            <b-form-input
                id="createdByDateTime"
                readonly
                v-model="loginData.createdDate"
            />
        </b-form-group>
        <b-form-group
            label="Last Modified By"
            label-for="modifiedBy"
        >
            <b-form-input
                id="modifiedBy"
                readonly
                v-model="loginData.lastModifyBy"
            />
        </b-form-group>
        <b-form-group
            label="Date & Time"
            label-for="modifiedByDateTime"
        >
            <b-form-input
                id="modifiedByDateTime"
                readonly
                v-model="loginData.lastModifyDate"
            />
        </b-form-group>
        <b-form-group
            label="Approved By"
            label-for="approvedBy"
        >
            <b-form-input
                id="approvedBy"
                readonly
                v-model="loginData.approveBy"
            />
        </b-form-group>
        <b-form-group
            label="Date & Time"
            label-for="approveByDateTime"
        >
            <b-form-input
                id="approveByDateTime"
                readonly
                v-model="loginData.approveBy"
            />
        </b-form-group>
    </div>
</template>
<script>
    import { computed } from '@vue/composition-api'
    import {BFormGroup, BFormInput, BFormDatepicker} from 'bootstrap-vue'

    export default {
        name: 'woLoginTab',
        components: {
            BFormGroup,
            BFormInput,
            BFormDatepicker,
        },
        props: {
            loginData: {
                type: Object,
                required: true
            }
        },
        setup(props){
            const loginDetails = computed(() => props.loginData)

            return {
                loginDetails
            }
        }
    }
</script>
