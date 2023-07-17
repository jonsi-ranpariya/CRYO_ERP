<template>
    <div>
        <b-row>
            <b-col md="12">
                <hr>
                <b-table
                    :fields="tableData"
                    :items="termData"
                    responsive
                    bordered
                    hover
                    class="mb-0"
                    show-empty
                >
                    <template #empty="scope">
                        <h5 class="text-center text-uppercase">No Billing Terms Available</h5>
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
                                <b-dropdown-item @click="selectTermAndCondition(data.index)">
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
                        disabled
                    />
                </b-form-group>
                <b-form-group
                    label="Term & Condition"
                    label-for="termAndCondition"
                >
                    <b-form-textarea
                        rows="3"
                        id="termAndCondition"
                        v-model="termData[updateKey].termAndCondition"
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
            termData: {
                type: Array
            },
            termAndConditionOptions: {
                type: Array
            }
        },
        setup: function () {
            const updateKey = ref(0)

            const selectTermAndCondition = (key) => {
                updateKey.value = key
            }

            return {
                updateKey,
                selectTermAndCondition
            }
        }
    }
</script>
