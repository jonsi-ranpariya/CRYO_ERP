<template>
    <div>
        <b-row>
            <b-col md="12">
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
                        {{ data.item.salesAgent.label }}
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
                                      icon="CheckSquareIcon"
                                      class="mr-50"
                                  />
                                  <span>View</span>
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
                        disabled
                    />
                </b-form-group>
                <b-form-group
                    label="Sales Office"
                    label-for="salesOffice"
                >
                    <b-form-input
                        id="salesOffice"
                        v-model="salesAgentData[updateKey].salesOffice"
                        disabled
                    />
                </b-form-group>
                <b-form-group
                    label="Comm(%)"
                    label-for="commPercent"
                >
                    <b-form-input
                        id="commPercent"
                        type="number"
                        v-model="salesAgentData[updateKey].commPercent"
                        disabled
                    />
                </b-form-group>
                <b-form-group
                    label="Comm Value"
                    label-for="commValue"
                >
                    <b-form-input
                        id="commValue"
                        type="number"
                        v-model="salesAgentData[updateKey].commValue"
                        disabled
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
                        disabled
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
        setup: function () {
            const updateKey = ref(0)

            const selectAgent = (key) => {
                updateKey.value = key
            }

            return {
                updateKey,
                selectAgent,
            }
        }
    }
</script>
