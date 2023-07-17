<template>
    <b-card-code>
        <b-overlay
            :show="showOverlayLoading"
            rounded="sm"
        >
            <b-row>
                <b-col md="12">
                    <b-table
                        responsive="sm"
                        :fields="bomProcessRows"
                        :items="bomProcessData"
                        :bordered="true"
                        :hover="true"
                        show-empty
                        class="table_scroll"
                        :busy="isBusy"
                    >
                        <!--Loader-->
                        <template #table-busy>
                            <div class="text-center my-2">
                                <b-spinner class="align-middle"></b-spinner>
                                <strong>Loading...</strong>
                            </div>
                        </template>

                        <!--Index-->
                        <template #cell(index)="data">
                            {{ data.index + 1 }}
                        </template>

                        <!--Action-->
                        <template
                            #cell(action)="data"
                        >
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
                                <b-dropdown-item @click="editBomVersionProcess(data.item)">
                                    <feather-icon
                                        icon="Edit2Icon"
                                        class="mr-50"
                                    />
                                    <span>Edit</span>
                                </b-dropdown-item>
                                <b-dropdown-item @click="deleteBomVersionProcess(data.item._id)">
                                    <feather-icon
                                        icon="TrashIcon"
                                        class="mr-50"
                                    />
                                    <span>Delete</span>
                                </b-dropdown-item>
                            </b-dropdown>
                        </template>
                    </b-table>
                    <hr>
                </b-col>
            </b-row>
            <validation-observer ref="simpleRules" #default="{ handleSubmit }">
                <b-form @submit.prevent="handleSubmit(submitFormData)">
                    <b-row>
                        <b-col md="12">
                            <hr>
                            <h5>Process Sheet Details</h5>
                            <hr>
                        </b-col>
                        <b-col md="4">
                            <validation-provider
                                #default="{ errors }"
                                name="Progress"
                                rules="required"
                            >
                                <b-form-group
                                    label="Progress"
                                    label-for="progress"
                                    :state="errors.length > 0 ? false : null"
                                >
                                    <v-select
                                        placeholder="Select Process"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="processOptions"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        input-id="progress"
                                        v-model="formData.progressId"
                                    />
                                    <small class="text-danger">{{ errors[0] }}</small>
                                </b-form-group>
                            </validation-provider>
<!--    @input="getProcessSheetListDetails($event)"
-->
                            <validation-provider
                                #default="validationContext"
                                name="Machine Number"
                                rules=""
                            >
                                <b-form-group
                                    label="Machine Number"
                                    label-for="machineNumber"
                                    :state="getValidationState(validationContext)"
                                >
                                    <b-form-input
                                        id="machineNumber"
                                        :state="getValidationState(validationContext)"
                                        v-model="formData.machineNumber"
                                    />
                                    <b-form-invalid-feedback>
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                            <validation-provider
                                #default="{ errors }"
                                name="Progress Description"
                                rules="required"
                            >
                                <b-form-group
                                    label="Progress Description"
                                    label-for="progressDescription"
                                >
                                    <b-form-input
                                        id="progressDescription"
                                        v-model="formData.progressDescription"
                                        :state="errors.length > 0 ? false : null"
                                    />
                                    <small class="text-danger">{{ errors[0] }}</small>
                                </b-form-group>
                            </validation-provider>
                            <validation-provider
                                #default="validationContext"
                                name="Jig/Fix No"
                                rules=""
                            >
                                <b-form-group
                                    label="Jig/Fix No"
                                    label-for="jigFixNumber"
                                    :state="getValidationState(validationContext)"
                                >
                                    <b-form-input
                                        id="jigFixNumber"
                                        :state="getValidationState(validationContext)"
                                        v-model="formData.jigFixNumber"
                                    />
                                    <b-form-invalid-feedback>
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                            <validation-provider
                                #default="validationContext"
                                name="Special Tool"
                                rules=""
                            >
                                <b-form-group
                                    label="Special Tool"
                                    label-for="specialTool"
                                    :state="getValidationState(validationContext)"
                                >
                                    <b-form-input
                                        id="specialTool"
                                        :state="getValidationState(validationContext)"
                                        v-model="formData.specialTool"
                                    />
                                    <b-form-invalid-feedback>
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                            <validation-provider
                                #default="validationContext"
                                name="Inspection Level"
                                rules=""
                            >
                                <b-form-group
                                    label="Inspection Level"
                                    label-for="inspectionLevel"
                                    :state="getValidationState(validationContext)"
                                >
                                    <b-form-input
                                        id="inspectionLevel"
                                        :state="getValidationState(validationContext)"
                                        v-model="formData.inspectionLevel"
                                    />
                                    <b-form-invalid-feedback>
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                            <validation-provider
                                #default="validationContext"
                                name="Measuring Device"
                                rules=""
                            >
                                <label for="measuringDevices" class="d-block">Measuring Device</label>
                                <b-input-group
                                    id="measuringDevices"
                                >
                                    <b-form-input
                                        v-model="formData.measuringDeviceLabel"
                                    />
                                    <b-form-input
                                        v-model="formData.measuringDevice"
                                    />
                                </b-input-group>
                            </validation-provider>
                        </b-col>
                        <b-col md="4">
                            <validation-provider
                                #default="validationContext"
                                name="QC Sample(%)"
                                rules=""
                            >
                                <b-form-group
                                    label="QC Sample(%)"
                                    label-for="qcSample"
                                    :state="getValidationState(validationContext)"
                                >
                                    <b-form-input
                                        id="qcSample"
                                        :state="getValidationState(validationContext)"
                                        v-model="formData.qcSample"
                                    />
                                    <b-form-invalid-feedback>
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                            <validation-provider
                                #default="validationContext"
                                name="Process Rate"
                                rules=""
                            >
                                <b-form-group
                                    label="Process Rate"
                                    label-for="processRate"
                                    :state="getValidationState(validationContext)"
                                >
                                    <b-form-input
                                        id="processRate"
                                        :state="getValidationState(validationContext)"
                                        v-model="formData.processRate"
                                    />
                                    <b-form-invalid-feedback>
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                            <validation-provider
                                #default="validationContext"
                                name="Days Require"
                                rules=""
                            >
                                <b-form-group
                                    label="Days Require"
                                    label-for="daysRequire"
                                    :state="getValidationState(validationContext)"
                                >
                                    <b-form-input
                                        id="daysRequire"
                                        :state="getValidationState(validationContext)"
                                        type="number"
                                        v-model="formData.daysRequire"
                                    />
                                    <b-form-invalid-feedback>
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                            <validation-provider
                                #default="validationContext"
                                name="Wt Loss(%)"
                                rules=""
                            >
                                <b-form-group
                                    label="Wt Loss(%)"
                                    label-for="wtLoss"
                                    :state="getValidationState(validationContext)"
                                >
                                    <b-form-input
                                        id="wtLoss"
                                        :state="getValidationState(validationContext)"
                                        v-model="formData.wtLoss"
                                    />
                                    <b-form-invalid-feedback>
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                            <validation-provider
                                #default="validationContext"
                                name="Mat. Wt."
                                rules=""
                            >
                                <b-form-group
                                    label="Mat. Wt."
                                    label-for="matWt"
                                    :state="getValidationState(validationContext)"
                                >
                                    <b-form-input
                                        id="matWt"
                                        :state="getValidationState(validationContext)"
                                        v-model="formData.matWt"
                                    />
                                    <b-form-invalid-feedback>
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                            <validation-provider
                                #default="validationContext"
                                name="Burning Loss (%)"
                                rules=""
                            >
                                <b-form-group
                                    label="Burning Loss (%)"
                                    label-for="burningLoss"
                                    :state="getValidationState(validationContext)"
                                >
                                    <b-form-input
                                        id="burningLoss"
                                        :state="getValidationState(validationContext)"
                                        v-model="formData.burningLoss"
                                    />
                                    <b-form-invalid-feedback>
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                        </b-col>
                        <b-col md="4">
                            <validation-provider
                                #default="validationContext"
                                name="Scrap Tolerance (%)"
                                rules=""
                            >
                                <b-form-group
                                    label="Scrap Tolerance (%)"
                                    label-for="scrapTolerance"
                                    :state="getValidationState(validationContext)"
                                >
                                    <b-form-input
                                        id="scrapTolerance"
                                        :state="getValidationState(validationContext)"
                                        v-model="formData.scrapTolerance"
                                    />
                                    <b-form-invalid-feedback>
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                            <validation-provider
                                #default="validationContext"
                                name="Inspection By"
                                rules=""
                            >
                                <b-form-group
                                    label="Inspection By"
                                    label-for="inspectionBy"
                                    :state="getValidationState(validationContext)"
                                >
                                    <b-form-input
                                        id="inspectionBy"
                                        :state="getValidationState(validationContext)"
                                        v-model="formData.inspectionBy"
                                    />
                                    <b-form-invalid-feedback>
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                            <validation-provider
                                #default="validationContext"
                                name="Insp. Instruction"
                                rules=""
                            >
                                <b-form-group
                                    label="Insp. Instruction"
                                    label-for="inspectionInstruction"
                                    :state="getValidationState(validationContext)"
                                >
                                    <b-form-textarea
                                        id="inspectionInstruction"
                                        :state="getValidationState(validationContext)"
                                        rows="2"
                                        v-model="formData.inspectionInstruction"
                                    />
                                    <b-form-invalid-feedback>
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                            <validation-provider
                                #default="validationContext"
                                name="Remark"
                                rules=""
                            >
                                <b-form-group
                                    label="Remark"
                                    label-for="remark"
                                    :state="getValidationState(validationContext)"
                                >
                                    <b-form-textarea
                                        id="remark"
                                        :state="getValidationState(validationContext)"
                                        rows="3"
                                        v-model="formData.remark"
                                    />
                                    <b-form-invalid-feedback>
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                        </b-col>
                        <b-col md="12">
                            <hr>
                        </b-col>
                        <b-col md="4">
                            <validation-provider
                                #default="validationContext"
                                name="Process Sheet No."
                                rules=""
                            >
                                <b-form-group
                                    label="Process Sheet No."
                                    label-for="processSheetNumber"
                                    :state="getValidationState(validationContext)"
                                >
                                    <b-form-input
                                        id="processSheetNumber"
                                        :state="getValidationState(validationContext)"
                                        v-model="formData.processSheetNumber"
                                    />
                                    <b-form-invalid-feedback>
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                        </b-col>
                        <b-col md="8">
                            <h5>Scrap Details</h5>
                            <hr>
                            <b-row>
                                <b-col md="4">
                                    <validation-provider
                                        #default="validationContext"
                                        name="Mat. Issue Wt."
                                        rules=""
                                    >
                                        <b-form-group
                                            label="Mat. Issue Wt."
                                            label-for="matIssueWt"
                                            :state="getValidationState(validationContext)"
                                        >
                                            <b-form-input
                                                id="matIssueWt"
                                                :state="getValidationState(validationContext)"
                                                v-model="formData.matIssueWt"
                                            />
                                            <b-form-invalid-feedback>
                                                {{ validationContext.errors[0] }}
                                            </b-form-invalid-feedback>
                                        </b-form-group>
                                    </validation-provider>
                                </b-col>
                                <b-col md="4">
                                    <validation-provider
                                        #default="validationContext"
                                        name="Scrap Qty."
                                        rules=""
                                    >
                                        <b-form-group
                                            label="Scrap Qty."
                                            label-for="scrapQty"
                                            :state="getValidationState(validationContext)"
                                        >
                                            <b-form-input
                                                id="scrapQty"
                                                :state="getValidationState(validationContext)"
                                                v-model="formData.scrapQty"
                                            />
                                            <b-form-invalid-feedback>
                                                {{ validationContext.errors[0] }}
                                            </b-form-invalid-feedback>
                                        </b-form-group>
                                    </validation-provider>
                                </b-col>
                                <b-col md="4">
                                    <validation-provider
                                        #default="validationContext"
                                        name="Scrap Code"
                                        rules=""
                                    >
                                        <b-form-group
                                            label="Scrap Code"
                                            label-for="scrapCode"
                                            :state="getValidationState(validationContext)"
                                        >
                                            <b-form-input
                                                id="scrapCode"
                                                :state="getValidationState(validationContext)"
                                                v-model="formData.scrapCode"
                                            />
                                            <b-form-invalid-feedback>
                                                {{ validationContext.errors[0] }}
                                            </b-form-invalid-feedback>
                                        </b-form-group>
                                    </validation-provider>
                                </b-col>
                            </b-row>
                        </b-col>
                        <b-col md="12">
                            <hr>
                            <b-button
                                variant="primary"
                                type="submit"
                            >
                                Save
                            </b-button>
                        </b-col>
                    </b-row>
                </b-form>
            </validation-observer>
        </b-overlay>
    </b-card-code>
</template>
<script>
import BCardCode from '@core/components/b-card-code'
import {ValidationProvider, ValidationObserver} from 'vee-validate'
import {
    BRow,
    BCol,
    BFormGroup,
    BFormInput,
    BInputGroup,
    BFormTextarea,
    BFormCheckbox,
    BForm,
    BButton,
    BFormDatepicker,
    BOverlay,
    BFormInvalidFeedback,
    BTable,
    BDropdown,
    BDropdownItem,
    BSpinner,
    BTabs,
    BTab
} from 'bootstrap-vue'
import {required} from '@validations'
import formValidation from '@core/comp-functions/forms/form-validation'
import Ripple from 'vue-ripple-directive'
import vSelect from 'vue-select'
import store from '@/store'
import router from '@/router'
import Toastification from '@core/components/toastification/ToastificationContent.vue'
import {useToast} from 'vue-toastification/composition'
import {ref, onUnmounted} from '@vue/composition-api'
import axios from '@axios'
import moment from 'moment'
import bomStoreModule from "../../bomStoreModule";
import Swal from 'sweetalert2'

export default {
    components: {
        BCardCode,
        ValidationProvider,
        ValidationObserver,
        BRow,
        BCol,
        BFormGroup,
        BFormInput,
        BFormCheckbox,
        BFormTextarea,
        BForm,
        BButton,
        BFormDatepicker,
        BOverlay,
        BFormInvalidFeedback,
        BTable,
        BDropdown,
        BDropdownItem,
        BSpinner,
        BTabs,
        BTab,
        BInputGroup,
        vSelect
    },
    setup() {
        const DM_APP_STORE_MODULE_NAME = 'bom-module'
        // Register module
        if (!store.hasModule(DM_APP_STORE_MODULE_NAME)) store.registerModule(DM_APP_STORE_MODULE_NAME, bomStoreModule)
        // UnRegister on leave
        /*onUnmounted(() => {
            if (store.hasModule(DM_APP_STORE_MODULE_NAME)) store.unregisterModule(DM_APP_STORE_MODULE_NAME)
        })*/
        const toast = useToast()

        const bomId = router.currentRoute.params.id
        const versionId = router.currentRoute.params.versionId

        const showOverlayLoading = ref(true)

        const isBusy = ref(true)

        const bomProcessRows = ref([
            {
                key: 'index',
                label: 'No'
            },
            {
                key: 'machineNumber',
                label: 'MachNo'
            },
            {
                key: 'progressDescription',
                label: 'Process'
            },
            {
                key: 'jigFixNumber',
                label: 'JigFix'
            },
            {
                key: 'specialTool',
                label: 'SpTools'
            },
            {
                key: 'inspectionLevel',
                label: 'Inspection'
            },
            {
                key: 'inspectionInstruction',
                label: 'InspInstruction'
            },
            {
                key: 'inspectionBy',
                label: 'InspBy'
            },
            {
                key: 'measuringDevice',
                label: 'MsgDevise'
            },
            {
                key: 'processRate',
                label: 'Rate'
            },
            {
                key: 'daysRequire',
                label: 'ReqDays'
            },
            {
                key: 'qcSample',
                label: 'Qc Sample'
            },
            {
                key: 'instCode',
                label: 'InstCode'
            },
            {
                key: 'burningLoss',
                label: 'Burning Loss'
            },
            {
                key: 'action',
                label: 'Action'
            }
        ])
        const bomProcessData = ref([])

        const processOptions = ref([])
        axios.get(`/api/get-process-master-option`).then(res => {
            processOptions.value = res.data.data
        });

        const refetchData = async () => {
            isBusy.value = true
            await axios.get(`/api/get-bom-version-process-data/${bomId}/${versionId}`).then(res => {
                bomProcessData.value = res.data.data
            })
            showOverlayLoading.value = false
            isBusy.value = false
        }
        refetchData()

        const blankFormData = {
            id: null,
            bomId: bomId,
            versionId: versionId,
            progressId: null,
            machineNumber: null,
            progressDescription: null,
            jigFixNumber: null,
            specialTool: null,
            inspectionLevel: null,
            measuringDeviceLabel: null,
            measuringDevice: null,
            qcSample: 0,
            processRate: 0,
            daysRequire: 0,
            wtLoss: 0,
            matWt: 0,
            burningLoss: 0,
            scrapTolerance: 0,
            inspectionBy: null,
            remark: null,
            inspectionInstruction: null,
            processSheetNumber: null,
            matIssueWt: null,
            scrapQty: null,
            scrapCode: null,
        }

        const formData = ref(JSON.parse(JSON.stringify(blankFormData)))

        const resetFormData = () => {
            formData.value = JSON.parse(JSON.stringify(blankFormData))
        }

        const editBomVersionProcess = (data) => {
            formData.value.id = data._id
            formData.value.bomId = data.bomId
            formData.value.versionId = data.versionId
            formData.value.progressId = data.progressId
            formData.value.machineNumber = data.machineNumber
            formData.value.progressDescription = data.progressDescription
            formData.value.jigFixNumber = data.jigFixNumber
            formData.value.specialTool = data.specialTool
            formData.value.inspectionLevel = data.inspectionLevel
            formData.value.measuringDeviceLabel = data.measuringDeviceLabel
            formData.value.measuringDevice = data.measuringDevice
            formData.value.qcSample = data.qcSample
            formData.value.processRate = data.processRate
            formData.value.daysRequire = data.daysRequire
            formData.value.wtLoss = data.wtLoss
            formData.value.matWt = data.matWt
            formData.value.burningLoss = data.burningLoss
            formData.value.scrapTolerance = data.scrapTolerance
            formData.value.inspectionBy = data.inspectionBy
            formData.value.remark = data.remark
            formData.value.inspectionInstruction = data.inspectionInstruction
            formData.value.processSheetNumber = data.processSheetNumber
            formData.value.matIssueWt = data.matIssueWt
            formData.value.scrapQty = data.scrapQty
            formData.value.scrapCode = data.scrapCode
        }

        const submitFormData = async () => {
            if (formData.value.id === null) {
                await store.dispatch('bom-module/addBomVersionProcess', formData.value).then(res => {
                    if (res.data.status === 200) {
                        toast({
                            component: Toastification,
                            position: 'top-right',
                            props: {
                                title: 'BOM Version Item Added',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: 'You have successfully Added Bill Of Master Version Item',
                            },
                        })
                    } else {
                        toast({
                            component: Toastification,
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
                await store.dispatch('bom-module/updateBomVersionProcess', formData.value).then(res => {
                    if (res.data.status === 200) {
                        toast({
                            component: Toastification,
                            position: 'top-right',
                            props: {
                                title: 'BOM Version Item Updated',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: 'You have successfully Updated Bill Of Master Version Item',
                            },
                        })
                    } else {
                        toast({
                            component: Toastification,
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
            }
            resetFormData()
            await refetchData()
        }

        const deleteBomVersionProcess = async (id) => {
            Swal.fire({
                title: 'Are you sure?',
                text: "Delete Bill Of Material Version Item",
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
                    store.dispatch('bom-module/deleteBomVersionProcess', {id: id}).then(res => {
                        if (res.data.status === 200) {
                            toast({
                                component: Toastification,
                                position: 'top-right',
                                props: {
                                    title: 'BOM Version Process Deleted',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: 'You have successfully Deleted Bill Of Master Version Process',
                                },
                            })
                        } else {
                            toast({
                                component: Toastification,
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
                    resetFormData()
                    refetchData()
                }
            })
        }

        // const getProcessSheetListDetails = async (id) => {
        //     await axios.get(`/api/process-sheet-list/${id}`).then((res) => {
        //         formData.value.machineNumber = res.data.data.machineNo
        //         formData.value.progressDescription = res.data.data.processDesc
        //         formData.value.jigFixNumber = res.data.data.jigFixNo
        //         formData.value.specialTool = res.data.data.specialTool
        //         formData.value.inspectionLevel = res.data.data.inspectionLevel
        //         formData.value.measuringDevice = res.data.data.measuringInstDesc
        //         formData.value.qcSample = res.data.data.qcSamplePer
        //         formData.value.processRate = res.data.data.processRate
        //         formData.value.daysRequire = res.data.data.daysReq
        //         formData.value.wtLoss = res.data.data.wtLossPer
        //         formData.value.matWt = res.data.data.matWt
        //         formData.value.burningLoss = res.data.data.burningLossPer
        //         formData.value.scrapTolerance = res.data.data.scrapTolerancePer
        //         formData.value.inspectionBy = res.data.data.inspectionBy
        //         formData.value.inspectionInstruction = res.data.data.inspectionInst
        //         formData.value.remark = res.data.data.remark
        //         formData.value.processSheetNumber = res.data.data?.process_details?.processSheetNo ?? null
        //     });
        // }

        const {refFormObserver, getValidationState, resetForm} = formValidation(resetFormData)

        return {
            showOverlayLoading,
            isBusy,
            bomId,
            versionId,
            bomProcessRows,
            bomProcessData,
            processOptions,
            refetchData,
            formData,
            resetFormData,
            submitFormData,
            editBomVersionProcess,
            deleteBomVersionProcess,
            // getProcessSheetListDetails,

            refFormObserver,
            getValidationState,
            resetForm
        }
    }
}
</script>
<style lang="scss">
@import '~@core/scss/vue/libs/vue-sweetalert.scss';
</style>
<style lang="scss" scoped>
@import '~@core/scss/base/bootstrap-extended/include';
@import '~@core/scss/base/components/variables-dark';

.dark-layout {
    div ::v-deep .card .card-body {
        .b-overlay {
            .bg-light {
                background-color: $theme-dark-body-bg !important;
            }
        }
    }
}
</style>
