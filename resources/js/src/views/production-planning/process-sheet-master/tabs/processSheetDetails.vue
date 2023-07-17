<template>
    <div>
        <b-table
            :fields="processSheetFields"
            :items="listOfProcessSheets"
            responsive
            class="mb-0"
            bordered
            hover
            show-empty
            :busy="isBusy"
            selectable
            select-mode="single"
            @row-selected="onRowSelect"
        >
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
                    <b-dropdown-item @click="deleteProcessSheetListData(data.item._id)">
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
        <b-row>
            <b-col md="12">
                <hr>
                <h4>Process Sheet</h4>
                <hr>
            </b-col>
        </b-row>
        <validation-observer ref="simpleRules">
            <b-form>
                <b-row>

                    <b-col md="4">
                        <b-form-group
                            label="Machine No"
                            label-for="machineNo"
                        >
                            <b-form-input
                                id="itemCode"
                                v-model="processSheetsData.machineNo"
                            />
                        </b-form-group>
                    </b-col>

                    <b-col md="4">
                        <b-form-group
                            label="Select Process"
                            label-for="processId"
                        >
                            <v-select
                                v-model="processSheetsData.processId"
                                placeholder="Select Process"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="processListOption"
                                :reduce="val => val.value"
                                :clearable="true"
                                v-on:input="getProcessDetail(processSheetsData.processId)"
                                input-id="processId"
                            />
                        </b-form-group>
                    </b-col>

                    <b-col md="4">
                        <b-form-group
                            label="Process Description"
                            label-for="processDesc"
                        >
                            <validation-provider
                                #default="{ errors }"
                                name="Process Description"
                                rules="required"
                            >
                                <b-form-input
                                    id="processDesc"
                                    v-model="processSheetsData.processDesc"
                                    :state="errors.length > 0 ? false:null"
                                />
                                <small class="text-danger">{{ errors[0] }}</small>
                            </validation-provider>
                        </b-form-group>
                    </b-col>

                    <b-col md="4">
                        <b-form-group
                            label="Jig/Fix No"
                            label-for="jigFixNo"
                        >
                            <b-form-input
                                id="jigFixNo"
                                v-model="processSheetsData.jigFixNo"
                            />
                        </b-form-group>
                    </b-col>

                    <b-col md="4">
                        <b-form-group
                            label="Special Tool"
                            label-for="specialTool"
                        >
                            <b-form-input
                                id="specialTool"
                                v-model="processSheetsData.specialTool"
                            />
                        </b-form-group>
                    </b-col>

                    <b-col md="4">
                        <b-form-group
                            label="Inspection Level"
                            label-for="inspectionLevel"
                        >
                            <b-form-input
                                id="inspectionLevel"
                                v-model="processSheetsData.inspectionLevel"
                            />
                        </b-form-group>
                    </b-col>

                    <b-col md="4">
                        <b-form-group
                            label="Measuring Instruments"
                            label-for="measuringInstDesc"
                        >
                            <b-form-input
                                id="measuringInstDesc"
                                v-model="processSheetsData.measuringInstDesc"
                            />
                        </b-form-group>
                    </b-col>

                    <b-col md="4">
                        <b-row>
                            <b-col md="6">
                                <b-form-group
                                    label="Qc Sample (%)"
                                    label-for="qcSamplePer"
                                >
                                    <b-form-input
                                        id="qcSamplePer"
                                        v-model="processSheetsData.qcSamplePer"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Process Rate(Hr)"
                                    label-for="processRate"
                                >
                                    <b-form-input
                                        id="processRate"
                                        v-model="processSheetsData.processRate"
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>

                    </b-col>

                    <b-col md="4">
                        <b-row>
                            <b-col md="6">
                                <b-form-group
                                    label="Setup Time(M)"
                                    label-for="setupTimeInMinute"
                                >
                                    <b-form-input
                                        id="setupTimeInMinute"
                                        v-model="processSheetsData.setupTimeInMinute"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Process Time(M)"
                                    label-for="processTimeInMinute"
                                >
                                    <b-form-input
                                        id="processTimeInMinute"
                                        v-model="processSheetsData.processTimeInMinute"
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>
                    </b-col>

                    <b-col md="4">
                        <b-form-group
                            label="Days Required"
                            label-for="daysReq"
                        >
                            <b-form-input
                                id="daysReq"
                                v-model="processSheetsData.daysReq"
                            />
                        </b-form-group>
                    </b-col>

                    <b-col md="4">
                        <b-form-group
                            label="Wt Loss (%)"
                            label-for="wtLossPer"
                        >
                            <b-form-input
                                id="wtLossPer"
                                v-model="processSheetsData.wtLossPer"
                            />
                        </b-form-group>
                    </b-col>

                    <b-col md="4">
                        <b-form-group
                            label="Mat. WT."
                            label-for="matWt"
                        >
                            <b-form-input
                                id="matWt"
                                v-model="processSheetsData.matWt"
                            />
                        </b-form-group>
                    </b-col>

                    <b-col md="4">
                        <b-form-group
                            label="Burning Loss (%)"
                            label-for="burningLossPer"
                        >
                            <b-form-input
                                id="burningLossPer"
                                v-model="processSheetsData.burningLossPer"
                            />
                        </b-form-group>
                    </b-col>

                    <b-col md="4">
                        <b-form-group
                            label="Scrap Tolerance (%)"
                            label-for="scrapTolerancePer"
                        >
                            <b-form-input
                                id="scrapTolerancePer"
                                v-model="processSheetsData.scrapTolerancePer"
                            />
                        </b-form-group>
                    </b-col>

                    <b-col md="4">
                        <b-form-group
                            label="inspectionBy"
                            label-for="inspectionBy"
                        >
                            <b-form-input
                                id="inspectionBy"
                                v-model="processSheetsData.inspectionBy"
                            />
                        </b-form-group>
                    </b-col>

                    <b-col md="6">
                        <b-form-group
                            label="inspection Instruction"
                            label-for="inspectionInst"
                        >
                            <b-form-textarea
                                id="inspectionInst"
                                v-model="processSheetsData.inspectionInst"
                                rows="1"
                            />
                        </b-form-group>
                    </b-col>

                    <b-col md="6">
                        <b-form-group
                            label="Remark"
                            label-for="remark"
                        >
                            <b-form-textarea
                                id="reason"
                                v-model="processSheetsData.remark"
                                rows="1"
                            />
                        </b-form-group>
                    </b-col>

                </b-row>
                <b-row>
                    <!-- submit and reset -->
                    <b-col>
                        <b-button
                            v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                            type="submit"
                            variant="primary"
                            class="mr-1"
                            @click.prevent="validationForm"
                        >
                            Add / Save Process
                        </b-button>
                    </b-col>
                </b-row>
            </b-form>
        </validation-observer>
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
        BDropdown,
        BDropdownItem,
        BButton,
        BFormDatepicker,
        BOverlay,
        BTable,
        BFormRadio,
        BSpinner
    } from 'bootstrap-vue'
    import {required} from '@validations'
    import Ripple from 'vue-ripple-directive'
    import vSelect from 'vue-select'
    import router from '@/router'
    import store from '@/store'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import {ref, computed, onUnmounted} from '@vue/composition-api'
    import productionPlanningStoreModule from '../../productionPlanningStoreModule'
    import axios from '@axios'

    export default {
        components: {
            BCardCode,
            ValidationProvider,
            ValidationObserver,
            BRow,
            BCol,
            BFormGroup,
            BFormInput,
            BFormTextarea,
            BForm,
            BButton,
            BDropdown,
            BDropdownItem,
            BFormDatepicker,
            vSelect,
            BOverlay,
            BTable,
            BFormRadio,
            BSpinner
        },
        directives: {
            Ripple,
        },
        methods: {
            validationForm() {
                this.$refs.simpleRules.validate().then(success => {
                    if (success) {
                        const hasIdExist = this.containsKey(this.processSheetsData, '_id')
                        if (hasIdExist) {
                            this.processSheetsData.id = this.processSheetsData._id
                            delete this.processSheetsData._id
                            store.dispatch('psl-module/updateProcessSheetList', this.processSheetsData).then(response => {
                                if (response.status === 200) {

                                    this.$toast({
                                        component: ToastificationContent,
                                        position: 'top-right',
                                        props: {
                                            title: 'Item Edited',
                                            icon: 'CheckSquareIcon',
                                            variant: 'success',
                                            text: `You have successfully Edited Sheet : ${this.processSheetsData.processDesc}.`,
                                        },
                                    })

                                    this.refetchProcessSheetData()

                                    this.resetSheetFormData()
                                }
                            })
                        } else {
                            store.dispatch('psl-module/addProcessSheetList', this.processSheetsData).then(response => {
                                if (response.status === 200) {

                                    this.$toast({
                                        component: ToastificationContent,
                                        position: 'top-right',
                                        props: {
                                            title: 'Item Created',
                                            icon: 'CheckSquareIcon',
                                            variant: 'success',
                                            text: `You have successfully Created New Sheet : ${this.processSheetsData.processDesc}.`,
                                        },
                                    })

                                    this.refetchProcessSheetData()

                                    this.resetSheetFormData()
                                }
                            })
                        }
                    }
                })
            },
            containsKey(obj, key) {
                return Object.keys(obj).includes(key)
            },
            deleteProcessSheetListData(id) {

                this.$swal({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    customClass: {
                        confirmButton: 'btn btn-primary',
                        cancelButton: 'btn btn-outline-danger ml-1',
                    },
                    buttonsStyling: false,
                }).then(result => {
                    if (result.value) {
                        store.dispatch(`psl-module/deleteProcessSheetList`, {id}).then(response => {
                            if (response.data.status === 200) {
                                this.refetchProcessSheetData()
                                this.$toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: `Deleted`,
                                        icon: 'CheckSquareIcon',
                                        variant: 'success',
                                        text: `Sheet Deleted Successfully`,
                                    },
                                })
                            } else {
                                this.$toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: `Error`,
                                        icon: 'AlertCircleIcon',
                                        variant: 'danger',
                                        text: `something went wrong`,
                                    },
                                })
                            }
                        })
                    }
                })
            }
        },
        props: {
            processSheetItemId: String,
        },
        setup(props) {
            const PSD_APP_STORE_MODULE_NAME = 'psl-module'
            // Register module
            if (!store.hasModule(PSD_APP_STORE_MODULE_NAME)) store.registerModule(PSD_APP_STORE_MODULE_NAME, productionPlanningStoreModule)
            // UnRegister on leave
            onUnmounted(() => {
                if (store.hasModule(PSD_APP_STORE_MODULE_NAME)) store.unregisterModule(PSD_APP_STORE_MODULE_NAME)
            })

            const processSheetId = ref(router.currentRoute.params.id)

            const processItemId = computed(() => props.processSheetItemId)

            const processListOption = ref([])

            const isBusy = ref(true)

            const processSheetFields = ref([
                {
                    key: 'rowSelected',
                    label: ''
                },
                {
                    key: 'index',
                    label: 'No',
                },
                {
                    key: 'machineNo',
                    label: 'Machine No',
                },
                {
                    key: 'processDesc',
                    label: 'Process Description',
                },
                {
                    key: 'jigFixNo',
                    label: 'Jig Fix No',
                },
                {
                    key: 'specialTool',
                    label: 'Special Tool',
                },
                {
                    key: 'inspectionLevel',
                    label: 'Inspection Level',
                },
                {
                    key: 'action',
                    label: 'Action',
                },
            ])

            const listOfProcessSheets = ref([])

            const refetchProcessSheetData = async () => {
                isBusy.value = true
                await axios.get(`/api/get-process-sheet-list-data/${processSheetId.value}`).then(res => {
                    listOfProcessSheets.value = res.data.data
                })
                isBusy.value = false
            }

            refetchProcessSheetData()

            const processSheetsData = ref({
                id: null,
                processSheetId: processSheetId.value,
                processItemId: processItemId,
                machineNo: null,
                processId: null,
                processDesc: null,
                jigFixId: null,
                jigFixNo: null,
                specialTool: null,
                inspectionLevel: null,
                measuringInstId: null,
                measuringInstDesc: null,
                qcSamplePer: null,
                processRate: null,
                daysReq: null,
                wtLossPer: null,
                matWt: null,
                burningLossPer: null,
                scrapTolerancePer: null,
                inspectionBy: null,
                inspectionInst: null,
                remark: null,
                setupTimeInMinute: null,
                processTimeInMinute: null,
                userDetail: null,
            })

            const resetSheetFormData = () => {
                processSheetsData.value = {
                    id: null,
                    processSheetId: processSheetId.value,
                    processItemId: processItemId,
                    machineNo: null,
                    processId: null,
                    processDesc: null,
                    jigFixId: null,
                    jigFixNo: null,
                    specialTool: null,
                    inspectionLevel: null,
                    measuringInstId: null,
                    measuringInstDesc: null,
                    qcSamplePer: null,
                    processRate: null,
                    daysReq: null,
                    wtLossPer: null,
                    matWt: null,
                    burningLossPer: null,
                    scrapTolerancePer: null,
                    inspectionBy: null,
                    inspectionInst: null,
                    remark: null,
                    setupTimeInMinute: null,
                    processTimeInMinute: null,
                    userDetail: null,
                }
            }

            const onRowSelect = (items) => {
                if (items.length > 0) {
                    processSheetsData.value._id = items[0]._id
                    processSheetsData.value.machineNo = items[0].machineNo
                    processSheetsData.value.processId = items[0].processId
                    processSheetsData.value.processDesc = items[0].processDesc
                    processSheetsData.value.jigFixId = items[0].jigFixId
                    processSheetsData.value.jigFixNo = items[0].jigFixNo
                    processSheetsData.value.specialTool = items[0].specialTool
                    processSheetsData.value.inspectionLevel = items[0].inspectionLevel
                    processSheetsData.value.measuringInstId = items[0].measuringInstId
                    processSheetsData.value.measuringInstDesc = items[0].measuringInstDesc
                    processSheetsData.value.qcSamplePer = items[0].qcSamplePer
                    processSheetsData.value.processRate = items[0].processRate
                    processSheetsData.value.daysReq = items[0].daysReq
                    processSheetsData.value.wtLossPer = items[0].wtLossPer
                    processSheetsData.value.matWt = items[0].matWt
                    processSheetsData.value.burningLossPer = items[0].burningLossPer
                    processSheetsData.value.scrapTolerancePer = items[0].scrapTolerancePer
                    processSheetsData.value.inspectionBy = items[0].inspectionBy
                    processSheetsData.value.inspectionInst = items[0].inspectionInst
                    processSheetsData.value.remark = items[0].remark
                    processSheetsData.value.setupTimeInMinute = items[0].setupTimeInMinute
                    processSheetsData.value.processTimeInMinute = items[0].processTimeInMinute
                    processSheetsData.value.userDetail = items[0].userDetail
                } else {
                    resetSheetFormData()
                }
            }

            axios.get('/api/get-process-master-option').then(res => {
                processListOption.value = res.data.data
            })

            const getProcessDetail = async (val) => {
                await axios.get(`/api/process-master/${val}`).then(res => {
                    processSheetsData.value.processDesc = res.data.data.processName
                })
            }

            return {
                processSheetId,
                processSheetFields,
                listOfProcessSheets,
                processSheetsData,
                refetchProcessSheetData,
                resetSheetFormData,
                processListOption,
                getProcessDetail,
                required,
                isBusy,
                onRowSelect
            }
        },
    }
</script>
<style lang="scss">
    @import '~@core/scss/vue/libs/vue-select.scss';
</style>
