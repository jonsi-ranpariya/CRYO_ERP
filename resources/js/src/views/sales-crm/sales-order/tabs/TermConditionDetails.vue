<template>
    <div>
        <hr>
        <!-- Table Area -->
        <b-table
            :fields="TermConditionFields"
            :items="listOfTermConditions"
            :bordered="true"
            :hover="true"
            show-empty
            responsive
            class="mb-0 table_scroll"
            selectable
            select-mode="single"
            @row-selected="onRowSelected"
        >
            <!-- A virtual column -->
            <template #cell(index)="data">
                {{ data.index + 1 }}
            </template>

            <!-- A custom formatted column -->
            <template #cell(termGroupName)="data">
                <span class="text-nowrap">{{ data.value }}</span>
            </template>

            <!-- A custom formatted column -->
            <template #cell(termDetail)="data">
                <span class="text-nowrap">{{ data.value }}</span>
            </template>

            <!-- A custom formatted column -->
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
              <b-dropdown-item @click="deleteSalesOrderTermCond(data.item._id)">
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

        <!-- Buttons Area -->
        <b-row>
            <b-col md="12">
                <hr>
            </b-col>
            <b-col md="12">
                <b-button
                    variant="primary"
                    type="button"
                    @click="openTCTemplateModal"
                >
                    From Template
                </b-button>
                <b-button
                    variant="primary"
                    type="button"
                    @click="defaultTemplate"
                >
                    From Default Template
                </b-button>
                <b-button
                    variant="primary"
                    type="button"
                    @click="copyFromPartyMaster"
                    :disabled="copyButton.isDisabled"
                >
                    {{ copyButton.text }}
                </b-button>
            </b-col>
            <b-col md="12">
                <hr>
            </b-col>
        </b-row>

        <!-- Form Area -->
        <validation-observer ref="simpleRules">
            <b-form>
                <b-row>
                    <b-col md="12">
                        <b-form-group
                            label="Select Group"
                            label-for="termConditionId"
                        >
                            <validation-provider
                                #default="{ errors }"
                                name="Select Group"
                                rules=""
                            >
                                <v-select
                                    v-model="salesOrderTermConditionData.termConditionId"
                                    placeholder="Select Group"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="TermConditionOptions"
                                    :reduce="val => val.value"
                                    :clearable="false"
                                    v-on:input="getTermConditionDetails(salesOrderTermConditionData.termConditionId)"
                                    input-id="termConditionId"
                                    :state="errors.length > 0 ? false:null"
                                />
                                <small class="text-danger">{{ errors[0] }}</small>
                            </validation-provider>
                        </b-form-group>
                    </b-col>
                    <b-col md="12">
                        <validation-provider
                            #default="{ errors }"
                            name="Group Name"
                            rules="required"
                        >
                            <b-form-group
                                label="Group Name"
                                label-for="termGroupName"
                            >
                                <b-form-input
                                    id="termGroupName"
                                    v-model="salesOrderTermConditionData.termGroupName"
                                    rows="1"
                                    :state="errors.length > 0 ? false:null"
                                />
                                <small class="text-danger">{{ errors[0] }}</small>
                            </b-form-group>
                        </validation-provider>
                    </b-col>
                    <b-col md="12">
                        <b-form-group
                            label="Term & Condition"
                            label-for="termGroupDetail"
                        >
                            <b-form-textarea
                                id="termGroupDetail"
                                v-model="salesOrderTermConditionData.termDetail"
                                rows="1"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="6">
                        <b-form-group
                            label="Term For"
                            label-for="termConditionFor"
                        >
                            <v-select
                                v-model="salesOrderTermConditionData.termConditionFor"
                                placeholder="Term For"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="TermForOption"
                                :reduce="val => val.value"
                                :clearable="false"
                                v-on:input="addTermForName(salesOrderTermConditionData.termConditionFor)"
                                input-id="termConditionFor"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="6">
                        <b-form-group class="mt-2">
                            <b-form-checkbox
                                id="isPrint"
                                v-model="salesOrderTermConditionData.isPrint"
                                name="isPrint"
                                value="1"
                            >
                                Is Print
                            </b-form-checkbox>
                        </b-form-group>
                    </b-col>
                </b-row>
                <b-row>
                    <!-- submit and reset -->
                    <b-col md="12">
                        <hr>
                        <b-button
                            v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                            type="submit"
                            variant="primary"
                            class="mr-1 float-right"
                            @click.prevent="validationForm"
                        >
                            Save
                        </b-button>
                    </b-col>
                </b-row>
            </b-form>
        </validation-observer>

        <!-- Modal Area -->
        <b-modal
            id="termConditionModal"
            title="Select Term & Condition Template"
            ok-title="submit"
            cancel-variant="danger"
            size="xl"
            no-close-on-backdrop
            scrollable
            ref="termConditionModal"
            @ok="fromTemplateHandelOk"
            @close="clearModalData"
            @cancel="clearModalData"
        >
            <b-table
                :fields="modalTableFields.templateField"
                :items="modalTableFields.templateItems"
                :no-border-collapse="false"
                responsive
                bordered
                hover
                show-empty
                class="table_scroll"
            >
                <template #cell(index)="data">
                    {{ data.index + 1 }}
                </template>
                <template #cell(action)="data">
                    <b-button
                        variant="flat-primary"
                        size="sm"
                        :id="`b_${data.item._id}`"
                        @click="getTemplate(data.item._id)"
                    >
                        Select
                    </b-button>
                </template>
            </b-table>
            <hr>
            <h5>Template Details</h5>
            <hr>
            <b-table
                :fields="modalTableFields.templateDataFields"
                :items="modalTableFields.templateDataItems"
                :no-border-collapse="false"
                responsive
                bordered
                hover
                show-empty
                class="table_scroll"
                :busy="modalTableIsBusy"
            >
                <!--Loader-->
                <template #table-busy>
                    <div class="text-center my-2">
                        <b-spinner class="align-middle"></b-spinner>
                        <strong>Loading...</strong>
                    </div>
                </template>

                <template #cell(index)="data">
                    {{ data.index + 1 }}
                </template>
            </b-table>
        </b-modal>
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
        BFormCheckbox,
        BFormTextarea,
        BForm,
        BDropdown,
        BDropdownItem,
        BButton,
        BFormDatepicker,
        BOverlay,
        BTable,
        BSpinner
    } from 'bootstrap-vue'
    import {required} from '@validations'
    import Ripple from 'vue-ripple-directive'
    import vSelect from 'vue-select'
    import router from '@/router'
    import store from '@/store'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import {ref, computed, onUnmounted} from '@vue/composition-api'
    import salesStoreModule from '../../salesStoreModule'
    import axios from '@axios'
    import {useToast} from "vue-toastification/composition";
    import Swal from "sweetalert2";
    import {forMatIndianDateAndTime} from "@core/utils/utils";

    export default {
        components: {
            BCardCode,
            ValidationProvider,
            ValidationObserver,
            BRow,
            BCol,
            BFormGroup,
            BFormCheckbox,
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
            BSpinner
        },
        directives: {
            Ripple,
        },
        methods: {
            async validationForm() {
                await this.$refs.simpleRules.validate().then(success => {
                    if (success) {
                        const hasIdExist = this.containsKey(this.salesOrderTermConditionData, '_id')
                        if (hasIdExist) {
                            this.salesOrderTermConditionData.id = this.salesOrderTermConditionData._id
                            delete this.salesOrderTermConditionData._id
                            store.dispatch('sales-order-module/updateSalesOrderTermCondition', this.salesOrderTermConditionData).then(response => {
                                if (response.status === 200) {
                                    this.resetTermConditionFormData()
                                    this.refetchTermConditionData()
                                    this.$toast({
                                        component: ToastificationContent,
                                        position: 'top-right',
                                        props: {
                                            title: 'Department Edited',
                                            icon: 'CheckSquareIcon',
                                            variant: 'success',
                                            text: `You have successfully Edited Business Type : ${this.salesOrderTermConditionData.termGroupName}.`,
                                        },
                                    })
                                }
                            })
                        } else {
                            store.dispatch('sales-order-module/addSalesOrderTermCondition', this.salesOrderTermConditionData).then(response => {
                                if (response.status === 200) {
                                    this.resetTermConditionFormData()
                                    this.refetchTermConditionData()
                                    this.$toast({
                                        component: ToastificationContent,
                                        position: 'top-right',
                                        props: {
                                            title: 'Department Created',
                                            icon: 'CheckSquareIcon',
                                            variant: 'success',
                                            text: `You have successfully Created New Department : ${this.salesOrderTermConditionData.termGroupName}.`,
                                        },
                                    })
                                }
                            })
                        }
                    }
                })
            },
            containsKey(obj, key) {
                return Object.keys(obj).includes(key)
            },
            deleteSalesOrderTermCond(id) {
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
                        store.dispatch(`sales-order-module/deleteSalesOrderTermCondition`, {id}).then(response => {
                            if (response.data.status === 200) {
                                this.refetchTermConditionData();
                                this.resetTermConditionFormData();
                                this.$toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: `Deleted`,
                                        icon: 'CheckSquareIcon',
                                        variant: 'success',
                                        text: `Department Deleted Successfully`,
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
            shellToPartyId: {
                required: true,
            }
        },
        setup(props, {termConditionModal}) {
            const SO_APP_STORE_MODULE_NAME = 'sales-order-module'
            if (!store.hasModule(SO_APP_STORE_MODULE_NAME)) store.registerModule(SO_APP_STORE_MODULE_NAME, salesStoreModule)

            const CurrentSalesOrderId = ref(router.currentRoute.params.id)
            const currentPartyId = computed(() => props.shellToPartyId);
            termConditionModal = ref()
            const toast = useToast()
            const copyButton = ref({
                text: 'Copy From Party Master',
                isDisabled: false
            });

            const TermConditionOptions = ref([])
            const TermForOption = ref([
                {label: 'General', value: 'General'},
                {label: 'Invoice', value: 'Invoice'},
                {label: 'Work Order', value: 'Work Order'},
            ])

            const TermConditionFields = ref([
                {
                    key: 'rowSelected',
                    label: ''
                },
                {
                    key: 'index',
                    label: 'Sr.No',
                },
                {
                    key: 'termGroupName',
                    label: 'Group Name',
                },
                {
                    key: 'termDetail',
                    label: 'Term & Condition',
                },
                {
                    key: 'action',
                    label: 'Action',
                },
            ])

            const listOfTermConditions = ref([])

            const refetchTermConditionData = async () => {
                await axios.get(`/api/get-sales-order-term-condition/${router.currentRoute.params.id}`).then(res => {
                    listOfTermConditions.value = res.data.data
                })
            }
            refetchTermConditionData();

            axios.get('/api/get-term-condition-detail-with-group-options').then(res => {
                TermConditionOptions.value = res.data.data
            })

            const salesOrderTermConditionData = ref({
                id: null,
                salesOrderId: CurrentSalesOrderId.value,
                termConditionId: null,
                termGroupName: null,
                termDetail: null,
                termConditionFor: null,
                termConditionForName: null,
                isPrint: '1',
            });

            const onRowSelected = (items) => {
                if (items.length > 0) {
                    salesOrderTermConditionData.value._id = items[0]._id
                    salesOrderTermConditionData.value.salesOrderId = items[0].salesOrderId
                    salesOrderTermConditionData.value.termConditionId = items[0].termConditionId ?? null
                    salesOrderTermConditionData.value.termGroupName = items[0].termGroupName ?? null
                    salesOrderTermConditionData.value.termDetail = items[0].termDetail ?? null
                    salesOrderTermConditionData.value.termConditionFor = items[0].termConditionFor ?? null
                    salesOrderTermConditionData.value.termConditionForName = items[0].termConditionForName ?? null
                    salesOrderTermConditionData.value.isPrint = items[0].isPrint ?? null
                } else {
                    resetTermConditionFormData()
                }
            }

            const resetTermConditionFormData = () => {
                salesOrderTermConditionData.value = {
                    id: null,
                    salesOrderId: CurrentSalesOrderId.value,
                    termConditionId: null,
                    termGroupName: null,
                    termDetail: null,
                    termConditionFor: null,
                    termConditionForName: null,
                    isPrint: '1',
                }
            }

            const getTermConditionDetails = async (val) => {
                await axios.get(`/api/get-term-condition-detail-with-group-details/${val}`).then(res => {
                    if (res.data.data) {
                        salesOrderTermConditionData.value.termDetail = res.data.data.tcGroupDescription
                        salesOrderTermConditionData.value.termGroupName = res.data.data.tc_group_details.groupDescription
                    }
                });
            }

            const addTermForName = async (val) => {
                salesOrderTermConditionData.value.termConditionForName = val
            }

            const copyFromPartyMaster = async () => {
                await Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to copy master term and condition!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, copy it!',
                    customClass: {
                        confirmButton: 'btn btn-primary',
                        cancelButton: 'btn btn-outline-danger ml-1',
                    },
                    buttonsStyling: false,
                }).then(result => {
                    if (result.value) {
                        copyButton.value.isDisabled = true
                        copyButton.value.text = 'Please wait...'
                        axios.post(`/api/copy-term-condition-party-master-sales-order`, {
                            partyId: currentPartyId.value,
                            salesOrderId: router.currentRoute.params.id
                        }).then((res) => {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: res.data.shortMessage,
                                    icon: res.data.icon,
                                    variant: res.data.variant,
                                    text: res.data.message,
                                },
                            });
                        });
                        copyButton.value.isDisabled = false
                        copyButton.value.text = 'Copy From Party Master'
                    }
                });
                await refetchTermConditionData();
            }

            const modalTableIsBusy = ref(false)

            const selectedTemplate = ref(null)

            const modalTableFields = ref({
                templateField: [
                    {
                        key: 'action',
                        label: ''
                    },
                    {
                        key: 'templateName',
                        label: 'Template Name'
                    },
                    {
                        key: 'created_at',
                        label: 'Created Date',
                        formatter: val => forMatIndianDateAndTime(val)
                    }
                ],
                templateItems: [],
                templateDataFields: [
                    {
                        key: 'index',
                        label: 'No.'
                    },
                    {
                        key: 'groupName',
                        label: 'Group Name'
                    },
                    {
                        key: 'tcDescription',
                        label: 'Description'
                    },
                ],
                templateDataItems: [],
            });

            const clearModalData = async () => {
                modalTableFields.value.templateDataItems = []
                modalTableFields.value.templateItems = []
                selectedTemplate.value = null
            }

            const openTCTemplateModal = async () => {
                selectedTemplate.value = null
                await axios.get('/api/term-condition-template-master').then((res) => {
                    modalTableFields.value.templateItems = res.data.data
                });
                termConditionModal.value.show();
            }

            const getTemplate = async (id) => {
                selectedTemplate.value = id
                modalTableIsBusy.value = true
                await axios.get(`/api/new/term-condition-template-wise/${id}`).then((res) => {
                    modalTableFields.value.templateDataItems = res.data.data
                });
                modalTableIsBusy.value = false
            }

            const fromTemplateHandelOk = async () => {
                if (selectedTemplate.value === null) {
                    toast({
                        component: ToastificationContent,
                        position: 'top-right',
                        props: {
                            title: `Error`,
                            icon: 'AlertCircleIcon',
                            variant: 'danger',
                            text: 'Please select any template.',
                        },
                    });
                    await openTCTemplateModal();
                } else {
                    await axios.post('/api/add-sales-order-term-condition-from-template', {
                        salesOrderId: CurrentSalesOrderId.value,
                        templateId: selectedTemplate.value
                    }).then((res) => {
                        if (res.status === 200) {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: "Added",
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: 'You have successfully added Term & Condition from Template',
                                },
                            });
                        }
                    }).catch(() => {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: `Error`,
                                icon: 'AlertCircleIcon',
                                variant: 'danger',
                                text: 'Internal server error.',
                            },
                        });
                    });
                    await clearModalData();
                    await refetchTermConditionData();
                }
            }

            const defaultTemplate = async () => {
                await Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to copy Default term and condition!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, copy it!',
                    customClass: {
                        confirmButton: 'btn btn-primary',
                        cancelButton: 'btn btn-outline-danger ml-1',
                    },
                    buttonsStyling: false,
                }).then(result => {
                    if (result.value) {
                        axios.post(`/api/copy-term-condition-default-template-sales-order`, {
                            salesOrderId: router.currentRoute.params.id
                        }).then((res) => {
                            if (res.status === 200) {
                                toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: "Added",
                                        icon: 'CheckSquareIcon',
                                        variant: 'success',
                                        text: 'You have successfully added Term & Condition from Default Template',
                                    },
                                });
                            }
                        }).catch(() => {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: `Error`,
                                    icon: 'AlertCircleIcon',
                                    variant: 'danger',
                                    text: 'Internal server error.',
                                },
                            });
                        });
                    }
                });
                await refetchTermConditionData();
            }

            return {
                CurrentSalesOrderId,
                copyButton,
                TermConditionFields,
                listOfTermConditions,
                salesOrderTermConditionData,
                refetchTermConditionData,
                resetTermConditionFormData,
                getTermConditionDetails,
                addTermForName,
                TermConditionOptions,
                TermForOption,
                copyFromPartyMaster,
                modalTableIsBusy,
                modalTableFields,
                clearModalData,
                termConditionModal,
                openTCTemplateModal,
                getTemplate,
                fromTemplateHandelOk,
                defaultTemplate,
                required,
                onRowSelected
            }
        },
    }
</script>

<style lang="scss">
    @import '~@core/scss/vue/libs/vue-select.scss';
</style>
