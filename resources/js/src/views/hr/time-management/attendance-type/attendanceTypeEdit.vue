<template>
    <div>
        <b-overlay
            :show="showOverlayLoading"
            rounded="sm"
        >
            <b-card-code>
                <validation-observer #default="{handleSubmit}">
                    <b-form @submit.prevent="handleSubmit(saveFormData)">
                        <b-row>
                            <b-col md="6">
                                <b-row>
                                    <b-col md="6">
                                        <validation-provider
                                            #default="validationContext"
                                            name="DA Type"
                                            rules="required"
                                        >
                                            <b-form-group
                                                :state="getValidationState(validationContext)"
                                            >
                                                <label for="da_type">DA Type <span
                                                    class="text-danger erp_required_star"
                                                >*</span></label>

                                                <v-select
                                                    v-model="formData.da_type"
                                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                                    :options="daTypeOption"
                                                    :clearable="false"
                                                    :reduce="val => val.value"
                                                    placeholder="Select Type"
                                                    id="da_type"
                                                    :state="getValidationState(validationContext)"
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
                                            name="User Type"
                                            rules="required"
                                        >
                                            <b-form-group
                                                :state="getValidationState(validationContext)"
                                            >
                                                <label for="user_type">User Type <span
                                                    class="text-danger erp_required_star"
                                                >*</span></label>

                                                <b-form-input
                                                    id="user_type"
                                                    v-model="formData.user_type"
                                                    :state="getValidationState(validationContext)"
                                                />
                                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                                    {{ validationContext.errors[0] }}
                                                </b-form-invalid-feedback>
                                            </b-form-group>
                                        </validation-provider>
                                    </b-col>
                                </b-row>
                            </b-col>
                            <b-col md="6">
                                <b-row>
                                    <b-col md="3">
                                        <b-form-checkbox
                                            class="custom-control-primary mt-2"
                                            v-model="formData.default"
                                        >
                                            Default
                                        </b-form-checkbox>
                                    </b-col>
                                    <b-col md="9">
                                        <b-form-group
                                            label="Color"
                                            label-for="color"
                                        >
                                            <b-form-input
                                                id="color"
                                                type="color"
                                                placeholder="Select Color"
                                                v-model="formData.color"
                                            />
                                        </b-form-group>
                                    </b-col>
                                </b-row>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="6">
                                <b-form-group
                                    label="Description"
                                    label-for="description"
                                >
                                    <b-form-textarea
                                        id="description"
                                        v-model="formData.description"
                                        rows="2"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Remark"
                                    label-for="remark"
                                >
                                    <b-form-textarea
                                        id="remark"
                                        v-model="formData.remark"
                                        rows="2"
                                    />
                                </b-form-group>
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
        </b-overlay>
    </div>
</template>
<script>
    import {
        BForm,
        BRow,
        BCol,
        BFormGroup,
        BFormInput,
        BFormInvalidFeedback,
        BFormCheckbox,
        BButton,
        BFormTextarea,
        BOverlay
    } from 'bootstrap-vue'
    import BCardCode from "@core/components/b-card-code/BCardCode";
    import {ValidationObserver, ValidationProvider} from 'vee-validate'
    import vSelect from 'vue-select'
    import {ref,onUnmounted} from "@vue/composition-api";
    import formValidation from "@core/comp-functions/forms/form-validation";
    import {required} from '@validations'
    import {useToast} from "vue-toastification/composition";
    import router from '@/router'
    import store from '@/store'
    import hrmsStoreModule from "../../hrmsStoreModule";
    import axios from '@axios'
    import Toastification from '@core/components/toastification/ToastificationContent.vue'
    export default {
        components: {
            BCardCode,
            ValidationObserver,
            ValidationProvider,
            BForm,
            BRow,
            BCol,
            BFormGroup,
            BFormInput,
            vSelect,
            BFormInvalidFeedback,
            BFormCheckbox,
            BButton,
            BFormTextarea,
            BOverlay
        },
        setup(){
            /*  const toast = useToast()
              //using store module
              const SE_APP_STORE_MODULE_NAME = 'hr-store-module'
              if (!store.hasModule(SE_APP_STORE_MODULE_NAME)) store.registerModule(SE_APP_STORE_MODULE_NAME, hrmsStoreModule)
              onUnmounted(() => {
                  if (store.hasModule(SE_APP_STORE_MODULE_NAME)) store.unregisterModule(SE_APP_STORE_MODULE_NAME)
              })*/

            const showOverlayLoading = ref(false)

            const daTypeOption = ref([
                {label:'DP' , value:1},
                {label:'PL' , value:2},
                {label:'SL' , value:3},
                {label:'LWP' , value:4},
            ])

            const blankFormData = {
                da_type:null,
                user_type:null,
                default:null,
                color:null,
                description:null,
                remark:null,
            }

            const formData = ref(JSON.parse(JSON.stringify(blankFormData)))

            const resetFormData = () => {
                formData.value = JSON.parse(JSON.stringify(blankFormData))
            }

            const refetchData = async () => {
                showOverlayLoading.value = true
                /* await axios.get(`/api//${router.currentRoute.params.id}`).then(res => {
                        formData.value = res.data.data
               })*/
                showOverlayLoading.value = false
            }
            refetchData()

            const saveFormData = async () => {
                /*
                    await store.dispatch('hr-store-module/updateAttendanceType', formData.value)
                        .then(res => {
                            if (res.status === 200) {
                                toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: 'Attendance Type update',
                                        icon: 'CheckSquareIcon',
                                        variant: 'success',
                                        text: `You have successfully update Attendance Type.`,
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
                        })
                */
            }
            const {
                refFormObserver,
                getValidationState,
                resetForm
            } = formValidation(resetFormData)

            return{
                refFormObserver,
                getValidationState,
                resetForm,
                resetFormData,
                formData,
                required,
                daTypeOption,
                saveFormData,
                showOverlayLoading,
                refetchData
            }
        }
    }

</script>
