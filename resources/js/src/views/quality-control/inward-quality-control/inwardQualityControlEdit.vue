<template>
    <div>
        <b-overlay
            :show="showOverlayLoading"
            rounded="sm"
        >
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
                                    >
                                        <v-select
                                            placeholder="Select Code"
                                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                            :options="partyCodeOptions"
                                            :reduce="val => val.value"
                                            :clearable="false"
                                            input-id="partyCode"
                                            disabled
                                            v-model="formData.goodNoteId"
                                            :state="getValidationState(validationContext)"
                                        />
                                    </b-form-group>
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors [0] }}
                                    </b-form-invalid-feedback>
                                </validation-provider>
                                <b-form-group
                                    label="GRN No."
                                    label-for="grnNo"
                                >
                                    <v-select
                                        placeholder="Select Code"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="grnNumberOptions"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        input-id="grnNo"
                                        v-model="formData.grnNo"
                                        disabled
                                    />
                                </b-form-group>

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
                                            disabled
                                        />
                                    </b-form-group>
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </validation-provider>
                                <b-form-group
                                    label="PO No."
                                    label-for="purchaseOrderNo"
                                >
                                    <v-select
                                        placeholder="Select Code"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="purchaseOrderNoOptions"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        input-id="purchaseOrderNo"
                                        v-model="formData.purchaseOrderNo"
                                        disabled
                                    />
                                </b-form-group>

                            </b-col>
<!--                            <b-col md="12">-->
<!--                                <hr>-->
<!--                                <b-button-->
<!--                                    variant="primary"-->
<!--                                    type="submit"-->
<!--                                    class="float-right"-->
<!--                                >-->
<!--                                    Update-->
<!--                                </b-button>-->
<!--                            </b-col>-->
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
                <b-tabs pills lazy>
                    <b-tab active>
                        <template #title>
                            <feather-icon
                                icon="FileIcon"
                                size="16"
                                class="mr-0 mr-sm-50"
                            />
                            <span class="d-none d-sm-inline">Item Details</span>
                        </template>
                        <hr>
                        <item-details-tab
                            :partyId="formData.partyId"
                            :goodNoteId="formData.goodNoteId"
                            :purchaseOrderId="formData.purchaseOrderId"
                        />
                    </b-tab>
                    <b-tab>
                        <template #title>
                            <feather-icon
                                icon="EditIcon"
                                size="16"
                                class="mr-0 mr-sm-50"
                            />
                            <span class="d-none d-sm-inline">Inspection Remark</span>
                        </template>
                        <hr>
                        <inspection-remark-tab
                            :remarkDetails="formData.remarkDetails"
                        />
                    </b-tab>
                    <b-tab>
                        <template #title>
                            <feather-icon
                                icon="LogInIcon"
                                size="16"
                                class="mr-0 mr-sm-50"
                            />
                            <span class="d-none d-sm-inline">Login</span>
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
    import {
        BForm,
        BRow,
        BCol,
        BFormGroup,
        BFormInput,
        BFormInvalidFeedback,
        BOverlay,
        BButton,
        BTabs,
        BTab
    } from 'bootstrap-vue'
    import BCardCode from "../../../@core/components/b-card-code/BCardCode";
    import {ValidationObserver, ValidationProvider} from 'vee-validate'
    import {ref,onUnmounted} from "@vue/composition-api";
    import axios from '@axios'
    import formValidation from "@core/comp-functions/forms/form-validation";
    import vSelect from 'vue-select'
    import itemDetailsTab from './tab/itemDetailsTab'
    import router from '@/router'
    import qualityControlStoreModule from "../qualityControlStoreModule";
    import {useToast} from "vue-toastification/composition";
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import store from '@/store'
    import inspectionRemarkTab from './tab/inspectionRemarkTab'
    import loginDetailsTab from './tab/loginDetailsTab'
    import moment from 'moment'
    import {getUserData} from "../../../auth/utils";
    import {getTcTodayDateTime} from "@core/utils/utils";

    export default {
        components: {
            BCardCode,
            ValidationProvider,
            ValidationObserver,
            BForm,
            BRow,
            BCol,
            BFormGroup,
            BFormInput,
            BFormInvalidFeedback,
            BOverlay,
            vSelect,
            BButton,
            BTabs,
            BTab,
            itemDetailsTab,
            inspectionRemarkTab,
            loginDetailsTab,
        },
        setup() {
            const toast = useToast()

            const ITEMADDON_APP_STORE_MODULE_NAME = 'quality-control-store-module'
            if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, qualityControlStoreModule)
            onUnmounted(() => {
                if (store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.unregisterModule(ITEMADDON_APP_STORE_MODULE_NAME)
            })

            const showOverlayLoading = ref(false)

            const partyCodeOptions = ref([])
            axios.get('/api/new/get-grn-item-options').then((res) => {
                partyCodeOptions.value = res.data.data
            })
            const grnNumberOptions = ref([])
            axios.get('/api/new/get-all-grn-item-options').then((res) => {
                grnNumberOptions.value = res.data.data
            })

            const purchaseOrderNoOptions = ref([])
            axios.get('/api/new/get-all-grn-po-number-options').then((res) => {
                purchaseOrderNoOptions.value = res.data.data
            })

            const currentUserData = ref(getUserData())

            const blankFormData = {
                goodNoteId:null,
                purchaseOrderId:null,
                partyId:null,
                partyCode: null,
                partyName: null,
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

            const refetchData = async () => {
                showOverlayLoading.value = true
                await axios.get(`/api/new/inward-quality-control/${router.currentRoute.params.id}`).then((res) => {
                    formData.value = res.data.data
                })
                showOverlayLoading.value = false
            }
            refetchData()

            const saveFormData = async () => {
                formData.value.loginDetails.lastModifiedBy = currentUserData.value.first_name + ' ' + currentUserData.value.last_name
                formData.value.loginDetails.modifiedDateTime = getTcTodayDateTime()
                await store.dispatch('quality-control-store-module/updateInwardQualityControl', formData.value).then(res => {
                    if (res.status === 200) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Inward Quality Control Updated',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: 'You have successfully Updated inward quality Control',
                            },
                        })
                    } else {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Something went wrong',
                                icon: 'AlertCircleIcon',
                                variant: 'danger',
                                text: 'Something went wrong',
                            },
                        })
                    }
                })
            }

            const {refFormObserver, resetForm, getValidationState} = formValidation(resetFormData)

            return {
                formData,
                refFormObserver,
                resetForm,
                getValidationState,
                showOverlayLoading,
                saveFormData,
                partyCodeOptions,
                resetFormData,
                refetchData,
                currentUserData,
                grnNumberOptions,
                purchaseOrderNoOptions
            }
        }
    }
</script>
