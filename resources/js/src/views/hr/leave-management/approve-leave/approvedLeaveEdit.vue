<template>
    <div>
        <b-card-actions
            action-collapse
            action-refresh
            ref="cardAction"
            title="Leave Balances"
            @refresh="refreshStop('cardAction')"
        >
            <b-row>
                <b-col md="12">
                    <b-table
                        :fields="itemsField"
                        :items="itemsData"
                        :bordered="true"
                        :hover="true"
                        class="mb-0 table_scroll"
                        :busy="isBusy"
                        show-empty
                        responsive
                    >
                        <!-- Loader -->
                        <template #table-busy>
                            <div class="text-center my-2">
                                <b-spinner class="align-middle"></b-spinner>
                                <strong>Loading...</strong>
                            </div>
                        </template>
                    </b-table>
                </b-col>
            </b-row>
        </b-card-actions>

        <!--Form Data-->
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
                                        <span>Apply as LWP if you do not have any leave balance.</span><br><br>
                                        <span>More then 03 SL require Medical Documentation.</span><br><br>
                                        <span>CL and SL will be lapse at the end of Financial Year. You can't adjust or encash SL or CL in ant case.</span><br><br>
                                        <span>All Leave application must be approved by approving authority, without approval, leave will be treated as an absent.</span><br>
                                    </div>
                                </b-alert>
                                <hr>
                            </b-col>
                            <b-col md="12">
                                <h5>Leave Application Details</h5>
                                <hr>
                                <br>
                            </b-col>
                            <b-col md="6">
                                <validation-provider
                                    #default="validationContext"
                                    name="Application ID"
                                    rules=""
                                >
                                    <b-form-group
                                        label="Application ID"
                                        label-for="applicationId"
                                        :state="getValidationState(validationContext)"
                                    >
                                        <b-form-input
                                            id="applicationId"
                                            v-model="formData.applicationId"
                                            readonly
                                            :state="getValidationState(validationContext)"
                                        />
                                        <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                            {{ validationContext.errors[0] }}
                                        </b-form-invalid-feedback>
                                    </b-form-group>
                                </validation-provider>
                                <b-row>
                                    <b-col md="6">
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
                                                        disabled
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
                                                            disabled
                                                        />
                                                    </b-input-group-append>
                                                </b-input-group>
                                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                                    {{ validationContext.errors[0] }}
                                                </b-form-invalid-feedback>
                                            </validation-provider>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="6">
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
                                                        disabled
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
                                                            disabled
                                                        />
                                                    </b-input-group-append>
                                                </b-input-group>
                                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                                    {{ validationContext.errors[0] }}
                                                </b-form-invalid-feedback>
                                            </validation-provider>
                                        </b-form-group>
                                    </b-col>
                                </b-row>
                                <b-row>
                                    <b-col md="6">
                                        <validation-provider
                                            #default="validationContext"
                                            name="Half Type"
                                            rules=""
                                        >
                                        <b-form-group
                                            label="Half Type"
                                            label-for="half_type"
                                            :state="getValidationState(validationContext)"
                                        >
                                            <v-select
                                                v-model="formData.for_half"
                                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                                :options="forHalfOptions"
                                                :clearable="false"
                                                input-id="half_type"
                                                :reduce="val => val.value"
                                                :state="getValidationState(validationContext)"
                                                disabled
                                            />
                                        </b-form-group>
                                        </validation-provider>
                                    </b-col>
                                    <b-col md="6">
                                        <validation-provider
                                            #default="validationContext"
                                            name="No. Of Days"
                                            rules=""
                                        >
                                        <b-form-group
                                            label="No. Of Days"
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
                                        </b-form-group>
                                        </validation-provider>
                                    </b-col>
                                </b-row>
                            </b-col>
                            <b-col md="6">
                                <b-form-group>
                                    <validation-provider
                                        #default="validationContext"
                                        name="Status"
                                        rules="required"
                                    >
                                        <label for="status">Status <span
                                            class="text-danger erp_required_star"
                                        >*</span></label>

                                        <v-select
                                            v-model="formData.status"
                                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                            :options="statusOptions"
                                            :clearable="false"
                                            id="status"
                                            placeholder="Select Status"
                                            :reduce="val => val.value"
                                            :state="getValidationState(validationContext)"
                                        />
                                        <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                            {{ validationContext.errors[0] }}
                                        </b-form-invalid-feedback>
                                    </validation-provider>
                                </b-form-group>
                                <validation-provider
                                    #default="validationContext"
                                    name="Purpose"
                                    rules=""
                                >
                                    <b-form-group
                                        label="Purpose"
                                        label-for="purpose"
                                        :state="getValidationState(validationContext)"
                                    >
                                        <b-form-textarea
                                            id="purpose"
                                            placeholder="Purpose"
                                            v-model="formData.remarks"
                                            rows="2"
                                            :state="getValidationState(validationContext)"
                                        />
                                        <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                            {{ validationContext.errors[0] }}
                                        </b-form-invalid-feedback>
                                    </b-form-group>
                                </validation-provider>
                                <validation-provider
                                    #default="validationContext"
                                    name="Reason for Approval Rejection"
                                    rules=""
                                >
                                    <b-form-group
                                        label="Reason for Approval Rejection"
                                        label-for="reason"
                                        :state="getValidationState(validationContext)"
                                    >
                                        <b-form-textarea
                                            id="reason"
                                            placeholder="Reason"
                                            v-model="formData.reason"
                                            rows="3"
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
        <b-card-code>
            <b-table
                responsive
                striped hover outlined
                :items="tableRows"
                empty-text="No matching records found"
            >
            </b-table>
        </b-card-code>
    </div>
</template>
<script>
    import {
        BTable,
        BRow,
        BCol,
        BSpinner,
        BCardText,
        BForm,
        BFormInput,
        BFormGroup,
        BFormDatepicker,
        BInputGroup,
        BInputGroupAppend,
        BFormTextarea,
        BFormInvalidFeedback,
        BButton,
        BOverlay,
        BTableSimple,
        BThead,
        BTbody,
        BTh,
        BTr,
        BAlert
    } from 'bootstrap-vue'
    import BCardActions from "@core/components/b-card-actions/BCardActions";
    import BCardCode from "@core/components/b-card-code/BCardCode";
    import {onUnmounted, ref} from "@vue/composition-api";
    import {ValidationObserver, ValidationProvider} from 'vee-validate'
    import formValidation from '@core/comp-functions/forms/form-validation'
    import {forMatIndianDate, getTcTodayDate} from "@core/utils/utils";
    import Cleave from 'vue-cleave-component'
    import vSelect from 'vue-select'
    import {useToast} from "vue-toastification/composition";
    import hrmsStoreModule from "../../hrmsStoreModule";
    import Toastification from '@core/components/toastification/ToastificationContent.vue'
    import store from '@/store'
    import {required} from '@validations'
    import axios from '@axios'

    export default {
        components: {
            BCardActions,
            BCardCode,
            BOverlay,
            BTable,
            BRow,
            BCol,
            BSpinner,
            BCardText,
            ValidationObserver,
            ValidationProvider,
            BForm,
            BFormInput,
            BFormGroup,
            BFormDatepicker,
            BInputGroup,
            BInputGroupAppend,
            Cleave,
            vSelect,
            BFormTextarea,
            BFormInvalidFeedback,
            BButton,
            BTableSimple,
            BThead,
            BTbody,
            BTh,
            BTr,
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

            const tableRows = [
                {key: 'Employee Name: ', value: 'RAKESH S PATEL'},
                {key: 'Grade:', value: 'Staff New'},
                {key: 'Branch: ', value: 'Office'},
                {key: 'Department: ', value: 'ADMIN'},
                {key: 'Designation: ', value: 'OFFICE ASSISTANT'},
                {key: 'Joining Date: ', value: '18-Apr-22'},
                {key: 'Employee Code: ', value: 'C008111'},
                {key: 'Group: ', value: 'Non Technical'},
                {key: 'Division: ', value: 'Vadodara'},
                {key: 'Category: ', value: 'CEPL'},
                {key: 'Unit Name: ', value: 'HEAD OFFICE'},
                {key: 'Confirmation Dt: ', value: '18-Apr-22'},
            ]

            const showOverlayLoading = ref(false)

            const isBusy = ref(false)

            const forHalfOptions = ref([
                {label: 'First', value: 1},
                {label: 'Second', value: 2},
            ])

            const statusOptions = ref([
                {label: 'Approved', value: 1},
                {label: 'Decline', value: 2},
            ])

            const dateFormat = ref({
                date: true,
                delimiter: '/',
                datePattern: ['d', 'm', 'Y'],
            })
            const formatDates = ref({
                from_date: null,
                to_date: null,
            })

            const getFromFormatDate = (date) => {
                formData.value.from_date = forMatIndianDate(date)
            }
            const getToFormatDate = (date) => {
                formData.value.to_date = forMatIndianDate(date)
            }

            const field = ref([
                {key: 'nomor', label: 'Baroce'},
                {key: 'barang', label: 'Goods'},
                {key: 'ctns', label: 'CTNS'},
                {key: 'qty', label: 'Qty'},
            ])
            const items = ref([
                {
                    nomor: 'nomor 1',
                    barang: 'Baju',
                    ctns: '10',
                    qty: '80'
                },
            ])
            const itemsField = ref([
                {
                    key: 'leaveType',
                    label: 'Leave Type',
                    thStyle: {width: "52%"},
                },
                {
                    key: 'currentBalance',
                    label: 'Current Balance',
                    thStyle: {width: "8%"},
                },
                {
                    key: 'alreadyApplied',
                    label: 'Already Applied',
                    thStyle: {width: "8%"},
                },
                {
                    key: 'eachAdjLeave',
                    label: 'Each/Adj. Leaves',
                    thStyle: {width: "8%"},
                },
                {
                    key: 'availableBalance',
                    label: 'Available Balance',
                    thStyle: {width: "8%"},
                },
                {
                    key: 'appliedFor',
                    label: 'Applied For',
                    thStyle: {width: "8%"},
                },
                {
                    key: 'closingBalance',
                    label: 'Closing Balance',
                    thStyle: {width: "8%"},
                }
            ])
            const itemsData = ref([])

            const refetchTableData = async () => {
                isBusy.value = true
                itemsData.value = [{
                    leaveType: 'Casual Leave (CL)',
                    currentBalance: '0',
                    alreadyApplied: '0',
                    eachAdjLeave: '0',
                    availableBalance: '0',
                    appliedFor: '0',
                    closingBalance: '0'
                },
                    {
                        leaveType: 'Privilege Leave (PL)',
                        currentBalance: '0',
                        alreadyApplied: '0',
                        eachAdjLeave: '0',
                        availableBalance: '0',
                        appliedFor: '0',
                        closingBalance: '0'
                    },
                    {
                        leaveType: 'Sick Leave (SL)',
                        currentBalance: '0',
                        alreadyApplied: '0',
                        eachAdjLeave: '0',
                        availableBalance: '0',
                        appliedFor: '0',
                        closingBalance: '0'
                    },
                    {
                        leaveType: 'Comp. Leave Enjoy (CO)',
                        currentBalance: '0',
                        alreadyApplied: '0',
                        eachAdjLeave: '0',
                        availableBalance: '0',
                        appliedFor: '0',
                        closingBalance: '0'
                    },
                    {
                        leaveType: 'Leave Without pay (LWP)',
                        currentBalance: '0',
                        alreadyApplied: '0',
                        eachAdjLeave: '0',
                        availableBalance: '0',
                        appliedFor: '0',
                        closingBalance: '0'
                    }]
                isBusy.value = false
            }
            refetchTableData()


            const blankFormData = {
                applicationId: null,
                from_date: forMatIndianDate(),
                to_date: forMatIndianDate(),
                for_half: null,
                total_days: null,
                status: null,
                remarks: null,
                reason: null,
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
                /* await store.dispatch('hr-store-module/', formData.value)
                       .then(res => {
                           if (res.status === 200) {
                               toast({
                                   component: ToastificationContent,
                                   position: 'top-right',
                                   props: {
                                       title: 'Approved Leave updated',
                                       icon: 'CheckSquareIcon',
                                       variant: 'success',
                                       text: `You have successfully update Approved Leave.`,
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

            const {refFormObserver, getValidationState, resetForm} = formValidation(resetFormData)

            return {
                itemsData,
                itemsField,
                refetchTableData,
                showOverlayLoading,
                isBusy,
                formData,
                refFormObserver,
                getValidationState,
                resetForm,
                resetFormData,
                dateFormat,
                formatDates,
                getFromFormatDate,
                getToFormatDate,
                forHalfOptions,
                statusOptions,
                saveFormData,
                required,
                tableRows,
            }
        },
        methods: {
            refreshStop(cardName) {
                setTimeout(() => {
                    this.$refs[cardName].showLoading = false
                }, 3000)
            },
        }
    }
</script>
