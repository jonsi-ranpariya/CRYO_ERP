<template>
    <div>
        <hr>
        <b-row>
            <b-col md="12">
                <b-table
                    :fields="tableData.fields"
                    :items="tableData.rows"
                    :bordered="true"
                    :hover="true"
                    show-empty
                    responsive
                    class="mb-0 table_scroll"
                    selectable
                    select-mode="single"
                    @row-selected="onRowSelected"
                >
                    <!-- Empty Fields -->
                    <template #empty="scope">
                        <h5 class="text-center text-uppercase">No Sales Order Stages Available</h5>
                    </template>
                    <!-- Serial Number -->
                    <template #cell(index)="data">
                        {{ data.index + 1 }}
                    </template>
                    <template #cell(stage)="data">
                        <span v-for="stage in stageOptions">
                            <span v-if="data.item.stage === stage.value">{{ stage.label }}</span>
                        </span>
                    </template>
                    <template #cell(status)="data">
                        <span v-for="status in statusOptions">
                            <span v-if="data.item.status === status.value">{{ status.label }}</span>
                        </span>
                    </template>
                    <template #cell(action)="data">
                <span>
                     <b-dropdown
                         variant="link"
                         toggle-class="text-decoration-none"
                         no-caret
                     >
                      <template v-slot:button-content>
                        <feather-icon
                            icon="MoreVerticalIcon"
                            size="16"
                            class="text-body align-middle mr-25"
                        />
                      </template>
                      <b-dropdown-item @click="deleteStage(data.item._id)">
                        <feather-icon
                            icon="TrashIcon"
                            class="mr-50"
                        />
                        <span>Delete</span>
                      </b-dropdown-item>
                    </b-dropdown>
                </span>
                    </template>

                    <!-- Selection Area -->
                    <template #cell(rowSelected)="{ rowSelected }">
                        <template v-if="rowSelected">
                            <span aria-hidden="true">&check;</span>
                            <span class="sr-only">Selected</span>
                        </template>
                        <template v-else>
                            <span aria-hidden="true">&nbsp;</span>
                            <span class="sr-only">Not selected</span>
                        </template>
                    </template>

                </b-table>
                <hr>
                <b-form
                    @submit.prevent="submitForm"
                >
                    <b-row>
                        <b-col md="6">
                            <b-form-group
                                label="Stage"
                                label-for="stage"
                            >
                                <v-select
                                    v-model="soStageDetails.stage"
                                    placeholder="Select Stage"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="stageOptions"
                                    :reduce="val => val.value"
                                    :clearable="false"
                                    input-id="stage"
                                />
                            </b-form-group>
                            <b-form-group
                                label="Require Days"
                                label-for="requireDays"
                            >
                                <b-form-input
                                    id="requireDays"
                                    type="number"
                                    v-model="soStageDetails.requireDays"
                                />
                            </b-form-group>
                            <b-form-group
                                label="Stage Details"
                                label-for="stageDetails"
                            >
                                <b-form-textarea
                                    id="stageDetails"
                                    rows="3"
                                    v-model="soStageDetails.stageDetails"
                                />
                            </b-form-group>
                        </b-col>
                        <b-col md="6">
                            <b-form-group
                                label="Responsible User"
                                label-for="resposibleUser"
                            >
                                <v-select
                                    placeholder="Select User"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="usersOptions"
                                    :reduce="val => val.value"
                                    :clearable="false"
                                    input-id="resposibleUser"
                                    v-model="soStageDetails.responsibleUser"
                                />
                            </b-form-group>
                            <b-form-group
                                label="Start Date"
                                label-for="startDate"
                            >
                                <!--<b-form-datepicker
                                    id="startDate"
                                    :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }"
                                    locale="in"
                                    class="mb-1"
                                    v-model="soStageDetails.startDate"
                                    @input="soStageDetails.endDate = null"
                                    size
                                />-->
                                <b-input-group>
                                    <b-input-group-prepend>
                                        <b-form-datepicker
                                            v-model="formatDates.startDate"
                                            button-only
                                            @input="getStartFormatDate($event)"
                                            show-decade-nav
                                            size="sm"
                                            nav-button-variant="primary"
                                        />
                                    </b-input-group-prepend>
                                    <cleave
                                        id="invoiceDate"
                                        v-model="soStageDetails.startDate"
                                        class="form-control"
                                        :raw="false"
                                        :options="dateFormat"
                                        placeholder="DD/MM/YYYY"
                                        show-decade-nav
                                    />
                                </b-input-group>
                            </b-form-group>
                            <b-form-group
                                label="End Date"
                                label-for="endDate"
                            >
                                <!--<b-form-datepicker
                                    id="endDate"
                                    :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }"
                                    locale="in"
                                    class="mb-1"
                                    v-model="soStageDetails.endDate"
                                    :min="soStageDetails.startDate"
                                />-->
                                <b-input-group>
                                    <b-input-group-prepend>
                                        <b-form-datepicker
                                            v-model="formatDates.endDate"
                                            button-only
                                            @input="getEndFormatDate($event)"
                                            show-decade-nav
                                            size="sm"
                                            nav-button-variant="primary"
                                        />
                                    </b-input-group-prepend>
                                    <cleave
                                        id="endDate"
                                        v-model="soStageDetails.endDate"
                                        class="form-control"
                                        :raw="false"
                                        :options="dateFormat"
                                        placeholder="DD/MM/YYYY"
                                        show-decade-nav
                                    />
                                </b-input-group>
                            </b-form-group>
                            <b-form-group
                                label="Status"
                                label-for="status"
                            >
                                <v-select
                                    placeholder="Select Status"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="statusOptions"
                                    :reduce="val => val.value"
                                    :clearable="false"
                                    input-id="status"
                                    v-model="soStageDetails.status"
                                />
                            </b-form-group>
                        </b-col>
                    </b-row>
                    <hr>
                    <b-button
                        variant="primary"
                        type="submit"
                    >
                        {{ buttonText }}
                    </b-button>
                </b-form>
            </b-col>
        </b-row>
    </div>
</template>
<script>
    import BCardCode from '@core/components/b-card-code'
    import {ValidationProvider, ValidationObserver} from 'vee-validate'
    import {
        BRow,
        BCol,
        BFormGroup,
        BFormInput,
        BFormTextarea,
        BForm,
        BButton,
        BFormDatepicker,
        BOverlay,
        BTab,
        BTabs,
        BTable,
        BSpinner,
        BFormInvalidFeedback,
        BDropdown,
        BDropdownItem,
        BInputGroup,
        BInputGroupAppend,
        BInputGroupPrepend
    } from 'bootstrap-vue';
    import {required, numeric} from '@validations';
    import Ripple from 'vue-ripple-directive';
    import vSelect from 'vue-select';
    import router from '@/router';
    import store from '@/store';
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue';
    import {ref, watch, watchEffect, onUnmounted, computed} from '@vue/composition-api';
    import axios from '@axios';
    import Swal from 'sweetalert2';
    import {useToast} from 'vue-toastification/composition';
    import formValidation from '@core/comp-functions/forms/form-validation';
    import salesStoreModule from "../../salesStoreModule";
    import moment from 'moment';
    import Cleave from 'vue-cleave-component';
    import {forMatIndianDate} from "../../../../@core/utils/utils";

    export default {
        components: {
            BCardCode,
            BRow,
            BCol,
            BFormGroup,
            BFormInput,
            BFormTextarea,
            BForm,
            BButton,
            BFormDatepicker,
            BOverlay,
            BTab,
            BTabs,
            BTable,
            BSpinner,
            vSelect,
            ValidationProvider,
            ValidationObserver,
            BFormInvalidFeedback,
            BDropdown,
            BDropdownItem,
            BInputGroup,
            BInputGroupAppend,
            BInputGroupPrepend,
            Cleave,
        },
        directives: {
            Ripple,
        },
        props: {
            soStageData: {
                type: Object
            }
        },
        emit: 'saveData',
        setup() {
            const SO_APP_STORE_MODULE_NAME = 'sales-order-module'
            // Register module
            if (!store.hasModule(SO_APP_STORE_MODULE_NAME)) store.registerModule(SO_APP_STORE_MODULE_NAME, salesStoreModule)
            // UnRegister on leave
            /*onUnmounted(() => {
                if (store.hasModule(SO_APP_STORE_MODULE_NAME)) store.unregisterModule(SO_APP_STORE_MODULE_NAME)
            })*/

            const toast = useToast()

            const stageOptions = ref([
                {label: 'Active', value: 1},
                {label: 'Achieved', value: 2},
                {label: 'Regret', value: 3},
                {label: 'Closed', value: 4},
                {label: 'Followup', value: 5},
            ])

            const usersOptions = ref([])

            axios.get('/api/get-users-options').then(res => {
                usersOptions.value = res.data.data
            })

            const statusOptions = ref([
                {label: 'Pending', value: 1},
                {label: 'Completed', value: 2},
                {label: 'Regret', value: 3},
                {label: 'Cancelled', value: 4},
            ])

            const tableData = ref({
                fields: [
                    {
                        key: 'rowSelected',
                        label: ''
                    },
                    {
                        key: 'index',
                        label: 'No'
                    },
                    {
                        key: 'stage',
                        label: 'Stage'
                    },
                    {
                        key: 'requireDays',
                        label: 'Require Days'
                    },
                    {
                        key: 'user_details',
                        label: 'Responsible User',
                        formatter: val => val !== null ? val.first_name + ' ' + val.last_name : null
                    },
                    {
                        key: 'startDate',
                        label: 'Start Date',
                        // formatter: val => moment(val).format('DD/MM/YYYY')
                    },
                    {
                        key: 'endDate',
                        label: 'End Date',
                        // formatter: val => moment(val).format('DD/MM/YYYY')
                    },
                    {
                        key: 'status',
                        label: 'Status'
                    },
                    {
                        key: 'action',
                        label: 'Action'
                    },
                ],
                rows: []
            })

            const fetchData = async () => {
                await axios.get(`/api/get-sales-order-stage/${router.currentRoute.params.id}`).then(res => {
                    tableData.value.rows = res.data.data
                })
            }
            fetchData()

            const soStageDetails = ref({
                id: null,
                salesOrderId: router.currentRoute.params.id,
                stage: null,
                requireDays: null,
                stageDetails: null,
                responsibleUser: null,
                startDate: forMatIndianDate(),
                endDate: forMatIndianDate(),
                status: null,
            })

            const buttonText = ref('Save')

            const onRowSelected = (items) => {
                if (items.length > 0) {
                    soStageDetails.value.id = items[0]._id
                    soStageDetails.value.salesOrderId = items[0].salesOrderId
                    soStageDetails.value.stage = items[0].stage ?? null
                    soStageDetails.value.requireDays = items[0].requireDays ?? null
                    soStageDetails.value.stageDetails = items[0].stageDetails ?? null
                    soStageDetails.value.responsibleUser = items[0].responsibleUser ?? null
                    soStageDetails.value.startDate = items[0].startDate ?? null
                    soStageDetails.value.endDate = items[0].endDate ?? null
                    soStageDetails.value.status = items[0].status ?? null
                    buttonText.value = 'Update'
                } else {
                    soStageDetails.value.id = null
                    soStageDetails.value.stage = null
                    soStageDetails.value.requireDays = null
                    soStageDetails.value.stageDetails = null
                    soStageDetails.value.responsibleUser = null
                    soStageDetails.value.startDate = null
                    soStageDetails.value.endDate = null
                    soStageDetails.value.status = null
                }
            }

            const submitForm = async () => {
                if (soStageDetails.value.id === null) {
                    await store.dispatch('sales-order-module/addSalesOrderStage', soStageDetails.value).then(res => {
                        if (res.data.status === 200) {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Sales Order Stage Added',
                                    icon: 'ThumbsUpIcon',
                                    variant: 'success',
                                    text: 'Sales Order Stage Added Successfully!',
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
                } else {
                    await store.dispatch('sales-order-module/updateSalesOrderStage', soStageDetails.value).then(res => {
                        if (res.data.status === 200) {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Sales Order Stage Updated',
                                    icon: 'ThumbsUpIcon',
                                    variant: 'success',
                                    text: 'Sales Order Stage Updated Successfully!',
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
                soStageDetails.value.id = null
                soStageDetails.value.stage = null
                soStageDetails.value.requireDays = null
                soStageDetails.value.stageDetails = null
                soStageDetails.value.responsibleUser = null
                soStageDetails.value.startDate = null
                soStageDetails.value.endDate = null
                soStageDetails.value.status = null
                await fetchData()
            }

            const deleteStage = async (id) => {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Name is already exist",
                    icon: 'warning',
                    showCancelButton: true,
                    showDenyButton: false,
                    confirmButtonText: 'Yes, delete It!',
                    denyButtonText: 'No, Decline!',
                    cancelButtonText: 'Cancel',
                    customClass: {
                        confirmButton: 'btn btn-outline-success',
                        cancelButton: 'btn btn-outline-danger ml-1',
                        denyButton: 'btn btn-outline-warning ml-1',
                    },
                    buttonsStyling: false,
                }).then(result => {
                    if (result.isConfirmed) {
                        store.dispatch('sales-order-module/deleteSalesOrderStage', {id: id}).then(res => {
                            if (res.data.status === 200) {
                                toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: 'Sales Order Stage Deleted',
                                        icon: 'ThumbsUpIcon',
                                        variant: 'success',
                                        text: 'Sales Order Stage Deleted Successfully!',
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
                        fetchData()
                    }
                    if (result.isDismissed) {
                        toast({
                            component: ToastificationContent,
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

            const dateFormat = ref({
                date: true,
                delimiter: '/',
                datePattern: ['d', 'm', 'Y'],
            })

            const formatDates = ref({
                startDate: null,
                endDate: null,
            })

            const getStartFormatDate = (date) => {
                soStageDetails.value.startDate = forMatIndianDate(date)
            }

            const getEndFormatDate = (date) => {
                soStageDetails.value.endDate = forMatIndianDate(date)
            }

            return {
                stageOptions,
                usersOptions,
                statusOptions,
                tableData,
                soStageDetails,
                submitForm,
                fetchData,
                deleteStage,
                buttonText,
                dateFormat,
                formatDates,
                getStartFormatDate,
                getEndFormatDate,

                numeric,
                required,
                onRowSelected
            }
        }
    }
</script>
