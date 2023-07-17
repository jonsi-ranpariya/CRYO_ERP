    <template>
    <div>
        <b-overlay
            :show="showOverlayLoading"
            rounded="sm"
        >
        <b-card-code>
            <validation-observer #default="{ handleSubmit }">
                <b-form @submit.prevent="handleSubmit(saveFormData)">
                    <b-row>
                        <b-col md="6">
                            <b-row>
                                <b-col md="6">
                                    <validation-provider
                                        #default="validationContext"
                                        name="GRN No"
                                        rules="required"
                                    >
                                        <b-form-group
                                            label="GRN No"
                                            label-for="grnNo"
                                        >
                                                <b-form-input
                                                    id="grnNo"
                                                    :state="getValidationState(validationContext)"
                                                    v-model="formData.grnNo"
                                                    readonly
                                                />
                                            <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                                {{ validationContext.errors[0] }}
                                            </b-form-invalid-feedback>
                                        </b-form-group>
                                    </validation-provider>
                                </b-col>
                                <b-col md="6">
                                    <validation-provider
                                        #default="validationContext"
                                        name="GRN Date"
                                        rules="required"
                                    >
                                        <b-form-group
                                            label="GRN Date"
                                            label-for="grnDate"
                                        >
                                            <b-input-group>
                                                <cleave
                                                    id="grnDate"
                                                    v-model="formData.grnDate"
                                                    class="form-control"
                                                    :raw="false"
                                                    :options="dateFormat"
                                                    placeholder="DD/MM/YYYY"
                                                    show-decade-nav
                                                />
                                                <b-input-group-append>
                                                    <b-form-datepicker
                                                        v-model="formatDates.grnDate"
                                                        button-only
                                                        @input="getJobWorkScrapFormateDate($event)"
                                                        show-decade-nav
                                                        size="sm"
                                                        nav-button-variant="primary"
                                                    />
                                                </b-input-group-append>
                                            </b-input-group>
                                        </b-form-group>
                                        <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                            {{ validationContext.errors[0] }}
                                        </b-form-invalid-feedback>
                                    </validation-provider>
                                </b-col>
                            </b-row>
                            <validation-provider
                                #default="validationContext"
                                name="Item Code"
                                rules="required"
                            >
                                <b-form-group
                                    label="Item Code"
                                    label-for="itemCode"
                                >
                                    <b-form-input
                                        id="itemCode"
                                        :state="getValidationState(validationContext)"
                                        v-model="formData.itemCode"
                                        readonly
                                    />
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                            <validation-provider
                                #default="validationContext"
                                name="Item Description"
                                rules="required"
                            >
                                <b-form-group
                                    label="Item Description"
                                    label-for="itemDescription"
                                    :state="getValidationState(validationContext)"
                                >
                                    <b-form-input
                                        v-model="formData.itemDescription"
                                        id="itemDescription"
                                        :state="getValidationState(validationContext)"
                                    />
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                            <b-row>
                                <b-col md="6">
                                    <b-form-group
                                        label="Add Description"
                                        label-for="addDescription"
                                    >
                                        <b-form-textarea
                                            id="addDescription"
                                            rows="2"
                                            v-model="formData.itemAddDescription"
                                        />
                                    </b-form-group>
                                </b-col>
                                <b-col md="6">
                                    <b-form-group
                                        label="Detail Description"
                                        label-for="detailDescription"
                                    >
                                        <b-form-textarea
                                            id="detailDescription"
                                            readonly
                                            rows="2"
                                            v-model="formData.itemDetailDescription"
                                        />
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col md="6">
                                    <b-form-group
                                        label="Drawing No."
                                        label-for="itemDrawingNo"
                                    >
                                        <b-form-input
                                            id="itemDrawingNo"
                                            readonly
                                            v-model="formData.itemDrawingNo"
                                        />
                                    </b-form-group>
                                </b-col>
                                <b-col md="6">
                                    <b-form-group
                                        label="Drawing Revision"
                                        label-for="itemRevision"
                                    >
                                        <b-form-input
                                            id="itemRevision"
                                            readonly
                                            v-model="formData.itemRevision"
                                        />
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-form-group
                                label="UOM"
                                label-for="uom"
                            >
                                <v-select
                                    v-model="formData.itemUom"
                                    placeholder="Select uom"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="uomOption"
                                    :reduce="val => val.value"
                                    :clearable="false"
                                    input-id="uom"
                                />
                            </b-form-group>
                            <b-row>
                                <b-col md="6">
                                    <b-form-group
                                        label="Sub-Contractor Code"
                                        label-for="subContractor"
                                    >
                                        <v-select
                                            placeholder="Select Code"
                                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                            :options="subContractorOptions"
                                            :reduce="val => val.value"
                                            :clearable="false"
                                            input-id="subContractorCode"
                                            v-model="formData.subContractor"
                                        />
                                    </b-form-group>
                                </b-col>
                                <b-col md="6">
                                    <b-form-group
                                        label="Sub-Contractor Name"
                                        label-for="subContractorName"
                                    >
                                        <b-form-input
                                            id="subContractorName"
                                            readonly
                                            v-model="formData.subContractorName"
                                        />
                                    </b-form-group>
                                </b-col>
                            </b-row>
                        </b-col>
                        <b-col md="6">
                            <b-form-group
                                label="Job Work No"
                                label-for="jobWorkNo"
                            >
                                <b-form-input
                                    id="jobWorkNo"
                                    v-model="formData.itemJobWorkNo"
                                />
                            </b-form-group>
                            <b-row>
                                <b-col md="6">
                                    <b-form-group
                                        label="Challan Date"
                                        label-for="challanDate"
                                    >
                                        <b-input-group>
                                            <b-input-group-prepend>
                                                <b-form-datepicker
                                                    v-model="formatDates.challanDate"
                                                    button-only
                                                    @input="getJobWorkChallanFormateDate($event)"
                                                    show-decade-nav
                                                    size="sm"
                                                    nav-button-variant="primary"
                                                />
                                            </b-input-group-prepend>
                                            <cleave
                                                id="challanDate"
                                                v-model="formData.challanDate"
                                                class="form-control"
                                                :raw="false"
                                                :options="dateFormat"
                                                placeholder="DD/MM/YYYY"
                                                show-decade-nav
                                            />
                                        </b-input-group>
                                    </b-form-group>
                                </b-col>
                                <b-col md="6">
                                    <b-form-group
                                        label="Challan No"
                                        label-for="challanNo"
                                    >
                                        <b-form-input
                                            id="challanNo"
                                            v-model="formData.challanNo"
                                        />
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-form-group
                                label="Challan Qty"
                                label-for="challanQty"
                            >
                                <b-form-input
                                    id="challanQty"
                                    v-model="formData.challanQty"
                                />
                            </b-form-group>
                            <b-row>
                                <b-col md="12">
                                    <hr>
                                    <h5>Scrap Details</h5>
                                    <hr>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col md="4">
                                    <b-form-group
                                        label="Expected Scrap"
                                        label-for="expectedScrap"
                                    >
                                        <b-form-input
                                            id="expectedScrap"
                                            v-model="formData.expectedScrap"
                                        />
                                    </b-form-group>
                                </b-col>
                                <b-col md="4">
                                    <b-form-group
                                        label="Scrap Received"
                                        label-for="scrapReceived"
                                    >
                                        <b-form-input
                                            id="scrapReceived"
                                            v-model="formData.scrapReceived"
                                        />
                                    </b-form-group>
                                </b-col>
                                <b-col md="4">
                                    <b-form-group
                                        label="Rate"
                                        label-for="rate"
                                    >
                                        <b-form-input
                                            id="rate"
                                            v-model="formData.rate"
                                        />
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col md="8">
                                    <b-form-group
                                        label="Scrap Code"
                                        label-for="scrapCode"
                                    >
                                        <v-select
                                            placeholder="Select Code"
                                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                            :options="scrapCodeOption"
                                            :reduce="val => val.value"
                                            :clearable="false"
                                            input-id="scrapCode"
                                            v-model="formData.scrapCode"
                                            disabled
                                        />
                                    </b-form-group>
                                </b-col>
                                <b-col md="4">
                                    <b-form-group
                                        label="Scrap Name"
                                        label-for="scrapName"
                                    >
                                        <b-form-input
                                            id="scrapName"
                                            readonly
                                            v-model="formData.scrapName"
                                        />
                                    </b-form-group>
                                </b-col>
                            </b-row>
                        </b-col>
                        <!--Button-->
                        <b-col md="12">
                            <hr>
                            <b-button
                                variant="primary"
                                type="submit"
                                class="float-right"
                            >
                                Save
                            </b-button>
                        </b-col>
                    </b-row>
                </b-form>
            </validation-observer>
        </b-card-code>
        </b-overlay>
    </div>
</template>
<script>
    import BCardCode from "../../../@core/components/b-card-code/BCardCode";
    import {
        BForm,
        BRow,
        BCol,
        BFormGroup,
        BFormInput,
        BInputGroup,
        BInputGroupAppend,
        BFormInvalidFeedback,
        BButton,
        BFormDatepicker,
        BFormTextarea,
        BTable,
        BOverlay,
        BInputGroupPrepend
    } from 'bootstrap-vue'
    import {ValidationObserver,ValidationProvider} from 'vee-validate'
    import formValidation from "../../../@core/comp-functions/forms/form-validation";
    import {onUnmounted, ref} from "@vue/composition-api";
    import {required} from "@validations"
    import axios from '@axios'
    import vSelect from 'vue-select'
    import store from '@/store'
    import router from '@/router'
    import Ripple from "vue-ripple-directive";
    import {useToast} from "vue-toastification/composition";
    import jobWorkStoreModule from "../jobWorkStoreModule";
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import {forMatIndianDate} from "../../../@core/utils/utils";
    import Cleave from 'vue-cleave-component'
    export default {
        components: {
            BCardCode,
            ValidationObserver,
            ValidationProvider,
            BForm,
            BRow,
            BCol,
            BFormGroup,
            BFormInput,
            BInputGroup,
            BInputGroupAppend,
            BFormInvalidFeedback,
            BButton,
            BFormDatepicker,
            BFormTextarea,
            vSelect,
            BTable,
            BOverlay,
            Cleave,
            BInputGroupPrepend
        },
        directives: {
            Ripple,
        },
        setup(){
            const toast = useToast()

            const ITEMADDON_APP_STORE_MODULE_NAME = 'scrap-entry-store-module'
            if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, jobWorkStoreModule)
            onUnmounted(() => {
                if (store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.unregisterModule(ITEMADDON_APP_STORE_MODULE_NAME)
            })

            const showOverlayLoading = ref(false)

            const uomOption = ref([])
            axios.get('/api/get-uom-master-options').then(res => {
                uomOption.value = res.data.data
            })
            const subContractorOptions = ref([])
            axios.get('/api/party/get-master-options').then(res => {
                subContractorOptions.value = res.data.data
            })

            const scrapCodeOption = ref([])
            axios.get('/api/get-item-master-options').then(res => {
                scrapCodeOption.value = res.data.data
            })

            const dateFormat = ref({
                date: true,
                delimiter: '/',
                datePattern: ['d', 'm', 'Y'],
            })

            const formatDates = ref({
                grnDate: null,
                challanDate: null,
            })

            const getJobWorkScrapFormateDate = (date) => {
                formData.value.grnDate = forMatIndianDate(date)
            }
            const getJobWorkChallanFormateDate = (date) => {
                formData.value.challanDate = forMatIndianDate(date)
            }

            const blankFormData = {
                grnNo:null,
                grnDate:null,
                itemCode:null,
                itemDescription:null,
                itemAddDescription:null,
                itemDetailDescription:null,
                itemDrawingNo:null,
                itemRevision:null,
                itemUom:null,
                subContractor:null,
                subContractorName:null,
                itemJobWorkNo:null,
                challanNo:null,
                challanDate:null,
                challanQty:null,
                expectedScrap:null,
                scrapReceived:null,
                rate:null,
                scrapCode:null,
                scrapName:null,
            }
            const refetchData = async () => {
                showOverlayLoading.value = true
                await axios.get(`/api/new/scrap-receipt-entrys/${router.currentRoute.params.id}`).then(res => {
                    formData.value = res.data.data
                })
                showOverlayLoading.value = false
            }
            refetchData()

            const formData = ref(JSON.parse(JSON.stringify(blankFormData)))

            const resetFormData = () => {
                formData.value = JSON.parse(JSON.stringify(blankFormData))
            }
            const saveFormData = async () => {
                await store.dispatch('scrap-entry-store-module/updateScrapReceiptEntry', formData.value).then(res => {
                    if (res.status === 200) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Scrap Receipt Entry Updated',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: `You have successfully Updated Scrap Receipt Entry.`,
                            },
                        })
                    } else {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Error',
                                icon: 'AlertCircleIcon',
                                variant: 'danger',
                                text: 'Something went wrong!',
                            },
                        })
                    }
                    router.push({name: 'scrap-receipt-entry'})
                })
            }
            const {refFormObserver, getValidationState, resetForm} = formValidation(resetFormData)
            return{
                formData,
                refFormObserver,
                getValidationState,
                resetForm,
                resetFormData,
                required,
                uomOption,
                subContractorOptions,
                scrapCodeOption,
                saveFormData,
                showOverlayLoading,
                refetchData,
                dateFormat,
                formatDates,
                getJobWorkChallanFormateDate,
                getJobWorkScrapFormateDate
            }
        }
    }
</script>

