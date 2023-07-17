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
                                >
                                    <v-select
                                        placeholder="Select Code"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="partyCodeOptions"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        input-id="partyCode"
                                        @input="getPartyDetail($event)"
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
    BButton,
    BFormInvalidFeedback,
    BTable
} from 'bootstrap-vue'
import BCardCode from '../../../@core/components/b-card-code/BCardCode'
import {ValidationObserver, ValidationProvider} from 'vee-validate'
import {required} from '@validations'
import formValidation from "@core/comp-functions/forms/form-validation";
import {onUnmounted, ref} from "@vue/composition-api";
import {getUserData} from "../../../auth/utils";
import vSelect from 'vue-select'
import axios from '@axios'
import router from '@/router'
import moment from "moment";
import {useToast} from "vue-toastification/composition";
import inventoryStoreModule from "../inventoryStoreModule";
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
import store from '@/store'

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
        BFormInvalidFeedback,
        vSelect,
        BButton,

        BTable
    },
    setup() {
        const toast = useToast()

        const ITEMADDON_APP_STORE_MODULE_NAME = 'inventory-store-module'
        if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, inventoryStoreModule)
        onUnmounted(() => {
            if (store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.unregisterModule(ITEMADDON_APP_STORE_MODULE_NAME)
        })

        const partyCodeOptions = ref([])
        axios.get('/api/new/get-pending-po-vendor-options').then((res) => {
            partyCodeOptions.value = res.data.data
        });

        const partyId = ref(null)
        const getPartyDetail = async (id) => {
            partyId.value = null
            await axios.get(`/api/purchase-order/${id}`).then((res) => {
                formData.value.partyName = res.data.data?.party_details?.partyName ?? null
                formData.value.partyCode = res.data.data?.party_details?.partyCode ?? null
                formData.value.partyId = res.data.data?.party_details?._id ?? null
            });
            partyId.value = id
        }

        const CurrentUserData = ref(getUserData())
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
                createdBy: CurrentUserData.value.first_name + ' ' + CurrentUserData.value.last_name,
                dateTime: moment(new Date()).format('DD/MM/YYYY HH:mm'),
                lastModifiedBy: CurrentUserData.value.first_name + ' ' + CurrentUserData.value.last_name,
                modifiedDateTime: moment(new Date()).format('DD/MM/YYYY HH:mm'),
                approvedBy: null,
                approveDate: null,
            },
        }
        const formData = ref(JSON.parse(JSON.stringify(blankFormData)))
        const resetFormData = () => {
            formData.value = JSON.parse(JSON.stringify(blankFormData))
        }

        const saveFormData = async () => {
            await store.dispatch('inventory-store-module/addGoodsReceiptNote', formData.value).then(res => {
                if (res.status === 200) {
                    toast({
                        component: ToastificationContent,
                        position: 'top-right',
                        props: {
                            title: 'Goods Receipt Note Added',
                            icon: 'CheckSquareIcon',
                            variant: 'success',
                            text: `You have successfully Added Goods Receipt Note.`,
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
                    name: 'edit-goods-receipt-note',
                    params: {
                        id: res.data.data._id
                    }
                })
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
            saveFormData,
            partyCodeOptions,
            getPartyDetail,

        }
    }
}

</script>
