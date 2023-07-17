<template>
    <div>
        <b-row>
            <b-col md="12">
                <hr>
                <h5>General Setting</h5>
                <hr>
            </b-col>
        </b-row>
        <b-form @submit.prevent="saveFormData">
            <b-row>
                <b-col md="6">
                    <b-form-checkbox
                        class="custom-control-primary mt-2"
                        v-model="formData.reduce_lunch_min_from_work_hrs"
                    >
                        Reduce Lunch min. from Total Working Hrs
                    </b-form-checkbox>

                    <b-form-checkbox
                        class="custom-control-primary mt-2"
                        v-model="formData.convert_day_type_weekly_of_paid"
                    >
                        Auto Convert Day type Weekly of Paid [ WOP ] to CO+
                    </b-form-checkbox>
                    <b-form-checkbox
                        class="custom-control-primary mt-2"
                        v-model="formData.convert_day_type_holiday_paid"
                    >
                        Auto Convert Day type Paid Holiday Paid [ PHP ] to CO+
                    </b-form-checkbox>
                </b-col>
                <b-col md="6">
                    <b-form-checkbox
                        class="custom-control-primary mt-2"
                        v-model="formData.available_auto_shift"
                    >
                        Available For Auto Shift
                    </b-form-checkbox>
                    <b-form-checkbox
                        class="custom-control-primary mt-2"
                        v-model="formData.half_day_leave_application_shift"
                    >
                        Do not allow half day leave application for this shift
                    </b-form-checkbox>
                    <b-form-checkbox
                        class="custom-control-primary mt-2"
                        v-model="formData.available_shift_change_request"
                    >
                        Available for Shift change request
                    </b-form-checkbox>
                </b-col>
            </b-row>
            <b-row>
                <b-col md="12">
                    <b-form-checkbox
                        class="custom-control-primary mt-2"
                        v-model="formData.swipe_day_of_full_day_leave"
                    >
                        Mark Swipe as 'X' on Day of Full day Leave/OD Application
                    </b-form-checkbox>
                </b-col>
            </b-row>
            <b-row>
                <b-col md="12">
                    <b-form-checkbox
                        class="custom-control-primary mt-2"
                        v-model="formData.calculate_compensation"
                    >
                        Calculate Compensation (Enter Compensation Calculation from Slab Settings Tab)
                    </b-form-checkbox>
                </b-col>
            </b-row>
            <br>
            <b-row>
                <b-col md="12">
                    <hr>
                    <h5>Do not Mark Swipe as 'X' for following Type(s) on Day of Full day Leave/OD Application</h5>
                    <hr>
                </b-col>
            </b-row>
            <b-row>
                <b-col md="12">
                    <div class="demo-inline-spacing">
                        <b-form-checkbox
                            v-model="formData.outside_duty"
                            name="grand"
                        >
                            OD
                        </b-form-checkbox>
                        <b-form-checkbox
                            v-model="formData.privilege_leave"
                            name="grand"
                        >
                            PL
                        </b-form-checkbox>
                        <b-form-checkbox
                            v-model="formData.casual_leave"
                            name="branch"
                        >
                            CL
                        </b-form-checkbox>
                        <b-form-checkbox
                            v-model="formData.sick_leave"
                            name="department"
                        >
                            SL
                        </b-form-checkbox>
                        <b-form-checkbox
                            v-model="formData.ordinary_leave"
                            name="division"
                        >
                            OL
                        </b-form-checkbox>
                        <b-form-checkbox
                            v-model="formData.co_leave"
                            name="unit"
                        >
                            CO-
                        </b-form-checkbox>
                        <b-form-checkbox
                            v-model="formData.leave_without_pay"
                            name="unit"
                        >
                            LWP
                        </b-form-checkbox>
                        <b-form-checkbox
                            v-model="formData.leave_l1"
                            name="category"
                        >
                            L1
                        </b-form-checkbox>
                        <b-form-checkbox
                            v-model="formData.leave_l2"
                            name="group"
                        >
                            L2
                        </b-form-checkbox>
                        <b-form-checkbox
                            v-model="formData.leave_l3"
                            name="group"
                        >
                            L3
                        </b-form-checkbox>
                        <b-form-checkbox
                            v-model="formData.leave_l4"
                            name="designation"
                        >
                            L4
                        </b-form-checkbox>
                        <b-form-checkbox
                            v-model="formData.leave_l5"
                            name="designation"
                        >
                            L5
                        </b-form-checkbox>
                    </div>
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
        BRow,
        BCol,
        BFormCheckbox,
        BButton,
        BForm
    } from 'bootstrap-vue'
    import {computed} from '@vue/composition-api'
    import {useToast} from "vue-toastification/composition";
    import hrmsStoreModule from "../../../hrmsStoreModule";
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import store from '@/store'

    export default {
        components: {
            BRow,
            BCol,
            BFormCheckbox,
            BButton,
            BForm
        },
        props: {
            generalSettingDetail: {
                type: Object,
                required: true,
            }
        },
        setup(props) {
/*
            const toast = useToast()
            const ITEMADDON_APP_STORE_MODULE_NAME = 'hr-store-module'
            if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, hrmsStoreModule)
*/

            const formData = computed(() => props.generalSettingDetail)

            const saveFormData = async () => {
 /*                 let submitData = {
                    id: router.currentRoute.params.id,
                    generalSettingDetail: formData.value
                }
                await store.dispatch('hr-store-module/updateShiftDefinition', submitData).then(res => {
                    if (res.status === 200) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'General Setting Updated',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: 'You have successfully Updated General Setting.',
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
