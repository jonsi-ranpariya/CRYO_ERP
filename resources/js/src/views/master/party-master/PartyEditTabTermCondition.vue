<template>
    <div>
        <b-row>
            <b-col md="12">
                <hr>
                <b-button
                    variant="primary"
                    type="button"
                    class="float-right"
                    @click="addNewTerm()"
                >
                    Add Term & Condition
                </b-button>
            </b-col>
            <b-col cols="12">
                <hr>
                <b-table
                    :fields="TermConditionFields"
                    :items="listOfTermConditions"
                    responsive="sm"
                    class="mb-0"
                    bordered
                    hover
                    show-empty
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
                <b-dropdown-item @click="selectTermConditionData(data.item)">
                  <feather-icon
                      icon="CheckSquareIcon"
                      class="mr-50"
                  />
                  <span>Select</span>
                </b-dropdown-item>
              <b-dropdown-item @click="editTermConditionData(data.item)">
                <feather-icon
                    icon="Edit2Icon"
                    class="mr-50"
                />
                <span>Edit</span>
              </b-dropdown-item>
              <b-dropdown-item @click="deleteTermConditionData(data.item._id)">
                <feather-icon
                    icon="TrashIcon"
                    class="mr-50"
                />
                <span>Delete</span>
              </b-dropdown-item>
            </b-dropdown>
                </span>
                    </template>
                </b-table>
            </b-col>
        </b-row>
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
            </b-col>
        </b-row>
        <!-- User Info: Input Fields -->
        <validation-observer ref="simpleRules">
            <b-form @submit.prevent="submitFormData">
                <b-row>
                    <b-col md="12">
                        <hr>
                        <h6>Term & Conditions Details</h6>
                        <hr>
                    </b-col>
                    <b-col md="12">
                        <validation-provider
                            #default="{ errors }"
                            name="Group"
                            rules=""
                        >
                            <b-form-group
                                label="Group"
                                label-for="term-group"
                                :state="errors.length > 0 ? false:null"
                            >
                                <v-select
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="groupsOptions"
                                    :reduce="val => val.value"
                                    :clearable="false"
                                    input-id="term-group"
                                    v-model="formData.group"
                                    @input="getTermConditionDetail($event)"
                                />
                                <b-form-invalid-feedback :state="errors.length > 0 ? false:null">
                                    {{ errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                    </b-col>
                    <b-col md="12">
                        <validation-provider
                            #default="{ errors }"
                            name="Group Name"
                            rules="required"
                        >
                            <b-form-group
                                label="Group Name"
                                label-for="groupName"
                                :state="errors.length > 0 ? false:null"
                            >
                                <b-form-input
                                    id="groupName"
                                    v-model="formData.groupName"
                                    :state="errors.length > 0 ? false:null"
                                />
                                <b-form-invalid-feedback :state="errors.length > 0 ? false:null">
                                    {{ errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                    </b-col>
                    <b-col md="12">
                        <b-form-group
                            label="Term & Condition"
                            label-for="term-detail"
                        >
                            <b-form-textarea
                                id="term-detail"
                                placeholder="Term & Condition"
                                rows="2"
                                v-model="formData.termDetails"
                            />
                        </b-form-group>
                    </b-col>
                </b-row>

                <hr>
                <!-- Action Buttons -->
                <b-button
                    variant="primary"
                    class="mb-1 mb-sm-0 mr-0 mr-sm-1 float-right"
                    :block="$store.getters['app/currentBreakPoint'] === 'xs'"
                    type="submit"
                    v-if="isButtonShow"
                >
                    {{ termButton }} Term & Condition
                </b-button>
                <!--<b-button
                    variant="primary"
                    class="mb-1 mb-sm-0 mr-0 mr-sm-1 float-right"
                    :block="$store.getters['app/currentBreakPoint'] === 'xs'"
                >
                    Get Term and Condition From Template
                </b-button>-->
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
    import {
        BButton,
        BRow,
        BCol,
        BFormGroup,
        BFormInput,
        BForm,
        BTable,
        BCard,
        BCardHeader,
        BCardTitle,
        BFormCheckbox,
        BFormTextarea,
        BDropdown,
        BDropdownItem,
        BFormInvalidFeedback,
        BSpinner
    } from 'bootstrap-vue'
    import Ripple from 'vue-ripple-directive'
    import vSelect from 'vue-select'
    import {ref, onUnmounted, onMounted} from '@vue/composition-api'
    import router from '@/router'
    import store from '@/store'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import formValidation from '@core/comp-functions/forms/form-validation'
    import {ValidationProvider, ValidationObserver} from 'vee-validate'
    import partyStoreModule from '../partyStoreModule'
    import moment from 'moment'
    import axios from '@axios'
    import {forMatIndianDateAndTime} from "@core/utils/utils";
    import {useToast} from "vue-toastification/composition";

    export default {
        components: {
            BButton,
            BRow,
            BCol,
            BFormGroup,
            BFormInput,
            BForm,
            BTable,
            BCard,
            BCardHeader,
            BCardTitle,
            BFormCheckbox,
            BFormTextarea,
            BDropdown,
            BDropdownItem,
            BFormInvalidFeedback,
            vSelect,
            BSpinner,

            ValidationProvider,
            ValidationObserver,
        },
        directives: {
            Ripple,
        },
        data() {
            return {
                termButton: 'Add',
                isButtonShow: true,
            }
        },
        setup({termConditionModal}) {
            termConditionModal = ref()
            const modalTableIsBusy = ref(false)
            const selectedTemplate = ref(null)
            const CurrentPartyId = ref(router.currentRoute.params.id)
            // const isButtonShow = true

            const toast = useToast()

            const APP_STORE_MODULE_NAME = 'master-add'
            onMounted(() => {
                if (!store.hasModule(APP_STORE_MODULE_NAME)) store.registerModule(APP_STORE_MODULE_NAME, partyStoreModule)
            });
            onUnmounted(() => {
                if (store.hasModule(APP_STORE_MODULE_NAME)) store.unregisterModule(APP_STORE_MODULE_NAME)
            });
            const groupsOptions = ref([])
            axios.get('/api/get-term-condition-detail-with-group-options').then(res => {
                groupsOptions.value = res.data.data
            })
            const TermConditionFields = ref([
                {
                    key: 'index',
                    label: 'Sr.No',
                },
                {
                    key: 'groupName',
                    label: 'Group',
                },
                {
                    key: 'termDetails',
                    label: 'Description',
                },
                {
                    key: 'created_at',
                    label: 'Created On',
                    formatter: val => forMatIndianDateAndTime(val)
                },
                {
                    key: 'action',
                    label: 'Action',
                },
            ])
            const listOfTermConditions = ref([])
            const refetchData = async () => {
                await axios.get(`/api/party/get-party-term-condition/${router.currentRoute.params.id}`).then(res => {
                    listOfTermConditions.value = res.data.data
                })
            }
            refetchData()

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

            const partyDetailFormData = {
                id: null,
                partyId: CurrentPartyId.value,
                group: [],
                groupName: null,
                termDetails: null,
            }

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
                    await axios.post('/api/new/add-party-master-term-condition-from-template', {
                        partyId: CurrentPartyId.value,
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
                    await refetchData();
                }
            }
            const formData = ref(JSON.parse(JSON.stringify(partyDetailFormData)))

            const resetGroupData = () => {
                formData.value = JSON.parse(JSON.stringify(partyDetailFormData))
            }

            const getTermConditionDetail = async (data) => {
                await axios.get(`/api/get-term-condition-detail-with-group-details/${data}`).then((res) => {
                    formData.value.groupName = res.data.data?.tc_group_details?.groupDescription ?? null
                    formData.value.termDetails = res.data.data.tcGroupDescription;
                });
            }

            const {refFormObserver, getValidationState, resetForm} = formValidation(resetGroupData)

            return {
                formData,

                refFormObserver,
                getValidationState,
                resetForm,
                resetGroupData,
                getTermConditionDetail,
                openTCTemplateModal,
                termConditionModal,
                modalTableIsBusy,
                modalTableFields,
                fromTemplateHandelOk,
                clearModalData,
                getTemplate,
                CurrentPartyId,
                TermConditionFields,
                listOfTermConditions,
                refetchData,
                groupsOptions,
            }
        },
        methods: {
            addNewTerm() {
                this.resetGroupData()
                this.isButtonShow = true
                this.termButton = 'Add'
            },
            async submitFormData() {
                await this.$refs.simpleRules.validate().then(success => {
                    if (success) {
                        if (this.formData.id === null) {
                            this.$store.dispatch('master-add/addPartyTermDetails', this.formData).then(() => {
                                this.resetGroupData();
                                this.refetchData();
                                this.$toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: 'Term & Condition Added',
                                        icon: 'CheckSquareIcon',
                                        variant: 'success',
                                        text: `You have successfully Added Term & Condition`,
                                    },
                                })
                            })
                        } else {
                            this.$store.dispatch('master-add/updatePartyTermDetails', this.formData).then(() => {
                                this.resetGroupData()
                                this.refetchData()
                                this.termButton = 'Add'
                                this.$toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: 'Term & Condition Updated',
                                        icon: 'CheckSquareIcon',
                                        variant: 'success',
                                        text: `You have successfully Updated Term & Condition`,
                                    },
                                })
                            })
                        }
                    }
                });
            },
            selectTermConditionData(data) {
                this.formData.group = data.group
                this.formData.groupName = data.groupName
                this.formData.termDetails = data.termDetails
                this.isButtonShow = false
            },
            editTermConditionData(data) {
                this.formData.partyId = data.partyId
                this.formData.id = data._id
                this.formData.group = data.group
                this.formData.groupName = data.groupName
                this.formData.termDetails = data.termDetails
                this.isButtonShow = true
                this.termButton = 'Update'
            },
            async deleteTermConditionData(id) {
                await this.$swal({
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
                        store.dispatch(`master-add/deletePartyTermDetails`, {id}).then(response => {
                            if (response.data.status === 200) {
                                this.resetGroupData();
                                this.refetchData();
                                this.$toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: 'Deleted',
                                        icon: 'CheckSquareIcon',
                                        variant: 'success',
                                        text: 'Term & Condition Delete Successfully',
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
        }
    }
</script>

<style lang="scss">
    @import '~@core/scss/vue/libs/vue-select.scss';
</style>
<style lang="scss">
    @import '~@core/scss/vue/libs/vue-sweetalert.scss';
</style>
