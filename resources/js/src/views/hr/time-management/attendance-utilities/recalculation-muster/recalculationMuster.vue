<template>
    <div>
        <b-card-code>
            <validation-observer #default="{handleSubmit}">
                <b-form @submit.prevent="handleSubmit(saveFormData)">
                    <b-row>
                        <!-- danger -->
                        <b-col md="12">
                            <b-alert
                                variant="danger"
                                show
                            >
                                <h4 class="alert-heading">
                                    Note:
                                </h4>
                                <div class="alert-body">
                                    <span>This utility regenerate and process the Muster Day of the given range. ie. generate day records as per the shift rules and save day type , late mark , OT etc accordingly.</span><br><br>
                                    <span>This will only work for non-locked data.</span><br><br>
                                    <span>This is useful when any shift rules / swipe data are changed which is needed to have the retrospective effect on day records.</span><br><br>
                                    <span>System is also having provision of execute this process on scheduled basis through API. For details check module [Attendance Settings --> Recalculate Attendance Settings].</span><br><br>
                                </div>
                            </b-alert>
                            <hr>
                        </b-col>
                    </b-row>

                    <b-card
                        no-body
                        class="card-statistics"
                    >
                        <b-card-body class="statistics-body">
                            <b-row>
                                <b-col
                                    v-for="item in statisticsItems"
                                    :key="item.title"
                                    md="2"
                                    sm="12"
                                    class="mb-2 mb-md-0"
                                    :class="item.customClass"
                                >
                                    <b-media no-body>
                                        <b-media-aside

                                            class="mr-2"
                                        >
                                            <b-avatar
                                                size="45"
                                                :variant="item.color"
                                            >
                                                {{ item.title }}
                                            </b-avatar>
                                        </b-media-aside>
                                        <b-media-body class="my-auto">
                                            <b-card-text class="font-small-3 mb-0">
                                                {{ item.subtitle }}
                                            </b-card-text>
                                        </b-media-body>
                                    </b-media>
                                </b-col>
                            </b-row>
                        </b-card-body>
                    </b-card>
                    <hr>
                    <b-row>
                        <b-col md="6">
                            <b-row>
                                <b-col md="6">
                                    <validation-provider
                                        #default="validationContext"
                                        name="From Date"
                                        rules="required"
                                    >
                                        <b-form-group
                                            :state="getValidationState(validationContext)"
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
                                                        type="date"
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
                                        name="To Date"
                                        rules="required"
                                    >
                                        <b-form-group
                                            :state="getValidationState(validationContext)"
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
                                                    />
                                                </b-input-group-append>
                                            </b-input-group>
                                            <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                                {{ validationContext.errors[0] }}
                                            </b-form-invalid-feedback>
                                        </b-form-group>
                                    </validation-provider>
                                </b-col>
                            </b-row>
                        </b-col>
                        <b-col md="6">
                            <div class="demo-inline-spacing">
                                <b-form-checkbox
                                    v-model="formData.consider_attendance_swipe_request"
                                    name="consider_attendance_swipe_request"
                                >
                                    Consider Attendance type from Swipe request.
                                </b-form-checkbox>
                                <b-form-checkbox
                                    v-model="formData.delete_auto_shift"
                                    name="delete_auto_shift"
                                >
                                    Delete Auto Shift Assignment
                                </b-form-checkbox>
                            </div>
                        </b-col>
                    </b-row>
                    <hr>
                    <b-row>
                        <b-col md="4">
                            <b-form-group
                                label="Grade"
                                label-for="grade"
                            >
                                <v-select
                                    v-model="formData.grade"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="gradeOptions"
                                    :clearable="false"
                                    input-id="grade"
                                    placeholder="Select Grade"
                                />
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                label="Branch"
                                label-for="branch"
                            >
                                <v-select
                                    v-model="formData.branch"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="branchOptions"
                                    :clearable="false"
                                    input-id="branch"
                                    placeholder="Select Branch"
                                />
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                label="Department"
                                label-for="department"
                            >
                                <v-select
                                    v-model="formData.department"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="departmentOptions"
                                    :clearable="false"
                                    input-id="grade"
                                    placeholder="Select Department"
                                />
                            </b-form-group>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col md="4">
                            <b-form-group
                                label="Division"
                                label-for="division"
                            >
                                <v-select
                                    v-model="formData.division"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="divisionOptions"
                                    :clearable="false"
                                    placeholder="Select Division"
                                    input-id="division"
                                />
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                label="Unit"
                                label-for="unit"
                            >
                                <v-select
                                    v-model="formData.unit"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="unitOptions"
                                    :clearable="false"
                                    input-id="unit"
                                    placeholder="Select Unit"
                                />
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                label="Category"
                                label-for="category"
                            >
                                <v-select
                                    v-model="formData.category"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="categoryOptions"
                                    :clearable="false"
                                    placeholder="Select Category"
                                    input-id="category"
                                />
                            </b-form-group>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col md="4">
                            <b-form-group
                                label="Group"
                                label-for="group"
                            >
                                <v-select
                                    v-model="formData.group"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="groupOptions"
                                    :clearable="false"
                                    placeholder="Select Group"
                                    input-id="group"
                                />
                            </b-form-group>
                        </b-col>
                    </b-row>
                    <hr>
                    <b-row>
                        <b-col md="4">
                            <b-form-group
                                label="Employee"
                                label-for="employee_name"
                            >
                                <v-select
                                    v-model="formData.employee_name"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="employeeOptions"
                                    :clearable="false"
                                    :reduce="val => val.value"
                                    placeholder="Select Employee"
                                    input-id="employee_name"
                                />
                            </b-form-group>
                        </b-col>
                        <b-col md="5">
                            <b-form-group
                                label="Status"
                                label-for="status"
                                label-class="mb-1"
                            >
                                <b-form-radio-group
                                    id="status"
                                    v-model="formData.status"
                                    :options="statusOptions"
                                />
                            </b-form-group>
                        </b-col>
                    </b-row>
                    <hr>
                    <b-col md="12">
                        <b-button
                            variant="primary"
                            class="float-right ml-1"
                        >
                            Reset
                        </b-button>
                        <b-button
                            variant="primary"
                            class="float-right"
                            @click="recalculation"
                        >
                            Recalculation
                        </b-button>
                    </b-col>
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
        BAlert,
        BFormCheckbox,
        BInputGroup,
        BInputGroupAppend,
        BFormDatepicker,
        BFormInvalidFeedback,
        BFormTextarea,
        BButton,
        BFormRadioGroup,
        BTabs,
        BTab,
        BCard,
        BCardBody,
        BMedia,
        BMediaAside,
        BAvatar,
        BMediaBody,
        BCardText,

    } from 'bootstrap-vue'
    import BCardCode from "@core/components/b-card-code/BCardCode";
    import {ValidationObserver, ValidationProvider} from 'vee-validate'
    import {ref} from "@vue/composition-api";
    import formValidation from "@core/comp-functions/forms/form-validation";
    import {forMatIndianDate} from "@core/utils/utils";
    import Cleave from 'vue-cleave-component'
    import {required} from '@validations'
    import vSelect from 'vue-select'
    import axios from '@axios'
    import Swal from "sweetalert2";
    import {useToast} from "vue-toastification/composition";
    import Toastification from '@core/components/toastification/ToastificationContent.vue'

    export default {
        components: {
            BCard,
            BCardBody,
            BMedia,
            BMediaAside,
            BAvatar,
            BMediaBody,
            BCardText,

            BForm,
            BRow,
            BCol,
            BFormGroup,
            BAlert,
            BCardCode,
            ValidationObserver,
            ValidationProvider,
            BFormCheckbox,
            BInputGroup,
            BInputGroupAppend,
            Cleave,
            BFormDatepicker,
            BFormInvalidFeedback,
            vSelect,
            BFormTextarea,
            BFormRadioGroup,
            BButton,
            BTabs,
            BTab,
        },
        setup() {
            const toast = useToast()

            const statisticsItems = [
                {
                    color: 'light-primary',
                    title: '324',
                    subtitle: 'Muster Count',
                    customClass: 'mb-2 mb-xl-0',
                },
                {
                    color: 'light-info',
                    title: '0',
                    subtitle: 'Day Locked',
                    customClass: 'mb-2 mb-xl-0',
                },
                {
                    color: 'light-danger',
                    title: '354',
                    subtitle: 'Day UnLocked',
                    customClass: 'mb-2 mb-sm-0',
                },
            ]

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
            const statusOptions = ref([
                {
                    text: 'All',
                    value: 'All'
                },
                {
                    text: 'Current',
                    value: 'Current'
                },
                {
                    text: 'Left',
                    value: 'Left'
                },
                {
                    text: 'Web Active',
                    value: 'Web Active'
                },
            ])

            const gradeOptions = ref([])
            axios.get('/api/new/get-grade-master')
                .then(res => {
                    gradeOptions.value = res.data
                })

            const branchOptions = ref([])
            axios.get('/api/new/get-hr-branch-master')
                .then(res => {
                    branchOptions.value = res.data
                })

            const departmentOptions = ref([])
            axios.get('/api/new/get-hr-department-master')
                .then(res => {
                    departmentOptions.value = res.data
                })

            const divisionOptions = ref([])
            axios.get('/api/new/get-division-master')
                .then(res => {
                    divisionOptions.value = res.data
                })

            const unitOptions = ref([])
            axios.get('/api/new/get-unit-master')
                .then(res => {
                    unitOptions.value = res.data
                })

            const categoryOptions = ref([])
            axios.get('/api/new/get-category-master')
                .then(res => {
                    categoryOptions.value = res.data
                })

            const groupOptions = ref([])
            axios.get('/api/new/get-group-master')
                .then(res => {
                    groupOptions.value = res.data
                })

            const employeeOptions = ref([])
            axios.get('/api/get-users-name-options')
                .then(res => {
                    employeeOptions.value = res.data.data
                })

            const companyOptions = ref([])
            axios.get('/api/administration/get-company-options')
                .then(res => {
                    companyOptions.value = res.data.data
                })

            const blankFormData = {
                from_date: forMatIndianDate(),
                to_date: forMatIndianDate(),
                consider_attendance_swipe_request:true,
                delete_auto_shift:true,
                grade: null,
                branch: null,
                department: null,
                division: null,
                unit: null,
                category: null,
                group: null,
                employee_name: null,
                status: 'Current',
            }

            const formData = ref(JSON.parse(JSON.stringify(blankFormData)))

            const resetFormData = () => {
                formData.value = JSON.parse(JSON.stringify(blankFormData))
            }

            const recalculation = async (data) => {
                await Swal.fire({
                    title: 'Are you sure?',
                    text: "you want to recalculate without selecting any filters",
                    icon: 'warning',
                    showCancelButton: true,
                    showDenyButton: true,
                    confirmButtonText: 'Yes',
                    denyButtonText: 'No',
                    cancelButtonText: 'Cancel',
                    customClass: {
                        confirmButton: 'btn btn-outline-success',
                        cancelButton: 'btn btn-outline-danger ml-1',
                        denyButton: 'btn btn-outline-warning ml-1',
                    },
                    buttonsStyling: false,
                }).then(result => {
                    if (result.isConfirmed) {
                        acceptDeclineEvent(data, 2)
                    }
                    if (result.isDenied) {
                        acceptDeclineEvent(data, 3)
                    }
                    if (result.isDismissed) {
                        toast({
                            component: Toastification,
                            position: 'top-right',
                            props: {
                                title: 'Cancel',
                                icon: 'AlertCircleIcon',
                                variant: 'danger',
                                text: 'You have abort the task!',
                            },
                        })
                    }
                })
            }

            const acceptDeclineEvent = async (data, status) => {}

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
                dateFormat,
                formatDates,
                getFromFormatDate,
                getToFormatDate,
                required,
                gradeOptions,
                groupOptions,
                unitOptions,
                categoryOptions,
                employeeOptions,
                departmentOptions,
                divisionOptions,
                branchOptions,
                statusOptions,
                statisticsItems,
                recalculation,
                acceptDeclineEvent
            }
        }
    }
</script>
