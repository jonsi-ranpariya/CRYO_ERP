<template>
    <div>
        <b-card-code>
            <validation-observer #default="{handleSubmit}">
                <b-form @submit.prevent="handleSubmit(saveFormData)">
                    <b-row>
                        <b-col md="12">
                            <b-alert
                                variant="danger"
                                show
                            >
                                <h4 class="alert-heading">
                                    Note:
                                </h4>
                                <div class="alert-body">
                                    <span>The CutOff Time is the day start and Day end time. ie. any In time punched before that time will considered for previous day and any out Time punched after that time will considered for next day.</span><br><br>
                                    <span>Eg. Today is 5th Aug 2019 and if shiift timing are from 9:30 to 18:30 and cut-off id 5:00 then all punch between 5-aug-2019 5:00 will be accounted in 5th Aug 2019.</span><br><br>
                                </div>
                            </b-alert>
                            <hr>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col md="4">
                            <b-form-group>
                                <validation-provider
                                    #default="validationContext"
                                    name="Shift Code"
                                    rules="required"
                                >
                                    <label for="shift_code">Shift Code <span
                                        class="text-danger erp_required_star"
                                    >*</span></label>

                                    <b-form-input
                                        placeholder="Enter Code"
                                        v-model="formData.shift_code"
                                        :state="getValidationState(validationContext)"
                                        id="shift_code"
                                    />
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </validation-provider>
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <validation-provider
                                #default="validationContext"
                                name="Shift Type"
                                rules="required"
                            >
                                <b-form-group
                                    :state="getValidationState(validationContext)"
                                >
                                    <label for="shift_type">Shift Type <span
                                        class="text-danger erp_required_star"
                                    >*</span></label>

                                    <v-select
                                        v-model="formData.shift_type"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="shiftTypeOptions"
                                        :clearable="false"
                                        :reduce="val => val.value"
                                        placeholder="Select Type"
                                        id="shift_type"
                                        :state="getValidationState(validationContext)"
                                    />
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                        </b-col>
                        <b-col md="4">
                            <validation-provider
                                #default="validationContext"
                                name="Total Working Hours"
                                rules=""
                            >
                                <b-form-group
                                    label="Total Working Hours"
                                    label-for="total_Working_hours"
                                    :state="getValidationState(validationContext)"
                                >
                                    <b-form-timepicker
                                        id="total_Working_hours"
                                        locale="en"
                                        v-model="formData.total_Working_hours"
                                        :state="getValidationState(validationContext)"
                                        readonly
                                    />
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col md="4">
                            <validation-provider
                                #default="validationContext"
                                name="Reporting Time"
                                rules=""
                            >
                                <b-form-group
                                    label="Reporting Time"
                                    label-for="reporting_time"
                                    :state="getValidationState(validationContext)"
                                >
                                    <b-form-timepicker
                                        id="reporting_time"
                                        locale="en"
                                        v-model="formData.reporting_time"
                                        :state="getValidationState(validationContext)"
                                    />
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                        </b-col>
                        <b-col md="4">
                            <validation-provider
                                #default="validationContext"
                                name="Leaving Time"
                                rules=""
                            >
                                <b-form-group
                                    label="Leaving Time"
                                    label-for="leaving_time"
                                    :state="getValidationState(validationContext)"
                                >
                                    <b-form-timepicker
                                        id="leaving_time"
                                        locale="en"
                                        v-model="formData.leaving_time"
                                        :state="getValidationState(validationContext)"
                                    />
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                        </b-col>
                        <b-col md="4">
                            <validation-provider
                                #default="validationContext"
                                name="Half Day Hours"
                                rules=""
                            >
                                <b-form-group
                                    label="Half Day Hours"
                                    label-for="half_day_hours"
                                    :state="getValidationState(validationContext)"
                                >
                                    <b-form-timepicker
                                        id="half_day_hours"
                                        locale="en"
                                        v-model="formData.half_day_hours"
                                        :state="getValidationState(validationContext)"
                                        readonly
                                    />
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col md="4">
                            <validation-provider
                                #default="validationContext"
                                name="Cutoff Time"
                                rules=""
                            >
                                <b-form-group
                                    label="Cutoff Time"
                                    label-for="cutoff_time"
                                    :state="getValidationState(validationContext)"
                                >
                                    <b-form-timepicker
                                        id="cutoff_time"
                                        locale="en"
                                        v-model="formData.cutoff_time"
                                        :state="getValidationState(validationContext)"
                                    />
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                        </b-col>
                        <b-col md="4">
                            <b-form-checkbox
                                class="custom-control-primary mt-2"
                                v-model="formData.shift_weekly_off"
                            >
                                This Shift Is Weekly Off
                            </b-form-checkbox>
                        </b-col>
                        <b-col md="4">
                            <validation-provider
                                #default="validationContext"
                                name="Lunch Break (Min)"
                                rules=""
                            >
                                <b-form-group
                                    label="Lunch Break (Min)"
                                    label-for="lunch_break_minute"
                                    :state="getValidationState(validationContext)"
                                >
                                    <b-form-input
                                        id="lunch_break_minute"
                                        v-model="formData.lunch_break_minute"
                                        :state="getValidationState(validationContext)"
                                    />
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col md="4">
                            <validation-provider
                                #default="validationContext"
                                name="Tea Break (Min)"
                                rules=""
                            >
                                <b-form-group
                                    label="Tea Break (Min)"
                                    label-for="tea_break_minute"
                                    :state="getValidationState(validationContext)"
                                >
                                    <b-form-input
                                        id="tea_break_minute"
                                        v-model="formData.tea_break_minute"
                                        :state="getValidationState(validationContext)"
                                    />
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                        </b-col>
                        <b-col md="4">
                            <validation-provider
                                #default="validationContext"
                                name="Dinner Break (Min)"
                                rules=""
                            >
                                <b-form-group
                                    label="Dinner Break (Min)"
                                    label-for="dinner_break_minute"
                                    :state="getValidationState(validationContext)"
                                >
                                    <b-form-input
                                        id="dinner_break_minute"
                                        v-model="formData.dinner_break_minute"
                                        :state="getValidationState(validationContext)"
                                    />
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                        </b-col>
                        <b-col md="4">
                            <validation-provider
                                #default="validationContext"
                                name="Roll Over Timing (Min)"
                                rules=""
                            >
                                <b-form-group
                                    label="Roll Over Timing (Min)"
                                    label-for="roll_over_timing_minute"
                                    :state="getValidationState(validationContext)"
                                >
                                    <b-form-input
                                        id="roll_over_timing_minute"
                                        v-model="formData.roll_over_timing_minute"
                                        :state="getValidationState(validationContext)"
                                    />
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col md="6">
                            <validation-provider
                                #default="validationContext"
                                name="Email Address"
                                rules="email"
                            >
                                <b-form-group
                                    label="Email Address"
                                    label-for="email_address"
                                    :state="getValidationState(validationContext)"
                                >
                                    <b-form-input
                                        id="email_address"
                                        placeholder="Email"
                                        v-model="formData.email_address"
                                    />
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                        </b-col>
                        <b-col md="6">
                            <validation-provider
                                #default="validationContext"
                                name="Remark"
                                rules=""
                            >
                                <b-form-group
                                    label="Remark"
                                    label-for="remark"
                                    :state="getValidationState(validationContext)"
                                >
                                    <b-form-textarea
                                        id="remark"
                                        placeholder="remark"
                                        v-model="formData.remark"
                                        rows="2"
                                        :state="getValidationState(validationContext)"
                                    />
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col md="12">
                            <b-form-checkbox
                                class="custom-control-primary mt-2"
                                v-model="formData.shift_hours_in_out_punch"
                            >
                               Consider This Shift For Hour Based Working And Add In/Out Punches Through Utility As Per  Shift CutOff Time.
                            </b-form-checkbox>
                        </b-col>
                    </b-row>
                    <hr>
                    <b-col md="12">
                        <b-button
                            type="submit"
                            variant="primary"
                            class="float-right"
                        >
                            Save
                        </b-button>
                    </b-col>
                </b-form>
            </validation-observer>
        </b-card-code>
    </div>
</template>
<script>
    import {
        BForm,
        BRow,
        BCol,
        BAlert,
        BFormGroup,
        BFormInput,
        BFormInvalidFeedback,
        BFormTimepicker,
        BFormCheckbox,
        BFormTextarea,
        BButton
    } from 'bootstrap-vue'
    import BCardCode from "@core/components/b-card-code/BCardCode";
    import {ValidationObserver, ValidationProvider} from 'vee-validate'
    import vSelect from 'vue-select'
    import {ref, onUnmounted} from '@vue/composition-api'
    import formValidation from "@core/comp-functions/forms/form-validation";
    import {required} from '@validations'
    import {useToast} from "vue-toastification/composition";
    import router from '@/router'
    import store from '@/store'
    import hrmsStoreModule from "../../hrmsStoreModule";
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'

    export default {
        components: {
            BCardCode,
            BForm,
            BRow,
            BCol,
            ValidationObserver,
            ValidationProvider,
            BAlert,
            vSelect,
            BFormInput,
            BFormGroup,
            BFormInvalidFeedback,
            BFormTimepicker,
            BFormCheckbox,
            BFormTextarea,
            BButton
        },
        setup() {
          /*  const toast = useToast()
            //using store module
            const SE_APP_STORE_MODULE_NAME = 'hr-store-module'
            if (!store.hasModule(SE_APP_STORE_MODULE_NAME)) store.registerModule(SE_APP_STORE_MODULE_NAME, hrmsStoreModule)
            onUnmounted(() => {
                if (store.hasModule(SE_APP_STORE_MODULE_NAME)) store.unregisterModule(SE_APP_STORE_MODULE_NAME)
            })*/

            const shiftTypeOptions = ref([
                {
                    label: 'Day',
                    value: 1
                },
                {
                    label: 'Night',
                    value: 2
                },
            ])

            const blankFormData = {
                shift_code: null,
                shift_type: null,
                total_Working_hours: null,
                reporting_time: null,
                leaving_time: null,
                half_day_hours: null,
                cutoff_time: null,
                shift_weekly_off: null,
                lunch_break_minute: null,
                tea_break_minute: null,
                dinner_break_minute: null,
                roll_over_timing_minute: null,
                email_address: null,
                remark: null,
                shift_hours_in_out_punch:null,
                generalSettingDetail:{
                    reduce_lunch_min_from_work_hrs: null,
                    convert_day_type_weekly_of_paid: null,
                    convert_day_type_holiday_paid: null,
                    available_auto_shift: null,
                    half_day_leave_application_shift: null,
                    available_shift_change_request: null,
                    swipe_day_of_full_day_leave: null,
                    calculate_compensation: null,
                    outside_duty: null,
                    privilege_leave: null,
                    casual_leave: null,
                    sick_leave: null,
                    ordinary_leave: null,
                    co_leave: null,
                    leave_without_pay: null,
                    leave_l1: null,
                    leave_l2: null,
                    leave_l3: null,
                    leave_l4: null,
                    leave_l5: null,
                },
                lateMarkDetail:{
                    lateMark_setup_enable_disable:null,
                    save_late_minute_lateMark:null,
                    lateMark_weeklyOff_paidHoliday:null,
                    abs_lateMark_grace_cross_month:null,
                    avoid_lateMark_halfDay_absent:null,
                    grace_latemark:null,
                    no_of_latemark:null,
                    no_of_day_absent:null,
                    daily_limitOf_in_grace_minutes:null,
                    total_minutes_in_grace_for_month:null,
                    no_of_month_in_grace_minute_utilize:null,
                    daily_limitOf_out_grace_minutes:null,
                    total_minutes_out_grace_for_month:null,
                    no_of_month_out_grace_minute_utilize:null,
                },
                dayWorkDetails:{
                    day_work_setup_enable_disable:null,
                    dayWork:1,
                    full_day_hours:null,
                    half_day_hours:null,
                    total_minutes_grace_for_month:null,
                    no_time_in_month_grace_minute_utilize:null,
                    daily_limit_grace_minute:null,
                    half_day_late_cutOff_time_fistHalf:null,
                    halfDay_cutOff_time_firstHalf_in:null,
                    halfDay_cutOff_time_firstHalf_out:null,
                    half_day_late_cutOff_time_secondHalf:null,
                    halfDay_cutOff_time_secondHalf_in:null,
                    halfDay_cutOff_time_secondHalf_out:null,
                    dont_add_early_in_min_total_work_hrs:null,
                    dont_add_early_out_min_total_work_hrs:null,
                },
                overTimeDetails:{
                    calculate_over_time:null,
                    over_time_dayWork:null,
                    weekly_off_ph_ot:null,
                    overtime_approval_required:null,
                    in_time_ot_approval:null,
                    out_time_ot_approval:null,
                    baseOfHourCutOff:null,
                    minimum_ot_hours_required:null,
                    maximum_ot_hours_allowed:null,
                    minimum_in_ot_hours_required:null,
                    maximum_out_ot_hours_allowed:null,
                    include_minimum_ot_hours_in_ot:null,
                    monthly_total_ot_round_off:null,
                    incase_working_hrs_less_then_halfDay_hrs:null,
                    round_off_daily_ot:null,
                },
                lateTimeDetails:{
                    calculate_late_time:null,
                    lateTimeDayWorkOptions:null,
                    late_coming_grace_periods:null,
                },
                coPlusDetails:{
                    calculate_co_from_ot:null,
                    minimum_daily_ot_minute_eligible_for_co:null,
                    for_ot_minutes:null,
                    co_credit_days:null,
                    daily_ot_approval_required:null,
                },
                filterDetails:{
                    group:null,
                    grade:null,
                    branch:null,
                    department:null,
                    division:null,
                    unit:null,
                    category:null,
                    designation:null,
                }
            }
            const formData = ref(JSON.parse(JSON.stringify(blankFormData)))

            const resetFormData = () => {
                formData.value = JSON.parse(JSON.stringify(blankFormData))
            }

            const saveFormData = async () => {
                console.log(formData.value)
                router.push({name: 'edit-shift-definition'})
/*
                await store.dispatch('hr-store-module/addShiftDefinition', formData.value)
                    .then(res => {
                        if (res.status === 200) {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Shift Definition Added',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: `You have successfully Added Shift Definition.`,
                                },
                            })
                        } else {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Error',
                                    icon: 'AlertCircleIcon',
                                    variant: 'danger',
                                    text: 'Something went wrong!',
                                },
                            })
                        }
                        router.push({
                            name: 'edit-shift-definition',
                            params: {
                                id: res.data.data._id
                            }
                        })
                    })
*/
            }

            const {
                refFormObserver,
                getValidationState,
                resetForm
            } = formValidation(resetFormData)

            return {
                formData,
                refFormObserver,
                getValidationState,
                resetForm,
                resetFormData,
                shiftTypeOptions,
                required,
                saveFormData
            }
        }
    }
</script>
