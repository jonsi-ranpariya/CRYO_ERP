<template>
    <div>
        <b-form @submit.prevent="saveFormData">
            <b-row>
                <b-col md="6">
                    <b-form-checkbox
                        class="custom-control-primary mt-2"
                        v-model="formData.calculate_co_from_ot"
                    >
                        Calculate CO+ from OT
                    </b-form-checkbox>
                    <br>
                    <b-form-group
                        label="Minimum Daily OT Minutes Eligible for CO+"
                        label-for="minimum_daily_ot_minute_eligible_for_co"
                    >
                        <b-form-input
                            id="minimum_daily_ot_minute_eligible_for_co"
                            v-model="formData.minimum_daily_ot_minute_eligible_for_co"
                        />
                    </b-form-group>
                    <b-row>
                        <b-col md="6">
                            <b-form-group
                                label="For OT minutes ?	"
                                label-for="for_ot_minutes"
                            >
                                <b-form-input
                                    id="for_ot_minutes"
                                    v-model="formData.for_ot_minutes"
                                />
                            </b-form-group>
                        </b-col>
                        <b-col md="6">
                            <b-form-group
                                label="= CO+ Credit Days"
                                label-for="co_credit_days"
                            >
                                <b-form-input
                                    id="co_credit_days"
                                    v-model="formData.co_credit_days"
                                />
                            </b-form-group>
                        </b-col>
                    </b-row>
                    <b-form-checkbox
                        class="custom-control-primary mt-2"
                        v-model="formData.daily_ot_approval_required"
                    >
                        Daily OT Approval Required
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
            BFormGroup,
            BFormInput,
            BButton
        },
        props: {
            coPlusDetails:{
                type:Object,
                required:true
            }
        },
        setup(props){
            /*
          const toast = useToast()
          const ITEMADDON_APP_STORE_MODULE_NAME = 'hr-store-module'
          if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, hrmsStoreModule)
            */
            const formData = computed( () => props.coPlusDetails)
            const saveFormData = async () => {
                console.log(formData.value)
                /*  let submitData = {
                    id: router.currentRoute.params.id,
                    coPlusDetails: formData.value
                }
                await store.dispatch('hr-store-module/updateShiftDefinition', submitData).then(res => {
                    if (res.status === 200) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'CO+ Updated',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: 'You have successfully Updated CO+s.',
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
            return{
                formData,
                saveFormData
            }
        }
    }
</script>
