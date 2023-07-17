<template>
    <div>
        <!-- table Data -->
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
                    selectable
                    select-mode="single"
                    @row-selected="onRowSelect"
                >
                    <!--Loader-->
                    <template #table-busy>
                        <div class="text-center my-2">
                            <b-spinner class="align-middle"></b-spinner>
                            <strong>Loading...</strong>
                        </div>
                    </template>
                    <!-- A virtual column -->
                    <template #cell(index)="data">
                        {{ data.index + 1 }}
                    </template>

                    <!-- A custom formatted column -->
                    <template #cell(processDesc)="data">
                        <span class="text-nowrap">{{ data.value}}</span>
                    </template>

                    <!-- A custom formatted column -->
                    <template #cell(action)="data">
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
                            <b-dropdown-item @click="deleteProcessData(data.item._id)">
                                <feather-icon
                                    icon="TrashIcon"
                                    class="mr-50"
                                />
                                <span>Delete</span>
                            </b-dropdown-item>
                        </b-dropdown>
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
            </b-col>
        </b-row>
        <!-- table close-->
        <!--Modal-->
        <validation-observer #default="{handleSubmit}">
            <b-form @submit.prevent="handleSubmit(saveProcessInSideSideData)">
                <b-row>
                    <b-col cols="12" class="mb-2">
                        <h5>Process Inside Details</h5>
                        <hr>
                    </b-col>
                    <b-col md="6">
                        <validation-provider
                            #default="validationContext"
                            name="Operator Name"
                            rules="required"
                        >
                            <b-form-group
                                label="Operator Name"
                                label-for="operatorName"
                            >
                                <v-select
                                    v-model="formDataProcess.InSideOperatorName"
                                    placeholder="Select Process"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="processDesOptions"
                                    :reduce="val => val.value"
                                    :clearable="false"
                                    input-id="InSideOperatorName"
                                    :state="getValidationState(validationContext)"
                                />
                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>

                        <!--  radio Buttons-->
                        <b-row>
                            <b-col md="12">
                                <b-form-group
                                    label="Type"
                                    label-for="selectType"
                                >
                                    <div class="demo-inline-spacing">
                                        <b-form-radio
                                            name="selectBatch"
                                            value="1"
                                            v-model="formDataProcess.selectBatch"
                                        >
                                            New
                                        </b-form-radio>
                                        <b-form-radio
                                            name="selectBatch"
                                            value="2"
                                            v-model="formDataProcess.selectBatch"
                                        >
                                            ReWork
                                        </b-form-radio>
                                    </div>
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="6">
                                <validation-provider
                                    #default="validationContext"
                                    name="Date"
                                    rules="required"
                                >
                                    <b-form-group
                                        label="Date"
                                        label-for="operatorDate"
                                    >
                                        <b-input-group>
                                            <cleave
                                                id="InSideOperatorDate"
                                                v-model="formDataProcess.InSideOperatorDate"
                                                class="form-control"
                                                :raw="false"
                                                :options="dateFormat"
                                                placeholder="DD/MM/YYYY"
                                                show-decade-nav
                                            />
                                            <b-input-group-append>
                                                <b-form-datepicker
                                                    v-model="formatDates.InSideOperatorDate"
                                                    button-only
                                                    @input="getInSideOperatorFormatDate($event)"
                                                    show-decade-nav
                                                    size="sm"
                                                    nav-button-variant="primary"
                                                />
                                            </b-input-group-append>
                                        </b-input-group>
                                        <b-form-invalid-feedback>
                                            {{ validationContext.errors[0] }}
                                        </b-form-invalid-feedback>
                                    </b-form-group>
                                </validation-provider>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Total Availabel Qty"
                                    label-for="totalAvlQty"
                                >
                                    <b-form-input
                                        v-model="formDataProcess.InSideTotalAvlQty"
                                        id="InSideTotalAvlQty"
                                        type="number"
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="6">
                                <b-form-group
                                    label="Issue Quantity"
                                    label-for="issueQty"
                                >
                                    <b-form-input
                                        v-model="formDataProcess.InSideIssueQty"
                                        id="InSideIssueQty"
                                        type="number"
                                        min="0"
                                        :max="formDataProcess.InSideTotalAvlQty"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Process Cost"
                                    label-for="processCost"
                                >
                                    <b-form-input
                                        v-model="formDataProcess.inSideProcessCost"
                                        id="inSideProcessCost"
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>
                    </b-col>

                    <b-col md="6">
                        <b-row>
                            <b-col md="6">
                                <b-form-group
                                    label="Accept Quntity"
                                    label-for="acceptQty"
                                >
                                    <b-form-input
                                        v-model="formDataProcess.inSideAcceptQty"
                                        id="inSideAcceptQty"
                                        type="number"
                                        readonly
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Reject Qty"
                                    label-for="rejectQty"
                                >
                                    <b-form-input
                                        v-model="formDataProcess.inSideRejectQty"
                                        id="inSideRejectQty"
                                        type="number"
                                        readonly
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="6">
                                <b-form-group
                                    label="No Of Hr"
                                    label-for="noOfHr"
                                >
                                    <b-form-input
                                        v-model="formDataProcess.inSideNoOfHr"
                                        id="inSideNoOfHr"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="R/W Qty"
                                    label-for="rwQty"
                                >
                                    <b-form-input
                                        v-model="formDataProcess.inSideRwQty"
                                        id="inSideRwQty"
                                        type="number"
                                        readonly
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-form-group
                            label="Remark"
                            label-for="processRemark"
                        >
                            <b-form-textarea
                                v-model="formDataProcess.inSideRemark"
                                id="inSideRemark"
                            />
                        </b-form-group>
                    </b-col>
                    <hr>
                    <!-- Button-->
                    <b-col md="12">
                        <hr>
                    </b-col>
                </b-row>
                <b-row>
                    <b-col md="6">
                        <b-form-group
                            label="M/C"
                            label-for="machineNo"
                        >
                            <v-select
                                v-model="formDataProcess.InSideMachineNo"
                                placeholder="Select Machine"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="machineOptions"
                                :reduce="val => val.value"
                                :clearable="false"
                                input-id="InSideMachineNo"
                            />
                        </b-form-group>
                    </b-col>
                </b-row>
                <b-row>
                    <b-col md="2"></b-col>
                    <b-col md="3">
                        <b-form-group
                            label="Standard"
                            label-for="standard"
                        ></b-form-group>
                    </b-col>
                    <b-col md="3">
                        <b-form-group
                            label="Standard Total"
                            label-for="standardTotal"
                        ></b-form-group>
                    </b-col>
                    <b-col md="2">
                        <b-form-group
                            label="Actual"
                            label-for="actual"
                        ></b-form-group>
                    </b-col>
                    <b-col md="2">
                        <b-form-group
                            label="Difference"
                            label-for="difference"
                        ></b-form-group>
                    </b-col>
                </b-row>
                <b-row>
                    <b-col md="2">
                        <b-form-group
                            label="Setup Time(Min.)"
                            label-for="setupTime"
                        ></b-form-group>
                    </b-col>
                    <b-col md="3">
                        <b-form-input
                            v-model="formDataProcess.standardSetTime"
                            id="standardSetTime"
                            type="number"
                            @keyup="calculateTimeAmount"

                        />
                    </b-col>
                    <b-col md="3">
                        <b-form-input
                            v-model="formDataProcess.standardTotalSetTime"
                            id="standardTotalSetTime"
                            type="number"
                            @keyup="calculateTimeAmount"
                        />
                    </b-col>
                    <b-col md="2">
                        <b-form-input
                            v-model="formDataProcess.actualSetTime"
                            id="actualSetTime"
                            type="number"
                            @keyup="calculateTimeAmount"
                        />
                    </b-col>
                    <b-col md="2">
                        <b-form-input
                            v-model="formDataProcess.differenceSetTime"
                            id="differenceSetTime"
                            type="number"
                        />
                    </b-col>
                </b-row>
                <br>
                <b-row>
                    <b-col md="2">
                        <b-form-group
                            label="Process Time(Min.)"
                            label-for="processTime"
                        ></b-form-group>
                    </b-col>
                    <b-col md="3">
                        <b-form-input
                            v-model="formDataProcess.standardProcessTime"
                            id="standardProcessTime"
                            type="number"
                            @keyup="calculateTimeAmount"
                        />
                    </b-col>
                    <b-col md="3">
                        <b-form-input
                            v-model="formDataProcess.standardTotalProcessTime"
                            id="standardTotalProcessTime"
                            type="number"
                            @keyup="calculateTimeAmount"
                        />
                    </b-col>
                    <b-col md="2">
                        <b-form-input
                            v-model="formDataProcess.actualProcessTime"
                            id="actualProcessTime"
                            type="number"
                            @keyup="calculateTimeAmount"
                        />
                    </b-col>
                    <b-col md="2">
                        <b-form-input
                            v-model="formDataProcess.differenceProcessTime"
                            id="differenceProcessTime"
                            type="number"
                        />
                    </b-col>
                </b-row>
                <br>
                <b-row>
                    <b-col md="2">
                        <b-form-group
                            label="Total Time(Min.)"
                            label-for="processTime"
                        ></b-form-group>
                    </b-col>
                    <b-col md="3">
                        <b-form-input
                            v-model="formDataProcess.standardTotalTime"
                            id="standardTotalTime"
                            type="number"
                        />
                    </b-col>
                    <b-col md="3">
                        <b-form-input
                            v-model="formDataProcess.standardTotalTolTime"
                            id="standardTotalTolTime"
                            type="number"
                        />
                    </b-col>
                    <b-col md="2">
                        <b-form-input
                            v-model="formDataProcess.actualTotalTime"
                            id="actualTotalTime"
                            type="number"
                        />
                    </b-col>
                    <b-col md="2">
                        <b-form-input
                            v-model="formDataProcess.differenceTotalTime"
                            id="differenceTotalTime"
                            type="number"
                        />
                    </b-col>
                    <b-col md="1"></b-col>
                </b-row>
                <br>
                <b-row>
                    <b-col md="2">
                        <b-form-group
                            label="Process Cost/Hr"
                            label-for="processCost"
                        ></b-form-group>
                    </b-col>
                    <b-col md="2">
                        <b-form-input
                            v-model="formDataProcess.standardProcess"
                            id="standardProcess"
                            type="number"
                            @keyup="calculateProcessCost"
                        />
                    </b-col>
                    <b-col md="0.5"></b-col>
                    <b-col md="1.5">
                        <b-form-group
                            label="Access Qty"
                            label-for="accessQty"
                        ></b-form-group>
                    </b-col>
                    <b-col md="3">
                        <b-form-input
                            v-model="formDataProcess.accessQty"
                            id="accessQty"
                            type="number"
                        />
                    </b-col>
                    <b-col md="3">
                        <b-button
                            class="mb"
                            variant="primary"
                        >
                            Generate Access Qty
                        </b-button>
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
        BFormInvalidFeedback,
        BFormRadio,
        BFormTextarea,
        BFormDatepicker,
        BInputGroup,
        BInputGroupAppend,
        BTable,
        BSpinner,
        BDropdown,
        BDropdownItem
    } from 'bootstrap-vue'
    import {ValidationObserver, ValidationProvider} from 'vee-validate'
    import {onUnmounted, ref, computed} from "@vue/composition-api";
    import axios from '@axios'
    import router from "@/router";
    import {getTcTodayDate, forMatIndianDate} from "@core/utils/utils";
    import formValidation from '@core/comp-functions/forms/form-validation'
    import {required} from '@validations'
    import vSelect from 'vue-select'
    import Cleave from 'vue-cleave-component'
    import jobCardStoreModule from "../../jobCardStoreModule";
    import {useToast} from "vue-toastification/composition";
    import store from '@/store'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import Swal from "sweetalert2";

    export default {
        components: {
            ValidationObserver,
            ValidationProvider,
            BForm,
            BFormGroup,
            BFormInput,
            BRow,
            BCol,
            BButton,
            vSelect,
            BFormInvalidFeedback,
            BFormRadio,
            BFormTextarea,
            BInputGroup,
            BInputGroupAppend,
            BFormDatepicker,
            Cleave,
            BTable,
            BSpinner,
            BDropdown,
            BDropdownItem,
        },
        props: {
            jobQty: {
                required: true
            },
            processNumber: {
                required: true
            }
        },
        setup(props) {
            const isBusy = ref(false)
            const toast = useToast()

            const SE_APP_STORE_MODULE_NAME = 'job-card-process-detail'
            if (!store.hasModule(SE_APP_STORE_MODULE_NAME)) store.registerModule(SE_APP_STORE_MODULE_NAME, jobCardStoreModule)
            onUnmounted(() => {
                if (store.hasModule(SE_APP_STORE_MODULE_NAME)) store.unregisterModule(SE_APP_STORE_MODULE_NAME)
            })
            const currentJobQty = computed(() => props.jobQty)
            const currentProcessNumber = computed(() => props.processNumber)

            const processDesOptions = ref([])
            axios.get('/api/new/get-operator-master-option').then(res => {
                // console.log(res.data.data)
                processDesOptions.value = res.data.data
            })
            const machineOptions = ref([])
            axios.get('/api/new/get-machine-master-option').then(res => {
                machineOptions.value = res.data.data
            })
            //table Process Details
            const itemsField = ref([
                {
                    key: 'rowSelected',
                    label: ''
                },
                {
                    key: 'index',
                    label: 'No'
                },
                {
                    key: 'operator_name.operatorName',
                    label: 'Operator Name',
                },
                {
                    key: 'InSideOperatorDate',
                    label: 'Date'
                },
                {
                    key: 'InSideTotalAvlQty',
                    label: 'Total Qty'
                },
                {
                    key: 'InSideIssueQty',
                    label: 'Issue Qty'
                },
                {
                    key: 'machine_number.machineName',
                    label: 'Machine No '
                },
                {
                    key: 'action',
                    label: 'Action'
                },
            ])
            const itemsData = ref([])

            const dateFormat = ref({
                date: true,
                delimiter: '/',
                datePattern: ['d', 'm', 'Y'],
            })

            const formatDates = ref({
                InSideOperatorDate: null,
            })

            const getInSideOperatorFormatDate = (date) => {
                formDataProcess.value.InSideOperatorDate = forMatIndianDate(date)
            }

            const blankFormData = {
                _id: null,
                jobId: router.currentRoute.params.id,
                InSideOperatorName: null,
                selectBatch: null,
                InSideOperatorDate: forMatIndianDate(getTcTodayDate()),
                InSideTotalAvlQty: currentJobQty.value,
                InSideIssueQty: 0,
                inSideAcceptQty: 0,
                inSideRejectQty: 0,
                inSideNoOfHr: 0,
                inSideRwQty: 0,
                inSideProcessCost: 0,
                inSideRemark: null,
                InSideMachineNo: null,
                standardSetTime: 0,
                standardTotalSetTime: 0,
                actualSetTime: 0,
                differenceSetTime: 0,
                standardProcessTime: 0,
                standardTotalProcessTime: 0,
                actualProcessTime: 0,
                differenceProcessTime: 0,
                standardTotalTime: 0,
                standardTotalTolTime: 0,
                actualTotalTime: 0,
                differenceTotalTime: 0,
                standardProcess: 0,
                accessQty: 0,
            }
            const refetchData = async () => {
                isBusy.value = true
                await axios.get(`/api/new/get-process-inside/${router.currentRoute.params.id}`).then(res => {
                    itemsData.value = res.data.data
                })
                isBusy.value = false
            }
            refetchData()

            const onRowSelect = (items) => {
                if (items.length > 0) {
                    formDataProcess.value._id = items[0]._id
                    formDataProcess.value.InSideOperatorName = items[0].InSideOperatorName ?? null
                    formDataProcess.value.selectBatch = items[0].selectBatch ?? null
                    formDataProcess.value.InSideOperatorDate = items[0].InSideOperatorDate ?? null
                    formDataProcess.value.InSideTotalAvlQty = items[0].InSideTotalAvlQty ?? null
                    formDataProcess.value.InSideIssueQty = items[0].InSideIssueQty ?? null
                    formDataProcess.value.inSideAcceptQty = items[0].inSideAcceptQty ?? null
                    formDataProcess.value.inSideRejectQty = items[0].inSideRejectQty ?? null
                    formDataProcess.value.inSideNoOfHr = items[0].inSideNoOfHr ?? null
                    formDataProcess.value.inSideRwQty = items[0].inSideRwQty ?? null
                    formDataProcess.value.inSideProcessCost = items[0].inSideProcessCost ?? null
                    formDataProcess.value.inSideRemark = items[0].inSideRemark ?? null
                    formDataProcess.value.InSideMachineNo = items[0].InSideMachineNo ?? null
                    formDataProcess.value.standardSetTime = items[0].standardSetTime ?? null
                    formDataProcess.value.standardTotalSetTime = items[0].standardTotalSetTime ?? null
                    formDataProcess.value.differenceSetTime = items[0].differenceSetTime ?? null
                    formDataProcess.value.standardProcessTime = items[0].standardProcessTime ?? null
                    formDataProcess.value.standardTotalProcessTime = items[0].standardTotalProcessTime ?? null
                    formDataProcess.value.differenceProcessTime = items[0].differenceProcessTime ?? null
                    formDataProcess.value.standardTotalTime = items[0].standardTotalTime ?? null
                    formDataProcess.value.standardTotalTolTime = items[0].standardTotalTolTime ?? null
                    formDataProcess.value.actualTotalTime = items[0].actualTotalTime ?? null
                    formDataProcess.value.differenceTotalTime = items[0].differenceTotalTime ?? null
                    formDataProcess.value.standardProcess = items[0].standardProcess ?? null
                    formDataProcess.value.accessQty = items[0].accessQty ?? null
                } else {
                    resetFormData()
                }
            }

            const formDataProcess = ref(JSON.parse(JSON.stringify(blankFormData)))

            const resetFormData = () => {
                formDataProcess.value = JSON.parse(JSON.stringify(blankFormData))
            }

            const deleteProcessData = async (id) => {
                await Swal.fire({
                    title: 'Are you sure?',
                    text: "Delete Job Card Process Inside",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, do it!',
                    cancelButtonText: 'No, keep it!',
                    customClass: {
                        confirmButton: 'btn btn-primary',
                        cancelButton: 'btn btn-outline-danger ml-1',
                    },
                    buttonsStyling: false,
                }).then(result => {
                    if (result.value) {
                        store.dispatch('job-card-process-detail/deleteJobCardProcessInSide', {id: id}).then(res => {
                            if (res.status === 200) {
                                toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: 'Job Card  Process Inside Deleted',
                                        icon: 'CheckSquareIcon',
                                        variant: 'success',
                                        text: `You have successfully Deleted Job Card  Process Inside.`,
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
                        resetFormData()
                        refetchData()
                    }
                })
            }

            const saveProcessInSideSideData = async () => {
                if (formDataProcess.value._id === null) {
                    await store.dispatch('job-card-process-detail/addJobCardProcessInSide', formDataProcess.value).then(res => {
                        console.log(res.data.data)
                        if (res.status === 200) {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Job Card Proces Inside Added',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: 'You have successfully Added Job Card Proces Inside',
                                },
                            })
                        } else {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Something went wrong',
                                    icon: 'AlertCircleIcon',
                                    variant: 'danger',
                                    text: 'Something went wrong',
                                },
                            })
                        }
                    })
                } else {
                    await store.dispatch('job-card-process-detail/updateJobCardProcessInSide', formDataProcess.value).then(res => {
                        if (res.status === 200) {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Job Card Process Inside Updated',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: `You have successfully Update Job Card Process Inside.`,
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
                resetFormData()
                await refetchData()
            }

            const getProcessDetails = async () => {
                await setTimeout(async () => {
                    await axios.get(`/api/get-process-sheet-by-number/${currentProcessNumber.value}`).then((res) => {
                        if(res.data.item_details) {
                            let itemDetails = res.data.item_details, setUpTime = 0, processTime = 0, processRate = 0;
                            itemDetails.forEach((item) => {
                                setUpTime += parseFloat(item.setupTimeInMinute)
                                processTime += parseFloat(item.processTimeInMinute)
                                processRate += parseFloat(item.processRate)
                            });

                            formDataProcess.value.standardSetTime = setUpTime;
                            formDataProcess.value.standardProcessTime = processTime;
                            formDataProcess.value.standardProcess = processRate;
                        }
                    });
                    await calculateTimeAmount();
                }, 1000)
            }
            getProcessDetails()

            const calculateTimeAmount = async () => {
                /*setup M to actual M Difference*/
                formDataProcess.value.standardTotalSetTime = formDataProcess.value.standardSetTime
                formDataProcess.value.differenceSetTime = parseFloat(formDataProcess.value.actualSetTime) - parseFloat(formDataProcess.value.standardSetTime)
                /*Process M to actual M Difference*/
                formDataProcess.value.standardTotalProcessTime = formDataProcess.value.standardProcessTime
                formDataProcess.value.differenceProcessTime = parseFloat(formDataProcess.value.actualProcessTime) - parseFloat(formDataProcess.value.standardTotalProcessTime)
                /*total of timing*/
                formDataProcess.value.standardTotalTime = parseFloat(formDataProcess.value.standardSetTime) + parseFloat(formDataProcess.value.standardProcessTime)
                formDataProcess.value.standardTotalTolTime = parseFloat(formDataProcess.value.standardTotalSetTime) + parseFloat(formDataProcess.value.standardTotalProcessTime)
                formDataProcess.value.actualTotalTime = parseFloat(formDataProcess.value.actualSetTime) + parseFloat(formDataProcess.value.actualProcessTime)
                // formDataProcess.value.differenceTotalTime = parseFloat(formDataProcess.value.differenceSetTime) + parseFloat(formDataProcess.value.differenceProcessTime)
                formDataProcess.value.actualTotalTime = parseFloat(parseFloat(formDataProcess.value.actualSetTime) / parseFloat(formDataProcess.value.InSideTotalAvlQty) + parseFloat(formDataProcess.value.actualProcessTime)).toFixed(2);
                await calculateProcessCost();
            }

            const calculateProcessCost = async () => {
                formDataProcess.value.inSideProcessCost = parseFloat(parseFloat(formDataProcess.value.actualTotalTime) * parseFloat(formDataProcess.value.standardProcess) / 60).toFixed(2);
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
                processDesOptions,
                formDataProcess,
                required,
                machineOptions,
                calculateTimeAmount,
                dateFormat,
                formatDates,
                getInSideOperatorFormatDate,
                saveProcessInSideSideData,
                refetchData,
                isBusy,
                itemsData,
                itemsField,
                deleteProcessData,
                calculateProcessCost,
                // getProcessDetails
                onRowSelect
            }
        }
    }
</script>

<style lang="scss">
    @import '~@core/scss/vue/libs/vue-sweetalert.scss';
</style>
