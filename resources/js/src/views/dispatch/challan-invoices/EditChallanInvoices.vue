<template>
    <b-card-code>
        <validation-observer ref="simpleRules">
            <b-form>
                <b-row>
                    <b-col md="4">
                        <b-form-group
                            label="party code"
                            label-for="party-code"
                        >
                            <validation-provider
                                #default="{ errors }"
                                name="Party Code"
                                rules="required"
                            >
                                <b-form-input
                                    id="party-code"
                                    v-model="invoiceFormData.partyCode"
                                    placeholder="party code"
                                    :state="errors.length > 0 ? false:null"
                                />
                                <small class="text-danger">{{ errors[0] }}</small>
                            </validation-provider>
                        </b-form-group>
                    </b-col>
                    <b-col md="4">
                        <b-form-group
                            label="Invoice No"
                            label-for="invoice-no"
                        >
                            <b-form-input
                                id="invoice-no"
                                v-model="invoiceFormData.invoiceNo"
                                placeholder="Invoice No"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="4">
                        <b-form-group
                            label="Invoice Date"
                            label-for="invoice-date"
                        >
                            <b-form-datepicker
                                id="invoice-date"
                                v-model="invoiceFormData.invoiceDate"
                                :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }"
                                placeholder="Invoice Date"
                            />
                        </b-form-group>
                    </b-col>

                    <b-col md="6">
                        <b-form-group
                            label="Challan No."
                            label-for="challan-no"
                        >
                            <b-form-input
                                id="challan-no"
                                v-model="invoiceFormData.challanNo"
                                placeholder="Challan No"
                            />
                        </b-form-group>
                    </b-col>

                    <b-col md="6">
                        <b-form-group
                            label="Order No."
                            label-for="order-no"
                        >
                            <b-form-input
                                id="order-no"
                                v-model="invoiceFormData.orderNo"
                                placeholder="Order No."
                            />
                        </b-form-group>
                    </b-col>

                </b-row>

                <b-row>

                    <b-col md="6" style="border-right: 1px solid #ebe9f1;">

                        <b-row>

                            <b-col md="12">

                                <hr>
                                <h6>Bill To Party</h6>
                                <hr>

                            </b-col>

                            <b-col md="4">
                                <b-form-group
                                    label="Bill To GSTIN"
                                    label-for="invoice-bill-to-gst"
                                >
                                    <b-form-input
                                        id="invoice-bill-to-gst"
                                        v-model="invoiceFormData.billToPartyGst"
                                        placeholder="Bill To GSTIN"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="8">
                                <b-form-group
                                    label="Bill To Party Name"
                                    label-for="invoice-bill-to-party"
                                >
                                    <b-form-input
                                        id="invoice-bill-to-party"
                                        v-model="invoiceFormData.billToPartyName"
                                        placeholder="Bill To Party"
                                    />
                                </b-form-group>
                            </b-col>

                            <b-col md="12">
                                <b-form-group
                                    label="Bill To Party Address"
                                    label-for="invoice-bill-to-address"
                                >
                                    <b-form-textarea
                                        id="invoice-bill-to-address"
                                        v-model="invoiceFormData.billToPartyAddress"
                                        placeholder="Bill To Party Address"
                                        rows="2"
                                    />
                                </b-form-group>
                            </b-col>

                            <b-col md="4">
                                <b-form-group
                                    label="Bill To State"
                                    label-for="invoice-bill-to-state"
                                >
                                    <b-form-input
                                        id="invoice-bill-to-state"
                                        v-model="invoiceFormData.billToPartyState"
                                        placeholder="Bill To State"
                                    />
                                </b-form-group>
                            </b-col>

                            <b-col md="4">
                                <b-form-group
                                    label="Bill To Country"
                                    label-for="invoice-bill-to-country"
                                >
                                    <b-form-input
                                        id="invoice-bill-to-country"
                                        v-model="invoiceFormData.billToPartyCountry"
                                        placeholder="Bill To Country"
                                    />
                                </b-form-group>
                            </b-col>

                            <b-col md="4">
                                <b-form-group
                                    label="Bill To PAN NO"
                                    label-for="invoice-bill-to-pan-no"
                                >
                                    <b-form-input
                                        id="invoice-bill-to-pan-no"
                                        v-model="invoiceFormData.billToPartyPanNo"
                                        placeholder="Bill To PAN NO"
                                    />
                                </b-form-group>
                            </b-col>

                            <b-col md="12">
                                <b-form-group
                                    label="Bill To Kind Attn."
                                    label-for="invoice-bill-to-attn"
                                >
                                    <b-form-input
                                        id="invoice-bill-to-attn"
                                        v-model="invoiceFormData.billToPartyAttn"
                                        placeholder="Bill To Bill To Kind Attn."
                                    />
                                </b-form-group>
                            </b-col>

                        </b-row>

                    </b-col>

                    <b-col md="6">

                        <b-row>

                            <b-col md="12">

                                <hr>
                                <h6>Ship To Party</h6>
                                <hr>

                            </b-col>

                            <b-col md="4">
                                <b-form-group
                                    label="SHIP To GSTIN"
                                    label-for="invoice-ship-to-gst"
                                >
                                    <b-form-input
                                        id="invoice-ship-to-gst"
                                        v-model="invoiceFormData.shipToPartyGst"
                                        placeholder="SHIP To GSTIN"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="8">
                                <b-form-group
                                    label="SHIP To Party Name"
                                    label-for="invoice-ship-to-party"
                                >
                                    <b-form-input
                                        id="invoice-ship-to-party"
                                        v-model="invoiceFormData.shipToPartyName"
                                        placeholder="SHIP To Party"
                                    />
                                </b-form-group>
                            </b-col>

                            <b-col md="12">
                                <b-form-group
                                    label="SHIP To Party Address"
                                    label-for="invoice-ship-to-address"
                                >
                                    <b-form-textarea
                                        id="invoice-ship-to-address"
                                        v-model="invoiceFormData.shipToPartyAddress"
                                        placeholder="SHIP To Party Address"
                                        rows="2"
                                    />
                                </b-form-group>
                            </b-col>

                            <b-col md="4">
                                <b-form-group
                                    label="SHIP To State"
                                    label-for="invoice-ship-to-state"
                                >
                                    <b-form-input
                                        id="invoice-ship-to-state"
                                        v-model="invoiceFormData.shipToPartyState"
                                        placeholder="SHIP To State"
                                    />
                                </b-form-group>
                            </b-col>

                            <b-col md="4">
                                <b-form-group
                                    label="SHIP To Country"
                                    label-for="invoice-ship-to-country"
                                >
                                    <b-form-input
                                        id="invoice-ship-to-country"
                                        v-model="invoiceFormData.shipToPartyCountry"
                                        placeholder="SHIP To Country"
                                    />
                                </b-form-group>
                            </b-col>

                            <b-col md="4">
                                <b-form-group
                                    label="SHIP To PAN NO"
                                    label-for="invoice-ship-to-pan-no"
                                >
                                    <b-form-input
                                        id="invoice-ship-to-pan-no"
                                        v-model="invoiceFormData.shipToPartyPanNo"
                                        placeholder="SHIP To PAN NO"
                                    />
                                </b-form-group>
                            </b-col>


                        </b-row>

                    </b-col>

                </b-row>

                <b-row>

                    <b-col cols="12">
                        <hr>
                        <h6>Add Invoice Items</h6>
                        <hr>
                    </b-col>

                </b-row>

                <div
                    ref="form"
                    class="repeater-form"
                    :style="{height: trHeight}"
                >
                    <b-row
                        v-for="(item, index) in invoiceFormData.invoiceItemList"
                        :id="item.id"
                        :key="item.id"
                        ref="row"
                    >

                        <!-- Item Name -->
                        <b-col md="3">
                            <b-form-group
                                label="Item Details"
                                label-for="item-name"
                            >
                                <b-form-textarea
                                    id="item-name"
                                    v-model="item.item_detail"
                                    placeholder="Item Details"
                                    rows="1"
                                />
                            </b-form-group>
                        </b-col>

                        <!-- HSN/SA -->
                        <b-col md="2">
                            <b-form-group
                                label="HSN/SAC"
                                label-for="hsn-sac"
                            >
                                <b-form-input
                                    id="hsn-sac"
                                    v-model="item.hsn_sac"
                                    type="text"
                                    placeholder="HSN/SAC"
                                />
                            </b-form-group>
                        </b-col>

                        <!-- HSN/SA -->
                        <b-col md="1">
                            <b-form-group
                                label="UOM"
                                label-for="uom"
                            >
                                <b-form-input
                                    id="uom"
                                    v-model="item.uom"
                                    type="text"
                                    placeholder="UOM"
                                />
                            </b-form-group>
                        </b-col>


                        <!-- Quantity -->
                        <b-col md="1">
                            <b-form-group
                                label="Quantity"
                                label-for="quantity"
                            >
                                <b-form-input
                                    id="quantity"
                                    v-model="item.qty"
                                    type="number"
                                    placeholder="0"
                                    value="0"
                                />
                            </b-form-group>
                        </b-col>

                        <!-- Cost -->
                        <b-col md="2">
                            <b-form-group
                                label="Rate"
                                label-for="cost"
                            >
                                <b-form-input
                                    id="cost"
                                    v-model="item.cost"
                                    type="number"
                                    placeholder="0"
                                    value="0"
                                />
                            </b-form-group>
                        </b-col>

                        <!-- Profession -->
                        <b-col md="2">
                            <b-form-group
                                label="Amount(INR)"
                                label-for="total_amount"
                            >
                                <b-form-input
                                    id="total_amount"
                                    v-model="item.total_amount = item.cost * item.qty"
                                />
                            </b-form-group>
                        </b-col>

                        <!-- Remove Button -->
                        <b-col md="1">
                            <b-button
                                variant="gradient-danger"
                                class="mt-0 mt-md-2"
                                @click="removeItem(index)"
                            >
                                <feather-icon
                                    icon="TrashIcon"
                                />
                            </b-button>
                        </b-col>
                        <b-col cols="12">
                            <hr>
                        </b-col>
                    </b-row>

                </div>

                <b-row>

                    <b-col cols="12">

                        <b-button
                            v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                            variant="primary"
                            @click="repeateAgain"
                        >
                            <feather-icon
                                icon="PlusIcon"
                                class="mr-25"
                            />
                            <span>Add New Item</span>
                        </b-button>

                    </b-col>

                </b-row>

                <b-row>

                    <b-col cols="12">

                        <hr>
                        <h6>Apply Tax Value</h6>
                        <hr>

                    </b-col>

                </b-row>

                <b-row>

                    <b-col md="3">
                        <b-form-group
                            label="CGST %"
                            label-for="cgst"
                        >
                            <b-form-input
                                id="cgst"
                                v-model="invoiceFormData.cgstTax"
                                type="number"
                                placeholder="CGST %"
                                value="0.00"
                            />
                        </b-form-group>
                    </b-col>

                    <b-col md="3">
                        <b-form-group
                            label="SGST %"
                            label-for="sgst"
                        >
                            <b-form-input
                                id="sgst"
                                v-model="invoiceFormData.sgstTax"
                                type="number"
                                placeholder="SGST %"
                                value="0.00"
                            />
                        </b-form-group>
                    </b-col>

                    <b-col md="3">
                        <b-form-group
                            label="IGST %"
                            label-for="igst"
                        >
                            <b-form-input
                                id="igst"
                                v-model="invoiceFormData.igstTax"
                                type="number"
                                placeholder="IGST %"
                                value="0.00"
                            />
                        </b-form-group>
                    </b-col>

                    <b-col md="3">
                        <b-form-group
                            label="UGST %"
                            label-for="ugst"
                        >
                            <b-form-input
                                id="ugst"
                                v-model="invoiceFormData.ugstTax"
                                type="number"
                                placeholder="UGST %"
                                value="0.00"
                            />
                        </b-form-group>
                    </b-col>

                </b-row>

                <b-row>

                    <b-col cols="12">

                        <hr>


                    </b-col>

                </b-row>

                <b-row>

                    <!-- Col: Sales Terms -->

                    <b-col cols="12" md="8" order="2" order-md="1">
                        <b-row>
                            <b-col md="4">
                                <b-form-group
                                    label="Transporter"
                                    label-for="transporter"
                                >
                                    <b-form-input
                                        id="transporter"
                                        v-model="invoiceFormData.transporter"
                                        placeholder="Transporter"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group
                                    label="Vehicle No."
                                    label-for="vehicle-no"
                                >
                                    <b-form-input
                                        id="vehicle-no"
                                        v-model="invoiceFormData.vehicleNo"
                                        placeholder="Vehicle No."
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group
                                    label="L.R. No. & Date"
                                    label-for="lr-no-date"
                                >
                                    <b-form-input
                                        id="lr-no-date"
                                        v-model="invoiceFormData.lrNo"
                                        placeholder="L.R. No. & Date"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="12">
                                <b-form-group
                                    label="Payment Terms and Other Details"
                                    label-for="invoice-terms-details"
                                >
                                    <b-form-textarea
                                        id="invoice-terms-details"
                                        v-model="invoiceFormData.paymentTerm"
                                        rows="2"
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>
                    </b-col>

                    <!-- Col: Total -->
                    <b-col
                        cols="12"
                        md="4"
                        class="mt-md-6 d-flex justify-content-end"
                        order="1"
                        order-md="2"
                    >
                        <div class="invoice-total-wrapper">
                            <div class="invoice-total-item">
                                <p class="invoice-total-title">
                                    Basic Amount:
                                </p>
                                <p class="invoice-total-amount">
                                    {{ decimalDigits(subTotal) }}
                                </p>
                            </div>
                            <div class="invoice-total-item">
                                <p class="invoice-total-title">
                                    Sub Total:
                                </p>
                                <p class="invoice-total-amount">
                                    {{ decimalDigits(subTotal) }}
                                </p>
                            </div>
                            <div class="invoice-total-item" v-if="invoiceFormData.cgstTax">
                                <p class="invoice-total-title">
                                    CGST({{ decimalDigits(invoiceFormData.cgstTax) }}%):
                                </p>
                                <p class="invoice-total-amount">
                                    {{ decimalDigits(CgstTaxTotal) }}
                                </p>
                            </div>
                            <div class="invoice-total-item" v-if="invoiceFormData.sgstTax">
                                <p class="invoice-total-title">
                                    SGST({{ decimalDigits(invoiceFormData.sgstTax) }}%):
                                </p>
                                <p class="invoice-total-amount">
                                    {{ decimalDigits(SgstTaxTotal) }}
                                </p>
                            </div>
                            <div class="invoice-total-item" v-if="invoiceFormData.igstTax">
                                <p class="invoice-total-title">
                                    IGST({{ decimalDigits(invoiceFormData.igstTax) }}%):
                                </p>
                                <p class="invoice-total-amount">
                                    {{ decimalDigits(IgstTaxTotal) }}
                                </p>
                            </div>
                            <div class="invoice-total-item" v-if="invoiceFormData.ugstTax">
                                <p class="invoice-total-title">
                                    UGST({{ decimalDigits(invoiceFormData.ugstTax) }}%):
                                </p>
                                <p class="invoice-total-amount">
                                    {{ decimalDigits(UgstTaxTotal) }}
                                </p>
                            </div>
                            <div class="invoice-total-item">
                                <p class="invoice-total-title">
                                    SubTotal1:
                                </p>
                                <p class="invoice-total-amount">
                                    {{ decimalDigits(grandTotal) }}
                                </p>
                            </div>
                            <div class="invoice-total-item">
                                <p class="invoice-total-title">
                                    Grand Total:
                                </p>
                                <p class="invoice-total-amount">
                                    {{ decimalDigits(grandTotal) }}
                                </p>
                            </div>
                        </div>
                    </b-col>
                </b-row>

                <b-row>

                    <b-col cols="12">

                        <hr>

                    </b-col>

                </b-row>

                <b-row>

                    <b-col cols="12">

                        <b-button
                            variant="primary"
                            type="submit"
                            @click.prevent="validationForm"
                        >
                            Save Invoice
                        </b-button>

                        <b-button
                            class="ml-2"
                            variant="primary"
                            type="button"
                            @click.prevent="generateGstInvoice"
                        >
                            Create GST Invoice
                        </b-button>

                        <b-button
                            class="ml-2"
                            variant="primary"
                            type="button"
                            @click.prevent="generateGstChallan"
                        >
                            Create GST Challan
                        </b-button>

                        <b-button
                            class="ml-2"
                            variant="primary"
                            type="button"
                            @click.prevent="generateEwayBill"
                        >
                            Create E-Way Bill
                        </b-button>

                    </b-col>

                </b-row>

            </b-form>
        </validation-observer>
    </b-card-code>
</template>

<script>
    import BCardCode from '@core/components/b-card-code'
    import {ValidationProvider, ValidationObserver} from 'vee-validate'
    import {
        BRow, BCol, BFormGroup, BFormInput, BFormCheckbox, BForm, BButton, BFormDatepicker, BFormTextarea,
    } from 'bootstrap-vue'
    import {required} from '@validations'
    import {heightTransition} from '@core/mixins/ui/transition'
    import Ripple from 'vue-ripple-directive'
    import vSelect from 'vue-select'
    import router from '@/router'
    import store from '@/store'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import {ref, onUnmounted} from '@vue/composition-api'
    import dispatchStoreModule from '../dispatchStoreModule'
    import {jsPDF} from "jspdf"
    import 'jspdf-autotable'

    export default {
        components: {
            BCardCode,
            ValidationProvider,
            ValidationObserver,
            BRow,
            BCol,
            BFormGroup,
            BFormInput,
            BFormCheckbox,
            BForm,
            BButton,
            BFormDatepicker,
            BFormTextarea,
            vSelect
        },
        directives: {
            Ripple,
        },
        mixins: [heightTransition],
        watch: {
            // eslint-disable-next-line func-names
            'invoiceFormData.invoiceItemList': function () {
                this.initTrHeight()
            },
        },
        mounted() {
            this.initTrHeight()
        },
        created() {
            window.addEventListener('resize', this.initTrHeight)
        },
        destroyed() {
            window.removeEventListener('resize', this.initTrHeight)
        },
        methods: {
            validationForm() {
                this.$refs.simpleRules.validate().then(success => {
                    if (success) {
                        // eslint-disable-next-line

                        //console.log("Before submit")

                        //console.log(this.invoiceFormData)

                        store.dispatch('dispatch-challan-invoices/editInvoiceChallan', this.invoiceFormData).then(response => {

                            //console.log(response);

                            if (response.status = 200) {

                                this.$router.push('/dispatch/challan-invoices')

                                this.$toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: 'Invoice Edited',
                                        icon: 'CheckSquareIcon',
                                        variant: 'success',
                                        text: `You have successfully Edited Invoice ${this.invoiceFormData.invoiceNo}.`,
                                    },
                                })
                            }

                        })


                    }
                })
            },
            generateGstInvoice() {

                console.log(this.invoiceFormData)

                const columnsItem = [
                    {header: "No", dataKey: "id"},
                    {header: "Item Details", dataKey: "item_detail"},
                    {header: "HSN/SAC", dataKey: "hsn_sac"},
                    {header: "UOM", dataKey: "uom"},
                    {header: "Quantity", dataKey: "qty"},
                    {header: "Rate", dataKey: "cost"},
                    {header: "Amount(INR)", dataKey: "total_amount"},
                ]

                const doc = new jsPDF()

                doc.autoTable({
                    body: this.invoiceFormData.invoiceItemList,
                    columns: columnsItem,
                })

                doc.save("mypdfnew.pdf")
            },
            generateGstChallan() {

                console.log(this.invoiceFormData)

                const doc = new jsPDF()

                doc.text("Hello world!", 10, 10)

                doc.save("mypdf.pdf")
            },
            generateEwayBill() {

                console.log(this.invoiceFormData)
            },
            repeateAgain() {

                var MyNextId = this.nextTodoId += this.nextTodoId

                /* this.InvoiceItems.push({
                     id: this.nextTodoId += this.nextTodoId,
                 })

                 this.invoiceFormData.invoiceItemList.push({
                     id: this.nextTodoId += this.nextTodoId,
                 })*/

                /*this.InvoiceItems.push({
                    id: MyNextId,
                })*/

                this.invoiceFormData.invoiceItemList.push({
                    id: MyNextId,
                    item_detail: '',
                    hsn_sac: '',
                    uom: '',
                    cost: 0,
                    qty: 1,
                    total_amount: 0,
                    prevHeight: 0,
                })


                this.$nextTick(() => {
                    this.trAddHeight(this.$refs.row[0].offsetHeight)
                })
            },
            removeItem(index) {
                //this.InvoiceItems.splice(index, 1)
                this.invoiceFormData.invoiceItemList.splice(index, 1)
                this.trTrimHeight(this.$refs.row[0].offsetHeight)
            },
            initTrHeight() {
                this.trSetHeight(null)
                this.$nextTick(() => {
                    this.trSetHeight(this.$refs.form.scrollHeight)
                })
            },
            decimalDigits: function (value) {
                return Number(value).toFixed(2)
            },
        },
        computed: {
            subTotal: function () {

                var total = this.invoiceFormData.invoiceItemList.reduce(function (accumulator, item) {
                    return accumulator + (item.cost * item.qty)
                }, 0);

                this.invoiceFormData.basicTotalAmount = this.decimalDigits(total);
                this.invoiceFormData.basicTotalAmount = this.decimalDigits(total);

                return total;
            },
            CgstTaxTotal: function () {
                var total = (this.subTotal) * (this.invoiceFormData.cgstTax / 100);
                this.invoiceFormData.cgstTotalAmount = this.decimalDigits(Math.round(total));
                return Math.round(total);
            },
            SgstTaxTotal: function () {
                var total = (this.subTotal) * (this.invoiceFormData.sgstTax / 100);
                this.invoiceFormData.sgstTotalAmount = this.decimalDigits(Math.round(total));
                return Math.round(total);
            },
            IgstTaxTotal: function () {
                var total = (this.subTotal) * (this.invoiceFormData.igstTax / 100);
                this.invoiceFormData.igstTotalAmount = this.decimalDigits(Math.round(total));
                return Math.round(total);
            },
            UgstTaxTotal: function () {
                var total = (this.subTotal) * (this.invoiceFormData.ugstTax / 100);
                this.invoiceFormData.ugstTotalAmount = this.decimalDigits(Math.round(total));
                return Math.round(total);
            },
            grandTotal: function () {
                var total = (this.subTotal + this.CgstTaxTotal + this.SgstTaxTotal + this.IgstTaxTotal + this.UgstTaxTotal);
                this.invoiceFormData.subTotalAmount1 = this.decimalDigits(Math.round(total));
                this.invoiceFormData.grandTotalAmount = this.decimalDigits(Math.round(total));
                return Math.round(total);
            },
        },
        setup() {

            const DISPATCH_CHALLNA_INV_APP_STORE_MODULE_NAME = 'dispatch-challan-invoices'

            // Register module
            if (!store.hasModule(DISPATCH_CHALLNA_INV_APP_STORE_MODULE_NAME))
                store.registerModule(DISPATCH_CHALLNA_INV_APP_STORE_MODULE_NAME, dispatchStoreModule)

            // UnRegister on leave
            onUnmounted(() => {
                if (store.hasModule(DISPATCH_CHALLNA_INV_APP_STORE_MODULE_NAME)) store.unregisterModule(DISPATCH_CHALLNA_INV_APP_STORE_MODULE_NAME)
            })

            const invoiceFormData = ref({
                id: null,
                partyCode: null,
                invoiceNo: null,
                invoiceDate: null,
                challanNo: null,
                orderNo: null,
                billToPartyGst: null,
                billToPartyName: null,
                billToPartyAddress: null,
                billToPartyState: null,
                billToPartyCountry: null,
                billToPartyPanNo: null,
                billToPartyAttn: null,
                shipToPartyGst: null,
                shipToPartyName: null,
                shipToPartyAddress: null,
                shipToPartyState: null,
                shipToPartyCountry: null,
                shipToPartyPanNo: null,
                invoiceItemList: [{
                    id: 1,
                    item_detail: '',
                    hsn_sac: '',
                    uom: '',
                    cost: 0,
                    qty: 1,
                    total_amount: 0,
                    prevHeight: 0,
                }],
                cgstTax: 0,
                sgstTax: 0,
                igstTax: 0,
                ugstTax: 0,
                transporter: null,
                vehicleNo: null,
                lrNo: null,
                paymentTerm: 'Price Basis : The Price is Ex Works, Basis. \nPayment Terms : Within 30 Days Direct Credit',
                basicTotalAmount: null,
                subTotalAmount: null,
                cgstTotalAmount: null,
                sgstTotalAmount: null,
                igstTotalAmount: null,
                ugstTotalAmount: null,
                subTotalAmount1: null,
                grandTotalAmount: null,
            })

            store.dispatch('dispatch-challan-invoices/fetchInvoiceDetail', {id: router.currentRoute.params.id})
                .then(response => {

                    invoiceFormData.value = response.data.data

                    invoiceFormData.value.id = response.data.data._id

                    delete invoiceFormData.value._id

                    //console.log(invoiceFormData.value)

                })
                .catch(error => {
                    if (error.response.status === 404) {
                        invoiceFormData.value = undefined
                    }
                })

            const nextTodoId = 499

            return {
                invoiceFormData,
                nextTodoId,
                required,
            }
        },
    }
</script>

<style lang="scss" scoped>

    .repeater-form {
        overflow: hidden;
        transition: .35s height;
    }

    .invoice-total-wrapper {
        width: 100%;
        max-width: 13rem;
    }

    .invoice-total-wrapper .invoice-total-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 0.5rem !important;
        border-bottom: 1px solid #ebe9f1;
    }

    .invoice-total-wrapper .invoice-total-item .invoice-total-title {
        margin-bottom: 0.35rem;
    }

    .invoice-total-wrapper .invoice-total-item .invoice-total-amount {
        margin-bottom: 0.35rem;
        font-weight: 600;
    }

</style>
