<template>
    <b-row>
        <b-col md="12">
            <hr>
            <b-button
                variant="primary"
                type="button"
                @click="addNewItem"
            >
                Add Item
            </b-button>
            <hr>
            <b-table
                :fields="tableData.fields"
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
                <template #cell(uom)="data">
                    <span v-if="typeof data.item.uom_details === 'object' && data.item.uom_details !== null">{{ data.item.uom_details.uom }}</span>
                    <span v-else>{{ data.item.uom }}</span>
                </template>
                <template #cell(status)="data">
                    <span v-for="status in statusOptions">
                        <span v-if="data.item.status === status.value">{{ status.label }}</span>
                    </span>
                </template>
                <template #cell(action)="data">
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
                                icon="Edit2Icon"
                                class="mr-50"
                            />
                            <span>Edit</span>
                        </b-dropdown-item>
                        <b-dropdown-item @click="removeItem(data.index, data.item._id)">
                            <feather-icon
                                icon="TrashIcon"
                                class="mr-50"
                            />
                            <span>Delete</span>
                        </b-dropdown-item>
                    </b-dropdown>
                </template>
            </b-table>
        </b-col>
        <b-col md="12">
            <hr>
        </b-col>
        <b-col md="6" v-if="itemData.length > 0">
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
                    @input="changeItemDescription($event, updateKey)"
                />
            </b-form-group>
            <b-form-group
                label="Item Description"
                label-for="itemDescription"
            >
                <b-form-input
                    id="itemDescription"
                    v-model="itemData[updateKey].itemDescription"
                    :readonly="isReadOnly"
                />
            </b-form-group>
            <b-form-group
                label="Item Desc (Cust)"
                label-for="itemDescCust"
            >
                <b-form-textarea
                    id="itemDescCust"
                    v-model="itemData[updateKey].itemDescCust"
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
                />
            </b-form-group>
            <b-form-group
                label="Detail Description"
                label-for="detailDescription"
            >
                <b-form-textarea
                    id="detailDescription"
                    v-model="itemData[updateKey].detailDescription"
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
                        />
                    </b-form-group>
                </b-col>
                <b-col md="4">
                    <b-form-group
                        label="UOM"
                        label-for="uom"
                    >
                        <v-select
                            placeholder="Select UOM"
                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                            :options="uomOptions"
                            :clearable="false"
                            input-id="salesFrom"
                            :reduce="val => val.value"
                            v-model="itemData[updateKey].uom"
                        />
                    </b-form-group>
                </b-col>
            </b-row>
        </b-col>
        <b-col md="6" v-if="itemData.length > 0">
            <b-form-group
                label="Item Note"
                label-for="itemNot"
            >
                <b-form-textarea
                    id="itemNote"
                    rows="2"
                    v-model="itemData[updateKey].itemNote"
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
                            v-model="itemData[updateKey].requireQty"
                            value="0"
                            @keyup="calculateAmount(updateKey)"
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
                            @keyup="calculateAmount(updateKey)"
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
                            @keyup="calculateAmount(updateKey)"
                        />
                    </b-form-group>
                    <b-form-group
                        label="Disc(Value)"
                        label-for="discValue"
                    >
                        <b-form-input
                            id="discValue"
                            type="number"
                            value="0"
                            v-model="itemData[updateKey].discValue"
                            @input="getItemDiscountCalculation(updateKey)"
                            :max="itemData[updateKey].rate"
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
                />
            </b-form-group>
            <b-form-group
                label="Cust Part No."
                label-for="custPartNo"
            >
                <b-form-input
                    id="custPartNo"
                    v-model="itemData[updateKey].custPartNo"
                />
            </b-form-group>
            <b-form-group
                label="Part No."
                label-for="partNo"
            >
                <b-form-input
                    id="partNo"
                    v-model="itemData[updateKey].partNo"
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
    import {changeToRound} from "@core/utils/utils";

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
                type: Object,
            },
            uomOptions: {
                type: Array,
            },
            itemOptions: {
                type: Array
            },
            roundingType: {
                required: true,
            }
        },
        emit: ['updateBillingTermData'],
        setup(props) {
            const updateKey = ref(0)
            const isReadOnly = ref(false)

            const statusOptions = ref([
                {label: 'Hot', value: 0},
                {label: 'Cold', value: 1},
                {label: 'Received', value: 2},
                {label: 'Regret', value: 3},
                {label: 'Lost', value: 4},
            ])

            const addNewItem = () => {
                let extraData = {
                    itemCode: null,
                    itemDescription: null,
                    itemDescCust: null,
                    addDescription: null,
                    detailDescription: null,
                    drawingNumber: null,
                    rev: null,
                    uom: null,
                    totalAmount: 0,
                    itemNote: null,
                    qty: 0,
                    rate: 0,
                    amount: 0,
                    status: 0,
                    discPercent: 0,
                    discValue: 0,
                    netAmount: 0,
                    custPartNo: null,
                    partNo: null,
                }
                props.itemData.push(extraData)
                let newIndex = props.itemData.length
                selectItem(newIndex - 1)
            }

            const selectItem = (key) => {
                updateKey.value = key
            }

            return {
                updateKey,
                isReadOnly,
                statusOptions,
                addNewItem,
                selectItem,
            }
        },
        methods: {
            removeItem(key, quotationItemId) {
                this.$swal({
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
                        if (quotationItemId) {
                            axios.delete(`/api/remove-sales-item/${quotationItemId}`)
                        }
                        this.itemData.splice(key, 1);
                        let newIndex = this.itemData.length
                        this.selectItem(newIndex - 1)
                        this.$toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: `Deleted`,
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: `Party Master Delete Successfully`,
                            },
                        })
                    }
                })
            },
            async changeItemDescription(e, key) {
                if (e !== null) {
                    this.isReadOnly = true
                    await axios.get(`/api/item-master/${e.value}`).then(res => {
                        this.itemData[key].itemDescription = res.data.data?.itemDescription ?? null
                        this.itemData[key].detailDescription = res.data.data?.itemDetails?.detailDescription ?? null
                        this.itemData[key].drawingNumber = res.data.data?.itemDetails?.drawingNumber ?? null
                        this.itemData[key].rev = res.data.data?.itemDetails?.revision ?? null
                        this.itemData[key].uom = res.data.data?.convUom ?? null
                        this.itemData[key].addDescription = res.data.data?.itemDetails?.description ?? null
                    })
                } else {
                    this.isReadOnly = false
                }
            },
            calculateAmount(key) {
                if (this.roundingType === '0' || this.roundingType === '1'){
                    this.itemData[key].amount = parseFloat(this.itemData[key]?.requireQty * this.itemData[key]?.rate).toFixed(2)
                    this.itemData[key].discValue = parseFloat((this.itemData[key]?.amount * this.itemData[key]?.discPercent) / 100).toFixed(2)
                    this.itemData[key].netAmount = parseFloat(this.itemData[key]?.amount - this.itemData[key]?.discValue).toFixed(2)
                }
                if(this.roundingType === '2'){
                    this.itemData[key].amount = changeToRound(parseFloat(this.itemData[key]?.requireQty * this.itemData[key]?.rate).toFixed(2))
                    this.itemData[key].discValue = changeToRound(parseFloat((this.itemData[key]?.amount * this.itemData[key]?.discPercent) / 100).toFixed(2))
                    this.itemData[key].netAmount = changeToRound(parseFloat(this.itemData[key]?.amount - this.itemData[key]?.discValue).toFixed(2))
                }
                this.$emit('updateBillingTermData', true);
            },
            getItemDiscountCalculation(key) {
                let itemAmount = parseFloat(this.itemData[key]?.requireQty * this.itemData[key]?.rate);
                let discountValue = parseFloat(this.itemData[key]?.discValue);

                if (this.roundingType === '0' || this.roundingType === '1') {
                    this.itemData[key].discPercent = parseFloat(parseFloat((discountValue / itemAmount) * 100).toFixed(2));
                    this.itemData[key].netAmount = parseFloat(itemAmount - discountValue).toFixed(2);
                }
                if (this.roundingType === '2') {
                    this.itemData[key].discPercent = changeToRound(parseFloat(parseFloat((discountValue / itemAmount) * 100).toFixed(2)));
                    this.itemData[key].netAmount = changeToRound(parseFloat(itemAmount - discountValue).toFixed(2)) ;
                }

                this.$emit('updateBillingTermData', true);
            }
        },
    }
</script>
<style lang="scss">
    @import '~@core/scss/vue/libs/vue-sweetalert.scss';
</style>
