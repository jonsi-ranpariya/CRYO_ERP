<template>
    <div>
        <b-row>
            <b-col md="12">
                <hr>
                <b-button
                    variant="primary"
                    type="button"
                    @click="addNewTermAndCondition"
                >
                    Add New Term & Condition
                </b-button>
            </b-col>
            <b-col md="12">
                <hr>
                <table class="table table-bordered table-striped table-hover table-responsive-sm table_scroll">
                    <th v-for="field in tableData.termAndConditionFields" class="text-uppercase">{{ field.label }}</th>
                    <tr v-if="termData.length > 0" v-for="(item, key) in termData">
                        <td>{{ key + 1 }}</td>
                        <td>{{ item.groupName ? item.groupName : '' }}</td>
                        <td>{{ item.termAndCondition ? item.termAndCondition : '' }}</td>
                        <td>
                            <template>
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
                                <b-dropdown-item @click="selectTermAndCondition(key)">
                                  <feather-icon
                                      icon="Edit2Icon"
                                      class="mr-50"
                                  />
                                  <span>Edit</span>
                                </b-dropdown-item>
                                <b-dropdown-item @click="removeTermAndCondition(key)">
                                  <feather-icon
                                      icon="TrashIcon"
                                      class="mr-50"
                                  />
                                  <span>Delete</span>
                                </b-dropdown-item>
                                </b-dropdown>
                            </span>
                            </template>
                        </td>
                    </tr>
                    <tr v-else>
                        <td colspan="4" class="text-uppercase text-center">No Term & Condition Data Available</td>
                    </tr>
                </table>
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
                <b-button
                    variant="primary"
                    type="button"
                    @click="fromPartyMaster"
                >
                    From Party Master
                </b-button>
                <b-button
                    variant="primary"
                    type="button"
                    @click="fromDefaultTerm"
                >
                    From Default Template
                </b-button>
            </b-col>
        </b-row>
        <b-row>
            <b-col md="12" v-if="termData.length > 0">
                <hr>
                <b-form-group
                    label="Group"
                    label-for="group"
                >
                    <v-select
                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                        :options="termAndConditionOptions"
                        :clearable="false"
                        input-id="billing-term"
                        :reduce="val => val.value"
                        v-model="termData[updateKey].group"
                        v-on:input="getTermDefaultData(termData[updateKey].group, updateKey)"
                    />
                </b-form-group>
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
                            v-model="termData[updateKey].groupName"
                            rows="1"
                            :state="errors.length > 0 ? false:null"
                        />
                        <small class="text-danger">{{ errors[0] }}</small>
                    </b-form-group>
                </validation-provider>
                <b-form-group
                    label="Term & Condition"
                    label-for="termAndCondition"
                >
                    <b-form-textarea
                        rows="3"
                        id="termAndCondition"
                        v-model="termData[updateKey].termAndCondition"
                    />
                </b-form-group>
            </b-col>
        </b-row>
        <!--Modal-->
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
import {ValidationProvider, ValidationObserver} from 'vee-validate'
import {
    BRow, BCol, BFormGroup, BFormInput, BFormTextarea, BForm, BButton, BFormDatepicker, BDropdown, BDropdownItem
    , BTable, BSpinner
} from 'bootstrap-vue'
import {required} from '@validations'
import Ripple from 'vue-ripple-directive'
import vSelect from 'vue-select'
import {ref, onUnmounted} from '@vue/composition-api'
import router from '@/router'
import axios from "@axios";
import {forMatIndianDateAndTime} from "@core/utils/utils";

export default {
    components: {
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
        BTable,
        BSpinner
    },
    directives: {
        Ripple,
    },
    props: {
        tableData: {
            type: Object
        },
        termData: {
            type: Array
        },
        termAndConditionOptions: {
            type: Array
        },
        partyId: {
            required: true
        }
    },
    setup(props, {termConditionModal}) {
        const updateKey = ref(0)

        termConditionModal = ref()
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
            if (modalTableFields.value.templateDataItems.length > 0){
                modalTableFields.value.templateDataItems.forEach((item) => {
                    props.termData.push({
                        "group": item.tcGroup,
                        "groupName": item.groupName,
                        "termAndCondition": item.tcDescription
                    })
                })
                updateKey.value = props.termData.length - 1
            }
        }

        console.log(props.partyId)

        const fromPartyMaster = async () => {
            await axios.get(`/api/party/get-party-term-condition/${props.partyId}`).then((response) => {
                if (response.data.data.length > 0) {
                    response.data.data.forEach((item) => {
                        props.termData.push({
                            "group": item.group,
                            "groupName": item.groupName,
                            "termAndCondition": item.termDetails
                        })
                    });
                    updateKey.value = props.termData.length - 1
                }
            })
        }

        const fromDefaultTerm = async () => {
            await axios.get('/api/get-default-term-template-by-type/1').then((res) => {
                if (res.data.data){
                    let terms = res.data.data.billing_items ?? []
                    terms.forEach((item) => {
                        props.termData.push({
                            "group": item.tcGroup,
                            "groupName": item.tcGroupName,
                            "termAndCondition": item.tcDescription
                        })
                    });
                    updateKey.value = props.termData.length - 1
                }
            });
        }

        return {
            updateKey,
            openTCTemplateModal,
            selectedTemplate,
            termConditionModal,
            getTemplate,
            modalTableFields,
            modalTableIsBusy,
            fromTemplateHandelOk,
            fromPartyMaster,
            fromDefaultTerm
        }
    },
    methods: {
        selectTermAndCondition(key) {
            this.updateKey = key
        },
        addNewTermAndCondition() {
            let formData = []
            formData.group = null
            formData.groupName = null
            formData.termAndCondition = null
            this.termData.push({...formData})
            let newKey = this.termData.length
            this.selectTermAndCondition(newKey - 1)
        },
        removeTermAndCondition(key) {
            this.termData.splice(key, 1)
            let newKey = this.termData.length
            this.selectTermAndCondition(newKey - 1)
        },
        getTermDefaultData(id, key) {
            this.$http.get(`/api/term-condition-detail-master/${id}`).then(res => {
                this.termData[key].groupName = res.data.data.tc_group_details.groupDescription
                this.termData[key].termAndCondition = res.data.data.tcGroupDescription
            })
        }
    }
}
</script>
