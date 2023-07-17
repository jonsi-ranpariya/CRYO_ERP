<template>
    <div>
        <b-row>
            <b-col md="2"><b>Report Details</b></b-col>
        </b-row>
        <hr>
        <br>
        <form method="post" target="_blank" action="/reports/sales-enquiry-report">
            <input type="hidden" name="salesEnquiryId" :value="currentEnquiryNumber"/>
            <input type="hidden" name="_token" :value="currentCsrfToken"/>
            <b-row>
                <b-col md="12">
                    <template>
                        <div class="demo-inline-spacing">
                            <b-form-checkbox
                                v-model="salesEnquiryReportFormData.enquiry_preview_mail"
                                name="enquiry_preview_mail"
                            >
                                Enquiry(Preview And Mail Option)
                            </b-form-checkbox>
                            <b-form-checkbox
                                v-model="salesEnquiryReportFormData.acknowledgement_mail"
                                name="acknowledgement_mail"
                            >
                                Acknowledgement(Only Mail Option)
                            </b-form-checkbox>
                            <b-form-checkbox
                                v-model="salesEnquiryReportFormData.regret_letter_mail"
                                name="regret_letter_mail"
                            >
                                Regret Letter(Only Mail Option)
                            </b-form-checkbox>
                        </div>
                    </template>
                </b-col>
            </b-row>
            <br>
            <hr>
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
    BButton
} from 'bootstrap-vue'
import { ref } from '@vue/composition-api'
import router from '@/router'
import { getCsrfToken } from '../../../../auth/utils'

export default {
    components: {
        BForm,
        BRow,
        BCol,
        BFormCheckbox,
        BButton
    },
    setup() {
        const salesEnquiryReportFormData = ref({
            enquiry_preview_mail: false,
            acknowledgement_mail: false,
            regret_letter_mail: false,
        })

        const currentEnquiryNumber = router.currentRoute.params.id

        const currentCsrfToken = getCsrfToken()
        return {
            salesEnquiryReportFormData,
            currentEnquiryNumber,
            currentCsrfToken
        }
    }
}
</script>
