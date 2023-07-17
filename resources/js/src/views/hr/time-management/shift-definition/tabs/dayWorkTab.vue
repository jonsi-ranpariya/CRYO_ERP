<template>
    <div>
        <b-form @submit.prevent="saveFormData">
            <b-row>
                <b-col md="7">
                    <b-form-checkbox
                        class="custom-control-primary mt-2"
                        v-model="formData.day_work_setup_enable_disable"
                    >
                        Day Work Setup Enable /Disable
                    </b-form-checkbox>
                    <br>
                    <b-form-radio-group
                        id="dayWork"
                        v-model="formData.dayWork"
                        :options="dayWorkOptions"
                        v-bind:disabled="!formData.day_work_setup_enable_disable"
                    />
                    <br>
                    <b-row>
                        <b-col md="12">
                            <hr>
                            <h5>Day Work Setup Enable /Disable</h5>
                            <hr>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col md="6">
                            <b-form-group
                                label="Full Day Hours"
                                label-for="full_day_hours"
                            >
                                <b-form-input
                                    id="full_day_hours"
                                    v-model="formData.full_day_hours"
                                    v-bind:disabled="!formData.day_work_setup_enable_disable"
                                />
                            </b-form-group>
                        </b-col>
                        <b-col md="6">
                            <b-form-group
                                label="Half Day Hours"
                                label-for="half_day_hours"
                            >
                                <b-form-input
                                    id="half_day_hours"
                                    v-model="formData.half_day_hours"
                                    v-bind:disabled="!formData.day_work_setup_enable_disable"
                                />
                            </b-form-group>
                        </b-col>
                    </b-row>
                    <hr>
                    <b-row>
                        <b-col md="12">
                            <b-form-group
                                label="Total Minutes Grace for the Month"
                                label-for="total_minutes_grace_for_month"
                            >
                                <b-form-input
                                    id="total_minutes_grace_for_month"
                                    v-model="formData.total_minutes_grace_for_month"
                                    v-bind:disabled="!formData.day_work_setup_enable_disable"
                                />
                            </b-form-group>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col md="12">
                            <b-form-group
                                label="No of times in a Month Grace Minutes can be Utilized	"
                                label-for="no_time_in_month_grace_minute_utilize"
                            >
                                <b-form-input
                                    id="no_time_in_month_grace_minute_utilize"
                                    v-model="formData.no_time_in_month_grace_minute_utilize"
                                    v-bind:disabled="!formData.day_work_setup_enable_disable"
                                />
                            </b-form-group>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col md="12">
                            <b-form-group
                                label="Daily Limit of Grace Minutes	"
                                label-for="daily_limit_grace_minute"
                            >
                                <b-form-input
                                    id="daily_limit_grace_minute"
                                    v-model="formData.daily_limit_grace_minute"
                                    v-bind:disabled="!formData.day_work_setup_enable_disable"
                                />
                            </b-form-group>
                        </b-col>
                    </b-row>
                </b-col>
                <b-col md="5">
                    <b-form-checkbox
                        class="custom-control-primary mt-2"
                        v-model="formData.half_day_late_cutOff_time_fistHalf"
                        v-bind:disabled="!formData.day_work_setup_enable_disable"
                    >
                        Half Day Late Cut off Time (First Half)
                    </b-form-checkbox>
                    <br>
                    <b-row>
                        <b-col md="6">
                            <b-form-group
                                label="IN"
                                label-for="halfDay_cutOff_time_firstHalf_in"
                            >
                                <b-form-input
                                    id="halfDay_cutOff_time_firstHalf_in"
                                    v-model="formData.halfDay_cutOff_time_firstHalf_in"
                                    v-bind:disabled="!formData.day_work_setup_enable_disable"
                                />
                            </b-form-group>
                        </b-col>
                        <b-col md="6">
                            <b-form-group
                                label="OUT"
                                label-for="halfDay_cutOff_time_firstHalf_out"
                            >
                                <b-form-input
                                    id="halfDay_cutOff_time_firstHalf_out"
                                    v-model="formData.halfDay_cutOff_time_firstHalf_out"
                                    v-bind:disabled="!formData.day_work_setup_enable_disable"
                                />
                            </b-form-group>
                        </b-col>
                    </b-row>
                    <b-form-checkbox
                        class="custom-control-primary mt-2"
                        v-model="formData.half_day_late_cutOff_time_secondHalf"
                        v-bind:disabled="!formData.day_work_setup_enable_disable"
                    >
                        Half Day Late Cut off Time (Second Half)
                    </b-form-checkbox>
                    <br>
                    <b-row>
                        <b-col md="6">
                            <b-form-group
                                label="IN"
                                label-for="halfDay_cutOff_time_secondHalf_in"
                            >
                                <b-form-input
                                    id="halfDay_cutOff_time_secondHalf_in"
                                    v-model="formData.halfDay_cutOff_time_secondHalf_in"
                                    v-bind:disabled="!formData.day_work_setup_enable_disable"
                                />
                            </b-form-group>
                        </b-col>
                        <b-col md="6">
                            <b-form-group
                                label="OUT"
                                label-for="halfDay_cutOff_time_secondHalf_out"
                            >
                                <b-form-input
                                    id="halfDay_cutOff_time_secondHalf_out"
                                    v-model="formData.halfDay_cutOff_time_secondHalf_out"
                                    v-bind:disabled="!formData.day_work_setup_enable_disable"
                                />
                            </b-form-group>
                        </b-col>
                    </b-row>
                    <b-form-checkbox
                        class="custom-control-primary mt-2"
                        v-model="formData.dont_add_early_in_min_total_work_hrs"
                        v-bind:disabled="!formData.day_work_setup_enable_disable"
                    >
                        Do Not add early IN minutes in Total Working Hrs
                    </b-form-checkbox>
                    <b-form-checkbox
                        class="custom-control-primary mt-2"
                        v-model="formData.dont_add_early_out_min_total_work_hrs"
                        v-bind:disabled="!formData.day_work_setup_enable_disable"
                    >
                        Do Not add late OUT minutes in Total Working Hrs
                    </b-form-checkbox>
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
        BFormRadioGroup,
        BFormGroup,
        BFormInput,
        BButton
    } from 'bootstrap-vue'
    import {ref, computed} from '@vue/composition-api'
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
            BFormRadioGroup,
            BFormGroup,
            BFormInput,
            BButton
        },
        props: {
            dayWorkDetails: {
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

            const formData = computed(() => props.dayWorkDetails)

            const dayWorkOptions = ref([
                {text: 'All Days', value: 1},
                {text: 'Working Days', value: 2},
                {text: 'Weekly Off and Paid Holiday', value: 3},
            ])

            const saveFormData = async () => {
                /*  let submitData = {
                    id: router.currentRoute.params.id,
                    dayWorkDetails: formData.value
                }
                await store.dispatch('hr-store-module/updateShiftDefinition', submitData).then(res => {
                    if (res.status === 200) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Day Work Updated',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: 'You have successfully Updated Day Work.',
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
                saveFormData,
                dayWorkOptions
            }
        }
    }
</script>
