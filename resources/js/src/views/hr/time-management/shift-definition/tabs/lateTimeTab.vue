<template>
    <div>
        <b-form @submit.prevent="saveFormData">
            <b-row>
                <b-col md="7">
                    <b-form-checkbox
                        class="custom-control-primary mt-2"
                        v-model="formData.calculate_late_time"
                    >
                        Calculate Late Time
                    </b-form-checkbox>
                    <br>
                    <b-form-radio-group
                        id="late_time_dayWork"
                        v-model="formData.late_time_dayWork"
                        :options="lateTimeDayWorkOptions"
                        v-bind:disabled="!formData.calculate_late_time"
                    />
                </b-col>
                <b-col md="5">
                    <b-form-group
                        label="Late Coming Grace Period	"
                        label-for="late_coming_grace_period"
                        class="mt-2"
                    >
                        <b-form-input
                            id="late_coming_grace_period"
                            v-model="formData.late_coming_grace_periods"
                            v-bind:disabled="!formData.calculate_late_time"
                        />
                    </b-form-group>
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
        BFormGroup,
        BFormInput,
        BFormCheckbox,
        BFormRadioGroup,
        BButton
    } from 'bootstrap-vue'
    import {computed, ref} from '@vue/composition-api'
    import {useToast} from "vue-toastification/composition";
    import hrmsStoreModule from "../../../hrmsStoreModule";
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import store from '@/store'

    export default {
        components: {
            BForm,
            BRow,
            BCol,
            BFormGroup,
            BFormInput,
            BFormCheckbox,
            BFormRadioGroup,
            BButton
        },
        props: {
            lateTimeDetails: {
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
            const formData = computed(() => props.lateTimeDetails)

            const lateTimeDayWorkOptions = ref([
                {text: 'All Days', value: 1},
                {text: 'Working Days', value: 2},
                {text: 'Weekly Off and Paid Holiday', value: 3},
            ])
            const saveFormData = async () => {
                console.log(formData.value)
                /*  let submitData = {
                    id: router.currentRoute.params.id,
                    lateTimeDetails: formData.value
                }
                await store.dispatch('hr-store-module/updateShiftDefinition', submitData).then(res => {
                    if (res.status === 200) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'late time Updated',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: 'You have successfully Updated late time.',
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
                lateTimeDayWorkOptions,
                formData,
                saveFormData
            }
        }
    }
</script>
