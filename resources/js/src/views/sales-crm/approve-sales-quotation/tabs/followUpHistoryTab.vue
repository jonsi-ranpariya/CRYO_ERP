<template>
    <div>
        <b-row>
            <b-col md="12">
                <hr>
                <b-table
                    :fields="tableData"
                    :items="followUpData"
                    responsive
                    bordered
                    hover
                    class="mb-0"
                    show-empty
                >
                    <template #empty="scope">
                        <h5 class="text-center text-uppercase">No Followup History Available</h5>
                    </template>
                    <template #cell(no)="data">
                        {{ data.index + 1 }}
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
                                <b-dropdown-item @click="selectHistory(data.index)">
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
            <b-col md="12" v-if="followUpData.length > 0">
                <hr>
                <h4>Quotation History</h4>
                <hr>
                <b-form-group
                    label="Date"
                    label-for="historyDate"
                >
                    <b-form-datepicker
                        id="historyDate"
                        :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }"
                        locale="in"
                        class="mb-1"
                        v-model="followUpData[updateKey].date"
                        disabled
                    />
                </b-form-group>
                <b-form-group
                    label="History"
                    label-for="history"
                >
                    <b-form-textarea
                        id="history"
                        rows="4"
                        v-model="followUpData[updateKey].history"
                        disabled
                    />
                </b-form-group>
                <b-form-group
                    label="Follow Up By"
                    label-for="followUpBy"
                >
                    <v-select
                        :options="usersList"
                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                        :clearable="false"
                        input-id="followUpBy"
                        v-model="followUpData[updateKey].followUpBy"
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
    import moment from 'moment'

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
            followUpData: {
                type: Array
            },
            usersList: {
                type: Array
            },
            tableData: {
                type: Array
            }
        },
        setup(){
            const updateKey = ref(0)

            const selectHistory = (key) => {
                updateKey.value = key
            }

            return {
                updateKey,
                selectHistory
            }
        }
    }
</script>
