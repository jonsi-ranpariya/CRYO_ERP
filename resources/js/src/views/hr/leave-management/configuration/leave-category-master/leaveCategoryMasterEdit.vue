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
                        <b-col md="4">
                            <validation-provider
                                #default="validationContext"
                                name="Type"
                                rules="required"
                            >
                                <b-form-group
                                    :state="getValidationState(validationContext)"
                                >
                                    <label for="type">Type <span
                                        class="text-danger erp_required_star"
                                    >*</span></label>

                                    <v-select
                                        placeholder="Select Type"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="typeOptions"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        id="type"
                                        v-model="formData.type"
                                        :state="getValidationState(validationContext)"
                                    />
                                </b-form-group>
                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </validation-provider>
                        </b-col>
                        <b-col md="8">
                            <validation-provider
                                #default="validationContext"
                                name="Leave Category Master"
                                rules="required"
                            >
                                <b-form-group
                                    :state="getValidationState(validationContext)"
                                >
                                    <label for="leave_category_master">Leave Category Master <span
                                        class="text-danger erp_required_star"
                                    >*</span></label>

                                    <b-form-textarea
                                        v-model="formData.leave_category_master"
                                        id="leave_category_master"
                                        rows="2"
                                        :state="getValidationState(validationContext)"
                                    />
                                </b-form-group>
                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </validation-provider>
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
        BFormTextarea,
        BButton,
        BFormInvalidFeedback
    } from 'bootstrap-vue'
    import BCardCode from "@core/components/b-card-code/BCardCode";
    import {ValidationObserver, ValidationProvider} from 'vee-validate'
    import vSelect from 'vue-select'
    import {onUnmounted, ref} from "@vue/composition-api";
    import formValidation from "../../../../../@core/comp-functions/forms/form-validation";
    import {required} from '@validations'
    import {useToast} from "vue-toastification/composition";
    import hrmsStoreModule from "../../../hrmsStoreModule";
    import store from '@/store/index'
    import axios from '@axios'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import Swal from "sweetalert2";
    import router from '@/router'

    export default {
        components: {
            BCardCode,
            ValidationProvider,
            ValidationObserver,
            vSelect,
            BForm,
            BRow,
            BButton,
            BFormTextarea,
            BCol,
            BFormGroup,
            BFormInvalidFeedback
        },
        setup() {
            const toast = useToast()

            const ITEMADDON_APP_STORE_MODULE_NAME = 'hr-store-module'
            if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, hrmsStoreModule)
            onUnmounted(() => {
                if (store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.unregisterModule(ITEMADDON_APP_STORE_MODULE_NAME)
            })

            const showOverlayLoading = ref(false)

            const typeOptions = ref([
                {label: 'Leave', value: 1},
                {label: 'OD', value: 2},
                {label: 'CO+', value: 3},
            ])
            const blankFormData = {
                type: null,
                leave_category_master: null,
            }
            const formData = ref(JSON.parse(JSON.stringify(blankFormData)))

            const resetFormData = () => {
                formData.value = JSON.parse(JSON.stringify(blankFormData))
            }

            const refetchData = async () => {
                showOverlayLoading.value = true
                // await axios.get(`/api/new//${router.currentRoute.params.id}`).then((res) => {
                //     formData.value = res.data.data
                // })
                showOverlayLoading.value = false
            }
            refetchData()

            const saveFormData = async () => {
                console.log(formData.value)
/*
                await store.dispatch('hr-store-module/addLeaveCategoryMaster', formData.value).then(res => {
                    if (res.status === 200) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Leave Category Manager Added',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: `You have successfully Added Leave Category Maanger.`,
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
                resetForm,
                getValidationState
            }
                = formValidation(resetFormData)

            return {
                saveFormData,
                formData,
                refFormObserver,
                resetForm,
                getValidationState,
                resetFormData,
                typeOptions,
                required,
                refetchData
            }
        }
    }
</script>

