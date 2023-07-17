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
                                    <b-col md="8">
                                        <validation-provider
                                            #default="validationContext"
                                            name="Calander Name"
                                            rules="required"
                                        >
                                            <b-form-group
                                                :state="getValidationState(validationContext)"
                                            >
                                                <label for="calendar_name">Calander Name <span
                                                    class="text-danger erp_required_star"
                                                >*</span></label>

                                                <v-select
                                                    v-model="formData.calendar_name"
                                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                                    :options="calenderNameOptions"
                                                    :clearable="false"
                                                    :reduce="val => val.value"
                                                    placeholder="Select Name"
                                                    id="calendar_name"
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
                                            name="Year"
                                            rules="required"
                                        >
                                            <b-form-group
                                                :state="getValidationState(validationContext)"
                                            >
                                                <label for="year">Year <span
                                                    class="text-danger erp_required_star"
                                                >*</span></label>

                                                <v-select
                                                    v-model="formData.year"
                                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                                    :options="yearOptions"
                                                    :clearable="false"
                                                    :reduce="val => val.value"
                                                    placeholder="Select Year"
                                                    id="year"
                                                    :state="getValidationState(validationContext)"
                                                />
                                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                                    {{ validationContext.errors[0] }}
                                                </b-form-invalid-feedback>
                                            </b-form-group>
                                        </validation-provider>
                                    </b-col>
                                </b-row>
                                <validation-provider
                                    #default="validationContext"
                                    name="Date"
                                    rules="required"
                                >
                                    <b-form-group
                                        :state="getValidationState(validationContext)"
                                    >
                                        <label for="date">Date <span
                                            class="text-danger erp_required_star"
                                        >*</span></label>

                                        <b-input-group>
                                            <cleave
                                                id="date"
                                                v-model="formData.date"
                                                class="form-control"
                                                :raw="false"
                                                :options="dateFormat"
                                                placeholder="DD/MM/YYYY"
                                                show-decade-nav
                                                :state="getValidationState(validationContext)"
                                            />
                                            <b-input-group-append>
                                                <b-form-datepicker
                                                    v-model="formatDates.date"
                                                    button-only
                                                    @input="getDate($event)"
                                                    show-decade-nav
                                                    size="sm"
                                                    type="date"
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
                            <b-col md="6">
                                <validation-provider
                                    #default="validationContext"
                                    name="Holiday Name"
                                    rules="required"
                                >
                                    <b-form-group
                                        :state="getValidationState(validationContext)"
                                    >
                                        <label for="date">Holiday Name <span
                                            class="text-danger erp_required_star"
                                        >*</span></label>

                                        <b-form-input
                                            id="holiday_name"
                                            v-model="formData.holiday_name"
                                            :state="getValidationState(validationContext)"
                                        />
                                        <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                            {{ validationContext.errors[0] }}
                                        </b-form-invalid-feedback>
                                    </b-form-group>
                                </validation-provider>
                                <validation-provider
                                    #default="validationContext"
                                    name="Holiday Type"
                                    rules=""
                                >
                                    <b-form-group
                                        label="Holiday Type"
                                        label-for="holiday_type"
                                        :state="getValidationState(validationContext)"
                                    >
                                        <v-select
                                            v-model="formData.holiday_type"
                                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                            :options="holidayTypeOptions"
                                            :clearable="false"
                                            :reduce="val => val.value"
                                            placeholder="Select Type"
                                            id="holiday_type"
                                            :state="getValidationState(validationContext)"
                                        />
                                        <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                            {{ validationContext.errors[0] }}
                                        </b-form-invalid-feedback>
                                    </b-form-group>
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
        BRow,
        BCol,
        BFormGroup,
        BForm,
        BFormInvalidFeedback,
        BInputGroup,
        BInputGroupAppend,
        BFormDatepicker,
        BFormInput,
        BButton,
        BOverlay
    } from 'bootstrap-vue'
    import {ValidationProvider, ValidationObserver} from 'vee-validate'
    import BCardCode from "@core/components/b-card-code/BCardCode";
    import {ref,onUnmounted} from '@vue/composition-api'
    import formValidation from "@core/comp-functions/forms/form-validation";
    import vSelect from 'vue-select'
    import {required} from '@validations'
    import moment from "moment";
    import {forMatIndianDate} from "@core/utils/utils";
    import Cleave from 'vue-cleave-component'
    import {useToast} from "vue-toastification/composition";
    import hrmsStoreModule from "../../hrmsStoreModule";
    import router from '@/router'
    import store from '@/store'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'

    export default {
        components: {
            BCardCode,
            ValidationObserver,
            ValidationProvider,
            BRow,
            BCol,
            BFormGroup,
            BForm,
            vSelect,
            BFormInvalidFeedback,
            BInputGroup,
            BInputGroupAppend,
            Cleave,
            BFormDatepicker,
            BFormInput,
            BButton,
            BOverlay
        },
        setup() {
            // const toast = useToast()
            // //using store module
            // const SE_APP_STORE_MODULE_NAME = 'hr-store-module'
            // if (!store.hasModule(SE_APP_STORE_MODULE_NAME)) store.registerModule(SE_APP_STORE_MODULE_NAME, hrmsStoreModule)
            // onUnmounted(() => {
            //     if (store.hasModule(SE_APP_STORE_MODULE_NAME)) store.unregisterModule(SE_APP_STORE_MODULE_NAME)
            // })

            const showOverlayLoading = ref(false)

            const dateFormat = ref({
                date: true,
                delimiter: '/',
                datePattern: ['d', 'm', 'Y'],
            })

            const formatDates = ref({
                date: null,
            })

            const getDate = (date) => {
                formData.value.date = forMatIndianDate(date)
            }

            const holidayTypeOptions = ref([
                {label: 'Mandatory', value: 1},
                {label: 'Optional', value: 2},
            ])

            const calenderNameOptions = ref([
                {label: 'Holiday_Factory', value: 1},
                {label: 'Holiday_Staff', value: 2},
            ])

            let year = {
                currentYear: moment().year(),
                lastYear: moment().subtract(1, 'year').year(),
                secondLastYear: moment().subtract(2, 'year').year(),
            }

            const yearOptions = ref([
                {
                    label: `${year.currentYear}`,
                    value: `${year.currentYear}`
                },
                {
                    label: `${year.lastYear}`,
                    value: `${year.lastYear}`
                },
                {
                    label: `${year.secondLastYear}`,
                    value: `${year.secondLastYear}`
                }
            ])

            const blankFormData = {
                calendar_name:null,
                year:null,
                date:forMatIndianDate(),
                holiday_name:null,
                holiday_type:null,
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
            /* await store.dispatch('hr-store-module/updateHolidayMaster', formData.value)
                   .then(res => {
                       if (res.status === 200) {
                           toast({
                               component: ToastificationContent,
                               position: 'top-right',
                               props: {
                                   title: 'Holiday Master',
                                   icon: 'CheckSquareIcon',
                                   variant: 'success',
                                   text: `You have successfully update Holiday Master.`,
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
                  })*/
            }

            const {
                refFormObserver,
                getValidationState,
                resetForm
            } = formValidation(resetFormData)

            return {
                saveFormData,
                calenderNameOptions,
                refFormObserver,
                getValidationState,
                resetForm,
                resetFormData,
                formData,
                yearOptions,
                required,
                dateFormat,
                formatDates,
                getDate,
                holidayTypeOptions,
                refetchData,
                showOverlayLoading
            }
        }
    }
</script>
