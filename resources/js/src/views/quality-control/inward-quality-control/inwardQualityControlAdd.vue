<template>
    <div>
        <b-card-code>
            <validation-observer #default="{handleSubmit}">
                <b-form @submit.prevent="handleSubmit(saveFormData)">
                    <b-row>
                        <b-col md="6">
                            <validation-provider
                                #default="validationContext"
                                name="Party Code"
                                rules="required"
                            >
                                <b-form-group
                                    label="Party Code"
                                    label-for="partyCode"
                                    :state="getValidationState(validationContext)"
                                >
                                    <v-select
                                        placeholder="Select Code"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="partyCodeOptions"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        input-id="partyCode"
                                        @input="getPartyDetail($event)"
                                        v-model="formData.goodNoteId"
                                        :state="getValidationState(validationContext)"
                                    />
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors [0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                            <validation-provider
                                #default="validationContext"
                                name="GRN No."
                                rules="required"
                            >
                                <b-form-group
                                    label="GRN No."
                                    label-for="grnNo"
                                    :state="getValidationState(validationContext)"
                                >
                                    <v-select
                                        placeholder="Select Code"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="grnNumberOptions"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        input-id="grnNo"
                                        @input="geGrnDataDetail($event)"
                                        v-model="formData.grnNo"
                                        :state="getValidationState(validationContext)"
                                    />
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors [0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
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
                                        :state="getValidationState(validationContext)"
                                        v-model="formData.partyName"
                                    />
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                            <validation-provider
                                #default="validationContext"
                                name="PO No."
                                rules="required"
                            >
                                <b-form-group
                                    label="PO No."
                                    label-for="purchaseOrderNo"
                                    :state="getValidationState(validationContext)"
                                >
                                    <v-select
                                        placeholder="Select Code"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="purchaseOrderNoOptions"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        @input="geGrnPoDataDetail($event)"
                                        input-id="purchaseOrderNo"
                                        v-model="formData.purchaseOrderNo"
                                        :state="getValidationState(validationContext)"
                                    />
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors [0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                        </b-col>
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
    </div>
</template>
<script>
    import {
        BForm,
        BRow,
        BCol,
        BFormInput,
        BFormGroup,
        BFormInvalidFeedback,
        BButton
    } from 'bootstrap-vue'
    import BCardCode from '@core/components/b-card-code'
    import {ValidationObserver, ValidationProvider} from 'vee-validate'
    import {onUnmounted, ref} from "@vue/composition-api";
    import axios from '@axios'
    import formValidation from "@core/comp-functions/forms/form-validation";
    import vSelect from 'vue-select'
    import {useToast} from "vue-toastification/composition";
    import qualityControlStoreModule from "../qualityControlStoreModule";
    import store from '@/store'
    import {required} from '@validations'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import router from '@/router'
    import moment from 'moment'
    import {getUserData} from "../../../auth/utils";

    export default {
        components: {
            BCardCode,
            BForm,
            BRow,
            BCol,
            BFormGroup,
            BFormInput,
            BButton,
            BFormInvalidFeedback,
            ValidationObserver,
            ValidationProvider,
            vSelect
        },

        setup() {
            const toast = useToast()

            const ITEMADDON_APP_STORE_MODULE_NAME = 'quality-control-store-module'
            if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, qualityControlStoreModule)
            onUnmounted(() => {
                if (store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.unregisterModule(ITEMADDON_APP_STORE_MODULE_NAME)
            })

            const partyCodeOptions = ref([])
            axios.get('/api/new/get-good-receipt-note-item-options').then((res) => {
                partyCodeOptions.value = res.data.data
            })

            const grnNumberOptions = ref([])
            /* axios.get('/api/new/get-grn-number-options').then((res) => {
                grnNumberOptions.value = res.data.data
            }) */
            axios.get('/api/new/get-grn-number-item-wise-options').then((res) => {
                grnNumberOptions.value = res.data.data
            })

            const purchaseOrderNoOptions = ref([])
            axios.get('/api/new/get-grn-po-number-options').then((res) => {
                purchaseOrderNoOptions.value = res.data.data
            })

            const partyId = ref(null)
            const getPartyDetail = async (id) => {
                partyId.value = null
                await axios.get(`/api/new/goods-receipt-note/${id}`).then((res) => {
                    formData.value.partyName = res.data.data?.partyName ?? null
                    formData.value.partyCode = res.data.data?.partyCode ?? null
                    formData.value.partyId = res.data.data?.partyId ?? null
                    formData.value.purchaseOrderId = res.data.data?.purchaseOrderId ?? null
                    formData.value.grnNo = res.data.data?.grn_Details?.grnNo ?? null
                    formData.value.purchaseOrderNo = res.data.data?.grn_Details?.poNo ?? null
                });
                partyId.value = partyId
            }

            const geGrnDataDetail = async (id) => {
                await axios.get(`/api/new/goods-receipt-note/${id}`).then((res) => {
                    formData.value.partyId = res.data.data?.partyId ?? null
                    formData.value.partyCode = res.data.data?.partyCode ?? null
                    formData.value.partyName = res.data.data?.partyName ?? null
                    formData.value.goodNoteId = res.data.data?._id ?? null
                    formData.value.purchaseOrderNo = res.data.data?.purchaseOrderId ?? null
                });
            }

            const geGrnPoDataDetail = async (id) => {
                await axios.get(`/api/new/goods-receipt-note-item/${id}`).then((res) => {
                    formData.value.partyName = res.data.data?.party_detail?.partyName ?? null
                    formData.value.goodNoteId = res.data.data?.goodNoteId ?? null
                    formData.value.grnNo = res.data.data?.grnNo ?? null
                });
            }

            const blankFormData  = {
                goodNoteId:null,
                purchaseOrderId:null,
                partyId:null,
                partyCode: null,
                partyName: null,
                grnNo:null,
                purchaseOrderNo:null,
                remarkDetails:{
                    remark:null,
                },
                loginDetails: {
                    createdBy: getUserData().first_name + ' ' + getUserData().last_name,
                    dateTime: moment(new Date()).format('DD/MM/YYYY HH:mm'),
                    lastModifiedBy: null,
                    modifiedDateTime: null,
                },
            }
            const formData = ref(JSON.parse(JSON.stringify(blankFormData)))
            const resetFormData = () => {
                formData.value = JSON.parse(JSON.stringify(blankFormData))
            }
            const saveFormData = async () => {
                await store.dispatch('quality-control-store-module/addInwardQualityControl', formData.value).then(res => {
                    if (res.status === 200) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Inward Quality Control Added',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: `You have successfully Added Inward Quality Control.`,
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
                    router.push({
                        name: 'edit-inward-quality-control',
                        params: {
                            id: res.data.data._id
                        }
                    })
                })
            }

            const {
                refFormObserver,
                resetForm,
                getValidationState
            } = formValidation(resetFormData)

            return {
                formData,
                refFormObserver,
                resetForm,
                getValidationState,
                resetFormData,
                partyCodeOptions,
                getPartyDetail,
                saveFormData,
                required,
                grnNumberOptions,
                purchaseOrderNoOptions,
                geGrnDataDetail,
                geGrnPoDataDetail
            }
        }
    }

</script>
