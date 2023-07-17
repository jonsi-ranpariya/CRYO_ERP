<template>
    <div>
        <b-row>
            <b-col md="12">
                <hr>
                <b-button
                    variant="primary"
                    type="button"
                    @click="addNewHistory"
                >
                    Add History
                </b-button>
            </b-col>
            <b-col md="12">
                <hr>
                <table class="table table-bordered table-striped table-hover table-responsive-sm table_scroll">
                    <th v-for="field in tableData" class="text-uppercase">{{ field.label }}</th>
                    <tr v-for="(item, key) in followUpData" v-if="followUpData.length > 0">
                        <td>{{ key + 1 }}</td>
                        <td>{{ item.date !== null ? item.date : '' }}</td>
                        <td>{{ item.history !== null ? item.history : '' }}</td>
                        <td v-if="typeof item.followUpBy === 'object' && item.followUpBy !== null">
                            {{ item.followUpBy.label }}
                        </td>
                        <td v-else></td>
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
                                <b-dropdown-item @click="selectHistory(key)">
                                  <feather-icon
                                      icon="Edit2Icon"
                                      class="mr-50"
                                  />
                                  <span>Edit</span>
                                </b-dropdown-item>
                                <b-dropdown-item @click="removeHistory(key)">
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
                        <td colspan="5" class="text-uppercase text-center">No History Available</td>
                    </tr>
                </table>
            </b-col>
            <b-col md="12" v-if="followUpData.length > 0">
                <hr>
                <h4>Quotation History</h4>
                <hr>
                <b-form-group
                    label="Date"
                    label-for="historyDate"
                >
                    <b-form-input
                        id="historyDate"
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
                    />
                </b-form-group>
            </b-col>
        </b-row>
    </div>
</template>
<script>
    import {ValidationProvider, ValidationObserver} from 'vee-validate'
    import {
        BRow,
        BCol, BFormGroup, BFormInput,
        BFormTextarea, BForm, BButton, BFormDatepicker,BDropdown,BDropdownItem
    } from 'bootstrap-vue'
    import Ripple from 'vue-ripple-directive'
    import vSelect from 'vue-select'
    import {forMatIndianDate} from "@core/utils/utils";
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
        data(){
            return {
                updateKey: 0
            }
        },
        methods: {
            selectHistory(key){
                this.updateKey = key
            },
            addNewHistory(){
                let formData = {
                    date: forMatIndianDate(new Date()),
                    history: null,
                    followUpBy: null
                }
                this.followUpData.push(formData)
                let newKey = this.followUpData.length
                this.selectHistory(newKey - 1)
            },
            removeHistory(key){
                this.followUpData.splice(key, 1)
                let updateKey = this.followUpData.length
                this.selectHistory(updateKey)
            },
        }
    }
</script>
