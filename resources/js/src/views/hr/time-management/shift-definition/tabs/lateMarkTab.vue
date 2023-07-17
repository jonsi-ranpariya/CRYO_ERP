<template>
    <div>
        <b-form @submit.prevent="saveFormData">
            <b-row>
                <b-col md="6">
                    <b-form-checkbox
                        class="custom-control-primary mt-2"
                        v-model="formData.lateMark_setup_enable_disable"
                    >
                        LateMark Setup Enable/ Disable
                    </b-form-checkbox>
                    <b-form-checkbox
                        class="custom-control-primary mt-2"
                        v-model="formData.save_late_minute_lateMark"
                        v-bind:disabled="!formData.lateMark_setup_enable_disable"
                    >
                        Save Late Minutes as Late Mark
                    </b-form-checkbox>
                    <b-form-checkbox
                        class="custom-control-primary mt-2"
                        v-model="formData.lateMark_weeklyOff_paidHoliday"
                        v-bind:disabled="!formData.lateMark_setup_enable_disable"
                    >
                        Calculate LateMarks on Weekly Off and Paid Holiday
                    </b-form-checkbox>
                    <b-form-checkbox
                        class="custom-control-primary mt-2"
                        v-model="formData.abs_lateMark_grace_cross_month"
                        v-bind:disabled="!formData.lateMark_setup_enable_disable"
                    >
                        Mark ABS once Late Mark grace crossed in a month
                    </b-form-checkbox>
                    <b-form-checkbox
                        class="custom-control-primary mt-2"
                        v-model="formData.avoid_lateMark_halfDay_absent"
                        v-bind:disabled="!formData.lateMark_setup_enable_disable"
                    >
                        Avoid LateMark on Half Day Absent
                    </b-form-checkbox>
                </b-col>
                <b-col md="6">
                    <b-row>
                        <b-col md="12">
                            <hr>
                            <h5>Conversion Rate</h5>
                            <hr>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col md="6">
                            <b-form-group
                                label="Grace LateMarks"
                                label-for="grace_latemarks"
                            >
                                <b-form-input
                                    id="grace_latemarks"
                                    v-model="formData.grace_latemark"
                                    v-bind:disabled="!formData.lateMark_setup_enable_disable"
                                />
                            </b-form-group>
                        </b-col>
                        <b-col md="6">
                            <b-form-group
                                label="No of LateMarks"
                                label-for="no_of_latemark"
                            >
                                <b-form-input
                                    id="no_of_latemark"
                                    v-model="formData.no_of_latemark"
                                    v-bind:disabled="!formData.lateMark_setup_enable_disable"
                                />
                            </b-form-group>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col md="6"></b-col>
                        <b-col md="6">
                            <b-form-group
                                label="No. of Day Absent"
                                label-for="no_of_day_absent"
                            >
                                <b-form-input
                                    id="no_of_day_absent"
                                    v-model="formData.no_of_day_absent"
                                    v-bind:disabled="!formData.lateMark_setup_enable_disable"
                                />
                            </b-form-group>
                        </b-col>
                    </b-row>
                </b-col>
            </b-row>
            <b-row>
                <b-col md="6">
                    <b-row>
                        <b-col md="12">
                            <hr>
                            <h5>In Time Grace</h5>
                            <hr>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col md="12">
                            <b-form-group
                                label="Daily Limit of IN Grace Minutes"
                                label-for="daily_limitOf_in_grace_minutes"
                            >
                                <b-form-input
                                    id="daily_limitOf_in_grace_minutes"
                                    v-model="formData.daily_limitOf_in_grace_minutes"
                                    v-bind:disabled="!formData.lateMark_setup_enable_disable"
                                />
                            </b-form-group>

                            <b-form-group
                                label="Total Minutes IN Grace for the Month	"
                                label-for="total_minutes_in_grace_for_month"
                            >
                                <b-form-input
                                    id="total_minutes_in_grace_for_month"
                                    v-model="formData.total_minutes_in_grace_for_month"
                                    v-bind:disabled="!formData.lateMark_setup_enable_disable"
                                />
                            </b-form-group>
                            <b-form-group
                                label="No of times in a month IN Grace Minutes can be Utilized"
                                label-for="no_of_month_in_grace_minute_utilize"
                            >
                                <b-form-input
                                    id="no_of_month_in_grace_minute_utilize"
                                    v-model="formData.no_of_month_in_grace_minute_utilize"
                                    v-bind:disabled="!formData.lateMark_setup_enable_disable"
                                />
                            </b-form-group>
                        </b-col>
                    </b-row>
                </b-col>
                <b-col md="6">
                    <b-row>
                        <b-col md="12">
                            <hr>
                            <h5>Out Time Grace</h5>
                            <hr>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col md="12">
                            <b-form-group
                                label="Daily Limit of OUT Grace Minutes"
                                label-for="daily_limitOf_out_grace_minutes"
                            >
                                <b-form-input
                                    id="daily_limitOf_out_grace_minutes"
                                    v-model="formData.daily_limitOf_out_grace_minutes"
                                    v-bind:disabled="!formData.lateMark_setup_enable_disable"
                                />
                            </b-form-group>

                            <b-form-group
                                label="Total Minutes OUT Grace for the Month"
                                label-for="total_minutes_out_grace_for_month"
                            >
                                <b-form-input
                                    id="total_minutes_out_grace_for_month"
                                    v-model="formData.total_minutes_out_grace_for_month"
                                    v-bind:disabled="!formData.lateMark_setup_enable_disable"
                                />
                            </b-form-group>
                            <b-form-group
                                label="No of times in a month OUT Grace Minutes can be Utilized"
                                label-for="no_of_month_out_grace_minute_utilize"
                            >
                                <b-form-input
                                    id="no_of_month_out_grace_minute_utilize"
                                    v-model="formData.no_of_month_out_grace_minute_utilize"
                                    v-bind:disabled="!formData.lateMark_setup_enable_disable"
                                />
                            </b-form-group>
                        </b-col>
                    </b-row>
                </b-col>
            </b-row>
            <hr>
            <b-col md="12">
                <b-button
                    variant="primary"
                    class="float-right"
                    type="submit"
                >
                    Save
                </b-button>
            </b-col>
        </b-form>
    </div>
</template>
<script>
    import {
        BForm,
        BRow,
        BCol,
        BFormCheckbox,
        BFormGroup,
        BFormInput,
        BButton
    } from 'bootstrap-vue'
    import {computed} from '@vue/composition-api'
    import {useToast} from "vue-toastification/composition";
    import hrmsStoreModule from "../../../hrmsStoreModule";
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import store from '@/store'

    export default {
        components: {
            BForm,
            BRow,
            BCol,
            BFormCheckbox,
            BFormGroup,
            BFormInput,
            BButton
        },
        props: {
            lateMarkDetail: {
                type: Object,
                required: true
            }
        },
        setup(props) {
            /*
               const toast = useToast()
               const ITEMADDON_APP_STORE_MODULE_NAME = 'hr-store-module'
               if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, hrmsStoreModule)
             */

            const formData = computed(() => props.lateMarkDetail)

            const saveFormData = async () => {
                /*  let submitData = {
                    id: router.currentRoute.params.id,
                    lateMarkDetail: formData.value
                }
                await store.dispatch('hr-store-module/updateShiftDefinition', submitData).then(res => {
                    if (res.status === 200) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Late Mark Updated',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: 'You have successfully Updated Late Mark.',
                            },
                        })
                    } else {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Something went wrong',
                                icon: 'AlertCircleIcon',
                                variant: 'danger',
                                text: 'Something went wrong',
                            },
                        })
                    }
                })*/
            }
            return {
                formData,
                saveFormData
            }
        }
    }
</script>
