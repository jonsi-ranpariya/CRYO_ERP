<template>
    <div>
        <b-card-code>
            <validation-observer #default="{ handleSubmit }">
                <b-form @submit.prevent="handleSubmit(saveFormData)">
                    <b-row>
                        <b-col md="6">
                            <validation-provider
                                #default="validationContext"
                                name="Ref No"
                                rules=""
                            >
                                <b-form-group
                                    label="Ref No"
                                    label-for="refNumber"
                                >
                                    <b-form-input
                                        id="refNumber"
                                        readonly
                                        v-model="formData.referenceNumber"
                                        :state="getValidationState(validationContext)"
                                    />
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                            <validation-provider
                                #default="validationContext"
                                name="Reference Date"
                                rules="required"
                            >
                                <b-form-group
                                    label="Reference Date"
                                    label-for="referenceDate"
                                    :state="getValidationState(validationContext)"
                                >
                                    <b-input-group>
                                        <cleave
                                            id="referenceDate"
                                            v-model="formData.referenceDate"
                                            class="form-control"
                                            :raw="false"
                                            :options="dateFormat"
                                            placeholder="DD/MM/YYYY"
                                            show-decade-nav
                                        />
                                        <b-input-group-append>
                                            <b-form-datepicker
                                                v-model="formatDates.referenceDate"
                                                button-only
                                                @input="getPurchaseRefFormateDate($event)"
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
                        <b-col md="6">
                            <validation-provider
                                #default="validationContext"
                                name="Due Date"
                                rules="required"
                            >
                                <b-form-group
                                    label="Due Date"
                                    label-for="dueDate"
                                    :state="getValidationState(validationContext)"
                                >
                                    <b-input-group>
                                        <b-input-group-prepend>
                                            <b-form-datepicker
                                                v-model="formatDates.dueDate"
                                                button-only
                                                @input="getPoInvoiceFormateDate($event)"
                                                show-decade-nav
                                                size="sm"
                                                nav-button-variant="primary"
                                                :state="getValidationState(validationContext)"
                                            />
                                        </b-input-group-prepend>
                                        <cleave
                                            id="dueDate"
                                            v-model="formData.dueDate"
                                            class="form-control"
                                            :raw="false"
                                            :options="dateFormat"
                                            placeholder="DD/MM/YYYY"
                                            show-decade-nav
                                            :state="getValidationState(validationContext)"
                                            @input="getDueDateInput($event)"
                                        />
                                    </b-input-group>
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                            <validation-provider
                                #default="validationContext"
                                name="Valid Up To"
                                rules="required"
                            >
                                <b-form-group
                                    label="Valid Up To"
                                    label-for="validUpTo"
                                >
                                    <b-input-group>
                                        <b-input-group-prepend>
                                            <b-form-datepicker
                                                v-model="formatDates.validUpTo"
                                                button-only
                                                @input="getValidToFormateDate($event)"
                                                show-decade-nav
                                                size="sm"
                                                nav-button-variant="primary"
                                            />
                                        </b-input-group-prepend>
                                        <cleave
                                            id="prInvoiceDate"
                                            v-model="formData.validUpTo"
                                            class="form-control"
                                            :raw="false"
                                            :options="dateFormat"
                                            placeholder="DD/MM/YYYY"
                                            show-decade-nav
                                            :state="getValidationState(validationContext)"
                                            @input="getValidUpToDateInput($event)"
                                        />
                                    </b-input-group>
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                        </b-col>
                        <!-- Button-->
                        <b-col md="12">
                            <hr>
                            <b-button
                                class="float-right"
                                variant="primary"
                                type="submit"
                            >
                                Save
                            </b-button>
                        </b-col>
                    </b-row>
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
        BFormGroup,
        BFormInput,
        BFormTextarea,
        BFormDatepicker,
        BButton,
        BFormInvalidFeedback,
        BInputGroup,
        BInputGroupAppend,
        BInputGroupPrepend
    } from 'bootstrap-vue'
    import BCardCode from "../../../@core/components/b-card-code/BCardCode";
    import Ripple from 'vue-ripple-directive'
    import {ref, onUnmounted} from '@vue/composition-api'
    import VSelect from 'vue-select'
    import axios from '@axios'
    import { forMatIndianDate, formatSqlDate, getTcTodayDate } from '@core/utils/utils'
    import {ValidationProvider, ValidationObserver} from 'vee-validate'
    import formValidation from '@core/comp-functions/forms/form-validation'
    import {required} from '@validations'
    import router from '@/router'
    import {getUserData} from "../../../auth/utils";
    import moment from 'moment'
    import store from '@/store'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import {useToast} from 'vue-toastification/composition'
    import purchaseStoreModule from "../purchaseStoreModule";
    import Cleave from 'vue-cleave-component'

    export default {
        components: {
            BCardCode,
            VSelect,
            BForm,
            BRow,
            BCol,
            BFormGroup,
            BFormInput,
            BFormTextarea,
            BFormDatepicker,
            BButton,
            BFormInvalidFeedback,
            ValidationProvider,
            ValidationObserver,
            BInputGroup,
            BInputGroupAppend,
            Cleave,
            BInputGroupPrepend
        },
        directives: {
            Ripple,
        },
        setup() {
            const toast = useToast()

            const ITEMADDON_APP_STORE_MODULE_NAME = 'purchase-store-module'
            if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, purchaseStoreModule)
            onUnmounted(() => {
                if (store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.unregisterModule(ITEMADDON_APP_STORE_MODULE_NAME)
            })


            const dateFormat = ref({
                date: true,
                delimiter: '/',
                datePattern: ['d', 'm', 'Y'],
            })
            const formatDates = ref({
                referenceDate: null,
                dueDate: null,
                validUpTo: null,
            })

            const getPurchaseRefFormateDate = (date) => {
                formData.value.referenceDate = forMatIndianDate(date)
            }
            const getPoInvoiceFormateDate = (date) => {
                formData.value.dueDate = forMatIndianDate(date)
            }
            const getValidToFormateDate = (date) => {
                formData.value.validUpTo = forMatIndianDate(date)
            }

            const blankFormData = {
                referenceNumber: null,
                referenceDate: forMatIndianDate(getTcTodayDate()),
                dueDate: forMatIndianDate(),
                validUpTo: forMatIndianDate(),
                dateOfBirth:null,
                loginDetails: {
                    createdBy: getUserData().first_name + ' ' + getUserData().last_name,
                    dateTime: moment(new Date()).format('DD/MM/YYYY HH:mm'),
                    lastModifiedBy: null,
                    modifiedDateTime: null,
                },
                headerFooterDetails: {
                    header: null,
                    headerDescription: null,
                    footer: null,
                    footerDescription: null,
                },
                remarkDetails: {
                    remark: null,
                },
            }

            const formData = ref(JSON.parse(JSON.stringify(blankFormData)))

            const resetFormData = () => {
                formData.value = JSON.parse(JSON.stringify(blankFormData))
            }

            const saveFormData = async () => {
                await store.dispatch('purchase-store-module/addPurchaseEnquiry', formData.value).then(res => {
                    if (res.status === 200) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Purchase Enquiry Added',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: `You have successfully Added Purchase Enquiry.`,
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
                        name: 'edit-purchase-enquiry',
                        params: {
                            id: res.data.data._id
                        }
                    })
                })
            }

            const getDueDateInput = (input) => {
                if (input.length === 10) {
                    let initial = input.split(/\//);
                    let newDateFormat =  [ initial[1], initial[0], initial[2] ].join('/')
                    formatDates.value.dueDate = formatSqlDate(moment(newDateFormat))
                }
            }

            const getValidUpToDateInput = (input) => {
                if (input.length === 10) {
                    let initial = input.split(/\//);
                    let newDateFormat =  [ initial[1], initial[0], initial[2] ].join('/')
                    formatDates.value.validUpTo = formatSqlDate(moment(newDateFormat))
                }
            }

            const {refFormObserver, getValidationState, resetForm} = formValidation(resetFormData)

            return {
                formData,
                resetFormData,
                saveFormData,
                required,
                refFormObserver,
                getValidationState,
                resetForm,
                dateFormat,
                formatDates,
                getPoInvoiceFormateDate,
                getValidToFormateDate,
                getPurchaseRefFormateDate,
                getDueDateInput,
                getValidUpToDateInput
            }
        }
    }
</script>
