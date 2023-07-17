<template>
    <b-card-code>
        <div>
            <b-row>
                <b-col md="12">
                    <h5>Report Criteria</h5>
                    <hr>
                </b-col>
            </b-row>
            <form method="post" action="/reports/stock-ledger-report" target="_blank">
            <input type="hidden" name="_token" :value="csrfToken">
            <b-row>
                <b-col md="2">
                    <b-form-checkbox
                        value="1"
                        unchecked-value="0"
                        inline
                        class="mt-1"
                        v-model="formData.itemSelect"
                        @change="getItemSelectState($event)"
                    >
                        Item
                    </b-form-checkbox>
                </b-col>
                <b-col md="10">
                    <v-select
                        :clearable="false"
                        :dir=" $store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                        :options="itemMasterOption"
                        :reduce="(val) => val.value"
                        placeholder="Select Item"
                        :disabled="formData.itemSelect === '0'"
                        v-model="formData.itemCode"
                    />
                    <input type="hidden" name="itemCode" v-model="formData.itemCode"/>
                </b-col>
            </b-row>
            <b-row class="mt-1">
                <b-col md="2">
                    <b-form-checkbox
                        value="1"
                        unchecked-value="0"
                        inline
                        class="mt-2"
                        v-model="formData.dateWise"
                        name="dateWise"
                    >
                        Date Wise
                    </b-form-checkbox>
                </b-col>
                <b-col md="5">
                    <b-form-group
                        label="From Date"
                        label-for="fromData"
                    >
                        <b-form-input
                            id="fromData"
                            type="date"
                            :disabled="formData.dateWise === '0'"
                            name="fromDate"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="5">
                    <b-form-group
                        label="To Date"
                        label-for="toData"
                    >
                        <b-form-input
                            id="toData"
                            type="date"
                            :disabled="formData.dateWise === '0'"
                            name="toDate"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="12">
                    <hr>
                    <b-button
                        type="submit"
                        class="float-right"
                        variant="primary"
                        @click="previewStockLedger"
                    >
                        Preview
                    </b-button>
                </b-col>
            </b-row>
            </form>
        </div>
    </b-card-code>
</template>
<script>
import {
    BForm,
    BRow,
    BCol,
    BFormGroup,
    BFormInput,
    BFormRadio,
    BButton,
    BFormInvalidFeedback,
    BInputGroup,
    BInputGroupAppend,
    BFormDatepicker,
    BFormTextarea,
    BTable,
    BSpinner,
    BBreadcrumb,
    BBreadcrumbItem,
    BFormCheckbox
} from 'bootstrap-vue'
import vSelect from 'vue-select'
import BCardCode from '@core/components/b-card-code/BCardCode.vue'
import { ValidationObserver, ValidationProvider } from 'vee-validate'
import { ref } from '@vue/composition-api'
import formValidation from '@core/comp-functions/forms/form-validation'
import axios from '@axios'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
import { useToast } from 'vue-toastification/composition'
import { getCsrfToken } from '../../../auth/utils'

export default {
    components: {
        BForm,
        BRow,
        BCol,
        BFormGroup,
        BFormInput,
        BFormRadio,
        BButton,
        BFormInvalidFeedback,
        BInputGroup,
        BInputGroupAppend,
        BFormDatepicker,
        BFormTextarea,
        BTable,
        BSpinner,
        BBreadcrumb,
        BBreadcrumbItem,
        BFormCheckbox,
        BCardCode,
        vSelect
    },
    setup() {
        const toast = useToast()
        const csrfToken = getCsrfToken()

        const itemMasterOption = ref([])
        axios.get('/api/get-item-master-options').then((res) => {
            itemMasterOption.value = res.data.data
        })

        const blankFormData = {
            itemSelect: '0',
            itemCode: null,
            dateWise: '0',
        }

        const formData = ref(JSON.parse(JSON.stringify(blankFormData)))

        const resetFormData = () => {
            formData.value = JSON.parse(JSON.stringify(blankFormData))
        }

        const getItemSelectState = (event) => {
            if (event === '0') {
                formData.value.itemCode = null
            }
        }

        const previewStockLedger = async () => {
            await axios.post('/reports/stock-ledger-report', formData.value).then(res => {
                console.log(res.data)
            }).catch(error => {
                console.log(error)
            })
        }

        return {
            csrfToken,
            itemMasterOption,
            formData,
            resetFormData,
            getItemSelectState,
            previewStockLedger
        }
    }
}
</script>
