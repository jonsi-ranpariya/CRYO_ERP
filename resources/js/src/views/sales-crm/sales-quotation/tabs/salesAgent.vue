<template>
    <div>
        <b-row>
            <b-col md="12">
                <hr>
                <b-button
                    variant="primary"
                    type="button"
                    @click="addSalesPerson"
                >
                    Add New Sales Person
                </b-button>
                <hr>
                <b-table
                    :fields="tableData"
                    :items="salesAgentData"
                    responsive
                    bordered
                    hover
                    class="mb-0"
                    show-empty
                >
                    <template #empty="scope">
                        <h5 class="text-center text-uppercase">No Sales Agent Available</h5>
                    </template>
                    <template #cell(no)="data">
                        {{ data.index + 1 }}
                    </template>
                    <template #cell(salesAgent)="data">
                        {{ data.item.salesAgent ? data.item.salesAgent.label : '' }}
                    </template>
                    <template #cell(comm)="data">
                        <span v-if="data.item.commPercent > 0">{{ data.item.commPercent }}</span>
                        <span v-else-if="data.item.commValue > 0">{{ data.item.commValue }}</span>
                        <span v-else></span>
                    </template>
                    <template #cell(action)="data">
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
                                <b-dropdown-item @click="selectAgent(data.index)">
                                  <feather-icon
                                      icon="Edit2Icon"
                                      class="mr-50"
                                  />
                                  <span>Edit</span>
                                </b-dropdown-item>
                                <b-dropdown-item @click="removeAgent(data.index)">
                                  <feather-icon
                                      icon="TrashIcon"
                                      class="mr-50"
                                  />
                                  <span>Delete</span>
                                </b-dropdown-item>
                                </b-dropdown>
                            </span>
                        </template>
                    </template>
                </b-table>
            </b-col>
            <b-col
                md="12"
                v-if="salesAgentData.length > 0"
            >
                <hr>
                <b-form-group
                    label="Sales Agent"
                    label-for="salesAgent"
                >
                    <v-select
                        placeholder="Select Agent"
                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                        :options="userList"
                        :clearable="false"
                        input-id="salesAgent"
                        v-model="salesAgentData[updateKey].salesAgent"
                    />
                </b-form-group>
                <b-form-group
                    label="Sales Office"
                    label-for="salesOffice"
                >
                    <b-form-input
                        id="salesOffice"
                        v-model="salesAgentData[updateKey].salesOffice"
                    />
                </b-form-group>
                <b-form-group
                    label="Comm(%)"
                    label-for="commPercent"
                >
                    <b-form-input
                        id="commPercent"
                        type="number"
                        :disabled="salesAgentData[updateKey].commValue > 0"
                        v-model="salesAgentData[updateKey].commPercent"
                    />
                </b-form-group>
                <b-form-group
                    label="Comm Value"
                    label-for="commValue"
                >
                    <b-form-input
                        id="commValue"
                        type="number"
                        :disabled="salesAgentData[updateKey].commPercent > 0"
                        v-model="salesAgentData[updateKey].commValue"
                    />
                </b-form-group>
                <b-form-group
                    label="Remark"
                    label-for="remark"
                >
                    <b-form-textarea
                        id="remark"
                        rows="3"
                        v-model="salesAgentData[updateKey].remark"
                    />
                </b-form-group>
            </b-col>
        </b-row>
    </div>
</template>
<script>
    import {ValidationProvider, ValidationObserver} from 'vee-validate'
    import {
        BRow, BCol, BFormGroup, BFormInput, BFormTextarea, BForm, BButton, BFormDatepicker,BDropdown,BDropdownItem,BTable
    } from 'bootstrap-vue'
    import {required} from '@validations'
    import Ripple from 'vue-ripple-directive'
    import vSelect from 'vue-select'
    import {ref, onUnmounted} from '@vue/composition-api'
    import router from '@/router'

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
            BTable,
            vSelect
        },
        directives: {
            Ripple,
        },
        props: {
            tableData: {
                type: Array
            },
            salesAgentData: {
                type: Array
            },
            userList: {
                type: Array
            }
        },
        data() {
            return {
                isShow: false,
                updateKey: 0,
            }
        },
        methods: {
            selectAgent(key) {
                this.updateKey = key
            },
            addSalesPerson() {
                let salesPersonData = []
                salesPersonData.salesAgent = null
                salesPersonData.salesOffice = null
                salesPersonData.commPercent = 0
                salesPersonData.commValue = 0
                salesPersonData.remark = null
                this.salesAgentData.push({...salesPersonData})
                let newKey = this.salesAgentData.length
                this.selectAgent(newKey - 1)
            },
            removeAgent(key){
                this.salesAgentData.splice(key, 1)
                let newKey = this.salesAgentData.length
                this.selectAgent(newKey - 1)
            },
        }
    }
</script>
