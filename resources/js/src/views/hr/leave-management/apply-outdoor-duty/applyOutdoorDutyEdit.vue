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
                        <b-col md="12">
                            <b-alert
                                variant="danger"
                                show
                            >
                                <h4 class="alert-heading">
                                    Note:
                                </h4>
                                <div class="alert-body">
                                    <span>Do Not Enter Future Outdoor Duty.</span><br><br>
                                </div>
                            </b-alert>
                            <hr>
                        </b-col>
                        <b-col md="5">
                            <validation-provider
                                #default="validationContext"
                                name="Application Date"
                                rules=""
                            >
                                <b-form-group
                                    label="Application Date"
                                    label-for="application_date"
                                    :state="getValidationState(validationContext)"
                                >
                                    <b-input-group>
                                        <cleave
                                            id="application_date"
                                            v-model="formData.application_date"
                                            class="form-control"
                                            :raw="false"
                                            :options="dateFormat"
                                            placeholder="DD/MM/YYYY"
                                            show-decade-nav
                                            :state="getValidationState(validationContext)"
                                            disabled
                                        />
                                        <b-input-group-append>
                                            <b-form-datepicker
                                                v-model="formatDates.application_date"
                                                button-only
                                                @input="getApplicationFormatDate($event)"
                                                show-decade-nav
                                                size="sm"
                                                nav-button-variant="primary"
                                                :state="getValidationState(validationContext)"
                                                disabled
                                            />
                                        </b-input-group-append>
                                    </b-input-group>
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                        </b-col>
                        <b-col md="7"></b-col>
                    </b-row>
                    <b-row>
                        <b-col md="5">
                            <b-form-group>
                                <validation-provider
                                    #default="validationContext"
                                    name="From Date"
                                    rules="required"
                                >
                                    <label for="from_date">From Date <span
                                        class="text-danger erp_required_star"
                                    >*</span></label>

                                    <b-input-group>
                                        <cleave
                                            id="from_date"
                                            v-model="formData.from_date"
                                            class="form-control"
                                            :raw="false"
                                            :options="dateFormat"
                                            placeholder="DD/MM/YYYY"
                                            show-decade-nav
                                            :state="getValidationState(validationContext)"
                                            @input="calculateDays"
                                        />
                                        <b-input-group-append>
                                            <b-form-datepicker
                                                v-model="formatDates.from_date"
                                                button-only
                                                @input="getFromFormatDate($event)"
                                                show-decade-nav
                                                size="sm"
                                                nav-button-variant="primary"
                                                :state="getValidationState(validationContext)"
                                                :max="new Date()"
                                            />
                                        </b-input-group-append>
                                    </b-input-group>
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </validation-provider>
                            </b-form-group>
                        </b-col>
                        <b-col md="7">
                            <b-row>
                                <b-col md="6">
                                    <validation-provider
                                        #default="validationContext"
                                        name="Start Day"
                                        rules=""
                                    >
                                        <b-form-group
                                            label="Start Day"
                                            label-for="start_day"
                                            :state="getValidationState(validationContext)"
                                        >
                                            <v-select
                                                v-model="formData.start_day"
                                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                                :options="startDayOptions"
                                                :clearable="false"
                                                :reduce="val => val.value"
                                                input-id="leave_type"
                                                :state="getValidationState(validationContext)"
                                                @input="selectDay($event)"
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
                                        name="For ? Half"
                                        rules=""
                                    >
                                        <b-form-group
                                            label="For ? Half"
                                            label-for="for_half"
                                            :state="getValidationState(validationContext)"
                                        >
                                            <v-select
                                                v-model="formData.for_half"
                                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                                :options="forHalfOptions"
                                                :clearable="false"
                                                input-id="leave_type"
                                                :reduce="val => val.value"
                                                :state="getValidationState(validationContext)"
                                                :disabled="isTypeDisable"
                                            />
                                            <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                                {{ validationContext.errors[0] }}
                                            </b-form-invalid-feedback>
                                        </b-form-group>
                                    </validation-provider>
                                </b-col>
                            </b-row>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col md="5">
                            <b-form-group>
                                <validation-provider
                                    #default="validationContext"
                                    name="To Date"
                                    rules="required"
                                >
                                    <label for="to_date">To Date <span
                                        class="text-danger erp_required_star"
                                    >*</span></label>

                                    <b-input-group>
                                        <cleave
                                            id="to_date"
                                            v-model="formData.to_date"
                                            class="form-control"
                                            :raw="false"
                                            :options="dateFormat"
                                            placeholder="DD/MM/YYYY"
                                            show-decade-nav
                                            :state="getValidationState(validationContext)"
                                            @input="calculateDays($event)"
                                        />
                                        <b-input-group-append>
                                            <b-form-datepicker
                                                v-model="formatDates.to_date"
                                                button-only
                                                @input="getToFormatDate($event)"
                                                show-decade-nav
                                                size="sm"
                                                nav-button-variant="primary"
                                                :state="getValidationState(validationContext)"
                                                :max="new Date()"
                                            />
                                        </b-input-group-append>
                                    </b-input-group>
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </validation-provider>
                            </b-form-group>
                        </b-col>
                        <b-col md="7">
                            <b-row>
                                <b-col md="6">
                                    <validation-provider
                                        #default="validationContext"
                                        name="Last Day"
                                        rules=""
                                    >
                                        <b-form-group
                                            label="Last Day"
                                            label-for="last_day"
                                            :state="getValidationState(validationContext)"
                                        >
                                            <v-select
                                                v-model="formData.last_day"
                                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                                :options="lastDayOptions"
                                                :reduce="val => val.value"
                                                :clearable="false"
                                                input-id="last_day"
                                                :state="getValidationState(validationContext)"
                                                :disabled="isDayLastDisable"
                                                @input="selectLastDay($event)"
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
                                        name="For ? Half"
                                        rules=""
                                    >
                                        <b-form-group
                                            label="For ? Half"
                                            label-for="last_day_for_half"
                                            :state="getValidationState(validationContext)"
                                        >
                                            <v-select
                                                v-model="formData.last_day_for_half"
                                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                                :options="lastDayForHalfOptions"
                                                :clearable="false"
                                                :reduce="val => val.value"
                                                input-id="leave_type"
                                                :state="getValidationState(validationContext)"
                                                :disabled="isSelectTypeDisable"
                                            />
                                            <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                                {{ validationContext.errors[0] }}
                                            </b-form-invalid-feedback>
                                        </b-form-group>
                                    </validation-provider>
                                </b-col>
                            </b-row>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col md="2">
                            <validation-provider
                                #default="validationContext"
                                name="Total Days"
                                rules=""
                            >
                                <b-form-group
                                    label="Total Days"
                                    label-for="total_days"
                                    :state="getValidationState(validationContext)"
                                >
                                    <b-form-input
                                        id="total_days"
                                        placeholder="Total Days"
                                        v-model="formData.total_days"
                                        :state="getValidationState(validationContext)"
                                        readonly
                                    />
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                        </b-col>
                        <b-col md="5">
                            <validation-provider
                                #default="validationContext"
                                name="Remarks"
                                rules=""
                            >
                                <b-form-group
                                    label="Remarks"
                                    label-for="remarks"
                                    :state="getValidationState(validationContext)"
                                >
                                    <b-form-textarea
                                        id="remarks"
                                        placeholder="Remarks"
                                        v-model="formData.remarks"
                                        rows="2"
                                        :state="getValidationState(validationContext)"
                                    />
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                        </b-col>
                        <b-col md="5">
                            <b-form-group>
                                <validation-provider
                                    #default="validationContext"
                                    name="Reason"
                                    rules="required"
                                >
                                    <label for="reason">Reason <span
                                        class="text-danger erp_required_star"
                                    >*</span></label>

                                    <b-form-textarea
                                        id="reason"
                                        placeholder="Reason"
                                        v-model="formData.reason"
                                        rows="2"
                                        :state="getValidationState(validationContext)"
                                    />
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </validation-provider>
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
        BInputGroup,
        BInputGroupAppend,
        BFormGroup,
        BFormDatepicker,
        BFormInvalidFeedback,
        BFormTextarea,
        BFormInput,
        BButton,
        BOverlay,
        BAlert
    } from 'bootstrap-vue'
    import BCardCode from "@core/components/b-card-code/BCardCode";
    import {ValidationObserver, ValidationProvider} from 'vee-validate'
    import {required} from '@validations'
    import {ref, onUnmounted} from "@vue/composition-api";
    import {forMatIndianDate,getTcTodayDate} from "@core/utils/utils";
    import formValidation from "@core/comp-functions/forms/form-validation";
    import Cleave from 'vue-cleave-component'
    import vSelect from 'vue-select'
    import moment from "moment";
    import axios from '@axios'
    import router from '@/router'
    import store from '@/store'
    import {useToast} from "vue-toastification/composition";
    import Toastification from '@core/components/toastification/ToastificationContent.vue'
    import hrmsStoreModule from "../../hrmsStoreModule";

    export default {
        components: {
            BCardCode,
            BForm,
            BRow,
            BCol,
            ValidationObserver,
            ValidationProvider,
            BInputGroup,
            BInputGroupAppend,
            BFormGroup,
            BFormDatepicker,
            Cleave,
            BFormInvalidFeedback,
            vSelect,
            BFormTextarea,
            BFormInput,
            BButton,
            BOverlay,
            BAlert
        },
        setup() {
            // const toast = useToast()
            // //using store module
            // const SE_APP_STORE_MODULE_NAME = 'hr-store-module'
            // if (!store.hasModule(SE_APP_STORE_MODULE_NAME)) store.registerModule(SE_APP_STORE_MODULE_NAME, hrmsStoreModule)
            // onUnmounted(() => {
            //     if (store.hasModule(SE_APP_STORE_MODULE_NAME)) store.unregisterModule(SE_APP_STORE_MODULE_NAME)
            // })
            const isTypeDisable = ref(false)
            const isSelectTypeDisable = ref(false)
            const isDayLastDisable = ref(false)

            const showOverlayLoading = ref(false)

            const startDayOptions = ref([
                {
                    label: 'Full',
                    value: 1
                },
                {
                    label: 'Half',
                    value: 2
                },
            ])

            const lastDayOptions = ref([
                {
                    label: 'Full',
                    value: 1
                },
                {
                    label: 'Half',
                    value: 2
                },
            ])

            const forHalfOptions = ref([
                {
                    label: 'First',
                    value: 1
                },
                {
                    label: 'Second',
                    value: 2
                },
            ])

            const lastDayForHalfOptions = ref([
                {
                    label: 'First',
                    value: 1
                },
            ])

            const dateFormat = ref({
                date: true,
                delimiter: '/',
                datePattern: ['d', 'm', 'Y'],
            })

            const formatDates = ref({
                application_date: null,
                from_date: null,
                to_date: null,
            })

            const getApplicationFormatDate = (date) => {
                formData.value.application_date = forMatIndianDate(date)
            }

            const getFromFormatDate = (date) => {
                formData.value.from_date = forMatIndianDate(date)
            }

            const getToFormatDate = (date) => {
                formData.value.to_date = forMatIndianDate(date)
            }

            const blankFormData = {
                application_date: forMatIndianDate(getTcTodayDate()),
                from_date: forMatIndianDate(),
                start_day: null,
                for_half: null,
                to_date: forMatIndianDate(),
                last_day: null,
                last_day_for_half: null,
                total_days: null,
                remarks: null,
                documentItem: null,
                reason: null,
            }
            const formData = ref(JSON.parse(JSON.stringify(blankFormData)))

            const resetFormData = () => {
                formData.value = JSON.parse(JSON.stringify(blankFormData))
            }

            const calculateDays = () => {
                let startDate = moment(formData.value.from_date, "DD/MM/YYYY");
                let endDate = moment(formData.value.to_date, "DD/MM/YYYY");

                formData.value.total_days = endDate.diff(startDate, 'days') + 1;

                if (formData.value.total_days <= 1) {
                    isDayLastDisable.value = true
                    formData.value.last_day = null
                } else {
                    isDayLastDisable.value = false
                }

                if (formData.value.start_day === 2){
                    formData.value.total_days = (formData.value.total_days) - 0.5;
                }

                if (formData.value.last_day === 2) {
                    formData.value.total_days = (formData.value.total_days) - 0.5;
                }

            }

            const selectDay = () => {
                formData.value.for_half = null

                if (formData.value.start_day === 1) {
                    isTypeDisable.value = true
                } else {
                    isTypeDisable.value = false
                }
                calculateDays()
            }

            const selectLastDay = () => {
                formData.value.last_day_for_half = null

                if (formData.value.last_day === 1) {
                    isSelectTypeDisable.value = true
                } else {
                    isSelectTypeDisable.value = false
                }
                calculateDays()
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
                /*    await store.dispatch('hr-store-module/updateOutdoorDuty', formData.value)
                       .then(res => {
                           if (res.status === 200) {
                               toast({
                                   component: ToastificationContent,
                                   position: 'top-right',
                                   props: {
                                       title: 'Outdoor Duty Update',
                                       icon: 'CheckSquareIcon',
                                       variant: 'success',
                                       text: `You have successfully Updatex Outdoor Duty.`,
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
                               name: 'edit-outdoor-duty',
                               params: {
                                   id: res.data.data._id
                               }
                           })
                       })*/
            }

            const {
                refFormObserver,
                getValidationState,
                resetForm
            } = formValidation(resetFormData)

            return {
                saveFormData,
                formData,
                dateFormat,
                formatDates,
                getApplicationFormatDate,
                refFormObserver,
                getValidationState,
                resetForm,
                resetFormData,
                startDayOptions,
                forHalfOptions,
                lastDayForHalfOptions,
                lastDayOptions,
                calculateDays,
                selectDay,
                selectLastDay,
                isSelectTypeDisable,
                isTypeDisable,
                isDayLastDisable,
                getFromFormatDate,
                getToFormatDate,
                showOverlayLoading,
                refetchData
            }
        }
    }
</script>
