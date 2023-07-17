<template>
    <div>
        <hr>
        <b-row>
            <b-col md="6">
                <b-form-group
                    label="Created By"
                    label-for="createdBy"
                >
                    <b-form-input
                        id="createdBy"
                        readonly
                        v-model="formData.createdBy"
                    />
                </b-form-group>
                <b-form-group
                    label="Date & Time"
                    label-for="createdDateAndTime"
                >
                    <b-form-input
                        id="createdDateAndTime"
                        disabled
                        v-model="formData.createdDateAndTime"
                    />
                </b-form-group>
                <b-form-group
                    label="Last Modified By"
                    label-for="lastModifiedBy"
                >
                    <b-form-input
                        id="lastModifiedBy"
                        readonly
                        v-model="formData.updatedBy"
                    />
                </b-form-group>
                <b-form-group
                    label="Date & Time"
                    label-for="updatedDateAndTime"
                >
                    <b-form-input
                        id="updatedDateAndTime"
                        disabled
                        v-model="formData.updatedDateAndTime"
                    />
                </b-form-group>
            </b-col>
            <b-col md="6">
                <b-form-group
                    label="Approved By"
                    label-for="approvedBy"
                >
                    <b-form-input
                        id="approvedBy"
                        readonly
                    />
                </b-form-group>
                <b-form-group
                    label="Date & Time"
                    label-for="approvedDateAndTime"
                >
                    <b-form-input
                        id="approvedDateAndTime"
                        disabled
                    />
                </b-form-group>
                <b-form-group
                    label="Stage"
                    label-for="stage"
                >
                    <v-select
                        id="serialNoWiseStock"
                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                        :options="stageOptions"
                        :reduce="val => val.value"
                        disabled
                        :clearable="false"
                        v-model="formData.stage"
                    />
                </b-form-group>
            </b-col>
        </b-row>
    </div>
</template>
<script>
    import {
        BRow,
        BCol,
        BFormGroup,
        BFormInput,
        BFormCheckbox,
        BForm,
        BButton,
        BTab,
        BTabs,
        BFormTextarea,
        BFormInvalidFeedback,
        BInputGroup,
        BFormDatepicker
    } from 'bootstrap-vue'
    import Ripple from 'vue-ripple-directive'
    import vSelect from 'vue-select'
    import axios from '@axios'
    import { ref } from '@vue/composition-api'
    import router from '@/router'
    import { forMatIndianDateAndTime } from '@core/utils/utils'

    export default {
        components: {
            BRow,
            BCol,
            BFormGroup,
            BFormInput,
            BFormCheckbox,
            BForm,
            BButton,
            BTab,
            BTabs,
            BFormTextarea,
            BFormInvalidFeedback,
            BInputGroup,
            BFormDatepicker,
            vSelect
        },
        directives: {
            Ripple,
        },
        setup() {
            const stageOptions = ref([
                {label: 'Prepared', value: 1},
                {label: 'Approved', value: 2},
                {label: 'Regret', value: 3}
            ])

            const formData = ref({
                createdBy: null,
                createdDateAndTime: null,
                updatedBy: null,
                updatedDateAndTime: null,
                approvedBy: null,
                approvedDateAndTime: null,
                stage: 1,
            })

            axios.get(`/api/item-master/${router.currentRoute.params.id}`).then(res => {
                formData.value.createdBy = res.data.data.created_by.first_name + res.data.data.created_by.last_name
                formData.value.createdDateAndTime = forMatIndianDateAndTime(res.data.data.created_at)
                formData.value.updatedBy = res.data.data.updated_by.first_name + res.data.data.updated_by.last_name
                formData.value.updatedDateAndTime = forMatIndianDateAndTime(res.data.data.updated_at)
            })

            return {
                stageOptions,
                formData
            }
        }
    }
</script>
