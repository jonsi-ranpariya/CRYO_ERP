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
                                            v-model="formData.purchaseOrderId"
                                            :state="getValidationState(validationContext)"
                                        />
                                    </b-form-group>
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors [0] }}
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
                                            :state="getValidationState(validationContext)"
                                            v-model="formData.partyName"
                                        />
                                    </b-form-group>
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </validation-provider>
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

        <!--tabs-->
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
                        />
                    </b-tab>
                    <b-tab>
                        <template #title>
                            <feather-icon
                                icon="UsersIcon"
                                size="16"
                                class="mr-0 mr-sm-50"
                            />
                            <span class="d-none d-sm-inline">Remark</span>
                        </template>
                        <hr>
                        <remark-details-tab
                            :remarkDetails="formData.remarkDetails"
                        />
                    </b-tab>
                    <b-tab>
                        <template #title>
                            <feather-icon
                                icon="UsersIcon"
                                size="16"
                                class="mr-0 mr-sm-50"
                            />
                            <span class="d-none d-sm-inline">Login Details</span>
                        </template>
                        <hr>
                        <login-details-tab
                            :login-data="formData.loginDetails"
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
    BFormInput,
    BFormGroup,
    BButton,
    BFormInvalidFeedback,
    BTab,
    BTabs,
    BOverlay,
} from 'bootstrap-vue'
import BCardCode from '../../../@core/components/b-card-code/BCardCode'
import {ValidationObserver, ValidationProvider} from 'vee-validate'
import {required} from '@validations'
import formValidation from "@core/comp-functions/forms/form-validation";
import {onUnmounted, ref} from "@vue/composition-api";
import vSelect from 'vue-select'
import axios from '@axios'
import remarkDetailsTab from './tabs/remarkDetailsTab'
import loginDetailsTab from './tabs/loginDetailsTab'
import router from "@/router";
import {useToast} from "vue-toastification/composition";
import inventoryStoreModule from "../inventoryStoreModule";
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
import store from '@/store'
import itemDetailsTab from './tabs/itemsDetailsTab'

export default {
    components: {
        BCardCode,
        ValidationProvider,
        ValidationObserver,
        BForm,
        BRow,
        BCol,
        BFormInput,
        BFormGroup,
        BButton,
        BFormInvalidFeedback,
        vSelect,
        BTab,
        BTabs,
        BOverlay,
        remarkDetailsTab,
        loginDetailsTab,
        itemDetailsTab
    },
    setup() {
        const toast = useToast()

        const ITEMADDON_APP_STORE_MODULE_NAME = 'inventory-store-module'
        if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, inventoryStoreModule)
        onUnmounted(() => {
            if (store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.unregisterModule(ITEMADDON_APP_STORE_MODULE_NAME)
        })

        const showOverlayLoading = ref(false)

        const partyCodeOptions = ref([]);
        axios.get('/api/new/get-purchase-order-vendor-options').then((res) => {
            partyCodeOptions.value = res.data.data;
        });

        const blankFormData = {
            purchaseOrderId: null,
            partyId: null,
            partyCode: null,
            partyName: null,
            remarkDetails: {
                remark: null,
                transporterVehicleNo: null,
            },
            loginDetails: {
                createdBy: null,
                dateTime: null,
                lastModifiedBy: null,
                modifiedDateTime: null,
                approvedBy: null,
                approveDate: null,
            },
        }
        const formData = ref(JSON.parse(JSON.stringify(blankFormData)))
        const resetFormData = () => {
            formData.value = JSON.parse(JSON.stringify(blankFormData))
        }

        const refetchData = async () => {
            showOverlayLoading.value = true
            await axios.get(`/api/new/goods-receipt-note/${router.currentRoute.params.id}`).then((res) => {
                formData.value = res.data.data
            })
            showOverlayLoading.value = false
        }
        refetchData()


        const saveFormData = async () => {
            await store.dispatch('inventory-store-module/updateGoodsReceiptNote', formData.value).then(res => {
                if (res.status === 200) {
                    toast({
                        component: ToastificationContent,
                        position: 'top-right',
                        props: {
                            title: 'Goods Receipt Note Updated',
                            icon: 'CheckSquareIcon',
                            variant: 'success',
                            text: 'You have successfully Updated Goods Receipt Note',
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
                router.push({name: 'goods-receipt-note'})
            })
        }
        const {refFormObserver, resetForm, getValidationState} = formValidation(resetFormData)
        return {
            required,
            refFormObserver,
            resetForm,
            resetFormData,
            getValidationState,
            formData,
            showOverlayLoading,
            refetchData,
            saveFormData,
            partyCodeOptions,
        }
    }
}

</script>
