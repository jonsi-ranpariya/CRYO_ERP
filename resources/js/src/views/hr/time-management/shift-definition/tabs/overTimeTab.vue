<template>
    <div>
        <b-form @submit.prevent="saveFormData">
            <b-row>
                <b-col md="7">
                    <b-form-checkbox
                        class="custom-control-primary mt-2"
                        v-model="formData.calculate_over_time"
                    >
                        Calculate OverTime
                    </b-form-checkbox>
                    <br>
                    <b-form-radio-group
                        id="over_time_dayWork"
                        v-model="formData.over_time_dayWork"
                        :options="overTimeDayWorkOptions"
                        v-bind:disabled="!formData.calculate_over_time"
                    />
                    <b-form-checkbox
                        class="custom-control-primary mt-2"
                        v-model="formData.weekly_off_ph_ot"
                        v-bind:disabled="!formData.calculate_over_time"
                    >
                        Weekly Off/PH as OT
                    </b-form-checkbox>
                    <br>
                    <b-row>
                        <b-col md="12">
                            <hr>
                            <h5>Over Time Approval</h5>
                            <hr>
                        </b-col>
                    </b-row>
                    <b-form-checkbox
                        class="custom-control-primary mt-2"
                        v-model="formData.overtime_approval_required"
                        v-bind:disabled="!formData.calculate_over_time"
                    >
                        OverTime Approval Required <br>
                        ( Applicable only when Cut Off Base OT is selected )
                    </b-form-checkbox>
                    <b-form-checkbox
                        class="custom-control-primary mt-2"
                        v-model="formData.in_time_ot_approval"
                        v-bind:disabled="!formData.calculate_over_time"
                    >
                        In Time OT Approval
                    </b-form-checkbox>
                    <b-form-checkbox
                        class="custom-control-primary mt-2"
                        v-model="formData.out_time_ot_approval"
                        v-bind:disabled="!formData.calculate_over_time"
                    >
                        Out Time OT Approval
                    </b-form-checkbox>
                </b-col>
                <b-col md="5">
                    <b-form-radio-group
                        class="mt-2"
                        id="baseOfHourCutOff"
                        v-model="formData.baseOfHourCutOff"
                        :options="basesOptions"
                        v-bind:disabled="!formData.calculate_over_time"
                    />
                    <br>
                    <b-form-group
                        label="Minimum OT Hours Required"
                        label-for="minimum_ot_hours_required"
                    >
                        <b-form-input
                            id="minimum_ot_hours_required"
                            v-model="formData.minimum_ot_hours_required"
                            v-bind:disabled="!formData.calculate_over_time"
                        />
                    </b-form-group>
                    <b-form-group
                        label="Maximum OT Hours Allowed"
                        label-for="maximum_ot_hours_allowed"
                    >
                        <b-form-input
                            id="maximum_ot_hours_allowed"
                            v-model="formData.maximum_ot_hours_allowed"
                            v-bind:disabled="!formData.calculate_over_time"
                        />
                    </b-form-group>
                    <b-form-group
                        label="Minimum In OT Hours Required"
                        label-for="minimum_in_ot_hours_required"
                    >
                        <b-form-input
                            id="minimum_in_ot_hours_required"
                            v-model="formData.minimum_in_ot_hours_required"
                            v-bind:disabled="!formData.calculate_over_time"
                        />
                    </b-form-group>
                    <b-form-group
                        label="Minimum Out OT Hours Required"
                        label-for="maximum_out_ot_hours_allowed"
                    >
                        <b-form-input
                            id="maximum_out_ot_hours_allowed"
                            v-model="formData.maximum_out_ot_hours_allowed"
                            v-bind:disabled="!formData.calculate_over_time"
                        />
                    </b-form-group>
                    <b-form-checkbox
                        class="custom-control-primary mt-2"
                        v-model="formData.include_minimum_ot_hours_in_ot"
                        v-bind:disabled="!formData.calculate_over_time"
                    >
                        Include Minimum OT Hours in OT
                    </b-form-checkbox>
                </b-col>
            </b-row>
            <hr>
            <b-row>
                <b-col md="4">
                    <b-form-group
                        label="Monthly total OT Round Off"
                        label-for="monthly_total_ot_round_off"
                    >
                        <v-select
                            v-model="formData.monthly_total_ot_round_off"
                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                            :options="monthlyTotalRoundOptions"
                            :clearable="false"
                            :reduce="val => val.value"
                            placeholder="Select Type"
                            id="monthly_total_ot_round_off"
                            v-bind:disabled="!formData.calculate_over_time"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="8">
                    <b-form-checkbox
                        class="custom-control-primary mt-2"
                        v-model="formData.incase_working_hrs_less_then_halfDay_hrs"
                    >
                        Consider Working Hrs As OT, Incase Working Hrs ls Less Than Half Day Hrs.
                    </b-form-checkbox>
                    <b-form-checkbox
                        class="custom-control-primary mt-2"
                        v-model="formData.round_off_daily_ot"
                    >
                        Round Off Daily OT (Enter from Slab Settings Tab)
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
        BFormCheckbox,
        BForm,
        BRow,
        BCol,
        BFormRadioGroup,
        BFormGroup,
        BFormInput,
        BButton
    } from 'bootstrap-vue'
    import {computed, ref} from '@vue/composition-api'
    import vSelect from 'vue-select'
    import {useToast} from "vue-toastification/composition";
    import hrmsStoreModule from "../../../hrmsStoreModule";
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import store from '@/store'
    export default {
        components: {
            BFormCheckbox,
            BForm,
            BRow,
            BCol,
            BFormRadioGroup,
            BFormGroup,
            BFormInput,
            vSelect,
            BButton
        },
        props: {
            overTimeDetails: {
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
            const formData = computed(() => props.overTimeDetails)

            const overTimeDayWorkOptions = ref([
                {text: 'All Days', value: 1},
                {text: 'Working Days', value: 2},
                {text: 'Weekly Off and Paid Holiday', value: 3},
            ])
            const basesOptions = ref([
                {text: 'Hourly Base', value: 1},
                {text: 'Cut Off Base', value: 2},
            ])
            const monthlyTotalRoundOptions = ref([
                {label: 'Yes', value: 1},
                {label: 'No', value: 2},
            ])

            const saveFormData = () => {
                console.log(formData.value)
                /*  let submitData = {
                    id: router.currentRoute.params.id,
                    overTimeDetails: formData.value
                }
                await store.dispatch('hr-store-module/updateShiftDefinition', submitData).then(res => {
                    if (res.status === 200) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Over Time Updated',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: 'You have successfully Updated Over Time.',
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
                overTimeDayWorkOptions,
                basesOptions,
                monthlyTotalRoundOptions,
                saveFormData
            }
        }
    }
</script>
