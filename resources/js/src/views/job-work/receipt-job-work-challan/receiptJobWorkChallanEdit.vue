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
                                            name="Party Code"
                                            rules="required"
                                        >
                                            <b-form-group
                                                label="Party Code"
                                                label-for="pcPartyCode"
                                            >
                                                <v-select
                                                    placeholder="Select Code"
                                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                                    :options="partyCodeOPtion"
                                                    :reduce="val => val.value"
                                                    :clearable="false"
                                                    input-id="pcPartyCode"
                                                    v-model="formData.partyCode"
                                                    @input="getPartyDetails($event)"
                                                    :state="getValidationState(validationContext)"
                                                    disabled
                                                />
                                            </b-form-group>
                                            <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                                {{ validationContext.errors[0] }}
                                            </b-form-invalid-feedback>
                                        </validation-provider>
                                    </b-col>
                                    <b-col md="6">
                                        <validation-provider
                                            #default="validationContext"
                                            name="Party Name"
                                            rules="required"
                                        >
                                            <b-form-group
                                                label="Party Name"
                                                label-for="partyName"
                                            >
                                                <b-form-input
                                                    id="partyName"
                                                    v-model="formData.partyName"
                                                    :state="getValidationState(validationContext)"
                                                />
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
                                                @input="getSubContrctorDetails($event)"
                                            />
                                            <!--                                            <b-form-input-->
                                            <!--                                                id="subContractor"-->
                                            <!--                                                v-model="formData.subContractor"-->
                                            <!--                                            />-->
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
                                <b-row>
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
                                    </b-col>
                                    <b-col md="6">
                                        <b-form-group
                                            label="Job Card No"
                                            label-for="jobCardNo"
                                        >
                                            <b-form-input
                                                id="jobCardNo"
                                                v-model="formData.itemJobCardNo"
                                            />
                                        </b-form-group>
                                    </b-col>
                                </b-row>
                                <b-form-group
                                    label="WO.No."
                                    label-for="itemWoNumber"
                                >
                                    <b-form-input
                                        id="itemWoNumber"
                                        v-model="formData.itemWoNumber"
                                    />
                                </b-form-group>
                                <b-row>
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
                                    <b-col md="6">
                                        <b-form-group
                                            label="Challan Date"
                                            label-for="challanDate"
                                        >
                                            <b-input-group>
                                                <cleave
                                                    id="challanDate"
                                                    v-model="formData.challanDate"
                                                    class="form-control"
                                                    :raw="false"
                                                    :options="dateFormat"
                                                    placeholder="DD/MM/YYYY"
                                                    show-decade-nav
                                                />
                                                <b-input-group-append>
                                                    <b-form-datepicker
                                                        v-model="formatDates.challanDate"
                                                        button-only
                                                        @input="getJobChallanFormateDate($event)"
                                                        show-decade-nav
                                                        size="sm"
                                                        nav-button-variant="primary"
                                                    />
                                                </b-input-group-append>
                                            </b-input-group>
                                        </b-form-group>
                                    </b-col>
                                </b-row>
                                <b-row>
                                    <b-col md="6">
                                        <b-form-group
                                            label="GIR No"
                                            label-for="girNo"
                                        >
                                            <b-form-input
                                                id="girNo"
                                                v-model="formData.girNo"
                                            />
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="6">
                                        <b-form-group
                                            label="GIR Date"
                                            label-for="girDate"
                                        >
                                            <b-input-group>
                                                <cleave
                                                    id="girDate"
                                                    v-model="formData.girDate"
                                                    class="form-control"
                                                    :raw="false"
                                                    :options="dateFormat"
                                                    placeholder="DD/MM/YYYY"
                                                    show-decade-nav
                                                />
                                                <b-input-group-append>
                                                    <b-form-datepicker
                                                        v-model="formatDates.girDate"
                                                        button-only
                                                        @input="getJobGirFormateDate($event)"
                                                        show-decade-nav
                                                        size="sm"
                                                        nav-button-variant="primary"
                                                    />
                                                </b-input-group-append>
                                            </b-input-group>
                                        </b-form-group>
                                    </b-col>
                                </b-row>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Item Make"
                                    label-for="itemMake"
                                >
                                    <v-select
                                        :clearable="false"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="makeOption"
                                        :reduce="(val) => val.value"
                                        input-id="itemMake"
                                        multiple
                                        placeholder="Select Make"
                                        push-tags
                                        taggable
                                        v-model="formData.itemMake"
                                    />
                                </b-form-group>
                                <b-form-group
                                    label="Store"
                                    label-for="itemStore"
                                >
                                    <v-select
                                        :clearable="false"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="storeOption"
                                        :reduce="(val) => val.value"
                                        input-id="itemStore"
                                        placeholder="Select Store"
                                        v-model="formData.itemStore"
                                    />
                                </b-form-group>
                                <b-form-group
                                    label="Receipt Note"
                                    label-for="receiptNote"
                                >
                                    <b-form-input
                                        id="receiptNote"
                                        v-model="formData.receiptNote"
                                    />
                                </b-form-group>
                                <b-row>
                                    <b-col md="6">
                                        <b-form-group
                                            label="Job Qty"
                                            label-for="jobQty"
                                        >
                                            <b-form-input
                                                v-model="formData.jobQty"
                                                id="jobQty"
                                            />
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="6">
                                        <b-form-group
                                            label="Pending Job Qty"
                                            label-for="pendingJobQty"
                                        >
                                            <b-form-input
                                                v-model="formData.pendingJobQty"
                                                id="pendingJobQty"
                                            />
                                        </b-form-group>
                                    </b-col>
                                </b-row>
                                <b-form-group
                                    label="Challan Qty"
                                    label-for="challanQty"
                                >
                                    <b-form-input
                                        v-model="formData.challanQty"
                                        id="challanQty"
                                    />
                                </b-form-group>
                                <b-row>
                                    <b-col md="6">
                                        <b-form-group
                                            label="GRN Date"
                                            label-for="grnDate"
                                        >
                                            <b-input-group>
                                                <b-input-group-prepend>
                                                    <b-form-datepicker
                                                        v-model="formatDates.grnDate"
                                                        button-only
                                                        @input="getJobGrnFormateDate($event)"
                                                        show-decade-nav
                                                        size="sm"
                                                        nav-button-variant="primary"
                                                    />
                                                </b-input-group-prepend>
                                                <cleave
                                                    id="grnDate"
                                                    v-model="formData.grnDate"
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
                                            label="GRN No"
                                            label-for="grnNo"
                                        >
                                            <b-form-input
                                                id="grnNo"
                                                v-model="formData.grnNo"
                                            />
                                        </b-form-group>
                                    </b-col>
                                </b-row>
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
                                    <b-col md="6">
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
                                    <b-col md="6">
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
        <!-- Tabs -->
        <b-overlay
            :show="showOverlayLoading"
            rounded="sm"
        >
            <b-card-code>
                <b-tabs
                    pills
                    lazy
                >
                    <b-tab active>
                        <template #title>
                            <feather-icon
                                icon="LogInIcon"
                                size="16"
                                class="mr-0 mr-sm-50"
                            />
                            <span class="d-none d-sm-inline">Login Details</span>
                        </template>
                        <hr>
                        <login-details-tab
                            :loginData="formData.loginDetails"
                        />
                    </b-tab>
                </b-tabs>
            </b-card-code>
        </b-overlay>
    </div>
</template>
<script>
    import BCardCode from "../../../@core/components/b-card-code/BCardCode";
    import {ValidationObserver, ValidationProvider} from 'vee-validate'
    import vSelect from 'vue-select'
    import axios from '@axios'
    import {required} from "@validations"
    import loginDetailsTab from "./tabs/loginDetailsTab";
    import router from '@/router'
    import Cleave from 'vue-cleave-component'
    import {
        BForm,
        BRow,
        BCol,
        BFormGroup,
        BFormInput,
        BFormInvalidFeedback,
        BFormTextarea,
        BFormDatepicker,
        BButton,
        BOverlay,
        BTabs,
        BTab,
        BInputGroup,
        BInputGroupAppend,
        BInputGroupPrepend
    } from 'bootstrap-vue'
    import {onUnmounted, ref} from "@vue/composition-api";
    import formValidation from "../../../@core/comp-functions/forms/form-validation";
    import {getUserData} from "../../../auth/utils";
    import moment from "moment";
    import Ripple from "vue-ripple-directive";
    import store from '@/store'
    import {useToast} from "vue-toastification/composition";
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import jobWorkStoreModule from "../jobWorkStoreModule";
    import {forMatIndianDate} from "../../../@core/utils/utils";


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
            vSelect,
            BFormInvalidFeedback,
            BFormTextarea,
            BFormDatepicker,
            BButton,
            BOverlay,
            BTabs,
            BTab,
            Cleave,
            BInputGroup,
            BInputGroupAppend,
            BInputGroupPrepend,
            loginDetailsTab
        },
        directives: {
            Ripple,
        },
        setup() {
            const toast = useToast()

            const ITEMADDON_APP_STORE_MODULE_NAME = 'receipt-job-challan-store-module'
            if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, jobWorkStoreModule)
            onUnmounted(() => {
                if (store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.unregisterModule(ITEMADDON_APP_STORE_MODULE_NAME)
            })
            const showOverlayLoading = ref(false)

            const partyCodeOPtion = ref([])
            axios.get('/api/party/get-master-options').then(res => {
                partyCodeOPtion.value = res.data.data
            })

            const subContractorOptions = ref([])
            axios.get('/api/party/get-master-options').then(res => {
                subContractorOptions.value = res.data.data
            })

            const scrapCodeOption = ref([])
            axios.get('/api/get-item-master-options').then(res => {
                scrapCodeOption.value = res.data.data
            })

            const uomOption = ref([])
            axios.get('/api/get-uom-master-options').then(res => {
                uomOption.value = res.data.data
            })
            const makeOption = ref([]);
            axios.get('/api/get-item-make-master-options').then(res => {
                makeOption.value = res.data.data
            })
            const storeOption = ref([]);
            axios.get("/api/get-store-master-options").then((res) => {
                storeOption.value = res.data.data;
            });
            const dateFormat = ref({
                date: true,
                delimiter: '/',
                datePattern: ['d', 'm', 'Y'],
            })

            const formatDates = ref({
                challanDate: null,
                girDate: null,
                grnDate: null,
            })

            const getJobChallanFormateDate = (date) => {
                formData.value.challanDate = forMatIndianDate(date)
            }

            const getJobGirFormateDate = (date) => {
                formData.value.girDate = forMatIndianDate(date)
            }
            const getJobGrnFormateDate = (date) => {
                formData.value.grnDate = forMatIndianDate(date)
            }

            const CurrentUserData = ref(getUserData())

            const formData = ref({
                id: null,
                partyCode: null,
                partyName: null,
                itemCode: null,
                itemDescription: null,
                itemAddDescription: null,
                itemDetailDescription: null,
                itemDrawingNo: null,
                itemRevision: null,
                itemUom: null,
                subContractor: null,
                subContractorName: null,
                itemJobWorkNo: null,
                itemJobCardNo: null,
                itemWoNumber: null,
                challanNo: null,
                challanDate: null,
                girNo: null,
                girDate: null,
                itemMake: null,
                itemStore: null,
                receiptNote: null,
                jobQty: null,
                pendingJobQty: null,
                challanQty: null,
                grnNo: null,
                grnDate: null,
                expectedScrap: null,
                scrapReceived: null,
                scrapCode: null,
                scrapName: null,
                rate: null,
                loginDetails: {
                    createdBy: CurrentUserData.value.first_name + ' ' + CurrentUserData.value.last_name,
                    dateTime: moment(new Date()).format('DD/MM/YYYY HH:mm'),
                    lastModifiedBy: null,
                    modifiedDateTime: null,
                },
            })


            axios.get(`/api/new/receipt-job-work-challan/${router.currentRoute.params.id}`).then(res => {
                formData.value = res.data.data
                formData.value.id = res.data.data._id
                formData.value.loginDetails.lastModifiedBy = CurrentUserData.value.first_name + ' ' + CurrentUserData.value.last_name
                formData.value.loginDetails.modifiedDateTime = moment(new Date()).format('DD/MM/YYYY HH:mm')
                delete res.data.data._id
                showOverlayLoading.value = false
            })


            const resetFormData = () => {
                formData.value = JSON.parse(JSON.stringify(formData.value))
            }
            const saveFormData = async () => {
                await store.dispatch('receipt-job-challan-store-module/updateReceiptJobWorkChallan', formData.value).then(res => {
                    if (res.status === 200) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Receipt Job Work Challan Updated',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: `You have successfully Updated Receipt Job Work Challan.`,
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
                    router.push({name: 'receipt-job-work-challan'})
                })
            }
            const {refFormObserver, getValidationState, resetForm} = formValidation(resetFormData)
            return {
                formData,
                refFormObserver,
                getValidationState,
                resetForm,
                saveFormData,
                resetFormData,
                uomOption,
                makeOption,
                storeOption,
                required,
                showOverlayLoading,
                partyCodeOPtion,
                scrapCodeOption,
                dateFormat,
                formatDates,
                getJobChallanFormateDate,
                getJobGirFormateDate,
                getJobGrnFormateDate,
                subContractorOptions,
                CurrentUserData
            }
        }
    }
</script>
