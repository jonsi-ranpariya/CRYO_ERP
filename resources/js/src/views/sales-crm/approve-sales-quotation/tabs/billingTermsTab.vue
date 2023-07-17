<template>
    <div>
        <b-row>
            <b-col md="12">
                <hr>
                <b-table
                    :fields="tableData"
                    :items="billingData"
                    responsive
                    bordered
                    hover
                    class="mb-0 table_scroll"
                    show-empty
                >
                    <template #empty="scope">
                        <h5 class="text-center text-uppercase">No Billing Terms Available</h5>
                    </template>
                    <template #cell(index)="data">
                        {{ data.index + 1 }}
                    </template>
                    <template #cell(defaultValue)="data">
                        <span>{{ data.item.percentage ? data.item.percentage : data.item.value ? data.item.value : '' }}</span>
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
                                    <b-dropdown-item @click="selectBillingTerm(data.index)">
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
            <hr>
            <b-col md="12" v-if="billingData.length > 0">
                <hr>
                <h4>Amount Details</h4>
            </b-col>
            <b-col md="12" v-if="billingData.length > 0">
                <hr>
                <b-row>
                    <b-col md="6">
                        <b-form-group
                            label="Billing Term"
                            label-for="billing-term"
                        >
                            <v-select
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="billingOptions"
                                :clearable="false"
                                input-id="billing-term"
                                :reduce="val => val.value"
                                v-model="billingData[updateKey].calCode"
                                disabled
                            />
                        </b-form-group>
                        <b-form-group
                            label="Cal Code"
                            label-for="calCodeLabel"
                        >
                            <b-form-input
                                id="calCodeLabel"
                                placeholder="Value"
                                v-model="billingData[updateKey].calCodeLabel"
                                readonly
                            />
                        </b-form-group>
                        <b-form-group
                            label="Defination"
                            label-for="calDefination"
                        >
                            <b-form-input
                                id="calDefination"
                                placeholder="Value"
                                v-model="billingData[updateKey].calDefination"
                                readonly
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="6">
                        <b-form-group
                            label="Narration"
                            label-for="narration"
                        >
                            <b-form-input
                                id="narration"
                                v-model="billingData[updateKey].narration"
                                readonly
                            />
                        </b-form-group>
                        <div v-if="isBillingValueShow">
                            <b-form-group
                                label="Value"
                                label-for="billing-value"
                            >
                                <b-form-input
                                    id="billing-value"
                                    placeholder="Value"
                                    v-model="billingData[updateKey].byValue"
                                    readonly
                                />
                            </b-form-group>
                        </div>
                        <div v-if="isBillingPercentShow">
                            <b-form-group
                                label="Percentage"
                                label-for="billing-percentage"
                            >
                                <b-form-input
                                    id="billing-percentage"
                                    placeholder="Percentage"
                                    v-model="billingData[updateKey].percentage"
                                    readonly
                                />
                            </b-form-group>
                        </div>
                        <b-form-group
                            label="Amount"
                            label-for="calculateAmount"
                        >
                            <b-form-input
                                id="calculateAmount"
                                placeholder="Value"
                                v-model="billingData[updateKey].calculateAmount"
                                readonly
                            />
                        </b-form-group>
                    </b-col>
                </b-row>
            </b-col>
        </b-row>
    </div>
</template>
<script>
    import {ValidationProvider, ValidationObserver} from 'vee-validate'
    import {
        BRow,
        BCol,
        BFormGroup,
        BFormInput,
        BFormTextarea,
        BForm,
        BButton,
        BFormDatepicker,
        BDropdown,
        BDropdownItem,
        BTable
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
            billingData: {
                type: Array,
            },
            tableData: {
                type: Array,
            },
            billingOptions: {
                type: Array
            }
        },
        setup(props) {
            const updateKey = ref(0)
            const isBillingPercentShow = ref(false)
            const isBillingValueShow = ref(false)

            const selectBillingTerm = (key) => {
                updateKey.value = key
                if (props.billingData[key].type === 0) {
                    isBillingPercentShow.value = true
                    isBillingValueShow.value = false
                }

                if (props.billingData[key].type === 1) {
                    isBillingValueShow.value = true
                    isBillingPercentShow.value = false
                }
            }

            return {
                updateKey,
                isBillingPercentShow,
                isBillingValueShow,
                selectBillingTerm,
            }
        }
    }
</script>
