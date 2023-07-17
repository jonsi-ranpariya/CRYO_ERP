<template>
    <div>
        <b-row>
            <b-col md="2"><b>Report Details</b></b-col>
        </b-row>
        <hr>
        <br>
        <form target="_blank" method="post" action="reports/sales-order-report">
            <input type="hidden" name="_token" v-model="currentCsrfToken" />
            <input type="hidden" name="salesOrderId" v-model="salesOrderId">
            <b-row>
                <b-col md="5">
                    <b-form-radio
                        name="sales_order_report_type"
                        class="mb-1"
                        value="1"
                        v-model="salesOrderReportFormData.sales_order_report_type"
                    >
                        Sales Order Intimation
                    </b-form-radio>
                    <b-form-radio
                        name="sales_order_report_type"
                        class="mb-1"
                        value="2"
                        v-model="salesOrderReportFormData.sales_order_report_type"
                    >
                        Sales Order Acknowledgement
                    </b-form-radio>
                    <b-form-radio
                        name="sales_order_report_type"
                        value="3"
                        v-model="salesOrderReportFormData.sales_order_report_type"
                    >
                        Sales Order Acknowledgement With Deviation
                    </b-form-radio>
                    <hr>
                    <b-row>
                        <b-col md="6">
                            <b-form-checkbox
                                name="user_sign"
                                v-model="salesOrderReportFormData.user_sign"
                                class="mb-1"
                            >
                                User Sign
                            </b-form-checkbox>
                            <b-form-checkbox
                                name="with_hasn_sac"
                                v-model="salesOrderReportFormData.with_hasn_sac"
                                class="mb-1"
                            >
                                With HSN/SAC No
                            </b-form-checkbox>
                            <b-form-checkbox
                                name="with_gst"
                                v-model="salesOrderReportFormData.with_gst"
                                class="mb-1"
                            >
                                With GST %
                            </b-form-checkbox>
                        </b-col>
                        <b-col md="6">
                            <b-form-checkbox
                                name="header_image"
                                v-model="salesOrderReportFormData.header_image"
                                class="mb-1"
                            >
                                Header Image
                            </b-form-checkbox>
                            <b-form-checkbox
                                name="footer_image"
                                v-model="salesOrderReportFormData.footer_image"
                                class="mb-1"
                            >
                                Footer Image
                            </b-form-checkbox>
                        </b-col>
                        <b-col md="12" v-if="salesOrderReportFormData.sales_order_report_type === '3'">
                            <hr>
                            <b-form-group
                                label="Deviation"
                                label-for="deviation"
                            >
                                <b-form-textarea
                                    name="deviation"
                                    v-model="salesOrderReportFormData.deviation"
                                    id="deviation"
                                    rows="4"
                                />
                            </b-form-group>
                            <hr>
                            <b-button
                                variant="primary"
                                type="button"
                                @click="saveSalesOrderDeviation"
                            >
                                Save
                            </b-button>
                        </b-col>
                    </b-row>
                </b-col>
                <b-col md="7">
                    <b-form-radio
                        name="print_customer_name"
                        v-model="salesOrderReportFormData.print_customer_name"
                        class="mb-1"
                        value="1"
                    >
                        Print Customer Name In SO Intimation...?
                    </b-form-radio>
                    <b-form-radio
                        name="print_customer_name"
                        v-model="salesOrderReportFormData.print_customer_name"
                        class="mb-1"
                        value="2"
                    >
                        Print Customer Code Only In SO Intimation...?
                    </b-form-radio>
                    <b-form-radio
                        name="print_customer_name"
                        v-model="salesOrderReportFormData.print_customer_name"
                        class="mb-1"
                        value="3"
                    >
                        Print Customer Add With Contact In SO Intimation...?
                    </b-form-radio>
                    <br>
                    <b-form-checkbox
                        name="print_so_ack_without_contact"
                        v-model="salesOrderReportFormData.print_so_ack_without_contact"
                        class="mb-1"
                    >
                        Print SO Acknowledgement Without Contact Person...?
                    </b-form-checkbox>
                    <b-form-checkbox
                        name="print_common_del"
                        v-model="salesOrderReportFormData.print_common_del"
                        class="mb-1"
                    >
                        Print Common Delivery Schedule for All Items...?
                    </b-form-checkbox>
                    <b-form-checkbox
                        name="print_item_so_ack"
                        v-model="salesOrderReportFormData.print_item_so_ack"
                        class="mb-1"
                    >
                        Print Items in Sales Order Acknowledgement...?
                    </b-form-checkbox>
                    <br>
                    <b-row>
                        <b-col md="6">
                            <b-form-checkbox
                                name="with_discount"
                                v-model="salesOrderReportFormData.with_discount"
                                class="mb-1"
                            >
                                Report With Discount
                            </b-form-checkbox>
                            <b-form-checkbox
                                name="with_discount_rate"
                                v-model="salesOrderReportFormData.with_discount_rate"
                                class="mb-1"
                            >
                                Report With Discounted Rate
                            </b-form-checkbox>
                        </b-col>
                        <b-col md="6">
                            <b-form-checkbox
                                name="with_addon"
                                v-model="salesOrderReportFormData.with_addon"
                                class="mb-1"
                            >
                                Report With AddOn
                            </b-form-checkbox>
                            <b-form-checkbox
                                name="with_only_pending_item"
                                v-model="salesOrderReportFormData.with_only_pending_item"
                                class="mb-1"
                            >
                                Only Pending Items
                            </b-form-checkbox>
                        </b-col>
                    </b-row>
                </b-col>
            </b-row>
            <br>
            <b-row>
                <b-col md="12">
                    <b-button
                        variant="primary"
                        type="button"
                        class="ml-1 mt-1 float-right"
                        @click=""
                    >
                        Selected Item SO Acknowledgement
                    </b-button>
                    <b-button
                        variant="primary"
                        type="button"
                        class="ml-1 mt-1 float-right"
                        @click=""
                    >
                        E-Mail
                    </b-button>
                    <b-button
                        type="submit"
                        variant="primary"
                        class="ml-1 mt-1 float-right"
                    >
                        Preview
                    </b-button>
                </b-col>
            </b-row>
        </form>
    </div>
</template>
<script>
    import {
        BRow,
        BCol,
        BForm,
        BFormGroup,
        BFormTextarea,
        BFormCheckbox,
        BButton,
        BFormRadio
    } from 'bootstrap-vue'
    import {ref} from "@vue/composition-api/dist/vue-composition-api";
    import vSelect from 'vue-select'
    import { getCsrfToken } from '@/auth/utils'
    import router from '@/router'
    import axios from '@axios'
    import { useToast } from 'vue-toastification/composition'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'

    export default {
        components: {
            BRow,
            BCol,
            BForm,
            BFormGroup,
            BFormTextarea,
            BFormCheckbox,
            BFormRadio,
            vSelect,
            BButton
        },
        methods: {
            submitFormData() {

                console.log("Form Submit")
            }
        },
        setup() {
            const pageOption = ref([
                {label: 'Blank Page', value: 1},
                {label: 'Letter Pad', value: 2}
            ])

            const selected = ref([])

            const currentCsrfToken = getCsrfToken()

            const salesOrderId = router.currentRoute.params.id

            const toast = useToast()

            const salesOrderReportFormData = ref({
                sales_order_report_type: 2,
                user_sign:false,
                with_gst:true,
                with_hasn_sac:true,
                header_image:true,
                footer_image:false,
                deviation:null,
                print_customer_name: 1,
                print_so_ack_without_contact:false,
                print_common_del:false,
                print_item_so_ack:true,
                with_discount:false,
                with_discount_rate:false,
                with_addon:false,
                with_only_pending_item:false,
            })

            const saveSalesOrderDeviation  = async () => {
                await axios.post('/api/update-sales-order-deviation', {
                    salesOrderId: salesOrderId,
                    deviation: salesOrderReportFormData.value.deviation
                }).then((res) => {
                    if (res.status === 200) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Deviation Updated',
                                icon: 'ThumbsUpIcon',
                                variant: 'success',
                                text: `Sales Order Deviation Updated Successfully!`,
                            },
                        })
                    }
                }).catch(() => {
                    toast({
                        component: ToastificationContent,
                        position: 'top-right',
                        props: {
                            title: 'Error',
                            icon: 'AlertCircleIcon',
                            variant: 'danger',
                            text: 'Internal Server Error.',
                        },
                    })
                })
            }

            const getSalesOrder = async () => {
                await axios.get(`/api/sales-order/${salesOrderId}`).then((res) => {
                    salesOrderReportFormData.value.deviation = res.data.data?.deviation ?? null
                })
            }
            getSalesOrder();

            return {
                selected,
                pageOption,
                currentCsrfToken,
                salesOrderId,
                salesOrderReportFormData,
                saveSalesOrderDeviation
            }
        }
    }
</script>
