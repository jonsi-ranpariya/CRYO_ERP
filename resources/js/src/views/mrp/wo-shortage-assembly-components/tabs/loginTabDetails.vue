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
            <b-col md="6">
                <b-form-group
                    label="Approved By"
                    label-for="approvedBy"
                >
                    <b-form-input
                        v-model="loginData.approvedBy"
                        id="approvedBy"
                        readonly
                    />
                </b-form-group>
            </b-col>
            <b-col md="6">
                <b-form-group
                    label="Date & Time"
                    label-for="approveDate"
                >
                    <b-form-input
                        v-model="loginData.approveDate"
                        id="approveDate"
                        disabled
                    />
                </b-form-group>
            </b-col>
            <b-col md="6">
                <b-form-group
                    label="Stage"
                    label-for="stage"
                >
                    <v-select
                        id="serialNoWiseStock"
                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                        :options="stageOptions"
                        :reduce="val => val.value"
                        aria-placeholder="Select Stage"
                        :clearable="false"
                        v-model="loginData.stage"
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
    import {ref} from "@vue/composition-api";

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
        },
        setup() {
            const stageOptions = ref([
                {label: 'Prepared', value: 1},
                {label: 'Approved', value: 2},
                {label: 'Regret', value: 3}
            ])

            return {
                stageOptions,
            }
        }

    }
</script>
