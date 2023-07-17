<template>
    <div>
        <b-row>
            <b-col md="12">
                <hr>
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
                    <!--                    class="table_scroll"-->
                    <!-- Loader -->
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
                            <b-dropdown-item @click="deleteProcessOutData(data.item._id)">
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
            </b-col>
        </b-row>
        <hr>
        <validation-observer #default="{handleSubmit}">
            <b-form @submit.prevent="handleSubmit(saveFormData)">
                <b-col md="10">
                    <b-form-group
                        label="Select Sub-Contractor"
                        label-for="selectSubContractor"
                    >
                        <div class="demo-inline-spacing">
                            <b-form-radio
                                name="OutSideSelectBatch"
                                value="1"
                                v-model="formDataProcessOut.OutSideSelectBatch"
                                @change="getPartyList($event)"
                            >
                                Party Master
                            </b-form-radio>
                            <b-form-radio
                                name="OutSideSelectBatch"
                                value="2"
                                v-model="formDataProcessOut.OutSideSelectBatch"
                                @change="getPartyList($event)"
                            >
                                Job Work Rate Master
                            </b-form-radio>
                        </div>
                    </b-form-group>
                </b-col>
                <br>
                <b-row>
                    <b-col md="6">
                        <b-row>
                            <b-col md="6">
                                <validation-provider
                                    #default="validationContext"
                                    name="Sub-Contractor Code"
                                    rules="required"
                                >
                                    <b-form-group
                                        label="Sub-Contractor Code"
                                        label-for="subContractorCode"
                                    >
                                        <v-select
                                            placeholder="Select No"
                                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                            :options="subContractorOption"
                                            :reduce="val => val.value"
                                            :clearable="false"
                                            input-id="subContractorCode"
                                            v-model="formDataProcessOut.OutSideSubContractorCode"
                                            @input="getSubContrctorDetails($event)"
                                            :state="getValidationState(validationContext)"
                                        />
                                        <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                            {{validationContext.errors[0]}}
                                        </b-form-invalid-feedback>
                                    </b-form-group>
                                </validation-provider>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Sub-Contractor Name"
                                    label-for="subContractorName"
                                >
                                    <b-form-input
                                        id="subContractorName"
                                        v-model="formDataProcessOut.OutSideSubContractorName"
                                        readonly
                                    />
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
                                                id="operatorDate"
                                                v-model="formDataProcessOut.OutSideOperatorDate"
                                                class="form-control"
                                                :raw="false"
                                                :options="dateFormat"
                                                placeholder="DD/MM/YYYY"
                                                show-decade-nav
                                            />
                                            <b-input-group-append>
                                                <b-form-datepicker
                                                    v-model="formatDates.OutSideOperatorDate"
                                                    button-only
                                                    @input="getOperatorFormateDate($event)"
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
                                    label="Challan No"
                                    label-for="challanNo"
                                >
                                    <b-form-input
                                        v-model="formDataProcessOut.outSideChallanNo"
                                        id="challanNo"
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="6">
                                <b-form-group
                                    label="Issue Quntity"
                                    label-for="issueQty"
                                >
                                    <b-form-input
                                        v-model="formDataProcessOut.outSideIssueQty"
                                        id="outSideIssueQty"
                                        type="number"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Total Availabel Qty"
                                    label-for="totalAvlQty"
                                >
                                    <b-form-input
                                        v-model="formDataProcessOut.outSideTotalAvlQty"
                                        id="outSideTotalAvlQty"
                                        type="number"
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
                                        v-model="formDataProcessOut.outSideAcceptQty"
                                        id="outSideAcceptQty"
                                        type="number"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Reject Qty"
                                    label-for="rejectQty"
                                >
                                    <b-form-input
                                        v-model="formDataProcessOut.outSideRejectQty"
                                        id="outSideRejectQty"
                                        type="number"
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="6">
                                <b-form-group
                                    label="Process Cost"
                                    label-for="processCost"
                                >
                                    <b-form-input
                                        v-model="formDataProcessOut.outSideProcessCost"
                                        id="outSideProcessCost"
                                        type="number"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="R/W Qty"
                                    label-for="rwQty"
                                >
                                    <b-form-input
                                        v-model="formDataProcessOut.outSideRwQty"
                                        id="outSideRwQty"
                                        type="number"
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-form-group
                            label="Remark"
                            label-for="processRemark"
                        >
                            <b-form-textarea
                                v-model="formDataProcessOut.outSideRemark"
                                id="outSideRemark"
                            />
                        </b-form-group>
                    </b-col>
                </b-row>
                <hr>
                <b-row>
                    <b-col md="12">
                        <hr>
                        <h5>Report</h5>
                        <hr>
                    </b-col>
                </b-row>
                <b-row>
                    <b-col md="3">
                        <b-form-checkbox>
                            Origibnal for Recipient
                        </b-form-checkbox>
                    </b-col>
                    <b-col md="3">
                        <b-form-checkbox>
                            Duplicate For Transpoter
                        </b-form-checkbox>
                    </b-col>
                    <b-col md="3">
                        <b-form-checkbox>
                            Triplicate For Supplier
                        </b-form-checkbox>
                    </b-col>
                    <b-col md="3"></b-col>
                </b-row>
                <br>
                <b-row>
                    <b-col md="2">
                        <b-form-checkbox>
                            Formate2
                        </b-form-checkbox>
                    </b-col>
                    <b-col md="2">
                        <b-form-checkbox>
                            With Conv
                        </b-form-checkbox>
                    </b-col>
                    <b-col md="4">
                        <b-form-checkbox>
                            Report With Only Issue Items
                        </b-form-checkbox>
                    </b-col>
                    <b-col md="4">
                        <b-form-checkbox>
                            Print First Process Issue Items
                        </b-form-checkbox>
                    </b-col>
                </b-row>
                <br>
                <b-row>
                    <b-col md="4">
                        <b-form-group
                            label="Page"
                            label-for="page"
                        >
                            <v-select
                                placeholder="Select Page"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="pageOption"
                                :reduce="val => val.value"
                                :clearable="false"
                                input-id="page"
                            />
                        </b-form-group>
                    </b-col>
                </b-row>
                <b-row>
                    <b-col class="d-flex mt-1">
                        <b-form-checkbox
                        >
                            Header Image
                        </b-form-checkbox>
                        <b-form-checkbox
                            class="ml-2"
                        >
                            Footer Image
                        </b-form-checkbox>
                    </b-col>
                </b-row>
                <br>
                <b-row>
                    <b-col md="3"></b-col>
                    <b-col md="3">
                        <b-button
                            class="float-right"
                            variant="primary"
                        >
                            Generate Challan
                        </b-button>
                    </b-col>
                    <b-col md="3">
                        <b-button
                            class="float-right"
                            variant="primary"
                        >
                            Preview Challan
                        </b-button>
                    </b-col>
                    <b-col md="3">
                        <b-button
                            class="float-right"
                            variant="primary"
                        >
                            Preview Issue Slip
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
        BCol,
        BRow,
        BForm,
        BFormGroup,
        BFormInput,
        BFormTextarea,
        BButton,
        BFormDatepicker,
        BTable,
        BSpinner,
        BDropdown,
        BDropdownItem,
        BFormInvalidFeedback,
        BFormRadio,
        BFormCheckbox,
        BInputGroup,
        BInputGroupAppend
    } from 'bootstrap-vue'
    import {onUnmounted, ref, computed} from "@vue/composition-api";
    import formValidation from '@core/comp-functions/forms/form-validation'
    import {ValidationProvider, ValidationObserver} from 'vee-validate'
    import {required} from '@validations'
    import axios from '@axios'
    import vSelect from 'vue-select'
    import router from '@/router'
    import {forMatIndianDate, getTcTodayDate} from "@core/utils/utils";
    import Cleave from 'vue-cleave-component'
    import {useToast} from "vue-toastification/composition";
    import jobCardStoreModule from "../../jobCardStoreModule";
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import store from '@/store'
    import Swal from "sweetalert2";

    export default {
        components: {
            ValidationProvider,
            ValidationObserver,
            BCol,
            BRow,
            BForm,
            BFormGroup,
            BFormInput,
            BFormTextarea,
            BButton,
            BFormDatepicker,
            BTable,
            BSpinner,
            BDropdown,
            BDropdownItem,
            BFormInvalidFeedback,
            BFormRadio,
            BFormCheckbox,
            BInputGroup,
            BInputGroupAppend,
            vSelect,
            Cleave
        },
        props: {
            itemCode: {
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

            const currentItemCode = computed(() => props.itemCode)

            const subContractorOption = ref([])
            axios.get('/api/party/get-master-options').then(res => {
                subContractorOption.value = res.data.data
            })

            const getSubContrctorDetails = async (id) => {
                await axios.get(`/api/party/edit/${id}`).then(res => {
                    formDataProcessOut.value.OutSideSubContractorName = res.data.data?.partyName ?? null
                })
            }
            const pageOption = ref([
                {label: 'Blank Page', value: 1},
                {label: 'Latter Pad', value: 2}
            ])
            const dateFormat = ref({
                date: true,
                delimiter: '/',
                datePattern: ['d', 'm', 'Y'],
            })

            const formatDates = ref({
                OutSideOperatorDate: null,
            })

            const getOperatorFormateDate = (date) => {
                formDataProcessOut.value.OutSideOperatorDate = forMatIndianDate(date)
            }

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
                    key: 'OutSideSubContractorName',
                    label: 'Sub-Contractor Name'
                },
                {
                    key: 'OutSideOperatorDate',
                    label: 'Date'
                },
                {
                    key: 'outSideIssueQty',
                    label: 'Issue Qty'
                },
                {
                    key: 'outSideAcceptQty',
                    label: 'Accept Qty'
                },
                {
                    key: 'outSideRejectQty',
                    label: 'Reject Qty'
                },
                {
                    key: 'outSideRwQty',
                    label: 'RW Qty'
                },
                {
                    key: 'action',
                    label: 'Action'
                },
            ])
            const itemsData = ref([])

            const blankFormData = {
                _id: null,
                jobId: router.currentRoute.params.id,
                OutSideSelectBatch: 1,
                OutSideSubContractorCode: null,
                OutSideSubContractorName: null,
                OutSideOperatorDate: forMatIndianDate(getTcTodayDate()),
                outSideChallanNo: null,
                outSideIssueQty: null,
                outSideTotalAvlQty: null,
                outSideAcceptQty: null,
                outSideRejectQty: null,
                outSideProcessCost: null,
                outSideRwQty: null,
                outSideRemark: null,
            }
            const formDataProcessOut = ref(JSON.parse(JSON.stringify(blankFormData)))

            const resetFormData = () => {
                formDataProcessOut.value = JSON.parse(JSON.stringify(blankFormData))
            }
            const refetchData = async () => {
                isBusy.value = true
                await axios.get(`/api/new/get-process-outside/${router.currentRoute.params.id}`).then(res => {
                    itemsData.value = res.data.data
                })
                isBusy.value = false
            }
            refetchData()

            const onRowSelect = (items) => {
                if (items.length > 0) {
                    formDataProcessOut.value._id = items[0]._id
                    formDataProcessOut.value.OutSideSelectBatch = items[0].OutSideSelectBatch ?? null
                    formDataProcessOut.value.OutSideSubContractorCode = items[0].OutSideSubContractorCode ?? null
                    formDataProcessOut.value.OutSideSubContractorName = items[0].OutSideSubContractorName ?? null
                    formDataProcessOut.value.OutSideOperatorDate = items[0].OutSideOperatorDate ?? null
                    formDataProcessOut.value.outSideChallanNo = items[0].outSideChallanNo ?? null
                    formDataProcessOut.value.outSideIssueQty = items[0].outSideIssueQty ?? null
                    formDataProcessOut.value.outSideTotalAvlQty = items[0].outSideTotalAvlQty ?? null
                    formDataProcessOut.value.outSideAcceptQty = items[0].outSideAcceptQty ?? null
                    formDataProcessOut.value.outSideRejectQty = items[0].outSideRejectQty ?? null
                    formDataProcessOut.value.outSideProcessCost = items[0].outSideProcessCost ?? null
                    formDataProcessOut.value.outSideRwQty = items[0].outSideRwQty ?? null
                    formDataProcessOut.value.outSideRemark = items[0].outSideRemark ?? null
                } else {
                    resetFormData()
                }
            }

            const deleteProcessOutData = async (id) => {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Delete Job Card Process OutSide",
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
                        store.dispatch('job-card-process-detail/deleteJobCardProcessOutSide', {id: id}).then(res => {
                            if (res.status === 200) {
                                toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: 'Job Card  Process OutSide Deleted',
                                        icon: 'CheckSquareIcon',
                                        variant: 'success',
                                        text: `You have successfully Deleted Job Card  Process OutSide.`,
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

            const saveFormData = async () => {
                if (formDataProcessOut.value._id === null) {
                    await store.dispatch('job-card-process-detail/addJobCardProcessOutSide', formDataProcessOut.value).then(res => {
                        if (res.status === 200) {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Job Card Process Added',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: 'You have successfully Added Job Card Process OutSide',
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
                    await store.dispatch('job-card-process-detail/updateJobCardProcessOutSide', formDataProcessOut.value).then(res => {
                        if (res.status === 200) {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Job Card Process OutSide Update',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: `You have successfully Update Job Card Process OutSide.`,
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

            const getPartyList = async (value) => {
                if (parseInt(value) === 1) {
                    await axios.get('/api/party/get-master-options').then(res => {
                        subContractorOption.value = res.data.data
                    })
                }
                if (parseInt(value) === 2) {
                    await axios.get(`/api/new/get-job-work-rate-contractor-by-item/${currentItemCode.value}`).then((res) => {
                        subContractorOption.value = res.data.data
                    })
                }
            }

            const {refFormObserver, getValidationState, resetForm} = formValidation(resetFormData)

            return {
                formDataProcessOut,
                refFormObserver,
                getValidationState,
                resetForm,
                resetFormData,
                deleteProcessOutData,
                saveFormData,
                subContractorOption,
                getSubContrctorDetails,
                pageOption,
                dateFormat,
                formatDates,
                getOperatorFormateDate,
                required,
                itemsField,
                itemsData,
                isBusy,
                getPartyList,
                onRowSelect
            }
        }
    }
</script>
