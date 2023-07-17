<template>
    <div>
        <b-overlay
            :show="showOverlayLoading"
            rounded="sm"
        >
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
                                    rules=""
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
                                    rules=""
                                >
                                    <b-form-group
                                        label="Due Date"
                                        label-for="dueDate"
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
                                    rules=""
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
        </b-overlay>

        <!-- Tabs -->
        <b-overlay
            :show="showOverlayLoading"
            rounded="sm"
        >
            <b-card-code>
                <b-tabs
                    pills
                    lazy
                >
                    <b-tab active>
                        <template #title>
                            <feather-icon
                                icon="UsersIcon"
                                size="16"
                                class="mr-0 mr-sm-50"
                            />
                            <span class="d-none d-sm-inline">Vendor Details</span>
                        </template>
                        <hr>
                        <vendor-details-tab/>
                    </b-tab>
                    <b-tab>
                        <template #title>
                            <feather-icon
                                icon="DatabaseIcon"
                                size="16"
                                class="mr-0 mr-sm-50"
                            />
                            <span class="d-none d-sm-inline">Items Details</span>
                        </template>
                        <hr>
                        <item-details-tab/>
                    </b-tab>
                    <b-tab>
                        <template #title>
                            <feather-icon
                                icon="FileTextIcon"
                                size="16"
                                class="mr-0 mr-sm-50"
                            />
                            <span class="d-none d-sm-inline">Header/Footer</span>
                        </template>
                        <hr>
                        <header-footer-tab
                            :headerFooterDetails="formData.headerFooterDetails"
                        />
                    </b-tab>
                    <b-tab>
                        <template #title>
                            <feather-icon
                                icon="EditIcon"
                                size="16"
                                class="mr-0 mr-sm-50"
                            />
                            <span class="d-none d-sm-inline">Remark</span>
                        </template>
                        <hr>
                        <remark-details-tab
                            :remarkDetails="formData.remarkDetails"
                        />
                    </b-tab>
                    <b-tab>
                        <template #title>
                            <feather-icon
                                icon="LogInIcon"
                                size="16"
                                class="mr-0 mr-sm-50"
                            />
                            <span class="d-none d-sm-inline">Login</span>
                        </template>
                        <hr>
                        <login-tab
                            :loginData="formData.loginDetails"
                        />
                    </b-tab>
                    <b-tab>
                        <template #title>
                            <feather-icon
                                icon="FileIcon"
                                size="16"
                                class="mr-0 mr-sm-50"
                            />
                            <span class="d-none d-sm-inline">Report</span>
                        </template>
                        <hr>
                        <report-tab
                        />
                    </b-tab>
                </b-tabs>
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
        BFormTextarea,
        BFormDatepicker,
        BButton,
        BFormInvalidFeedback,
        BOverlay,
        BTabs,
        BTab,
        BInputGroupAppend,
        BInputGroup,
        BInputGroupPrepend
    } from 'bootstrap-vue'
    import BCardCode from "@core/components/b-card-code/BCardCode";
    import Ripple from 'vue-ripple-directive'
    import {ref, onUnmounted} from '@vue/composition-api'
    import VSelect from 'vue-select'
    import axios from '@axios'
    import {getTcTodayDate} from "@core/utils/utils";
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
    import VendorDetailsTab from "./tabs/vendorDetailsTab";
    import ItemDetailsTab from "./tabs/itemDetailsTab";
    import headerFooterTab from "./tabs/headerFooterTab";
    import remarkDetailsTab from "./tabs/remarkDetailsTab";
    import loginTab from "./tabs/loginTab"
    import reportTab from "./tabs/reportTab"
    import {forMatIndianDate} from "@core/utils/utils";
    import Cleave from 'vue-cleave-component'
    import {getTcTodayDateTime} from "@core/utils/utils";

    export default {
        components: {
            VendorDetailsTab,
            ItemDetailsTab,
            headerFooterTab,
            remarkDetailsTab,
            BCardCode,
            loginTab,
            reportTab,
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
            BOverlay,
            BTabs,
            BTab,
            ValidationProvider,
            ValidationObserver,
            Cleave,
            BInputGroupAppend,
            BInputGroup,
            BInputGroupPrepend
        },
        directives: {
            Ripple,
        },
        setup() {
            const ITEMADDON_APP_STORE_MODULE_NAME = 'purchase-store-module'
            if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, purchaseStoreModule)
            onUnmounted(() => {
                if (store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.unregisterModule(ITEMADDON_APP_STORE_MODULE_NAME)
            })

            const toast = useToast()

            const showOverlayLoading = ref(false)
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
            const CurrentUserData = ref(getUserData())

            const blankFormData = {
                id:null,
                referenceNumber: null,
                referenceDate: forMatIndianDate(getTcTodayDate()),
                dueDate: forMatIndianDate(),
                validUpTo: forMatIndianDate(),
                loginDetails: {
                    createdBy: CurrentUserData.value.first_name + ' ' + CurrentUserData.value.last_name,
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

            axios.get(`/api/purchase-enquiry/${router.currentRoute.params.id}`).then(res => {
                formData.value = res.data.data
                formData.value.id = res.data.data._id
                delete res.data.data._id
                showOverlayLoading.value = false
            })

            const saveFormData = async () => {
                formData.value.loginDetails.lastModifiedBy = CurrentUserData.value.first_name + ' ' + CurrentUserData.value.last_name
                formData.value.loginDetails.modifiedDateTime = getTcTodayDateTime()
                await store.dispatch('purchase-store-module/updatePurchaseEnquiry', formData.value).then(res => {
                    if (res.status === 200) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Purchase Enquiry Updated',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: `You have successfully Updated Purchase Enquiry.`,
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
            }

            const {refFormObserver, getValidationState, resetForm} = formValidation(resetFormData)

            return {
                showOverlayLoading,
                formData,
                resetFormData,
                saveFormData,
                required,

                refFormObserver,
                getValidationState,
                resetForm,
                dateFormat,
                formatDates,
                getPurchaseRefFormateDate,
                getValidToFormateDate,
                getPoInvoiceFormateDate

            }
        }
    }
</script>
