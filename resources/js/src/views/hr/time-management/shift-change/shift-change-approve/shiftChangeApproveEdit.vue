<template>
    <div>
        <b-overlay
            :show="showOverlayLoading"
            rounded="sm"
        >
            <b-card-code>
                <validation-observer
                    #default="{ handleSubmit }"
                >
                    <!-- Form -->
                    <b-form
                        @submit.prevent="handleSubmit(saveFormData)"
                    >
                        <b-row>
                            <b-col md="4">
                                <validation-provider
                                    #default="validationContext"
                                    name="Effective Date"
                                    rules="required"
                                >
                                    <b-form-group
                                        :state="getValidationState(validationContext)"
                                    >
                                        <label for="effective_date">Effective Date <span
                                            class="text-danger erp_required_star"
                                        >*</span></label>

                                        <b-input-group>
                                            <cleave
                                                id="effective_date"
                                                v-model="formData.effective_date"
                                                class="form-control"
                                                :raw="false"
                                                :options="dateFormat"
                                                placeholder="DD/MM/YYYY"
                                                show-decade-nav
                                                :state="getValidationState(validationContext)"
                                            />
                                            <b-input-group-append>
                                                <b-form-datepicker
                                                    v-model="formatDates.effective_date"
                                                    button-only
                                                    @input="getEffectiveFormatDate($event)"
                                                    show-decade-nav
                                                    size="sm"
                                                    nav-button-variant="primary"
                                                    :state="getValidationState(validationContext)"
                                                />
                                            </b-input-group-append>
                                        </b-input-group>
                                        <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                            {{ validationContext.errors[0] }}
                                        </b-form-invalid-feedback>
                                    </b-form-group>
                                </validation-provider>
                            </b-col>
                            <b-col md="4">
                                <validation-provider
                                    #default="validationContext"
                                    name="Existing shift"
                                    rules="required"
                                >
                                    <b-form-group
                                        :state="getValidationState(validationContext)"
                                    >
                                        <label for="existing_shift">Existing shift <span
                                            class="text-danger erp_required_star"
                                        >*</span></label>

                                        <v-select
                                            v-model="formData.existing_shift"
                                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                            :options="existingShiftOptions"
                                            :clearable="false"
                                            :reduce="val => val.value"
                                            placeholder="Select Shift"
                                            id="existing_shift"
                                            :state="getValidationState(validationContext)"
                                            disabled
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
                                    name="New shift"
                                    rules="required"
                                >
                                    <b-form-group
                                        :state="getValidationState(validationContext)"
                                    >
                                        <label for="new_shift">New shift <span
                                            class="text-danger erp_required_star"
                                        >*</span></label>

                                        <v-select
                                            v-model="formData.new_shift"
                                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                            :options="newShiftOptions"
                                            :clearable="false"
                                            :reduce="val => val.value"
                                            placeholder="Select Shift"
                                            id="new_shift"
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
                            <b-col md="8">
                                <b-form-group
                                    label="Remarks"
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
                        <!-- Save Button -->
                        <b-col md="12">
                            <b-button
                                variant="primary"
                                class="mr-2 float-right"
                                type="submit"
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
        BButton,
        BInputGroup,
        BInputGroupAppend,
        BFormInvalidFeedback,
        BFormDatepicker,
        BFormTextarea,
        BOverlay
    } from 'bootstrap-vue'
    import BCardCode from "@core/components/b-card-code/BCardCode";
    import {onMounted, onUnmounted, ref} from "@vue/composition-api";
    import formValidation from "@core/comp-functions/forms/form-validation";
    import {ValidationObserver, ValidationProvider} from 'vee-validate'
    import {required} from '@validations'
    import Cleave from 'vue-cleave-component'
    import {forMatIndianDate, getTcTodayDate} from "@core/utils/utils";
    import vSelect from 'vue-select'
    import {useToast} from "vue-toastification/composition";
    import hrmsStoreModule from "../../../hrmsStoreModule";
    import store from '@/store'
    import router from '@/router'
    import axios from '@axios'

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
            BButton,
            BFormInvalidFeedback,
            Cleave,
            BInputGroup,
            BInputGroupAppend,
            BFormDatepicker,
            vSelect,
            BFormTextarea,
            BOverlay
        },
        setup() {
            /* const ITEMADDON_APP_STORE_MODULE_NAME = 'hr-store-module'

             onMounted(() => {
                 if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, hrmsStoreModule)
             });
             onUnmounted(() => {
                 if (store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.unregisterModule(ITEMADDON_APP_STORE_MODULE_NAME)
             });

             const toast = useToast()
 */
            const showOverlayLoading = ref(false)

            const dateFormat = ref({
                date: true,
                delimiter: '/',
                datePattern: ['d', 'm', 'Y'],
            })

            const formatDates = ref({
                effective_date: null,
            })

            const getEffectiveFormatDate = (date) => {
                formData.value.effective_date = forMatIndianDate(date)
            }

            const existingShiftOptions = ref([
                {label: 'OS', value: 1},
                {label: 'V3', value: 2},
            ])

            const newShiftOptions = ref([
                {label: 'OS', value: 1},
                {label: 'V3', value: 2},
            ])

            const blankFormData = {
                effective_date: null,
                existing_shift: 1,
                new_shift: 1,
                remark: null,
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
                console.log(formData.value)
                /*
                await store.dispatch('hr-store-module/addShiftChangeRequest', formData.value).then(res => {
                    if (res.status === 200) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Shift Change Request Update',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: `You have successfully Update Shift Change Request.`,
                            },
                        });
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
                        });
                    }
                    router.push({
                        name: 'edit-shift-change-request',
                        params: {
                            id: res.data.data._id
                        }
                    });
                });
            */

            }

            const {
                refFormObserver,
                getValidationState,
                resetForm
            } = formValidation(resetFormData)

            return {
                refFormObserver,
                getValidationState,
                resetForm,
                resetFormData,
                formData,
                required,
                saveFormData,
                getEffectiveFormatDate,
                dateFormat,
                formatDates,
                existingShiftOptions,
                newShiftOptions,
                showOverlayLoading,
                refetchData
            }
        }
    }
</script>
