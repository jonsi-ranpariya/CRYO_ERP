<template>
    <div>
        <b-row>
            <b-col md="2"><b>Report Details</b></b-col>
        </b-row>
        <hr>
        <br>
        <form target="_blank" method="post" action="reports/sales-quotation-report">
            <input type="hidden" name="_token" v-model="currentCsrfToken"/>
            <input type="hidden" name="salesQuoationId" v-model="salesQuoationId">
            <b-row>
                <b-col md="7">
                    <b-form-checkbox
                        v-model="salesQuotationReportFormData.report_letter_format"
                        name="report_letter_format"
                        class="mb-1"
                    >
                        Report In Letter Format
                    </b-form-checkbox>
                    <b-form-checkbox
                        v-model="salesQuotationReportFormData.report_item_spec"
                        name="report_item_spec"
                        class="mb-1"
                    >
                        Report With Item Spec
                    </b-form-checkbox>
                    <b-row>
                        <b-col md="6">
                            <b-form-checkbox
                                v-model="salesQuotationReportFormData.report_Discount"
                                name="report_Discount"
                                class="mb-1"
                            >
                                Report With Discount
                            </b-form-checkbox>
                        </b-col>
                        <b-col md="6">
                            <b-form-checkbox
                                v-model="salesQuotationReportFormData.print_Discount_value"
                                name="print_Discount_value"
                                class="mb-1"
                            >
                                Print Discount Value Only
                            </b-form-checkbox>
                        </b-col>
                    </b-row>
                    <b-form-checkbox
                        v-model="salesQuotationReportFormData.report_without_totalAmount"
                        name="report_without_totalAmount"
                        class="mb-1"
                    >
                        Report Without Total Amount
                    </b-form-checkbox>
<!--                    <b-form-checkbox
                        v-model="salesQuotationReportFormData.report_with_totalAmount"
                        name="report_with_totalAmount"
                        class="mb-1"
                    >
                        Report With Total Amount Only
                    </b-form-checkbox>-->
                    <b-row>
                        <b-col md="6">
                            <b-form-checkbox
                                v-model="salesQuotationReportFormData.report_without_rate"
                                name="report_without_rate"
                                class="mb-1"
                            >
                                Report Without Rate
                            </b-form-checkbox>
                        </b-col>
                        <b-col md="6">
                            <b-form-checkbox
                                v-model="salesQuotationReportFormData.print_quotation_salesPerson"
                                name="print_quotation_salesPerson"
                                class="mb-1"
                            >
                                Print Quotation With Sales Person
                            </b-form-checkbox>
                        </b-col>
                    </b-row>
                    <b-form-checkbox
                        v-model="salesQuotationReportFormData.report_discountRate"
                        name="report_discountRate"
                        class="mb-1"
                    >
                        Report With Discounted Rate
                    </b-form-checkbox>
                </b-col>
                <b-col md="5">
                    <b-row>
                        <!--<b-col md="6">
                            <b-form-group
                                label="Page"
                                label-for="page"
                            >
                                <v-select
                                    placeholder="Select Page"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :reduce="val => val.value"
                                    :options="pageOption"
                                    :clearable="false"
                                    v-model="salesQuotationReportFormData.page"
                                    input-id="page"
                                />
                            </b-form-group>
                        </b-col>-->
                        <b-col md="6">
                            <b-form-checkbox
                                v-model="salesQuotationReportFormData.item_image"
                                name="item_image"
                            >
                                With Item Image
                            </b-form-checkbox>
                            <br>
                            <b-form-checkbox
                                v-model="salesQuotationReportFormData.hsn_sac"
                                name="hsn_sac"
                            >
                                With HSN/SAC
                            </b-form-checkbox>
                        </b-col>
                    </b-row>
                    <br>
                    <b-row>
                        <b-col md="6">
                            <b-form-checkbox
                                v-model="salesQuotationReportFormData.header_image"
                                name="header_image"
                                class="mb-1"
                            >
                                Header Image
                            </b-form-checkbox>
                            <b-form-checkbox
                                v-model="salesQuotationReportFormData.footer_image"
                                name="footer_image"
                                class="mb-1"
                            >
                                Footer Image
                            </b-form-checkbox>
                            <b-form-checkbox
                                v-model="salesQuotationReportFormData.user_sign"
                                name="user_sign"
                                class="mb-1"
                            >
                                User Sign
                            </b-form-checkbox>
                        </b-col>
                        <b-col md="6">
<!--                            <b-form-checkbox
                                v-model="salesQuotationReportFormData.page_break"
                                name="page_break"
                            >
                                Page Break
                            </b-form-checkbox>-->
                            <br>
                            <b-form-checkbox
                                v-model="salesQuotationReportFormData.envelop"
                                name="envelop"
                            >
                                Envelop #10
                            </b-form-checkbox>
                        </b-col>
                    </b-row>
                </b-col>
            </b-row>
            <b-row>
                <b-col md="12">
                    <b-button
                        variant="primary"
                        type="submit"
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
    BForm,
    BRow,
    BCol,
    BFormCheckbox,
    BFormGroup,
    BButton
} from 'bootstrap-vue'
import { ref } from '@vue/composition-api'
import vSelect from 'vue-select'
import { getCsrfToken } from '../../../../auth/utils'
import router from '@/router'

export default {
    components: {
        BRow,
        BCol,
        BFormCheckbox,
        BFormGroup,
        vSelect,
        BButton,
        BForm
    },
    setup() {

        const pageOption = ref([
            {
                label: 'Blank Page',
                value: 1
            },
            {
                label: 'Letter Pad',
                value: 2
            }
        ])

        const currentCsrfToken = getCsrfToken()

        const salesQuoationId = router.currentRoute.params.id

        const salesQuotationReportFormData = ref({
            report_letter_format: false,
            report_addOn: false,
            report_addOn_annexure: false,
            report_item_spec: false,
            report_item_spec_addOn: false,
            report_addOn_item_spec: false,
            report_addOn_group_by_type: false,
            report_anx1_anx2: false,

            report_Discount: false,
            print_Discount_value: false,
            report_without_totalAmount: false,
            report_with_totalAmount: false,
            report_without_rate: false,
            print_quotation_salesPerson: false,
            report_discountRate: false,
            page: false,
            item_image: false,
            hsn_sac: true,
            header_image: true,
            footer_image: false,
            user_sign: false,
            page_break: true,
            envelop: false,
        })

        return {
            pageOption,
            salesQuotationReportFormData,
            currentCsrfToken,
            salesQuoationId
        }
    }
}
</script>
