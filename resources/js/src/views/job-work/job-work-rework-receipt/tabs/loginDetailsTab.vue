<template>
    <div>
        <b-row>
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
                    label-for="createdDateTime"
                >
                    <b-form-input
                        v-model="loginData.dateTime"
                        id="createdDateTime"
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
                        v-model="loginData.modifiedDateTime"
                        id="modifiedDateTime"
                        disabled
                    />
                </b-form-group>
            </b-col>
        </b-row>
    </div>
</template>
<script>
    import {BRow, BCol, BFormGroup, BFormInput,} from 'bootstrap-vue'
    import BCardCode from "../../../../@core/components/b-card-code/BCardCode";
    import VSelect from 'vue-select'
    import Ripple from "vue-ripple-directive";

    export default {
        components: {
            BCardCode,
            BRow,
            BCol,
            BFormGroup,
            BFormInput,
            VSelect,
        },
        directives: {
            Ripple,
        },
        props: {
            loginData: {
                type: Object
            }
        }

    }
</script>
