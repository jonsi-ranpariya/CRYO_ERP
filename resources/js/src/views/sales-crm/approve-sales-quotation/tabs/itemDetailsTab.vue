<template>
    <b-row>
        <b-col md="12">
            <hr>
            <b-table
                :fields="tableData"
                :items="itemData"
                responsive
                bordered
                hover
                class="mb-0"
                show-empty
            >
                <template #empty="scope">
                    <h5 class="text-center text-uppercase">No Item Available</h5>
                </template>
                <template #cell(srNo)="data">
                    {{ data.index + 1 }}
                </template>
                <template #cell(itemCode)="data">
                    {{ data.item.itemCode.label ? data.item.itemCode.label : data.item.itemCode ? data.item.itemCode : null }}
                </template>
                <template #cell(uom)="data">
                    <span v-if="typeof data.item.uom_details === 'object' && data.item.uom_details !== null">{{ data.item.uom_details.uom }}</span>
                    <span v-else>{{ data.item.uom }}</span>
                </template>
                <template #cell(status)="data">
                    <span v-for="status in statusOptions">
                        <span v-if="status.value === data.item.status">{{ status.label }}</span>
                    </span>
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
                                <b-dropdown-item @click="selectItem(data.index)">
                                  <feather-icon
                                      icon="CheckSquareIcon"
                                      class="mr-50"
                                  />
                                  <span>Select</span>
                                </b-dropdown-item>
                            </b-dropdown>
                        </span>
                    </template>
                </template>
            </b-table>
        </b-col>
        <b-col md="12">
            <hr>
        </b-col>
        <b-col md="6" v-if="itemData">
            <b-form-group
                label="Item Code"
                label-for="itemCode"
            >
                <v-select
                    placeholder="Select Item"
                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                    :options="itemOptions"
                    :clearable="false"
                    input-id="itemCode"
                    v-model="itemData[updateKey].itemCode"
                    disabled
                />
            </b-form-group>
            <b-form-group
                label="Item Description"
                label-for="itemDescription"
            >
                <b-form-input
                    id="itemDescription"
                    v-model="itemData[updateKey].itemDescription"
                    disabled
                />
            </b-form-group>
            <b-form-group
                label="Item Desc (Cust)"
                label-for="itemDescCust"
            >
                <b-form-textarea
                    id="itemDescCust"
                    v-model="itemData[updateKey].itemDescCust"
                    disabled
                    rows="2"
                />
            </b-form-group>
            <b-form-group
                label="Add Description"
                label-for="addDescription"
            >
                <b-form-input
                    id="addDescription"
                    v-model="itemData[updateKey].addDescription"
                    disabled
                />
            </b-form-group>
            <b-form-group
                label="Detail Description"
                label-for="detailDescription"
            >
                <b-form-textarea
                    id="detailDescription"
                    v-model="itemData[updateKey].detailDescription"
                    disabled
                    rows="3"
                />
            </b-form-group>
            <b-form-group
                label="Drawing No."
                label-for="drawingNo"
            >
                <b-form-input
                    id="drawingNo"
                    v-model="itemData[updateKey].drawingNumber"
                    disabled
                />
            </b-form-group>
            <b-row>
                <b-col md="8">
                    <b-form-group
                        label="Drawing Revision"
                        label-for="drawingRevision"
                    >
                        <b-form-input
                            id="drawingRevision"
                            v-model="itemData[updateKey].rev"
                            disabled
                        />
                    </b-form-group>
                </b-col>
                <b-col md="4">
                    <b-form-group
                        label="UOM"
                        label-for="uom"
                    >
                        <v-select
                            placeholder="Select UOm"
                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                            :options="uomOptions"
                            :clearable="false"
                            input-id="salesFrom"
                            :reduce="val => val.value"
                            v-model="itemData[updateKey].uom"
                            disabled
                        />
                    </b-form-group>
                </b-col>
            </b-row>
        </b-col>
        <b-col md="6" v-if="itemData">
            <b-form-group
                label="Item Note"
                label-for="itemNot"
            >
                <b-form-textarea
                    id="itemNote"
                    rows="2"
                    v-model="itemData[updateKey].itemNote"
                    disabled
                />
            </b-form-group>
            <b-row>
                <b-col md="6">
                    <b-form-group
                        label="Quantity"
                        label-for="qty"
                    >
                        <b-form-input
                            id="qty"
                            type="number"
                            v-model="itemData[updateKey].qty"
                            value="0"
                            disabled
                        />
                    </b-form-group>
                    <b-form-group
                        label="Rate"
                        label-for="rate"
                    >
                        <b-form-input
                            id="rate"
                            type="number"
                            v-model="itemData[updateKey].rate"
                            value="0"
                            disabled
                        />
                    </b-form-group>
                    <b-form-group
                        label="Amount"
                        label-for="amount"
                    >
                        <b-form-input
                            id="amount"
                            type="number"
                            readonly
                            v-model="itemData[updateKey].amount"
                            value="0"
                            disabled
                        />
                    </b-form-group>
                </b-col>
                <b-col md="6">
                    <b-form-group
                        label="Disc(%)"
                        label-for="discPercent"
                    >
                        <b-form-input
                            id="discPercent"
                            type="number"
                            v-model="itemData[updateKey].discPercent"
                            value="0"
                            disabled
                        />
                    </b-form-group>
                    <b-form-group
                        label="Disc(Value)"
                        label-for="discValue"
                    >
                        <b-form-input
                            id="discValue"
                            type="number"
                            readonly
                            value="0"
                            v-model="itemData[updateKey].discValue"
                            disabled
                        />
                    </b-form-group>
                    <b-form-group
                        label="Net Amount"
                        label-for="netAmount"
                    >
                        <b-form-input
                            id="netAmount"
                            type="number"
                            readonly
                            value="0"
                            v-model="itemData[updateKey].netAmount"
                            disabled
                        />
                    </b-form-group>
                </b-col>
            </b-row>
            <b-form-group
                label="Total Amount"
                label-for="totalAmount"
            >
                <b-form-input
                    id="totalAmount"
                    type="number"
                    readonly
                    v-model="itemData[updateKey].totalAmount === 0 ? itemData[updateKey].total_amount : itemData[updateKey].totalAmount"
                    disabled
                />
            </b-form-group>
            <b-form-group
                label="Status"
                label-for="status"
            >
                <v-select
                    placeholder="Select Status"
                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                    :options="statusOptions"
                    :reduce="val => val.value"
                    :clearable="false"
                    input-id="status"
                    v-model="itemData[updateKey].status"
                    disabled
                />
            </b-form-group>
            <b-form-group
                label="Cust Part No."
                label-for="custPartNo"
            >
                <b-form-input
                    id="custPartNo"
                    v-model="itemData[updateKey].custPartNo"
                    disabled
                />
            </b-form-group>
            <b-form-group
                label="Part No."
                label-for="partNo"
            >
                <b-form-input
                    id="partNo"
                    v-model="itemData[updateKey].partNo"
                    disabled
                />
            </b-form-group>
        </b-col>
    </b-row>
</template>
<script>
    import BCardCode from '@core/components/b-card-code'
    import {ValidationProvider, ValidationObserver} from 'vee-validate'
    import {
        BRow, BCol, BFormGroup, BFormInput, BFormTextarea, BForm, BButton, BFormDatepicker, BTab, BTabs,
        BTable,
        BDropdown,
        BDropdownItem,
    } from 'bootstrap-vue'
    import {required} from '@validations'
    import Ripple from 'vue-ripple-directive'
    import vSelect from 'vue-select'
    import store from '@/store'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import {ref, computed, onUnmounted} from '@vue/composition-api'
    import axios from '@axios'

    export default {
        components: {
            BCardCode,
            ValidationProvider,
            ValidationObserver,
            BRow,
            BCol,
            BFormGroup,
            BFormInput,
            BFormTextarea,
            BForm,
            BButton,
            BFormDatepicker,
            BTab,
            BTabs,
            BTable,
            BDropdown,
            BDropdownItem,
            vSelect
        },
        directives: {
            Ripple,
        },
        props: {
            itemData: {
                type: Array,
            },
            tableData: {
                type: Array,
            },
            uomOptions: {
                type: Array,
            },
            itemOptions: {
                type: Array
            }
        },
        setup() {
            const updateKey = ref(0)

            const statusOptions = ref([
                {label: 'Hot', value: 0},
                {label: 'Cold', value: 1},
                {label: 'Received', value: 2},
                {label: 'Regret', value: 3},
                {label: 'Lost', value: 4},
            ])

            const selectItem = (key) => {
                updateKey.value = key
            }

            return {
                updateKey,
                statusOptions,
                selectItem
            }
        },
        methods: {

        }
    }
</script>
