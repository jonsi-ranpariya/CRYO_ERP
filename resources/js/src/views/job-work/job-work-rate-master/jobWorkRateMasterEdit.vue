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
                                <b-form-group
                                    label="Alice"
                                    label-for="itemAlice"
                                >
                                    <b-form-input
                                        v-model="formData.itemAlice"
                                        id="itemAlice"
                                    />
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
                        </b-col>
                        <b-col md="6">
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
                            <b-form-group
                                label="CFactor"
                                label-for="cFactor"
                            >
                                <b-form-input
                                    id="cFactor"
                                    v-model="formData.cFactor"
                                />
                            </b-form-group>
                            <b-form-group
                                label="Conv. UOM"
                                label-for="convUom"
                            >
                                <v-select
                                    id="convUom"
                                    v-model="formData.convUom"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="uomOptions"
                                    :clearable="false"
                                    :reduce="val => val.value"
                                />
                            </b-form-group>
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
        <b-overlay
            :show="showOverlayLoading"
            rounded="sm"
        >
            <b-card-code>
                <b-tabs pills>
                    <b-tab active>
                        <template #title>
                            <feather-icon
                                icon="UserIcon"
                                size="16"
                                class="mr-0 mr-sm-50"
                            />
                            <span class="d-none d-sm-inline">Process</span>
                        </template>
                        <hr>
                        <process-details-tab
                        />
                    </b-tab>
                    <b-tab>
                        <template #title>
                            <feather-icon
                                icon="UserIcon"
                                size="16"
                                class="mr-0 mr-sm-50"
                            />
                            <span class="d-none d-sm-inline">Terms & Condition</span>
                        </template>
                        <hr>
                        <terms-and-condition-tab
                        />
                    </b-tab>
                    <b-tab>
                        <template #title>
                            <feather-icon
                                icon="UserIcon"
                                size="16"
                                class="mr-0 mr-sm-50"
                            />
                            <span class="d-none d-sm-inline">Sub-Contractor</span>
                        </template>
                        <hr>
                        <sub-contractor-tab
                            :subContractorDetails="formData.subContractorDetails"
                        />
                    </b-tab>
                </b-tabs>
            </b-card-code>
        </b-overlay>
    </div>
</template>
<script>
    import {
        BForm,
        BRow,
        BCol,
        BFormGroup,
        BFormInput,
        BFormInvalidFeedback,
        BButton,
        BFormTextarea,
        BTabs,
        BTab,
        BOverlay
    } from 'bootstrap-vue'
    import BCardCode from "../../../@core/components/b-card-code/BCardCode";
    import formValidation from "../../../@core/comp-functions/forms/form-validation";
    import {onUnmounted, ref} from "@vue/composition-api"
    import {ValidationObserver, ValidationProvider} from 'vee-validate'
    import {required} from "@validations"
    import vSelect from 'vue-select'
    import axios from '@axios'
    import router from '@/router'
    import processDetailsTab from "./tabs/processDetailTab"
    import termsAndConditionTab from "./tabs/termsAndConditionTab"
    import subContractorTab from "./tabs/subContractorTab"
    import {useToast} from "vue-toastification/composition";
    import jobWorkStoreModule from "../jobWorkStoreModule";
    import store from '@/store'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'

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
            BFormInvalidFeedback,
            BButton,
            vSelect,
            BFormTextarea,
            BTabs,
            BTab,
            BOverlay,
            processDetailsTab,
            termsAndConditionTab,
            subContractorTab
        },
        setup() {
            const toast = useToast()

            const ITEMADDON_APP_STORE_MODULE_NAME = 'job-work-rate-master-store-module'
            if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, jobWorkStoreModule)
            onUnmounted(() => {
                if (store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.unregisterModule(ITEMADDON_APP_STORE_MODULE_NAME)
            })

            const showOverlayLoading = ref(false)

            const uomOptions = ref([])
            axios.get('/api/get-uom-master-options').then(res => {
                uomOptions.value = res.data.data
            })
            const uomOption = ref([])
            axios.get('/api/get-uom-master-options').then(res => {
                uomOption.value = res.data.data
            })

            const BlankFormData = {
                itemCode: null,
                itemDescription: null,
                itemAlice: null,
                itemAddDescription: null,
                itemDetailDescription: null,
                itemDrawingNo: null,
                itemRevision: null,
                itemUom: null,
                cFactor: null,
                convUom: null,
                subContractorDetails:{
                    subContractorId: null,
                    subContractorCode: null,
                    subContractorName: null,
                    contractorAddress: null,
                    contractorCountry: null,
                    contractorState: null,
                    contractorCity: null,
                    contractorFaxNo: null,
                    ContractorEmailId: null,
                    contractorWebsite: null,
                    contractorPinCode: null,
                    contraPhoneCountry: '+91',
                    contraPhoneNo: null,
                }
            }

            const refetchData = async () =>{
                showOverlayLoading.value = true
                    await axios.get(`/api/new/job-work-rate-master/${router.currentRoute.params.id}`).then(res =>{
                        formData.value = res.data.data
                    })
                showOverlayLoading.value = false
            }
            refetchData()

            const formData = ref(JSON.parse(JSON.stringify(BlankFormData)))
            const resetFormData = async () => {
                formData.value = JSON.parse(JSON.stringify(BlankFormData))
            }
            const saveFormData = async () => {
                await store.dispatch('job-work-rate-master-store-module/updateJobWorkRateMaster', formData.value).then(res => {
                    if (res.status === 200) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Job Work Rate Master Updated',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: `You have successfully Updated Job Work Rate Master.`,
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
                })
            }
            const {refFormObserver, getValidationState, resetForm} = formValidation(resetFormData)
            return {
                refFormObserver,
                resetForm,
                resetFormData,
                getValidationState,
                formData,
                required,
                uomOption,
                uomOptions,
                saveFormData,
                showOverlayLoading
            }

        }
    }
</script>
