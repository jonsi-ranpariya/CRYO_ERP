<template>
    <div>
        <b-row>
            <b-col md="12">
                <hr>
                <b-button
                    variant="primary"
                    type="button"
                    @click="changeBillingTermData()"
                >
                    Change Billing Term
                </b-button>
            </b-col>
        </b-row>
        <b-row>
            <b-col md="12">
                <div v-if="changeBillingTerm">
                    <hr>
                    <b-form-group
                        label="Change Billing Term"
                        label-for="billing-term"
                    >
                        <v-select
                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                            :options="billingOptions"
                            :clearable="false"
                            input-id="billing-term"
                            :reduce="val => val.value"
                            @input="getBillingData($event)"
                        />
                    </b-form-group>
                </div>
                <hr>
                <b-table
                    :fields="tableData.billingTermFields"
                    :items="billingData"
                    :bordered="true"
                    :hover="true"
                    show-empty
                    responsive
                    class="mb-0 table_scroll"
                >
                    <template #empty="scope">
                        <h5 class="text-center text-uppercase">No Billing Term Available</h5>
                    </template>
                    <template #cell(index)="data">
                        {{ data.index + 1 }}
                    </template>
                    <!--<template #cell(byValue)="data">
                        {{ billingTermCalculateData.netAmount }}
                    </template>-->
                    <template #cell(action)="data">
                        <template>
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
                                        icon="Edit2Icon"
                                        class="mr-50"
                                    />
                                    <span>Edit</span>
                                </b-dropdown-item>
                                <b-dropdown-item @click="removeBillingTerm(data.index)">
                                    <feather-icon
                                        icon="TrashIcon"
                                        class="mr-50"
                                    />
                                    <span>Delete</span>
                                </b-dropdown-item>
                            </b-dropdown>
                        </template>
                    </template>
                </b-table>
            </b-col>
        </b-row>
        <b-row v-if="editBillingTerm">
            <b-col md="12">
                <hr>
                <h4>Amount Details</h4>
                <hr>
            </b-col>
            <b-col md="12">
                <b-form-group
                    label="Cal Code"
                    label-for="calCode"
                >
                    <b-form-input
                        id="calCode"
                        placeholder="Cal Code"
                        readonly
                        v-model="billingData[updateKey].calCodeLabel"
                    />
                </b-form-group>
                <b-form-group
                    label="Narration"
                    label-for="narration"
                >
                    <b-form-input
                        id="narration"
                        placeholder="Narration"
                        readonly
                        v-model="billingData[updateKey].narration"
                    />
                </b-form-group>
                <b-form-group
                    label="Percentage"
                    label-for="percentage"
                >
                    <b-form-input
                        id="percentage"
                        placeholder="Percentage"
                        :disabled="billingData[updateKey].byValue > 0"
                        v-model="billingData[updateKey].percentage"
                    />
                </b-form-group>
                <b-form-group
                    label="Value"
                    label-for="byValue"
                >
                    <b-form-input
                        id="byValue"
                        placeholder="Value"
                        :disabled="billingData[updateKey].percentage > 0"
                        v-model="billingData[updateKey].byValue"
                    />
                </b-form-group>
                <hr>
                <b-button
                    type="button"
                    variant="primary"
                    @click="updateBillingTerm"
                >
                    Update Billing Term
                </b-button>
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
                type: Object,
            },
            billingOptions: {
                type: Array
            },
            billingTermCalculateData: {
                type: Object
            }
        },
        emit: ['updateBillingTermData'],
        data() {
            return {
                updateKey: 0,
                basicAmount: 0,
                editBillingTerm: false,
                changeBillingTerm: false,
            }
        },
        methods: {
            selectBillingTerm(key) {
                this.updateKey = key
                this.editBillingTerm = true
            },
            updateBillingTerm() {
                this.$emit('updateBillingTermData', true)
                this.editBillingTerm = false
            },
            removeBillingTerm(key) {
                this.billingData.splice(key, 1)
                let newKey = this.billingData.length
                this.selectBillingTerm(newKey - 1)
            },
            async getBillingData(id) {
                this.billingData.splice(0 ,this.billingData.length)
                await this.$http.get(`/api/billing-template-master/${id}`).then(res => {
                    if (res.data.data.billing_items) {
                        for (let i = 0; i < res.data.data.billing_items.length; i++) {
                            this.billingData.push({...res.data.data.billing_items[i]})
                        }
                        this.$emit('updateBillingTermData', true)
                    }
                })
            },
            changeBillingTermData() {
                this.changeBillingTerm = !this.changeBillingTerm
            }
        }
    }
</script>
